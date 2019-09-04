<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 *
 * @author Dompak
 */
class frmProfile extends CMS_Priv_Strict_Controller {
    
    
    
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
        $today       = date('Y-m-d H:i:s');

        //$MAXIMUM_FILESIZE = 1000 * 1000;
        //$rEFileTypes ="/^\.(jpg|jpeg){1}$/i";

        // this is just for code completion
        if (FALSE) $crud = new Extended_Grocery_CRUD();

        $this->load->config('grocery_crud');
        $this->config->set_item('grocery_crud_file_upload_allow_file_types','jpeg|jpg|png');

        
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
        //$crud->unset_back_to_list();
        $crud->unset_print();
        $crud->unset_export();

        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_country_model');
        */

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('no-search-flexigrid');
            $crud->set_relation('CompanyId', $this->cms_complete_table_name('company'), 'cCompanyCode');
            $crud->display_as('NoBPJSKes','No. BPJS');
            $crud->display_as('member','Anggota Keluarga');
            $crud->display_as('NoKTP','No. KTP');
            $crud->display_as('Nama','Name'); 
            //$crud->unset_edit();
        }else{
            $crud->set_theme('no-flexigrid_1');
            $crud->set_relation('CompanyId', $this->cms_complete_table_name('company'), 'cCompanyName');
            $crud->display_as('NoBPJSKes','No. BPJS Kesehatan');
            $crud->display_as('member','Anggota Keluarga (Maksimal 3 Anak & 1 Suami/Istri)');
            $crud->display_as('NoKTP','No KTP/ e-KTP');
            $crud->set_relation('StatusDiri', $this->cms_complete_table_name('StatusDiri'), 'StatusDiriName');
            $crud->display_as('Nama','Full Name'); 
        }


        if ($this->uri->segment(5) != $session_nik){
            //$crud->set_theme('flexigrid');
            $crud->unset_edit();
            //$crud->unset_read();
        }


        $my_profile = $this->_callback_my_profile();

        if ($my_profile['company_status'] ==0){
            $crud->unset_back_to_list();
        }
        


        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->cms_complete_table_name('profile'));
        $crud->where('NIK', $session_nik);

        // primary key
        $crud->set_primary_key('NIK');

        // set subject
        $crud->set_subject('Karyawan');

        // displayed columns on list
		$crud->columns('Photos','Nama','NIK','NoKK','NoKTP','TglKTP','Sex','Agama','TglLahir','TptLahir','AlamatKTP','AlamatDomisili','Kodepos','Telp','Hp','BloodType','StatusDiri','NamaIbuKandung','NoNPWP','NoKPJ','NoBPJSKes','EmailPribadi','CompanyId','DivisiID','DeptID','UnitID','SeksiID','Email','member');
		
        $crud->unset_edit_fields('UpdatedBy','UpdatedTime');
        $crud->field_type('UpdatedBy', 'hidden', $session_nik);
        $crud->field_type('UpdatedTime', 'hidden', $today);
		
        // displayed columns on edit operation
        if ($state =='read'){
		$crud->edit_fields('Photos','NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','AlamatKTP','AlamatDomisili','Kodepos','Telp',
                            'Hp','Email','StatusDiri','TglMenikah','TglMasuk','TglKeluar','CompanyId','DivisiID','DeptID','UnitID','SeksiID','JabatanID','JmlAnak','Status','NoNPWP','NoKPJ','NamaIbuKandung');
        }
        else{
        $crud->edit_fields('Photos','NIK','NoKK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','AlamatKTP','CityKTP','KodeposKTP','AlamatDomisili','CityDomisili','Kodepos','Telp','Hp','BloodType','StatusDiri','NamaIbuKandung','NoNPWP','NoKPJ','NoBPJSKes','EmailPribadi','CompanyId','DivisiID','DeptID','UnitID','SeksiID','Email','UpdatedBy','UpdatedTime','member','Files','EmsaData','TermsAndConditions');

        }		
       
        $data = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = ".$session_nik));
        $_SESSION['old_NoKTP']         = $data['NoKTP'];
        $_SESSION['old_NoKK']         = $data['NoKK'];
        $_SESSION['old_TglKTP']        = $data['TglKTP'];
        $_SESSION['old_Nama']          = $data['Nama'];
        $_SESSION['old_Sex']           = $data['Sex'];
        $_SESSION['old_Agama']         = $data['Agama'];
        $_SESSION['old_TglLahir']      = $data['TglLahir'];
        $_SESSION['old_TptLahir']      = $data['TptLahir'];
        $_SESSION['old_Telp']          = $data['Telp'];
        $_SESSION['old_Hp']            = $data['Hp'];
        $_SESSION['old_CompanyId']     = $data['CompanyId'];
        $_SESSION['old_DivisiID']      = $data['DivisiID'];
        $_SESSION['old_DeptID']        = $data['DeptID'];
        $_SESSION['old_UnitID']        = $data['UnitID'];
        $_SESSION['old_SeksiID']       = $data['SeksiID'];
        $_SESSION['old_StatusDiri']    = $data['StatusDiri'];
        $_SESSION['old_NoNPWP']        = $data['NoNPWP'];
        $_SESSION['old_NoKPJ']         = $data['NoKPJ'];
        $_SESSION['old_NoBPJSKes']     = $data['NoBPJSKes'];
        $_SESSION['old_BloodType']     = $data['BloodType'];
        $_SESSION['old_TglKTPever']    = $data['TglKTPever'];
        

        $_SESSION['old_NamaIbuKandung']= $data['NamaIbuKandung'];

        $AlamatDomisili = str_ireplace("\\r\\n", "\r\n", $data['AlamatDomisili']);
        $AlamatKTP = str_ireplace("\\r\\n", "\r\n", $data['AlamatKTP']);

        $_SESSION['old_AlamatDomisili'] = $AlamatDomisili;
        $_SESSION['old_CityDomisili']   = $data['CityDomisili'];
        $_SESSION['old_Kodepos']        = $data['Kodepos'];

        $_SESSION['old_AlamatKTP']      = $AlamatKTP;
        $_SESSION['old_CityKTP']        = $data['CityKTP'];
        $_SESSION['old_KodeposKTP']     = $data['KodeposKTP'];
        $_SESSION['old_TglMasuk']       = $data['TglMasuk'];


		
		$crud->add_fields('Photos','NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','AlamatDomisili','Kodepos','Telp',
                            'Hp','Email','AlamatKTP','StatusDiri','TglMenikah','TglMasuk','TglKeluar','BandSkrg','Status',
                            'CompanyId','DivisiID','DeptID','UnitID','JabatanID','JmlAnak');
		


        //$crud->set_field_upload('Photos','assets/uploads/files/');

        $crud->set_field_upload('Photos','assets/uploads/files');
        //$crud->set_field_upload('Photos','modules/'.$this->cms_module_path().'/assets/uploads');
        // caption of each columns		
				
        $crud->display_as('NIK','NIK');
        $crud->display_as('TglKTP','Tgl KTP Berlaku Hingga');
        $crud->display_as('Sex','Sex');
        $crud->display_as('BandSkrg','Band');
        $crud->display_as('TglMasuk','Tgl Mulai Bergabung');
        $crud->display_as('Status','Status');
        $crud->display_as('StatusDiri','Marital Status');
        $crud->display_as('CompanyId','Company');
        $crud->display_as('DivisiID','Division');
        $crud->display_as('DeptID','Department');
        $crud->display_as('UnitID','Unit');
        $crud->display_as('SeksiID','Section');
        $crud->display_as('JabatanID','Job Title Structural');
        $crud->display_as('JobId','Job Title Fungsional');        
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
        $crud->display_as('NamaIbuKandung','Mother’s Name');
        $crud->display_as('NoKPJ','No. KPJ');
        $crud->display_as('BloodType','Blood Type');
        $crud->display_as('Telp','Telp');
        $crud->display_as('Hp','HP');
        $crud->display_as('EmailPribadi','Email Pribadi');
        $crud->display_as('Email','Email Perusahaan');
        $crud->display_as('TermsAndConditions','Terms & Conditions');
        $crud->display_as('Files','Attachment Scan KTP & KK');
        $crud->display_as('Agama','Relegion');
        $crud->display_as('NoKK','No Kartu Keluarga');            
        $crud->display_as('NIK','NIK Karyawan');   
        $crud->display_as('EmsaData','Data Hardware & Software');
        

        $crud->change_field_type('NoKTP', 'integer');
        // /$crud->change_field_type('KodeposKTP', 'integer');
        $crud->change_field_type('Kodepos', 'integer');
        $crud->change_field_type('NoKK', 'integer');        
				
		
		// $crud->required_fields( $field1, $field2, $field3, ... );		
        $crud->required_fields('NoKK','Nama','NoKTP','Sex','TglLahir','TptLahir','Agama','Status','AlamatKTP','CityKTP','KodeposKTP','AlamatDomisili','CityDomisili','Kodepos','Hp','BloodType','StatusDiri','NamaIbuKandung','NoNPWP','EmailPribadi','Email','TglMasuk','TermsAndConditions');
       
		
		//$crud->unique_fields( $field1, $field2, $field3, ... );
		$crud->unique_fields('NIK');
       		

		$crud->set_relation('Status', $this->cms_complete_table_name('status'), 'StatusName');
        $crud->set_relation('Sex', $this->cms_complete_table_name('sex'), 'SexNameEng');        
        $crud->set_relation('DivisiID', $this->cms_complete_table_name('div'), 'cDivName');
        $crud->set_relation('DeptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        $crud->set_relation('UnitID', $this->cms_complete_table_name('unit'), 'NamaUnit');
        $crud->set_relation('SeksiID', $this->cms_complete_table_name('section'), 'cSectionName');
        $crud->set_relation('JabatanID', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');
        
        $crud->set_relation('Agama', $this->cms_complete_table_name('agama'), 'agama_name');

        $crud->set_primary_key('BloodTypeName',$this->cms_complete_table_name('blood_type'));
        $crud->set_relation('BloodType', $this->cms_complete_table_name('blood_type'), 'BloodTypeName');

        $crud->set_primary_key('City',$this->cms_complete_table_name('city'));
        $crud->set_relation('TptLahir', $this->cms_complete_table_name('city'), 'City');
        $crud->set_relation('CityKTP', $this->cms_complete_table_name('city'), 'City');
        $crud->set_relation('CityDomisili', $this->cms_complete_table_name('city'), 'City');     	
			
		$crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));
        //$crud->callback_column('NIK',array($this,'_callback_NIK'));
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

        
        $crud->callback_column('member',array($this, '_callback_column_member'));
        $crud->callback_field('member',array($this, '_callback_field_member'));

        $crud->callback_column('Files',array($this, 'callback_column_files'));
        $crud->callback_field('Files',array($this, 'callback_field_files'));

        //$crud->callback_column('Photos',array($this,'_callback_column_Photos'));
        $crud->callback_column('StatusDiri',array($this,'_callback_column_StatusDiri'));


        // Callback for Edit Field
        $crud->callback_edit_field('TermsAndConditions', array($this, '_callback_column_TermsAndConditions'));
        $crud->callback_edit_field('NoBPJSKes',array($this,'_callback_edit_field_NoBPJSKes'));
        $crud->callback_edit_field('NoNPWP',array($this,'_callback_edit_field_NoNPWP'));
        $crud->callback_edit_field('NoKTP',array($this,'_callback_edit_field_NoKTP'));
        $crud->callback_edit_field('Hp',array($this,'_callback_edit_field_Hp'));
        //$crud->callback_edit_field('BloodType',array($this,'_callback_edit_field_BloodType'));
        $crud->callback_edit_field('Email',array($this,'_callback_edit_field_Email'));
        $crud->callback_edit_field('EmailPribadi',array($this,'_callback_edit_field_EmailPribadi'));

        $crud->callback_edit_field('KodeposKTP',array($this,'_callback_edit_field_KodeposKTP'));
        $crud->callback_edit_field('Kodepos',array($this,'_callback_edit_field_Kodepos'));
        $crud->callback_edit_field('NamaIbuKandung',array($this,'_callback_edit_field_NamaIbuKandung'));

        $crud->callback_edit_field('NIK',array($this,'_callback_edit_field_NIK'));
        $crud->callback_edit_field('NoKK',array($this,'_callback_edit_field_NoKK'));
        $crud->callback_edit_field('NoKPJ',array($this,'_callback_edit_field_NoKPJ'));

        $crud->callback_edit_field('TglKTP',array($this,'_callback_edit_field_TglKTP'));
        $crud->callback_column('TglKTP',array($this, '_callback_column_TglKTP'));

        $crud->callback_edit_field('EmsaData',array($this,'_callback_edit_field_EmsaData'));


        $this->crud = $crud;
        return $crud;
    }


    public function _example_output($output = null){

        $my_profile = $this->_callback_my_profile();

        $data = array(
            'company_status' => $my_profile['company_status'],             
        );

        $output   = array_merge((array)$output, $data);

        $this->view($this->cms_module_path().'/frmProfile_view', $output,
        $this->cms_complete_navigation_name('frmProfile'));    
    }


    public function index(){
        $this->dbemsa = $this->load->database('emsa', TRUE);

        if($this->uri->segment('5') != $this->cms_user_id() && $this->uri->segment('4') == 'edit'){
            redirect('karyawan/frmProfile','refresh');
        }
         
        $crud = $this->make_crud();       

        $dd_data = array(
                //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
                'dd_state' =>  $crud->getState(),                
                
                'dd_dropdowns' => array('CompanyId','DivisiID','DeptID','UnitID','SeksiID'),
                
                'dd_url' => array('', site_url().'/karyawan/frmProfile/get_states/', site_url().'/karyawan/frmProfile/get_cities/', site_url().'/karyawan/frmProfile/get_units/',site_url().'/karyawan/frmProfile/get_seksi/'),
                
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

    public function _before_update($post_array, $primary_key){
        $post_array = $this->_before_insert_or_update($post_array, $primary_key);

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        // SAVE CHANGES OF photo
        //  * The photo data in in json format.
        //  * It can be accessed via $_POST['md_real_field_photos_col']
        //
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data = json_decode($this->input->post('md_real_field_photos_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('file_id', 'url','file_code');
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
            $this->db->delete($this->cms_complete_table_name('profile_attachment'),
                 array('file_id'=>$detail_primary_key));
        }
        
        foreach($insert_records as $insert_record){

           $MAXIMUM_FILESIZE = 1000 * 1000;
           $rEFileTypes ="/^\.(jpg|jpeg){1}$/i";

            $upload_path = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index = $insert_record['record_index'];
            $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", " ","","-"), 
                     trim($_FILES['md_field_photos_col_url_'.$record_index]['name']));

            $fsize     = $_FILES['md_field_photos_col_url_'.$record_index]['size']; 

            $tmp_name  = $_FILES['md_field_photos_col_url_'.$record_index]['tmp_name'];
            $type_name  = $_FILES['md_field_photos_col_url_'.$record_index]['type'];
            $file_name = $_FILES['md_field_photos_col_url_'.$record_index]['name'];
            $file_name = $this->randomize_string($file_name).$safe_filename;
            $file_code = $_FILES['md_field_photos_col_url_'.$record_index]['name'];  
                   


            $data = array(
                'url' => $file_name,
                'file_code' => $file_code,
            );

            $data['file_nik'] = $primary_key;
            
            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){

                return $post_array;

            }else{

                $file_anda = round($fsize/1000000,2);

                echo "<script language='javascript'>alert('Error!!!  File harus jpg atau jpeg dan size maksimal 1 MB, size=[$file_anda MB] & type=[$type_name]');</script>";
                return FALSE;
                
            }
            
            
            
        }

        
        
    }

    public function _after_update($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);

        $seumur_hidup = $post_array['TglKTPever'];
        if ($seumur_hidup =='TglKTP'){
            $value_ktp = 1;
            $this->db->update($this->cms_complete_table_name('profile'),array('TglKTP'=>NULL), array('NIK'=>$primary_key));
        }else{
            $value_ktp = 0;
        }

        $this->db->update($this->cms_complete_table_name('profile'),array('TglKTPever'=>$value_ktp), array('NIK'=>$primary_key));
    
        include "email_frmProfile.php";
        include "email2hrd_frmProfile.php";
    
        echo "<script language='javascript'>alert('Data Sudah Disimpan dan Email sudah dikirim...');</script>";

        return $success;
    }

    public function _before_delete($primary_key){

        return TRUE;
    }

    public function _after_delete($primary_key){
        return TRUE;
    }

    public function _after_insert_or_update($post_array, $primary_key){


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        // SAVE CHANGES OF photo
        //  * The photo data in in json format.
        //  * It can be accessed via $_POST['md_real_field_photos_col']
        //
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $this->copy_photo_user_ftp($post_array, $primary_key);

        $data = json_decode($this->input->post('md_real_field_photos_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('file_id', 'url','file_code');
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
            $this->db->delete($this->cms_complete_table_name('profile_attachment'),
                 array('file_id'=>$detail_primary_key));
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  INSERTED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($insert_records as $insert_record){
            //$this->load->library('image_moo',$this->config);
            /*
            $this->load->library('upload', $config);
            
            $config =  array(
                  'allowed_types'   => "jpg|jpeg",
                  'overwrite'       => TRUE,
                  'max_size'        => "1000KB",
                  'max_height'      => "768",
                  'max_width'       => "1024"   
                );
            */

            //$config['upload_path'] = './uploads/';
            /*
            $config['allowed_types'] = 'gif|jpg';
            $config['max_size'] = '100KB';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';


            $this->load->library('upload', $config);
            */

            // Size must under 15 KB
            $MAXIMUM_FILESIZE = 1000 * 1000; 

            $upload_path = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';

            $record_index = $insert_record['record_index'];

            $rEFileTypes ="/^\.(jpg|jpeg){1}$/i";


            $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", " ","","-"), 
                     trim($_FILES['md_field_photos_col_url_'.$record_index]['name']));

            $fsize     = $_FILES['md_field_photos_col_url_'.$record_index]['size'];
            
            $tmp_name  = $_FILES['md_field_photos_col_url_'.$record_index]['tmp_name'];
            $file_name = $_FILES['md_field_photos_col_url_'.$record_index]['name'];
            $file_name = $this->randomize_string($file_name).$safe_filename;
            $file_code = $_FILES['md_field_photos_col_url_'.$record_index]['name'];  
                   
            $file_server = $_SERVER['SERVER_NAME'];

            $data = array(
                'url' => $file_name,
                'file_code' => $file_code,
                'file_server' => $file_server,
            );

            $data['file_nik'] = $primary_key;
            
            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $this->db->insert($this->cms_complete_table_name('profile_attachment'), $data);

                // Duplicate file to another server using ftp
                $ftp_server     = '172.17.0.32'; // destination server
                $ftp_user_name  = 'operator'; // username ftp destination server
                $ftp_user_pass  = 'L3ts4sim.2a'; // password ftp destination server
                //$file           = $upload_path.$file_name;//tobe uploaded
                $file           = 'http://172.17.0.16/hris2/modules/karyawan/assets/uploads/'.$file_name;//tobe uploaded
                $remote_file    = '/hris2/modules/karyawan/assets/uploads/'.$file_name; // address file destination

                $conn_id = ftp_connect($ftp_server);
                $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)) {
                 
                } else {
                   
                }
                
                ftp_close($conn_id); // close the connection

            }
            
            
            //$thumbnail_name = 'thumb_'.$file_name;
            //$this->image_moo->load($upload_path.$file_name)->resize(800,75)->save($upload_path.$thumbnail_name,true);
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
        $real_column_names = array('MemberId', 'MemberName', 'MemberTempatLahir','MemberLahir', 'MemberStatus', 'MemberSex' ,'MemberBloodType' ,'MemberKTP');
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
            $this->db->delete($this->cms_complete_table_name('profile_member'),
                 array('MemberId'=>$detail_primary_key));
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
            $data['NIK'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('profile_member'),
                 $data, array('MemberId'=>$detail_primary_key));
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
            $data['NIK'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('profile_member'), $data);
            $detail_primary_key = $this->db->insert_id();
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
            return "<img src='http://".$_SERVER['SERVER_NAME']."/hris2/assets/uploads/files/".$image."' width=50>";
        }
        else {
            if ($Sex =='L'){
            $image = 'Male.png';
            }else {
            $image = 'Female.png';
            } 
           return "<img src='http://".$_SERVER['SERVER_NAME']."/hris2/assets/uploads/files/".$image."' width=50>";

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
        $query = $this->db->select('MemberId, NIK, MemberName, MemberTempatLahir , MemberLahir, MemberStatus, MemberSex , MemberBloodType ,MemberKTP')
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
        // /$options = array();
        $options['MemberSex'] = array();
        $query = $this->db->select('SexId,SexCode,SexName,SexNameEng')
           ->from($this->cms_complete_table_name('sex'))
           ->get();
        foreach($query->result() as $row){
            $options['MemberSex'][] = array('value' => $row->SexCode, 'caption' => $row->SexNameEng);
        }


        $options['MemberBloodType'] = array();
        $query = $this->db->select('BloodTypeId,BloodTypeName')
           ->from($this->cms_complete_table_name('blood_type'))
           ->get();
        foreach($query->result() as $row){
            $options['MemberBloodType'][] = array('value' => $row->BloodTypeName, 'caption' => $row->BloodTypeName);
        }

        $options['MemberTempatLahir'] = array();
        $query = $this->db->select('CityId,City')
           ->from($this->cms_complete_table_name('city'))
           ->get();
        foreach($query->result() as $row){
            $options['MemberTempatLahir'][] = array('value' => $row->City, 'caption' => $row->City);
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
        $query = $this->db->select('MemberId, NIK, MemberName, MemberTempatLahir , MemberLahir, MemberStatus, MemberSex , MemberBloodType ,MemberKTP')
            ->from($this->cms_complete_table_name('profile_member'))
            ->where('NIK', $row->NIK)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' orang';
        }else if($num_row>0){
            return $num_row .' orang';
        }else{
            return 'No Body';
        }
    }


    // returned on insert and edit
    public function callback_field_files($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('file_id, url,file_code')
            ->from($this->cms_complete_table_name('profile_attachment'))
            ->where('file_nik', $primary_key)
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
        return $this->load->view($this->cms_module_path().'/field_profile_attachment',$data, TRUE);
    }

    // returned on view
    public function callback_column_files($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('file_id, url,file_code')
            ->from($this->cms_complete_table_name('profile_attachment'))
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
                Saya bertanggung jawab atas kebenaran data-data yang saya berikan, <br/>
                Setelah saya selesai mengupdate data, akan diinformasikan kembali  via email ke saya dan  PIC di HRM.
            
            </div>';          

           

    }

   
    public function _callback_edit_field_NoKTP($value, $row){

        return '<input onkeypress="return isNumberKey(event);" type="text" name="NoKTP" placeholder="Nomor Induk Kependudukan ditulis tanpa spasi, contoh: 3216062403xxxxxx" class="form-control" value="'.$value.'">';
        
    }


    public function _callback_edit_field_Hp($value, $row){

        return '<input onkeypress="return isNumberKey(event);" maxlength="12" type="text" name="Hp" placeholder="08211321xxxx" class="form-control" value="'.$value.'">';
        
    }

    public function _callback_edit_field_EmsaData($value, $row){        
        $nik = $row;
        $SQL = "SELECT b.cSTokNewTag,b.cSTokOldTag,iTransID,cItemName Item,
                CASE WHEN d.Description IS NULL THEN '-' ELSE d.Description END OS,
                CASE WHEN cProcessorName IS NULL THEN '-' ELSE cProcessorName END cProcessorName,
                CASE WHEN cRAMName IS NULL THEN '-' ELSE cRAMName END cRAMName,
                CASE WHEN iHDCapacity IS NULL THEN '-' ELSE iHDCapacity END iHDCapacity,
                CASE WHEN cStokProcSpeed IS NULL THEN '-' ELSE cStokProcSpeed END cStokProcSpeed FROM tbl_trans a
                LEFT JOIN tbl_stock b ON a.itransStokID=b.iStokID
                LEFT JOIN tbl_item c ON b.iStokItem=c.iItemID
                LEFT JOIN tbl_os d ON b.iStokOS=d.OSID
                LEFT JOIN tbl_processor e ON b.iStokProc=e.cProcessorName
                LEFT JOIN tbl_ram f ON b.iStokRAm=f.iRAMId
                LEFT JOIN tbl_hdd g ON b.iStokHD=g.iHDId
                WHERE iTransNik = ".$nik." AND bTransStatus = 0";

        $query = $this->dbemsa->query($SQL);
        foreach ($query->result() as $row)
        {
                $Tagging = $row->cSTokNewTag;
                $TaggingOld = $row->cSTokOldTag;
                $Item =  $row->Item;
                $OS =  $row->OS;   
                $cProcessorName =  $row->cProcessorName;   
                $cRAMName =  $row->cRAMName;   
                $iHDCapacity =  $row->iHDCapacity;            
                $TransID =  $row->iTransID;
                $Spesification = 'Processor '.$row->cProcessorName.' '.$row->cStokProcSpeed.'<br/>Memory '.$row->cRAMName.' HDD'.$row->iHDCapacity;                
        }

        //$TransID = 2360;
        $options['softwarestd'] = array();
        $options['softwarenonstd'] = array();
        $SQLSoft = "SELECT b.Description,b.Standard FROM tbl_transdetail_soft a
                    LEFT JOIN tbl_tools b ON a.iTSToolId=b.ToolsID  WHERE iTSTransID = ".$TransID;
        $query = $this->dbemsa->query($SQLSoft);
        $software = "";
        $datasoft = 0;
        foreach ($query->result() as $row)
        {
                if($row->Standard==1) {
                    $options['softwarestd'][] = $row->Description;
                } elseif ($row->Standard==0) {
                    $options['softwarenonstd'][] = $row->Description;
                }
        } 



        $options['Tagging'] = $Tagging;
        $options['TaggingOld'] = $TaggingOld;
        $options['Item'] = $Item;
        $options['Spesification'] = $Spesification;
        $options['TransID'] = $TransID;

       
        $data = array(
                    'result' => $result,
                    'options' => $options,
                    'date_format' => $date_format,
                );

        return $this->load->view($this->cms_module_path().'/field_profile_emsa',$data, TRUE);
        
    }

    public function _callback_edit_field_BloodType($value, $row){

        return '<input onkeypress="return alphaOnly(event)" style="text-transform:uppercase;" type="text" name="BloodType" class="form-control" value="'.$value.'">';
        
    }


    public function _callback_edit_field_NoBPJSKes($value, $row){

        return '<input onkeypress="return isNumberKey(event);" type="text" name="NoBPJSKes" placeholder="Bagi yg sudah memiliki kartu BPJS Kesehatan, tulis dengan lengkap" class="form-control" value="'.$value.'">';
        
    }

    public function _callback_edit_field_NoNPWP($value, $row){

        return '<input onkeypress="return isNumberKey(event);" maxlength="15" type="text" name="NoNPWP" placeholder="Tanpa tanda titik atau strip, contoh: 47400560040xxxx" class="form-control" value="'.$value.'">';
        
    }
    

    public function _callback_edit_field_Email($value, $row){

        return '<input onblur="validateEmail(this.value);" type="text" name="Email" class="form-control" value="'.$value.'">';
        
    }

    public function _callback_edit_field_EmailPribadi($value, $row){

        return '<input onblur="validateEmail(this.value);" type="text" name="EmailPribadi" class="form-control" value="'.$value.'">';
        
    }


    public function _callback_edit_field_KodeposKTP($value, $row){

        return '<input onkeypress="return isNumberKey(event);" maxlength="5" type="text" name="KodeposKTP" placeholder="Kodepos sesuai Alamat di KTP" class="form-control" value="'.$value.'">';
        
    }

    public function _callback_edit_field_Kodepos($value, $row){

        return '<input onkeypress="return isNumberKey(event);" maxlength="5" type="text" name="Kodepos" placeholder="Kodepos sesuai Alamat Domisili" class="form-control" value="'.$value.'">';
        
    }

    public function _callback_edit_field_NoKK($value, $row){

        return '<input onkeypress="return isNumberKey(event);" maxlength="16" type="text" name="NoKK" placeholder="Nomor Kartu Keluarga ditulis hanya Angka" class="form-control" value="'.$value.'">';
        
    }

    public function _callback_edit_field_NamaIbuKandung($value, $row){

        return '<input type="text" name="NamaIbuKandung" placeholder="Tulis nama Ibu Kandung dengan lengkap" class="form-control" value="'.$value.'">';
        
    }

    public function _callback_edit_field_NIK($value, $row){

        return '<input disabled type="text" name="NIK" placeholder="NIK Karyawan" class="form-control" value="'.$value.'">';
        
    }

    public function _callback_edit_field_NoKPJ($value, $row){

        return '<input style="text-transform:uppercase;" type="text" name="NoKPJ" placeholder="BPJS Ketenagakerjaan D/H Jamsostek" class="form-control" value="'.$value.'">';
        
    }


    public function _callback_edit_field_TglKTP($value, $row){

        $this->db->select('*')
                     ->from('tbl_profile')
                     ->where('NIK', $this->cms_user_id());
            $db = $this->db->get();
            $row = $db->row(0);
            $TglKTPever = $row->TglKTPever;

        $js = '<script type = "text/javascript">
                $(document).ready(function () {
                    $(".input_control").change(function () {
                    $("input[name=" + this.value + "]")[0].disabled = this.checked;
                             
                }).change();
            });</script>';

        if (!is_null($value) && !empty($value) && $value !=""){
            $Tgl = date('d/m/Y', strtotime($value));
        }
        else{
            $Tgl = '';
        }

        
        if ($TglKTPever == 1){
            $check = 'checked';

        }else{
            $check = '';

        }
        
            return '<div class="row">
                      <div class="col-lg-6">
                        <div class="input-prepend">          
                          <input type="text" class="datepicker-input" name="TglKTP" value="'.$Tgl.'">
                          <a href="#" style="text-decoration: none;" class="glyphicon glyphicon-question-sign tip-top" data-toggle="tooltip" title="Check jika masa berlaku KTP seumur hidup"></a>
                          <span style="width:20px;float:left" class="add-on">
                            <input type="checkbox" class="input_control" value="TglKTP" name="TglKTPever" '.$check.'>  
                          </span>
                          <span style="width:150px;float:left" class="add-on">Seumur Hidup</span>
                        </div>
                      </div>
                      </div>'.$js;
            
    }

    public function _callback_column_StatusDiri($value, $row){

        $module_path = $this->cms_module_path();
        $query = $this->db->select('MemberId, NIK, MemberName, MemberTempatLahir , MemberLahir, MemberStatus, MemberSex , MemberBloodType ,MemberKTP')
            ->from($this->cms_complete_table_name('profile_member'))
            ->where('NIK', $row->NIK)
            ->where('MemberStatus', 3)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            $jml = $num_row;
        }else if($num_row>0){
            $jml = $num_row;
        }else{
            $jml = 0;
        }

        $this->db->select('*')
                     ->from('tbl_statusdiri')
                     ->where('StatusDiriId', $value);
            $db = $this->db->get();
            $row = $db->row(0);
            $StatusDiri = $row->StatusDiriName;  

        if ($value ==1){
            return $value;
        }else{
            return $StatusDiri.'/'.$jml;
        }

        
    }


    public function _callback_my_profilexxx(){        
        $result = mysql_query("SELECT CompanyId AS CompanyId, DeptID AS DeptID, Sex AS Sex, StatusDiri AS StatusDiri, tbl_company.bStatus AS bStatus 
            FROM tbl_profile INNER JOIN tbl_company ON tbl_profile.CompanyId=tbl_company.iCompanyId 
            WHERE NIK=".$this->cms_user_id());


        $storeArray = Array();
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $storeArray['company'] =  $row['CompanyId'];
            $storeArray['dept'] =  $row['DeptID'];
            $storeArray['sex'] =  $row['Sex'];
            $storeArray['status_diri'] =  $row['StatusDiri'];
            $storeArray['company_status'] =  $row['bStatus'];
           
            
        }
        
        return $storeArray; 

    }


    public function _callback_my_profile(){        
        $mysqlcomm = "SELECT CompanyId AS CompanyId, DeptID AS DeptID, Sex AS Sex, StatusDiri AS StatusDiri, tbl_company.bStatus AS bStatus 
                      FROM tbl_profile INNER JOIN tbl_company ON tbl_profile.CompanyId=tbl_company.iCompanyId 
                      WHERE NIK=".$this->cms_user_id();
        $query = $this->db->query($mysqlcomm);              


        $storeArray = Array();
        foreach ($query->result() as $row)
        {   
                $storeArray['company'] =  $row->CompanyId;
                $storeArray['dept'] =  $row->DeptID;
                $storeArray['sex'] =  $row->Sex;
                $storeArray['status_diri'] =  $row->StatusDiri;
                $storeArray['company_status'] =  $row->bStatus;
        }

        $query = $this->db->query("INSERT INTO support_testing VALUES ('storeArray => ".json_encode($storeArray)."')");
        return $storeArray; 

    }


    




    public function _callback_column_TglKTP($value, $row){
        $module_path = $this->cms_module_path();
        $this->db->select('*')
                     ->from('tbl_profile')
                     ->where('NIK', $this->cms_user_id());
            $db = $this->db->get();
            $row = $db->row(0);
            $TglKTPever = $row->TglKTPever;

            if ($TglKTPever == 1){
                $TglKTP = 'Seumur Hidup';
            }else{
                if (is_null($row->TglKTP)){
                    $TglKTP = '-';
                }else{
                    $TglKTP = date('d-M-Y', strtotime($row->TglKTP));
                }                
                
            }

            return $TglKTP;


    }


    public function copy_photo_user_ftp($post_array, $primary_key){

        $this->load->library('image_moo', $this->config);        
        $this->load->library('upload', $config);

        $upload_path = FCPATH.'assets/uploads/files/';

        $this->db->select('*')
                     ->from('tbl_profile')
                     ->where('NIK', $primary_key);
        $db = $this->db->get();
        $data = $db->row(0);

        $file_name = $data->Photos;

        if (!is_null($file_name) || !empty($file_name)){

            $thumbnail_name = 'thumb_'.$file_name;
            $this->image_moo->load($upload_path.$file_name)->resize_crop(250,250)->save($upload_path.$thumbnail_name,true);
            // Duplicate file to another server using ftp
            $ftp_server     = '172.17.0.32'; // destination server
            $ftp_user_name  = 'operator'; // username ftp destination server
            $ftp_user_pass  = 'L3ts4sim.2a'; // password ftp destination server
            //$file           = $upload_path.$file_name;//tobe uploaded
            $file           = 'http://172.17.0.16/hris2/assets/uploads/files/'.$file_name;//tobe uploaded
            $remote_file    = '/hris2/assets/uploads/files/'.$file_name; // address file destination

            $file_thumb           = 'http://172.17.0.16/hris2/assets/uploads/files/'.$thumbnail_name;//tobe uploaded
            $remote_file_thumb    = '/hris2/assets/uploads/files/'.$thumbnail_name; // address file destination

            $conn_id        = ftp_connect($ftp_server);
            $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
            if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)) {
                ftp_put($conn_id, $remote_file_thumb, $file_thumb, FTP_BINARY);                 
            } else {
                   
            }
                
            ftp_close($conn_id); // close the connection
        }
    }

    public function Get_Spesification($stock_id){

        $this->db->select('cProcessorName, cStokProcSpeed, cRAMName, iHDCapacity, iStokType')
                 ->from('tbl_stock')
                 ->join('tbl_processor','iProcessorId=iStokProc')
                 ->join('tbl_hdd','iHDId=iStokHD')
                 ->join('tbl_ram','iRAMId=iStokRAM')
                 ->where('iStokID', $stock_id);
        $db = $this->dbemsa->get();
        $data = $db->row(0);
        $num_row = $db->num_rows();

        if ($num_row > 0 && ($data->iStokType==1 || $data->iStokType==2 || $data->iStokType==5)){
            return 'Processor '.$data->cProcessorName.' '.$data->cStokProcSpeed.'<br/>Memory '.$data->cRAMName.' HDD'.$data->iHDCapacity;
        }
        else{
            return '';
        }
    
    }
    




}