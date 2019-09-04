<?php
include "htdocs/db_connect.php";

//session_start();
	
switch($_GET[act]){
//+-----------------------------------------------------------+
//		Untuk menampilkan Member Asuransi Kesehatan
//+-----------------------------------------------------------+
	

default:

$edit = mysql_query("SELECT * FROM tblAgenda WHERE id='$_GET[id]'");
$data= mysql_fetch_array($edit);


echo"<table width=100%><b>Topik :</b></br>
$data[Topik]";
echo"<hr width=100%></table>";

echo"<table width=100%><b>Konten :</b></br>
$data[Isi]
<hr width=100%></table>";


break;
		
}
?>
