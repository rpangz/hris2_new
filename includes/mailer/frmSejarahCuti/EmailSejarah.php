<?php
session_start();
error_reporting(0);
include "../../koneksi/koneksi.php";
//require 'terbilang.php';


	//---------------------------------------------------------------------------------//
	$alphaNumeric  = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	$random = substr(str_shuffle($alphaNumeric), 0, 7);	
	$textColor = imagecolorallocate ($image, 0, 0, 0);
	imagestring ($image, 5, 5, 8,  $random, $textColor); 
	$token= md5($random);
	//---------------------------------------------------------------------------------//



	$data   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=$_GET[nik]"));

	$NIK     = $data['NIK'];
	

	$sqlURL1 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_services WHERE id=3"));
	$sqlURL2 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_services WHERE id=2"));


	$url 	= $sqlURL1['Url'];
	$url1 	= $sqlURL2['Url'];


	$profile = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$NIK'"));
	$kcu     = mysql_fetch_array(mysql_query("SELECT * FROM tbl_hakcuti WHERE HakId='$data[HakCutiId]'"));

	$Periode1 = date('d-M-Y', strtotime($kcu['Periode1']));
	$Periode2 = date('d-M-Y', strtotime($kcu['Periode2']));


	$jka      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id='$kcu[JenisHakCuti]'"));

    $LimitExp = $jka['LimitExp'];
    $soon     = date('Y-m-d', strtotime($kcu['Periode2']. ' + '.$LimitExp));
    $soon2    = date('d-M-Y', strtotime($soon));

	


	require_once 'class.phpmailer.php';	

	try {

	$mail = new PHPMailer(true);

	$body =
	"<html>
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
    
    
<title>Detail Sejarah Cuti</title>
	</head>
<body>
	<p><strong>Detail Sejarah Cuti</strong></p>
<table width='550' height='270' border='0' cellpadding=0 cellspacing=0 frame=border rules=rows>  
	
<tr>
    <td width='120' height=18 class=style1>NIK</td>
    <td width='10'><span class=style1>:</span></td>
    <td><span class=style1>$data[NIK]</span></td>
</tr>

<tr>
    <td width='120' height=18 class=style1>Nama</td>
    <td width='10'><span class=style1>:</span></td>
    <td><span class=style1>$profile[Nama]</span></td>
</tr>
	
<tr>
    <td height=18 class=style1>Periode Cuti</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$Periode1 s/d $Periode2</span></td>
</tr>
<tr>
    <td height=18 class=style1>Diperpanjang Sampai</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$soon2</span></td>
</tr>

	</table>
	</br>
	</br>
	<p><font color=#FF0000 size=-1>$StatusApproval</font></p>	
	<a href='$link1' onClick=window.open('$url/ServicesApproval.php',Ratting,width=550,height=170,0,status=0,);>Accept</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href='$link2' onClick=window.open('$url/ServicesApproval.php',Ratting,width=550,height=170,0,status=0,);>Reject</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</body>
	</html>";
	
	$mail->Body     = $body;
	$StatusApproval = 'Klik link dibawah ini untuk proses selanjutnya';

	$bSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId = '$ID'"));
	$NIKEmail 	= $bSQL['NIK'.$proses];
	$aSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$NIKEmail'"));

	// Setting Email **
	$mSet = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_mail_server WHERE Status='1' AND Folder='frmCuti' ORDER BY id DESC LIMIT 1"));
	
	$mail->IsSMTP();
	$mail->Mailer     	= "smtp";
	$mail->Host       	= "Exc2013-DAG";
	$mail->Port       	= 25;
	//$mail->SMTPSecure   = "tls";		
	$mail->SMTPKeepAlive= true;
	$mail->SMTPAuth     = true;
	//$mail->Port       	= 587;	
	$mail->From         = "system.noreply@unias.com";
	$mail->FromName     = "Human Resource Information System";
	$mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');
	$to = "dompak.sinambela@unias.com";
	//$to = "$aSQL[Email]";
	$mail->AddAddress($to);
	$mail->Subject       = "Sejarah Cuti";
	$mail->AltBody       = "To view the message, please use an HTML compatible email viewer!"; 	
	$mail->WordWrap      = 80;	
	$mail->IsHTML(true);	
	$mail->Send();	
	
		}
		catch (phpmailerException $e)
		{
		echo $e->errorMessage();
		}	

		echo"<script type='text/javascript'>alert('Email Sudah Dikirim... Click OK to close window');window.open('', '_self', '');window.close();</script>";
		
?>