 <link href="../themes/cerulean/assets/default/bootstrap.min.css" rel="stylesheet">
  

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

    ol.progtrckr[data-progtrckr-steps="2"] li { width: 45%; }
    ol.progtrckr[data-progtrckr-steps="3"] li { width: 30%; }
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

// FORM CUTI
$tampil = mysql_query("SELECT * FROM tbl_formcuti WHERE companyID ='".$company_id."' AND StatusForm ='P' ORDER BY CutiId DESC");    
$total  = mysql_num_rows($tampil);

if ($total >0){

echo'<div class="panel panel-default">
     <div class="panel-heading">           
       <i class="glyphicon glyphicon-briefcase"></i><strong> Form Cuti</strong>
     </div>
     <div class="panel-body">
     <table width="100%" id="tfhover" border="0" cellpadding="0" cellspacing="0">
     <tr>    
       <th colspan="2" width="5%"><div align="center">No</div></th>
       <th colspan="1" width="25%"><div align="center">Remark</div></th> 
       <th colspan="3" width="70%"><div align="center">Approval Progress</div></th>      
     </tr>';

$no =1;
while($data = mysql_fetch_array($tampil)){

echo'<tr>
     <th bgcolor="'.status_form_bg($data['StatusForm']).'"></th>
     <td>'.$no.'.</td>
	   <td bgcolor="" width="180">
     <div align=left>
     <a href="?act=detail_cuti&id='.$data['CutiId'].'" class="tooltip-bottom" data-tooltip="'.name_user($data['FormCutiNIK']).' - '.$data['Keperluan'].' [';
     $detail = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId='".$data['CutiId']."' ORDER BY TglCuti ASC");
     while($dta = mysql_fetch_array($detail)){
      $TglCuti = date('d-M-Y', strtotime($dta['TglCuti']));        
        echo $TglCuti. ', ';
      }
echo ']">'.$data['Keperluan'].'<br/>'.'['.name_user($data['FormCutiNIK']).']</a></td>
    <td>
			<ol class="progtrckr" data-progtrckr-steps="3">
    			<li class="'.tooltip_class ($value=1,$table='tbl_formcuti',$primary_column='CutiId',$data['CutiId']).'"><a href="#" class="tooltip-bottom" data-tooltip="'.tooltip_text ($data['Apv1'],$data['NIK1'],$table='tbl_formcuti',$primary_column='CutiId',$data['CutiId'],$process=1).'">Verifikator (HRD)</a></li>
    			<li class="'.tooltip_class ($value=2,$table='tbl_formcuti',$primary_column='CutiId',$data['CutiId']).'"><a href="#" class="tooltip-bottom" data-tooltip="'.tooltip_text ($data['Apv2'],$data['NIK2'],$table='tbl_formcuti',$primary_column='CutiId',$data['CutiId'],$process=2).'">Atasan Langsung</a></li>
    			<li class="'.tooltip_class ($value=3,$table='tbl_formcuti',$primary_column='CutiId',$data['CutiId']).'"><a href="#" class="tooltip-bottom" data-tooltip="'.tooltip_text ($data['Apv3'],$data['NIK3'],$table='tbl_formcuti',$primary_column='CutiId',$data['CutiId'],$process=3).'">Atasan Lebih Tinggi</a></li>
			</ol>
  	</td>  
    </tr>';	
$no++;

}

echo '</table></div></div><br/>';

}
// END OF FORM CUTI


// FORM IJIN
$tampil = mysql_query("SELECT * FROM tbl_formijin WHERE companyID ='".$company_id."' AND StatusForm ='P' ORDER BY IjinId DESC");    
$total  = mysql_num_rows($tampil);

if ($total >0){

echo'<div class="panel panel-default">
     <div class="panel-heading">           
       <i class="glyphicon glyphicon-pushpin"></i><strong> Form Ijin</strong>
     </div>
     <div class="panel-body">
     <table width="100%" id="tfhover" border="0" cellpadding="0" cellspacing="0">
     <tr>    
       <th colspan="2" width="5%"><div align="center">No</div></th>
       <th colspan="1" width="25%"><div align="center">Remark</div></th> 
       <th colspan="3" width="70%"><div align="center">Approval Progress</div></th>      
     </tr>';
   
$no =1;
while($data = mysql_fetch_array($tampil)){

echo'<tr>
     <th bgcolor="'.status_form_bg($data['StatusForm']).'"></th>
     <td>'.$no.'.</td>
     <td bgcolor="" width="180">
     <div align=left>
     <a href="?act=detail_ijin&id='.$data['IjinId'].'" class="tooltip-bottom" data-tooltip="'.name_user($data['NIK']).' - '.$data['Alasan'].'';
echo '">'.$data['Alasan'].'<br/>'.'['.name_user($data['NIK']).']</a></td>    
    <td>
      <ol class="progtrckr" data-progtrckr-steps="2">
          <li class="'.tooltip_class ($value=1,$table='tbl_formijin',$primary_column='IjinId',$data['IjinId']).'"><a href="#" class="tooltip-bottom" data-tooltip="'.tooltip_text ($data['Apv1'],$data['NIK1'],$table='tbl_formijin',$primary_column='IjinId',$data['IjinId'],$process=1).'">Atasan Langsung</a></li>
          <li class="'.tooltip_class ($value=2,$table='tbl_formijin',$primary_column='IjinId',$data['IjinId']).'"><a href="#" class="tooltip-bottom" data-tooltip="'.tooltip_text ($data['Apv2'],$data['NIK2'],$table='tbl_formijin',$primary_column='IjinId',$data['IjinId'],$process=2).'">HRD</a></li>
      </ol>
    </td>  
    </tr>'; 
$no++;

}

echo '</table></div></div><br/>';

}
// END OF FORM IJIN


// FORM PERP SISA CUTI
$tampil = mysql_query("SELECT * FROM tbl_formperpcuti WHERE companyID ='".$company_id."' AND StatusForm ='P' ORDER BY FormPerpCutiId ASC");    
$total  = mysql_num_rows($tampil);

if ($total >0){

echo'<div class="panel panel-default">
     <div class="panel-heading">           
       <i class="glyphicon glyphicon-leaf"></i><strong> Form Perpanjangan Sisa Cuti</strong>
     </div>
     <div class="panel-body">
     <table width="100%" id="tfhover" border="0" cellpadding="0" cellspacing="0">
     <tr>    
       <th colspan="2" width="5%"><div align="center">No</div></th>
       <th colspan="1" width="25%"><div align="center">Remark</div></th> 
       <th colspan="3" width="70%"><div align="center">Approval Progress</div></th>      
     </tr>';
   
$no =1;
while($data = mysql_fetch_array($tampil)){

echo'<tr>
     <th bgcolor="'.status_form_bg($data['StatusForm']).'"></th>
     <td>'.$no.'.</td>
     <td bgcolor="" width="180">
     <div align=left>
     <a href="?act=detail_sisa&id='.$data['FormPerpCutiId'].'" class="tooltip-bottom" data-tooltip="'.name_user($data['NIK']).' : '.periode_cuti($data['HakCutiId']).'';
echo '">'.periode_cuti($data['HakCutiId']).'<br/>'.'['.name_user($data['NIK']).']</a></td>    
    <td>
      <ol class="progtrckr" data-progtrckr-steps="2">
          <li class="'.tooltip_class ($value=1,$table='tbl_formperpcuti',$primary_column='FormPerpCutiId',$data['FormPerpCutiId']).'"><a href="#" class="tooltip-bottom" data-tooltip="'.tooltip_text ($data['Apv1'],$data['NIK1'],$table='tbl_formperpcuti',$primary_column='FormPerpCutiId',$data['FormPerpCutiId'],$process=1).'">Atasan Langsung</a></li>
          <li class="'.tooltip_class ($value=2,$table='tbl_formperpcuti',$primary_column='FormPerpCutiId',$data['FormPerpCutiId']).'"><a href="#" class="tooltip-bottom" data-tooltip="'.tooltip_text ($data['Apv2'],$data['NIK2'],$table='tbl_formperpcuti',$primary_column='FormPerpCutiId',$data['FormPerpCutiId'],$process=2).'">HRD</a></li>
      </ol>
    </td>  
    </tr>'; 
$no++;

}

echo '</table></div></div><br/>';

}
// END OF FORM PERP SISA CUTI


// FORM MY CV
//$tampil = mysql_query("SELECT * FROM tbl_profile_process WHERE companyID ='".$company_id."' AND ProcessStatusForm ='P' ORDER BY ProcessId ASC");

$tampil = mysql_query("select a1.* from tbl_profile_process a1 inner join (select max(ProcessId) as max from tbl_profile_process group by ProcessNIK) a2 on a1.ProcessId = a2.max WHERE ProcessStatusForm='P' AND companyId='".$company_id."'");



$total  = mysql_num_rows($tampil);

if ($total >0){

echo'<div class="panel panel-default">
     <div class="panel-heading">           
       <i class="glyphicon glyphicon-file"></i><strong> Form My CV</strong>
     </div>
     <div class="panel-body">
     <table width="100%" id="tfhover" border="0" cellpadding="0" cellspacing="0">
     <tr>    
       <th colspan="2" width="5%"><div align="center">No</div></th>
       <th colspan="1" width="25%"><div align="center">Remark</div></th> 
       <th colspan="3" width="70%"><div align="center">Approval Progress</div></th>      
     </tr>';
   
$no =1;
while($data = mysql_fetch_array($tampil)){

echo'<tr>
     <th bgcolor="'.status_form_bg($data['ProcessStatusForm']).'"></th>
     <td>'.$no.'.</td>
     <td bgcolor="" width="180">
     <div align=left>
     <a href="http://'.$_SERVER['SERVER_NAME'].'/hris2/karyawan/frmMyCV/index/edit/'.$data['ProcessNIK'].'/?state=last_update&id='.$data['ProcessId'].'" class="tooltip-bottom" data-tooltip="'.$data['ProcessNIK'].'  '.name_user($data['ProcessNIK']).'';
echo '">'.name_user($data['ProcessNIK']).'<br/>'.'['.$data['ProcessNIK'].']</a></td>    
    <td>
      <ol class="progtrckr" data-progtrckr-steps="2">
          <li class="'.tooltip_class_cv ($value=1,$table='tbl_profile_process',$primary_column='ProcessId',$data['ProcessId']).'"><a href="#" class="tooltip-bottom" data-tooltip="'.tooltip_text_cv ($data['ProcessApv1'],$data['ProcessNIK1'],$table='tbl_profile_process',$primary_column='ProcessId',$data['ProcessId'],$process=1).'">Atasan Langsung</a></li>
          <li class="'.tooltip_class_cv ($value=2,$table='tbl_profile_process',$primary_column='ProcessId',$data['ProcessId']).'"><a href="#" class="tooltip-bottom" data-tooltip="'.tooltip_text_cv ($data['ProcessApv2'],$data['ProcessNIK2'],$table='tbl_profile_process',$primary_column='ProcessId',$data['ProcessId'],$process=2).'">HRD</a></li>
      </ol>
    </td>  
    </tr>'; 
$no++;

}

echo '</table></div></div><br/>';

}
// END OF FORM MY CV

break;

case"detail_cuti":


  $edit = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId='".$_GET['id']."'");
  $data = mysql_fetch_array($edit);

  $dst1   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id =$data[JenisCuti]"));
  $dst2   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_hakcuti WHERE HakId =$data[HakCutiId]"));


  $Periode1 = date('d-M-Y', strtotime($dst2['Periode1']));
  $Periode2 = date('d-M-Y', strtotime($dst2['Periode2']));

  $last_apv = 'NIK'.$data['ApvLevel'];
  $last_nik = $data[$last_apv];

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
  
  echo '<form method="POST" name="submit" action="?act=update&id=$_GET[id]" enctype="multipart/form-data">
        <input type="hidden" name="id" value="'.$_GET['id'].'">
        <table class="table table-striped" border="0">        
        <tr>
          <td width=150>NIK</td><td width=10>:</td><td>'.$data['FormCutiNIK'].'</td>
        </tr>
        <tr>
          <td width=150>Nama</td><td width=10>:</td><td>'.name_user($data['FormCutiNIK']).'</td>
        </tr>
        <tr>
          <td>Keperluan</td><td>:</td><td>'.$data['Keperluan'].'</td>
        </tr>
        <tr>
          <td>Alamat</td><td>:</td><td>'.$data['Alamat'].'</td>
        </tr>
        <tr>
          <td>Pengganti</td><td>:</td><td>'.name_user_pengganti($data['NIKPengganti']).'</td>
        </tr>
        <tr>
          <td>No Telpon</td><td>:</td><td>'.$data['NoTelpon'].'</td>
        </tr>
        <tr>
          <td>Jenis Cuti</td><td>:</td><td>'.jenis_cuti($data['JenisCuti']).'</td>
        </tr>
        <tr>
          <td>Tanggal Masuk</td><td>:</td><td><strong>'.date_format_id($data['TglMasuk']).'</strong></td>
        </tr>';

  $detail = mysql_query("SELECT * FROM tbl_formcutidetail WHERE CutiId ='".$data['CutiId']."' ORDER BY TglCuti ASC");
  $total = mysql_num_rows($detail);

  echo'<tr>
          <td>Tanggal Cuti</td><td>:</td><td>';

     $be= 1;
     while($dta = mysql_fetch_array($detail)){
      $TglCuti = date('d-M-Y', strtotime($dta['TglCuti']));
        echo $be.'. '.$TglCuti.'<br/>';

        $be++;

      } 
  
    
  echo '</td></tr>
        <tr>
          <td>Jumlah Cuti</td><td>:</td><td>'.$total.' hari</td>
        </tr>
        <tr>
          <td>Status Form</td><td>:</td><td bgcolor='.$bg.'><b>'.$st.'</b></td>
        </tr>
        <tr>
          <td>Alasan</td><td>:</td><td>'.$data['Alasan'].' '.$data['AlasanApv'].'</td>
        </tr>';

$apv = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode = 1 ORDER BY MatProses ASC");

   while($dwa = mysql_fetch_array($apv)){
    $txt_nik = 'NIK'.$dwa['MatProses'];
    $txt_apv = 'Apv'.$dwa['MatProses'];
    $txt_tgl = 'Tgl'.$dwa['MatProses'];

    $apv_nik = $data[$txt_nik];
    $apv_apv = $data[$txt_apv];
    $apv_tgl = $data[$txt_tgl];

    if ($apv_apv == 'A'){
         $Tip1   = ' - ACCEPTED';
         $Tgl1  = ', @'.date('d-M-Y H:i', strtotime($apv_tgl)).' WIB';
         $als1  = '';

    }
    elseif($apv_apv =='P'){
        
        $Tip1    = ' - PROCESS';       
        $Tgl1  = '';
        $als1  = '';
    }
    elseif($apv_apv =='R'){
        
        $Tip1  = ' - REJECTED';
        $Tgl1  = ', @'.date('d-M-Y H:i', strtotime($apv_tgl)).' WIB';
        $als1  = 'Karena '.$data['AlasanApv'];
    }
    else {
       
        $Tip1    = '';      
        $Tgl1  = '';
        $als1  = '';
    }



      $user_apv   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK =$apv_nik"));
        echo '<tr>
          <td>'.$dwa['MatName'].'</td><td>:</td><td>'.$user_apv['Nama'].$Tgl1.$Tip1.'</td>
        </tr>';

      }        
      echo '</table>
      <br/>
      <table>
        <tr>        
        <td width="50%"><input type="button" class="btn btn-primary" value="&nbsp;&nbsp;&nbsp; Back &nbsp;&nbsp;" onclick=window.location.href="?"></td>
        <td width="30%"><input type="button" class="btn btn-default" value="&nbsp;&nbsp;&nbsp; Void &nbsp;&nbsp;" onclick=window.location.href="#openModal" $ck></td>
        <td align="right"><input type="button" class="btn btn-default" value="Send Email Approval to ['.next_approval_email($last_nik).']" onclick=window.open("http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/mailer/frmListCuti/ApprovalEmail.php?id='.$_GET['id'].'","_blank")></td>
        </tr>
      </table>
      </form>';

break;

case "detail_ijin":

  $edit = mysql_query("SELECT * FROM tbl_formijin WHERE IjinId = '".$_GET['id']."'");
  $data = mysql_fetch_array($edit);
  $today    = date('Y-m-d');

  $last_apv = 'NIK'.$data['ApvLevel'];
  $last_nik = $data[$last_apv];
  

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
  
  echo '<form method=POST name="submit" action="?act=update_ijin&id='.$_GET['id'].'" enctype="multipart/form-data">
        <input type="hidden" name="id" value="'.$_GET['id'].'">
        <table class="table table-striped" border="0">
       
        <tr>
          <td width=150>NIK</td><td width=10>:</td><td>'.$data['NIK'].'</td>
        </tr>
        <tr>
          <td width=150>Nama</td><td width=10>:</td><td>'.name_user($data['NIK']).'</td>
        </tr>
        <tr>
          <td>Keperluan</td><td>:</td><td>'.$data['Alasan'].'</td>
        </tr>
        <tr>
          <td>Jenis Ijin</td><td>:</td><td>'.jenis_ijin($data['JenisIjin']).'</td>
        </tr>
        <tr>
          <td>Tanggal / Pukul</td><td>:</td><td>'.date_format_id($data['TglActive1']).'</td>
        </tr>
        <tr>
          <td>Status Form</td><td>:</td><td bgcolor='.$bg.'><b>'.$st.'</b></td>
        </tr>';

$apv = mysql_query("SELECT * FROM tbl_apv_matrik_approval WHERE MatCode = 4 ORDER BY MatProses ASC");

   while($dwa = mysql_fetch_array($apv)){
    $txt_nik = 'NIK'.$dwa['MatProses'];
    $txt_apv = 'Apv'.$dwa['MatProses'];
    $txt_tgl = 'Tgl'.$dwa['MatProses'];

    $apv_nik = $data[$txt_nik];
    $apv_apv = $data[$txt_apv];
    $apv_tgl = $data[$txt_tgl];

    if ($apv_apv == 'A'){
         $Tip1   = ' - ACCEPTED';
         $Tgl1  = ', @'.date('d-M-Y H:i', strtotime($apv_tgl)).' WIB';
         $als1  = '';
    }
    elseif($apv_apv =='P'){
        
        $Tip1    = ' - PROCESS';       
        $Tgl1  = '';
        $als1  = '';
    }
    elseif($apv_apv =='R'){        
        $Tip1  = ' - REJECTED';
        $Tgl1  = ', @'.date('d-M-Y H:i', strtotime($apv_tgl)).' WIB';
        $als1  = 'Karena '.$data['AlasanApv'];
    }
    else {       
        $Tip1    = '';      
        $Tgl1  = '';
        $als1  = '';
    }



      $user_apv   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK =$apv_nik"));

        echo '<tr>
          <td>'.$dwa['MatName'].'</td><td>:</td><td>'.$user_apv['Nama'].$Tgl1.$Tip1.'</td>
        </tr>';

      }          
      

        
echo '</table>
<br/>
      <table>
        <tr>
        <td width="50%"><input type="button" class="btn btn-primary" value="&nbsp;&nbsp;&nbsp; Back &nbsp;&nbsp;" onclick=window.location.href="?"></td>
        <td width="30%"><input type="button" class="btn btn-default" value="&nbsp;&nbsp;&nbsp; Void &nbsp;&nbsp;" onclick=window.location.href="#openModal_ijin" '.$ck.'></td>
        <td align="right"><input type="button" class="btn btn-default" value="Send Email Approval to ['.next_approval_email($last_nik).']" onclick=window.open("http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/mailer/frmListFormIjin/ApprovalEmail.php?id='.$_GET['id'].'","_blank")></td>
        </tr>
      </table>
      </form>';

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
    mysql_query("UPDATE tbl_formcuti SET StatusForm = 'X',Alasan='$_POST[Alasan]' WHERE CutiId = '$_GET[id]'");
                  
    include "http://$_SERVER[SERVER_NAME]/hris2/includes/mailer/frmCuti/SendMailVoid.php?id=$_GET[id]";
  
    echo"<script language='javascript'>alert('Form Anda sudah Berhasil di Void, Email sudah dikirim...');window.location ='?';</script>";               
  }


break;


case "void_ijin":

    $sql    = "SELECT * FROM tbl_formijin WHERE IjinId='".$_GET['id']."'";           
    $query  = mysql_query($sql);
    $data   = mysql_fetch_array($query);
    
  
  if ($data['StatusForm'] == 'R')
  {
    echo "<script language='javascript'>alert('Error!!! Form Sudah di Reject Sebelumnya');window.location ='?act=detail_ijin&id=$_GET[id]';</script>";
  }
  elseif ($data['StatusForm'] == 'X')
  {
    echo "<script language='javascript'>alert('Error!!! Form Sudah pernah di Void');window.location ='?act=detail_ijin&id=$_GET[id]';</script>";
  }
  elseif ($data['StatusForm'] == 'A')
  {
    echo "<script language='javascript'>alert('Error!!! Form Sudah di Accept Sebelumnya');window.location ='?act=detail_ijin&id=$_GET[id]';</script>";
  }
  
  else{    
    mysql_query("UPDATE tbl_formijin SET StatusForm = 'X',Alasan='$_POST[Alasan_Ijin]' WHERE IjinId = '$_GET[id]'");
                  
    include 'http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/mailer/frmIjin/SendMailVoid.php?id='.$_GET['id'];
  
    echo"<script language='javascript'>alert('Form Anda sudah Berhasil di Void, Email sudah dikirim...');window.location ='?';</script>";               
  }


break;



}

function date_format_id($value){

  if (is_null($value) || empty($value)){
    $foramt = '';
  }else{
    $foramt = date('d-M-Y H:i', strtotime($value));
  }

  return $foramt;

}

function jenis_cuti($value){

    $query  = mysql_query("SELECT * FROM tbl_jeniscuti WHERE id='$value'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    return $data['JenisCutiName'];

}

function next_approval_email($value){

    $query  = mysql_query("SELECT * FROM tbl_profile WHERE NIK='$value'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    return $data['Email'];

}

function last_nik_approval($value){

    $query  = mysql_query("SELECT * FROM tbl_profile WHERE NIK='$value'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    return $data['NIK'];

}




function color_td($value){
    if ($value %2==0){
        return '#F7F7F7';
    }
    else{
        return '';
    }
}

function tooltip_text ($value,$nik,$table,$primary_column,$primary_key,$process){

    $sql       = mysql_query('SELECT * FROM '.$table.' WHERE '.$primary_column.'="'.$primary_key.'" LIMIT 1');
    $total     = mysql_num_rows($sql);
    $data      = mysql_fetch_array($sql);

    $dst   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=$nik"));

    if ($value =='A'){
        $class = 'progtrckr-done';
        $Tip   = 'ACCEPTED';
        $Nama  = 'By: '.$dst['Nama'];
        $Tgl   = '@'.date('d-M-Y H:i', strtotime($data['Tgl'.$process])).' WIB';
        $als   = '';
    }
    elseif($value =='P'){
        $class = 'progtrckr-todo';
        $Tip   = 'PROCESS';
        $Nama  = 'By: '.$dst['Nama'];
        $Tgl   = '';
        $als   = '';
    }
    elseif($value =='R'){
        $class = 'progtrckr-void';
        $Tip   = 'REJECTED';
        $Nama  = 'By: '.$dst['Nama'];
        $Tgl   = '@'.date('d-M-Y H:i', strtotime($data['Tgl'.$process])).' WIB';
        $als   = 'Karena '.$data['AlasanApv'];
    }
    else {
        $class = 'progtrckr-todo';
        $Tip   = '';
        $Nama  = 'By: '.$dst['Nama'];
        $Tgl   = '';
        $als   = '';
    }

    return $Tip.' '.$als.' '.$Tgl.' '.$Nama;

}


function tooltip_text_cv ($value,$nik,$table,$primary_column,$primary_key,$process){

    $sql       = mysql_query('SELECT * FROM '.$table.' WHERE '.$primary_column.'="'.$primary_key.'" LIMIT 1');
    $total     = mysql_num_rows($sql);
    $data      = mysql_fetch_array($sql);

    $dst   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_profile WHERE NIK=$nik"));

    if ($value =='A'){
        $class = 'progtrckr-done';
        $Tip   = 'ACCEPTED';
        $Nama  = 'By: '.$dst['Nama'];
        $Tgl   = '@'.date('d-M-Y H:i', strtotime($data['ProcessDate'.$process])).' WIB';
        $als   = '';
    }
    elseif($value =='P'){
        $class = 'progtrckr-todo';
        $Tip   = 'PROCESS';
        $Nama  = 'By: '.$dst['Nama'];
        $Tgl   = '';
        $als   = '';
    }
    elseif($value =='R'){
        $class = 'progtrckr-void';
        $Tip   = 'REJECTED';
        $Nama  = 'By: '.$dst['Nama'];
        $Tgl   = '@'.date('d-M-Y H:i', strtotime($data['ProcessDate'.$process])).' WIB';
        $als   = 'Karena '.$data['PorcessAlasanApv'];
    }
    else {
        $class = 'progtrckr-todo';
        $Tip   = '';
        $Nama  = 'By: '.$dst['Nama'];
        $Tgl   = '';
        $als   = '';
    }

    return $Tip.' '.$als.' '.$Tgl.' '.$Nama;

}

function jenis_ijin($value){

    $sql       = mysql_query('SELECT * FROM tbl_jenisijin WHERE JenisIjinId="'.$value.'" LIMIT 1');
    $total     = mysql_num_rows($sql);
    $data      = mysql_fetch_array($sql);

    return $data['JenisIjinName'];

}

function periode_cuti($value){

    $sql       = mysql_query('SELECT * FROM tbl_hakcuti INNER JOIN tbl_jeniscuti ON tbl_jeniscuti.id=tbl_hakcuti.JenisHakCuti WHERE HakId='.$value);
    $total     = mysql_num_rows($sql);
    $data      = mysql_fetch_array($sql);

    $Periode1   = date('d-M-Y', strtotime($data['Periode1']));
    $Periode2   = date('d-M-Y', strtotime($data['Periode2']));

    if ($total >0){
      return $Periode1.' / '.$Periode2.' ['.$data['JenisCutiName'].']';
    }else{
      return '';
    }

}

function tooltip_class ($value,$table,$primary_column,$primary_key){

    $sql       = mysql_query('SELECT * FROM '.$table.' WHERE '.$primary_column.'="'.$primary_key.'" LIMIT 1');
    $total     = mysql_num_rows($sql);
    $data      = mysql_fetch_array($sql);


    if ($data['Apv'.$value] =='A'){
        $class = 'progtrckr-done';
    }
    elseif($data['Apv'.$value] =='P'){
        $class = 'progtrckr-todo';
    }
    elseif($data['Apv'.$value] =='R'){
        $class = 'progtrckr-void';
    }
    else {
        $class = 'progtrckr-todo';
    }

    return $class;

}


function tooltip_class_cv ($value,$table,$primary_column,$primary_key){

    $sql       = mysql_query('SELECT * FROM '.$table.' WHERE '.$primary_column.'="'.$primary_key.'" LIMIT 1');
    $total     = mysql_num_rows($sql);
    $data      = mysql_fetch_array($sql);


    if ($data['ProcessApv'.$value] =='A'){
        $class = 'progtrckr-done';
    }
    elseif($data['ProcessApv'.$value] =='P'){
        $class = 'progtrckr-todo';
    }
    elseif($data['ProcessApv'.$value] =='R'){
        $class = 'progtrckr-void';
    }
    else {
        $class = 'progtrckr-todo';
    }

    return $class;

}


function status_form($value){
    if($value=='A'){
      $print ="";
    }
    else{
      $print ="";
    }
    return $print;
}

function status_form_bg($value){

    if ($value == 'A'){
        return '#00FF00';         
    }
    elseif ($value == 'R'){
        return '#FF0000';         
    }
    elseif ($value == 'X'){
        return '#FF00FF';         
    }    
    else {
        return '';           
    }

}


function name_user($nik){

    $sql       = mysql_query('SELECT * FROM tbl_profile WHERE NIK="'.$nik.'" LIMIT 1');
    $total     = mysql_num_rows($sql);
    $data      = mysql_fetch_array($sql);

    if ($total >0){
      return $data['Nama'];
    }else{
      return '';
    }

}


function name_user_pengganti($nik){

    $sql       = mysql_query('SELECT * FROM tbl_profile WHERE NIK="'.$nik.'" LIMIT 1');
    $total     = mysql_num_rows($sql);
    $data      = mysql_fetch_array($sql);

    if ($total >0){
      return $data['Nama'];
    }else{
      return '';
    }

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

function validateComment_ijin(){
  var a=document.forms["formvoid_ijin"]["Alasan_Ijin"].value;
  if (a==null || a==""){ alert("Alasan tidak boleh kosong"); document.formvoid_ijin.Alasan_Ijin.focus() ; return false; }   
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
      <br/><br/>    
        <input  type="submit" class="btn btn-primary" onclick="return validateComment" value="   Submit   ">          
     </form>
  </div>
  
</div>

<div id="openModal_ijin" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <h4>Alasan Form di Void</h4>
    <?php echo"<form name='formvoid_ijin' id='formvoid_ijin' action='?act=void_ijin&id=$_GET[id]' onsubmit='return validateComment_ijin()' method='POST'>";?>
      <textarea name="Alasan_Ijin" placeholder="* Harus diisi" style="width: 360px; height: 140px;"></textarea>
      <br/><br/>    
        <input  type="submit" class="btn btn-primary" onclick="return validateComment_ijin" value="   Submit   ">          
     </form>
  </div>  
</div>





