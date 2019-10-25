<?php
if(isset($dd_state3) && ($dd_state3 == 'add' || $dd_state3 == 'edit')) {
//DONT HAVE TO EDIT THE CODE BELOW IF YOU DONT WANNA :P
echo '<script type="text/javascript">';
echo '$(document).ready(function() {';
for($i = 0; $i <= sizeof($dd_dropdowns3)-1; $i++):
	//SET VARIABLES
	echo 'var '.$dd_dropdowns3[$i].' = $(\'select[name="'.$dd_dropdowns3[$i].'"]\');';
	//SET LOADING IMAGES
	if($i != sizeof($dd_dropdowns3)-1) {
		echo '$(\'#'.$dd_dropdowns3[$i].'_input_box\').append(\'<img src="'.$dd_ajax_loader3.'" border="0" id="'.$dd_dropdowns3[$i].'_ajax_loader" class="dd_ajax_loader3" style="display: none;">\');';
	}
	
	if($i > 0 && $dd_state3 == 'add') {
		//HIDE ALL CHILD ITEMS
		echo '$(\'#'.$dd_dropdowns3[$i].'_input_box\').hide();';
		//REMOVE CHILD OPTIONS
		echo $dd_dropdowns3[$i].'.children().remove().end();';
	}
endfor;

for($i = 1; $i <= sizeof($dd_dropdowns3)-1; $i++):
	//CHILD DROPDOWNS
	echo $dd_dropdowns3[$i-1].'.change(function() {';
	echo 'var select_value = this.value;';
	//SHOW LOADING IMAGE
	echo '$(\'#'.$dd_dropdowns3[$i-1].'_ajax_loader\').show();';
	//REMOVE ALL CURRENT OPTIONS FROM CHILD DROPDOWNS
	echo $dd_dropdowns3[$i].'.find(\'option\').remove();';
	//POST TO A CUSTOM CONTROLLER ADDING OPTIONS | JSON
	echo 'var myOptions = "";';
	//GET JSON REQUEST OF STATES
	echo '$.getJSON(\''.$dd_url3[$i].'\'+select_value, function(data) {';
	//APPEND RECEIVED DATA TO STATES DROP DOWN LIST
	echo $dd_dropdowns3[$i].'.append(\'<option value=""></option>\');';
	echo '$.each(data, function(key, val) {';
	echo $dd_dropdowns3[$i].'.append(';
	echo '$(\'<option></option>\').val(val.value).html(val.property)';
	echo ');';
	echo '});';
	//SHOW CHILD SELECTION FIELD
	echo '$(\'#'.$dd_dropdowns3[$i].'_input_box\').show();';
	//MAKE SURE CITY STILL HIDDEN INCASE OF COUNTRY CHANGE
	for($x = $i+1; $x <= sizeof($dd_dropdowns3)-1; $x++):
		echo '$(\'#'.$dd_dropdowns3[$x].'_input_box\').hide();';
	endfor;
	//RESET JQUERY STYLE OF DROPDOWN LIST WITH NEW DATA
	echo $dd_dropdowns3[$i-1].'.each(function(){';
	echo '$(this).trigger("liszt:updated");';
	echo '});';
	echo $dd_dropdowns3[$i].'.each(function(){';
	echo '$(this).trigger("liszt:updated");';
	echo '});';
	//HIDE LOADING IMAGE
	echo '$(\'#'.$dd_dropdowns3[$i-1].'_ajax_loader\').hide();';
	echo '});';
	echo '});';
endfor;
echo '});';
echo '</script>';
}
?>