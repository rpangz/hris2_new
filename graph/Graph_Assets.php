<script src="js2/jquery.min.js" type="text/javascript"></script>
<script src="js2/highcharts.js" type="text/javascript"></script>
<script type = "text/javascript">
function goToPage( id ) {
  var node = document.getElementById( id );  
  if( node &&
    node.tagName == "SELECT" ) {
    window.location.href = node.options[node.selectedIndex].value;    
  }  
}
</script>

<?php
error_reporting(0);
session_start();
//include "../../../koneksi/koneksi.php"; 

$hostName = '172.17.0.59';
$userName = 'sa';
$passWord = '$mis@admin';
$dataBase = 'eKasbon_Astel';

mssql_connect($hostName, $userName, $passWord);
mssql_select_db($dataBase);




echo"<form name='form2' id='form2' action='?' method='POST'>
	<table>
		<tr><td>Tahun</td><td>:</td><td><select name=PRD>
	<option value='0' SELECTED>--All---</option>";
    $sql = mssql_query("SELECT * FROM (SELECT YEAR(dPeriodStartDate) AS Tahun FROM tbPeriod) AS Tahun GROUP BY Tahun");					  
		  while ($data = mssql_fetch_array($sql)){
		  if ($_POST[PRD] == $data[Tahun]){
			echo "<option value='$data[Tahun]' SELECTED>$data[Tahun]</option>";
		}
			else {
			echo "<option value='$data[Tahun]'>$data[Tahun]</option>";
		}
		  }  
	echo"</select></td>  
 
	<td>Departemen</td><td>:</td><td><select name='iDeptID'>
	<option value='0' SELECTED>--All---</option>";		
	$sql = mssql_query("SELECT * FROM tbDept WHERE iDeptID !=0 ORDER BY cDeptName ASC");					  
	  while ($data = mssql_fetch_array($sql)){
	  if ($_POST[iDeptID] == $data[iDeptID]){
		echo "<option value='$data[iDeptID]' SELECTED>$data[cDeptName]</option>";
		}
		else 
		{
			echo "<option value='$data[iDeptID]'>$data[cDeptName]</option>";
		}
		}
		echo"</select></td>
		
		<td>Status:</td><td>:</td><td><select name='cKBStatusApv'>		
		<option value='0'>---All---</option>    
		<option value='A'>Accept</option>
		<option value='R'>Reject</option>
		<option value='X'>Void</option>
		</select>
		&nbsp;&nbsp;&nbsp;
	
	<td><input  type='submit' onclick='return validateForm' value='  Generate  '></tr></table></form>";
	
$satu 	= mssql_fetch_array(mssql_query("SELECT TOP 1 * FROM (SELECT YEAR(dPeriodStartDate) AS Tahun FROM tbPeriod) AS Tahun GROUP BY Tahun ORDER BY Tahun ASC"));
$dua 	= mssql_fetch_array(mssql_query("SELECT TOP 1 * FROM (SELECT YEAR(dPeriodStartDate) AS Tahun FROM tbPeriod) AS Tahun GROUP BY Tahun ORDER BY Tahun DESC"));


	$Start			= $_POST[PRD];
	$DeptId			= $_POST[iDeptID];
	$cKBStatusApv 	= $_POST[cKBStatusApv];
	
	If ($Start == "0"){
		$ThnMin = $satu[Tahun];
		$ThnMax = $dua[Tahun];
		$title	= 'Semua Tahun';
		}
		else {	
		$ThnMin = $_POST[PRD];
		$ThnMax = $_POST[PRD];
		$title 	= $_POST[PRD];
		}
	If ($DeptId == "0"){
		$Dept='>0';
		$title1 = 'Semua Departemen';
		}
		else {
		$kdept 	= mssql_fetch_array(mssql_query("SELECT * FROM tbDept WHERE iDeptID=$_POST[iDeptID]"));
		$Dept='='.$DeptId;
		$title1 = $kdept[cDeptName];
		}
	


//$sql   	= "SELECT iKBPeriodId,count(iKBID) AS Jumlah FROM tbKB WHERE bKBStatus=1 GROUP BY iKBPeriodId ORDER BY iKBPeriodId ASC";
//$section 	=

$min = mssql_fetch_array(mssql_query("SELECT min(iPeriodId) AS Start FROM (SELECT iPeriodId,YEAR(dPeriodStartDate) AS Tahun,dPeriodStartDate FROM tbPeriod) AS Yer WHERE Tahun='$ThnMin'"));
$max = mssql_fetch_array(mssql_query("SELECT max(iPeriodId) AS Finish FROM (SELECT iPeriodId,YEAR(dPeriodStartDate) AS Tahun,dPeriodStartDate FROM tbPeriod) AS Yer WHERE Tahun='$ThnMax'"));
$sql = "SELECT iKBPeriodId,count(iKBID) AS Jumlah FROM tbKB WHERE bKBStatus=1 AND iKBPeriodId >='$min[Start]' AND iKBPeriodId <='$max[Finish]' AND iKBDeptId$Dept ";


if ($_POST['cKBStatusApv'] == 'A')
	{
		$sql .= " AND cKBStatusApv='A'";
		$title3 = ' - ACCEPT';
	}
elseif ($cKBStatusApv == 'R')
	{
		$sql .= " AND cKBStatusApv='R'";
		$title3 = ' - REJECT';
	}
elseif ($cKBStatusApv == 'X')
	{
		$sql .= " AND cKBStatusApv='X'";
		$title3 = ' - VOID';
	}
else 
	{
		$sql .= "";
		$title3 = ' - ALL';
	}
	
$sql .= "GROUP BY iKBPeriodId ORDER BY iKBPeriodId ASC";

echo"<script type='text/javascript'>
	var chart1; // globally available
$(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'container',
            type: 'column'
         },   
         title: {
            text: 'Grafik Pengajuan Kasbon $title dan $title1 $title3'
         },
         xAxis: {
            categories: ['Bulan']
         },
         yAxis: {
            title: {
               text: 'Jumlah Kasbon (form)'
            }
         },
              series:             
            [";		
		
		
           
            $query = mssql_query($sql);
            while($ret = mssql_fetch_array($query)){
			$sqlday = mssql_fetch_array(mssql_query("SELECT * FROM tbPeriod WHERE iPeriodId = '$ret[iKBPeriodId]'"));
            	$time = strtotime($sqlday[dPeriodStartDate]);
				$dPeriodStartDate = date("M-Y", $time);
			
				$merek = $dPeriodStartDate;				
                $sql_jumlah   = "SELECT count(iKBID) AS jumlah FROM tbKB WHERE iKBPeriodId='$ret[iKBPeriodId]' AND bKBStatus=1";       
                
				
				if ($cKBStatusApv == 'A')
					{
						$sql_jumlah .="AND cKBStatusApv='A'";
					}
				elseif ($cKBStatusApv == 'R')
					{
						$sql_jumlah .="AND cKBStatusApv='R'";
					}
				elseif ($cKBStatusApv == 'X')
					{
						$sql_jumlah .="AND cKBStatusApv='X'";
					}
				else
					{				
						$sql_jumlah .="";					
					}
				
				 
				 $query_jumlah = mssql_query($sql_jumlah);
                 while( $data = mssql_fetch_array($query_jumlah)){
                    $jumlah = $data['jumlah'];                 
                  }             
                  ?>
                  {
                      name: '<?php echo $merek; ?>',
                      data: [<?php echo $jumlah; ?>],
                  },
                  <?php } 
            echo"]
      });
   });	
</script>
<div id='container'></div>";		
