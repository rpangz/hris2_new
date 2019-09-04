<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Master_Company
 *
 * @author No-CMS Module Generator
 */
class frmPerpCuti extends CMS_Priv_Strict_Controller {

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
        $session_nik = $this->cms_user_id();
        $today = date('Y-m-d H:i:s');
        $hrd_modules = $this->cms_get_config('hrd_cuti_modules');
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
		$crud->unset_texteditor('Alamat');
        $crud->unset_texteditor('Keperluan');
        
		
        // $crud->unset_add();
        //$crud->unset_edit();
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();
        $my_profile = $this->_callback_my_profile();

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('no-action-flexigrid');
            //$crud->unset_edit();
            $crud->set_relation('NIK2', $this->cms_complete_table_name('profile'), '{Nama}');
        }else{
            $crud->set_theme('no-flexigrid_1');
            $crud->set_primary_key('hrd_nik',$this->cms_complete_table_name('apv_hrd'));
            $crud->set_relation('NIK2', $this->cms_complete_table_name('apv_hrd'), '{hrd_name} [{hrd_email}]',array('hrd_status' =>1,'hrd_company' => $my_profile['company'], 'hrd_modules' => $hrd_modules));

        }

        $crud->set_relation('HakCutiId', $this->cms_complete_table_name('hakcuti'), '{JenisHakCuti}');
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
        $crud->set_table($this->cms_complete_table_name('formperpcuti'));

        $list = $this->uri->segment(4);
        if ($this->uri->segment(4) !=0 && !is_null($this->uri->segment(4)) && isset($list)){
            $crud->where('JenisHakCuti', $this->uri->segment(4));
        }       
        else {
            $crud->where('JenisHakCuti >=', 0);          
        }

        $crud->where('tbl_formperpcuti.NIK', $session_nik);
        $crud->order_by('FormPerpCutiId','DESC');
        // primary key
        $crud->set_primary_key('FormPerpCutiId');

        // set subject
        $crud->set_subject('Form Perpanjangan Cuti');
        $crud->unset_add_fields('CreatedBy','CreatedTime','Tgl1','Tgl2','Alasan');
        $crud->field_type('CreatedBy', 'hidden', $session_nik);
        $crud->field_type('CreatedTime', 'hidden', $today);
        $crud->field_type('Tgl1', 'hidden', $today);
        $crud->field_type('Tgl2', 'hidden', $today);

        // displayed columns on list
		$crud->columns('NIKKI','NIK','HakCutiId2','CreatedTime','StatusForm');
		
		
        // displayed columns on edit operation
       
		$crud->edit_fields('StatusForm','Alasan');

		
        // displayed columns on add operation
		
		$crud->add_fields('NIK','HakCutiId','NIK1','NIK2','CreatedBy','CreatedTime');
        // /$crud->add_fields('phone');
		


        // caption of each columns		
		$crud->display_as('NIK2','NIK');
        $crud->display_as('NIKKI','NIK');		
        $crud->display_as('NIK','Nama');
        $crud->display_as('HakCutiId','Periode Hak Cuti');
        $crud->display_as('TglActive2','Tgl Active2');
        $crud->display_as('Keperluan','Keperluan');
        $crud->display_as('StatusForm','Status Form');
        $crud->display_as('ApvLevel','Approval');
        $crud->display_as('NIK1','Menyetujui - Atasan');
        $crud->display_as('NIK2','Mengetahui - HRD');
        $crud->display_as('Apv1','Status Approval 1');
        $crud->display_as('Apv2','Status Approval 2');


        $crud->set_lang_string('form_save','Process');    
				
		
		// $crud->required_fields( $field1, $field2, $field3, ... );
		$crud->required_fields('NIK','HakCutiId','NIK1','NIK2','Apv1','Apv2','StatusForm','Alasan');
       
		
		//$crud->unique_fields( $field1, $field2, $field3, ... );
		//$crud->unique_fields('NIK');
       		

		$crud->set_relation('NIK', $this->cms_complete_table_name('profile'), 'Nama',array('NIK' => $session_nik));
        //$crud->set_relation('HakCutiId', $this->cms_complete_table_name('hakcuti'), '{Periode1} s/d {Periode2} [ {JenisHakCuti} ]');
        $crud->set_relation('Apv1', $this->cms_complete_table_name('statusform'), 'NamaStatusForm');
        $crud->set_relation('Apv2', $this->cms_complete_table_name('statusform'), 'NamaStatusForm');
        if ($state=='Add' || $state=='edit'){
            $crud->set_relation('StatusForm', $this->cms_complete_table_name('statusform'), 'NamaStatusForm',array('Id' => 4));
        }
        //$crud->set_relation('DivisiID', $this->cms_complete_table_name('div'), 'cDivName');
        //$crud->set_relation('DeptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        //$crud->set_relation('UnitID', $this->cms_complete_table_name('unit'), 'NamaUnit');
       // $crud->set_relation('JabatanID', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');

        //$crud->set_relation('StatusDiri', $this->cms_complete_table_name('StatusDiri'), 'StatusDiriName');
        //$crud->set_relation('Agama', $this->cms_complete_table_name('Agama'), 'agama_name');
        //$crud->set_relation('NIK2', $this->cms_complete_table_name('apv_hrd'), '{hrd_name} [{hrd_email}]',array('hrd_status' => 1, 'hrd_company' => $hrd_company));
      	
			
		$crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));
        //$crud->callback_column('CutiId',array($this,'_callback_edit_url'));
        //$crud->callback_column('TglActive1',array($this,'_Date1_call'));
        //$crud->callback_column('TglActive2',array($this,'_Date2_call'));
        $crud->callback_column('StatusForm',array($this,'_callback_column_StatusForm'));
        $crud->callback_column('NIKKI',array($this,'_callback_column_NIKKI'));
        $crud->callback_column('HakCutiId2',array($this,'_callback_column_HakCutiId'));

        $crud->callback_add_field('NIK1', array($this, '_callback_add_field_NIK1'));
        $crud->callback_edit_field('NIK1', array($this, '_callback_edit_field_NIK1'));

        $crud->callback_add_field('HakCutiId', array($this, 'empty_state_dropdown_select'));
        $crud->callback_edit_field('HakCutiId', array($this, 'empty_state_dropdown_select'));

        $crud->callback_edit_field('Alasan', array($this, '_callback_edit_field_Alasan'));
       

        $crud->callback_add_field('phone', array($this, '_callback_phone'));

        //$crud->callback_add_field('FormCutiNIK', array($this, '_callback_add_field_FormCutiNIK'));


        $this->crud = $crud;
        return $crud;
    }

    

    public function _example_output($output = null){
        //$this->view($this->cms_module_path().'modules/customers', $output);
        $data = array(
            'state' => $this->_callback_state_action(), 
        );

        $output   = array_merge((array)$output, $data);

        $this->view($this->cms_module_path().'/frmPerpCuti_view', $output,
        $this->cms_complete_navigation_name('frmPerpCuti'));    
    }


    

    public function index(){
        $crud = $this->make_crud();

        $dd_data = array(
                'dd_state' =>  $crud->getState(),             
                'dd_dropdowns' => array('NIK','HakCutiId'),                
                'dd_url' => array('', site_url().'/kehadiran/frmPerpCuti/get_states/', site_url().'/kehadiran/frmPerpCuti/get_cities/'),               
                'dd_ajax_loader' => base_url().'ajax-loader.gif'
            );      


        $output = $crud->render();
        $output->dropdown_setup = $dd_data;      
        $this->_example_output($output);
    }


    

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('formperpcuti'),array('FormPerpCutiId'=>$id));
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

        $segment4 = $this->uri->segment(4);
        $session_nik = $this->cms_user_id();

        //$dt       = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formperpcuti WHERE NIK=".$session_nik." ORDER BY FormPerpCutiId DESC LIMIT 1"));
        //$ID       = $dt['FormPerpCutiId'];
        $ID       = $primary_key;

        include "http://$_SERVER[SERVER_NAME]/hris2/includes/mailer/frmPerpCuti/SendMail.php?id=$ID&mynik=$session_nik&proses=1";
        echo "<script language='javascript'>alert('Data Sudah Disimpan dan Email sudah dikirim...');</script>";

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
        $ListingID = $this->uri->segment(5);
        $session_nik = $this->cms_user_id();

        //$dt       = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formperpcuti WHERE NIK=".$session_nik." AND FormPerpCutiId=".$ListingID));
        // $ID       = $dt['FormPerpCutiId'];
        $ID       = $primary_key;

        include "http://$_SERVER[SERVER_NAME]/hris2/includes/mailer/frmPerpCuti/SendMailVoid.php?id=$ID&mynik=$session_nik&proses=1";
        echo "<script language='javascript'>alert('Data Sudah Disimpan dan Email sudah dikirim...');history.go(-1);</script>";

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

    public function _callback_column_StatusForm($value, $row){     
     //return $value;
     //$query2 = $this->db->query('SELECT * FROM tbl_main_user WHERE user_id=2');
     $query2 = $this->db->query('SELECT * FROM tbl_statusform WHERE CodeStatusForm="'.$value.'"');
                           
     foreach ($query2->result() as $rown){       
            return '<span style="background-color:'.$rown->ColourStatusForm.'"><b>'.$rown->NamaStatusForm.'</b></span>';
      
       
     }     

        
    }

    public function _callback_column_NIKKI($value, $row){
        //return $value." - scale: <b>".$row->date."</b>";
        return $row->NIK;
        
    }


    //CALLBACK FUNCTIONS
    public function _callback_add_field_NIK1(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK1" class="chosen-select" data-placeholder="Select Mengetahui - Atasan" style="width: 500px; display: none;">';
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
            $empty_select .= '<option value="" disabled selected>Select Menyetujui - Atasan</option>';

            foreach($db->result() as $row):               
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.' ['.$row->Email.']</option>';
                
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;
    }


    //CALLBACK FUNCTIONS
    public function _callback_edit_field_NIK1(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="NIK1" class="chosen-select" data-placeholder="Select Mengetahui Atasan" style="width: 500px; display: none;">';
        $empty_select_closed= '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
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
            $this->db->select('*')
                     ->from('tbl_formperpcuti')
                     ->where('FormPerpCutiId', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $NIK1 = $row->NIK1;

            //GET THE CITIES PER STATE ID 

            $this->db->select('tbl_profile.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_profile.Email AS Email')
                     ->from($this->cms_complete_table_name('apv_group_approval'))
                     ->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID',$dta['DeptID'])
                     ->order_by('iGroupApprovalListId','ASC');

            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            $empty_select .= '<option value="" disabled selected>Select Mengetahui - Atasan</option>';

            foreach($db->result() as $row):

                if($row->NIK == $NIK1) {
                    $empty_select .= '<option value="'.$row->NIK.'" selected="selected">'.$row->Nama.' ['.$row->Email.']</option>';
                } else {
                    $empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.' ['.$row->Email.']</option>';
                }

                    //$empty_select .= '<option value="'.$row->NIK.'">'.$row->Nama.' ['.$row->Email.']</option>';
                
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;
    }


    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_select(){
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="HakCutiId" class="chosen-select" data-placeholder="Select Periode Hak Cuti" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        $today = date('Y-m-d');
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit"){
            //GET THE STORED STATE ID
            $this->db->select('NIK, HakCutiId')
                     ->from('tbl_formperpcuti')
                     ->where('FormPerpCutiId', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $NIK = $row->NIK;
            $HakCutiId = $row->HakCutiId;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('tbl_hakcuti')
                     ->where('NIK', $NIK)
                     ->where('PeriodeExt',NULL);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                $Periode1 = date('d-M-Y', strtotime($row->Periode1));
                $Periode2 = date('d-M-Y', strtotime($row->Periode2));

                $dta = mysql_fetch_array(mysql_query('SELECT count(FormCutiNIK) AS QtyPakai FROM tbl_formcuti INNER JOIN 
                                                    tbl_formcutidetail ON tbl_formcuti.CutiId = tbl_formcutidetail.CutiId 
                                                    WHERE tbl_formcuti.FormCutiNIK="'.$NIK.'" AND HakCutiId="'.$row->HakId.'" 
                                                    AND StatusForm="A" '));
                $jka      = mysql_fetch_array(mysql_query('SELECT * FROM tbl_jeniscuti WHERE id="'.$row->JenisHakCuti.'"'));

            //$soon     = date('Y-m-d', strtotime('+ '.$jka['LimitExp']));
            //$soon     = date('Y-m-d', strtotime('+ 6 Month'));
            //$soon     = date('Y-m-d',strtotime($row->Periode2) + ('6 Month')); //my preferred method
            $LimitExp = $jka['LimitExp'];
            $soon     = date('Y-m-d', strtotime($row->Periode2. ' + '.$LimitExp));
            $soon2    = date('Y-m-d', strtotime($soon));
            //$soon2     = date('d-M-Y',strtotime($soon)); //my preferred method
            //$soon2 = strtotime("+6 days", $row->Periode2);

            $inin         = strtotime($row->Periode2);

            $PerPer2       = date('Y-m-d',strtotime('-1 month',$inin));

            $Qty      = $row->Qty;
            $QtyPakai = $dta['QtyPakai'];
            $Sisa     = $Qty - $QtyPakai;
           

            if ($today > $soon || $Sisa <= 0 || $PerPer2 > $today){
                $HakId = "";
                $ne    ='Tidak Bisa Diperpanjang';
            }
            
            else{
                $HakId = $row->HakId;
                $ne    ='Bisa Diperpanjang';
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



                if($row->HakId == $HakCutiId) {
                    $empty_select .= '<option value="'.$row->HakId.'" selected="selected" '.$sati.'>'.$Periode1.' s/d'.$Periode2.'  [sisa : '.$Sisa.' hari]</option>';
                } else {
                    $empty_select .= '<option value="'.$row->HakId.'" '.$sati.'>'.$Periode1.' s/d'.$Periode2.'   [sisa : '.$Sisa.' hari]</option>';
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
    public function get_states(){
        $NIK = $this->uri->segment(4);
        $today = date('Y-m-d');
        
        $this->db->select("*")
                 ->from('tbl_hakcuti')
                 ->where('NIK', $NIK)
                 ->where('PeriodeExt',NULL);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $Periode1 = date('d-M-Y', strtotime($row->Periode1));
            $Periode2 = date('d-M-Y', strtotime($row->Periode2));

            

            $dta      = mysql_fetch_array(mysql_query('SELECT count(FormCutiNIK) AS QtyPakai FROM tbl_formcuti INNER JOIN 
                                                    tbl_formcutidetail ON tbl_formcuti.CutiId = tbl_formcutidetail.CutiId 
                                                    WHERE tbl_formcuti.FormCutiNIK="'.$NIK.'" AND HakCutiId="'.$row->HakId.'" 
                                                    AND StatusForm="A" '));

            $jka      = mysql_fetch_array(mysql_query('SELECT * FROM tbl_jeniscuti WHERE id="'.$row->JenisHakCuti.'"'));

            $LimitExp = $jka['LimitExp'];
            $soon     = date('Y-m-d', strtotime($row->Periode2. ' + '.$LimitExp));
            $soon2    = date('Y-m-d', strtotime($soon));

            $PeriodeExt     = date('Y-m-d', strtotime($row->PeriodeExt));
            //$soon2     = date('d-M-Y',strtotime($soon)); //my preferred method
            //$soon2 = strtotime("+6 days", $row->Periode2);

            $inin         = strtotime($row->Periode2);
            $PerPer2       = date('Y-m-d',strtotime('-1 month',$inin));

            $Qty      = $row->Qty;
            $QtyPakai = $dta['QtyPakai'];
            $Sisa     = $Qty - $QtyPakai;
           

            if ($today > $soon || $Sisa <= 0 || $PerPer2 > $today){
                $HakId = "";
                $ne    = 'Cuti '.$jka['JenisCutiName'].' No Available';
            }
            
            else{
                $HakId = $row->HakId;
                //$ne    = 'Bisa Diperpanjang '.$jka['JenisCutiCode'];
                $ne    = 'Cuti '.$jka['JenisCutiName'].' <b>Available</b>';
            }


            $array[] = array("value" => $HakId ,"property" => $Periode1.' s/d '.$Periode2.'   [sisa : '.$Sisa.' hari]'.' - '.$ne);
        endforeach;
        
        echo json_encode($array);
        exit;
    }


    // Add Type
    public function _callback_column_HakCutiId($value, $row){      
        $query = $this->db->query('SELECT Periode1,Periode2,PeriodeExt,JenisCutiName FROM tbl_hakcuti LEFT JOIN 
                                    tbl_jeniscuti ON tbl_hakcuti.JenisHakCuti = tbl_jeniscuti.id 
                                    WHERE HakId='.$row->HakCutiId); 

       foreach ($query->result() as $rown){
            $Periode1 = date('d-M-Y', strtotime($rown->Periode1));
            $Periode2 = date('d-M-Y', strtotime($rown->Periode2));
        return $Periode1.' s/d '.$Periode2.' ['.$rown->JenisCutiName.']';
        }   //return $array;

        
    }



    // Add Type
    public function _callback_edit_field_Alasan($value, $row){
        $ListingID = $this->uri->segment(5); 
        $query     = $this->db->query('SELECT StatusForm,Alasan FROM tbl_formperpcuti WHERE FormPerpCutiId='.$ListingID); 

       foreach ($query->result() as $rown){
        if ($rown->StatusForm =='P' OR $rown->StatusForm ==''){
            $ted = '';
        }
        else {
            $ted = 'disabled';
        }
        return "<input type='Text' maxlength='150' name='Alasan' $ted>";
        }   //return $array;

        
    }


    public function _callback_my_profile(){
      
        $result = mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$this->cms_user_id());
        $storeArray = Array();
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $storeArray['company'] =  $row['CompanyId'];
            $storeArray['dept'] =  $row['DeptID'];
            $storeArray['sex'] =  $row['Sex'];
            $storeArray['status_diri'] =  $row['StatusDiri'];  
        }

        return $storeArray;     
    
    }


    public function _callback_phone($value, $row){
        return "<a href='http://www.grocerycrud.com/assets/themes/default/images/logo.png' class='fancybox'>value</a>";
    }


    public function _callback_state_action(){
        $crud = $this->new_crud();
        $state = $crud->getState();
        return $state;    
    }


    
    

   


    


    


}