<?php
/**
 * 标签操作页面
 * 新增标签
 * 
 * 新增标签内容
 *
 */


class BiaoqianAction extends Action {
	
	//显示所有标签
	public function index(){
		include 'url.php';

		
		$data =  new DataModel();	//实例化数据层,用于给页面提供数据 
		$rs_biaoqian=$data->biaoqian_meiyongguo(array('dx_id'=>$_REQUEST['dx_id'] ));//显示对象没有使用的标签
		$this->rs_biaoqian=$rs_biaoqian;//把数组赋值给模版
		
		
		$this->dx_id=$_REQUEST['dx_id'];//把对象id 增加到 数组中
		
		
		
		//显示所有属性
		$rs_shuxing=common_table_select('BiaoqianShuxing');
		$this->rs_shuxing=$rs_shuxing;
		//dump($rs_shuxing);
		
		$this->display();
	}
	
	

	
	
	//新增标签内容
	public function xinzeng_neirong(){
		include 'url.php';
		
		//显示标签数据
		$rs_biaoqian=common_table_yanzheng('ShituBiaoqianShuxing',array('bq_id'=>$_REQUEST['bq_id']));
		//dump($rs_biaoqian);
		$this->rs_biaoqian=$rs_biaoqian;
		$this->dx_id=$_REQUEST['dx_id'];
		
		$this->display();
	}

	
	//新增标签内容验证页面
	public  function xinzeng_neirong_yanzheng(){
		include 'url.php';
		
		//验证用户输入标签内容的格式,是否符合标签属性
		$array_jiance=common_jiance_geshi($_REQUEST['bn_neirong'],array('geshi'=>$_REQUEST['bq_shuxing']));
    	if ($array_jiance['zhuangtai']==FALSE){
    		$this->ajaxReturn(" ",$array_jiance['tishi'],0);
    	}else{
    		
    		
    		//判断标签内容里,该对象是否已经包含这个标签了,如果包含了, 使用数就不加一了,如果是第一次使用,标签的使用数加一
			$cunzai=common_table_yanzheng('BiaoqianNeirong', array('dx_id'=>$_REQUEST['dx_id'],'bq_id'=>$_REQUEST['bq_id']));
			//dump($cunzai);
			if(!$cunzai){

				//这是为标签的使用数 加一
				gengxin_paixu('Biaoqian',array('zhujian_name'=>'bq_id','id'=>$_REQUEST['bq_id'],'ziduan'=>'paixu', 'jiajian'=>'jia') );//加一
			}
	    		

    		//向数据库,写入新的标签内容
    		common_table_xieru('BiaoqianNeirong', array('dx_id'=>$_REQUEST['dx_id'],'bq_id'=>$_REQUEST['bq_id'],'bn_neirong'=>$_REQUEST['bn_neirong'],'user_id'=>session('user_id'),'bn_time'=>time()));

    		$this->ajaxReturn('','成功',1);
    	}
		
	
	}

	
	

	
	/**
	 * 增加 标签 验证页面
	 */
	public function xinzeng_biaoqian_yanzheng(){
		include 'url.php';
		
		//判断是否选择了标签属性
		if(!$_REQUEST['bs_id']){
			//$this->success("请选择属性");
			$this->ajaxReturn('','请选择属性',0);
			exit();
		}
		
		//判断是否 输入了标签名字
		$changdu=common_jiance_changdu($_REQUEST['bq_name'], array('changdu_zuida'=>100,'changdu_zuixiao'=>1));
		if(!$changdu){
			//$this->success("标签名字不能为空");
			$this->ajaxReturn('','标签名字不能为空,也不能大于 100个字符',0);
			exit();
		}
		
		
		//判断此标签是否存在
		$cunzai=common_table_yanzheng('Biaoqian', array('bq_name'=>$_REQUEST['bq_name']));
		//dump($cunzai);
		if($cunzai){
			$this->ajaxReturn('','该标签已存在',0);
			exit();
		}
		
		//写入新标签
		common_table_xieru("Biaoqian", array('bs_id'=>$_REQUEST['bs_id'],'bq_name'=>$_REQUEST['bq_name'],'user_id'=>session('user_id'),'bq_time'=>time()));
		//$this->success("增加成功");
		$this->ajaxReturn('','增加成功',1);

	}
	
	
	
	/**
	 * 显示一个标签的,所有标签内容 ,并且在同一个对象下面
	 */
	public function biaoqian_neirong(){
		include 'url.php';

		//显示当前选中标签的数据,把数据赋值给表单,用来新曾标签内容时用
		$rs_biaoqian=common_table_yanzheng('ShituBiaoqianShuxing',array('bq_id'=>$_REQUEST['bq_id']));
		//dump($rs_biaoqian);
		$this->rs_biaoqian=$rs_biaoqian;
		$this->dx_id=$_REQUEST['dx_id'];
		
		
		//显示当前对象下, 选中标签的所有标签内容
		$data=new DataModel();
		$biaoqian_neirong=$data->biaoqian_neirong(array('dx_id'=>$_REQUEST['dx_id'],'bq_id'=>$_REQUEST['bq_id']) );
		$this->biaoqian_neirong=$biaoqian_neirong;
		
		
		
		$this->display();
	}
	
	
	
	/**
	 * 标签内容的态度显示页面 ,认同或者不认同
	 */
	public function biaoqian_taidu(){
		include 'url.php';
		$this->bn_id=$_REQUEST['bn_id'];//标签内容id
		$this->taidu=$_REQUEST['taidu'];//获取用户的评价态度
		
		
		//显示该标签内容的,所有用户态度
		$data= new DataModel();
		$rs_taidu=$data->biaoqian_neirong_taidu(array('bn_id'=>$_REQUEST['bn_id'],'bt_taidu'=>$_REQUEST['taidu']));

		$this->rs_taidu=$rs_taidu;
		
		$this->display();
	}
	
	
	/**
	 * 标签内容的态度,验证页面
	 */
	public function biaoqian_taidu_yanzheng(){
		include 'url.php';
		
		//验证标签内容评论的值是否为空
		$pinglun_jiance=common_jiance_changdu($_REQUEST['bt_pinglun'],  array('changdu_zuida'=>'500','changdu_zuixiao'=>'2')); 
		if(!$pinglun_jiance){
			$this->ajaxReturn('','评论内容不能为空,也不能小于2个字符',0);
			exit();
		}
		
		
		//每个用户只能对一条内容,发表一个态度(认同或者不认同),发表不限制的评论
		if($_REQUEST['bt_taidu']){//如果用户态度存在,则检测用户是否,已经表过态,没有的话,可以表态,如果有了则只能评论不能表态
			
			//如果表里的,用户 id存在 ,并且此条标签内容的id 也存在,并且 ,态度不是0 的话,说明用户表过态了
			$user_taidu=D('BiaoqianTaidu');
			$data[user_id]=session('user_id');
			$data[bn_id]=$_REQUEST['bn_id'];
			$data[bt_taidu]=array( 'neq' ,0);
			$rs_taidu=$user_taidu->where($data)->find();
			
			if($rs_taidu){
				$this->ajaxReturn('','你已经对这条内容表过态度了,你现在只能评论了',0);
				exit();
			}
		}
		
		
		//更新标签内容表的paixv字段,如果用户认同 则加一,如果用户不认同则减一,评论不算
		if($_REQUEST['bt_taidu']==1){
			gengxin_paixu('BiaoqianNeirong',array('zhujian_name'=>'bn_id','id'=>$_REQUEST['bn_id'],'ziduan'=>'paixu', 'jiajian'=>'jia') );//加一
		}
		
		if($_REQUEST['bt_taidu']==2){
			gengxin_paixu('BiaoqianNeirong',array('zhujian_name'=>'bn_id','id'=>$_REQUEST['bn_id'],'ziduan'=>'paixu', 'jiajian'=>'jian') );//减一
			
		}
		
		
		//向数据库写入,用户对标签内容的评价和态度
		$zhuangtai=common_table_xieru('BiaoqianTaidu',array('bn_id'=>$_REQUEST['bn_id'],'user_id'=>session('user_id'),'bt_pinglun'=>$_REQUEST['bt_pinglun'],'bt_taidu'=>$_REQUEST['bt_taidu'],'bt_time'=>time()));
		if($zhuangtai){
			$this->ajaxReturn('','成功',1);
		}else{
			$this->ajaxReturn('','失败了',0);
		}
	
	}
}