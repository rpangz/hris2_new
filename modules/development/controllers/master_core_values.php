<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class master_core_values extends CMS_Priv_Strict_Controller {

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
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        //$crud->unset_export();
        $crud->unset_texteditor('tCoreValues');

        
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table('tbl_kpi_core_values');
        $crud->order_by('iCoreValues','ASC');
        //$crud->where('EmployeeID', $this->cms_user_id());

        // primary key
        $crud->set_primary_key('iCoreValues');

        // set subject
        $crud->set_subject('Core Values');

        // displayed columns on list
        $crud->columns('iCoreValues','tCoreValues','narration_value');
        // displayed columns on edit operation
        $crud->edit_fields('tCoreValues','narration_value');
        // displayed columns on add operation
        $crud->add_fields('tCoreValues','narration_value');


        // caption of each columns
        $crud->display_as('iCoreValues','ID');
        $crud->display_as('tCoreValues','Activity Plan');
        $crud->display_as('PlanManPeople','Plan');
        $crud->display_as('BobotManPeople','Bobot (%)');  

       
        $crud->required_fields('tCoreValues','narration_value');      
        

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
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/master_core_values_view', $output,
            $this->cms_complete_navigation_name('master_core_values'));
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