<?php
session_start();
error_reporting(0);
include "../../koneksi/koneksi.php";


if ($_GET['act']=='update'){

	send_mail_to_group_admin($session_nik=$_GET['nik'], $action='update', $subject='Notifikasi Perubahan Group Admin', $title='Kami informasikan bahwa ada <b>perubahan admin HRIS</b> untuk departemen.');

}
elseif ($_GET['act']=='insert'){

	send_mail_to_group_admin($session_nik=$_GET['nik'], $action='insert', $subject='Notifikasi Penambahan Group Admin', $title='Kami informasikan bahwa anda <b>menjadi admin HRIS</b> untuk departemen.');

}

elseif ($_GET['act']=='delete'){

	send_mail_to_group_admin($session_nik=$_GET['nik'], $action='delete', $subject='Notifikasi Penghapusan Group Admin', $title='Kami informasikan bahwa anda <b>tidak lagi menjadi admin HRIS</b> untuk departemen.');

}



function send_mail_to_group_admin($session_nik, $action, $subject, $title){

require_once 'class.phpmailer.php';	

	$query  = mysql_query('SELECT * FROM tbl_group_admin WHERE admin_group_nik='.$session_nik);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);



try {

	$mail = new PHPMailer(true);

	$body =
	'<html>
	<head>
	<style type=text/css>
	.style1 {
		font-size: 13px
	}
	.style4 {
		font-size: 13px;
		font-style: normal;
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
		font-size: 13px;
		font-weight: bold;
	}
	table {
		border: thin black solid;
	}

	ol {
  		list-style: decimal;
  		padding-left: 30px;
	}

    </style>
    
    
	<title>Detail Departemen</title>
	</head>
	<body>
		<p>Kepada YTH: '.get_name_nik($session_nik).'</p>
		<p>'.$title.'</p>
		<p><strong>Detail Departemen</strong></p>

		<table width="70%" border="0" cellpadding="0" cellspacing="0" frame="border" rules="rows">		
		<tr>		    
		    <th width="50%" height="18" class="style1">Form CV *</th>
		    <th width="50%" height="18" class="style1">Form Cuti *</th>
		</tr>
		<tr>		    
		    <th width="50%" height="18" class="style1"></th>
		    <th width="50%" height="18" class="style1"></th>
		</tr>

		<tr>		    
		    <td class="style1" valign="top"><div align="left">'.get_data_form_cv($session_nik).'</div></td>
		    <td class="style1" valign="top"><div align="left">'.get_data_form_cuti($session_nik).'</div></td>
		</tr>';

		$mail->Body     = $body;		

		$footer ='	
		</table>
		<ul>
	      <li>Form CV* : Admin bisa melihat dan mengunduh data curriculum vitae (CV) sesuai karyawan di departemen diatas</li>
	      <li>Form Cuti* : Admin menerima email notifikasi form cuti yang sudah di approved sesuai karyawan di departemen diatas</li>
	   
    	</ul>

		</br>
			<p><font color=#FF0000 size=-1>Perhatian email ini dikirim secara otomatis dari Human Resource Information System (HRIS). Jangan membalas ke alamat ini</font></p>
		</br>
		</br>
		</body>
		</html>';


	
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
	//$to = "dompak.sinambela@unias.com";
	$to = get_email_nik($session_nik);
	$mail->Body         .= $footer;		
	$mail->AddAddress($to);
	$mail->Subject       = $subject;
	$mail->AltBody       = "To view the message, please use an HTML compatible email viewer!"; 	
	$mail->WordWrap      = 80;	
	$mail->IsHTML(true);	
	$mail->Send();	
	
}
catch (phpmailerException $e){
	echo $e->errorMessage();
}	


}


function get_name_nik($session_nik){

	$query  = mysql_query("SELECT * FROM tbl_profile WHERE NIK='".$session_nik."'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    return $data['Nama'];

}

function get_email_nik($session_nik){

	$query  = mysql_query("SELECT * FROM tbl_profile WHERE NIK='".$session_nik."'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    return $data['Email'];

}


function get_data_form_cv($session_nik){

	$query  = mysql_query("SELECT * FROM tbl_group_admin INNER JOIN tbl_dept ON admin_form_cv=iDeptID INNER JOIN tbl_div ON iDivId=iDeptDivID INNER JOIN tbl_company ON iDivCompany=iCompanyId WHERE admin_group_nik='".$session_nik."'");
    $total  = mysql_num_rows($query);

    $no=1;

    $list ='<ol>';
    while ($data = mysql_fetch_array($query)){

    	$list .='<li>'.$data['cDeptName'].' ('.$data['cCompanyCode'].')</li>';

    $no++;
    }

    $list .='</ol>';

    return $list;
    

}


function get_data_form_cuti($session_nik){

	$query  = mysql_query("SELECT * FROM tbl_group_admin INNER JOIN tbl_dept ON admin_form_cuti=iDeptID INNER JOIN tbl_div ON iDivId=iDeptDivID INNER JOIN tbl_company ON iDivCompany=iCompanyId WHERE admin_group_nik='".$session_nik."'");
    $total  = mysql_num_rows($query);

    $no=1;

    $list ='<ol>';
    while ($data = mysql_fetch_array($query)){

    	$list .='<li>'.$data['cDeptName'].' ('.$data['cCompanyCode'].')</li>';

    $no++;
    }

    $list .='</ol>';

    return $list;
    

}

?>