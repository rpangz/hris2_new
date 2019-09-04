<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kehadiran_Model extends CMS_Model{

    protected $php_date_format;

    public function __construct(){
        parent::__construct();       

        $this->table_header = cms_module_config($this->cms_module_path(), 'table_header');
        $this->table_detail = cms_module_config($this->cms_module_path(), 'table_detail');
    }

    public function get_data_row($table_name, $where_column, $result_column, $primary_key){

        $query = $this->db->select($result_column)->from($table_name)->where($where_column, $primary_key)->get();
        $row   = $query->row();

        if($query->num_rows()>0){            
            return $row->$result_column;            
        }else{
            return '';
        }            
    }


    public function get_all_user(){

        $this->db->select('NIK,Nama,Email')
                 ->from('tbl_profile')
                 ->where('bStatus',1)
                 ->where('NIK >',1000)
                 ->order_by('Nama', 'ASC');
        $db = $this->db->get();

        return $db->result();
    }

    public function check_libur_exclude($user_nik){
        $query = $this->db->query("SELECT COUNT(1) As jumlah FROM tbl_formcutimassal_exclude WHERE nik = '".$user_nik."'");
        foreach ($query->result() as $key => $value) {
            $data = $value->jumlah;
        }

        if($data>0){
            return true;
        } else {
            return false;
        }

    }

    public function get_potential_substitution_user($user_nik){

        $this->db->select('NIKPengganti')
                  ->from($this->table_header)
                  ->where('FormCutiNIK', $user_nik)
                  ->where('StatusForm', 'A')
                  ->where('JenisCuti', 1)
                  ->order_by('CutiId','DESC')
                  ->limit(1);
        $query = $this->db->get();
        $num_row = $query->num_rows();
        $data  = $query->row(0);

        if($num_row > 0){
            return $data->NIKPengganti;
        }
        else{
            return '';
        }        
    }


    public function hrd_data_option($company,$modules){

        $this->db->select('*')
                     ->from($this->cms_complete_table_name('apv_hrd'))
                     ->where('hrd_status',1)
                     ->where('hrd_company',$company)
                     ->where('hrd_modules', $modules)
                     ->order_by('hrd_name','ASC');

        $db = $this->db->get();

        return $db->result();
    }

    public function atasan_langsung_data_option($dept){

        $this->db->select('tbl_profile.NIK AS NIK,tbl_profile.Nama AS Nama,tbl_profile.Email AS Email')
                     ->from($this->cms_complete_table_name('apv_group_approval'))
                     ->join('tbl_profile','tbl_apv_group_approval.NIK = tbl_profile.NIK')
                     ->where('tbl_apv_group_approval.deptID', $dept)
                     ->group_by('tbl_profile.NIK')
                     ->where('form_cuti', 1)
                     ->where('bStatus',1)
                     ->order_by('iGroupApprovalListId','ASC');

        $db = $this->db->get();

        return $db->result();
    }


    public function daftar_hari_utang_cuti($tahun){

        $data = array();
        $query = $this->db->query("SELECT Tanggal FROM tbl_formcuti_list_utang WHERE Status=1 and YEAR(Tanggal)='".$tahun."' Group by Tanggal order by Tanggal ASC");

        foreach ($query->result() as $key => $value) {
            $data[] = $value->Tanggal;
        }

        return $data;
    }

    public function daftar_hari_libur($tanggal){

        $data = array();
        $query = $this->db->query("SELECT a.keperluan FROM tbl_formcutimasal a, tbl_formcutimasaldetail b 
                                   WHERE a.cutiid=b.cutiid AND b.tglcuti = '".$tanggal."' 
                                   UNION ALL
                                   SELECT keterangan FROM tbl_holiday WHERE tanggal = '".$tanggal."'");

        foreach ($query->result() as $key => $value) {
            $data[] = $value->keperluan;
        }

        return $data;
    }


    public function total_sisa_cuti_tahunan($user_nik){
        $today    = date('Y-m-d');
        $sub_total  = 0;
        $grand = 0;

        $query = $this->db->query("select *,(select count(c.DetailCutiId) as total from ".$this->table_header." as b inner join ".$this->table_detail." as c on b.CutiId=c.CutiId 
                                where b.StatusForm IN ('A','P') and b.HakCutiId=a.HakId) as total_pakai,
                                (a.Qty-(select count(c.DetailCutiId) as total from ".$this->table_header." as b inner join ".$this->table_detail." as c on b.CutiId=c.CutiId where b.StatusForm IN ('A','P') and b.HakCutiId=a.HakId)) as sisa_cuti from 
                                tbl_hakcuti as a where a.NIK='".$user_nik."' and a.StatusHak=1 and  DATE(a.Periode1) <='".$today."' and 
                                if (a.PeriodeExt IS NOT NULL, DATE(a.PeriodeExt) >='".$today."', DATE(a.Periode2) >='".$today."') 
                                and
                                a.JenisHakCuti=1
                                group by a.HakId 
                                having sisa_cuti >0
                                order by a.JenisHakCuti,a.Periode1 ASC
                                
                                ");

        foreach ($query->result() as $key => $value) {

            @$grand += $value->sisa_cuti; 

        }

        return $grand;
    }


    public function total_sisa_cuti_besar($user_nik){
        $today    = date('Y-m-d');
        $sub_total  = 0;
        $grand = 0;

        $query = $this->db->query("select *,(select count(c.DetailCutiId) as total from ".$this->table_header." as b inner join ".$this->table_detail." as c on b.CutiId=c.CutiId 
                                where b.StatusForm='A' and b.HakCutiId=a.HakId) as total_pakai,
                                (a.Qty-(select count(c.DetailCutiId) as total from ".$this->table_header." as b inner join ".$this->table_detail." as c on b.CutiId=c.CutiId where b.StatusForm='A' and b.HakCutiId=a.HakId)) as sisa_cuti from 
                                tbl_hakcuti as a where a.NIK='".$user_nik."' and a.StatusHak=1 and  DATE(a.Periode1) <='".$today."' and 
                                if (a.PeriodeExt IS NOT NULL, DATE(a.PeriodeExt) >='".$today."', DATE(a.Periode2) >='".$today."') 
                                and
                                a.JenisHakCuti=2
                                group by a.HakId 
                                having sisa_cuti >0
                                order by a.JenisHakCuti,a.Periode1 ASC
                                LIMIT 1");

        foreach ($query->result() as $key => $value) {

            @$grand += $value->sisa_cuti; 

        }

        return $grand;
    }


    public function allocation_on_leave_data($user_id, $type){

        $today = date('Y-m-d');
        $data  = array();

        $query = $this->db->query("select *,(select count(c.DetailCutiId) as total from ".$this->table_header." as b inner join ".$this->table_detail." as c on b.CutiId=c.CutiId 
                                where b.StatusForm='A' and b.HakCutiId=a.HakId) as total_pakai,
                                (a.Qty-(select count(c.DetailCutiId) as total from ".$this->table_header." as b inner join ".$this->table_detail." as c on b.CutiId=c.CutiId where b.StatusForm='A' and b.HakCutiId=a.HakId)) as sisa_cuti from 
                                tbl_hakcuti as a where a.NIK='".$user_id."' and a.StatusHak=1 and  DATE(a.Periode1) <='".$today."' and 
                                if (a.PeriodeExt IS NOT NULL, DATE(a.PeriodeExt) >='".$today."', DATE(a.Periode2) >='".$today."') 
                                and
                                a.JenisHakCuti=".$type."
                                group by a.HakId 
                                having sisa_cuti >0
                                order by a.JenisHakCuti,a.Periode1 ASC");

        foreach ($query->result() as $key => $value) {

            $data['HakId'][] = $value->HakId;
            $data['Qty'][] = $value->Qty;
            $data['total_pakai'][] = $value->total_pakai;
            $data['sisa_cuti'][] = $value->sisa_cuti;           

        }

        return $data;
    }


    public function allocation_cuti($user_nik, $jenis_cuti){
        $today      = date('Y-m-d');
        $sub_total  = 0;
        $grand      = 0;
        
        $query = $this->db->query("select *,(select count(c.DetailCutiId) as total from ".$this->table_header." as b inner join ".$this->table_detail." as c on b.CutiId=c.CutiId 
                                where b.StatusForm IN ('A','P') and b.HakCutiId=a.HakId) as total_pakai,
                                (a.Qty-(select count(c.DetailCutiId) as total from ".$this->table_header." as b inner join ".$this->table_detail." as c on b.CutiId=c.CutiId where b.StatusForm IN ('A','P') and b.HakCutiId=a.HakId)) as sisa_cuti from 
                                tbl_hakcuti as a where a.NIK='".$user_nik."' and a.StatusHak=1 and  DATE(a.Periode1) <='".$today."' and 
                                if (a.PeriodeExt IS NOT NULL, DATE(a.PeriodeExt) >='".$today."', DATE(a.Periode2) >='".$today."') 
                                and
                                a.JenisHakCuti=".$jenis_cuti."
                                group by a.HakId 
                                having sisa_cuti >0
                                order by a.JenisHakCuti,a.Periode1 ASC LIMIT 1");

        $data = $query->row();
        return $data->HakId;
    }


    public function show_detail_cuti($primary_key){
        $today      = date('Y-m-d');
        $sub_total  = 0;
        $grand      = 0;
        
        $query = $this->db->query("SELECT * FROM ".$this->table_header." WHERE CutiId='".$primary_key."'");

        return $query->row();
    }


    public function basic_date_format($date){
        if (is_null($date) || $date =='0000-00-00'){
            $tanggal = '';
        }
        else{
            $tanggal = date('d-M-Y', strtotime($date));
        } 

        return $tanggal;
    }

    public function detail_date_format($date){
        if (is_null($date) || $date =='0000-00-00' || empty($date)){
            $tanggal = '';
        }
        else{
            $tanggal = date('d-M-Y H:i', strtotime($date));
        }
        return $tanggal;
    }

    public function date_to_sql($date){

        if (is_null($date) || $date =='0000-00-00'){
            $tanggal = '';
        }
        else{
            $orderdate = explode('/', $date);
            $day   = $orderdate[0];
            $month = $orderdate[1];                
            $year  = $orderdate[2];
            $tanggal = $year.'-'.$month.'-'.$day;
        } 

        return $tanggal;        
    }

    protected function _convert_date_to_sql_date($date, $date_format)
    {

        list($php_day, $php_month, $php_year) = array('d','m','Y');
        list($js_day, $js_month, $js_year) = array('dd','mm','yy');
        list($ui_day, $ui_month, $ui_year) = array('dd','mm','yyyy');

        if($date_format == 'uk-date'){
            $this->php_date_format      = "$php_day/$php_month/$php_year";
        }
        if($date_format == 'us-date'){
            $this->php_date_format      = "$php_month/$php_day/$php_year";
        }
        if($date_format == 'sql-date'){
            $this->php_date_format      = "$php_year-$php_month-$php_day";
        }


        $date = substr($date,0,10);
        if(preg_match('/\d{4}-\d{2}-\d{2}/',$date))
        {
            //If it's already a sql-date don't convert it!
            return $date;
        }elseif(empty($date))
        {
            return '';
        }

        $date_array = preg_split( '/[-\.\/ ]/', $date);
        if($this->php_date_format == 'd/m/Y')
        {
            $sql_date = date('Y-m-d',mktime(0,0,0,$date_array[1],$date_array[0],$date_array[2]));
        }
        elseif($this->php_date_format == 'm/d/Y')
        {
            $sql_date = date('Y-m-d',mktime(0,0,0,$date_array[0],$date_array[1],$date_array[2]));
        }
        else
        {
            $sql_date = $date;
        }

        return $sql_date;
    }


    public function day_name_id($tanggal){

        $day = date('D', strtotime($tanggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        return $dayList[$day];
    }

    public function show_detail_tanggal_cuti($primary_key){

        $query = $this->db->query("SELECT *,DATE_FORMAT(TglCuti, '%d-%b-%Y') AS TglCutiInd FROM ".$this->table_detail." WHERE CutiId='".$primary_key."' ORDER BY TglCuti ASC");

        return $query->result();
    }


    public function status_form_text($value){

        $query = $this->db->query("SELECT NamaStatusForm FROM tbl_statusform WHERE CodeStatusForm='".$value."'");
        $row   = $query->row();

        return $row->NamaStatusForm;
    }

    public function status_approval_caption($primary_key,$level_id){

        $html   ='';

        $NIK    = 'NIK'.$level_id;
        $Apv    = 'Apv'.$level_id;
        $Tgl    = 'Tgl'.$level_id;
        $Remark = 'Remark'.$level_id;

        $query = $this->db->query("SELECT * FROM ".$this->table_header." WHERE CutiId='".$primary_key."'");
        $data  = $query->row();

        $nama  = $this->get_data_row($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $data->$NIK);
        $status= $this->status_form_text($data->$Apv);
        $tanggal= $this->detail_date_format($data->$Tgl);
        $remark= $data->$Remark;

        if($data->$Apv == 'P'){
            $status = '<span class="label label-default">'.$status.'</span>';
        }
        elseif($data->$Apv == 'A'){
            $status = '<span class="label label-success">'.$status.'</span>';
        }
        elseif($data->$Apv == 'X'){
            $status = '<span class="label label-danger">'.$status.'</span>';
        }
        elseif($data->$Apv == 'R'){
            $status = '<span class="label label-danger">'.$status.'</span>';
        }
        else{
            $status = '<span class="label label-default">'.$status.'</span>';
        }

        $html .= $nama.', '.$status.' '.$tanggal.' <small>'.$remark.'</small>';

        return $html;
    }


    public function count_form_still_process($user_nik){

        $query = $this->db->query("select count(CutiId) as total_proses from ".$this->table_header." where FormCutiNIK='".$user_nik."' and StatusForm='P'");
        $data  = $query->row();
        return $data->total_proses;
    }

    public function count_hutang_cuti($user_nik, $year){

        $query = $this->db->query("select count(b.DetailCutiId) as total_hutang from ".$this->table_header." as a inner join ".$this->table_detail." as b on a.CutiId=b.CutiId 
            where a.FormCutiNIK='".$user_nik."' and (a.JenisCuti=0 or a.JenisCuti=1) and a.StatusForm='A' and a.HakCutiId=0 group by b.CutiId");

        $data  = $query->row();

        return $data->total_hutang;        
    }


    public function sejarah_tanggal_hutang_cuti($user_nik, $year){

        $query = $this->db->query("select a.CutiId,b.TglCuti,DATE_FORMAT(b.TglCuti, '%d-%b-%Y') AS TglCutiInd,a.Keperluan from ".$this->table_header." as a inner join ".$this->table_detail." as b on a.CutiId=b.CutiId 
            where a.FormCutiNIK='".$user_nik."' and (a.JenisCuti=0 or a.JenisCuti=1) and a.StatusForm='A' and a.HakCutiId=0 order by b.TglCuti asc");        

        return $query->result();        
    }
}