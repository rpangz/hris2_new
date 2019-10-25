<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class report_IX_karyawan_in_out extends CMS_Priv_Strict_Controller {



    public $corescr = "SELECT a.nik,nama,lamakontrak,sex,bandskrg,JobFungsionalName,
                        CASE WHEN sex='P' THEN 'TK-0' ELSE (CASE WHEN statusdiri=1 THEN 'TK-0' ELSE CONCAT('K-',CASE WHEN anak IS NULL THEN 0 ELSE anak END) END) END AS TKINOUT,
                        CONCAT(CASE WHEN cDivName IS NULL THEN '' ELSE cDivName END,' / ',CASE WHEN cDeptName IS NULL THEN '' ELSE cDeptName END) divdept,
                        TglMasuk,NoNPWP,norek,cabangrek,NoKTP,alamatktp,KDDESA kel,NMPROP,NMDATI2,NMKEC,startkontrak,endkontrak,newkontrak,tglkeluar,
                        DATE_ADD(tglkeluar, INTERVAL -1 DAY) AS hariterakhir,a.CompanyID,cCompanyName,
                        a.bStatus,DATE_ADD(newkontrak,INTERVAL -1 DAY) akhiroff,status,DATE_ADD(tglkeluar,INTERVAL -1 DAY) akhirresign,agama_name
                        FROM tbl_profile a
                        LEFT JOIN tbl_job_fungsional b ON a.JobID=b.JobFungsionalID
                        LEFT JOIN (SELECT nik,COUNT(1) anak FROM tbl_profile_member WHERE MemberStatus = 3 GROUP BY nik) c ON a.nik=c.nik
                        LEFT JOIN tbl_div d ON a.DivisiID=d.iDivId
                        LEFT JOIN tbl_dept e ON a.DeptID=e.iDeptID
                        LEFT JOIN tbl_unit f ON a.UnitID=f.unitID
                        LEFT JOIN tbl_propinsi g ON a.KDPROP=g.KDPROP
                        LEFT JOIN tbl_dati2 h ON a.KDDATI2=h.KDDATI2
                        LEFT JOIN tbl_kec i ON a.KDKEC=i.KDKEC
                        LEFT JOIN tbl_company j ON a.CompanyID=j.iCompanyID
                        LEFT JOIN tbl_agama l ON a.Agama=l.agama_id
                        WHERE (DATE_FORMAT(tglmasuk,'%Y%m')='|blnproses|') OR
                              (DATE_FORMAT(startkontrak,'%Y%m')='|blnproses|') OR
                              (DATE_FORMAT(endkontrak,'%Y%m')='|blnproses|') OR
                              (a.status = '4' AND DATE_FORMAT(DATE_ADD(newkontrak,INTERVAL -1 DAY),'%Y%m')='|blnproses|') OR
                              (DATE_FORMAT(tglkeluar,'%Y%m')='|blnproses|')";


    public $corescrbpjskes = "
                        SELECT
                        a.nik,a.nama,a.sex,bandskrg,CASE WHEN cDivName IS NULL THEN '' ELSE cDivName END divisi,
                        CASE WHEN cDeptName IS NULL THEN '' ELSE cDeptName END dept,                                               
                        TglMasuk,tglkeluar,
                        DATE_ADD(tglkeluar, INTERVAL -1 DAY) AS hariterakhir,a.CompanyID,cCompanyName,
                        a.bStatus,tptlahir,tgllahir,FLOOR(DATEDIFF(current_date(),tgllahir)/365) AS usia,
                        CASE WHEN statusdiri=1 THEN 'TK-0' ELSE CONCAT('K-',CASE WHEN anak IS NULL THEN 0 ELSE anak END) END AS TKINOUT,
                        bloodtype,noktp,nonpwp,CASE WHEN NoBpjsLama IS NULL THEN '-' ELSE NoBpjsLama END NoBpjsLama,'YA' BpjsPensiun,k.mothername,nik_old,agama_name,alamatktp,a.KDDESA kel,NMPROP,NMDATI2,NMKEC
                        FROM tbl_profile a
                        LEFT JOIN tbl_job_fungsional b ON a.JobID=b.JobFungsionalID
                        LEFT JOIN (SELECT nik,COUNT(1) anak FROM tbl_profile_member WHERE MemberStatus = 3 GROUP BY nik) c ON a.nik=c.nik
                        LEFT JOIN tbl_div d ON a.DivisiID=d.iDivId
                        LEFT JOIN tbl_dept e ON a.DeptID=e.iDeptID
                        LEFT JOIN tbl_unit f ON a.UnitID=f.unitID
                        LEFT JOIN tbl_propinsi g ON a.KDPROP=g.KDPROP
                        LEFT JOIN tbl_dati2 h ON a.KDDATI2=h.KDDATI2
                        LEFT JOIN tbl_kec i ON a.KDKEC=i.KDKEC
                        LEFT JOIN tbl_company j ON a.CompanyID=j.iCompanyID
                        LEFT JOIN (SELECT * FROM tbl_bpjs WHERE LENGTH(NoBpjsLama)>5 AND PISA = 1) k ON a.nik=k.nik
                        LEFT JOIN tbl_agama l ON a.Agama=l.agama_id
                        WHERE
                        (DATE_FORMAT(DATE_ADD('|blnproses|',INTERVAL -3 MONTH),'%m%Y') = DATE_FORMAT(tglmasuk,'%m%Y') AND DATE_FORMAT(tglmasuk,'%d')<=15) OR
                        (DATE_FORMAT(DATE_ADD('|blnproses|',INTERVAL -4 MONTH),'%m%Y') = DATE_FORMAT(tglmasuk,'%m%Y') AND DATE_FORMAT(tglmasuk,'%d')>15) OR
                        (DATE_FORMAT(DATE_ADD('|blnproses|',INTERVAL -1 MONTH),'%m%Y') = DATE_FORMAT(tglkeluar,'%m%Y'))
                        ";



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
        $this->view($this->cms_module_path().'/report_IX_karyawan_in_out_view', $output,
        $this->cms_complete_navigation_name('report_IX_karyawan_in_out'));    
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
        $output->blnproses = $this->get_bulan_proses();
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





    public function ajax_load_data(){
        $jenis         = $this->input->get('jenis');
        $blnproses         = $this->input->get('blnproses');        
        /*
        $tglfr         = $this->input->get('tglfr');
        $tglto         = $this->input->get('tglto');
        */
        //$tglfr = date("Y-m-d", strtotime($tglfr));
        //$tglto = date("Y-m-d", strtotime($tglto));
        
        /*
        $tglfr = date_format($tglfr,"Y-m-d");
        $tglto = date_format($tglto,"Y-m-d");
        */
        $payroll       =  $this->loaddata_payroll_inout($jenis,$blnproses);
        $bpjskesehatan =  $this->loaddata_bpjskes_inout($jenis,$blnproses); 
        $bpjstk        =  $this->loaddata_bpjstk_inout($jenis,$blnproses); 

        $htmldata = '';
        $htmldata .= '<div class="tab">
                          <button class="tablinks" onclick="openCity(event, \'payroll\')" id="defaultOpen">Payroll</button>
                          <button class="tablinks" onclick="openCity(event, \'bpjskesehatan\')">BPJS Kesehatan</button>
                          <button class="tablinks" onclick="openCity(event, \'bpjstk\')">BPJS Ketenagakerjaan</button>
                      </div>';


        $exportlinkpayroll = site_url('report/report_IX_karyawan_in_out/loaddata_payroll_inout_excell/').'?jenis='.$jenis.'&blnproses='.$blnproses;
        $exportlinkbpjskes = site_url('report/report_IX_karyawan_in_out/loaddata_bpjskes_inout_excell/').'?jenis='.$jenis.'&blnproses='.$blnproses;
        $exportlinkbpjstk  = site_url('report/report_IX_karyawan_in_out/loaddata_bpjstk_inout_excell/').'?jenis='.$jenis.'&blnproses='.$blnproses;               

        $htmldata .= '<div id="payroll" class="tabcontent">
                            <a href='.$exportlinkpayroll.'><img src="https://'.$_SERVER['SERVER_NAME'].'/hris2/images/icn-excel.png" alt="Download Excel" width="25" class="img-responsive"/></a>    
                            '.$payroll.'
                      </div>';

        $htmldata .= '<div id="bpjskesehatan" class="tabcontent">
                            <a href='.$exportlinkbpjskes.'><img src="https://'.$_SERVER['SERVER_NAME'].'/hris2/images/icn-excel.png" alt="Download Excel" width="25" class="img-responsive"/></a>
                          '.$bpjskesehatan.' 
                      </div>';

        $htmldata .= '<div id="bpjstk" class="tabcontent">
                        <a href='.$exportlinkbpjstk.'><img src="https://'.$_SERVER['SERVER_NAME'].'/hris2/images/icn-excel.png" alt="Download Excel" width="25" class="img-responsive"/></a>
                        '.$bpjstk.'
                      </div>';

        echo $htmldata;                      
        
    }


    public function loaddata_payroll_inout($jenis,$blnproses){
        $scr = $this->corescr;
        $scr = str_replace("|blnproses|",$blnproses,$scr);

        $htmldetail = '';
        if($jenis=="inout"){
             $scrgroup = "SELECT CompanyID,cCompanyName FROM ( ".$scr." ) a GROUP BY cCompanyName";
             $querygroup = $this->db->query($scrgroup);    
             foreach ($querygroup->result() as $rowgroup) {
                $headerpttitle = $rowgroup->cCompanyName;
                $headerptid    = $rowgroup->CompanyID;

                $htmldetail .= '<table style="width: 100%;text-align: center;font-weight: bold;"><tr><td style="width: 100%;text-align: center;" colspan=10><h4><u>'.$headerpttitle.'</u></h4></td></tr></table>';

                // KARYAWAN MASUK ========================================================================================================================
                $scrgroupdetail   = '';
                $querygroupdetail = '';
                $totaldata        =  0;

                $scrgroupdetail = "SELECT * FROM ( ".$scr." ) a WHERE CompanyID = '".$headerptid."' 
                                   AND (DATE_FORMAT(tglmasuk,'%Y%m')='".$blnproses."')";
                $querygroupdetail = $this->db->query($scrgroupdetail);
                $totaldata = 0;
                $totaldata = $querygroupdetail->num_rows();
                if($totaldata>0){                    
                    $htmldetail .= '<b>KARYAWAN MASUK</b>';    
                    $htmldetail .= '<table class="ReportTable" id="datareport">
                                      <thead>
                                          <tr>
                                              <th style="width:5px;">NO</th>
                                              <th style="width:20px;">NIK</th>
                                              <th style="width:150px;">NAMA</th>
                                              <th style="width:30px;">STATUS</th>
                                              <th style="width:10px;">SEX</th>
                                              <th style="width:15px;">BD</th>
                                              <th style="width:100px;">JABATAN</th>
                                              <th style="width:50px;">TK/K</th>
                                              <th style="width:200px;">DIV / DEPT / </th>
                                              <th style="width:70px;">PER TGL</th>
                                              <th style="width:100px;">NO NPWP</th>
                                              <th style="width:100px;">NOREK BCA</th>
                                              <th style="width:70px;">CABANG</th>
                                              <th style="width:100px;">E-KTP</th>                                            
                                          </tr>
                                      </thead>
                                      <tbody>';
                    $no = 0;                  
                    foreach ($querygroupdetail->result() as $rowgroupdetail) {
                        $no += 1;
                        $htmldetail .= '<tr>                                          
                                          <td>'.$no.'</td>
                                          <td>'.$rowgroupdetail->nik.'</td>
                                          <td>'.$rowgroupdetail->nama.'</td>
                                          <td style="text-align: center">'.$rowgroupdetail->lamakontrak.'</td>
                                          <td style="text-align: center">'.$rowgroupdetail->sex.'</td>
                                          <td style="text-align: center">'.$rowgroupdetail->bandskrg.'</td>
                                          <td>'.$rowgroupdetail->JobFungsionalName.'</td>
                                          <td style="text-align: center">'.$rowgroupdetail->TKINOUT.'</td>
                                          <td>'.$rowgroupdetail->divdept.'</td>
                                          <td style="text-align: center">'.$this->date_format_txt($rowgroupdetail->TglMasuk).'</td>
                                          <td>'.$this->npwp_format_txt($rowgroupdetail->NoNPWP).'</td>
                                          <td>'.$rowgroupdetail->norek.'</td>
                                          <td>'.$rowgroupdetail->cabangrek.'</td>
                                          <td>'.$rowgroupdetail->NoKTP.'</td>                                        
                                        </tr>
                                        <tr>            
                                              <td></td>    
                                              <td colspan="7">Alamat KTP : Pinang Ranti RT 002, RW 002, Kel. Pinang Ranti, Kec. Makasar, Jakarta Timur, DKI Jakarta</td>
                                              <td colspan="6">Alamat NPWP : Sama dengan KTP</td>
                                        </tr>';     

                    } //tutup foreach querygroupdetail    

                    $htmldetail .= '</tbody></table><br>'; //TUTUP TABLE KARYAWAN MASUK                    

                } //TUTUP IF TOTAL DATA > 0
                //============================== TUTUP KARYAWAN MASUK =======================================================================

                // KARYAWAN DIPERPANJANG =============================================================================================================================
                $scrgroupdetail   = '';
                $querygroupdetail = '';
                $totaldata        =  0;

                $scrgroupdetail = "SELECT * FROM ( ".$scr." ) a WHERE CompanyID = '".$headerptid."' AND (DATE_FORMAT(startkontrak,'%Y%m')='".$blnproses."')";


                $querygroupdetail = $this->db->query($scrgroupdetail);
                $totaldata = 0;
                $totaldata = $querygroupdetail->num_rows();
                if($totaldata>0){     
                    $htmldetail .= '<b>KWT DIPERPANJANG</b>';    
                    $htmldetail .= '<table class="ReportTable" id="datareport">
                                      <thead>
                                          <tr>
                                              <th>No</th>
                                              <th>NIK</th>
                                              <th>NAMA</th>
                                              <th>STATUS</th>
                                              <th>SEX</th>
                                              <th>BD</th>
                                              <th>JABATAN</th>              
                                              <th>Div / Dept</th>
                                              <th>KWT 1</th>
                                              <th>KWT 2</th>
                                              <th>KETERANGAN</th>              
                                          </tr>
                                      </thead>
                                      <tbody>';
                    $no = 0;                  
                    foreach ($querygroupdetail->result() as $rowgroupdetail) {
                        $no += 1;
                        $htmldetail .= '<tr>
                                          <td>'.$no.'</td>
                                          <td>'.$rowgroupdetail->nik.'</td>
                                          <td>'.$rowgroupdetail->nama.'</td>
                                          <td style="text-align: center">'.$rowgroupdetail->lamakontrak.'</td>
                                          <td style="text-align: center">'.$rowgroupdetail->sex.'</td>
                                          <td style="text-align: center">'.$rowgroupdetail->bandskrg.'</td>
                                          <td>'.$rowgroupdetail->JobFungsionalName.'</td>                                          
                                          <td>'.$rowgroupdetail->divdept.'</td>
                                          <td style="text-align: center">'.$this->date_format_txt($rowgroupdetail->startkontrak).'</td>
                                          <td style="text-align: center">'.$this->date_format_txt($rowgroupdetail->endkontrak).'</td>
                                          <td></td>                                          
                                      </tr>';     

                    } //tutup foreach querygroupdetail    

                    $htmldetail .= '</tbody></table><br>'; //TUTUP TABLE KARYAWAN MASUK                    

                } //TUTUP IF TOTAL DATA > 0
                //============================== KARYAWAN DIPERPANJANG =======================================================================

                // KARYAWAN 1 BULAN KEDEPAN AKAN MEMASUKI OFF ================================================================================
                $scrgroupdetail   = '';
                $querygroupdetail = '';
                $totaldata        =  0;

                $scrgroupdetail = "SELECT * FROM ( ".$scr." ) a WHERE CompanyID = '".$headerptid."' AND (DATE_FORMAT(endkontrak,'%Y%m')='".$blnproses."')";
                
                $querygroupdetail = $this->db->query($scrgroupdetail);
                $totaldata = 0;
                $totaldata = $querygroupdetail->num_rows();
                if($totaldata>0){     
                    $htmldetail .= '<b>KARYAWAN 1 BULAN KEDEPAN AKAN MEMASUKI OFF</b>';    
                    $htmldetail .= '<table class="ReportTable" id="datareport">
                                      <thead>
                                          <tr>
                                              <th>NO</th>
                                              <th>NIK</th>
                                              <th>NAMA</th>
                                              <th>JABATAN</th>              
                                              <th>BD</th>              
                                              <th>Div / Dept</th>
                                              <th>HARI TERAKHIR</th>            
                                              <th>KETERANGAN</th>              
                                          </tr>
                                      </thead>
                                      <tbody>';
                    $no = 0;                  
                    foreach ($querygroupdetail->result() as $rowgroupdetail) {
                        $no += 1;
                        $htmldetail .= '<tr>
                                          <td>'.$no.'</td>
                                          <td>'.$rowgroupdetail->nik.'</td>
                                          <td>'.$rowgroupdetail->nama.'</td>
                                          <td>'.$rowgroupdetail->JobFungsionalName.'</td>                                          
                                          <td style="text-align: center">'.$rowgroupdetail->bandskrg.'</td>
                                          <td>'.$rowgroupdetail->divdept.'</td>                                          
                                          <td style="text-align: center">'.$this->date_format_txt($rowgroupdetail->endkontrak).'</td>
                                          <td></td>                                          
                                      </tr>';     

                    } //tutup foreach querygroupdetail    

                    $htmldetail .= '</tbody></table><br>'; //TUTUP TABLE KARYAWAN MASUK                    

                } //TUTUP IF TOTAL DATA > 0
                //============================== KARYAWAN 1 BULAN KEDEPAN AKAN MEMASUKI OFF ===================================================

                // KARYAWAN OFF ===============================================================================================================
                $scrgroupdetail   = '';
                $querygroupdetail = '';
                $totaldata        =  0;

                $scrgroupdetail = "SELECT * FROM ( ".$scr." ) a WHERE CompanyID = '".$headerptid."' AND (a.status = '4' AND DATE_FORMAT(DATE_ADD(newkontrak,INTERVAL -1 DAY),'%Y%m')='".$blnproses."')";

                $querygroupdetail = $this->db->query($scrgroupdetail);
                $totaldata = 0;
                $totaldata = $querygroupdetail->num_rows();
                if($totaldata>0){     
                    $htmldetail .= '<b>KARYAWAN OFF</b>';    
                    $htmldetail .= '<table class="ReportTable" id="datareport">
                                      <thead>
                                          <tr>
                                              <th>NO</th>
                                              <th>NIK</th>
                                              <th>NAMA</th>
                                              <th>JABATAN</th>              
                                              <th>BD</th>              
                                              <th>Div / Dept</th>
                                              <th>TERAKHIR OFF</th>
                                              <th>TGL KARYAWAN BARU</th>            
                                              <th>KETERANGAN</th>              
                                          </tr>
                                      </thead>
                                      <tbody>';
                    $no = 0;                  
                    foreach ($querygroupdetail->result() as $rowgroupdetail) {
                        $no += 1;
                        $htmldetail .= '<tr>
                                          <td>'.$no.'</td>
                                          <td>'.$rowgroupdetail->nik.'</td>
                                          <td>'.$rowgroupdetail->nama.'</td>
                                          <td>'.$rowgroupdetail->JobFungsionalName.'</td>                                          
                                          <td style="text-align: center">'.$rowgroupdetail->bandskrg.'</td>
                                          <td>'.$rowgroupdetail->divdept.'</td>                                          
                                          <td style="text-align: center">'.$this->date_format_txt($rowgroupdetail->endkontrak).'</td>
                                          <td></td>                                          
                                      </tr>';     

                    } //tutup foreach querygroupdetail    

                    $htmldetail .= '</tbody></table><br>'; //TUTUP TABLE KARYAWAN MASUK                    

                } //TUTUP IF TOTAL DATA > 0
                //============================== KARYAWAN OFF ==============================================================================

                // LAIN LAIN ===============================================================================================================
                $scrgroupdetail   = '';
                $querygroupdetail = '';
                $totaldata        =  0;

                    $htmldetail .= '<b>LAIN LAIN</b>';    
                    $htmldetail .= '<table class="ReportTable" id="datareport">
                                      <thead>
                                          <tr>
                                              <th>NO</th>
                                              <th>NIK</th>
                                              <th>NAMA</th>
                                              <th>JABATAN</th>              
                                              <th>BD</th>              
                                              <th>Div / Dept</th>
                                              <th>PER TGL</th>            
                                              <th>KETERANGAN</th>              
                                          </tr>
                                      </thead>
                                      <tbody>
                                            <tr>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>                                          
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>                                          
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>                                          
                                            </tr></tbody></table><br>';
                   
                //============================== LAIN LAIN ==============================================================================
                // KARYAWAN KELUAR =======================================================================================================
                $scrgroupdetail   = '';
                $querygroupdetail = '';
                $totaldata        =  0;

                $scrgroupdetail = "SELECT * FROM ( ".$scr." ) a WHERE CompanyID = '".$headerptid."' AND (DATE_FORMAT(tglkeluar,'%Y%m')='".$blnproses."')";

                $querygroupdetail = $this->db->query($scrgroupdetail);
                $totaldata = 0;
                $totaldata = $querygroupdetail->num_rows();
                if($totaldata>0){     
                    $htmldetail .= '<b>KARYAWAN KELUAR</b>';    
                    $htmldetail .= '<table class="ReportTable" id="datareport">
                                      <thead>
                                          <tr>
                                              <th>NO</th>
                                              <th>NIK</th>
                                              <th>NAMA</th>
                                              <th>JABATAN</th>              
                                              <th>BD</th>              
                                              <th>Div / Dept</th>
                                              <th>TGL TERAKHIR</th>
                                              <th>TGL RESIGN</th>            
                                              <th>KETERANGAN</th>              
                                          </tr>
                                      </thead>
                                      <tbody>';
                    $no = 0;                  
                    foreach ($querygroupdetail->result() as $rowgroupdetail) {
                        $no += 1;
                        $htmldetail .= '<tr>
                                          <td>'.$no.'</td>
                                          <td>'.$rowgroupdetail->nik.'</td>
                                          <td>'.$rowgroupdetail->nama.'</td>
                                          <td>'.$rowgroupdetail->JobFungsionalName.'</td>                                          
                                          <td style="text-align: center">'.$rowgroupdetail->bandskrg.'</td>
                                          <td>'.$rowgroupdetail->divdept.'</td>                                          
                                          <td style="text-align: center">'.$this->date_format_txt($rowgroupdetail->akhirresign).'</td>
                                          <td style="text-align: center">'.$this->date_format_txt($rowgroupdetail->tglkeluar).'</td>
                                          <td></td>                                          
                                      </tr>';     

                    } //tutup foreach querygroupdetail    

                    $htmldetail .= '</tbody></table><br>'; //TUTUP TABLE KARYAWAN MASUK                    

                } //TUTUP IF TOTAL DATA > 0
                //============================== KARYAWAN KELUAR ===================================                                           

             }// TUTUP IF IN OUT 
        }


        return $htmldetail;
    }


    public function loaddata_bpjskes_inout($jenis,$blnproses){
        $tahun = substr($blnproses, 0, 4);
        $bulan = substr($blnproses, 4, 2);
        $blnprosesstr = $tahun.'-'.$bulan.'-01'; 
        $scr = $this->corescrbpjskes;        
        $scr = str_replace("|blnproses|",$blnprosesstr,$scr);

        $htmldetail = '';
        if($jenis=="inout"){
             // KARYAWAN MASUK ========================================================================================================================
             $scrgroup = "SELECT CompanyID,cCompanyName FROM ( ".$scr." ) a GROUP BY cCompanyName";
             $querygroup = $this->db->query($scrgroup);   
             $htmldetail .= '<table style="width: 100%;text-align: center;font-weight: bold;"><tr><td colspan="9"><h4><u>PESERTA MASUK</u></h4></td></tr></table>'; 
             foreach ($querygroup->result() as $rowgroup) {
                $headerpttitle = $rowgroup->cCompanyName;
                $headerptid    = $rowgroup->CompanyID;
                
                
                $scrgroupdetail   = '';
                $querygroupdetail = '';
                $totaldata        =  0;

                $scrgroupdetail = "SELECT * FROM ( ".$scr." ) a WHERE CompanyID = '".$headerptid."' 
                                   AND ((DATE_FORMAT(DATE_ADD('".$blnprosesstr."',INTERVAL -3 MONTH),'%m%Y') = DATE_FORMAT(tglmasuk,'%m%Y') 
                                   AND DATE_FORMAT(tglmasuk,'%d')<=15)
                                   OR (DATE_FORMAT(DATE_ADD('".$blnprosesstr."',INTERVAL -4 MONTH),'%m%Y') = DATE_FORMAT(tglmasuk,'%m%Y') 
                                   AND DATE_FORMAT(tglmasuk,'%d')>15))";
                $querygroupdetail = $this->db->query($scrgroupdetail);
                $totaldata = 0;
                $totaldata = $querygroupdetail->num_rows();
                if($totaldata>0){                    
                    $htmldetail .= '<b>'.$headerpttitle.'</b>';    
                    $htmldetail .= '<table class="ReportTable" id="datareport">
                                      <thead>
                                          <tr>
                                              <th>NO</th>
                                              <th style="width:50px;">NIK</th>
                                              <th style="width:150px;">NAMA</th>
                                              <th style="width:10px;">BAND</th>
                                              <th style="width:80px;">TGL LAHIR</th>
                                              <th style="width:250px;">DIVISI/DIREKTORAT</th>
                                              <th style="width:250px;">DEPARTMENT</th>
                                              <th>JK</th>
                                              <th>HUBUNGAN KELUARGA</th>
                                              <th>KETERANGAN</th>
                                          </tr>
                                      </thead>
                                      <tbody>';
                    $no = 0;                  
                    foreach ($querygroupdetail->result() as $rowgroupdetail) {
                        $no += 1;
                        $htmldetail .= '<tr>
                                          <td>'.$no.'</td>
                                          <td>'.$rowgroupdetail->nik.'</td>
                                          <td>'.$rowgroupdetail->nama.'</td>
                                          <td style="text-align: center">'.$rowgroupdetail->bandskrg.'</td>
                                          <td style="text-align: center">'.$this->date_format_txt($rowgroupdetail->tgllahir).'</td>
                                          <td>'.$rowgroupdetail->divisi.'</td>
                                          <td>'.$rowgroupdetail->dept.'</td>
                                          <td style="text-align: center">'.$rowgroupdetail->sex.'</td>                                          
                                          <td style="text-align:center"> - </td>
                                          <td></td>                                          
                                      </tr>';     

                    } //tutup foreach querygroupdetail    

                    $htmldetail .= '</tbody></table><br>'; //TUTUP TABLE KARYAWAN MASUK                    

                } //TUTUP IF TOTAL DATA > 0
                //============================== TUTUP KARYAWAN MASUK ================================================================================

             } // TUTUP LOOP PESERTA MASUK 


//=====================================================================================================================================================

             // PESERTA KELUAR ========================================================================================================================
             $scrgroup = "SELECT CompanyID,cCompanyName FROM ( ".$scr." ) a GROUP BY cCompanyName";
             $querygroup = $this->db->query($scrgroup);   
             $htmldetail .= '<table style="width: 100%;text-align: center;font-weight: bold;"><tr><td colspan="9" style="width: 100%;text-align:center;"><h4><u>PESERTA KELUAR</u></h4></td></tr></table>'; 
             foreach ($querygroup->result() as $rowgroup) {
                $headerpttitle = $rowgroup->cCompanyName;
                $headerptid    = $rowgroup->CompanyID;
                
                
                $scrgroupdetail   = '';
                $querygroupdetail = '';
                $totaldata        =  0;

                $scrgroupdetail = "SELECT * FROM ( ".$scr." ) a WHERE CompanyID = '".$headerptid."' 
                                   AND (DATE_FORMAT(DATE_ADD('".$blnprosesstr."',INTERVAL -1 MONTH),'%m%Y') = DATE_FORMAT(tglkeluar,'%m%Y'))";

                $querygroupdetail = $this->db->query($scrgroupdetail);
                $totaldata = 0;
                $totaldata = $querygroupdetail->num_rows();
                if($totaldata>0){                    
                    $htmldetail .= '<b>'.$headerpttitle.'</b>';    
                    $htmldetail .= '<table class="ReportTable" id="datareport" style="width:100%;">
                                      <thead>
                                          <tr>
                                              <th style="width:2%;">NO</th>
                                              <th style="width:50px;">NIK</th>
                                              <th style="width:150px;">NAMA</th>
                                              <th style="width:10px;">BAND</th>
                                              <th style="width:80px;">TGL LAHIR</th>
                                              <th style="width:250px;">DIVISI/DIREKTORAT</th>
                                              <th style="width:250px;">DEPARTMENT</th>
                                              <th style="width:5%;">JK</th>
                                              <th style="width:5%;">HUBUNGAN KELUARGA</th>
                                              <th>KETERANGAN</th>
                                          </tr>
                                      </thead>
                                      <tbody>';
                    $no = 0;                  
                    foreach ($querygroupdetail->result() as $rowgroupdetail) {
                        $no += 1;
                        $htmldetail .= '<tr>
                                          <td>'.$no.'</td>
                                          <td>'.$rowgroupdetail->nik.'</td>
                                          <td>'.$rowgroupdetail->nama.'</td>
                                          <td style="text-align: center">'.$rowgroupdetail->bandskrg.'</td>
                                          <td style="text-align: center">'.$this->date_format_txt($rowgroupdetail->tgllahir).'</td>
                                          <td>'.$rowgroupdetail->divisi.'</td>
                                          <td>'.$rowgroupdetail->dept.'</td>
                                          <td style="text-align: center">'.$rowgroupdetail->sex.'</td>                                          
                                          <td style="text-align:center"> - </td>
                                          <td></td>                                          
                                      </tr>';     

                    } //tutup foreach querygroupdetail    

                    $htmldetail .= '</tbody></table><br>'; //TUTUP TABLE KARYAWAN MASUK                    

                } //TUTUP IF TOTAL DATA > 0
                //============================== TUTUP PESERTA MASUK =======================================================================

             } // TUTUP LOOP PESERTA KELUAR 

        } // TUTUP IF IN OUT 


        return $htmldetail;
    }


    public function loaddata_bpjstk_inout($jenis,$blnproses){
        $tahun = substr($blnproses, 0, 4);
        $bulan = substr($blnproses, 4, 2);
        $blnprosesstr = $tahun.'-'.$bulan.'-01'; 
        $scr = $this->corescrbpjskes;
        $scr = str_replace("|blnproses|",$blnprosesstr,$scr);

        


        $htmldetail = '';
        if($jenis=="inout"){
             $scrgroup = "SELECT CompanyID,cCompanyName FROM ( ".$scr." ) a GROUP BY cCompanyName";
             $querygroup = $this->db->query($scrgroup); 
             $htmldetail .= '<table style="width: 100%;text-align: center;font-weight: bold;"><tr><td style="width: 100%;text-align:center;" colspan="16"><h4><u>PESERTA MASUK</u></h4></td></tr></table>';   
             foreach ($querygroup->result() as $rowgroup) {
                $headerpttitle = $rowgroup->cCompanyName;
                $headerptid    = $rowgroup->CompanyID;
                

                // KARYAWAN MASUK ========================================================================================================================
                $scrgroupdetail   = '';
                $querygroupdetail = '';
                $totaldata        =  0;

                $scrgroupdetail = "SELECT * FROM ( ".$scr." ) a WHERE CompanyID = '".$headerptid."' AND 
                                   ((DATE_FORMAT(DATE_ADD('".$blnprosesstr."',INTERVAL -3 MONTH),'%m%Y') = DATE_FORMAT(tglmasuk,'%m%Y') 
                                   AND DATE_FORMAT(tglmasuk,'%d')<=15) OR
                                   (DATE_FORMAT(DATE_ADD('".$blnprosesstr."',INTERVAL -4 MONTH),'%m%Y') = DATE_FORMAT(tglmasuk,'%m%Y') 
                                   AND DATE_FORMAT(tglmasuk,'%d')>15)) AND nik_old IS NULL";


                $querygroupdetail = $this->db->query($scrgroupdetail);
                $totaldata = 0;
                $totaldata = $querygroupdetail->num_rows();
                if($totaldata>0){                    
                    $htmldetail .= '<b>'.$headerpttitle.' - KARYAWAN BARU</b>';    
                    $htmldetail .= '<table class="ReportTable" id="datareport">
                                      <thead>
                                          <tr>
                                              <th rowspan="2">NO</th>
                                              <th rowspan="2">NIK</th>
                                              <th rowspan="2">NAMA KARYAWAN</th>
                                              <th rowspan="2">BD</th>
                                              <th rowspan="2">TGL MASUK</th>
                                              <th colspan="2">LAHIR</th>
                                              <th rowspan="2">USIA</th>
                                              <th rowspan="2">SEX</th>
                                              <th rowspan="2">STATUS<br>NIKAH</th>                  
                                              <th rowspan="2">GOL DARAH</th>
                                              <th rowspan="2">AGAMA</th>
                                              <th rowspan="2">NO KTP</th>
                                              <th rowspan="2">NPWP</th>
                                              <th rowspan="2">NO BPJS TK</th>
                                              <th rowspan="2">BPJS PENSIUN</th>
                                          </tr>
                                          <tr>
                                              <th>TEMPAT</th>
                                              <th>TANGGAL</th>
                                          </tr>
                                      </thead>
                                      <tbody>';
                    $no = 0;                  
                    foreach ($querygroupdetail->result() as $rowgroupdetail) {
                        $no += 1;
                        $htmldetail .= '<tr>
                                          <td>'.$no.'</td>
                                          <td>'.$rowgroupdetail->nik.'</td>
                                          <td>'.$rowgroupdetail->nama.'</td>
                                          <td>'.$rowgroupdetail->bandskrg.'</td>
                                          <td>'.$this->date_format_txt($rowgroupdetail->TglMasuk).'</td>
                                          <td>'.$rowgroupdetail->tptlahir.'</td>
                                          <td>'.$this->date_format_txt($rowgroupdetail->tgllahir).'</td>
                                          <td>'.$rowgroupdetail->usia.'</td>
                                          <td>'.$rowgroupdetail->sex.'</td>
                                          <td>'.$rowgroupdetail->TKINOUT.'</td>
                                          <td>'.$rowgroupdetail->bloodtype.'</td>
                                          <td>'.$rowgroupdetail->agama_name.'</td>
                                          <td>'.$rowgroupdetail->NoKTP.'</td>
                                          <td>'.$this->npwp_format_txt($rowgroupdetail->nonpwp).'</td>
                                          <td>'.$rowgroupdetail->NoBpjsLama.'</td>
                                          <td>'.$rowgroupdetail->BpjsPensiun.'</td>
                                      </tr>
                                      <tr>
                                          <td></td>
                                          <td colspan="4">Nama Ibu Kandung : '.$rowgroupdetail->mothername.'</td>
                                          <td colspan="11">Alamat KTP : '.$rowgroupdetail->alamatktp.',Kel. '.$this->get_kelurahan($rowgroupdetail->kel).', Kec. '.$rowgroupdetail->NMKEC.' '.$rowgroupdetail->NMDATI2.'</td>
                                      </tr>
                                      '.$this->get_member($rowgroupdetail->nik);     

                    } //tutup foreach querygroupdetail    

                    $htmldetail .= '</tbody></table><br>'; //TUTUP TABLE KARYAWAN MASUK                    

                } //TUTUP IF TOTAL DATA > 0
                //============================== TUTUP KARYAWAN MASUK =======================================================================

                

                // KARYAWAN ON ===============================================================================================================
                $scrgroupdetail   = '';
                $querygroupdetail = '';
                $totaldata        =  0;

                $scrgroupdetail = "SELECT * FROM ( ".$scr." ) a WHERE CompanyID = '".$headerptid."' AND
                                   ((DATE_FORMAT(DATE_ADD('".$blnprosesstr."',INTERVAL -3 MONTH),'%m%Y') = DATE_FORMAT(tglmasuk,'%m%Y') 
                                   AND DATE_FORMAT(tglmasuk,'%d')<=15) OR
                                   (DATE_FORMAT(DATE_ADD('".$blnprosesstr."',INTERVAL -4 MONTH),'%m%Y') = DATE_FORMAT(tglmasuk,'%m%Y') 
                                   AND DATE_FORMAT(tglmasuk,'%d')>15)) AND nik_old IS NOT NULL";


                $querygroupdetail = $this->db->query($scrgroupdetail);
                $totaldata = 0;
                $totaldata = $querygroupdetail->num_rows();
                if($totaldata>0){                    
                    $htmldetail .= '<b>'.$headerpttitle.' - KARYAWAN ON</b>';    
                    $htmldetail .= '<table class="ReportTable" id="datareport">
                                      <thead>
                                          <tr>
                                              <th rowspan="2">NO</th>
                                              <th rowspan="2">NIK</th>
                                              <th rowspan="2">NAMA KARYAWAN</th>
                                              <th rowspan="2">BD</th>
                                              <th rowspan="2">TGL MASUK</th>
                                              <th colspan="2">LAHIR</th>
                                              <th rowspan="2">USIA</th>
                                              <th rowspan="2">SEX</th>
                                              <th rowspan="2">STATUS<br>NIKAH</th>                  
                                              <th rowspan="2">GOL DARAH</th>
                                              <th rowspan="2">AGAMA</th>
                                              <th rowspan="2">NO KTP</th>
                                              <th rowspan="2">NPWP</th>
                                              <th rowspan="2">NO BPJS TK</th>
                                              <th rowspan="2">BPJS PENSIUN</th>
                                          </tr>
                                          <tr>
                                              <th>TEMPAT</th>
                                              <th>TANGGAL</th>
                                          </tr>
                                      </thead>
                                      <tbody>';
                    $no = 0;                  
                    foreach ($querygroupdetail->result() as $rowgroupdetail) {
                        $no += 1;
                        $htmldetail .= '<tr>
                                          <td>'.$no.'</td>
                                          <td>'.$rowgroupdetail->nik.'</td>
                                          <td>'.$rowgroupdetail->nama.'</td>
                                          <td>'.$rowgroupdetail->bandskrg.'</td>
                                          <td>'.$this->date_format_txt($rowgroupdetail->TglMasuk).'</td>
                                          <td>'.$rowgroupdetail->tptlahir.'</td>
                                          <td>'.$this->date_format_txt($rowgroupdetail->tgllahir).'</td>
                                          <td>'.$rowgroupdetail->usia.'</td>
                                          <td>'.$rowgroupdetail->sex.'</td>
                                          <td>'.$rowgroupdetail->TKINOUT.'</td>
                                          <td>'.$rowgroupdetail->bloodtype.'</td>
                                          <td>'.$rowgroupdetail->agama_name.'</td>
                                          <td>'.$rowgroupdetail->NoKTP.'</td>
                                          <td>'.$rowgroupdetail->nonpwp.'</td>
                                          <td>'.$rowgroupdetail->NoBpjsLama.'</td>
                                          <td>'.$rowgroupdetail->BpjsPensiun.'</td>
                                      </tr>
                                      <tr>
                                          <td></td>
                                          <td colspan="4">Nama Ibu Kandung : '.$rowgroupdetail->mothername.'</td>
                                          <td colspan="11">Alamat KTP : '.$rowgroupdetail->alamatktp.',Kel. '.$this->get_kelurahan($rowgroupdetail->kel).', Kec. '.$rowgroupdetail->NMKEC.' '.$rowgroupdetail->NMDATI2.'</td>
                                      </tr>
                                      '.$this->get_member($rowgroupdetail->nik); ;     

                    } //tutup foreach querygroupdetail    

                    $htmldetail .= '</tbody></table><br>'; //TUTUP TABLE KARYAWAN ON                

                } //TUTUP IF TOTAL DATA > 0
                //============================== KARYAWAN ON ==============================================================================
                                                                
             } //TUTUP LOOPING COMPANY


             //======================================== PESERTA KELUAR =======================================================================
             $scrgroup = "SELECT CompanyID,cCompanyName FROM ( ".$scr." ) a WHERE (DATE_FORMAT(DATE_ADD('".$blnprosesstr."',INTERVAL -1 MONTH),'%m%Y') = DATE_FORMAT(tglkeluar,'%m%Y')) GROUP BY cCompanyName";
             $querygroup = $this->db->query($scrgroup); 
             $htmldetail .= '<table style="width: 100%;text-align: center;font-weight: bold;"><tr><td colspan="16"><h4><u>PESERTA KELUAR</u></h4></td></tr></table>';    
             $htmldetail .= '<table class="ReportTable" id="datareport">
                                  <thead>
                                      <tr>
                                          <th rowspan="2">NO</th>
                                          <th rowspan="2">NIK</th>
                                          <th rowspan="2">NAMA KARYAWAN</th>
                                          <th rowspan="2">BD</th>
                                          <th colspan="2">TANGGAL</th>
                                          <th colspan="2">NO PESERTA</th>
                                          <th rowspan="2">KET</th>
                                      </tr>
                                      <tr>
                                          <th>LAHIR</th>
                                          <th>KELUAR</th>
                                          <th>AKDHK</th>
                                          <th>BPJS-TK</th>
                                      </tr>
                                  </thead>
                                  <tbody>';   
             foreach ($querygroup->result() as $rowgroup) {
                $headerpttitle = $rowgroup->cCompanyName;
                $headerptid    = $rowgroup->CompanyID;
                $scrgroupdetail   = '';
                $querygroupdetail = '';
                $totaldata        =  0;
                $htmldetail .= '<tr><td colspan="8"><b>'.$headerpttitle.'</b></td></tr>';
                $scrgroupdetail = "SELECT * FROM ( ".$scr." ) a WHERE CompanyID = '".$headerptid."' AND 
                                   (DATE_FORMAT(DATE_ADD('".$blnprosesstr."',INTERVAL -1 MONTH),'%m%Y') = DATE_FORMAT(tglkeluar,'%m%Y'))";
                $querygroupdetail = $this->db->query($scrgroupdetail);
                $totaldata = 0;
                $totaldata = $querygroup->num_rows();
                if($totaldata>0){                                        
                    $no = 0;                  
                    foreach ($querygroupdetail->result() as $rowgroupdetail) {
                        $no += 1;
                        $htmldetail .= '<tr>
                                          <td>'.$no.'</td>
                                          <td>'.$rowgroupdetail->nik.'</td>
                                          <td>'.$rowgroupdetail->nama.'</td>
                                          <td>'.$rowgroupdetail->bandskrg.'</td>
                                          <td>'.$this->date_format_txt($rowgroupdetail->tgllahir).'</td>
                                          <td>'.$this->date_format_txt($rowgroupdetail->tglkeluar).'</td>
                                          <td></td>
                                          <td></td>
                                          <td>RESIGN</td>                                          
                                        </tr>';     
                    } //tutup foreach querygroupdetail    

                                      

                } //TUTUP IF TOTAL DATA > 0

                //============================== TUTUP KARYAWAN KELUAR =======================================================================
                                                                
             } //TUTUP LOOPING COMPANY

             $htmldetail .= '</tbody></table>'; //TUTUP TABLE KARYAWAN MASUK  
        }// TUTUP IF IN OUT 


        return $htmldetail;
    }



    function date_format_txt($value){
        if (!is_null($value) && !empty($value)){
            $date = date('d-M-Y', strtotime($value));
        }else{
            $date = '';
        }
        return $date;
    }

    function npwp_format_txt($value){
        $value = str_replace("-","",$value);
        if (!is_null($value) && !empty($value)){
            if(strlen($value)==15){
               $npwp = substr($value,0,2).".".substr($value,2,3).".".substr($value,5,3).".".substr($value,8,1)."-".substr($value,9,3).".".substr($value,12,3);     
            } else {
               $npwp = $value;
            }            
        }else{
            $npwp = '';
        }
        return $npwp;
    }

    public function get_bulan_proses()
    {
        $optdata = '';
        $mysqlcomm = "SELECT DATE_FORMAT(tglmasuk,'%Y%m') AS blnid,DATE_FORMAT(tglmasuk,'%M %Y') AS blnname 
                           FROM tbl_profile WHERE tglmasuk IS NOT NULL
                           GROUP BY DATE_FORMAT(tglmasuk,'%Y%m') ORDER BY DATE_FORMAT(tglmasuk,'%Y%m') DESC LIMIT 12";
        $data = $this->db->query($mysqlcomm);
        foreach ($data->result() as $rowgroupdetail) {
            $optdata .= '<option value="'.$rowgroupdetail->blnid.'">'.$rowgroupdetail->blnname.'</option>';
        }    

        return $optdata;
    }

    function get_kelurahan($value){
        if (!is_null($value) && !empty($value)){
            $this->db->select('NMDESA')
                 ->from('tbl_desa')
                 ->where('KDDESA',$value);
            $db = $this->db->get();
            $data = $db->row(0);
            $num_row = $db->num_rows();

            if ($num_row >0){
                return $data->NMDESA;
            }else{
                return '';
            }   
        }else{
            return '';
        }        
    }

    function get_member($value){
        //$value = 5144;
        $htmlmemberdata = "";
        $mysqlcomm     = "";
        $wifename      = "";
        $wifetmptlahir = "";
        $wifetgllahir  = "";
        $wifeusia      = "";
        $wifesex       = "";

        $childname1      = "";
        $childtmptlahir1 = "";
        $childtgllahir1  = "";
        $childusia1      = "";
        $childsex1       = "";

        $childname2      = "";
        $childtmptlahir2 = "";
        $childtgllahir2  = "";
        $childusia2      = "";
        $childsex2       = "";

        $childname3      = "";
        $childtmptlahir3 = "";
        $childtgllahir3  = "";
        $childusia3      = "";
        $childsex3       = "";

        $mysqlcomm = "SELECT membername,membertempatlahir,memberlahir,FLOOR(DATEDIFF(current_date(),memberlahir)/365) AS usia,membersex FROM tbl_profile_member WHERE nik = ".$value." AND MemberStatus IN (1,2) LIMIT 1";
        $data = $this->db->query($mysqlcomm);
        foreach ($data->result() as $rowgroupdetail) {
            $wifename      = $rowgroupdetail->membername;
            $wifetmptlahir = $rowgroupdetail->membertempatlahir;
            $wifetgllahir  = $rowgroupdetail->memberlahir;
            $wifeusia      = $rowgroupdetail->usia;
            $wifesex       = $rowgroupdetail->membersex;
        }    

        $htmlmemberdata .= '<tr>
                              <td></td>
                              <td colspan="4">Nama Suami/Istri &nbsp;&nbsp;&nbsp;: '.$wifename.'</td>                  
                              <td>'.$wifetmptlahir.'</td>
                              <td>'.$this->date_format_txt($wifetgllahir).'</td>
                              <td>'.$wifeusia.'</td>
                              <td>'.$wifesex.'</td>
                              <td rowspan="4" colspan="7"></td>  
                            </tr>';


        //========================================== UNTUK MEMBER CHILD
        $no            = 0;                    
        $mysqlcomm     = "";                  
        $mysqlcomm     = "SELECT membername,membertempatlahir,memberlahir,FLOOR(DATEDIFF(current_date(),memberlahir)/365) AS usia,membersex FROM tbl_profile_member WHERE nik = ".$value." AND MemberStatus IN (3) ORDER BY memberlahir ASC LIMIT 3";
        //echo $mysqlcomm;
        //die();
        $data = $this->db->query($mysqlcomm);
        foreach ($data->result() as $rowgroupdetail) {
            $no += 1;
            $varchildname       = 'childname'.$no;
            ${$varchildname}    = $rowgroupdetail->membername;

            $varchildtmptlahir       = 'childtmptlahir'.$no;
            ${$varchildtmptlahir}    = $rowgroupdetail->membertempatlahir;

            $varchildtgllahir       = 'childtgllahir'.$no;
            ${$varchildtgllahir}    = $rowgroupdetail->memberlahir;

            $varchildusia = 'childusia'.$no;
            ${$varchildusia}    = $rowgroupdetail->usia;

            $varchildsex = 'childsex'.$no;
            ${$varchildsex}    = $rowgroupdetail->membersex;
            
            /*
            $childname.$no      = $rowgroupdetail->membername;
            $childtmptlahir.$no = $rowgroupdetail->membertempatlahir;
            $childtgllahir.$no  = $rowgroupdetail->memberlahir;
            $childusia.$no      = $rowgroupdetail->usia;
            $childsex.$no       = $rowgroupdetail->membersex;            
            */
        }                    

        $htmlmemberdata  .= '<tr>
                                  <td></td>
                                  <td colspan="4">Nama Anak ke 1 *) : '.$childname1.'</td>                  
                                  <td>'.$childtmptlahir1.'</td>
                                  <td>'.$this->date_format_txt($childtgllahir1).'</td>
                                  <td>'.$childusia1.'</td>
                                  <td>'.$childsex1.'</td>
                            </tr>
                            <tr>
                                  <td></td>
                                  <td colspan="4">Nama Anak ke 2 *) : '.$childname2.'</td>                  
                                  <td>'.$childtmptlahir2.'</td>
                                  <td>'.$this->date_format_txt($childtgllahir2).'</td>
                                  <td>'.$childusia2.'</td>
                                  <td>'.$childsex2.'</td>
                            </tr>
                            <tr>
                                  <td></td>
                                  <td colspan="4">Nama Anak ke 3 *) : '.$childname3.'</td>                  
                                  <td>'.$childtmptlahir3.'</td>
                                  <td>'.$this->date_format_txt($childtgllahir3).'</td>
                                  <td>'.$childusia3.'</td>
                                  <td>'.$childsex3.'</td>
                            </tr>';

        return $htmlmemberdata;
    }



    public function loaddata_payroll_inout_excell(){
        $jenis        = $this->input->get('jenis');
        $blnproses    = $this->input->get('blnproses');
        $data['htmldata'] = $this->loaddata_payroll_inout($jenis,$blnproses);
        $data['namaexcell'] = 'Laporan_In_OUt_Payroll';

        $this->load->view('report_IX_excell_view',$data);
        /*
        $this->view($this->cms_module_path().'/report_IX_excell_view', $output,
        $this->cms_complete_navigation_name('report_IX_karyawan_in_out'));
        */
    }

    public function loaddata_bpjskes_inout_excell(){
        $jenis        = $this->input->get('jenis');
        $blnproses    = $this->input->get('blnproses');
        $data['htmldata'] = $this->loaddata_bpjskes_inout($jenis,$blnproses);
        $data['namaexcell'] = 'Laporan_In_Out_BPJS_Kes';

        $this->load->view('report_IX_excell_view',$data);
        /*
        $this->view($this->cms_module_path().'/report_IX_excell_view', $output,
        $this->cms_complete_navigation_name('report_IX_karyawan_in_out'));
        */
    }

    public function loaddata_bpjstk_inout_excell(){
        $jenis        = $this->input->get('jenis');
        $blnproses    = $this->input->get('blnproses');
        $data['htmldata'] = $this->loaddata_bpjstk_inout($jenis,$blnproses);
        $data['namaexcell'] = 'Laporan_In_Out_BPJS_Ketenaga_Kerjaan';

        $this->load->view('report_IX_excell_view',$data);
        /*
        $this->view($this->cms_module_path().'/report_IX_excell_view', $output,
        $this->cms_complete_navigation_name('report_IX_karyawan_in_out'));
        */
    }






}