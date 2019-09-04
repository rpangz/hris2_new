<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class frmReview extends CMS_Priv_Strict_Controller {

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
    

       
        $session_id = $this->cms_user_id();
        $today = date('Y-m-d H:i:s');
        //$crud->set_theme('flexigrid');
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
        $crud->unset_texteditor('Alamat_Tinggal');

        if ($state == 'list'){
            $crud->unset_add();
        }

        
        if ($state != 'edit' && $state != 'add' && $state='read'){
             $crud->set_theme('flexigrid');
        }
        else {
            $crud->set_theme('no-flexigrid_1');
        }

      
        
        $crud->unset_edit();
        $crud->unset_delete();
        // $crud->unset_list();
        //$crud->unset_back_to_list();
        $crud->unset_print();
        $crud->unset_export();

        
        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_country_model');
        */

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

       
        $crud->set_lang_string('form_save','Register');
        

        // table name
      

		$crud->set_table($this->cms_complete_table_name('bpjs'));
        //$crud->set_rules('email', 'email','trim|required|xss_clean|callback_email_check');

        //$where = "iTransPeriodId =".$this->uri->segment(4)." AND cTransCode LIKE".$this->uri->segment(5);
        //$crud->where($where);

        //$crud->where('iTransPeriodId', $this->uri->segment(4));
        //$crud->like('cTransCode',$this->uri->segment(4));
        if ($this->uri->segment(4) !='' && !is_null($this->uri->segment(4) && $this->uri->segment(4) != 'index')){
            $crud->where('No_KK', $this->uri->segment(4));
        }

        else {
             $crud->where('No_KK','0');
        }

       
        //$crud->order_by('DeptID','ASC');
        // primary key
        $crud->set_primary_key('bpjs_Id');

        $crud->set_subject('BPJS');


        //$crud->unset_add_fields('iTransCreateBy','dTransCreateTime');
        //$crud->unset_edit_fields('iTransUpdateBy','dTransUpdatetime');

        //$crud->field_type('iTransCreateBy', 'hidden', $session_id);
        //$crud->field_type('dTransCreateTime', 'hidden', $today);
        //$crud->field_type('iTransUpdateBy', 'hidden', $session_id);
        //$crud->field_type('dTransUpdatetime', 'hidden', $today);

        $crud->columns('bpjs_Id','MotherNIK','MotherName','No_KK','No_KTP','Nama','PISA','Tempat_Lahir','Tgl_Lahir','Sex','Status_Kawin',
                            'Alamat_Tinggal','No_RT','No_RW','Kode_Pos',
                            'KDKEC','NMKEC','KDDESA','NMDESA',                            
                            'KDFaskes','NMFaskes','KDFaskesGigi','NMFaskesGigi',
                            'Nomor_Telp','email','NIK','Jabatan',
                            'Status_Karyawan','Kelas_Rawat','TMT','Gaji','Kewarganegaraan','No_Polis','Nama_Asuransi','No_NPWP',
                            'No_Passport','companyID','divisionID','deptID','CreateTime');


        $crud->edit_fields('MotherNIK','MotherName','No_KK','No_KTP','NIK','Nama','PISA','Tgl_Lahir','Tempat_Lahir','Sex','Status_Kawin',
                            'Alamat_Tinggal',
                            'KDPROP','KDDATI2','KDKEC','KDDESA',
                            'No_RT','No_RW','Kode_Pos',
                            'KDFaskes_KDPROP','KDFaskes_KDDATI2','KDFaskes','KDFaskesGigi',                             
                            'Kelas_Rawat','TMT','Gaji','Kewarganegaraan','No_NPWP','No_Passport',
                            'companyID','divisionID','deptID','Jabatan','Status_Karyawan','email','Nomor_Telp',
                            'No_Polis (Asuransi Lainnya)','Nama_Asuransi Lainnya');


        $crud->add_fields('MotherNIK','MotherName','No_KK','No_KTP','NIK','Nama','PISA','Tgl_Lahir','Tempat_Lahir','Sex','Status_Kawin',
                            'Alamat_Tinggal',
                            'KDPROP','KDDATI2','KDKEC','KDDESA',
                            'No_RT','No_RW','Kode_Pos',
                            'KDFaskes_KDPROP','KDFaskes_KDDATI2','KDFaskes','KDFaskesGigi',                            
                            'Kelas_Rawat','TMT','Kewarganegaraan','No_NPWP','No_Passport',
                            'companyID','divisionID','deptID','Jabatan','Status_Karyawan','email','Nomor_Telp',
                            'No_Polis (Asuransi Lainnya)','Nama_Asuransi Lainnya');
            
       
        $crud->display_as('bpjs_Id','1.No');
        $crud->display_as('No_KK','2.No KK');
        $crud->display_as('No_KTP','3.No KTP');       
        $crud->display_as('Nama','4.Nama Lengkap');
        $crud->display_as('PISA','5.PISA');
        $crud->display_as('Tempat_Lahir','6.Tempat Lahir');
        $crud->display_as('Tgl_Lahir','7.Tgl Lahir dd/mm/yyyy');
        $crud->display_as('Sex','8.Sex');
        $crud->display_as('Status_Kawin','9.Status Kawin');
        //$crud->display_as('Alamat_Tinggal','10.Alamat');
        $crud->display_as('Alamat_Tinggal','10.Alamat (Sesuai KTP)');
        $crud->display_as('No_RT','11.RT');
        $crud->display_as('No_RW','12.RW');
        $crud->display_as('Kode_Pos','13.Kodepos');
        $crud->display_as('KDKEC','14.Kode Kecamatan');
        $crud->display_as('NMKEC','15.Nama Kecamatan');
        $crud->display_as('KDDESA','16.Kode Desa');
        $crud->display_as('NMDESA','17.Nama Desa/Kel');
        $crud->display_as('KDFaskes','18.Kode Faskes Tk.1');
        $crud->display_as('NMFaskes','19.Nama Faskes Tk.1');
        $crud->display_as('KDFaskesGigi','20.Kode Faskes Gigi');
        $crud->display_as('NMFaskesGigi','21.Nama Faskes Gigi');
        $crud->display_as('Nomor_Telp','22.No Telp');
        $crud->display_as('email','23.Email');
        $crud->display_as('NIK','24.NIK');
        $crud->display_as('Jabatan','25.Jabatan');
        $crud->display_as('Status_Karyawan','26.Status Karyawan');
        $crud->display_as('Kelas_Rawat','27.Kelas Rawat');
        $crud->display_as('TMT','28.Tgl Aktif Peserta');
        $crud->display_as('Gaji','29.Gaji');
        $crud->display_as('Kewarganegaraan','30.Warga Negara');
        $crud->display_as('No_Polis','31.No Polis');
        $crud->display_as('Nama_Asuransi','32.Nama Asuransi');
        $crud->display_as('No_NPWP','33.No NPWP');
        $crud->display_as('No_Passport','34.No Passport');
        $crud->display_as('CreateTime','Tgl Input');
        $crud->display_as('companyID','Company');
        $crud->display_as('divisionID','Division');
        $crud->display_as('deptID','Departement');        
        $crud->display_as('KDPROP','Propinsi');
        $crud->display_as('KDDATI2','Kab/Kota');
        $crud->display_as('KDFaskes_KDPROP','Faskes Propinsi');
        $crud->display_as('KDFaskes_KDDATI2','Faskes Kab/Kota');
        $crud->display_as('MotherNIK','NIK Ibu Kandung');
        $crud->display_as('MotherName','Nama Ibu Kandung');
       
        //$crud->display_as('NMDESA','Desa');



        $crud->required_fields('No_KK','No_KTP','NIK','Nama','PISA','Tgl_Lahir','Tempat_Lahir','Sex','Status_Kawin',
                            'KDPROP','KDDATI2','KDKEC','KDDESA',
                            'Alamat_Tinggal','No_RT','No_RW','Kode_Pos',
                            'KDFaskes_KDPROP','KDFaskes_KDDATI2','KDFaskes','KDFaskesGigi',
                            'Nomor_Telp','email','Jabatan','Status_Karyawan',
                            'Kelas_Rawat','TMT','Kewarganegaraan',
                            'companyID','divisionID','deptID','MotherName');


        

        //$crud->unique_fields('Nama','No_KTP');

        $crud->set_relation('Sex', $this->cms_complete_table_name('bpjs_sex'), 'SexName');
        $crud->set_relation('Status_Kawin', $this->cms_complete_table_name('bpjs_statuskawin'), 'StatusDiriName');
        $crud->set_relation('PISA', $this->cms_complete_table_name('bpjs_pisa'), 'pisa_name');
        $crud->set_relation('Kelas_Rawat', $this->cms_complete_table_name('bpjs_kelas'), 'kelas_name');
        $crud->set_relation('Status_Karyawan', $this->cms_complete_table_name('bpjs_status'), 'StatusName');
        $crud->set_relation('Kewarganegaraan', $this->cms_complete_table_name('bpjs_nation'), 'nation_name');
        $crud->set_relation('Jabatan', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');
        


        $crud->set_relation('KDPROP', $this->cms_complete_table_name('propinsi'), 'NMPROP',array('KDNEGARA' => 'IDN'));
        $crud->set_relation('KDDATI2', $this->cms_complete_table_name('dati2'), '{KDDATI2} - {NMDATI2}');
        $crud->set_relation('KDKEC', $this->cms_complete_table_name('kec'), '{KDKEC}');
        $crud->set_relation('KDDESA', $this->cms_complete_table_name('desa'), '{KDDESA}');

        $crud->set_relation('companyID', $this->cms_complete_table_name('company'), 'cCompanyName');
        $crud->set_relation('divisionID', $this->cms_complete_table_name('div'), 'cDivName');
        $crud->set_relation('deptID', $this->cms_complete_table_name('dept'), 'cDeptName');

        //$crud->set_relation('deptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        $crud->set_relation('KDFaskes', $this->cms_complete_table_name('faskesumum'), '{KDFaskes}');
        $crud->set_relation('KDFaskesGigi', $this->cms_complete_table_name('faskesumum'), '{KDFaskes}');

        $crud->set_relation('KDFaskes_KDPROP', $this->cms_complete_table_name('propinsi'), 'NMPROP');
        $crud->set_relation('KDFaskes_KDDATI2', $this->cms_complete_table_name('dati2'), '{KDDATI2} - {NMDATI2}');
        

        //$crud->set_relation('typeID','tbl_type','cTypeName');

        //$crud->field_type('bTransStatus','enum',array('0','READY','1','OUT'));
        //$crud->field_type('bTransStatus', 'true_false', array('Returned', 'Out'));

        //$crud->set_relation('typeID','tbl_type','cTypeName');  
            
            //IF YOU HAVE A LARGE AMOUNT OF DATA, ENABLE THE CALLBACKS BELOW - FOR EXAMPLE ONE USER HAD 36000 CITIES AND SLOWERD UP THE LOADING PROCESS. THESE CALLBACKS WILL LOAD EMPTY SELECT FIELDS THEN POPULATE THEM AFTERWARDS
            

        

      
        //$crud->callback_column('Nama',array($this,'_callback_webpage_url'));
        
        //$crud->add_action('print', '', '','ui-icon-image',array($this,'just_a_test'));
        //$crud->add_action('More', '', 'demo/action_more','ui-icon-plus');
        //$crud->add_action('Smileys', 'http://astapp02/i-MAM2/assets/grocery_crud/themes/flexigrid/css/images/print.png', 'demo/action_smiley');
        //Z:\xampp\htdocs\i-MAM2\assets\grocery_crud\themes\flexigrid\css\images
      	
			
		$crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));

        //$crud->callback_add_field('divisionID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_edit_field('divisionID', array($this, 'empty_state_dropdown_select'));
        //$crud->callback_add_field('deptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_edit_field('deptID', array($this, 'empty_city_dropdown_select'));


        //function to dropdown multiselect
      
        $crud->callback_add_field('KDDATI2', array($this, 'empty_dati2_dropdown_select'));
        $crud->callback_edit_field('KDDATI2', array($this, 'empty_dati2_dropdown_select'));
        $crud->callback_add_field('KDKEC', array($this, 'empty_kec_dropdown_select'));
        $crud->callback_edit_field('KDKEC', array($this, 'empty_kec_dropdown_select'));
        $crud->callback_add_field('KDDESA', array($this, 'empty_desa_dropdown_select'));
        $crud->callback_edit_field('KDDESA', array($this, 'empty_desa_dropdown_select'));

        
        //$crud->callback_column('Asuransi_Lainnya',array($this, '_callback_column_citizen'));
        //$crud->callback_field('Asuransi_Lainnya',array($this, '_callback_field_citizen'));


        $crud->callback_add_field('KDFaskes_KDDATI2', array($this, 'empty_KDFaskes_KDDATI2_dropdown_select'));
        $crud->callback_edit_field('KDFaskes_KDDATI2', array($this, 'empty_KDFaskes_KDDATI2_dropdown_select'));
        $crud->callback_add_field('KDFaskes', array($this, 'empty_KDFaskes_dropdown_select'));
        $crud->callback_edit_field('KDFaskes', array($this, 'empty_KDFaskes_dropdown_select'));
        $crud->callback_add_field('KDFaskesGigi', array($this, 'empty_KDFaskesGigi_dropdown_select'));
        //$crud->callback_edit_field('KDFaskesGigi', array($this, 'empty_KDFaskesGigi_dropdown_select'));

        $crud->callback_column('Asuransi_Lainnya',array($this, '_callback_column_citizen'));

        $crud->callback_column('NMFaskes',array($this,'_callback_column_NMFaskes'));
        $crud->callback_column('NMFaskesGigi',array($this,'_callback_column_NMFaskesGigi'));

        $crud->callback_column('NMKEC',array($this,'_callback_column_NMKEC'));
        $crud->callback_column('NMDESA',array($this,'_callback_column_NMDESA'));

        //$crud->callback_column('No_KTP',array($this,'_callback_column_No_KTP'));
        //$crud->callback_column('No_KK',array($this,'_callback_column_No_KK'));
        //$crud->callback_column('Nomor_Telp',array($this,'_callback_column_Nomor_Telp'));
        //$crud->callback_column('No_NPWP',array($this,'_callback_column_No_NPWP'));

        
        $crud->callback_add_field('No_KK', array($this, '_callback_add_field_No_KK'));
        $crud->callback_add_field('NIK', array($this, '_callback_add_field_NIK'));
        $crud->callback_add_field('Jabatan', array($this, '_callback_add_field_Jabatan'));
        $crud->callback_add_field('email', array($this, '_callback_add_field_email'));
        $crud->callback_add_field('TMT', array($this, '_callback_add_field_TMT'));
        $crud->callback_add_field('companyID', array($this, '_callback_add_field_companyID'));
        $crud->callback_add_field('divisionID', array($this, '_callback_add_field_divisionID'));
        $crud->callback_add_field('deptID', array($this, '_callback_add_field_deptID'));
        $crud->callback_add_field('Status_Karyawan', array($this, '_callback_add_field_Status_Karyawan'));
        $crud->callback_add_field('Alamat_Tinggal', array($this, '_callback_add_field_Alamat_Tinggal'));
        $crud->callback_add_field('Nomor_Telp', array($this, '_callback_add_field_Nomor_Telp'));
        $crud->callback_add_field('No_RT', array($this, '_callback_add_field_No_RT'));
        $crud->callback_add_field('No_RW', array($this, '_callback_add_field_No_RW'));
        $crud->callback_add_field('Kode_Pos', array($this, '_callback_add_field_Kode_Pos'));
        $crud->callback_add_field('Kelas_Rawat', array($this, '_callback_add_field_Kelas_Rawat'));
        $crud->callback_add_field('Kewarganegaraan', array($this, '_callback_add_field_Kewarganegaraan'));
        $crud->callback_add_field('KDPROP', array($this, '_callback_add_field_KDPROP'));
        $crud->callback_add_field('KDFaskes_KDPROP', array($this, '_callback_add_field_KDFaskes_KDPROP'));

        $crud->callback_add_field('PISA', array($this, '_callback_add_field_PISA'));


        


        $this->crud = $crud;
        return $crud;
    }

    public function _example_output($output = null)
    {
        
        //http://astapp02/hris2/bpjs/frmRegistration/index/add
        //$this->view($this->cms_module_path().'modules/customers', $output);
        $this->view($this->cms_module_path().'/frmReview_view', $output,
        $this->cms_complete_navigation_name('frmReview'));    
    }


    

    public function index(){
       
        $crud = $this->make_crud();

        $dd_data11 = array(
                //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
                'dd_state11' =>  $crud->getState(),
                //SETUP YOUR DROPDOWNS
                //Parent field item always listed first in array, in this case countryID
                //Child field items need to follow in order, e.g stateID then cityID
                'dd_dropdowns11' => array('companyID','divisionID','deptID'),
                //SETUP URL POST FOR EACH CHILD
                //List in order as per above
                'dd_url11' => array('', site_url().'/bpjs/frmRegistration/get_states/', site_url().'/bpjs/frmRegistration/get_cities/'),
                //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
                'dd_ajax_loader11' => base_url().'ajax-loader.gif'
            );

        $dd_data22 = array(
                //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
                'dd_state22' =>  $crud->getState(),
                //SETUP YOUR DROPDOWNS
                //Parent field item always listed first in array, in this case countryID
                //Child field items need to follow in order, e.g stateID then cityID
                'dd_dropdowns22' => array('KDPROP','KDDATI2','KDKEC','KDDESA'),
                //SETUP URL POST FOR EACH CHILD
                //List in order as per above
                'dd_url22' => array('', site_url().'/bpjs/frmRegistration/get_dati2/', site_url().'/bpjs/frmRegistration/get_kec/', site_url().'/bpjs/frmRegistration/get_desa/'),
                //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
                'dd_ajax_loader22' => base_url().'ajax-loader.gif'
            );

        $dd_data33 = array(
                //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
                'dd_state33' =>  $crud->getState(),
                //SETUP YOUR DROPDOWNS
                //Parent field item always listed first in array, in this case countryID
                //Child field items need to follow in order, e.g stateID then cityID
                'dd_dropdowns33' => array('KDFaskes_KDPROP','KDFaskes_KDDATI2','KDFaskes','KDFaskesGigi'),
                //SETUP URL POST FOR EACH CHILD
                //List in order as per above
                'dd_url33' => array('', site_url().'/bpjs/frmRegistration/get_KDFaskes_KDDATI2/', site_url().'/bpjs/frmRegistration/get_KDFaskes/',site_url().'/bpjs/frmRegistration/get_KDFaskesGigi/'),
                //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
                'dd_ajax_loader33' => base_url().'ajax-loader.gif'
            );


        


            $output = $crud->render();
            $output->dropdown_setup11 = $dd_data11;
            $output->dropdown_setup22 = $dd_data22;
            $output->dropdown_setup33 = $dd_data33;
           
            
            $this->_example_output($output);

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // render
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //$output = $crud->render();
        //$this->view($this->cms_module_path().'/customers_view', $output,
          //  $this->cms_complete_navigation_name('Customers'));
    }

    public function delete_selection(){
        $crud = $this->make_crud();
        if(!$crud->unset_delete){
            $id_list = json_decode($this->input->post('data'));
            foreach($id_list as $id){
                if($this->_before_delete($id)){
                    $this->db->delete($this->cms_complete_table_name('bpjs'),array('bpjs_Id'=>$id));
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

        $No_KK      = $post_array['No_KK'];
        $email      = $post_array['email'];
        $companyID  = $post_array['companyID'];

        include "http://".$_SERVER['SERVER_NAME']."/hris2/includes/mailer/bpjs/frmRegistration.php?primary_key=".$primary_key."&company=".$companyID;

        echo "<script language='javascript'>alert('Data Sudah Disimpan dan Email sudah dikirim ke Anda dan HRD...');</script>";


        return $success;

      

    }

    public function _before_update($post_array, $primary_key){
        $post_array = $this->_before_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here
        return $post_array;
    }

    public function _after_update($post_array, $primary_key){

    //$id_child = $primary_key;
    //echo"<script>window.open('http://astapp02/hris2/child/bpjs/print.php?id=$id_child');</script>";


        $success = $this->_after_insert_or_update($post_array, $primary_key);
        // HINT : Put your code here
        return $success;

        
    }

    public function _before_delete($primary_key){

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
        $data = json_decode($this->input->post('md_real_field_citizen_col'), TRUE);
        $insert_records = $data['insert'];
        $update_records = $data['update'];
        $delete_records = $data['delete'];
        $real_column_names = array('asuransi_id', 'bpjs_Id', 'asuransi_name', 'asuransi_no');
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
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $where = array(
                    $relation_column_name => $detail_primary_key
                );
                $this->db->delete($table_name, $where);
            }
            $this->db->delete($this->cms_complete_table_name('bpjs_asuransi'),
                 array('asuransi_id'=>$detail_primary_key));
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
            $data['bpjs_Id'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('bpjs_asuransi'),
                 $data, array('asuransi_id'=>$detail_primary_key));
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Updated Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $update_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
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
            $data['bpjs_Id'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('bpjs_asuransi'), $data);
            $detail_primary_key = $this->db->insert_id();
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Adjust Many-to-Many Fields of Inserted Data
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            for($i=0; $i<count($many_to_many_column_names); $i++){
                $key =     $many_to_many_column_names[$i];
                $new_values = $insert_record['data'][$key];
                $table_name = $this->cms_complete_table_name($many_to_many_relation_tables[$i]);
                $relation_column_name = $many_to_many_relation_table_columns[$i];
                $relation_selection_column_name = $many_to_many_relation_selection_columns[$i];
                $query = $this->db->select($relation_column_name.','.$relation_selection_column_name)
                    ->from($table_name)
                    ->where($relation_column_name, $detail_primary_key)
                    ->get();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // delete everything which is not in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                $old_values = array();
                foreach($query->result_array() as $row){
                    $old_values = array();
                    if(!in_array($row[$relation_selection_column_name], $new_values)){
                        $where = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $row[$relation_selection_column_name]
                        );
                        $this->db->delete($table_name, $where);
                    }else{
                        $old_values[] = $row[$relation_selection_column_name];
                    }
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                // add everything which is not in old_values but in new_values
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                foreach($new_values as $new_value){
                    if(!in_array($new_value, $old_values)){
                        $data = array(
                            $relation_column_name => $detail_primary_key,
                            $relation_selection_column_name => $new_value
                        );
                        $this->db->insert($table_name, $data);
                    }
                }
            }
        }

        return TRUE;
    }


    // returned on insert and edit
    public function _callback_field_citizen($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('asuransi_id, bpjs_Id, asuransi_name, asuransi_no')
            ->from($this->cms_complete_table_name('bpjs_asuransi'))
            ->where('bpjs_Id', $primary_key)
            ->get();
        $result = $query->result_array();
        // add "hobby" to $result
       

        // get options
        $options = array();
        
        
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
        );
        return $this->load->view($this->cms_module_path().'/field_bpjs_asuransi',$data, TRUE);
    }

    // returned on view
    public function _callback_column_citizen($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('asuransi_id, bpjs_Id, asuransi_name, asuransi_no')
            ->from($this->cms_complete_table_name('bpjs_asuransi'))
            ->where('bpjs_Id', $row->bpjs_Id)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' Asuransi';
        }else if($num_row>0){
            return $num_row .' Asuransi';
        }else{
            return 'No Asuransi';
        }
    }

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }

    // add hyperlink
    public function _callback_edit_url($value, $row){    
    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->customerNumber)."'>$value</a>";
        
    }


    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_select()
    {
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
            $this->db->select('companyID, divisionID, deptID')
                     ->from('tbl_bpjs')
                     ->where('bpjs_Id', $listingID);
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
            $this->db->select('companyID, divisionID, deptID, unitID')
                     ->from('tbl_bpjs')
                     ->where('bpjs_Id', $listingID);
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
        $divisionID = $this->uri->segment(5);
        
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



   
    //CALLBACK FUNCTIONS
    public function empty_dati2_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="KDDATI2" class="chosen-select" data-placeholder="Select Kab/Kota" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('KDPROP, KDDATI2, KDKEC, KDDESA')
                     ->from('tbl_bpjs')
                     ->where('bpjs_Id', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $KDPROP = $row->KDPROP;
            $KDDATI2 = $row->KDDATI2;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('tbl_dati2')
                     ->where('KDPROP', $KDPROP);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->KDDATI2 == $KDDATI2) {
                    $empty_select .= '<option value="'.$row->KDDATI2.'" selected="selected">'.$row->KDDATI2.' - '.$row->NMDATI2.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->KDDATI2.'">'.$row->KDDATI2.' - '.$row->NMDATI2.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } 

        elseif (isset($listingID) && $state == "add") {
            //GET THE STORED STATE ID
            $this->db->select('*')
                     ->from('tbl_bpjs')
                     ->where('No_KK', $listingID)
                     ->where('PISA', 1)
                     ->limit(0,1);

            $db = $this->db->get();
            $row = $db->row(0);
            $KDPROP = $row->KDPROP;
            $KDDATI2 = $row->KDDATI2;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('tbl_dati2')
                     ->where('KDPROP', $KDPROP);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->KDDATI2 == $KDDATI2) {
                    $empty_select .= '<option value="'.$row->KDDATI2.'" selected="selected">'.$row->KDDATI2.' - '.$row->NMDATI2.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->KDDATI2.'">'.$row->KDDATI2.' - '.$row->NMDATI2.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        }


        else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }

    public function empty_kec_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="KDKEC" class="chosen-select" data-placeholder="Select Kecamatan" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('KDPROP, KDDATI2, KDKEC, KDDESA')
                     ->from('tbl_bpjs')
                     ->where('bpjs_Id', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $KDDATI2 = $row->KDDATI2;
            $KDKEC = $row->KDKEC;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_kec')
                     ->where('KDDATI2', $KDDATI2);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->KDKEC == $KDKEC) {
                    $empty_select .= '<option value="'.$row->KDKEC.'" selected="selected">'.$row->KDKEC.' - '.$row->NMKEC.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->KDKEC.'">'.$row->KDKEC.' - '.$row->NMKEC.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } 

        elseif(isset($listingID) && $state == "add") {
            //GET THE STORED STATE ID
            $this->db->select('KDPROP, KDDATI2, KDKEC, KDDESA')
                     ->from('tbl_bpjs')
                     ->where('No_KK', $listingID)
                     ->where('PISA', 1)
                     ->limit(0,1);



            $db = $this->db->get();
            $row = $db->row(0);
            $KDDATI2 = $row->KDDATI2;
            $KDKEC = $row->KDKEC;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_kec')
                     ->where('KDDATI2', $KDDATI2);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->KDKEC == $KDKEC) {
                    $empty_select .= '<option value="'.$row->KDKEC.'" selected="selected">'.$row->KDKEC.' - '.$row->NMKEC.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->KDKEC.'">'.$row->KDKEC.' - '.$row->NMKEC.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        }

        else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }
     
    

    public function empty_desa_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="KDDESA" class="chosen-select" data-placeholder="Select Desa" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('KDPROP, KDDATI2, KDKEC, KDDESA')
                     ->from('tbl_bpjs')
                     ->where('bpjs_Id', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $KDDESA = $row->KDDESA;
            $KDKEC = $row->KDKEC;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_desa')
                     ->where('KDDESA', $KDDESA);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->KDDESA == $KDDESA) {
                    $empty_select .= '<option value="'.$row->KDDESA.'" selected="selected">'.$row->KDDESA.' - '.$row->NMDESA.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->KDDESA.'">'.$row->KDDESA.' - '.$row->NMDESA.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } 

        elseif(isset($listingID) && $state == "add") {
            //GET THE STORED STATE ID
            $this->db->select('KDPROP, KDDATI2, KDKEC, KDDESA')
                     ->from('tbl_bpjs')
                     ->where('No_KK', $listingID)
                     ->where('PISA', 1)
                     ->limit(0,1);


            $db = $this->db->get();
            $row = $db->row(0);
            $KDDESA = $row->KDDESA;
            $KDKEC = $row->KDKEC;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_desa')
                     ->where('KDDESA', $KDDESA);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->KDDESA == $KDDESA) {
                    $empty_select .= '<option value="'.$row->KDDESA.'" selected="selected">'.$row->KDDESA.' - '.$row->NMDESA.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->KDDESA.'">'.$row->KDDESA.' - '.$row->NMDESA.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        }

        else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }            
    





    //GET JSON OF STATES
    public function get_dati2()
    {
        $KDPROP = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_dati2')
                 ->where('KDPROP', $KDPROP);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->KDDATI2, "property" => $row->KDDATI2.' - '.$row->NMDATI2);
        endforeach;
        
        echo json_encode($array);
        exit;
    }
    
    //GET JSON OF CITIES
    public function get_kec()
    {
        $KDDATI2 = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_kec')
                 ->where('KDDATI2', $KDDATI2);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->KDKEC, "property" => $row->KDKEC.' - '.$row->NMKEC);
        endforeach;
        
        echo json_encode($array);
        exit;
    }

    //GET JSON OF CITIES
    public function get_desa()
    {
        $KDKEC = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_desa')
                 ->where('KDKEC', $KDKEC);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->KDDESA, "property" => $row->KDDESA.' - '.$row->NMDESA);
        endforeach;
        
        echo json_encode($array);
        exit;
    }




     // add hyperlink
    public function _callback_webpage_url($value, $row){        
    
        return "<a href='".site_url($this->cms_module_path().'/frmReview/index/'.$this->uri->segment(4).'/edit/'.$row->bpjs_Id)."'>$value</a>";
        
    }



    //CALLBACK FUNCTIONS Faskes
    public function empty_KDFaskes_KDDATI2_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="KDFaskes_KDDATI2" class="chosen-select" data-placeholder="Select Faskes Kab/Kota" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        //$no_kk = $this->uri->segment(4);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('KDFaskes_KDPROP, KDFaskes_KDDATI2, KDFaskes, KDFaskesGigi')
                     ->from('tbl_bpjs')
                     ->where('bpjs_Id', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $KDFaskes_KDPROP = $row->KDFaskes_KDPROP;
            $KDFaskes_KDDATI2 = $row->KDFaskes_KDDATI2;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('tbl_dati2')
                     ->where('KDPROP', $KDFaskes_KDPROP);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->KDDATI2 == $KDFaskes_KDDATI2) {
                    $empty_select .= '<option value="'.$row->KDDATI2.'" selected="selected">'.$row->KDDATI2.' - '.$row->NMDATI2.'</option>';

                } else {
                    $empty_select .= '<option value="'.$row->KDDATI2.'">'.$row->KDDATI2.' - '.$row->NMDATI2.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        }

        elseif(isset($listingID) && $state == "add") {
            //GET THE STORED STATE ID
            $this->db->select('KDFaskes_KDPROP, KDFaskes_KDDATI2, KDFaskes, KDFaskesGigi')
                     ->from('tbl_bpjs')
                     ->where('No_KK', $listingID)
                     ->where('PISA', 1)
                     ->limit(0,1);
                     
            $db = $this->db->get();
            $row = $db->row(0);
            $KDFaskes_KDPROP = $row->KDFaskes_KDPROP;
            $KDFaskes_KDDATI2 = $row->KDFaskes_KDDATI2;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('tbl_dati2')
                     ->where('KDPROP', $KDFaskes_KDPROP);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->KDDATI2 == $KDFaskes_KDDATI2) {
                    $empty_select .= '<option value="'.$row->KDDATI2.'" selected="selected">'.$row->KDDATI2.' - '.$row->NMDATI2.'</option>';

                } else {
                    $empty_select .= '<option value="'.$row->KDDATI2.'">'.$row->KDDATI2.' - '.$row->NMDATI2.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } 

       

        else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }

    public function empty_KDFaskes_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="KDFaskes"  class="chosen-select" data-placeholder="Select Faskes Tk.1" style="width: 700px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('KDFaskes_KDPROP, KDFaskes_KDDATI2, KDFaskes, KDFaskesGigi')
                     ->from('tbl_bpjs')
                     ->where('bpjs_Id', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $KDFaskes_KDDATI2 = $row->KDFaskes_KDDATI2;
            $KDFaskes = $row->KDFaskes;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_faskesumum')
                     ->where('KDDATI2', $KDFaskes_KDDATI2);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->KDFaskes == $KDFaskes) {
                    //$empty_select .= '<option value="'.$row->KDFaskes.'" selected="selected">'.$row->KDFaskes.' - '.$row->NMFaskes.'</option>';
                    $empty_select .= '<option value="'.$row->KDFaskes.'" selected="selected">'.$row->KDFaskes.' - '.$row->TipeFaskes.' '.$row->NMFaskes.' ( '.$row->AlamatFaskes.' )</option>';
                } else {
                    //$empty_select .= '<option value="'.$row->KDFaskes.'">'.$row->KDFaskes.' - '.$row->NMFaskes.'</option>';
                    $empty_select .= '<option value="'.$row->KDFaskes.'">'.$row->KDFaskes.' - '.$row->TipeFaskes.' '.$row->NMFaskes.' ( '.$row->AlamatFaskes.' )</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        } 

        elseif(isset($listingID) && $state == "add") {
            //GET THE STORED STATE ID
            $this->db->select('KDFaskes_KDPROP, KDFaskes_KDDATI2, KDFaskes, KDFaskesGigi')
                     ->from('tbl_bpjs')
                     ->where('No_KK', $listingID)
                     ->where('PISA', 1)
                     ->limit(0,1);


            $db = $this->db->get();
            $row = $db->row(0);
            $KDFaskes_KDDATI2 = $row->KDFaskes_KDDATI2;
            $KDFaskes = $row->KDFaskes;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_faskesumum')
                     ->where('KDDATI2', $KDFaskes_KDDATI2);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->KDFaskes == $KDFaskes) {
                    //$empty_select .= '<option value="'.$row->KDFaskes.'" selected="selected">'.$row->KDFaskes.' - '.$row->NMFaskes.'</option>';
                    $empty_select .= '<option value="'.$row->KDFaskes.'" selected="selected">'.$row->KDFaskes.' - '.$row->TipeFaskes.' '.$row->NMFaskes.' ( '.$row->AlamatFaskes.' )</option>';
                } else {
                    //$empty_select .= '<option value="'.$row->KDFaskes.'">'.$row->KDFaskes.' - '.$row->NMFaskes.'</option>';
                    $empty_select .= '<option value="'.$row->KDFaskes.'">'.$row->KDFaskes.' - '.$row->TipeFaskes.' '.$row->NMFaskes.' ( '.$row->AlamatFaskes.' )</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;
        }

        else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }


    public function empty_KDFaskesGigi_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="KDFaskesGigi" class="chosen-select" data-placeholder="Select Faskes Gigi" style="width: 700px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('KDFaskes_KDPROP, KDFaskes_KDDATI2, KDFaskes, KDFaskesGigi')
                     ->from('tbl_bpjs')
                     ->where('bpjs_Id', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
           
            $KDFaskes_KDDATI2 = $row->KDFaskes_KDDATI2;
            $KDFaskes = $row->KDFaskesGigi;
            //$KDFaskes = $row->KDFaskes;
          
            //GET THE CITIES PER STATE ID 

            $this->db->select('*')
                     ->from('tbl_faskesumum')
                     ->where('KDDATI2', $KDFaskes_KDDATI2);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            
            foreach($db->result() as $row):
                if($row->$KDFaskes == $KDFaskes) {
                    $empty_select .= '<option value="'.$row->KDFaskes.'" selected="selected">'.$row->KDFaskes.' - '.$row->TipeFaskes.' '.$row->NMFaskes.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->KDFaskes.'">'.$row->KDFaskes.' - '.$row->TipeFaskes.' '.$row->NMFaskes.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;

        } 

        elseif(isset($listingID) && $state == "add") {
            //GET THE STORED STATE ID
            $this->db->select('KDFaskes_KDPROP, KDFaskes_KDDATI2, KDFaskes, KDFaskesGigi')
                     ->from('tbl_bpjs')
                     ->where('No_KK', $listingID)
                     ->where('PISA', 1)
                     ->limit(0,1);

            $db = $this->db->get();
            $row = $db->row(0);
           
            $KDFaskes_KDDATI2 = $row->KDFaskes_KDDATI2;
            $KDFaskes = $row->KDFaskesGigi;
            //$KDFaskes = $row->KDFaskes;
          
            //GET THE CITIES PER STATE ID 

            $this->db->select('*')
                     ->from('tbl_faskesumum')
                     ->where('KDDATI2', $KDFaskes_KDDATI2);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            
            foreach($db->result() as $row):
                if($row->KDFaskes == $KDFaskes) {
                    $empty_select .= '<option value="'.$row->KDFaskes.'" selected="selected">'.$row->KDFaskes.' - '.$row->TipeFaskes.' '.$row->NMFaskes.' ( '.$row->AlamatFaskes.' )</option>';
                } else {
                    $empty_select .= '<option value="'.$row->KDFaskes.'">'.$row->KDFaskes.' - '.$row->TipeFaskes.' '.$row->NMFaskes.' ( '.$row->AlamatFaskes.' )</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;

        }

        else {
            //RETURN SELECTION COMBO
            return $empty_select.$empty_select_closed;  
        }
    }


    //GET JSON OF STATES
    public function get_KDFaskes_KDDATI2()
    {
        $KDPROP = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_dati2')
                 ->where('KDPROP', $KDPROP);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->KDDATI2, "property" => $row->KDDATI2.' - '.$row->NMDATI2);
        endforeach;
        
        echo json_encode($array);
        exit;
    }
    
    //GET JSON OF CITIES
    public function get_KDFaskes()
    {
        $KDDATI2 = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_faskesumum')
                 ->where('KDDATI2', $KDDATI2);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->KDFaskes, "property" => $row->KDFaskes.' - '.$row->TipeFaskes.' '.$row->NMFaskes.' ( '.$row->AlamatFaskes.' )');
        endforeach;
        
        echo json_encode($array);
        exit;
    }

    //GET JSON OF CITIES
    public function get_KDFaskesGigi()
    {
        $KDFaskes = $this->uri->segment(4);


        $this->db->select('*')
                     ->from('tbl_faskesumum')
                     ->where('KDFaskes', $KDFaskes);
            $db2 = $this->db->get();
            $row = $db2->row(0);
            $KDDATI2 = $row->KDDATI2;

        
        $this->db->select("*")
                 ->from('tbl_faskesumum')
                 ->where('KDDATI2', $KDDATI2);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->KDFaskes, "property" => $row->KDFaskes.' - '.$row->TipeFaskes.' '.$row->NMFaskes.' ( '.$row->AlamatFaskes.' )');
        endforeach;
        
        echo json_encode($array);
        exit;
    }





    public function _callback_column_NMFaskes($value, $row)
    {    

     $query2 = $this->db->query('SELECT * FROM tbl_bpjs LEFT JOIN
                      tbl_faskesumum ON tbl_bpjs.KDFaskes = tbl_faskesumum.KDFaskes 
                      WHERE bpjs_Id='.$row->bpjs_Id);     
     foreach ($query2->result() as $rown){
           return $rown->TipeFaskes.' '.$rown->NMFaskes;       
     }      

        
    }


    public function _callback_column_NMFaskesGigi($value, $row)
    {    

     $query2 = $this->db->query('SELECT * FROM tbl_bpjs LEFT JOIN
                      tbl_faskesumum ON tbl_bpjs.KDFaskesGigi = tbl_faskesumum.KDFaskes 
                      WHERE bpjs_Id='.$row->bpjs_Id);   
                        
     foreach ($query2->result() as $rown){
            return $rown->TipeFaskes.' '.$rown->NMFaskes;       
     }      

        
    }


    public function _callback_column_NMKEC($value, $row)
    {    

     $query2 = $this->db->query('SELECT * FROM tbl_bpjs LEFT JOIN
                      tbl_kec ON tbl_bpjs.KDKEC = tbl_kec.KDKEC 
                      WHERE bpjs_Id='.$row->bpjs_Id);     
     foreach ($query2->result() as $rown){        
           // $Processor = 'Processor '.$rown->cProcessorName;
            return $rown->NMKEC;       
     }      

        
    }


    public function _callback_column_NMDESA($value, $row)
    {    

     $query2 = $this->db->query('SELECT * FROM tbl_bpjs LEFT JOIN
                      tbl_desa ON tbl_bpjs.KDDESA = tbl_desa.KDDESA 
                      WHERE bpjs_Id='.$row->bpjs_Id);     
     foreach ($query2->result() as $rown){        
          
            return $rown->NMDESA;       
     }      

        
    }


    public function _callback_column_No_KTP($value, $row)
    {    

     $query2 = $this->db->query('SELECT * FROM tbl_bpjs WHERE bpjs_Id='.$row->bpjs_Id);     
     foreach ($query2->result() as $rown){        
          
            return "'".$rown->No_KTP;       
     }      

        
    }


    public function _callback_column_No_KK($value, $row)
    {    

     $query2 = $this->db->query('SELECT * FROM tbl_bpjs WHERE bpjs_Id='.$row->bpjs_Id);     
     foreach ($query2->result() as $rown){        
          
            return "'".$rown->No_KK;       
     }      

        
    }


    public function _callback_column_Nomor_Telp($value, $row)
    {    

     $query2 = $this->db->query('SELECT * FROM tbl_bpjs WHERE bpjs_Id='.$row->bpjs_Id);     
     foreach ($query2->result() as $rown){        
          
            return "'".$rown->Nomor_Telp;       
     }      

        
    }


    public function _callback_column_No_NPWP($value, $row)
    {    

     $query2 = $this->db->query('SELECT * FROM tbl_bpjs WHERE bpjs_Id='.$row->bpjs_Id);     
     foreach ($query2->result() as $rown){        
          
            return "'".$rown->No_NPWP;       
     }      

        
    }



    // Add Default Tagging Asset
    public function _callback_add_field_No_KK()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))     
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return $rown->No_KK."<input type='hidden' maxlength='50' value='".$rown->No_KK."' name='No_KK'>";
        }   
        
    }


    // Add Default Tagging Asset
    public function _callback_add_field_NIK()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))     
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return $rown->NIK."<input type='hidden' maxlength='50' value='".$rown->NIK."' name='NIK'>";
        }   
        
    }


    // Add Default Tagging Asset
    public function _callback_add_field_Jabatan()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))
            ->join('tbl_jabatan', 'tbl_bpjs.Jabatan = tbl_jabatan.JabatanId')          
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return $rown->NamaJabatan."<input type='hidden' maxlength='50' value='".$rown->Jabatan."' name='Jabatan'>";
        }   
        
    }



    // Add Default Tagging Asset
    public function _callback_add_field_email()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))     
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return $rown->email."<input type='hidden' maxlength='50' value='".$rown->email."' name='email'>";
        }   
        
    }


    // Add Default Tagging Asset
    public function _callback_add_field_TMT()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))     
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return $rown->TMT." ( yyyy/mm/dd) <input type='hidden' maxlength='50' value='".$rown->TMT."' name='TMT'>";
        }   
        
    }


    // Add Default Tagging Asset
    public function _callback_add_field_companyID()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))
            ->join('tbl_company', 'tbl_bpjs.companyID = tbl_company.iCompanyId')          
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return $rown->cCompanyName."<input type='hidden' maxlength='50' value='".$rown->companyID."' name='companyID'>";
        }   
        
    }


    // Add Default Tagging Asset
    public function _callback_add_field_divisionID()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))
            ->join('tbl_div', 'tbl_bpjs.divisionID = tbl_div.iDivId')          
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return $rown->cDivName."<input type='hidden' maxlength='50' value='".$rown->iDivId."' name='divisionID'>";
        }   
        
    }


    // Add Default Tagging Asset
    public function _callback_add_field_deptID()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))
            ->join('tbl_dept', 'tbl_bpjs.deptID = tbl_dept.iDeptID')          
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return $rown->cDeptName."<input type='hidden' maxlength='50' value='".$rown->iDeptID."' name='deptID'>";
        }   
        
    }



    // Add Default Tagging Asset
    public function _callback_add_field_Status_Karyawan()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))
            ->join('tbl_bpjs_status', 'tbl_bpjs.Status_Karyawan = tbl_bpjs_status.StatusId')          
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return $rown->StatusName."<input type='hidden' maxlength='50' value='".$rown->StatusId."' name='Status_Karyawan'>";
        }   
        
    }


    // Add Default Tagging Asset
    public function _callback_add_field_Alamat_Tinggal()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))     
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return "<textarea style='width: 480px; height: 100px;' name='Alamat_Tinggal'>".$rown->Alamat_Tinggal."</textarea>";
        }   
        
    }

   

   // Add Default Tagging Asset
    public function _callback_add_field_Nomor_Telp()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))     
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return "<input type='text' value='".$rown->Nomor_Telp."' name='Nomor_Telp'>";
        }   
        
    }


    // Add Default Tagging Asset
    public function _callback_add_field_No_RT()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))     
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return "<input type='text' value='".$rown->No_RT."' name='No_RT'>";
        }   
        
    }


    // Add Default Tagging Asset
    public function _callback_add_field_No_RW()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))     
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return "<input type='text' value='".$rown->No_RW."' name='No_RW'>";
        }   
        
    }


    // Add Default Tagging Asset
    public function _callback_add_field_Kode_Pos()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))     
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return "<input type='text' value='".$rown->Kode_Pos."' name='Kode_Pos'>";
        }   
        
    }



    // Add Default Tagging Asset
    public function _callback_add_field_Kelas_Rawat()
    {
      
        $stateID = $this->uri->segment(5);
        $query = $this->db->select('*')
            ->from($this->cms_complete_table_name('bpjs'))
            ->join('tbl_bpjs_kelas', 'tbl_bpjs.Kelas_Rawat = tbl_bpjs_kelas.kelas_id')          
            ->where('No_KK', $stateID)
            ->where('PISA', 1)
            ->get();        

        foreach ($query->result() as $rown){
            return $rown->kelas_name."<input type='hidden' maxlength='50' value='".$rown->kelas_id."' name='Kelas_Rawat'>";
        }   
        
    }


    public function _callback_add_field_Kewarganegaraan()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="Kewarganegaraan" class="chosen-select" data-placeholder="Select Kewarganegaraan" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        
            //GET THE STORED STATE ID
            $this->db->select('*')
                     ->from('tbl_bpjs')
                     ->where('No_KK', $listingID)
                     ->where('PISA', 1)
                     ->limit(0,1);

            $db = $this->db->get();
            $row = $db->row(0);
           
            $Nation = $row->Kewarganegaraan;
            //$KDFaskes = $row->KDFaskesGigi;
            //$KDFaskes = $row->KDFaskes;
          
            //GET THE CITIES PER STATE ID 

            $this->db->select('*')
                     ->from('tbl_bpjs_nation');
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            
            foreach($db->result() as $row):
                if($row->nation_id == $Nation) {
                    $empty_select .= '<option value="'.$row->nation_id.'" selected="selected">'.$row->nation_name.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->nation_id.'">'.$row->nation_name.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;

        
    }


    public function _callback_add_field_KDPROP()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="KDPROP" class="chosen-select" data-placeholder="Select Propinsi" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        
            //GET THE STORED STATE ID
            $this->db->select('*')
                     ->from('tbl_bpjs')
                     ->where('No_KK', $listingID)
                     ->where('PISA', 1)
                     ->limit(0,1);

            $db = $this->db->get();
            $row = $db->row(0);
           
            $KDPROP = $row->KDPROP;
            //$KDFaskes = $row->KDFaskesGigi;
            //$KDFaskes = $row->KDFaskes;
          
            //GET THE CITIES PER STATE ID 

            $this->db->select('*')
                     ->from('tbl_propinsi');
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            
            foreach($db->result() as $row):
                if($row->KDPROP == $KDPROP) {
                    $empty_select .= '<option value="'.$row->KDPROP.'" selected="selected">'.$row->NMPROP.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->KDPROP.'">'.$row->NMPROP.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;

        
    }


    

    public function _callback_add_field_KDFaskes_KDPROP()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="KDFaskes_KDPROP" class="chosen-select" data-placeholder="Select Faskes Propinsi" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        
            //GET THE STORED STATE ID
            $this->db->select('*')
                     ->from('tbl_bpjs')
                     ->where('No_KK', $listingID)
                     ->where('PISA', 1)
                     ->limit(0,1);

            $db = $this->db->get();
            $row = $db->row(0);
           
            $KDPROP = $row->KDPROP;
            //$KDFaskes = $row->KDFaskesGigi;
            //$KDFaskes = $row->KDFaskes;
          
            //GET THE CITIES PER STATE ID 

            $this->db->select('*')
                     ->from('tbl_propinsi');
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            
            foreach($db->result() as $row):
                if($row->KDPROP == $KDPROP) {
                    $empty_select .= '<option value="'.$row->KDPROP.'" selected="selected">'.$row->NMPROP.'</option>';
                } else {
                    $empty_select .= '<option value="'.$row->KDPROP.'">'.$row->NMPROP.'</option>';
                }
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;

        
    }


    public function _callback_add_field_PISA()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="PISA" class="chosen-select" data-placeholder="Select PISA" style="width: 300px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
          
            //GET THE CITIES PER STATE ID 

            $this->db->select('*')
                     ->from('tbl_bpjs_pisa')
                     ->where('pisa_id !=',1);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
             $empty_select .= '<option value="" disabled selected>Select 5.PISA</option>';

            foreach($db->result() as $row):               
                    $empty_select .= '<option value="'.$row->pisa_id.'">'.$row->Pisa_name.'</option>';
                
            endforeach;
            
            //RETURN SELECTION COMBO
            //echo $KDFaskes;
            return $empty_select.$empty_select_closed;

        
    }


 


   


   







}

