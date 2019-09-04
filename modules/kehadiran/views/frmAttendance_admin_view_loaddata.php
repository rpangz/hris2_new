<?php 


$periode = $this->uri->segment(4);
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
$database_path = "\\\\ASTABS02\\Att\\att2000.mdb";

//check file exist before we proceed
if (!file_exists($database_path)) {
    die("Access database file not found !");

}

//create a new PDO object
$database = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$database_path; Uid=$db_username; Pwd=$db_password;");


$sql  = "SELECT DateValue([CHECKTIME]) AS Tanggal
FROM CHECKINOUT INNER JOIN USERINFO ON CHECKINOUT.USERID = USERINFO.USERID
WHERE (((USERINFO.Badgenumber)='$session_nik')) GROUP BY DateValue([CHECKTIME]) 
HAVING (((DateValue([CHECKTIME])) >=#$Periode1#) AND (DateValue([CHECKTIME])) <=#$Periode2#)
ORDER BY DateValue([CHECKTIME])";
$result = $database->query($sql);

if ($row = $result->fetch()){
echo 'Ronaldo Pangasian ( 5144 )';    
echo'<table id="tfhover" class="tftableon" width="100%" border="1" cellspacing="1" cellpadding="1">
        <tr>        
        <th colspan="12" width="3%"><div align=right>
            <div class="social">
            <ul>
              <li><a class="north" href="https://'.$_SERVER['SERVER_NAME'].'/hris2/includes/export/frmAtt/exp_frmAtt.php?NIK='.$session_nik.'&PRD='.$periode_id.'" target="_blank" title="Download Excel"><img src="https://'.$_SERVER['SERVER_NAME'].'/hris2/images/icn-excel.png" alt="Download Excel" width="25" class="img-responsive"/></a></li>              
            </ul>
        </div>
        </th>
        </tr>        
        <tr>        
        <th width="3%"><div align=center>No</th>
        <th width="10%"><div align=center>Day</th>
        <th width="10%">Date</th>
        <th width="10%"><div align=center>Working Hour</th>
        <th width="5%"><div align=center>Activity</th>               
        <th width="8%"><div align=center>Duty On</th>
        <th width="8%"><div align=center>Duty Off</th>
        <th width="8%"><div align=center>Late In</th>
        <th width="10%"><div align=center>Early Departure</th>
        <th width="8%"><div align=center>Over Time</th> 
        <th width="8%"><div align=center>Total Hour</th>
        <th width="12%"><div align=center>Notes</th>        
    </tr>';

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
        
        <td bgcolor='.color_td($week,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'><div align="center">'.$no.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'><div align="center">'.day_name($date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'</div></td>                   
        <td bgcolor='.color_td($week,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'><div align="center">'.format_tanggal($date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'><div align="center">'.status_empty_data($in=$check_in_txt, $out=$check_out_txt, $text='08:00 - 17:00',$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'><div align="center">'.status_empty_data($in=$check_in_txt, $out=$check_out_txt, $text='Work',$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'><div align="center">'.$check_in_txt.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'><div align="center">'.$check_out_txt.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'><div align="center">'.$late_txt.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'><div align="center">'.$early_txt.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'><div align="center">'.$over_txt.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'><div align="center">'.$total_work.'</div></td>
        <td bgcolor='.color_td($week,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'><div align="center">'.status_empty_data($in=$check_in_txt, $out=$check_out_txt, $text='Working Hour',$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter).'</div></td>
        
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
      ';
}
else{
 
  echo '<div class="alert alert-danger">
       <strong>FAILED:</strong> Data Not Found! Please Contact HRD<a class="close" data-dismiss="alert">×</a>
       </div>';

}