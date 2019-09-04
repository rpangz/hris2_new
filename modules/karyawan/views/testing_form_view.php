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

//}
// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}
?>

<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Project History</h4>
    </div>

<?php    
echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);

?>

<div class="modal-footer">
        <button type="button" class="btn btn-primary btn-flat pull-left" onclick="save_resume(7)"><i class="fa fa-floppy-o"></i> Simpan</button>
        <button type="button" class="btn btn-default btn-flat pull-right" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
    </div>