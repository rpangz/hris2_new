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

	mysql_query("UPDATE tbl_formperpcuti SET Pin  = '$token', 
											 ApvLevel = '1' 
											 WHERE FormPerpCutiId = '$_GET[id]'");



	$data   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId=$_GET[id]"));

	$ID     = $data['FormPerpCutiId'];
	$MyNIK  = $_GET['mynik'];
	$proses = $_GET['proses'];

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

	$profile = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$MyNIK'"));
	$kcu     = mysql_fetch_array(mysql_query("SELECT * FROM tbl_hakcuti WHERE HakId='$data[HakCutiId]'"));

	$Periode1 = date('d-M-Y', strtotime($kcu['Periode1']));
	$Periode2 = date('d-M-Y', strtotime($kcu['Periode2']));


	$jka      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id='$kcu[JenisHakCuti]'"));

    $LimitExp = $jka['LimitExp'];
    $soon     = date('Y-m-d', strtotime($kcu['Periode2']. ' + '.$LimitExp));
    $soon2    = date('d-M-Y', strtotime($soon));

	
/*
	$tag = mysql_fetch_array(mysql_query("SELECT * FROM tbl_stock WHERE iStokID='$data[iStokIDTag]'"));
	$sta = mysql_fetch_array(mysql_query("SELECT * FROM tbl_prob_status WHERE prob_status_id='$data[prob_status]'"));
	$typ = mysql_fetch_array(mysql_query("SELECT * FROM tbl_prob_type WHERE prob_type_id='$data[prob_type]'"));
	$res = mysql_fetch_array(mysql_query("SELECT * FROM tbl_main_user WHERE user_id='$data[ResponsibilityBy]'"));
	
	$view= mysql_fetch_array(mysql_query("SELECT * FROM tbl_stock LEFT JOIN 
                      tbl_item ON tbl_stock.iStokItem = tbl_item.iItemID LEFT JOIN 
                      tbl_type ON tbl_stock.iStokType = tbl_type.iTypeID LEFT JOIN
                      tbl_trans ON tbl_stock.iStokID = tbl_trans.itransStokId 
					  WHERE iStokID='$data[iStokIDTag]' ORDER BY dTransOutDate DESC LIMIT 0 , 1 "));

*/

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




	$link1 = $url.'ServicesApproval.php?act=accept&id='.$ID.'&mynik='.$MyNIK.'&token='.$token.'&proses='.$proses;
	$link2 = $url.'ServicesApproval.php?act=reject&id='.$ID.'&mynik='.$MyNIK.'&token='.$token.'&proses='.$proses;
	//$link3 = $url1.'index.php?module=formProgresKasbonInternal&act=detail&id='.$_GET[id].'&gen=1&PRD='.$data[iKBPeriodId].'&proses='.$iNo[iNoProses].'&token='.$token.'&comid='.$_SESSION[CompanyId];


$ApvList = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode='2' AND MatStatus='1' ");		

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
	<p><font color=#FF0000 size=-1>$StatusApproval</font></p>	
	<a href='$link1' onClick=window.open('$url/ServicesApproval.php',Ratting,width=550,height=170,0,status=0,);>Accept</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href='$link2' onClick=window.open('$url/ServicesApproval.php',Ratting,width=550,height=170,0,status=0,);>Reject</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</body>
	</html>";


	$bSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId = '$ID'"));
	$NIKEmail 	= $bSQL['NIK'.$proses];
	$aSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$NIKEmail'"));

	// Setting Email **
	$mSet = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_mail_server WHERE cStatus='1' AND cFolder='frmPerpCuti' ORDER BY id DESC LIMIT 1"));
	
	$mail->Mailer        = "smtp";
	$mail->Port          = $mSet['cPort'];
	$mail->IsSMTP();	
	$mail->SMTPKeepAlive = True;                    
	$mail->Host          = "$mSet[cHost]";	
	$mail->From          = "$mSet[cFrom]";
	$mail->FromName      = "$mSet[cFromName]";	
	$mail->SMTPAuth      = True;
	//$mail->Port       	= 587;
	//$to = "dompak.sinambela@unias.com";
	$to = "$aSQL[Email]";
	$mail->Body         .= $footer;		
	$mail->AddAddress($to);
	$mail->Subject       = "$mSet[cSubject]";
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