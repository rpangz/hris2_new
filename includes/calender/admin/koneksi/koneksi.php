<?php

$hostName = 'portal';
$userName = 'root';
$passWord = 'asa';
$dataBase = 'Agenda';

mysql_connect($hostName, $userName, $passWord);
mysql_select_db($dataBase);
?>