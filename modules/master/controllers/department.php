<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Master_Department
 *
 * @author No-CMS Module Generator
 */
class Department extends CMS_Priv_Strict_Controller {

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
        $crud->unset_texteditor('tDeptRemarks');
        // $crud->unset_add();
        // $crud->unset_edit();
        // $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');
            //$crud->unset_edit();
        }

        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_city_model');
        */

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->cms_complete_table_name('dept'));

        $list = $this->uri->segment(4);

        if ($this->uri->segment(4) !=0 && !is_null($this->uri->segment(4)) && isset($list)){
            $crud->where('companyID', $this->uri->segment(4));
        }       
        else {
            $crud->where('companyID >=', 0);          
        }
        $crud->ORDER_BY('companyID','ASC');
        $crud->ORDER_BY('iDeptDivID','ASC');
        

        // primary key
        $crud->set_primary_key('iDeptID');

        // set subject
        $crud->set_subject('Departement');

        // displayed columns on list
        $crud->columns('iDeptID','cDeptName','iDeptDivID','company','CC_No','CC_Name','bDeptStatus');
        // displayed columns on edit operation
        $crud->edit_fields('companyID','iDeptDivID','cDeptName','CC_No','CC_Name','bDeptStatus');
        // displayed columns on add operation
        $crud->add_fields('companyID','iDeptDivID','cDeptName','CC_No','CC_Name','bDeptStatus');
        

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put Tabs (if needed)
        // usage:
        //     $crud->set_tabs(array(
        //        'First Tab Caption'  => $how_many_field_on_first_tab,
        //        'Second Tab Caption' => $how_many_field_on_second_tab,
        //     ));
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        // caption of each columns
        $crud->display_as('iDeptDivID','Division');
        $crud->display_as('companyID','Company');
        $crud->display_as('cDeptCode','Code');
        $crud->display_as('cDeptName','Departement Name');
        $crud->display_as('tDeptRemarks','Remarks');
        $crud->display_as('bDeptStatus','Status');
        $crud->display_as('iDeptID','Dept ID');
        $crud->display_as('CC_No','Cost Ctr No');
        $crud->display_as('CC_Name','Cost Ctr Name');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put required field validation codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/required_fields)
        // eg:
        //      $crud->required_fields( $field1, $field2, $field3, ... );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //$crud->required_fields('iDeptDivID','cDeptCode','cDeptName','tDeptRemarks','bDeptStatus','CC_No','CC_Name');
        $crud->required_fields('iDeptDivID','cDeptCode','cDeptName','tDeptRemarks','bDeptStatus');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put required field validation codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/unique_fields)
        // eg:
        //      $crud->unique_fields( $field1, $field2, $field3, ... );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        //$crud->unique_fields('name');

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
        $crud->set_relation('iDeptDivID', $this->cms_complete_table_name('div'), 'cDivName');
        $crud->set_relation('companyID', $this->cms_complete_table_name('company'), 'cCompanyName');

        //$crud->set_relation('iDeptDivID', $this->cms_complete_table_name('company'), 'cCompanyCode');

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

        $crud->callback_column('company',array($this, '_callback_column_company'));
        $crud->callback_column('cDeptName',array($this,'_callback_edit_url'));

        $crud->callback_add_field('iDeptDivID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_edit_field('iDeptDivID', array($this, 'empty_state_dropdown_select'));
        //$crud->callback_add_field('deptID', array($this, 'empty_city_dropdown_select'));
        //$crud->callback_edit_field('deptID', array($this, 'empty_city_dropdown_select'));


        //$crud->callback_field('citizen',array($this, '_callback_field_citizen'));

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

    public function _example_output($output = null)
    {
        $data = array(
            'state' => $this->_callback_state_action(),
        );

        $output   = array_merge((array)$output, $data);

        //$this->view($this->cms_module_path().'modules/customers', $output);
        $this->view($this->cms_module_path().'/department_view', $output,
        $this->cms_complete_navigation_name('department'));    
    }


    public function index(){
        $crud = $this->make_crud();

        $dd_data = array(
                //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
                'dd_state' =>  $crud->getState(),
                //SETUP YOUR DROPDOWNS
                //Parent field item always listed first in array, in this case countryID
                //Child field items need to follow in order, e.g stateID then cityID
                'dd_dropdowns' => array('companyID','iDeptDivID'),
                //SETUP URL POST FOR EACH CHILD
                //List in order as per above
                'dd_url' => array('', site_url().'/master/department/get_states/', site_url().'/master/department/get_cities/'),
                //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
                'dd_ajax_loader' => base_url().'ajax-loader.gif'
            );

        


        $output = $crud->render();
        $output->dropdown_setup = $dd_data;
           
            
        $this->_example_output($output);
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('dept'),array('iDeptID'=>$id));
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
        // delete corresponding citizen
       
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
    public function _callback_column_company($value, $row)
    {
        //return $value." - scale: <b>".$row->date."</b>";
        
         $query = $this->db->select('cCompanyCode,cCompanyName')
            ->from($this->cms_complete_table_name('div'))
            ->join('tbl_company', 'tbl_div.iDivCompany = tbl_company.iCompanyId') 
            //->join($this->cms_complete_table_name('company'))
            ->where('iDivId', $row->iDeptDivID)
            ->get();
        $result = $query->result_array();
        
        
        // $query = $this->db->query('SELECT cCompanyCode FROM tbl_company WHERE iCompanyId='. $row->);
       // $options = array();
        //$options['cCompanyCode'] = array();

        foreach ($query->result() as $row){
        return $row->cCompanyName;
        
        }

        //return  $result;
        
    }

    // add hyperlink
    public function _callback_edit_url($value, $row){    
    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->iDeptID)."'>$value</a>";
        
    }


    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="iDeptDivID" class="chosen-select" data-placeholder="Select Division" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('companyID, iDeptDivID')
                     ->from('tbl_dept')
                     ->where('iDeptID', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $companyID = $row->companyID;
            $iDeptDivID = $row->iDeptDivID;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('tbl_div')
                     ->where('iDivId', $iDeptDivID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iDivId == $iDeptDivID) {
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

    public function empty_city_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="deptID" class="chosen-select" data-placeholder="Select Departement" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('iDeptDivID, companyID')
                     ->from('tbl_dept')
                     ->where('iDeptID', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $iDeptDivID = $row->iDeptDivID;
            $iDeptID = $row->iDeptID;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_dept')
                     ->where('iDeptDivID', $iDeptDivID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iDeptID == $iDeptID) {
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
                
    //GET JSON OF STATES
    public function get_states()
    {
        $companyID = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_div')
                 ->where('iDivCompany', $companyID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iDivId, "property" => $row->cDivName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }
    
    //GET JSON OF CITIES
    public function get_cities()
    {
        $divisionID = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_dept')
                 ->where('iDeptDivID', $iDeptDivID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iDeptID, "property" => $row->cDeptName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }

    public function _callback_state_action(){
        $crud = $this->new_crud();
        $state = $crud->getState();
        return $state;    
    }
    

    

}