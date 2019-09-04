<?php
session_start();
error_reporting(0);
include "../../koneksi/koneksi.php";
$session_nik  = $_GET['NIK'];
$periode_id   = $_GET['PRD'];
$current_year = date("Y");

$tampil = mysql_query("SELECT * FROM tbl_profile WHERE NIK='$session_nik'");
$total  = mysql_num_rows($tampil);
$data   = mysql_fetch_array($tampil);

$TglMasuk = date('d-M-Y', strtotime($data['TglMasuk']));
$dept     = mysql_fetch_array(mysql_query("SELECT * FROM tbl_dept WHERE iDeptID='$data[DeptID]'"));
$jabatan  = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jabatan WHERE JabatanId='$data[JabatanID]'"));
$email    = $data['Email'];
$nama 	  = $data['Nama'];


$sql_periode      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_Periode WHERE iPeriodId='$periode_id'"));

if ($periode_id != 0){
    $Periode1 = date('m/j/Y', strtotime($sql_periode['dPeriodStartDate']));
    $Periode2 = date('m/j/Y', strtotime($sql_periode['dPeriodEndDate']));
}
else{
    $Periode1 = '1/1/'.$current_year;
    $Periode2 = '12/31/'.$current_year;
}


$db_username 	= 'Admin';
$db_password 	= '';
$database_path 	= "\\\\ASTABS02\\Att\\att2000.mdb";

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
$query_me = $database->query($profile);

if ($wisky = $query_me->fetch()){
    $USERID = $wisky['USERID'];   
}
else{
    $USERID = '';
}

require_once 'class.phpmailer.php';	

try {

$mail = new PHPMailer(true);

$body ='
	<html>
	<head>
	<title>REPORT EMPLOYEE ATTENDANCE '.$nama.'</title>
	</head>

	<style>

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
		background: url("https://apps.unias.com/hris2/images/bg3.gif") repeat;
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

	table.tabborder {
		border-width:1px; border-spacing:0px; border-style:solid;
		border-color:gray; border-collapse:separate; background-color:white;
	}
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

	td.thickBorder{border-right:0px;}
	}

	</style>

	<body>
	<table id="tfhover" class="tftableon" width="100%" border="1" cellspacing="0" cellpadding="0">
	  <tr>
	    <td height="42" colspan="12"><div align="left"><font size="+2"><strong>REPORT EMPLOYEE ATTENDANCE</strong></font></div></td>
	  </tr>
	  
	  <tr>
	    <td colspan="3"><strong>Fingerprint ID</strong></td>
	    <td colspan="3"><div align="left">'.$USERID.'</div></td>
	    <td colspan="2"><strong>Employee Title</strong></td>
	    <td colspan="4"><div align="left">'.$jabatan['NamaJabatan'].'</div></td>
	  </tr>
	  <tr>
	    <td colspan="3"><strong>Employee Code</strong></td>
	    <td colspan="3"><div align="left">'.$data['NIK'].'</td>
	    <td colspan="2"><strong>Employee Hire Date</strong></td>
	    <td colspan="4"><div align="left">'.$TglMasuk.'</div></td>
	  </tr>
	  <tr>
	    <td colspan="3"><strong>Employee Name</strong></td>
	    <td colspan="3">'.$data['Nama'].'</td>
	    <td colspan="2"><strong>Department Name</strong></td>
	    <td colspan="4">'.$dept['cDeptName'].'</td>
	  </tr>
	  <tr>
	    <td colspan="12" height="10">&nbsp;</td>	    
	  </tr>
	  <tr>
	    <th width="3%"><div align=center>No</div></th>
	    <th width="10%"><div align=center>Day</div></th>
	    <th width="10%">Date</th>
	    <th width="10%"><div align=center>Working Hour</div></th>
	    <th width="5%"><div align=center>Activity</div></th>               
	    <th width="8%"><div align=center>Duty On</div></th>
	    <th width="8%"><div align=center>Duty Off</div></th>
	    <th width="8%"><div align=center>Late In</div></th>
	    <th width="10%"><div align=center>Early Departure</div></th>
	    <th width="8%"><div align=center>Over Time</div></th> 
	    <th width="8%"><div align=center>Total Hour</div></th>
	    <th width="12%"><div align=center>Notes</div></th>   
	  </tr>';

$mail->Body   =$body;

$no=1;

$date = date("Y-m-d", strtotime($Periode1 . " -1 day"));
$final_date = date("Y-m-d", strtotime($Periode2));

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

    $detail[$no]='<tr>        
        <td bgcolor='.color_td($week).'><div align="center">'.$no.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.day_name($date).'</div></td>                   
        <td bgcolor='.color_td($week).'><div align="center">'.format_tanggal($date).'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.status_empty_data($in=$check_in_txt, $out=$check_out_txt, $text='08:00 - 17:00').'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.status_empty_data($in=$check_in_txt, $out=$check_out_txt, $text='Work').'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.$check_in_txt.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.$check_out_txt.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.$late_txt.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.$early_txt.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.$over_txt.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.$total_work.'</div></td>
        <td bgcolor='.color_td($week).'><div align="center">'.status_empty_data($in=$check_in_txt, $out=$check_out_txt, $text='Working Hour').'</div></td>        
        </tr>';

        $mail->Body .= $detail[$no];
$no++;



}


$footer='<tr>
        <th colspan="7"><div align="center"><strong>Total</strong></div></th>
        <th><div align="center"><strong>'.minutes_to_hours($total_late).'</strong></div></th>
        <th><div align="center"><strong>'.minutes_to_hours($total_early).'</strong></div></th>
        <th><div align="center"><strong>'.minutes_to_hours($total_over).'</strong></div></th>
        <th><div align="center"><strong>'.minutes_to_hours($total_all).'</strong></div></th>
        <th><div align="center"><strong></strong></div></th>
      </tr>
      </table>
      </body>
</html>';

$mail->Body .=$footer;

	
	$footer2 ='<p><font color="#FF0000" size="-1">Perhatian email ini dikirim secara otomatis dari HRIS. Jangan membalas ke alamat ini</font></p>';
	$mail->Body .=$footer2;

	$mail->IsSMTP();
    $mail->Mailer       = "smtp";
    $mail->Host         = "Exc2013-DAG";
    $mail->Port         = 25;
    $mail->SMTPKeepAlive= true;
    $mail->SMTPAuth     = true;
    $mail->From         = "system.noreply@unias.com";
    $mail->FromName     = "Human Resource Information System";
    $mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');    
    //$to = "dompak.sinambela@unias.com";
	$to = "$email";
    $mail->AddAddress($to);
    $mail->Subject       = "REPORT EMPLOYEE ATTENDANCE [$nama]";
    $mail->AltBody       = "To view the message, please use an HTML compatible email viewer!";  
    $mail->WordWrap      = 80;  
    $mail->IsHTML(true);    
    $mail->Send();
    $statusku = 'Email Berhasil Dikirim ke ['.$email.']';

	
}	

		catch (phpmailerException $e){
			echo $e->errorMessage();
			$statusku = 'Error!!! Email Tidak Berhasil Dikirim ke ['.$email.']';
		}


}

echo "<script type='text/javascript'>alert('$statusku...Click OK to close window');window.open('', '_self', '');window.close();</script>";


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


function status_empty_data($in,$out,$text){

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

?>