<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!--<h4>calender</h4>-->

$session_nik = $this->cms_user_id();

<?php echo $content; ?>

<?php 
$today = date ("m/d/Y");
$time  = strtotime($today);

$y     = date('Y', $time);
$m     = date('m', $time);

include "./includes/calender/MyCalender.php"; ?>