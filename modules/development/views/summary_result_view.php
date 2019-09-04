<style type="text/css">
    .container {
        width: 100%;
    }
</style>

<form class="form-inline" action="{{ site_url }}{{ module_path }}/summary_result/filter_selection" method="post">
    <div class="form-group">
        <label for="email">Company:</label>
        <select class="form-control" id="CompanyID" name="CompanyID">
            <?php
            foreach ($company_option_data as $key => $value) { 
                if($value->CompanyID == $this->uri->segment(4)){                
                    echo '<option value="'.$value->CompanyID.'" selected="selected">'.$value->cCompanyName.'</option>';
                }
                else{                
                    echo '<option value="'.$value->CompanyID.'">'.$value->cCompanyName.'</option>';
                }            
            }
            ?>       
        </select>
    </div>
    <div class="form-group">
        <label for="pwd">Year:</label>
        <select class="form-control" id="PeriodID" name="PeriodID">
            
            <?php
            foreach ($period_option_data as $key => $value) { 
                if($value->PeriodID == $this->uri->segment(5)){                
                    echo '<option value="'.$value->PeriodID.'" selected="selected">'.$value->PeriodID.'</option>';
                }
                else{                
                    echo '<option value="'.$value->PeriodID.'">'.$value->PeriodID.'</option>';
                }            
            }
            ?>
        </select>
    </div>
  
    <button type="submit" class="btn btn-primary">Generate</button>
</form> 

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
echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);

?>

<script type="text/javascript">
    $(document).ajaxComplete(function () {

        $('[rel="total_score_A"]').attr('class','text-right field-sorting');
        $('[rel="total_score_B"]').attr('class','text-right field-sorting');
        $('[rel="total_score_C"]').attr('class','text-right field-sorting');
        $('[rel="total_score"]').attr('class','text-right field-sorting');
        $('[rel="iAgree"]').attr('class','text-center field-sorting');


        $('[relied="total_score_A"]').attr('class','text-right');
        $('[relied="total_score_B"]').attr('class','text-right');
        $('[relied="total_score_C"]').attr('class','text-right');
        $('[relied="total_score"]').attr('class','text-right');
        $('[relied="iAgree"]').attr('class','text-center');
       

    });


    $(document).ajaxComplete(function(){
        // TODO: Put your custom code here
    });

    $(document).ready(function(){
        // TODO: Put your custom code here
    })


</script>
