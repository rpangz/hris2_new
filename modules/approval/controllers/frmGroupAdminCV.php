<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class frmGroupAdminCV extends CMS_Priv_Strict_Controller {

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
        $crud->unset_texteditor('tTransRemark');
        

        // $crud->unset_add();
        // $crud->unset_edit();
        // $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');
             $crud->set_relation('AdminCVNIK', $this->cms_complete_table_name('profile'), '{NIK}');
             $crud->display_as('AdminCVNIK','NIK');

             $crud->set_relation('companyID', $this->cms_complete_table_name('company'), 'cCompanyCode');
            //$crud->unset_edit();
        }
        else {
        	 $crud->set_relation('AdminCVNIK', $this->cms_complete_table_name('profile'), '{Nama} - {NIK}');
        	 $crud->display_as('AdminCVNIK','Nama');
             $crud->set_relation('companyID', $this->cms_complete_table_name('company'), 'cCompanyName');
        }
        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_country_model');
        */

        if ($this->uri->segment(4) !=0 && !is_null($this->uri->segment(4))){
            $crud->where('tbl_admin_cv.deptID', $this->uri->segment(4));
            //$crud->order_by('iGroupApprovalListId', 'ASC');

        }
        else {
            $crud->where('tbl_admin_cv.deptID >=', 0);
            $crud->order_by('deptID','ASC');

        }


        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
      

        $crud->set_table($this->cms_complete_table_name('admin_cv'));

        //$where = "iTransPeriodId =".$this->uri->segment(4)." AND cTransCode LIKE".$this->uri->segment(5);
        //$crud->where($where);

        //$crud->where('iTransPeriodId', $this->uri->segment(4));
        //$crud->like('cTransCode',$this->uri->segment(4));
        //$crud->where('cTransCode', $this->uri->segment(5));


        //$crud->order_by('iGroupApprovalListId','ASC');
        // primary key
        $crud->set_primary_key('AdminCVId');

        $crud->set_subject('Group Admin CV');

        //$crud->unset_add_fields('iTransCreateBy','dTransCreateTime');
        //$crud->unset_edit_fields('iTransUpdateBy','dTransUpdatetime');

        //$crud->field_type('iTransCreateBy', 'hidden', $session_id);
        //$crud->field_type('dTransCreateTime', 'hidden', $today);
        //$crud->field_type('iTransUpdateBy', 'hidden', $session_id);
        //$crud->field_type('dTransUpdatetime', 'hidden', $today);

        $crud->columns('AdminCVNIK','NIKKI','deptID','divisionID','companyID');
        $crud->edit_fields('companyID','divisionID','deptID','AdminCVNIK');
        $crud->add_fields('AdminCVNIK','deptID');
            
       
        $crud->display_as('companyID','Company');
        $crud->display_as('divisionID','Division');
        $crud->display_as('deptID','Departement');
        $crud->display_as('iGroupApprovalListId','No.Urut');
        $crud->display_as('NIKKI','Nama');
        $crud->display_as('active_sub','Sub Active');
        $crud->display_as('potential','Sub Potential');

        $crud->display_as('form_cuti','Form Cuti');
        $crud->display_as('form_ijin','Form Ijin');
        $crud->display_as('form_my_cv','Form CV');
        

        $crud->required_fields('deptID','iGroupApprovalListId','NIK','form_cuti','form_ijin','form_my_cv');

        //$crud->unique_fields('cTransCode');

        
        $crud->set_relation('divisionID', $this->cms_complete_table_name('div'), 'cDivName');
        //$crud->set_relation('deptID', $this->cms_complete_table_name('dept'), 'cDeptName');
       

        //$crud->field_type('bTransStatus','enum',array('0','READY','1','OUT'));
        //$crud->field_type('bTransStatus', 'true_false', array('Returned', 'Out'));

        //$crud->set_relation('typeID','tbl_type','cTypeName');  
            
            //IF YOU HAVE A LARGE AMOUNT OF DATA, ENABLE THE CALLBACKS BELOW - FOR EXAMPLE ONE USER HAD 36000 CITIES AND SLOWERD UP THE LOADING PROCESS. THESE CALLBACKS WILL LOAD EMPTY SELECT FIELDS THEN POPULATE THEM AFTERWARDS
            
        $crud->callback_column('potential',array($this,'existing_potential_user'));
        $crud->callback_column('active_sub',array($this,'existing_active_user'));
        $crud->callback_add_field('deptID', array($this, '_callback_edit_field_potential'));
        $crud->callback_edit_field('deptID', array($this, '_callback_edit_field_potential'));
        //$crud->callback_edit_field('active_sub', array($this, '_callback_edit_field_active_sub'));

        //$crud->callback_add_field('potential', array($this, '_callback_edit_field_potential'));

        

      
        $crud->callback_column('NamaUnit',array($this,'_callback_webpage_url'));

        //$crud->field_type('form_cuti', 'true_false');

        //$crud->field_type('form_cuti','enum',array(1 => 'active',0=> 'inactive'));

        $crud->field_type('form_cuti','dropdown',array(1 => 'active', 0=> 'inactive'));
        $crud->field_type('form_ijin','dropdown',array(1 => 'active', 0=> 'inactive'));
        $crud->field_type('form_my_cv','dropdown',array(1 => 'active', 0=> 'inactive'));

        //$crud->callback_field('form_cuti', array($this, 'get_true_false_input_form_cuti'));
        //$crud->callback_field('form_ijin', array($this, 'get_true_false_input_form_ijin'));
        //$crud->callback_field('form_my_cv', array($this, 'get_true_false_input_form_my_cv'));

        
        //$crud->add_action('print', '', '','ui-icon-image',array($this,'just_a_test'));
        //$crud->add_action('More', '', 'demo/action_more','ui-icon-plus');
        
            
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        //$crud->callback_add_field('divisionID', array($this, 'empty_state_dropdown_select'));
        //$crud->callback_edit_field('divisionID', array($this, 'empty_state_dropdown_select'));
        //$crud->callback_add_field('deptID', array($this, 'empty_city_dropdown_select'));
        //$crud->callback_edit_field('deptID', array($this, 'empty_city_dropdown_select'));

        $crud->callback_column('NIKKI', array($this, '_callback_column_NIKKI'));
        //$crud->callback_column('iGroupApprovalId', array($this, '_callback_column_iGroupApprovalId'));
        



        

        $this->crud = $crud;
        return $crud;
    }


    public function index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/frmGroupAdminCV_view', $output,
            $this->cms_complete_navigation_name('frmGroupAdminCV'));
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

        //$session_nik = $this->check_user_nik($value=$this->uri->segment(5));
        $session_nik = 4833;

        $empty_select        = '<div class="row">
                                <div class="col-md-8">
                                <div class="input-prepend">
                                <select data-live-search="true" style="width: 100%; display: none;" class="selectpicker form-control" multiple="multiple" data-container="body" data-header="Pilih Departement" name="dept_id[]" id="dept_id[]">';
                     
                        

            $tampil = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");

            while ($rows = mysql_fetch_array($tampil)){                            

                $name          = 'dept_id';
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
                $dropdown .= '<option value="'.$option.'"'.$select.' data-subtext="'.$this->division_profile($dept_id=$option).'">'.$this->department_profile($dept_id=$option).'</option>'."\n";
        }

        $dropdown .= '';
        return $dropdown;
    }

    public function potential_all_user($company,$nik){

        $query   = mysql_query('SELECT * FROM tbl_dept INNER JOIN tbl_div ON iDeptDivID=iDivId WHERE companyID='.$company.' ORDER BY cDivName ASC');
        $total   = mysql_num_rows($query);
        $results = array();

        while($data = mysql_fetch_assoc($query)){
           $results[] = $data['iDeptID'];
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


    public function department_profile($dept_id){

        $query  = mysql_query('SELECT * FROM tbl_dept INNER JOIN tbl_div ON iDeptDivID=iDivId WHERE iDeptID='.$dept_id);
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);
        if ($total >0){
            return $data['cDeptName'];
        }else{
            return '';
        }

    }


    public function division_profile($dept_id){

        $query  = mysql_query('SELECT * FROM tbl_dept INNER JOIN tbl_div ON iDeptDivID=iDivId WHERE iDeptID='.$dept_id);
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);
        if ($total >0){
            return $data['cDivName'];
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

                        $form .= '<optgroup label="'.$rows['cCompanyName'].'"';

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

   

}