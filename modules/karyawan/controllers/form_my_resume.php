<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class form_my_resume extends CMS_Priv_Strict_Controller {

    protected $URL_MAP = array();

    protected $table_name = '';
    protected $tbl_profile                  = 'tbl_profile';
    protected $tbl_profile_certification    = 'tbl_profile_certification';
    protected $tbl_profile_projecthistory   = 'tbl_profile_projecthistory';
    protected $tbl_profile_technicalskill   = 'tbl_profile_technicalskill';
    protected $tbl_profile_education        = 'tbl_profile_education';
    protected $tbl_profile_workexperience   = 'tbl_profile_workexperience';
    protected $tbl_profile_training         = 'tbl_profile_training';
    protected $tbl_profile_attachment       = 'tbl_profile_attachment';
    protected $tbl_profile_files            = 'tbl_profile_files';
    protected $tbl_profile_member           = 'tbl_profile_member';
    protected $tbl_profile_pergerakan_mutasi= 'tbl_profile_pergerakan_mutasi';
    protected $tbl_hakcuti                  = 'tbl_hakcuti';

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');        
        $this->load->model($this->cms_module_path().'/karyawan_model');
        //$this->load->model($this->cms_module_path().'/mailer_employee_model');       
               
    }

    public function cms_complete_table_name($table_name){
        $this->load->helper($this->cms_module_path().'/function');
        if(function_exists('cms_complete_table_name')){
            return cms_complete_table_name($table_name);
        }else{
            return parent::cms_complete_table_name($table_name);
        }
    }

    private function make_crud(){
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // initialize groceryCRUD
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud = $this->new_crud();
       // $crud->set_theme('flexigrid');
        $session_nik = $this->cms_user_id();
        $_SESSION['NIK'] = $session_nik;        
        $today       = date('Y-m-d H:i:s');

        $hrd_modules = $this->cms_get_config('hrd_profile_modules');

        // this is just for code completion
        if (FALSE) $crud = new Extended_Grocery_CRUD();

        //$config['grocery_crud_file_upload_allow_file_types'] = 'gif|jpeg|jpg|png|tiff';
        //$crud->config->set_item('grocery_crud_file_upload_allow_file_types','gif|jpeg|jpg|png');
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
        $crud->unset_read();
		$crud->unset_texteditor('AlamatDomisili');
        $crud->unset_texteditor('AlamatKTP');
		
        //$crud->unset_add();
        // $crud->unset_edit();
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        $crud->unset_export();

        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_country_model');
        */

        $crud->set_table($this->tbl_profile);


        $crud->set_tabs(array(
                'Education'  => 1,
                'Work Experience' => 1,
                'Training' => 1,
                'Technical Skill' => 1,
                'Certification' => 1,
                'Project History' => 1,
                'Family' => 1,
                'Attachment' => 1,
                'Approval' => 2
        ));

        $crud->edit_fields('education','working','training','skill','certification','project','family','attachment','NIK1','NIK2');

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('no-search-flexigrid');
            $crud->set_relation('CompanyId', $this->cms_complete_table_name('company'), 'cCompanyCode');
            $crud->display_as('NoBPJSKes','Nomor BPJS Kesehatan');
            $crud->display_as('member','Anggota Keluarga');
            // $crud->set_table($this->cms_complete_table_name('profile_temp')); 
            //$crud->unset_edit();
        }else{
            $crud->set_theme('no-flexigrid-resume');
            $crud->set_relation('CompanyId', $this->cms_complete_table_name('company'), 'cCompanyName');
            $crud->display_as('NoBPJSKes','Nomor BPJS Kesehatan (Bagi Yg sudah punya kartu)');
            $crud->display_as('member','Anggota Keluarga (Maksimal 3 Anak & 1 Suami/Istri)');

            $crud->set_primary_key('hrd_nik',$this->cms_complete_table_name('apv_hrd'));
            $crud->set_relation('NIK2', $this->cms_complete_table_name('apv_hrd'), '{hrd_name} [{hrd_email}]',array('hrd_status' =>1,'hrd_company' => $my_profile['company'], 'hrd_modules' => $hrd_modules));
            
            //$crud->set_table($this->cms_complete_table_name('profile_temp'));

        }

        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $crud->callback_field('education',array($this, '_callback_field_education'));
        

       


        

        $this->crud = $crud;
        return $crud;
    }


    public function _example_output($output = null){        

        $data = array(
            'session_nik' => $this->cms_user_id(),
            'table_name' => $this->table_name,
            'total_resume'=> $this->count_resume_data(1),
        );

        $output   = array_merge((array)$output, $data);

        $this->view($this->cms_module_path().'/form_my_resume_view', $output,
        $this->cms_complete_navigation_name('form_my_resume'));    
    }


    public function ___index(){
         
        $crud = $this->make_crud();

        $output = $crud->render();
          
        $this->_example_output($output);
    }

    public function edit(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/manage_resume_view', $output,
            $this->cms_complete_navigation_name('form_my_resume'));
    }


    public function index(){

        $primary_key = $this->cms_user_id();

        $profile        = $this->karyawan_model->employee_profile($primary_key);
        $education      = $this->karyawan_model->education_profile($primary_key);
        $project        = $this->karyawan_model->project_profile($primary_key);
        $working        = $this->karyawan_model->working_profile($primary_key);
        $skill          = $this->karyawan_model->skill_profile($primary_key);
        $training       = $this->karyawan_model->training_profile($primary_key);
        $certification  = $this->karyawan_model->certification_profile($primary_key);
        

        $output = array(
            'profile' => $profile,
            'education' => $education,
            'working' => $working,
            'project' => $project,
            'skill' => $skill,
            'training' => $training,
            'certification' => $certification,
            'primary_key' => $primary_key,
        );

        $this->view($this->cms_module_path().'/resume_orbit_view', $output,
            $this->cms_complete_navigation_name('form_my_resume'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('profile'),array('NIK'=>$id));
                    $this->_after_delete($id);
                }
            }
        }
    }

    public function _before_insert($post_array){
        $post_array = $this->_before_insert_or_update($post_array);
        // HINT : Put your code here
        return $post_array;
    }

    public function _after_insert($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here
        return $success;
    }

    public function _before_update_process($post_array, $primary_key){

    }

    public function _after_update_process($post_array, $primary_key){


    }


    public function _before_update($post_array, $primary_key){

        
    }

    public function _after_update($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);
        
        return $success;
        //return true;
    }

    public function _before_delete($primary_key){

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


    // returned on insert and edit
    public function _callback_field_education($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');        

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from($this->tbl_profile_education)
            ->where('EduNIK', $primary_key)
            ->get();
        $result = $query->result_array();

        // get options
        $options = array();
        $options['EduCity'] = array();
        $query = $this->db->select('*')
           ->from('tbl_city')
           ->get();
        foreach($query->result() as $row){
            $options['EduCity'][] = array('value' => $row->City, 'caption' => $row->City);
        }

        $options['EduLevelId'] = array();
        $query = $this->db->select('*')
           ->from('tbl_edulevel')
           ->get();
        foreach($query->result() as $row){
            $options['EduLevelId'][] = array('value' => $row->EducationLevelName, 'caption' => $row->EducationLevelName);
        }
        
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $module_path,
        );
        return $this->load->view($this->cms_module_path().'/field_resume_education_view',$data, TRUE);
    }




















    public function ajax_get_list($id){

        $table_name = $this->set_resume_table($id);

        $this->table_name = $table_name;

        $this->load->model('resume_model');

        $row_model = 'get_datatables_'.$id;

        $data = array(
            'session_nik' => $this->cms_user_id(),
            'result' => $this->resume_model->$row_model($this->cms_user_id(), $table_name),
            'file_path' => site_url('modules/karyawan/assets/uploads/'),
            'state' => 'list',

        );

        echo $this->load->view($this->cms_module_path().'/resume#'.$id.'_view', $data ,TRUE);
    }


    public function ajax_add_resume(){

        $table_id = $this->uri->segment(4);

        $table_name = $this->set_resume_table($table_id);

        $this->table_name = $table_name;

        $this->load->model('resume_model');

        $row_model = 'get_datatables_'.$table_id;

        $data = array(
            'session_nik' => $this->cms_user_id(),
            'file_path' => site_url('modules/karyawan/assets/uploads/'),
            'state' => 'add',

        );

        echo $this->load->view($this->cms_module_path().'/resume#'.$table_id.'_view', $data ,TRUE);
    }

    public function ajax_edit_resume(){

        $primary_key = $this->uri->segment(4);
        $table_id    = $this->uri->segment(5);

        $table_name = $this->set_resume_table($table_id);

        $this->table_name = $table_name;

        $this->load->model('resume_model');

        $row_model = 'get_edit_resume_'.$table_id;

        $data = array(
            'session_nik' => $this->cms_user_id(),
            'file_path' => site_url('modules/karyawan/assets/uploads/'),
            'state' => 'edit',
            'result' => $this->resume_model->$row_model($primary_key),
            'tanggal' => $this->js_date_to_php($this->resume_model->$row_model($primary_key)->ProjectDate),

        );

        echo $this->load->view($this->cms_module_path().'/resume#'.$table_id.'_view', $data ,TRUE);
    }

    
    public function resume_delete($primary_key, $table_name){

        $this->load->model('resume_model');

        //$this->resume_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function set_resume_table($id){

        if ($id==1){
            return 'tbl_profile';
        }
        else if($id==2){
            return 'tbl_profile_workexperience';
        }
        else if($id==3){
            return 'tbl_profile_education';
        }
        else if($id==4){
            return 'tbl_profile_training';
        }
        else if($id==5){
            return 'tbl_profile_technicalskill';
        }
        else if($id==6){
            return 'tbl_profile_certification';
        }
        else if($id==7){
            return 'tbl_profile_projecthistory_testing';
        }
        else{
            return '-';
        }
    }

    public function count_resume_data($table_id){

        $table_name = $this->set_resume_table($table_id);

        $this->load->model('resume_model');

        $data = $this->resume_model->count_all($this->cms_user_id(), $table_name);

        return $data;
    }

    public function insert_resume($table_id){
        /*
        $this->load->model('development_model');

        $this->_validate($this->input->post('KPIID'),$this->input->post('ItemID'), $activity_id=NULL);

        $pieces = explode('/', $this->input->post('DD'));
        $DD = $pieces[2].'-'.$pieces[1].'-'.$pieces[0];

        $EveryMonth_post = $this->input->post('EveryMonth');
        */       

        $data = array(
                'ProjectNIK' => $this->cms_user_id(),
                'ProjectDate' => date('Y-m-d'),
                'ProjectInstitution' => $this->input->post('ProjectInstitution'),
                'ProjectYear' => $this->input->post('ProjectYear'),
                'ProjectLength' => $this->input->post('ProjectLength'),
                'ProjectName' => $this->input->post('ProjectName'),
                'ProjectTechnicalSpec' => $this->input->post('ProjectTechnicalSpec'),
                'ProjectPosition' => $this->input->post('ProjectPosition'),
            );

        $this->db->insert('tbl_profile_projecthistory_testing', $data);

        echo json_encode(array("status" => TRUE));
    }

    public function update_resume($table_id){

        $primary_key = $this->input->post('ProjectId');       

        $data = array(
                'ProjectNIK' => $this->cms_user_id(),
                'ProjectDate' => $this->js_date_to_sql($this->input->post('ProjectDate')),
                'ProjectInstitution' => $this->input->post('ProjectInstitution'),
                'ProjectYear' => $this->input->post('ProjectYear'),
                'ProjectLength' => $this->input->post('ProjectLength'),
                'ProjectName' => $this->input->post('ProjectName'),
                'ProjectTechnicalSpec' => $this->input->post('ProjectTechnicalSpec'),
                'ProjectPosition' => $this->input->post('ProjectPosition'),
            );

        $this->db->update('tbl_profile_projecthistory_testing', $data, array('ProjectId' => $primary_key));

        echo json_encode(array("status" => TRUE));
    }

    public function js_date_to_php($php_date){

        $DATE_FORMAT = split ('-', $php_date);

        $date = $DATE_FORMAT[2];
        $month = $DATE_FORMAT[1];
        $year = $DATE_FORMAT[0];

        return $date.'/'.$month.'/'.$year;    
    }

    public function js_date_to_sql($php_date){

        $DATE_FORMAT = split ('/', $php_date);

        $date = $DATE_FORMAT[0];
        $month = $DATE_FORMAT[1];
        $year = $DATE_FORMAT[2];

        return $year.'-'.$month.'-'.$date;    
    }

    


}