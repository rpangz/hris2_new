<style>
.container {
  width: 100%;
}

.butn {
  -webkit-border-radius: 37;
  -moz-border-radius: 37;
  border-radius: 37px;
  font-family: Georgia;
  color: #ffffff;
  font-size: 12px;
  background: #3498db;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
}

.butn:hover {
  background: #0e83cc;
  text-decoration: none;
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

echo '<div style="display:none">'.preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output).'</div>';

$crud = new penyesuaian_karyawan();


  ?>   
    <table class="table table-striped" style="font-size:12px;width:55%;table-layout:fixed">
        <tr>
            <td width="10%" class="noborder-lr" valign="middle">Jenis</td>
            <td width="2%" class="noborder-lr"><div align="center">:</div></td>
            <td width="37%">
              <select name="jenis" id="jenis" class="chosen-select form-control" data-placeholder="Pilih Perusahaan" style="width: 100%; font-size: 12px; height: 35px; ">
                  <option value="0" disabled selected>- Pilih Jenis Mutasi -</option>  
                  <?php echo $jenismutasi; ?>
               </select>
            </td>
        
            <td style="width: 300px;">           
                <input type="button" name="loadjenis" id="loadjenis" value="- LOAD DATA -" style="width: 90px; height: 30px; font-size: 11px;"> <input type="button" name="reset" id="reset" value="- RESET -" onclick="ResetForm()" style="width: 90px; height: 30px; font-size: 11px;">    
            </td>         
        </tr>
    </table>    

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

    


    $("#loadjenis").click(function(e){    
        var jenis    = $('#jenis').val();
        $.ajax({
            url : "<?php echo site_url('karyawan/penyesuaian_karyawan/loadform/')?>/?jenis="+jenis,
            type: "GET", 
            success: function(data)
            {                                            
                $('#divloaddata').html(data);

                $('#tgleffektif').datepicker({
                     dateFormat: "dd/mm/yy"
                });

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


function save_band() {
    var nik    = $('#nik').val();
    var band = $('#band').val();
    var jabatan = $('#jabatan').val();
    var tglfrom = $('#tgleffektif').val();
    var jenismutasival = $('#jenismutasival').val();
    var remark = $('#remark').val();

    $.ajax({
        url : "<?php echo site_url('karyawan/penyesuaian_karyawan/ajax_save_band/')?>/?nik="+nik+"&band="+band+"&jabatan="+jabatan+"&tglfrom="+tglfrom+"&jenismutasival="+jenismutasival+"&remark="+remark,
        type: "GET",     
              
        success: function(data)
        {                       
            var res    = data.split("|");
            var error  = res[0];
            var errmsg = res[1];
            alert(errmsg);
            if(error){
            } else {
                ResetForm();
            }
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
           //show_modal_dialog_warning(title='ERROR', 'Mohon dicoba kembali...');
           show_modal_dialog_warning(title='ERROR', errorThrown);
           //alert('Error ajax data');
        }
    });   
}


function save_mutasi() {
    var nik            = $('#nik').val();
    var nikbaru        = $('#nikbaru').val();
    var company        = $('#company').val();
    var divisi         = $('#divisi').val();
    var department     = $('#department').val();
    var tgleffektif    = $('#tgleffektif').val();
    var jenismutasival = $('#jenismutasival').val();
    var remark = $('#remark').val();

    $.ajax({
        url : "<?php echo site_url('karyawan/penyesuaian_karyawan/ajax_save_mutasi/')?>/?nik="+nik+"&company="+company+"&divisi="+divisi+"&department="+department+"&jenismutasival="+jenismutasival+"&tgleffektif="+tgleffektif+"&remark="+remark+"&nikbaru="+nikbaru,
        type: "GET",     
              
        success: function(data)
        {                                   
            var res    = data.split("|");
            var error  = res[0];
            var errmsg = res[1];
            alert(errmsg);
            if(error){
            } else {
                ResetForm();
            }
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
           //show_modal_dialog_warning(title='ERROR', 'Mohon dicoba kembali...');
           show_modal_dialog_warning(title='ERROR', errorThrown);
           //alert('Error ajax data');
        }
    });   
}

function save_tetap() {
    var nik            = $('#nik').val();
    var tgleffektif    = $('#tgleffektif').val();
    var jenismutasival = $('#jenismutasival').val();
    var remark = $('#remark').val();

    $.ajax({
        url : "<?php echo site_url('karyawan/penyesuaian_karyawan/ajax_save_tetap/')?>/?nik="+nik+"&jenismutasival="+jenismutasival+"&tglefektif="+tgleffektif+"&remark="+remark,
        type: "GET",     
              
        success: function(data)
        {                       
            var res    = data.split("|");
            var error  = res[0];
            var errmsg = res[1];
            alert(errmsg);
            if(error){
            } else {
                ResetForm();
            }
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
           //show_modal_dialog_warning(title='ERROR', 'Mohon dicoba kembali...');
           show_modal_dialog_warning(title='ERROR', errorThrown);
           //alert('Error ajax data');
        }
    });   
}

function save_kontrak() {
    var nik            = $('#nik').val();
    var tgleffektif    = $('#tgleffektif').val();
    var jenismutasival = $('#jenismutasival').val();
    var remark         = $('#remark').val();
    var lamakontrak    = $('#lamakontrak').val();

    $.ajax({
        url : "<?php echo site_url('karyawan/penyesuaian_karyawan/ajax_save_kontrak/')?>/?nik="+nik+"&jenismutasival="+jenismutasival+"&tglefektif="+tgleffektif+"&remark="+remark+"&lamakontrak="+lamakontrak,
        type: "GET",     
              
        success: function(data)
        {                       
            var res    = data.split("|");
            var error  = res[0];
            var errmsg = res[1];
            alert(errmsg);
            if(error){
            } else {
                ResetForm();
            }
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
           //show_modal_dialog_warning(title='ERROR', 'Mohon dicoba kembali...');
           show_modal_dialog_warning(title='ERROR', errorThrown);
           //alert('Error ajax data');
        }
    });   
}


function ResetForm(){
    $('#divloaddata').html('');
}


function get_divisi() {
    var company    = $('#company').val();
    $.ajax({
        url : "<?php echo site_url('report/report_karyawan_masuk/get_divisi/')?>/"+company,
        type: "GET", 
        dataType: "JSON",           
        success: function(data)
        {                
            
            
            $('#department').empty();
            $('#department').append('<option value="0" disabled selected>- Pilih Department -</option>');

            $('#divisi').empty();
            $('#divisi').append('<option value="0" disabled selected>- Pilih Divisi -</option>');
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
}


function get_dept() {
    var divisi    = $('#divisi').val();
    $.ajax({
        url : "<?php echo site_url('report/report_karyawan_masuk/get_dept/')?>/"+divisi,
        type: "GET", 
        dataType: "JSON",           
        success: function(data)
        {                
            
            $('#department').empty();
            $('#department').append('<option value="0" disabled selected>- Pilih Department -</option>');
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
}


function get_lamakontrak(nik,statuspkwt) {    
    $.ajax({
        url : "<?php echo site_url('karyawan/penyesuaian_karyawan/get_lamakontrak/')?>/"+nik+"/"+statuspkwt,
        type: "GET", 
        dataType: "JSON",           
        success: function(data)
        {                
            
            $('#lamakontrak').empty();
            $('#lamakontrak').append('<option value="0"  selected="">- Pilih Lama Kontrak -</option>');
            $.each(data,function(key, value)
            {
                $('#lamakontrak').append('<option value=' + value.value + '>' + value.property + '</option>'); // return empty
            });
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
           //show_modal_dialog_warning(title='ERROR', 'Mohon dicoba kembali...');
           show_modal_dialog_warning(title='ERROR', errorThrown);
           //alert('Error ajax data');
        }
    });
}

function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

 return true;
}

function check_endkontrak(){
    var lamakontrak    = $('#lamakontrak').val();
    var tglendkontrak  = $('#tgleffektif').val();
    var nik            = $('#nik').val();
    
    $.ajax({
        url : "<?php echo site_url('karyawan/penyesuaian_karyawan/check_endkontrak/')?>/?lamakontrak="+lamakontrak+"&tglendkontrak="+tglendkontrak+"&nik="+nik,
        type: "GET",                 
        success: function(data)
        {       
            var res    = data.split("|");
            var error  = res[0];
            var errmsg = res[1];

            if(error){
                alert(errmsg);
                $('#tgleffektif').val('');
            }                          
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
           //show_modal_dialog_warning(title='ERROR', 'Mohon dicoba kembali...');
           alert('ERROR ( '+errorThrown+ ' )');
           //alert('Error ajax data');
        }
    });
}

function setendkontrak(){
    var lamakontrak    = $('#lamakontrak').val();
    var nik            = $('#nik').val();

    $.ajax({
        url : "<?php echo site_url('karyawan/penyesuaian_karyawan/set_endkontrak/')?>/?lamakontrak="+lamakontrak+"&nik="+nik,
        type: "GET",                 
        success: function(data)
        {       
            var res    = data.split("|");
            var error  = res[0];
            var hasil = res[1];

            if(error){
                alert(hasil);
                $('#tgleffektif').val('');
            } else {
                $('#tgleffektif').val(hasil);        
            }     

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
           //show_modal_dialog_warning(title='ERROR', 'Mohon dicoba kembali...');
           alert('ERROR ( '+errorThrown+ ' )');
           //alert('Error ajax data');
        }
    });
}

function get_datakontrak() {
    var nik    = $('#nik').val();
    $.ajax({
        url : "<?php echo site_url('karyawan/penyesuaian_karyawan/get_datakontrak/')?>/"+nik,
        type: "GET", 
        dataType: "JSON",           
        success: function(data)
        {                
            $('#divcontractbeforePKWT1').html(data.KontrakPKWT1);
            $('#divcontractbeforePKWT2').html(data.KontrakPKWT2);
            $('#divcontractbefore').html(data.KontrakCur);
            $('#divstatuspkwt').html(data.statuspkwt);
            
            setTimeout(get_lamakontrak(nik,data.statuspkwt), 1000);
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
           //show_modal_dialog_warning(title='ERROR', 'Mohon dicoba kembali...');
           show_modal_dialog_warning(title='ERROR', errorThrown);
           //alert('Error ajax data');
        }
    });
}



</script>