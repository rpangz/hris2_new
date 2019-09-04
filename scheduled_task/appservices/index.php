<?php

function fungsiCurl($url){
    $data = curl_init();
	
    curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($data, CURLOPT_URL, $url);
         curl_setopt($data, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
     $hasil = curl_exec($data);
     curl_close($data);
     return $hasil;
}
$url 	= fungsiCurl('http://appservices.unias.com/publish/');

$pecah 	= explode('<table>', $url);
$pecah2 = explode ('</table>',$pecah[0]);
$pecah3 = explode ('<td></td>', $pecah2[0]);

$today = date ("m/d/Y H:i:s");

/*
$pecah3 = explode ('<body>&nbsp;</body>', $pecah2[0]);
$pecah4 = explode ('<td>&nbsp;&nbsp;</td>',$pecah3[2]);
*/
/*
$pecah17 = explode ('<td>&nbsp;</td>',$pecah2[1]);
$pecah18 = explode (" ",$pecah2[1]);
echo "<br>";
*/

//echo $pecah3[0];

$status = md5($pecah3[0]);

//echo $status;


if ($status !='3d1c4e7700a823143523ff9c60cea7d7'){

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
			<p>Kepada YTH: IT Support </p>
			<p><strong>Tanggal: $today</strong></p>
			<p><strong>http://appservices.unias.com/publish/ sedang Offline</strong></p><br/>
			
			Mohon Diperiksa,Terimakasih
			
		
			
	</br>
	</br>
	<p><font color=#FF0000 size=-1>Perhatian email ini dikirim secara otomatis dari appservices. Jangan membalas ke alamat ini</font></p>	
	</body>
	</html>";
		
	$mail->Body =$body; 	
	
	$mail->Mailer = "SMTP";
	//$mail->Port = 110;
	$mail->IsSMTP();	
	$mail->SMTPKeepAlive = true;
	$mail->Port       = 25;                    
	$mail->Host       = "Exc2013-DAG";	
	$mail->From       = "system.noreply@unias.com";
	$mail->FromName   = "appservices";
	$to = "itsupport@unias.com";
	//$to  = "$dad[Email]";
	//$mail->Body .= $footer;	
	$mail->AddAddress($to);
	$mail->Subject    = "WARNING!!! From AppServices";
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 	
	$mail->WordWrap   = 80;	
	$mail->IsHTML(true);	
	$mail->Send();	
	
		}
		
		catch (phpmailerException $e)
		{
		echo $e->errorMessage();
		}
		
}else {

}
?>
