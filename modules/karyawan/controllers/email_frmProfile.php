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

    if ($data['TglKTPever'] ==1){
      $TglKTP = 'Seumur Hidup';
    }
    else{
        if (is_null($data['TglKTP'])){
            $TglKTP = '-';
        }else{
            $TglKTP = date('d-M-Y', strtotime($data['TglKTP']));
        }   
    }

    $TglLahir =date('d-M-Y', strtotime($data['TglLahir']));
    //$TglKTP =date('d-M-Y', strtotime($data['TglKTP']));
    $TglMasuk =date('d-M-Y', strtotime($data['TglMasuk']));

    $sadarion =date('d-M-Y H:i:s');

    $ember   = mysql_query("SELECT * FROM tbl_profile_member INNER JOIN 
              tbl_sex ON MemberSex=SexCode INNER JOIN 
              tbl_member_status ON MemberStatus=MemberStatusId 
              WHERE NIK='".$primary_key."' AND MemberStatus='3'");
    $Jmlember = mysql_num_rows($ember);

    if ($data['StatusDiri'] ==1){
        $StatusDiri = '';
    }else{
        $StatusDiri = '/'.$Jmlember;
        
    }

    if(!is_null($data['Photos'] || !empty($data['Photos']))){

      //$link_my_photo = '<a href="https://apps.unias.com/hris2/assets/uploads/files/'.$data['Photos'].'" target="_blank">Download</a>';
      $link_my_photo = '<a href="'.site_url('assets/uploads/files/'.$data['Photos']).'" target="_blank">Download</a>';

    }
    else{
      $link_my_photo = '';
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
    }
    .style7 {font-size: 13px; font-weight: bold; }
    table { border: thin black solid; } /* or other border styles */
    </style>
    
    
<title>Detail Perubahan Data Profile Karyawan</title>
    </head>
<body>

  <p>Dear, '.$data['Nama'].'</p>
    <p>Terimakasih, Anda Sudah melakukan update profile pada '.$sadarion.'</p>

  <p><strong>Detail Perubahan Data Profile Karyawan</strong></p>
    
  <table width="100%" border="1" cellspacing="1" cellpadding="1" frame="border" rules="rows">
  <tr>
    <td width="129" class="header">NIK</td>
    <td width="19">:</td>
    <td width="519">'.$data['NIK'].'</td>
  </tr>
  <tr>
    <td class="header">Name</td>
    <td>:</td>
    <td>'.$data['Nama'].'</td>
  </tr>

  <tr>
    <td class="header">Photo</td>
    <td>:</td>
    <td>'.$link_my_photo.'</td>
  </tr>
  
  <tr>
    <td class="header">Sex</td>
    <td>:</td>
    <td>'.$data['SexNameEng'].'</td>
  </tr>
  <tr>
    <td class="header">Relegion</td>
    <td>:</td>
    <td>'.$data['agama_name'].'</td>
  </tr>
  <tr>
    <td class="header">Birth Place</td>
    <td>:</td>
    <td>'.$data['TptLahir'].'</td>
  </tr>
  <tr>
    <td class="header">Birth Date</td>
    <td>:</td>
    <td>'.$TglLahir.'</td>
  </tr>
  <tr>
    <td class="header">Address (ID Based)</td>
    <td>:</td>
    <td>'.$data['AlamatKTP'].'</td>
  </tr>
  <tr>
    <td class="header">City (ID Based)</td>
    <td>:</td>
    <td>'.$data['CityKTP'].'</td>
  </tr>
  <tr>
    <td class="header">ZIP (ID Based)</td>
    <td>:</td>
    <td>'.$data['KodeposKTP'].'</td>
  </tr>
  <tr>
    <td class="header">Address (Current)</td>
    <td>:</td>
    <td>'.$data['AlamatDomisili'].'</td>
  </tr>
  <tr>
    <td class="header">City (Current)</td>
    <td>:</td>
    <td>'.$data['CityDomisili'].'</td>
  </tr>

  <tr>
    <td class="header">ZIP (Current)</td>
    <td>:</td>
    <td>'.$data['Kodepos'].'</td>
  </tr>

  <tr>
    <td class="header">Telp</td>
    <td>:</td>
    <td>'.$data['Telp'].'</td>
  </tr>
  <tr>
    <td class="header">HP</td>
    <td>:</td>
    <td>'.$data['Hp'].'</td>
  </tr>
  <tr>
    <td class="header">Marital Status</td>
    <td>:</td>
    <td>'.$data['StatusDiriName'].$StatusDiri.'</td>
  </tr>
  <tr>
    <td class="header">Blood Type</td>
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
    <td class="header">No Kartu Keluarga</td>
    <td>:</td>
    <td>'.$data['NoKK'].'</td>
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
    <td class="header">Mother&#39;s Name</td>
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
        <th width="30%" bgcolor="#CCCCCC">Name</th>
        <th width="10%" bgcolor="#CCCCCC">Birth Date</th>
        <th width="10%" bgcolor="#CCCCCC">Birth Place</th>
        <th width="10%" bgcolor="#CCCCCC">Status</th>
        <th width="10%" bgcolor="#CCCCCC">Sex</th>
        <th width="10%" bgcolor="#CCCCCC">Blood Type</th>
        <th width="20%" bgcolor="#CCCCCC">No KTP</th>
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
        <td width="30%">'.$me.'. '.$dw['MemberName'].'</td>
        <td width="10%"><div align="center">'.$MemberLahir.'</div></td>
        <td width="10%"><div align="center">'.$dw['MemberTempatLahir'].'</div></td>
        <td width="10%"><div align="center">'.$dw['MemberStatusName'].'</div></td>
        <td width="10%"><div align="center">'.$dw['SexNameEng'].'</div></td>
        <td width="10%"><div align="center">'.$dw['MemberBloodType'].'</div></td>
        <td width="20%"><div align="center">'.$dw['MemberKTP'].'</div></td>
      </tr>';

      $mail->Body .= $MyMember[$dw['MemberId']];
      $me++;
  
  }


  $footer_member ='</table>    
    </td>
  </tr>

  <tr>
    <td class="header">Attachment Files</td>
    <td>:</td>
    <td>';

  $mail->Body         .= $footer_member;

      $files   = mysql_query("SELECT * FROM tbl_profile_attachment WHERE file_nik='".$primary_key."' ORDER BY file_id ASC");

      while ($fw = mysql_fetch_array($files)){     

      $MyFiles[$fw['file_id']]=
      '&nbsp;<a href="http://'.$_SERVER['SERVER_NAME'].'/hris2/modules/karyawan/assets/uploads/'.$fw['url'].'" target="_blank">'.$fw['file_code'].'</a><br/>';

      $mail->Body .= $MyFiles[$fw['file_id']];
      $me++;
  
  }




    $footer='</td>
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
    $mail->Priority     = 1;
    $mail->From         = "HRIS";
    $mail->FromName     = "HRIS";
    $mail->SetFrom('hris.noreply@unias.com', 'HRIS');
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