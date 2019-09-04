<?php

include "../../includes/koneksi/koneksi.php";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=ReportPSC.xls");//ganti nama sesuai keperluan
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

	
	if (!is_null($_GET['month'])){
		$month = $_GET['month'];
		$yy    = substr($month,0,4);
		$mm    = substr($month,4,6);
		
		if ($mm=='01'){
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


	$db_SQL  = "SELECT iPSCDeptId, cDeptName ,iPSCCompanyId 
			 	FROM tbl_psc 
				INNER JOIN tbl_dept ON tbl_psc.iPSCDeptId = tbl_dept.iDeptID 
				WHERE MONTH( dPSCDAte ) =  '$mm' 
				AND YEAR( dPSCDAte ) =  '$yy' 
				AND iPSCCompanyId != 2
				GROUP BY iPSCDeptId, cDeptName 
				ORDER BY iPSCCompanyId,iPSCDeptId ASC ";
				
	$db_conn = mysql_query($db_SQL);
	$total	 = mysql_num_rows($db_conn);
	
	
?>
<table width="70%" id="tfhover" class="tftable" border="1" cellpadding="2" cellspacing="2" frame="box">
  <tr>
    <th height="47" colspan="5" scope="col"><div align="center" class="style2"><strong>LAPORAN BIAYA PRINTING,SCANNING &amp; COPY CD/DVD <?php echo $nM.' '.$yy.' , Total DEPT: '.$total ?></strong></div></th>
  </tr>
<?php

$no = 1;
while($data = mysql_fetch_array($db_conn)){
	$compa = mysql_fetch_array(mysql_query("SELECT * FROM tbl_company WHERE iCompanyId = $data[iPSCCompanyId]"));

?>  
  <tr>
    <th colspan="5"><div align="left"><span class="style3"><?php echo $data['iPSCDeptId'].'. '.$data['cDeptName'].'  &nbsp;&nbsp;&nbsp;#'.$compa['cCompanyCode'] ?></span></div></th>
  </tr>
  
  <tr>
    <th width="120" height="25" bgcolor="#999999"><div align="center"><strong>Tanggal</strong></div></th>
    <th width="150" bgcolor="#999999"><div align="center"><strong>Nama</strong></div></th>
    <th width="40" bgcolor="#999999"><div align="center"><strong>Jumlah</strong></div></th>
    <th width="250" bgcolor="#999999"><div align="center"><strong>Subject</strong></div></th>
    <th width="80" bgcolor="#999999"><div align="center"><strong>Total</strong></div></th>
  </tr>
  
 <?php
 
 	$type_SQL ="SELECT itypeId, cTypeName FROM tbl_psc 
				INNER JOIN tbl_psc_type ON tbl_psc.iPSCTypeId = tbl_psc_type.itypeId 
				WHERE MONTH( dPSCDAte ) =  '$mm' 
				AND YEAR( dPSCDAte ) =  '$yy' 
				AND iPSCDeptId='$data[iPSCDeptId]' 
				GROUP BY itypeId, cTypeName 
				ORDER BY itypeId ASC";
				
	$type_conn = mysql_query($type_SQL);
	$total_type	 = mysql_num_rows($type_conn);
				
while($row_type = mysql_fetch_array($type_conn)){

	$row	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_psc 
											 WHERE MONTH( dPSCDAte ) =  '$mm' 
											 AND YEAR( dPSCDAte ) =  '$yy' 
											AND iPSCDeptId ='$data[iPSCDeptId]' 
											AND iPSCTypeId ='$row_type[itypeId]'
											ORDER BY dPSCDAte ASC"));
						
 ?>
  <tr>
    <td height="20" colspan="5"><div class="style4"><strong><?php echo $row_type['cTypeName'] ?></strong></div></td>
  </tr>
<?php  
  $rw_SQL ="SELECT * FROM tbl_psc 
  			WHERE MONTH( dPSCDAte ) =  '$mm' 
            AND YEAR( dPSCDAte ) =  '$yy' 
			AND iPSCDeptId ='$data[iPSCDeptId]' 
			AND iPSCTypeId ='$row_type[itypeId]'
			ORDER BY dPSCDAte ASC";
			
	$rw_conn = mysql_query($rw_SQL);
	$total_rw	 = mysql_num_rows($rw_conn);
	
while($row = mysql_fetch_array($rw_conn)){
	
	$sql_tot = mysql_fetch_array(mysql_query("SELECT * FROM tbl_psc_type WHERE itypeId = $row[iPSCTypeId]"));
	$iPSCQty    = number_format($row['iPSCQty'], 0);
	$mTypePrice = number_format($sql_tot['mTypePrice'], 0);
	//$harga = $iPSCQty * $mTypePrice;
	
	$hrg = $row['iPSCQty'] * $sql_tot['mTypePrice'];
	$harga = number_format($hrg, 0);
	//@$grand += $hrg;
	
	$dPSCDate = date('d M Y , H:i', strtotime($row['dPSCDate']));
			
?>
  <tr>
    <td height="20"><?php echo $dPSCDate ?></td>
    <td height="20"><?php echo $row['cPSCName'] ?></td>
    <td><div align="center"><?php echo $row['iPSCQty'] ?></div></td>
    <td><?php echo $row['tPSCRemark'] ?></td>
    <td><div align="right"><?php echo $harga ?></div></td>
  </tr>
 
 <?php
 }
 
 
 $total1 = mysql_fetch_array(mysql_query("SELECT SUM( iPSCQty ) AS Jumlah
											FROM tbl_psc
											WHERE MONTH( dPSCDAte ) =  '$mm' 
            								AND YEAR( dPSCDAte ) =  '$yy' 
											AND iPSCDeptId ='$data[iPSCDeptId]' 
											AND iPSCTypeId ='$row_type[itypeId]'
											ORDER BY dPSCDAte ASC"));
											
 $sql_tot1 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_psc_type WHERE itypeId = $row_type[itypeId]"));
 
 	$hrg2   = $total1['Jumlah'] * $sql_tot1['mTypePrice'];
	$harga2 = number_format($hrg2, 0);
	
	
											

 ?>
  
  <tr>
    <td colspan="4"><div class="style5"><strong>Total Biaya <?php echo $row_type['cTypeName'] ?></strong></div></td>
    <td><div class="style5"><?php echo $harga2 ?></div></td>
  </tr>
  
  <?php
    
				
  }
  
  $total22 = mysql_fetch_array(mysql_query("SELECT sum(iPSCQty * mTypePrice) AS Jml FROM tbl_psc 
				INNER JOIN tbl_psc_type ON tbl_psc.iPSCTypeId = tbl_psc_type.itypeId 
				WHERE MONTH( dPSCDAte ) =  '$mm' 
            								AND YEAR( dPSCDAte ) =  '$yy' 
											AND iPSCDeptId ='$data[iPSCDeptId]' 
				ORDER BY itypeId ASC"));
				
		$grand = number_format($total22['Jml'], 0);
		
		//@$grand += $hgg;
				
				
  
  ?>
  <tr>
    <td colspan="4"><div class="style6"><strong>Total biaya <?php echo $data['cDeptName'] ?></strong></div></td>
    <td><div class="style6"><?php echo $grand ?></div></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  
 <?php
 
 $no++;
 }
 
 ?>
</table>
</body>
</html>