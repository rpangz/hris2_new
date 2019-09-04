<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class frmTimeKPI extends CMS_Priv_Strict_Controller {

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
        $crud->unset_add();
        // $crud->unset_edit();
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        // $crud->unset_print();
        // $crud->unset_export();

        // set custom grocery crud model, uncomment to use.
     
        //$crud->set_theme('flexigrid');
        // adjust groceryCRUD's language to No-CMS's language

        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->cms_complete_table_name('kpi_result'));
        $crud->order_by('kpi_result_nik','ASC');

        // primary key
        $crud->set_primary_key('kpi_result_id');

        // set subject
        $crud->set_subject('Time KPI');

        // displayed columns on list
        $crud->columns('kpi_result_periode','kpi_result_nik','kpi_result_time');
        // displayed columns on edit operation
        $crud->edit_fields('kpi_result_periode','kpi_result_nik','kpi_result_time','kpi_result_updatetime');
        // displayed columns on add operation
        
        //$crud->add_fields('country_id','name','tourism','citizen','commodity');

        
        $crud->field_type('kpi_result_periode','readonly');
        $crud->field_type('kpi_result_nik','readonly');


        $crud->unset_edit_fields('kpi_result_updatetime');
        $crud->field_type('kpi_result_updatetime','hidden',NULL);

     
        // caption of each columns
        $crud->display_as('kpi_result_periode','Periode');
        $crud->display_as('kpi_result_nik','Nama');
        $crud->display_as('kpi_result_time','Waktu');
              
        $crud->set_relation('kpi_result_nik', $this->cms_complete_table_name('profile'), 'Nama');

    
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));


        //$crud->callback_before_insert(array($this,'encrypt_password_callback'));

        //$crud->callback_column('citizen',array($this, '_callback_column_citizen'));
        $crud->callback_field('kpi_result_time',array($this, '_callback_field_kpi_result_time'));


        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/frmTimeKPI_view', $output,
            $this->cms_complete_navigation_name('frmTimeKPI'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('city'),array('city_id'=>$id));
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
        // HINT : Put your code here       

        return $success;
    }

    public function _before_update($post_array, $primary_key){
        $post_array = $this->_before_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here

    /*   
        $data = json_decode($this->input->post('md_real_field_time_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('time_id','time_result');
        $set_column_names = array();
        
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
            $this->db->update($this->cms_complete_table_name('kpi_time'), $data, array('time_id'=>$detail_primary_key));            
            
        }
    */

        return $post_array;
    }

    public function _after_update($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here

        return $success;
    }

    public function _before_delete($primary_key){
        // delete corresponding citizen
        $this->db->delete($this->cms_complete_table_name('kpi_time'), array('kpi_result_id'=>$primary_key));
        return TRUE;
    }

    public function _after_delete($primary_key){
        return TRUE;
    }

    public function _after_insert_or_update($post_array, $primary_key){

        $data = json_decode($this->input->post('md_real_field_time_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('time_id','time_item','time_result');
        $set_column_names = array();
        
        
        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            $this->db->delete($this->cms_complete_table_name('kpi_time'),
                 array('time_id'=>$detail_primary_key));
        }
       
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
            $this->db->update($this->cms_complete_table_name('kpi_time'), $data, array('time_id'=>$detail_primary_key)); 

            $value = $post_array['time_result_'.$update_record['record_index']];
            
            if (!empty($value)){            
                $time_result = $value;
            }
            else{
                $time_result = NULL;            
            }

            $this->db->update($this->cms_complete_table_name('kpi_time'), array('time_result' =>$time_result), array('time_id'=>$detail_primary_key));

            $this->update_time_value($detail_primary_key);

            

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
            $this->db->insert($this->cms_complete_table_name('kpi_time'), $data);
            $detail_primary_key = $this->db->insert_id();
            
        }



        //$this->update_user_time_result($primary_key);

        $this->update_user_time_result($primary_key);

        

        return TRUE;
    }

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }


    // returned on insert and edit
    public function _callback_field_kpi_result_time($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        //$this->set_rules('birthdate','birthdate','required');        

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('time_id, time_item, time_result')
            ->from($this->cms_complete_table_name('kpi_time'))
            ->where('kpi_result_id', $primary_key)
            ->order_by('time_item','ASC')
            ->get();
        $result = $query->result_array();


        // get options
        $options = array();
        $options['time_item'] = array();
        $query = $this->db->select('time_item_id,time_item_name,time_item_unit')
           ->from($this->cms_complete_table_name('kpi_time_item'))
           ->get();
        foreach($query->result() as $row){
            $options['time_item'][] = array('value' => $row->time_item_id, 'caption' => $row->time_item_name.' ('.$row->time_item_unit.')');
        }


        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
        );
        return $this->load->view($this->cms_module_path().'/field_detail_time',$data, TRUE);
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



    public function update_time_value($detail_primary_key){

        $query  = mysql_query("SELECT * FROM `tbl_kpi_time` WHERE time_id='".$detail_primary_key."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        if (!is_null($data['time_result']) OR !empty($data['time_result'])){

            if ($data['time_item'] ==1){
                $time_value = $this->nilai_datang_terlambat($value = $data['time_result']);
            }
            elseif ($data['time_item'] ==2){
                $time_value = $this->nilai_sakit_tanpa_surat_dokter($value = $data['time_result']);
            }
            elseif($data['time_item'] ==3){
                $time_value = $this->nilai_tidak_hadir_tanpa_alasan($value = $data['time_result']);
            }
            else{
                $time_value = NULL;
            }            

        }
        else{
            $time_value = NULL;
        }

        $this->db->update($this->cms_complete_table_name('kpi_time'),array('time_value'=>$time_value), array('time_id'=>$detail_primary_key));
        

    }


    public function kpi_weight($session_kpi){

      $query  = mysql_query('SELECT * FROM tbl_kpi_type WHERE kpi_type_id='.$session_kpi);
      $total  = mysql_num_rows($query);
      $data   = mysql_fetch_array($query);

      return $data['kpi_type_weight'];   

    }

    public function update_user_time_result($primary_key){

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

    public function nilai_datang_terlambat($value){

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


    public function nilai_sakit_tanpa_surat_dokter($value){      
      

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


    public function nilai_tidak_hadir_tanpa_alasan($value){
      

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

}