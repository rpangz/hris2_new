<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class frmSubstitutionPotential extends CMS_Priv_Strict_Controller {

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
        

        $crud->unset_add();
        // $crud->unset_edit();
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('no-action-flexigrid');            
        }
        else{
            $crud->set_relation('NIK', $this->cms_complete_table_name('profile'), 'Nama' ,NULL);
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
      

        $crud->set_table($this->cms_complete_table_name('profile'));

/*
        $list = $this->uri->segment(4);
        if ($this->uri->segment(4) !=0 && !is_null($this->uri->segment(4)) && isset($list)){
            $crud->where('hrd_company', $this->uri->segment(4));
        }       
        else {
            $crud->where('hrd_company >=', 0);          
        }
*/
        //$where = "iTransPeriodId =".$this->uri->segment(4)." AND cTransCode LIKE".$this->uri->segment(5);
        //$crud->where($where);

        //$crud->where('iTransPeriodId', $this->uri->segment(4));
        //$crud->like('cTransCode',$this->uri->segment(4));
        $crud->where('bStatus', 1);

        $crud->order_by('NIK','ASC');
        //$crud->order_by('iGroupApprovalListId','ASC');
        // primary key
        $crud->set_primary_key('NIK');

        $crud->set_subject('Substitution Potential');

        //$crud->unset_add_fields('iTransCreateBy','dTransCreateTime');
        
        $crud->field_type('NIK','readonly');

        //$crud->field_type('iTransCreateBy', 'hidden', $session_id);
        //$crud->field_type('dTransCreateTime', 'hidden', $today);
        //$crud->field_type('iTransUpdateBy', 'hidden', $session_id);
        //$crud->field_type('dTransUpdatetime', 'hidden', $today);

        $crud->columns('NIK','Nama','PotentialNIK');
        $crud->edit_fields('NIK','PotentialNIK');
        $crud->add_fields('NIK','PotentialNIK');
            
       
        $crud->display_as('PotentialNIK','Potential');
        

        

        //$crud->unique_fields('hrd_nik');

        //$crud->set_relation('hrd_company', $this->cms_complete_table_name('company'), 'cCompanyName');
        //$crud->set_relation('divisionID', $this->cms_complete_table_name('div'), 'cDivName');
        //$crud->set_relation('deptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        

        //$crud->field_type('bTransStatus','enum',array('0','READY','1','OUT'));
        //$crud->field_type('bTransStatus', 'true_false', array('Returned', 'Out'));

        //$crud->set_relation('typeID','tbl_type','cTypeName');  
                    

    


        //$crud->set_relation('NIK', $this->cms_complete_table_name('profile'), 'Nama' ,NULL);

      
        $crud->callback_column('Nama',array($this,'_callback_column_NIK'));
        
        //$crud->add_action('print', '', '','ui-icon-image',array($this,'just_a_test'));
        //$crud->add_action('More', '', 'demo/action_more','ui-icon-plus');
        
            
        $crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));


        $crud->callback_edit_field('PotentialNIK', array($this, '_callback_edit_field_PotentialNIK'));


        //$crud->callback_column('hrd_name', array($this, '_callback_column_hrd_name'));
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
        
        $this->view($this->cms_module_path().'/frmSubstitutionPotential_view', $output,
            $this->cms_complete_navigation_name('frmSubstitutionPotential'));
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
        $session_nik = $this->uri->segment(5);
        mysql_query('DELETE FROM tbl_substitution_potential WHERE CurrentNIK='.$session_nik);

        return $post_array;
    }

    public function _after_update($post_array, $primary_key){
        $success = $this->_after_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here       

        $session_nik = $this->uri->segment(5);

        foreach ($_POST['PotentialNIK'] as $nik_potential){

            mysql_query('INSERT INTO tbl_substitution_potential (CurrentNIK,PotentialNIK) VALUES ("'.$session_nik.'","'.$nik_potential.'")');

          
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
    public function _callback_column_NIK($value, $row){    
    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->NIK)."'>$value</a>";
        
    }

    public function _callback_state_action(){
        $crud = $this->new_crud();
        $state = $crud->getState();
        return $state;    
    }

    public function _callback_edit_field_PotentialNIK(){

        $session_nik = $this->uri->segment(5);

        $empty_select        = '<select data-live-search="true" style="width: 100%; display: none;" class="selectpicker form-control" multiple="multiple" data-container="body" data-header="Pilih Karyawan Substitusi Potensial (Maksimal 4 Orang)" name="nik_potential[]" id="nik_potential[]">';
        $empty_select_closed = '</select>';             
                        

                        $tampil = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");

                        while ($rows = mysql_fetch_array($tampil)){

                            

                            $name       = 'nik_potential';
                            $options    = $this->potential_all_user($company=$rows['iCompanyId'],$nik=$session_nik);
                            $selected   = $this->current_substitution_potential($nik=$session_nik);

                            $empty_select .= '<optgroup label="'.$rows['cCompanyName'].'"';
                            $empty_select .= $this->multi_dropdown($name, $options, $selected );
                            $empty_select .= '</optgroup>';

                        }  
                         
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

   







}