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

// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}

?>

<div id="content">
<a href="javascript:void(0);" onclick="form_coaching_and_counseling('7')" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus-circle big-icon"></i> Tambah Data</a>
	<?php 
	echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);
	?>
</div>
<style type="text/css">
.container {
  width: 100%;
}
</style>

<script type="text/javascript">

function form_coaching_and_counseling(primary_key){
    var save_method = 'update';
    
    //$('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('development/coaching_and_counseling/form_coaching_and_counseling/')?>/"+primary_key,
        type: "GET",
        /*dataType: "JSON",*/
        success: function(html)
        {
           
            $('#content').html(html);                      
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function form_index(){
    var save_method = 'update';
    
    //$('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('development/coaching_and_counseling/index/')?>",
        type: "GET",
        /*dataType: "JSON",*/
        success: function(html)
        {
           
            $('#content').html(html);                      
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
</script>
