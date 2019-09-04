<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Installation script for
 *
 * @author No-CMS Module Generator
 */
class frmHits extends CMS_Priv_Strict_Controller {

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
        //$crud->unset_texteditor('description');
        
         $crud->unset_add();
         $crud->unset_edit();
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            //$crud->set_theme('flexigrid');
            //$crud->unset_edit();
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
        $crud->set_table($this->cms_complete_table_name('hits'));
        $crud->order_by('hits_date','DESC');

        // primary key
        $crud->set_primary_key('hits_id');

        // set subject
        $crud->set_subject('Hits');

        // displayed columns on list
        $crud->columns('hits_date','ip_address','computer_name');

        
        
        // displayed columns on edit operation
       
        $crud->edit_fields('interval_name','interval_code');

        
        // displayed columns on add operation
        
        $crud->add_fields('interval_name','interval_code');
        


        // caption of each columns      
                
        $crud->display_as('hits_date','Datetime');
        $crud->display_as('ip_address','IP Address');
        $crud->display_as('computer_name','Computer Name');
        
                
        
        // $crud->required_fields( $field1, $field2, $field3, ... );
        $crud->required_fields('interval_name','interval_code');
       
        
        //$crud->unique_fields( $field1, $field2, $field3, ... );
        $crud->unique_fields('interval_name');
            

        //$crud->set_relation('authorization_id', $this->cms_complete_table_name('main_authorization'), 'authorization_name');
        
            
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $crud->callback_column('hits_date',array($this,'_callback_column_hits_date'));
        //$crud->callback_column('Number',array($this,'_callback_column_Number'));

        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/frmHits_view', $output,
            $this->cms_complete_navigation_name('frmHits'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('hits'),array('hits_id'=>$id));
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


    public function _callback_column_hits_date($value, $row){
        //$session_id = $this->cms_user_name();
        //return $value." - scale: <b>".$row->date."</b>";
        $Date2 = date('d-M-Y H:i:s, l', strtotime($row->hits_date));
        return $Date2;
        
    }

    public function _callback_column_Number($value, $row){        
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('hits'))     
            //->where('NIK', $NIK)
            ->get();
            $num_row = $query->num_rows();

         $sql = mysql_query("SELECT * FROM tbl_hits");

        $no=1;
        //for($i=1; $i<=$num_row; $i++) {
        //while ($no < $num_row) {
        while ($data = mysql_fetch_array($sql)){  
        //foreach ($query->result() as $rown){
            //return $data['hits_id'];
            return $no++;
            //print $no++;
        }           
        
    }



}