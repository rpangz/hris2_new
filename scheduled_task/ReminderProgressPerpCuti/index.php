<?php
session_start();
error_reporting(0);
include "../koneksi/koneksi.php";
$today 		= date ("Y-m-d H:i:s");


$sqlURL1 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_services WHERE id=3"));
$sqlURL2 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_services WHERE id=2"));

$url 	= $sqlURL1['Url'];
$url1 	= $sqlURL2['Url'];

$isa     		= strtotime($today);

$TglExp 		= date('Y-m-d H:i:s',strtotime('-1 day',$isa));


$dws 	    = "SELECT * FROM `tbl_formperpcuti` INNER JOIN 
				tbl_profile ON tbl_formperpcuti.NIK = tbl_profile.NIK 
				WHERE tbl_profile.bStatus=1 AND tbl_formperpcuti.StatusForm='P'				
				ORDER BY tbl_formperpcuti.NIK ASC";               

				
$que 		= mysql_query($dws);
$tot 	    = mysql_num_rows($que);

echo 'Jumlah Data: '.$tot.'<br/>';
echo 'Tgl Expire: '.$TglExp.'<br/>';
echo 'Hari Ini: '.$today;


while ($dw = mysql_fetch_array($que)){

    $data 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId= '$dw[FormPerpCutiId]'"));
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


    $profile  = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$MyNIK'"));
    $profile2 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK='$data[$btn_NIK]'"));

    $si_approval = $profile2['Nama'];


    $kcu     = mysql_fetch_array(mysql_query("SELECT * FROM tbl_hakcuti WHERE HakId='$data[HakCutiId]'"));

    $Periode1 = date('d-M-Y', strtotime($kcu['Periode1']));
    $Periode2 = date('d-M-Y', strtotime($kcu['Periode2']));


    $jka      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id='$kcu[JenisHakCuti]'"));

    $LimitExp = $jka['LimitExp'];
    $soon     = date('Y-m-d', strtotime($kcu['Periode2']. ' + '.$LimitExp));
    $soon2    = date('d-M-Y', strtotime($soon));
            

    $dta = mysql_fetch_array(mysql_query('SELECT count(FormCutiNIK) AS QtyPakai FROM tbl_formcuti INNER JOIN 
                                                    tbl_formcutidetail ON tbl_formcuti.CutiId = tbl_formcutidetail.CutiId 
                                                    WHERE tbl_formcuti.FormCutiNIK="'.$MyNIK.'" AND HakCutiId="'.$data['HakCutiId'].'" 
                                                    AND StatusForm="A" '));


    $Qty      = $kcu['Qty'];
    //$QtyPakai = $dta['QtyPakai'];
    $QtyPakai = check_jumlah_cuti($MyNIK, $data['HakCutiId']);
    $Sisa     = $Qty - $QtyPakai;


    if ($JmlProses == $proses){

        $aSQL 		    = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$data[$btn_NIK]'"));
        $StatusApproval = 'Proses Approval Sudah Selesai';
        $next   = $proses;

        $link1  = '';
        $link2  = '';
        $link3  = '';

        $Accept = '';
        $Reject = '';

        mysql_query("UPDATE tbl_formperpcuti SET UpdatedTime = '$today' WHERE FormPerpCutiId= '$dw[FormPerpCutiId]' AND $txttoken = '$mytoken'");





    }
    else {
        $next = $proses;
        $bSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId = '$dw[FormPerpCutiId]'"));
        $NIKEmail 	= $bSQL['NIK'.$next];
        $aSQL 		= mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$NIKEmail'"));
        $StatusApproval = 'Klik link dibawah ini untuk proses selanjutnya';


        $link1 = $url.'ServicesApproval.php?act=accept&id='.$dw['FormPerpCutiId'].'&mynik='.$MyNIK.'&token='.$mytoken.'&proses='.$proses;
        $link2 = $url.'ServicesApproval.php?act=reject&id='.$dw['FormPerpCutiId'].'&mynik='.$MyNIK.'&token='.$mytoken.'&proses='.$proses;
        $link3 = $url1.'kehadiran/frmPerpCuti/edit/'.$dw['FormPerpCutiId'].'?mynik='.$MyNIK.'&token='.$mytoken;

        $Accept = 'Accept';
        $Reject = 'Reject';

        //$link1 = $url.'ServicesApproval.php?act=accept&id='.$_GET['id'].'&mynik='.$MyNIK.'&token='.$token.'&proses='.$next;
        //$link2 = $url.'ServicesApproval.php?act=reject&id='.$ID.'&mynik='.$MyNIK.'&token='.$token.'&proses='.$next;

        mysql_query("UPDATE tbl_formperpcuti SET UpdatedTime = '$today' WHERE FormPerpCutiId = '$dw[FormPerpCutiId]' AND $txttoken = '$mytoken'");

    }


    require_once 'class.phpmailer.php';

    try {

        $mail = new PHPMailer(true);

$body =
    "<html>
    <head>
    <style type=text/css>
    .style1 {
        font-size: 13px
    }
    .style4 {
        font-size: 13px; font-style: normal;
    }

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
    .style7 {
        font-size: 13px; font-weight: bold;
    }
    table {
        border: thin black solid;
    }
    </style>
    
    
<title>Detail Permohonan Perpanjangan Sisa Cuti</title>
    </head>
<body>
 <p>Dear, $si_approval</p><br/>
    Proses Approval berhenti di Anda, Mohon Form dibawah ini diproses.

    <p><strong>Detail Permohonan Perpanjangan Sisa Cuti</strong></p>
<table width='550' height='270' border='0' cellpadding=0 cellspacing=0 frame=border rules=rows>  
    
<tr>
    <td width='120' height=18 class=style1>NIK</td>
    <td width='10'><span class=style1>:</span></td>
    <td><span class=style1>$data[NIK]</span></td>
</tr>
<tr>
    <td width='120' height=18 class=style1>Nama</td>
    <td width='10'><span class=style1>:</span></td>
    <td><span class=style1>$profile[Nama]</span></td>
</tr>    
<tr>
    <td height=18 class=style1>Periode Cuti</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$Periode1 s/d $Periode2  #".$data['HakCutiId']."</span></td>
</tr>
<tr>
    <td height=18 class=style1>Diperpanjang Sampai</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$soon2</span></td>
</tr>
<tr>
    <td height=18 class=style1>Jenis Cuti</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$jka[JenisCutiName]</span></td>
</tr>

<tr>
    <td height=18 class=style1>Sisa Cuti</td>
    <td><span class=style1>:</span></td>
    <td><span class=style1>$Sisa</span></td>
</tr>

";

$mail->Body     = $body;



        $ApvList = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode='2' AND MatStatus='1'");

        while ($data = mysql_fetch_array($ApvList)){

            $sql      = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId='$dw[FormPerpCutiId]'"));
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
	</html>
    <br/>
    <br/>";


        // Setting Email **
        $mSet = mysql_fetch_array(mysql_query("SELECT * FROM tbl_apv_mail_server WHERE Status='1' AND Folder='frmPerpCuti' ORDER BY id DESC LIMIT 1"));

        $mail->IsSMTP();
        $mail->Mailer     	= "smtp";
        $mail->Host       	= "Exc2013-DAG";
        $mail->Port       	= 25;
        $mail->SMTPKeepAlive= true;
        $mail->SMTPAuth     = true;
        $mail->Priority     = 1;
        $mail->From         = "hris.noreply@unias.com";
        $mail->FromName     = "HRIS";
        $mail->SetFrom('hris.noreply@unias.com', 'HRIS');
        $to = "$aSQL[Email]";
        //$to = "dompak.sinambela@unias.com";
        $mail->Body         .= $footer;
        $mail->AddAddress($to);
        //$mail->Subject       = "$mSet[Subject]";
        $mail->Subject       = "Permohonan Perpanjangan Sisa Cuti - Reminder";
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

function check_jumlah_cuti($user_nik, $hak_cuti){

        $query  = mysql_query("select count(b.DetailCutiId) as Jumlah from tbl_formcuti as a inner join tbl_formcutidetail as b on a.CutiId=b.CutiId 
            where a.FormCutiNIK=".$user_nik." and a.HakCutiId=".$hak_cuti." and a.StatusForm='A'");

        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);        
        
        return $data['Jumlah'];
}   





?>