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


namespace app\admin\controller;


use app\admin\controller\Permissions;

class Goods extends Permissions
{
    public function index()
    {
        $list = model('goods')->with('goodscate')->select();
        $this->assign('list', $list);
        return $this->fetch();
    }

    /*添加商品*/
    public function add()
    {
        if ($this->request->isPost()) {//添加数据
          $post = $this->request->post();
    			//验证  唯一规则： 表名，字段名，排除主键值，主键名
          $validate = new \think\Validate([
              ['name', 'require', '商品名称不能为空'],
              ['cate_id', 'require', '请选择分类'],
                ['price', 'require', '价格不能为空'],
          ]);
          //验证部分数据合法性
          if (!$validate->check($post)) {
              $this->error('提交失败：' . $validate->getError());
          }
          $model = model('goods');
          $result = $model->add($post);
          if($result){
              return $this->success('添加成功','admin/goods/index');
          }else{
              return $this->error('修改失败');
          }
        } else {
            $model = model('GoodsCate');
            $cate = $model->select();
            $cates = $model->catelist($cate);
            $this->assign('cates', $cates);
            return $this->fetch();
        }
    }

    //创建规格
    public function createAttr(){
      if ($this->request->isPost()) {//添加数据
          $d = $this->request->post();
          $attr = [];
          foreach($d['attr_list'] as $k => $v){
              $attr[$v] = $d['value_list'][$k];
          }
          asort($attr);
          foreach($attr as $k => $v){
              $attr[$k] = array_unique(array_filter(explode('|',$v)));
          }
          $rs = ['spec'=>$attr];
          sort($attr);
          $rs['arr'] = $this->toArr($attr);
          echo json_encode($rs);
      }
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
    //删除
    public function delete()
    {
    	if($this->request->isAjax()) {
    		$id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
        $result = Db::name('goods')->where('id',$id)->delete();
        if($result){//删除规格商品
          Db::name('goods_attr')->where('goods_id',$id)->delete();
          return $this->success('删除成功','admin/goods/index');
        }else{
          return $this->error('删除失败');
        }
    	}
    }
}
