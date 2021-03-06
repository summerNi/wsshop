<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:62:"D:\wamp64\www\pethome\public/../app/admin\view\goods\edit.html";i:1542093929;}*/ ?>
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
          <input name="name" lay-verify="required" placeholder="请输入商品名称" value="<?php echo $goods['name']; ?>" autocomplete="off" class="layui-input" type="text" >
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">商品副名称</label>
        <div class="layui-input-inline">
          <input name="sub_name" lay-verify="required" placeholder="请输入商品副标题" value="<?php echo $goods['sub_name']; ?>" autocomplete="off" class="layui-input" type="text" >
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">价格</label>
        <div class="layui-input-inline">
          <input name="price" lay-verify="required" placeholder="请输入价格" value="<?php echo $goods['price']; ?>" autocomplete="off" class="layui-input" type="text" >
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">市场价</label>
        <div class="layui-input-inline">
          <input name="market_price"  placeholder="请输入市场价" value="<?php echo $goods['market_price']; ?>" autocomplete="off" class="layui-input" type="text" >
        </div>
      </div>


      <div class="layui-upload" id="upload-thumb">
        <label class="layui-form-label">封面图</label>
        <button type="button" class="layui-btn" id="thumb">上传封面图</button>
        <div class="layui-upload-list">
          <label class="layui-form-label"></label>
          <img class="layui-upload-img" src="<?php echo $goods['pic']; ?>" id="demo1" width="150" height="150" >
          <input type="hidden" name="pic" id="pic_url" value="<?php echo $goods['pic']; ?>">
          <p id="demoText"></p>
        </div>
      </div>




      <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">商品详情</label>
        <div class="layui-input-block" style="max-width:800px;">
          <textarea placeholder="请输入内容" class="layui-textarea" name="description" id="container" style="border:0;padding:0"><?php echo $goods['description']; ?></textarea>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">

          <input type="radio" name="status" value="1" title="上架"  <?php if($goods['status'] == 1): ?>checked<?php endif; ?> ><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><div>上架</div></div>
          <input type="radio" name="status" value="0" title="下架" <?php if($goods['status'] == 0): ?>checked<?php endif; ?> ><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><div>下架</div></div>
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-input-block">
          <button class="layui-btn" lay-submit lay-filter="admin">立即提交</button>
          <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
      </div>

    </form>

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
            $("#pic_url").val(res.src);
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
                      url:"<?php echo url('admin/goods/edit'); ?>",
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
