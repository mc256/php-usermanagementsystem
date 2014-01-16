<?php

define("__db_username__", 		"testaccount");
define("__db_password__", 		"D4S5L4q9fuLTLexf");
define("__db_host__", 			"localhost");
define("__db_name__", 		"openstaple_test");

define("__db_charset__"), "utf8");
define("__db_sort_charset__"), "utf8_general_ci");

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




?>