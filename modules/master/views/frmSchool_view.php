<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$asset = new CMS_Asset();
foreach($css_files as $file){
    $asset->add_css($file);
}
echo $asset->compile_css();

foreach($js_files as $file){
    $asset->add_js($file);
}
echo $asset->compile_js();

if($state !='edit' AND $state !='add'){

echo"<table>
  <tr>
    <td><select class='form-control' id=select onchange=goToPage('select')>
    <option value='' disabled SELECTED>Select Level</option>

    <option value='http://$_SERVER[SERVER_NAME]/hris2/master/frmSchool/index/0'>---ALL---</option>";
    $sql = mysql_query("SELECT * FROM tbl_school_level ORDER BY SchoolLevelId ASC");                     
    while ($data = mysql_fetch_array($sql)){

    if($this->uri->segment('4')==$data['SchoolLevelId']){  
      echo "<option value='http://$_SERVER[SERVER_NAME]/hris2/master/frmSchool/index/$data[SchoolLevelId]' SELECTED>$data[SchoolLevelName]</option>";
    }
    else {
      echo "<option value='http://$_SERVER[SERVER_NAME]/hris2/master/frmSchool/index/$data[SchoolLevelId]'>$data[SchoolLevelName]</option>";
    }

    }  
         
echo"</select>
    </table>&nbsp;&nbsp;";

}
// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}
echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);
?>

<script type = "text/javascript">
function goToPage( id ) {
  var node = document.getElementById( id );  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>

<!--<a class="btn btn-primary" href="{{ site_url }}{{ module_path }}/browse_division/index">Show Front Page</a><script type="text/javascript">
    $(document).ajaxComplete(function () {

        //ADD COMPONENTS
        if($('.pDiv2 .delete_all_button').length == 0 && $('#flex1 tbody td .delete-row').length != 0) { //check if element already exists (for ajax refresh purposes)
            $('.pDiv2').prepend('<div class="pGroup"><a class="delete_all_button btn btn-default" href="#"><i class="glyphicon glyphicon-remove"></i> Delete Selected</a></div>');
        }
        if($('#flex1 thead td .checkall').length == 0 && $('#flex1 tbody td .delete-row').length != 0){
            $('#flex1 thead tr').prepend('<td><input type="checkbox" class="checkall" /></td>');
            $('#flex1 tbody tr').each(function(){
                $(this).prepend('<td><input type="checkbox" value="' + $(this).attr('rowId') + '" /></td>');
            });
        }

    });

    // CHECK ALL
    $('.checkall').live('click', function(){
        $(this).parents('table:eq(0)').find(':checkbox').attr('checked', this.checked);
    });
    // DELETE ALL
    $('.delete_all_button').live('click', function(event){
        event.preventDefault();
        var list = new Array();
        $('input[type=checkbox]').each(function() {
            if (this.checked) {
                //create list of values that will be parsed to controller
                list.push(this.value);
            }
        });
        //send data to delete
        $.post('{{ MODULE_SITE_URL }}manage_city/delete_selection', { data: JSON.stringify(list) }, function(data) {
            for(i=0; i<list.length; i++){
                //remove selection rows
                $('#flex1 tr[rowId="' + list[i] + '"]').remove();
            }
            alert('Selected row deleted');
        });
    });


    $(document).ajaxComplete(function(){
        // TODO: Put your custom code here
    });

    $(document).ready(function(){
        // TODO: Put your custom code here
    })
</script>-->