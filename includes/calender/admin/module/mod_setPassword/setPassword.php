<?php

error_reporting(0);
session_start();
include "../../koneksi/koneksi.php";



	switch($_GET[act]){
	
		default:

		echo "		
				<table width=100%>
				<b>Ganti Password</b><hr width=100%>				
				</table>
				
				<form method=POST action='?module=setPassword&act=password'>
				<table id='tablekonten' height='76'>
					<input type='hidden' name='User' value='$_SESSION[User]'>
					<input type='hidden' name='id' value='$_SESSION[id]'>
					<tr><td>Password</td><td>:</td><td><input type='password' name='PasswordLama' size=50></td></tr>
					<tr><td>Password Baru</td><td>:</td><td><input type='password' name='PasswordBaru' size=50></td></tr>
					<tr><td>Re-type Password Baru</td><td>:</td><td><input type='password' name='PasswordBaru2' size=50></td></tr></table>";
		
		echo "<tr><td><input type='submit' value='  Save  '>&nbsp;&nbsp;&nbsp;<input type=button value=' Cancel ' onclick=\"window.location.href='?module=setPassword';\"></div></td></tr>
          </form>";
					
				
	break;
	
	
	case "hapus":
	mssql_query("DELETE FROM tblProfileLogin WHERE NIK='$_GET[id]'");
	echo"<script>window.location ='http://portal/kasbon/master.php?module=setting';</script>";
	break;
	
	case "update":
	$pass = md5($_POST[Password]);
		mssql_query("UPDATE tblProfileLogin SET Password = '$pass'                                 
                                 WHERE NIK	 = '$_POST[id]'");
	
echo"<script>window.location ='http://portal/kasbon/master.php?module=setting';</script>";
	
	break;
	
	case "input":
	$pass = md5($_POST[Password]);
	mssql_query("INSERT INTO tblProfileLogin(NIK,
								   Password,
								   Nama,
								   Email)								   
								    
							VALUES('$_POST[NIK]',
								   '$pass',
								   '$_POST[Name]',
								   '$_POST[Email]',
								   '$_POST[Ponsel]',
								   '$_POST[Position]',
								   '$_POST[Level]')");
	echo"<script>window.location ='http://portal/kasbon/master.php?module=setting';</script>";
	
	break;
	
//----------------------------------------------------------------------------------------------------//
	case "password":
	include "../../koneksi/koneksi.php";
	$id = $_POST[id];
	$User = $_POST[User];
	
	$passwordLama = md5($_POST[PasswordLama]);
	$passwordBaru = md5($_POST[PasswordBaru]);
	$passwordBaru2 = md5($_POST[PasswordBaru2]);
	
	$data = mysql_fetch_array(mysql_query("SELECT * FROM tblprofilelogin WHERE User = '$User'"));
	
	if (empty($passwordLama) || empty($passwordBaru) || empty($passwordBaru2)){
		//echo "Mohon isikan semua kolom<br><a href=javascript:history.go(-1)><b>Ulangi Lagi</b>";
		echo "<script language='javascript'>alert('Mohon isikan semua kolom, Ulangi Lagi');history.go(-1);</script>";
	}
	else{
		if ($passwordLama != $data[Password]){
			echo "<script language='javascript'>alert('Password Lama Anda salah, Ulangi Lagi');history.go(-1);</script>";
			//echo "Password Lama Anda salah<br><a href=javascript:history.go(-1)><b>Ulangi Lagi</b>";
		}
		elseif ($passwordBaru != $passwordBaru2){
			echo "<script language='javascript'>alert('Password Baru dan Re-Type Password Baru tidak Cocok, Ulangi Lagi');history.go(-1);</script>";
			//echo "Password Baru dan Re-Type Password Baru tidak Cocok<br><a href=javascript:history.go(-1)><b>Ulangi Lagi</b>";
		}
		else {
			mysql_query("UPDATE tblprofilelogin SET Password = '$passwordBaru' WHERE User = '$User'");
			echo "<link href=../../css/login.css rel=stylesheet type=text/css>";
			echo "<center>Password Anda Berhasil dirubah! <br>Silahkan Login kembali...<br>";
			echo "<a href='http://202.153.21.4/Calender/admin/index.php'><b>LOGIN</b></a></center>";
		}
	}
	break;
	
}

?>
