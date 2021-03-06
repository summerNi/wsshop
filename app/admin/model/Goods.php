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
        $status = [0=>'下架',1=>'正常'];
        return $status[$data['status']];
    }


    /**/
    public function add($d){
        $data = [
            'name' => $d['name'],
            'description' => $d['description'],
            'price' => $d['price'],
            'pic' => $d['pic'],
            'sub_name' => $d['sub_name'],
            'create_time' => time(),
            'status' => $d['status'],
            'market_price' => $d['market_price'],
        ];
        db('goods')->insert($data);
        $id =  db('goods')->getLastInsID();
        return $id;
    }

}
