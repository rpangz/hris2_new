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

	mysql_query("UPDATE tbl_formijin SET Pin  = '$token', 
											 ApvLevel = '1' 
											 WHERE IjinId = '$_GET[id]'");



	$data   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formijin WHERE IjinId=$_GET[id]"));

	$ID     = $data['IjinId'];
	$MyNIK  = $data['NIK'];
	$proses = $_GET['proses'];

	$sqlURL1 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_services WHERE id=4"));
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
$StatusApproval = 'Klik link dibawah ini untuk proses selanjutnya';




	$link1 = $url.'ServicesApproval.php?act=accept&id='.$ID.'&mynik='.$MyNIK.'&token='.$token.'&proses='.$proses;
	$link2 = $url.'ServicesApproval.php?act=reject&id='.$ID.'&mynik='.$MyNIK.'&token='.$token.'&proses='.$proses;
	//$link3 = $url1.'index.php?module=formProgresKasbonInternal&act=detail&id='.$_GET[id].'&gen=1&PRD='.$data[iKBPeriodId].'&proses='.$iNo[iNoProses].'&token='.$token.'&comid='.$_SESSION[CompanyId];


$ApvList = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode='4' AND MatStatus='1' ");		

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
	<a href='$link1' onClick=window.open('$url/ServicesApproval.php',Ratting,width=550,height=170,0,status=0,);>Accept</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href='$link2' onClick=window.open('$url/ServicesApproval.php',Ratting,width=550,height=170,0,status=0,);>Reject</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</body>
	</html>";


	$bSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_formijin WHERE IjinId = '$ID'"));
	$NIKEmail 	= $bSQL['NIK'.$proses];
	$aSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$NIKEmail'"));

	

	// Setting Email **
	$mSet = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_mail_server WHERE Status='1' AND Folder='frmIjin' ORDER BY id DESC LIMIT 1"));
	
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

	$to = "$aSQL[Email]";
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