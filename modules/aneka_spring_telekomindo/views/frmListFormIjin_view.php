<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->model('data_filter_model');

$modules = $this->uri->segment('1');
$pages   = $this->uri->segment('2');
$this->config->load('cms_config');       
$company_id = $this->config->item('cms_astel_id');

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

  echo $this->data_filter_model->data_filter_company_and_form_ijin($company_id,$modules,$pages,$type=$JenisIjin,$nikki=$NIKKI);

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

if ($this->input->get('ref') == 'detail' && !is_null($this->input->get('id')) ){  
   $this->load->model('detail_form_model');
   echo $this->detail_form_model->detail_form_ijin($form_id = $this->input->get('id'),$company_id);
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
<!-- sometime later, probably inside your on load event callback -->
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
