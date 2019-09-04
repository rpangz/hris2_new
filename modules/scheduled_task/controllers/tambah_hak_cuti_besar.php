<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// semua cuti memiliki masa aktif 3 Tahun setelah tanngal cuti muncul

class tambah_hak_cuti_besar extends CI_Controller {

    protected $URL_MAP = array();

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('scheduled_task_mailer_model');   

    }

    public function index(){      
      // Sisindokom
      $join_date = date('Y-m-d');      

      if($this->count_user_haveed($where='=2', $join_date) > 0){
        $result = $this->get_data_karyawan($where='=2', $join_date);        
          $query = $this->db->select('*')
                 ->from('tbl_apv_hrd AS a')
                 ->join('tbl_profile AS b','b.NIK=a.hrd_nik','INNER')
                 ->where('bStatus',1)
                 ->where('hrd_company', 2)
                 ->where('hrd_modules', 'form_cuti')
                 ->group_by('b.NIK')                                              
                 ->order_by('NIK','ASC')
                 ->get();          
          
          foreach($query->result() as $data){

              $this->scheduled_task_mailer_model->mailer_hak_cuti_besar($primary_key=NULL, $data->NIK, $result, $join_date);
            
          }

      }

      // ASTEL & Group

      if($this->count_user_haveed($where='!=2', $join_date) > 0){

          $result = $this->get_data_karyawan($where='!=2', $join_date);
        
          $query = $this->db->select('*')
                 ->from('tbl_apv_hrd AS a')
                 ->join('tbl_profile AS b','b.NIK=a.hrd_nik','INNER')
                 ->where('bStatus',1)
                 ->where('hrd_company !=', 2)
                 ->where('hrd_modules', 'form_cuti')
                 ->group_by('b.NIK')                                              
                 ->order_by('NIK','ASC')
                 ->get();          
          
          foreach($query->result() as $data){

              $this->scheduled_task_mailer_model->mailer_hak_cuti_besar($primary_key=NULL, $data->NIK, $result, $join_date);
          }

      }      

        $data = array(
            'title' => '[HRIS] Scheduled Task',
            'content' => 'Done',            
        );

        $this->load->view('scheduled_task_new/tambah_hak_cuti_besar_view',$data);
    }    

    

    public function count_user_haveed($where, $date){        
        
        $input_date= strtotime($date);

        $tahun10  = date('Y-m-d', strtotime('-10 year', $input_date));
        $tahun15  = date('Y-m-d', strtotime('-15 year', $input_date));
        $tahun20  = date('Y-m-d', strtotime('-20 year', $input_date));
        $tahun25  = date('Y-m-d', strtotime('-25 year', $input_date));

        $SQL   = "SELECT NIK,Nama, Email FROM tbl_profile WHERE bStatus=1 AND 
                  (TglMasuk = '".$tahun10."' OR TglMasuk='".$tahun15."' OR TglMasuk='".$tahun20."' OR TglMasuk='".$tahun25."') AND CompanyId ".$where." ORDER BY NIK ASC";

        $query = $this->db->query($SQL);
        $count = $query->num_rows();
        $data   = $query->row();

        return $count;        
    }

    public function get_data_karyawan($where, $date){

        $input_date= strtotime($date);

        $tahun10  = date('Y-m-d', strtotime('-10 year', $input_date));
        $tahun15  = date('Y-m-d', strtotime('-15 year', $input_date));
        $tahun20  = date('Y-m-d', strtotime('-20 year', $input_date));
        $tahun25  = date('Y-m-d', strtotime('-25 year', $input_date));

        $SQL   = "SELECT NIK,Nama, Email, TglMasuk, CompanyId FROM tbl_profile WHERE bStatus=1 AND 
                  (TglMasuk = '".$tahun10."' OR TglMasuk='".$tahun15."' OR TglMasuk='".$tahun20."' OR TglMasuk='".$tahun25."') AND CompanyId ".$where." ORDER BY NIK ASC";

        $query = $this->db->query($SQL);
        $count = $query->num_rows();

        return $query->result();
    }      

}