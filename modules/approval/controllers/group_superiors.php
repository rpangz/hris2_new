<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class group_superiors extends CMS_Priv_Strict_Controller {

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
        $session_id = $this->cms_user_id();
        $today = date('Y-m-d H:i:s');
        //$crud->set_theme('datatables');
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
        $crud->unset_texteditor('superiors_remarks');
        

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
        else {
            $crud->set_relation('superiors_nik', $this->cms_complete_table_name('profile'), 'Nama');
            $crud->set_theme('no-flexigrid');
        }
        
       

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
      

        $crud->set_table($this->cms_complete_table_name('apv_group_superiors'));

        //$where = "iTransPeriodId =".$this->uri->segment(4)." AND cTransCode LIKE".$this->uri->segment(5);
        //$crud->where($where);

        //$crud->where('iTransPeriodId', $this->uri->segment(4));
        //$crud->like('cTransCode',$this->uri->segment(4));
        //$crud->where('cTransCode', $this->uri->segment(5));


        //$crud->order_by('iGroupApprovalListId','ASC');
        // primary key
        $crud->set_primary_key('superiors_id');

        $crud->set_subject('Group Atasan');

        //$crud->unset_add_fields('iTransCreateBy','dTransCreateTime');
        //$crud->unset_edit_fields('iTransUpdateBy','dTransUpdatetime');

        //$crud->field_type('iTransCreateBy', 'hidden', $session_id);
        //$crud->field_type('dTransCreateTime', 'hidden', $today);
        //$crud->field_type('iTransUpdateBy', 'hidden', $session_id);
        //$crud->field_type('dTransUpdatetime', 'hidden', $today);

        $crud->columns('superiors_nik','superiors_name','superiors_jabatan','superiors_remarks','bawahan','superiors_id');
        $crud->edit_fields('superiors_nik','superiors_jabatan','superiors_remarks','bawahan');
        $crud->add_fields('superiors_nik','superiors_jabatan','superiors_remarks','bawahan');
            
       
        $crud->display_as('superiors_nik','NIK');
        $crud->display_as('superiors_name','Nama');
        $crud->display_as('superiors_jabatan','Jabatan');
        $crud->display_as('superiors_remarks','Remarks');
       
        

        $crud->required_fields('superiors_nik','superiors_jabatan');

        $crud->unique_fields('superiors_nik');

        $crud->set_relation_n_n('bawahan',
            $this->cms_complete_table_name('apv_group_bawahan'),
            $this->cms_complete_table_name('profile'),
            'superiors_id', 'NIK',
            'Nama', 'priority');

        
        $crud->set_relation('superiors_jabatan', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');
        
        //$crud->set_relation('deptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        //$crud->set_relation('iUnitID', $this->cms_complete_table_name('unit'), 'NamaUnit');
              

      
        $crud->callback_column('superiors_name',array($this,'_callback_edit_url'));

        //$crud->field_type('form_cuti', 'true_false');

        //$crud->field_type('form_cuti','enum',array(1 => 'active',0=> 'inactive'));

        $crud->callback_column('bawahan',array($this, '_callback_column_citizen'));


        //$crud->callback_field('form_cuti', array($this, 'get_true_false_input_form_cuti'));
        //$crud->callback_field('form_ijin', array($this, 'get_true_false_input_form_ijin'));
        //$crud->callback_field('form_my_cv', array($this, 'get_true_false_input_form_my_cv'));

        
        //$crud->add_action('print', '', '','ui-icon-image',array($this,'just_a_test'));
        //$crud->add_action('More', '', 'demo/action_more','ui-icon-plus');
        
            
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $crud->callback_add_field('divisionID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_edit_field('divisionID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_add_field('deptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_edit_field('deptID', array($this, 'empty_city_dropdown_select'));

        $crud->callback_add_field('iUnitID', array($this, 'empty_unit_dropdown_select'));
        $crud->callback_edit_field('iUnitID', array($this, 'empty_unit_dropdown_select'));

        $crud->callback_column('NIKKI', array($this, '_callback_column_NIKKI'));
        //$crud->callback_column('iGroupApprovalId', array($this, '_callback_column_iGroupApprovalId'));       

        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/group_superiors_view', $output,
            $this->cms_complete_navigation_name('group_superiors'));
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

        return $success;
    }

    public function _before_delete($primary_key){

        $this->db->delete($this->cms_complete_table_name('apv_group_bawahan'),
              array('superiors_id'=>$primary_key));

        return TRUE;
    }

    public function _after_delete($primary_key){
        return TRUE;
    }

    public function _after_insert_or_update($post_array, $primary_key){

        $nama = $this->data_table_value($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $post_array['superiors_nik']);        

        $this->db->update('tbl_apv_group_superiors', array('superiors_name'=> $nama), array('superiors_id'=> $primary_key));

        return TRUE;
    }

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }

    // add hyperlink
    public function _callback_edit_url($value, $row){    
    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->superiors_id)."'>$value</a>";
        
    }

    public function data_table_value($table_name, $where_column, $result_column, $value){

        $this->db->select($result_column)
                 ->from($table_name)
                 ->where($where_column, $value);
        $db      = $this->db->get();
        $data    = $db->row(0);
        $num_row = $db->num_rows();

        if ($num_row > 0){
            return $data->$result_column;
        }
        else{
            return '';
        }
    }

    public function _callback_column_citizen($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('apv_group_bawahan'))
            ->where('superiors_id', $row->superiors_id)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' Orang';
        }else if($num_row>0){
            return $num_row .' Orang';
        }else{
            return 'Tidak Ada';
        }
    }   

    

   

}