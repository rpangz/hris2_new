<?php
/*

@Name			: SendMail function
@Purpose		: Sending mail with automation for reminder user to realize or outstanding
				  Kasbon which has procesed using e-Kasbon System for each admin officer
@Created By		: Dompak Petrus
@Creaded date	: 03-Sep-2014
@Updateed date	: -
@Application	: e-Kasbon System

*/

class SendMail
{
	var $NIK;
	var $Email;	
	
	private $dbHost	= 'portal';
	private $dbUser	= 'root';
	private $dbPass	= 'asa';
	private $dbName = 'db_reminder';

// Function ConnectDB	
	function connectDB()
	{
		mysql_connect($this->dbHost, $this->dbUser, $this->dbPass);
		mysql_select_db($this->dbName) or die ('Database not exist, Please contact your develover');
	}

// Function NIKRealize	
	function NIKRealize()
	{
		$query = mysql_query ("SELECT * FROM tbl_p3k");
		while ($row = mysql_fetch_array($query))		
		$data[] = $row;
		return $data;
		
	}

// Function RealizeRemainderMail
	function RealizeRemainderMail($to)
	{
	
	date_default_timezone_set('Asia/Jakarta');
	$today = date ("d-M-Y H:i");
	
	include "class.phpmailer.php";
	$Array = $this->NIKRealize();
	$i=1;

	foreach ($Array as $data){
	$NIK	= $data['NIK'];
	$Nama	= $data['Nama'];
	$to		= $data['Email'];
	
		try {		
		$mail= new PHPMailer (true);
		
		$sql = mysql_query ("SELECT * FROM tbl_p3k");
		
		
		$body=
		"<html>
			<head>
			<style type=text/css>
			.style1 {font-size: 12px}
			.style4 {font-size: 12px; font-style: italic; }

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
			
			table { border: thin black solid;
					font-size:12px;} /* or other border styles */
			</style>			
			<title>Integreted Reminder System</title>
			</head>
			<body>
			<p>Kepada YTH: $Nama </p>
			<p><strong>List KKWT Yang akan Habis Masa Berlaku</strong></p>
			<p><strong>Tanggal: $today</strong></p>
			<table border=1 cellpadding=0 cellspacing=0 frame=border rules=rows>		
			<th><div align='center'>No</div></th>
			<th><div align='center'>NIK</div></th>
			<th><div align='center'>Nama</div></th>
			<th><div align='center'>Tgl Batas Masa Berlaku</div></th>
					
			</tr>";
		
		
		$mail-> Body 		= $body;			
		$no					=1;
	
		while ($dta = mysql_fetch_array($sql)){
		
		$NIK				= $dta['NIK'];
		$Nama				= $dta['Nama'];
		$Tgl_Form			= date('d-M-Y', strtotime($dta['KKWT_Date2']));		
		
			
		//$DueDate			= date('d-M-Y', strtotime('+10 day',$Tgl));		
		$konten[$NIK]		="<tr>
								<td><div align='center'>$no</div></td>
								<td><div align='left'>$dta[NIK]</div></td>
								<td><div align='left'>$dta[Nama]</div></td>
								<td><div align='left'>$Tgl_Form</div></td>
								
							</tr>";		
				
		$mail->Body .= $konten[$NIK];	
		$no++;
		}
			
	$footer ="</table>
			</br>
			</br>
			<p><font color='#FF0000' size=-1>Perhatian email ini dikirim secara otomatis dari <i>e</i>-Kasbon System. Jangan membalas ke alamat ini</font></p>
			</body>
			</html>";			
					
			$mail->IsSMTP();
  			$mail->Mailer       = "smtp";
  			$mail->Host         = "astelmail.unias.com";
  			$mail->Port         = 25;
  			$mail->SMTPSecure   = "tls";    
  			$mail->SMTPKeepAlive= true;
  			$mail->SMTPAuth     = true; 
  			$mail->SetFrom('system.noreply@unias.com', 'Integrated Reminder Services (IRIS)');
			$to = "dompak.sinambela@unias.com";
			$mail->AddAddress ($to);			
			$mail->Subject			= 'Integrated Reminder System';
			$mail->Body 			.= $footer;
			$mail->AltBody			= 'To view the message, please use an HTML compatible email viewer!';
			$mail->WordWrap			= 80;
			$mail->IsHTML (True);
			$mail->Send();
			}	
			
			catch (phpmailerException $e)
			{
			//echo $e->errorMessage();
			}		
	$i++;
			
	}
	
	}
	
	
	// Konten Email untuk remainder list kasbon yang belum di realisasi		
	function MailRealizeContent()
	{
	$sql = mysql_query ("SELECT * FROM tbl_p3k");
	while ($row = mysql_fetch_array($sql))		
	$data[] 	= $row;
	$Expire		= $row['StartingDate'];
	$col		= mysql_num_rows($sql);
	$total[] 	= $col;
	return $data;
	return $total;
		
	}
	


}
?>