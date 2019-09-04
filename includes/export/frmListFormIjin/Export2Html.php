<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Permohonan Ijin</title>
<style type=text/css>
#body {
	font-size:36px;
}

.noPrint {
    display: none;
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
table {font-size: 16px;}
.style1 {
	font-size: 30px;
	font-weight: bold;
}
.style2 {font-size: 9px}
</style>

</head>

<body>
<a href="javascript:window.print()";><img style=border:0; src="http://<?php echo $_SERVER['SERVER_NAME']?>/hris2/includes/images/printer1.png" onmouseover=this.src="http://<?php echo $_SERVER['SERVER_NAME']?>/hris2/includes/images/printer2.png" onmouseout=this.src="http://<?php echo $_SERVER['SERVER_NAME']?>/hris2/includes/images/printer1.png" title="Print" width="30" height="30"></a>
<br/>

<?php
	include "../../koneksi/koneksi.php";
/*	
	$sql 	= "SELECT * FROM tbl_formijin LEFT JOIN
                      tbl_profile ON tbl_formijin.NIK = tbl_profile.NIK LEFT JOIN
					  tbl_company ON tbl_profile.CompanyId = tbl_company.iCompanyId LEFT JOIN
                      tbl_div ON tbl_profile.DivisiID = tbl_div.iDivId LEFT JOIN
                      tbl_dept ON tbl_profile.DeptID = tbl_dept.iDeptID LEFT JOIN
					  tbl_unit ON tbl_profile.UnitID = tbl_unit.unitID LEFT JOIN
					  tbl_jenisijin ON tbl_formijin.JenisIjin = tbl_jenisijin.JenisIjinId LEFT JOIN
					  tbl_jabatan ON tbl_profile.JabatanID = tbl_jabatan.JabatanId
					  WHERE tbl_formijin.IjinId=$_GET[id]";
*/
 

 $sql = " SELECT *,
          tbl_formijin.CreatedTime AS tglbuat,
          tbl_formijin.NIK1 AS NIK1_data,
          tbl_formijin.NIK2 AS NIK2_data
          FROM tbl_formijin
          LEFT JOIN tbl_profile ON tbl_formijin.NIK = tbl_profile.NIK
          LEFT JOIN tbl_company ON tbl_profile.CompanyId = tbl_company.iCompanyId
          LEFT JOIN tbl_div ON tbl_profile.DivisiID = tbl_div.iDivId
          LEFT JOIN tbl_dept ON tbl_profile.DeptID = tbl_dept.iDeptID
          LEFT JOIN tbl_unit ON tbl_profile.UnitID = tbl_unit.unitID
          LEFT JOIN tbl_jenisijin ON tbl_formijin.JenisIjin = tbl_jenisijin.JenisIjinId
          LEFT JOIN tbl_jabatan ON tbl_profile.JabatanID = tbl_jabatan.JabatanId
          WHERE tbl_formijin.ijinid = ".$_GET[id];            

	$tampil 	= mysql_query($sql);		
	$data 		= mysql_fetch_array($tampil);
	$total  	= mysql_num_rows($tampil);
	

	//$TglMasuk 	= date('d M Y', strtotime($data['TglMasuk']));
  
	$CreatedTime = date('d M Y', strtotime($data['tglbuat']));
	$Tgl1        = date('d M Y', strtotime($data['Tgl1']));
	$Tgl2        = date('d M Y', strtotime($data['Tgl2']));
	
	

	$NIK1 		 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$data[NIK1_data]'"));	
	$NIK2 		 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$data[NIK2_data]'"));	
	
	if ($data['Apv1']=='A'){
		$Apv1	= 'APPROVED';
	}
	elseif ($data['Apv1']=='R'){
		$Apv1	= 'REJECTED';
	}
	
	elseif ($data['Apv1']=='X'){
		$Apv1	= 'CANCELED/VOID';
	}
	
	else{
		$Apv1	= '';
	}
	
	
	if ($data['Apv2']=='A'){
		$Apv2	= 'APPROVED';
	}
	elseif ($data['Apv2']=='R'){
		$Apv2	= 'REJECTED';
	}
	
	elseif ($data['Apv2']=='X'){
		$Apv2	= 'CANCELED/VOID';
	}
	
	else{
		$Apv2	= '';
	}
	
		// Dinas Luar Kantor
		if ($data['JenisIjin'] ==3){
			$JenisIjin3_BG = '#999999';
			$JenisIjin3_NM = 'V';	
	
		}
		
		// Dinas Luar Kota
		if ($data['JenisIjin'] ==2){
			$JenisIjin2_BG = '#999999';
			$JenisIjin2_NM = 'V';	
	
		}
		
		//Sakit + Surat
    //Revisi kesalahan jenisijin => Ronald (27/05/2019)
		if ($data['JenisIjin'] ==10){
			$JenisIjin6_BG = '#999999';
			$JenisIjin6_NM = 'V';	
	
		}
		// Sakit
		if ($data['JenisIjin'] ==5){
			$JenisIjin5_BG = '#999999';
			$JenisIjin5_NM = 'V';	
	
		}
	

?>
<table width="900" class="table1" border="0px" cellpadding="0" cellspacing="0" frame="box">
  <tr>
    <td scope="col"><table width="900" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td scope="col" height="25"><div align="left"><strong><?php echo $data['cCompanyName'] ?></strong></div></td>
        <td scope="col"><div align="right" class="style2">FO-022-HLD Rev. 1 - Jun 13</div></td>
      </tr>
      <tr>
        <td colspan="2" scope="row" class="thickBorder" height="40"><div align="center" class="style1"><strong>PERMOHONAN IJIN</strong></div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="900" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25" scope="col">&nbsp;</td>
        <td width="157" scope="col"><div align="left"></div></td>
        <td width="23" scope="col">&nbsp;</td>
        <td width="272" scope="col">&nbsp;</td>
        <td width="61" scope="col">&nbsp;</td>
        <td width="85" scope="col">&nbsp;</td>
        <td width="25" scope="col">&nbsp;</td>
        <td width="228" scope="col">&nbsp;</td>
        <td width="24" scope="col">&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td>Mohon diijinkan,</td>
        <td>:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td>Nama</td>
        <td>:</td>
        <td class="thickBorder"><?php echo $data['Nama'] ?></td>
        <td>&nbsp;</td>
        <td>NIK</td>
        <td>:</td>
        <td class="thickBorder"><?php echo $data['NIK'] ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td>Div / Dept / Unit</td>
        <td>:</td>
        <td class="thickBorder"><?php echo $data['cDivName'].'/ '.$data['cDeptName'].'/ '.$data['NamaUnit'] ?></td>
        <td>&nbsp;</td>
        <td>Jabatan</td>
        <td>:</td>
        <td class="thickBorder"><?php echo $data['NamaJabatan'] ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="9" scope="row" height="25" class="thickBorder">&nbsp;</td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="900" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="24" scope="col" height="30">&nbsp;</td>
        <td width="25" scope="col">1.</td>
        <td width="196" scope="col">Datang lbh awal/terlambat</td>
        <td width="31" scope="col"><div align="center">:</div></td>
        <td width="33" scope="col">Jam</td>
        <td width="105" scope="col" class="thickBorder">&nbsp;</td>
        <td width="28" scope="col">Tgl</td>
        <td width="110" scope="col" class="thickBorder">&nbsp;</td>
        <td width="27" scope="col">Bln</td>
        <td width="111" scope="col" class="thickBorder">&nbsp;</td>
        <td width="30" scope="col">Thn</td>
        <td width="155" scope="col" class="thickBorder">&nbsp;</td>
        <td width="25" scope="col">&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="30">&nbsp;</td>
        <td>2.</td>
        <td>Pulang lebih awal</td>
        <td><div align="center">:</div></td>
        <td>Jam</td>
        <td class="thickBorder">&nbsp;</td>
        <td>Tgl</td>
        <td class="thickBorder">&nbsp;</td>
        <td>Bln</td>
        <td class="thickBorder">&nbsp;</td>
        <td>Thn</td>
        <td class="thickBorder">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="30">&nbsp;</td>
        <td>3.</td>
        <td>Dinas luar</td>
        <td><div align="center">:</div></td>
        <td><table width="30" class="table1" border="0px" cellpadding="0" cellspacing="0" frame="box">
          <tr>
            <td bgcolor="<?php echo $JenisIjin3_BG ?>" scope="col"><div align="center"><strong>&nbsp;<?php echo $JenisIjin3_NM?></strong></div></td>
          </tr>
        </table></td>
        <td>&nbsp;&nbsp;Kantor</td>
        <td>Tgl</td>
        <td class="thickBorder">&nbsp;</td>
        <td>s/d</td>
        <td class="thickBorder">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Jam</td>
        <td class="thickBorder">&nbsp;</td>
        <td>s/d</td>
        <td class="thickBorder">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="30">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><table width="30" class="table1" border="0px" cellpadding="0" cellspacing="0" frame="box">
          <tr>
            <td bgcolor="<?php echo $JenisIjin2_BG ?>" scope="col"><div align="center">&nbsp;<?php echo $JenisIjin2_NM ?></div></td>
          </tr>
        </table></td>
        <td>&nbsp;&nbsp;Kota</td>
        <td>Tgl</td>
        <td class="thickBorder">&nbsp;</td>
        <td>Tgl</td>
        <td class="thickBorder">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="30">&nbsp;</td>
        <td>4.</td>
        <td>Ijin tidak masuk kerja</td>
        <td><div align="center">:</div></td>
        <td><table width="30" class="table1" border="0px" cellpadding="0" cellspacing="0" frame="box">
          <tr>
            <td bgcolor="<?php echo $JenisIjin5_BG ?>" scope="col">&nbsp;<?php echo $JenisIjin5_NM ?></td>
          </tr>
        </table></td>
        <td colspan="3">&nbsp;&nbsp;Sakit tanpa surat dokter</td>
        <td><table width="30" class="table1" border="0px" cellpadding="0" cellspacing="0" frame="box">
          <tr>
            <td bgcolor="<?php echo $JenisIjin6_BG ?>" scope="col">&nbsp;<?php echo $JenisIjin6_NM ?></td>
          </tr>
        </table></td>
        <td colspan="3">&nbsp;&nbsp;Sakit dengan surat dokter</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="30">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><table width="30" class="table1" border="0px" cellpadding="0" cellspacing="0" frame="box">
          <tr>
            <th scope="col">&nbsp;</th>
          </tr>
        </table></td>
        <td colspan="3">&nbsp;&nbsp;Ijin</td>
        <td><table width="30" class="table1" border="0px" cellpadding="0" cellspacing="0" frame="box">
          <tr>
            <th scope="col">&nbsp;</th>
          </tr>
        </table></td>
        <td colspan="3">&nbsp;&nbsp;Alpa / Mangkir</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Tgl</td>
        <td class="thickBorder">&nbsp;</td>
        <td>s/d</td>
        <td class="thickBorder">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="right">Alasan</div></td>
        <td><div align="center">:</div></td>
        <td colspan="8" class="thickBorder">&nbsp; <?php echo $data['Alasan']; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="13" scope="row" class="thickBorder">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="900" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="21" scope="col" height="25">&nbsp;</td>
        <td width="31" scope="col"><div align="left">Tgl</div></td>
        <td width="217" scope="col" class="thickBorder"><div align="center"> <?php echo $CreatedTime; ?></div></td>
        <td width="32" scope="col">&nbsp;</td>
        <td width="37" scope="col">Tgl</td>
        <td width="240" scope="col" class="thickBorder"><div align="center"><?php echo $Tgl1 ?></div></td>
        <td width="52" scope="col">&nbsp;</td>
        <td width="29" scope="col">Tgl</td>
        <td width="212" scope="col" class="thickBorder"><div align="center"><?php echo $Tgl2 ?></div></td>
        <td width="29" scope="col">&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">Menyetujui,</div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">Diterima,</div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="65" scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">
          <p>&nbsp;</p>
          </div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center"><strong><?php echo $Apv1 ?></strong></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center"><strong><?php echo $Apv2 ?></strong></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="22" scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="thickBorder"><div align="center"><?php echo $data['Nama'] ?></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="thickBorder"><div align="center"><?php echo $NIK1['Nama'] ?></div>
          <div align="center"></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="thickBorder"><div align="center"><?php echo $NIK2['Nama'] ?></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">Karyawan</div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">Atasan langsung, min. Ka  Dep / GM</div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">HRD</div></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
  </tr>
</table>
</body>
</html>
