<?php

    $record_index = 0;
    $max_data     = 20;
        
?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />

<style type="text/css">
    #md_table_fpts input[type="text"]{        
    }
    #md_table_fpts .chzn-drop input[type="text"]{       
    }
    #md_table_fpts th:last-child, #md_table_fpts td:last-child{       
    }
</style>

<style type="text/css">
.label-info {
    background-color: #FFFF00;
    color:#000000;
}
.label-warning {
    background-color: #FF9900;
}
.label-default{
    font-size: 12px;
    width: 100%;
}

</style>

<div id="md_table_fpts_container">
    <!--<div id="no-datamd_table_fpts">No data</div>-->
    <div style="padding-left:1%">
        <span id="md_field_fpts_add" class="add btn btn-default fbutton"><i class="glyphicon glyphicon-plus-sign"></i> Add Participant </span>
        <span class="delete-icon btn btn-default md_field_fpts_delete" id="delete_rows" record_index=""><i class="glyphicon glyphicon-minus-sign"></i> Delete Row</span>        
    </div>
    <br />

    <table id="md_table_fpts" align="center" class="table table-striped table-bordered" style="width:98%;table-layout:fixed;">
       
        <thead style="border-top:1px solid #999999; background:#E1DFD7">
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="50%" class="text-center">Nama</th>
                <th class="text-center">Jabatan</th>                
                <th class="text-center">Ikatan Dinas</th>                             
            </tr>           
        </thead>
        <tbody>
            <!-- the data presentation be here -->
        </tbody>   


    </table>    
    <!-- This is the real input. If you want to catch the data, please json_decode this input's value--> 

    <input id="md_real_field_fpts_col" name="md_real_field_fpts_col" type="hidden"/>
    <!--<textarea id="md_real_field_fpts_col" name="md_real_field_fpts_col" style="width: 98%; height: 100%; border: 1px solid #999999;" type="hidden"></textarea>-->
</div>

<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/ui/'.grocery_CRUD::JQUERY_UI_JS); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.ui.datetime.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.numeric.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery-ui-timepicker-addon.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/function/toword_id.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/function/terbilang_js_id.js'); ?>"></script>

<script type="text/javascript">

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // DATA INITIALIZATION
    //
    // * Prepare some global variables
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    var DATE_FORMAT = '<?php echo $date_format ?>';
    var OPTIONS_fpts = <?php echo json_encode($options); ?>;
    var RECORD_INDEX_fpts = <?php echo $record_index; ?>;
    var DATA_fpts = {update:new Array(), insert:new Array(), delete:new Array()};
    var old_data = <?php echo json_encode($result); ?>;
    var profile_data = <?php echo json_encode($profile_data); ?>;

    for(var i=0; i<old_data.length; i++){
        var row = old_data[i];
        var record_index = i;
        var primary_key = row['FPTSDtlID'];
        var data = row;
        delete data['FPTSDtlID'];
        DATA_fpts.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }  
    


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ADD ROW FUNCTION
    //
    // * When "Add fpts" clicked, this function is called without parameter.
    // * When page loaded for the first time, this function is called with value parameter
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function add_table_row_fpts(value){
        // hide no-data div
        $("#no-datamd_table_fpts").hide();
        $("#md_table_fpts").show();

        count = $('#md_table_fpts tr').length;
        real = count-1;
        
        document.getElementById("delete_rows").setAttribute("record_index",real);

        RECORD_INDEX_fpts = real;
       
        var component = '<tr id="md_field_fpts_tr_'+RECORD_INDEX_fpts+'" class="md_field_fpts_tr">';

        component += '<td><div align="center">';
        component += RECORD_INDEX_fpts+1;
        component += '</div></td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "ParticipantID"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        

        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('ParticipantID')){
          field_value = value.ParticipantID;
        }
        component += '<td>';
        component += '<select id="md_field_fpts_col_ParticipantID_'+RECORD_INDEX_fpts+'" record_index="'+RECORD_INDEX_fpts+'" class="md_field_fpts_col numeric chzn-select form-control" column_name="ParticipantID" onchange="option_select('+RECORD_INDEX_fpts+');">';
        var options = OPTIONS_fpts.ParticipantID;
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
        //    FIELD "JabatanID"
        /////////////////////////////////////////////////////////////////////////////////////////////////////      

        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('JabatanID')){
          field_value = value.JabatanID;
        }    

        component += '<td class="text-center">';
        component += '<input id="md_field_fpts_col_JabatanID_'+RECORD_INDEX_fpts+'" record_index="'+RECORD_INDEX_fpts+'" class="md_field_fpts_col form-control" column_name="JabatanID" type="text" value="'+field_value+'" readonly/>';
        component += '</td>'; 


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "ServiceQty"
        /////////////////////////////////////////////////////////////////////////////////////////////////////      

        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('ServiceQty')){
          field_value = value.ServiceQty;
        }
        component += '<td class="text-center">';
        component += '<input id="md_field_fpts_col_ServiceQty_'+RECORD_INDEX_fpts+'" record_index="'+RECORD_INDEX_fpts+'" class="md_field_fpts_col form-control" column_name="ServiceQty" type="text" placeholder="" maxlength="50" value="'+field_value+'" readonly/>';
        component += '</td>';

        component += '</tr>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_fpts tbody').append(component);

        mutate_input_fpts();

    } // end of ADD ROW FUNCTION



    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Main event handling program
    //
    // * Initialization
    // * md_field_fpts_add.click (Add row)
    // * md_field_fpts_delete.click (Delete row)
    // * md_field_fpts_col.change (Edit cell)
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){

        var id = 0;

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // INITIALIZATION
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        synchronize_fpts();
        for(var i=0; i<DATA_fpts.update.length; i++){
            add_table_row_fpts(DATA_fpts.update[i].data);
            RECORD_INDEX_fpts++;           
        }
        synchronize_fpts_table_width();

        // on resize, adjust the table width
        $(window).resize(function() {
            synchronize_fpts_table_width();
        });
        

        count = $('#md_table_fpts tr').length;
        real = count-2;       



        if (real < 0){
            document.getElementById("save-and-go-back-button").disabled = true;
        }
        else{
            document.getElementById("save-and-go-back-button").disabled = false;
        }
        
       


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_fpts_add.click (Add row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_field_fpts_add').click(function(){
            // new data

        if($("tr.md_field_fpts_tr").length<'<?php echo $max_data ?>')

        var data = new Object();
            
        data.ParticipantID = '';
        data.JabatanID = '';
        data.ServiceQty = '';       


        count = $('#md_table_fpts tr').length;
        real  = count-1;

        var ParticipantQty = real+1;
        document.getElementById('ParticipantQty').value = ParticipantQty; 

        //document.getElementById("delete_rows").setAttribute("record_index",real);
        //document.getElementById('delete_rows').innerHTML = 'Delete Row '+real;

        //$('#counter').html(real);
        //$('#counter-del').html(getGetOrdinal(n=real));
        
        number_change();
            // insert data to the DATA_fpts
            DATA_fpts.insert.push({
                'record_index' : real,
                'primary_key' : '',
                'data' : data,
            });

            // add table's row
            add_table_row_fpts(data);
            //disabled_tombol(RECORD_INDEX_fpts);
            //find_duplicate_value();
            // add  by 1
            RECORD_INDEX_fpts++;

            // synchronize to the md_real_field_fpts_col
            synchronize_fpts();
            synchronize_fpts_table_width();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_fpts_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_fpts_delete').live('click', function(){
            //var record_index = $(this).attr('record_index');
            // remove the component
           // $('#md_field_fpts_tr_'+record_index).remove();


            //var $tbody = $("#md_table_fpts tbody");
            //var $last = $tbody.find('tr:last');

            var record_index = $(this).attr('record_index');
            // remove the component
            $('#md_field_fpts_tr_'+record_index).remove();

            // remove the component

            //$('#md_field_performance_tr_'+last).remove();

                    
            //$last.remove();

            count = $('#md_table_fpts tr').length;
            real = count-2;

            document.getElementById("delete_rows").setAttribute("record_index", real);
            //document.getElementById('delete_rows').innerHTML = 'Delete Row '+real;

            if (real < 0){
                document.getElementById("save-and-go-back-button").disabled = true;
            }
            else{
                document.getElementById("save-and-go-back-button").disabled = false;
            }

            var ParticipantQty = real+1;
            document.getElementById('ParticipantQty').value = ParticipantQty;           

            number_change();

            var record_index_found = false;
            for(var i=0; i<DATA_fpts.insert.length; i++){
                if(DATA_fpts.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_fpts.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_fpts.update.length; i++){
                    if(DATA_fpts.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_fpts.update[i].primary_key;
                        // delete element from update
                        DATA_fpts.update.splice(i,1);
                        // add it to delete
                        DATA_fpts.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }
            synchronize_fpts();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_fpts_col.change (Edit cell)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_fpts_col').live('change', function(){
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
            for(var i=0; i<DATA_fpts.insert.length; i++){
                if(DATA_fpts.insert[i].record_index == record_index){
                    record_index_found = true;
                    // insert value
                    eval('DATA_fpts.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_fpts.update.length; i++){
                    if(DATA_fpts.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value
                        eval('DATA_fpts.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        break;
                    }
                }
            }
            synchronize_fpts();
        });


    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // reset field on save
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url == "{{ module_site_url }}frmKasbon/index/insert") {
            response = $.parseJSON(xhr.responseText);
            if(response.success == true){
                DATA_fpts = {update:new Array(), insert:new Array(), delete:new Array()};
                $('#md_table_fpts tr').not(':first').remove();
                synchronize_fpts();
            }
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize data to md_real_field_fpts_col.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_fpts(){
        $('#md_real_field_fpts_col').val(JSON.stringify(DATA_fpts));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize table width (called on resize and add).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_fpts_table_width(){
        var parent_width = $("#md_table_fpts_container").parent().parent().width();
        if($("#md_table_fpts_container table:visible").length > 0){
            $("#md_table_fpts_container").width(parent_width);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // function to mutate input
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function mutate_input_fpts(){
        // datepicker-input
        $('#md_table_fpts .datepicker-input').datepicker({
                dateFormat: js_date_format,
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-100:c+100",
        });
        // date-picker-input-clear
        $('#md_table_fpts .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_fpts .datetime-input').datetimepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
        
        $('#md_table_fpts .datetime-input-clear').button();
        
        $('#md_table_fpts .datetime-input-clear').click(function(){
            $(this).parent().find('.datetime-input').val("");
            return false;
        });
        // chzn-select
        $("#md_table_fpts .chzn-select").chosen({allow_single_deselect: true});
        // numeric
        $('#md_table_fpts .numeric').numeric();
        $('#md_table_fpts .numeric').keydown(function(e){
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

    function get_profile_rate(nik){
      return profile_data.filter(
          function(profile_data){
            if (profile_data.NIK == nik){        
                var founds = profile_data.JabatanID;
                return profile_data.NamaJabatan;              
            }else{
                return false;        
            }            
          }
      );
    }


    function option_select(input) {
        
        var max_data = real;
        var gn, elem;
        var sum = 0;   

        var base_url = '<?php echo base_url()?>';

        for (i=0; i <= max_data; ++i) {

            gn   = 'md_field_fpts_col_ParticipantID_'+(i);
            elem = document.getElementById(gn);
            sum  = Number(elem.value);

            var found = get_profile_rate(sum);

            if (found == 0){
                var jabatan_name     = 'N/A';                
            }
            else{
                var jabatan_name     = found[0].NamaJabatan;
            }

            document.getElementById("md_field_fpts_col_JabatanID_"+i).value= jabatan_name;

            var xx  = document.getElementById("md_field_fpts_col_ParticipantID_"+i).value;

            if (sum <= 0 || xx == ''){
                document.getElementById("save-and-go-back-button").disabled = true;
            }
            else{
                document.getElementById("save-and-go-back-button").disabled = false;
            }

        }


        var x  = document.getElementById("md_field_fpts_col_ParticipantID_"+input).value;


        if (x == ''){
            document.getElementById("save-and-go-back-button").disabled = true;
        }
        else{
            document.getElementById("save-and-go-back-button").disabled = false;
        }     


    }
    
   





    

</script>