<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$asset = new CMS_Asset();
foreach($css_files as $file){
    $asset->add_css($file);
}
echo $asset->compile_css();

foreach($js_files as $file){
    $asset->add_js($file);
}
echo $asset->compile_js();

// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}
//echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);
$hostName = '172.17.0.59';
$userName = 'sa';
$passWord = '$mis@admin';

if($company ==2){
	$dataBase = 'askes_sis';
}else{
	$dataBase = 'askes';
}

mssql_connect($hostName, $userName, $passWord);
mssql_select_db($dataBase);

echo"
    <table>
  <tr>
    <td><select class='form-control' id=select onchange=goToPage('select')>
	<option value='' disabled SELECTED>Select Periode</option>";

    $sql = mssql_query("SELECT * FROM tblPeriode WHERE Aktif='Y'");						  
	while ($data = mssql_fetch_array($sql)){
		$Periode1 = date('d M Y', strtotime($data['Periode1']));
		$Periode2 = date('d M Y', strtotime($data['Periode2']));

	    if($this->input->get('p')==$data['PeriodeId']){  
	      echo "<option value='https://".$_SERVER['SERVER_NAME']."/hris2/kehadiran/frmSejarahRawatJalan/index/?act=default&p=$data[PeriodeId]' SELECTED>".$Periode1." - ".$Periode2."</option>";
	    }
	    else {
	      echo "<option value='https://".$_SERVER['SERVER_NAME']."/hris2/kehadiran/frmSejarahRawatJalan/index/?act=default&p=$data[PeriodeId]'>".$Periode1." - ".$Periode2."</option>";
	    }

    }

    

		 
echo"</select></table>&nbsp;&nbsp;";

if (!is_null($this->input->get('act'))){

switch($_GET['act']){

default:

$NIK       = $session_nik;
$PeriodeId = $this->input->get('p');


$jmlManfaat = mssql_num_rows(mssql_query("SELECT * FROM tblManfaat WHERE PeriodeId='$PeriodeId' AND ManfaatId != '0'"));
$jmlManfaatT = mssql_num_rows(mssql_query("SELECT * FROM tblManfaat WHERE PeriodeId='$PeriodeId' AND TypeManfaat !='K'"));


$ws = mssql_query("SELECT tblHakAsuransi.NIK AS NIK,tblHakAsuransi.MemberId AS MemberId,tblHakAsuransi.PeriodeId AS PeriodeId,tblProfilePeserta.Nama AS Nama,
tblProfilePeserta.Aktif AS Aktif,tblProfilePeserta.StatusId AS StatusId,tblProfilePeserta.LevelId AS LevelId,tblProfilePeserta.CompanyId AS CompanyId
FROM         tblHakAsuransi INNER JOIN
                      tblProfilePeserta ON tblHakAsuransi.NIK = tblProfilePeserta.NIK AND tblHakAsuransi.MemberId = tblProfilePeserta.MemberId
					  WHERE tblHakAsuransi.NIK='$session_nik' AND tblHakAsuransi.PeriodeId='$PeriodeId'");

$JumlahData = mssql_num_rows($ws);					  


$Periode = mssql_fetch_array(mssql_query("SELECT * FROM tblPeriode WHERE PeriodeId='$PeriodeId'"));
$Periode1 = date('d M Y', strtotime($Periode['Periode1']));
$Periode2 = date('d M Y', strtotime($Periode['Periode2']));

$so = 1;

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $time), 4);

	
echo "<h4>Sejarah Klaim Asuransi Kesehatan $session_nik - Total Record : $JumlahData</h4></p>";
//echo"<table width=100%><hr width=100%></table>";	
echo"<table style=width:100%;>
	<tr>
		<td>
<table style=width:100%; id='tfhover'>
  
</table></td></tr><tr><td>
			
<div style='width:100%;overflow:auto;'>  
<table style=width:100%; class=tabborder id='tfhover'>";
while ($dada = mssql_fetch_array($ws)){

$mem = $dada['MemberId'];
$tampil = mssql_query("SELECT * FROM tblHakAsuransi INNER JOIN tblManfaat ON tblHakAsuransi.PeriodeId = tblManfaat.PeriodeId
		WHERE NIK=$dada[NIK] AND MemberId='$mem' AND tblHakAsuransi.PeriodeId='$PeriodeId'");
		
	$sqr = mssql_query("SELECT * FROM tblFormKlaim WHERE NIK=$dada[NIK] AND MemberId='$mem' AND PeriodeId='$PeriodeId'");	
	$cari = mssql_num_rows($sqr);
	
	$header = mssql_query("SELECT * FROM tblManfaat WHERE PeriodeId='$PeriodeId'");
	$jmlManfaat2 = $jmlManfaat * 2;	
	$NamaPaket =	mssql_fetch_array(mssql_query("SELECT * FROM tblLevel WHERE PeriodeId='$PeriodeId' AND LevelId=$dada[LevelId]"));
	
	echo "<h4>$so . NIK=$dada[NIK] [<b><a href=?act=detail&p=$PeriodeId&m=$mem>$dada[Nama]</a></b>] $NamaPaket[PaketAsuransiName]</h4>";
	echo"<table id='tfhover' class='tftableon' width='100%'' border='1'>		
		<tr>		
		<th rowspan='3' width='6%'><div align=center>Tgl Berobat</th>
		<th rowspan='3' width='6%'><div align=center>Tgl Input</th>
		<th rowspan='3' width='6%'><div align=center>Tgl Bayar</th>
		<th colspan=$jmlManfaat2>Periode $Periode1 - $Periode2</th></tr>";
		
	$no=1;
		while($data = mssql_fetch_array($header)){
		echo"<th colspan=2>$data[NamaManfaat] [$data[TypeManfaat]]</th>";		
		$no++;
			}
		echo"</tr>";
		
	echo"<tr>";
		
		for($i = 1; $i <= $jmlManfaat; $i++){
			echo"<th width=5%>Klaim</th>
			<th width=5%>Bayar</th>";
			}
		echo"</tr>";
		
	$i=1;
	$mks = mssql_query("SELECT tblFormKlaimTrans.FormKlaimId AS FormKlaimId
FROM         tblFormKlaimTrans INNER JOIN
                      tblFormKlaim ON tblFormKlaimTrans.NIK = tblFormKlaim.NIK AND tblFormKlaimTrans.MemberId = tblFormKlaim.MemberId AND 
                      tblFormKlaimTrans.FormKlaimId = tblFormKlaim.FormKlaimId AND tblFormKlaimTrans.PeriodeId = tblFormKlaim.PeriodeId
					  WHERE tblFormKlaimTrans.NIK=$dada[NIK] AND tblFormKlaimTrans.MemberId='$mem' AND tblFormKlaimTrans.PeriodeId='$PeriodeId' AND tblFormKlaimTrans.StatusForm='B'
					  GROUP BY tblFormKlaimTrans.FormKlaimId");
	while ($lada = mssql_fetch_array($mks)){
	
	$sql = mssql_query("SELECT * FROM tblFormKlaimTrans
WHERE NIK='$dada[NIK]' AND MemberId='$mem' AND PeriodeId='$PeriodeId' AND FormKlaimId='$lada[FormKlaimId]' AND StatusForm='B'");
	
	$query = mssql_fetch_array($sql);
	$TglBerobat = date('d M Y', strtotime($query['TglBerobat']));
	$TglProses = date('d M Y', strtotime($query['TglProses']));
	$TglBayar = date('d M Y', strtotime($query['TglPembayaran']));
	
		echo "<tr>		
		<td><div align='center'>$TglBerobat</td>
		<td><div align='center'>$TglProses</td>
		<td><div align='center'>$TglBayar</td>";
		
		$n=1;
		
		while ($n <= $jmlManfaat){
		$add= mssql_fetch_array(mssql_query("SELECT SUM(tblFormKlaim.Bayar) AS Bayar,SUM(tblFormKlaim.BiayaKlaim) AS BiayaKlaim
FROM         tblFormKlaimTrans INNER JOIN
                      tblFormKlaim ON tblFormKlaimTrans.NIK = tblFormKlaim.NIK AND tblFormKlaimTrans.MemberId = tblFormKlaim.MemberId AND 
                      tblFormKlaimTrans.FormKlaimId = tblFormKlaim.FormKlaimId AND tblFormKlaimTrans.PeriodeId = tblFormKlaim.PeriodeId
					  WHERE tblFormKlaimTrans.NIK=$dada[NIK] AND tblFormKlaimTrans.MemberId='$mem' AND tblFormKlaimTrans.PeriodeId='$PeriodeId' AND tblFormKlaimTrans.FormKlaimId='$lada[FormKlaimId]' AND tblFormKlaim.ManfaatId='$n'"));		
		$Bayar = number_format($add['Bayar'], 0);
		$Klaim = number_format($add['BiayaKlaim'], 0);
		
		echo"<td><div align='right'>$Klaim</td>";
		echo"<td><div align='right'>$Bayar</td>";
		$n++;
		}		
	$i++;			
	}	

		echo"<tr><th colspan=3><div align='right'>Total</th>";
		
		
		$m = 1;
				
while ($m <= $jmlManfaat){		
		$tot = mssql_fetch_array(mssql_query("SELECT SUM(tblFormKlaim.Bayar) AS Bayar,SUM(tblFormKlaim.BiayaKlaim) AS BiayaKlaim
FROM         tblFormKlaimTrans INNER JOIN
                      tblFormKlaim ON tblFormKlaimTrans.NIK = tblFormKlaim.NIK AND tblFormKlaimTrans.MemberId = tblFormKlaim.MemberId AND 
                      tblFormKlaimTrans.FormKlaimId = tblFormKlaim.FormKlaimId AND tblFormKlaimTrans.PeriodeId = tblFormKlaim.PeriodeId
					  WHERE tblFormKlaimTrans.NIK='$dada[NIK]' AND tblFormKlaimTrans.MemberId='$mem' AND tblFormKlaimTrans.PeriodeId='$PeriodeId' AND tblFormKlaim.ManfaatId='$m' AND tblFormKlaimTrans.StatusForm='B'"));
		$TotalBayar = number_format($tot['Bayar'], 0);
		$TotalKlaim = number_format($tot['BiayaKlaim'], 0);
		echo "
			<th><div align='right'>$TotalKlaim</td>
			<th><div align='right'>$TotalBayar</td>";	
			$m++;
			}
					

echo"<tr><th colspan=3><div align='right'>Sisa Plafon</th>";

$Array3 = mssql_fetch_array(mssql_query("SELECT     *
FROM         tblHakAsuransi INNER JOIN
                      tblLevel ON tblHakAsuransi.PeriodeId = tblLevel.PeriodeId AND tblHakAsuransi.LevelId = tblLevel.LevelId
WHERE NIK=$dada[NIK] AND MemberId=1 AND tblHakAsuransi.PeriodeId='$PeriodeId'"));

$Array4 = mssql_fetch_array(mssql_query("SELECT     sum(BiayaManfaat) AS BiayaManfaat
FROM         tblHakAsuransi INNER JOIN
                      tblPaketAsuransi ON tblHakAsuransi.LevelId = tblPaketAsuransi.LevelId AND tblHakAsuransi.PeriodeId = tblPaketAsuransi.PeriodeId INNER JOIN
                      tblManfaat ON tblPaketAsuransi.ManfaatId = tblManfaat.ManfaatId AND tblPaketAsuransi.PeriodeId = tblManfaat.PeriodeId
WHERE NIK=$dada[NIK] AND MemberId=1 AND tblHakAsuransi.PeriodeId='$PeriodeId' AND tblManfaat.TypeManfaat='T'"));

$SisaTahunan = $Array3['MaxSantunan'] - $Array4['BiayaManfaat'];


$Array5 = mssql_fetch_array(mssql_query("SELECT     sum(Bayar) AS Bayar
FROM         tblHakAsuransi INNER JOIN
                      tblFormKlaimTrans ON tblHakAsuransi.NIK = tblFormKlaimTrans.NIK AND tblHakAsuransi.MemberId = tblFormKlaimTrans.MemberId AND 
                      tblHakAsuransi.PeriodeId = tblFormKlaimTrans.PeriodeId INNER JOIN
                      tblFormKlaim ON tblFormKlaimTrans.NIK = tblFormKlaim.NIK AND tblFormKlaimTrans.MemberId = tblFormKlaim.MemberId AND 
                      tblFormKlaimTrans.FormKlaimId = tblFormKlaim.FormKlaimId INNER JOIN
                      tblManfaat ON tblFormKlaim.ManfaatId = tblManfaat.ManfaatId AND tblFormKlaim.PeriodeId = tblManfaat.PeriodeId
WHERE tblHakAsuransi.NIK=$dada[NIK] AND tblHakAsuransi.MemberId='$mem' AND tblHakAsuransi.PeriodeId='$PeriodeId' AND tblManfaat.TypeManfaat='K' AND tblFormKlaimTrans.StatusForm='B'"));
	

$rr = number_format($SisaTahunan - $Array5['Bayar'],0);	
			echo "
			<th colspan=8><div align='center'>$rr</td>";

$t = 5;
while ($t <= 8){
$sql1 = mssql_query("SELECT SUM(tblFormKlaim.Bayar) AS Bayar,tblHakAsuransi.NIK AS NIK,tblHakAsuransi.MemberId As MemberId,tblFormKlaim.ManfaatId AS ManfaatId
FROM         tblHakAsuransi INNER JOIN
                      tblFormKlaimTrans ON tblHakAsuransi.NIK = tblFormKlaimTrans.NIK AND tblHakAsuransi.MemberId = tblFormKlaimTrans.MemberId AND 
                      tblHakAsuransi.PeriodeId = tblFormKlaimTrans.PeriodeId INNER JOIN
                      tblFormKlaim ON tblFormKlaimTrans.NIK = tblFormKlaim.NIK AND tblFormKlaimTrans.MemberId = tblFormKlaim.MemberId AND 
                      tblFormKlaimTrans.FormKlaimId = tblFormKlaim.FormKlaimId INNER JOIN
                      tblProfilePeserta ON tblHakAsuransi.NIK = tblProfilePeserta.NIK AND tblHakAsuransi.MemberId = tblProfilePeserta.MemberId
WHERE tblHakAsuransi.NIK=$dada[NIK] AND tblHakAsuransi.MemberId='$mem' AND tblHakAsuransi.PeriodeId='$PeriodeId' AND tblFormKlaim.ManfaatId='$t' AND tblFormKlaimTrans.StatusForm='B'
GROUP BY tblHakAsuransi.NIK,tblHakAsuransi.MemberId,tblFormKlaim.ManfaatId");

$sql2 = mssql_query("SELECT     *
FROM         tblHakAsuransi INNER JOIN
                      tblPaketAsuransi ON tblHakAsuransi.PeriodeId = tblPaketAsuransi.PeriodeId AND tblHakAsuransi.LevelId = tblPaketAsuransi.LevelId
WHERE NIK=$dada[NIK] AND MemberId='$mem' AND tblHakAsuransi.PeriodeId='$PeriodeId' AND ManfaatId='$t'");
 
$Array1 = mssql_fetch_array($sql1);
$Array2 = mssql_fetch_array($sql2);
$sisa = number_format($Array2['BiayaManfaat'] - $Array1['Bayar'], 0);

			echo "<th colspan=2><div align='right'>$sisa</td>";	
			$t++;
			}			
$mem++;
echo "</table>";
//echo"&nbsp;";

$so++;

}

break;


case "detail":


	
	$sql=mssql_query("SELECT * FROM tblFormKlaimTrans WHERE NIK=$session_nik AND MemberId=$_GET[m] AND PeriodeId=$_GET[p] AND StatusForm='B'");
	$profile=mssql_fetch_array(mssql_query("SELECT * FROM tblProfilePeserta INNER JOIN tblStatusMember ON tblProfilePeserta.StatusId = tblStatusMember.StatusId
			WHERE NIK=$session_nik AND MemberId=$_GET[m]"));

	echo "<h4>Detail Sejarah Pembayaran Klaim Asuransi <b>$profile[NIK] $profile[Nama] [$profile[NamaStatus]]</b></h4>";
/*	
	echo"<a href='?act=default&p=$_GET[p]' class='button tooltip-attr' title='Kembali'><img src='https://apps.unias.com/hris2/images/back.png'></a>&nbsp;&nbsp;";
	echo"<a href='#' onClick=window.open('module/mod_sejarah/Send2html2.php','Ratting','width=650,height=600,scrollbars=1,left=0,top=0,toolbar=0,status=0,') class='button tooltip-attr' title='print'><img src='https://apps.unias.com/hris2/images/print2.png'></a>&nbsp;&nbsp;";	

	if (is_null($profile['Email']) || $profile['Email'] ==" "){		
		echo"<a href='#' class='button tooltip-attr' title='Tidak bisa kirim email karena tidak punya akun e-mail'><img src='https://apps.unias.com/hris2/images/email25x25NoNo.png'></a><br/>&nbsp;&nbsp;&nbsp;";
	}else {
		echo"<a href='module/mod_sejarah/Send2Email.php' class='button tooltip-attr' title='kirim email ke [$profile[Email]]'><img src='https://apps.unias.com/hris2/images/email25x25.png'></a><br/>&nbsp;&nbsp;&nbsp;";
	}

*/





$no=1;

while ($data=mssql_fetch_array($sql)){

$TglBerobat = date('d M Y', strtotime($data['TglBerobat']));
$TglProses = date('d M Y', strtotime($data['TglProses']));
if ($data['TglPembayaran'] == NULL){
$TglPembayaran='';
}
else {
$TglPembayaran = date('d M Y', strtotime($data['TglPembayaran']));
}
	echo "<table id='tfhover' class='tftableondetail' style='border-style: solid;border-width:1px;border-color:#999999;' width='100%'>	
		<tr>		
		<th colspan=5><div align='left'>[$data[FormKlaimId]] Nama/NIK/ : $profile[Nama] / $profile[NIK].$_GET[m] [$profile[NamaStatus]]</th>		
		<th><div align='right'>Tgl Berobat: $TglBerobat / Tgl Bayar: $TglPembayaran</th></tr>
		<tr>
		<th width='5%'>No</th>
		<th width='20%'>Manfaat</th>
		<th width='12%'>Klaim (Rp)</th>
		<th width='12%'>Bayar (Rp)</th>
		<th width='12%'>Sisa Plafon (Rp)</th>
		<th>Keterangan</th>
		</tr>";
	$konten=mssql_query("SELECT * FROM tblManfaat WHERE PeriodeId=$_GET[p]");
$i=1;
while($manf = mssql_fetch_array($konten)){
		echo"<tr><td><div align='center'>$manf[ManfaatId]</td>";
		echo"<td><div align='left'>$manf[NamaManfaat] [$manf[TypeManfaat]]</td>";

	$detail=mssql_fetch_array(mssql_query("SELECT     *
FROM         tblHakAsuransi INNER JOIN
                      tblFormKlaimTrans ON tblHakAsuransi.NIK = tblFormKlaimTrans.NIK AND tblHakAsuransi.MemberId = tblFormKlaimTrans.MemberId AND 
                      tblHakAsuransi.PeriodeId = tblFormKlaimTrans.PeriodeId INNER JOIN
                      tblFormKlaim ON tblFormKlaimTrans.NIK = tblFormKlaim.NIK AND tblFormKlaimTrans.MemberId = tblFormKlaim.MemberId AND 
                      tblFormKlaimTrans.FormKlaimId = tblFormKlaim.FormKlaimId AND tblFormKlaimTrans.PeriodeId = tblFormKlaim.PeriodeId
WHERE tblHakAsuransi.NIK=$data[NIK] AND tblHakAsuransi.MemberId=$data[MemberId] AND tblHakAsuransi.PeriodeId=$data[PeriodeId] AND tblFormKlaimTrans.FormKlaimId=$data[FormKlaimId] AND tblFormKlaim.ManfaatId = $manf[ManfaatId]"));
$BiayaKlaim = number_format($detail['BiayaKlaim'], 0);
$Bayar = number_format($detail['Bayar'], 0);

//----------------------------Hitung biaya kunjungan---------------------------------------
$Array3 = mssql_fetch_array(mssql_query("SELECT     *
FROM         tblHakAsuransi INNER JOIN
                      tblLevel ON tblHakAsuransi.PeriodeId = tblLevel.PeriodeId AND tblHakAsuransi.LevelId = tblLevel.LevelId
WHERE NIK=$data[NIK] AND MemberId=1 AND tblHakAsuransi.PeriodeId='$data[PeriodeId]'"));

$Array4 = mssql_fetch_array(mssql_query("SELECT     sum(BiayaManfaat) AS BiayaManfaat
FROM         tblHakAsuransi INNER JOIN
                      tblPaketAsuransi ON tblHakAsuransi.LevelId = tblPaketAsuransi.LevelId AND tblHakAsuransi.PeriodeId = tblPaketAsuransi.PeriodeId INNER JOIN
                      tblManfaat ON tblPaketAsuransi.ManfaatId = tblManfaat.ManfaatId AND tblPaketAsuransi.PeriodeId = tblManfaat.PeriodeId
WHERE NIK=$data[NIK] AND MemberId=1 AND tblHakAsuransi.PeriodeId='$data[PeriodeId]' AND tblManfaat.TypeManfaat='T'"));

$SisaTahunan=$Array3['MaxSantunan'] - $Array4['BiayaManfaat'];

$Array5 = mssql_fetch_array(mssql_query("SELECT     sum(Bayar) AS Bayar
FROM         tblHakAsuransi INNER JOIN
                      tblFormKlaimTrans ON tblHakAsuransi.NIK = tblFormKlaimTrans.NIK AND tblHakAsuransi.MemberId = tblFormKlaimTrans.MemberId AND 
                      tblHakAsuransi.PeriodeId = tblFormKlaimTrans.PeriodeId INNER JOIN
                      tblFormKlaim ON tblFormKlaimTrans.NIK = tblFormKlaim.NIK AND tblFormKlaimTrans.MemberId = tblFormKlaim.MemberId AND 
                      tblFormKlaimTrans.FormKlaimId = tblFormKlaim.FormKlaimId INNER JOIN
                      tblManfaat ON tblFormKlaim.ManfaatId = tblManfaat.ManfaatId AND tblFormKlaim.PeriodeId = tblManfaat.PeriodeId
WHERE tblHakAsuransi.NIK=$data[NIK] AND tblHakAsuransi.MemberId='$data[MemberId]' AND tblHakAsuransi.PeriodeId='$data[PeriodeId]' AND tblManfaat.TypeManfaat='K' AND tblFormKlaimTrans.StatusForm='B' AND tblFormKlaimTrans.FormKlaimId <=$data[FormKlaimId]"));

$rr=number_format($SisaTahunan - $Array5['Bayar'],0);

$sql1=mssql_query("SELECT SUM(tblFormKlaim.Bayar) AS Bayar,tblHakAsuransi.NIK AS NIK,tblHakAsuransi.MemberId As MemberId,tblFormKlaim.ManfaatId AS ManfaatId
FROM         tblHakAsuransi INNER JOIN
                      tblFormKlaimTrans ON tblHakAsuransi.NIK = tblFormKlaimTrans.NIK AND tblHakAsuransi.MemberId = tblFormKlaimTrans.MemberId AND 
                      tblHakAsuransi.PeriodeId = tblFormKlaimTrans.PeriodeId INNER JOIN
                      tblFormKlaim ON tblFormKlaimTrans.NIK = tblFormKlaim.NIK AND tblFormKlaimTrans.MemberId = tblFormKlaim.MemberId AND 
                      tblFormKlaimTrans.FormKlaimId = tblFormKlaim.FormKlaimId INNER JOIN
                      tblProfilePeserta ON tblHakAsuransi.NIK = tblProfilePeserta.NIK AND tblHakAsuransi.MemberId = tblProfilePeserta.MemberId
WHERE tblHakAsuransi.NIK=$data[NIK] AND tblHakAsuransi.MemberId='$data[MemberId]' AND tblHakAsuransi.PeriodeId='$data[PeriodeId]' AND tblFormKlaim.ManfaatId='$manf[ManfaatId]' AND tblFormKlaimTrans.StatusForm='B' AND tblFormKlaimTrans.FormKlaimId <= '$data[FormKlaimId]'
GROUP BY tblHakAsuransi.NIK,tblHakAsuransi.MemberId,tblFormKlaim.ManfaatId");

$sql2=mssql_query("SELECT     *
FROM         tblHakAsuransi INNER JOIN
                      tblPaketAsuransi ON tblHakAsuransi.PeriodeId = tblPaketAsuransi.PeriodeId AND tblHakAsuransi.LevelId = tblPaketAsuransi.LevelId
WHERE NIK=$data[NIK] AND MemberId='$data[MemberId]' AND tblHakAsuransi.PeriodeId='$data[PeriodeId]' AND ManfaatId='$manf[ManfaatId]'");
 
$Array1 = mssql_fetch_array($sql1);
$Array2 = mssql_fetch_array($sql2);
$Sisa = ($Array2['BiayaManfaat'] - $Array1['Bayar']);

if ($manf['TypeManfaat']=='K'){
	$SisaPlafon='*)';
	}
	elseif ($manf['TypeManfaat']!='K' && $Sisa <= 0){	
		$SisaPlafon = number_format($Sisa, 0);
		$kon='#FFDDDD';
	}
	elseif ($manf['TypeManfaat']!='K' && $Sisa > 0){	
		$SisaPlafon = number_format($Sisa, 0);
		$kon='';
	}
	else{
		$SisaPlafon = '';
		$kon='';

	}

//-----------------------------end session------------------------------------------------------------

if ($detail['Keterangan']==""){
$Keterangan= '-';
}
else {
$Keterangan=$detail['Keterangan'];
}

	echo"<td><div align='right'>$BiayaKlaim</td>
	<td><div align='right'>$Bayar</td>
	<td bgcolor=''><div align='right'>$SisaPlafon</td>
	<td><div align='left'>$Keterangan</td></tr>";
$i++;

	}



$total=mssql_fetch_array(mssql_query("SELECT SUM(BiayaKlaim) AS BiayaKlaim,SUM(Bayar) AS Bayar
FROM         tblFormKlaimTrans INNER JOIN
                      tblFormKlaim ON tblFormKlaimTrans.NIK = tblFormKlaim.NIK AND tblFormKlaimTrans.MemberId = tblFormKlaim.MemberId AND 
                      tblFormKlaimTrans.FormKlaimId = tblFormKlaim.FormKlaimId AND tblFormKlaimTrans.PeriodeId = tblFormKlaim.PeriodeId
WHERE tblFormKlaimTrans.NIK=$session_nik AND tblFormKlaimTrans.MemberId=$_GET[m] AND tblFormKlaimTrans.PeriodeId=$_GET[p] AND tblFormKlaimTrans.FormKlaimId=$data[FormKlaimId] AND tblFormKlaimTrans.StatusForm='B' AND tblFormKlaim.ManfaatId !=0"));
$Total_BiayaKlaim = number_format($total['BiayaKlaim'], 0);
$Total_Bayar = number_format($total['Bayar'], 0);	
	
echo"<tr>
		<th colspan=2><div align='center'>Jumlah (Rp)</th>
		<th colspan=1><div align='right'>$Total_BiayaKlaim</th>
		<th colspan=1><div align='right'>$Total_Bayar</th>
		<th colspan=1><div align='right'>*) $rr</th>
	</tr>";
	
	echo "</table>";
	echo"&nbsp;";
	//echo"<br/>";
	
$no++;
}

break;





}

}
else{
	echo"<div class='alert alert-info'>
      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      <strong>Info!</strong> Silahkan Pilih Periode
    </div>";
}


?>
	<blockquote>
    	<p>Wealth is Useless Without Health.</p>
    	<small>by <cite>ASTEL & Group</cite></small>
	</blockquote>


<script type = "text/javascript">
function goToPage( id ) {
  var node = document.getElementById( id );  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>


<style>
/*
A:link { COLOR: blue; TEXT-DECORATION: none; font-weight: none }
A:visited { COLOR: blue; TEXT-DECORATION: none; font-weight: none }
A:active { COLOR: blue; TEXT-DECORATION: none }
A:hover { COLOR: #FF0000; TEXT-DECORATION: underline; font-weight: none }
.right { text-align: right;}
.center { text-align: center;}
*/


table.tftableon {

font-size:9px;
color:#333333;
border-width: 1px;
border-color: #729ea5;
border-collapse: collapse;
background-color: #FFFFFF;

}

table.tftableon th {
font-size:10px;
background-color:#CCCCCC;
border-width: 1px;
padding: 2px;
border-style: solid;
border-color:#999999;
text-align:center;
background: url("https://apps.unias.com/hris2/images/bg3.gif") repeat;
height: 24px;
}
table.tftableon td {
font-size:9px;
height: 24px;
border-width: 1px;
padding: 2px;
border-style: solid;
border-color:#999999;

}

table.tftableondetail {

font-size:9px;
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

table.tabborder {border-width:1px; border-spacing:0px; border-style:solid; 
     border-color:gray; border-collapse:separate; background-color:white;}
table.tabborder th,
table.tabborder td {border-width:1px; padding:2px;	border-style:inset; 
     border-color: black;background-color:white;}
.bold8 {width:50px; font-size:9px; font-family:arial; text-align:center; 
     font-weight:bold;}
.pt8 {width:10px; font-size:9px; font-family:arial; text-align:center;}
.gaya {
	font-size: 11px;
	font-family: Arial;}

</style>
<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#results").load("fetch_pages.php", {'page':0}, function() {$("#1-page").addClass('active');});  //initial page number to load
	
	$(".paginate_click").click(function (e) {
		
		$("#results").prepend('<div class="loading-indication"><img src="ajax-loader1.gif" /> Loading...</div>');
		
		var clicked_id = $(this).attr("id").split("-"); //ID of clicked element, split() to get page number.
		var page_num = parseInt(clicked_id[0]); //clicked_id[0] holds the page number we need 
		
		$('.paginate_click').removeClass('active'); //remove any active class
		
		$("#results").load("fetch_pages.php", {'page':(page_num-1)}, function(){

		});

		$(this).addClass('active'); //add active class to currently clicked element (style purpose)
		
		return false; //prevent going to herf link
	});	
});
</script>
