<link href="../../themes/{{ used_theme }}/assets/default/bootstrap.min.css" rel="stylesheet">
<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!--<style type=text/css>
#body {
	font-size:36px;
}

.noPrint {
    display: none;
}

#tfhover{
    border-collapse:collapse;
}
#tfhover tr {
    background-color:transparent;
}
#tfhover tr:hover td  {
  background-color:#FFFF33;
}
#tfhover tr td.link{
    background-color:transparent;
}

/* Bagian untuk tabel */	
table.tftable {
font-size:12px;
	color:#333333;
	border-width: 1px;
	border-color:#000000;
	border-collapse: collapse;

}

table.tftable th {
	font-size:12px;
	background-color:#CCCCCC;
	border-width: 1px;
	padding: 3px;
	border-style: solid;
	border-color: #999999;
	text-align:center;

}
table.tftable tr {
	background-color:#FFFFFF;
}
table.tftable td {
	font-size:12px;
	border-width: 1px;
	padding: 2px;
	border-style: solid;
	border-color: #999999;
	background-color:#FFFFFF;


}


.bigcell {
    position: relative;
    width: 100px;
    height: 50px;
    border: thin dotted gray;
}

td.thickBorder{ 
	border-bottom: solid gray 1px;
}
td.thickBorderRight{ 
	border-right: solid gray 1px;
	border-bottom: solid gray 1px;
}

.strikeout {
	position: absolute;
	height: 0px;
	width: 179px;
	background-color: black;
	top: 146px;
	visibility: inherit;
}
.table1 { border:1px black solid; 
			font-size: 12px;
		} /* or other border styles */
			
.table2 {font-size: 14px;} /* or other border styles */
			
			
table {font-size: 16px;}

.style2 {
	font-size: 16px;
	font-weight: bold;
	color:#0000FF;
}


.style3 {
	font-size: 20px;
	font-weight: bold;
	color:#FF0000;
}

.style4 {
	font-size: 12px;
	font-weight: bold;
	color:#0000FF;
	float:left;
}

.style5 {
	font-size: 12px;
	font-weight: bold;
	color:#0000FF;
	float:right;
}

.style6 {
	font-size: 12px;
	font-weight: bold;
	color:#FF0000;
	float:right;
}

</style>-->

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
td.noBorder{
  border-style: solid;
  border-color:#999999;
}

</style>

<?php
include "../../includes/koneksi/koneksi.php";
$company_id = $_GET['company'];	
		


	if ($_GET['div'] == 0 OR empty($_GET['div'])){
		$div = '>0';
	}
	else{
		$div = '='.$_GET['div'];
	}


	if ($_GET['dept'] == 0){
		$dept = '>0';
	}
	else{
		$dept = '='.$_GET['dept'];
	}

  if ($_GET['jc'] == 0){
    $jenis_ijin = '>0';
  }
  else{
    $jenis_ijin = '='.$_GET['jc'];
  }


	$today  = date ("Y-m-d");	
	$tampil = mysql_query("SELECT * FROM tbl_formijin INNER JOIN tbl_profile ON tbl_formijin.NIK=tbl_profile.NIK 
                         WHERE tbl_formijin.NIK !=0 AND tbl_profile.CompanyId ='$company_id' AND DivisiID$div AND DeptID$dept 
                         AND JenisIjin$jenis_ijin AND StatusForm='A'");


  $total   = mysql_num_rows($tampil);

  if ($total > 0){

    $link2excel = 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/report/gen_rptFormIjin.php?company='.$company_id.'&pt='.$_GET['pt'].'&div='.$_GET['div'].'&dept='.$_GET['dept'].'&jenis_ijin='.$_GET['jenis_ijin'];
  
 

 ?>
  
  <div align=right>
        <div class="social">
          <ul>
              <li><a class="north" href="<?php echo $link2excel ?>" target="_blank" title="Download Excel"><img src="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/hris2/images/icn-excel.png'?>" alt="Download Excel" width="25" class="img-responsive"/></a></li>
          </ul>
        </div>
  </div>
  <table id="tfhover" class="tftableon" width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th height="47" colspan="8" scope="col"><div align="center" class="style2"><strong><?php echo modal_status_name(url_segment_4th()) ?> - <?php echo jenis_form_name($_GET['jc']).'  ['.company_name($company_id); ?>]</strong></div></th>
  </tr>
  <tr>
  	<th width="2%" height="25" bgcolor="#999999"><div align="center"><strong>No</strong></div></th>
    <th width="3%" height="25" bgcolor="#999999"><div align="center"><strong>NIK</strong></div></th>
    <th width="15%" bgcolor="#999999"><div align="center"><strong>Nama</strong></div></th>
    <th width="15%" bgcolor="#999999"><div align="center"><strong>Jenis Ijin</strong></div></th>
    <th width="12%" bgcolor="#999999"><div align="center"><strong>Tanggal/Pukul</strong></div></th>
    <th width="20%" bgcolor="#999999"><div align="center"><strong>Alasan</strong></div></th>
    <th width="15%" bgcolor="#999999"><div align="center"><strong>Divisi</strong></div></th>
    <th width="15%" bgcolor="#999999"><div align="center"><strong>Department</strong></div></th>
   
  </tr>
<?php
$no = 1;
  	
while ($data = mysql_fetch_array($tampil)){


?>
    <tr>
  	<td height="20" bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo $no ?></div></td>
    <td height="20" bgcolor="<?php echo color_td($no)?>"><?php echo $data['NIK'] ?></td>
    <td height="20" bgcolor="<?php echo color_td($no)?>"><?php echo $data['Nama'] ?></td>
    <td height="20" bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo jenis_form_name($data['JenisIjin']); ?></div></td>
    <td bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo format_tanggal_date_time($data['TglActive1']); ?><div></td>
    <td bgcolor="<?php echo color_td($no)?>"><div align="left"><?php echo $data['Alasan'] ?></div></td>
    <td bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo division_name($value=$data['DivisiID']); ?><div></td>
    <td bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo department_name($value=$data['DeptID']); ?></div></td>
    
  </tr>

<?php
$no++;
}



  


?>
</table>

<?php

}
else{

    echo 'No Data Found...';
    $link2excel = '#';

}


function color_td($value){
    if ($value %2==0){
        return '#F7F7F7';
    }
    else{
        return '';
    }

}

function modal_status_name($value){

    $query  = mysql_query('SELECT * FROM tbl_reports WHERE ReportModules="'.$value.'"');
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['ReportName'];
    }
    else {
        return '';
    }
    

}

function company_name($value){

    $query  = mysql_query('SELECT * FROM tbl_company WHERE iCompanyId="'.$value.'"');
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['cCompanyName'];
    }
    else {
        return '';
    }
    

}

function division_name($value){

    $query  = mysql_query('SELECT * FROM tbl_div WHERE iDivId="'.$value.'"');
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['cDivName'];
    }
    else {
        return '';
    }
    

}

function department_name($value){

    $query  = mysql_query('SELECT * FROM tbl_dept WHERE iDeptID="'.$value.'"');
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['cDeptName'];
    }
    else {
        return '';
    }
    

}





function jenis_form_name($value){

    $query  = mysql_query('SELECT * FROM tbl_jenisijin WHERE JenisIjinId="'.$value.'"');
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['JenisIjinName'];
    }
    else {
        return '-';
    }
    

}


function format_tanggal_date_time($value){

   return date('d-M-Y H:i', strtotime($value));
    

}


function url_segment_4th(){

  $url = $_SERVER['REQUEST_URI'];
  $parsed = parse_url($url);
  $path = $parsed['path'];
  $path_parts = explode('/', $path);
  return $desired_output = $path_parts[4];

}


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
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();

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