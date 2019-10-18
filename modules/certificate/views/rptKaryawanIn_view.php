<style>
.container {
  width: 100%;
}


.myButton {
    -moz-box-shadow: 3px 4px 0px 0px #1564ad;
    -webkit-box-shadow: 3px 4px 0px 0px #1564ad;
    box-shadow: 3px 4px 0px 0px #1564ad;
    background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5));
    background:-moz-linear-gradient(top, #79bbff 5%, #378de5 100%);
    background:-webkit-linear-gradient(top, #79bbff 5%, #378de5 100%);
    background:-o-linear-gradient(top, #79bbff 5%, #378de5 100%);
    background:-ms-linear-gradient(top, #79bbff 5%, #378de5 100%);
    background:linear-gradient(to bottom, #79bbff 5%, #378de5 100%);
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5',GradientType=0);
    background-color:#79bbff;
    border:2px solid #337bc4;
    display:inline-block;
    cursor:pointer;
    color:#ffffff;
    font-family:Arial;
    font-size:12px;
    font-weight:bold;
    padding:12px 10px;
    text-decoration:none;
}
.myButton:hover {
    background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff));
    background:-moz-linear-gradient(top, #378de5 5%, #79bbff 100%);
    background:-webkit-linear-gradient(top, #378de5 5%, #79bbff 100%);
    background:-o-linear-gradient(top, #378de5 5%, #79bbff 100%);
    background:-ms-linear-gradient(top, #378de5 5%, #79bbff 100%);
    background:linear-gradient(to bottom, #378de5 5%, #79bbff 100%);
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff',GradientType=0);
    background-color:#378de5;
}
.myButton:active {
    position:relative;
    top:1px;
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


/*
    $companyid = $this->uri->segment('4');
    $jenissertifikat = $this->uri->segment('5');
    $tglawal = $this->uri->segment('6');
    $tglakhir = $this->uri->segment('7');
*/

    $jenissertifikat = $this->uri->segment('4');
    $tglawal = $this->uri->segment('5');
    $tglakhir = $this->uri->segment('6');
    $companyid = $this->uri->segment('7');
    $statusaktif = $this->uri->segment('8');
    if($tglawal=="01-01-1900"){$tglawal="";}
    if($tglakhir=="31-12-5000"){$tglakhir="";}

/*
if($jenissertifikat!="" && $jenissertifikat!="ALL") {$lbljenissertifikat = "(".$jenissertifikat.")"; } else {$lbljenissertifikat="";}
if($tglawal!="") {$lbltglawal = ", Tgl :".$tglawal.""; } else {$lbltglawal="";}
if($tglawal!="" && $tglakhir!="") {$lbltglakhir = "S/D ".$tglakhir.""; } else {$lbltglakhir="";}
*/


if($this->uri->segment('9') =='' && $this->uri->segment('4') !='add' && $this->uri->segment('4') !='edit')  {
   $kategori = $this->uri->segment('4');
  ?>   

    <table class="form-group form-inline">
      <tr>
      <td style="padding-right: 10px; width: 300px; height: 35px;" >
        <label style="font-size: 12px;">Company</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <select class="form-control" id="company" style="width: 150px; height: 30px; font-size: 12px;"> 
        <option value="0" <?php if($companyid=="0"){echo "SELECTED";} ?>  >--ALL--</option>  
        <?php      
            $sql = mysql_query("SELECT icompanyID,cCompanyCode FROM tbl_company WHERE bstatus=1");
            while ($data = mysql_fetch_array($sql)) { ?> 
            <option value="<?php echo $data['icompanyID']; ?>" <?php if($companyid==$data['icompanyID']){echo "SELECTED";} ?>  ><?php echo $data['cCompanyCode']; ?></option>           
        <?php } ?>
        </select>
      </td>      
      <td style="padding-right: 10px; width: 300px;" >
        <label style="font-size: 12px;">Jenis Sertifikat</label> &nbsp;
        <select class="form-control" id="jenissertifikat" style="width: 150px; height: 30px; font-size: 12px;">        
            <option value="0" <?php if($jenissertifikat=="0"){echo "SELECTED";} ?>  >--ALL--</option>
            <option value="CISCO" <?php if($jenissertifikat=="CISCO"){echo "SELECTED";} ?> >CISCO</option>
            <option value="ORACLE" <?php if($jenissertifikat=="ORACLE"){echo "SELECTED";} ?> >ORACLE</option>
            <option value="LAINNYA" <?php if($jenissertifikat=="LAINNYA"){echo "SELECTED";} ?> >LAINNYA</option>
        </select>
      </td>      
      </tr>
      <tr>
      <td style="width: 400px; height: 40px;">
        <label style="font-size: 12px;">Tanggal Valid</label> &nbsp; &nbsp; <input type="text" class="form-control" id="tglfrom" name="tglfrom" placeholder="Dari" style="text-align: center; width: 100px; height: 30px; font-size: 12px;" value="<?php echo $tglawal; ?>"> &nbsp;S/D&nbsp; <input type="text" class="form-control" id="tglto" name="tglto" placeholder="Sampai" style="text-align: center; width: 100px; height: 30px;  font-size: 12px;" value="<?php echo $tglakhir; ?>">
      </td>
      <td style="width: 400px; height: 40px;">
        <label style="font-size: 12px;">Status Aktif</label> &nbsp; &nbsp; &nbsp;&nbsp;
        <select class="form-control" id="statusaktif" style="width: 150px; height: 30px; font-size: 12px;">        
            <option value="0" <?php if($statusaktif=="0"){echo "SELECTED";} ?>  >--ALL--</option>
            <option value="AKTIF" <?php if($statusaktif=="AKTIF"){echo "SELECTED";} ?> >AKTIF</option>
            <option value="NON" <?php if($statusaktif=="NON"){echo "SELECTED";} ?> >NON AKTIF</option>            
        </select>
      </td>
      </tr>
       <tr>

      <td style="width: 300px;">
        <input type="button" name="load" id="load" value="- LOAD DATA -" onclick="LoadData(jenissertifikat.value,tglfrom.value,tglto.value,company.value,statusaktif.value)" style="width: 90px; height: 25px; font-size: 11px;"> <input type="button" name="reset" id="reset" value="- RESET -" onclick="ResetData()" style="width: 90px; height: 25px; font-size: 11px;">
      </td>
      
      </tr>

    </table>
    <div style="width: 100%; text-align: center;"><label>LAPORAN SERTIFIKASI</label></div>
    <div style="width: 100%; border-bottom: 1px solid;"></div>
    <br/>                    


     
       
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

    function LoadData(sertifikat,tglawalsertifikat,tglakhirsertifikat,company,statusaktif) {        
        var hrefurl = "<?php echo site_url('certificate/LaporanCertificate/index/'); ?>";
        if(tglawalsertifikat.length<3) {tglawalsertifikat = "01-01-1900";} 
        if(tglakhirsertifikat.length<3) {tglakhirsertifikat = "31-12-5000";}         
        //hrefurl = hrefurl+"/"+company+"/"+sertifikat+"/"+tglawalsertifikat+"/"+tglakhirsertifikat+"/";
        hrefurl = hrefurl+"/"+sertifikat+"/"+tglawalsertifikat+"/"+tglakhirsertifikat+"/"+company+"/"+statusaktif+"/";
        window.location.href = hrefurl;
    }

     function ResetData() {        
        document.getElementById("jenissertifikat").value="0";
        document.getElementById("tglfrom").value="";
        document.getElementById("tglto").value="";
        document.getElementById("company").value="0";
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

$('#tglfrom').datepicker({
    dateFormat: "dd-mm-yy"
});

$('#tglto').datepicker({
    dateFormat: "dd-mm-yy"
});

</script>