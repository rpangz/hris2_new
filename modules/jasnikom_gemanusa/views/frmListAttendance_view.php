<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$this->load->model('data_filter_model');
$this->config->load('cms_config');       
$company_id = $this->config->item('cms_jasnikom_id');

$modules = $this->uri->segment('1');
$pages   = $this->uri->segment('2');
$current_year = date("Y");

if (isset($_GET['nik']) && (!is_null($_GET['nik']) || !empty($_GET['nik']))){
    $nik = $_GET['nik'];
}
else{
    $nik = '';
}

if (isset($_GET['periode']) && (!is_null($_GET['periode']) || !empty($_GET['periode']))){
    $periode = $_GET['periode'];
}
else{
    $periode = '';
}

echo $this->data_filter_model->search_filter_with_dropdown($company_id,$modules,$pages,$periode,$nik,$current_year);


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

include "./includes/frmListAttendance.php";

?>

<style type="text/css">
.ddl-title{
    background-color:#5bc0de !important;
    color:#fff !important;
    font-style:italic;
    font-size:80%;
}  
.ddl-select.input-group-btn:first-child>.btn-group:not(:first-child)>.btn {
    width: 550px;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}
.glyphicon.glyphicon-search {
    font-size: 15px;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}
.btn-info:hover, .btn-info:focus, .btn-info:active, .btn-info.active {    
    border-color: #3399FF; /*set the color you want here*/
}


</style>