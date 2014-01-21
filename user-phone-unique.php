<?php
//============================================
//用于检测 电话 是否唯一是否唯一
//
//
//[[[可控参数]]]
define("__post_interface__",	"phone");										//用于查询的表单项目名称
define("__db_vali_type__",		0);												//填写该验证类型的位置(从零开始)
define("__db_vali_count__",		2);												//填写数据库验证类型的总数
define("__reply_delay__", 		0);												//访问延时,防止查询攻击
define("__name_filter__", 		"/^[0-9]{10,11}$/");	//过滤查询的字符串
//
//[[[返回值设定]]]
define("__return_unique__",			0);				//唯一时的返回值
define("__return_not_unique__",		1);				//不唯一且已经验证时的返回值
define("__return_error__",			3);				//不符合要求时的返回值
//
//============================================
if (isset($_GET[__post_interface__])) {
	if (preg_match(__name_filter__,$_GET[__post_interface__])) {
		sleep(__reply_delay__);
		require("functions.php");
		if (phone_unique($_GET[__post_interface__])) {
			echo __return_not_unique__;
		} else {
			echo __return_unique__;
		}
	}else{
		echo __return_error__;
	}
}else{
	echo __return_error__;
}

?>
