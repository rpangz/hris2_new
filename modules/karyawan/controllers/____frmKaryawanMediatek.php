<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 *
 * @author Dompak
 */
class frmKaryawanMediatek extends CMS_Priv_Strict_Controller {

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
        $company_id = $this->cms_get_config('cms_mediatek_id');
        $hrd_modules = $this->cms_get_config('hrd_profile_modules');

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
        $crud->unset_texteditor('AlamatDomisili');
        $crud->unset_texteditor('AlamatKTP');
        
        //$crud->unset_add();
        // $crud->unset_edit();
        // $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        //$crud->unset_export();

        // set custom grocery crud model, uncomment to use.
        

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');
            $crud->set_relation('CompanyId', $this->cms_complete_table_name('company'), 'cCompanyCode');
            $crud->display_as('NoBPJSKes','Nomor BPJS Kesehatan');
            //$crud->unset_edit();
        }else{
            $crud->set_theme('no-flexigrid_1');
            $crud->set_relation('CompanyId', $this->cms_complete_table_name('company'), '{cCompanyName}',array('iCompanyId' =>$company_id));
            $crud->display_as('NoBPJSKes','Nomor BPJS Kesehatan (Bagi Yg sudah punya kartu)');
        }
        

        $crud->set_language($this->cms_language());

        
        
        // table name
        $crud->set_table($this->cms_complete_table_name('profile'));

        $listingID = $this->uri->segment(4);

        if (!is_null($listingID) && $listingID !=0){
            
            $crud->where('tbl_profile.CompanyId',$company_id);

        }
        else{
          
            $crud->where('tbl_profile.CompanyId',$company_id);
        }

       
        // primary key
        $crud->set_primary_key('NIK');

        // set subject
        $crud->set_subject('Karyawan');

        // displayed columns on list
        $crud->columns('Photos','NoKPJ','NoBPJSKes','NIK','Nama','TptLahir','TglLahir','Sex','StatusDiri','BloodType','NoNPWP','NoKTP','AlamatKTP','AlamatDomisili','NamaIbuKandung','CompanyId','DivisiID','DeptID','UnitID','SeksiID','EmailPribadi','bStatus','UpdatedTime');
        

        $crud->unset_add_fields('CreatedBy','CreatedTime','UpdatedBy','UpdatedTime');
        $crud->field_type('CreatedBy', 'hidden', $session_nik);
        $crud->field_type('CreatedTime', 'hidden', $today);
        

        $crud->unset_edit_fields('UpdatedBy','UpdatedTime');
        $crud->field_type('UpdatedBy', 'hidden', $session_nik);
        $crud->field_type('UpdatedTime', 'hidden', $today);
        
       

        $crud->add_fields('Photos','NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','AlamatKTP','AlamatDomisili','Kodepos','Telp','Hp','BloodType','StatusDiri','NamaIbuKandung','NoNPWP','NoKPJ','NoBPJSKes','EmailPribadi','CompanyId','DivisiID','DeptID','UnitID','SeksiID','Email','JabatanID','JobId','TglMasuk','TglKeluar','Status','bStatus','member','workexp','Education','training','technical','certification','project','Files','CreatedBy','CreatedTime','UpdatedBy','UpdatedTime');

        $crud->edit_fields('Photos','NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','AlamatKTP','AlamatDomisili','Kodepos','Telp','Hp','BloodType','StatusDiri','NamaIbuKandung','NoNPWP','NoKPJ','NoBPJSKes','EmailPribadi','CompanyId','DivisiID','DeptID','UnitID','SeksiID','Email','JabatanID','JobId','TglMasuk','TglKeluar','Status','bStatus','member','workexp','Education','training','technical','certification','project','Files','UpdatedBy','UpdatedTime');        

        $crud->required_fields('NIK','Nama','NoKTP','TglKTP','Sex','TglLahir','TptLahir','Agama','Status','AlamatKTP','AlamatDomisili','Hp','BloodType','StatusDiri','NamaIbuKandung','NoNPWP','NoKPJ','EmailPribadi','CompanyId','DivisiID','DeptID','UnitID','Email','JabatanID','JobId','TglMasuk','bStatus');
       
          


        $crud->set_field_upload('Photos','assets/uploads/files');
        // caption of each columns      
                
        $crud->display_as('NIK','NIK');
        $crud->display_as('Nama','Nama');
        $crud->display_as('NoKTP','No KTP/ e-KTP');
        $crud->display_as('TglKTP','Tgl KTP Berlaku Hingga');
        $crud->display_as('Sex','Sex');
        $crud->display_as('BandSkrg','Band');
        $crud->display_as('TglMasuk','Tgl Bergabung');
        $crud->display_as('Status','Status');
        $crud->display_as('StatusDiri','Status Diri');
        $crud->display_as('CompanyId','Company');
        $crud->display_as('DivisiID','Division');
        $crud->display_as('DeptID','Departemen');
        $crud->display_as('UnitID','Unit');
        $crud->display_as('SeksiID','Seksi');
        $crud->display_as('JabatanID','Jabatan');
        $crud->display_as('JmlAnak','Jumlah Anak');
        $crud->display_as('TptLahir','Tempat Lahir');
        $crud->display_as('TglLahir','Tgl Lahir');
        $crud->display_as('TglMenikah','Tgl Menikah');
        $crud->display_as('TglKeluar','Tgl Keluar');
        $crud->display_as('AlamatKTP','Alamat KTP/ e-KTP');
        $crud->display_as('AlamatDomisili','Alamat Domisili/ Tinggal');
        $crud->display_as('NamaIbuKandung','Nama Ibu Kandung');
        $crud->display_as('NoNPWP','Nomor NPWP (Tanpa tanda titik)');
        $crud->display_as('NamaIbuKandung','Nama Lengkap Ibu Kandung');
        $crud->display_as('NoKPJ','Nomor Kartu Peserta Jamsostek');
        $crud->display_as('BloodType','Golongan Darah');
        $crud->display_as('Telp','Telepon Rumah');
        $crud->display_as('Hp','Nomor Handphone');
        $crud->display_as('EmailPribadi','Email Pribadi');
        $crud->display_as('Email','Email Perusahaan');
        $crud->display_as('TermsAndConditions','Terms & Conditions');
        $crud->display_as('Kodepos','Kodepos Sesuai Domisili');
        $crud->display_as('JabatanID','Job Title Structural');
        $crud->display_as('JobId','Job Title Fungsional');
        $crud->display_as('workexp','Work Experience');
        $crud->display_as('Education','Pendidikan Terakhir');
        $crud->display_as('project','Project History'); 
        $crud->display_as('Files','Attachment Files');
        $crud->display_as('bStatus','Status Karyawan'); 
        
        
                
        
        // $crud->required_fields( $field1, $field2, $field3, ... );       
       
        
        //$crud->unique_fields( $field1, $field2, $field3, ... );
        $crud->unique_fields('NIK');
            

        $crud->set_relation('Status', $this->cms_complete_table_name('status'), 'StatusName');
        $crud->set_relation('Sex', $this->cms_complete_table_name('sex'), 'SexName');
        $crud->set_relation('DivisiID', $this->cms_complete_table_name('div'), 'cDivName');
        $crud->set_relation('DeptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        $crud->set_relation('UnitID', $this->cms_complete_table_name('unit'), 'NamaUnit');
        $crud->set_relation('SeksiID', $this->cms_complete_table_name('section'), 'cSectionName');
        $crud->set_relation('JabatanID', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');
        $crud->set_relation('StatusDiri', $this->cms_complete_table_name('StatusDiri'), 'StatusDiriName');
        $crud->set_relation('Agama', $this->cms_complete_table_name('Agama'), 'agama_name');
        $crud->set_relation('JobId', $this->cms_complete_table_name('job_fungsional'), 'JobFungsionalName');

        
            
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));
        $crud->callback_column('Nama',array($this,'_callback_edit_url'));
        $crud->callback_column('TglMasuk',array($this,'_Date1_call'));
        $crud->callback_before_upload(array($this, '_valid_images'));
        $crud->callback_add_field('DivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_edit_field('DivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_add_field('DeptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_edit_field('DeptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_add_field('UnitID', array($this, 'empty_units_dropdown_select'));
        $crud->callback_edit_field('UnitID', array($this, 'empty_units_dropdown_select'));
        $crud->callback_add_field('SeksiID', array($this, 'empty_seksi_dropdown_select'));
        $crud->callback_edit_field('SeksiID', array($this, 'empty_seksi_dropdown_select'));
        $crud->callback_edit_field('TermsAndConditions', array($this, '_callback_column_TermsAndConditions'));
        $crud->callback_column('NoKPJ',array($this,'_callback_column_NoKPJ'));
        $crud->callback_column('NoNPWP',array($this,'_callback_column_NoNPWP'));
        $crud->callback_column('NoKTP',array($this,'_callback_column_NoKTP'));
        $crud->callback_column('TglLahir',array($this,'_callback_column_TglLahir'));
        $crud->callback_column('UpdatedTime',array($this,'_callback_column_UpdatedTime'));
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

        $crud->add_action('FormCV', 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/images/cv.png', ' ',' http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/images/cv.png',array($this,'_callback_column_FormCV'));



        $this->crud = $crud;
        return $crud;
    }


    public function _example_output($output = null){
        $this->view($this->cms_module_path().'/frmKaryawanMediatek_view', $output,
        $this->cms_complete_navigation_name('frmKaryawanMediatek'));    
    }


    public function index(){
                  
        $crud = $this->make_crud();

        $dd_data = array(
                //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
                'dd_state' =>  $crud->getState(),                
                'dd_dropdowns' => array('CompanyId','DivisiID','DeptID','UnitID','SeksiID'),
                'dd_url' => array('', site_url().'/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/get_states/', site_url().'/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/get_cities/', site_url().'/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/get_units/',site_url().'/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/get_seksi/'),
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

        // delete corresponding photo
        $this->db->delete($this->cms_complete_table_name('profile_files'),
              array('file_nik'=>$primary_key));

        // delete corresponding training
        $this->db->delete($this->cms_complete_table_name('profile_training'),
              array('TrainingNIK'=>$primary_key));

        // delete corresponding technicalskill
        $this->db->delete($this->cms_complete_table_name('profile_technicalskill'),
              array('TechnicalSkillNIK'=>$primary_key));

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

        $Old_NIK   = $this->uri->segment(5);
        $New_NIK   = $post_array['NIK'];
        $companyID = $post_array['CompanyId'];
        $state     = $this->uri->segment(4);



        if($Old_NIK != $New_NIK AND $state =='edit'){

            // update tabel form cuti
            mysql_query("UPDATE tbl_formcuti SET FormCutiNIK = '$New_NIK',
                                                 companyID  = '$companyID'
                                                 WHERE FormCutiNIK = '$Old_NIK'");

            // update tabel hak cuti
            mysql_query("UPDATE tbl_hakcuti SET NIK = '$New_NIK',
                                                companyID ='$companyID'
                                                WHERE NIK = '$Old_NIK'");

            // update tabel perpanjangan cuti
            mysql_query("UPDATE tbl_formperpcuti SET NIK = '$New_NIK',
                                                 companyID  = '$companyID'
                                                 WHERE NIK = '$Old_NIK'");

            // update tabel group approval
            mysql_query("UPDATE tbl_apv_group_approval SET NIK = '$New_NIK' WHERE NIK = '$Old_NIK'");


            // update tabel ijin
            mysql_query("UPDATE tbl_formijin SET NIK = '$New_NIK',
                                                 companyID  = '$companyID'
                                                 WHERE NIK = '$Old_NIK' ");

            // update tabel main user
            mysql_query("UPDATE tbl_main_user SET user_id = '$New_NIK' WHERE user_id = '$Old_NIK' ");

            // update tabel group user
            mysql_query("UPDATE tbl_main_group_user SET user_id = '$New_NIK' WHERE user_id = '$Old_NIK' ");

            // update module user
            //mysql_query("UPDATE tbl_main_module SET user_id = '$New_NIK' WHERE user_id = '$Old_NIK' ");

            // update member karyawan
            mysql_query("UPDATE tbl_profile_member SET NIK = '$New_NIK' WHERE NIK = '$Old_NIK' ");


            //echo "<script language='javascript'>alert('Data Tidak Sama...');history.go(-1);</script>";

        }

         

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
            $this->db->delete($this->cms_complete_table_name('profile_files'),
                 array('file_id'=>$detail_primary_key));
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  INSERTED DATA
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach($insert_records as $insert_record){
            

            $MAXIMUM_FILESIZE = 1000 * 1000; 

            $upload_path = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';

            $record_index = $insert_record['record_index'];

            $rEFileTypes ="/^\.(jpg|jpeg|pdf|xls|xlsx|doc){1}$/i";
            $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['md_field_photos_col_url_'.$record_index]['name']));
            $fsize     = $_FILES['md_field_photos_col_url_'.$record_index]['size'];


            $tmp_name = $_FILES['md_field_photos_col_url_'.$record_index]['tmp_name'];
            $file_name = $_FILES['md_field_photos_col_url_'.$record_index]['name'];
            $file_name = $this->randomize_string($file_name).$file_name;
            $file_code = $_FILES['md_field_photos_col_url_'.$record_index]['name'];

            

            $data = array(
                'url' => $file_name,
                'file_code' => $file_code,
            );
            $data['file_nik'] = $primary_key;

            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $this->db->insert($this->cms_complete_table_name('profile_files'), $data);
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
        $real_column_names = array('WorkExpId', 'WorkExpNIK', 'WorkExpStart', 'WorkExpFinish', 'WorkExpCompany','WorkExpPosition');
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
        $real_column_names = array('EduId', 'EduNIK', 'EduStart', 'EduFinish', 'EduLevelId','EduInstitution','EduCity','EduFaculty','EduMajor','EduGPA');
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
        $real_column_names = array('TrainingId', 'TrainingNIK', 'TrainingYear', 'TrainingInstitution', 'TrainingCity','TrainingModul','TrainingType');
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
        $real_column_names = array('TechnicalSkillId', 'TechnicalSkillNIK', 'TechnicalSkillName', 'TechnicalSkillExp', 'TechnicalSkillDesc');
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
        $real_column_names = array('CertId', 'CertNIK', 'CertDate', 'CertProduct', 'CertName', 'CertPartnerName','CertValidStart','CertValidFinish');
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
        $real_column_names = array('ProjectId', 'ProjectNIK', 'ProjectDate', 'ProjectName', 'ProjectInstitution', 'ProjectYear', 'ProjectLength','ProjectTechnicalSpec','ProjectPosition');
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
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->NIK)."'>$value</a>";
        
    }

    // change dPeriodEndDate format to d-M-Y
    public function _Date1_call($value, $row){
        //return $value." - scale: <b>".$row->date."</b>";
        $Date1 = date('d-M-Y', strtotime($row->TglMasuk));
        return $Date1;
        
    }


    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_select(){
        
        $empty_select = '<select name="DivisiID" class="chosen-select" data-placeholder="Select Division" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        
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
        $empty_select = '<select name="DeptID" class="chosen-select" data-placeholder="Select Departement" style="width: 500px; display: none;">';
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
        $empty_select = '<select name="UnitID" class="chosen-select" data-placeholder="Select Unit" style="width: 300px; display: none;">';
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
        $empty_select = '<select name="SeksiID" class="chosen-select" data-placeholder="Select Section" style="width: 300px; display: none;">';
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
        return $this->load->view($this->cms_module_path().'/field_profile_family',$data, TRUE);
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
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('WorkExpId, WorkExpNIK, WorkExpStart, WorkExpFinish, WorkExpCompany, WorkExpPosition')
            ->from($this->cms_complete_table_name('profile_workexperience'))
            ->where('WorkExpNIK', $primary_key)
            ->get();
        $result = $query->result_array();       

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
        return $this->load->view($this->cms_module_path().'/field_profile_workexp',$data, TRUE);
    }

    // returned on view
    public function _callback_column_workexp($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('WorkExpId, WorkExpNIK, WorkExpStart, WorkExpFinish, WorkExpCompany, WorkExpPosition')
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

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('EduId,EduNIK,EduStart,EduFinish,EduLevelId,EduInstitution,EduCity,EduFaculty,EduMajor,EduGPA')
            ->from($this->cms_complete_table_name('profile_education'))
            ->where('EduNIK', $primary_key)
            ->get();
        $result = $query->result_array();

        // get options
        $options = array();
        $options['EduLevelId'] = array();
        $query = $this->db->select('EducationLevelId,EducationLevelName,EducationLevelbStatus')
           ->from($this->cms_complete_table_name('eduLevel'))
           ->get();
        foreach($query->result() as $row){
            $options['EduLevelId'][] = array('value' => $row->EducationLevelId, 'caption' => $row->EducationLevelName);
        }

        $today       = date('Y-m-d H:i:s');

        $options['EduCreatedTime'] = $today;

       
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
        );
        return $this->load->view($this->cms_module_path().'/field_profile_education',$data, TRUE);
    }

    // returned on view
    public function _callback_column_Education($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('EduId,EduNIK,EduStart,EduFinish,EduLevelId,EduInstitution,EduCity,EduFaculty,EduMajor,EduGPA')
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

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('TrainingId,TrainingNIK,TrainingYear,TrainingInstitution,TrainingCity,TrainingModul,TrainingType')
            ->from($this->cms_complete_table_name('profile_training'))
            ->where('TrainingNIK', $primary_key)
            ->get();
        $result = $query->result_array();

        // get options
        $options = array();
                    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
        );
        return $this->load->view($this->cms_module_path().'/field_profile_training',$data, TRUE);
    }

    // returned on view
    public function _callback_column_training($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('TrainingId,TrainingNIK,TrainingYear,TrainingInstitution,TrainingCity,TrainingModul,TrainingType')
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

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('TechnicalSkillId,TechnicalSkillNIK,TechnicalSkillName,TechnicalSkillExp,TechnicalSkillDesc')
            ->from($this->cms_complete_table_name('profile_technicalskill'))
            ->where('TechnicalSkillNIK', $primary_key)
            ->get();
        $result = $query->result_array();

        // get options
        $options = array();
                    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
        );
        return $this->load->view($this->cms_module_path().'/field_profile_technical',$data, TRUE);
    }

    // returned on view
    public function _callback_column_technical($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('TechnicalSkillId,TechnicalSkillNIK,TechnicalSkillName,TechnicalSkillExp,TechnicalSkillDesc')
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

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('CertId,CertNIK,CertDate,CertProduct,CertName,CertPartnerName,CertValidStart,CertValidFinish')
            ->from($this->cms_complete_table_name('profile_certification'))
            ->where('CertNIK', $primary_key)
            ->get();
        $result = $query->result_array();

        // get options
        $options = array();
                    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
        );
        return $this->load->view($this->cms_module_path().'/field_profile_certification',$data, TRUE);
    }

    // returned on view
    public function _callback_column_certification($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('CertId,CertNIK,CertDate,CertProduct,CertName,CertPartnerName,CertValidStart,CertValidFinish')
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

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('ProjectId,ProjectNIK,ProjectDate,ProjectName,ProjectInstitution,ProjectYear,ProjectLength,ProjectTechnicalSpec,ProjectPosition')
            ->from($this->cms_complete_table_name('profile_projecthistory'))
            ->where('ProjectNIK', $primary_key)
            ->get();
        $result = $query->result_array();

        // get options
        $options = array();
                    
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
        );
        return $this->load->view($this->cms_module_path().'/field_profile_project',$data, TRUE);
    }

    // returned on view
    public function _callback_column_project($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('ProjectId,ProjectNIK,ProjectDate,ProjectName,ProjectInstitution,ProjectYear,ProjectLength,ProjectTechnicalSpec,ProjectPosition')
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

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('file_id, url,file_code')
            ->from($this->cms_complete_table_name('profile_files'))
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
        return $this->load->view($this->cms_module_path().'/field_profile_files',$data, TRUE);
    }

    // returned on view
    public function callback_column_files($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('file_id, url,file_code')
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

            <div id="autoUpdate" class="autoUpdate">            
                Saya Memberikan data yang sebenarnya sesuai berkas-berkas saya, <br/>
                Saya Bertanggungjawab atas keabsahan data tersebut, <br/>
                Saya Bersedia Email akan dikirim ke HRD & Saya, setelah melakukan proses Update.
            
            </div>';

           

    }

    public function _callback_column_NoKPJ($value, $row){             
            

        if (is_null($value) || empty($value) || $value =='-'){
            return "-"; 
        }else{
            $Tgl_Lahir = date('d/m/Y', strtotime($value));
            return "'".$value;           
        }

    }

    public function _callback_column_NoNPWP($value, $row){             
        if (is_null($value) || empty($value) || $value =='-'){
            return "-"; 
        }else{
            $Tgl_Lahir = date('d/m/Y', strtotime($value));
            return "'".$value;           
        }    
    }

    public function _callback_column_NoKTP($value, $row){             
        if (is_null($value) || empty($value) || $value =='-'){
            return "-"; 
        }else{
            $Tgl_Lahir = date('d/m/Y', strtotime($value));
            return "'".$value;           
        }    
    }

    public function _callback_column_TglLahir($value, $row){
                
        if (is_null($value) || empty($value) || $value =='0000-00-00'){
            $Tgl_Lahir = "-";
            return $Tgl_Lahir; 
        }else{
            $Tgl_Lahir = date('d/m/Y', strtotime($value));
            return $Tgl_Lahir;           
        }
            
    }

    public function _callback_column_UpdatedTime($value, $row){             
        if (is_null($value) || empty($value) || $value =='-'){
            return "-"; 
        }else{
            $UpdatedTime = date('d-M-Y H:i:s', strtotime($value));
            return "".$UpdatedTime;           
        }    
    }


    // add hyperlink
    public function _callback_column_FormCV($primary_key, $row){
       
            return site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index?nik='.$row->NIK);
        
    }






}