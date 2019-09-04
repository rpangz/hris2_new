<?php
session_start();
error_reporting(0);
include "../koneksi/koneksi.php";

$today      = date ("Y-m-d H:i:s");
$isa        = strtotime($today);
$TglExp     = date('Y-m-d',strtotime('-30 day',$isa));

//$before_3rd_month   = date('Y-m-d',strtotime('-90 day',$isa));
//$before_2rd_month   = date('Y-m-d',strtotime('-60 day',$isa));
//$before_1rd_month   = date('Y-m-d',strtotime('-30 day',$isa));
//$current_month      = date('Y-m-d',strtotime($isa));


// Update status certificate for expired after 7 (seven) days form current expired date

//temp $sql_exp        = mysql_query('SELECT * FROM tbl_profile_certification INNER JOIN tbl_profile ON CertNIK=NIK WHERE '.where_value().' AND bStatus=1 ORDER BY CertNIK ASC');
$sql_exp        = mysql_query('SELECT * FROM tbl_profile_certification INNER JOIN tbl_profile ON CertNIK=NIK WHERE CertNIK=5144 AND bStatus=999 ORDER BY CertNIK ASC');
$total_exp      = mysql_num_rows($sql_exp);
$no =1;
while ($data_exp = mysql_fetch_array($sql_exp)){

    $isa_dum        = strtotime($data_exp['CertValidFinish']);
    $exp_date       = date('Y-m-d',strtotime('+7 day',$isa_dum));
    $nikki          = $data_exp['NIK'];

    if ($exp_date < $today){
        //temp update_expire_certificate($id=$data_exp['CertId'],$nikki);        
    }
      
$no++;
}



// Send Mail to User
//temp $sql        = mysql_query('SELECT * FROM tbl_profile_certification INNER JOIN tbl_profile ON CertNIK=NIK WHERE '.where_value().' AND CertStatus="1" AND bStatus=1 GROUP BY CertNIK ORDER BY CertNIK ASC');
$sql        = mysql_query('SELECT * FROM tbl_profile_certification INNER JOIN tbl_profile ON CertNIK=NIK WHERE CertNIK=5144 GROUP BY CertNIK ORDER BY CertNIK ASC');

$total      = mysql_num_rows($sql);
$no =1;
while ($data = mysql_fetch_array($sql)){

    $nikki          = $data['NIK'];
    $email          = $data['Email'];
    $nama           = $data['Nama'].' [Karyawan]';
    $where_nik      = '='.$data['CertNIK'];
    $where_dept     = '>0';
    $where_valid    = where_value();
    $company_id     = $data['CompanyId'];
    
    //echo "testaaa";
    SendMail($nikki,$email,$nama,$where_nik,$where_valid,$where_dept,$company_id);    

$no++;
}


// Send Mail to HRD
$sql1        = mysql_query('SELECT * FROM tbl_apv_hrd INNER JOIN 
                            tbl_profile ON tbl_apv_hrd.hrd_company=tbl_profile.CompanyId INNER JOIN 
                            tbl_profile_certification ON CertNIK=tbl_profile.NIK 
                            WHERE '.where_value().' AND hrd_modules="certificate_reminder" AND CertStatus="1" AND bStatus=1 AND hrd_status=1 GROUP BY hrd_company,hrd_nik');

$total1      = mysql_num_rows($sql1);
$no =1;
while ($data1 = mysql_fetch_array($sql1)){

    $nikki          = $data1['NIK'];
    //$email          = $data1['Email'];
    $email          = email_address($data1['hrd_nik']);
    $nama           = $data1['hrd_name'].' [HRD]';
    $where_nik      = '>0';
    $where_dept     = '>0';
    $where_valid    = where_value();
    $company_id     = $data1['hrd_company'];
    
    //temp SendMail($nikki,$email,$nama,$where_nik,$where_valid,$where_dept,$company_id);    

$no++;
}

// Send Mail to Atasan Langsung
$sql2        = mysql_query('SELECT * FROM tbl_profile_certification INNER JOIN 
                            tbl_profile ON tbl_profile_certification.CertNIK=tbl_profile.NIK INNER JOIN 
                            tbl_apv_group_approval ON tbl_apv_group_approval.deptID=tbl_profile.DeptID 
                            WHERE '.where_value().' 
                            AND CertStatus="1" AND bStatus=1 GROUP BY tbl_profile.NIK1 ORDER BY tbl_apv_group_approval.deptID,iGroupApprovalListId ASC');

$total2      = mysql_num_rows($sql2);
$no =1;
while ($data2 = mysql_fetch_array($sql2)){

    $nikki          = $data2['NIK'];
    $email          = email_address($data2['NIK1']);
    $nama           = profile_name($data2['NIK1']).' [Atasan]';
    $where_nik      = '>0';
    $where_dept     = '='.$data2['DeptID'];
    $where_valid    = where_value();
    $company_id     = $data2['CompanyId'];
    
    //temp SendMail($nikki,$email,$nama,$where_nik,$where_valid,$where_dept,$company_id);    

$no++;
}








function SendMail($nikki,$email,$nama,$where_nik,$where_valid,$where_dept,$company_id){

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
    <td colspan="12"><font size="+2"><strong>Expired Certificate</strong></font></td>
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

  $query  = mysql_query('SELECT * FROM tbl_profile_certification 
                        INNER JOIN tbl_profile ON CertNIK=NIK 
                        WHERE bStatus="1" AND CertStatus="1" AND CertNIK'.$where_nik.' AND DeptID'.$where_dept.' AND CompanyId='.$company_id.' AND '.where_value());

    while ($data = mysql_fetch_array($query)){

        $detail[$no]='<tr>
                        <td bgcolor='.color_td($no).'><div align="center">'.$no.'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.$data['CertNIK'].'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.$data['Nama'].'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.date_format_txt($data['CertDate']).'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.$data['CertName'].'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.$data['CertProduct'].'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.$data['CertPartnerName'].'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.date_format_txt($data['CertValidStart']).'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center"><span style="background-color:'.expired_date($data['CertValidFinish']).'"><strong>'.date_format_txt($data['CertValidFinish']).'</strong></span></div></td>
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
    //$to = "dompak.sinambela@unias.com";
    $to = "$email";    
    $mail->AddAddress($to);
    $mail->Subject       = "Expired Certificate ".company_name($company_id);
    $mail->AltBody       = "To view the message, please use an HTML compatible email viewer!";  
    $mail->WordWrap      = 80;  
    $mail->IsHTML(true);    
    $mail->Send();
    $Statusku = 'Email Berhasil Dikirim';

}  
        catch(phpmailerException $e){
        echo $e->errorMessage();
        $Statusku = 'Error!!! Email Tidak Berhasil Dikirim';

}

}

//echo"<script type='text/javascript'>alert('Email Berhasil Dikirim. Click OK to close window [".where_value()."]');window.open('', '_self', '');window.close();</script>";

function color_td($value){
    if ($value %2==0){
        return '#F7F7F7';
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
    $before_3rd_month   = date('Y-m-d',strtotime('-90 day',$isa));
    $before_2rd_month   = date('Y-m-d',strtotime('-60 day',$isa));
    $before_1rd_month   = date('Y-m-d',strtotime('-30 day',$isa));
    */

    $before_3rd_month   = date('Y-m-d',strtotime('+3 month',$isa));
    $before_2rd_month   = date('Y-m-d',strtotime('+2 month',$isa));
    $before_1rd_month   = date('Y-m-d',strtotime('+1 month',$isa));

    $current_month      = date('Y-m-d',strtotime($today));

    return '(CertValidFinish="'.$before_3rd_month.'" OR CertValidFinish="'.$before_2rd_month.'" OR CertValidFinish="'.$before_1rd_month.'" OR CertValidFinish <="'.$current_month.'") AND (CertItem !=3 AND CertItem !=4) AND CertStatus=1';


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


function update_expire_certificate($id, $nikki){

    mysql_query("UPDATE tbl_profile_certification SET CertStatus=0 WHERE CertId='$id' AND CertNIK='$nikki'");

}


// (CertValidFinish="2015-10-22" OR CertValidFinish="2015-11-21" OR CertValidFinish="2015-12-21" OR CertValidFinish <="2016-01-20")
?>