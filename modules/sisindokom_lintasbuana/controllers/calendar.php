<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class calendar extends CMS_Priv_Strict_Controller {

    protected $URL_MAP = array();

    public function cms_complete_table_name($table_name){
        $this->load->helper($this->cms_module_path().'/function');
        if(function_exists('cms_complete_table_name')){
            return cms_complete_table_name($table_name);
        }else{
            return parent::cms_complete_table_name($table_name);
        }
    }

    private function make_crud(){
      
        $crud = $this->new_crud();
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

        $crud->unset_jquery();
        $crud->unset_read();
      
        $crud->unset_print();        
        
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        //$crud->unset_list();
        $crud->unset_back_to_list();


        $crud->set_language($this->cms_language());

        $crud->set_table($this->cms_complete_table_name('agama'));

        $crud->set_primary_key('agama_id');

        $crud->set_subject('Agama');

        $crud->columns('agama_name');
       
        $crud->edit_fields('agama_name');

        $crud->add_fields('agama_name');
        
        $crud->display_as('agama_name','Name');
        
        $crud->required_fields('agama_name');
       
        $crud->unique_fields('agama_name');           
      

        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        $output = $crud->render();
        $this->view($this->cms_module_path().'/calendar_view', $output,
            $this->cms_complete_navigation_name('calendar'));
    }

   



}