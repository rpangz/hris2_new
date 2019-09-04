<style>

    <!-- Progress with steps -->

    ol.progtrckr {
        margin: 0;
        padding: 0;
        list-style-type none;
    }

    ol.progtrckr li {
        display: inline-block;
        text-align: center;
        line-height: 3em;
    }

    ol.progtrckr[data-progtrckr-steps="2"] li { width: 49%; }
    ol.progtrckr[data-progtrckr-steps="3"] li { width: 33%; }
    ol.progtrckr[data-progtrckr-steps="4"] li { width: 24%; }
    ol.progtrckr[data-progtrckr-steps="5"] li { width: 19%; }
    ol.progtrckr[data-progtrckr-steps="6"] li { width: 16%; }
    ol.progtrckr[data-progtrckr-steps="7"] li { width: 14%; }
    ol.progtrckr[data-progtrckr-steps="8"] li { width: 12%; }
    ol.progtrckr[data-progtrckr-steps="9"] li { width: 11%; }

    ol.progtrckr li.progtrckr-done {
        color: black;
        border-bottom: 4px solid yellowgreen;
    }
    ol.progtrckr li.progtrckr-todo {
        color: silver; 
        border-bottom: 4px solid silver;
    }
    ol.progtrckr li.progtrckr-void {
        color: silver; 
        border-bottom: 4px solid red;
    }

    ol.progtrckr li:after {
        content: "\00a0\00a0";
    }
    ol.progtrckr li:before {
        position: relative;
        bottom: -2.5em;
        float: left;
        left: 50%;
        line-height: 1em;
    }
    ol.progtrckr li.progtrckr-done:before {
        content: "\2713";
        color: white;
        background-color: yellowgreen;
        height: 1.2em;
        width: 1.2em;
        line-height: 1.2em;
        border: none;
        border-radius: 1.2em;
    }
    ol.progtrckr li.progtrckr-todo:before {
        content: "\039F";
        color: silver;
        background-color: white;
        font-size: 1.5em;
        bottom: -1.6em;
    }
    ol.progtrckr li.progtrckr-void:before {
        content: "\039F";
        color: silver;
        background-color: red;
        font-size: 1.5em;
        bottom: -1.6em;
    }


   


</style>


<style>
*,
*:before,
*:after {
  -webkit-box-sizing: border-box;
  -moz-box-sizing:    border-box;
  box-sizing:         border-box;
}



body,
button {
  font-family: "Helvetica Neue", Arial, sans-serif;

}

button {
  font-size: 100%;
}

a:hover {
  text-decoration: none;
}

header,
.content,
.content p {
  margin: 4em 0;
  text-align: center;
}

/**
 * Tooltips!
 */

/* Base styles for the element that has a tooltip */
[data-tooltip],
.tooltip {
  position: relative;
  cursor: pointer;

}

/* Base styles for the entire tooltip */
[data-tooltip]:before,
[data-tooltip]:after,
.tooltip:before,
.tooltip:after {
  position: absolute;
  visibility: hidden;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
  opacity: 0;
  -webkit-transition: 
      opacity 0.2s ease-in-out,
        visibility 0.2s ease-in-out,
        -webkit-transform 0.2s cubic-bezier(0.71, 1.7, 0.77, 1.24);
    -moz-transition:    
        opacity 0.2s ease-in-out,
        visibility 0.2s ease-in-out,
        -moz-transform 0.2s cubic-bezier(0.71, 1.7, 0.77, 1.24);
    transition:         
        opacity 0.2s ease-in-out,
        visibility 0.2s ease-in-out,
        transform 0.2s cubic-bezier(0.71, 1.7, 0.77, 1.24);
  -webkit-transform: translate3d(0, 0, 0);
  -moz-transform:    translate3d(0, 0, 0);
  transform:         translate3d(0, 0, 0);
  pointer-events: none;
}

/* Show the entire tooltip on hover and focus */
[data-tooltip]:hover:before,
[data-tooltip]:hover:after,
[data-tooltip]:focus:before,
[data-tooltip]:focus:after,
.tooltip:hover:before,
.tooltip:hover:after,
.tooltip:focus:before,
.tooltip:focus:after {
  visibility: visible;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
  filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=100);
  opacity: 1;
}

/* Base styles for the tooltip's directional arrow */
.tooltip:before,
[data-tooltip]:before {
  z-index: 1001;
  border: 6px solid transparent;
  background: transparent;
  content: "";
}

/* Base styles for the tooltip's content area */
.tooltip:after,
[data-tooltip]:after {
  z-index: 1000;
  padding: 8px;
  width: 220px;
  background-color: #000;
  background-color: hsla(0, 0%, 20%, 0.9);
  color: #fff;
  content: attr(data-tooltip);
  font-size: 11px;
  line-height: 1.2;
}

/* Directions */

/* Top (default) */
[data-tooltip]:before,
[data-tooltip]:after,
.tooltip:before,
.tooltip:after,
.tooltip-top:before,
.tooltip-top:after {
  bottom: 100%;
  left: 50%;
}

[data-tooltip]:before,
.tooltip:before,
.tooltip-top:before {
  margin-left: -6px;
  margin-bottom: -12px;
  border-top-color: #000;
  border-top-color: hsla(0, 0%, 20%, 0.9);
}

/* Horizontally align top/bottom tooltips */
[data-tooltip]:after,
.tooltip:after,
.tooltip-top:after {
  margin-left: -80px;
}

[data-tooltip]:hover:before,
[data-tooltip]:hover:after,
[data-tooltip]:focus:before,
[data-tooltip]:focus:after,
.tooltip:hover:before,
.tooltip:hover:after,
.tooltip:focus:before,
.tooltip:focus:after,
.tooltip-top:hover:before,
.tooltip-top:hover:after,
.tooltip-top:focus:before,
.tooltip-top:focus:after {
  -webkit-transform: translateY(-12px);
  -moz-transform:    translateY(-12px);
  transform:         translateY(-12px); 
}

/* Left */
.tooltip-left:before,
.tooltip-left:after {
  right: 100%;
  bottom: 50%;
  left: auto;
}

.tooltip-left:before {
  margin-left: 0;
  margin-right: -12px;
  margin-bottom: 0;
  border-top-color: transparent;
  border-left-color: #000;
  border-left-color: hsla(0, 0%, 20%, 0.9);
}

.tooltip-left:hover:before,
.tooltip-left:hover:after,
.tooltip-left:focus:before,
.tooltip-left:focus:after {
  -webkit-transform: translateX(-12px);
  -moz-transform:    translateX(-12px);
  transform:         translateX(-12px); 
}

/* Bottom */
.tooltip-bottom:before,
.tooltip-bottom:after {
  top: 100%;
  bottom: auto;
  left: 50%;
}

.tooltip-bottom:before {
  margin-top: -12px;
  margin-bottom: 0;
  border-top-color: transparent;
  border-bottom-color: #000;
  border-bottom-color: hsla(0, 0%, 20%, 0.9);
}

.tooltip-bottom:hover:before,
.tooltip-bottom:hover:after,
.tooltip-bottom:focus:before,
.tooltip-bottom:focus:after {
  -webkit-transform: translateY(12px);
  -moz-transform:    translateY(12px);
  transform:         translateY(12px); 
}

/* Right */
.tooltip-right:before,
.tooltip-right:after {
  bottom: 50%;
  left: 100%;
}

.tooltip-right:before {
  margin-bottom: 0;
  margin-left: -12px;
  border-top-color: transparent;
  border-right-color: #000;
  border-right-color: hsla(0, 0%, 20%, 0.9);
}

.tooltip-right:hover:before,
.tooltip-right:hover:after,
.tooltip-right:focus:before,
.tooltip-right:focus:after {
  -webkit-transform: translateX(12px);
  -moz-transform:    translateX(12px);
  transform:         translateX(12px); 
}

/* Move directional arrows down a bit for left/right tooltips */
.tooltip-left:before,
.tooltip-right:before {
  top: 3px;
}

/* Vertically center tooltip content for left/right tooltips */
.tooltip-left:after,
.tooltip-right:after {
  margin-left: 0;
  margin-bottom: -16px;
}

</style>


<STYLE>

#tfhover{
    border-collapse:collapse;
}
#tfhover tr {
    background-color:transparent;
}
#tfhover tr:hover td  {
  background-color:#FFFF33;
}
#tfhover tr td.link{
    background-color:transparent;
}

/* Bagian untuk tabel */    
table.tftable {
font-size:12px;
color:#333333;
border-width: 1px;
border-color:#000000;
border-collapse: collapse;

}

table.tftable th {
font-size:12px;
background-color:#CCCCCC;
border-width: 1px;
padding: 3px;
border-style: solid;
border-color: #999999;
text-align:center;

}
table.tftable tr {
background-color:#FFFFFF;
}
table.tftable td {
font-size:11px;
border-width: 1px;
padding: 2px;
border-style: solid;
border-color: #999999;
background-color:#FFFFFF;


}



</STYLE>



<?php

include "koneksi/koneksi.php";

switch($this->input->get('act')){

default:
?>


<?php

    $tampil = mysql_query("SELECT * FROM tbl_formcuti WHERE StatusForm ='P' ORDER BY CutiId DESC");    
    $total  = mysql_num_rows($tampil);

if ($total >0){

  echo"<table width='100%' id='tfhover' border='0' cellpadding='0' cellspacing='0'>

<tr>    
      <th colspan=2><div align='center'>No</div></th>
      <th colspan=2><div align='center'>Remark</div></th> 
      <th colspan=3><div align='center'>Approval Progress</div></th>
      
      </tr>";


   
$no =1;
while($data = mysql_fetch_array($tampil)){

    $dst1   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK =$data[NIK1]"));
    $dst2   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK =$data[NIK2]"));
    $dst3   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK =$data[NIK3]"));
    $dst4   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK =$data[FormCutiNIK]"));
    
    if ($data['Apv1'] =='A'){
        $class1 = 'progtrckr-done';
         $Tip1   = 'ACCEPTED';
         $Nama1  = 'By: '.$dst1['Nama'];
         $Tgl1  = '@'.date('d-M-Y H:i:s', strtotime($data['Tgl1'])).' WIB';
        $als1  = '';

    }
    elseif($data['Apv1'] =='P'){
        $class1 = 'progtrckr-todo';
        $Tip1    = 'PROCESS';
        $Nama1  = '';
        $Tgl1  = '';
        $als1  = '';
    }
    elseif($data['Apv1'] =='R'){
        $class1 = 'progtrckr-void';
        $Tip1    = 'REJECTED';
        $Nama1  = 'By: '.$dst1['Nama'];
        $Tgl1  = '@'.date('d-M-Y H:i', strtotime($data['Tgl1'])).' WIB';
        $als1  = 'Karena '.$data['AlasanApv'];
    }
    else {
        $class1 = 'progtrckr-todo';
        $Tip1    = '';
        $Nama1  = '';
        $Tgl1  = '';
        $als1  = '';
    }


    if ($data['Apv2'] =='A'){
        $class2 = 'progtrckr-done';
         $Tip2   = 'ACCEPTED';
         $Nama2  = 'By: '.$dst2['Nama'];
         $Tgl2  = '@'.date('d-M-Y H:i:s', strtotime($data['Tgl2'])).' WIB';
         $als2  = '';
    }
    elseif($data['Apv2'] =='P'){
        $class2 = 'progtrckr-todo';
        $Tip2    = 'PROCESS';
        $Nama2  = '';
        $Tgl2  = '';
        $als2  = '';
    }
    elseif($data['Apv2'] =='R'){
        $class2 = 'progtrckr-void';
        $Tip2    = 'REJECTED';
        $Nama2  = 'By: '.$dst2['Nama'];
        $Tgl2  = '@'.date('d-M-Y H:i', strtotime($data['Tgl2'])).' WIB';
        $als2  = 'Karena '.$data['AlasanApv'];
    }
    else {
        $class2 = 'progtrckr-todo';
        $Tip2    = '';
        $Nama2  = '';
        $Tgl2  = '';
        $als2  = '';
    }



    if ($data['Apv3'] =='A'){
        $class3 = 'progtrckr-done';
        $Tip3   = 'ACCEPTED';
        $Nama3  = 'By: '.$dst3['Nama'];
        $Tgl3  = '@'.date('d-M-Y H:i:s', strtotime($data['Tgl3'])).' WIB';
        $als3  = '';
    }
    elseif($data['Apv3'] =='P'){
        $class3 = 'progtrckr-todo';
        $Tip3    = 'PROCESS';
        $Nama3  = '';
        $Tgl3  = '';
        $als3  = '';
    }
    elseif($data['Apv3'] =='R'){
        $class3 = 'progtrckr-void';
        $Tip3    = 'REJECTED';
        $Nama3  = 'By: '.$dst3['Nama'];
        $Tgl3  = '@'.date('d-M-Y H:i', strtotime($data['Tgl3'])).' WIB';
        $als3  = 'Karena '.$data['AlasanApv'];
    }
    else {
        $class3 = 'progtrckr-todo';
        $Tip3    = '';
        $Nama3  = '';
        $Tgl3  = '';
        $als3  = '';
    }


    if ($data['StatusForm'] == 'A'){
        $bg = '#00FF00';
         
    }
    elseif ($data['StatusForm'] == 'R'){
        $bg = '#FF0000';
         
    }
    elseif ($data['StatusForm'] == 'X'){
        $bg = '#FF00FF';
         
    }    
    else {
        $bg = '';
           
    }



    if($data['StatusForm']=='A'){
        //$print ="<img style=border:0; src='../includes/images/print1.png' onmouseover=this.src='../includes/images/print2.png' onmouseout=this.src='../includes/images/print1.png' title='Print' alt='Print' width=15 height=15>";
        $print ="";
    }
    else{
        $print ="";
    }

    


	echo "<tr>
        <th bgcolor='$bg'> </th>
        <td>$no.</td>
	   <td bgcolor='' width=180><div align=left><a href='?act=detail&id=$data[CutiId]' class='tooltip-bottom' data-tooltip='$dst4[Nama] - $data[Keperluan] [";

     $detail = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId = $data[CutiId] ORDER BY TglCuti ASC");
     while($dta = mysql_fetch_array($detail)){
      $TglCuti = date('d-M-Y', strtotime($dta['TglCuti']));
        echo $TglCuti. ', ';

      }

     echo "]'>$dst4[Nama] - $data[Keperluan]</a></td>

	<td>     
        <a href='?act=print&id=$data[CutiId]'>$print</a>
  </td>
  <td>
			<ol class='progtrckr' data-progtrckr-steps='3'>
    			<li class='$class1'><a href='#' class='tooltip-bottom' data-tooltip='$Tip1 $als1 $Tgl1 $Nama1'>Atasan Langsung</a></li>
    			<li class='$class2'><a href='#' class='tooltip-bottom' data-tooltip='$Tip2  $als2 $Tgl2 $Nama2'>Atasan Lebih Tinggi</a></li>
    			<li class='$class3'><a href='#' class='tooltip-bottom' data-tooltip='$Tip3  $als3 $Tgl3 $Nama3'>HRD</a></li>
			</ol>
	</td>  
    
    </tr>";
	
$no++;
}

?>

</table>
  <br/>
    <br/>
  <br/>

<?PHP
}
else {
  echo "<i>No Progress Approval Cuti to show...</i>";
}

break;

case"detail":

    

  $edit = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId = '$_GET[id]'");
  $data = mysql_fetch_array($edit);

  $dst1   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id =$data[JenisCuti]"));
  $dst2   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_hakcuti WHERE HakId =$data[HakCutiId]"));

  $user   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK =$data[FormCutiNIK]"));
  $ganti  = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK =$data[NIKPengganti]"));

  $Periode1 = date('d-M-Y', strtotime($dst2['Periode1']));
  $Periode2 = date('d-M-Y', strtotime($dst2['Periode2']));

  if ($data['StatusForm'] == 'A'){
        $bg = '#00FF00';
        $st = 'ACCEPTED';
        $ck = 'DISABLED';
         
    }
    elseif ($data['StatusForm'] == 'R'){
        $bg = '#FF0000';
        $st = 'REJECTED'; 
        $ck = 'DISABLED';
    }
    elseif ($data['StatusForm'] == 'X'){
        $bg = '#FF00FF';
        $st = 'CANCELED'; 
        $ck = 'DISABLED';
         
    }    
    else {
        $bg = '';
        $st = 'PROCESS';
        $ck = ''; 
           
    } 
  
    echo "<form method=POST name='submit' action='?act=update&id=$_GET[id]' enctype='multipart/form-data'>
        <input type='hidden' name='id' value='$_GET[id]'>
        <table class='tftableon' border='0'>
        <tr>
          <td width=150>Periode Hak Cuti</td><td width=10>:</td><td>$Periode1 s/d $Periode2</td>
        </tr>
        <tr>
          <td width=150>NIK</td><td width=10>:</td><td>$data[FormCutiNIK]</td>
        </tr>
        <tr>
          <td width=150>Nama</td><td width=10>:</td><td>$user[Nama]</td>
        </tr>
        <tr>
          <td>Keperluan</td><td>:</td><td>$data[Keperluan]</td>
        </tr>
        <tr>
          <td>Alamat</td><td>:</td><td>$data[Alamat]</td>
        </tr>
        <tr>
          <td>Pengganti</td><td>:</td><td>$ganti[Nama]</td>
        </tr>
        <tr>
          <td>No Telpon</td><td>:</td><td>$data[NoTelpon]</td>
        </tr>
        <tr>
          <td>Jenis Cuti</td><td>:</td><td>$dst1[JenisCutiName]</td>
        </tr>
        <tr>
          <td>Tanggal Masuk</td><td>:</td><td>$data[TglMasuk]</td>
        </tr>";

  $detail = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId = $data[CutiId] ORDER BY TglCuti ASC");
  $total = mysql_num_rows($detail);

  echo"<tr>
          <td>Tanggal Cuti</td><td>:</td><td>

        ";
        $be= 1;
     while($dta = mysql_fetch_array($detail)){
      $TglCuti = date('d-M-Y', strtotime($dta['TglCuti']));
        
        //echo $TglCuti. ', ';
        echo "$be. $TglCuti<br/>";

        $be++;

      } 
  
    
  echo "</td></tr>
      <tr>
          <td>Jumlah Cuti</td><td>:</td><td>$total hari</td>
        </tr>

        <tr>
          <td>Status Form</td><td>:</td><td bgcolor='$bg'><b>$st</b></td>
        </tr>

        <tr>
          <td>Alasan</td><td>:</td><td>$data[Alasan] $data[AlasanApv]</td>
        </tr>

          
      

        
      </table>
<br/>
      <table>
        <tr>
        <td width='450'><input type='button' class='btn btn-default' value='&nbsp;&nbsp;&nbsp; Back &nbsp;&nbsp;' onclick=window.location.href='?'></td>
        <td  align='right'><input type='button' class='btn btn-default' value='&nbsp;&nbsp;&nbsp; Void &nbsp;&nbsp;' onclick=window.location.href='#openModal' $ck></td>

        </tr>
      </table>
      </form>

      ";       
break;




case "print":

  include "print.php";
  

break;


case "void":

    $sql    = "SELECT * FROM tbl_formcuti WHERE CutiId='$_GET[id]'";           
    $query  = mysql_query($sql);
    $data   = mysql_fetch_array($query);
    
  
  if ($data['StatusForm'] == 'R')
  {
    echo "<script language='javascript'>alert('Error!!! Form Sudah di Reject Sebelumnya');window.location ='?act=detail&id=$_GET[id]';</script>";
    //echo"<script language='javascript'>alert('Error!!! Kasbon tidak bisa di Void Karena sudah pernah di Reject atau Void');window.location ='module=$_GET[module]&act=detail&id=$_GET[id]&PRD=$_GET[PRD]';</script>";
  }
  elseif ($data['StatusForm'] == 'X')
  {
    echo "<script language='javascript'>alert('Error!!! Form Sudah pernah di Void');window.location ='?act=detail&id=$_GET[id]';</script>";
  }
  elseif ($data['StatusForm'] == 'A')
  {
    echo "<script language='javascript'>alert('Error!!! Form Sudah di Accept Sebelumnya');window.location ='module=$_GET[module]&act=detail&id=$_GET[id]&PRD=$_GET[PRD]';</script>";
  }
  
  else 
  {
    mysql_query("UPDATE tbl_formcuti SET StatusForm = 'X',
                   Alasan   = '$_POST[Alasan]' 
                   WHERE CutiId = '$_GET[id]'");
                   
    //include "SendMailVoid.php";
    include "http://$_SERVER[SERVER_NAME]/hris2/includes/mailer/frmCuti/SendMailVoid.php?id=$_GET[id]";
  
    echo"<script language='javascript'>alert('Form Anda sudah Berhasil di Void, Email sudah dikirim...');window.location ='?';</script>";               
  }


break;





}
?>

<script>
function goBack() {
    window.history.back()
}
</script>


<script type="text/javascript">

function validateComment(){
  var a=document.forms["formvoid"]["Alasan"].value;
  if (a==null || a==""){ alert("Alasan tidak boleh kosong"); document.formvoid.Alasan.focus() ; return false; }   
}
</script>






<style>
  .modalDialog {
    position: fixed;
    font-family: Arial, Helvetica, sans-serif;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgba(0,0,0,0.8);
    z-index: 99999;
    opacity:0;
    -webkit-transition: opacity 400ms ease-in;
    -moz-transition: opacity 400ms ease-in;
    transition: opacity 400ms ease-in;
    pointer-events: none;
  }

  .modalDialog:target {
    opacity:1;
    pointer-events: auto;
  }

  .modalDialog > div {
    width: 400px;
    position: relative;
    margin: 10% auto;
    padding: 5px 20px 13px 20px;
    border-radius: 10px;
    background: #fff;
    background: -moz-linear-gradient(#fff, #999);
    background: -webkit-linear-gradient(#fff, #999);
    background: -o-linear-gradient(#fff, #999);
  }

  .close {
    background: #606061;
    color: #FFFFFF;
    line-height: 25px;
    position: absolute;
    right: -12px;
    text-align: center;
    top: -10px;
    width: 24px;
    text-decoration: none;
    font-weight: bold;
    -webkit-border-radius: 12px;
    -moz-border-radius: 12px;
    border-radius: 12px;
    -moz-box-shadow: 1px 1px 3px #000;
    -webkit-box-shadow: 1px 1px 3px #000;
    box-shadow: 1px 1px 3px #000;
  }

  .close:hover { background: #00d9ff; }
  </style>


<div id="openModal" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <h4>Alasan Form di Void</h4>
    <?php echo"<form name='formvoid' id='formvoid' action='?act=void&id=$_GET[id]' onsubmit='return validateComment()' method='POST'>";?>
      <textarea name="Alasan" placeholder="* Harus diisi" style="width: 360px; height: 140px;"></textarea>    
        <input  type="submit" class="btn btn-primary" onclick="return validateComment" value="   Submit   ">          
     </form>    

  </div>
  
</div>





