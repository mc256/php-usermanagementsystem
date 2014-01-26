<?php
//============================================
//各项组件设定
//
//[数据库]
define("__db_username__", 		"testaccount");					//数据库登录用户名
define("__db_password__", 		"D4S5L4q9fuLTLexf");			//数据库登录密码
define("__db_host__", 			"localhost");					//数据库主机位置
define("__db_name__",	 		"openstaple_test");				//数据库名称
define("__db_charset__", 		"utf8");						//字符样式
define("__db_sort_charset__", 	"utf8_general_ci");				//整理
//
//[安全密匙]
define("__secret_A__",			"i*(&d5f4e6w&(5yd");			//用于加密网站密码,一旦设定请勿随意更改
define("__secret_B__",			"as4d6e6i#%111>ad");			//用于加密网站密码,一旦设定请勿随意更改
define("__secret_C__",			"ags4wetigiow4d!d");			//用于COOKIE用户登录加密（长时间）
define("__secret_D__",			"apoigln89GKUWdfd");			//用于COOKIE用户登录加密（短时间）
define("__secret_E__",			"SADQEiglSUWdGDDd");			//用于COOKIE用户登录加密（Cookie 名称）
define("__cookie_prefix__",		"mc_key_");						//用于COOKIE前缀
//
//[有效时间]
define("__keeplogin_long__",	1814400);						//记住密码的最长时间 3周
define("__keeplogin_short__", 	3600);							//用户活跃登录最长时间 1小时
//
//[COOKIE输入保护]
define("__cookie_name_filter__", 	"/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_\.]{5,20}$/u");	//过滤查询的字符串
define("__cookie_data_filter__", 	"/^(1|0)\|[0-9a-f]{32}$/");	//过滤查询的字符串
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

function prepare_password($raw){
	return md5($raw.__secret_A__).md5($raw.__secret_B__);

}

function confirm_user($username,$password){
	$connection	=	create_db_connection();
	$sql		=	"SELECT `user_name`,`user_password` FROM `mc_users` WHERE `user_name`='".$username."' LIMIT 1";
	$query		=	mysql_query($sql);
	$row		=	mysql_fetch_array($query);
	if (isset($row["user_name"])&&$row["user_password"]==prepare_password($password)) {
		$result	=	0;
	} else {
		$result	=	1;
	}
	destory_db_connection($connection);
	return $result;

}


function update_login_status($username,$password,$method){
	$time		=	time();
	$connection	=	create_db_connection();

	if ($method) {
		$validate	=	$time+__keeplogin_long__;
		$cookie_key	=	md5(prepare_password($password).$time.__secret_C__);
	} else {
		$validate	=	$time+__keeplogin_short__;
		$cookie_key	=	md5(prepare_password($password).$time.__secret_D__);
	}

	$sql			=	"UPDATE `mc_users` SET `user_validate` = '".$validate."' WHERE `user_name`='".$username."'";
	$cookie_name	=	__cookie_prefix__.substr(md5($username.__secret_E__), 0, 8);
	$cookie_title	=	__cookie_prefix__."master";
	$cookie_value	=	$method."|".$cookie_key;

	$query			=	mysql_query($sql);
	$result			=	mysql_affected_rows();

	destory_db_connection($connection);
	setcookie($cookie_name, $cookie_value, $validate);
	setcookie($cookie_title, $username, $validate);

	return $result;

}

function confirm_rights(){
	$cookie_title	=	__cookie_prefix__."master";
	if (isset($_COOKIE[$cookie_title])&&preg_match(__cookie_name_filter__,$_COOKIE[$cookie_title])){//验证第一个COOKIE，确定用户名
		$cookie_name	=	__cookie_prefix__.substr(md5($_COOKIE[$cookie_title].__secret_E__), 0, 8);
		if (isset($_COOKIE[$cookie_name])&&preg_match(__cookie_data_filter__, $_COOKIE[$cookie_name])){//获取第二个COOKIE，确定用户信息
			return true;//未完工
		} else {
			return false;
		}
	}else{
		return false;
	}
}


?>