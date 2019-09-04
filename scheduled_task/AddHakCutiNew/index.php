<?php
session_start();
error_reporting(0);
include "../koneksi/koneksi.php";

//require 'terbilang.php';
$today 		= date ("Y-m-d");
$lalu       = strtotime($today);
//$today 		= '2014-06-20';
$last_year  = date('Y-m-d',strtotime('-1 year',$lalu));


/*
$sql 	    = "SELECT tbl_hakcuti.NIK AS NIK,
						tbl_profile.Nama AS Nama,
						tbl_hakcuti.Periode1 AS Periode1,
						tbl_hakcuti.Periode2 AS Periode2,
						tbl_hakcuti.PeriodeKerja1 AS PeriodeKerja1,
						tbl_hakcuti.PeriodeKerja2 AS PeriodeKerja2,
						tbl_profile.CompanyId AS CompanyId 
				FROM `tbl_hakcuti` INNER JOIN 
				tbl_profile ON tbl_hakcuti.NIK = tbl_profile.NIK 
				WHERE tbl_profile.bStatus=1 AND tbl_hakcuti.JenisHakcuti=1 
				AND Periode2='$today'
				GROUP BY tbl_hakcuti.NIK 
				ORDER BY tbl_hakcuti.NIK ASC";

*/

$sql 	    = "SELECT * FROM `tbl_profile` WHERE bStatus=1 AND TglMasuk='$last_year' GROUP BY NIK ORDER BY NIK ASC";


$query 		= mysql_query($sql);
$total 	    = mysql_num_rows($query);

while ($data = mysql_fetch_array($query)){

	$lht     		= mysql_query("SELECT * FROM tbl_hakcuti WHERE NIK=".$data['NIK']);
	$jml_lht 		= mysql_num_rows($lht);
	$TglMasuk       = strtotime($data['TglMasuk']);
	//$input1 		= strtotime($data['Periode1']);
	//$input2 		= strtotime($data['Periode2']);

	//$input3 		= strtotime($data['PeriodeKerja1']);
	//$input4 		= strtotime($data['PeriodeKerja2']);

	$Periode1 		= date('Y-m-d',strtotime('+1 year',$TglMasuk));
	$ode2 		    = date('Y-m-d',strtotime('+2 year',$TglMasuk));
	$odeode2        = strtotime($ode2);
	$Periode2 		= date('Y-m-d',strtotime('-1 day',$odeode2));
	$PeriodeKerja1 	= date('Y-m-d',strtotime($data['TglMasuk']));
	$PeriKerja2 	= date('Y-m-d',strtotime('+1 year',$TglMasuk));
	$periperi       = strtotime($PeriKerja2);
	$PeriodeKerja2 	= date('Y-m-d',strtotime('-1 day',$periperi));
	
if ($jml_lht==0){
	//echo $Periode1.'s/d'.$Periode2;

		mysql_query("INSERT INTO tbl_hakcuti(NIK,
											Periode1,
											Periode2,
											PeriodeKerja1,
											PeriodeKerja2,						
											JenisHakCuti,
											Qty,
											QtyPakai,
											StatusHak,
											companyID) 
									VALUES ('$data[NIK]',
											'$Periode1',
											'$Periode2',
											'$PeriodeKerja1',
											'$PeriodeKerja2',											
											'1',
											'12',
											'0',
											'1',
											'$data[CompanyId]')");
	$id = mysql_insert_id();
	

	$Peri1 		= date('Y-m-d',strtotime($PeriodeKerja1));
	$Peri2 		= date('Y-m-d',strtotime($PeriodeKerja2));
	
	// Add Form Cuti
	$aku = mysql_query("SELECT * FROM `tbl_formcutimasal` INNER JOIN tbl_formcutimasaldetail ON 
						tbl_formcutimasal.CutiId = tbl_formcutimasaldetail.CutiId 
						WHERE TglCuti >='$PeriodeKerja1' AND TglCuti <='$PeriodeKerja2'
						GROUP BY tbl_formcutimasal.CutiId 
						ORDER BY tbl_formcutimasal.CutiId ASC");
		  
	  
	while ($rw = mysql_fetch_array($aku)){
		  
			//echo $rw['CutiId'].'<br/>';
			
			mysql_query("INSERT INTO tbl_formcuti(FormCutiNIK,
												  HakCutiId,
												  JenisCuti,
												  StatusForm,
												  Keperluan,
												  Alamat,
												  NoTelpon,
												  Pengganti,
												  TglMasuk,
												  active_id,
												  ApvLevel,
												  NIK1,
												  NIK2,
												  NIK3,
												  Apv1,
												  Apv2,
												  Apv3,
												  Tgl1,
												  Tgl2,
												  Tgl3,
												  CutiMasalId,
												  CreatedBy,
												  CreatedTime,
												  companyID) 
									VALUES ('$data[NIK]',
											'$id',
											'4',
											'A',
											'$rw[Keperluan]',
											'$rw[Alamat]',
											'$rw[NoTelpon]',
											'$rw[Pengganti]',
											'$rw[TglMasuk]',
											'1',
											'3',
											'$rw[NIK1]',
											'$rw[NIK2]',
											'$rw[NIK3]',
											'A',
											'A',
											'A',
											'$rw[Tgl1]',
											'$rw[Tgl2]',
											'$rw[Tgl3]',
											'$rw[CutiId]',
											'$rw[CreatedBy]',
											'$rw[CreatedTime]',											
											'$data[CompanyId]')");
										
			$CutiId = mysql_insert_id();
			
				
				
		  // Add Cuti Detail 
		  $akb = mysql_query("SELECT * FROM `tbl_formcutimasaldetail` 
								WHERE CutiId = '$rw[CutiId]' 
								ORDER BY CutiId ASC");
		  
		  while ($rwd = mysql_fetch_array($akb)){
		  
			//echo 'Tgl:'.$rwd['TglCuti'].'<br/>';
			
			
			mysql_query("INSERT INTO tbl_formcutidetail(CutiId,
												  TglCuti,
												  active_id) 
									VALUES ('$CutiId',
											'$rwd[TglCuti]',
											'1')");
			
			
				
		  
		  }
		  
		  
		  }
		  
	mysql_query("UPDATE tbl_formcuti SET HakCutiId = '".$id."' WHERE FormCutiNIK = '".$data['NIK']."' AND HakCutiId=0 AND JenisCuti=1 AND StatusForm='A' AND Apv3='A'"); 	  
		 
	}	  
}

// Kirim Email Untuk HRD ASTEL GROUP
$recive1 	=  "SELECT * FROM tbl_apv_hrd WHERE hrd_status=1 AND hrd_modules='form_cuti' AND hrd_company=1";

$rows_data1 = mysql_query($recive1);

while ($dw = mysql_fetch_array($rows_data1)){


	$sql1 	    = "SELECT tbl_hakcuti.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_hakcuti.Periode1 AS Periode1,tbl_hakcuti.Periode2 AS Periode2,tbl_profile.CompanyId AS CompanyId 
				FROM `tbl_hakcuti` INNER JOIN 
				tbl_profile ON tbl_hakcuti.NIK = tbl_profile.NIK 
				WHERE tbl_profile.bStatus=1 AND tbl_hakcuti.JenisHakcuti=1
				AND Periode1='$today' AND tbl_hakcuti.companyID !=2 AND StatusMutasi=0
				GROUP BY tbl_hakcuti.NIK 
				ORDER BY tbl_hakcuti.NIK ASC";

	//$sql1 	        = "SELECT * FROM `tbl_profile` WHERE bStatus=1 AND TglMasuk='$today' GROUP BY NIK ORDER BY NIK ASC";		
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
			<p><strong>Daftar Hak Cuti Tahunan Pertama Kali Yang Sudah Dibuatkan Pada Tanggal: $today</strong></p>
			
			<table width='600' border=1 cellpadding=2 cellspacing=0 frame=border rules=rows>		
			<th><div align='center'>No</div></th>
			<th><div align='center'>NIK</div></th>
			<th><div align='center'>Nama</div></th>
			<th><div align='center'>Periode 1</div></th>
			<th><div align='center'>Periode 2</div></th>
			<th><div align='center'>Perusahaan</div></th>
							
			</tr>";
		
	$mail->Body = $body; 
	
	
		
	$no	 =1;
while ($rows = mysql_fetch_array($query1)){	
	
	$cm	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_company WHERE iCompanyId = $rows[CompanyId]"));	
	$NIK	= $rows['NIK'];
	
	if ($no%2==0){$Vcolor="bgcolor='#FFFFFF'";}else{$Vcolor="bgcolor='#F5F5F5'";}
	
	$Periode1	= date('d-M-Y', strtotime($rows['Periode1']));
	$Periode2	= date('d-M-Y', strtotime($rows['Periode2']));
	
	$konten[$NIK]	="<tr>
								<td $Vcolor><div align='center'>$no</div></td>
								<td $Vcolor><div align='left'>$rows[NIK]</div></td>
								<td $Vcolor><div align='left'>$rows[Nama]</div></td>
								<td $Vcolor><div align='right'>$Periode1</div></td>
								<td $Vcolor><div align='right'>$Periode2</div></td>
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
	$mail->Host       	= "Exc2013-DAG";
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
	$mail->Subject    = "Hak Cuti Tahunan";
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






// Kirim Email Untuk HRD SISINDOKOM
$recive2 	=  "SELECT * FROM tbl_apv_hrd WHERE hrd_status=1 AND hrd_modules='form_cuti' AND hrd_company=2";

$rows_data2 = mysql_query($recive2);

while ($dw2 = mysql_fetch_array($rows_data2)){

	$sql2 	    = "SELECT tbl_hakcuti.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_hakcuti.Periode1 AS Periode1,tbl_hakcuti.Periode2 AS Periode2,tbl_profile.CompanyId AS CompanyId 
				FROM `tbl_hakcuti` INNER JOIN 
				tbl_profile ON tbl_hakcuti.NIK = tbl_profile.NIK 
				WHERE tbl_profile.bStatus=1 AND tbl_hakcuti.JenisHakcuti=1
				AND Periode1='$today' AND tbl_hakcuti.companyID =2 AND StatusMutasi=0
				GROUP BY tbl_hakcuti.NIK 
				ORDER BY tbl_hakcuti.NIK ASC";
				
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
			<p><strong>Daftar Hak Cuti Tahunan Pertama Kali Yang Sudah Dibuatkan Pada Tanggal: $today</strong></p>			
			<table width='600' border=1 cellpadding=2 cellspacing=0 frame=border rules=rows>		
			<th><div align='center'>No</div></th>
			<th><div align='center'>NIK</div></th>
			<th><div align='center'>Nama</div></th>
			<th><div align='center'>Periode 1</div></th>
			<th><div align='center'>Periode 2</div></th>
			<th><div align='center'>Perusahaan</div></th>
							
			</tr>";
		
	$mail->Body = $body;
		
	$no	 =1;
while ($rows2 = mysql_fetch_array($query2)){	
	
	$cm2	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_company WHERE iCompanyId = $rows2[CompanyId]"));	
	$NIK	= $rows2['NIK'];
	
	if ($no%2==0){$Vcolor="bgcolor='#FFFFFF'";}else{$Vcolor="bgcolor='#F5F5F5'";}
	
	$Periode1	= date('d-M-Y', strtotime($rows2['Periode1']));
	$Periode2	= date('d-M-Y', strtotime($rows2['Periode2']));
	
	$konten[$NIK]	="<tr>
								<td $Vcolor><div align='center'>$no</div></td>
								<td $Vcolor><div align='left'>$rows2[NIK]</div></td>
								<td $Vcolor><div align='left'>$rows2[Nama]</div></td>
								<td $Vcolor><div align='right'>$Periode1</div></td>
								<td $Vcolor><div align='right'>$Periode2</div></td>
								<td $Vcolor><div align='left'>$cm2[cCompanyName]</div></td>
															
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
	$mail->Host       	= "Exc2013-DAG";
	$mail->Port       	= 25;
	$mail->SMTPKeepAlive= true;
	$mail->SMTPAuth     = true;
	$mail->From         = "system.noreply@unias.com";
	$mail->FromName     = "Human Resource Information System (HRIS)";
	$mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System (HRIS)');
	$to  = "$dw2[hrd_email]";
	//$to  = "dompak.sinambela@unias.com";
	$mail->Body .= $footer;	
	$mail->AddAddress($to);
	$mail->Subject    = "Hak Cuti Tahunan";
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
?>