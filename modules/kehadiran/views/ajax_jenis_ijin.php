<script type="text/javascript">
function GetXmlHttpObject() 
{ 
var xmlHttp=null; 
try 
 	{ 
 	// Firefox, Opera 8.0+, Safari 
 	xmlHttp=new XMLHttpRequest(); 
 	} 
	catch (e) 
 	{ 
 	//Internet Explorer 
 	try 
 	{ 
 	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); 
  	} 
 	catch (e) 
  	{ 
  	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  	} 
 	} 
return xmlHttp; 
}

function kirim(id) 
{ 
var xmlHttp=GetXmlHttpObject()	 
var url="modules/kehadiran/views/ajax_manfaat.php" ;
url1=url+"?id="+id;
xmlHttp.onreadystatechange=hasil; 
function hasil() 
	{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") 
 	              {	     
                      document.getElementById("tampil").innerHTML=xmlHttp.responseText; 
 	              } 
	else 
    	              { 
    	               alert("Problem retrieving data:" + xmlhttp.statusText); 
    	               }	 
	} 
	xmlHttp.open("GET",url1,true);
	xmlHttp.send(null); 	 
}
</script>


<?php
error_reporting(0);
session_start();


//echo "<table class='tftablein' border='1'>";
echo"<tr><td>Pilih Periode</div></td><td>:</td><td>
<select name='PeriodeId' OnChange='kirim(this.value)'>
<option selected='selected' value='0'>---Pilih Periode---</option>";


$sql = mysql_query("SELECT * FROM tbl_jeniscuti_item");

while ($dta = mysql_fetch_array($sql)){
	echo "<option value='$dta[JenisItemCutiId]'>$dta[JenisItemCutiName]</option>";
}
echo"</table>";
//echo"<tr><td>Manfaat</div></td><td>:</td><td>
echO"<tr><td><div id='tampil'></div>";


?>