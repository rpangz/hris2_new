<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$modules = $this->uri->segment('1');
$pages   = $this->uri->segment('2');
$this->config->load('cms_config');       
$company_id = $this->config->item('cms_mediatek_id');

if (is_null($this->uri->segment('5'))){
  $NIKKI  = 0;
}else{
  $NIKKI  = $this->uri->segment('5');
}

if (is_null($this->uri->segment('4'))){
  $JenisIjin = 0;
}else {
  $JenisIjin = $this->uri->segment('4');

}


//if($this->uri->segment('5') =='' && ($this->uri->segment('4') !='add')){
if($this->uri->segment('4') !='edit' && $this->uri->segment('5') !='edit' && $this->uri->segment('5') !='add' && $this->uri->segment('6') !='add'){
  ?>

  

<?php
echo"<table>
  <tr>
    <td><select class='form-control' id=select onchange=goToPage('select')>";
	echo "<option value='' disabled SELECTED>Select Jenis Ijin</option>";
    $sql = mysql_query("SELECT * FROM tbl_jenisijin ORDER BY JenisIjinId ASC");					  
		 while ($data = mysql_fetch_array($sql)){

    if($this->uri->segment('4')==$data['JenisIjinId']){  
      echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/".$modules."/".$this->uri->segment('2')."/index/".$data['JenisIjinId']."/".$NIKKI."' SELECTED>$data[JenisIjinName]</option>";
    }

      else {
      echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/".$modules."/".$this->uri->segment('2')."/index/".$data['JenisIjinId']."/".$NIKKI."'>$data[JenisIjinName]</option>";
    }


      }  

echo"</select></td>
<td>&nbsp</td>
  
    <td><select class='form-control' id=select2 onchange=goToPage1('select2')>";
    echo "<option value='' disabled SELECTED>Select Karyawan</option>";
    echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/".$modules."/".$this->uri->segment('2')."/index/".$JenisIjin."/0' >---ALL---</option>";
    $sql = mysql_query("SELECT * FROM tbl_profile WHERE CompanyId ='$company_id' ORDER BY Nama ASC");           
     while ($data = mysql_fetch_array($sql)){

     if($this->uri->segment('5')==$data['NIK']){  
      echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/".$modules."/".$this->uri->segment('2')."/index/".$JenisIjin."/".$data['NIK']."' SELECTED>$data[Nama]</option>";
    }
      else {
      echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/".$modules."/".$this->uri->segment('2')."/".$JenisIjin."/".$data['NIK']."'>$data[Nama]</option>";
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
    $url    = 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/export/frmListFormIjin/Export2Html.php?id='.$ID;
    //$url    = '#';
    $target = 'target=_blank';
    //$target = '';

  }else{

    $url    = '#';
    $target = '';
  }

  //echo "<a href='$url' $target>
    //<img style=border:0; src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/excel1.png' onmouseover=this.src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/excel2.png' onmouseout=this.src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/excel1.png' title='Export to Excel' alt='Export to Excel' width=30 height=30></a>";
  echo"<a href='$url' $target><img style=border:0; src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/printer1.png' onmouseover=this.src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/printer2.png' onmouseout=this.src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/printer1.png' title='Print' width=30 height=30></a>&nbsp;&nbsp;&nbsp;&nbsp;";
  
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
