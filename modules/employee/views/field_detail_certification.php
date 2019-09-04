<?php
    $record_index = 0;
    $upload_path = base_url('modules/karyawan/assets/uploads').'/';
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    #md_table_certification input[type="text"]{
        max-width:300px;
    }
    #md_table_certification .chzn-drop input[type="text"]{
        max-width:240px;
    }
    #md_table_certification th:last-child, #md_table_certification td:last-child{
        width: 60px;
    }
    #certification_display_as_box{
        display: none;
    }
    #md_table_certification{
        font-size: 12px;
    }
    #md_table_certification textarea{
        width: 280px;
    }
    
</style>

<div id="md_table_certification_container">
    <div id="no-datamd_table_certification">No data</div>
    <table id="md_table_certification" class="table table-striped table-bordered row-border" style="display:none;">
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Product</th>
                <th>Certificate</th>
                <th>Institution</th>
                <th>Valid From</th>
                <th>Valid Until</th>
                <th>Status</th>                
                <th>Evidence</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            <!-- the data presentation be here -->
        </tbody>
    </table>
    <div class="fbutton">
        <span id="md_field_certification_add" class="add btn btn-success btn-xs">
            <i class="glyphicon glyphicon-plus-sign"></i> Add certification </span>
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
        var statusdisable = '';
        var field_value_status = '';
        var field_value_valid = '';

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertDate')){
          field_value = php_date_to_js(value.CertDate);
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertStatus')){
          field_value_status = value.CertStatus;
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertValidFinish')){
          field_value_valid = php_date_to_js(value.CertValidFinish);
        }

        if(field_value_status == 0 && field_value_valid.length>0) {
            var statusdisable = 'disabled';
        }


        component += '<td>';
        component += '<input style="width: 80px;" id="md_field_certification_col_CertDate_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col form-control datepicker-input" column_name="CertDate" placeholder="tgl terbit" type="text" value="'+field_value+'" '+statusdisable+' />';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertItem"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        var statusdisable = '';
        var field_value_status = '';
        var field_value_valid = '';

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertItem')){
          field_value = value.CertItem;
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertStatus')){
          field_value_status = value.CertStatus;
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertValidFinish')){
          field_value_valid = php_date_to_js(value.CertValidFinish);
        }

        if(field_value_status == 0 && field_value_valid.length>0) {
            var statusdisable = 'disabled';
        }

        component += '<td>';
        component += '<select '+statusdisable+' style="width: 100px !important; min-width: 100px; max-width: 100px;" id="md_field_certification_col_CertItem_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col form-control numeric chzn-select" column_name="CertItem" >';
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
        var statusdisable = '';

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertProduct')){
          field_value = value.CertProduct;
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertStatus')){
          field_value_status = value.CertStatus;
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertValidFinish')){
          field_value_valid = php_date_to_js(value.CertValidFinish);
        }

        if(field_value_status == 0 && field_value_valid.length>0) {
            var statusdisable = 'disabled';
        }

        component += '<td>';
        component += '<input style="width:150px;" id="md_field_certification_col_CertProduct_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col form-control" column_name="CertProduct" type="text" placeholder="" value="'+field_value+'" '+statusdisable+'/>';
        component += '</td>';        


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertName"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        var statusdisable = '';

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertName')){
          field_value = value.CertName;
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertStatus')){
          field_value_status = value.CertStatus;
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertValidFinish')){
          field_value_valid = php_date_to_js(value.CertValidFinish);
        }

        if(field_value_status == 0 && field_value_valid.length>0) {
            var statusdisable = 'disabled';
        }

        component += '<td>';
        component += '<input style="width:250px;" id="md_field_certification_col_CertName_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col form-control" column_name="CertName" type="text" placeholder="nama sertifikat" value="'+field_value+'" '+statusdisable+'/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertPartnerName"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        var statusdisable = '';

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertPartnerName')){
          field_value = value.CertPartnerName;
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertStatus')){
          field_value_status = value.CertStatus;
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertValidFinish')){
          field_value_valid = php_date_to_js(value.CertValidFinish);
        }

        if(field_value_status == 0 && field_value_valid.length>0) {
            var statusdisable = 'disabled';
        }

        component += '<td>';
        component += '<input style="width:150px;" id="md_field_certification_col_CertPartnerName_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col form-control" column_name="CertPartnerName" type="text" placeholder="lembaga yg menerbitkan" value="'+field_value+'" '+statusdisable+'/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertValidStart"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        var statusdisable = '';

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertValidStart')){
          field_value = php_date_to_js(value.CertValidStart);
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertStatus')){
          field_value_status = value.CertStatus;
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertValidFinish')){
          field_value_valid = php_date_to_js(value.CertValidFinish);
        }

        if(field_value_status == 0 && field_value_valid.length>0) {
            var statusdisable = 'disabled';
        }

        component += '<td>';
        component += '<input style="width: 80px;" id="md_field_certification_col_CertValidStart_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col form-control datepicker-input" column_name="CertValidStart" placeholder="berlaku dari" type="text" value="'+field_value+'" '+statusdisable+'/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertValidFinish"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        var statusdisable = '';

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertValidFinish')){
          field_value = php_date_to_js(value.CertValidFinish);
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertStatus')){
          field_value_status = value.CertStatus;
        }

        if(field_value_status == 0 && field_value_valid.length>0) {
            var statusdisable = 'disabled';
        }

        component += '<td>';
        component += '<input style="width: 80px;" id="md_field_certification_col_CertValidFinish_'+RECORD_INDEX_certification+'" record_index="'+RECORD_INDEX_certification+'" class="md_field_certification_col form-control datepicker-input" column_name="CertValidFinish" placeholder="berlaku sampai" type="text" value="'+field_value+'" '+statusdisable+' onblur="cekdatanilai(this.id,this.value)"  />';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertStatus"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertStatus')){
          field_value = value.CertStatus;
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertValidFinish')){
          field_value_valid = php_date_to_js(value.CertValidFinish);
        }

        if(field_value_valid.length>0) {                        
            if(field_value == 1){
                var field_text = '<span class="label label-success">Active</span>';
            }
            else{
                var field_text = '<span class="label label-warning">Inactive</span>';
            }
        } else {
            var field_text = '';
        }
        component += '<td>';
        component += field_text;
        component += '</td>';       
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "CertFileUrl"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertStatus')){
          field_value_status = value.CertStatus;
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertValidFinish')){
          field_value_valid = php_date_to_js(value.CertValidFinish);
        }

        if(field_value_status == 0 && field_value_valid.length>0) {
            var statusdisable = 'disabled';
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertFileUrl')){
            field_value = value.CertFileUrl;
        }

        component += '<td>';
        if(field_value != '' && field_value != null){
            component += '<a href="'+UPLOAD_PATH+field_value+'" class="btn btn-xs btn-primary" target="_blank"><i class="glyphicon glyphicon-download-alt"</i></a>';
        }else{
            component += '<input id="md_field_certification_col_CertFileUrl_'+RECORD_INDEX_certification+
                  '" record_index="'+RECORD_INDEX_certification+
                  '" class="md_field_certification_col" column_name="CertFileUrl" type="file"'+
                  ' name="md_field_certification_col_CertFileUrl_'+RECORD_INDEX_certification+'" value="'+field_value+'" '+statusdisable+' />';
        }
        component += '</td>';
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete Button
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertStatus')){
          field_value_status = value.CertStatus;
        }

        if(typeof(value) != 'undefined' && value.hasOwnProperty('CertValidFinish')){
          field_value_valid = php_date_to_js(value.CertValidFinish);
        }

        /* UNTUK MENGHILANGKAN TOMBOL DELETE */
        if(1 == 1) {
            
        } else {
            component += '<td><span class="delete-icon btn btn-danger btn-xs md_field_certification_delete" record_index="'+RECORD_INDEX_certification+'"><i class="glyphicon glyphicon-trash"></i></span></td>';
            component += '</tr>';
        }


        

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
            
            data.CertDate = '';
            data.CertItem = '1';
            data.CertProduct = '';
            data.CertPartnerName = '';
            data.CertName = '';
            data.CertValidStart = '';
            data.CertValidFinish = '';
            data.CertFileUrl = '';
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
        if (settings.url == "{{ module_site_url }}form_my_resume/index/insert") {
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
                yearRange: "c-100:c+100",
        });
        // date-picker-input-clear
        $('#md_table_certification .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_certification .datetime-input').datetimepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
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