<?php
session_start();
error_reporting(0);
include "../koneksi/koneksi.php";

// Enam Bulan sebelumnya

$today      = date ("Y-m-d H:i:s");
$isa        = strtotime($today);
$TglExp     = date('Y-m-d',strtotime('-30 day',$isa));


//$before_3rd_month   = date('Y-m-d',strtotime('-90 day',$isa));
//$before_2rd_month   = date('Y-m-d',strtotime('-60 day',$isa));
//$before_1rd_month   = date('Y-m-d',strtotime('-30 day',$isa));
//$current_month      = date('Y-m-d',strtotime($isa));

/*mendapatkan tanggal mysql sekarang*/
$mysqlcomm = "";
$mysqlcomm = "SELECT DATE(now()) tglsekarangmysql FROM DUAL";
$sql = mysql_query($mysqlcomm);
$total      = mysql_num_rows($sql);
while ($data = mysql_fetch_array($sql)){
    $tglsekarangmysql = $data['tglsekarangmysql'];
}

function tanggalsekarang() {
    /*mendapatkan tanggal mysql sekarang*/
    $mysqlcomm = "";
    $mysqlcomm = "SELECT DATE(now()) tglsekarangmysql FROM DUAL";
    $sql = mysql_query($mysqlcomm);
    $total      = mysql_num_rows($sql);
    while ($data = mysql_fetch_array($sql)){
        $tglsekarangmysql = $data['tglsekarangmysql'];
    }

    return $tglsekarangmysql;
}

$tglsekarang = "now()";
//$tglsekarang = "2019-05-28";
//$tglsekarangmysql = "2019-05-28";
$mysqlcommcore = "

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'6 BULAN' ketbulan,tglblnin tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) AND CertValidFinish > DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH)
  GROUP BY certnik ORDER BY CertNIK ASC
) a 

UNION ALL

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'6 BULAN' ketbulan,DATE_ADD(tglblnin, INTERVAL 14 DAY)  tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) AND CertValidFinish > DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH)
  GROUP BY certnik ORDER BY CertNIK ASC
) a 

UNION ALL

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'6 BULAN' ketbulan,DATE_ADD(tglblnin, INTERVAL 28 DAY)  tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) AND CertValidFinish > DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH)
  GROUP BY certnik ORDER BY CertNIK ASC
) a 

UNION ALL

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'5 BULAN' ketbulan,tglblnin tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) AND CertValidFinish > DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH)
  GROUP BY certnik ORDER BY CertNIK ASC
) a 

UNION ALL

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'5 BULAN' ketbulan,DATE_ADD(tglblnin, INTERVAL 14 DAY)  tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) AND CertValidFinish > DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH)
  GROUP BY certnik ORDER BY CertNIK ASC
) a

UNION ALL

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'5 BULAN' ketbulan,DATE_ADD(tglblnin, INTERVAL 28 DAY)  tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) AND CertValidFinish > DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH)
  GROUP BY certnik ORDER BY CertNIK ASC
) a 

UNION ALL

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'4 BULAN' ketbulan,tglblnin tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) AND CertValidFinish > DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH)
  GROUP BY certnik ORDER BY CertNIK ASC
) a 

UNION ALL

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'4 BULAN' ketbulan,DATE_ADD(tglblnin, INTERVAL 14 DAY)  tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) AND CertValidFinish > DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH)
  GROUP BY certnik ORDER BY CertNIK ASC
) a 

UNION ALL

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'4 BULAN' ketbulan,DATE_ADD(tglblnin, INTERVAL 28 DAY)  tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) AND CertValidFinish > DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH)
  GROUP BY certnik ORDER BY CertNIK ASC
) a 

UNION ALL

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'3 BULAN' ketbulan,tglblnin tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) AND CertValidFinish > DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH)
  GROUP BY certnik ORDER BY CertNIK ASC
) a 

UNION ALL

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'3 BULAN' ketbulan,DATE_ADD(tglblnin, INTERVAL 14 DAY)  tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) AND CertValidFinish > DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH)
  GROUP BY certnik ORDER BY CertNIK ASC
) a 

UNION ALL

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'3 BULAN' ketbulan,DATE_ADD(tglblnin, INTERVAL 28 DAY)  tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) AND CertValidFinish > DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH)
  GROUP BY certnik ORDER BY CertNIK ASC
) a 

UNION ALL

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'2 BULAN' ketbulan,DATE(".$tglsekarang.") tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) AND CertValidFinish > DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH)
  GROUP BY certnik ORDER BY CertNIK ASC
) a 

UNION ALL

SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,'1 BULAN' ketbulan,DATE(".$tglsekarang.") tglkirim FROM (
  SELECT certid, certnik,certitem,certproduct,certname,CertValidFinish,
  CONCAT(YEAR(".$tglsekarang."),'-',LPAD(MONTH(".$tglsekarang."),2,0),'-',LPAD(DAY(CertValidFinish),2,0)) tglblnin,
  DATE_ADD(".$tglsekarang.", INTERVAL 6 MONTH) 6bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 5 MONTH) 5bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 4 MONTH) 4bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 3 MONTH) 3bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 2 MONTH) 2bln,
  DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 1bln
  FROM tbl_profile_certification a INNER JOIN tbl_profile b ON CertNIK=NIK WHERE CertStatus='1'
  AND (CertItem =3 OR CertItem =4) AND CertStatus=1 AND CertStatus=1
  AND bStatus=1 
  AND CertValidFinish <= DATE_ADD(".$tglsekarang.", INTERVAL 1 MONTH) 
  GROUP BY certnik ORDER BY CertNIK ASC
) a 

";

$mysqlcomm = "SELECT nik,email,nama,CompanyId,ketbulan,DeptID FROM (".$mysqlcommcore.") a, tbl_profile b WHERE a.certnik=b.nik AND tglkirim='".$tglsekarangmysql."'";

$dataasli = "";
$dataasli = $mysqlcommcore;
$sql      = mysql_query($mysqlcomm);
$total    = mysql_num_rows($sql);
$no =1;
while ($data = mysql_fetch_array($sql)){
    $dataasli = "";
    $dataasli = $mysqlcommcore;
    $nik          = $data['nik'];
    $email          = $data['email'];
    //$email = "RONALDO.PANGASIAN@unias.com";
    $nama           = $data['nama'].' [Karyawan]';
    $where_dept     = '>0';
    $where_valid    = '';
    $company_id     = $data['CompanyId'];
    $dept_id        = $data['DeptID'];
    $ketbulan       = $data['ketbulan'];
      //SendMail($nik,$email,$nama,$where_dept,$company_id,$dataasli,'USER');  
 $no++;
}

//SendMailAtasanLangsung($dataasli);  
//SendMailAtasanLangsung2($dataasli);
//SendMailHrd($nik,$dataasli,$company_id,$mysqlcomm);       
SendHjt($nik,$dataasli,$company_id,$dept_id);
SendTS($nik,$dataasli,$company_id,$dept_id);
SendMeri($nik,$dataasli,$company_id,$dept_id);
SendTO($nik,$dataasli,$company_id,$dept_id);   


function SendMailHrd($nik,$dataasli,$company_id,$dataasliWithCompanyID){
    $mysqlcommhrd = "";
    $mysqlcommhrd = "SELECT hrd_id, hrd_nik, hrd_name, hrd_email, hrd_status, hrd_modules, hrd_company 
                    FROM tbl_apv_hrd a,(".$dataasliWithCompanyID.") b WHERE a.hrd_company=b.CompanyID AND hrd_modules='certificate_reminder' 
                     AND hrd_status = 1 GROUP BY hrd_nik" ;
   
    $sqlhrd = mysql_query($mysqlcommhrd);
    while ($datahrd = mysql_fetch_array($sqlhrd)){            
        $nik          = $nik;
        //$email = "RONALDO.PANGASIAN@unias.com";
        $email        = $datahrd['hrd_email'];
        $nama         = $datahrd['hrd_name'].' [HRD]';
        $where_dept     = '>0';
        $where_valid    = '';
        $company_id     = $datahrd['hrd_company'];
        SendMail($nik,$email,$nama,$where_dept,$company_id,$dataasli,'HRD');        
    }                  
}

function SendMailAtasanLangsung($dataasli){

    $mysqlcommatasanlgsg = "";
    $mysqlcommatasanlgsg = "SELECT nik1 FROM (".$dataasli.") a, tbl_profile b WHERE a.CertNIK=b.nik 
                            AND (b.nik1 IS NOT NULL OR b.nik1>0) AND tglkirim = '".tanggalsekarang()."' GROUP BY b.nik1";                 
                
    $sqlatasanlgsg = mysql_query($mysqlcommatasanlgsg);
    while ($dataatasanlgsg = mysql_fetch_array($sqlatasanlgsg)){            
        $nik          = $dataatasanlgsg['nik1'];
        //$email = "RONALDO.PANGASIAN@unias.com";
        $email        = email_address($nik);
        $nama         = profile_name($nik).' [Atasan]';
        $where_dept     = '>0';
        $where_valid    = '';
        $company_id     = $dataatasanlgsg['CompanyId'];
        SendMail($nik,$email,$nama,$where_dept,$company_id,$dataasli,'ATASAN1');        
    }           
}

function SendMailAtasanLangsung2($dataasli){

    $mysqlcommatasanlgsg = "";
    $mysqlcommatasanlgsg = "SELECT nik2 FROM (".$dataasli.") a, tbl_profile b WHERE a.CertNIK=b.nik 
                            AND (b.nik2 IS NOT NULL OR b.nik2>0) AND tglkirim = '".tanggalsekarang()."' GROUP BY b.nik2";                         
    $sqlatasanlgsg = mysql_query($mysqlcommatasanlgsg);
    while ($dataatasanlgsg = mysql_fetch_array($sqlatasanlgsg)){            
        $nik          = $dataatasanlgsg['nik2'];
        //$email = "RONALDO.PANGASIAN@unias.com";
        $email        = email_address($nik);
        $nama         = profile_name($nik).' [Atasan 2]';
        $where_dept     = '>0';
        $where_valid    = '';
        $company_id     = $dataatasanlgsg['CompanyId'];
        SendMail($nik,$email,$nama,$where_dept,$company_id,$dataasli,'ATASAN2');        
    }           
}


function SendHjt($nik,$dataasli,$company_id,$dept_id){
        $mysqlcommts = "";
        $mysqlcommts = "SELECT * FROM (".$dataasli.") a, tbl_profile b WHERE a.CertNIK=b.nik 
                         AND tglkirim = '".tanggalsekarang()."'  LIMIT 1" ;
       
        $sqlts = mysql_query($mysqlcommts);
        while ($datats = mysql_fetch_array($sqlts)){

          $nik          = $nik;
          //$email = "RONALDO.PANGASIAN@unias.com";
          $email        = "henry.jaya@sisindokom.com";
          $nama         = "Mr. Henry Jaya Teddy";
          $where_dept     = '>0';
          $where_valid    = '';
          $company_id     = '2';
          SendMail($nik,$email,$nama,$where_dept,$company_id,$dataasli,'HJT');   

        }       
}  

/*
function SendTS($nik,$dataasli,$company_id,$dept_id){
           
        $nik          = $nik;
        //$email         = "RONALDO.PANGASIAN@unias.com";
        $email        = "Tommy.Soegianto@unias.com";
        $nama         = "Mr. Tommy Soegianto";
        $where_dept     = '>0';
        $where_valid    = '';
        $company_id     = '1';
        SendMail($nik,$email,$nama,$where_dept,$company_id,$dataasli,'TS');        
} 
*/ 

function SendTS($nik,$dataasli,$company_id,$dept_id){
        $mysqlcommts = "";
        $mysqlcommts = "SELECT * FROM (".$dataasli.") a, tbl_profile b WHERE a.CertNIK=b.nik 
                         AND tglkirim = '".tanggalsekarang()."' AND b.DivisiID NOT IN ('32') LIMIT 1" ;
       
        $sqlts = mysql_query($mysqlcommts);
        while ($datats = mysql_fetch_array($sqlts)){         

            $nik          = $nik;
            //$email         = "RONALDO.PANGASIAN@unias.com";
            $email        = "Tommy.Soegianto@unias.com";
            $nama         = "Mr. Tommy Soegianto";
            $where_dept     = '>0';
            $where_valid    = '';
            $company_id     = '1';
            SendMail($nik,$email,$nama,$where_dept,$company_id,$dataasli,'TS');      
        }  
} 

function SendMeri($nik,$dataasli,$company_id,$dept_id){
        $mysqlcommmeri = "";
        $mysqlcommmeri = "SELECT * FROM (".$dataasli.") a, tbl_profile b WHERE a.CertNIK=b.nik 
                         AND tglkirim = '".tanggalsekarang()."' AND b.DivisiID IN ('32') LIMIT 1" ;
       
        $sqlmeri = mysql_query($mysqlcommmeri);
        while ($datameri = mysql_fetch_array($sqlmeri)){         

            $nik          = $nik;
            //$email         = "RONALDO.PANGASIAN@unias.com";
            $email        = "Meri.Gajali@sisindokom.com";
            $nama         = "Mrs. Meri Gajali";
            $where_dept     = '>0';
            $where_valid    = '';
            $company_id     = '2';
            SendMail($nik,$email,$nama,$where_dept,$company_id,$dataasli,'MERI');      
        }  
}  

function SendTO($nik,$dataasli,$company_id,$dept_id){
        $mysqlcommts = "";
        $mysqlcommts = "SELECT * FROM (".$dataasli.") a, tbl_profile b WHERE a.CertNIK=b.nik 
                         AND tglkirim = '".tanggalsekarang()."' AND a.ketbulan IN ('1 BULAN','2 BULAN') LIMIT 1" ;
        
        $sqlts = mysql_query($mysqlcommts);
        while ($datats = mysql_fetch_array($sqlts)){

          $nik          = $nik;
          //$email = "RONALDO.PANGASIAN@unias.com";
          $email        = "Tikno.Ongkoadi@unias.com";
          $nama         = "Mr. Tikno Ongkoadi";
          $where_dept     = '>0';
          $where_valid    = '';
          $company_id     = '2';
          SendMail($nik,$email,$nama,$where_dept,$company_id,$dataasli,'TO');  

        }      
}  


function SendMail($nikki,$email,$nama,$where_dept,$company_id,$dataasli,$jeniskirim){

$server = 'https://apps.unias.com';

require_once 'class.phpmailer.php'; 

try {

    $mail = new PHPMailer(true);


$body ='

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<style>

    .buttonme {
        display: block;
        width: 115px;
        height: 45px;
        background: #4E9CAF;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
        color: white;
        font-weight: bold;
    }


    table.tftableon {
        font-family: Arial;
        font-size:12px;
        color:#333333;
        border-width: 1px;
        border-color: #729ea5;
        border-collapse: collapse;
        background-color: #FFFFFF;
        padding:1px;
        vertical-align: middle;
    }

    table.tftableon th {
        font-size:12px;
        background-color:#CCCCCC;
        border-width: 1px;
        padding: 2px;
        border-style: solid;
        border-color:#999999;
        text-align:center;
        background: url("https://apps.unias.com/hris2/images/bg3.gif") repeat;
        height: 30px;
        vertical-align: middle;
    }
    table.tftableon td {
        font-size:12px;
        height: 24px;
        border-width: 1px;
        padding: 3px;
        border-style: solid;
        border-color:#999999;
        vertical-align: middle;
    }

    table.tftableondetail {
        font-size:12px;
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

    table.tabborder {
        border-width:1px;
        border-spacing:0px;
        border-style:solid;
        border-color:gray;
        border-collapse:separate;
        background-color:white;
    }
    table.tabborder th,table.tabborder td {
        border-width:1px;
        padding:2px;
        border-style:inset;
        border-color: black;
        background-color:white;
    }
    .bold8 {
        width:50px;
        font-size:9px;
        font-family:arial;
        text-align:center;
        font-weight:bold;
    }
    .pt8 {
        width:10px;
        font-size:9px;
        font-family:arial;
        text-align:center;
    }
    .gaya {
        font-size: 11px;
        font-family: Arial;
    }
    .social {
        width:100px;
        float:right;
        padding-top:5px;
    }

    .social ul {
        list-style: none;
    }

    .social ul li {
        float:left;
        width:21px;
        height:24px;
        margin:0;
        padding:0;
        margin-left:6px;
    }

    td.thickBorder{
        border-right:0px;
    }    

</style>

<body>
<p>Dear, '.$nama.'</p>
<p><strong>Berikut detail sertifikat yang akan habis masa berlakunya</strong></p>
<table id="tfhover" class="tftableon" width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="12"><font size="+2"><strong>Expired Certificate ( BETA )</strong></font></td>
  </tr>
  <tr>
    <th width="2%"><div align="center">No</div></th>
    <th width="4%"><div align="center">NIK</div></th>
    <th width="10%"><div align="center">Name</div></th>
    <th width="8%"><div align="center">Date</div></th>
    <th width="10%"><div align="center">Certificate Name</div></th>
    <th width="10%"><div align="center">Product Name</div></th>
    <th width="10%"><div align="center">Partner Name</div></th>
    <th width="8%"><div align="center">Valid Start</div></th>
    <th width="8%"><div align="center">Valid Finish</div></th>
    <th width="5%"><div align="center">File Attachment</div></th>
    <th width="5%"><div align="center">Company</div></th>
    <th width="20%"><div align="center">Div/Dept/Unit</div></th>
  </tr>';

$mail->Body     = $body;
  $no=1;

if($jeniskirim=="USER") {
  $mysqlcomm2 = "";
  $mysqlcomm2 = "SELECT * FROM (".$dataasli.") a 
                 INNER JOIN tbl_profile_certification b ON a.certid=b.certid
                 INNER JOIN tbl_profile c ON a.certnik=c.nik WHERE a.certnik = '".$nikki."'
                 AND DeptID ".$where_dept." AND bStatus=1 AND certstatus=1 AND CompanyId='".$company_id."'
                 AND a.tglkirim='".tanggalsekarang()."'";  
 } elseif($jeniskirim=="ATASAN1") {
  $mysqlcomm2 = "";
  $mysqlcomm2 = "SELECT * FROM (".$dataasli.") a 
                 INNER JOIN tbl_profile_certification b ON a.certid=b.certid
                 INNER JOIN tbl_profile c ON a.certnik=c.nik WHERE DeptID ".$where_dept." 
                 AND bStatus=1 AND certstatus=1 AND c.nik1='".$nikki."'
                 AND a.tglkirim='".tanggalsekarang()."'";
 } elseif($jeniskirim=="ATASAN2"){
    $mysqlcomm2 = "";
    $mysqlcomm2 = "SELECT * FROM (".$dataasli.") a 
                 INNER JOIN tbl_profile_certification b ON a.certid=b.certid
                 INNER JOIN tbl_profile c ON a.certnik=c.nik WHERE DeptID ".$where_dept." 
                 AND bStatus=1 AND certstatus=1 AND c.nik2='".$nikki."'
                 AND a.tglkirim='".tanggalsekarang()."'";
          
 } elseif($jeniskirim=="TO") {
   $mysqlcomm2 = "";
   $mysqlcomm2 = "SELECT * FROM (".$dataasli.") a 
                 INNER JOIN tbl_profile_certification b ON a.certid=b.certid
                 INNER JOIN tbl_profile c ON a.certnik=c.nik WHERE DeptID ".$where_dept." 
                 AND bStatus=1 AND certstatus=1 
                 AND a.tglkirim='".tanggalsekarang()."' AND a.ketbulan IN ('1 BULAN','2 BULAN')"; 
   echo $mysqlcomm2;              
 } elseif($jeniskirim=="TS") {
   $mysqlcomm2 = "";
   $mysqlcomm2 = "SELECT * FROM (".$dataasli.") a 
                 INNER JOIN tbl_profile_certification b ON a.certid=b.certid
                 INNER JOIN tbl_profile c ON a.certnik=c.nik WHERE DeptID ".$where_dept." 
                 AND bStatus=1 AND certstatus=1 
                 AND a.tglkirim='".tanggalsekarang()."' AND c.DivisiID NOT IN ('32') "; 
 } elseif($jeniskirim=="MERI") {
   $mysqlcomm2 = "";
   $mysqlcomm2 = "SELECT * FROM (".$dataasli.") a 
                 INNER JOIN tbl_profile_certification b ON a.certid=b.certid
                 INNER JOIN tbl_profile c ON a.certnik=c.nik WHERE DeptID ".$where_dept." 
                 AND bStatus=1 AND certstatus=1 AND CompanyId='".$company_id."'
                 AND a.tglkirim='".tanggalsekarang()."' AND c.DivisiID IN ('32') "; 
 } elseif($jeniskirim=="HRD") {
   $mysqlcomm2 = "";
   $mysqlcomm2 = "SELECT * FROM (".$dataasli.") a 
                 INNER JOIN tbl_profile_certification b ON a.certid=b.certid
                 INNER JOIN tbl_profile c ON a.certnik=c.nik WHERE DeptID ".$where_dept." AND CompanyId='".$company_id."'
                 AND bStatus=1 AND certstatus=1 
                 AND a.tglkirim='".tanggalsekarang()."'";  

 } else {
    $mysqlcomm2 = "";
    $mysqlcomm2 = "SELECT * FROM (".$dataasli.") a 
                 INNER JOIN tbl_profile_certification b ON a.certid=b.certid
                 INNER JOIN tbl_profile c ON a.certnik=c.nik WHERE DeptID ".$where_dept." 
                 AND bStatus=1 AND certstatus=1 
                 AND a.tglkirim='".tanggalsekarang()."'";      
 }

  $query  = mysql_query($mysqlcomm2);
    while ($data = mysql_fetch_array($query)){

        if($data['CertValidFinish']!="0000-00-00"){
            $validfinish = date_format_txt($data['CertValidFinish']);
        } else {
            $validfinish = "NO DATA";
        }

        
        $detail[$no]='<tr>
                        <td bgcolor='.color_td($no).'><div align="center">'.$no.'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.$data['CertNIK'].'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.$data['Nama'].'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.date_format_txt($data['CertDate']).'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.$data['CertName'].'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.$data['CertProduct'].'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.$data['CertPartnerName'].'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.date_format_txt($data['CertValidStart']).'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center"><span style="background-color:'.expired_date($data['CertValidFinish']).'"><strong>'.$validfinish.'</strong></span></div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.file_url($data['CertFileUrl']).'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.company($data['CompanyId']).'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.profile_company($data['DeptID']).'</div></td>
                    </tr>';
        $mail->Body .= $detail[$no];
        $no++;

    }

$footer ="</table>
    </body>
    </html><p><font color='#FF0000' size='-1'>Perhatian email ini dikirim secara otomatis dari HRIS. Jangan membalas ke alamat ini</font></p>";
$mail->Body         .= $footer;   



    $mail->IsSMTP();
    $mail->Mailer       = "smtp";
    $mail->Host         = "Exc2013-DAG";
    $mail->Port         = 25;
    $mail->SMTPKeepAlive= true;
    $mail->Priority     = 1;
    $mail->SMTPAuth     = true;
    $mail->From         = "system.noreply@unias.com";
    $mail->FromName     = "Human Resource Information System";
    $mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');    
    //$to = "test.apps@unias.com";
    //$to = "ronaldo.pangasian@unias.com";
    $to = "$email";    
    $mail->AddAddress($to);
    $mail->Subject       = "Expired Certificate ".company_name($company_id);
    $mail->AltBody       = "To view the message, please use an HTML compatible email viewer!";  
    $mail->WordWrap      = 80;  
    $mail->IsHTML(true);    
    $mail->Send();
    //echo $mail->Body;
    $Statusku = 'Email Berhasil Dikirim';

    $mysqlcommlog = "";
    $mysqlcommlog = "INSERT INTO scheduler_certificate_log(nik_karyawan, emailkirim, namakirim, tglkirim,jeniscer) 
                     VALUES 
                     (".$nikki.",'".$email."','".$nama."',now(),'CCIE')" ;
    mysql_query($mysqlcommlog);


}  
        catch(phpmailerException $e){
        echo $e->errorMessage();
        $Statusku = 'Error!!! Email Tidak Berhasil Dikirim';

}

}

echo"<script type='text/javascript'>alert('Email Berhasil Dikirim. Click OK to close window [".where_value()."]');window.open('', '_self', '');window.close();</script>";

function color_td($value){
    if ($value %2==0){
        return '#F7F7F7';
    }
    else{
        return '';
    }
}

function certification_category($value){

    $query  = mysql_query("SELECT * FROM `tbl_certification_item` WHERE CertItemId='$value'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['CertItemName'];
    }
    else{
        return '';
    }

}

function profile_company($value){

    $query  = mysql_query("SELECT * FROM `tbl_company` INNER JOIN 
                                        tbl_div ON tbl_company.iCompanyId=tbl_div.iDivCompany INNER JOIN 
                                        tbl_dept ON tbl_div.iDivId=tbl_dept.iDeptDivID INNER JOIN 
                                        tbl_unit ON tbl_unit.deptID=tbl_dept.iDeptID WHERE iDeptID='$value'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);
    
    if ($total >0){
        return $data['cDivName'].'/'.$data['cDeptName'].'/'.$data['NamaUnit'];
    }
    else{
        return '';
    }

}

function company($value){

    $query  = mysql_query("SELECT * FROM `tbl_company` WHERE iCompanyId='$value'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['cCompanyCode'];
    }
    else{
        return '';
    }
    
}

function file_url($value){

    $server = 'https://apps.unias.com';

    if (!is_null($value) && !empty($value)){
        $url='<a href="'.$server.'/hris2/modules/karyawan/assets/uploads/'.$value.'" target="_blank">Download</a>';
    }else{
        $url = '';
    }

    return $url;

}

function date_format_txt($value){

    if (!is_null($value) && !empty($value)){
        $date = date('d-M-Y', strtotime($value));
    }else{
        $date = '';
    }

    return $date;

}

function where_value(){

    $today      = date ("Y-m-d H:i:s");
    $isa        = strtotime($today);
 /*   
    $before_6th_month   = date('Y-m-d',strtotime('-180 day',$isa));
    $before_5th_month   = date('Y-m-d',strtotime('-150 day',$isa));
    $before_4th_month   = date('Y-m-d',strtotime('-120 day',$isa));
    $before_3rd_month   = date('Y-m-d',strtotime('-90 day',$isa));
    $before_2rd_month   = date('Y-m-d',strtotime('-60 day',$isa));
    $before_1rd_month   = date('Y-m-d',strtotime('-30 day',$isa));
*/

    $before_6th_month   = date('Y-m-d',strtotime('+6 month',$isa));
    $before_5th_month   = date('Y-m-d',strtotime('+5 month',$isa));
    $before_4th_month   = date('Y-m-d',strtotime('+4 month',$isa));
    $before_3rd_month   = date('Y-m-d',strtotime('+3 month',$isa));
    $before_2rd_month   = date('Y-m-d',strtotime('+2 month',$isa));
    $before_1rd_month   = date('Y-m-d',strtotime('+1 month',$isa));

    
    $current_month      = date('Y-m-d',strtotime($today));

    $current_last_notif = date('Y-m-d',strtotime('+7 day',$isa));

    return '(CertValidFinish="'.$before_6th_month.'" OR CertValidFinish="'.$before_5th_month.'" OR CertValidFinish="'.$before_4th_month.'" OR CertValidFinish="'.$before_3rd_month.'" OR CertValidFinish="'.$before_2rd_month.'" OR CertValidFinish="'.$before_1rd_month.'" OR CertValidFinish <="'.$current_last_notif.'") AND (CertItem =3 OR CertItem =4) AND CertStatus=1';


}

function select_value_sub(){

    return 'DATE_SUB(CertValidFinish,INTERVAL -7 DAY) AS SubtractDate';
}

function having_value(){

    return 'Having SubtractDate >= DATE(NOW())';

}

function notes_expired ($value){

    $query  = mysql_query("SELECT * FROM `tbl_profile_certification` WHERE CertId='$value'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    $today      = date ("Y-m-d H:i:s");
    $this_day   = date ("Y-m-d");
    $isa        = strtotime($today);
    $current_last_notif = date('Y-m-d',strtotime('+7 day',$data['CertValidFinish']));

    if ($this_day >=$data['CertValidFinish'] && $current_last_notif > $data['CertValidFinish']){
        return '<strong>EXPIRED</strong>';
    }
    elseif($this_day >=$data['CertValidFinish'] && $current_last_notif <= $data['CertValidFinish']){
        return '<strong>CLOSED</strong>';
    }
    else{
        return '<strong>PROCESS</strong>';

    }


}


function update_status_expired ($value){

    $query  = mysql_query("SELECT * FROM `tbl_profile_certification` WHERE CertId='$value'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    $today  = date ("Y-m-d");
    $next   = date('Y-m-d',strtotime('+7 day',$data['CertValidFinish']));

    if ($today == $next){

        mysql_query("UPDATE tbl_profile_certification SET CertReminder='0' WHERE CertId='$value'");

    }

}

function email_address($nik){
    $query  = mysql_query("SELECT * FROM `tbl_profile` WHERE NIK='$nik'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['Email'];
    }else{
        return '';
    }
}

function profile_name($nik){
    $query  = mysql_query("SELECT * FROM `tbl_profile` WHERE NIK='$nik'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['Nama'];
    }else{
        return '';
    }
}

function company_name($value){
    $query  = mysql_query("SELECT * FROM `tbl_company` WHERE iCompanyId='$value'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['cCompanyName'];
    }else{
        return '';
    }
}

function expired_date($value){    
    $today      = date("Y-m-d");
    $date1      = date('Y-m-d', strtotime($today));
    $date2      = date('Y-m-d', strtotime($value));

    if (strtotime($today) < strtotime($value)){
        return '#FFFF00';
    }else{
        return '#FFFF00';
    }
}


// (CertValidFinish="2015-10-22" OR CertValidFinish="2015-11-21" OR CertValidFinish="2015-12-21" OR CertValidFinish <="2016-01-20")
?>

