<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * TASKSPA - A PA Tasks
 * NOTE: To Reminder user that they have a jobs
 * @package Scheduled Task PA-KPI
 * @author Dompak Petrus Sinambela
 * @copyright 03-Oct-2017
 * @version 1
*/

class tasks_performance_appraisal extends CMS_Controller {

    protected $URL_MAP = array();

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('mailer_model');       

    }    

    public function index(){

        /* Notifikasi ke Karyawan supaya membuat KPI Awal Tahun */
        //$this->send_reminder_renewal();


        /* Notifikasi untuk membuat KPI Tahunan */
        $this->send_reminder_user();

        
        /* Kirim Notifikasi ke karyawan untuk selalu update KPI Activity (Belum Sepakat)*/
        $this->send_reminder_user_progress_undeal();


        /* Kirim Notifikasi ke karyawan untuk selalu update KPI Achievement (Sudah Sepakat)*/
        $this->send_reminder_user_progress_deal();

        /* Notofikasi untuk atasan melakukan approval */
        $this->send_reminder_atasan_untuk_approval();        

        /* Notofikasi ke Atasan supaya menyuruh staff membuat KPI Tahunan */
        //$this->send_reminder_atasan();

        /* Notifikasi ke karyawan supaya mengisi Score Semester Pertama */
        $this->send_reminder_user_input_score_semeter_pertama();

        /* Notifikasi ke karyawan supaya mengisi Score Semester Kedua */
        $this->send_reminder_user_input_score_semeter_kedua();

    }

    public function send_reminder_user(){
        $today = date('Y-m-d');
        $year = date('Y');

        //$days = date('m-d');
        $days = date('n');

        //if ($days=='04-22' || $days =='04-23' || $days =='04-24' || $days =='04-25' || $days =='04-26' || $days =='04-27' || $days =='04-28' || $days =='04-29' || $days =='04-30'){
        if ($days == 1){

            $SQL      = "SELECT NIK, Nama, CompanyId, DivisiId, DeptID, UnitID, Email FROM tbl_profile as b WHERE b.bStatus=1 AND b.CompanyId=2 AND NOT EXISTS(SELECT * FROM tbl_kpi_header_form as a WHERE b.NIK = a.EmployeeID AND PeriodID='".$year."') ORDER BY b.NIK ASC";
            $query    = $this->db->query($SQL);        
            $num_row  = $query->num_rows();

            foreach($query->result() as $data){
                
                $this->mailer_model->send_reminder_user($data->NIK, $data->Nama, $data->Email, $year);
                 
            }

        }
    }


    public function send_reminder_renewal(){
        $today = date('Y-m-d');
        $year  = date('Y');

        $days  = date('m-d');

        if (((date('j') - 1) % 3) == 0){

            $SQL      = "SELECT b.NIK, b.Nama, b.CompanyId, b.DivisiId, b.DeptID, b.UnitID, b.Email,b.TglMasuk,TIMESTAMPDIFF(MONTH,b.TglMasuk,'".$year."-12-31') as Lama_Kerja_Month FROM tbl_profile as b WHERE b.bStatus=1 AND b.CompanyId=2 AND NOT EXISTS(SELECT * FROM tbl_kpi_header_form as a WHERE b.NIK = a.EmployeeID AND PeriodID='".$year."') having Lama_Kerja_Month >=5 ORDER BY b.NIK ASC";
            $query    = $this->db->query($SQL);        
            $num_row  = $query->num_rows();

            foreach($query->result() as $data){
                
                $this->mailer_model->send_reminder_user($data->NIK, $data->Nama, $data->Email, $year);
                 
            }
        }
    }


    public function send_reminder_atasan(){
        $today = date('Y-m-d');

        if ($today >= '2017-05-01' && $today <= '2017-05-15'){

        if (((date('j') - 1) % 3) == 0){

        $query = $this->db->select('superiors_nik AS NIK, superiors_name AS Nama, Email')
                          ->from('tbl_apv_group_superiors')
                          ->join('tbl_profile','tbl_profile.NIK=superiors_nik')  
                          ->order_by('superiors_nik','ASC')
                          ->get();

        foreach($query->result() as $data){
            $total      = $this->count_bawahan($data->NIK);
            if ($total > 0){

                $this->mailer_model->send_reminder_atasan($data->NIK, $data->Nama, $data->Email, $total, $this->get_data_bawahan($data->NIK));
            
            }
        }

        }

      }

    }


    public function send_reminder_user_input_score_semeter_pertama(){
        $today = date('Y-m-d');
        $year  = date('Y');
        $days  = date('m-d');

        if ($days >='07-01' && $days <= '07-31' && ((date('j') - 1) % 3) == 0){

            $SQL      = "SELECT NIK, Nama, CompanyId, DivisiId, DeptID, UnitID, Email FROM tbl_profile as b WHERE b.bStatus=1 AND b.CompanyId=2 AND EXISTS(SELECT * FROM tbl_kpi_header_form as a WHERE b.NIK = a.EmployeeID AND a.iAgree=1 AND PeriodID='".$year."') ORDER BY b.NIK ASC";
            $query    = $this->db->query($SQL);        
            $num_row  = $query->num_rows();

            foreach($query->result() as $data){
                
                $this->mailer_model->kirim_email_penilaian_semester_pertama($data->NIK, $data->Nama, $data->Email, $year);
                 
            }

        }
    }


    public function send_reminder_user_input_score_semeter_kedua(){
        $today = date('Y-m-d');
        $year  = date('Y');
        $days  = date('m-d');

        if ($days >='12-01' && $days <='12-31' && ((date('j') - 1) % 3) == 0){

            $SQL      = "SELECT NIK, Nama, CompanyId, DivisiId, DeptID, UnitID, Email FROM tbl_profile as b WHERE b.bStatus=1 AND b.CompanyId=2 AND EXISTS(SELECT * FROM tbl_kpi_header_form as a WHERE b.NIK = a.EmployeeID AND a.iAgree=1 AND PeriodID='".$year."') ORDER BY b.NIK ASC";
            $query    = $this->db->query($SQL);        
            $num_row  = $query->num_rows();

            foreach($query->result() as $data){
                
                $this->mailer_model->kirim_email_penilaian_semester_kedua($data->NIK, $data->Nama, $data->Email, $year);
                 
            }

        }
    }


    public function send_reminder_user_progress_undeal(){
        $today = date('Y-m-d');
        $year  = date('Y');
        $days  = date('d');

        if ($days == '01'){

            $SQL      = "SELECT NIK, Nama, CompanyId, DivisiId, DeptID, UnitID, Email FROM tbl_profile as b WHERE b.bStatus=1 AND b.CompanyId=2 AND EXISTS(SELECT * FROM tbl_kpi_header_form as a WHERE b.NIK = a.EmployeeID AND iAgree=0 AND PeriodID='".$year."') ORDER BY b.NIK ASC";
            $query    = $this->db->query($SQL);        
            $num_row  = $query->num_rows();

            foreach($query->result() as $data){
                
                $this->mailer_model->kirim_email_reminder_progress($data->NIK, $data->Nama, $data->Email, $year);
                 
            }
        }
    }


    public function send_reminder_user_progress_deal(){
        $today = date('Y-m-d');
        $year  = date('Y');
        $days  = date('d');

        if ($days == '01'){

            $SQL      = "SELECT NIK, Nama, CompanyId, DivisiId, DeptID, UnitID, Email FROM tbl_profile as b WHERE b.bStatus=1 AND b.CompanyId=2 AND EXISTS(SELECT * FROM tbl_kpi_header_form as a WHERE b.NIK = a.EmployeeID AND iAgree=1 AND PeriodID='".$year."') ORDER BY b.NIK ASC";
            $query    = $this->db->query($SQL);        
            $num_row  = $query->num_rows();

            foreach($query->result() as $data){
                
                $this->mailer_model->kirim_email_reminder_progress($data->NIK, $data->Nama, $data->Email, $year);
                 
            }

        }
    }



    public function send_reminder_atasan_untuk_approval(){
        $today = date('Y-m-d');
        $year  = date('Y');       

        if (((date('j') - 1) % 3) == 0){    

          $SQL      = "SELECT superiors_nik AS NIK, superiors_name AS Nama, Email,KPIID,EmployeeID FROM tbl_apv_group_superiors AS a INNER JOIN tbl_profile AS b ON b.NIK=superiors_nik INNER JOIN tbl_kpi_header_form AS c ON a.superiors_nik=c.iAtasanNIK WHERE c.iAgree = 0 AND c.PeriodID='".$year."' GROUP BY a.superiors_nik";
          $query    = $this->db->query($SQL);        
          $num_row  = $query->num_rows();

          foreach($query->result() as $data){              
              $this->mailer_model->send_reminder_atasan_approval($data->NIK, $data->Nama, $data->Email, $total, $this->get_data_bawahan_belum_approval($data->NIK));    
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

    public function count_bawahan($user_id){
        $year = date('Y');

        $SQL      = "SELECT tbl_profile.NIK AS NIK, tbl_profile.Nama AS Nama,superiors_name AS Atasan, CompanyId, DivisiId, DeptID, UnitID, Email FROM `tbl_apv_group_bawahan` INNER JOIN 
                     tbl_apv_group_superiors ON tbl_apv_group_bawahan.superiors_id=tbl_apv_group_superiors.superiors_id INNER JOIN 
                     tbl_profile ON tbl_profile.NIK=tbl_apv_group_bawahan.NIK 
                     WHERE bStatus=1 AND superiors_nik='".$user_id."' AND NOT EXISTS(SELECT * FROM tbl_kpi_header_form WHERE tbl_apv_group_bawahan.NIK = tbl_kpi_header_form.EmployeeID AND PeriodID='".$year."') 
                     ORDER BY superiors_nik";

        $query    = $this->db->query($SQL);        
        $num_row  = $query->num_rows();
        return $num_row;
    }


    public function get_data_bawahan($user_id){
        $year = date('Y');

        $SQL      = "SELECT tbl_profile.NIK AS NIK, tbl_profile.Nama AS Nama,superiors_name AS Atasan, CompanyId, DivisiId, DeptID, UnitID, Email FROM `tbl_apv_group_bawahan` INNER JOIN 
                     tbl_apv_group_superiors ON tbl_apv_group_bawahan.superiors_id=tbl_apv_group_superiors.superiors_id INNER JOIN 
                     tbl_profile ON tbl_profile.NIK=tbl_apv_group_bawahan.NIK 
                     WHERE bStatus=1 AND superiors_nik='".$user_id."' AND NOT EXISTS(SELECT * FROM tbl_kpi_header_form WHERE tbl_apv_group_bawahan.NIK = tbl_kpi_header_form.EmployeeID AND PeriodID='".$year."') 
                     ORDER BY superiors_nik";

        $query    = $this->db->query($SQL);        
        $num_row  = $query->num_rows();
        return $query->result();
    }


    public function get_data_bawahan_belum_approval($user_id){
        $year = date('Y');
        $SQL      = "SELECT b.NIK AS NIK,b.Nama AS Nama,b.CompanyId, b.DivisiId, b.DeptID, b.UnitID, b.Email FROM tbl_kpi_header_form AS a INNER JOIN tbl_profile AS b ON a.EmployeeID=b.NIK WHERE a.PeriodID='".$year."' AND a.iAtasanNIK='".$user_id."' AND a.iAgree=0";
        $query    = $this->db->query($SQL);        
        $num_row  = $query->num_rows();
        return $query->result();
    }
    

}