<?php

include "../../../includes/koneksi/koneksi.php";

$sadarion     = date('d-M-Y H:i:s');
$companyID    = $_GET['company'];
$primary_key  = $_GET['primary_key'];

$sql     = mysql_query("SELECT * FROM tbl_apv_hrd WHERE hrd_status=1 AND hrd_modules='bpjs' AND hrd_company=".$companyID);
$jumlah  = mysql_num_rows($sql);

$sql1     = mysql_query("SELECT * FROM tbl_bpjs WHERE bpjs_Id=".$primary_key);
$jumlah1  = mysql_num_rows($sql1);
$rows1    = mysql_fetch_array($sql1);

$no_kk    = $rows1['No_KK'];
$email    = $rows1['email'];
$Nama     = $rows1['Nama'];


if ($jumlah >0 && ($primary_key !="" || !is_null($primary_key))){
  
  while ($rows = mysql_fetch_array($sql)){

  $notes = 'Dear, '.$rows['hrd_name'].'<br/>Karyawan Dibawah Ini Melakukan Registrasi BPJS Kesehatan Pada Tanggal '.$sadarion;
  send_mail($primary_key,$no_kk,$rows['hrd_email'],$notes);

  }
}





  $notes = 'Dear, '.$Nama.'<br/>Terimakasih, Anda Sudah Melakukan Registrasi BPJS Kesehatan dan Email Form Registrasi Sudah Dikirimkan Ke HRD Pada Tanggal '.$sadarion;
  send_mail($primary_key,$no_kk,$email,$notes);

//echo "<script language='javascript'>alert('Data Sudah Disimpan dan Email sudah dikirim ke Anda dan HRD".$primary_key."...');</script>";

function send_mail($primary_key,$no_kk,$email,$notes){

$today    = date('Y-m-d H:i:s');
$mysqlcomm = "
SELECT *,a.tipefaskes,a.nmfaskes,a.alamatfaskes,b.tipefaskes tipefaskesgigi,a.nmfaskes nmfaskesgigi,a.alamatfaskes alamatfaskesgigi FROM tbl_bpjs INNER JOIN tbl_bpjs_pisa ON tbl_bpjs_pisa.pisa_id=tbl_bpjs.PISA
INNER JOIN tbl_bpjs_statuskawin ON tbl_bpjs_statuskawin.StatusDiriId=tbl_bpjs.Status_Kawin
INNER JOIN tbl_company ON tbl_bpjs.companyID=tbl_company.iCompanyId
INNER JOIN tbl_div ON tbl_bpjs.divisionID=tbl_div.iDivId
INNER JOIN tbl_dept ON tbl_bpjs.deptID=tbl_dept.iDeptID
INNER JOIN tbl_propinsi ON tbl_bpjs.KDPROP = tbl_propinsi.KDPROP
INNER JOIN tbl_dati2 ON tbl_dati2.KDDATI2=tbl_bpjs.KDDATI2
INNER JOIN tbl_kec ON tbl_kec.KDKEC=tbl_bpjs.KDKEC
INNER JOIN tbl_desa ON tbl_desa.KDDESA=tbl_bpjs.KDDESA
INNER JOIN tbl_bpjs_sex ON tbl_bpjs.Sex = tbl_bpjs_sex.SexId
INNER JOIN tbl_faskesumum a ON tbl_bpjs.KDFaskes=a.KDFaskes
INNER JOIN tbl_faskesumum b ON b.KDFaskes=tbl_bpjs.KDFaskesGigi
INNER JOIN tbl_jabatan ON tbl_jabatan.JabatanId=tbl_bpjs.Jabatan
INNER JOIN tbl_bpjs_status ON tbl_bpjs_status.StatusId=tbl_bpjs.Status_Karyawan
INNER JOIN tbl_bpjs_kelas ON tbl_bpjs_kelas.kelas_id=tbl_bpjs.Kelas_Rawat
INNER JOIN tbl_bpjs_nation ON tbl_bpjs_nation.nation_id=tbl_bpjs.Kewarganegaraan
WHERE bpjs_Id=".$primary_key;
$data = mysql_fetch_array(mysql_query($mysqlcomm));

/*
$data     = mysql_fetch_array(mysql_query("SELECT * FROM tbl_bpjs INNER JOIN 
tbl_bpjs_pisa ON tbl_bpjs_pisa.pisa_id=tbl_bpjs.PISA INNER JOIN 
tbl_bpjs_statuskawin ON tbl_bpjs_statuskawin.StatusDiriId=tbl_bpjs.Status_Kawin INNER JOIN
      tbl_company ON tbl_bpjs.companyID=tbl_company.iCompanyId INNER JOIN 
      tbl_div ON tbl_bpjs.divisionID=tbl_div.iDivId INNER JOIN 
      tbl_dept ON tbl_bpjs.deptID=tbl_dept.iDeptID INNER JOIN 
      tbl_propinsi ON tbl_bpjs.KDPROP = tbl_propinsi.KDPROP AND tbl_propinsi.KDPROP=tbl_bpjs.KDFaskes_KDPROP INNER JOIN
tbl_dati2 ON tbl_dati2.KDDATI2=tbl_bpjs.KDDATI2 AND tbl_bpjs.KDFaskes_KDDATI2=tbl_dati2.KDDATI2 INNER JOIN 
tbl_kec ON tbl_kec.KDKEC=tbl_bpjs.KDKEC INNER JOIN 
tbl_desa ON tbl_desa.KDDESA=tbl_bpjs.KDDESA INNER JOIN 
tbl_bpjs_sex ON tbl_bpjs.Sex = tbl_bpjs_sex.SexId INNER JOIN 
tbl_faskesumum ON tbl_bpjs.KDFaskes=tbl_faskesumum.KDFaskes INNER JOIN 
tbl_faskesgigi ON tbl_faskesgigi.KDFaskesGigi=tbl_bpjs.KDFaskesGigi INNER JOIN 
tbl_jabatan ON tbl_jabatan.JabatanId=tbl_bpjs.Jabatan INNER JOIN 
tbl_bpjs_status ON tbl_bpjs_status.StatusId=tbl_bpjs.Status_Karyawan INNER JOIN 
tbl_bpjs_kelas ON tbl_bpjs_kelas.kelas_id=tbl_bpjs.Kelas_Rawat INNER JOIN 
tbl_bpjs_nation ON tbl_bpjs_nation.nation_id=tbl_bpjs.Kewarganegaraan 
WHERE bpjs_Id=".$primary_key));
*/

$Tgl_Lahir  = date('d-M-Y', strtotime($data['Tgl_Lahir']));
$TglDibuat  = date('d-M-Y', strtotime($data['CreateTime']));

$dewa       = mysql_fetch_array(mysql_query("SELECT * FROM tbl_bpjs WHERE No_KK='".$no_kk."' AND PISA=1"));

if ($data['PISA'] !=1){
  $pisa_user = ' ['.$dewa['Nama'].']';

}else{
  $pisa_user = '';
}

require_once 'class.phpmailer.php';

    try {

    $mail = new PHPMailer(true);

    $body =
    '<html>
    <head>
    <style type=text/css>
    .style1 {font-size: 13px}
    .style4 {font-size: 13px; font-style: normal; }

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
    .header{
      font-weight:bold;
      border-bottom: solid gray 1px;
    }
    .style7 {
      font-size: 13px; font-weight: bold;
    }
    table {
      border: thin black solid;
    }

    td.thickBorder{
      border-bottom: solid gray 1px;
    }
    td.thickBorderRight{
      border-right: solid gray 1px;border-bottom: solid gray 1px;
    }

    /* or other border styles */
    </style>
    
    
<title>Detail Registrasi BPJS Kesehatan</title>
    </head>
<body>


    <p>'.$notes.'</p>

  <p><strong>Detail Registrasi BPJS Kesehatan</strong></p>
    
  <table width="100%" border="0" cellspacing="1" cellpadding="1" frame="border" rules="rows">
  <tr>
    <td width="129" class="header">No BPJS (Jika Ada)</td>
    <td width="8" class="thickBorder">:</td>
    <td width="519" class="thickBorder">'.$data['NoBpjsLama'].'</td>
  </tr>
  <tr>
    <td width="129" class="header">No KK</td>
    <td width="8" class="thickBorder">:</td>
    <td width="519" class="thickBorder">'.$data['No_KK'].'</td>
  </tr>
  <tr>
    <td class="header">No KTP</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['No_KTP'].'</td>
  </tr>
  
  <tr>
    <td class="header">NIK Karyawan</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['NIK'].'</td>
  </tr>

  <tr>
    <td class="header">Nama Karyawan</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['Nama'].$pisa_user.'</td>
  </tr>

  <tr>
    <td class="header">PISA</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['Pisa_name'].'</td>
  </tr>
  <tr>
    <td class="header">Tanggal Lahir</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$Tgl_Lahir.'</td>
  </tr>
  <tr>
    <td class="header">Tempat Lahir</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['Tempat_Lahir'].'</td>
  </tr>
  <tr>
    <td class="header">Sex</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['SexName'].'</td>
  </tr>
  <tr>
    <td class="header">Status Kawin</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['StatusDiriName'].'</td>
  </tr>
  <tr>
    <td class="header">Alamat (Sesuai KTP)</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['Alamat_Tinggal'].'</td>
  </tr>
  <tr>
    <td class="header">Propinsi</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['NMPROP'].'</td>
  </tr>
  <tr>
    <td class="header">Kab/Kota</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['NMDATI2'].'</td>
  </tr>

  <tr>
    <td class="header">Kecamatan</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['NMKEC'].'</td>
  </tr>

  <tr>
    <td class="header">Desa</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['NMDESA'].'</td>
  </tr>
  <tr>
    <td class="header">No RT / No RW</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['No_RT'].'/'.$data['No_RW'].'</td>
  </tr>
  <tr>
    <td class="header">Kode Pos</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['Kode_Pos'].'</td>
  </tr>
  <tr>
    <td class="header">Faskes Propinsi</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['NMPROP'].'</td>
  </tr>
  <tr>
    <td class="header">Faskes Kab/Kota</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['NMDATI2'].'</td>
  </tr>
  <tr>
    <td class="header">Faskes Tk.1</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['TipeFaskes'].' '.$data['NMFaskes'].'. '.$data['AlamatFaskes'].'</td>
  </tr>
  <tr>
    <td class="header">Faskes Gigi</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['tipefaskesgigi'].' '.$data['nmfaskesgigi'].'. '.$data['alamatfaskesgigi'].'</td>
  </tr>
  <tr>
    <td class="header">Kelas Rawat</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['kelas_name'].'</td>
  </tr>
  <tr>
    <td class="header">Tgl Aktif Peserta</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">-</td>
  </tr>
  <tr>
    <td class="header">Kewarganegaraan</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['nation_name'].'</td>
  </tr>
  
  <tr>
    <td class="header">No NPWP</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['No_NPWP'].'</td>
  </tr>
  <tr>
    <td class="header">Company</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['cCompanyName'].'</td>
  </tr>

  <tr >
    <td class="header">Division</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['cDivName'].'</td>
  </tr>

  <tr>
    <td class="header">Departement</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['cDeptName'].'</td>
  </tr>  
  <tr>
    <td class="header">Jabatan</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['NamaJabatan'].'</td>
  </tr>
  <tr>
    <td class="header">Status Karyawan</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['StatusName'].'</td>
  </tr>
  <tr>
    <td class="header">Email</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['email'].'</td>
  </tr>
  <tr>
    <td class="header">Nomor Telp</td>
    <td class="thickBorder">:</td>
    <td class="thickBorder">'.$data['Nomor_Telp'].'</td>
  </tr>

  </table>
    </br>
    <p><font color=#FF0000 size=-1>Perhatian email ini dikirim secara otomatis dari HRIS. Jangan membalas ke alamat ini</font></p>
    </body>
</html>';
  
  $mail->Body = $body;    

      
    $mail->IsSMTP();
    $mail->Mailer       = "smtp";
    $mail->Host         = "Exc2013-DAG";
    $mail->Port         = 25;
    $mail->SMTPKeepAlive= true;
    $mail->SMTPAuth     = true;
    $mail->From         = "system.noreply@unias.com";
    $mail->FromName     = "Human Resource Information System";
    $mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');
    $to = "$email";
    //$to = "dompak.sinambela@unias.com";
    $mail->AddAddress($to);
    $mail->Subject       = "Registrasi BPJS Kesehatan $data[Nama]";
    $mail->AltBody       = "To view the message, please use an HTML compatible email viewer!";  
    $mail->WordWrap      = 80;  
    $mail->IsHTML(true);    
    $mail->Send();  
    
        }
        catch (phpmailerException $e)
        {
        echo $e->errorMessage();
        }
}


?>