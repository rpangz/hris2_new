<?php
session_start();
error_reporting(0);
include "../../koneksi/koneksi.php";

$ct = $_POST['ct'];
$ck = $_POST['ck'];

$nik   = $_GET['nik'];

if(!empty($_POST['ct'])) {
	

    $tampil = mysql_query("SELECT * FROM tbl_profile WHERE NIK='$nik'");
    $total  = mysql_num_rows($tampil);
    $data   = mysql_fetch_array($tampil);



echo '<H2>'.$data['Nama'].'</H2>
      <H3><u>Hak Cuti Tahunan</u></H3>';

//$SQL1 = mysql_query("SELECT * FROM tbl_hakcuti WHERE NIK='$nik' AND JenisHakCuti='1' ORDER BY HakId DESC");

//$JM  = mysql_num_rows($SQL1);

$no   = 1;
//while ($row1 = mysql_fetch_array($SQL1)){

foreach($_POST['ct'] as $selected) {

	$SQL1 = mysql_query("SELECT * FROM tbl_hakcuti WHERE NIK='$nik' AND HakId=".$selected);
	$row1 = mysql_fetch_array($SQL1);
	
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

    



   

    echo'<table class="zui-table zui-table-horizontal zui-table-highlight" border="1px">
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
            
           echo '            
                <tr><td>'.$ww['Keperluan'].'<br/>';

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

echo '<hr/>';


}


if(!empty($_POST['ck'])) {

// Cuti BESAR
  

echo'<H3><u>Hak Cuti Besar</u></H3>';

//$SQL2 = mysql_query("SELECT * FROM tbl_hakcuti WHERE NIK='$nik' AND JenisHakCuti='2' ORDER BY HakId DESC");
$i    = 1;

$JH  = mysql_num_rows($SQL2);

foreach($_POST['ck'] as $selected2) {
//while ($row2 = mysql_fetch_array($SQL2)){
	
	$SQL2 = mysql_query("SELECT * FROM tbl_hakcuti WHERE NIK='$nik' AND HakId=".$selected2);
	$row2 = mysql_fetch_array($SQL2);
	
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


    echo'<table class="zui-table zui-table-horizontal zui-table-highlight" border=1>
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
            
           echo '            
                <tr><td>'.$wa['Keperluan'].'<br/>';

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

}

 echo'<H4>*) <i>Sisa cuti khusus gabungan '.$grand2.' hari </H4><p>Lihat hak cuti yg berwarna merah</p></i>';






    echo"<script type='text/javascript'>alert('Data Sudah Di simpan dan Email sudah dikirim... Click OK to close window');window.open('', '_self', '');window.close();</script>";



    $footer ='  
    </table>
    </br>
    </br>
    <p><font color="#FF0000" size=-1>Perhatian email ini dikirim secara otomatis dari HRIS. Jangan membalas ke alamat ini</font></p>   
    </body>
    </html>';


 // Set timezone
require_once 'class.phpmailer.php'; 

    try {

    $mail = new PHPMailer(true);


    $mail->IsSMTP();
    $mail->Mailer       = "smtp";
    $mail->Host         = "astelmail.unias.com";
    $mail->Port         = 25;
    $mail->SMTPSecure   = "tls";        
    $mail->SMTPKeepAlive= true;
    $mail->SMTPAuth     = true; 
    $mail->From         = "system.noreply@unias.com";
    $mail->FromName     = "Human Resource Information System";
    $mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');    

    //$to = "$aSQL[Email]";
    $to = "dompak.sinambela@unias.com";
    $mail->Body         .= $footer;     
    $mail->AddAddress($to);
    $mail->Subject       = "$mSet[Subject] - $jka[JenisIjinName]";
    $mail->AltBody       = "To view the message, please use an HTML compatible email viewer!";  
    $mail->WordWrap      = 80;  
    $mail->IsHTML(true);    
    $mail->Send();

    }
        catch (phpmailerException $e)
        {
        echo $e->errorMessage();
        }     

		
?>



<style type="text/css">
    
    .zui-table {
    border: solid 1px #DDEEEE;
    border-collapse: collapse;
    border-spacing: 1;
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