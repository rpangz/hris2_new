<?php
    $record_index = 1;
    $this->load->model('development_model');

?>
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ base_url }}assets/bootstrap/css/font-awesome.css" />

<style type="text/css">
    #md_table input[type="text"]{
        /*max-width:100px;*/
    }
    #md_table .chzn-drop input[type="text"]{
        /*max-width:240px;*/
    }
    #md_table th:last-child, #md_table td:last-child{
        /*width: 60px;*/
    }

    div.ext-box { display: table; }
    div.int-box { display: table-cell; vertical-align: middle; }



label.btn span {
  font-size: 1.5em ;
}

div[data-toggle="buttons"] label.active{
    color: #7AA3CC;
}

div[data-toggle="buttons"] label {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 2em;
    text-align: left;
    white-space: nowrap;
    vertical-align: top;
    cursor: pointer;
    background-color: none;
    border: 0px solid 
    #c8c8c8;
    border-radius: 3px;
    color: #c8c8c8;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
}

div[data-toggle="buttons"] label:hover {
color: #7AA3CC;
}

div[data-toggle="buttons"] label:active, div[data-toggle="buttons"] label.active {
-webkit-box-shadow: none;
box-shadow: none;
}

.label-info {
    background-color: #FFFF00;
    color:#000000;
}

.label-warning {
    background-color: #FF9900;
}




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

input[type="radio"] {
  margin-top: -50%;
  vertical-align: middle;
}

input {
    display: table-cell;
    vertical-align: middle
}
</style>

<?php echo $title; ?>

<table id="md_table" class="table table-striped table-bordered table-hover" style="width:100%">
    <thead>
        <tr>            
            <th colspan="5">               
            <div id="add_rows">
                <span id="md_field_citizen_add" class="add btn btn-primary fbutton"><i class="glyphicon glyphicon-plus-sign"></i> Add Row (Total :<span id="counter">0</span>)</span>                         
                <span id="btnDelTradesperson" class="add btn btn-default fbutton-delete"><i class="glyphicon glyphicon-minus-sign"></i> Delete Row <span id="counter-del">0</span></span>
            </div>

            </th>
            <th colspan="10">
                <h4><span class="label label-default" id="total_performance">Score : 0.00</span></h4>
            </th>            
        </tr>
            <tr>
                <th rowspan="3" width="2%">ID</th>                
                <th rowspan="3" width="20%"><div align="center">Area Kerja</div></th>
                <th rowspan="3" width="20%"><div align="center">Target Kerja</div></th>
                <th rowspan="3" width="3%" align="center" valign="middle"><div align="center">Bobot</div></th>
                <th rowspan="3" width="25%"><div align="center">Hasil yang Dicapai</div></th>
                <th colspan="10"><div align="center">Kategori Penilaian</div></th>
                
            </tr>
            <tr>                
                <th colspan="3" bgcolor="#00FF00"><div align="center">Baik</div></th>
                <th colspan="3" bgcolor="#FFFF00"><div align="center">Cukup</div></th>
                <th colspan="4" bgcolor="#FF9900"><div align="center">Kurang</div></th>
            </tr>
            <tr>
                <th width="3%" bgcolor="#00FF00"><div align="center">10</div></th>
                <th width="3%" bgcolor="#00FF00"><div align="center">9</div></th>
                <th width="3%" bgcolor="#00FF00"><div align="center">8</div></th>
                <th width="3%" bgcolor="#FFFF00"><div align="center">7</div></th>
                <th width="3%" bgcolor="#FFFF00"><div align="center">6</div></th>
                <th width="3%" bgcolor="#FFFF00"><div align="center">5</div></th>
                <th width="3%" bgcolor="#FF9900"><div align="center">4</div></th>
                <th width="3%" bgcolor="#FF9900"><div align="center">3</div></th>
                <th width="3%" bgcolor="#FF9900"><div align="center">2</div></th>
                <th width="3%" bgcolor="#FF9900"><div align="center">1</div></th>
                
            </tr>
            </thead>
            <tbody>
                <tr class="md_field_citizen_tr">                    
                    <input type="hidden" id="user" name="id" value="" class="id" />                  
                </tr>
        </table>




<script type="text/javascript"> 
  

function UpdateCostPerformance() {
      var sum10 = 0;
      var sum9 = 0;
      var sum8 = 0;
      var sum7 = 0;
      var sum6 = 0;
      var sum5 = 0;
      var sum4 = 0;
      var sum3 = 0;
      var sum2 = 0;
      var sum1 = 0;

      var bobot = <?php echo $this->development_model->kpi_weight($session_kpi=1);?>;
      var max_data = real;

      var subtotal;
      var total_performance;
      var grand_total;


      var gn, elem;




      for (i=1; i <= max_data; ++i) {

        gn = 'md_field_citizen_col_radio_performace_10'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum10 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_9'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum9 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_8'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum8 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_7'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum7 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_6'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum6 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_5'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum5 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_4'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum4 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_3'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum3 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_2'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum2 += Number(elem.value)* bobot/100; }

        gn = 'md_field_citizen_col_radio_performace_1'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum1 += Number(elem.value)* bobot/100; }


      }



    subtotal = (sum10+sum9+sum8+sum7+sum6+sum5+sum4+sum3+sum2+sum1) / max_data;
    total_performance = subtotal.toFixed(2);

    if ( total_performance >= 4.40 ){
        document.getElementById("total_performance").className = "label label-success";
        var status = 'Baik';
    }
    else if (total_performance < 4.40 && total_performance >=2.75){
        document.getElementById("total_performance").className = "label label-info";
        var status = 'Cukup';
    }
    else {
        document.getElementById("total_performance").className = "label label-warning";
        var status = 'Kurang';
    }    



    document.getElementById('total_performance').value = total_performance;
    document.getElementById('total_performance').innerHTML = 'Score : '+total_performance+' ('+status+')'; //NOW WORKS
    document.getElementById('total_performance_result').innerHTML = total_performance;
     
    document.getElementById('total_time_result').value = <?php echo $this->development_model->calculate_rata_rata_time($session_nik,$periode); ?>; 
    var sum_total_attitude = Number(document.getElementById('total_attitude').value);
    var sum_total_performance = Number(document.getElementById('total_performance').value);
    var sum_total_time = Number(document.getElementById('total_time_result').value);

    var grand_total_kpi = (sum_total_attitude+sum_total_performance+sum_total_time);

    var grand_total = grand_total_kpi.toFixed(2);
    document.getElementById('grand_total_kpi_result').innerHTML = grand_total;

    if (grand_total >=8.00){
        document.getElementById('pointA').innerHTML = '<span class="glyphicon glyphicon-ok"></span>';
        document.getElementById('pointB').innerHTML = '';
        document.getElementById('pointC').innerHTML = '';
    }
    else if(grand_total < 8.00 && grand_total >=5.00){
        document.getElementById('pointA').innerHTML = '';
        document.getElementById('pointB').innerHTML = '<span class="glyphicon glyphicon-ok"></span>';
        document.getElementById('pointC').innerHTML = '';
    }
    else if(grand_total <=4){
        document.getElementById('pointA').innerHTML = '';
        document.getElementById('pointB').innerHTML = '';
        document.getElementById('pointC').innerHTML = '<span class="glyphicon glyphicon-ok"></span>';
    }

    else{
       
    }

    if ( grand_total >= 8.00 ){
        document.getElementById("head_total_score").className = "label label-success";
        var status_head = 'Baik';
    }
    else if (grand_total < 8.00 && grand_total >=5.00){
        document.getElementById("head_total_score").className = "label label-info";
        var status_head = 'Cukup';
    }
    else {
        document.getElementById("head_total_score").className = "label label-warning";
        var status_head = 'Kurang';
    }    



    document.getElementById('head_total_score').innerHTML = 'TOTAL NILAI : '+grand_total+' ('+status_head+')';

    var grand_total_abs = grand_total_kpi.toFixed(0);

    for (tdi=1; i <= 10; ++tdi){

        if (grand_total_abs == tdi){
            document.getElementById('total_color_'+tdi).style.backgroundColor="#FFFF99";
            document.getElementById('total_color_'+tdi).className = "numberCircle";
        }else{
            document.getElementById('total_color_'+tdi).style.backgroundColor="";
            document.getElementById('total_color_'+tdi).className = "";
        }
    }



}

   

</script>

<script type="text/javascript">

$(document).ready(function() {
            var id = 0;

            
            // Add button functionality
            $("#md_table .fbutton").click(function() {

                id++;               

                count = $('#md_table tr').length;
                real = count-4;
                $('#counter').html(real);
                $('#counter-del').html(getGetOrdinal(n=real));

                if (real > 4) {
                    $('#md_field_citizen_add').attr('disabled', 'disabled');                   
                    
                } else {
                    $('#md_field_citizen_add').removeAttr('disabled');
                    
                }

                
                var master = $(this).parents("#md_table");
                
                // Get a new row based on the prototype row
                var prot = master.find(".md_field_citizen_tr").clone();
                prot.attr("class", id + " item")
                prot.find(".id").attr("value", id);       
        

                master.find("tbody").append(prot);


                var component = '<td>'+id+'</td>';
                    component += '<td><textarea style="width: 100%; height: 100px;" id="md_field_citizen_col_WorkExpPosition" class="md_field_citizen_col form-control"></textarea></td>';
                    component += '<td><textarea style="width: 100%; height: 100px;" id="md_field_citizen_col_WorkExpPosition" class="md_field_citizen_col form-control"></textarea></td>';
                    component += '<td><div align="center">20%</div></td>';
                    component += '<td><textarea style="width: 100%; height: 100px;" id="md_field_citizen_col_WorkExpPosition" class="md_field_citizen_col form-control"></textarea></td>';
                    component += '<td><div align="center"><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_10'+id+'" value="10" onclick="UpdateCostPerformance()"/><label for="md_field_citizen_col_radio_performace_10'+id+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
                    component += '<td><div align="center"><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_9'+id+'" value="9" onclick="UpdateCostPerformance()"/><label for="md_field_citizen_col_radio_performace_9'+id+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';    
                    component += '<td><div align="center"><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_8'+id+'" value="8" onclick="UpdateCostPerformance()"/><label for="md_field_citizen_col_radio_performace_8'+id+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
                    component += '<td><div align="center"><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_7'+id+'" value="7" onclick="UpdateCostPerformance()"/><label for="md_field_citizen_col_radio_performace_7'+id+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
                    component += '<td><div align="center"><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_6'+id+'" value="6" onclick="UpdateCostPerformance()"/><label for="md_field_citizen_col_radio_performace_6'+id+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
                    component += '<td><div align="center"><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_5'+id+'" value="5" onclick="UpdateCostPerformance()"/><label for="md_field_citizen_col_radio_performace_5'+id+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
                    component += '<td><div align="center"><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_4'+id+'" value="4" onclick="UpdateCostPerformance()"/><label for="md_field_citizen_col_radio_performace_4'+id+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
                    component += '<td><div align="center"><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_3'+id+'" value="3" onclick="UpdateCostPerformance()"/><label for="md_field_citizen_col_radio_performace_3'+id+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
                    component += '<td><div align="center"><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_2'+id+'" value="2" onclick="UpdateCostPerformance()"/><label for="md_field_citizen_col_radio_performace_2'+id+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
                    component += '<td><div align="center"><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_1'+id+'" value="1" onclick="UpdateCostPerformance()"/><label for="md_field_citizen_col_radio_performace_1'+id+'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
                    /*
                    component += '<td><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_10'+id+'" value="10" onclick="UpdateCostPerformance()"></td>';
                    component += '<td><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_9'+id+'" value="9" onclick="UpdateCostPerformance()"></td>';
                    component += '<td><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_8'+id+'" value="8" onclick="UpdateCostPerformance()"></td>';
                    component += '<td><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_7'+id+'" value="7" onclick="UpdateCostPerformance()"></td>';
                    component += '<td><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_6'+id+'" value="6" onclick="UpdateCostPerformance()"></td>';
                    component += '<td><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_5'+id+'" value="5" onclick="UpdateCostPerformance()"></td>';
                    component += '<td><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_4'+id+'" value="4" onclick="UpdateCostPerformance()"></td>';
                    component += '<td><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_3'+id+'" value="3" onclick="UpdateCostPerformance()"></td>';
                    component += '<td><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_2'+id+'" value="2" onclick="UpdateCostPerformance()"></td>';
                    component += '<td><input type="radio" name="radio_perf'+id+'" id="md_field_citizen_col_radio_performace_1'+id+'" value="1" onclick="UpdateCostPerformance()"></td>';

                    */
                
                prot.append(component);

                //prot.append('<td><span id="delete-rows" class="delete-icon btn btn-default md_field_citizen_delete"><i class="glyphicon glyphicon-minus-sign"></i></span>'+id_rows+'</td>');
                
              

                
            });
            
            // Remove button functionality
            $("#md_table .md_field_citizen_delete").live("click", function() {
                //$(this).closest('tr').remove();
                //$(this).parents("tr:last").remove();
                
                //$(this).find("td:last input").remove();

                //$(this).parents('tr').last().remove();
                //$('table#md_table tr#1').remove();
                recalcId();
                id--;
            });





            var $tbody = $("#md_table tbody")
                $("#btnDelTradesperson").click(function (){
                    var $last = $tbody.find('tr:last');


                    if($last.is(':first-child')){
                        //alert('No row to delete')
                        $('#md_field_citizen_add').attr('disabled', 'disabled');
                    }else {
                        
                        $last.remove();
                        recalcId();
                        id--;


                    }

                count = $('table tr.item').length;
                real = count;
                $('#counter').html(real);
                $('#counter-del').html(getGetOrdinal(n=real));

                if (real > 4) {
                    $('#md_field_citizen_add').attr('disabled', 'disabled');                    
                }
                 else {
                    $('#md_field_citizen_add').removeAttr('disabled');
                    
                }

                    
                }); 


        });

function recalcId(){
    $.each($("table tr.item"),function (i,el){
        $(this).find("td:first input").val(i + 1);

        

        count = $('table tr.item').length;
                real = count;
                $('#counter').html(real);
                $('#counter-del').html(getGetOrdinal(n=real));


    })



}

function getGetOrdinal(n) {
   var s=["th","st","nd","rd"],
       v=n%100;
   return n+(s[(v-20)%10]||s[v]||s[0]);
}


function remove_radio(i){   

        document.getElementById("md_field_citizen_col_radio_performace_10"+i).checked = false;
        document.getElementById("md_field_citizen_col_radio_performace_9"+i).checked = false;
        document.getElementById("md_field_citizen_col_radio_performace_8"+i).checked = false;
        document.getElementById("md_field_citizen_col_radio_performace_7"+i).checked = false;
        document.getElementById("md_field_citizen_col_radio_performace_6"+i).checked = false;
        document.getElementById("md_field_citizen_col_radio_performace_5"+i).checked = false;
        document.getElementById("md_field_citizen_col_radio_performace_4"+i).checked = false;
        document.getElementById("md_field_citizen_col_radio_performace_3"+i).checked = false;
        document.getElementById("md_field_citizen_col_radio_performace_2"+i).checked = false;
        document.getElementById("md_field_citizen_col_radio_performace_1"+i).checked = false;
 

}

</script>