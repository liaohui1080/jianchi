<?php
class ShengshixianAction extends Action {
	
	//省市县  首页
	public function index(){
		common_zidong();
		
		$this->display();
	}
	
	
	
	//ajax 显示省页面
	public function sheng(){
		common_zidong();
		$array_sheng=common_table_select("Sheng");
		$this->array_sheng=$array_sheng;
		$this->display();
	}

	//ajax 显示市页面
	public function shi(){
		common_zidong();
		$array_shi=common_table_select("Shi",array('sheng_id'=>$_REQUEST['sheng_id']));
		$this->array_shi=$array_shi;
		$this->display();
	}
	
	//ajax 显示县页面
	public function xian(){
		common_zidong();
		$array_xian=common_table_select("Xian",array('shi_id'=>$_REQUEST['shi_id']));
		$this->array_xian=$array_xian;
		$this->display();
	}
	
}