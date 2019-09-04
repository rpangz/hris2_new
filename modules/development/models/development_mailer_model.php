<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class development_mailer_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
        $this->load->helper('url');
	}


	public function mailer_form_kasbon($primary_key, $session_nik){

    	       
    	require_once (APPPATH.'modules/development/model/class.phpmailer.php');

		try {

		$mail = new PHPMailer(true);

		$body =
		'<html>
		<head>
		<style type=text/css>

		body {
			font-family: arial;
			font-size:12px;
		}
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

		table td {		    
		    display:table-cell;
		    vertical-align:middle;
		    height:20px;
		}

	    </style>
    
    
		<title>Form Pengajuan Kasbon</title>
		</head>
			<body>
			<p><strong>KPI</strong></p>
				<table class="table" width="900" border="0" cellspacing="1" cellpadding="1" frame="border" rules="rows">
				  <tr>
				    <td>TEST</td>
				  </tr>
				</table>
			</br>
			<p><font color="#FF0000" size="-1">Perhatian email ini dikirim secara otomatis dari System. Jangan membalas ke alamat ini</font></p>
			</br>
			</body>
		</html>';
	
	
		$mail->IsSMTP();
		$mail->Mailer     	= "smtp";
		$mail->Port       	=  25;
		$mail->SMTPKeepAlive= true;
		$mail->SMTPAuth     = true;
		$mail->Priority     = 1;
		$mail->From         = "HRIS";
		$mail->FromName     = "HRIS";
		$mail->SetFrom('hris.noreply@unias.com', 'HRIS');
		//$to = $this->cms_user_email($session_nik);
		$to = "dompak.sinambela@unias.com";
		$mail->Body         = $body;		
		$mail->AddAddress($to);
		$mail->Subject       = "[KPI]";
		$mail->AltBody       = "To view the message, please use an HTML compatible email viewer!"; 	
		$mail->WordWrap      = 80;	
		$mail->IsHTML(true);	
		$mail->Send();	
		
		}
		catch (phpmailerException $e){
			echo $e->errorMessage();
		}   	
		
    }

	


}
