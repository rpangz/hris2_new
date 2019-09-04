<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script type="text/javascript" src="{{ base_url }}assets/jquery/ui/jquery-1.8.3.js"></script>
<script type="text/javascript" src="{{ base_url }}assets/jquery/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="{{ base_url }}assets/jquery/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="{{ base_url }}assets/jquery/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="{{ base_url }}assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ base_url }}assets/bootstrap/js/bootstrap.js"></script>

<script type="text/javascript" src="{{ base_url }}themes/cerulean/assets/default/script.js"></script>



<link href="{{ base_url }}themes/cerulean/assets/default/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="{{ base_url }}includes/css/tcal_bootstrap.css" />
<script type="text/javascript" src="{{ base_url }}includes/js/tcal.js"></script>


<label for="idTourDateDetails">Choose Date :</label>
    <div class="form-group">
        <div class="input-group">
            <input type="text" name="idTourDateDetails" id="idTourDateDetails" class="form-control tcal" placeholder="Start Date"><span class="input-group-addon"><i id="calIconTourDateDetails" class="glyphicon glyphicon-calendar"></i></span>
            <input type="text" name="idTourDateDetails" id="idTourDateDetails" class="form-control tcal" placeholder="End Date"><span class="input-group-addon"><i id="calIconTourDateDetails" class="glyphicon glyphicon-calendar"></i></span>
        </div>
</div>


TYPE html>
<html>
<head>
    <title>Date Picker</title>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
</head>

<body>

<br>
<div class="container">
    <form action="PDF.php" method="post">
 <legend>Date Time Picker Bootstrap</legend>
        <fieldset>
   <div class="form-group">
                <label for="dtp_input2" class="col-md-2 control-label">Tanggal</label>
                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="10" type="text" name="dari">
     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
    <input type="hidden" id="dtp_input2" value=""/><br/>
            </div>
        </fieldset>
  
    </form>
</div>


<script type="text/javascript">
 $('.form_date').datetimepicker({
        language:  'id',
        weekStart: 1,
        todayBtn:  1,
  autoclose: 1,
  todayHighlight: 1,
  startView: 2,
  minView: 2,
  forceParse: 0
    });
</script>

</body>
</html>