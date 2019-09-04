<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$this->load->model('data_filter_model');

$profile = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$_SESSION['NIK']));
$modules = $this->uri->segment('1');
$pages   = $this->uri->segment('2');
$this->config->load('cms_config');       
$company_id = $this->config->item('cms_sisindokom_id');

if (is_null($this->uri->segment('5'))){
 $NIKKI  = 0;
}else{
 $NIKKI  = $this->uri->segment('5');
}

if (is_null($this->uri->segment('4'))){
  $JenisCuti = 0;
}else {
  $JenisCuti = $this->uri->segment('4');

}


if($this->uri->segment('5') !='edit' && $this->uri->segment('5') !='add' && $this->uri->segment('6') !='add' && $this->uri->segment('4') !='read' && $this->uri->segment('5') !='read' && $this->uri->segment('6') !='read'){

echo $this->data_filter_model->data_filter_company_and_form_cuti($company_id,$modules,$pages,$type_cuti=$JenisCuti,$nikki=$NIKKI);

}


elseif($this->uri->segment('5') == 'read'){
  $ID  = $this->uri->segment('6');

  $ska = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId=".$ID));
  if($ska['StatusForm']=='A'){
    //$url    = 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/export/frmListCuti/Export2Excel.php?id=$ID';
    $url    = 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/export/frmListCutiUtang/Export2Html2.php?id='.$ID;
    //$url    = '#';
    $target = 'target=_blank';
    //$target = '';

  }else{

    $url    = '#';
    $target = '';
  }

  
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

<script type = "text/javascript">
function goToPage(id) {
  var node = document.getElementById(id);  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>

<script type = "text/javascript">
function goToPage2(id) {
  var node = document.getElementById( id );  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>


<script type = "text/javascript">
function goToPage1(id) {
  var node = document.getElementById(id);  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>





<style type="text/css">
.chzn-container, .chzn-drop, .chzn-drop .chzn-search, .chzn-drop {
  width: 498px !important;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;

}
.chzn-search input {
    width: 478px !important;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
}
.chzn-container { width:500px !important; }


  .dropdown_box1{
    width:370px;
    height:30px;
    margin-top:5px;
    margin-left:0px;
    font-size: 12px;
    font-family: arial;
  }

  .dropdown_box2{
    width:370px;
    height:30px;
    margin-top:5px;
    margin-left:10px;
    font-size: 12px;
    font-family: arial;
  }

</style>