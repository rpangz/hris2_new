<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class frmSejarahCutiDivision extends CMS_Priv_Strict_Controller {

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
        $session_nik = $this->cms_user_id();
        $_SESSION['NIK'] = $session_nik;
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
        $crud->unset_print();
       
        
        $crud->set_language($this->cms_language());       
        $crud->set_table($this->cms_complete_table_name('hakcuti'));
        $crud->where('tbl_hakcuti.NIK',0);        
        $crud->set_primary_key('HakId');        
        $crud->set_subject('Daftar Hak Cuti');        
		$crud->columns('NIK2','NIK','Periode1','Periode2','PeriodeExt','JenisHakCuti','Qty','QtyPakai','StatusHak');	
        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $result = mysql_query("SELECT * FROM tbl_profile INNER JOIN tbl_div ON DivisiID=iDivId WHERE NIK=".$this->cms_user_id());
        $data = Array();
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $data['session_nik']     =  $row['NIK'];
            //$data['company_id']      =  $row['CompanyId'];
            $data['division_id']     =  $row['DivisiID'];
            $data['division_name']   =  $row['cDivName'];
            //$data['department_id'] =  $row['DeptID'];            
            $data['sex']             =  $row['Sex'];            
        }

        $output = $crud->render();
        $output   = array_merge((array)$output, $data);
        $this->view($this->cms_module_path().'/frmSejarahCutiDivision_view', $output,$this->cms_complete_navigation_name('frmSejarahCutiDivision'));
    }

}