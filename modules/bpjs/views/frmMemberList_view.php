<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



include "includes/koneksi/koneksi.php";

//$_SERVER['SERVER_NAME'];

if(($this->uri->segment('5') !='edit') && ($this->uri->segment('5') !='add')) {

echo"<table style='font-size:12px'>
    <tr>
        <td><select class='form-control' id=select onchange=goToPage('select')>";
	echo "<option value='0' disabled SELECTED>Select Company</option>";
    $sql = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");					  
		 while ($data = mysql_fetch_array($sql)){

	if($this->uri->segment('4')==$data['iCompanyId']){
	echo "<option value='https://".$_SERVER['SERVER_NAME']."/hris2/bpjs/frmMemberList/index/$data[iCompanyId]' SELECTED>$data[cCompanyName]</option>";  
      
    }
      else {
      echo "<option value='https://".$_SERVER['SERVER_NAME']."/hris2/bpjs/frmMemberList/index/$data[iCompanyId]'>$data[cCompanyName]</option>";
    }
      }  
      
}
		
	echo"</select></table></br>";



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

