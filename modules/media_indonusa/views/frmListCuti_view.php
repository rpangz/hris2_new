<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->model('data_filter_model');

$profile = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$_SESSION['NIK']));

$this->config->load('cms_config');       
$company_id = $this->config->item('cms_mediaindonusa_id');
$modules = $this->uri->segment('1');
$pages   = $this->uri->segment('2');

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
    $url    = 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/export/frmListCuti/Export2Html2.php?id='.$ID;
    //$url    = '#';
    $target = 'target=_blank';
    //$target = '';

  }else{

    $url    = '#';
    $target = '';
  }

  //echo "<a href='$url' $target>
    //<img style=border:0; src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/excel1.png' onmouseover=this.src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/excel2.png' onmouseout=this.src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/excel1.png' title='Export to Excel' alt='Export to Excel' width=30 height=30></a>";
 // echo"<a href='$url' $target><img style=border:0; src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/printer1.png' onmouseover=this.src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/printer2.png' onmouseout=this.src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/printer1.png' title='Print' width=30 height=30></a>&nbsp;&nbsp;&nbsp;&nbsp;";
  
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
function goToPage( id ) {
  var node = document.getElementById(id);  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>

<script type = "text/javascript">
function goToPage2( id ) {
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


<script>
  /**
   * Opens window screen centered.
   * @param windowWidth the window width in pixels (integer)
   * @param windowHeight the window height in pixels (integer)
   * @param windowOuterHeight the window outer height in pixels (integer)
   * @param url the url to open
   * @param wname the name of the window
   * @param features the features except width and height (status, toolbar, location, menubar, directories, resizable, scrollbars)
   */
  function CenterWindow(windowWidth, windowHeight, windowOuterHeight, url, wname, features) {
    var centerLeft = parseInt((window.screen.availWidth - windowWidth) / 2);
    var centerTop = parseInt(((window.screen.availHeight - windowHeight) / 2) - windowOuterHeight);
 
    var misc_features;
    if (features) {
      misc_features = ', ' + features;
    }
    else {
      misc_features = ', status=no, location=no, scrollbars=yes, resizable=yes';
    }
    var windowFeatures = 'width=' + windowWidth + ',height=' + windowHeight + ',left=' + centerLeft + ',top=' + centerTop + misc_features;
    var win = window.open(url, wname, windowFeatures);
    win.focus();
    return win;
  }
</script>



