<?php
$day = date ("d-m-Y_H:i");

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Sisa_Cuti_$day.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<style type=text/css>
#body {
	font-size:36px;
}

.noPrint {
    display: none;
}

.bigcell {
    position: relative;
    width: 100px;
    height: 50px;
    border: thin dotted gray;
}

td.thickBorder{ border-bottom: solid gray 1px;}
td.thickBorderRight{ border-right: solid gray 1px;
					border-bottom: solid gray 1px;}

}
.strikeout {
	position: absolute;
	height: 0px;
	width: 179px;
	background-color: black;
	top: 146px;
	visibility: inherit;
	}
.table1 { border:1px black solid; 
			font-size: 12px;} /* or other border styles */
table {font-size: 16px;}
.style1 {
	font-size: 16px;
	font-weight: bold;
}
</style>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="800" class="table1" border="0px" cellpadding="0" cellspacing="0" frame="box">
  <tr>
    <td bgcolor="#CCCCCC"> <span class="style1">EMPLOYEE  CV</span></td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="128">Name</td>
        <td width="12">:</td>
        <td width="143">Dompak Petrus</td>
        <td width="106">Age</td>
        <td width="11">:</td>
        <td width="187">38 Tahun</td>
        <td colspan="2" rowspan="9"><div align="center"></div></td>
        </tr>
      <tr>
        <td>NIP</td>
        <td>:</td>
        <td>&nbsp;</td>
        <td>Place Of Birth</td>
        <td>:</td>
        <td>Jakarta</td>
        </tr>
      <tr>
        <td>Company</td>
        <td>:</td>
        <td>&nbsp;</td>
        <td>Date of birth</td>
        <td>:</td>
        <td>7/6/1976</td>
        </tr>
      <tr>
        <td>Division </td>
        <td>:</td>
        <td>&nbsp;</td>
        <td rowspan="3" valign="top">Address</td>
        <td rowspan="3" valign="top">:</td>
        <td rowspan="3" valign="top">Jl. Panataran No. 2, Pegangsaan</td>
        </tr>
      <tr>
        <td>Job Title Structural</td>
        <td>:</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>City</td>
        <td>:</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Job Title fungsional</td>
        <td>:</td>
        <td>&nbsp;</td>
        <td>ZIP</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Joint date</td>
        <td>:</td>
        <td>&nbsp;</td>
        <td>Telephone</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Sex</td>
        <td>:</td>
        <td>&nbsp;</td>
        <td>Fax</td>
        <td>:</td>
        <td>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td colspan="4">Work Experience</td>
        </tr>
      <tr>
        <td width="83" bgcolor="#CCCCCC"><div align="center">Start Year</div></td>
        <td width="85" bgcolor="#CCCCCC"><div align="center">End Year</div></td>
        <td width="270" bgcolor="#CCCCCC"><div align="center">Company</div></td>
        <td width="334" bgcolor="#CCCCCC"><div align="center">Position</div></td>
      </tr>
      <tr>
        <td>8/ 1/ 2000</td>
        <td>5/ 31/ 2012</td>
        <td>PT. HM Sam poerna, Tbk</td>
        <td>I S System Analyst</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td colspan="7">Education</td>
        </tr>
      <tr>
        <td bgcolor="#CCCCCC"><div align="center">Start Year</div></td>
        <td bgcolor="#CCCCCC"><div align="center">End Year</div></td>
        <td bgcolor="#CCCCCC"><div align="center">I nstitution</div></td>
        <td bgcolor="#CCCCCC"><div align="center">City</div></td>
        <td bgcolor="#CCCCCC"><div align="center">Faculty</div></td>
        <td bgcolor="#CCCCCC"><div align="center">GPA</div></td>
        <td bgcolor="#CCCCCC"><div align="center">Major</div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
