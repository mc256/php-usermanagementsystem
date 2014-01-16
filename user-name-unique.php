<?php
//============================================
//用于检测用户名是否唯一
//
//[[[可控参数]]]
define("__post_interface__",	"username");									//用于查询的表单项目名称
define("__reply_delay__", 		0);												//访问延时,防止查询攻击
define("__name_filter__", 		"/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_\.]{5,20}$/u");	//过滤查询的字符串
//
//[[[返回值设定]]]
define("__return_unique__",		0);				//唯一时的返回值
define("__return_not_unique__",	1);				//不唯一时的返回值
define("__return_error__",		2);				//不符合要求时的返回值
//
//============================================
if (isset($_POST[__post_interface__])) {
	if (preg_match(__name_filter__,$_POST[__post_interface__])) {
		sleep(__reply_delay__);
		require("database-connections.php");
		$connection	=	create_db_connection();
		$sql		=	"SELECT `user_name` FROM `mc_users` WHERE `user_name`='".$_POST[__post_interface__]."' LIMIT 1";
		$result		=	mysql_query($sql);
		$row		=	mysql_fetch_array($result);
		if (isset($row["user_name"])) {
			echo __return_not_unique__;
		} else {
			echo __return_unique__;
		}
		destory_db_connection($connection);	
	}else{
		echo __return_error__;
	}
}else{
	echo __return_error__;
}

?>
