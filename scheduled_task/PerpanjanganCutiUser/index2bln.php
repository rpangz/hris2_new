<?php
session_start();
error_reporting(0);
include "../koneksi/koneksi.php";
//require 'terbilang.php';

/*
$hari_ini 	= date ("Y-m-d");
$lalu       = strtotime($hari_ini);
$today 		= '2016-02-29';
$today      = date ('Y-m-d',strtotime('+1 month',$lalu));
$date 		= date ("Y-m-d");

*/

$hari_ini 	= date ("Y-m-d");
$lalu       = strtotime($hari_ini);
$kyou       = date ('Y-m-d',strtotime('+2 month',$lalu));
$kyou_dum   = strtotime($kyou);
$today      = date ('Y-m-d',strtotime('-1 days',$kyou_dum));
$date 		= date ("Y-m-d");


$ThisDay      = date ('d-M-Y',strtotime($today));

//$today 		= '2019-09-09';
/*
$sql 	    = "SELECT tbl_hakcuti.NIK AS NIK,
						tbl_profile.Nama AS Nama,
						tbl_main_user.email AS Email,
						tbl_hakcuti.Periode1 AS Periode1,
						tbl_hakcuti.Periode2 AS Periode2,
						tbl_hakcuti.PeriodeKerja1 AS PeriodeKerja1,
						tbl_hakcuti.PeriodeKerja2 AS PeriodeKerja2,
						tbl_profile.CompanyId AS CompanyId 
				FROM `tbl_hakcuti` INNER JOIN 
				tbl_profile ON tbl_hakcuti.NIK = tbl_profile.NIK 
				INNER JOIN tbl_main_user ON tbl_main_user.user_id=tbl_profile.NIK 
				WHERE tbl_profile.bStatus=1 AND tbl_profile.CompanyId=2 AND (tbl_hakcuti.JenisHakcuti=1 OR tbl_hakcuti.JenisHakcuti=2) 
				AND Periode2='$today' 
				AND PeriodeExt IS NULL
				GROUP BY tbl_hakcuti.NIK 
				ORDER BY tbl_hakcuti.NIK ASC";
*/

$sql 	    = "select *,(Qty-count(TglCuti)) AS Sisa,
						@rownum:=@rownum+1 'Nomor',
						tbl_hakcuti.NIK AS NIK,
						tbl_profile.Nama AS Nama,
						tbl_main_user.email AS Email,
						tbl_hakcuti.Periode1 AS Periode1,
						tbl_hakcuti.Periode2 AS Periode2,
						tbl_hakcuti.PeriodeKerja1 AS PeriodeKerja1,
						tbl_hakcuti.PeriodeKerja2 AS PeriodeKerja2,
						tbl_profile.CompanyId AS CompanyId,
						tbl_hakcuti.JenisHakCuti AS JenisHakCuti,
						tbl_main_user.Email AS EmailKirim
from tbl_hakcuti LEFT JOIN tbl_formcuti ON tbl_hakcuti.Hakid=tbl_formcuti.HakCutiId LEFT JOIN 
tbl_formcutidetail ON tbl_formcuti.CutiId=tbl_formcutidetail.CutiId INNER JOIN 
tbl_profile ON tbl_profile.NIK=tbl_hakcuti.NIK INNER JOIN tbl_main_user ON tbl_main_user.user_id=tbl_profile.NIK , (SELECT @rownum:=0) r 
WHERE tbl_profile.bStatus=1 AND (tbl_formcuti.StatusForm='A' OR tbl_formcuti.StatusForm IS NULL) AND JenisHakCuti <='2' AND 
Periode2 ='$today' AND PeriodeExt IS NULL  
GROUP BY tbl_hakcuti.NIK 
Having Sisa > 0";

			
$query 		= mysql_query($sql);
$total 	    = mysql_num_rows($query);

//echo "$today";


while ($data = mysql_fetch_array($query)){



	$input1 		= strtotime($data['Periode1']);
	$input2 		= strtotime($data['Periode2']);

	$input3 		= strtotime($data['PeriodeKerja1']);
	$input4 		= strtotime($data['PeriodeKerja2']);

	$Periode1 		= date('Y-m-d',strtotime('+1 year',$input1));
	$Periode2 		= date('Y-m-d',strtotime('+1 year',$input2));

	$PeriodeKerja1 	= date('Y-m-d',strtotime('+1 year',$input3));
	$PeriodeKerja2 	= date('Y-m-d',strtotime('+1 year',$input4));

	$Peri1 		= date('Y-m-d',strtotime('-1 year',$input1));
	$Peri2 		= date('Y-m-d',strtotime('-1 year',$input2));

/*		  
	
	$sql1 	    = "SELECT tbl_hakcuti.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_hakcuti.Periode1 AS Periode1,tbl_hakcuti.Periode2 AS Periode2,tbl_profile.CompanyId AS CompanyId,
				tbl_hakcuti.JenisHakCuti AS JenisHakCuti 
				FROM `tbl_hakcuti` INNER JOIN 
				tbl_profile ON tbl_hakcuti.NIK = tbl_profile.NIK 
				WHERE tbl_profile.bStatus=1 AND (tbl_hakcuti.JenisHakcuti=1 OR tbl_hakcuti.JenisHakcuti=2)
				AND Periode2='$today' AND tbl_profile.NIK='$data[NIK]' AND PeriodeExt IS NULL
				ORDER BY tbl_hakcuti.NIK ASC";

*/


$sql1 	    = "select *,(Qty-count(TglCuti)) AS Sisa,
						@rownum:=@rownum+1 'Nomor',
						tbl_hakcuti.NIK AS NIK,
						tbl_profile.Nama AS Nama,
						tbl_hakcuti.Periode1 AS Periode1,
						tbl_hakcuti.Periode2 AS Periode2,
						tbl_hakcuti.PeriodeKerja1 AS PeriodeKerja1,
						tbl_hakcuti.PeriodeKerja2 AS PeriodeKerja2,
						tbl_profile.CompanyId AS CompanyId,
						tbl_hakcuti.JenisHakCuti AS JenisHakCuti
from tbl_hakcuti LEFT JOIN tbl_formcuti ON tbl_hakcuti.Hakid=tbl_formcuti.HakCutiId LEFT JOIN tbl_formcutidetail ON tbl_formcuti.CutiId=tbl_formcutidetail.CutiId INNER JOIN tbl_profile ON tbl_profile.NIK=tbl_hakcuti.NIK , (SELECT @rownum:=0) r 
WHERE tbl_hakcuti.NIK='$data[NIK]' AND tbl_profile.bStatus=1 AND (tbl_formcuti.StatusForm='A' OR tbl_formcuti.StatusForm IS NULL) AND JenisHakCuti <='2' AND 
Periode2 ='$today' AND PeriodeExt IS NULL  
GROUP BY HakId
Having Sisa > 0";

				
	$query1 		= mysql_query($sql1);
	$total1 	    = mysql_num_rows($query1);
	
	
if ($total > 0){	
	require_once 'class.phpmailer.php';	

	try {

	$mail = new PHPMailer(true);

	$body =
	"<html>
		<head>
			<style type=text/css>
			.style1 {font-size: 12px}
			.style4 {font-size: 12px; font-style: italic;}

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
			<p>Kepada YTH: $data[Nama] </p>
			<p><strong>Daftar Hak Cuti Tahunan Yang Akan Habis 2 Bulan Lagi: $ThisDay</strong></p>			
			<table width='800' border=1 cellpadding=2 cellspacing=0 frame=border rules=rows>		
			<th><div align='center'>No</div></th>
			<th><div align='center'>NIK</div></th>
			<th><div align='center'>Nama</div></th>
			<th><div align='center'>Periode 1</div></th>
			<th><div align='center'>Periode 2</div></th>
			<th><div align='center'>Jenis Cuti</div></th>			
			<th><div align='center'>Perusahaan</div></th>							
			</tr>";
		
	$mail->Body = $body; 
	
	
		
	$no	 =1;
while ($rows = mysql_fetch_array($query1)){	
	
	$datacompany = $rows[CompanyId];

	$cm	    = mysql_fetch_array(mysql_query("SELECT * FROM tbl_company WHERE iCompanyId = $rows[CompanyId]"));	
	$NIK	= $rows['NIK'];

	$jcm	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id = $rows[JenisHakCuti]"));
	
	if ($no%2==0){$Vcolor="bgcolor='#FFFFFF'";}else{$Vcolor="bgcolor='#F5F5F5'";}
	
	$Periode1	= date('d-M-Y', strtotime($rows['Periode1']));
	$Periode2	= date('d-M-Y', strtotime($rows['Periode2']));
	
	$konten[$NIK]	="<tr>
								<td $Vcolor><div align='center'>$no</div></td>
								<td $Vcolor><div align='left'>$rows[NIK]</div></td>
								<td $Vcolor><div align='left'>$rows[Nama]</div></td>
								<td $Vcolor><div align='right'>$Periode1</div></td>
								<td $Vcolor><div align='right'><b>$Periode2</b></div></td>
								<td $Vcolor><div align='center'>$jcm[JenisCutiName]</div></td>								
								<td $Vcolor><div align='left'>$cm[cCompanyName]</div></td>
															
							</tr>";
	$mail->Body .= $konten[$NIK];	
	$no++;
		
	
	}
	
	$footer ="	
	</table>
	</br>
	<p><strong>Anda sudah diperbolehkan memperpanjang masa berlaku cuti ini</strong></p>
	</br>
	<p><font color=#FF0000 size=-1>Perhatian email ini dikirim secara otomatis dari Human Resource Information System (HRIS). Jangan membalas ke alamat ini</font></p>	
	</body>
	</html>";	
	
	

	$mail->IsSMTP();
	$mail->Mailer     	= "smtp";
	//$mail->Host       	= "Exc2013-DAG";
	$mail->Port       	= 25;	
	//$mail->SMTPKeepAlive= true;
	$mail->SMTPAuth     = true;
	$mail->From         = "hris.noreply@unias.com";
	$mail->FromName     = "HRIS";
	$mail->SetFrom('hris.noreply@unias.com', 'HRIS');
	//$to  = "dompak.sinambela@unias.com";
	//$to  = "$data[Email]";
	$to  = "$data[EmailKirim]";
	//$to  = "ronaldo.pangasian@unias.com";
	$mail->Body .= $footer;	
	$mail->AddAddress($to);

	//========================================================================================================================
    $mysqlcommcekhrd = "";
    $mysqlcommcekhrd = "SELECT * FROM tbl_apv_hrd WHERE hrd_modules = 'form_cuti' 
                        AND hrd_status = 1 AND hrd_company = ".$datacompany." AND hrd_nik NOT IN (5144,3967)" ;
    $sqlcekhrd = mysql_query($mysqlcommcekhrd);
    while ($datacekhrd = mysql_fetch_array($sqlcekhrd)){   
        $mailhrd = $datacekhrd['hrd_email'];
        $mail->AddCC($mailhrd);                 
    }
    $mail->AddBCC("ronaldo.pangasian@unias.com");                 
    //========================================================================================================================


	$mail->Subject    = "Perpanjangan Sisa Cuti";
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 	
	$mail->WordWrap   = 80;	
	$mail->IsHTML(true);	
	$mail->Send();	
	//echo $mail->Body;
	
	
		}
		catch (phpmailerException $e)
		{
		echo $e->errorMessage();
		}
			
}


}


//echo"<script type='text/javascript'>alert('Email Berhasil Dikirim. Click OK to close window');window.open('', '_self', '');window.close();</script>";


?>