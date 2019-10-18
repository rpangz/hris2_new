<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER[SERVER_NAME]; ?>/hris/assets/progressbar/loading-bar.css"/>
<script type="text/javascript" src="<?php echo $_SERVER[SERVER_NAME]; ?>/hris/assets/progressbar/loading-bar.js"></script>


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

if($karyawan<>"ALL") {
    $connscript = " AND nik = ".$karyawan;
}

?> 


<?php if($this->uri->segment(3)!="index") { ?>
<!-- untuk table filter data ==================================================================== -->    
<table>

<tr style="height: 35px;">
    <td><font style="font-size: 11px; font-weight: bold;">Jenis</font></td>
    <td>&nbsp;:&nbsp;&nbsp;</td>
    <td>
        <select class='form-control' style="font-size: 11px; width: 50%; height:30px;" id="jenislaporan" name="jenislaporan">
        <option value='detail'>DETAIL</option>
        <option value='rekap'>REKAP</option>
        </select>   
    </td>
</tr>    
<tr style="height: 35px;">
    <td><font style="font-size: 11px; font-weight: bold;">Periode</font></td>
    <td>&nbsp;:&nbsp;&nbsp;</td>
    <td>
        <select class='form-control' style="font-size: 11px; width: 40%; height:30px;" id="periode" name="periode">
        <option value='0' disabled SELECTED>Select Periode</option>
        <?php 
        $sql = mysql_query("SELECT * FROM tbl_periode WHERE iPeriodId >0 AND bPeriodStatus=1 ORDER BY iPeriodId ASC");                     
        while ($data = mysql_fetch_array($sql)){
          echo "<option value='$data[iPeriodId]'>$data[cPeriodName]</option>";                
        }  
        ?>
        </select>   
    </td>
</tr>
<tr style="height: 35px;">
    <td><font style="font-size: 11px; font-weight: bold;">Department</font></td>
    <td>&nbsp;:&nbsp;&nbsp;</td>
    <td>
        <select class='form-control' style="font-size: 11px; height:30px;" id="department" name="department" onchange="loadkaryawan(this.value)">
        <option value='0' disabled SELECTED>Select Department</option>
        <?php 
        $mysqlcomm = "";
        $mysqlcomm = "SELECT iDeptID,cDeptName,cCompanyCode FROM tbl_dept a
                      INNER JOIN tbl_company b ON a.companyID=b.icompanyID
                      ORDER BY companyID, cDeptName";
        $sql = mysql_query($mysqlcomm);                     
        while ($data = mysql_fetch_array($sql)){
          echo "<option value='$data[iDeptID]'>$data[cDeptName] ($data[cCompanyCode]) </option>";
        }  
        ?>
        </select>   
    </td>
</tr>

<tr style="height: 35px;">
    <td><font style="font-size: 11px; font-weight: bold;">Karyawan</font></td>
    <td>&nbsp;:&nbsp;&nbsp;</td>
    <td>
        <select class='form-control' style="font-size: 11px; height:30px;" id="karyawan" name="karyawan">
        <option value='0' disabled SELECTED>Select Karyawan</option>        
        </select>   
    </td>
    <td>
        &nbsp;&nbsp;<input type="button" name="test" value="Load Data" onclick="loaddata(periode.value,department.value,karyawan.value,jenislaporan.value)" style="width:120px;">    
    </td>
</tr>



</table>
<!-- untuk table filter data ==================================================================== -->  
<?php } ?>








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

function loaddata(periode,department,nik,jenislaporan) {

    var server = "<?php echo $_SERVER[SERVER_NAME]; ?>";
    if(jenislaporan=="detail"){
        var url_link =  "https://"+server+"/hris2/kehadiran/frmAttendance_admin/index/"+periode+"/"+department+"/"+nik;    
    } else {
        var url_link =  "https://"+server+"/hris2/kehadiran/frmAttendance_admin/LoadDAtaRekap/"+periode+"/"+department+"/"+nik;    
    }
    
    $('#loaddatapreview').html('');
    $.ajax({
        url : url_link,
        type: "GET",
        beforeSend: function()
        {
              document.getElementById('imgdatepreview').style.display = "";                    
        },
        success: function(html)
        {   
            document.getElementById('imgdatepreview').style.display = "none";         
            $('#loaddatapreview').html(html);            
        },

        error: function (jqXHR, textStatus, errorThrown)
        {            
            alert('Error get data from ajax');
        }
    });
}



function loadkaryawan(dept){

    $.ajax({
        url : "<?php echo site_url('kehadiran/frmAttendance_admin/GetKaryawan')?>/?dept="+dept,
        type:'POST',
        dataType: 'json',
        success: function(response) {
            $('#karyawan').empty();
            $("#karyawan").append('<option value=ALL> -- ALL -- </option>');
            $.each(response,function(key, value)
            {                       
                $("#karyawan").append('<option value=' + value.nik + '>' + value.nama + '</option>');
            });
            $('.selectpicker').selectpicker('refresh');
         }
    });

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


if($this->uri->segment(3)=="index") {
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


//Pengecekan Dept
$mysqlcomm = "SELECT nik,nama,deptid,nik_absensi FROM tbl_profile WHERE deptid = ".$department." AND bstatus = 1 ".$connscript;
$query  = mysql_query($mysqlcomm);
$total  = mysql_num_rows($query);

while ($data = mysql_fetch_array($query)){ //awal load karyawan

            $session_nik = $data['nik_absensi'];
            $namakary = $data['nama'];

            //pengecekan jumlah cuti
            $datacutiarr = "";
            $datacutiarr = check_cuti_arr($sql_periode['dPeriodStartDate'],$sql_periode['dPeriodEndDate'],$session_nik);

            $dataliburarr = "";
            $dataliburarr = check_libur_nasional_arr($sql_periode['dPeriodStartDate'],$sql_periode['dPeriodEndDate'],$session_nik);

            $datasakitarr = "";
            $datasakitarr = check_sakit_arr($sql_periode['dPeriodStartDate'],$sql_periode['dPeriodEndDate'],$session_nik);



//create a new PDO object
$database = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$database_path; Uid=$db_username; Pwd=$db_password;");
$sql  = "SELECT DateValue([CHECKTIME]) AS Tanggal
FROM CHECKINOUT INNER JOIN USERINFO ON CHECKINOUT.USERID = USERINFO.USERID
WHERE (((USERINFO.Badgenumber)='$session_nik')) GROUP BY DateValue([CHECKTIME]) 
HAVING (((DateValue([CHECKTIME])) >=#$Periode1#) AND (DateValue([CHECKTIME])) <=#$Periode2#)
ORDER BY DateValue([CHECKTIME])";


$result = $database->query($sql);

if ($row = $result->fetch()){



echo '<center>'.$namakary.' ( '.$session_nik.' ) </center>';    
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


    $datacuti = "";
    $datacuti = check_cuti($date,$datacutiarr);
    $countdatacuti = sizeof($datacuti); //untuk mengecek data di dalam array
    if($countdatacuti>0){
      $total_cuti = $total_cuti + 1;
    }

    $dataliburbersama = "";
    $dataliburbersama = check_libur_bersama($date,$dataliburarr);

    $countdataliburbersama = sizeof($dataliburbersama); //untuk mengecek data di dalam array
    if($countdataliburbersama>0){
      $total_libur_bersama = $total_libur_bersama + 1;
    }

    //pengecekan jumlah libur nasional
    $datalibur = "";
    $datalibur = check_libur_nasional($date,$dataliburarr);
    $countdatalibur = sizeof($datalibur); //untuk mengecek data di dalam array
    if($countdatalibur>0){
      $total_libur_nasional = $total_libur_nasional + 1;
    }


    $datasakittanpasuratdokter = "";
    $datasakittanpasuratdokter = check_sakit_tanpa_surat_dokter($date,$datasakitarr);
    $countsakittanpasuratdokter = sizeof($datasakittanpasuratdokter); //untuk mengecek data di dalam array
    if($countsakittanpasuratdokter>0){
      $total_sakit_tanpa_surat_dokter = $total_sakit_tanpa_surat_dokter + 1;
    }

    $datasakitdengansuratdokter = "";
    $datasakitdengansuratdokter = check_sakit_dengan_surat_dokter($date,$datasakitarr);
    $countsakitdengansuratdokter = sizeof($datasakitdengansuratdokter); //untuk mengecek data di dalam array
    if($countsakitdengansuratdokter>0){
      $total_sakit_dengan_surat_dokter = $total_sakit_dengan_surat_dokter + 1;
    }

    /*

    //pengecekan sakit tanpa surat dokter
    $datasakittanpasuratdokter = "";
    $datasakittanpasuratdokter = check_sakit_tanpa_surat_dokter($date,$session_nik);
    $countsakittanpasuratdokter = sizeof($datasakittanpasuratdokter); //untuk mengecek data di dalam array
    if($countsakittanpasuratdokter>0){
      $total_sakit_tanpa_surat_dokter = $total_sakit_tanpa_surat_dokter + 1;
    }

    //pengecekan sakit tanpa surat dokter
    $datasakitdengansuratdokter = "";
    $datasakitdengansuratdokter = check_sakit_dengan_surat_dokter($date,$session_nik);
    $countsakitdengansuratdokter = sizeof($datasakitdengansuratdokter); //untuk mengecek data di dalam array
    if($countsakitdengansuratdokter>0){
      $total_sakit_dengan_surat_dokter = $total_sakit_dengan_surat_dokter + 1;
    }

    */



    

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
      <table>
        <tr>
            <td style="border-top:1px dotted;width:1100px;">
            </td>
        </tr>
      </table>
      <br>
      ';

      $total_late = 0;$total_early=0;$total_over=0;$total_all;
}
else{
 
    
  echo '<div class="alert alert-danger">
       <strong>FAILED:</strong> Data '.$namakary.' ( '.$session_nik.' ) Not Found! Please Contact HRD<a class="close" data-dismiss="alert">×</a>
       </div>';
  


}


} // akhir load karyawan

// ========================================================== END LOAD DATA ==============================================================
} // akhir dari if uri segemen(3) = index



echo '<div id="loaddatapreview" style="border-top: 1px solid;padding-top:20px;">
           
      </div>'; //untuk load data ajax 


echo '<div id="imgdatepreview" style="height: 400px; width: 1000px; padding-top:50px; display:none">
      <center><img src="https://'.$_SERVER[SERVER_NAME].'/hris2/images/loader2.gif" id="loaderimg"></center>
      <center> <font style="font-size:20px; font-weight: bold"> Loading Data . . .</font></center>
      </div>'; //untuk load data ajax 


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

/*
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
*/


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

function status_empty_data($in,$out,$text,$date,$session_nik,$datacuti,$dataliburbersama,$datalibur,$datasakittanpasuratdokter,$datasakitdengansuratdokter){


    $countdatacuti = sizeof($datacuti); //untuk mengecek data di dalam arra
    $countdatalibur = sizeof($datalibur); //untuk mengecek data di dalam arra
    $countdataliburbersama = sizeof($dataliburbersama); //untuk mengecek data di dalam arra
    $countsakittanpasuratdokter = sizeof($datasakittanpasuratdokter); //untuk mengecek data di dalam array
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
        return '<font color="red"><strong>'.$datalibur['keterangan'].'</strong></font>';
      } elseif ($countdataliburbersama>0) {
        return '<font color="red"><strong>'.$dataliburbersama['keterangan'].'</strong></font>';
      } elseif ($countdatacuti>0) {
        return '<font color="blue"><strong>'.$datacuti['keperluan'].'</strong></font>';
      } elseif ($countsakittanpasuratdokter>0) {
        return '<font color="blue"><strong>'.$datasakittanpasuratdokter['alasan'].'</strong></font>';
      } elseif ($countsakitdengansuratdokter>0) {
        return '<font color="blue"><strong>'.$datasakitdengansuratdokter['alasan'].'</strong></font>';
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


function check_cuti_arr($date1,$date2,$session_nik){

  $tgl    = date('Y-m-d', strtotime($date));
  $mysqlcomm = "SELECT a.cutiid,keperluan,tglcuti,tglmasuk FROM tbl_formcuti a, tbl_formcutidetail b 
                WHERE a.cutiid=b.cutiid AND formcutinik = ".$session_nik." AND statusForm = 'A' AND (tglcuti BETWEEN '".$date1."' AND '".$date2."') AND JenisCuti NOT IN (4) ";


  $query  = mysql_query($mysqlcomm);
  $total  = mysql_num_rows($query);

  $datacutiarr = array();
  while ($data = mysql_fetch_array($query)){

    $datacutiarr[] = array('keperluan' => $data['keperluan'],
                           'tglcuti' => $data['tglcuti']     
                      );
    

  }

  return $datacutiarr;

}

function check_cuti($date,$datacutiarr){

  $datacuti = array();  
  $countarraydatacuti = sizeof($datacutiarr); //untuk mengecek data di dalam array  
  for($i=0;$i<=$countarraydatacuti-1;$i++){ 
      if ($date==$datacutiarr[$i][tglcuti]) {        
          $datacuti = $datacutiarr[$i];
      } 
  } 

  return $datacuti;

}

function check_libur_nasional_arr($date1,$date2,$session_nik){

  $tgl    = date('Y-m-d', strtotime($date));
  $mysqlcomm = "SELECT keterangan,DATE_FORMAT(tanggal,'%Y-%m-%d') tanggal,'LIBUR NASIONAL' jenis FROM tbl_holiday WHERE tanggal BETWEEN '".$date1."' AND '".$date2."' 
                UNION ALL
                SELECT a.keperluan,DATE_FORMAT(b.tglcuti,'%Y-%m-%d'),'CUTI BERSAMA' jenis FROM tbl_formcutimasal a, tbl_formcutimasaldetail b 
                WHERE a.cutiid=b.cutiid AND tglcuti BETWEEN '".$date1."' AND '".$date2."'";


  $query  = mysql_query($mysqlcomm);
  $total  = mysql_num_rows($query);

  $dataliburarr = array();
  while ($data = mysql_fetch_array($query)){

    $dataliburarr[] = array('keterangan' => $data['keterangan'],
                            'tanggal' => $data['tanggal'],
                            'jenis' => $data['jenis']   
                      );
    
  }
  return $dataliburarr;
}

function check_libur_nasional($date,$dataliburarr){

  $dataliburnasional = array();  
  $countarraydatalibur = sizeof($dataliburarr); //untuk mengecek data di dalam array  

  for($i=0;$i<=$countarraydatalibur-1;$i++){ 

      if ($date==$dataliburarr[$i][tanggal] && $dataliburarr[$i][jenis]=="LIBUR NASIONAL") {        
          $dataliburnasional = $dataliburarr[$i];
          
      } 
  } 

  return $dataliburnasional;


}


function check_libur_bersama($date,$dataliburarr){
  
  $dataliburbersama = array();  
  $countarraydatalibur = sizeof($dataliburarr); //untuk mengecek data di dalam array  

  for($i=0;$i<=$countarraydatalibur-1;$i++){ 

      if ($date==$dataliburarr[$i][tanggal] && $dataliburarr[$i][jenis]=="CUTI BERSAMA") {        
          $dataliburbersama = $dataliburarr[$i];
          
      } 
  } 
  return $dataliburbersama;

}


function check_sakit_arr($date1,$date2,$session_nik){

  $tgl    = date('Y-m-d', strtotime($date));
  $mysqlcomm = "SELECT DATE_FORMAT(tglactive1,'%Y-%m-%d') tglactive1,DATE_FORMAT(tglactive2,'%Y-%m-%d') tglactive2,jenisijin,alasan FROM tbl_formijin 
                WHERE (tglactive1>='".$date1."' OR tglactive2<='".$date2."') AND nik = ".$session_nik." AND statusform = 'A'";


  $query  = mysql_query($mysqlcomm);
  $total  = mysql_num_rows($query);

  $datasakitarr = array();
  while ($data = mysql_fetch_array($query)){

    $datasakitarr[] = array('tglactive1' => $data['tglactive1'],
                            'tglactive2' => $data['tglactive2'],
                            'jenisijin' => $data['jenisijin'],
                            'alasan' => $data['alasan']
                      );
    
  }
  return $datasakitarr;
}


function check_sakit_tanpa_surat_dokter($date,$datasakitarr){

  $datasakittanpasuratdokter = array();  
  $countarraydatasakit = sizeof($datasakitarr); //untuk mengecek data di dalam array  

  for($i=0;$i<=$countarraydatasakit-1;$i++){ 
      if ($date==$datasakitarr[$i][tglactive1] && $datasakitarr[$i][jenisijin]=="3") {        
          $datasakittanpasuratdokter = $datasakitarr[$i];          
      } 
  } 
  return $datasakittanpasuratdokter;

}



function check_sakit_dengan_surat_dokter($date,$datasakitarr){

  $datasakitdengansuratdokter = array();  
  $countarraydatasakit = sizeof($datasakitarr); //untuk mengecek data di dalam array  

  for($i=0;$i<=$countarraydatasakit-1;$i++){ 
      if ($date>=$datasakitarr[$i][tglactive1] && $date<=$datasakitarr[$i][tglactive2] && $datasakitarr[$i][jenisijin]=="9") {        
          $datasakitdengansuratdokter = $datasakitarr[$i];          
      } 
  } 
  return $datasakitdengansuratdokter;

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