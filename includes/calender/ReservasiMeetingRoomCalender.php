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
<link href="http://astapp02/hris2/includes/calender/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="icon.png" />


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
  height: 120px;
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
require('includes/koneksi/koneksi.php');
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

<td width="50%" align="left"><a class="Previous" href="<?php echo "?month=". $prev_month . "&year=" . $prev_year; ?>" style=""><img src='http://astapp02/hris2/includes/calender/images/previous.png'> Previous</a></td>
<td width="50%" align="right"><a class="Next" href="<?php echo "?month=". $next_month . "&year=" . $next_year; ?>" style="">Next <img src='http://astapp02/hris2/includes/calender/images/next.png'></a>  </td>
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
/*
echo"<td><select id=select1 onchange=goToPage('select1')>
";	
    $sql = mysql_query("SELECT * FROM tblPeriod");					  
		  while ($data = mysql_fetch_array($sql)){
	if ($data['MonthId'] == $_GET['month'] && $data['YearId'] == $_GET['year']){		  
			echo "<option value='?month=$data[MonthId]&year=$data[YearId]' SELECTED>$data[cName]</option>";
		  }
		  else {
		  echo "<option value='?month=$data[MonthId]&year=$data[YearId]'>$data[cName]</option>";
		  }
	}	
*/	
?>


<?php
echo "<form method=POST action='?'>
		<td><select class='dropdown_box1' name='BulanId'>";	
    $sql = mysql_query("SELECT * FROM tbl_month");					  
		  while ($data = mysql_fetch_array($sql)){
	if ($data['BulanId'] == $_GET['month'] || $data['BulanId'] == $cMonth){		  
			echo "<option value='$data[BulanId]' SELECTED>$data[NamaBulan]</option>";
		  }
		  else {
		  echo "<option value='$data[BulanId]'>$data[NamaBulan]</option>";
		  }
	}
	echo "</td><td><select class='dropdown_box2' name='NamaTahun'>";

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
</td><td><button type="submit" class="styled-button-8" name="submit">&nbsp;&nbsp;      View      &nbsp;&nbsp;</button>
<!--<input type="submit" name="submit" value=" View " >-->
</td>
</form>

<td colspan=6><div style="float: right;">
	<!--<a href="#"><img style="border:0;" src="http://astapp02/hris2/includes/calender/images/admin.png" alt="Admin Calender" width="25" height="25"></a>--></td>
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
		
		if ($tgl_merah >= 1 ){
		$bg    = '#FF0000';
		$bgf    = '#FFFFFF';		
		$title = ' .'.$NamaMerah['Keterangan'];
		$a1    = '<b>';
		$a2    = '</b>';
		}

		elseif ($HariHari==$full_date && $tgl_merah <= 0){
		$bg    = '#99FFFF';
		$bgf    = '';		
		$title = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     &hearts;';
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

		$tampil     = mysql_query("SELECT * FROM tbl_booking_meeting_room 
									LEFT JOIN tbl_meetingroom ON tbl_booking_meeting_room.booking_room = tbl_meetingroom.room_id  
									WHERE DATE_FORMAT(booking_Active1, '%Y-%m-%d') = '$full_date' AND booking_status='1' ORDER BY booking_room,booking_Active1 DESC");

		
		$no         = 1;
		while($data = mysql_fetch_array($tampil)){
			$Room   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_meetingroom WHERE room_id = '$data[booking_room]'"));


			//$tot_cuti = mysql_num_rows(mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId = '$data[CutiId]'"));

			//$tgl_cuti    = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId = '$data[CutiId]' ORDER BY TglCuti ASC"));
	
			//$id     = $data['CutiId'];
			//$NIK    = $data['FormCutiNIK'];
			$Jam1     = date('H:i', strtotime($data['booking_Active1']));
			$Jam2     = date('H:i', strtotime($data['booking_Active2']));
			$Ruangan  = $Room['room_name'];
			$Topik    = $data['booking_keperluan'];
			//$JmlCuti= $tot_cuti;
			$Tanggal  = $data['booking_Active1'];

			if ($data['booking_status'] ==1){
				$status_me = 'Active';
			}
			else{
				$status_me = 'Inactive';
			}
			
			//echo "<div align='left'><a href='#'>$no. $Ruangan - ($Topik by:$data[booking_user]) Pkl: $Jam1 - $Jam2 WIB</a></br>";
			//echo'<a href="#" class="tt">hover here!<span class="tooltip"><span class="top"></span><span class="middle">WWOOWW!, <br />This really is a very long tooltip.  Normally they aren,t this long but every once in a while you feel the urge to use a really long description to make sure you get your point across to everyone!  This could go on and on all of the way down the page and probably overflow onto the next website you visit!  No, seriously go check the next website you planned on visiting..but you have to be quick when you move the mouse off of this link.  I bet you cant do it fast enough ;)</span><span class="bottom"></span></span></a>';
			/*
			echo"<a class='tooltips' href='#'>$no. $Ruangan - Pkl: $Jam1 - $Jam2<span>

			 &nbsp;&nbsp;			Room &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $Ruangan <br/>
			 &nbsp;&nbsp;			User &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $data[booking_user] </br>
			 &nbsp;&nbsp;			Keperluan : $Topik</br>
			 &nbsp;&nbsp;			Mulai : Pukul $Jam1 WIB <br/>
			 &nbsp;&nbsp;			Selesai : Pukul $Jam2 WIB </span></a></br>";
*/
			 
			 echo"<a class='tooltips' href='#'>$no. $Ruangan - Pkl: $Jam1 - $Jam2<span>
			
			 </br><table cellspacing='2' cellpadding='2'>
			 	<tr><td width='70'>&nbsp;&nbsp; Room</td><td width='8'>:</td><td>$Ruangan</td></tr>
			 	<tr><td>&nbsp;&nbsp; User</td><td>:</td><td> $data[booking_user]</td></tr>
			 	<tr><td>&nbsp;&nbsp; Keperluan</td><td>:</td><td> $Topik</td></tr>
			 	<tr><td>&nbsp;&nbsp; Mulai</td><td>:</td><td> $Jam1 WIB</td></tr>
			 	<tr><td>&nbsp;&nbsp; Selesai</td><td>:</td><td> $Jam2 WIB</td></tr>
			 	<tr><td>&nbsp;&nbsp; Status</td><td>:</td><td> $status_me</td></tr>
			 </table>
			 

			 </span></a>
			 </br>";


			//echo '<a href="#" title="This is some information for our tooltip."><span title="More">CSS3 Tooltip</span></a>';
			//echo '<a title="A tooltip with default settings, <br/>the href is displayed below the title" href="http://google.de">Link to google</a>';
			//echo'<a href="http://astapp02/hris2/includes/calender/ajax5.htm" class="jTip" id="four" name="Window caption or title">No Specified Width</a>';
			//echo "<div align='left'><a href='#' class='tooltip-bottom' data-tooltip=$Topik>$no. $Ruangan -by:$data[booking_user] Pkl: $Jam1 - $Jam2 WIB</a></br>";
			//echo "<div align='left'><a href=javascript:void(0); title='' onClick=window.open('http://$_SERVER[SERVER_NAME]/hris2/includes/Calender/AgendaDetail.php?month=$_GET[month]&year=$_GET[year]&id=$id','Ratting','width=700,height=500,left=0,0,status=0,scrollbars=1',toolbar=0,status=0);>$id. $Topik $tgl_merah $cari</a></br>";
			//echo $no.'.'.$event_title."<br />";
			//echo"<table width=100%><hr width=100%></table>";
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
