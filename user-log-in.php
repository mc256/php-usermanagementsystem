<?php
//============================================
//使用者登录
//
//[[[可控参数]]]
define("__post_interface_username__",	"username");							//用于查询的表单项目名称
define("__post_interface_password__",	"password");							
define("__reply_delay__", 		0);												//访问延时,防止查询攻击
define("__username_filter__", 	"/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_\.]{5,20}$/u");	//过滤查询的字符串
define("__password_filter__", 	"/^[0-9a-zA-Z\!\_\+\-\,\.\/\;\|\:]{8,25}$/");	//过滤查询的字符串
//
//[[[返回值设定]]]
define("__return_correct__",		0);				//唯一时的返回值
define("__return_error__",			2);				//不符合要求时的返回值
//
//============================================
if (isset($_GET[__post_interface_username__])&&
	isset($_GET[__post_interface_password__])) {
	if (preg_match(__username_filter__,$_GET[__post_interface_username__])&&
		preg_match(__password_filter__,$_GET[__post_interface_password__])) {
		sleep(__reply_delay__);
		require("functions.php");
		if (confirm_user($_GET[__post_interface_username__],$_GET[__post_interface_password__])) {
			echo __return_error__;
		} else {
			echo __return_correct__;
		}
	}else{
		echo __return_error__;
	}
}else{
	echo __return_error__;
}

?>
