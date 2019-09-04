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
        $session_nik        = $this->cms_user_id();
        $hrd_modules = $this->cms_get_config('hrd_profile_modules');
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

        $my_profile = $this->_callback_my_profile();

        $crud->set_language($this->cms_language());
        $crud->set_lang_string('delete_error_message','Error!!! Data tidak bisa dihapus karena sudah expired, silahkan hubungi administrator...');
        $crud->set_lang_string('update_error','Error!!! Data tidak bisa diperbaharui karena sudah expired, silahkan hubungi administrator...');


        if ($this->check_allow_delete_periode($primary_key) == 0){
            $crud->set_lang_string('alert_delete','Apakah anda yakin menghapus record ini? Data tidak bisa di kembalikan lagi.');
        }
        else{
            $crud->set_lang_string('alert_delete','Error!!! Data tidak bisa dihapus karena sudah expired....');
        }        
        
        //$crud->set_lang_string('alert_delete','Apakah anda yakin menghapus record ini? Data tidak bisa di kembalikan lagi.');
        //$crud->add_action('Delete', base_url().'assets/grocery_crud/themes/flexigrid/css/images/close.png', base_url().'assets/grocery_crud/themes/flexigrid/css/images/close.png',base_url().'assets/grocery_crud/themes/flexigrid/css/images/close.png',array($this,'check_allow_delete_periode'));

        $crud->add_action('Add', base_url().'assets/grocery_crud/themes/flexigrid/css/images/add.png', base_url().'assets/grocery_crud/themes/flexigrid/css/images/add.png',base_url().'assets/grocery_crud/themes/flexigrid/css/images/add.png',array($this,'modal_dialog_detail'));


        if ($this->check_allow_add_periode()==0){
            $crud->unset_add();
        }


        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('no-flexigrid-kpi');
            $crud->set_relation('companyID', $this->cms_complete_table_name('company'), '{cCompanyCode}');
        }
        else {           
            $crud->set_theme('no-flexigrid-kpi');
        }       
        // table name
        $crud->set_table($this->cms_complete_table_name('kpi_result'));

        $crud->where('kpi_result_nik',$this->cms_user_id());

        // primary key
        $crud->set_primary_key('kpi_result_id');

        // set subject
        $crud->set_subject('Key Performance Indicators (KPI)');

        // displayed columns on list
        $crud->columns('kpi_result_nik','kpi_result_periode','kpi_result_performance','kpi_result_attitude','kpi_result_time','total_nilai','result');
        // displayed columns on edit operation
        //$crud->edit_fields('country_id','name','tourism','commodity','citizen');
        $crud->edit_fields('kpi_result_performance','NIK1','NIK2','NIK3');
        // displayed columns on add operation
        $crud->add_fields('kpi_result_performance','NIK1','NIK2','NIK3','companyID');

        $crud->unset_add_fields('kpi_result_performance','companyID');
        $crud->field_type('companyID','hidden',$my_profile['company']);


        $crud->unset_edit_fields('kpi_result_performance');
        $crud->field_type('kpi_result_performance','hidden',NULL);
        $crud->field_type('companyID','hidden',$my_profile['company']);
        

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
        $crud->display_as('NIK1','Atasan Langsung');
        $crud->display_as('NIK2','Atasan Lebih Tinggi');
        $crud->display_as('NIK3','HRD');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put required field validation codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/required_fields)
        // eg:
        //      $crud->required_fields( $field1, $field2, $field3, ... );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        $crud->required_fields('NIK1','NIK2','NIK3');

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
        
        ///$crud->set_relation('country_id', $this->cms_complete_table_name('twn_country'), 'name');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put set relation_n_n (detail many to many) codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/set_relation_n_n)
        // eg:
        //      $crud->set_relation_n_n( $field_name, $relation_table, $selection_table, $primary_key_alias_to_this_table,
        //          $primary_key_alias_to_selection_table , $title_field_selection_table, $priority_field_relation );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        //$crud->set_relation('NIK1', $this->cms_complete_table_name('apv_group_approval'), '{hrd_name} [{hrd_email}]',array('hrd_status' =>1,'hrd_company' => $my_profile['company'], 'hrd_modules' => $hrd_modules));

        //$crud->set_relation('NIK1', $this->cms_complete_table_name('profile'), '{Nama} [{Email}]',array('bStatus' =>1));
        //$crud->set_relation('NIK2', $this->cms_complete_table_name('profile'), '{Nama} [{Email}]',array('bStatus' =>1));

        //$crud->set_relation('NIK3', $this->cms_complete_table_name('apv_hrd'), '{hrd_name} [{hrd_email}]',array('hrd_status' =>1,'hrd_company' => $my_profile['company'], 'hrd_modules' => $hrd_modules));

        


        $crud->callback_add_field('NIK1', array($this, 'empty_nik1_dropdown_select'));
        $crud->callback_edit_field('NIK1', array($this, 'empty_nik1_dropdown_select'));

        $crud->callback_add_field('NIK2', array($this, 'empty_nik2_dropdown_select'));
        $crud->callback_edit_field('NIK2', array($this, 'empty_nik2_dropdown_select'));


        $crud->callback_add_field('NIK3', array($this, 'empty_nik3_dropdown_select'));
        $crud->callback_edit_field('NIK3', array($this, 'empty_nik3_dropdown_select'));

       

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

        $crud->callback_column('total_nilai',array($this, '_callback_column_total_nilai'));
        $crud->callback_column('result',array($this, '_callback_column_result'));
        $crud->callback_column('kpi_result_nik',array($this, '_callback_column_kpi_result_nik'));

        //$crud->callback_add_field('NIK1', array($this, '_callback_add_field_NIK1'));



        //$crud->callback_before_insert(array($this,'encrypt_password_callback'));

        //$crud->callback_column('citizen',array($this, '_callback_column_citizen'));
        //$crud->callback_field('citizen',array($this, '_callback_field_citizen'));

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
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $listingID = $this->uri->segment(5);
        $state = $crud->getState();

        $data = array(
            'session_nik' => $this->cms_user_id(),
            'module_path' => $this->cms_module_path(),
            'action' => $this->get_action_form($state, $primary_key=$listingID, $previous=$this->input->get('prev')),
            'state' => $state,
            'field_kpi_performance' => $this->_callback_field_kpi_performance($value =NULL, $primary_key=$listingID),
            'field_kpi_attitude' => $this->_callback_field_kpi_attitude($value =NULL, $primary_key=$listingID),
            'field_kpi_time' => $this->_callback_field_kpi_time($value =NULL, $primary_key=$listingID),
            'previous' => $this->input->get('prev'),
            'session_nik' => $this->cms_user_id(),
            'periode' => $this->get_periode_id($primary_key=$listingID),
    

        );

        $output   = array_merge((array)$output, $data);
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

        return $post_array;
              
    } 


    public function _after_insert($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);

        $kpi_result_periode = $this->get_new_periode();
        $kpi_result_nik     = $this->cms_user_id();

        $this->db->update($this->cms_complete_table_name('kpi_result'),array('kpi_result_periode'=>$kpi_result_periode,'kpi_result_nik'=>$kpi_result_nik), array('kpi_result_id'=>$primary_key));

        //$this->db->insert($this->cms_complete_table_name('kpi_result'),array('kpi_result_periode'=>$kpi_result_periode,'kpi_result_nik'=>$kpi_result_nik));
        //$kpi_primary_key = $this->db->insert_id();

        $data = json_decode($this->input->post('md_real_field_performance_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('performance_id','performance_area','performance_target','performance_weight','performance_result','performance_value');
        $set_column_names = array();
        $many_to_many_column_names = array();
        $many_to_many_relation_tables = array();
        $many_to_many_relation_table_columns = array();
        $many_to_many_relation_selection_columns = array();

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  INSERTED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        

        foreach($update_records as $update_record){
            //$detail_primary_key = $update_record['primary_key'];
            $data = array();
            foreach($update_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['kpi_result_id'] = $primary_key;
            //$this->db->update($this->cms_complete_table_name('kpi_performance'), $data, array('performance_id'=>$detail_primary_key));

            $this->db->insert($this->cms_complete_table_name('kpi_performance'), $data);
            $detail_primary_key = $this->db->insert_id();

            $this->db->update($this->cms_complete_table_name('kpi_performance'), array('kpi_result_id'=>$primary_key), array('performance_id'=>$detail_primary_key));
            
            $radio_value = $post_array['performance_value_'.$update_record['record_index']];    
            $this->db->update($this->cms_complete_table_name('kpi_performance'),array('performance_value'=> $radio_value), array('performance_id'=>$detail_primary_key));

                        
        }


        foreach($insert_records as $insert_record){
            $data = array();
            foreach($insert_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['kpi_result_id'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('kpi_performance'), $data);
            $detail_primary_key = $this->db->insert_id();          

            $radio_value = $post_array['performance_value_'.$insert_record['record_index']];
            $performance_weight = 50;    
            
            $this->db->update($this->cms_complete_table_name('kpi_performance'),array('kpi_result_id'=>$primary_key,'performance_value'=>$radio_value,'performance_weight'=>$performance_weight), array('performance_id'=>$detail_primary_key));
            
        }

        $this->update_user_performance_result($primary_key);


       

        $data = json_decode($this->input->post('md_real_field_attitude_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('attitude_id','attitude_factor','attitude_definition','attitude_weight','attitude_value');
        $set_column_names = array();
        $many_to_many_column_names = array();
        $many_to_many_relation_tables = array();
        $many_to_many_relation_table_columns = array();
        $many_to_many_relation_selection_columns = array();

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  INSERTED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        

        foreach($update_records as $update_record){
            //$detail_primary_key = $update_record['primary_key'];
            $data = array();
            foreach($update_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['kpi_result_id'] = $primary_key;
            //$this->db->update($this->cms_complete_table_name('kpi_performance'), $data, array('performance_id'=>$detail_primary_key));

            $this->db->insert($this->cms_complete_table_name('kpi_attitude'), $data);
            $detail_primary_key = $this->db->insert_id();

            $this->db->update($this->cms_complete_table_name('kpi_attitude'), array('kpi_result_id'=>$primary_key), array('attitude_id'=>$detail_primary_key));
            
            $radio_value = $post_array['attitude_value_'.$update_record['record_index']];    
            $this->db->update($this->cms_complete_table_name('kpi_attitude'),array('attitude_value'=> $radio_value), array('attitude_id'=>$detail_primary_key));

                        
        }


        foreach($insert_records as $insert_record){
            $data = array();
            foreach($insert_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['kpi_result_id'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('kpi_attitude'), $data);
            $detail_primary_key = $this->db->insert_id();          

            $radio_value = $post_array['attitude_value_'.$insert_record['record_index']];
            $attitude_weight = 30;    
            
            $this->db->update($this->cms_complete_table_name('kpi_attitude'),array('kpi_result_id'=>$primary_key,'attitude_value'=>$radio_value,'attitude_weight'=>$attitude_weight), array('attitude_id'=>$detail_primary_key));
            
        }

        $this->update_user_attitude_result($primary_key);


        if (!empty($post_array['datang_terlambat'])){            
            $datang_terlambat = $post_array['datang_terlambat'];
        }
        else{
            $datang_terlambat = NULL;            
        }

        if (!empty($post_array['tanpa_surat_dokter'])){            
            $tanpa_surat_dokter = $post_array['tanpa_surat_dokter'];
        }
        else{
            $tanpa_surat_dokter = NULL;            
        }

        if (!empty($post_array['tidak_hadir'])){            
            $tidak_hadir = $post_array['tidak_hadir'];
        }
        else{
            $tidak_hadir = NULL;            
        }
        

        $this->db->insert($this->cms_complete_table_name('kpi_time'), array('kpi_result_id'=>$primary_key,'time_item'=>1,'time_result'=>$datang_terlambat));
        $this->db->insert($this->cms_complete_table_name('kpi_time'), array('kpi_result_id'=>$primary_key,'time_item'=>2,'time_result'=>$tanpa_surat_dokter));
        $this->db->insert($this->cms_complete_table_name('kpi_time'), array('kpi_result_id'=>$primary_key,'time_item'=>3,'time_result'=>$tidak_hadir));

               


        return $success;
    }

    public function _before_update($post_array, $primary_key){
        $post_array = $this->_before_insert_or_update($post_array, $primary_key);

        if ($this->check_allow_delete_periode($primary_key) == 0){
            return false;
        }
        else{
            return $post_array;
        }        

        
    }

    public function _after_update($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);        
        
        $data = json_decode($this->input->post('md_real_field_performance_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('performance_id','performance_area','performance_target','performance_weight','performance_result','performance_value');
        $set_column_names = array();
        $many_to_many_column_names = array();
        $many_to_many_relation_tables = array();
        $many_to_many_relation_table_columns = array();
        $many_to_many_relation_selection_columns = array();
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
            $this->db->delete($this->cms_complete_table_name('kpi_performance'), array('performance_id'=>$detail_primary_key));
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
            $data['kpi_result_id'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('kpi_performance'), $data, array('performance_id'=>$detail_primary_key));

            $radio_value = $post_array['performance_value_'.$update_record['record_index']];    
            $this->db->update($this->cms_complete_table_name('kpi_performance'),array('performance_value'=> $radio_value), array('performance_id'=>$detail_primary_key));

            

            
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
            $data['kpi_result_id'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('kpi_performance'), $data);
            $detail_primary_key = $this->db->insert_id();

            $radio_value = $post_array['performance_value_'.$insert_record['record_index']];
            $performance_weight = 50;    
            $this->db->update($this->cms_complete_table_name('kpi_performance'),array('performance_value'=>$radio_value,'performance_weight'=>$performance_weight), array('performance_id'=>$detail_primary_key));

            
            
        }

        $this->update_user_performance_result($primary_key);



        // form detail sikap

        $data = json_decode($this->input->post('md_real_field_attitude_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('attitude_id','attitude_factor','attitude_definition','attitude_weight','attitude_value');
        $set_column_names = array();
        $many_to_many_column_names = array();
        $many_to_many_relation_tables = array();
        $many_to_many_relation_table_columns = array();
        $many_to_many_relation_selection_columns = array();
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
            $this->db->delete($this->cms_complete_table_name('kpi_attitude'), array('attitude_id'=>$detail_primary_key));
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
            $data['kpi_result_id'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('kpi_attitude'), $data, array('attitude_id'=>$detail_primary_key));

            $radio_value = $post_array['attitude_value_'.$update_record['record_index']];    
            $this->db->update($this->cms_complete_table_name('kpi_attitude'),array('attitude_value'=> $radio_value), array('attitude_id'=>$detail_primary_key));
            
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
            $data['kpi_result_id'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('kpi_attitude'), $data);
            $detail_primary_key = $this->db->insert_id();

            $radio_value = $post_array['attitude_value_'.$insert_record['record_index']];
            $attitude_weight = 30;    
            $this->db->update($this->cms_complete_table_name('kpi_attitude'),array('attitude_value'=>$radio_value,'attitude_weight'=>$attitude_weight), array('attitude_id'=>$detail_primary_key));
            
            
        }

        $this->update_user_attitude_result($primary_key);
        $this->update_user_time_result($primary_key);

        //$this->db->update($this->cms_complete_table_name('kpi_time'),array('time_value'=>$radio_value,'attitude_weight'=>$attitude_weight), array('attitude_id'=>$detail_primary_key));

        return $success;
    }

    public function _before_delete($primary_key){

        //$crud = $this->new_crud();

        if ($this->check_allow_delete_periode($primary_key) == 0){
            //redirect('{{ base_url }}development/frmKeyPerformanceIndicator/index');
            //echo '<script language="javascript">alert("Error!!! Data tidak bisa dihapus karena sudah expired...");</script>';
            //echo "<textarea>".json_encode(array('success' => true , 'success_message' => 'This participant already exists'))."</textarea>";
            //$crud->set_echo_and_die();

            $this->form_validation->set_message('delete_error_message', 'Error!!! Data tidak bisa dihapus karena sudah expired, silahkan hubungi administrator...');

            // /$lang['delete_error_message']   = 'Your data was not deleted from the database.';

            //$crud->set_lang_string('delete_error_message','Error!!! Data tidak bisa dihapus karena sudah expired....');

            

            return false;

            echo '<script language="javascript">alert("Error!!! Data tidak bisa dihapus karena sudah expired...");</script>';
        }

        else{       
            $this->db->delete($this->cms_complete_table_name('kpi_performance'), array('kpi_result_id'=>$primary_key));
            $this->db->delete($this->cms_complete_table_name('kpi_attitude'), array('kpi_result_id'=>$primary_key));
            $this->db->delete($this->cms_complete_table_name('kpi_time'), array('kpi_result_id'=>$primary_key));
            $this->db->delete($this->cms_complete_table_name('kpi_evaluator'), array('kpi_result_id'=>$primary_key));
            $this->db->delete($this->cms_complete_table_name('kpi_incumbent'), array('kpi_result_id'=>$primary_key));
            $this->db->delete($this->cms_complete_table_name('kpi_review'), array('kpi_result_id'=>$primary_key));
            
            return TRUE;
        }



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


    // returned on insert and edit
    public function _callback_field_kpi_performance($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        $previous = $this->input->get('prev');

        if (empty($previous) AND is_null($previous)){
            $primary_key = $primary_key;
        }
        else{
            $primary_key = $previous;
        }

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('performance_id,performance_area,performance_target,performance_weight,performance_result,performance_value')
            ->from($this->cms_complete_table_name('kpi_performance'))
            ->join('tbl_kpi_result', 'tbl_kpi_result.kpi_result_id = tbl_kpi_performance.kpi_result_id')
            ->where('kpi_result_nik', $this->cms_user_id())
            ->where('tbl_kpi_performance.kpi_result_id', $primary_key)
            ->get();
        $result = $query->result_array();
        $num_row = $query->num_rows();

        if ($num_row >0){
            $val1 = $this->current_value_performace($session_nik = $this->cms_user_id(), $primary_key);
            $val2 = $this->kpi_weight($session_kpi=1);

            $current_value = ($val1 * $val2)/100;
            $current_value = ($current_value)/$num_row;
            $current_value = number_format($current_value,2);
        }
        else{
            $current_value = 0.00; 
        }

        
        $options = array();

        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'session_nik' => $this->cms_user_id(),
            'periode' => $this->get_periode_id($primary_key),
            'current_value_performance' => $current_value,
        );
        return $this->load->view($this->cms_module_path().'/field_detail_performance',$data, TRUE);
    }


    public function _callback_field_kpi_attitude($value, $primary_key){

        $crud = $this->make_crud();
        $state = $crud->getState();

        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');
        $my_profile = $this->_callback_my_profile();

        $previous = $my_profile['jabatan'];      
        
       
        if(!isset($primary_key)) $primary_key = -1;
        
        if ($state != 'add'){
        $query = $this->db->select('attitude_id,attitude_factor,attitude_definition,attitude_weight,attitude_value')
            ->from($this->cms_complete_table_name('kpi_attitude'))
            ->join('tbl_kpi_result', 'tbl_kpi_result.kpi_result_id = tbl_kpi_attitude.kpi_result_id')
            ->where('kpi_result_nik', $this->cms_user_id())
            ->where('tbl_kpi_attitude.kpi_result_id', $primary_key)
            //->where('attitude_periode', $this->get_periode_id($primary_key))
            ->get();
        }
        else{
            $query = $this->db->select('attitude_id,attitude_factor,attitude_definition,attitude_weight,attitude_value')
            ->from($this->cms_complete_table_name('kpi_attitude_master'))
            ->where('find_in_set ('.$previous.',attitude_jabatan)',NULL)
            ->where('attitude_status', 1)
            ->get();
        }


        $result = $query->result_array();
        $num_row = $query->num_rows();

        if ($num_row >0){
            $val1 = $this->current_value_attitude($session_nik=$this->cms_user_id(), $primary_key);
            $val2 = $this->kpi_weight($session_kpi=2);

            $current_value = ($val1 * $val2)/100;
            $current_value = ($current_value)/$num_row;
            $current_value = number_format($current_value,2);
        }
        else{
            $current_value = 0.00; 
        }
        // get options
        $options = array();
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'session_nik' => $this->cms_user_id(),
            'periode' => $this->get_periode_id($primary_key),
            'current_value_attitude' => $current_value,
            'max_data' => $num_row,
        );
        return $this->load->view($this->cms_module_path().'/field_detail_attitude',$data, TRUE);
    }


    public function _callback_field_kpi_time($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');      

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('kpi_performance'))
            ->where('performance_id', $primary_key)
            ->get();
        $result = $query->result_array();
        
        $options = array();
        
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'session_nik' => $this->cms_user_id(),
            'primary_key' => $primary_key,
            'periode' => $this->get_periode_id($primary_key),
        );
        return $this->load->view($this->cms_module_path().'/field_detail_time',$data, TRUE);
    }

    public function _callback_my_profile(){        
        $result = mysql_query("SELECT CompanyId AS CompanyId, DeptID AS DeptID, Sex AS Sex, StatusDiri AS StatusDiri, tbl_company.bStatus AS bStatus,JabatanID 
            FROM tbl_profile INNER JOIN tbl_company ON tbl_profile.CompanyId=tbl_company.iCompanyId 
            WHERE NIK=".$this->cms_user_id());
        $storeArray = Array();
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $storeArray['company'] =  $row['CompanyId'];
            $storeArray['dept'] =  $row['DeptID'];
            $storeArray['sex'] =  $row['Sex'];
            $storeArray['status_diri'] =  $row['StatusDiri'];
            $storeArray['company_status'] =  $row['bStatus'];
            $storeArray['jabatan'] = $row['JabatanID'];
            
        }
        return $storeArray;     
    }

    
    public function get_periode_id($primary_key){

        $session_nik = $this->cms_user_id();

        $query  = mysql_query("SELECT * FROM tbl_kpi_result WHERE kpi_result_id='".$primary_key."' AND kpi_result_nik='".$session_nik."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        if ($total >0){
            return $data['kpi_result_periode'];
        }
        else{
            return 0;
        }

        

    }


    public function current_value_performace($session_nik, $primary_key){
        
        $query  = mysql_query("SELECT sum(performance_value) AS total FROM tbl_kpi_performance WHERE kpi_result_id='".$primary_key."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);        

        if (is_null($data['total'])){
            return 0;
        }
        else{
            return $data['total'];
        }


    }

    public function current_value_attitude($session_nik, $primary_key){
        
        $query  = mysql_query("SELECT sum(attitude_value) AS total FROM tbl_kpi_attitude WHERE kpi_result_id='".$primary_key."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);        

        if (is_null($data['total'])){
            return 0;
        }
        else{
            return $data['total'];
        }


    }

    public function kpi_weight($session_kpi){

      $query  = mysql_query('SELECT * FROM tbl_kpi_type WHERE kpi_type_id='.$session_kpi);
      $total  = mysql_num_rows($query);
      $data   = mysql_fetch_array($query);

      return $data['kpi_type_weight'];   

    }

    public function modal_dialog_detail($primary_key , $row){

        if ($this->check_allow_add_periode()==0){
            return '#';
        }
        else{
            return site_url($this->uri->segment('1').'/'.$this->uri->segment('2').'/index/add/?prev='.$row->kpi_result_id);
        }

    }

    // add hyperlink
    public function _callback_column_kpi_result_nik($value, $row){

        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('profile'))     
            ->where('NIK', $row->kpi_result_nik)
            ->get(); 

    
        foreach ($query->result() as $rown){

            $query  = mysql_query("SELECT * FROM tbl_kpi_result WHERE kpi_result_id='".$row->kpi_result_id."' AND kpi_result_nik='".$this->cms_user_id()."'");
            $total  = mysql_num_rows($query);
            $data   = mysql_fetch_array($query);

            $today = date('Y');

            if($data['kpi_result_periode'] >= $today){
                $status = '<a href="'.site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->kpi_result_id).'">'.$rown->Nama.'</a>';            
            }
            else{
                $status = $rown->Nama;
            }

            return $status;
            //return '<a href="'.site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->kpi_result_id).'">'.$rown->Nama.'</a>';
        }
    
        
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
            $status = '<span class="label label-success" style="font-size:13px;"><strong>&nbsp;&nbsp; Baik&nbsp;&nbsp;</strong></span>';
        }
        else if($grand_total < 8.00 && $grand_total >=5.00){
            $status = '<span class="label label-info" style="font-size:13px;"><strong>&nbsp;Cukup&nbsp;</strong></span>';            
        }
        else if($grand_total <=4){
            $status = '<span class="label label-warning" style="font-size:13px;"><strong> Kurang </strong></span>';          
        }
        else{
           $status = '-'; 
        }

        return $status;
    }

    public function get_action_form($state, $primary_key, $previous){

        if ($state == 'add' && is_null($previous)){
            $action = 'insert';
        }
        elseif ($state == 'add' && !is_null($previous)){
            $action = 'insert/?prev='.$previous;
        }
        elseif($state == 'edit'){
            $action = 'update/'.$primary_key;
        }
        else{
            $action = '';
        }

        return $action;

    }

    public function get_new_periode(){

        $query  = mysql_query('SELECT max(kpi_result_periode) AS periode FROM tbl_kpi_result WHERE kpi_result_nik='.$this->cms_user_id());
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        $today = date('Y');

        if(!is_null($data['periode']) AND !empty($data['periode'])){
            $new_periode = $data['periode']+1;
        }
        else{
            $new_periode = $today;
        }

        return $new_periode;


    }


    public function check_allow_add_periode(){

        $query  = mysql_query('SELECT max(kpi_result_periode) AS periode FROM tbl_kpi_result WHERE kpi_result_nik='.$this->cms_user_id());
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        $today = date('Y');

        if($data['periode'] > $today){
            $status = 0;
        }
        else{
            $status = 1;
        }

        return $status;


    }


    public function check_allow_delete_periode($primary_key){

        $query  = mysql_query("SELECT * FROM tbl_kpi_result WHERE kpi_result_id='".$primary_key."' AND kpi_result_nik='".$this->cms_user_id()."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        $today = date('Y');

        /*$hari_ini   = date ("Y");
        $lalu       = strtotime($hari_ini);
        $today      = date ('Y',strtotime('+1 year',$lalu));*/

        


        if($data['kpi_result_periode'] >= $today){
            //$status = site_url($this->uri->segment('1').'/'.$this->uri->segment('2').'/index/delete/'.$primary_key);
            $status = 1;            
        }
        else{
            $status = 0;
        }

        return $status;


    }

    public function update_user_performance_result($primary_key){

        $this->db->select('sum(performance_value) AS total_value,count(performance_value) AS jumlah_data')
             ->from($this->cms_complete_table_name('kpi_performance'))
             ->where('kpi_result_id', $primary_key);

        $db = $this->db->get();
        $row = $db->row(0);
        $total_value = $row->total_value;
        $jumlah_data = $row->jumlah_data;


        $total = ($total_value / $jumlah_data)* $this->kpi_weight($session_kpi=1);
        $total = $total / 100;
        $total = number_format($total,2);

        $this->db->update($this->cms_complete_table_name('kpi_result'),array('kpi_result_performance'=>$total), array('kpi_result_id'=>$primary_key));

    }

    public function update_user_attitude_result($primary_key){

        $this->db->select('sum(attitude_value) AS total_value,count(attitude_value) AS jumlah_data')
             ->from($this->cms_complete_table_name('kpi_attitude'))
             ->where('kpi_result_id', $primary_key);

        $db = $this->db->get();
        $row = $db->row(0);
        $total_value = $row->total_value;
        $jumlah_data = $row->jumlah_data;


        $total = ($total_value / $jumlah_data)* $this->kpi_weight($session_kpi=2);
        $total = $total / 100;
        $total = number_format($total,2);

        $this->db->update($this->cms_complete_table_name('kpi_result'),array('kpi_result_attitude'=>$total), array('kpi_result_id'=>$primary_key));

    }


    public function update_user_time_result($primary_key){

        $value_1 = $this->nilai_datang_terlambat($primary_key);
        $this->db->update($this->cms_complete_table_name('kpi_time'),array('time_value'=>$value_1), array('kpi_result_id'=>$primary_key,'time_item'=>1));

        $value_2 = $this->nilai_sakit_tanpa_surat_dokter($primary_key);
        $this->db->update($this->cms_complete_table_name('kpi_time'),array('time_value'=>$value_2), array('kpi_result_id'=>$primary_key,'time_item'=>2));

        $value_3 = $this->nilai_tidak_hadir_tanpa_alasan($primary_key);
        $this->db->update($this->cms_complete_table_name('kpi_time'),array('time_value'=>$value_3), array('kpi_result_id'=>$primary_key,'time_item'=>3));



        $this->db->select('sum(time_value) AS total_value,count(time_value) AS jumlah_data')
             ->from($this->cms_complete_table_name('kpi_time'))
             ->where('kpi_result_id', $primary_key);

        $db = $this->db->get();
        $row = $db->row(0);
        $total_value = $row->total_value;
        $jumlah_data = $row->jumlah_data;


        $total = ($total_value / $jumlah_data)* $this->kpi_weight($session_kpi=3);
        $total = $total / 100;
        $total = number_format($total,2);

        $this->db->update($this->cms_complete_table_name('kpi_result'),array('kpi_result_time'=>$total), array('kpi_result_id'=>$primary_key));

    }


    public function jumlah_datang_terlambat($primary_key){
      
      $query  = mysql_query("SELECT * FROM `tbl_kpi_time` WHERE kpi_result_id='".$primary_key."' AND time_item='1'");
      $data   = mysql_fetch_array($query);
      $total  = mysql_num_rows($query);

      if ($total > 0){
        return $data['time_result'];
      }else{
        return '';
      }

    }


    public function jumlah_sakit_tanpa_surat_dokter($primary_key){

      $query  = mysql_query("SELECT * FROM `tbl_kpi_time` WHERE kpi_result_id='".$primary_key."' AND time_item='2'");
      $data   = mysql_fetch_array($query);
      $total  = mysql_num_rows($query);

      if ($total > 0){
        return $data['time_result'];
      }else{
        return '';
      }

    }


    public function jumlah_tidak_hadir_tanpa_alasan($primary_key){

      $query  = mysql_query("SELECT * FROM `tbl_kpi_time` WHERE kpi_result_id='".$primary_key."' AND time_item='3'");
      $data   = mysql_fetch_array($query);
      $total  = mysql_num_rows($query);

      if ($total > 0){
        return $data['time_result'];
      }else{
        return '';
      }

    }




    public function nilai_datang_terlambat($primary_key){

      $value = $this->jumlah_datang_terlambat($primary_key);

      if (!is_null($value)){

        if($value < 260){
            $nilai = 10;
        }
        elseif($value >= 261 && $value <= 530){
            $nilai = 9;
        }
        elseif($value >= 531 && $value <= 791){
            $nilai = 8;
        }
        elseif($value >= 792 && $value <= 1050){
            $nilai = 7;
        }
        elseif($value >= 1051 && $value <= 1320){
            $nilai = 6;
        }
        elseif($value >= 1321 && $value <= 1580){
            $nilai = 5;
        }
        elseif($value >= 1581 && $value <= 1840){
            $nilai = 4;
        }
        elseif($value >= 1841 && $value <= 2110){
            $nilai = 3;
        }
        elseif($value >= 2111 && $value <= 2370){
            $nilai = 2;
        }
        elseif($value >2371){
            $nilai = 1;
        }
        else{
            $nilai = 0;
        }

      }

      else{
        $nilai = '';
      }

      return $nilai;


    }


    public function nilai_sakit_tanpa_surat_dokter($primary_key){
      
      $value = $this->jumlah_sakit_tanpa_surat_dokter($primary_key);

      if (!is_null($value)){

        if($value ==0){
            $nilai = 10;
        }
        elseif($value == 1){
            $nilai = 9;
        }
        elseif($value == 2){
            $nilai = 8;
        }
        elseif($value == 3){
            $nilai = 7;
        }
        elseif($value == 4){
            $nilai = 6;
        }
        elseif($value == 5){
            $nilai = 5;
        }
        elseif($value == 6){
            $nilai = 4;
        }
        elseif($value == 7){
            $nilai = 3;
        }
        elseif($value == 8){
            $nilai = 2;
        }
        elseif($value > 9){
            $nilai = 1;
        }
        else{
            $nilai = 0;
        }

      }
      else{
        $nilai = '';
      }

      return $nilai;


    }


    public function nilai_tidak_hadir_tanpa_alasan($primary_key){
      
      $value = $this->jumlah_tidak_hadir_tanpa_alasan($primary_key);

      if (!is_null($value)){

        if($value ==0){
            $nilai = 9;
        }
        elseif($value == 1){
            $nilai = 8;
        }
        elseif($value == 2){
            $nilai = 7;
        }
        elseif($value == 3){
            $nilai = 6;
        }
        elseif($value == 4){
            $nilai = 5;
        }
        elseif($value == 5){
            $nilai = 4;
        }
        elseif($value == 6){
            $nilai = 3;
        }
        elseif($value == 7){
            $nilai = 2;
        }
        elseif($value > 8){
            $nilai = 1;
        }
        else{
            $nilai = 0;
        }
      }
      else{
        $nilai = '';
      }

      return $nilai;


    }


    public function _callback_add_field_NIK1(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK1" class="chosen-select" data-placeholder="Select Atasan Langsung" style="width: 500px; display: none;">';
        $empty_select_closed= '</select>';
    
        $crud = new grocery_CRUD();
        $state = $crud->getState();

        $session_nik = $this->cms_user_id();
        
        $my_profile = $this->_callback_my_profile();
      

            $this->db->select('tbl_profile.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_profile.Email AS Email')
                     ->from($this->cms_complete_table_name('apv_group_approval'))
                     ->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID',$my_profile['dept'])
                     ->where('form_cuti', 1)
                     ->order_by('iGroupApprovalListId','ASC');

            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select Atasan Langsung</option>';

            foreach($db->result() as $row):               
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.' ['.$row->Email.']</option>';
                
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;
    }


    public function empty_nik1_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK1" class="selectpicker" data-width="500px" data-style="btn-default" data-placeholder="Select Atasan Langsung" style="width: 500px !important;display: none;">';
        $empty_select .= '<option value="0" selected="selected" disabled>Select Atasan Langsung</option>';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();

        $my_profile = $this->_callback_my_profile();
        
        if(isset($listingID) && $state == "edit") {
            $this->db->select('*')
                     ->from('tbl_kpi_result')
                     ->where('kpi_result_id', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);            
            $NIK1 = $row->NIK1;

            //GET THE CITIES PER STATE ID
            $this->db->select('tbl_apv_group_approval.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_profile.Email AS Email')
                     ->from('tbl_apv_group_approval')
                     ->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID', $my_profile['dept'])
                     ->order_by('iGroupApprovalListId', 'ASC');
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->NIK == $NIK1) {
                    $empty_select .= '<option value="'.$row->NIK.'" selected="selected">'.$row->Nama.' ['.$row->Email.']</option>';
                } else {
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.' ['.$row->Email.']</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {            
        
            $this->db->select('tbl_apv_group_approval.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_profile.Email AS Email')
                     ->from('tbl_apv_group_approval')
                     ->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID', $my_profile['dept'])
                     ->order_by('iGroupApprovalListId', 'ASC');
            $db = $this->db->get();
            

            foreach($db->result() as $row):
               
                $empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.' ['.$row->Email.']</option>';
                
            endforeach;            

            return $empty_select.$empty_select_closed;  
        }
    }



    public function empty_nik2_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK2" class="selectpicker" data-width="500px" data-style="btn-default" data-placeholder="Select Atasan Lebih Tinggi" style="width: 500px; display: none;">';
        $empty_select .= '<option value="0" selected="selected" disabled>Select Atasan Lebih Tinggi</option>';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();

        $my_profile = $this->_callback_my_profile();
        
        if(isset($listingID) && $state == "edit") {
            $this->db->select('*')
                     ->from('tbl_kpi_result')
                     ->where('kpi_result_id', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);            
            $NIK2 = $row->NIK2;
                        
            //GET THE CITIES PER STATE ID
            $this->db->select('tbl_apv_group_approval.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_profile.Email AS Email')
                     ->from('tbl_apv_group_approval')
                     ->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID', $my_profile['dept'])
                     ->order_by('iGroupApprovalListId', 'ASC');
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->NIK == $NIK2) {
                    $empty_select .= '<option value="'.$row->NIK.'" selected="selected">'.$row->Nama.' ['.$row->Email.']</option>';
                } else {
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.' ['.$row->Email.']</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {            
        
            $this->db->select('tbl_apv_group_approval.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_profile.Email AS Email')
                     ->from('tbl_apv_group_approval')
                     ->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID', $my_profile['dept'])
                     ->order_by('iGroupApprovalListId', 'ASC');
            $db = $this->db->get();            

            foreach($db->result() as $row):
               
                $empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.' ['.$row->Email.']</option>';
                
            endforeach;            

            return $empty_select.$empty_select_closed;  
        }
    }


    public function empty_nik3_dropdown_select(){
        
        $empty_select = '<select name="NIK3" class="selectpicker" data-width="500px" data-style="btn-default" data-placeholder="HRD" style="width: 500px; display: visible;">';
        $empty_select .= '<option value="0" selected="selected" disabled>Select HRD</option>';
        $empty_select_closed = '</select>';
       
        $listingID = $this->uri->segment(5);
        
        $crud = new grocery_CRUD();
        $state = $crud->getState();

        $my_profile = $this->_callback_my_profile();
        
        if(isset($listingID) && $state == "edit") {
            $this->db->select('*')
                     ->from('tbl_kpi_result')
                     ->where('kpi_result_id', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);            
            $NIK3 = $row->NIK3;
                        
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_apv_hrd')
                     ->where('hrd_modules', 'my_profile')
                     ->where('hrd_company', $my_profile['company'])
                     ->order_by('hrd_name', 'ASC');
            $db = $this->db->get();
            
            foreach($db->result() as $row):
                if($row->hrd_nik == $NIK3) {
                    $empty_select .= '<option value="'.$row->hrd_nik.'" selected="selected">'.$row->hrd_name.' ['.$row->hrd_email.']</option>';
                } else {
                    $empty_select .= '<option value="'.$row->hrd_nik.'">'.$row->hrd_name.' ['.$row->hrd_email.']</option>';
                }
            endforeach;
            
            return $empty_select.$empty_select_closed;
        } else {

            $this->db->select('*')
                     ->from('tbl_apv_hrd')
                     ->where('hrd_modules', 'my_profile')
                     ->where('hrd_company', $my_profile['company'])
                     ->order_by('hrd_name', 'ASC');
            $db = $this->db->get();

            foreach($db->result() as $row):
               
                $empty_select .= '<option value="'.$row->hrd_nik.'">'.$row->hrd_name.' ['.$row->hrd_email.']</option>';
                
            endforeach;

            return $empty_select.$empty_select_closed;  
        }
    }


}