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
use think\Db;
class Slide extends Permissions
{
    public function index()
    {
        $post = $this->request->param();
        $where = [];
        if (isset($post['keywords']) and !empty($post['keywords'])) {
            $where['title'] = ['like', '%' . $post['keywords'] . '%'];
        }
        if (isset($post['create_time']) and !empty($post['create_time'])) {
            $min_time = strtotime($post['create_time']);
            $max_time = $min_time + 24 * 60 * 60;
            $where['create_time'] = [['>=',$min_time],['<=',$max_time]];
        }
        $list = model('slide')->where($where)->paginate(20);
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
              ['title', 'require', '幻灯名称不能为空'],
                ['img', 'require', '图片不能为空'],
          ]);
            //验证部分数据合法性
            if (!$validate->check($post)) {
                $this->error('提交失败：' . $validate->getError());
            }
            $model = model('slide');
            $result = $model->add($post);
            if ($result) {
                return $this->success('添加成功', 'admin/slide/index');
            } else {
                return $this->error('添加失败');
            }
        } else {
            return $this->fetch();
        }
    }

    /*添加商品*/
    public function edit()
    {
        $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
        $model = model('slide');
        if ($this->request->isPost()) {//添加数据
            $post = $this->request->post();
            //验证  唯一规则： 表名，字段名，排除主键值，主键名
            $validate = new \think\Validate([
              ['title', 'require', '幻灯名称不能为空'],
                ['img', 'require', '图片不能为空'],
          ]);
            //验证部分数据合法性
            if (!$validate->check($post)) {
                $this->error('提交失败：' . $validate->getError());
            }

            $result = $model->save($post);
            if ($result) {
                return $this->success('修改成功', 'admin/slide/index');
            } else {
                return $this->error('修改失败');
            }
        } else {
            $slide = $model->where('id',$id)->find();
            $slide = $slide->getData();//获取所有原始数据
            if(!empty($slide)) {
      				$this->assign('slide',$slide);
      				return $this->fetch();
      			} else {
      				return $this->error('id不正确');
      			}
        }
    }


    //删除
    public function delete()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
            $result = Db::name('slide')->where('id', $id)->delete();
            if ($result) {//删除规格商品
                return $this->success('删除成功', 'admin/slide/index');
            } else {
                return $this->error('删除失败');
            }
        }
    }
}
