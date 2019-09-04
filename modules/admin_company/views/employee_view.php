<style type="text/css">
    #flex1 a.image-thumbnail img{
        max-width:200px;
        width: 50px;
        height: 50px;
    }
    .container {
        width: 100%;
    }
    #flex1 td {
        vertical-align: middle !important;
    }

    .fa-spin-custom, .glyphicon-spin {
    -webkit-animation: spin 1000ms infinite linear;
    animation: spin 1000ms infinite linear;
    }
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }
    }
    @keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }
    }

    dd{
        font-size: 11px;
    }

    #back_button{
        display: none;
    }
    .edit-icon{
        display: none !important;
    }

    .full-screen {
        width: 100% !important;
        height: 100% !important;
        margin: 0;
        top: 0;
        left: 0;
    }

</style>

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$today_print = date('Y_m_d_H_i_s');
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
    $this->load->view('dependent_dropdown', $dropdown_setup);
}

?>

<script type="text/javascript">

var save_method;
var table;
var primary_key;
var base_url = '<?php echo base_url();?>';
var user_session;

/*
$(document).ready(function(){    

    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
});
*/

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

    user_session = user_nik;

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


function push_export_resume(){

    location.href = base_url+'/includes/printer/prt_frmMyCV.php?nik='+user_session;
            
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

<script type="text/javascript">

$(function () {
    // $('#myModal').modal('hide');
});

document.getElementById("btnPrint__").onclick = function () {
    printElement(document.getElementById("clonetext"));
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);

    var $printSection = document.getElementById("printSection");

    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }


    $printSection.innerHTML = "";

    $printSection.appendChild(domClone);
  
    var today      = '<?php echo $today_print; ?>';
    document.title = 'RESUME_'+today;
    window.print();

}

</script>

<div class="modal" id="modal_form_mutation_employee" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="#" id="form_mutation_employee" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail Pergerakan Karyawan</h4>
            </div>
            <div class="modal-body form">
                <input type="hidden" name="hrd_nik" value=""/>                
                    
                    <input type="hidden" name="primary_key" />
                    <div class="form-group" id="nik-lama-preview">
                        <label class="control-label col-md-3">NIK Lama</label>
                        <div class="col-md-9">
                                <select name="nik_lama" data-live-search="true" class="selectpicker show-tick form-control" data-show-subtext="true" data-container="body" data-width="100%" data-size="10" data-header="Pilih Karyawan">
                                <?php

                                $SQL    = "SELECT NIK,Nama,Email FROM tbl_profile WHERE bStatus=1";
                                $query  = $this->db->query($SQL);

                                    echo '<option data-subtext="" selected="selected" value="">Pilih Karyawan</option>';

                                foreach($query->result() as $data){
                                    echo '<option data-subtext="'.$data->NIK.'" value="'.$data->NIK.'">'.$data->Nama.'</option>';
                                }
                                ?>          
                                </select>
                        </div>       
                    </div>

                    <div class="form-group" id="nik-baru-preview">
                        <label class="control-label col-md-3">NIK Baru</label>
                        <div class="col-md-9">
                            <input name="nik_baru" placeholder="dalam angka" class="form-control numeric" type="text">
                        </div>     
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Join Date</label>
                        <div class="col-md-9">
                            <input name="join_date" placeholder="dd/mm/yyyy" class="form-control datepicker-input" type="text">
                            <span class="help-block">Tanggal Mulai bergabung dengan NIK baru</span>
                        </div>                        
                    </div>

                    <div class="form-group" id="nik-lama-preview">
                        <label class="control-label col-md-3">Pergerakan Mutasi</label>
                        <div class="col-md-9">
                                <select name="mutasi_id" data-live-search="false" class="selectpicker show-tick form-control" data-show-subtext="true" data-container="body" data-width="100%" data-size="10">
                                <?php

                                $SQL    = "SELECT mutasi_id,mutasi_name FROM tbl_master_pergerakan_mutasi WHERE status=1";
                                $query  = $this->db->query($SQL);                                    

                                foreach($query->result() as $data){
                                    echo '<option data-subtext="" value="'.$data->mutasi_id.'">'.$data->mutasi_name.'</option>';
                                }
                                ?>          
                                </select>
                        </div>       
                    </div>


                    <div class="alert alert-success alert-dismissible">               
                        <dl>
                            <dt>Data apa saja yang digenerate oleh Sistem ?</dt>
                            <dd>Profile karyawan yang mencakup semua Resume (CV).</dd>
                            <dd>Sisa cuti yang terakhir tanpa sejarah cuti.</dd>

                            <dt>Data apa saja yang diperbaharui oleh Sistem ?</dt>
                            <dd>Status karyawan dengan NIK lama akan dinonaktifan.</dd>
                            <dd>Mengganti NIK lama menjadi NIK baru pada <strong>akun login</strong> disemua aplikasi yg terintegrasi dengan HRIS.</dd>                           
                        </dl>
                     </div>                        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancel</button>
                <button type="button" class="btn btn-primary btn-flat pull-left" onclick="btn_mutation_save()"><i class="glyphicon glyphicon-floppy-disk"></i> Process</button>                
            </div>
        </form>
        </div>
    </div>
</div>



<div class="modal" id="modal_form_mutation_history" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="#" id="form_mutation_employee" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail Pergerakan Karyawan</h4>
            </div>
            <div class="modal-body">                   
                    
                    
                    <div class="form-group" id="nik-karyawan">
                        
                        <div class="col-md-12">
                                <select name="nik_karyawan" onchange="show_sejarah_mutasi(this.value)" data-live-search="true" class="selectpicker show-tick form-control" data-show-subtext="true" data-container="body" data-width="100%" data-size="10" data-header="Pilih Karyawan">
                                <?php

                                $SQL    = "SELECT NIK,Nama,nama_karyawan,nik_lama,nik_baru FROM tbl_profile_pergerakan_mutasi AS a INNER JOIN tbl_profile AS b ON a.nik_lama=b.NIK GROUP BY a.nama_karyawan";
                                $query  = $this->db->query($SQL);

                                    echo '<option data-subtext="" selected="selected" value="">Pilih Karyawan</option>';

                                foreach($query->result() as $data){
                                    echo '<option data-subtext="" value="'.$data->nama_karyawan.'">'.$data->nama_karyawan.'</option>';
                                }
                                ?>          
                                </select>
                        </div>       
                    </div>

                    <div class="form-history">                                                 
                        
                    </div>                                       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>                
            </div>
        </form>
        </div>
    </div>
</div>


<div class="modal" id="modal_form_resume_employee" role="dialog">
    <div class="modal-dialog full-screen">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Employee Resume</h4>
            </div>
            <div class="modal-body" id="clonetext">               
                <div class="form-body">
                    
                </div>                                       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>                
                <button type="button" class="btn btn-primary btn-flat pull-left" onclick="push_print_save()"><i class="glyphicon glyphicon-print"></i> Cetak</button>
                <button type="button" class="btn btn-success btn-flat pull-left" onclick="push_export_resume()"><i class="glyphicon glyphicon-download-alt"></i> Export</button>
            </div>        
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