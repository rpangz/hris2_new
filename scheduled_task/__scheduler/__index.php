<?php
session_start();
error_reporting(0);
include "../koneksi/koneksi.php";
//require 'terbilang.php';

$today 		= date ("d-M-Y H:i");
$target 	= date ("Y-m-d H:i:s");
$DueDate	= date ('Y-m-d H:i:s', strtotime('+10 day'));		
	

//$recive 	="SELECT tbl_receiver.NIK AS NIK,tbl_receiver.Name AS Name,tbl_receiver.Email AS Email FROM tbl_scheduler 
//			INNER JOIN tbl_scheduler_receiver ON tbl_scheduler.scheduler_id = tbl_scheduler_receiver.scheduler_id
//			INNER JOIN tbl_receiver ON tbl_scheduler_receiver.NIK = tbl_receiver.NIK
//			WHERE tbl_scheduler.scheduler_id =2";

//$rows_data = mysql_query($recive);

//while ($dad = mysql_fetch_array($rows_data)){
	
	

	
	$query 	="SELECT * FROM tbl_scheduler WHERE scheduler_id=2)";
			
	$sql 	= mysql_query($query);
	$total 	= mysql_num_rows($sql);
	$data   = mysql_fetch_array($sql);

	
if ($total > 0){	
	require_once 'class.phpmailer.php';	

	try {

	$mail = new PHPMailer(true);

	

	$body =
	"<html>
		<head>
			<style type=text/css>
			.style1 {font-size: 12px}
			.style4 {font-size: 12px; font-style: italic; }

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
			
			table { border: thin black solid;
					font-size:12px;} /* or other border styles */
			</style>			
			<title>Integreted Reminder System</title>
			</head>
	
	<body>
			<p>Kepada YTH: $dad[Name] </p>
			<p><strong>List KKWT Yang akan Habis Masa Berlaku</strong></p>
			<p><strong>Tanggal: $today</strong></p>
			<table border=1 cellpadding=0 cellspacing=0 frame=border rules=rows>		
			<th><div align='center'>No</div></th>
			<th><div align='center'>NIK</div></th>
			<th><div align='center'>Nama</div></th>
			<th><div align='center'>ID</div></th>
			<th><div align='center'>KKWT Name</div></th>
			<th><div align='center'>Tgl Batas Masa Berlaku</div></th>
	</body>

	</html>";	
	
	$mail->Body       = $body; 

	$mail->Mailer     = "smtp";
	$mail->Port       = 110;
	$mail->IsSMTP();	
	$mail->SMTPKeepAlive = true;
	$mail->Port       = 25;                    
	$mail->Host       = "172.17.0.2";	
	$mail->From       = "system.noreply@unias.com";
	$mail->FromName   = "Integreted Reminder Services";
	//$to = "dompak.sinambela@unias.com";
	//$to= "$dad[Email]";
	//$mail->Body .= $footer;	
	$mail->AddAddress($to);
	$mail->Subject    = "Test";
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 	
	$mail->WordWrap   = 80;	
	$mail->IsHTML(true);	
	$mail->Send();	
	
		}
		catch (phpmailerException $e)
		{
		echo $e->errorMessage();
		}	
}

//}	

?>