<?php
include "../../koneksi/koneksi.php";
$day = date ("d-m-Y_H:i:s");
$session_nik  = $_GET['NIK'];
$periode_id   = $_GET['PRD'];
$current_year = date("Y");

$file_name   = $session_nik.'_'.$day;


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=REPORT_EMPLOYEE_ATTENDANCE_$file_name.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");



$tampil = mysql_query("SELECT * FROM tbl_profile WHERE NIK='$session_nik'");
$total  = mysql_num_rows($tampil);
$data   = mysql_fetch_array($tampil);

$TglMasuk = date('d-M-Y', strtotime($data['TglMasuk']));
$dept      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_dept WHERE iDeptID='$data[DeptID]'"));
$jabatan   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jabatan WHERE JabatanId='$data[JabatanID]'"));
$divisi    = mysql_fetch_array(mysql_query("SELECT * FROM tbl_div WHERE iDivID='$data[DivisiID]'"));
$unit      = mysql_fetch_array(mysql_query("SELECT NamaUnit FROM tbl_unit WHERE unitID='$data[UnitID]'"));
$company   = mysql_fetch_array(mysql_query("SELECT cCompanyName FROM tbl_company WHERE iCompanyID='$data[CompanyId]'"));


$sql_periode      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_Periode WHERE iPeriodId='$periode_id'"));

if ($periode_id != 0){
    $Periode1 = date('m/j/Y', strtotime($sql_periode['dPeriodStartDate']));
    $Periode2 = date('m/j/Y', strtotime($sql_periode['dPeriodEndDate']));
}
else{
    $Periode1 = '1/1/'.$current_year;
    $Periode2 = '12/31/'.$current_year;
}


$db_username = 'Admin';
$db_password = '';

//path to database file ASTABS02
$database_path = "\\\\ASTABS02\\Att\\att2000.mdb";

//check file exist before we proceed
if (!file_exists($database_path)) {
    die("Access database file not found !");
}

$database = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$database_path; Uid=$db_username; Pwd=$db_password;");


$sql  = "SELECT DateValue([CHECKTIME]) AS Tanggal
FROM CHECKINOUT INNER JOIN USERINFO ON CHECKINOUT.USERID = USERINFO.USERID
WHERE (((USERINFO.Badgenumber)='$session_nik')) 
GROUP BY DateValue([CHECKTIME]) 
HAVING (((DateValue([CHECKTIME])) >=#$Periode1#) AND (DateValue([CHECKTIME])) <=#$Periode2#)
ORDER BY DateValue([CHECKTIME])";
$result = $database->query($sql);





if ($row = $result->fetch()){

$profile  = "SELECT TOP 1 USERINFO.Badgenumber,USERINFO.USERID FROM USERINFO WHERE (((USERINFO.Badgenumber)='$session_nik'))";
$query_me    = $database->query($profile);

if ($wisky = $query_me->fetch()){
    $USERID = $wisky['USERID'];   
}
else{
    $USERID = '';
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Absensi</title>
</head>

<style>
body{
    font-family:Arial;
}
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
    font-family: Arial;
    font-size:12px;
    color:#333333;
    border-width: 1px;
    border-color: #729ea5;
    border-collapse: collapse;
    background-color: #FFFFFF;
    padding:1px;
    vertical-align: middle;

}

table.tftableon th {
    font-size:12px;
    background-color:#CCCCCC;
    border-width: 1px;
    padding: 2px;
    border-style: solid;
    border-color:#999999;
    text-align:center;
    background: url("http://appservices.unias.com/hris2/images/bg3.gif") repeat;
    height: 30px;
    vertical-align: middle;
}
table.tftableon td {
    font-size:12px;
    height: 24px;
    border-width: 1px;
    padding: 3px;
    border-style: solid;
    border-color:#999999;
    vertical-align: middle;

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
    background: url("http://appservices.unias.com/hris2/images/bg.gif") repeat;
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

table.tabborder {
    border-width:1px; border-spacing:0px; border-style:solid;
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
    width:100px;
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

td.thickBorder{
    border-right:0px;
}


</style>

<body>
<table id="tfhover" class="tftableon" width="800" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td height="30" colspan="12"><div align="left"><font size="+3"><strong>REPORT EMPLOYEE ATTENDANCE <?php echo $company['cCompanyName'] ?></strong></font></div></td>
  </tr>
  
  <tr>
    <td colspan="3"><strong>Fingerprint ID</strong></td>
    <td colspan="3"><div align="left"><?php echo $USERID ?></div></td>
    <td colspan="2"><strong>Employee Title</strong></td>
    <td colspan="4"><div align="left"><?php echo $jabatan['NamaJabatan'] ?></div></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Employee Code</strong></td>
    <td colspan="3"><div align="left"><?php echo $data['NIK'] ?></td>
    <td colspan="2"><strong>Employee Hire Date</strong></td>
    <td colspan="4"><div align="left"><?php echo $TglMasuk ?></div></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Employee Name</strong></td>
    <td colspan="3"><?php echo $data['Nama'] ?></td>
    <td colspan="2"><strong>Division Name</strong></td>
    <td colspan="4"><?php echo $divisi['cDivName'] ?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Department Name</strong></td>
    <td colspan="3"><?php echo $dept['cDeptName'] ?></td>
    <td colspan="2"><strong>Unit Name</strong></td>
    <td colspan="4"><?php echo $unit['NamaUnit'] ?></td>
  </tr>
  <tr>
    <td colspan="12">&nbsp;</td>    
  </tr>
  <tr>
    <th width="30"><div align=center>No</div></th>
    <th width="60"><div align=center>Day</div></th>
    <th width="70">Date</th>
    <th width="90"><div align=center>Working Hour</div></th>
    <th width="60"><div align=center>Activity</div></th>               
    <th width="60"><div align=center>Duty On</div></th>
    <th width="60"><div align=center>Duty Off</div></th>
    <th width="70"><div align=center>Late In</div></th>
    <th width="70"><div align=center>Early Departure</div></th>
    <th width="70"><div align=center>Over Time</div></th> 
    <th width="70"><div align=center>Total Hour</div></th>
    <th width="90"><div align=center>Notes</div></th>   
  </tr>

<?php
$no=1;




$date = date("Y-m-d", strtotime($Periode1 . " -1 day"));
$final_date = date("Y-m-d", strtotime($Periode2));

$total_terlambat = 0;
$total_cuti = 0;
$total_libur_nasional = 0;
$total_libur_bersama = 0;
$total_sakit_tanpa_surat_dokter = 0;
$total_sakit_dengan_surat_dokter = 0;

while($date < $final_date){
   $date = date("Y-m-d", strtotime($date . " +1 day"));
   $dates[] = $date;

  $Tanggal  = date('d-M-Y', strtotime($row['Tanggal']));
  $day      = date('N', strtotime($row['Tanggal']));
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



    $grand_total = calculate_time_span($check_in,$check_out);

    if ($check_out == '00:00' || $check_in == '00:00'){
        $grand_all_chk = 0;
        $total_work = '';
    }

    else{
        $grand_all_chk = $grand_total;
        $total_work = calculating_time($check_in,$check_out);
    }

    @$total_all += $grand_all_chk;


    $late_min_chk = calculating_late_chk($check_in,'08:00');
    if ($late_min_chk < 0){
        $late_txt   = calculating_late('08:00',$check_in);
        $grand_late = calculate_time_span('08:00',$check_in);
    }else{
        $late_txt   = '';
        $grand_late = 0;
    }

    @$total_late += $grand_late;


    $early_min_chk = calculating_early_chk('08:00',$check_in);
    if ($early_min_chk < 0 && $check_in !='00:00'){
        $early_txt = calculating_early($check_in,'08:00');  
        $grand_early = calculate_time_span($check_in,'08:00');
      
    }else{
        $early_txt = '';
        $grand_early = 0;     
      
    }

    @$total_early += $grand_early;


    $over_min_chk = calculating_over_chk($check_out,'17:00');
    if ($over_min_chk < 0){
        $over_txt = calculating_over('17:00',$check_out);
        $grand_over = calculate_time_span('17:00',$check_out);
    }else{
        $over_txt = '';
        $grand_over = 0;
    }

    @$total_over += $grand_over;

    //pengecekan jumlah telat
    if($late_txt!=''){
      $total_terlambat = $total_terlambat + 1;
    }

    //pengecekan jumlah cuti
    $datacuti = check_cuti($date,$session_nik);
    $countdatacuti = sizeof($datacuti); //untuk mengecek data di dalam array
    if($countdatacuti>0){
      $total_cuti = $total_cuti + 1;
    }

    //pengecekan jumlah libur bersama
    $dataliburbersama = check_libur_bersama($date,$session_nik);
    $countdataliburbersama = sizeof($dataliburbersama); //untuk mengecek data di dalam array
    if($countdataliburbersama>0){
      $total_libur_bersama = $total_libur_bersama + 1;
    }

    //pengecekan jumlah libur nasional
    $datalibur = check_libur_nasional($date,$session_nik);
    $countdatalibur = sizeof($datalibur); //untuk mengecek data di dalam array
    if($countdatalibur>0){
      $total_libur_nasional = $total_libur_nasional + 1;
    }

    //pengecekan sakit tanpa surat dokter
    $datasakittanpasuratdokter = check_sakit_tanpa_surat_dokter($date,$session_nik);
    $countsakittanpasuratdokter = sizeof($datasakittanpasuratdokter); //untuk mengecek data di dalam array
    if($countsakittanpasuratdokter>0){
      $total_sakit_tanpa_surat_dokter = $total_sakit_tanpa_surat_dokter + 1;
    }

    //pengecekan sakit tanpa surat dokter
    $datasakitdengansuratdokter = check_sakit_dengan_surat_dokter($date,$session_nik);
    $countsakitdengansuratdokter = sizeof($datasakitdengansuratdokter); //untuk mengecek data di dalam array
    if($countsakitdengansuratdokter>0){
      $total_sakit_dengan_surat_dokter = $total_sakit_dengan_surat_dokter + 1;
    }

    echo'<tr>
        
        <td bgcolor='.color_td($week,$date,$session_nik).'><div align="center">'.$no.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik).'><div align="center">'.day_name($date,$session_nik).'</div></td>                   
        <td bgcolor='.color_td($week,$date,$session_nik).'><div align="center">'.format_tanggal($date,$session_nik).'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik).'><div align="center">'.status_empty_data($in=$check_in_txt, $out=$check_out_txt, $text='08:00 - 17:00',$date,$session_nik).'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik).'><div align="center">'.status_empty_data($in=$check_in_txt, $out=$check_out_txt, $text='Work',$date,$session_nik).'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik).'><div align="center">'.$check_in_txt.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik).'><div align="center">'.$check_out_txt.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik).'><div align="center">'.$late_txt.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik).'><div align="center">'.$early_txt.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik).'><div align="center">'.$over_txt.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik).'><div align="center">'.$total_work.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik).'><div align="center">'.status_empty_data($in=$check_in_txt, $out=$check_out_txt, $text='Working Hour',$date,$session_nik).'</div></td>        
        </tr>';

$no++;
   
    
}


echo '<tr>
        <th colspan="7"><div align="center"><strong>Total</strong></div></th>
        <th><div align="center"><strong>'.minutes_to_hours($total_late).'</strong></div></th>
        <th><div align="center"><strong>'.minutes_to_hours($total_early).'</strong></div></th>
        <th><div align="center"><strong>'.minutes_to_hours($total_over).'</strong></div></th>
        <th><div align="center"><strong>'.minutes_to_hours($total_all).'</strong></div></th>
        <th><div align="center"><strong></strong></div></th>
      </tr>
      </table>
      <table>
        <tr>
            <td>Jumlah Terlambat</td>
            <td>&nbsp;:</td>
            <td style="text-align:right;width:30%;">'.$total_terlambat.' Hari </td>
            <td>( '.minutes_to_hours($total_late).' )</td>
        </tr>
        <tr>
            <td>Jumlah Cuti</td>
            <td>&nbsp;:</td>
            <td style="text-align:right;width:30%;">'.$total_cuti.' Hari</td>
            <td></td>
        </tr>
        <tr>
            <td>Jumlah Libur Nasional</td>
            <td>&nbsp;:</td>
            <td style="text-align:right;width:30%;">'.$total_libur_nasional.' Hari</td>
            <td></td>
        </tr>
        <tr>
            <td>Jumlah Libur Bersama</td>
            <td>&nbsp;:</td>
            <td style="text-align:right;width:30%;">'.$total_libur_bersama.' Hari</td>
            <td></td>
        </tr>
        <tr>
            <td>Jumlah Sakit (Tanpa Surat)</td>
            <td>&nbsp;:</td>
            <td style="text-align:right;width:30%;">'.$total_sakit_tanpa_surat_dokter.' Hari</td>
            <td></td>
        </tr>
        <tr>
            <td>Jumlah Sakit (Dengan Surat)</td>
            <td>&nbsp;:</td>
            <td style="text-align:right;width:30%;">'.$total_sakit_dengan_surat_dokter.' Hari</td>
            <td></td>
        </tr>
      </table>
      </body>
</html>';


}
else{

}


function day_name($date){

    $tanggal  = date('Y-m-d', strtotime($date));

    $query  = mysql_query("SELECT * FROM tbl_holiday WHERE Tanggal='$tanggal'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

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

      if ($total>0 || $kyou=='Minggu'){

            return '<font color="red"><strong>'.$kyou.'</strong></font>';

      }else{
            return $kyou;
      }

}

function format_tanggal($date){

    $tgl    = date('Y-m-d', strtotime($date));
    $query  = mysql_query("SELECT * FROM tbl_holiday WHERE Tanggal='$tgl'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

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

      $tanggal  = date('d-M-Y', strtotime($date));

      if ($total>0 || $kyou=='Minggu'){
            return '<font color="red"><strong>'.$tanggal.'</strong></font>';
      }else{
            return $tanggal;
      } 
 

}



/*
function status_empty_date($in,$out,$text){

    if (empty($in) && empty($out)){
        return '';
    }else{
        return $text;
    }

}



function color_td($value){

  if ($value %2==0){
      return '#F7F7F7';
  }
  else{
      return '';
  }

}
*/


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
      if($hour < 10) return $hour.'h'.$mins.'min';
    }

    return $hour.'h'.$mins.'min';
}

function madSafety($string) {
  $string = stripslashes($string);
  $string = strip_tags($string);
  $string = mysql_real_escape_string($string);
  return $string;
}



function check_cuti($date,$session_nik){

  $tgl    = date('Y-m-d', strtotime($date));
  $mysqlcomm = "SELECT a.cutiid,keperluan,tglcuti,tglmasuk FROM tbl_formcuti a, tbl_formcutidetail b 
                         WHERE a.cutiid=b.cutiid AND formcutinik = ".$session_nik." AND statusForm = 'A' AND tglcuti = '".$date."'";


  $query  = mysql_query($mysqlcomm);
  $total  = mysql_num_rows($query);

  while ($data = mysql_fetch_array($query)){

    $datacuti = array('cutiid' => $data['cutiid'],
                      'keperluan' => $data['keperluan'],
                      'tglcuti' => $data['tglcuti'],
                      'tglmasuk' => $data['tglmasuk']     
                      );
    

  }

  return $datacuti;

}


function check_libur_nasional($date,$session_nik){

  $tgl    = date('Y-m-d', strtotime($date));
  $mysqlcomm = "SELECT * FROM tbl_holiday WHERE Tanggal = '".$date."'";


  $query  = mysql_query($mysqlcomm);
  $total  = mysql_num_rows($query);

  while ($data = mysql_fetch_array($query)){

    $datalibur = array('liburid' => $data['id'],
                      'Keterangan' => $data['Keterangan'],   
                      );
    

  }

  return $datalibur;


}


function check_libur_bersama($date,$session_nik){

  $tgl    = date('Y-m-d', strtotime($date));
  $mysqlcomm = "SELECT a.CutiId,Keperluan FROM tbl_formcutimasal a, tbl_formcutimasaldetail b WHERE a.cutiid=b.cutiid AND tglcuti = '".$date."' AND StatusForm = 'A'";

  $query  = mysql_query($mysqlcomm);
  $total  = mysql_num_rows($query);

  while ($data = mysql_fetch_array($query)){
    $dataliburbersama = array('CutiId' => $data['CutiId'],
                       'Keperluan' => $data['Keperluan'],   
                      );
    

  }
  return $dataliburbersama;
}


function check_sakit_tanpa_surat_dokter($date,$session_nik){

  $tgl    = date('Y-m-d', strtotime($date));
  $mysqlcomm = "SELECT * FROM tbl_formijin WHERE nik = ".$session_nik." AND tglactive1 = '".$date."' AND statusform = 'A' AND Jenisijin = 3";

  $query  = mysql_query($mysqlcomm);
  $total  = mysql_num_rows($query);

  while ($data = mysql_fetch_array($query)){

    $datasakittanpasuratdokter = array('IjinId' => $data['IjinId'],
                              'Alasan' => $data['Alasan'],   
                      );
    
  }

  return $datasakittanpasuratdokter;

}

function check_sakit_dengan_surat_dokter($date,$session_nik){

  $tgl    = date('Y-m-d', strtotime($date));
  $mysqlcomm = "SELECT * FROM tbl_formijin WHERE nik = ".$session_nik." AND statusform = 'A' AND Jenisijin = 10 AND ('".$date."' BETWEEN TglActive1 AND TglActive2)";

  $query  = mysql_query($mysqlcomm);
  $total  = mysql_num_rows($query);

  while ($data = mysql_fetch_array($query)){

    $datasakitdengansuratdokter = array('IjinId' => $data['IjinId'],
                              'Alasan' => $data['Alasan'],   
                      );
    
  }

  return $datasakitdengansuratdokter;

}

function color_td($value,$date,$session_nik){

  $datacuti = check_cuti($date,$session_nik);
  $countdatacuti = sizeof($datacuti); //untuk mengecek data di dalam array

  $datalibur = check_libur_nasional($date,$session_nik);
  $countdatalibur = sizeof($datalibur); //untuk mengecek data di dalam array
  
  $dataliburbersama = check_libur_bersama($date,$session_nik);
  $countdataliburbersama = sizeof($dataliburbersama); //untuk mengecek data di dalam array

  $datasakittanpasuratdokter = check_sakit_tanpa_surat_dokter($date,$session_nik);
  $countsakittanpasuratdokter = sizeof($datasakittanpasuratdokter); //untuk mengecek data di dalam array

  $datasakitdengansuratdokter = check_sakit_dengan_surat_dokter($date,$session_nik);
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

function status_empty_data($in,$out,$text,$date,$session_nik){

    $datacuti = check_cuti($date,$session_nik);
    $countdatacuti = sizeof($datacuti); //untuk mengecek data di dalam arra

    $datalibur = check_libur_nasional($date,$session_nik);
    $countdatalibur = sizeof($datalibur); //untuk mengecek data di dalam arra

    $dataliburbersama = check_libur_bersama($date,$session_nik);
    $countdataliburbersama = sizeof($dataliburbersama); //untuk mengecek data di dalam arra

    $datasakittanpasuratdokter = check_sakit_tanpa_surat_dokter($date,$session_nik);
    $countsakittanpasuratdokter = sizeof($datasakittanpasuratdokter); //untuk mengecek data di dalam array

    $datasakitdengansuratdokter = check_sakit_dengan_surat_dokter($date,$session_nik);
    $countsakitdengansuratdokter = sizeof($datasakitdengansuratdokter); //untuk mengecek data di dalam array
    

    if($text=="Work"){
      
      if($countdatalibur>0){
        return '<font color="red"><strong>Libur Nasional</strong></font>';
      } elseif ($countdataliburbersama>0) {
        return '<font color="red"><strong>Libur Bersama</strong></font>';
      } elseif ($countdatacuti>0) {
        return '<font color="blue"><strong>CUTI</strong></font>';
      } elseif ($countsakittanpasuratdokter>0) {
        return '<font color="blue"><strong>Sakit (Tanpa Surat)</strong></font>';
      } elseif ($countsakitdengansuratdokter>0) {
        return '<font color="blue"><strong>Sakit (Dengan Surat)</strong></font>';
      } elseif (empty($in) && empty($out)){
          return '';
      }else{
          return $text;
      }

    } elseif($text=="Working Hour"){

      if($countdatalibur>0){
        return '<font color="red"><strong>'.$datalibur['Keterangan'].'</strong></font>';
      } elseif ($countdataliburbersama>0) {
        return '<font color="red"><strong>'.$dataliburbersama['Keperluan'].'</strong></font>';
      } elseif ($countdatacuti>0) {
        return '<font color="blue"><strong>'.$datacuti['keperluan'].'</strong></font>';
      } elseif ($countsakittanpasuratdokter>0) {
        return '<font color="blue"><strong>'.$datasakittanpasuratdokter['Alasan'].'</strong></font>';
      } elseif ($countsakitdengansuratdokter>0) {
        return '<font color="blue"><strong>'.$datasakitdengansuratdokter['Alasan'].'</strong></font>';
      } elseif (empty($in) && empty($out)){
          return '';
      }else{
          return $text;
      }

    } else {
      if (empty($in) && empty($out)){
          return '';
      }else{
          return $text;
      }
    }
    


}


?>
