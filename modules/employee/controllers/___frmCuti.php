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
        // $crud->unset_add();
        // $crud->unset_edit();
        // $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        // $crud->unset_print();
        // $crud->unset_export();

        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_city_model');
        */
        $crud->unset_texteditor('Alamat');
        $crud->unset_texteditor('Keperluan');
        
        $dta = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = '$session_nik'"));
        // $crud->unset_add();
        //$crud->unset_edit();
        //$crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');
            //$crud->unset_add();
        }
        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->cms_complete_table_name('formcuti'));
        $crud->where('FormCutiNIK', $session_nik);

        // primary key
        $crud->set_primary_key('CutiId');

        // set subject
        $crud->set_subject('Form Cuti');
        $crud->change_field_type('NoTelpon', 'integer');
        // displayed columns on list
        $crud->columns('FormCutiNIK','Keperluan','JenisCuti','StatusForm','citizen');
        
        
        // displayed columns on edit operation
       
        $crud->edit_fields('FormCutiNIK','JenisCuti','Keperluan','Alamat','citizen');
        $crud->add_fields('FormCutiNIK','JenisCuti','Keperluan','Alamat','citizen');

        
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
        $crud->display_as('iNIK1','Atasan Langsung');
        $crud->display_as('iNIK2','Atasan Lebih Tinggi');
        $crud->display_as('iNIK3','Staff HRD');
        $crud->display_as('iNIK4','Ka.Div HRD');
        $crud->display_as('citizen','Tanggal Cuti');          
                
        
        // $crud->required_fields( $field1, $field2, $field3, ... );
        $crud->required_fields('FormCutiNIK','Keperluan','Alamat','NoTelpon');
       
        
        //$crud->unique_fields( $field1, $field2, $field3, ... );
        //$crud->unique_fields('NIK');
            

        $crud->set_relation('FormCutiNIK', $this->cms_complete_table_name('profile'), 'Nama');
        $crud->set_relation('JenisCuti', $this->cms_complete_table_name('jeniscuti'), 'JenisCutiName');
        //$crud->set_relation('CompanyId', $this->cms_complete_table_name('company'), 'cCompanyCode');
        //$crud->set_relation('DivisiID', $this->cms_complete_table_name('div'), 'cDivName');
        //$crud->set_relation('DeptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        //$crud->set_relation('UnitID', $this->cms_complete_table_name('unit'), 'NamaUnit');
        //$crud->set_relation('JenisCuti', $this->cms_complete_table_name('jeniscuti'), 'JenisCutiName');

        //$crud->set_relation('StatusDiri', $this->cms_complete_table_name('StatusDiri'), 'StatusDiriName');
        //$crud->set_relation('iNIK1', $this->cms_complete_table_name('apv_group_approval'), 'NIK',array('deptID' => $dta['DeptID']));
        //$crud->set_relation('iNIK2', $this->cms_complete_table_name('apv_group_approval'), 'NIK',array('deptID' => $dta['DeptID']));
        //$crud->set_relation('iNIK3', $this->cms_complete_table_name('apv_group_approval'), 'NIK',array('deptID' => 1));
        //$crud->set_relation('iNIK4', $this->cms_complete_table_name('apv_group_approval'), 'NIK',array('deptID' => 1));
        // /$crud->set_relation('user_id','users','username',array('status' => 'active'));
        //$crud->field_type('iNIK3','dropdown',array('4833' => 'Dompak Petrus Sinambela [dompak.sinambela@unias.com]','3333' => 'Yosia Lombu [dompak.sinambela@unias.com]'));
        
            
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));
        //$crud->callback_column('CutiId',array($this,'_callback_edit_url'));
        //$crud->callback_column('TglActive1',array($this,'_Date1_call'));
        //$crud->callback_column('TglActive2',array($this,'_Date2_call'));


        $crud->callback_add_field('FormCutiNIK', array($this, '_callback_add_field_FormCutiNIK'));
        $crud->callback_edit_field('FormCutiNIK', array($this, '_callback_add_field_FormCutiNIK'));
        $crud->callback_column('StatusForm',array($this,'_callback_column_StatusForm'));

        //$crud->callback_add_field('iNIK1', array($this, '_callback_add_field_iNIK1'));
        //$crud->callback_add_field('iNIK2', array($this, '_callback_add_field_iNIK2'));
        //$crud->callback_add_field('iNIK3', array($this, '_callback_add_field_iNIK3'));
        //$crud->callback_add_field('iNIK4', array($this, '_callback_add_field_iNIK4'));

        $crud->callback_column('citizen',array($this, '_callback_column_citizen'));
        $crud->callback_field('citizen',array($this, '_callback_field_citizen'));

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
        $real_column_names = array('DetailCutiId,CutiId,TglCuti,IsAllocate,Keterangan');
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


    // returned on insert and edit
    public function _callback_field_citizen($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('DetailCutiId,CutiId,TglCuti,IsAllocate,Keterangan')
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
        $options['IsAllocate'] = array();
        $query = $this->db->select('IsAllocate,active_name')
           ->from($this->cms_complete_table_name('active'))
           ->get();
        foreach($query->result() as $row){
            $options['IsAllocate'][] = array('value' => $row->IsAllocate, 'caption' => $row->active_name);
        }  

       

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
        $query = $this->db->select('DetailCutiId,CutiId,TglCuti,IsAllocate,Keterangan')
            ->from($this->cms_complete_table_name('formcutidetail'))
            ->where('CutiId', $row->CutiId)
            ->where('IsAllocate',1)
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




    // add hyperlink
    public function _callback_column($value, $row){    
    
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

    public function _callback_column_StatusForm($value, $row)
    {     
     //return $value;
     //$query2 = $this->db->query('SELECT * FROM tbl_main_user WHERE user_id=2');
     $query2 = $this->db->query('SELECT * FROM tbl_statusform WHERE CodeStatusForm="'.$value.'"');
                           
     foreach ($query2->result() as $rown){       
            return '<span style="background-color:'.$rown->ColourStatusForm.'"><b>'.$rown->NamaStatusForm.'</b></span>';      
       
     }     

        
    }

    //CALLBACK FUNCTIONS
    public function _callback_add_field_iNIK1()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="iNIK1" class="chosen-select" data-placeholder="Select Atasan Langsung" style="width: 500px; display: none;">';
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

    public function _callback_add_field_iNIK2()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="iNIK2" class="chosen-select" data-placeholder="Select Atasan Lebih Tinggi" style="width: 500px; display: none;">';
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

}