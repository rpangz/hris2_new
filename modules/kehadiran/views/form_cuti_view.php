<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ($sex =='P' && $status_diri ==1){
  $jen_cuti = '!=5';
}
elseif($sex == 'L'){
  $jen_cuti = '!=5';
}
else{
  $jen_cuti = '>=0';
}


if($state !='edit' AND $state !='add'){

    if ($jen_cuti == '---ALL---' || is_null($this->uri->segment('3')) || ($this->uri->segment('4')) ==0){
        $notes = 'Silahkan pilih jenis cuti dibawah';
    }
    elseif($jenis_cuti_id == 3){
        $notes = 'Silahkan lihat info cuti <i>'.$jeniscuti.'</i>';
    }
    elseif($jenis_cuti_id == 4){
        $notes = 'Cuti <i>'.$jeniscuti.'</i> anda dipotong otomatis oleh Sistem / HRD';
    }

    elseif($jenis_cuti_id == 5){
        $notes = 'Maksimal cuti <i>'.$jeniscuti.'</i> anda <span class="badge"><b>'.$maximun_days.'</b></span>';
    }
    else{
        $notes = 'Sisa cuti <i>'.$jeniscuti.'</i> anda <span class="badge"><b>'.$sisacuti.' Days</b></span> ';
    }

echo '<div class="alert alert-info">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Info!</strong> '.$notes.'</div>
      <table>
    <tr>
      <td><select class="form-control" id="select" onchange=goToPage("select")>
	  <option value="0" disabled SELECTED>Select Jenis Cuti</option>';

$sql = mysql_query("SELECT * FROM tbl_jeniscuti WHERE id ".$jen_cuti." ORDER BY id ASC");					  
while ($data = mysql_fetch_array($sql)){

    if($this->uri->segment('4')==$data['id']){  
      echo '<option value="'.site_url('kehadiran/form_cuti/index/'.$data['id']).'" SELECTED>'.$data['JenisCutiName'].'</option>';
    }
    else {
      echo '<option value="'.site_url('kehadiran/form_cuti/index/'.$data['id']).'">'.$data['JenisCutiName'].'</option>';
    }

}  
		 
echo '</select></table>&nbsp;&nbsp;';


}

elseif($this->uri->segment('5') =='read'){
  $id_child = $this->uri->segment('6');
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


if(isset($dropdown_setup)) {
  $this->load->view('dependent_dropdown_item', $dropdown_setup);
}

if ($this->input->get('ref') == 'detail' && !is_null($this->input->get('id')) ){  
  $this->load->model('detail_form_model');
  echo $this->detail_form_model->detail_form_cuti($form_id = $this->input->get('id'),$company_id=NULL,$session_id,$level_id=NULL);

}

if ($this->uri->segment('4') == 5){

}

if ($this->uri->segment('4') == 3 && $state=='add' ){
?>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Info Form Cuti Khusus/ Ijin
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Info Form Cuti Khusus/ Ijin</h4>
      </div>
      <div class="modal-body">
        {{ cms_notice_cuti_khusus }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

<?php
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

<script>

$(document).ready(function () {   
    ko.applyBindings({showAlert: ko.observable(true)});
});

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



a.tooltip {outline:none; }
a.tooltip strong {line-height:30px;}
a.tooltip:hover {text-decoration:none;} 
a.tooltip span {
    z-index:10;display:none; padding:14px 20px;
    margin-top:-30px; margin-left:28px;
    width:300px; line-height:16px;
}
a.tooltip:hover span{
    display:inline; position:absolute; color:#111;
    border:1px solid #DCA; background:#fffAF0;}
.callout {z-index:20;position:absolute;top:30px;border:0;left:-12px;}
    
/*CSS3 extras*/
a.tooltip span
{
    border-radius:4px;
    box-shadow: 5px 5px 8px #CCC;
}

</style>



<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>


<script language="JavaScript">
  function testing(val,x){
    maxlen = x;
    if(val.length > maxlen){
    alert('Limit of characters is '+ maxlen);
    document.chars.tests.value = val.substring(0,maxlen);
    document.crudForm.Keperluan.focus() ;return false;
  }
}

function Minimum(obj,min){
 if (obj.value.length<min) alert('Field Keperluan minimal '+min+' karakter');
 document.crudForm.Keperluan.focus() ;return false;
}

$('textarea').keyup(function() {
    var cs = $(this).val().length;
    $('#characters').text(cs);
});

</script>


<script type="text/javascript">
function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    }

function alphanumeric(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
}

function alphaOnly(e) {
  var code;
  if (!e) var e = window.event;
  if (e.keyCode) code = e.keyCode;
  else if (e.which) code = e.which;
  if ((code >= 48) && (code <= 57)) { return false; }
  return true;
}



function validateEmail(sEmail) {
  var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;

  if(!sEmail.match(reEmail)) {
    alert("Invalid email address");
    return false;
  }

  return true;

}

function handleChange1(input) {   
    var input=parseInt(input.value);
    if(input < 5 || input >5)
    alert("ZIP (ID Based) value should be 5 Digit");
    return ;
}

function handleChange2(input){   
    var input=parseInt(input.value);
    if(input !=5)
    alert("ZIP (Current) value should be 5 Digit");
    return ;
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

    .dropdown_box{
        width:500px;
        height:30px;
        margin-top:5px;
        margin-left:0px;
        font-size: 12px;
        font-family: arial;
    }

    .form-control{
        width:100%;
    }

    .row {
        -webkit-column-width: 700px; /* Chrome, Safari, Opera */
        -moz-column-width: 700px; /* Firefox */  
        column-width: 700px;
    }

    

</style>

<script type="text/javascript">
$(document).ready(function(){
    $(".tip-top").tooltip({
        placement : 'top'
    });
    $(".tip-right").tooltip({
        placement : 'right'
    });
    $(".tip-bottom").tooltip({
        placement : 'bottom'
    });
    $(".tip-left").tooltip({
        placement : 'left'
    });
});
</script> 