<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class frmGroupAdmin extends CMS_Priv_Strict_Controller {

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
             //$crud->set_relation('admin_group_nik', $this->cms_complete_table_name('profile'), '{NIK}');
             $crud->display_as('admin_group_nik','NIK');

             //$crud->set_relation('companyID', $this->cms_complete_table_name('company'), 'cCompanyCode');
            //$crud->unset_edit();
        }
        else {
        	 //$crud->set_relation('admin_group_nik', $this->cms_complete_table_name('profile'), '{Nama} - {NIK}');
        	 $crud->display_as('admin_group_nik','Nama');
             //$crud->set_relation('companyID', $this->cms_complete_table_name('company'), 'cCompanyName');
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
      

        $crud->set_table($this->cms_complete_table_name('group_admin'));        

        if ($this->uri->segment(4) !=0 && !is_null($this->uri->segment(4))){
            //$nik = 'admin_group_nik ='.$this->uri->segment(4);
        }
        else {
            //$nik = 'admin_group_nik >=0';
            //$crud->where('tbl_admin_cv.deptID >=', 0);
           // $crud->order_by('deptID','ASC');

        }

        //$where = '1=1';
        //$crud->where ($where);

        //$where = $nik.' GROUP_BY admin_group_nik';

        $list = $this->uri->segment(4);

        if ($this->uri->segment(4) !=0 && !is_null($this->uri->segment(4)) && isset($list)){
            $crud->where('admin_group_nik', $this->uri->segment(4));
            //$crud->where('tbl_hakcuti.companyID', $company_id);
            //$crud->order_by('HakId','ASC');
        }
        else {
            $crud->where('admin_group_nik >=', 0);
            //$crud->where('tbl_hakcuti.companyID', $company_id);
            // /$crud->order_by('HakId','ASC');
            //$crud->unset_add();
            //$crud->unset_edit();
        }

        $crud->where('admin_group_id GROUP BY admin_group_nik');


        //$crud->group_by('admin_group_nik');

        //$where = "iTransPeriodId =".$this->uri->segment(4)." AND cTransCode LIKE".$this->uri->segment(5);
        //$crud->where($where);

        //$crud->where('iTransPeriodId', $this->uri->segment(4));
        //$crud->like('cTransCode',$this->uri->segment(4));
        //$crud->where('cTransCode', $this->uri->segment(5));


        //$crud->order_by('iGroupApprovalListId','ASC');
        // primary key
        $crud->set_primary_key('admin_group_nik');

        $crud->set_subject('Group Admin');

        //$crud->unset_add_fields('iTransCreateBy','dTransCreateTime');
        //$crud->unset_edit_fields('iTransUpdateBy','dTransUpdatetime');

        //$crud->field_type('iTransCreateBy', 'hidden', $session_id);
        //$crud->field_type('dTransCreateTime', 'hidden', $today);
        //$crud->field_type('iTransUpdateBy', 'hidden', $session_id);
        //$crud->field_type('dTransUpdatetime', 'hidden', $today);

        $crud->columns('admin_group_nik','NIKKI','admin_form_cv','admin_form_cuti');
        $crud->edit_fields('admin_group_nik','admin_form_cv','admin_form_cuti');
        $crud->add_fields('admin_group_nik','admin_form_cv','admin_form_cuti');
            
       
        $crud->display_as('admin_form_cv','Form CV <a href="#" style="text-decoration: none;" class="glyphicon glyphicon-question-sign tip-right" data-toggle="tooltip" title="Admin Untuk Curriculum Vitae List (CV)"></a>');
        $crud->display_as('admin_form_cuti','Form Cuti <a href="#" style="text-decoration: none;" class="glyphicon glyphicon-question-sign tip-right" data-toggle="tooltip" title="Admin Untuk Email Notifikasi Form Cuti"></a>');
        $crud->display_as('NIKKI','Nama');
       
        

        $crud->required_fields('admin_group_nik');

        //$crud->unique_fields('cTransCode');

        
        //$crud->set_relation('divisionID', $this->cms_complete_table_name('div'), 'cDivName');
        //$crud->set_relation('deptID', $this->cms_complete_table_name('dept'), 'cDeptName');
       

        //$crud->field_type('bTransStatus','enum',array('0','READY','1','OUT'));
        //$crud->field_type('bTransStatus', 'true_false', array('Returned', 'Out'));

        //$crud->set_relation('typeID','tbl_type','cTypeName');  
            
            //IF YOU HAVE A LARGE AMOUNT OF DATA, ENABLE THE CALLBACKS BELOW - FOR EXAMPLE ONE USER HAD 36000 CITIES AND SLOWERD UP THE LOADING PROCESS. THESE CALLBACKS WILL LOAD EMPTY SELECT FIELDS THEN POPULATE THEM AFTERWARDS
            
        //$crud->callback_column('potential',array($this,'existing_potential_user'));
        //$crud->callback_column('active_sub',array($this,'existing_active_user'));


        $crud->callback_add_field('admin_group_nik', array($this, '_callback_add_field_admin_group_nik'));
        $crud->callback_edit_field('admin_group_nik', array($this, '_callback_edit_field_admin_group_nik'));


        $crud->callback_column('admin_form_cv', array($this, '_callback_column_admin_form_cv'));
        $crud->callback_add_field('admin_form_cv', array($this, '_callback_edit_field_admin_form_cv'));
        $crud->callback_edit_field('admin_form_cv', array($this, '_callback_edit_field_admin_form_cv'));

        $crud->callback_column('admin_form_cuti', array($this, '_callback_column_admin_form_cuti'));
        $crud->callback_add_field('admin_form_cuti', array($this, '_callback_edit_field_admin_form_cuti'));
        $crud->callback_edit_field('admin_form_cuti', array($this, '_callback_edit_field_admin_form_cuti'));
        


        //$crud->callback_edit_field('active_sub', array($this, '_callback_edit_field_active_sub'));

        //$crud->callback_add_field('potential', array($this, '_callback_edit_field_potential'));

        

      
        //$crud->callback_column('NamaUnit',array($this,'_callback_webpage_url'));

        //$crud->field_type('form_cuti', 'true_false');

        //$crud->field_type('form_cuti','enum',array(1 => 'active',0=> 'inactive'));

       

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
        $output = $crud->render();
        $this->view($this->cms_module_path().'/frmGroupAdmin_view', $output, $this->cms_complete_navigation_name('frmGroupAdmin'));
    }


    

    
    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('group_admin'),array('admin_group_nik'=>$id));
                    $this->_after_delete($id);
                }
            }
        }
    }

    public function _before_insert($post_array){
        $post_array = $this->_before_insert_or_update($post_array);
        
        $session_nik = $post_array['admin_group_nik'];      

        mysql_query('DELETE FROM tbl_group_admin WHERE admin_group_nik='.$session_nik);


        return $post_array;
    }

    public function _after_insert($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here

        $session_nik = $post_array['admin_group_nik'];

        $form_cv_num   = count($_POST['dept_id_as_form_cv']);
        $form_cuti_num = count($_POST['dept_id_as_form_cuti']);

        if ($form_cv_num > 0){

            $this->update_tbl_main_group_user($value=$session_nik);

        }
              

        if (!empty($_POST['dept_id_as_form_cv']) || !is_null($_POST['dept_id_as_form_cv'])){            

            foreach ($_POST['dept_id_as_form_cv'] as $dept_id_as_form_cv){

                mysql_query('INSERT INTO tbl_group_admin (admin_group_nik,admin_form_cv) VALUES ("'.$session_nik.'","'.$dept_id_as_form_cv.'")');
            }


        }


        if (!empty($_POST['dept_id_as_form_cuti']) || !is_null($_POST['dept_id_as_form_cuti'])){

            foreach ($_POST['dept_id_as_form_cuti'] as $dept_id_as_form_cuti){

                mysql_query('INSERT INTO tbl_group_admin (admin_group_nik,admin_form_cuti) VALUES ("'.$session_nik.'","'.$dept_id_as_form_cuti.'")');
            }


        }

        //include "http://".$_SERVER['SERVER_NAME']."/hris2/includes/mailer/frmCuti/SendMail.php?id=".$primary_key."&mynik=".$session_nik."&proses=1";
        //include "http://".$_SERVER['SERVER_NAME']."/hris2/includes/mailer/frmGroupAdmin/index.php?act=updateid=".$primary_key."&mynik=".$session_nik."&proses=1";
        include site_url('includes/mailer/frmGroupAdmin/index.php?act=insert&nik='.$session_nik);       


        return $success;
    }

    public function _before_update($post_array, $primary_key){
        $post_array = $this->_before_insert_or_update($post_array, $primary_key);
        
        $session_nik = $primary_key;      

        mysql_query('DELETE FROM tbl_group_admin WHERE admin_group_nik='.$session_nik);


        return $post_array;
    }

    public function _after_update($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);       
        
        $session_nik = $primary_key;
        
        $form_cv_num   = count($_POST['dept_id_as_form_cv']);
        $form_cuti_num = count($_POST['dept_id_as_form_cuti']);

        if ($form_cv_num > 0){

            $this->update_tbl_main_group_user($value=$session_nik);

        }



        /*
        $max_post = max($form_cv_num, $form_cuti_num);

        $the_biggest = $this->find_the_greatest($one=$form_cv_num, $two=$form_cuti_num, $three=0);


        if ($the_biggest==1){

            for($no=0; $no <= $max_post; $no++){
                $dept_id_as_form_cv = $_POST['dept_id_as_form_cv'];
                $dept_id_as_form_cuti = $_POST['dept_id_as_form_cuti'];
                
                mysql_query('INSERT INTO tbl_group_admin (admin_group_nik,admin_form_cv) VALUES ("'.$session_nik.'","'.$dept_id_as_form_cv.'")');
                $new_id = mysql_insert_id();
                mysql_query('UPDATE tbl_group_admin SET admin_group_nik=$session_nik,admin_form_cuti=$dept_id_as_form_cuti WHERE admin_group_id=$new_id');

            }


        }
        elseif($the_biggest==2){

        }
        else{

        }
        
    */
        
      

  

        if (!empty($_POST['dept_id_as_form_cv']) || !is_null($_POST['dept_id_as_form_cv'])){            

            foreach ($_POST['dept_id_as_form_cv'] as $dept_id_as_form_cv){

                mysql_query('INSERT INTO tbl_group_admin (admin_group_nik,admin_form_cv) VALUES ("'.$session_nik.'","'.$dept_id_as_form_cv.'")');
            }


        }


        if (!empty($_POST['dept_id_as_form_cuti']) || !is_null($_POST['dept_id_as_form_cuti'])){

            foreach ($_POST['dept_id_as_form_cuti'] as $dept_id_as_form_cuti){

                mysql_query('INSERT INTO tbl_group_admin (admin_group_nik,admin_form_cuti) VALUES ("'.$session_nik.'","'.$dept_id_as_form_cuti.'")');
            }


        }
             

        include site_url('includes/mailer/frmGroupAdmin/index.php?act=update&nik='.$session_nik);

        return $success;
    }

    public function _before_delete($primary_key){

        include site_url('includes/mailer/frmGroupAdmin/index.php?act=delete&nik='.$primary_key); 

        return TRUE;
    }

    public function _after_delete($primary_key){

        //include site_url('includes/mailer/frmGroupAdmin/index.php?act=delete&nik='.$primary_key); 

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
            ->where('NIK', $row->admin_group_nik)
            ->get(); 

    
        foreach ($query->result() as $rown){
            return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->admin_group_nik)."'>".$rown->Nama."</a>";
        }
   
    
        
    }

    //CALLBACK FUNCTIONS
    public function _callback_edit_field_admin_group_nik($value, $row){
        //CREATE THE EMPTY SELECT STRING
        $empty_select  = '<div class="row">';
        $empty_select .= '<div class="col-md-8">';
        $empty_select .= '<select data-live-search="true" name="admin_group_nik" class="selectpicker form-control" data-container="body" data-placeholder="Select Karyawan" style="width: 480px;">';
        $empty_select_closed = '</select>';
        $empty_select_closed .= '</div>';
        $empty_select_closed .= '</div>';
      
        $listingID = $this->uri->segment(5);        
        
        $crud = new grocery_CRUD();
        $state = $crud->getState();    
        
            $this->db->select('admin_group_id, admin_group_nik')
                     ->from($this->cms_complete_table_name('group_admin'))
                     ->where('admin_group_nik', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $session_nik = $row->admin_group_nik;
            
         $tampil = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");

        while ($rows = mysql_fetch_array($tampil)){

            $this->db->select('*')
                     ->from($this->cms_complete_table_name('profile'))
                     ->where('bStatus', 1)
                     ->where('CompanyId', $rows['iCompanyId']);
            $db = $this->db->get();
            
            $empty_select .= '<optgroup label="'.$rows['cCompanyName'].'">';

            foreach($db->result() as $row):
                if($row->NIK == $session_nik) {
                    $empty_select .= '<option value="'.$row->NIK.'" selected="selected" data-subtext="'.$row->NIK.'">'.$row->Nama.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->NIK.'" data-subtext="'.$row->NIK.'">'.$row->Nama.'</option>';
                }
            endforeach;
            
        }    
        
        return $empty_select.$empty_select_closed;
     
        
    }



    public function _callback_add_field_admin_group_nik(){
       
        $empty_select  = '<div class="row">';
        $empty_select .= '<div class="col-md-8">';
        $empty_select .= '<select data-live-search="true" name="admin_group_nik" class="selectpicker form-control" data-container="body" data-placeholder="Select Karyawan" style="width: 480px;">';
        $empty_select .= '<option value="0" SELECTED disabled>Select Karyawan</option>';
        $empty_select_closed = '</select>';
        $empty_select_closed .= '</div>';
        $empty_select_closed .= '</div>';
      
        $listingID = $this->uri->segment(4);        
        
        $crud = new grocery_CRUD();
        $state = $crud->getState();            
                     
        
        $tampil = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");

        while ($rows = mysql_fetch_array($tampil)){

            $this->db->select('*')
                     ->from($this->cms_complete_table_name('profile'))
                     ->where('bStatus', 1)
                     ->where('CompanyId', $rows['iCompanyId']);
            $db = $this->db->get();

            $empty_select .= '<optgroup label="'.$rows['cCompanyName'].'">';

            foreach($db->result() as $row):
                if($this->current_nik_admin($nik=$row->NIK) == 1){                   
                    $status = 'disabled';
                }
                else{
                    $status = '';
                }

                $empty_select .= '<option value="'.$row->NIK.'" data-subtext="'.$row->NIK.'" '.$status.'>'.$row->Nama.'</option>';

            endforeach;

        }
        
        return $empty_select.$empty_select_closed;  
        
    }             
    


     // add hyperlink
    public function _callback_column_iGroupApprovalId($value, $row){        
    
        //return "<a href='".site_url($this->cms_module_path().'/frmGroupApproval/index/edit/'.$row->iGroupApprovalId)."'>$value</a>";
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->iGroupApprovalId)."'>$value</a>";
        
    }

    


    public function _callback_edit_field_admin_form_cv($value, $primary_key){

        if (isset($primary_key)){
           $session_nik = $primary_key; 
        }
        else{
            $session_nik = NULL; 
        }
        //$session_nik = 4833;

        $empty_select        = '<div class="row">
                                <div class="col-md-8">
                                <div class="input-prepend">
                                <select data-live-search="true" style="width: 100%; display: none;" class="selectpicker form-control" multiple="multiple" multiple data-actions-box="true" data-selected-text-format="count" data-container="body" data-header="Pilih Departement" name="dept_id_as_form_cv[]" id="dept_id_as_form_cv[]">';                    
                        

            $tampil = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");

            while ($rows = mysql_fetch_array($tampil)){                            

                $name          = 'dept_id_as_form_cv';
                $options       = $this->department_all_user($company=$rows['iCompanyId'],$nik=$session_nik);
                $selected      = $this->current_admin_form_cv($nik=$session_nik);

                $empty_select .= '<optgroup label="'.$rows['cCompanyName'].'">';
                $empty_select .= $this->multi_dropdown($name, $options, $selected );
                $empty_select .= '</optgroup>';

            }
        $empty_select_closed = '</select></div></div></div>';  
                         
        return $empty_select.$empty_select_closed;       


    }

    public function _callback_edit_field_admin_form_cuti($value, $primary_key){

        if (isset($primary_key)){
           $session_nik = $primary_key; 
        }
        else{
            $session_nik = NULL; 
        }

        $empty_select        = '<div class="row">
                                <div class="col-md-8">
                                <div class="input-prepend">
                                <select data-live-search="true" style="width: 100%; display: none;" class="selectpicker form-control" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-container="body" data-header="Pilih Departement" name="dept_id_as_form_cuti[]" id="dept_id_as_form_cuti[]">';
                     
                        

            $tampil = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");

            while ($rows = mysql_fetch_array($tampil)){                            

                $name          = 'dept_id_as_form_cuti';
                $options       = $this->department_all_user($company=$rows['iCompanyId'],$nik=$session_nik);
                $selected      = $this->current_admin_form_cuti($nik=$session_nik);

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

    public function department_all_user($company,$nik){

        $query   = mysql_query('SELECT * FROM tbl_dept INNER JOIN tbl_div ON iDeptDivID=iDivId WHERE companyID='.$company.' ORDER BY cDivName ASC');
        $total   = mysql_num_rows($query);
        $results = array();

        while($data = mysql_fetch_assoc($query)){
           $results[] = $data['iDeptID'];
        }

        return $results;

    }

    public function current_admin_form_cv($nik){

        $sql  = "SELECT * FROM tbl_group_admin";

        if (!is_null($nik)){

            $sql  .= " WHERE admin_group_nik=".$nik;
        }
        else {
            $sql  .= " WHERE admin_group_nik=0";
        }


        $query  = mysql_query($sql);
        $total  = mysql_num_rows($query);


        $results = array();
        while($data = mysql_fetch_assoc($query))
        {
           $results[] = $data['admin_form_cv'];
        }

        return $results;



    }

    public function current_admin_form_cuti($nik){

        $sql  = "SELECT * FROM tbl_group_admin";

        if (!is_null($nik)){

            $sql  .= " WHERE admin_group_nik=".$nik;
        }
        else {
            $sql  .= " WHERE admin_group_nik=0";
        }

        $query  = mysql_query($sql);

        //$query  = mysql_query('SELECT * FROM tbl_group_admin WHERE admin_group_nik='.$nik);
        $total  = mysql_num_rows($query);


        $results = array();
        while($data = mysql_fetch_assoc($query))
        {
           $results[] = $data['admin_form_cuti'];
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

    public function current_nik_admin($nik){

        $query  = mysql_query('SELECT * FROM tbl_group_admin WHERE admin_group_nik='.$nik);
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        if ($total >0){
            return 1;
        }
        else {
            return 0;
        }


    }

 

    public function _callback_column_admin_form_cv($value, $row){

        $query  = mysql_query('SELECT * FROM tbl_group_admin INNER JOIN tbl_dept ON admin_form_cv=iDeptID INNER JOIN tbl_company ON companyID=iCompanyId WHERE admin_group_nik='.$row->admin_group_nik.' ORDER BY iDeptDivID ASC');
        $total  = mysql_num_rows($query);      

        $no   = 1;
        $dept = '';
        while ($data = mysql_fetch_array($query)){
            $dept .= $no.'. '.$data['cDeptName'].' ('.$data['cCompanyCode'].')';

            if ($no < $total){
               $dept .= ', ';
            }
        $no++;
        }

        if ($total >0){
            $tooltip = '<a href="#" style="text-decoration: none; color:#000000;" class="tip-top" data-toggle="tooltip" title="'.$dept.'">'.$total.' Department</a>';
        }
        else{
            $tooltip = '';
        }   
    
        //return '<strong>'.$total.' Department </strong>'.$tooltip;
        return $tooltip;

        //return '<a href="#" style="text-decoration: none;" class="glyphicon glyphicon-question-sign tip-top" data-toggle="tooltip" title="'.$dept.'">News <span class="badge">5</span></a>';
    }

    public function _callback_column_admin_form_cuti($value, $row){

        $style = '<style type="text/css">  

                a.my-tool-tip, a.my-tool-tip:hover, a.my-tool-tip:visited {
                  color: black;
                }

                a.tooltip {outline:none; }
                a.tooltip strong {line-height:30px;}
                a.tooltip:hover {text-decoration:none;} 
                a.tooltip span {
                    z-index:10;display:none; padding:14px 20px;
                    margin-top:-30px; margin-left:28px;
                    width:300px; line-height:16px;
                }
                a.tooltip:hover span{
                    display:inline; position:absolute; color:#111;
                    border:1px solid #DCA; background:#fffAF0;}
                .callout {z-index:20;position:absolute;top:30px;border:0;left:-12px;}
                    
                /*CSS3 extras*/
                a.tooltip span {
                    border-radius:4px;
                    box-shadow: 5px 5px 8px #CCC;
                }
            </style>';

        $query  = mysql_query('SELECT * FROM tbl_group_admin INNER JOIN tbl_dept ON admin_form_cuti=iDeptID INNER JOIN tbl_company ON companyID=iCompanyId WHERE admin_group_nik='.$row->admin_group_nik.' ORDER BY iDeptDivID ASC');
        $total  = mysql_num_rows($query);        

        $no   = 1;
        $dept = '';
        while ($data = mysql_fetch_array($query)){
            $dept .= $no.'. '.$data['cDeptName'].' ('.$data['cCompanyCode'].')';

            if ($no < $total){
               $dept .= ', ';
            }
        $no++;
        }

        if ($total >0){
            //$tooltip = '<a href="#" style="text-decoration: none;" class="glyphicon glyphicon-question-sign tip-top" data-toggle="tooltip" title="Check jika masa berlaku KTP seumur hidup"></a>';
            $tooltip = '<a href="#" style="text-decoration: none; color:#000000;" class="tip-top" data-toggle="tooltip" title="'.$dept.'">'.$total.' Department</a>';
        }
        else{
            $tooltip = '';
        }      
    
        //return '<strong>'.$total.' Department </strong>'.$tooltip.$style;
        return $tooltip.$style;


    }


    public function find_the_greatest($one, $two, $three){

        if ($one>$two){
           if($one>$three){
                return 1;
            }
           else{
                return 3;
            }
         }
        else{
        if ($two>$three){
            return 2;
        }

        else{
            return 3;
        }
        } 


    }

    public function update_tbl_main_group_user($value){

        $query  = mysql_query("SELECT * FROM tbl_main_group_user WHERE user_id='".$value."' AND group_id=55");
        $total  = mysql_num_rows($query);

        $group_id = 55;

        if ($total ==0){
             mysql_query('INSERT INTO tbl_main_group_user (group_id,user_id) VALUES ("'.$group_id.'","'.$value.'")');
        }


    }

   

   

}