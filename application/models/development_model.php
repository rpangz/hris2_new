<?php
class development_model extends CI_Model  {


	function __construct(){
        parent::__construct();
        $this->load->model('detail_form_model');
        $this->config->load('grocery_crud');
        
  }
    

    public function user_kpi_performance($session_nik, $session_company, $session_dept, $session_kpi=1, $action, $field, $periode, $primary_key){            
        //$this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from('tbl_kpi_performance')
            ->where('performance_nik', $session_nik)
            ->where('performance_periode', $periode)
            ->get();
        $result = $query->result_array();
        $num_row = $query->num_rows();

        if ($num_row >0){
          $val1 = $this->current_value_performace($session_nik, $periode);
          $val2 = $this->kpi_weight($session_kpi=1);

          $current_value = ($val1 * $val2)/100;
          $current_value = ($current_value)/$num_row;
          $current_value = number_format($current_value,2);
        }
        else{
          $current_value = 0.00; 
        }

        $options = array();
       
        $data = array(
            'title' => '<h3>'.$this->kpi_type_title($session_kpi=1).' '.$periode.'</h3>',
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'total' => $num_row,
            'current_value_performance' => $current_value,
            'primary_key' =>$primary_key,
        );
        return $this->load->view('development/field_detail_performance',$data, TRUE);

    }


    public function user_kpi_attitude($session_nik, $session_company, $session_dept, $session_kpi=2, $action, $field, $periode, $primary_key){
        //$this->config->load('grocery_crud');
        $date_format = $this->config->item('grocery_crud_date_format');
           
        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from('tbl_kpi_attitude')
            ->where('attitude_nik', $session_nik)
            ->where('attitude_periode', $periode)
            ->get();
        $result = $query->result_array();
        $num_row = $query->num_rows();

        $val1 = $this->current_value_attitude($session_nik, $periode);
        $val2 = $this->kpi_weight($session_kpi=2);

        $current_value = ($val1 * $val2)/100;
        $current_value = ($current_value)/$num_row;
        $current_value = number_format($current_value,2);

        $options = array();
       
        $data = array(
            'title' => '<h3>'.$this->kpi_type_title($session_kpi=2).'</h3>',
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'periode' => $periode,
            'total' => $num_row,
            'current_value_attitude' => $current_value,
        );

      return $this->load->view('development/field_detail_attitude',$data, TRUE);


    }


    public function user_kpi_time($session_nik, $session_company, $session_dept, $session_kpi=3, $action, $field, $periode, $primary_key){

      //$this->config->load('grocery_crud');
      $date_format = $this->config->item('grocery_crud_date_format');
      $module_path = 'development'; 
     
      $this->config->load('grocery_crud');
      
        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from('tbl_kpi_attitude')
            ->where('attitude_nik', $session_nik)
            ->where('attitude_periode', $periode)
            ->get();
        $result = $query->result_array();
        $num_row = $query->num_rows();

        $val1 = $this->current_value_attitude($session_nik, $periode);
        $val2 = $this->kpi_weight($session_kpi=2);

        $current_value = ($val1 * $val2)/100;
        $current_value = ($current_value)/$num_row;
        $current_value = number_format($current_value,2);

        $options = array();

        $data = array(
            'title' => '<h3>'.$this->kpi_type_title($session_kpi=3).'</h3>',
            'result' => $result,
            'options' => $options,
            'date_format' => $date_format,
            'periode' => $periode,
            'total' => $num_row,
            'current_value_attitude' => $current_value,
        );

      return $this->load->view('development/field_detail_time',$data, TRUE);


    }


   
    public function nav_tabs_kpi(){

      $query = mysql_query("SELECT * FROM tbl_kpi_type WHERE kpi_type_status='1'");
      $total = mysql_num_rows($query);

      $no =1;
      $navi = '';
      while($data = mysql_fetch_array($query)){

        if ($no==1){
          $status= 'active';
        }else{
          $status= '';
        }

        $navi .= '<li class="'.$status.'"><a href="#'.$data['kpi_type_name'].'" data-toggle="tab"><img src="'.$data['kpi_type_icon'].'" class="img-circle" alt="'.$data['kpi_type_name'].'" width="30" height="30"> '.$data['kpi_type_name'].'</a></li>';

        $no++;

      }

      return $navi;


    }


    public function nav_tabs_content_kpi($session_nik, $session_company, $session_dept, $session_kpi=NULL, $action, $field, $periode, $primary_key){

      $query = mysql_query("SELECT * FROM tbl_kpi_type WHERE kpi_type_status='1'");
      $total = mysql_num_rows($query);

      $no =1;
      $navi = '';
      while($data = mysql_fetch_array($query)){

        if ($no==1){
          $status= 'active';
        }else{
          $status= '';
        }

        $code = 'user_kpi_'.$data['kpi_type_code'];

        $navi .= '<div class="tab-pane fade in '.$status.'" id="'.$data['kpi_type_name'].'">';
        $navi .= $this->development_model->$code($session_nik, $session_company, $session_dept, $session_kpi=NULL, $action, $field, $periode, $primary_key);
        $navi .= '</div>';

        $no++;

      }

      return $navi;


    }


    public function kpi_weight($session_kpi){

      $query  = mysql_query('SELECT * FROM tbl_kpi_type WHERE kpi_type_id='.$session_kpi);
      $total  = mysql_num_rows($query);
      $data   = mysql_fetch_array($query);

      return $data['kpi_type_weight'];   

    }

    public function kpi_type_title($session_kpi){

      $query  = mysql_query('SELECT * FROM tbl_kpi_type WHERE kpi_type_id='.$session_kpi);
      $total  = mysql_num_rows($query);
      $data   = mysql_fetch_array($query);

      return $data['kpi_type_title'].' ( Bobot : '.$data['kpi_type_weight'].'% )';   

    }

    public function kpi_total_data($session_kpi){

      $query  = mysql_query('SELECT * FROM tbl_kpi_type WHERE kpi_type_id='.$session_kpi);
      $data   = mysql_fetch_array($query);

      $sql = mysql_query("SELECT * FROM tbl_kpi_".$data['kpi_type_code']);

      $total  = mysql_num_rows($sql);

      return $total; 


    }

    public function jumlah_sakit_tanpa_surat_dokter($session_nik,$periode){

      $token = mysql_escape_string($periode);

      /*
      $query  = mysql_query("SELECT count(TglActive1) AS Jumlah FROM `tbl_formijin` WHERE JenisIjin=3 AND StatusForm='A' AND YEAR(TglActive1) ='".$token."' AND NIK='".$session_nik."' GROUP BY YEAR(TglActive1)");
      $data   = mysql_fetch_array($query);
      $total  = mysql_num_rows($query);
      */

      $query  = mysql_query("SELECT * FROM `tbl_kpi_result` INNER JOIN tbl_kpi_time ON tbl_kpi_time.kpi_result_id=tbl_kpi_result.kpi_result_id WHERE kpi_result_periode='".$token."' AND kpi_result_nik='".$session_nik."' AND time_item='2'");
      $data   = mysql_fetch_array($query);
      $total  = mysql_num_rows($query);

      if ($total > 0){
        return $data['time_result'];
      }else{
        return '';
      }

    }

    public function jumlah_tidak_hadir_tanpa_alasan($session_nik,$periode){
      $token  = mysql_escape_string($periode);
      $query  = mysql_query("SELECT * FROM `tbl_kpi_result` INNER JOIN tbl_kpi_time ON tbl_kpi_time.kpi_result_id=tbl_kpi_result.kpi_result_id WHERE kpi_result_periode='".$token."' AND kpi_result_nik='".$session_nik."' AND time_item='3'");
      $data   = mysql_fetch_array($query);
      $total  = mysql_num_rows($query);

      if ($total > 0){
        return $data['time_result'];
      }else{
        return '';
      }

    }

    public function jumlah_datang_terlambat($session_nik, $periode){
      /*
      $token = mysql_escape_string($periode);
      $query  = mysql_query("SELECT count(TglActive1) AS Jumlah FROM `tbl_formijin` WHERE JenisIjin='3' AND StatusForm='A' AND YEAR(TglActive1) = '".$token."' AND NIK='".$session_nik."' GROUP BY YEAR(TglActive1)");
      $data   = mysql_fetch_array($query);
      $total  = mysql_num_rows($query);
      */


      $token  = mysql_escape_string($periode);
      $query  = mysql_query("SELECT * FROM `tbl_kpi_result` INNER JOIN tbl_kpi_time ON tbl_kpi_time.kpi_result_id=tbl_kpi_result.kpi_result_id WHERE kpi_result_periode='".$token."' AND kpi_result_nik='".$session_nik."' AND time_item='1'");
      $data   = mysql_fetch_array($query);
      $total  = mysql_num_rows($query);

      if ($total > 0){
        return $data['time_result'];
      }else{
        return '';
      }

    }


    public function nilai_datang_terlambat($session_nik,$periode){

      $value = $this->jumlah_datang_terlambat($session_nik,$periode);

      if (!is_null($value)){

        if($value < 260){
            $nilai = 10;
        }
        elseif($value >= 261 && $value <= 530){
            $nilai = 9;
        }
        elseif($value >= 531 && $value <= 791){
            $nilai = 8;
        }
        elseif($value >= 792 && $value <= 1050){
            $nilai = 7;
        }
        elseif($value >= 1051 && $value <= 1320){
            $nilai = 6;
        }
        elseif($value >= 1321 && $value <= 1580){
            $nilai = 5;
        }
        elseif($value >= 1581 && $value <= 1840){
            $nilai = 4;
        }
        elseif($value >= 1841 && $value <= 2110){
            $nilai = 3;
        }
        elseif($value >= 2111 && $value <= 2370){
            $nilai = 2;
        }
        elseif($value >2371){
            $nilai = 1;
        }
        else{
            $nilai = 0;
        }

      }

      else{
        $nilai = '';
      }

      return $nilai;


    }


    public function nilai_sakit_tanpa_surat_dokter($session_nik,$periode){
      
      $value = $this->jumlah_sakit_tanpa_surat_dokter($session_nik,$periode);

      if (!is_null($value)){

        if($value ==0){
            $nilai = 10;
        }
        elseif($value == 1){
            $nilai = 9;
        }
        elseif($value == 2){
            $nilai = 8;
        }
        elseif($value == 3){
            $nilai = 7;
        }
        elseif($value == 4){
            $nilai = 6;
        }
        elseif($value == 5){
            $nilai = 5;
        }
        elseif($value == 6){
            $nilai = 4;
        }
        elseif($value == 7){
            $nilai = 3;
        }
        elseif($value == 8){
            $nilai = 2;
        }
        elseif($value > 9){
            $nilai = 1;
        }
        else{
            $nilai = 0;
        }

      }
      else{
        $nilai = '';
      }

      return $nilai;


    }

    public function nilai_tidak_hadir_tanpa_alasan($session_nik,$periode){
      
      $value = $this->jumlah_tidak_hadir_tanpa_alasan($session_nik,$periode);

      if (!is_null($value)){

        if($value ==0){
            $nilai = 9;
        }
        elseif($value == 1){
            $nilai = 8;
        }
        elseif($value == 2){
            $nilai = 7;
        }
        elseif($value == 3){
            $nilai = 6;
        }
        elseif($value == 4){
            $nilai = 5;
        }
        elseif($value == 5){
            $nilai = 4;
        }
        elseif($value == 6){
            $nilai = 3;
        }
        elseif($value == 7){
            $nilai = 2;
        }
        elseif($value > 8){
            $nilai = 1;
        }
        else{
            $nilai = '';
        }
      }

      else{
          $nilai = '';
      }

      return $nilai;


    }

    public function nilai_rata_rata_time($session_nik,$periode){

      $val1 = $this->nilai_datang_terlambat($session_nik,$periode);
      $val2 = $this->nilai_sakit_tanpa_surat_dokter($session_nik,$periode);
      $val3 = $this->nilai_tidak_hadir_tanpa_alasan($session_nik,$periode);

      $total = (($val1 + $val2 + $val3) / 3);

      return number_format($total,2);


    }

    public function calculate_rata_rata_time($session_nik,$periode){

      $val1 = $this->nilai_datang_terlambat($session_nik,$periode);
      $val2 = $this->nilai_sakit_tanpa_surat_dokter($session_nik,$periode);
      $val3 = $this->nilai_tidak_hadir_tanpa_alasan($session_nik,$periode);

      $total = (($val1 + $val2 + $val3) * $this->kpi_weight($session_kpi=3)/100);
      $total = $total/3;

      return number_format($total,2);
      //return $val3;


    }

    public function status_radio_jumlah_datang_terlambat($session_nik, $periode, $value){

        $val = $this->nilai_datang_terlambat($session_nik,$periode);

        if ($val==$value && !empty($val)){
          $status = 'checked';

        }else{
          $status = '';
        }

        return $status;
    }


    public function status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value){

        $val = $this->nilai_sakit_tanpa_surat_dokter($session_nik,$periode);

        if ($val==$value){
          $status = 'checked';

        }else{
          $status = '';
        }

        return $status;
    }

    public function status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value){

        $val = $this->nilai_tidak_hadir_tanpa_alasan($session_nik,$periode);

        if ($val==$value){
          $status = 'checked';

        }else{
          $status = '';
        }

        return $status;


    }


    public function current_value_performace($session_nik, $periode){
        $token = mysql_escape_string($periode);
        $query  = mysql_query("SELECT sum(performance_value) AS total FROM tbl_kpi_performance WHERE performance_periode='".$token."' AND performance_nik='".$session_nik."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);        

        if (is_null($data['total'])){
            return 0;
        }
        else{
            return $data['total'];
        }


    }

    public function current_value_attitude($session_nik, $periode){
        $token  = mysql_escape_string($periode);
        $query  = mysql_query("SELECT sum(attitude_value) AS total FROM tbl_kpi_attitude WHERE attitude_periode='".$token."' AND attitude_nik='".$session_nik."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);        

        if (is_null($data['total'])){
            return 0;
        }
        else{
            return $data['total'];
        }


    }

    public function evaluator_result($primary_key){

        $query  = mysql_query("SELECT * FROM tbl_kpi_evaluator WHERE kpi_result_id='".$primary_key."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);        

        if ($total > 0){
            return $data['evaluator_desc'];
        }
        else{
            return '';
        }


    }


    public function incumbent_result($primary_key){

        $query  = mysql_query("SELECT * FROM tbl_kpi_incumbent WHERE kpi_result_id='".$primary_key."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);        

        if ($total > 0){
            return $data['incumbent_desc'];
        }
        else{
            return '';
        }


    }


    public function review_result($primary_key, $item){

        $query  = mysql_query("SELECT * FROM tbl_kpi_review WHERE kpi_result_id='".$primary_key."' AND review_item ='".$item."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);        

        if ($total > 0){
            return $data['review_desc'];
        }
        else{
            return '';
        }


    }


    public function review_form($primary_key){

        $query  = mysql_query("SELECT * FROM tbl_kpi_review_item WHERE review_item_status='1' ORDER BY review_item_id ASC");
        $total  = mysql_num_rows($query);

        $no =1;
        $empty = '';
        while($data = mysql_fetch_array($query)){

          $empty .= '<tr>';
          $empty .= '<td width="20%">'.$data['review_item_name'].'</td>';
          $empty .= '<td width="80%">';
          $empty .= '<textarea style="width: 100%; height: 100%; border: none; font-style:italic;" placeholder="Silahkan diisi..." class="form-control" name="review_note_'.$data['review_item_id'].'" readonly>'.$this->review_result($primary_key, $item=$data['review_item_id']).'</textarea>';
          $empty .= '</td>';
          $empty .= '</tr>';

        $no++;

        }

        return $empty;


    }

    public function get_name_user($nik){

        $query  = mysql_query("SELECT * FROM tbl_profile WHERE NIK='".$nik."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);        

        if ($total > 0){
            return $data['Nama'];
        }
        else{
            return '';
        }



    }

    
    

    




}

?>