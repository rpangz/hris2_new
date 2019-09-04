<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report Cuti</title>

<!--
<style type=text/css>
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
			font-size: 12px;} /* or other border styles */
			
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

</style>
</head>

<body>
-->

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

</style>

<?php
include "../../includes/koneksi/koneksi.php";

$company_id = $_GET['company'];



	if (!is_null($_GET['pt']) && !is_null($_GET['div']) && !is_null($_GET['dept']) && !is_null($_GET['from']) && !is_null($_GET['to'])){
		
		$From    = $_GET['from'];
		$dd      = substr($From,0,2);
		$mm      = substr($From,3,2);
		$yyyy    = substr($From,6,4);


		$To      = $_GET['to'];
		$dd_2    = substr($To,0,2);
		$mm_2    = substr($To,3,2);
		$yyyy_2  = substr($To,6,4);

		
		if ($mm =='01'){
			$nM = 'Januari';		
		}
		elseif($mm=='02'){
			$nM = 'Februari';
		}
		
		elseif($mm=='03'){
			$nM = 'Maret';
		}
		
		elseif($mm=='04'){
			$nM = 'April';
		}
		
		elseif($mm=='05'){
			$nM = 'Mei';
		}
		
		elseif($mm=='06'){
			$nM = 'Juni';
		}
		
		elseif($mm=='07'){
			$nM = 'Juli';
		}
		
		elseif($mm=='08'){
			$nM = 'Agustus';
		}
		
		elseif($mm=='09'){
			$nM = 'September';
		}
		
		elseif($mm=='10'){
			$nM = 'Oktober';
		}
		
		elseif($mm=='11'){
			$nM = 'Nopember';
		}
		
		elseif($mm=='12'){
			$nM = 'Desember';
		}
		
		else{
			$nM = 'No Month';
		}
	}
	else {
		$month = '';
	}


	//echo $dd.'*'.$mm.'*'.$yyyy.'<br/>';

	//echo $dd_2.'*'.$mm_2.'*'.$yyyy_2;
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


	$today = date ("d-M-Y");

	$find1  = $yyyy.'-'.$mm.'-'.$dd.'<br/>';
	$find2  = $yyyy_2.'-'.$mm_2.'-'.$dd_2.'<br/>';


	$db_SQL = "SELECT *,tbl_formcuti.TglMasuk AS TglMasukKembali  FROM `tbl_formcuti` INNER JOIN 
         tbl_formcutidetail ON tbl_formcuti.CutiId = tbl_formcutidetail.CutiId INNER JOIN 
         tbl_profile ON tbl_formcuti.FormCutiNIK = tbl_profile.NIK		
		WHERE TglCuti >='$find1' AND TglCuti <='$find2' 
		AND tbl_profile.CompanyId ='$company_id' AND DivisiID$div AND DeptID$dept 
		AND StatusForm='A'
		GROUP BY tbl_formcuti.CutiId";


	$db_conn = mysql_query($db_SQL);
	$total	 = mysql_num_rows($db_conn);

 if ($total > 0){

 	$link2excel = 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/report/gen_rptCutiPerPeriode.php?company='.$company_id.'&pt='.$_GET['pt'].'&div='.$_GET['div'].'&dept='.$_GET['dept'].'&jc='.$_GET['jc'].'&from='.$_GET['from'].'&to='.$_GET['to'];

	
	
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
    <th height="47" colspan="8" scope="col"><div align="center" class="style2"><strong><?php echo modal_status_name(url_segment_4th()) ?></strong></div></th>
  </tr>


<?php

$no = 1;


?>  
 
  
  <tr>
  	<th width="3%" height="25" bgcolor="#999999"><div align="center"><strong>No</strong></div></th>
    <th width="3%" height="25" bgcolor="#999999"><div align="center"><strong>NIK</strong></div></th>
    <th width="15%" bgcolor="#999999"><div align="center"><strong>Nama</strong></div></th>
    <th width="30%" bgcolor="#999999"><div align="center"><strong>Subject</strong></div></th>
    <th width="5%" bgcolor="#999999"><div align="center"><strong>Jml Cuti</strong></div></th>
    <th width="10%" bgcolor="#999999"><div align="center"><strong>Jenis Cuti</strong></div></th>
    <th width="20%" bgcolor="#999999"><div align="center"><strong>Tgl Cuti</strong></div></th>
    <th width="5%" bgcolor="#999999"><div align="center"><strong>Tgl Masuk</strong></div></th>    
  </tr>
 
  
 <?php
 
 	
				
while($data = mysql_fetch_array($db_conn)){

	$detail_a = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId = $data[CutiId]");
	$JmlCuti  = mysql_num_rows($detail_a);

	$jes = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id = $data[JenisCuti]"));


	$TglMasuk = date('d-M-Y', strtotime($data['TglMasukKembali']));
 ?>
  
  <tr>
  	<td height="20" bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo $no ?></div></td>
    <td height="20" bgcolor="<?php echo color_td($no)?>"><?php echo $data['NIK'] ?></td>
    <td height="20" bgcolor="<?php echo color_td($no)?>"><?php echo $data['Nama'] ?></td>
    <td bgcolor="<?php echo color_td($no)?>"><div align="left"><?php echo $data['Keperluan'] ?></div></td>
    <td bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo $JmlCuti. ' Hari' ?></div></td>
    <td bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo $jes['JenisCutiName'] ?></div></td>
    <td bgcolor="<?php echo color_td($no)?>"><div align="left">

    	<?php 
while($dw = mysql_fetch_array($detail_a)){
	$TglCuti = date('d-M-Y', strtotime($dw['TglCuti']));
    	echo $TglCuti.', '; 
    }
?>
    </div></td>
    <td bgcolor="<?php echo color_td($no)?>"><div align="right"><?php echo $TglMasuk ?></div></td>
    
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

function url_segment_4th(){

	$url = $_SERVER['REQUEST_URI'];
	$parsed = parse_url($url);
	$path = $parsed['path'];
	$path_parts = explode('/', $path);
	return $desired_output = $path_parts[4];

}

?>
</body>
</html>
