<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$profile = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$_SESSION['NIK']));

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
?>




<?php


echo"<table>
  <tr>
    <td><select class='form-control' id=select onchange=goToPage('select')>";
  echo "<option value='' disabled SELECTED>Select Jenis Cuti</option>";
    $sql = mysql_query("SELECT * FROM tbl_jeniscuti");            
    while ($data = mysql_fetch_array($sql)){
    if($this->uri->segment('4')==$data['id']){  
      echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/".$this->uri->segment('1')."/".$this->uri->segment('2')."/index/".$data['id']."/".$NIKKI."' SELECTED>$data[JenisCutiName]</option>";
    }
    else {
      echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/".$this->uri->segment('1')."/".$this->uri->segment('2')."/index/".$data['id']."/".$NIKKI."'>$data[JenisCutiName]</option>";
    }


  } 
echo"</select></td>
<td>&nbsp</td>
  
    <td><select class='form-control' id=select2 onchange=goToPage1('select2')>";
    echo "<option value='' disabled SELECTED>Select Karyawan</option>";
    echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/".$this->uri->segment('1')."/".$this->uri->segment('2')."/index/".$JenisCuti."/0' >---ALL---</option>";
    $sql = mysql_query("SELECT * FROM tbl_profile WHERE bStatus =1 ORDER BY Nama ASC");           
    
    while ($data = mysql_fetch_array($sql)){

    if($this->uri->segment('5')==$data['NIK']){  
      echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/".$this->uri->segment('1')."/".$this->uri->segment('2')."/index/".$JenisCuti."/".$data['NIK']."' SELECTED>$data[Nama]</option>";
    }
      else {
      echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/".$this->uri->segment('1')."/".$this->uri->segment('2')."/index/".$JenisCuti."/".$data['NIK']."'>$data[Nama]</option>";
    }
      }
     
  echo"</select></td>
  </tr></table></br>";
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




