<?php
session_start();
error_reporting(0);
include "../../koneksi/koneksi.php";
	

	$data   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId=$_GET[id]"));

	$ID     = $data['FormPerpCutiId'];
	$MyNIK  = $_GET['nik'];

	
	
	$profile = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$MyNIK'"));
	$kcu     = mysql_fetch_array(mysql_query("SELECT * FROM tbl_hakcuti WHERE HakId='$data[HakCutiId]'"));
	

	$Periode1 = date('d-M-Y', strtotime($kcu['Periode1']));
	$Periode2 = date('d-M-Y', strtotime($kcu['Periode2']));


	$jka      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id='$kcu[JenisHakCuti]'"));

    $LimitExp = $jka['LimitExp'];
    $soon     = date('Y-m-d', strtotime($kcu['Periode2']. ' + '.$LimitExp));
    $soon2    = date('d-M-Y', strtotime($soon));

	mysql_query("UPDATE tbl_hakcuti SET PeriodeExt = '$soon' WHERE HakId = '$data[HakCutiId]'");


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
    
    
<title>Detail Permohonan Perpanjangan Sisa Cuti</title>
	</head>
<body>
	<p><strong>Detail Permohonan Perpanjangan Sisa Cuti</strong></p>
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

	
";

$mail->Body     = $body;
$StatusApproval = 'Klik link dibawah ini untuk proses selanjutnya';





$ApvList = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode='4' AND MatStatus='1'");		

	while ($data = mysql_fetch_array($ApvList)){

	
	$sql      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId='$ID'"));	
	$no       = $data['MatProses'];
	$Approval = 'NIK'.$no;
	$Apv   	  = $sql['Apv'.$no];
	$Tgl      = $sql['Tgl'.$no];
	$NIK      = $sql['NIK'.$no];
	
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
	
	$ProfileName = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$NIK'"));
	
			
	$approvallist[$data['MatProses']]="
	
	<tr>
		<td height=18 class=style1>$data[MatName]</td>
		<td><span class=style1>:</span></td>
		<td><span class=style1>$ProfileName[Nama], $cTgl $cStatus</span></td>   
	</tr>";
	$mail->Body .= $approvallist[$data['MatProses']];
	}
	
	$footer ="	
	</table>
	</br>
	</br>
	<p><font color=#FF0000 size=-1>Perhatian email ini dikirim secara otomatis dari HRIS. Jangan membalas ke alamat ini</font></p>	
	</body>
	</html>";


	$bSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId = '$ID'"));
	$aSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$MyNIK'"));

	// Setting Email **
	
	$mail->IsSMTP();
    $mail->Mailer       = "smtp";
    $mail->Host         = "Exc2013-DAG";
    $mail->Port         = 25;
    //$mail->SMTPSecure   = "tls";        
    $mail->SMTPKeepAlive= true;
    $mail->SMTPAuth     = true;
	//$mail->Port       	= 587; 
    $mail->From         = "system.noreply@unias.com";
    $mail->FromName     = "Human Resource Information System";
    $mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');    
    $to = "dompak.sinambela@unias.com";
	//$to = "$aSQL[Email]";
	$mail->Body         .= $footer;		
    $mail->AddAddress($to);
    $mail->Subject       = "Perpanjangan Sisa Cuti";
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