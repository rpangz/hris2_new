<?php
class detail_form_model extends CI_Model  {

	function __construct(){
        parent::__construct();
        
    }

    public function detail_form_sisa_cuti($form_id,$company_id){
    	
  		$modal_dialog = '<div id="myModal" class="modal fade">';
  		$modal_dialog .= '<div class="modal-dialog">';
  		$modal_dialog .= '<div class="modal-content">';
  		$modal_dialog .= '<div class="modal-header">';
  		$modal_dialog .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
  		$modal_dialog .= '<h4 class="modal-title">Detail #'.$form_id.'</h4>';
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '<div class="modal-body">';
  		$modal_dialog .= $this->data_form_sisa_cuti($form_id,$company_id);
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '<div class="modal-footer">';
  		$modal_dialog .= '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '</div>';

  		return $modal_dialog;

    }

    public function detail_form_cuti($form_id,$company_id,$session_id,$level_id){
    	
  		$modal_dialog = '<div id="myModal" class="modal fade">';
  		$modal_dialog .= '<div class="modal-dialog">';
  		$modal_dialog .= '<div class="modal-content">';
  		$modal_dialog .= '<div class="modal-header">';
  		$modal_dialog .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
  		$modal_dialog .= '<h4 class="modal-title"><span id="demo" class="label label-success">Detail #'.$form_id.'</span></h4>';
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '<div class="modal-body">';
  		$modal_dialog .= $this->data_form_cuti($form_id,$company_id,$session_id,$level_id);
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '<div class="modal-footer">';
  		$modal_dialog .= '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '</div>';

  		return $modal_dialog;

    }

    public function detail_form_ijin($form_id,$company_id,$session_id,$level_id){
    	
  		$modal_dialog = '<div id="myModal" class="modal fade">';
  		$modal_dialog .= '<div class="modal-dialog">';
  		$modal_dialog .= '<div class="modal-content">';
  		$modal_dialog .= '<div class="modal-header">';
  		$modal_dialog .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
  		$modal_dialog .= '<h4 class="modal-title">Detail #'.$form_id.'</h4>';
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '<div class="modal-body">';
  		$modal_dialog .= $this->data_form_ijin($form_id,$company_id,$session_id,$level_id);
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '<div class="modal-footer">';
  		$modal_dialog .= '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '</div>';
  		$modal_dialog .= '</div>';

  		return $modal_dialog;

    }

    public function data_form_sisa_cuti($form_id,$company_id,$session_id,$level_id){

      $sql   = "SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId= '".$form_id."'";

      if (!is_null($company_id)){
          $sql   .= " AND companyID='".$company_id."'";
      }
      if (!is_null($session_id)){
          $sql   .= " AND NIK='".$session_id."'";
      }
      if (!is_null($level_id)){
          $sql   .= " AND ApvLevel='".$level_id."'";
      }

      $query = mysql_query($sql);


    	//$query = mysql_query("SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId= '".$form_id."' AND companyID='".$company_id."'");
  		$data  = mysql_fetch_array($query);
  		$total = mysql_num_rows($query);
  
  		$table =  '<table class="table table-striped table-hover" border="0" width="100%" style="font-size:12px;">';
      $table .= '<tr><th width="30%">NIK / Nama</th><td>:</td><td>'.$data['NIK'].' / '.$this->nama_user($id = $data['NIK']).'</td></tr>';
      $table .= '<tr><th>Periode Cuti</th><td>:</td><td>'.$this->periode_hak_cuti($id=$data['HakCutiId']).'</td></tr>';
      $table .= '<tr><th>Tanggal Pengajuan</th><td>:</td><td>'.$this->format_tanggal_id($value=$data['CreatedTime']).', '.$this->nama_hari_id($date=$data['CreatedTime']).'</td></tr>';
      $table .= '<tr><th>Status Form</th><td>:</td><td>'.$this->status_form($value=$data['StatusForm']).'</td></tr>';

		$apv = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode=2 ORDER BY MatProses ASC");

	   	while($rows = mysql_fetch_array($apv)){
	   		$txt_nik = 'NIK'.$rows['MatProses'];
		    $txt_apv = 'Apv'.$rows['MatProses'];
		    $txt_tgl = 'Tgl'.$rows['MatProses'];

		    $apv_nik = $data[$txt_nik];
		    $apv_apv = $data[$txt_apv];
		    $apv_tgl = $data[$txt_tgl];

	        $table .= '<tr><th>'.$rows['MatName'].'</th><td>:</td><td>'.$this->nama_user($id=$apv_nik).', '.$this->progress_approval($apv_apv,$apv_tgl,$alasan=$data['AlasanApv']).'</td></tr>';

	    } 

        $table .= '</table>';

		if ($total >0){
			return $table;
		}
		else{
			return '<p><code>Data Not Found...</code></p>';
		}

    }

    public function data_form_cuti($form_id,$company_id,$session_id,$level_id){

      $sql   = "SELECT * FROM tbl_formcuti WHERE CutiId= '".$form_id."'";

      if (!is_null($company_id)){
          $sql   .= " AND companyID='".$company_id."'";
      }
      if (!is_null($session_id)){
          $sql   .= " AND FormCutiNIK='".$session_id."'";
      }
      if (!is_null($level_id)){
          $sql   .= " AND ApvLevel='".$level_id."'";
      }



      $query = mysql_query($sql);
    	//$query = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId= '".$form_id."' AND companyID='".$company_id."'");
  		$data  = mysql_fetch_array($query);
  		$total = mysql_num_rows($query);

      if ($data['JenisItemCuti'] <= 9 && $data['JenisCuti'] !=5){
        $total_cuti = $this->detail_total_cuti($value=$data['CutiId']);
        $tgl_cuti   = $this->detail_tanggal_cuti($value=$data['CutiId']);
      }
      elseif($data['JenisCuti'] == 5){
        $total_cuti = $this->count_days_cuti($id=$form_id);
        $tgl_cuti   = $this->active_days_cuti($id=$form_id);
      }
      else{
        $total_cuti = $this->count_days_cuti($id=$form_id);
        $tgl_cuti   = $this->active_days_cuti($id=$form_id);
      }


  		$style ='<style>
  						  ul {padding-left:1em} 
  						  li {padding-left:0px}
  				    </style>';

  		$table =  '<table class="table table-striped table-hover" border="0" width="100%" style="font-size:12px;">';
      $table .= '<tr><th width="30%">NIK / Nama</th><td>:</td><td>'.$data['FormCutiNIK'].' / '.$this->nama_user($id = $data['FormCutiNIK']).'</td></tr>';
        //$table .= '<tr><th>Nama</th><td>:</td><td>'.$this->nama_user($id = $data['FormCutiNIK']).'</td></tr>';
      $table .= '<tr><th>Keperluan</th><td>:</td><td>'.$data['Keperluan'].'</td></tr>';
      $table .= '<tr><th>Alamat</th><td>:</td><td>'.$data['Alamat'].'</td></tr>';
      $table .= '<tr><th>Pengganti</th><td>:</td><td>'.$this->nama_user($id=$data['NIKPengganti']).'</td></tr>';
      $table .= '<tr><th>No Telpon</th><td>:</td><td>'.$data['NoTelpon'].'</td></tr>';
      $table .= '<tr><th>Jenis Cuti</th><td>:</td><td>'.$this->jenis_hak_cuti($id=$data['JenisCuti']).'</td></tr>';
      $table .= '<tr><th>Tanggal Masuk</th><td>:</td><td>'.$this->format_tanggal_id($value=$data['TglMasuk']).', '.$this->nama_hari_id($date=$data['TglMasuk']).'</td></tr>';
      $table .= '<tr><th>Tanggal Pengajuan</th><td>:</td><td>'.$this->format_tanggal_id($value=$data['CreatedTime']).', '.$this->nama_hari_id($date=$data['CreatedTime']).'</td></tr>';
      $table .= '<tr><th>Tanggal Cuti</th><td>:</td><td>'.$tgl_cuti.'</td></tr>';
      //$table .= '<tr><th>Tanggal Cuti</th><td>:</td><td>'.$this->detail_tanggal_cuti($value=$data['CutiId']).'</td></tr>';
      //$table .= '<tr><th>Jumlah Cuti</th><td>:</td><td>'.$this->detail_total_cuti($value=$data['CutiId']).'</td></tr>';
      $table .= '<tr><th>Jumlah Cuti</th><td>:</td><td>'.$total_cuti.'</td></tr>';
      $table .= '<tr><th>Status Form</th><td>:</td><td>'.$this->status_form($value=$data['StatusForm']).'</td></tr>';
      $table .= '<tr><th>Alasan</th><td>:</td><td>'.$data['Alasan'].' '.$data['AlasanApv'].'</td></tr>';

		$apv = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode=1 ORDER BY MatProses ASC");

	   	while($rows = mysql_fetch_array($apv)){
	   		$txt_nik = 'NIK'.$rows['MatProses'];
		    $txt_apv = 'Apv'.$rows['MatProses'];
		    $txt_tgl = 'Tgl'.$rows['MatProses'];

		    $apv_nik = $data[$txt_nik];
		    $apv_apv = $data[$txt_apv];
		    $apv_tgl = $data[$txt_tgl];

	        $table .= '<tr><th>'.$rows['MatName'].'</th><td>:</td><td>'.$this->nama_user($id=$apv_nik).', '.$this->progress_approval($apv_apv,$apv_tgl,$alasan=$data['AlasanApv']).'</td></tr>';

	    }

        $table .= '</table>';

		if ($total >0){
			return $table.$style;
		}
		else{
			return '<p><code>Data Not Found...</code></p>';
		}

    }

    public function data_form_ijin($form_id,$company_id,$session_id,$level_id){

      $sql   = "SELECT * FROM tbl_formijin WHERE IjinId= '".$form_id."'";

      if (!is_null($company_id)){
          $sql   .= " AND companyID='".$company_id."'";
      }
      if (!is_null($session_id)){
          $sql   .= " AND NIK='".$session_id."'";
      }
      if (!is_null($level_id)){
          $sql   .= " AND ApvLevel='".$level_id."'";
      }

      $query = mysql_query($sql);
    	//$query = mysql_query("SELECT * FROM tbl_formijin WHERE IjinId= '".$form_id."' AND companyID='".$company_id."'");
  		$data  = mysql_fetch_array($query);
  		$total = mysql_num_rows($query);

  		$style ='<style>
  						ul {padding-left:1em} 
  						li {padding-left:0px}
  				</style>';

  		$table =  '<table class="table table-striped table-hover" border="0" width="100%" style="font-size:12px;">';
      $table .= '<tr><th width="30%">NIK / Nama</th><td>:</td><td>'.$data['NIK'].' / '.$this->nama_user($id=$data['NIK']).'</td></tr>';
      $table .= '<tr><th>Keperluan</th><td>:</td><td>'.$data['Alasan'].'</td></tr>';
      $table .= '<tr><th>Jenis Ijin</th><td>:</td><td>'.$this->jenis_hak_ijin($id=$data['JenisIjin']).'</td></tr>';
      $table .= '<tr><th>Tanggal / Pukul</th><td>:</td><td>'.$this->tanggal_active_ijin($value=$data['IjinId']).'</td></tr>';
      $table .= '<tr><th>Tanggal Pengajuan</th><td>:</td><td>'.$this->format_tanggal_id($value=$data['CreatedTime']).', '.$this->nama_hari_id($date=$data['CreatedTime']).'</td></tr>';
      $table .= '<tr><th>Status Form</th><td>:</td><td>'.$this->status_form($value=$data['StatusForm']).'</td></tr>';

		$apv = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode=4 ORDER BY MatProses ASC");

	   	while($rows = mysql_fetch_array($apv)){
	   		$txt_nik = 'NIK'.$rows['MatProses'];
		    $txt_apv = 'Apv'.$rows['MatProses'];
		    $txt_tgl = 'Tgl'.$rows['MatProses'];
		    $apv_nik = $data[$txt_nik];
		    $apv_apv = $data[$txt_apv];
		    $apv_tgl = $data[$txt_tgl];

	        $table .= '<tr><th>'.$rows['MatName'].'</th><td>:</td><td>'.$this->nama_user($id=$apv_nik).', '.$this->progress_approval($apv_apv,$apv_tgl,$alasan=$data['AlasanApv']).'</td></tr>';

	    }

        $table .= '</table>';

        if ($total >0){
			return $table.$style;
		}
		else{
			return '<p><code>Data Not Found...</code></p>';
		}

    }

    public function periode_hak_cuti($id){

    	$query = mysql_query("SELECT * FROM tbl_hakcuti INNER JOIN tbl_jeniscuti ON JenisHakCuti=id WHERE HakId='".$id."'");
  		$data  = mysql_fetch_array($query);
  		$total = mysql_num_rows($query);

  		if ($total >0){
	  		$periode1 = date('d-M-Y', strtotime($data['Periode1']));
	  		$periode2 = date('d-M-Y', strtotime($data['Periode2']));
	  		$type 	  = ' ('.$data['JenisCutiName'].')';
  		}else{
  			$periode1 = '';
	  		$periode2 = '';
	  		$type 	  = '';
  		}

  		return $periode1.' s/d '.$periode2.' '.$type;

    }

    public function jenis_hak_cuti($id){

    	$query = mysql_query("SELECT * FROM tbl_jeniscuti WHERE id='".$id."'");
  		$data  = mysql_fetch_array($query);
  		$total = mysql_num_rows($query);

  		if ($total >0){
	  		$type 	  = $data['JenisCutiName'];
  		}else{
	  		$type 	  = '';
  		}

  		return $type;

    }

    public function jenis_hak_ijin($id){

    	$query = mysql_query("SELECT * FROM tbl_jenisijin WHERE JenisIjinId='".$id."'");
  		$data  = mysql_fetch_array($query);
  		$total = mysql_num_rows($query);

  		if ($total >0){
	  		$type 	  = $data['JenisIjinName'];
  		}else{
	  		$type 	  = '';
  		}

  		return $type;

    }

    public function nama_user($id){

    	$query = mysql_query("SELECT * FROM tbl_profile WHERE NIK='".$id."'");
  		$data  = mysql_fetch_array($query);
  		$total = mysql_num_rows($query);

  		if ($total >0){
  			return $data['Nama'];
  		}else{
  			return '';
  		}

    }

    public function progress_approval($apv_apv,$apv_tgl,$alasan){

	    if ($apv_apv == 'A'){
	        $Tip1  = '(Accepted)';
	        $Tgl1  = date('d-M-Y H:i', strtotime($apv_tgl)).' WIB';
	        $als1  = '';
	    }
	    elseif($apv_apv =='P'){	        
	        $Tip1  = 'Process';       
	        $Tgl1  = '';
	        $als1  = '';
	    }
	    elseif($apv_apv =='R'){        
	        $Tip1  = '(Rejected)';
	        $Tgl1  = date('d-M-Y H:i', strtotime($apv_tgl)).' WIB';
	        $als1  = 'Karena '.$alasan;
	    }
	    elseif($apv_apv =='X'){        
	        $Tip1  = '(Voided)';
	        $Tgl1  = date('d-M-Y H:i', strtotime($apv_tgl)).' WIB';
	        $als1  = 'Karena '.$alasan;
	    }
	    else {       
	        $Tip1  = 'Process';      
	        $Tgl1  = '';
	        $als1  = '';
	    }

	    return $Tgl1.' '.$Tip1;
	       

    }

    public function status_form($value){

    	if ($value == 'A'){
	        $bg = '#00FF00';
	        $st = 'Accepted';	               
	    }
	    elseif ($value == 'R'){
	        $bg = '#FF0000';
	        $st = 'Rejected';	        
	    }
	    elseif ($value == 'X'){
	        $bg = '#FF00FF';
	        $st = 'Voided';	             
	    }    
	    else {
	        $bg = '';
	        $st = 'Process';	              
	    }

	    return $st;
	    //return array('bg'=>$bg,'string'=>$st);

    }

    public function format_tanggal_id($value){

    	if (!empty($value) || !is_null($value) || $value== '0000-00-00'){
    		$tanggal = date('d-M-Y', strtotime($value));
    	}
    	else{
    		$tanggal = 'N/A';
    	}
    	return $tanggal;

    }

    public function detail_tanggal_cuti($value){

    	$detail = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId ='".$value."' ORDER BY TglCuti ASC");
  		$total  = mysql_num_rows($detail);

     	$no = 1;
     	$date = '<ul>';
     	while($data = mysql_fetch_array($detail)){
      		$tanggal_id = date('d-M-Y', strtotime($data['TglCuti']));
      		$hari 		= $this->nama_hari_id($data['TglCuti']);

        	$date .= '<li>'.$tanggal_id.', '.$hari.'</li>';
        	$no++;

      	}
      	$date .= '</ul>';

      	if ($total >0){
      		return $date;
      	}
      	else{
      		return 'N/A';
      	} 


    }

    public function tanggal_active_ijin($value){

    	$detail = mysql_query("SELECT * FROM tbl_formijin WHERE IjinId='".$value."'");
  		$total  = mysql_num_rows($detail);
  		$data   = mysql_fetch_array($detail);

  		$active_date1 = date('d-M-Y H:i', strtotime($data['TglActive1']));
  		$active_date2 = date('d-M-Y H:i', strtotime($data['TglActive2']));

      	if (empty($data['TglActive2'])){

      		$str = $active_date1;

      	}
      	else{
      		$str = $active_date1.' ~ '.$active_date2;
      	}

      	return $str;


    }

    public function detail_total_cuti($value){

    	$detail = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId ='".$value."' ORDER BY TglCuti ASC");
  		$total  = mysql_num_rows($detail);
     	
     	if ($total >0){
      		return $total.' Hari';
      	}
      	else{
      		return 'N/A';
      	}

    }

    public function nama_hari_id($date){

    	$dayin = date('N', strtotime($date));

        if ($dayin==1){
            $nDayin = 'Senin';
        }
        elseif ($dayin==2){
            $nDayin = 'Selasa';
        }
        elseif ($dayin==3){
            $nDayin = 'Rabu';
        }
        elseif ($dayin==4){
        	$nDayin = 'Kamis';
        }
        elseif ($dayin==5){
            $nDayin = 'Jumat';
        }
        elseif ($dayin==6){
          	$nDayin = 'Sabtu';
        }
        elseif ($dayin==7){
            $nDayin = 'Minggu';
        }
        else{
        	$nDayin = '';
        }

        if (!empty($date) || !is_null($date) || $date== '0000-00-00'){
    		$hari = $nDayin;
    	}
    	else{
    		$hari = 'N/A';
    	}

    	return $hari;


    }

    public function count_days_cuti($id){

      $query  = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId='$id'");
      $total  = mysql_num_rows($query);
      $data   = mysql_fetch_array($query);

      $startTimeStamp = strtotime($data['TglActive1']);
      $endTimeStamp   = strtotime($data['TglActive2']);
      $timeDiff     = abs($endTimeStamp - $startTimeStamp);
      $numberDays   = $timeDiff/86400;  // 86400 seconds in one day
      $numberDays   = intval($numberDays+1);

      return $numberDays.' Hari';

    }

    public function active_days_cuti($id){

      $query  = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId='$id'");
      $total  = mysql_num_rows($query);
      $data   = mysql_fetch_array($query);

      $TglActive1   = date('d-M-Y', strtotime($data['TglActive1']));
      $TglActive2   = date('d-M-Y', strtotime($data['TglActive2']));

      return $TglActive1.' s/d '.$TglActive2;

    }




}

?>