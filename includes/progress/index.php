<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>How to create pagination in PHP and MySQL with AJAX | PGPGang.com</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <script type="text/javascript" src="http://astapp02/hris2/includes/js/jquery-1.8.0.min.js"></script>
<style>
div.pagination {
padding: 3px;
margin: 3px;
text-align:center;
}

div.pagination a {
padding: 2px 5px 2px 5px;
margin: 2px;
border: 1px solid #AAAADD;

text-decoration: none; /* no underline */
color: #000099;
}
div.pagination a:hover, div.digg a:active {
border: 1px solid #000099;

color: #000;
}
div.pagination span.current {
padding: 2px 5px 2px 5px;
margin: 2px;
border: 1px solid #000099;

font-weight: bold;
background-color: #000099;
color: #FFF;
}
div.pagination span.disabled {
padding: 2px 5px 2px 5px;
margin: 2px;
border: 1px solid #EEE;

color: #DDD;
}

</style>

<script type="text/javascript">
$(document).ready(function(){
changePagination('0');	
});
function changePagination(pageId){
     $(".flash").show();
     $(".flash").fadeIn(400).html
                ('Loading <img src="ajax-loader.gif" />');
     var dataString = 'pageId='+ pageId;
     $.ajax({
           type: "POST",
           url: "http://astapp02/hris2/includes/progress/ProgressApprovalUser.php",
           data: dataString,
           cache: false,
           success: function(result){
           $(".flash").hide();
                 $("#pageData").html(result);
           }
      });
}
</script>
  </head>
  <body>
    <h2>How to create pagination in PHP and MySQL with AJAX example.&nbsp;&nbsp;&nbsp;=> <a href="http://www.phpgang.com/">Home</a> | <a href="http://demo.phpgang.com/">More Demos</a></h2>

<div id="pageData"></div>
<span class="flash"></span>

</body>
</html>