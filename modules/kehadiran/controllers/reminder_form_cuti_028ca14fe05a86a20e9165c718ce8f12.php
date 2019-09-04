<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Reminder untuk cuti form pengajuan cuti

class Reminder_Form_Cuti_028ca14fe05a86a20e9165c718ce8f12 extends CMS_Controller {

    public function __construct(){

        parent::__construct();
        $this->load->helper('url');  
        $this->load->model($this->cms_module_path().'/Kehadiran_Model');
        $this->load->model($this->cms_module_path().'/Kehadiran_Mailer_Model'); 

        $this->table_header = cms_module_config($this->cms_module_path(), 'table_header');
        $this->table_detail = cms_module_config($this->cms_module_path(), 'table_detail');   

    }

    public function index(){    

        $query = $this->db->query("select * from ".$this->table_header." as a where a.StatusForm='P' and a.JenisCuti <=2 and version=1 order by a.CutiId ASC");

        foreach ($query->result() as $key => $data) {

            $NIK        = 'NIK'.$data->ApvLevel;            
            $comments   = 'Dear '.$this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->$NIK).', Mohon form dibawah ini diproses.';

            $this->Kehadiran_Mailer_Model->mailer_form_cuti($data->CutiId, $data->$NIK, $data->ApvLevel, $workflow_id=1, $status=1, $act='P', $subject='Reminder', $data->companyID, $comments);
        }
    }      
    
}