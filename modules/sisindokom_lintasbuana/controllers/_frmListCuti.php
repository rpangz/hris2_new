<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class frmListCuti extends CMS_Priv_Strict_Controller {

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
        $company_id = $this->cms_get_config('cms_sisindokom_id');
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
        //$crud->unset_read();
        $crud->unset_texteditor('Remark');
        // $crud->unset_add();
        //$crud->unset_edit();
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();

        $crud->unset_texteditor('Alamat');
        $crud->unset_texteditor('Keperluan');
        $crud->unset_texteditor('Alasan');
        $listingID = $this->uri->segment(4);
        $_SESSION['JenisCuti'] = $listingID;

        //$crud->add_action('More', '', 'demo/action_more','ui-icon-plus');
        

        

        $dta = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$session_nik'"));

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');
            $crud->set_relation('ApvLevel', $this->cms_complete_table_name('apv_matrik_approval'), '{MatName}',array('MatCode' => $company_id));
            $crud->display_as('FormCutiNIK','NIK');
            //$crud->set_relation('FormCutiNIK', $this->cms_complete_table_name('profile'), 'NIK',array('NIK >' => 0));
            //$crud->unset_add();
        }
        else {
            $crud->set_relation('FormCutiNIK', $this->cms_complete_table_name('profile'), '{Nama} - {NIK}',array('NIK >' => 0,'companyID' => $company_id));
            $crud->display_as('FormCutiNIK','Nama');
        }

        
      
        

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->cms_complete_table_name('formcuti'));

        $list = $this->uri->segment(4);

        if ($this->uri->segment(4) !=0 && !is_null($this->uri->segment(4)) && isset($list)){
            $crud->where('JenisCuti', $this->uri->segment(4));
            $crud->where('tbl_formcuti.companyID', $company_id);
            //$crud->where('tbl_formcuti.FormCutiNIK', $this->uri->segment(5));
            $crud->order_by('CutiId','DESC');
        }
        else {
            $crud->where('JenisCuti >=', 0);
            $crud->where('tbl_formcuti.companyID', $company_id);
            //$crud->where('tbl_formcuti.FormCutiNIK >', 0);
            $crud->order_by('CutiId','DESC');
            $crud->unset_add();
            //$crud->unset_edit();
        }

        $list5 = $this->uri->segment(5);

        if ($this->uri->segment(5) !=0 && !is_null($this->uri->segment(5)) && isset($list5)){            
            $crud->where('tbl_formcuti.FormCutiNIK', $this->uri->segment(5));
                      
        }
        else {           
            $crud->where('tbl_formcuti.FormCutiNIK >', 0);

           
        }


/*
        if ($this->uri->segment(4) !=0 && !is_null($this->uri->segment(4)) && isset($listingID)){
            
            $crud->where('iTransPeriodId', $this->uri->segment(5));
            //$where = 'tbl_trans.itransStokId = tbl_stok.iStokID AND tbl_stok.iStokType='.$this->uri->segment(4);
            $crud->where('iStokType', $this->uri->segment(4));
            //$crud->or_where('productName','Car');
        }
        else {
            
            $crud->where('iTransPeriodId >=', 0);
            $crud->where('iStokType >=', 0);
            //$crud->or_where('itransStokId >=', 0);
        }
*/
       
        
        //$crud->order_by('Name','ASC');

        // primary key
        $crud->set_primary_key('CutiId');
        $crud->change_field_type('NoTelpon', 'integer');
        
        //$dKBDate = date('d-M-y', $crud->columns('dBudgetDate');
        // set subject
        //$jka = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id = '$listingID'"));
        //$nmc = $jka['JenisCutiName'];

        $jka = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id = '$listingID'"));
        $nmc = $jka['JenisCutiName'];

        $crud->set_subject('Form Cuti '.$nmc);

        $crud->unset_add_fields('CreatedBy','CreatedTime','Tgl1','Tgl2','Tgl3','Apv1','Apv2','Apv3','StatusForm','ApvLevel');
        $crud->field_type('CreatedBy', 'hidden', $session_nik);
        $crud->field_type('CreatedTime', 'hidden', $today);
        $crud->field_type('Tgl1', 'hidden', $today);
        $crud->field_type('Tgl2', 'hidden', $today);
        $crud->field_type('Tgl3', 'hidden', $today);
        $crud->field_type('Apv1', 'hidden', 'A');
        $crud->field_type('Apv2', 'hidden', 'A');
        $crud->field_type('Apv3', 'hidden', 'A');       
        $crud->field_type('ApvLevel', 'hidden', 3);
        $crud->field_type('JmlTgl', 'hidden');        
       
       



        // displayed columns on list
        $crud->columns('FormCutiNIK','NIK','JenisCuti','Keperluan','Detail','TglMasuk','ApvLevel','StatusForm','Aturan');
        // displayed columns on edit operation

        // displayed columns on add operation
       

        
        if (!is_null($this->input->get('nik'))){
            $NIKKI = $this->input->get('nik');
            $dt    = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$NIKKI'"));
            $ert   = $dt['Email'];

        }else{
            $NIKKI = 0;
            $ert   = '-';
        }

        
       // caption of each columns      
        $crud->display_as('CutiId','ID'); 
        $crud->display_as('NIK','Nama');
        $crud->display_as('TglActive1','Tgl Active1');
        $crud->display_as('TglActive2','Tgl Active2');
        $crud->display_as('Keperluan','Keperluan');
        $crud->display_as('StatusForm','Status Form');
        $crud->display_as('ApvLevel','Approval');
        $crud->display_as('NoTelpon','No Telpon');
        $crud->display_as('NIK2','Atasan Lebih Tinggi');
        $crud->display_as('NIK3','HRD');
        $crud->display_as('NIK1','Atasan Langsung');
        $crud->display_as('Detail','Cuti Tanggal');
        $crud->display_as('TglMasuk','Tanggal Masuk Kembali Bekerja');
        $crud->display_as('HakCutiId','Periode Pengambilan Cuti');
        $crud->display_as('HakCutiId2','Periode Hak Cuti');
        $crud->display_as('TglCuti','Tanggal Cuti');
        $crud->display_as('JenisCuti','Jenis Cuti');
        $crud->display_as('Apv1','Atasan Langsung - Apv 1');
        $crud->display_as('Apv2','Atasan Lebih Tinggi - Apv 2');
        $crud->display_as('Apv3','HRD - Apv 3');
        $crud->display_as('SendMail','Email to '.$ert);
        $crud->display_as('Aturan','Pengajuan');  
        $crud->display_as('NIKPengganti','Petugas Pengganti');          
        
        

        $crud->required_fields('FormCutiNIK','JenisCuti','StatusForm','Keperluan','Alamat','HakCutiId','TglMasuk','NIKPengganti','NoTelpon','NIK1','NIK2','NIK3','Alasan','Apv1','Apv2','Apv3');

       
        if (!is_null($this->input->get('nik'))){
            $NIKKI = $this->input->get('nik');
            //$crud->set_relation('FormCutiNIK', $this->cms_complete_table_name('profile'), 'Nama',array('NIK' => $NIKKI));
            $crud->callback_add_field('FormCutiNIK', array($this, '_callback_add_field_FormCutiNIK'));

            $cm        = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$NIKKI));
            $companyID = $cm['CompanyId'];
            $DeptID    = $cm['DeptID'];
            $crud->unset_add_fields('companyID');
            $crud->field_type('companyID', 'hidden', $companyID);
            $crud->set_relation('FormCutiNIK', $this->cms_complete_table_name('profile'), 'Nama',array('NIK >' => $NIKKI));

        }else{
            $NIKKI     = '0';
            $DeptID    = 0;
            //$crud->set_relation('FormCutiNIK', $this->cms_complete_table_name('profile'), 'Nama',array('NIK >' => $NIKKI));
        }
        


        $crud->set_relation('JenisCuti', $this->cms_complete_table_name('jeniscuti'), 'JenisCutiName',array('id !=' => 0));

        if ($state=='edit'){
            $crud->set_relation('StatusForm', $this->cms_complete_table_name('statusform'), 'NamaStatusForm');
             //$crud->callback_edit_field('StatusForm',array($this,'_callback_edit_field_StatusForm'));
           
        }
        else{
             $crud->field_type('StatusForm', 'hidden', 'A');
        }

       

        $crud->set_relation('NIK1', $this->cms_complete_table_name('profile'), 'Nama');
        $crud->set_relation('NIK2', $this->cms_complete_table_name('profile'), 'Nama');
        //$crud->set_relation('FormCutiNIK', $this->cms_complete_table_name('profile'), 'Nama',array('CompanyId !=' => 2));

/*
        $crud->field_type('NIK3','dropdown',array('4833' => 'Dompak Petrus Sinambela [dompak.sinambela@unias.com]',
                                                  '3333' => 'Yosia Lombu [dompak.sinambela@unias.com]')); 
*/
        $crud->set_relation('NIK3', $this->cms_complete_table_name('apv_hrd'), '{hrd_name}',array('hrd_status' => 1,'hrd_company' => $company_id, 'hrd_modules' => $hrd_modules));

        if ($state=='read'){
            $crud->edit_fields('FormCutiNIK','JenisCuti','Keperluan','Alamat','NIKPengganti','NoTelpon','Detail','TglMasuk','NIK1','NIK2','NIK3');
            $crud->set_relation('NIKPengganti', $this->cms_complete_table_name('profile'), '{Nama} - {NIK}');
        }
        else{
            $crud->edit_fields('StatusForm','Alasan');
            $crud->set_relation('NIKPengganti', $this->cms_complete_table_name('profile'), '{Nama} - {NIK}',array('bStatus' =>1,'DeptID' => $DeptID));
        }

        

        

        //$crud->change_field_type('SendMail', 'enum', array( 'English' => 'en', 'Russian' => 'ru' ));
        $crud->field_type('SendMail','true_false',array('No','Yes'));
        
        
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $crud->callback_column('Detail',array($this, '_callback_column_citizen'));
        $crud->callback_field('Detail',array($this, '_callback_field_citizen'));

        $crud->callback_edit_field('HakCutiId2', array($this, '_callback_edit_field_HakCutiId2'));
        $crud->callback_edit_field('FormCutiNIK2', array($this, '_callback_edit_field_FormCutiNIK2'));
        //$crud->callback_edit_field('FormCutiNIK', array($this, '_callback_add_field_FormCutiNIK'));
        $crud->callback_column('StatusForm',array($this,'_callback_column_StatusForm'));
        $crud->callback_column('Aturan',array($this,'_callback_column_Aturan'));      

        $crud->callback_add_field('NIK1', array($this, '_callback_add_field_NIK1'));
        $crud->callback_add_field('NIK2', array($this, '_callback_add_field_NIK2'));
        //$crud->callback_add_field('NIK3', array($this, '_callback_add_field_NIK3'));
        $crud->callback_column('TglMasuk', array($this, '_callback_column_TglMasuk'));
        //$crud->callback_add_field('iNIK4', array($this, '_callback_add_field_iNIK4'));
        
        //$crud->callback_add_field('HakCutiId', array($this, '_callback_add_field_HakCutiId'));
        $crud->callback_edit_field('Alasan', array($this, '_callback_edit_field_Alasan'));
        //$crud->callback_add_field('HakCutiId2', array($this, '_callback_add_field_HakCutiId2'));
        $crud->callback_column('NIK',array($this,'_callback_column_NIK'));

        $crud->callback_add_field('JmlTgl', array($this, 'empty_city_dropdown_select'));
        $crud->callback_edit_field('JmlTgl', array($this, 'empty_city_dropdown_select'));

        if (!is_null($this->input->get('hc')) AND $this->uri->segment(4) !=3){            
            $crud->add_fields('JenisCuti','FormCutiNIK','HakCutiId2','Keperluan','Alamat','NoTelpon','Detail','TglMasuk','NIKPengganti','NIK1','Apv1','NIK2','Apv2','NIK3','Apv3','Tgl1','Tgl2','Tgl3','StatusForm','ApvLevel','CreatedBy','CreatedTime','SendMail','companyID');
            $crud->callback_add_field('HakCutiId2', array($this, '_callback_add_field_HakCutiId2'));
        
        }
        elseif (!is_null($this->input->get('hc')) AND $this->uri->segment(4) ==3){
            $crud->add_fields('JenisCuti','FormCutiNIK','HakCutiId2','Keperluan','Alamat','NoTelpon','TglActive1','TglActive2','TglMasuk','NIKPengganti','NIK1','Apv1','NIK2','Apv2','NIK3','Apv3','Tgl1','Tgl2','Tgl3','StatusForm','ApvLevel','CreatedBy','CreatedTime','SendMail','companyID');
            $crud->callback_add_field('HakCutiId2', array($this, '_callback_add_field_HakCutiId2'));

        }
        else{
            //$crud->add_fields('JenisCuti','FormCutiNIK','HakCutiId','Keperluan','Alamat','Pengganti','NoTelpon','Detail','TglMasuk','NIK1','NIK2','NIK3','CreatedBy','CreatedTime');
            $crud->add_fields('JenisCuti','FormCutiNIK','HakCutiId','Keperluan','Alamat','NoTelpon','Detail','TglMasuk','NIKPengganti','NIK1','Apv1','NIK2','Apv2','NIK3','Apv3','Tgl1','Tgl2','Tgl3','StatusForm','ApvLevel','CreatedBy','CreatedTime','SendMail','companyID');

            $crud->callback_add_field('HakCutiId', array($this, 'empty_state_dropdown_select'));
            $crud->callback_edit_field('HakCutiId', array($this, 'empty_state_dropdown_select'));

            $crud->set_relation('HakCutiId', $this->cms_complete_table_name('hakcuti'), '{Periode1} - {Periode2} [{Qty}]',array('NIK' => $session_nik,'StatusHak' => 1));
            
        }


        $crud->callback_add_field('JenisCuti', array($this, '_callback_add_field_JenisCuti'));
        $crud->set_relation('HakCutiId', $this->cms_complete_table_name('hakcuti'), '{Periode1} - {Periode2} [{Qty}]',array('NIK' => $session_nik,'StatusHak' => 1));
        $crud->add_action('Print', 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/images/print1.png', ' ',' http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/images/print1.png',array($this,'_callback_column_Print'));
                


        $this->crud = $crud;
        return $crud;
    }

    public function _example_output($output = null){      

        //$this->view($this->cms_module_path().'modules/customers', $output);
        $this->view($this->cms_module_path().'/frmListCuti_view', $output,
        $this->cms_complete_navigation_name('frmListCuti'));    
    }


    

    public function index(){
        $crud = $this->make_crud();

        $dd_data = array(

                'dd_state' =>  $crud->getState(),
                'dd_dropdowns' => array('FormCutiNIK','HakCutiId'),            
                'dd_url' => array('', site_url().'/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/get_states/', site_url().'/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/get_cities/'),
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
                    $this->db->delete($this->cms_complete_table_name('formcuti'),array('CutiId'=>$id));
                    $this->_after_delete($id);
                }
            }
        }
    }

    // change dPeriodEndDate format to d-M-Y
    public function _date_format_callback($value, $row){
        //return $value." - scale: <b>".$row->date."</b>";
        $date_value = date('d-M-Y', strtotime($row->StartingDate));
        return $date_value;
        
    }

    public function _before_insert($post_array){
        $post_array = $this->_before_insert_or_update($post_array);
        // HINT : Put your code here
        $data = json_decode($this->input->post('md_real_field_citizen_col'), TRUE);
        $insert_records = $data['insert'];

        $real_column_names = array('DetailCutiId','CutiId','Keterangan','TglCuti','active_id');
        $set_column_names = array();

        $data['TglCuti'] = $TglCuti;
        $todayku = date('d/m/Y');

        if (count($insert_records) <=0){
            return FALSE;
        }else{
            return $post_array;        
       }

        //return $post_array;
    }

    public function _after_insert($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);
       
        $ID       = $primary_key;
        $SendMail = $post_array['SendMail'];

        $TglMasukku    = $post_array['TglMasuk'];
        $dateObj       = DateTime::createFromFormat('d/m/Y', $TglMasukku);
        $TglMasuk      = $dateObj->format('Y-m-d');



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


        if(($num_row ==0 || $total ==0) && $SendMail ==1){

            include "http://".$_SERVER['SERVER_NAME']."/hris2/includes/mailer/frmListCuti/SendMail.php?id=".$primary_key;
            echo "<script language='javascript'>alert('Data Sudah Disimpan dan Email sudah dikirim...$num_row , $total');</script>";

        }
        elseif(($num_row ==0 || $total ==0) && $SendMail ==0){

            echo "<script language='javascript'>alert('Data Sudah Disimpan...$num_row , $total ');</script>";

        }
        else{

            mysql_query("DELETE FROM tbl_formcuti WHERE CutiId =".$primary_key);
            mysql_query("DELETE FROM tbl_formcutidetail WHERE CutiId=".$primary_key);
            
            echo "<script language='javascript'>alert('Error!!! Tgl Cuti Dan Tgl Masuk tidak sesuai, silahkan isi kembali...$num_row , $total');history.go(-1);</script>";

        }

        
        
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

        //$ListingID   = $this->uri->segment(6);
        //$session_nik = $this->cms_user_id();

        //$dt       = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formperpcuti WHERE NIK=".$session_nik." AND FormPerpCutiId=".$ListingID));
        // /$ID       = $dt['FormPerpCutiId'];
        $ID       = $primary_key;

        include "http://$_SERVER[SERVER_NAME]/hris2/includes/mailer/frmListCuti/SendMailVoid.php?id=$ID";
        echo "<script language='javascript'>alert('Data Sudah Disimpan dan Email sudah dikirim...');</script>";


        return $success;
    }

    public function _before_delete($primary_key){
        // delete corresponding citizen
        $this->db->delete($this->cms_complete_table_name('formcutidetail'),
              array('CutiId'=>$primary_key));
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


        
        

        //$server = $_SERVER['SERVER_NAME'];

        //echo "<script language='javascript'>alert('Data Sudah Disimpan dan Email sudah dikirim...');window.location ='http://astapp02/hris2/kehadiran/frmProgressApproval';</script>";
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

       

        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
        );

        return $this->load->view($this->cms_module_path().'/field_listcuti_detail',$data, TRUE);
    }

    // returned on view
    public function _callback_column_citizen($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('DetailCutiId, CutiId, Keterangan, TglCuti, active_id')
            ->from($this->cms_complete_table_name('formcutidetail'))
            ->where('CutiId', $row->CutiId)
            ->get();
        $num_row = $query->num_rows();
        //$HakCutiId   = $row->HakCutiId;   
        // show how many records
        if($num_row>1){
            return $num_row .' Hari';
        }else if($num_row>0){
            return $num_row .' Hari';
        }else{
            return 'No Data';
        }
    }


    // Add Default Tagging Asset
    public function _callback_add_field_FormCutiNIK(){
      
        //$stateID = $this->uri->segment(5);
        //$NIK = $this->cms_user_id();
        $NIK = $this->input->get('nik');
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('profile'))     
            ->where('NIK', $NIK)
            ->get();        

        foreach ($query->result() as $rown){
            return $rown->NIK.' - '.$rown->Nama."<input type='hidden' maxlength='50' value='".$rown->NIK."' name='FormCutiNIK'>";
        }   
        
    }


    // Add Default Tagging Asset
    public function _callback_edit_field_HakCutiId2(){ 

        $listingID   = $this->uri->segment(6); 

        $this->db->select('*')
                     ->from('tbl_formcuti')
                     ->where('CutiId', $listingID);
            $db          = $this->db->get();
            $row         = $db->row(0);
            $HakCutiId   = $row->HakCutiId;    
    
           $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('hakcuti'))     
            ->where('HakId', $HakCutiId)
            ->get();        

        foreach ($query->result() as $rown){
            $Periode1 = date('d M Y', strtotime($rown->Periode1));
            $Periode2 = date('d M Y', strtotime($rown->Periode2));

            return $Periode1.' s/d '.$Periode2."<input type='hidden' maxlength='50' value='".$rown->HakId."' name='FormCutiNIK'>";
        }   
        
    }


    // Add Default Tagging Asset
    public function _callback_edit_field_FormCutiNIK2(){ 

        $listingID   = $this->uri->segment(6);
        $this->db->select('*')
                     ->from('tbl_formcuti')
                     ->where('CutiId', $listingID);
            $db          = $this->db->get();
            $row         = $db->row(0);
            $FormCutiNIK   = $row->FormCutiNIK;    
    
           $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('profile'))     
            ->where('NIK', $FormCutiNIK)
            ->get();        

        foreach ($query->result() as $rown){
            return $rown->Nama."<input type='hidden' maxlength='50' value='".$rown->Nama."' name='FormCutiNIKKI'>";
        }   
        
    }




    //CALLBACK FUNCTIONS
    public function _callback_add_field_HakCutiId2(){
        //CREATE THE EMPTY SELECT STRING
       $FormCutiNIK = $this->input->get('nik');

       //$JenisCuti   = $this->uri->segment(4);
       if ($_SESSION['JenisCuti']==1 OR $_SESSION['JenisCuti']==4){
            $JenisCuti = 1;
        }
        else {
            $JenisCuti = $_SESSION['JenisCuti'];
        }



       if (!is_null($this->input->get('hc'))){
            $HakCutiId   = $this->input->get('hc'); 
       }
       else {
            $HakCutiId   = 0; 
       }       
       
       $today       = date('Y-m-d');
       
       $query = $this->db->select('*')
                ->from($this->cms_complete_table_name('hakcuti'))
                ->where('NIK',$FormCutiNIK)
                ->where('HakId',$HakCutiId)
                ->where('JenisHakCuti',$JenisCuti)
                ->get();

        

       

        //$db      = $this->db->get();
        $num_row = $query->num_rows();
            //$row    = $db->row(0);
            //$HakId  = $row->HakId;

            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
           
        foreach($query->result() as $row):
            
            $Periode1 = date('d-M-Y', strtotime($row->Periode1));
            $Periode2 = date('d-M-Y', strtotime($row->Periode2));

            $dta      = mysql_fetch_array(mysql_query('SELECT count(FormCutiNIK) AS QtyPakai FROM tbl_formcuti INNER JOIN 
                                                    tbl_formcutidetail ON tbl_formcuti.CutiId = tbl_formcutidetail.CutiId 
                                                    WHERE tbl_formcuti.FormCutiNIK="'.$FormCutiNIK.'" AND HakCutiId="'.$row->HakId.'" 
                                                    AND StatusForm="A" '));

            //$jka      = mysql_fetch_array(mysql_query('SELECT * FROM tbl_jeniscuti WHERE id="'.$row->JenisHakCuti.'"'));

        
            //$LimitExp = $jka['LimitExp'];

            if (is_null($row->PeriodeExt) OR $row->PeriodeExt ==""){
                $soon     = date('Y-m-d', strtotime($row->Periode2));

            }
            else {
                $soon     = date('Y-m-d', strtotime($row->PeriodeExt));
            }

            
            $soon2    = date('Y-m-d', strtotime($soon));
            $Qty      = $row->Qty;
            $QtyPakai = $dta['QtyPakai'];
            $Sisa     = $Qty - $QtyPakai;
           

            if ($today > $soon || $Sisa <= 0){
                $HakId = 0;
                $ne    = 'Tidak Bisa Dipakai';
            }
            
            else{
                $HakId = $row->HakId;
                $ne    = 'Bisa Dipakai';
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
           
            
                          
                
            endforeach;

            if ($num_row <=0 || $today < $row->Periode1 || $Sisa <=0){
                $empty_select = "<b>Tidak Ada</b><input type='hidden' maxlength='50' value='' name='HakCutiId'>";
            }

            elseif ($num_row <=0 || $today > $row->Periode2 && is_null($row->PeriodeExt) || $Sisa <=0){
                $empty_select = "<b>Tidak Ada</b><input type='hidden' maxlength='50' value='' name='HakCutiId'>";
            }


            elseif ($num_row <=0 || $today > $row->PeriodeExt && !is_null($row->PeriodeExt) || $Sisa <=0){
                $empty_select = "<b>Tidak Ada</b><input type='hidden' maxlength='50' value='' name='HakCutiId'>";
            }
            else {
            //elseif ($num_row >0 || $today < $soon || $Sisa > 0){
                 $empty_select = $Periode1.' s/d '.$Periode2.' [Sisa :'.$Sisa.'] - '.$ne."<input type='hidden' maxlength='50' value='".$row->HakId."' name='HakCutiId'>";
            //}
            //else {
           //      $empty_select = "<b>Tidak Ada</b><input type='hidden' maxlength='50' value='' name='HakCutiId'>"; 

            }
            

            
            return $empty_select;

           
            
            //RETURN SELECTION COMBO
            //return $empty_select.$empty_select_closed;
       
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


    

    //CALLBACK FUNCTIONS
    public function _callback_add_field_NIK1(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK1" class="chosen-select" data-placeholder="Select Atasan Langsung" style="width: 400px; display: none;">';
        $empty_select_closed= '</select>';
        //GET THE ID OF THE LISTING USING URI
        //$listingID = $this->uri->segment(5);
        
        if (!is_null($this->input->get('nik'))){
            $FormCutiNIK = $this->input->get('nik'); 
        }
        else {
            $FormCutiNIK = 0; 
        }    

        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();

        $session_nik = $this->cms_user_id();
        
        $dta = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = ".$FormCutiNIK));
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
                     ->order_by('iGroupApprovalListId','ASC');

            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select Atasan Langsung</option>';

            foreach($db->result() as $row):               
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.'</option>';
                
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;
    }


    //CALLBACK FUNCTIONS

    public function _callback_add_field_NIK2() {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK2" class="chosen-select" data-placeholder="Select Atasan Lebih Tinggi" style="width: 400px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        //$listingID = $this->uri->segment(5);

        if (!is_null($this->input->get('nik'))){
            $FormCutiNIK = $this->input->get('nik'); 
        }
        else {
            $FormCutiNIK = 0; 
        }    
        
        //LOAD GCRUD AND GET THE STATE
        $crud  = new grocery_CRUD();
        $state = $crud->getState();

        $session_nik = $this->cms_user_id();        
        $dta         = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK =".$FormCutiNIK));
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
                     ->order_by('iGroupApprovalListId','ASC');

            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select Atasan Lebih Tinggi</option>';

            foreach($db->result() as $row):               
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.'</option>';
                
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;
    }


    

    // change dPeriodEndDate format to d-M-Y
    public function _callback_column_TglMasuk($value, $row) {
        //return $value." - scale: <b>".$row->date."</b>";
        $Date = date('d-M-Y', strtotime($row->TglMasuk));
        return $Date;
        
    }



    


    

    // Add Type
    public function _callback_edit_field_Alasan($value, $row){
        $ListingID = $this->uri->segment(6); 
        $query     = $this->db->query('SELECT StatusForm,Alasan FROM tbl_formcuti WHERE CutiId='.$ListingID); 

       foreach ($query->result() as $rown){
        if ($rown->StatusForm =='P' OR $rown->StatusForm ==''){
            $ted = '';
        }
        else {
            $ted = '';
        }
        return "<input type='Text' maxlength='150' name='Alasan' $ted>";
        }   //return $array;

        
    }

    public function _callback_column_NlIK($value, $row){    
        return $row->FormCutiNIK;        
    }





    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select id=select onchange=goToPage("select") name="HakCutiId" class="chosen-select" data-placeholder="Select Periode Hak Cuti" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        $listID = $this->uri->segment(4);



        //$_SESSION['FormCutiNIK'] = $FormCutiNIK;
        
        $today = date('Y-m-d');
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit"){
            //GET THE STORED STATE ID
            $this->db->select('FormCutiNIK, HakCutiId')
                     ->from('tbl_formcuti')
                     ->where('CutiId', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $FormCutiNIK = $row->FormCutiNIK;
            $HakCutiId   = $row->HakCutiId;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('tbl_hakcuti')
                     ->where('JenisHakCuti', $listingID)
                     ->where('NIK', $FormCutiNIK);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                $Periode1 = date('d-M-Y', strtotime($row->Periode1));
                $Periode2 = date('d-M-Y', strtotime($row->Periode2));

                $dta = mysql_fetch_array(mysql_query('SELECT count(FormCutiNIK) AS QtyPakai FROM tbl_formcuti INNER JOIN 
                                                    tbl_formcutidetail ON tbl_formcuti.CutiId = tbl_formcutidetail.CutiId 
                                                    WHERE tbl_formcuti.FormCutiNIK="'.$FormCutiNIK.'" AND HakCutiId="'.$row->HakId.'" 
                                                    AND StatusForm="A" '));

            $jka      = mysql_fetch_array(mysql_query('SELECT * FROM tbl_jeniscuti WHERE id="'.$row->JenisHakCuti.'"'));

        
            $LimitExp = $jka['LimitExp'];
            $soon     = date('Y-m-d', strtotime($row->Periode2. ' + '.$LimitExp));
            $soon2    = date('Y-m-d', strtotime($soon));
            //$soon2     = date('d-M-Y',strtotime($soon)); //my preferred method
            //$soon2 = strtotime("+6 days", $row->Periode2);

            $Qty      = $row->Qty;
            $QtyPakai = $dta['QtyPakai'];
            $Sisa     = $Qty - $QtyPakai;
           

            if ($today > $soon || $Sisa <= 0){
                $HakId = 0;
                $ne    = 'Tidak Bisa Dipakai';
                $link  = '#';
            }
            
            else{
                $HakId = $row->HakId;
                $ne    = 'Bisa Dipakai';
                $link  = 'http://'.$server.'/hris2/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/index/'.$listID.'/add/'.$row->HakId;
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



                if($row->HakId == $HakCutiId) {
                    //$empty_select .= '<option value="'.$row->HakId.'" selected="selected" '.$sati.'>'.$Periode1.' s/d'.$Periode2.'  [sisa : '.$Sisa.' hari]</option>';
                    $empty_select .= '<option value="'.$link.'" selected="selected">'.$Periode1.' s/d'.$Periode2.'  [sisa : '.$Sisa.' hari]</option>';
                } else {
                    //$empty_select .= '<option value="'.$row->HakId.'" '.$sati.'>'.$Periode1.' s/d'.$Periode2.'   [sisa : '.$Sisa.' hari]</option>';
                    $empty_select .= '<option value="'.$link.'">'.$Periode1.' s/d'.$Periode2.'  [sisa : '.$Sisa.' hari]</option>';
                }
            endforeach;

            $js ='<script type = "text/javascript">
                    function goToPage(id) {var node = document.getElementById( id );
                    if( node && node.tagName == "SELECT") 
                        { window.location.href = node.options[node.selectedIndex].value;}
                }
              </script>';

            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }


    //GET JSON OF STATES
    public function get_states(){
        
        $listingID   = $this->uri->segment(5);
        

        if (!is_null($this->input->get('nik'))){
            $FormCutiNIK = $this->input->get('nik');

        }else{
            $FormCutiNIK = $this->uri->segment(4);
        }


        if ($_SESSION['JenisCuti']==1 OR $_SESSION['JenisCuti']==4){
            $JenisCuti = 1;
        }
        else {
            $JenisCuti = $_SESSION['JenisCuti'];
        }
       
        

        $today = date('Y-m-d');
        
        $this->db->select("*")
                 ->from('tbl_hakcuti')
                 ->where('JenisHakCuti', $JenisCuti)
                 ->where('NIK', $FormCutiNIK);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $Periode1 = date('d-M-Y', strtotime($row->Periode1));
            $Periode2 = date('d-M-Y', strtotime($row->Periode2));            

            $dta      = mysql_fetch_array(mysql_query('SELECT count(FormCutiNIK) AS QtyPakai FROM tbl_formcuti INNER JOIN 
                                                    tbl_formcutidetail ON tbl_formcuti.CutiId = tbl_formcutidetail.CutiId 
                                                    WHERE tbl_formcuti.FormCutiNIK="'.$FormCutiNIK.'" AND HakCutiId="'.$row->HakId.'" 
                                                    AND StatusForm="A"'));

           if (is_null($row->PeriodeExt) OR $row->PeriodeExt ==""){
                $soon     = date('Y-m-d', strtotime($row->Periode2));

            }
            else {
                $soon     = date('Y-m-d', strtotime($row->PeriodeExt));
            }


            //$soon     = date('Y-m-d', strtotime($row->Periode2. ' + '.$LimitExp));
            $soon2    = date('Y-m-d', strtotime($soon));
            //$soon2     = date('d-M-Y',strtotime($soon)); //my preferred method
            //$soon2 = strtotime("+6 days", $row->Periode2);

            $Qty      = $row->Qty;
            $QtyPakai = $dta['QtyPakai'];
            $Sisa     = $Qty - $QtyPakai;
           

            if ($today > $soon || $Sisa <= 0){
                $HakId = 0;
                $ne    ='Tidak Bisa Dipakai';
            }
            
            else{
                $HakId = $row->HakId;
                $ne    ='Bisa Dipakai';
            }


            $array[] = array("value" => '?nik='.$FormCutiNIK.'&hc='.$HakId ,"property" => $Periode1.' s/d '.$Periode2.'   [sisa : '.$Sisa.' hari]'.' - '.$ne);
        endforeach;
        
        echo json_encode($array);
        exit;
    }


    public function empty_city_dropdown_select(){
        $HakCutiId = $this->uri->segment(4);
        $this->load->helper('url');
       
    }


    //GET JSON OF CITIES
    public function get_cities(){
        $HakCutiId = $this->uri->segment(4);
        $this->load->helper('url');
        
    }



    


    //CALLBACK FUNCTIONS
    public function _callback_add_field_JenisCuti2()    {

    

        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select id=select onchange=goToPage("select") name="" class="chosen-select" data-placeholder="Select Periode Hak Cuti" style="width: 350px; display: none;">';
        $empty_select_closed= '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);

        //$PRD       = $this->input->get('PRD', TRUE);
        $PRD       = $this->uri->segment(6);
        $today = date('Y-m-d');
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();

        $session_nik = $this->cms_user_id();
        
        //$dta = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = $session_nik"));
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
        if(!is_null($listingID) || $listingID !="" && $state == "add") {
            $this->db->select('id,JenisCutiName')
                     ->from($this->cms_complete_table_name('jeniscuti'))
                     //->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     //->where('NIK',$session_nik)
                     ->where('id !=',0)
                     ->where('id',$listingID)
                     ->order_by('id','ASC');

            $db     = $this->db->get();
                       
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select Periode Hak Cuti</option>';

            foreach($db->result() as $row): 
          

            $server = $_SERVER['SERVER_NAME'];

                    //$empty_select .= '<option value="'.$HakId.'">'.$Periode1.' s/d '.$Periode2.'  [sisa : '.$Sisa.' hari]</option>';
                if($row->id == $listingID) {
                    $empty_select .= '<option value="http://'.$server.'/hris2/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/index/add/'.$row->id.'" selected="selected">'.$row->JenisCutiName.'</option>';
                }else{
                    $empty_select .= '<option value="http://'.$server.'/hris2/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/index/add/'.$row->id.'">'.$row->JenisCutiName.'</option>';
                }
                
            endforeach;   

            $js ='<script type = "text/javascript">
                    function goToPage(id) {var node = document.getElementById( id );
                    if( node && node.tagName == "SELECT") 
                        { window.location.href = node.options[node.selectedIndex].value;}
                }
              </script>';

            $js2 ="<input type='hidden' maxlength='50' value='" .$row->id. "' name='JenisCuti'>";
            return $empty_select.$empty_select_closed.$js.$js2;

        }


        else {

            $this->db->select('id,JenisCutiName')
                     ->from($this->cms_complete_table_name('jeniscuti'))                   
                     ->where('id !=',0)
                     //->where('id',$listingID)
                     ->order_by('id','ASC');

            $db     = $this->db->get();
          
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select Periode Hak Cuti</option>';

            foreach($db->result() as $row): 
          

            $server = $_SERVER['SERVER_NAME'];

                    //$empty_select .= '<option value="'.$HakId.'">'.$Periode1.' s/d '.$Periode2.'  [sisa : '.$Sisa.' hari]</option>';
                if($row->id == $listingID) {
                    $empty_select .= '<option value="http://'.$server.'/hris2/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/index/add/'.$row->id.'" selected="selected">'.$row->JenisCutiName.'</option>';
                }else{
                    $empty_select .= '<option value="http://'.$server.'/hris2/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/index/add/'.$row->id.'">'.$row->JenisCutiName.'</option>';
                }
                
            endforeach;

            $js ='<script type = "text/javascript">
                    function goToPage(id) {var node = document.getElementById( id );
                    if( node && node.tagName == "SELECT") 
                        { window.location.href = node.options[node.selectedIndex].value;}
                }
              </script>';

            $js2 ="<input type='hidden' maxlength='50' value='" .$row->id. "' name='JenisCuti'>";
            return $empty_select.$empty_select_closed.$js.$js2;

        }
    }


    // Add Type
    public function _callback_add_field_JenisCuti(){
      
        $stateID = $this->uri->segment(4);
        $query = $this->db->query('SELECT id, JenisCutiCode,JenisCutiName FROM tbl_jeniscuti WHERE id='.$stateID);  


       foreach ($query->result() as $row){
        return "$row->JenisCutiName<input type='hidden' maxlength='50' value='" . $row->id. "' name='JenisCuti'>";
        }   //return $array;

        
    }

    public function _callback_add_field_SendMail(){
        return '<input type="radio" name="SendMail" value="1"> Yes <input type="radio" name="SendMail" value="0" checked> No';
    }



    public function _callback_edit_field_StatusForm(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="StatusForm" class="chosen-select" data-placeholder="Select Status Form" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(6);
        
        //LOAD GCRUD AND GET THE STATE
        $crud  = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        
            //GET THE STORED STATE ID
            $this->db->select('*')
                     ->from('tbl_formcuti')
                     ->where('CutiId', $listingID);

            $db  = $this->db->get();
            $row = $db->row(0);
           
            $StatusForm = $row->StatusForm;            
          
            //GET THE CITIES PER STATE ID 

            $this->db->select('*')
                     ->from('tbl_statusform');
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            
            foreach($db->result() as $row):
                if($row->CodeStatusForm == $StatusForm) {
                    $empty_select .= '<option value="'.$row->CodeStatusForm.'" selected="selected">'.$row->NamaStatusForm.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->CodeStatusForm.'">'.$row->NamaStatusForm.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;

        
    }


    // add hyperlink
    public function _callback_column_Print($primary_key, $row){
            
            return "javascript:window.open('".site_url('includes/export/frmListCuti/Export2Html2.php') .'?id='.$row->CutiId. "', 'Export', 'width=950, height=' + screen.height + ', top=0, left=0,scrollbars=yes,resizable=yes,copyhistory=no,menubar=no,location=no,toolbar=no,directories=0,titlebar=0,status=no', false);void(0)";        
        
    }







   

    

}




