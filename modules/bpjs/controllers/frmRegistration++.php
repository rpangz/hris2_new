<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Master_Company
 *
 * @author No-CMS Module Generator
 */
class frmRegistration extends CMS_Priv_Strict_Controller {

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
        $crud->unset_texteditor('Alamat_Tinggal');
        
        

        // $crud->unset_add();
        // $crud->unset_edit();
        // $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        $crud->unset_export();
        //$crud->unset_table();

        
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
      

		$crud->set_table($this->cms_complete_table_name('bpjs'));
        //$crud->set_rules('email', 'email','trim|required|xss_clean|callback_email_check');

        //$where = "iTransPeriodId =".$this->uri->segment(4)." AND cTransCode LIKE".$this->uri->segment(5);
        //$crud->where($where);

        //$crud->where('iTransPeriodId', $this->uri->segment(4));
        //$crud->like('cTransCode',$this->uri->segment(4));
        if ($session_id !="" || is_null($session_id)){
            $crud->where('aktif', 1);

        }

    
        //$crud->where('cTransCode', $this->uri->segment(5));

        //$crud->order_by('DeptID','ASC');
        // primary key
        $crud->set_primary_key('bpjs_Id');

        $crud->set_subject('Registration');


        //$crud->unset_add_fields('iTransCreateBy','dTransCreateTime');
        //$crud->unset_edit_fields('iTransUpdateBy','dTransUpdatetime');

        //$crud->field_type('iTransCreateBy', 'hidden', $session_id);
        //$crud->field_type('dTransCreateTime', 'hidden', $today);
        //$crud->field_type('iTransUpdateBy', 'hidden', $session_id);
        //$crud->field_type('dTransUpdatetime', 'hidden', $today);

        $crud->columns('No_KK','No_KTP','NIK','Nama','PISA','Tgl_Lahir','Tempat_Lahir','Sex','Status_Kawin',
                            'Alamat_Tinggal','No_RT','No_RW','Kode_Pos','Kode_Kec','Kode_Desa','Kode_FaskesTk1',
                            'Nama_FaskesTk1','Kode_FaskesGigi','Nama_FaskesGigi','Nomor_Telp','email','Jabatan',
                            'Status_Karyawan','Kelas_Rawat','TMT','Gaji','Kewarganegaraan','No_NPWP',
                            'No_Passport','Asuransi_Lainnya','companyID','divisionID','deptID');


        $crud->edit_fields('No_KK','No_KTP','NIK','Nama','PISA','Tgl_Lahir','Tempat_Lahir','Sex','Status_Kawin',
                            'Alamat_Tinggal','No_RT','No_RW','Kode_Pos','Kode_Kec','Kode_Desa','Kode_FaskesTk1',
                            'Nama_FaskesTk1','Kode_FaskesGigi','Nama_FaskesGigi','Nomor_Telp','email','Jabatan',
                            'Status_Karyawan','Kelas_Rawat','TMT','Gaji','Kewarganegaraan','No_NPWP',
                            'No_Passport','Asuransi_Lainnya','companyID','divisionID','deptID');


        $crud->add_fields('No_KK','No_KTP','NIK','Nama','PISA','Tgl_Lahir','Tempat_Lahir','Sex','Status_Kawin',
                            'Alamat_Tinggal','No_RT','No_RW','Kode_Pos','Kode_Kec','Kode_Desa','Kode_FaskesTk1',
                            'Nama_FaskesTk1','Kode_FaskesGigi','Nama_FaskesGigi','Nomor_Telp','email','Jabatan',
                            'Status_Karyawan','Kelas_Rawat','TMT','Gaji','Kewarganegaraan','No_NPWP',
                            'No_Passport','Asuransi_Lainnya','companyID','divisionID','deptID');
            
       
        $crud->display_as('No_KK','No KK');
        $crud->display_as('No_KTP','No KTP');
        $crud->display_as('NIK','NIK');
        $crud->display_as('Nama','Nama Lengkap');
        $crud->display_as('PISA','PISA');
        $crud->display_as('Sex','Sex');
        $crud->display_as('Status_Kawin','Status Kawin');
        $crud->display_as('companyID','Company');
        $crud->display_as('divisionID','Division');
        $crud->display_as('deptID','Departement');




        $crud->required_fields('No_KK','No_KTP','NIK','Nama','PISA','Tgl_Lahir','Tempat_Lahir','Sex','Status_Kawin',
                            'Alamat_Tinggal','No_RT','No_RW','Kode_Pos','Kode_Kec','Kode_Desa','Kode_FaskesTk1',
                            'Nama_FaskesTk1','Kode_FaskesGigi','Nama_FaskesGigi','Nomor_Telp','email','Jabatan',
                            'Status_Karyawan','Kelas_Rawat','TMT','Gaji','Kewarganegaraan','No_NPWP',
                            'No_Passport','Asuransi_Lainnya','companyID','divisionID','deptID');


        

        //$crud->unique_fields('NIK','No_KK');

        $crud->set_relation('Sex', $this->cms_complete_table_name('bpjs_sex'), 'SexName');
        $crud->set_relation('Status_Kawin', $this->cms_complete_table_name('bpjs_statuskawin'), 'StatusDiriName');
        $crud->set_relation('PISA', $this->cms_complete_table_name('bpjs_pisa'), 'pisa_name');
        $crud->set_relation('Kelas_Rawat', $this->cms_complete_table_name('bpjs_kelas'), 'kelas_name');
        $crud->set_relation('Status_Karyawan', $this->cms_complete_table_name('bpjs_status'), 'StatusName');
        $crud->set_relation('Kewarganegaraan', $this->cms_complete_table_name('bpjs_nation'), 'nation_name');
        $crud->set_relation('Jabatan', $this->cms_complete_table_name('bpjs_jabatan'), 'NamaJabatan');
        $crud->set_relation('companyID', $this->cms_complete_table_name('bpjs_company'), 'cCompanyName');
        //$crud->set_relation('typeID','tbl_type','cTypeName');

        //$crud->field_type('bTransStatus','enum',array('0','READY','1','OUT'));
        //$crud->field_type('bTransStatus', 'true_false', array('Returned', 'Out'));

        //$crud->set_relation('typeID','tbl_type','cTypeName');  
            
            //IF YOU HAVE A LARGE AMOUNT OF DATA, ENABLE THE CALLBACKS BELOW - FOR EXAMPLE ONE USER HAD 36000 CITIES AND SLOWERD UP THE LOADING PROCESS. THESE CALLBACKS WILL LOAD EMPTY SELECT FIELDS THEN POPULATE THEM AFTERWARDS
            

        

      
        $crud->callback_column('NamaUnit',array($this,'_callback_webpage_url'));
        
        //$crud->add_action('print', '', '','ui-icon-image',array($this,'just_a_test'));
        //$crud->add_action('More', '', 'demo/action_more','ui-icon-plus');
        //$crud->add_action('Smileys', 'http://astapp02/i-MAM2/assets/grocery_crud/themes/flexigrid/css/images/print.png', 'demo/action_smiley');
        //Z:\xampp\htdocs\i-MAM2\assets\grocery_crud\themes\flexigrid\css\images
      	
			
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

      

        



        

        $this->crud = $crud;
        return $crud;
    }

    public function _example_output($output = null)
    {
        //$this->view($this->cms_module_path().'modules/customers', $output);
        $this->view($this->cms_module_path().'/frmRegistration_view', $output,
        $this->cms_complete_navigation_name('frmRegistration'));    
    }


    

    public function index(){
        $crud = $this->make_crud();

        $dd_data = array(
                //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
                'dd_state' =>  $crud->getState(),
                //SETUP YOUR DROPDOWNS
                //Parent field item always listed first in array, in this case countryID
                //Child field items need to follow in order, e.g stateID then cityID
                'dd_dropdowns' => array('companyID','divisionID','deptID'),
                //SETUP URL POST FOR EACH CHILD
                //List in order as per above
                'dd_url' => array('', site_url().'/bpjs/frmRegistration/get_states/', site_url().'/bpjs/frmRegistration/get_cities/'),
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
                    $this->db->delete($this->cms_complete_table_name('unit'),array('unitID'=>$id));
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
    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->customerNumber)."'>$value</a>";
        
    }


    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="divisionID" class="chosen-select" data-placeholder="Select Division" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('companyID, divisionID, deptID')
                     ->from('tbl_unit')
                     ->where('unitID', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $companyID = $row->companyID;
            $divisionID = $row->divisionID;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('tbl_div')
                     ->where('iDivCompany', $companyID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iDivId == $divisionID) {
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
        $empty_select = '<select name="deptID" class="chosen-select" data-placeholder="Select Departement" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('companyID, divisionID, deptID, unitID')
                     ->from('tbl_unit')
                     ->where('unitID', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $divisionID = $row->divisionID;
            $deptID = $row->deptID;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_dept')
                     ->where('iDeptDivID', $divisionID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iDeptID == $deptID) {
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
                
    //GET JSON OF STATES
    public function get_states()
    {
        $companyID = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_div')
                 ->where('iDivCompany', $companyID);
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
        $divisionID = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_dept')
                 ->where('iDeptDivID', $divisionID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iDeptID, "property" => $row->cDeptName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }



   


     // add hyperlink
    public function _callback_webpage_url($value, $row){        
    
        return "<a href='".site_url($this->cms_module_path().'/frmRegistration/index/edit/'.$row->unitID)."'>$value</a>";
        
    }

   




   


   







}

