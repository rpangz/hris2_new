<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$this->load->model('data_filter_model');
$modules = $this->uri->segment('1');
$pages   = $this->uri->segment('2');

if (isset($_GET['nik']) && (!is_null($_GET['nik']) || !empty($_GET['nik']))){
    $nik = $_GET['nik'];
}
else{
    $nik = '';
}


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
//echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);

echo $this->data_filter_model->data_filter_user_division($modules,$pages,$division_id,$division_name,$nik,$session_nik);

include "./includes/frmSejarahCutiUserBawahan.php";

?>
<script type = "text/javascript">
function goToPage( id ) {
  var node = document.getElementById(id);  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>