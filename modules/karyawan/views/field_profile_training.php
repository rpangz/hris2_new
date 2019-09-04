<?php
    $record_index = 0;
    $session_nik  = $_SESSION['NIK'];
    $today        = date('Y-m-d H:i:s');
    $upload_path  = base_url('modules/'.$module_path.'/assets/uploads').'/';
    
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    #md_table_training input[type="text"]{
        max-width:600px;
    }

    #md_table_training .chzn-drop input[type="text"]{
        max-width:240px;
    }
    #md_table_training th:last-child, #md_table_training td:last-child{
        width: 60px;
    }
</style>

<div id="md_table_training_container">
    <div id="no-datamd_table_training">No data</div>
    <table id="md_table_training" class="table table-striped table-bordered" style="display:none">
        <thead>
            <tr>
                <th>Year</th>
                <th>Institution</th>
                <th>City</th>
                <th>Modul</th>
                <th>Training Type</th>
                <th colspan="2" width="8%">File Attachment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- the data presentation be here -->
        </tbody>
    </table>
    <div class="fbutton">
        <span id="md_field_training_add" class="add btn btn-default">
            <i class="glyphicon glyphicon-briefcase"></i> Trainings </span>
    </div>
    <br />
    <!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
    <input id="md_real_field_training_col" name="md_real_field_training_col" type="hidden" />
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
    var OPTIONS_training = <?php echo json_encode($options); ?>;
    var RECORD_INDEX_training = <?php echo $record_index; ?>;
    var UPLOAD_PATH = '<?php echo $upload_path; ?>';
    var DATA_training = {update:new Array(), insert:new Array(), delete:new Array()};
    var old_data = <?php echo json_encode($result); ?>;
    for(var i=0; i<old_data.length; i++){
        var row = old_data[i];
        var record_index = i;
        var primary_key = row['TrainingId'];
        var data = row;
        delete data['TrainingId'];
        DATA_training.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }
    console.log(DATA_training);


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ADD ROW FUNCTION
    //
    // * When "Add training" clicked, this function is called without parameter.
    // * When page loaded for the first time, this function is called with value parameter
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function add_table_row_training(value){
        // hide no-data div
        $("#no-datamd_table_training").hide();
        $("#md_table_training").show();

        var component = '<tr id="md_field_training_tr_'+RECORD_INDEX_training+'" class="md_field_training_tr">';
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "TrainingYear"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
       

        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('TrainingYear')){
          field_value = value.TrainingYear;
        }
        component += '<td>';
        component += '<input onkeypress="return isNumberKey(event);" style="width: 50px;" id="md_field_training_col_TrainingYear_'+RECORD_INDEX_training+'" record_index="'+RECORD_INDEX_training+'" class="md_field_training_col" column_name="TrainingYear" type="text" maxlength="4" value="'+field_value+'"/>';
        component += '</td>';

        


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "TrainingInstitution"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('TrainingInstitution')){
          field_value = value.TrainingInstitution;
        }
        component += '<td>';
        component += '<input style="width: 350px;" id="md_field_training_col_TrainingInstitution_'+RECORD_INDEX_training+'" record_index="'+RECORD_INDEX_training+'" class="md_field_training_col" column_name="TrainingInstitution" type="text" value="'+field_value+'"/>';
        component += '</td>';
       


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "TrainingCity"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('TrainingCity')){
          field_value = value.TrainingCity;
        }
        component += '<td>';
        component += '<select style="width: 200px !important; min-width: 200px; max-width: 200px;" id="md_field_training_col_TrainingCity_'+RECORD_INDEX_training+'" record_index="'+RECORD_INDEX_training+'" class="md_field_training_col numeric chzn-select" column_name="TrainingCity" >';
        var options = OPTIONS_training.TrainingCity;
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
        //    FIELD "TrainingModul"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('TrainingModul')){
          field_value = value.TrainingModul;
        }
        component += '<td>';
        component += '<input style="width: 450px;" id="md_field_training_col_TrainingModul_'+RECORD_INDEX_training+'" record_index="'+RECORD_INDEX_training+'" class="md_field_training_col" column_name="TrainingModul" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "TrainingType"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('TrainingType')){
          field_value = value.TrainingType;
        }
        component += '<td>';
        component += '<input style="width: 150px;" id="md_field_training_col_TrainingType_'+RECORD_INDEX_training+'" record_index="'+RECORD_INDEX_training+'" class="md_field_training_col" column_name="TrainingType" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "TrainingFileUrl"
        /////////////////////////////////////////////////////////////////////////////////////////////////////

        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('TrainingFileUrl')){
            field_value = value.TrainingFileUrl;
        }      

        var base_url = '<?php echo base_url();?>';
        component += '<td>';
        component += '<div class="fileupload fileupload-new" data-provides="fileupload"><span class="btn btn-primary btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input id="md_field_training_col_TrainingFileUrl_'+RECORD_INDEX_training+'" record_index="'+RECORD_INDEX_training+'" type="file" column_name="TrainingFileUrl" name="md_field_training_col_TrainingFileUrl_'+RECORD_INDEX_training+'" value="'+field_value+'" /></span><span class="fileupload-preview"></span><a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a></div>';
        component += '</td>';      

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "TrainingFileUrl"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('TrainingFileUrl')){
            field_value = value.TrainingFileUrl;
        }        

        var text;
        if (field_value =='' || field_value == null){
            text = '';
        }else{
            text   = '<a href="https://apps.unias.com/hris2/modules/karyawan/assets/uploads/'+field_value+'" target="_blank"><img src="'+base_url+'images/icn-attach.png" title="Attachment" width="17" height="17" /></a>';
        }
        /*
        component += '<td align="center">';
        component += '<a href="'+base_url+'modules/karyawan/assets/uploads/'+field_value+'" target="_blank">'+text+'</a>';
        component += '</td>';
        */

        component += '<td width="2%" align="center">'+text+'</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete Button
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        component += '<td><span class="delete-icon btn btn-default md_field_training_delete" record_index="'+RECORD_INDEX_training+'"><i class="glyphicon glyphicon-minus-sign"></i></span></td>';
        component += '</tr>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_training tbody').append(component);
        mutate_input_training();

    } // end of ADD ROW FUNCTION





    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Main event handling program
    //
    // * Initialization
    // * md_field_training_add.click (Add row)
    // * md_field_training_delete.click (Delete row)
    // * md_field_training_col.change (Edit cell)
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // INITIALIZATION
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        synchronize_training();
        for(var i=0; i<DATA_training.update.length; i++){
            add_table_row_training(DATA_training.update[i].data);
            RECORD_INDEX_training++;
        }
        synchronize_training_table_width();

        // on resize, adjust the table width
        $(window).resize(function() {
            synchronize_training_table_width();
        });

         



        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_training_add.click (Add row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_field_training_add').click(function(){

            
            // new data
            var data = new Object();

            
            
          data.TrainingYear = '';
          data.TrainingInstitution = '';
          data.TrainingCity = '';
          data.TrainingModul = '';
          data.TrainingType = '';
          

          
            // insert data to the DATA_training
            DATA_training.insert.push({
                'record_index' : RECORD_INDEX_training,
                'primary_key' : '',
                'data' : data,
            });

            // add table's row
            add_table_row_training(data);
            // add  by 1
            RECORD_INDEX_training++;

            // synchronize to the md_real_field_training_col
            synchronize_training();
            synchronize_training_table_width();
        });

        

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_training_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_training_delete').live('click', function(){
            var record_index = $(this).attr('record_index');
            // remove the component
            $('#md_field_training_tr_'+record_index).remove();

            var record_index_found = false;
            for(var i=0; i<DATA_training.insert.length; i++){
                if(DATA_training.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_training.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_training.update.length; i++){
                    if(DATA_training.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_training.update[i].primary_key;
                        // delete element from update
                        DATA_training.update.splice(i,1);
                        // add it to delete
                        DATA_training.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }
            synchronize_training();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_training_col.change (Edit cell)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_training_col').live('change', function(){
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
            for(var i=0; i<DATA_training.insert.length; i++){
                if(DATA_training.insert[i].record_index == record_index){
                    record_index_found = true;
                    // insert value
                    eval('DATA_training.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_training.update.length; i++){
                    if(DATA_training.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value
                        eval('DATA_training.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        break;
                    }
                }
            }
            synchronize_training();
        });


    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // reset field on save
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url == "{{ module_site_url }}frmMyCV/index/insert") {
            response = $.parseJSON(xhr.responseText);
            if(response.success == true){
                DATA_training = {update:new Array(), insert:new Array(), delete:new Array()};
                $('#md_table_training tr').not(':first').remove();
                synchronize_training();
            }
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize data to md_real_field_training_col.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_training(){
        $('#md_real_field_training_col').val(JSON.stringify(DATA_training));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize table width (called on resize and add).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_training_table_width(){
        var parent_width = $("#md_table_training_container").parent().parent().width();
        if($("#md_table_training_container table:visible").length > 0){
            $("#md_table_training_container").width(parent_width);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // function to mutate input
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function mutate_input_training(){
        // datepicker-input
        $('#md_table_training .datepicker-input').datepicker({
                dateFormat: 'Y',
                viewMode: "years",
                showButtonPanel: true,
                changeMonth: false,
                changeYear: true,
                yearRange: "c-200:c+200",
        });
        // date-picker-input-clear
        $('#md_table_training .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_training .datetime-input').datepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            yearRange: "c-70:c+70",
        });
        
        $('#md_table_training .datetime-input-clear').button();
        
        $('#md_table_training .datetime-input-clear').click(function(){
            $(this).parent().find('.datetime-input').val("");
            return false;
        });
        // chzn-select
        $("#md_table_training .chzn-select").chosen({allow_single_deselect: true});
        // numeric
        $('#md_table_training .numeric').numeric();
        $('#md_table_training .numeric').keydown(function(e){
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