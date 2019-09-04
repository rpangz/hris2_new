<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$this->load->model('data_filter_model');
$this->config->load('cms_config');       
$company_id = $this->config->item('cms_mediaindonusa_id');
$modules    = $this->uri->segment('1');
$pages      = $this->uri->segment('2');
$current_id = $this->uri->segment('4');
  
echo $this->data_filter_model->data_filter_report($current_id,$modules,$pages);



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



?>

<script type = "text/javascript">
function goToPage( id ) {
  var node = document.getElementById( id );  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>

<link type="text/css" rel="stylesheet" href="{{ base_url }}assets/bootstrap/css/datepicker.css">
<script src="http://<?php echo $_SERVER['SERVER_NAME']?>/hris2/includes/js/bootstrap-datepicker.js"></script>

<?php

switch($this->uri->segment('4')){

case "1": ?>

<div id="myModal" class="modal fade">
  <div class = "modal-dialog">
    <div class = "modal-content">
    <div class="modal-body">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Report Filter <?php echo modal_status_name($this->uri->segment('4'))?></h4>
      </div>
      <form class="form-horizontal" role="form" action="" enctype="multipart/form-data" method="get">
        <table width="100%" border="0" cellspacing="0" cellpadding="0"> 
         <tr>
          <td>
           <?php include 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/report/modul_item.php?company='.$company_id;?>
          </td>
        </tr>     
       </table>        
      <br/>
      <div class="form-group">        
        <div class="col-md-12">
          <label for="from">Start Date :</label>
          <div class="input-group date" data-provide="datepicker">
            <input type="text" class="form-control" name="from" placeholder="dd-mm-yyyy">
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
          </div>
        </div>
      </div>
      <div class="form-group">        
        <div class="col-md-12">
          <label for="to">End Date :</label>
          <div class="input-group date" data-provide="datepicker">
            <input type="text" class="form-control" name="to" placeholder="dd-mm-yyyy">
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
          </div>
        </div>
      </div>      
    </div>  

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="submit" value="Generate">
    </div>
    </form>
    </div>
  </div>  
</div>

<?php
break;


case "2":
?> 

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Report Filter <?php echo modal_status_name($this->uri->segment('4'))?></h4>
            </div>
            <div class="modal-body">
          <form name="form2" action="" method="GET">
          <table class="table2" width="100%" border="0" cellspacing="0" cellpadding="5"> 
         <tr>
          <td>
           <?php include 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/report/modul_item.php?company='.$company_id;?>
          </td>
        </tr>
        <tr>
          <td><label for="JenisCuti">Jenis Cuti :</label><select id="JenisCuti" name="jc" class="form-control">
          <option value="0" disabled SELECTED>---Jenis Cuti---</option>
      <?php      
            $sql = mysql_query("SELECT * FROM tbl_jeniscuti WHERE id=1 || id=2 ORDER BY id ASC");            
              while ($dt = mysql_fetch_array($sql)){
                  echo "<option value='$dt[id]'>$dt[JenisCutiName]</option>";
              };
      ?>
            
    </select>
        </td>
          </tr>         
        </table>       
        <br/>     

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" name="submit" value="Generate">
            </div>
        </div>
        </form>
    </div>
</div>

<?php

break;

case "3": ?>

<div id="myModal" class="modal fade">
  <div class = "modal-dialog">
    <div class = "modal-content">
    <div class="modal-body">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Report Filter <?php echo modal_status_name($this->uri->segment('4'))?></h4>
      </div>
      <form class="form-horizontal" role="form" action="" enctype="multipart/form-data" method="get">
        <table width="100%" border="0" cellspacing="0" cellpadding="0"> 
         <tr>
          <td>
           <?php include 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/report/modul_item.php?company='.$company_id;?>
          </td>
        </tr>     
       </table>        
      <br/>
      <div class="form-group">        
        <div class="col-md-12">
          <label for="from">Start Date :</label>
          <div class="input-group date" data-provide="datepicker">
            <input type="text" class="form-control" name="from" placeholder="dd-mm-yyyy">
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
          </div>
        </div>
      </div>
      <div class="form-group">        
        <div class="col-md-12">
          <label for="to">End Date :</label>
          <div class="input-group date" data-provide="datepicker">
            <input type="text" class="form-control" name="to" placeholder="dd-mm-yyyy">
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
          </div>
        </div>
      </div>      
    </div>  

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="submit" value="Generate">
    </div>
    </form>
    </div>
  </div>  
</div>





<?php
break;


case "4": ?>

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Report Filter <?php echo modal_status_name($this->uri->segment('4'))?></h4>
            </div>
            <div class="modal-body">
          <form name="form2" action="" method="GET">
          <table class="table2" width="100%" border="0" cellspacing="0" cellpadding="5"> 
         <tr>
          <td>
           <?php include 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/report/modul_item.php?company='.$company_id;?>
          </td>
        </tr>
        <tr>
          <td><label for="jenis_ijin">Jenis Ijin :</label><select id="jc" name="jc" class="form-control">
          
      <?php      
            $sql = mysql_query("SELECT * FROM tbl_jenisijin ORDER BY JenisIjinId ASC");            
              while ($dt = mysql_fetch_array($sql)){
                  echo "<option value='$dt[JenisIjinId]'>$dt[JenisIjinName]</option>";
              };
      ?>
            
    </select>
        </td>
          </tr>         
        </table>       
        <br/>     

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" name="submit" value="Generate">
            </div>
        </div>
        </form>
    </div>
</div>

<?php
case "5": ?>





<div id="myModal" class="modal fade">
  <div class = "modal-dialog">
    <div class = "modal-content">
    <div class="modal-body">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Report Filter <?php echo modal_status_name($this->uri->segment('4'))?></h4>
      </div>
      <form class="form-horizontal" role="form" action="" enctype="multipart/form-data" method="get">
        <table width="100%" border="0" cellspacing="0" cellpadding="0"> 
         <tr>
          <td>
           <?php include 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/report/modul_item.php?company='.$company_id;?>
          </td>
        </tr>     
       </table>        
      <br/>
      <div class="form-group">        
        <div class="col-md-12">
          <label for="from">Start Date :</label>
          <div class="input-group date" data-provide="datepicker">
            <input type="text" class="form-control" name="from" placeholder="dd-mm-yyyy">
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
          </div>
        </div>
      </div>
      <div class="form-group">        
        <div class="col-md-12">
          <label for="to">End Date :</label>
          <div class="input-group date" data-provide="datepicker">
            <input type="text" class="form-control" name="to" placeholder="dd-mm-yyyy">
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
          </div>
        </div>
      </div>      
    </div>  

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="submit" value="Generate">
    </div>
    </form>
    </div>
  </div>  
</div>







<?php


break;



}

function modal_status_btn($value){

    $query  = mysql_query('SELECT * FROM tbl_reports WHERE ReportId='.$value);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return '';
    }
    else {
        return 'disabled';
    }
    

}


function modal_status_name($value){

    $query  = mysql_query('SELECT * FROM tbl_reports WHERE ReportId='.$value);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['ReportName'];
    }
    else {
        return '';
    }
    

}

function report_modules_name($value){

    $query  = mysql_query('SELECT * FROM tbl_reports WHERE ReportId='.$value);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['ReportModules'];
    }
    else {
        return '#';
    }
    

}


?>     





<?php

if (!is_null($this->input->get('submit')) && ($this->input->get('submit')=='Generate')){
 
  include 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/report/'.report_modules_name($this->uri->segment('4')).'?company='.$company_id.'&pt='.$this->input->get('pt').'&div='.$this->input->get('div').'&dept='.$this->input->get('dept').'&jc='.$this->input->get('jc').'&from='.$this->input->get('from').'&to='.$this->input->get('to');

}

else {
    echo "Silahkan Pilih Filter Diatas...";
}

?>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<link href="https://apps.unias.com/hris2/themes/{{ used_theme }}/assets/default/bootstrap.min.css" rel="stylesheet">

<script>
    $('.input-group.date').datepicker({
      format: "dd-mm-yyyy",
      startDate: "01-01-2012",
      endDate: "01-01-2020",
      todayBtn: "linked",
      autoclose: true,
      todayHighlight: true,
      yearRange: "c-70:c+70",
      changeMonth: true,
      changeYear: true,
    });

    $(".input-group.date").css('cursor','pointer');
</script> 

<script type="text/javascript">
  $(document).ready(function(){
    $("#myModal").modal('show');
  });

  var toggle = '[data-toggle=dropdown]'
, Dropdown = function (element) {
    var $el = $(element).on('click.dropdown.data-api', this.toggle)
    $('html').on('click.dropdown.data-api', function () {
      $el.parent().removeClass('open')
    })
  }

</script>


<!--<script src="https://apps.unias.com/hris2/assets/bootstrap/js/bootstrap.min.js"></script>-->