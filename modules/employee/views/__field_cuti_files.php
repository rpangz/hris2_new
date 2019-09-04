<?php
    $record_index = 0;
    $session_nik  = $_SESSION['NIK'];
    $today        = date('Y-m-d H:i:s');
    $upload_path  = base_url('modules/'.$module_path.'/assets/uploads').'/';

    
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<style type="text/css">
</style>

<table id="md_table_files" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="text-align:center">File - jpg|jpeg|pdf [Max 1MB]</th>
            <th style="text-align:center">Nama File</th>
            <th style="text-align:center;width:100px;">Action</th>
            
        </tr>
    </thead>
    <tbody>
        <!-- the data presentation be here -->
    </tbody>
</table>
<input id="md_field_files_add" class="btn btn-default" type="button" value="Add Attachment Files" />
<br />
<!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
<input id="md_real_field_files_col" name="md_real_field_files_col" type="hidden" />

<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/ui/'.grocery_CRUD::JQUERY_UI_JS); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.ui.datetime.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.numeric.min.js'); ?>"></script>
<script type="text/javascript">

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // DATA INITIALIZATION
    //
    // * Prepare some global variables
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    var DATE_FORMAT = '<?php echo $date_format ?>';
    var OPTIONS_files = <?php echo json_encode($options); ?>;
    var RECORD_INDEX_files = <?php echo $record_index; ?>;
    var UPLOAD_PATH = '<?php echo $upload_path; ?>';
    var DATA_files = {update:new Array(), insert:new Array(), delete:new Array()};
    var old_data = <?php echo json_encode($result); ?>;
    for(var i=0; i<old_data.length; i++){
        var row = old_data[i];
        var record_index = i;
        var primary_key = row['file_id'];
        var data = row;
        delete data['file_id'];
        DATA_files.update.push({
            'record_index' : record_index,
            'primary_key' : primary_key,
            'data' : data,
        });
    }
    console.log(DATA_files);


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ADD ROW FUNCTION
    //
    // * When "Add Photo" clicked, this function is called without parameter.
    // * When page loaded for the first time, this function is called with value parameter
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function add_table_row_files(value){

        $("#no-datamd_table_files").hide();
        $("#md_table_files").show();

        var component = '<tr id="md_field_files_tr_'+RECORD_INDEX_files+'" class="md_field_files_tr">';   

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "url"
        /////////////////////////////////////////////////////////////////////////////////////////////////////

        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('url')){
            field_value = value.url;
        }      

        var base_url = '<?php echo base_url();?>';
        component += '<td>';
        //component += '<div class="fileupload fileupload-new" data-provides="fileupload"><span class="btn btn-primary btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input id="md_field_files_col_url_'+RECORD_INDEX_files+'" record_index="'+RECORD_INDEX_files+'" type="file" column_name="url" name="md_field_files_col_url_'+RECORD_INDEX_files+'" value="'+field_value+'" /></span><span class="fileupload-preview"></span><a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a></div>';
        
        component += '<input id="md_field_files_col_url_'+RECORD_INDEX_files+
                  '" record_index="'+RECORD_INDEX_files+
                  '" class="md_field_files_col" column_name="url" type="file"'+
                  ' name="md_field_files_col_url_'+RECORD_INDEX_files+'" value="'+field_value+'"/>';

        component += '</td>';      

        
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //    FIELD "file_name"
        /////////////////////////////////////////////////////////////////////////////////////////////////////

        var field_value = '';
        if(typeof(value) != 'undefined' && value.hasOwnProperty('file_name')){
          field_value = value.file_name;
        }
        component += '<td>';
        component += '<input maxlength="50" placeholder="Maksimal 50 karakter" style="width: 350px;" id="md_field_files_col_file_name_'+RECORD_INDEX_files+'" record_index="'+RECORD_INDEX_files+'" class="md_field_files_col" column_name="file_name" type="text" value="'+field_value+'"/>';
        component += '</td>';


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete Button
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //component += '<td><input class="md_field_files_download btn btn-default" record_index="'+RECORD_INDEX_files+'" primary_key="" type="button" value="Download" /></td>';
        component += '<td><input class="md_field_files_delete btn btn-default" record_index="'+RECORD_INDEX_files+'" primary_key="" type="button" value="Delete" /></td>';
        component += '</tr>';

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add component to table
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_table_files tbody').append(component);
        mutate_input();

    } // end of ADD ROW FUNCTION



    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Main event handling program
    //
    // * Initialization
    // * md_field_files_add.click (Add row)
    // * md_field_files_delete.click (Delete row)
    // * md_field_files_col.change (Edit cell)
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // INITIALIZATION
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        synchronize_files();
        for(var i=0; i<DATA_files.update.length; i++){
            add_table_row_files(DATA_files.update[i].data);
            RECORD_INDEX_files++;
        }


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_files_add.click (Add row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#md_field_files_add').click(function(){
            // new data
            var data = new Object();
            data.url        = '';
            data.file_name  = '';
            data.file_code  = '';

            // insert data to the DATA_files
            DATA_files.insert.push({
                'record_index' : RECORD_INDEX_files,
                'primary_key' : '',
                'data' : data,
            });

            // add table's row
            add_table_row_files(data);
            // add  by 1
            RECORD_INDEX_files++;

            // synchronize to the md_real_field_files_col
            synchronize_files();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_files_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_files_delete').live('click', function(){
            var record_index = $(this).attr('record_index');
            // remove the component
            $('#md_field_files_tr_'+record_index).remove();

            var record_index_found = false;
            for(var i=0; i<DATA_files.insert.length; i++){
                if(DATA_files.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_files.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_files.update.length; i++){
                    if(DATA_files.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_files.update[i].primary_key;
                        // delete element from update
                        DATA_files.update.splice(i,1);
                        // add it to delete
                        DATA_files.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }
            synchronize_files();
        });

    
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_files_delete.click (Delete row)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_files_download').live('click', function(){
            var record_index = $(this).attr('record_index');
            // remove the component
            $('#md_field_files_tr_'+record_index).remove();

            var record_index_found = false;
            for(var i=0; i<DATA_files.insert.length; i++){
                if(DATA_files.insert[i].record_index == record_index){
                    record_index_found = true;
                    // delete element from insert
                    DATA_files.insert.splice(i,1);
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_files.update.length; i++){
                    if(DATA_files.update[i].record_index == record_index){
                        record_index_found = true;
                        var primary_key = DATA_files.update[i].primary_key;
                        // delete element from update
                        DATA_files.update.splice(i,1);
                        // add it to delete
                        DATA_files.delete.push({
                            'record_index':record_index,
                            'primary_key':primary_key
                        });
                        break;
                    }
                }
            }
            synchronize_files();
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // md_field_files_col.change (Edit cell)
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.md_field_files_col').live('change', function(){
            var value = $(this).val();
            var column_name = $(this).attr('column_name');
            var record_index = $(this).attr('record_index');
            var record_index_found = false;
            // date picker
            if($(this).hasClass('datepicker-input')){
                value = js_date_to_php(value);
            }
            if(typeof(value)=='undefined'){
                value = '';
            }
            for(var i=0; i<DATA_files.insert.length; i++){
                if(DATA_files.insert[i].record_index == record_index){
                    record_index_found = true;
                    // insert value
                    eval('DATA_files.insert['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                    break;
                }
            }
            if(!record_index_found){
                for(var i=0; i<DATA_files.update.length; i++){
                    if(DATA_files.update[i].record_index == record_index){
                        record_index_found = true;
                        // edit value
                        eval('DATA_files.update['+i+'].data.'+column_name+' = '+JSON.stringify(value)+';');
                        break;
                    }
                }
            }
            synchronize_files();
        });


    });
    
   
    $(document).ajaxSuccess(function(event, xhr, settings) {        
        if (settings.url == "{{ module_site_url }}frmCuti/index/insert") {
            response = $.parseJSON(xhr.responseText);
            if(response.success == true){
                DATA_files = {update:new Array(), insert:new Array(), delete:new Array()};
                $('#md_table_files tr').not(':first').remove();
                synchronize_files();
            }
        }
    });

    function synchronize_files(){
        $('#md_real_field_files_col').val(JSON.stringify(DATA_files));
    }
     

    function IsNumeric(input){
        return (input - 0) == input && input.length > 0;
    }

    

</script>