<?php
class data_filter_model extends CI_Model  {

	function __construct(){
        parent::__construct();
    }

    public function data_filter_company_per_type($company_id,$current_id,$modules,$pages){
    	
		$empty_select = '<div class="row">';
		$empty_select .='<div class="col-sm-6">';
    	$empty_select .='<select data-live-search="true" style="width: 100%; display: none;" class="selectpicker form-control" data-container="body" onchange=goToPage("select") name="select" id="select">';
  		$empty_select .='<option value="" disabled SELECTED>Select Karyawan</option>';
        $empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/0').'">---ALL---</option>';
        $empty_select_closed = '</select></div></div><br/>';

        $java_script = '<script type = "text/javascript">
						function goToPage(id) {
						  var node = document.getElementById(id);  
						  if( node &&
						    node.tagName == "SELECT" ) {
						    window.location.href = node.options[node.selectedIndex].value;    
						  }  
						}
						</script>';
		$tampil = mysql_query("SELECT * FROM tbl_div WHERE iDivCompany='".$company_id."' ORDER BY cDivName ASC");
  		while ($rows = mysql_fetch_array($tampil)){

  		$empty_select .='<optgroup label="'.$rows['cDivName'].' Division">';

	    $sql = mysql_query("SELECT * FROM tbl_profile WHERE DivisiID='".$rows['iDivId']."' ORDER BY Nama ASC");            
	    while ($data = mysql_fetch_array($sql)){
		    if($current_id==$data['NIK']){  
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$data['NIK']).'" data-subtext="'.$data['NIK'].'" SELECTED>'.$data['Nama'].'</option>';
		    }
		    else {
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$data['NIK']).'" data-subtext="'.$data['NIK'].'">'.$data['Nama'].'</option>';
		    }
	  	}
	  	$empty_select .='</optgroup>';
	  	}  

  		return $empty_select.$empty_select_closed.$java_script;
    }



    public function data_filter_company_and_form_cuti($company_id,$modules,$pages,$type_cuti,$nikki){

    	$div_open     = '<div class="row">';
		$empty_select ='<div class="col-sm-4">';
    	$empty_select .='<select data-live-search="false" style="width: 100%; display: none;" class="selectpicker form-control" data-container="body" onchange=goToPage("select") name="select" id="select">';
  		$empty_select .='<option value="" disabled SELECTED>Select Jenis Cuti</option>';
        //$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/0').'">---ALL---</option>';        

        $java_script = '<script type = "text/javascript">
						function goToPage(id) {
						  var node = document.getElementById(id);  
						  if( node &&
						    node.tagName == "SELECT" ) {
						    window.location.href = node.options[node.selectedIndex].value;    
						  }  
						}
						</script>';

		

		

		$sql = mysql_query("SELECT * FROM tbl_jeniscuti");            
	    while ($data = mysql_fetch_array($sql)){
		    if($type_cuti==$data['id']){
		    	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$data['id'].'/'.$nikki).'" SELECTED>'.$data['JenisCutiName'].'</option>';  
		       //echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/".$this->uri->segment('1')."/".$this->uri->segment('2')."/index/".$data['id']."/".$NIKKI."' SELECTED>$data[JenisCutiName]</option>";
		    }

		    else {
		    	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$data['id'].'/'.$nikki).'">'.$data['JenisCutiName'].'</option>';
		      //echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/".$this->uri->segment('1')."/".$this->uri->segment('2')."/index/".$data['id']."/".$NIKKI."'>$data[JenisCutiName]</option>";
		    }
		}


	    

	  	$empty_select .= '</select>';
        $empty_select .= '</div>';		
		$empty_select .='<div class="col-sm-6">';
    	$empty_select .='<select data-live-search="true" class="selectpicker form-control" data-container="body" onchange=goToPage("select2") name="select2" id="select2">';
  		$empty_select .='<option value="" disabled SELECTED>Select Karyawan</option>';
        $empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$type_cuti.'/0').'">---ALL---</option>';      

        $tampil = mysql_query("SELECT * FROM tbl_div WHERE iDivCompany='".$company_id."' ORDER BY cDivName ASC");
  		while ($rows = mysql_fetch_array($tampil)){

  		$empty_select .='<optgroup label="'.$rows['cDivName'].' Division">';

	    $sql = mysql_query("SELECT * FROM tbl_profile WHERE DivisiID='".$rows['iDivId']."' ORDER BY Nama ASC");            
	    while ($data = mysql_fetch_array($sql)){
		    if($nikki==$data['NIK']){  
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$type_cuti.'/'.$data['NIK']).'" data-subtext="'.$data['NIK'].'" SELECTED>'.$data['Nama'].'</option>';
		    }
		    else {
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$type_cuti.'/'.$data['NIK']).'" data-subtext="'.$data['NIK'].'">'.$data['Nama'].'</option>';
		    }
	  	}
	  	$empty_select .='</optgroup>';
	  	} 

	  	$empty_select .= '</select>';
        $empty_select .= '</div>';
	  	$div_close     = '</div><br/>';

	  

  		return $div_open.$empty_select.$div_close.$java_script;

    }

    public function data_filter_company_and_form_ijin($company_id,$modules,$pages,$type,$nikki){

    	$div_open     = '<div class="row">';
		$empty_select ='<div class="col-sm-4">';
    	$empty_select .='<select data-live-search="false" style="width: 100%; display: none;" class="selectpicker form-control" data-container="body" onchange=goToPage("select") name="select" id="select">';
  		$empty_select .='<option value="" disabled SELECTED>Select Jenis Ijin</option>';
        //$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/0').'">---ALL---</option>';        

        $java_script = '<script type = "text/javascript">
						function goToPage(id) {
						  var node = document.getElementById(id);  
						  if( node &&
						    node.tagName == "SELECT" ) {
						    window.location.href = node.options[node.selectedIndex].value;    
						  }  
						}
						</script>';		

		$sql = mysql_query("SELECT * FROM tbl_jenisijin ORDER BY JenisIjinId ASC");            
	    while ($data = mysql_fetch_array($sql)){
		    if($type==$data['JenisIjinId']){
		    	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$data['JenisIjinId'].'/'.$nikki).'" SELECTED>'.$data['JenisIjinName'].'</option>';  
		    }
		    else {
		    	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$data['JenisIjinId'].'/'.$nikki).'">'.$data['JenisIjinName'].'</option>';
		    }
		}


	    

	  	$empty_select .= '</select>';
        $empty_select .= '</div>';		
		$empty_select .='<div class="col-sm-6">';
    	$empty_select .='<select data-live-search="true" class="selectpicker form-control" data-container="body" onchange=goToPage("select2") name="select2" id="select2">';
  		$empty_select .='<option value="" disabled SELECTED>Select Karyawan</option>';
        $empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$type.'/0').'">---ALL---</option>';      

        $tampil = mysql_query("SELECT * FROM tbl_div WHERE iDivCompany='".$company_id."' ORDER BY cDivName ASC");
  		while ($rows = mysql_fetch_array($tampil)){

  		$empty_select .='<optgroup label="'.$rows['cDivName'].' Division">';

	    $sql = mysql_query("SELECT * FROM tbl_profile WHERE DivisiID='".$rows['iDivId']."' ORDER BY Nama ASC");            
	    while ($data = mysql_fetch_array($sql)){
		    if($nikki==$data['NIK']){  
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$type.'/'.$data['NIK']).'" data-subtext="'.$data['NIK'].'" SELECTED>'.$data['Nama'].'</option>';
		    }
		    else {
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$type.'/'.$data['NIK']).'" data-subtext="'.$data['NIK'].'">'.$data['Nama'].'</option>';
		    }
	  	}
	  	$empty_select .='</optgroup>';
	  	} 

	  	$empty_select .= '</select>';
        $empty_select .= '</div>';
	  	$div_close     = '</div><br/>';

	  

  		return $div_open.$empty_select.$div_close.$java_script;

    }


    public function data_filter_periode($current_id,$modules,$pages){
    	
		$empty_select = '<div class="row">';
		$empty_select .='<div class="col-sm-4">';
    	$empty_select .='<select data-live-search="true" style="width: 100%; display: none;" class="selectpicker form-control" data-container="body" onchange=goToPage("select") name="select" id="select">';
  		$empty_select .='<option value="" disabled SELECTED>Select Periode</option>';
        //$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/0').'">---ALL---</option>';
        $empty_select_closed = '</select></div></div><br/>';

        $java_script = '<script type = "text/javascript">
						function goToPage(id) {
						  var node = document.getElementById(id);  
						  if( node &&
						    node.tagName == "SELECT" ) {
						    window.location.href = node.options[node.selectedIndex].value;    
						  }  
						}
						</script>';

	    $sql = mysql_query("SELECT * FROM tbl_periode ORDER BY iPeriodId ASC");            
	    while ($data = mysql_fetch_array($sql)){
		    if($current_id==$data['iPeriodId']){  
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$data['iPeriodId']).'" data-subtext="" SELECTED>'.$data['cPeriodName'].'</option>';
		    }
		    else {
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$data['iPeriodId']).'" data-subtext="">'.$data['cPeriodName'].'</option>';
		    }
	  	} 

  		return $empty_select.$empty_select_closed.$java_script;
    }


    public function data_filter_report($current_id,$modules,$pages){
    	
		$empty_select = '<div class="row">';
		$empty_select .='<div class="col-sm-4">';
    	$empty_select .='<select data-live-search="false" style="width: 100%; display: none;" class="selectpicker form-control" data-container="body" onchange=goToPage("select") name="select" id="select">';
  		$empty_select .='<option value="" disabled SELECTED>Select Report</option>';
        //$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/0').'">---ALL---</option>';
        
        

        $java_script = '<script type = "text/javascript">
						function goToPage(id) {
						  var node = document.getElementById(id);  
						  if( node &&
						    node.tagName == "SELECT" ) {
						    window.location.href = node.options[node.selectedIndex].value;    
						  }  
						}
						</script>';

		

	    $sql = mysql_query("SELECT * FROM tbl_reports ORDER BY ReportId ASC");            
	    while ($data = mysql_fetch_array($sql)){
		    if($current_id==$data['ReportId']){  
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$data['ReportId']).'" data-subtext="" SELECTED>'.$data['ReportName'].'</option>';
		    }
		    else {
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$data['ReportId']).'" data-subtext="">'.$data['ReportName'].'</option>';
		    }
	  	}
	  	$empty_select .='</select></div>';
	  	$empty_select .='<div class="col-sm-6">';
  		$empty_select .='<a href="#myModal" class="btn btn-primary" data-toggle="modal" '.$this->modal_status_btn($value=$current_id).'>Report Filters</a>';
        $empty_select .= '</div>';
        $empty_select_closed = '</div><br/>'; 

  		return $empty_select.$empty_select_closed.$java_script;
    }


    public function modal_status_btn($value){

    	if (!empty($value) && is_null($value)){
	    $query  = mysql_query('SELECT * FROM tbl_reports WHERE ReportId='.$value);
	    $total  = mysql_num_rows($query);
	    $data   = mysql_fetch_array($query);
	    
		    if ($total >0){
		        return '';
		    }
		    else {
		        return 'disabled';
		    }

		}
		else{
			return false;
		}
    

	}


	public function search_filter_with_dropdown($company_id,$modules,$pages,$periode,$nik,$current_year){
		
		$empty_select ='<div class="row">';
        $empty_select .='<div class="col-md-6">';
        $empty_select .='<div class="form-horizontal">';
        $empty_select .='<form method="get" action="?">';
        $empty_select .='<div class="input-group">';
        $empty_select .='<div class="ddl-select input-group-btn">';
        $empty_select .='<select id="periode" class="selectpicker form-control" data-container="body" data-style="btn-primary" name="periode">';
        $empty_select .='<option value="" data-hidden="true" class="ddl-title">Periode</option>';
        $empty_select .='<option value="0">---ALL Year '.$current_year.'---</option>"';

                  
        $sql = mysql_query("SELECT * FROM tbl_periode WHERE iPeriodId >0 AND bPeriodStatus=1 ORDER BY iPeriodId ASC");                     
            while ($data = mysql_fetch_array($sql)){
                if($periode==$data['iPeriodId']){
                    $empty_select .='<option value="'.$data['iPeriodId'].'" SELECTED>'.$data['cPeriodName'].'</option>';
                }
                else{
                    $empty_select .='<option value="'.$data['iPeriodId'].'">'.$data['cPeriodName'].'</option>';
                }
            }                   

                  
        $empty_select .='</select>';
        $empty_select .='</div>';
        $empty_select .='<select data-live-search="true" class="selectpicker form-control" data-container="body" name="nik" id="nik">';
  		$empty_select .='<option value="" disabled SELECTED>Select Karyawan</option>';

  		$tampil = mysql_query("SELECT * FROM tbl_div WHERE iDivCompany='".$company_id."' ORDER BY cDivName ASC");
  		while ($rows = mysql_fetch_array($tampil)){

  		$empty_select .='<optgroup label="'.$rows['cDivName'].' Division">';

	    $sql = mysql_query("SELECT * FROM tbl_profile WHERE DivisiID='".$rows['iDivId']."' ORDER BY Nama ASC");            
	    while ($data = mysql_fetch_array($sql)){
		    if($nik==$data['NIK']){  
		      	$empty_select .='<option value="'.$data['NIK'].'" data-subtext="'.$data['NIK'].'" SELECTED>'.$data['Nama'].'</option>';
		    }
		    else {
		      	$empty_select .='<option value="'.$data['NIK'].'" data-subtext="'.$data['NIK'].'">'.$data['Nama'].'</option>';
		    }
	  	}
	  	$empty_select .='</optgroup>';
	  	} 

	  	$empty_select .= '</select>';
        //$empty_select .='<input id="txtkey" class="form-control" placeholder="NIK or Name" aria-describedby="ddlsearch" type="text" name="nik" value="'.$namae.'">';
        $empty_select .='<span class="input-group-btn">';
        $empty_select .='<button id="btn-search" class="btn btn-info" type="submit"><i class="glyphicon glyphicon-search"></i></button>';
        $empty_select .='</span>';
        $empty_select .='</div>';
        $empty_select .='</form>'; 
        $empty_select .='</div>';
        $empty_select .='</div>';
    	$empty_select .='</div><br/>';


      	return $empty_select;
  

	}


	public function data_filter_user_department($modules,$pages,$department_id,$department_name,$nik,$session_nik){
		
		$empty_select ='<div class="row">';
        $empty_select .='<div class="col-sm-6">';        
        $empty_select .='<select data-live-search="true" class="selectpicker form-control" data-container="body" onchange=goToPage("select") name="select" id="select">';
  		$empty_select .='<option value="" disabled SELECTED>Select Karyawan</option>';

	    $sql = mysql_query("SELECT * FROM tbl_profile WHERE NIK !='".$session_nik."' AND DeptID ='".$department_id."' AND bStatus=1 ORDER BY Nama ASC");            
	    while ($data = mysql_fetch_array($sql)){
		    if($nik==$data['NIK']){  
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'?nik='.$data['NIK']).'" data-subtext="'.$data['NIK'].'" SELECTED>'.$data['Nama'].'</option>';
		    }
		    else {
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'?nik='.$data['NIK']).'" data-subtext="'.$data['NIK'].'">'.$data['Nama'].'</option>';
		    }
	  	} 

	  	$empty_select .= '</select>';            
        $empty_select .='</div>';
        $empty_select .='<div class="col-sm-3">';
        $empty_select .='<span class="label label-success">Department '.$department_name.'</span>';
        $empty_select .='</div>';
    	$empty_select .='</div>';

      	return $empty_select;
  

	}

	public function data_filter_user_division($modules,$pages,$division_id,$division_name,$nik,$session_nik){
		
		$empty_select ='<div class="row">';
        $empty_select .='<div class="col-sm-6">';        
        $empty_select .='<select data-live-search="true" class="selectpicker form-control" data-container="body" onchange=goToPage("select") name="select" id="select">';
  		$empty_select .='<option value="" disabled SELECTED>Select Karyawan</option>';

  		$tampil = mysql_query("SELECT * FROM tbl_dept WHERE iDeptDivID='".$division_id."' ORDER BY cDeptName ASC");
  		while ($rows = mysql_fetch_array($tampil)){
  		$empty_select .='<optgroup label="'.$rows['cDeptName'].' Department">';

	    $sql = mysql_query("SELECT * FROM tbl_profile WHERE NIK !='".$session_nik."' AND DeptID='".$rows['iDeptID']."' AND bStatus=1 ORDER BY Nama ASC");            
	    while ($data = mysql_fetch_array($sql)){
		    if($nik==$data['NIK']){  
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'?nik='.$data['NIK']).'" data-subtext="'.$data['NIK'].'" SELECTED>'.$data['Nama'].'</option>';
		    }
		    else {
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'?nik='.$data['NIK']).'" data-subtext="'.$data['NIK'].'">'.$data['Nama'].'</option>';
		    }
	  	}
	  	$empty_select .='</optgroup>';
	  	}  

	  	$empty_select .= '</select>';            
        $empty_select .='</div>';
        $empty_select .='<div class="col-sm-3">';
        $empty_select .='<span class="label label-success">Division '.$division_name.'</span>';
        $empty_select .='</div>';
    	$empty_select .='</div>';

      	return $empty_select;
  

	}

	public function data_filter_user_company($modules,$pages,$company_id,$company_name,$nik,$session_nik){
		
		$empty_select ='<div class="row">';
        $empty_select .='<div class="col-sm-6">';        
        $empty_select .='<select data-live-search="true" class="selectpicker form-control" data-container="body" onchange=goToPage("select") name="select" id="select">';
  		$empty_select .='<option value="" disabled SELECTED>Select Karyawan</option>';
        
        $tampil = mysql_query("SELECT * FROM tbl_div WHERE iDivCompany='".$company_id."' ORDER BY cDivName ASC");
  		while ($rows = mysql_fetch_array($tampil)){
  		$empty_select .='<optgroup label="'.$rows['cDivName'].' Division">';

	    $sql = mysql_query("SELECT * FROM tbl_profile WHERE NIK !='".$session_nik."' AND DivisiID='".$rows['iDivId']."' AND bStatus=1 ORDER BY Nama ASC");            
	    while ($data = mysql_fetch_array($sql)){
		    if($nik==$data['NIK']){  
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'?nik='.$data['NIK']).'" data-subtext="'.$data['NIK'].'" SELECTED>'.$data['Nama'].'</option>';
		    }
		    else {
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'?nik='.$data['NIK']).'" data-subtext="'.$data['NIK'].'">'.$data['Nama'].'</option>';
		    }
	  	}
	  	$empty_select .='</optgroup>';
	  	} 

	  	$empty_select .= '</select>';            
        $empty_select .='</div>';
        $empty_select .='<div class="col-sm-3">';
        $empty_select .='<span class="label label-success">Company '.$company_name.'</span>';
        $empty_select .='</div>';
    	$empty_select .='</div>';
      	return $empty_select;
  

	}


	public function data_filter_user_cross_company($current_id,$modules,$pages){		
		
		$empty_select ='<div class="row">';
        $empty_select .='<div class="col-sm-6">';        
        $empty_select .='<select data-live-search="true" class="selectpicker form-control" data-container="body" onchange=goToPage("select") name="select" id="select">';
  		$empty_select .='<option value="" disabled SELECTED>Select Karyawan</option>';
  		$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/0').'">---ALL---</option>';
        
        //$tampil = mysql_query("SELECT * FROM tbl_div WHERE iDivCompany='".$company_id."' ORDER BY cDivName ASC");
        $tampil = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");

  		while ($rows = mysql_fetch_array($tampil)){

  		$empty_select .='<optgroup label="'.$rows['cCompanyName'].'">';

	    $sql = mysql_query("SELECT * FROM tbl_profile WHERE CompanyId='".$rows['iCompanyId']."' AND bStatus=1 ORDER BY Nama ASC");            
	    while ($data = mysql_fetch_array($sql)){
		    if($current_id==$data['NIK']){  
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$data['NIK']).'" data-subtext="'.$data['NIK'].'" SELECTED>'.$data['Nama'].'</option>';
		    }
		    else {
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/'.$data['NIK']).'" data-subtext="'.$data['NIK'].'">'.$data['Nama'].'</option>';
		    }
	  	}
	  	$empty_select .='</optgroup>';
	  	} 

	  	$empty_select .= '</select>';            
        $empty_select .='</div>';
    	$empty_select .='</div>';
    	//$empty_select .='<br/>';
    	$empty_select .='<br/>';
      	return $empty_select;
  

	}

	public function data_filter_user_cross_company_admin($current_id,$modules,$pages,$form_admin,$session_nik){		
		
		$empty_select ='<div class="row">';
        $empty_select .='<div class="col-sm-4">';        
        $empty_select .='<select data-live-search="true" class="selectpicker form-control" data-container="body" onchange=goToPage("select") name="select" id="select">';
  		$empty_select .='<option value="" disabled SELECTED>Select Karyawan</option>';
  		$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/?nik=0').'">---ALL---</option>';
        
        //$tampil = mysql_query("SELECT * FROM tbl_div WHERE iDivCompany='".$company_id."' ORDER BY cDivName ASC");
        //$tampil = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");

  		//while ($rows = mysql_fetch_array($tampil)){

  		//$empty_select .='<optgroup label="'.$rows['cCompanyName'].'">';

	    $sql = mysql_query("SELECT * FROM tbl_group_admin INNER JOIN tbl_profile ON ".$form_admin."=DeptID WHERE admin_group_nik='".$session_nik."' AND bStatus=1 AND DeptID IS NOT NULL ORDER BY Nama ASC");            
	    while ($data = mysql_fetch_array($sql)){
		    if($current_id==$data['NIK']){  
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/?nik='.$data['NIK']).'" data-subtext="'.$data['NIK'].'" SELECTED>'.$data['Nama'].'</option>';
		    }
		    else {
		      	$empty_select .='<option value="'.site_url($modules.'/'.$pages.'/index/?nik='.$data['NIK']).'" data-subtext="'.$data['NIK'].'">'.$data['Nama'].'</option>';
		    }
	  	}
	  	//$empty_select .='</optgroup>';
	  	//} 

	  	$empty_select .= '</select>';            
        $empty_select .='</div>';

        //$empty_select .='<div class="col-sm-4">';
        //$empty_select .='<input type="text" value="" placeholder="type what you want search..." name="" id="search" class="form-control">';
        //$empty_select .='</div>';

/*
        $empty_select .='<form class="form-horizontal" role="form">';
        $empty_select .='<div class="input-group col-sm-4">';
        $empty_select .= '<input type="text" id="key_words" name="key_words" class="form-control" placeholder="type what you want search..." />';
        $empty_select .= '<span class="input-group-btn">';
        $empty_select .= '<button class="btn btn-primary" type="submit">';
        $empty_select .= '<i class="glyphicon glyphicon-search"></i>';
        $empty_select .= '</button>';
        $empty_select .= '</span>';
        $empty_select .= '</div>';
        $empty_select .= '</form>';
       */
        //$empty_select .='<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>';
        //$empty_select .='</div>';



    	$empty_select .='</div>';
    	//$empty_select .='<br/>';
    	$empty_select .='<br/>';
      	return $empty_select;
  

	}

	public function data_filter_user_cross_company_nik_pengganti($session_nik){

		$style ='<style>
			.bolden{font-weight: bold;}
		</style>';			
		
		$empty_select ='<div class="row">';
        $empty_select .='<div class="col-md-8">';        
        $empty_select .='<select data-live-search="true" class="selectpicker form-control" data-container="body" name="NIKPengganti" id="NIKPengganti">';
  		$empty_select .='<option value="" disabled SELECTED>Select Karyawan</option>';
  		
        
        //$tampil = mysql_query("SELECT * FROM tbl_div WHERE iDivCompany='".$company_id."' ORDER BY cDivName ASC");
        $tampil = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");

  		while ($rows = mysql_fetch_array($tampil)){

  		$empty_select .='<optgroup label="'.$rows['cCompanyName'].'">';

	    	$sql = mysql_query("SELECT * FROM tbl_div WHERE iDivCompany='".$rows['iCompanyId']."' ORDER BY cDivName ASC");            
		    while ($data = mysql_fetch_array($sql)){
			   
			      	//$empty_select .='<optgroup label="'.$data['cDivName'].'">';
			      	$empty_select .='<option value="" disabled class="bolden">'.$data['cDivName'].' Division ('.$rows['cCompanyCode'].')</option>';

			      		$sql2 = mysql_query("SELECT * FROM tbl_profile WHERE DivisiID='".$data['iDivId']."' AND bStatus=1 AND NIK != '".$session_nik."' ORDER BY Nama ASC");         
		    			while ($data2 = mysql_fetch_array($sql2)){

		    				$empty_select .='<option value="'.$data2['NIK'].'" data-subtext="'.$data2['NIK'].' ['.$data2['Email'].']">&#160;&#160;&#160;'.$data2['Nama'].'</option>';

		    			}

			      	//$empty_select .='</optgroup>';
			   
		  	}

	  	$empty_select .='</optgroup>';

	  	} 

	  	$empty_select .= '</select>';            
        $empty_select .='</div>';
    	$empty_select .='</div>';
    	//$empty_select .='<br/>';
    	//$empty_select .='<br/>';
      	return $empty_select.$style;
  

	}












}

?>