<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//include "includes/koneksi/koneksi.php";
$this->config->load('cms_config');       
$company_id = $this->config->item('cms_sisindokom_id');

if (!is_null($this->input->get('pt')) && !is_null($this->input->get('div')) && !is_null($this->input->get('dept')) && !is_null($this->input->get('jc'))){
$link2excel = 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/report/gen_rptSisaCuti.php?company='.$company_id.'&pt='.$this->input->get('pt').'&div='.$this->input->get('div').'&dept='.$this->input->get('dept').'&jc='.$this->input->get('jc');
        $link2pdf   = '#';
        }else{
        $link2excel = '';
        $link2pdf   = '';
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


<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['SERVER_NAME']?>/hris2/includes/css/tcal.css" />
  <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/hris2/includes/js/tcal.js"></script>
<div id="tfheader">

      
<form name="form2" action="" method="GET">
<table class="table2" width="100%" border="0" cellspacing="0" cellpadding="5">
 
 <tr>
    <td scope="col">&nbsp;&nbsp;<?php include "http://".$_SERVER['SERVER_NAME']."/hris2/includes/report/modul_pilih.php?company=$company_id"; ?></td>
    <td scope="col"><select id="JenisCuti" name="jc" class="dropdown_box1">
  <option value='0' disabled SELECTED>---Jenis Cuti---</option>
    <?php 
    $sql = mysql_query("SELECT * FROM tbl_jeniscuti WHERE id=1 || id=2 ORDER BY id ASC");            
      while ($dt = mysql_fetch_array($sql)){
      echo "<option value='$dt[id]'>$dt[JenisCutiName]</option>";
      };
    ?>  
  </select>
</td>
  </tr>
  
  <tr>
    <td colspan="2" scope="row"><div align="right">
      <input type="submit" class="btn btn-default" name="submit" value="Generate">   
      &nbsp;&nbsp;

    <!--<a href="<?php echo $link2excel ?>">
    <img style=border:0; src='../includes/images/excel1.png' onmouseover=this.src='../includes/images/excel2.png' onmouseout=this.src='../includes/images/excel1.png' title='Export to Excel' alt='Export to Excel' width="25" height="25"></a>&nbsp;
    </div>-->
  </td>
  </tr>


  

 
</table>
</form>



<br/>

<div class="tfclear"></div>
  </div>

<br/>
<?php
if (!is_null($this->input->get('pt')) && !is_null($this->input->get('div')) && !is_null($this->input->get('dept')) && !is_null($this->input->get('jc'))){

  include 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/report/rpt_SisaCuti.php?company='.$company_id.'&pt='.$this->input->get('pt').'&div='.$this->input->get('div').'&dept='.$this->input->get('dept').'&jc='.$this->input->get('jc');

}

else {
  echo "Silahkan Pilih Filter Diatas...";
}

?>

<?php



?>


<!-- CSS styles for standard search box -->
<style type="text/css">
  #tfheader{
    background-color:#CCCCCC;
  }
  #tfnewsearch{
    float:left;
    padding:10px;
  }
  .tftextinput{
    margin: 0;
    padding: 5px 15px;
    font-family: Arial, Helvetica, sans-serif;
    font-size:14px;
    border:1px solid #0076a3; border-right:0px;
    border-top-left-radius: 5px 5px;
    border-bottom-left-radius: 5px 5px;
  }
  .tfbutton {
    margin: 0;
    padding: 5px 15px;
    font-family: Arial, Helvetica, sans-serif;
    font-size:14px;
    outline: none;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    color: #ffffff;
    border: solid 1px #0076a3; border-right:0px;
    background: #0095cd;
    background: -webkit-gradient(linear, left top, left bottom, from(#00adee), to(#0078a5));
    background: -moz-linear-gradient(top,  #00adee,  #0078a5);
    border-top-right-radius: 5px 5px;
    border-bottom-right-radius: 5px 5px;
  }
  .tfbutton:hover {
    text-decoration: none;
    background: #007ead;
    background: -webkit-gradient(linear, left top, left bottom, from(#0095cc), to(#00678e));
    background: -moz-linear-gradient(top,  #0095cc,  #00678e);
  }
  /* Fixes submit button height problem in Firefox */
  .tfbutton::-moz-focus-inner {
    border: 0;
  }
  .tfclear{
    clear:both;
  }


  .fwm_button {
   color: white;
   font-weight: bold;   
   background-image: url('http://<?php echo $_SERVER['SERVER_NAME']?>/hris2/includes/images/excel1.png');

 }

</style>
