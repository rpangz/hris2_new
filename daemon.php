<?php
// Make sure it's run from CLI
if(php_sapi_name() != 'cli' && !empty($_SERVER['REMOTE_ADDR'])) exit("Access Denied.");	

// Please configure this
$url = "https://apps.unias.com/hris2";

// 1. Approval untuk form permintaan Form Cuti
fclose(fopen($url."/index.php/kehadiran/Reminder_Form_Cuti_028ca14fe05a86a20e9165c718ce8f12/index/", "r"));

?>
