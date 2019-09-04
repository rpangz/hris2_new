<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Reminder untuk cuti form pengajuan cuti

class Reminder_Form_Cuti extends CMS_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');  
        $this->load->model('kehadiran/Kehadiran_Model');
        $this->load->model('kehadiran/Kehadiran_Mailer_Model');              
    }

    public function index(){    

        $query = $this->db->query("select * from tbl_formcuti_temp as a where a.StatusForm='P' order by a.CutiId ASC LIMIT 1");

        foreach ($query->result() as $key => $data) {

            $NIK        = 'NIK'.$data->ApvLevel;
            $user_nik   = 4833;

            $comments   = 'Dear '.$this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $user_nik).', Mohon form dibawah ini diproses.';

            $this->Kehadiran_Mailer_Model->mailer_form_cuti(8528, 4833, $data->ApvLevel, $workflow_id=1, $status=1, $act='P', $subject='Reminder', $data->companyID, $comments);
        }

    }      

}