<?php
include "class_Remainder.php";
$today = date ("m/d/Y H:i:s");

$call = new SendMail();
$call->connectDB();

$dataArray = $call->NIKRealize();

$i=1;

foreach ($dataArray as $data){
	$to  = $data['Email'];

if 	($call->MailRealizeContent($total) > 0 && $call->MailRealizeContent($Expire) <=$today){	
	$call->RealizeRemainderMail($to);
}	
$i++;
}

?>