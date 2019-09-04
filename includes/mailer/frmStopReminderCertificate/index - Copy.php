<?php
session_start();
error_reporting(0);
include "../../koneksi/koneksi.php";

$today   = date ("Y-m-d H:i:s");
$date    = date ("d-M-Y");

$alphaNumeric   = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ0123456789";
$random         = substr(str_shuffle($alphaNumeric), 0, 7);
$NewPassword    = md5($random);

if (!empty($_GET['user_id']) || !is_null($_GET['user_id'])){
    
    mysql_query("UPDATE tbl_main_user SET password='$NewPassword' WHERE user_id='$_GET[user_id]'");

    send_email_reset_password($nik=$_GET['user_id'],$new_password=$random);

}


function send_email_reset_password($nik,$new_password){

    $date   = date ("d-M-Y");
    $dir_url= $_SERVER['SERVER_NAME'].'/hris2/';
    $query  = mysql_query("SELECT * FROM tbl_main_user WHERE user_id='".$nik."'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    $internal  = 'https://apps.unias.com/hris2/';
    $eksternal = 'https://apps.unias.com/hris2/';


    require_once 'class.phpmailer.php'; 
    try {

    $mail = new PHPMailer(true);
    $body='
        <html>
        <head>
          <title>Password Baru</title>
        </head>
        <body>Jakarta, '.$date.'<br />
              Kepada Yth: '.$data['real_name'].'<br />   
        <br/>
        Password login sistem HRIS anda sudah di-reset oleh System.<br />
        Mohon password diganti setelah anda berhasil masuk kembali ke sistem HRIS.<br/>
        <br/>
        Terimakasih.    
        <p><strong>Detail Password Baru</strong></p>
        <table width="650" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="86">Username</td>
            <td width="10">:</td>
            <td width="554">'.$data['user_name'].'</td>
        </tr>
        <tr>
            <td width="86">Password</td>
            <td width="10">:</td>
            <td width="554">'.$new_password.'</td>
        </tr>     
        </table>

        <p><strong>Detail Link Aplikasi HRIS</strong></p>
        <table width="650" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="86">Internal</td>
            <td width="10">:</td>
            <td width="554"><a href='.$internal.'>'.$internal.'</a></td>
        </tr>
        <tr>
            <td width="86">Eksternal</td>
            <td width="10">:</td>
            <td width="554"><a href='.$eksternal.'>'.$eksternal.'</a></td>
        </tr>     
        </table>
        <p><font color="#FF0000" size="-1">Perhatian email ini dikirim secara otomatis dari sistem HRIS. Jangan membalas ke alamat ini</font></p>
        </body>
        </html>';

        
        $mail->IsSMTP();
        $mail->Mailer       = "smtp";
        $mail->Host         = "Exc2013-DAG";
        $mail->Port         = 25;
        $mail->SMTPKeepAlive= true;
        $mail->SMTPAuth     = true;   
        $mail->From         = "system.noreply@unias.com";
        $mail->FromName     = "Human Resource Information System (HRIS)";
        $mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System (HRIS)');  
        $to = $data['email'];
        //$to = "dompak.sinambela@unias.com";
        $mail->Body = $body;    
        $mail->AddAddress($to);
        $mail->Subject  = "Reset Password HRIS";
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";     
        $mail->WordWrap   = 80; 
        $mail->IsHTML(true);    
        $mail->Send();  
        
    }
    catch (phpmailerException $e){
        echo $e->errorMessage();
    }


    echo"<script type='text/javascript'>alert('Reset password berhasil dan email sudah dikirim. Click OK to close window');window.open('', '_self', '');window.close();</script>";

}
?>