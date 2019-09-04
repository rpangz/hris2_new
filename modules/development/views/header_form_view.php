<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$asset = new CMS_Asset();
foreach($css_files as $file){
    $asset->add_css($file);
}
echo $asset->compile_css();

foreach($js_files as $file){
    $asset->add_js($file);
}
echo $asset->compile_js();

// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}
echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);
?>
<script type="text/javascript">

	$(document).ready(function(){
		$('#field-iOrgItem').prop('disabled', true).trigger("liszt:updated");
		$('#field-iTypeForm').change();
	});
	$('#field-iTypeForm').on('change', function(){
		$('#field-iOrgItem').prop('disabled', true);
		if($('#field-iTypeForm').val() == 2){
			$('#field-iOrgItem').val(1);
			$('#field-iOrgItem').trigger("liszt:updated");
		}
		
		if($('#field-iTypeForm').val() == 1){
			$('#field-iOrgItem').val(2);
			$('#field-iOrgItem').trigger("liszt:updated");
		}
		
	});
	
	$('#save-and-go-back-button').on('click', function(){
		$('#field-iOrgItem').prop('disabled', false);
	});
	
	// $(document).ajaxComplete(function(){
		// $('#field-iOrgItem').prop('disabled', true).trigger("liszt:updated");
	// });
</script>
<style>

.container {
  width: 100%;
}


</style>