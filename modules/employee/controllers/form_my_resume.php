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
        $this->load->model($this->cms_module_path().'/mailer_karyawan_model');   
              
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
        $crud->unset_read();
        $crud->unset_add();
        // $crud->unset_edit();
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        $crud->unset_export();

        $crud->set_language($this->cms_language());
        $crud->set_theme('no-flexigrid-form-resume');

        // table name
        $crud->set_table($this->tbl_profile);
        $crud->where('NIK', $this->cms_user_id()); 
        $crud->set_primary_key('NIK');
        $crud->set_subject('Resume');      
        $crud->columns('NIK','Nama');       
        $crud->edit_fields('NIK','education','working','training','skill','project','certification','TermsAndConditions');
        $crud->unset_edit_fields('NIK');
        $crud->field_type('NIK', 'hidden', $this->cms_user_id());    

        $crud->set_tabs(
            array(
                'Education' => 1,
                'Working Experience' => 1,
                'Training' => 1,
                'Technical Skills' => 1,
                'Project' => 1,
                'Certification' => 1,
                'Terms and Conditions' => 1,
            )
        );

        $crud->required_fields('TermsAndConditions');


        // caption of each columns
        $crud->display_as('TermsAndConditions','Terms & Conditions');
        $crud->display_as('name','Name');
        $crud->display_as('tourism','Tourism');
        $crud->display_as('commodity','Commodity');
        $crud->display_as('citizen','Citizen');


        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $crud->callback_field('education',array($this, '_callback_field_education'));
        $crud->callback_field('working',array($this, '_callback_field_working'));
        $crud->callback_field('training',array($this, '_callback_field_training'));
        $crud->callback_field('skill',array($this, '_callback_field_skill'));
        $crud->callback_field('project',array($this, '_callback_field_project'));
        $crud->callback_field('certification',array($this, '_callback_field_certification'));
        $crud->callback_field('TermsAndConditions',array($this, '_callback_field_TermsAndConditions'));
       
        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        

        $crud = $this->make_crud();
        $state = $crud->getState();
         
        if ($state == 'list' || $state == 'success'){

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

            $this->view($this->cms_module_path().'/resume_orbit_view', $output,$this->cms_complete_navigation_name('form_my_resume'));                        
        }
        else{
            if($this->uri->segment('5') != $this->cms_user_id()){
                redirect('employee/form_my_resume','refresh');
            }
            
            $output = $crud->render();
            $output->state = $state;
            $this->view($this->cms_module_path().'/manage_resume_view', $output,$this->cms_complete_navigation_name('form_my_resume'));
        }
        
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
        // HINT : Put your code here

        $company_id = $this->cms_table_data_hris($this->tbl_profile, $where_column='NIK', $result_column='CompanyId', $this->cms_user_id());
        $email      = $this->cms_table_data_hris($this->tbl_profile, $where_column='NIK', $result_column='Email', $this->cms_user_id());
        $full_name  = $this->cms_table_data_hris($this->tbl_profile, $where_column='NIK', $result_column='Nama', $this->cms_user_id()); 

        $HRD    = "SELECT a.hrd_nik AS NIK,b.Nama AS Nama,b.Email AS Email FROM tbl_apv_hrd AS a 
                   INNER JOIN ".$this->tbl_profile." AS b ON a.hrd_nik=b.NIK 
                   WHERE a.hrd_modules='my_profile' AND a.hrd_company=".$company_id." 
                   and b.bStatus=1 GROUP BY a.hrd_nik";

        $query  = $this->db->query($HRD);

        foreach ($query->result() as $data){

            $this->mailer_karyawan_model->kirim_email_update_resume($primary_key, $data->Nama, $data->Email);
            
        }

        $this->mailer_karyawan_model->kirim_email_update_resume($primary_key, $full_name, $email);        

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
        //  INSERT DELETE TO OLD DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        //Work Exp
        $query = $this->db->query("DELETE FROM tbl_profile_workexperience_data_old WHERE WorkExpNik = ".$primary_key);
        $query = $this->db->query("INSERT INTO tbl_profile_workexperience_data_old
                                   SELECT * FROM tbl_profile_workexperience WHERE WorkExpNik = ".$primary_key);


        //Training
        $query = $this->db->query("DELETE FROM tbl_profile_training_data_old WHERE TrainingNik = ".$primary_key);
        $query = $this->db->query("INSERT INTO tbl_profile_training_data_old
                                   SELECT * FROM tbl_profile_training WHERE TrainingNik = ".$primary_key);

        //Project
        $query = $this->db->query("DELETE FROM tbl_profile_projecthistory_data_old WHERE ProjectNik = ".$primary_key);
        $query = $this->db->query("INSERT INTO tbl_profile_projecthistory_data_old
                                   SELECT * FROM tbl_profile_projecthistory WHERE ProjectNik = ".$primary_key);

        //Certification
        $query = $this->db->query("DELETE FROM tbl_profile_certification_data_old WHERE CertNik = ".$primary_key);
        $query = $this->db->query("INSERT INTO tbl_profile_certification_data_old
                                   SELECT * FROM tbl_profile_certification WHERE CertNik = ".$primary_key);

        //Education
        $query = $this->db->query("DELETE FROM tbl_profile_education_data_old WHERE EduNik = ".$primary_key);
        $query = $this->db->query("INSERT INTO tbl_profile_education_data_old
                                   SELECT * FROM tbl_profile_education WHERE EduNik = ".$primary_key);

        //Skills
        $query = $this->db->query("DELETE FROM tbl_profile_technicalskill_data_old WHERE TechnicalSkillNik = ".$primary_key);
        $query = $this->db->query("INSERT INTO tbl_profile_technicalskill_data_old
                                   SELECT * FROM tbl_profile_technicalskill WHERE TechnicalSkillNik = ".$primary_key);


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  EDUCATION
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data = json_decode($this->input->post('md_real_field_education_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
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
            $upload_path            = FCPATH.'modules/karyawan/assets/uploads/';
            $record_index           = $update_record['record_index'];
            $tmp_name               = $_FILES['md_field_education_col_EduFileUrl_'.$record_index]['tmp_name'];
            $file_name              = $_FILES['md_field_education_col_EduFileUrl_'.$record_index]['name'];
            $file_name              = $this->randomize_string($file_name).$file_name;          
            if(!empty($tmp_name) && !is_null($tmp_name)){
                $data['EduFileUrl']     = $file_name;
            }
            move_uploaded_file($tmp_name, $upload_path.$file_name);

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
            if(!empty($tmp_name) && !is_null($tmp_name)){
                $data['EduFileUrl']     = $file_name;
            }
            else{
                $data['EduFileUrl']     = '';
            }

            $data['EduNIK']         = $primary_key;            
            $data['EduCreatedBy']   = $this->cms_user_id();
            $data['EduUpdatedBy']   = $this->cms_user_id();
            $data['EduCreatedTime'] = date('Y-m-d H:i:s');
            $data['EduApv']         = 'A';
            $data['EduStatus']      = 1;
            move_uploaded_file($tmp_name, $upload_path.$file_name);
            $this->db->insert($this->tbl_profile_education, $data);
            $detail_primary_key     = $this->db->insert_id();
        }



        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  WORKING EXPERIENCE
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data = json_decode($this->input->post('md_real_field_working_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('WorkExpId','WorkExpNIK','WorkExpStart','WorkExpFinish','WorkExpCompany','WorkExpPosition','WorkExpDesc','EduFaculty','WorkExpFileUrl');
        $set_column_names = array();

        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            $this->db->delete($this->tbl_profile_workexperience, array('WorkExpId' => $detail_primary_key));
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
            $upload_path            = FCPATH.'modules/karyawan/assets/uploads/';
            $record_index           = $update_record['record_index'];
            $tmp_name               = $_FILES['md_field_working_col_WorkExpFileUrl_'.$record_index]['tmp_name'];
            $file_name              = $_FILES['md_field_working_col_WorkExpFileUrl_'.$record_index]['name'];
            $file_name              = $this->randomize_string($file_name).$file_name;
            if(!empty($tmp_name) && !is_null($tmp_name)){
                $data['WorkExpFileUrl']     = $file_name;
            }            
            move_uploaded_file($tmp_name, $upload_path.$file_name);

            $data['WorkExpNIK']         = $primary_key;
            $data['WorkExpUpdatedBy']   = $this->cms_user_id();

            if(is_null($data['WorkExpFinish']) || empty($data['WorkExpFinish']) || $data['WorkExpFinish'] == '0000-00-00'){
                $data['WorkExpUntilNow']         = 1;
            }
            else{
                $data['WorkExpUntilNow']         = 0;
            }
            $this->db->update($this->tbl_profile_workexperience, $data, array('WorkExpId' => $detail_primary_key));
            
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
            $tmp_name               = $_FILES['md_field_working_col_WorkExpFileUrl_'.$record_index]['tmp_name'];
            $file_name              = $_FILES['md_field_working_col_WorkExpFileUrl_'.$record_index]['name'];
            $file_name              = $this->randomize_string($file_name).$file_name;
            if(!empty($tmp_name) && !is_null($tmp_name)){
                $data['WorkExpFileUrl']     = $file_name;
            }
            else{
                $data['WorkExpFileUrl']     = '';
            }
            $data['WorkExpNIK']         = $primary_key;
            $data['WorkExpCreatedBy']   = $this->cms_user_id();
            $data['WorkExpUpdatedBy']   = $this->cms_user_id();
            $data['WorkExpCreatedTime'] = date('Y-m-d H:i:s');
            $data['WorkExpApv']         = 'A';
            $data['WorkExpStatus']      = 1;

            if(is_null($data['WorkExpFinish']) || empty($data['WorkExpFinish']) || $data['WorkExpFinish'] == '0000-00-00'){
                $data['WorkExpUntilNow']         = 1;
            }
            else{
                $data['WorkExpUntilNow']         = 0;
            }

            move_uploaded_file($tmp_name, $upload_path.$file_name);
            $this->db->insert($this->tbl_profile_workexperience, $data);
            $detail_primary_key     = $this->db->insert_id();
        }



        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  TRAINING
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data = json_decode($this->input->post('md_real_field_training_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('TrainingId','TrainingNIK','TrainingYear','TrainingInstitution','TrainingCity','TrainingModul','TrainingType','TrainingFileUrl');
        $set_column_names = array();

        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            $this->db->delete($this->tbl_profile_training, array('TrainingId' => $detail_primary_key));
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

            $upload_path            = FCPATH.'modules/karyawan/assets/uploads/';
            $record_index           = $update_record['record_index'];
            $tmp_name               = $_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['tmp_name'];
            $file_name              = $_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['name'];
            $file_name              = $this->randomize_string($file_name).$file_name;
            if(!empty($tmp_name) && !is_null($tmp_name)){
                $data['TrainingFileUrl']     = $file_name;
            }
            move_uploaded_file($tmp_name, $upload_path.$file_name);

            $data['TrainingNIK']         = $primary_key;
            $data['TrainingUpdatedBy']   = $this->cms_user_id();
            $this->db->update($this->tbl_profile_training, $data, array('TrainingId' => $detail_primary_key));
            
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
            $tmp_name               = $_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['tmp_name'];
            $file_name              = $_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['name'];
            $file_name              = $this->randomize_string($file_name).$file_name;
            if(!empty($tmp_name) && !is_null($tmp_name)){
                $data['TrainingFileUrl']     = $file_name;
            }
            else{
                $data['TrainingFileUrl']     = '';
            }

            $data['TrainingNIK']         = $primary_key;
            $data['TrainingUpdatedBy']   = $this->cms_user_id();
            $data['TrainingCreatedBy']   = $this->cms_user_id();
            $data['TrainingCreatedTime'] = date('Y-m-d H:i:s');
            $data['TrainingApv']         = 'A';
            $data['TrainingStatus']      = 1;
            move_uploaded_file($tmp_name, $upload_path.$file_name);
            $this->db->insert($this->tbl_profile_training, $data);
            $detail_primary_key     = $this->db->insert_id();
        }


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  Technical Skill
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data = json_decode($this->input->post('md_real_field_skill_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('TechnicalSkillId','TechnicalSkillNIK','TechnicalSkillName','TechnicalSkillExp','TechnicalSkillDesc','TechnicalSkillFileUrl');
        $set_column_names = array();

        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            $this->db->delete($this->tbl_profile_technicalskill, array('TechnicalSkillId' => $detail_primary_key));
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

            $upload_path            = FCPATH.'modules/karyawan/assets/uploads/';
            $record_index           = $update_record['record_index'];
            $tmp_name               = $_FILES['md_field_skill_col_TechnicalSkillFileUrl_'.$record_index]['tmp_name'];
            $file_name              = $_FILES['md_field_skill_col_TechnicalSkillFileUrl_'.$record_index]['name'];
            $file_name              = $this->randomize_string($file_name).$file_name;
            if(!empty($tmp_name) && !is_null($tmp_name)){
                $data['TechnicalSkillFileUrl']     = $file_name;
            }
            move_uploaded_file($tmp_name, $upload_path.$file_name);            

            $data['TechnicalSkillNIK']         = $primary_key;
            $data['TechnicalSkillUpdatedBy']   = $this->cms_user_id();
            $this->db->update($this->tbl_profile_technicalskill, $data, array('TechnicalSkillId' => $detail_primary_key));
            
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
            $tmp_name               = $_FILES['md_field_skill_col_TechnicalSkillFileUrl_'.$record_index]['tmp_name'];
            $file_name              = $_FILES['md_field_skill_col_TechnicalSkillFileUrl_'.$record_index]['name'];
            $file_name              = $this->randomize_string($file_name).$file_name;
            if(!empty($tmp_name) && !is_null($tmp_name)){
                $data['TechnicalSkillFileUrl']     = $file_name;
            }
            else{
                $data['TechnicalSkillFileUrl']     = '';
            }

            $data['TechnicalSkillNIK']         = $primary_key;
            $data['TechnicalSkillUpdatedBy']   = $this->cms_user_id();
            $data['TechnicalSkillCreatedBy']   = $this->cms_user_id();
            $data['TechnicalSkillCreatedTime'] = date('Y-m-d H:i:s');
            $data['TechnicalSkillApv']         = 'A';
            $data['TechnicalSkillStatus']      = 1;
            move_uploaded_file($tmp_name, $upload_path.$file_name);
            $this->db->insert($this->tbl_profile_technicalskill, $data);
            $detail_primary_key     = $this->db->insert_id();
        }


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  PROJECT
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data = json_decode($this->input->post('md_real_field_project_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('ProjectId','ProjectNIK','ProjectDate','ProjectName','ProjectInstitution','ProjectYear','ProjectLength','ProjectTechnicalSpec','ProjectPosition','ProjectFileUrl');
        $set_column_names = array();

        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            $this->db->delete($this->tbl_profile_projecthistory, array('ProjectId' => $detail_primary_key));
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

            $upload_path            = FCPATH.'modules/karyawan/assets/uploads/';
            $record_index           = $update_record['record_index'];
            $tmp_name               = $_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['tmp_name'];
            $file_name              = $_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['name'];
            $file_name              = $this->randomize_string($file_name).$file_name;
            if(!empty($tmp_name) && !is_null($tmp_name)){
                $data['ProjectFileUrl']     = $file_name;
            }            
            move_uploaded_file($tmp_name, $upload_path.$file_name);

            $data['ProjectNIK']         = $primary_key;
            $data['ProjectUpdatedBy']   = $this->cms_user_id();
            $this->db->update($this->tbl_profile_projecthistory, $data, array('ProjectId' => $detail_primary_key));
            
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
            $tmp_name               = $_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['tmp_name'];
            $file_name              = $_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['name'];
            $file_name              = $this->randomize_string($file_name).$file_name;
            if(!empty($tmp_name) && !is_null($tmp_name)){
                $data['ProjectFileUrl']     = $file_name;
            }
            else{
                $data['ProjectFileUrl']     = '';
            }

            $data['ProjectNIK']         = $primary_key;            
            $data['ProjectUpdatedBy']   = $this->cms_user_id();
            $data['ProjectCreatedBy']   = $this->cms_user_id();
            $data['ProjectCreatedTime'] = date('Y-m-d H:i:s');
            $data['ProjectApv']         = 'A';
            $data['ProjectStatus']      = 1;
            move_uploaded_file($tmp_name, $upload_path.$file_name);
            $this->db->insert($this->tbl_profile_projecthistory, $data);
            $detail_primary_key     = $this->db->insert_id();
        }


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  CERTIFICATION
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data = json_decode($this->input->post('md_real_field_certification_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('CertId','CertNIK','CertDate','CertItem','CertProduct','CertName','CertPartnerName','CertValidStart','CertValidFinish','CertFileUrl');
        $set_column_names = array();

        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            $this->db->delete($this->tbl_profile_certification, array('CertId' => $detail_primary_key));
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

            $upload_path            = FCPATH.'modules/karyawan/assets/uploads/';
            $record_index           = $update_record['record_index'];
            $tmp_name               = $_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['tmp_name'];
            $file_name              = $_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['name'];
            $file_name              = $this->randomize_string($file_name).$file_name;

            if(!empty($tmp_name) && !is_null($tmp_name)){
                $data['CertFileUrl']     = $file_name;
            }

            //masi cari disni move_uploaded_file($tmp_name, $upload_path.$file_name);            

            $data['CertNIK']         = $primary_key;
            $data['CertUpdatedBy']   = $this->cms_user_id();
            $this->db->update($this->tbl_profile_certification, $data, array('CertId' => $detail_primary_key));
            
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
            $tmp_name               = $_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['tmp_name'];
            $file_name              = $_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['name'];
            $file_name              = $this->randomize_string($file_name).$file_name;

            if(!empty($tmp_name) && !is_null($tmp_name)){
                $data['CertFileUrl']     = $file_name;
            }
            else{
                $data['CertFileUrl']     = '';
            }

            $data['CertNIK']         = $primary_key;            
            $data['CertUpdatedBy']   = $this->cms_user_id();
            $data['CertCreatedBy']   = $this->cms_user_id();
            $data['CertCreatedTime'] = date('Y-m-d H:i:s');
            $data['CertApv']         = 'A';
            $data['CertStatus']      = 1;
            move_uploaded_file($tmp_name, $upload_path.$file_name);
            
            //$byksertifikat = cek_certificate_aktif($primary_key,);


            $this->db->insert($this->tbl_profile_certification, $data);
            $detail_primary_key     = $this->db->insert_id();
        }
        
        return TRUE;
    }

    public function cek_certificate_aktif($certnik,$certitem,$certproduct){

    }

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }

    public function _callback_field_education($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');        

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from($this->tbl_profile_education)
            ->where('EduNIK', $primary_key)
            ->order_by('EduStart','ASC')
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


    public function _callback_field_working($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');        

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from($this->tbl_profile_workexperience)
            ->where('WorkExpNIK', $primary_key)
            ->order_by('WorkExpStart','ASC')
            ->get();
        $result = $query->result_array();
        // get options
        $options = array();
    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $module_path,
        );
        return $this->load->view($this->cms_module_path().'/field_detail_working',$data, TRUE);
    }


    public function _callback_field_training($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');        

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from($this->tbl_profile_training)
            ->where('TrainingNIK', $primary_key)
            ->order_by('TrainingYear','ASC')
            ->get();
        $result = $query->result_array();
        // get options
        $options = array();
        /*
        $options['TrainingCity'] = array();
        $query = $this->db->select('*')
           ->from('tbl_city')
           ->get();
        foreach($query->result() as $row){
            $options['TrainingCity'][] = array('value' => $row->City, 'caption' => $row->City);
        }
        */
    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $module_path,
        );
        return $this->load->view($this->cms_module_path().'/field_detail_training',$data, TRUE);
    }


    public function _callback_field_skill($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');        

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from($this->tbl_profile_technicalskill)
            ->where('TechnicalSkillNIK', $primary_key)
            ->order_by('TechnicalSkillId','ASC')
            ->get();
        $result = $query->result_array();
        // get options
        $options = array();
    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $module_path,
        );
        return $this->load->view($this->cms_module_path().'/field_detail_skill',$data, TRUE);
    }


    public function _callback_field_project($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');        

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from($this->tbl_profile_projecthistory)
            ->where('ProjectNIK', $primary_key)
            ->order_by('ProjectYear,ProjectDate','ASC')
            ->get();
        $result = $query->result_array();
        // get options
        $options = array();
    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $module_path,
        );
        return $this->load->view($this->cms_module_path().'/field_detail_project',$data, TRUE);
    }


    public function _callback_field_certification($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');        

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from($this->tbl_profile_certification)
            ->where('CertNIK', $primary_key)
            ->order_by('CertDate,CertItem,CertStatus','ASC')
            ->get();
        $result = $query->result_array();
        // get options
        $options = array();

        $options['CertItem'] = array();
        $query = $this->db->select('CertItemId,CertItemName')
           ->from($this->cms_complete_table_name('certification_item'))
           ->where('CertItemStatus',1)
           ->order_by('CertItemName','ASC')
           ->get();
        foreach($query->result() as $row){
            $options['CertItem'][] = array('value' => $row->CertItemId, 'caption' => $row->CertItemName);
        }
    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $module_path,
        );
        return $this->load->view($this->cms_module_path().'/field_detail_certification',$data, TRUE);
    }


    public function _callback_field_TermsAndConditions($value, $row){

        $html = '<div><label><input type="checkbox" id="checkbox1" name="TermsAndConditions" value="1" onclick="CheckProjectMandatory()" value="Harap Periksa Kembali Inputan Anda" />I accept the terms and conditions </label></div>';
        $html .= '<div id="autoUpdate" class="alert alert-info autoUpdate">';
        $html .= '<ol>';
        $html .= '<li>Saya bertanggung jawab atas kebenaran data-data yang saya berikan</li>';
        $html .= '<li>Setelah saya selesai mengupdate data, akan diinformasikan kembali via email ke saya dan PIC di HRD</li>';
        $html .= '<li>Jika Anda tidak melakukan perubahan Resume, silahkan klik Cancel untuk kembali</li>';
        $html .= '</ol>';
        $html .= '</div>';
        $html .= '<div id="warningmessage" class="alert alert-danger" style="display:none">';
        $html .= 'Terdapat Data <u>Kolom Project</u> Yang Belum Lengkap, Harap Lengkapi Data Anda Terlebih Dahulu ';
        $html .= '</div>';

        return $html;
    }

    public function cms_table_data_hris($table_name, $where_column, $result_column, $value){

        $this->db->select($result_column)->from($table_name)->where($where_column, $value);
        $db      = $this->db->get();
        $data    = $db->row(0);
        $num_row = $db->num_rows();

        if ($num_row > 0){
            return $data->$result_column;
        }
        else{
            return '';
        }
    }

}