<style type="text/css">
    a.image-thumbnail img{
        max-width:200px;
    }


table.comicGreen {
  font-family: "Times New Roman", cursive, sans-serif;
  border: 2px solid #4F7849;
  background-color: #EEEEEE;

  text-align: left;
  border-collapse: collapse;
}
table.comicGreen td, table.comicGreen th {
  border: 1px solid #4F7849;
  padding: 3px 2px;
}
table.comicGreen tbody td {
  font-size: 13px;
  font-weight: bold;
  color: #4F7849;
}
table.comicGreen thead {
  background: #4F7849;
  background: -moz-linear-gradient(top, #7b9a76 0%, #60855b 66%, #4F7849 100%);
  background: -webkit-linear-gradient(top, #7b9a76 0%, #60855b 66%, #4F7849 100%);
  background: linear-gradient(to bottom, #7b9a76 0%, #60855b 66%, #4F7849 100%);
  border-bottom: 1px solid #444444;
}
table.comicGreen thead th {
  font-size: 14px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: center;
  border-left: 2px solid #D0E4F5;
}
table.comicGreen thead th:first-child {
  border-left: none;
}





</style>
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


if ($this->uri->segment(4) !='edit' AND $this->uri->segment(4) != 'add' AND $this->uri->segment(4) !='read'){
          
}else{
         
}

//if ($company_status == 0){

// Alert untuk company yang berstatus 0 atau tidak aktif
if ($company_status ==0){
echo '<div class="alert alert-warning">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     <strong>Warning!</strong> Anda Tidak Bisa melakukan proses Update, Karena Batas waktunya sudah Habis.
     </div>';
}

//}
// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}
echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);

		if ($this->uri->segment('4') =='edit'){
            //echo '<ol>Email akan dikirim ke HRD Setelah anda melakukan proses Update.</ol>';

    }

?>


<?php
if(isset($dropdown_setup)) {
  $this->load->view('dependent_dropdown', $dropdown_setup);
}
?>

<style type="text/css">
    .box{
        padding: 20px;
        display: none;
        margin-top: 20px;
        border: 1px solid #000;
    }
    
    .autoUpdate{ 
    	background: #FFFFCC;
    	padding: 20px;
    	margin-top: 20px;
        border: 1px solid #000;
        color:#FF0000;
        width: 100%;
    	
         }

    label {
        display: block;
        padding-left: 15px;
        text-indent: -15px;
    }

    a.my-tool-tip, a.my-tool-tip:hover, a.my-tool-tip:visited {
      color: black;
    }
    
    
</style>

<script type="text/javascript">
	$(document).ready(function () {
    $('#checkbox1').change(function () {
        if (!this.checked) 
        //  ^
           $('#autoUpdate').fadeIn('slow');
        else 
            $('#autoUpdate').fadeOut('slow');
        	
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function()
        {
    var changeYear = $( ".datepicker-input" ).datepicker( "option", "changeYear" );
    $( ".datepicker-input" ).datepicker( "option", "yearRange", "-70:+70" );
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
    //return ;
    // /document.getElementById(input).focus();
    //document.getElementById(KodeposKTP).innerHTML = "<span style='color:red;'>Mandatory!</span>";
      return ;


}

function handleChange2(input) {
   
    var input=parseInt(input.value);
    if(input !=5)
    alert("ZIP (Current) value should be 5 Digit");
    return ;

}



</script>

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
