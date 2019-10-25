<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class penyesuaian_karyawan extends CMS_Priv_Strict_Controller {


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
        $this->view($this->cms_module_path().'/penyesuaian_karyawan_view', $output,
        $this->cms_complete_navigation_name('penyesuaian_karyawan'));    
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
        $output->company     = $this->get_company();
        $output->jenismutasi = $this->get_jenis_mutasi();
        $output->jenisjabatan = $this->get_jenis_jabatan();
        $output->nik = $this->get_jenis_nik();
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


    public function get_jenis_mutasi()
    {
        
        $this->db->select("*")
                 ->from('tbl_list_jenismutasi')
                 ->where('statusmutasi', '1')
                 ->order_by("ordinal", "asc");
        $db = $this->db->get();        
        $data = '';
        foreach($db->result() as $row):
           $data .= '<option value="'.$row->kodemutasi.'">'.$row->jenismutasi.'</option>';
        endforeach;
        
        return $data;
    }

    public function get_jenis_nik()
    {
        
        $this->db->select("*")
                 ->from('tbl_profile')
                 ->where('bStatus', '1')
                 ->order_by("Nama", "asc");
        $db = $this->db->get();        
        $data = '';
        foreach($db->result() as $row):
           $data .= '<option value="'.$row->NIK.'">'.$row->Nama.'</option>';
        endforeach;
        
        return $data;
    }


    public function get_jenis_nik_kontrak()
    {  
       /*      
       $query = $this->db->query("SELECT NIK,Nama,startkontrak_first,startkontrak,DATE_FORMAT(endkontrak,'%d/%m/%Y') endkontrak  FROM tbl_profile
                                  WHERE endkontrak>=DATE_ADD(current_date(),INTERVAL -3 MONTH) AND endkontrak<=current_date() 
                                  ORDER BY endkontrak");
       */
       
       $query = $this->db->query("SELECT NIK,Nama,startkontrak_first,startkontrak,DATE_FORMAT(endkontrak,'%d/%m/%Y') endkontrak  FROM tbl_profile
                                  
                                  ORDER BY Nama");

       $data = '';
       foreach ($query->result() as $row)
        {
                $data .= '<option value="'.$row->NIK.'">'.$row->Nama.' ( Exp : '.$row->endkontrak.' ) </option>';                
        }        
        return $data;
    }


    public function get_jenis_jabatan()
    {
        
        $this->db->select("*")
                 ->from('tbl_jabatan')
                 ->order_by("Pangkat", "asc");
        $db = $this->db->get();        
        $data = '';
        foreach($db->result() as $row):
           $data .= '<option value="'.$row->JabatanId.'">'.$row->NamaJabatan.'</option>';
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

    public function loadform(){
        $jenisform         = $this->input->get('jenis');
        if($jenisform==1){
            echo $this->loadbandform($jenisform);
        } elseif ($jenisform==2) {
            echo $this->loadmutasiform($jenisform);
        } elseif ($jenisform==3) {
            echo $this->loadkaryawantetapform($jenisform);
        } elseif ($jenisform==4) {
            echo $this->loadkontrakform($jenisform);
        }
        else{
            echo "No Form Available";
        }

    }

    public function loadbandform($jenisform){
        $htmldata = '<table class="table table-striped" style="font-size:12px;width:50%;table-layout:fixed;">
                        <input type="text" id="jenismutasival" name="jenismutasival" value="'.$jenisform.'" style="display:none;">
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">NIK</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <select name="nik" id="nik" class="chosen-select form-control" data-placeholder="Pilih Karyawan" style="width: 100%; font-size: 12px; height: 35px;"> 
                                <option value="0" disabled selected>- Pilih Karyawan -</option>
                                '.$this->get_jenis_nik().'               
                               </select>
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Band</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <input type="text" class="form-control" placeholder="Band" id="band" name="band" style="width: 50%; font-size: 12px; height: 35px;" />                    
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Jabatan</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <select name="jabatan" id="jabatan" class="chosen-select form-control" data-placeholder="Pilih Jabatan" style="width: 100%; font-size: 12px; height: 35px;"> 
                                <option value="0" disabled selected>- Pilih Jabatan -</option>
                                '.$this->get_jenis_jabatan().'             
                               </select>
                            </td>                
                        </tr> 
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Tgl Efektif</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <input type="text" class="form-control" placeholder="" id="tgleffektif" name="tgleffektif" style="width: 30%; font-size: 12px; height: 35px; text-align: center;" />                    
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Remark</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <input type="text" class="form-control" placeholder="Remark" id="remark" name="remark" style="width: 100%; font-size: 12px; height: 35px;" />                    
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle" colspan="3">
                                <input type="button" name="simpanband" id="simpanband" value="Simpan" style="width: 90px; height: 30px; font-size: 11px;" onclick="save_band()"> 
                            </td>                        
                        </tr>     
                    </table>';

        return $htmldata;          
    }


    public function loadmutasiform($jenisform){
        $htmldata = '<table class="table table-striped" style="font-size:12px;width:100%;table-layout:fixed;">
                        <input type="text" id="jenismutasival" name="jenismutasival" value="'.$jenisform.'" style="display:none;">
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">NIK</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <select name="nik" id="nik" class="chosen-select form-control" data-placeholder="Pilih Karyawan" style="width: 100%; font-size: 12px; height: 35px;"> 
                                <option value="0" disabled selected>- Pilih Karyawan -</option>
                                '.$this->get_jenis_nik().'               
                               </select>
                            </td>
                            <td width="50%"  rowspan="7">

                                <center><h1>HARAP DI PERHATIKAN!!!</h1></center>
                                <div style="border-top: 1px dotted;"></div>
                                <br>
                                <ul style="font-size:15px;">                                    
                                    <li>NIK baru hanya untuk <b>Perpindahan PT</b>, Jika PT tidak berubah maka system tidak akan membuat NIK baru</li>
                                    <br>
                                    <li>Jika <b>Perpindahan PT</b>, maka data yang terdapat di NIK lama akan otomatis termigrasi ke NIK baru</li><br>
                                    <li>Data yang akan termigrasi ke NIK baru antara lain : 
                                        <ul>
                                            <li>Sejarah Cuti</li>
                                            <li>Profile Karyawan</li>
                                            <li>CV Karyawan</li>    
                                        </ul>
                                    </li>
                                    <br>
                                    <li>NIK lama akan dengan otomatis di non-aktif kan</li>
                                </ul>
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Company</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <select name="company" id="company" class="chosen-select form-control" data-placeholder="Pilih Company" style="width: 100%; font-size: 12px; height: 35px;" onchange="get_divisi()"> 
                                <option value="0" disabled selected>- Pilih Company -</option>
                                '.$this->get_company().'               
                               </select>
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Divisi</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <select name="divisi" id="divisi" class="chosen-select form-control" data-placeholder="Pilih Divisi" style="width: 100%; font-size: 12px; height: 35px;" onchange="get_dept()"> 
                                <option value="0" disabled selected>- Pilih Divisi -</option>                                            
                               </select>
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Departement</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <select name="department" id="department" class="chosen-select form-control" data-placeholder="Pilih Departement" style="width: 100%; font-size: 12px; height: 35px;"> 
                                <option value="0" disabled selected>- Pilih Departement -</option>
                                             
                               </select>
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">NIK Baru ( Pindah PT )</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <input type="text" class="form-control" placeholder="NIK Baru Untuk Pindah PT" id="nikbaru" name="nikbaru" style="width: 50%; font-size: 12px; height: 35px;" onkeypress="return isNumberKey(event)" />                    
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Tgl Efektif</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <input type="text" class="form-control" placeholder="" id="tgleffektif" name="tgleffektif" style="width: 30%; font-size: 12px; height: 35px; text-align: center;" />                    
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Remark</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <input type="text" class="form-control" placeholder="Remark" id="remark" name="remark" style="width: 100%; font-size: 12px; height: 35px;" />                    
                            </td>                
                        </tr>
                        <!--
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle" style="border-bottom: 1px dotted;" colspan="3"></td>
                        </tr>
                        --> 

                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle" colspan="3">
                                <input type="button" name="simpanband" id="simpanband" value="Simpan" style="width: 90px; height: 30px; font-size: 11px;" onclick="save_mutasi()"> 
                            </td>                        
                        </tr>     
                    </table>';

        return $htmldata;          
    }



    public function loadkontrakform($jenisform){
        $htmldata = '<table class="table table-striped" style="font-size:12px;width:50%;table-layout:fixed;">
                        <input type="text" id="jenismutasival" name="jenismutasival" value="'.$jenisform.'" style="display:none;">
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">NIK</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <select name="nik" id="nik" class="chosen-select form-control" data-placeholder="Pilih Karyawan" style="width: 100%; font-size: 12px; height: 35px;" onchange="get_datakontrak()"> 
                                <option value="0" disabled selected>- Pilih Karyawan -</option>
                                '.$this->get_jenis_nik_kontrak().'               
                               </select>
                            </td>
                            <!--
                            <td width="50%"  rowspan="7">

                                <center><h1>HARAP DI PERHATIKAN!!!</h1></center>
                                <div style="border-top: 1px dotted;"></div>
                                <br>
                                <ul style="font-size:15px;">                                    
                                    <li>NIK baru hanya untuk <b>Perpindahan PT</b>, Jika PT tidak berubah maka system tidak akan membuat NIK baru</li>
                                    <br>
                                    <li>Jika <b>Perpindahan PT</b>, maka data yang terdapat di NIK lama akan otomatis termigrasi ke NIK baru</li><br>
                                    <li>Data yang akan termigrasi ke NIK baru antara lain : 
                                        <ul>
                                            <li>Sejarah Cuti</li>
                                            <li>Profile Karyawan</li>
                                            <li>CV Karyawan</li>    
                                        </ul>
                                    </li>
                                    <br>
                                    <li>NIK lama akan dengan otomatis di non-aktif kan</li>
                                </ul>
                            </td>  
                            -->              
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Kontrak PKWT 1</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <div id="divcontractbeforePKWT1"> - </>
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Kontrak PKWT 2</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <div id="divcontractbeforePKWT2"> - </>
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Kontrak Sebelumnya</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <div id="divcontractbefore"> - </>
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Jenis PKWT</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <div id="divstatuspkwt"> - </>
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Kontrak Baru</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <select name="lamakontrak" id="lamakontrak" class="chosen-select form-control" data-placeholder="Pilih Lama Kontrak" style="width: 100%; font-size: 12px; height: 35px;" onchange="setendkontrak()"> 
                                <option value="0" disabled selected>- Pilih Lama Kontrak -</option>
                                               
                               </select>
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Tgl Akhir Kontrak Baru</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <input type="text" class="form-control" placeholder="" id="tgleffektif" name="tgleffektif" style="width: 30%; font-size: 12px; height: 35px; text-align: center;" onchange="check_endkontrak()" />                    
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Remark</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <input type="text" class="form-control" placeholder="Remark" id="remark" name="remark" style="width: 100%; font-size: 12px; height: 35px;" />                    
                            </td>                
                        </tr>
                        <!--
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle" style="border-bottom: 1px dotted;" colspan="3"></td>
                        </tr>
                        --> 

                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle" colspan="3">
                                <input type="button" name="simpanband" id="simpanband" value="Simpan" style="width: 90px; height: 30px; font-size: 11px;" onclick="save_kontrak()"> 
                            </td>                        
                        </tr>     
                    </table>';

        return $htmldata;          
    }


    public function loadkaryawantetapform($jenisform){
        $htmldata = '<table class="table table-striped" style="font-size:12px;width:50%;table-layout:fixed;">
                        <input type="text" id="jenismutasival" name="jenismutasival" value="'.$jenisform.'" style="display:none;">
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">NIK</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <select name="nik" id="nik" class="chosen-select form-control" data-placeholder="Pilih Karyawan" style="width: 100%; font-size: 12px; height: 35px;"> 
                                <option value="0" disabled selected>- Pilih Karyawan -</option>
                                '.$this->get_jenis_nik().'               
                               </select>
                            </td>                
                        </tr>                        
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Tgl Efektif</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <input type="text" class="form-control" placeholder="" id="tgleffektif" name="tgleffektif" style="width: 30%; font-size: 12px; height: 35px; text-align: center;" />                    
                            </td>                
                        </tr>
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle">Remark</td>
                            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
                            <td width="37%">
                              <input type="text" class="form-control" placeholder="Remark" id="remark" name="remark" style="width: 100%; font-size: 12px; height: 35px;" />                    
                            </td>                
                        </tr>
                        <!--
                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle" style="border-bottom: 1px dotted;" colspan="3"></td>
                        </tr>
                        --> 

                        <tr>
                            <td width="12%" class="noborder-lr" valign="middle" colspan="3">
                                <input type="button" name="simpanband" id="simpanband" value="Simpan" style="width: 90px; height: 30px; font-size: 11px;" onclick="save_tetap()"> 
                            </td>                        
                        </tr>     
                    </table>';

        return $htmldata;          
    }

    public function ajax_save_band(){
         $nik               = $this->input->get('nik');
         $band              = $this->input->get('band');
         $jabatan           = $this->input->get('jabatan');   
         $jenismutasival    = $this->input->get('jenismutasival');   
         $tglfrom           = $this->input->get('tglfrom');            
         $remark            = $this->input->get('remark');   
         $date              = str_replace('/', '-', $tglfrom );
         $tglefektif        = date("Y-m-d", strtotime($date));


         //$data = $db->row(0);

         if($jabatan==0){
            $error  = true;
            $errmsg = "Harap Pilih Jabatan Terlebih Dahulu !!!";
         }

         if(strlen($band)<1 && strlen($band)>3){
            $error  = true;
            $errmsg = "Harap Isi Band Dengan Benar !!!";  
         }

         if($nik==0){
            $error  = true;
            $errmsg = "Harap Pilih NIK Terlebih Dahulu !!!";
         }

         if(strlen($jenismutasival)<1){
            $error  = true;
            $errmsg = "Jenis Mutasi Tidak Di Temukan !!!";
         }
     

         if(strlen($tglefektif)<10 || $tglefektif=="1970-01-01"){
            $error  = true;
            $errmsg = "Tanggal Efektif Belum Di Isi !!!";
         }



         if(!$error) {
            $this->db->select('*')
                 ->from('tbl_profile')
                 ->where('NIK', $nik);
             $db = $this->db->get();
             $data = $db->row(0);
             $jabatan_old    = $data->JabatanID;
             $band_old       = $data->BandSkrg;
             $nik_absensi    = $data->NIK_Absensi;

             if(strlen($nik_absensi<1)){
                $error  = true;
                $errmsg = "NIK Primary Tidak Di Temukan";
             }   
         }


         if(!$error){

            $sql0 = $this->db->update("tbl_penyesuaian_karyawan",
                                array('bstatus' => 0,), 
                                array('nik'=>$nik));

            $sql = $this->db->insert("tbl_penyesuaian_karyawan",
                        array(                    
                            'nik_absensi' => $nik_absensi,
                            'nik' => $nik,
                            'jabatan_new' => $jabatan,
                            'jabatan_old' => $jabatan_old,
                            'bd_new' => $band,
                            'bd_old' => $band_old,
                            'tglefektif' => $tglefektif,
                            'jenis_penyesuaian' => $jenismutasival,
                            'createuser' => $this->cms_user_id(),
                            'createtime' => date('Y-m-d H:i:s'),
                            'updateuser' => $this->cms_user_id(),
                            'updatetime' => date('Y-m-d H:i:s'),
                            'bstatus' => 1,
                            'remarks' => $remark,
                        )
                    );
         }

         if($sql){
            $sql2 = $this->db->update($this->cms_complete_table_name('profile'),
                            array('JabatanID' => $jabatan,
                                  'BandLalu' =>  $band_old,
                                  'BandSkrg' =>  $band,
                                  'UpdatedBy' => $this->cms_user_id(),
                                  'UpdatedTime' => date('Y-m-d H:i:s'),
                            ), 
                            array('NIK'=>$nik));
         }

         if($sql2){
            $error  = false;
            $errmsg = "Data Berhasil Di Input";
         }
         

        $returndata = $error."|".$errmsg;

        echo $returndata;
       
    }


    public function ajax_save_mutasi(){
         $nik                  = $this->input->get('nik');
         $company              = $this->input->get('company');
         $divisi               = $this->input->get('divisi');   
         $department           = $this->input->get('department');   
         $jenismutasival       = $this->input->get('jenismutasival');   
         $tgleffektif          = $this->input->get('tgleffektif');     
         $remark               = $this->input->get('remark');          
         $nikbaru               = $this->input->get('nikbaru');
         $date                 = str_replace('/', '-', $tgleffektif );
         $tglefektif           = date("Y-m-d", strtotime($date));



         if($department==0){
            $error  = true;
            $errmsg = "Harap Pilih Departement Terlebih Dahulu !!!";
         }

         if($divisi==0){
            $error  = true;
            $errmsg = "Harap Pilih Divisi Terlebih Dahulu !!!";
         }
         
         if($company==0){
            $error  = true;
            $errmsg = "Harap Pilih Company Terlebih Dahulu !!!";
         }

         if($nik==0){
            $error  = true;
            $errmsg = "Harap Pilih NIK Terlebih Dahulu !!!";
         }

         if(strlen($jenismutasival)<1){
            $error  = true;
            $errmsg = "Jenis Mutasi Tidak Di Temukan !!!";
         }
     

         if(strlen($tglefektif)<10 || $tglefektif=="1970-01-01"){
            $error  = true;
            $errmsg = "Tanggal Efektif Belum Di Isi !!!";
         }

         if($nik==$nikbaru){
            $error  = true;
            $errmsg = "NIK tidak boleh sama dengan NIK baru !!!";  
         }



         if(!$error) {
            $this->db->select('*')
                 ->from('tbl_profile')
                 ->where('NIK', $nik);
             $db = $this->db->get();
             $data = $db->row(0);
             $company_old       = $data->CompanyId;
             $divisi_old        = $data->DivisiID;
             $department_old    = $data->DeptID;
             $nik_absensi       = $data->NIK_Absensi;

             if(strlen($nik_absensi<1)){
                $error  = true;
                $errmsg = "NIK Primary Tidak Di Temukan";               
             }   

         }

         $migratenik = "NO";
         if(!$error){
            if($company!=$company_old){                
                $hasil = $this->mutasi_nik($nik,$nikbaru,$tglefektif,$company);
                $migratenik = "OK";
                $mutasi_error   = $hasil['error'];
                $mutasi_message = $hasil['message'];
                $error  = $mutasi_error;
                $errmsg = $mutasi_message;
            }
         }

         


         if(!$error){

            $sql0 = $this->db->update("tbl_penyesuaian_karyawan",
                                array('bstatus' => 0,), 
                                array('nik'=>$nik));

            if($migratenik=="OK"){
                $sql = $this->db->insert("tbl_penyesuaian_karyawan",
                        array(                    
                            'nik_absensi' => $nik_absensi,
                            'nik' => $nik,
                            'nik_new' => $nikbaru,
                            'nik_old' => $nik,
                            'company_new' => $company,
                            'company_old' => $company_old,
                            'divisi_new' => $divisi,
                            'divisi_old' => $divisi_old,
                            'department_new' => $department,
                            'department_old' => $department_old,
                            'tglefektif' => $tglefektif,
                            'jenis_penyesuaian' => $jenismutasival,
                            'createuser' => $this->cms_user_id(),
                            'createtime' => date('Y-m-d H:i:s'),
                            'updateuser' => $this->cms_user_id(),
                            'updatetime' => date('Y-m-d H:i:s'),
                            'bstatus' => 1,
                            'remarks' => $remark,
                        )
                    );
            } else {
                $sql = $this->db->insert("tbl_penyesuaian_karyawan",
                        array(                    
                            'nik_absensi' => $nik_absensi,
                            'nik' => $nik,                            
                            'company_new' => $company,
                            'company_old' => $company_old,
                            'divisi_new' => $divisi,
                            'divisi_old' => $divisi_old,
                            'department_new' => $department,
                            'department_old' => $department_old,
                            'tglefektif' => $tglefektif,
                            'jenis_penyesuaian' => $jenismutasival,
                            'createuser' => $this->cms_user_id(),
                            'createtime' => date('Y-m-d H:i:s'),
                            'updateuser' => $this->cms_user_id(),
                            'updatetime' => date('Y-m-d H:i:s'),
                            'bstatus' => 1,
                            'remarks' => $remark,
                        )
                    );
            }

            
         }

         if($sql){
            if($migratenik=="OK"){
                $sql2 = $this->db->update($this->cms_complete_table_name('profile'),
                            array('bStatus' => 0,                                  
                                  'UpdatedBy' => $this->cms_user_id(),
                                  'UpdatedTime' => date('Y-m-d H:i:s'),
                            ), 
                            array('NIK'=>$nik));  

                $sql2 = $this->db->update($this->cms_complete_table_name('profile'),
                            array('CompanyId' => $company,
                                  'DivisiID' =>  $divisi,
                                  'DeptID' =>  $department,
                                  'TglMasuk' =>  $tglefektif,
                                  'UpdatedBy' => $this->cms_user_id(),
                                  'UpdatedTime' => date('Y-m-d H:i:s'),
                                  'CreatedBy' => $this->cms_user_id(),
                                  'CreatedTime' => date('Y-m-d H:i:s'),
                            ), 
                            array('NIK'=>$nikbaru));                                        
            } else {
                $sql2 = $this->db->update($this->cms_complete_table_name('profile'),
                            array('CompanyId' => $company,
                                  'DivisiID' =>  $divisi,
                                  'DeptID' =>  $department,
                                  'UpdatedBy' => $this->cms_user_id(),
                                  'UpdatedTime' => date('Y-m-d H:i:s'),
                            ), 
                            array('NIK'=>$nik));
            }
            
         }

         if($sql2){
            $error  = false;
            $errmsg = "Data Berhasil Di Input";
         }
         

        $returndata = $error."|".$errmsg;
        
        echo $returndata;
        
    }

    public function ajax_save_tetap(){
         $nik               = $this->input->get('nik');        
         $jenismutasival    = $this->input->get('jenismutasival');   
         $tglefektif           = $this->input->get('tglefektif');            
         $remark            = $this->input->get('remark');   
         $date              = str_replace('/', '-', $tglefektif );
         $tglefektif        = date("Y-m-d", strtotime($date));



         //$data = $db->row(0);


         if($nik==0){
            $error  = true;
            $errmsg = "Harap Pilih NIK Terlebih Dahulu !!!";
         }

         if(strlen($jenismutasival)<1){
            $error  = true;
            $errmsg = "Jenis Mutasi Tidak Di Temukan !!!";
         }
     

         if(strlen($tglefektif)<10 || $tglefektif=="1970-01-01"){
            $error  = true;
            $errmsg = "Tanggal Efektif Belum Di Isi !!!";
         }



         if(!$error) {
            $this->db->select('*')
                 ->from('tbl_profile')
                 ->where('NIK', $nik);
             $db = $this->db->get();
             $data = $db->row(0);
             $status_old    = $data->Status;
             $nik_absensi    = $data->NIK_Absensi;

             if(strlen($nik_absensi<1)){
                $error  = true;
                $errmsg = "NIK Primary Tidak Di Temukan";
             }   
         }


         if(!$error){

            $sql0 = $this->db->update("tbl_penyesuaian_karyawan",
                                array('bstatus' => 0,), 
                                array('nik'=>$nik));

            $sql = $this->db->insert("tbl_penyesuaian_karyawan",
                        array(                    
                            'nik_absensi' => $nik_absensi,
                            'nik' => $nik,
                            'statuskontrak_new' => 2,
                            'statuskontrak_old' => $status_old,
                            'tglefektif' => $tglefektif,
                            'jenis_penyesuaian' => $jenismutasival,
                            'createuser' => $this->cms_user_id(),
                            'createtime' => date('Y-m-d H:i:s'),
                            'updateuser' => $this->cms_user_id(),
                            'updatetime' => date('Y-m-d H:i:s'),
                            'bstatus' => 1,
                            'remarks' => $remark,
                        )
                    );
         }

         if($sql){
            $sql2 = $this->db->update($this->cms_complete_table_name('profile'),
                            array('Status' => 2,                                 
                                  'UpdatedBy' => $this->cms_user_id(),
                                  'UpdatedTime' => date('Y-m-d H:i:s'),
                            ), 
                            array('NIK'=>$nik));
         }

         if($sql2){
            $error  = false;
            $errmsg = "Data Berhasil Di Input";
         }
         

        $returndata = $error."|".$errmsg;

        echo $returndata;
       
    }



    public function ajax_save_kontrak(){
         $nik               = $this->input->get('nik');        
         $lamakontrak       = $this->input->get('lamakontrak');   
         $tglefektif        = $this->input->get('tglefektif');            
         $date              = str_replace('/', '-', $tglefektif );
         $tglefektif        = date("Y-m-d", strtotime($date));
         $remark            = $this->input->get('remark');   
         $jenismutasival    = $this->input->get('jenismutasival');   


         if($nik==0){
            $error  = true;
            $errmsg = "Harap Pilih NIK Terlebih Dahulu !!!";
         }

         if($lamakontrak==0){
            $error  = true;
            $errmsg = "Harap Pilih Lama Kontrak Terlebih Dahulu !!!";
         }

         if(strlen($jenismutasival)<1){
            $error  = true;
            $errmsg = "Jenis Mutasi Tidak Di Temukan !!!";
         }
     

         if(strlen($tglefektif)<10 || $tglefektif=="1970-01-01"){
            $error  = true;
            $errmsg = "Tanggal Efektif Belum Di Isi !!!";
         }



         if(!$error) {
            $this->db->select('*')
                 ->from('tbl_profile')
                 ->where('NIK', $nik);
             $db = $this->db->get();
             $data = $db->row(0);
             $statuspkwt              = $data->statuspkwt;

             $lamakontrakdata         = $data->lamakontrak;
             if(is_null($lamakontrakdata) || strlen($lamakontrakdata)<1) {
                $lamakontrakdata = 0;
             }

             $lamakontrakdata_PKWT2    = $data->lamakontrak_PKWT2;
             if(is_null($lamakontrakdata_PKWT2) || strlen($lamakontrakdata_PKWT2)<1){
                $lamakontrakdata_PKWT2 = 0;
             }

     

             $nik_absensi             = $data->NIK_Absensi;

             $startkontrak_first       = $data->startkontrak_first;
             $startkontrak             = $data->startkontrak;
             $endkontrak               = $data->endkontrak;             

             $startkontrak_first_PKWT2 = $data->startkontrak_first_PKWT2;
             $startkontrak_PKWT2       = $data->startkontrak_PKWT2;
             $endkontrak_PKWT2         = $data->endkontrak_PKWT2;                          

             if(strlen($nik_absensi<1)){
                $error  = true;
                $errmsg = "NIK Primary Tidak Di Temukan";
             }   
         }

         $this->db->select('*')
                  ->from('list_max_pkwt')
                  ->where('jenispkwt', $statuspkwt);
         $db = $this->db->get();
         $data = $db->row(0);
         $lamamaxpkwt  = $data->lamapkwt;

         if($statuspkwt=="PKWT1"){
            $startkontrak_new = date('Y-m-d', strtotime($endkontrak . ' +1 day'));
         } elseif ($statuspkwt=="PKWT2") {
            $startkontrak_new = date('Y-m-d', strtotime($endkontrak_PKWT2 . ' +1 day'));
         } else {
            $error  = true;
            $errmsg = "Status PKWT Tidak Di Temukan !";
         }


         if($statuspkwt=="PKWT1" && $lamakontrakdata==$lamamaxpkwt){            
             $statuspkwt   = "PKWT2";
             $pkwt2oldornew = "NEW";            
         } elseif ($statuspkwt=="PKWT1" && $lamakontrakdata+$lamakontrak>$lamamaxpkwt) {
             $error  = true;
             $errmsg = "Lama Kontrak Tersisa Untuk PKWT1 adalah </b> ".$lamamaxpkwt-$lamakontrakdata." Bulan </b>";
         } elseif ($statuspkwt=="PKWT2" && $lamakontrakdata_PKWT2+$lamakontrak>$lamamaxpkwt) {
             $error  = true;
             $errmsg = "Lama Kontrak Tersisa Untuk PKWT1 adalah </b> ".$lamamaxpkwt-$lamakontrakdata." Bulan </b>";
         } 





         if(!$error){

            $sql0 = $this->db->update("tbl_penyesuaian_karyawan",
                                array('bstatus' => 0,), 
                                array('nik'=>$nik));

            $sql = $this->db->insert("tbl_penyesuaian_karyawan",
                        array(                    
                            'nik_absensi' => $nik_absensi,
                            'nik' => $nik,
                            'jenis_penyesuaian' => $jenismutasival,
                            'statuskontrak_new' => 3,
                            'startkontrak' => $startkontrak_new,                            
                            'endkontrak' => $tglefektif,
                            'lamakontrak' => $lamakontrak,
                            'jenisPKWT' => $statuspkwt,
                            'tglefektif' => $startkontrak_new,                            
                            'createuser' => $this->cms_user_id(),
                            'createtime' => date('Y-m-d H:i:s'),
                            'updateuser' => $this->cms_user_id(),
                            'updatetime' => date('Y-m-d H:i:s'),
                            'bstatus' => 1,
                            'remarks' => $remark,
                        )
                    );
         }

         

         if($sql){

            if($statuspkwt=="PKWT1"){
                $sql2 = $this->db->update($this->cms_complete_table_name('profile'),
                            array('startkontrak' => $startkontrak_new,                                 
                                  'endkontrak' => $tglefektif,
                                  'statuspkwt' => $statuspkwt,
                                  'lamakontrak' => $lamakontrakdata+$lamakontrak,
                                  'lamakontrak_cur' => $lamakontrak,
                                  'UpdatedBy' => $this->cms_user_id(),
                                  'UpdatedTime' => date('Y-m-d H:i:s'),
                            ), 
                            array('NIK'=>$nik));
            } elseif ($statuspkwt=="PKWT2") {
                if($pkwt2oldornew=="NEW"){
                    $sql2 = $this->db->update($this->cms_complete_table_name('profile'),
                            array('startkontrak_first_PKWT2' => $startkontrak_new,
                                  'startkontrak_PKWT2' => $startkontrak_new,                                 
                                  'endkontrak_PKWT2' => $tglefektif,
                                  'statuspkwt' => $statuspkwt,
                                  'lamakontrak_PKWT2' => $lamakontrak,
                                  'lamakontrak_cur_PKWT2' => $lamakontrak,
                                  'UpdatedBy' => $this->cms_user_id(),
                                  'UpdatedTime' => date('Y-m-d H:i:s'),
                            ), 
                            array('NIK'=>$nik));
                } else {                    
                    $sql2 = $this->db->update($this->cms_complete_table_name('profile'),
                            array(
                                  'startkontrak_PKWT2' => $startkontrak_new,                                 
                                  'endkontrak_PKWT2' => $tglefektif,
                                  'statuspkwt' => $statuspkwt,
                                  'lamakontrak_PKWT2' => $lamakontrakdata_PKWT2+$lamakontrak,
                                  'lamakontrak_cur_PKWT2' => $lamakontrak,
                                  'UpdatedBy' => $this->cms_user_id(),
                                  'UpdatedTime' => date('Y-m-d H:i:s'),
                            ), 
                            array('NIK'=>$nik));
                }
            }

         }

         if($sql2){
            $error  = false;
            $errmsg = "Data Berhasil Di Input";
         }
         

        $returndata = $error."|".$errmsg;

        echo $returndata;
       
    }

//// MUTASI NIK ================================================================================================================================
    public function mutasi_nik($nik_lama,$nik_baru,$TglMasuk,$company){

        $today       = date('Y-m-d H:i:s');


        $this->db->select('NIK, Nama, Email')
                 ->from("tbl_profile")
                 ->where('NIK', $nik_baru);
        $db = $this->db->get();
        $row = $db->row(0);
        $num_row = $db->num_rows();


        $this->db->select('NIK, Nama, Email')
                 ->from("tbl_profile")
                 ->where('NIK', $nik_lama);
        $sql    = $this->db->get();
        $ws     = $sql->row(0);

        
        if(empty($nik_lama) || is_null($nik_lama)){
            $data = array('error' => true, 'message' => 'NIK lama harus diisi...');
        }
        elseif(empty($nik_baru) || is_null($nik_baru)){
            $data = array('error' => true, 'message' => 'NIK baru harus diisi...');
        }
        elseif(!is_numeric($nik_baru)){
            $data = array('error' => true, 'message' => 'NIK baru harus numeric...');
        }
        elseif($num_row > 0){
            $data = array('error' => true, 'message' => 'NIK baru sudah terdaftar sebelumnya, gunakan NIK yang lain...');
        }
        elseif(strlen($TglMasuk)<10){
            $data = array('error' => true, 'message' => 'Tgl Efektif harus diisi...');
        }            
        elseif(!$this->_callback_duplicate_row($nik_lama, $nik_baru, $company)){
            $data = array('error' => true, 'message' => 'Terjadi kesalahan pada koneksi database...');
        }                
        else{           
/*

            $this->mailer_employee_model->kirim_email_mutasi($nik_lama, $nik_baru, $ws->Nama, $ws->Email, $this->set_table_row('tbl_master_pergerakan_mutasi', 'mutasi_id', $mutasi_id, 'mutasi_name'));
*/  
            $data = array('error' => false, 'message' => 'berhasil');
        }        

        return $data;
    }


    private function _validate($nik_lama, $nik_baru)
    {

        $data = array();
        $data['status'] = TRUE;

        if($this->input->post('join_date') == '')
        {    
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            return FALSE;
        }
        else{
            return TRUE;
        }
    }

    public function _callback_duplicate_row($nik_lama, $nik_baru, $company){

        $this->db->select('NIK,Nama,Email')
                 ->from('tbl_profile')
                 ->where('NIK', $nik_baru);
        $db = $this->db->get();
        $data = $db->row(0);
        $num_row = $db->num_rows();

        if ($num_row > 0){
            return FALSE;
        }
        else{

            $this->Duplicate_MySQL_Record_Primary('tbl_profile', $primary_key_field='NIK', $nik_lama, $nik_baru);           

            $this->Duplicate_MySQL_Record_Secondary('tbl_profile_certification', $primary_key_field='CertId', $secondary_key_field='CertNIK', $nik_lama, $nik_baru, $status_field='CertStatus');
            
            $this->Duplicate_MySQL_Record_Secondary('tbl_profile_attachment', $primary_key_field='file_id', $secondary_key_field='file_nik', $nik_lama, $nik_baru, $status_field=NULL);

            $this->Duplicate_MySQL_Record_Secondary('tbl_profile_education', $primary_key_field='EduId', $secondary_key_field='EduNIK', $nik_lama, $nik_baru, $status_field='EduStatus');

            $this->Duplicate_MySQL_Record_Secondary('tbl_profile_files', $primary_key_field='file_id', $secondary_key_field='file_nik', $nik_lama, $nik_baru, $status_field='file_status');

            $this->Duplicate_MySQL_Record_Secondary('tbl_profile_member', $primary_key_field='MemberId', $secondary_key_field='NIK', $nik_lama, $nik_baru, $status_field=NULL);

            $this->Duplicate_MySQL_Record_Secondary('tbl_profile_projecthistory', $primary_key_field='ProjectId', $secondary_key_field='ProjectNIK', $nik_lama, $nik_baru, $status_field='ProjectStatus');

            $this->Duplicate_MySQL_Record_Secondary('tbl_profile_technicalskill', $primary_key_field='TechnicalSkillId', $secondary_key_field='TechnicalSkillNIK', $nik_lama, $nik_baru, $status_field='TechnicalSkillStatus');

            $this->Duplicate_MySQL_Record_Secondary('tbl_profile_training', $primary_key_field='TrainingId', $secondary_key_field='TrainingNIK', $nik_lama, $nik_baru, $status_field='TrainingStatus');

            $this->Duplicate_MySQL_Record_Secondary('tbl_profile_workexperience', $primary_key_field='WorkExpId', $secondary_key_field='WorkExpNIK', $nik_lama, $nik_baru, $status_field='WorkExpStatus');  
/* dimatiin karena sudah masuk ke Migrate_Cuti
            $this->Duplicate_MySQL_Record_Secondary('tbl_hakcuti', $primary_key_field='HakId', $secondary_key_field='NIK', $nik_lama, $nik_baru, $status_field=NULL);             
*/
            $this->Migrate_Cuti($nik_lama,$nik_baru,$company);

            /* JANGAN DI BUKA DLU
            $this->employee_model->sisa_hak_cuti_user($nik_lama, $nik_baru);
            $this->db->update('tbl_main_user', array('user_id'=> $nik_baru), array('user_id' => $nik_lama));
            $this->db->update('tbl_main_group_user', array('user_id'=> $nik_baru), array('user_id' => $nik_lama));
            $this->db->update('tbl_kpi_header_form', array('EmployeeID'=> $nik_baru), array('EmployeeID' => $nik_lama));
            */

            return TRUE;
        }
    }

    public function Migrate_Cuti($nik_lama,$nik_baru,$company){

        //insert ke hakcuti
        $mysqlcomm = "";
        $mysqlcomm = "
            INSERT INTO tbl_hakcuti
            SELECT @a:=@a+1 AS HakId, '".$nik_baru."' NIK, Periode1, Periode2, PeriodeKerja1, PeriodeKerja2, PeriodeExt,
            JenisHakCuti, Qty, QtyPakai, StatusHak, StatusMutasi, '".$company."' companyID, HakRemark, HakId AS HakId_old FROM (
            SELECT * FROM tbl_hakcuti WHERE nik = '".$nik_lama."') a,
            (SELECT @a:=MAX(HakId) FROM tbl_hakcuti) b
        ";
        $query = $this->db->query($mysqlcomm);
   
        
        //insert ke formcuti
        $mysqlcomm = "";
        $mysqlcomm = "
            INSERT INTO tbl_formcuti
            SELECT @a:=@a+1 AS CutiId, '".$nik_baru."' AS FormCutiNIK, EmployeeName, hakidnew AS HakCutiId, JenisCuti, JenisItemCuti, JenisItemCuti2, LocationCuti,
            StatusForm, Keperluan, Alamat, NoTelpon, Pengganti, NIKPengganti, TglActive1,
            TglActive2, TglMasuk, Detail, active_id, ApvLevel, NIK1, NIK2, NIK3, Apv1, Apv2,
            Apv3, Pin, Pin1, Pin2, Pin3, Tgl1, Tgl2, Tgl3, Remark1, Remark2, Remark3, CutiMasalId,
            CutiUtangId, CreatedBy, CreatedTime, UpdatedTime, Alasan, AlasanApv, SendMail, version, '".$company."' companyID, CutiID AS CutiId_old FROM (
            SELECT a.*,b.hakid AS hakidnew FROM tbl_formcuti a LEFT JOIN tbl_hakcuti b ON a.hakcutiid=b.hakid_old
            WHERE Formcutinik = '".$nik_lama."' AND HakCutiId > 0 ) a,
            (SELECT @a:=MAX(CutiId) FROM tbl_formcuti) b
        ";
        $query = $this->db->query($mysqlcomm);

        //insert ke formcutidetail
        $mysqlcomm = "";
        $mysqlcomm = "
            INSERT INTO tbl_formcutidetail
            SELECT @a:=@a+1,CutiIdnew, TglCuti, active_id, HakCutiIdnew, AllocationId, Keterangan FROM (
            SELECT DetailCutiId, b.CutiId AS CutiIdnew, TglCuti, a.active_id, b.HakCutiId AS HakCutiIdnew, AllocationId, Keterangan FROM (
            SELECT a.* FROM tbl_formcutidetail a, tbl_formcuti b
            WHERE a.CutiId=b.CutiId AND b.formcutinik = '".$nik_lama."' ) a,
            tbl_formcuti b WHERE a.cutiid=b.cutiid_old
            ) a, (SELECT @a:=MAX(DetailCutiId) FROM tbl_formcutidetail) b
        ";
        $query = $this->db->query($mysqlcomm);


    }


    public function Duplicate_MySQL_Record_Primary($table, $primary_key_field, $primary_key_val, $primary_key_new){
       /* generate the select query */
       $this->db->where($primary_key_field, $primary_key_val);        
       $query = $this->db->get($table);

        foreach ($query->result() as $row){   
            foreach($row as $key=>$val){        
                if($key != $primary_key_field){                    
                    $this->db->set($key, $val);               
                }
                else{
                    $this->db->set($key, $primary_key_new);
                }              
            }
        }

        /* insert the new record into table*/
        $this->db->insert($table);


        /* JANGAN DI MATIIN DULU
            $this->db->update($table, array('bStatus'=> 0), array($primary_key_field => $primary_key_val));
        */

        return TRUE;
    }

    public function Duplicate_MySQL_Record_Secondary($table, $primary_key_field, $secondary_key_field, $primary_key_val, $primary_key_new, $status_field){
       /* generate the select query */

        /*
        if(!empty($status_field) || !is_null($status_field)){

            $sql = $this->db->select($primary_key_field)
                        ->from($table)
                        ->where($secondary_key_field, $primary_key_val)
                        ->where($status_field, 1)
                        ->order_by($primary_key_field, 'ASC')           
                        ->get();
        }
        else{

            $sql = $this->db->select($primary_key_field)
                        ->from($table)
                        ->where($secondary_key_field, $primary_key_val)                        
                        ->order_by($primary_key_field, 'ASC')           
                        ->get();

        }
        */


        $sql = $this->db->select($primary_key_field)
                        ->from($table)
                        ->where($secondary_key_field, $primary_key_val)                        
                        ->order_by($primary_key_field, 'ASC')           
                        ->get();

        foreach($sql->result() as $data){

            $this->db->where($primary_key_field, $data->$primary_key_field);
            $query = $this->db->get($table);

            foreach ($query->result() as $row){   
                foreach($row as $key=>$val){        
                    if($key != $primary_key_field){                    
                        if($key == $secondary_key_field){
                            $this->db->set($key, $primary_key_new);
                        }
                        else{
                            $this->db->set($key, $val);
                        }                
                    }             
                }
            }


            /* insert the new record into table*/
            $this->db->insert($table);
        }

        return TRUE;
    }
//// MUTASI NIK ================================================================================================================================    

    public function check_endkontrak()
    {   
        $nik                 = $this->input->get('nik'); 
        $lamakontrak         = $this->input->get('lamakontrak'); 
        $tglendkontrak       = $this->input->get('tglendkontrak');                  
        $date                = str_replace('/', '-', $tglendkontrak);
        $tglendkontrak       = date("Y-m-d", strtotime($date));

        $this->db->select('*')
             ->from('tbl_profile')
             ->where('NIK', $nik);
         $db = $this->db->get();
         $data = $db->row(0);

         $startkontrak_first       = $data->startkontrak_first;
         $startkontrak             = $data->startkontrak;
         $endkontrak               = $data->endkontrak;
         $lamakontrak_data              = $data->lamakontrak;

         $startkontrak_first_PKWT2 = $data->startkontrak_first_PKWT2;
         $startkontrak_PKWT2       = $data->startkontrak_PKWT2;
         $endkontrak_PKWT2         = $data->endkontrak_PKWT2;
         $lamakontrak_data_PKWT2        = $data->lamakontrak_PKWT2;

         $statuspkwt                = $data->statuspkwt;



        $error  = false;
        $errmsg = "";

        if($statuspkwt=="PKWT1"){
            $tglmasuk = date('Y-m-d', strtotime($endkontrak . ' +1 day'));
         } elseif ($statuspkwt=="PKWT2") {
            $tglmasuk = date('Y-m-d', strtotime($endkontrak_PKWT2 . ' +1 day'));
         } else {
            $error = true;
            $final = "Tanggal Kontrak Tidak Di Temukan !";
         }
    
         if($nik==0){
            $error  = true;
            $errmsg = "Harap Pilih NIK Terlebih Dahulu !!!";
         }

        $query   = mysql_query("
                    SELECT * FROM (
                        SELECT awalkontrak,akhirkontrak,
                        DATE_ADD(akhirkontrak,INTERVAL -16 DAY) rangebawah,
                        DATE_ADD(akhirkontrak,INTERVAL 16 DAY) rangeatas FROM (
                        SELECT '".$tglmasuk."' AS awalkontrak,DATE_ADD(DATE_ADD('".$tglmasuk."',INTERVAL ".$lamakontrak." MONTH),INTERVAL -1 DAY) akhirkontrak FROM DUAL
                        ) a
                    ) a WHERE '".$tglendkontrak."'>=rangebawah AND '".$tglendkontrak."'<=rangeatas");
        



        $total   = mysql_num_rows($query);        
        
        if($total<1){
            $error  = true;
            $errmsg = "Tanggal End Kontrak Tidak sesuai";
        }            

        if($lamakontrak == "NK"){
            $error  = true;
            $errmsg = "Status Karyawan Bukan Kontrak";
        }


        echo $error."|".$errmsg;
 

    }

    public function set_endkontrak()
    {   
        $lamakontrak         = $this->input->get('lamakontrak'); 
        $nik                 = $this->input->get('nik'); 
    

        $error  = false;
        $errmsg = "";

        $this->db->select('*')
             ->from('tbl_profile')
             ->where('NIK', $nik);
         $db = $this->db->get();
         $data = $db->row(0);

         $startkontrak_first       = $data->startkontrak_first;
         $startkontrak             = $data->startkontrak;
         $endkontrak               = $data->endkontrak;
         $lamakontrak_data         = $data->lamakontrak;

         $startkontrak_first_PKWT2 = $data->startkontrak_first_PKWT2;
         $startkontrak_PKWT2       = $data->startkontrak_PKWT2;
         $endkontrak_PKWT2         = $data->endkontrak_PKWT2;
         $lamakontrak_data_PKWT2        = $data->lamakontrak_PKWT2;

         $statuspkwt                = $data->statuspkwt;

         if($statuspkwt=="PKWT1"){
            $tglmasuk = date('Y-m-d', strtotime($endkontrak . ' +1 day'));
         } elseif ($statuspkwt=="PKWT2") {
            $tglmasuk = date('Y-m-d', strtotime($endkontrak_PKWT2 . ' +1 day'));
         } else {
            $error = true;
            $final = "Tanggal Kontrak Tidak Di Temukan !";
         }

         if($nik==0){
            $error  = true;
            $final = "Harap Pilih NIK Terlebih Dahulu !!!";
         }

         if($lamakontrak==0){
            $error  = true;
            $final = "Harap Pilih Lama Kontrak Terlebih Dahulu !!!";
         }

        if(!$error && $lamakontrak<>"NK"){
            $mysqlcomm = "
                        SELECT DATE_FORMAT(DATE_ADD(tglberikut,INTERVAL -1 DAY),'%d/%m/%Y') tglberikut FROM (
                            SELECT
                              CASE WHEN DATE_FORMAT(tglkontrak,'%d') >= 15 THEN
                                DATE_FORMAT(DATE_ADD(tglkontrak,INTERVAL ".$lamakontrak."+1 MONTH),'%Y-%m-01')
                              ELSE
                                DATE_FORMAT(DATE_ADD(tglkontrak,INTERVAL ".$lamakontrak." MONTH),'%Y-%m-01') END tglberikut
                            FROM (
                            SELECT '".$tglmasuk."' tglkontrak FROM DUAL ) a
                            ) a
                        ";
            

            $query = $this->db->query($mysqlcomm);
            $data = $query->row(0);
            $final = $data->tglberikut;            
        }

        echo $error."|".$final;
    }


    public function get_datakontrak($nik)
    {        
        $mysqlcomm = "SELECT CASE WHEN startkontrak_first IS NOT NULL THEN
                                 CONCAT(DATE_FORMAT(startkontrak_first,'%d-%m-%Y'),' S/D ',DATE_FORMAT(endkontrak,'%d-%m-%Y'),' ( <b>',lamakontrak,' Bulan</b> )')
                               ELSE
                                 ' - ' END KontrakPKWT1,
                               CASE WHEN startkontrak_first_PKWT2 IS NOT NULL THEN
                                 CONCAT(DATE_FORMAT(startkontrak_first_PKWT2,'%d-%m-%Y'),' S/D ',DATE_FORMAT(endkontrak_PKWT2,'%d-%m-%Y'),' ( <b>',lamakontrak_PKWT2,' Bulan</b> )')
                               ELSE
                                 ' - ' END KontrakPKWT2,
                               CASE WHEN startkontrak IS NOT NULL THEN
                                 CONCAT(DATE_FORMAT(startkontrak,'%d-%m-%Y'),' S/D ',DATE_FORMAT(endkontrak,'%d-%m-%Y'),' ( <b>',lamakontrak_cur,' Bulan</b> )')
                               ELSE
                                 ' - ' END KontrakPKWT1_cur,
                               CASE WHEN startkontrak_first_PKWT2 IS NOT NULL THEN
                                 CONCAT(DATE_FORMAT(startkontrak_PKWT2,'%d-%m-%Y'),' S/D ',DATE_FORMAT(endkontrak_PKWT2,'%d-%m-%Y'),' ( <b>',lamakontrak_cur_PKWT2,' Bulan</b> )')
                               ELSE
                                 ' - ' END KontrakPKWT2_cur,
                                statuspkwt
                        FROM tbl_profile WHERE nik = '".$nik."'";

        
        $query = $this->db->query($mysqlcomm);
        $data = $query->row(0);

        if($data->statuspkwt=="PKWT1"){
            $KontrakCur = $data->KontrakPKWT1_cur;
        } elseif ($data->statuspkwt=="PKWT2") {
            $KontrakCur = $data->KontrakPKWT2_cur;
        } else {
            $KontrakCur = "-";
        }
        
        $this->db->select('*')
             ->from('tbl_profile')
             ->where('NIK', $nik);
         $db = $this->db->get();
         $dataprofile = $db->row(0);

         $statuspkwt                = $dataprofile->statuspkwt;
         $statuspkwtnew             = $dataprofile->statuspkwt;
         $lamakontrak_data          = $dataprofile->lamakontrak;
         $lamakontrak_data_PKWT2    = $dataprofile->lamakontrak_PKWT2;

        if($statuspkwt=="PKWT1"){
            $lamakontrak = $lamakontrak_data;
        } else {
            $lamakontrak = $lamakontrak_data_PKWT2;
        }

         $this->db->select('*')
                  ->from('list_max_pkwt')
                  ->where('jenispkwt', $statuspkwt);
         $db = $this->db->get();
         $data2 = $db->row(0);
         $lamamaxpkwt  = $data2->lamapkwt;
         $sisakontrak  = $lamamaxpkwt - $lamakontrak;

         if($statuspkwt=="PKWT1" && $lamakontrak==$lamamaxpkwt){            
             $statuspkwtnew   = "PKWT2";             
         } 


        $array = array("KontrakPKWT1" => $data->KontrakPKWT1, 
                       "KontrakPKWT2" => $data->KontrakPKWT2,
                       "KontrakCur"   => $KontrakCur,     
                       "statuspkwt"   => $statuspkwtnew,
                       "sisakontrak"  => $sisakontrak
                      );
        
        
        echo json_encode($array);
        exit;
    }

    public function get_lamakontrak($nik,$statuspkwt)
    {        

        $this->db->select('*')
             ->from('tbl_profile')
             ->where('NIK', $nik);
         $db = $this->db->get();
         $data = $db->row(0);

         $lamakontrakdata         = $data->lamakontrak;
         if(is_null($lamakontrakdata) || strlen($lamakontrakdata)<1) {
            $lamakontrakdata = 0;
         }
         $lamakontrakdata_PKWT2    = $data->lamakontrak_PKWT2;
         if(is_null($lamakontrakdata_PKWT2) || strlen($lamakontrakdata_PKWT2)<1){
            $lamakontrakdata_PKWT2 = 0;
         }
  
               
         $this->db->select('*')
                  ->from('list_max_pkwt')
                  ->where('jenispkwt', $statuspkwt);
         $db = $this->db->get();
         $data = $db->row(0);
         $lamamaxpkwt  = $data->lamapkwt;

         if($statuspkwt=="PKWT1"){
            $lamakontrak = $lamakontrakdata;
         } elseif ($statuspkwt=="PKWT2") {
            $lamakontrak = $lamakontrakdata_PKWT2;
         }


         $sisakontrak = $lamamaxpkwt-$lamakontrak;



        $this->db->select("*")
                 ->from('tbl_list_kontrak')
                 ->where('kontrak_id<=', $sisakontrak)
                 ->where('kontrak_id!=', 'NK')
                 ->where('kontrak_status','1')
                 ->order_by('kontrak_ordinal');
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
           $array[] = array("value" => $row->kontrak_id, "property" => $row->kontrak_desc);
        endforeach;
        
        echo json_encode($array);
        exit;
    }


}