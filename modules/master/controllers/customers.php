<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Manage_Job
 *
 * @author No-CMS Module Generator
 */
class Customers extends CMS_Priv_Strict_Controller {

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
        // $crud->unset_print();
        // $crud->unset_export();

        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_job_model');
        */

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->cms_complete_table_name('customers'));

        // primary key
        $crud->set_primary_key('customerNumber');

        // set subject
        $crud->set_subject('Customer');

        // displayed columns on list
        $crud->columns('customerName','contactLastName','contactFirstName');
        // displayed columns on edit operation
        $crud->edit_fields('customerName','contactLastName','contactFirstName');
        // displayed columns on add operation
        $crud->add_fields('customerName','contactLastName','contactFirstName');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put Tabs (if needed)
        // usage:
        //     $crud->set_tabs(array(
        //        'First Tab Caption'  => $how_many_field_on_first_tab,
        //        'Second Tab Caption' => $how_many_field_on_second_tab,
        //     ));
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        // caption of each columns
        $crud->display_as('customerName','Name');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put required field validation codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/required_fields)
        // eg:
        //      $crud->required_fields( $field1, $field2, $field3, ... );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud->required_fields('customerName');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put required field validation codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/unique_fields)
        // eg:
        //      $crud->unique_fields( $field1, $field2, $field3, ... );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud->unique_fields('customerName');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put field validation codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/set_rules)
        // eg:
        //      $crud->set_rules( $field_name , $caption, $filter );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put set relation (lookup) codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/set_relation)
        // eg:
        //      $crud->set_relation( $field_name , $related_table, $related_title_field , $where , $order_by );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put set relation_n_n (detail many to many) codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/set_relation_n_n)
        // eg:
        //      $crud->set_relation_n_n( $field_name, $relation_table, $selection_table, $primary_key_alias_to_this_table,
        //          $primary_key_alias_to_selection_table , $title_field_selection_table, $priority_field_relation );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put custom field type here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/field_type)
        // eg:
        //      $crud->field_type( $field_name , $field_type, $value  );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////




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



        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put custom error message here
        // (documentation: httm://www.grocerycrud.com/documentation/set_lang_string)
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // $crud->set_lang_string('delete_error_message', 'Cannot delete the record');
        // $crud->set_lang_string('update_error',         'Cannot edit the record'  );
        // $crud->set_lang_string('insert_error',         'Cannot add the record'   );

        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/Customers_view', $output,
            $this->cms_complete_navigation_name('customers'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('customers'),array('customerNumber'=>$id));
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


    function customers_management()
    {
            //GROCERY CRUD SETUP
            $crud = new grocery_CRUD();

            $crud->set_table('customers');
            $crud->columns('customerName','contactLastName','phone','countryID','stateID','cityID');
            $crud->display_as('salesRepEmployeeNumber','From Employeer')
                 ->display_as('customerName','Name')
                 ->display_as('cityID','City/Town')
                 ->display_as('stateID','State/Province')
                 ->display_as('countryID','Country')
                 ->display_as('contactLastName','Last Name');
            $crud->set_subject('Customer');
            $crud->set_relation('salesRepEmployeeNumber','employees','{lastName} {firstName}');
            $crud->set_relation('countryID','country','country_title');
            $crud->set_relation('stateID','state','state_title');
            $crud->set_relation('cityID','city','city_title');
            $crud->fields('customerName','contactLastName','phone','countryID','stateID','cityID');
            $crud->required_fields('countryID','stateID','cityID');     
            
            //IF YOU HAVE A LARGE AMOUNT OF DATA, ENABLE THE CALLBACKS BELOW - FOR EXAMPLE ONE USER HAD 36000 CITIES AND SLOWERD UP THE LOADING PROCESS. THESE CALLBACKS WILL LOAD EMPTY SELECT FIELDS THEN POPULATE THEM AFTERWARDS
            $crud->callback_add_field('stateID', array($this, 'empty_state_dropdown_select'));
            $crud->callback_edit_field('stateID', array($this, 'empty_state_dropdown_select'));
            $crud->callback_add_field('cityID', array($this, 'empty_city_dropdown_select'));
            $crud->callback_edit_field('cityID', array($this, 'empty_city_dropdown_select'));
                        
            $output = $crud->render();
            
            //DEPENDENT DROPDOWN SETUP
            $dd_data = array(
                //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
                'dd_state' =>  $crud->getState(),
                //SETUP YOUR DROPDOWNS
                //Parent field item always listed first in array, in this case countryID
                //Child field items need to follow in order, e.g stateID then cityID
                'dd_dropdowns' => array('countryID','stateID','cityID'),
                //SETUP URL POST FOR EACH CHILD
                //List in order as per above
                'dd_url' => array('', site_url().'/examples/get_states/', site_url().'/examples/get_cities/'),
                //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
                'dd_ajax_loader' => base_url().'ajax-loader.gif'
            );
            $output->dropdown_setup = $dd_data;
            
            $this->_example_output($output);
    }   
    
    //CALLBACK FUNCTIONS
    function empty_state_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="stateID" class="chosen-select" data-placeholder="Select State/Province" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(4);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('countryID, stateID')
                     ->from('customers')
                     ->where('customerNumber', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $countryID = $row->countryID;
            $stateID = $row->stateID;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('state')
                     ->where('countryID', $countryID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->state_id == $stateID) {
                    $empty_select .= '<option value="'.$row->state_id.'" selected="selected">'.$row->state_title.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->state_id.'">'.$row->state_title.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }
    
    function empty_city_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="cityID" class="chosen-select" data-placeholder="Select City/Town" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(4);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('stateID, cityID')
                     ->from('customers')
                     ->where('customerNumber', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $stateID = $row->stateID;
            $cityID = $row->cityID;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('city')
                     ->where('stateID', $stateID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->city_id == $cityID) {
                    $empty_select .= '<option value="'.$row->city_id.'" selected="selected">'.$row->city_title.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->city_id.'">'.$row->city_title.'</option>';
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
    function get_states()
    {
        $countryID = $this->uri->segment(3);
        
        $this->db->select("*")
                 ->from('state')
                 ->where('countryID', $countryID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->state_id, "property" => $row->state_title);
        endforeach;
        
        echo json_encode($array);
        exit;
    }
    
    //GET JSON OF CITIES
    function get_cities()
    {
        $stateID = $this->uri->segment(3);
        
        $this->db->select("*")
                 ->from('city')
                 ->where('stateID', $stateID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->city_id, "property" => $row->city_title);
        endforeach;
        
        echo json_encode($array);
        exit;
    }



}