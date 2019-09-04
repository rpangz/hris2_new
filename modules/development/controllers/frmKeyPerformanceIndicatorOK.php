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
        $crud->set_lang_string('alert_delete','Apakah anda yakin menghapus record ini? Data tidak bisa di kembalikan lagi.');

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');
        }
        else {
           
            $crud->set_theme('no-flexigrid-kpi');

        }       

        $crud->add_action('Add', base_url().'assets/grocery_crud/themes/flexigrid/css/images/add.png', base_url().'assets/grocery_crud/themes/flexigrid/css/images/add.png',base_url().'assets/grocery_crud/themes/flexigrid/css/images/add.png',array($this,'modal_dialog_detail'));


        // table name
        $crud->set_table($this->cms_complete_table_name('kpi_result'));

        // primary key
        $crud->set_primary_key('kpi_result_id');

        // set subject
        $crud->set_subject('Key Performance Indicators (KPI)');

        // displayed columns on list
        $crud->columns('kpi_result_periode','kpi_result_nik','kpi_result_performance','kpi_result_attitude','kpi_result_time','total_nilai','result');
        // displayed columns on edit operation
        $crud->edit_fields('kpi_result_performance');
        // displayed columns on add operation
        $crud->add_fields('country_id');

        //$crud->unset_add_fields('country_id');
        $crud->unset_fields('country_id');
        $crud->unset_add_fields('country_id');
        $crud->field_type('country_id', 'hidden', 0);

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put Tabs (if needed)
        // usage:
        //     $crud->set_tabs(array(
        //        'First Tab Caption'  => $how_many_field_on_first_tab,
        //        'Second Tab Caption' => $how_many_field_on_second_tab,
        //     ));
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        // caption of each columns
        $crud->display_as('kpi_result_nik','Nama');
        $crud->display_as('kpi_result_performance','Kinerja');
        $crud->display_as('kpi_result_attitude','Sikap');
        $crud->display_as('kpi_result_time','Waktu');
        $crud->display_as('kpi_result_periode','Periode');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put required field validation codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/required_fields)
        // eg:
        //      $crud->required_fields( $field1, $field2, $field3, ... );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud->required_fields('name');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put required field validation codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/unique_fields)
        // eg:
        //      $crud->unique_fields( $field1, $field2, $field3, ... );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud->unique_fields('name');

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
        
        //$crud->set_relation('kpi_result_nik', $this->cms_complete_table_name('profile'), 'Nama');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put set relation_n_n (detail many to many) codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/set_relation_n_n)
        // eg:
        //      $crud->set_relation_n_n( $field_name, $relation_table, $selection_table, $primary_key_alias_to_this_table,
        //          $primary_key_alias_to_selection_table , $title_field_selection_table, $priority_field_relation );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
/*
        $crud->set_relation_n_n('tourism',
            $this->cms_complete_table_name('twn_city_tourism'),
            $this->cms_complete_table_name('twn_tourism'),
            'city_id', 'tourism_id',
            'name',NULL);
        
        $crud->set_relation_n_n('commodity',
            $this->cms_complete_table_name('twn_city_commodity'),
            $this->cms_complete_table_name('twn_commodity'),
            'city_id', 'commodity_id',
            'name', 'priority');
*/
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put custom field type here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/field_type)
        // eg:
        //      $crud->field_type( $field_name , $field_type, $value  );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        //$crud->set_rules('citizen', 'citizen', 'callback_test_check');

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

        $crud->callback_column('total_nilai',array($this, '_callback_column_total_nilai'));
        $crud->callback_column('result',array($this, '_callback_column_result'));
        $crud->callback_column('kpi_result_nik',array($this, '_callback_column_kpi_result_nik'));

        
        $crud->callback_column('kpi_result_performance',array($this, '_callback_column_citizen'));
        $crud->callback_field('kpi_result_performance',array($this, '_callback_field_citizen'));

        //$crud->set_rules('birthdate','birthdate','xss_clean|required');

//        $crud->set_rules('birthdate','birthdate','callback_nombre_check');

        //$crud->set_rules('tourism', 'tourism', '_callback_rules_tourism');
        //$crud->set_rules('tourism','tourism','required'); 
        //$crud->set_rules('tourism','_callback_field_tourism');
        //$crud->set_rules('tourism', 'tourism', 'required[tourism.tourism_id]');
        //$crud->set_rules('tourism', 'Salt Code','callback_check_salt');

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
        $state = $crud->getState();
        $my_profile = $this->_callback_my_profile();
        $output = $crud->render();
        $data = array(
            'session_nik' => $this->cms_user_id(),
            'session_company' => $my_profile['company'],
            'session_dept' => $my_profile['dept'],
            'state' => $state,
            'module_path' => $this->cms_module_path(),
            'action' => $this->input->get('act'),
            'field_kpi' => $this->_callback_field_citizen($value=NULL, $primary_key=NULL),
            'periode' => $this->input->get('periode'),
            'previous' => $this->input->get('previous'),

        );

        $output   = array_merge((array)$output, $data);

        //$output = $crud->render();
        $this->view($this->cms_module_path().'/frmKeyPerformanceIndicator_view', $output,$this->cms_complete_navigation_name('frmKeyPerformanceIndicator'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('kpi_result'),array('kpi_result_id'=>$id));
                    $this->_after_delete($id);
                }
            }
        }
    }   


    public function _before_insert($post_array){
        $post_array = $this->_before_insert_or_update($post_array);

        $data = json_decode($this->input->post('md_real_field_citizen_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        //$real_column_names = array('citizen_id', 'name', 'birthdate', 'job_id');
        $set_column_names = array();
        //$many_to_many_column_names = array('hobby');
        //$many_to_many_relation_tables = array('citizen_hobby');
        //$many_to_many_relation_table_columns = array('citizen_id');
        //$many_to_many_relation_selection_columns = array('hobby_id');


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  INSERTED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($insert_records as $insert_record){
            //$this->form_validation->set_rules( 'birthdate', 'birthdate', 'required' );
            //$this->crud->set_rules("name","name","required");
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



       
        //return $post_array;   
        if (count($detail_primary_key) ==0){
            //$error = $this->form_validation->set_message('country_id', 'country_id',' No Data');
            echo '<script language="javascript">alert("Error!!! Citizen Tidak Boleh Kosong...");</script>';
            return false;
            //return $error;


        }else{
            return $post_array;   
        }
       


        
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
        //$this->db->delete($this->cms_complete_table_name('citizen'),array('city_id'=>$primary_key));

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
        $real_column_names = array('citizen_id', 'name', 'birthdate', 'job_id');
        $set_column_names = array();
        $many_to_many_column_names = array('hobby');
        $many_to_many_relation_tables = array('citizen_hobby');
        $many_to_many_relation_table_columns = array('citizen_id');
        $many_to_many_relation_selection_columns = array('hobby_id');
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
            //$this->form_validation->set_rules( 'birthdate', 'birthdate', 'required' );
            //$this->crud->set_rules("name","name","required");
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
        $query = $this->db->select('*')
            ->from('tbl_kpi_performance')
            ->where('performance_nik', $this->cms_user_id())
            ->where('performance_periode', $primary_key)
            ->get();
        $result = $query->result_array();
        
        $options = array();
        
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
        );
        return $this->load->view($this->cms_module_path().'/field_detail_performance',$data, TRUE);
    }

    // returned on view
    public function _callback_column_citizen($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('citizen_id, name, birthdate, job_id')
            ->from($this->cms_complete_table_name('twn_citizen'))
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

    public function _callback_column_total_nilai($value, $row){

        $this->db->select('*')
             ->from($this->cms_complete_table_name('kpi_result'))
             ->where('kpi_result_id', $row->kpi_result_id);

            $db = $this->db->get();
            $row = $db->row(0);
            $val1 = $row->kpi_result_performance;
            $val2 = $row->kpi_result_attitude;
            $val3 = $row->kpi_result_time;
            
            $total = $val1+$val2+$val3;

            return number_format($total,2);


    }

    public function _callback_column_result($value, $row){

        $grand_total = $this->_callback_column_total_nilai($value, $row);

        if ($grand_total >=8.00){
            $status = '<span class="label label-success" style="font-size:14px;"><strong> Baik </strong></span>';
        }
        else if($grand_total < 8.00 && $grand_total >=5.00){
            $status = '<span class="label label-info" style="font-size:14px;"><strong> Cukup </strong></span>';            
        }
        else if($grand_total <=4){
            $status = '<span class="label label-warning" style="font-size:14px;"><strong> Kurang </strong></span>';          
        }
        else{
           $status = '-'; 
        }

        return $status;
    }


    // add hyperlink
    public function _callback_column_kpi_result_nik($value, $row){

        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('profile'))     
            ->where('NIK', $row->kpi_result_nik)
            ->get(); 

    
        foreach ($query->result() as $rown){
            return '<a href="'.site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->kpi_result_periode.'/?act=edit&periode='.$row->kpi_result_periode).'">'.$rown->Nama.'</a>';
        }
    
        
    }

    public function modal_dialog_detail($primary_key , $row){

        if (1 !=4){

            //return site_url($this->uri->segment('1').'/'.$this->uri->segment('2').'/index/?ref=detail&id='.$primary_key);
            //return '/index?ref=detail&id='.$primary_key;
            return site_url($this->uri->segment('1').'/'.$this->uri->segment('2').'/index/add/?previous='.$row->kpi_result_periode);
        }
        else{
            return '#';
        }

    }



}