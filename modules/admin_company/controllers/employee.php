<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class employee extends CMS_Priv_Strict_Controller {

    protected $URL_MAP  = array();
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

    protected $form_company_id = '';   


    public function cms_complete_table_name($table_name){
        $this->load->helper($this->cms_module_path().'/function');
        if(function_exists('cms_complete_table_name')){
            return cms_complete_table_name($table_name);
        }else{
            return parent::cms_complete_table_name($table_name);
        }
    }

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');        
        $this->load->model($this->cms_module_path().'/employee_model');
        $this->load->model($this->cms_module_path().'/mailer_employee_model');       
               
    }


    public function cms_user_form_company_id(){

        $query = $this->db->select('group_company_id, user_id, iCompanyId')
                        ->from('tbl_group_company_user')
                        ->where('user_id', $this->cms_user_id())
                        ->group_by('iCompanyId')                        
                        ->order_by('iCompanyId', 'ASC')           
                        ->get();
        
        $num_row = $query->num_rows();
        $company = '';

        foreach($query->result() as $data){
            $company .= $data->iCompanyId.',';
        }

        if ($num_row > 0){
            return $company;
        }
        else{
            return 0;
        }      
    
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
        // $crud->unset_add();
        // $crud->unset_edit();
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();

        $crud->unset_texteditor('AlamatDomisili','AlamatKTP');

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
        $today = date('Y-m-d H:i:s');
        

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid-profile');
        }
        else{
            $crud->set_theme('no-flexigrid-general');
        }

        // table name
        $crud->set_table($this->tbl_profile);
        $crud->where('FIND_IN_SET ('.$this->tbl_profile.'.CompanyId,"'.$this->cms_user_form_company_id().'")');
        $crud->order_by($this->tbl_profile.'.CompanyId','ASC');

        // primary key
        $crud->set_primary_key('NIK');

        // set subject
        $crud->set_subject('Employee');

        // displayed columns on list
        $crud->columns('Photos','NIK','Nama','NoKK','NoKTP','TglKTP','Sex','Agama','TglLahir','TptLahir','AlamatKTP','AlamatDomisili','Kodepos','Telp','Hp','BloodType','StatusDiri','NamaIbuKandung','NoNPWP','NoKPJ','NoBPJSKes','EmailPribadi','CompanyId','DivisiID','DeptID','UnitID','SeksiID','JabatanID','BandSkrg','Grade','Email','member','bStatus','UpdatedTime');
        // displayed columns on edit operation
        
        //$crud->columns('NIK','Nama','NoKK','NoKTP','TglKTP','Sex','Agama','TglLahir','bStatus');


        $crud->edit_fields('Photos','NIK','NoKK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','Telp','Hp','BloodType','StatusDiri','NamaIbuKandung','NoNPWP','NoKPJ','NoBPJSKes','EmailPribadi','AlamatKTP','CityKTP','KodeposKTP','AlamatDomisili','CityDomisili','Kodepos','CompanyId','DivisiID','DeptID','UnitID','SeksiID','Email','JabatanID','JobId','BandSkrg','Grade','TglMasuk','TglKeluar','Status','bStatus','UpdatedBy','UpdatedTime');        
        // displayed columns on add operation
        $crud->add_fields('Photos','NIK','NoKK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','Telp','Hp','BloodType','StatusDiri','NamaIbuKandung','NoNPWP','NoKPJ','NoBPJSKes','EmailPribadi','AlamatKTP','CityKTP','KodeposKTP','AlamatDomisili','CityDomisili','Kodepos','CompanyId','DivisiID','DeptID','UnitID','SeksiID','Email','JabatanID','JobId','BandSkrg','Grade','TglMasuk','TglKeluar','Status','bStatus','CreatedBy','CreatedTime','UpdatedBy','UpdatedTime');

        if ($state =='add'){
            $crud->unique_fields('NIK');
            $crud->required_fields('NIK','Nama','Sex','Agama','TglLahir','TglMasuk','Email','CompanyId','DivisiID','DeptID','UnitID','Status','bStatus');
        }
        else{
            $crud->field_type('NIK','readonly');
            $crud->required_fields('NIK','Nama','Sex','Agama','TglLahir','TglMasuk','Email','CompanyId','DivisiID','DeptID','UnitID','Status','bStatus');
        }
        
        // HINT: Put custom field type here
        $crud->unset_add_fields('CreatedBy','CreatedTime','UpdatedBy','UpdatedTime');
        $crud->field_type('CreatedBy', 'hidden', $this->cms_user_id());
        $crud->field_type('CreatedTime', 'hidden', $today);        

        $crud->unset_edit_fields('UpdatedBy','UpdatedTime');
        $crud->field_type('UpdatedBy', 'hidden', $this->cms_user_id());
        $crud->field_type('UpdatedTime', 'hidden', $today);

        

        $crud->placeholder('NoKK', 'Nomor KK tidak usah pakai titik');
        $crud->placeholder('NoKTP', 'Nomor KTP tidak usah pakai titik');


        // caption of each columns
        $crud->display_as('NIK','NIK');
        $crud->display_as('Sex','Sex');
        $crud->display_as('NoKK','No Kartu Keluarga');        
        $crud->display_as('BandSkrg','Band');
        $crud->display_as('Grade','Grading');
        $crud->display_as('TglMasuk','Tgl Mulai Bergabung');
        $crud->display_as('Status','Status Karyawan');
        $crud->display_as('StatusDiri','Marital Status');
        $crud->display_as('CompanyId','Company');
        $crud->display_as('DivisiID','Division');
        $crud->display_as('DeptID','Department');
        $crud->display_as('UnitID','Unit');
        $crud->display_as('SeksiID','Section');
        $crud->display_as('JabatanID','Job Title Structural');
        $crud->display_as('JobId','Job Title Fungsional');        
        $crud->display_as('JmlAnak','Jumlah Anak');
        $crud->display_as('TptLahir','Birth Place');
        $crud->display_as('TglLahir','Birth Date');
        $crud->display_as('TglMenikah','Tgl Menikah');
        $crud->display_as('TglKeluar','Tgl Keluar');
        $crud->display_as('AlamatKTP','Address (ID Based)');
        $crud->display_as('CityKTP','City (ID Based)');
        $crud->display_as('KodeposKTP','ZIP (ID Based)');
        $crud->display_as('AlamatDomisili','Address (Current)');
        $crud->display_as('CityDomisili','City (Current)');
        $crud->display_as('Kodepos','ZIP (Current)');
        $crud->display_as('NamaIbuKandung','Nama Ibu Kandung');
        $crud->display_as('NoNPWP','No. NPWP');
        $crud->display_as('NamaIbuKandung','Mother’s Name');
        $crud->display_as('NoKPJ','No. KPJ');
        $crud->display_as('BloodType','Blood Type');
        $crud->display_as('Telp','Telp');
        $crud->display_as('Hp','HP');
        $crud->display_as('EmailPribadi','Email Pribadi');
        $crud->display_as('Email','Email Perusahaan');
        $crud->display_as('TermsAndConditions','Terms & Conditions');
        $crud->display_as('Files','Attachment (My CV)');
        $crud->display_as('attachment','Attachment (My Profile)');
        $crud->display_as('Agama','Relegion');
        $crud->display_as('bStatus','Join Status');
        $crud->display_as('TermsAndConditions','Updated');

        // HINT: Put required field validation codes here     

        // HINT: Put required field validation as unique codes here
        //$crud->unique_fields('NIK');


        // HINT: Put set relation (lookup) codes here
        $crud->set_relation('CompanyId', 'tbl_company', 'cCompanyName');
        $crud->set_relation('DivisiID', 'tbl_div', 'cDivName');
        $crud->set_relation('DeptID', 'tbl_dept', 'cDeptName');
        $crud->set_relation('UnitID', 'tbl_unit', 'NamaUnit');
        $crud->set_relation('SeksiID', 'tbl_section', 'cSectionName');
        $crud->set_relation('Status', $this->cms_complete_table_name('status'), 'StatusName');
        $crud->set_relation('Sex', $this->cms_complete_table_name('sex'), 'SexNameEng');          
        $crud->set_relation('SeksiID', $this->cms_complete_table_name('section'), 'cSectionName');
        $crud->set_relation('JabatanID', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');
        $crud->set_relation('Agama', $this->cms_complete_table_name('Agama'), 'agama_name');
        $crud->set_relation('JobId', $this->cms_complete_table_name('job_fungsional'), 'JobFungsionalName');
        $crud->set_relation('TptLahir', $this->cms_complete_table_name('city'), 'City');
        $crud->set_relation('CityKTP', $this->cms_complete_table_name('city'), 'City');
        $crud->set_relation('CityDomisili', $this->cms_complete_table_name('city'), 'City');
        $crud->set_relation('BloodType', $this->cms_complete_table_name('blood_type'), 'BloodTypeName');
        $crud->set_relation('StatusDiri', $this->cms_complete_table_name('StatusDiri'), 'StatusDiriName');


        // Make foreingn Key
        $crud->set_primary_key('City',$this->cms_complete_table_name('city'));
        $crud->set_primary_key('BloodTypeName',$this->cms_complete_table_name('blood_type'));       
   

        //$crud->set_rules('citizen', 'citizen', 'callback_test_check');

        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $crud->set_field_upload('Photos','assets/uploads/files');

        $crud->add_action('Resume', '', '','resume-icon',array($this,'_callback_employee_resume'));

        //$crud->callback_before_insert(array($this,'encrypt_password_callback'));

        /* callback library */
        $crud->callback_column('Nama',array($this,'_callback_column_Nama'));
        $crud->callback_add_field('DivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_edit_field('DivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_add_field('DeptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_edit_field('DeptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_add_field('UnitID', array($this, 'empty_units_dropdown_select'));
        $crud->callback_edit_field('UnitID', array($this, 'empty_units_dropdown_select'));
        $crud->callback_add_field('SeksiID', array($this, 'empty_seksi_dropdown_select'));
        $crud->callback_edit_field('SeksiID', array($this, 'empty_seksi_dropdown_select'));
        $crud->callback_column('certification',array($this, '_callback_column_certification'));
        $crud->callback_field('certification',array($this, '_callback_field_certification'));


        $crud->callback_column('member',array($this, '_callback_column_member'));
        $crud->callback_field('member',array($this, '_callback_field_member'));

        $this->crud = $crud;
        return $crud;
    }

    public function _example_output($output = null){
        $data = array(
            'state' => '',
        );

        $output   = array_merge((array)$output, $data);

        $this->view($this->cms_module_path().'/employee_view', $output,
        $this->cms_complete_navigation_name('employee'));    
    }

    public function index(){
                  
        $crud = $this->make_crud();

        $dd_data = array(
                'dd_state' =>  $crud->getState(),                
                'dd_dropdowns' => array('CompanyId','DivisiID','DeptID','UnitID','SeksiID'),
                'dd_url' => array('', site_url().'/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/get_states/', site_url().'/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/get_cities/', site_url().'/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/get_units/',site_url().'/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/get_seksi/'),
                'dd_ajax_loader' => base_url().'ajax-loader.gif'
            );       


        $output = $crud->render();
        $output->dropdown_setup = $dd_data;            
        $this->_example_output($output);

    }

    public function ___index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/employee_view', $output,
            $this->cms_complete_navigation_name('employee'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('city'),array('city_id'=>$id));
                    $this->_after_delete($id);
                }
            }
        }
    }   


    public function _before_insert($post_array){
        $post_array = $this->_before_insert_or_update($post_array);        
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
        /*
        $this->db->delete($this->cms_complete_table_name('citizen'),
              array('city_id'=>$primary_key));
        */

        return TRUE;
    }

    public function _after_delete($primary_key){
        return TRUE;
    }

    public function _after_insert_or_update($post_array, $primary_key){

        if ($this->uri->segment(3) == 'index'){
            $this->db->update($this->tbl_hakcuti, array('companyID'=> $post_array['CompanyId']), array('NIK' => $primary_key));
        }

        return TRUE;
    }

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }

    public function _callback_employee_resume($value, $primary_key){
        return false;
        //return '<a href="javascript:void(0)" onclick="callback_resume_form('.$primary_key.')" /><span class="resume-icon"></span></a>'; 
    }

    public function _callback_download_url($value, $primary_key){

        $this->db->select('url')
                 ->from($this->tbl_profile_attachment)
                 ->where('file_id', $value);
        $db = $this->db->get();
        $data = $db->row(0);

        $file_name = $data->url;

        if(empty($file_name) || is_null($file_name)){
            return '';
        }
        else{
            $url = site_url('modules/karyawan/assets/uploads/'.$file_name);
            if (!file_exists(FCPATH.'modules/karyawan/assets/uploads/'.$file_name)) {
                return '';
            }
            else{
                return $url;
            }
        }  
    }


    public function _callback_download_WorkExpFileUrl($value, $primary_key){

        $this->db->select('WorkExpFileUrl')
                 ->from($this->tbl_profile_workexperience)
                 ->where('WorkExpId', $value);
        $db = $this->db->get();
        $data = $db->row(0);

        $file_name = $data->WorkExpFileUrl;    

        if(empty($file_name) || is_null($file_name)){
            return '';
        }
        else{
            $url = site_url('modules/karyawan/assets/uploads/'.$file_name);
            if (!file_exists(FCPATH.'modules/karyawan/assets/uploads/'.$file_name)) {
                return '';
            }
            else{
                return $url;
            }
        }     
    }


    public function _callback_download_EduFileUrl($value, $primary_key){

        $this->db->select('EduFileUrl')
                 ->from($this->tbl_profile_education)
                 ->where('EduId', $value);
        $db = $this->db->get();
        $data = $db->row(0);

        $file_name = $data->EduFileUrl;    

        if(empty($file_name) || is_null($file_name)){
            return '';
        }
        else{
            $url = site_url('modules/karyawan/assets/uploads/'.$file_name);
            if (!file_exists(FCPATH.'modules/karyawan/assets/uploads/'.$file_name)) {
                return '';
            }
            else{
                return $url;
            }
        }  
    }


    public function _callback_download_TrainingFileUrl($value, $primary_key){

        $this->db->select('TrainingFileUrl')
                 ->from($this->tbl_profile_training)
                 ->where('TrainingId', $value);
        $db = $this->db->get();
        $data = $db->row(0);

        $file_name = $data->TrainingFileUrl;

        if(empty($file_name) || is_null($file_name)){
            return '';
        }
        else{
            $url = site_url('modules/karyawan/assets/uploads/'.$file_name);
            if (!file_exists(FCPATH.'modules/karyawan/assets/uploads/'.$file_name)) {
                return '';
            }
            else{
                return $url;
            }
        }  
    }


    public function _callback_download_TechnicalSkillFileUrl($value, $primary_key){

        $this->db->select('TechnicalSkillFileUrl')
                 ->from($this->tbl_profile_technicalskill)
                 ->where('TechnicalSkillId', $value);
        $db = $this->db->get();
        $data = $db->row(0);

        $file_name = $data->TechnicalSkillFileUrl;

        if(empty($file_name) || is_null($file_name)){
            return '';
        }
        else{
            $url = site_url('modules/karyawan/assets/uploads/'.$file_name);
            if (!file_exists(FCPATH.'modules/karyawan/assets/uploads/'.$file_name)) {
                return '';
            }
            else{
                return $url;
            }
        }  
    }


    public function _callback_download_CertFileUrl($value, $primary_key){

        $this->db->select('CertFileUrl')
                 ->from($this->tbl_profile_certification)
                 ->where('CertId', $value);
        $db = $this->db->get();
        $data = $db->row(0);

        $file_name = $data->CertFileUrl;

        if(empty($file_name) || is_null($file_name)){
            return '';
        }
        else{
            $url = site_url('modules/karyawan/assets/uploads/'.$file_name);
            if (!file_exists(FCPATH.'modules/karyawan/assets/uploads/'.$file_name)) {
                return '';
            }
            else{
                return $url;
            }
        }  
    }

    public function _callback_download_ProjectFileUrl($value, $primary_key){

        $this->db->select('ProjectFileUrl')
                 ->from($this->tbl_profile_projecthistory)
                 ->where('ProjectId', $value);
        $db = $this->db->get();
        $data = $db->row(0);

        $file_name = $data->ProjectFileUrl;

        if(empty($file_name) || is_null($file_name)){
            return '';
        }
        else{
            $url = site_url('modules/karyawan/assets/uploads/'.$file_name);
            if (!file_exists(FCPATH.'modules/karyawan/assets/uploads/'.$file_name)) {
                return '';
            }
            else{
                return $url;
            }
        }  
    }

    

    // add hyperlink
    public function _callback_column_Nama($value, $row){

        return '<a href="'.site_url($this->cms_module_path().'/'.$this->uri->segment(2).'/index/edit/'.$row->NIK).'">'.$value.'</a>';
        
    }


    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_select(){
        
        $empty_select = '<select name="DivisiID" class="chosen-select" data-placeholder="Select Division" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('CompanyId, DivisiID, DeptID, UnitID, SeksiID')
                     ->from($this->tbl_profile)
                     ->where('NIK', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $CompanyId = $row->CompanyId;
            $DivisiID = $row->DivisiID;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('iDivId, cDivName')
                     ->from('tbl_div')
                     ->where('iDivCompany', $CompanyId);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iDivId == $DivisiID) {
                    $empty_select .= '<option value="'.$row->iDivId.'" selected="selected">'.$row->cDivName.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->iDivId.'">'.$row->cDivName.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }

    public function empty_city_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="DeptID" class="chosen-select" data-placeholder="Select Departement" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('CompanyId, DivisiID, DeptID, UnitID, SeksiID')
                     ->from($this->tbl_profile)
                     ->where('NIK', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $DivisiID = $row->DivisiID;
            $DeptID = $row->DeptID;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('iDeptID, cDeptName')
                     ->from('tbl_dept')
                     ->where('iDeptDivID', $DivisiID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iDeptID == $DeptID) {
                    $empty_select .= '<option value="'.$row->iDeptID.'" selected="selected">'.$row->cDeptName.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->iDeptID.'">'.$row->cDeptName.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }


    public function empty_units_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="UnitID" class="chosen-select" data-placeholder="Select Unit" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('CompanyId, DivisiID, DeptID, UnitID, SeksiID')
                     ->from($this->tbl_profile)
                     ->where('NIK', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $UnitID = $row->UnitID;
            $DeptID = $row->DeptID;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('unitID, NamaUnit')
                     ->from('tbl_unit')
                     ->where('deptID', $DeptID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->unitID == $UnitID) {
                    $empty_select .= '<option value="'.$row->unitID.'" selected="selected">'.$row->NamaUnit.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->unitID.'">'.$row->NamaUnit.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }


    public function empty_seksi_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="SeksiID" class="chosen-select" data-placeholder="Select Section" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud  = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('CompanyId, DivisiID, DeptID, UnitID, SeksiID')
                     ->from($this->tbl_profile)
                     ->where('NIK', $listingID);
            $db     = $this->db->get();
            $row    = $db->row(0);
            $UnitID = $row->UnitID;
            $DeptID = $row->DeptID;
            $SeksiID = $row->SeksiID;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('iSectionID, cSectionName')
                     ->from('tbl_section')
                     ->where('unitID', $UnitID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iSectionID == $SeksiID) {
                    $empty_select .= '<option value="'.$row->iSectionID.'" selected="selected">'.$row->cSectionName.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->iSectionID.'">'.$row->cSectionName.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }


    //GET JSON OF STATES
    public function get_states(){
        $CompanyId = $this->uri->segment(4);
        
        $this->db->select('iDivId, cDivName')
                 ->from('tbl_div')
                 ->where('iDivCompany', $CompanyId);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iDivId, "property" => $row->cDivName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }
    
    //GET JSON OF CITIES
    public function get_cities(){
        $DivisiID = $this->uri->segment(4);
        
        $this->db->select('iDeptID, cDeptName')
                 ->from('tbl_dept')
                 ->where('iDeptDivID', $DivisiID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iDeptID, "property" => $row->cDeptName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }


    //GET JSON OF CITIES
    public function get_units(){
        $DeptID = $this->uri->segment(4);
        
        $this->db->select('unitID, NamaUnit')
                 ->from('tbl_unit')
                 ->where('deptID', $DeptID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->unitID, "property" => $row->NamaUnit);
        endforeach;
        
        echo json_encode($array);
        exit;
    }


    //GET JSON OF CITIES
    public function get_seksi(){
        $UnitID = $this->uri->segment(4);
        
        $this->db->select('iSectionID, cSectionName')
                 ->from('tbl_section')
                 ->where('unitID', $UnitID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iSectionID, "property" => $row->cSectionName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }


    // Ajax Library
    public function ajax_modal_mutation_employee(){

        $query = $this->db->select('NIK,Nama,Email')
            ->from($this->tbl_profile)
            //->where('CompanyId', $primary_key)
            ->get();
        $result = $query->row_array();
        $num_row = $query->num_rows();

        $data = array(
            'result' => $result,            
        );

        echo json_encode($data);     

    }

    public function save_callback_mutation_employee(){

        $today       = date('Y-m-d H:i:s');
        $nik_baru    = $this->input->post('nik_baru');
        $nik_lama    = $this->input->post('nik_lama');
        $mutasi_id   = $this->input->post('mutasi_id');

        $pieces = explode('/', $this->input->post('join_date'));
        $TglMasuk = $pieces[2].'-'.$pieces[1].'-'.$pieces[0];

        $this->db->select('NIK, Nama, Email')
                 ->from($this->tbl_profile)
                 ->where('NIK', $nik_baru);
        $db = $this->db->get();
        $row = $db->row(0);
        $num_row = $db->num_rows();


        $this->db->select('NIK, Nama, Email')
                 ->from($this->tbl_profile)
                 ->where('NIK', $nik_lama);
        $sql    = $this->db->get();
        $ws     = $sql->row(0);


        
        if(empty($nik_lama) || is_null($nik_lama)){
            $data = array('status' => FALSE, 'message' => 'NIK lama harus diisi...');
        }
        elseif(empty($nik_baru) || is_null($nik_baru)){
            $data = array('status' => FALSE, 'message' => 'NIK baru harus diisi...');
        }
        elseif(!is_numeric($nik_baru)){
            $data = array('status' => FALSE, 'message' => 'NIK baru harus numeric...');
        }
        elseif($num_row > 0){
            $data = array('status' => FALSE, 'message' => 'NIK baru sudah terdaftar sebelumnya, gunakan NIK yang lain...');
        }
        elseif(!$this->_validate($nik_baru,$nik_lama)){
            $data = array('status' => FALSE, 'message' => 'Join Date harus diisi...');
        }
        elseif(!$this->_callback_duplicate_row($nik_lama, $nik_baru)){
            $data = array('status' => FALSE, 'message' => 'Terjadi kesalahan pada koneksi database...');
        }
        else{           
            $data = array('status' => TRUE, 'message' => 'Data sudah disimpan...Klik <a href="'.site_url('admin_company/employee/index/edit/'.$nik_baru).'" class="" title="Edit"> Disini</a> untuk memperbaharui profil.');
            $this->db->update($this->tbl_profile, array('TglMasuk'=> $TglMasuk), array('NIK' => $nik_baru));

            $this->db->insert($this->tbl_profile_pergerakan_mutasi, array('nama_karyawan' => $ws->Nama, 'nik_lama' => $nik_lama, 'nik_baru' => $nik_baru, 'mutasi_id'=> $mutasi_id, 'created_by' => $this->cms_user_id()));

            $this->mailer_employee_model->kirim_email_mutasi($nik_lama, $nik_baru, $ws->Nama, $ws->Email, $this->set_table_row('tbl_master_pergerakan_mutasi', 'mutasi_id', $mutasi_id, 'mutasi_name'));
        }        

        echo json_encode($data);
    }


    public function _callback_duplicate_row($nik_lama, $nik_baru){

        $this->db->select('NIK,Nama,Email')
                 ->from('tbl_profile')
                 ->where('NIK', $nik_baru);
        $db = $this->db->get();
        $data = $db->row(0);
        $num_row = $db->num_rows();

        if ($num_row > 0){
            return FALSE;
        }
        else{

            $this->Duplicate_MySQL_Record_Primary($this->tbl_profile, $primary_key_field='NIK', $nik_lama, $nik_baru);           

            $this->Duplicate_MySQL_Record_Secondary($this->tbl_profile_certification, $primary_key_field='CertId', $secondary_key_field='CertNIK', $nik_lama, $nik_baru, $status_field='CertStatus');
            
            $this->Duplicate_MySQL_Record_Secondary($this->tbl_profile_attachment, $primary_key_field='file_id', $secondary_key_field='file_nik', $nik_lama, $nik_baru, $status_field=NULL);

            $this->Duplicate_MySQL_Record_Secondary($this->tbl_profile_education, $primary_key_field='EduId', $secondary_key_field='EduNIK', $nik_lama, $nik_baru, $status_field='EduStatus');

            $this->Duplicate_MySQL_Record_Secondary($this->tbl_profile_files, $primary_key_field='file_id', $secondary_key_field='file_nik', $nik_lama, $nik_baru, $status_field='file_status');

            $this->Duplicate_MySQL_Record_Secondary($this->tbl_profile_member, $primary_key_field='MemberId', $secondary_key_field='NIK', $nik_lama, $nik_baru, $status_field=NULL);

            $this->Duplicate_MySQL_Record_Secondary($this->tbl_profile_projecthistory, $primary_key_field='ProjectId', $secondary_key_field='ProjectNIK', $nik_lama, $nik_baru, $status_field='ProjectStatus');

            $this->Duplicate_MySQL_Record_Secondary($this->tbl_profile_technicalskill, $primary_key_field='TechnicalSkillId', $secondary_key_field='TechnicalSkillNIK', $nik_lama, $nik_baru, $status_field='TechnicalSkillStatus');

            $this->Duplicate_MySQL_Record_Secondary($this->tbl_profile_training, $primary_key_field='TrainingId', $secondary_key_field='TrainingNIK', $nik_lama, $nik_baru, $status_field='TrainingStatus');

            $this->Duplicate_MySQL_Record_Secondary($this->tbl_profile_workexperience, $primary_key_field='WorkExpId', $secondary_key_field='WorkExpNIK', $nik_lama, $nik_baru, $status_field='WorkExpStatus');            

            $this->employee_model->sisa_hak_cuti_user($nik_lama, $nik_baru);

            $this->db->update('tbl_main_user', array('user_id'=> $nik_baru), array('user_id' => $nik_lama));
            $this->db->update('tbl_main_group_user', array('user_id'=> $nik_baru), array('user_id' => $nik_lama));
            $this->db->update('tbl_kpi_header_form', array('EmployeeID'=> $nik_baru), array('EmployeeID' => $nik_lama));
            

            // HRIS APP
            /*
            $this->third_party_integrated($db_conn='default', $table='tbl_main_user', $primary_key_field='user_id', $nik_lama, $nik_baru);
            $this->third_party_integrated($db_conn='default', $table='tbl_main_group_user', $primary_key_field='user_id', $nik_lama, $nik_baru);
            $this->third_party_integrated($db_conn='default', $table='tbl_kpi_header_form', $primary_key_field='EmployeeID', $nik_lama, $nik_baru);
            */

            // EKASBON APP
            //$this->third_party_integrated($db_conn='ekasbon', $table='tbl_main_user', $primary_key_field='user_id', $nik_lama, $nik_baru);


            // EMSA APP
            //$this->third_party_integrated($db_conn='emsa', $table='tbl_main_user', $primary_key_field='user_id', $nik_lama, $nik_baru);

            
            return TRUE;
        }
    }


    public function Duplicate_MySQL_Record_Primary($table, $primary_key_field, $primary_key_val, $primary_key_new){
       /* generate the select query */
       $this->db->where($primary_key_field, $primary_key_val);        
       $query = $this->db->get($table);

        foreach ($query->result() as $row){   
            foreach($row as $key=>$val){        
                if($key != $primary_key_field){                    
                    $this->db->set($key, $val);               
                }
                else{
                    $this->db->set($key, $primary_key_new);
                }              
            }
        }
        /* insert the new record into table*/
        $this->db->insert($table);

        $this->db->update($table, array('bStatus'=> 0), array($primary_key_field => $primary_key_val));

        return TRUE;
    }

    public function Duplicate_MySQL_Record_Secondary($table, $primary_key_field, $secondary_key_field, $primary_key_val, $primary_key_new, $status_field){
       /* generate the select query */

        /*
        if(!empty($status_field) || !is_null($status_field)){

            $sql = $this->db->select($primary_key_field)
                        ->from($table)
                        ->where($secondary_key_field, $primary_key_val)
                        ->where($status_field, 1)
                        ->order_by($primary_key_field, 'ASC')           
                        ->get();
        }
        else{

            $sql = $this->db->select($primary_key_field)
                        ->from($table)
                        ->where($secondary_key_field, $primary_key_val)                        
                        ->order_by($primary_key_field, 'ASC')           
                        ->get();

        }
        */


        $sql = $this->db->select($primary_key_field)
                        ->from($table)
                        ->where($secondary_key_field, $primary_key_val)                        
                        ->order_by($primary_key_field, 'ASC')           
                        ->get();

        foreach($sql->result() as $data){

            $this->db->where($primary_key_field, $data->$primary_key_field);
            $query = $this->db->get($table);

            foreach ($query->result() as $row){   
                foreach($row as $key=>$val){        
                    if($key != $primary_key_field){                    
                        if($key == $secondary_key_field){
                            $this->db->set($key, $primary_key_new);
                        }
                        else{
                            $this->db->set($key, $val);
                        }                
                    }             
                }
            }
            /* insert the new record into table*/
            $this->db->insert($table);
        }

        return TRUE;
    }

    private function _validate($nik_lama, $nik_baru)
    {

        $data = array();
        $data['status'] = TRUE;

        if($this->input->post('join_date') == '')
        {    
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            return FALSE;
        }
        else{
            return TRUE;
        }
    }


    public function third_party_integrated($db_conn, $table, $primary_key_field, $primary_key_val, $primary_key_new){

        $db = $this->load->database($db_conn, TRUE);

        $this->$db->update($table, array($primary_key_field => $primary_key_new), array($primary_key_field => $primary_key_val));

        $this->$db->close();
        //return TRUE;        
    }

    public function ajax_modal_mutation_history($nama_karyawan){

        $today = date('Y-m-d');      

        $sql        = "SELECT NIK,Nama,Email,b.nik_lama,b.nik_baru,d.mutasi_name,DATE_FORMAT(TglMasuk,'%d-%b-%Y') AS TglMasuk,e.cCompanyName,f.cDivName,g.cDeptName FROM ".$this->tbl_profile." AS a 
                        LEFT JOIN ".$this->tbl_profile_pergerakan_mutasi." AS b ON a.NIK=b.nik_baru 
                        LEFT JOIN ".$this->tbl_profile_pergerakan_mutasi." AS c ON a.NIK=c.nik_lama 
                        LEFT JOIN tbl_master_pergerakan_mutasi AS d ON c.mutasi_id=d.mutasi_id 
                        INNER JOIN tbl_company AS e ON a.CompanyId=e.iCompanyId 
                        INNER JOIN tbl_div AS f ON f.iDivId = a.DivisiID 
                        INNER JOIN tbl_dept AS g ON g.iDeptID=a.DeptID
                        WHERE Nama LIKE '%".$nama_karyawan."%' GROUP BY a.NIK";
        $query      = $this->db->query($sql);        
       
        if(empty($nama_karyawan) || is_null($nama_karyawan)){
            $response = array(
                'result' => '',
            );
        }
        else{
            $response = array(
                'result' => $query->result(),
            );
        }
        

        echo json_encode($response);
    }


    public function ajax_modal_resume_employee($primary_key){

        $profile        = $this->employee_model->employee_profile($primary_key);
        $education      = $this->employee_model->education_profile($primary_key);
        $project        = $this->employee_model->project_profile($primary_key);
        $working        = $this->employee_model->working_profile($primary_key);
        $skill          = $this->employee_model->skill_profile($primary_key);
        $training       = $this->employee_model->training_profile($primary_key);
        $certification  = $this->employee_model->certification_profile($primary_key);

        $data = array(
            'profile' => $profile,
            'education' => $education,
            'working' => $working,
            'project' => $project,
            'skill' => $skill,
            'training' => $training,
            'certification' => $certification,
            'content' => $primary_key,
            'base_url' => base_url(),
            'font_awesome_css' => site_url('assets/orbit/plugins/font-awesome/css/font-awesome.css'),
        );

        echo $this->load->view($this->cms_module_path().'/modal_resume_employee_orbit_view', $data, TRUE);            
    }


    private function make_crud_family(){
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
        // $crud->unset_add();
        // $crud->unset_edit();
        // $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();


        $crud->set_language($this->cms_language());
        $today = date('Y-m-d H:i:s');        

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid-profile');
            $crud->set_relation('NIK', $this->tbl_profile, '{Nama}');
        }
        else{
            $crud->set_theme('no-flexigrid-general');
            $crud->set_relation('NIK', $this->tbl_profile, '{NIK}. {Nama}');
        }

        // table name
        $crud->set_table($this->tbl_profile_member);
        $crud->order_by('CompanyId,NIK','ASC');
        $crud->where('FIND_IN_SET (CompanyId,"'.$this->cms_user_form_company_id().'")');

        $crud->set_primary_key('MemberId');

        $crud->set_subject('Family');
        
        $crud->columns('NIK','MemberName','MemberTempatLahir','MemberLahir','MemberSex','MemberStatus','MemberBloodType','MemberKTP');
        
        $crud->edit_fields('NIK','MemberName','MemberTempatLahir','MemberLahir','MemberSex','MemberStatus','MemberBloodType','MemberKTP');        
    
        $crud->add_fields('NIK','MemberName','MemberTempatLahir','MemberLahir','MemberSex','MemberStatus','MemberBloodType','MemberKTP');    

        $crud->required_fields('NIK','MemberName','MemberTempatLahir','MemberLahir','MemberSex','MemberStatus','MemberBloodType','MemberKTP');

        // caption of each columns
        $crud->display_as('NIK','NIK');
        $crud->display_as('MemberName','Name');
        $crud->display_as('MemberTempatLahir','Birth Place');        
        $crud->display_as('MemberLahir','Birth Date');
        $crud->display_as('MemberSex','Sex');
        $crud->display_as('MemberStatus','Status');
        $crud->display_as('Status','Status Karyawan');
        $crud->display_as('MemberBloodType','Blood Type');
        $crud->display_as('MemberKTP','No KTP');     
    

        
        $crud->set_relation('MemberTempatLahir', 'tbl_city', 'City');
        $crud->set_relation('MemberSex', 'tbl_sex', 'SexNameEng');
        $crud->set_relation('MemberStatus', 'tbl_member_status', 'MemberStatusName');
        //$crud->set_relation('MemberBloodType', 'tbl_blood_type', 'BloodTypeName');

        $crud->set_primary_key('City', 'tbl_city');
        $crud->set_primary_key('BloodTypeName', 'tbl_blood_type');


        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $this->crud = $crud;
        return $crud;
    }   

    public function family(){
        $crud = $this->make_crud_family();
        $output = $crud->render();
        $this->view($this->cms_module_path().'/family_view', $output, $this->cms_complete_navigation_name('employee'));
    }


    private function make_crud_education(){
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
        // $crud->unset_add();
        // $crud->unset_edit();
        // $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();

        $crud->unset_texteditor('AlamatDomisili','AlamatKTP');

        $crud->set_language($this->cms_language());
        $today = date('Y-m-d H:i:s');        

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid-profile');
            $crud->set_relation('EduNIK', $this->tbl_profile, '{NIK}. {Nama}');
        }
        else{
            $crud->set_theme('no-flexigrid-general');
            $crud->set_relation('EduNIK', $this->tbl_profile, '{NIK}. {Nama}');
        }

        // table name
        $crud->set_table($this->tbl_profile_education);
        $crud->order_by('CompanyId,EduNIK','ASC');
        $crud->where('FIND_IN_SET (CompanyId,"'.$this->cms_user_form_company_id().'")');

        $crud->set_primary_key('EduId');

        $crud->set_subject('Education');
        
        $crud->columns('EduNIK','EduStart','EduFinish','EduLevelId','EduInstitution','EduCity','EduFaculty','EduMajor','EduGPA','EduCertificate','EduStatus');
        
        $crud->edit_fields('EduNIK','EduStart','EduFinish','EduLevelId','EduInstitution','EduCity','EduFaculty','EduMajor','EduGPA','EduCertificate','EduFileUrl','EduStatus');        
    
        $crud->add_fields('EduNIK','EduStart','EduFinish','EduLevelId','EduInstitution','EduCity','EduFaculty','EduMajor','EduGPA','EduCertificate','EduFileUrl','EduStatus','EduCreatedBy','EduCreatedTime');    

        $crud->required_fields('EduNIK','EduStart','EduFinish','EduLevelId','EduInstitution','EduCity','EduCertificate','EduStatus','EduUpdatedBy');

        // caption of each columns
        $crud->display_as('EduNIK','NIK');
        $crud->display_as('EduStart','Start');
        $crud->display_as('EduFinish','Finish');        
        $crud->display_as('EduLevelId','Level');
        $crud->display_as('EduInstitution','Institution');
        $crud->display_as('EduCity','City');
        $crud->display_as('EduFaculty','Faculty');
        $crud->display_as('EduMajor','Major');
        $crud->display_as('EduGPA','GPA');
        $crud->display_as('EduCertificate', 'Certificate');
        $crud->display_as('EduFileUrl', 'Evidence');
        $crud->display_as('EduStatus', 'Status');     
    
        $crud->field_type('EduStart','integer');
        $crud->field_type('EduFinish','integer');
        
        $crud->set_relation('EduCity', 'tbl_city', 'City');
        $crud->set_relation('EduLevelId', 'tbl_edulevel', 'EducationLevelName');
        $crud->set_relation('EduCertificate', 'tbl_edu_certificate', 'CertificateStatus');
        $crud->set_relation('EduFaculty', 'tbl_faculty', 'FacultyName');

        $crud->set_primary_key('City', 'tbl_city');
        $crud->set_primary_key('EducationLevelName', 'tbl_edulevel');
        $crud->set_primary_key('FacultyName', 'tbl_faculty');

         // HINT: Put custom field type here
        $crud->unset_add_fields('EduCreatedBy','EduCreatedTime','EduUpdatedBy','EduUpdatedTime');
        $crud->field_type('EduCreatedBy', 'hidden', $this->cms_user_id());
        $crud->field_type('EduCreatedTime', 'hidden', $today);        

        $crud->unset_edit_fields('EduUpdatedBy','EduUpdatedTime');
        $crud->field_type('EduUpdatedBy', 'hidden', $this->cms_user_id());
        $crud->field_type('EduUpdatedTime', 'hidden', $today);


        $crud->set_config_upload('pdf|jpg|jpeg|png', '1MB');
        $crud->add_action('Download', '', '','download-icon',array($this,'_callback_download_EduFileUrl'));
        $crud->set_field_upload('EduFileUrl','modules/karyawan/assets/uploads');        
        $crud->help_block('EduFileUrl', $this->cms_lang('Allowed file pdf,jpg,jpeg,png and maximum size 1 MB'));


        $crud->placeholder('EduStart', $this->cms_lang('Tahun mulai'));
        $crud->placeholder('EduFinish', $this->cms_lang('Tahun Selesai'));


        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $this->crud = $crud;
        return $crud;
    }   

    public function education(){
        $crud = $this->make_crud_education();
        $output = $crud->render();
        $this->view($this->cms_module_path().'/education_view', $output, $this->cms_complete_navigation_name('employee'));
    }



    /* Education Training */
    
    private function make_crud_training(){
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
        //$crud->unset_add();
        //$crud->unset_edit();
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        //$crud->unset_export();
        $crud->unset_texteditor('TrainingModul');


        $crud->set_language($this->cms_language());
        
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid-profile');
            $crud->set_relation('TrainingNIK', $this->tbl_profile, '{NIK}. {Nama}');  
        }
        else{
            $crud->set_theme('no-flexigrid-general');
            $crud->set_relation('TrainingNIK', $this->tbl_profile, '{NIK}. {Nama}');  
        }

        // table name
        $crud->set_table($this->tbl_profile_training);
        $crud->order_by('CompanyId,TrainingNIK','ASC');
        $crud->where('FIND_IN_SET (CompanyId,"'.$this->cms_user_form_company_id().'")');

        // primary key
        $crud->set_primary_key('TrainingId');

        // set subject
        $crud->set_subject($this->cms_lang('Training'));

        // displayed columns on list
        $crud->columns('TrainingNIK','TrainingYear','TrainingInstitution','TrainingCity','TrainingModul','TrainingType');
        $crud->edit_fields('TrainingNIK','TrainingYear','TrainingInstitution','TrainingCity','TrainingModul','TrainingType','TrainingUpdatedBy','TrainingFileUrl');        
        $crud->add_fields('TrainingNIK','TrainingYear','TrainingInstitution','TrainingCity','TrainingModul','TrainingType','TrainingCreatedBy','TrainingCreatedTime','TrainingUpdatedBy','TrainingFileUrl');

        // caption of each columns
        $crud->display_as('TrainingNIK', $this->cms_lang('NIK'));
        $crud->display_as('TrainingYear', $this->cms_lang('Year'));
        $crud->display_as('TrainingInstitution', $this->cms_lang('Institution'));
        $crud->display_as('TrainingCity', $this->cms_lang('City'));
        $crud->display_as('TrainingModul', $this->cms_lang('Modul'));
        $crud->display_as('TrainingType', $this->cms_lang('Type'));
        $crud->display_as('TrainingFileUrl', $this->cms_lang('Evidence'));

        $crud->required_fields('TrainingNIK','TrainingYear','TrainingInstitution','TrainingCity','TrainingModul','TrainingType');
        //$crud->unique_fields('name');
        
        $crud->field_type('TrainingModul' ,'text');
        $crud->field_type('TrainingYear','integer');

        $crud->unset_add_fields('TrainingCreatedBy','TrainingCreatedTime','TrainingUpdatedBy');
        $crud->unset_edit_fields('TrainingUpdatedBy');
        $crud->field_type('TrainingCreatedBy', 'hidden', $this->cms_user_id());
        $crud->field_type('TrainingCreatedTime', 'hidden', date('Y-m-d H:i:s'));
        $crud->field_type('TrainingUpdatedBy', 'hidden', $this->cms_user_id());


        $crud->set_config_upload('pdf|jpg|jpeg|png', '1MB');
        $crud->add_action('Download', '', '','download-icon',array($this,'_callback_download_TrainingFileUrl'));
        $crud->set_field_upload('TrainingFileUrl','modules/karyawan/assets/uploads');        
        $crud->help_block('TrainingFileUrl', $this->cms_lang('Allowed file pdf,jpg,jpeg,png and maximum size 1 MB'));

        /* set relational */
        
        $crud->set_primary_key('City', 'tbl_city');       
        $crud->set_relation('TrainingCity', 'tbl_city', 'City');
              

        
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $this->crud = $crud;
        return $crud;
    }

    public function training(){
        $crud = $this->make_crud_training();
        $output = $crud->render();
        $this->view($this->cms_module_path().'/training_view', $output,
            $this->cms_complete_navigation_name('employee'));
    }



    /* Certification */
    
    private function make_crud_certification(){
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
        //$crud->unset_add();
        //$crud->unset_edit();
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        //$crud->unset_export();
        //$crud->unset_texteditor('TechnicalSkillDesc');

        $crud->set_language($this->cms_language());
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid-profile');
        }
        else{
            $crud->set_theme('no-flexigrid-general');
        }

        // table name
        $crud->set_table($this->tbl_profile_certification);
        $crud->order_by('CompanyId,CertNIK','ASC');
        $crud->where('FIND_IN_SET (CompanyId,"'.$this->cms_user_form_company_id().'")');

        // primary key
        $crud->set_primary_key('CertId');

        // set subject
        $crud->set_subject($this->cms_lang('Certification'));

        // displayed columns on list
        $crud->columns('CertNIK','CertDate','CertItem','CertProduct','CertName','CertPartnerName','CertValidStart','CertValidFinish','CertStatus');
        $crud->edit_fields('CertNIK','CertDate','CertItem','CertProduct','CertName','CertPartnerName','CertValidStart','CertValidFinish','CertStatus','CertFileUrl','CertUpdatedBy');        
        $crud->add_fields('CertNIK','CertDate','CertItem','CertProduct','CertName','CertPartnerName','CertValidStart','CertValidFinish','CertStatus','CertFileUrl','CertCreatedBy','CertCreatedTime','CertUpdatedBy');

        // caption of each columns
        $crud->display_as('CertNIK', $this->cms_lang('NIK'));
        $crud->display_as('CertDate', $this->cms_lang('Date'));
        $crud->display_as('CertItem', $this->cms_lang('Item'));
        $crud->display_as('CertProduct', $this->cms_lang('Product'));
        $crud->display_as('CertFileUrl', $this->cms_lang('Evidence'));
        $crud->display_as('CertName', $this->cms_lang('Title'));
        $crud->display_as('CertPartnerName', $this->cms_lang('Partner'));
        $crud->display_as('CertValidStart', $this->cms_lang('Start'));
        $crud->display_as('CertValidFinish', $this->cms_lang('Finish'));
        $crud->display_as('CertStatus', $this->cms_lang('Status'));
        

        $crud->required_fields('CertNIK','CertDate','CertItem','CertProduct','CertName','CertPartnerName','CertValidStart','CertValidFinish');
        //$crud->unique_fields('name');
    
        $crud->set_config_upload('pdf|jpg|jpeg|png', '1MB');
        $crud->set_field_upload('CertFileUrl','modules/karyawan/assets/uploads');
        $crud->add_action('Download', '', '','download-icon',array($this,'_callback_download_CertFileUrl'));
        $crud->help_block('CertFileUrl', $this->cms_lang('Allowed file pdf,jpg,jpeg,png and maximum size 1 MB'));

        $crud->set_relation('CertItem', 'tbl_certification_item', 'CertItemName');
        $crud->set_relation('CertNIK', $this->tbl_profile, '{NIK}. {Nama}');

        $crud->unset_add_fields('CertCreatedBy','CertCreatedTime','CertUpdatedBy');
        $crud->unset_edit_fields('CertUpdatedBy');
        $crud->field_type('CertCreatedBy', 'hidden', $this->cms_user_id());
        $crud->field_type('CertCreatedTime', 'hidden', date('Y-m-d H:i:s'));
        $crud->field_type('CertUpdatedBy', 'hidden', $this->cms_user_id());
       

        
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $this->crud = $crud;
        return $crud;
    }

    public function certification(){
        $crud = $this->make_crud_certification();
        $output = $crud->render();
        $this->view($this->cms_module_path().'/certification_view', $output,
            $this->cms_complete_navigation_name('employee'));
    }


    private function make_crud_project_history(){
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
        //$crud->unset_add();
        //$crud->unset_edit();
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        //$crud->unset_export();
        $crud->unset_texteditor('ProjectTechnicalSpec');

        $crud->set_language($this->cms_language());
        
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid-profile');
        }
        else{
            $crud->set_theme('no-flexigrid-general');
        }

        // table name
        $crud->set_table($this->tbl_profile_projecthistory);
        $crud->order_by('CompanyId,ProjectNIK','ASC');
        $crud->where('FIND_IN_SET (CompanyId,"'.$this->cms_user_form_company_id().'")');

        // primary key
        $crud->set_primary_key('ProjectId');

        // set subject
        $crud->set_subject($this->cms_lang('Project History'));

        // displayed columns on list
        $crud->columns('ProjectNIK','ProjectDate','ProjectName','ProjectInstitution','ProjectYear','ProjectLength','ProjectTechnicalSpec','ProjectPosition','ProjectStatus');
        $crud->edit_fields('ProjectNIK','ProjectDate','ProjectName','ProjectInstitution','ProjectYear','ProjectLength','ProjectTechnicalSpec','ProjectPosition','ProjectStatus','ProjectFileUrl','ProjectUpdatedBy');        
        $crud->add_fields('ProjectNIK','ProjectDate','ProjectName','ProjectInstitution','ProjectYear','ProjectLength','ProjectTechnicalSpec','ProjectPosition','ProjectStatus','ProjectFileUrl','ProjectCreatedBy','ProjectCreatedTime','ProjectUpdatedBy');

        // caption of each columns
        $crud->display_as('ProjectDate', $this->cms_lang('Date'));
        $crud->display_as('ProjectInstitution', $this->cms_lang('Institution'));
        $crud->display_as('ProjectYear', $this->cms_lang('Year'));
        $crud->display_as('ProjectFileUrl', $this->cms_lang('Evidence'));
        $crud->display_as('ProjectName', $this->cms_lang('Title'));
        $crud->display_as('ProjectLength', $this->cms_lang('Duration'));
        $crud->display_as('ProjectTechnicalSpec', $this->cms_lang('Description'));
        $crud->display_as('ProjectPosition', $this->cms_lang('Position'));
        $crud->display_as('ProjectNIK', $this->cms_lang('NIK'));
        $crud->display_as('ProjectStatus', $this->cms_lang('Status'));
        

        $crud->field_type('ProjectYear','integer');
        $crud->required_fields('ProjectNIK','ProjectDate','ProjectName','ProjectInstitution','ProjectYear','ProjectLength','ProjectTechnicalSpec','ProjectPosition');
        //$crud->unique_fields('name');
    
        $crud->set_config_upload('pdf|jpg|jpeg|png', '1MB');
        $crud->set_field_upload('ProjectFileUrl','modules/karyawan/assets/uploads');
        $crud->add_action('Download', '', '','download-icon',array($this,'_callback_download_ProjectFileUrl'));
        $crud->help_block('ProjectFileUrl', $this->cms_lang('Allowed file pdf,jpg,jpeg,png and maximum size 1 MB'));
        $crud->help_block('ProjectLength', $this->cms_lang('Waktu pengerjaan proyek'));
        $crud->help_block('ProjectPosition', $this->cms_lang('Posisi dalam proyek tersebut'));

        $crud->set_relation('ProjectNIK', $this->tbl_profile, '{NIK}. {Nama}');

        $crud->unset_add_fields('ProjectCreatedBy','ProjectCreatedTime','ProjectUpdatedBy');
        $crud->unset_edit_fields('ProjectUpdatedBy');
        $crud->field_type('ProjectCreatedBy', 'hidden', $this->cms_user_id());
        $crud->field_type('ProjectCreatedTime', 'hidden', date('Y-m-d H:i:s'));
        $crud->field_type('ProjectUpdatedBy', 'hidden', $this->cms_user_id());
        

        
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $this->crud = $crud;
        return $crud;
    }

    public function project(){
        $crud = $this->make_crud_project_history();
        $output = $crud->render();
        $this->view($this->cms_module_path().'/project_view', $output,
            $this->cms_complete_navigation_name('employee'));
    }


    /* Technical Skill */
    
    private function make_crud_technical_skill(){
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
        //$crud->unset_add();
        //$crud->unset_edit();
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        //$crud->unset_export();
        $crud->unset_texteditor('TechnicalSkillDesc');

        $crud->set_language($this->cms_language());

        // table name
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid-profile');
        }
        else{
            $crud->set_theme('no-flexigrid-general');
        }

        // table name
        $crud->set_table($this->tbl_profile_technicalskill);
        $crud->order_by('CompanyId,TechnicalSkillNIK','ASC');
        $crud->where('FIND_IN_SET (CompanyId,"'.$this->cms_user_form_company_id().'")');

        // primary key
        $crud->set_primary_key('TechnicalSkillId');

        // set subject
        $crud->set_subject($this->cms_lang('Technical Skill'));

        // displayed columns on list
        $crud->columns('TechnicalSkillNIK','TechnicalSkillName','TechnicalSkillExp','TechnicalSkillDesc');
        $crud->edit_fields('TechnicalSkillNIK','TechnicalSkillName','TechnicalSkillExp','TechnicalSkillDesc','TechnicalSkillFileUrl','TechnicalSkillUpdatedBy');        
        $crud->add_fields('TechnicalSkillNIK','TechnicalSkillName','TechnicalSkillExp','TechnicalSkillDesc','TechnicalSkillFileUrl','TechnicalSkillCreatedBy','TechnicalSkillCreatedTime','TechnicalSkillUpdatedBy');

        // caption of each columns
        $crud->display_as('TechnicalSkillNIK', $this->cms_lang('NIK'));
        $crud->display_as('TechnicalSkillName', $this->cms_lang('Title'));
        $crud->display_as('TechnicalSkillExp', $this->cms_lang('Experience'));
        $crud->display_as('TechnicalSkillDesc', $this->cms_lang('Description'));
        $crud->display_as('TechnicalSkillFileUrl', $this->cms_lang('Evidence'));
        

        $crud->required_fields('TechnicalSkillNIK','TechnicalSkillName','TechnicalSkillExp','TechnicalSkillDesc');
        //$crud->unique_fields('name');
    
        $crud->set_config_upload('pdf|jpg|jpeg|png', '1MB');
        $crud->set_field_upload('TechnicalSkillFileUrl','modules/karyawan/assets/uploads');
        $crud->add_action('Download', '', '','download-icon',array($this,'_callback_download_TechnicalSkillFileUrl'));
        $crud->help_block('TechnicalSkillFileUrl', $this->cms_lang('Allowed file pdf,jpg,jpeg,png and maximum size 1 MB'));
        $crud->help_block('TechnicalSkillName', $this->cms_lang('Nama Keahlian/Kompetensi'));

        $crud->set_relation('TechnicalSkillNIK', $this->tbl_profile, '{NIK}. {Nama}');

        $crud->unset_add_fields('TechnicalSkillCreatedBy','TechnicalSkillCreatedTime','TechnicalSkillUpdatedBy');
        $crud->unset_edit_fields('TechnicalSkillUpdatedBy');
        $crud->field_type('TechnicalSkillCreatedBy', 'hidden', $this->cms_user_id());
        $crud->field_type('TechnicalSkillCreatedTime', 'hidden', date('Y-m-d H:i:s'));
        $crud->field_type('TechnicalSkillUpdatedBy', 'hidden', $this->cms_user_id());
        

        
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $this->crud = $crud;
        return $crud;
    }

    public function skill(){
        $crud = $this->make_crud_technical_skill();
        $output = $crud->render();
        $this->view($this->cms_module_path().'/skill_view', $output,
            $this->cms_complete_navigation_name('employee'));
    }



    /* attachment */
    
    private function make_crud_attachment(){
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
        //$crud->unset_add();
        //$crud->unset_edit();
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        //$crud->unset_export();
        $crud->unset_texteditor('ProjectTechnicalSpec');

        $crud->set_language($this->cms_language());
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid-profile');
        }
        else{
            $crud->set_theme('no-flexigrid-general');
        }

        // table name
        $crud->set_table($this->tbl_profile_attachment);
        $crud->order_by('CompanyId,file_nik','ASC');
        $crud->where('FIND_IN_SET (CompanyId,"'.$this->cms_user_form_company_id().'")');

        // primary key
        $crud->set_primary_key('file_id');

        // set subject
        $crud->set_subject($this->cms_lang('Attachment'));

        // displayed columns on list
        $crud->columns('file_nik','file_code');
        $crud->edit_fields('file_nik','file_code','url');        
        $crud->add_fields('file_nik','file_code','url');

        // caption of each columns
        $crud->display_as('file_code', $this->cms_lang('Title'));
        $crud->display_as('file_nik', $this->cms_lang('NIK'));
        $crud->display_as('url', $this->cms_lang('File'));       
        
        $crud->required_fields('file_nik','file_code','url');
        //$crud->unique_fields('name');

        //$crud->set_dialog_forms(true);
    
        $crud->set_config_upload('pdf|jpg|jpeg|png', '1MB');
        $crud->set_field_upload('url','modules/karyawan/assets/uploads');
        $crud->add_action('Download', '', '','download-icon',array($this,'_callback_download_url'));
        $crud->help_block('url', $this->cms_lang('Allowed file pdf,jpg,jpeg,png and maximum size 1 MB'));

        $crud->set_relation('file_nik', $this->tbl_profile, '{NIK}. {Nama}');

        //$crud->unset_add_fields('file_nik');       
        //$crud->field_type('file_nik', 'hidden', $this->cms_user_id());

        
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $this->crud = $crud;
        return $crud;
    }

    public function attachment(){
        $crud = $this->make_crud_attachment();
        $output = $crud->render();
        $this->view($this->cms_module_path().'/attachment_view', $output,
            $this->cms_complete_navigation_name('employee'));
    }



     private function make_crud_work_experience(){
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
        //$crud->unset_add();
        //$crud->unset_edit();
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        //$crud->unset_export();
        $crud->unset_texteditor('WorkExpDesc');

        $crud->set_language($this->cms_language());
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid-profile');
        }
        else{
            $crud->set_theme('no-flexigrid-general');
        }

        // table name
        $crud->set_table($this->tbl_profile_workexperience);
        $crud->order_by('CompanyId,WorkExpNIK','ASC');
        $crud->where('FIND_IN_SET (CompanyId,"'.$this->cms_user_form_company_id().'")');

        // primary key
        $crud->set_primary_key('WorkExpId');

        // set subject
        $crud->set_subject($this->cms_lang('Work Experience'));

        // displayed columns on list
        $crud->columns('WorkExpNIK','WorkExpStart','WorkExpFinish','WorkExpCompany','WorkExpPosition','WorkExpDesc');
        $crud->edit_fields('WorkExpNIK','WorkExpStart','WorkExpFinish','WorkExpCompany','WorkExpPosition','WorkExpDesc','WorkExpUpdatedBy','WorkExpFileUrl');
        $crud->add_fields('WorkExpNIK','WorkExpStart','WorkExpFinish','WorkExpCompany','WorkExpPosition','WorkExpDesc','WorkExpCreatedBy','WorkExpCreatedTime','WorkExpUpdatedBy','WorkExpFileUrl');

        // caption of each columns
        $crud->display_as('WorkExpStart', $this->cms_lang('Start'));
        $crud->display_as('WorkExpFinish', $this->cms_lang('Finish'));
        $crud->display_as('WorkExpCompany', $this->cms_lang('Company'));
        $crud->display_as('WorkExpPosition', $this->cms_lang('Position'));
        $crud->display_as('WorkExpDesc', $this->cms_lang('Description'));
        $crud->display_as('WorkExpFileUrl', $this->cms_lang('Evidence'));
        $crud->display_as('WorkExpNIK', $this->cms_lang('NIK'));

        $crud->required_fields('WorkExpNIK','WorkExpStart','WorkExpFinish','WorkExpCompany','WorkExpPosition','WorkExpDesc');

        
        
        //$crud->field_type('WorkExpNIK' ,'readonly');

        // Help Block Library
        $crud->help_block('WorkExpFileUrl', $this->cms_lang('Allowed file pdf,jpg and maximum size 1 MB'));

        // Placeholder Library
        $crud->placeholder('WorkExpStart', $this->cms_lang('Start working'));
        $crud->placeholder('WorkExpFinish', $this->cms_lang('End working'));

        $crud->unset_add_fields('WorkExpCreatedBy','WorkExpCreatedTime','WorkExpUpdatedBy');
        $crud->field_type('WorkExpCreatedBy', 'hidden', $this->cms_user_id());
        $crud->field_type('WorkExpCreatedTime', 'hidden', date('Y-m-d H:i:s'));
        $crud->field_type('WorkExpUpdatedBy', 'hidden', $this->cms_user_id());
        //$crud->field_type('WorkExpNIK', 'hidden', $this->cms_user_id());

        $crud->set_config_upload('pdf|jpg|jpeg|png', '1MB');
        $crud->set_field_upload('WorkExpFileUrl','modules/karyawan/assets/uploads');
        $crud->add_action('Download', '', '','download-icon',array($this,'_callback_download_WorkExpFileUrl'));

        $crud->set_relation('WorkExpNIK', $this->tbl_profile, '{NIK}. {Nama}');

        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $this->crud = $crud;
        return $crud;
    }

    public function working(){
        $crud = $this->make_crud_work_experience();
        $output = $crud->render();
        $this->view($this->cms_module_path().'/working_view', $output,
            $this->cms_complete_navigation_name('employee'));
    }


    public function set_table_row($table, $primary_key_field, $primary_key_val, $return_field){

        $this->db->select($return_field)
                 ->from($table)
                 ->where($primary_key_field, $primary_key_val);
        $db = $this->db->get();
        $data = $db->row(0);
        $num_row = $db->num_rows();

        if($num_row > 0){
            return $data->$return_field;
        }
        else{
            return '';
        }
    }



    


}