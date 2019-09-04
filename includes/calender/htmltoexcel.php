<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<title>BAND Function</title>
</head>
<style type="text/css">
	body {
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
		margin:0px;
		padding:0px;
	}
	#atd td{
		padding:3px;
		font-weight:bold;
	}
	#avg_col{
		background-color:#CCFFCC;
	}
	#ctbl, #ctbl td{
		padding:5px;
		border: 1px solid black;
		border-collapse:collapse;
	}
</style>
<html>
<body>
<?php

$table = $display = "";	
$fn = "tejash";
			
			$table .= '<table border="0" cellpadding="0" cellspacing="0" id="ctbl"><tr><td>';
			$table .= '<tr id="atd">';
			$table .= '<td rowspan="2" style="background-color:#000099;color:#FFFFFF;">Time</td>';
			$table .= '<td colspan="4" style="background-color:#FFFF33">TN</td>';
			$table .= '<td colspan="4" style="background-color:#FFFF33">CN</td>';
			$table .= '<td rowspan="2" style="background-color:#000099;color:#FFFFFF;padding:0px 5px 0px 5px;">Band<br>Level</td>';
			$table .= '</tr>';
			$table .= '<tr id="atd">';
			$table .= '<td style="background-color:#FFFCCC">OFFERED</td>';
			$table .= '<td style="background-color:#FFFCCC">BAND</td>';
			$table .= '<td style="background-color:#FFFCCC">RUN TIME</td>';
			$table .= '<td style="background-color:#FFFCCC">Abandoned</td>';
			$table .= '<td style="background-color:#FFCC99">OFFERED</td>';
			$table .= '<td style="background-color:#FFCC99">BAND</td>';
			$table .= '<td style="background-color:#FFCC99">RUN TIME</td>';
			$table .= '<td style="background-color:#FFCC99">Abandoned</td>';
			$table .= '</tr>';
			$table .= '<tr>';
			$table .= $display;
			$table .= '</td></tr></table>';
		

		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=$fn.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
?>
</body>
</html>