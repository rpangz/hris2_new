<?php
    $record_index = 0;
    $upload_path = base_url('modules/karyawan/assets/uploads').'/';
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    #md_table_working input[type="text"]{
        max-width:300px;
    }
    #md_table_working .chzn-drop input[type="text"]{
        max-width:240px;
    }
    #md_table_working th:last-child, #md_table_working td:last-child{
        width: 60px;
    }
    #working_display_as_box{
        display: none;
    }
    #md_table_working{
        font-size: 12px;
    }
    #md_table_working textarea{
        width: 280px;
    }
    
    
</style>

<div id="md_table_working_container">
    <div id="no-datamd_table_working">No data</div>
    <table id="md_table_working" class="table table-striped table-bordered row-border" style="display:none;">   

    <div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-info-circle"></i> Tips!</h4>
        <p class="keterangan">Kosongkan kolom { Finish } jika status waktunya sampai sekarang.</p>
    </div>
        <thead>
            <tr>
                <th>Start</th>
                <th>Finish</th>
                <th>Company</th>
                <th>Position</th>
                <th>Descriptions</th>                
                <th>Evidence</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            <!-- the data presentation be here -->
        </tbody>
    </table>
    <div class="fbutton">
        <span id="md_field_working_add" class="add btn btn-success btn-xs">
            <i class="glyphicon glyphicon-plus-sign"></i> Add Working </span>
    </div>
    <br />
    <!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
    <input id="md_real_field_working_col" name="md_real_field_working_col" type="hidden" />
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
    var OPTIONS_working = <?php echo json_encode($options); ?>;
    var RECORD_INDEX_working = <?php echo $record_index; ?>;
    var UPLOAD_PATH = '<?php echo $upload_path; ?>';
    var DATA_working = {update:new Array(), insert:new Array(), delete:new Array()};
    var old_data = <?php echo json_encode($result); ?>;
    for(var i=0; i<old_data.length; i++){
        var row = old_data[i];
        var record_index = i;
        var primary_key = row['WorkExpId'];
        var data = row;
        delete data['WorkExpId'];
        DATA_working.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ADD ROW FUNCTION
    //
    // * When "Add working" clicked, this function is called without parameter.
    // * When page loaded for the first time, this function is called with value parameter
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function add_table_row_working(value){
        // hide no-data div
        $("#no-datamd_table_working").hide();
        $("#md_table_working").show();

        var component = '<tr id="md_field_working_tr_'+RECORD_INDEX_working+'" class="md_field_working_tr">';
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "WorkExpStart"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('WorkExpStart')){
          field_value = php_date_to_js(value.WorkExpStart);
        }
        component += '<td>';
        component += '<input style="width: 80px;" id="md_field_working_col_WorkExpStart_'+RECORD_INDEX_working+'" record_index="'+RECORD_INDEX_working+'" class="md_field_working_col form-control datepicker-input" column_name="WorkExpStart" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "WorkExpFinish"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('WorkExpFinish') && value.WorkExpFinish != '0000-00-00' && value.WorkExpFinish != null){
          field_value = php_date_to_js(value.WorkExpFinish);
        }
        component += '<td>';
        component += '<input style="width: 80px;" id="md_field_working_col_WorkExpFinish_'+RECORD_INDEX_working+'" record_index="'+RECORD_INDEX_working+'" class="md_field_working_col form-control datepicker-input" column_name="WorkExpFinish" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "WorkExpCompany"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('WorkExpCompany')){
          field_value = value.WorkExpCompany;
        }
        component += '<td>';
        component += '<input style="width:300px;" id="md_field_working_col_WorkExpCompany_'+RECORD_INDEX_working+'" record_index="'+RECORD_INDEX_working+'" class="md_field_working_col form-control" column_name="WorkExpCompany" type="text" placeholder="" value="'+field_value+'"/>';
        component += '</td>';        


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "WorkExpPosition"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('WorkExpPosition')){
          field_value = value.WorkExpPosition;
        }
        component += '<td>';
        component += '<input style="width:250px;" id="md_field_working_col_WorkExpPosition_'+RECORD_INDEX_working+'" record_index="'+RECORD_INDEX_working+'" class="md_field_working_col form-control" column_name="WorkExpPosition" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "WorkExpDesc"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('WorkExpDesc')){
          field_value = value.WorkExpDesc;
        }
        component += '<td>';
        component += ' <textarea rows="3" cols="10" id="md_field_working_col_WorkExpDesc_'+RECORD_INDEX_working+'" record_index="'+RECORD_INDEX_working+'" class="md_field_working_col form-control" column_name="WorkExpDesc" placeholder="Jelaskan pekerjaan anda dengan singkat dan padat">'+field_value+'</textarea>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "WorkExpFileUrl"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('WorkExpFileUrl')){
            field_value = value.WorkExpFileUrl;
        }
        component += '<td>';
        if(field_value != '' && field_value != null){
            component += '<a href="'+UPLOAD_PATH+field_value+'" class="btn btn-xs btn-primary" target="_blank"><i class="glyphicon glyphicon-download-alt"</i></a>';
        }else{
            component += '<input id="md_field_working_col_WorkExpFileUrl_'+RECORD_INDEX_working+
                  '" record_index="'+RECORD_INDEX_working+
                  '" class="md_field_working_col" column_name="WorkExpFileUrl" type="file"'+
                  ' name="md_field_working_col_WorkExpFileUrl_'+RECORD_INDEX_working+'" value="'+field_value+'"/>';
        }

        component += '</td>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete Button
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        component += '<td><span class="delete-icon btn btn-danger btn-xs md_field_working_delete" record_index="'+RECORD_INDEX_working+'"><i class="glyphicon glyphicon-trash"></i></span></td>';
        component += '</tr>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_working tbody').append(component);
        mutate_input_working();

    } // end of ADD ROW FUNCTION



    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Main event handling program
    //
    // * Initialization
    // * md_field_working_add.click (Add row)
    // * md_field_working_delete.click (Delete row)
    // * md_field_working_col.change (Edit cell)
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // INITIALIZATION
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        synchronize_working();
        for(var i=0; i<DATA_working.update.length; i++){
            add_table_row_working(DATA_working.update[i].data);
            RECORD_INDEX_working++;
        }
        synchronize_working_table_width();

        // on resize, adjust the table width
        $(window).resize(function() {
            synchronize_working_table_width();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_working_add.click (Add row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_field_working_add').click(function(){
            // new data
            var data = new Object();
            
            data.WorkExpStart = '';
            data.WorkExpFinish = '';
            data.WorkExpCompany = '';
            data.WorkExpPosition = '';
            data.WorkExpDesc = '';
            // insert data to the DATA_working
            DATA_working.insert.push({
                'record_index' : RECORD_INDEX_working,
                'primary_key' : '',
                'data' : data,
            });

            // add table's row
            add_table_row_working(data);
            // add  by 1
            RECORD_INDEX_working++;

            // synchronize to the md_real_field_working_col
            synchronize_working();
            synchronize_working_table_width();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_working_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_working_delete').live('click', function(){
            var record_index = $(this).attr('record_index');
            // remove the component
            $('#md_field_working_tr_'+record_index).remove();

            var record_index_found = false;
            for(var i=0; i<DATA_working.insert.length; i++){
                if(DATA_working.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_working.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_working.update.length; i++){
                    if(DATA_working.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_working.update[i].primary_key;
                        // delete element from update
                        DATA_working.update.splice(i,1);
                        // add it to delete
                        DATA_working.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }
            synchronize_working();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_working_col.change (Edit cell)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_working_col').live('change', function(){
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
            for(var i=0; i<DATA_working.insert.length; i++){
                if(DATA_working.insert[i].record_index == record_index){
                    record_index_found = true;
                    // insert value
                    eval('DATA_working.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_working.update.length; i++){
                    if(DATA_working.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value
                        eval('DATA_working.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        break;
                    }
                }
            }
            synchronize_working();
        });


    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // reset field on save
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url == "{{ module_site_url }}form_my_resume/index/insert") {
            response = $.parseJSON(xhr.responseText);
            if(response.success == true){
                DATA_working = {update:new Array(), insert:new Array(), delete:new Array()};
                $('#md_table_working tr').not(':first').remove();
                synchronize_working();
            }
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize data to md_real_field_working_col.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_working(){
        $('#md_real_field_working_col').val(JSON.stringify(DATA_working));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize table width (called on resize and add).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_working_table_width(){
        var parent_width = $("#md_table_working_container").parent().parent().width();
        if($("#md_table_working_container table:visible").length > 0){
            $("#md_table_working_container").width(parent_width);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // function to mutate input
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function mutate_input_working(){
        // datepicker-input
        $('#md_table_working .datepicker-input').datepicker({
                dateFormat: js_date_format,
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-100:c+100",
        });
        // date-picker-input-clear
        $('#md_table_working .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_working .datetime-input').datetimepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
        
        $('#md_table_working .datetime-input-clear').button();
        
        $('#md_table_working .datetime-input-clear').click(function(){
            $(this).parent().find('.datetime-input').val("");
            return false;
        });
        // chzn-select
        $("#md_table_working .chzn-select").chosen({allow_single_deselect: true});
        // numeric
        $('#md_table_working .numeric').numeric();
        $('#md_table_working .numeric').keydown(function(e){
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
        if(typeof(js_date)=='undefined' || js_date == '' || js_date == null){
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
        if(typeof(php_date)=='undefined' || php_date == '' || php_date == null){
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