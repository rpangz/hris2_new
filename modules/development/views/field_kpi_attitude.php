<?php
    $record_index = 1;
    $this->load->model('development_model');

?>
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/font-awesome.css'); ?>" />

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


span.glyphicon-ok {
    font-size: 16px;
}


input[type="radio"] {
  margin-top: -1px;
  vertical-align: middle;
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

<?php echo $title; ?>

<table id="md_table_attitude" class="table table-striped table-bordered table-hover" style="width:100%">
    <thead>
        <tr>            
            <th colspan="3">               
            Petunjuk : Bacalah pernyataan-pernyataan berikut ini dengan seksama dan berikan penilaian secara obyektif 
            dengan memberi tanda (<input type="radio" id="sample" name="sample" />) pada pilihan yang sesuai.

            </th>
            <th colspan="10">
                <h4><span class="label label-default" id="total_attitude">Score : 0.00</span></h4>
            </th>            
        </tr>
            <tr>
                <th rowspan="3" width="2%">ID</th>                
                <th rowspan="3" width="20%"><div align="center">Faktor</div></th>
                <th rowspan="3" width="48%"><div align="center">Definisi</div></th>                
                <th colspan="10"><div align="center">Kategori Penilaian</div></th>
                
            </tr>
            <tr>                
                <th colspan="3" bgcolor="#00FF00"><div align="center">Baik</div></th>
                <th colspan="3" bgcolor="#FFFF00"><div align="center">Cukup</div></th>
                <th colspan="4" bgcolor="#FF9900"><div align="center">Kurang</div></th>
            </tr>
            <tr>
                <th width="2%" bgcolor="#00FF00"><div align="center">10</div></th>
                <th width="2%" bgcolor="#00FF00"><div align="center">9</div></th>
                <th width="2%" bgcolor="#00FF00"><div align="center">8</div></th>
                <th width="2%" bgcolor="#FFFF00"><div align="center">7</div></th>
                <th width="2%" bgcolor="#FFFF00"><div align="center">6</div></th>
                <th width="2%" bgcolor="#FFFF00"><div align="center">5</div></th>
                <th width="2%" bgcolor="#FF9900"><div align="center">4</div></th>
                <th width="2%" bgcolor="#FF9900"><div align="center">3</div></th>
                <th width="2%" bgcolor="#FF9900"><div align="center">2</div></th>
                <th width="2%" bgcolor="#FF9900"><div align="center">1</div></th>
                
            </tr>
            </thead>
            <tbody>                                   

<?php 


    $tampil = mysql_query("SELECT * FROM tbl_kpi_attitude WHERE attitude_status=1");
    $total  = mysql_num_rows($tampil);

    $no        = 1;
    $form_data = '';
    while($data = mysql_fetch_array($tampil)){

        $radio_name = 'radio_group_'.$no;
        $radio_id   = 'radio_'.$no;

        $form_data .= '<tr>';

        $form_data .= '<td><div align="center">'.$no.'</div></td>';
        $form_data .= '<td><div align="center">'.$data['attitude_factor'].'</div></td>';
        $form_data .= '<td><div align="left">'.$data['attitude_definition'].'</div></td>';
        $form_data .= '<td><div align="center"><input type="radio" name="'.$radio_name.'" id="10_'.$radio_id.'" value="10" onclick="UpdateCostAttitude()"/><label for="10_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
        $form_data .= '<td><div align="center"><input type="radio" name="'.$radio_name.'" id="9_'.$radio_id.'" value="9" onclick="UpdateCostAttitude()"/><label for="9_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
        $form_data .= '<td><div align="center"><input type="radio" name="'.$radio_name.'" id="8_'.$radio_id.'" value="8" onclick="UpdateCostAttitude()"/><label for="8_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
        $form_data .= '<td><div align="center"><input type="radio" name="'.$radio_name.'" id="7_'.$radio_id.'" value="7" onclick="UpdateCostAttitude()"/><label for="7_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
        $form_data .= '<td><div align="center"><input type="radio" name="'.$radio_name.'" id="6_'.$radio_id.'" value="6" onclick="UpdateCostAttitude()"/><label for="6_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
        $form_data .= '<td><div align="center"><input type="radio" name="'.$radio_name.'" id="5_'.$radio_id.'" value="5" onclick="UpdateCostAttitude()"/><label for="5_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
        $form_data .= '<td><div align="center"><input type="radio" name="'.$radio_name.'" id="4_'.$radio_id.'" value="4" onclick="UpdateCostAttitude()"/><label for="4_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
        $form_data .= '<td><div align="center"><input type="radio" name="'.$radio_name.'" id="3_'.$radio_id.'" value="3" onclick="UpdateCostAttitude()"/><label for="3_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
        $form_data .= '<td><div align="center"><input type="radio" name="'.$radio_name.'" id="2_'.$radio_id.'" value="2" onclick="UpdateCostAttitude()"/><label for="2_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
        $form_data .= '<td><div align="center"><input type="radio" name="'.$radio_name.'" id="1_'.$radio_id.'" value="1" onclick="UpdateCostAttitude()"/><label for="1_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>';
        $form_data .= '</tr>';

        $no++;
    }
        echo $form_data;

?>

                
        </table>




<script type="text/javascript"> 
  

function UpdateCostAttitude() {
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

      var bobot = <?php echo $this->development_model->kpi_weight($session_kpi=2);?>;
      var max_data = <?php echo $total ?>;

      var subtotal;
      var total_attitude;
      var grand_total;


      var gn, elem;




      for (i=1; i <= max_data; ++i) {

        gn = '10_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum10 += Number(elem.value)* bobot/100; }

        gn = '9_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum9 += Number(elem.value)* bobot/100; }

        gn = '8_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum8 += Number(elem.value)* bobot/100; }

        gn = '7_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum7 += Number(elem.value)* bobot/100; }

        gn = '6_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum6 += Number(elem.value)* bobot/100; }

        gn = '5_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum5 += Number(elem.value)* bobot/100; }

        gn = '4_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum4 += Number(elem.value)* bobot/100; }

        gn = '3_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum3 += Number(elem.value)* bobot/100; }

        gn = '2_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum2 += Number(elem.value)* bobot/100; }

        gn = '1_radio_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum1 += Number(elem.value)* bobot/100; }


      }



    subtotal = (sum10+sum9+sum8+sum7+sum6+sum5+sum4+sum3+sum2+sum1) / max_data;
    total_attitude = subtotal.toFixed(2);

    if ( total_attitude >= 2.40 ){
        document.getElementById("total_attitude").className = "label label-success";
        var status = 'Baik';
    }
    else if (total_attitude < 2.40 && total_attitude >=1.50){
        document.getElementById("total_attitude").className = "label label-info";
        var status = 'Cukup';
    }
    else {
        document.getElementById("total_attitude").className = "label label-warning";
        var status = 'Kurang';
    }    



    document.getElementById('total_attitude').value = total_attitude;
    document.getElementById('total_attitude').innerHTML = 'Score : '+total_attitude+' ('+status+')';
    document.getElementById('total_attitude_result').innerHTML = total_attitude;


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

function sum(){ 
    var fn, ln, result; 
    fn = parseInt(document.getElementById("n1").value, 10);
    ln = parseInt(document.getElementById("n2").value, 10);
    result =  (fn+ln); 
    document.getElementById("demo2").innerHTML = result; 
}


</script>