<?php
session_start();
error_reporting(0);
include "../../koneksi/koneksi.php";
//require 'terbilang.php';


	

	$data   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId=$_GET[id]"));

	$ID     = $data['CutiId'];
	$MyNIK  = $data['FormCutiNIK'];
	$proses = 3;
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

	$res      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_hakcuti WHERE HakId='$data[HakCutiId]'"));

	$reson    = mysql_query("SELECT * FROM tbl_hakcuti WHERE NIK='$MyNIK' AND JenisHakCuti =1 ORDER BY HakId DESC LIMIT 1");
	$ota      = mysql_num_rows($reson);
	$owa      = mysql_fetch_array($reson);

	if ($ota >0){

	$deon1          = strtotime($owa['Periode1']);
	$deon2          = strtotime($owa['Periode2']);

	$Periode1 		= date('d M Y',strtotime('+1 year',$deon1));
	$Periode2 		= date('d M Y',strtotime('+1 year',$deon2));
	
	}else{

	$TglMasuk       = strtotime($profile['TglMasuk']);

	$Periode1 		= date('d M Y',strtotime('+1 year',$TglMasuk));
	$ode2 		    = date('Y-m-d',strtotime('+2 year',$TglMasuk));
	$odeode2        = strtotime($ode2);
	$Periode2 		= date('d M Y',strtotime('-1 day',$odeode2));
	$PeriodeKerja1 	= date('Y-m-d',strtotime($profile['TglMasuk']));
	$PeriKerja2 	= date('Y-m-d',strtotime('+1 year',$TglMasuk));
	$periperi       = strtotime($PeriKerja2);
	$PeriodeKerja2 	= date('Y-m-d',strtotime('-1 day',$periperi));


	}

	

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
    <td height=18 class=style1>Periode Pengambilan Cuti</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>Utang Cuti Untuk Periode $Periode1 s/d $Periode2</span></td>
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
    <td height=18><span class=style1>Pengganti</span></td>
    <td><span class=style1>:</span></td>
    <td><span class=style4>$gw[Nama]</span></td>
</tr>
	
";

$mail->Body     = $body;
$StatusApproval = 'Proses Approval Sudah Selesai';

// Tanggal Cuti
$Cuti  = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId=$_GET[id]");
$total = mysql_num_rows($Cuti);

$kont1 ="<tr>
    		<td height=18><span class=style1>Jumlah Cuti</span></td>
    		<td><span class=style1>:</span></td>
    		<td><span class=style4>$total Hari</span></td>
		</tr>
		<tr>
			<td rowspan='$total' height=18 class=style1>Tanggal Cuti</td>
			<td rowspan='$total'><span class=style1>:</span></td>";

$mail->Body .= $kont1;

//$NIKEmail = 'NIK'.$proses;


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



$ApvList = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode='1' AND MatStatus='1' AND companyID='1'");		

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
	</table>
	</br>
	</br>
	<p><font color=#FF0000 size=-1>$StatusApproval</font></p>	
	</br>
	</br>
	</body>
	</html>";


	$bSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId = '$ID'"));
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
	$to = "$profile[Email]";
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

		
?>