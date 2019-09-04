<?php 

      define('db_host','172.17.0.16');
      define('db_user','operator');
      define('db_pass','$M15.apps@admin16');
      define('db_name','imam2');  
      mysql_connect(db_host,db_user,db_pass);
      mysql_select_db(db_name);


?>
  
<script src="js2/highcharts1.js"></script>
<script src="js2/exporting1.js"></script>


<script type="text/javascript">
$(function () {
    $('#container1').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Grafik Stok Asset'
        },
        xAxis: {
            categories: [

        <?php
        $sql   = "SELECT iTypeID,cTypeName FROM tbl_type WHERE iTypeID >0 ORDER BY cTypeName ASC";
        $query = mysql_query($sql);
        while( $data = mysql_fetch_array( $query ) ){
            $type  =$data['cTypeName'];

            echo "'".$type."',";
           
            }

           ?>


            ]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Assets'
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
            name: 'Out',
            data: [
            
            <?php 
            $sql_in   = "SELECT iTypeID,cTypeName FROM tbl_type WHERE iTypeID >0 ORDER BY cTypeName ASC";
            $query = mysql_query($sql_in);
            while( $dt = mysql_fetch_array( $query ) ){
            $no=$dt['iTypeID'];

            $sql_jumlah = "SELECT count(iStokType) As jumlah FROM tbl_stock WHERE bStokStatus='0' AND iStokType='$no'";        
            $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
            while( $data = mysql_fetch_array( $query_jumlah ) ){
            $jumlah_0 = $data['jumlah'];
                    
                    echo $jumlah_0.',';

            }
            }
            ?>
            
            ]
        

        }, {
            name: 'Ready',
            data: [

            <?php 
            $sql_in   = "SELECT iTypeID,cTypeName FROM tbl_type WHERE iTypeID >0 ORDER BY cTypeName ASC";
            $query = mysql_query($sql_in);
            while( $dt = mysql_fetch_array( $query ) ){
            $no=$dt['iTypeID'];

            $sql_jumlah = "SELECT count(iStokType) As jumlah FROM tbl_stock WHERE bStokStatus='1' AND iStokType='$no'";        
            $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
            while( $data = mysql_fetch_array( $query_jumlah ) ){
            $jumlah_1 = $data['jumlah'];
                    
                    echo $jumlah_1.',';

            }
            }
            ?>

            ]
        }, {
            name: 'Service',
            data: [

            <?php 
            $sql_in   = "SELECT iTypeID,cTypeName FROM tbl_type WHERE iTypeID >0 ORDER BY cTypeName ASC";
            $query = mysql_query($sql_in);
            while( $dt = mysql_fetch_array( $query ) ){
            $no=$dt['iTypeID'];

            $sql_jumlah = "SELECT count(iStokType) As jumlah FROM tbl_stock WHERE bStokStatus='2' AND iStokType='$no'";        
            $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
            while( $data = mysql_fetch_array( $query_jumlah ) ){
            $jumlah_2 = $data['jumlah'];
                    
                    echo $jumlah_2.',';

            }
            }
            ?>



            ]
        }, {
            name: 'Unrepairable',
            data: [

            <?php 
            $sql_in   = "SELECT iTypeID,cTypeName FROM tbl_type WHERE iTypeID >0 ORDER BY cTypeName ASC";
            $query = mysql_query($sql_in);
            while( $dt = mysql_fetch_array( $query ) ){
            $no=$dt['iTypeID'];

            $sql_jumlah = "SELECT count(iStokType) As jumlah FROM tbl_stock WHERE bStokStatus='3' AND iStokType='$no'";        
            $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
            while( $data = mysql_fetch_array( $query_jumlah ) ){
            $jumlah_3 = $data['jumlah'];
                    
                    echo $jumlah_3.',';

            }
            }
            ?>

            ]
        },{
            name: 'Transform',
            data: [

            <?php 
            $sql_in   = "SELECT iTypeID,cTypeName FROM tbl_type WHERE iTypeID >0 ORDER BY cTypeName ASC";
            $query = mysql_query($sql_in);
            while( $dt = mysql_fetch_array( $query ) ){
            $no=$dt['iTypeID'];

            $sql_jumlah = "SELECT count(iStokType) As jumlah FROM tbl_stock WHERE bStokStatus='4' AND iStokType='$no'";        
            $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
            while( $data = mysql_fetch_array( $query_jumlah ) ){
            $jumlah_4 = $data['jumlah'];
                    
                    echo $jumlah_4.',';

            }
            }
            ?>


            ]
        },{
            name: 'Send to logistic',
            data: [

            <?php 
            $sql_in   = "SELECT iTypeID,cTypeName FROM tbl_type WHERE iTypeID >0 ORDER BY cTypeName ASC";
            $query = mysql_query($sql_in);
            while( $dt = mysql_fetch_array( $query ) ){
            $no=$dt['iTypeID'];

            $sql_jumlah = "SELECT count(iStokType) As jumlah FROM tbl_stock WHERE bStokStatus='5' AND iStokType='$no'";        
            $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
            while( $data = mysql_fetch_array( $query_jumlah ) ){
            $jumlah_5 = $data['jumlah'];
                    
                    echo $jumlah_5.',';

            }
            }
            ?>

            ]
        }



        ]
    });
});
</script>




<div id="container1" style=" height: 700px; margin: 0 auto"></div>



