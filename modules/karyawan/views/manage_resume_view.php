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
echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);
?>
<style type="text/css">
	/*.container {
        width: 100%;
    }*/
</style>


<script type="text/javascript">

var save_method;
var table;
var primary_key;
var base_url = '<?php echo base_url();?>';


$(document).ready(function(){    

   $('.numeric').numeric();

});


function callback_mutation_employee(){
    save_method = 'update';
    $('#form_mutation_employee')[0].reset();
    
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin_company/employee/ajax_modal_mutation_employee/')?>/",
        type: "GET",
        dataType: "JSON",
        beforeSend: function(){
            $('.selectpicker').selectpicker('refresh');
            show_modal_dialog_warning(title='<span class="glyphicon glyphicon-refresh glyphicon-spin"></span> Mohon Ditunggu', content='Form Sedang dibuatkan...', 'modal modal-default');          
        },
        success: function(data)
        {
            $(".datepicker-input").datepicker({
                /*showOn: 'focus',*/
                dateFormat: 'dd/mm/yy',
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-100:c+100",
            }).focus();

            $('#modal_form_error').modal('hide');           
            $('#modal_form_mutation_employee .modal-title').text('Form Pergerakan Karyawan');
            $('#modal_form_mutation_employee .form-body').html();                                               
            $('#modal_form_mutation_employee').modal({backdrop: 'static'});
            $('#modal_form_mutation_employee').modal('show');

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $('#modal_form_error #back_button').hide();
            show_modal_dialog_warning(title='<span class="glyphicon glyphicon-remove"></span> Gagal Koneksi', content='Mohon halaman di refresh kembali...', 'modal modal-default');
        }
    });
}


function btn_mutation_save(){
            
    var formData = new FormData($('#form_mutation_employee')[0]);
    var this_container = $(this).closest('.flexigrid');

    $.ajax({
    url : "<?php echo site_url('admin_company/employee/save_callback_mutation_employee/')?>",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    dataType: "JSON",

    beforeSend: function(){
        $('#modal_form_mutation_employee').modal('hide');
        $('#modal_form_error #back_button').hide();
        show_modal_dialog_warning(title='<span class="glyphicon glyphicon-refresh glyphicon-spin"></span> Mohon Ditunggu...', content='Data sedang diproses...','modal modal-warning');  
    },

    success: function(data)
    {   
        if(!data.status){
            $('#modal_form_mutation_employee [name="nik_baru"]').empty();

            $('#modal_form_error #back_button').show();

            show_modal_dialog_warning(title='<span class="glyphicon glyphicon-remove"></span> GAGAL...', content=data.message, 'modal modal-danger');
        }
        else{
            $('#modal_form_error #back_button').hide();

            $('#modal_form_mutation_employee [name="nik_baru"]').empty();
            $('#modal_form_mutation_employee [name="nik_lama"]').empty();

            this_container.find('.ajax_refresh_and_loading').trigger('click');

            show_modal_dialog_warning(title='<span class="glyphicon glyphicon-ok"></span> BERHASIL...', content=data.message, 'modal modal-success');
        }  
        
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        $('#modal_form_error #back_button').hide();
        show_modal_dialog_warning(title='<span class="glyphicon glyphicon-remove"></span> ERROR...', content='Terjadi kesalahan koneksi pada database...', 'modal modal-danger');       
    }
    });

}


function back_modal(){

    $('.selectpicker').selectpicker('refresh');    
  
    $('#modal_form_error').modal('hide');           
    $('#modal_form_mutation_employee .modal-title').text('Form Pergerakan Karyawan');
    $('#modal_form_mutation_employee .form-body').html();                                               
    $('#modal_form_mutation_employee').modal({backdrop: 'static'});
    $('#modal_form_mutation_employee').modal('show');               

}


function show_modal_dialog_warning(title, content, gaya){
    
    $('.form-body').html(content);
    $('#modal_form_error').attr('class', gaya);
    $('#modal_form_error').modal({backdrop: 'static'});
    $('#modal_form_error').modal('show');           

    $('.modal-title').html(title);                

}


function callback_mutation_history(){
    save_method = 'update';    

    $('[name="nik_karyawan"]  option[value=""').prop("selected", true);

    //$('.form-history')[0].reset();
    
    
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin_company/employee/ajax_modal_mutation_employee/')?>/",
        type: "GET",
        dataType: "JSON",
        beforeSend: function(){
            $('.selectpicker').selectpicker('refresh');
            show_modal_dialog_warning(title='<span class="glyphicon glyphicon-refresh glyphicon-spin"></span> Mohon Ditunggu', content='Form Sedang dibuatkan...', 'modal modal-default');          
        },
        success: function(data)
        {
            $('#modal_form_mutation_history .form-history').html('');            

            $('#modal_form_error').modal('hide');           
            $('#modal_form_mutation_history .modal-title').text('Sejarah Pergerakan Mutasi');
            $('#modal_form_mutation_history .form-body').html();                                               
            $('#modal_form_mutation_history').modal({backdrop: 'static'});
            $('#modal_form_mutation_history').modal('show');

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $('#modal_form_error #back_button').hide();
            show_modal_dialog_warning(title='<span class="glyphicon glyphicon-remove"></span> Gagal Koneksi', content='Mohon halaman di refresh kembali...', 'modal modal-default');
        }
    });
}


function show_sejarah_mutasi(nama_karyawan){   

    save_method = 'update';    
    
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin_company/employee/ajax_modal_mutation_history/')?>/"+nama_karyawan,
        type: "GET",
        dataType: "JSON",
        beforeSend: function(){

        },
        success: function(data)
        {

            var trHTML = '<table class="table table-hover" style="font-size:11px">';
                trHTML += '<thead>';
                trHTML += '<tr>';
                trHTML += '<th class="text-center" width="20%">Tanggal</th>';
                trHTML += '<th class="text-center" width="20%">NIK</th>';               
                trHTML += '<th class="text-left">Keterangan</th>';
                trHTML += '</tr>';
                trHTML += '</thead>';

            var no = 1;
            $.each(data.result, function (key,value) {

                trHTML += 
                '<tr>'+
                '<td class="text-center">'+value.TglMasuk+'</td>'+
                '<td class="text-center">'+value.NIK +'</td>'+                
                '<td class="text-left">'+value.mutasi_name+'</td>'+
                '</tr>';
               no++;     
            });


            $('#modal_form_mutation_history .form-history').html(trHTML);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            //$('#modal_form_error #back_button').hide();
            //show_modal_dialog_warning(title='<span class="glyphicon glyphicon-remove"></span> Gagal Koneksi', content='Mohon halaman di refresh kembali...', 'modal modal-default');
        }
    });

}


function callback_resume_form(user_nik){

    $.ajax({
        url : "<?php echo site_url('admin_company/employee/ajax_modal_resume_employee/')?>/"+user_nik,
        type: "GET",
        /*dataType: "JSON",*/
        beforeSend: function(){
            show_modal_dialog_warning(title='<span class="glyphicon glyphicon-refresh glyphicon-spin"></span> Mohon Ditunggu', content='Resume Sedang dibuatkan...', 'modal modal-default');          
        },
        success: function(html)
        {
            $('#modal_form_error').modal('hide');
            $('#modal_form_resume_employee .form-body').html(html);                              
            $('#modal_form_resume_employee .modal-title').text('Employee Resume');                                             
            $('#modal_form_resume_employee').modal({backdrop: 'static'}); 
            $('#modal_form_resume_employee').modal('show');          

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            show_modal_dialog_warning(title='<span class="glyphicon glyphicon-remove"></span> Gagal Koneksi', content='Mohon halaman di refresh kembali...', 'modal modal-default');
        }
    });

}

function push_print_save(){

    printElement(document.getElementById("clonetext"));
            
}

</script>



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


<div class="modal" id="modal_form_resume_edit" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="#" id="form_education_update" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body form">
                <div class="form-body">                                                 
                        
                </div>                                                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
                <button type="button" class="btn btn-primary btn-flat pull-left" onclick="btn_resume_edit_save()"><i class="glyphicon glyphicon-floppy-disk"></i> Submit</button>                
            </div>
        </form>
        </div>
    </div>
</div>


<div class="modal" id="modal_form_resume_add" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="#" id="form_education_insert" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body form">
                <div class="form-body">                                                 
                        
                </div>                                                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
                <button type="button" class="btn btn-primary btn-flat pull-left" onclick="btn_resume_save()"><i class="glyphicon glyphicon-floppy-disk"></i> Submit</button>                
            </div>
        </form>
        </div>
    </div>
</div>



<div class="modal modal-warning" id="modal_form_error" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body form">                                   
                <div class="form-body">                                                 
                        
                </div>                
            </div>

            <div class="modal-footer" id="back_button">
                <button type="button" class="btn btn-default btn-flat" onclick="back_modal()"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
            </div>

        </div>
    </div>
</div>