<?php
    $record_index = 0;
    $Max =4;
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    
    #md_table_family {
        /*width:100%;*/
    }

    #md_table_family input[type="text"]{
        width:100%; 
    }

    #md_table_family .chzn-drop input[type="text"]{
        /*max-width:500px;*/
    }
    #md_table_family th:last-child, #md_table_family td:last-child{
        /*width: 60px;*/
    }

    #md_field_family_col_MemberStatus{
        /*width:10px;*/   
    }

    

</style>

<div id="md_table_family_container">
    <div id="no-datamd_table_family">No data</div>
    <table id="md_table_family" class="table table-striped table-hover table-bordered row-border" width="100%" style="display:none; width:98%;table-layout:fixed;">
        <thead>
            <tr>
                <th width="30%">Name</th>
                <th width="10%">Birth Date</th>
                <th width="10%">Birth Place</th>
                <th width="10%">Status</th>
                <th width="10%">Sex</th>
                <th width="10%">Blood Type</th>
                <th width="15%">No KTP/ e-KTP/ NIK</th>
                <th width="5%">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- the data presentation be here -->
        </tbody>
    </table>
    <div class="fbutton">
        <span id="md_field_family_add" class="add btn btn-default">
            <i class="glyphicon glyphicon-user"></i> Anggota Keluarga </span>
    </div>
    <br />
    <!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
    <input id="md_real_field_family_col" name="md_real_field_family_col" type="hidden" />
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
    var OPTIONS_family = <?php echo json_encode($options); ?>;
    var RECORD_INDEX_family = <?php echo $record_index; ?>;
    var DATA_family = {update:new Array(), insert:new Array(), delete:new Array()};
    var old_data = <?php echo json_encode($result); ?>;
    for(var i=0; i<old_data.length; i++){
        var row = old_data[i];
        var record_index = i;
        var primary_key = row['MemberId'];
        var data = row;
        delete data['MemberId'];
        DATA_family.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ADD ROW FUNCTION
    //
    // * When "Add family" clicked, this function is called without parameter.
    // * When page loaded for the first time, this function is called with value parameter
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function add_table_row_family(value){
        // hide no-data div
        $("#no-datamd_table_family").hide();
        $("#md_table_family").show();

        var component = '<tr id="md_field_family_tr_'+RECORD_INDEX_family+'" class="md_field_family_tr">';
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "MemberName"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('MemberName')){
          field_value = value.MemberName;
        }
        component += '<td>';
        component += '<input style="width: 100% !important; min-width: 100%; max-width: 100%;" id="md_field_family_col_MemberName_'+RECORD_INDEX_family+'" record_index="'+RECORD_INDEX_family+'" class="md_field_family_col form-control" column_name="MemberName" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "MemberLahir"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('MemberLahir')){
          field_value = php_date_to_js(value.MemberLahir);

        }
        component += '<td>';
        component += '<input style="width: 100% !important; min-width: 100%; max-width: 100%;" id="md_field_family_col_MemberLahir_'+RECORD_INDEX_family+'" record_index="'+RECORD_INDEX_family+'" class="md_field_family_col datetime-input form-control" column_name="MemberLahir" type="text" value="'+field_value+'"/>';
        component += '</td>';



        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "MemberTempatLahir"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        


        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('MemberTempatLahir')){
          field_value = value.MemberTempatLahir;
        }
        component += '<td>';
        component += '<select style="width:100%" id="md_field_family_col_MemberTempatLahir_'+RECORD_INDEX_family+'" record_index="'+RECORD_INDEX_family+'" class="md_field_family_col numeric chzn-select form-control" column_name="MemberTempatLahir" >';
        var options = OPTIONS_family.MemberTempatLahir;
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
        //    FIELD "MemberStatus"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('MemberStatus')){
          field_value = value.MemberStatus;
        }
        component += '<td>';
        component += '<select style="width:100%" id="md_field_family_col_MemberStatus_'+RECORD_INDEX_family+'" record_index="'+RECORD_INDEX_family+'" class="md_field_family_col numeric chzn-select form-control" column_name="MemberStatus" >';
        var options = OPTIONS_family.MemberStatus;
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
        //    FIELD "MemberSex"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('MemberSex')){
          field_value = value.MemberSex;
        }
        component += '<td>';
        component += '<select style="width:100%" id="md_field_family_col_MemberSex_'+RECORD_INDEX_family+'" record_index="'+RECORD_INDEX_family+'" class="md_field_family_col numeric chzn-select form-control" column_name="MemberSex" >';
        var options = OPTIONS_family.MemberSex;
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
        //    FIELD "MemberBloodType"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        

         var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('MemberBloodType')){
          field_value = value.MemberBloodType;
        }
        component += '<td>';
        component += '<select style="width:100%" id="md_field_family_col_MemberBloodType_'+RECORD_INDEX_family+'" record_index="'+RECORD_INDEX_family+'" class="md_field_family_col numeric chzn-select form-control" column_name="MemberBloodType" >';
        var options = OPTIONS_family.MemberBloodType;
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
        //    FIELD "MemberKTP"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('MemberKTP')){
          field_value = value.MemberKTP;
        }
        component += '<td>';
        component += '<input style="width: 100% !important; min-width: 100%; max-width: 100%;" id="md_field_family_col_MemberKTP_'+RECORD_INDEX_family+'" record_index="'+RECORD_INDEX_family+'" class="md_field_family_col form-control" column_name="MemberKTP" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete Button
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        component += '<td><span class="delete-icon btn btn-default md_field_family_delete" record_index="'+RECORD_INDEX_family+'"><i class="glyphicon glyphicon-minus-sign"></i></span></td>';
        component += '</tr>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_family tbody').append(component);
        mutate_input_family();

    } // end of ADD ROW FUNCTION





    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Main event handling program
    //
    // * Initialization
    // * md_field_family_add.click (Add row)
    // * md_field_family_delete.click (Delete row)
    // * md_field_family_col.change (Edit cell)
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // INITIALIZATION
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        synchronize_family();
        for(var i=0; i<DATA_family.update.length; i++){
            add_table_row_family(DATA_family.update[i].data);
            RECORD_INDEX_family++;
        }
        synchronize_family_table_width();

        // on resize, adjust the table width
        $(window).resize(function() {
            synchronize_family_table_width();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_family_add.click (Add row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_field_family_add').click(function(){

            if($("tr.md_field_family_tr").length<'<?php echo $Max ?>')
            // new data
            var data = new Object();
            
            data.MemberName = '';
            data.MemberSex = '';
            data.MemberLahir = '';
            data.MemberTempatLahir = '';
            data.MemberStatus = '';
            data.MemberBloodType = '';
            data.MemberKTP = '';

            // insert data to the DATA_family
            DATA_family.insert.push({
                'record_index' : RECORD_INDEX_family,
                'primary_key' : '',
                'data' : data,
            });

            // add table's row
            add_table_row_family(data);
            // add  by 1
            RECORD_INDEX_family++;

            // synchronize to the md_real_field_family_col
            synchronize_family();
            synchronize_family_table_width();
        });

        

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_family_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_family_delete').live('click', function(){
            var record_index = $(this).attr('record_index');
            // remove the component
            $('#md_field_family_tr_'+record_index).remove();

            var record_index_found = false;
            for(var i=0; i<DATA_family.insert.length; i++){
                if(DATA_family.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_family.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_family.update.length; i++){
                    if(DATA_family.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_family.update[i].primary_key;
                        // delete element from update
                        DATA_family.update.splice(i,1);
                        // add it to delete
                        DATA_family.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }
            synchronize_family();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_family_col.change (Edit cell)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_family_col').live('change', function(){
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
            for(var i=0; i<DATA_family.insert.length; i++){
                if(DATA_family.insert[i].record_index == record_index){
                    record_index_found = true;
                    // insert value
                    eval('DATA_family.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_family.update.length; i++){
                    if(DATA_family.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value
                        eval('DATA_family.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        break;
                    }
                }
            }
            synchronize_family();
        });


    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // reset field on save
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url == "{{ module_site_url }}frmMemberBPJSKetenagakerjaan/index/insert") {
            response = $.parseJSON(xhr.responseText);
            if(response.success == true){
                DATA_family = {update:new Array(), insert:new Array(), delete:new Array()};
                $('#md_table_family tr').not(':first').remove();
                synchronize_family();
            }
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize data to md_real_field_family_col.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_family(){
        $('#md_real_field_family_col').val(JSON.stringify(DATA_family));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize table width (called on resize and add).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_family_table_width(){
        var parent_width = $("#md_table_family_container").parent().parent().width();
        if($("#md_table_family_container table:visible").length > 0){
            $("#md_table_family_container").width(parent_width);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // function to mutate input
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function mutate_input_family(){
        // datepicker-input
        $('#md_table_family .datepicker-input').datepicker({
                dateFormat: js_date_format,
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-200:c+200",
        });
        // date-picker-input-clear
        $('#md_table_family .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_family .datetime-input').datepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            yearRange: "c-70:c+70",
        });
        
        $('#md_table_family .datetime-input-clear').button();
        
        $('#md_table_family .datetime-input-clear').click(function(){
            $(this).parent().find('.datetime-input').val("");
            return false;
        });
        // chzn-select
        $("#md_table_family .chzn-select").chosen({allow_single_deselect: true});
        // numeric
        $('#md_table_family .numeric').numeric();
        $('#md_table_family .numeric').keydown(function(e){
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