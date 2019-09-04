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

	mysql_query("UPDATE tbl_formcuti SET Pin      = '$token',
										 ApvLevel = '1' 
										 WHERE CutiId = '$_GET[id]'");



	$data   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId=$_GET[id]"));

	$ID     = $data['CutiId'];
	$MyNIK  = $_GET['mynik'];
	$proses = $_GET['proses'];

	$gw     = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$data[NIKPengganti]'"));

	$sqlURL1 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_services WHERE id=1"));
	$sqlURL2 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_services WHERE id=2"));

	
	


	$url 	= $sqlURL1['Url'];
	$url1 	= $sqlURL2['Url'];


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



	$profile = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$MyNIK'"));
	
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
    
    
<title>Detail Permohonan Cuti</title>
	</head>
<body>
	<p><strong>Detail Permohonan Cuti</strong></p>
<table width='550' height='270' border='0' cellpadding=0 cellspacing=0 frame=border rules=rows>  

	
<tr>
    <td width='120' height=18 class=style1>NIK</td>
    <td width='10'><span class=style1>:</span></td>
    <td><span class=style1>$data[FormCutiNIK]</span></td>
</tr>

<tr>
    <td width='120' height=18 class=style1>Nama</td>
    <td width='10'><span class=style1>:</span></td>
    <td><span class=style1>$profile[Nama]</span></td>
</tr>

<tr>
    <td width='120' height=18 class=style1>Jenis Cuti</td>
    <td width='10'><span class=style1>:</span></td>
    <td><span class=style1>".jenis_cuti($data['JenisCuti'],$data['JenisItemCuti'])."</span></td>
</tr>
	
<tr>
    <td height=18 class=style1>Keperluan</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$data[Keperluan]</span></td>
</tr>
<tr>
    <td height=18 class=style1>Alamat</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$data[Alamat]</span></td>
</tr>
<tr>
    <td height=18 class=style1>No Telepon</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$data[NoTelpon]</span></td>
</tr>	
<tr>
    <td height=18><span class=style1>Petugas Pengganti</span></td>
    <td><span class=style1>:</span></td>
    <td><span class=style4>$gw[Nama]</span></td>
</tr>
	
";

$mail->Body     = $body;
$StatusApproval = 'Klik link dibawah ini untuk proses selanjutnya';

// Tanggal Cuti
$Cuti  = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId=$_GET[id]");
$total = mysql_num_rows($Cuti);


if ($data['JenisItemCuti'] <= 9 && $data['JenisCuti'] !=5){
	$total_cut = mysql_num_rows($Cuti);
	$tgl_cut   = '';
}

elseif($data['JenisCuti'] == 5){

	$total_cut = count_days($_GET['id']);
	$tgl_cut   = active_days($_GET['id']);

}
else{
	$total_cut = count_days($_GET['id']);
	$tgl_cut   = active_days($_GET['id']);
}

$kont1 ="<tr>
    		<td height=18><span class=style1>Jumlah Cuti</span></td>
    		<td><span class=style1>:</span></td>
    		<td><span class=style4>".$total_cut." Hari ".$tgl_cut."</span></td>
		</tr>
		<tr>
			<td rowspan='$total' height=18 class=style1>Tanggal Cuti</td>
			<td rowspan='$total'><span class=style1>:</span></td>";

$mail->Body .= $kont1;


while ($dst = mysql_fetch_array($Cuti)){

	
	$Tgl = date('d-M-Y', strtotime($dst['TglCuti']));
	$day = date('N', strtotime($dst['TglCuti']));

	if ($day==1){
		$nDay = 'Senin';
	}
	elseif ($day==2){
		$nDay = 'Selasa';
	}
	elseif ($day==3){
		$nDay = 'Rabu';
	}
	elseif ($day==4){
		$nDay = 'Kamis';
	}
	elseif ($day==5){
		$nDay = 'Jumat';
	}
	elseif ($day==6){
		$nDay = 'Sabtu';
	}
	elseif ($day==7){
		$nDay = 'Minggu';
	}
	else{
		$nDay = '';
	}

	$MyCuti[$dst['DetailCutiId']]="
	
		<td><span class=style1>$nDay , $Tgl</span></td>   
	</tr>";
	$mail->Body .= $MyCuti[$dst['DetailCutiId']];
	}


$kont2 ="</tr><tr>
    		<td height=18><span class=style1>Tanggal Masuk Kerja</span></td>
    		<td><span class=style1>:</span></td>
    		<td><span class=style4>$nDayin , $TglMasuk</span></td>
		</tr>";

$mail->Body .= $kont2;

	$link1 = $url.'ServicesApproval.php?act=accept&id='.$ID.'&mynik='.$MyNIK.'&token='.$token.'&proses='.$proses;
	$link2 = $url.'ServicesApproval.php?act=reject&id='.$ID.'&mynik='.$MyNIK.'&token='.$token.'&proses='.$proses;
	//$link3 = $url1.'index.php?module=formProgresKasbonInternal&act=detail&id='.$_GET[id].'&gen=1&PRD='.$data[iKBPeriodId].'&proses='.$iNo[iNoProses].'&token='.$token.'&comid='.$_SESSION[CompanyId];


	$ApvList = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode='1' AND MatStatus='1'");		

	while ($data = mysql_fetch_array($ApvList)){

	
	$sql      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId='$ID'"));	
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
	<tr>
		<td height=18 class=style1>Attachment</td>
		<td><span class=style1>:</span></td>
		<td><span class=style1>".files_cuti($_GET['id'])."</span></td>   
	</tr>

	</table>
	</br>
	</br>
		<p><font color=#FF0000 size=-1>$StatusApproval</font></p>	
		<a href='$link1' onClick=window.open('$url/ServicesApproval.php',Ratting,width=550,height=170,0,status=0,);>Accept</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href='$link2' onClick=window.open('$url/ServicesApproval.php',Ratting,width=550,height=170,0,status=0,);>Reject</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</br>
	</br>
	</body>
	</html>";


	$bSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId = '$ID'"));
	$NIKEmail 	= $bSQL['NIK'.$proses];
	$aSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$NIKEmail'"));

	// Setting Email **
	$mSet       = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_mail_server WHERE Status='1' AND Folder='form_cuti' ORDER BY id DESC LIMIT 1"));

	//Setting Basic Email Configuration
	$set_Host       = mysql_fetch_array(mysql_query("SELECT * FROM tbl_main_config WHERE config_id='20'"));
	$set_Port   	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_main_config WHERE config_id='23'"));
	$set_From   	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_main_config WHERE config_id='10'"));
	$set_Username   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_main_config WHERE config_id='21'"));
	$set_Password   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_main_config WHERE config_id='22'"));
	
	$mail->IsSMTP();
	$mail->Mailer     	= "smtp";
	//$mail->Host       	= "$set_Host[value]";
	$mail->Port       	=  $set_Port['value'];
	$mail->SMTPKeepAlive= true;
	$mail->SMTPAuth     = true;
	$mail->Priority     = 1;
	$mail->From         = "$set_From[value]";
	$mail->FromName     = "Human Resource Information System";
	//$mail->Username     = "$set_Username[value]";
	//$mail->Password     = "$set_Password[value]";
	$mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');
	$to = "$aSQL[Email]";
	$mail->Body         .= $footer;		
	$mail->AddAddress($to);
	$mail->Subject       = "$mSet[Subject]";
	$mail->AltBody       = "To view the message, please use an HTML compatible email viewer!"; 	
	$mail->WordWrap      = 80;	
	$mail->IsHTML(true);	
	$mail->Send();	
	
		}
		catch (phpmailerException $e)
		{
		echo $e->errorMessage();
		}

function jenis_cuti($id,$item){

	$sql1 			= mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id=".$id));
	$JenisCuti  	= $sql1['JenisCutiName'];
	$sql2 			= mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti_item WHERE JenisItemCutiId=".$item));
	$JenisItemCuti  = $sql2['JenisItemCutiName'];

	if ($item != 0){
		$add = '('.$JenisItemCuti.')';
	}else{
		$add = '';
	}

	return '<b>'.$JenisCuti.'</b> '.$add;

}

function files_cuti($id){

	$server_publish = '202.153.21.10';

	$file  = mysql_query("SELECT * FROM tbl_formcuti_files WHERE cuti_id='$id'");
	$total = mysql_num_rows($file);
	if ($total > 0){		
		$link = '';
	}else{
		$link = '-';
	}
	while ($data = mysql_fetch_array($file)){
		$link   .= '<a href="http://'.$server_publish.'/hris2/modules/kehadiran/assets/uploads/'.$data['url'].'" target="_blank">'.$data['file_code'].'</a><br/>';
	}

	return $link;

}

function count_days($id){

	$query  = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId='$id'");
	$total  = mysql_num_rows($query);
	$data   = mysql_fetch_array($query);

	$startTimeStamp = strtotime($data['TglActive1']);
	$endTimeStamp   = strtotime($data['TglActive2']);
	$timeDiff 		= abs($endTimeStamp - $startTimeStamp);
	$numberDays 	= $timeDiff/86400;  // 86400 seconds in one day
	$numberDays 	= intval($numberDays+1);

	return $numberDays;

}


function active_days($id){

	$query  = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId='$id'");
	$total  = mysql_num_rows($query);
	$data   = mysql_fetch_array($query);

	$TglActive1   = date('d-M-Y', strtotime($data['TglActive1']));
	$TglActive2   = date('d-M-Y', strtotime($data['TglActive2']));

	return '('.$TglActive1.' s/d '.$TglActive2.')';

}


		
?>