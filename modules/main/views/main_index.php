<style media="all" type="text/css">

    .datewidget {
        margin-top:10%;
        min-width:25%;
    }
    .time {
        font-family:Tahoma, Geneva, sans-serif;
        text-align:right;
        font-size:24px;
        color:#0099FF;
        font-weight:bold;
    }
    .headtime {
        font-size:16px;
        text-align:right;
        text-transform:uppercase;
        color:#036;
        font-weight:bold;
    }


 

</style>

<script type="text/javascript">
	function clickIE4(){
	if (event.button==2){
	return false;
	}
	}
	function clickNS4(e){
	if (document.layers||document.getElementById&&!document.all){
	if (e.which==2||e.which==3){
	return false;
	}
	}
	}
	if (document.layers){
	document.captureEvents(Event.MOUSEDOWN);
	document.onmousedown=clickNS4;
	}
	else if (document.all&&!document.getElementById){
	document.onmousedown=clickIE4;
	}
	document.oncontextmenu=new Function("return false")
	function disableselect(e){
	return false
	}
	function reEnable(){
	return true
	}
	//if IE4+
	document.onselectstart=new Function ("return false")
	//if NS6
	if (window.sidebar){
	document.onmousedown=disableselect
	document.onclick=reEnable
	}
</script>

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
$jam   = date("H");
$detik = date("i");
if ($jam >= 00 && $jam <=11 && $detik >= 0){
	$salam='Pagi';
	}
if ($jam >= 11 && $jam <=15 && $detik >= 0){
	$salam='Siang';
	}
if ($jam >= 15 && $jam <=18 && $detik >= 0){
	$salam='Sore';
	}
if ($jam >= 18 && $jam <=24 && $detik >= 0){
	$salam='Malam';
	}
*/

//$data['user_id'] = $this->session->userdata('user_id');
//$session_nik = {{ user_id }};

//echo $data['user_id'].'DOM';


function greeting(){

$jam   = date("H");
$detik = date("i");

if ($jam >= 00 && $jam <=11 && $detik >= 0){
	return $salam='Pagi';
}
if ($jam >= 11 && $jam <=15 && $detik >= 0){
	return $salam='Siang';
}
if ($jam >= 15 && $jam <=18 && $detik >= 0){
	return $salam='Sore';
}
if ($jam >= 18 && $jam <=24 && $detik >= 0){
	return $salam='Malam';
}

}


function my_profile2(){      
        $result 	= mysql_query("SELECT * FROM tbl_profile WHERE NIK='".$_SESSION['NIK']."'");
        $row    	= mysql_fetch_array($result);
        $num_rows 	= mysql_num_rows($result);

        return $row['Nama'];    
}

function my_profile(){
      
        $result = mysql_query("SELECT * FROM tbl_profile WHERE NIK=".$_SESSION['NIK']);
        $storeArray = Array();
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

        	if ($row['Sex'] == 'L'){
        		$call = 'Bapak';

        	}else{
        		$call = 'Ibu';
        	}

            $storeArray['nama'] =  $row['Nama'];
            $storeArray['sex'] =  $row['Sex'];
            $storeArray['call'] =  $call;

        }

        return $storeArray;     
    
}

$my_profile = my_profile();

$datalogin   = mysql_fetch_array(mysql_query("SELECT * FROM tbl_main_user WHERE user_id='{{ user_id }}'"));
$real_name = $datalogin['real_name'];

$name = $my_profile['nama'];
$call = $my_profile['call'];

//echo $real_name;



?>


<!--<h3><?php //echo 'Selamat '.greeting().', '.$name; ?></h3><h4>Anda Sedang berada di Human Resource Information System Version 2.0 - ASTEL Group </h4>-->

<h3><?php echo 'Selamat '.greeting(); ?> {{ user_name }}, </h3><h4>Anda Sedang berada di Human Resource Information System Version 2.0 - ASTEL Group </h4>



<!--<h2><?php //echo 'Selamat '.$salam ?> {{ user_name }}, <br/><br/>Anda Sedang berada di Human Resource Information System</h2>-->

<?php //include "graph/Graph_bpjs.php"; ?>
<?php
	//echo $submenu_screen;

?>
<br/>
<br/>


<?php

$hari_ini 	= date ("Y-m-d");
$lalu       = strtotime($hari_ini);
$today      = date ('Y-m-d',strtotime('+1 month',$lalu));
$date 		= date ("Y-m-d");

/*
$sql 	    = "SELECT tbl_hakcuti.NIK AS NIK,
						tbl_profile.Nama AS Nama,
						tbl_hakcuti.Periode1 AS Periode1,
						tbl_hakcuti.Periode2 AS Periode2,
						tbl_hakcuti.PeriodeKerja1 AS PeriodeKerja1,
						tbl_hakcuti.PeriodeKerja2 AS PeriodeKerja2,
						tbl_profile.CompanyId AS CompanyId,
						tbl_hakcuti.JenisHakCuti AS JenisHakCuti,
						(tbl_hakcuti.Qty-count(tbl_formcutidetail.TglCuti)) AS Sisa 
				FROM `tbl_hakcuti` INNER JOIN 
				tbl_profile ON tbl_hakcuti.NIK = tbl_profile.NIK INNER JOIN 
				tbl_formcuti ON tbl_hakcuti.Hakid=tbl_formcuti.HakCutiId 
				INNER JOIN tbl_formcutidetail ON tbl_formcuti.CutiId=tbl_formcutidetail.CutiId 
				WHERE tbl_profile.bStatus=1 AND tbl_hakcuti.JenisHakcuti <=2 
				AND Periode2 ='$today' 
				AND PeriodeExt IS NULL 
				AND tbl_hakcuti.NIK = '$_SESSION[NIK]' AND 
				(tbl_formcuti.StatusForm='A' OR tbl_formcuti.StatusForm IS NULL) 
				ORDER BY tbl_hakcuti.HakId ASC";
*/

$sql 	    = "select *,(Qty-count(TglCuti)) AS Sisa,
						@rownum:=@rownum+1 'Nomor',
						tbl_hakcuti.NIK AS NIK,
						tbl_profile.Nama AS Nama,
						tbl_hakcuti.Periode1 AS Periode1,
						tbl_hakcuti.Periode2 AS Periode2,
						tbl_hakcuti.PeriodeKerja1 AS PeriodeKerja1,
						tbl_hakcuti.PeriodeKerja2 AS PeriodeKerja2,
						tbl_profile.CompanyId AS CompanyId,
						tbl_hakcuti.JenisHakCuti AS JenisHakCuti
from tbl_hakcuti LEFT JOIN tbl_formcuti ON tbl_hakcuti.Hakid=tbl_formcuti.HakCutiId LEFT JOIN tbl_formcutidetail ON tbl_formcuti.CutiId=tbl_formcutidetail.CutiId INNER JOIN tbl_profile ON tbl_profile.NIK=tbl_hakcuti.NIK , (SELECT @rownum:=0) r 
WHERE tbl_hakcuti.NIK='$_SESSION[NIK]' AND (tbl_formcuti.StatusForm='A' OR tbl_formcuti.StatusForm IS NULL) AND JenisHakCuti <='2' AND 
Periode2 ='$today' AND PeriodeExt IS NULL  
GROUP BY HakId 
Having Sisa > 0";

/*
$sql 	    = "select *,(Qty-count(TglCuti)) AS Sisa,@rownum:=@rownum+1 'Nomor',
tbl_hakcuti.NIK AS NIK,
						tbl_profile.Nama AS Nama,
						tbl_hakcuti.Periode1 AS Periode1,
						tbl_hakcuti.Periode2 AS Periode2,
						tbl_hakcuti.PeriodeKerja1 AS PeriodeKerja1,
						tbl_hakcuti.PeriodeKerja2 AS PeriodeKerja2,
						tbl_profile.CompanyId AS CompanyId,
						tbl_hakcuti.JenisHakCuti AS JenisHakCuti
from tbl_hakcuti LEFT JOIN tbl_formcuti ON tbl_hakcuti.Hakid=tbl_formcuti.HakCutiId LEFT JOIN tbl_formcutidetail ON tbl_formcuti.CutiId=tbl_formcutidetail.CutiId INNER JOIN tbl_profile ON tbl_profile.NIK=tbl_hakcuti.NIK , (SELECT @rownum:=0) r 
WHERE tbl_hakcuti.NIK='$_SESSION[NIK]' AND (tbl_formcuti.StatusForm='A' OR tbl_formcuti.StatusForm IS NULL) AND JenisHakCuti <='2' AND ((Periode1 <= '$today' 
       AND PeriodeExt IS NULL AND Periode2 >='$today') OR (Periode1 <= '$today' AND PeriodeExt IS NOT NULL AND PeriodeExt >='$today')) 
GROUP BY HakId 
Having Sisa > 0"; 
*/
				
$query 		= mysql_query($sql);
$total 	    = mysql_num_rows($query);

if ($total >0){
	//echo '* Masa Berlaku Hak Cuti Anda akan Habis, Silahkan diperpanjang...';
	//echo '<br/><p/>';

	echo "<div class='alert alert-danger'>
	<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
	<strong>Warning!</strong> Masa Berlaku Hak Cuti Anda akan Habis, Silahkan diperpanjang...
	<br/><p/>
	<table width='100%' border=1 cellpadding=2 cellspacing=0 frame=border>		
			<th><div align='center'>No</div></th>
			<th><div align='center'>NIK</div></th>
			<th><div align='center'>Nama</div></th>
			<th><div align='center'>Periode 1</div></th>
			<th><div align='center'>Periode 2</div></th>
			<th><div align='center'>Jenis Cuti</div></th>
			<th><div align='center'>Sisa Cuti</div></th>
			<th><div align='center'>Perusahaan</div></th>							
			</tr>";
	
	
		
	$no	 =1;
while ($row = mysql_fetch_array($query)){	
	
	$cm	    = mysql_fetch_array(mysql_query("SELECT * FROM tbl_company WHERE iCompanyId = $row[CompanyId]"));	
	$NIK	= $row['NIK'];

	$jcm	= mysql_fetch_array(mysql_query("SELECT * FROM tbl_jeniscuti WHERE id = $row[JenisHakCuti]"));
	
	if ($no%2==0){$Vcolor="bgcolor='#FFFFFF'";}else{$Vcolor="bgcolor='#F5F5F5'";}	
	$Periode1	= date('d-M-Y', strtotime($row['Periode1']));
	$Periode2	= date('d-M-Y', strtotime($row['Periode2']));
	
	echo "<tr>
				<td $Vcolor><div align='center'>$no</div></td>
				<td $Vcolor><div align='center'>$row[NIK]</div></td>
				<td $Vcolor><div align='center'>$row[Nama]</div></td>
				<td $Vcolor><div align='center'>$Periode1</div></td>
				<td $Vcolor><div align='center'><b>$Periode2</b></div></td>
				<td $Vcolor><div align='center'>$jcm[JenisCutiName]</div></td>
				<td $Vcolor><div align='center'>$row[Sisa] Hari</div></td>
				<td $Vcolor><div align='center'>$cm[cCompanyName]</div></td>
			</tr>";
	
	$no++;
		
	
	}
		
	echo '</table></div>';

}



?>

