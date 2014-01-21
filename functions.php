<?php
//============================================
//用于链接数据库
//
//[[[可控参数]]]
define("__db_username__", 		"testaccount");					//数据库登录用户名
define("__db_password__", 		"D4S5L4q9fuLTLexf");			//数据库登录密码
define("__db_host__", 			"localhost");					//数据库主机位置
define("__db_name__",	 		"openstaple_test");				//数据库名称
define("__db_charset__", 		"utf8");						//字符样式
define("__db_sort_charset__", 	"utf8_general_ci");				//整理
//
//============================================
function create_db_connection(){

	$handle = mysql_connect(__db_host__,__db_username__,__db_password__);
	mysql_select_db(__db_name__, $handle);
	mysql_query("SET NAMES ".__db_charset__); 
	mysql_query("SET CHARACTER SET ".__db_charset__);
	mysql_query("SET COLLATION_CONNECTION='".__db_sort_charset__."'");
	return $handle;

}

function destory_db_connection($handle){

	mysql_close($handle);

}

function pre_str($string){

	return addslashes($string);

}

function email_unique($data){
	$connection	=	create_db_connection();
	$sql		=	"SELECT `user_email` FROM `mc_users` WHERE `user_email`='".$data."' LIMIT 1";
	$query		=	mysql_query($sql);
	$row		=	mysql_fetch_array($query);
	if (isset($row["user_email"])) {
		$result	=	1;
	} else {
		$result	=	0;
	}
	destory_db_connection($connection);
	return $result;
}

function name_unique($data){
	$connection	=	create_db_connection();
	$sql		=	"SELECT `user_name` FROM `mc_users` WHERE `user_name`='".$data."' LIMIT 1";
	$query		=	mysql_query($sql);
	$row		=	mysql_fetch_array($query);
	if (isset($row["user_name"])) {
		$result	=	1;
	} else {
		$result	=	0;
	}
	destory_db_connection($connection);
	return $result;
}

function phone_unique($data){
	$connection	=	create_db_connection();
	$sql		=	"SELECT `user_phone` FROM `mc_users` WHERE `user_phone`='".$data."' LIMIT 1";
	$query		=	mysql_query($sql);
	$row		=	mysql_fetch_array($query);
	if (isset($row["user_phone"])) {
		$result	=	1;
	} else {
		$result	=	0;
	}
	destory_db_connection($connection);
	return $result;

}

?>