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
//echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);
?>

 


  
<style>

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
.panel {margin-top: 25px;}
.panel .panel-heading { padding: 5px 5px 0 5px;}
.panel .nav-tabs {border-bottom: none;}


/* table */ 

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
            </style>

  
    

      

            
          <div class="panel panel-default panel-fade">
          
            <div class="panel-heading">
             
              <span class="panel-title">
              
                <div class="pull-left">
                <!--
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#letters" data-toggle="tab"><i class="glyphicon glyphicon-print"></i> Letters</a></li>
                  <li><a href="#emails" data-toggle="tab"><i class="glyphicon glyphicon-send"></i> Emails</a></li>
                  <li><a href="#loglist" data-toggle="tab"><i class="glyphicon glyphicon-list"></i> Logs</a></li>
                </ul>

                -->

                 <ul class="nav nav-tabs">
                  <li class="active"><a href="#letters" data-toggle="tab"><img src="{{ base_url }}assets/images/performance_icn.png" class="img-circle" alt="Performance" width="30" height="30"> Kinerja</a></li>
                  <li><a href="#emails" data-toggle="tab"><img src="{{ base_url }}assets/images/attitude_icn.png" class="img-circle" alt="Attitude" width="30" height="30"> Sikap</a></li>
                  <li><a href="#loglist" data-toggle="tab"><img src="{{ base_url }}assets/images/time1_icn.png" class="img-circle" alt="Time" width="30" height="30"> Waktu</a></li>
                </ul>
                  
                </div>
                
                <!--<div class="btn-group pull-right">
                  <div class="btn-group">
                    <a href="#" class="btn  dropdown-toggle" data-toggle="dropdown">
                      <span class="glyphicon glyphicon-cog"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Action 1</a></li>
                      <li><a href="#">Action 2</a></li>
                      <li class="divider"></li>
                      <li><a href="#">Another Action</a></li>
                    </ul>
                  </div>
                </div>-->

                <div class="clearfix"></div>

              </span>
              
            </div>
            <div class="panel-body">
                        
                                
              <div class="tab-content">    
                  <div class="tab-pane fade in active" id="letters">
                  <h3>Letters</h3>
                 <FORM ACTION="" METHOD="post">
                  <INPUT TYPE="hidden" NAME="FormName" VALUE="PrintLetters">
                  <TABLE class="table table-striped">
                  <THEAD>
                    <TR><TH>Print</TH><TH style="text-align:left">Subscription</TH><TH style="text-align:left">Venue</TH><TH>Date/Time</TH><TH>Quantity</TH></TR>
                  </THEAD>
                  <TBODY>
                    <TR><TD><INPUT TYPE="checkbox" NAME="EventCode" VALUE=588031></TD><TD>Season Subscription (Winter)</TD><TD>Downtown Theater</TD><TD>1/1/2015 12:00 PM</TD><TD>8</TD></TR>
                    <TR><TD><INPUT TYPE="checkbox" NAME="EventCode" VALUE=588031></TD><TD>Season Subscription (Spring)</TD><TD>Downtown Theater</TD><TD>1/1/2015 12:00 PM</TD><TD>8</TD></TR>
                    <TR><TD><INPUT TYPE="checkbox" NAME="EventCode" VALUE=588031></TD><TD>Season Subscription (Summer)</TD><TD>Downtown Theater</TD><TD>1/1/2015 12:00 PM</TD><TD>8</TD></TR>
                    <TR><TD><INPUT TYPE="checkbox" NAME="EventCode" VALUE=588031></TD><TD>Season Subscription (Fall)</TD><TD>Downtown Theater</TD><TD>1/1/2015 12:00 PM</TD><TD>8</TD></TR>
                  </TBODY>
                  </TABLE>
                  Select events and click below<BR><BR>
                  <INPUT TYPE="submit" CLASS="btn btn-outline btn-default" VALUE="Submit">
                
                </div>
              
                          
                    <div class="tab-pane fade" id="emails">
                <h3>Emails</h3>                
                 
                  <INPUT TYPE="hidden" NAME="FormName" VALUE="PrintLetters">
                  <TABLE class="table table-striped">
                  <THEAD>
                    <TR><TH>Print</TH><TH style="text-align:left">Subscription</TH><TH style="text-align:left">Venue</TH><TH>Date/Time</TH><TH>Quantity</TH></TR>
                  </THEAD>
                  <TBODY>
                    <TR><TD><INPUT TYPE="checkbox" NAME="EventCode" VALUE=588031></TD><TD>Season Subscription (Winter)</TD><TD>Downtown Theater</TD><TD>1/1/2015 12:00 PM</TD><TD>8</TD></TR>
                    <TR><TD><INPUT TYPE="checkbox" NAME="EventCode" VALUE=588031></TD><TD>Season Subscription (Spring)</TD><TD>Downtown Theater</TD><TD>1/1/2015 12:00 PM</TD><TD>8</TD></TR>
                    <TR><TD><INPUT TYPE="checkbox" NAME="EventCode" VALUE=588031></TD><TD>Season Subscription (Summer)</TD><TD>Downtown Theater</TD><TD>1/1/2015 12:00 PM</TD><TD>8</TD></TR>
                    <TR><TD><INPUT TYPE="checkbox" NAME="EventCode" VALUE=588031></TD><TD>Season Subscription (Fall)</TD><TD>Downtown Theater</TD><TD>1/1/2015 12:00 PM</TD><TD>8</TD></TR>
                  </TBODY>
                  </TABLE>
                  Select events and click below<BR><BR>
                  <INPUT TYPE="submit" CLASS="btn btn-outline btn-default" VALUE="Submit">
                
                </div>
                
                  <div class="tab-pane fade" id="loglist">
                <h3>Logs</h3>                  
                 
                  <INPUT TYPE="hidden" NAME="FormName" VALUE="PrintLetters">
                  <TABLE class="table table-striped">
                  <THEAD>
                    <TR><TH>Print</TH><TH style="text-align:left">Subscription</TH><TH style="text-align:left">Venue</TH><TH>Date/Time</TH><TH>Quantity</TH></TR>
                  </THEAD>
                  <TBODY>
                    <TR><TD><INPUT TYPE="checkbox" NAME="EventCode" VALUE=588031></TD><TD>Season Subscription (Winter)</TD><TD>Downtown Theater</TD><TD>1/1/2015 12:00 PM</TD><TD>8</TD></TR>
                    <TR><TD><INPUT TYPE="checkbox" NAME="EventCode" VALUE=588031></TD><TD>Season Subscription (Spring)</TD><TD>Downtown Theater</TD><TD>1/1/2015 12:00 PM</TD><TD>8</TD></TR>
                    <TR><TD><INPUT TYPE="checkbox" NAME="EventCode" VALUE=588031></TD><TD>Season Subscription (Summer)</TD><TD>Downtown Theater</TD><TD>1/1/2015 12:00 PM</TD><TD>8</TD></TR>
                    <TR><TD><INPUT TYPE="checkbox" NAME="EventCode" VALUE=588031></TD><TD>Season Subscription (Fall)</TD><TD>Downtown Theater</TD><TD>1/1/2015 12:00 PM</TD><TD>8</TD></TR>
                  </TBODY>
                  </TABLE>
                  Select events and click below<BR><BR>
                  <INPUT TYPE="submit" CLASS="btn btn-outline btn-default" VALUE="Submit">
                </FORM>
                </div>

              </div>
              
            </div>

          </div> 
   






<style>



        
.nav-tabs > li > a::after { content: ""; background: #4285F4; height: 2px; position: absolute; width: 100%; left: 0px; bottom: -1px; transition: all 250ms ease 0s; transform: scale(0); }
.nav-tabs > li.active > a::after, .nav-tabs > li:hover > a::after { transform: scale(1); }


</style>