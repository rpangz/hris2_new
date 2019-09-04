<?php

error_reporting(0);
session_start();
include "../../koneksi/koneksi.php";
//$aksi = "module/mod_users/aksi_users.php";
	switch($_GET[act]){
		// Tampil User
		default:

		echo "<h2>Edit Password</h2>
				<form method=POST action='$aksi?module=users&act=password'>
				<table class='tftablein' border='0'>
					<input type='hidden' name='NIK' value='$_SESSION[NIK]'>
					<tr><td>Password</div></td><td> : <input type='password' name='PasswordLama'></td></tr>
					<tr><td>Password Baru</div></td><td> : <input type='password' name='PasswordBaru'></td></tr>
					<tr><td>Re-type Password Baru</div></td><td> : <input type='password' name='PasswordBaru2'></td></tr>
					<tr><td colspan=2><input type=submit value='   Save   '>&nbsp;&nbsp;&nbsp;
					<input type=button value='  Cancel  ' onclick=self.history.back()></td></tr>
				</table>
				</form>";
	break;
	
	
	case "hapus":
	mssql_query("DELETE FROM tblProfileLogin WHERE NIK='$_GET[id]'");
	echo"<script>window.location ='http://portal/askes/master.php?module=users';</script>";
	break;
	
	case "update":
	$pass = md5($_POST[Password]);
		mssql_query("UPDATE tblProfileLogin SET Password = '$pass'                                 
                                 WHERE NIK	 = '$_POST[id]'");
	
echo"<script>window.location ='http://portal/askes/master.php?module=users';</script>";
	
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
	echo"<script>window.location ='http://portal/askes/master.php?module=users';</script>";
	
	break;
	
	case "password":
	$id = $_POST[NIK];
	$passwordLama = md5($_POST[PasswordLama]);
	$passwordBaru = md5($_POST[PasswordBaru]);
	$passwordBaru2 = md5($_POST[PasswordBaru2]);
	
	$data = mssql_fetch_array(mssql_query("SELECT * FROM tblProfileLogin WHERE NIK = '$id'"));
	if (empty($passwordLama) || empty($passwordBaru) || empty($passwordBaru2)){
		echo "Mohon isikan semua kolom<br><a href=javascript:history.go(-1)><b>Ulangi Lagi</b>";
	}
	else{
		if ($passwordLama != $data[Password]){
			echo "Password Lama Anda salah<br><a href=javascript:history.go(-1)><b>Ulangi Lagi</b>";
		}
		elseif ($passwordBaru != $passwordBaru2){
			echo "Password Baru dan Re-Type Password Baru tidak Cocok<br><a href=javascript:history.go(-1)><b>Ulangi Lagi</b>";
		}
		else {
			mssql_query("UPDATE tblProfileLogin SET Password = '$passwordBaru' WHERE NIK = '$id'");
			echo "<link href=../../css/login.css rel=stylesheet type=text/css>";
			echo "<center>Password Anda Berhasil dirubah! <br> 
		Silahkan Login kembali...<br>";
			echo "<a href='http://portal/askes/index.php'><b>LOGIN</b></a></center>";
		}
	}
	break;
	
}

?>
