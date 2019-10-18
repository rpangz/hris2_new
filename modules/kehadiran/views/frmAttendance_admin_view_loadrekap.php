<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#9ABAD9;margin:0px auto;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#9ABAD9;color:#444;background-color:#EBF5FF;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#9ABAD9;color:#fff;background-color:#409cff;}
.tg .tg-hmp3{background-color:#D2E4FC;text-align:left;vertical-align:to;font-size: 11px; font-style: "Arial";font-weight: bold;}
.tg .tg-0lax{text-align:center;vertical-align:middle; font-size: 11px; font-style: "Arial"; font-weight: bold;}
.tg .tg-0laxdetail{text-align:left;vertical-align:middle; font-size: 11px; font-style: "Arial";font-weight: bold;}
</style>


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$asset = new CMS_Asset();
foreach($css_files as $file){
    $asset->add_css($file);
}
echo $asset->compile_css();
foreach($js_files as $file){
    $asset->add_js($file);
}
echo $asset->compile_js();
$current_year = date("Y");


$connscript = "";
$karyawan   = "ALL";


$periode = $this->uri->segment(4);
$department = $this->uri->segment(5);
$karyawan = $this->uri->segment(6);
$hari_kerja = 22;
$menit_kerja_perhari = 8*60;
$menit_kerja_perbulan = $hari_kerja*$menit_kerja_perhari;


if($karyawan<>"ALL") {
    $connscript = " AND nik = ".$karyawan;
}

?> 



<?php


function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}
//echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);
?>

<script type = "text/javascript">
function goToPage( id ) {
  var node = document.getElementById( id );  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}



</script>

<script type="text/javascript">
$(function () {
    $('.input-group-addon.beautiful').each(function () {
        
        var $widget = $(this),
            $input = $widget.find('input'),
            type = $input.attr('type');
            settings = {
                checkbox: {
                    on: { icon: 'fa fa-check-circle-o' },
                    off: { icon: 'fa fa-circle-o' }
                },
                radio: {
                    on: { icon: 'fa fa-dot-circle-o' },
                    off: { icon: 'fa fa-circle-o' }
                }
            };
            
        $widget.prepend('<span class="' + settings[type].off.icon + '"></span>');
            
        $widget.on('click', function () {
            $input.prop('checked', !$input.is(':checked'));
            updateDisplay();
        });
            
        function updateDisplay() {
            var isChecked = $input.is(':checked') ? 'on' : 'off';
                
            $widget.find('.fa').attr('class', settings[type][isChecked].icon);
                
            //Just for desplay
            isChecked = $input.is(':checked') ? 'checked' : 'not Checked';
            $widget.closest('.input-group').find('input[type="text"]').val('Input is currently ' + isChecked)
        }
        
        updateDisplay();
    });
});
</script>





<?php



// ========================================================== AWAL LOAD DATA ==============================================================


if (isset($periode) || !is_null($periode)){
    $periode_id          = $this->uri->segment(4);
}
else{
    $periode_id          = 0;
} 


$mysqlcomm = "";
if($periode_id != 0){
   $mysqlcomm =  "SELECT * FROM tbl_Periode WHERE iPeriodId='$periode_id'";
} else {
   $mysqlcomm =  "SELECT b.dPeriodStartDate,a.dPeriodEndDate FROM
                  (SELECT * FROM tbl_periode WHERE current_date() BETWEEN dPeriodStartDate AND dPeriodEndDate ) a,
                  (SELECT * FROM tbl_periode WHERE DATE_SUB(current_date(), INTERVAL 1 MONTH) BETWEEN dPeriodStartDate AND dPeriodEndDate ) b";
}

$sql_periode      = mysql_fetch_array(mysql_query($mysqlcomm));

//perubahan untuk membaca 2 bulan saja yang di load
$Periode1 = date('m/j/Y', strtotime($sql_periode['dPeriodStartDate']));
$Periode2 = date('m/j/Y', strtotime($sql_periode['dPeriodEndDate']));



$db_username = 'Admin'; //username
$db_password = ''; //password


//path to database file ASTABS02
//temp $database_path = "\\\\ASTABS02\\Att\\att2000.mdb";

$database_path = "d:\\att2000.mdb";


//check file exist before we proceed
if (!file_exists($database_path)) {
    die("Access database file not found !");

}




?>

<table class="tg">
  <tr>
    <th class="tg-0lax" rowspan="2">NO</th>
    <th class="tg-0lax" rowspan="2">NIK</th>
    <th class="tg-0lax" rowspan="2">NAMA</th>
    <th class="tg-0lax" colspan="3">SAKIT</th>
    <th class="tg-0lax" colspan="3">SAKIT<br>( SURAT )</th>
    <th class="tg-0lax" colspan="3">IJIN</th>
    <th class="tg-0lax" colspan="3">ALPHA</th>
    <th class="tg-0lax" colspan="3">CUTI</th>
    <th class="tg-0lax" colspan="3">TERLAMBAT</th>
    <th class="tg-0lax" colspan="3">PULANG <br> CEPAT </th>
    <th class="tg-0lax" colspan="2">LALAI <br> FINGER </th>
    <th class="tg-0lax" colspan="2">EFEKTIF <br> KERJA </th>
    <th class="tg-0lax" colspan="2">RESULT </th>
  </tr>
  
  <tr>
    <th class="tg-0lax">Hr</th>
    <th class="tg-0lax">Mnt</th>
    <th class="tg-0lax">%</th>
    <th class="tg-0lax">Hr</th>
    <th class="tg-0lax">Mnt</th>
    <th class="tg-0lax">%</th>
    <th class="tg-0lax">Hr</th>
    <th class="tg-0lax">Mnt</th>
    <th class="tg-0lax">%</th>
    <th class="tg-0lax">Hr</th>
    <th class="tg-0lax">Mnt</th>
    <th class="tg-0lax">%</th>
    <th class="tg-0lax">Hr</th>
    <th class="tg-0lax">Mnt</th>
    <th class="tg-0lax">%</th>
    <th class="tg-0lax">Freq</th>
    <th class="tg-0lax">Mnt</th>
    <th class="tg-0lax">%</th>
    <th class="tg-0lax">Freq</th>
    <th class="tg-0lax">Mnt</th>
    <th class="tg-0lax">%</th>
    <th class="tg-0lax">Freq</th>
    <th class="tg-0lax">%</th>
    <th class="tg-0lax">Hr</th>
    <th class="tg-0lax">Mnt</th>
    <th class="tg-0lax">Tdk Hdr</th>
    <th class="tg-0lax">Hadir</th>
  </tr> 

<?php




//Pengecekan Dept
$mysqlcomm = "SELECT nik,nama,deptid,nik_absensi FROM tbl_profile WHERE deptid = ".$department." AND bstatus = 1 ".$connscript." LIMIT 1000";
$query  = mysql_query($mysqlcomm);
$total  = mysql_num_rows($query);

$norekap = 0;
while ($data = mysql_fetch_array($query)){ //awal load karyawan
            $norekap = $norekap + 1;
            $session_nik = $data['nik_absensi'];
            $namakary = $data['nama'];

     

$total_sakit_tanpa_surat_dokter = 0;
$total_sakit_dengan_surat_dokter = 0;
$total_cuti = 0;
$total_ijin = 0;
$total_alpa = 0;
$total_lalai_finger = 0;
$total_terlambat = 0;
$total_late = 0;
$countdatacuti = 0;
$countdataliburbersama = 0; 
$countdatalibur = 0;
$countsakittanpasuratdokter = 0;
$countsakitdengansuratdokter = 0;
$countijin = 0;

//pengecekan jumlah cuti
$datacuti = "";
$datacuti = check_cuti($sql_periode['dPeriodStartDate'],$sql_periode['dPeriodEndDate'],$session_nik);
$countdatacuti = sizeof($datacuti); //untuk mengecek data di dalam array
$total_cuti = $countdatacuti;

//echo 'NIK : '.$session_nik.' ==> '.json_encode($datacuti).'<br>';
//echo "AAA => ".json_encode($datacuti[0][tglcuti]);



//pengecekan ijin record
$dataijinrecord = "";
$dataijinrecord = check_ijin_record($sql_periode['dPeriodStartDate'],$sql_periode['dPeriodEndDate'],$session_nik);

$dataijindata = "";
$dataijindata = check_ijin_data($sql_periode['dPeriodStartDate'],$sql_periode['dPeriodEndDate'],$session_nik);


$dataliburdata = "";
$dataliburdata = check_libur($sql_periode['dPeriodStartDate'],$sql_periode['dPeriodEndDate'],$session_nik);



$total_sakit_tanpa_surat_dokter  = $dataijinrecord['sakittanpasurat'];
$total_sakit_dengan_surat_dokter = $dataijinrecord['sakitdengansurat'];
$total_ijin = $dataijinrecord['lain'];


    





//create a new PDO object
$database = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$database_path; Uid=$db_username; Pwd=$db_password;");
$sql  = "SELECT DateValue([CHECKTIME]) AS Tanggal
FROM CHECKINOUT INNER JOIN USERINFO ON CHECKINOUT.USERID = USERINFO.USERID
WHERE (((USERINFO.Badgenumber)='$session_nik')) GROUP BY DateValue([CHECKTIME]) 
HAVING (((DateValue([CHECKTIME])) >=#$Periode1#) AND (DateValue([CHECKTIME])) <=#$Periode2#)
ORDER BY DateValue([CHECKTIME])";


$result = $database->query($sql);

if ($row = $result->fetch()){

$no=1;


$date = date("Y-m-d", strtotime($Periode1 . " -1 day"));
$final_date = date("Y-m-d", strtotime($Periode2));
$total_terlambat = 0;

$total_libur_nasional = 0;
$total_libur_bersama = 0;

$total_late = 0;
$total_early=0;
$total_over=0;
$total_all=0;

$total_alpa = 0;
$total_lalai_finger = 0;
$total_efektif_kerja = 0;


while($date < $final_date){


   $date = date("Y-m-d", strtotime($date . " +1 day"));
   $dates[] = $date;

   //$txt_date = $dates[];



  $Tanggal  = date('d-M-Y', strtotime($row['Tanggal']));
  $day      = date('N', strtotime($date));
  //$week     = date('W', strtotime($row['Tanggal']));
  $week     = $no;

$sql_in  = "SELECT TOP 1 DateValue([CHECKTIME]) AS Tanggal,CHECKTIME
FROM CHECKINOUT INNER JOIN USERINFO ON CHECKINOUT.USERID = USERINFO.USERID
WHERE (((USERINFO.Badgenumber)='$session_nik') AND CHECKTYPE='I' AND DateValue([CHECKTIME])=#$date#) ORDER BY [CHECKTIME]";
$result_in = $database->query($sql_in);

if ($row_in = $result_in->fetch()){
    $check_in_txt = date('H:i', strtotime($row_in['CHECKTIME']));
    $check_in = date('H:i', strtotime($row_in['CHECKTIME']));
    $date_in  = date('Y-m-d H:i:s', strtotime($row_in['CHECKTIME']));
}
else{
    $check_in_txt = '';
    $check_in = '00:00';
    $date_in  = date('Y-m-d H:i:s', strtotime($row_in['CHECKTIME']));

}


$sql_out  = "SELECT TOP 1 DateValue([CHECKTIME]) AS Tanggal,CHECKTIME
FROM CHECKINOUT INNER JOIN USERINFO ON CHECKINOUT.USERID = USERINFO.USERID
WHERE (((USERINFO.Badgenumber)='$session_nik') AND CHECKTYPE='O' AND DateValue([CHECKTIME])=#$date#) ORDER BY [CHECKTIME]";
$result_out = $database->query($sql_out);

if ($row_out = $result_out->fetch()){
    $check_out_txt = date('H:i', strtotime($row_out['CHECKTIME']));
    $check_out = date('H:i', strtotime($row_out['CHECKTIME']));
    $date_out  = date('Y-m-d H:i:s', strtotime($row_out['CHECKTIME']));
}
else{
    $check_out_txt = '';
    $check_out = '00:00';
    $date_out  = date('Y-m-d H:i:s', strtotime($row_out['CHECKTIME']));
}


    $late_min_chk = calculating_late_chk($check_in,'08:00');
    if ($late_min_chk < 0){
        $late_txt   = calculating_late('08:00',$check_in);
        $grand_late = calculate_time_span('08:00',$check_in);
    }else{
        $late_txt   = '';
        $grand_late = 0;
    }

    @$total_late += $grand_late;



    //pengecekan jumlah telat
    if($late_txt!=''){
      $total_terlambat = $total_terlambat + 1;
    }


    
   

    //pengecekan Alpa

    $N     = "";
    $N     = date('N', strtotime($date));
    if($check_in_txt == '' && $check_out_txt == '' 
        && (
            check_array_cuti($date,$datacuti) &&
            check_array_ijin($date,$dataijindata) &&
            check_array_libur($date,$dataliburdata) &&
            check_sakit_tanpa_surat($date,$dataijindata)
            ) 
        && ($N<>"6" && $N<>"7") ) {
        $total_alpa = $total_alpa + 1;
    }

 


    //pengecekan Lalai Finger
    if( ($check_in_txt == '' && $check_out_txt <> '') || ($check_in_txt <> '' && $check_out_txt == '') ){
        $total_lalai_finger = $total_lalai_finger + 1;
    }






$no++;  
   
    
}

}
else{
 
  /*   
  echo '<div class="alert alert-danger">
       <strong>FAILED:</strong> Data Not Found! Please Contact HRD<a class="close" data-dismiss="alert">×</a>
       </div>';
  */
}

/*
$total_terlambat = 0;
$total_cuti = 0;
$total_libur_nasional = 0;
$total_libur_bersama = 0;
$total_sakit_tanpa_surat_dokter = 0;
$total_sakit_dengan_surat_dokter = 0;
*/

$total_terlambat_persen = 0;
$total_terlambat_persen = round(($total_late/$menit_kerja_perbulan) * 100,1); 

$total_cuti_menit = 0; $total_cuti_persen = 0;
$total_cuti_menit       = $total_cuti*$menit_kerja_perhari;
$total_cuti_persen      = round(($total_cuti/$hari_kerja) * 100,1); 

$total_sakit_tanpa_surat_dokter_menit = 0; $total_sakit_tanpa_surat_dokter_persen = 0;
$total_sakit_tanpa_surat_dokter_menit = $total_sakit_tanpa_surat_dokter*$menit_kerja_perhari;
$total_sakit_tanpa_surat_dokter_persen = round(($total_sakit_tanpa_surat_dokter/$hari_kerja) * 100,1); 

$total_sakit_dengan_surat_dokter_menit = 0; $total_sakit_dengan_surat_dokter_persen = 0;
$total_sakit_dengan_surat_dokter_menit = $total_sakit_dengan_surat_dokter*$menit_kerja_perhari;
$total_sakit_dengan_surat_dokter_persen = round(($total_sakit_dengan_surat_dokter/$hari_kerja) * 100,1);

$total_ijin_menit = 0; $total_ijin_persen = 0;
$total_ijin_menit = $total_ijin*$menit_kerja_perhari;
$total_ijin_persen = round(($total_ijin/$hari_kerja) * 100,1);

$total_alpa_menit = 0; $total_alpa_persen = 0;
$total_alpa_menit = $total_alpa*$menit_kerja_perhari;
$total_alpa_persen = round(($total_alpa/$hari_kerja) * 100,1);

$total_lalai_finger_menit = 0; $total_lalai_finger_persen = 0;
$total_lalai_finger_menit = $total_lalai_finger*$menit_kerja_perhari;
$total_lalai_finger_persen = round(($total_lalai_finger/$hari_kerja) * 100,1);

$total_efektif_kerja       = $hari_kerja - $total_sakit_dengan_surat_dokter - $total_sakit_tanpa_surat_dokter - $total_cuti - $total_ijin - $total_alpa;
$total_efektif_kerja_menit = $menit_kerja_perbulan - ($total_late + $total_cuti_menit + $total_sakit_tanpa_surat_dokter_menit + $total_sakit_dengan_surat_dokter_menit + $total_ijin_menit + $total_alpa_menit ); 


$total_hadir_persen = round(($total_efektif_kerja_menit/$menit_kerja_perbulan) * 100,1);
$total_tdk_hadir_persen = round(100 - $total_hadir_persen,2)




?>


<tr>
    <td class="tg-0laxdetail"><?php echo $norekap; ?></td>
    <td class="tg-0laxdetail"><?php echo $session_nik; ?></td>
    <td class="tg-0laxdetail"><?php echo $namakary; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_sakit_tanpa_surat_dokter; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_sakit_tanpa_surat_dokter_menit; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_sakit_tanpa_surat_dokter_persen; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_sakit_dengan_surat_dokter; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_sakit_dengan_surat_dokter_menit; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_sakit_dengan_surat_dokter_persen; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_ijin; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_ijin_menit; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_ijin_persen; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_alpa; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_alpa_menit; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_alpa_persen; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_cuti; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_cuti_menit; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_cuti_persen; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_terlambat; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_late; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_terlambat_persen; ?></td>
    <td class="tg-0laxdetail">0</td>
    <td class="tg-0laxdetail">0</td>
    <td class="tg-0laxdetail">0</td>
    <td class="tg-0laxdetail"><?php echo $total_lalai_finger; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_lalai_finger_persen; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_efektif_kerja; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_efektif_kerja_menit; ?></td>
    <td class="tg-0laxdetail"><?php echo $total_tdk_hadir_persen; ?>%</td>
    <td class="tg-0laxdetail"><?php echo $total_hadir_persen; ?>%</td>
 </tr>




<?php



} // akhir load karyawan

echo '</table>';
// ========================================================== END LOAD DATA ==============================================================


// List of function on this page

function day_name($date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter){

    $tanggal  = date('Y-m-d', strtotime($date));

    $query  = mysql_query("SELECT * FROM tbl_holiday WHERE Tanggal='$tanggal'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);
    
    $cutiid = "";
    

    $countdatacuti = sizeof($datacuti); //untuk mengecek data di dalam array
    $countdataliburbersama = sizeof($dataliburbersama); //untuk mengecek data di dalam array
    $countsakittanpasuratdokter = sizeof($datasakittanpasuratdokter); //untuk mengecek data di dalam array
    $countsakitdengansuratdokter = sizeof($datasakitdengansuratdokter); //untuk mengecek data di dalam array
    
    
    $N      = date('N', strtotime($date));

      if ($N==1){
        $kyou = 'Senin';
      }
      elseif ($N==2){
        $kyou = 'Selasa';
      }
      elseif ($N==3){
        $kyou = 'Rabu';
      }
      elseif ($N==4){
        $kyou = 'Kamis';
      }
      elseif ($N==5){
        $kyou = 'Jumat';
      }
      elseif ($N==6){
        $kyou = 'Sabtu';
      }
      elseif ($N==7){
        $kyou = 'Minggu';
      }
      else{
        $kyou = '';
      }


      if ($total>0 || $kyou=='Minggu' || $kyou=='Sabtu' || $countdataliburbersama>0){
            return '<font color="red"><strong>'.$kyou.'</strong></font>';
      }elseif($countdatacuti>0 || $countsakittanpasuratdokter || $countsakitdengansuratdokter) {
            return '<font color="blue"><strong>'.$kyou.'</strong></font>';
      }else{
            return $kyou;
      }

      

}


function format_tanggal($date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter){

    $tgl    = date('Y-m-d', strtotime($date));
    $query  = mysql_query("SELECT * FROM tbl_holiday WHERE Tanggal='$tgl'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    $N      = date('N', strtotime($date));


    $countdatacuti = sizeof($datacuti); //untuk mengecek data di dalam arra
    $countdataliburbersama = sizeof($dataliburbersama); //untuk mengecek data di dalam array
    $countsakittanpasuratdokter = sizeof($datasakittanpasuratdokter); //untuk mengecek data di dalam array
    $countsakitdengansuratdokter = sizeof($datasakitdengansuratdokter); //untuk mengecek data di dalam array

    if ($N==1){
        $kyou = 'Senin';
      }
      elseif ($N==2){
        $kyou = 'Selasa';
      }
      elseif ($N==3){
        $kyou = 'Rabu';
      }
      elseif ($N==4){
        $kyou = 'Kamis';
      }
      elseif ($N==5){
        $kyou = 'Jumat';
      }
      elseif ($N==6){
        $kyou = 'Sabtu';
      }
      elseif ($N==7){
        $kyou = 'Minggu';
      }
      else{
        $kyou = '';
      }

      $tanggal  = date('d-M-Y', strtotime($date));

      if ($total>0 || $kyou=='Minggu' || $kyou=='Sabtu' || $countdataliburbersama>0){
            return '<font color="red"><strong>'.$tanggal.'</strong></font>';
      }elseif($countdatacuti>0 || $countsakittanpasuratdokter || $countsakitdengansuratdokter){
            return '<font color="blue"><strong>'.$tanggal.'</strong></font>';
      }else{
            return $tanggal;
      } 
 

}



function color_td($value,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter){


  $countdatacuti = sizeof($datacuti); //untuk mengecek data di dalam array
  $countdatalibur = sizeof($datalibur); //untuk mengecek data di dalam array
  $countdataliburbersama = sizeof($dataliburbersama); //untuk mengecek data di dalam array
  $countsakittanpasuratdokter = sizeof($datasakittanpasuratdokter); //untuk mengecek data di dalam array
  $countsakitdengansuratdokter = sizeof($datasakitdengansuratdokter); //untuk mengecek data di dalam array
  if($countdatacuti>0 || $countdatalibur>0 || $countdataliburbersama>0 || $countsakittanpasuratdokter>0 || $countsakitdengansuratdokter>0) {
     return 'yellow';
  }
  else {
    if ($value %2==0){
        return '#F7F7F7';
    }
    else{
        return '';
    } 
  }
  

}



function calculating_time($time1,$time2){ 
  
    list($hours, $minutes) = explode(':', $time1);
    $startTimestamp = mktime($hours, $minutes);

    list($hours, $minutes) = explode(':', $time2);
    $endTimestamp = mktime($hours, $minutes);

    $seconds = $endTimestamp - $startTimestamp;
    $minutes = ($seconds / 60) % 60;
    $hours = floor($seconds / (60 * 60));

      if ($time2 !='00:00'){
          return $hours.'h'.$minutes.'min';
      }else{
          return '-';
      }

}


function calculating_late($time1,$time2){  
  
    list($hours, $minutes) = explode(':', $time1);
    $startTimestamp = mktime($hours, $minutes);

    list($hours, $minutes) = explode(':', $time2);
    $endTimestamp = mktime($hours, $minutes);

    $seconds  = $endTimestamp - $startTimestamp;
    $minutes  = abs(($seconds / 60) % 60);
    $hours    = abs(floor($seconds / (60 * 60)));

    return $hours.'h'.$minutes.'min';

}

function calculating_late_chk($time1,$time2){  
  
    list($hours, $minutes) = explode(':', $time1);
    $startTimestamp = mktime($hours, $minutes);

    list($hours, $minutes) = explode(':', $time2);
    $endTimestamp = mktime($hours, $minutes);

    $seconds  = $endTimestamp - $startTimestamp;
    $minutes  = ($seconds / 60) % 60;
    $hours    = floor($seconds / (60 * 60));

    return $minutes;

}

function calculating_early($time1,$time2){  
  
    list($hours, $minutes) = explode(':', $time1);
    $startTimestamp = mktime($hours, $minutes);

    list($hours, $minutes) = explode(':', $time2);
    $endTimestamp = mktime($hours, $minutes);

    $seconds  = $endTimestamp - $startTimestamp;
    $minutes  = abs(($seconds / 60) % 60);
    $hours    = abs(floor($seconds / (60 * 60)));

    return $hours.'h'.$minutes.'min';

}

function calculating_early_chk($time1,$time2){  
  
    list($hours, $minutes) = explode(':', $time1);
    $startTimestamp = mktime($hours, $minutes);

    list($hours, $minutes) = explode(':', $time2);
    $endTimestamp = mktime($hours, $minutes);

    $seconds  = $endTimestamp - $startTimestamp;
    $minutes  = ($seconds / 60) % 60;
    $hours    = ($seconds / (60 * 60));

    return $hours;

}

function calculating_over($time1,$time2){  
  
    list($hours, $minutes) = explode(':', $time1);
    $startTimestamp = mktime($hours, $minutes);

    list($hours, $minutes) = explode(':', $time2);
    $endTimestamp = mktime($hours, $minutes);

    $seconds  = $endTimestamp - $startTimestamp;
    $minutes  = abs(($seconds / 60) % 60);
    $hours    = abs(floor($seconds / (60 * 60)));

    return $hours.'h'.$minutes.'min';

}

function calculating_over_chk($time1,$time2){  
  
    list($hours, $minutes) = explode(':', $time1);
    $startTimestamp = mktime($hours, $minutes);

    list($hours, $minutes) = explode(':', $time2);
    $endTimestamp = mktime($hours, $minutes);

    $seconds  = $endTimestamp - $startTimestamp;
    $minutes  = ($seconds / 60) % 60;
    $hours    = ($seconds / (60 * 60));

    return $hours;

}

function calculating_grand_late($time1,$time2){  
  
    list($hours, $minutes) = explode(':', $time1);
    $startTimestamp = mktime($hours, $minutes);

    list($hours, $minutes) = explode(':', $time2);
    $endTimestamp = mktime($hours, $minutes);

    $seconds  = $endTimestamp - $startTimestamp;
    $minutes  = ($seconds / 60) % 60;
    $hours    = ($seconds / (60 * 60));

    return $minutes;

}


function calculate_time_span($time1,$time2){
        $seconds  = strtotime($time2) - strtotime($time1);

        $months = floor($seconds / (3600*24*30));
        $day = floor($seconds / (3600*24));
        $hours = floor($seconds / 3600);
        $mins = (($seconds - ($hours*3600)) / 60);
        $secs = floor($seconds % 60);

        if($seconds < 60)
            $time = $secs." seconds ago";
        else if($seconds < 60*60 )
            $time = $mins." min ago";
        else if($seconds < 24*60*60)
            $time = $hours." hours ago";
        else if($seconds < 24*60*60)
            $time = $day." day ago";
        else
            $time = $months." month ago";

        $start_ts = strtotime($time1);
        $end_ts = strtotime($time2); 
        $minutes_per_day = (int)(($end_ts - $start_ts)/60);

        return $minutes_per_day;
}


function minutes_to_hours($nm, $lZ = true){
    $mins = $nm % 60;
    if($mins == 0)    $mins = "0$mins";

    $hour = floor($nm / 60);
    if($lZ){
      if($hour < 10) return $hour.' h '.$mins.' min';
    }

    return $hour.' h '.$mins.' min';
}



function check_cuti($periode1,$periode2,$session_nik){

  $tgl    = date('Y-m-d', strtotime($date));
  $mysqlcomm = "SELECT a.cutiid,keperluan,tglcuti,tglmasuk FROM tbl_formcuti a, tbl_formcutidetail b 
                         WHERE a.cutiid=b.cutiid AND formcutinik = ".$session_nik." AND statusForm = 'A' 
                         AND (tglcuti BETWEEN '".$periode1."' AND '".$periode2."') AND JenisCuti NOT IN (4) ";

                     
  $query  = mysql_query($mysqlcomm);
  $total  = mysql_num_rows($query);
  $datacuti = array();

  while ($data = mysql_fetch_array($query)){

    $datacuti[] = array('cutiid' => $data['cutiid'],
                      'keperluan' => $data['keperluan'],
                      'tglcuti' => $data['tglcuti'],
                      'tglmasuk' => $data['tglmasuk']     
                      );
    

  }



  return $datacuti;

}




function check_ijin_record($periode1,$periode2,$session_nik){

  $tgl    = date('Y-m-d', strtotime($date));
  $mysqlcomm = "SELECT SUM(sakittanpasurat) sakittanpasurat,SUM(sakitdengansurat) sakitdengansurat,SUM(lain) lain FROM (
                SELECT
                CASE WHEN jenisijin = 3 AND tglactive1>='".$periode1."' AND tglactive1<='".$periode2."' THEN 1 ELSE 0 END sakittanpasurat,
                CASE WHEN jenisijin = 10 AND DATEDIFF(tglactive2,tglactive1) IS NOT NULL THEN DATEDIFF(tglactive2,tglactive1) ELSE 0 END sakitdengansurat,
                CASE WHEN jenisijin = 9 AND DATEDIFF(tglactive2,tglactive1) IS NOT NULL THEN DATEDIFF(tglactive2,tglactive1) ELSE 0 END lain
                FROM (
                SELECT jenisijin,
                CASE WHEN tglactive1<'".$periode1."' THEN '".$periode1."' ELSE tglactive1 END tglactive1,
                CASE WHEN tglactive2>'".$periode2."' THEN '".$periode2."' ELSE tglactive2 END tglactive2
                FROM tbl_formijin WHERE (tglactive1>='".$periode1."' OR tglactive2<='".$periode2."') AND nik = ".$session_nik." ) a
                ) a";

  $query  = mysql_query($mysqlcomm);
  $total  = mysql_num_rows($query);


  
  while ($data = mysql_fetch_array($query)){

    if($data['sakittanpasurat']>0){ $sakittanpasurat = $data['sakittanpasurat'];} else { $sakittanpasurat = 0; }
    if($data['sakitdengansurat']>0){ $sakitdengansurat = $data['sakitdengansurat'];} else { $sakitdengansurat = 0; }
    if($data['lain']>0){ $lain = $data['lain'];} else { $lain = 0; }

    $dataijin =         array('sakittanpasurat' => $sakittanpasurat,
                              'sakitdengansurat' => $sakitdengansurat,   
                              'lain' => $lain,
                        );
    
  }

  return $dataijin;

}

function check_ijin_data($periode1,$periode2,$session_nik){

  $tgl    = date('Y-m-d', strtotime($date));
  $mysqlcomm = "SELECT DATE(tglactive1) tglactive1,DATE(tglactive2) tglactive2 FROM tbl_formijin WHERE (tglactive1>='".$periode1."' OR tglactive2<='".$periode2."') 
                AND nik = ".$session_nik." AND statusform = 'A' ";

                     
  $query  = mysql_query($mysqlcomm);
  $total  = mysql_num_rows($query);
  $dataijindata = array();

  while ($data = mysql_fetch_array($query)){

    $dataijindata[] = array('tglactive1' => $data['tglactive1'],
                            'tglactive2' => $data['tglactive2']                
                      );
    

  }



  return $dataijindata;

}


function check_libur($periode1,$periode2,$session_nik){


  $mysqlcomm = "SELECT * FROM (
                SELECT tglcuti FROM tbl_formcutimasaldetail UNION ALL
                SELECT tanggal FROM tbl_holiday ) a WHERE tglcuti BETWEEN '".$periode1."' AND '".$periode2."'";

               
  $query  = mysql_query($mysqlcomm);
  $total  = mysql_num_rows($query);
  $dataliburdata = array();

  while ($data = mysql_fetch_array($query)){

    $dataliburdata[] = array('tgllibur' => $data['tglcuti']                            
                            );
    

  }



  return $dataliburdata;


}


function check_array_cuti($date,$datacuti){
  $hitung = 0;  
  $countarraydatacuti = sizeof($datacuti); //untuk mengecek data di dalam array  
  for($i=0;$i<=$countarraydatacuti-1;$i++){ 
      if ($date==$datacuti[$i][tglcuti]) {        
          $hitung = $hitung + 1;
      } 
  } 

  if($hitung>0) {
    return false;
  } else {
    return true;
  }


}


function check_array_ijin($date,$dataijindata){


  $hitung = 0;  
  $countarraydataijindata = sizeof($dataijindata); //untuk mengecek data di dalam array  
  for($i=0;$i<=$countarraydataijindata-1;$i++){ 
      if ($date>=$dataijindata[$i][tglactive1] && $date<=$dataijindata[$i][tglactive2]) {        
          $hitung = $hitung + 1;
      } 
  } 


  if($hitung>0) {
    return false;
  } else {
    return true;
  }

/*
  return true;
*/
}

function check_sakit_tanpa_surat($date,$dataijindata){


  $hitung = 0;  
  $countarraydataijindata = sizeof($dataijindata); //untuk mengecek data di dalam array  
  for($i=0;$i<=$countarraydataijindata-1;$i++){ 
      if ($date==$dataijindata[$i][tglactive1]) {        
          $hitung = $hitung + 1;
      } 
  } 



  if($hitung>0) {
    return false;
  } else {
    return true;
  }

/*
  return true;
*/
}


function check_array_libur($date,$dataliburdata){

  
  $hitung = 0;  
  $countarraydataliburdata = sizeof($dataliburdata); //untuk mengecek data di dalam array  
  for($i=0;$i<=$countarraydataliburdata-1;$i++){ 
      if ($date==$dataliburdata[$i][tgllibur]) {        
          $hitung = $hitung + 1;
      } 
  } 

  if($hitung>0) {
    return false;
  } else {
    return true;
  }



}






 




?>



<style>
/*
A:link { COLOR: blue; TEXT-DECORATION: none; font-weight: none }
A:visited { COLOR: blue; TEXT-DECORATION: none; font-weight: none }
A:active { COLOR: blue; TEXT-DECORATION: none }
A:hover { COLOR: #FF0000; TEXT-DECORATION: underline; font-weight: none }
.right { text-align: right;}
.center { text-align: center;}
*/

.buttonme {
display: block;
width: 115px;
height: 45px;
background: #4E9CAF;
padding: 10px;
text-align: center;
border-radius: 5px;
color: white;
font-weight: bold;
}


table.tftableon {

font-size:12px;
color:#333333;
border-width: 1px;
border-color: #729ea5;
border-collapse: collapse;
background-color: #FFFFFF;
padding:1px;

}

table.tftableon th {
font-size:12px;
background-color:#CCCCCC;
border-width: 1px;
padding: 2px;
border-style: solid;
border-color:#999999;
text-align:center;
background: url("https://apps.unias.com/hris2/images/bg3.gif") repeat;
height: 30px;
}
table.tftableon td {
font-size:12px;
height: 24px;
border-width: 1px;
padding: 3px;
border-style: solid;
border-color:#999999;

}

table.tftableondetail {

font-size:12px;
color:#333333;
border-width: 1px;
border-color: #729ea5;
border-collapse: collapse;
background-color: #FFFFFF;

}

table.tftableondetail th {
font-size:14px;
background-color:#CCCCCC;
border-width: 1px;
padding: 2px;
border-style: solid;
border-color:#999999;
text-align:center;
background: url("https://apps.unias.com/hris2/images/bg.gif") repeat;

}
table.tftableondetail td {
font-size:12px;
border-width: 1px;
padding: 2px;
border-style: solid;
border-color:#999999;

}


table.tftableon tr {
background-color:#FFFFFF;
}

#tfhover{
    border-collapse:collapse;
}
#tfhover tr {
    background-color:transparent;
}
#tfhover tr:hover td  {
  background-color:#D7EFFD;
}
#tfhover tr td.link{
    background-color:transparent;
}
</style>

<style type="text/css">

table.tabborder {border-width:1px; border-spacing:0px; border-style:solid; 
     border-color:gray; border-collapse:separate; background-color:white;}
table.tabborder th,
table.tabborder td {border-width:1px; padding:2px;  border-style:inset; 
     border-color: black;background-color:white;}
.bold8 {width:50px; font-size:9px; font-family:arial; text-align:center; 
     font-weight:bold;}
.pt8 {width:10px; font-size:9px; font-family:arial; text-align:center;}
.gaya {
    font-size: 11px;
    font-family: Arial;}

.social {
    width:70px;
    float:right;
    padding-top:5px;
}

.social ul {
    list-style: none;
}

.social ul li {
    float:left;
    width:21px;
    height:24px;
    margin:0;
    padding:0;
    margin-left:6px;
}



</style>