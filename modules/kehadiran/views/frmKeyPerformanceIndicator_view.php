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


<form id="accountForm" method="post" class="form-horizontal">
<div class="bs-example">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#kinerja">KINERJA</a></li>
        <li><a data-toggle="tab" href="#sikap">SIKAP</a></li>
        <li><a data-toggle="tab" href="#waktu">WAKTU</a></li>       
    </ul>
    <div class="tab-content">
        <div id="kinerja" class="tab-pane fade in active">
          <h3>A. PENILAIAN KINERJA OPERASIONAL (Bobot : 55 %)</h3> 

          <input type="button" value="Add Row" onclick="addRow('dataTable')" />

          <input type="button" value="Delete Row" onclick="deleteRow('dataTable')" />

          <p/>
          <table cellspacing="1" cellpadding="0" style="width:100%;" class="tftableon" id="tfhover">
            <tr>
              <tr>
                <th rowspan="3" width="3%"><div align="center">#</div></th>
                <th rowspan="3" width="18%"><div align="center">Area Kerja</div></th>
                <th rowspan="3" width="18%"><div align="center">Target Kerja</div></th>
                <th rowspan="3" width="5%"><div align="center">Bobot</div></th>
                <th rowspan="3" width="26%"><div align="center">Hasil yang Dicapai</div></th>
                <th colspan="10"><div align="center">Kategori Penilaian</div></th>
              </tr>
              <tr>
               
                <th colspan="3"><div align="center">Baik</div></th>
                <th colspan="3"><div align="center">Cukup</div></th>
                <th colspan="4"><div align="center">Kurang</div></th>
              </tr>
              <tr>
               
                <th width="3%"><div align="center">10</div></th>
                <th width="3%"><div align="center">9</div></th>
                <th width="3%"><div align="center">8</div></th>
                <th width="3%"><div align="center">7</div></th>
                <th width="3%"><div align="center">6</div></th>
                <th width="3%"><div align="center">5</div></th>
                <th width="3%"><div align="center">4</div></th>
                <th width="3%"><div align="center">3</div></th>
                <th width="3%"><div align="center">2</div></th>
                <th width="3%"><div align="center">1</div></th>
              </tr>
          </table><br/>

          <table id="dataTable" border="1" cellspacing="1" cellpadding="0" style="width:100%;" class="tftableon">
            

            <tr>
              <td width="3%"><div align="center"><input type="checkbox" name="chk"/></div></td>
              <td width="18%"><textarea style="resize:none" name="Kerja" rows="4" ></textarea></td>
              <td width="18%"><textarea style="resize:none" name="Target" rows="4" ></textarea></td>
              <td width="5%"><div align="center">20%</div></td>
              <td width="26%"><textarea style="resize:none" name="Hasil" rows="4"></textarea></td>
             <td width="3%"><div align="center"><input id="radio1_1" name="radio1_1" type="radio"></div></td>
              <td width="3%"><div align="center"><input id="radio1_2" name="radio1_1" type="radio"></div></td>
              <td width="3%"><div align="center"><input id="radio1_3" name="radio1_1" type="radio"></div></td>
              <td width="3%"><div align="center"><input id="radio1_4" name="radio1_1" type="radio"></div></td>
              <td width="3%"><div align="center"><input id="radio1_5" name="radio1_1" type="radio"></div></td>
              <td width="3%"><div align="center"><input id="radio1_6" name="radio1_1" type="radio"></div></td>
              <td width="3%"><div align="center"><input id="radio1_7" name="radio1_1" type="radio"></div></td>
              <td width="3%"><div align="center"><input id="radio1_8" name="radio1_1" type="radio"></div></td>
              <td width="3%"><div align="center"><input id="radio1_9" name="radio1_1" type="radio"></div></td>
              <td width="3%"><div align="center"><input id="radio1_10" name="radio1_1" type="radio"></div></td>
            </tr>
          </table>



        </div>
        <div id="sikap" class="tab-pane fade">
          <h3>B. PENILAIAN SIKAP KERJA  (Bobot : 30 %)</h3>

          <table border="0" cellspacing="1" cellpadding="0" style="width:100%;" class="tftableon" id="tfhover">
       
        <tr height="40">
          <th colspan="13"><div align="left">Petunjuk : Bacalah pernyataan-pernyataan berikut ini dengan seksama dan berikan penilaian secara obyektif 
            dengan memberi tanda silang (X) pada pilihan yang sesuai.</div></th>
        </tr>
       
        <tr>
          <th rowspan="3" width="3%"><div align="center">No</div></th>
          <th rowspan="3" width="20%"><div align="center">Faktor</div></th>
          <th rowspan="3"><div align="center">Defenisi</div></th>
          <th colspan="10"><div align="center">Kategori Penilaian</div></th>
        </tr>
        <tr>
         
          <th colspan="3"><div align="center">Baik</div></th>
          <th colspan="3"><div align="center">Cukup</div></th>
          <th colspan="4"><div align="center">Kurang</div></th>
        </tr>
        <tr>
         
          <th width="3%"><div align="center">10</div></th>
          <th width="3%"><div align="center">9</div></th>
          <th width="3%"><div align="center">8</div></th>
          <th width="3%"><div align="center">7</div></th>
          <th width="3%"><div align="center">6</div></th>
          <th width="3%"><div align="center">5</div></th>
          <th width="3%"><div align="center">4</div></th>
          <th width="3%"><div align="center">3</div></th>
          <th width="3%"><div align="center">2</div></th>
          <th width="3%"><div align="center">1</div></th>
        </tr>

<?php
  
  $tampil = mysql_query("SELECT * FROM tbl_kpi_sikap WHERE SikapStatus=1");

  $no=1;
    while($data = mysql_fetch_array($tampil)){

      $radio_name = 'radio_group_'.$no;

     

?>






        <tr>
          <td><div align="center"><?php echo $no ?></div></td>
          <td><div align="center"><?php echo $data['SikapFaktor'] ?></div></td>
          <td><div align="center"><?php echo $data['SikapDefinisi'] ?></div></td>
          <td><div align="center"><input id="radio1_1" name="<?php echo $radio_name ?>" type="radio"></div></td>
          <td><div align="center"><input id="radio1_2" name="<?php echo $radio_name ?>" type="radio"></div></td>
          <td><div align="center"><input id="radio1_3" name="<?php echo $radio_name ?>" type="radio"></div></td>
          <td><div align="center"><input id="radio1_4" name="<?php echo $radio_name ?>" type="radio"></div></td>
          <td><div align="center"><input id="radio1_5" name="<?php echo $radio_name ?>" type="radio"></div></td>
          <td><div align="center"><input id="radio1_6" name="<?php echo $radio_name ?>" type="radio"></div></td>
          <td><div align="center"><input id="radio1_7" name="<?php echo $radio_name ?>" type="radio"></div></td>
          <td><div align="center"><input id="radio1_8" name="<?php echo $radio_name ?>" type="radio"></div></td>
          <td><div align="center"><input id="radio1_9" name="<?php echo $radio_name ?>" type="radio"></div></td>
          <td><div align="center"><input id="radio1_10" name="<?php echo $radio_name ?>" type="radio"></div></td>
        </tr>
    
<?php
    $no++;
    }
?>        
      </table>


        </div>

       <div id="waktu" class="tab-pane fade in active">
            <h3>D. PENILAIAN KEDISIPLINAN WAKTU - data dari HRD (Bobot : 10  %)</h3>
            <p>Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui. Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth.</p>
        </div>

        <div id="waktuku" class="tab-pane fade in active">
        </div>


    </div>
</div>
</form>





<style>

.container {
        
    }

textarea {
    border: none;
    width: 100%;
    -webkit-box-sizing: border-box; /* <=iOS4, <= Android  2.3 */
       -moz-box-sizing: border-box; /* FF1+ */
            box-sizing: border-box; /* Chrome, IE8, Opera, Safari 5.1*/
}

.buttonme {
display: block;
width: 115px;
height: 45px;
background: #4E9CAF;
padding: 10px;
text-align: center;
border-radius: 5px;
color: white;
font-weight: bold;
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
font-size:14px;
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
table.tabborder td {border-width:1px; padding:2px;	border-style:inset; 
     border-color: black;background-color:white;}
.bold8 {width:50px; font-size:9px; font-family:arial; text-align:center; 
     font-weight:bold;}
.pt8 {width:10px; font-size:9px; font-family:arial; text-align:center;}
.gaya {
	font-size: 11px;
	font-family: Arial;}





</style>



 <script type="text/javascript">

$(function(){
    
    $(".example_table").delegate('input', 'click', function(e){
        $(this).closest('table').find('td.checked input:not(:checked)').closest('td').removeClass('checked');
        if ($(this).is(':checked')) {
            $(this).closest('td').addClass('checked');
        }
    });
});



</script>

<style type="text/css">
.hover {
  background-color: #F9E9E9;
}

.checked {
  background-color: #00FF00;
}
</style>


<SCRIPT language="javascript">
    function addRow(tableID) {

      var table = document.getElementById(tableID);

      var rowCount = table.rows.length;
      var row = table.insertRow(rowCount);

      var colCount = table.rows[0].cells.length;

      for(var i=0; i<colCount; i++) {

        var newcell = row.insertCell(i);

        newcell.innerHTML = table.rows[0].cells[i].innerHTML;
        //alert(newcell.childNodes);
        switch(newcell.childNodes[0].type) {
          case "text":
              newcell.childNodes[0].value = "";
              break;
          case "checkbox":
              newcell.childNodes[0].checked = false;
              break;
          case "select-one":
              newcell.childNodes[0].selectedIndex = 0;
              break;
        }
      }
    }

    function deleteRow(tableID) {
      try {
      var table = document.getElementById(tableID);
      var rowCount = table.rows.length;

      for(var i=0; i<rowCount; i++) {
        var row = table.rows[i];
        var chkbox = row.cells[0].childNodes[0];
        if(null != chkbox && true == chkbox.checked) {
          if(rowCount <= 1) {
            alert("Cannot delete all the rows.");
            break;
          }
          table.deleteRow(i);
          rowCount--;
          i--;
        }


      }
      }catch(e) {
        alert(e);
      }
    }

  </SCRIPT>
