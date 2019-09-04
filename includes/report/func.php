<link href="{{ base_url }}themes/cerulean/assets/default/bootstrap.min.css" rel="stylesheet">

<?php
define('BASE_URL', 'https://'.$_SERVER['SERVER_NAME']);

include '../koneksi/koneksi.php';

//require ('{{ base_url }}/includes/koneksi/koneksi.php');

//**************************************
//     Page load dropdown results     //
//**************************************
function getTierOne(){
	$result = mysql_query("SELECT * FROM tbl_company WHERE iCompanyId=$_GET[company]");
	  while($tier = mysql_fetch_array($result)){
		   echo '<option value="'.$tier['iCompanyId'].'">'.$tier['cCompanyName'].'</option>';
		}

}

//**************************************
//     First selection results     //
//**************************************
if(!empty($_GET['func']) && $_GET['func'] == "drop_1" && isset($_GET['func'])) { 
   drop_1($_GET['drop_var']); 
}

function drop_1($drop_var){  
    include "../koneksi/koneksi.php";
	$result = mysql_query("SELECT * FROM tbl_div WHERE iDivCompany='$drop_var'");
	
	echo '<tr>
          <td><label for="drop_2">Division :</label>
          <select class="form-control" name="div" id="drop_2">
         <option value="" selected="selected" DISABLED>Select Division</option>
	      <option value="0">---All Division---</option>';
		   while($drop_2 = mysql_fetch_array( $result )){
			  echo '<option value="'.$drop_2['iDivId'].'">'.$drop_2['cDivName'].'</option>';
			}
	
	echo '</select>
		  </td></tr>';
	echo "<script type=\"text/javascript\">
$('#wait_2').hide();
	$('#drop_2').change(function(){
	  $('#wait_2').show();
	  $('#result_2').hide();
      $.get(\"https://$_SERVER[SERVER_NAME]/hris2/includes/report/func.php\", {
		func: \"drop_2\",
		drop_var: $('#drop_2').val()
      }, function(response){
        $('#result_2').fadeOut();
        setTimeout(\"finishAjax_tier_three('result_2', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}

//**************************************
//     Second selection results     //
//**************************************
if(!empty($_GET['func']) && $_GET['func'] == "drop_2" && isset($_GET['func'])) { 
   drop_2($_GET['drop_var']); 
}

function drop_2($drop_var){  
    include "../koneksi/koneksi.php";
	$result = mysql_query("SELECT * FROM tbl_dept WHERE iDeptDivID='$drop_var'");
	
	echo '<tr>
          <td><label for="drop_3">Departement :</label>
          <select class="form-control" name="dept" id="drop_3">
        <option value=""  selected="selected" disabled>Select Departement</option>
	      <option value="0">---All Departement---</option>';

		   while($drop_3 = mysql_fetch_array( $result )){
			  echo '<option value="'.$drop_3['iDeptID'].'">'.$drop_3['cDeptName'].'</option>';
			}
	
	echo '</select></td></tr>';
    
}
?>