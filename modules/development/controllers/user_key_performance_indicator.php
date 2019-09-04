<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class user_key_performance_indicator extends CMS_Priv_Strict_Controller {

    protected $URL_MAP = array();

    public $navigation_name = '';
    protected $user_department_id = NULL;
    protected $user_company_id = NULL;
    protected $key_id = NULL;
    protected $key_title = NULL;
    protected $key_nik = NULL;
    protected $key_type = NULL;
    protected $key_active = NULL;
    protected $key_agree = NULL;
    protected $key_nik_atasan = NULL;
    protected $salt = 'aB1cD2eF3G';
    protected $performance_management=0;


    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('mailer_model');
        $this->load->model('mailer_kpi_model');  
        if ($this->cms_have_privilege('performance_management') == 1) $this->performance_management = 1;
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

    public function navigation_name($value){

        $navigation_name = $this->uri->segment(3);

        if ($value == $navigation_name){
            return 'active';
        }
        else{
            return '';
        } 

        $this->navigation_name = $navigation_name;
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
        // $crud->unset_print();
        // $crud->unset_export();

        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_country_model');
        */

        
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->cms_complete_table_name('country'));

        // primary key
        $crud->set_primary_key('country_id');

        // set subject
        $crud->set_subject('Country');

        // displayed columns on list
        $crud->columns('name');
        // displayed columns on edit operation
        $crud->edit_fields('name');
        // displayed columns on add operation
        $crud->add_fields('name');

      
        // caption of each columns
        $crud->display_as('name','Name');

      
        $crud->required_fields('name');

       
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

        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        $crud = $this->make_crud();
        $output = $crud->render();

        

        $primary_key = $this->input->get('KPIID');

        if (isset($primary_key)){
            $period_id = $this->input->get('KPIID');
            $this->set_current_key($this->cms_user_id(), $period_id);
        }
        else{
            $period_id = 0;
            $this->set_current_key($this->cms_user_id(), $period_id);
        }


        if($this->performance_management == 1){
            $SQL    = "SELECT * FROM tbl_kpi_header_form WHERE KPIID='".$this->key_id."'";            
            $query  = $this->db->query($SQL);        
            $result = $query->row_array();
        }
        else{
            $SQL    = "SELECT * FROM tbl_kpi_header_form WHERE KPIID='".$this->key_id."' AND (EmployeeID='".$this->cms_user_id()."' OR iAtasanNIK='".$this->cms_user_id()."' OR (iAtasanNIK2='".$this->cms_user_id()."' AND iAgree = 1))";
            $query  = $this->db->query($SQL);        
            $result = $query->row_array();
        }
        

        $output->session_nik = $this->cms_user_id();
        $output->primary_key = $this->key_id;
        $output->result = $result;
        $output->costum_user_logo = $this->costum_user_logo();
        $output->date_format = $date_format;
        $output->key_title = $this->key_title;
        $output->period_option = $this->period_option();
        $output->key_active = $this->key_active;
        $output->key_type = $this->key_type;
        $output->key_nik_atasan = $this->key_nik_atasan;
        $output->key_agree = $this->key_agree;
        $output->performance_management = $this->performance_management;    


        $this->view($this->cms_module_path().'/user_key_performance_indicator_view', $output, $this->cms_complete_navigation_name('user_key_performance_indicator'));

    }


    private function make_crud_header_form(){
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // initialize groceryCRUD
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud = $this->new_crud();
        // this is just for code completion
        if (FALSE) $crud = new Extended_Grocery_CRUD();

        $today = date('Y-m-d H:i:s');

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
        $crud->unset_texteditor('cDescription');


        //$crud->set_theme('no-flexigrid-employee-kpi');
        $crud->set_theme('no-flexigrid-general');

        
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table('tbl_kpi_header_form');
        $crud->where('EmployeeID', $this->cms_user_id());

        // primary key
        $crud->set_primary_key('KPIID');

        // set subject
        $crud->set_subject('IPP (Individual Performance Plan)');

        // displayed columns on list
        $crud->columns('EmployeeID','full_name','CompanyID','DivisionID','DepartmentID','UnitID','iGrade','PeriodID','iTypeForm','iOrgItem','iAtasanNIK','iAtasanNIK2','cTitle','cDescription');
        // displayed columns on edit operation
        $crud->edit_fields('EmployeeID','CompanyID','DivisionID','DepartmentID','UnitID','iGrade','PeriodID','iTypeForm','iOrgItem','iAtasanNIK','iAtasanNIK2','cTitle','cDescription');
        // displayed columns on add operation
        $crud->add_fields('EmployeeID','CompanyID','DivisionID','DepartmentID','UnitID','iGrade','iGrade','PeriodID','iTypeForm','iOrgItem','iAtasanNIK','iAtasanNIK2','cTitle','cDescription','CreatedTime','CreatedBy');

        // caption of each columns
        $crud->display_as('CompanyID','Company');
        $crud->display_as('UnitID','Unit');
        $crud->display_as('DepartmentID','Department');
        $crud->display_as('DivisionID','Division');
        $crud->display_as('PeriodID','Period');
        $crud->display_as('cTitle','Title');
        $crud->display_as('cDescription','Description');
        $crud->display_as('iTypeForm','Type Form');
        $crud->display_as('iAtasanNIK','Atasan Langsung');
        $crud->display_as('iOrgItem','Item');
        $crud->display_as('iGrade','Grade');        
        $crud->display_as('iAtasanNIK2','Atasan Tdk Langsung'); //perubahan KPA

        $crud->unset_add_fields('EmployeeID','CompanyID','DivisionID','DepartmentID','UnitID','CreatedTime','CreatedBy');

        $crud->field_type('EmployeeID', 'hidden', $this->cms_user_id());
        $crud->field_type('CompanyID', 'hidden', $this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='CompanyId', $this->cms_user_id()));
        $crud->field_type('DivisionID', 'hidden', $this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='DivisiID', $this->cms_user_id()));
        $crud->field_type('DepartmentID', 'hidden', $this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='DeptID', $this->cms_user_id()));
        $crud->field_type('UnitID', 'hidden', $this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='UnitID', $this->cms_user_id()));

        $crud->field_type('iGrade', 'hidden', $this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Grade', $this->cms_user_id()));
        $crud->field_type('CreatedTime', 'hidden', $today);
        $crud->field_type('CreatedBy', 'hidden', $this->cms_user_id());
      
        $crud->required_fields('EmployeeID','CompanyID','DivisionID','DepartmentID','PeriodID','iAtasanNIK','iAtasanNIK2','iTypeForm','cTitle','iOrgItem');

        $crud->set_primary_key('NamaTahun','tbl_year');
        $crud->set_relation('PeriodID', 'tbl_year', 'NamaTahun');
        $crud->set_relation('iTypeForm', 'tbl_kpi_type_form', 'cName');
        //$crud->set_relation('iAtasanNIK', 'tbl_apv_group_approval', 'NIK', array('divisionID' => 1));
        $crud->set_relation('iAtasanNIK', 'tbl_profile', 'Nama', array('bStatus' => 1));
        $crud->set_relation('iAtasanNIK2', 'tbl_profile', 'Nama', array('bStatus' => 1));

        $crud->callback_column('full_name',array($this, '_callback_column_full_name'));
        $crud->callback_column('CompanyID',array($this, '_callback_column_CompanyID'));
        $crud->callback_column('DivisionID',array($this, '_callback_column_DivisionID'));
        $crud->callback_column('DepartmentID',array($this, '_callback_column_DepartmentID'));
        $crud->callback_column('UnitID',array($this, '_callback_column_UnitID'));

        $crud->callback_field('iAtasanNIK',array($this, '_callback_field_atasan_user'));
        $crud->callback_field('iAtasanNIK2',array($this, '_callback_field_atasan_user_2'));

        //$crud->field_type('iOrgItem','set',array('Struktural','Fungsional'));
        //$crud->field_type('iOrgItem', 'set', array(1 => 'Struktural', 2 => 'Fungsional'));

        $crud->field_type('iOrgItem','dropdown', array(1 => 'Struktural', 2 => 'Fungsional'));

        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $this->crud = $crud;
        return $crud;
    }


    public function header_form(){

        $this->set_user_profile($this->cms_user_id());

        $crud = $this->make_crud_header_form();

        if($crud->getState() == 'edit' && $this->cms_user_id() != $this->cms_table_data('tbl_kpi_header_form', 'KPIID', 'EmployeeID', $this->uri->segment(5))){
            redirect($this->cms_module_path().'/user_key_performance_indicator/header_form','refresh');
        }

        $output = $crud->render();
        $this->view($this->cms_module_path().'/header_form_view', $output, $this->cms_complete_navigation_name('user_key_performance_indicator'));
    }


    //CALLBACK FUNCTIONS
    public function _callback_field_atasan_user($value, $primary_key){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="iAtasanNIK" id="iAtasanNIK" class="chosen-select" data-placeholder="Pilih Atasan" style="width: 350px;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('iAtasanNIK')
                     ->from('tbl_kpi_header_form')
                     ->where('KPIID', $listingID);
            $db = $this->db->get();
            $data = $db->row(0);
            
            //GET THE STATES PER COUNTRY ID

            $SQL    = "select b.NIK as NIK,b.Nama AS Nama from tbl_apv_group_approval as a inner join tbl_profile as b on a.NIK=b.NIK 
                        where a.deptID=".$this->user_department_id." group by a.NIK
                        union 
                        select d.superiors_nik AS NIK,d.superiors_name AS Nama from tbl_apv_group_bawahan as c inner join tbl_apv_group_superiors as d on c.superiors_id=d.superiors_id where c.NIK=".$this->cms_user_id()." and d.superiors_nik !=".$this->cms_user_id()." group by d.superiors_nik";
            $query  = $this->db->query($SQL);
            /*
            $this->db->select('tbl_profile.NIK AS NIK,Nama')
                     ->from('tbl_apv_group_approval')
                     ->join('tbl_profile', 'tbl_apv_group_approval.NIK=tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID', $this->user_department_id)
                     ->group_by('tbl_apv_group_approval.NIK')
                     ->order_by('iGroupApprovalListId','ASC');
            $db = $this->db->get();
            */
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($query->result() as $row){
                if($row->NIK == $data->iAtasanNIK){
                    $empty_select .= '<option value="'.$row->NIK.'" selected="selected">'.$row->NIK.' '.$row->Nama.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->NIK.' '.$row->Nama.'</option>';
                }
            }
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {

            $SQL    = "select b.NIK as NIK,b.Nama AS Nama from tbl_apv_group_approval as a inner join tbl_profile as b on a.NIK=b.NIK 
                        where a.deptID=".$this->user_department_id." group by a.NIK
                        union 
                        select d.superiors_nik AS NIK,d.superiors_name AS Nama from tbl_apv_group_bawahan as c inner join tbl_apv_group_superiors as d on c.superiors_id=d.superiors_id where c.NIK=".$this->cms_user_id()." and d.superiors_nik !=".$this->cms_user_id()." group by d.superiors_nik";
            $query  = $this->db->query($SQL);
            /*
            $this->db->select('tbl_profile.NIK AS NIK,Nama')
                     ->from('tbl_apv_group_approval')
                     ->join('tbl_profile', 'tbl_apv_group_approval.NIK=tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID', $this->user_department_id)
                     ->group_by('tbl_apv_group_approval.NIK')
                     ->order_by('iGroupApprovalListId','ASC');
            $db = $this->db->get();
            */
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($query->result() as $row){               
                $empty_select .= '<option value="'.$row->NIK.'">'.$row->NIK.' '.$row->Nama.'</option>';                
            }

            return $empty_select.$empty_select_closed;  
        }
    }



    private function make_crud_activity_plan(){
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
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        // $crud->unset_print();
        // $crud->unset_export();

        $crud->unset_texteditor('Description');


        $crud->set_theme('no-flexigrid-employee-kpi');

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table('tbl_kpi_activity_plan');
        $crud->where('EmployeeID', $this->cms_user_id());

        // primary key
        $crud->set_primary_key('activity_id');

        // set subject
        $crud->set_subject('I. KPI -KEY PERFORMANCE INDICATOR (Berdasarkan KPI evaluation yang mengacu pada Activity Plan)');

        // displayed columns on list
        $crud->columns('KPIID','Description','UoM','DD','EveryMonth','Bobot_A','Plan_B');
        // displayed columns on edit operation
        $crud->edit_fields('KPIID','Description','UoM','DD','EveryMonth','Bobot_A','Plan_B');
        // displayed columns on add operation
        $crud->add_fields('KPIID','Description','UoM','DD','EveryMonth','Bobot_A','Plan_B');

        // caption of each columns
        $crud->display_as('Bobot_A','Bobot_A (%)');
        $crud->display_as('EveryMonth','Setiap bulan?');
        $crud->display_as('DD','Due Date');
        $crud->display_as('PeriodID','Period');

        $crud->set_rules('Bobot_A','Bobot_A','integer');

        $crud->unset_add_fields('EmployeeID','CompanyID','DivisionID','DepartmentID');
      
        $crud->required_fields('KPIID','Description','UoM','Bobot_A','Plan_B');

        $crud->field_type('EveryMonth', 'true_false', array('No', 'Yes'));

    
        $crud->set_relation('KPIID', 'tbl_kpi_header_form', 'PeriodID',array('EmployeeID' => $this->cms_user_id()));
        $crud->set_relation('UoM', 'tbl_kpi_uom', 'NameUom');

        $crud->callback_column('full_name',array($this, '_callback_column_full_name'));
        $crud->callback_column('CompanyID',array($this, '_callback_column_CompanyID'));
        $crud->callback_column('DivisionID',array($this, '_callback_column_DivisionID'));
        $crud->callback_column('DepartmentID',array($this, '_callback_column_DepartmentID'));
       
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $this->crud = $crud;
        return $crud;
    }


    public function activity_plan(){
        $crud = $this->make_crud_activity_plan();
        $output = $crud->render();
        $this->view($this->cms_module_path().'/activity_plan_view', $output, $this->cms_complete_navigation_name('user_key_performance_indicator'));
    }



    private function make_crud_routine_activity(){
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
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        // $crud->unset_print();
        // $crud->unset_export();

        $crud->unset_texteditor('Description');


        $crud->set_theme('no-flexigrid-employee-kpi');

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table('tbl_kpi_routine_activity');
        $crud->where('EmployeeID', $this->cms_user_id());

        // primary key
        $crud->set_primary_key('routine_id');

        // set subject
        $crud->set_subject('II. PERFORMANCE INDICATOR (ROUTINE ACTIVITY) ');

        // displayed columns on list
        $crud->columns('KPIID','Description','UoM','DD','EveryMonth','Bobot_A','Plan_B');
        // displayed columns on edit operation
        $crud->edit_fields('KPIID','Description','UoM','DD','EveryMonth','Bobot_A','Plan_B');
        // displayed columns on add operation
        $crud->add_fields('KPIID','Description','UoM','DD','EveryMonth','Bobot_A','Plan_B');

        // caption of each columns
        $crud->display_as('Bobot_A','Bobot_A (%)');
        $crud->display_as('EveryMonth','Setiap bulan?');
        $crud->display_as('DD','Due Date');
        $crud->display_as('PeriodID','Period');

        $crud->set_rules('Bobot_A','Bobot_A','integer');

        $crud->unset_add_fields('EmployeeID','CompanyID','DivisionID','DepartmentID');
      
        $crud->required_fields('KPIID','Description','UoM','Bobot_A','Plan_B');

        $crud->field_type('EveryMonth', 'true_false', array('No', 'Yes'));

    
        $crud->set_relation('KPIID', 'tbl_kpi_header_form', 'PeriodID',array('EmployeeID' => $this->cms_user_id()));
        $crud->set_relation('UoM', 'tbl_kpi_uom', 'NameUom');

        $crud->callback_column('full_name',array($this, '_callback_column_full_name'));
        $crud->callback_column('CompanyID',array($this, '_callback_column_CompanyID'));
        $crud->callback_column('DivisionID',array($this, '_callback_column_DivisionID'));
        $crud->callback_column('DepartmentID',array($this, '_callback_column_DepartmentID'));
       
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $this->crud = $crud;
        return $crud;
    }


    public function routine_activity(){
        $crud = $this->make_crud_routine_activity();
        $output = $crud->render();
        $this->view($this->cms_module_path().'/routine_activity_view', $output, $this->cms_complete_navigation_name('user_key_performance_indicator'));
    }



    private function make_crud_special_assignment(){
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
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        // $crud->unset_print();
        // $crud->unset_export();

        $crud->unset_texteditor('Description');


        $crud->set_theme('no-flexigrid-employee-kpi');

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table('tbl_kpi_special_assignment');
        $crud->where('EmployeeID', $this->cms_user_id());

        // primary key
        $crud->set_primary_key('assignment_id');

        // set subject
        $crud->set_subject('III. SPECIAL ASSIGNMENT');

        // displayed columns on list
        $crud->columns('KPIID','Description','UoM','DD','EveryMonth','Bobot_A','Plan_B');
        // displayed columns on edit operation
        $crud->edit_fields('KPIID','Description','UoM','DD','EveryMonth','Bobot_A','Plan_B');
        // displayed columns on add operation
        $crud->add_fields('KPIID','Description','UoM','DD','EveryMonth','Bobot_A','Plan_B');

        $crud->set_rules('Bobot_A','Bobot_A','integer');

        // caption of each columns
        $crud->display_as('Bobot_A','Bobot_A (%)');
        $crud->display_as('EveryMonth','Setiap bulan?');
        $crud->display_as('DD','Due Date');
        $crud->display_as('PeriodID','Period');

        $crud->unset_add_fields('EmployeeID','CompanyID','DivisionID','DepartmentID');
      
        $crud->required_fields('KPIID','Description','UoM','Bobot_A','Plan_B');

    
        $crud->set_relation('KPIID', 'tbl_kpi_header_form', 'PeriodID',array('EmployeeID' => $this->cms_user_id()));
        $crud->set_relation('UoM', 'tbl_kpi_uom', 'NameUom');

        $crud->field_type('EveryMonth', 'true_false', array('No', 'Yes'));

        $crud->callback_column('full_name',array($this, '_callback_column_full_name'));
        $crud->callback_column('CompanyID',array($this, '_callback_column_CompanyID'));
        $crud->callback_column('DivisionID',array($this, '_callback_column_DivisionID'));
        $crud->callback_column('DepartmentID',array($this, '_callback_column_DepartmentID'));
       
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $this->crud = $crud;
        return $crud;
    }


    public function special_assignment(){
        $crud = $this->make_crud_special_assignment();
        $output = $crud->render();
        $this->view($this->cms_module_path().'/special_assignment_view', $output, $this->cms_complete_navigation_name('user_key_performance_indicator'));
    }



    public function _before_insert($post_array){
        $post_array = $this->_before_insert_or_update($post_array);
        // HINT : Put your code here
        return $post_array;
    }

    public function _after_insert($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);

        $ckey_hash = md5($this->salt.$primary_key);

        //$year = date('Y');
        $year = $post_array['PeriodID'];
        $DD   = $year.'-'.'12'.'-'.'31';

        if ($this->uri->segment(3) == 'header_form'){

            $this->db->update('tbl_kpi_header_form', array('ckey_hash' => $ckey_hash), array('KPIID'=> $primary_key)); 

            /*
            if ($post_array['iTypeForm'] == 2){
                $Plan_B = 4;
            }
            else{
                $Plan_B = 3;
            }

            $query = $this->db->select('iCoreValues, tCoreValues')
               ->from('tbl_kpi_core_values')
               ->order_by('iCoreValues', 'ASC')           
               ->get();
            $no=1;
            foreach($query->result() as $data){

                $this->db->select('Description')->from('tbl_kpi_activity_plan')->where('ItemID', 4)->where('Description', $data->tCoreValues)->where('KPIID', $primary_key);
                $db      = $this->db->get();
                $num_row = $db->num_rows();

                if ($num_row <= 0){
                    $this->db->insert('tbl_kpi_activity_plan', array('KPIID'=>$primary_key, 'ItemID'=>4, 'Description'=>$data->tCoreValues, 'UoM' =>'%', 'DD'=>$DD, 'Plan_B'=> $Plan_B, 'Bobot_A'=>10));
                }
            }


            if ($post_array['iTypeForm'] == 2){

                $query = $this->db->select('iManPeople, tManPeople,PlanManPeople,BobotManPeople')
                   ->from('tbl_kpi_managing_people')
                   ->order_by('iManPeople', 'ASC')           
                   ->get();
                $no=1;
                foreach($query->result() as $data){

                    $this->db->select('Description')->from('tbl_kpi_activity_plan')->where('ItemID', 5)->where('Description', $data->tManPeople)->where('KPIID', $primary_key);
                    $db      = $this->db->get();
                    $num_row = $db->num_rows();

                    if ($num_row <= 0){
                        $this->db->insert('tbl_kpi_activity_plan', array('KPIID'=>$primary_key, 'ItemID'=>5, 'Description'=>$data->tManPeople, 'UoM' =>'%', 'DD'=>$DD, 'Plan_B'=>$data->PlanManPeople, 'Bobot_A'=>$data->BobotManPeople));
                    }                                        
                }
            }
            else{
                $this->db->delete('tbl_kpi_activity_plan', array('KPIID'=> $primary_key, 'ItemID'=> 5));
            }

            */


        }
        
        // HINT : Put your code here
        return $success;
    }

    public function _before_update($post_array, $primary_key){
        $post_array = $this->_before_insert_or_update($post_array, $primary_key);

        if ($this->uri->segment(3) == 'header_form'){

            $this->db->select('EmployeeID')
                 ->from('tbl_kpi_header_form')
                 ->where('KPIID', $primary_key);
            $db      = $this->db->get();
            $data    = $db->row(0);
            $num_row = $db->num_rows();

            if ($data->EmployeeID != $this->cms_user_id()){
                return FALSE;
            }
            else{
                return $post_array;
            }


        }
        else{
            return $post_array;
        }        
    }

    public function _after_update($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here


        return $success;
    }

    public function _before_delete($primary_key){

        if ($this->uri->segment(3) == 'header_form'){
            $this->db->delete('tbl_kpi_routine_activity', array('routine_id'=> $primary_key));
            $this->db->delete('tbl_kpi_activity_plan', array('activity_id'=> $primary_key));
            $this->db->delete('tbl_kpi_special_assignment', array('assignment_id'=> $primary_key));
        }       


        return TRUE;
    }

    public function _after_delete($primary_key){
        return TRUE;
    }

    public function _after_insert_or_update($post_array, $primary_key){

        //$year = date('Y');
        $year = $post_array['PeriodID'];
        $DD   = $year.'-'.'12'.'-'.'31';

        if ($this->uri->segment(3) == 'header_form'){
            
            if ($post_array['iTypeForm'] == 2){
                $Plan_B = 4;
            }
            else{
                $Plan_B = 3;
            }

            $query = $this->db->select('iCoreValues, tCoreValues, dDefaultValue')
               ->from('tbl_kpi_core_values')
               ->order_by('iCoreValues', 'ASC')           
               ->get();
            $no=1;

            if ($this->count_activity_user($primary_key, $item=4) <= 0){
                foreach($query->result() as $data){                    
                    $this->db->insert('tbl_kpi_activity_plan', 
                        array('KPIID'=>$primary_key,
                              'ItemID'=>4,
                              'Reg_ID'=>$data->iCoreValues,
                              'Description'=>$data->tCoreValues,
                              'UoM' =>'%',
                              'DD'=> $DD,
                              'Plan_B'=> $Plan_B,
                              'Bobot_A'=> $data->dDefaultValue)
                        );                    
                }
            }
            else{
                $this->db->update('tbl_kpi_activity_plan', array('DD'=>$DD), array('KPIID' => $primary_key, 'ItemID'=> 4));
            }


            if ($post_array['iTypeForm'] == 2){

                $query = $this->db->select('iManPeople, tManPeople,PlanManPeople,BobotManPeople')
                                  ->from('tbl_kpi_managing_people')
                                  ->order_by('iManPeople', 'ASC')           
                                  ->get();
                $no=1;

                if ($this->count_activity_user($primary_key, $item=5) <= 0){

                    foreach($query->result() as $data){
                        
                        $this->db->insert('tbl_kpi_activity_plan', 
                            array('KPIID'=>$primary_key,
                                  'ItemID'=>5,
                                  'Reg_ID'=>$data->iManPeople,
                                  'Description'=>$data->tManPeople,
                                  'UoM' =>'%',
                                  'DD'=>$DD,
                                  'Plan_B'=>$data->PlanManPeople,
                                  'Bobot_A'=>$data->BobotManPeople)
                            );                                                                
                    }
                }
                else{
                    $this->db->update('tbl_kpi_activity_plan', array('DD'=>$DD), array('KPIID' => $primary_key, 'ItemID'=> 5));
                }
                
            }
            else{
                $this->db->delete('tbl_kpi_activity_plan', array('KPIID'=> $primary_key, 'ItemID'=> 5));
            }            


        }

        return TRUE;
    }

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }

    public function _callback_column_full_name($value, $row){

        return $this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $row->EmployeeID);

    }

    public function _callback_column_CompanyID($value, $row){

        return $this->cms_table_data($table_name='tbl_company', $where_column='iCompanyId', $result_column='cCompanyName', $row->CompanyID);

    }

    public function _callback_column_DivisionID($value, $row){

        return $this->cms_table_data($table_name='tbl_div', $where_column='iDivId', $result_column='cDivName', $row->DivisionID);

    }

    public function _callback_column_DepartmentID($value, $row){

        return $this->cms_table_data($table_name='tbl_dept', $where_column='iDeptID', $result_column='cDeptName', $row->DepartmentID);

    }

    public function _callback_column_UnitID($value, $row){

        return $this->cms_table_data($table_name='tbl_unit', $where_column='unitID', $result_column='NamaUnit', $row->UnitID);

    }

    public function count_activity_user($primary_key, $item){

        $this->db->select('COUNT(activity_id) AS Total')
                 ->from('tbl_kpi_activity_plan')
                 ->where('KPIID', $primary_key)
                 ->where('ItemID', $item);
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

    public function cms_table_data($table_name, $where_column, $result_column, $value){

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


    public function period_option(){        

        $primary_key = $this->input->get('KPIID');

        $java_script = '<script type = "text/javascript">
                        function goToPage(id) {
                          var node = document.getElementById(id);  
                          if( node &&
                            node.tagName == "SELECT" ) {
                            window.location.href = node.options[node.selectedIndex].value;    
                          }  
                        }
                        </script>';


        if (isset($primary_key)){            
            $this->set_current_key($this->cms_user_id(), $primary_key);
        }
        else{
            $this->set_current_key($this->cms_user_id(), $primary_key);
        }

        $empty_select = '<div class="col-sm-4">';
        $empty_select .= '<select data-live-search="true" class="selectpicker show-tick form-control" data-show-subtext="true" data-container="body" data-width="100%" onchange=goToPage("select") name="select" id="select" data-header="Pilih Karyawan">';
        $empty_select_closed = '</select></div>';

        $this->db->select('KPIID,cTitle,EmployeeID')
                 ->from('tbl_kpi_header_form')
                 ->where('EmployeeID', $this->cms_user_id())
                 ->order_by('KPIID','DESC');
                        
        $db = $this->db->get();            

        foreach($db->result() as $data):

            if($data->KPIID == $this->key_id) {
                $empty_select .= '<option value="'.site_url('development/user_key_performance_indicator/?KPIID='.$data->KPIID).'" data-subtext="'.$this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->EmployeeID).'" SELECTED>'.$data->cTitle.'</option>';
            }
            else{
                $empty_select .= '<option value="'.site_url('development/user_key_performance_indicator/?KPIID='.$data->KPIID).'" data-subtext="'.$this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->EmployeeID).'" >'.$data->cTitle.'</option>';
            }      
        endforeach;        

        $this->db->select('KPIID,cTitle,EmployeeID')
                 ->from('tbl_kpi_header_form')
                 ->where('iAtasanNIK', $this->cms_user_id())
                 ->where('EmployeeID !=', $this->cms_user_id())
                 ->order_by('EmployeeID','DESC');
                        
        $sql = $this->db->get();
        $num_row= $sql->num_rows();

        if ($num_row > 0){
            $empty_select .='<option data-divider="true"></option>';
        }            

        foreach($sql->result() as $data):

            if($data->KPIID == $this->key_id) {
                $empty_select .= '<option value="'.site_url('development/user_key_performance_indicator/?KPIID='.$data->KPIID).'" data-subtext="'.$this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->EmployeeID).'" SELECTED>'.$data->cTitle.'</option>';
            }
            else{
                $empty_select .= '<option value="'.site_url('development/user_key_performance_indicator/?KPIID='.$data->KPIID).'" data-subtext="'.$this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->EmployeeID).'" >'.$data->cTitle.'</option>';
            }      
        endforeach;


        if($this->performance_management == 1){
			
            $empty_select .='<option data-divider="true"></option>';

            $this->db->select('KPIID,cTitle,EmployeeID,PeriodID')
                 ->from('tbl_kpi_header_form')
                 ->where('iAtasanNIK !=', $this->cms_user_id())
                 ->where('EmployeeID !=', $this->cms_user_id())
                 ->order_by('PeriodID,EmployeeID','DESC');
            $sqli = $this->db->get();

            foreach($sqli->result() as $data):

                if($data->KPIID == $this->key_id) {
                    $empty_select .= '<option value="'.site_url('development/user_key_performance_indicator/?KPIID='.$data->KPIID).'" data-subtext="'.$this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->EmployeeID).'" SELECTED>'.$data->cTitle.' <small>'.$data->PeriodID.'</small></option>';
                }
                else{
                    $empty_select .= '<option value="'.site_url('development/user_key_performance_indicator/?KPIID='.$data->KPIID).'" data-subtext="'.$this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->EmployeeID).'" >'.$data->cTitle.' <small>'.$data->PeriodID.'</small></option>';
                }      
            endforeach;
        }

        return $empty_select.$empty_select_closed.$java_script; 
    }



    public function __period_option(){        

        $primary_key = $this->input->get('KPIID');

        if (isset($primary_key)){            
            $this->set_current_key($this->cms_user_id(), $primary_key);
        }
        else{
            $this->set_current_key($this->cms_user_id(), $primary_key);
        }

        $empty_select = '<div class="btn-group">';
        $empty_select .= '<button type="button" class="btn btn-sm btn-default ">{{ language:PA }} '.$this->key_title.' ('.$this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $this->key_nik).')</button>';
        $empty_select .= '<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">';
        $empty_select .= '<span class="caret"></span>';
        $empty_select .= '<span class="sr-only">Toggle Dropdown</span>';
        $empty_select .= '</button>';

        $empty_select .= '<ul class="dropdown-menu" role="menu">';
        $empty_select_closed = '</ul></div>';

        $this->db->select('KPIID,cTitle,EmployeeID')
                 ->from('tbl_kpi_header_form')
                 ->where('EmployeeID', $this->cms_user_id())
                 ->order_by('KPIID','DESC');
                        
        $db = $this->db->get();            

        foreach($db->result() as $data):

            if($data->KPIID == $this->key_id) {
                $empty_select .= '<li class="active"><a href="{{ base_url }}development/user_key_performance_indicator/?KPIID='.$data->KPIID.'">'.$data->cTitle.' ('.$this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->EmployeeID).')</a></li>';
            }
            else{
                $empty_select .= '<li><a href="{{ base_url }}development/user_key_performance_indicator/?KPIID='.$data->KPIID.'">'.$data->cTitle.' ('.$this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->EmployeeID).')</a></li>';
            }      
        endforeach;        

        $this->db->select('KPIID,cTitle,EmployeeID')
                 ->from('tbl_kpi_header_form')
                 ->where('iAtasanNIK', $this->cms_user_id())
                 ->where('EmployeeID !=', $this->cms_user_id())
                 ->order_by('EmployeeID','DESC');
                        
        $sql = $this->db->get();
        $num_row= $sql->num_rows();

        if ($num_row > 0){
            $empty_select .='<li class="divider"></li>';
        }            

        foreach($sql->result() as $data):

            if($data->KPIID == $this->key_id) {
                $empty_select .= '<li class="active"><a href="{{ base_url }}development/user_key_performance_indicator/?KPIID='.$data->KPIID.'">'.$data->cTitle.' ('.$this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->EmployeeID).')</a></li>';
            }
            else{
                $empty_select .= '<li><a href="{{ base_url }}development/user_key_performance_indicator/?KPIID='.$data->KPIID.'">'.$data->cTitle.' ('.$this->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->EmployeeID).')</a></li>';
            }      
        endforeach;


        return $empty_select.$empty_select_closed; 
    }


    public function costum_user_logo(){

         $this->db->select('CompanyId')
                     ->from('tbl_profile')
                     ->where('NIK', $this->cms_user_id());
            $sql    = $this->db->get();
            $data    = $sql->row(0);
            $num_row= $sql->num_rows();




        if ($data->CompanyId == $this->cms_get_config('cms_sisindokom_id')){
                $logo_img  = '<img src ="{{ site_logosis }}" style="max-height:35px; max-width:180px;" />';
            }
            // jasnikom
            elseif ($data->CompanyId == $this->cms_get_config('cms_jasnikom_id')){
                $logo_img  = '<img src ="{{ site_logojas }}" style="max-height:35px; max-width:180px;" />';
            }

            elseif ($data->CompanyId == $this->cms_get_config('cms_mediaindonusa_id')){
                $logo_img  = '<img src ="{{ site_logomediaindonusa }}" style="max-height:35px; max-width:180px;" />';
            }            

            elseif ($data->CompanyId == $this->cms_get_config('cms_mediatek_id')){
                $logo_img  = '<img src ="{{ site_logomediatek }}" style="max-height:35px; max-width:180px;" />';
            }

            elseif ($data->CompanyId == $this->cms_get_config('cms_mediaindonusa_id')){
                $logo_img  = '<img src ="{{ site_logodatacell }}" style="max-height:35px; max-width:180px;" />';
            }

            elseif ($data->CompanyId == $this->cms_get_config('cms_provis_id')){
                $logo_img  = '<img src ="{{ site_logoprovis }}" style="max-height:35px; max-width:180px;" />';
            }

            else {
                $logo_img  = '<img src ="{{ site_logo }}" style="max-height:35px; max-width:180px;" />';
            }

            return $logo_img;

    }


    public function set_user_profile($session_nik){

        $this->db->select('NIK,Nama,CompanyId,DivisiID,DeptID,UnitID')
                 ->from('tbl_profile')
                 ->where('NIK', $session_nik);
        $db      = $this->db->get();
        $data    = $db->row(0);
        $num_row = $db->num_rows();
        if ($num_row > 0){
            $this->user_department_id = $data->DeptID;
            $this->user_company_id = $data->CompanyId;
        }
        return $this;
    }

    public function set_current_key($session_nik, $key_id=NULL){

        if (isset($key_id) && $key_id > 0){

            $this->db->select('KPIID, cTitle, iTypeForm, EmployeeID, iAtasanNIK, iAgree, Active')
                 ->from('tbl_kpi_header_form')
                 ->where('KPIID', $key_id)
                 ->order_by('KPIID', 'DESC')
                 ->limit(1);
            $db      = $this->db->get();
            $data    = $db->row(0);
            $num_row = $db->num_rows();

        }
        else{
            $this->db->select('KPIID, cTitle, iTypeForm, EmployeeID, iAtasanNIK, iAgree, Active')
                     ->from('tbl_kpi_header_form')
                     ->where('EmployeeID', $session_nik)
                     ->order_by('KPIID', 'DESC')
                     ->limit(1);
            $db      = $this->db->get();
            $data    = $db->row(0);
            $num_row = $db->num_rows();
        }

        if ($num_row > 0){
            $this->key_id = $data->KPIID;
            $this->key_title = $data->cTitle;
            $this->key_type = $data->iTypeForm;
            $this->key_active = $data->Active;
            $this->key_nik = $data->EmployeeID;
            $this->key_nik_atasan = $data->iAtasanNIK;
            $this->key_agree = $data->iAgree;
        }
        return $this;
    }

    public function set_nilai_skala($value=NULL){

        if ($value <= 60 && $value > 10){
            return 1;
        }
        elseif($value > 60 && $value <= 80){
            return 2;
        }
        elseif($value > 80 && $value <= 100){
            return 3;
        }
        elseif($value > 100 && $value <= 120){
            return 4;
        }
        elseif($value > 120){
            return 5;
        }
        else{
            return 0;
        }
    }


    public function set_nilai_akhir_pa($value=NULL){
        /*
        if ($value >= 4.50 && $value <= 5.00){
            return 'IST (ISTIMEWA)';
        }
        elseif($value >= 3.75 && $value <= 4.49){
            return 'BS (BAIK SEKALI)';
        }
        elseif($value >= 3.25 && $value <= 3.74){
            return 'B+ (BAIK PLUS)';
        }
        elseif($value >= 3.00 && $value <= 3.24){
            return 'B (BAIK)';
        }
        elseif($value >= 2.75 && $value <= 2.99){
            return 'B- (BAIK MINUS)';
        }
        elseif($value >= 2.00 && $value <= 2.74){
            return 'C (CUKUP)';
        }
        elseif($value >= 1.00 && $value <= 1.99){
            return 'K (KURANG)';
        }        
        else{
            return 'Tidak Terdeteksi';
        }
        */

        /* Dirubah atas pemintaan bu Titi tgl 11-Apr-2018 */
        
        if($value >= 4.52){
            return 'BS (BAIK SEKALI)';
        }
        elseif($value >= 4.01 && $value <= 4.51){
            return 'B+ (BAIK PLUS)';
        }
        elseif($value >= 3.70 && $value <= 4.00){
            return 'B (BAIK)';
        }
        elseif($value >= 3.39 && $value <= 3.69){
            return 'B- (BAIK MINUS)';
        }
        elseif($value >= 3.08 && $value <= 3.38){
            return 'C+ (CUKUP PLUS)';
        }
        elseif($value >= 2.77 && $value <= 3.07){
            return 'C (CUKUP)';
        }
        elseif($value >= 2.26 && $value <= 2.76){
            return 'C- (CUKUP MINUS)';
        }
        elseif($value <= 2.25){
            return 'K (KURANG)';
        }        
        else{
            return 'Tidak Terdeteksi';
        }

    }


    public function plan_edit($id){

        $this->load->model('development_model');

        $data = $this->development_model->get_edit_plan($id);
        //$data->DD = ($data->DD == '00/00/0000') ? '' : $data->DD;
        $data->total = $this->development_model->count_bobot_user($data->KPIID, $data->ItemID, $id);
        echo json_encode($data);
    }

    public function plan_insert()
    {
        $this->load->model('development_model');
        $this->_validate($this->input->post('KPIID'),$this->input->post('ItemID'), $activity_id=NULL);

        $pieces = explode('/', $this->input->post('DD'));
        $DD = $pieces[2].'-'.$pieces[1].'-'.$pieces[0];

        $EveryMonth_post = $this->input->post('EveryMonth');

        if (isset($EveryMonth_post)){
            $EveryMonth = 1;
        }
        else{
            $EveryMonth = 0;
        }

        $data = array(
                'KPIID' => $this->input->post('KPIID'),
                'ItemID' => $this->input->post('ItemID'),
                'Description' => $this->input->post('Description'),
                'UoM' => $this->input->post('UoM'),
                'DD' => $DD,
                'EveryMonth' => $EveryMonth,
                'Bobot_A' => $this->input->post('Bobot_A'),
                'Plan_B' => $this->input->post('Plan_B'),
            );
        $insert = $this->development_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function plan_update()
    {
        $this->load->model('development_model');

        $this->_validate($this->input->post('KPIID'), $this->input->post('ItemID'), $this->input->post('activity_id'));

        $pieces = explode('/', $this->input->post('DD'));

        $DD = $pieces[2].'-'.$pieces[1].'-'.$pieces[0];


        $data = array(
                'ItemID' => $this->input->post('ItemID'),
                'Description' => $this->input->post('Description'),
                'UoM' => $this->input->post('UoM'),
                'DD' => $DD,
                'EveryMonth' => $this->input->post('EveryMonth'),
                'Bobot_A' => $this->input->post('Bobot_A'),
                'Plan_B' => $this->input->post('Plan_B'),
            );

        $this->development_model->update(array('activity_id' => $this->input->post('activity_id')), $data);
        echo json_encode(array("status" => TRUE));
    }


    public function plan_monitoring($id){

        $this->load->model('development_model');

        $this->db->select('*')
                 ->from('tbl_kpi_activity_plan')
                 ->where('activity_id', $id);
        $db      = $this->db->get();
        $row    = $db->row(0);        

        $data = $this->development_model->get_monitoring_plan($id);
        $data->narration_managing_people = $this->development_model->get_narration_managing_people($data->Reg_ID);
        $data->narration_core_value      = $this->development_model->get_narration_core_value($data->Reg_ID);
        $data->narration_key_performance_indicator      = $this->development_model->get_narration_key_performance_indicator($data->ItemID);
        $data->MonRemarksAtasan      = $row->MonRemarksAtasan;

        echo json_encode($data);
    }

    private function randomize_string($value){
        $time = date('Y:m:d H:i:s');
        return substr(md5($value.$time),0,6);
    }


    public function plan_monitoring_update()
    {
        $this->load->model('development_model');
        //$this->_validate();
        $today = date('Ymd_His');
        //$fileName = $today.'_'.$_FILES['MonEvidence']['name'];

        //$this->_validate();

        $data = array(
                'SM1' => $this->input->post('SM1'),
                'SM2' => $this->input->post('SM2'),
                'MonRemarks' => $this->input->post('MonRemarks'),
                'Nilai_Skala_Atasan' => $this->input->post('Nilai_Skala_Atasan'),
                'MonRemarksAtasan' => $this->input->post('MonRemarksAtasan'),
            );

        
        if($this->input->post('remove_photo')) // if remove photo checked
        {
            if(file_exists('./assets/files/upload_pa/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
                unlink('./assets/files/upload_pa/'.$this->input->post('remove_photo'));
            $data['photo'] = '';
        }

        if(!empty($_FILES['photo']['name']))
        {
            $upload = $this->_do_upload();
            
            //delete file
            $person = $this->development_model->get_by_id($this->input->post('activity_id'));

            if(file_exists('./assets/files/upload_pa/'.$person->photo) && $person->photo)
                unlink('./assets/files/upload_pa/'.$person->photo);

            $data['photo'] = $upload;
        }




        /*
        $config['upload_path'] = './assets/files/upload_pa/';
        $config['allowed_types'] = 'gif|jpg|png|doc|txt';
        $config['max_size'] = 1024 * 8;
        //$config['encrypt_name'] = TRUE;
 
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $this->upload->data();
        */       

       
        $this->development_model->update_monitoring(array('activity_id' => $this->input->post('activity_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function plan_delete($id)
    {
        $this->load->model('development_model');

        $this->development_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function plan_deal($id)
    {
        $this->load->model('development_model');

        $this->development_model->deal_by_id($id);

        echo json_encode(array("status" => TRUE));
    }

    public function plan_undeal($id)
    {
        $this->load->model('development_model');

        $this->development_model->undeal_by_id($id);
        echo json_encode(array("status" => TRUE));
    }


    private function _validate($primary_key, $type, $activity_id)
    {

        $this->load->model('development_model');
       
        $total = $this->development_model->count_bobot_user($primary_key, $type, $activity_id);

        $grand = $total+$this->input->post('Bobot_A');

        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('ItemID') == '')
        {
            $data['inputerror'][] = 'ItemID';
            $data['error_string'][] = 'Item is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('Description') == '')
        {
            $data['inputerror'][] = 'Description';
            $data['error_string'][] = 'Description is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('UoM') == '')
        {
            $data['inputerror'][] = 'UoM';
            $data['error_string'][] = 'UoM is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('DD') == '')
        {
            $data['inputerror'][] = 'DD';
            $data['error_string'][] = 'Due Date is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('Plan_B') == '')
        {
            $data['inputerror'][] = 'Plan_B';
            $data['error_string'][] = 'Target Plan is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('Bobot_A') == '')
        {
            $data['inputerror'][] = 'Bobot_A';
            $data['error_string'][] = 'Bobot is required';
            $data['status'] = FALSE;
        }

        if($grand > 100)
        {
            $data['inputerror'][] = 'Bobot_A';
            $data['error_string'][] = 'Total bobot tidak boleh melebihi 100%, Total bobot saat ini '.$total.'%';
            $data['status'] = FALSE;
        }


        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }


    private function _do_upload()
    {

        //$upload_path = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';

        $config['upload_path']          = './assets/files/upload_pa/';
        $config['allowed_types']        = 'gif|jpg|png|pdf';
        $config['max_size']             = 1000; //set max size allowed in Kilobyte
        $config['max_width']            = 1000; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('photo')) //upload and validate
        {
            $data['inputerror'][] = 'photo';
            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

    public function set_bobot_nilai_user($primary_key, $type){

        $SQL    = "SELECT cFPValue FROM `tbl_kpi_header_form` INNER JOIN 
                   tbl_kpi_faktor_penilaian ON iFPGradeID=LEFT(iGrade ,1) AND iFPItem=iOrgItem 
                   WHERE KPIID='".$primary_key."' AND iFPActivityID='".$type."'";
        $query  = $this->db->query($SQL);
        $data   = $query->row(0);
        $num_row = $query->num_rows();

        if ($num_row > 0){
            return $data->cFPValue;
        }
        else{
            return 0;
        }       

    }

    public function summing_bobot_user($primary_key, $type){

        if ($type ==1){

            $SQL    = "SELECT sum(Bobot_A) AS Total FROM `tbl_kpi_activity_plan` WHERE KPIID='".$primary_key."' AND (ItemID=1 OR ItemID=2 OR ItemID =3)";
            $query  = $this->db->query($SQL);
            $data   = $query->row(0);
            $num_row = $query->num_rows();

        }
        else{

            $SQL    = "SELECT sum(Bobot_A) AS Total FROM `tbl_kpi_activity_plan` WHERE KPIID='".$primary_key."' AND ItemID='".$type."'";
            $query  = $this->db->query($SQL);
            $data   = $query->row(0);
            $num_row = $query->num_rows();

        }
    

        if ($num_row > 0){
            return $data->Total;
        }
        else{
            return 0;
        }       

    }

    public function update_total_score($primary_key, $column, $score){

        $this->db->update('tbl_kpi_header_form', array($column=> $score), array('KPIID'=>$primary_key));
        return $this->db->affected_rows();
    }

    public function kpi_deal()
    {
        
        $today = date('Y-m-d H:i:s');
       
        $data = array(
                'iAgree' => $this->input->post('iAgree'),
                'dAgreeDate' => $today,
                'PARemarks' => $this->input->post('PARemarks'),
            );

        $this->db->update('tbl_kpi_header_form',$data, array('KPIID'=> $this->input->post('KPIID')));

        $this->mailer_model->send_deal_mailer($this->input->post('KPIID'), $this->cms_user_id());

        echo json_encode(array("status" => TRUE));
    }




    public function deal_edit($id){

        $this->load->model('development_model');
        $data = $this->development_model->get_detail_header($id);
    
        echo json_encode($data);
    }


    public function ajax_callback_monitor_global($primary_key, $type){

        $this->load->model('development_model');

        $SQL    = "SELECT EmployeeID,iAtasanNIK,iAgree,Active FROM `tbl_kpi_header_form` WHERE KPIID='".$primary_key."'";
        $query  = $this->db->query($SQL);
        $row    = $query->row(0);

        $data = array(
            'result'=> $this->development_model->get_data_global($primary_key, $type),
            'session_nik' => $this->cms_user_id(),
            'session_nik_atasan' => $row->iAtasanNIK,
            'key_agree' => $row->iAgree,
            'key_active' => $row->Active,
            'performance_management' => $this->performance_management,
        );
    
        echo json_encode($data);
    }



    public function send_email_kpi()
    {
        
        $today = date('Y-m-d H:i:s');

        $SQL    = "SELECT iTypeForm,EmployeeID,cTitle FROM `tbl_kpi_header_form` WHERE KPIID='".$this->input->post('KPIID')."'";
        $query  = $this->db->query($SQL);
        $data   = $query->row(0);

      
        $this->mailer_kpi_model->mailer_to_superiors($this->input->post('KPIID'), $this->cms_user_id(), $data->iTypeForm, $data->EmployeeID, $data->cTitle);

        echo json_encode(array("status" => TRUE));
    }

    public function send_email_kpi_monitor()
    {
        
        $today = date('Y-m-d H:i:s');

        $SQL    = "SELECT iTypeForm,EmployeeID,cTitle FROM `tbl_kpi_header_form` WHERE KPIID='".$this->input->post('KPIID')."'";
        $query  = $this->db->query($SQL);
        $data   = $query->row(0);

      
        $this->mailer_kpi_model->mailer_to_superiors($this->input->post('KPIID'), $this->cms_user_id(), $data->iTypeForm, $data->EmployeeID, $data->cTitle);

        echo json_encode(array("status" => TRUE));
    }


    public function ajax_save_form_monitor_global()
    {
        $primary_key = $this->input->post('KPIID');
        $type        = $this->input->post('ItemID');
        $today       = date('Y-m-d H:i:s');

        if($type == 1){
            $SQL    = "select a.activity_id,a.ItemID,a.Description,a.Nilai_Skala_Atasan,a.MonRemarksAtasan from tbl_kpi_activity_plan AS a where a.KPIID=".$primary_key." and (a.ItemID=1 OR a.ItemID=2 OR a.ItemID=3) order by a.ItemID,a.activity_id asc";
            $query  = $this->db->query($SQL);
        }
        else{
            $SQL    = "select a.activity_id,a.ItemID,a.Description,a.Nilai_Skala_Atasan,a.MonRemarksAtasan from tbl_kpi_activity_plan AS a where a.KPIID=".$primary_key." and a.ItemID=".$type." order by a.ItemID,a.activity_id asc";
            $query  = $this->db->query($SQL);
        }

        foreach($query->result() as $row){

            $Nilai_Skala_Atasan = $this->input->post('Nilai_Skala_Atasan_'.$row->activity_id);
            $MonRemarksAtasan   = $this->input->post('MonRemarksAtasan_'.$row->activity_id);

            $this->db->update('tbl_kpi_activity_plan',
                array('Nilai_Skala_Atasan' => $Nilai_Skala_Atasan, 'MonRemarksAtasan'=> $MonRemarksAtasan),
                array('KPIID'=> $primary_key,'ItemID'=> $row->ItemID, 'activity_id'=> $row->activity_id));
        }


        if($this->input->post('email_notif_global') == 1){

            $SQL2    = "SELECT iTypeForm,EmployeeID,cTitle FROM `tbl_kpi_header_form` WHERE KPIID='".$primary_key."'";
            $query2  = $this->db->query($SQL2);
            $data    = $query2->row(0);

            /* Kirim email ke karyawan */ 
            $this->mailer_kpi_model->kirim_email_setelah_penilaian_atasan($primary_key, $this->cms_user_id(), $data->iTypeForm, $data->EmployeeID, $data->cTitle, $data->EmployeeID);
        } 


        if($this->input->post('email_notif_global_tome') == 1){

            $SQL2    = "SELECT iTypeForm,EmployeeID,cTitle FROM `tbl_kpi_header_form` WHERE KPIID='".$primary_key."'";
            $query2  = $this->db->query($SQL2);
            $data    = $query2->row(0);

            /* Kirim email ke saya juga */
            $this->mailer_kpi_model->kirim_email_setelah_penilaian_atasan($primary_key, $this->cms_user_id(), $data->iTypeForm, $data->EmployeeID, $data->cTitle, $this->cms_user_id());
        }

        




            /* Kirim email ke Dompak */
            $SQL21    = "SELECT iTypeForm, EmployeeID,cTitle FROM `tbl_kpi_header_form` WHERE KPIID='".$primary_key."'";
            $query21  = $this->db->query($SQL21);
            $data21   = $query21->row(0);

            /* Kirim email ke dompak juga */
            $this->mailer_kpi_model->kirim_email_setelah_penilaian_atasan($primary_key, $this->cms_user_id(), $data21->iTypeForm, $data21->EmployeeID, $data21->cTitle, 4833);      


        echo json_encode(
            array(
            "status" => TRUE,
            'send_email_status'=> $this->input->post('email_notif_global'),
            'send_email_tome_status'=> $this->input->post('email_notif_global_tome')
            )
        );
    }




    public function _callback_field_atasan_user_2($value, $primary_key){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="iAtasanNIK2" id="iAtasanNIK2" class="chosen-select" data-placeholder="Pilih Atasan Tdk Langsung" style="width: 350px;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('iAtasanNIK')
                     ->from('tbl_kpi_header_form')
                     ->where('KPIID', $listingID);
            $db = $this->db->get();
            $data = $db->row(0);
            
            //GET THE STATES PER COUNTRY ID

            $SQL    = "select b.NIK as NIK,b.Nama AS Nama from tbl_apv_group_approval as a inner join tbl_profile as b on a.NIK=b.NIK 
                        where a.deptID=".$this->user_department_id." group by a.NIK
                        union 
                        select d.superiors_nik AS NIK,d.superiors_name AS Nama from tbl_apv_group_bawahan as c inner join tbl_apv_group_superiors as d on c.superiors_id=d.superiors_id where c.NIK=".$this->cms_user_id()." and d.superiors_nik !=".$this->cms_user_id()." group by d.superiors_nik";
            $query  = $this->db->query($SQL);

            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($query->result() as $row){
                if($row->NIK == $data->iAtasanNIK){
                    $empty_select .= '<option value="'.$row->NIK.'" selected="selected">'.$row->NIK.' '.$row->Nama.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->NIK.' '.$row->Nama.'</option>';
                }
            }
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {

            $SQL    = "select b.NIK as NIK,b.Nama AS Nama from tbl_apv_group_approval as a inner join tbl_profile as b on a.NIK=b.NIK 
                        where a.deptID=".$this->user_department_id." group by a.NIK
                        union 
                        select d.superiors_nik AS NIK,d.superiors_name AS Nama from tbl_apv_group_bawahan as c inner join tbl_apv_group_superiors as d on c.superiors_id=d.superiors_id where c.NIK=".$this->cms_user_id()." and d.superiors_nik !=".$this->cms_user_id()." group by d.superiors_nik";
            $query  = $this->db->query($SQL);
            /*
            $this->db->select('tbl_profile.NIK AS NIK,Nama')
                     ->from('tbl_apv_group_approval')
                     ->join('tbl_profile', 'tbl_apv_group_approval.NIK=tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID', $this->user_department_id)
                     ->group_by('tbl_apv_group_approval.NIK')
                     ->order_by('iGroupApprovalListId','ASC');
            $db = $this->db->get();
            */
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($query->result() as $row){               
                $empty_select .= '<option value="'.$row->NIK.'">'.$row->NIK.' '.$row->Nama.'</option>';                
            }

            return $empty_select.$empty_select_closed;  
        }
    }
    



}