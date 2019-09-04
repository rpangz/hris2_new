<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MY PROFILE</title>
</head>

<body>
  <?php
  $today       = date('Y-m-d H:i:s');
    $data   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile LEFT JOIN 
      tbl_company ON tbl_profile.CompanyId=tbl_company.iCompanyId LEFT JOIN 
      tbl_div ON tbl_profile.DivisiID=tbl_div.iDivId LEFT JOIN 
      tbl_dept ON tbl_profile.DeptID=tbl_dept.iDeptID LEFT JOIN 
      tbl_unit ON tbl_profile.UnitID=tbl_unit.UnitID LEFT JOIN 
      tbl_section ON tbl_profile.SeksiID = tbl_section.iSectionID LEFT JOIN 
      tbl_statusdiri ON tbl_profile.StatusDiri=tbl_statusdiri.StatusDiriId LEFT JOIN 
      tbl_sex ON tbl_profile.Sex = tbl_sex.SexCode LEFT JOIN 
      tbl_agama ON tbl_profile.Agama=tbl_agama.agama_id 
      WHERE NIK=".$primary_key));
    $NIK    = $data['NIK'];
    $Nama   = $data['Nama'];
    $CompanyId = $data['CompanyId'];
    $TglLahir =date('d-M-Y', strtotime($data['TglLahir']));
    $TglKTP =date('d-M-Y', strtotime($data['TglKTP']));

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
    }
    .style7 {font-size: 13px; font-weight: bold; }
    table { border: thin black solid; } /* or other border styles */
    </style>
    
    
<title>Detail Perubahan Data Profile Karyawan</title>
    </head>
<body>

  <p>Dear, '.$data['Nama'].'</p>
    <p>Terimakasih, Anda Sudah melakukan update profile pada '.$today.'</p>

  <p><strong>Detail Perubahan Data Profile Karyawan</strong></p>
    
  <table width="800" border="1" cellspacing="1" cellpadding="1" frame="border" rules="rows">
    <tr>
    <td width="129" class="header">NIK</td>
    <td width="19">:</td>
    <td width="519">'.$data['NIK'].'</td>
  </tr>
  <tr>
    <td class="header">Nama</td>
    <td>:</td>
    <td>'.$data['Nama'].'</td>
  </tr>
  
  <tr>
    <td class="header">Sex</td>
    <td>:</td>
    <td>'.$data['SexName'].'</td>
  </tr>
  <tr>
    <td class="header">Agama</td>
    <td>:</td>
    <td>'.$data['agama_name'].'</td>
  </tr>
  <tr>
    <td class="header">Tempat Lahir</td>
    <td>:</td>
    <td>'.$data['TptLahir'].'</td>
  </tr>
  <tr>
    <td class="header">Tanggal Lahir</td>
    <td>:</td>
    <td>'.$TglLahir.'</td>
  </tr>
  <tr>
    <td class="header">Alamat KTP/ e-KTP</td>
    <td>:</td>
    <td>'.$data['AlamatKTP'].'</td>
  </tr>
  <tr>
    <td class="header">Alamat Domisili/ Tinggal</td>
    <td>:</td>
    <td>'.$data['AlamatDomisili'].'</td>
  </tr>
  <tr>
    <td class="header">Telepon Rumah</td>
    <td>:</td>
    <td>'.$data['Telp'].'</td>
  </tr>
  <tr>
    <td class="header">Nomor Handphone</td>
    <td>:</td>
    <td>'.$data['Hp'].'</td>
  </tr>
  <tr>
    <td class="header">Status</td>
    <td>:</td>
    <td>'.$data['StatusDiriName'].'</td>
  </tr>
  <tr>
    <td class="header">Gol Darah</td>
    <td>:</td>
    <td>'.$data['BloodType'].'</td>
  </tr>
  <tr>
    <td class="header">No. NPWP</td>
    <td>:</td>
    <td>'.$data['NoNPWP'].'</td>
  </tr>
  <tr>
    <td class="header">No. KPJ</td>
    <td>:</td>
    <td>'.$data['NoKPJ'].'</td>
  </tr>
  <tr>
    <td class="header">No. BPJS Kesehatan</td>
    <td>:</td>
    <td>'.$data['NoBPJSKes'].'</td>
  </tr>
  <tr>
    <td class="header">No  E-KTP</td>
    <td>:</td>
    <td>'.$data['NoKTP'].'</td>
  </tr>
  <tr>
    <td class="header">Tgl KTP</td>
    <td>:</td>
    <td>'.$TglKTP.'</td>
  </tr>
  
  <tr>
    <td class="header">Nama Ibu Kandung</td>
    <td>:</td>
    <td>'.$data['NamaIbuKandung'].'</td>
  </tr>
  <tr>
    <td class="header">Email Pribadi</td>
    <td>:</td>
    <td>'.$data['EmailPribadi'].'</td>
  </tr>

  <tr >
    <td class="header">Email Perusahaan</td>
    <td>:</td>
    <td>'.$data['Email'].'</td>
  </tr>

  <tr>
    <td class="header">Company</td>
    <td>:</td>
    <td>'.$data['cCompanyName'].'</td>
  </tr>  
  <tr>
    <td class="header">Division</td>
    <td>:</td>
    <td>'.$data['cDivName'].'</td>
  </tr>
  <tr>
    <td class="header">Department</td>
    <td>:</td>
    <td>'.$data['cDeptName'].'</td>
  </tr>
  <tr>
    <td class="header">Unit</td>
    <td>:</td>
    <td>'.$data['NamaUnit'].'</td>
  </tr>
  <tr>
    <td class="header">Section</td>
    <td>:</td>
    <td>'.$data['cSectionName'].'</td>
  </tr>
  <tr>
    <td class="header">Anggota Keluarga</td>
    <td>:</td>
    <td>

      <table width="100%" border="0" cellspacing="1" cellpadding="0" style="border-color:#FFFFFF">';      
$mail->Body         = $body;  
      
  $member   = mysql_query("SELECT * FROM tbl_profile_member INNER JOIN 
              tbl_sex ON MemberSex=SexCode INNER JOIN 
              tbl_member_status ON MemberStatus=MemberStatusId 
              WHERE NIK='".$primary_key."'");
  $JmlMember = mysql_num_rows($member);

  $header = '
        <tr>
        <th width="40%" bgcolor="#CCCCCC">Nama</th>
        <th width="20%" bgcolor="#CCCCCC">Tanggal Lahir</th>
        <th width="20%" bgcolor="#CCCCCC">Status Keluarga</th>
        <th width="20%" bgcolor="#CCCCCC">Sex</th>
      </tr>
  ';

  if ($JmlMember > 0){
      $mail->Body         .= $header;
  }


  $me=1;
  while ($dw = mysql_fetch_array($member)){
  
      $MemberLahir = date('d-M-Y', strtotime($dw['MemberLahir']));
      //$day = date('N', strtotime($dst['TglCuti']));

      

      $MyMember[$dw['MemberId']]=
      '<tr>
        <td width="40%">'.$me.'. '.$dw['MemberName'].'</td>
        <td width="20%"><div align="center">'.$MemberLahir.'</div></td>
        <td width="20%"><div align="center">'.$dw['MemberStatusName'].'</div></td>
        <td width="20%"><div align="center">'.$dw['SexName'].'</div></td>
      </tr>';

      $mail->Body .= $MyMember[$dw['MemberId']];
      $me++;
  
  }


  $footer ='</table>    
    </td>
  </tr>
</table>
    </br>
    <p><font color=#FF0000 size=-1>Perhatian email ini dikirim secara otomatis dari HRIS. Jangan membalas ke alamat ini</font></p>
    </body>
    </html>';
  
  $mail->Body         .= $footer;   

    $user_email   = mysql_fetch_array(mysql_query("SELECT email FROM tbl_main_user WHERE user_id='".$primary_key."'"));
    //$old_Division = $sql2['cDivName'];

      
    $mail->IsSMTP();
    $mail->Mailer       = "smtp";
    $mail->Host         = "Exc2013-DAG";
    $mail->Port         = 25;
    $mail->SMTPKeepAlive= true;
    $mail->SMTPAuth     = true;
    $mail->From         = "system.noreply@unias.com";
    $mail->FromName     = "Human Resource Information System";
    $mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');
    $to = "$user_email[email]";
    //$to = "dompak.sinambela@unias.com";
    $mail->AddAddress($to);
    $mail->Subject       = "Perubahan Data Profile $data[Nama]";
    $mail->AltBody       = "To view the message, please use an HTML compatible email viewer!";  
    $mail->WordWrap      = 80;  
    $mail->IsHTML(true);    
    $mail->Send();  
    
        }
        catch (phpmailerException $e)
        {
        echo $e->errorMessage();
        }  
?>
</body>
</html>