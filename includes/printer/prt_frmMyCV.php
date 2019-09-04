<?php
/*
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Sisa_Cuti_$day.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
*/
include "../koneksi/koneksi.php";
$kyou = date("Ymd_His");

header("Content-Type: application/vnd.ms-word");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=CV_$_GET[nama]_$kyou.doc"); 


function format_tanggal_id($date){
    if (!is_null($date) || !empty($date) || $date != ''){
        $tanggal_id = date('d-M-Y', strtotime($date));
    }
    else{
        $tanggal_id = '-';
    }
    return $tanggal_id;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EMPLOYEE CV <?php echo $Namae ?></title>

<style type=text/css>

/*body {
	font-size:36px;
	font-family:Arial;

  width: 100%;
  height: 100%;
  
  margin-left: -2.00cm;
  margin-right: auto;
  margin-top: auto;

}*/


body {
        width: 100%;
        height: 100%;
        margin-left: -2.00cm;
        padding: 0;
        background-color: #FAFAFA;
        font: 20pt "Arial";
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .subpage {
        padding: 1cm;
        border: 5px red solid;
        height: 257mm;
        outline: 2cm #FFEAEA solid;
    }
    
    @page {
        size: A4;
        margin: 0;
    }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;        
        }
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }



@page {
  size: A4;
}


.noPrint{
    display: none;
}

.bigcell {
    position: relative;
    width: 100px;
    height: 50px;
    border: thin dotted black;
}

td.thickBorder{
	border-bottom: solid black 2px;
}
td.thickBorderRight{
	border-right: solid black 2px;
	border-bottom: solid black 2px;
}

}
.strikeout {
	position: absolute;
	height: 0px;
	width: 179px;
	background-color: black;
	top: 146px;
	visibility: inherit;
}
.table2 {
	border:2px black solid;
	font-size: 12px;
}
.table1 {	
	font-size: 12px;
} /* or other border styles */
	
.table1 td{
	height:25px;
} /* or other border styles */
	
table {
	font-size: 16px;
	}
.style1 {
	font-size: 30px;
	font-weight: bold;	
}

.style2 {
	font-size: 9px
}

 .noborder
      {
        border:none;
      }

</style>


<style type="text/css" media="print">
@media print {
    div.divFooter {
        position: fixed;
        height: 50px; /* put the image height here */
        width: 50px; /* put the image width here */
        top: 0;
    }
}
</style>

<link href="screen.css" rel="stylesheet" type="text/css" media="screen" />
<link href="print.css" rel="stylesheet" type="text/css" media="print" />

<style type="text/css">
@media print {
input#btnPrint {
display: none;
}
}
</style> 

</head>

<body>

<!--<input type="button" id="btnPrint" onclick="window.print();" value="Print Page" />
<a href="javascript:window.print()";><img style=border:0; src="http://<?php //echo $_SERVER['SERVER_NAME']?>/hris2/includes/images/printer1.png" 
onmouseover=this.src="http://<?php //echo $_SERVER['SERVER_NAME']?>/hris2/includes/images/printer2.png" 
onmouseout=this.src="http://<?php //echo $_SERVER['SERVER_NAME']?>/hris2/includes/images/printer1.png" title="Print" width="30" height="30"></a>

<br/>-->

<?php


$year   = date ("Y");
$bulan  = date ("F");
$hari   = date ("d");

$nikki    = $_GET['nik'];

$tampil   = mysql_query("SELECT * FROM tbl_profile LEFT JOIN 
      tbl_company ON tbl_profile.CompanyId=tbl_company.iCompanyId LEFT JOIN 
      tbl_div ON tbl_profile.DivisiID=tbl_div.iDivId LEFT JOIN 
      tbl_dept ON tbl_profile.DeptID=tbl_dept.iDeptID LEFT JOIN 
      tbl_unit ON tbl_profile.UnitID=tbl_unit.UnitID LEFT JOIN 
      tbl_section ON tbl_profile.SeksiID = tbl_section.iSectionID LEFT JOIN 
      tbl_statusdiri ON tbl_profile.StatusDiri=tbl_statusdiri.StatusDiriId LEFT JOIN 
      tbl_sex ON tbl_profile.Sex = tbl_sex.SexCode LEFT JOIN 
      tbl_jabatan ON tbl_profile.JabatanID = tbl_jabatan.JabatanId LEFT JOIN 
      tbl_job_fungsional ON tbl_profile.JobCVId = tbl_job_fungsional.JobFungsionalId LEFT JOIN 
      tbl_profile_process ON tbl_profile_process.ProcessId = tbl_profile.ProcessCVNumber LEFT JOIN  
      tbl_agama ON tbl_profile.Agama=tbl_agama.agama_id WHERE NIK=".$nikki);
	  
	$data 	    = mysql_fetch_array($tampil);
  $NIK        = $data['NIK'];
  $Nama       = $data['Nama'];
  $CompanyId  = $data['CompanyId'];
  $logo       = $CompanyId.'.png';
  $process_id = $data['ProcessCVNumber'];
	
	$TglLahir   = date('d-M-Y', strtotime($data['TglLahir']));
  $TglMasuk   = date('d-M-Y', strtotime($data['TglMasuk']));

    
        //+Calculation age------------------------------------------------------------------------------------- 
        $today1 = date ("Y");
        $today2 = date ("m");
        $today3 = date ("d");

        $time = strtotime($data['TglLahir']);
        $d=date('d', $time);
        $y=date('Y', $time);
        $m=date('m', $time);

        $rr = strtotime($m.'/'.$d.'/'.$today1);


        $lahir      = mktime(0,0,0,$m,$d,$y); //jam,menit,detik,bulan,tanggal,tahun
        $t          = time(); $umur = ($lahir < 0) ? ( $t + ($lahir * -1) ) : $t - $lahir; $tahun = 60 * 60 * 24 * 365; 
        $tahunlahir = $umur / $tahun; 
        $MyAge      = floor($tahunlahir);
	  
?>

<div class="divFooter"><img src="http://<?php echo $_SERVER['SERVER_NAME'].'/hris2/includes/images/'.$logo ?>" /></div>


<table width="750" border="0" cellpadding="0" cellspacing="0">
 
  <tr>
    <td><table width="750" class="table2" border="0" cellpadding="0" cellspacing="0" frame="box">
      <tr>
        <td height="30" colspan="7" class="thickBorder" bgcolor="#CCCCCC"><strong>&nbsp;EMPLOYEE CV <?php echo $Namae ?></strong></td>
        </tr>
      <tr height="20">
        <td width="180"> Name</td>
        <td width="12">:</td>
        <td width="350"><?php echo $data['Nama']?></td>
        <td width="12">&nbsp;</td>
        <td width="120">Age</td>
        <td width="12">:</td>
        <td width="250"><?php echo $MyAge ?></td>
      </tr>
      <tr>
        <td>NIP</td>
        <td>:</td>
        <td><?php echo $data['NIK'] ?></td>
        <td>&nbsp;</td>
        <td>Place of birth</td>
        <td>:</td>
        <td><?php echo $data['TptLahir'] ?></td>
      </tr>
      <tr>
        <td>Company</td>
        <td>:</td>
        <td><?php echo $data['cCompanyName'] ?></td>
        <td>&nbsp;</td>
        <td>Date of birth</td>
        <td>:</td>
        <td><?php echo $TglLahir ?></td>
      </tr>
      <tr>
        <td>Division</td>
        <td>:</td>
        <td><?php echo $data['cDivName'] ?></td>
        <td>&nbsp;</td>
        <td>Address</td>
        <td>:</td>
        <td><?php echo $data['AlamatDomisili'] ?></td>
      </tr>
      <tr>
        <td>Job Title Structural</td>
        <td>:</td>
        <td><?php echo $data['NamaJabatan'] ?></td>
        <td>&nbsp;</td>
        <td>City</td>
        <td>:</td>
        <td><?php echo $data['CityDomisili'] ?></td>
      </tr>
      <tr>
        <td>Job Title fungsional</td>
        <td>:</td>
        <td><?php echo $data['JobFungsionalName'] ?></td>
        <td>&nbsp;</td>
        <td>ZIP</td>
        <td>:</td>
        <td><?php echo $data['Kodepos'] ?></td>
      </tr>
      <tr>
        <td>Joint date</td>
        <td>:</td>
        <td><?php echo $TglMasuk ?></td>
        <td>&nbsp;</td>
        <td>Telephone</td>
        <td>:</td>
        <td><?php echo $data['Hp'] ?></td>
      </tr>
      <tr>
        <td>Sex</td>
        <td>:</td>
        <td><?php echo $data['SexNameEng'] ?></td>
        <td>&nbsp;</td>
        <td>Fax</td>
        <td>:</td>
        <td><?php echo $data['Fax'] ?></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>
  <tr>
    <td>
      <table width="100%" class="table1" border="1" cellpadding="0" cellspacing="0" frame="box">
      <tr>
        <td height="30" colspan="4"><strong>&nbsp;Work Experience</strong></td>
        </tr>
      <tr>
        <td bgcolor="#CCCCCC"><div align="center">Start Year</div></td>
        <td bgcolor="#CCCCCC"><div align="center">End Year</div></td>
        <td bgcolor="#CCCCCC"><div align="center">Company</div></td>
        <td bgcolor="#CCCCCC"><div align="center">Position</div></td>
      </tr>
 <?php 
 $workexp = mysql_query("SELECT * FROM tbl_profile_workexperience WHERE WorkExpNIK=".$nikki." ORDER BY WorkExpStart ASC");

        while ($ws1 = mysql_fetch_array($workexp)){
                $WorkExpStart =date('d-M-Y', strtotime($ws1['WorkExpStart']));
                $WorkExpFinish =date('d-M-Y', strtotime($ws1['WorkExpFinish']));

                if($ws1['WorkExpUntilNow'] == 1){
                  $WorkExpFinish         = 'Sekarang';
                }
                else{
                  $WorkExpFinish         = date('d-M-Y', strtotime($ws1['WorkExpFinish']));
                }

 ?>
      <tr>
        <td><?php echo format_tanggal_id($date=$ws1['WorkExpStart']) ?></td>
        <td><?php echo $WorkExpFinish; ?></td>
        <td><?php echo $ws1['WorkExpCompany'] ?></td>
        <td><?php echo $ws1['WorkExpPosition'] ?></td>
      </tr>

 <?php } ?>
    </table>
  </td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="750" class="table1" border="1" cellpadding="1" cellspacing="0" frame="box">
      <tr>
        <td height="30" colspan="7"><strong>&nbsp;Education</strong></td>
        </tr>
      <tr>
        <td width="88" bgcolor="#CCCCCC"><div align="center">Start Year</div></td>
        <td width="88" bgcolor="#CCCCCC"><div align="center">End Year</div></td>
        <td width="220" bgcolor="#CCCCCC"><div align="center">Institution</div></td>
        <td width="123" bgcolor="#CCCCCC"><div align="center">City</div></td>
        <td width="149" bgcolor="#CCCCCC"><div align="center">Faculty</div></td>
        <td width="53" bgcolor="#CCCCCC"><div align="center">Gpa</div></td>
        <td width="171" bgcolor="#CCCCCC"><div align="center">Major</div></td>
      </tr>
<?php

$education = mysql_query("SELECT * FROM tbl_profile_education WHERE EduNIK=".$nikki." ORDER BY EduStart ASC");

                    while ($ws3 = mysql_fetch_array($education)){
?>
      <tr>
        <td><?php echo $ws3['EduStart'] ?></td>
        <td><?php echo $ws3['EduFinish'] ?></td>
        <td><?php echo $ws3['EduInstitution'] ?></td>
        <td><?php echo $ws3['EduCity'] ?></td>
        <td><?php echo $ws3['EduFaculty'] ?></td>
        <td><?php echo $ws3['EduGPA'] ?></td>
        <td><?php echo $ws3['EduMajor'] ?></td>
      </tr>
<?php } ?>
    </table></td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="750" class="table1" border="1" cellpadding="1" cellspacing="0" frame="box">
      <tr>
        <td height="30" colspan="5"><strong>&nbsp;Training</strong></td>
        </tr>
      <tr>
        <td width="47" bgcolor="#CCCCCC"><div align="center">Year</div></td>
        <td width="388" bgcolor="#CCCCCC"><div align="center">Institution</div></td>
        <td width="94" bgcolor="#CCCCCC"><div align="center">City</div></td>
        <td width="257" bgcolor="#CCCCCC"><div align="center">Modul</div></td>
        <td width="108" bgcolor="#CCCCCC"><div align="center">Training Type</div></td>
      </tr>
      
<?php

$training = mysql_query("SELECT * FROM tbl_profile_training WHERE TrainingNIK=".$nikki." ORDER BY TrainingYear ASC");

                    while ($ws2 = mysql_fetch_array($training)){
              ?>
      <tr>
        <td><?php echo $ws2['TrainingYear'] ?></td>
        <td><?php echo $ws2['TrainingInstitution'] ?></td>
        <td><?php echo $ws2['TrainingCity'] ?></td>
        <td><?php echo $ws2['TrainingModul'] ?></td>
        <td><?php echo $ws2['TrainingType'] ?></td>
      </tr>
<?php } ?>
    </table></td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="750" class="table1" border="1" cellpadding="1" cellspacing="0" frame="box">
      <tr>
        <td height="30" colspan="3"><strong>&nbsp;Technical Skill</strong></td>
        </tr>
      <tr>
        <td width="502" bgcolor="#CCCCCC"><div align="center">Technical Skill</div></td>
        <td width="233" bgcolor="#CCCCCC"><div align="center">Experiences</div></td>
        <td width="161" bgcolor="#CCCCCC"><div align="center">Description</div></td>
      </tr>
<?php
$skill = mysql_query("SELECT * FROM tbl_profile_technicalskill WHERE TechnicalSkillNIK=".$nikki." ORDER BY TechnicalSkillId ASC");
                    while ($ws4 = mysql_fetch_array($skill)){
?>
      <tr>
        <td><?php echo $ws4['TechnicalSkillName'] ?></td>
        <td><?php echo $ws4['TechnicalSkillExp'] ?></td>
        <td><?php echo $ws4['TechnicalSkillDesc'] ?></td>
      </tr>
<?php } ?>
    </table></td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="750" class="table1" border="1" cellpadding="1" cellspacing="0" frame="box">
      <tr>
        <td height="30" colspan="5"><strong>&nbsp;Certification</strong></td>
        </tr>
      <tr>
        <td bgcolor="#CCCCCC"><div align="center">Date</div></td>
        <td bgcolor="#CCCCCC"><div align="center">Product</div></td>
        <td bgcolor="#CCCCCC"><div align="center">Certificate</div></td>
        <td bgcolor="#CCCCCC"><div align="center">Partner institution</div></td>
        <td bgcolor="#CCCCCC"><div align="center">Certification</div></td>
      </tr>
<?php
$Cert = mysql_query("SELECT * FROM tbl_profile_certification WHERE CertNIK=".$nikki." ORDER BY CertDate ASC");
                    while ($ws5 = mysql_fetch_array($Cert)){
                        $CertDate =date('d-M-Y', strtotime($ws5['CertDate']));
                        $CertValidStart =date('d M Y', strtotime($ws5['CertValidStart']));
                        $CertValidFinish =date('d M Y', strtotime($ws5['CertValidFinish']));
?>
      <tr>
        <td><?php echo format_tanggal_id($date=$ws5['CertDate']) ?></td>
        <td><?php echo $ws5['CertProduct'] ?></td>
        <td><?php echo $ws5['CertName'] ?></td>
        <td><?php echo $ws5['CertPartnerName'] ?></td>
        <td><?php echo format_tanggal_id($date=$ws5['CertValidStart']).' s/d '.format_tanggal_id($date=$ws5['CertValidFinish']) ?></td>
      </tr>
<?php } ?>
    </table></td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="750" class="table1" border="1" cellpadding="1" cellspacing="0" frame="box">
      <tr>
        <td height="30" colspan="7"><strong>&nbsp;Project History</strong></td>
        </tr>
      <tr>
        <td width="80" rowspan="2" bgcolor="#CCCCCC"><div align="center">Date</div></td>
        <td colspan="4" bgcolor="#CCCCCC"><div align="center">Project</div></td>
        <td width="169" rowspan="2" bgcolor="#CCCCCC"><div align="center">Technical Spec</div></td>
        <td width="125" rowspan="2" bgcolor="#CCCCCC"><div align="center">Position in Project</div></td>
      </tr>
      <tr>
        <td width="195" bgcolor="#CCCCCC"><div align="center">Project</div></td>
        <td width="193" bgcolor="#CCCCCC"><div align="center">Institution</div></td>
        <td width="54" bgcolor="#CCCCCC"><div align="center">Year</div></td>
        <td width="76" bgcolor="#CCCCCC"><div align="center">Length</div></td>
        </tr>
<?php
$project = mysql_query("SELECT * FROM tbl_profile_projecthistory WHERE ProjectNIK=".$nikki." ORDER BY ProjectDate ASC");
                    while ($ws6 = mysql_fetch_array($project)){
                        $ProjectDate =date('d-M-Y', strtotime($ws6['ProjectDate']));
?>
      <tr>
        <td><?php echo format_tanggal_id($date=$ws6['ProjectDate']) ?></td>
        <td><?php echo $ws6['ProjectName'] ?></td>
        <td><?php echo $ws6['ProjectInstitution'] ?></td>
        <td><div align="center"><?php echo $ws6['ProjectYear'] ?></div></td>
        <td><div align="center"><?php echo $ws6['ProjectLength'] ?></div></td>
        <td><?php echo $ws6['ProjectTechnicalSpec'] ?></td>
        <td><?php echo $ws6['ProjectPosition'] ?></td>
      </tr>
<?php } ?>
    </table></td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>
  <tr>
    <td class="noborder"><div align="right"></div></td>
  </tr>
  <tr>
    <td height="76">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right"><?php echo $data['Nama'] ?></div></td>
  </tr>
</table>
</body>
</html>
