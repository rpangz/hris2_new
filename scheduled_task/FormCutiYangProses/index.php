<?php
session_start();
error_reporting(0);
include "../koneksi/koneksi.php";
//require 'terbilang.php';
$today 		= date ("d-M-Y");

//$today 		= '2015-05-12';


	$dws 	    = "SELECT * FROM `tbl_formcuti` INNER JOIN 
				tbl_profile ON tbl_formcuti.FormCutiNIK = tbl_profile.NIK 
				WHERE tbl_profile.bStatus=1 AND tbl_formcuti.StatusForm='P' 
				AND tbl_formcuti.companyID !=2
				ORDER BY tbl_formcuti.FormCutiNIK ASC";
				
	$que 		= mysql_query($dws);
	$tot 	    = mysql_num_rows($que);

//if ($tot > 0){
// Untuk HRD ASTEL GROUP
$recive1 	=  "SELECT * FROM tbl_apv_hrd WHERE hrd_status=1 AND hrd_company !=2 AND hrd_modules='form_cuti' GROUP BY hrd_nik";

$rows_data1 = mysql_query($recive1);

while ($dw = mysql_fetch_array($rows_data1)){

	$sql1 	    = "SELECT * FROM `tbl_formcuti` INNER JOIN 
				tbl_profile ON tbl_formcuti.FormCutiNIK = tbl_profile.NIK 
				WHERE tbl_profile.bStatus=1 AND tbl_formcuti.StatusForm='P' 
				AND tbl_formcuti.companyID !=2 
				ORDER BY tbl_formcuti.FormCutiNIK ASC";
				
	$query1 		= mysql_query($sql1);
	$total1 	    = mysql_num_rows($query1);
	
	
if ($total1 > 0){	
	require_once 'class.phpmailer.php';	

	try {

	$mail = new PHPMailer(true);

	$body =
	"<html>
		<head>
			<style type=text/css>
			.style1 {font-size: 12px}
			.style4 {font-size: 12px; font-style: italic; }

			.bigcell {
			position: relative;
			width: 100px;
			height: 50px;
			border: thin dotted gray;
			}

			.strikeout {
			position: absolute;
			height: 0px;
			width: 179px;
			background-color: black;
			top: 146px;
			visibility: inherit;
			}
			
			table { border: thin black solid;
					font-size:12px;} /* or other border styles */
			</style>			
			<title>Human Resource Information System (HRIS)</title>
			</head>
	
	<body>
			<p>Kepada YTH: $dw[hrd_name] </p>
			<p><strong>Daftar Form Cuti Yang Masih Proses Approval sampai Tanggal: $today</strong></p>
			
			<table width='900' border=1 cellpadding=2 cellspacing=0 frame=border rules=rows>		
			<th><div align='center'>No</div></th>
			<th><div align='center'>NIK</div></th>
			<th><div align='center'>Nama</div></th>
			<th><div align='center'>Keperluan</div></th>
			<th><div align='center'>Jumlah Cuti</div></th>
			<th><div align='center'>Approval Terakhir</div></th>
			<th><div align='center'>Perusahaan</div></th>
							
			</tr>";
		
	$mail->Body = $body; 
	
	
		
	$no	 =1;
while ($rows = mysql_fetch_array($query1)){	
	
	$cm	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_company WHERE iCompanyId = $rows[CompanyId]"));	
	$NIK	= $rows['NIK'];

	$sql 	    = "SELECT  * FROM tbl_formcutidetail WHERE CutiId=".$rows['CutiId'];
				
	$query 		= mysql_query($sql);
	$JmlCuti    = mysql_num_rows($query);

	$vcm	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode=1 AND MatProses=".$rows['ApvLevel']));	
	$Posisi1= $vcm['MatName'];


	
	if ($no%2==0){$Vcolor="bgcolor='#FFFFFF'";}else{$Vcolor="bgcolor='#F5F5F5'";}
	
	$Periode1	= date('d-M-Y', strtotime($rows['Periode1']));
	$Periode2	= date('d-M-Y', strtotime($rows['Periode2']));
	
	$konten[$NIK]	="<tr>
								<td $Vcolor><div align='center'>$no</div></td>
								<td $Vcolor><div align='left'>$rows[NIK]</div></td>
								<td $Vcolor><div align='left'>$rows[Nama]</div></td>
								<td $Vcolor><div align='left'>$rows[Keperluan]</div></td>
								<td $Vcolor><div align='center'>$JmlCuti Hari</div></td>
								<td $Vcolor><div align='center'>$Posisi1</div></td>
								<td $Vcolor><div align='left'>$cm[cCompanyName]</div></td>
															
							</tr>";
	$mail->Body .= $konten[$NIK];	
	$no++;
		
	
	}
	
	$footer ="	
	</table>
	</br>
	</br>
	<p><font color=#FF0000 size=-1>Perhatian email ini dikirim secara otomatis dari Human Resource Information System (HRIS). Jangan membalas ke alamat ini</font></p>	
	</body>
	</html>";	
	
	

	$mail->IsSMTP();
	$mail->Mailer     	= "smtp";
	//$mail->Host       	= "Exc2013-DAG";
	$mail->Port       	= 25;
	$mail->SMTPKeepAlive= true;
	$mail->SMTPAuth     = true;
	$mail->From         = "system.noreply@unias.com";
	$mail->FromName     = "Human Resource Information System (HRIS)";
	$mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System (HRIS)');
	$to  = "$dw[hrd_email]";
	//$to  = "dompak.sinambela@unias.com";
	$mail->Body .= $footer;	
	$mail->AddAddress($to);
	$mail->Subject    = "Form Cuti Yang Masih Proses";
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 	
	$mail->WordWrap   = 80;	
	$mail->IsHTML(true);	
	$mail->Send();	
	
	
	
		}
		catch (phpmailerException $e)
		{
		echo $e->errorMessage();
		}
			
}
}


//}



	$dws2 	    = "SELECT * FROM `tbl_formcuti` INNER JOIN 
				tbl_profile ON tbl_formcuti.FormCutiNIK = tbl_profile.NIK 
				WHERE tbl_profile.bStatus=1 AND tbl_formcuti.StatusForm='P' 
				AND tbl_formcuti.companyID =2 
				ORDER BY tbl_formcuti.FormCutiNIK ASC";
				
	$que2 		= mysql_query($dws2);
	$tot2 	    = mysql_num_rows($que2);

//if ($tot2 > 0){

// Untuk HRD SISINDOKOM
$recive2 	=  "SELECT * FROM tbl_apv_hrd WHERE hrd_status=1 AND hrd_company =2 AND hrd_modules='form_cuti' GROUP BY hrd_nik";

$rows_data2 = mysql_query($recive2);

while ($dw2 = mysql_fetch_array($rows_data2)){

	$sql2 	    = "SELECT * FROM `tbl_formcuti` INNER JOIN 
				tbl_profile ON tbl_formcuti.FormCutiNIK = tbl_profile.NIK 
				WHERE tbl_profile.bStatus=1 AND tbl_formcuti.StatusForm='P' 
				AND tbl_formcuti.companyID =2
				ORDER BY tbl_formcuti.FormCutiNIK ASC";
				
	$query2 		= mysql_query($sql2);
	$total2 	    = mysql_num_rows($query2);
	
	
if ($total2 > 0){	
	require_once 'class.phpmailer.php';	

	try {

	$mail = new PHPMailer(true);

	$body =
	"<html>
		<head>
			<style type=text/css>
			.style1 {font-size: 12px}
			.style4 {font-size: 12px; font-style: italic; }

			.bigcell {
			position: relative;
			width: 100px;
			height: 50px;
			border: thin dotted gray;
			}

			.strikeout {
			position: absolute;
			height: 0px;
			width: 179px;
			background-color: black;
			top: 146px;
			visibility: inherit;
			}
			
			table { border: thin black solid;
					font-size:12px;} /* or other border styles */
			</style>			
			<title>Human Resource Information System (HRIS)</title>
			</head>
	
	<body>
			<p>Kepada YTH: $dw2[hrd_name] </p>
			<p><strong>Daftar Form Cuti Yang Masih Proses Approval sampai Tanggal: $today</strong></p>			
			<table width='900' border=1 cellpadding=2 cellspacing=0 frame=border rules=rows>		
			<th><div align='center'>No</div></th>
			<th><div align='center'>NIK</div></th>
			<th><div align='center'>Nama</div></th>
			<th><div align='center'>Keperluan</div></th>
			<th><div align='center'>Jumlah Cuti</div></th>
			<th><div align='center'>Approval Terakhir</div></th>
			<th><div align='center'>Perusahaan</div></th>
							
			</tr>";
		
	$mail->Body = $body; 
	
	
		
	$no	 =1;
while ($rows2 = mysql_fetch_array($query2)){	
	
	$cm2	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_company WHERE iCompanyId = $rows2[CompanyId]"));	
	$NIK2	= $rows2['NIK'];

	$sqa2	    = "SELECT  * FROM tbl_formcutidetail WHERE CutiId=".$rows2['CutiId'];
				
	$ry2 	= mysql_query($sqa2);
	$JmlCuti2   = mysql_num_rows($ry2);

	$vcm2	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode=1 AND MatProses=".$rows2['ApvLevel']));	
	$Posisi2= $vcm2['MatName'];


	
	if ($no%2==0){$Vcolor="bgcolor='#FFFFFF'";}else{$Vcolor="bgcolor='#F5F5F5'";}
	
	$Periode1	= date('d-M-Y', strtotime($rows2['Periode1']));
	$Periode2	= date('d-M-Y', strtotime($rows2['Periode2']));
	
	$konten2[$NIK2]	="<tr>
								<td $Vcolor><div align='center'>$no</div></td>
								<td $Vcolor><div align='left'>$rows2[NIK]</div></td>
								<td $Vcolor><div align='left'>$rows2[Nama]</div></td>
								<td $Vcolor><div align='left'>$rows2[Keperluan]</div></td>		
								<td $Vcolor><div align='center'>$JmlCuti2 Hari</div></td>
								<td $Vcolor><div align='center'>$Posisi2</div></td>
								<td $Vcolor><div align='left'>$cm2[cCompanyName]</div></td>
															
							</tr>";
	$mail->Body .= $konten2[$NIK2];	
	$no++;
		
	
	}
	
	$footer2 ="	
	</table>
	</br>
	</br>
	<p><font color=#FF0000 size=-1>Perhatian email ini dikirim secara otomatis dari Human Resource Information System (HRIS). Jangan membalas ke alamat ini</font></p>	
	</body>
	</html>";	
	
	

	$mail->IsSMTP();
	$mail->Mailer     	= "smtp";
	//$mail->Host       	= "Exc2013-DAG";
	$mail->Port       	= 25;
	$mail->SMTPKeepAlive= true;
	$mail->SMTPAuth     = true;
	$mail->From         = "system.noreply@unias.com";
	$mail->FromName     = "Human Resource Information System (HRIS)";
	$mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System (HRIS)');
	$to  = "$dw2[hrd_email]";
	//$to  = "dompak.sinambela@unias.com";
	$mail->Body .= $footer2;	
	$mail->AddAddress($to);
	$mail->Subject    = "Form Cuti Yang Masih Proses";
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 	
	$mail->WordWrap   = 80;	
	$mail->IsHTML(true);	
	$mail->Send();	
	
	
	
		}
		catch (phpmailerException $e)
		{
		echo $e->errorMessage();
		}
			
}
}

echo"<script type='text/javascript'>alert('Email Berhasil Dikirim. Click OK to close window');window.open('', '_self', '');window.close();</script>";

//}
?>