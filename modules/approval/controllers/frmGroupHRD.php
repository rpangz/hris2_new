<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Master_Company
 *
 * @author No-CMS Module Generator
 */
class frmGroupHRD extends CMS_Priv_Strict_Controller {

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
        //$crud->unset_texteditor('tTransRemark');
        

        // $crud->unset_add();
        // $crud->unset_edit();
        // $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');
            $crud->set_relation('hrd_nik', $this->cms_complete_table_name('profile'), '{NIK}');
            $crud->set_relation('hrd_company', $this->cms_complete_table_name('company'), 'cCompanyCode');
            //$crud->unset_edit();
        } else{
            $crud->set_relation('hrd_nik', $this->cms_complete_table_name('profile'), '{Nama} - [{NIK}]');
            $crud->set_relation('hrd_company', $this->cms_complete_table_name('company'), 'cCompanyName');
        }
        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_country_model');
        */

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
      

        $crud->set_table($this->cms_complete_table_name('apv_hrd'));

        $list = $this->uri->segment(4);
        if ($this->uri->segment(4) !=0 && !is_null($this->uri->segment(4)) && isset($list)){
            $crud->where('hrd_company', $this->uri->segment(4));
        }       
        else {
            $crud->where('hrd_company >=', 0);          
        }

        //$where = "iTransPeriodId =".$this->uri->segment(4)." AND cTransCode LIKE".$this->uri->segment(5);
        //$crud->where($where);

        //$crud->where('iTransPeriodId', $this->uri->segment(4));
        //$crud->like('cTransCode',$this->uri->segment(4));
        //$crud->where('cTransCode', $this->uri->segment(5));

        $crud->order_by('hrd_company','ASC');
        //$crud->order_by('iGroupApprovalListId','ASC');
        // primary key
        $crud->set_primary_key('hrd_id');

        $crud->set_subject('Group HRD');

        //$crud->unset_add_fields('iTransCreateBy','dTransCreateTime');
        //$crud->unset_edit_fields('iTransUpdateBy','dTransUpdatetime');

        //$crud->field_type('iTransCreateBy', 'hidden', $session_id);
        //$crud->field_type('dTransCreateTime', 'hidden', $today);
        //$crud->field_type('iTransUpdateBy', 'hidden', $session_id);
        //$crud->field_type('dTransUpdatetime', 'hidden', $today);

        //$crud->field_type('hrd_name', 'readonly');
        //$crud->field_type('hrd_email', 'readonly');

        $crud->columns('hrd_nik','hrd_name','hrd_status','hrd_modules','hrd_company','potential','active_sub');
        $crud->edit_fields('hrd_company','hrd_nik','hrd_modules','hrd_status','potential','active_sub');
        $crud->add_fields('hrd_company','hrd_nik','hrd_modules','hrd_status');
            
       
        $crud->display_as('hrd_nik','NIK');
        $crud->display_as('hrd_name','Name');
        $crud->display_as('hrd_email','Email');
        $crud->display_as('hrd_status','Status');
        $crud->display_as('hrd_company','Company');
        $crud->display_as('hrd_modules','HRD Modules');
        $crud->display_as('active_sub','Sub Active');
        $crud->display_as('potential','Sub Potential');
        

        $crud->required_fields('hrd_nik','hrd_name','hrd_email','hrd_status','hrd_modules','hrd_company');

        //$crud->unique_fields('hrd_nik');

        
        $crud->set_relation('hrd_modules', $this->cms_complete_table_name('apv_hrd_modules'), 'modules_name');
        //$crud->set_relation('deptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        

        //$crud->field_type('bTransStatus','enum',array('0','READY','1','OUT'));
        //$crud->field_type('bTransStatus', 'true_false', array('Returned', 'Out'));

        //$crud->set_relation('typeID','tbl_type','cTypeName');  
            
            //IF YOU HAVE A LARGE AMOUNT OF DATA, ENABLE THE CALLBACKS BELOW - FOR EXAMPLE ONE USER HAD 36000 CITIES AND SLOWERD UP THE LOADING PROCESS. THESE CALLBACKS WILL LOAD EMPTY SELECT FIELDS THEN POPULATE THEM AFTERWARDS
            

        
        //$crud->field_type('hrd_status','true_false');

        //$crud->field_type('hrd_status','set',array('banana','orange','apple','lemon'));
        $crud->field_type('hrd_status','dropdown',array('1' => 'active', '0' => 'inactive',));
      
        $crud->callback_column('NamaUnit',array($this,'_callback_webpage_url'));
        
        //$crud->add_action('print', '', '','ui-icon-image',array($this,'just_a_test'));
        //$crud->add_action('More', '', 'demo/action_more','ui-icon-plus');
        
            
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        $crud->callback_add_field('divisionID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_edit_field('divisionID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_add_field('deptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_edit_field('deptID', array($this, 'empty_city_dropdown_select'));

        $crud->callback_column('hrd_name', array($this, '_callback_column_hrd_name'));

        $crud->callback_column('potential',array($this,'existing_potential_user'));
        $crud->callback_column('active_sub',array($this,'existing_active_user'));
        $crud->callback_edit_field('potential', array($this, '_callback_edit_field_potential'));
        $crud->callback_edit_field('active_sub', array($this, '_callback_edit_field_active_sub'));
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
        $data = array(
            'state' => $this->_callback_state_action(),
        );

        $output   = array_merge((array)$output, $data);
        
        $this->view($this->cms_module_path().'/frmGroupHRD_view', $output,
            $this->cms_complete_navigation_name('frmGroupHRD'));
    }


    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('apv_hrd'),array('hrd_id'=>$id));
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
        
        $session_nik = $post_array['hrd_nik'];

        if (empty($_POST['status_substitution']) || is_null($_POST['status_substitution'])){
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

        $my_profile = $this->_callback_my_profile($nik=$post_array['hrd_nik']);

        $nama       = $my_profile['Nama'];
        $email      = $my_profile['Email'];

        mysql_query("UPDATE tbl_apv_hrd SET hrd_name='$nama',hrd_email='$email' WHERE hrd_id='$primary_key'");       


        return TRUE;
    }

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }

    // add hyperlink
    public function _callback_column_hrd_name($value, $row){    
    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->hrd_id)."'>$value</a>";
        
    }

    public function _callback_state_action(){
        $crud = $this->new_crud();
        $state = $crud->getState();
        return $state;    
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

        $query  = mysql_query('SELECT * FROM tbl_apv_hrd WHERE hrd_id='.$this->uri->segment(5));
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);
        if ($total >0){
            return $data['hrd_nik'];
        }else{
            return '0';
        }

    }

    public function existing_potential_user($value, $row){

        $query  = mysql_query('SELECT * FROM tbl_substitution_potential WHERE CurrentNIK='.$row->hrd_nik);
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

        $query  = mysql_query('SELECT * FROM tbl_profile WHERE NIK='.$row->hrd_nik);
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
                          
                        <input id="switch-animate" name="status_substitution" type="checkbox" data-handle-width="225" '.$this->current_substitution_status($session_nik).' data-on-text="<strong>ON</strong>" data-off-text="<strong>OFF</strong>" />
 
                         
                        </div>
                      </div>
                      </div>';


        return $form;


    }

    public function current_substitution($nik){

        $query  = mysql_query('SELECT * FROM tbl_profile WHERE NIK='.$nik);
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        if ($total >0 && !is_null($data['SubstitutionNIK1'])){
            return $data['SubstitutionNIK1'];
        }
        else {
            return '0';
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


    public function _callback_my_profile($nik){
      
        $result = mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$nik);
        $storeArray = Array();
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
            $storeArray['Nama'] =  $row['Nama'];
            $storeArray['Email'] =  $row['Email'];
        }

        return $storeArray;     
    
    }



}