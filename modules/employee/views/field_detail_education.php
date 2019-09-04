<?php
    $record_index = 0;
    $upload_path = base_url('modules/karyawan/assets/uploads').'/';
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    #md_table_education input[type="text"]{
        max-width:200px;
    }
    #md_table_education .chzn-drop input[type="text"]{
        max-width:240px;
    }
    #md_table_education th:last-child, #md_table_education td:last-child{
        width: 60px;
    }
    #education_display_as_box{
        display: none;
    }
    #md_table_education{
        font-size: 12px;
    }
    
</style>

<div id="md_table_education_container">
    <div id="no-datamd_table_education">No data</div>
    <table id="md_table_education" class="table table-striped table-bordered row-border" style="display:none;">
        <thead>
            <tr>
                <th>Start</th>
                <th>Finish</th>
                <th>Level</th>
                <th>Institution</th>
                <th>City</th>
                <th>Faculty</th>
                <th>Major</th>
                <th>GPA</th>
                <th>Evidence</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            <!-- the data presentation be here -->
        </tbody>
    </table>
    <div class="fbutton">
        <span id="md_field_education_add" class="add btn btn-success btn-xs">
            <i class="glyphicon glyphicon-plus-sign"></i> Add Education </span>
    </div>
    <br />
    <!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
    <input id="md_real_field_education_col" name="md_real_field_education_col" type="hidden" />
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
    var OPTIONS_education = <?php echo json_encode($options); ?>;
    var RECORD_INDEX_education = <?php echo $record_index; ?>;
    var UPLOAD_PATH = '<?php echo $upload_path; ?>';
    var DATA_education = {update:new Array(), insert:new Array(), delete:new Array()};
    var old_data = <?php echo json_encode($result); ?>;
    for(var i=0; i<old_data.length; i++){
        var row = old_data[i];
        var record_index = i;
        var primary_key = row['EduId'];
        var data = row;
        delete data['EduId'];
        DATA_education.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ADD ROW FUNCTION
    //
    // * When "Add education" clicked, this function is called without parameter.
    // * When page loaded for the first time, this function is called with value parameter
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function add_table_row_education(value){
        // hide no-data div
        $("#no-datamd_table_education").hide();
        $("#md_table_education").show();

        var component = '<tr id="md_field_education_tr_'+RECORD_INDEX_education+'" class="md_field_education_tr">';
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduStart"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduStart')){
          field_value = value.EduStart;
        }
        component += '<td>';
        component += '<input style="width: 60px;" id="md_field_education_col_EduStart_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control numeric" max="4" min="4" column_name="EduStart" type="text" placeholder="tahun" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduFinish"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduFinish')){
          field_value = value.EduFinish;
        }
        component += '<td>';
        component += '<input style="width: 60px;" id="md_field_education_col_EduFinish_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control numeric" max="4" min="4" column_name="EduFinish" type="text" placeholder="tahun" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduLevelId"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduLevelId')){
          field_value = value.EduLevelId;
        }
        component += '<td>';
        component += '<select style="width: 50px !important; min-width: 50px; max-width: 50px;" id="md_field_education_col_EduLevelId_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control numeric chzn-select" column_name="EduLevelId" >';
        var options = OPTIONS_education.EduLevelId;
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
        //    FIELD "EduInstitution"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduInstitution')){
          field_value = value.EduInstitution;
        }
        component += '<td>';
        component += '<input id="md_field_education_col_EduInstitution_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control" column_name="EduInstitution" type="text" placeholder="Nama lembaga yg resmi" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduCity"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduCity')){
          field_value = value.EduCity;
        }
        component += '<td>';
        component += '<select style="width: 150px !important; min-width: 150px; max-width: 150px;" id="md_field_education_col_EduCity_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control numeric chzn-select" column_name="EduCity" >';
        var options = OPTIONS_education.EduCity;
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
        //    FIELD "EduFaculty"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduFaculty')){
          field_value = value.EduFaculty;
        }
        component += '<td>';
        component += '<input id="md_field_education_col_EduFaculty_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control" column_name="EduFaculty" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduMajor"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduMajor')){
          field_value = value.EduMajor;
        }
        component += '<td>';
        component += '<input style="width: 120px;" id="md_field_education_col_EduMajor_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control" column_name="EduMajor" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduGPA"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduGPA')){
          field_value = value.EduGPA;
        }
        component += '<td>';
        component += '<input style="width: 60px;" id="md_field_education_col_EduGPA_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control" column_name="EduGPA" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduFileUrl"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduFileUrl')){
            field_value = value.EduFileUrl;
        }
        component += '<td>';
        if(field_value != '' && field_value != null){
            component += '<a href="'+UPLOAD_PATH+field_value+'" class="btn btn-xs btn-primary" target="_blank"><i class="glyphicon glyphicon-download-alt"</i></a>';
        }else{
            component += '<input id="md_field_education_col_EduFileUrl_'+RECORD_INDEX_education+
                  '" record_index="'+RECORD_INDEX_education+
                  '" class="md_field_education_col" column_name="EduFileUrl" type="file"'+
                  ' name="md_field_education_col_EduFileUrl_'+RECORD_INDEX_education+'" value="'+field_value+'"/>';
        }

        component += '</td>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete Button
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        component += '<td><span class="delete-icon btn btn-danger btn-xs md_field_education_delete" record_index="'+RECORD_INDEX_education+'"><i class="glyphicon glyphicon-trash"></i></span></td>';
        component += '</tr>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_education tbody').append(component);
        mutate_input_education();

    } // end of ADD ROW FUNCTION



    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Main event handling program
    //
    // * Initialization
    // * md_field_education_add.click (Add row)
    // * md_field_education_delete.click (Delete row)
    // * md_field_education_col.change (Edit cell)
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // INITIALIZATION
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        synchronize_education();
        for(var i=0; i<DATA_education.update.length; i++){
            add_table_row_education(DATA_education.update[i].data);
            RECORD_INDEX_education++;
        }
        synchronize_education_table_width();

        // on resize, adjust the table width
        $(window).resize(function() {
            synchronize_education_table_width();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_education_add.click (Add row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_field_education_add').click(function(){
            // new data
            var data = new Object();
            
            data.EduStart = '';
            data.EduFinish = '';
            data.EduLevelId = '';
            data.EduInstitution = '';
            data.EduCity = '';
            data.EduFaculty = '';
            data.EduMajor = '';
            // insert data to the DATA_education
            DATA_education.insert.push({
                'record_index' : RECORD_INDEX_education,
                'primary_key' : '',
                'data' : data,
            });

            // add table's row
            add_table_row_education(data);
            // add  by 1
            RECORD_INDEX_education++;

            // synchronize to the md_real_field_education_col
            synchronize_education();
            synchronize_education_table_width();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_education_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_education_delete').live('click', function(){
            var record_index = $(this).attr('record_index');
            // remove the component
            $('#md_field_education_tr_'+record_index).remove();

            var record_index_found = false;
            for(var i=0; i<DATA_education.insert.length; i++){
                if(DATA_education.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_education.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_education.update.length; i++){
                    if(DATA_education.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_education.update[i].primary_key;
                        // delete element from update
                        DATA_education.update.splice(i,1);
                        // add it to delete
                        DATA_education.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }
            synchronize_education();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_education_col.change (Edit cell)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_education_col').live('change', function(){
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
            for(var i=0; i<DATA_education.insert.length; i++){
                if(DATA_education.insert[i].record_index == record_index){
                    record_index_found = true;
                    // insert value
                    eval('DATA_education.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_education.update.length; i++){
                    if(DATA_education.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value
                        eval('DATA_education.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        break;
                    }
                }
            }
            synchronize_education();
        });


    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // reset field on save
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url == "{{ module_site_url }}form_my_resume/index/insert") {
            response = $.parseJSON(xhr.responseText);
            if(response.success == true){
                DATA_education = {update:new Array(), insert:new Array(), delete:new Array()};
                $('#md_table_education tr').not(':first').remove();
                synchronize_education();
            }
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize data to md_real_field_education_col.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_education(){
        $('#md_real_field_education_col').val(JSON.stringify(DATA_education));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize table width (called on resize and add).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_education_table_width(){
        var parent_width = $("#md_table_education_container").parent().parent().width();
        if($("#md_table_education_container table:visible").length > 0){
            $("#md_table_education_container").width(parent_width);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // function to mutate input
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function mutate_input_education(){
        // datepicker-input
        $('#md_table_education .datepicker-input').datepicker({
                dateFormat: js_date_format,
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-100:c+100",
        });
        // date-picker-input-clear
        $('#md_table_education .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_education .datetime-input').datetimepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
        
        $('#md_table_education .datetime-input-clear').button();
        
        $('#md_table_education .datetime-input-clear').click(function(){
            $(this).parent().find('.datetime-input').val("");
            return false;
        });
        // chzn-select
        $("#md_table_education .chzn-select").chosen({allow_single_deselect: true});
        // numeric
        $('#md_table_education .numeric').numeric();
        $('#md_table_education .numeric').keydown(function(e){
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