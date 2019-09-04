<?php
    $record_index = 0;
    $session_nik  = $_SESSION['NIK'];
    $today        = date('Y-m-d H:i:s');
    $upload_path  = base_url('modules/'.$module_path.'/assets/uploads').'/';
    
    
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    #md_table_technical input[type="text"]{
        max-width:700px;
    }

    

    #md_table_technical .chzn-drop input[type="text"]{
        max-width:240px;
    }
    #md_table_technical th:last-child, #md_table_technical td:last-child{
        width: 60px;
    }
</style>

<div id="md_table_technical_container">
    <div id="no-datamd_table_technical">No data</div>
    <table id="md_table_technical" class="table table-striped table-bordered" style="display:none">
        <thead>
            <tr>
                <th>Technical Skill Title</th>
                <th>Experiences</th>
                <th>Description</th>
                <th colspan="2" width="8%">File Attachment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- the data presentation be here -->
        </tbody>
    </table>
    <div class="fbutton">
        <span id="md_field_technical_add" class="add btn btn-default">
            <i class="glyphicon glyphicon-wrench"></i> Technicals Skill </span>
    </div>
    <br />
    <!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
    <input id="md_real_field_technical_col" name="md_real_field_technical_col" type="hidden" />
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
    var OPTIONS_technical = <?php echo json_encode($options); ?>;
    var RECORD_INDEX_technical = <?php echo $record_index; ?>;
    var UPLOAD_PATH = '<?php echo $upload_path; ?>';
    var DATA_technical = {update:new Array(), insert:new Array(), delete:new Array()};
    var old_data = <?php echo json_encode($result); ?>;
    for(var i=0; i<old_data.length; i++){
        var row = old_data[i];
        var record_index = i;
        var primary_key = row['TechnicalSkillId'];
        var data = row;
        delete data['TechnicalSkillId'];
        DATA_technical.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }
    console.log(DATA_technical);


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ADD ROW FUNCTION
    //
    // * When "Add technical" clicked, this function is called without parameter.
    // * When page loaded for the first time, this function is called with value parameter
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function add_table_row_technical(value){
        // hide no-data div
        $("#no-datamd_table_technical").hide();
        $("#md_table_technical").show();

        var component = '<tr id="md_field_technical_tr_'+RECORD_INDEX_technical+'" class="md_field_technical_tr">';
        
       
        


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "TechnicalSkillName"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('TechnicalSkillName')){
          field_value = value.TechnicalSkillName;
        }
        component += '<td>';
        component += '<input style="width: 400px;" id="md_field_technical_col_TechnicalSkillName_'+RECORD_INDEX_technical+'" record_index="'+RECORD_INDEX_technical+'" class="md_field_technical_col" column_name="TechnicalSkillName" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "TechnicalSkillExp"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('TechnicalSkillExp')){
          field_value = value.TechnicalSkillExp;
        }
        component += '<td>';
        component += '<input style="width: 450px;" id="md_field_technical_col_TechnicalSkillExp_'+RECORD_INDEX_technical+'" record_index="'+RECORD_INDEX_technical+'" class="md_field_technical_col" column_name="TechnicalSkillExp" type="text" value="'+field_value+'"/>';
        component += '</td>';

        

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "TechnicalSkillDesc"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('TechnicalSkillDesc')){
          field_value = value.TechnicalSkillDesc;
        }
        component += '<td>';
        component += '<textarea style="width: 400px !important; min-width: 400px; max-width: 400px; height: 100px;" id="md_field_technical_col_TechnicalSkillDesc_'+RECORD_INDEX_technical+'" record_index="'+RECORD_INDEX_technical+'" class="md_field_technical_col" column_name="TechnicalSkillDesc">'+field_value+'</textarea>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "TechnicalSkillFileUrl"
        /////////////////////////////////////////////////////////////////////////////////////////////////////

        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('TechnicalSkillFileUrl')){
            field_value = value.TechnicalSkillFileUrl;
        }      

        var base_url = '<?php echo base_url();?>';
        component += '<td>';
        component += '<div class="fileupload fileupload-new" data-provides="fileupload"><span class="btn btn-primary btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input id="md_field_technical_col_TechnicalSkillFileUrl_'+RECORD_INDEX_technical+'" record_index="'+RECORD_INDEX_technical+'" type="file" column_name="TechnicalSkillFileUrl" name="md_field_technical_col_TechnicalSkillFileUrl_'+RECORD_INDEX_technical+'" value="'+field_value+'" /></span><span class="fileupload-preview"></span><a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a></div>';
        component += '</td>';      

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "TechnicalSkillFileUrl"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('TechnicalSkillFileUrl')){
            field_value = value.TechnicalSkillFileUrl;
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
        component += '<td><span class="delete-icon btn btn-default md_field_technical_delete" record_index="'+RECORD_INDEX_technical+'"><i class="glyphicon glyphicon-minus-sign"></i></span></td>';
        component += '</tr>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_technical tbody').append(component);
        mutate_input_technical();

    } // end of ADD ROW FUNCTION





    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Main event handling program
    //
    // * Initialization
    // * md_field_technical_add.click (Add row)
    // * md_field_technical_delete.click (Delete row)
    // * md_field_technical_col.change (Edit cell)
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // INITIALIZATION
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        synchronize_technical();
        for(var i=0; i<DATA_technical.update.length; i++){
            add_table_row_technical(DATA_technical.update[i].data);
            RECORD_INDEX_technical++;
        }
        synchronize_technical_table_width();

        // on resize, adjust the table width
        $(window).resize(function() {
            synchronize_technical_table_width();
        });

         



        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_technical_add.click (Add row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_field_technical_add').click(function(){

            
            // new data
            var data = new Object();

            
            
          data.TechnicalSkillName = '';
          data.TechnicalSkillExp = '';
          data.TechnicalSkillDesc = '';
         
          

          
            // insert data to the DATA_technical
            DATA_technical.insert.push({
                'record_index' : RECORD_INDEX_technical,
                'primary_key' : '',
                'data' : data,
            });

            // add table's row
            add_table_row_technical(data);
            // add  by 1
            RECORD_INDEX_technical++;

            // synchronize to the md_real_field_technical_col
            synchronize_technical();
            synchronize_technical_table_width();
        });

        

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_technical_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_technical_delete').live('click', function(){
            var record_index = $(this).attr('record_index');
            // remove the component
            $('#md_field_technical_tr_'+record_index).remove();

            var record_index_found = false;
            for(var i=0; i<DATA_technical.insert.length; i++){
                if(DATA_technical.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_technical.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_technical.update.length; i++){
                    if(DATA_technical.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_technical.update[i].primary_key;
                        // delete element from update
                        DATA_technical.update.splice(i,1);
                        // add it to delete
                        DATA_technical.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }
            synchronize_technical();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_technical_col.change (Edit cell)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_technical_col').live('change', function(){
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
            for(var i=0; i<DATA_technical.insert.length; i++){
                if(DATA_technical.insert[i].record_index == record_index){
                    record_index_found = true;
                    // insert value
                    eval('DATA_technical.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_technical.update.length; i++){
                    if(DATA_technical.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value
                        eval('DATA_technical.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        break;
                    }
                }
            }
            synchronize_technical();
        });


    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // reset field on save
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url == "{{ module_site_url }}frmMyCV/index/insert") {
            response = $.parseJSON(xhr.responseText);
            if(response.success == true){
                DATA_technical = {update:new Array(), insert:new Array(), delete:new Array()};
                $('#md_table_technical tr').not(':first').remove();
                synchronize_technical();
            }
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize data to md_real_field_technical_col.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_technical(){
        $('#md_real_field_technical_col').val(JSON.stringify(DATA_technical));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize table width (called on resize and add).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_technical_table_width(){
        var parent_width = $("#md_table_technical_container").parent().parent().width();
        if($("#md_table_technical_container table:visible").length > 0){
            $("#md_table_technical_container").width(parent_width);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // function to mutate input
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function mutate_input_technical(){
        // datepicker-input
        $('#md_table_technical .datepicker-input').datepicker({
                dateFormat: 'Y',
                viewMode: "years",
                showButtonPanel: true,
                changeMonth: false,
                changeYear: true,
                yearRange: "c-200:c+200",
        });
        // date-picker-input-clear
        $('#md_table_technical .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_technical .datetime-input').datepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            yearRange: "c-70:c+70",
        });
        
        $('#md_table_technical .datetime-input-clear').button();
        
        $('#md_table_technical .datetime-input-clear').click(function(){
            $(this).parent().find('.datetime-input').val("");
            return false;
        });
        // chzn-select
        $("#md_table_technical .chzn-select").chosen({allow_single_deselect: true});
        // numeric
        $('#md_table_technical .numeric').numeric();
        $('#md_table_technical .numeric').keydown(function(e){
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