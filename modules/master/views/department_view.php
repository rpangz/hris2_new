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

if($state !='edit' AND $state !='add'){

echo"<table>
  <tr>
    <td><select class='form-control' id=select onchange=goToPage('select')>
    <option value='' disabled SELECTED>Select Company</option>

    <option value='http://$_SERVER[SERVER_NAME]/hris2/master/department/index/0'>---ALL---</option>";
    $sql = mysql_query("SELECT * FROM tbl_company WHERE bStatus=1 ORDER BY cCompanyName ASC");                     
    while ($data = mysql_fetch_array($sql)){

    if($this->uri->segment('4')==$data['iCompanyId']){  
      echo "<option value='http://$_SERVER[SERVER_NAME]/hris2/master/department/index/$data[iCompanyId]' SELECTED>$data[cCompanyName]</option>";
    }
    else {
      echo "<option value='http://$_SERVER[SERVER_NAME]/hris2/master/department/index/$data[iCompanyId]'>$data[cCompanyName]</option>";
    }

    }  
         
echo"</select>
    </table>&nbsp;&nbsp;";

}

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

<script type = "text/javascript">
function goToPage( id ) {
  var node = document.getElementById( id );  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>