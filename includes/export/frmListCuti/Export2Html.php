<style type=text/css>

.noPrint {
    display: none;
}
.style1 {font-size: 12px; border-bottom:0px thin solid white;}
.style2 {
	font-size: 24px;
	font-weight: bold;
	border-bottom:0px thin solid black;
}

.style3 {
	font-size: 18px;
	font-weight: bold;
	border-bottom:0px thin solid black;
}
.style4 {font-size: 10px; font-style: italic; }
.style5 {font-size: 14px}

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
.style7 {font-size: 12px; font-weight: bold; }
.table1 { border:1px black solid; 
			font-size: 12px;} /* or other border styles */
table {font-size: 12px;}
			
.style11 {font-size: x-large}




    </style>
	
	
	
<script type="text/javascript">	
$(function() {
    $("table a").click(function (){
        $("body > table").addClass("print-hidden");
        $(this).parents("table").last().removeClass("print-hidden");
        if (window.print) {
            window.print();
        }
    });
});
</script>
<script type="text/javascript">	
$("#btnExport").click(function(e) {
    window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
    e.preventDefault();
});
</script>

<style type="text/css">

    #printable { display: none; }

    @media print
    {
    	#non-printable { display: none; }
    	#printable { display: block; }
    }
	
	.btnimage {
    border: 0 none;
    background: none;
    background-image: url('images/printer1.png');    
    width: 30px;
    height: 30px;
}
.btnimage:hover {
    background-image: url('images/printer2.png');        
}

    </style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $("#btnPrint").live("click", function () {
		
           var divContents = $("#dvContainer").html();
			
           var printWindow = window.open('', '', 'height=600,width=950 scrollbars=yes ');
			//printWindow.document.write('<link rel="stylesheet" type="text/css" href="style1.css">');
		
			
			//printWindow.document.write('<link rel="stylesheet" type="text/css" href="style.css">');
           // printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
        //    printWindow.document.write('</body></html>');
           // printWindow.document.close();
            printWindow.print();
        });
    </script>
	
<?php
error_reporting(0);
session_start();
include "koneksi/koneksi.php";
//require 'terbilang.php';


$tampil = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId = '$_GET[id]'");		
	$data = mysql_fetch_array($tampil);
	
	//$Dept = mysql_fetch_array(mysql_query("SELECT * FROM tbDept WHERE iDeptID='$data[iKBDeptId]'"));
	$total = mysql_num_rows($tampil);
	
	
	
echo"<a href='javascript:window.print()';><img style=border:0; src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/printer1.png' onmouseover=this.src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/printer2.png' onmouseout=this.src='http://".$_SERVER['SERVER_NAME']."/hris2/includes/images/printer1.png' title='Print' width=30 height=30></a>&nbsp;&nbsp;&nbsp;&nbsp;";
//echo"<input type='image' id='btnPrint' class='btnimage' style=border:0; src='images/printer1.png'  onmouseover=this.src='images/printer2.png' onmouseout=this.src='images/printer1.png' title='Print' width=30 height=30 />";


echo"<p><strong>Detail Permohonan Cuti</strong></p>
<div id='dvContainer'>
<table width=900 class=table1 border=0px cellpadding=0 cellspacing=0 frame=box>
  <tr>
    <td width=95 height=31><span class=style1>FO-018-HLD</span></td>
    <td width=5>&nbsp;</td>
    <td width=116>&nbsp;</td>
    <td width=59>&nbsp;</td>
    <td width=353><span class=style1>#$_GET[act] $data[cKBNo]</td>
    <td width=1><span class=style1></span></td>
    <td width=151><div align=right><span class=style7>Rev. 1-Nov 13</span></div></td>
    
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan=5><div align='right' class=style4>(Wajib diisi N + 7 hari kerja)</div></td>
  </tr>
  <tr >
     <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan=3><div align='center' class=style2>KAS BON</div></td>
    <td>&nbsp;</td>
    <td><div align='center' class=style1>___<u>$dKBDueDate</u>___</td>   
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan=4><div align=right class=style1>Selambatnya diselesaikan tanggal :</div></td>
	 <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><span class=style7>PT.</span></td>
    <td><span class=style1>:</span></td>
    <td colspan=2 class='thickBorder'><span class=style1>$Company[NamaCompany]</span></td>
	<td><div align='right' class=style1>____<u>$dKBDueDate</u>____</div></td>
    <td><span class=style1></span></td>
    <td rowspan=8 valign=bottom><span class=style1></span><span class=style1></span><span class=style1></span><span class=style1></span>   
	
	
	 <table  width='120' align=right border=2px cellpadding=0 cellspacing=0 bordercolor=#000000 frame=border>
        
	</table>
	<span class=style1></span></td>  
  </tr>
  <tr> 
    <td><span class=style7>Divisi</span></td>
    <td><span class=style1>:</span></td>
    <td colspan=2 class='thickBorder'><span class='style1'>$Dept[cDeptName]</span></td>
    <td><span class=style1></span></td>
	<td><span class=style1></span></td>
 
  </tr>
  <tr>
    <td ><span class=style7>No SO</span></td>
    <td><span class=style1>:</span></td>
    <td colspan=2 class='thickBorder'>---</td>
    <td>&nbsp;</td>
    <td colspan=2>&nbsp;</td>
  </tr>
  <tr>
    
    <td colspan=2><span class=style4>(Wajib diisi untuk projet)</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	 <td>&nbsp;</td>
    
  </tr>
  <tr>
    <td><span class=style1>Untuk Keperluan</span></td>
    <td><span class=style1>:</span></td>
    <td colspan=3 class='thickBorder'><span class=style1>$data[tKBRemark]</span></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class=style1>Jumlah</span></td>
    <td><span class=style1>:</span></td>
    <td class='thickBorder'><span class=style1>$mKBamount</span></td>
    <td rowspan=2><span class=style1>&nbsp;Terbilang :</span></td>
    <td rowspan=2 class='thickBorder'><div align='left'><span class=style1>$terbilang</span></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class=style1>Valas</span></td>
    <td><span class=style1>:</span></td>
    <td class='thickBorder'><span class=style1>$Currency[cCurrencyCode]</span></td>
   <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan=6 valign='bottom'>
     </table>
		
	</br>
		<hr />

		<table width='900' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <th width='430' scope='col'><div align='right'></div></th>
    <th width='10' scope='col'>&nbsp;</th>
    <th width='460'><div align='right' class=style1>FO-014-HLD Rev.0 - Mar 12</div></th>
  </tr>
  <tr>
    <td colspan='3'><div align='center' class=style3><strong>PERJALANAN DINAS</strong></div></td>
  </tr>
  <tr>
    <td colspan='3'><div align='center' class=style3><strong>DALAM NEGERI / LUAR NEGERI / DETACHING</strong></div></td>
  </tr>
  <tr>
    <td><strong>$Com[NamaCompany]</strong></td>
    <td>&nbsp;</td>
    <td><strong>No: $sqli[iUHPDNo]</strong></td>
  </tr>
  <tr>
    <td colspan='3' valign='bottom'></br>
	<table width='900' class=table1 cellspacing=0 border=0 bordercolor=#000000>
      <tr>
        <td width='10'>&nbsp;</td>
        <td width='124'><span class=style1><div align='left'>Nama</div></span></td>
        <td width='9'><div align=center>:</div></td>
        <td width='296' class='thickBorderRight'><span class=style1><div align='left'>$sqli[cUHPDUser]</span></div></td>
        <td width='9'>&nbsp;</td>
        <td width='153'><span class=style1><div align='left'>Tujuan</div></span></td>
        <td width='9'>:</td>
        <td width='278' class='thickBorder'><div align='left'><span class=style1>$sqli[cUHPDTujuan]</div></td>
        <td width='10'>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><span class=style1>NIK</td>
        <td><div align='center'>:</div></td>
       <td class='thickBorderRight'><span class=style1>$sqli[iUHPDNIK]</td>
        <td>&nbsp;</td>
        <td><span class=style1>Transport</td>
        <td>:</td>
        <td class='thickBorder'><span class=style1>$sqli[cUHPDTransport]</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><span class=style1>Jabatan</td>
        <td><div align='center'>:</div></td>
        <td class='thickBorderRight'><span class=style1>$Jobs[NamaJabatan]</span></td>
        <td>&nbsp;</td>
        <td><span class=style1>Beban Proyek / SO No.</td>
        <td>:</td>
        <td class='thickBorder'>$sqli[cUHPDBebanProyek]</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><span class=style1>Band</td>
        <td><div align='center'>:</div></td>
        <td class='thickBorderRight'><span class=style1>$sqli[iUHPDBand]</span></td>
        <td>&nbsp;</td>
        <td><span class=style1>Beban Divisi</td>
        <td>:</td>
         <td class='thickBorder'><span class=style1>$sqli[cUHPDBebanDivisi]</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class='thickBorder'>&nbsp;</td>
        <td class='thickBorder'><span class=style1>Div / Dept / Unit</td>
        <td class='thickBorder'><div align='center'>:</div></td>
         <td class='thickBorderRight'><span class=style1>$Deptku[cDeptName]</span></td>
        <td class='thickBorder'>&nbsp;</td>
        <td class='thickBorder'>&nbsp;</td>
        <td class='thickBorder'>&nbsp;</td>
        <td class='thickBorder'>&nbsp;</td>
        <td class='thickBorder'>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan='2' rowspan='2' class='thickBorderRight'><span class=style1>Tgl / Jam Berangkat</td>
        <td class='thickBorderRight'><span class=style1>&nbsp;Rencana : $dUHPDActive1</span></td>
        <td>&nbsp;</td>
        <td colspan='2' rowspan='2' class='thickBorderRight'><span class=style1>Tgl / Jam Kembali</td>
         <td class='thickBorder'><span class=style1>&nbsp;Rencana : $dUHPDActive2</span></td>
        <td class='thickBorder'>&nbsp;</td>
      </tr>
      <tr>
        <td class='thickBorder'>&nbsp;</td>
         <td class='thickBorderRight'><span class=style1>&nbsp;Realisasi : </span></td>
        <td class='thickBorder'>&nbsp;</td>
        <td class='thickBorder'><span class=style1>&nbsp;Realisasi : </td>
        <td class='thickBorder'>&nbsp;</td>
      </tr>
      <tr>
        <td height='89'>&nbsp;</td>
        <td valign='top'><span class=style1>Rencana Pekerjaan</td>
        <td valign='top'><div align='center'>:</div></td>
        <td colspan='5' valign='top'><span class=style1><p>$sqli[tUHPDRemark]</p>
          </td>
        <td>&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
</table>
</br>
<hr />



<table width='900' border='0' cellspacing='0' cellpadding='0' >
  <tr>
    <th class=style3>REALISASI</th>
  </tr>
  <tr>
    <td valign='bottom'></br>
	<table width='900' border=2 cellpadding=0 cellspacing=0 bordercolor=#000000 frame=border>
      <tr>
        <td colspan='4' class='thickBorder'><div align='center'><strong>Realisasi Pekerjaan Yang Dilakukan</strong></div></td>
        </tr>
      <tr>
        <td class='thickBorderRight' width='26' bgcolor='#CCCCCC'><div align='center'>No.</td>
        <td class='thickBorderRight' width='106' bgcolor='#CCCCCC'><div align='center'>Tanggal</div></dh>
        <td class='thickBorderRight' width='299' bgcolor='#CCCCCC'><div align='center'>Lokasi</div></td>
        <td class='thickBorder' width='469' bgcolor='#CCCCCC'><div align='center'>Uraian Pekerjaan</div></td>
        </tr>
      <tr>
        <td class='thickBorderRight'><div align='center'>&nbsp;</div></td>
		<td class='thickBorderRight'><div align='center'>&nbsp;</div></td>
        <td class='thickBorderRight'>&nbsp;</td>
        <td class='thickBorder'>&nbsp;</td>
        </tr>
      <tr>
        <td class='thickBorderRight'><div align='center'>&nbsp;</div></td>
        <td class='thickBorderRight'><div align='center'>&nbsp;</div></td>
        <td class='thickBorderRight'>&nbsp;</td>
        <td class='thickBorder'>&nbsp;</td>
        </tr>
	<tr>
        <td class='thickBorderRight'><div align='center'>&nbsp;</div></td>
        <td class='thickBorderRight'><div align='center'>&nbsp;</div></td>
        <td class='thickBorderRight'>&nbsp;</td>
        <td class='thickBorder'>&nbsp;</td>
        </tr>
		
		<tr>
        <td class='thickBorderRight'><div align='center'>&nbsp;</div></td>
        <td class='thickBorderRight'><div align='center'>&nbsp;</div></td>
        <td class='thickBorderRight'>&nbsp;</td>
        <td class='thickBorder'>&nbsp;</td>
        </tr>
		
		<tr>
        <td class='thickBorderRight'><div align='center'>&nbsp;</div></td>
        <td class='thickBorderRight'><div align='center'>&nbsp;</div></td>
        <td class='thickBorderRight'>&nbsp;</td>
        <td class='thickBorder'>&nbsp;</td>
        </tr>
		
		<tr>
        <td class='thickBorderRight'><div align='center'>&nbsp;</div></td>
        <td class='thickBorderRight'><div align='center'>&nbsp;</div></td>
        <td class='thickBorderRight'>&nbsp;</td>
        <td class='thickBorder'>&nbsp;</td>
        </tr>
      
    </table></td>
  </tr>
</table>
</br>
<hr />


	<table width='900' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <th class=style3>PERJALANAN DINAS</th>
  </tr>
  <tr>
    <td><table width='900' border='2' cellspacing='0' cellpadding='0' bordercolor=#000000 frame=border>
      <tr>
        <td colspan='10' bgcolor='#CCCCCC'><div align='center'><strong>Biaya Trasport</strong></div></td>
        </tr>
      <tr>
        <td width='120'>&nbsp;</td>
        <td width='125'><div align='center'>Perkiraan</div></td>
        <td width='1'>&nbsp;</td>
        <td colspan='7' ><div align='center'>Realisasi</div></td>
        </tr>
      <tr>
        <td>&nbsp;Tgl</td>
        <td>&nbsp;$dUHPDAct1 - $dUHPDAct2</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width=80><div align='center'>Total</div></td>
      </tr>
      
	 <tr><td>&nbsp;$da[CostTransName]</td>
		<td>&nbsp;$TransPerkiraan</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
        <td>&nbsp;</td></tr>
      <tr>
        <td>&nbsp;Keterangan</td>
        <td colspan='9'>&nbsp;$sqltrans[TransKeterangan]</td>
        </tr>
    </table></td>
  </tr>
  
 

 
  <tr>
    <td><table width='900' border='2' cellspacing='0' cellpadding='0' bordercolor=#000000 frame=border>
      <tr>
        <th colspan='10' bgcolor='#CCCCCC'>Biaya Harian</th>
        </tr>
      <tr>
        <td width='120'>&nbsp;</td>
        <td width='125'><div align='center'>Perkiraan</div></td>
        <td width='1'>&nbsp;</td>
        <td colspan='7'><div align='center'>Realisasi</div></td>
        </tr>
      <tr>
        <td>&nbsp;Tgl</td>
        <td>&nbsp;$dUHPDAct1 - $dUHPDAct2</td>
        <td>&nbsp;</td>
        <td width='81'>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width='80'><div align='center'>Total</div></td>
      </tr>
	  <tr><td>&nbsp;$di[CostDayName]</td>
		<td>&nbsp;$DaysPerkiraan</td>
		<td></td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

	</tr><tr>
        <td>&nbsp;Keterangan</td>
        <td colspan='9'>&nbsp;$sqltrans[TransKeterangan]</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width='900' border='0' cellspacing='0' cellpadding='0'>
      <tr>
        <th width='128'>Total Biaya :</th>
        <th width='128'>Perkiraan</th>
        <th width='35'><div align='left'>Rp.</div></th>
        <th width='200'><div align='left'>$mKBamount</div></th>
        <th width='100'>Realisasi</th>
        <th width='34'><div align='left'>Rp.</div></th>
        <th width='200'><div align='left'></div></th>
		 <th width='134'><div align='left'></div></th>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align='left'>US$</div></td>
        <td class='thickBorder'>&nbsp;</td>
        <td>&nbsp;</td>
        <td>US$</td>
        <td class='thickBorder'>&nbsp;</td>
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
		 <td>&nbsp;</td>
      </tr>
    </table>
	<p>Saya akan mempertanggungjawabkan seluruh pengeluaran dalam waktu 7 (tujuh) hari kerja setelah selesainya perjalanan dinas</p>
	</td>
  </tr>
  <tr>
    <td><table width='900' border='2' cellspacing='0' cellpadding='0' bordercolor=#000000 frame=border>
      <tr>
        <th colspan='5'>Berangkat</th>
        <th colspan='5'>Kembali</th>
        </tr>
      </tr>
	  <tr>
        <td><div align='center'>$firstname</div></td><td><div align=center>$firstname</div></td>
		
		</tr>
    </table></td>
  </tr>
</table>
		
		
		</div></body>";

?>