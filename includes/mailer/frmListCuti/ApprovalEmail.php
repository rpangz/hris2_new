<?php
session_start();
error_reporting(0);
include "../../koneksi/koneksi.php";
//require 'terbilang.php';
$today 		= date ("Y-m-d H:i:s");

//$today 		= '2015-05-12';


$sqlURL1 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_services WHERE id=1"));
$sqlURL2 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_services WHERE id=2"));

$url 	= $sqlURL1['Url'];
$url1 	= $sqlURL2['Url'];


//$date     = strtotime($post_array['TglMasuk']);
//$TglMasuk = date('Y-m-d', $date);

$isa     		= strtotime($today);

//$jarak  = mysql_fetch_array(mysql_query("SELECT * FROM tbl_interval WHERE id=1"));

// Setiap 1 Hari akan dikirim emailnya

$TglExp 		= date('Y-m-d H:i:s',strtotime('-1 day',$isa));


/*
    $dws 	    = "SELECT * FROM `tbl_formcuti` INNER JOIN
				tbl_profile ON tbl_formcuti.FormCutiNIK = tbl_profile.NIK
				WHERE tbl_profile.bStatus=1 AND tbl_formcuti.StatusForm='P'
				AND tbl_formcuti.UpdatedTime <= '$TglExp'
				GROUP BY tbl_formcuti.FormCutiNIK
				ORDER BY tbl_formcuti.FormCutiNIK ASC";

                

*/
	$dws 	    = "SELECT * FROM `tbl_formcuti` INNER JOIN 
				tbl_profile ON tbl_formcuti.FormCutiNIK = tbl_profile.NIK 
				WHERE CutiId='$_GET[id]' AND tbl_profile.bStatus=1 AND tbl_formcuti.StatusForm='P'				
				ORDER BY tbl_formcuti.FormCutiNIK ASC";

                // AND tbl_formcuti.UpdatedTime >= '$TglExp'

				
	$que 		= mysql_query($dws);
	$tot 	    = mysql_num_rows($que);

//echo 'Jumlah Data: '.$tot.'<br/>';
//echo 'Tgl Expire: '.$TglExp.'<br/>';
//echo 'Hari Ini: '.$today;


while ($dw = mysql_fetch_array($que)){

    $data 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId = '$dw[CutiId]'"));
    $Pemohon 	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$dw[FormCutiNIK]'"));
    $gw     	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$dw[NIKPengganti]'"));

    $MyNIK      = $dw['FormCutiNIK'];

    $proses     = $dw['ApvLevel'];

    if ($proses == '1'){
        $before   = '';
        $txttoken = 'Pin'.$before;
        //$txtApvbefore  = $data['Apv1'];

        $mytoken = $data[$txttoken];

    }
    else {
        $before   = $proses-1;
        $txttoken = 'Pin'.$before;
        $mytoken = $data[$txttoken];
        //$txtApvbefore  = $data['Apv'.$before];
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
    //$btn_mail = 'cKBEmail'.$proses;

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

        mysql_query("UPDATE tbl_formcuti SET UpdatedTime = '$today' WHERE CutiId = '$dw[CutiId]' AND $txttoken = '$mytoken'");





    }
    else {
        $next = $proses;
        $bSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId = '$dw[CutiId]'"));
        $NIKEmail 	= $bSQL['NIK'.$next];
        $aSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$NIKEmail'"));
        $StatusApproval = 'Klik link dibawah ini untuk proses selanjutnya';


        $link1 = $url.'ServicesApproval.php?act=accept&id='.$dw['CutiId'].'&mynik='.$MyNIK.'&token='.$mytoken.'&proses='.$proses;
        $link2 = $url.'ServicesApproval.php?act=reject&id='.$dw['CutiId'].'&mynik='.$MyNIK.'&token='.$mytoken.'&proses='.$proses;
        $link3 = $url1.'kehadiran/frmCuti/edit/'.$dw['CutiId'].'?mynik='.$MyNIK.'&token='.$mytoken;

        $Accept = 'Accept';
        $Reject = 'Reject';

        //$link1 = $url.'ServicesApproval.php?act=accept&id='.$_GET['id'].'&mynik='.$MyNIK.'&token='.$token.'&proses='.$next;
        //$link2 = $url.'ServicesApproval.php?act=reject&id='.$ID.'&mynik='.$MyNIK.'&token='.$token.'&proses='.$next;

        mysql_query("UPDATE tbl_formcuti SET UpdatedTime = '$today' WHERE CutiId = '$dw[CutiId]' AND $txttoken = '$mytoken'");

    }


    require_once 'class.phpmailer.php';

    try {

        $mail = new PHPMailer(true);

        $body =
            "<html>
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


<title>Detail Permohonan Cuti</title>
	</head>
<body>
    <p>Dear, $si_approval</p><br/>
    Proses Approval berhenti di Anda, Mohon Permohonan Cuti dibawah ini diproses.

	<p><strong>Detail Permohonan Cuti</strong></p>
<table width='550' height='270' border='0' cellpadding=0 cellspacing=0 frame=border rules=rows>

<tr>
    <td width='120' height=18 class=style1>NIK</td>
    <td width='10'><span class=style1>:</span></td>
    <td><span class=style1>$data[FormCutiNIK]</span></td>
</tr>

<tr>
    <td width='120' height=18 class=style1>Nama</td>
    <td width='10'><span class=style1>:</span></td>
    <td><span class=style1>$profile[Nama]</span></td>
</tr>

<tr>
    <td width='120' height=18 class=style1>Jenis Cuti</td>
    <td width='10'><span class=style1>:</span></td>
    <td><span class=style1>".jenis_cuti($data['JenisCuti'],$data['JenisItemCuti'])."</span></td>
</tr>

<tr>
    <td height=18 class=style1>Keperluan</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$data[Keperluan]</span></td>
</tr>
<tr>
    <td height=18 class=style1>Alamat</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$data[Alamat]</span></td>
</tr>
<tr>
    <td height=18 class=style1>No Telepon</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$data[NoTelpon]</span></td>
</tr>
<tr>
    <td height=18><span class=style1>Petugas Pengganti</span></td>
    <td><span class=style1>:</span></td>
    <td><span class=style4>$gw[Nama]</span></td>
</tr>

";

        $mail->Body     = $body;
//$StatusApproval = 'Klik link dibawah ini untuk proses selanjutnya';

// Tanggal Cuti
        $Cuti  = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId=$dw[CutiId]");
        $total = mysql_num_rows($Cuti);
        if ($data['JenisItemCuti'] <= 9){
            $total_cut = mysql_num_rows($Cuti);
            $tgl_cut   = '';
        }
        else{
            $total_cut = count_days($dw['CutiId']);
            $tgl_cut   = active_days($dw['CutiId']);
        }

        $kont1 ="<tr>
    		<td height=18><span class=style1>Jumlah Cuti</span></td>
    		<td><span class=style1>:</span></td>
    		<td><span class=style4>".$total_cut." Hari ".$tgl_cut."</span></td>
		</tr>
		<tr>
			<td rowspan='$total' height=18 class=style1>Tanggal Cuti</td>
			<td rowspan='$total'><span class=style1>:</span></td>";

        $mail->Body .= $kont1;


        while ($dst = mysql_fetch_array($Cuti)){

            $Tgl = date('d-M-Y', strtotime($dst['TglCuti']));
            $day = date('N', strtotime($dst['TglCuti']));

            if ($day==1){
                $nDay = 'Senin';
            }
            elseif ($day==2){
                $nDay = 'Selasa';
            }
            elseif ($day==3){
                $nDay = 'Rabu';
            }
            elseif ($day==4){
                $nDay = 'Kamis';
            }
            elseif ($day==5){
                $nDay = 'Jumat';
            }
            elseif ($day==6){
                $nDay = 'Sabtu';
            }
            elseif ($day==7){
                $nDay = 'Minggu';
            }
            else{
                $nDay = '';
            }

            $MyCuti[$dst['DetailCutiId']]="

		<td><span class=style1>$nDay , $Tgl</span></td>
	</tr>";
            $mail->Body .= $MyCuti[$dst['DetailCutiId']];
        }


        $kont2 ="</tr><tr>
    		<td height=18><span class=style1>Tanggal Masuk Kerja</span></td>
    		<td><span class=style1>:</span></td>
    		<td><span class=style4>$nDayin , $TglMasuk</span></td>
		</tr>";

        $mail->Body .= $kont2;



        $ApvList = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode='1' AND MatStatus='1'");

        while ($data = mysql_fetch_array($ApvList)){

            $sql      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId='$dw[CutiId]'"));
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
        <tr>
        <td height=18 class=style1>Attachment</td>
        <td><span class=style1>:</span></td>
        <td><span class=style1>".files_cuti($dw['CutiId'])."</span></td>   
    </tr>
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
        $mSet = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_mail_server WHERE Status='1' AND Folder='frmCuti' ORDER BY id DESC LIMIT 1"));

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
        $mail->Subject       = "Permohonan Cuti - Reminder";
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


function jenis_cuti($id,$item){

    $sql1           = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id=".$id));
    $JenisCuti      = $sql1['JenisCutiName'];
    $sql2           = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti_item WHERE JenisItemCutiId=".$item));
    $JenisItemCuti  = $sql2['JenisItemCutiName'];

    if ($item != 0){
        $add = '('.$JenisItemCuti.')';
    }else{
        $add = '';
    }

    return '<b>'.$JenisCuti.'</b> '.$add;

}

function files_cuti($id){

    $server_publish = 'appservices.unias.com';

    $file  = mysql_query("SELECT * FROM tbl_formcuti_files WHERE cuti_id='$id'");
    $total = mysql_num_rows($file);
    if ($total > 0){        
        $link = '';
    }else{
        $link = '-';
    }
    while ($data = mysql_fetch_array($file)){
        $link   .= '<a href="http://'.$server_publish.'/hris2/modules/kehadiran/assets/uploads/'.$data['url'].'" target="_blank">'.$data['file_code'].'</a><br/>';
    }

    return $link;

}

function count_days($id){

    $query  = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId='$id'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    $startTimeStamp = strtotime($data['TglActive1']);
    $endTimeStamp   = strtotime($data['TglActive2']);
    $timeDiff       = abs($endTimeStamp - $startTimeStamp);
    $numberDays     = $timeDiff/86400;  // 86400 seconds in one day
    $numberDays     = intval($numberDays+1);

    return $numberDays;

}


function active_days($id){

    $query  = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId='$id'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    $TglActive1   = date('d-M-Y', strtotime($data['TglActive1']));
    $TglActive2   = date('d-M-Y', strtotime($data['TglActive2']));

    return '('.$TglActive1.' s/d '.$TglActive2.')';

}


?>