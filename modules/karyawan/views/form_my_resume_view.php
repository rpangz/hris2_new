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

$crud = new form_my_resume();
?>

<!-- Main content -->
<link rel="stylesheet" href="{{ base_url }}assets/font-awesome-4.6.3/css/font-awesome.min.css">

<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-2">
          
          <div class="box box-solid" style="border:1px solid #e8e4e3;border-radius: 5px;box-shadow: 5px 5px 5px #888888;">
            
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li class="active" id="tab1"><a href="javascript:void(0);" onclick="get_list('1')"><i class="fa fa-user"></i> My Resume <span class="label label-warning pull-right"><?php echo $crud->count_resume_data(1);?></span></a></li>
                <li id="tab2"><a href="javascript:void(0);" onclick="get_list('2')"><i class="fa fa-building-o"></i> Work Experience <span class="label label-warning pull-right"><?php echo $crud->count_resume_data(2);?></span></a></li>
                <li id="tab3"><a href="javascript:void(0);" onclick="get_list('3')"><i class="fa fa-graduation-cap"></i> Education <span class="label label-warning pull-right"><?php echo $crud->count_resume_data(3);?></span></a></li>
                <li id="tab4"><a href="javascript:void(0);" onclick="get_list('4')"><i class="fa fa-suitcase"></i> Training <span class="label label-warning pull-right"><?php echo $crud->count_resume_data(4);?></span></a></li>
                <li id="tab5"><a href="javascript:void(0);" onclick="get_list('5')"><i class="fa fa-wrench"></i> Technical Skill <span class="label label-warning pull-right"><?php echo $crud->count_resume_data(5);?></span></a></li>
                <li id="tab6"><a href="javascript:void(0);" onclick="get_list('6')"><i class="fa fa-certificate"></i> Certification <span class="label label-warning pull-right"><?php echo $crud->count_resume_data(6);?></span></a></li>
                <li id="tab7"><a href="javascript:void(0);" onclick="get_list('7')"><i class="fa fa-cube"></i> Project History <span class="label label-warning pull-right"><?php echo $crud->count_resume_data(7);?></span></a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
          
        </div>
        <!-- /.col -->
        <div class="col-md-10">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">My Resume</h3>

              

            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              
              <div class="table-responsive">

              
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>



<!-- Modal untuk pencarian struktural -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            
            
            
                
                    
            
            
            
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
<script type="text/javascript">

var save_method;
var table;
var table_id;
var primary_key;


$(document).ready(function(){
    get_list(7);
 });

function edit_person(id){
    save_method = 'update';
    primary_key = id;
    //$('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('organization_mapping/diagram_frame/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            var status = data.Functional;

            var url_edit = "<?php echo site_url('organization_mapping/diagram_frame/table_frame/edit/')?>/"+id;

            if (status == 0){
                var text_status = 'Struktural';
            }
            else{
                var text_status = 'Fungsional';
            }

            if (data.MappingCode2 != null && data.MappingCode2 != ''){
                var mapping_code2 = ', '+data.MappingCode2;
            }
            else{
                var mapping_code2 = '';
            }

            var remarks = '<div class="box-body remarks">'+
              '<dl>'+
                '<dt>{{ language:Full Name Position }} :</dt>'+
                '<dd>'+data.long_name_position+'</dd>'+
                '<dt>{{ language:Organization Unit }} :</dt>'+
                '<dd>'+data.UnitID+'</dd>'+
                '<dt>{{ language:Mapping Code }} :</dt>'+
                '<dd>'+data.MappingCode+' '+mapping_code2+'</dd>'+
                '<dt>{{ language:Officer }} :</dt>'+
                '<dd>'+data.EmployeeName+'</dd>'+
                '<dt>{{ language:Grade (maximum) }} :</dt>'+
                '<dd>'+data.GradeCode+'</dd>'+
              '</dl>'+
            '</div>';


            $('[name="title_txt"]').attr("data-content", remarks);
            $('[name="title_txt"]').text(data.Description);
            $('[name="COID"]').val(data.COID);


            var trHTML = '<select data-live-search="true" class="selectpicker form-control" multiple data-show-subtext="true" data-container="body" data-width="100%" name="PositionID[]" id="PositionID" data-header="{{ language:Select }} {{ language:Position History }}">';
            var no = 1;
            $.each(data.option_position, function (key,value) {
                trHTML +='<option value="'+value.position_name+'" data-subtext="">'+value.position_name +'</option>';
               no++;     
            });
            trHTML += '</select>';

            $('#position_field_struktural').html(trHTML);
            $('#position_field_fungsional').html(trHTML);

            $('.selectpicker').selectpicker({style: 'btn-default',size: 'auto'});
            $('.selectpicker').selectpicker('refresh');

            if (status == 1){

                $('[name="Grade"]').text(data.search_grade);
                $('[name="GradeID"]').val(data.search_grade);

                $('#modal_form_fungsional').modal({backdrop: 'static'});
                $('#modal_form_fungsional').modal('show');
                //$('#modal_form_fungsional').draggable({handle: ".modal-header"});
            }
            else{

                $('[name="Grade"]').text(data.search_grade);
                $('[name="GradeID"]').val(data.search_grade);
                
                $('#modal_form').modal({backdrop: 'static'});
                $('#modal_form').modal('show');
                //$('#modal_form').draggable({handle: ".modal-header"});
            }

            //$('.modal-title').text('{{ language:Searching Talent }} #'+data.COID);
            $('.modal-title').html('{{ language:Searching Talent }} '+text_status+' #'+data.COID+' <i class="fa fa-pencil call-edit" title="edit" onclick="open_diagram_edit()"></i>');

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}


function edit_resume(primary_key, table_id){
    save_method = 'update';
    
    //$('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();



    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('karyawan/form_my_resume/ajax_edit_resume/')?>/"+primary_key+"/"+table_id,
        type: "GET",
        /*dataType: "JSON",*/
        success: function(html)
        { 

            $('#modal_form').modal({backdrop: 'static'});
            $('#modal_form').modal('show');

            $('.modal-content').html(html);
            mutate_field_config();            
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function add_resume(id,keys){
    save_method = 'add';
    primary_key = id;
    //$('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('karyawan/form_my_resume/ajax_add_resume/')?>/"+id,
        type: "POST",
        /*dataType: "JSON",*/
        success: function(html)
        {
                      
            $('#modal_form').modal({backdrop: 'static'});
            $('#modal_form').modal('show');       

            $('.modal-content').html(html);

            mutate_field_config();
           
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}



function get_list(id){
    save_method = 'update';
    table_id = id;
    
    $('.box li').removeClass('active');
    $('.help-block').empty();

    $("#tab"+id).addClass("active");

    $('.box-title').html(set_box_title(id));

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('karyawan/form_my_resume/ajax_get_list/')?>/"+id,
        type: "GET",
        /*dataType: "JSON",*/
        success: function(html)
        {
            
            $('.table-responsive').html(html);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}




function delete_resume(id)
{
    if(confirm('Apakah anda yakin untuk menghapus data ini ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('karyawan/form_my_resume/resume_delete')?>",
            type: "POST",
            data : {primary_key:id,table:table_id},
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                //$('#modal_form').modal('hide');

                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

function set_box_title(id){

    if (id==1){
        return 'My Resume';
    }
    else if(id==2){
        return 'Work Experience';
    }
    else if(id==3){
        return 'Education';
    }
    else if(id==4){
        return 'Training';
    }
    else if(id==5){
        return 'Technical Skill';
    }
    else if(id==6){
        return 'Certification';
    }
    else if(id==7){
        return 'Project History';
    }
    else{
        return '-';
    }

}


function save_resume(id){

    //$('#btnSave').text('saving...'); 
    //$('#btnSave').attr('disabled',true); 
    
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('karyawan/form_my_resume/insert_resume/')?>/"+id;
    } else {
        url = "<?php echo site_url('karyawan/form_my_resume/update_resume/')?>/"+id;
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status)
            {
                $('#modal_form').modal('hide');
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
            
            //$('#btnSave').text('save');
            //$('#btnSave').attr('disabled',false);

            get_list(id);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); 
            $('#btnSave').attr('disabled',false); 

        }
    });
}

function open_diagram_edit(){
    var url_edit = "<?php echo site_url('organization_mapping/diagram_frame/table_frame/edit/')?>/"+primary_key;
    location.href = url_edit;
}



function mutate_field_config(){
        // datepicker-input
        $('#modal_form .datepicker-input').datepicker({
                dateFormat: 'd/mm/yy',
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-200:c+200",
        });       

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


<script type="text/javascript">

    $(".modal-dialog").draggable({
        handle: ".modal-header"
    });

    $(".modal-dialog").draggable({
        handle: ".modal-header"
    });

    $('#TrainingID').change(function(){
        if($(this).attr('checked')){
            $(this).val(1);
        }else{
            $(this).val(0);
        }
    });

</script>

<style type="text/css">
    .container {
        width: 100%;
    }
    .big-icon {
        font-size: 18px;
    }

    .fade {
   opacity: 0;
   -webkit-transition: opacity 0.05s linear;
      -moz-transition: opacity 0.05s linear;
       -ms-transition: opacity 0.05s linear;
        -o-transition: opacity 0.05s linear;
           transition: opacity 0.05s linear;
 }

</style>
