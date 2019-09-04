<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class tasks_performance_appraisal extends CMS_Controller {

    protected $URL_MAP = array();

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('mailer_model');       

    }    

    public function index(){
      $this->load->model('mailer_model');
        
      $this_days = date('d');



      //$this->mailer_model->send_reminder_atasan($primary_key=NULL, $session_nik=NULL);

      /*

      if ($this_days==1 || $this_days ==15){

        $query = $this->db->select('*')
                          ->from('tbl_kpi_header_form')    
                          ->order_by('KPIID','ASC')
                          ->get();

        foreach($query->result() as $data){
            $this->development_mailer_model->mailer_form_kasbon($data->KPIID, $data->EmployeeID);            
        }        

      }
      */

      $data = array(
          'title' => '[HRIS] Scheduled Task',
      );

    }

    public function send_reminder_user(){
        $today = date('Y-m-d');
        $year = date('Y');

        $days = date('m-d');

        if ($days=='04-22' || $days =='04-23' || $days =='04-24' || $days =='04-25' || $days =='04-26' || $days =='04-27' || $days =='04-28' || $days =='04-29' || $days =='04-30'){

            $SQL      = "SELECT NIK, Nama, CompanyId, DivisiId, DeptID, UnitID, Email FROM tbl_profile as b WHERE b.bStatus=1 AND b.CompanyId=2 AND NOT EXISTS(SELECT * FROM tbl_kpi_header_form as a WHERE b.NIK = a.EmployeeID AND PeriodID='".$year."') ORDER BY b.NIK ASC";
            $query    = $this->db->query($SQL);        
            $num_row  = $query->num_rows();

            foreach($query->result() as $data){
                
                $this->mailer_model->send_reminder_user($data->NIK, $data->Nama, $data->Email);
                 
            }

        }
    }

    public function send_reminder_atasan(){
        $today = date('Y-m-d');

        if ($today >= '2017-05-01' && $today <= '2017-05-15'){

        if (((date('j') - 1) % 3)){

        $query = $this->db->select('tbl_apv_group_approval.NIK AS NIK, tbl_apv_group_approval.iUnitID AS iUnitID, Email, Nama')
                          ->from('tbl_apv_group_approval')
                          ->join('tbl_profile','tbl_profile.NIK=tbl_apv_group_approval.NIK')
                          ->where('tbl_apv_group_approval.companyID', 2)
                          ->where('form_kpi', 1)
                          ->group_by('tbl_apv_group_approval.NIK')    
                          ->order_by('tbl_apv_group_approval.NIK','ASC')
                          ->get();

        foreach($query->result() as $data){

            $unit_user = $this->get_dept_atasan($data->NIK);

            $total = $this->count_bawahan($data->NIK, $unit_user);

            if ($total > 0){

                $this->mailer_model->send_reminder_atasan($data->NIK, $data->Nama, $data->Email, $total, $this->get_data_bawahan($data->NIK, $unit_user));
            
            }            

        }

        }

      }

    }

    public function __count_user_kpi($user_id){

        $year = date('Y');

        $this->db->select('count(KPIID) AS Total')->from('tbl_kpi_header_form')->where('EmployeeID', $user_id)->where('PeriodID', $year);
        $db      = $this->db->get();
        $data    = $db->row(0);
        $num_row = $db->num_rows();

        if ($num_row > 0){
            return $data->Total;
        }
        else{
            return 0;
        }
    }

    public function count_user_kpi($user_id){
        $year = date('Y');
        $SQL      = "SELECT NIK,Nama,CompanyId, DivisiId, DeptID, UnitID, Email FROM tbl_profile as b WHERE b.bStatus=1 AND b.CompanyId=2 AND b.NIK ='".$user_id."' AND NOT EXISTS(SELECT * FROM tbl_kpi_header_form as a WHERE b.NIK = a.EmployeeID AND PeriodID='".$year."') ORDER BY b.NIK ASC";

        $query    = $this->db->query($SQL);        
        $num_row  = $query->num_rows();
        return $num_row;
    }

    public function count_bawahan($user_id, $unit_id){
        $year = date('Y');

        $SQL      = "SELECT NIK, Nama, CompanyId, DivisiId, DeptID, UnitID, Email FROM tbl_profile as b WHERE b.bStatus=1 AND b.CompanyId=2 AND FIND_IN_SET(b.UnitID,'".$unit_id."') AND b.NIK !=".$user_id." AND NOT EXISTS(SELECT * FROM tbl_kpi_header_form as a WHERE b.NIK = a.EmployeeID AND PeriodID='".$year."') ORDER BY b.UnitID ASC";

        $query    = $this->db->query($SQL);        
        $num_row  = $query->num_rows();
        return $num_row;
    }


    public function get_data_bawahan($user_id, $unit_id){
        $year = date('Y');

        $SQL      = "SELECT NIK,Nama,CompanyId, DivisiId, DeptID, UnitID, Email FROM tbl_profile as b WHERE b.bStatus=1 AND b.CompanyId=2 AND FIND_IN_SET (b.UnitID,'".$unit_id."') AND b.NIK !=".$user_id." AND NOT EXISTS(SELECT * FROM tbl_kpi_header_form as a WHERE b.NIK = a.EmployeeID AND PeriodID='".$year."') ORDER BY b.UnitID ASC";

        $query    = $this->db->query($SQL);        
        $num_row  = $query->num_rows();
        return $query->result();
    }

    public function get_dept_atasan($user_id){
        $year = date('Y');

        $SQL      = "SELECT UnitID FROM tbl_apv_group_approval WHERE companyID=2 AND NIK='".$user_id."' GROUP BY UnitID ORDER BY UnitID ASC";
        $query    = $this->db->query($SQL);        
        $num_row  = $query->num_rows();
        $html     = '';

        foreach($query->result() as $data){
            $html .= $data->UnitID.',';
        }

        return $html;
    }    

}