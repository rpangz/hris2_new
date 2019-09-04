<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class reminder extends CMS_Priv_Strict_Controller {

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
        $session_nik = $this->cms_user_id();
        $_SESSION['NIK'] = $session_nik;
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
        //$crud->unset_texteditor('scheduler_detail');
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

        $crud->add_action('Run', 'http://'.$_SERVER['SERVER_NAME'].'/hris2/images/run13.png', ' ',' http://'.$_SERVER['SERVER_NAME'].'/hris2/images/run13.png',array($this,'_callback_column_Run'));

        
        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');
            $crud->set_relation('scheduler_publisher', $this->cms_complete_table_name('main_user'), 'user_name');
            $crud->set_relation_n_n('receiver',
            $this->cms_complete_table_name('scheduler_receiver'),
            $this->cms_complete_table_name('profile'),
            'scheduler_id', 'NIK',
            '{Nama}');           
           
        }
        else{
            //$crud->set_theme('flexigrid');           

            $crud->set_relation_n_n('receiver',
            $this->cms_complete_table_name('scheduler_receiver'),
            $this->cms_complete_table_name('profile'),
            'scheduler_id', 'NIK',
            '{Nama} [{Email}]');

        }


        // table name
        $crud->set_table($this->cms_complete_table_name('scheduler'));

        
        $crud->where('scheduler_publisher', $session_nik);
        
        // primary key
        $crud->set_primary_key('scheduler_id');
        
             

        // set subject
        $crud->set_subject('Scheduler');

        //

        // displayed columns on list
        $crud->columns('scheduler_subject','scheduler_detail','scheduler_publisher','scheduler_start','scheduler_status','scheduler_konten','receiver');

        $crud->unset_add_fields('scheduler_publisher','scheduler_updateby','scheduler_token');
        $crud->field_type('scheduler_publisher', 'hidden', $session_nik);
        $crud->field_type('scheduler_updateby', 'hidden', $session_nik);
        $crud->field_type('scheduler_token', 'hidden', $this->_token_string());

      

        // displayed columns on edit operation
        $crud->edit_fields('scheduler_type','scheduler_item','scheduler_subject','scheduler_detail','scheduler_updateby','scheduler_start','scheduler_status','scheduler_konten','scheduler_begin','scheduler_repeat','receiver');
        // displayed columns on add operation
        $crud->add_fields('scheduler_type','scheduler_item','scheduler_subject','scheduler_detail','scheduler_publisher','scheduler_updateby','scheduler_start','scheduler_status','scheduler_konten','scheduler_begin','scheduler_repeat','receiver','scheduler_token');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put Tabs (if needed)
        // usage:
        //     $crud->set_tabs(array(
        //        'First Tab Caption'  => $how_many_field_on_first_tab,
        //        'Second Tab Caption' => $how_many_field_on_second_tab,
        //     ));
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        // caption of each columns
        $crud->display_as('scheduler_subject','Subject');
        $crud->display_as('scheduler_detail','Detail/Content');
        $crud->display_as('scheduler_publisher','Publisher');
        $crud->display_as('receiver','Receiver');
        $crud->display_as('scheduler_start','Start');
        $crud->display_as('scheduler_status','Status');
        $crud->display_as('scheduler_konten','Content');
        $crud->display_as('scheduler_begin','Scheduler Begin Before @Start');
        $crud->display_as('scheduler_repeat','Scheduler Repeat After');
       

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put required field validation codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/required_fields)
        // eg:
        //      $crud->required_fields( $field1, $field2, $field3, ... );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud->required_fields('scheduler_type','scheduler_item','scheduler_subject','scheduler_start','scheduler_status','scheduler_begin','scheduler_repeat','scheduler_konten');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put required field validation codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/unique_fields)
        // eg:
        //      $crud->unique_fields( $field1, $field2, $field3, ... );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud->unique_fields('scheduler_subject');

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
        
        $crud->set_relation('scheduler_begin', $this->cms_complete_table_name('interval'), 'interval_name',null,'interval_id ASC');
        $crud->set_relation('scheduler_repeat', $this->cms_complete_table_name('interval'), 'interval_name',null,'interval_id ASC');
       //  $crud->order_by('symbol','desc');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put set relation_n_n (detail many to many) codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/set_relation_n_n)
        // eg:
        //      $crud->set_relation_n_n( $field_name, $relation_table, $selection_table, $primary_key_alias_to_this_table,
        //          $primary_key_alias_to_selection_table , $title_field_selection_table, $priority_field_relation );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        /*
        $crud->set_relation_n_n('receiver',
            $this->cms_complete_table_name('scheduler_receiver'),
            $this->cms_complete_table_name('receiver'),
            'scheduler_id', 'NIK',
            '{Name} [{Email}]');
        */
        
        
            
    
        /*
        $crud->set_relation_n_n('receiver',
            $this->cms_complete_table_name('scheduler_receiver'),
            $this->cms_complete_table_name('profile'),
            'scheduler_id', 'NIK',
            '{Nama} [{Email}]', 'id');
        */

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

        $crud->callback_column('scheduler_subject',array($this, '_callback_column_scheduler_subject'));
        $crud->set_relation('scheduler_type', $this->cms_complete_table_name('scheduler_type'), 'SchedulerTypeName',null,'SchedulerTypeId ASC');
        $crud->set_relation('scheduler_item', $this->cms_complete_table_name('scheduler_item'), 'SchedulerItemName',null,'SchedulerItemId ASC');

        $crud->callback_add_field('scheduler_item', array($this, '_empty_state_dropdown_select'));
        $crud->callback_edit_field('scheduler_item', array($this, '_empty_state_dropdown_select'));

       // $crud->callback_column('citizen',array($this, '_callback_column_citizen'));
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

    public function _example_output($output = null){

        /*
        $data = array(
            'state' => $this->_callback_state_action(),
        );
        */

        //$output = array_merge((array)$output, $data);

        //$this->view($this->cms_module_path().'modules/customers', $output);
        $this->view($this->cms_module_path().'/reminder_index', $output,
        $this->cms_complete_navigation_name('index'));    
    }

    public function index(){
        $crud = $this->make_crud();
        $dd_data = array(
                'dd_state' =>  $crud->getState(),
                'dd_dropdowns' => array('scheduler_type','scheduler_item'),
                'dd_url' => array('', site_url().'/reminder/reminder/get_states/', site_url().'/reminder/reminder/get_cities/'),
                'dd_ajax_loader' => base_url().'ajax-loader.gif'
        );

        $output = $crud->render();
        $output->dropdown_setup = $dd_data;            
        $this->_example_output($output);
    }


    public function index_test(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/reminder_index', $output,
            $this->cms_complete_navigation_name('index'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('scheduler'),array('scheduler_id'=>$id));

                   
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
        $this->db->delete($this->cms_complete_table_name('scheduler_receiver'),
              array('scheduler_id'=>$primary_key));
        return TRUE;
    }

    public function _after_delete($primary_key){
        return TRUE;
    }

    public function _after_insert_or_update($post_array, $primary_key){

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        // SAVE CHANGES OF citizen
        //  * The citizen data in in json format.
        //  * It can be accessed via $_POST['md_real_field_citizen_col']
        //
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data = json_decode($this->input->post('md_real_field_citizen_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('scheduler_id', 'NIK');
        $set_column_names = array();
        //$many_to_many_column_names = array('hobby');
        //$many_to_many_relation_tables = array('citizen_hobby');
        //$many_to_many_relation_table_columns = array('citizen_id');
        //$many_to_many_relation_selection_columns = array('hobby_id');
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  DELETED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $where = array(
                    $relation_column_name => $detail_primary_key
                );
                $this->db->delete($table_name, $where);
            }
            $this->db->delete($this->cms_complete_table_name('citizen'),
                 array('citizen_id'=>$detail_primary_key));
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  UPDATED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($update_records as $update_record){
            $detail_primary_key = $update_record['primary_key'];
            $data = array();
            foreach($update_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['city_id'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('citizen'),
                 $data, array('citizen_id'=>$detail_primary_key));
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Updated Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $update_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  INSERTED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($insert_records as $insert_record){
            $data = array();
            foreach($insert_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['city_id'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('citizen'), $data);
            $detail_primary_key = $this->db->insert_id();
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Inserted Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $insert_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }

        return TRUE;
    }

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }


    // returned on insert and edit
    public function _callback_field_citizen($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('citizen_id, name, birthdate, job_id')
            ->from($this->cms_complete_table_name('citizen'))
            ->where('city_id', $primary_key)
            ->get();
        $result = $query->result_array();
        // add "hobby" to $result
        for($i=0; $i<count($result); $i++){
            $query_detail = $this->db->select('hobby_id')
               ->from($this->cms_complete_table_name('citizen_hobby'))
               ->where(array('citizen_id'=>$result[$i]['citizen_id']))->get();
            $value = array();
            foreach($query_detail->result() as $row){
                $value[] = $row->hobby_id;
            }
            $result[$i]['hobby'] = $value;
        }

        // get options
        $options = array();
        $options['job_id'] = array();
        $query = $this->db->select('job_id,name')
           ->from($this->cms_complete_table_name('job'))
           ->get();
        foreach($query->result() as $row){
            $options['job_id'][] = array('value' => $row->job_id, 'caption' => $row->name);
        }
        
        $options['hobby'] = array();
        $query = $this->db->select('hobby_id,name')
           ->from($this->cms_complete_table_name('hobby'))->get();
        foreach($query->result() as $row){
            $options['hobby'][] = array('value' => $row->hobby_id, 'caption' => strip_tags($row->name));
        }
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
        );
        return $this->load->view($this->cms_module_path().'/field_city_citizen',$data, TRUE);
    }

    // returned on view
    public function _callback_column_citizen($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('citizen_id, name, birthdate, job_id')
            ->from($this->cms_complete_table_name('citizen'))
            ->where('city_id', $row->city_id)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' Citizens';
        }else if($num_row>0){
            return $num_row .' Citizen';
        }else{
            return 'No Citizen';
        }
    }

    // add hyperlink
    public function _callback_column_scheduler_subject($value, $row){    
    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->scheduler_id)."'>$value</a>";
        
    }

    // add hyperlink
    public function _callback_column_Run($primary_key, $row){

        $query  = mysql_query("SELECT * FROM tbl_scheduled_task WHERE id='$primary_key'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        $url ='http://'.$_SERVER['SERVER_NAME'].'/hris2/scheduled_task/ReminderNotif/';
        /*
        if ($row->scheduler_status==0){
            echo '<script language="javascript">alert("Error!!! Status Must Be Activeted...");</script>';
            return false;
        }
        */
        

        return "javascript:window.open('".$url.'?id='.$primary_key.'&nik='.$_SESSION['NIK'].'&token='.$row->scheduler_token. "');void(0)";
            

    }

    public function _token_string(){
        $alphaNumeric   = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $random         = substr(str_shuffle($alphaNumeric), 0, 7);        
        $token          = md5($random);
        return $token;
    }

    //CALLBACK FUNCTIONS
    public function _empty_state_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="scheduler_item" class="chosen-select" data-placeholder="Select Item" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('*')
                     ->from($this->cms_complete_table_name('scheduler'))
                     ->where('scheduler_id', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $scheduler_type = $row->scheduler_type;
            $scheduler_item = $row->scheduler_item;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from($this->cms_complete_table_name('scheduler_item'))
                     ->where('SchedulerTypeId', $scheduler_type);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->SchedulerItemId == $scheduler_item) {
                    $empty_select .= '<option value="'.$row->SchedulerItemId.'" selected="selected">'.$row->SchedulerItemName.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->SchedulerItemId.'">'.$row->SchedulerItemName.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }

    public function _empty_city_dropdown_select(){
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
        $SchedulerTypeId = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from($this->cms_complete_table_name('scheduler_item'))
                 ->where('SchedulerTypeId', $SchedulerTypeId);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->SchedulerItemId, "property" => $row->SchedulerItemName);
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

}
