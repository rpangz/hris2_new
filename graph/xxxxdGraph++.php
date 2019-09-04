<?php 

define('db_host','portal');
      define('db_user','root');
      define('db_pass','asa');
      define('db_name','imam2');
  
      mysql_connect(db_host,db_user,db_pass);
      mysql_select_db(db_name);

  ?>

<script src='js2/jquery.min.js' type='text/javascript'></script>
<script src="js2/highcharts.js" type="text/javascript"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">

var chart1; // globally available
$(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'container',
            type: 'column'
         },   
         title: {
            text: 'Grafik Stok Assets'
         },
         xAxis: {
            categories: ['Type']
         },
         yAxis: {
            title: {
               text: 'Jumlah (pcs)'
            }
         },
              series:             
            [
            <?php 
        
        	


           $sql   = "SELECT iTypeID,cTypeName FROM tbl_type WHERE iTypeID >0";
            $query = mysql_query( $sql )  or die(mysql_error());
            while( $ret = mysql_fetch_array( $query ) ){
            	$merek=$ret['iTypeID'];
            	$jdl=$ret['cTypeName'];

                 $sql_jumlah   = "SELECT count(iStokType) As jumlah FROM tbl_stock WHERE iStokType='$merek' AND iStokType >0";        
                 $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
                 while( $data = mysql_fetch_array( $query_jumlah ) ){
                    $jumlah = $data['jumlah'];                 
                  }             
                  ?>
                  {
                      name: '<?php echo $jdl; ?>',
                      data: [<?php echo $jumlah; ?>]
                  },
                  <?php } ?>
            ]
      });
   });	
</script>

<script type="text/javascript">
var chart2; // globally available
$(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'container2',
            type: 'column'
         },   
         title: {
            text: 'Grafik Transaksi Out'
         },
         xAxis: {
            categories: ['Bulan']
         },
         yAxis: {
            title: {
               text: 'Jumlah Transaksi Out'
            }
         },
              series:             
            [
            <?php 
        	//include('config.php');

        	


           $sql   = "SELECT iPeriodId,cPeriodName FROM tbl_periode WHERE iPeriodId >1";
            $query = mysql_query( $sql )  or die(mysql_error());
            while( $ret = mysql_fetch_array( $query ) ){
            	$merek=$ret['iPeriodId'];
            	$jdl=$ret['cPeriodName'];

                 $sql_jumlah   = "SELECT count(iTransPeriodId) As jumlah FROM tbl_trans WHERE iTransPeriodId='$merek'";        
                 $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
                 while( $data = mysql_fetch_array( $query_jumlah ) ){
                    $jumlah = $data['jumlah'];                 
                  }             
                  ?>
                  {
                      name: '<?php echo $jdl; ?>',
                      data: [<?php echo $jumlah; ?>]
                  },
                  <?php } ?>
            ]
      });
   });	
</script>



		<div id='container'></div>
		</br>	
		<div id='container2'></div>
  </br>


  <script type="text/javascript">
$(function () {
    $('#container3').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Stacked bar chart'
        },
        xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total fruit consumption'
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2]
        }, {
            name: 'Jane',
            data: [2, 2, 3, 2, 1]
        }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5]
        }]
    });
});
</script>


  <div id="container3"></div>   



   