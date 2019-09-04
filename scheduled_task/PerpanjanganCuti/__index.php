<?php
session_start();
error_reporting(0);
include "../koneksi/koneksi.php";
//require 'terbilang.php';

$query1 	= "SELECT * FROM tbl_scheduler WHERE scheduler_id=1 AND scheduler_konten=0 AND scheduler_status=1";			
$sql1 		= mysql_query($query1);
$total1 	= mysql_num_rows($sql1);
$wap        = mysql_fetch_array($sql1);
$time_ku    = mysql_fetch_array(mysql_query("SELECT * FROM tbl_interval WHERE interval_id=$wap[scheduler_begin]"));
$time_mu    = mysql_fetch_array(mysql_query("SELECT * FROM tbl_interval WHERE interval_id=$wap[scheduler_repeat]"));



$today 		= date ("Y-m-d H:i:s");

$target 	= $wap['scheduler_start'];
$init		= $time_ku['interval_name'];
//$Begin  	= date ('Y-m-d H:i:s', strtotime('- '.$init));
$Begin  	= date ('Y-m-d H:i:s', strtotime('- '.$init));
$soon 		= date ('Y-m-d H:i:s', strtotime('+ '.$init));
$Begini  	= date ('d-M-Y H:i:s', strtotime($Begin));
//$DueDate	= date ('Y-m-d H:i:s', strtotime('+10 day'));		
$interval	= $time_mu['interval_name'];

$input 		= strtotime("$wap[scheduler_lastrun]");

$Repeat 	= date("Y-m-d H:i:s", strtotime("+$interval", $input));

echo "today= $today | target=$target | begin=$Begin | interval= $interval | input= $input | repeat= $Repeat | Scheduler Begin Before= $init | Kemudian=$soon ";



if ($target <= $Begin && is_null($wap['scheduler_lastrun'])){

$recive 	="SELECT tbl_receiver.NIK AS NIK,tbl_receiver.Name AS Name,tbl_receiver.Email AS Email FROM tbl_scheduler 
			INNER JOIN tbl_scheduler_receiver ON tbl_scheduler.scheduler_id = tbl_scheduler_receiver.scheduler_id
			INNER JOIN tbl_receiver ON tbl_scheduler_receiver.NIK = tbl_receiver.NIK
			WHERE tbl_scheduler.scheduler_id=1";

$rows_data = mysql_query($recive);

while ($dad = mysql_fetch_array($rows_data)){
	
	//$query ="SELECT  MAX( tbl_kkwt.KKWTId ) AS ID, tbl_p3k.NIK AS NIK, tbl_kkwt.KKWT_Date2 AS KKWT_Date2 FROM tbl_p3k LEFT JOIN tbl_kkwt ON tbl_p3k.NIK = tbl_kkwt.NIK 
		//	WHERE tbl_kkwt.KKWT_Date2 >= '$DueDate' GROUP BY tbl_kkwt.NIK ORDER BY tbl_kkwt.KKWTId DESC LIMIT 1";
	
	$query 	="SELECT * FROM tbl_kkwt WHERE KKWTId IN (SELECT MAX( KKWTId ) FROM tbl_kkwt 
			  WHERE active_id =1 AND KKWT_Date2 <= '$soon' 
			  GROUP BY NIK ORDER BY KKWT_Date2 ASC)";
			
	$sql 	= mysql_query($query);
	$total 	= mysql_num_rows($sql);
	
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
			<title>Integrated Reminder Services (IRIS)</title>
			</head>
	
	<body>
			
			<p><strong>List KKWT Yang akan Habis Masa Berlaku +/- $init</strong></p>
			<p><strong>Tanggal: $today</strong></p>
			<table border=1 cellpadding=2 cellspacing=0 frame=border rules=rows>		
			<th><div align='center'>No</div></th>
			<th><div align='center'>NIK</div></th>
			<th><div align='center'>Nama</div></th>
			<th><div align='center'>ID</div></th>
			<th><div align='center'>KKWT Name</div></th>
			<th><div align='center'>Tgl Batas Masa Berlaku</div></th>					
			</tr>";
		
	$mail->Body = $body; 	
			
	$no	 =1;
while ($data = mysql_fetch_array($sql)){	
	$qry 	= "SELECT * FROM tbl_p3k WHERE NIK=$data[NIK]";
	$qws	= mysql_query($qry);
	$row	= mysql_fetch_array($qws);	
	$NIK	= $data['NIK'];			
	if ($no%2==0){$Vcolor="bgcolor='#FFFFFF'";}else{$Vcolor="bgcolor='#F5F5F5'";}
	//$Expire			= date('d-M-Y', strtotime($data['KKWT_Date2']));
	$Date2	= date('d-M-Y', strtotime($data['KKWT_Date2']));
	
	$konten[$NIK]	="<tr>
								<td $Vcolor><div align='center'>$no</div></td>
								<td $Vcolor><div align='left'>$data[NIK]</div></td>
								<td $Vcolor><div align='left'><a href=http://astapp02/reminder/p3k/frmKKWT/index/edit/$data[KKWTId]>$row[Name]</a></div></td>
								<td $Vcolor><div align='right'>$data[KKWTId]</div></td>
								<td $Vcolor><div align='left'>$data[KKWT_Name]</div></td>
								<td $Vcolor><div align='left'>$Date2</div></td>								
							</tr>";
	$mail->Body .= $konten[$NIK];	
	$no++;
		
	
	}
	
	$footer ="	
	</table>
	</br>
	</br>
	<p><font color=#FF0000 size=-1>Perhatian email ini dikirim secara otomatis dari Integrated Reminder Services (IRIS). Jangan membalas ke alamat ini</font></p>	
	</body>
	</html>";	
	
	

	$mail->IsSMTP();
	$mail->Mailer     	= "smtp";
	$mail->Host       	= "astelmail.unias.com";
	$mail->Port       	= 25;
	$mail->SMTPSecure   = "tls";		
	$mail->SMTPKeepAlive= true;
	$mail->SMTPAuth     = true;             
	$mail->From         = "system.noreply@unias.com";
	$mail->FromName     = "Integrated Reminder Services (IRIS)";
	$mail->SetFrom('system.noreply@unias.com', 'Integrated Reminder Services (IRIS)');
	$to  = "$dad[Email]";
	$mail->Body .= $footer;	
	$mail->AddAddress($to);
	$mail->Subject    = "$wap[scheduler_subject]";
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

}	

mysql_query("UPDATE tbl_scheduler SET scheduler_lastrun = '$Begin' WHERE scheduler_id = 1");

}


// Step II

elseif ($today >= $Repeat &&  !is_null($wap[scheduler_lastrun])){

$recive 	="SELECT tbl_receiver.NIK AS NIK,tbl_receiver.Name AS Name,tbl_receiver.Email AS Email FROM tbl_scheduler 
			INNER JOIN tbl_scheduler_receiver ON tbl_scheduler.scheduler_id = tbl_scheduler_receiver.scheduler_id
			INNER JOIN tbl_receiver ON tbl_scheduler_receiver.NIK = tbl_receiver.NIK
			WHERE tbl_scheduler.scheduler_id=1";

$rows_data = mysql_query($recive);

while ($dad = mysql_fetch_array($rows_data)){
	
	//$query ="SELECT  MAX( tbl_kkwt.KKWTId ) AS ID, tbl_p3k.NIK AS NIK, tbl_kkwt.KKWT_Date2 AS KKWT_Date2 FROM tbl_p3k LEFT JOIN tbl_kkwt ON tbl_p3k.NIK = tbl_kkwt.NIK 
		//	WHERE tbl_kkwt.KKWT_Date2 >= '$DueDate' GROUP BY tbl_kkwt.NIK ORDER BY tbl_kkwt.KKWTId DESC LIMIT 1";
	

	
	$query 	="SELECT * FROM tbl_kkwt WHERE KKWTId IN (SELECT MAX(KKWTId) FROM tbl_kkwt 
			  WHERE active_id =1 AND KKWT_Date2 <= '$soon' 
			  GROUP BY NIK ORDER BY KKWT_Date2 ASC)";
			
			
	$sql 	= mysql_query($query);
	$total 	= mysql_num_rows($sql);
	
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
			
			table { width:40%;
					border: thin black solid;
					font-size:12px;}

					 /* or other border styles */
			</style>			
			<title>Integrated Reminder Services (IRIS)</title>
			</head>
	
	<body>
			<p>Kepada YTH: $dad[Name] </p>
			<p><strong>List KKWT Yang akan Habis Masa Berlaku +/- $init</strong></p>
			<p><strong>Tanggal: $today</strong></p>
			<table border=1 cellpadding=3 cellspacing=0 frame=border rules=rows>		
			<th><div align='center'>No</div></th>
			<th><div align='center'>NIK</div></th>
			<th><div align='center'>Nama</div></th>
			<th><div align='center'>ID</div></th>
			<th><div align='center'>KKWT Name</div></th>
			<th><div align='center'>Tgl Batas Masa Berlaku</div></th>
					
			</tr>";
		
	$mail->Body = $body; 

	
			
	$no	 = 1;
while ($data = mysql_fetch_array($sql)){
	
	$qry 	= "SELECT * FROM tbl_p3k WHERE NIK=$data[NIK]";
	$qws	= mysql_query($qry);
	$row	= mysql_fetch_array($qws);
	
	
	$NIK			= $data['NIK'];

	if ($no%2==0){$Vcolor="bgcolor='#FFFFFF'";}else{$Vcolor="bgcolor='#F5F5F5'";}

	//$Expire			= date('d-M-Y', strtotime($data['KKWT_Date2']));
	$Date2			= date('d-M-Y', strtotime($data['KKWT_Date2']));	
	$konten[$NIK]	= "<tr>
								<td $Vcolor><div align='center'>$no</div></td>
								<td $Vcolor><div align='left'>$data[NIK]</div></td>
								<td $Vcolor><div align='left'><a href=http://astapp02/reminder/p3k/frmKKWT/index/edit/$data[KKWTId]>$row[Name]</a></div></td>
								<td $Vcolor><div align='right'>$data[KKWTId]</div></td>
								<td $Vcolor><div align='left'>$data[KKWT_Name]</div></td>
								<td $Vcolor><div align='right'>$Date2</div></td>							
								
							</tr>";
	$mail->Body .= $konten[$NIK];	
	$no++;
		
	
	}
	
	$footer ="	
	</table>
	</br>
	</br>
	<p><font color=#FF0000 size=-1>Perhatian email ini dikirim secara otomatis dari Integrated Reminder Services (IRIS). Jangan membalas ke alamat ini</font></p>	
	</body>
	</html>";	
	
	$mail->IsSMTP();
  	$mail->Mailer       = "smtp";
  	$mail->Host         = "astelmail.unias.com";
  	$mail->Port         = 25;
  	$mail->SMTPSecure   = "tls";    
  	$mail->SMTPKeepAlive= true;
  	$mail->SMTPAuth     = true;
  	$mail->Port       	= 587; 
  	$mail->SetFrom('system.noreply@unias.com', 'Integrated Reminder Services (IRIS)');
	//$to = "dompak.sinambela@unias.com";
	$to = "$dad[Email]";
	$mail->Body .= $footer;	
	$mail->AddAddress($to);
	$mail->Subject  = "$wap[scheduler_subject]";
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

}	

mysql_query("UPDATE tbl_scheduler SET scheduler_lastrun = '$Repeat' WHERE scheduler_id = 1");

}

else {

	echo "</br> </br> Soon task scheduler repeat @ $Repeat";
}

?>