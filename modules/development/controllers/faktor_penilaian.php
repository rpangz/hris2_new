<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class faktor_penilaian extends CMS_Priv_Strict_Controller {

    protected $URL_MAP = array();

    public function __construct(){
        parent::__construct();
        $this->load->model($this->cms_module_path().'/development_model');        
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
        $crud->set_theme('no-flexigrid');

        // unset things
        $crud->unset_jquery();
        $crud->unset_read();
        //$crud->unset_add();
        // $crud->unset_edit();
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        //$crud->unset_export();
        $crud->unset_texteditor('cDescription');

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
        $crud->set_table('tbl_kpi_faktor_penilaian');
        $crud->order_by('iFPActivityID,iFPItem,iFPGradeID','ASC');
        //$crud->where('EmployeeID', $this->cms_user_id());

        // primary key
        $crud->set_primary_key('iFPID');

        // set subject
        $crud->set_subject('Faktor Penilaian');

        // displayed columns on list
        $crud->columns('iFPActivityID','iFPItem','iFPGradeID','cFPValue');
        // displayed columns on edit operation
        $crud->edit_fields('iFPActivityID','iFPItem','iFPGradeID','cFPValue');
        // displayed columns on add operation
        $crud->add_fields('iFPActivityID','iFPItem','iFPGradeID','cFPValue');

        $crud->field_type('iFPActivityID','dropdown', array(1 => 'KEY PERFORMANCE INDICATORS (KPI)', 2 => 'PROCESS & CORE VALUES', 3=>'MANAGING PEOPLE'));
        $crud->field_type('iFPItem','dropdown', array(1 => 'Struktural', 2 => 'Fungsional'));

        $crud->field_type('iFPGradeID','dropdown', array(0 =>'Band 0',1=>'Band 1',2=>'Band 2',3=>'Band 3',4=>'Band 4',5=>'Band 5',6=>'Band 6',7=>'Band 7',8=>'Band 8'));

        $crud->set_rules('cFPValue','Value','integer');

        /*
        $crud->set_relation('EmployeeID', 'tbl_profile', 'Nama');
        $crud->set_relation('iAtasanNIK', 'tbl_profile', 'Nama');
        $crud->set_relation('iTypeForm', 'tbl_kpi_type_form', 'cName');
        $crud->set_relation('CompanyID', 'tbl_company', 'cCompanyName');
        $crud->set_relation('DivisionID', 'tbl_div', 'cDivName');
        $crud->set_relation('DepartmentID', 'tbl_dept', 'cDeptName');
        */

        //$crud->field_type('iAgree', 'true_false', array('Tidak', 'Ya'));
        //$crud->field_type('Active', 'true_false', array('Close', 'Open'));

        // caption of each columns
        $crud->display_as('iFPActivityID','Activity Plan');
        $crud->display_as('iFPItem','Type');
        $crud->display_as('iFPGradeID','Band');
        $crud->display_as('cFPValue','Value (%)');
        
        /*
        $crud->change_field_type('PeriodID', 'readonly');
        $crud->change_field_type('cTitle', 'readonly');
        $crud->change_field_type('EmployeeID', 'readonly');
        $crud->change_field_type('CompanyID', 'readonly');
        $crud->change_field_type('DepartmentID', 'readonly');
        $crud->change_field_type('iTypeForm', 'readonly');
        $crud->change_field_type('iAtasanNIK', 'readonly');
        //$crud->change_field_type('iAgree', 'readonly');
        $crud->change_field_type('CreatedTime', 'readonly');
        */

       
        $crud->required_fields('iFPActivityID','iFPItem','iFPGradeID','cFPValue');

       
        

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put callback here
        // (documentation: httm://www.grocerycrud.com/documentation/options_functions)
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));


        //$crud->callback_before_insert(array($this,'encrypt_password_callback'));

        $crud->callback_column('monitoring',array($this, '_callback_column_monitoring'));
        $crud->callback_field('monitoring',array($this, '_callback_field_monitoring'));

        

        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/faktor_penilaian_view', $output,
            $this->cms_complete_navigation_name('faktor_penilaian'));
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
        $this->db->delete($this->cms_complete_table_name('citizen'),
              array('city_id'=>$primary_key));
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


}