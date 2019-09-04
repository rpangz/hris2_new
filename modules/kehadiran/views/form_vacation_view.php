<style type="text/css">
    .container {
        width: 100% !important;
    }
    .card {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        width: 100%;
        padding: 5px;
    }

    #message:empty{
        display:none;
    }
    #btn-register, .register_input{
        display:none;
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    #__section-content{
      overflow-x: auto;
      overflow-y: hidden;
      padding-bottom:1px;
      padding-right: 2px !important;
      padding-left: 2px !important;
      width: 100% !important;
    }


.ui-datepicker td span, .ui-datepicker td a {
  text-align: center;
}

.ui-widget-content .ui-state-default {
  background: #b3b3b3 url(images/ui-bg_glass_75_e6e6e6_1x400.png) 50% 50% repeat-x;
}

.ui-state-default.ui-state-active {
  background: white url(images/ui-bg_glass_75_e6e6e6_1x400.png) 50% 50% repeat-x;
}

textarea { font-size: 12px !important; }
input { font-size: 12px !important; }
select { font-size: 12px !important; }

li[data-original-index]{
    font-size: small !important;
}

.selectpicker[data-toggle=dropdown]{
    font-size: small !important;
}

.selectpicker.btn-default{
    font-size: small !important;
}


.glyphicon.fast-right-spinner {
    -webkit-animation: glyphicon-spin-r 1s infinite linear;
    animation: glyphicon-spin-r 1s infinite linear;
}

.glyphicon.normal-right-spinner {
    -webkit-animation: glyphicon-spin-r 2s infinite linear;
    animation: glyphicon-spin-r 2s infinite linear;
}

.glyphicon.slow-right-spinner {
    -webkit-animation: glyphicon-spin-r 3s infinite linear;
    animation: glyphicon-spin-r 3s infinite linear;
}

.glyphicon.fast-left-spinner {
    -webkit-animation: glyphicon-spin-l 1s infinite linear;
    animation: glyphicon-spin-l 1s infinite linear;
}

.glyphicon.normal-left-spinner {
    -webkit-animation: glyphicon-spin-l 2s infinite linear;
    animation: glyphicon-spin-l 2s infinite linear;
}

.glyphicon.slow-left-spinner {
    -webkit-animation: glyphicon-spin-l 3s infinite linear;
    animation: glyphicon-spin-l 3s infinite linear;
}

.borderless td, .borderless th {
    border: none !important;
}

@-webkit-keyframes glyphicon-spin-r {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(359deg);
        transform: rotate(359deg);
    }
}

@keyframes glyphicon-spin-r {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(359deg);
        transform: rotate(359deg);
    }
}

@-webkit-keyframes glyphicon-spin-l {
    0% {
        -webkit-transform: rotate(359deg);
        transform: rotate(359deg);
    }

    100% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
}

@keyframes glyphicon-spin-l {
    0% {
        -webkit-transform: rotate(359deg);
        transform: rotate(359deg);
    }

    100% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
}


.tanggal_cuti_list th
{
    padding:0px;
    margin:0px;
    font-size: 12px;
    border-bottom: 3px double #999999 !important;
}

.tanggal_cuti_list td
{
    font-size: 12px;
    padding-bottom: 2px !important;
    padding-top: 2px !important;
    border-bottom: 1px solid #CCCCCC !important;
    border-top: 1px solid #CCCCCC !important;
}

.gi-2x{font-size: 2em;}
.gi-3x{font-size: 3em;}
.gi-4x{font-size: 4em;}
.gi-5x{font-size: 5em;}

.filter-option{
    font-size: small !important;
}

input[readonly] {
     cursor: pointer !important;
}

.onleave-allocation{
    cursor: pointer !important;
}

.hide-me{
    display: none !important;
}
.status-default{
    background-color: #33bbff !important;
}

.breadcrumb .nav-cuti{
    display: none !important;
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

// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}
//echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);
?>

<script type="text/javascript">
$(document).ready(function(){
    function alignModal(){
        var modalDialog = $(this).find(".modal-dialog");        
        // Applying the top margin on modal dialog to align it vertically center
        modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
    }
    // Align modal when it is displayed
    $(".modal").on("shown.bs.modal", alignModal);    
    // Align modal when user resize the window
    $(window).on("resize", function(){
        $(".modal:visible").each(alignModal);
    });   
});
</script>

<script type="text/javascript">
    $(document).ajaxComplete(function () {

        $('[rel="Detail"]').attr('class','text-right field-sorting');
        $('[rel="TglMasuk"]').attr('class','text-center field-sorting');
        $('[rel="JenisCuti"]').attr('class','text-center field-sorting');
        $('[rel="StatusForm"]').attr('class','text-center field-sorting');

        $('[costum-text="Detail"]').attr('class','text-right');
        $('[costum-text="StatusForm"]').attr('class','text-center');
        $('[costum-text="JenisCuti"]').attr('class','text-center');
        $('[costum-text="TglMasuk"]').attr('class','text-center');       

    });

    function AjaxSendEmailCuti(value){
                $.ajax({
                    "url" : "<?php echo site_url('kehadiran/form_vacation/ajax_submit_send_email/')?>",
                    "type" : "POST",                  
                    "dataType" : "json",                    
                    "success" : function(data){
                        alert(data);
                    },
                    "complete" : function(){                       

                    },
                    error: function(xhr, textStatus, errorThrown){
                        
                    }
                });    
    }


    $(document).ajaxComplete(function(){
        // TODO: Put your custom code here

        $('.void-settlement.crud-action').each(function(){
            if ($(this).attr('href') == 'javascript:void(0)') {
                $(this).hide();
            }               
        });


        $(".void-settlement.crud-action").click(function() {            

            var primary_key = $(this).attr('href'); 

            $('#__modal_void_form_cuti [name="primary_key"]').val(primary_key);
            $('#__modal_void_form_cuti [name="Alasan"]').val('');
            $('#__modal_void_form_cuti').modal({backdrop: 'static'});
            $('#__modal_void_form_cuti').modal('show');
            $('#__modal_void_form_cuti').draggable({handle: '.modal-header'});

            call_remarks_dialog_void();
            
        });


    });

    $(document).ready(function(){

        $('.void-settlement.crud-action').each(function(){
            if ($(this).attr('href') == 'javascript:void(0)') {
                $(this).hide();
            }               
        });

        
        // TODO: Put your custom code here
    })
</script>

<script type="text/javascript">

    var REQUEST_EXISTS = false;
    var REQUEST = "";
    var rowId = 0;
    var DATE_FORMAT = '<?php echo $date_format ?>';
    var base_url = '<?php echo site_url()?>';

    //var DATA_citizen = {update:new Array()};    


    $(document).ready(function(){        

        callback_jumlah_semua_cuti();


        $('input').keyup(function(){
            check_user_exists();
        });     





        $('.datepicker-input').datepicker({            
            dateFormat: 'dd/mm/yy',
            showWidget: true,

            onSelect: function (dateText, value) {
                var data_tanggal = $('[name="<?php echo $secret_code?>detail_cuti"]').val();
                data_post = {
                    'tanggal': data_tanggal,
                    'value': dateText,
                };

                $.ajax({
                    "url" : "<?php echo site_url('kehadiran/form_vacation/check_tanggal_masuk/')?>",
                    "type" : "POST",
                    "data" : data_post,
                    "dataType" : "json",
                    "beforeSend" : function(){                        
                        show_modal_message(title='', content='<i class="glyphicon glyphicon-repeat fast-right-spinner"></i> Mohon tunggu...tanggal sedang divalidasi.','modal modal-danger', '');   
                    },
                    "success" : function(data){

                        if(!data.status){                            
                            hide_modal_message();
                        }
                        else{
                            show_modal_message(title='', content='<i class="glyphicon glyphicon-exclamation-sign"></i> '+data.message,'modal modal-default', '');
                        }

                        check_user_exists();                  
                       
                    },
                    "complete" : function(){                       

                    },
                    error: function(xhr, textStatus, errorThrown){
                        
                    }
                });  


            }

        }).focus(function() {
            $(this).next().trigger('click');
        });


        $('.pilih-tanggal-cuti').datepicker({            
            dateFormat: 'dd/mm/yy',
            showWidget: true,

            onSelect: function (dateText, value) {               

                var data_tanggal = $('[name="<?php echo $secret_code?>detail_cuti"]').val();
                var total_cuti = $('[name="<?php echo $secret_code?>total_form_cuti"]').val();
                var total = $('[name="<?php echo $secret_code?>sisa_cuti_gabungan"]').val();
                var total_date = $('[name="<?php echo $secret_code?>total_form_cuti"]').val();
                var last_number = $('#tanggal_cuti_list tr:last').attr('rowId');
                var sepakat_utang = $('[name="<?php echo $secret_code?>sepakat_utang"]').val();
                var TglMasuk = $('[name="<?php echo $secret_code?>TglMasuk"]').val();

                data_post = {
                    'tanggal': data_tanggal,
                    'value': dateText,
                    'sub_total':total_cuti,
                    'total':total,
                    'sepakat_utang':sepakat_utang,
                    'TglMasuk':TglMasuk,
                };

                if(typeof(last_number)=='undefined' || last_number == ''){
                    rowId = 0;
                }
                else{
                    rowId = last_number;
                }

                rowId = Number(parseInt(rowId)+1);

                $.ajax({
                    "url" : "<?php echo site_url('kehadiran/form_vacation/check_double_date/')?>",
                    "type" : "POST",
                    "data" : data_post,
                    "dataType" : "json",
                    "beforeSend" : function(){                        
                        show_modal_message(title='', content='<i class="glyphicon glyphicon-repeat fast-right-spinner"></i> Mohon tunggu...tanggal sedang divalidasi.','modal modal-danger', '');  
                                     
                    },
                    "success" : function(data){
                        hide_modal_message();

                        if(!data.status){
                            $('#tanggal_cuti_list tbody').append('<tr rowId="'+rowId+'"><td id="rowData">'+dateText+'</td><td><a href="javascript:void(0)" style="color: inherit !important;" title="Hapus #'+rowId+'" onclick="hapus_tanggal('+rowId+')"><i class="glyphicon glyphicon-trash"></i></a><input id="input_td_cuti_'+rowId+'" column_name="AllocationID" type="hidden" value="'+data.hutang+'"/></td></tr>');
                            syncronize_date();                           
                        }
                        else{
                            show_modal_message(title='', content='<i class="glyphicon glyphicon-exclamation-sign"></i> '+data.message,'modal modal-default', '');
                        }                   
                       
                    },
                    "complete" : function(){                       

                    },
                    error: function(xhr, textStatus, errorThrown){
                        
                    }
                });                

                
            }

        }).focus(function() {
            $(this).next().trigger('click');
        });


        $('.selectpicker').selectpicker({style: 'btn-default',size: 'auto'});
        $('.selectpicker').selectpicker('refresh');  
  

    });

    function syncronize_date(){

        var table = $("#tanggal_cuti_list tbody");

        var cutiku ='';
        var keys = [];
        //var DATA_citizen = {update:new Array()};

        table.find('tr').each(function (i, el) {
        var $tds = $(this).find('td'),
            tanggal = $tds.eq(0).text();
        var record_index = $(this).attr('rowId');
            //cutiku += tanggal+',';             
            /*
            keys.push({
            'hak_cuti' : 1,            
            'tanggal' : tanggal,
            }); 
            */

            /*
            DATA_citizen.update.push({
            'record_index' : record_index,            
            'date_key' : js_date_to_php(tanggal),
            'allocation' : 0,
            });
            */

            keys.push(tanggal);       
        // do something with productId, product, Quantity
        });


        //synchronize_citizen();

        
        $('[name="<?php echo $secret_code?>detail_cuti"]').val(JSON.stringify(keys));

        //$('[name="<?php echo $secret_code?>detail_cuti_json"]').val(JSON.stringify(DATA_citizen));

        $('[name="<?php echo $secret_code?>total_form_cuti"]').val(keys.length);

        $('#tanggal_cuti_list .total-label').text('Total cuti '+keys.length+' hari');

        check_user_exists();
    }

    function check_textarea(){
        check_user_exists();
    }

    function check_tanggal_masuk(){
        check_user_exists();
    }

    function check_select_option(){
        check_user_exists();
    }

    function hapus_tanggal(primary_key){

        $('#tanggal_cuti_list [rowId="'+primary_key+'"]').remove();

        syncronize_date();
        check_user_exists();
    }

    function callback_kesepakatan_utang(user_nik){

        hide_modal_message();

        $('#modal_kesepakatan_utang').modal({backdrop: 'static'});
        $('#modal_kesepakatan_utang').modal('show');
        $('#modal_kesepakatan_utang').draggable({handle: '.modal-header'}); 
    }


    function push_add_utang_cuti(value){
        $('[name="<?php echo $secret_code?>sepakat_utang"]').val(value);
        $('#modal_kesepakatan_utang').modal('hide');

                $.ajax({
                    "url" : "<?php echo site_url('kehadiran/form_vacation/ajax_after_term_and_condition/')?>",
                    "type" : "POST",
                    "data" : {"value":value},
                    "dataType" : "json",
                    "beforeSend" : function(){                        
                        show_modal_message(title='', content='<i class="glyphicon glyphicon-repeat fast-right-spinner"></i> Mohon tunggu...pernyataan anda sedang divalidasi.','modal modal-danger', '');                                     
                    },
                    "success" : function(data){
                        hide_modal_message();
                        show_modal_message(title='', content='<i class="glyphicon glyphicon-check"></i> Pernyataan anda sudah diterima. Sekarang klik kembali kalender sesuai tanggal <strong>Cuti Bersama yang ditetapkan oleh Pemerintah</strong>. '+data.message,'modal modal-danger', '');                 

                        window.setTimeout(function (){
                            $("#modal_form_message").modal("hide");
                        }, 9000);                                          
                       
                    },
                    "complete" : function(){                       

                    },
                    error: function(xhr, textStatus, errorThrown){
                        
                    }
                });    
    }


    function btn_order_save(){

        var component = '';
        var list ='';
        var prioritas='';
        var key_days = [];

        var total_cuti = $('[name="<?php echo $secret_code?>total_form_cuti"]').val();
        var detail_cuti = $('[name="<?php echo $secret_code?>detail_cuti"]').val();
        var sisa_cuti_tahunan = $('[name="<?php echo $secret_code?>sisa_cuti_tahunan"]').val();
        var sisa_cuti_besar = $('[name="<?php echo $secret_code?>sisa_cuti_besar"]').val();
        var sisa_cuti_gabungan = $('[name="<?php echo $secret_code?>sisa_cuti_gabungan"]').val();

        detail_cuti = JSON.parse(detail_cuti);

        var table = $("#tanggal_cuti_list tbody");

        var data_post = {            
            'detail_cuti': detail_cuti,
            'total_cuti':total_cuti,           
        };
    
        $.ajax({
            "url" : "<?php echo site_url('kehadiran/form_vacation/check_before_submit/')?>",
            "type" : "POST",
            "data" : data_post,
            "dataType" : "json",
            "beforeSend" : function(){                        
                show_modal_message(title='', content='<i class="glyphicon glyphicon-repeat fast-right-spinner"></i> Mohon tunggu...data sedang diproses.','modal modal-danger', '');                                       
            },

            "success" : function(credo){

                hide_modal_message();

                component += '<table class="table borderless">'+                      
                      '<tbody>'+
                        '<tr>'+
                          '<td width="40%"><strong>Jumlah Cuti</strong></td>'+
                          '<td width="60%">'+total_cuti+' Hari</td>'+                         
                        '</tr>'+
                        '<tr>'+
                          '<td><strong>Detail Cuti (dd/mm/yyyy)</strong></td>';                                 

                component += '<td>:</td>';                       
                component += '</tr>';
                component += '<tr>';
                component += '<td colspan="2">';

                component += '<table class="table table-striped table-bordered" id="detail_alokasi_cuti" style="font-size:small">';
                component += '<thead style="border-bottom:3px solid gray">';

                component += '<tr>'+
                                '<th>Hari</th>'+
                                '<th>Tanggal</th>';

                component += '<th>Alokasi Cuti</th>';

                component += '</tr>';

                component += '</thead>';

                component += '<tbody>';
                

                table.find('tr').each(function (i, el) {
                var $tds = $(this).find('td'),
                    tanggal = $tds.eq(0).text();
                var record_index = $(this).attr('rowId');                

                var allocation = $('#input_td_cuti_'+record_index).val();

                var selected = '';
                

                    component +='<tr>'+
                                '<td width="30%">'+get_name_day(tanggal)+'</td>'+
                                '<td width="30%">'+tanggal+'</td>'+
                                '<td>';

                    component +='<select class="form-control selectpicker onleave-allocation" id="onleave_allocation_'+record_index+'" name="onleave_allocation_'+record_index+'" onchange="onleave_allocation_select('+record_index+')">';                    
                    
                var arr = [
                            {"type":0,"title":"Hutang"},                            
                            {"type":1,"title":"Tahunan"},
                            {"type":2,"title":"Besar"},
                        ];

                component +='<option record_index="'+record_index+'" value="" disabled selected="selected">Pilih opsi</option>';
                $.each(arr, function (key,rows) {
                        
                    component +='<option record_index="'+record_index+'" value="'+rows['type']+'">'+rows['title']+'</option>';                        
                
                });



                    component +='</select>';
                            

                    component +='</td>'+
                              '</tr>';

                
                    
                });


                component += '</tbody>';
                component += '</table>';

                component += '</td>';                                     
                component += '</tr>';                      
                component += '</tbody>';
                component += '</table>';

                component += '<input type="hidden" name="jumlah_cuti" id="jumlah_cuti" value="'+total_cuti+'" placeholder="jumlah_cuti"/>';

                component +='<div class="alert alert-danger" id="message_before_submit" style="display:none;"></div>';

                $('#modal_before_submit .modal-body').html(component);
                $('#modal_before_submit').modal({backdrop: 'static'});
                $('#modal_before_submit').modal('show');
                $('#modal_before_submit').draggable({handle: '.modal-header'});

                $("#modal_before_submit .selectpicker").selectpicker({});

                validation_synchronize_citizen();

                
            },
            error: function(xhr, textStatus, errorThrown){
                
            }
        });                


    }


    function onleave_allocation_select(record_index){
        
        var column_name = 'allocation';       

        //var alokasi = $('#modal_before_submit [name="onleave_allocation_'+record_index+'"]').val();

        var value = $('#modal_before_submit [name="onleave_allocation_'+record_index+'"] option:selected').val();

        $('#input_td_cuti_'+record_index).val(value);

        //alert(value);
        force_synchronize(record_index, column_name='allocation', value);

        
        show_before_submit();
    }


    function show_before_submit(){

        var message ='';
        var error   = false;
        var priority=0;

        var sisa_cuti_tahunan = $('[name="<?php echo $secret_code?>sisa_cuti_tahunan"]').val();
        var sisa_cuti_besar = $('[name="<?php echo $secret_code?>sisa_cuti_besar"]').val();
        var sisa_cuti_gabungan = $('[name="<?php echo $secret_code?>sisa_cuti_gabungan"]').val();
        var total_cuti = $('[name="<?php echo $secret_code?>total_form_cuti"]').val();


        var AllocationID = false;
        $('#tanggal_cuti_list tbody [column_name="AllocationID"]').each(function(){
            if ($(this).val() == "") {
                AllocationID = true;
            }
        }); 


        var tahunan = 0;
        $('#tanggal_cuti_list tbody [column_name="AllocationID"]').each(function(){
            if ($(this).val() == "1") {
                
                tahunan++;
            }
        });


        var besar = 0;
        $('#tanggal_cuti_list tbody [column_name="AllocationID"]').each(function(){
            if ($(this).val() == "2") {
                
                besar++;
            }
        });


        var hutang = 0;
        $('#tanggal_cuti_list tbody [column_name="AllocationID"]').each(function(){
            if ($(this).val() == "0") {
                
                hutang++;
            }
        });


        var check_value = [{"tahunan":tahunan,"besar":besar}];

        if(tahunan >0 && besar <=0){
            priority = 1;
        }
        else if(tahunan <=0 && besar > 0){
            priority = 2;
        }
        else if(tahunan > 0 && tahunan > besar){
            priority = 1;
        }
        else if(besar > 0 && besar > tahunan){
            priority = 2;
        }
        else if(besar > 0 && tahunan > 0 && besar==tahunan){
            priority = 1;
        }


        if (AllocationID){
            message = 'Silahkan pilih alokasi cutinya';
            error   = true;
            $('#modal_before_submit #btn_submit_form').hide();
            $('#modal_before_submit #btn_submit_form').attr('disabled', 'disabled');  
        }
        else if (tahunan > sisa_cuti_tahunan){
            message = 'Alokasi cuti tahunan melebihi sisa cuti tahunan anda';
            error   = true;
            $('#modal_before_submit #btn_submit_form').hide();
            $('#modal_before_submit #btn_submit_form').attr('disabled', 'disabled');  
        }
        else if (besar > sisa_cuti_besar){
            message = 'Alokasi cuti besar melebihi sisa cuti besar anda';
            error   = true;
            $('#modal_before_submit #btn_submit_form').hide();
            $('#modal_before_submit #btn_submit_form').attr('disabled', 'disabled');  
        }
        else if(total_cuti <=0){
            message = 'Silahkan pilih tanggal cuti anda';
            error   = true;
            $('#modal_before_submit #btn_submit_form').hide();
            $('#modal_before_submit #btn_submit_form').attr('disabled', 'disabled'); 
        }
        else {
            message = '';
            error   = false;
            $('#modal_before_submit #btn_submit_form').show();
            $('#modal_before_submit #btn_submit_form').removeAttr('disabled');
            console.log($('#modal_before_submit #btn_submit_form'));                       
        }

        if(error){
            $('#modal_before_submit #message_before_submit').show();
            $('#modal_before_submit #message_before_submit').html(message);
        }
        else{
            $('#modal_before_submit #message_before_submit').hide();
        }

        $('#form_order [name="<?php echo $secret_code?>prioritas_cuti"]').val(priority);
    }

    function force_synchronize(record_index, column_name, value){

        /*
        var record_index_found = false;

        for(var i=0; i<DATA_citizen.update.length; i++){
            if(DATA_citizen.update[i].record_index == record_index){
                record_index_found = true;
                // edit value
                eval('DATA_citizen.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                       
                break;
            }
        }
        */

        synchronize_citizen();
    }

    function synchronize_citizen(){

        var table = $("#tanggal_cuti_list tbody");
        var DATA_citizen = {update:new Array()};

        table.find('tr').each(function (i, el) {
        var $tds = $(this).find('td'),
            tanggal = $tds.eq(0).text();
        var record_index = $(this).attr('rowId');
        var allocation = $('#input_td_cuti_'+record_index).val();

            DATA_citizen.update.push({
            'record_index' : record_index,            
            'date_key' : js_date_to_php(tanggal),
            'allocation' : allocation,
            });     
            // do something with productId, product, Quantity
        });

        $('[name="<?php echo $secret_code?>detail_cuti_json"]').val(JSON.stringify(DATA_citizen));
    }


    function validation_synchronize_citizen(){

        var total_cuti = $('[name="<?php echo $secret_code?>total_form_cuti"]').val();
        var detail_cuti = $('[name="<?php echo $secret_code?>detail_cuti"]').val();
        var sisa_cuti_tahunan = $('[name="<?php echo $secret_code?>sisa_cuti_tahunan"]').val();
        var sisa_cuti_besar = $('[name="<?php echo $secret_code?>sisa_cuti_besar"]').val();
        var sisa_cuti_gabungan = $('[name="<?php echo $secret_code?>sisa_cuti_gabungan"]').val();

        var table = $("#tanggal_cuti_list tbody");       

        table.find('tr').each(function (i, el) {
        var $tds = $(this).find('td'),
            tanggal = $tds.eq(0).text();
        var record_index = $(this).attr('rowId');
        var allocation = $('#input_td_cuti_'+record_index).val();
            

            if(allocation == 0 && allocation !=''){
                $('#modal_before_submit [name="onleave_allocation_'+record_index+'"] option[value=""]').remove();
                $('#modal_before_submit [name="onleave_allocation_'+record_index+'"] option[value!="0"]').remove();                
            }

            else if(sisa_cuti_tahunan <=0){
                $('#modal_before_submit [name="onleave_allocation_'+record_index+'"] option[value="0"]').remove();
                $('#modal_before_submit [name="onleave_allocation_'+record_index+'"] option[value="1"]').remove(); 
            }

            else if(sisa_cuti_besar <=0){
                $('#modal_before_submit [name="onleave_allocation_'+record_index+'"] option[value="0"]').remove();
                $('#modal_before_submit [name="onleave_allocation_'+record_index+'"] option[value="2"]').remove(); 
            }
            else{
                $('#modal_before_submit [name="onleave_allocation_'+record_index+'"] option[value="0"]').remove(); 
            }


            if(allocation == 1){
                $('#modal_before_submit [name="onleave_allocation_'+record_index+'"] option[value="1"]').prop("selected", true);
            }
            if(allocation == 2){
                $('#modal_before_submit [name="onleave_allocation_'+record_index+'"] option[value="2"]').prop("selected", true);
            }           
                   
            
        });

        $('#modal_before_submit .selectpicker').selectpicker('refresh');

        show_before_submit();
    }

    function js_date_to_php(js_date){

        if(typeof(js_date)=='undefined' || js_date == ''){
            return '';
        }
        var date = '';
        var month = '';
        var year = '';
        var php_date = '';
        
        var date_array = js_date.split('/');
        day = date_array[0];
        month = date_array[1];
        year = date_array[2];
        php_date = year+'-'+month+'-'+day;
        
        return php_date;
    }

    function get_name_day(tanggal) {

        var tanggal = js_date_to_php(tanggal);

        var A = new Date(tanggal);
        var weekdays = new Array(7);
        weekdays[0] = "Minggu";
        weekdays[1] = "Senin";
        weekdays[2] = "Selasa";
        weekdays[3] = "Rabu";
        weekdays[4] = "Kamis";
        weekdays[5] = "Jumat";
        weekdays[6] = "Sabtu";
        var r = weekdays[A.getDay()];
        return r;
    }


    function get_name_day_sql(tanggal) {

        var A = new Date(tanggal);
        var weekdays = new Array(7);
        weekdays[0] = "Minggu";
        weekdays[1] = "Senin";
        weekdays[2] = "Selasa";
        weekdays[3] = "Rabu";
        weekdays[4] = "Kamis";
        weekdays[5] = "Jumat";
        weekdays[6] = "Sabtu";
        var r = weekdays[A.getDay()];
        return r;
    }


    function check_user_exists(){

        var Keperluan =  $('[name="<?php echo $secret_code?>Keperluan"]').val();
        var Alamat = $('[name="<?php echo $secret_code?>Alamat"]').val();
        var NoTelpon = $('[name="<?php echo $secret_code?>NoTelpon"]').val();
        var NIKPengganti = $('[name="<?php echo $secret_code?>NIKPengganti"]').val();
        var NIK1 = $('[name="<?php echo $secret_code?>NIK1"]').val();
        var NIK2 = $('[name="<?php echo $secret_code?>NIK2"]').val();
        var NIK3 = $('[name="<?php echo $secret_code?>NIK3"]').val();        
        var TglMasuk = $('[name="<?php echo $secret_code?>TglMasuk"]').val();
        var detail_cuti = $('[name="<?php echo $secret_code?>detail_cuti"]').val();
        var total_cuti = $('[name="<?php echo $secret_code?>total_form_cuti"]').val();
        var total = $('[name="<?php echo $secret_code?>sisa_cuti_gabungan"]').val();
        var sepakat_utang = $('[name="<?php echo $secret_code?>sepakat_utang"]').val();


        var data_post = { 
            'Keperluan': Keperluan,           
            'Alamat': Alamat,
            'NoTelpon': NoTelpon,
            'NIKPengganti': NIKPengganti,
            'NIK1': NIK1,
            'NIK2': NIK2,
            'NIK3': NIK3,
            'TglMasuk': TglMasuk,
            'detail_cuti': detail_cuti,
            'total_cuti':total_cuti,
            'total':total,
            'sepakat_utang':sepakat_utang,
        };


        $("#img_ajax_loader").show();
        if(REQUEST_EXISTS){
            REQUEST.abort();
        }
        REQUEST_EXISTS = true;
        REQUEST = $.ajax({
            "url" : "<?php echo site_url('kehadiran/form_vacation/check_registration/')?>",
            "type" : "POST",
            "data" : data_post,
            "dataType" : "json",
            "success" : function(data){

                if(!data.error && Keperluan !='' && Alamat !='' && NoTelpon !='' && TglMasuk !=''){
                    $('input[name="register"]').show();
                    $('input[name="register"]').removeAttr('disabled');
                    console.log($('input[name="register"]'));
                }                

                else{
                    $('input[name="register"]').hide();
                    $('input[name="register"]').attr('disabled', 'disabled');
                }

                // get message from server + local check
                var message = '';
                if(data.message!=''){
                    message += data.message+'<br />';
                }

                $("#message").attr('class', 'alert alert-danger');

                if(message != $('#message').html()){
                    $('#message').html(message);
                }
                REQUEST_EXISTS = false;
                $("#img_ajax_loader").hide();
            },
            error: function(xhr, textStatus, errorThrown){
                if(textStatus != 'abort'){
                    setTimeout(check_user_exists, 10000);    
                }
            }
        });
    }


    function push_submit_form_cuti(){

        //var prioritas_cuti = $('#modal_before_submit [type="radio"]:checked').val();
        var prioritas_cuti = $('[name="<?php echo $secret_code?>prioritas_cuti"]').val();
        var Keperluan =  $('[name="<?php echo $secret_code?>Keperluan"]').val();
        var Alamat = $('[name="<?php echo $secret_code?>Alamat"]').val();
        var NoTelpon = $('[name="<?php echo $secret_code?>NoTelpon"]').val();
        var NIKPengganti = $('[name="<?php echo $secret_code?>NIKPengganti"]').val();
        var NIK1 = $('[name="<?php echo $secret_code?>NIK1"]').val();
        var NIK2 = $('[name="<?php echo $secret_code?>NIK2"]').val();
        var NIK3 = $('[name="<?php echo $secret_code?>NIK3"]').val();        
        var TglMasuk = $('[name="<?php echo $secret_code?>TglMasuk"]').val();
        var detail_cuti = $('[name="<?php echo $secret_code?>detail_cuti"]').val();
        var detail_cuti_json = $('[name="<?php echo $secret_code?>detail_cuti_json"]').val();
        var total_cuti = $('[name="<?php echo $secret_code?>total_form_cuti"]').val();
        var total = $('[name="<?php echo $secret_code?>sisa_cuti_gabungan"]').val();
        var sepakat_utang = $('[name="<?php echo $secret_code?>sepakat_utang"]').val();


        var data_post = { 
            'Keperluan': Keperluan,           
            'Alamat': Alamat,
            'NoTelpon': NoTelpon,
            'NIKPengganti': NIKPengganti,
            'NIK1': NIK1,
            'NIK2': NIK2,
            'NIK3': NIK3,
            'TglMasuk': TglMasuk,
            'detail_cuti': detail_cuti,
            'detail_cuti_json': detail_cuti_json,
            'total_cuti':total_cuti,
            'total':total,
            'sepakat_utang':sepakat_utang,
            'prioritas_cuti':prioritas_cuti,
        };

        $('#modal_before_submit').modal('hide');

        REQUEST = $.ajax({
            "url" : "<?php echo site_url('kehadiran/form_vacation/ajax_submit_form_cuti/')?>",
            "type" : "POST",
            "data" : data_post,
            "dataType" : "json",
            "beforeSend" : function(){                        
                show_modal_message(title='', content='<i class="glyphicon glyphicon-repeat fast-right-spinner"></i> Mohon tunggu...permohonan cuti anda sedang diproses.','modal modal-danger', '');                     
            },
            "success" : function(data){
                $('.flexigrid').find('.ajax_refresh_and_loading').trigger('click');

                $('input[name="register"]').hide();
                $('input[name="register"]').attr('disabled', 'disabled');

                $('#message').html('<i class="glyphicon glyphicon-check"></i> {{ language:Berhasil...data sudah disimpan, dan email sudah dikirim. }}').attr('class', 'alert alert-success');                 

                $('#form_order')[0].reset();

                $('[name="<?php echo $secret_code?>detail_cuti"]').val('');
                $('[name="<?php echo $secret_code?>total_form_cuti"]').val(0);
                $('[name="<?php echo $secret_code?>sepakat_utang"]').val(0);

                $('#tanggal_cuti_list tbody').empty();
                $('#tanggal_cuti_list .total-label').text('Total cuti 0 hari');

                show_modal_message(title='', content='<i class="glyphicon glyphicon-check"></i> Berhasil...data sudah disimpan, dan email sudah dikirim.','modal modal-success', '');                 

                window.setTimeout(function (){
                    $("#modal_form_message").modal("hide");
                }, 4000);

            },
            error: function(xhr, textStatus, errorThrown){
                
            }
        });
       

    }


    function callback_dialog_detail_cuti(primary_key){

        var trHTML='';   
        var detail_tgl_cuti='';   
        var type;  

        var data_post = { 
            'primary_key': primary_key,          
        };


        REQUEST = $.ajax({
            "url" : "<?php echo site_url('kehadiran/form_vacation/ajax_form_cuti_detail/')?>",
            "type" : "POST",
            "data" : data_post,
            "dataType" : "json",
            "beforeSend" : function(){ 
                show_modal_message(title='', content='<i class="glyphicon glyphicon-repeat fast-right-spinner"></i> Mohon tunggu...konten sedang diproses.','modal modal-danger', '');  
            },
            "success" : function(data){
                hide_modal_message();

                $.each(data.Detail, function (key,value) {  

                    if(value['AllocationId'] == 1 && value['AllocationId'] !==null){
                        type = '(Tahunan)';
                    }
                    else if(value['AllocationId'] == 2 && value['AllocationId'] !==null){
                        type = '(Besar)';
                    }
                    else if(value['AllocationId'] == 0 && value['AllocationId'] !==null){
                        type = '(Hutang)';
                    }
                    else{
                        type = '';
                    }             

                    detail_tgl_cuti += '<p>'+get_name_day_sql(value['TglCuti'])+', '+value['TglCutiInd']+' '+type+'</p>'; 
                       
                });

                if(data.result['Alasan'] == null){
                    var status ='';
                }
                else{
                    var status = data.result['Alasan'];
                }

                if(data.result['JenisCuti'] == 0){
                    var JenisCuti = 'Hutang';
                }
                else{
                    var JenisCuti = data.JenisCuti;
                }


                trHTML +='<table class="table table-hover" style="font-size:12px">'+                    
                    '<tbody>'+
                      '<tr>'+
                        '<td width="35%">NIK / Nama</td>'+
                        '<td width="2%">:</td>'+
                        '<td>'+data.result['FormCutiNIK']+' / '+data.Nama+'</td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Keperluan</td>'+
                        '<td>:</td>'+
                        '<td>'+data.result['Keperluan']+'</td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Alamat</td>'+
                        '<td>:</td>'+
                        '<td>'+data.result['Alamat']+'</td>'+
                      '</tr>'+

                      '<tr>'+
                        '<td>Pengganti</td>'+
                        '<td>:</td>'+
                        '<td>'+data.Pengganti+'</td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>No Telpon</td>'+
                        '<td>:</td>'+
                        '<td>'+data.result['NoTelpon']+'</td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Jenis Cuti</td>'+
                        '<td>:</td>'+
                        '<td>'+JenisCuti+'</td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Tanggal Masuk</td>'+
                        '<td>:</td>'+
                        '<td>'+get_name_day_sql(data.result['TglMasuk'])+', '+data.TglMasuk+'</td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Tanggal Pengajuan</td>'+
                        '<td>:</td>'+
                        '<td>'+data.CreatedTime+'</td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Tanggal Cuti</td>'+
                        '<td>:</td>'+
                        '<td>'+detail_tgl_cuti+'</td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Jumlah Cuti</td>'+
                        '<td>:</td>'+
                        '<td>'+data.Detail.length+' Hari</td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Status Form</td>'+
                        '<td>:</td>'+
                        '<td>'+data.StatusForm+'</td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Alasan</td>'+
                        '<td>:</td>'+
                        '<td>'+status+'</td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Verifikator (HRD)</td>'+
                        '<td>:</td>'+
                        '<td>'+data.Approval1+'</td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Atasan Langsung</td>'+
                        '<td>:</td>'+
                        '<td>'+data.Approval2+'</td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Atasan Lebih Tinggi</td>'+
                        '<td>:</td>'+
                        '<td>'+data.Approval3+'</td>'+
                      '</tr>'+
                    '</tbody>'+
                '</table>';

                $('#modal_cuti_detail .modal-title').html('Detail form pengajuan cuti #'+primary_key);
                $('#modal_cuti_detail .modal-body').html(trHTML);   

                $('#modal_cuti_detail').modal({backdrop: 'static'});
                $('#modal_cuti_detail').modal('show');
                $('#modal_cuti_detail').draggable({handle: '.modal-header'});            

            },
            error: function(xhr, textStatus, errorThrown){
                
            }
        });

    }


    function push_void_advance_settlement(){

        var primary_key = $('#__modal_void_form_cuti [name="primary_key"]').val();
        var Alasan      = $('#__modal_void_form_cuti [name="Alasan"]').val();

        $('#__modal_void_form_cuti').modal('hide');

            $.ajax({
                    "url" : "<?php echo site_url('kehadiran/form_vacation/ajax_save_void_cuti/')?>",
                    "type" : "POST",
                    "data" : {"primary_key":primary_key,"Alasan":Alasan},
                    "dataType" : "json",
                    beforeSend : function(){                        
                        show_modal_message(title='', content='<i class="glyphicon glyphicon-repeat fast-right-spinner"></i> Mohon tunggu...data sedang diproses.','modal modal-default', '');                     
                    },

                    success : function(data){                       

                        if(!data.status){                           
                            show_modal_message(title='', content='<i class="glyphicon glyphicon-remove-sign"></i> Form gagal dibatalkan','modal modal-default', '');                            
                        }
                        else{
                            $('.flexigrid').find('.ajax_refresh_and_loading').trigger('click');                                             
                            show_modal_message(title='', content='<i class="glyphicon glyphicon-ok-sign"></i> Form berhasil dibatalkan','modal modal-default', '');                         
                        }

                        window.setTimeout(function (){
                            $("#modal_form_message").modal("hide");
                        }, 4000);

                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert('Gagal membatalkan form ini');
                    }
            });

    }



    function callback_jumlah_semua_cuti(){


            $.ajax({
                    "url" : "<?php echo site_url('kehadiran/form_vacation/ajax_total_sejarah_cuti/')?>",
                    "type" : "POST",
                    "data" : "",
                    "dataType" : "json",
                    beforeSend : function(){   

                        //show_modal_message(title='', content='<i class="glyphicon glyphicon-repeat fast-right-spinner"></i> Mohon tunggu...konten sedang diproses.','modal modal-default', '');

                    },

                    success : function(data){ 

                        //hide_modal_message();

                        if(data.hutang_cuti > 0){
                            $('#sejarah_hutang_cuti').show();
                            $('#sejarah_hutang_cuti .total_hutang').html(data.hutang_cuti);
                        }
                        else{
                            $('#sejarah_hutang_cuti').hide();
                        }

                        $('.total_gabungan').text(data.total_gabungan);
                        $('.total_tahunan').text(data.total_tahunan);
                        $('.total_besar').text(data.total_besar);

                        if(data.total_gabungan > 0){
                            $('.total_gabungan').switchClass('label-default','label-success');
                        }

                        if(data.total_tahunan > 0){
                            $('.total_tahunan').switchClass('label-default','label-success');
                        }

                        if(data.total_besar > 0){
                            $('.total_besar').switchClass('label-default','label-success');
                        }                    

                    },
                    error: function(xhr, textStatus, errorThrown){
                        
                    }
            });

    }


    function callback_sejarah_cuti_hutang(){

        var component = '';

            $.ajax({
                    "url" : "<?php echo site_url('kehadiran/form_vacation/ajax_sejarah_cuti_hutang/')?>",
                    "type" : "POST",
                    "data" : "",
                    "dataType" : "json",
                    beforeSend : function(){  

                        show_modal_message(title='', content='<i class="glyphicon glyphicon-repeat fast-right-spinner"></i> Mohon tunggu...konten sedang diproses.','modal modal-default', ''); 
 
                    },

                    success : function(data){ 

                        hide_modal_message();

                        component += '<table class="table table-striped">'+
                                    '<thead>'+
                                      '<tr>'+
                                        '<th>Tanggal</th>'+
                                        '<th>Keperluan</th>'+                                    
                                      '</tr>'+
                                    '</thead>'+
                                    '<tbody>';

                        $.each(data.result, function (key,value) {               

                            component +='<tr>'+ 
                                        '<td>'+get_name_day_sql(value.TglCuti)+', '+value.TglCutiInd+'</td>'+ 
                                        '<td>'+value.Keperluan+'</td>'+                                         
                                      '</tr>';
                       
                        });                        

                        $('#modal_sejarah_hutang_cuti .modal-body').html(component);
                        $('#modal_sejarah_hutang_cuti').modal({backdrop: 'static'});
                        $('#modal_sejarah_hutang_cuti').modal('show');
                        $('#modal_sejarah_hutang_cuti').draggable({handle: '.modal-header'});                 

                    },
                    error: function(xhr, textStatus, errorThrown){
                        
                    }
            });

    }


    function call_remarks_dialog(){

        var remarks = $('[name="Remarks"]').val().length;

        if (remarks < 10 || remarks > 50){
            $('#btn_remarks').attr('disabled', 'disabled');
        }
        else{
            $('#btn_remarks').attr('disabled', false);
        }
    }


    function call_remarks_dialog_void(){

        var remarks = $('#__modal_void_form_cuti [name="Alasan"]').val().length;

        if (remarks < 10 || remarks > 50){
            $('#btn_void').attr('disabled', 'disabled');
        }
        else{
            $('#btn_void').attr('disabled', false);
        }
    }

    function php_date_to_js(php_date){
        if(typeof(php_date)=='undefined' || php_date == ''){
            return '';
        }
        var date_array = php_date.split('-');
        var year = date_array[0];
        var month = date_array[1];
        var day = date_array[2];
        if(DATE_FORMAT == 'uk-date'){
            return day+'/'+month+'/'+year;
        }else if(DATE_FORMAT == 'us-date'){
            return month+'/'+date+'/'+year;
        }else if(DATE_FORMAT == 'sql-date'){
            return year+'-'+month+'-'+day;
        }else{
            return '';
        }
    }



</script>

<div id="crud_transportation">
    <div class="col-lg-4">
        <div class="card">
        
            <h4>{{ language:Form Permohonan Cuti Anda }}</h4> 

            <?php
            echo form_open('#', 'class="form form-horizontal" id="form_order"');

            echo form_input(array('name'=>'Keperluan', 'value'=>'', 'class'=>'register_input'));
            echo form_input(array('name'=>'Alamat', 'value'=>'', 'class'=>'register_input'));
            echo form_input(array('name'=>'NoTelpon', 'value'=>'', 'class'=>'register_input'));
            echo form_input(array('name'=>'TglMasuk', 'value'=>'', 'class'=>'register_input'));
            echo form_input(array('name'=>'NIKPengganti', 'value'=>'', 'class'=>'register_input'));
            echo form_input(array('name'=>'NIK1', 'value'=>'', 'class'=>'register_input'));
            echo form_input(array('name'=>'NIK2', 'value'=>'', 'class'=>'register_input'));
            echo form_input(array('name'=>'NIK3', 'value'=>'', 'class'=>'register_input')); 

            echo '<input type="hidden" name="'.$secret_code.'sisa_cuti_tahunan" id="'.$secret_code.'sisa_cuti_tahunan" value="'.$sisa_cuti_tahunan.'" placeholder="sisa cuti tahunan"/>';
            echo '<input type="hidden" name="'.$secret_code.'sisa_cuti_besar" id="'.$secret_code.'sisa_cuti_besar" value="'.$sisa_cuti_besar.'" placeholder="sisa cuti besar"/>';
            echo '<input type="hidden" name="'.$secret_code.'sisa_cuti_gabungan" id="'.$secret_code.'sisa_cuti_gabungan" value="'.$sisa_cuti_gabungan.'" placeholder="sisa cuti gabungan"/>';
            echo '<input type="hidden" name="'.$secret_code.'total_form_cuti" id="'.$secret_code.'total_form_cuti" value="0" placeholder="total cuti yg diajukan"/>';
            echo '<input type="hidden" name="'.$secret_code.'sepakat_utang" id="'.$secret_code.'sepakat_utang" value="0" placeholder="sepakat hutang cuti"/>';
            echo '<input type="hidden" name="'.$secret_code.'prioritas_cuti" id="'.$secret_code.'prioritas_cuti" value="0" placeholder="cuti yg digunakan"/>';
            

            echo '<div class="form-group row">';    
            
            echo '<div class="col-sm-12">';

            echo '<table class="table informasi-cuti">
                      <thead>
                        <tr>
                          <th colspan="2" id="total_gabungan">Total sisa cuti anda <span class="label label-default total_gabungan" style="font-size:12px">'.$sisa_cuti_gabungan.'</span> hari</th>                         
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td width="80%"><strong>Cuti Tahunan</strong></td>
                          <td id="total_tahunan" class="text-right"><span class="label label-default total_tahunan" style="font-size:12px">'.$sisa_cuti_tahunan.'</span></td>                          
                        </tr>
                        <tr>
                          <td><strong>Cuti Besar</strong></td>
                          <td id="total_besar" class="text-right"><span class="label label-default total_besar" style="font-size:12px">'.$sisa_cuti_besar.'</span></td>                         
                        </tr>

                        <tr id="sejarah_hutang_cuti" style="display:none">
                          <td style="font-style:italic"><a href="javascript:void(0)" style="color: inherit; text-decoration: none;" onclick="callback_sejarah_cuti_hutang()">*Hutang cuti yang belum dialokasikan</a></td>
                          <td id="total_hutang" class="text-right"><span class="label label-default total_hutang" style="font-size:12px"></span></td>                         
                        </tr>

                      </tbody>
                    </table>';

            echo '</div>';

           

            echo '</div>';


            echo '<div class="form-group row">';    
            echo '<div class="col-sm-12">';
            echo '<div class="input-group input-group-icon">';
            echo '<span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt" aria-hidden="true"></i></span>';
            //echo form_input($secret_code.'NoTelpon', $NoTelpon, 'id="'.$secret_code.'NoTelpon" placeholder="{{ language:Nomor telpon yg bisa dihubungi selama cuti }}" value="08211321124" class="form-control"');   
            echo '<input type="text" class="form-control" placeholder="{{ language:Nomor telpon yg bisa dihubungi selama cuti }}" value="'.$NoTelpon.'" name="'.$secret_code.'NoTelpon" id="'.$secret_code.'NoTelpon" />';
            echo '</div>';
            echo '</div>'; 
            echo '</div>';

            echo '<div class="form-group row">';    
            echo '<div class="col-sm-12">';
            //echo form_textarea($secret_code.'Keperluan', $Keperluan, 'id="'.$secret_code.'Keperluan" placeholder="{{ language:Keperluan }}" class="form-control mention" rows="3" style="height:80px" onkeyup="check_textarea()" style="color:black !important"');
            echo '<textarea name="'.$secret_code.'Keperluan" id="'.$secret_code.'Keperluan" placeholder="{{ language:Keperluan, minimal 10 karakter }}" class="form-control" rows="4" cols="150" style="height:80px;" style="color:black !important;font-size:small !important;" onkeyup="check_textarea()"></textarea>';

            echo '</div>';
            echo '</div>';


            echo '<div class="form-group row">';    
            echo '<div class="col-sm-12">';
            //echo form_textarea($secret_code.'Alamat', $Alamat, 'id="'.$secret_code.'Alamat" placeholder="{{ language:Alamat selama cuti }}" class="form-control mention" rows="3" style="height:80px" onkeyup="check_textarea()" style="color:black !important"');
            echo '<textarea name="'.$secret_code.'Alamat" id="'.$secret_code.'Alamat" placeholder="{{ language:Alamat selama cuti, minimal 10 karakter }}" class="form-control mention" rows="3" style="height:80px" onkeyup="check_textarea()" style="color:black !important;font-size:small !important">'.$Alamat.'</textarea>';
            echo '</div>';
            echo '</div>';


            echo '<div class="form-group row">';  
            
            echo '<div class="col-sm-7">';
            echo '<p>Klik kalender dibawah <small>(dd/mm/yyyy)</small></p>';
            echo '<div class="pilih-tanggal-cuti"></div>';          

            //echo '</div>';
            echo '<input type="hidden" class="form-control" name="'.$secret_code.'detail_cuti" id="'.$secret_code.'detail_cuti" value="" placeholder="tanggal cuti yg diajukan"/>';
            //echo '<textarea name="'.$secret_code.'detail_cuti" id="'.$secret_code.'detail_cuti" placeholder="{{ language:tanggal cuti yg diajukan }}" class="form-control" rows="4" cols="150" style="height:120px; width:350px" style="color:black !important;font-size:small !important;"></textarea>';

            echo '<textarea name="'.$secret_code.'detail_cuti_json" id="'.$secret_code.'detail_cuti_json" placeholder="{{ language:tanggal cuti yg diajukan }}" class="form-control hide-me" rows="4" cols="150" style="height:120px; width:410px" style="color:black !important;font-size:small !important;"></textarea>';

            echo '</div>';


            echo '<div class="col-sm-5">';
            echo '<input type="hidden" class="form-control" />';
            echo '<table class="table tanggal_cuti_list" id="tanggal_cuti_list">
                      <thead>
                        <tr>                          
                          <th colspan="2" class="total-label">Total cuti 0 hari</th>                                                 
                        </tr>
                      </thead>
                      <tbody>';
                                       
                        
            echo '</tbody>';
            echo '</table>';
            echo '</div>';

            echo '</div>';


            echo '<div class="form-group row">';    
            echo '<div class="col-sm-12">';
            echo '<div class="input-group input-group-icon">';
            echo '<span class="input-group-addon"><i class="glyphicon glyphicon-calendar" aria-hidden="true"></i></span>';
            echo form_input($secret_code.'TglMasuk', $TglMasuk, 'id="'.$secret_code.'TglMasuk" placeholder="{{ language:Tanggal kembali bekerja (dd/mm/yyyy) }}" class="form-control datepicker-input" readonly="readonly" onchange="check_tanggal_masuk()"');   
            echo '</div>';
            echo '</div>'; 
            echo '</div>';


            echo '<div class="form-group row">';    
            echo '<div class="col-sm-12">';
            echo '<div class="input-group input-group-icon">';
            echo '<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>';    
            echo '<select data-live-search="true" class="form-control pengganti-option selectpicker show-tick" name="'.$secret_code.'NIKPengganti" id="'.$secret_code.'NIKPengganti" data-header="{{ language:Pilih Petugas Pengganti }}" data-container="body" data-size="7" data-width="100%" data-show-subtext="true" onchange="check_select_option()">';
            echo '<option value="0" selected disabled>{{ language:Pilih Petugas Pengganti }}</option>';   

            foreach ($semua_karyawan as $key => $value) {

                /*
                if($potential_substitution == $value->NIK){
                    echo '<option value="'.$value->NIK.'" selected="selected" data-subtext="<small>'.$value->NIK.'</small>" >'.$value->Nama.'</option>';
                }
                else{
                    echo '<option value="'.$value->NIK.'" data-subtext="<small>'.$value->NIK.'</small>">'.$value->Nama.'</option>';
                }
                */
                

                echo '<option value="'.$value->NIK.'" data-subtext="<small>'.$value->NIK.'</small>">'.$value->Nama.'</option>';
                 
            }        
            echo '</select>';
            echo '</div>';
            echo '</div>'; 
            echo '</div>';


            echo '<div class="form-group row">';
            echo '<div class="col-sm-12">';
            echo '<div class="input-group">';
            echo '<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>';   
            echo '<select class="form-control hrd-option selectpicker" name="'.$secret_code.'NIK1" id="'.$secret_code.'NIK1" data-show-subtext="true" data-header="{{ language:Pilih Verifikator }}" style="font-size:12px !important" onchange="check_select_option()">';
            //echo '<option value="0" selected disabled>{{ language:Select Verificator }}</option>';    

            foreach ($hrd_data_option as $key => $value) {
                echo '<option value="'.$value->hrd_nik.'" data-subtext="<small>'.$value->hrd_nik.'</small>">'.$value->hrd_name.'</option>';
            }
            echo '</select>';    
            echo '</div>';
            echo '</div>';
            echo '</div>';


            echo '<div class="form-group row">';
            echo '<div class="col-sm-12">';
            echo '<div class="input-group">';
            echo '<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>';   
            echo '<select class="form-control atasana-langsung-option selectpicker" name="'.$secret_code.'NIK2" id="'.$secret_code.'NIK2" data-show-subtext="true" data-header="{{ language:Pilih Atasan Langsung }}" style="font-size:12px !important" onchange="check_select_option()">';
            echo '<option value="0" selected disabled>{{ language:Pilih Atasan Langsung }}</option>';  

            foreach ($atasan_langsung_data_option as $key => $value) {
                echo '<option value="'.$value->NIK.'" data-subtext="<small>'.$value->NIK.'</small>">'.$value->Nama.'</option>';
            }

            echo '</select>';    
            echo '</div>';
            echo '</div>';
            echo '</div>';


            echo '<div class="form-group row">';
            echo '<div class="col-sm-12">';
            echo '<div class="input-group">';
            echo '<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>';   
            echo '<select class="form-control atasan-tinggi-option selectpicker" name="'.$secret_code.'NIK3" id="'.$secret_code.'NIK3" data-show-subtext="true" data-header="{{ language:Pilih Atasan Lebih Tinggi }}" style="font-size:12px !important" onchange="check_select_option()">';
            echo '<option value="0" selected disabled>{{ language:Pilih Atasan Lebih Tinggi }}</option>'; 

            foreach ($atasan_langsung_data_option as $key => $value) {
                echo '<option value="'.$value->NIK.'" data-subtext="<small>'.$value->NIK.'</small>">'.$value->Nama.'</option>';
            }

            echo '</select>';    
            echo '</div>';
            echo '</div>';
            echo '</div>';


            echo '<div class="form-group row"><div class="col-sm-12">';
            echo '<img id="img_ajax_loader" style="display:none;" src="'.base_url('assets/nocms/images/ajax-loader.gif').'" />';
            echo '<div id="message" class="alert alert-danger"></div>';
            echo '<input type="button" name="register" id="btn-register" class="btn btn-primary btn-block btn-lg" style="display:none;" onclick="btn_order_save()" value="'.$register_caption.'">';
            echo '</div></div>';
            echo form_close();
        ?>


        
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            
                <?php echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output); ?> 
            
        </div>                  
    </div>
</div>

<input type="button" name="aa" value="SEEEENNNNNNNNNNNNNNNNNNNNNNNDDDDDDDDDDDDDDDDD" onclick="AjaxSendEmailCuti()"> 

<div class="modal" id="modal_kesepakatan_utang" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" method="post" id="form_kesepakatan_utang" autocomplete="off">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" style="font-weight: bold">Terms and Conditions agreement</h5>
            </div>
            <div class="modal-body form">
                
                <p>Sesuai ketentuan, hutang cuti akan dipotong pada periode hak cuti tahun berikutnya atau ketika hak cuti anda muncul.</p>
                <p>Apakah anda setuju?</p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-flat btn-sm" id="create_new_kasbon" onclick="push_add_utang_cuti(1)"><i class="glyphicon glyphicon-send"></i> Saya Setuju</button>
                <button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal" onclick="push_add_utang_cuti(0)"><i class="glyphicon glyphicon-remove"></i> Tidak Setuju</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal" id="modal_before_submit" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" method="post" id="form_before_submit" autocomplete="off">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" style="font-weight: bold">Konfirmasi ulang form pengajuan cuti</h5>
            </div>
            <div class="modal-body form">
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-flat" disabled="disabled" id="btn_submit_form" onclick="push_submit_form_cuti()" ><i class="glyphicon glyphicon-send"></i> SUBMIT</button>
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> TUTUP</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal" id="modal_cuti_detail" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" style="font-weight: bold">Detail form pengajuan cuti</h5>
            </div>
            <div class="modal-body form">
                
                
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> TUTUP</button>
            </div>            
        </div>
    </div>
</div>


<div class="modal" id="__modal_void_form_cuti" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" style="font-weight: bold">Apakah anda sudah yakin membatalkan form ini?</h5>
            </div>
                       
            <div class="modal-body form">
                <input type="hidden" name="primary_key"/>            
                <textarea id="Alasan" name="Alasan" cols="2" rows="5" class="form-control" placeholder="Tuliskan alasan anda disini, minimal 10 karakter dan maksimal 50 karakter..." onkeyup="call_remarks_dialog_void()"></textarea>                           
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-flat btn-sm" disabled="disabled" id="btn_void" onclick="push_void_advance_settlement()"><i class="glyphicon glyphicon-send"></i> Continue</button>
                <button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancel</button>
            </div>            
        </div>
    </div>
</div>


<div class="modal" id="modal_sejarah_hutang_cuti" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-weight: bold">Hutang cuti yang belum dialokasikan</h4>
            </div>                       
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tutup</button>
            </div>            
        </div>
    </div>
</div>

