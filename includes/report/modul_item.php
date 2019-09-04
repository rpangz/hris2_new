<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
  $company_id = $_GET['company'];
?>

<link href="{{ base_url }}themes/{{ used_theme }}assets/default/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="{{ base_url }}assets/ajax/jquery.min.js"></script>


<script type="text/javascript">
$(document).ready(function() {
	$('#wait_1').hide();
	$('#drop_1').change(function(){
	  $('#wait_1').show();
	  $('#result_1').hide();

    var host = window.location.hostname;
    var company = "<?php echo $company_id; ?>";
      $.get("https://"+host+"/hris2/includes/report/func.php?company="+company, {
		func: "drop_1",
		drop_var: $('#drop_1').val()
      }, function(response){
        $('#result_1').fadeOut();
        setTimeout("finishAjax('result_1', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

function finishAjax(id, response) {
  $('#wait_1').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_three(id, response) {
  $('#wait_2').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
</script>

<?PHP
include "../../includes/koneksi/koneksi.php";
include "../../includes/report/func.php";
 
echo "<tr>
      
        <td><label for='drop_1'>Company :</label>
  	   <select class='form-control' name='pt' id='drop_1'>
  	    <option value='0' selected='selected' disabled='disabled'>---Pilih Company---</option>";
        
        getTierOne();
      
        echo"</select>
      
        <span id='wait_1' style='display: none;'>
        <img alt='Please Wait' src='{{ base_url }}includes/report/ajax-loader.gif'/>
        </span>
        <span id='result_1' style='display: none;'></span>
        <span id='wait_2' style='display: none;'>
        <img alt='Please Wait' src='{{ base_url }}includes/report/ajax-loader.gif'/>
        </span>
        <span id='result_2' style='display: none;'></span>      
        </td>
      </tr>";

 

?>

