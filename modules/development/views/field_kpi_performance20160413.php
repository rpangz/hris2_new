<?php
    $record_index = 1;
    $this->load->model('development_model');
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    #md_table_citizen input[type="text"]{
        /*max-width:100px;*/
    }
    #md_table_citizen .chzn-drop input[type="text"]{
        max-width:240px;
    }
    #md_table_citizen th:last-child, #md_table_citizen td:last-child{
        /*width: 60px;*/
    }

    div.ext-box { display: table; }
div.int-box { display: table-cell; vertical-align: middle; }

</style>

<div id="md_table_citizen_container">
    <div id="no-datamd_table_citizen">No data</div>
    <table id="md_table_citizen" class="table table-striped table-bordered table-hover" style="width:100%">
        <thead>
            <tr>
                <th rowspan="3">#</th>
                <th rowspan="3"><div align="center">Area Kerja</div></th>
                <th rowspan="3"><div align="center">Target Kerja</div></th>
                <th rowspan="3" valign="middle"><div align="center">Bobot</div></th>
                <th rowspan="3"><div align="center">Hasil yang Dicapai</div></th>
                <th colspan="10"><div align="center">Kategori Penilaian</div></th>
                <th rowspan="3">Action</th>
            </tr>
            <tr>                
                <th colspan="3" bgcolor="#00FF00"><div align="center">Baik</div></th>
                <th colspan="3" bgcolor="#FFFF00"><div align="center">Cukup</div></th>
                <th colspan="4" bgcolor="#FF9900"><div align="center">Kurang</div></th>
            </tr>
                <th width="2%" bgcolor="#00FF00"><div align="center">10</div></th>
                <th width="2%" bgcolor="#00FF00"><div align="center">9</div></th>
                <th width="2%" bgcolor="#00FF00"><div align="center">8</div></th>
                <th width="2%" bgcolor="#FFFF00"><div align="center">7</div></th>
                <th width="2%" bgcolor="#FFFF00"><div align="center">6</div></th>
                <th width="2%" bgcolor="#FFFF00"><div align="center">5</div></th>
                <th width="2%" bgcolor="#FF9900"><div align="center">4</div></th>
                <th width="2%" bgcolor="#FF9900"><div align="center">3</div></th>
                <th width="2%" bgcolor="#FF9900"><div align="center">2</div></th>
                <th width="2%" bgcolor="#FF9900"><div align="center">1</div></th>
                
            </tr>
        </thead>
        <tbody id="mytbody">            
            
        </tbody>
    </table>

    <table style="width:100%">
        <thead>
        <tr>
            <th rowspan="5">Score (%) : </th>
            <th rowspan="11"><input type="text" class="form-control" id="total_performance" value="" size="50" readonly></th>
        </tr>
    </thead>
    </table>
    <br/>

    
    <div class="fbutton">
        <span id="md_field_citizen_add" class="add btn btn-default">
            <i class="glyphicon glyphicon-plus-sign"></i> Add Row </span>
    </div>
    <br />
    <!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
    <input id="md_real_field_citizen_col" name="md_real_field_citizen_col" type="hidden" />
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
    var OPTIONS_citizen = <?php echo json_encode($options); ?>;
    var RECORD_INDEX_citizen = <?php echo $record_index; ?>;
    var DATA_citizen = {update:new Array(), insert:new Array(), delete:new Array()};
    var old_data = <?php echo json_encode($result); ?>;
    for(var i=0; i<old_data.length; i++){
        var row = old_data[i];
        var record_index = i;
        var primary_key = row['NIK'];
        var data = row;
        delete data['NIK'];
        DATA_citizen.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }

    var arr = [];
    
    

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ADD ROW FUNCTION
    //
    // * When "Add Citizen" clicked, this function is called without parameter.
    // * When page loaded for the first time, this function is called with value parameter
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function add_table_row_citizen(value){
        // hide no-data div
        $("#no-datamd_table_citizen").hide();
        $("#md_table_citizen").show();

        var component = '<tr id="md_field_citizen_tr_'+RECORD_INDEX_citizen+'" class="md_field_citizen_tr">';
    

        component += '<td>';
        component += '<input type="text" name="id[]" value="0" class="id" />';
        component += '</td>';


        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('Nama')){
          field_value = value.Nama;
        }
        component += '<td>';
        component += '<textarea style="width: 100%; height: 100px;" id="md_field_citizen_col_WorkExpPosition_'+RECORD_INDEX_citizen+'" record_index="'+RECORD_INDEX_citizen+'" class="md_field_citizen_col form-control" column_name="Nama">'+field_value+'</textarea>';
        component += '</td>';


       
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('Email')){
          field_value = value.Email;
        }
        component += '<td>';
        component += '<textarea style="width: 100%; height: 100px;" id="md_field_citizen_col_WorkExpPosition_'+RECORD_INDEX_citizen+'" record_index="'+RECORD_INDEX_citizen+'" class="md_field_citizen_col form-control" column_name="Email">'+field_value+'</textarea>';
        component += '</td>';


        
      
        component += '<td>';
        component += '20%';
        component += '</td>';


        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('NoKK')){
          field_value = value.NoKK;
        }
        component += '<td>';
        component += '<textarea style="width: 100%; height: 100px;" id="md_field_citizen_col_WorkExpPosition_'+RECORD_INDEX_citizen+'" record_index="'+RECORD_INDEX_citizen+'" class="md_field_citizen_col form-control" column_name="Sex">'+field_value+'</textarea>';
        component += '</td>';
 

        // radio select

        component += '<td>';
        component += '<input id="md_field_citizen_col_radio_performace_10'+RECORD_INDEX_citizen+'" record_index="'+RECORD_INDEX_citizen+'" class="md_field_citizen_col" column_name="radio_performace" name="radio_performace_'+RECORD_INDEX_citizen+'" type="radio" value="10" onclick="UpdateCostPerformance()"/>';
        component += '</td>';


        component += '<td>';
        component += '<input id="md_field_citizen_col_radio_performace_9'+RECORD_INDEX_citizen+'" record_index="'+RECORD_INDEX_citizen+'" class="md_field_citizen_col" column_name="radio_performace" name="radio_performace_'+RECORD_INDEX_citizen+'" type="radio" value="9" onclick="UpdateCostPerformance()"/>';
        component += '</td>';


        component += '<td>';
        component += '<input id="md_field_citizen_col_radio_performace_8'+RECORD_INDEX_citizen+'" record_index="'+RECORD_INDEX_citizen+'" class="md_field_citizen_col" column_name="radio_performace" name="radio_performace_'+RECORD_INDEX_citizen+'" type="radio" value="8" onclick="UpdateCostPerformance()"/>';
        component += '</td>';

        component += '<td>';
        component += '<input id="md_field_citizen_col_radio_performace_7'+RECORD_INDEX_citizen+'" record_index="'+RECORD_INDEX_citizen+'" class="md_field_citizen_col" column_name="radio_performace" name="radio_performace_'+RECORD_INDEX_citizen+'" type="radio" value="7" onclick="UpdateCostPerformance()"/>';
        component += '</td>';

        component += '<td>';
        component += '<input id="md_field_citizen_col_radio_performace_6'+RECORD_INDEX_citizen+'" record_index="'+RECORD_INDEX_citizen+'" class="md_field_citizen_col" column_name="radio_performace" name="radio_performace_'+RECORD_INDEX_citizen+'" type="radio" value="6" onclick="UpdateCostPerformance()"/>';
        component += '</td>';

        component += '<td>';
        component += '<input id="md_field_citizen_col_radio_performace_5'+RECORD_INDEX_citizen+'" record_index="'+RECORD_INDEX_citizen+'" class="md_field_citizen_col" column_name="radio_performace" name="radio_performace_'+RECORD_INDEX_citizen+'" type="radio" value="5" onclick="UpdateCostPerformance()"/>';
        component += '</td>';

        component += '<td>';
        component += '<input id="md_field_citizen_col_radio_performace_4'+RECORD_INDEX_citizen+'" record_index="'+RECORD_INDEX_citizen+'" class="md_field_citizen_col" column_name="radio_performace" name="radio_performace_'+RECORD_INDEX_citizen+'" type="radio" value="4" onclick="UpdateCostPerformance()"/>';
        component += '</td>';

        component += '<td>';
        component += '<input id="md_field_citizen_col_radio_performace_3'+RECORD_INDEX_citizen+'" record_index="'+RECORD_INDEX_citizen+'" class="md_field_citizen_col" column_name="radio_performace" name="radio_performace_'+RECORD_INDEX_citizen+'" type="radio" value="3" onclick="UpdateCostPerformance()"/>';
        component += '</td>';

        component += '<td>';
        component += '<input id="md_field_citizen_col_radio_performace_2'+RECORD_INDEX_citizen+'" record_index="'+RECORD_INDEX_citizen+'" class="md_field_citizen_col" column_name="radio_performace" name="radio_performace_'+RECORD_INDEX_citizen+'" type="radio" value="2" onclick="UpdateCostPerformance()"/>';
        component += '</td>';

        component += '<td>';
        component += '<input id="md_field_citizen_col_radio_performace_1'+RECORD_INDEX_citizen+'" record_index="'+RECORD_INDEX_citizen+'" class="md_field_citizen_col" column_name="radio_performace" name="radio_performace_'+RECORD_INDEX_citizen+'" type="radio" value="1" onclick="UpdateCostPerformance()"/>';
        component += '</td>';

        

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete Button
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        component += '<td><span class="delete-icon btn btn-default md_field_citizen_delete" record_index="'+RECORD_INDEX_citizen+'"><i class="glyphicon glyphicon-minus-sign"></i></span></td>';
        component += '</tr>';
/*
        component += '<tr>';
        component += '<td colspan="5">';
        component += 'Score (%) :';
        component += '</td>';
        component += '<td colspan="11">';
        component += '2.5';
        component += '</td>';
        component += '<tr>';
*/
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_citizen tbody').append(component);
        mutate_input_citizen();

    } // end of ADD ROW FUNCTION





    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Main event handling program
    //
    // * Initialization
    // * md_field_citizen_add.click (Add row)
    // * md_field_citizen_delete.click (Delete row)
    // * md_field_citizen_col.change (Edit cell)
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // INITIALIZATION
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        synchronize_citizen();
        for(var i=0; i<DATA_citizen.update.length; i++){
            add_table_row_citizen(DATA_citizen.update[i].data);
            RECORD_INDEX_citizen++;
        }
        synchronize_citizen_table_width();

        // on resize, adjust the table width
        $(window).resize(function() {
            synchronize_citizen_table_width();
        });

         



        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_citizen_add.click (Add row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_field_citizen_add').click(function(){

            if($("tr.md_field_citizen_tr").length<'<?php echo 5 ?>')

            //if($("tr.md_field_citizen_tr").length<5)
            // new data
            var data = new Object();

            
            
          data.NIK = '';
          data.Nama = '';
          data.Email = '';
          data.Sex = '';

          
            // insert data to the DATA_citizen
            DATA_citizen.insert.push({
                'record_index' : RECORD_INDEX_citizen,
                'primary_key' : '',
                'data' : data,
            });

            // add table's row
            add_table_row_citizen(data);
            // add  by 1
            RECORD_INDEX_citizen++;

            // synchronize to the md_real_field_citizen_col
            synchronize_citizen();
            synchronize_citizen_table_width();
        });

        

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_citizen_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_citizen_delete').live('click', function(){
            var record_index = $(this).attr('record_index');
            // remove the component
            $('#md_field_citizen_tr_'+record_index).remove();

            var record_index_found = false;
            for(var i=0; i<DATA_citizen.insert.length; i++){
                if(DATA_citizen.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_citizen.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_citizen.update.length; i++){
                    if(DATA_citizen.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_citizen.update[i].primary_key;
                        // delete element from update
                        DATA_citizen.update.splice(i,1);
                        // add it to delete
                        DATA_citizen.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }
            synchronize_citizen();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_citizen_col.change (Edit cell)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_citizen_col').live('change', function(){
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
            for(var i=0; i<DATA_citizen.insert.length; i++){
                if(DATA_citizen.insert[i].record_index == record_index){
                    record_index_found = true;
                    // insert value
                    eval('DATA_citizen.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_citizen.update.length; i++){
                    if(DATA_citizen.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value
                        eval('DATA_citizen.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        break;
                    }
                }
            }
            synchronize_citizen();
        });


    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // reset field on save
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url == "{{ module_site_url }}frmKeyPerformanceIndicator/index/insert") {
            response = $.parseJSON(xhr.responseText);
            if(response.success == true){
                DATA_citizen = {update:new Array(), insert:new Array(), delete:new Array()};
                $('#md_table_citizen tr').not(':first').remove();
                synchronize_citizen();
            }
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize data to md_real_field_citizen_col.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_citizen(){
        $('#md_real_field_citizen_col').val(JSON.stringify(DATA_citizen));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize table width (called on resize and add).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_citizen_table_width(){
        var parent_width = $("#md_table_citizen_container").parent().parent().width();
        if($("#md_table_citizen_container table:visible").length > 0){
            $("#md_table_citizen_container").width(parent_width);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // function to mutate input
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function mutate_input_citizen(){
        // datepicker-input
        $('#md_table_citizen .datepicker-input').datepicker({
                dateFormat: js_date_format,
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-100:c+100",
        });
        // date-picker-input-clear
        $('#md_table_citizen .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_citizen .datetime-input').datetimepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
        
        $('#md_table_citizen .datetime-input-clear').button();
        
        $('#md_table_citizen .datetime-input-clear').click(function(){
            $(this).parent().find('.datetime-input').val("");
            return false;
        });
        // chzn-select
        $("#md_table_citizen .chzn-select").chosen({allow_single_deselect: true});
        // numeric
        $('#md_table_citizen .numeric').numeric();
        $('#md_table_citizen .numeric').keydown(function(e){
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

    function UpdateCostPerformance() {
      var sum10 = 0;
      var sum9 = 0;
      var sum8 = 0;
      var sum7 = 0;
      var sum6 = 0;
      var sum5 = 0;
      var sum4 = 0;
      var sum3 = 0;
      var sum2 = 0;
      var sum1 = 0;

      var bobot = <?php echo $this->development_model->kpi_weight($session_kpi=1);?>;
      var max_data = real;

      var subtotal;
      var total_performance;
      var grand_total;


      var gn, elem;
      for (i=1; i <= max_data; ++i) {
        gn = 'md_field_citizen_col_radio_performace_10'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum10 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_9'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum9 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_8'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum8 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_7'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum7 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_6'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum6 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_5'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum5 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_4'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum4 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_3'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum3 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_2'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum2 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_1'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum1 += Number(elem.value)* bobot/100; }


      }

      subtotal = (sum10+sum9+sum8+sum7+sum6+sum5+sum4+sum3+sum2+sum1) / max_data;
      total_performance = subtotal.toFixed(2);

      document.getElementById('total_performance').value = total_performance;
      document.getElementById('grand_total').innerHTML = total_performance; //NOW WORKS
     


    }


    

</script>

<script type="text/javascript">

$(function() {
    $('#md_field_citizen_add').bind('click', function() {
        //$('#mytbody').after('<tr><td>'+ new Date() +'</td></tr>');
        //var count = $('#mytbody').children().length;
        count = $('tr').length;
        real = count -4;
        $('#counter').html(real);
    });
});

</script>

<script type="text/javascript">

$(document).ready(function() {
            var id = 0;
            
            // Add button functionality
            $("#md_table_citizen .fbutton").click(function() {
                id++;
                var master = $(this).parents("#md_table_citizen");
                
                // Get a new row based on the prototype row
                var prot = master.find(".md_field_citizen_tr").clone();
                prot.attr("class", id + " item")
                prot.find(".id").attr("value", id);
                
                master.find("tbody").append(prot);
                prot.append('<td><input id="radio_performace_10'+id+'" record_index="'+id+'" class="md_field_citizen_col" column_name="radio_performace" name="radio_performace_'+id+'" type="radio" value="10" onclick="UpdateCostPerformance()"/></td>');
                prot.append('<td><span class="md_field_citizen_delete"><button class="remove">Remove</button></span></td>');
            });
            
            // Remove button functionality
            $("#md_table_citizen .md_field_citizen_delete").live("click", function() {
                $(this).parents("tr").remove();
                recalcId();
                id--;
            });
        });

function recalcId(){
    $.each($("table tr.item"),function (i,el){
        $(this).find("td:first input").val(i + 1); // Simply couse the first "prototype" is not counted in the list
    })
}



</script>

<table id="md_table_citizen" class="dynatable">
            <thead>
            <tr>
            
            <th><div class="fbutton">
        <button class="add">Add</button>
    </div></th>
            
            </tr>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Col 3</th>
                    <th>Col 4</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr class="md_field_citizen_tr">
                    <td><input type="text" name="id[]" value="0" class="id" /></td>
                    <td><input type="text" name="name[]" value="" class="id"/></td>
                    <td><input type="text" name="col4[]" value="" /></td>
                    <td><input type="text" name="col3[]" value="" /></td>
                     
                </tr>
        </table>