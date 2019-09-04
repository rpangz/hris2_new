<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Reminder untuk cuti besar yang kan habis

class reminder_expired_hak_cuti_besar extends CMS_Controller {

    protected $URL_MAP = array();

    protected $hak_cuti_besar = 2;

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('scheduled_task_mailer_model');
        $this->load->model($this->cms_module_path().'/hak_cuti_model');                   

    }

    public function index(){       
            
      $date         = date('Y-m-d');
      $tanggal      = strtotime($date);

      $check_month  = array('3', '2', '1');
      $arrlength    = count($check_month);

      for($x = 0; $x < $arrlength; $x++) {

          $round_bulan  = date('Y-m-d',strtotime('+'.$check_month[$x].' month', $tanggal));

          $cuti         = $this->hak_cuti_model->get_hak_cuti($round_bulan, $this->hak_cuti_besar);

          foreach ($cuti as $key => $value) {

              $sisa_cuti = $this->hak_cuti_model->hitung_sisa_cuti($value['HakId'], $this->hak_cuti_besar);

              $jumlah_sisa_cuti = $value['Qty'] - $sisa_cuti['total'];

              $user = $this->hak_cuti_model->user_profile($value['HakId']);

              if($sisa_cuti['status'] == 1 AND $jumlah_sisa_cuti > 0){

                  $this->scheduled_task_mailer_model->mailer_reminder_hak_cuti_besar($value['HakId'], $jumlah_sisa_cuti, $user['NIK'], $user['Nama'], $user['Email'], $check_month[$x]);

              }          
          }

      }          
     
        $data = array(
            'title' => '[HRIS] Scheduled Task',
            'content' => $cuti,
            'result' => $check_month,
            'check_tanggal' =>  $round_bulan,           
        );

        $this->load->view('scheduled_task/reminder_expired_hak_cuti_besar_view',$data);
    }   

      

}