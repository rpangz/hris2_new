
<?php
    $data   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile LEFT JOIN 
      tbl_company ON tbl_profile.CompanyId=tbl_company.iCompanyId LEFT JOIN 
      tbl_div ON tbl_profile.DivisiID=tbl_div.iDivId LEFT JOIN 
      tbl_dept ON tbl_profile.DeptID=tbl_dept.iDeptID LEFT JOIN 
      tbl_unit ON tbl_profile.UnitID=tbl_unit.UnitID LEFT JOIN 
      tbl_section ON tbl_profile.SeksiID = tbl_section.iSectionID LEFT JOIN 
      tbl_statusdiri ON tbl_profile.StatusDiri=tbl_statusdiri.StatusDiriId LEFT JOIN 
      tbl_sex ON tbl_profile.Sex = tbl_sex.SexCode LEFT JOIN 
      tbl_agama ON tbl_profile.Agama=tbl_agama.agama_id WHERE NIK=".$primary_key));

    $NIK    = $data['NIK'];
    $Nama   = $data['Nama'];
    $CompanyId = $data['CompanyId'];
    
    if ($CompanyId ==2){
        $hrd_company = 2;
    }
    else {
        $hrd_company = 1;
    }

    //condition for red color

        if ($_SESSION['old_Sex'] == $data['Sex']){
            $bg1 = '';
        }else{
            $bg1 = '#FFFF99';
        }

        if ($_SESSION['old_Agama'] == $data['Agama']){
            $bg2 = '';
        }else{
            $bg2 = '#FFFF99';
        }

        if ($_SESSION['old_TptLahir'] == $data['TptLahir']){
            $bg3 = '';
        }else{
            $bg3 = '#FFFF99';
        }

        if ($_SESSION['old_TglLahir'] == $data['TglLahir']){
            $bg4 = '';
        }else{
            $bg4 = '#FFFF99';
        }

        if ($_SESSION['old_AlamatKTP'] == $data['AlamatKTP']){
            $bg5 = '';
        }else{
            $bg5 = '#FFFF99';
        }

        if ($_SESSION['old_AlamatDomisili'] == $data['AlamatDomisili']){
            $bg6 = '';
        }else{
            $bg6 = '#FFFF99';
        }

        if ($_SESSION['old_Telp'] == $data['Telp']){
            $bg7 = '';
        }else{
            $bg7 = '#FFFF99';
        }

        if ($_SESSION['old_Hp'] == $data['Hp']){
            $bg8 = '';
        }else{
            $bg8 = '#FFFF99';
        }

        if ($_SESSION['old_StatusDiri'] == $data['StatusDiri']){
            $bg9 = '';
        }else{
            $bg9 = '#FFFF99';
        }

        if ($_SESSION['old_NoKTP'] == $data['NoKTP']){
            $bg10 = '';
        }else{
            $bg10 = '#FFFF99';
        }

        if ($_SESSION['old_BloodType'] == $data['BloodType']){
            $bg11 = '';
        }else{
            $bg11 = '#FFFF99';
        }

        if ($_SESSION['old_NoNPWP'] == $data['NoNPWP']){
            $bg12 = '';
        }else{
            $bg12 = '#FFFF99';
        }

        if ($_SESSION['old_NoKPJ'] == $data['NoKPJ']){
            $bg13 = '';
        }else{
            $bg13 = '#FFFF99';
        }

        if ($_SESSION['old_NoKTP'] == $data['NoKTP']){
            $bg14 = '';
        }else{
            $bg14 = '#FFFF99';
        }

        if ($_SESSION['old_TglKTP'] == $data['TglKTP']){
            $bg15 = '';
        }else{
            $bg15 = '#FFFF99';
        }

        if ($_SESSION['old_NamaIbuKandung'] == $data['NamaIbuKandung']){
            $bg16 = '';
        }else{
            $bg16 = '#FFFF99';
        }

        if ($_SESSION['old_CompanyId'] == $data['CompanyId']){
            $bg17 = '';
        }else{
            $bg17 = '#FFFF99';
        }

        if ($_SESSION['old_DivisiID'] == $data['DivisiID']){
            $bg18 = '';
        }else{
            $bg18 = '#FFFF99';
        }

        if ($_SESSION['old_DeptID'] == $data['DeptID']){
            $bg19 = '';
        }else{
            $bg19 = '#FFFF99';
        }

        if ($_SESSION['old_UnitID'] == $data['UnitID']){
            $bg20 = '';
        }else{
            $bg20 = '#FFFF99';
        }

        if ($_SESSION['old_SeksiID'] == $data['SeksiID']){
            $bg21 = '';
        }else{
            $bg21 = '#FFFF99';
        }

        if ($_SESSION['old_NoBPJSKes'] == $data['NoBPJSKes']){
            $bg22 = '';
        }else{
            $bg22 = '#FFFF99';
        }


        $old_TglKTP =date('d-M-Y', strtotime($_SESSION['old_TglKTP']));
        $new_TglKTP =date('d-M-Y', strtotime($data['TglKTP']));

        $old_TglLahir =date('d-M-Y', strtotime($_SESSION['old_TglLahir']));
        $new_TglLahir =date('d-M-Y', strtotime($data['TglLahir']));


    $region_new   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_agama WHERE agama_id=".$post_array['Agama']));
    $n_region_new = $region_new['agama_name'];

    $region_old   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_agama WHERE agama_id=".$_SESSION['old_Agama']));
    $n_region_old = $region_old['agama_name'];

    $sql1   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_Company WHERE iCompanyId=".$_SESSION['old_CompanyId']));
    $old_Company = $sql1['cCompanyName'];

    $sql2   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_div WHERE iDivId=".$_SESSION['old_DivisiID']));
    $old_Division = $sql2['cDivName'];

    $sql3   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_dept WHERE iDeptID=".$_SESSION['old_DeptID']));
    $old_Dept = $sql3['cDeptName'];

    $sql4   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_unit WHERE unitID=".$_SESSION['old_UnitID']));
    $old_Unit = $sql4['NamaUnit'];

    $sql5   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_section WHERE iSectionID=".$_SESSION['old_SeksiID']));
    $old_Section = $sql5['cSectionName'];

    $sql6   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_sex WHERE SexCode='".$_SESSION['old_Sex']."'"));
    $old_Sex = $sql6['SexName'];

    $sql7   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_statusdiri WHERE StatusDiriId='".$_SESSION['old_StatusDiri']."'"));
    $old_StatusDiri = $sql7['StatusDiriName'];


    
$ss = mysql_query("SELECT * FROM tbl_apv_hrd WHERE hrd_status=1 AND hrd_company='$hrd_company' ORDER BY hrd_nik ASC");

while ($rom = mysql_fetch_array($ss)){
    

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
    .style7 {font-size: 13px; font-weight: bold; }
    table { border: thin black solid; } /* or other border styles */
    </style>
    
    
<title>Detail Perubahan Data Profile Karyawan</title>
    </head>
<body>
    <p>Kepada YTH: '.$rom['hrd_name'].'</p>
    <p><strong>Detail Perubahan Data Profile Karyawan</strong></p>
    NIK &nbsp; : '.$data['NIK'].'</br>
    Nama : '.$data['Nama'].'</br></br>

    <table width="800" border="1" cellspacing="1" cellpadding="1" frame="border" rules="rows">
  <tr>
    <th bgcolor="#CCCCCC" width="200" scope="col">Data Profil</th>
    <th bgcolor="#CCCCCC" width="300" scope="col">Before</th>
    <th bgcolor="#CCCCCC" width="300" scope="col">After</th>
  </tr>
  
  <tr>
    <th width="200" scope="row"><div align="right">Sex :</div></th>
    <td width="300">'.$old_Sex.'</td>
    <td width="300" bgcolor="'.$bg1.'">'.$data['SexName'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Agama :</div></th>
    <td>'.$n_region_old.'</td>
    <td bgcolor="'.$bg2.'">'.$n_region_new.'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Tempat Lahir :</div></th>
    <td>'.$_SESSION['old_TptLahir'].'</td>
    <td bgcolor="'.$bg3.'">'.$data['TptLahir'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Tanggal Lahir :</div></th>
    <td>'.$old_TglLahir.'</td>
    <td bgcolor="'.$bg4.'">'.$new_TglLahir.'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Alamat KTP :</div></th>
    <td>'.$_SESSION['old_AlamatKTP'].'</td>
    <td bgcolor="'.$bg5.'">'.$data['AlamatKTP'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Alamat Domisili :</div></th>
    <td>'.$_SESSION['old_AlamatDomisili'].'</td>
    <td bgcolor="'.$bg6.'">'.$data['AlamatDomisili'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">No Telpon :</div></th>
    <td>'.$_SESSION['old_Telp'].'</td>
    <td bgcolor="'.$bg7.'">'.$data['Telp'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">No Handphone :</div></th>
    <td>'.$_SESSION['old_Hp'].'</td>
    <td bgcolor="'.$bg8.'">'.$data['Hp'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Status Diri :</div></th>
    <td>'.$old_StatusDiri.'</td>
    <td bgcolor="'.$bg9.'">'.$data['StatusDiriName'].'</td>
  </tr>

  <tr>
    <th width="200" scope="row"><div align="right">No KTP :</div></th>
    <td width="300">'.$_SESSION['old_NoKTP'].'</td>
    <td width="300" bgcolor="'.$bg10.'">'.$data['NoKTP'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Golongan Darah :</div></th>
    <td>'.$_SESSION['old_BloodType'].'</td>
    <td bgcolor="'.$bg11.'">'.$data['BloodType'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">No. NPWP :</div></th>
    <td>'.$_SESSION['old_NoNPWP'].'</td>
    <td bgcolor="'.$bg12.'">'.$data['NoNPWP'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">No. KPJ :</div></th>
    <td>'.$_SESSION['old_NoKPJ'].'</td>
    <td bgcolor="'.$bg13.'">'.$data['NoKPJ'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">No. BPJS Kesehatan :</div></th>
    <td>'.$_SESSION['old_NoBPJSKes'].'</td>
    <td bgcolor="'.$bg22.'">'.$data['NoBPJSKes'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">No. e-KTP :</div></th>
    <td>'.$_SESSION['old_NoKTP'].'</td>
    <td bgcolor="'.$bg14.'">'.$data['NoKTP'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Tgl KTP :</div></th>
    <td>'.$old_TglKTP.'</td>
    <td bgcolor="'.$bg15.'">'.$new_TglKTP.'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Nama Ibu Kandung :</div></th>
    <td>'.$_SESSION['old_NamaIbuKandung'].'</td>
    <td bgcolor="'.$bg16.'">'.$data['NamaIbuKandung'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Company :</div></th>
    <td>'.$old_Company.'</td>
    <td bgcolor="'.$bg17.'">'.$data['cCompanyName'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Division :</div></th>
    <td>'.$old_Division.'</td>
    <td bgcolor="'.$bg18.'">'.$data['cDivName'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Department :</div></th>
    <td>'.$old_Dept.'</td>
    <td bgcolor="'.$bg19.'">'.$data['cDeptName'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Unit :</div></th>
    <td>'.$old_Unit.'</td>
    <td bgcolor="'.$bg20.'">'.$data['NamaUnit'].'</td>
  </tr>

  <tr>
    <th scope="row"><div align="right">Section :</div></th>
    <td>'.$old_Section.'</td>
    <td bgcolor="'.$bg21.'">'.$data['cSectionName'].'</td>
  </tr>
  
  
  
</table>
    <p><font size=-1>*) Data yang berubah berwarna Kuning</font></p>
    </br>
    </br>
    <p><font color=#FF0000 size=-1>Perhatian email ini dikirim secara otomatis dari HRIS. Jangan membalas ke alamat ini</font></p>
    </body>
    </html>';
    
    
    $mail->Body         = $body;    
    $mail->IsSMTP();
    $mail->Mailer       = "smtp";
    $mail->Host         = "Exc2013-DAG";
    $mail->Port         = 25;
    $mail->SMTPKeepAlive= true;
    $mail->SMTPAuth     = true;
    $mail->From         = "system.noreply@unias.com";
    $mail->FromName     = "Human Resource Information System";
    $mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');
    $to = "$rom[hrd_email]";
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

}