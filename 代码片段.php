<?php

		//将数组转换为一维数组
		foreach ($rs_biaoqian AS $value){
			$zhuanhuan_biaoqian[]=$value['bq_id'];
		}

				
		//去除数组里重复的数据
		foreach ($sosuo_xianshi AS $value){
			$zhuanhuan_array[]=$value['da_biaoshi'];
			$yiwei_array=array_unique($zhuanhuan_array);//去除重复的数据
		}
		//把不重复的数组,转换成二维数组
		foreach ($yiwei_array AS $key=>$value){
		
			//echo $yiwei_array[$key]."<br>";
			$erwei_array[]=array("da_biaoshi"=>$yiwei_array[$key]);
		}