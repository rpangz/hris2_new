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


$crud = new report_karyawan_masuk();


  ?>   
    <table class="table table-striped" style="font-size:12px;width:75%;table-layout:fixed">
        <tr>
            <td width="10%" class="noborder-lr" valign="middle">Jenis</td>
            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
            <td width="37%">
              <select name="jenis" id="jenis" class="chosen-select form-control" data-placeholder="Pilih Perusahaan" style="width: 100%; font-size: 12px; height: 30px; ">
                <option value="detail" selected="">DETAIL</option>
                <option value="rekap">REKAP</option>
               </select>
            </td>
            <td width="7%"><div align="left"></div></td>
            <td width="12%" class="noborder-lr" valign="middle">Grouping</td>
            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
            <td width="37%">
              <select name="grouping" id="grouping" class="chosen-select form-control" data-placeholder="Pilih Perusahaan" style="width: 100%; font-size: 11px; height: 30px;">
                <option value="all"> ALL </option>
                <option value="cCompanyName"> COMPANY </option>
                <option value="cDivName"> DIVISI </option>
                <option value="cDeptName"> DEPARTMENT </option>
                <option value="tglmasuk"> TGL MASUK </option>
               </select>
            </td>
        </tr>

        <tr>
            <td width="10%" class="noborder-lr" valign="middle">Company</td>
            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
            <td width="37%">
              <select name="company" id="company" class="chosen-select form-control" data-placeholder="Pilih Perusahaan" style="width: 100%; font-size: 11px; height: 30px;">
                <option value="0" selected="selected">ALL</option>
                    <?php echo $company ?>
               </select>
            </td>
            <td width="7%"><div align="left"></div></td>
            <td width="12%" class="noborder-lr" valign="middle">Divisi</td>
            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
            <td width="37%">
              <select name="divisi" id="divisi" class="chosen-select form-control" data-placeholder="Pilih Perusahaan" style="width: 100%; font-size: 11px; height: 30px;"> 
                <option value="0">ALL</option>               
               </select>
            </td>
        </tr>

        <tr>
            <td width="10%" class="noborder-lr" valign="middle">Department</td>
            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
            <td width="37%">
              <select name="department" id="department" class="chosen-select form-control" data-placeholder="Pilih Perusahaan" style="width: 100%; font-size: 11px; height: 30px;">
                <option value="0">ALL</option>
               </select>
            </td>
            <td width="7%"><div align="left"></div></td>
            <td width="12%" class="noborder-lr" valign="middle">Tanggal Masuk</td>
            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
            <td width="37%">
              <input type="text" class="form-control" id="tglfrom" name="tglfrom" placeholder="Dari" style="text-align: center; width: 100px; height: 30px; font-size: 12px;" value="">
              
            </td>
        </tr>
    </table>    
    <td style="width: 300px;">
        <input type="button" name="load" id="load" value="- LOAD DATA -" style="width: 90px; height: 25px; font-size: 11px;"> <input type="button" name="reset" id="reset" value="- RESET -" onclick="ResetData()" style="width: 90px; height: 25px; font-size: 11px;">
    </td>
    <div style="width: 100%; text-align: center;">
        <label>LAPORAN DATA KARYAWAN</label>
    </div>
    <div style="width: 100%; border-bottom: 1px solid;"></div>
    <div id="divloaddata" style="width: 100%; border-bottom: 1px solid; overflow: scroll; height: 450px;">

    </div>
    <br/>                    




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

    function exportTableToExcel(tableID, filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        
        // Specify file name
        filename = filename?filename+'.xls':'excel_data.xls';
        
        // Create download link element
        downloadLink = document.createElement("a");
        
        document.body.appendChild(downloadLink);
        
        if(navigator.msSaveOrOpenBlob){
            var blob = new Blob(['\ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob( blob, filename);
        }else{
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        
            // Setting the file name
            downloadLink.download = filename;
            
            //triggering the function
            downloadLink.click();
        }
    }

</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap3/docs/css/highlight.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap3/css/bootstrap-switch.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-select-1.9.4/css/bootstrap-select.min.css'); ?>" />
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap-select-1.9.4/js/bootstrap-select.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap-select-1.9.4/js/i18n/defaults-*.min.js'); ?>"></script>



<!-- Script for Switch button ON-OFF-->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap3/docs/js/highlight.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap3/js/bootstrap-switch.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap3/docs/js/main.js'); ?>"></script>

<script type="text/javascript">

$( document ).ready(function() {
    //$("#switch-animate").bootstrapSwitch();

    $("#load").click(function(e){    

        var jenis    = $('#jenis').val();
        var grouping = $('#grouping').val();
        var company = $('#company').val();
        var divisi = $('#divisi').val();
        var department = $('#department').val();
        /*
        var tglfr = $('#grouping').val();
        var tglto = $('#grouping').val();
        
        var tglfr = '01/10/2019';
        var tglto = '31/10/2019';
        */
        var tglfr = '';
        var tglto = '';
        var loadingtxt = '<center><img src="<?php echo base_url('images/loader2.gif'); ?>"></center>';
        $('#divloaddata').html(loadingtxt);
        $.ajax({
            url : "<?php echo site_url('report/report_karyawan_masuk/ajax_load_data/')?>/?jenis="+jenis+"&grouping="+grouping+"&company="+company+"&divisi="+divisi+"&department="+department+"&tglfr="+tglfr+"&tglto="+tglto,
            type: "GET",            
            success: function(data)
            {                
                $('#divloaddata').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
               //show_modal_dialog_warning(title='ERROR', 'Mohon dicoba kembali...');
               show_modal_dialog_warning(title='ERROR', errorThrown);
               //alert('Error ajax data');
            }
        });   
    });  


    $("#company").change(function(e){    
        var company    = $('#company').val();
        $.ajax({
            url : "<?php echo site_url('report/report_karyawan_masuk/get_divisi/')?>/"+company,
            type: "GET", 
            dataType: "JSON",           
            success: function(data)
            {                
                
                
                $('#department').empty();
                $('#department').append('<option value=0>ALL</option>');

                $('#divisi').empty();
                $('#divisi').append('<option value=0>ALL</option>');
                $.each(data,function(key, value)
                {
                    $('#divisi').append('<option value=' + value.value + '>' + value.property + '</option>'); // return empty
                });
                
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
               //show_modal_dialog_warning(title='ERROR', 'Mohon dicoba kembali...');
               show_modal_dialog_warning(title='ERROR', errorThrown);
               //alert('Error ajax data');
            }
        });   
    });


    $("#divisi").change(function(e){    
        var divisi    = $('#divisi').val();
        $.ajax({
            url : "<?php echo site_url('report/report_karyawan_masuk/get_dept/')?>/"+divisi,
            type: "GET", 
            dataType: "JSON",           
            success: function(data)
            {                
                
                $('#department').empty();
                $('#department').append('<option value=0>ALL</option>');
                $.each(data,function(key, value)
                {
                    $('#department').append('<option value=' + value.value + '>' + value.property + '</option>'); // return empty
                });
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
               //show_modal_dialog_warning(title='ERROR', 'Mohon dicoba kembali...');
               show_modal_dialog_warning(title='ERROR', errorThrown);
               //alert('Error ajax data');
            }
        });   
    });


    


});   


$('#tglfrom').datepicker({
     dateFormat: "dd-mm-yy"
});

/*
$('#tglto').datepicker({
    dateFormat: "dd-mm-yy"
});
*/

</script>