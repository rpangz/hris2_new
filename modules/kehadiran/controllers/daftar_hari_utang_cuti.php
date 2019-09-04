<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class daftar_hari_utang_cuti extends CMS_Priv_Strict_Controller {

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

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');            
        }
        else {
            $crud->set_theme('no-flexigrid');
        }


        // table name
        $crud->set_table('tbl_formcuti_list_utang');
        $crud->order_by('Tanggal','ASC');

        // primary key
        $crud->set_primary_key('UtangId');

        // set subject
        $crud->set_subject('Daftar Hutang Cuti');

        // displayed columns on list
        $crud->columns('Keterangan','Tanggal','Status');
        // displayed columns on edit operation
        $crud->edit_fields('Keterangan','Tanggal','Status','UpdatedBy');
        // displayed columns on add operation
        $crud->add_fields('Keterangan','Tanggal','Status','CreatedBy','CreatedTime','UpdatedBy');


        // caption of each columns
        $crud->display_as('Keterangan','Keterangan');
        $crud->display_as('Tanggal','Tanggal');
        $crud->display_as('Status','Status');      

        
        $crud->required_fields('Keterangan','Tanggal','Status');
        //$crud->unique_fields('Tanggal');

        $crud->unset_add_fields('CreatedBy','CreatedTime','UpdatedBy');
        $crud->field_type('CreatedBy', 'hidden', $this->cms_user_id());
        $crud->field_type('CreatedTime', 'hidden', date('Y-m-d H:i:s'));
        $crud->field_type('UpdatedBy', 'hidden', $this->cms_user_id());

        
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));


        $crud->callback_column('Keterangan',array($this,'_callback_column_Keterangan'));



        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/daftar_hari_utang_cuti_view', $output,
            $this->cms_complete_navigation_name('daftar_hari_utang_cuti'));
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

    public function _callback_column_Keterangan($value, $row){    
    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->UtangId)."'>".$value."</a>";
        
    }



}