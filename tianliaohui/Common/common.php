<?php



/*
 * 公共函数库介绍，包括一下函数
 * zifuji   字符集函数，用于控制网站的字符集
 *
 * */




/*自动
 * */
function common_zidong(){
/*	header("Content-Type:text/html; charset=utf-8");//字符集
	


	//如果用户已经登录，则用户在操作一下数组包含页面的时候，直接重定向到 个人中心页面
	$page_gerenzhongxin=array('Index/index','index/denglu_xianshi','index/denglu_yanzheng','index/zhuce_xianshi','index/zhuce_yanzheng');

	//活动当前的模块名 和操作名,以便程序判断是否跳转到个人中心
	$mokuai_caozuo=MODULE_NAME."/".ACTION_NAME;
	
	
	//获取cookie的值
	$array_cookie=common_jiance_cookie();
	foreach ($page_gerenzhongxin AS $page_g){
		if ($mokuai_caozuo==$page_g and $array_cookie){

			redirect('/gerenzhongxin');//重定向到个人中心页面
		}
	}*/

		
	//设置用户模版使用的 url  和 用户名 id mail 
/*	return array(
		'index'=>'index',//首页
		
		//登录页面
		'denglu_xianshi'=>'/denglu_xianshi',//登录显示页面
		
		'denglu_yanzheng'=>'/denglu_yanzheng',//登录验证页面
		
		//注册页面
		'zhuce_xianshi'=>'index/zhuce_xianshi',//注册显示页面
		'zhuce_yanzheng'=>'index/zhuce_yanzheng',//注册验证页面
		'zhuce_wancheng'=>'index/zhuce_wancheng',//上传头像，设置用户名字
		'zhuce_wancheng_yanzheng'=>'index/zhuce_wancheng_yanzheng',//上传头像，设置用户名字
		
		'tuichu'=>'/tuichu',//退出登录
		
		//个人中心页面
		'gerenzhongxin'=>'gerenzhongxin',//个人中心显示页面
		'file_touxiang'=>'index/file_touxiang',					//上传图片显示页面
		'file_touxiang_yanzheng'=>'index/file_touxiang_yanzheng',//上传图片验证页面
		
		//对象页面
		'duixiang'=>'index/duixiang',//对象显示页面
		
		'user'=>$array_cookie
	);*/
}




/** cookie 检测
 	*@access用到的thinkphp常量
	 * ACTION_NAME  //获取当前操作名字
	 * *******************************************************************************************
	 * 如果，用户进入当前页面，检测到cookie存在的话，就从数据库  user关于用户信息的 表里   读取用户的信息
	 * 如果，用户进入当前页面，cookie不存在了，给用户 一个 cookie 不存在的提示，以便程序根据这个提示来执行跳转登录页面，或者弹出登录框的操作
	 */
function common_jiance_cookie(){

	//如果, session 的值存在,则 user_id 使用session的值,否则,使用cookie的只,然后再重新给 session 赋值
	if(session('user_id')){
		$user_id=session('user_id');
	}else{
		$user_id=cookie('user_id');
		session('user_id',$user_id);
	}

	if($user_id){
		
		//显示用户所有信息
		$user=new DataModel();
		$user_suoyou=$user->user($user_id);
		return $user_suoyou;
		
		/*//获取用户注册的mail
		$array_mail=common_table_yanzheng('User', array('user_id'=>$user_id));
		//dump($array_name);


		//获取用户 名字
		$array_name=common_table_yanzheng('UserName', array('user_id'=>$user_id),array('un_id','desc'));
		//dump($array_name);

		//获取用户头像
		$array_image=common_table_yanzheng('UserImage', array('user_id'=>$user_id),array('ui_id','desc'));
		//dump($array_image);

		//获得用户 匿名 帐号的 id
		$array_niming_id=common_table_yanzheng('UserNiming', array('user_id'=>$user_id),array('unm_id','desc'));
		//dump($array_niming_id);


		return array('user_id'=>$user_id,'user_mail'=>$array_mail['user_mail'],'user_name'=>$array_name['un_name'],'user_image'=>$array_image['ui_image'],'user_niming_id'=>$array_niming_id['unm_id']);
*/
	}else{

		//给程序提示，cookie已经不存在了
		return false;

	}
}




//登录公共函数-所有登录都调用这个函数
/*函数详解
 * array("user_mail"=>"登录的mail","user_mima"=>'登录密码');
 *
 * ////////////////////////////////////////////////////////////////////////////////////////
 * 调用的其他函数
 * common_table_xieru   		数据写入函数
 * common_table_yanzheng     数据验证函数
 * trim_array                去掉数组字串两端空格函数
 * */
function common_denglu($array){

	$array=trim_array($array);
	//dump($array);

	//检测用户输入的值是否为空
	$changdu_mail=common_jiance_changdu($array['user_mail'], array('changdu_zuida'=>100,'changdu_zuixiao'=>5) );
	if(!$changdu_mail){
		return array('zhuangtai'=>false,'tishi'=>'邮箱不能为空');
	}
	$changdu_mima=common_jiance_changdu($array['user_mima'], array('changdu_zuida'=>16,'changdu_zuixiao'=>5) );
	if(!$changdu_mima){
		return array('zhuangtai'=>false,'tishi'=>'密码不能为空');
	}


	//查找用户名是否存在
	$rs_user=common_table_yanzheng('User', array('user_mail'=>$array['user_mail']));
	//dump($rs_user);

	if(!$rs_user){//如果用户名不存在，则报错
		//echo "用户名不存在";
		return  array('zhuangtai'=>false,'tishi'=>'用户名不存在');

	}else{//如果存在，则搜索该用户的密码

		//echo "用户名正确，现在开始搜索密码,";
		$rs_mima=common_table_yanzheng('UserMima', array('user_id'=>$rs_user['user_id'],'um_mima'=>md5($array['user_mima'])),array('um_id',' desc'));
		//dump($rs_mima);
		if(!$rs_mima){
			//echo "密码错误";
			return array('zhuangtai'=>false,'tishi'=>'密码错误');

		}else{
			//echo "密码正确，可以执行登录程序了";

			//把登录成功的 user_mail  和 user_id 写入session
			session('user_mail',$array['user_mail']);
			session('user_id',$rs_user['user_id']);

			cookie('user_mail',$array['user_mail'],3600);
			cookie('user_id',$rs_user['user_id'],3600);
				
			//把用户登录的时间 和ip 写入数据库
			$ip = get_client_ip();//获取ip
			$ip=intval(ip2long($ip)); //将ip地址转换为整数
			common_table_xieru("UserDengluTuichu",array('user_id'=>$rs_user['user_id'],'udt_ip'=>$ip,'udt_time'=>time(),'udt_zhuangtai'=>'denglu'));
				
			return  array('zhuangtai'=>true,'tishi'=>'登录成功');
		}

	}


}




/*//////////////////////////////////////////////////////////////////////////////////////
 * 注册公共函数
 * 参数详解
 * array("user_mail"=>"注册mail","user_name"=>'注册用户名',"user_mima"=>'注册密码');
 ////////////////////////////////////////////////////////////////////////////////////////
 * 调用的其他函数
 * common_table_xieru   		数据写入函数
 * common_table_yanzheng     数据验证函数
 * trim_array                去掉数组字串两端空格函数
 */
function common_zhuce($array){

	$array=trim_array($array);
	//检测用户输入数据是否符合数据格式   ,检测函数以后再补上


	//验证email的长度,和格式
	$array_jiance_mail=common_jiance_geshi($array['user_mail'],array('changdu_zuida'=>100, 'changdu_zuixiao'=>5,'geshi'=>'mail'));
	if($array_jiance_mail['zhuangtai']==false){
		return $array_jiance_mail;
	}

	//验证密码 是否正确
	$array_jiance_mima=common_jiance_geshi($array['user_mima'],array('changdu_zuida'=>16, 'changdu_zuixiao'=>5,'geshi'=>'mima','xiangtong'=>array($array['user_mima'],$array['user_mima2'])));
	if($array_jiance_mima['zhuangtai']==false){
		return $array_jiance_mima;
	}



	//验证改email是否已经注册过
	$rs_user=common_table_yanzheng("User",array('user_mail'=>$array['user_mail']));
	//dump($rs_user);

	if($rs_user){
		//echo "email已存在\n";
		return  array('zhuangtai'=>false,'tishi'=>'email已存在');
	}else{
		/*写入注册新用户
		 * 在 user 表里 写入 mail
		 * 读取 user 表里 mail 字段对应的 user_id 用于下面写入别的表里使用
		 * 在user_name 表里 写入 un_name  user_id  un_time
		 * 在user_mima 表里写入 user_id , um_mima  um_time
		 * 在 user_niming 表里写入 user_id  unm_time
		 * */

		//在 user 表里 写入 mail
		common_table_xieru("User", array("user_mail"=>$array['user_mail'],'user_time'=>time()));

		//读取 user 表里 mail 字段对应的 user_id 用于下面写入别的表里使用
		$user_id=common_table_yanzheng("User",array('user_mail'=>$array['user_mail']));
		//echo $user_id['user_id'];

		//在user_name 表里 写入 un_name  user_id
		//common_table_xieru("UserName",array('un_name'=>$array['user_name'],'user_id'=>$user_id['user_id'],'un_time'=>time()));

		//在user_mima 表里写入 user_id , um_mima
		common_table_xieru("UserMima",array('um_mima'=>md5($array['user_mima']),'user_id'=>$user_id['user_id'],'um_time'=>time()));

		//在 user_niming 表里写入 user_id
		common_table_xieru("UserNiming",array('user_id'=>$user_id['user_id'],'unm_time'=>time()));
		//echo "写入成功\n";


		//调用 登陆函数 common_denglu()
		$rs_denglu=common_denglu(array("user_mail"=>$array['user_mail'],"user_mima"=>$array['user_mima']));

		return  array('zhuangtai'=>true,'tishi'=>'注册完成');

	}





}






/*写入数据
 * 参数详解
 * $table_name=表名字
 * $array_data("字段名"=>"要写入的数据"); 多个字段写入，按数组方式添加
 * */
function common_table_xieru($table_name,$array_data){
	$table=D($table_name);
	$zhuangtai=$table->add($array_data);
	if($zhuangtai){
		return TRUE;
	}else{
		return FALSE;
	}
	
}



/**
 * 更新数据表
 * @author  $table_name=表名字
 * @author  $array_data("要更新的字段名"=>"要更新的数据"); 多个字段更新，按数组方式添加
 */
function common_table_gengxin($table_name,$array_data){
	$table=D($table_name);
	$zhuangtai=$table->save($array_data);
	if($zhuangtai){
		return TRUE;
	}else{
		return FALSE;
	}
	
}







/**
 * 验证数据是否存在函数。只返回一条数据  find
 * 参数详解
 * @access $table = 表名字
 * @access $array_data=array("字段名"=>'字段数据'); 要查询的数据，可以多写几个
 * @access $array_paixv=array("排序字段",'排序规则');  array('user_id','desc')默认为空，如果需要查询，则在调用的时候使用这个数组
 *@return Array
 * ////////////////////////////////////////////////////////////////////////////////////////
 *
 * @global 调用的其他函数
 * trim_array                去掉数组字串两端空格函数
 *
 */
function common_table_yanzheng($table_name,$array_data,$array_paixv=NULL){

	$array_data=trim_array($array_data);
	//dump($array_data);
	//dump($array_paixv);
	$table=D($table_name);
	if($array_paixv){//如果排序存在，就排序
		$ziduan=$array_paixv[0];
		$guize=$array_paixv[1];
		$rs_table=$table->where($array_data)->order($ziduan.' '.$guize)->find();
		//dump($rs_table);
	}else{//排序不存在
		$rs_table=$table->where($array_data)->find();
	}

	if($rs_table){
		return $rs_table;
	}



}


/**
 * 根据查询的值从数据库查询多条数据,返回 select
 * 参数详解
 * @access $table = 表名字
 * @access $array_data=array("字段名"=>'字段数据'); 要查询的数据，可以多写几个
 * @access $array_paixv=array("排序字段",'排序规则');  array('user_id','desc')默认为空，如果需要查询，则在调用的时候使用这个数组
 *
 * ////////////////////////////////////////////////////////////////////////////////////////
 *
 * @global 调用的其他函数
 * trim_array                去掉数组字串两端空格函数
 *
 */
function common_table_select($table_name,$array_data=NULL,$array_paixv=NULL){

	$array_data=trim_array($array_data);
	//dump($array_data);
	//dump($array_paixv);
	$table=D($table_name);
	if($array_paixv){//如果排序存在，就排序
		$ziduan=$array_paixv[0];
		$guize=$array_paixv[1];
		$rs_table=$table->where($array_data)->order($ziduan.' '.$guize)->select();
		//dump($rs_table);
	}else{//排序不存在
		$rs_table=$table->where($array_data)->select();
	}

	if($rs_table){
		return $rs_table;
	}



}




//清除数组所有字符串元素两边的空格
function trim_array($array){
	foreach ($array AS $name=>$value){
		$trim_array[$name]=trim($value);
	}
	return $trim_array;
}




/**
 * 字符串格式验证
 * @access $zifuchuan='要验证的字符串'
 * @access $array_shuxiang=array('changdu_zuida'=>'字符串最大长度','changdu_zuixiao'=>'字符串最小长度','geshi'=>'字符串格式（数字int，文字string, 日期时间time, 邮箱格式mail,密码格式mima）,'xiangtong(两次输入的字符串是否相同)'=>array('对比字符串1,对比字符串2')')
 * @return Array
 * */
function common_jiance_geshi($zifu,$array_shuxing=null){



	//数组赋值给变量
	$changdu_zuida   = $array_shuxing['changdu_zuida']; //字符串最大长度
	$changdu_zuixiao = $array_shuxing['changdu_zuixiao'];//字符串最小长度
	$geshi           = $array_shuxing['geshi'];//字符格式
	$xiangtong       = $array_shuxing['xiangtong'];//两次输入的密码是否一样.不验证密码的时候,可以不写


	//把$geshi的值转换成汉字
	switch ($geshi){
		
		case '数字':
			//验证长度
			$mingzi_changdu=common_jiance_changdu($zifu,array('changdu_zuida'=>100,'changdu_zuixiao'=>1));
			if($mingzi_changdu==false){
				return array('zhuangtai'=>false, 'tishi'=>$geshi."不能少于1 个字符, 也不能大于240个字符");
			}else{
				
				if(!is_numeric ($zifu)){//判断是否为数字
					return array('zhuangtai'=>false, 'tishi'=>'不是有效的数字');
				}
			}
			
			break;
			
			
		case '长文字':
			//验证长度
			$mingzi_changdu=common_jiance_changdu($zifu,array('changdu_zuida'=>10000,'changdu_zuixiao'=>2));
			if($mingzi_changdu==false){
				return array('zhuangtai'=>false, 'tishi'=>$geshi."不能少于 2 个英文字符, 也不能大于10000个英文字符");
			}
			break;
			
			
			
			
		case '短文字':
			$geshi_hanzi="短文字";	
			//验证长度
			$mingzi_changdu=common_jiance_changdu($zifu,array('changdu_zuida'=>240,'changdu_zuixiao'=>2));
			if($mingzi_changdu==false){
				return array('zhuangtai'=>false, 'tishi'=>$geshi_hanzi."不能少于 2 个英文字符, 也不能大于240个英文字符");
			}
			
			break;
			
			
		case '日期':
			$riqi=explode("-", $zifu);
			
			if(!checkdate($riqi[1],$riqi[2],$riqi[0])){
				return array('zhuangtai'=>false, 'tishi'=>'日期格式错误');
			}
			
			
			break;
			
			
		case '图片':
			
			return array('zhuangtai'=>false, 'tishi'=>'图片验证暂时不能用');
			
			
			
			break;
			
			
			
		case 'mail':
			$geshi_hanzi='邮箱';
			//验证字符串长度
			$zifu_changdu=common_jiance_changdu($zifu,array('changdu_zuida'=>$changdu_zuida,'changdu_zuixiao'=>$changdu_zuixiao));

			if($zifu_changdu==false){
				return array('zhuangtai'=>false, 'tishi'=>$geshi_hanzi."不能少于".$changdu_zuixiao."英文字符");
			}else{

				//验证邮箱格式
				if(!eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $zifu)){
					return array('zhuangtai'=>false, 'tishi'=>'email格式错误');
				}
			}
			
			
			break;
			
			
			
			
		case 'mima':
			$geshi_hanzi='密码';
			//验证字符串长度
			$zifu_changdu=common_jiance_changdu($zifu,array('changdu_zuida'=>$changdu_zuida,'changdu_zuixiao'=>$changdu_zuixiao));
			if(!$zifu_changdu){
				return array('zhuangtai'=>false, 'tishi'=>$geshi_hanzi."不能少于".$changdu_zuixiao."英文字符");
			}else{

				//验证两次输入密码是否相同
				if($xiangtong[0]!=$xiangtong[1]){
					return array('zhuangtai'=>false, 'tishi'=>'两次输入的密码不一样');
				}
			}
			
			break;
			
		  default:
		    return array('zhuangtai'=>true, 'tishi'=>'无操作');
		    break;
			
			
	}



	//如果上面所有的判断头通过的话, return 真
	return array('zhuangtai'=>true, 'tishi'=>"字符串合乎规则");
}





/**
 * 检测字符串的长度是否符合规定
 * @access $zifu='要验证的字符串'
 * @access array('changdu_zuida'=>'字符串最大长度','changdu_zuixiao'=>'字符串最小长度')
 * @return true,false
 * @abstract  这里需要改进的是, 中文字符的长度,没法算
 *
 */
function common_jiance_changdu($zifu,$array){
	//去掉字符串首尾空格
	$zifu=trim($zifu);

	//字符串长度
	$zifu_changdu=strlen($zifu);
	//dump($array);
	//数组赋值给变量
	$changdu_zuida   = $array['changdu_zuida']; //字符串最大长度
	$changdu_zuixiao = $array['changdu_zuixiao'];//字符串最小长度



	//限制最小长度
	if($changdu_zuixiao>0){
		if($zifu_changdu < $changdu_zuixiao){
			//echo "不能少于".$changdu_zuixiao."英文字符（一个汉字等于2个英文）";
			return false;
		}
	}


	//限制最大长度
	if ($changdu_zuida>0){
		if($zifu_changdu> $changdu_zuida){
			//echo "不能超过".$changdu_zuida."英文字符（一个汉字等于2个英文）";
			return false;
		}
	}

	//如果以上判断都通过的话,则 输出 真,
	return  true;
}


/**
 *图上传操作\n
 *判断用户上传的是头像 ,还是一般图片
 *@access $geshi='头像touxiang'  or   '一般图片tupian';
 *@return array
 * */
function common_file_image($geshi){

	//import("ORG.Util.UploadFile");

	$upload = new UploadFile();// 实例化上传类
	$upload->maxSize  = 3145728 ;// 设置附件上传大小
	$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型

	$upload->thumb= true;//生成缩略图
	//$upload->imageClassPath = 'ORG.Util.Image';// 设置引用图片类库包路径
	$upload->saveRule = md5(uniqid(20,true));//设置上传文件规则--生成一个不重复的文件名



	//上传头像设置
	if($geshi=='touxiang'){
		//echo "缩略图";
		$upload->thumbMaxWidth="350,60";//缩略图宽
		$upload->thumbMaxHeight="350,60";//缩略图高
		$upload->thumbPrefix="touxiang_350_,touxiang_60_";//缩略图的前缀名
		$upload->thumbRemoveOrigin=true;//删除原图
			
		$upload->savePath =  './PUBLIC/image_touxiang/';// 设置附件上传目录
			
	}elseif($geshi='tupian'){//上传一般图片设置
		//echo "一般图片";
		$upload->thumbMaxWidth="300";//缩略图宽
		$upload->thumbMaxHeight="300";//缩略图高
		$upload->thumbPrefix="tupian_300_";//缩略图的前缀名
			
		$upload->savePath =  './PUBLIC/image_tupian/';// 设置附件上传目录
	}




	if(!$upload->upload()) {// 上传错误提示错误信息

		return array('zhuangtai'=>true, 'tishi'=>$upload->getErrorMsg());

	}else{// 上传成功 获取上传文件信息

		return $upload->getUploadFileInfo();

	}



}


/**
 * 产生一个唯一不重复的标示---dx_biaoshi 也在用
 * @return $biaoshi_weiyi 变量
 */

function suijishu(){
	//Load('extend'); //加载扩展函数库后，就可以调用其中的所有函数了。
	$biaoshi_time=time();
	//mt_rand()产生一个随机数
	//uniqid 本函数会依据当时的毫秒以及指定的前置字符串产生一个独一无二的字符串
	$biaoshi_weiyi=md5(uniqid(mt_rand())).$biaoshi_time;//随机一个以当前时间为毫秒的随机数,几乎不会重复
	return $biaoshi_weiyi;
	
	//to_guid_string ();//根据 PHP 各种类型变量生成唯一标识号 ,暂时没有使用



}
	


/**
 * @author更新排序字段
 * @access $table_name = 表名字
 * @access array('zhujian_name'=>主键名字,'id'=>id,'ziduan'=>更新字段, 'jiajian'=>加一(jia) 或者 减一(jian))
 * @return true false
 */
function gengxin_paixu($table_name,$array){
//这是为标签的使用数 加一
$bq_paixu=M($table_name);
$data_paixu[$array['zhujian_name']]=$array['id'];
	if($array['jiajian']=='jia'){
		$zhuangtai=$bq_paixu->where($data_paixu)->setInc($array['ziduan'],1); //这是为标签的使用数 加一
	}else{
		$zhuangtai=$bq_paixu->where($data_paixu)->setDec($array['ziduan'],1); //这是为标签的使用数 加一
	}
	
	if($zhuangtai){
		return TRUE;
	}else{
		return false;
	}

}



/**
 * @author 统计总数
 * @access $table_name = 数据表名字
 * @access array('ziduan'=>要统计的字段)
 * @return array()
 */
function zongshu($table_name,$array){
	
	$zongshu=M($table_name);
	$count=$zongshu->where($array)->count();
	return $count;
}

/**
 * @author 更新数据
 * @access $table_name=数据表名字
 * @access array('ziduan'=>要更新的字段)
 * @return true  false
 */
function gengxin($table_name,$array){
	$gengxin=M($table_name);
	$zhuangtai=$gengxin->save($array);
	if($zhuangtai){
		return TRUE;
	}else{
		return false;
	}
}
?>