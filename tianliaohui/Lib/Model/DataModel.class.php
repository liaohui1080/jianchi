<?php
/**
 * @author liaohui1080
 * @author 主要是,为前端提供已经格式化好的数据,,供前端使用
 *
 */

class DataModel extends Model{ 

	
	/**
	 * 
	 * @author显示该对象使用过的标签,具体操作是:先调出所有标签,然后拿这些标签,去和标签内容表中 dx_id 是该对象的标签比较,看那些是用过的\n
	 * @access  参数详解  array('dx_id'=>对象id )
	 * 
	 * @return array
	 */
     Public function biaoqian_yongguo($array){ 

		//显示所有标签,直接排序.标签用的越多,排序越靠前
		$biaoqian=common_table_select('Biaoqian',"",array('paixu','desc'));
		//dump($rs_biaoqian);
		
		//把所有标签,和对象已使用标签对比,显示出试用过的标签
		foreach ($biaoqian AS $bq){
			//搜索对象中已经存在的标签,显示认同度最高的一条
			$rs_duixiang_biaoqian=common_table_yanzheng('BiaoqianNeirong',array('dx_id'=>$array['dx_id'],'bq_id'=>$bq['bq_id']),array('paixu','desc'));
			if($rs_duixiang_biaoqian){
				//把标签名字,写入数组
				$rs_duixiang_biaoqian['bq_name']=$bq['bq_name'];
				
				//把标签排序写入数组
				$rs_duixiang_biaoqian['paixu']=$bq['paixu'];
				
				//显示使用的标签,并转换为二维数组
				$rs_biaoqian[]=$rs_duixiang_biaoqian;
			}
		
		}
		//dump($rs_biaoqian);
		
		return $rs_biaoqian;
	} 

	
	
	/**
	 * @author 显示该对象没有使用过的标签,具体操作是:先 查找该对象使用过那些标签,然后再去和 标签表对比,把该对象没有使用过的标签列出来
	 * @access 参数详解   array('dx_id'=>对象id )
	 * @return array
	 */
	public function biaoqian_meiyongguo($array){
		
		
		//显示所有标签,直接排序.标签用的越多,排序越靠前
		$biaoqian=common_table_select('Biaoqian',"",array('paixu','desc'));
		//dump($rs_biaoqian);
		
		//把所有标签,和对象已使用标签对比,显示出没有使用的标签
		foreach ($biaoqian AS $bq){
			//搜索对象中已经存在的标签,和所有标签对比,列出没有试用过的标签
			$rs_duixiang_biaoqian=common_table_yanzheng('BiaoqianNeirong',array('dx_id'=>$array['dx_id'],'bq_id'=>$bq['bq_id']),array('paixu','desc'));
			if(!$rs_duixiang_biaoqian){
			
				//显示没有使用的标签,并转换为二维数组
				$rs_biaoqian[]=$bq;
			}
		
		}
		//dump($rs_biaoqian);
		
		return $rs_biaoqian;
	
	}
	
	
	
	
	
	
	/**
	 * @author 显示当前对象下, 选中标签的所有标签内容
	 * @author 排序按照,认同度排, 认同度越高,排的越高
	 * @access  参数详解  array('dx_id'=>对象id,'bq_id'=>标签id)
	 * @return array()
	 */
	public function biaoqian_neirong($array){
		//获取选中标签id的所有标签内容
		$biaoqian_neirong=common_table_select('BiaoqianNeirong',array('dx_id'=>$array['dx_id'],'bq_id'=>$array['bq_id']),array('paixu','desc'));
		foreach ($biaoqian_neirong AS $bq_nr){
			
			//获取增加此内容的用户名字.注意名字要排序的,把最新的一个名字显示出来
			$user_name=$this->user($bq_nr['user_id']);
			$bq_nr['user_name']=$user_name['user_name'];
			$neirong[]=$bq_nr;
			
		}
		//dump($neirong);
		
		return $neirong;
	}
	

	
	/**
	 * @author 显示一个标签内容下所有的用户态度,并按时间先后排序,最后写的排在最前面
	 * @access 参数详解  array('bn_id'=>标签内容的id,'bt_taidu'=>用户的态度)
	 * @return array()
	 */
	public function biaoqian_neirong_taidu($array){
		//显示所有标签内容的评价
		if($array['bt_taidu']){//显示有态度
		$taidu=common_table_select('BiaoqianTaidu',array("bn_id"=>$array['bn_id'],"bt_taidu"=>$array['bt_taidu']),array('bt_id','desc'));
		}else{//显示所有,包括没有态度的评论
		$taidu=common_table_select('BiaoqianTaidu',array("bn_id"=>$array['bn_id']),array('bt_id','desc'));
		}
		
		foreach ($taidu AS $rs_td){
			
			//获取增加此内容的用户名字.注意名字要排序的,把最新的一个名字显示出来
			$user_name=$this->user($rs_td['user_id']);
			$rs_td['user_name']=$user_name['user_name'];
			//把用户态度的数字值格式化为 汉字
			if($rs_td['bt_taidu']==1){
				
				$rs_td['bt_taidu_hanzi']="认同";
				
			}elseif($rs_td['bt_taidu']==2){
				
				$rs_td['bt_taidu_hanzi']="不认同";
				
			}elseif($rs_td['bt_taidu']==0){
				
				$rs_td['bt_taidu_hanzi']="评论";
			}
			
			
			$rs_taidu[]=$rs_td;
			
		}
		
		//dump($rs_taidu);
		return $rs_taidu;
	}
	
	
	
	
	
	/**
	 * 获取用户的所有基本信息 ( 名字, id email 头像等..)
	 * @access $user_id = 用户的id
	 * @return array()
	 */
	public function user($user_id){
		//获取用户注册的mail
		$array_mail=common_table_yanzheng('User', array('user_id'=>$user_id));
		//dump($array_name);


		//获取用户 名字
		$array_name=common_table_yanzheng('UserName', array('user_id'=>$user_id),array('un_id','desc'));
		//dump($array_name);

		//获取用户头像
		$array_image=common_table_yanzheng('UserImage', array('user_id'=>$user_id),array('ui_id','desc'));
		//如果用户没有头像,则使用默认头像
		if($array_image){
			$user_image=$array_image['ui_image'];
			$user_image=$array_image['ui_image'];
		}else{
			$user_image='moren.png';
		}
		//dump($array_image);

		//获得用户 匿名 帐号的 id
		$array_niming_id=common_table_yanzheng('UserNiming', array('user_id'=>$user_id),array('unm_id','desc'));
		//dump($array_niming_id);


		return array(
		'user_id'=>$user_id,
		'user_mail'=>$array_mail['user_mail'],
		'user_name'=>$array_name['un_name'],
		'user_image'=>$user_image,
		'user_niming_id'=>$array_niming_id['unm_id']
		);
		
	
	}
	
	
	
	
	
	/**
	 * 获取对象名字,排序按照,标签内容认同度最高的那个名字显示出来
	 * @access 参数详解 array('dx_id'=>对象的id)
	 * @return Array  false
	 */
	public function duixiang_name($array){
		
		//获取对象的一些信息
		$duixiang=common_table_yanzheng('Duixiang',array('dx_id'=>$array['dx_id']));
		
		
		//先获取,标签 表里 标签等于 名字 的那个标签 的 id
		$bq_id=common_table_yanzheng('Biaoqian', array('bq_name'=>'名字'));
		if($bq_id){//如果bq_id存在,则说明有名字这个标签
			
			//获取 标签内容 表里,  这个对象的名字,直接排序
			$duixiang_name=common_table_yanzheng('BiaoqianNeirong',array('dx_id'=>$array['dx_id'],'bq_id'=>$bq_id['bq_id']),array('paixu','desc'));
			
			$duixiang_name['duixiang']=$duixiang;//把对象的信息增加到数组里
			
			
			return $duixiang_name;
		}else{
		
			return FALSE;
		}
	
	}
	
	
	
	/**
	 * 加入对象的所有用户,直接带统计数
	 * @access 参数详解$dx_id=对象的id
	 * @return array('zongshu'=>加入这个对象的人的总数 ,'jiaru_user'=>array()加入这个对象的所有人,用数组显示出来 )
	 */
	public function duixiang_yonghu($dx_id){
		
		$duixiang=common_table_select('DuixiangJiaru',array("dx_id"=>$dx_id),array('dj_time','desc'));
		$count=count($duixiang);

		if($duixiang){
			foreach ($duixiang AS $rs_dx){
				//加入该对象的人的 用户信息,
				$user=$this->user($rs_dx['user_id']);
				$rs_dx['user_id']=$user;
				
				
				
				$shuchu[]=$rs_dx;
			}
			return array('count'=>$count,'jiaru_user'=>$shuchu );
			
		}else{
			return FALSE;
		}
	
	}
	
	
	
	
	
	/**
	 * @author 获得正在申请加入这个对象的人数    获得所有 申请加入该对象的人
	 * @author 是这样计算的,你只能审核,在你加入对象之后新加入的人,也就是 对象申请 表里,那些申请加入该对象时间,比你加入对象时间 大于 或者 等于  的人
	 * @access 参数详解 $array = array('dx_id'=>对象的id  , 'user_id'=>用户的id)
	 * @return array('zongshu'=>加入这个对象的人的总数 ,'shengqing_user'=>array()申请加入这个对象的所有人,用数组显示出来 )
	 */
/*	public function duixiang_shenqing_user($array){
		//获取用户成功加入对象时的时间
    	//$jiaru_time=common_table_yanzheng('DuixiangJiaru', array('dx_id'=>$array['dx_id'],'user_id'=>$array['user_id']));
    	
    	

		$shenqing_user= M("DuixiangShenqing");
		$data['dx_id']=$array['dx_id'];
		$data['ds_zhuangtai']=0;
		//$data['ds_time']=array('egt',$jiaru_time['dj_time']);//比你加入对象时间 大于 或者 等于  的人
		
		$rs_shenqing_user=$shenqing_user->where($data)->select();//显示正在申请加入这个对象的所有人
		
		foreach ($rs_shenqing_user AS $rs_sq_user){
			//获取申请加入该对象的人的 用户信息,
			$user=$this->user($rs_sq_user['user_id']);
			$rs_sq_user['user_id']=$user;//把用户信息增加到数组里
			
			
			
			//获取邀请人的 用户信息,如果有邀请人才运行
			if($rs_sq_user['ds_yaoqingren']){
				$yaoqingren=$this->user($rs_sq_user['ds_yaoqingren']);
				$rs_sq_user['ds_yaoqingren']=$yaoqingren;
			}
			
			$shenqing[]=$rs_sq_user;//生成数组
		}
		//dump($shenqing);
		
		
		$count=$shenqing_user->where($data)->count();//显示正在申请加入这个对象的人数
		
		
		return array('count'=>$count,'shenqing_user'=>$shenqing);
	}*/
	
	/**
	 * @author 获得正在申请加入这个对象的人数    获得所有 申请加入该对象的人
	 * @access 参数详解 $array = array('dx_id'=>对象的id)
	 * @return array('zongshu'=>加入这个对象的人的总数 ,'shengqing_user'=>array()申请加入这个对象的所有人,用数组显示出来 )
	 */
	public function duixiang_shenqing_user($array){
		
		$shenqing_user= M("DuixiangShenqing");
		$data['dx_id']=$array['dx_id'];
		$data['ds_zhuangtai']=0;

		
		$rs_shenqing_user=$shenqing_user->where($data)->select();//显示正在申请加入这个对象的所有人
		
		foreach ($rs_shenqing_user AS $rs_sq_user){
			//获取申请加入该对象的人的 用户信息,
			$user=$this->user($rs_sq_user['user_id']);
			$rs_sq_user['user_id']=$user;//把用户信息增加到数组里
			
			
			
			//获取邀请人的 用户信息,如果有邀请人才运行
			if($rs_sq_user['ds_yaoqingren']){
				$yaoqingren=$this->user($rs_sq_user['ds_yaoqingren']);
				$rs_sq_user['ds_yaoqingren']=$yaoqingren;
			}
			
			
			//获取审核进度
			$jindu=$this->shenhe_jindu(array('ds_id'=>$rs_sq_user['ds_id']));
			$rs_sq_user['shenhe_jindu']=$jindu['tishi'];//把审核进度增加到数组里
			
			
			//检索 对象审核 表里是否已经有用户的审核数据,
    		$shenhe=common_table_yanzheng('DuixiangShenhe', array('ds_id'=>$rs_sq_user['ds_id'], 'user_id'=>session('user_id')));
    		if($shenhe){
    			if($shenhe['dsh_zhuangtai']==0){
    				$shenhe_zhuangtai='拒绝';
    			}elseif($shenhe['dsh_zhuangtai']==1){
    				$shenhe_zhuangtai='通过';
    			}
    			$rs_sq_user['duixiang_user_shenhe']=$shenhe_zhuangtai;
    		}else{
    			$rs_sq_user['duixiang_user_shenhe']=false;
    		}
    		
			
			$shenqing[]=$rs_sq_user;//生成数组
		}
		//dump($shenqing);
		
		
		$count=$shenqing_user->where($data)->count();//显示正在申请加入这个对象的人数
		
		
		return array('count'=>$count,'shenqing_user'=>$shenqing);
	}	
	
	
	
	
	/**
	 * @author 检测申请加入这个对象的人的审核进度,就是,看看,还需要多少个人审核通过才能加入对象
	 * @access 参数详解 array('ds_id'=>用户申请加入对象的id---DuixiangShenqing)
	 * @return array('zhuangtai'=>yijiaru(表示,这个用户已经加入了对象)  , nengjiaru(表示,用户已经有资格加入对象了)  ,  dengdai(表示,正在审核中) ,'tishi'=>提示信息,包括剩余人数)
	 */
	public function shenhe_jindu($array){
	
	
    	//获取 对象id,  如果
    	$dx_id=common_table_yanzheng('DuixiangShenqing', array('ds_id'=>$array['ds_id']));
    	
    	//如果 状态 =1 则说明这个用户已经加入了,
    	if($dx_id['ds_zhuangtai']==1){
			return array('zhuangtai'=>'yijiaru','tishi'=>'该用户已经加入这个对象了');
			
    	}else{//如果不等于一 则说明用户还没有加入对象
    		
	    	//获取加入这个对象 的人数
	    	$jiaru_count=zongshu('DuixiangJiaru', array('dx_id'=>$dx_id['dx_id']));
			
	    	//如果对象已加入的人数大于3 则取三分之一的人数,然后小数点以后四舍五入,如果小于3则不进行处理
	    	if($jiaru_count>=3){
	    		$jiaru_count=round($jiaru_count/3);
	    	}
	    	
	    	//获取审核表里 已经同意加入的数据总数
	    	$shenhe_count=zongshu('DuixiangShenhe', array('ds_id'=>$dx_id['ds_id'],'dsh_zhuangtai'=>1));
    		
	    	//获取剩余有审核权限的人数
			$shenhe_renshu=$jiaru_count-$shenhe_count;
			
			//如果人数大于0.则说明审核没有完成
			if ($shenhe_renshu>0){
				return array('zhuangtai'=>'dengdai','tishi'=>$shenhe_renshu);
				
			}elseif ($shenhe_renshu==0){//如果人数等于0.则说明审核已经完成,
			
				return array('zhuangtai'=>'nengjiaru','tishi'=>'该用户可以加入该对象了');
			}


    	
    	}
    	
    	
	} //end shenhe_jindu 
	
	
} //结束 Data class

