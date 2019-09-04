<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$profile = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$_SESSION['NIK']));

$this->config->load('cms_config');       
$company_id = $this->config->item('cms_astel_id');
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

$this->load->model('data_filter_model');

if($this->uri->segment('5') !='edit' && $this->uri->segment('5') !='add' && $this->uri->segment('6') !='add' && $this->uri->segment('4') !='read' && $this->uri->segment('5') !='read' && $this->uri->segment('6') !='read'){

echo $this->data_filter_model->data_filter_company_and_form_cuti($company_id,$modules,$pages,$type_cuti=$JenisCuti,$nikki=$NIKKI);

}


elseif($this->uri->segment('5') == 'read'){
  $ID  = $this->uri->segment('6');

  $ska = mysql_fetch_array(mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId=".$ID));
  if($ska['StatusForm']=='A'){
    $url    = 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/export/frmListCuti/Export2Html2.php?id='.$ID;   
    $target = 'target=_blank';   

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

if ($this->input->get('ref') == 'detail' && !is_null($this->input->get('id')) ){  
   $this->load->model('detail_form_model');
   echo $this->detail_form_model->detail_form_cuti($form_id = $this->input->get('id'),$company_id,$session_id=NULL,$level_id=NULL);

}


function update_tbl_profile($nik,$substitution_nik,$substitution_status){

    mysql_query("UPDATE tbl_profile SET SubstitutionNIK1='$substitution_nik',SubstitutionStatus='$substitution_status' WHERE NIK='$nik'");

}

function current_substitution($nik){

    $query  = mysql_query('SELECT * FROM tbl_profile WHERE NIK='.$nik);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['SubstitutionNIK1'];
    }
    else {
        return '';
    }

}

function current_substitution_status($nik){

    $query  = mysql_query('SELECT * FROM tbl_profile WHERE NIK='.$nik);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        if ($data['SubstitutionStatus']==1){
            return 'checked';
        }else{
            return '';
        }
    }
    else {
        return '';
    }

}

function substitution_status_nav($nik){

    $query  = mysql_query('SELECT * FROM tbl_apv_group_approval WHERE NIK='.$nik);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    $query2  = mysql_query('SELECT * FROM tbl_apv_hrd WHERE hrd_nik='.$nik);
    $total2  = mysql_num_rows($query2);
    $data2   = mysql_fetch_array($query2);

    if ($total >0 || $total2 >0){
        $substitution_nav = '';
    }
    else {
        $substitution_nav = 'disabled';
    }

    return $substitution_nav;

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