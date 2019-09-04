<script type="text/javascript">
function closeWin()
{
myWindow.close();
}
</script>

<script type="text/javascript">
function forceNumber(e) {
    var keyCode = e.keyCode ? e.keyCode : e.which;
    if((keyCode < 48 || keyCode > 58) && keyCode != 188) {
        return false;
    }
    return true;
}
function numberWithCommas(n){
    n = n.replace(/,/g, "");
    var s=n.split('.')[1];
    (s) ? s="."+s : s="";
    n=n.split('.')[0];
    while(n.length>3){
        s=","+n.substr(n.length-3,3)+s;
        n=n.substr(0,n.length-3)
    }
    return n+s;
}
</script>

<script type = "text/javascript">
function goToPage( id ) {
  var node = document.getElementById( id );  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>
<style>
a.tooltip {outline:none; }
a.tooltip strong {line-height:30px;}
a.tooltip:hover {text-decoration:none;} 
a.tooltip span {
    z-index:10;display:none; padding:14px 20px;
    margin-top:30px; margin-left:-160px;
    width:240px; line-height:14px;
}
a.tooltip:hover span{
    display:inline; position:absolute; 
    border:2px solid #FFF;  color:#EEE;
    background:#000 url(src/css-tooltip-gradient-bg.png) repeat-x 0 0;
}

.callout {z-index:20;position:absolute;border:0;top:-14px;left:120px;}

/*CSS3 extras*/
a.tooltip span
{
    border-radius:2px;
-moz-border-radius: 2px;
    -webkit-border-radius: 2px;
        
    -moz-box-shadow: 0px 0px 8px 4px #666;
    -webkit-box-shadow: 0px 0px 8px 4px #666;
box-shadow: 0px 0px 8px 4px #666;
opacity: 0.8;
}


a.tooltip2 {outline:none; }
a.tooltip2 strong {line-height:30px;}
a.tooltip2:hover {text-decoration:none;} 
a.tooltip2 span {
    z-index:10;display:none; padding:14px 20px;
    margin-top:-30px; margin-left:28px;
    width:240px; line-height:16px;
}
a.tooltip2:hover span{
    display:inline; position:absolute; color:#111;
    border:1px solid #DCA; background:#fffAF0;}
.callout2 {z-index:20;position:absolute;top:30px;border:0;left:-12px;}

    
/*CSS3 extras*/
a.tooltip2 span
{
    border-radius:4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
        
    -moz-box-shadow: 5px 5px 8px #CCC;
    -webkit-box-shadow: 5px 5px 8px #CCC;
    box-shadow: 5px 5px 8px #CCC;
}
</style>

<style type="text/css">
.tooltip1{

    position: relative;
}

.tooltip1:hover:after{
    background: #333;
    background: rgba(0,0,0,.8);
    border-radius: 5px;
    bottom: 30px;
    color: #fff;
    content: attr(title);
    left: 20%;
    padding: 5px 15px;
    position: absolute;
    z-index: 98;
    width: 320px;
}

.tooltip1:hover:before{
    border: solid;
    border-color: #333 transparent;
    border-width: 6px 6px 0 6px;
    bottom: 24px;
    content: "";
    left: 50%;
    position: absolute;
    z-index: 99;
}

</style>

<style type="text/css">
a.tooltip3 {
		position: relative;
		display: inline;
	}
	
	a.tooltip3 span {
		position: absolute;
		left: 50%;
		width:140px;
		padding: 6px;
		margin-left: -76px;
		background: #000;
		color: #fff;
		text-align: center;
		visibility: hidden;
		border-radius: 5px;
	} 
			
	a.tooltip3 span:after {
		content: '';
		position: absolute;
		top: 100%;
		left: 50%;
		margin-left: -8px;
		width: 0; height: 0;
		border-top: 8px solid black;
		border-right: 8px solid transparent;
		border-left: 8px solid transparent;
	}
			
	a:hover.tooltip3 span {
		visibility: visible;
		opacity: 0.8;
		bottom: 30px;
		z-index: 999;
	}
</style>
	
<style type="text/css">

/* required style sheet for this demo */

.progress { float: left; width: 100%; overflow: hidden; padding-bottom: 5px }
.progress a { padding: 10px 20px; color:#979797; font-weight:normal }
.progress a:visited {color:#3386a8}
.progress .active a {color:black}
.progress .item { position: relative; border-bottom: 2px solid #d7d7d7 }
.progress .active:before { border-bottom: 2px solid #3386a8; display: block; content: ""; width: 1000px; right: 0; top: 42px; position: absolute; z-index: 2; margin-right: 50% }
.progress .active:after { display: block; content: ""; height: 10px; width: 10px; background:#3386a8; border-radius: 10px; position: absolute; left: 50%; top: 37px }
</style>

 <style type="text/css">
        .tooltip4
        {            
            position: relative;
            text-decoration: none;
            top: 0px;
            left: 0px;
			
        }
        .tooltip4:hover:after
        {
            background: #333;
            background: rgba(0,0,0,.7);
           font-size:10px;
            top: -5px;
            color: #fff;
            content: attr(alt);
            left: 0px;
            padding: 5px 15px;
            position: absolute;
            z-index: 98;
            width: 200px;
        }
        .tooltip4:hover:before
        {
            font-size:10px;          
            bottom: 10px;
            content: "";
            left: 0px;
            position: absolute;
            z-index: 99;
            top: 0px;
        }
    </style>
	

<script type="text/javascript">
function validateForm()
{
var a=document.forms["form1"]["mKBPakai"].value;
var b=document.forms["form1"]["tKBRincian"].value;
var c=document.forms["form1"]["mKBamount"].value;
var d=document.forms["form1"]["mKBRealize"].value;

//if (a==null || a==""){alert("Dipakai tidak boleh kosong");  return false; }

if (b==null || b==""){alert("Rincian tidak boleh kosong");  return false; }
if (c==null || c==""){alert("Rincian tidak boleh kosong");  return false; }
if (d==null || d==""){alert("Rincian tidak boleh kosong");  return false; }

if (isNaN(a)){ alert("Dipakai harus angka"); return false; }
}

</script>

<script type="text/javascript">
function validateForm1()
{


var a=document.forms["form"]["mKBPakai"].value;
var b=document.forms["form"]["tKBRincian"].value;
var c=document.forms["form"]["mKBRealize"].value;

if (a==null || a==""){alert("Jumlah Pakai tidak boleh kosong");  document.form.mKBPakai.focus() ; return false; }
if (a > c){alert("Jumlah pakai melebihi nilai realisasi");  document.form.mKBPakai.focus() ; return false; }  
if (b==null || b==""){alert("Rincian tidak boleh kosong");  document.form.tKBRincian.focus() ; return false; }


}
</script>

		
<?php
//***********************************************************************************************
    // Sub Name                 : Index_load
    // Created By               : Dompak Petrus
    // Created Date             : 25-Nov-2013
    // Last Update By           : none
    // Last Update Date         : none
    // Description              : This sub called at the first time web form loaded
    // Parameter                : none
    // Return Value             : none
//************************************************************************************************

error_reporting(0);
session_start();
//include "../../../koneksi/koneksi.php";


$hostName = 'MISPC00378';
$userName = 'sa';
$passWord = 'admin';
$dataBase = 'eKasbon_Jasnikom';


mssql_connect($hostName, $userName, $passWord);
mssql_select_db($dataBase);


//require 'terbilang.php';


$alphaNumeric  = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
$random = substr(str_shuffle($alphaNumeric), 0, 7);

$textColor = imagecolorallocate ($image, 0, 0, 0); //black
imagestring ($image, 5, 5, 8,  $random, $textColor); 
$_SESSION['image_random_value'] = md5($random);
$token= md5($random);

$today = date ("m/d/Y");
$DateTime = date ("m/d/Y H:i:s");

switch($this->input->get('act')){

	default:
	echo"<table> 
  <tr><td>Period</td><td>:</td><td><select id=select1 onchange=goToPage('select1')>";
    $sql = mssql_query("SELECT * FROM tbPeriod ORDER BY iPeriodId ASC");					  
		  while ($data = mssql_fetch_array($sql)){
			echo "<option value='?act=bSearch&PRD=$data[iPeriodId]'>$data[cPeriodName]</option>";
		  }  
	echo"</select></table>";

break;

case"bSearch":
	
	echo"<table> 
	<tr><td>Period</td><td>:</td><td><select id=select1 onchange=goToPage('select1')>";
    $sql = mssql_query("SELECT * FROM tbPeriod ORDER BY iPeriodId ASC");					  
		  while ($data = mssql_fetch_array($sql)){
		  if ($data[iPeriodId] == $_GET[PRD]){
			echo "<option value='?act=bSearch&PRD=$data[iPeriodId]' SELECTED>$data[cPeriodName]</option>";
			}
			else{
			echo "<option value='?act=bSearch&PRD=$data[iPeriodId]'>$data[cPeriodName]</option>";
		  }
	}		  
  echo"</select></table>";
	
$PRD = $this->input->get('PRD');

	$tampil = mssql_query("SELECT tbKB.cKBNo AS cKBNo, tbKB.iKBID AS iKBID, tbKB.dKBDate AS dKBDate,tbKB.bKBStatus AS bKBStatus,tbKB.iKBPeriodId AS iKBPeriodId,tbKB.dKBDueDate AS dKBDueDate,tbKB.iKBCurrencyId AS iKBCurrencyId,
	tbKB.iKBKasbonId AS iKBKasbonId,tbKB.mKBRealize AS mKBRealize,tbKB.bKBRespon AS bKBRespon,tbKB.iKBDeptId AS iKBDeptId, tbKB.cKBUser AS cKBUser, tbKB.mKBamount AS mKBamount, tbKB.tKBRemark AS tKBRemark,tbProsesApprovalKB.bKBRealisasi AS bKBRealisasi 
	FROM tbKB LEFT JOIN tbProsesApprovalKB ON tbKB.iKBID = tbProsesApprovalKB.iKBID WHERE tbKB.iKBPeriodId='$PRD' AND tbKB.bKBStatus=1 AND tbProsesApprovalKB.bKBRealisasi=1 AND tbKB.mKBRealize > 0");		
	
	$Dept = mssql_fetch_array(mssql_query("SELECT * FROM tbDept WHERE iDeptID='$_SESSION[UserDeptId]'"));
	$total = mssql_num_rows($tampil);

if ($total <= 0 ){

echo"</br><p><font color=#FF0000 size=-1>No Data $PRD</font></p>";
}
else {	
	//<td>Kontrol Kasbon Internal Periode: <b>$Periode[cPeriodName]</b>, Total Record: $total</td>
	$Periode = mssql_fetch_array(mssql_query("SELECT * FROM tbPeriod WHERE iPeriodId='$PRD'"));				
	echo "<div class='row-fluid'>                
                <div class='span12'>
                    <div class='head clearfix'>
                        <div class='isw-grid'></div>
                        <h1><b>Data $mod - Total Record : $total</b></h1>
                    </div>
		<table  width=100% id='tfhover' border='0' cellpadding='0' cellspacing='0'>		
		<tr>
		<th width=25>No</th>		
		<th colspan=2>...</th>
		<th colspan=1>Respon</th>
		<th colspan=1>No Kasbon</th>
		<th>Progres</th>		
		</tr>";
    $num=1;
	while($data = mssql_fetch_array($tampil)){	

	$name =  $data[cKBUser];
	list($fname, $lname) = split(' ', $name,2);
	
	$TglKB = date('d M Y', strtotime($data[dKBDate]));		  
	$Apv1 = mssql_fetch_array(mssql_query("SELECT * FROM tbKBApproval WHERE iKBDeptId=$data[iKBDeptId]"));
	$Apv2 = mssql_fetch_array(mssql_query("SELECT * FROM tbKBApproval WHERE iKBDeptId='3'"));
	$dKBDate = date('d-M-y', strtotime($data[dKBDate]));
	
	$mKBamount = number_format($data[mKBamount], 2);
	$mKBRealize = number_format($data[mKBRealize], 2);
	//$terbilang1 = Terbilang($data[mKBamount]);
//------------------------------------------------------//

	if ($data[KBApv1] == 'A'){
		$bg1 = '#00FF00';
		$Tgl1 = date('d-M-y', strtotime($data[KBTgl1]));
		$note1 = '<img style=border:0; src=images/OK2.png  width=18 height=18 title=Accept,'.$Tgl1.'>';
		
		}
	elseif ($data[KBApv1] == 'R'){
		$bg1 = 'red';
		$Tgl1 = date('d-M-y', strtotime($data[KBTgl1]));
		$note1 = '<img style=border:0; src=images/NG2.png  width=18 height=18 title=Reject,'.$Tgl1.'>';
		
		}
	else {
		$bg1 = '';
		$note1 = '<img style=border:0; src=images/girigiri2.png  width=18 height=18 title=Waiting...>';
		$Tgl1 = '';
	}
//------------------------------------------------------//
	if ($data[bKBRespon] == '1' OR $data[bKBRespon] == 'True'){		
		$Real = '<img style=border:0; src=images/OK2.png  width=16 height=16 title=Realisasi >';
		$indicator ='#00FF00';
	}	
	else {		
		//$Real = '<img style=border:0; src=images/girigiri2.png  width=16 height=16 title=Belum>';
		$Real = '';
		$indicator ='';
	
	}
//------------------------------------------------------//
	if ($data[KBApv3] == 'A'){
		$bg3 = '#00FF00';
		$Tgl3 = date('d-M-y', strtotime($data[KBTgl3]));
		$note3 = '<img style=border:0; src=images/OK2.png  width=18 height=18 title=Accept,'.$Tgl3.'>';
		
	}
	elseif ($data[KBApv3] == 'R'){
		$bg3 = 'red';
		$Tgl3 = date('d-M-y', strtotime($data[KBTgl3]));
		$note3 = '<img style=border:0; src=images/NG2.png  width=18 height=18 title=Reject,'.$Tgl3.'>';
		
		}
	else {
		$bg3 = '';
		$note3 = '<img style=border:0; src=images/girigiri2.png  width=18 height=18 title=Waiting...>';
		$Tgl3 = '';
	}
//------------------------------------------------------//	
	if ($data[iKBApv] >= 1){
		$bg4 = '#00FF00';
		$note4 = 'Process';	
	}	
	else {
		$bg4 = '';
		$note4 = 'Send';
	
	}
	if ($data[KBVoid] == 1){
		$void = 'red';
		//$note4 = 'Process';	
	}	
	else {
		$void = '';
		//$note4 = 'Send';
	
	}
	
	$sqli = mssql_fetch_array(mssql_query("SELECT * FROM tbProsesResponKB WHERE iKBID = '$data[iKBID]' "));
	
	if ($sqli[cKBApvAtasan1] == 'A' || $sqli[cKBApvAtasan1] == 'R'){
	$leni = 'item active';
	$tglin = date('d-M-Y', strtotime($sqli[dKBTglAtasan1]));
	}
	else{
	$leni = 'item';
	$tglin = '';
	}
	
	if ($sqli[cKBApvAtasan2] == 'A' || $sqli[cKBApvAtasan2] == 'R'){
	$lenisa = 'item active';
	$tglout = date('d-M-Y', strtotime($sqli[dKBTglAtasan2]));
	}
	else{
	$lenisa = 'item';
	$tglout = '';
	}
	
	if ($_GET['token']==""){
	$token = '';
	
	}
	else {
	$token ='&token='.$_GET['token'];
	}


	$Currency = mssql_fetch_array(mssql_query("SELECT * FROM tbCurrency WHERE iCurrencyId='$data[iKBCurrencyId]'"));	
		echo "<tr>
		<td rowspan=1 bgcolor='$void'><div align='center'>$num .</td>
		<td width=3%><a href='#openModal$num'>
		<img style=border:0; src='images/money1.png' onmouseover=this.src='images/money2.png' onmouseout=this.src='images/money1.png' title='Pertanggung jawaban' alt='Pertanggung jawaban' width=16 height=16></a>
		<div id='openModal$num' class='modalDialog'>
		
	<div>";
	
	if ($data[iKBKasbonId] == 1){
		   //<form name='form1' id='form1' action='module=$_GET[module]&act=input&id=$_GET[id]&PRD=$_GET[PRD]' onsubmit='return validateForm()' method='POST'>
		echo"<form name='form1' id='form1' action='module=$_GET[module]&act=input&id=$data[iKBID]&PRD=$_GET[PRD]' method='POST'>
		<div class='modal-header'>
					<a href='#' class='close'>&times;</a>
					<h2><b>Pertanggung jawaban Kasbon No: $data[cKBNo]</b></h2>
					<div align='right'><input  type='submit' onclick='return validateForm' value='  Process  '></div>

				</div>
				
		
		<p>Diajukan &nbsp;&nbsp;:<input type=text name='mKBamount' autocomplete='off' size=30 value='$data[mKBamount]'></p>
		
		<p><input type='hidden' name='iKBKasbonId' value='$data[iKBKasbonId]'></p>
		<p>Realisasi &nbsp;:<input type=text name='mKBRealize' autocomplete='off' size=30 value='$data[mKBRealize]'></p>
		
		<p>Dipakai &nbsp;&nbsp;&nbsp;:<input type=text name='mKBPakai' placeholder='00000000' autocomplete='off' size=30></p>
		<p>Rincian Pemakaian :</br><textarea name='tKBRincian' placeholder='Harus Diisi' style='width: 360px; height: 120px;'></textarea>
		
		
		</form>";
		}
		
		
	//<input type=button value='  Cancel  ' onclick=\"window.location.href='#close';\">	
	elseif($data[iKBKasbonId] ==2) {
		echo"<form action='module=$_GET[module]&act=input&id=$data[iKBID]&PRD=$_GET[PRD]' method='POST'>	
			
				<div class='modal-header'>
					<a href='#' class='close'>&times;</a>
					<h2><b>Pertanggung jawaban Kasbon No: $data[cKBNo]</b></h2>
					<div align='right'><input  type='submit' onclick='return validateForm' value='  Process  '></div>
				</div>	
				<div class='modal-body'>
					<div class='divDialogElements'>
						<ul class='tabs' data-tabs='tabs'>
							<li class='active'><a href='#kasbon$num'>Kasbon</a></li>
							<li><a href='#transport$num'>Biaya Transport</a></li>
							<li><a href='#harian$num'>Biaya Harian</a></li>
							
							</ul>
							<div id='my-tab-content' class='tab-content'>							
							<div class='active tab-pane' id='kasbon$num'>
							<p>Diajukan &nbsp;&nbsp;:<input type=text name='mKBamount' autocomplete='off' size=30 value='$data[mKBamount]'></p>		
							<p><input type='hidden' name='iKBKasbonId' value='$data[iKBKasbonId]'></p>
							<p>Realisasi &nbsp;:<input type=text name='mKBRealize' autocomplete='off' size=30 value='$data[mKBRealize]'></p>		
							<p>Dipakai &nbsp;&nbsp;&nbsp;:<input type=text name='mKBPakai' autocomplete='off' size=30></p>
							<p>Rincian Pemakaian :</br><textarea name='tKBRincian' style='width: 360px; height: 120px;'></textarea></p>

							
							</div>							
							<div class='tab-pane' id='transport$num'>
							<table border='0' cellspacing='2' cellpadding='2'>
							<tr>
							<th scope='col'>Item</th>
							<th scope='col'>Perkiraan (Rp)</th>
							<th scope='col'>Jml Pakai (Rp)</th>
							</tr>";
							
	$UHPD = mssql_fetch_array(mssql_query("SELECT * FROM tbUHPD WHERE iUHPDKBId = '$data[iKBID]'"));
		
	$no=1;		
	$sql = mssql_query("SELECT     * FROM tbCostTrans LEFT JOIN
                      tbUHPDTrans ON tbCostTrans.CostTransId = tbUHPDTrans.CostTransId
WHERE tbUHPDTrans.iUHPDTransId=$UHPD[iUHPDId] AND tbCostTrans.CompanyId=$_SESSION[CompanyId] ORDER BY tbCostTrans.CostTransId ASC");
	
	while ($dta = mssql_fetch_array($sql)){
	//$sqltrans = mssql_fetch_array(mssql_query("SELECT * FROM tbUHPDTrans WHERE iUHPDTransId = '$sqli[iUHPDId]' AND CostTransId=$data[CostTransId]"));
	
	$TransPerkiraan = number_format($sqltrans[TransPerkiraan], 0);
	
		echo "
		<tr>
		<td><div align='right'>$dta[CostTransName]:</div></td>
		<td><input type='text' placeholder='00000000' name='TransPerkiraan".$no."' size=15 value='$dta[TransPerkiraan]' onkeydown='return tabOnEnter(this,event)' onkeyup='this.value=numberWithCommas(this.value);'></td>
		<td><input type='text' placeholder='00000000' name='TransPakai".$no."' size=15 onkeydown='return tabOnEnter(this,event)' onkeyup='this.value=numberWithCommas(this.value);'></td>
		</tr>";

	$no++;	
	}
	
							echo"</table><p>Rincian Pemakaian :</br><textarea name='tUHPDTransRincian' style='width: 360px; height: 120px;'></textarea></p></div>
							
							<div class='tab-pane' id='harian$num'>
														<table border='0' cellspacing='2' cellpadding='2'>
							<tr>
							<th scope='col'>Item</th>
							<th scope='col'>Perkiraan (Rp)</th>
							<th scope='col'>Jml Pakai (Rp)</th>
							</tr>";
							
		$UHPD = mssql_fetch_array(mssql_query("SELECT * FROM tbUHPD WHERE iUHPDKBId = '$data[iKBID]'"));
		
	$no=1;
		
	$sql = mssql_query("SELECT     *
FROM         tbCostDay LEFT JOIN
                      tbUHPDDays ON tbCostDay.CostDayId = tbUHPDDays.CostDayId
WHERE tbUHPDDays.iUHPDDaysId=$UHPD[iUHPDId] AND tbCostDay.CompanyId=$_SESSION[CompanyId] ORDER BY tbCostDay.CostDayId ASC");
	
	while ($dta = mssql_fetch_array($sql)){	
	$TransPerkiraan = number_format($sqltrans[TransPerkiraan], 0);
	
		echo "
		<tr>
		<td><div align='right'>$dta[CostDayName]:</div></td>
		<td><input type='text' placeholder='00000000' name='DaysPerkiraan".$no."' size=15 value='$dta[DaysPerkiraan]' onkeydown='return tabOnEnter(this,event)' onkeyup='this.value=numberWithCommas(this.value);'></td>
		<td><input type='text' placeholder='00000000' name='DaysPakai".$no."' size=15 onkeydown='return tabOnEnter(this,event)' onkeyup='this.value=numberWithCommas(this.value);'></td>
		</tr>";

	$no++;	
	}
	
							echo"</table><p>Rincian Pemakaian :</br><textarea name='tUHPDDaysRincian' style='width: 360px; height: 120px;'></textarea></div>

							
							
							</div>							
							</div>							
						</div>					
					</div>			
				

			
		</form>";
		
		}
	echo"</div>
</div>

</td>
		<td width=3%><div align='center'><a href='module=$_GET[module]&act=print$data[iKBKasbonId]&id=$data[iKBID]&PRD=$_GET[PRD]'>
		<img style=border:0; src='images/print1.png' onmouseover=this.src='images/print2.png' onmouseout=this.src='images/print1.png' title='print' alt='print' width=16 height=16></a></td>
		
		<td width=3%><div align='center'>$Real</td>		
		<td bgcolor='$indicator'><div align=center><a href='#' class='tooltip'> $data[cKBNo]
		<span><img class='callout' src='images/callout_black.gif' />
        Keperluan: $data[tKBRemark]</br>
		Jumlah: $Currency[cCurrencyCode] $data[mKBamount]</br>

</span>
</a></td>
		
		<td>
		<ul class='reset maketabs progress'>";
		//<li class='$leni'><a href='#' title='Atasan Langsung Approval By Dompak Petrus, $tglin'>Atasan Langsung</a></li>
		//<li class='$lenisa'><a href='#' title='$tglout'>Atasan Lebih Tinggi</a></li>";
		
	$pro = mssql_query("SELECT * FROM tbMatrikApproval WHERE iKasbonId ='$data[iKBKasbonId]' AND iCompanyId ='$_SESSION[CompanyId]' ORDER BY iNoProses");		
	$no = 1;

	
while ($dta = mssql_fetch_array($pro)){

	$no = $dta[iNoProses];	
	$cKBApv = 'cKBApv'.$no;
	$dKBTgl = 'dKBTgl'.$no;
	$iKBNIK = 'iKBNIK'.$no;
	$dKBTgl = 'dKBTgl'.$no;
	
	$Profile = mssql_fetch_array(mssql_query("SELECT * FROM tblProfileLogin WHERE NIK ='$sqli[$iKBNIK]'"));		
	
	
	if ($sqli[$cKBApv] == 'A' || $sqli[$cKBApv] == 'R' || $sqli[$cKBApv] == 'C' || $sqli[$cKBApv] == 'N'){
	$len = 'item active';
	$Nama = $Profile[Nama];
	$TglApv = date('d-M-Y', strtotime($sqli[$dKBTgl]));
	$spasi = 'oleh';
	$spasi1 = 'tanggal';
	}
	else {
	$len = 'item';
	$Nama = '';
	$TglApv = '';
	$spasi = '';
	$spasi1 = '';
	}
	
	$Divisi = mssql_fetch_array(mssql_query("SELECT * FROM tbApproval WHERE ApprovalId = '$dta[ApprovalId]'"));	
	
	if ($sqli[$cKBApv] == "A"){	
	$Tip = $Divisi[Name].' sudah meng-approval';
	$fontcolor = '';
	}
	elseif($sqli[$cKBApv] == "R") {	
	$Tip = $Divisi[Name].' sudah meng-reject';
	$fontcolor = '#FF0000';
	}
	elseif($sqli[$cKBApv] == "C") {	
	$Tip = $Divisi[Name].' sudah meng-check';
	$fontcolor = '';
	}
	elseif($sqli[$cKBApv] == "N") {	
	$Tip = $Divisi[Name].' sudah dinotifikasi';
	$fontcolor = '';
	}
	
	else{	
	$Tip = 'Proses '.$Divisi[Name];
	}
		
		echo"<li class='$len'><a href='#' class='tooltip4' title='$Tip $spasi1 $TglApv $spasi $Nama' alt='$Tip $spasi1 $TglApv $spasi $Nama'>
	<font color='$fontcolor'>$Divisi[Name]</font></a></li>";
	$no++;
  }		
		echo"
		</ul>
		
		</td>		
		</tr>";
		$num++;		
	}	
	echo "</table>";
	
}	
	
	break;


}		
?>
