<?php
//session_start();
include "../../koneksi/koneksi.php";

//$nama_file = "namafile.doc";

$sql 	= "SELECT     *
FROM         tbl_trans LEFT JOIN
                      tbl_stock ON tbl_trans.itransStokId = tbl_stock.iStokID LEFT JOIN
                      tbl_rAM ON tbl_stock.iStokRAM = tbl_rAM.iRAMId LEFT JOIN
                      tbl_rental ON tbl_stock.iStokRental = tbl_rental.iRentalID LEFT JOIN
                      tbl_processor ON tbl_stock.iStokProc = tbl_processor.iProcessorId LEFT JOIN
                      tbl_hd ON tbl_stock.iStokHD = tbl_hd.iHDId LEFT JOIN
                      tbl_item ON tbl_stock.iStokItem = tbl_item.iItemID LEFT JOIN
                      tbl_dept ON tbl_trans.iTransDept = tbl_dept.iDeptID LEFT JOIN
                      tbl_type ON tbl_stock.iStokType = tbl_type.iTypeID LEFT JOIN 
					  tbl_div ON tbl_dept.iDeptDivID = tbl_div.iDivId 
					  LEFT JOIN tbl_company ON tbl_div.iDivCompany = tbl_company.iCompanyId
WHERE iTransId=$_GET[id]";
					
$tampil = mysql_query($sql);
$data	= mysql_fetch_array($tampil);

$string = $data['cTransCode'];
$string = preg_replace("/<img[^>]+\//i", "-", $string); 

$dTransOutDate = date('d-M-Y', strtotime($data['dTransOutDate']));
$hari = date('l', strtotime($data['dTransOutDate']));
if($hari=='Monday'){
	$hari_id ='Senin';
	}
	elseif ($hari=='Tuesday'){
	$hari_id ='Selasa';
	}
	elseif ($hari=='Wednesday'){
	$hari_id ='Rabu';
	}
	elseif ($hari=='Thursday'){
	$hari_id ='Kamis';
	}
	elseif ($hari=='Friday'){
	$hari_id ='Jumat';
	}
	elseif ($hari=='Saturday'){
	$hari_id ='Sabtu';
	}
	elseif ($hari=='Sunday'){
	$hari_id ='Minggu';
	}
	else{
	$hari_id ='';
	}

	if ($data['iStokProc'] !="" || !is_null($data['iStokProc'])){
		$Processor = 'Processor : '. $data['cProcessorName'];	
	}
	else {
		$Processor = '';
	}
	
	if ($data['cStokProcSpeed'] !="" || !is_null($data['cStokProcSpeed'])){
		$Speed = $data['cStokProcSpeed'];	
	}
	else {
		$Speed = '';
	}
	
	if ($data['iStokRAM'] !="" || !is_null($data['iStokRAM'])){
		$RAM = 'Memory : '.$data['cRAMName'];	
	}
	else {
		$RAM = '';
	}
	
	if ($data['iStokHD'] !="" || !is_null($data['iStokHD'])){
		$Harddisk = 'Harddisk : '.$data['iHDCapacity'];	
	}
	else {
		$Harddisk = '';
	}
	


$nama_file = $string.'.doc';

header("Content-Type: application/vnd.ms-word");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-disposition: attachment; filename=".$nama_file);


//echo $content;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type=text/css>

@page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
  /* ... the rest of the rules ... */
}


body {
        height: 842px;
        width: 595px;
        /* to centre page on screen*/
        margin-left: auto;
        margin-right: auto;
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

td.thickBorder{
	border-collapse:collapse; 
	border-bottom:none;
	border-left:none;
	}

td.thick{ 
	border: solid white 0px;
	}
	
td.thickBorderRight{ 
	border-right: solid white 1px;
	border-bottom: solid white 1px;
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
table {
	font-size: 12px;
	border-width: 1px;
	border-collapse: collapse;
}
.style16 {
	font-size: 12px;
	}
	
	/* Bagian untuk tabel */	
table.tftable {
	font-size:12px;
	color:#333333;
	border-width: 1px;
	border-color:#000000;
	border-collapse: collapse;
	border:none;
	border-left: none;
    border-right: none;

}

table.tftable th {
	font-size:12px;
	background-color:#CCCCCC;
	border-width: 1px;
	padding: 3px;
	border-style: solid;
	border-color:#000000;
	text-align:center;
	border-collapse: collapse;
}
table.tftable tr {
	background-color:#FFFFFF;
}
table.tftable td {
	font-size:12px;
	border-width: 1px;
	padding: 2px;
	border-style: solid;
	border-color:#000000;
	background-color:#FFFFFF;
	


}
noBorder {
	border:none;
	border-bottom:none;
	border-top:none;
	
}
.style17 {font-size: 12px}

table.bottomBorder { 
	border-collapse:collapse;
	border-style:dotted;
	
	border-left:none;
	border-right:none;
	}
table.bottomBorder td, table.bottomBorder th { 
	
	border-style:dotted;
	border-left:none;
	border-right:none;
	 }

table.headerme { 
	border-collapse:collapse;
	border:none;
	border-width:0px;
	}
	
</style>
   

 
<title>Print FPB</title>
</head>

<body>
<table  class="tftable" width="720" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" frame="box" border="0">
  <tr>
    <td height="" colspan="5" scope="col"><div align="center"><img src="http://<?php echo $_SERVER['SERVER_NAME']?>/i-MAM2/child/images/<?php echo $data['tCompanyLogo']; ?>"  /></div></td>
  </tr>
  <tr>
    <td colspan="4" scope="col"><div align="left">Nomor: <?php echo $data['cTransCode'] ?></div></td>
    <td width="82" scope="col"><div align="left">Tgl: <?php echo $data['dTransOutDate'] ?></div></td>
  </tr>
  <tr>
    <td height="28" colspan="5" scope="row">
    <table class="headerme" width="720" height="" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="720" height="26"><div align="center"><strong>FORM SEWA ATAU ALOKASI PEMBEBANAN BIAYA HARDWARE</strong></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="34" height="20" scope="row"><div align="center"><strong>No.</strong></div></td>
    <td colspan="3"><div align="center"><strong>Nama &amp; Spesifikasi Hardware</strong></div></td>
    <td><div align="center"><strong>Jumlah</strong></div></td>
  </tr>
  <tr style="border-collapse:collapse">
    <td rowspan="8" valign="top" scope="row"><div align="center">1</div></td>
    <td width="255" span="thickBorder">Nama / Divisi</td>
    <td width="15"><div align="center">:</div></td>
    <td width="348"><?php echo $data['cTransUser'].' / '.$data['cDeptName'] ?></td>
    <td rowspan="8" valign="top"><div align="center">1</div></td>
  </tr>
  <tr>
    <td valign="top" class="noBorder">Peralatan</td>
    <td><div align="center">:</div></td>
    <td valign="top">
	<?php echo $data['cTypeName'].'  '.$data['cItemName'] ?></p>
	<?php echo $Processor.' '.$Speed ?></p>
    <?php echo $RAM ?></p>
    <?php echo $Harddisk ?></p>
    </td>
  </tr>
  <tr>
    <td>Aksesoris</td>
    <td><div align="center">:</div></td>
    <td>
    
    <?php
	// Aksesoris yang ada di Assets
	$sql_aks		= "SELECT * FROM tbl_accessoriesdetail LEFT JOIN
                      tbl_accessories ON tbl_accessoriesdetail.iAccessoriesId = tbl_accessories.iAccessoriesId
					  WHERE iStokID=$data[iStokID]";
					   	
	$tampil_aks 	= mysql_query($sql_aks);
	$total_aks 	= mysql_num_rows($tampil_aks);

	if ($total_aks > 0){
	echo '* Main : ';
	while($data_aks = mysql_fetch_array($tampil_aks)){	
		echo $data_aks['cAccessoriesName'].' , ';
	$no++;
	}
	
	}
	?>    
    </p>
    <?php
    // Aksesoris lain-lain
	$sql_aks2		= "SELECT * FROM tbl_transdetail LEFT JOIN
                      tbl_accessories ON tbl_transdetail.iTDAccessoriesId = tbl_accessories.iAccessoriesId
					  WHERE iTDTransId=$data[iTransId]"; 	
	$tampil_aks2 	= mysql_query($sql_aks2);
	$total_aks2 	= mysql_num_rows($tampil_aks2);

	if ($total_aks2 > 0){
	echo '* Lain-lain : ';
	while($data_aks2 = mysql_fetch_array($tampil_aks2)){	
		echo $data_aks2['cAccessoriesName'].' , ';
	$no++;
	}
	
	}
	?>
    
    
    </td>
  </tr>
  <tr>
    <td>Asset Number /Serial number</td>
    <td><div align="center">:</div></td>
    <td>A/N: <?php echo $data['cStokNewTag'].' , S/N: '. $data['cStokSN'] ?></td>
  </tr>
  <tr>
    <td>Kondisi Peralatan</td>
    <td><div align="center">:</div></td>
    <td valign="top" span="thickBorderRight">Baik<br/>
      *Peralatan dilabel  perusahaan, label tidak boleh di cabut atau rusak.<br />
        Jika  terjadi kerusakan atau kehilangan atas peralatan yang disebabkan kelalaian menjadi tanggung jawab peminjam  pribadi.      
    </td>
  </tr>
  <tr>
    <td><span class="style16">Aplikasi yang terpasang</span></td>
    <td><div align="center"><span class="style16">:</span></div></td>
    <td><p>
    
    <?php
	$sql_soft		= "SELECT * FROM tbl_softwaredetail LEFT JOIN
                      tbl_software ON tbl_softwaredetail.iSoftwareId = tbl_software.iSoftwareId
					  WHERE iStokID=$data[iStokID]"; 	
	$tampil_soft 	= mysql_query($sql_soft);
	$total_soft 	= mysql_num_rows($tampil_soft);

	if ($total_soft > 0){
	//echo '<ul style="list-style-type:square">';
	while($data_soft = mysql_fetch_array($tampil_soft)){	
		echo $data_soft['cSoftwareName'].'<br />';
	$no++;
	}
	//echo '</ul>';
	}
	?>
    
  *Perusahaan hanya  bertanggung jawab atas aplikasi yang terpasang diatas, diluar  aplikasi diatas menjadi tanggung jawab peminjam pribadi.</td>
  </tr>
  <tr>
    <td><span class="style16">Keterangan Keperluan</span></td>
    <td><div align="center"><span class="style16">:</span></div></td>
    <td><span class="style16"><?php echo $data['tTransRemark'] ?></span></td>
  </tr>
  <tr>
    <td><span class="style16">Lokasi</span></td>
    <td><div align="center"><span class="style16">:</span></div></td>
    <td><span class="style16">Jakarta</span></td>
  </tr>
  <tr>
    <td colspan="2" scope="row"><div align="left" class="style16">Barang yang dipinjam ini akan digunakan untuk</div></td>
    <td><div align="center"><span class="style16">:</span></div></td>
    <td colspan="2"><span class="style16">Operasional Kerja</span></td>
  </tr>
  <tr>
    <td colspan="2" scope="row"><div align="left" class="style16">Project</div></td>
    <td><div align="center"><span class="style16">:</span></div></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" scope="row"><div align="left" class="style16">Pada hari</div></td>
    <td><div align="center"><span class="style16">:</span></div></td>
    <td colspan="2"><span class="style16"><?php echo $hari_id. ', Tanggal '. $dTransOutDate ?></span></td>
  </tr>
  <tr>
    <td colspan="2" scope="row"><div align="left" class="style16">Dan akan dikembalikan pada tanggal</div></td>
    <td><div align="center"><span class="style16">:</span></div></td>
    <td colspan="2"><span class="style16">...............................................</span></td>
  </tr>
  <tr>
    <td colspan="5" scope="row">
    <table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" frame="border">
      <tr>
        <td width="180" scope="col"><div align="center" class="style1">Diajukan Oleh,</div></td>
        <td width="180" scope="col"><div align="center"><span class="style1">Disetujui Oleh,</span></div></td>
        <td colspan="2" scope="col"><div align="center"><span class="style1">Verifikasi Oleh,</span></div></td>
        </tr>
      <tr>
        <td scope="row"><div align="center" class="style1">Pemohon</div></td>
        <td><div align="center"><span class="style1">Kadep / Kadiv Pemohon</span></div></td>
        <td width="180"><div align="center" class="style1">MIS</div></td>
        <td width="180"><div align="center" class="style1">Kadep MIS</div></td>
      </tr>
      <tr>
        <td height="50" valign="bottom" scope="row"><div align="center" class="style1">(....................................)</div></td>
        <td valign="bottom"><div align="center" class="style1">(.....................................)</div></td>
        <td valign="bottom"><div align="center" class="style1">(.....................................)</div></td>
        <td valign="bottom"><div align="center" class="style1">(......................................)</div></td>
      </tr>
      <tr>
        <td><div align="left">Tgl:</div></td>
        <td><span class="style1">Tgl:</span></td>
        <td><span class="style1">Tgl:</span></td>
        <td><span class="style1">Tgl:</span></td>
      </tr>
    </table></td>
  </tr>
  
    <td colspan="5">
   	  <table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" frame="border">
      <tr>
        <td colspan="4" scope="col"><div align="center"><strong>PENYERAHAN  HARDWARE</strong></div></td>
        </tr>
      <tr>
        <td width="180" scope="row"><div align="center" class="style16">Diserahkan Oleh,</div></td>
        <td width="180"><div align="center">Diterima Oleh,</div></td>
        <td width="360" colspan="2">Kondisi fisik Hardware:</td>
        </tr>
      <tr>
        <td width="180" scope="row"><div align="center">MIS</div></td>
        <td width="180"><div align="center">Pemohon</div></td>
        <td colspan="2" rowspan="3">
        
        <table class="bottomBorder" width="350" height="80" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>        </td>
        </tr>
      <tr>
        <td height="50" valign="bottom" scope="row"><div align="center">(.................................)</div></td>
        <td valign="bottom"><div align="center">(...................................)</div></td>
        </tr>
      <tr>
        <td>Tgl:</td>
        <td>Tgl:</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    
    <td colspan="5">
    <table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" frame="border">
      <tr>
        <td colspan="4" scope="col"><div align="center"><strong>PENGEMBALIAN  HARDWARE</strong></div></td>
        </tr>
      <tr>
        <td width="180" scope="row"><div align="center">Dikembalikan Oleh,</div></td>
        <td width="180"><div align="center">Diterima Oleh,</div></td>
        <td width="360" colspan="2"><div align="left">Kondisi fisik Hardware:</div></td>
        </tr>
      <tr>
        <td scope="row"><div align="center">Pemohon</div></td>
        <td><div align="center">MIS</div></td>
        <td colspan="2" rowspan="3">
          
            <div align="left">
              <table class="bottomBorder" width="350" height="80" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <td scope="col">&nbsp;</td>
          </tr>
          <tr>
            <td scope="row">&nbsp;</td>
          </tr>
          <tr>
            <td scope="row">&nbsp;</td>
          </tr>
          <tr>
            <td scope="row">&nbsp;</td>
                </table>
          </div></td>
        </tr>
      <tr>
        <td height="50" valign="bottom" scope="row"><div align="center">(.............................)</div></td>
        <td valign="bottom"><div align="center">(.....................................)</div></td>
        </tr>
      <tr>
        <td>Tgl:</td>
        <td>Tgl:</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" scope="row"><div align="center" class="style17">Lampiran 10.1</div></td>
  </tr>
</table>




</body>
</html>

