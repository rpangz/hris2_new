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

// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}

$id_kk = $this->uri->segment(4);

if ($this->uri->segment(4) !='edit' && $this->uri->segment(4) !='add'){

//echo "<form method='post' action='https://".$_SERVER['SERVER_NAME']."/hris2/bpjs/frmReview/index/'>";
//echo "<option value='https://".$_SERVER['SERVER_NAME']."/hris2/bpjs/frmMemberListAstel/index/$data[iPeriodId]' SELECTED> $data[cPeriodName]</option>";  

?>
<!--
   <input type="text" name="id" placeholder="Isi Dengan No Kartu Keluarga..." autocomplete="off" size="50"><input type="submit" class='btn btn-default' name="submit" value="  Search  "><br>
</form>
</br>-->

 <!-- HTML for SEARCH BAR -->
  <div id="tfheader">
<?php
  echo "<form method='post' action='https://".$_SERVER['SERVER_NAME']."/hris2/bpjs/frmReview/index/'>";
?>    
    
  <table width="100%">
            <tr>
              <td>
                <input type="text" class="tftextinput" size="40" maxlength="120" autocomplete="off" placeholder="Isi Dengan No Kartu Keluarga..." name="id"><input type="submit" name="submit" value="Search" class="tfbutton">
              </td>
            </tr>
  </table> </form>  
  <div class="tfclear"></div>
  </div>
  <br/>

<?php
if ($this->uri->segment(4) !=''){
  
  //include "includes/koneksi/koneksi.php";

  $no_kk= $this->uri->segment(4);

  $sql     = mysql_query("SELECT * FROM tbl_bpjs LEFT JOIN tbl_company ON tbl_bpjs.companyID = tbl_company.iCompanyId WHERE No_KK='$no_kk' AND PISA=1");
  $data    = mysql_fetch_array($sql);
  $bStatus = $data['bStatus'];  

  $jml = mysql_num_rows($sql);

  if ($jml == 0 || $bStatus == 0){
    $bButton = "disabled";
  }
  else {
    $bButton = "";
  }
 
  echo "<form><input type='button' $bButton class='btn btn-large'  value='  Add Member  ' onClick=window.location.href='https://$_SERVER[SERVER_NAME]/hris2/bpjs/frmReview/index/add/$id_kk'></form></br>";

}
}


if ($this->uri->segment(4) !=''){
echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);

}
?>


<!-- CSS styles for standard search box -->
<style type="text/css">



  #tfheader{

  }
  #tfnewsearch{
    float:left;
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
</style>


<?php

if(isset($_POST['submit'])) 
{

	//include "includes/koneksi/koneksi.php";

	$name = madSafety($_POST['id']);
  //$name = $_POST['id'];

  //$no_kk = madSafety($name);
  

	$tampil = mysql_query("SELECT * FROM tbl_bpjs WHERE No_KK='$name' AND PISA=1");
	$total  = mysql_num_rows($tampil);
    
    
    if ($total=="" || $total ==0){
    	echo "</br>Data Dengan Nomor Kartu Keluarga  <b>$name</b>  Tidak Ditemukan...";
    }
    else {
      echo "<script language='javascript'>window.location ='https://".$_SERVER['SERVER_NAME']."/hris2/bpjs/frmReview/index/$name';</script>";
    //echo "<script language='javascript'>window.location ='https://astapp02/hris2/bpjs/frmReview/index/add/$name';</script>";    
    }
    //header('Location: https://astapp02/hris2/bpjs/frmReview/index/$name');

}

?>


<?php
if(isset($dropdown_setup11)) {
  $this->load->view('dependent_dropdown11', $dropdown_setup11);
}
?>

<?php
if(isset($dropdown_setup22)) {
  $this->load->view('dependent_dropdown22', $dropdown_setup22);
}
?>

<?php
if(isset($dropdown_setup33)) {
  $this->load->view('dependent_dropdown33', $dropdown_setup33);
}
?>

<?php

function anti_injection($sql) {
   $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\)/"),"",$sql);
   $sql = trim($sql);
   $sql = strip_tags($sql);
   $sql = addslashes($sql);
   return $sql;
   
}

function madSafety($string) {
$string = stripslashes($string);
$string = strip_tags($string);
$string = mysql_real_escape_string($string);
return $string;
} 


?>


<script type="text/javascript">
    $(document).ready(function()
        {
    var changeYear = $( ".datepicker-input" ).datepicker( "option", "changeYear" );
    $( ".datepicker-input" ).datepicker( "option", "yearRange", "-70:+70" );
        });
</script>