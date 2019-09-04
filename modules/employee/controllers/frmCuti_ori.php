<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Description of Manage_City
 *
 * @author No-CMS Module Generator
 */
class frmCuti extends CMS_Priv_Strict_Controller {

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
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();

        $crud->unset_texteditor('Alamat');
        $crud->unset_texteditor('Keperluan');
        $crud->unset_texteditor('Alasan');

        

        //$config = array('style' => 'height:24px; width: 700px;');


        $listingID = $this->uri->segment(4);        

        $dta = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$session_nik'"));

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');

            //$crud->unset_add();
        }
        else {
             $crud->set_theme('no-flexigrid_1');
            //$crud->set_relation('FormCutiNIK', $this->cms_complete_table_name('profile'), 'Nama',array('NIK >' => 0));
        }




        $list = $this->uri->segment(4);

        if ($this->uri->segment(4) !=0 && !is_null($this->uri->segment(4)) && isset($list)){
            $crud->where('JenisCuti', $this->uri->segment(4));
        }
        else {
            $crud->where('JenisCuti >=', 0);
        }
      
        if($this->uri->segment('4') =='' || $this->uri->segment('4') =='0' || $this->uri->segment('4') =='4'){
            $crud->unset_add();
            //$crud->unset_edit();
            //$crud->unset_read();

        }

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->cms_complete_table_name('formcuti'));
        $crud->where('FormCutiNIK', $session_nik);
        $crud->order_by('CutiId','DESC');

        // primary key
        $crud->set_primary_key('CutiId');
        $crud->change_field_type('NoTelpon', 'integer');


        
        //$dKBDate = date('d-M-y', $crud->columns('dBudgetDate');
        // set subject
        $jka = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id = '$listingID'"));
        $nmc = $jka['JenisCutiName'];

        $crud->set_subject('Form Cuti '.$nmc);

        $cm        = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$session_nik));
        $companyID = $cm['CompanyId'];
        $DeptID    = $cm['DeptID'];

        $crud->unset_add_fields('CreatedBy','CreatedTime','UpdatedTime','companyID');
        $crud->field_type('CreatedBy', 'hidden', $session_nik);
        $crud->field_type('CreatedTime', 'hidden', $today);
        $crud->field_type('UpdatedTime', 'hidden', $today);
        $crud->field_type('companyID', 'hidden', $companyID);

        // displayed columns on list
        //$crud->columns('FormCutiNIK','JenisCuti','StatusForm','Keperluan','ApvLevel','Detail','TglMasuk');
        $crud->columns('FormCutiNIK','NIK','JenisCuti','Keperluan','Detail','TglMasuk','ApvLevel','StatusForm','Aturan');
        // displayed columns on edit operation
        if ($state=='read'){
            $crud->edit_fields('FormCutiNIK','JenisCuti','HakCutiId','Keperluan','Alamat','NIKPengganti','NoTelpon','Detail','TglMasuk','NIK1','NIK2','NIK3');
        }
        else{
            $crud->edit_fields('StatusForm','Alasan');
        }
        // displayed columns on add operation
        if ($listingID !=3){
            $crud->add_fields('FormCutiNIK','JenisCuti','HakCutiId','Keperluan','Alamat','NoTelpon','Detail','TglMasuk','NIKPengganti','NIK1','NIK2','NIK3','CreatedBy','CreatedTime','UpdatedTime','companyID');
        }
        else {
            $crud->add_fields('FormCutiNIK','JenisCuti','HakCutiId','Keperluan','Alamat','NoTelpon','NIKPengganti','TglActive1','TglActive2','TglMasuk','NIK1','NIK2','NIK3','CreatedBy','CreatedTime','UpdatedTime','companyID');
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put Tabs (if needed)
        // usage:
        //     $crud->set_tabs(array(
        //        'First Tab Caption'  => $how_many_field_on_first_tab,
        //        'Second Tab Caption' => $how_many_field_on_second_tab,
        //     ));
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //$TglApv = date('d-M-Y', strtotime($sqli[$dKBTgl]));
        
        
       // caption of each columns      
        $crud->display_as('CutiId','ID');       
        $crud->display_as('FormCutiNIK','Nama');
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
        

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put required field validation codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/required_fields)
        // eg:
        //      $crud->required_fields( $field1, $field2, $field3, ... );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud->required_fields('FormCutiNIK','JenisCuti','StatusForm','Keperluan','Alamat','HakCutiId','TglMasuk','NIKPengganti','NoTelpon','NIK1','NIK2','NIK3','Alasan');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put required field validation codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/unique_fields)
        // eg:
        //      $crud->unique_fields( $field1, $field2, $field3, ... );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //$crud->unique_fields('NIK');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put field validation codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/set_rules)
        // eg:
        //      $crud->set_rules( $field_name , $caption, $filter );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put set relation (lookup) codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/set_relation)
        // eg:
        //      $crud->set_relation( $field_name , $related_table, $related_title_field , $where , $order_by );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //$crud->set_relation('country_id', $this->cms_complete_table_name('country'), 'name');
        //$crud->set_relation('Company', $this->cms_complete_table_name('Company'), 'company_code');
        //$crud->set_relation('Division', $this->cms_complete_table_name('Division'), 'cDivName');
        //$crud->set_relation('Departement', $this->cms_complete_table_name('dept'), 'cDeptName');
        //$crud->set_relation('Status', $this->cms_complete_table_name('status'), 'StatusName');
        //$crud->set_relation('Jobs', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');
        //$crud->set_relation('Location', $this->cms_complete_table_name('location'), 'LocationName');
        //$crud->set_relation('Penempatan', $this->cms_complete_table_name('Company'), 'company_name');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put set relation_n_n (detail many to many) codes here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/set_relation_n_n)
        // eg:
        //      $crud->set_relation_n_n( $field_name, $relation_table, $selection_table, $primary_key_alias_to_this_table,
        //          $primary_key_alias_to_selection_table , $title_field_selection_table, $priority_field_relation );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        //$crud->set_relation('FormCutiNIK', $this->cms_complete_table_name('profile'), 'Nama');
        $crud->set_relation('JenisCuti', $this->cms_complete_table_name('jeniscuti'), 'JenisCutiName',array('id !=' => 0));

        if ($state=='Add' || $state=='edit'){
            $crud->set_relation('StatusForm', $this->cms_complete_table_name('statusform'), 'NamaStatusForm',array('Id' => 4));
        }

/*
        $crud->field_type('NIK3','dropdown',array('4833' => 'Dompak Petrus Sinambela [dompak.sinambela@unias.com]',
                                                  '3333' => 'Yosia Lombu [dompak.sinambela@unias.com]')); 
*/
        
        $crud->set_primary_key('hrd_nik',$this->cms_complete_table_name('apv_hrd'));
        $crud->set_relation('NIK3', $this->cms_complete_table_name('apv_hrd'), '{hrd_name} [{hrd_email}]',array('hrd_status' =>1,'hrd_company' => $companyID, 'hrd_modules' => 'form_cuti'));
        $crud->set_relation('ApvLevel', $this->cms_complete_table_name('apv_matrik_approval'), '{MatName}',array('MatCode' => 1));


        $crud->set_relation('HakCutiId', $this->cms_complete_table_name('hakcuti'), '{Periode1} - {Periode2} [{Qty}]',array('NIK' => $session_nik,'StatusHak' => 1));

        $crud->set_relation('NIKPengganti', $this->cms_complete_table_name('profile'), '{Nama} [{Email}] - {NIK}',array('bStatus' =>1,'DeptID' => $DeptID));
/*
        $crud->set_relation('NIK1', $this->cms_complete_table_name('apv_group_approval'), 'NIK',array('deptID' => $dta['DeptID']));
        $crud->set_relation('NIK2', $this->cms_complete_table_name('apv_group_approval'), 'NIK',array('deptID' => $dta['DeptID']));
        $crud->set_relation('NIK3', $this->cms_complete_table_name('apv_group_approval'), 'NIK',array('deptID' => 1));
*/

        // /$crud->set_relation('user_id','users','username',array('status' => 'active'));

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put custom field type here
        // (documentation: http://www.grocerycrud.com/documentation/options_functions/field_type)
        // eg:
        //      $crud->field_type( $field_name , $field_type, $value  );
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put callback here
        // (documentation: httm://www.grocerycrud.com/documentation/options_functions)
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $crud->callback_column('Detail',array($this, '_callback_column_citizen'));
        $crud->callback_field('Detail',array($this, '_callback_field_citizen'));

        $crud->callback_add_field('FormCutiNIK', array($this, '_callback_add_field_FormCutiNIK'));
        $crud->callback_edit_field('FormCutiNIK', array($this, '_callback_add_field_FormCutiNIK'));
        $crud->callback_column('StatusForm',array($this,'_callback_column_StatusForm'));
        $crud->callback_add_field('JenisCuti',array($this,'_callback_add_JenisCuti'));
        //$crud->callback_column('StartingDate',array($this,'_date_format_callback'));
        //$crud->callback_column('total',array($this, '_callback_column_total'));
        //$crud->callback_before_update('total',array($this, '_callback_column_total'));

        $crud->callback_add_field('NIK1', array($this, '_callback_add_field_NIK1'));
        $crud->callback_add_field('NIK2', array($this, '_callback_add_field_NIK2'));
        //$crud->callback_add_field('NIK3', array($this, '_callback_add_field_NIK3'));
        $crud->callback_column('TglMasuk', array($this, '_callback_column_TglMasuk'));
        //$crud->callback_add_field('iNIK4', array($this, '_callback_add_field_iNIK4'));
        
        $crud->callback_add_field('HakCutiId', array($this, '_callback_add_field_HakCutiId'));
        $crud->callback_edit_field('Alasan', array($this, '_callback_edit_field_Alasan'));
        //$crud->callback_edit_field('StatusForm', array($this, '_callback_edit_field_StatusForm'));
        $crud->callback_column('NIK',array($this,'_callback_column_NIK'));
        $crud->callback_column('Aturan',array($this,'_callback_column_Aturan'));
        //$crud->callback_column('Void',array($this, '_callback_column_Void'));
        //$crud->add_action('Void', '', 'demo/action_more','ui-icon-plus');
        //$crud->add_action('Void', '', '','ui-icon-image',array($this,'just_a_test'));
        //$crud->add_action('Void','', '', 'demo/action_more', 'demo/action_smiley');
        //$crud->add_action('Void', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', 'demo/action_smiley');
        //$crud->callback_field('budget_detail',array($this, '_callback_field_budget_detail'));

        $crud->add_action('Print', 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/images/print1.png', ' ',' http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/images/print1.png',array($this,'_callback_column_Print'));


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // HINT: Put custom error message here
        // (documentation: httm://www.grocerycrud.com/documentation/set_lang_string)
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // $crud->set_lang_string('delete_error_message', 'Cannot delete the record');
        // $crud->set_lang_string('update_error',         'Cannot edit the record'  );
        // $crud->set_lang_string('insert_error',         'Cannot add the record'   );

        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/frmCuti_view', $output,
            $this->cms_complete_navigation_name('frmCuti'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('frmCuti'),array('CutiId'=>$id));
                    $this->_after_delete($id);
                }
            }
        }
    }

    // change dPeriodEndDate format to d-M-Y
    public function _date_format_callback($value, $row)
    {
        //return $value." - scale: <b>".$row->date."</b>";
        $date_value = date('d-M-Y', strtotime($row->StartingDate));
        return $date_value;
        
    }

    public function _before_insert($post_array){
        $post_array = $this->_before_insert_or_update($post_array);
        
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
        
        
    }

    
    public function _after_insert($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);

        $error = $this->_before_insert_or_update($post_array);
        
        
        // HINT : Put your code here

        //$info = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId=".$primary_key);

        /*
        $query = $this->db->select('DetailCutiId, CutiId, Keterangan, TglCuti, active_id')
            ->from($this->cms_complete_table_name('formcutidetail'))
            ->where('CutiId', $primary_key)
            ->get();
        */
        
        //$ID       = $primary_key;
        //$segment4    = $this->uri->segment(4);
        $session_nik = $this->cms_user_id();
        $TglMasukku    = $post_array['TglMasuk'];

        //$date     = strtotime($post_array['TglMasuk']); 
        //$TglMasuk = date('Y-m-d', $date);

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

       

        if($num_row > 0 || $total >0){
            mysql_query("DELETE FROM tbl_formcuti WHERE CutiId =".$primary_key);
            mysql_query("DELETE FROM tbl_formcutidetail WHERE CutiId=".$primary_key);
            

            echo "<script language='javascript'>alert('Error!!! Tgl Cuti Dan Tgl Masuk tidak sesuai, silahkan isi kembali...$num_row , $total');history.go(-1);</script>";
        
            return $error;
        }
        else{

            include "http://".$_SERVER['SERVER_NAME']."/hris2/includes/mailer/frmCuti/SendMail.php?id=".$primary_key."&mynik=".$session_nik."&proses=1";
            echo "<script language='javascript'>alert('Data Sudah Disimpan dan Email sudah dikirim...$num_row , $total');</script>";  

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

        //$dt       = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formperpcuti WHERE NIK=".$session_nik." AND FormPerpCutiId=".$ListingID));
        //$ID       = $ListingID;
        $ID       = $primary_key;

        include "http://".$_SERVER['SERVER_NAME']."/hris2/includes/mailer/frmCuti/SendMailVoid.php?id=$ID";
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
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' Hari';
        }else if($num_row>0){
            return $num_row .' Hari';
        }else{
            return 'No Data';
        }
    }

    public function _callback_column_NIKXX($value, $row){    
        return $row->FormCutiNIK;        
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
                     ->where('hrd_modules', 'form_cuti')
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

            $server = $_SERVER['SERVER_NAME'];

                    //$empty_select .= '<option value="'.$HakId.'">'.$Periode1.' s/d '.$Periode2.'  [sisa : '.$Sisa.' hari]</option>';
                if($row->HakId == $PRD) {
                    $empty_select .= '<option value="http://'.$server.'/hris2/kehadiran/frmCuti/index/'.$listingID.'/add/'.$row->HakId.'" selected="selected"'.$sati.' '.$text.'>'.$row->HakId.'. '.$Periode1.' s/d '.$Periode2.'  [sisa : '.$Sisa.' hari]</option>';
                }else{
                    $empty_select .= '<option value="http://'.$server.'/hris2/kehadiran/frmCuti/index/'.$listingID.'/add/'.$row->HakId.'" '.$sati.' '.$text.'>'.$row->HakId.'. '.$Periode1.' s/d '.$Periode2.'  [sisa : '.$Sisa.' hari]</option>';
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
        if ($rown->StatusForm =='P' OR $rown->StatusForm ==''){
            $ted = '';
        }
        else {
            $ted = 'disabled';
        }
        return "<input type='Text' maxlength='150' name='Alasan' value='".$rown->Alasan.''.$rown->AlasanApv."' $ted>";
        }   //return $array;

        
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
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;

        
    }

    // add hyperlink
    public function _callback_column_Print($primary_key, $row){

       

            //return "javascript:window.open('".site_url('includes/export/frmListCuti/Export2Html2.php') .'?id='.$row->CutiId. "','_blank')";

            //return "javascript:openBlank('".site_url('includes/export/frmListCuti/Export2Html2.php') . '?id=' . $row->CutiId . "','_blank')";

            //return 'window.open ("http://jsc.simfatic-solutions.com","mywindow","menubar=1,resizable=1,width=350,height=250");'; 

            //return "<a href='javascript: void(0)' onclick=window.open('popup.html','windowname1','width=200, height=77');return false;></a>";

            //return "javascript:window.open('".site_url('includes/export/frmListCuti/Export2Html2.php') .'?id='.$row->CutiId. "', 'Export', 'width=500, height=750, top=0, left=0,scrollbars=yes,resizable=yes', false);void(0)";        
            
            return "javascript:window.open('".site_url('includes/export/frmCuti/Export2Html2.php') .'?id='.$row->CutiId.'&nik='.$_SESSION['NIK']. "', 'Export', 'width=950, height=' + screen.height + ', top=0, left=0,scrollbars=yes,resizable=yes,copyhistory=no,menubar=no,location=no,toolbar=no,directories=0,titlebar=0,status=no', false);void(0)";        
        
    }

    

}