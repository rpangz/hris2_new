<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Dompak
 */
class frmTasks2 extends CMS_Priv_Strict_Controller {

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
        $_SESSION['NIK']    = $session_nik;        
        $today              = date('Y-m-d H:i:s');

        $this->load->library("session");
        
        if (FALSE) $crud = new Extended_Grocery_CRUD();

        $state = $crud->getState();
        $state_info = $crud->getStateInfo();
        $primary_key = isset($state_info->primary_key)? $state_info->primary_key : NULL;       

        $crud->set_language($this->cms_language());       
        
        // table name
        $crud->set_table($this->cms_complete_table_name('profile'));
        
        $crud->callback_field('Detail',array($this, '_callback_field_citizen'));

        
        $this->crud = $crud;
        return $crud;
    }


  

    public function index(){
        $crud = $this->make_crud();
        $output = $crud->render();
        $my_profile = $this->_callback_my_profile();        
        $data = array(
            'session_nik' => $my_profile['session_nik'],
            'session_name' => $my_profile['session_name'],
            'data_id' => $this->get_states(),             
        );

        $output   = array_merge((array)$output, $data);    
        $this->view($this->cms_module_path().'/frmTasks2_view', $output,$this->cms_complete_navigation_name('frmTasks2'));
        //$this->view($this->cms_module_path().'/ajax_data', $output,$this->cms_complete_navigation_name('frmTasks2'));
        //$this->view('172.17.0.16/hris2/ajax_data.php', $output,$this->cms_complete_navigation_name('frmTasks2'));
        //$this->load->view('http://172.17.0.16/hris2/ajax_data.php');
    }

    public function _callback_my_profile(){        
        $result = mysql_query("SELECT Nama AS Nama,CompanyId AS CompanyId, DeptID AS DeptID, Sex AS Sex, StatusDiri AS StatusDiri, tbl_company.bStatus AS bStatus 
            FROM tbl_profile INNER JOIN tbl_company ON tbl_profile.CompanyId=tbl_company.iCompanyId 
            WHERE NIK=".$this->cms_user_id());
        $storeArray = Array();
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $storeArray['company'] =  $row['CompanyId'];
            $storeArray['dept'] =  $row['DeptID'];
            $storeArray['sex'] =  $row['Sex'];
            $storeArray['status_diri'] =  $row['StatusDiri'];
            $storeArray['company_status'] =  $row['bStatus'];
            $storeArray['session_nik'] = $this->cms_user_id();
            $storeArray['session_name'] = $row['Nama'];
            
        }
        return $storeArray;     
    }

    //GET JSON OF STATES
    public function get_states(){        
        $id=$this->input->post('id');
        return $id;      
        
    }

    // returned on insert and edit
    public function _callback_field_citizen($value, $primary_key){
        

        return $this->load->view($this->cms_module_path().'/ajax_data',$data, TRUE);
    }




    



}