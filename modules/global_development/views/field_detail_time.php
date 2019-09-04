<?php
    $record_index = 0;
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    #md_table_time input[type="text"]{
        max-width:100%;
    }
    #md_table_time .chzn-drop input[type="text"]{
        max-width:100%;
    }
    #md_table_time th:last-child, #md_table_time td:last-child{
        width: 100%;
    }
</style>

<div id="md_table_time_container">
    <div id="no-datamd_table_time">No data</div>
    <table id="md_table_time" class="table table-striped table-bordered" style="display:none">
        <thead>
            <tr>
                <th width="60%"><div align="center">Type</div></th>
                <th width="40%"><div align="center">Value <a href="#" style="text-decoration: none;" class="glyphicon glyphicon-question-sign tip-right" data-toggle="tooltip" title="Hanya bisa melakukan edit value"></a></div></th>
            </tr>
        </thead>
        <tbody>
            <!-- the data presentation be here -->
        </tbody>
    </table>
    
    <!--<div class="fbutton">
        <span id="md_field_time_add" class="add btn btn-default">
            <i class="glyphicon glyphicon-plus-sign"></i> Add time        </span>
    </div>-->
    <br />
    <!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
    <input id="md_real_field_time_col" name="md_real_field_time_col" type="hidden" />
</div>

<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/ui/'.grocery_CRUD::JQUERY_UI_JS); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.ui.datetime.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.numeric.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery-ui-timepicker-addon.js'); ?>"></script>

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

<script type="text/javascript">

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // DATA INITIALIZATION
    //
    // * Prepare some global variables
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    var DATE_FORMAT = '<?php echo $date_format ?>';
    var OPTIONS_time = <?php echo json_encode($options); ?>;
    var RECORD_INDEX_time = <?php echo $record_index; ?>;
    var DATA_time = {update:new Array(), insert:new Array(), delete:new Array()};
    var old_data = <?php echo json_encode($result); ?>;
    for(var i=0; i<old_data.length; i++){
        var row = old_data[i];
        var record_index = i;
        var primary_key = row['time_id'];
        var data = row;
        delete data['time_id'];
        DATA_time.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ADD ROW FUNCTION
    //
    // * When "Add time" clicked, this function is called without parameter.
    // * When page loaded for the first time, this function is called with value parameter
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function add_table_row_time(value){
        // hide no-data div
        $("#no-datamd_table_time").hide();
        $("#md_table_time").show();

        var component = '<tr id="md_field_time_tr_'+RECORD_INDEX_time+'" class="md_field_time_tr">';
        
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "time_item"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        
/*
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('time_item')){
          field_value = value.time_item;
        }
        component += '<td>';
        component += '<select style="width: 96% !important; min-width: 96%; max-width: 96%;" id="md_field_time_col_time_item_'+RECORD_INDEX_time+'" record_index="'+RECORD_INDEX_time+'" class="md_field_time_col numeric form-control" column_name="time_item" >';
        var options = OPTIONS_time.time_item;
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
*/


        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('time_item')){
          field_value = value.time_item;
        }
        component += '<td>';
        component += '<strong>';
       
        var options = OPTIONS_time.time_item;
        for(var i=0; i<options.length; i++){
          var option = options[i];
          var selected = '';
          if(option['value'] == field_value){
              component += option['caption'];
          }
          //component += option['caption'];
        }
        component += '</strong>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "time_result"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('time_result') && value.time_result != null){
          field_value = value.time_result;
        }
        else{
          field_value = '';
        }
        component += '<td>';
        component += '<input onkeypress="return isNumberKey(event);" style="width: 97% !important; min-width: 97%; max-width: 97%;" id="md_field_time_col_time_result_'+RECORD_INDEX_time+'" record_index="'+RECORD_INDEX_time+'" class="md_field_time_col" name="time_result_'+RECORD_INDEX_time+'" column_name="time_result" type="text" value="'+field_value+'"/>';
        component += '</td>';
       


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete Button
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //component += '<td><span class="delete-icon btn btn-default md_field_time_delete" record_index="'+RECORD_INDEX_time+'"><i class="glyphicon glyphicon-minus-sign"></i></span></td>';
        component += '</tr>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_time tbody').append(component);
        mutate_input_time();

    } // end of ADD ROW FUNCTION





    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Main event handling program
    //
    // * Initialization
    // * md_field_time_add.click (Add row)
    // * md_field_time_delete.click (Delete row)
    // * md_field_time_col.change (Edit cell)
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // INITIALIZATION
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        synchronize_time();
        for(var i=0; i<DATA_time.update.length; i++){
            add_table_row_time(DATA_time.update[i].data);
            RECORD_INDEX_time++;
        }
        synchronize_time_table_width();

        // on resize, adjust the table width
        $(window).resize(function() {
            synchronize_time_table_width();
        });

         



        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_time_add.click (Add row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_field_time_add').click(function(){
            // new data
            var data = new Object();

            
            
            data.time_item = '';
            data.time_result = '';
          
            // insert data to the DATA_time
            DATA_time.insert.push({
                'record_index' : RECORD_INDEX_time,
                'primary_key' : '',
                'data' : data,
            });

            // add table's row
            add_table_row_time(data);
            // add  by 1
            RECORD_INDEX_time++;

            // synchronize to the md_real_field_time_col
            synchronize_time();
            synchronize_time_table_width();
        });

        

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_time_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_time_delete').live('click', function(){
            var record_index = $(this).attr('record_index');
            // remove the component
            $('#md_field_time_tr_'+record_index).remove();

            var record_index_found = false;
            for(var i=0; i<DATA_time.insert.length; i++){
                if(DATA_time.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_time.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_time.update.length; i++){
                    if(DATA_time.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_time.update[i].primary_key;
                        // delete element from update
                        DATA_time.update.splice(i,1);
                        // add it to delete
                        DATA_time.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }
            synchronize_time();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_time_col.change (Edit cell)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_time_col').live('change', function(){
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
            for(var i=0; i<DATA_time.insert.length; i++){
                if(DATA_time.insert[i].record_index == record_index){
                    record_index_found = true;
                    // insert value
                    eval('DATA_time.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_time.update.length; i++){
                    if(DATA_time.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value
                        eval('DATA_time.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        break;
                    }
                }
            }
            synchronize_time();
        });


    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // reset field on save
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url == "{{ module_site_url }}manage_city/index/insert") {
            response = $.parseJSON(xhr.responseText);
            if(response.success == true){
                DATA_time = {update:new Array(), insert:new Array(), delete:new Array()};
                $('#md_table_time tr').not(':first').remove();
                synchronize_time();
            }
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize data to md_real_field_time_col.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_time(){
        $('#md_real_field_time_col').val(JSON.stringify(DATA_time));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize table width (called on resize and add).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_time_table_width(){
        var parent_width = $("#md_table_time_container").parent().parent().width();
        if($("#md_table_time_container table:visible").length > 0){
            $("#md_table_time_container").width(parent_width);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // function to mutate input
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function mutate_input_time(){
        // datepicker-input
        $('#md_table_time .datepicker-input').datepicker({
                dateFormat: js_date_format,
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-100:c+100",
        });
        // date-picker-input-clear
        $('#md_table_time .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_time .datetime-input').datetimepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
        
        $('#md_table_time .datetime-input-clear').button();
        
        $('#md_table_time .datetime-input-clear').click(function(){
            $(this).parent().find('.datetime-input').val("");
            return false;
        });
        // chzn-select
        $("#md_table_time .chzn-select").chosen({allow_single_deselect: true});
        // numeric
        $('#md_table_time .numeric').numeric();
        $('#md_table_time .numeric').keydown(function(e){
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


    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    }

</script>