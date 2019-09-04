<?php
// Koneksi database
include "koneksi/koneksi.php";
  
$q   = trim(strip_tags($_GET['term'])); // variabel $q untuk mengambil inputan user
//$sql = mysql_query("SELECT * FROM tbl_trans WHERE cTransUser LIKE '%".$q."%'"); // menampilkan data yg ada didatabase yg sesuai dengan inputan user


$sql = mysql_query("SELECT * FROM tbl_profile WHERE ( NIK LIKE '%".$q."%' OR Nama LIKE '%".$q."%' ) AND bStatus=1"); 



while ($data = mysql_fetch_array($sql)){
	
	$result[] = htmlentities(stripslashes($data['NIK']).' '.$data['Nama']); // manempilkan nama jabatan
}
echo json_encode($result); // menampilkan data dengan format json
?>