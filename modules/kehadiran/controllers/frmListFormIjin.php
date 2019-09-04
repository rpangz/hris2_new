<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Master_Company
 *
 * @author No-CMS Module Generator
 */
class frmListFormIjin extends CMS_Priv_Strict_Controller {

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
        $today = date('Y-m-d H:i:s');
        $company_id = $this->cms_get_config('cms_jasnikom_id');
        $hrd_modules = $this->cms_get_config('hrd_cuti_modules');

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
		$crud->unset_texteditor('Alasan');
        $crud->unset_texteditor('Alamat');
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
            $crud->set_relation('NIK', $this->cms_complete_table_name('profile'), 'NIK',array('bStatus' => 1));
            $crud->display_as('NIK','NIK');
        }

        else {
            $crud->set_relation('NIK', $this->cms_complete_table_name('profile'), 'Nama',array('bStatus' => 1,'NIK' => $this->uri->segment(5)));
            $crud->display_as('NIK','Nama');
        }
        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_country_model');
        */
        $DivisiID = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$session_nik'"));
        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->cms_complete_table_name('formijin'));

        $list = $this->uri->segment(4);
        if ($this->uri->segment(4) !=0 && !is_null($this->uri->segment(4)) && isset($list)){
            $crud->where('JenisIjin', $this->uri->segment(4));
            //$crud->where('tbl_formijin.companyID !=', 2);
        }
        else {
            $crud->where('JenisIjin >=', 0);
            //$crud->where('tbl_formijin.companyID !=', 2);
        }

        if($this->uri->segment('4') =='' || $this->uri->segment('4') =='0' || $this->uri->segment('5') =='0'){
            $crud->unset_add();
            //$crud->unset_edit();

        }

        $list5 = $this->uri->segment(5);

        if ($this->uri->segment(5) !=0 && !is_null($this->uri->segment(5)) && isset($list5)){            
            $crud->where('tbl_formijin.NIK', $this->uri->segment(5));           
        }
        else {           
            $crud->where('tbl_formijin.NIK >', 0);
           
        }


        //$crud->where('DivisiID', $DivisiID['DivisiID']);
        //$crud->order_by('FormCutiNIK', 'ASC');
        //$crud->order_by('FormCutiId', 'ASC');

        // primary key
        $crud->set_primary_key('IjinId');

        $jka = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jenisijin WHERE JenisIjinId = '$list'"));
        if ($jka['JenisIjinId'] !=0){
            $nmc = $jka['JenisIjinName'];
        }
        else{
            $nmc = '';
        }

        $crud->set_subject('Form Ijin '.$nmc);


        $crud->unset_add_fields('CreatedBy','CreatedTime','Tgl1','Tgl2','Apv1','Apv2','ApvLevel','StatusForm');
        $crud->field_type('CreatedBy', 'hidden', $session_nik);
        $crud->field_type('CreatedTime', 'hidden', $today);
        $crud->field_type('Tgl1', 'hidden', $today);
        $crud->field_type('Tgl2', 'hidden', $today);
        $crud->field_type('Apv1', 'hidden', 'A');
        $crud->field_type('Apv2', 'hidden', 'A');
        $crud->field_type('ApvLevel', 'hidden', 2);
        $crud->field_type('StatusForm', 'hidden', 'A');


            $cm        = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$session_nik));
            $companyID = $cm['CompanyId'];
            $crud->unset_add_fields('companyID');
            $crud->field_type('companyID', 'hidden', $companyID);
       


        // displayed columns on list
		
		$crud->edit_fields('NIK','JenisIjin','Alasan','StatusForm');


        if (!is_null($this->uri->segment('5'))){
            $NIKKI = $this->uri->segment('5');
           
            $cm        = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$NIKKI));
            $companyID = $cm['CompanyId'];
            $DeptID    = $cm['DeptID'];
           

        }else{
            $NIKKI     = 0;
            $DeptID    = 0;
            $companyID = 0;
            //$crud->set_relation('FormCutiNIK', $this->cms_complete_table_name('profile'), 'Nama',array('NIK >' => $NIKKI));
        }

        

        if ($list==1 || $list==2 || $list==3){
            $crud->add_fields('JenisIjin','NIK','TglActive1','Alasan','NIK1','NIK2','SendMail','CreatedBy','CreatedTime','Tgl1','Tgl2','Apv1','Apv2','ApvLevel','StatusForm','companyID');
            $crud->display_as('TglActive1','Tanggal / Pukul');

            $crud->columns('NIK','NIKKI','TglActive1','JenisIjin','Alasan','ApvLevel','StatusForm');


        }
        elseif ($list==5 || $list==6){
           $crud->add_fields('JenisIjin','NIK','TglActive1','TglActive2','Alasan','NIK1','NIK2','SendMail','CreatedBy','CreatedTime','Tgl1','Tgl2','Apv1','Apv2','ApvLevel','StatusForm','companyID');

           $crud->display_as('TglActive1','@From DateTime');
           $crud->display_as('TglActive2','@To DateTime');

           $crud->columns('NIK','NIKKI','TglActive1','TglActive2','JenisIjin','Alasan','ApvLevel','StatusForm');


        }
        else {
           $crud->add_fields('JenisIjin','NIK','TglActive1','TglActive2','Alasan','NIK1','NIK2','SendMail','CreatedBy','CreatedTime','Tgl1','Tgl2','Apv1','Apv2','ApvLevel','StatusForm','companyID');

           $crud->display_as('TglActive1','@From DateTime');
           $crud->display_as('TglActive2','@To DateTime');

           $crud->columns('NIK','NIKKI','TglActive1','JenisIjin','Alasan','ApvLevel','StatusForm');
        }
		
        // displayed columns on edit operation
       
		//$crud->edit_fields('NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','Alamat','Kodepos','Telp','Hp','Email','AlamatKTP','StatusDiri','TglMenikah','TglMasuk','TglKeluar','BandSkrg','Status','CompanyId','DivisiID','DeptID','UnitID','JabatanID','JmlAnak');

		
        // displayed columns on add operation
		
		//$crud->add_fields('NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','Alamat','Kodepos','Telp','Hp','Email','AlamatKTP','StatusDiri','TglMenikah','TglMasuk','TglKeluar','BandSkrg','Status','CompanyId','DivisiID','DeptID','UnitID','JabatanID','JmlAnak');
		


        // caption of each columns		
				
        
        $crud->display_as('TglIssue','Tgl Issue');
        $crud->display_as('TglKTP','Tgl KTP');
        $crud->display_as('NIKKI','Nama');
        
        $crud->display_as('TglMasuk','Tgl Masuk');
        $crud->display_as('StatusForm','Status Form');
        $crud->display_as('SendMail','Email to user');
       
        $crud->display_as('DivisiID','Division');
        $crud->display_as('DeptID','Departemen');
        $crud->display_as('UnitID','Unit');
        $crud->display_as('NIK1','Menyetujui');
        $crud->display_as('NIK2','Mengetahui');
        $crud->display_as('ApvLevel','Approval');
        $crud->display_as('TglLahir','Tgl Lahir');
        $crud->display_as('TglMenikah','Tgl Menikah');
        $crud->display_as('TglKeluar','Tgl Keluar');
        $crud->display_as('JenisIjin','Jenis Ijin');

				
		
		// $crud->required_fields( $field1, $field2, $field3, ... );
		$crud->required_fields('JenisIjin','NIK','TglActive1','TglActive2','Alasan','NIK1','NIK2','SendMail');
       
		
		//$crud->unique_fields( $field1, $field2, $field3, ... );
		//$crud->unique_fields('NIK');
       		

		//$crud->set_relation('NIK', $this->cms_complete_table_name('profile'), '{Nama}');
        
        $crud->set_relation('JenisIjin', $this->cms_complete_table_name('jenisijin'), 'JenisIjinName',array('JenisIjinId !=' => 0));
        //$crud->set_relation('NIK2', $this->cms_complete_table_name('apv_hrd'), '{hrd_name} [{hrd_email}]',array('hrd_status' => 1));
        $crud->set_primary_key('hrd_nik',$this->cms_complete_table_name('apv_hrd'));
        $crud->set_relation('NIK2', $this->cms_complete_table_name('apv_hrd'), '{hrd_name}',array('hrd_status' => 1, 'hrd_modules' => $hrd_modules, 'hrd_company' => $companyID));
        //$crud->set_relation('CompanyId', $this->cms_complete_table_name('company'), 'cCompanyCode');
        //$crud->set_relation('DivisiID', $this->cms_complete_table_name('div'), 'cDivName');
        //$crud->set_relation('DeptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        //$crud->set_relation('UnitID', $this->cms_complete_table_name('unit'), 'NamaUnit');
       // $crud->set_relation('JabatanID', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');

        //$crud->set_relation('StatusDiri', $this->cms_complete_table_name('StatusDiri'), 'StatusDiriName');
        //$crud->set_relation('Agama', $this->cms_complete_table_name('Agama'), 'agama_name');

      	$crud->field_type('SendMail','true_false',array('No','Yes'));
			
		$crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $crud->callback_add_field('JenisIjin', array($this, '_callback_add_field_JenisIjin'));
        //$crud->callback_add_field('NIK1', array($this, '_callback_add_field_NIK1'));
        $crud->callback_edit_field('NIK1', array($this, '_callback_edit_field_NIK1'));

        //$crud->callback_column('FormCutiNIK',array($this,'_callback_edit_url'));
        //$crud->callback_column('TglActive1',array($this,'_Date1_call'));
        //$crud->callback_column('TglActive2',array($this,'_Date2_call'));
        $crud->callback_column('NIKKI',array($this,'_callback_column_NIKKI'));
        $crud->callback_column('StatusForm',array($this,'_callback_column_StatusForm'));
        $crud->callback_column('ApvLevel',array($this,'_callback_column_ApvLevel'));
        //$crud->callback_column('DivisiID',array($this,'_callback_column_DivisiID'));
        $crud->callback_add_field('NIK1', array($this, 'empty_state_dropdown_select'));
        //$crud->callback_edit_field('NIK1', array($this, 'empty_state_dropdown_select'));

        //$crud->callback_column('Print',array($this,'_callback_column_Print'));
        $crud->add_action('Print', 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/images/print1.png', '','http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/images/print1.png',array($this,'_callback_column_Print'));

        $this->crud = $crud;
        return $crud;
    }

    public function _example_output($output = null){
        //$this->view($this->cms_module_path().'modules/customers', $output);
        $this->view($this->cms_module_path().'/frmListFormIjin_view', $output,
        $this->cms_complete_navigation_name('frmListFormIjin'));    
    }


    

    public function index(){
        $crud = $this->make_crud();

        $dd_data = array(
                //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
                'dd_state' =>  $crud->getState(),
                //SETUP YOUR DROPDOWNS
                //Parent field item always listed first in array, in this case countryID
                //Child field items need to follow in order, e.g stateID then cityID
                'dd_dropdowns' => array('NIK','NIK1'),
                //SETUP URL POST FOR EACH CHILD
                //List in order as per above
                'dd_url' => array('', site_url().'/kehadiran/frmListFormIjin/get_states/', site_url().'/kehadiran/frmListFormIjin/get_cities/'),
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
                    $this->db->delete($this->cms_complete_table_name('formijin'),array('IjinId'=>$id));
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
        $ID       = $primary_key;
        $SendMail = $post_array['SendMail'];
        $NIK      = $post_array['NIK'];

        if ($SendMail ==1){
            include "http://$_SERVER[SERVER_NAME]/hris2/includes/mailer/frmListFormIjin/SendMailUser.php?id=$ID&nik=$NIK";
            echo "<script language='javascript'>alert('Data Sudah Disimpan dan Email sudah dikirim...');history.go(-1);</script>";
            return $success;
        }
        else{
            return $success;
        }
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
         
         $query = $this->db->query('SELECT NIK,Nama FROM tbl_profile WHERE NIK='.$row->FormCutiNIK);


     
       foreach ($query->result() as $rown){
        //return $row->Nama.'Ku';
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->CutiId)."'>".$rown->Nama."</a>";
        
        }   //return 

        //return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->CutiId)."'>".$row->CutiId."</a>";
       
        
    }

    // add hyperlink
    public function _callback_column_NIKKI($value, $row){

        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('profile'))
            ->join('tbl_formijin', 'tbl_profile.NIK = tbl_formijin.NIK')      
            ->where('tbl_formijin.NIK', $row->NIK)
            ->where('IjinId', $row->IjinId)
            ->get();          

    
        foreach ($query->result() as $rown){
            return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/'.$row->JenisIjin.'/edit/'.$row->IjinId)."'>$rown->Nama</a>";
        }
   
    
        
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


    public function _callback_column_NIK($value, $row){    
        return $row->FormCutiNIK;        
    }

    public function _callback_column_StatusForm($value, $row){   

     
     //return $value;
     //$query2 = $this->db->query('SELECT * FROM tbl_main_user WHERE user_id=2');
     $query2 = $this->db->query('SELECT * FROM tbl_statusform WHERE CodeStatusForm="'.$value.'"');
                           
     foreach ($query2->result() as $rown){       
            //return '<span style="background-color:'.$rown->ColourStatusForm.'"><b>'.$rown->NamaStatusForm.'</b></span>';
            return '<span style="background-color:'.$rown->ColourStatusForm.';color:'.$rown->FontColourForm.'"><b>'.$rown->NamaStatusForm.'</b></span>';
      
       
     }     

        
    }


    public function _callback_column_ApvLevel($value, $row){   
    
    $query2 = $this->db->query('SELECT * FROM tbl_apv_matrik_approval WHERE MatProses="'.$value.'" AND MatCode=4');
                           
     foreach ($query2->result() as $rown){       
            return $rown->MatName;
       
     }       
    }


    public function _callback_column_DivisiID($value, $row){    
         
         $query = $this->db->query('SELECT * FROM tbl_profile INNER JOIN 
                                    tbl_div ON tbl_profile.DivisiID = tbl_div.iDivId 
                                    WHERE NIK='.$row->FormCutiNIK);
     
       foreach ($query->result() as $rown){
        //return $row->Nama.'Ku';
        return $rown->cDivName;
        
        }   //return 

        //return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->CutiId)."'>".$row->CutiId."</a>";
       
        
    }

    // Add Type
    public function _callback_add_field_JenisIjin(){
      
        $stateID = $this->uri->segment(4);
        $query = $this->db->query('SELECT * FROM tbl_jenisijin WHERE JenisIjinId='.$stateID);  


       foreach ($query->result() as $row){
        return "$row->JenisIjinName<input type='hidden' maxlength='50' value='" . $row->JenisIjinId. "' name='JenisIjin'>";
        }   //return $array;

        
    }



    


    //CALLBACK FUNCTIONS
    public function _callback_edit_field_NIK1(){
            //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK1" class="chosen-select" data-placeholder="Select Mengetahui" style="width: 300px; display: none;">';
        $empty_select_closed= '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();

        $session_nik = $this->cms_user_id();
        
        $dta = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = $session_nik"));
        //$data = mysql_fetch_array($edit);
        /*
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))
            ->join('tbl_bpjs_kelas', 'tbl_bpjs.Kelas_Rawat = tbl_bpjs_kelas.kelas_id')          
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();  

        */
            $this->db->select('*')
                     ->from('tbl_formperpcuti')
                     ->where('FormPerpCutiId', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $NIK1 = $row->NIK1;

            //GET THE CITIES PER STATE ID 

            $this->db->select('tbl_profile.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_profile.Email AS Email')
                     ->from($this->cms_complete_table_name('apv_group_approval'))
                     ->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID',$dta['DeptID'])
                     ->order_by('iGroupApprovalListId','ASC');

            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select Mengetahui</option>';

            foreach($db->result() as $row):

                if($row->NIK == $NIK1) {
                    $empty_select .= '<option value="'.$row->NIK.'" selected="selected">'.$row->Nama.'</option>';
                    //$empty_select .= '<option value="'.$row->NIK.'" selected="selected">'.$row->Nama.' ['.$row->Email.']</option>';
                } else {
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.'</option>';
                }

                    //$empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.' ['.$row->Email.']</option>';
                
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;
    }



    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK1" class="chosen-select" data-placeholder="Select Menyetujui" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        $today = date('Y-m-d');
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit"){
            //GET THE STORED STATE ID
            $this->db->select('*')
                     ->from('tbl_formijin')
                     ->where('IjinId', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $NIK = $row->NIK;
            $NIK1 = $row->NIK1;
            $JenisIjin = $row->JenisIjin;

            $jka       = mysql_fetch_array(mysql_query('SELECT * FROM tbl_profile WHERE NIK="'.$listingID.'"'));
            $deptID    = $jka['DeptID'];
            $companyID = $jka['CompanyId'];
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('tbl_apv_group_approval')
                     //->join('tbl_profile')
                     ->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK') 
                     ->where('tbl_apv_group_approval.deptID', $deptID)
                     ->where('tbl_apv_group_approval.companyID', $companyID);;
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->NIK == $NIK) {
                    $empty_select .= '<option value="'.$row->NIK.'" selected="selected">'.$row->NIK.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->NIK.'</option>';
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
    public function get_states(){
        
        $NIK       = $this->uri->segment(5);
        $jka       = mysql_fetch_array(mysql_query('SELECT * FROM tbl_profile WHERE NIK="'.$NIK.'"'));
        $deptID    = $jka['DeptID'];
        $companyID = $jka['CompanyId'];

        $today = date('Y-m-d');
        
        $this->db->select("*")
                 ->from('tbl_apv_group_approval')
                 //->join('tbl_profile','tbl_apv_group_approval.NIK=tbl_profile.NIK') 
                 ->where('deptID', $deptID)
                 ->where('companyID', $companyID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $nn       = mysql_fetch_array(mysql_query('SELECT * FROM tbl_profile WHERE NIK="'.$row->NIK.'"'));
            $Nama     = $nn['Nama'];
            $Email    = $nn['Email'];           

            $array[] = array("value" => $row->NIK ,"property" => $Nama);
        endforeach;
        
        echo json_encode($array);
        exit;
    }

    public function _callback_column_NIKKIXX($value, $row){
        return $row->NIK;
        
    }


    // add hyperlink
    public function _callback_column_Print($value, $row){      

        return "javascript:window.open('".site_url('includes/export/frmListFormIjin/Export2Html.php') .'?id='.$row->IjinId. "', 'Export', 'width=950, height=' + screen.height + ', top=0, left=0,scrollbars=yes,resizable=yes,copyhistory=no,menubar=no,location=no,toolbar=no,directories=0,titlebar=0,status=no', false);void(0)";        
       
        
    }


  




}