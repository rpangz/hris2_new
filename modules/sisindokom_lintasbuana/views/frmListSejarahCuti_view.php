<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//include "includes/koneksi/koneksi.php";
$this->config->load('cms_config');       
$company_id = $this->config->item('cms_sisindokom_id');

function madSafety($string) {
  $string = stripslashes($string);
  $string = strip_tags($string);
  $string = mysql_real_escape_string($string);
  return $string;
} 


$NIK = $this->uri->segment('4');
  



  if (!is_null($this->input->get('nik'))){
        $NIK  = $this->input->get('nik');
        $name = madSafety($NIK);
      $arr  = explode(" ",$name);
      $nik = $arr[0];
      $sSQL    = mysql_query("SELECT * FROM tbl_profile WHERE NIK='$nik'");
      $profile = mysql_fetch_array($sSQL);
      $Jml  = mysql_num_rows($sSQL);

if ($Jml >0){
  $nikki = $nik;
  $nama = $profile['Nama'];
  $email = $profile['Email'];
  $link  = '#';
  $link2  = '#';


}else{
  $nikki = '';
  $nama  = '';
  $email = '';
  $link  = '#';
  $link2  = '#';
}

      }
    else{
        $NIK = '';
        $name = madSafety($NIK);
        $arr  = explode(" ",$name);
        $nik = $arr[0];

        $nikki = '';
        $nama  = '';
        $email = '';
        $link  = '#';
        $link2  = '#';
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
  var node = document.getElementById(id);  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>

<style type="text/css">

  select {
    
  }

  select {
  font-size: 14px;
  font-family: arial;
}

</style>




<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<!-- CSS styles for standard search box -->
<style type="text/css">
  #tfheader{
    /* background-color:#c3dfef; */

  }
  #tfnewsearch{
    float:left;
    /*padding:10px;*/
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

  span.glyphicon-search {
    width: 28px;
    height:28px;
}

</style>


  <!-- HTML for SEARCH BAR -->
  <div id="tfheader">
    
    <form id="tfnewsearch" method="get" action="?">
      <table width="100%">
            <tr>
              <td>
                <input type="text" class="tftextinput" size="40" maxlength="120" autocomplete="off" placeholder="NIK or Name" name="nik"><input type="submit" value="search" class="tfbutton">
              </td>
              <!--
              <td align="right"  width="60%">
                <a href="#" <?php //echo $link; ?></a>
                <a href="#" <?php //echo $link2; ?></a>

              </td>-->
            </tr>
   </table> </form>  
  <div class="tfclear"></div>
  </div>
  

      

  <!--   
    <div class="row">        
        <div class="col-md-6 col-md-offset-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="NIK or Name" />                    
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </div>
    </div>-->

   


<?php  

  include "./includes/frmListSejarahCuti_new.php";

?>


<script src="https://<?php echo $_SERVER['SERVER_NAME'];?>/hris2/includes/js/jquery-1.8.3.js"></script>
<script src="https://<?php echo $_SERVER['SERVER_NAME'];?>/hris2/includes/js/jquery-ui.js"></script>


  
 

 <script>
  
    // fungsi autocomplete
    function autocomplete(){
      $( ".auto" ).autocomplete({
       source: "https://<?php echo $_SERVER['SERVER_NAME'];?>/hris2/includes/Search.php?com=<?php echo $company_id;?>", 
         minLength:2,
      });
      
      // hapus inputan data 
      $(".hapus").click(function(){
        $(this).parent().parent().remove();
      });
    }
    $(function(){
      // fungsi autocomplete default
      $( ".tftextinput" ).autocomplete({
       source: "https://<?php echo $_SERVER['SERVER_NAME'];?>/hris2/includes/Search.php?com=<?php echo $company_id;?>", 
         minLength:2,
      });
      
      // fungsi untuk menambahkan inputan data
      $("#tambah").click(function(){
        row = '<tr><td></td><td><input type="text" name="nik[]" class="auto" /></td>'+
        '<td><button class="hapus">Hapus</button></td></tr>';
        $(row).insertBefore("#last");
        autocomplete();
      });
    });
    </script>


   