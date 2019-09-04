<script src="https://apps.unias.com/hris2/assets/highcharts/js/jquery.min.js" type="text/javascript"></script>
<script src="https://apps.unias.com/hris2/assets/highcharts/js/highcharts.js" type="text/javascript"></script>


<?php

include "../../includes/koneksi/koneksi.php";
$company_id = $_GET['company'];

if (!is_null($_GET['pt']) && !is_null($_GET['div']) && !is_null($_GET['dept']) && !is_null($_GET['from']) && !is_null($_GET['to'])){

	//$From			= $_GET['from'];
	//$Until			= $_GET['to'];
	$Company		= $company_id;
	$Division		= $_GET['div'];
	$Dept   		= $_GET['dept'];

	$From    = $_GET['from'];
	$dd      = substr($From,0,2);
	$mm      = substr($From,3,2);
	$yyyy    = substr($From,6,4);


	$To      = $_GET['to'];
	$dd_2    = substr($To,0,2);
	$mm_2    = substr($To,3,2);
	$yyyy_2  = substr($To,6,4);

		
	}
	else {
		$month = '';
	}


	//echo $dd.'*'.$mm.'*'.$yyyy.'<br/>';

	//echo $dd_2.'*'.$mm_2.'*'.$yyyy_2;

	
	//$find1  = $yyyy.'-'.$mm.'-'.$dd.'<br/>';
	//$find2  = $yyyy_2.'-'.$mm_2.'-'.$dd_2.'<br/>';


	//$find1  = $yyyy.'-'.$mm.'<br/>';
	//	$find2  = $yyyy_2.'-'.$mm_2.'<br/>';


	$find1 = date('Y-m', strtotime($_GET['from']));
	$find2 = date('Y-m', strtotime($_GET['to']));

	$title1 = date('M Y', strtotime($_GET['from']));
	$title2 = date('M Y', strtotime($_GET['to']));

	//echo $find1;
	//echo $find2;
/*
	if ($Division == "0"){
		$DivisionId = '>0';
		//$title1   = 'Semua Divisi';
	}
	else {
		$kDiv 	= mysql_fetch_array(mysql_query("SELECT * FROM tbdiv WHERE iDivId=$Division"));
		$DivisionId   ='='.$Division;
		//$title1 = $kDiv['cDivName'];
	}
	
*/

		$sql ="SELECT tbl_formcutidetail.TglCuti AS TglCuti,count(tbl_formcutidetail.TglCuti) AS Jumlah FROM tbl_formcutidetail JOIN 
		tbl_formcuti ON tbl_formcutidetail.CutiId=tbl_formcuti.CutiId JOIN tbl_profile ON tbl_formcuti.FormCutiNIK=tbl_profile.NIK ";

		$sql .=" WHERE DATE_FORMAT(tbl_formcutidetail.TglCuti,'%Y-%m') >= '".$find1."' AND 
			  DATE_FORMAT(tbl_formcutidetail.TglCuti,'%Y-%m') <='".$find2."' AND 
			  tbl_formcuti.StatusForm='A'";

		if ($Company==0){
			$Judul1 = 'ALL Company';
			$sql .=" AND tbl_profile.CompanyId >0";
		}else{
			$kCom = mysql_fetch_array(mysql_query("SELECT * FROM tbl_company WHERE iCompanyId=$Company"));
			$Judul1 = $kCom['cCompanyName'];			
			$sql .=" AND tbl_profile.CompanyId ='".$Company."'";
		}

		if ($Division==0){
			$Judul2 = 'ALL Division';
			$sql .=" AND tbl_profile.DivisiID >0";
		}else{
			$kDiv = mysql_fetch_array(mysql_query("SELECT * FROM tbl_div WHERE iDivId=$Division"));
			$Judul2 = $kDiv['cDivName'];			
			$sql .=" AND tbl_profile.DivisiID ='".$Division."'";
		}

		if ($Dept==0){
			$Judul3 = 'ALL Department';
			$sql .=" AND tbl_profile.DeptID >0";
		}else{
			$kDept = mysql_fetch_array(mysql_query("SELECT * FROM tbl_dept WHERE iDeptID=$Dept"));
			$Judul3 = $kDept['cDeptName'];			
			$sql .=" AND tbl_profile.DeptID ='".$Dept."'";
		}  

		$sql .=" GROUP BY  DATE_FORMAT(tbl_formcutidetail.TglCuti,'%Y-%m') ORDER BY tbl_formcutidetail.TglCuti ASC ";


echo '<H4  align="center">'.$Judul1.' &#8594; '.$Judul2.' &#8594; '.$Judul3.'</H4>';
//$min = mysql_fetch_array(mysql_query("SELECT min(iPeriodId) AS Start FROM (SELECT iPeriodId,YEAR(dPeriodStartDate) AS Tahun,dPeriodStartDate FROM tbPeriod) AS Yer WHERE Tahun='$ThnMin'"));
//$max = mysql_fetch_array(mysql_query("SELECT max(iPeriodId) AS Finish FROM (SELECT iPeriodId,YEAR(dPeriodStartDate) AS Tahun,dPeriodStartDate FROM tbPeriod) AS Yer WHERE Tahun='$ThnMax'"));

//$sql = "SELECT TglCuti,count(DetailCutiId) AS Jumlah FROM tbl_formcutidetail WHERE MONTH(TglCuti) >= MONTH($find1) AND MONTH(TglCuti) <= MONTH($find2) GROUP BY TglCuti ORDER BY TglCuti ASC";	
//$sql .= "";

//$sql .= "GROUP BY TglCuti ORDER BY CutiId";

echo"<script type='text/javascript'>
	var chart1; // globally available
$(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'container',
            type: 'column'
         },   
         title: {
            text: 'Grafik Cuti $title1 s/d $title2'
         },
         xAxis: {
            categories: ['Bulan']
         },
         yAxis: {
            title: {
               text: 'Jumlah Cuti (Hari)'
            }
         },
              series:             
            [";		
		
		
           
            //$query = mysql_query($sql);
        
        
		

		/*
		$query = mysql_query("SELECT tbl_formcutidetail.TglCuti AS TglCuti,count(tbl_formcutidetail.TglCuti) AS Jumlah FROM tbl_formcutidetail JOIN 
		tbl_formcuti ON tbl_formcutidetail.CutiId=tbl_formcuti.CutiId 
		WHERE DATE_FORMAT(tbl_formcutidetail.TglCuti,'%Y-%m') >= '$find1' AND DATE_FORMAT(tbl_formcutidetail.TglCuti,'%Y-%m') <='$find2' AND StatusForm='A' GROUP BY  DATE_FORMAT(tbl_formcutidetail.TglCuti,'%Y-%m') ORDER BY tbl_formcutidetail.TglCuti ASC ");

	*/
            $noe = 1;
            $query = mysql_query($sql);
            $total = mysql_num_rows($query);



            while($ret = mysql_fetch_array($query)){
				//$sqlday = mysql_fetch_array(mysql_query("SELECT * FROM tbPeriod"));
            	$time1 = date('Y-m', strtotime($ret['TglCuti']));
            	//echo $time1;
            	//$time2 = date('Y-m-d', strtotime($sqlday['dPeriodEndDate']));
				
			/*
				//$merek = $dPeriodStartDate;				
                $sql_jumlah   = "SELECT TglCuti,count(tbl_formcutidetail.TglCuti) AS Jml FROM tbl_formcutidetail JOIN tbl_formcuti ON tbl_formcutidetail.CutiId=tbl_formcuti.CutiId 
                				 WHERE DATE_FORMAT(tbl_formcutidetail.TglCuti,'%Y-%m') ='$time1' AND StatusForm='A' 
                				 GROUP BY  DATE_FORMAT(TglCuti,'$time1')";	
				
				 
				 $query_jumlah = mysql_query($sql_jumlah);
                 $data = mysql_fetch_array($query_jumlah);
                    //$jumlah = $data['Jml'];
                               
                 // }

            */
                  $jumlah 	= $ret['Jumlah'];
                  $merek 	= date("M-Y", strtotime($ret['TglCuti']));

                  ?>
                  {
                      name: '<?php echo $merek; ?>',
                      data: [<?php echo $jumlah; ?>],
                  },

                  <?php $noe++; } 
            echo "]
      });
   });	
</script>
<div id='container'></div>";		




?>
