<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class frmTrainingCertificate extends CMS_Priv_Strict_Controller {

    protected $URL_MAP = array();

    public function cms_complete_table_name($table_name){
        $this->load->helper($this->cms_module_path().'/function');
        if(function_exists('cms_complete_table_name')){
            return cms_complete_table_name($table_name);
        }else{
            return parent::cms_complete_table_name($table_name);
        }
    }

    public function get_company(){

        $crud       = new grocery_CRUD();
        $state      = $crud->getState();
        $listingID  = $this->uri->segment(5);
        $companyID  = $this->input->post('get_company');     

        if(isset($listingID) && $state == "edit"){
            $this->db->select('*')
                     ->from('tbl_fpts')
                     ->where('FPTSID', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $get_company = $row->CompanyID;
        }
        else{
            if(isset($companyID)){
                $get_company = $companyID;
            }
            else{
                $get_company = 1;
            }
        }

        return $get_company;
    }

    public function set_db_company($value){
        return 'db1'.$value;
    }    

    private function make_crud(){
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // initialize groceryCRUD
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $crud = $this->new_crud();
        $today     = date('Y-m-d H:i:s');
        // this is just for code completion
        if (FALSE) $crud = new Extended_Grocery_CRUD();

        $crud->set_theme('flexigrid-fpts');

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
        $crud->set_model($this->cms_module_path().'/grocerycrud_city_model');
        */

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

       


        // table name
        
        $crud->set_table($this->cms_complete_table_name('fpts'));

        // primary key
        $crud->set_primary_key('FPTSID');

        // set subject
        $crud->set_subject('Form PTS');

        // displayed columns on list
        $crud->columns('FPTSNo','TrDate','CompanyID','DivisionID','DepartmentID','Participant');
        // displayed columns on edit operation
        $crud->edit_fields('FPTSNo','TrDate','CompanyID','DivisionID','DepartmentID','TypeID','ModulName','OrganizerID','DestRadio','DestinationID','Address','Date1','Date2','ReasoningID','BudgetID','ChargeID','ProjectID','CurrencyID','Amount','TotalAmount','PaymentID','AccountBankID','AccountID','AccountName','TermsID');
        // displayed columns on add operation
        $crud->add_fields('FPTSNo','TrDate','CompanyID','DivisionID','DepartmentID','TypeID','ModulName','OrganizerID','DestRadio','DestinationID','Address','Date1','Date2','ReasoningID','BudgetID','ChargeID','ProjectID','CurrencyID','Amount','TotalAmount','PaymentID','AccountBankID','AccountID','AccountName','TermsID');

        //$crud->unset_add_fields('FPTSNo','TrDate','CompanyID','DivisionID','DepartmentID','DestRadio','DestinationID');

        
        $crud->field_type('CreatedTime','hidden',$today);
        $crud->field_type('CreatedBy','hidden',$this->cms_user_id());
        $crud->field_type('UpdatedBy','hidden',$this->cms_user_id());
    
        
        // caption of each columns
        $crud->display_as('FPTSNo','No Form');
        $crud->display_as('TrDate','Date');        
        $crud->display_as('CompanyID','Company');
        $crud->display_as('DivisionID','Division');
        $crud->display_as('DepartmentID','Department');
        $crud->display_as('Participant','Participant');
        $crud->display_as('ModulName','Modul Name');
        $crud->display_as('OrganizerID','Penyelenggara');
        $crud->display_as('DestRadio','Pelaksanaan di');
        $crud->display_as('DestinationID','Destination');
        $crud->display_as('Address','Address');
        $crud->display_as('Date1','Jadwal');
        $crud->display_as('Date2','Jadwal');
        $crud->display_as('ReasoningID','Pertimbangan Atas Pengajuan');
        $crud->display_as('BudgetID','Budget');
        $crud->display_as('ChargeID','Beban');
        $crud->display_as('ProjectID','Project ID');
        $crud->display_as('CurrencyID','Currency ID');
        $crud->display_as('TotalAmount','Total Amount');
        $crud->display_as('PaymentID','Payment ID');
        $crud->display_as('AccountBankID','Bank ID');
        $crud->display_as('AccountID','Nomor Rekening');
        $crud->display_as('AccountName','Atas Nama');
        $crud->display_as('TermsID','Terms & Conditions');

   
        $crud->required_fields('FPTSNo','TrDate','CompanyID','DivisionID','DepartmentID','TypeID','ModulName','OrganizerID','DestRadio','DestinationID','Address','Date1','Date2','ReasoningID','BudgetID','ChargeID','ProjectID','CurrencyID','Amount','TotalAmount','TermsID');

        
        $crud->unique_fields('FPTSNo');


        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $crud->callback_column('Participant',array($this, '_callback_column_participant'));
        $crud->callback_field('Participant',array($this, '_callback_participant_detail'));


        $crud->callback_add_field('DivisionID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_edit_field('DivisionID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_add_field('DepartmentID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_edit_field('DepartmentID', array($this, 'empty_city_dropdown_select'));

        $this->crud = $crud;
        return $crud;
    }   


    public function _example_output($output = null){

        $crud = $this->make_crud();
        $state = $crud->getState();
        $listingID = $this->uri->segment(5);

        $data = array(
            'session_nik' => $this->cms_user_id(),
            'module_path' => $this->cms_module_path(),
            'state' => $state,
            'FPTSNo' => $this->empty_FPTSNo_dropdown_select($value =NULL, $primary_key=$listingID),
            'CompanyID' => $this->empty_company_dropdown_select($value =NULL, $primary_key=$listingID),
            'DivisionID' => $this->empty_state_dropdown_select($value =NULL, $primary_key=$listingID),
            'DepartmentID' => $this->empty_city_dropdown_select($value =NULL, $primary_key=$listingID),
            'ProductID' => $this->empty_product_dropdown_select($value =NULL, $primary_key=$listingID),
            'DestinationID' => $this->_callback_field_DestinationID($value = NULL, $primary_key = $listingID),
            'field_detail_fpts' => $this->_callback_participant_detail($value=NULL,$primary_key=$listingID),
            'ReasoningID' => $this->_callback_field_ReasoningID($value = NULL, $primary_key = $listingID),
            'CurrencyID' => $this->_callback_field_CurrencyID($value = NULL, $primary_key = $listingID),
            'KategoriID' => $this->_callback_field_KategoriID($value = NULL, $primary_key = $listingID),
            //'BankMandiri' => table_to_query(),
        );

        $output   = array_merge((array)$output, $data);

        $this->view($this->cms_module_path().'/frmTrainingCertificate_view', $output,
        $this->cms_complete_navigation_name('frmTrainingCertificate'));    
    }


    public function index(){
                  
        $crud = $this->make_crud();

        $dd_data5 = array(
            'dd_state5' =>  $crud->getState(),                
            'dd_dropdowns5' => array('DivisionID','DepartmentID'),
            'dd_url5' => array('',site_url().'/'.$this->cms_module_path().'/'.$this->uri->segment('2').'/get_cities/'),
            'dd_ajax_loader5' => base_url().'ajax-loader.gif'
        );
       
        $output = $crud->render();
        $output->dropdown_setup5 = $dd_data5;         
        $this->_example_output($output);

    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('fpts'),array('FPTSID'=>$id));
                    $this->_after_delete($id);
                }
            }
        }
    }


    public function _before_insert($post_array){
        $post_array = $this->_before_insert_or_update($post_array);
        // HINT : Put your code here

        echo '<script language="javascript">alert("Data: '.$post_array['TermsID'].'");</script>';
        return FALSE;

        //return $post_array;
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
        $this->db->delete($this->cms_complete_table_name('fpts_detail'),
              array('FPTSID'=>$primary_key));
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
        $data = json_decode($this->input->post('md_real_field_fpts_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('FPTSDtlID', 'ParticipantID', 'JabatanID', 'ServiceQty');
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
            
            $this->db->delete($this->cms_complete_table_name('fpts_detail'),
                 array('FPTSDtlID'=>$detail_primary_key));
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
            $data['FPTSID'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('fpts_detail'),
                 $data, array('FPTSDtlID'=>$detail_primary_key));
            
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
            $data['FPTSID'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('fpts_detail'), $data);
            $detail_primary_key = $this->db->insert_id();
            
        }

        return TRUE;
    }

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }

    // returned on insert and edit
    public function _callback_participant_detail($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        


        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('fpts_detail'))
            ->where('FPTSID', $primary_key)
            ->get();
        $result = $query->result_array();
        // add "hobby" to $result

        $sqlin = $this->db->select('NIK,Nama,tbl_profile.JabatanID AS JabatanID,NamaJabatan')
                              ->from('tbl_profile')
                              ->join('tbl_jabatan','tbl_jabatan.JabatanId=tbl_profile.JabatanID')
                              ->where('CompanyId', $this->get_company())
                              ->where('bStatus', 1)
                              ->order_by('NIK','ASC')
                              ->get();
        $profile_sql = $sqlin->num_rows();       
        $profile_data = $sqlin->result_array();
        

        // get options
        $options = array();
        $options['ParticipantID'] = array();
        $query = $this->db->select('*')
           ->from($this->cms_complete_table_name('profile'))
           ->where('bStatus', 1)
           ->where('CompanyId', $this->get_company())
           ->order_by('Nama', 'ASC')
           ->get();
        foreach($query->result() as $row){
            $options['ParticipantID'][] = array('value' => $row->NIK, 'caption' => $row->Nama.' ('.$row->NIK.')');
        }
        
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'profile_data' => $profile_data,
        );
        return $this->load->view($this->cms_module_path().'/field_detail_fpts',$data, TRUE);
    }

    // returned on view
    public function _callback_column_participant($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('fpts_detail'))
            ->where('FPTSID', $row->FPTSID)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' Participant';
        }else if($num_row>0){
            return $num_row .' Participant';
        }else{
            return 'No Participant';
        }
    }

    public function convert_month_to_text($month){
        $m =$month;

        if ($m == 1){$txt = 'I';}
        elseif ($m == 2){$txt = 'II';}
        elseif ($m==3){$txt = 'III';}
        elseif ($m==4){$txt = 'IV';}
        elseif ($m==5){$txt = 'V';}
        elseif ($m==6){$txt = 'VI';}
        elseif ($m==7){$txt = 'VII';}
        elseif ($m==8){$txt = 'VIII';}
        elseif ($m==9){$txt = 'IX';}
        elseif ($m==10){$txt = 'X';}
        elseif ($m==11){$txt = 'XI';}
        elseif ($m==12){$txt = 'XII';}
        else {$txt = '';}

        return $txt;
    }


    public function empty_FPTSNo_dropdown_select($value, $primary_key){

        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();

        $listingID = $this->uri->segment(5);
        
        if(isset($listingID) && $state == "edit"){

            $this->db->select('*')
                 ->from('tbl_fpts')
                 ->where('FPTSID', $primary_key);
            $db = $this->db->get();
            $row = $db->row(0);
            $num_row = $db->num_rows();
            $new_kasbon_number = $row->FPTSNo;
        }

        else{

            $year      = date('Y');
            $month     = date('m');
            $bulan     = date('m');
            $month     = $this->convert_month_to_text($month);
            $company_id= $this->get_company();

            $this->db->select('*')
                      ->from('tbl_company')
                      ->where('iCompanyId', $company_id);
            $db = $this->db->get();
            $row = $db->row(0);
            $cFPICodeForm = $row->cFPICodeForm;    


            $this->db->select("MAX(FPTSNo) AS last_number")
                     ->from('tbl_fpts')
                     ->where('CompanyID', $company_id)
                     ->where('MONTH(CreatedTime)', $bulan)
                     ->where('YEAR(CreatedTime)', $year)
                     ;
            $db = $this->db->get();
            $row = $db->row(0);
            $num_row = $db->num_rows();


            $KasbonID = $row->last_number;
            $num2str = substr($KasbonID,0,3);
            $num2str = intval($num2str);

            if ($num_row == 0){            
                $num = '000';
                $new = ($num+1); 
            }
            elseif ($num2str < 9){               
                $num = substr($KasbonID,0,3);
                $num = intval($num);
                $new='00'.($num + 1);
            }
            elseif ($num2str < 99 && $num2str >= 9){
                $num = substr($KasbonID,0,3);
                $num = intval($num);
                $new='0'.($num + 1);
            }            
            else {               
                $num = substr($KasbonID,0,3);
                $num = intval($num);
                $new=$num + 1;
            }

            $new_kasbon_number = $new.'/PTS/'.$cFPICodeForm.'/'.$month.'/'.$year;
        }

        return $new_kasbon_number;

    }

    public function dropdown_select_company(){

        $empty_select = '<select name="get_company" id="get_company" data-live-search="true" class="selectpicker form-control" data-container="body" data-width="100%" style="width:100%" onchange="select_connection(this.value);">';  
        $empty_select .= '<option value="0" selected="selected">Select Company</option>';
        $empty_select_closed = '</select>';
        
        $form_dept_id = $this->cms_user_form_dept_id();      
           
          
        $this->db->select('*')
                  ->from('tbl_company')
                  ->join('tbl_dept', 'tbl_company.iCompanyId = tbl_dept.companyID')
                  ->where('FIND_IN_SET (iDeptID,"'.$form_dept_id.'")')
                  ->group_by('iCompanyId');
            
        $db = $this->db->get();            
           
           
        foreach($db->result() as $row):
                
            $empty_select .= '<option value="'.$row->iCompanyId.'">'.$row->cCompanyName.'</option>';
                
        endforeach;
            
        return $empty_select.$empty_select_closed;
        
    }


    public function empty_company_dropdown_select($value, $primary_key){

        $empty_select = '<select name="CompanyID" id="CompanyID" data-live-search="false" class="selectpicker form-control full-width" data-container="body" data-width="100%" style="width:100%">';

        $empty_select_closed = '</select>';         
        
            
        $this->db->select('*')
                  ->from('tbl_company')
                  ->where('iCompanyId', $this->get_company());
        $db = $this->db->get();            
            
        foreach($db->result() as $row):
           
            $empty_select .= '<option value="'.$row->iCompanyId.'" selected="selected">'.$row->cCompanyName.'</option>';
                
        endforeach;            
            
        return $empty_select.$empty_select_closed;
       
    }


    public function empty_state_dropdown_select($value, $primary_key){

        $empty_select = '<select name="DivisionID" id="DivisionID" class="selectpicker form-control" style="width:100%">';
        $empty_select .= '<option value="0" selected="selected" disabled>Select Division</option>';
        $empty_select_closed = '</select>';
        
        $listingID = $this->uri->segment(5);
        $form_dept_id = $this->cms_user_form_dept_id();

        $action     = $this->input->get('action');
        $level      = $this->input->get('level');
        $token      = $this->input->get('token');
        $token_id   = 'Pin'.$level;
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();

        if (!isset($token)){
            $where = 'FIND_IN_SET (iDeptID,"'.$form_dept_id.'")';
        }
        else{
            $where = 'iDeptID > 0';
        }
        
        if(isset($listingID) && $state == "edit") {
           
            $this->db->select('*')
                     ->from('tbl_catrhdr')
                     ->where('CATRID', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $CompanyID = $row->CompanyID;
            $DivisionID = $row->DivisionID;           
           
            
            $this->db->select('*')
                     ->from('tbl_div')
                     ->join('tbl_dept','tbl_dept.iDeptDivID = tbl_div.iDivId')
                     ->where('iDivCompany', $CompanyID)
                     ->where($where)
                     ->group_by('iDivId');
            $db = $this->db->get();
            
        
            foreach($db->result() as $row):
                if($row->iDivId == $DivisionID) {
                    $empty_select .= '<option value="'.$row->iDivId.'" selected="selected">'.$row->cDivName.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->iDivId.'">'.$row->cDivName.'</option>';
                }
            endforeach;
            
    
            return $empty_select.$empty_select_closed;
        } else {
            
            $this->db->select('*')
                     ->from('tbl_div')
                     ->join('tbl_dept','tbl_dept.iDeptDivID = tbl_div.iDivId')
                     ->where('iDivCompany', 1)
                     ->where($where)
                     ->group_by('iDivId');
            $db = $this->db->get();           
            
            foreach($db->result() as $row):
              
                $empty_select .= '<option value="'.$row->iDivId.'">'.$row->cDivName.'</option>';
                
            endforeach;

            return $empty_select.$empty_select_closed;  
        }
    }


    public function empty_city_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="DepartmentID" id="DepartmentID" class="selectpicker form-control" data-placeholder="Select Departement" style="width: 100%;">';
        //$empty_select .= '<option value="0" selected="selected" disabled>Select Departement</option>';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        $form_dept_id = $this->cms_user_form_dept_id();

        $action     = $this->input->get('action');
        $level      = $this->input->get('level');
        $token      = $this->input->get('token');
        $token_id   = 'Pin'.$level;
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit"){
            //GET THE STORED STATE ID
            $this->db->select('*')
                     ->from('tbl_fpts')
                     ->where('FPTSID', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $DepartmentID = $row->DepartmentID;
            $DivisionID = $row->DivisionID;
            

            if (!isset($token)){
                $where = 'FIND_IN_SET (iDeptID,"'.$form_dept_id.'")';
            }
            else{
                $where = 'iDeptID >= 0';
            }            
          
            $this->db->select('*')
                     ->from('tbl_dept')
                     ->where('iDeptDivID', $DivisionID)
                     ->where($where);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iDeptID == $DepartmentID) {
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

    
    //GET JSON OF CITIES
    public function get_cities(){
        $DivisiID = $this->uri->segment(4);
        $form_dept_id = $this->cms_user_form_dept_id();

        $action     = $this->input->get('action');
        $level      = $this->input->get('level');
        $token      = $this->input->get('token');
        $token_id   = 'Pin'.$level;

        if (!isset($token)){
            $where = 'FIND_IN_SET (iDeptID,"'.$form_dept_id.'")';
        }
        else{
            $where = 'iDeptID >= 0';
        }        
       
        $this->db->select('*')
                 ->from('tbl_dept')
                 ->where('iDeptDivID', $DivisiID)
                 ->where($where);

        $db = $this->db->get();
      
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iDeptID, "property" => $row->cDeptName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }

    public function empty_product_dropdown_select($value, $primary_key){

        $empty_select = '<select data-live-search="true" class="selectpicker form-control" data-show-subtext="true" data-container="body" data-width="100%" name="ProductID" id="ProductID" style="width:100%;">';
        $empty_select .= '<option value="0" selected="selected" disabled>Select Product</option>';
        $empty_select_closed = '</select>';

        $listingID = $this->uri->segment(5);       
              
        $crud = new grocery_CRUD();
        $state = $crud->getState();

     
        if(isset($listingID) && $state == "edit"){  

            $this->db->select('*')
                     ->from('tbl_catrhdr')
                     ->where('CATRID', $primary_key);
            $db = $this->db->get();
            $row = $db->row(0);
            $EmployeeID = $row->EmployeeID;       
            
          

                $this->db->select('*')
                         ->from('tbl_profile')
                         ->where('bStatus',1)
                         ->where('DivisiID', $data->iDivId)
                         ->order_by('Nama','ASC');
                        
                $db = $this->db->get();
                
                

                foreach($db->result() as $row):
                    if($row->NIK == $EmployeeID) {
                        $empty_select .= '<option value="'.$row->NIK.'" data-subtext="'.$row->NIK.' ['.$row->Email.']" selected="selected">'.$row->Nama.'</option>';
                    } else {
                        $empty_select .= '<option value="'.$row->NIK.'" data-subtext="'.$row->NIK.' ['.$row->Email.']">'.$row->Nama.'</option>';
                    }
                endforeach;

            
            
            return $empty_select.$empty_select_closed;

        } else {          
                

                $this->db->select('*')
                         ->from('tbl_fpts_product')
                         ->where('bStatus',1)
                         ->order_by('ProductID','ASC');
                        
                $db = $this->db->get();
                
                foreach($db->result() as $row):                
                        $empty_select .= '<option value="'.$row->ProductID.'">'.$row->ProductName.'</option>';
                    
                endforeach;               

           
            
            return $empty_select.$empty_select_closed;  
        }
    


    }

    public function _callback_field_DestinationID($value, $primary_key){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select data-live-search="true" class="selectpicker form-control selectwidthauto" data-show-subtext="true" data-container="body" data-width="100%" name="DestinationID" id="DestinationID" data-header="Select Destination">';
        //$empty_select = '<select name="DestinationID" id="DestinationID" class="chzn-select form-control" data-placeholder="Select Project ID" style="width: 100% !important;" disabled>';

        $empty_select .= '<option value="0" selected="selected" disabled>Select Destination</option>';
        $empty_select_closed = '</select>';

        $listingID = $this->uri->segment(5);       
              
        $crud = new grocery_CRUD();
        $state = $crud->getState();


        $this->db->select('*')
                  ->from('tbl_mst_propinsi')
                  ->order_by('KDPROP','ASC');
        $db_provence = $this->db->get();

       
        if(isset($listingID) && $state == "edit"){

            $this->db->select('*')
                     ->from('tbl_catrhdr')
                     ->where('CATRID', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $DestinationID = $row->DestinationID;

            foreach($db_provence->result() as $data):

                $empty_select .= '<optgroup label="'.$data->NMPROP.'">';            
    
                $this->db->select('*')
                         ->from('tbl_mst_dati2')
                         ->join('tbl_mst_propinsi','tbl_mst_propinsi.KDPROP=tbl_mst_dati2.KDPROP')
                         ->where('tbl_mst_dati2.KDPROP', $data->KDPROP)
                         ->order_by('tbl_mst_propinsi.KDPROP','ASC');
                        
                $db = $this->db->get();            

                foreach($db->result() as $row):
                    if($row->KDDATI2 == $DestinationID) {
                        $empty_select .= '<option value="'.$row->KDDATI2.'" data-subtext="('.ucwords(strtolower($row->NMPROP)).')" selected="selected">'.$row->NMDATI2.'</option>';
                    } else {
                        $empty_select .= '<option value="'.$row->KDDATI2.'" data-subtext="('.ucwords(strtolower($row->NMPROP)).')">'.$row->NMDATI2.'</option>';
                    }
                endforeach;

                $empty_select .= '</optgroup>';

                endforeach;                      
            
            return $empty_select.$empty_select_closed;

        } else {

            foreach($db_provence->result() as $data):

                $empty_select .= '<optgroup label="'.$data->NMPROP.'">';                       

                $this->db->select('*')
                         ->from('tbl_mst_dati2')
                         ->join('tbl_mst_propinsi','tbl_mst_propinsi.KDPROP=tbl_mst_dati2.KDPROP')
                         ->where('tbl_mst_dati2.KDPROP', $data->KDPROP)
                         ->order_by('tbl_mst_propinsi.KDPROP','ASC');
                        
                $db = $this->db->get();
                
                foreach($db->result() as $row):                
                        $empty_select .= '<option value="'.$row->KDDATI2.'" data-subtext="('.ucwords(strtolower($row->NMPROP)).')">'.$row->NMDATI2.'</option>';
                    
                endforeach;
                $empty_select .= '</optgroup>';

            endforeach;          
            
            return $empty_select.$empty_select_closed;  
        }
    }


    public function _callback_field_ReasoningID($value, $primary_key){


        $funkyradio = '';
       
        if(isset($listingID) && $state == "edit"){

            $this->db->select('*')
                     ->from('tbl_fpts')
                     ->where('FPTSID', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $ReasoningID = $row->ReasoningID;                      
    
                $this->db->select('*')
                         ->from('tbl_fpts_pertimbangan')
                         ->where('PertimbanganStatus', 1)
                         ->order_by('priority','ASC');
                        
                $db = $this->db->get();
                
                foreach($db->result() as $data):                
                        
                    $funkyradio .= '<tr>';
                    $funkyradio .= '<td>';
                    $funkyradio .= '<div class="funkyradio-success">';
                    $funkyradio .= '<input type="checkbox" name="ReasoningID" id="ReasoningID_'.$data->PertimbanganID.'" value="'.$data->PertimbanganID.'" />';
                    $funkyradio .= '<label for="ReasoningID_'.$data->PertimbanganID.'">'.$data->PertimbanganName.'</label>';
                    $funkyradio .= '</div>';
                    $funkyradio .= '</td>';

                    if ($data->PertimbanganID == 0){
                        $funkyradio .= '<td width="60%"><input type="text" name="Other" id="Other" value="'.$row->Other.'" title="Other" class="form-control" placeholder="Other" readonly/></td>';
                    }
                    else{
                        $funkyradio .= '<td>&nbsp;</td>';
                    }
                    
                    $funkyradio .= '</tr>';
                    
                endforeach;                                   
            
            return $empty_select.$empty_select_closed;

        } else {                   

                $this->db->select('*')
                         ->from('tbl_fpts_pertimbangan')
                         ->where('PertimbanganStatus', 1)
                         ->order_by('priority','ASC');
                        
                $db = $this->db->get();
                
                foreach($db->result() as $data):                
                        
                    $funkyradio .= '<tr>';
                    $funkyradio .= '<td>';
                    $funkyradio .= '<div class="funkyradio-success">';
                    $funkyradio .= '<input type="checkbox" name="ReasoningID" id="ReasoningID_'.$data->PertimbanganID.'" value="'.$data->PertimbanganID.'" />';
                    $funkyradio .= '<label for="ReasoningID_'.$data->PertimbanganID.'">'.$data->PertimbanganName.'</label>';
                    $funkyradio .= '</div>';
                    $funkyradio .= '</td>';

                    if ($data->PertimbanganID == 0){
                        $funkyradio .= '<td width="60%"><input type="text" name="Other" id="Other" value="" title="Other" class="form-control" placeholder="Other" readonly/></td>';
                    }
                    else{
                        $funkyradio .= '<td>&nbsp;</td>';
                    }
                    
                    $funkyradio .= '</tr>';
                    
                endforeach;

           
            return $funkyradio;  
        }
    }

    public function cms_user_form_dept_id(){

        $this->db->select('*')
                 ->from('tbl_form_group_dept')
                 ->where('form_group_nik',$this->cms_user_id());
        $db = $this->db->get();
        $data = $db->row(0);
        $num_row = $db->num_rows();

        if ($num_row > 0 && !empty($data->form_group_fpi_ga) && !is_null($data->form_group_fpi_ga) && $data->form_group_fpi_ga !=''){
            return $data->form_group_fpi_ga;
        }
        else{
            return 0;
        }               
    
    }

    public function _callback_field_CurrencyID($value, $primary_key){
    
        $empty_select = '<select name="CurrencyID" id="CurrencyID" data-show-subtext="true" class="selectpicker form-control" data-container="body" data-width="100%" data-header="Select Currency" style="width:100%" onchange="select_currency()">';

        //$empty_select .= '<option value="0" selected="selected" disabled>Select Currency</option>';
        $empty_select_closed = '</select>';
        
        $listingID = $this->uri->segment(5);        
        
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        $action     = $this->input->get('action');
        $level      = $this->input->get('level');
        $token      = $this->input->get('token');
        $token_id   = 'Pin'.$level;    

        
        if(isset($listingID) && $state == "edit") {

            $this->db->select('*')
                     ->from('tbl_fpts')
                     ->where('FPTSID', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $CurrencyID = $row->CurrencyID;

           
            $this->db->select('*')
                       ->from('tbl_currency')
                       ->order_by('priority', 'ASC');                        
            $db2 = $this->db->get();              
           
            foreach($db2->result() as $row):
                if($row->currency_code == $CurrencyID) {
                    $empty_select .= '<option value="'.$row->currency_code.'" data-subtext="'.$row->currency_name.'" selected="selected">'.$row->currency_code.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->currency_code.'" data-subtext="'.$row->currency_name.'">'.$row->currency_code.'</option>';
                }
            endforeach;           
                       
            
            return $empty_select.$empty_select_closed;
        } 
        elseif($state == "add") {

            $this->db->select('*')
                       ->from('tbl_currency')
                       ->order_by('priority', 'ASC');                        
            $db2 = $this->db->get();

            foreach($db2->result() as $row):
                
                $empty_select .= '<option value="'.$row->currency_code.'" data-subtext="'.$row->currency_name.'">'.$row->currency_code.'</option>';
                
            endforeach;

            return $empty_select.$empty_select_closed;        
              
        }

    }

    public function _callback_field_KategoriID($value, $primary_key){
    
        $empty_select = '<select name="KategoriID" id="KategoriID" data-show-subtext="true" class="selectpicker form-control" data-container="body" data-width="100%" data-header="Select Category" style="width:100%">';

        //$empty_select .= '<option value="0" selected="selected" disabled>Select Currency</option>';
        $empty_select_closed = '</select>';
        
        $listingID = $this->uri->segment(5);        
        
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        $action     = $this->input->get('action');
        $level      = $this->input->get('level');
        $token      = $this->input->get('token');
        $token_id   = 'Pin'.$level;    

        
        if(isset($listingID) && $state == "edit") {

            $this->db->select('*')
                     ->from('tbl_fpts')
                     ->where('FPTSID', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $KategoriID = $row->KategoriID;
           
            $this->db->select('*')
                       ->from('tbl_fpts_kategori')
                       ->order_by('KategoriID','ASC');                        
            $db2 = $this->db->get();              
           
            foreach($db2->result() as $row):
                if($row->KategoriID == $KategoriID) {
                    $empty_select .= '<option value="'.$row->KategoriID.'" selected="selected">'.$row->Description.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->KategoriID.'">'.$row->Description.'</option>';
                }
            endforeach;           
                       
            
            return $empty_select.$empty_select_closed;
        } 
        elseif($state == "add") {

            $this->db->select('*')
                       ->from('tbl_fpts_kategori')
                       ->order_by('KategoriID', 'ASC');                        
            $db2 = $this->db->get();

            foreach($db2->result() as $row):
                
                $empty_select .= '<option value="'.$row->KategoriID.'">'.$row->Description.'</option>';
                
            endforeach;

            return $empty_select.$empty_select_closed;        
              
        }

    }





}