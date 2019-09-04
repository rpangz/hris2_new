<style type="text/css">
	
	.zui-table {
    border: solid 1px #DDEEEE;
    border-collapse: collapse;
    border-spacing: 0;
    font: normal 13px Arial, sans-serif;
    width: 550px;
}
.zui-table thead th {
    background-color: #DDEFEF;
    border: solid 1px #DDEEEE;
    color: #336B6B;
    padding: 10px;
    text-align: center;
    text-shadow: 1px 1px 1px #fff;
}
.zui-table tbody td {
    border: solid 1px #DDEEEE;
    color: #333;
    padding: 10px;
    text-shadow: 1px 1px 1px #fff;
}
.zui-table-highlight tbody tr:hover {
    background-color: #CCE7E7;
}
.zui-table-horizontal tbody td {
    border-left: none;
    border-right: none;
}



</style>


<?PHP

include "koneksi/koneksi.php";




	if (!is_null($this->input->get('nik'))){
        $NIK  = $this->input->get('nik');
        $name = madSafety($NIK);
  		$arr  = explode(" ",$name);

    	}
    else{
        $NIK = '';
        $name = madSafety($NIK);
        $arr  = explode(" ",$name);
    }


	$nik = $arr[0];

    $dept   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$_SESSION['NIK']));
	$tampil = mysql_query("SELECT * FROM tbl_profile WHERE NIK='".$nik."' AND DeptID=".$dept['DeptID']);
  	$total  = mysql_num_rows($tampil);
  	$data   = mysql_fetch_array($tampil);


  if ($total <=0){
  		echo "Data Tidak Ditemukan...";

  	}
  else {

echo '<H2>'.$data['Nama'].'</H2>
      <H3><u>Hak Cuti Tahunan</u></H3>';

$SQL1 = mysql_query("SELECT * FROM tbl_hakcuti WHERE NIK='$nik' AND JenisHakCuti='1' ORDER BY HakId DESC");

$JM  = mysql_num_rows($SQL1);
if ($JM >0){
$no   = 1;
while ($row1 = mysql_fetch_array($SQL1)){


 
    $Periode1  = date('d M Y', strtotime($row1['Periode1']));
    if (is_null($row1['PeriodeExt']) OR $row1['PeriodeExt']==""){
        $Periode2  = date('d M Y', strtotime($row1['Periode2']));
    }
    else {
        $Periode2  = date('d M Y', strtotime($row1['PeriodeExt']));
    }

    $LimitExp = '12 Month';

    $Kerja1     = date('d M Y', strtotime($row1['Periode1']. ' - '.$LimitExp));
    $Kerja2     = date('d M Y', strtotime($row1['Periode2']. ' - '.$LimitExp));

    $LamaKerja1  = dateDiff("$Periode1", "$Periode2") . "\n";



   

  	echo'  	
  		<table class="zui-table zui-table-horizontal zui-table-highlight">
    <thead>
        <tr>
            <th colspan=2 align="center"><font color=""><strong>Pengambilan cuti '.$Periode1. ' - ' .$Periode2.'</strong></font></th>
           
        </tr>
        <tr>
        
            <th align="center">Hak cuti tahun kerja '.$Kerja1.' - ' .$Kerja2.'</th>
            <th align="right">'.$row1['Qty'].'</th>
           
        </tr>


    </thead>
    <tbody>';

    $deta1 = mysql_query("SELECT * FROM tbl_formcuti WHERE HakCutiId='$row1[HakId]' AND StatusForm='A' AND FormCutiNIK='$row1[NIK]'");
    
    while ($ww = mysql_fetch_array($deta1)){

        $DHA = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId='$ww[CutiId]'");
        $JmlHari  = mysql_num_rows($DHA);

        $TglBuat  = date('Y-m-d', strtotime($ww['CreatedTime']));
        $TglMasuk = date('Y-m-d', strtotime($ww['TglMasuk']));

        if ($TglBuat < $TglMasuk){
            $sopi  = '#000000';
        }else{
            $sopi  = '#FF00FF';
        }  
            
           echo '            
                <tr><td><font color="'.$sopi.'">'.$ww['Keperluan'].'</font><br/>';

                while ($ws = mysql_fetch_array($DHA)){
                    $TglCuti = date('d M Y', strtotime($ws['TglCuti']));

                    $dayin = date('N', strtotime($ws['TglCuti']));

                    if ($dayin==1){
                     $nDayin = 'Senin';
                        }
                    elseif ($dayin==2){
                        $nDayin = 'Selasa';
                    }
                    elseif ($dayin==3){
                        $nDayin = 'Rabu';
                    }
                    elseif ($dayin==4){
                        $nDayin = 'Kamis';
                    }
                    elseif ($dayin==5){
                        $nDayin = 'Jumat';
                    }
                    elseif ($dayin==6){
                        $nDayin = 'Sabtu';
                    }
                    elseif ($dayin==7){
                        $nDayin = 'Minggu';
                    }
                    else{
                        $nDayin = '';
                    }

                    echo'<li>'.$nDayin.', '.$TglCuti.'</li>';
                }
                echo'</td>
                <td align="right">- '.$JmlHari.'</td>       
            </tr>';

    }

    $hh = mysql_query("SELECT * FROM `tbl_formcuti` INNER JOIN tbl_formcutidetail ON tbl_formcuti.CutiId=tbl_formcutidetail.CutiId 
            WHERE tbl_formcuti.HakCutiId='$row1[HakId]' AND tbl_formcuti.StatusForm='A' AND tbl_formcuti.FormCutiNIK='$row1[NIK]'");

            $jka      = mysql_fetch_array(mysql_query('SELECT * FROM tbl_jeniscuti WHERE id="'.$row1['JenisHakCuti'].'"'));

            $today    = date('Y-m-d');
            if (!is_null($jka['LimitExp'])){
                $LimitExp = $jka['LimitExp'];
            }else{
                $LimitExp = '';
            }
            $soon     = date('Y-m-d', strtotime($row1['Periode2']. ' + '.$LimitExp));
            $soon2    = date('Y-m-d', strtotime($soon));

            $Qty      = $row1['Qty'];
            $QtyPakai = mysql_num_rows($hh);
            $Sisa     = $Qty - $QtyPakai;

            if ($today < $row1['Periode1'] && $Sisa <= 0){
                $sati = 'disabled';
                $ne    = '';
                $gab  = 0;
                $bg    = '';
            }
            elseif($today > $row1['Periode2'] && is_null($row1['PeriodeExt']) OR $Sisa <= 0){
                $sati = 'disabled';
                $ne    = '';
                $gab  = 0;
                $bg    = '';
            }
            elseif ($today > $row1['PeriodeExt'] && !is_null($row1['PeriodeExt']) OR $Sisa <= 0){
                $sati = 'disabled';
                $ne    = '';
                $gab  = 0;
                $bg    = '';
            }
            else{
                $sati = '';
                $ne    = '*) Bisa Dipakai , ';
                $gab  = $Sisa;
                $bg    = '#FF0000';

            }

/*
            if ($today > $soon || $Sisa <= 0){               
                $ne    ='';
                $gab   = 0;
                $bg    = '';
            }
            
            else{               
                $ne    ='*) Bisa Dipakai , ';
                $gab   = $Sisa;
                $bg   = '#FF0000';
            }
*/
            @$grand += $gab;


       echo '<tr>
            <td align="right"><font color="'.$bg.'"><strong>Sisa Cuti ( '.$Qty.' - '.$QtyPakai.' )</strong></font></td>
            <td align="right"><font color="'.$bg.'"><strong>'.$Sisa.'</strong></font></td>
          
        </tr>
</tbody>

</table><br/>';


$no++;

}

    echo'<H4>*) <i>Sisa cuti tahunan gabungan '.$grand.' hari </H4><p>Lihat hak cuti yg berwarna merah</p></i>';

}
else{
    echo'<p>No Data</p>';
}


echo '<hr/>';





// Cuti BESAR
  

echo'<H3><u>Hak Cuti Besar</u></H3>';

$SQL2 = mysql_query("SELECT * FROM tbl_hakcuti WHERE NIK='$nik' AND JenisHakCuti='2' ORDER BY HakId DESC");
$i    = 1;

$JH  = mysql_num_rows($SQL2);

if ($JH >0){
while ($row2 = mysql_fetch_array($SQL2)){

    $Periode1  = date('d M Y', strtotime($row2['Periode1']));
    if (is_null($row2['PeriodeExt']) OR $row2['PeriodeExt']==""){
        $Periode2  = date('d M Y', strtotime($row2['Periode2']));
    }
    else {
        $Periode2  = date('d M Y', strtotime($row2['PeriodeExt']));
    }

    $PeriodeKerja1  = date('d M Y', strtotime($row2['PeriodeKerja1']));
    $PeriodeKerja2  = date('d M Y', strtotime($row2['PeriodeKerja2']));

    $LimitExp = '12 Month';

   
    $Kerja1     = date('d M Y', strtotime($row2['Periode1']. ' - '.$LimitExp));
    $Kerja2     = date('d M Y', strtotime($row2['Periode2']. ' - '.$LimitExp));

    $LamaKerja2  = dateDiff("$PeriodeKerja1", "$PeriodeKerja2") . "\n";

        $PeriodeKerja22 = strtotime($row2['PeriodeKerja2']);

        $today1 = date ('Y', $PeriodeKerja22);
        $today2 = date ('m', $PeriodeKerja22);
        $today3 = date ('d', $PeriodeKerja22);

        $PeriodeKerja11 = strtotime($row2['PeriodeKerja1']);
        $d=date('d', $PeriodeKerja11);
        $y=date('Y', $PeriodeKerja11);
        $m=date('m', $PeriodeKerja11);

        $rr = strtotime($m.'/'.$d.'/'.$today1);


        $lahir      = mktime(0,0,0,$m,$d,$y); //jam,menit,detik,bulan,tanggal,tahun
        $t          = time(); $umur = ($lahir < 0) ? ( $t + ($lahir * -1) ) : $t - $lahir; $tahun = 60 * 60 * 24 * 365; 
        $tahunlahir = $umur / $tahun; 
        $MyAge      = floor($tahunlahir);


    echo'<table class="zui-table zui-table-horizontal zui-table-highlight">
    <thead>
       <tr>
            <th colspan=2 align="center"><font color=""><strong>Pengambilan cuti '.$Periode1. ' - ' .$Periode2.'</strong></font></th>
           
        </tr>
        <tr>        
            <th align="center">Hak cuti tahun kerja '.$PeriodeKerja1.' - ' .$PeriodeKerja2.' ( '.$MyAge.' Thn )</th>
            <th align="right">'.$row1['Qty'].'</th>           
        </tr>


    </thead>
    <tbody>';

    $deta1 = mysql_query("SELECT * FROM tbl_formcuti WHERE HakCutiId='$row2[HakId]' AND StatusForm='A' AND FormCutiNIK='$row2[NIK]'");
    
    while ($wa = mysql_fetch_array($deta1)){

        $DHA = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId='$wa[CutiId]'");
        $JmlHari  = mysql_num_rows($DHA);
        
        $TglBuat  = date('Y-m-d', strtotime($wa['CreatedTime']));
        $TglMasuk = date('Y-m-d', strtotime($wa['TglMasuk']));

        if ($TglBuat < $TglMasuk){
            $sopu  = '#000000';
        }else{
            $sopu  = '#FF00FF';
        }     

           echo '            
                <tr><td><font color="'.$sopu.'">'.$wa['Keperluan'].'</font><br/>';

                while ($ws = mysql_fetch_array($DHA)){
                    $TglCuti = date('d M Y', strtotime($ws['TglCuti']));
                    echo'<li>'.$TglCuti.'</li>';
                }
                echo'</td>
                <td align="right">- '.$JmlHari.'</td>       
            </tr>';

    }

    $hh = mysql_query("SELECT * FROM `tbl_formcuti` INNER JOIN tbl_formcutidetail ON tbl_formcuti.CutiId=tbl_formcutidetail.CutiId 
            WHERE tbl_formcuti.HakCutiId='$row2[HakId]' AND tbl_formcuti.StatusForm='A' AND tbl_formcuti.FormCutiNIK='$row2[NIK]'");

            $jka      = mysql_fetch_array(mysql_query('SELECT * FROM tbl_jeniscuti WHERE id="'.$row2['JenisHakCuti'].'"'));

            $today    = date('Y-m-d');

            if (!is_null($jka['LimitExp'])){
                $LimitExp = $jka['LimitExp'];
            }else{
                $LimitExp = '';
            }


            if (!is_null($row2['PeriodeExt'])){
                $PeriodeExt = $row2['PeriodeExt'];
            }else{
                $PeriodeExt = 0;
            }

            $soon      = date('Y-m-d', strtotime($row2['Periode2']. ' + '.$PeriodeExt));
            $soon2     = date('Y-m-d', strtotime($soon));

            $Qty2      = $row2['Qty'];
            $QtyPakai2 = mysql_num_rows($hh);
            $Sisa2     = $Qty2 - $QtyPakai2;


            if ($today < $row2['Periode1'] && $Sisa2 <= 0){
                $sati = 'disabled';
                $ne    = '';
                $gab2  = 0;
                $bg    = '';
            }
            elseif($today > $row2['Periode2'] && is_null($row2['PeriodeExt']) OR $Sisa2 <= 0){
                $sati = 'disabled';
                $ne    = '';
                $gab2  = 0;
                $bg    = '';
            }
            elseif ($today > $row2['PeriodeExt'] && !is_null($row2['PeriodeExt']) OR $Sisa2 <= 0){
                $sati = 'disabled';
                $ne    = '';
                $gab2  = 0;
                $bg    = '';
            }
            else{
                $sati = '';
                $ne    = '*) Bisa Dipakai , ';
                $gab2  = $Sisa2;
                $bg    = '#FF0000';

            }

/*

            if ($today < $soon || $Sisa2 <= 0){               
                $ne    = '';
                $gab2  = 0;
                $bg    = '';
            }
            
            else{               
                $ne    = '*) Bisa Dipakai , ';
                $gab2  = $Sisa2;
                $bg    = '#FF0000';
            }
*/
            @$grand2 += $gab2;


       echo '<tr>
            <td align="right"><font color="'.$bg.'"><strong>Sisa Cuti ( '.$Qty2.' - '.$QtyPakai2.' )</strong></font></td>
            <td align="right"><font color="'.$bg.'"><strong>'.$Sisa2.'</strong></font></td>
          
        </tr>
</tbody>


</table><br/>';
$i++;

}


 echo'<H4>*) <i>Sisa cuti khusus gabungan '.$grand2.' hari </H4><p>Lihat hak cuti yg berwarna merah</p></i>';

}

else {
    echo'<p>No Data</p>';
}


}


?>




<?PHP
  
  // Set timezone


  // Time format is UNIX timestamp or
  // PHP strtotime compatible strings
function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }

    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
        $ttime = $time1;
        $time1 = $time2;
        $time2 = $ttime;
    }

    // Set up intervals and diffs arrays
    $intervals  = array('year','month','day','hour','minute','second');
    $diffs      = array();

    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Create temp time from time1 and interval
      $ttime = strtotime('+1 ' . $interval, $time1);
      // Set initial values
      $add = 1;
      $looped = 0;
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
        // Create new temp time from time1 and interval
        $add++;
        $ttime = strtotime("+" . $add . " " . $interval, $time1);
        $looped++;
      }
 
      $time1 = strtotime("+" . $looped . " " . $interval, $time1);
      $diffs[$interval] = $looped;
    }
    
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
    break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
    // Add s if value is not 1
    if ($value != 1) {
      $interval .= "s";
    }
    // Add value and interval to times array
    $times[] = $value . " " . $interval;
    $count++;
      }
    }

    // Return string with times
    return implode(", ", $times);
  }

?>
