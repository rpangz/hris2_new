<?php
    $record_index = 0;
    $max_data     = 5;
    $this->load->model('development_model');

?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />
<style type="text/css">
    #md_table_performance input[type="text"]{
        /*max-width:100px;*/
    }
    #md_table_performance .chzn-drop input[type="text"]{
        /*max-width:240px;*/
    }
    #md_table_performance th:last-child, #md_table_performance td:last-child{
        /*width: 60px;*/
    }

    tr{font-family: Arial; font-size: 12px;}

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
<?php //echo $title; ?>
<div id="md_table_performance_container">
    <div id="no-datamd_table_performance">No data</div>
    <table id="md_table_performance" class="table table-striped table-bordered table-hover" style="display:none;width:100%">
        <thead>
           <tr>            
            <th colspan="5">               
            <div id="add_rows">
                <span id="md_field_performance_add" class="add btn btn-primary fbutton"><i class="glyphicon glyphicon-plus-sign"></i> Add Row (Total :<span id="counter">0</span>)</span>                         
                <!--<span id="btnDelTradesperson" class="add btn btn-default fbutton-delete"><i class="glyphicon glyphicon-minus-sign"></i> Delete Row <span id="counter-del">0</span></span>-->
                
                <span class="delete-icon btn btn-default md_field_performance_delete"><i class="glyphicon glyphicon-minus-sign"></i> Delete Row <span id="counter-del">0</span></span>
            </div>

            </th>
            <th colspan="10">
                <h4><span class="label label-default" id="total_performance">Score : 0.00</span></h4>
            </th>            
        </tr>
            <tr>
                <th rowspan="3" width="2%">ID</th>                
                <th rowspan="3" width="25%"><div align="center">Area Kerja</div></th>
                <th rowspan="3" width="20%"><div align="center">Target Kerja</div></th>
                <th rowspan="3" width="3%" align="center" valign="middle"><div align="center">Bobot</div></th>
                <th rowspan="3" width="30%"><div align="center">Hasil yang Dicapai</div></th>
                <th colspan="10"><div align="center">Kategori Penilaian </div></th>
                
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



   <div class="fbutton">
        <span id="md_field_performance_add" class="add btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Add Row </span>
    </div>

    


    <!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
    <input id="md_real_field_performance_col" name="md_real_field_performance_col" type="hidden" />
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
    var OPTIONS_performance = <?php echo json_encode($options); ?>;
    var RECORD_INDEX_performance = <?php echo $record_index; ?>;
    var DATA_performance = {update:new Array(), insert:new Array(), delete:new Array()};
    var old_data = <?php echo json_encode($result); ?>;
    for(var i=0; i<old_data.length; i++){
        var row = old_data[i];
        var record_index = i;
        var primary_key = row['performance_id'];
        var data = row;
        delete data['performance_id'];
        DATA_performance.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ADD ROW FUNCTION
    //
    // * When "Add performance" clicked, this function is called without parameter.
    // * When page loaded for the first time, this function is called with value parameter
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function add_table_row_performance(value){
        // hide no-data div
        $("#no-datamd_table_performance").hide();
        $("#md_table_performance").show();

        count = $('#md_table_performance tr').length;
        real = count-4;
        $('#counter').html(real);
        $('#counter-del').html(getGetOrdinal(n=real));

        RECORD_INDEX_performance = real+1;

        var component = '<tr id="md_field_performance_tr_'+RECORD_INDEX_performance+'" class="md_field_performance_tr">';        

      
        component += '<td>';
        component += RECORD_INDEX_performance;
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "performance_area"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_area')){
          field_value = value.performance_area;
        }
        component += '<td>';
        component += '<textarea style="width: 100%; height: 100px;" id="md_field_performance_col_performance_area_'+RECORD_INDEX_performance+'" record_index="'+RECORD_INDEX_performance+'" class="md_field_performance_col form-control" column_name="performance_area">'+field_value+'</textarea>';
        component += '</td>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "performance_target"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_target')){
          field_value = value.performance_target;
        }
        component += '<td>';
        component += '<textarea style="width: 100%; height: 100px;" id="md_field_performance_col_performance_target_'+RECORD_INDEX_performance+'" record_index="'+RECORD_INDEX_performance+'" class="md_field_performance_col form-control" column_name="performance_target">'+field_value+'</textarea>';
        component += '</td>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "performance_weight"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_weight')){
          field_value = value.performance_weight;
        }
        else{
          field_value = 20;
        }
        component += '<td>';
        component += field_value;
        component += '</td>';



        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "performance_result"
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        var field_value = '';        
        
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_result')){
          field_value = value.performance_result;
        }       

        component += '<td>';
        component += '<textarea style="width: 100%; height: 100px;" id="md_field_performance_col_performance_result_'+RECORD_INDEX_performance+'" record_index="'+RECORD_INDEX_performance+'" class="md_field_performance_col form-control" column_name="performance_result">'+field_value+'</textarea>';
        component += '</td>';



        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_value')){
          field_value = value.performance_value;
        }

        if (field_value ==10){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_perf'+RECORD_INDEX_performance+'" id="md_field_performance_col_radio_performace_10'+RECORD_INDEX_performance+'" record_index="'+RECORD_INDEX_performance+'" value="10" onclick="UpdateCostPerformance()" '+chk+'/><label for="md_field_performance_col_radio_performace_10'+RECORD_INDEX_performance+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_value')){
          field_value = value.performance_value;
        }

        if (field_value ==9){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_perf'+RECORD_INDEX_performance+'" id="md_field_performance_col_radio_performace_9'+RECORD_INDEX_performance+'" record_index="'+RECORD_INDEX_performance+'" value="9" onclick="UpdateCostPerformance()" '+chk+'/><label for="md_field_performance_col_radio_performace_9'+RECORD_INDEX_performance+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_value')){
          field_value = value.performance_value;
        }

        if (field_value ==8){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_perf'+RECORD_INDEX_performance+'" id="md_field_performance_col_radio_performace_8'+RECORD_INDEX_performance+'" record_index="'+RECORD_INDEX_performance+'" value="8" onclick="UpdateCostPerformance()" '+chk+'/><label for="md_field_performance_col_radio_performace_8'+RECORD_INDEX_performance+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_value')){
          field_value = value.performance_value;
        }

        if (field_value ==7){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_perf'+RECORD_INDEX_performance+'" id="md_field_performance_col_radio_performace_7'+RECORD_INDEX_performance+'" record_index="'+RECORD_INDEX_performance+'" value="7" onclick="UpdateCostPerformance()" '+chk+'/><label for="md_field_performance_col_radio_performace_7'+RECORD_INDEX_performance+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_value')){
          field_value = value.performance_value;
        }

        if (field_value ==6){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_perf'+RECORD_INDEX_performance+'" id="md_field_performance_col_radio_performace_6'+RECORD_INDEX_performance+'" record_index="'+RECORD_INDEX_performance+'" value="6" onclick="UpdateCostPerformance()" '+chk+'/><label for="md_field_performance_col_radio_performace_6'+RECORD_INDEX_performance+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_value')){
          field_value = value.performance_value;
        }

        if (field_value ==5){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_perf'+RECORD_INDEX_performance+'" id="md_field_performance_col_radio_performace_5'+RECORD_INDEX_performance+'" record_index="'+RECORD_INDEX_performance+'" value="5" onclick="UpdateCostPerformance()" '+chk+'/><label for="md_field_performance_col_radio_performace_5'+RECORD_INDEX_performance+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_value')){
          field_value = value.performance_value;
        }

        if (field_value ==4){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_perf'+RECORD_INDEX_performance+'" id="md_field_performance_col_radio_performace_4'+RECORD_INDEX_performance+'" record_index="'+RECORD_INDEX_performance+'" value="4" onclick="UpdateCostPerformance()" '+chk+'/><label for="md_field_performance_col_radio_performace_4'+RECORD_INDEX_performance+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_value')){
          field_value = value.performance_value;
        }

        if (field_value ==3){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_perf'+RECORD_INDEX_performance+'" id="md_field_performance_col_radio_performace_3'+RECORD_INDEX_performance+'" record_index="'+RECORD_INDEX_performance+'" value="3" onclick="UpdateCostPerformance()" '+chk+'/><label for="md_field_performance_col_radio_performace_3'+RECORD_INDEX_performance+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';



        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_value')){
          field_value = value.performance_value;
        }

        if (field_value ==2){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_perf'+RECORD_INDEX_performance+'" id="md_field_performance_col_radio_performace_2'+RECORD_INDEX_performance+'" record_index="'+RECORD_INDEX_performance+'" value="2" onclick="UpdateCostPerformance()" '+chk+'/><label for="md_field_performance_col_radio_performace_2'+RECORD_INDEX_performance+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';



        var field_value = '';
        var chk         = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('performance_value')){
          field_value = value.performance_value;
        }

        if (field_value ==1){ chk = 'checked';} else{chk = '';}
        component += '<td>';
        component += '<div align="center"><input type="radio" name="radio_perf'+RECORD_INDEX_performance+'" id="md_field_performance_col_radio_performace_1'+RECORD_INDEX_performance+'" record_index="'+RECORD_INDEX_performance+'" value="1" onclick="UpdateCostPerformance()" '+chk+'/><label for="md_field_performance_col_radio_performace_1'+RECORD_INDEX_performance+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div>';
        component += '</td>';


      


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete Button
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //component += '<td><span class="delete-icon btn btn-default md_field_performance_delete" record_index="'+RECORD_INDEX_performance+'"><i class="glyphicon glyphicon-minus-sign"></i></span></td>';
        component += '</tr>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_performance tbody').append(component);
        mutate_input_performance();

    } // end of ADD ROW FUNCTION





    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Main event handling program
    //
    // * Initialization
    // * md_field_performance_add.click (Add row)
    // * md_field_performance_delete.click (Delete row)
    // * md_field_performance_col.change (Edit cell)
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){

        var id = 0;

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // INITIALIZATION
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        


        synchronize_performance();

        for(var i=0; i<DATA_performance.update.length; i++){
            add_table_row_performance(DATA_performance.update[i].data);
            RECORD_INDEX_performance++;            

        }
        synchronize_performance_table_width();



        // on resize, adjust the table width
        $(window).resize(function() {
            synchronize_performance_table_width();
        });

        count = $('#md_table_performance tr').length;
        real = count-4;
        $('#counter').html(real);
        $('#counter-del').html(getGetOrdinal(n=real));

        
        
        
        //var real = <?php echo $total; ?>;

        //$('#counter').html(real);
        //$('#counter-del').html(getGetOrdinal(n=real));
        
        current_value_prf();

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_performance_add.click (Add row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_field_performance_add').click(function(){
           
            if($("tr.md_field_performance_tr").length<'<?php echo $max_data ?>')
                       

            var data = new Object();

            
            
            data.performance_area = '';
            data.performance_target = '';
            data.performance_weight = '';
            data.performance_result = '';
            data.performance_value = '';

          
            // insert data to the DATA_performance
            DATA_performance.insert.push({
                'record_index' : RECORD_INDEX_performance,
                'primary_key' : '',
                'data' : data,
            });

            // add table's row
            add_table_row_performance(data);
            // add  by 1

            //var prot = master.find(".md_field_performance_tr").clone();

            RECORD_INDEX_performance++;

            count = $('#md_table_performance tr').length;
            real = count-4;
            $('#counter').html(real);
            $('#counter-del').html(getGetOrdinal(n=real));

            var master = $(this).parents("#md_table");
                
    
                var prot = master.find(".md_field_performance_tr").clone();
                prot.attr("class", id + " item")
                prot.find(".id").attr("value", id); 



            // synchronize to the md_real_field_performance_col
            synchronize_performance();
            synchronize_performance_table_width();
        });

        

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_performance_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_performance_delete').live('click', function(){
            //var record_index = $(this).attr('record_index');
            var $tbody = $("#md_table_performance tbody");
            var $last = $tbody.find('tr:last');
            // remove the component

            //$('#md_field_performance_tr_'+last).remove();

                    
            $last.remove();

            count = $('#md_table_performance tr').length;
            real = count-4;
            $('#counter').html(real);
            $('#counter-del').html(getGetOrdinal(n=real));

            var record_index = real+1;

            var record_index_found = false;
            for(var i=0; i<DATA_performance.insert.length; i++){
                if(DATA_performance.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_performance.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_performance.update.length; i++){
                    if(DATA_performance.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_performance.update[i].primary_key;
                        // delete element from update
                        DATA_performance.update.splice(i,1);
                        // add it to delete
                        DATA_performance.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }

            
           
            

            synchronize_performance();


        });

        
        


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_performance_col.change (Edit cell)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_performance_col').live('change', function(){
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
            for(var i=0; i<DATA_performance.insert.length; i++){
                if(DATA_performance.insert[i].record_index == record_index){
                    record_index_found = true;
                    // insert value
                    eval('DATA_performance.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_performance.update.length; i++){
                    if(DATA_performance.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value
                        eval('DATA_performance.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        break;
                    }
                }
            }
            synchronize_performance();
        });


    });

    function recalcId(){
        $.each($("table tr.item"),function (i,el){
            $(this).find("td:first input").val(record_index + 1);

            

            count = $('table tr.item').length;
                    real = count;
                    $('#counter').html(real);
                    $('#counter-del').html(getGetOrdinal(n=real));


        })



    }
    


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // reset field on save
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url == "{{ module_site_url }}manage_city/index/insert") {
            response = $.parseJSON(xhr.responseText);
            if(response.success == true){
                DATA_performance = {update:new Array(), insert:new Array(), delete:new Array()};
                $('#md_table_performance tr').not(':first').remove();
                synchronize_performance();
            }
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize data to md_real_field_performance_col.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_performance(){
        $('#md_real_field_performance_col').val(JSON.stringify(DATA_performance));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // synchronize table width (called on resize and add).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function synchronize_performance_table_width(){
        var parent_width = $("#md_table_performance_container").parent().parent().width();
        if($("#md_table_performance_container table:visible").length > 0){
            $("#md_table_performance_container").width(parent_width);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // function to mutate input
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function mutate_input_performance(){
        // datepicker-input
        $('#md_table_performance .datepicker-input').datepicker({
                dateFormat: js_date_format,
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-100:c+100",
        });
        // date-picker-input-clear
        $('#md_table_performance .datepicker-input-clear').click(function(){
            $(this).parent().find('.datepicker-input').val('');
            return false;
        });
        // datetime-input
        $('#md_table_performance .datetime-input').datetimepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: js_date_format,
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
        
        $('#md_table_performance .datetime-input-clear').button();
        
        $('#md_table_performance .datetime-input-clear').click(function(){
            $(this).parent().find('.datetime-input').val("");
            return false;
        });
        // chzn-select
        $("#md_table_performance .chzn-select").chosen({allow_single_deselect: true});
        // numeric
        $('#md_table_performance .numeric').numeric();
        $('#md_table_performance .numeric').keydown(function(e){
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

    function getGetOrdinal(n) {
       var s=["th","st","nd","rd"],
           v=n%100;
       return n+(s[(v-20)%10]||s[v]||s[0]);
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

        gn = 'md_field_performance_col_radio_performace_10'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum10 += Number(elem.value)* bobot/100; }

        gn = 'md_field_performance_col_radio_performace_9'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum9 += Number(elem.value)* bobot/100; }

        gn = 'md_field_performance_col_radio_performace_8'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum8 += Number(elem.value)* bobot/100; }

        gn = 'md_field_performance_col_radio_performace_7'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum7 += Number(elem.value)* bobot/100; }

        gn = 'md_field_performance_col_radio_performace_6'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum6 += Number(elem.value)* bobot/100; }

        gn = 'md_field_performance_col_radio_performace_5'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum5 += Number(elem.value)* bobot/100; }

        gn = 'md_field_performance_col_radio_performace_4'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum4 += Number(elem.value)* bobot/100; }

        gn = 'md_field_performance_col_radio_performace_3'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum3 += Number(elem.value)* bobot/100; }

        gn = 'md_field_performance_col_radio_performace_2'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum2 += Number(elem.value)* bobot/100; }

        gn = 'md_field_performance_col_radio_performace_1'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum1 += Number(elem.value)* bobot/100; }


      }



    subtotal = (sum10+sum9+sum8+sum7+sum6+sum5+sum4+sum3+sum2+sum1) / max_data;
    total_performance = subtotal.toFixed(2);

    if ( total_performance >= 4.40 ){
        document.getElementById("total_performance").className = "label label-success";
        var status = 'Baik';
    }
    else if (total_performance < 4.40 && total_performance >=2.75){
        document.getElementById("total_performance").className = "label label-info";
        var status = 'Cukup';
    }
    else {
        document.getElementById("total_performance").className = "label label-warning";
        var status = 'Kurang';
    }    



    document.getElementById('total_performance').value = total_performance;
    document.getElementById('total_performance').innerHTML = 'Score : '+total_performance+' ('+status+')'; //NOW WORKS
    document.getElementById('total_performance_result').innerHTML = total_performance;
     
    document.getElementById('total_time_result').value = <?php echo $this->development_model->calculate_rata_rata_time($session_nik,$periode=2015); ?>; 
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
    else if(grand_total <=4.00){
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


    function current_value_prf(){

        subtotal = <?php echo $current_value_performance ?>;
        total_performance = subtotal.toFixed(2);

        if ( total_performance >= 4.40 ){
            document.getElementById("total_performance").className = "label label-success";
            var status = 'Baik';
        }
        else if (total_performance < 4.40 && total_performance >=2.75){
            document.getElementById("total_performance").className = "label label-info";
            var status = 'Cukup';
        }
        else {
            document.getElementById("total_performance").className = "label label-warning";
            var status = 'Kurang';
        }

        document.getElementById('total_performance').value = total_performance;
        document.getElementById('total_performance').innerHTML = 'Score : '+total_performance+' ('+status+')'; //NOW WORKS
        document.getElementById('total_performance_result').innerHTML = total_performance;


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