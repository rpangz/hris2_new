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
<style type="text/css">
	.container {
        width: 100%;
    }
    .form-control{
        font-size: 12px;
    }
    .chzn-container {
        font-size: 12px;
    }
    #TermsAndConditions_display_as_box{
        display: none;
    }
    .ftitle{
        display: none;
    }
    .keterangan{
        font-size: small;
    }

</style>

<script type="text/javascript">
    $(document).ready(function () {
        $('#checkbox1').change(function () {
            if (!this.checked) 
            //  ^
               $('#autoUpdate').fadeIn('slow');
            else 
                $('#autoUpdate').fadeOut('slow');
                $('#warningmessage').fadeOut('slow');
                
        });
    });


    function CheckProjectMandatory(){
        var i;
        var statuserror = false;
        for (i = 0; i <= 10; i++) {
          var myEle = document.getElementById("md_field_project_col_ProjectDate_"+i);
          if(myEle){
             var ProjectDate         = document.getElementById("md_field_project_col_ProjectDate_"+i).value;
             var ProjectName         = document.getElementById("md_field_project_col_ProjectName_"+i).value;
             var ProjectInstitution  = document.getElementById("md_field_project_col_ProjectInstitution_"+i).value;
             var ProjectYear         = document.getElementById("md_field_project_col_ProjectYear_"+i).value;
             var ProjectLength       = document.getElementById("md_field_project_col_ProjectLength_"+i).value;
             var ProjectTechnicalSpec= document.getElementById("md_field_project_col_ProjectTechnicalSpec_"+i).value;
             var ProjectPosition     = document.getElementById("md_field_project_col_ProjectPosition_"+i).value;

             //===================================================
             if(ProjectDate=="" || ProjectName=="" || 
                ProjectInstitution=="" || ProjectYear=="" || 
                ProjectLength=="" || ProjectTechnicalSpec=="" || 
                ProjectPosition=="") {
                statuserror = true;
                console.log("CHECKING KE " + i + " ERROR"); 
             }
             //====================================================
          }
        }

        if(statuserror){
            $('#warningmessage').fadeIn('slow');
            document.getElementById("checkbox1").checked = false;                
         } 
        
    }


</script>
