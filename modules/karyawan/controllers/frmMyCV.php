<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Master_Company
 *
 * @author No-CMS Module Generator
 */
class frmMyCV extends CMS_Priv_Strict_Controller {

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
       // $crud->set_theme('flexigrid');
        $session_nik = $this->cms_user_id();
        $_SESSION['NIK'] = $session_nik;        
        $today       = date('Y-m-d H:i:s');

        $hrd_modules = $this->cms_get_config('hrd_profile_modules');

        // this is just for code completion
        if (FALSE) $crud = new Extended_Grocery_CRUD();

        //$config['grocery_crud_file_upload_allow_file_types'] = 'gif|jpeg|jpg|png|tiff';
        //$crud->config->set_item('grocery_crud_file_upload_allow_file_types','gif|jpeg|jpg|png');
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
		$crud->unset_texteditor('AlamatDomisili');
        $crud->unset_texteditor('AlamatKTP');
		
        $crud->unset_add();
        // $crud->unset_edit();
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        $crud->unset_export();

        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_country_model');
        */

        $my_profile = $this->_callback_my_profile();
        $crud->add_action('form_update_changes', '', 'showitems/green');
        $crud->set_lang_string('form_update_changes','Process');  


        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('no-search-flexigrid');
            $crud->set_relation('CompanyId', $this->cms_complete_table_name('company'), 'cCompanyCode');
            $crud->display_as('NoBPJSKes','Nomor BPJS Kesehatan');
            $crud->display_as('member','Anggota Keluarga');
            // $crud->set_table($this->cms_complete_table_name('profile_temp')); 
            //$crud->unset_edit();
        }else{
            $crud->set_theme('no-flexigrid_1');
            $crud->set_relation('CompanyId', $this->cms_complete_table_name('company'), 'cCompanyName');
            $crud->display_as('NoBPJSKes','Nomor BPJS Kesehatan (Bagi Yg sudah punya kartu)');
            $crud->display_as('member','Anggota Keluarga (Maksimal 3 Anak & 1 Suami/Istri)');

            $crud->set_primary_key('hrd_nik',$this->cms_complete_table_name('apv_hrd'));
            $crud->set_relation('NIK2', $this->cms_complete_table_name('apv_hrd'), '{hrd_name} [{hrd_email}]',array('hrd_status' =>1,'hrd_company' => $my_profile['company'], 'hrd_modules' => $hrd_modules));
            
            //$crud->set_table($this->cms_complete_table_name('profile_temp'));

        }

       


        if ($this->uri->segment(5) != $session_nik){
            //$crud->set_theme('flexigrid');
            $crud->unset_edit();
            //$crud->unset_read();
        }

        /*if ($state =='edit'){

            $result = mysql_query("SELECT `ProfileId`, `NIK`, `NoKTP`, `TglKTP`, `Photos`, `NoKK`, `Nama`, `Sex`, `Agama`, `TglLahir`, 
                `TptLahir`, `NamaIbuKandung`, `AlamatKTP`, `CityKTP`, `KodeposKTP`, `AlamatDomisili`, `CityDomisili`, `NoRT`, 
                `NoRW`, `Kodepos`, `Telp`, `Hp`, `Fax`, `Email`, `EmailPribadi`, `StatusDiri`, `TglMenikah`, `NoNPWP`, 
                `NoKPJ`, `NoBPJSKes`, `TglMasuk`, `TglKeluar`, `TglBatasKerja`, `BandLalu`, `BandSkrg`, `Status`, `bStatus`, 
                `JabatanID`, `JobId`, `CompanyId`, `DivisiID`, `DeptID`, `UnitID`, `SeksiID`, `JmlAnak`, `Quit`, `BloodType`, 
                `LicType`, `LicNo`, `KPA`, `AcctBankName`, `AcctBankNo`, `DateModify`, `WebRoleId`, `ApprovalId`, 
                `TermsAndConditions`, `NIK1`, `NIK2`, `CreatedBy`, `CreatedTime`, `UpdatedBy`, `UpdatedTime`, `member` 
                FROM `tbl_profile_temp` WHERE NIK ='$session_nik'");

                $total  = mysql_num_rows($result);

            if ($total == 0){

                    $sql = mysql_query("SELECT `NIK`, `NoKTP`, `TglKTP`, `Photos`, `NoKK`, `Nama`, `Sex`, `Agama`, `TglLahir`, 
                        `TptLahir`, `NamaIbuKandung`, `AlamatKTP`, `CityKTP`, `KodeposKTP`, `AlamatDomisili`, `CityDomisili`, `NoRT`, 
                        `NoRW`, `Kodepos`, `Telp`, `Hp`, `Fax`, `Email`, `EmailPribadi`, `StatusDiri`, `TglMenikah`, `NoNPWP`, 
                        `NoKPJ`, `NoBPJSKes`, `TglMasuk`, `TglKeluar`, `TglBatasKerja`, `BandLalu`, `BandSkrg`, `Status`, `bStatus`, 
                        `JabatanID`, `JobId`, `CompanyId`, `DivisiID`, `DeptID`, `UnitID`, `SeksiID`, `JmlAnak`, `Quit`, `BloodType`, 
                        `LicType`, `LicNo`, `KPA`, `AcctBankName`, `AcctBankNo`, `DateModify`, `WebRoleId`, `ApprovalId`, 
                        `TermsAndConditions`, `NIK1`, `NIK2`, `CreatedBy`, `CreatedTime`, `UpdatedBy`, `UpdatedTime`, `member` 
                        FROM `tbl_profile` WHERE NIK ='$session_nik'");

                    while ($row = mysql_fetch_assoc($sql)){
                      foreach ($row as $field => $value){
                        $fields .= "$field, ";
                        $values .= "'$value', ";
                      }
                      // remove trailing ", " from $fields and $values
                      $fields = preg_replace('/, $/', '', $fields);
                      $values = preg_replace('/, $/', '', $values);

                      $sql = "INSERT INTO tbl_profile_temp ($fields) VALUES ($values)";
                      mysql_query($sql);
                    }
                    
                     echo "<script language='javascript'>location.reload();</script>";
                    //$new_id = mysql_insert_id();

            }
            else{

            } 



        }*/

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());       

        $crud->set_table($this->cms_complete_table_name('profile'));
        $crud->where('NIK', $session_nik);
        $crud->limit(1,0);

        // primary key
        $crud->set_primary_key('NIK');

        // set subject
        $crud->set_subject('Karyawan');

        // displayed columns on list
		$crud->columns('Photos','NIK','Nama','NoKTP','TglKTP','Sex','Agama','TglLahir','TptLahir','AlamatKTP','AlamatDomisili','Kodepos','Telp','Hp','BloodType','StatusDiri','NamaIbuKandung','NoNPWP','NoKPJ','NoBPJSKes','EmailPribadi','CompanyId','DivisiID','DeptID','UnitID','SeksiID','Email','member');
		
        $crud->unset_edit_fields('UpdatedBy','UpdatedTime');
        $crud->field_type('UpdatedBy', 'hidden', $session_nik);
        $crud->field_type('UpdatedTime', 'hidden', $today);
		
        
        if ($state =='edit'){
        //$crud->edit_fields('NoKTP','TglKTP','NIK','Nama','Sex','Agama','TglLahir','TptLahir','AlamatKTP','CityKTP','KodeposKTP','AlamatDomisili','CityDomisili','Kodepos','Telp','Hp','Fax','BloodType','StatusDiri','NamaIbuKandung','NoNPWP','NoKPJ','NoBPJSKes','EmailPribadi','CompanyId','DivisiID','DeptID','UnitID','SeksiID','JabatanID','JobId','Email','UpdatedBy','UpdatedTime','workexp','Education','training','technical','certification','project','Files');
        $crud->edit_fields('JobCVId','UpdatedBy','UpdatedTime','workexp','Education','training','technical','certification','project','Files','NIK1','NIK2','TermsAndConditions');

        $crud->change_field_type('Nama','readonly');
        $crud->change_field_type('NoKTP','readonly');
        $crud->change_field_type('TglKTP','readonly');
        $crud->change_field_type('Sex','readonly');
        $crud->change_field_type('Agama','readonly');
        $crud->change_field_type('TglLahir','readonly');
        $crud->change_field_type('AlamatKTP','readonly');
        $crud->change_field_type('TptLahir','readonly');
        $crud->change_field_type('CityKTP','readonly');
        $crud->change_field_type('KodeposKTP','readonly');
        $crud->change_field_type('AlamatDomisili','readonly');
        $crud->change_field_type('CityDomisili','readonly');
        $crud->change_field_type('Kodepos','readonly');
        $crud->change_field_type('Telp','readonly');
        $crud->change_field_type('Hp','readonly');
        $crud->change_field_type('BloodType','readonly');
        $crud->change_field_type('StatusDiri','readonly');
        $crud->change_field_type('NamaIbuKandung','readonly');
        $crud->change_field_type('NoNPWP','readonly');
        $crud->change_field_type('NoKPJ','readonly');
        $crud->change_field_type('NoBPJSKes','readonly');
        $crud->change_field_type('EmailPribadi','readonly');
        $crud->change_field_type('JabatanID','readonly');
        $crud->change_field_type('Email','readonly');
        $crud->change_field_type('NIK','readonly');      

        }
		
       $crud->required_fields('NIK1','NIK2','TermsAndConditions');

        $crud->add_fields('Photos','NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','AlamatDomisili','Kodepos','Telp',
                            'Hp','Email','AlamatKTP','StatusDiri','TglMenikah','TglMasuk','TglKeluar','BandSkrg','Status',
                            'CompanyId','DivisiID','DeptID','UnitID','JabatanID','JmlAnak');

        $data = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = ".$session_nik));
        $_SESSION['old_NoKTP']         = $data['NoKTP'];
        $_SESSION['old_TglKTP']        = $data['TglKTP'];
        $_SESSION['old_Nama']          = $data['Nama'];
        $_SESSION['old_Sex']           = $data['Sex'];
        $_SESSION['old_Agama']         = $data['Agama'];
        $_SESSION['old_TglLahir']      = $data['TglLahir'];
        $_SESSION['old_TptLahir']      = $data['TptLahir'];
        $_SESSION['old_Telp']          = $data['Telp'];
        $_SESSION['old_Hp']            = $data['Hp'];

        $_SESSION['old_CompanyId']            = $data['CompanyId'];
        $_SESSION['old_DivisiID']            = $data['DivisiID'];
        $_SESSION['old_DeptID']            = $data['DeptID'];
        $_SESSION['old_UnitID']            = $data['UnitID'];
        $_SESSION['old_SeksiID']            = $data['SeksiID'];

        $_SESSION['old_StatusDiri']            = $data['StatusDiri'];
        $_SESSION['old_NoNPWP']            = $data['NoNPWP'];
        $_SESSION['old_NoKPJ']            = $data['NoKPJ'];
        $_SESSION['old_NoBPJSKes']            = $data['NoBPJSKes'];
        $_SESSION['old_BloodType']            = $data['BloodType'];
        //$_SESSION['old_Sex']            = $data['Sex'];

        $_SESSION['old_NamaIbuKandung']            = $data['NamaIbuKandung'];

        $AlamatDomisili = str_ireplace("\\r\\n", "\r\n", $data['AlamatDomisili']);
        $AlamatKTP = str_ireplace("\\r\\n", "\r\n", $data['AlamatKTP']);

        $_SESSION['old_AlamatDomisili']             = $AlamatDomisili;
        $_SESSION['old_AlamatKTP']                  = $AlamatKTP;


        $query = $this->db->select('ProcessCVNumber')
            ->from($this->cms_complete_table_name('profile'))
            ->where('NIK', $this->cms_user_id())
            ->get();
        $result = $query->result_array();
        $row    = $query->row();
        $sessionData = array('ProcessCVNumber' => $row->ProcessCVNumber);
        $this->session->set_userdata($sessionData);

        $last_update    = $this->input->get('state');
        $last_id_update = $this->input->get('id');

        if(!is_null($last_update) || !empty($last_update) || isset($last_update) || $last_update !=""){
            $action = $last_update;
            $id     = $last_id_update;

            if ( $id != $this->_callback_my_form_cv() && $action =='last_update'){
                $crud->unset_back_to_list();

            }
        }



/*
        $Kodepos2       = $data['Kodepos'];
        $Telp2          = $data['Telp'];
        $Hp2            = $data['Hp'];
        $Email2         = $data['Email'];
        $AlamatKTP2     = $data['AlamatDomisili'];
        $StatusDiri2    = $data['StatusDiri'];
        $Alamat2        = $_SESSION['Alamat2'];

*/

/*
        $crud->unset_add_fields('NoKTP2','TglKTP2','Nama2','Sex2','Agama2','TglLahir2','TptLahir2','Alamat2','Kodepos2','Telp2',
                            'Hp2','Email2','AlamatKTP2','StatusDiri2');
*/

        //$crud->unset_add_fields('Alamat2');
/*
        $crud->field_type('NoKTP2', 'hidden', $NoKTP2);
        $crud->field_type('TglKTP2', 'hidden', $TglKTP2);
        $crud->field_type('Nama2', 'hidden', $Nama2);
        $crud->field_type('Sex2', 'hidden', $Sex2);
        $crud->field_type('Agama2', 'hidden', $Agama2);
        $crud->field_type('TglLahir2', 'hidden', $TglLahir2);
        $crud->field_type('TptLahir2', 'hidden', $TptLahir2);
        $crud->field_type('Alamat2', 'hidden', $Alamat2);
        $crud->field_type('Kodepos2', 'hidden', $Kodepos2);
        $crud->field_type('Telp2', 'hidden', $Telp2);
        $crud->field_type('Hp2', 'hidden', $Hp2);
        $crud->field_type('Email2', 'hidden', $Email2);
        $crud->field_type('AlamatKTP2', 'hidden', $AlamatKTP2);
        $crud->field_type('StatusDiri2', 'hidden', $StatusDiri2);
*/
        //$crud->field_type('Alamat2', 'hidden', $Alamat2);
        // displayed columns on add operation
		
		
		


        $crud->set_field_upload('Photos','assets/uploads/files');
        // caption of each columns		
				
        $crud->display_as('NIK','NIK');
        $crud->display_as('Nama','Full Name');
        $crud->display_as('NoKTP','No KTP/ e-KTP');
        $crud->display_as('TglKTP','Tgl KTP Berlaku Hingga');
        $crud->display_as('Sex','Sex');
        $crud->display_as('BandSkrg','Band');
        $crud->display_as('TglMasuk','Tgl Mulai Bergabung');
        $crud->display_as('Status','Status');
        $crud->display_as('StatusDiri','Status Diri');
        $crud->display_as('CompanyId','Company');
        $crud->display_as('DivisiID','Division');
        $crud->display_as('DeptID','Departemen');
        $crud->display_as('UnitID','Unit');
        $crud->display_as('SeksiID','Seksi');
        $crud->display_as('JabatanID','Job Title Structural');
        $crud->display_as('JobId','Job Title Fungsional');
        $crud->display_as('JobCVId','Job Title Fungsional');          
        $crud->display_as('JmlAnak','Jumlah Anak');
        $crud->display_as('TptLahir','Birth Place');
        $crud->display_as('TglLahir','Birth Date');
        $crud->display_as('TglMenikah','Tgl Menikah');
        $crud->display_as('TglKeluar','Tgl Keluar');
        $crud->display_as('AlamatKTP','Address (ID Based)');
        $crud->display_as('CityKTP','City (ID Based)');
        $crud->display_as('KodeposKTP','ZIP (ID Based)');
        $crud->display_as('AlamatDomisili','Address (Current)');
        $crud->display_as('CityDomisili','City (Current)');
        $crud->display_as('Kodepos','ZIP (Current)');
        $crud->display_as('NamaIbuKandung','Nama Ibu Kandung');
        $crud->display_as('NoNPWP','No. NPWP');
        $crud->display_as('NamaIbuKandung','Nama Lengkap Ibu Kandung');
        $crud->display_as('NoKPJ','No. KPJ');
        $crud->display_as('BloodType','Blood Type');
        $crud->display_as('Telp','Telp');
        $crud->display_as('Hp','HP');
        $crud->display_as('EmailPribadi','Email Pribadi');
        $crud->display_as('Email','Email Perusahaan');
        $crud->display_as('TermsAndConditions','Terms & Conditions');
        $crud->display_as('JabatanID','Job Title Structural');
        //$crud->display_as('JobId','Job Title Fungsional');

        $crud->display_as('workexp','Work Experience');
        $crud->display_as('Education','Education');

        $crud->display_as('project','Project History'); 
        $crud->display_as('Files','Attachment Files'); 
        $crud->display_as('NIK1','Menyetujui - Atasan');
        $crud->display_as('NIK2','Mengetahui - HRD');  

           

        
        





        
				
		
		// $crud->required_fields( $field1, $field2, $field3, ... );
		
       
		
		//$crud->unique_fields( $field1, $field2, $field3, ... );
		$crud->unique_fields('NIK');
       		

		$crud->set_relation('Status', $this->cms_complete_table_name('status'), 'StatusName');
        $crud->set_relation('Sex', $this->cms_complete_table_name('sex'), 'SexNameEng');
        
        $crud->set_relation('DivisiID', $this->cms_complete_table_name('div'), 'cDivName');
        $crud->set_relation('DeptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        $crud->set_relation('UnitID', $this->cms_complete_table_name('unit'), 'NamaUnit');
        $crud->set_relation('SeksiID', $this->cms_complete_table_name('section'), 'cSectionName');
        $crud->set_relation('JabatanID', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');

        $crud->set_relation('StatusDiri', $this->cms_complete_table_name('StatusDiri'), 'StatusDiriName');
        $crud->set_relation('Agama', $this->cms_complete_table_name('Agama'), 'agama_name');

        $crud->set_primary_key('BloodTypeName',$this->cms_complete_table_name('blood_type'));
        $crud->set_relation('BloodType', $this->cms_complete_table_name('blood_type'), 'BloodTypeName');

        $crud->set_primary_key('City',$this->cms_complete_table_name('city'));
        $crud->set_relation('TptLahir', $this->cms_complete_table_name('city'), 'City');
        $crud->set_relation('CityKTP', $this->cms_complete_table_name('city'), 'City');
        $crud->set_relation('CityDomisili', $this->cms_complete_table_name('city'), 'City');        

        $crud->set_relation('JobCVId', $this->cms_complete_table_name('job_fungsional'), 'JobFungsionalName');

              	
			
		$crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));
       
        // send data to dummy file

        //$crud->callback_before_update(array($this,'_before_update_process'));
        //$crud->callback_after_update(array($this,'_after_update_process'));

        $crud->callback_column('Nama',array($this,'_callback_edit_url'));
        $crud->callback_column('TglMasuk',array($this,'_Date1_call'));

        $crud->callback_before_upload(array($this, '_valid_images'));

        $crud->callback_edit_field('CompanyId', array($this, 'empty_company_dropdown_select'));
        $crud->callback_add_field('DivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_edit_field('DivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_add_field('DeptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_edit_field('DeptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_add_field('UnitID', array($this, 'empty_units_dropdown_select'));
        $crud->callback_edit_field('UnitID', array($this, 'empty_units_dropdown_select'));
        $crud->callback_add_field('SeksiID', array($this, 'empty_seksi_dropdown_select'));
        $crud->callback_edit_field('SeksiID', array($this, 'empty_seksi_dropdown_select'));

        $crud->callback_edit_field('TermsAndConditions', array($this, '_callback_column_TermsAndConditions'));

        $crud->callback_edit_field('NIK1', array($this, '_callback_edit_field_NIK1'));
        $crud->callback_edit_field('NIK2', array($this, '_callback_edit_field_NIK2'));

        // Disabled some field

        


        /*
        $crud->callback_add_field('DivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_edit_field('DivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_add_field('DeptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_edit_field('DeptID', array($this, 'empty_city_dropdown_select'));
        */

        $crud->callback_column('member',array($this, '_callback_column_member'));
        $crud->callback_field('member',array($this, '_callback_field_member'));

        $crud->callback_column('workexp',array($this, '_callback_column_workexp'));
        $crud->callback_field('workexp',array($this, '_callback_field_workexp'));

        $crud->callback_column('Education',array($this, '_callback_column_Education'));
        $crud->callback_field('Education',array($this, '_callback_field_Education'));

        $crud->callback_column('training',array($this, '_callback_column_training'));
        $crud->callback_field('training',array($this, '_callback_field_training'));

        $crud->callback_column('technical',array($this, '_callback_column_technical'));
        $crud->callback_field('technical',array($this, '_callback_field_technical'));

        $crud->callback_column('certification',array($this, '_callback_column_certification'));
        $crud->callback_field('certification',array($this, '_callback_field_certification'));

        $crud->callback_column('project',array($this, '_callback_column_project'));
        $crud->callback_field('project',array($this, '_callback_field_project'));

        $crud->callback_column('Files',array($this, 'callback_column_files'));
        $crud->callback_field('Files',array($this, 'callback_field_files'));
        

        $crud->callback_column('Photos',array($this,'_callback_column_Photos'));

        

        $this->crud = $crud;
        return $crud;
    }


    public function _example_output($output = null){

        $my_profile = $this->_callback_my_profile();
        

        $data = array(
            'sex' => $my_profile['sex'],
            'status_diri' => $my_profile['status_diri'],
            'state' => $this->_callback_state_action(),
            'process_cv' => $my_profile['process_cv'],
            'process_cv_number' => $my_profile['process_cv_number'],

        );

        $output   = array_merge((array)$output, $data);

        $this->view($this->cms_module_path().'/frmMyCV_view', $output,
        $this->cms_complete_navigation_name('frmMyCV'));    
    }


    public function index(){
         //echo"<script>window.open('http://astapp02/hris2/bpjs/frmRegistration/index/add');</script>";
         
        $crud = $this->make_crud();

        $dd_data = array(
                'dd_state' =>  $crud->getState(),                
                'dd_dropdowns' => array('CompanyId','DivisiID','DeptID','UnitID','SeksiID'),               
                'dd_url' => array('', site_url().'/karyawan/frmMyCV/get_states/', site_url().'/karyawan/frmMyCV/get_cities/', site_url().'/karyawan/frmMyCV/get_units/',site_url().'/karyawan/frmMyCV/get_seksi/'),
                'dd_ajax_loader' => base_url().'ajax-loader.gif'
            );     


        $output = $crud->render();
        $output->dropdown_setup = $dd_data;            
        $this->_example_output($output);
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('profile'),array('NIK'=>$id));
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

    public function _before_update_process($post_array, $primary_key){

    }

    public function _after_update_process($post_array, $primary_key){

        echo "<script language='javascript'>alert('Data Sudah Disimpan dan Email sudah dikirim...');</script>";

    }


    public function _before_update($post_array, $primary_key){

        $session_nik = $this->cms_user_id();
        $tb_dummy = array(
            $this->cms_complete_table_name('profile_workexperience'),
            $this->cms_complete_table_name('profile_education'),
            $this->cms_complete_table_name('profile_training'),
            $this->cms_complete_table_name('profile_technicalskill'),
            $this->cms_complete_table_name('profile_certification'),
            $this->cms_complete_table_name('profile_projecthistory'),
            $this->cms_complete_table_name('profile_files'),
        );


        foreach ($tb_dummy as $arrayvalue){        
            $column_nik         = $this->_callback_primary_column_nik($arrayvalue);
            $this->db->delete($arrayvalue,array($column_nik=>$primary_key));   
        }

        //$post_array = $this->_before_insert_or_update($post_array, $primary_key);
        $data = json_decode($this->input->post('md_real_field_files_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('file_id', 'url','file_code');
        $set_column_names = array();
        $many_to_many_column_names = array();
        $many_to_many_relation_tables = array();
        $many_to_many_relation_table_columns = array();
        $many_to_many_relation_selection_columns = array();
        
        
        foreach($insert_records as $insert_record){

           $MAXIMUM_FILESIZE = 1000 * 1000;
           $rEFileTypes ="/^\.(jpg|jpeg|pdf){1}$/i";

            $upload_path = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index = $insert_record['record_index'];
            $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", " ","","-"), 
                     trim($_FILES['md_field_files_col_url_'.$record_index]['name']));

            $fsize     = $_FILES['md_field_files_col_url_'.$record_index]['size']; 

            $tmp_name  = $_FILES['md_field_files_col_url_'.$record_index]['tmp_name'];
            $type_name  = $_FILES['md_field_files_col_url_'.$record_index]['type'];
            $file_name = $_FILES['md_field_files_col_url_'.$record_index]['name'];
            $file_name = $this->randomize_string($file_name).$safe_filename;
            $file_code = $_FILES['md_field_files_col_url_'.$record_index]['name'];                  


            $data = array(
                'url' => $file_name,
                'file_code' => $file_code,
            );

            $data['file_nik'] = $primary_key;
            
            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){

                return $post_array;

            }else{

                $file_anda = round($fsize/1000000,2);

                echo "<script language='javascript'>alert('Error!!!  File harus jpg , jpeg atau pdf dan size maksimal 1 MB, size=[$file_anda MB] & type=[$type_name]');</script>";
                return FALSE;
                
            }
            
            
            
        }

        //return $post_array;
    }

    public function _after_update($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here

        $session_nik = $this->cms_user_id();
        $tb_dummy = array(
            $this->cms_complete_table_name('profile_workexperience'),
            $this->cms_complete_table_name('profile_education'),
            $this->cms_complete_table_name('profile_training'),
            $this->cms_complete_table_name('profile_technicalskill'),
            $this->cms_complete_table_name('profile_certification'),
            $this->cms_complete_table_name('profile_projecthistory'),
            $this->cms_complete_table_name('profile_files'),
        );

        foreach ($tb_dummy as $arrayvalue){

        $temp               = '_temp';
        $table_name_ori     = $arrayvalue;
        $table_name_temp    = $table_name_ori.$temp;
        $column_nik         = $this->_callback_primary_column_nik($table_name_ori);
        $primary_column     = $this->_callback_primary_column_name($table_name_ori);

        $result = mysql_query("SELECT * FROM $arrayvalue WHERE $column_nik='".$session_nik."'");
        $total  = mysql_num_rows($result);
        if ($total >0){
            while ($data = mysql_fetch_array($result)){             
                $id              = $data[$primary_column];                    
                $this->_callback_insert_rows($id,$table_name_ori,$table_name_temp,$session_nik,$primary_column);
            }
        }

        $this->db->delete($arrayvalue,array($column_nik=>$session_nik));     
   
        }

        $last_process = $this->_callback_last_process_id();

       
        include "http://$_SERVER[SERVER_NAME]/hris2/includes/mailer/frmKaryawanALL/SendMail.php?nik=$session_nik&proses=1&last_process=$last_process";

        echo "<script language='javascript'>alert('Data Sudah Disimpan dan Email sudah dikirim...');</script>";
        return $success;
        //return true;
    }

    public function _before_delete($primary_key){

        $session_nik = $this->cms_user_id();
        $tb_dummy = array(
            $this->cms_complete_table_name('profile_workexperience'),
            $this->cms_complete_table_name('profile_education'),
            $this->cms_complete_table_name('profile_training'),
            $this->cms_complete_table_name('profile_technicalskill'),
            $this->cms_complete_table_name('profile_certification'),
            $this->cms_complete_table_name('profile_projecthistory'),
            $this->cms_complete_table_name('profile_files'),
        );


        foreach ($tb_dummy as $arrayvalue){        
            $column_nik         = $this->_callback_primary_column_nik($arrayvalue);
            $this->db->delete($arrayvalue,array($column_nik=>$primary_key));   
        }


    /*    
        $this->db->delete($this->cms_complete_table_name('profile_files'),
              array('file_nik'=>$primary_key));

       
        $this->db->delete($this->cms_complete_table_name('profile_training'),
              array('TrainingNIK'=>$primary_key));

      
        $this->db->delete($this->cms_complete_table_name('profile_technicalskill'),
              array('TechnicalSkillNIK'=>$primary_key));
    */

        return TRUE;
    }

    public function _after_delete($primary_key){
        return TRUE;
    }

    public function _after_insert_or_update($post_array, $primary_key){

        //$data_process = $this->_after_update();
        $alphaNumeric   = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $random         = substr(str_shuffle($alphaNumeric), 0, 7);
        $token          = md5($random);
        $today          = date('Y-m-d H:i:s');
        $my_profile     = $this->_callback_my_profile();          

        $this->db->insert($this->cms_complete_table_name('profile_process'),
            array(
                'ProcessNIK' => $this->cms_user_id(),
                'ProcessLevel' => 1,
                'ProcessNIK1' => $post_array['NIK1'],
                'ProcessNIK2' => $post_array['NIK2'],
                'ProcessPin' => $token,
                'ProcessLastId' => $this->_callback_my_form_cv(),
                'companyID' => $my_profile['company'],
                'CreatedBy' => $this->cms_user_id(),
                'CreatedTime' => date('Y-m-d H:i:s'),
                'UpdatedBy' => $this->cms_user_id(),
            )
        );

        

        $process_primary_key = $this->db->insert_id();

        $this->db->update($this->cms_complete_table_name('profile'),array('ProcessCV' =>1,'ProcessCVNumber' =>$process_primary_key), array('NIK'=>$primary_key));


        $data = json_decode($this->input->post('md_real_field_files_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('file_id','file_type','url','file_code');
        $set_column_names = array();
        $many_to_many_column_names = array();
        $many_to_many_relation_tables = array();
        $many_to_many_relation_table_columns = array();
        $many_to_many_relation_selection_columns = array();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  DELETED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            $this->db->delete($this->cms_complete_table_name('profile_files'),
                 array('file_id'=>$detail_primary_key));
        }
        
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  INSERTED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($insert_records as $insert_record){
            $data = array();
            foreach($insert_record['data'] as $key=>$value){               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['file_nik'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('profile_files'), $data);
            $detail_primary_key = $this->db->insert_id();

            $this->db->update($this->cms_complete_table_name('profile_files'),
                array('file_process_id'=>$process_primary_key,
                    'file_UpdatedBy'=>$this->cms_user_id()),
                array('file_id'=>$detail_primary_key));


            // Begin insert file
            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $insert_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_files_col_url_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_files_col_url_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_files_col_url_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_files_col_url_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_files_col_url_'.$record_index]['name'];
            $data               = array('url' => $file_name,'file_code' => $file_code,);
            $data['file_id']    = $primary_key;


            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $this->db->update($this->cms_complete_table_name('profile_files'),
                $data, array('file_id'=>$detail_primary_key));
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);

            }
            // end of insert file



            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Inserted Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $insert_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }



        foreach($update_records as $update_record){
            $detail_primary_key = $update_record['primary_key'];
            $data = array();
            foreach($update_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['file_nik'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('profile_files'),
                 $data, array('file_id'=>$detail_primary_key));


            $data = array();
            foreach($update_record['data'] as $key=>$value){
               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['file_nik'] = $primary_key;           
            $this->db->insert($this->cms_complete_table_name('profile_files'), $data);
            $detail_primary_key = $this->db->insert_id();

            $this->db->update($this->cms_complete_table_name('profile_files'),
                array('file_process_id'=>$process_primary_key,
                    'file_UpdatedBy'=>$this->cms_user_id()),
                array('file_id'=>$detail_primary_key));

            
        }



        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        // SAVE CHANGES OF citizen
        //  * The citizen data in in json format.
        //  * It can be accessed via $_POST['md_real_field_citizen_col']
        //
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $data = json_decode($this->input->post('md_real_field_citizen_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('WorkExpId','WorkExpNIK','WorkExpStart','WorkExpFinish','WorkExpCompany','WorkExpPosition','WorkExpFileName','WorkExpFileUrl','WorkExpStatus','WorkExpApv','WorkExpProcessId','WorkExpUpdatedBy');
        $set_column_names = array();
        $many_to_many_column_names = array();
        $many_to_many_relation_tables = array();
        $many_to_many_relation_table_columns = array();
        $many_to_many_relation_selection_columns = array();

        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  DELETED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $where = array(
                    $relation_column_name => $detail_primary_key
                );
                $this->db->delete($table_name, $where);
            }
            $this->db->delete($this->cms_complete_table_name('profile_workexperience'),
                 array('WorkExpId'=>$detail_primary_key));
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  UPDATED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($update_records as $update_record){
            $detail_primary_key = $update_record['primary_key'];
            $data = array();
            foreach($update_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['WorkExpNIK'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('profile_workexperience'),
                 $data, array('WorkExpId'=>$detail_primary_key));


            // Begin update file
            foreach($update_record['data'] as $key=>$value){               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['WorkExpNIK'] = $primary_key;           
            $this->db->insert($this->cms_complete_table_name('profile_workexperience'), $data);
            $detail_primary_key2 = $this->db->insert_id();


            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $update_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_citizen_col_WorkExpFileUrl_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_citizen_col_WorkExpFileUrl_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_citizen_col_WorkExpFileUrl_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_citizen_col_WorkExpFileUrl_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_citizen_col_WorkExpFileUrl_'.$record_index]['name'];

            $this->db->update($this->cms_complete_table_name('profile_workexperience'),
                array('WorkExpProcessId'=>$process_primary_key,'WorkExpUpdatedBy'=>$this->cms_user_id(),),
                array('WorkExpId'=>$detail_primary_key2));

            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.')) && !is_null($file_name) && !empty($file_name)){
                $this->db->update($this->cms_complete_table_name('profile_workexperience'),
                    array('WorkExpFileUrl'=>$file_name,'WorkExpFileName'=>$file_code,),
                    array('WorkExpId'=>$detail_primary_key2));
                move_uploaded_file($tmp_name, $upload_path.$file_name);                
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);

            }
            // end of update file

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Updated Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $update_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  INSERTED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($insert_records as $insert_record){
            //$this->form_validation->set_rules( 'birthdate', 'birthdate', 'required' );
            //$this->crud->set_rules("name","name","required");
            $data = array();
            foreach($insert_record['data'] as $key=>$value){
               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['WorkExpNIK'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('profile_workexperience'), $data);
            $detail_primary_key = $this->db->insert_id();

            $this->db->update($this->cms_complete_table_name('profile_workexperience'),
                array('WorkExpProcessId'=>$process_primary_key,
                    'WorkExpUpdatedBy'=>$this->cms_user_id()),
                array('WorkExpId'=>$detail_primary_key));


            // Begin insert file
            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $insert_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_citizen_col_WorkExpFileUrl_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_citizen_col_WorkExpFileUrl_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_citizen_col_WorkExpFileUrl_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_citizen_col_WorkExpFileUrl_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_citizen_col_WorkExpFileUrl_'.$record_index]['name'];
            $data               = array('WorkExpFileUrl' => $file_name,'WorkExpFileName' => $file_code,);
            $data['WorkExpId'] = $primary_key;


            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $this->db->update($this->cms_complete_table_name('profile_workexperience'),
                $data, array('WorkExpId'=>$detail_primary_key));
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);

            }
            // end of insert file



            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Inserted Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $insert_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }


// education

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        // SAVE CHANGES OF education
        //  * The education data in in json format.
        //  * It can be accessed via $_POST['md_real_field_education_col']
        //
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $data = json_decode($this->input->post('md_real_field_education_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('EduId','EduNIK','EduStart','EduFinish','EduLevelId','EduInstitution','EduCity','EduFaculty','EduMajor','EduGPA','EduFileName','EduFileUrl','EduStatus','EduApv','EduProcessId','EduUpdatedBy');
        $set_column_names = array();
        $many_to_many_column_names = array();
        $many_to_many_relation_tables = array();
        $many_to_many_relation_table_columns = array();
        $many_to_many_relation_selection_columns = array();

        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  DELETED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $where = array(
                    $relation_column_name => $detail_primary_key
                );
                $this->db->delete($table_name, $where);
            }
            $this->db->delete($this->cms_complete_table_name('profile_education'),
                 array('EduId'=>$detail_primary_key));
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  UPDATED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($update_records as $update_record){
            $detail_primary_key = $update_record['primary_key'];
            $data = array();
            foreach($update_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            
            $data['EduNIK'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('profile_education'),
                 $data, array('EduId'=>$detail_primary_key));
            
            foreach($update_record['data'] as $key=>$value){               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['EduNIK'] = $primary_key;           
            $this->db->insert($this->cms_complete_table_name('profile_education'), $data);
            $detail_primary_key2 = $this->db->insert_id();




            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $update_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_education_col_EduFileUrl_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_education_col_EduFileUrl_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_education_col_EduFileUrl_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_education_col_EduFileUrl_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_education_col_EduFileUrl_'.$record_index]['name'];

            
            $this->db->update($this->cms_complete_table_name('profile_education'),
                array('EduProcessId'=>$process_primary_key,'EduUpdatedBy'=>$this->cms_user_id(),),
                array('EduId'=>$detail_primary_key2));

            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename,'.')) && !is_null($file_name) && !empty($file_name)){
                $this->db->update($this->cms_complete_table_name('profile_education'),
                    array('EduFileUrl'=>$file_name,'EduFileName'=>$file_code,),
                    array('EduId'=>$detail_primary_key2));
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);
            }


            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Updated Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $update_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  INSERTED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($insert_records as $insert_record){
            //$this->form_validation->set_rules( 'birthdate', 'birthdate', 'required' );
            //$this->crud->set_rules("name","name","required");
            $data = array();
            foreach($insert_record['data'] as $key=>$value){               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['EduNIK'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('profile_education'), $data);
            $detail_primary_key = $this->db->insert_id();

            $this->db->update($this->cms_complete_table_name('profile_education'),
                array('EduProcessId'=>$process_primary_key,
                    'EduUpdatedBy'=>$this->cms_user_id()),
                array('EduId'=>$detail_primary_key));


            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $insert_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_education_col_EduFileUrl_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_education_col_EduFileUrl_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_education_col_EduFileUrl_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_education_col_EduFileUrl_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_education_col_EduFileUrl_'.$record_index]['name'];
            $data               = array('EduFileUrl' => $file_name,'EduFileName' => $file_code,);
            $data['EduId']      = $primary_key;


            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $this->db->update($this->cms_complete_table_name('profile_education'),
                $data, array('EduId'=>$detail_primary_key));
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);

            }


            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Inserted Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $insert_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }





        // training

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        // SAVE CHANGES OF training
        //  * The training data in in json format.
        //  * It can be accessed via $_POST['md_real_field_training_col']
        //
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $data = json_decode($this->input->post('md_real_field_training_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('TrainingId', 'TrainingNIK', 'TrainingYear', 'TrainingInstitution', 'TrainingCity','TrainingModul','TrainingType','TrainingFileName','TrainingFileUrl','TrainingStatus','TrainingApv','TrainingProcessId','TrainingUpdatedBy');
        $set_column_names = array();

        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  DELETED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $where = array(
                    $relation_column_name => $detail_primary_key
                );
                $this->db->delete($table_name, $where);
            }
            $this->db->delete($this->cms_complete_table_name('profile_training'),
                 array('TrainingId'=>$detail_primary_key));
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  UPDATED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($update_records as $update_record){
            $detail_primary_key = $update_record['primary_key'];
            $data = array();
            foreach($update_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['TrainingNIK'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('profile_training'),
                 $data, array('TrainingId'=>$detail_primary_key));


            foreach($update_record['data'] as $key=>$value){               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['TrainingNIK'] = $primary_key;           
            $this->db->insert($this->cms_complete_table_name('profile_training'), $data);
            $detail_primary_key2 = $this->db->insert_id();


            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $update_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['name'];


            
            $this->db->update($this->cms_complete_table_name('profile_training'),
                array('TrainingProcessId'=>$process_primary_key,'TrainingUpdatedBy'=>$this->cms_user_id(),),
                array('TrainingId'=>$detail_primary_key2));

            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename,'.')) && !is_null($file_name) && !empty($file_name)){
                $this->db->update($this->cms_complete_table_name('profile_training'),
                    array('TrainingFileUrl'=>$file_name,'TrainingFileName'=>$file_code,),
                    array('TrainingId'=>$detail_primary_key2));
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);
            }


            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Updated Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $update_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  INSERTED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($insert_records as $insert_record){
            //$this->form_validation->set_rules( 'birthdate', 'birthdate', 'required' );
            //$this->crud->set_rules("name","name","required");
            $data = array();
            foreach($insert_record['data'] as $key=>$value){

               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['TrainingNIK'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('profile_training'), $data);
            $detail_primary_key = $this->db->insert_id();

            $this->db->update($this->cms_complete_table_name('profile_training'),
                array('TrainingProcessId'=>$process_primary_key,
                    'TrainingUpdatedBy'=>$this->cms_user_id()),
                array('TrainingId'=>$detail_primary_key));

            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $insert_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_training_col_TrainingFileUrl_'.$record_index]['name'];
            $data               = array('TrainingFileUrl' => $file_name,'TrainingFileName' => $file_code,);
            $data['TrainingId'] = $primary_key;


            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $this->db->update($this->cms_complete_table_name('profile_training'),
                $data, array('TrainingId'=>$detail_primary_key));
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);

            }
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Inserted Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $insert_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }





        // technical skill 

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        // SAVE CHANGES OF technical
        //  * The technical data in in json format.
        //  * It can be accessed via $_POST['md_real_field_technical_col']
        //
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $data = json_decode($this->input->post('md_real_field_technical_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('TechnicalSkillId', 'TechnicalSkillNIK', 'TechnicalSkillName', 'TechnicalSkillExp','TechnicalSkillDesc','TechnicalSkillFileName','TechnicalSkillFileUrl','TechnicalSkillStatus','TechnicalSkillApv','TechnicalSkillProcessId','TechnicalSkillUpdatedBy');
        $set_column_names = array();

        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  DELETED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $where = array(
                    $relation_column_name => $detail_primary_key
                );
                $this->db->delete($table_name, $where);
            }
            $this->db->delete($this->cms_complete_table_name('profile_technicalskill'),
                 array('TechnicalSkillId'=>$detail_primary_key));
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  UPDATED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($update_records as $update_record){
            $detail_primary_key = $update_record['primary_key'];
            $data = array();
            foreach($update_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['TechnicalSkillNIK'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('profile_technicalskill'),
                 $data, array('TechnicalSkillId'=>$detail_primary_key));

            foreach($update_record['data'] as $key=>$value){               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['TechnicalSkillNIK'] = $primary_key;           
            $this->db->insert($this->cms_complete_table_name('profile_technicalskill'), $data);
            $detail_primary_key2 = $this->db->insert_id();


            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $update_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_technical_col_TechnicalSkillFileUrl_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_technical_col_TechnicalSkillFileUrl_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_technical_col_TechnicalSkillFileUrl_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_technical_col_TechnicalSkillFileUrl_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_technical_col_TechnicalSkillFileUrl_'.$record_index]['name'];

            
            $this->db->update($this->cms_complete_table_name('profile_technicalskill'),
                array('TechnicalSkillProcessId'=>$process_primary_key,'TechnicalSkillUpdatedBy'=>$this->cms_user_id(),),
                array('TechnicalSkillId'=>$detail_primary_key2));

            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename,'.')) && !is_null($file_name) && !empty($file_name)){
                $this->db->update($this->cms_complete_table_name('profile_technicalskill'),
                    array('TechnicalSkillFileUrl'=>$file_name,'TechnicalSkillFileName'=>$file_code,),
                    array('TechnicalSkillId'=>$detail_primary_key2));
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);
            }

           

            

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Updated Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $update_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  INSERTED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($insert_records as $insert_record){
            //$this->form_validation->set_rules( 'birthdate', 'birthdate', 'required' );
            //$this->crud->set_rules("name","name","required");
            $data = array();
            foreach($insert_record['data'] as $key=>$value){               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['TechnicalSkillNIK'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('profile_technicalskill'), $data);
            $detail_primary_key = $this->db->insert_id();


            $this->db->update($this->cms_complete_table_name('profile_technicalskill'),
                array('TechnicalSkillProcessId'=>$process_primary_key,
                    'TechnicalSkillUpdatedBy'=>$this->cms_user_id()),
                array('TechnicalSkillId'=>$detail_primary_key));

            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $insert_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_technical_col_TechnicalSkillFileUrl_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_technical_col_TechnicalSkillFileUrl_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_technical_col_TechnicalSkillFileUrl_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_technical_col_TechnicalSkillFileUrl_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_technical_col_TechnicalSkillFileUrl_'.$record_index]['name'];
            $data               = array('TechnicalSkillFileUrl' => $file_name,'TechnicalSkillFileName' => $file_code,);
            $data['TechnicalSkillId']      = $primary_key;


            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $this->db->update($this->cms_complete_table_name('profile_technicalskill'),
                $data, array('TechnicalSkillId'=>$detail_primary_key));
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);

            }


            

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Inserted Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $insert_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }



        // certification

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        // SAVE CHANGES OF certification
        //  * The certification data in in json format.
        //  * It can be accessed via $_POST['md_real_field_certification_col']
        //
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $data = json_decode($this->input->post('md_real_field_certification_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('CertId', 'CertNIK', 'CertDate', 'CertItem', 'CertProduct', 'CertName', 'CertPartnerName','CertValidStart','CertValidFinish','CertFileName','CertFileUrl','CertStatus','CertApv','CertProcessId','CertUpdatedBy');
        $set_column_names = array();

        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  DELETED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $where = array(
                    $relation_column_name => $detail_primary_key
                );
                $this->db->delete($table_name, $where);
            }
            $this->db->delete($this->cms_complete_table_name('profile_certification'),
                 array('CertId'=>$detail_primary_key));
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  UPDATED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($update_records as $update_record){
            $detail_primary_key = $update_record['primary_key'];
            $data = array();
            foreach($update_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['CertNIK'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('profile_certification'),
                 $data, array('CertId'=>$detail_primary_key));
            
            
            foreach($update_record['data'] as $key=>$value){               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['CertNIK'] = $primary_key;           
            $this->db->insert($this->cms_complete_table_name('profile_certification'), $data);
            $detail_primary_key2 = $this->db->insert_id();


            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $update_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['name'];

           
            $this->db->update($this->cms_complete_table_name('profile_certification'),
                array('CertProcessId'=>$process_primary_key,'CertUpdatedBy'=>$this->cms_user_id(),),
                array('CertId'=>$detail_primary_key2));

            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename,'.')) && !is_null($file_name) && !empty($file_name)){
                $this->db->update($this->cms_complete_table_name('profile_certification'),
                    array('CertFileUrl'=>$file_name,'CertFileName'=>$file_code,),
                    array('CertId'=>$detail_primary_key2));
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);
            }


            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Updated Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $update_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  INSERTED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($insert_records as $insert_record){
            //$this->form_validation->set_rules( 'birthdate', 'birthdate', 'required' );
            //$this->crud->set_rules("name","name","required");
            $data = array();
            foreach($insert_record['data'] as $key=>$value){
               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['CertNIK'] = $primary_key;           
            $this->db->insert($this->cms_complete_table_name('profile_certification'), $data);
            $detail_primary_key = $this->db->insert_id();

            $this->db->update($this->cms_complete_table_name('profile_certification'),
                array('CertProcessId'=>$process_primary_key,
                    'CertUpdatedBy'=>$this->cms_user_id()),
                array('CertId'=>$detail_primary_key));

           

            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $insert_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_certification_col_CertFileUrl_'.$record_index]['name'];
            $data               = array('CertFileUrl' => $file_name,'CertFileName' => $file_code,);
            $data['CertId']      = $primary_key;


            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $this->db->update($this->cms_complete_table_name('profile_certification'),
                $data, array('CertId'=>$detail_primary_key));
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);

            }

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Inserted Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $insert_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }



        // Project History

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        // SAVE CHANGES OF Project History
        //  * The Project History data in in json format.
        //  * It can be accessed via $_POST['md_real_field_project_col']
        //
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $data = json_decode($this->input->post('md_real_field_project_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('ProjectId','ProjectNIK','ProjectDate','ProjectName','ProjectInstitution','ProjectYear','ProjectLength','ProjectTechnicalSpec','ProjectPosition','ProjectFileName','ProjectFileUrl','ProjectStatus','ProjectApv','ProjectProcessId','ProjectUpdatedBy');
        $set_column_names = array();

        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  DELETED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($delete_records as $delete_record){
            $detail_primary_key = $delete_record['primary_key'];
            // delete many to many
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $where = array(
                    $relation_column_name => $detail_primary_key
                );
                $this->db->delete($table_name, $where);
            }
            $this->db->delete($this->cms_complete_table_name('profile_projecthistory'),
                 array('ProjectId'=>$detail_primary_key));
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  UPDATED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($update_records as $update_record){
            $detail_primary_key = $update_record['primary_key'];
            $data = array();
            foreach($update_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['ProjectNIK'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('profile_projecthistory'),
                 $data, array('ProjectId'=>$detail_primary_key));

            /*
            $this->db->update($this->cms_complete_table_name('profile_projecthistory'),
                array('ProjectProcessId'=>$process_primary_key,
                      'ProjectUpdatedBy'=>$this->cms_user_id()),
                array('ProjectId'=>$detail_primary_key));

            $this->db->update($this->cms_complete_table_name('profile_projecthistory_temp'),
                 $data, array('ProjectId'=>$detail_primary_key));

            $this->db->update($this->cms_complete_table_name('profile_projecthistory_temp'),
                array('ProjectProcessId'=>$process_primary_key,
                      'ProjectUpdatedBy'=>$this->cms_user_id()),
                array('ProjectId'=>$detail_primary_key));
            */

            foreach($update_record['data'] as $key=>$value){               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['ProjectNIK'] = $primary_key;           
            $this->db->insert($this->cms_complete_table_name('profile_projecthistory'), $data);
            $detail_primary_key2 = $this->db->insert_id();


            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $update_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['name'];

            
            $this->db->update($this->cms_complete_table_name('profile_projecthistory'),
                array('ProjectProcessId'=>$process_primary_key,'ProjectUpdatedBy'=>$this->cms_user_id(),),
                array('ProjectId'=>$detail_primary_key2));

            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename,'.')) && !is_null($file_name) && !empty($file_name)){
                $this->db->update($this->cms_complete_table_name('profile_projecthistory'),
                    array('ProjectFileUrl'=>$file_name,'ProjectFileName'=>$file_code,),
                    array('ProjectId'=>$detail_primary_key2));
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);
            }


            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Updated Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $update_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  INSERTED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($insert_records as $insert_record){
            //$this->form_validation->set_rules( 'birthdate', 'birthdate', 'required' );
            //$this->crud->set_rules("name","name","required");
            $data = array();
            foreach($insert_record['data'] as $key=>$value){

               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['ProjectNIK'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('profile_projecthistory'), $data);
            $detail_primary_key = $this->db->insert_id();

            $this->db->update($this->cms_complete_table_name('profile_projecthistory'),
                array('ProjectProcessId'=>$process_primary_key,
                    'ProjectUpdatedBy'=>$this->cms_user_id()),
                array('ProjectId'=>$detail_primary_key));

            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $insert_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_project_col_ProjectFileUrl_'.$record_index]['name'];
            $data               = array('ProjectFileUrl' => $file_name,'ProjectFileName' => $file_code,);
            $data['ProjectId']  = $primary_key;


            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $this->db->update($this->cms_complete_table_name('profile_projecthistory'),
                $data, array('ProjectId'=>$detail_primary_key));
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);

            }

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Inserted Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $insert_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }

        $this->certification_expired_date($nik=$primary_key);


        return TRUE;
    }

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }

    // add hyperlink
    public function _callback_edit_url($value, $row){    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->NIK)."'><strong>$value</strong></a>";
        
    }


    // add hyperlink
    public function _callback_NIK($value, $row){    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->NIK)."'><strong>$value</strong></a>";
        
    }

    // change dPeriodEndDate format to d-M-Y
    public function _Date1_call($value, $row){
        //return $value." - scale: <b>".$row->date."</b>";
        $Date1 = date('d-M-Y', strtotime($row->TglMasuk));
        return $Date1;
        
    }

    //CALLBACK FUNCTIONS
    public function empty_company_dropdown_select($value, $row){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select disabled name="CompanyId" class="chosen-select" data-placeholder="Select Company" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('CompanyId, DivisiID, DeptID')
                     ->from('tbl_profile')
                     ->where('NIK', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $CompanyId = $row->CompanyId;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('tbl_company')
                     ->where('iCompanyId', $CompanyId);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iCompanyId == $CompanyId) {
                    $empty_select .= '<option value="'.$row->iCompanyId.'" selected="selected">'.$row->cCompanyName.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->iCompanyId.'">'.$row->cCompanyName.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }


    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select disabled name="DivisiID" class="chosen-select" data-placeholder="Select Division" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('CompanyId, DivisiID, DeptID')
                     ->from('tbl_profile')
                     ->where('NIK', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $CompanyId = $row->CompanyId;
            $DivisiID = $row->DivisiID;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('tbl_div')
                     ->where('iDivCompany', $CompanyId);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iDivId == $DivisiID) {
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

    public function empty_city_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select disabled name="DeptID" class="chosen-select" data-placeholder="Select Departement" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('CompanyId, DivisiID, DeptID, unitID')
                     ->from('tbl_profile')
                     ->where('NIK', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $DivisiID = $row->DivisiID;
            $DeptID = $row->DeptID;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_dept')
                     ->where('iDeptDivID', $DivisiID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iDeptID == $DeptID) {
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


    public function empty_units_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select disabled name="UnitID" class="chosen-select" data-placeholder="Select Unit" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('*')
                     ->from('tbl_profile')
                     ->where('NIK', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $UnitID = $row->UnitID;
            $DeptID = $row->DeptID;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_unit')
                     ->where('deptID', $DeptID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->unitID == $UnitID) {
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


    public function empty_seksi_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select disabled name="SeksiID" class="chosen-select" data-placeholder="Select Section" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud  = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('*')
                     ->from('tbl_profile')
                     ->where('NIK', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $UnitID = $row->UnitID;
            $DeptID = $row->DeptID;
            $SeksiID = $row->SeksiID;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_section')
                     ->where('unitID', $UnitID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iSectionID == $SeksiID) {
                    $empty_select .= '<option value="'.$row->iSectionID.'" selected="selected">'.$row->cSectionName.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->iSectionID.'">'.$row->cSectionName.'</option>';
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
        $CompanyId = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_div')
                 ->where('iDivCompany', $CompanyId);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iDivId, "property" => $row->cDivName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }
    
    //GET JSON OF CITIES
    public function get_cities(){
        $DivisiID = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_dept')
                 ->where('iDeptDivID', $DivisiID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iDeptID, "property" => $row->cDeptName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }


    //GET JSON OF CITIES
    public function get_units(){
        $DeptID = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_unit')
                 ->where('deptID', $DeptID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->unitID, "property" => $row->NamaUnit);
        endforeach;
        
        echo json_encode($array);
        exit;
    }


    //GET JSON OF CITIES
    public function get_seksi(){
        $UnitID = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_section')
                 ->where('unitID', $UnitID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iSectionID, "property" => $row->cSectionName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }


    public function _callback_column_Photos($value, $row){
        $this->db->select('*')
                     ->from('tbl_profile')
                     ->where('NIK', $row->NIK);
            $db = $this->db->get();
            $row = $db->row(0);
            $Sex = $row->Sex;            


        if (isset($value) || !is_null($value)){
            $image = $value;  
            return "<img src='http://".$_SERVER['SERVER_NAME']."/hris2/assets/uploads/files/" . $image . "' width=40>";
        }
        else {
            if ($Sex =='L'){
            $image = 'Male.png';
            }else {
            $image = 'Female.png';
            } 
           return "<img src='http://".$_SERVER['SERVER_NAME']."/hris2/assets/uploads/files/" . $image . "' width=40>";

        }
    }


    public function _valid_images($files_to_upload, $field_info){
        if ($files_to_upload[$field_info->encrypted_field_name]['type'] != 'image/png' && $files_to_upload[$field_info->encrypted_field_name]['type'] != 'image/jpg' && 
            $files_to_upload[$field_info->encrypted_field_name]['type'] != 'image/jpeg')
        {
            return 'Sorry, we can upload only images here.';
        }
        return true;
    }


    // returned on insert and edit
    public function _callback_field_member($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('MemberId, NIK, MemberName, MemberLahir, MemberStatus, MemberSex')
            ->from($this->cms_complete_table_name('profile_member'))
            ->where('NIK', $primary_key)
            ->get();
        $result = $query->result_array();

        // get options
        $options = array();
        $options['MemberStatus'] = array();
        $query = $this->db->select('MemberStatusId,MemberStatusName')
           ->from($this->cms_complete_table_name('member_status'))
           ->get();
        foreach($query->result() as $row){
            $options['MemberStatus'][] = array('value' => $row->MemberStatusId, 'caption' => $row->MemberStatusName);
        }


        // get options
        //$options = array();
        $options['MemberSex'] = array();
        $query = $this->db->select('SexId,SexCode,SexName')
           ->from($this->cms_complete_table_name('sex'))
           ->get();
        foreach($query->result() as $row){
            $options['MemberSex'][] = array('value' => $row->SexCode, 'caption' => $row->SexName);
        }
      
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
        );
        return $this->load->view($this->cms_module_path().'/field_profile_member',$data, TRUE);
    }

    // returned on view
    public function _callback_column_member($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('MemberId, NIK, MemberName, MemberLahir, MemberStatus, MemberSex')
            ->from($this->cms_complete_table_name('profile_member'))
            ->where('NIK', $row->NIK)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' Member';
        }else if($num_row>0){
            return $num_row .' Member';
        }else{
            return 'No Member';
        }
    }


    // returned on insert and edit
    public function _callback_field_workexp($value, $primary_key){

        //$crud = new grocery_CRUD();

        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        $last_update    = $this->input->get('state');
        $last_id_update = $this->input->get('id');
        if(!is_null($last_update) || !empty($last_update) || isset($last_update) || $last_update !=""){
            $table      = $this->cms_complete_table_name('profile_workexperience_temp');
            $process_id = $last_id_update;
        }
        else{
            $table      = $this->cms_complete_table_name('profile_workexperience');
            $process_id = $this->_callback_my_form_cv();
        }

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('WorkExpId, WorkExpNIK, WorkExpStart, WorkExpFinish, WorkExpCompany, WorkExpPosition, WorkExpDesc, WorkExpFileName, WorkExpFileUrl, WorkExpStatus, WorkExpApv, WorkExpProcessId, WorkExpUpdatedBy')
            ->from($table)
            ->where('WorkExpNIK', $primary_key)
            ->where('WorkExpProcessId', $process_id)
            ->get();
        $result = $query->result_array();       

        //$crud->set_field_upload('WorkExpFileUrl','assets/uploads/');

        // get options
        //$options = array();
        $options['MemberSex'] = array();
        $query = $this->db->select('SexId,SexCode,SexName')
           ->from($this->cms_complete_table_name('sex'))
           ->get();
        foreach($query->result() as $row){
            $options['MemberSex'][] = array('value' => $row->SexCode, 'caption' => $row->SexName);
        }
      
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $this->cms_module_path(),
        );
        return $this->load->view($this->cms_module_path().'/field_profile_workexp',$data, TRUE);
    }

    // returned on view
    public function _callback_column_workexp($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('WorkExpId, WorkExpNIK, WorkExpStart, WorkExpFinish, WorkExpCompany, WorkExpPosition, Certificate, WorkExpFileName, WorkExpFileUrl, WorkExpStatus,WorkExpApv,WorkExpProcessId,WorkExpUpdatedBy')
            ->from($this->cms_complete_table_name('profile_workexperience'))
            ->where('WorkExpNIK', $row->NIK)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' Member';
        }else if($num_row>0){
            return $num_row .' Member';
        }else{
            return 'No Member';
        }
    }



    // returned on insert and edit
    public function _callback_field_Education($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        $last_update    = $this->input->get('state');
        $last_id_update = $this->input->get('id');
        if(!is_null($last_update) || !empty($last_update) || isset($last_update) || $last_update !=""){
            $table      = $this->cms_complete_table_name('profile_education_temp');
            $process_id = $last_id_update;
        }
        else{
            $table      = $this->cms_complete_table_name('profile_education');
            $process_id = $this->_callback_my_form_cv();
        }

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('EduId,EduNIK,EduStart,EduFinish,EduLevelId,EduInstitution,EduCity,EduFaculty,EduMajor,EduGPA,EduCertificate,EduFileName,EduFileUrl,EduStatus,EduApv,EduProcessId,EduUpdatedBy')
            ->from($table)
            ->where('EduNIK', $primary_key)
            ->where('EduProcessId', $process_id)
            ->get();
        $result = $query->result_array();

        // get options
        $options = array();
        $options['EduLevelId'] = array();
        $query = $this->db->select('EducationLevelId,EducationLevelName,EducationLevelbStatus')
           ->from($this->cms_complete_table_name('eduLevel'))
           ->get();
        foreach($query->result() as $row){
            $options['EduLevelId'][] = array('value' => $row->EducationLevelName, 'caption' => $row->EducationLevelName);
        }

        $today       = date('Y-m-d H:i:s');

        $options['EduCreatedTime'] = $today;

        $options['EduCity'] = array();
        $query = $this->db->select('CityId,City')
           ->from($this->cms_complete_table_name('city'))
           ->get();
        foreach($query->result() as $row){
            $options['EduCity'][] = array('value' => $row->City, 'caption' => $row->City);
        }

        $options['EduInstitution'] = array();
        $query = $this->db->select('SchoolId,SchoolName,SchoolStatus,SchoolLevel')
           ->from($this->cms_complete_table_name('school'))
           ->where('SchoolStatus',1)
           ->order_by('SchoolName','ASC')
           ->get();
        foreach($query->result() as $row){
            $options['EduInstitution'][] = array('value' => $row->SchoolName, 'caption' => $row->SchoolName);
        }

        $options['EduFaculty'] = array();
        $query = $this->db->select('FacultyId,FacultyName,FacultyStatus,FacultyLevel')
           ->from($this->cms_complete_table_name('faculty'))
           ->where('FacultyStatus',1)
           ->order_by('FacultyName','ASC')
           ->get();
        foreach($query->result() as $row){
            $options['EduFaculty'][] = array('value' => $row->FacultyName, 'caption' => $row->FacultyName);
        }

        $options['EduCertificate'] = array();
        $query = $this->db->select('CertificateStatus')
           ->from($this->cms_complete_table_name('edu_certificate'))
           ->order_by('CertificateStatus','ASC')
           ->get();
        foreach($query->result() as $row){
            $options['EduCertificate'][] = array('value' => $row->CertificateStatus, 'caption' => $row->CertificateStatus);
        }


          

       
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $this->cms_module_path(),
        );
        return $this->load->view($this->cms_module_path().'/field_profile_education',$data, TRUE);
    }

    // returned on view
    public function _callback_column_Education($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('EduId,EduNIK,EduStart,EduFinish,EduLevelId,EduInstitution,EduCity,EduFaculty,EduMajor,EduGPA,EduCertificate,EduFileName,EduFileUrl,EduStatus,EduApv,EduProcessId,EduUpdatedBy')
            ->from($this->cms_complete_table_name('profile_education'))
            ->where('EduNIK', $row->NIK)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' education';
        }else if($num_row>0){
            return $num_row .' education';
        }else{
            return 'No education';
        }
    }



    // returned on insert and edit
    public function _callback_field_training($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        $last_update    = $this->input->get('state');
        $last_id_update = $this->input->get('id');
        if(!is_null($last_update) || !empty($last_update) || isset($last_update) || $last_update !=""){
            $table      = $this->cms_complete_table_name('profile_training_temp');
            $process_id = $last_id_update;
        }
        else{
            $table      = $this->cms_complete_table_name('profile_training');
            $process_id = $this->_callback_my_form_cv();
        }

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('TrainingId,TrainingNIK,TrainingYear,TrainingInstitution,TrainingCity,TrainingModul,TrainingType,TrainingFileName,TrainingFileUrl,TrainingStatus,TrainingApv,TrainingProcessId,TrainingUpdatedBy')
            ->from($table)
            ->where('TrainingNIK', $primary_key)
            ->where('TrainingProcessId', $process_id)
            ->get();
        $result = $query->result_array();

        // get options
        $options = array();

        $options['TrainingCity'] = array();
        $query = $this->db->select('CityId,City')
           ->from($this->cms_complete_table_name('city'))
           ->get();
        foreach($query->result() as $row){
            $options['TrainingCity'][] = array('value' => $row->City, 'caption' => $row->City);
        }

                    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $this->cms_module_path(),
        );
        return $this->load->view($this->cms_module_path().'/field_profile_training',$data, TRUE);
    }

    // returned on view
    public function _callback_column_training($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('TrainingId,TrainingNIK,TrainingYear,TrainingInstitution,TrainingCity,TrainingModul,TrainingType,TrainingFileName,TrainingFileUrl,TrainingStatus,TrainingApv,TrainingProcessId,TrainingUpdatedBy')
            ->from($this->cms_complete_table_name('profile_training'))
            ->where('TrainingNIK', $row->NIK)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' training';
        }else if($num_row>0){
            return $num_row .' training';
        }else{
            return 'No training';
        }
    }


    // returned on insert and edit
    public function _callback_field_technical($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        $last_update    = $this->input->get('state');
        $last_id_update = $this->input->get('id');
        if(!is_null($last_update) || !empty($last_update) || isset($last_update) || $last_update !=""){
            $table      = $this->cms_complete_table_name('profile_technicalskill_temp');
            $process_id = $last_id_update;
        }
        else{
            $table      = $this->cms_complete_table_name('profile_technicalskill');
            $process_id = $this->_callback_my_form_cv();
        }

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('TechnicalSkillId,TechnicalSkillNIK,TechnicalSkillName,TechnicalSkillExp,TechnicalSkillDesc,TechnicalSkillFileName,TechnicalSkillFileUrl,TechnicalSkillStatus,TechnicalSkillApv,TechnicalSkillProcessId,TechnicalSkillUpdatedBy')
            ->from($table)
            ->where('TechnicalSkillNIK', $primary_key)
            ->where('TechnicalSkillProcessId', $process_id)
            ->get();
        $result = $query->result_array();

        // get options
        $options = array();
                    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $this->cms_module_path(),
        );
        return $this->load->view($this->cms_module_path().'/field_profile_technical',$data, TRUE);
    }

    // returned on view
    public function _callback_column_technical($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('TechnicalSkillId,TechnicalSkillNIK,TechnicalSkillName,TechnicalSkillExp,TechnicalSkillDesc,TechnicalSkillFileName,TechnicalSkillFileUrl,TechnicalSkillStatus,TechnicalSkillApv,TechnicalSkillProcessId,TechnicalSkillUpdatedBy')
            ->from($this->cms_complete_table_name('profile_technicalskill'))
            ->where('TechnicalSkillNIK', $row->NIK)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' Technical';
        }else if($num_row>0){
            return $num_row .' Technical';
        }else{
            return 'No Technical';
        }
    }



    // returned on insert and edit
    public function _callback_field_certification($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        $last_update    = $this->input->get('state');
        $last_id_update = $this->input->get('id');
        if(!is_null($last_update) || !empty($last_update) || isset($last_update) || $last_update !=""){
            $table      = $this->cms_complete_table_name('profile_certification_temp');
            $process_id = $last_id_update;
        }
        else{
            $table      = $this->cms_complete_table_name('profile_certification');
            $process_id = $this->_callback_my_form_cv();
        }

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('CertId,CertNIK,CertDate,CertItem,CertProduct,CertName,CertPartnerName,CertValidStart,CertValidFinish,CertFileName,CertFileUrl,CertStatus,CertApv,CertProcessId,CertUpdatedBy')
            ->from($table)
            ->where('CertNIK', $primary_key)
            //->where('CertStatus', 1)
            ->where('CertProcessId', $process_id)
            ->get();
        $result = $query->result_array();

        $row1 = $query->row();

        // get options
        $options = array();
        $options['CertItem'] = array();
        $query = $this->db->select('CertItemId,CertItemName')
           ->from($this->cms_complete_table_name('certification_item'))
           ->where('CertItemStatus',1)
           ->order_by('CertItemName','ASC')
           ->get();
        foreach($query->result() as $row){
            $options['CertItem'][] = array('value' => $row->CertItemId, 'caption' => $row->CertItemName);
        }
                    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $this->cms_module_path(),
        );

        //$sessionData = array('CertProcessId' => $row1->CertProcessId);
        //$this->session->set_userdata($sessionData);

        return $this->load->view($this->cms_module_path().'/field_profile_certification',$data, TRUE);
    }

    // returned on view
    public function _callback_column_certification($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('CertId,CertNIK,CertDate,CertItem,CertProduct,CertName,CertPartnerName,CertValidStart,CertValidFinish,CertFileName,CertFileUrl,CertStatus,CertApv,CertProcessId,CertUpdatedBy')
            ->from($this->cms_complete_table_name('profile_certification'))
            ->where('CertNIK', $row->NIK)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' Technical';
        }else if($num_row>0){
            return $num_row .' Technical';
        }else{
            return 'No Technical';
        }
    }



    // returned on insert and edit
    public function _callback_field_project($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');
        
        $last_update    = $this->input->get('state');
        $last_id_update = $this->input->get('id');
        if(!is_null($last_update) || !empty($last_update) || isset($last_update) || $last_update !=""){
            $table      = $this->cms_complete_table_name('profile_projecthistory_temp');
            $process_id = $last_id_update;
        }
        else{
            $table      = $this->cms_complete_table_name('profile_projecthistory');
            $process_id = $this->_callback_my_form_cv();
        }

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('ProjectId,ProjectNIK,ProjectDate,ProjectName,ProjectInstitution,ProjectYear,ProjectLength,ProjectTechnicalSpec,ProjectPosition,ProjectFileName,ProjectFileUrl,ProjectStatus,ProjectApv,ProjectProcessId,ProjectUpdatedBy')
            ->from($table)
            ->where('ProjectNIK', $primary_key)
            ->where('ProjectProcessId', $process_id)
            ->get();
        $result = $query->result_array();

        // get options
        $options = array();
                    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $this->cms_module_path(),
        );
        return $this->load->view($this->cms_module_path().'/field_profile_project',$data, TRUE);
    }

    // returned on view
    public function _callback_column_project($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('ProjectId,ProjectNIK,ProjectDate,ProjectName,ProjectInstitution,ProjectYear,ProjectLength,ProjectTechnicalSpec,ProjectPosition,ProjectFileName,ProjectFileUrl,ProjectStatus,ProjectApv,ProjectProcessId,ProjectUpdatedBy')
            ->from($this->cms_complete_table_name('profile_projecthistory'))
            ->where('ProjectNIK', $row->NIK)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' Project';
        }else if($num_row>0){
            return $num_row .' Project';
        }else{
            return 'No Project';
        }
    }


    // returned on insert and edit
    public function callback_field_files($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        $last_update    = $this->input->get('state');
        $last_id_update = $this->input->get('id');
        if(!is_null($last_update) || !empty($last_update) || isset($last_update) || $last_update !=""){
            $table      = $this->cms_complete_table_name('profile_files_temp');
            $process_id = $last_id_update;
        }
        else{
            $table      = $this->cms_complete_table_name('profile_files');
            $process_id = $this->_callback_my_form_cv();
        }

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('file_id,file_type,url,file_code')
            ->from($table)
            ->where('file_nik', $primary_key)
            ->where('file_process_id', $process_id)
            ->get();
        $result = $query->result_array();

       

        // get options
        $options = array();

        $options['file_type'] = array();
        $query = $this->db->select('FilesTypeId,FilesTypeName,FilesTypeCode,FilesTypeStatus')
           ->from($this->cms_complete_table_name('files_type'))
           ->get();
        foreach($query->result() as $row){
            $options['file_type'][] = array('value' => $row->FilesTypeId, 'caption' => $row->FilesTypeName);
        }


        
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $this->cms_module_path(),
        );
        return $this->load->view($this->cms_module_path().'/field_profile_files',$data, TRUE);
    }

    // returned on view
    public function callback_column_files($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('file_id,file_type,url,file_code')
            ->from($this->cms_complete_table_name('profile_files'))
            ->where('file_nik', $row->NIK)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' Files';
        }else if($num_row>0){
            return $num_row .' Files';
        }else{
            return 'No Files';
        }
    }

    private function randomize_string($value){
        $time = date('Y:m:d H:i:s');
        return substr(md5($value.$time),0,9);
    }

    private function no_string($value){
        $stime = '';
        return $stime;
    }





    
    // returned on view
    public function _callback_column_TermsAndConditions($value, $row){
       return '<div><label><input type="checkbox" id="checkbox1" name="TermsAndConditions" value="1" />I accept the terms and conditions </label></div>

            <div id="autoUpdate" class="alert alert-info autoUpdate">
                 <ol>
                  <li>Saya bertanggung jawab atas kebenaran data-data yang saya berikan</li>
                  <li>Setelah saya klik tombol Process, Maka Form CV saya sebelumnya akan diproses approval ulang</li>
                  <li>Setelah saya selesai mengupdate data, akan diinformasikan kembali  via email ke saya dan  PIC di HRM</li>
                  <li>Jika Anda tidak melakukan perubahan form CV, silahkan klik Cancel untuk kembali</li>
                </ol>   
            
            </div>';

           

    }


    public function _callback_my_profile(){
      
        $result = mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$this->cms_user_id());
        $storeArray = Array();
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $storeArray['company'] =  $row['CompanyId'];
            $storeArray['dept'] =  $row['DeptID'];
            $storeArray['sex'] =  $row['Sex'];
            $storeArray['status_diri'] =  $row['StatusDiri'];
            $storeArray['process_cv'] =  $row['ProcessCV'];
            $storeArray['process_cv_number'] =  $row['ProcessCVNumber'];  
        }

        return $storeArray;     
    
    }

    public function _callback_my_form_cv(){
      
        $result = mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$this->cms_user_id());
        $row = mysql_fetch_array($result);

        return $row['ProcessCVNumber'];     
    
    }

    public function _callback_my_form_cv_status(){
      
        $result = mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$this->cms_user_id());
        $row = mysql_fetch_array($result);

        return $row['ProcessCV'];     
    
    }


    //CALLBACK FUNCTIONS
    public function _callback_edit_field_NIK1(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK1" class="chosen-select" data-placeholder="Atasan Langsung" style="width: 500px; display: none;">';
        $empty_select_closed= '</select>';
        
        $crud = new grocery_CRUD();
        $state = $crud->getState();

        $session_nik = $this->cms_user_id();
        $my_profile = $this->_callback_my_profile();

        $dta = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = $session_nik"));
    

            $this->db->select('tbl_profile.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_profile.Email AS Email')
                     ->from($this->cms_complete_table_name('apv_group_approval'))
                     ->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID',$my_profile['dept'])
                     ->order_by('iGroupApprovalListId','ASC');

            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select Mengetahui</option>';

            foreach($db->result() as $row):               
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.' ['.$row->Email.']</option>';
                
            endforeach;
            return $empty_select.$empty_select_closed;
    }

    //CALLBACK FUNCTIONS
    public function _callback_edit_field_NIK2(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK2" class="chosen-select" data-placeholder="Select HRD" style="width: 500px; display: none;">';
        $empty_select_closed= '</select>';
        
        $crud = new grocery_CRUD();
        $state = $crud->getState();

        $my_profile = $this->_callback_my_profile();
        $hrd_modules = $this->cms_get_config('hrd_profile_modules');

        $session_nik = $this->cms_user_id();
        
        $dta = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = $session_nik"));
    

            $this->db->select('hrd_nik,hrd_name,hrd_email')
                     ->from($this->cms_complete_table_name('apv_hrd'))
                     //->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     ->where('hrd_status',1)
                     ->where('hrd_company',$my_profile['company'])
                     ->where('hrd_modules',$hrd_modules)
                     ->order_by('hrd_name','ASC');

            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select Mengetahui</option>';

            foreach($db->result() as $row):               
                    $empty_select .= '<option value="'.$row->hrd_nik.'">'.$row->hrd_name.' ['.$row->hrd_email.']</option>';
                
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;
    }
    

    public function _callback_state_action(){
        $crud = $this->new_crud();
        $state = $crud->getState();
        return $state;    
    }


    public function _callback_insert_rows($id,$table_name_ori,$table_name_temp,$session_nik,$primary_column){

    $sql = mysql_query("SELECT * FROM $table_name_ori WHERE $primary_column ='$id'");

        while ($row = mysql_fetch_assoc($sql)){
            foreach ($row as $field => $value){

                if ($field != "$primary_column"){
                        $fields .= "$field, ";
                        $values .= "'$value', ";
                   }
            }
                  
            $fields = preg_replace('/, $/', '', $fields);
            $values = preg_replace('/, $/', '', $values);                    

            $sql = "INSERT INTO $table_name_temp ($fields) VALUES ($values)";
            mysql_query($sql);
            //$new_id = mysql_insert_id();                                    

        }

    }

    public function _callback_primary_column_name($table_name_ori){
        $res = mysql_query("SHOW COLUMNS FROM $table_name_ori");
        $row = mysql_fetch_assoc($res);
        return $row['Field'];
    }

    public function _callback_primary_column_nik($table_name_ori){
        $qColumnNames = mysql_query("SHOW COLUMNS FROM $table_name_ori");
        $numColumns   = mysql_num_rows($qColumnNames);
        $x = 0;
        while ($x < $numColumns){
            $colname = mysql_fetch_row($qColumnNames);
            $col[$x] = $colname[0];
            $x++;
        }

        $array = array_values($col);
        return $array[1];

    }

    public function _callback_session_process_id(){

        $query = $this->db->select('ProcessCVNumber')
            ->from($this->cms_complete_table_name('profile'))
            ->where('NIK', $this->cms_user_id())
            ->get();
        $result = $query->result_array();
        $row    = $query->row();

        
        $options = array();                    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
        );
        


        $sessionData = array('ProcessCVNumber' => $row->ProcessCVNumber);
        $last_process = $this->session->set_userdata($sessionData);
        return $last_process;


    }


    public function _callback_last_process_id(){

        $last_no    = mysql_query("SELECT * FROM tbl_profile_process WHERE ProcessNIK = '".$this->cms_user_id()."' AND ProcessId < '".$this->_callback_my_form_cv()."' ORDER BY ProcessId DESC LIMIT 1");
        $jumlah     = mysql_num_rows($last_no);
        $dataku     = mysql_fetch_array($last_no);

        if ($jumlah > 0){
            $before_form = $dataku['ProcessId'];
        }else{
            $before_form = 0;
        }
        return $before_form;


    }

    public function certification_expired_date($nik){

        /*
        $today  = date('Y-m-d');

        $query  = mysql_query('SELECT * FROM tbl_profile_certification WHERE CertNIK='.$nik);
        $total  = mysql_num_rows($query);

        if ($total >0){
            while($data = mysql_fetch_array($query)){
                $tanggal       = $data['CertValidFinish'];
                $input         = strtotime('$tanggal');          
                $the_7th_day   = date('Y-m-d',strtotime('+7 day',$input));

                $input = strtotime("2016-07-07");
                $Periode1 = date('Y-m-d',strtotime('+7 day',$input1));

                if ($today > $the_7th_day){
                    mysql_query('UPDATE tbl_profile_certification SET CertStatus="0" WHERE CertId ="'.$data['CertId'].'"');
                }
                else{
                    mysql_query('UPDATE tbl_profile_certification SET CertStatus="1" WHERE CertId ="'.$data['CertId'].'"');
                }
            }
        }


        $query_temp  = mysql_query('SELECT * FROM tbl_profile_certification_temp WHERE CertNIK='.$nik);
        $total_temp  = mysql_num_rows($query_temp);

        if ($total_temp >0){
            while($data_temp = mysql_fetch_array($query_temp)){
                $tanggal_temp       = $data_temp['CertValidFinish'];
                $input_temp         = strtotime('$tanggal_temp');
                $the_7th_day_temp   = date('Y-m-d',strtotime('+7 day',$input_temp));

                if ($today > $the_7th_day_temp){
                    mysql_query('UPDATE tbl_profile_certification_temp SET CertStatus="0" WHERE CertId ="'.$data_temp['CertId'].'"');
                }
                else{
                    mysql_query('UPDATE tbl_profile_certification_temp SET CertStatus="1" WHERE CertId ="'.$data_temp['CertId'].'"');
                }
            }
        }

        */        

        mysql_query("UPDATE tbl_profile_certification SET CertStatus='0' WHERE CertNIK ='$nik' AND CertValidFinish <=(NOW() - INTERVAL 7 DAY)");
        mysql_query("UPDATE tbl_profile_certification_temp SET CertStatus='0' WHERE CertNIK ='$nik' AND CertValidFinish <=(NOW() - INTERVAL 7 DAY)");

        mysql_query("UPDATE tbl_profile_certification SET CertStatus='0' WHERE CertNIK='$nik' AND CertValidFinish <=(NOW() - INTERVAL 7 DAY)");
        mysql_query("UPDATE tbl_profile_certification_temp SET CertStatus='0' WHERE CertNIK='$nik' AND CertValidFinish <=(NOW() - INTERVAL 7 DAY)");

        

    }





}