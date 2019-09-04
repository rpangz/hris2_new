<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class form_my_resume extends CMS_Priv_Strict_Controller {

    protected $URL_MAP = array();

    protected $table_name = '';
    protected $tbl_profile                  = 'test_profile';
    protected $tbl_profile_certification    = 'test_profile_certification';
    protected $tbl_profile_projecthistory   = 'test_profile_projecthistory';
    protected $tbl_profile_technicalskill   = 'test_profile_technicalskill';
    protected $tbl_profile_education        = 'test_profile_education';
    protected $tbl_profile_workexperience   = 'test_profile_workexperience';
    protected $tbl_profile_training         = 'test_profile_training';
    protected $tbl_profile_attachment       = 'test_profile_attachment';
    protected $tbl_profile_files            = 'test_profile_files';
    protected $tbl_profile_member           = 'test_profile_member';
    protected $tbl_profile_pergerakan_mutasi= 'test_profile_pergerakan_mutasi';
    protected $tbl_hakcuti                  = 'test_hakcuti';

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

    private function randomize_string($value){
        $time = date('Y:m:d H:i:s');
        return substr(md5($value.$time),0,6);
    }

    private function make_crud(){
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // initialize groceryCRUD
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud = $this->new_crud();
        // $crud->set_theme('flexigrid');    
        // this is just for code completion
        if (FALSE) $crud = new Extended_Grocery_CRUD();

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
		//$crud->unset_texteditor('AlamatDomisili');
        //$crud->unset_texteditor('AlamatKTP');
		
        //$crud->unset_add();
        // $crud->unset_edit();
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        $crud->unset_export();

        $crud->set_language($this->cms_language());

        $crud->set_theme('no-flexigrid-resume');
        $crud->where('NIK',$this->cms_user_id());

        $crud->set_table($this->tbl_profile);

        $crud->set_tabs(
            array(
                'Education' => 1,
            )
        );

        $crud->columns('NIK','Nama');

        $crud->edit_fields('NIK','education');
        $crud->unset_edit_fields('NIK');
        $crud->field_type('NIK', 'hidden', $this->cms_user_id());                

        $crud->callback_before_insert(array($this,'before_insert'));
        $crud->callback_before_update(array($this,'before_update'));
        $crud->callback_before_delete(array($this,'before_delete'));
        $crud->callback_after_insert(array($this,'after_insert'));
        $crud->callback_after_update(array($this,'after_update'));
        $crud->callback_after_delete(array($this,'after_delete'));

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
    

    public function index(){

        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/manage_resume_view', $output,
            $this->cms_complete_navigation_name('form_my_resume'));
    }


    public function result(){

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

    public function _before_update($post_array, $primary_key){
        $post_array = $this->_before_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here
        return $post_array;
    }

    public function _after_update($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);
        
        return $success;
    }

    public function _before_delete($primary_key){

        return TRUE;
    }

    public function _after_delete($primary_key){
        return TRUE;
    }

    public function _after_insert_or_update($post_array, $primary_key){

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  EDUCATION
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data = json_decode($this->input->post('md_real_field_education_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        //$real_column_names = array('EduId','EduNIK','EduStart','EduFinish','EduLevelId','EduInstitution','EduCity','EduFaculty','EduMajor','EduGPA','EduFileUrl');
        $real_column_names = array('EduId','EduNIK','EduStart','EduFinish','EduLevelId','EduInstitution','EduCity','EduFaculty','EduMajor','EduGPA','EduFileName','EduFileUrl','EduStatus','EduApv','EduProcessId','EduUpdatedBy');
        $set_column_names = array();

        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            $this->db->delete($this->tbl_profile_education, array('EduId' => $detail_primary_key));
        }
    
        foreach($update_records as $update_record){
            $detail_primary_key = $update_record['primary_key'];
            $data = array();
            foreach($update_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['EduNIK']         = $primary_key;
            $data['EduUpdatedBy']   = $this->cms_user_id();
            $this->db->update($this->tbl_profile_education, $data, array('EduId' => $detail_primary_key));
            
        }
        
        foreach($insert_records as $insert_record){
            $data = array();
            foreach($insert_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }            

            $upload_path            = FCPATH.'modules/karyawan/assets/uploads/';
            $record_index           = $insert_record['record_index'];
            $tmp_name               = $_FILES['md_field_education_col_EduFileUrl_'.$record_index]['tmp_name'];
            $file_name              = $_FILES['md_field_education_col_EduFileUrl_'.$record_index]['name'];
            $file_name              = $this->randomize_string($file_name).$file_name;
            $data['EduNIK']         = $primary_key;
            $data['EduFileUrl']     = $file_name;
            $data['EduCreatedBy']   = $this->cms_user_id();
            $data['EduCreatedTime'] = date('Y-m-d H:i:s');
            $data['EduApv']         = 'A';
            move_uploaded_file($tmp_name, $upload_path.$file_name);
            $this->db->insert($this->tbl_profile_education, $data);
            $detail_primary_key     = $this->db->insert_id();
        }

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
        return $this->load->view($this->cms_module_path().'/field_detail_education',$data, TRUE);
    }


    


}