
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Permohonan Cuti</title>

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

<?PHP
	include "../../koneksi/koneksi.php";

  
	
	$sql 	= "SELECT *,tbl_formcuti.TglMasuk AS TglMasuk, tbl_formcuti.Alamat AS Alamat,tbl_profile.Alamat AS AlamatRumah 
           FROM tbl_formcuti LEFT JOIN
                      tbl_profile ON tbl_formcuti.FormCutiNIK = tbl_profile.NIK LEFT JOIN
					  tbl_company ON tbl_profile.CompanyId = tbl_company.iCompanyId LEFT JOIN
                      tbl_div ON tbl_profile.DivisiID = tbl_div.iDivId LEFT JOIN
                      tbl_dept ON tbl_profile.DeptID = tbl_dept.iDeptID LEFT JOIN
					  tbl_unit ON tbl_profile.UnitID = tbl_unit.unitID LEFT JOIN
					  tbl_hakcuti ON tbl_formcuti.HakCutiId = tbl_hakcuti.HakId LEFT JOIN
					  tbl_jabatan ON tbl_profile.JabatanID = tbl_jabatan.JabatanId
					  WHERE tbl_formcuti.CutiId=$_GET[id]";
					  
	$detail 	= "SELECT * FROM tbl_formcutidetail WHERE CutiId=$_GET[id]";
	$jumlah 	= mysql_query("$detail");
	$JmlCuti  	= mysql_num_rows($jumlah);
	
	$tampil 	= mysql_query("$sql");		
	$data 		= mysql_fetch_array($tampil);
	$total  	= mysql_num_rows($tampil);
	
	$TglMasuk 	= date('d M Y', strtotime($data['TglMasuk']));
	$CreatedTime = date('d M Y', strtotime($data['CreatedTime']));
	
	$Tgl1        = date('d M Y', strtotime($data['Tgl1']));
	$Tgl2        = date('d M Y', strtotime($data['Tgl2']));

  $NIK1      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$data[NIK1]'")); 
  $NIK2      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$data[NIK2]'"));
	
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
	
	
	
	if ($data['JenisCuti'] ==1 || $data['JenisCuti'] ==4){
		$JenisCuti_BG1 = '#999999';
		$JenisCuti_NM1 = 'V';
		
		$JenisCuti_BG2 = '';
		$JenisCuti_NM2 = '&nbsp;';
		
		$Periode1 = date('d M Y', strtotime($data['Periode1']));
		$Periode2 = date('d M Y', strtotime($data['Periode2']));
		
	
	}
	elseif($data['JenisCuti'] ==2){
		$JenisCuti_BG1 = '';
		$JenisCuti_NM1 = '&nbsp;';
		
		$JenisCuti_BG2 = '#999999';
		$JenisCuti_NM2 = 'V';
	
	}
	else {
		$JenisCuti_BG1 = '';
		$JenisCuti_NM1 = '&nbsp;';
		
		$JenisCuti_BG2 = '';
		$JenisCuti_NM2 = '&nbsp;';
	
	}
	
	
	
	if ($data['StatusForm'] =='A'){
		$StatusForm_BG1 = '#999999';
		$StatusForm_NM1 = 'V';
		
		$StatusForm_BG2 = '';
		$StatusForm_NM2 = '&nbsp;';		
	
	}
	elseif($data['StatusForm'] =='R'){
		$StatusForm_BG1 = '';
		$StatusForm_NM1 = '&nbsp;';
		
		$StatusForm_BG2 = '#999999';
		$StatusForm_NM2 = 'V';	
	
	}
	else {
		$StatusForm_BG1 = '';
		$StatusForm_NM1 = '&nbsp;';
		
		$StatusForm_BG2 = '';
		$StatusForm_NM2 = '&nbsp;';	
	}

?>
<table width="900" class="table1" border="0px" cellpadding="0" cellspacing="0" frame="box">
  <tr>
    <td scope="col"><table width="900" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td width="445" height="33" scope="col"><div align="left"><strong>&nbsp;&nbsp;<?php echo $data['cCompanyName'] ?></strong></div></td>
        <td width="455" scope="col" height="40"><div align="right" class="style2">FO-023-HLD Rev. 1 - Jun 13 &nbsp;&nbsp;</div></td>
      </tr>
      <tr>
        <td colspan="2" scope="row"><div align="center" class="style1">PERMOHONAN CUTI</div></td>
        </tr>
      <tr>
        <td colspan="2" scope="row" class="thickBorder" height="30"><div align="center"><strong>Hak cuti tahunan kadaluarsa bila karyawan tidak mempergunakan hak cutinya sampai muncul kembali hak </strong></div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row">
    
    <table width="900" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="24" height="25" scope="col">&nbsp;</td>
        <td width="136" scope="col">Nama</td>
        <td width="12" scope="col">:</td>
        <td width="262" scope="col" class="thickBorder"><?php echo $data['Nama'] ?></td>
        <td width="32" scope="col">     
        
        
        </td>
        <td width="150" scope="col">NIK</td>
        <td width="15" scope="col">:</td>
        <td width="250" scope="col" class="thickBorder"><?php echo $data['FormCutiNIK']; ?></td>
        <td width="19" scope="col">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" scope="row">&nbsp;</td>
        <td>Jabatan</td>
        <td>:</td>
        <td class="thickBorder"><?php echo $data['NamaJabatan'] ?></td>
        <td>&nbsp;</td>
        <td>Tgl Masuk Kerja </td>
        <td>:</td>
        <td class="thickBorder"> <?php echo $TglMasuk; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" scope="row">&nbsp;</td>
        <td>Div / Dept / Unit</td>
        <td>:</td>
        <td class="thickBorder"><?php echo $data['cDivName'].'/ '.$data['cDeptName'].'/ '.$data['NamaUnit'] ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="900" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="22" height="25" scope="col">&nbsp;</td>
        <td colspan="5" scope="col"><div align="left">Dengan ini mengajukan permohonan untuk menjalani cuti  :</div></td>
        <td width="30" scope="col">
        	<table width="30" class=table1 border=0px cellpadding=0 cellspacing=0 frame=box>
          <tr>
            <td bgcolor="<?php echo $JenisCuti_BG1; ?>" scope="col"><div align="center"><?php echo $JenisCuti_NM1; ?></div></td>
          </tr>
        </table>        </td>
        <td width="110" scope="col">&nbsp;&nbsp;Tahunan tgl</td>
        <td colspan="3" class="thickBorder" scope="col">
        <?php 
		$cuti = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId='$_GET[id]' ORDER BY TglCuti ASC");					  
		  while ($ws = mysql_fetch_array($cuti)){
		  	$TglCuti = date('d-M-Y', strtotime($ws['TglCuti']));
			if($data[JenisCuti]==1 || $data[JenisCuti]==4){
		  		echo $TglCuti.', ';
				}
				
		  
		  }
		  echo '<b>('.$JmlCuti.' hari)</b>';
		  ?></td>
        <td width="18" scope="col">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" scope="row">&nbsp;</td>
        <td width="24"><table width="30" class="table1" border="0px" cellpadding="0" cellspacing="0" frame="box">
          <tr>
            <td scope="col">&nbsp;</td>
          </tr>
        </table></td>
        <td width="110">&nbsp;&nbsp;Sesuai PP tgl</td>
        <td width="134" class="thickBorder"> <div align="center"></div></td>
        <td width="32">s/d</td>
        <td width="151" class="thickBorder"><div align="center"></div></td>
        <td><table width="30" class=table1 border=0px cellpadding=0 cellspacing=0 frame=box>
          <tr>
            <td bgcolor="<?php echo $JenisCuti_BG2; ?>" scope="col"><div align="center"><?php echo $JenisCuti_NM2; ?></div></td>
          </tr>
        </table></td>
        <td>&nbsp;&nbsp;Khusus tgl</td>
        <td colspan="3" class="thickBorder">
        
        <?php 
		$cutik = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId='$_GET[id]' ORDER BY TglCuti ASC");					  
		  while ($wss = mysql_fetch_array($cutik)){
		  	$TglCuti = date('d-M-Y', strtotime($wss['TglCuti']));
			if($data[JenisCuti]==2){
		  		echo $TglCuti.', ';
				}
				
		  
		  }
		  ?>        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td colspan="2">Keperluan cuti</td>
        <td colspan="6" class="thickBorder">: <?php echo $data['Keperluan']; ?></td>
        <td width="33">&nbsp;</td>
        <td width="129">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td colspan="2">Alamat selama cuti</td>
        <td colspan="6" class="thickBorder">: <?php echo $data['Alamat']; ?></td>
        <td colspan="2" class="thickBorder">Telp: <?php echo $data['NoTelpon']; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td colspan="2">Petugas pengganti</td>
        <td colspan="6" class="thickBorder">: <?php echo $data['Pengganti']; ?></td>
        <td colspan="2">(ditentukan oleh atasan)</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" class="thickBorder"><div align="center">Tgl : <?php echo $CreatedTime ?></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="107">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="50" scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="24" scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" class="thickBorder"><div align="center"><?php echo $data['Nama'] ?></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="2" class="thickBorder" scope="row">&nbsp;</td>
        <td colspan="2" class="thickBorder"><div align="center">Karyawan</div></td>
        <td colspan="8" class="thickBorder">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="900" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19" height="25" scope="col">&nbsp;</td>
        <td width="24" scope="col">1.</td>
        <td width="229" scope="col">Masa berlaku cuti</td>
        <td width="26" scope="col">:</td>
        <td width="184" scope="col" class="thickBorder"> <div align="center"></div></td>
        <td width="32" scope="col"><div align="center">s/d</div></td>
        <td width="182" scope="col" class="thickBorder"><div align="center"></div></td>
        <td width="23" scope="col">=</td>
        <td width="83" scope="col">&nbsp;</td>
        <td width="98" scope="col">&nbsp;</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td>2.</td>
        <td>Hak Cuti tahun kerja</td>
        <td>:</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td><div align="center">s/d</div></td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>=</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td> Hari</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td>3.</td>
        <td>Sisa hak cuti tahun kerja</td>
        <td>:</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td><div align="center">s/d</div></td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>=</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>Hari</td>
      </tr>
      <tr>
        <td height="25" scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>=</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>Hari</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td>4.</td>
        <td>Cuti yang telah diambil</td>
        <td>:</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td ><div align="center">s/d</div></td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>=</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>Hari</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td>5.</td>
        <td>Cuti yang akan diambil </td>
        <td>:</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td><div align="center">s/d</div></td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>=</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>Hari</td>
      </tr>
      <tr>
        <td scope="row" height="25">&nbsp;</td>
        <td>6.</td>
        <td>Sisa hak cuti tahun kerja</td>
        <td>:</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td><div align="center">s/d</div></td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>=</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>Hari</td>
      </tr>
      <tr>
        <td height="32" scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3"><div align="right"><strong>Data hak cuti diisi oleh HRD</strong></div></td>
        <td><div align="center"><strong>:</strong></div></td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong>Persetujuan atasan  :</strong></td>
        <td><table width="30" class="table1" border="0px" cellpadding="0" cellspacing="0" frame="box">
          <tr>
            <td bgcolor="<?php echo $StatusForm_BG1; ?>" scope="col"><div align="center"><?php echo $StatusForm_NM1; ?></div></td>
          </tr>
        </table></td>
        <td>&nbsp;&nbsp;Menyetujui</td>
        <td><table width="30" class="table1" border="0px" cellpadding="0" cellspacing="0" frame="box">
          <tr>
            <td bgcolor="<?php echo $StatusForm_BG2; ?>" scope="col"><div align="center"><?php echo $StatusForm_NM2; ?></div></td>
          </tr>
        </table></td>
        <td>&nbsp;&nbsp;Tidak menyetujui</td>
        <td><table width="30" class="table1" border="0px" cellpadding="0" cellspacing="0" frame="box">
          <tr>
            <td scope="col">&nbsp;</td>
          </tr>
        </table></td>
        <td>&nbsp;&nbsp;Menunda</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="left">Alasan</div></td>
        <td><div align="center">:</div></td>
        <td colspan="6" class="thickBorder">&nbsp;</td>
        </tr>
      <tr>
        <td height="25" scope="row">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" scope="row">&nbsp;</td>
        <td>Tgl</td>
        <td class="thickBorder"><div align="center"><?php echo $Tgl1 ?></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Tgl</td>
        <td class="thickBorder"><div align="center"><?php echo $Tgl2 ?></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" scope="row">&nbsp;</td>
        <td colspan="2"><div align="center">Atasan langsung</div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><div align="center">Atasan tak langsung</div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="50" scope="row">&nbsp;</td>
        <td colspan="2" class="thickBorder"><div align="center"><strong><?php echo $Apv1 ?></strong></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" class="thickBorder"><div align="center"><strong><?php echo $Apv2 ?></strong></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" scope="row">&nbsp;</td>
        <td colspan="2"><div align="center">Minimal Kadep / GM</div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><div align="center">Minimal Kadep / GM</div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="5" colspan="10" scope="row" class="thickBorder">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="900" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="17" height="41" scope="col">&nbsp;</td>
        <td colspan="8" scope="col"><div align="left"><strong>Perubahan pengambilan cuti</strong> ( diisi apabila melakukan perubahan )</div></td>
        <td width="36" scope="col">&nbsp;</td>
      </tr>
      <tr>
        <td scope="row">&nbsp;</td>
        <td colspan="2">Tanggal mulai cuti</td>
        <td width="69"><div align="center">:</div></td>
        <td colspan="2" class="thickBorder"><div align="center"></div></td>
        <td width="68"><div align="center">s/d</div></td>
        <td colspan="2" class="thickBorder"><div align="center"></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row">&nbsp;</td>
        <td width="30">&nbsp;</td>
        <td width="193">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="33">&nbsp;</td>
        <td width="220">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="29">&nbsp;</td>
        <td width="205">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row">&nbsp;</td>
        <td>Tgl</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>&nbsp;</td>
        <td>Tgl</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>&nbsp;</td>
        <td>Tgl</td>
        <td class="thickBorder"><div align="center"></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><div align="center">Atasan langsung</div></td>
        <td>&nbsp;</td>
        <td colspan="2"><div align="center">Atasan tak langsung</div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="50" scope="row">&nbsp;</td>
        <td colspan="2" class="thickBorder"><div align="center"></div></td>
        <td>&nbsp;</td>
        <td colspan="2" class="thickBorder"><div align="center"></div></td>
        <td>&nbsp;</td>
        <td colspan="2" class="thickBorder"><div align="center"></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td scope="row">&nbsp;</td>
        <td colspan="2"><div align="center">Karyawan</div></td>
        <td>&nbsp;</td>
        <td colspan="2"><div align="center">Minimal Kadep / GM</div></td>
        <td>&nbsp;</td>
        <td colspan="2"><div align="center">Minimal Kadep / GM</div></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row" >&nbsp;</td>
  </tr>
</table>

</body>
</html>


