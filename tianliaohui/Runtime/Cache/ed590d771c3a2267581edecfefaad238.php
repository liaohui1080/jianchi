<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>无标题文档</title><link href="../Public/css/css.css" rel="stylesheet" type="text/css" /><link href="../Public/css/duixiang.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="../Public/js/jquery-1.8.2.js"></script><script type="text/javascript" src="../Public/js/date.js"></script><script type="text/javascript" src="../Public/js/js.js"></script><script></script><!--公共弹出层--><style>.zhezhao{width:100%; height:500px; background-color:#000; position:absolute; top:0px; left:0px;z-index:1; display:none;}
/*
遮罩等等动画
*/
.zhezhao_dengdai{ width:100px; height:100px; background-color:#ff8040; z-index:1000; display:none; top:200px; left:200px; position:absolute;}
.tanchu_neirong{width:100%; height:auto; background-color:#ff8040; position:absolute; z-index:3; padding-top:10px; padding-bottom:40px;display:none;}	
.tanchu_neirong .guanbi{width:98%; height:30px; padding-right:2%; font-size:14px; line-height:30px;}
.tanchu_neirong .guanbi a{ width:80px; height:30px; display:block; text-align:center; float:right; color:#ffff00;}
.tanchu_neirong .guanbi a:hover{ width:80px; display:block; background-color:#ff8040; color:#ffffff;}
.tanchu_neirong .xianshi { width:97%; padding-left:3%;}


/*
弹出层2

*/

</style><div id="zhezhao" class="zhezhao" onclick="tanchuceng_guanbi()">遮罩层</div><div id="zhezhao_dengdai" class="zhezhao_dengdai"><img src="../Public/images/dengdai.gif" alt="" /></div><div id="tanchu_neirong" class="tanchu_neirong"><div class="guanbi"><a href="javascript:void(0);" onclick="tanchuceng_guanbi()">关闭</a></div><!--用来显示ajax_内容的--><div id="tanchu_neirong_xianshi" class="xianshi"></div></div></head><body><?php if(is_array($rs_duixiang)): $i = 0; $__LIST__ = $rs_duixiang;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs_dx): $mod = ($i % 2 );++$i;?><ul><ol><a href="<?php echo ($duixiang); ?>/index/dx_id/<?php echo ($rs_dx['dx_id']); ?>"><?php echo ($rs_dx['dx_id']); ?>--<?php echo ($rs_dx['dx_name']); ?></a></ol><li><img src="/PUBLIC/image_touxiang/touxiang_60_<?php echo ($rs_dx['user']['user_image']); ?>" class="file_touxiang_60"/></li><li><?php echo ($rs_dx['user']['user_name']); ?></li><li>&nbsp;</li></ul><?php endforeach; endif; else: echo "" ;endif; ?></body></html>