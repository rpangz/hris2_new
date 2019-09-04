<?php
      define('db_host','172.17.0.16');
      define('db_user','operator');
      define('db_pass','$M15.apps@admin16');
      define('db_name','hris2');
  
      mysql_connect(db_host,db_user,db_pass);
      mysql_select_db(db_name);

?>

<script src="../assets/highcharts/js/highcharts1.js" type="text/javascript"></script>
<script src="../assets/highcharts/js/exporting1.js" type="text/javascript"></script>

<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Grafik Hits To Application'
        },
        xAxis: {
            categories: [

            <?php
           $sql   = "SELECT hits_date FROM tbl_hits GROUP BY DATE_FORMAT(hits_date,'%Y-%m-%d') ORDER BY hits_date ASC";
           $query = mysql_query($sql);
          while( $data = mysql_fetch_array( $query ) ){
            $type = date('d-M-Y', strtotime($data['hits_date']));
            $hari = date('N', strtotime($data['hits_date']));
            //$type  =$data['hits_date'];
            if ($hari==1){$nHari='Senin';}
            elseif ($hari==2){$nHari='Selasa';}
            elseif ($hari==3){$nHari='Rabu';}
            elseif ($hari==4){$nHari='Kamis';}
            elseif ($hari==5){$nHari='Jumat';}
            elseif ($hari==6){$nHari='Sabtu';}
            elseif ($hari==7){$nHari='Minggu';}
            else {$nHari='No Days';}

           echo "'".$nHari.", ".$type."',";
           
            }

           ?>

           ]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total Hits to Applications'
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
            name: 'Hits',
            data: [


            <?php 
            $sql_in   = "SELECT hits_date FROM tbl_hits GROUP BY DATE_FORMAT(hits_date,'%Y-%m-%d') ORDER BY hits_date ASC";
            $query = mysql_query($sql_in);
            while( $dt = mysql_fetch_array( $query ) ){
            //$no=$dt['iPeriodId'];
            $no = date('Y-m-d', strtotime($dt['hits_date']));

            //echo $no;

            $sql_jumlah = "SELECT count(hits_id) As jumlah FROM tbl_hits WHERE DATE_FORMAT(hits_date,'%Y-%m-%d') = '$no'";        
            $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
            while( $data = mysql_fetch_array( $query_jumlah ) ){
            $jumlah = $data['jumlah'];
                    
                    echo $jumlah.',';

            }
            }
            ?>



            ]
        }, ]
    });
});  
</script>
    <div id='container'></div>
    </br>