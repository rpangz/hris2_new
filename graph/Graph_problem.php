<?php 

      define('db_host','portal');
      define('db_user','root');
      define('db_pass','asa');
      define('db_name','imam2');
  
      mysql_connect(db_host,db_user,db_pass);
      mysql_select_db(db_name);

  ?>
  
<script src="../js2/highcharts1.js"></script>
<script src="../js2/exporting1.js"></script>



<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Grafik Problem'
        },
        xAxis: {
            categories: [

            <?php
           $sql   = "SELECT iPeriodId,cPeriodName FROM tbl_periode WHERE iPeriodId >=43 ORDER BY iPeriodId DESC";
           $query = mysql_query($sql);
           while( $data = mysql_fetch_array( $query ) ){
            $type  =$data['cPeriodName'];

           echo "'".$type."',";
           
            }

           ?>



            ]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total'
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
            name: 'Application',
            data: [

            <?php 
            $sql_in   = "SELECT iPeriodId,cPeriodName FROM tbl_periode WHERE iPeriodId >=43 ORDER BY iPeriodId DESC";
            $query = mysql_query($sql_in);
            while( $dt = mysql_fetch_array( $query ) ){
            $no=$dt['iPeriodId'];

            $sql_jumlah = "SELECT count(prob_no) As jumlah FROM tbl_problem WHERE prob_periode='$no' AND prob_type=1";        
            $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
            while( $data = mysql_fetch_array( $query_jumlah ) ){
            $jumlah_0 = $data['jumlah'];
                    
                    echo $jumlah_0.',';

            }
            }
            ?>



            ]
        }, {
            name: 'Software',
            data: [

            <?php 
            $sql_in   = "SELECT iPeriodId,cPeriodName FROM tbl_periode WHERE iPeriodId >=43 ORDER BY iPeriodId DESC";
            $query = mysql_query($sql_in);
            while( $dt = mysql_fetch_array( $query ) ){
            $no=$dt['iPeriodId'];

            $sql_jumlah = "SELECT count(prob_no) As jumlah FROM tbl_problem WHERE prob_periode='$no' AND prob_type=2";        
            $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
            while( $data = mysql_fetch_array( $query_jumlah ) ){
            $jumlah_0 = $data['jumlah'];
                    
                    echo $jumlah_0.',';

            }
            }
            ?>


            ]
        },{
            name: 'Email',
            data: [

            <?php 
            $sql_in   = "SELECT iPeriodId,cPeriodName FROM tbl_periode WHERE iPeriodId >=43 ORDER BY iPeriodId DESC";
            $query = mysql_query($sql_in);
            while( $dt = mysql_fetch_array( $query ) ){
            $no=$dt['iPeriodId'];

            $sql_jumlah = "SELECT count(prob_no) As jumlah FROM tbl_problem WHERE prob_periode='$no' AND prob_type=3";        
            $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
            while( $data = mysql_fetch_array( $query_jumlah ) ){
            $jumlah_0 = $data['jumlah'];
                    
                    echo $jumlah_0.',';

            }
            }
            ?>


            ]
        },{
            name: 'Internet',
            data: [

            <?php 
            $sql_in   = "SELECT iPeriodId,cPeriodName FROM tbl_periode WHERE iPeriodId >=43 ORDER BY iPeriodId DESC";
            $query = mysql_query($sql_in);
            while( $dt = mysql_fetch_array( $query ) ){
            $no=$dt['iPeriodId'];

            $sql_jumlah = "SELECT count(prob_no) As jumlah FROM tbl_problem WHERE prob_periode='$no' AND prob_type=4";        
            $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
            while( $data = mysql_fetch_array( $query_jumlah ) ){
            $jumlah_0 = $data['jumlah'];
                    
                    echo $jumlah_0.',';

            }
            }
            ?>


            ]
        },{
            name: 'Network',
            data: [

            <?php 
            $sql_in   = "SELECT iPeriodId,cPeriodName FROM tbl_periode WHERE iPeriodId >=43 ORDER BY iPeriodId DESC";
            $query = mysql_query($sql_in);
            while( $dt = mysql_fetch_array( $query ) ){
            $no=$dt['iPeriodId'];

            $sql_jumlah = "SELECT count(prob_no) As jumlah FROM tbl_problem WHERE prob_periode='$no' AND prob_type=5";        
            $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
            while( $data = mysql_fetch_array( $query_jumlah ) ){
            $jumlah_0 = $data['jumlah'];
                    
                    echo $jumlah_0.',';

            }
            }
            ?>


            ]
        },




        ]
    });
});
</script>




<div id="container" style=" height: 700px; margin: 0 auto"></div>



