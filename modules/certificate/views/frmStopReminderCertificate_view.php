<style>
.container {
  width: 100%;
}

</style>
<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');


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


if($this->uri->segment('5') =='' && $this->uri->segment('4') !='add' && $this->uri->segment('4') !='edit')  {
   $kategori = $this->uri->segment('4');
    echo '<table>
        <tr>
        <td><select class="form-control" id=select onchange=goToPage("select")>';

    ?>        

    <option value="" disabled SELECTED>JENIS SERTIFIKAT</option>
    <option value="<?php echo site_url('certificate/frmStopReminderCertificate/index/0');?>" 
                   <?php if($kategori=='0'){ echo 'SELECTED'; } ?> >--ALL--</option>
    <option value="<?php echo site_url('certificate/frmStopReminderCertificate/index/NON'); ?>"
                   <?php if($kategori=='NON'){ echo 'SELECTED'; } ?> >NON CCIE</option>
    <option value="<?php echo site_url('certificate/frmStopReminderCertificate/index/CCIE'); ?>"
                    <?php if($kategori=='CCIE'){ echo 'SELECTED'; } ?> >CCIE</option>;

    <?php

/*
    $sql = mysql_query("SELECT * FROM tbl_company INNER JOIN
                    tbl_div ON tbl_company.iCompanyId = tbl_div.iDivCompany INNER JOIN
                    tbl_dept ON tbl_div.iDivId = tbl_dept.iDeptDivId ORDER BY iCompanyId,iDivId,iDeptID ASC");
    while ($data = mysql_fetch_array($sql)) {

        if ($this->uri->segment('4') == $data['iDeptID']) {
            //echo '<option value="http://'.site_url('approval/frmGroupApproval/index/').'" SELECTED>'.$data['cCompanyCode'].' &#8226;'. $data['cDivName'].' &#8226;.'.$data['cDeptName'].'</option>';

            echo '<option value="'.site_url('approval/frmGroupApproval/index/'.$data['iDeptID']).'" SELECTED>'.$data['cCompanyCode'].' &#8226; '. $data['cDivName'].' &#8226; '.$data['cDeptName'].'</option>';

        } else {
            echo '<option value="'.site_url('approval/frmGroupApproval/index/'.$data['iDeptID']).'">'.$data['cCompanyCode'].' &#8226; '. $data['cDivName'].' &#8226; '.$data['cDeptName'].'</option>';

            //echo "<option value='http://".$_SERVER['SERVER_NAME']."/hris2/approval/frmGroupApproval/index/". $data['iDeptID']."'>$data[cCompanyCode] &#8226; $data[cDivName] &#8226; $data[cDeptName]</option>";
        }


    }
*/
    echo '</select></td></tr></table><br/>';

}
echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);
?>


<?php
if(isset($dropdown_setup)) {
  $this->load->view('dependent_dropdown', $dropdown_setup);
}
?>


<script type = "text/javascript">
    function goToPage(id) {
        var node = document.getElementById(id);
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
 jQuery(document).ready(function () {

    jQuery("select").on("change", function(){
      var msg = $("#msg");
    
      var count = 0;
    
      for (var i = 0; i < this.options.length; i++)
      {
        var option = this.options[i];
        
        option.selected ? count++ : null;
        
        if (count > 4)
        {
            option.selected = false;
            option.disabled = true;

            msg.html("Please select only four options.");
        }else{
            option.disabled = false;
            msg.html("");
        }
      }
    });
});


</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap3/docs/css/highlight.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap3/css/bootstrap-switch.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-select-1.9.4/css/bootstrap-select.min.css'); ?>" />
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap-select-1.9.4/js/bootstrap-select.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap-select-1.9.4/js/i18n/defaults-*.min.js'); ?>"></script>

<!-- Script for Switch button ON-OFF-->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap3/docs/js/highlight.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap3/js/bootstrap-switch.js'); ?>"></script>
<!--<script type="text/javascript" src="<?php echo base_url('assets/bootstrap3/docs/js/main.js'); ?>"></script>-->

<script type="text/javascript">

$( document ).ready(function() {
    $("#switch-animate").bootstrapSwitch();
});   

</script>