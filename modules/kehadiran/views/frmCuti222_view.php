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
  $notes = 'Silahkan Pilih Jenis Cuti Dibawah';
}else{
  $notes = 'Sisa Cuti '.$jeniscuti.' Anda <span class="badge"><b>'.$sisacuti.'</b></span> Days.';
}

echo"<div class='alert alert-info'>
      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      <strong>Info!</strong> $notes
    </div>
    <table>
  <tr>
    <td><select class='form-control' id=select onchange=goToPage('select')>
	<option value='' disabled SELECTED>Select Jenis Cuti</option>";

    $sql = mysql_query("SELECT * FROM tbl_jeniscuti WHERE id ".$jen_cuti." ORDER BY id ASC");					  
		 while ($data = mysql_fetch_array($sql)){

    if($this->uri->segment('4')==$data['id']){  
      echo "<option value='http://$_SERVER[SERVER_NAME]/hris2/kehadiran/frmCuti2/index/$data[id]' SELECTED>$data[JenisCutiName]</option>";
    }
    else {
      echo "<option value='http://$_SERVER[SERVER_NAME]/hris2/kehadiran/frmCuti2/index/$data[id]'>$data[JenisCutiName]</option>";
    }

    }  
		 
echo"</select></table>&nbsp;&nbsp;";


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
//echo '<link type="text/css" rel="stylesheet" href="{{ base_url }}assets/bootstrap/css/datepicker.css">';
//echo '<script src="{{ base_url }}assets/bootstrap/js/bootstrap-datepicker2.js"></script>';
}


$From    = '01/04/2016';
$dd      = substr($From,0,2);
$mm      = substr($From,3,2);
$yyyy    = substr($From,6,4);

$new_format_date = $yyyy.'-'.$mm.'-'.$dd;
//$isa        = strtotime('2016-04-01');

$isa    = strtotime($new_format_date);
        //$input         = strtotime($post_array['TglActive1']);

$TglActive2 = date('Y-m-d',strtotime('+90 days',$isa));

//echo $TglActive2;

$originalDate = "01/04/2016";
//echo $newDate = date("Y-m-d", strtotime($originalDate));

$date1 = '2016-02-01';
$date2 = '2016-03-08';

if ($date1 > $date2){
  echo 'X';
}else{
  echo 'O';
}



if ($this->uri->segment('4') == 3 && $state=='add'){
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
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

    .glyphicon.glyphicon-question-sign {
    font-size: 12px;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    }

    label {
        display: block;
        padding-left: 15px;
        text-indent: -15px;
    }

    a.my-tool-tip, a.my-tool-tip:hover, a.my-tool-tip:visited {
      color: black;
    }

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
    a.tooltip span {
        border-radius:4px;
        box-shadow: 5px 5px 8px #CCC;
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



<!--
<script type="text/javascript" src="{{ base_url }}assets/jquery/jquery-1.9.1.js"></script>  
<script type="text/javascript" src="{{ base_url }}assets/jquery/jquery-ui.js"></script> 


<script type='text/javascript'>//<![CDATA[
$(window).load(function(){
$(document).ready(function () {
    var d = new Date();
    var monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"];
    today = monthNames[d.getMonth()] + ' ' + d.getDate() + ' ' + d.getFullYear();

    $('#to').attr('disabled', 'disabled');
    $('#from').datepicker({
        defaultDate: "+1d",
        minDate: 1,
        maxDate: "+6M",
        dateFormat: 'dd/mm/yy',
        showOtherMonths: true,
        changeMonth: true,
        selectOtherMonths: true,
        required: true,
        showOn: "focus",
        numberOfMonths: 1,
    });

    $('#from').change(function () {
        var from = $('#from').datepicker('getDate');
        var date_diff = Math.ceil((from.getTime() - Date.parse(today)) / 86400000);
        var maxDate_d = date_diff+93+'d';
        date_diff = date_diff + 'd';
        $('#to').val('').removeAttr('disabled').removeClass('hasDatepicker').datepicker({
            dateFormat: 'dd/mm/yy',
            minDate: date_diff,
            maxDate: maxDate_d
        });
    });

    $('#to').keyup(function () {
        $(this).val('');
        alert('Please select date from Calendar');
    });
    $('#from').keyup(function () {
        $('#from,#to').val('');
        $('#to').attr('disabled', 'disabled');
        alert('Please select date from Calendar');
    });

});
});//]]> 

</script>
-->
<section id="autocomplete">
                <div class="page-header">
                    <h1>Autocomplete</h1>
                </div>
                <div class="ui-widget">
                    <label for="tags">Tags: </label>
                    <input id="tags" class="form-control" />
                </div>


<script type="text/javascript">
// Autocomplete
var availableTags = [

<?php
$query  = mysql_query('SELECT * FROM tbl_profile WHERE bStatus=1 ORDER BY Nama ASC');
$total  = mysql_num_rows($query);

  while($data = mysql_fetch_array($query)){

    echo '"'.$data['Nama'].'",';

  }
//"ActionScript", "AppleScript", "Asp", "BASIC", "C", "C++", "Clojure", "COBOL", "ColdFusion", "Erlang", "Fortran", "Groovy", "Haskell", "Java", "JavaScript", "Lisp", "Perl", "PHP", "Python", "Ruby", "Scala", "Scheme",];
?>
];

$("#tags").autocomplete({
    source: availableTags
});
</script>
</section>

 
               
                <div id="tooltip">
                  <p><a href="#" title="That's what this widget is">Tooltips</a> can be attached to any element. When you hover
                      the element with your mouse, the title attribute is displayed in a little box next to the element, just like a native tooltip.</p>
                  <p>But as it's not a native tooltip, it can be styled. Any themes built with
                      <a href="#" title="ThemeRoller: jQuery UI's theme builder application">ThemeRoller</a>
                      will also style tooltips accordingly.</p>
                  <p>Tooltips are also useful for form elements, to show some additional information in the context of each field.</p>
                  <p><label for="age">Your age:</label><input id="age" title="We ask for your age only for statistical purposes." /></p>
                  <p>Hover the field to see the tooltip.</p>
                </div>



  
  
  

  
    
  
    
  
