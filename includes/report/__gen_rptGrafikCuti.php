<?php

include "../../includes/koneksi/koneksi.php";
$day = date ("d-m-Y_H:i");

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Report_Cuti_$day.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report PSC</title>

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

</style>
</head>

<body>

<?php
//include "./includes/koneksi/koneksi.php";
	
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




	 //$find1  = $yyyy.'-'.$mm.'-'.$dd.'<br/>';
	 //$find2  = $yyyy_2.'-'.$mm_2.'-'.$dd_2.'<br/>';


	$db_SQL = "SELECT * FROM `tbl_formcuti` INNER JOIN 
         tbl_formcutidetail ON tbl_formcuti.CutiId = tbl_formcutidetail.CutiId INNER JOIN 
         tbl_profile ON tbl_formcuti.FormCutiNIK = tbl_profile.NIK		
		WHERE TglCuti >='$find1' AND TglCuti <='$find2' 
		AND tbl_profile.CompanyId ='$_GET[pt]' AND DivisiID$div AND DeptID$dept 
		AND StatusForm='A'
		GROUP BY tbl_formcuti.CutiId";


	$db_conn = mysql_query($db_SQL);
	$total	 = mysql_num_rows($db_conn);

 $total;
	
	
?>

	<table width="100%" id="tfhover" class="tftable" border="1" cellpadding="2" cellspacing="2" frame="box">
  <tr>
    <th height="47" colspan="8" scope="col"><div align="center" class="style2"><strong>LAPORAN CUTI</strong></div></th>
  </tr>
<?php

$no = 1;


?>  
 
  
  <tr>
  	<th width="20" height="25" bgcolor="#999999"><div align="center"><strong>No</strong></div></th>
    <th width="50" height="25" bgcolor="#999999"><div align="center"><strong>NIK</strong></div></th>
    <th width="170" bgcolor="#999999"><div align="center"><strong>Nama</strong></div></th>
    <th width="100" bgcolor="#999999"><div align="center"><strong>Subject</strong></div></th>
    <th width="50" bgcolor="#999999"><div align="center"><strong>Jml Cuti</strong></div></th>
    <th width="80" bgcolor="#999999"><div align="center"><strong>Jenis Cuti</strong></div></th>
    <th width="200" bgcolor="#999999"><div align="center"><strong>Tgl Cuti</strong></div></th>
    <th width="80" bgcolor="#999999"><div align="center"><strong>Tgl Masuk</strong></div></th>
  </tr>
  
 <?php
 
 	
				
while($data = mysql_fetch_array($db_conn)){

	$detail_a = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId = $data[CutiId]");
	$JmlCuti  = mysql_num_rows($detail_a);

	$jes = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id = $data[JenisCuti]"));


	
 ?>
  
  <tr>
  	<td height="20"><div align="center"><?php echo $no ?></div></td>
    <td height="20"><?php echo $data['NIK'] ?></td>
    <td height="20"><?php echo $data['Nama'] ?></td>
    <td><div align="left"><?php echo $data['Keperluan'] ?></div></td>
    <td><?php echo $JmlCuti. ' Hari' ?></td>
    <td><div align="center"><?php echo $jes['JenisCutiName'] ?></div></td>
    <td><div align="left">

    	<?php 
while($dw = mysql_fetch_array($detail_a)){
	$TglCuti = date('d-M-Y', strtotime($dw['TglCuti']));
    	echo $TglCuti.', '; 
    }
?>
    </div></td>
    <td><div align="right"><?php echo $data['TglMasuk'] ?></div></td>
  </tr>
 
 <?php
 
 

  

 
 $no++;
 }
 
 ?>
</table>

</body>
</html>
