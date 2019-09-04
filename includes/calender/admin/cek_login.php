<?php

error_reporting(0);
include "koneksi/koneksi.php";
function antiinjection($data){
	$filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
	return $filter_sql;
}

$User = antiinjection($_POST[User]);
$pass     = antiinjection(md5($_POST[Password]));

$login = mysql_query("SELECT * FROM tblprofilelogin WHERE User='$User' AND Password='$pass' AND Aktif='Y'");
$ketemu= mysql_num_rows($login);
$r = mysql_fetch_array($login);

// Apabila username dan password ditemukan
if ($ketemu > 0){
	session_start();
	session_register("User");
	session_register("Nama");
	session_register("Password");
	session_register("WebRoleId");
	
	$_SESSION[id]			= $r[id];
	$_SESSION[User]     	= $r[User];
	$_SESSION[Nama]  		= $r[Nama];
	$_SESSION[Password]     = $r[Password];
	$_SESSION[WebRoleId]    = $r[WebRoleId];
  
	header('location: master.php?module=home');
	
}

else{
	//echo "$pass";
	echo "<link href=../css/login.css rel=stylesheet type=text/css>";
	echo "<center>LOGIN GAGAL! <br> 
        Username atau Password Anda tidak benar.<br>";
	echo "<a href=index.php><b>ULANGI LAGI</b></a></center>";
}

?>