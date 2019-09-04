<?php

include "../../includes/koneksi/koneksi.php";
$day = date ("d-m-Y_H:i");

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Sisa_Cuti_$day.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report PSC</title>

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

td.thickBorder{ border-bottom: solid gray 1px;}
td.thickBorderRight{ border-right: solid gray 1px;
					border-bottom: solid gray 1px;}

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

</style>-->

<style>
body{
    font-family:Arial;
}
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

td.thickBorder{
    border-right:0px;
}

</style>
</head>

<body>

<?php
	
	
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




	


	$today  = date ("Y-m-d");	
	$tampil = mysql_query("SELECT *,sum(Qty) AS Qty FROM tbl_hakcuti INNER JOIN 
							tbl_profile ON tbl_hakcuti.NIK=tbl_profile.NIK 
							WHERE tbl_hakcuti.NIK !=0 AND tbl_profile.CompanyId ='$company_id' AND DivisiID$div AND DeptID$dept 
							AND (Periode2 >='$today' OR PeriodeExt >='$today')
							AND tbl_hakcuti.JenisHakCuti='$_GET[jc]' GROUP BY tbl_hakcuti.NIK");

	$jeb 	 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id = $_GET[jc]"));

  	$total   = mysql_num_rows($tampil);

	
	
?>

	<table id="tfhover" class="tftableon" width="900" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td height="80" colspan="8"><div align="center" class="style2"><strong>Laporan Sisa Cuti <?php echo $jeb['JenisCutiName'] ?></strong></div></td>
  </tr>

  <tr>
  	<th width="50" height="25" bgcolor="#999999"><div align="center"><strong>No</strong></div></th>
    <th width="80" height="25" bgcolor="#999999"><div align="center"><strong>NIK</strong></div></th>
    <th width="150" bgcolor="#999999"><div align="center"><strong>Nama</strong></div></th>
    <th width="100" bgcolor="#999999"><div align="center"><strong>Jenis Cuti</strong></div></th>
    <th width="100" bgcolor="#999999"><div align="center"><strong>Company</strong></div></th>
    <th width="120" bgcolor="#999999"><div align="center"><strong>Divisi</strong></div></th>
    <th width="200" bgcolor="#999999"><div align="center"><strong>Department</strong></div></th>
    <th width="80" bgcolor="#999999"><div align="center"><strong>Sisa Cuti</strong></div></th>
  </tr>
<?php

$no = 1;
  	
while ($data = mysql_fetch_array($tampil)){

	$sqli = mysql_fetch_array(mysql_query("SELECT FormCutiNIK,COUNT(tbl_formcuti.CutiId) AS QtyPakai 
											FROM `tbl_formcuti` INNER JOIN tbl_formcutidetail ON 
											tbl_formcuti.CutiId=tbl_formcutidetail.CutiId INNER JOIN 
											tbl_hakcuti ON tbl_formcuti.HakCutiId = tbl_hakcuti.HakId 
											WHERE FormCutiNIK='$data[NIK]' AND tbl_formcuti.StatusForm='A' 
											AND tbl_hakcuti.JenisHakCuti='$data[JenisHakCuti]' AND (Periode2 >='$today' OR PeriodeExt >='$today')
											GROUP BY FormCutiNIK"));

	
	$wd_com  = mysql_fetch_array(mysql_query("SELECT * FROM tbl_company WHERE iCompanyId = $data[CompanyId]"));
	$wd_div  = mysql_fetch_array(mysql_query("SELECT * FROM tbl_div WHERE iDivId = $data[DivisiID]"));
	$wd_dept = mysql_fetch_array(mysql_query("SELECT * FROM tbl_dept WHERE iDeptID = $data[DeptID]"));

	$jes 	 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id = $data[JenisHakCuti]"));


			$Qty      = $data['Qty'];
			$QtyPakai = $sqli['QtyPakai'];

			if (is_null($QtyPakai) || $QtyPakai=='' || $QtyPakai==0){
				$pakai =0;
			}else{
				$pakai =$sqli['QtyPakai'];
			}
            
            $Sisa     = $Qty - $pakai;


?>
    <tr>
  	<td height="20" bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo $no ?></div></td>
    <td height="20" bgcolor="<?php echo color_td($no)?>"><?php echo $data['NIK'] ?></td>
    <td height="20" bgcolor="<?php echo color_td($no)?>"><?php echo $data['Nama'] ?></td>
    <td height="20" bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo $jes['JenisCutiName'] ?></div></td>
    <td bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo $wd_com['cCompanyCode'] ?></div></td>
    <td bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo $wd_div['cDivName'] ?><div></td>
    <td bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo $wd_dept['cDeptName'] ?></div></td>
    <td bgcolor="<?php echo color_td($no)?>"><div align="center"><?php echo $Sisa ?></div></td>
  </tr>

<?php
$no++;
}
 
function color_td($value){
    if ($value %2==0){
        return '#F7F7F7';
    }
    else{
        return '';
    }

}

?>
</table>

</body>
</html>
