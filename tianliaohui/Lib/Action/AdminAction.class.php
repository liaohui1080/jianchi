<?php
/**
 * 管理页面
 *
 */


class AdminAction extends Action {
	
	//管理   的 页面url
	public function url(){
		header("Content-Type:text/html; charset=utf-8");//字符集
		
		//检测cookie是否存在
    	$array_cookie=common_jiance_cookie();
       	//dump($array_cookie);
    	if(!$array_cookie){
    		$this->jumpUrl='index';
    		$this->error('请重新登录');
    	}
		
		
		
		$this->shuxing='__URL__/shuxing'; //标签属性显示页面
		$this->shuxing_yanzheng='__URL__/shuxing_yanzheng'; //标签熟悉 验证页面
		
		$this->biaoqian='__URL__/biaoqian'; //增加新标签
		$this->biaoqian_yanzheng='__URL__/biaoqian_yanzheng'; //增加新标签验证页面
	}
	
	
	//管理首页
	public function index(){
		$this->url();	
		

		
		$this->display();
	}
	
	
	//属性显示页面
	public function shuxing(){
		$this->url();
		
		//显示所有属性
		$rs_shuxing=common_table_select('BiaoqianShuxing');
		$this->rs_shuxing=$rs_shuxing;
		//dump($rs_shuxing);
		
		$this->display();
	}
	
	/**
	 * 属性增加验证
	 */
	public function shuxing_yanzheng(){
		$this->url();
		$changdu=common_jiance_changdu($_REQUEST['bs_name'], array('changdu_zuida'=>20,'changdu_zuixiao'=>1));
		if($changdu){
			common_table_xieru("BiaoqianShuxing", array('bs_name'=>$_REQUEST['bs_name'], 'bs_time'=>time()));
			
			$this->success("增加成功");
		}else{
			$this->success("不能为空");
		}
	}
	
	
	
	/**
	 * 增加新标签显示页面
	 */
	public function biaoqian(){
		$this->url();
		
		//显示所有标签
		$rs_biaoqian=common_table_select('Biaoqian');
		//dump($rs_biaoqian);
		$this->rs_biaoqian=$rs_biaoqian;
		
		
		//显示所有属性
		$rs_shuxing=common_table_select('BiaoqianShuxing');
		$this->rs_shuxing=$rs_shuxing;
		//dump($rs_shuxing);
		
		$this->display();
	}
	
	
	/**
	 * 属性增加验证
	 */
	public function biaoqian_yanzheng(){
		$this->url();
		
		//判断是否选择了标签熟悉
		if(!$_REQUEST['bs_id']){
			$this->success("请选择属性");
			exit();
		}
		
		//判断是否 输入了标签名字
		$changdu=common_jiance_changdu($_REQUEST['bq_name'], array('changdu_zuida'=>20,'changdu_zuixiao'=>1));
		if(!$changdu){
			$this->success("标签名字不能为空");
			exit();
		}
		
		
		//写入新标签
		$zhuangtai=common_table_xieru("Biaoqian", array('bs_id'=>$_REQUEST['bs_id'],'bq_name'=>$_REQUEST['bq_name'],'user_id'=>session('user_id'),'bq_time'=>time()));
		if($zhuangtai){
			$this->success("增加成功");
		}else{
			$this->success("失败");
		}

	}

}