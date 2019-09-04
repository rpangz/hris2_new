<?php
session_start();
error_reporting(0);
include "../../koneksi/koneksi.php";

$today 		= date ("Y-m-d H:i:s");

$sqlURL1 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_services WHERE id=4"));
$sqlURL2 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_services WHERE id=2"));

$url 	= $sqlURL1['Url'];
$url1 	= $sqlURL2['Url'];


	$dws 	    = "SELECT * FROM `tbl_formijin` INNER JOIN 
				tbl_profile ON tbl_formijin.NIK = tbl_profile.NIK 
				WHERE IjinId='$_GET[id]' AND tbl_profile.bStatus=1 AND tbl_formijin.StatusForm='P'				
				ORDER BY tbl_formijin.NIK ASC";

				
	$que 		= mysql_query($dws);
	$tot 	    = mysql_num_rows($que);


while ($dw = mysql_fetch_array($que)){

    $data 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_formijin WHERE IjinId = '$dw[IjinId]'"));
    $Pemohon 	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$dw[NIK]'"));
    

    $MyNIK      = $dw['NIK'];

    $proses     = $dw['ApvLevel'];

    if ($proses == '1'){
        $before   = '';
        $txttoken = 'Pin'.$before;
        $mytoken = $data[$txttoken];

    }
    else {
        $before   = $proses-1;
        $txttoken = 'Pin'.$before;
        $mytoken = $data[$txttoken];
    }

    $prosesn    = $data['ApvLevel'];
    $txtApv     = $data['Apv'.$prosesn];
    $txtTgl     = $data['Tgl'.$prosesn];
    $txtNIK     = $data['NIK'.$prosesn];
    $txtPin     = $data['Pin'.$prosesn];

    $btn_Apv    = 'Apv'.$prosesn;
    $btn_Tgl    = 'Tgl'.$prosesn;
    $btn_NIK    = 'NIK'.$prosesn;
    $btn_Pin    = 'Pin'.$prosesn;
    $btn_Remark = 'Remark'.$prosesn;

    $txtApvbefore  = $data['Apv'.$proses];

    $TglMasuk = date('d-M-Y', strtotime($data['TglMasuk']));

    $dayin = date('N', strtotime($data['TglMasuk']));

    if ($dayin==1){
        $nDayin = 'Senin';
    }
    elseif ($dayin==2){
        $nDayin = 'Selasa';
    }
    elseif ($dayin==3){
        $nDayin = 'Rabu';
    }
    elseif ($dayin==4){
        $nDayin = 'Kamis';
    }
    elseif ($dayin==5){
        $nDayin = 'Jumat';
    }
    elseif ($dayin==6){
        $nDayin = 'Sabtu';
    }
    elseif ($dayin==7){
        $nDayin = 'Minggu';
    }
    else{
        $nDayin = '';
    }

    $profile  = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$MyNIK'"));
    $profile2 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$data[$btn_NIK]'"));

    $pt      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_company WHERE iCompanyId='$profile[CompanyId]'"));

    $si_approval = $profile2['Nama'];

    if ($JmlProses == $proses){

        $aSQL 		    = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$data[$btn_NIK]'"));
        $StatusApproval = 'Proses Approval Sudah Selesai';
        $next = $proses;

        $link1 = '';
        $link2 = '';
        $link3 = '';

        $Accept = '';
        $Reject = '';



    }
    else {
        $next = $proses;
        $bSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_formijin WHERE IjinId = '$dw[IjinId]'"));
        $NIKEmail 	= $bSQL['NIK'.$next];
        $aSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$NIKEmail'"));
        $StatusApproval = 'Klik link dibawah ini untuk proses selanjutnya';


        $link1 = $url.'ServicesApproval.php?act=accept&id='.$dw['IjinId'].'&mynik='.$MyNIK.'&token='.$mytoken.'&proses='.$proses;
        $link2 = $url.'ServicesApproval.php?act=reject&id='.$dw['IjinId'].'&mynik='.$MyNIK.'&token='.$mytoken.'&proses='.$proses;
        $link3 = $url1.'kehadiran/frmIjin/edit/'.$dw['IjinId'].'?mynik='.$MyNIK.'&token='.$mytoken;

        $Accept = 'Accept';
        $Reject = 'Reject';


    }

    if (!is_null($data['TglActive1'])){
        $TglActive1 = date('d-M-Y', strtotime($data['TglActive1']));
        $Pkl1       = 'Pukul: '.date('H:i', strtotime($data['TglActive1'])).' WIB';
    }
    else{
        $TglActive1 = '';
        $Pkl1       = '';
    }


    if (!is_null($data['TglActive2'])){
        $TglActive2 =  date('d-M-Y', strtotime($data['TglActive2']));
        $Pkl2       = 'Pukul: '.date('H:i', strtotime($data['TglActive2'])).' WIB';
    }
    else{
        $TglActive2 = '-';
        $Pkl2       = '';
    }


    $jka      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jenisijin WHERE JenisIjinId='$data[JenisIjin]'"));


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
    
    
    <title>Detail Permohonan Ijin - '.$jka['JenisIjinName'].'</title>
        </head>
    <body>
        <p><strong>Detail Permohonan Ijin - '.$jka['JenisIjinName'].'</strong></p>
    <table width="550" height="270" border="0" cellpadding="0" cellspacing="0" frame="border" rules="rows">  
        
    <tr>
        <td width="120" height="18" class="style1">PT.</td>
        <td width="10"><span class="style1">:</span></td>
        <td><span class="style1"><strong>'.$pt['cCompanyName'].'</strong></span></td>
    </tr>
    <tr>
        <td width="120" height="18" class="style1">Form Ijin</td>
        <td width="10"><span class="style1">:</span></td>
        <td><span class="style1">'.$jka['JenisIjinName'].'</span></td>
    </tr>
    <tr>
        <td width="120" height="18" class="style1">NIK</td>
        <td width="10"><span class="style1">:</span></td>
        <td><span class="style1">'.$data['NIK'].'</span></td>
    </tr>
    <tr>
        <td width="120" height="18" class="style1">Nama</td>
        <td width="10"><span class="style1">:</span></td>
        <td><span class="style1">'.$profile['Nama'].'</span></td>
    </tr>        
    <tr>
        <td height="18" class="style1">Dari Tanggal</td>
        <td><span class="style1">:</span></td>
        <td><span class="style1">'.$TglActive1.' '.$Pkl1.'</span></td>
    </tr>
    <tr>
        <td height="18" class="style1">Sampai Tanggal</td>
        <td><span class="style1">:</span></td>
        <td><span class="style1">'.$TglActive2.' '.$Pkl2.'</span></td>
    </tr>
    <tr>
        <td height="18" class="style1">Alasan</td>
        <td><span class="style1">:</span></td>
        <td><span class="style1">'.$data['Alasan'].'</span></td>
    </tr>';

        $mail->Body     = $body;       



        $ApvList = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode='4' AND MatStatus='1'");

        while ($data = mysql_fetch_array($ApvList)){

            $sql      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formijin WHERE IjinId='$dw[IjinId]'"));
            $no       = $data['MatProses'];
            $Approval = 'NIK'.$no;
            $Apv   	  = $sql['Apv'.$no];
            $Tgl      = $sql['Tgl'.$no];
            $NIK      = $sql['NIK'.$no];

            if (is_null($Tgl) || $Tgl ==" "){
                $cTgl = '';
            }
            else{
                $cTgl = date('@ d-M-Y H:i', strtotime($Tgl));
            }

            if ($Apv =='A'){
                $cStatus = '- ACCEPTED';
            }
            elseif($Apv =='R'){
                $cStatus = '- REJECTED';
            }
            elseif($Apv =='X'){
                $cStatus = '- CANCELED';
            }
            elseif($Apv =='P'){
                $cStatus = '';
            }
            else{
                $cStatus = '';
            }

            $ProfileName = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$NIK'"));
            $approvallist[$data['MatProses']]="

	<tr>
		<td height=18 class=style1>$data[MatName]</td>
		<td><span class=style1>:</span></td>
		<td><span class=style1>$ProfileName[Nama], $cTgl $cStatus</span></td>
	</tr>";
            $mail->Body .= $approvallist[$data['MatProses']];
        }

        $footer ="
        
	</table>
	</br>

	</br>
	<p><font color=#FF0000 size=-1>$StatusApproval</font></p>
	<a href='$link1' onClick=window.open('$url/ServicesApproval.php',Ratting,width=550,height=170,0,status=0,);>$Accept</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href='$link2' onClick=window.open('$url/ServicesApproval.php',Ratting,width=550,height=170,0,status=0,);>$Reject</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</br>
	</br>
	</body>
	</html>";


        // Setting Email **
        $mSet = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_mail_server WHERE Status='1' AND Folder='frmIjin' ORDER BY id DESC LIMIT 1"));

        $mail->IsSMTP();
        $mail->Mailer     	= "smtp";
        $mail->Host       	= "Exc2013-DAG";
        $mail->Port       	= 25;
        $mail->SMTPKeepAlive= true;
        $mail->SMTPAuth     = true;
        $mail->Priority     = 1;
        $mail->From         = "system.noreply@unias.com";
        $mail->FromName     = "Human Resource Information System";
        $mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');
        $to = "$aSQL[Email]";
        //$to = "dompak.sinambela@unias.com";
        $mail->Body         .= $footer;
        $mail->AddAddress($to);
        //$mail->Subject       = "$mSet[Subject]";
        $mail->Subject       = "$mSet[Subject] - $jka[JenisIjinName]";
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

echo"<script type='text/javascript'>alert('Email Berhasil Dikirim. Click OK to close window');window.open('', '_self', '');window.close();</script>";




?>