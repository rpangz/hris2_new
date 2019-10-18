<style type="text/css">
    .container {
        width: 100%;
    }

    .table th {
       text-align: center;         
    }

    table.paleBlueRows {
      font-family: "Times New Roman", Courier, monospace;
      width: 350px;
      height: 200px;
      text-align: center;
      border-collapse: collapse;
    }
    table.paleBlueRows td, table.paleBlueRows th {
      border: 1px solid #FFFFFF;
      padding: 3px 2px;
    }
    table.paleBlueRows tbody td {
      font-size: 12px;
      
    }
    table.paleBlueRows thead {
      background: #0B6FA4;
      border-bottom: 5px solid #FFFFFF;
    }
    table.paleBlueRows thead th {
      font-size: 12px;
      font-weight: bold;
      color: #FFFFFF;
      text-align: center;
      border-left: 2px solid #FFFFFF;

    }
    table.paleBlueRows thead th:first-child {
      border-left: none;
    }

</style>



<body onload="loaaddetaildata()">

<div class="col-md-6 text-left">
    <form class="form-horizontal" role="form">                                    
        <div class="form-group">
            <label class="col-md-2">Periode</label>
            <div class="col-sm-3">
                <select class="form-control input-sm" id="periode" name="periode" style="font-size: 12px;" data-attr="input_data">
                    <?php
                    $tahunskg = DATE('Y');                    
                    foreach ($period_option_data as $key => $value) {
                            if($value->PeriodID==$tahunskg){ $selected = 'SELECTED';} else {$selected = '';}                         
                            echo '<option value="'.$value->PeriodID.'" '.$selected.'>'.$value->PeriodID.'</option>';                      
                    }
                    ?>
                </select>                                                      
            </div>
            <div class="col-sm-3">
                <button class="btn btn-success waves-effect waves-light form-control" type="button" style="vertical-align: center;" id="search" onclick="loaaddetaildata()">
                    <label style="font-size: 12px"> - Load Data - </label>
                </button>                                                    
            </div>

        </div>     
                                                      
    </form>
</div> 



<div class="row" id="divdatatable">
    <div class="col-sm-12">
        <div class="card-box table-responsive" id="tabledetail">
            <!-- Detail DATA DISI AJAX -->           
        </div>
      </div>
</div>

</body>

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

    function loaaddetaildata(){
        var loadtext = '<div class="alert alert-info text-center" role="alert" style="font-weight: bold; font-size:15px;">PROCCESSING DATA, PLEASE WAIT . . . . .</div>'
        $('#tabledetail').html(loadtext);
        var periode = $('#periode').val();
        $.ajax({
          type: "POST",
          url: "second_layer_approvement/loaaddetaildata",
          data : {"periode" : periode},
          success: function(data){
            
            $('#tabledetail').html(data);
            /*=======================================================*/


            /*==========================================================*/  
          },      
        });     
    }

    function approve(kpiid){   
        $("#remarks"+kpiid).removeAttr('required');    
        var usulan = $('#usulan'+kpiid).val();
        var remarks = $('#remarks'+kpiid).val();
        $.ajax({
          type: "POST",
          url: "second_layer_approvement/approve",
          data : {"kpiid" : kpiid, "usulan" : usulan, "remarks" : remarks},
          success: function(data){  
            $('#tabledetail').html(data);
              setTimeout(function(){ loaaddetaildata(); }, 1000);
          },      
        });     
    }

    function unapprove(kpiid){
        $("#remarks"+kpiid).removeAttr('required');       
        var usulan = $('#usulan'+kpiid).val();
        var remarks = $('#remarks'+kpiid).val();
        $.ajax({
          type: "POST",
          url: "second_layer_approvement/unapprove",
          data : {"kpiid" : kpiid, "usulan" : usulan, "remarks" : remarks},
          success: function(data){  
            $('#tabledetail').html(data);
              setTimeout(function(){ loaaddetaildata(); }, 1000);
          },      
        });     
    }

    function revisi(kpiid){  
        $("#remarks"+kpiid).attr('required', '');    
        var usulan = $('#usulan'+kpiid).val();
        var remarks = $('#remarks'+kpiid).val();
        $.ajax({
          type: "POST",
          url: "second_layer_approvement/revisi",
          data : {"kpiid" : kpiid, "usulan" : usulan, "remarks" : remarks},
          success: function(data){  
            $('#tabledetail').html(data);
              setTimeout(function(){ loaaddetaildata(); }, 1000);
          },      
        });     
    }


    
</script>
