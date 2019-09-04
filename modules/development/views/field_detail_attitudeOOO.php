<?php
    $record_index = 1;
    $this->load->model('development_model');
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    #md_table_attitude input[type="text"]{
        
    }
    #md_table_attitude .chzn-drop input[type="text"]{
        
    }
    #md_table_attitude th:last-child, #md_table_attitude td:last-child{
       
    }

    .numberCircle {
        border-radius: 50%;
        behavior: url(PIE.htc); /* remove if you don't care about IE8 */

        width: 24px;
        height: 24px;
        padding: 2px;
        
        background: #fff;
        border: 2px solid #666;
        color: #666;
        text-align: center;
        align: 
        
        font: 12px Arial, sans-serif;
    }
</style>

<?php echo $title; ?>
<div id="md_table_attitude_container">
    <div id="no-datamd_table_attitude">No data</div>
    <table id="md_table_attitude" class="table table-striped table-bordered table-hover" style="display:none;width:100%">
        <thead>
            <tr>            
                <th colspan="3">
                <h4>B. PENILAIAN SIKAP KERJA  (Bobot : 30 %)</h4><br/>               
                Petunjuk : Bacalah pernyataan-pernyataan berikut ini dengan seksama dan berikan penilaian secara obyektif 
                dengan memberi tanda (<input type="radio" id="sample" name="sample" />) pada pilihan yang sesuai.

                </th>
                <th colspan="10">
                    <h4><span class="label label-default" id="total_attitude">Score : 0.00</span></h4>
                </th>            
            </tr>
            <tr>
                <th rowspan="3" width="2%">ID</th>                
                <th rowspan="3" width="20%"><div align="center">Faktor</div></th>
                <th rowspan="3" width="48%"><div align="center">Definisi</div></th>                
                <th colspan="10"><div align="center">Kategori Penilaian</div></th>
                
            </tr>
            <tr>                
                <th colspan="3" bgcolor="#00FF00"><div align="center">Baik</div></th>
                <th colspan="3" bgcolor="#FFFF00"><div align="center">Cukup</div></th>
                <th colspan="4" bgcolor="#FF9900"><div align="center">Kurang</div></th>
            </tr>
            <tr>
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
        <tbody>
            <!-- the data presentation be here -->
        </tbody>
    </table>
    
    <br />
    <!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
    <input id="md_real_field_attitude_col" name="md_real_field_attitude_col" type="hidden" />
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
    var OPTIONS_attitude = <?php echo json_encode($options); ?>;
    var RECORD_INDEX_attitude = <?php echo $record_index; ?>;
    var DATA_attitude = {update:new Array(), insert:new Array(), delete:new Array()};
    var old_data = <?php echo json_encode($result); ?>;
    for(var i=0; i<old_data.length; i++){
        var row = old_data[i];
        var record_index = i;
        var primary_key = row['attitude_id'];
        var data = row;
        delete data['attitude_id'];
        DATA_attitude.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ADD ROW FUNCTION
    //
    // * When "Add attitude" clicked, this function is called without parameter.
    // * When page loaded for the first time, this function is called with value parameter
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function add_table_row_attitude(value){
        // hide no-data div
        $("#no-datamd_table_attitude").hide();
        $("#md_table_attitude").show();

        //RECORD_INDEX_attitude = RECORD_INDEX_attitude+1;

        var component = '<tr id="md_field_attitude_tr_'+RECORD_INDEX_attitude+'" class="md_field_attitude_tr">';

        component += '<td>';
        component += RECORD_INDEX_attitude;
        component += '</td>';
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "attitude_factor"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('attitude_factor')){
          field_value = value.attitude_factor;
        }
        component += '<td>';
        component += '<div align="center">'+field_value+'</div>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "attitude_definition"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('attitude_definition')){
          field_value = value.attitude_definition;
        }
        component += '<td>';
        component += '<div align="left">'+field_value+'</div>';
        component += '</td>';



        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('attitude_value')){
          field_value = value.attitude_value;
        }

        if (field_value ==10){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_group_'+RECORD_INDEX_attitude+'" id="10_radio_'+RECORD_INDEX_attitude+'" record_index="'+RECORD_INDEX_attitude+'" value="10" onclick="UpdateCostAttitude()" '+chk+'/><label for="10_radio_'+RECORD_INDEX_attitude+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('attitude_value')){
          field_value = value.attitude_value;
        }

        if (field_value ==9){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_group_'+RECORD_INDEX_attitude+'" id="9_radio_'+RECORD_INDEX_attitude+'" record_index="'+RECORD_INDEX_attitude+'" value="9" onclick="UpdateCostAttitude()" '+chk+'/><label for="9_radio_'+RECORD_INDEX_attitude+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('attitude_value')){
          field_value = value.attitude_value;
        }

        if (field_value ==8){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_group_'+RECORD_INDEX_attitude+'" id="8_radio_'+RECORD_INDEX_attitude+'" record_index="'+RECORD_INDEX_attitude+'" value="8" onclick="UpdateCostAttitude()" '+chk+'/><label for="8_radio_'+RECORD_INDEX_attitude+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('attitude_value')){
          field_value = value.attitude_value;
        }

        if (field_value ==7){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_group_'+RECORD_INDEX_attitude+'" id="7_radio_'+RECORD_INDEX_attitude+'" record_index="'+RECORD_INDEX_attitude+'" value="7" onclick="UpdateCostAttitude()" '+chk+'/><label for="7_radio_'+RECORD_INDEX_attitude+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('attitude_value')){
          field_value = value.attitude_value;
        }

        if (field_value ==6){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_group_'+RECORD_INDEX_attitude+'" id="6_radio_'+RECORD_INDEX_attitude+'" record_index="'+RECORD_INDEX_attitude+'" value="6" onclick="UpdateCostAttitude()" '+chk+'/><label for="6_radio_'+RECORD_INDEX_attitude+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('attitude_value')){
          field_value = value.attitude_value;
        }

        if (field_value ==5){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_group_'+RECORD_INDEX_attitude+'" id="5_radio_'+RECORD_INDEX_attitude+'" record_index="'+RECORD_INDEX_attitude+'" value="5" onclick="UpdateCostAttitude()" '+chk+'/><label for="5_radio_'+RECORD_INDEX_attitude+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('attitude_value')){
          field_value = value.attitude_value;
        }

        if (field_value ==4){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_group_'+RECORD_INDEX_attitude+'" id="4_radio_'+RECORD_INDEX_attitude+'" record_index="'+RECORD_INDEX_attitude+'" value="4" onclick="UpdateCostAttitude()" '+chk+'/><label for="4_radio_'+RECORD_INDEX_attitude+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('attitude_value')){
          field_value = value.attitude_value;
        }

        if (field_value ==3){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_group_'+RECORD_INDEX_attitude+'" id="3_radio_'+RECORD_INDEX_attitude+'" record_index="'+RECORD_INDEX_attitude+'" value="3" onclick="UpdateCostAttitude()" '+chk+'/><label for="3_radio_'+RECORD_INDEX_attitude+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('attitude_value')){
          field_value = value.attitude_value;
        }

        if (field_value ==2){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_group_'+RECORD_INDEX_attitude+'" id="2_radio_'+RECORD_INDEX_attitude+'" record_index="'+RECORD_INDEX_attitude+'" value="2" onclick="UpdateCostAttitude()" '+chk+'/><label for="2_radio_'+RECORD_INDEX_attitude+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('attitude_value')){
          field_value = value.attitude_value;
        }

        if (field_value ==1){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_group_'+RECORD_INDEX_attitude+'" id="1_radio_'+RECORD_INDEX_attitude+'" record_index="'+RECORD_INDEX_attitude+'" value="1" onclick="UpdateCostAttitude()" '+chk+'/><label for="1_radio_'+RECORD_INDEX_attitude+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';




        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete Button
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        component += '</tr>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_attitude tbody').append(component);
        mutate_input_attitude();

    } // end of ADD ROW FUNCTION





    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Main event handling program
    //
    // * Initialization
    // * md_field_attitude_add.click (Add row)
    // * md_field_attitude_delete.click (Delete row)
    // * md_field_attitude_col.change (Edit cell)
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // INITIALIZATION
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        synchronize_attitude();
        for(var i=0; i<DATA_attitude.update.length; i++){
            add_table_row_attitude(DATA_attitude.update[i].data);
            RECORD_INDEX_attitude++;
        }
        synchronize_attitude_table_width();

        // on resize, adjust the table width
        $(window).resize(function() {
            synchronize_attitude_table_width();
        });

         
        current_value_att();


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_attitude_add.click (Add row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_field_attitude_add').click(function(){
            // new data
            var data = new Object();

            
            
          data.name = '';
          data.birthdate = '';
          data.job_id = '';
          data.hobby = '';

          
            // insert data to the DATA_attitude
            DATA_attitude.insert.push({
                'record_index' : RECORD_INDEX_attitude,
                'primary_key' : '',
                'data' : data,
            });

            // add table's row
            add_table_row_attitude(data);
            // add  by 1
            RECORD_INDEX_attitude++;

            // synchronize to the md_real_field_attitude_col
            synchronize_attitude();
            synchronize_attitude_table_width();
        });

        

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_attitude_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_attitude_delete').live('click', function(){
            var record_index = $(this).attr('record_index');
            // remove the component
            $('#md_field_attitude_tr_'+record_index).remove();

            var record_index_found = false;
            for(var i=0; i<DATA_attitude.insert.length; i++){
                if(DATA_attitude.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_attitude.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_attitude.update.length; i++){
                    if(DATA_attitude.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_attitude.update[i].primary_key;
                        // delete element from update
                        DATA_attitude.update.splice(i,1);
                        // add it to delete
                        DATA_attitude.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }
            synchronize_attitude();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_attitude_col.change (Edit cell)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_attitude_col').live('change', function(){
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
            for(var i=0; i<DATA_attitude.insert.length; i++){
                if(DATA_attitude.insert[i].record_index == record_index){
                    record_index_found = true;
                    // insert value
                    eval('DATA_attitude.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_attitude.update.length; i++){
                    if(DATA_attitude.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value
                        eval('DATA_attitude.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        break;
                    }
                }
            }
            synchronize_attitude();
        });


    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // reset field on save
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url == "{{ module_site_url }}manage_city/index/insert") {
            response = $.parseJSON(xhr.responseText);
            if(response.success == true){
                DATA_attitude = {update:new Array(), insert:new Array(), delete:new Array()};
                $('#md_table_attitude tr').not(':first').remove();
                synchronize_attitude();
            }
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize data to md_real_field_attitude_col.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_attitude(){
        $('#md_real_field_attitude_col').val(JSON.stringify(DATA_attitude));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize table width (called on resize and add).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_attitude_table_width(){
        var parent_width = $("#md_table_attitude_container").parent().parent().width();
        if($("#md_table_attitude_container table:visible").length > 0){
            $("#md_table_attitude_container").width(parent_width);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // function to mutate input
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function mutate_input_attitude(){
        // datepicker-input
        $('#md_table_attitude .datepicker-input').datepicker({
                dateFormat: js_date_format,
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-100:c+100",
        });
        // date-picker-input-clear
        $('#md_table_attitude .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_attitude .datetime-input').datetimepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
        
        $('#md_table_attitude .datetime-input-clear').button();
        
        $('#md_table_attitude .datetime-input-clear').click(function(){
            $(this).parent().find('.datetime-input').val("");
            return false;
        });
        // chzn-select
        $("#md_table_attitude .chzn-select").chosen({allow_single_deselect: true});
        // numeric
        $('#md_table_attitude .numeric').numeric();
        $('#md_table_attitude .numeric').keydown(function(e){
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


    function UpdateCostAttitude() {
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

      var bobot = <?php echo $this->development_model->kpi_weight($session_kpi=2);?>;
      var max_data = <?php echo $total ?>;

      var subtotal;
      var total_attitude;
      var grand_total;


      var gn, elem;




      for (i=1; i <= max_data; ++i) {

        gn = '10_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum10 += Number(elem.value)* bobot/100; }

        gn = '9_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum9 += Number(elem.value)* bobot/100; }

        gn = '8_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum8 += Number(elem.value)* bobot/100; }

        gn = '7_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum7 += Number(elem.value)* bobot/100; }

        gn = '6_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum6 += Number(elem.value)* bobot/100; }

        gn = '5_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum5 += Number(elem.value)* bobot/100; }

        gn = '4_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum4 += Number(elem.value)* bobot/100; }

        gn = '3_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum3 += Number(elem.value)* bobot/100; }

        gn = '2_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum2 += Number(elem.value)* bobot/100; }

        gn = '1_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum1 += Number(elem.value)* bobot/100; }


      }



        subtotal = (sum10+sum9+sum8+sum7+sum6+sum5+sum4+sum3+sum2+sum1) / max_data;
        total_attitude = subtotal.toFixed(2);

        if ( total_attitude >= 2.40 ){
            document.getElementById("total_attitude").className = "label label-success";
            var status = 'Baik';
        }
        else if (total_attitude < 2.40 && total_attitude >=1.50){
            document.getElementById("total_attitude").className = "label label-info";
            var status = 'Cukup';
        }
        else {
            document.getElementById("total_attitude").className = "label label-warning";
            var status = 'Kurang';
        }    



        document.getElementById('total_attitude').value = total_attitude;
        document.getElementById('total_attitude').innerHTML = 'Score : '+total_attitude+' ('+status+')';
        document.getElementById('total_attitude_result').innerHTML = total_attitude;


        document.getElementById('total_time_result').value = <?php echo $this->development_model->calculate_rata_rata_time($session_nik,$periode); ?>;
        var sum_total_attitude = Number(document.getElementById('total_attitude').value);
        var sum_total_performance = Number(document.getElementById('total_performance').value);
        var sum_total_time = Number(document.getElementById('total_time_result').value);

        var grand_total_kpi = (sum_total_attitude+sum_total_performance+sum_total_time);
        var grand_total = grand_total_kpi.toFixed(2);
        document.getElementById('grand_total_kpi_result').innerHTML = grand_total;


        if (grand_total >=8.00){
            document.getElementById('pointA').innerHTML = '<span class="glyphicon glyphicon-ok"></span>';
            document.getElementById('pointB').innerHTML = '';
            document.getElementById('pointC').innerHTML = '';
        }
        else if(grand_total < 8.00 && grand_total >=5.00){
            document.getElementById('pointA').innerHTML = '';
            document.getElementById('pointB').innerHTML = '<span class="glyphicon glyphicon-ok"></span>';
            document.getElementById('pointC').innerHTML = '';
        }
        else if(grand_total <=4){
            document.getElementById('pointA').innerHTML = '';
            document.getElementById('pointB').innerHTML = '';
            document.getElementById('pointC').innerHTML = '<span class="glyphicon glyphicon-ok"></span>';
        }

        else{
           
        }



        if ( grand_total >= 8.00 ){
            document.getElementById("head_total_score").className = "label label-success";
            var status_head = 'Baik';
        }
        else if (grand_total < 8.00 && grand_total >=5.00){
            document.getElementById("head_total_score").className = "label label-info";
            var status_head = 'Cukup';
        }
        else {
            document.getElementById("head_total_score").className = "label label-warning";
            var status_head = 'Kurang';
        }    


        document.getElementById('head_total_score').innerHTML = 'TOTAL NILAI : '+grand_total+' ('+status_head+')';

        var grand_total_abs = grand_total_kpi.toFixed(0);

        for (tdi=1; tdi <= 10; ++tdi){

            if (grand_total_abs == tdi){
                document.getElementById('total_color_'+tdi).style.backgroundColor="#FFFF99";
                document.getElementById('total_color_'+tdi).className = "numberCircle";
            }else{
                document.getElementById('total_color_'+tdi).style.backgroundColor="";
                document.getElementById('total_color_'+tdi).className = "";
            }
        }


    }

    function sum(){ 
            var fn, ln, result; 
            fn = parseInt(document.getElementById("n1").value, 10);
            ln = parseInt(document.getElementById("n2").value, 10);
            result =  (fn+ln); 
            document.getElementById("demo2").innerHTML = result; 
    }


    function current_value_att(){

        subtotal = <?php echo $current_value_attitude ?>;
        total_attitude = subtotal.toFixed(2);

        if ( total_attitude >= 2.40 ){
            document.getElementById("total_attitude").className = "label label-success";
            var status = 'Baik';
        }
        else if (total_attitude < 2.40 && total_attitude >=1.50){
            document.getElementById("total_attitude").className = "label label-info";
            var status = 'Cukup';
        }
        else {
            document.getElementById("total_attitude").className = "label label-warning";
            var status = 'Kurang';
        }    



        document.getElementById('total_attitude').value = total_attitude;
        document.getElementById('total_attitude').innerHTML = 'Score : '+total_attitude+' ('+status+')';
        document.getElementById('total_attitude_result').innerHTML = total_attitude;


        document.getElementById('total_time_result').value = <?php echo $this->development_model->calculate_rata_rata_time($session_nik,$periode); ?>;
        var sum_total_attitude = Number(document.getElementById('total_attitude').value);
        var sum_total_performance = Number(document.getElementById('total_performance').value);
        var sum_total_time = Number(document.getElementById('total_time_result').value);

        var grand_total_kpi = (sum_total_attitude+sum_total_performance+sum_total_time);
        var grand_total = grand_total_kpi.toFixed(2);
        document.getElementById('grand_total_kpi_result').innerHTML = grand_total;


        if (grand_total >=8.00){
            document.getElementById('pointA').innerHTML = '<span class="glyphicon glyphicon-ok"></span>';
            document.getElementById('pointB').innerHTML = '';
            document.getElementById('pointC').innerHTML = '';
        }
        else if(grand_total < 8.00 && grand_total >=5.00){
            document.getElementById('pointA').innerHTML = '';
            document.getElementById('pointB').innerHTML = '<span class="glyphicon glyphicon-ok"></span>';
            document.getElementById('pointC').innerHTML = '';
        }
        else if(grand_total <=4){
            document.getElementById('pointA').innerHTML = '';
            document.getElementById('pointB').innerHTML = '';
            document.getElementById('pointC').innerHTML = '<span class="glyphicon glyphicon-ok"></span>';
        }

        else{
           
        }



        if ( grand_total >= 8.00 ){
            document.getElementById("head_total_score").className = "label label-success";
            var status_head = 'Baik';
        }
        else if (grand_total < 8.00 && grand_total >=5.00){
            document.getElementById("head_total_score").className = "label label-info";
            var status_head = 'Cukup';
        }
        else {
            document.getElementById("head_total_score").className = "label label-warning";
            var status_head = 'Kurang';
        }    


        document.getElementById('head_total_score').innerHTML = 'TOTAL NILAI : '+grand_total+' ('+status_head+')';

        var grand_total_abs = grand_total_kpi.toFixed(0);

        for (tdi=1; tdi <= 10; ++tdi){

            if (grand_total_abs == tdi){
                document.getElementById('total_color_'+tdi).style.backgroundColor="#FFFF99";
                document.getElementById('total_color_'+tdi).className = "numberCircle";
            }else{
                document.getElementById('total_color_'+tdi).style.backgroundColor="";
                document.getElementById('total_color_'+tdi).className = "";
            }
        }

    }


</script>