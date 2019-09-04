<?php
session_start();
error_reporting(0);
include "../koneksi/koneksi.php";
//require 'terbilang.php';
$today 		= date("Y-m-d");

$today 		= '2018-11-11';

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
				AND Periode2='$today' AND StatusMutasi=0 
				GROUP BY tbl_hakcuti.NIK 
				ORDER BY tbl_hakcuti.NIK ASC";
				
$query 		= mysql_query($sql);
$total 	    = mysql_num_rows($query);

while ($data = mysql_fetch_array($query)){



$input1 		= strtotime($data['Periode1']);
$input2 		= strtotime($data['Periode2']);

$input3 		= strtotime($data['PeriodeKerja1']);
$input4 		= strtotime($data['PeriodeKerja2']);

$Periode1 		= date('Y-m-d',strtotime('+1 year',$input1));
$Periode2 		= date('Y-m-d',strtotime('+1 year',$input2));

$PeriodeKerja1 	= date('Y-m-d',strtotime('+1 year',$input3));
$PeriodeKerja2 	= date('Y-m-d',strtotime('+1 year',$input4));

	//echo $Peri1	= date('Y-m-d', strtotime($data['Periode1']));
	//echo $Peri2	= date('Y-m-d', strtotime($data['Periode2']));
	
	

	
	



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

								



	//$Peri1 		= date('Y-m-d',strtotime('-1 year',$input1));
	//$Peri2 		= date('Y-m-d',strtotime('-1 year',$input2));

	$Peri1 		= date('Y-m-d',strtotime($PeriodeKerja1));
	$Peri2 		= date('Y-m-d',strtotime($PeriodeKerja2));


	//$Peri1 		= date('Y-m-d',strtotime($data['Periode1']));
	//$Peri2 		= date('Y-m-d',strtotime($data['Periode2']));


    echo $peri1;
    echo $peri2;
	
	// Add Form Cuti
	$aku = mysql_query("SELECT * FROM `tbl_formcutimasal` INNER JOIN tbl_formcutimasaldetail ON 
						tbl_formcutimasal.CutiId = tbl_formcutimasaldetail.CutiId 
						WHERE TglCuti >='$Peri1' AND TglCuti <='$Peri2' 
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

echo $sql;
?>