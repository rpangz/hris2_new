<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $this->load->model('development_model');

?>

<style type="text/css">
.label-info {
    background-color: #FFFF00;
    color:#000000;
}

.label-warning {
    background-color: #FF9900;
}

</style>

<?php

$asset = new CMS_Asset();
foreach($css_files as $file){
    $asset->add_css($file);
}
echo $asset->compile_css();

foreach($js_files as $file){
    $asset->add_js($file);
}
echo $asset->compile_js();


echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);

// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}

//if ($state !='edit' AND $state != 'add' AND $state !='delete' AND $action !='edit' AND $action !='add'){ 

  //echo $asset->compile_js();

  //echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);

//}

if ($state =='edit' OR $state == 'add'){

    echo '<style> .container {width: 100%;}</style>';
?>

<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />

<style type="text/css">
/* Hidding the radiobuttons & checkboxes */
input[type="radio"], input[type="checkbox"] {
    display: none;
}
/* Hidding the "check" status of inputs */
input[type="radio"] + label .fa-circle,
input[type="checkbox"] + label .fa-check  {
display: none;
}
/* Styling the "check" status */
input[type="radio"]:checked + label .fa-circle,
input[type="checkbox"]:checked + label .fa-check {
display: block;
color: DarkTurquoise;
}
/* Styling checkboxes */
input[type="checkbox"]:checked + label .fa-check {
position: relative;
left: .125em;
bottom: .125em;
}
/* Styling radiobuttons */
input[type="radio"]:checked + label .fa-circle-o {
display: none;
}


span.glyphicon-ok {
    font-size: 16px;
}


input[type="radio"] {
  margin-top: -1px;
  vertical-align: middle;
}


.label-info {
    background-color: #FFFF00;
    color:#000000;
}

.label-warning {
    background-color: #FF9900;
}

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

<!--
<div class="bs-example">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#Kinerja">Kinerja</a></li>
        <li><a data-toggle="tab" href="#Sikap">Sikap</a></li>
       
    </ul>
    <div class="tab-content">
        <div id="Kinerja" class="tab-pane fade in active">
            <h3>Kinerja</h3>
            <?php //echo $field_kpi_performance; ?>
        </div>
        <div id="Sikap" class="tab-pane fade">
            <h3>Sikap</h3>
            <p>Vestibulum nec erat eu nulla rhoncus fringilla ut non neque. Vivamus nibh urna, ornare id gravida ut, mollis a magna. Aliquam porttitor condimentum nisi, eu viverra ipsum porta ut. Nam hendrerit bibendum turpis, sed molestie mi fermentum id. Aenean volutpat velit sem. Sed consequat ante in rutrum convallis. Nunc facilisis leo at faucibus adipiscing.</p>
        </div>
       
    </div>
</div>
-->

<div class="panel panel-default panel-fade">          
    <div class="panel-heading">             
        <span class="panel-title">              
            <div class="pull-left">
                <ul class="nav nav-tabs">
                    <?php echo $this->development_model->nav_tabs_kpi(); ?> 
                </ul>                  
            </div>
            <div class="btn-group pull-right">
                <div class="btn-group">
                    <h4><span class="label label-default" id="head_total_score">TOTAL NILAI : 0.00</span></h4>
                </div>
            </div>
            <div class="clearfix"></div>
        </span>              
    </div>
    <div class="panel-body">                    
        <!--<form id="crudForm" name="crudForm" action="{{ base_url }}development/frmKeyPerformanceIndicator/index/<?php //echo $action ?>" method="post" autocomplete="off" enctype="multipart/form-data" />-->
            <input type="hidden" value="<?php echo $session_nik ?>" name="nik" />
            <input type="hidden" value="<?php echo $previous ?>" name="previous" id="previous"/>                  
            <div class="tab-content">
                <div class="tab-pane fade in active" id="Kinerja">
                    <?php echo $field_kpi_performance; ?>
                </div>
                <div class="tab-pane fade in" id="Sikap">
                    <?php echo $field_kpi_attitude; ?>
                </div>
                <div class="tab-pane fade in" id="Waktu">
                    <?php echo $field_kpi_time; ?>
                </div>
            </div>              
            <div class="modal-footer">               
                
                <!--<input type="button" value="Save changes" id="save-and-go-back-button" class="btn btn-primary"/>-->                
                <input type="button" value="Cancel" class="btn btn-default" id="cancel-button" />
                <!--<input  id="form-button-save" type="submit" value="Save changes" class="btn btn-primary"/>-->
                <input type="button" value="Save changes" id="save-and-go-back-button" class="btn btn-primary"/>            

                <!--<input type="button" value="Cancel" class="btn btn-default" id="cancel-button" />
                <input id="form-button-save" type="submit" class="btn btn-primary" value="Save changes" />-->
            </div>
            <div class="form-button-box" style="width:100%;float: right;">
                <div class="small-loading" id="FormLoading" style="width:100%;float: right;">Loading, updating changes...</div>
            </div>
            <div class="clear"></div>
        </form>        
    </div>
</div> 

</div>
</div>

<?php }  ?>


<style>

input.add {
    -moz-border-radius: 4px;
    border-radius: 4px;
    background-color:#6FFF5C;
    -moz-box-shadow: 0 0 4px rgba(0, 0, 0, .75);
    box-shadow: 0 0 4px rgba(0, 0, 0, .75);
}
input.add:hover {
    background-color:#1EFF00;
    -moz-border-radius: 4px;
    border-radius: 4px;
}
input.removeRow {
    -moz-border-radius: 4px;
    border-radius: 4px;
    background-color:#FFBBBB;
    -moz-box-shadow: 0 0 4px rgba(0, 0, 0, .75);
    box-shadow: 0 0 4px rgba(0, 0, 0, .75);
}
input.removeRow:hover {
    background-color:#FF0000;
    -moz-border-radius: 4px;
    border-radius: 4px;
}


/* links: outlines and underscores */  
a.btn,      
a.btn:active, 
a.btn:focus, 

button.btn:active, 
button.btn:focus,   
button.btn:active, 
button.btn:focus, 

.dropdown-menu li a,
.dropdown-menu li a:active,
.dropdown-menu li a:focus,
.dropdown-menu li a:hover,

ul.dropdown-menu li a,
ul.dropdown-menu li a:active,
ul.dropdown-menu li a:focus,
ul.dropdown-menu li a:hover,

.nav-tabs li a,
.nav-tabs li a:active,
.nav-tabs li a:focus { outline:0px !important; -webkit-appearance:none;  text-decoration:none; }  

</style>

<style>
/* panel */ 
.panel {margin-top: 2px;}
.panel .panel-heading { padding: 5px 5px 0 5px;}
.panel .nav-tabs {border-bottom: none;}


/* table */ 
/*
.table > thead > tr > th, 
.table > tbody > tr > th, 
.table > tfoot > tr > th
{
background-color: #000000;
color: #ffffff;
border-bottom: 1px solid #F3F3F3;
border-top: 1px solid #F3F3F3 !important;
line-height: 1.42857;
padding: 8px;
vertical-align: top;
}

.table > thead > tr > td, 
.table > tbody > tr > td, 
.table > tfoot > tr > td 
{
border-top: 0px solid blue;
line-height: 1.42857;
padding: 8px;
vertical-align: top;
background-color: #F3F3F3;

}

.table-striped > tbody > tr:nth-child(2n+1) > td 
{ 
background-color: #ffffff;
}
*/
/* buttons */ 
.btn-default.btn-outline:active,
.btn-default.btn-outline:focus, 
.btn-default.btn-outline    { color: #676767; border-color: #676767; background-color: transparent; border-width: 2px; -webkit-transition: all 0.25s; -moz-transition: all 0.25s; transition: all 0.25s;}   
.btn-default.btn-outline:hover  { color: #000000; border-color: #000000; background-color: transparent; border-width: 2px; -webkit-transition: all 0.75s; -moz-transition: all 0.75s; transition: all 0.75s; } 


/* panel buttons */ 
.btn-group button.btn.btn-outline.btn-default       { background-color: #f5f5f5; color: #676767; border-color: #dddddd; border-width: 1px; padding: 5px 15px; line-height: 2; -webkit-transition: all 0.75s; -moz-transition: all 0.75s; transition: all 0.75s; }} 
.btn-group button.btn.btn-outline.btn-default:focus   { background-color: #f5f5f5;} 
.btn-group button.btn.btn-outline.btn-default:active    { background-color: #f5f5f5;}
.btn-group button.btn.btn-outline.btn-default:hover   { background-color: #eeeeee; border-width: 1px; -webkit-transition: all 0.75s; -moz-transition: all 0.75s; transition: all 0.75s; } 

.btn-outline.btn-highlight  { color: #676767; border-color: #676767; background-color: transparent; border-width: 2px;}

.display-title { font family: verdana, arial, helvetica; color:#008400;}


ul.nav.nav-tabs li.btn-group.active > a.btn.btn-default
{
border: 1px solid #dddddd;
background-color: #ffffff;
border-right:0px;
margin-right: 0px;
border-bottom: 0px;
}

ul.nav.nav-tabs li.btn-group > a.btn.btn-default
{
border: 1px solid #F5F5F5;
border-right:0px;
margin-right: 0px;
border-bottom: 0px;
}

ul.nav.nav-tabs > li.btn-group.active > a.btn.dropdown-toggle
{
border: 1px solid #dddddd;
background-color: #ffffff;
margin-left: 0px;
border-left:0px;
border-bottom: 0px;
 
}

ul.nav.nav-tabs > li.btn-group > a.btn.dropdown-toggle
{
border: 1px solid #F5F5F5;
margin-left: 0px;
border-left: 0px;
border-bottom: 0px;
}

 ul.nav.nav-tabs li.btn-group a.btn.dropdown-toggle span.caret
{
color: #F5F5F5;
}

 ul.nav.nav-tabs li.btn-group.active > a.btn.dropdown-toggle > span.caret
{
color: #999999;
}

.noborder-bottom{
  border-bottom: none !important;
}
.noborder-lr{
  border-right: none !important;
  border-left: none !important;
}
.noborder-r{
  border-right: none !important;
}
.noborder-l{
  border-left: none !important;
}

  </style>
  


<style type="text/css">
                .dropdown-submenu{
                    position:relative;
                }

                .dropdown-submenu > .dropdown-menu
                {
                    top:0;
                    left:100%;
                    margin-top:-6px;
                    margin-left:-1px;
                    -webkit-border-radius:0 6px 6px 6px;
                    -moz-border-radius:0 6px 6px 6px;
                    border-radius:0 6px 6px 6px;
                }

                .dropdown-submenu:hover > .dropdown-menu{
                    display:block;
                }

                .dropdown-submenu > a:after{
                    display:block;
                    content:" ";
                    float:left;
                    width:0;
                    height:0;
                    border-color:transparent;
                    border-style:solid;
                    border-width:5px 0 5px 5px;
                    border-left-color:#cccccc;
                    margin-top:5px;
                    margin-right:-10px;
                }

                .dropdown-submenu:hover > a:after{
                    border-left-color:#ffffff;
                }

                .dropdown-submenu .pull-left{
                    float:none;
                }

                .dropdown-submenu.pull-left > .dropdown-menu{
                    left:-100%;
                    margin-left:10px;
                    -webkit-border-radius:6px 0 6px 6px;
                    -moz-border-radius:6px 0 6px 6px;
                    border-radius:6px 0 6px 6px;
                }
                #_first-left-dropdown{
                    display:block;
                    margin:0px;
                    border:none;
                }
                @media (max-width: 750px){
                    #_first-left-dropdown{
                        position:static;
                    }
                }
            }


table.tftableon {

font-size:12px;
color:#333333;
border-width: 1px;
border-color: #729ea5;
border-collapse: collapse;
background-color: #FFFFFF;

}

table.tftableon th {
font-size:12px;
background-color:#CCCCCC;
border-width: 1px;
padding: 2px;
border-style: solid;
border-color:#999999;
text-align:center;
background: url("https://apps.unias.com/hris2/images/bg3.gif") repeat;
height: 24px;
}
table.tftableon td {
font-size:12px;
height: 24px;
border-width: 1px;
padding: 2px;
border-style: solid;
border-color:#999999;

}

table.tftableondetail {

font-size:12px;
color:#333333;
border-width: 1px;
border-color: #729ea5;
border-collapse: collapse;
background-color: #FFFFFF;

}

table.tftableondetail th {
font-size:14px;
background-color:#CCCCCC;
border-width: 1px;
padding: 2px;
border-style: solid;
border-color:#999999;
text-align:center;
background: url("https://apps.unias.com/hris2/images/bg.gif") repeat;

}
table.tftableondetail td {
font-size:12px;
border-width: 1px;
padding: 2px;
border-style: solid;
border-color:#999999;

}


table.tftableon tr {
background-color:#FFFFFF;
}

#tfhover{
    border-collapse:collapse;
}
#tfhover tr {
    background-color:transparent;
}
#tfhover tr:hover td {
  background-color:#D7EFFD;
}

#tfhover label:hover, label:active, input:hover+label, input:active+label {
  background-color:#D7EFFD;
}

#tfhover tr td.link{
    background-color:transparent;
}


table.tabborder {border-width:1px; border-spacing:0px; border-style:solid; 
     border-color:gray; border-collapse:separate; background-color:white;}
table.tabborder th,
table.tabborder td {border-width:1px; padding:2px;  border-style:inset; 
     border-color: black;background-color:white;}
.bold8 {width:50px; font-size:9px; font-family:arial; text-align:center; 
     font-weight:bold;}
.pt8 {width:10px; font-size:9px; font-family:arial; text-align:center;}
.gaya {
  font-size: 12px;
  font-family: Arial;}

</style>
<style>



        
.nav-tabs > li > a::after { content: ""; background: #4285F4; height: 2px; position: absolute; width: 100%; left: 0px; bottom: -1px; transition: all 250ms ease 0s; transform: scale(0); }
.nav-tabs > li.active > a::after, .nav-tabs > li:hover > a::after { transform: scale(1); }



</style>
<style type="text/css">
    .bs-example{
        margin: 20px;
    }   
    hr {
       border: 0;
    }

    .modal-dialog{
        padding-top: 2%;
    }

    a.my-tool-tip, a.my-tool-tip:hover, a.my-tool-tip:visited {

    color: black;
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