<?php
session_start();
error_reporting(0);
include "../koneksi/koneksi.php";
//require 'terbilang.php';


$query 	="SELECT * FROM tbl_scheduler WHERE scheduler_id !=1 AND scheduler_konten=1 AND scheduler_status=1";			
$sql 	= mysql_query($query);
$total 	= mysql_num_rows($sql);


//$data   = mysql_fetch_array($sql);

while ($data = mysql_fetch_array($sql)){

$time_ku = mysql_fetch_array(mysql_query("SELECT * FROM tbl_interval WHERE interval_id=$data[scheduler_begin]"));
$time_mu = mysql_fetch_array(mysql_query("SELECT * FROM tbl_interval WHERE interval_id=$data[scheduler_repeat]"));


$today 		= date ("Y-m-d H:i:s");
$target 	= $data['scheduler_start'];
$init		= $time_ku['interval_name'];
$Begin  	= date ('Y-m-d H:i:s', strtotime('- '.$init));

$interval	= $time_mu['interval_name'];

//$Repeat  	= date ('Y-m-d H:i:s', strtotime(+$interval));

//$Repeat		= strtotime("+$interval", $data['scheduler_lastrun']);

$input = strtotime("$data[scheduler_lastrun]");

$Repeat = date("Y-m-d H:i:s", strtotime("+$interval", $input));


echo "today= $today | target=$target | begin=$Begin | interval= $interval | input= $input | repeat= $Repeat </br>";

if ($target <= $Begin && is_null($data['scheduler_lastrun'])){



$recive 	="SELECT tbl_receiver.NIK AS NIK,tbl_receiver.Name AS Name,tbl_receiver.Email AS Email FROM tbl_scheduler 
			INNER JOIN tbl_scheduler_receiver ON tbl_scheduler.scheduler_id = tbl_scheduler_receiver.scheduler_id
			INNER JOIN tbl_receiver ON tbl_scheduler_receiver.NIK = tbl_receiver.NIK
			WHERE tbl_scheduler.scheduler_id = $data[scheduler_id]";

$rows_data = mysql_query($recive);

while ($dad = mysql_fetch_array($rows_data)){	
	
	
if ($total > 0){	
	require_once 'class.phpmailer.php';	

	try {

	$mail = new PHPMailer(true);

	$body =
	"<html>
	<head>
			
			<title>Integrated Reminder System</title>
			</head>
	
	<body>
			<p>Kepada YTH: $dad[Name] </p>

			$data[scheduler_detail]
	


	";
		
	$mail->Body = $body; 

	
			
	
	
	$footer ="	
	
	</br>
	
	</br>
	
	<p><font color=#FF0000 size=-1>Do not relpy this email</font></p>	
	</body>
	</html>";	
	
	$mail->Mailer = "smtp";
	$mail->Port = 110;
	$mail->IsSMTP();	
	$mail->SMTPKeepAlive = true;
	$mail->Port       = 25;                    
	$mail->Host       = "172.17.0.2";	
	$mail->From       = "system.noreply@unias.com";
	$mail->FromName   = "Integrated Reminder Services";
	//$to = "dompak.sinambela@unias.com";
	$to= "$dad[Email]";
	$mail->Body .= $footer;	
	$mail->AddAddress($to);
	$mail->Subject  = "$data[scheduler_subject]";
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 	
	$mail->WordWrap   = 80;	
	$mail->IsHTML(true);	
	$mail->Send();	
	
		}
		catch (phpmailerException $e)
		{
		echo $e->errorMessage();
		}	

mysql_query("UPDATE tbl_scheduler SET scheduler_lastrun = '$Begin' WHERE scheduler_id = $data[scheduler_id]");


}

}	

}

elseif ($today >= $Repeat &&  !is_null($data[scheduler_lastrun])){


$recive 	="SELECT tbl_receiver.NIK AS NIK,tbl_receiver.Name AS Name,tbl_receiver.Email AS Email FROM tbl_scheduler 
			INNER JOIN tbl_scheduler_receiver ON tbl_scheduler.scheduler_id = tbl_scheduler_receiver.scheduler_id
			INNER JOIN tbl_receiver ON tbl_scheduler_receiver.NIK = tbl_receiver.NIK
			WHERE tbl_scheduler.scheduler_id = $data[scheduler_id]";

$rows_data = mysql_query($recive);

while ($dad = mysql_fetch_array($rows_data)){	
	
	
if ($total > 0){	
	require_once 'class.phpmailer.php';	

	try {

	$mail = new PHPMailer(true);

	$body =
	"<html>
	<head>
			
			<title>Integreted Reminder System</title>
			</head>
	
	<body>
			<p>Kepada YTH: $dad[Name] </p>

			$data[scheduler_detail]
	
	

	";
		
	$mail->Body = $body; 

	
			
	
	
	$footer ="	
	
	</br>
	
	</br>
	
	<p><font color=#FF0000 size=-1>Do not relpy this email</font></p>	
	</body>
	</html>";	
	
	$mail->IsSMTP();
  	$mail->Mailer       = "smtp";
  	$mail->Host         = "astelmail.unias.com";
  	$mail->Port         = 25;
  	$mail->SMTPSecure   = "tls";    
  	$mail->SMTPKeepAlive= true;
  	$mail->SMTPAuth     = true; 
  	$mail->SetFrom('system.noreply@unias.com', 'Integrated Reminder Services (IRIS)');
	//$to = "dompak.sinambela@unias.com";
	$to= "$dad[Email]";
	$mail->Body .= $footer;	
	$mail->AddAddress($to);
	$mail->Subject  = "$data[scheduler_subject]";
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 	
	$mail->WordWrap   = 80;	
	$mail->IsHTML(true);	
	$mail->Send();	
	
		}
		catch (phpmailerException $e)
		{
		echo $e->errorMessage();
		}	

//mysql_query("UPDATE tbl_scheduler SET scheduler_lastrun = '$Begin' WHERE scheduler_id = 2");


}

}

mysql_query("UPDATE tbl_scheduler SET scheduler_lastrun = '$Repeat' WHERE scheduler_id = $data[scheduler_id]");


}

else {

	echo "</br> </br> Soon task scheduler repeat @ $Repea</br></br>";
}
$no++;

}
?>