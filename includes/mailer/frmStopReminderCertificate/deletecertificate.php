<?php 
session_start();
error_reporting(0);


$servername = "https://".$_SERVER['SERVER_NAME']."/hris2/certificate/frmStopReminderCertificate/";


include "../../koneksi/koneksi.php";
$today   = date ("Y-m-d H:i:s");
$date    = date ("d-M-Y");

$alphaNumeric   = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ0123456789";
$random         = substr(str_shuffle($alphaNumeric), 0, 7);
$NewPassword    = md5($random);
$certid = $_GET['certid']; 
$userid = $_GET['userid']; 




if(isset($_POST['action']) && !empty($_POST['action'])) {

    $action = $_POST['action'];
    $parameter = $_POST['parameter'];
    $alasan = $_POST['alasan'];
    $userid = $_POST['userid'];
    echo prosesdata($parameter,$alasan,$userid);

} else {

?>
<body onload="loadprompt()">


     <div id="loadingdiv" class="content">
        <label style="font-size: 18px; visibility: hidden;" id="loadingajaxlabel">PLEASE WAIT <br> UPDATE DATA. . .</label><br>
        <img src="loader2.gif" id="loadingajax" style="visibility: hidden;">
     </div>



    <style type="text/css">
        .content {
       
            width: 250px;
            height: 250px;
            text-align: center;

            position:absolute; /*it can be fixed too*/
            left:0; right:0;
            top:0; bottom:0;
            margin:auto;

            /*this to solve "the content will not be cut when the window is smaller than the content": */
            max-width:100%;
            max-height:100%;

        }    
    </style>

    <link rel="stylesheet" type="text/css" href="https://localhost/hris2/assets/bootstrap/css/bootstrap.min.css">
    <!-- JS dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap 4 dependency -->
    <script src="popper.min.js"></script>
    <script src="https://localhost/hris2/assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- bootbox code -->
    <script src="bootbox.min.js"></script>
    <script src="bootbox.locales.min.js"></script>
    <script>
        
        function loadprompt(){
           bootbox.prompt({
                title: "Alasan Hapus Sertifikasi : ",
                inputType: 'textarea',
                callback: function (result) {
                    if(result==null) {
                        window.location = "<?php echo $servername; ?>";
                    }
                    else if(result=="") {
                        alert("Alasan Belum Di Isi");
                        window.location = "<?php echo $servername; ?>";
                    }
                    else
                    {
                        $.ajax({ url: 'deletecertificate.php',
                                 data: {action: 'proses',parameter: '<?php echo $certid; ?>',alasan: result,userid: '<?php echo $userid; ?>' },
                                 type: 'post',
                                 success: function(output) {
                                              document.getElementById("loadingajax").style.visibility = "hidden";
                                              document.getElementById("loadingajaxlabel").innerHTML  = "Proses Data Berhasil . . . <br> Direct To Page . . .";
                                              alert(output);
                                              window.location = "<?php echo $servername; ?>";
                                              console.log(output);
                                        }
                        });
                    }

                    
                }
            }); 
        }

            
            $(document).ready(function () {
                $(document).ajaxStart(function () {
                    document.getElementById("loadingajax").style.visibility = "visible";
                    document.getElementById("loadingajaxlabel").style.visibility = "visible";                                     
                }).ajaxStop(function () {
                    document.getElementById("loadingajax").style.visibility = "hidden";
                    document.getElementById("loadingajaxlabel").style.visibility = "hidden";                  
                });
            });

        
    </script>
</body>

</html>


<?php
   
}

?>



<?php

//======================================================= ALL PHP FUNCTION =====================================

function prosesdata($certid,$alasan,$userid) {

        $mysqlcomm = "INSERT INTO tbl_profile_certification_hapus
                      SELECT CertId, CertNIK, CertDate, CertItem, CertProduct, CertName, CertPartnerName, CertValidStart,
                      CertValidFinish, CertFileName, CertFileUrl, CertStatus, CertApv, CertProcessId,
                      CertCreatedBy, CertCreatedTime, CertUpdatedBy, CertUpdatedTime, '".$alasan."' alasan, '".$userid."' deluser, now() deltime
                      FROM tbl_profile_certification WHERE certid = '".$certid."'";       
        $query  = mysql_query($mysqlcomm);
        $query  = mysql_query("DELETE FROM tbl_profile_certification WHERE CertId='".$certid."'");       
        
/*
        $mysqlcomm = "";
        $mysqlcomm = "SELECT a.user_id,a.email,c.nama FROM tbl_main_user a
                               INNER JOIN tbl_profile_certification b ON a.user_id=b.certnik
                               INNER JOIN tbl_profile c ON a.user_id=c.nik
                               WHERE b.certid = '".$certid."'" ;
        $query  = mysql_query($mysqlcomm);
        while ($data = mysql_fetch_array($query)){
            $nik = $data['user_id'];
            $email = $data['email'];
            $nama = $data['nama']." ( KARYAWAN )";
        }        
        send_email_stop_reminder_certificate($certid,$nik,$email,$nama);
        $nik = "";$email = "";$nama = "";
        sendmailtohrd($certid);
        $nik = "";$email = "";$nama = "";
        sendmailtoatasan($certid);
*/
        echo "Delete Certificate Berhasil, Klik OK Untuk Kembali Ke List Data";        
        //return "berhasil";
        
}

function sendmailtoatasan($certid){
    $query = "";
    $mysqlcomm = "SELECT a.nama,a.nik,a.email FROM tbl_profile a
                  INNER JOIN (SELECT nik1 FROM tbl_profile WHERE nik = '".getcertnik($certid)."') b ON a.nik=b.nik1" ;
    //echo $mysqlcomm
    $query  = mysql_query($mysqlcomm);    
    while ($data = mysql_fetch_array($query)){
        $nik = $data['nik'];
        $nama = $data['nama']." ( ATASAN )";
        $email = $data['email'];           
        send_email_stop_reminder_certificate($certid,$nik,$email,$nama);
    }
}

function sendmailtohrd($certid){
        $query = "";
        $mysqlcomm = "  SELECT b.nik,b.nama,b.email,cDeptName FROM tbl_main_group_user a
                        INNER JOIN tbl_profile b ON a.user_id=b.nik
                        INNER JOIN tbl_dept c ON b.deptid=c.iDeptId
                        WHERE group_id = 59  " ;
        $query  = mysql_query($mysqlcomm);
        while ($data = mysql_fetch_array($query)){
            $nik = $data['nik'];
            $deptname = $data['cDeptName'];
            $nama = $data['nama']." ( ".$deptname." )";
            $email = $data['email'];           
            send_email_stop_reminder_certificate($certid,$nik,$email,$nama);
        }
        //return $nik;
}


function getcertnik($certid) {
   
        $query = "";
        $mysqlcomm = "SELECT CertNIK FROM tbl_profile_certification WHERE certid = '".$certid."'" ;
        $query  = mysql_query($mysqlcomm);
        while ($data = mysql_fetch_array($query)){
            $nik = $data['CertNIK'];
        }

        return $nik;
}

function send_email_stop_reminder_certificate($certid,$nik,$email,$nama){

    $date   = date ("d-M-Y");
    $dir_url= $_SERVER['SERVER_NAME'].'/hris2/';
    


    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    $internal  = 'https://apps.unias.com/hris2/';
    $eksternal = 'https://apps.unias.com/hris2/';


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
        <p><strong>BERIKUT DATA SERTIFIKAT YANG TIDAK DI LANJUTKAN KEMBALI </strong></p>
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

          $mysqlcomm2 = "";
          $mysqlcomm2 = "SELECT CertNik,Nama,CertDate,CertName,CertProduct,CertPartnerName,CertValidStart,CertValidFinish,CertFileUrl,CompanyId,DeptID FROM tbl_profile_certification a 
                         INNER JOIN tbl_profile b ON a.certnik=b.nik 
                         WHERE certid='".$certid."'";              
          $query  = mysql_query($mysqlcomm2);
            while ($data = mysql_fetch_array($query)){
                       
  
                $detail[$no]='<tr>
                                <td bgcolor='.color_td($no).'><div align="center">'.$no.'</div></td>
                                <td bgcolor='.color_td($no).'><div align="center">'.$data['CertNik'].'</div></td>
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
        $mail->SMTPAuth     = true;   
        $mail->From         = "system.noreply@unias.com";
        $mail->FromName     = "Human Resource Information System (HRIS)";
        $mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System (HRIS)');  
        //$to = $email;
        $to = "ronaldo.pangasian@unias.com";
        //$to = "dompak.sinambela@unias.com";
        $mail->AddAddress($to);
        $mail->Subject  = "Pemberhentian Reminder Sertifikasi";
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";     
        $mail->WordWrap   = 80; 
        $mail->IsHTML(true);    
        $mail->Send();
        //echo $mail->Body;
        
    }
    catch (phpmailerException $e){
        echo $e->errorMessage();
    }


    //echo"<script type='text/javascript'>alert('Stop Reminder berhasil dan Email Telah Dikirim. Click OK to close window');window.open('', '_self', '');window.close();</script>";

}

function color_td($value){
    if ($value %2==0){
        return '#F7F7F7';
    }
    else{
        return '';
    }
}

function date_format_txt($value){

    if (!is_null($value) && !empty($value)){
        $date = date('d-M-Y', strtotime($value));
    }else{
        $date = '';
    }

    return $date;

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

?>