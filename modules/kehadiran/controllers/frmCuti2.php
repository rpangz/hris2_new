<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class frmCuti2 extends CMS_Priv_Strict_Controller {

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
        $today = date('Y-m-d H:i:s');          
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
        $crud->unset_texteditor('Remark');
        // $crud->unset_add();
        //$crud->unset_edit();
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();

        $crud->unset_texteditor('Alamat');
        $crud->unset_texteditor('Keperluan');
        $crud->unset_texteditor('Alasan');
        $listingID = $this->uri->segment(4);
        $_SESSION['JenisCuti'] = $listingID;    
        $my_profile = $this->_callback_my_profile();

             
        
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');
            $crud->display_as('FormCutiNIK','NIK');
            $crud->display_as('TglMasuk','Kembali Bekerja');
            $crud->display_as('Detail','Jumlah Cuti');   
            $crud->set_relation('NIK3', $this->cms_complete_table_name('profile'), '{Nama}');
        }
        else {
            $crud->set_theme('no-flexigrid_1');
            $crud->display_as('FormCutiNIK','Nama');
            $crud->display_as('TglMasuk','Tanggal Masuk Kembali Bekerja');
            $crud->display_as('Detail','Cuti Tanggal*');   
            $crud->set_primary_key('hrd_nik',$this->cms_complete_table_name('apv_hrd'));
            $crud->set_relation('NIK3', $this->cms_complete_table_name('apv_hrd'), '{hrd_name} [{hrd_email}]',array('hrd_status' =>1,'hrd_company' => $my_profile['company'], 'hrd_modules' => $hrd_modules));
        }

        
        $crud->set_relation('ApvLevel', $this->cms_complete_table_name('apv_matrik_approval'), '{MatName}',array('MatCode' => 1));
        

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->cms_complete_table_name('formcuti'));
        $crud->where('FormCutiNIK', $session_nik);

        $list       = $this->uri->segment(4);
        $itemIDa    = $this->uri->segment(6);
        

        if ($this->uri->segment(4) !=0 && !is_null($this->uri->segment(4)) && isset($list)){
            $crud->where('JenisCuti', $this->uri->segment(4));
            $crud->order_by('CutiId','DESC');
        }       
        else {
            $crud->where('JenisCuti >=', 0);
            $crud->order_by('CutiId','DESC');            
        }

        if($this->_callback_SisaCuti() <=0 && $list !=3 && $list !=5){
            $crud->unset_add();
        }

        // primary key
        $crud->set_primary_key('CutiId');
        $crud->change_field_type('NoTelpon', 'integer');
             

        $crud->set_subject('Form Cuti '.$this->_callback_jenis_cuti());

        // displayed columns on list
        $crud->columns('FormCutiNIK','NIK','JenisCuti','Keperluan','Detail','TglMasuk','ApvLevel','StatusForm');
        $crud->unset_add_fields('CreatedBy','CreatedTime','UpdatedTime','companyID');
        $crud->field_type('CreatedBy', 'hidden', $session_nik);
        $crud->field_type('CreatedTime', 'hidden', $today);
        $crud->field_type('UpdatedTime', 'hidden', $today);
        $crud->field_type('companyID', 'hidden', $my_profile['company']);

        if ($listingID !=3 && $listingID !=5){
            $crud->add_fields('FormCutiNIK','JenisCuti','HakCutiId','Keperluan','Alamat','NoTelpon','Detail','TglMasuk','NIKPengganti','NIK1','NIK2','NIK3','CreatedBy','CreatedTime','UpdatedTime','companyID');
            $crud->callback_add_field('HakCutiId', array($this, '_callback_add_field_HakCutiId'));
        }
        elseif ($listingID ==5){

            $zero = 0;
            $sisa = 0;

            $crud->unset_add_fields('JenisItemCuti','JenisItemCuti2','LocationCuti','TglActive2');
            $crud->field_type('JenisItemCuti','hidden',0);
            $crud->field_type('JenisItemCuti2','hidden',NULL);
            $crud->field_type('LocationCuti','hidden',0);
            $crud->field_type('TglActive2','hidden');
            //$crud->field_type('HakCutiId','hidden', $zero);
            $crud->field_type('SisaCuti','hidden', $sisa);
            //$crud->add_fields('FormCutiNIK','JenisCuti','HakCutiId','Max_Cuti','Keperluan','Alamat','NoTelpon','NIKPengganti','TglActive1','TglActive2','TglMasuk','Files','NIK1','NIK2','NIK3','CreatedBy','CreatedTime','UpdatedTime','companyID');
            $crud->add_fields('FormCutiNIK','JenisCuti','HakCutiId','LocationCuti','Keperluan','Alamat','NoTelpon','NIKPengganti','TglActive1','TglActive2','TglMasuk','Files','NIK1','NIK2','NIK3','CreatedBy','CreatedTime','UpdatedTime','companyID');
            $crud->callback_add_field('Max_Cuti', array($this, '_callback_add_field_max_cuti_melahirkan'));
            $crud->callback_add_field('HakCutiId', array($this, '_callback_add_field_HakCutiId_Melahirkan'));

            //$crud->callback_add_field('TglActive1', array($this, '_callback_add_field_TglActive1'));
            //$crud->callback_add_field('TglActive2', array($this, '_callback_add_field_TglActive2'));
            //$crud->callback_add_field('TglMasuk', array($this, '_callback_add_field_TglMasuk'));
        }
        else {           

                        
            $zero = 0;

            if (!empty($itemIDa) || !is_null($itemIDa)){
                $crud->unset_add_fields('HakCutiId','JenisItemCuti','JenisItemCuti2');
                $crud->field_type('HakCutiId','hidden', $zero);
                $crud->field_type('JenisItemCuti','hidden',$itemIDa);                              

                if ($itemIDa <= 9){
                    $crud->add_fields('FormCutiNIK','JenisCuti','HakCutiId','JenisItemCuti','JenisItemCuti2','LocationCuti','Keperluan','Alamat','NoTelpon','NIKPengganti','Detail','TglMasuk','Files','NIK1','NIK2','NIK3','CreatedBy','CreatedTime','UpdatedTime','companyID');
                }else{
                    $crud->add_fields('FormCutiNIK','JenisCuti','HakCutiId','JenisItemCuti','JenisItemCuti2','LocationCuti','Keperluan','Alamat','NoTelpon','NIKPengganti','TglActive1','TglActive2','TglMasuk','Files','NIK1','NIK2','NIK3','CreatedBy','CreatedTime','UpdatedTime','companyID');
                }
            }
            else{
                $crud->unset_add_fields('JenisItemCuti','JenisItemCuti2');               
                $crud->field_type('JenisItemCuti','hidden',$itemIDa);                
                $crud->add_fields('FormCutiNIK','JenisCuti','JenisItemCuti','JenisItemCuti2','LocationCuti','Keperluan','Alamat','NoTelpon','NIKPengganti','TglActive1','TglActive2','Detail','TglMasuk','Files','NIK1','NIK2','NIK3','CreatedBy','CreatedTime','UpdatedTime','companyID');
                //$crud->unset_add_fields('NIK3');              
                //$crud->unset_back_to_list();               


            }

            $crud->callback_add_field('JenisItemCuti2', array($this, '_callback_add_field_JenisItemCuti'));
            $crud->callback_add_field('LocationCuti', array($this, '_callback_add_field_LocationCuti'));

            //$crud->callback_add_field('LocationCuti', array($this, 'empty_state_dropdown_select'));

        }

        
        $crud->display_as('CutiId','ID');       
        //$crud->display_as('FormCutiNIK','NIK');
        $crud->display_as('NIK','Nama');
        $crud->display_as('TglActive1','Tgl Active1');
        $crud->display_as('TglActive2','Tgl Active2');
        $crud->display_as('Keperluan','Keperluan');
        $crud->display_as('StatusForm','Status Form');
        $crud->display_as('ApvLevel','Current Approval');
        $crud->display_as('NoTelpon','No Telpon');
        $crud->display_as('NIK2','Atasan Lebih Tinggi');
        $crud->display_as('NIK3','Mengetahui HRD');
        $crud->display_as('NIK1','Atasan Langsung');
        $crud->display_as('HakCutiId','Sisa Cuti');
        $crud->display_as('HakCutiId2','Periode Pengambilan Cuti');
        $crud->display_as('TglCuti','Tanggal Cuti');
        $crud->display_as('JenisCuti','Jenis Cuti');
        $crud->display_as('Apv1','Atasan Langsung - Apv 1');
        $crud->display_as('Apv2','Atasan Lebih Tinggi - Apv 2');
        $crud->display_as('Apv3','HRD - Apv 3');
        $crud->display_as('TglActive1','Awal Cuti');
        $crud->display_as('TglActive2','Akhir Cuti');
        $crud->display_as('Aturan','Pengajuan');
        $crud->display_as('NIKPengganti','Petugas Pengganti');
        $crud->display_as('Alamat','Alamat Selama Cuti');
        $crud->display_as('JenisItemCuti','Jenis Item Cuti');
        $crud->display_as('JenisItemCuti2','Jenis Item Cuti');
        $crud->display_as('LocationCuti','Location');
        $crud->display_as('Files','Attachment Files');


        
        
        //$crud->set_lang_string('_before_insert','Updating existing customer');
        //$crud->set_lang_string('form_back_to_list','Go back to customers page');
        $crud->set_lang_string('form_save','Process');


        $crud->required_fields('FormCutiNIK','JenisCuti','JenisItemCuti','JenisItemCuti2','LocationCuti','StatusForm','Keperluan','Alamat','TglMasuk','NIKPengganti','NoTelpon','NIK1','NIK2','NIK3','Alasan','Apv1','Apv2','Apv3','LocationCuti');

       
        
        $crud->set_relation('JenisCuti', $this->cms_complete_table_name('jeniscuti'), 'JenisCutiName',array('id !=' => 0));

        if ($state=='Add' || $state=='edit'){
            $crud->set_relation('StatusForm', $this->cms_complete_table_name('statusform'), 'NamaStatusForm',array('Id' => 4));
        }

       

        $crud->set_relation('NIK1', $this->cms_complete_table_name('profile'), 'Nama');
        $crud->set_relation('NIK2', $this->cms_complete_table_name('profile'), 'Nama');

        //$crud->set_relation('NIK3', $this->cms_complete_table_name('apv_hrd'), '{hrd_name}',array('hrd_status' => 1,'hrd_company' => $company_id, 'hrd_modules' => $hrd_modules));

        
        if ($state=='read'){
            $crud->edit_fields('FormCutiNIK','JenisCuti','Keperluan','Alamat','NIKPengganti','NoTelpon','Detail','TglMasuk','NIK1','NIK2','NIK3');
            $crud->set_relation('NIKPengganti', $this->cms_complete_table_name('profile'), '{Nama} - {NIK}');
        }
        else{
            $crud->edit_fields('StatusForm','Alasan');
            $crud->set_relation('NIKPengganti', $this->cms_complete_table_name('profile'), '{Nama} - {NIK}',array('bStatus' =>1,'DeptID' => $my_profile['dept'], 'NIK !=' => $this->cms_user_id()));
        }

        

        $crud->set_primary_key('hrd_nik',$this->cms_complete_table_name('apv_hrd'));
        
        $crud->set_relation('ApvLevel', $this->cms_complete_table_name('apv_matrik_approval'), '{MatName}',array('MatCode' => 1));

        $crud->set_relation('NIKPengganti', $this->cms_complete_table_name('profile'), '{Nama} [{Email}] - {NIK}',array('bStatus' =>1,'NIK !=' => $this->cms_user_id()));
        
        
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $crud->callback_column('Detail',array($this, '_callback_column_citizen'));
        $crud->callback_field('Detail',array($this, '_callback_field_citizen'));

        $crud->callback_column('Files',array($this, '_callback_column_files'));
        $crud->callback_field('Files',array($this, '_callback_field_files'));

        $crud->callback_add_field('FormCutiNIK', array($this, '_callback_add_field_FormCutiNIK'));
        $crud->callback_edit_field('FormCutiNIK', array($this, '_callback_add_field_FormCutiNIK'));
        $crud->callback_column('StatusForm',array($this,'_callback_column_StatusForm'));
        $crud->callback_add_field('JenisCuti',array($this,'_callback_add_JenisCuti'));

        //$crud->callback_add_field('Keperluan',array($this,'_callback_add_Keperluan'));
        
        $crud->callback_add_field('NIK1', array($this, '_callback_add_field_NIK1'));
        $crud->callback_add_field('NIK2', array($this, '_callback_add_field_NIK2'));
        $crud->callback_column('TglMasuk', array($this, '_callback_column_TglMasuk'));

        //$crud->callback_add_field('NIKPengganti', array($this, '_callback_add_field_NIKPengganti'));        
        
        $crud->callback_edit_field('Alasan', array($this, '_callback_edit_field_Alasan'));
        //$crud->callback_edit_field('StatusForm', array($this, '_callback_edit_field_StatusForm'));
        $crud->callback_column('NIK',array($this,'_callback_column_NIK'));
        $crud->callback_column('Aturan',array($this,'_callback_column_Aturan'));

        $crud->callback_field('NoTelpon',array($this,'_callback_field_NoTelpon'));
        
        $crud->add_action('Read', base_url().'assets/grocery_crud/themes/flexigrid/css/images/magnifier.png', base_url().'assets/grocery_crud/themes/flexigrid/css/images/magnifier.png',base_url().'assets/grocery_crud/themes/flexigrid/css/images/magnifier.png',array($this,'modal_dialog_detail'));

        $crud->add_action('Print', base_url('assets/grocery_crud/themes/flexigrid/css/images/print.png'), ' ',base_url('assets/grocery_crud/themes/flexigrid/css/images/print.png'),array($this,'_callback_column_Print'));

        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        $my_profile = $this->_callback_my_profile();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();

        $data = array(
            'sisacuti' => $this->_callback_SisaCuti(),
            'jeniscuti' => $this->_callback_jenis_cuti(),
            'sex' => $my_profile['sex'],
            'status_diri' => $my_profile['status_diri'],
            'state' => $this->_callback_state_action(),
            'session_id' => $this->cms_user_id(),
            'jenis_cuti_id' => $this->uri->segment(4),
            'maximun_days' => $this->maximum_days_of_form(),
            'max_cuti_khusus_ijin' => $this->maximum_cuti_khusus_ijin(),
        );

        $output   = array_merge((array)$output, $data);

        $this->view($this->cms_module_path().'/frmCuti2_view', $output,
            $this->cms_complete_navigation_name('frmCuti2'));
    }


    public function _example_output($output = null){

        $my_profile = $this->_callback_my_profile();        

        $data = array(
            'sisacuti' => $this->_callback_SisaCuti(),
            'jeniscuti' => $this->_callback_jenis_cuti(),
            'sex' => $my_profile['sex'],
            'status_diri' => $my_profile['status_diri'],
            'state' => $this->_callback_state_action(),
            'max_cuti_khusus_ijin' => $this->maximum_cuti_khusus_ijin(), 
        );

        $output   = array_merge((array)$output, $data);

        $this->view($this->cms_module_path().'/frmCuti2_view', $output,
        $this->cms_complete_navigation_name('frmCuti2'));    
    }



    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('frmCuti2'),array('CutiId'=>$id));
                    $this->_after_delete($id);
                }
            }
        }
    }

    // change dPeriodEndDate format to d-M-Y
    public function _date_format_callback($value, $row){
        $date_value = date('d-M-Y', strtotime($row->StartingDate));
        return $date_value;
        
    }

    public function _before_insert($post_array){
        $post_array = $this->_before_insert_or_update($post_array);
        $data = json_decode($this->input->post('md_real_field_citizen_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $set_column_names = array();       

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
            $data['CutiId'] = $primary_key;
            $detail_primary_key = $this->db->insert_id();            
            $record_index = $insert_record['record_index']; // rekam field
            @$total_TglCuti += count($record_index); // jumlah cuti

        }            

        $isa        = strtotime($this->new_format_date_mysql($date=$post_array['TglActive1']));

        

        $TglActive2 = date('Y-m-d',strtotime('+'.$this->maximum_days_of_form().' -1 day',$isa));
        $TglMasuk   = date('Y-m-d',strtotime($this->new_format_date_mysql($date=$post_array['TglMasuk'])));

        $end_tgl_cuti = date('d-M-Y',strtotime('+'.$this->maximum_days_of_form().' -1 day',$isa));




        if (strlen($post_array['Keperluan']) < 10){
            echo '<script language="javascript">alert("Error!!! Field Keperluan minimal 10 karakter...");</script>';
            return false;
        }
        elseif (strlen($post_array['Alamat']) < 10){
            echo '<script language="javascript">alert("Error!!! Field Alamat minimal 10 karakter...");</script>';
            return false;
        }
        elseif (strlen($post_array['NoTelpon']) < 10){
            echo '<script language="javascript">alert("Error!!! Nomor Telpon minimal 10 digit...");</script>';
            return false;
        }
        elseif (strlen($post_array['SisaCuti']) <= 0 ){
            echo '<script language="javascript">alert("Error!!! Sisa Cuti Anda Tidak Ada...");</script>';
            return false;
        }
        elseif (count($detail_primary_key) ==0 && $post_array['JenisCuti'] <=2 ){
            echo '<script language="javascript">alert("Error!!! Cuti Tanggal Tidak Boleh Kosong...");</script>';
            return false;
        }
        elseif ($TglActive2 >= $TglMasuk && $post_array['JenisCuti'] ==5 ){
            echo '<script language="javascript">alert("Error!!! Tanggal masuk kembali bekerja tidak sesuai, cuti berakhir tgl '.$end_tgl_cuti.'");</script>';
            return false;
        }
        else{
            return $post_array;   
        }


        
    }
    
    public function _after_insert($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);

        $error = $this->_before_insert_or_update($post_array);
        $session_nik = $this->cms_user_id();
        $TglMasukku    = $post_array['TglMasuk'];

        $dateObj  = DateTime::createFromFormat('d/m/Y', $TglMasukku);
        $TglMasuk = $dateObj->format('Y-m-d');


        $NIKKIKU     = $post_array['Keperluan'];

        $query = $this->db->select('DetailCutiId, CutiId, Keterangan, TglCuti, active_id')
            ->from($this->cms_complete_table_name('formcutidetail'))
            ->where('CutiId', $primary_key)
            ->where('TglCuti >=',$TglMasuk)
            ->get();
        $num_row = $query->num_rows();

        $TglSama = mysql_query("SELECT COUNT(TglCuti)  AS Jumlah, DATE(TglCuti) as TglCuti 
                                FROM tbl_formcutidetail 
                                WHERE CutiId ='".$primary_key."' GROUP BY DATE(TglCuti) 
                                Having COUNT(TglCuti) > 1");

        $total = mysql_num_rows($TglSama);

        if ($post_array['JenisCuti']==3){
            $this->hapus_cuti_lebih($primary_key);
        }

        if ($post_array['JenisCuti']==5){
            $this->update_tgl_active_dua($primary_key);
        }


        if($num_row > 0 || $total >0){
            mysql_query("DELETE FROM tbl_formcuti WHERE CutiId =".$primary_key);
            mysql_query("DELETE FROM tbl_formcutidetail WHERE CutiId=".$primary_key);      

            echo "<script language='javascript'>alert('Error!!! Cuti Tanggal atau Tanggal Masuk Kembali Tidak sesuai...');history.go(-1);</script>";        
            return $error;
        }
        else{

            include site_url('includes/mailer/frmCuti/SendMail.php?id='.$primary_key.'&mynik='.$session_nik.'&proses=1');
            
            
            echo '<script language="javascript">alert("Data Sudah Disimpan dan Email sudah dikirim...");</script>';

/*
            $result = mysql_query("SELECT `FormCutiNIK`, `HakCutiId`, `JenisCuti`, `StatusForm`, `Keperluan`,
                                  `Alamat`, `NoTelpon`, `Pengganti`, `NIKPengganti`, `TglActive1`, `TglActive2`,
                                  `TglMasuk`, `Detail`, `active_id`, `ApvLevel`, `NIK1`, `NIK2`, `NIK3`, `Apv1`,
                                  `Apv2`, `Apv3`, `Pin`, `Pin1`, `Pin2`, `Pin3`, `Tgl1`, `Tgl2`, `Tgl3`, `Remark1`,
                                  `Remark2`, `CutiMasalId`, `CreatedBy`, `CreatedTime`, `UpdatedTime`, `Alasan`, `AlasanApv`,
                                  `SendMail`, `companyID` FROM `tbl_formcuti` WHERE CutiId =".$primary_key); 

           
            while ($row = mysql_fetch_assoc($result)){
              foreach ($row as $field => $value) {
                $fields .= "$field, ";
                $values .= "'$value', ";
              }
              // remove trailing ", " from $fields and $values
              $fields = preg_replace('/, $/', '', $fields);
              $values = preg_replace('/, $/', '', $values);

              $sql = "INSERT INTO tbl_formcuti ($fields) VALUES ($values)";
              mysql_query($sql);
            }

            $new_id = mysql_insert_id();            
*/           
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

        $ListingID = $this->uri->segment(6);
        $session_nik = $this->cms_user_id();
        $ID       = $primary_key;

        include site_url('includes/mailer/frmCuti/SendMailVoid.php?id='.$primary_key);  

        echo '<script language="javascript">alert("Data Sudah Disimpan dan Email sudah dikirim...");</script>';


        return $success;
    }

    public function _before_delete($primary_key){
        // delete corresponding citizen
        $this->db->delete($this->cms_complete_table_name('formcutidetail'), array('CutiId'=>$primary_key));
        return TRUE;
    }

    public function _after_delete($primary_key){
        return TRUE;
    }

    public function _after_insert_or_update($post_array, $primary_key){

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
        $real_column_names = array('DetailCutiId','CutiId','Keterangan','TglCuti','active_id');
        $set_column_names = array();
        //$many_to_many_column_names = array('hobby');
        //$many_to_many_relation_tables = array('citizen_hobby');
        //$many_to_many_relation_table_columns = array('citizen_id');
        //$many_to_many_relation_selection_columns = array('hobby_id');
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
            $this->db->delete($this->cms_complete_table_name('formcutidetail'),
                 array('DetailCutiId'=>$detail_primary_key));
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
            $data['CutiId'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('formcutidetail'),
                 $data, array('DetailCutiId'=>$detail_primary_key));
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
            $data = array();
            foreach($insert_record['data'] as $key=>$value){
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['CutiId'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('formcutidetail'), $data);
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
        $real_column_names = array('file_id','cuti_id','file_name','url','file_code','file_UpdatedBy');
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
            $this->db->delete($this->cms_complete_table_name('formcuti_files'),
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

            $MAXIMUM_FILESIZE   = 1000 * 1000;
            $upload_path        = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index       = $insert_record['record_index'];
            $rEFileTypes        = "/^\.(jpg|jpeg|pdf){1}$/i";
            $safe_filename      = preg_replace(array("/\s+/", "/[^-\.\w]+/"),array("_", ""),trim($_FILES['md_field_photos_col_url_'.$record_index]['name']));
            $fsize              = $_FILES['md_field_photos_col_url_'.$record_index]['size'];
            $tmp_name           = $_FILES['md_field_photos_col_url_'.$record_index]['tmp_name'];
            $file_name          = $_FILES['md_field_photos_col_url_'.$record_index]['name'];
            $file_name          = $this->randomize_string($file_name).$file_name;
            $file_code          = $_FILES['md_field_photos_col_url_'.$record_index]['name'];
            $data               = array(
                'url' => $file_name,
                'file_code' => $file_code,
                'file_UpdatedBy'=>$this->cms_user_id(),
            );

            $data['cuti_id']    = $primary_key;

            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $this->db->insert($this->cms_complete_table_name('formcuti_files'), $data);
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/kehadiran/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/kehadiran/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);

            }


            /*
            $this->load->library('image_moo');
            $upload_path    = FCPATH.'modules/'.$this->cms_module_path().'/assets/uploads/';
            $record_index   = $insert_record['record_index'];
            $tmp_name       = $_FILES['md_field_photos_col_url_'.$record_index]['tmp_name'];
            $file_name      = $_FILES['md_field_photos_col_url_'.$record_index]['name'];
            $file_name      = $this->randomize_string($file_name).$file_name;
            $file_code      = $_FILES['md_field_photos_col_url_'.$record_index]['name'];
            move_uploaded_file($tmp_name, $upload_path.$file_name);
            $data = array(
                'url' => $file_name,
                'file_code' => $file_code,
                'file_UpdatedBy'=>$this->cms_user_id(),
            );
            $data['cuti_id'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('formcuti_files'), $data);

            $thumbnail_name = 'thumb_'.$file_name;
            $this->image_moo->load($upload_path.$file_name)->resize(800,75)->save($upload_path.$thumbnail_name,true);
            */


        }



/*
        $data = json_decode($this->input->post('md_real_field_files_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('file_id','cuti_id','file_name','url','file_code','file_UpdatedBy');
        $set_column_names = array(); 



        foreach($insert_records as $insert_record){
            $data = array();
            foreach($insert_record['data'] as $key=>$value){
               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['cuti_id'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('formcuti_files'), $data);
            $detail_primary_key = $this->db->insert_id();

            $this->db->update($this->cms_complete_table_name('formcuti_files'),
                array('file_UpdatedBy'=>$this->cms_user_id()),
                array('file_id'=>$detail_primary_key));


            
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
            


            if ($fsize <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){
                move_uploaded_file($tmp_name, $upload_path.$file_name);
                $this->db->update($this->cms_complete_table_name('formcuti_files'),
                $data, array('file_id'=>$detail_primary_key));
                $ftp_server     = '172.17.0.32';
                $ftp_user_name  = 'operator';
                $ftp_user_pass  = 'L3ts4sim.2a';
                $file           = 'http://172.17.0.16/hris2/modules/kehadiran/assets/uploads/'.$file_name;
                $remote_file    = '/hris2/modules/kehadiran/assets/uploads/'.$file_name;
                $conn_id        = ftp_connect($ftp_server);
                $login_result   = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)){ } else { }                
                ftp_close($conn_id);

            }


            
        }
        */       


        
        return TRUE;

    }

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }


    // add hyperlink
    public function _callback_column_NIK($value, $row){

        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('profile'))     
            ->join('tbl_formcuti', 'tbl_profile.NIK = tbl_formcuti.FormCutiNIK')        
            ->where('NIK', $row->FormCutiNIK)
            ->where('CutiId', $row->CutiId)
            ->get(); 

    
        foreach ($query->result() as $rown){
            return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/'.$row->JenisCuti.'/edit/'.$row->CutiId)."'>$rown->Nama</a>";
        }
    
        
    }


    // returned on insert and edit
    public function _callback_field_citizen($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('DetailCutiId, CutiId, Keterangan, TglCuti, active_id')
            ->from($this->cms_complete_table_name('formcutidetail'))
            ->where('CutiId', $primary_key)
            ->get();
        
        $result = $query->result_array();
        // add "hobby" to $result
        
        // get options
        $options = array();
        $options['CutiId'] = array();

        // get options
        $options = array();
        $options['active_id'] = array();
        $query = $this->db->select('active_id,active_name')
           ->from($this->cms_complete_table_name('active'))
           ->get();
        foreach($query->result() as $row){
            $options['active_id'][] = array('value' => $row->active_id, 'caption' => $row->active_name);
        }  

       //$this->form_validation->set_message('TglCuti', 'Tanggal Tidak Boleh Kosong');

        $data = array(
            'result' => $result,
            'sisacuti' =>$this->_callback_SisaCuti(),
            'max_cuti_khusus_ijin' => $this->maximum_cuti_khusus_ijin(),
            'options' => $options,
            'date_format' => $date_format,
        );

        return $this->load->view($this->cms_module_path().'/field_cuti_detail',$data, TRUE);
    }

    // returned on view
    public function _callback_column_citizen($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('DetailCutiId, CutiId, Keterangan, TglCuti, active_id')
            ->from($this->cms_complete_table_name('formcutidetail'))
            ->where('CutiId', $row->CutiId)
            ->get();
        


        if ($row->JenisItemCuti <= 9 && $row->JenisCuti !=5){
            $num_row = $query->num_rows();           
        }
        elseif($row->JenisCuti == 5){
            $num_row = $this->count_days($primary_key=$row->CutiId);
        }
        else{
            $num_row = $this->count_days($primary_key=$row->CutiId);
            
        }


        // show how many records
        if($num_row>1){
            return $num_row .' Hari';
        }else if($num_row>0){
            return $num_row .' Hari';
        }else{
            return 'No Data';
        }
    }    



    // returned on insert and edit
    public function _callback_field_files($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('file_id,cuti_id,file_name,url,file_code')
            ->from($this->cms_complete_table_name('formcuti_files'))
            ->where('cuti_id', $primary_key)
            ->get();
        $result = $query->result_array();       
        $options = array();
        
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'module_path' => $this->cms_module_path(),
        );
        return $this->load->view($this->cms_module_path().'/field_cuti_files',$data, TRUE);
    }

    // returned on view
    public function _callback_column_files($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('file_id,cuti_id,file_name,url,file_code')
            ->from($this->cms_complete_table_name('profile_files'))
            ->where('cuti_id', $row->CutiId)
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

    

    // Add Default Tagging Asset
    public function _callback_add_field_FormCutiNIK(){
      
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

    public function _callback_column_StatusForm($value, $row){     
     //return $value;
     //$query2 = $this->db->query('SELECT * FROM tbl_main_user WHERE user_id=2');
     $query2 = $this->db->query('SELECT * FROM tbl_statusform WHERE CodeStatusForm="'.$value.'"');
                           
     foreach ($query2->result() as $rown){       
            return '<span style="background-color:'.$rown->ColourStatusForm.';color:'.$rown->FontColourForm.'"><b>'.$rown->NamaStatusForm.'</b></span>';      
       
     } 

        
    }


    public function _callback_column_Aturan($value, $row){     
     //return $value;
     //$query2 = $this->db->query('SELECT * FROM tbl_main_user WHERE user_id=2');
     $query = $this->db->query('SELECT * FROM tbl_formcuti WHERE CutiId="'.$row->CutiId.'"');
                           
     foreach ($query->result() as $rown){
        $TglBuat  = date('Y-m-d', strtotime($rown->CreatedTime));
        $TglMasuk = date('Y-m-d', strtotime($rown->TglMasuk));

        if ($TglBuat < $TglMasuk){
            $sop  = 'Ikut Aturan';

        }else{
            $sop  = 'Tidak Ikut Aturan';
        }        
            return $sop;      
       
     }     

        
    }


    // Add Type
    public function _callback_add_JenisCuti(){
      
        $stateID = $this->uri->segment(4);
        $query = $this->db->query('SELECT id, JenisCutiCode,JenisCutiName FROM tbl_jeniscuti WHERE id='.$stateID);  


       foreach ($query->result() as $row){
        return "$row->JenisCutiName<input type='hidden' maxlength='50' value='" . $row->id. "' name='JenisCuti'>";
        }   //return $array;

        
    }


    //CALLBACK FUNCTIONS
    public function _callback_add_field_NIK1(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK1" class="chosen-select" data-placeholder="Select Atasan Langsung" style="width: 500px; display: none;">';
        $empty_select_closed= '</select>';
        //GET THE ID OF THE LISTING USING URI
        //$listingID = $this->uri->segment(5);
        
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
            //GET THE CITIES PER STATE ID 

            $this->db->select('tbl_profile.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_profile.Email AS Email')
                     ->from($this->cms_complete_table_name('apv_group_approval'))
                     ->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID',$dta['DeptID'])
                     ->where('form_cuti', 1)
                     ->order_by('iGroupApprovalListId','ASC');

            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select Atasan Langsung</option>';

            foreach($db->result() as $row):               
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.' ['.$row->Email.']</option>';
                
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;
    }


    //CALLBACK FUNCTIONS

    public function _callback_add_field_NIK2(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK2" class="chosen-select" data-placeholder="Select Atasan Lebih Tinggi" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        //$listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud  = new grocery_CRUD();
        $state = $crud->getState();

        $session_nik = $this->cms_user_id();        
        $dta         = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = $session_nik"));
        /*
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))
            ->join('tbl_bpjs_kelas', 'tbl_bpjs.Kelas_Rawat = tbl_bpjs_kelas.kelas_id')          
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();  

        */
            //GET THE CITIES PER STATE ID 

            $this->db->select('tbl_profile.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_profile.Email AS Email')
                     ->from($this->cms_complete_table_name('apv_group_approval'))
                     ->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID',$dta['DeptID'])
                     ->where('form_cuti', 1)
                     ->order_by('iGroupApprovalListId','ASC');

            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select Atasan Lebih Tinggi</option>';

            foreach($db->result() as $row):               
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.' ['.$row->Email.']</option>';
                
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;
    }


    public function _callback_add_field_NIK3(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK3" class="chosen-select" data-placeholder="Select HRD" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        $crud  = new grocery_CRUD();
        $state = $crud->getState();


        $session_nik = $this->cms_user_id();        
        $dta         = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = $session_nik"));
        
        $companyID = $dta['CompanyId'];

        //GET THE CITIES PER STATE ID        

            $this->db->select('*')
                     ->from($this->cms_complete_table_name('apv_hrd'))
                     ->where('hrd_status',1)
                     ->where('hrd_company',$companyID)
                     ->where('hrd_modules', $hrd_modules)
                     ->order_by('hrd_name','ASC');

            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select HRD</option>';

            foreach($db->result() as $row):               
                    $empty_select .= '<option value="'.$row->hrd_nik.'">'.$row->hrd_name.' ['.$row->hrd_email.']</option>';
                
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;
    }
    

    // change dPeriodEndDate format to d-M-Y
    public function _callback_column_TglMasuk($value, $row){
        //return $value." - scale: <b>".$row->date."</b>";
        $Date = date('d-M-Y', strtotime($row->TglMasuk));
        return $Date;
        
    }


    //CALLBACK FUNCTIONS
    public function _callback_add_field_HakCutiId(){                      
        //$value = $grand;

        if ($this->_callback_SisaCuti() > 0){
            $bg = '#00FFFF';
        }else{
            $bg = '#FF0000';
        }
/*
        return '<input type="text" style="color: #000000; font-family: Arial; font-weight: bold; font-size: 14px; background-color:'.$bg.'" name="HakCutiId" class="form-control" value="'.$value.'  Hari" disabled>
                <input type="hidden" name="HakCutiId" id="HakCutiId" class="form-control" value="'.$value.'">'; 
*/
        return "<strong>".$this->_callback_SisaCuti()." Days</strong><input type='hidden' maxlength='50' value='" . $this->_callback_SisaCuti(). "' name='SisaCuti'>";
        //return '<input type="text" style="color: #000000; font-family: Arial; font-weight: bold; font-size: 14px; background-color:'.$bg.'" name="HakCutiId" id="HakCutiId" class="form-control" value="'.$value.'">';

    
    }

    //CALLBACK FUNCTIONS
    public function _callback_add_field_HakCutiId_Melahirkan(){                    
       
        return '<strong>90 Days</strong><input type="hidden" maxlength="50" value="90" name="SisaCuti">';

    }

    public function _callback_SisaCuti(){

        $jc = mysql_fetch_array(mysql_query('SELECT * FROM tbl_jeniscuti WHERE id="'.$this->uri->segment(4).'"'));


        //$SQL1 = mysql_query("SELECT * FROM tbl_hakcuti WHERE NIK='".$this->cms_user_id()."' AND JenisHakCuti='".$this->uri->segment(4)."' ORDER BY HakId DESC");

        $SQL1 = mysql_query("SELECT * FROM tbl_hakcuti WHERE NIK='".$this->cms_user_id()."' AND JenisHakCuti='".$this->uri->segment(4)."' AND ((Periode1 <= NOW() 
            AND PeriodeExt IS NULL AND Periode2 >=NOW()) OR (Periode1 <= NOW() AND PeriodeExt IS NOT NULL AND PeriodeExt >=NOW())) ORDER BY HakId ASC");

        $JM  = mysql_num_rows($SQL1);
        if ($JM >0){
        $no   = 1;
        while ($row1 = mysql_fetch_array($SQL1)){


 
        $Periode1  = date('d M Y', strtotime($row1['Periode1']));
        if (is_null($row1['PeriodeExt']) OR $row1['PeriodeExt']==""){
            $Periode2  = date('d M Y', strtotime($row1['Periode2']));
        }
        else {
            $Periode2  = date('d M Y', strtotime($row1['PeriodeExt']));
        }

        $LimitExp   = '12 Month';
        $Kerja1     = date('d M Y', strtotime($row1['Periode1']. ' - '.$LimitExp));
        $Kerja2     = date('d M Y', strtotime($row1['Periode2']. ' - '.$LimitExp));

       
        $deta1 = mysql_query("SELECT * FROM tbl_formcuti WHERE HakCutiId='$row1[HakId]' AND StatusForm='A' AND FormCutiNIK='$row1[NIK]'");
    
    

    $hh = mysql_query("SELECT * FROM `tbl_formcuti` INNER JOIN tbl_formcutidetail ON tbl_formcuti.CutiId=tbl_formcutidetail.CutiId 
        WHERE tbl_formcuti.HakCutiId='$row1[HakId]' AND tbl_formcuti.StatusForm='A' AND tbl_formcuti.FormCutiNIK='$row1[NIK]'");

            $jka      = mysql_fetch_array(mysql_query('SELECT * FROM tbl_jeniscuti WHERE id="'.$row1['JenisHakCuti'].'"'));

            $today    = date('Y-m-d');
            if (!is_null($jka['LimitExp'])){
                $LimitExp = $jka['LimitExp'];
            }else{
                $LimitExp = '';
            }
            $soon     = date('Y-m-d', strtotime($row1['Periode2']. ' + '.$LimitExp));
            $soon2    = date('Y-m-d', strtotime($soon));

            $Qty      = $row1['Qty'];
            $QtyPakai = mysql_num_rows($hh);
            $Sisa     = $Qty - $QtyPakai;

            if ($today < $row1['Periode1'] && $Sisa <= 0){               
                $gab  = 0;                
            }
            elseif($today > $row1['Periode2'] && is_null($row1['PeriodeExt']) OR $Sisa <= 0){                
                $gab  = 0;               
            }
            elseif ($today > $row1['PeriodeExt'] && !is_null($row1['PeriodeExt']) OR $Sisa <= 0){               
                $gab  = 0;               
            }
            else{              
                $gab  = $Sisa;          

            }

            @$grand += $gab;      


        $no++;

        }
        }

        else {
            @$grand = 0;            
        }

           
        $value = $grand;

        return $value;

    }


    //CALLBACK FUNCTIONS
    public function _callback_add_field_HakCutiIdxx(){   

        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select id=select onchange=goToPage("select") name="" class="chosen-select" data-placeholder="Select Periode Hak Cuti" style="width: 350px; display: none;">';
        $empty_select_closed= '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(4);

        //$PRD       = $this->input->get('PRD', TRUE);
        $PRD       = $this->uri->segment(6);
        $today = date('Y-m-d');
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();

        $session_nik = $this->cms_user_id();
     
            //GET THE CITIES PER STATE ID 
        if(isset($listingID) && $state == "add") {
            $this->db->select('HakId,Periode1,Periode2,PeriodeExt,Qty,QtyPakai,JenisHakCuti')
                     ->from($this->cms_complete_table_name('hakcuti'))
                     //->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     ->where('NIK',$session_nik)
                     ->where('StatusHak',1)
                     ->where('JenisHakCuti',$listingID)
                     ->order_by('HakId','ASC');

            $db     = $this->db->get();
            //$row    = $db->row(0);
            //$HakId  = $row->HakId;

            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select Periode Hak Cuti</option>';

            foreach($db->result() as $row): 
            $Periode1 = date('d-M-Y', strtotime($row->Periode1));
            $Periode2 = date('d-M-Y', strtotime($row->Periode2));


            $dta = mysql_fetch_array(mysql_query('SELECT count(FormCutiNIK) AS QtyPakai FROM tbl_formcuti INNER JOIN 
                                                    tbl_formcutidetail ON tbl_formcuti.CutiId = tbl_formcutidetail.CutiId 
                                                    WHERE tbl_formcuti.FormCutiNIK="'.$session_nik.'" AND HakCutiId="'.$row->HakId.'" 
                                                    AND StatusForm="A"'));
            $Qty      = $row->Qty;
            $QtyPakai = $dta['QtyPakai'];
            $Sisa     = $Qty - $QtyPakai;
            if ($Sisa <= 0){
                $text = "disabled";
                $HakId = ' ';
                $B1 = ' ';
                $B2 = ' ';
            }
            else {
                $text = " ";
                $HakId = $row->HakId;
                $B1 = '<b>';
                $B2 = '</b>';
            }

            if ($today < $row->Periode1){
                $sati = 'disabled';
            }
            elseif($today > $row->Periode2 && is_null($row->PeriodeExt)){
                $sati = 'disabled';
            }
            elseif ($today > $row->PeriodeExt && !is_null($row->PeriodeExt)){
                $sati = 'disabled';
            }
            else{
                $sati = '';
            }


                if($row->HakId == $PRD) {

                    $empty_select .= '<option value="'.base_url('kehadiran/frmCuti2/index/'.$listingID.'/add/'.$row->HakId).'" selected="selected"'.$sati.' '.$text.'>'.$row->HakId.'. '.$Periode1.' s/d '.$Periode2.'  [sisa : '.$Sisa.' hari]</option>';
                }else{
                    $empty_select .= '<option value="'.base_url('kehadiran/frmCuti2/index/'.$listingID.'/add/'.$row->HakId).'" '.$sati.' '.$text.'>'.$row->HakId.'. '.$Periode1.' s/d '.$Periode2.'  [sisa : '.$Sisa.' hari]</option>';
                }
                
            endforeach;
     

            $js ='<script type = "text/javascript">
                    function goToPage(id) {var node = document.getElementById( id );
                    if( node && node.tagName == "SELECT") 
                        { window.location.href = node.options[node.selectedIndex].value;}
                }
              </script>';

            $hakcuti ="<input type='hidden' maxlength='50' value='" .$PRD. "' name='HakCutiId'>";
            return $empty_select.$empty_select_closed.$js.$hakcuti;

        }



    }


    // Add Type
    public function _callback_add_field_HakCutiId2(){
      
        $stateID = $this->uri->segment(6);
        
    }


    // Add Type
    public function _callback_edit_field_Alasan($value, $row){
        $ListingID = $this->uri->segment(6); 
        $query     = $this->db->query('SELECT * FROM tbl_formcuti WHERE CutiId='.$ListingID);        

       foreach ($query->result() as $rown){
            $today    = date('Y-m-d');
            $TglMasuk = date('Y-m-d', strtotime($rown->TglMasuk)); 

            if (($rown->StatusForm =='P' OR $rown->StatusForm =='') AND $today < $TglMasuk){
                $ted = '';
            }
            else {
                $ted = 'disabled';
            }        
        }

        return "<input type='Text' maxlength='150' name='Alasan' value='".$rown->Alasan.''.$rown->AlasanApv."' $ted>";
        
    }


    public function _callback_edit_field_StatusForm(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="StatusForm" class="chosen-select" data-placeholder="Select Status Form" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(6);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        
            //GET THE STORED STATE ID
            $this->db->select('*')
                     ->from('tbl_formcuti')
                     ->where('CutiId', $listingID);
                     //->where('PISA', 1)
                     //->limit(0,1);

            $db = $this->db->get();
            $row = $db->row(0);
           
            $StatusForm = $row->StatusForm;
            //$KDFaskes = $row->KDFaskesGigi;
            //$KDFaskes = $row->KDFaskes;
          
            //GET THE CITIES PER STATE ID 

            $this->db->select('*')
                     ->from('tbl_statusform');
            $db2 = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            
            foreach($db2->result() as $rown):
                if($rown->CodeStatusForm == $StatusForm) {
                    $empty_select .= '<option value="'.$rown->CodeStatusForm.'" selected="selected">'.$rown->NamaStatusForm.'</option>';
                } else {
                    $empty_select .= '<option value="'.$rown->CodeStatusForm.'">'.$rown->NamaStatusForm.'</option>';
                }
            endforeach;
            
           
            return $empty_select.$empty_select_closed;

        
    }

    public function _callback_jenis_cuti(){

        if (!is_null($this->uri->segment(4))){
            $listingID = $this->uri->segment(4);
        }else{
            $listingID = 0;
        }

        $this->db->select('*')
                 ->from($this->cms_complete_table_name('jeniscuti'))
                 ->where('id',$listingID);
        $db = $this->db->get();
        $row = $db->row(0);
        $num_row = $db->num_rows(); 

        if ($num_row >0){
            return $row->JenisCutiName;
        }
        else{
            return '';
        }
                
    
    }

    public function _callback_my_profile(){
      
        $result = mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$this->cms_user_id());
        $storeArray = Array();
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $storeArray['company'] =  $row['CompanyId'];
            $storeArray['dept'] =  $row['DeptID'];
            $storeArray['sex'] =  $row['Sex'];
            $storeArray['status_diri'] =  $row['StatusDiri'];  
        }

        return $storeArray;     
    
    }

    // add hyperlink
    public function _callback_column_Print($primary_key, $row){

        if ($row->JenisCuti !=4){
        return "javascript:window.open('".site_url('includes/export/frmCuti/Export2Html2.php') .'?id='.$row->CutiId.'&nik='.$_SESSION['NIK']. "', 'Export', 'width=950, height=' + screen.height + ', top=0, left=0,scrollbars=yes,resizable=yes,copyhistory=no,menubar=no,location=no,toolbar=no,directories=0,titlebar=0,status=no', false);void(0)";        
        }
        else{
        return '#';
        }
    }


    public function _callback_add_Keperluan(){
        return '<div id="tooltip"><textarea style="width: 100%;max-width:100%;min-width:100%; height: 80px;" name="Keperluan" title="Nomor telpon minimal 10 digit." class="texteditor"></textarea><span id="characters"><span></div>';
    }

    public function _callback_field_NoTelpon($value, $row){
        return '<input onkeypress="return isNumberKey(event);" maxlength="12" type="text" name="NoTelpon" title="Nomor telpon minimal 10 digit." placeholder="08211321xxxx maksimal 10 digit" class="form-control" value="'.$value.'">';        
    }

    public function _callback_state_action(){
        $crud = $this->new_crud();
        $state = $crud->getState();
        return $state;    
    }


    public function _callback_add_field_LocationCutisssss(){

        /*<div class="form-group">
        <!--<h6>Location</h6>-->
        <label class="radio-inline">
          <input id="LocationId" name="LocationId" value="1" type="radio" onclick="doIt(this);"> Jabodetabek
        </label>
        <label class="radio-inline">
          <input id="LocationId" name="LocationId" value="2" type="radio"  onclick="doIt(this);"> Diluar Jabodetabek
        </label>
        <input type="hidden" name="sum" value="" />
        <div id="sum"></div>
        
    </div>
    <script>
      function doIt(obj){       
        obj.form.elements["sum"].value = obj.value;
      }
    </script>*/
  

        return '
                <div class="form-group">
                <label class="radio-inline">
                    <input id="id_radio1" type="radio" name="name_radio1" value="value_radio1" /> Jabodetabek
                    </label>
                <label class="radio-inline">
                    <input id="id_radio2" type="radio" name="name_radio1" value="value_radio2" /> Diluar Jabodetabek
                </label>
                <label class="radio-inline">
                    <div id="div1"><b>Maksimal Cuti 2 Hari</b></div>
                    <div id="div2"><b>Maksimal Cuti 3 Hari</b></div>                 
                 </label>
                </div>
                <script>
                $(document).ready(function () {

                    $("#div1").hide("fast");
                    $("#div2").hide("fast");

                    $("#id_radio1").click(function () {
                        $("#div2").hide("fast");
                        $("#div1").show("fast");
                        $("#div1").value("2");

                    });
                    $("#id_radio2").click(function () {
                        $("#div1").hide("fast");
                        $("#div2").show("fast");
                    });
                });

                </script>

';

    }



    public function empty_state_dropdown_select2(){
       
       return '
                <div class="form-group">
                <label class="radio-inline">
                    <input id="id_radio1" type="radio" name="name_radio1" value="value_radio1" /> Jabodetabek
                    </label>
                <label class="radio-inline">
                    <input id="id_radio2" type="radio" name="name_radio1" value="value_radio2" /> Diluar Jabodetabek
                </label>
                <label class="radio-inline">
                    <div id="div1"><b>Maksimal Cuti 2 Hari</b></div>
                    <div id="div2"><b>Maksimal Cuti 3 Hari</b></div>                 
                 </label>
                </div>
                <script>
                $(document).ready(function () {

                    $("#div1").hide("fast");
                    $("#div2").hide("fast");

                    $("#id_radio1").click(function () {
                        $("#div2").hide("fast");
                        $("#div1").show("fast");
                        $("#div1").value("2");

                    });
                    $("#id_radio2").click(function () {
                        $("#div1").hide("fast");
                        $("#div2").show("fast");
                    });
                });

                </script>

';

    }


    //GET JSON OF STATES
    public function get_cities2(){
        return '
                <div class="form-group">
                <label class="radio-inline">
                    <input id="id_radio1" type="radio" name="name_radio1" value="value_radio1" /> Jabodetabek
                    </label>
                <label class="radio-inline">
                    <input id="id_radio2" type="radio" name="name_radio1" value="value_radio2" /> Diluar Jabodetabek
                </label>
                <label class="radio-inline">
                    <div id="div1"><b>Maksimal Cuti 2 Hari</b></div>
                    <div id="div2"><b>Maksimal Cuti 3 Hari</b></div>                 
                 </label>
                </div>
                <script>
                $(document).ready(function () {

                    $("#div1").hide("fast");
                    $("#div2").hide("fast");

                    $("#id_radio1").click(function () {
                        $("#div2").hide("fast");
                        $("#div1").show("fast");
                        $("#div1").value("2");

                    });
                    $("#id_radio2").click(function () {
                        $("#div1").hide("fast");
                        $("#div2").show("fast");
                    });
                });

                </script>

';
    }


    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_selectxx()
    {

        $listingID = $this->uri->segment(6);

        $jc = mysql_fetch_array(mysql_query('SELECT * FROM tbl_jeniscuti_item WHERE JenisItemCutiId="'.$listingID.'"'));

        $jml = $jc['DayLimitCuti'];

        $radio_select = '<div class="form-group">
                        <label class="radio-inline">
                            <input id="id_radio1" type="radio" name="name_radio1" value="value_radio1" /> Jabodetabek
                            </label>
                        <label class="radio-inline">
                            <input id="id_radio2" type="radio" name="name_radio1" value="value_radio2" /> Diluar Jabodetabek
                        </label>
                        <label class="radio-inline">
                            <div id="div1"><b>Maksimal Cuti '.$listingID.' Hari</b></div>
                            <div id="div2"><b>Maksimal Cuti 3 Hari</b></div>                 
                        </label>
                        </div>

                        <select id="age" name="age">
            <option value="13">13 or younger</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
        </select>
        <div id="parentPermission">
        <p>Parents Name:
            <input type="text" name="parent_name" />
        </p>
        <p>Parents Email:
            <input type="text" id="srt" name="parent_email" />
        </p>
        
        <p>You must have parental permission before you can play.</p>
    </div>

                        <script>
                        $(document).ready(function(){
                            $("#div1").hide("fast");
                            $("#div2").hide("fast");
                            $("#id_radio1").click(function () {
                                $("#div2").hide("fast");
                                $("#div1").show("fast");
                                $("#div1").value("2");
                            });
                            $("#id_radio2").click(function () {
                                $("#div1").hide("fast");
                                $("#div2").show("fast");
                            });
                        });

$(document).ready(function () {
    toggleFields(); 
    $("#age").change(function () {
        toggleFields();
    });

});
function toggleFields() {
    var age = $("#age").val();
    var dop = document.getElementById("srt").value;

    if (age <= 13)
        $("#parentPermission").show();
    else
        $("#parentPermission").hide();
}

                        </script>';

        return $radio_select;

    }

    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_select()
    {
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        $listingID = 4;


        $tooltip = '<a href="#" class="tooltip">Tooltip<span>                    
                    <strong>Most Light-weight Tooltip</strong><br />
                    This is the easy-to-use Tooltip driven purely by CSS.
                    </span>
                    </a>';

        $empty_select = '<select name="LocationCuti" class="chosen-select" data-placeholder="Select Location" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';       
        
        return '<div class="form-group"><div class="form-inline">'.$empty_select.$empty_select_closed.$tooltip.'</div></div>';


        $radio_select = '<div class="form-group">
                        <label class="radio-inline">
                            <input id="id_radio1" type="radio" name="name_radio1" value="value_radio1" /> Jabodetabek
                        </label>
                        <label class="radio-inline">
                            <input id="id_radio2" type="radio" name="name_radio1" value="value_radio2" /> Diluar Jabodetabek
                        </label>
                        <label class="radio-inline">
                            <div id="div1"><b>Maksimal Cuti '.$listingID.' Hari</b></div>
                            <div id="div2"><b>Maksimal Cuti 3 Hari</b></div>                 
                        </label>
                        </div>            

                        <script>
                        $(document).ready(function(){
                            $("#div1").hide("fast");
                            $("#div2").hide("fast");
                            $("#id_radio1").click(function () {
                                $("#div2").hide("fast");
                                $("#div1").show("fast");
                                $("#div1").value("2");
                            });
                            $("#id_radio2").click(function () {
                                $("#div1").hide("fast");
                                $("#div2").show("fast");
                            });
                        });
                        </script>';

        //return $radio_select;

        
        
    }

    
                
    //GET JSON OF STATES
    public function get_states()
    {
        $LocationId = $this->uri->segment(4);

        $jc  = mysql_fetch_array(mysql_query('SELECT * FROM tbl_jeniscuti_item WHERE JenisItemCutiId="'.$LocationId.'"'));

        $jml = $jc['DayLimitCuti'];
        $Jabodetabek = $jc['Jabodetabek'];

        
        $this->db->select("*")
                 ->from('tbl_jeniscuti_item_detail');
        $db = $this->db->get();
        
        
        $array = array();
        foreach($db->result() as $row):

            if ($Jabodetabek ==1){
                $total_cuti = $jml + $row->JenisItemCutiDetailQty;
            }
            else{
                $total_cuti = $jml;
            }

            $max_cuti = '[Maksimal Cuti '.$total_cuti.' Days]';

            $array[] = array("value" =>$row->JenisItemCutiDetailId, "property" => $row->JenisItemCutiDetailName.' '.$max_cuti);
        endforeach;           


        echo json_encode($array);

        //return json_encode($array);

        exit;



    }

    public function get_json($my_location){

        return $my_location;

    }

    public function my_json(){

        return $this->get_states();

    }


    //GET JSON OF STATES
    public function get_statesxxx()
    {
        $companyID = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_jeniscuti_item')
                 ->where('JenisItemCutiId', $companyID);
        $db = $this->db->get();
        
        $row = $db->row(0);        

        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->DayLimitCuti);
        endforeach;
        
        echo json_encode($array);
        exit;
    }


    public function _callback_add_field_JenisItemCuti(){          

        $empty_select = '<select id="select" name="JenisItemCuti2" onchange=goToPage("select") class="chosen-select" data-placeholder="Select Jenis Ijin" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
       
        $listingID = $this->uri->segment(4);
        $itemIDa   = $this->uri->segment(6);

        if (is_null($itemIDa) || empty($itemIDa)){
            $itemID = 0;
        }else{
            $itemID = $this->uri->segment(6);
        }

        $crud = new grocery_CRUD();
        $state = $crud->getState();       
    
            $this->db->select('*')
                     ->from('tbl_jeniscuti_item')
                     ->where('JenisItemCutiStatus', 1);
            $db = $this->db->get();
            
            $empty_select .= '<option value="0" disabled selected>Select Jenis Ijin</option>';

            foreach($db->result() as $row):                                
                if($row->JenisItemCutiId == $itemID) {
                    $empty_select .= '<option value="'.base_url('kehadiran/frmCuti2/index/'.$listingID.'/add/'.$row->JenisItemCutiId).'" selected="selected">'.$row->JenisItemCutiName.'</option>';
                }else{
                    $empty_select .= '<option value="'.base_url('kehadiran/frmCuti2/index/'.$listingID.'/add/'.$row->JenisItemCutiId).'">'.$row->JenisItemCutiName.'</option>';
                }
                

            endforeach;

           $js ='<script type = "text/javascript">
                    function goToPage(id) {var node = document.getElementById( id );
                    if( node && node.tagName == "SELECT") 
                        { window.location.href = node.options[node.selectedIndex].value;}
                }
              </script>';

            return $empty_select.$empty_select_closed.$js;



    

                
    }

    public function _callback_add_field_LocationCuti(){
        $itemIDa   = $this->uri->segment(6);

        $jc  = mysql_fetch_array(mysql_query('SELECT * FROM tbl_jeniscuti_item WHERE JenisItemCutiId="'.$itemIDa.'"'));

        $jml = $jc['DayLimitCuti'];
        $Jabodetabek = $jc['Jabodetabek'];

        if ($Jabodetabek == 1){   
            $total_cuti1 = $jml;          
            $total_cuti2 = $jml + 1;
        }else{
            $total_cuti1 = $jml;          
            $total_cuti2 = $jml;
        }            
       

        $radio_select = '<input type="hidden" maxlength="50" value="100" name="SisaCuti">';
        $radio_select .= '<div class="form-group">';
        $radio_select .= '<label class="radio-inline">';
        $radio_select .= '<input id="id_radio1" type="radio" name="LocationCuti" value="1" /> Jabodetabek';
        $radio_select .= '</label>';
        $radio_select .= '<label class="radio-inline">';
        $radio_select .= '<input id="id_radio2" type="radio" name="LocationCuti" value="0" /> Diluar Jabodetabek';
        $radio_select .= '</label>';
        $radio_select .= '<label class="radio-inline">';
        $radio_select .= '<div id="tooltip">';
        $radio_select .= '<div id="div1"><a href="#" style="text-decoration: none; color:#000000;" title="Setiap Kelebihan Cuti Tanggal Akan Dipotong Otomatis"><strong>Maksimal Cuti '.$total_cuti1.' Hari</strong></a><b></b></div>';
        $radio_select .= '<div id="div2"><a href="#" style="text-decoration: none; color:#000000;" title="Setiap Kelebihan Cuti Tanggal Akan Dipotong Otomatis"><strong>Maksimal Cuti '.$total_cuti2.' Hari</strong></a><b></b></div>';
        $radio_select .= '</div>';
        //$radio_select .= '<div id="div2"><b>Maksimal Cuti '.$total_cuti2.' Hari</b></div>';                 
        $radio_select .= '</label>';
        $radio_select .= '</div>';
        $radio_select .= '<script>
                            $(document).ready(function(){
                            $("#div1").hide("fast");
                            $("#div2").hide("fast");
                            $("#id_radio1").click(function () {
                                $("#div2").hide("fast");
                                $("#div1").show("fast");
                            });
                            $("#id_radio2").click(function () {
                                $("#div1").hide("fast");
                                $("#div2").show("fast");
                            });
                        });
                        </script>';

        return $radio_select;
    }


    private function randomize_string($value){
        $time = date('Y:m:d H:i:s');
        return substr(md5($value.$time),0,9);
    }

    public function hapus_cuti_lebih($primary_key){

        $query  = mysql_query("SELECT * FROM tbl_formcuti INNER JOIN 
                               tbl_jeniscuti_item ON tbl_jeniscuti_item.JenisItemCutiId=tbl_formcuti.JenisItemCuti 
                               WHERE CutiId='$primary_key'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        if ($data['LocationCuti']==1){
            $jml_cuti = $data['DayLimitCuti'];
        }else{
            $jml_cuti = ($data['DayLimitCuti']+1);
        }

        $sql     = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId='$primary_key'");
        $jumlah  = mysql_num_rows($sql);
        $row     = mysql_fetch_array($sql);

        $delete_sisa = $jumlah - $jml_cuti;

        if ($jumlah > $jml_cuti){

            mysql_query("DELETE FROM tbl_formcutidetail WHERE CutiId ='$primary_key' ORDER BY TglCuti DESC LIMIT $delete_sisa");

        }




    }


    public function update_tgl_active_dua($primary_key){

        $query  = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId='".$primary_key."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        $isa        = strtotime($data['TglActive1']);
        $TglActive2 = date('Y-m-d',strtotime('+'.$this->maximum_days_of_form().' -1 day',$isa));

        $this->db->update($this->cms_complete_table_name('formcuti'),array('TglActive2'=>$TglActive2),array('CutiId'=>$primary_key));

    }

    public function modal_dialog_detail($primary_key , $row){

        if ($row->JenisCuti !=4){

            //return site_url($this->uri->segment('1').'/'.$this->uri->segment('2').'/index/?ref=detail&id='.$primary_key);
            return '?ref=detail&id='.$primary_key;
        }
        else{
            return '#';
        }

    }

    public function _callback_add_field_NIKPengganti($value, $primary_key){

        $this->load->model('data_filter_model');
        return $this->data_filter_model->data_filter_user_cross_company_nik_pengganti($session_nik=$this->cms_user_id());
    
    }

    public function _callback_add_field_max_cuti_melahirkan(){

        return '90 Days<input type="hidden" maxlength="50" value="90" name="SisaCuti">';

    }


    public function _callback_add_field_TglActive1(){            

        return '<input class="datepicker-input" title="We ask for your age only for statistical purposes." placeholder="Select start date" type="text" name="TglActive1" id="TglActive1" />';
   
    }   

     

    public function _callback_add_field_TglActive2(){

        return '<input class="datepicker-input" placeholder="Select end date" contenteditable="false" type="text" name="TglActive2" id="TglActive2" />';

    }    


    public function _callback_add_field_TglMasuk(){

        return '<div class="input-group date" data-provide="datepicker">
                <input type="text" class="form-control" name="TglMasuk" id="to" placeholder="dd/mm/yyyy" title="We ask for your age only for statistical purposes.">
               <span class="input-group-addon">
                    <a href="#" style="text-decoration: none;" class="glyphicon glyphicon-question-sign tip-right" data-toggle="tooltip" title="Tanggal masuk kerja setelah 90 hari"></a>
                </span>
               </div>';     

    }


    public function new_format_date_mysql($date){

        $dd      = substr($date,0,2);
        $mm      = substr($date,3,2);
        $yyyy    = substr($date,6,4);

        $new_format_date = $yyyy.'-'.$mm.'-'.$dd;

        return $new_format_date;


    }

    public function maximum_days_of_form(){

        $query  = mysql_query("SELECT * FROM tbl_jeniscuti WHERE id='".$this->uri->segment(4)."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        if ($total >0){
            $max_day = $data['maximun_days'];
        }else{
            $max_day = '';
        }

        return $max_day;


    }


    public function count_days($primary_key){

        $query  = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId='".$primary_key."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        $startTimeStamp = strtotime($data['TglActive1']);
        $endTimeStamp   = strtotime($data['TglActive2']);
        $timeDiff       = abs($endTimeStamp - $startTimeStamp);
        $numberDays     = $timeDiff/86400;  // 86400 seconds in one day
        $numberDays     = intval($numberDays+1);

        return $numberDays;

    }


    public function maximum_cuti_khusus_ijin(){

        $query  = mysql_query("SELECT * FROM tbl_jeniscuti_item WHERE JenisItemCutiId='".$this->uri->segment(6)."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        if ($total >0){
            $max_cuti = $data['DayLimitCuti']+1;
        }else{
            $max_cuti = '';
        }

        return $max_cuti;


    }
    
 

    

    

}