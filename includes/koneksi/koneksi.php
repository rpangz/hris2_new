<?php

/*
$hostName = '172.17.0.16';
$userName = 'operator';
$passWord = '$M15.apps@admin16';
$dataBase = 'hris2';
*/

$hostName = '172.17.2.249';
$userName = 'root';
$passWord = '';
$dataBase = 'hris2';




mysql_connect($hostName, $userName, $passWord);
mysql_select_db($dataBase);

?>