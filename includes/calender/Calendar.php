<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<script type = "text/javascript">
function goToPage( id ) {
  var node = document.getElementById( id );  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://<?php echo $_SERVER['SERVER_NAME']?>/hris2/includes/calender/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="icon.png" />
<link href="../themes/cerulean/assets/default/bootstrap.min.css" rel="stylesheet">
	<style>

.right { text-align: right;}
.center { text-align: center;}
</style>


<style>

  
.dropdown_box1{
    width:150px;
    height:30px;
    margin-top:5px;
    margin-bottom:5px;
    margin-left:0px;
    font-size: 12px;
    font-family: arial;
  }

 .dropdown_box2{
    width:100px;
    height:30px;
    margin-top:5px;
    margin-bottom:5px;
    margin-left:5px;
    font-size: 12px;
    font-family: arial;
  }



a.tooltips {
  position: relative;
  display: inline;
}
a.tooltips span {
  position: absolute;
  width:250px;
  color: #FFFFFF;
  background: #000000;
  height: 140px;
  line-height: 15px;
  text-align: left;
  visibility: hidden;
  border-radius: 6px;
}
a.tooltips span:after {
  content: '';
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -8px;
  width: 0; height: 0;
  border-top: 8px solid #000000;
  border-right: 8px solid transparent;
  border-left: 8px solid transparent;
}
a:hover.tooltips span {
  visibility: visible;
  opacity: 0.8;
  bottom: 30px;
  left: 50%;
  margin-left: -76px;
  z-index: 999;
}



A:active { COLOR: blue; TEXT-DECORATION: none }
A:hover { COLOR: #FF0000; TEXT-DECORATION: underline; font-weight: none }
.right { text-align: right;}
.center { text-align: center;}

</style>


</head>
<body>
<?php


$today = date ("m/d/Y");
$time  = strtotime($today);

$y     = date('Y', $time);
$m     = date('m', $time);

//header("Location: ?month=$m&year=$y");

$yy    = '$y';
$mm    = '$m';
//$yy    = $y;

//This is your Db connect file.  You need this for access	
require('htdocs/db_connect.php');
//Here are the months
$monthNames = Array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", 
"Agustus", "September", "Oktober", "Nopember", "Desember");
?>
<?php
if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");
?>
<?php
$cMonth     = $_REQUEST["month"];
$cYear      = $_REQUEST["year"];
$prev_year  = $cYear;
$next_year  = $cYear;
$prev_month = $cMonth-1;
$next_month = $cMonth+1;
if ($prev_month == 0 ) {
	$prev_month = 12;
	$prev_year = $cYear - 1;
}
if ($next_month == 13 ) {
	$next_month = 1;
	$next_year = $cYear + 1;
}
$link_date="month=". $cMonth . "&year=" . $cYear."&";
?>
<div id="calendarDiv">
<table width="100%" height="200px">
<tr align="center">
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>

<td width="50%" align="left"><a class="Previous" href="<?php echo "?month=". $prev_month . "&year=" . $prev_year; ?>" style=""><img src='http://<?php echo $_SERVER['SERVER_NAME']?>/hris2/includes/calender/images/previous.png'> Previous</a></td>
<td width="50%" align="right"><a class="Next" href="<?php echo "?month=". $next_month . "&year=" . $next_year; ?>" style="">Next <img src='http://<?php echo $_SERVER['SERVER_NAME']?>/hris2/includes/calender/images/next.png'></a>  </td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center">
<table width="100%" border="0" cellpadding="2" cellspacing="2">
<tr align="center">
	<td colspan="7"><h2 class="monthLabel"><center><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></center></h2></td>
</tr>
<tr>

<?php
echo "<form method=POST action='?'>
		<td><select class='form-control' name='BulanId'>";	
    $sql = mysql_query("SELECT * FROM tbl_month");					  
		  while ($data = mysql_fetch_array($sql)){
	if ($data['BulanId'] == $_GET['month'] || $data['BulanId'] == $cMonth){		  
			echo "<option value='$data[BulanId]' SELECTED>$data[NamaBulan]</option>";
		  }
		  else {
		  echo "<option value='$data[BulanId]'>$data[NamaBulan]</option>";
		  }
	}
	echo "</td><td><select class='form-control' name='NamaTahun'>";

	 $sql = mysql_query("SELECT * FROM tbl_year WHERE Status='1'");					  
		  while ($data = mysql_fetch_array($sql)){
	if ($data['NamaTahun'] == $_GET['year'] ||  $data['NamaTahun'] == $cYear){		  
			echo "<option value=$data[NamaTahun] SELECTED>$data[NamaTahun]</option>";
		  }
		  else {
		  echo "<option value=$data[NamaTahun]>$data[NamaTahun]</option>";
		  }
	}	
	
?>
</td><td><button type="submit" class="btn btn-primary" name="submit">&nbsp;&nbsp;      View      &nbsp;&nbsp;</button>
<!--</td><td><input type="submit" name="submit" value=" View " ></td>-->
</form>

<td colspan=6><div style="float: right;">
	<a href="#"></td>
		  </tr>
	  
<tr>
	<td align="center" class="dayLabelku"><strong>Minggu</strong></td>
	<td align="center" class="dayLabel"><strong>Senin</strong></td>
	<td align="center" class="dayLabel"><strong>Selasa</strong></td>
	<td align="center" class="dayLabel"><strong>Rabu</strong></td>
	<td align="center" class="dayLabel"><strong>Kamis</strong></td>
	<td align="center" class="dayLabel"><strong>Jumat</strong></td>
	<td align="center" class="dayLabelku"><strong>Sabtu</strong></td>
</tr>
<?php 

$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
$maxday    = date("t",$timestamp);
$thismonth = getdate ($timestamp);
$startday  = $thismonth['wday'];
for ($i=0; $i<($maxday+$startday); $i++) {
	
	if(($i % 7) == 0 ) {
		echo "<tr>\n";
	}
	if($i < $startday) {echo "<td class='calendarTd'><div id='dayNum'> </div></td>\n";}
	
	else {
		//<font color='red'>
		$number=($i - $startday + 1);
		if ($cMonth<=10){$padMonth="0".$cMonth;}
		elseif ($cMonth>10){$padMonth=$cMonth;}
		if ($number<=10){$padnumber="0".$number;}
		elseif ($number>10){$padnumber=$number;}
		$full_date = $cYear."-".$padMonth."-".$padnumber;

		$HariHari  = date('Y-m-d');

		if(isset($_POST['submit'])){
			$a = $_POST['NamaTahun'];
			$b = $_POST['BulanId'];
			$cari=$_GET['year'].'-'.$_GET['month'].'-'.($i - $startday + 1);
			header("Location: ?month=$b&year=$a");
		}
		
		
		else {
			$a = $y;
			$b = $m;
			$cari= $full_date;
		}
		
		
		$tgl_merah = mysql_num_rows(mysql_query("SELECT * FROM tbl_holiday WHERE Tanggal = '$cari' AND IsWorking='1'"));
		$NamaMerah = mysql_fetch_array(mysql_query("SELECT * FROM tbl_holiday WHERE Tanggal = '$cari' AND IsWorking='1'"));
		
		
		$time = strtotime($tgl_merah['Tanggal']);
		$y    = date('Y', $time);
		$m    = date('m', $time);
		$d    = date('d', $time);
		
		if ($tgl_merah >= 1){
		$bg    = '#FF0000';
		$bgf    = '#FFFFFF';			
		$title = ' .'.$NamaMerah['Keterangan'];
		$a1    = '<b>';
		$a2    = '</b>';
		}

		elseif ($HariHari==$full_date && $tgl_merah <= 0){
		$bg    = '#99FFFF';
		$bgf    = '';		
		$title = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     &#94;&#95;&#94;';
		$a1    = '<b>';
		$a2    = '</b>';
		}

		else {
		$bg    = '';
		$bgf   = '';			
		$title = '';
		$a1    = '';
		$a2    = '';
		}

		echo "<td class='calendarTd' bgcolor='$bg' title='$title'><font color='$bgf'><div id='dayNumKu' align='left'>$a1". ($i - $startday + 1).$title." $a2</div>";
		$number=($i - $startday + 1);
		if ($cMonth<=10){$padMonth="0".$cMonth;}
		elseif ($cMonth>10){$padMonth=$cMonth;}
		if ($number<=10){$padnumber="0".$number;}
		elseif ($number>10){$padnumber=$number;}
		$full_date = $cYear."-".$padMonth."-".$padnumber;
		$next_number=$number+1;
		$next_date=$cYear."-".$cMonth."-".$next_number;
		echo "<div id ='dateInfo' style='font-size:11px;' align='left'>";
	
		$full_date  = mysql_real_escape_string($full_date);	
		
		//$tampil     = mysql_query("SELECT * FROM tbl_Agenda WHERE Tanggal = '$full_date'");

		//$tampil     = mysql_query("SELECT * FROM tbl_formCuti WHERE TglActive1 = '$full_date' AND StatusForm='A'");
		
		$tampil     = mysql_query("SELECT * FROM tbl_formCuti 
									INNER JOIN tbl_formcutidetail ON tbl_formcuti.CutiId = tbl_formcutidetail.CutiId  
									WHERE TglCuti = '$full_date' AND StatusForm='A' AND JenisCuti !=4 AND companyID='$company_id' ORDER BY TglCuti ASC");

		$no         = $number;
		while($data = mysql_fetch_array($tampil)){
			$NamaOpr= mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$data[FormCutiNIK]'"));

			$jen_cut= mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id = '$data[JenisCuti]'"));

			$tot_cuti = mysql_num_rows(mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId = '$data[CutiId]'"));
				
			$id     = $data['CutiId'];
			$NIK    = $data['FormCutiNIK'];
			$Topik  = $data['Keperluan'];
			$JmlCuti= $tot_cuti;
			//$Tanggal= $data['TglCuti'];
			$Tanggal= date('d M Y', strtotime($data['TglCuti']));
			$TglMasuk= date('d M Y', strtotime($data['TglMasuk']));
			//echo "<div align='left'><a href='#'>$NIK-$NamaOpr[Nama] ($Topik)</a></br>";

			echo"&#8727; <a class='tooltips' href='#'>$NamaOpr[Nama]<span>
			
			 </br><table cellspacing='2' cellpadding='2'>
			 	<tr><td width='70'>&nbsp;&nbsp; NIK</td><td width='8'>:</td><td>$NIK</td></tr>
			 	<tr><td>&nbsp;&nbsp; Nama</td><td>:</td><td> $NamaOpr[Nama]</td></tr>
			 	<tr><td>&nbsp;&nbsp; Jenis Cuti</td><td>:</td><td> $jen_cut[JenisCutiName]</td></tr>
			 	<tr><td>&nbsp;&nbsp; Tgl Cuti</td><td>:</td><td> $Tanggal</td></tr>
			 	<tr><td>&nbsp;&nbsp; Tgl Masuk</td><td>:</td><td> $TglMasuk</td></tr>
			 	<tr><td>&nbsp;&nbsp; Jml Cuti</td><td>:</td><td> $JmlCuti Hari</td></tr>
			 	<tr><td>&nbsp;&nbsp; Keperluan</td><td>:</td><td> $Topik</td></tr>
			 	
			 </table>
			 

			 </span></a>
			 </br>";



	
		$no++;
	}
}	
		
		echo "</div>";
		echo "</td>\n";
	}
	if(($i % 7) == 6 ) echo "</tr>\n";

?>
</table>
</td>
</tr>
</table>
</div><!--calendarDiv--!>
</body>
</html>
