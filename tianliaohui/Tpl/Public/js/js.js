$(document).ready(function(e) {

});


















//ajax无刷新图片上传
function ajax_file_touxiang(url){

	//使用 ajaxFile 插件上传文件
	$.ajaxFileUpload({
		url:url,
		secureuri:false,
		fileElementId:'file_touxiang',   //文件选择框的id属性
		dataType: 'text',
		success:function(msg){
			
			$(".file_touxiang_350").attr({"src":"../PUBLIC/image_touxiang/touxiang_350_"+msg});
			$(".file_touxiang_60").attr({"src":"../PUBLIC/image_touxiang/touxiang_60_"+msg});
			alert(msg);
		},
		error:function(msg){
			alert("连接服务器失败");
		}  
	});
	
}



//显示弹出层
function tanchuceng(url){
	
	//控制底部遮罩层的长宽铺满整个屏幕
	$("#zhezhao").width($(document).width()).height($(document).height()).fadeTo("slow", 0.66,function (){
		
		//显示等待动画
		$("#zhezhao_dengdai").show();
		
		$.ajax({
		url:url,
		dataType:'html',
		success:function(msg){
			$("#zhezhao_dengdai").hide();//关闭等待动画
			
			//把ajax获取的内容,装载进入 tanchu_neirong_xianshi 标签
			$("#tanchu_neirong_xianshi").html(msg);
			
			//控制 弹出的内容层 宽度铺满屏幕,并把他垂直居中
			$("#tanchu_neirong").offset({ top:($(window).height()-$("#tanchu_neirong").height())/2+$(window).scrollTop()-50}).show();
			
			
		},
		error:function(msg){
			alert("弹出连接服务器失败");
		}
		
		});
	});
}

//关闭弹出层
function tanchuceng_guanbi(){
	//隐藏
	$("#zhezhao").hide();
	$("#zhezhao_dengdai").hide();
	$("#tanchu_neirong").hide();//把tanchu_neirong 这个层的顶部位置设置为 0 这样,就不会每次点关闭,tanchu_neirong这个层会往下跑
	$("#tanchu_neirong_xianshi").html("正在载入...");
}





