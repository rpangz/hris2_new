<?php
class form_substitution_model extends CI_Model {

	function __construct(){
        parent::__construct();
    }

    public function form_cuti_view_total($nik,$current_nik){

        $sql     = mysql_query("SELECT * FROM  (SELECT *,CONCAT('NIK',ApvLevel) as SubstitutionNIK FROM tbl_formcuti WHERE StatusForm='P') a");
        $jumlah  = mysql_num_rows($sql);
        @$grand  = 0;
            while($rows = mysql_fetch_assoc($sql)){
                $look_apv = mysql_query('SELECT * FROM tbl_formcuti WHERE CutiId="'.$rows['CutiId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
                $view_row  = mysql_num_rows($look_apv);
                @$grand += $view_row;
            }

        return $grand;
    }

    public function form_ijin_view_total($nik,$current_nik){
        $sql     = mysql_query("SELECT * FROM  (SELECT *,CONCAT('NIK',ApvLevel) as SubstitutionNIK FROM tbl_formijin WHERE StatusForm='P') a");
        $jumlah  = mysql_num_rows($sql);
        @$grand  = 0;
            while($rows = mysql_fetch_assoc($sql)){
                $look_apv = mysql_query('SELECT * FROM tbl_formijin WHERE IjinId="'.$rows['IjinId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
                $view_row  = mysql_num_rows($look_apv);
                @$grand += $view_row;
            }

        return $grand;
    }

    public function form_sisa_cuti_view_total($nik,$current_nik){
        $sql     = mysql_query("select a1.*,CONCAT('NIK',ApvLevel) as SubstitutionNIK from tbl_formperpcuti a1 inner join 
                              (select max(FormPerpCutiId) as max from tbl_formperpcuti group by HakCutiId,NIK) a2 on a1.FormPerpCutiId = a2.max WHERE StatusForm='P'");
        $jumlah  = mysql_num_rows($sql);
        @$grand  = 0;
            while($rows = mysql_fetch_assoc($sql)){
                $look_apv = mysql_query('SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId="'.$rows['FormPerpCutiId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
                $view_row  = mysql_num_rows($look_apv);
                @$grand += $view_row;   

            }

        return $grand;
    }

    public function form_cv_view_total($nik,$current_nik){
        $sql     = mysql_query("SELECT * FROM  (SELECT `ProcessId`, `ProcessNIK`, `ProcessLevel`, `ProcessStatusForm`, `ProcessNIK1`, `ProcessNIK2`, `ProcessApv1`, `ProcessApv2`, `ProcessPin`, `ProcessPin1`, `ProcessPin2`, `ProcessDate1`, `ProcessDate2`, `ProcessRemark1`, `ProcessRemark2`, `PorcessAlasanApv`, `ProcessLastId`, `ProcessRepeated`,CONCAT('ProcessNIK',ProcessLevel) as SubstitutionNIK 
                   FROM tbl_profile INNER JOIN 
                   tbl_profile_process ON tbl_profile_process.ProcessId = tbl_profile.ProcessCVNumber 
                   WHERE bStatus=1 AND ProcessStatusForm='P') a");
        $jumlah  = mysql_num_rows($sql);
        @$grand  = 0;
            while($rows = mysql_fetch_assoc($sql)){
                $look_apv = mysql_query('SELECT * FROM tbl_profile_process WHERE ProcessId="'.$rows['ProcessId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
                $view_row  = mysql_num_rows($look_apv);
                @$grand += $view_row;
            }

        return $grand;
    }

    public function all_form_view_total($nik,$current_nik){

        $grand_total =  $this->form_cuti_view_total($nik,$current_nik);
        $grand_total += $this->form_ijin_view_total($nik,$current_nik);
        $grand_total += $this->form_sisa_cuti_view_total($nik,$current_nik);
        $grand_total += $this->form_cv_view_total($nik,$current_nik);          

        return $grand_total;

    }

    public function all_potential_user_form($nik){

        $query  = mysql_query('SELECT * FROM `tbl_substitution_potential` INNER JOIN tbl_profile ON NIK=CurrentNIK WHERE PotentialNIK="'.$nik.'" GROUP BY CurrentNIK ORDER BY Nama ASC');
        $total  = mysql_num_rows($query);
        $total  = 0;
        while($data = mysql_fetch_assoc($query)){

            $total += $this->all_form_view_total($nik,$current_nik=$data['CurrentNIK']);

        }
        return $total;
    }

    public function current_substitution_status($nik){

        $query  = mysql_query('SELECT * FROM tbl_profile WHERE NIK='.$nik);
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);

        if ($total >0){

            if ($data['SubstitutionStatus']==1){
                return '<span class="label label-success">&nbsp;ON&nbsp;</span>';
            }else{
                return '<span class="label label-default">OFF</span>';
            }
        }
        else {
            return '<span class="label label-default">OFF</span>';
        }

    }

    
}
?>