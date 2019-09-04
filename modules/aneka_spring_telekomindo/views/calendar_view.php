<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$this->config->load('cms_config');       
$company_id = $this->config->item('cms_astel_id');

$today = date ("m/d/Y");
$time  = strtotime($today);

$y     = date('Y', $time);
$m     = date('m', $time);


include "./includes/calender/Calendar.php"; ?>