<?php
//session_start();
//error_reporting(0);
include "../koneksi/koneksi.php";

/* =============================================================================================== 
   ||SCRIPT UNTUK NON AKTIF USER                                                                ||
   ===============================================================================================  */ 



$mysqlcomm = "
REPLACE INTO tbl_main_user_resign
SELECT b.*,now() FROM tbl_profile a, tbl_main_user b WHERE a.nik=b.user_id AND b.password != 'RESIGN' AND a.bstatus = 0
";
$sql = mysql_query($mysqlcomm);

$mysqlcomm = "UPDATE tbl_profile a, tbl_main_user b SET password='RESIGN' WHERE a.nik=b.user_id AND b.password != 'RESIGN' AND a.bstatus = 0";
$sql = mysql_query($mysqlcomm);

SendMailHrd();


function CheckData($company_id){
    if($company_id == 1) {
        $mysqlcommhrd2 = "SELECT COUNT(1) total FROM tbl_main_user_resign a, tbl_profile b WHERE a.user_id=b.nik and b.companyid != 2 AND DATE(NonAktifTime)=current_date()" ;   
    } else {
        $mysqlcommhrd2 = "SELECT COUNT(1) total FROM tbl_main_user_resign a, tbl_profile b WHERE a.user_id=b.nik and b.companyid = 2 AND DATE(NonAktifTime)=current_date()" ;   
    }
    $sqlhrd2 = mysql_query($mysqlcommhrd2);
    while ($datahrd2 = mysql_fetch_array($sqlhrd2)){            
        $total        = $datahrd2['total'];
    } 

    if($total>0){
        return true;
    } else {
        return false;
    }                   
}


function SendMailHrd(){
    $mysqlcommhrd = "";
    $mysqlcommhrd = "SELECT * FROM tbl_apv_hrd WHERE hrd_status = 1 AND hrd_modules = 'my_profile' AND hrd_company IN (1,2) GROUP BY hrd_company" ;
    $sqlhrd = mysql_query($mysqlcommhrd);
    while ($datahrd = mysql_fetch_array($sqlhrd)){            
        $nik          = $nik;
        //$email = "RONALDO.PANGASIAN@unias.com";
        $email        = $datahrd['hrd_email'];
        $nama         = $datahrd['hrd_name'].' [HRD]';
        $company_id     = $datahrd['hrd_company'];
        if(CheckData($company_id)) {
            SendMail($nik,$email,$nama,$company_id);             
        }        
    }                  
}



function SendMail($nikki,$email,$nama,$company_id){

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
<p><strong>BERIKUT ADALAH DAFTAR USER RESIGN YANG TELAH DI NON AKTIFKAN USER NYA</strong></p>
<table id="tfhover" class="tftableon" width="100%" border="1" cellspacing="0" cellpadding="0">
  
  <tr>
    <th width="2%"><div align="center">No</div></th>
    <th width="4%"><div align="center">NIK</div></th>
    <th width="10%"><div align="center">Nama</div></th>
    <th width="8%"><div align="center">Tgl Masuk</div></th>
    <th width="10%"><div align="center">Tgl Non Aktif</div></th>
    <th width="10%"><div align="center">Company</div></th>
  </tr>';

$mail->Body     = $body;
  $no=1;

  if($company_id == 1) {
        $mysqlcomm2 = "SELECT b.*,a.nonaktiftime FROM tbl_main_user_resign a, tbl_profile b WHERE a.user_id=b.nik and b.companyid != 2 AND DATE(NonAktifTime)=current_date()" ;   
  } else {
        $mysqlcomm2 = "SELECT b.*,a.nonaktiftime FROM tbl_main_user_resign a, tbl_profile b WHERE a.user_id=b.nik and b.companyid = 2 AND DATE(NonAktifTime)=current_date()" ;   
  }

  $query  = mysql_query($mysqlcomm2);
    while ($data = mysql_fetch_array($query)){

        $detail[$no]='<tr>
                        <td bgcolor='.color_td($no).'><div align="center">'.$no.'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.$data['NIK'].'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.$data['Nama'].'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.date_format_txt($data['TglMasuk']).'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.date_format_txt($data['nonaktiftime']).'</div></td>
                        <td bgcolor='.color_td($no).'><div align="center">'.company($data['CompanyId']).'</div></td>
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
    $to = "ronaldo.pangasian@unias.com";
    //$to = "$email";    
    $mail->AddAddress($to);
    $mail->Subject       = "NON AKTIF USER RESIGN ".company_name($company_id);
    $mail->AltBody       = "To view the message, please use an HTML compatible email viewer!";  
    $mail->WordWrap      = 80;  
    $mail->IsHTML(true);    
    $mail->Send();
    //echo $mail->Body;
    $Statusku = 'Email Berhasil Dikirim';

}  
        catch(phpmailerException $e){
        echo $e->errorMessage();
        $Statusku = 'Error!!! Email Tidak Berhasil Dikirim';

}
    
}

//echo $Statusku;
echo"<script type='text/javascript'>alert('Email Berhasil Dikirim. Click OK to close window [".where_value()."]');window.open('', '_self', '');window.close();</script>";

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


// (CertValidFinish="2015-10-22" OR CertValidFinish="2015-11-21" OR CertValidFinish="2015-12-21" OR CertValidFinish <="2016-01-20")
?>