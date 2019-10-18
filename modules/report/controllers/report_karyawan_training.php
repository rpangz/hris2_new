<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class report_karyawan_training extends CMS_Priv_Strict_Controller {


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
    

        //$crud->set_theme('flexigrid');
        $session_id = $this->cms_user_id();
        $today = date('Y-m-d H:i:s');
        //$crud->set_theme('datatables');
        // this is just for code completion


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

        $crud->set_table('tbl_profile');
        $crud->columns('nik');
        $crud->where('nik','5144');  
        $crud->set_primary_key('nik');
       
        $this->crud = $crud;
        return $crud;
    }

    public function stop_scheduler($primary_key){
        return "javascript:window.open('".base_url()."includes/mailer/frmStopReminderCertificate/?nik=".$primary_key."');void(0);location.reload();";
    } 

    public function _example_output($output = null)
    {
        //$this->view($this->cms_module_path().'modules/customers', $output);
        $this->view($this->cms_module_path().'/report_karyawan_training_view', $output,
        $this->cms_complete_navigation_name('report_karyawan_training'));    
    }

    public function index(){

        /*
        $crud = $this->make_crud();
        $output = $crud->render();
        $output->company = $this->get_company();
        $this->view($this->cms_module_path().'/report_karyawan_masuk_view', $output,
        $this->cms_complete_navigation_name('report_karyawan_masuk')); 
        */

        $crud = $this->make_crud();
        $output = $crud->render();
        $output->company = $this->get_company();
        $output->year = $this->get_year();        
        $output->dropdown_setup = $dd_data;
        $this->_example_output($output);
        
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('apv_group_approval'),array('iGroupApprovalId'=>$id));
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
        
        $session_nik = $post_array['NIK'];

        if (empty($_POST['status']) || is_null($_POST['status'])){
            $status = 'False';

            $this->update_tbl_profile($nik=$session_nik,$substitution_nik=$_POST['active_sub_nik'],$substitution_status=0);

        }else{
            $status = $_POST['status'];

            $this->update_tbl_profile($nik=$session_nik,$substitution_nik=$_POST['active_sub_nik'],$substitution_status=1);

        }


        if (!empty($_POST['nik_potential']) || !is_null($_POST['nik_potential'])){

            mysql_query('DELETE FROM tbl_substitution_potential WHERE CurrentNIK='.$session_nik);

            foreach ($_POST['nik_potential'] as $nik_potential){

                mysql_query('INSERT INTO tbl_substitution_potential (CurrentNIK,PotentialNIK) VALUES ("'.$session_nik.'","'.$nik_potential.'")');

            }
            mysql_query('INSERT INTO tbl_substitution_potential (CurrentNIK,PotentialNIK) VALUES ("'.$session_nik.'","'.$session_nik.'")');
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
        return TRUE;
    }

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }

    // add hyperlink
    public function _callback_edit_url($value, $row){    
    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->customerNumber)."'>$value</a>";
        
    }

    // add hyperlink
    public function _callback_column_NIKKI($value, $row){

        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('profile'))     
            ->where('NIK', $row->NIK)
            ->get(); 

        foreach ($query->result() as $rown){
            return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->iGroupApprovalId)."'>$rown->Nama</a>";
        }    
        
    }


    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_select(){
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
            $this->db->select('companyID, divisionID, deptID, iGroupApprovalId')
                     ->from('tbl_apv_group_approval')
                     ->where('iGroupApprovalId', $listingID);
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
            $this->db->select('companyID, divisionID, deptID, iGroupApprovalId')
                     ->from('tbl_apv_group_approval')
                     ->where('iGroupApprovalId', $listingID);
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

    public function empty_unit_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="iUnitID" class="chosen-select" data-placeholder="Select Unit" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('companyID, divisionID, deptID, iUnitID, iGroupApprovalId')
                     ->from('tbl_apv_group_approval')
                     ->where('iGroupApprovalId', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $divisionID = $row->divisionID;
            $deptID = $row->deptID;
            $unitID = $row->iUnitID;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_unit')
                     ->where('deptID', $deptID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->unitID == $unitID) {
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

    public function get_company()
    {
        
        $this->db->select("*")
                 ->from('tbl_company')
                 ->where('bstatus', '1');
        $db = $this->db->get();
        
        $data = '';
        foreach($db->result() as $row):
           $data .= '<option value="'.$row->iCompanyId.'">'.$row->cCompanyName.'</option>';
        endforeach;
        
        return $data;
    }

    public function get_year()
    {
        
        $this->db->distinct()
                 ->select('TrainingYear')
                 ->from('tbl_profile_training')
                 ->where('TrainingYear!=', '0000')
                 ->order_by('TrainingYear');
        $db = $this->db->get();
        
        $data = '';
        foreach($db->result() as $row):
           $data .= '<option value="'.$row->TrainingYear.'">'.$row->TrainingYear.'</option>';
        endforeach;
        
        return $data;
    }

    public function get_divisi($company)
    {        
        $this->db->select("*")
                 ->from('tbl_div')
                 ->where('iDivCompany', $company);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
           $array[] = array("value" => $row->iDivId, "property" => $row->cDivName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }

    public function get_dept($div)
    {        
        $this->db->select("*")
                 ->from('tbl_dept')
                 ->where('iDeptDivID', $div);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
           $array[] = array("value" => $row->iDeptID, "property" => $row->cDeptName);
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

    //GET JSON OF CITIES
    public function get_unit()
    {
        $deptID = $this->uri->segment(4);
        
        $this->db->select('unitID, NamaUnit')
                 ->from('tbl_unit')
                 ->where('deptID', $deptID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->unitID, "property" => $row->NamaUnit);
        endforeach;
        
        echo json_encode($array);
        exit;
    }
   


     // add hyperlink
    public function _callback_column_iGroupApprovalId($value, $row){        
    
        //return "<a href='".site_url($this->cms_module_path().'/frmGroupApproval/index/edit/'.$row->iGroupApprovalId)."'>$value</a>";
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->iGroupApprovalId)."'>$value</a>";
        
    }

    public function _callback_column_NIK2XX($value, $row)
    {
       
        //$Date2 = date('d-M-Y', strtotime($row->TglActive2));
        return $row->NIK;
        
    }


    public function _callback_edit_field_potential(){

        $session_nik = $this->check_user_nik($value=$this->uri->segment(5));

        $empty_select        = '<div class="row">
                                <div class="col-md-8">
                                <div class="input-prepend">
                                <select data-live-search="true" style="width: 100%; display: none;" 
                                class="selectpicker form-control" multiple="multiple" data-container="body" data-header="Pilih Karyawan Substitusi Potensial (Maksimal 4 Orang)" 
                                name="nik_potential[]" id="nik_potential[]">';
                     
                        

            $tampil = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");

            while ($rows = mysql_fetch_array($tampil)){                            

                $name          = 'nik_potential';
                $options       = $this->potential_all_user($company=$rows['iCompanyId'],$nik=$session_nik);
                $selected      = $this->current_substitution_potential($nik=$session_nik);

                $empty_select .= '<optgroup label="'.$rows['cCompanyName'].'">';
                $empty_select .= $this->multi_dropdown($name, $options, $selected );
                $empty_select .= '</optgroup>';

            }
        $empty_select_closed = '</select></div></div></div>';  
                         
        return $empty_select.$empty_select_closed;       


    }


    public function multi_dropdown( $name, array $options, array $selected=null, $size=4 ){
        $dropdown = '';

        foreach( $options as $key=>$option ){
               
                $select = in_array( $option, $selected ) ? ' selected' : null;
                $dropdown .= '<option value="'.$option.'"'.$select.' data-subtext="'.$option.'">'.$this->potential_profile($nik=$option).'</option>'."\n";
        }

        $dropdown .= '';
        return $dropdown;
    }

    public function potential_all_user($company,$nik){

        $query   = mysql_query('SELECT * FROM tbl_profile WHERE CompanyId='.$company.' AND NIK !='.$nik.' AND bStatus=1 ORDER BY Nama ASC');
        $total   = mysql_num_rows($query);
        $results = array();

        while($data = mysql_fetch_assoc($query)){
           $results[] = $data['NIK'];
        }

        return $results;

    }

    public function current_substitution_potential($nik){

        $query  = mysql_query('SELECT * FROM tbl_substitution_potential WHERE CurrentNIK='.$nik);
        $total  = mysql_num_rows($query);


        $results = array();
        while($data = mysql_fetch_assoc($query))
        {
           $results[] = $data['PotentialNIK'];
        }

        return $results;



    }


    public function potential_profile($nik){

        $query  = mysql_query('SELECT * FROM tbl_profile WHERE NIK='.$nik);
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);
        if ($total >0){
            return $data['Nama'];
        }else{
            return '';
        }

    }

    public function check_user_nik($value){

        $query  = mysql_query('SELECT * FROM tbl_apv_group_approval WHERE iGroupApprovalId='.$this->uri->segment(5));
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);
        if ($total >0){
            return $data['NIK'];
        }else{
            return '';
        }

    }

    public function existing_potential_user($value, $row){

        $query  = mysql_query('SELECT * FROM tbl_substitution_potential WHERE CurrentNIK='.$row->NIK);
        $total  = mysql_num_rows($query);

        if ($total >0){
            //$text    = '<span class="badge">'.$total.'</span> ';
            $text = '';
        }else{
            $text = '';
        }        


        $no      = 1;
        while($data = mysql_fetch_assoc($query)){

            $text .= $this->potential_profile($nik=$data['PotentialNIK']);

            if ($no < $total){
               $text .= ', ';
            }
            

        $no++;
        
        }

        return $text;


    }


    public function existing_active_user($value, $row){

        $query  = mysql_query('SELECT * FROM tbl_profile WHERE NIK='.$row->NIK);
        $total  = mysql_num_rows($query);       
        $data   = mysql_fetch_array($query);

        


        if (is_null($data['SubstitutionNIK1']) || empty($data['SubstitutionNIK1'])){
            $text ='';
            $text .='';
        }else{
            if ($data['SubstitutionStatus']==1){
                $text = '<span class="label label-primary">&nbsp;ON&nbsp;</span> ';
            }else{
                $text = '<span class="label label-default">OFF</span> ';
            }
            $text .= $this->potential_profile($nik=$data['SubstitutionNIK1']);
        }                  


        return $text;


    }

    public function _callback_edit_field_active_sub(){

        $session_nik = $this->check_user_nik($value=$this->uri->segment(5));

        //<select class="selectpicker" data-placeholder="Select Departement" style="width: 300px; display: none;" id="SubstitutionNIK1" name="SubstitutionNIK1">

        $form ='<div class="row">
                      <div class="col-md-8">
                        <div class="input-prepend">                         
                        <select data-live-search="true" style="width: 100%; display: none;" class="selectpicker form-control" data-container="body" data-header="Pilih Karyawan Substitusi" name="active_sub_nik" id="active_sub_nik">';

                        $form .= '<option value="" disabled SELECTED>Select User</option>';
                        
                        $tampil = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");

                        while ($rows = mysql_fetch_array($tampil)){

                        $form .= '<optgroup label="'.$rows['cCompanyName'].'">';

                        $sql = mysql_query("SELECT * FROM tbl_profile WHERE CompanyId=".$rows['iCompanyId']." AND NIK !='$session_nik' AND bStatus=1 GROUP BY NIK ORDER BY Nama ASC");           
                        while ($data = mysql_fetch_array($sql)){

                            if($this->current_substitution($session_nik)== $data['NIK']){  
                                $form .= '<option value="'.$data['NIK'].'" data-subtext="'.$data['NIK'].' ['.$data['Email'].']" SELECTED>'.$data['Nama'].'</option>';
                            }
                            else {
                                $form .= '<option value="'.$data['NIK'].'" data-subtext="'.$data['NIK'].' ['.$data['Email'].']">'.$data['Nama'].'</option>';
                            }

                        }
                        $form .= '</optgroup>';
                        }  

                        $form .= '</select>
                        <br/>
                          <span style="width:100%;float:left" class="add-on">
                            <input id="switch-animate" name="status" type="checkbox" data-handle-width="225" '.$this->current_substitution_status($session_nik).' data-on-text="<strong>ON</strong>" data-off-text="<strong>OFF</strong>" />
 
                          </span>
                        </div>
                      </div>
                      </div>';


        return $form;


    }

    public function current_substitution($nik){

        $query  = mysql_query('SELECT * FROM tbl_profile WHERE NIK='.$nik);
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        if ($total >0){
            return $data['SubstitutionNIK1'];
        }
        else {
            return '';
        }

    }

    public function current_substitution_status($nik){

        $query  = mysql_query('SELECT * FROM tbl_profile WHERE NIK='.$nik);
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        if ($total >0){
            if ($data['SubstitutionStatus']==1){
                return 'checked';
            }else{
                return '';
            }
        }
        else {
            return '';
        }

    }

    public function update_tbl_profile($nik,$substitution_nik,$substitution_status){

        mysql_query("UPDATE tbl_profile SET SubstitutionNIK1='$substitution_nik',SubstitutionStatus='$substitution_status' WHERE NIK='$nik'");

    }

    public function get_true_false_input_form_cuti($value, $primary_key){
        
        if ($value==1){
            $status = 'checked';
        }else{
            $status = '';
        }
               
        $input = '<input id="switch-animate1" data-toggle="toggle" type="checkbox" '.$status.' name="form_cuti" data-on-text="<strong>active</strong>" data-off-text="<strong>inactive</strong>" value="'.$value.'">';
        
       
        return $input;
    }

    public function get_true_false_input_form_ijin($value, $primary_key){
        
        if ($value==1){
            $status = 'checked';
        }else{
            $status = '';
        }
               
        $input = '<input id="switch-animate1" data-toggle="toggle" type="checkbox" '.$status.' name="form_ijin" data-on-text="<strong>active</strong>" data-off-text="<strong>inactive</strong>">';
        
        return $input;
    }

    public function get_true_false_input_form_my_cv($value, $primary_key){
        
        if ($value==1){
            $status = 'checked';
        }else{
            $status = '';
        }
               
        $input = '<input id="switch-animate1" data-toggle="toggle" type="checkbox" '.$status.' name="form_my_cv" data-on-text="<strong>active</strong>" data-off-text="<strong>inactive</strong>">';
        
        $jquery ='<script>
            $(":checkbox").checkboxpicker().change(function() {
                $("#switch-animate1").prop("checked",1);
                $("#switch-animate1").prop("disabled", 0);
 
            });

            
        </script>';
        return $input.$jquery;
    }    


    public function ajax_load_data_excell(){
        $data         = $this->input->get('data');
        $loaddata =  "                      
                      header('Content-Type: application/vnd.ms-excel'); 
                      header('Content-disposition: attachment; filename=AAA.xls');
                      ";
        $loaddata .= "TEST";
        echo $loaddata; 

    }


    public function ajax_load_data(){
        
        $jenis         = $this->input->get('jenis');
        $grouping      = $this->input->get('grouping');
        $company       = $this->input->get('company');
        $divisi        = $this->input->get('divisi');
        $department    = $this->input->get('department');
        $tahun1         = $this->input->get('tahun1');
        $statusaktif   = $this->input->get('statusaktif');

        $connscr = '';
        if($company!='0'){
            $connscr .= ' AND a.companyid="'.$company.'"';
        }

        if($divisi!='0'){
            $connscr .= ' AND DivisiId="'.$divisi.'"';
        }

        if($department!='0'){
            $connscr .= ' AND deptid="'.$department.'"';
        }

        if($statusaktif!='all'){
            $connscr .= ' AND a.bstatus="'.$statusaktif.'"';
        }

        if($tahun1!='0'){
            $connscr .= ' AND TrainingYear="'.$tahun1.'"';
        }

        if($jenis=='rekap' && $grouping=='all'){
            $grouping='cCompanyName';
        }

        
        if($grouping!="all"){
            $ordering = "ORDER BY ".$grouping.",cCompanyCode,cDivName,cDeptName,nik";
        } else {
            $ordering = "ORDER BY cCompanyCode,cDivName,cDeptName,nik";
        }

        $corequery =    'SELECT a.companyid,deptid,DivisiId,cCompanyName,cCompanyCode,
                        CASE WHEN cDivName IS NULL THEN "" ELSE cDivName END cDivName,
                        CASE WHEN cDeptName IS NULL THEN "" ELSE cDeptName END cDeptName,nik,nama,
                        TrainingYear,TrainingInstitution, TrainingCity,TrainingModul,TrainingType,
                        CASE WHEN a.bstatus = 1 THEN "ACTIVE" ELSE "NON ACTIVE" END bstatus
                        FROM (tbl_profile_training z,tbl_profile a)
                        LEFT JOIN tbl_dept b ON a.DeptId=b.iDeptId
                        LEFT JOIN tbl_div c ON a.DivisiId=c.iDivId
                        LEFT JOIN tbl_company d ON a.CompanyId=d.iCompanyId
                        LEFT JOIN tbl_jabatan e ON a.JabatanID=e.JabatanID
                        LEFT JOIN tbl_status f ON a.Status=f.StatusID
                        
                        WHERE a.nik=z.TrainingNik AND 1=1 '.$connscr.' '.$ordering;



        $loaddatadetail = '';             
        if($jenis=="detail"){
            if($grouping<>'all'){
                $mysqlcomm = 'SELECT '.$grouping.' FROM ('.$corequery.') a GROUP BY '.$grouping;
                $query = $this->db->query($mysqlcomm);
                $alltotal = 0;
                $datareport = 0;
                foreach ($query->result() as $row)
                {       
                        $datareport += 1;    
                        $groupingvalue = $row->$grouping;
                        //$loaddatadetail .= '<tr><td>'.$groupingvalue.'</td></tr>';
                        $loaddataexcell = '<td style="width:4%; text-align: right;">
                                          <a href="#" title="Download Excel '.$groupingvalue.'" onclick="exportTableToExcel(\'datareport'.$datareport.'\')"><img src="https://'.$_SERVER['SERVER_NAME'].'/hris2/images/icn-excel.png" alt="Download Excel 2 '.$groupingvalue.'" width="25" class="img-responsive"/></a>
                                        </td>';

                        $loaddatadetail .= '<table style="width:100%;">
                                            <tr>
                                                <td style="width:20%; text-align: left"><b>'.$groupingvalue.'</b></td>
                                                <td style="width:70%; text-align: left"><b>&nbsp;</b></td>
                                                '.$loaddataexcell.'
                                            </tr>
                                            </table>';

                        $loaddatadetail .= '<table class="ReportTable" id="datareport'.$datareport.'">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>NIK</th>
                                                        <th>Nama</th>
                                                        <th>Tahun</th>
                                                        <th>Institusi</th>
                                                        <th>Kota</th>
                                                        <th>Modul</th>
                                                        <th>Tipe</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                        $mysqlcommdetail = 'SELECT * FROM ('.$corequery.') a WHERE '.$grouping.'="'.$groupingvalue.'"'; 
                        $querydetail = $this->db->query($mysqlcommdetail); 
                        $grouptotal = 0;
                        $no         = 0;
                        foreach ($querydetail->result() as $rowdetail)
                        {  
                            $grouptotal += 1;$alltotal += 1;$no += 1;

                            $loaddatadetail .= '<tr>
                                                    <td>'.$no.'</td>
                                                    <td>'.$rowdetail->nik.'</td>
                                                    <td>'.$rowdetail->nama.'</td>
                                                    <td>'.$rowdetail->TrainingYear.'</td>
                                                    <td>'.$rowdetail->TrainingInstitution.'</td>
                                                    <td>'.$rowdetail->TrainingCity.'</td>
                                                    <td>'.$rowdetail->TrainingModul.'</td>
                                                    <td>'.$rowdetail->TrainingType.'</td>
                                                    <td>'.$rowdetail->bstatus.'</td>
                                                </tr> 
                                                ';
                        }    

                        $loaddatadetail .= '<tr><td colspan=8 style="font-weight:bold; text-align: center">Total Training: </td><td style="text-align:right; font-weight:bold; padding-right: 5px;">'.$grouptotal.'</td></tr>';
                        $loaddatadetail .= '</tbody></table><br>';
                        //$loaddatadetail .= '<tr><td colspan=11 style="font-weight:bold; text-align: center">Total Karyawan: </td><td style="text-align:right; font-weight:bold;">'.$grouptotal.'</td></tr><br><br>'; 
                                  
                }
                //$loaddatadetail .= '<tr><td>Total Karyawan2: '.$alltotal.'</td></tr><br><br>';
                
                $loaddatadetail .= '
                                    <table class="ReportTable"> 
                                        <tbody>
                                            <tr><td style="text-align: center; font-weight: bold;">Grand Total Training: '.$alltotal.'</td></tr>
                                        </tbody>     
                                    </table>';
                
            } else {

                    $loaddataexcell .= '<td style="width:4%; text-align: right;">
                                          <a href="#" title="Download Excel" onclick="exportTableToExcel(\'datareportall\')"><img src="https://'.$_SERVER['SERVER_NAME'].'/hris2/images/icn-excel.png" alt="Download Excel" width="25" class="img-responsive"/></a>
                                        </td>';

                    $loaddatadetail .= '<table style="width:100%;">
                                        <tr>
                                            <td style="width:20%; text-align: left"><b>ALL DATA</b></td>
                                            <td style="width:70%; text-align: left"><b>&nbsp;</b></td>
                                            '.$loaddataexcell.'
                                        </tr>
                                        </table>';
                    $loaddatadetail .= '<table class="ReportTable" id="datareportall">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>NIK</th>
                                                    <th>Nama</th>
                                                    <th>Tahun</th>
                                                    <th>Institusi</th>
                                                    <th>Kota</th>
                                                    <th>Modul</th>
                                                    <th>Tipe</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                        $mysqlcommdetail = 'SELECT * FROM ('.$corequery.') a';     
                        $querydetail = $this->db->query($mysqlcommdetail); 
                        $alltotal   = 0;
                        $grouptotal = 0;
                        $no         = 0;
                        foreach ($querydetail->result() as $rowdetail)
                        {  
                            $grouptotal += 1;$alltotal += 1;$no += 1;

                            $loaddatadetail .= '<tr>
                                                   <td>'.$no.'</td>
                                                    <td>'.$rowdetail->nik.'</td>
                                                    <td>'.$rowdetail->nama.'</td>
                                                    <td>'.$rowdetail->TrainingYear.'</td>
                                                    <td>'.$rowdetail->TrainingInstitution.'</td>
                                                    <td>'.$rowdetail->TrainingCity.'</td>
                                                    <td>'.$rowdetail->TrainingModul.'</td>
                                                    <td>'.$rowdetail->TrainingType.'</td>
                                                    <td>'.$rowdetail->bstatus.'</td>
                                                </tr> 
                                                ';
                        }    
                        $loaddatadetail .= '</tbody></table>';
                        $loaddatadetail .= '<tr><td>Total Training: '.$alltotal.'</td></tr><br><br>';                         
            }
        } elseif ($jenis=="rekap") {

                $loaddataexcell .= '<td style="width:4%; text-align: right;">
                                          <a href="#" title="Download Excel" onclick="exportTableToExcel(\'datareportrekap\')"><img src="https://'.$_SERVER['SERVER_NAME'].'/hris2/images/icn-excel.png" alt="Download Excel" width="25" class="img-responsive"/></a>
                                    </td>';

                $loaddatadetail .= '<table style="width:100%;">
                                    <tr>
                                        <td style="width:20%; text-align: left"><b>ALL DATA</b></td>
                                        <td style="width:70%; text-align: left"><b>&nbsp;</b></td>
                                        '.$loaddataexcell.'
                                    </tr>
                                    </table>';

                $loaddatadetail .= '<table class="ReportTable" id="datareportrekap">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Property</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                $mysqlcomm = 'SELECT '.$grouping.' AS property,COUNT(1) AS value FROM ('.$corequery.') a GROUP BY '.$grouping;
                $query = $this->db->query($mysqlcomm);
                $no = 0;
                $alltotal = 0;
                $valtotal = 0;
                foreach ($query->result() as $row)
                {
                        $valtotal += $row->value;
                        $no += 1;
                        $alltotal += 1;
                        $loaddatadetail .= '<tr>
                                                <td style="text-align: center">'.$no.'</td>
                                                <td>'.$row->property.'</td>
                                                <td style="text-align: right; padding-right:10px;">'.$row->value.'</td>                                              
                                            </tr> 
                                            ';   
                }  
                $loaddatadetail .= '<tr>
                                        <td colspan=2 style="font-weight:bold;font-size:12px;text-align: center">Total :</td>
                                        <td style="text-align: right; padding-right:10px; font-weight:bold">'.$valtotal.'</td>
                                    </tr>';
                $loaddatadetail .= '</tbody></table>';  
        }



        if($alltotal<1){
            $loaddatadetail = '<center> - NO DATA - </center>';
        }


        $loaddatacss = '
            <style type="text/css">
              table.ReportTable {
              font-family: "Times New Roman", Times, serif;
              border: 2px solid #A40808;
              background-color: #EEE7DB;
              width: 100%;
              text-align: left;
              border-collapse: collapse;
            }
            table.ReportTable td, table.ReportTable th {
              border: 1px solid #AAAAAA;
              padding: 3px 2px;
            }
            table.ReportTable tbody td {
              font-size: 12px;
            }
            table.ReportTable thead {
              background: #A40808;
              background: -moz-linear-gradient(top, #bb4646 0%, #ad2020 66%, #A40808 100%);
              background: -webkit-linear-gradient(top, #bb4646 0%, #ad2020 66%, #A40808 100%);
              background: linear-gradient(to bottom, #bb4646 0%, #ad2020 66%, #A40808 100%);
            }
            table.ReportTable thead th {
              font-size: 12px;
              font-weight: bold;
              color: #FFFFFF;
              text-align: center;
              border-left: 2px solid #A40808;
            }
            table.ReportTable thead th:first-child {
              border-left: none;
            }

            table.ReportTable tfoot td {
              font-size: 13px;
            }
            table.ReportTable tfoot .links {
              text-align: right;
            }
            table.ReportTable tfoot .links a{
              display: inline-block;
              background: #FFFFFF;
              color: #A40808;
              padding: 2px 8px;
              border-radius: 5px;
            }
            </style>
        ';

        $loaddata = $loaddatacss.$loaddatadetail;
        //$loaddata .= $loaddatadetail;
        //$loaddata = $corequery;
        echo $loaddata;
    }




}