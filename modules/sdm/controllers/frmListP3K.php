<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Master_Company
 *
 * @author No-CMS Module Generator
 */
class frmListP3K extends CMS_Priv_Strict_Controller {

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
		$crud->unset_texteditor('Keperluan');
        $crud->unset_texteditor('Catatan');
        //$crud->unset_operations(); // it s a view
		
        // $crud->unset_add();
        // $crud->unset_edit();
        // $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');
            $crud->unset_edit();
        }
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
        $crud->set_table($this->cms_complete_table_name('formp3k'));
        $crud->order_by('NIK', 'ASC');
        $crud->order_by('FormP3KId', 'ASC');

        // primary key
        $crud->set_primary_key('FormP3KId');

        // set subject
        $crud->set_subject('Daftar P3K');

        // displayed columns on list
		$crud->columns('NIK2','NIK','Pilihan','TglIssue','Catatan','FormStatus');
		
		
        // displayed columns on edit operation
       
		//$crud->edit_fields('NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','Alamat','Kodepos','Telp','Hp','Email','AlamatKTP','StatusDiri','TglMenikah','TglMasuk','TglKeluar','BandSkrg','Status','CompanyId','DivisiID','DeptID','UnitID','JabatanID','JmlAnak');

		
        // displayed columns on add operation
		
		$crud->add_fields('NIK','Pilihan','TglIssue','Catatan','FormStatus','CurJabatanID','NewJabatanID','CurCompanyId','CurDivisiID','CurDeptID','CurUnitID');
        $crud->edit_fields('NIK','Pilihan','TglIssue','Catatan','FormStatus','CurJabatanID','NewJabatanID','CurCompanyId','CurDivisiID','CurDeptID','CurUnitID');
		


        // caption of each columns		
				
        $crud->display_as('NIK2','NIK');
        $crud->display_as('NIK','Nama');
        $crud->display_as('TglIssue','Tgl Perubahan');
        $crud->display_as('TglKTP','Tgl KTP');
        $crud->display_as('Sex','Sex');
        $crud->display_as('BandSkrg','Band');
        $crud->display_as('TglMasuk','Tgl Masuk');
        $crud->display_as('Status','Status');
        $crud->display_as('StatusDiri','Status Diri');
        $crud->display_as('CompanyId','Company');
        $crud->display_as('DivisiID','Division');
        $crud->display_as('DeptID','Departemen');
        $crud->display_as('UnitID','Unit');
        $crud->display_as('JabatanID','Jabatan');
        $crud->display_as('JmlAnak','Jumlah Anak');
        $crud->display_as('TptLahir','Tempat Lahir');
        $crud->display_as('TglLahir','Tgl Lahir');
        $crud->display_as('TglMenikah','Tgl Menikah');
        $crud->display_as('TglKeluar','Tgl Keluar');
        $crud->display_as('AlamatKTP','Alamat KTP');


        
				
		
		// $crud->required_fields( $field1, $field2, $field3, ... );
		$crud->required_fields('NIK','Pilihan','TglIssue','FormStatus');
       
		
		//$crud->unique_fields( $field1, $field2, $field3, ... );
		//$crud->unique_fields('NIK');
       		

		//$crud->set_relation('NIK', $this->cms_complete_table_name('profile'), 'Nama');
        $crud->set_relation('Pilihan', $this->cms_complete_table_name('jenisperubahan'), 'PerName');
        $crud->set_relation('CurCompanyId', $this->cms_complete_table_name('company'), 'cCompanyName');
        $crud->set_relation('CurDivisiID', $this->cms_complete_table_name('div'), 'cDivName');
        $crud->set_relation('CurDeptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        $crud->set_relation('CurUnitID', $this->cms_complete_table_name('unit'), 'NamaUnit');
        $crud->set_relation('CurJabatanID', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');
        $crud->set_relation('NewJabatanID', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');
        //$crud->set_relation('StatusDiri', $this->cms_complete_table_name('StatusDiri'), 'StatusDiriName');
        //$crud->set_relation('Agama', $this->cms_complete_table_name('Agama'), 'agama_name');

      	
			
		$crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));
        $crud->callback_column('NIK',array($this,'_callback_column_NIK'));
        $crud->callback_column('TglIssue',array($this,'_callback_column_TglIssue'));
        //$crud->callback_column('TglActive2',array($this,'_Date2_call'));
        $crud->callback_column('NIK2',array($this,'_callback_column_NIK2'));
        $crud->callback_column('FormStatus',array($this,'_callback_column_FormStatus'));

        $crud->callback_add_field('NIK', array($this, '_callback_add_field_NIK'));
        $crud->callback_add_field('FormStatus', array($this, '_callback_add_field_FormStatus'));

        $crud->callback_edit_field('NIK', array($this, '_callback_edit_field_NIK'));
        $crud->callback_edit_field('FormStatus', array($this, '_callback_edit_field_FormStatus'));

        $crud->callback_add_field('CurDivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_edit_field('CurDivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_add_field('CurDeptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_edit_field('CurDeptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_add_field('CurUnitID', array($this, 'empty_unit_dropdown_select'));
        $crud->callback_edit_field('CurUnitID', array($this, 'empty_unit_dropdown_select'));



        $this->crud = $crud;
        return $crud;
    }

    public function _example_output($output = null)
    {
        
        //echo "<script language='javascript'>window.location ='http://astapp02/hris2/bpjs/frmRegistration/index/add';</script>";
        //$this->view($this->cms_module_path().'modules/customers', $output);
        $this->view($this->cms_module_path().'/frmListP3K_view', $output,
        $this->cms_complete_navigation_name('frmListP3K'));    
    }


    public function index(){
         //echo"<script>window.open('http://astapp02/hris2/bpjs/frmRegistration/index/add');</script>";
         
        $crud = $this->make_crud();

        $dd_data = array(
                //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
                'dd_state' =>  $crud->getState(),
                //SETUP YOUR DROPDOWNS
                //Parent field item always listed first in array, in this case countryID
                //Child field items need to follow in order, e.g stateID then cityID
                'dd_dropdowns' => array('CurCompanyId','CurDivisiID','CurDeptID','CurUnitID'),
                //SETUP URL POST FOR EACH CHILD
                //List in order as per above
                'dd_url' => array('', site_url().'/sdm/frmListP3K/get_states/', site_url().'/sdm/frmListP3K/get_cities/',  site_url().'/sdm/frmListP3K/get_unit/'),
                //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
                'dd_ajax_loader' => base_url().'ajax-loader.gif'
            );  

        


      $output = $crud->render();
            $output->dropdown_setup = $dd_data;            
            $this->_example_output($output);

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //$output = $crud->render();
        //$this->view($this->cms_module_path().'/customers_view', $output,
          //  $this->cms_complete_navigation_name('Customers'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('formp3k'),array('FormP3KId'=>$id));
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
    public function _callback_column_NIK($value, $row){    
         
         $query = $this->db->query('SELECT NIK,Nama FROM tbl_profile WHERE NIK='.$row->NIK);
     
       foreach ($query->result() as $rown){
        //return $row->Nama.'Ku';
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->FormP3KId)."'>".$rown->Nama."</a>";
        
        }   //return 

        //return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->CutiId)."'>".$row->CutiId."</a>";
       
        
    }

    // change dPeriodEndDate format to d-M-Y
    public function _callback_column_TglIssue($value, $row)
    {
        //return $value." - scale: <b>".$row->date."</b>";
        $Date1 = date('d-M-Y', strtotime($row->TglIssue));
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


    public function _callback_column_NIK2($value, $row){    
        return $row->NIK;        
    }

    public function _callback_column_FormStatus($value, $row)
    {     
     //return $value;
     //$query2 = $this->db->query('SELECT * FROM tbl_main_user WHERE user_id=2');
     $query2 = $this->db->query('SELECT * FROM tbl_statusform WHERE CodeStatusForm="'.$value.'"');
                           
     foreach ($query2->result() as $rown){       
            return '<span style="background-color:'.$rown->ColourStatusForm.'"><b>'.$rown->NamaStatusForm.'</b></span>';
      
       
     }     

        
    }


    public function _callback_add_field_NIK()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK" class="chosen-select" data-placeholder="Select Karyawan" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
          
            //GET THE CITIES PER STATE ID 

            $this->db->select('*')
                     ->from('tbl_profile');
                    // ->where('pisa_id !=',1);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
             $empty_select .= '<option value="" disabled selected>Select Karyawan</option>';

            foreach($db->result() as $row):               
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->NIK.' - '.$row->Nama.'</option>';
                
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;

        
    }


    public function _callback_add_field_FormStatus()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="FormStatus" class="chosen-select" data-placeholder="Select Status" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        //$listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
          
            //GET THE CITIES PER STATE ID 

            $this->db->select('*')
                     ->from('tbl_statusform');
                    // ->where('pisa_id !=',1);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select Status</option>';

            foreach($db->result() as $row):               
                    $empty_select .= '<option value="'.$row->CodeStatusForm.'">'.$row->NamaStatusForm.'</option>';
                
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;

        
    }

    public function _callback_edit_field_FormStatus($value, $row)
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="FormStatus" class="chosen-select" data-placeholder="Select Status" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        
            //GET THE STORED STATE ID
            $this->db->select('*')
                     ->from('tbl_formp3k')
                     ->where('FormP3KId', $listingID)
                     //->where('PISA', 1)
                     ->limit(0,1);

            $db = $this->db->get();
            $row = $db->row(0);
           
            $FormStatus = $row->FormStatus;
            //$KDFaskes = $row->KDFaskesGigi;
            //$KDFaskes = $row->KDFaskes;
          
            //GET THE CITIES PER STATE ID 

            $this->db->select('*')
                     ->from('tbl_statusform');
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            
            foreach($db->result() as $row):
                if($row->CodeStatusForm == $FormStatus) {
                    $empty_select .= '<option value="'.$row->CodeStatusForm.'" selected="selected">'.$row->NamaStatusForm.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->CodeStatusForm.'">'.$row->NamaStatusForm.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;

        
    }


    public function _callback_edit_field_NIK($value, $row)
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK" class="chosen-select" data-placeholder="Select Karyawan" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        
            //GET THE STORED STATE ID
            $this->db->select('*')
                     ->from('tbl_formp3k')
                     ->where('FormP3KId', $listingID)
                     //->where('PISA', 1)
                     ->limit(0,1);

            $db = $this->db->get();
            $row = $db->row(0);
           
            $NIK = $row->NIK;
            //$KDFaskes = $row->KDFaskesGigi;
            //$KDFaskes = $row->KDFaskes;
          
            //GET THE CITIES PER STATE ID 

            $this->db->select('*')
                     ->from('tbl_profile');
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            
            foreach($db->result() as $row):
                if($row->NIK == $NIK) {
                    $empty_select .= '<option value="'.$row->NIK.'" selected="selected">'.$row->NIK.' - '.$row->Nama.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->NIK.' - '.$row->Nama.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;

        
    }


    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="CurDivisiID" class="chosen-select" data-placeholder="Select Division" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('CurCompanyId, CurDivisiID, CurDeptID')
                     ->from('tbl_formp3k')
                     ->where('FormP3KId', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $CurCompanyId = $row->CurCompanyId;
            $CurDivisiID = $row->CurDivisiID;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('tbl_div')
                     ->where('iDivCompany', $CurCompanyId);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iDivId == $CurDivisiID) {
                    $empty_select .= '<option value="'.$row->iDivId.'" selected="selected">'.$row->cDivName.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->iDivId.'">'.$row->cDivName.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }

    public function empty_city_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="CurDeptID" class="chosen-select" data-placeholder="Select Departement" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('CurCompanyId, CurDivisiID, CurDeptID, CurUnitID')
                     ->from('tbl_formp3k')
                     ->where('FormP3KId', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $CurDivisiID = $row->CurDivisiID;
            $CurDeptID = $row->CurDeptID;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_dept')
                     ->where('iDeptDivID', $CurDivisiID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iDeptID == $CurDeptID) {
                    $empty_select .= '<option value="'.$row->iDeptID.'" selected="selected">'.$row->cDeptName.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->iDeptID.'">'.$row->cDeptName.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }

    public function empty_unit_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="CurUnitID" class="chosen-select" data-placeholder="Select Unit" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('CurCompanyId, CurDivisiID, CurDeptID, CurUnitID')
                     ->from('tbl_formp3k')
                     ->where('FormP3KId', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $CurDivisiID = $row->CurDivisiID;
            $CurDeptID = $row->CurDeptID;
            $CurUnitID = $row->CurUnitID;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_unit')
                     ->where('unitID', $CurUnitID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->unitID == $CurUnitID) {
                    $empty_select .= '<option value="'.$row->unitID.'" selected="selected">'.$row->NamaUnit.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->unitID.'">'.$row->NamaUnit.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }
                
    //GET JSON OF STATES
    public function get_states()
    {
        $CurCompanyId = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_div')
                 ->where('iDivCompany', $CurCompanyId);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iDivId, "property" => $row->cDivName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }
    
    //GET JSON OF CITIES
    public function get_cities()
    {
        $CurDivisiID = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_dept')
                 ->where('iDeptDivID', $CurDivisiID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iDeptID, "property" => $row->cDeptName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }

    public function get_unit()
    {
        $CurUnitID = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_unit')
                 ->where('unitID', $CurUnitID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->unitID, "property" => $row->NamaUnit);
        endforeach;
        
        echo json_encode($array);
        exit;
    }



  




}