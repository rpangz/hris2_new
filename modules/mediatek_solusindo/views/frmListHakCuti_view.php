<style type="text/css">
  a[href="<?php echo site_url('{{ module_path }}/frmListHakCuti/index/delete/0');?>"]
  {
    visibility : hidden;
    pointer-events: none;
        cursor: default;
  }
</style>

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->model('data_filter_model');

$modules = $this->uri->segment('1');
$pages   = $this->uri->segment('2');
$this->config->load('cms_config');       
$company_id = $this->config->item('cms_mediatek_id');


if($this->uri->segment('5') =='' && ($this->uri->segment('4') !='add') || ($this->uri->segment('4') =='success')){

    echo $this->data_filter_model->data_filter_company_per_type($company_id,$current_id=$this->uri->segment('4'),$modules,$pages);

}


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

.dropdown_box1{
    width:370px;
    height:30px;
    margin-top:5px;
    margin-left:0px;
    font-size: 12px;
    font-family: arial;
  }
</style>
