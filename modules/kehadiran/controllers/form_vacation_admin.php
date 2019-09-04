<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of form_vacation
 *
 * @author Dompak Petrus Sinambela
 */
class Form_Vacation_Admin extends CMS_Priv_Strict_Controller {

    protected $URL_MAP = array();
    protected $php_date_format;

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');        
        $this->load->library('session');

        if(!isset($_SESSION)){
            session_start();
        }
        $this->load->model($this->cms_module_path().'/Kehadiran_Model');
        $this->load->model($this->cms_module_path().'/Kehadiran_Mailer_Model');
        //$this->Kehadiran = new Kehadiran_Model();  

        //$this->company = $this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='CompanyId', $this->cms_user_id());
        //$this->department = $this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='DeptID', $this->cms_user_id());
        //$this->full_name = $this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $this->cms_user_id()); 

        $this->table_header = cms_module_config($this->cms_module_path(), 'table_header');
        $this->table_detail = cms_module_config($this->cms_module_path(), 'table_detail');

        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        $this->php_date_format = $date_format;
    }


    public function cms_complete_table_name($table_name){
        $this->load->helper($this->cms_module_path().'/function');
        if(function_exists('cms_complete_table_name')){
            return cms_complete_table_name($table_name);
        }else{
            return parent::cms_complete_table_name($table_name);
        }
    }

    private function __random_string($length=10){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $size = strlen( $chars );
        $str = '';
        for( $i = 0; $i < $length; $i++ ){
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }
        return $str;
    }

    public function generate_token(){
        $alphaNumeric   = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $random         = substr(str_shuffle($alphaNumeric), 0, 7);
        $token          = md5($random);
        return $token;
    }

    private function make_crud(){
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // initialize groceryCRUD
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud = $this->new_crud();
        // this is just for code completion
        if (FALSE) $crud = new Extended_Grocery_CRUD();

        // check state & get primary_key
        $state = $crud->getState();
        $state_info = $crud->getStateInfo();
        $primary_key = isset($state_info->primary_key)? $state_info->primary_key : NULL;
        switch($state){
            case 'unknown': break;
            case 'list' : break;
            case 'add' : break;
            case 'edit' : break;
            case 'delete' : break;
            case 'insert' : break;
            case 'update' : break;
            case 'ajax_list' : break;
            case 'ajax_list_info': break;
            case 'insert_validation': break;
            case 'update_validation': break;
            case 'upload_file': break;
            case 'delete_file': break;
            case 'ajax_relation': break;
            case 'ajax_relation_n_n': break;
            case 'success': break;
            case 'export': break;
            case 'print': break;
        }

        // unset things
        $crud->unset_jquery();
        //$crud->unset_read();
        //$crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        $crud->unset_export();

        $crud->set_theme('no-flexigrid-form-vacation');

        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_city_model');
        */
        //$crud->set_theme('flexigrid');
        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->table_header);
        $crud->where('version', 1);
        //$crud->where('FIND_IN_SET ('.$this->table_header.'.companyID,"'.$this->allowed_company().'")');
        $crud->order_by('CutiId','DESC');


        // primary key
        $crud->set_primary_key('CutiId');

        // set subject
        $crud->set_subject('Tabel form cuti');

        // displayed columns on list
        $crud->columns('FormCutiNIK','EmployeeName','Keperluan','JenisCuti','Detail','TglMasuk','ApvLevel','StatusForm','companyID');
        // displayed columns on edit operation
        $crud->edit_fields('FormCutiNIK','NIK','JenisCuti','Keperluan','Detail','TglMasuk','ApvLevel','StatusForm');
        // displayed columns on add operation
        $crud->add_fields('FormCutiNIK','NIK','JenisCuti','Keperluan','Detail','TglMasuk','ApvLevel','StatusForm');

        //$crud->add_action($this->cms_lang('Batalkan form cuti'), 'glyphicon glyphicon-remove text-danger', '','btn btn-xs btn-default btn-flat void-settlement',array($this,'_callback_Void_Settlement'));
      
        // caption of each columns
        $crud->display_as('FormCutiNIK','NIK');
        $crud->display_as('EmployeeName','Nama');
        $crud->display_as('companyID','Company');
        $crud->display_as('JenisCuti','Tipe');
        $crud->display_as('TglMasuk','Tgl Masuk');
        $crud->display_as('ApvLevel','Approval');
        $crud->display_as('StatusForm','Status');
        $crud->display_as('Detail','Qty');

        
        $crud->required_fields('name');

        
        //$crud->unique_fields('name');

        //$crud->set_relation('JenisCuti', $this->cms_complete_table_name('jeniscuti'), 'JenisCutiName',array('id !=' => 0));
        $crud->set_relation('ApvLevel', $this->cms_complete_table_name('apv_matrik_approval'), '{MatName}',array('MatCode' => 1));

        // Callback
        $crud->callback_column('StatusForm',array($this,'_callback_column_StatusForm'));
        $crud->callback_column('JenisCuti',array($this,'_callback_column_JenisCuti'));
        $crud->callback_column('companyID',array($this,'_callback_column_companyID'));
        $crud->callback_column('Detail',array($this, '_callback_column_citizen'));

    
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));
       

        $this->crud = $crud;
        return $crud;
    }

    public function index(){

        $crud = $this->make_crud();

        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        //$sisa_cuti_tahunan = $this->Kehadiran_Model->total_sisa_cuti_tahunan($this->cms_user_id());
        //$sisa_cuti_besar   = $this->Kehadiran_Model->total_sisa_cuti_besar($this->cms_user_id());


        //$sisa_cuti_tahunan = 2;
        //$sisa_cuti_besar   = 3;


        // the honey_pot, every fake input should be empty
        $honey_pot_pass = (strlen($this->input->post('Keperluan', ''))==0) &&
            (strlen($this->input->post('Alamat', ''))==0) &&
            (strlen($this->input->post('NoTelpon', ''))==0) &&
            (strlen($this->input->post('TglMasuk', ''))==0);
        if(!$honey_pot_pass){
            show_404();
            die();
        }  



        if(!isset($_SESSION['__main_form_cuti_button_hidden_session'])){
            $_SESSION['__main_form_cuti_button_hidden_session'] = 1;
        }


        $previous_secret_code = $this->session->userdata('__main_registration_secret_code');
        if($previous_secret_code === NULL){
            $previous_secret_code = $this->__random_string();
        }
        //get user input
        $Keperluan        = $this->input->post($previous_secret_code.'Keperluan');
        $Alamat       = $this->input->post($previous_secret_code.'Alamat');
        $NoTelpon   = $this->input->post($previous_secret_code.'NoTelpon');
        $NIKPengganti      = $this->input->post($previous_secret_code.'NIKPengganti');
        $NIK1      = $this->input->post($previous_secret_code.'NIK1');
        $NIK2    = $this->input->post($previous_secret_code.'NIK2');
        $NIK3     = $this->input->post($previous_secret_code.'NIK3');        

        //set validation rule
        $this->form_validation->set_rules($previous_secret_code.'Keperluan', 'Keperluan', 'required|xss_clean');
        $this->form_validation->set_rules($previous_secret_code.'Alamat', 'Alamat', 'required|xss_clean');

        // generate new secret code
        $secret_code = $this->__random_string();
        $this->session->set_userdata('__main_registration_secret_code', $secret_code);
        if ($this->form_validation->run()) {

            $data['NIK3']      = $NIK3;
            $data['Keperluan']         = $Keperluan;
            $data['Alamat']        = $Alamat;
            $data['NoTelpon']    = $NoTelpon;

            redirect('','refresh');
        } else {

            $output = $crud->render();
            $output->Keperluan = $Keperluan;
            $output->Alamat = $Alamat;
            $output->NoTelpon = $NoTelpon;
            $output->NIKPengganti = $NIKPengganti;
            $output->NIK1 = $NIK1;
            $output->NIK2 = $NIK2;
            $output->register_caption = $this->cms_lang('SUBMIT');
            $output->secret_code = $secret_code;
            $output->date_format = $date_format;  
            //$output->NoTelpon = $this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Hp', $this->cms_user_id());
            //$output->Alamat = $this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='AlamatDomisili', $this->cms_user_id());
            $output->semua_karyawan = $this->Kehadiran_Model->get_all_user(); 
            //$output->hrd_data_option =$this->Kehadiran_Model->hrd_data_option($this->company, $modules='form_cuti');  
            //$output->atasan_langsung_data_option = $this->Kehadiran_Model->atasan_langsung_data_option($this->department);  
            //$output->potential_substitution = $this->Kehadiran_Model->get_potential_substitution_user($this->cms_user_id());
            //$output->sisa_cuti_tahunan = $sisa_cuti_tahunan;
            //$output->sisa_cuti_besar   = $sisa_cuti_besar;                   
            //$output->sisa_cuti_gabungan= $sisa_cuti_tahunan+$sisa_cuti_besar;
            $output->date_format = $date_format;
            $output->module_path = $this->cms_module_path();

            $output->button_hidden_session = $_SESSION['__main_form_cuti_button_hidden_session'];

            $this->view($this->cms_module_path().'/form_vacation_admin_view', $output,
            $this->cms_complete_navigation_name('form_vacation_admin'));            
        }
    }

    public function _before_insert($post_array){
        
        return $post_array;   
        
    }

    public function _after_insert($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here       

        return $success;
    }

    public function _before_update($post_array, $primary_key){
        $post_array = $this->_before_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here
        return $post_array;
    }

    public function _after_update($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here
        return $success;
    }

    public function _before_delete($primary_key){
        // delete corresponding citizen
       
        return TRUE;
    }

    public function _after_delete($primary_key){
        return TRUE;
    }

    public function _after_insert_or_update($post_array, $primary_key){

        return TRUE;
    }

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }


    public function check_registration(){

        $this->cms_guard_page('kehadiran_form_vacation');

        if ($this->input->is_ajax_request()) {

            $EmployeeID = $this->input->post('EmployeeID');
            $Keperluan = $this->input->post('Keperluan');
            $Alamat = $this->input->post('Alamat');
            $NoTelpon = $this->input->post('NoTelpon');
            $NIKPengganti = $this->input->post('NIKPengganti');
            $NIK1 = $this->input->post('NIK1');
            $NIK2 = $this->input->post('NIK2');
            $NIK3 = $this->input->post('NIK3');
            $TglMasuk = $this->input->post('TglMasuk');
            $detail_cuti = $this->input->post('detail_cuti');
            $total_cuti = $this->input->post('total_cuti');
            $total = $this->input->post('total');
            $sepakat_utang = $this->input->post('sepakat_utang');

            $data_cuti = json_decode($this->input->post('detail_cuti'), TRUE);


            $data_cutiku = array();
            foreach($data_cuti as $key=>$cutiku){               
                    
                $data_cutiku[$key] = $this->Kehadiran_Model->date_to_sql($cutiku);
                    
            }


            $message   = "";
            $error = FALSE;
            if ($EmployeeID == "") {
                $message = $this->cms_lang("Karyawan harus diisi");
                $error = TRUE;
            }
            else if ($Keperluan == "") {
                $message = $this->cms_lang("Keperluan harus diisi");
                $error = TRUE;
            }
            else if(strlen($Keperluan) < 10){
                $message = $this->cms_lang("Keperluan minimal 10 karakter");
                $error = TRUE;
            }
            else if($Alamat =="") {
                $message = $this->cms_lang("Alamat harus diisi");
                $error = TRUE;
            }
            else if(strlen($Alamat) < 10){
                $message = $this->cms_lang("Alamat minimal 10 karakter");
                $error = TRUE;
            }
            else if($NoTelpon == "") {
                $message = $this->cms_lang("Nomor telp harus diisi");
                $error = TRUE;
            }
            else if(!$this->is_digits($NoTelpon)) {
                $message = $this->cms_lang("Nomor telp harus angka");
                $error = TRUE;
            }

            else if($TglMasuk == "") {
                $message = $this->cms_lang("Tanggal masuk harus diisi");
                $error = TRUE;
            }

            else if($NIKPengganti == "") {
                $message = $this->cms_lang("Petugas pengganti harus diisi");
                $error = TRUE;
            }

            else if($NIK1 == "") {
                $message = $this->cms_lang("Verifikator harus diisi");
                $error = TRUE;
            }
            else if($NIK2 == "") {
                $message = $this->cms_lang("Atasan Langsung harus diisi");
                $error = TRUE;
            }
            else if($NIK3 == "") {
                $message = $this->cms_lang("Atasan Lebih tinggi harus diisi");
                $error = TRUE;
            }
            else if($detail_cuti == "") {
                $message = $this->cms_lang("Tanggal cuti harus diisi");
                $error = TRUE;
            }

            else if($total_cuti > $total && $sepakat_utang==0) {
                $message = $this->cms_lang("Periode cuti melebihi sisa hak cuti, Untuk mengajukan hutang cuti <br/><a href='javascript:void(0)' onclick='callback_kesepakatan_utang(".$EmployeeID.")' title='Sepakat'>Klik Disini</a>.");
                $error = TRUE;
            }
            else if($total_cuti <= 0) {
                $message = $this->cms_lang("Silahkan pilih tanggal cuti anda");
                $error = TRUE;
            }
            else if(in_array($TglMasuk, $data_cuti)){
                $message = 'Tanggal kembali bekerja harus diluar tanggal cuti';
                $error= TRUE;                
            }

            else if($this->find_minimal_array($data_cutiku) >= $this->Kehadiran_Model->date_to_sql($TglMasuk) || $this->find_maksimal_array($data_cutiku) >= $this->Kehadiran_Model->date_to_sql($TglMasuk)){
                $message = 'Tanggal kembali bekerja harus hari setelah cuti';
                $error= TRUE;                
            }
            /*
            else if($this->Kehadiran_Model->count_form_still_process($EmployeeID) > 0){
                $message = 'Masih ada form pengajuan cuti yang belum selesai';
                $error= TRUE; 
            }
            */
            

            /*
            else if($NIKPengganti =="") {
                $message = $this->cms_lang("Karyawan pengganti harus ada");
                $error = TRUE;
            }
            else if($NIK1 =="") {
                $message = $this->cms_lang("Verifikator harus diisi");
                $error = TRUE;
            }
            else if($NIK2 =="") {
                $message = $this->cms_lang("Atasan Langsung harus diisi");
                $error = TRUE;
            }
            else if($NIK3 =="" && $RoundTrip==1) {
                $message = $this->cms_lang("Atasan Lebih Tinggi harus diisi");
                $error = TRUE;
            }  
            */
                  
                        

            $data = array(
                "exists" =>'',
                "error" => $error,
                "message" => $message
            );
            $this->cms_show_json($data);
        }
    }


    public function ajax_submit_form_cuti(){

        $todays = date('Y-m-d H:i:s');
        $today  = date('Y-m-d');

        $this->cms_guard_page('kehadiran_form_vacation');

        if ($this->input->is_ajax_request()) {

            $message   = "";
            $error = FALSE;

            $EmployeeID = $this->input->post('EmployeeID');
            $Keperluan = $this->input->post('Keperluan');
            $Alamat = $this->input->post('Alamat');
            $NoTelpon = $this->input->post('NoTelpon');
            $NIKPengganti = $this->input->post('NIKPengganti');
            $NIK1 = $this->input->post('NIK1');
            $NIK2 = $this->input->post('NIK2');
            $NIK3 = $this->input->post('NIK3');
            $TglMasuk = $this->input->post('TglMasuk');
            $detail_cuti = $this->input->post('detail_cuti');
            $detail_cuti_json = $this->input->post('detail_cuti_json');
            $total_cuti = $this->input->post('total_cuti');
            $total = $this->input->post('total');
            $sepakat_utang = $this->input->post('sepakat_utang');
            $data_cuti = json_decode($this->input->post('detail_cuti'), TRUE);

            $data_cuti_json = json_decode($this->input->post('detail_cuti_json'), TRUE);

            $update_records = $data_cuti_json['update'];

            $prioritas_cuti = $this->input->post('prioritas_cuti'); 

            $CompanyId = $this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='CompanyId', $EmployeeID);
            

            $EmployeeName = $this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $EmployeeID); 

        if($total_cuti > 0){

            if ($prioritas_cuti == 0){
                $HakCutiId = 0;
                $prioritas_cuti__=1;
            }
            elseif ($prioritas_cuti == 1){
                $prioritas_cuti__=1;
                $HakCutiId = $this->Kehadiran_Model->allocation_cuti($EmployeeID, 1);
            }
            elseif ($prioritas_cuti == 2) {
                $prioritas_cuti__=2;
                $HakCutiId = $this->Kehadiran_Model->allocation_cuti($EmployeeID, 2);
            }
            else{
                $prioritas_cuti__=1;
                $HakCutiId = 0;
            }          


            $data_header = array(
                'FormCutiNIK'=> $EmployeeID,
                'EmployeeName'=> $EmployeeName,
                'HakCutiId'=> $HakCutiId,
                'JenisCuti'=> $prioritas_cuti__,
                'JenisItemCuti'=> 0,
                'LocationCuti'=> 0,
                'StatusForm'=> 'P',
                'Keperluan'=> $Keperluan,
                'Alamat'=> $Alamat,
                'NoTelpon'=> $NoTelpon,
                'NIKPengganti'=> $NIKPengganti,
                'TglMasuk'=> $this->Kehadiran_Model->date_to_sql($TglMasuk),
                'active_id'=> 1,
                'ApvLevel' => 1,
                'NIK1'=>$NIK1,
                'NIK2'=>$NIK2,
                'NIK3'=>$NIK3,
                'Apv1'=>'P',
                'Apv2'=>'P',
                'Apv3'=>'P',
                'Pin'=> $this->generate_token(),
                'Pin1'=> $this->generate_token(),
                'CreatedBy'=> $this->cms_user_id(),
                'CreatedTime'=>$todays,                
                'UpdatedTime'=>$todays,
                'version'=>2,
                'companyID'=> $CompanyId,
            );

            
            $this->db->insert($this->table_header, $data_header);
            $detail_primary_key = $this->db->insert_id();

            foreach($update_records as $update_record){

                $HakcutiDetail = 0;
                if ($prioritas_cuti == 0 || $prioritas_cuti == 1){
                    $HakcutiDetail = $this->Kehadiran_Model->allocation_cuti($this->cms_user_id(), 1);
                }

                $data_detail = array();    
                $data_detail['CutiId'] = $detail_primary_key;        
                $data_detail['TglCuti'] = $update_record['date_key'];
                $data_detail['active_id'] = 1;
                $data_detail['HakCutiId'] = $HakcutiDetail;
                $data_detail['AllocationId'] = $update_record['allocation'];

                $this->db->insert($this->table_detail, $data_detail);
            }


            $query1 = $this->db->query("select *,count(a.AllocationId) as Jumlah from ".$this->table_detail." as a where a.AllocationId >0 and a.CutiId=".$detail_primary_key." group by a.AllocationId order by a.AllocationId asc");

            foreach ($query1->result() as $key => $credo) {

                    $query = $this->db->query("select *,(select count(c.DetailCutiId) as total from ".$this->table_header." as b inner join ".$this->table_detail." as c on b.CutiId=c.CutiId 
                                    where b.StatusForm='A' and b.HakCutiId=a.HakId) as total_pakai,
                                    (a.Qty-(select count(c.DetailCutiId) as total from ".$this->table_header." as b inner join ".$this->table_detail." as c on b.CutiId=c.CutiId where b.StatusForm='A' and b.HakCutiId=a.HakId)) as sisa_cuti from 
                                    tbl_hakcuti as a where a.NIK='".$EmployeeID."' and a.StatusHak=1 and  DATE(a.Periode1) <='".$today."' and 
                                    if (a.PeriodeExt IS NOT NULL, DATE(a.PeriodeExt) >='".$today."', DATE(a.Periode2) >='".$today."') 
                                    and
                                    a.JenisHakCuti=".$credo->AllocationId."
                                    group by a.HakId 
                                    having sisa_cuti >0
                                    order by a.JenisHakCuti,a.Periode1 ASC");

                    foreach ($query->result() as $key => $row) {

                        $this->db->limit($credo->Jumlah)->update($this->table_detail, array('HakCutiId'=> $row->HakId), array('CutiId'=> $detail_primary_key,'HakCutiId'=>0, 'AllocationId'=>$credo->AllocationId));

                    }                

            }


            //$comments  = 'Dear '.$this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $NIK1).', Mohon form dibawah ini diproses.';

            //$this->Kehadiran_Mailer_Model->mailer_form_cuti($detail_primary_key, $NIK1, $level_id=1, $workflow_id=1, $status=1, $act='P', $subject='Process', $CompanyId, $comments);
            

            if($this->db->affected_rows() > 0){
                $message   = "Gagal menyimpan data...";
                $error = TRUE;
            }
        }  

            $this->syncronize_onleave_data($detail_primary_key, $EmployeeID);         

            $data = array(                
                "error" => $error,
                "message" => $message
            );
            $this->cms_show_json($data);
        }
    }

    public function is_digits($element) {
        return !preg_match ("/[^0-9]/", $element);
    }

    public function check_double_date(){
        $this->cms_guard_page('kehadiran_form_vacation');

        $tahun = date('Y');

        $EmployeeID = $this->input->post('EmployeeID');

        $data = json_decode($this->input->post('tanggal'), TRUE);
        $value = $this->input->post('value');
        $TglMasuk = $this->input->post('TglMasuk');        

        $sub_total = $this->input->post('sub_total');
        $total     = $this->input->post('total');
        $sepakat_utang = $this->input->post('sepakat_utang');

        $daftar_hari_utang = $this->Kehadiran_Model->daftar_hari_utang_cuti($tahun);

        $orderdate = explode('/', $value);
        $month = $orderdate[1];
        $day   = $orderdate[0];
        $year  = $orderdate[2];

        $sql_date = $year.'-'.$month.'-'.$day;


        $status = FALSE;
        $message = '';
        $hutang  = '';

        if ($EmployeeID == "") {
            $status = TRUE;
            $message = $this->cms_lang("Karyawan harus diisi");
            $hutang = '';
        }
        else if(in_array($value, $data)){
            $status = TRUE;
            $message = 'Tanggal tidak boleh sama';
            $hutang = '';
        }
        else if($sub_total >= $total && $sepakat_utang==0){
            $status = TRUE;
            $message = 'Periode cuti melebihi sisa hak cuti, Untuk mengajukan hutang cuti <br/><a href="javascript:void(0)" onclick="callback_kesepakatan_utang('.$EmployeeID.')" title="Sepakat">Klik Disini</a>.';
            //$message = 'Periode cuti melebihi sisa hak cuti , selanjutnya akan menjadi hutang cuti';
            $hutang = '';
        }
        /*
        elseif($sepakat_utang==1 && !in_array($sql_date, $daftar_hari_utang) && $sub_total >= $total){
            $status = FALSE;
            
            $message = 'Tanggal yang anda pilih salah. Tambahan tanggal Cuti Bersama sesuai yang ditetapkan Pemerintah adalah:';
            $message .= '<ul>';

            foreach ($daftar_hari_utang as $key => $row) {
                $message .= '<li>'.$this->Kehadiran_Model->day_name_id($row).', '.$this->Kehadiran_Model->basic_date_format($row).'</li>';
            }
            $message .= '</ul>';  
            
            $hutang = '';    
        }
        */
        elseif (in_array($TglMasuk, $data) || $value == $TglMasuk) {
            $status = TRUE;
            $message = 'Tanggal kembali bekerja harus diluar tanggal cuti';
            $hutang = '';
        }

        elseif ($value >= $TglMasuk && !empty($TglMasuk)) {
            $status = TRUE;
            $message = 'Tanggal kembali bekerja harus hari setelah cuti';
            $hutang = '';
        }        

        elseif($sepakat_utang==1 && in_array($sql_date, $daftar_hari_utang) && $sub_total >= $total){
            $status = FALSE;
            $message = '';            
            $hutang = 0;    
        }

        elseif($sepakat_utang==1 && in_array($sql_date, $daftar_hari_utang) && $sub_total < $total){
            $status = FALSE;
            $message = '';            
            $hutang = 0;    
        }
        elseif($sepakat_utang==1 && $sub_total >= $total){
            $status = FALSE;
            $message = '';            
            $hutang = 0;    
        }
        

        $output = array(
            "status" => $status,
            "message" => $message,
            "hutang" => $hutang,
                             
        );
        $this->cms_show_json($output);
    }


    public function check_tanggal_masuk(){
        $this->cms_guard_page('kehadiran_form_vacation');

        $EmployeeID = $this->input->post('EmployeeID');

        $this->config->load('grocery_crud');
        //$date_format = $this->config->item('grocery_crud_date_format');
        $date_format = 'uk-date';

        $tahun = date('Y');
        $data = json_decode($this->input->post('tanggal'), TRUE);
        $value = $this->input->post('value'); 
        $valuein = $this->Kehadiran_Model->date_to_sql($value);

        $data_cuti = array();
        foreach($data as $key=>$values){               
                
            $data_cuti[$key] = $this->Kehadiran_Model->date_to_sql($values);
                
        }

        $status = FALSE;
        $message = '';

        if ($EmployeeID == "") {
            $status = TRUE;
            $message = $this->cms_lang("Karyawan harus diisi");            
        }
        else if(in_array($valuein, $data_cuti)){
            $status = TRUE;
            $message = 'Tanggal kembali bekerja harus diluar tanggal cuti';
        }
        else if($this->find_minimal_array($data_cuti) >= $valuein || $this->find_maksimal_array($data_cuti) >= $valuein){            
            $status  = TRUE; 
            $message = 'Tanggal kembali bekerja harus hari setelah cuti';               
        }

        $output = array(
            "status" => $status,
            "message" => $message,                             
        );
        $this->cms_show_json($output);
    }


    public function check_before_submit(){
        $this->cms_guard_page('kehadiran_form_vacation');

        $tahun = date('Y');
        $data = json_decode($this->input->post('detail_cuti'), TRUE);      

        $status = FALSE;
        $message = '';        

        $output = array(
            "status" => $status,
            "message" => $message,                             
        );
        $this->cms_show_json($output);
    }


    public function ajax_after_term_and_condition(){
        $this->cms_guard_page('kehadiran_form_vacation');

        $tahun = date('Y');

        $daftar_hari_utang = $this->Kehadiran_Model->daftar_hari_utang_cuti($tahun);

        $status = FALSE;
        $message = '';

        $message .= '<ul>';
            foreach ($daftar_hari_utang as $key => $row) {
                $message .= '<li>'.$this->Kehadiran_Model->day_name_id($row).', '.$this->Kehadiran_Model->basic_date_format($row).'</li>';
            }
        $message .= '</ul>'; 

        $output = array(
            "status" => $status,
            "message" => $message,
                             
        );
        $this->cms_show_json($output);
    }


    public function find_minimal_array($arr){

        return min($arr);

    }

    public function find_maksimal_array($arr){

        return max($arr);

    }

    public function ajax_form_cuti_detail(){

        $this->cms_guard_page('kehadiran_form_vacation');

        $primary_key = $this->input->post('primary_key');

        $result = $this->Kehadiran_Model->show_detail_cuti($primary_key);

        $output = array(
            "result"=> $result,
            //"Nama" => $this->full_name,
            "Pengganti" => $this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $result->NIKPengganti),
            "JenisCuti" => $this->Kehadiran_Model->get_data_row($table_name='tbl_jeniscuti', $where_column='id', $result_column='JenisCutiName', $result->JenisCuti),
            "TglMasuk" => $this->Kehadiran_Model->basic_date_format($result->TglMasuk),
            "CreatedTime" => $this->Kehadiran_Model->detail_date_format($result->CreatedTime),
            "Detail"=> $this->Kehadiran_Model->show_detail_tanggal_cuti($primary_key),
            "StatusForm"=> $this->Kehadiran_Model->status_form_text($result->StatusForm),
            "Approval1" => $this->Kehadiran_Model->status_approval_caption($primary_key,$level_id=1),
            "Approval2" => $this->Kehadiran_Model->status_approval_caption($primary_key,$level_id=2),
            "Approval3" => $this->Kehadiran_Model->status_approval_caption($primary_key,$level_id=3),
            "status" => '',
            "message" => '',
                             
        );
        $this->cms_show_json($output);
    }


    public function _callback_column_StatusForm($value, $row){ 

        if($value == 'P'){
            return '<span class="label label-default status-default" style="font-size:11px">Process</span>';
        }
        elseif($value == 'A'){
            return '<span class="label label-success" style="font-size:11px">Approved</span>';
        }
        elseif($value == 'X'){
            return '<span class="label label-danger" style="font-size:11px">Voided</span>';
        }
        elseif($value == 'R'){
            return '<span class="label label-warning" style="font-size:11px">Rejected</span>';
        }
        else{
            return 'N/A';
        }      
    }


    public function _callback_column_JenisCuti($value, $row){ 

        if($value == 0){
            return 'Hutang';
        }
        elseif($value == 1){
            return 'Tahunan';
        }
        elseif($value == 2){
            return 'Besar';
        }
        elseif($value == 3){
            return 'Khusus';
        }
        elseif($value == 4){
            return 'Bersama';
        }
        elseif($value == 5){
            return 'Melahirkan Atau Keguguran';
        }
        else{
            return 'N/A';
        }      
    }

    public function _callback_column_companyID($value, $row){ 

        return $this->Kehadiran_Model->get_data_row($table_name='tbl_company', $where_column='iCompanyId', $result_column='cCompanyCode', $value);   

    }


    public function _callback_column_citizen($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('DetailCutiId, CutiId, Keterangan, TglCuti, active_id')
            ->from($this->table_detail)
            ->where('CutiId', $row->CutiId)
            ->get();
        


        if ($row->JenisItemCuti <= 9 && $row->JenisCuti !=5){
            $num_row = $query->num_rows();           
        }
        elseif($row->JenisCuti == 5){
            $num_row = $this->count_days($primary_key=$row->CutiId);
        }
        else{
            $num_row = $this->count_days($primary_key=$row->CutiId);
            
        }

        // show how many records
        if($num_row>1){
            return $num_row .' Hari';
        }else if($num_row>0){
            return $num_row .' Hari';
        }else{
            return 'No Data';
        }
    }


    public function _callback_Void_Settlement($value, $row){

        if(!isset($row->CutiId)) $row->CutiId = -1;

        $query = $this->db->select('StatusForm')
            ->from($this->table_header)
            ->where('CutiId', $row->CutiId)
            ->get();
        $num_row = $query->num_rows();
        $data    = $query->row(0);

        if($num_row > 0){
            if($data->StatusForm == 'P'){
                return '#'.$row->CutiId;
            }
            else{
                return 'javascript:void(0)';
            } 
        }
        else{
                return 'javascript:void(0)';
        }
                    
    }


    public function ajax_save_void_cuti(){

        $this->cms_guard_page('kehadiran_form_vacation');

        $primary_key = trim($this->input->post('primary_key'), "#");
        $Alasan      = $this->input->post('Alasan');

        $this->db->select('StatusForm')
                 ->from($this->table_header)
                 ->where('CutiId', $primary_key);
        $db = $this->db->get();
        $data = $db->row(0);
        $num_row = $db->num_rows();

        $status = TRUE;

        if($data->StatusForm != 'P'){
            $status = FALSE;
        }
        

        if($status){
            $this->db->update($this->table_header, array('StatusForm' => 'X','Alasan'=> $Alasan), array('CutiId'=> $primary_key));
        }


        $output = array(
            "exists" =>'',
            "error" => '',
            "message" => '',
            "status" => $status,
        );

        $this->cms_show_json($output);
    }


    public function ajax_total_sejarah_cuti(){

        $year = date('Y');

        $this->cms_guard_page('kehadiran_form_vacation');

        if ($this->input->is_ajax_request()) {   

            $EmployeeID = $this->input->post('EmployeeID');

            $sisa_cuti_tahunan = $this->Kehadiran_Model->total_sisa_cuti_tahunan($EmployeeID);
            $sisa_cuti_besar   = $this->Kehadiran_Model->total_sisa_cuti_besar($EmployeeID);

            $message   = "";
            $error     = FALSE;
            $status    = TRUE;

            $data = array(  
                "hutang_cuti" => $this->Kehadiran_Model->count_hutang_cuti($EmployeeID, $year), 
                "total_gabungan" => $sisa_cuti_tahunan+$sisa_cuti_besar,
                "total_tahunan" => $sisa_cuti_tahunan,
                "total_besar" => $sisa_cuti_besar,            
                "error" => $error,
                "message" => $message
            );
            $this->cms_show_json($data);
        }
    }

    public function ajax_sejarah_cuti_hutang(){

        $year = date('Y');

        $this->cms_guard_page('kehadiran_form_vacation');

        if ($this->input->is_ajax_request()) { 

            $EmployeeID = $this->input->post('EmployeeID');

            $data = array(                            
                "result" => $this->Kehadiran_Model->sejarah_tanggal_hutang_cuti($EmployeeID, $year),                
            );
            $this->cms_show_json($data);
        }
    }


    public function ajax_select_option_employee(){

        $this->cms_guard_page('kehadiran_form_vacation');

        if ($this->input->is_ajax_request()) {   

            $EmployeeID = $this->input->post('EmployeeID');

            $sisa_cuti_tahunan = $this->Kehadiran_Model->total_sisa_cuti_tahunan($EmployeeID);
            $sisa_cuti_besar   = $this->Kehadiran_Model->total_sisa_cuti_besar($EmployeeID);

            $company = $this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='CompanyId', $EmployeeID);
            $department = $this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='DeptID', $EmployeeID);
            $full_name = $this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $EmployeeID); 


            $message   = "";
            $error     = FALSE;
            $status    = TRUE;

            $data = array(             
                "error" => $error,
                "message" => $message,
                "sisa_cuti_tahunan" => $sisa_cuti_tahunan,
                "sisa_cuti_besar"   => $sisa_cuti_besar,             
                "sisa_cuti_gabungan" => $sisa_cuti_tahunan+$sisa_cuti_besar,
                "atasan_langsung_data_option" => $this->Kehadiran_Model->atasan_langsung_data_option($department),
                "NoTelpon" => $this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Hp', $EmployeeID),
                "Alamat" => $this->Kehadiran_Model->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='AlamatDomisili', $EmployeeID),
                "hrd_data_option" => $this->Kehadiran_Model->hrd_data_option($company, $modules='form_cuti'), 
            );

            $this->cms_show_json($data);
        }
    }


    public function ajax_btn_form_cuti(){

        $this->cms_guard_page('kehadiran_form_vacation');

        if ($this->input->is_ajax_request()) {   

            $status_hidden = $this->input->post('status_hidden');

            if($status_hidden == 1){
                $_SESSION['__main_form_cuti_button_hidden_session'] = 0;
            }
            else{
                $_SESSION['__main_form_cuti_button_hidden_session'] = 1;
            }

            $message   = "";
            $error     = FALSE;
            $status    = TRUE;

            $data = array(             
                "error" => $error,
                "message" => $message,
                "status"=>$_SESSION['__main_form_cuti_button_hidden_session'],
            );
            $this->cms_show_json($data);
        }
    }


    public function syncronize_onleave_data($primary_key, $user_nik){

        $this->db->update($this->table_header, array('StatusForm'=> 'A' ,'ApvLevel'=> 3), array('CutiId'=> $primary_key, 'FormCutiNIK'=> $user_nik));

        $this->db->select('*')
                 ->from($this->table_header)
                 ->where('CutiId', $primary_key)
                 ->where('FormCutiNIK', $user_nik);
        $db   = $this->db->get();
        $data = $db->row(0);

        $query = $this->db->query("select * from ".$this->table_detail." as a where a.CutiId=".$primary_key." and a.HakCutiId !=".$data->HakCutiId." group by a.HakCutiId order by a.AllocationId asc");
                           
        foreach ($query->result() as $row){       
            
            $this->Duplicate_MySQL_Record_Primary($this->table_header, $primary_key_field='CutiId', $primary_key, $row->HakCutiId, $row->AllocationId, $user_nik);    
            
        } 
    }


    public function Duplicate_MySQL_Record_Primary($table, $primary_key_field, $primary_key_val, $hak_cuti_id, $jenis_cuti, $user_nik){
       /* generate the select query */
       $this->db->where($primary_key_field, $primary_key_val);        
       $query = $this->db->get($table);

        foreach ($query->result() as $row){   
            foreach($row as $key=>$val){        
                if($key != $primary_key_field){                    
                    $this->db->set($key, $val);               
                }              
            }
        }
        /* insert the new record into table*/
        $this->db->insert($table);
        $detail_primary_key = $this->db->insert_id();

        $this->db->update($this->table_header,array('HakCutiId'=> $hak_cuti_id, 'JenisCuti'=> $jenis_cuti), array('CutiId'=> $detail_primary_key,'FormCutiNIK'=> $user_nik));
        $this->db->update($this->table_detail,array('CutiId'=> $detail_primary_key), array('CutiId'=> $primary_key_val,'HakCutiId'=> $hak_cuti_id));

        return true;
    }


    public function allowed_company(){

        $query = $this->db->query("
            select 
                * 
            from 
                tbl_apv_hrd as a 
            where 
                a.hrd_modules='form_cuti' and a.hrd_status=1 and a.hrd_nik=4833
            group by 
                a.hrd_nik,a.hrd_company
            order by 
                a.hrd_company asc
        ");

        $data = '';
        foreach ($query->result() as $key => $value) {
            $data .= $value->hrd_company.',';
        }

        return $data;
    }







}