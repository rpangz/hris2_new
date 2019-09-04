<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class summary extends CMS_Priv_Strict_Controller {

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
        $crud->set_theme('no-flexigrid');

        // unset things
        $crud->unset_jquery();
        $crud->unset_read();
        //$crud->unset_add();
        // $crud->unset_edit();
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        //$crud->unset_export();
        $crud->unset_texteditor('cDescription');

       
        //$crud->set_theme('flexigrid');
        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table('tbl_kpi_faktor_penilaian');
        $crud->order_by('iFPActivityID,iFPItem,iFPGradeID','ASC');
        //$crud->where('EmployeeID', $this->cms_user_id());

        // primary key
        $crud->set_primary_key('iFPID');

        // set subject
        $crud->set_subject('Faktor Penilaian');

        // displayed columns on list
        $crud->columns('iFPActivityID','iFPItem','iFPGradeID','cFPValue');
        // displayed columns on edit operation
        $crud->edit_fields('iFPActivityID','iFPItem','iFPGradeID','cFPValue');
        // displayed columns on add operation
        $crud->add_fields('iFPActivityID','iFPItem','iFPGradeID','cFPValue');

        $crud->field_type('iFPActivityID','dropdown', array(1 => 'KEY PERFORMANCE INDICATORS (KPI)', 2 => 'PROCESS & CORE VALUES', 3=>'MANAGING PEOPLE'));
        $crud->field_type('iFPItem','dropdown', array(1 => 'Struktural', 2 => 'Fungsional'));

        $crud->field_type('iFPGradeID','dropdown', array(0 =>'Band 0',1=>'Band 1',2=>'Band 2',3=>'Band 3',4=>'Band 4',5=>'Band 5',6=>'Band 6',7=>'Band 7',8=>'Band 8'));

        $crud->set_rules('cFPValue','Value','integer');

     
        //$crud->field_type('iAgree', 'true_false', array('Tidak', 'Ya'));
        //$crud->field_type('Active', 'true_false', array('Close', 'Open'));

        // caption of each columns
        $crud->display_as('iFPActivityID','Activity Plan');
        $crud->display_as('iFPItem','Type');
        $crud->display_as('iFPGradeID','Band');
        $crud->display_as('cFPValue','Value (%)');
        
        /*
        $crud->change_field_type('PeriodID', 'readonly');
        $crud->change_field_type('cTitle', 'readonly');
        $crud->change_field_type('EmployeeID', 'readonly');
        $crud->change_field_type('CompanyID', 'readonly');
        $crud->change_field_type('DepartmentID', 'readonly');
        $crud->change_field_type('iTypeForm', 'readonly');
        $crud->change_field_type('iAtasanNIK', 'readonly');
        //$crud->change_field_type('iAgree', 'readonly');
        $crud->change_field_type('CreatedTime', 'readonly');
        */

       
        $crud->required_fields('iFPActivityID','iFPItem','iFPGradeID','cFPValue');

       
        

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

        $crud->callback_column('monitoring',array($this, '_callback_column_monitoring'));
        $crud->callback_field('monitoring',array($this, '_callback_field_monitoring'));

        

        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();

        $SQL    = "SELECT KPIID, cTitle, EmployeeID, PeriodID, Nama,cDivName,cDeptName,total_score,iCounseling FROM tbl_kpi_header_form INNER JOIN tbl_profile ON NIK=EmployeeID 
                   INNER JOIN tbl_div ON DivisionID=iDivId INNER JOIN 
                   tbl_dept ON iDeptID=DepartmentID
                   WHERE iAtasanNIK='".$this->cms_user_id()."' AND iAgree=0 ORDER BY PeriodID,cDivName,cDeptName DESC";
        $query  = $this->db->query($SQL);        
        $result = $query->result();

        $output->session_nik = $this->cms_user_id();       
        $output->result = $result;        

        $this->view($this->cms_module_path().'/summary_view', $output,
            $this->cms_complete_navigation_name('summary'));
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

    public function detail(){

        $primary_key = $this->uri->segment(4);

        $data = $this->development_model->get_detail_header($primary_key);
        $data->nilai_akhir = $this->set_nilai_akhir_pa($data->total_score);
        $data->nama = $this->set_user_profile($data->EmployeeID,'Nama');
        $data->divisi = $this->set_user_profile($data->EmployeeID,'cDivName');
        $data->dept = $this->set_user_profile($data->EmployeeID,'cDeptName');
        $data->jabatan = $this->set_user_profile($data->EmployeeID,'NamaJabatan');
        echo json_encode($data);


        //echo $this->load->view($this->cms_module_path().'/summary_detail_view', $data ,TRUE);
    }

    public function add_form_counseling(){

        $primary_key = $this->uri->segment(4);

        $data = $this->development_model->get_detail_header($primary_key);
        $data->nilai_akhir = $this->set_nilai_akhir_pa($data->total_score);
        $data->nama = $this->set_user_profile($data->EmployeeID,'Nama');
        $data->divisi = $this->set_user_profile($data->EmployeeID,'cDivName');
        $data->dept = $this->set_user_profile($data->EmployeeID,'cDeptName');
        $data->jabatan = $this->set_user_profile($data->EmployeeID,'NamaJabatan');
        $data->company = $this->set_user_profile($data->EmployeeID,'cCompanyName');
        echo json_encode($data);

        //echo $this->load->view($this->cms_module_path().'/summary_detail_view', $data ,TRUE);
    }

    public function final_bobot_user($primary_key){

        $SQL    = "SELECT AVG(((SM1+SM2)/Plan_B)*100) AS Achieve 
                   FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                   WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."'";
        $query  = $this->db->query($SQL);
        $data    = $query->row(0);

        return number_format($data->Achieve,0);

    }

    public function set_nilai_akhir_pa($value=NULL){

        if ($value >= 4.50 && $value <= 5.00){
            return 'IST (ISTIMEWA)';
        }
        elseif($value >=3.75 && $value <= 4.49){
            return 'BS (BAIK SEKALI)';
        }
        elseif($value >= 3.25 && $value <= 3.74){
            return 'B+ (BAIK PLUS)';
        }
        elseif($value >= 3.00 && $value <= 3.24){
            return 'B (BAIK)';
        }
        elseif($value >= 2.75 && $value <= 2.99){
            return 'B- (BAIK MINUS)';
        }
        elseif($value >= 2.00 && $value <= 2.74){
            return 'C (CUKUP)';
        }
        elseif($value >= 1.00 && $value <= 1.99){
            return 'K (KURANG)';
        }        
        else{
            return 'Tidak Terdeteksi';
        }

    }

    public function set_user_profile($session_nik, $value){

        $this->db->select('NIK, Nama, cCompanyName, cDivName, cDeptName, NamaUnit, NamaJabatan')
                 ->from('tbl_profile')
                 ->join('tbl_company', 'CompanyId=iCompanyId','INNER')
                 ->join('tbl_div', 'DivisiID=iDivId','INNER')
                 ->join('tbl_dept', 'tbl_profile.DeptID=iDeptID','INNER')
                 ->join('tbl_unit', 'tbl_profile.UnitID=tbl_unit.unitID','INNER')
                 ->join('tbl_jabatan', 'tbl_profile.JabatanID=tbl_jabatan.JabatanId','INNER')                 
                 ->where('NIK', $session_nik);
        $db      = $this->db->get();
        $data    = $db->row(0);
        $num_row = $db->num_rows();
        if ($num_row > 0){
            return $data->$value;
        }
        else{
            return '';
        }
        
    }

    public function counseling_insert()
    {
        $today = date('Y-m-d H:i:s');

        $this->load->model('development_model');
        //$this->_validate($this->input->post('CounselingKPIID'),$this->input->post('ItemID'), $activity_id=NULL);

        $data = array(
                'CounselingKPIID' => $this->input->post('CounselingKPIID'),
                'hal_positif' => $this->input->post('hal_positif'),
                'hal_perlu_ditingkatkan' => $this->input->post('hal_perlu_ditingkatkan'),
                'tantangan_dalam_pekerjaan' => $this->input->post('tantangan_dalam_pekerjaan'),
                'aspirasi_karir' => $this->input->post('aspirasi_karir'),
                'PV1' => $this->input->post('PV1'),
                'PV2' => $this->input->post('PV2'),
                'PV3' => $this->input->post('PV3'),
                'PV4' => $this->input->post('PV4'),
                'PV5' => $this->input->post('PV5'),
                'PV6' => $this->input->post('PV6'),
                'PV7' => $this->input->post('PV7'),
                'PV8' => $this->input->post('PV8'),
                'CreatedBy' => $this->cms_user_id(),
                'CreatedTime' => $today,
                'UpdatedBy' => $this->cms_user_id(),
                'UpdatedTime' => $today,
            );

        $this->db->insert('tbl_kpi_coaching_and_counseling', $data);
        //$this->db->update('tbl_kpi_header_form', array('iCounseling'=> 1), array('KPIID'=> $this->input->post('CounselingKPIID')));

        $insert = $this->development_model->save_counseling($data);
        echo json_encode(array("status" => TRUE));
    }

    public function counseling_update()
    {
        $this->load->model('development_model');

        $this->_validate($this->input->post('KPIID'), $this->input->post('ItemID'), $this->input->post('activity_id'));

        $pieces = explode('/', $this->input->post('DD'));

        $DD = $pieces[2].'-'.$pieces[1].'-'.$pieces[0];


        $data = array(
                'ItemID' => $this->input->post('ItemID'),
                'Description' => $this->input->post('Description'),
                'UoM' => $this->input->post('UoM'),
                'DD' => $DD,
                'EveryMonth' => $this->input->post('EveryMonth'),
                'Bobot_A' => $this->input->post('Bobot_A'),
                'Plan_B' => $this->input->post('Plan_B'),
            );

        $this->development_model->update(array('activity_id' => $this->input->post('activity_id')), $data);
        echo json_encode(array("status" => TRUE));
    }


}