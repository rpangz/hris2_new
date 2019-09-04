<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Master_Company
 *
 * @author No-CMS Module Generator
 */
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
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // initialize groceryCRUD
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud = $this->new_crud();
        $crud->set_theme('flexigrid');
        $session_nik = $this->cms_user_id();
        $_SESSION['NIK'] = $session_nik;
        $today = date('Y-m-d H:i:s');          
        $company_id = $this->cms_get_config('cms_jasnikom_id');
        $hrd_modules = $this->cms_get_config('hrd_cuti_modules');
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
		$crud->unset_texteditor('Alamat');
        $crud->unset_texteditor('Keperluan');
        
		
        // $crud->unset_add();
        //$crud->unset_edit();
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();

        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_country_model');
        */

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->cms_complete_table_name('formcuti'));
        $crud->where('FormCutiNIK', $session_nik);

        // primary key
        $crud->set_primary_key('CutiId');

        // set subject
        $crud->set_subject('Form Cuti');

        // displayed columns on list
		$crud->columns('CutiId','FormCutiNIK','Keperluan','StatusForm','ApvLevel');
		
		
        // displayed columns on edit operation
       
		//$crud->edit_fields('NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','Alamat','Kodepos','Telp','Hp','Email','AlamatKTP','StatusDiri','TglMenikah','TglMasuk','TglKeluar','BandSkrg','Status','CompanyId','DivisiID','DeptID','UnitID','JabatanID','JmlAnak');

		
        // displayed columns on add operation
		
		//$crud->add_fields('NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','Alamat','Kodepos','Telp','Hp','Email','AlamatKTP','StatusDiri','TglMenikah','TglMasuk','TglKeluar','BandSkrg','Status','CompanyId','DivisiID','DeptID','UnitID','JabatanID','JmlAnak');
		


        // caption of each columns		
		$crud->display_as('CutiId','ID');		
        $crud->display_as('FormCutiNIK','Nama');
        $crud->display_as('TglActive1','Tgl Active1');
        $crud->display_as('TglActive2','Tgl Active2');
        $crud->display_as('Keperluan','Keperluan');
        $crud->display_as('StatusForm','Status');
        $crud->display_as('ApvLevel','Approval');
        


        
				
		
		// $crud->required_fields( $field1, $field2, $field3, ... );
		$crud->required_fields('FormCutiNIK','TglActive1','TglActive2','Keperluan','StatusForm','ApvLevel');
       
		
		//$crud->unique_fields( $field1, $field2, $field3, ... );
		//$crud->unique_fields('NIK');
       		

		$crud->set_relation('FormCutiNIK', $this->cms_complete_table_name('profile'), 'Nama');
        $crud->set_relation('JenisCuti', $this->cms_complete_table_name('jeniscuti'), 'JenisCutiName');
        //$crud->set_relation('CompanyId', $this->cms_complete_table_name('company'), 'cCompanyCode');
        //$crud->set_relation('DivisiID', $this->cms_complete_table_name('div'), 'cDivName');
        //$crud->set_relation('DeptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        //$crud->set_relation('UnitID', $this->cms_complete_table_name('unit'), 'NamaUnit');
       // $crud->set_relation('JabatanID', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');

        //$crud->set_relation('StatusDiri', $this->cms_complete_table_name('StatusDiri'), 'StatusDiriName');
        //$crud->set_relation('Agama', $this->cms_complete_table_name('Agama'), 'agama_name');

      	
			
		$crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));
        //$crud->callback_column('CutiId',array($this,'_callback_edit_url'));
        $crud->callback_column('TglActive1',array($this,'_Date1_call'));
        $crud->callback_column('TglActive2',array($this,'_Date2_call'));


        $crud->callback_add_field('FormCutiNIK', array($this, '_callback_add_field_FormCutiNIK'));


        $this->crud = $crud;
        return $crud;
    }

    

    public function index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/frmProgressApprovalList_view', $output,
            $this->cms_complete_navigation_name('frmProgressApprovalList'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('formcuti'),array('CutiId'=>$id));
                    $this->_after_delete($id);
                }
            }
        }
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
        // HINT : Put your code here
        return $success;
    }

    public function _before_delete($primary_key){

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

    // add hyperlink
    public function _callback_edit_url($value, $row){    
    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->CutiId)."'>$value</a>";
        
    }

    // change dPeriodEndDate format to d-M-Y
    public function _Date1_call($value, $row)
    {
        //return $value." - scale: <b>".$row->date."</b>";
        $Date1 = date('d-M-Y', strtotime($row->TglActive1));
        return $Date1;
        
    }

    // change dPeriodEndDate format to d-M-Y
    public function _Date2_call($value, $row)
    {
        //$session_id = $this->cms_user_name();
        //return $value." - scale: <b>".$row->date."</b>";
        $Date2 = date('d-M-Y', strtotime($row->TglActive2));
        return $Date2;
        
    }


    // Add Default Tagging Asset
    public function _callback_add_field_FormCutiNIK()
    {
      
        //$stateID = $this->uri->segment(5);
        $NIK = $this->cms_user_id();
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('profile'))     
            ->where('NIK', $NIK)
            ->get();        

        foreach ($query->result() as $rown){
            return $rown->Nama."<input type='hidden' maxlength='50' value='".$rown->NIK."' name='FormCutiNIK'>";
        }   
        
    }



}