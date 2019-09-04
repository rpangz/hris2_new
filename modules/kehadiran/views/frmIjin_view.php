<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if($this->uri->segment('5') =='' && ($this->uri->segment('4') !='add')){
  ?>

  

<?php
echo"<table style='font-size:12px'>
  <tr>
    <td><select class='form-control' id=select onchange=goToPage('select')>";
	  echo "<option value='' disabled SELECTED>Select Jenis Ijin</option>";
    $sql = mysql_query("SELECT * FROM tbl_jenisijin ORDER BY JenisIjinId ASC");					  
		 while ($data = mysql_fetch_array($sql)){

    if($this->uri->segment('4')==$data['JenisIjinId']){  
      echo "<option value='http://$_SERVER[SERVER_NAME]/hris2/kehadiran/frmIjin/index/$data[JenisIjinId]' SELECTED>$data[JenisIjinName]</option>";
    }

      else {
      echo "<option value='http://$_SERVER[SERVER_NAME]/hris2/kehadiran/frmIjin/index/$data[JenisIjinId]'>$data[JenisIjinName]</option>";
    }
  }
  		 
echo"</select></table>&nbsp;&nbsp;";


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

if ($this->input->get('ref') == 'detail' && !is_null($this->input->get('id')) ){  
  $this->load->model('detail_form_model');
  echo $this->detail_form_model->detail_form_ijin($form_id = $this->input->get('id'),$company_id=NULL,$session_id,$level_id=NULL);

}

?>
<script>
    $("#myModal").on("show", function() {    // wire up the OK button to dismiss the modal when shown
        $("#myModal a.btn").on("click", function(e) {
            console.log("button pressed");   // just as an example...
            $("#myModal").modal('hide');     // dismiss the dialog
        });
    });
    $("#myModal").on("hide", function() {    // remove the event listeners when the dialog is dismissed
        $("#myModal a.btn").off("click");
    });
    
    $("#myModal").on("hidden", function() {  // remove the actual elements from the DOM when fully hidden
        $("#myModal").remove();
    });
    
    $("#myModal").modal({                    // wire up the actual modal functionality and show the dialog
      "backdrop"  : "static",
      "keyboard"  : true,
      "show"      : true                     // ensure the modal is shown immediately
    });
</script>
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
</style>
