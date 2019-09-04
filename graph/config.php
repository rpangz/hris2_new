<?php

	//defined('ROOT') or die('');
	
	define('db_host','172.17.0.17');
	define('db_user','root');
	define('db_pass','asa');
	define('db_name','candralabdb');
	
	mysql_connect(db_host,db_user,db_pass);
	mysql_select_db(db_name);
	
?>
