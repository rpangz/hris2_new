<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class second_layer_approvement extends CMS_Priv_Strict_Controller {

    protected $URL_MAP = array();
    protected $company_id = NULL;
    protected $period_id  = NULL;
    protected $main_table = 'tbl_kpi_header_form';


    public function cms_complete_table_name($table_name){
        $this->load->helper($this->cms_module_path().'/function');
        if(function_exists('cms_complete_table_name')){
            return cms_complete_table_name($table_name);
        }else{
            return parent::cms_complete_table_name($table_name);
        }
    }


    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model($this->cms_module_path().'/Development_Model'); 
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
        $crud->unset_edit();
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();

        $crud->set_theme('no-flexigrid-summary-result');

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
        $crud->set_table($this->main_table);
        $crud->order_by('DivisionID','ASC');
        $crud->order_by('DepartmentID','ASC');
        $crud->order_by('EmployeeID','ASC');
        $crud->where('CompanyID', $this->uri->segment(4));
        $crud->where('PeriodID', $this->uri->segment(5));

        // primary key
        $crud->set_primary_key('KPIID');

        // set subject
        $crud->set_subject('REKAP PENILAIAN  KINERJA');

        // displayed columns on list
        $crud->columns('EmployeeID','EmployeeName','cTitle','DivisionID','DepartmentID','PeriodID','iAgree','total_score_A','nilai_A1','nilai_A2','total_score_B','nilai_B1','nilai_B2','total_score_C','nilai_C1','nilai_C2','total_score','Category','PARemarks');
        // displayed columns on edit operation
        $crud->edit_fields('country_id','name','tourism','commodity','citizen');
        // displayed columns on add operation
        $crud->add_fields('country_id','name','tourism','citizen','commodity');

        $crud->field_type('iAgree', 'true_false', array(1 => 'Yes', 0 => ''));


        // caption of each columns
        $crud->display_as('EmployeeID','NIK');
        $crud->display_as('EmployeeName','Name');
        $crud->display_as('DivisionID','Division');
        $crud->display_as('DepartmentID','Department');
        $crud->display_as('total_score_A','A');
        $crud->display_as('total_score_B','B');
        $crud->display_as('total_score_C','C');
        $crud->display_as('PeriodID','Period');
        $crud->display_as('total_score','Total');
        $crud->display_as('iAgree','Approved');
        $crud->display_as('cTitle','Title');
        $crud->display_as('PARemarks','Remarks');
        $crud->display_as('nilai_A1','A1');
        $crud->display_as('nilai_A2','A2');
        $crud->display_as('nilai_B1','B1');
        $crud->display_as('nilai_B2','B2');
        $crud->display_as('nilai_C1','C1');
        $crud->display_as('nilai_C2','C2');

        

        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));



        $crud->callback_column('EmployeeName',array($this, '_callback_column_EmployeeName'));
        $crud->callback_column('DivisionID',array($this, '_callback_column_DivisionID'));
        $crud->callback_column('DepartmentID',array($this, '_callback_column_DepartmentID'));
        $crud->callback_column('Category',array($this, '_callback_column_Category'));
        $crud->callback_column('nilai_A1',array($this, '_callback_column_nilai_A1'));
        $crud->callback_column('nilai_A2',array($this, '_callback_column_nilai_A2'));
        $crud->callback_column('nilai_B1',array($this, '_callback_column_nilai_B1'));
        $crud->callback_column('nilai_B2',array($this, '_callback_column_nilai_B2'));
        $crud->callback_column('nilai_C1',array($this, '_callback_column_nilai_C1'));
        $crud->callback_column('nilai_C2',array($this, '_callback_column_nilai_C2'));

        $this->crud = $crud;
        return $crud;
    }

    public function index(){

        $crud = $this->make_crud();
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $output->company_id = $_SESSION['__mark_company_id'];
        $output->period_id = $_SESSION['__mark_period_id'];
        $output->company_option_data = $this->company_option_data();
        $output->period_option_data = $this->period_option_data();
        $output->kpi_value = "Testing";
        $output->list_score = "Testing";

        $this->view($this->cms_module_path().'/second_layer_approvement_view', $output,
            $this->cms_complete_navigation_name('second_layer_approvement'));
    }

    public function filter_selection(){

        $CompanyID = $this->input->post('CompanyID');
        $PeriodID  = $this->input->post('PeriodID');

        if(isset($CompanyID)){
            $this->company_id = $CompanyID;
            $_SESSION['__mark_company_id'] = $CompanyID;
        }

        if(isset($PeriodID)){
            $this->period_id = $PeriodID;
            $_SESSION['__mark_period_id'] = $PeriodID;
        }


        redirect($this->cms_module_path().'/second_layer_approvement/index/'.$CompanyID.'/'.$PeriodID,'refresh');

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
        return $post_array;
    }

    public function _after_update($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here
        return $success;
    }

    public function _before_delete($primary_key){
        // delete corresponding citizen
        $this->db->delete($this->cms_complete_table_name('citizen'),
              array('city_id'=>$primary_key));
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


    public function company_option_data(){

        $sql        = "select a.CompanyID,b.cCompanyName from tbl_kpi_header_form as a inner join tbl_company as b on a.CompanyID=b.iCompanyId group by a.CompanyID order by a.CompanyID asc";
        $query      = $this->db->query($sql);

        return $query->result();
    }

    public function period_option_data(){

        $sql        = "select a.PeriodID from tbl_kpi_header_form as a group by a.PeriodID order by a.PeriodID asc";
        $query      = $this->db->query($sql);

        return $query->result();
    }


    // returned on view
    public function _callback_column_EmployeeName($value, $row){

        $this->db->select('Nama')
                 ->from('tbl_profile')
                 ->where('NIK', $row->EmployeeID);
        $db = $this->db->get();
        $data = $db->row(0);

        return $data->Nama;
    }

    public function _callback_column_DivisionID($value, $row){

        $this->db->select('cDivName')
                 ->from('tbl_div')
                 ->where('iDivId', $row->DivisionID);
        $db = $this->db->get();
        $data = $db->row(0);

        return $data->cDivName;
    }


    public function _callback_column_DepartmentID($value, $row){

        $this->db->select('cDeptName')
                 ->from('tbl_dept')
                 ->where('iDeptID', $row->DepartmentID);
        $db = $this->db->get();
        $data = $db->row(0);

        return $data->cDeptName;
    }

    public function _callback_column_Category($value){


        return $this->Development_Model->set_nilai_akhir_pa($value);

       
    }

    public function _callback_column_nilai_A1($value, $row){

        $jumlah_A1 = $this->caunt_total_activity($row->KPIID, 1);
        $jumlah_A2 = $this->caunt_total_activity($row->KPIID, 2);
        $jumlah_A3 = $this->caunt_total_activity($row->KPIID, 3);

        $total_jumlah = $jumlah_A1+$jumlah_A2+$jumlah_A3;

        $terisi1 = $this->caunt_total_loaded_activity1($row->KPIID, 1);
        $terisi2 = $this->caunt_total_loaded_activity1($row->KPIID, 2);
        $terisi3 = $this->caunt_total_loaded_activity1($row->KPIID, 3);

        $total_terisi = $terisi1+$terisi2+$terisi3;

        return '('.$total_jumlah.'/'.$total_terisi.')';
       
    }

    public function _callback_column_nilai_A2($value, $row){

        $jumlah_A1 = $this->caunt_total_activity($row->KPIID, 1);
        $jumlah_A2 = $this->caunt_total_activity($row->KPIID, 2);
        $jumlah_A3 = $this->caunt_total_activity($row->KPIID, 3);

        $total_jumlah = $jumlah_A1+$jumlah_A2+$jumlah_A3;

        $terisi1 = $this->caunt_total_loaded_activity2($row->KPIID, 1);
        $terisi2 = $this->caunt_total_loaded_activity2($row->KPIID, 2);
        $terisi3 = $this->caunt_total_loaded_activity2($row->KPIID, 3);

        $total_terisi = $terisi1+$terisi2+$terisi3;

        return '('.$total_jumlah.'/'.$total_terisi.')';
       
    }


    public function _callback_column_nilai_B1($value, $row){

        $jumlah_A1 = $this->caunt_total_activity($row->KPIID, 4);
        $total_jumlah = $jumlah_A1;

        $terisi1 = $this->caunt_total_loaded_activity1($row->KPIID, 4);      
        $total_terisi = $terisi1;

        return '('.$total_jumlah.'/'.$total_terisi.')';
       
    }

    public function _callback_column_nilai_B2($value, $row){

        $jumlah_A1 = $this->caunt_total_activity($row->KPIID, 4);
        $total_jumlah = $jumlah_A1;

        $terisi1 = $this->caunt_total_loaded_activity2($row->KPIID, 4);      
        $total_terisi = $terisi1;

        return '('.$total_jumlah.'/'.$total_terisi.')';
       
    }


    public function _callback_column_nilai_C1($value, $row){

        $jumlah_A1 = $this->caunt_total_activity($row->KPIID, 5);
        $total_jumlah = $jumlah_A1;

        $terisi1 = $this->caunt_total_loaded_activity1($row->KPIID, 5);      
        $total_terisi = $terisi1;

        return '('.$total_jumlah.'/'.$total_terisi.')';
       
    }

    public function _callback_column_nilai_C2($value, $row){

        $jumlah_A1 = $this->caunt_total_activity($row->KPIID, 5);
        $total_jumlah = $jumlah_A1;

        $terisi1 = $this->caunt_total_loaded_activity2($row->KPIID, 5);      
        $total_terisi = $terisi1;

        return '('.$total_jumlah.'/'.$total_terisi.')';
       
    }

    public function caunt_total_activity($primary_key, $item){

        $SQL    = "select count(a.activity_id) as total from tbl_kpi_activity_plan as a where a.KPIID=".$primary_key." and a.ItemID=".$item;
        $query  = $this->db->query($SQL);        
        $data   = $query ->row(0); 

        return $data->total;
    }

    public function caunt_total_loaded_activity1($primary_key, $item){

        $SQL    = "select count(a.activity_id) as total from tbl_kpi_activity_plan as a where a.KPIID=".$primary_key." and a.ItemID=".$item." and a.SM2 >0";
        $query  = $this->db->query($SQL);        
        $data   = $query ->row(0); 

        return $data->total;
    }

    public function caunt_total_loaded_activity2($primary_key, $item){

        $SQL    = "select count(a.activity_id) as total from tbl_kpi_activity_plan as a where a.KPIID=".$primary_key." and a.ItemID=".$item." and a.Nilai_Skala_Atasan >0";
        $query  = $this->db->query($SQL);        
        $data   = $query ->row(0); 

        return $data->total;
    }

    public function loaaddetaildata(){
        $periode = $this->input->post('periode');

        $SQL = "SELECT a.KPIID,a.EmployeeID,nama,cDeptName,total_score_A,total_score_B,
                CASE WHEN iTypeForm = 1 THEN '-' ELSE total_score_c END total_score_C,total_score,
                iAgree2,UsulanAgree2,RemarkAgree2
                FROM tbl_kpi_header_form a
                INNER JOIN tbl_profile b ON a.EmployeeID=b.nik
                INNER JOIN tbl_dept c ON a.DepartmentID=c.iDeptID
                INNER JOIN tbl_kpi_secondlayer_status d ON a.iAgree2=d.id_status
                WHERE a.iAtasanNIK2 = '".$this->cms_user_id()."' AND PeriodID = '".$periode."' AND iAgree = 1
                ORDER BY d.position_status,cDeptName";

        $query = $this->db->query($SQL);
        $total = $query->num_rows();


        if($total > 0) {
            $output['detaildata'] = $query->result(); 
            $output['list_score'] = $this->list_score(); 
            $this->view($this->cms_module_path().'/second_layer_approvement_detaildata_view', $output,
                        $this->cms_complete_navigation_name('second_layer_approvement'));    
        } else {
            echo '<div class="alert alert-danger text-center" role="alert">
                     - No Data Available
                  </div>';
        }
        

    }

    public function list_score(){
        $this->db->select('*')
                 ->from('tbl_kpi_score')
                 ->order_by('score_position','ASC');
        $score = $this->db->get()->result();
        return $score;
    }


    public function approve(){

        $kpiid = $this->input->post('kpiid');
        $usulan = $this->input->post('usulan');
        $remarks = $this->input->post('remarks');
        
        $data = array(                  
            'iAgree2' => '3', 
            'UsulanAgree2' => 'OK', 
            'RemarkAgree2' => $remarks,
        );

        $this->db->set('dAgreeDate2', 'NOW()', FALSE);
        $result = $this->db->where('KPIID', $kpiid)
                           ->update('tbl_kpi_header_form', $data);

        if($result) {
            echo '<div class="alert alert-success text-center" role="alert" style="font-weight: bold; font-size:15px;">DATA BERHASIL DI APPROVE</div>';
        } else {
            echo '<div class="alert alert-danger text-center" role="alert" style="font-weight: bold; font-size:15px;">DATA GAGAL DI APPROVE</div>';
        } 

    }

    public function unapprove(){

        $kpiid = $this->input->post('kpiid');
        $usulan = $this->input->post('usulan');
        $remarks = $this->input->post('remarks');
        
        $data = array(                  
            'iAgree2' => '2', 
            'UsulanAgree2' => $usulan, 
            'RemarkAgree2' => $remarks,
        );

        $this->db->set('dAgreeDate2', 'NOW()', FALSE);
        $result = $this->db->where('KPIID', $kpiid)
                           ->update('tbl_kpi_header_form', $data);

        if($result) {
            echo '<div class="alert alert-success text-center" role="alert" style="font-weight: bold; font-size:15px;">DATA BERHASIL DI UNAPPROVE</div>';
        } else {
            echo '<div class="alert alert-danger text-center" role="alert" style="font-weight: bold; font-size:15px;">DATA GAGAL DI UNAPPROVE</div>';
        } 

    }

    public function revisi(){

        $kpiid = $this->input->post('kpiid');
        $usulan = $this->input->post('usulan');
        $remarks = $this->input->post('remarks');
        
        $data = array(                  
            'iAgree2' => '4', 
            'UsulanAgree2' => $usulan, 
            'RemarkAgree2' => $remarks,
        );

        $this->db->set('dAgreeDate2', 'NOW()', FALSE);
        $result = $this->db->where('KPIID', $kpiid)
                           ->update('tbl_kpi_header_form', $data);

        if($result) {
            echo '<div class="alert alert-success text-center" role="alert" style="font-weight: bold; font-size:15px;">DATA BERHASIL DI REVISI</div>';
        } else {
            echo '<div class="alert alert-danger text-center" role="alert" style="font-weight: bold; font-size:15px;">DATA GAGAL DI REVISI</div>';
        } 

    }


    



}