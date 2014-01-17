<?php
//============================================
//用于检测电子邮箱地址是否唯一是否唯一
//
//[[[可控参数]]]
define("__post_interface__",	"email");										//用于查询的表单项目名称
define("__db_vali_type__",		0);												//填写该验证类型的位置(从零开始)
define("__db_vali_count__",		2);												//填写数据库验证类型的总数
define("__reply_delay__", 		0);												//访问延时,防止查询攻击
define("__name_filter__", 		"/^[0-9a-z][a-z0-9\._-]{1,}@[a-z0-9-]{1,}[a-z0-9]\.[a-z\.]{1,}[a-z]$/");	//过滤查询的字符串
//
//[[[返回值设定]]]
define("__return_unique__",			0);				//唯一时的返回值
define("__return_not_unique__",		1);				//不唯一且已经验证时的返回值
define("__return_invalidated__",	2);				//不唯一但尚未验证邮箱时的返回值
define("__return_error__",			3);				//不符合要求时的返回值
//
//============================================
if (isset($_GET[__post_interface__])) {
	if (preg_match(__name_filter__,$_GET[__post_interface__])) {
		sleep(__reply_delay__);
		require("database-connections.php");
		$connection	=	create_db_connection();
		$sql		=	"SELECT `user_email`,`user_validate` FROM `mc_users` WHERE `user_email`='".$_GET[__post_interface__]."' LIMIT 1";
		$result		=	mysql_query($sql);
		$row		=	mysql_fetch_array($result);
		if (isset($row["user_email"])) {
			$validate = str_pad( decbin($row["user_validate"]), __db_vali_count__, "0", STR_PAD_LEFT);
			if ($validate[__db_vali_type__] == "0") {
				echo __return_invalidated__;
			} else {
			    echo __return_not_unique__;
			}
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
