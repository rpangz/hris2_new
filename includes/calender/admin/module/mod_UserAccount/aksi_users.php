<?php
error_reporting(0);
session_start();
include "../../koneksi/koneksi.php";

$module=$_GET[module];
$act=$_GET[act];

// Hapus user
if ($module=='user' AND $act=='hapus'){
	mssql_query("DELETE FROM tblProfileLogin WHERE NIK='$_GET[id]'");
	header('location:../../master.php?module=user');
}

// Input user
elseif ($module=='user' AND $act=='input'){
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
	header('location:../../master.php?module=user');
}

// Update user
elseif ($module=='users' AND $act=='update'){
	
		$pass = md5($_POST[Password]);
		mssql_query("UPDATE tblProfileLogin SET Password = '$pass'                                 
                                 WHERE NIK	 = '$_POST[id]'");
	
	header('location:../../master.php?module=user');
}

// Ubah Password
elseif ($module=='users' AND $act=='password'){
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
		Silahkan Login kembali ke Sistem HRIS.<br>";
			echo "<a href=../../index.php><b>LOGIN</b></a></center>";
		}
	}
}
?>
