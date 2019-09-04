<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<style>
A:link { COLOR: blue; TEXT-DECORATION: none; font-weight: none }
A:visited { COLOR: blue; TEXT-DECORATION: none; font-weight: none }
A:active { COLOR: blue; TEXT-DECORATION: none }
A:hover { COLOR: #FF0000; TEXT-DECORATION: none; font-weight: none }
.right { text-align: right;}
.center { text-align: center;}
</style>
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
<link rel="shortcut icon" href="icon.png" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" />

</head>
<body>
<?php
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
$cMonth = $_REQUEST["month"];
$cYear = $_REQUEST["year"];
$prev_year = $cYear;
$next_year = $cYear;
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
<td width="50%" align="left"><a class="Previous" href="<?php echo "master.php" . "?month=". $prev_month . "&year=" . $prev_year; ?>" style=""><img src='images/previous.png'> Previous</a></td>
<td width="50%" align="right"><a class="Next" href="<?php echo "master.php" . "?month=". $next_month . "&year=" . $next_year; ?>" style="">Next <img src='images/next.png'></a>  </td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center">
<table width="100%" border="0" cellpadding="2" cellspacing="2">
<tr align="center">
<td colspan="7"><h1 class="monthLabel"><center><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></center></h1></td>
</tr>
<tr>

<?php

echo"<td><select id=select1 onchange=goToPage('select1')>
<option value='0'>...</option>";	
    $sql = mysql_query("SELECT * FROM tblPeriod");					  
		  while ($data = mysql_fetch_array($sql)){
	if ($data[MonthId] == $_GET[month] && $data[YearId] == $_GET[year]){		  
			echo "<option value='?month=$data[MonthId]&year=$data[YearId]' SELECTED>$data[cName]</option>";
		  }
		  else {
		  echo "<option value='?month=$data[MonthId]&year=$data[YearId]'>$data[cName]</option>";
		  }
	}	
?>
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
$maxday = date("t",$timestamp);
$thismonth = getdate ($timestamp);
$startday = $thismonth['wday'];
for ($i=0; $i<($maxday+$startday); $i++) {
	
	if(($i % 7) == 0 ) {
		echo "<tr>\n";
	}
	if($i < $startday) {echo "<td class='calendarTd'><div id='dayNum'></div></td>\n";}
	
	else {
		
		echo "<td class='calendarTd'><div id='dayNum'>". ($i - $startday + 1)."</div>";
		$number=($i - $startday + 1);
		if ($cMonth<10){$padMonth="0".$cMonth;}
		elseif ($cMonth>10){$padMonth=$cMonth;}
		if ($number<10){$padnumber="0".$number;}
		elseif ($number>10){$padnumber=$number;}
		$full_date = $cYear."-".$padMonth."-".$padnumber;
		$next_number=$number+1;
		$next_date=$cYear."-".$cMonth."-".$next_number;
		echo "<div id ='dateInfo' style='font-size:10px;'>";
	
		$full_date=mysql_real_escape_string($full_date);//Use this if you are getting the date from somewhere shady.
	 	
		
		$tampil=mysql_query("SELECT * FROM event_table WHERE event_date = '$full_date'");
		$no=1;
		while($data = mysql_fetch_array($tampil)){		
			$event_id=$data['event_id'];
			$event_title=$data['event_title'];
			$event_date=$data['event_date'];
			echo "<a href=javascript:void(0); title='' onClick=window.open('http://202.153.21.4/Calender/AgendaDetail.php?month=$_GET[month]&year=$_GET[year]&id=$event_id','Ratting','width=700,height=500,left=900,0,status=0,scrollbars=1',toolbar=0,status=0);>$no. $event_title</a></br>";
			//echo $no.'.'.$event_title."<br />";
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
