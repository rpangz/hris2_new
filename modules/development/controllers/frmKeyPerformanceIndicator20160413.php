<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class frmKeyPerformanceIndicator extends CMS_Priv_Strict_Controller {

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
        //$crud->set_theme('flexigrid');
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
		//$crud->unset_texteditor('description');
		
        // $crud->unset_add();
        // $crud->unset_edit();
        // $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');
             
        }
        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_country_model');
        */

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->cms_complete_table_name('agama'));

        // primary key
        $crud->set_primary_key('agama_id');

        // set subject
        $crud->set_subject('Agama');

        // displayed columns on list
		$crud->columns('agama_name');
		
		
        // displayed columns on edit operation
       
		$crud->edit_fields('agama_name');

		
        // displayed columns on add operation
		
		$crud->add_fields('agama_name');
		


        // caption of each columns		
				
        $crud->display_as('agama_name','Name');
        //$crud->display_as('company_name','Name');
        //$crud->display_as('description','Description');
        
				
		
		// $crud->required_fields( $field1, $field2, $field3, ... );
		$crud->required_fields('agama_name');
       
		
		//$crud->unique_fields( $field1, $field2, $field3, ... );
		$crud->unique_fields('agama_name');
       		
        $crud->callback_column('agama_name',array($this, '_callback_column_agama_name'));
		//$crud->set_relation('authorization_id', $this->cms_complete_table_name('main_authorization'), 'authorization_name');
      	
			
		$crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $crud->callback_column('Files',array($this, '_callback_field_citizen'));
        $crud->callback_field('Files',array($this, '_callback_field_citizen'));

        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        $state = $crud->getState();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $my_profile = $this->_callback_my_profile();
        $output = $crud->render();
        $data = array(
            'session_nik' => $this->cms_user_id(),
            'session_company' => $my_profile['company'],
            'session_dept' => $my_profile['dept'],
            'state' => $state,
            'action' => $this->input->get('act'),
            'module_path' => $this->cms_module_path(),
            'field_kpi' => $this->_callback_field_citizen($value=NULL, $primary_key=NULL),

        );

        $output   = array_merge((array)$output, $data);
        $this->view($this->cms_module_path().'/frmKeyPerformanceIndicator_view', $output, $this->cms_complete_navigation_name('frmKeyPerformanceIndicator'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('agama'),array('agama_id'=>$id));
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

    // add hyperlink
    public function _callback_column_agama_name($value, $row){    
    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->agama_id)."'>$value</a>";
        
    }

    public function _callback_my_profile(){        
        $result = mysql_query("SELECT CompanyId AS CompanyId, DeptID AS DeptID, Sex AS Sex, StatusDiri AS StatusDiri, tbl_company.bStatus AS bStatus 
            FROM tbl_profile INNER JOIN tbl_company ON tbl_profile.CompanyId=tbl_company.iCompanyId 
            WHERE NIK=".$this->cms_user_id());
        $storeArray = Array();
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $storeArray['company'] =  $row['CompanyId'];
            $storeArray['dept'] =  $row['DeptID'];
            $storeArray['sex'] =  $row['Sex'];
            $storeArray['status_diri'] =  $row['StatusDiri'];
            $storeArray['company_status'] =  $row['bStatus'];
            
        }
        return $storeArray;     
    }

    // returned on insert and edit
    public function _callback_field_citizen($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');        

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from('tbl_profile')
            ->where('NIK', $primary_key)
            ->get();
        $result = $query->result_array();

        //$result = array();

        // get options
        $options = array();
       
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $module_path,
        );
        return $this->load->view('development/field_kpi_performance',$data, TRUE);
    }



}