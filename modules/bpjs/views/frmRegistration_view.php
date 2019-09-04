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




if ($this->uri->segment(4) =='add'){
echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);

}

elseif ($this->uri->segment(4) !='add'){

echo "<form><input type='button' class='btn btn-large' value='  Registration  ' onClick=window.location.href='https://".$_SERVER['SERVER_NAME']."/hris2/bpjs/frmRegistration/index/add'></form>";

}

?>

<script type="text/javascript">
    $(document).ready(function()
        {
    var changeYear = $( ".datepicker-input" ).datepicker( "option", "changeYear" );
    $( ".datepicker-input" ).datepicker( "option", "yearRange", "-70:+70" );
        });
</script>

<?php
if(isset($dropdown_setup)) {
  $this->load->view('dependent_dropdown', $dropdown_setup);
}
?>

<?php
if(isset($dropdown_setup2)) {
  $this->load->view('dependent_dropdown2', $dropdown_setup2);
}
?>

<?php
if(isset($dropdown_setup3)) {
  $this->load->view('dependent_dropdown3', $dropdown_setup3);
}
?>



