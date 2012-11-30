<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
	

	
	
	
   	 /*********************************************************************************************************
   	  * 
   	  * 首页
   	  * 
   	  * *******************************************************************************************************/
    public function index(){
		include("url.php");
		
/*    		//给模版变量赋值
		$url=common_zidong();
		foreach ($url AS $name=>$value){
			$this->$name=$value;
		}
*/

		
		



		$this->display();
    }

    
    
    
   	 /*********************************************************************************************************
   	  * 
   	  * 个人中心页面
   	  * 
   	  * *******************************************************************************************************/
/*    public function gerenzhongxin(){
    	common_zidong();
    	$this->url_peizhi();

    	
    	//检测cookie是否存在
    	$array_cookie=common_jiance_cookie();
       	//dump($array_cookie);
    	if(!$array_cookie){
    		$this->jumpUrl='index';
    		$this->error('请重新登录');
    	}
    	

    	
    	
    	$this->display();
    }
    */
    
    

    
    
    
    
   	 /*********************************************************************************************************
   	  * 
   	  * 登录验证页面
   	  * 
   	  * *******************************************************************************************************/
    public function denglu_yanzheng(){
    	include("url.php");
    	
    	
    	//调用公用登录函数
		$array_denglu=common_denglu(array("user_mail"=>$_REQUEST['user_mail'],"user_mima"=>$_REQUEST['user_mima']));
		//dump($array_denglu);
    	if($array_denglu['zhuangtai']==false){
    		$this->error($array_denglu['tishi']);
    	}else if($array_denglu['zhuangtai']==true){
    		$this->jumpUrl='/Gerenzhongxin'; 
    		$this->success($array_denglu['tishi']);
    	}
    }
    
    
    
    
    
    
    
    
   	 /*********************************************************************************************************
   	  * 
   	  * 注册显示页面
   	  * 
   	  * *******************************************************************************************************/
    public function zhuce_xianshi(){
		include("url.php");
	
    	$this->display();
    }
    
   	 /*********************************************************************************************************
   	  * 
   	  * 注册验证页面
   	  * 
   	  * *******************************************************************************************************/
    public function zhuce_yanzheng(){
		include("url.php");
    	
    	
    	
    	
    	
        $array_zhuce=common_zhuce(array("user_mail"=>$_REQUEST['user_mail'],"user_mima"=>$_REQUEST['user_mima'],'user_mima2'=>$_REQUEST['user_mima2']));
    	
    	if($array_zhuce['zhuangtai']==false){
    		$this->error($array_zhuce['tishi']);
    	}else if($array_zhuce['zhuangtai']==true){
    		$this->jumpUrl='zhuce_wancheng'; 
    		$this->success($array_zhuce['tishi']);
    	}
    	
    	
    }
    

    
    

    
   	 /*********************************************************************************************************
   	  * 
   	  * 上传头像，设置用户名字
   	  * 
   	  * *******************************************************************************************************/
    public function zhuce_wancheng(){
    	include("url.php");
    	
    	//检测cookie是否存在
    	$array_cookie=common_jiance_cookie();
    	$this->user=$array_cookie;
    	//dump($array_cookie);
    	if(!$array_cookie){
    		$this->jumpUrl='index';
    		$this->error('请重新登录');
    	}
    	
    	
    	
    	

    	$this->display();
    }
    
    
   	 /*********************************************************************************************************
   	  * 
   	  * 上传头像，设置用户名字  验证页面
   	  * 
   	  * *******************************************************************************************************/
    public function zhuce_wancheng_yanzheng(){
		include("url.php");
		
		echo $_REQUEST['user_image'];
		
		
		
		
    	//检测输入的值是否符合标准
    	$user_name_changdu=common_jiance_changdu($_REQUEST['user_name'], array('changdu_zuida'=>20,'changdu_zuixiao'=>4));
    	if(!$user_name_changdu ){
    		$this->error("名字长度不能少于 4 个字符,也不能大于20字符<br/>(这里的字符是按英文计算的,一个汉字等于2个英文字符)");
    	}
    	
    	//在user_name 表里 写入 un_name  user_id
		common_table_xieru("UserName",array('un_name'=>$_REQUEST['user_name'],'user_id'=>session('user_id'),'un_time'=>time()));
		
    	//echo "头像完成";
		$this->jumpUrl='/Gerenzhongxin'; 
    	$this->success('设置完成');
    	
    }
    
    
    
    
    
   	 /*********************************************************************************************************
   	  * 
   	  * 退出
   	  * 
   	  * *******************************************************************************************************/
    public function tuichu(){
    	include("url.php");
    	
		//把用户退出的时间 和ip 写入数据库
		$ip = get_client_ip();//获取ip
		$ip=intval(ip2long($ip)); //将ip地址转换为整数
		common_table_xieru("UserDengluTuichu",array('user_id'=>session('user_id'),'udt_ip'=>$ip,'udt_time'=>time(),'udt_zhuangtai'=>'tuichu'));
		
		
    	session('user_id',null);//删除session
    	cookie('user_id',null);//删除cookie
		$this->jumpUrl='/'; 
    	$this->success('退出成功，正在转到首页......');
    
    
    }
    
    
    /**
     * 头像上传
     */
    public function file_touxiang(){
		include("url.php");
		
		
        //检测cookie是否存在
    	$array_cookie=common_jiance_cookie();
       	//dump($array_cookie);
    	if(!$array_cookie){
    		
    		echo "你没有登录";
    		exit();
    	}		



   	
    	$this->display();
    }
    
    
    
    /**
     * 头像上传验证页面
     */
    public  function  file_touxiang_yanzheng(){
		include("url.php");
    	
        //检测cookie是否存在
    	$array_cookie=common_jiance_cookie();
       	//dump($array_cookie);
    	if(!$array_cookie){
    		
    		echo "你没有登录";
    		exit();
    	}
    	
    	
		//上传文件
		$array_image=common_file_image('touxiang');
    	//dump($array_image);
    	if($array_image['zhuangtai']==true){
    		echo $array_image['tishi'];
    		exit();
    	}else{
    		echo $user_image=$array_image[0]['savename'];//用户头像地址
    		    	
	    	//写入数据库
			//在user_name 表里 写入 un_name  user_id
			common_table_xieru("UserImage",array('user_id'=>$array_cookie['user_id'],'ui_image'=>$user_image,'ui_time'=>time()));
    	}
		
    	
    	

    
    }
   
    
    
}