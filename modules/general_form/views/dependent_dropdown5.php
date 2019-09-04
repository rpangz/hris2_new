<?php
if(isset($dd_state5) && ($dd_state5 == 'add' || $dd_state5 == 'edit')){
//DONT HAVE TO EDIT THE CODE BELOW IF YOU DONT WANNA :P
echo '<script type="text/javascript">';
echo '$(document).ready(function() {';
for($i = 0; $i <= sizeof($dd_dropdowns5)-1; $i++):
	//SET VARIABLES
	echo 'var '.$dd_dropdowns5[$i].' = $(\'select[name="'.$dd_dropdowns5[$i].'"]\');';
	//SET LOADING IMAGES
	if($i != sizeof($dd_dropdowns5)-1) {
		//echo '$(\'#'.$dd_dropdowns5[$i].'_input_box\').append(\'<img src="'.$dd_ajax_loader5.'" border="0" id="'.$dd_dropdowns5[$i].'_ajax_loader" class="dd_ajax_loader" style="display: none;">\');';
	}	
	if($i > 0 && $dd_state5 == 'add') {
		//HIDE ALL CHILD ITEMS
		echo '$(\'#'.$dd_dropdowns5[$i].'_input_box\').hide();';
		//REMOVE CHILD OPTIONS
		echo $dd_dropdowns5[$i].'.children().remove().end();';
	}
endfor;

for($i = 1; $i <= sizeof($dd_dropdowns5)-1; $i++):
	//CHILD DROPDOWNS
	echo $dd_dropdowns5[$i-1].'.change(function() {';
	echo 'var select_value = this.value;';
	//SHOW LOADING IMAGE
	//echo '$(\'#'.$dd_dropdowns[$i-1].'_ajax_loader\').show();';
	//REMOVE ALL CURRENT OPTIONS FROM CHILD DROPDOWNS
	echo $dd_dropdowns5[$i].'.find(\'option\').remove();';
	//POST TO A CUSTOM CONTROLLER ADDING OPTIONS | JSON
	echo 'var myOptions = "";';
	//GET JSON REQUEST OF STATES
	echo '$.getJSON(\''.$dd_url5[$i].'\'+select_value, function(data) {';
	//APPEND RECEIVED DATA TO STATES DROP DOWN LIST
	echo $dd_dropdowns5[$i].'.append(\'<option value="">Select Department</option>\');';
	echo '$.each(data, function(key, val) {';
	echo $dd_dropdowns5[$i].'.append(';
	echo '$(\'<option></option>\').val(val.value).html(val.property)';
	echo ');';
	echo '});';
	//SHOW CHILD SELECTION FIELD
	echo '$(\'#'.$dd_dropdowns5[$i].'_input_box\').show();';
	//MAKE SURE CITY STILL HIDDEN INCASE OF COUNTRY CHANGE
	for($x = $i+1; $x <= sizeof($dd_dropdowns5)-1; $x++):
		echo '$(\'#'.$dd_dropdowns5[$x].'_input_box\').hide();';
	endfor;

	echo '$("#DepartmentID").selectpicker("refresh");';
	//RESET JQUERY STYLE OF DROPDOWN LIST WITH NEW DATA
	echo $dd_dropdowns5[$i-1].'.each(function(){';
	echo '$(this).trigger("liszt:updated");';
	echo '});';
	echo $dd_dropdowns5[$i].'.each(function(){';
	echo '$(this).trigger("liszt:updated");';
	echo '});';
	//HIDE LOADING IMAGE
	echo '$(\'#'.$dd_dropdowns5[$i-1].'_ajax_loader\').hide();';
	echo '});';
	echo '});';
endfor;
echo '});';
echo '</script>';
}
?>