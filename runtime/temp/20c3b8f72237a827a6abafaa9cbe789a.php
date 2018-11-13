<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:60:"D:\wamp64\www\coffee\public/../app/admin\view\goods\add.html";i:1540377919;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>layui</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="/static/public/layui/css/layui.css"  media="all">
  <link rel="stylesheet" href="/static/public/font-awesome/css/font-awesome.min.css" media="all" />
  <link rel="stylesheet" href="/static/admin/css/admin.css"  media="all">
</head>
<body style="padding:10px;">
  <div class="tplay-body-div">
    <div style="margin-top: 20px;">
    </div>
    <form class="layui-form" id="admin">

      <div class="layui-form-item">
        <label class="layui-form-label">商品名称</label>
        <div class="layui-input-inline">
          <input name="name" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text" >
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">商品副名称</label>
        <div class="layui-input-inline">
          <input name="sub_name" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text" >
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">分类</label>
        <div class="layui-input-inline">
          <select name="cate_id" lay-filter="aihao">
            <?php if(is_array($cates) || $cates instanceof \think\Collection || $cates instanceof \think\Paginator): $i = 0; $__LIST__ = $cates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo['id']; ?>" <?php if(!(empty($cate['pid']) || (($cate['pid'] instanceof \think\Collection || $cate['pid'] instanceof \think\Paginator ) && $cate['pid']->isEmpty()))): if($cate['pid'] == $vo['id']): ?> selected=""<?php endif; else: if(!(empty($pid) || (($pid instanceof \think\Collection || $pid instanceof \think\Paginator ) && $pid->isEmpty()))): if($pid == $vo['id']): ?> selected=""<?php endif; endif; endif; ?>><?php echo $vo['str']; ?><?php echo $vo['name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">价格</label>
        <div class="layui-input-inline">
          <input name="price" lay-verify="required" placeholder="请输入价格" autocomplete="off" class="layui-input" type="text" >
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">原价</label>
        <div class="layui-input-inline">
          <input name="market_price"  placeholder="请输入原价" autocomplete="off" class="layui-input" type="text" >
          <span>非打折商品可不填</span>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">库存</label>
        <div class="layui-input-inline">
          <input name="stock" lay-verify="required" placeholder="请输入库存" autocomplete="off" class="layui-input" type="text" >
        </div>
      </div>

      <div class="layui-upload" id="upload-thumb">
        <label class="layui-form-label">封面图</label>
        <button type="button" class="layui-btn" id="thumb">上传封面图</button>
        <div class="layui-upload-list">
          <label class="layui-form-label"></label>
          <img class="layui-upload-img" id="demo1" width="150" height="150" >
          <p id="demoText"></p>
        </div>
      </div>

      <div class="layui-form-item" id="attr_input">
        <input type="hidden" value='' id="goods_attr" name="goods_attr"/>
        <label class="layui-form-label">规格名称</label>
        <div class="layui-input-inline">
          <input name="goods_attr_name[]"  placeholder="请输入规格名称"  class="layui-input" type="text">
        </div>
        <label class="layui-form-label">规格值</label>
        <div class="layui-input-inline">
          <input name="goods_attr_value[]"  placeholder="请输入规格值,多个用|隔开"  class="layui-input" type="text">
        </div>
        <button type="button" class="layui-btn" onclick="addAttr()">添加规格</button>
        <button type="button" class="layui-btn" onclick="createAttr()">生成规格商品</button>
      </div>

      <div class="layui-form-item layui-form-text" id="attr_view" style="display:none">

      </div>


      <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">商品详情</label>
        <div class="layui-input-block" style="max-width:800px;">
          <textarea placeholder="请输入内容" class="layui-textarea" name="description" id="container" style="border:0;padding:0"></textarea>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
          <input type="radio" name="status" value="1" title="上架" checked=""><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><div>上架</div></div>
          <input type="radio" name="status" value="0" title="下架" ><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><div>下架</div></div>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">商品类型</label>
        <div class="layui-input-block">
          <input type="radio" name="is_discount" value="0" title="原价商品" checked=""><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><div>原价商品</div></div>
          <input type="radio" name="is_discount" value="1" title="打折商品"><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><div>打折商品</div></div>

        </div>

      </div>
      <div class="layui-form-item">
        <div class="layui-input-block">
          <button class="layui-btn" lay-submit lay-filter="admin">立即提交</button>
          <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
      </div>

    </form>
    <script>
          /**添加规格**/
          function addAttr(){
              var html = "<div class='layui-form-item' >";
              html+= "<label class='layui-form-label'>规格名称</label>";
              html+= "<div class='layui-input-inline'>";
              html+= "<input name='goods_attr_name[]'  placeholder='请输入规格名称'  class='layui-input' type='text'></div>";
              html+= "<label class='layui-form-label'>规格值</label>";
              html+= "<div class='layui-input-inline'>";
              html+= "<input name='goods_attr_value[]'  placeholder='请输入规格值,多个用|隔开'  class='layui-input' type='text'></div></div'";
              $("#attr_input").after(html);
          }

          /**创建规格商品**/
          function createAttr(){
              $("#attr_view").show();
              var attr_name = $(":input[name='goods_attr_name[]']");
              var attr_arr = [];
              for(var i=0;i<attr_name.length;i++){
                attr_arr[i]=$(attr_name[i]).val();//获取value值
              }
              var attr_value = $(":input[name='goods_attr_value[]']");
              var attr_value_arr = [];
              for(var i=0;i<attr_value.length;i++){
                attr_value_arr[i]=$(attr_value[i]).val();//获取value值
              }
              $.ajax({
                 url: "<?php echo url('goods/createAttr'); ?>",
                 method: 'post',
                 dataType: 'json',
                 data: {attr_list: attr_arr, value_list: attr_value_arr},
                 success: function (rs) {
                     data = { //数据
                         "title": "规格预览"
                         , "attr_list": rs.spec
                         , "attr_value_list": rs.arr
                     };
                     $("#goods_attr").val(JSON.stringify(rs.spec));
                     layui.use('laytpl', function () {
                         var laytpl = layui.laytpl;
                         var getTpl = attr_script.innerHTML, view = document.getElementById('attr_view');
                         laytpl(getTpl).render(data, function (html) {
                             view.innerHTML = html;
                         });
                     });
                 }
             });

          }
    </script>
    <script type="text/html" id="attr_script">
      <table class="layui-table">
          <thead>
          <tr>
              {{#  layui.each(d.attr_list, function(index, item){ }}
              <th>{{ index }}</th>
              {{#  }); }}
              <th>库存</th>
              <th>价格</th>
          </tr>
          </thead>
          <tbody>
          {{#  layui.each(d.attr_value_list, function(index, item){ }}
          <tr>
              {{# var arr = item.split('_');}}
              {{# layui.each(arr, function(i, e){ }}
              <td>{{ e }}</td>
              {{#  }); }}
              <td><input type="text" style='width: 100px'  class='layui-input' name="{{ item }}_stock[]" value="100"/></td>
              <td><input type="text" style='width: 100px'  class='layui-input' name="{{ item }}_price[]" value="100"/></td>
          </tr>
          {{#  }); }}
          </tbody>
      </table>
  </script>

    <script src="/static/public/layui/layui.js"></script>
    <script src="/static/public/jquery/jquery.min.js"></script>
    <!-- <script>
        var message;
        layui.config({
            base: '/static/admin/js/',
            version: '1.0.1'
        }).use(['app', 'message'], function() {
            var app = layui.app,
                $ = layui.jquery,
                layer = layui.layer;
            //将message设置为全局以便子页面调用
            message = layui.message;
            //主入口
            app.set({
                type: 'iframe'
            }).init();
        });
    </script> -->
    <script>
    layui.use('upload', function(){
      var upload = layui.upload;
      //执行实例
      var uploadInst = upload.render({
        elem: '#thumb' //绑定元素
        ,url: "<?php echo url('common/goodsImgUpload'); ?>" //上传接口
        ,done: function(res){
          //上传完毕回调
          if(res.code == 2) {
            $('#demo1').attr('src',res.src);
            $('#upload-thumb').append('<input type="hidden" name="pic" value="'+ res.src +'">');
          } else {
            layer.msg(res.msg);
          }
        }
        ,error: function(){
          //请求异常回调
          //演示失败状态，并实现重传
          var demoText = $('#demoText');
          demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
          demoText.find('.demo-reload').on('click', function(){
            uploadInst.upload();
          });
        }
      });
    });
    </script>
    <!-- 加载编辑器的容器 -->
    <script id="container" name="description" type="text/plain">

    </script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="/static/public/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/static/public/ueditor/ueditor.all.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
    </script>
    <script>
      layui.use(['layer', 'form'], function() {
          var layer = layui.layer,
              $ = layui.jquery,
              form = layui.form;
          $(window).on('load', function() {
              form.on('submit(admin)', function(data) {
                  $.ajax({
                      url:"<?php echo url('admin/goods/add'); ?>",
                      data:$('#admin').serialize(),
                      type:'post',
                      async: false,
                      success:function(res) {
                          if(res.code == 1) {
                              layer.alert(res.msg, function(index){
                                location.href = res.url;
                              })
                          } else {
                              layer.msg(res.msg);
                          }
                      }
                  })
                  return false;
              });
          });
      });
    </script>
  </div>
</body>
</html>
