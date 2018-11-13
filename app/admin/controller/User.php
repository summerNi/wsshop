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
class User extends Permissions
{
    public function index()
    {
      $post = $this->request->param();
      $where = [];
      if (isset($post['keywords']) and !empty($post['keywords'])) {
          $where['wechat_name|true_name'] = ['like', '%' . $post['keywords'] . '%'];
      }
      if (isset($post['create_time']) and !empty($post['create_time'])) {
          $min_time = strtotime($post['create_time']);
          $max_time = $min_time + 24 * 60 * 60;
          $where['create_time'] = [['>=',$min_time],['<=',$max_time]];
      }
      $list = model('user')->where($where)->paginate(20);
      $this->assign('list', $list);
      return $this->fetch();
    }



}
