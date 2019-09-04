<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$this->load->model('data_filter_model');
$this->config->load('cms_config');
$modules = $this->uri->segment('1');
$pages   = $this->uri->segment('2');       


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


echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);

?>



<script type = "text/javascript">
    function goToPage(id) {
        var node = document.getElementById(id);
        if( node &&
            node.tagName == "SELECT" ) {
            window.location.href = node.options[node.selectedIndex].value;
        }
    }
</script>

<style type="text/css">
    .chzn-container, .chzn-drop, .chzn-drop .chzn-search, .chzn-drop {
        width: 498px !important;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;

    }
    .chzn-search input {
        width: 478px !important;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .chzn-container { width:500px !important; }

    .dropdown_box{
        width:500px;
        height:30px;
        margin-top:5px;
        margin-left:0px;
        font-size: 12px;
        font-family: arial;
    }

    .form-control{
        width:100%;
    }

    .row {
        -webkit-column-width: 700px; /* Chrome, Safari, Opera */
        -moz-column-width: 700px; /* Firefox */  
        column-width: 700px;
    }

    .box{
        padding: 20px;
        display: none;
        margin-top: 20px;
        border: 1px solid #000;
    }

    label {
        display: block;
        padding-left: 15px;
        text-indent: -15px;
    }

   
    .blue {
    color: yellow;
}


</style>

<script type="text/javascript">
$(document).ready(function(){
    $(".tip-top").tooltip({
        placement : 'top'
    });
    $(".tip-right").tooltip({
        placement : 'right'
    });
    $(".tip-bottom").tooltip({
        placement : 'bottom'
    });
    $(".tip-left").tooltip({
        placement : 'left'
    });
});
</script>

<!--

<link rel="stylesheet" type="text/css" href="<?php //echo base_url('assets/bootstrap3/docs/css/highlight.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php //echo base_url('assets/bootstrap3/css/bootstrap-switch.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php //echo base_url('assets/bootstrap-select-1.9.4/css/bootstrap-select.min.css'); ?>" />
<script type="text/javascript" src="<?php //echo base_url('assets/bootstrap-select-1.9.4/js/bootstrap-select.min.js'); ?>"></script>
<script type="text/javascript" src="<?php //echo base_url('assets/bootstrap-select-1.9.4/js/i18n/defaults-*.min.js'); ?>"></script>
-->