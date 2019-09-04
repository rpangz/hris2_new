<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(($this->uri->segment('4') !='edit') && ($this->uri->segment('5') !='add')) {

  $this->load->model('data_filter_model');
  $modules    = $this->uri->segment('1');
  $pages      = $this->uri->segment('2');
  $current_id = $this->uri->segment('4');

  echo $this->data_filter_model->data_filter_periode($current_id,$modules,$pages);
      
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
echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);

?>



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

<script type = "text/javascript">
function goToPage( id ) {
  var node = document.getElementById( id );  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>

