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


		if ($this->uri->segment(4) !='edit' AND $this->uri->segment(4) != 'add' AND $this->uri->segment(4) !='read'){
          
        }else{
         
        }
// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}


		if ($this->uri->segment('4') =='edit'){

            echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);
            //echo '<ol>Email akan dikirim ke HRD Setelah anda melakukan proses Update.</ol>';

        }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Resume</title>
<link type="text/css" rel="stylesheet" href="http://172.17.0.16/hris2/css/blue.css" />
<link type="text/css" rel="stylesheet" href="http://172.17.0.16/hris2/css/print.css" media="print"/>
<!--[if IE 7]>
<link href="css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if IE 6]>
<link href="css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script type="text/javascript" src="http://172.17.0.16/hris2/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://172.17.0.16/hris2/js/jquery.tipsy.js"></script>
<script type="text/javascript" src="http://172.17.0.16/hris2/js/cufon.yui.js"></script>
<script type="text/javascript" src="http://172.17.0.16/hris2/js/scrollTo.js"></script>
<script type="text/javascript" src="http://172.17.0.16/hris2/js/myriad.js"></script>
<script type="text/javascript" src="http://172.17.0.16/hris2/js/jquery.colorbox.js"></script>
<script type="text/javascript" src="http://172.17.0.16/hris2/js/custom.js"></script>
<script type="text/javascript">
        Cufon.replace('h1,h2');
</script>
</head>
<body>
<!-- Begin Wrapper -->
<div id="wrapper">
  <div class="wrapper-top"></div>
  <div class="wrapper-mid">
    <!-- Begin Paper -->
    <div id="paper">
      <div class="paper-top"></div>
      <div id="paper-mid">
        <div class="entry">
          <!-- Begin Image -->
          <img class="portrait" src="http://172.17.0.16/hris2/images/image.jpg" alt="John Smith" />
          <!-- End Image -->
          <!-- Begin Personal Information -->
          <div class="self">
            <h1 class="name">John Smith <br />
              <span>Interactive Designer</span></h1>
            <ul>
              <li class="ad">111 Lorem Street, 34785 Ipsum City sdfsd sdfs</li>
              <li class="mail">johnsmith@business.com</li>
              <li class="tel">+11 444 555 22 33</li>
              <li class="web">www.businessweb.com</li>
            </ul>
          </div>
          <!-- End Personal Information -->
          <!-- Begin Social -->
          <div class="social">
            <ul>
              <li><a class='north' href="#" title="Edit"><img src="http://172.17.0.16/hris2/images/icn-edit.png" alt="" /></a></li> 
              <li><a class='north' href="#" title="Download .xls"><img src="http://172.17.0.16/hris2/images/icn-save.jpg" alt="Download the pdf version" /></a></li>
              <li><a class='north' href="javascript:window.print()" title="Print"><img src="http://172.17.0.16/hris2/images/icn-print.jpg" alt="" /></a></li>
              <li><a class='north' id="contact" href="contact/index.html" title="Send Me Email"><img src="http://172.17.0.16/hris2/images/icn-contact.jpg" alt="" /></a></li>
              
            </ul>
          </div>
          <!-- End Social -->
        </div>
        <!-- Begin 1st Row -->
        <div class="entry">
          <h2>OBJECTIVE</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin dignissim viverra nibh sed varius. Proin bibendum nunc in sem ultrices posuere. Aliquam ut aliquam lacus.</p>
        </div>
        <!-- End 1st Row -->
        <!-- Begin 2nd Row -->
        <div class="entry">
          <h2>EDUCATION</h2>
          <div class="content">
            <h3>Sep 2005 - Feb 2007</h3>
            <p>Academy of Art University, London <br />
              <em>Master in Communication Design</em></p>
          </div>
          <div class="content">
            <h3>Sep 2001 - Jun 2005</h3>
            <p>University of Art &amp; Design, New York <br />
              <em>Bachelor of Science in Graphic Design</em></p>
          </div>
        </div>
        <!-- End 2nd Row -->
        <!-- Begin 3rd Row -->
        <div class="entry">
          <h2>EXPERIENCE</h2>
          <div class="content">
            <h3>May 2009 - Feb 2010</h3>
            <p>Agency Creative, London <br />
              <em>Senior Web Designer</em></p>
            <ul class="info">
              <li>Vestibulum eu ante massa, sed rhoncus velit.</li>
              <li>Pellentesque at lectus in <a href="#">libero dapibus</a> cursus. Sed arcu ipsum, varius at ultricies acuro, tincidunt iaculis diam.</li>
            </ul>
          </div>
          <div class="content">
            <h3>Jun 2007 - May 2009</h3>
            <p>Junior Web Designer <br />
              <em>Bachelor of Science in Graphic Design</em></p>
            <ul class="info">
              <li>Sed fermentum sollicitudin interdum. Etiam imperdiet sapien in dolor rhoncus a semper tortor posuere. </li>
              <li>Pellentesque at lectus in libero dapibus cursus. Sed arcu ipsum, varius at ultricies acuro, tincidunt iaculis diam.</li>
            </ul>
          </div>
        </div>
        <!-- End 3rd Row -->
        <!-- Begin 4th Row -->
        <div class="entry">
          <h2>SKILLS</h2>
          <div class="content">
            <h3>Software Knowledge</h3>
            <ul class="skills">
              <li>Photoshop</li>
              <li>Illustrator</li>
              <li>InDesign</li>
              <li>Flash</li>
              <li>Fireworks</li>
              <li>Dreamweaver</li>
              <li>After Effects</li>
              <li>Cinema 4D</li>
              <li>Maya</li>
            </ul>
          </div>
          <div class="content">
            <h3>Languages</h3>
            <ul class="skills">
              <li>CSS/XHTML</li>
              <li>PHP</li>
              <li>JavaScript</li>
              <li>Ruby on Rails</li>
              <li>ActionScript</li>
              <li>C++</li>
            </ul>
          </div>
        </div>
        <!-- End 4th Row -->
         <!-- Begin 5th Row -->
        <div class="entry">
        <h2>WORKS</h2>
            <ul class="works">
                <li><a href="images/1.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="http://172.17.0.16/hris2/images/image.jpg" alt="" /></a></li>
                <li><a href="images/2.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="http://172.17.0.16/hris2/images/image.jpg" alt="" /></a></li>
                <li><a href="images/3.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="http://172.17.0.16/hris2/images/image.jpg" alt="" /></a></li>
                <li><a href="images/1.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="http://172.17.0.16/hris2/images/image.jpg" alt="" /></a></li>
                <li><a href="images/2.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="http://172.17.0.16/hris2/images/image.jpg" alt="" /></a></li>
                <li><a href="images/3.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="http://172.17.0.16/hris2/images/image.jpg" alt="" /></a></li>
                <li><a href="images/1.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="http://172.17.0.16/hris2/images/image.jpg" alt="" /></a></li>
                <li><a href="images/1.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="http://172.17.0.16/hris2/images/image.jpg" alt="" /></a></li>
            </ul>
        </div>
        <!-- Begin 5th Row -->
      </div>
      <div class="clear"></div>
      <div class="paper-bottom"></div>
    </div>
    <!-- End Paper -->
  </div>
  <div class="wrapper-bottom"></div>
</div>
<div id="message"><a href="#top" id="top-link">Go to Top</a></div>
<!-- End Wrapper -->
</body>
</html>


<?php
if(isset($dropdown_setup)) {
  $this->load->view('dependent_dropdown', $dropdown_setup);
}
?>

<style type="text/css">
    .box{
        padding: 20px;
        display: none;
        margin-top: 20px;
        border: 1px solid #000;
    }
    
    .autoUpdate{ 
    	background: #FFFFCC;
    	padding: 20px;
    	margin-top: 20px;
        border: 1px solid #000;
        color:#FF0000;
        width: 100%;
    	
         }

    label {
        display: block;
        padding-left: 15px;
        text-indent: -15px;
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
        	
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function()
        {
    var changeYear = $( ".datepicker-input" ).datepicker( "option", "changeYear" );
    $( ".datepicker-input" ).datepicker( "option", "yearRange", "-70:+70" );
        });
</script>

