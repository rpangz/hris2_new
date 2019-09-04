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

if($state !='edit' AND $state !='add'){

echo"<table>
  <tr>
    <td><select class='form-control' id=select onchange=goToPage('select')>
    <option value='' disabled SELECTED>Select Periode</option>";
    $sql = mysql_query("SELECT * FROM tbl_periode WHERE bPeriodStatus=1 ORDER BY iPeriodId ASC");                     
    while ($data = mysql_fetch_array($sql)){

    if($this->uri->segment('4')==$data['iPeriodId']){  
      echo "<option value='http://$_SERVER[SERVER_NAME]/hris2/kehadiran/frmAttendance/index/$data[iPeriodId]' SELECTED>$data[cPeriodName]</option>";
    }
    else {
      echo "<option value='http://$_SERVER[SERVER_NAME]/hris2/kehadiran/frmAttendance/index/$data[iPeriodId]'>$data[cPeriodName]</option>";
    }

    }  
         
echo"</select>
    </table>&nbsp;&nbsp;";

}



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

$periode = $this->uri->segment(4);

if (isset($periode) || !is_null($periode)){
    $periode_id          = $this->uri->segment(4);
}
else{
    $periode_id          = 0;
} 

$sql_periode      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_Periode WHERE iPeriodId='$periode_id'"));

if ($periode_id != 0){
    $Periode1 = date('m/j/Y', strtotime($sql_periode['dPeriodStartDate']));
    $Periode2 = date('m/j/Y', strtotime($sql_periode['dPeriodEndDate']));
}
else{
    $Periode1 = '1/1/1970';
    $Periode2 = '1/1/7000';
}


$db_username = 'Admin'; //username
$db_password = ''; //password

//path to database file ASTABS02
$database_path = "\\\\ASTABS02\\Att\\att2000.mdb";

//check file exist before we proceed
if (!file_exists($database_path)) {
    die("Access database file not found !");

    //echo '<div class="alert alert-danger"><strong>Danger!</strong> Access database file not found !</div>';
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

echo'<table id="tfhover" class="tftableon" width="100%" border="1" cellspacing="1" cellpadding="1">
        <tr>        
        <th colspan="12" width="3%"><div align=right>
            <div class="social">
            <ul>
              <li><a class="north" href="http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/export/frmAtt/exp_frmAtt.php?NIK='.$session_nik.'&PRD='.$periode_id.'" target="_blank" title="Download Excel"><img src="http://'.$_SERVER['SERVER_NAME'].'/hris2/images/icn-excel.png" alt="Download Excel" width="25" class="img-responsive"/></a></li>
              
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



while ($row = $result->fetch()){

  $Tanggal  = date('d-M-Y', strtotime($row['Tanggal']));
  $day      = date('N', strtotime($row['Tanggal']));
  //$week     = date('W', strtotime($row['Tanggal']));
  $week     = $no;

$sql_in  = "SELECT TOP 1 DateValue([CHECKTIME]) AS Tanggal,CHECKTIME
FROM CHECKINOUT INNER JOIN USERINFO ON CHECKINOUT.USERID = USERINFO.USERID
WHERE (((USERINFO.Badgenumber)='$session_nik') AND CHECKTYPE='I' AND DateValue([CHECKTIME])=#$row[Tanggal]#) ORDER BY [CHECKTIME]";
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
WHERE (((USERINFO.Badgenumber)='$session_nik') AND CHECKTYPE='O' AND DateValue([CHECKTIME])=#$row[Tanggal]#) ORDER BY [CHECKTIME]";
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

    echo'<tr>
        
        <td bgcolor='.color_td($week).'><div align="center">'.$no.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.day_name($day).'</div></td>                   
        <td bgcolor='.color_td($week).'><div align="center">'.$Tanggal.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">08:00 - 17:00</div></td>
        <td bgcolor='.color_td($week).'><div align="center">Work</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.$check_in_txt.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.$check_out_txt.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.$late_txt.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.$early_txt.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.$over_txt.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.$total_work.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">Working Hour</div></td>
        
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
      </table>';


}
else{
 
  echo '<div class="alert alert-danger">
       <strong>FAILED:</strong> Data Not Found!<a class="close" data-dismiss="alert">×</a>
       </div>';

}


// List of function on this page

function day_name($N){

  if ($N==1){
    return 'Senin';
  }
  elseif ($N==2){
    return 'Selasa';
  }
  elseif ($N==3){
    return 'Rabu';
  }
  elseif ($N==4){
    return 'Kamis';
  }
  elseif ($N==5){
    return 'Jumat';
  }
  elseif ($N==6){
    return 'Sabtu';
  }
  elseif ($N==7){
    return 'Minggu';
  }
  else{
    return '';
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
background: url("http://appservices.unias.com/hris2/images/bg3.gif") repeat;
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