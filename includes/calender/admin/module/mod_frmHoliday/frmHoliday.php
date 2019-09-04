<style>
A:link { COLOR: blue; TEXT-DECORATION: none; font-weight: none }
A:visited { COLOR: blue; TEXT-DECORATION: none; font-weight: none }
A:active { COLOR: blue; TEXT-DECORATION: none }
A:hover { COLOR: #FF0000; TEXT-DECORATION: underline; font-weight: none }
.right { text-align: right;}
.center { text-align: center;}
</style>


<script type="text/javascript">
function closeWin()
{
myWindow.close();
}
</script>
<script type = "text/javascript">
function goToPage( id ) {
  var node = document.getElementById( id );  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>
<?php
//***********************************************************************************************
    // Sub Name                 : Index_load
    // Created By               : Dompak Petrus
    // Created Date             : 25-Nov-2013
    // Last Update By           : none
    // Last Update Date         : none
    // Description              : This sub called at the first time web form loaded
    // Parameter                : none
    // Return Value             : none
//************************************************************************************************

session_start();
include "../../koneksi/koneksi.php";	

switch($_GET[act]){

	default:
	
	echo"<table width=100%>Holiday<hr width=100%></table>";
	echo"<table width='80%'> 
  <tr><td>Period</td><td>:</td><td><select id=select1 onchange=goToPage('select1')>
    <option value='0'>---Pilih---</option>";
	$sql = mysql_query("SELECT * FROM tblPeriod ORDER BY id ASC");					  
		  while ($data = mysql_fetch_array($sql)){		  
			echo "<option value='?module=frmHoliday&act=bSearch&PRD=$data[id]'>$data[cName]</option>";
		  }
		  
  echo"</select></table>";
echo"<table width=100%><hr width=100%></table>";

$_SESSION[ui]=$_GET[ui];	
break;

	break;

//*Searching by Period-----------------------------------------------------------------------------------//
	case"bSearch":
	
	$period=mysql_fetch_array(mysql_query("SELECT * FROM tblPeriod WHERE id='$_GET[PRD]'"));
	
echo"<table width=100%>Holiday >> $period[cName]<hr width=100%></table>";
echo"<table width='80%'> 
  <tr><td>Period</td><td>:</td><td><select id=select1 onchange=goToPage('select1')>";
    $sql = mysql_query("SELECT * FROM tblPeriod ORDER BY id ASC");					  
		  while ($data = mysql_fetch_array($sql)){
		  if ($data[id] == $_GET[PRD]){
			echo "<option value='?module=frmHoliday&act=bSearch&PRD=$data[id]' SELECTED>$data[cName]</option>";
			}
			else{
			echo "<option value='?module=frmHoliday&act=bSearch&PRD=$data[id]'>$data[cName]</option>";
		  }
}		  
  echo"</select></table>";
  
echo"<table width=100%><hr width=100%></table>";
echo "<input type=button value='   Add   ' onclick=\"window.location.href='?module=frmHoliday&act=tambah&PRD=$_GET[PRD]';\"></br>";
$Periode=mysql_fetch_array(mysql_query("SELECT * FROM tblPeriod WHERE id='$_GET[PRD]'"));	

$tampil=mysql_query("SELECT * FROM tblholiday WHERE (Tanggal >='$Periode[YearId]-$Periode[MonthId]-01' AND Tanggal <='$Periode[YearId]-$Periode[MonthId]-31') ORDER BY Tanggal ASC");	
	
	$total = mysql_num_rows($tampil);
if ($total <= 0 ){
echo"Tidak ada Data";
}
else {	
	echo "<table id='tfhover' class='tftable' border='0'>	
		<tr>
		<td colspan=12>Total : $total Record</td>
		</tr>
		<tr>
		<th>No</th>
		<th>Tanggal</th>
		<th>Topik</th>
		
		
		</tr>";
    
	$no=1;
	while($data = mysql_fetch_array($tampil)){
	$Tgl = date('d-m-Y', strtotime($data[Tanggal]));
	

	echo"<script type=text/javascript>
	window.onload=function(){
	var tfrow = document.getElementById('tfhover').rows.length;
	var tbRow=[];
	for (var i=1;i<tfrow;i++) {
		tbRow[i]=document.getElementById('tfhover').rows[i];
		tbRow[i].onmouseover = function(){
		  this.style.backgroundColor = '#FFFF66';
		};
		tbRow[i].onmouseout = function() {
		  this.style.backgroundColor = '#ffffff';
		};
	}
};
</script>";
	
		echo "<tr>
		<td rowspan=1 bgcolor=''><div align='center'>$no</td>		
		<td><div align='left'><a href=?module=frmHoliday&act=Detail&id=$data[id]>$Tgl</a></td>	
		<td><div align='left'>$data[Topik]</td>		
		</tr>";
		$no++;		
	}
//<td><a href=?module=inprogress&act=void&id=$data[iKBID]><div align='center'>Void</a></td>	
	echo "</table>";
	echo"<table width=100%><hr width=100%></table>";
	}
	break;

//+Tambah+--------------------------------------------------------------------------------------------------------// 	
	case"tambah":
	
	$period=mysql_fetch_array(mysql_query("SELECT * FROM tblPeriod WHERE id='$_GET[PRD]'"));

echo"<table width=100%>Holiday >> $period[cName]<hr width=100%></table>";
	echo"
	<form method=POST action='?module=frmHoliday&act=input'>
	<table id='tablekonten' width='100%'>		
	<tr><td>Date</td><td>:</td><td><input class='tcal' id='date' type=text name='Tanggal' size='15'></td></tr>	
	<tr><td>Topik</td><td>:</td><td><input type=text name='Topik' size=80</td></tr>

	";
	
	echo"<table width=100%>
	<tr>
	<td colspan=8><input name='simpan' type='submit' value='   Save   '>&nbsp;&nbsp;<input type=button value=' Cancel ' onclick=self.history.back()></div></td>
	</tr></table></form>";
	echo"<table width=100%><hr width=100%></table>";
	break;
	
//+Input+--------------------------------------------------------------------------------------------//
	case "input":

include "../../koneksi/koneksi.php";

if ($_POST[Tanggal]=="0" || $_POST[Topik]=="")
{
echo "<script language='javascript'>alert('Data Kurang Lengkap, Isilah data dengan Lengkap');history.go(-1);</script>";

}

else {

$Tambah =  mysql_fetch_array(mysql_query("SELECT max(id) AS No FROM tblholiday"));
$a=1;
$New=($Tambah[No] + $a);

$today = date ("m/d/Y");
$Tgl = date('Y-m-d', strtotime($_POST[Tanggal]));

mysql_query("INSERT INTO tblholiday (id,Tanggal,Topik) 
							VALUES ('$New','$Tgl','$_POST[Topik]')");


echo "<script language='javascript'>alert('Data Sudah disimpan');history.go(-2);</script>";
}
break;

//+Detail+-----------------------------------------------------------------------------------------------//

case"Detail":

	$edit = mysql_query("SELECT * FROM tblholiday WHERE id=$_GET[id]");
	$data = mysql_fetch_array($edit);	
$Tgl = date('m/d/Y', strtotime($data[Tanggal]));
echo"<table width=100%>Holiday >> Edit<hr width=100%></table>";
	echo"
	<form method=POST action='?module=frmHoliday&act=Update'>
	<input type='hidden' name='id' value='$_GET[id]'>
	<table id='tablekonten' width='100%'>		
	<tr><td>Date</td><td>:</td><td><input class='tcal' id='date' type=text name='Tanggal' size='15' value=$Tgl></td></tr>	
	<tr><td>Topik</td><td>:</td><td><input type=text name='Topik' size=80 value='$data[Topik]'</td></tr>
	
	";
	
	echo"<table width=100%>
	<tr>
	<td colspan=8><input name='simpan' type='submit' value='   Save   '>&nbsp;&nbsp;<input type=button value=' Cancel ' onclick=self.history.back()></div></td>
	<td><input type=button value=' Delete ' onclick=\"window.location.href='?module=frmHoliday&act=Delete&id=$_GET[id]';\"></td>
	</tr></table></form>";
	echo"<table width=100%><hr width=100%></table>";
	break;
	
	case "Update":
	$Tgl = date('Y-m-d', strtotime($_POST[Tanggal]));
	mysql_query("UPDATE tblholiday SET Tanggal = '$Tgl',
										Topik = '$_POST[Topik]'										
									WHERE id='$_POST[id]'");																
	
	echo "<script language='javascript'>alert('Data Sudah diupdate');history.go(-2);</script>";
	break;
	
	
	case "Delete":
	mysql_query("DELETE FROM tblholiday WHERE id='$_GET[id]'");																
	echo "<script language='javascript'>alert('Data Sudah hapus...');history.go(-2);</script>";
	break;
}		
?>
