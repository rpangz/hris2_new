<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Master_Company
 *
 * @author No-CMS Module Generator
 */
class frmPeriode extends CMS_Priv_Strict_Controller {

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
        $crud->unset_read();
        //$crud->unset_texteditor('tRentalRemarks');

        // $crud->unset_add();
        // $crud->unset_edit();
        // $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();
        $session_id = $this->cms_user_id();
        $today = date('Y-m-d H:i:s');

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
        $crud->set_table($this->cms_complete_table_name('periode'));

        // primary key
        $crud->set_primary_key('iPeriodId');

        // set subject
        $crud->set_subject('Periode');

        // displayed columns on list
		$crud->columns('cPeriodName','dPeriodStartDate','dPeriodEndDate','bPeriodStatus');
		
		
        // displayed columns on edit operation
       
		$crud->edit_fields('cPeriodName','dPeriodStartDate','dPeriodEndDate','bPeriodStatus');

		
        // displayed columns on add operation
		
		$crud->add_fields('cPeriodName','dPeriodStartDate','dPeriodEndDate','bPeriodStatus');
		


        // caption of each columns		
				
        $crud->display_as('cPeriodName','Name');
        $crud->display_as('dPeriodStartDate','Start Date');
        $crud->display_as('dPeriodEndDate','End Date');
        $crud->display_as('bPeriodStatus','Status');
        //$crud->display_as('tRentalRemarks','Description');
        
				
		
		// $crud->required_fields( $field1, $field2, $field3, ... );
		$crud->required_fields('cPeriodName','dPeriodStartDate','dPeriodEndDate');
       
		
		//$crud->unique_fields( $field1, $field2, $field3, ... );
		
        $crud->unique_fields('cPeriodName');
       		

		//$crud->set_relation('iRentalType', $this->cms_complete_table_name('type'), 'cTypeName');
      	
			
		$crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $crud->callback_column('dPeriodStartDate',array($this,'_Date1_call'));
        $crud->callback_column('dPeriodEndDate',array($this,'_Date2_call'));
        $crud->callback_column('cPeriodName',array($this,'_callback_edit_url'));

        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/frmPeriode_view', $output,
            $this->cms_complete_navigation_name('frmPeriode'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('periode'),array('iPeriodId'=>$id));
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


    // change dPeriodEndDate format to d-M-Y
    public function _Date1_call($value, $row)
    {
        //return $value." - scale: <b>".$row->date."</b>";
        $Date1 = date('d-M-Y', strtotime($row->dPeriodStartDate));
        return $Date1;
        
    }
    
    // change dPeriodEndDate format to d-M-Y
    public function _Date2_call($value, $row)
    {
        //return $value." - scale: <b>".$row->date."</b>";
        $Date2 = date('d-M-Y', strtotime($row->dPeriodEndDate));
        return $Date2;
        
    }

    // add hyperlink
    public function _callback_edit_url($value, $row){    
    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->iPeriodId)."'>$value</a>";
        
    }



}