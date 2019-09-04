<?php

function bacaHTML($url){
     // inisialisasi CURL
     $data = curl_init();
     // setting CURL
     curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($data, CURLOPT_URL, $url);
     // menjalankan CURL untuk membaca isi file
     $hasil = curl_exec($data);
     curl_close($data);
     return $hasil;
}
$kodeHTML =  bacaHTML('http://www.klikbca.com');
$pecah = explode('<table width="139" border="0" cellspacing="0" cellpadding="0">', $kodeHTML);
$pecahLagi = explode('</table>', $pecah[2]);
echo"Informasi Nilai Tukar Mata Uang Rupiah, </br><i>sumber : www.klikbca.com</i>";
echo "<table  id='tfhover' class='tftable' border='0'>";

echo "<tr>
		<td width=50><div align='center'>KURS</td>
		<td width=80><div align='center'>JUAL</td>
		<td width=80><div align='center'>BELI</td>
		</tr>";
echo $pecahLagi[0];
echo "</table>";
?>

