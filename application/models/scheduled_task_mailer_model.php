<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class scheduled_task_mailer_model extends CMS_Model {	

	function __construct()
	{
		parent::__construct();
        $this->load->helper('url');
        require_once (APPPATH.'libraries/class.phpmailer.php');
	}

	public function mailer_hak_cuti_besar($primary_key, $session_nik, $result, $date){   
    	
    $user_name = $this->data_table_value($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $session_nik);

		try {

		$mail = new PHPMailer(true);

		$body =
		'<html>
    <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Reminder Email</title>
    <style>
      /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */
      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%; }

      body {
        background-color: #f6f6f6;
        font-family: sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 0; 
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%; }

      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: sans-serif;
          font-size: 14px;
          vertical-align: top; }

      /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */

      .body {
        background-color: #f6f6f6;
        width: 100%; }

      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
      .container {
        display: block;
        Margin: 0 auto !important;
        /* makes it centered */
        max-width: 100%;
        padding: 10px;
        width: 100%; }

      /* This should also be a block element, so that it will fill 100% of the .container */
      .content {
        box-sizing: border-box;
        display: block;
        Margin: 0 auto;
        max-width: 100%;
        padding: 10px; }

      /* -------------------------------------
          HEADER, FOOTER, MAIN
      ------------------------------------- */
      .main {
        background: #fff;
        border-radius: 3px;
        width: 100%; }

      .wrapper {
        box-sizing: border-box;
        padding: 20px; }

      .footer {
        clear: both;
        padding-top: 10px;
        text-align: center;
        width: 100%; }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center; }

      /* -------------------------------------
          TYPOGRAPHY
      ------------------------------------- */
      h1,
      h2,
      h3,
      h4 {
        color: #000000;
        font-family: sans-serif;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        Margin-bottom: 30px; }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize; }

      p,
      ul,
      ol {
        font-family: sans-serif;
        font-size: 14px;
        font-weight: normal;
        margin: 0;
        Margin-bottom: 15px; }
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px; }

      a {
        color: #3498db;
        text-decoration: underline; }

      /* -------------------------------------
          BUTTONS
      ------------------------------------- */
      .btn {
        box-sizing: border-box;
        width: 100%; }
        .btn > tbody > tr > td {
          padding-bottom: 15px; }
        .btn table {
          width: auto; }
        .btn table td {
          background-color: #ffffff;
          border-radius: 5px;
          text-align: center; }
        .btn a {
          background-color: #ffffff;
          border: solid 1px #3498db;
          border-radius: 5px;
          box-sizing: border-box;
          color: #3498db;
          cursor: pointer;
          display: inline-block;
          font-size: 14px;
          font-weight: bold;
          margin: 0;
          padding: 12px 25px;
          text-decoration: none;
          text-transform: capitalize; }

      .btn-primary table td {
        background-color: #3498db; }

      .btn-primary a {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff; }

      /* -------------------------------------
          OTHER STYLES THAT MIGHT BE USEFUL
      ------------------------------------- */
      .last {
        margin-bottom: 0; }

      .first {
        margin-top: 0; }

      .align-center {
        text-align: center; }

      .align-right {
        text-align: right; }

      .align-left {
        text-align: left; }

      .clear {
        clear: both; }

      .mt0 {
        margin-top: 0; }

      .mb0 {
        margin-bottom: 0; }

      .preheader {
        color: transparent;
        display: none;
        height: 0;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        mso-hide: all;
        visibility: hidden;
        width: 0; }

      .powered-by a {
        text-decoration: none; }

      hr {
        border: 0;
        border-bottom: 1px solid #f6f6f6;
        Margin: 20px 0; }

      /* -------------------------------------
          RESPONSIVE AND MOBILE FRIENDLY STYLES
      ------------------------------------- */
      @media only screen and (max-width: 620px) {
        table[class=body] h1 {
          font-size: 28px !important;
          margin-bottom: 10px !important; }
        table[class=body] p,
        table[class=body] ul,
        table[class=body] ol,
        table[class=body] td,
        table[class=body] span,
        table[class=body] a {
          font-size: 16px !important; }
        table[class=body] .wrapper,
        table[class=body] .article {
          padding: 10px !important; }
        table[class=body] .content {
          padding: 0 !important; }
        table[class=body] .container {
          padding: 0 !important;
          width: 100% !important; }
        table[class=body] .main {
          border-left-width: 0 !important;
          border-radius: 0 !important;
          border-right-width: 0 !important; }
        table[class=body] .btn table {
          width: 100% !important; }
        table[class=body] .btn a {
          width: 100% !important; }
        table[class=body] .img-responsive {
          height: auto !important;
          max-width: 100% !important;
          width: auto !important; }}

      /* -------------------------------------
          PRESERVE THESE STYLES IN THE HEAD
      ------------------------------------- */
      @media all {
        .ExternalClass {
          width: 100%; }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
          line-height: 100%; }
        .apple-link a {
          color: inherit !important;
          font-family: inherit !important;
          font-size: inherit !important;
          font-weight: inherit !important;
          line-height: inherit !important;
          text-decoration: none !important; } 
        .btn-primary table td:hover {
          background-color: #34495e !important; }
        .btn-primary a:hover {
          background-color: #34495e !important;
          border-color: #34495e !important; } }

    </style>
  </head>
  <body class="">
    <table border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">

            <!-- START CENTERED WHITE CONTAINER -->
            <span class="preheader">Mohon segera membuat Hak Cuti.</span>
            <table class="main">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper">
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>
                        <p><strong>Dear '.$user_name.',</strong></p>
                        <p>Berikut Daftar Karyawan yg sudah bisa memiliki Hak Cuti Besar, Mohon menambahkan Hak Cuti yg bersangkutan di HRIS. <strong>Sistem TIDAK melakukan proses penambahan otomatis</strong>.</p>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                          <tbody>
                            <tr>
                              <td align="left">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <td bgcolor="#CCCCCC" width="5%">No</td>
                                    <td bgcolor="#CCCCCC" width="10%">NIK</td>
                                    <td bgcolor="#CCCCCC" width="20%">Nama</td>
                                    <td bgcolor="#CCCCCC" width="15%">Tgl Bergabung</td>
                                    <td bgcolor="#CCCCCC" width="10%">Masa Kerja</td>
                                    <td bgcolor="#CCCCCC" width="10%">Lama Cuti</td>
                                    <td bgcolor="#CCCCCC" width="">Perusahaan</td>
                                  </tr>

                                  </thead>
                                  <tbody>';

                                  $no=1;

                                  foreach ($result as $key => $value) {

                                      $masa_kerja = $this->beda_waktu($value->TglMasuk, $date);
                                      $masa_kerjaku = $masa_kerja['y'];
                                      $lama_cuti  = $this->jumlah_lama_cuti($masa_kerjaku);

                                      $body .='<tr>';                                      
                                      $body .='<td>'.$no.'</td>';
                                      $body .='<td>'.$value->NIK.'</td>';
                                      $body .='<td>'.$value->Nama.'</td>';
                                      $body .='<td>'.$this->basic_date_format($value->TglMasuk).'</td>';
                                      $body .='<td>'.$masa_kerjaku.' Tahun</td>';
                                      $body .='<td>'.$lama_cuti.' Hari</td>';
                                      $body .='<td>'.$this->data_table_value($table_name='tbl_company', $where_column='iCompanyId', $result_column='cCompanyName', $value->CompanyId).'</td>';
                                      
                                      $body .='</tr>';

                                      $no++;
                                  }                                  

                                  $body .='</tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <p style="margin-top:10px">*) Hak Cuti Besar memiliki masa aktif 3 Tahun setelah tanggal cuti.</p>
                        <p>Terima kasih</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

              <!-- END MAIN CONTENT AREA -->
              </table>

            <!-- START FOOTER -->
            <div class="footer">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="content-block">
                    <span class="apple-link">Human Resource Information System PT. Aneka Spring Telekomindo & Group</span>
                    <br> Perhatian email ini dikirim secara otomatis dari System. Jangan membalas ke alamat ini.
                  </td>
                </tr>
                <tr>
                  <td class="content-block powered-by">
                    Powered By <a href="https://apps.unias.com">M.I.S</a>, All Rights Reserved
                  </td>
                </tr>
              </table>
            </div>';

           


            $body .= '<!-- END FOOTER -->
            
<!-- END CENTERED WHITE CONTAINER --></div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
</html><br/><br/>';
	
	
		$mail->IsSMTP();
		$mail->Mailer     	= "smtp";
		$mail->Port       	=  25;
		$mail->SMTPKeepAlive= true;
		$mail->SMTPAuth     = true;
		$mail->Priority     = 1;
		$mail->From         = "HRIS";
		$mail->FromName     = "HRIS";
		$mail->SetFrom('hris.noreply@unias.com', 'HRIS');
		$to = $this->cms_user_email($session_nik);
		//$to = "dompak.sinambela@unias.com";
		$mail->Body         = $body;		
		$mail->AddAddress($to);
		$mail->Subject       = "[Daftar Cuti Besar (Khusus)]";
		$mail->AltBody       = "To view the message, please use an HTML compatible email viewer!"; 	
		$mail->WordWrap      = 80;	
		$mail->IsHTML(true);	
		$mail->Send();	
		
		}
		catch (phpmailerException $e){
			echo $e->errorMessage();
		}   	
		
    }

    public function mailer_reminder_hak_cuti_besar($primary_key, $sisa_cuti, $session_nik, $session_name, $session_email, $periode_check){   
      

    try {

    $mail = new PHPMailer(true);

    $body =
    '<html>
    <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Reminder Email</title>
    <style>
      /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */
      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%; }

      body {
        background-color: #f6f6f6;
        font-family: sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 0; 
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%; }

      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: sans-serif;
          font-size: 14px;
          vertical-align: top; }

      /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */

      .body {
        background-color: #f6f6f6;
        width: 100%; }

      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
      .container {
        display: block;
        Margin: 0 auto !important;
        /* makes it centered */
        max-width: 100%;
        padding: 10px;
        width: 100%; }

      /* This should also be a block element, so that it will fill 100% of the .container */
      .content {
        box-sizing: border-box;
        display: block;
        Margin: 0 auto;
        max-width: 100%;
        padding: 10px; }

      /* -------------------------------------
          HEADER, FOOTER, MAIN
      ------------------------------------- */
      .main {
        background: #fff;
        border-radius: 3px;
        width: 100%; }

      .wrapper {
        box-sizing: border-box;
        padding: 20px; }

      .footer {
        clear: both;
        padding-top: 10px;
        text-align: center;
        width: 100%; }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center; }

      /* -------------------------------------
          TYPOGRAPHY
      ------------------------------------- */
      h1,
      h2,
      h3,
      h4 {
        color: #000000;
        font-family: sans-serif;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        Margin-bottom: 30px; }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize; }

      p,
      ul,
      ol {
        font-family: sans-serif;
        font-size: 14px;
        font-weight: normal;
        margin: 0;
        Margin-bottom: 15px; }
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px; }

      a {
        color: #3498db;
        text-decoration: underline; }

      /* -------------------------------------
          BUTTONS
      ------------------------------------- */
      .btn {
        box-sizing: border-box;
        width: 100%; }
        .btn > tbody > tr > td {
          padding-bottom: 15px; }
        .btn table {
          width: auto; }
        .btn table td {
          background-color: #ffffff;
          border-radius: 5px;
          text-align: center; }
        .btn a {
          background-color: #ffffff;
          border: solid 1px #3498db;
          border-radius: 5px;
          box-sizing: border-box;
          color: #3498db;
          cursor: pointer;
          display: inline-block;
          font-size: 14px;
          font-weight: bold;
          margin: 0;
          padding: 12px 25px;
          text-decoration: none;
          text-transform: capitalize; }

      .btn-primary table td {
        background-color: #3498db; }

      .btn-primary a {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff; }

      /* -------------------------------------
          OTHER STYLES THAT MIGHT BE USEFUL
      ------------------------------------- */
      .last {
        margin-bottom: 0; }

      .first {
        margin-top: 0; }

      .align-center {
        text-align: center; }

      .align-right {
        text-align: right; }

      .align-left {
        text-align: left; }

      .clear {
        clear: both; }

      .mt0 {
        margin-top: 0; }

      .mb0 {
        margin-bottom: 0; }

      .preheader {
        color: transparent;
        display: none;
        height: 0;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        mso-hide: all;
        visibility: hidden;
        width: 0; }

      .powered-by a {
        text-decoration: none; }

      hr {
        border: 0;
        border-bottom: 1px solid #f6f6f6;
        Margin: 20px 0; }

      /* -------------------------------------
          RESPONSIVE AND MOBILE FRIENDLY STYLES
      ------------------------------------- */
      @media only screen and (max-width: 620px) {
        table[class=body] h1 {
          font-size: 28px !important;
          margin-bottom: 10px !important; }
        table[class=body] p,
        table[class=body] ul,
        table[class=body] ol,
        table[class=body] td,
        table[class=body] span,
        table[class=body] a {
          font-size: 16px !important; }
        table[class=body] .wrapper,
        table[class=body] .article {
          padding: 10px !important; }
        table[class=body] .content {
          padding: 0 !important; }
        table[class=body] .container {
          padding: 0 !important;
          width: 100% !important; }
        table[class=body] .main {
          border-left-width: 0 !important;
          border-radius: 0 !important;
          border-right-width: 0 !important; }
        table[class=body] .btn table {
          width: 100% !important; }
        table[class=body] .btn a {
          width: 100% !important; }
        table[class=body] .img-responsive {
          height: auto !important;
          max-width: 100% !important;
          width: auto !important; }}

      /* -------------------------------------
          PRESERVE THESE STYLES IN THE HEAD
      ------------------------------------- */
      @media all {
        .ExternalClass {
          width: 100%; }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
          line-height: 100%; }
        .apple-link a {
          color: inherit !important;
          font-family: inherit !important;
          font-size: inherit !important;
          font-weight: inherit !important;
          line-height: inherit !important;
          text-decoration: none !important; } 
        .btn-primary table td:hover {
          background-color: #34495e !important; }
        .btn-primary a:hover {
          background-color: #34495e !important;
          border-color: #34495e !important; } }

    </style>
  </head>
  <body class="">
    <table border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">

            <!-- START CENTERED WHITE CONTAINER -->
            <span class="preheader">Perpanjangan Masa Berlaku Hak Cuti.</span>
            <table class="main">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper">
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>
                        <p><strong>Dear '.$session_name.',</strong></p>
                        <p>Hak Cuti Besar anda akan habis masa berlakunya <strong>'.$periode_check.' bulan lagi</strong>, Silahkan hubungi HRD untuk memperpanjang masa berlakunya.</p>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                          <tbody>
                            <tr>
                              <td align="left">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <td bgcolor="#CCCCCC" width="5%">#ID</td>
                                    <td bgcolor="#CCCCCC" width="10%">NIK</td>
                                    <td bgcolor="#CCCCCC" width="20%">Periode 1</td>
                                    <td bgcolor="#CCCCCC" width="20%">Periode 2</td>
                                    <td bgcolor="#CCCCCC">Sisa Cuti</td>                                    
                                  </tr>

                                  </thead>
                                  <tbody>';

                                  $query = $this->db->select('*')
                                                    ->from('tbl_hakcuti')
                                                    ->where('HakId', $primary_key)                                                   
                                                    ->order_by('HakId','ASC')
                                                    ->get();
                                  $no=1;

                                  foreach($query->result() as $data){

                                      $body .='<tr>';                                      
                                      $body .='<td>'.$primary_key.'</td>';
                                      $body .='<td>'.$data->NIK.'</td>';                                    
                                      $body .='<td>'.$this->basic_date_format($data->Periode1).'</td>';
                                      $body .='<td>'.$this->basic_date_format($data->Periode2).'</td>';
                                      $body .='<td>'.$sisa_cuti.' Hari</td>'; 
                                      
                                      $body .='</tr>';

                                      $no++;
                                    }                                  
                       

                                  $body .='</tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <br/>
                        <br/>
                        <p>Terima kasih</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

              <!-- END MAIN CONTENT AREA -->
              </table>

            <!-- START FOOTER -->
            <div class="footer">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="content-block">
                    <span class="apple-link">Human Resource Information System PT. Aneka Spring Telekomindo & Group</span>
                    <br> Perhatian email ini dikirim secara otomatis dari System. Jangan membalas ke alamat ini.
                  </td>
                </tr>
                <tr>
                  <td class="content-block powered-by">
                    Powered By <a href="https://apps.unias.com">M.I.S</a>, All Rights Reserved
                  </td>
                </tr>
              </table>
            </div>';

           


            $body .= '<!-- END FOOTER -->
            
<!-- END CENTERED WHITE CONTAINER --></div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
</html><br/><br/>';
  
  
    $mail->IsSMTP();
    $mail->Mailer       = "smtp";
    $mail->Port         =  25;
    $mail->SMTPKeepAlive= true;
    $mail->SMTPAuth     = true;
    $mail->Priority     = 1;
    $mail->From         = "HRIS";
    $mail->FromName     = "HRIS";
    $mail->SetFrom('hris.noreply@unias.com', 'HRIS');
    //$to = "dompak.sinambela@unias.com";
    $mail->Body         = $body;    
    $mail->AddAddress($session_email);
    $mail->Subject       = "[Reminder]";
    $mail->AltBody       = "To view the message, please use an HTML compatible email viewer!";  
    $mail->WordWrap      = 80;  
    $mail->IsHTML(true);  
    $mail->Send();  
    
    }
    catch (phpmailerException $e){
      echo $e->errorMessage();
    }     
    
    }

    

    public function data_table_value($table_name, $where_column, $result_column, $value){

        $this->db->select($result_column)
                 ->from($table_name)
                 ->where($where_column, $value);
        $db      = $this->db->get();
        $data    = $db->row(0);
        $num_row = $db->num_rows();

        if ($num_row > 0){
            return $data->$result_column;
        }
        else{
            return '';
        }
    }

    public function cms_user_email($user_nik){

      $this->db->select('Email')
                 ->from('tbl_profile')
                 ->where('NIK',$user_nik);
        $db = $this->db->get();
        $data = $db->row(0);
        $num_row = $db->num_rows();

        if ($num_row >0){
            return $data->Email;
        }else{
            return 'itsupport@unias.com';
        }

    }

    public function daysDifference($endDate, $beginDate){

        $date_parts1  = explode("-", $beginDate);
        $date_parts2  = explode("-", $endDate);
        $start_date   = gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
        $end_date     = gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
        $diff         = abs($end_date - $start_date);
        $years        = floor($diff / 365.25);
        
        return $years;
    }

    public function jumlah_lama_cuti($jumlah_tahun){

        if($jumlah_tahun == 10){
            return 12;
        }
        elseif($jumlah_tahun == 15){
            return 15;
        }
        elseif($jumlah_tahun == 20){
            return 18;
        }
        elseif($jumlah_tahun == 25){
            return 20;
        }
        else{
            return 0;
        }
    }

    public function basic_date_format($date){

      if (is_null($date) || $date =='0000-00-00'){
        $tanggal = '';
      }
      else{
        $tanggal = date('d-M-Y', strtotime($date));
      }       

        return $tanggal;

    }

    public function beda_waktu($date1, $date2, $format = false){

      $diff = date_diff(date_create($date1), date_create($date2) );
      if ($format)
        return $diff->format($format);
      
      return array('y' => $diff->y,
            'm' => $diff->m,
            'd' => $diff->d,
            'h' => $diff->h,
            'i' => $diff->i,
            's' => $diff->s
          );
    }


    public function create_button_link($accept=NULL, $reject=NULL, $check=NULL, $url=NULL){

        $html = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                  <td>
                  <div>';

                      $html .='<!--[if mso]>
                          <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://litmus.com" style="height:36px;v-text-anchor:middle;width:150px;" arcsize="5%" strokecolor="#00CC00" fillcolor="#00CC00">
                            <w:anchorlock/>
                            <center style="color:#ffffff;font-family:Helvetica, Arial,sans-serif;font-size:16px;">Accept</center>
                          </v:roundrect>
                        <![endif]-->
                        <a href="http://buttons.cm" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:150px;-webkit-text-size-adjust:none;mso-hide:all;">Accept</a>';
                      
                      $html .='<!--[if mso]>
                          <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://litmus.com" style="height:36px;v-text-anchor:middle;width:150px;" arcsize="5%" strokecolor="#FF0000" fillcolor="#FF0000">
                            <w:anchorlock/>
                            <center style="color:#ffffff;font-family:Helvetica, Arial,sans-serif;font-size:16px;">Reject</center>
                          </v:roundrect>
                        <![endif]-->
                        <a href="http://buttons.cm" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:150px;-webkit-text-size-adjust:none;mso-hide:all;">Reject</a>';
                      
                      $html .='<!--[if mso]>
                          <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://litmus.com" style="height:36px;v-text-anchor:middle;width:150px;" arcsize="5%" strokecolor="#00CCFF" fillcolor="#00CCFF">
                            <w:anchorlock/>
                            <center style="color:#ffffff;font-family:Helvetica, Arial,sans-serif;font-size:16px;">Check</center>
                          </v:roundrect>
                        <![endif]-->
                        <a href="http://buttons.cm" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:150px;-webkit-text-size-adjust:none;mso-hide:all;">Check</a>';


                      $html .='</div>
                    </td>
                  </tr>
                </table>';

    return $html;

    }

	


}
