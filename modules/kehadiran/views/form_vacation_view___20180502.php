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


</style>

<!--
<link rel="stylesheet" href="https://apps.unias.com/hris2/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css">
<script src="https://apps.unias.com/hris2/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="https://apps.unias.com/hris2/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
-->
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
    $(document).ajaxComplete(function () {

        $('[rel="Detail"]').attr('class','text-right field-sorting');
        $('[rel="TglMasuk"]').attr('class','text-center field-sorting');

        $('[costum-text="Detail"]').attr('class','text-right');
        $('[costum-text="StatusForm"]').attr('class','text-center');
        $('[costum-text="JenisCuti"]').attr('class','text-center');
        $('[costum-text="TglMasuk"]').attr('class','text-center');       

    });

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


    $(document).ready(function(){


        var total_gabungan = $('.total_gabungan').text();
        var total_tahunan = $('.total_tahunan').text();
        var total_besar = $('.total_besar').text();

        if(total_gabungan > 0){
            $('.total_gabungan').switchClass('label-default','label-success');
        }

        if(total_tahunan > 0){
            $('.total_tahunan').switchClass('label-default','label-success');
        }

        if(total_besar > 0){
            $('.total_besar').switchClass('label-default','label-success');
        }


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
                            $('#tanggal_cuti_list tbody').append('<tr rowId="'+rowId+'"><td id="rowData">'+dateText+'</td><td><a href="javascript:void(0)" style="color: inherit !important;" title="Hapus #'+rowId+'" onclick="hapus_tanggal('+rowId+')"><i class="glyphicon glyphicon-trash"></i></a></td></tr>');
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

        table.find('tr').each(function (i, el) {
        var $tds = $(this).find('td'),
            tanggal = $tds.eq(0).text();
            //cutiku += tanggal+',';             
            /*
            keys.push({
            'hak_cuti' : 1,            
            'tanggal' : tanggal,
            }); 
            */   
            keys.push(tanggal);       
        // do something with productId, product, Quantity
        });


        $('[name="<?php echo $secret_code?>detail_cuti"]').val(JSON.stringify(keys));

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

        var total_cuti = $('[name="<?php echo $secret_code?>total_form_cuti"]').val();
        var detail_cuti = $('[name="<?php echo $secret_code?>detail_cuti"]').val();
        var sisa_cuti_tahunan = $('[name="<?php echo $secret_code?>sisa_cuti_tahunan"]').val();
        var sisa_cuti_besar = $('[name="<?php echo $secret_code?>sisa_cuti_besar"]').val();

        detail_cuti = JSON.parse(detail_cuti);

        var data_post = {            
            'detail_cuti': detail_cuti,
            'total_cuti':total_cuti,           
        };

    
        REQUEST = $.ajax({
            "url" : "<?php echo site_url('kehadiran/form_vacation/check_before_submit/')?>",
            "type" : "POST",
            "data" : data_post,
            "dataType" : "json",
            "success" : function(credo){

                component += '<table class="table borderless">'+                      
                      '<tbody>'+
                        '<tr>'+
                          '<td width="40%"><strong>Jumlah Cuti</strong></td>'+
                          '<td width="60%">'+total_cuti+' Hari</td>'+                         
                        '</tr>'+
                        '<tr>'+
                          '<td><strong>Detail Cuti (dd/mm/yyyy)</strong></td>';
    
                        $.each(detail_cuti, function(index, value) {
                            list += '<p>'+get_name_day(value)+', '+value+'</p>';
                        });        
                

                component +='<td>'+list+'</td>'+                          
                                '</tr>'+
                                '<tr>'+
                                  '<td><strong>Prioritas tipe hak cuti yang akan digunakan</strong></td>';
                
                if(sisa_cuti_tahunan > 0){
                    prioritas += '<input type="radio" name="prioritas" id="prioritas_1" checked="checked" value="1"><label for="radio-1">&nbsp;&nbsp; Tahunan</label><br/>';
                }

                if(sisa_cuti_besar > 0 && sisa_cuti_tahunan ==0){
                    prioritas += '<input type="radio" name="prioritas" id="prioritas_2" checked="checked" value="2"><label for="radio-1">&nbsp;&nbsp; Besar</label>';
                }
                else if(sisa_cuti_besar == 0 && sisa_cuti_tahunan ==0){
                    prioritas += '';
                }
                else{
                    prioritas += '<input type="radio" name="prioritas" id="prioritas_2" value="2"><label for="radio-1">&nbsp;&nbsp; Besar</label>';
                }

                if(sisa_cuti_besar == 0 && sisa_cuti_tahunan ==0){
                    prioritas += '<input type="radio" name="prioritas" id="prioritas_3" checked="checked" value="0"><label for="radio-1">&nbsp;&nbsp; Hutang Cuti</label>';
                }
                                  component +='<td>'+prioritas+'</td>'+                          
                                '</tr>'+                        
                              '</tbody>'+
                '</table>';

                component += '<input type="hidden" name="jumlah_cuti" id="jumlah_cuti" value="'+total_cuti+'" placeholder="jumlah_cuti"/>';


                $('#modal_before_submit .modal-body').html(component);
                $('#modal_before_submit').modal({backdrop: 'static'});
                $('#modal_before_submit').modal('show');
                $('#modal_before_submit').draggable({handle: '.modal-header'});

                
            },
            error: function(xhr, textStatus, errorThrown){
                
            }
        });


                

        


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


        var prioritas_cuti = $('#modal_before_submit [type="radio"]:checked').val();
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

                    detail_tgl_cuti += '<p>'+get_name_day_sql(value['TglCuti'])+', '+value['TglCutiInd']+'</p>'; 
                       
                });

                if(data.result['Alasan'] == null){
                    var status ='';
                }
                else{
                    var status = data.result['Alasan'];
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
                        '<td>'+data.JenisCuti+'</td>'+
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
                          <td width="50%"><strong>Cuti Tahunan</strong></td>
                          <td id="total_tahunan" class="text-right"><span class="label label-default total_tahunan" style="font-size:12px">'.$sisa_cuti_tahunan.'</span></td>                          
                        </tr>
                        <tr>
                          <td><strong>Cuti Besar</strong></td>
                          <td id="total_besar" class="text-right"><span class="label label-default total_besar" style="font-size:12px">'.$sisa_cuti_besar.'</span></td>                         
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
            echo form_textarea($secret_code.'Keperluan', $Keperluan, 'id="'.$secret_code.'Keperluan" placeholder="{{ language:Keperluan }}" class="form-control mention" rows="3" style="height:80px" onkeyup="check_textarea()" style="color:black !important"');
            echo '</div>';
            echo '</div>';


            echo '<div class="form-group row">';    
            echo '<div class="col-sm-12">';
            //echo form_textarea($secret_code.'Alamat', $Alamat, 'id="'.$secret_code.'Alamat" placeholder="{{ language:Alamat selama cuti }}" class="form-control mention" rows="3" style="height:80px" onkeyup="check_textarea()" style="color:black !important"');
            echo '<textarea name="'.$secret_code.'Alamat" id="'.$secret_code.'Alamat" placeholder="{{ language:Alamat selama cuti }}" class="form-control mention" rows="3" style="height:80px" onkeyup="check_textarea()" style="color:black !important;font-size:small !important">'.$Alamat.'</textarea>';
            echo '</div>';
            echo '</div>';


            echo '<div class="form-group row">';  
            
            echo '<div class="col-sm-7">';
            echo '<p>Klik kalender dibawah <small>(dd/mm/yyyy)</small></p>';
            echo '<div class="pilih-tanggal-cuti"></div>';          

            //echo '</div>';
            echo '<input type="hidden" class="form-control" name="'.$secret_code.'detail_cuti" id="'.$secret_code.'detail_cuti" value="" placeholder="tanggal cuti yg diajukan"/>';
            //echo '<textarea name="'.$secret_code.'detail_cuti" id="'.$secret_code.'detail_cuti" placeholder="{{ language:tanggal cuti yg diajukan }}" class="form-control" rows="4" cols="150" style="height:120px; width:350px" style="color:black !important;font-size:small !important;"></textarea>';

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
            echo '<select data-live-search="true" class="form-control pengganti-option selectpicker show-tick" name="'.$secret_code.'NIKPengganti" id="'.$secret_code.'NIKPengganti" data-container="body" data-size="7" data-width="100%" data-show-subtext="true" onchange="check_select_option()">';
            echo '<option value="0" selected disabled>{{ language:Select Petugas Pengganti }}</option>';   

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
            echo '<select class="form-control hrd-option selectpicker" name="'.$secret_code.'NIK1" id="'.$secret_code.'NIK1" data-show-subtext="true" data-header="Pilih Verifikator" style="font-size:12px !important" onchange="check_select_option()">';
            echo '<option value="0" selected disabled>{{ language:Select Verificator }}</option>';    

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
            echo '<select class="form-control atasana-langsung-option selectpicker" name="'.$secret_code.'NIK2" id="'.$secret_code.'NIK2" data-show-subtext="true" data-header="Pilih Atasan Langsung" style="font-size:12px !important" onchange="check_select_option()">';
            echo '<option value="0" selected disabled>{{ language:Select Atasan Langsung }}</option>';  

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
            echo '<select class="form-control atasan-tinggi-option selectpicker" name="'.$secret_code.'NIK3" id="'.$secret_code.'NIK3" data-show-subtext="true" data-header="Pilih Atasan Lebih Tinggi" style="font-size:12px !important" onchange="check_select_option()">';
            echo '<option value="0" selected disabled>{{ language:Select Atasan Lebih Tinggi }}</option>'; 

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
                <button type="button" class="btn btn-primary btn-flat" onclick="push_submit_form_cuti()"><i class="glyphicon glyphicon-send"></i> SUBMIT</button>
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