<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class frmProgressApprovalList extends CMS_Priv_Strict_Controller {

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
      
        $crud = $this->new_crud();
        $crud->set_theme('flexigrid');
        $session_nik = $this->cms_user_id();
        $_SESSION['NIK'] = $session_nik;        
        if (FALSE) $crud = new Extended_Grocery_CRUD();
        $state = $crud->getState();
        $state_info = $crud->getStateInfo();
        $primary_key = isset($state_info->primary_key)? $state_info->primary_key : NULL;       
        $crud->set_language($this->cms_language());        
        $crud->set_table($this->cms_complete_table_name('formcuti'));   	
		

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
        );

        $output   = array_merge((array)$output, $data);        
        $this->view($this->cms_module_path().'/frmProgressApprovalList_view', $output, $this->cms_complete_navigation_name('frmProgressApprovalList'));
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

    


}