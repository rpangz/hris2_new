<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class monitoring extends CMS_Priv_Strict_Controller {

    protected $URL_MAP = array();

    public function __construct(){
        parent::__construct();
        $this->load->model($this->cms_module_path().'/development_model');        
    }

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
        $crud->set_theme('no-flexigrid-monitoring');

        // unset things
        $crud->unset_jquery();
        $crud->unset_read();
        $crud->unset_add();
        // $crud->unset_edit();
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        //$crud->unset_export();
        $crud->unset_texteditor('cDescription');

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

        // table name
        $crud->set_table('tbl_kpi_header_form');
        $crud->order_by('PeriodID','DESC');
        //$crud->where('EmployeeID', $this->cms_user_id());

        // primary key
        $crud->set_primary_key('KPIID');

        // set subject
        $crud->set_subject('Monitoring');

        // displayed columns on list
        $crud->columns('PeriodID','cTitle','EmployeeID','CompanyID','DepartmentID','UnitID','iTypeForm','iGrade','iAtasanNIK','iAgree','Active','CreatedTime','BobotA','BobotB','BobotC');
        // displayed columns on edit operation
        $crud->edit_fields('PeriodID','cTitle','EmployeeID','CompanyID','DepartmentID','UnitID','iTypeForm','iGrade','iAtasanNIK','iAgree','Active');
        // displayed columns on add operation
        $crud->add_fields('iActivityID','cDescription');

        $crud->set_relation('EmployeeID', 'tbl_profile', 'Nama');
        $crud->set_relation('iAtasanNIK', 'tbl_profile', '{NIK} {Nama}');
        $crud->set_relation('iTypeForm', 'tbl_kpi_type_form', 'cName');
        $crud->set_relation('CompanyID', 'tbl_company', 'cCompanyName');
        $crud->set_relation('DivisionID', 'tbl_div', 'cDivName');
        $crud->set_relation('DepartmentID', 'tbl_dept', 'cDeptName');
        $crud->set_relation('UnitID', 'tbl_unit', 'NamaUnit');

        $crud->field_type('iAgree', 'true_false', array('Tidak', 'Ya'));
        $crud->field_type('Active', 'true_false', array('Close', 'Open'));

        // caption of each columns
        $crud->display_as('PeriodID','Tahun');
        $crud->display_as('cTitle','Judul');
        $crud->display_as('cDescription','Deskripsi');
        $crud->display_as('iAtasanNIK','Atasan');
        $crud->display_as('CompanyID','Company');
        $crud->display_as('DivisionID','Division');
        $crud->display_as('DepartmentID','Department');
        $crud->display_as('UnitID','Unit');
        $crud->display_as('iTypeForm','Type');
        $crud->display_as('iAgree','Deal');
        $crud->display_as('CreatedTime','Dibuat');
        $crud->display_as('EmployeeID','Karyawan');
        $crud->display_as('Active','Status');
        $crud->display_as('iGrade','Grade');

        $crud->display_as('BobotA','Bobot A');
        $crud->display_as('BobotB','Bobot BI');
        $crud->display_as('BobotC','Bobot BII');

        $crud->change_field_type('PeriodID', 'readonly');
        $crud->change_field_type('cTitle', 'readonly');
        $crud->change_field_type('EmployeeID', 'readonly');
        $crud->change_field_type('CompanyID', 'readonly');
        $crud->change_field_type('DepartmentID', 'readonly');
        $crud->change_field_type('UnitID', 'readonly');
        $crud->change_field_type('iTypeForm', 'readonly');
        //$crud->change_field_type('iAtasanNIK', 'readonly');
        //$crud->change_field_type('iAgree', 'readonly');
        $crud->change_field_type('CreatedTime', 'readonly');

       
        $crud->required_fields('iAgree','Active','iAtasanNIK','iGrade');

       
        //$crud->unique_fields('name');

        //$crud->add_action('Detail', 'btn btn-default', 'glyphicon glyphicon-th-list','',array($this,'_callback_column_detail'));

        
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        //$crud->field_type('iGrade','dropdown', array(1 => 'Band 1', 2 => 'Band 2', 3 => 'Band 3', 4 => 'Band 4', 5 => 'Band 5', 6 => 'Band 6', 7 => 'Band 7', 8 => 'Band 8'));


        //$crud->callback_before_insert(array($this,'encrypt_password_callback'));

        $crud->callback_column('monitoring',array($this, '_callback_column_monitoring'));
        $crud->callback_field('monitoring',array($this, '_callback_field_monitoring'));

        $crud->callback_column('BobotA',array($this, '_callback_column_BobotA'));
        $crud->callback_column('BobotB',array($this, '_callback_column_BobotB'));
        $crud->callback_column('BobotC',array($this, '_callback_column_BobotC'));

      

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
        $this->view($this->cms_module_path().'/monitoring_view', $output,
            $this->cms_complete_navigation_name('monitoring'));
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
        return $post_array;
    }

    public function _after_update($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here
        return $success;
    }

    public function _before_delete($primary_key){
        // delete corresponding citizen
        //$this->db->delete($this->cms_complete_table_name('citizen'), array('city_id'=>$primary_key));

        $this->db->select('iAgree, Active')
                     ->from('tbl_kpi_header_form')
                     ->where('KPIID', $primary_key)
                     ->order_by('KPIID', 'DESC');
        $db      = $this->db->get();
        $data    = $db->row(0);
        $num_row = $db->num_rows();

        if ($data->iAgree == 1){
            return FALSE;
        }
        /*
        elseif($this->count_activity($primary_key) > 0){
            return FALSE;
        }
        */
        else{
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

    public function plan_detail($id){
        $data = $this->development_model->get_detail_pa($id);

        $data->tab1 = $this->development_model->detail_tab1($id);
        $data->tab2 = $this->development_model->detail_tab2($id);
        $data->tab3 = $this->development_model->detail_tab3($id);
        $data->total_managing_people = $this->development_model->count_managing_people($id);
        echo json_encode($data);
    }

    public function count_activity($primary_key){

        $this->db->select('COUNT(activity_id) AS Total')
                 ->from('tbl_kpi_activity_plan')
                 ->where('KPIID', $primary_key);
        $db      = $this->db->get();
        $data    = $db->row(0);
        $num_row = $db->num_rows();

        return $data->Total;
    }

    // add hyperlink
    public function _callback_column_BobotA($value, $row){  
    
        $SQL    = "SELECT sum(Bobot_A) AS Bobot FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$row->KPIID."' AND (ItemID=1 OR ItemID=2 OR ItemID=3) ORDER BY ItemID ASC";
        $query  = $this->db->query($SQL);  
        $data   = $query->row(0);

        return $data->Bobot;      
        
    }

    public function _callback_column_BobotB($value, $row){  
    
        $SQL    = "SELECT sum(Bobot_A) AS Bobot FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$row->KPIID."' AND (ItemID=4) ORDER BY ItemID ASC";
        $query  = $this->db->query($SQL);  
        $data   = $query->row(0);

        return $data->Bobot;      
        
    }

    public function _callback_column_BobotC($value, $row){  
    
        $SQL    = "SELECT sum(Bobot_A) AS Bobot FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$row->KPIID."' AND (ItemID=5) ORDER BY ItemID ASC";
        $query  = $this->db->query($SQL);  
        $data   = $query->row(0);

        return $data->Bobot;      
        
    }

}