<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Insert title here</title><link href="../Public/css/css.css" rel="stylesheet" type="text/css"><link href="../Public/css/touxiang.css" rel="stylesheet" type="text/css"><script type="text/javascript" src="../Public/js/jquery-1.8.2.js"></script><script type="text/javascript" src="../Public/js/ajaxfileupload.js"></script><script type="text/javascript" src="../Public/js/js.js"></script><script>$(document).ready(function(e) {
	
	
	//上传头像 的函数
	$("#ajax_file_touxiang").click(function(){ajax_file_touxiang('__URL__/file_touxiang_yanzheng');})
	

});

	
	
</script></head><body ><div class="zhuti"><h1>干干净净的世界，<br>这一切是需要你亲手创造</h1><form action="<?php echo ($zhuce_wancheng_yanzheng); ?>" method="post"  class="zhuce"><ul><li><div class="touxiang"><?php if(($user["user_image"]) != ""): ?><img src="../PUBLIC/image_touxiang/touxiang_350_<?php echo ($user['user_image']); ?>" class="file_touxiang_350"/><?php else: ?><img src="../Public/images/touxiang.png" class="file_touxiang_350"/><?php endif; ?></div></li><li><div class="div-1">传一张自己的照片做头像：</div><div class="div-2"><div><input name="poto" type="file" id="file_touxiang" style="width:60px;"/></div><div><a href="javascript:void(0);" id="ajax_file_touxiang">上传照片</a></div></div></li><li><div class="div-1">写你的真实姓名：</div><div class="div-2"><input name="user_name" type="text" value="" id="user_name" class="wenbenkuang"/></div></li><li><input type="submit" value="完成" id="zhuce_wancheng" class="zhuce-anniu"/></li></ul></form></div></body></html>