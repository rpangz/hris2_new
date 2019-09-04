<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//$_SERVER['SERVER_NAME'];

if(($this->uri->segment('4') !='edit') && ($this->uri->segment('5') !='add') && ($this->uri->segment('4') !='add')){

?>
<div class="row">
  <div class="col-lg-4">
  <?php

    echo "<form type='get'><select class='form-control' id=select onchange=goToPage('select')>";
    echo "<option value='' disabled SELECTED>Select Company</option>";
    //echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/bpjs/frmMemberBPJSKetenagakerjaan/index/0' >ALL Company</option>";
    $sql = mysql_query("SELECT * FROM tbl_company WHERE iCompanyId ='1' ORDER BY iCompanyId ASC");           
     while ($data = mysql_fetch_array($sql)){

  if($this->uri->segment('4')==$data['iCompanyId']){
     echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/bpjs/frmMemberBPJSKetenagakerjaan/index/$data[iCompanyId]' SELECTED>$data[cCompanyName]</option>";  
      
    }
      else {
      echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/bpjs/frmMemberBPJSKetenagakerjaan/index/$data[iCompanyId]'>$data[cCompanyName]</option>";
    }
      }  
      
}
    
  echo"</select>"; ?>

  </div>
  <!--<div class="col-lg-2">
    <input checked='true' type='checkbox' name="ck1" value='1'/><label>Aktif</label>
  </div>
  <div class="col-lg-2">
    <input checked='true' type='checkbox' name="ck2" value='0'/><label>Tidak Aktif</label>
  </div>-->
</div>
</form>
</br>
<?php




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

<style type="text/css">
    .box{
        padding: 20px;
        display: none;
        margin-top: 20px;
        border: 1px solid #000;
    }
    
    .autoUpdate{ 
      background: #FFFFCC;
      padding: 20px;
      margin-top: 20px;
        border: 1px solid #000;
        color:#FF0000;
        width: 100%;
      
         }

    label {
        display: block;
        padding-left: 15px;
        text-indent: -15px;
    }
    
    
</style>

<script type="text/javascript">
  $(document).ready(function () {
    $('#checkbox1').change(function () {
        if (!this.checked) 
        //  ^
           $('#autoUpdate').fadeIn('slow');
        else 
            $('#autoUpdate').fadeOut('slow');
          
    });
});
</script>