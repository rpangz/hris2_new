<?php
//202.153.21.4
$today = date ("m/d/Y");
$time = strtotime($today);

$y=date('Y', $time);
$m=date('m', $time);

//echo "<script language='javascript'>;window.location ='?month=$m&year=$y';</script>"; 
header("Location: ?month=$m&year=$y");

?>
