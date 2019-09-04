<?php
session_start();
error_reporting(0);
include "../../koneksi/koneksi.php";
//require 'terbilang.php';


	


	$data   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formijin WHERE IjinId=$_GET[id]"));

	$ID     = $data['IjinId'];
	$NIK    = $data['NIK'];
	

	$sqlURL1 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_services WHERE id=3"));
	$sqlURL2 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_services WHERE id=2"));


	$url 	= $sqlURL1['Url'];
	$url1 	= $sqlURL2['Url'];

/*
	$TglMasuk = date('d-M-Y', strtotime($data['TglMasuk']));

	$dayin = date('N', strtotime($data['TglMasuk']));

	if ($dayin==1){
		$nDayin = 'Senin';
	}
	elseif ($dayin==2){
		$nDayin = 'Selasa';
	}
	elseif ($dayin==3){
		$nDayin = 'Rabu';
	}
	elseif ($dayin==4){
		$nDayin = 'Kamis';
	}
	elseif ($dayin==5){
		$nDayin = 'Jumat';
	}
	elseif ($dayin==6){
		$nDayin = 'Sabtu';
	}
	elseif ($dayin==7){
		$nDayin = 'Minggu';
	}
	else{
		$nDayin = '';
	}

*/

	$profile = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$NIK'"));
	$pt      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_company WHERE iCompanyId='$profile[CompanyId]'"));
	
	if (!is_null($data['TglActive1'])){
		$TglActive1 = date('d-M-Y', strtotime($data['TglActive1']));
		$Pkl1       = 'Pukul: '.date('H:i', strtotime($data['TglActive1'])).' WIB';
	}
	else{
		$TglActive1 = '';
		$Pkl1       = '';
	}


	if (!is_null($data['TglActive2'])){
		$TglActive2 =  date('d-M-Y', strtotime($data['TglActive2']));
		$Pkl2       = 'Pukul: '.date('H:i', strtotime($data['TglActive2'])).' WIB';
	}
	else{
		$TglActive2 = '-';
		$Pkl2       = '';
	}

	

	$jka      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jenisijin WHERE JenisIjinId='$data[JenisIjin]'"));

  
	


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
    
    
<title>Detail Permohonan Ijin - $jka[JenisIjinName]</title>
	</head>
<body>
	<p><strong>Detail Permohonan Ijin - $jka[JenisIjinName]</strong></p>
<table width='550' height='270' border='0' cellpadding=0 cellspacing=0 frame=border rules=rows>  
	
<tr>
    <td width='120' height=18 class=style1>PT.</td>
    <td width='10'><span class=style1>:</span></td>
    <td><span class=style1><strong>$pt[cCompanyName]</strong></span></td>
</tr>
<tr>
    <td width='120' height=18 class=style1>Form Ijin</td>
    <td width='10'><span class=style1>:</span></td>
    <td><span class=style1>$jka[JenisIjinName]</span></td>
</tr>

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
    <td height=18 class=style1>Dari Tanggal</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$TglActive1 $Pkl1</span></td>
</tr>
<tr>
    <td height=18 class=style1>Sampai Tanggal</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$TglActive2 $Pkl2</span></td>
</tr>
<tr>
    <td height=18 class=style1>Alasan</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$data[Alasan]</span></td>
</tr>

	
";

$mail->Body     = $body;
$StatusApproval = 'Perhatian email ini dikirim secara otomatis dari HRIS. Jangan membalas ke alamat ini';




$ApvList = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode='4' AND MatStatus='1'");			

	while ($data = mysql_fetch_array($ApvList)){

	
	$sql      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formijin WHERE IjinId='$ID'"));	
	$no       = $data['MatProses'];
	$Approval = 'NIK'.$no;
	$Apv   	  = $sql['Apv'.$no];
	$Tgl      = $sql['Tgl'.$no];
	$NIKApv   = $sql['NIK'.$no];
	
	if (is_null($Tgl) || $Tgl ==" "){
		$cTgl = '';
	}
	else{
		$cTgl = date('d-M-Y @ H:i', strtotime($Tgl));
	}

	if ($Apv =='A'){
		$cStatus = '- ACCEPTED';
	}
	elseif($Apv =='R'){
		$cStatus = '- REJECTED';
	}
	elseif($Apv =='X'){
		$cStatus = '- CANCELED';
	}
	elseif($Apv =='P'){
		$cStatus = '';
	}
	else{
		$cStatus = '';	
	}
	
	$ProfileName = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$NIKApv'"));
	
			
	$approvallist[$data['MatProses']]="
	
	<tr>
		<td height=18 class=style1>$data[MatName]</td>
		<td><span class=style1>:</span></td>
		<td><span class=style1>$ProfileName[Nama]  $cTgl $cStatus</span></td>   
	</tr>";
	$mail->Body .= $approvallist[$data['MatProses']];
	}
	
	$footer ="	
	</table>
	</br>
	</br>
	<p><font color=#FF0000 size=-1>$StatusApproval</font></p>
	</body>
	</html>";


	$bSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_formijin WHERE IjinId = '$ID'"));
	$NIKEmail 	= $bSQL['NIK'.$proses];
	$aSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$NIKEmail'"));

	// Setting Email **
	$mSet = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_mail_server WHERE Status='1' AND Folder='frmIjin' ORDER BY id DESC LIMIT 1"));
	
	$mail->IsSMTP();
	$mail->Mailer     	= "smtp";
	//$mail->Host       	= "Exc2013-DAG";
	$mail->Port       	= 25;
	//$mail->SMTPSecure   = "tls";		
	$mail->SMTPKeepAlive= true;
	$mail->SMTPAuth     = true;
	//$mail->Port       	= 587;	
	$mail->From         = "system.noreply@unias.com";
	$mail->FromName     = "Human Resource Information System";
	$mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');	

	$to = "$profile[Email]";
	//$to = "dompak.sinambela@unias.com";
	$mail->Body         .= $footer;		
	$mail->AddAddress($to);
	$mail->Subject       = "$mSet[Subject] - $jka[JenisIjinName]";
	$mail->AltBody       = "To view the message, please use an HTML compatible email viewer!"; 	
	$mail->WordWrap      = 80;	
	$mail->IsHTML(true);	
	$mail->Send();	
	
		}
		catch (phpmailerException $e)
		{
		echo $e->errorMessage();
		}	

		
?>