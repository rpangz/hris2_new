<?php
    $record_index = 0;
    $session_nik  = $_SESSION['NIK'];
    $today        = date('Y-m-d H:i:s');
    $upload_path  = base_url('modules/'.$module_path.'/assets/uploads').'/';   

?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    #md_table_certification input[type="text"]{
        max-width:100%;
    }

    #md_table_certification .chzn-drop input[type="text"]{
        max-width:100%;
    }
    #md_table_certification th:last-child, #md_table_certification td:last-child{
        /*width: 60px;*/
    }
</style>

<div id="md_table_certification_container">
    <div id="no-datamd_table_certification">No data</div>
    <table id="md_table_certification" class="table table-striped table-bordered" style="display:none">
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Product</th>
                <th>Certificate</th>
                <th>Partner Institution</th>
                <th>Valid From</th>
                <th>Valid Until</th>
                <th width="5%"><div align="center">Status <a href="#" style="text-decoration: none;" class="glyphicon glyphicon-question-sign tip-right" data-toggle="tooltip" title="Notifikasi reminder hanya untuk sertifikat yang active"></a></div></th>
                <th colspan="2" width="8%">File Attachment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- the data presentation be here -->
        </tbody>
    </table>
    <div class="fbutton">
        <span id="md_field_certification_add" class="add btn btn-default">
            <i class="glyphicon glyphicon-book"></i> Certification </span>
    </div>
    <br />
    <!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
    <input id="md_real_field_certification_col" name="md_real_field_certification_col" type="hidden" />
</div>

<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/ui/'.grocery_CRUD::JQUERY_UI_JS); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.ui.datetime.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.numeric.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery-ui-timepicker-addon.js'); ?>"></script>
<script type="text/javascript">

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // DATA INITIALIZATION
    //
    // * Prepare some global variables
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    var DATE_FORMAT = '<?php echo $date_format ?>';
    var OPTIONS_certification = <?php echo json_encode($options); ?>;
    var RECORD_INDEX_certification = <?php echo $record_index; ?>;
    var UPLOAD_PATH = '<?php echo $upload_path; ?>';
    var DATA_certification = {update:new Array(), insert:new Array(), delete:new Array()};
    var old_data = <?php echo json_encode($result); ?>;
    for(var i=0; i<old_data.length; i++){
        var row = old_data[i];
        var record_index = i;
        var primary_key = row['CertId'];
        var data = row;
        delete data['CertId'];
        DATA_certification.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }

    console.log(DATA_certification);


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ADD ROW FUNCTION
    //
    // * When "Add certification" clicked, this function is called without parameter.
    // * When page loaded for the first time, this function is called with value parameter
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function add_table_row_certification(value){
        // hide no-data div
        $("#no-datamd_table_certification").hide();
        $("#md_table_certification").show();

        var component = '<tr id="md_field_certification_tr_'+RECORD_INDEX_certification+'" class="md_field_certification_tr">';
        


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertDate"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertDate')){
          field_value = php_date_to_js(value.CertDate);

        }
        component += '<td>';
        component += '<input style="width: 80px;" id="md_field_certification_col_CertDate_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col datetime-input" column_name="CertDate" type="text" value="'+field_value+'"/>';
        component += '</td>';

       
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "Category"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertItem')){
          field_value = value.CertItem;
        }
        component += '<td>';
        component += '<select style="width: 150px !important; min-width: 150px; max-width: 150px;" id="md_field_certification_col_CertItem_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col numeric chzn-select" column_name="CertItem" >';
        var options = OPTIONS_certification.CertItem;
        component += '<option value></option>';
        for(var i=0; i<options.length; i++){
          var option = options[i];
          var selected = '';
          if(option['value'] == field_value){
              selected = 'selected="selected"';
          }
          component += '<option value="'+option['value']+'" '+selected+'>'+option['caption']+'</option>';
        }
        component += '</select>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertProduct"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertProduct')){
          field_value = value.CertProduct;
        }
        component += '<td>';
        component += '<input style="width: 250px;" id="md_field_certification_col_CertProduct_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col" column_name="CertProduct" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertName"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertName')){
          field_value = value.CertName;
        }
        component += '<td>';
        component += '<input style="width: 350px;" id="md_field_certification_col_CertName_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col" column_name="CertName" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertPartnerName"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertPartnerName')){
          field_value = value.CertPartnerName;
        }
        component += '<td>';
        component += '<input style="width: 250px;" id="md_field_certification_col_CertPartnerName_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col" column_name="CertPartnerName" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertValidStart"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertValidStart') && value.CertValidStart != null){
          field_value = php_date_to_js(value.CertValidStart);
        }
        else{
          field_value = '';
        }

        component += '<td>';
        component += '<input style="width: 80px;" id="md_field_certification_col_CertValidStart_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col datetime-input" column_name="CertValidStart" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertValidFinish"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        
        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertValidFinish') && value.CertValidFinish != null){          
          field_value = php_date_to_js(value.CertValidFinish);          
        }
        else{
          field_value = '';
        }      
        
        component += '<td>';
        component += '<input style="width: 80px;" id="md_field_certification_col_CertValidFinish_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col datetime-input" column_name="CertValidFinish" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertStatus"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        var text_CertStatus;
        var color_td;
        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertStatus')){
            field_value = value.CertStatus;

            if (field_value ==1 && field_value != null){
                text_CertStatus = 'Active';
                color_td        = 'bg-success';
            }
            else if(field_value ==0 && field_value != null){
                text_CertStatus = 'Inactive';
                color_td        = 'bg-danger';
            }            
            else{
                text_CertStatus = '';
                color_td        = '';
            }

        }
        else{
              field_value       = '';
              text_CertStatus   = '';
              color_td          = '';
        }

        
        component += '<td><div align="center"><p class="'+color_td+'">';
        component += '<strong>'+text_CertStatus+'</strong>';
        component += '</p></div></td>';



        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertFileUrl"
        /////////////////////////////////////////////////////////////////////////////////////////////////////

        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertFileUrl')){
            field_value = value.CertFileUrl;
        }      

        var base_url = '<?php echo base_url();?>';
        component += '<td>';
        component += '<div class="fileupload fileupload-new" data-provides="fileupload"><span class="btn btn-primary btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input id="md_field_certification_col_CertFileUrl_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" type="file" column_name="CertFileUrl" name="md_field_certification_col_CertFileUrl_'+RECORD_INDEX_certification+'" value="'+field_value+'" /></span><span class="fileupload-preview"></span><a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a></div>';
        component += '</td>';      

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertFileUrl"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertFileUrl')){
            field_value = value.CertFileUrl;
        }        

        var text;
        if (field_value =='' || field_value == null){
            text = '';
        }else{
            text   = '<a href="https://apps.unias.com/hris2/modules/karyawan/assets/uploads/'+field_value+'" target="_blank"><img src="'+base_url+'images/icn-attach.png" title="Attachment" width="17" height="17" class="img-responsive" /></a>';
        }

        /*component += '<td align="center">';
        component += '<a href="'+base_url+'modules/karyawan/assets/uploads/'+field_value+'" target="_blank">'+text+'</a>';
        component += '</td>';*/

        component += '<td width="2%" align="center">'+text+'</td>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete Button
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        component += '<td><span class="delete-icon btn btn-default md_field_certification_delete" record_index="'+RECORD_INDEX_certification+'"><i class="glyphicon glyphicon-minus-sign"></i></span></td>';
        component += '</tr>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_certification tbody').append(component);
        mutate_input_certification();

    } // end of ADD ROW FUNCTION





    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Main event handling program
    //
    // * Initialization
    // * md_field_certification_add.click (Add row)
    // * md_field_certification_delete.click (Delete row)
    // * md_field_certification_col.change (Edit cell)
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // INITIALIZATION
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        synchronize_certification();
        for(var i=0; i<DATA_certification.update.length; i++){
            add_table_row_certification(DATA_certification.update[i].data);
            RECORD_INDEX_certification++;
        }
        synchronize_certification_table_width();

        // on resize, adjust the table width
        $(window).resize(function() {
            synchronize_certification_table_width();
        });

         



        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_certification_add.click (Add row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_field_certification_add').click(function(){
            
            // new data
            var data = new Object();            
            
          data.WorkExpStart = '';
          data.WorkExpFinish = '';
          data.WorkExpCompany = '';
          data.WorkExpPosition = '';         

          
            // insert data to the DATA_certification
            DATA_certification.insert.push({
                'record_index' : RECORD_INDEX_certification,
                'primary_key' : '',
                'data' : data,
            });

            // add table's row
            add_table_row_certification(data);
            // add  by 1
            RECORD_INDEX_certification++;

            // synchronize to the md_real_field_certification_col
            synchronize_certification();
            synchronize_certification_table_width();
        });

        

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_certification_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_certification_delete').live('click', function(){
            var record_index = $(this).attr('record_index');
            // remove the component
            $('#md_field_certification_tr_'+record_index).remove();

            var record_index_found = false;
            for(var i=0; i<DATA_certification.insert.length; i++){
                if(DATA_certification.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_certification.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_certification.update.length; i++){
                    if(DATA_certification.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_certification.update[i].primary_key;
                        // delete element from update
                        DATA_certification.update.splice(i,1);
                        // add it to delete
                        DATA_certification.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }
            synchronize_certification();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_certification_col.change (Edit cell)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_certification_col').live('change', function(){
            var value = $(this).val();
            var column_name = $(this).attr('column_name');
            var record_index = $(this).attr('record_index');
            var record_index_found = false;
            // date picker
            if($(this).hasClass('datepicker-input')){
                value = js_date_to_php(value);
            }
            else if($(this).hasClass('datetime-input')){
                value = js_datetime_to_php(value);
            }
            if(typeof(value)=='undefined'){
                value = '';
            }
            for(var i=0; i<DATA_certification.insert.length; i++){
                if(DATA_certification.insert[i].record_index == record_index){
                    record_index_found = true;
                    // insert value
                    eval('DATA_certification.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_certification.update.length; i++){
                    if(DATA_certification.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value
                        eval('DATA_certification.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        break;
                    }
                }
            }
            synchronize_certification();
        });


    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // reset field on save
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url == "{{ module_site_url }}frmKaryawan/index/insert") {
            response = $.parseJSON(xhr.responseText);
            if(response.success == true){
                DATA_certification = {update:new Array(), insert:new Array(), delete:new Array()};
                $('#md_table_certification tr').not(':first').remove();
                synchronize_certification();
            }
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize data to md_real_field_certification_col.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_certification(){
        $('#md_real_field_certification_col').val(JSON.stringify(DATA_certification));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize table width (called on resize and add).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_certification_table_width(){
        var parent_width = $("#md_table_certification_container").parent().parent().width();
        if($("#md_table_certification_container table:visible").length > 0){
            $("#md_table_certification_container").width(parent_width);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // function to mutate input
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function mutate_input_certification(){
        // datepicker-input
        $('#md_table_certification .datepicker-input').datepicker({
                dateFormat: js_date_format,
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-200:c+200",
        });
        // date-picker-input-clear
        $('#md_table_certification .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_certification .datetime-input').datepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            yearRange: "c-70:c+70",
        });
        
        $('#md_table_certification .datetime-input-clear').button();
        
        $('#md_table_certification .datetime-input-clear').click(function(){
            $(this).parent().find('.datetime-input').val("");
            return false;
        });
        // chzn-select
        $("#md_table_certification .chzn-select").chosen({allow_single_deselect: true});
        // numeric
        $('#md_table_certification .numeric').numeric();
        $('#md_table_certification .numeric').keydown(function(e){
            if(e.keyCode == 38)
            {
                if(IsNumeric($(this).val()))
                {
                    var new_number = parseInt($(this).val()) + 1;
                    $(this).val(new_number);
                }else if($(this).val().length == 0)
                {
                    var new_number = 1;
                    $(this).val(new_number);
                }
            }
            else if(e.keyCode == 40)
            {
                if(IsNumeric($(this).val()))
                {
                    var new_number = parseInt($(this).val()) - 1;
                    $(this).val(new_number);
                }else if($(this).val().length == 0)
                {
                    var new_number = -1;
                    $(this).val(new_number);
                }
            }
            $(this).trigger('change');
        });

    }



   

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // General Functions
    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    function js_datetime_to_php(js_datetime){
        if(typeof(js_datetime)=='undefined' || js_datetime == ''){
            return '';
        }
        var datetime_array = js_datetime.split(' ');
        var js_date = datetime_array[0];
        var time = datetime_array[1];
        var php_date = js_date_to_php(js_date);
        return php_date + ' ' + time;
    }
    function php_datetime_to_js(php_datetime){
        if(typeof(php_datetime)=='undefined' || php_datetime == ''){
            return '';
        }
        var datetime_array = php_datetime.split(' ');
        var php_date = datetime_array[0];
        var time = datetime_array[1];
        var js_date = php_date_to_js(php_date);
        return js_date + ' ' + time;
    }

    function js_date_to_php(js_date){
        if(typeof(js_date)=='undefined' || js_date == ''){
            return '';
        }
        var date = '';
        var month = '';
        var year = '';
        var php_date = '';
        if(DATE_FORMAT == 'uk-date'){
            var date_array = js_date.split('/');
            day = date_array[0];
            month = date_array[1];
            year = date_array[2];
            php_date = year+'-'+month+'-'+day;
        }else if(DATE_FORMAT == 'us-date'){
            var date_array = js_date.split('/');
            day = date_array[1];
            month = date_array[0];
            year = date_array[2];
            php_date = year+'-'+month+'-'+day;
        }else if(DATE_FORMAT == 'sql-date'){
            var date_array = js_date.split('-');
            day = date_array[2];
            month = date_array[1];
            year = date_array[0];
            php_date = year+'-'+month+'-'+day;
        }
        return php_date;
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

    function IsNumeric(input){
        return (input - 0) == input && input.length > 0;
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