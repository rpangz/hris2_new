<?php
session_start();
error_reporting(0);
include "../../koneksi/koneksi.php";


	$data   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=$_GET[id]"));
	$NIK  	= $data['NIK'];
	$Nama	= $data['Nama'];
	$CompanyId = $data['CompanyId'];
	
	if ($CompanyId ==2){
		$hrd_company = 2;
	}
	else {
		$hrd_company = 1;
	}
	
$ss = mysql_query("SELECT * FROM tbl_apv_hrd WHERE hrd_status=1 AND hrd_company='$hrd_company' ORDER BY hrd_nik ASC");

while ($rom = mysql_fetch_array($ss)){
	

	require_once 'class.phpmailer.php';	

	try {

	$mail = new PHPMailer(true);

	$body =
	'<html>
	<head>
	<style type=text/css>
	.style1 {font-size: 13px}
	.style4 {font-size: 13px; font-style: normal; }

	.bigcell {
    position: relative;
    width: 100px;
    height: 50px;
    border: thin dotted gray;
	}

	.strikeout {
	position: absolute;
	height: 0px;
	width: 179px;
	background-color: black;
	top: 146px;
	visibility: inherit;
	}
	.style7 {font-size: 13px; font-weight: bold; }
	table { border: thin black solid; } /* or other border styles */
    </style>
    
    
<title>Detail Perubahan Data Profile Karyawan</title>
	</head>
<body>
	<p>Kepada YTH: '.$rom['hrd_name'].$_SESSION['Sex2'].'</p>
	<p><strong>Detail Perubahan Data Profile Karyawan</strong></p>
	<table width="550" border="1" cellspacing="1" cellpadding="1" frame="border" rules="rows">
  <tr>
    <th bgcolor="#CCCCCC" scope="col">Data Profil</th>
    <th bgcolor="#CCCCCC" width="200" scope="col">Before</th>
    <th bgcolor="#CCCCCC" width="200" scope="col">After</th>
  </tr>
  <tr>
    <th width="150" scope="row"><div align="right">NIK :</div></th>
    <td>'.$data['NIK'].'</td>
    <td>'.$data['NIK'].'</td>
  </tr>
  <tr>
    <th scope="row"><div align="right">Nama :</div></th>
    <td>'.$data['Nama'].'</td>
    <td>'.$data['Nama'].'</td>
  </tr>
  <tr>
    <th scope="row"><div align="right">No KTP :</div></th>
    <td>'.$data['NoKTP'].'</td>
    <td>'.$data['NoKTP'].'</td>
  </tr>
  <tr>
    <th scope="row"><div align="right">Tgl KTP :</div></th>
    <td>'.$data['TglKTP'].'</td>
    <td>'.$data['TglKTP'].'</td>
  </tr>
  <tr>
    <th scope="row"><div align="right">Alamat :</div></th>
    <td>'.$data['Alamat'].'</td>
    <td>'.$data['Alamat'].'</td>
  </tr>
  <tr>
    <th scope="row"><div align="right">No Telpon :</div></th>
    <td>'.$data['NoTelpon'].'</td>
    <td>'.$data['NoTelpon'].'</td>
  </tr>
  <tr>
    <th scope="row"><div align="right">Agama :</div></th>
    <td>'.$data['Agama'].'</td>
    <td>'.$data['Agama'].'</td>
  </tr>
</table>
	</br>
	</br>
	<p><font color=#FF0000 size=-1>Perhatian email ini dikirim secara otomatis dari HRIS. Jangan membalas ke alamat ini</font></p>
	</body>
	</html>';
$mail->Body     = $body;
	
	
	$mail->IsSMTP();
	$mail->Mailer     	= "smtp";
	$mail->Host       	= "astmail02-mbx2.unias.com";
	$mail->Port       	= 25;
	//$mail->SMTPSecure   = "tls";		
	$mail->SMTPKeepAlive= true;
	$mail->SMTPAuth     = true;
	//$mail->Port       	= 587;	
	$mail->From         = "system.noreply@unias.com";
	$mail->FromName     = "Human Resource Information System";
	$mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');
	$to = "$rom[hrd_email]";
	$mail->AddAddress($to);
	$mail->Subject       = "Perubahan Data Profile $data[Nama]";
	$mail->AltBody       = "To view the message, please use an HTML compatible email viewer!"; 	
	$mail->WordWrap      = 80;	
	$mail->IsHTML(true);	
	$mail->Send();	
	
		}
		catch (phpmailerException $e)
		{
		echo $e->errorMessage();
		}	

}
		
?>