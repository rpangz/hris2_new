<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Master_Company
 *
 * @author No-CMS Module Generator
 */
class frmProfile extends CMS_Priv_Strict_Controller {

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
       // $crud->set_theme('flexigrid');
        $session_nik = $this->cms_user_id();
        // this is just for code completion
        if (FALSE) $crud = new Extended_Grocery_CRUD();

        //$config['grocery_crud_file_upload_allow_file_types'] = 'gif|jpeg|jpg|png|tiff';
        //$crud->config->set_item('grocery_crud_file_upload_allow_file_types','gif|jpeg|jpg|png');
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
        //$crud->unset_read();
		$crud->unset_texteditor('AlamatDomisili');
        $crud->unset_texteditor('AlamatKTP');
		
        $crud->unset_add();
        // $crud->unset_edit();
        $crud->unset_delete();
        // $crud->unset_list();
        // $crud->unset_back_to_list();
        $crud->unset_print();
        $crud->unset_export();

        // set custom grocery crud model, uncomment to use.
        /*
        $this->load->model('grocery_crud_model');
        $this->load->model('grocery_crud_generic_model');
        $this->load->model('grocery_crud_automatic_model');
        $crud->set_model($this->cms_module_path().'/grocerycrud_country_model');
        */

        if ($state !='edit' AND $state != 'add' AND $state !='read'){
            $crud->set_theme('flexigrid');
            //$crud->unset_edit();
        }else{
            $crud->set_theme('no-flexigrid_1');
        }


        if ($this->uri->segment(5) != $session_nik){
            //$crud->set_theme('flexigrid');
            $crud->unset_edit();
            //$crud->unset_read();
        }

        // adjust groceryCRUD's language to No-CMS's language
        $crud->set_language($this->cms_language());

        // table name
        $crud->set_table($this->cms_complete_table_name('profile'));
        $crud->where('NIK', $session_nik);

        // primary key
        $crud->set_primary_key('NIK');

        // set subject
        $crud->set_subject('Karyawan');

        // displayed columns on list
		$crud->columns('Photos','NIK','Nama','Sex','BandSkrg','TglMasuk','Status','StatusDiri','CompanyId','DivisiID','DeptID','UnitID','JabatanID');
		

		
        // displayed columns on edit operation
        if ($state =='read'){
		$crud->edit_fields('Photos','NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','AlamatKTP','AlamatDomisili','Kodepos','Telp',
                            'Hp','Email','StatusDiri','TglMenikah','TglMasuk','TglKeluar','CompanyId','DivisiID','DeptID','UnitID','JabatanID','JmlAnak','Status','NoNPWP','NoKPJ','NamaIbuKandung');
        }
        else{
        $crud->edit_fields('Photos','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','AlamatKTP','AlamatDomisili','Kodepos','Telp','Hp','BloodType','StatusDiri','NamaIbuKandung','NoNPWP','NoKPJ','EmailPribadi','CompanyId','DivisiID','DeptID','UnitID','SeksiID','Email');

        }
		
       
        $data = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK = ".$session_nik));
        $_SESSION['NoKTP2']         = $data['NoKTP'];
        $_SESSION['TglKTP2']        = $data['TglKTP'];
        $_SESSION['Nama2']          = $data['Nama'];
        $_SESSION['Sex2']           = $data['Sex'];
        $_SESSION['Agama2']         = $data['Agama'];
        $_SESSION['TglLahir2']      = $data['TglLahir'];
        $_SESSION['TptLahir2']      = $data['TptLahir'];
        $_SESSION['Alamat2']        = $data['AlamatDomisili'];
        $_SESSION['Hp2']            = $data['Hp'];

        $alamatnya = str_ireplace("\\r\\n", "\r\n", $data['AlamatDomisili']);

        $_SESSION['alamatnya']            = $alamatnya;


        $Kodepos2       = $data['Kodepos'];
        $Telp2          = $data['Telp'];
        $Hp2            = $data['Hp'];
        $Email2         = $data['Email'];
        $AlamatKTP2     = $data['AlamatDomisili'];
        $StatusDiri2    = $data['StatusDiri'];
        $Alamat2        = $_SESSION['Alamat2'];



/*
        $crud->unset_add_fields('NoKTP2','TglKTP2','Nama2','Sex2','Agama2','TglLahir2','TptLahir2','Alamat2','Kodepos2','Telp2',
                            'Hp2','Email2','AlamatKTP2','StatusDiri2');
*/

        $crud->unset_add_fields('Alamat2');
/*
        $crud->field_type('NoKTP2', 'hidden', $NoKTP2);
        $crud->field_type('TglKTP2', 'hidden', $TglKTP2);
        $crud->field_type('Nama2', 'hidden', $Nama2);
        $crud->field_type('Sex2', 'hidden', $Sex2);
        $crud->field_type('Agama2', 'hidden', $Agama2);
        $crud->field_type('TglLahir2', 'hidden', $TglLahir2);
        $crud->field_type('TptLahir2', 'hidden', $TptLahir2);
        $crud->field_type('Alamat2', 'hidden', $Alamat2);
        $crud->field_type('Kodepos2', 'hidden', $Kodepos2);
        $crud->field_type('Telp2', 'hidden', $Telp2);
        $crud->field_type('Hp2', 'hidden', $Hp2);
        $crud->field_type('Email2', 'hidden', $Email2);
        $crud->field_type('AlamatKTP2', 'hidden', $AlamatKTP2);
        $crud->field_type('StatusDiri2', 'hidden', $StatusDiri2);
*/
        $crud->field_type('Alamat2', 'hidden', $Alamat2);
        // displayed columns on add operation
		
		$crud->add_fields('Photos','NIK','NoKTP','TglKTP','Nama','Sex','Agama','TglLahir','TptLahir','AlamatDomisili','Kodepos','Telp',
                            'Hp','Email','AlamatKTP','StatusDiri','TglMenikah','TglMasuk','TglKeluar','BandSkrg','Status',
                            'CompanyId','DivisiID','DeptID','UnitID','JabatanID','JmlAnak');
		


        $crud->set_field_upload('Photos','assets/uploads/files');
        // caption of each columns		
				
        $crud->display_as('NIK','NIK');
        $crud->display_as('Nama','Nama');
        $crud->display_as('NoKTP','No KTP/ e-KTP');
        $crud->display_as('TglKTP','Tgl KTP');
        $crud->display_as('Sex','Sex');
        $crud->display_as('BandSkrg','Band');
        $crud->display_as('TglMasuk','Tgl Masuk');
        $crud->display_as('Status','Status');
        $crud->display_as('StatusDiri','Status Diri');
        $crud->display_as('CompanyId','Company');
        $crud->display_as('DivisiID','Division');
        $crud->display_as('DeptID','Departemen');
        $crud->display_as('UnitID','Unit');
        $crud->display_as('JabatanID','Jabatan');
        $crud->display_as('JmlAnak','Jumlah Anak');
        $crud->display_as('TptLahir','Tempat Lahir');
        $crud->display_as('TglLahir','Tgl Lahir');
        $crud->display_as('TglMenikah','Tgl Menikah');
        $crud->display_as('TglKeluar','Tgl Keluar');
        $crud->display_as('AlamatKTP','Alamat KTP/ e-KTP');
        $crud->display_as('member','Anggota Keluarga');
        $crud->display_as('AlamatDomisili','Alamat Domisili/ Tinggal');
        $crud->display_as('NamaIbuKandung','Nama Ibu Kandung');
        $crud->display_as('NoNPWP','Nomor NPWP');
        $crud->display_as('NamaIbuKandung','Nama Ibu Kandung');
        $crud->display_as('NoKPJ','Nomor Kartu Penjamin Kesehatan');
        $crud->display_as('BloodType','Golongan Darah');
        $crud->display_as('Telp','Telepon Rumah');
        $crud->display_as('Hp','Nomor Handphone');
        $crud->display_as('EmailPribadi','Email Pribadi');
        $crud->display_as('Email','Email Perusahaan');




        
				
		
		// $crud->required_fields( $field1, $field2, $field3, ... );
		
        $crud->required_fields('NIK','Nama','Sex','TglLahir','TptLahir','Agama','Status','AlamatKTP','AlamatDomisili','Hp','BloodType','NamaIbuKandung','NoNPWP','NoKPJ');
       
		
		//$crud->unique_fields( $field1, $field2, $field3, ... );
		$crud->unique_fields('NIK');
       		

		$crud->set_relation('Status', $this->cms_complete_table_name('status'), 'StatusName');
        $crud->set_relation('Sex', $this->cms_complete_table_name('sex'), 'SexName');
        $crud->set_relation('CompanyId', $this->cms_complete_table_name('company'), 'cCompanyCode');
        $crud->set_relation('DivisiID', $this->cms_complete_table_name('div'), 'cDivName');
        $crud->set_relation('DeptID', $this->cms_complete_table_name('dept'), 'cDeptName');
        $crud->set_relation('UnitID', $this->cms_complete_table_name('unit'), 'NamaUnit');
        $crud->set_relation('JabatanID', $this->cms_complete_table_name('jabatan'), 'NamaJabatan');

        $crud->set_relation('StatusDiri', $this->cms_complete_table_name('StatusDiri'), 'StatusDiriName');
        $crud->set_relation('Agama', $this->cms_complete_table_name('Agama'), 'agama_name');

      	
			
		$crud->callback_before_insert(array($this,'_before_insert'));
        $crud->callback_before_update(array($this,'_before_update'));
        $crud->callback_before_delete(array($this,'_before_delete'));
        $crud->callback_after_insert(array($this,'_after_insert'));
        $crud->callback_after_update(array($this,'_after_update'));
        $crud->callback_after_delete(array($this,'_after_delete'));
        $crud->callback_column('Nama',array($this,'_callback_edit_url'));
        $crud->callback_column('TglMasuk',array($this,'_Date1_call'));

        $crud->callback_before_upload(array($this, '_valid_images'));

        $crud->callback_add_field('DivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_edit_field('DivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_add_field('DeptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_edit_field('DeptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_add_field('UnitID', array($this, 'empty_units_dropdown_select'));
        $crud->callback_edit_field('UnitID', array($this, 'empty_units_dropdown_select'));
        $crud->callback_add_field('SeksiID', array($this, 'empty_seksi_dropdown_select'));
        $crud->callback_edit_field('SeksiID', array($this, 'empty_seksi_dropdown_select'));

        /*
        $crud->callback_add_field('DivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_edit_field('DivisiID', array($this, 'empty_state_dropdown_select'));
        $crud->callback_add_field('DeptID', array($this, 'empty_city_dropdown_select'));
        $crud->callback_edit_field('DeptID', array($this, 'empty_city_dropdown_select'));
        */

        $crud->callback_column('Photos',array($this,'_callback_column_Photos'));

        $crud->callback_column('member',array($this, '_callback_column_member'));
        $crud->callback_field('member',array($this, '_callback_field_member'));


        $this->crud = $crud;
        return $crud;
    }


    public function _example_output($output = null){
        
        //echo "<script language='javascript'>window.location ='http://astapp02/hris2/bpjs/frmRegistration/index/add';</script>";
        //$this->view($this->cms_module_path().'modules/customers', $output);
        $this->view($this->cms_module_path().'/frmProfile_view', $output,
        $this->cms_complete_navigation_name('frmProfile'));    
    }


    public function index(){
         //echo"<script>window.open('http://astapp02/hris2/bpjs/frmRegistration/index/add');</script>";
         
        $crud = $this->make_crud();

        $dd_data = array(
                //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
                'dd_state' =>  $crud->getState(),
                //SETUP YOUR DROPDOWNS
                //Parent field item always listed first in array, in this case countryID
                //Child field items need to follow in order, e.g stateID then cityID
                
                'dd_dropdowns' => array('CompanyId','DivisiID','DeptID','UnitID','SeksiID'),
                //SETUP URL POST FOR EACH CHILD
                //List in order as per above
                //'dd_url' => array('', site_url().'/karyawan/frmProfile/get_states/', site_url().'/karyawan/frmProfile/get_cities/'),
                'dd_url' => array('', site_url().'/karyawan/frmProfile/get_states/', site_url().'/karyawan/frmProfile/get_cities/', site_url().'/karyawan/frmProfile/get_units/',site_url().'/karyawan/frmProfile/get_seksi/'),
                //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
                'dd_ajax_loader' => base_url().'ajax-loader.gif'
            );

        
        

        


      $output = $crud->render();
            $output->dropdown_setup = $dd_data;            
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
                    $this->db->delete($this->cms_complete_table_name('profile'),array('NIK'=>$id));
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
        // HINT : Put your code here

        //$alamatku = $_SESSION['Alamat2'];

    $data   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$primary_key));
    $NIK    = $data['NIK'];
    $Nama   = $data['Nama'];
    $CompanyId = $data['CompanyId'];
    
    if ($CompanyId ==2){
        $hrd_company = 2;
    }
    else {
        $hrd_company = 1;
    }

    //condition for red color

        if ($_SESSION['NoKTP2'] == $data['NoKTP']){
            $bg1 = '';
        }else{
            $bg1 = '#FFFF99';
        }

        if ($_SESSION['TglKTP2'] == $data['TglKTP']){
            $bg2 = '';
        }else{
            $bg2 = '#FFFF99';
        }

        if ($_SESSION['alamatnya'] == $data['Alamat']){
            $bg3 = '';
        }else{
            $bg3 = '#FFFF99';
        }

        if ($_SESSION['Hp2'] == $data['Hp']){
            $bg4 = '';
        }else{
            $bg4 = '#FFFF99';
        }

        if ($_SESSION['Agama2'] == $data['Agama']){
            $bg5 = '';
        }else{
            $bg5 = '#FFFF99';
        }

    $region_new   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_agama WHERE agama_id=".$post_array['Agama']));
    $n_region_new = $region_new['agama_name'];

    $region_old   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_agama WHERE agama_id=".$_SESSION['Agama2']));
    $n_region_old = $region_old['agama_name'];


    
$ss = mysql_query("SELECT * FROM tbl_apv_hrd WHERE hrd_status=1 AND hrd_company='$hrd_company' ORDER BY hrd_nik ASC");

while ($rom = mysql_fetch_array($ss)){
    

    require_once 'class.phpmailer.php'; 

    try {

    $mail = new PHPMailer(true);

    $body =
    '<html>
    <head>
    <style type=text/css>
    .style1 {font-size: 13px}
    .style4 {font-size: 13px; font-style: normal; }

    .bigcell {
    position: relative;
    width: 100px;
    height: 50px;
    border: thin dotted gray;
    }

    .strikeout {
    position: absolute;
    height: 0px;
    width: 179px;
    background-color: black;
    top: 146px;
    visibility: inherit;
    }
    .style7 {font-size: 13px; font-weight: bold; }
    table { border: thin black solid; } /* or other border styles */
    </style>
    
    
<title>Detail Perubahan Data Profile Karyawan</title>
    </head>
<body>
    <p>Kepada YTH: '.$rom['hrd_name'].'</p>
    <p><strong>Detail Perubahan Data Profile Karyawan</strong></p>
    NIK &nbsp; : '.$data['NIK'].'</br>
    Nama : '.$data['Nama'].'</br></br>

    <table width="800" border="1" cellspacing="1" cellpadding="1" frame="border" rules="rows">
  <tr>
    <th bgcolor="#CCCCCC" width="200" scope="col">Data Profil</th>
    <th bgcolor="#CCCCCC" width="300" scope="col">Before</th>
    <th bgcolor="#CCCCCC" width="300" scope="col">After</th>
  </tr>
  
  <tr>
    <th width="200" scope="row"><div align="right">No KTP :</div></th>
    <td width="300">'.$_SESSION['NoKTP2'].'</td>
    <td width="300" bgcolor="'.$bg1.'">'.$data['NoKTP'].'</td>
  </tr>
  <tr>
    <th scope="row"><div align="right">Tgl KTP :</div></th>
    <td>'.$_SESSION['TglKTP2'].'</td>
    <td bgcolor="'.$bg2.'">'.$data['TglKTP'].'</td>
  </tr>
  <tr>
    <th scope="row"><div align="right">Alamat :</div></th>
    <td>'.$_SESSION['alamatnya'].'</td>
    <td bgcolor="'.$bg3.'">'.$data['Alamat'].'</td>
  </tr>
  <tr>
    <th scope="row"><div align="right">No Telpon :</div></th>
    <td>'.$_SESSION['Hp2'].'</td>
    <td bgcolor="'.$bg4.'">'.$data['Hp'].'</td>
  </tr>
  <tr>
    <th scope="row"><div align="right">Agama :</div></th>
    <td>'.$n_region_old.'</td>
    <td bgcolor="'.$bg5.'">'.$n_region_new.'</td>
  </tr>
</table>
    <p><font size=-1>*) Data yang berubah berwarna Kuning</font></p>
    </br>
    </br>
    <p><font color=#FF0000 size=-1>Perhatian email ini dikirim secara otomatis dari HRIS. Jangan membalas ke alamat ini</font></p>
    </body>
    </html>';
    
    $mail->Body         = $body;    
    $mail->IsSMTP();
    $mail->Mailer       = "smtp";
    $mail->Host         = "Exc2013-DAG";
    $mail->Port         = 25;
    $mail->SMTPKeepAlive= true;
    $mail->SMTPAuth     = true;
    $mail->From         = "system.noreply@unias.com";
    $mail->FromName     = "Human Resource Information System";
    $mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');
    $to = "$rom[hrd_email]";
    $mail->AddAddress($to);
    $mail->Subject       = "Perubahan Data Profile $data[Nama]";
    $mail->AltBody       = "To view the message, please use an HTML compatible email viewer!";  
    $mail->WordWrap      = 80;  
    $mail->IsHTML(true);    
    $mail->Send();  
    
        }
        catch (phpmailerException $e)
        {
        echo $e->errorMessage();
        }   

}


        //include "http://$_SERVER[SERVER_NAME]/hris2/includes/mailer/frmProfile/SendMail.php?id=".$primary_key;
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
        $real_column_names = array('MemberId', 'MemberName', 'MemberLahir', 'MemberStatus', 'MemberSex');
        $set_column_names = array();

        
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
            $this->db->delete($this->cms_complete_table_name('profile_member'),
                 array('MemberId'=>$detail_primary_key));
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
            $data['NIK'] = $primary_key;
            $this->db->update($this->cms_complete_table_name('profile_member'),
                 $data, array('MemberId'=>$detail_primary_key));
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
            //$this->form_validation->set_rules( 'birthdate', 'birthdate', 'required' );
            //$this->crud->set_rules("name","name","required");
            $data = array();
            foreach($insert_record['data'] as $key=>$value){

               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['NIK'] = $primary_key;
            $this->db->insert($this->cms_complete_table_name('profile_member'), $data);
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

    public function _before_insert_or_update($post_array, $primary_key=NULL){
        return $post_array;
    }

    // add hyperlink
    public function _callback_edit_url($value, $row){    
        return "<a href='".site_url($this->cms_module_path().'/'.$this->uri->segment('2').'/index/edit/'.$row->NIK)."'>$value</a>";
        
    }

    // change dPeriodEndDate format to d-M-Y
    public function _Date1_call($value, $row){
        //return $value." - scale: <b>".$row->date."</b>";
        $Date1 = date('d-M-Y', strtotime($row->TglMasuk));
        return $Date1;
        
    }


    //CALLBACK FUNCTIONS
    public function empty_state_dropdown_select()
    {
        //CREATE THE EMPTY SELECT STRING
        $empty_select = '<select name="DivisiID" class="chosen-select" data-placeholder="Select Division" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('CompanyId, DivisiID, DeptID')
                     ->from('tbl_profile')
                     ->where('NIK', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $CompanyId = $row->CompanyId;
            $DivisiID = $row->DivisiID;
            
            //GET THE STATES PER COUNTRY ID
            $this->db->select('*')
                     ->from('tbl_div')
                     ->where('iDivCompany', $CompanyId);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iDivId == $DivisiID) {
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
        $empty_select = '<select name="DeptID" class="chosen-select" data-placeholder="Select Departement" style="width: 500px; display: none;">';
        $empty_select_closed = '</select>';
        //GET THE ID OF THE LISTING USING URI
        $listingID = $this->uri->segment(5);
        
        //LOAD GCRUD AND GET THE STATE
        $crud = new grocery_CRUD();
        $state = $crud->getState();
        
        //CHECK FOR A URI VALUE AND MAKE SURE ITS ON THE EDIT STATE
        if(isset($listingID) && $state == "edit") {
            //GET THE STORED STATE ID
            $this->db->select('CompanyId, DivisiID, DeptID, unitID')
                     ->from('tbl_profile')
                     ->where('NIK', $listingID);
            $db = $this->db->get();
            $row = $db->row(0);
            $DivisiID = $row->DivisiID;
            $DeptID = $row->DeptID;
            
            //GET THE CITIES PER STATE ID
            $this->db->select('*')
                     ->from('tbl_dept')
                     ->where('iDeptDivID', $DivisiID);
            $db = $this->db->get();
            
            //APPEND THE OPTION FIELDS WITH VALUES FROM THE STATES PER THE COUNTRY ID
            foreach($db->result() as $row):
                if($row->iDeptID == $DeptID) {
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
        $CompanyId = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_div')
                 ->where('iDivCompany', $CompanyId);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iDivId, "property" => $row->cDivName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }
    
    //GET JSON OF CITIES
    public function get_cities(){
        $DivisiID = $this->uri->segment(4);
        
        $this->db->select("*")
                 ->from('tbl_dept')
                 ->where('iDeptDivID', $DivisiID);
        $db = $this->db->get();
        
        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->iDeptID, "property" => $row->cDeptName);
        endforeach;
        
        echo json_encode($array);
        exit;
    }


    public function _callback_column_Photos($value, $row){
        $this->db->select('*')
                     ->from('tbl_profile')
                     ->where('NIK', $row->NIK);
            $db = $this->db->get();
            $row = $db->row(0);
            $Sex = $row->Sex;            


        if (isset($value) || !is_null($value)){
            $image = $value;  
            return "<img src='http://".$_SERVER['SERVER_NAME']."/hris2/assets/uploads/files/" . $image . "' width=40>";
        }
        else {
            if ($Sex =='L'){
            $image = 'Male.png';
            }else {
            $image = 'Female.png';
            } 
           return "<img src='http://".$_SERVER['SERVER_NAME']."/hris2/assets/uploads/files/" . $image . "' width=40>";

        }
    }


    public function _valid_images($files_to_upload, $field_info){
        if ($files_to_upload[$field_info->encrypted_field_name]['type'] != 'image/png' && $files_to_upload[$field_info->encrypted_field_name]['type'] != 'image/jpg' && 
            $files_to_upload[$field_info->encrypted_field_name]['type'] != 'image/jpeg')
        {
            return 'Sorry, we can upload only images here.';
        }
        return true;
    }


    // returned on insert and edit
    public function _callback_field_member($value, $primary_key){
        $module_path = $this->cms_module_path();
        $this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('MemberId, NIK, MemberName, MemberLahir, MemberStatus, MemberSex')
            ->from($this->cms_complete_table_name('profile_member'))
            ->where('NIK', $primary_key)
            ->get();
        $result = $query->result_array();

        // get options
        $options = array();
        $options['MemberStatus'] = array();
        $query = $this->db->select('MemberStatusId,MemberStatusName')
           ->from($this->cms_complete_table_name('member_status'))
           ->get();
        foreach($query->result() as $row){
            $options['MemberStatus'][] = array('value' => $row->MemberStatusId, 'caption' => $row->MemberStatusName);
        }


        // get options
        //$options = array();
        $options['MemberSex'] = array();
        $query = $this->db->select('SexId,SexCode,SexName')
           ->from($this->cms_complete_table_name('sex'))
           ->get();
        foreach($query->result() as $row){
            $options['MemberSex'][] = array('value' => $row->SexCode, 'caption' => $row->SexName);
        }
      
        $data = array(
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
        );
        return $this->load->view($this->cms_module_path().'/field_profile_member',$data, TRUE);
    }

    // returned on view
    public function _callback_column_member($value, $row){
        $module_path = $this->cms_module_path();
        $query = $this->db->select('MemberId, NIK, MemberName, MemberLahir, MemberStatus, MemberSex')
            ->from($this->cms_complete_table_name('profile_member'))
            ->where('NIK', $row->NIK)
            ->get();
        $num_row = $query->num_rows();
        // show how many records
        if($num_row>1){
            return $num_row .' Member';
        }else if($num_row>0){
            return $num_row .' Member';
        }else{
            return 'No Member';
        }
    }



}