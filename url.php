<?php

	header("Content-Type:text/html; charset=utf-8");//字符集
	//首页
		$this->index='__URL__/index';//首页
		
		//登录页面
		$this->denglu_xianshi='__URL__/denglu_xianshi';//登录显示页面
		$this->denglu_yanzheng='__URL__/denglu_yanzheng';//登录验证页面
		
		//注册页面
		$this->zhuce_xianshi='__URL__/zhuce_xianshi';//注册显示页面
		$this->zhuce_yanzheng='__URL__/zhuce_yanzheng';//注册验证页面
		$this->zhuce_wancheng='__URL__/zhuce_wancheng';//上传头像，设置用户名字
		$this->zhuce_wancheng_yanzheng='__URL__/zhuce_wancheng_yanzheng';//上传头像，设置用户名字
		
		$this->tuichu='/Index/tuichu';//退出登录
		
		//个人中心页面
		$this->gerenzhongxin='/Gerenzhongxin';//个人中心显示页面
		$this->file_touxiang='Index/file_touxiang';					//上传图片显示页面
		$this->file_touxiang_yanzheng='Index/file_touxiang_yanzheng';//上传图片验证页面
		$this->user_name_xiugai='__URL__/user_name_xiugai';//修改用户名显示页面
		$this->user_name_xiugai_yanzheng='__URL__/user_name_xiugai_yanzheng';//修改用户名验证页面
		
		
		
		//对象页面
		$this->duixiang='/Duixiang';//对象显示页面
		$this->duixiang_chuangjian='/Duixiang/duixiang_chuangjian';//创建新对象显示页面
		$this->duixiang_chuangjian_yanzheng='/Duixiang/duixiang_chuangjian_yanzheng';//创建新对象_验证页面
		
		$this->shengshixian='/Shengshixian';//省市县
		
		
		
		$this->yaoqing='/Yaoqing';//邀请

		
		
		//标签页面
		$this->biaoqian='/Biaoqian';//标签显示页面
		
			
	


		//如果用户已经登录，则用户在操作一下数组包含页面的时候，直接重定向到 个人中心页面
		$page_gerenzhongxin=array('Index/index','index/denglu_xianshi','index/denglu_yanzheng','index/zhuce_xianshi','index/zhuce_yanzheng');
	
		//活动当前的模块名 和操作名,以便程序判断是否跳转到个人中心
		$mokuai_caozuo=MODULE_NAME."/".ACTION_NAME;
		
		
		//获取cookie的值
		$array_cookie=common_jiance_cookie();
		foreach ($page_gerenzhongxin AS $page_g){
			if ($mokuai_caozuo==$page_g and $array_cookie){
	
				redirect('/Gerenzhongxin');//重定向到个人中心页面
			}
		}
		
		
		
		
		
		//给全局的 用户名 照片  id 模版赋值
		$array_cookie=common_jiance_cookie();
		//dump($array_cookie);
		$this->user=$array_cookie;
		
		

		
		
	
	
