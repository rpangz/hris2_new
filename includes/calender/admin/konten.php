<?php
session_start();
include "koneksi/koneksi.php";
//include "fungsi/fungsi_indotgl.php";
include "fungsi/library.php";
include "fungsi/fungsi_indotgl.php";
include "fungsi/fungsi_combobox.php";
include "fungsi/class_paging.php";


$module=$_GET[module];
$act=$_GET[act];

if ($_GET[module]=='home'){


$jam=date("H");
$detik=date("i");
if ($jam >= 00 && $jam <=11 && $detik >= 0){
	$salam='Pagi';
	}
if ($jam >= 11 && $jam <=15 && $detik >= 0){
	$salam='Siang';
	}
if ($jam >= 15 && $jam <=18 && $detik >= 0){
	$salam='Sore';
	}
if ($jam >= 18 && $jam <=24 && $detik >= 0){
	$salam='Malam';
	}
	


//$WebRole=mysql_fetch_array(mysql_query("SELECT * FROM tbWebRoleName WHERE WebRoleId='$_SESSION[AppWebRoleId]'"));
  echo "<h2>Selamat $salam, <b>$_SESSION[Nama]</b></h2>
		 </p> <font size=-1>Anda berada di halaman <b>Aplikasi Penjadwalan Agenda</b><br></font>";
		 
		echo"&nbsp;</br></p>";
		
		//include "bca.php";
        
		echo"<p align=right>Login : $hari_ini, ";
  echo tgl_indo(date("Y m d")); 
  echo " | "; 
  echo date("H:i:s");
  echo"&nbsp;</br>"; 

}


elseif ($_GET[module]=='frmAgenda'){
	include "module/mod_frmAgenda/frmAgenda.php";
}


elseif ($_GET[module]=='setPassword'){
	include "module/mod_setPassword/setPassword.php";
}
elseif ($_GET[module]=='listPKBApproval'){
	include "module/mod_listPKBApproval/listPKBApproval.php";
}

elseif ($_GET[module]=='UserAccount'){
	include "module/mod_UserAccount/UserAccount.php";
}

elseif ($_GET[module]=='frmHoliday'){
	include "module/mod_frmHoliday/frmHoliday.php";
}

else{
	echo "<p><b>Modul Tidak Ditemukan</b></p>";
}

?>