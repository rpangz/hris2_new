<?php
    $record_index = 0;
    $session_nik  = $_SESSION['NIK'];
    $today        = date('Y-m-d H:i:s');
    $upload_path  = base_url('modules/'.$module_path.'/assets/uploads').'/';

   

?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    #md_table_project input[type="text"]{
        max-width:600px;
    }

    #md_table_project .chzn-drop input[type="text"]{
        max-width:240px;
    }
    #md_table_project th:last-child, #md_table_project td:last-child{
        width: 60px;
    }
</style>

<div id="md_table_project_container">
    <div id="no-datamd_table_project">No data</div>
    <table id="md_table_project" class="table table-striped table-bordered" style="display:none">
        <thead>
            <tr>
                <th>Date</th>
                <th>Project</th>
                <th>Institution</th>
                <th>Year</th>
                <th>Length</th>
                <th>Technical Spec</th>
                <th>Position in Project</th>
                <th colspan="2" width="8%">File Attachment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- the data presentation be here -->
        </tbody>
    </table>
    <div class="fbutton">
        <span id="md_field_project_add" class="add btn btn-default">
            <i class="glyphicon glyphicon-list-alt"></i> Project History </span>
    </div>
    <br />
    <!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
    <input id="md_real_field_project_col" name="md_real_field_project_col" type="hidden" />
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
    var OPTIONS_project = <?php echo json_encode($options); ?>;
    var RECORD_INDEX_project = <?php echo $record_index; ?>;
    var UPLOAD_PATH = '<?php echo $upload_path; ?>';
    var DATA_project = {update:new Array(), insert:new Array(), delete:new Array()};
    var old_data = <?php echo json_encode($result); ?>;
    for(var i=0; i<old_data.length; i++){
        var row = old_data[i];
        var record_index = i;
        var primary_key = row['ProjectId'];
        var data = row;
        delete data['ProjectId'];
        DATA_project.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }
    console.log(DATA_project);


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ADD ROW FUNCTION
    //
    // * When "Add project" clicked, this function is called without parameter.
    // * When page loaded for the first time, this function is called with value parameter
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function add_table_row_project(value){
        // hide no-data div
        $("#no-datamd_table_project").hide();
        $("#md_table_project").show();

        var component = '<tr id="md_field_project_tr_'+RECORD_INDEX_project+'" class="md_field_project_tr">';
        


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "ProjectDate"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('ProjectDate')){
          field_value = php_date_to_js(value.ProjectDate);

        }
        component += '<td>';
        component += '<input style="width: 80px;" id="md_field_project_col_ProjectDate_'+RECORD_INDEX_project+'" record_index="'+RECORD_INDEX_project+'" class="md_field_project_col datetime-input" column_name="ProjectDate" type="text" value="'+field_value+'"/>';
        component += '</td>';

        

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "ProjectName"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('ProjectName')){
          field_value = value.ProjectName;
        }
        component += '<td>';
        component += '<input style="width: 350px;" id="md_field_project_col_ProjectName_'+RECORD_INDEX_project+'" record_index="'+RECORD_INDEX_project+'" class="md_field_project_col" column_name="ProjectName" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "ProjectInstitution"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('ProjectInstitution')){
          field_value = value.ProjectInstitution;
        }
        component += '<td>';
        component += '<input style="width: 350px;" id="md_field_project_col_ProjectInstitution_'+RECORD_INDEX_project+'" record_index="'+RECORD_INDEX_project+'" class="md_field_project_col" column_name="ProjectInstitution" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "ProjectYear"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('ProjectYear')){
          field_value = value.ProjectYear;
        }
        component += '<td>';
        component += '<input onkeypress="return isNumberKey(event);" style="width: 40px;" id="md_field_project_col_ProjectYear_'+RECORD_INDEX_project+'" record_index="'+RECORD_INDEX_project+'" class="md_field_project_col" column_name="ProjectYear" type="text" maxlength="4" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "ProjectLength"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('ProjectLength')){
          field_value = value.ProjectLength;
        }
        component += '<td>';
        component += '<input style="width: 80px;" id="md_field_project_col_ProjectLength_'+RECORD_INDEX_project+'" record_index="'+RECORD_INDEX_project+'" class="md_field_project_col" column_name="ProjectLength" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "ProjectTechnicalSpec"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('ProjectTechnicalSpec')){
          field_value = value.ProjectTechnicalSpec;
        }
        component += '<td>';
        component += '<textarea style="width: 250px; height: 100px;" id="md_field_project_col_ProjectTechnicalSpec_'+RECORD_INDEX_project+'" record_index="'+RECORD_INDEX_project+'" class="md_field_project_col" column_name="ProjectTechnicalSpec">'+field_value+'</textarea>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "ProjectPosition"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('ProjectPosition')){
          field_value = value.ProjectPosition;
        }
        component += '<td>';
        component += '<input style="width: 150px;" id="md_field_project_col_ProjectPosition_'+RECORD_INDEX_project+'" record_index="'+RECORD_INDEX_project+'" class="md_field_project_col" column_name="ProjectPosition" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "ProjectFileUrl"
        /////////////////////////////////////////////////////////////////////////////////////////////////////

        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('ProjectFileUrl')){
            field_value = value.ProjectFileUrl;
        }      

        var base_url = '<?php echo base_url();?>';
        component += '<td>';
        component += '<div class="fileupload fileupload-new" data-provides="fileupload"><span class="btn btn-primary btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input id="md_field_project_col_ProjectFileUrl_'+RECORD_INDEX_project+'" record_index="'+RECORD_INDEX_project+'" type="file" column_name="ProjectFileUrl" name="md_field_project_col_ProjectFileUrl_'+RECORD_INDEX_project+'" value="'+field_value+'" /></span><span class="fileupload-preview"></span><a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a></div>';
        component += '</td>';      

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "ProjectFileUrl"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('ProjectFileUrl')){
            field_value = value.ProjectFileUrl;
        }        

        var text;
        if (field_value =='' || field_value == null){
            text = '';
        }else{
            text   = '<a href="https://apps.unias.com/hris2/modules/karyawan/assets/uploads/'+field_value+'" target="_blank"><img src="'+base_url+'images/icn-attach.png" title="Attachment" width="17" height="17" /></a>';
        }

        /*component += '<td align="center">';
        component += '<a href="'+base_url+'modules/karyawan/assets/uploads/'+field_value+'" target="_blank">'+text+'</a>';
        component += '</td>';*/

        component += '<td width="2%" align="center">'+text+'</td>';         




        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete Button
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        component += '<td><span class="delete-icon btn btn-default md_field_project_delete" record_index="'+RECORD_INDEX_project+'"><i class="glyphicon glyphicon-minus-sign"></i></span></td>';
        component += '</tr>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_project tbody').append(component);
        mutate_input_project();

    } // end of ADD ROW FUNCTION





    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Main event handling program
    //
    // * Initialization
    // * md_field_project_add.click (Add row)
    // * md_field_project_delete.click (Delete row)
    // * md_field_project_col.change (Edit cell)
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // INITIALIZATION
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        synchronize_project();
        for(var i=0; i<DATA_project.update.length; i++){
            add_table_row_project(DATA_project.update[i].data);
            RECORD_INDEX_project++;
        }
        synchronize_project_table_width();

        // on resize, adjust the table width
        $(window).resize(function() {
            synchronize_project_table_width();
        });

         



        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_project_add.click (Add row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_field_project_add').click(function(){
            
            // new data
            var data = new Object();            
            
          data.WorkExpStart = '';
          data.WorkExpFinish = '';
          data.WorkExpCompany = '';
          data.WorkExpPosition = '';         

          
            // insert data to the DATA_project
            DATA_project.insert.push({
                'record_index' : RECORD_INDEX_project,
                'primary_key' : '',
                'data' : data,
            });

            // add table's row
            add_table_row_project(data);
            // add  by 1
            RECORD_INDEX_project++;

            // synchronize to the md_real_field_project_col
            synchronize_project();
            synchronize_project_table_width();
        });

        

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_project_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_project_delete').live('click', function(){
            var record_index = $(this).attr('record_index');
            // remove the component
            $('#md_field_project_tr_'+record_index).remove();

            var record_index_found = false;
            for(var i=0; i<DATA_project.insert.length; i++){
                if(DATA_project.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_project.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_project.update.length; i++){
                    if(DATA_project.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_project.update[i].primary_key;
                        // delete element from update
                        DATA_project.update.splice(i,1);
                        // add it to delete
                        DATA_project.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }
            synchronize_project();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_project_col.change (Edit cell)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_project_col').live('change', function(){
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
            for(var i=0; i<DATA_project.insert.length; i++){
                if(DATA_project.insert[i].record_index == record_index){
                    record_index_found = true;
                    // insert value
                    eval('DATA_project.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_project.update.length; i++){
                    if(DATA_project.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value
                        eval('DATA_project.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        break;
                    }
                }
            }
            synchronize_project();
        });


    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // reset field on save
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url == "{{ module_site_url }}frmKaryawan/index/insert") {
            response = $.parseJSON(xhr.responseText);
            if(response.success == true){
                DATA_project = {update:new Array(), insert:new Array(), delete:new Array()};
                $('#md_table_project tr').not(':first').remove();
                synchronize_project();
            }
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize data to md_real_field_project_col.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_project(){
        $('#md_real_field_project_col').val(JSON.stringify(DATA_project));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize table width (called on resize and add).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_project_table_width(){
        var parent_width = $("#md_table_project_container").parent().parent().width();
        if($("#md_table_project_container table:visible").length > 0){
            $("#md_table_project_container").width(parent_width);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // function to mutate input
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function mutate_input_project(){
        // datepicker-input
        $('#md_table_project .datepicker-input').datepicker({
                dateFormat: js_date_format,
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-200:c+200",
        });
        // date-picker-input-clear
        $('#md_table_project .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_project .datetime-input').datepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            yearRange: "c-70:c+70",
        });
        
        $('#md_table_project .datetime-input-clear').button();
        
        $('#md_table_project .datetime-input-clear').click(function(){
            $(this).parent().find('.datetime-input').val("");
            return false;
        });
        // chzn-select
        $("#md_table_project .chzn-select").chosen({allow_single_deselect: true});
        // numeric
        $('#md_table_project .numeric').numeric();
        $('#md_table_project .numeric').keydown(function(e){
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