<script type="text/javascript"> 
  function tabE(obj,e){ 
   var e=(typeof event!='undefined')?window.event:e;// IE : Moz 
   if(e.keyCode==13){ 
     var ele = document.forms[0].elements; 
     for(var i=0;i<ele.length;i++){ 
       var q=(i==ele.length-1)?0:i+1;// if last element : if any other 
       if(obj==ele[i]){ele[q].focus();break} 
     } 
  return false; 
   } 
  }

function tabEnt(obj,e){ 
   var e=(typeof event!='undefined')?window.event:e;// IE : Moz 
   if(e.keyCode==13){ 
     var ele = document.forms[0].elements; 
     for(var i=0;i<ele.length;i++){ 
       var q=(i==ele.length-1)?0:i+2;// if last element : if any other 
       if(obj==ele[i]){ele[q].focus();break} 
     } 
  return false; 
   } 
  }   
  
</script> 

<?php
error_reporting(0);
session_start();
include "../../koneksi/koneksi.php";


	switch($_GET[act]){
	
	default:
	echo"<script type=text/javascript>
	window.onload=function(){
	var tfrow = document.getElementById('tfhover').rows.length;
	var tbRow=[];
	for (var i=1;i<tfrow;i++) {
		tbRow[i]=document.getElementById('tfhover').rows[i];
		tbRow[i].onmouseover = function(){
		  this.style.backgroundColor = '#FFFF66';
		};
		tbRow[i].onmouseout = function() {
		  this.style.backgroundColor = '#ffffff';
		};
	}
};
</script>";
	$no=1;
	$tampil = mysql_query("SELECT * FROM tblProfileLogin");
	echo"<table width=100%><b>User Account</b><hr width=100%></table>";
	echo "<input type=button value='   Add   ' onclick=\"window.location.href='?module=UserAccount&act=add';\">";
	echo"<table  id='tfhover' class='tftable' border='0'>	
	<tr>
	<th>No</th>
	<th>User Login</th>	
	<th>Nama Lengkap</th>
	<th>Aktif</th>
	<th>Web Role</th>
	<th>Email</th>
	</tr>";
   
	while($data = mysql_fetch_array($tampil)){
	$time = strtotime($data[HistoryDate]);	
	$y=date('Y', $time);
	$m=date('m', $time);
	$h=date('H', $time);
	$Role = mssql_fetch_array(mssql_query("SELECT * FROM tbWebRoleName WHERE WebRoleId='$data[AppWebRoleId]'"));
	$Dept = mssql_fetch_array(mssql_query("SELECT * FROM tbDept WHERE iDeptID='$data[UserDeptId]'"));
	
	$Tgl = date('d-M-Y', strtotime($data[HistoryDate]));
	
	if ($data[WebRoleId]==1){
	$WebRole= 'Administrator';
	}
	else {
	$WebRole= 'User';
	}
	
	echo "<tbody><tr>
		<td><div align='center'>$no</td>
		<td><div align='left'><a href=?module=UserAccount&act=Detail&id=$data[Id]>$data[User]</a></td>	
		
		<td><div align='left'>$data[Nama]</td>
		<td><div align='center'>$data[Aktif]</td>		
		<td><div align='center'>$WebRole</td>
		<td><div align='left'>$data[Email]</td>
	</tr></tbody>";
	$no++;
	}
	//echo"</table>";	
	echo"<table width=100%><hr width=100%></table>";	
	break;
		
	case "new":
		
		echo "<table class='tftablein' border='0'>
		<form method='POST' action='?module=UserAccount&act=password'>
		<input type='hidden' name='UserName' value='$_SESSION[UserName]'>
		<tr><td colspan=3 bgcolor=#CCCCCC>Ganti Password</td></tr>		
		
		<tr><td>Password</td><td>:</td><td><input type='password' name='PasswordLama' size=50 onkeypress='return tabE(this,event)'></td></tr>
		<tr><td>Password Baru</td><td>:</td><td><input type='password' name='PasswordBaru' size=50 onkeypress='return tabE(this,event)'></td></tr>
		<tr><td>Re-type Password Baru</td><td>:</td><td><input type='password' name='PasswordBaru2' size=50 onkeypress='return tabE(this,event)'></td></tr>

		<tr><td colspan=3><input type=submit value='  Save  '>&nbsp;&nbsp;<input type=button value=' Cancel ' onclick=\"window.location.href='?module=UserAccount&act=UserAccount';\"></div></td></tr>
          </table>";
		
		
	break;
	
	// Modul Add----------------------------------------------------------------------------------------------------
	case "add":
	
	echo"<script type=text/javascript> 
  function tabE(obj,e){ 
   var e=(typeof event!='undefined')?window.event:e;// IE : Moz 
   if(e.keyCode==13){ 
     var ele = document.forms[0].elements; 
     for(var i=0;i<ele.length;i++){ 
       var q=(i==ele.length-1)?0:i+1;// if last element : if any other 
       if(obj==ele[i]){ele[q].focus();break} 
     } 
  return false; 
   } 
  }

function tabEnt(obj,e){ 
   var e=(typeof event!='undefined')?window.event:e;// IE : Moz 
   if(e.keyCode==13){ 
     var ele = document.forms[0].elements; 
     for(var i=0;i<ele.length;i++){ 
       var q=(i==ele.length-1)?0:i+2;// if last element : if any other 
       if(obj==ele[i]){ele[q].focus();break} 
     } 
  return false; 
   } 
  }   
  
</script>";
	//$Tambah =  mssql_fetch_array(mssql_query("SELECT max(UserId) AS No FROM tblExPE"));	
	echo"<table width=100%><b>User Account >> Add</b><hr width=100%></table>";
	$a=1;
	$New=($Tambah[No] + $a);	
	echo "<table class='tftablein' border='0'>
		<form method='POST' action='?module=UserAccount&act=input'>		
		<tr><td>User Name</td><td>:</td><td><input type=text name='User' size=30 onkeypress='return tabE(this,event)'></td></tr>
		<tr><td>Full Name</td><td>:</td><td><input type=text name='Nama' size=50 onkeypress='return tabE(this,event)'></td></tr>
		<tr><td>Status Login</td><td>:</td><td>";			  
		  
		echo"<input type='radio' name='Aktif' value='Y' checked>Aktif&nbsp;&nbsp;
		<input type='radio' name='Aktif' value='N'>Non Aktif&nbsp;&nbsp;
		";
		
		echo"<tr><td>Web Role</td><td>:</td><td><select name='WebRoleId'>
		<option value='0'>---Please Select---</option>
		<option value='1'>Administartor</option>
		<option value='2'>User</option>";	
		
		echo"<tr><td><div>Email</td><td> :</td><td><input type=text name='Email' size=50 onkeypress='return tabE(this,event)'></td></tr>
			<tr><td>Password</td><td>:</td><td><input type='password' name='Password' size=50 onkeypress='return tabE(this,event)'></td></tr>
			</p>";	
		
	echo "<tr><td colspan=3><input type=submit value='  Save  '>&nbsp;&nbsp;<input type=button value=' Cancel ' onclick=self.history.back()></div></td></tr>
          </table>";
	
	break;
	
	
	// Modul Detail--------------------------------------------------------------------------------------------------
	case "Detail":	
	$edit = mysql_query("SELECT * FROM tblProfileLogin WHERE Id=$_GET[id]");
	$data = mysql_fetch_array($edit);	
	
	if ($data[Aktif] == 'Y'){
		$y = 'checked';
	}
	elseif ($data[Aktif] == 'N'){
		$n = 'checked';
	}
	else{
		$y = '';
		$n = '';
	}
	
	echo"<table width=100%><b>User Account >> Detail</b><hr width=100%></table>";
	echo "
	<form method=POST name='submit' action='?module=UserAccount&act=update&id=$_GET[id]'enctype='multipart/form-data'>
          <input type='hidden' name='Id' value='$_GET[Id]'>";	
	
	echo "<table class='tftablein' border='0'>		
		
		<tr><td>User Name</td><td>:</td><td><input type=text name='User' size=50 value='$data[User]'></td></tr>
		<tr><td>Full Name</td><td>:</td><td><input type=text name='Nama' size=50 value='$data[Nama]'></td></tr>
		<tr><td>Status Login</td><td>:</td><td>";		
		
		echo"<input type='radio' name='Aktif' value='Y' $y>Aktif&nbsp;&nbsp;		
		<input type='radio' name='Aktif' value='N' $n>Non Aktif&nbsp;&nbsp;";	
		
		echo"<tr><td>Web Role</td><td>:</td><td><select name='WebRoleId'>";		
			if ($data[WebRoleId] == 1){
				echo "<option value='0'>---Please Select---</option>
				      <option value='1' SELECTED>Administrator</option>
				      <option value='2'>User</option>
				";
			}
			if ($data[WebRoleId] == 2){
			echo "<option value='0'>---Please Select---</option>
				  <option value='1'>Administrator</option>
				  <option value='2' SELECTED>User</option>";
			}
			
		
		
	echo"<tr><td>Email</td><td>:</td><td><input type=text name='Email' size=50 value='$data[Email]'></td></tr>";	
	echo "<tr><td colspan=5><input type='submit' value='  Save  '>&nbsp;&nbsp;";
	echo"<input type=button value=' Cancel ' onclick=\"window.location.href='?module=UserAccount&act=UserAccount';\"></div></td>";
    echo"<td><input type=button value=' Delete ' onclick=\"window.location.href='?module=UserAccount&act=delete&id=$_GET[id]';\"></td></tr>
	</table>";
	echo"<table width=100%><hr width=100%></table>";
	break;
	
	// Modul Update--------------------------------------------------------------------------------------------------
	case "update":
	mysql_query("UPDATE tblprofilelogin SET User = '$_POST[User]',
										Nama = '$_POST[Nama]',
										Aktif = '$_POST[Aktif]',
										WebRoleId = '$_POST[WebRoleId]',
										Email = '$_POST[Email]'								
									WHERE Id='$_GET[id]'");																
	echo "<script language='javascript'>alert('Data sudah di update');window.location ='?module=UserAccount';</script>";
	break;
	
		
	// Modul Input--------------------------------------------------------------------------------------------------
	case "input":
	$Tambah =  mysql_fetch_array(mysql_query("SELECT max(Id) AS No FROM tblProfileLogin"));	
	
	$a=1;
	$New=($Tambah[No] + $a);	
	
	if ($_POST[User]=="" || $_POST[Nama]=="" || $_POST[Password]=="" || $_POST[Aktif]=="" || $_POST[WebRoleId]=="0")
		{
			echo "<script language='javascript'>alert('Data Kurang Lengkap, Isilah data dengan Lengkap');history.go(-1);</script>";
		}
		else {
	$pass = md5($_POST[Password]);
	$today = date ("m/d/Y");
	mysql_query("INSERT INTO tblProfileLogin(Id,
									User,
									Nama,
								   Password,
								   Aktif,
								   Email,
								   WebRoleId								   
								   )								   
								    
							VALUES('$New',
									'$_POST[User]',
								   '$_POST[Nama]',
								   '$pass',
								   '$_POST[Aktif]',
								   '$_POST[Email]',
								   '$_POST[WebRoleId]')");
								   
	echo "<script language='javascript'>alert('Data sudah disimpan');window.location ='?module=UserAccount';</script>";
	}
	break;	
	
	// Modul Hapus--------------------------------------------------------------------------------------------------	
	case "delete":
	mssql_query("DELETE FROM tblProfileLogin WHERE UserId='$_GET[id]'");																
	echo "<script language='javascript'>alert('Data sudah di hapus');window.location ='?module=User';</script>";
	break;
	
}

?>
