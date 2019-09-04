<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Master_Company
 *
 * @author No-CMS Module Generator
 */
class frmListHakCuti extends CMS_Priv_Strict_Controller {

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
        $session_nik        = $this->cms_user_id();
        $_SESSION['NIK']    = $session_nik;        
        $today              = date('Y-m-d H:i:s');
        $company_id         = $this->cms_get_config('cms_astel_id');
        $hrd_modules        = $this->cms_get_config('hrd_profile_modules');


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
		$crud->unset_texteditor('Keperluan');
        $crud->unset_texteditor('HakRemark');
        //$crud->unset_operations(); // it s a view
		
        // $crud->unset_add();
        // $crud->unset_edit();
        // $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        // $crud->unset_export();
        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');
            //$crud->set_relation('NIK', $this->cms_complete_table_name('profile'), 'NIK',array('CompanyId !=' => 2));
            //$crud->unset_edit();
            $crud->set_relation('companyID', $this->cms_complete_table_name('company'), 'cCompanyCode',array('iCompanyId' => $company_id));
            $crud->display_as('NIK','NIK');
        }
        else {
            $crud->set_relation('NIK', $this->cms_complete_table_name('profile'), '{Nama} - {NIK}',array('CompanyId' => $company_id));
            $crud->set_relation('companyID', $this->cms_complete_table_name('company'), 'cCompanyName',array('iCompanyId' => $company_id));
            $crud->display_as('NIK','Nama');
        }


        // query for search dropdown
        $list = $this->uri->segment(4);

        if ($this->uri->segment(4) !=0 && !is_null($this->uri->segment(4)) && isset($list)){
            $crud->where('tbl_hakcuti.NIK', $this->uri->segment(4));
            $crud->where('tbl_hakcuti.companyID', $company_id);
            $crud->order_by('HakId','ASC');
        }
        else {
            $crud->where('tbl_hakcuti.NIK >=', 0);
            $crud->where('tbl_hakcuti.companyID', $company_id);
            $crud->order_by('HakId','ASC');
            //$crud->unset_add();
            //$crud->unset_edit();
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
        $crud->set_table($this->cms_complete_table_name('hakcuti'));
        $crud->where('tbl_hakcuti.companyID', $company_id);
        $crud->order_by('NIK','ASC');
       

        // primary key
        $crud->set_primary_key('HakId');

        // set subject
        $crud->set_subject('Daftar Hak Cuti');

        // displayed columns on list
		$crud->columns('NIK','NIK2','Periode1','Periode2','PeriodeExt','JenisHakCuti','Qty','QtyPakai','StatusHak','companyID');

        $crud->edit_fields('companyID','NIK','Periode1','Periode2','PeriodeKerja1','PeriodeKerja2','PeriodeExt','JenisHakCuti','Qty','QtyPakai','StatusHak','HakRemark');
		$crud->add_fields('companyID','NIK','Periode1','Periode2','PeriodeKerja1','PeriodeKerja2','PeriodeExt','JenisHakCuti','Qty','QtyPakai','StatusHak','HakRemark');
		
        // displayed columns on edit operation
       
		//$crud->edit_fields('NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','Alamat','Kodepos','Telp','Hp','Email','AlamatKTP','StatusDiri','TglMenikah','TglMasuk','TglKeluar','BandSkrg','Status','CompanyId','DivisiID','DeptID','UnitID','JabatanID','JmlAnak');

		
        // displayed columns on add operation
		
		//$crud->add_fields('NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','Alamat','Kodepos','Telp','Hp','Email','AlamatKTP','StatusDiri','TglMenikah','TglMasuk','TglKeluar','BandSkrg','Status','CompanyId','DivisiID','DeptID','UnitID','JabatanID','JmlAnak');
		$crud->change_field_type('Qty', 'integer');
        $crud->change_field_type('QtyPakai', 'integer');


        // caption of each columns		
				
        $crud->display_as('NIK2','Nama');
        
        $crud->display_as('Periode1','Periode Mulai Berlaku');
        $crud->display_as('Periode2','Periode Akhir Berlaku');
        $crud->display_as('JenisHakCuti','Jenis Cuti');
        $crud->display_as('QtyPakai','Qty Pakai');
        $crud->display_as('StatusHak','Status');
        $crud->display_as('PeriodeExt','Diperpanjang');
        $crud->display_as('PeriodeKerja1','Hak cuti thn kerja 1');
        $crud->display_as('PeriodeKerja2','Hak cuti thn kerja 2');
        $crud->display_as('companyID','Company');
        $crud->display_as('HakRemark','Remark');


        
				
		
		// $crud->required_fields( $field1, $field2, $field3, ... );
		$crud->required_fields('companyID','NIK','Periode1','Periode2','JenisHakCuti','QtyPakai','StatusHak','PeriodeKerja1','PeriodeKerja2');
       
		
		//$crud->unique_fields( $field1, $field2, $field3, ... );
		//$crud->unique_fields('NIK');
       		

		
        $crud->set_relation('JenisHakCuti', $this->cms_complete_table_name('jeniscuti'), 'JenisCutiName',array('id !=' => 0));
        
        //$crud->set_relation('DivisiID', $this->cms_complete_table_name('div'), 'cDivName');
        //$crud->set_relation('DeptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        //$crud->set_relation('UnitID', $this->cms_complete_table_name('unit'), 'NamaUnit');
       // $crud->set_relation('JabatanID', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');

        //$crud->set_relation('StatusDiri', $this->cms_complete_table_name('StatusDiri'), 'StatusDiriName');
        //$crud->set_relation('Agama', $this->cms_complete_table_name('Agama'), 'agama_name');      	
			
		$crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));
        $crud->callback_column('FormCutiNIK',array($this,'_callback_edit_url'));
        $crud->callback_column('Periode1',array($this,'_Date1_call'));
        $crud->callback_column('Periode2',array($this,'_Date2_call'));
        $crud->callback_column('PeriodeExt',array($this,'_callback_column_PeriodeExt'));

        $crud->callback_column('NIK2',array($this,'_callback_column_NIK2'));
       // $crud->callback_column('Nama',array($this,'_callback_edit_url'));

        $crud->callback_add_field('Qty', array($this, '_callback_add_field_Qty'));

        $this->crud = $crud;
        return $crud;
    }

    public function index(){
        $crud = $this->make_crud();
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $output = $crud->render();
        $this->view($this->cms_module_path().'/frmListHakCuti_view', $output,
            $this->cms_complete_navigation_name('frmListHakCuti'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('hakcuti'),array('HakId'=>$id));
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

        $this->db->select('*')
                     //->from('tbl_hakcuti')
                     ->from($this->cms_complete_table_name('hakcuti'))
                     ->where('HakId', $primary_key);
            $db         = $this->db->get();
            $row        = $db->row(0);
            $NIK        = $row->NIK;
            $Periode1   = $row->Periode1;
            $Periode2   = $row->Periode2;
            $PeriodeKerja1 = $row->PeriodeKerja1;
            $PeriodeKerja2 = $row->PeriodeKerja2;



    if($post_array['JenisHakCuti'] == 1){

    $input1         = strtotime($Periode1);
    $input2         = strtotime($Periode2);

    $input3         = strtotime($PeriodeKerja1);
    $input4         = strtotime($PeriodeKerja2);

    $Periode1       = date('Y-m-d',strtotime('+1 year',$input1));
    $Periode2       = date('Y-m-d',strtotime('+1 year',$input2));

    $PeriodeKerja1  = date('Y-m-d',strtotime('+1 year',$input3));
    $PeriodeKerja2  = date('Y-m-d',strtotime('+1 year',$input4)); 

    $Peri1      = date('Y-m-d',strtotime('-1 year',$input1));
    $Peri2      = date('Y-m-d',strtotime('-1 year',$input2));
    
    // Add Form Cuti
    $aku = mysql_query("SELECT * FROM `tbl_formcutimasal` INNER JOIN tbl_formcutimasaldetail ON 
                        tbl_formcutimasal.CutiId = tbl_formcutimasaldetail.CutiId 
                        WHERE TglCuti >='$Peri1' AND TglCuti <='$Peri2' 
                        GROUP BY tbl_formcutimasal.CutiId 
                        ORDER BY tbl_formcutimasal.CutiId ASC");
          
          while ($rw = mysql_fetch_array($aku)){            
            mysql_query("INSERT INTO tbl_formcuti(FormCutiNIK,
                                                  HakCutiId,
                                                  JenisCuti,
                                                  StatusForm,
                                                  Keperluan,
                                                  Alamat,
                                                  NoTelpon,
                                                  Pengganti,
                                                  TglMasuk,
                                                  active_id,
                                                  ApvLevel,
                                                  NIK1,
                                                  NIK2,
                                                  NIK3,
                                                  Apv1,
                                                  Apv2,
                                                  Apv3,
                                                  Tgl1,
                                                  Tgl2,
                                                  Tgl3,
                                                  CreatedBy,
                                                  CreatedTime,
                                                  companyID) 
                                    VALUES ('$NIK',
                                            '$primary_key',
                                            '4',
                                            'A',
                                            '$rw[Keperluan]',
                                            '$rw[Alamat]',
                                            '$rw[NoTelpon]',
                                            '$rw[Pengganti]',
                                            '$rw[TglMasuk]',
                                            '1',
                                            '3',
                                            '$rw[NIK1]',
                                            '$rw[NIK2]',
                                            '$rw[NIK3]',
                                            'A',
                                            'A',
                                            'A',
                                            '$rw[Tgl1]',
                                            '$rw[Tgl2]',
                                            '$rw[Tgl3]',
                                            '$rw[CreatedBy]',
                                            '$rw[CreatedTime]',                                         
                                            '$post_array[companyID]')");
                                        
            $CutiId = mysql_insert_id();
            
                
                
          // Add Cuti Detail 
          $akb = mysql_query("SELECT * FROM `tbl_formcutimasaldetail` 
                                WHERE CutiId = '$rw[CutiId]' 
                                ORDER BY CutiId ASC");
          
          while ($rwd = mysql_fetch_array($akb)){            
            
            mysql_query("INSERT INTO tbl_formcutidetail(CutiId,
                                                  TglCuti,
                                                  active_id) 
                                    VALUES ('$CutiId',
                                            '$rwd[TglCuti]',
                                            '1')");
            
            
                
          
          }
          
          
          }

        // save data utang cuti to new period
        mysql_query("UPDATE tbl_formcuti SET HakCutiId = '".$primary_key."' WHERE FormCutiNIK = '".$NIK."' AND HakCutiId=0");



        }

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

        $this->db->delete($this->cms_complete_table_name('formcuti'),
              array('HakCutiId'=>$primary_key));        

        mysql_query("DELETE  FROM tbl_formcutidetail WHERE CutiId IN (SELECT  CutiId FROM tbl_formcuti WHERE HakCutiId =".$primary_key.")");
        //mysql_query("DELETE FROM tbl_formcuti WHERE HakCutiId =".$primary_key);

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
         
         $query = $this->db->query('SELECT NIK,Nama FROM tbl_profile WHERE NIK='.$row->FormCutiNIK);
     
       foreach ($query->result() as $rown){
        //return $row->Nama.'Ku';
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->CutiId)."'>".$rown->Nama."</a>";
        
        }   //return 

        //return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->CutiId)."'>".$row->CutiId."</a>";
       
        
    }


    // add hyperlink
    public function _callback_column_NIK2($value, $row){

        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('profile'))     
            ->where('NIK', $row->NIK)
            ->get(); 

    
        foreach ($query->result() as $rown){
            return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->HakId)."'>$rown->Nama</a>";
        }
   
    
        
    }


    // change dPeriodEndDate format to d-M-Y
    public function _Date1_call($value, $row){
        //return $value." - scale: <b>".$row->date."</b>";
        $Date1 = date('d-M-Y', strtotime($row->Periode1));
        return $Date1;
        
    }

    // change dPeriodEndDate format to d-M-Y
    public function _Date2_call($value, $row){
        //$session_id = $this->cms_user_name();
        //return $value." - scale: <b>".$row->date."</b>";
        $Date2 = date('d-M-Y', strtotime($row->Periode2));
        return $Date2;
        
    }


    public function _callback_add_field_Qty(){
        /*
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))     
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
     */      // ->get();        
    return "<input type='text' value='12' name='Qty'>";
       /* foreach ($query->result() as $rown){
           
     */ //  }   
        
    }

    public function _callback_column_NIK22($value, $row){    
        return $row->NIK;        
    }


    // change dPeriodEndDate format to d-M-Y
    public function _callback_column_PeriodeExt($value, $row){
        //$session_id = $this->cms_user_name();
        //return $value." - scale: <b>".$row->date."</b>";
        if (!is_null($row->PeriodeExt) || $row->PeriodeExt !=""){
            $Date2 = date('d-M-Y', strtotime($row->PeriodeExt));
        }
        else {
            $Date2 = "";
        }
        return $Date2;
        
    }


  




}