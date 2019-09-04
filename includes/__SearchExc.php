<?php
// Koneksi database
include "koneksi/koneksi.php";
  
$q   = trim(strip_tags($_GET['term'])); // variabel $q untuk mengambil inputan user
//$sql = mysql_query("SELECT * FROM tbl_trans WHERE cTransUser LIKE '%".$q."%'"); // menampilkan data yg ada didatabase yg sesuai dengan inputan user


$sql = mysql_query("SELECT * FROM tbl_profile WHERE ( NIK LIKE '%".$q."%' OR Nama LIKE '%".$q."%' ) AND CompanyId >2 AND bStatus=1"); 



while ($data = mysql_fetch_array($sql)){
	//$ID = $data['iStokID'];
	//$user = mysql_fetch_array(mysql_query("SELECT * FROM tbl_trans WHERE itransStokId='$ID' ORDER BY dTransOutDate DESC LIMIT 0,1"));
	
	//$result[] = htmlentities(stripslashes($data['cStokNewTag'])); // manempilkan nama jabatan
	$result[] = htmlentities(stripslashes($data['NIK']).' '.$data['Nama']); // manempilkan nama jabatan
	//$result2[] = htmlentities(stripslashes($data['cTransUser'])); // manempilkan nama jabatan
}
echo json_encode($result); // menampilkan data dengan format json
?>