<?php
// Koneksi database
include "koneksi/koneksi.php";
  
$q   = trim(strip_tags($_GET['term'])); // variabel $q untuk mengambil inputan user

$sql = mysql_query("SELECT * FROM tbl_profile_education WHERE ( EduInstitution LIKE '%".$q."%' )"); 



while ($data = mysql_fetch_array($sql)){
	
	$result[] = htmlentities(stripslashes($data['EduInstitution']));
	
}
echo json_encode($result);
?>