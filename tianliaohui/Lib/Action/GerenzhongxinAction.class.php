<?php
// 本类由系统自动生成，仅供测试用途
class GerenzhongxinAction extends Action {
	
	
	
	
	
	
   	 /*********************************************************************************************************
   	  * 
   	  * 首页
   	  * 
   	  * *******************************************************************************************************/
    public function index(){
    	include("url.php");
    	

    	
    	//检测cookie是否存在
    	$array_cookie=common_jiance_cookie();
       	//dump($array_cookie);
    	if(!$array_cookie){
    		$this->jumpUrl='index';
    		$this->error('请重新登录');
    	}


    	//显示用户加入的对象,(以后要加上对象的名字,这里对象名字,用)
    	$rs_duixiang_jiaru=common_table_select('DuixiangJiaru',array('user_id'=>session('user_id')));
    	$this->rs_duixiang_jiaru=$rs_duixiang_jiaru;

		//显示用户正在审核的对象
		$rs_duixiang_shenqing=common_table_select('DuixiangShenqing',array('user_id'=>session('user_id'),'ds_zhuangtai'=>0));
    	//dump($rs_duixiang_shenqing);
    	$this->rs_duixiang_shenqing=$rs_duixiang_shenqing;
    	
		$this->display();
    }

    
    /**
     * 修改用户名字 显示页面
     */
    public  function  user_name_xiugai(){
    	include 'url.php';
    	
    	$this->display();
    	
    }

    
    /**
     * 修改用户名字 验证页面
     */
    public  function  user_name_xiugai_yanzheng(){
    	include 'url.php';
		
    	//检测输入的值是否符合标准
    	$user_name_changdu=common_jiance_changdu($_REQUEST['user_name'], array('changdu_zuida'=>20,'changdu_zuixiao'=>4));
    	if(!$user_name_changdu){
    		
    		$this->ajaxReturn(" "," 名字长度不能少于 4 个字符,也不能大于20字符\n(这里的字符是按英文计算的,一个汉字等于2个英文字符) ",0 ); 
    	}
    	
    	//往数据库里,写入用户的新名字
    	common_table_xieru('UserName', array('user_id'=>session('user_id') ,'un_name'=>$_REQUEST['user_name'],'un_time'=>time()));
    	
    	$this->ajaxReturn($_REQUEST['user_name']," 修改成功 ", 1 ); 
    	
    	
    }  
    
}