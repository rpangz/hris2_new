<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kehadiran_Mailer_Model extends CMS_Model{

    protected $email_from_address;
    protected $email_from_name; 

    public function __construct(){
        parent::__construct();      

        $this->load->model($this->cms_module_path().'/Kehadiran_Model'); 

        $this->table_header = cms_module_config($this->cms_module_path(), 'table_header');
        $this->table_detail = cms_module_config($this->cms_module_path(), 'table_detail');

        $this->email_from_address = $this->cms_get_config('cms_email_reply_address');
        $this->email_from_name = $this->cms_get_config('cms_email_reply_name');
    }

    public function cms_asfa_services(){

        $this->db->select('value')
                 ->from('tbl_main_config')
                 ->where('config_name','cms_asfa_services');
        $db    = $this->db->get();
        $data    = $db->row(0);
        $num_row = $db->num_rows();
        if ($num_row > 0){ return $data->value;} else{ return '';}
    }

    public function get_data_row($table_name, $where_column, $result_column, $primary_key){

        $query = $this->db->select($result_column)->from($table_name)->where($where_column, $primary_key)->get();
        $row   = $query->row();

        if($query->num_rows()>0){            
            return $row->$result_column;            
        }else{
            return '';
        }            
    }


    public function show_detail_cuti($primary_key){
        $today      = date('Y-m-d');
        $sub_total  = 0;
        $grand      = 0;
        
        $query = $this->db->query("SELECT * FROM ".$this->table_header." WHERE CutiId='".$primary_key."'");

        return $query->row();
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

    public function detail_date_format($date){
        if (is_null($date) || $date =='0000-00-00' || empty($date)){
            $tanggal = '';
        }
        else{
            $tanggal = date('d-M-Y H:i', strtotime($date));
        }
        return $tanggal;
    }

    public function day_name_id($tanggal){

        $day = date('D', strtotime($tanggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        return $dayList[$day];
    }

    public function show_detail_tanggal_cuti($primary_key){

        $query = $this->db->query("SELECT *,DATE_FORMAT(TglCuti, '%d-%b-%Y') AS TglCutiInd FROM ".$this->table_detail." WHERE CutiId='".$primary_key."' ORDER BY TglCuti ASC");

        return $query->result();
    }


    public function status_form_text($value){

        $query = $this->db->query("SELECT NamaStatusForm FROM tbl_statusform WHERE CodeStatusForm='".$value."'");
        $row   = $query->row();

        return $row->NamaStatusForm;
    }

    public function status_approval_caption($primary_key,$level_id){

        $html   ='';

        $NIK    = 'NIK'.$level_id;
        $Apv    = 'Apv'.$level_id;
        $Tgl    = 'Tgl'.$level_id;
        $Remark = 'Remark'.$level_id;

        $query = $this->db->query("SELECT * FROM ".$this->table_header." WHERE CutiId='".$primary_key."'");
        $data  = $query->row();

        $nama  = $this->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->$NIK);
        $status= $this->status_form_text($data->$Apv);
        $tanggal= $this->detail_date_format($data->$Tgl);
        $remark= $data->$Remark;

        if($data->$Apv == 'P'){
            $status = '<span class="label label-default">'.$status.'</span>';
        }
        elseif($data->$Apv == 'A'){
            $status = '<span class="label label-success">'.$status.'</span>';
        }
        elseif($data->$Apv == 'X'){
            $status = '<span class="label label-danger">'.$status.'</span>';
        }
        elseif($data->$Apv == 'R'){
            $status = '<span class="label label-danger">'.$status.'</span>';
        }
        else{
            $status = '<span class="label label-default">'.$status.'</span>';
        }

        $html .= $nama.', '.$status.' '.$tanggal.' <small>'.$remark.'</small>';

        return $html;
    }



    public function mailer_form_cuti($primary_key, $session_nik, $level_id, $workflow_id, $status, $act, $subject, $company, $remarks =NULL){
        
        $base_url_img = $this->config->item('base_url_img');

        $this->db->select('*')
                 ->from($this->table_header)
                 ->where('CutiId', $primary_key);
        $db = $this->db->get();
        $data = $db->row(0);
        $num_row = $db->num_rows();


        $sisa_cuti_tahunan = $this->Kehadiran_Model->total_sisa_cuti_tahunan($data->FormCutiNIK);
        $sisa_cuti_besar   = $this->Kehadiran_Model->total_sisa_cuti_besar($data->FormCutiNIK);
        

        $body =
        '
        <html xmlns="http://www.w3.org/1999/xhtml" style="font-family: Helvetica Neue, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
        <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>DIFA System</title>

        <style type="text/css">
        img {
        max-width: 100%;
        }
        body {
        -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
        }
        body {
        background-color: #f6f6f6;
        }
        @media only screen and (max-width: 640px) {
          body {
            padding: 0 !important;
          }
          h1 {
            font-weight: 800 !important; margin: 20px 0 5px !important;
          }
          h2 {
            font-weight: 800 !important; margin: 20px 0 5px !important;
          }
          h3 {
            font-weight: 800 !important; margin: 20px 0 5px !important;
          }
          h4 {
            font-weight: 800 !important; margin: 20px 0 5px !important;
          }
          h1 {
            font-size: 22px !important;
          }
          h2 {
            font-size: 18px !important;
          }
          h3 {
            font-size: 16px !important;
          }
          .container {
            padding: 0 !important; width: 100% !important;
          }
          .content {
            padding: 0 !important;
          }
          .content-wrap {
            padding: 10px !important;
          }
          .invoice {
            width: 100% !important;
          }
        }
        </style>




        <style type="text/css">
/* Star hover using lang hack in its own style wrapper, otherwise Gmail will strip it out */
    * [lang~="x-star-wrapper"]:hover *[lang~="x-star-number"]{
        color: #119da2 !important;
        border-color: #119da2 !important;
    }

    * [lang~="x-star-wrapper"]:hover *[lang~="x-full-star"],
    * [lang~="x-star-wrapper"]:hover ~ *[lang~="x-star-wrapper"] *[lang~="x-full-star"] {
      display : block !important;
      width : auto !important;
      overflow : visible !important;
      float : none !important;
      margin-top: -1px !important;
    }

    * [lang~="x-star-wrapper"]:hover *[lang~="x-empty-star"],
    * [lang~="x-star-wrapper"]:hover ~ *[lang~="x-star-wrapper"] *[lang~="x-empty-star"] {
      display : block !important;
      width : 0 !important;
      overflow : hidden !important;
      float : left !important;
      height: 0 !important;
    }
</style>


<style type="text/css">
/* Normal email CSS */
    @-ms-viewport {
        width: device-width;
    }
    body {
        margin: 0;
        padding: 0;
        min-width: 100%;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
    }
    td {
        vertical-align: top;
    }
    img {
        border: 0;
        -ms-interpolation-mode: bicubic;
        max-width: 100% !important;
        height: auto;
    }
    a {
        text-decoration: none;
        color: #119da2;
    }
    a:hover {
        text-decoration: underline;
    }

    *[class=main-wrapper],
    *[class=main-content]{
        min-width: 0 !important;
        width: 600px !important;
        margin: 0 auto !important;
    }
    *[class=rating] {
      unicode-bidi: bidi-override;
      direction: rtl;
    }
    *[class=rating] > *[class=star] {
      display: inline-block;
      position: relative;
      text-decoration: none;
    }

    @media (max-width: 621px) {
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -o-box-sizing: border-box;
        }
        table {
            min-width: 0 !important;
            width: 100% !important;
        }
        *[class=body-copy] {
            padding: 0 10px !important;
        }
        *[class=main-wrapper],
        *[class=main-content]{
            min-width: 0 !important;
            width: 320px !important;
            margin: 0 auto !important;
        }
        *[class=ms-sixhundred-table] {
            width: 100% !important;
            display: block !important;
            float: left !important;
            clear: both !important;
        }
        *[class=content-padding] {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        *[class=bottom-padding]{
            margin-bottom: 2px !important;
            font-size: 0 !important;
            line-height: 0 !important;
        }
        *[class=top-padding] {
            display: none !important;
        }
        *[class=hide-mobile] {
            display: none !important;
        }
        

        /* Prevent hover effects so double click issue doesnt happen on mobile devices */
        * [lang~="x-star-wrapper"]:hover *[lang~="x-star-number"]{
            color: #AEAEAE !important;
            border-color: #FFFFFF !important;
        }
        * [lang~="x-star-wrapper"]{
            pointer-events: none !important;
        }
        * [lang~="x-star-divbox"]{
            pointer-events: auto !important;
        }
        *[class=rating] *[class="star-wrapper"] a div:nth-child(2),
        *[class=rating] *[class="star-wrapper"]:hover a div:nth-child(2),
        *[class=rating] *[class="star-wrapper"] ~ *[class="star-wrapper"] a div:nth-child(2){
          display : none !important;
          width : 0 !important;
          height: 0 !important;
          overflow : hidden !important;
          float : left !important;
        }
        *[class=rating] *[class="star-wrapper"] a div:nth-child(1),
        *[class=rating] *[class="star-wrapper"]:hover a div:nth-child(1),
        *[class=rating] *[class="star-wrapper"] ~ *[class="star-wrapper"] a div:nth-child(1){
          display : block !important;
          width : auto !important;
          overflow : visible !important;
          float : none !important;
        }
    }
</style>


        </head>

        <body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

        <table class="body-wrap" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
          <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
          <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; margin: 0;" valign="top"></td>
            <td class="container" width="600" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
              <div class="content" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
                  <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">          
                    <td class="alert alert-good" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #68B90F; margin: 0; padding: 10px;" align="center" bgcolor="#FF9F00" valign="top">
                        <img src="'.$base_url_img.'assets/nocms/images/custom_logo/logo-home copy.png'.'" alt="Apps Logo" height="35px" width="230px"> 
                    </td>            
                  </tr>
                  <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">          
                    <td class="alert alert-good" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 0px 0px 0 0; background-color: #68B90F; margin: 0; padding: 5px;" align="center" bgcolor="#FF9F00" valign="top">
                        Form Pengajuan Permohonan Cuti  
                    </td>            
                  </tr>

                  <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                    <td class="content-wrap" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
                      <table width="100%" cellpadding="0" cellspacing="0" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                        <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                          <td class="content-block" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; margin: 0; padding: 0 0 10px;" valign="top">
                            <strong style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">'.$remarks.'</strong>
                          </td>
                        </tr>                        

                        <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                          <td class="content-block" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; margin: 0; padding: 0 0 10px;" valign="top">
                            <table class="invoice" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; text-align: left; width: 100%; margin: 10px auto;">
                              
                              

                              <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                                  <td colspan="2" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; margin: 0; padding: 5px 0;" valign="top">
                                    <table class="invoice-items" cellpadding="0" cellspacing="0" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; width: 100%; margin: 0;">
                                      
                                      <tr class="total" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                                        <td colspan="3" class="alignright" width="100%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; text-align: left; border-top-width: 1px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 1px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0 5px 0;" align="right" valign="top">Detail Permohonan</td>
                                      </tr>

                                      <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                                        <td width="20%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">NIK/Nama</td>
                                        <td width="2%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">:</td>
                                        <td class="alignleft" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; text-align: left; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" align="right" valign="top"><strong>'.$data->FormCutiNIK.'/'.$this->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->FormCutiNIK).'</strong></td>
                                      </tr>

                                       <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                                        <td width="20%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">Sisa Cuti</td>
                                        <td width="2%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">:</td>
                                        <td class="alignleft" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; text-align: left; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" align="right" valign="top"><strong>Tahunan: '.$sisa_cuti_tahunan.' Hari/ Besar: '.$sisa_cuti_besar.' Hari</strong></td>
                                      </tr>

                                      <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                                        <td width="20%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">Tanggal Cuti</td>
                                        <td width="2%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">:</td>
                                        <td class="alignleft" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; text-align: left; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" align="right" valign="top">'.$this->body_detail_cuti($primary_key).'</td>
                                      </tr>
                                      <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                                        <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">Tanggal Masuk</td>
                                        <td width="2%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">:</td>
                                        <td class="alignleft" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; text-align: left; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" align="right" valign="top">'.$this->day_name_id($data->TglMasuk).', '.$this->basic_date_format($data->TglMasuk).'</td>
                                      </tr>
                                      <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                                        <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">Keperluan</td>
                                        <td width="2%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">:</td>
                                        <td class="alignleft" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; text-align: left; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" align="right" valign="top">'.$data->Keperluan.'</td>
                                      </tr> 
                                      <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                                        <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">Pengganti</td>
                                        <td width="2%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">:</td>
                                        <td class="alignleft" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; text-align: left; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" align="right" valign="top">'.$this->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->NIKPengganti).'</td>
                                      </tr>
                                      <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                                        <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">Alamat selama cuti</td>
                                        <td width="2%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">:</td>
                                        <td class="alignleft" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; text-align: left; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" align="right" valign="top">'.$data->Alamat.'</td>
                                      </tr>

                                      <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                                        <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">No Telpon</td>
                                        <td width="2%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">:</td>
                                        <td class="alignleft" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; text-align: left; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" align="right" valign="top">'.$data->NoTelpon.'</td>
                                      </tr>                       

                                    </table>
                                </td>
                              </tr>';

                              //$body .= $this->detail_outstanding_trip($primary_key, $session_nik, $level_id, $status, $workflow_id);

                              
                              $body .= '<tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                                  <td colspan="2" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; margin: 0; padding: 5px 0;" valign="top">
                                    <table class="invoice-items" cellpadding="0" cellspacing="0" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; width: 100%; margin: 0;">
                                      
                                      <tr class="total" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                                        <td colspan="2" class="alignright" width="100%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; text-align: left; border-top-width: 1px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 1px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0 5px 0;" align="right" valign="top">Approval</td> 
                                      </tr>';

                                        for ($x = 1; $x <= 3; $x++) {

                                            $query = $this->db->query("select * from ".$this->table_header." as a where a.CutiId=".$primary_key);
                                            $data  = $query->row(0);

                                            $NIK    = 'NIK'.$x;
                                            $Tgl    = 'Tgl'.$x;
                                            $Apv    = 'Apv'.$x;
                                            $Pin    = 'Pin'.$x;
                                            $Remark = 'Remark'.$x;

                                            if($x==1){
                                                $process_level_name = 'Verifikator';
                                            }
                                            elseif($x == 2){
                                                $process_level_name = 'Atasan Langsung';
                                            }
                                            elseif($x == 3){
                                                $process_level_name = 'Atasan Lebih Tinggi';
                                            }
                                            else{
                                                $process_level_name = '';
                                            }

                                            $body .= '
                                            <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                                            <td width="5%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" valign="top">'.$x.'.&nbsp;&nbsp;</td>
                                            <td class="alignleft" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; text-align: left; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0 5px 0;" align="right" valign="top">'.$process_level_name.' : '.$this->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->$NIK).', <strong>'.$this->detail_status_approval($data->$Apv).'</strong> '.$this->detail_date_format($data->$Tgl).' <strong><i><font color="red">'.$data->$Remark.'</font></i></strong></td>
                                            </tr>';                                            
                                        }                                  


                                    $body .='</table>
                                </td>
                              </tr>';
                              

                              $body .= $this->approval_action_link($primary_key, $session_nik, $level_id, $status, $workflow_id);


                            $body .='</table>
                          </td>
                        </tr>              
                        
                      </table>
                    </td>
                  </tr>
                </table>
                  <div class="footer" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; width: 100%; clear: both; color: #999; margin: 0; padding: 10px;">
                  <table width="100%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                    <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                      <td class="aligncenter content-block" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 10px;" align="center" valign="top">Perhatian email ini dikirim secara otomatis dari System. Jangan membalas ke alamat ini.</td>
                    </tr>
                    <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">
                      <td class="aligncenter content-block" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 10px;" align="center" valign="top">Powered By <a href="https://apps.unias.com" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">M.I.S</a> All Rights Reserved.</td>
                    </tr>
                  </table>
                  </div>
                </div>
            </td>
            <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; margin: 0;" valign="top"></td>
          </tr>
        </table>
        </body>
        </html>
        ';
       

        $email_to_address   = $this->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Email', $session_nik);
        $email_to_address = 'ronaldo.pangasian@unias.com';
        //$email_to_address   = 'dompak.sinambela@unias.com';
        $email_subject      = '['.$subject.'] Permohonan Cuti '.$data->EmployeeName;  
        
        $this->cms_send_email($this->email_from_address, $this->email_from_name, $email_to_address, $email_subject, $body); 


        return $email_to_address;
                       
    }


    public function approval_action_link($primary_key, $session_nik, $level_id, $status, $workflow_id){
      
        $this->db->select('*')
                 ->from($this->table_header)
                 ->where('CutiId', $primary_key);
        $db = $this->db->get();
        $data = $db->row(0);
        $num_row = $db->num_rows();

        $NIK    = 'NIK'.$level_id;
        $Tgl    = 'Tgl'.$level_id;
        $Apv    = 'Apv'.$level_id;
        $Pin    = 'Pin'.$level_id;
        $Remark = 'Remark'.$level_id;   

        if($level_id == 1){
            $Accept = 'Verify';
        }
        else{
            $Accept = 'Accept';
        }      

        $url_accept = $this->cms_asfa_services().'form_vacation/?id='.$primary_key.'&action=accept&level='.$level_id.'&token='.$data->$Pin;
        $url_reject = $this->cms_asfa_services().'form_vacation/?id='.$primary_key.'&action=reject&level='.$level_id.'&token='.$data->$Pin;                                                   

        $action_text  = '<tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">';
        $action_text .= '<td colspan="2" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; margin: 0; padding: 5px 0;" valign="top">';
        $action_text .= '<table class="invoice-items" cellpadding="0" cellspacing="0" style="text-align: center; font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; width: 100%; margin: 0;">';
        $action_text .= '<tr class="total" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">';
        $action_text .= '<td colspan="3" class="alignright" width="100%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; text-align: left; border-top-width: 1px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 1px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0 5px 0;" align="right" valign="top">Klik tombol dibawah untuk memproses form ini</td>'; 
        $action_text .= '</tr>';
        $action_text .= '<tr>';
        $action_text .= '<td colspan="3">&nbsp;</td>';
        $action_text .= '</tr>';
        $action_text .= '<tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; margin: 0;">';

        
        $action_text .= '<td class="content-block" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">';
        $action_text .= '<a href="'.$url_accept.'" class="btn-primary" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">&nbsp;&nbsp;'.$Accept.'&nbsp;&nbsp;</a>';
        $action_text .= '</td>';

        
        $action_text .= '<td class="content-block" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">';
        $action_text .= '<a href="'.$url_reject.'" class="btn-primary" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #ea0918; margin: 0; border-color: #ea0918; border-style: solid; border-width: 10px 20px;">&nbsp;&nbsp;Reject&nbsp;&nbsp;</a>';
        $action_text .= '</td>';
        
      
        $action_text .= '</tr>';                                                
        $action_text .= '</table>';
        $action_text .= '</td>';
        $action_text .= '</tr>';

        if ($status == 1 && $num_row >0){
            return $action_text;
        }
        else{
            return '';
        }   

    }


    public function body_detail_cuti($primary_key){
        $html = '<ul>';

        $query = $this->db->query("select * from ".$this->table_detail." as a where a.CutiId=".$primary_key." order by a.TglCuti asc");

        foreach ($query->result() as $key => $row) {

            if($row->AllocationId == 1 && !is_null($row->AllocationId)){
                $type = '(Tahunan)';
            }
            elseif($row->AllocationId == 2 && !is_null($row->AllocationId)){
                $type = '(Besar)';
            }
            elseif($row->AllocationId == 0 && !is_null($row->AllocationId)){
                $type = '(Hutang)';
            }
            else{
                $type = '';
            }

            $html .= '<li>'.$this->day_name_id($row->TglCuti).', '.$this->basic_date_format($row->TglCuti).' '.$type.'</li>';
        }

        $html .= '</ul>';

        return $html;
    }

    public function detail_status_approval($value){

        if($value == 'P'){
            return 'Process';
        }
        else if($value == 'A'){
            return 'Accepted';
        }
        else if($value == 'R'){
            return 'Rejected';
        }
        else if($value == 'X'){
            return 'Voided';
        }
        else{
            return '';
        }     
    }

}