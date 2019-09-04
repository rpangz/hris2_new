<?php
    $record_index = 0;
    $session_nik  = $_SESSION['NIK'];
    $today        = date('Y-m-d H:i:s');
    $upload_path  = base_url('modules/'.$module_path.'/assets/uploads').'/';
    
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    #md_table_education input[type="text"]{
        max-width:600px;
    }

    #md_table_education .chzn-drop input[type="text"]{
        max-width:240px;
    }
    #md_table_education th:last-child, #md_table_education td:last-child{
        width: 60px;
    }

.clearfix{*zoom:1;}.clearfix:before,.clearfix:after{display:table;content:"";line-height:0;}
.clearfix:after{clear:both;}
.hide-text{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0;}
.input-block-level{display:block;width:100%;min-height:18px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
.btn-file{overflow:hidden;position:relative;vertical-align:middle;}.btn-file>input{position:absolute;top:0;right:0;margin:0;opacity:0;filter:alpha(opacity=0);transform:translate(-300px, 0) scale(4);font-size:23px;direction:ltr;cursor:pointer;}
.fileupload{margin-bottom:9px;}.fileupload .uneditable-input{display:inline-block;margin-bottom:0px;vertical-align:middle;cursor:text;}
.fileupload .thumbnail{overflow:hidden;display:inline-block;margin-bottom:5px;vertical-align:middle;text-align:center;}.fileupload .thumbnail>img{display:inline-block;vertical-align:middle;max-height:100%;}
.fileupload .btn{vertical-align:middle;}
.fileupload-exists .fileupload-new,.fileupload-new .fileupload-exists{display:none;}
.fileupload-inline .fileupload-controls{display:inline;}
.fileupload-new .input-append .btn-file{-webkit-border-radius:0 3px 3px 0;-moz-border-radius:0 3px 3px 0;border-radius:0 3px 3px 0;}
.thumbnail-borderless .thumbnail{border:none;padding:0;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;}
.fileupload-new.thumbnail-borderless .thumbnail{border:1px solid #ddd;}
.control-group.warning .fileupload .uneditable-input{color:#a47e3c;border-color:#a47e3c;}
.control-group.warning .fileupload .fileupload-preview{color:#a47e3c;}
.control-group.warning .fileupload .thumbnail{border-color:#a47e3c;}
.control-group.error .fileupload .uneditable-input{color:#b94a48;border-color:#b94a48;}
.control-group.error .fileupload .fileupload-preview{color:#b94a48;}
.control-group.error .fileupload .thumbnail{border-color:#b94a48;}
.control-group.success .fileupload .uneditable-input{color:#468847;border-color:#468847;}
.control-group.success .fileupload .fileupload-preview{color:#468847;}
.control-group.success .fileupload .thumbnail{border-color:#468847;}

</style>

<div id="md_table_education_container">
    <div id="no-datamd_table_education">No data</div>
    <table id="md_table_education" class="table table-striped table-bordered" style="display:none">
        <thead>
            <tr>
                <th>Start Year</th>
                <th>End Year</th>
                <th>Institution</th>
                <th>City</th>
                <th>Level</th>
                <th>Faculty</th>
                <th>GPA</th>
                <th>Major</th>
               
                <th colspan="2" width="8%">File Attachment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- the data presentation be here -->
        </tbody>
    </table>
    <div class="fbutton">
        <span id="md_field_education_add" class="add btn btn-default">
            <i class="glyphicon glyphicon-tower"></i> Educations </span>
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

    console.log(DATA_education);


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
        
        

        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduStart')){
          field_value = value.EduStart;
        }
        component += '<td>';
        component += '<input onkeypress="return isNumberKey(event);" style="width: 60px;" id="md_field_education_col_EduStart_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col" column_name="EduStart" type="text" maxlength="4" value="'+field_value+'"/>';
        component += '</td>';



        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduFinish')){
          field_value = value.EduFinish;
        }
        component += '<td>';
        component += '<input onkeypress="return isNumberKey(event);" style="width: 60px;" id="md_field_education_col_EduFinish_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col" column_name="EduFinish" type="text" maxlength="4" value="'+field_value+'"/>';
        component += '</td>';



        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduInstitution"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduInstitution')){
          field_value = value.EduInstitution;
        }
        component += '<td>';
        component += '<select style="width: 300px !important; min-width: 300px; max-width: 300px;" id="md_field_education_col_EduInstitution_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col numeric chzn-select" column_name="EduInstitution" >';
        var options = OPTIONS_education.EduInstitution;
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
        //    FIELD "EduCity"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduCity')){
          field_value = value.EduCity;
        }
        component += '<td>';
        component += '<select style="width: 150px !important; min-width: 150px; max-width: 150px;" id="md_field_education_col_EduCity_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col numeric chzn-select" column_name="EduCity" >';
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
        //    FIELD "EduLevelId"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduLevelId')){
          field_value = value.EduLevelId;
        }
        component += '<td>';
        component += '<select style="width: 80px !important; min-width: 80px; max-width: 80px;" id="md_field_education_col_EduLevelId_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col numeric chzn-select" column_name="EduLevelId" >';
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
        //    FIELD "EduFaculty"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduFaculty')){
          field_value = value.EduFaculty;
        }
        component += '<td>';
        component += '<select style="width: 250px !important; min-width: 250px; max-width: 250px;" id="md_field_education_col_EduFaculty_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col numeric chzn-select" column_name="EduFaculty" >';
        var options = OPTIONS_education.EduFaculty;
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
        //    FIELD "EduGPA"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduGPA')){
          field_value = value.EduGPA;
        }
        component += '<td>';
        component += '<input onkeypress="return isNumberKeyComma(event);" maxlength="5" style="width: 40px;" id="md_field_education_col_EduGPA_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col" column_name="EduGPA" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduMajor"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduMajor')){
          field_value = value.EduMajor;
        }
        component += '<td>';
        component += '<input style="width: 250px;" id="md_field_education_col_EduMajor_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" class="md_field_education_col" column_name="EduMajor" type="text" value="'+field_value+'"/>';
        component += '</td>';



        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduFileUrl"
        /////////////////////////////////////////////////////////////////////////////////////////////////////

        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduFileUrl')){
            field_value = value.EduFileUrl;
        }      

        var base_url = '<?php echo base_url();?>';
        component += '<td>';
        component += '<div class="fileupload fileupload-new" data-provides="fileupload"><span class="btn btn-primary btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input id="md_field_education_col_EduFileUrl_'+RECORD_INDEX_education+'" record_index="'+RECORD_INDEX_education+'" type="file" data-trigger="fileload" column_name="EduFileUrl" name="md_field_education_col_EduFileUrl_'+RECORD_INDEX_education+'" value="'+field_value+'" /></span><span class="fileupload-preview"></span><a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a></div>';
        component += '</td>';      

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "EduFileUrl"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('EduFileUrl')){
            field_value = value.EduFileUrl;
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
        component += '<td><span class="delete-icon btn btn-default md_field_education_delete" record_index="'+RECORD_INDEX_education+'"><i class="glyphicon glyphicon-minus-sign"></i></span></td>';
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
        if (settings.url == "{{ module_site_url }}frmKaryawan/index/insert") {
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
                yearRange: "c-200:c+200",
        });
        // date-picker-input-clear
        $('#md_table_education .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_education .datetime-input').datepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            yearRange: "c-70:c+70",
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

    function isNumberKeyComma(evt){
        var e = window.event || evt; // for trans-browser compatibility 
    var charCode = e.which || e.keyCode; 
    if ((charCode > 45 && charCode < 58) || charCode == 8){ 
        return true; 
    } 
    return false;  
    }

</script>




<!--
<script type="text/javascript">
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
</script>
-->


<script>
  
    // fungsi autocomplete
    function autocomplete(){
      $( ".auto" ).autocomplete({
       source: "http://<?php echo $_SERVER['SERVER_NAME'];?>/hris2/includes/Search_University.php", 
         minLength:2,
      });
      
      // hapus inputan data 
      $(".hapus").click(function(){
        $(this).parent().parent().remove();
      });
    }
    $(function(){
      // fungsi autocomplete default
      $( ".tftextinput" ).autocomplete({
       source: "http://<?php echo $_SERVER['SERVER_NAME'];?>/hris2/includes/Search_University.php", 
         minLength:2,
      });
      
      // fungsi untuk menambahkan inputan data
      $("#tambah").click(function(){
        row = '<tr><td></td><td><input type="text" name="nik[]" class="auto" /></td>'+
        '<td><button class="hapus">Hapus</button></td></tr>';
        $(row).insertBefore("#last");
        autocomplete();
      });
    });
</script>
