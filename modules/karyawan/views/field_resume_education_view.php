<?php
    $record_index = 0;
    $upload_path = base_url('modules/'.$module_path.'/assets/uploads').'/';

?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    #md_table_education input[type="text"]{
        /*max-width:350px;*/
        /*
        max-width:100%;
        min-width:100%;
        width:100%;
        */        
    }
    #md_table_education .chzn-drop input[type="text"]{
        /*max-width:350px;*/
    }
    #md_table_education th:last-child, #md_table_education td:last-child{
        /*width: 10%;*/
    }
    #education_display_as_box{
        display: none;
    }
    .flexigrid textarea{
        width:100%;
        height: 100%;
    }
</style>

<div id="md_table_education_container">
    <div id="no-datamd_table_education">No data</div>
    <table id="md_table_education" class="table table-striped table-bordered table-hover row-border" style="width:100%;">
        <thead>
            <tr>
                <th width="2%">No</th>
                <th width="5%">Start Year</th>
                <th width="5%">End Year</th>
                <th>Institution</th>
                <th width="10%">City</th>
                <th width="5%">Level</th>
                <th width="5%">Faculty</th>                
                <th width="10%">Major</th>
                <th width="5%">GPA</th>
                <th width="5%">Evidence</th>
                <th width="10%" class="text-center">#</th>
            </tr>
        </thead>
        <tbody>
            <!-- the data presentation be here -->
        </tbody>
    </table>
    <div class="fbutton">
        <!--<span id="md_field_education_add" class="add btn btn-default">
            <i class="glyphicon glyphicon-plus-sign"></i> Add education
        </span>-->

        <span onclick="education_add()" class="add btn btn-default">
            <i class="glyphicon glyphicon-plus-sign"></i> Add education
        </span>
    </div>
    <br/>

    <!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
    <!--<input id="md_real_field_education_col" name="md_real_field_education_col" type="hidden" />-->

    <textarea id="md_real_field_education_col" name="md_real_field_education_col" type="hidden" class="form-control" rows="15"></textarea>

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
        var primary_key  = row['EduId'];
        var data = row;
        delete data['EduId'];
        DATA_education.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }

    var column_field = ['EduStart','EduFinish','EduInstitution'];


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
        //    FIELD "Record Index"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        
        component += '<td>';
        component += RECORD_INDEX_education;
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduStart"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduStart')){
          field_value = value.EduStart;
        }
        component += '<td>';
        component += '<span id="md_field_education_td_EduStart_'+RECORD_INDEX_education+'">'+field_value+'</span>';
        component += '<input id="md_field_education_col_EduStart_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col col-sm-12 form-control numeric" column_name="EduStart" type="hidden" maxlength="4" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduFinish"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduFinish')){
          field_value = value.EduFinish;
        }
        component += '<td>';
        component += '<span id="md_field_education_td_EduFinish_'+RECORD_INDEX_education+'">'+field_value+'</span>';
        component += '<input id="md_field_education_col_EduFinish_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control numeric" column_name="EduFinish" type="hidden" maxlength="4" value="'+field_value+'"/>';
        component += '</td>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduInstitution"
        /////////////////////////////////////////////////////////////////////////////////////////////////////        
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduInstitution')){
          field_value = value.EduInstitution;
        }
        component += '<td>';
        component += '<span id="md_field_education_td_EduInstitution_'+RECORD_INDEX_education+'">'+field_value+'</span>';
        component += '<input id="md_field_education_col_EduInstitution_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control" column_name="EduInstitution" type="hidden" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduCity"
        /////////////////////////////////////////////////////////////////////////////////////////////////////        
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduCity')){
          field_value = value.EduCity;
        }
        component += '<td>';
        component += '<span id="md_field_education_td_EduCity_'+RECORD_INDEX_education+'">'+field_value+'</span>';
        component += '<input id="md_field_education_col_EduCity_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control" column_name="EduCity" type="hidden" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduLevelId"
        /////////////////////////////////////////////////////////////////////////////////////////////////////        
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduLevelId')){
          field_value = value.EduLevelId;
        }
        component += '<td>';
        component += '<span id="md_field_education_td_EduLevelId_'+RECORD_INDEX_education+'">'+field_value+'</span>';
        component += '<input id="md_field_education_col_EduLevelId_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control" column_name="EduLevelId" type="hidden" value="'+field_value+'"/>';
        component += '</td>';    


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduFaculty"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduFaculty')){
          field_value = value.EduFaculty;
        }
        component += '<td>';
        component += '<span id="md_field_education_td_EduFaculty_'+RECORD_INDEX_education+'">'+field_value+'</span>';
        component += '<input id="md_field_education_col_EduFaculty_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control" column_name="EduFaculty" type="hidden" value="'+field_value+'"/>';
        component += '</td>';        


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduMajor"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduMajor')){
          field_value = value.EduMajor;
        }
        component += '<td>';
        component += '<span id="md_field_education_td_EduMajor_'+RECORD_INDEX_education+'">'+field_value+'</span>';
        component += '<input id="md_field_education_col_EduMajor_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control" column_name="EduMajor" type="hidden" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduGPA"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduGPA')){
          field_value = value.EduGPA;
        }
        component += '<td>';
        component += '<span id="md_field_education_td_EduGPA_'+RECORD_INDEX_education+'">'+field_value+'</span>';
        component += '<input id="md_field_education_col_EduGPA_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control" column_name="EduGPA" type="hidden" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduMajor"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduFileUrl')){
          field_value = value.EduFileUrl;
        }
        component += '<td>';
        component += '<span id="md_field_education_td_EduFileUrl_'+RECORD_INDEX_education+'">'+field_value+'</span>';
        component += '<input id="md_field_education_col_EduFileUrl_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col form-control" column_name="EduFileUrl" type="hidden" value="'+field_value+'"/>';
        component += '</td>';



        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete Button
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        component += '<td class="text-center"><span class="btn btn-primary btn-xs" title="'+RECORD_INDEX_education+'" onclick="education_edit('+RECORD_INDEX_education+')"><i class="glyphicon glyphicon-pencil"></i></span> <span class="delete-icon btn btn-danger btn-xs md_field_education_delete" record_index="'+RECORD_INDEX_education+'"><i class="glyphicon glyphicon-remove"></i></span></td>';
        component += '</tr>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_education tbody').append(component);
        mutate_input_education();

    } // end of ADD ROW FUNCTION


    function add_modal_row_education(primary_key, value){

        var component = '';

        var field_value = '';
        if(typeof(primary_key) != 'undefined' && primary_key != null){
          field_value = primary_key;
        }
        component += '<input type="text" value="'+field_value+'" name="primary_key" class="form-control"/>';


        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduStart')){
          field_value = value.EduStart;
        }        
        component += '<div class="form-group">'+
                '<label class="control-label col-md-3">Start *</label>'+                            
                '<div class="col-md-9">'+
                '<input name="EduStart" placeholder="dalam angka" max="4" class="form-control numeric" value="'+field_value+'" type="text">'+                
                '<span class="help-block"></span>'+
                '</div>'+
                '</div>';


        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduFinish')){
          field_value = value.EduFinish;
        }
        component +='<div class="form-group">'+
                '<label class="control-label col-md-3">Finish *</label>'+                            
                '<div class="col-md-9">'+
                '<input name="EduFinish" placeholder="dalam angka" max="4" class="form-control numeric" value="'+field_value+'" type="text">'+                
                '<span class="help-block"></span>'+
                '</div>'+
                '</div>';

        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduInstitution')){
          field_value = value.EduInstitution;
        }
        component +='<div class="form-group">'+
                '<label class="control-label col-md-3">Institution *</label>'+                            
                '<div class="col-md-9">'+
                '<input name="EduInstitution" placeholder="gunakan nama resmi institusi" class="form-control" value="'+field_value+'" type="text">'+                
                '<span class="help-block"></span>'+
                '</div>'+
                '</div>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "birthdate"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduCreatedTime')){
          field_value = php_date_to_js(value.EduCreatedTime);
        }
        component += '<td>';
        component += '<input class="md_field_education_col datepicker-input" column_name="EduCreatedTime" type="text" value="'+field_value+'"/>';
        component += '</td>';


        return component;
        //mutate_input_education();
    }







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
            data.EduLevelId = '';
            //data.EduFileName = '';
            //data.EduFileUrl = '';
          
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
        if (settings.url == "{{ module_site_url }}manage_city/index/insert") {
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


    function education_edit(primary_key){

        var record_index = primary_key;
        var record_index_found = false;

        var data = new Object();

        if(DATA_education.update[primary_key]){
            record_index_found = true;           
        
            $.each(column_field, function(index, column_name){        
                var record_index_found = false;
                data[column_name] = DATA_education.update[primary_key].data[column_name];   

            });

        }
        else{
            record_index_found = false;

            $.each(column_field, function(index, column_name){        
                
                data[column_name] = $('#md_field_education_col_'+column_name+'_'+primary_key).val(); 

            });
        }

       
        

       

        /*
        if(!record_index_found){           
            var EduStart        = DATA_education.update[primary_key].data['EduStart'];
            var EduFinish       = DATA_education.update[primary_key].data['EduFinish'];
            var EduInstitution  = DATA_education.update[primary_key].data['EduInstitution'];                 
        }
        else{

            var EduStart        = DATA_education.insert[1].data['EduStart'];
            var EduFinish       = DATA_education.insert[primary_key];
            var EduInstitution  = DATA_education.insert[primary_key];
        }
        */

        /*
        var data = new Object();

        
        $.each(column_field, function(index, column_name){        
            var record_index_found = false;
            /*
            for(var i=0; i<DATA_education.update.length; i++){
                var row = DATA_education.update[i];
                var record_index = i;
                
                var data = row;
                delete data['EduId'];
                DATA_education.update.push({
                    'data' : data,
                });
            }
            */

            //data[column_name] = DATA_education.update[primary_key].data(column_name);
            /*
            data[column_name] = DATA_education.update[primary_key].data[column_name];   

        });
*/
        


           
        

        /*
        $.each(column_field, function(index, column_name){

            for(var i=0; i<DATA_education.insert.length; i++){
                if(DATA_education.insert[i].record_index == record_index){
                    record_index_found = true;

                    $('#form_education_update [name="'+column_name+'"]').val('ss');
                    // insert value
                    //eval('DATA_education.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    //break;
                }
            }

            if(!record_index_found){
                for(var i=0; i<DATA_education.update.length; i++){
                    if(DATA_education.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value

                        $('#form_education_update [name="'+column_name+'"]').val(DATA_education.update[i].data[column_name]);

                        //eval('DATA_education.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        //break;
                    }
                }
            }

        });
        */

        var html = add_modal_row_education(primary_key, data);      



        /*
        if(DATA_education.update[record_index]){
            record_index_found = false;
        }
        else{
            record_index_found = true;
        }
        
        
        if(!record_index_found){
            for(var i=0; i<DATA_education.update.length; i++){
                if(DATA_education.update[i].record_index == record_index){
                    record_index_found = true;
                    EduStart        = DATA_education.update[primary_key].data['EduStart'];
                    EduFinish       = DATA_education.update[primary_key].data['EduFinish'];
                    EduInstitution  = DATA_education.update[primary_key].data['EduInstitution']; 
                }
            }
        }
        else{
            for(var i=0; i<DATA_education.insert.length; i++){
                if(DATA_education.insert[i].record_index == record_index){
                    record_index_found = false;
                    EduStart        = DATA_education.insert[primary_key].data['EduStart'];
                    EduFinish       = DATA_education.insert[primary_key].data['EduFinish'];
                    EduInstitution  = DATA_education.insert[primary_key].data['EduInstitution'];                   
                }
            }
        }
        */
               
        

        $('#modal_form_resume_edit .modal-title').text('Edit Education #'+primary_key);
        $('#modal_form_resume_edit .form-body').html(html);                                               
        $('#modal_form_resume_edit').modal({backdrop: 'static'});
        $('#modal_form_resume_edit').modal('show');

    }

    function education_add(){

        //$('#form_education_insert')[0].reset();
        var html = add_modal_row_education(primary_key=null, value='');


        $('#modal_form_resume_add .modal-title').text('Add Education');
        $('#modal_form_resume_add .form-body').html(html);                                               
        $('#modal_form_resume_add').modal({backdrop: 'static'});
        $('#modal_form_resume_add').modal('show');

    }

    function btn_resume_save(){

        //var formData = new FormData($('#form_mutation_employee')[0]);
        //var this_container = $(this).closest('.flexigrid');

        var data = new Object();

        $.each(column_field, function( index, column_name){

            var value = $('#modal_form_resume_add [name="'+column_name+'"]').val();             
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

            data[column_name] = value;   
        });


          
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

            //$('#form_education_insert')[0].reset();
            //$('#form_resume_employee').empty();

            $('#modal_form_resume_add').modal('hide');
    }


    function btn_resume_edit_save(){

        $('#modal_form_resume_edit').modal('hide');
        
        $.each(column_field, function( index, column_name){

            var value        = $('#modal_form_resume_edit [name="'+column_name+'"]').val();
            var record_index = $('#modal_form_resume_edit [name="primary_key"]').val();
            var record_index_found = false;

            $('[name="'+column_name+'"]').parent().parent().addClass('has-error');
            //$('[name="'+column_name+'"]').next().text(error_string[i]);


            $('#md_field_education_col_'+column_name+'_'+record_index).val(value);
            $('#md_field_education_td_'+column_name+'_'+record_index).text(value);

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
    }


    



</script>