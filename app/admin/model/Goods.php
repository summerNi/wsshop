<?php
// +----------------------------------------------------------------------
// | Tplay [ WE ONLY DO WHAT IS NECESSARY ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://tplay.pengyichen.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 听雨 < 389625819@qq.com >
// +----------------------------------------------------------------------


namespace app\admin\model;

use \think\Model;
use \think\Db;
class Goods extends Model
{
    public function getStatusAttr($value, $data)
    {
        $status = [0=>'正常',1=>'下架'];
        return $status[$data['status']];
    }

    public function goodscate()
    {
        //关联分类表
        return $this->belongsTo('GoodsCate','cate_id');
    }

    /**/
    public function add($d){
        $spec = htmlspecialchars_decode($d['goods_attr']);
        $spec = json_decode($spec,true);

        if(!$spec){
            $spec = ['规格'=>[$d['name']]];
        }
        $spec_temp = $spec;
        asort($spec);
        $spec = json_encode($spec,JSON_UNESCAPED_UNICODE );
        $data = [
            'name' => $d['name'],
            'description' => $d['description'],
            'price' => $d['price'],
            'pic' => $d['pic'],
            'sub_name' => $d['sub_name'],
            'goods_attr' => htmlspecialchars($spec),
            'create_time' => time(),
            'cate_id' => $d['cate_id'],
            'status' => $d['status'],
            'market_price' => $d['market_price'],
            'stock' => $d['stock'],
            'is_discount' => $d['is_discount'],
        ];

        //自动事务处理
        Db::startTrans();
        try{
            db('goods')->insert($data);
            $id =  db('goods')->getLastInsID();
            $attr = $spec_temp;
            foreach ($attr as $k => $v) {
                $attr[$k] = implode('|', $v);
            }
            $temp = $this->createAttr($attr);
            $arr = $temp['arr'];
            $goods_attr = [];
            foreach ($arr as $title) {
                $stock = isset($d[$title . '_stock'][0]) ? (int)$d[$title . '_stock'][0] : 100;
                $price = $d['price'];
                $tmp = [
                    'goods_id' => $id,
                    'attr_name' => $title,
                    'attr_price' => $stock,
                    'attr_stock' => $price,
                ];
                $goods_attr[] = $tmp;
            }
            db('goods_attr')->insertAll($goods_attr);
            // 提交事务
            Db::commit();
            return true;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return false;
        }
    }

    //创建规格
    public function createAttr($attr){
      asort($attr);
      foreach($attr as $k => $v){
          $attr[$k] = array_unique(array_filter(explode('|',$v)));
      }
      $rs = ['spec'=>$attr];
      sort($attr);
      $rs['arr'] = $this->toArr($attr);
      return $rs;
    }

    /**
     * 递归将属性变为数组
     * @param  [type] $attr [description]
     * @return [type]       [description]
     */
    public function toArr($attr){
        if(count($attr)<2){
            return isset($attr[0]) ? $attr[0] : [];
        }else{
            $one = $attr[0];
            $two = $attr[1];
            $temp = [];
            foreach($one as $v){
                foreach($two as $val){
                    $temp[] = $v.'_'.$val;
                }
            }
            //重新组成数组
            unset($attr[0]);
            unset($attr[1]);
            $new = [$temp];
            foreach($attr as $v){
                $new[] = $v;
            }
            return $this->toArr($new);
        }
    }
}
