<?php
// 本类由系统自动生成，仅供测试用途
class DuixiangAction extends Action {
	

	/**
	 * 类库载入时自动运行
	 * Enter description here ...
	 */
	public function __construct(){
    	//检测cookie是否存在
    	$array_cookie=common_jiance_cookie();
       	//dump($array_cookie);
    	if(!$array_cookie){
    		$this->jumpUrl='/';
    		$this->error('请重新登录');
    	}
    	
    	

	}
	
	
   	 /*********************************************************************************************************
   	  * 
   	  * 首页
   	  * 
   	  * *******************************************************************************************************/
    public function index(){
    	include("url.php");
    	
        //检测用户是否,加入了这个对象,如果没有则跳转到对象公开页面,如果加入了,就不进入对象页面
    	$jiaru=common_table_yanzheng('DuixiangJiaru', array('dx_id'=>$_REQUEST['dx_id'],'user_id'=>session('user_id')));
    	//dump($jiaru);
    	if(!$jiaru){
    		//重定向到对象公开页面
    		$this->redirect('Duixiang/duixiang_gongkai/',array('dx_id'=>$_REQUEST['dx_id']),0,"");
    	}
    	

		$data =  new DataModel();	//实例化数据层,用于给页面提供数据 
		
		
		//把对象id赋值给模版
		$this->dx_id=$_REQUEST['dx_id'];

		
		//显示对象的名字 (显示 标签内容里 等于 名字的标签,他的认同对最高 的那个 名字)
		$duixiang_name=$data->duixiang_name( array('dx_id'=>$_REQUEST['dx_id']));
		//dump($duixiang_name);
		$this->duixiang_name=$duixiang_name;
		
		
		
		
		//显示对象使用的标签和内容
		$rs_biaoqian=$data->biaoqian_yongguo(array('dx_id'=>$_REQUEST['dx_id'] ));
		//dump($rs_biaoqian);
		$this->rs_biaoqian=$rs_biaoqian;//把数组赋值给模版
		

		//显示正在申请加入这个对象的人数,是这样计算的,你只能审核,在你加入对象之后新加入的人,也就是 对象申请 表里,那些申请加入该对象时间,比你加入对象时间大的人
		$shenqing_user=$data->duixiang_shenqing_user(array('dx_id'=>$_REQUEST['dx_id'],'user_id'=>session('user_id')));
		//dump($shenqing_user);
		$this->count=$shenqing_user['count'];
		
		
		//显示已经加入这个对象的人
		$duixiang_yonghu=$data->duixiang_yonghu($_REQUEST['dx_id']);
    	//dump($duixiang_yonghu);
    	$this->duixiang_yonghu=$duixiang_yonghu['jiaru_user'];//显示所有加入对象的人,赋值给模版
    	$this->duixiang_yonghu_count=$duixiang_yonghu['count'];//把人数 赋值给模版
		
		
		$this->display();
    }

    
    /**
     * 创建一个新对象  显示页面
     */
    public function duixiang_chuangjian(){
    	include 'url.php';
    	
    	
    	$this->display();
    }

    
    
    /**
     * 创建一个新对象 验证页面
     */
    public function duixiang_chuangjian_yanzheng(){
    	include 'url.php';
    	//echo "验证页面";
    	
    	//检测创建对象 的名字是否符合标准
    	$array_jiance=common_jiance_geshi($_REQUEST['bn_neirong'],array('geshi'=>'短文字'));
    	if ($array_jiance['zhuangtai']==FALSE){
    		$this->ajaxReturn(" ",$array_jiance['tishi'],0);
    	}else{
    		
    		//获取标签 id,下面要用
    		$bq_id=common_table_yanzheng('Biaoqian', array('bq_name'=>'名字'));
    		//dump($shuxing_id);
    		
    		 //这是为标签的使用数 加一
			$bq_paixu=M('Biaoqian');
			$data_paixu['bq_id']=$bq_id['bq_id'];
			$bq_paixu->where($data_paixu)->setInc('bq_paixu',1); //这是为标签的使用数 加一
    		
    		
    		//创建一个对象,默认是一个私人对象,
    		$biaoshi=suijishu();
    		common_table_xieru('Duixiang', array('dx_biaoshi'=>$biaoshi, 'user_id'=>session('user_id'),	'dx_time'=>time()));
    			
    		//搜索刚刚创建对象的id .根据对象的唯一 标识,找到id
    		$dx_id=common_table_yanzheng('Duixiang', array('dx_biaoshi'=>$biaoshi));
    		    		    		
    		//写入对象的第一个名字到  标签内容表 
    		common_table_xieru('BiaoqianNeirong', array('dx_id'=>$dx_id['dx_id'],'bq_id'=>$bq_id['bq_id'],'bn_neirong'=>$_REQUEST['bn_neirong'],'user_id'=>session('user_id'),'bn_time'=>time()));
    		
    		//把该用户写入  对象加入表,
    		common_table_xieru('DuixiangJiaru', array('dx_id'=>$dx_id['dx_id'],'dx_name'=>$_REQUEST['bn_neirong'],'user_id'=>session('user_id'),'dj_time'=>time()));
    		
    		$this->ajaxReturn($dx_id['dx_id'],"成功",1);
    	}

    	

    	
    	
    }    
    
    
    
    
    /**
     * 对象公开页面,,就是用户.在没有注册或者没有加入对象的时候看到的页面
     */
    public function duixiang_gongkai(){
    	include 'url.php';
    	
    	$this->dx_id=$_REQUEST['dx_id'];//把对象id赋值给模版
    	
		$data =  new DataModel();	//实例化数据层,用于给页面提供数据 
		//18211802922 凉风秋叶 电话
		
		//显示对象的名字 (显示 标签内容里 等于 名字的标签,他的认同对最高 的那个 名字)
		$duixiang_name=$data->duixiang_name( array('dx_id'=>$_REQUEST['dx_id']));
		//dump($duixiang_name);
		$this->duixiang_name=$duixiang_name;
		
		
		//显示对象使用的标签和内容
		$rs_biaoqian=$data->biaoqian_yongguo(array('dx_id'=>$_REQUEST['dx_id'] ));
		//dump($rs_biaoqian);
		$this->rs_biaoqian=$rs_biaoqian;//把数组赋值给模版
		
		
		//显示加入这个对象的人
		$duixiang_yonghu=$data->duixiang_yonghu($_REQUEST['dx_id']);
    	//dump($duixiang_yonghu);
    	$this->duixiang_yonghu=$duixiang_yonghu['jiaru_user'];//显示所有加入对象的人,赋值给模版
    	$this->duixiang_yonghu_count=$duixiang_yonghu['count'];//把人数 赋值给模版
    	
    	
    	//检测用户是否已经发送过加入申请了
    	$shenqing=common_table_yanzheng('DuixiangShenqing', array('dx_id'=>$_REQUEST['dx_id'],'user_id'=>session('user_id')));
    	//dump($shenqing);
    	$this->shenqing=$shenqing;
    	
    	$this->display();
    }
   
    
    
    /**
     * 申请加入对象验证页面
     */
    public function duixiang_shenqing_yanzheng(){
    	include 'url.php';

    	//验证数据是否符合标准
    	$name=common_jiance_changdu($_REQUEST['ds_name'], array('changdu_zuida'=>'100','changdu_zuixiao'=>'2') );
    	if (!$name){
    		$this->error('名字不能小于2个字符,也不能大于100个字符');
    		exit();
    	}
    	
    	$liyou=common_jiance_changdu($_REQUEST['ds_liyou'], array('changdu_zuida'=>'255','changdu_zuixiao'=>'10') );
    	if (!$liyou){
    		$this->error('理由不能小于10个字符,也不能大于255个字符');
    		exit();
    	}
    	
    
    	
    	
    	//向对象申请表里写入数据
    	$shenqing=common_table_xieru('DuixiangShenqing', 
    	array(
    	'dx_id'=>$_REQUEST['dx_id'],
    	'dx_name'=>$_REQUEST['dx_name'],
    	'user_id'=>session('user_id'),
    	'ds_name'=>$_REQUEST['ds_name'],
    	'ds_liyou'=>$_REQUEST['ds_liyou'],
    	'ds_yaoqingren'=>$_REQUEST['ds_yaoqingren'],
    	'ds_time'=>time()
    	));
    	
    	
    	if ($shenqing){
    		$this->success('申请已发送,请耐心等待审核...');
    	}else{
    		$this->success('操作失败');
    	}
    	
    }
    
    
    
    
    /**
     * 显示所有对象.
     */
    public function duixiang_quanbu(){
    	include 'url.php';
    	$data=new DataModel();
    	//显示所有对象
    	$duixiang=common_table_select("Duixiang");
    	//dump($duixiang);
    	
    	//获取对象的名字,对象的创建人
    	foreach ($duixiang AS $rs_dx){
    		$dx_name=$data->duixiang_name(array('dx_id'=>$rs_dx['dx_id']));
    		$user=$data->user($rs_dx['user_id']);
    		$rs_dx['dx_name']=$dx_name['bn_neirong'];
    		$rs_dx['user']=$user;
    		$rs_duixiang[]=$rs_dx;
    	}
    	//dump($rs_duixiang);
    	$this->rs_duixiang=$rs_duixiang;
    	
    	
    	
    	$this->display();
    }
    
    
    
    /**
     * 审核显示页面.
     */
    public function shenhe(){
    	include 'url.php';
    	$data=new DataModel();
    	
    	
		//显示正在申请加入这个对象的人数,是这样计算的,你只能审核,在你加入对象之后新加入的人,也就是 对象申请 表里,那些申请加入该对象时间,比你加入对象时间大的人
		$shenqing_user=$data->duixiang_shenqing_user(array('dx_id'=>$_REQUEST['dx_id']));
		//dump($shenqing_user['shenqing_user']);
		$this->rs_shenqing_user=$shenqing_user['shenqing_user'];
    	
    	$this->display();
    }
    
    
    
    /**
     * 审核确认页面,如果通过审核则显示二次确认页面 ,   如果不通过审核则显示,拒绝理由输入页面
     */
    public function shenhe_queren(){
    	include 'url.php';
    	
    	$this->shenhe=$_REQUEST['shenhe'];//把审核通过不通过的参数赋值给模版
    	$this->ds_id=$_REQUEST['ds_id'];//把审核通过不通过的参数赋值给模版
    	
    	//显示申请加入这个对象的人的信息
    	$shenqing_user=common_table_yanzheng('DuixiangShenqing', array('ds_id'));
    	dump($shenqing_user);
    	
    	$this->display();
    }
    
    
    
    /**
     * 审核验证页面,
     * 具体运行方式是: 先获取 对象加入 表里所有已经加入该对象的人数,然后除以3,获取其中三分之一的人的总数,  如果人数小于3,这不进行三分之一处理
     * 然后获取对象 审核表 里 审核状态=1  并且 对象申请id=  对象申请表里的 对象申请id  的记录总数
     * 如果这个记录总数 = 对象加入表里的 三分之一 的人数, 就说明审核通过了,
     * 审核通过以后, 在对象加入表里,写入该用户的信息, 并且在对象申请表里,把状态 设为 1,代表已经通过 了,然后,还有给该申请用户发一条,已经加入对象的消息,消息会附上所有参与审核的并同意加入的人的名字
     * 
     * 如果是拒绝通过的话,则给用户发消息,然后检索 对象审核 表里是否已经有数据,如果有的话,只更新状态,如果没有的话,新增一个状态 
     * 
     * 另外,不管用户是拒绝通过,还是同意通过,都将会给申请加入这个对象的人,发送一条消息,
     */
    public function shenhe_yanzheng(){
    	include 'url.php';
    	
      	$data= new DataModel();
    	
    	//第一次获取审核进度,如果 状态等于 真,则说明这个用户已经加入了这个对象
		$jindu=$data->shenhe_jindu(array('ds_id'=>$_REQUEST['ds_id']));
		
		if($jindu['zhuangtai']=='yijiaru'){//该被审核用户,已经加入了对象 了
			
			$this->error($jindu['tishi']);
			exit();
			
		}elseif($jindu['zhuangtai']=='dengdai'){//否则,则说明用户正在审核中
			
			 //检索 对象审核 表里是否已经有用户的审核数据
    		 $shenhe=common_table_yanzheng('DuixiangShenhe', array('ds_id'=>$_REQUEST['ds_id'], 'user_id'=>session('user_id')));
    		 
    		 
    		 //同意审核   和拒绝审核 从上一页传递过来的参数
			 if($_REQUEST['shenhe']=='yes'){//同意审核 
			 	
			 	if(!$shenhe){//如果用户以前没有审核过,则新增一条审核
    				common_table_xieru('DuixiangShenhe', array('ds_id'=>$_REQUEST['ds_id'],'user_id'=>session('user_id'),'dsh_time'=>time(),'dsh_zhuangtai'=>1));
    					
    			}else{ //否则只修改,审核时间,和审核状态
    				common_table_gengxin('DuixiangShenhe', array('dsh_id'=>$shenhe['dsh_id'],'dsh_time'=>time(),'dsh_zhuangtai'=>1));
    			}
			 	
			 	//第二次获得审核进度,看看用户新增了这个审核以后, 申请加入对象的这个人,是否已经达到了通过审核的标准,
    			$jindu_dierci=$data->shenhe_jindu(array('ds_id'=>$_REQUEST['ds_id']));
    			
    			if($jindu_dierci['zhuangtai']=='nengjiaru'){ //该被审核用户可以,加入对象
    				
					$shengqing=common_table_yanzheng('DuixiangShenqing', array('ds_id'=>$_REQUEST['ds_id']));//获取 申请加入对象的用户的申请数据
    			
    				//把该用户写入  对象加入表,
	    			common_table_xieru('DuixiangJiaru', array('dx_id'=>$shengqing['dx_id'],'dx_name'=>$shengqing['dx_name'],'user_id'=>$shengqing['user_id'],'dj_time'=>time()));
	    		
	    			//更新 对象申请表  的状态
	    			common_table_gengxin('DuixiangShenqing', array('ds_id'=>$shengqing['ds_id'],'ds_zhuangtai'=>1));
    			
    			}
    			
    			
			 }elseif($_REQUEST['shenhe']=='no'){//不同意审核 
			 
			     	if(!$shenhe){//如果用户以前没有审核过,则新增一条审核
    					common_table_xieru('DuixiangShenhe', array('ds_id'=>$_REQUEST['ds_id'],'user_id'=>session('user_id'),'dsh_time'=>time(),'dsh_zhuangtai'=>0));
    					
    				}else{ //否则只修改,审核时间,和审核状态
    					common_table_gengxin('DuixiangShenhe', array('dsh_id'=>$shenhe['dsh_id'],'dsh_time'=>time(),'dsh_zhuangtai'=>0));
    				}
			 }
		
		
		}
		
 
 

    }
    
    
}