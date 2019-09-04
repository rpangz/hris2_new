<?php 

      define('db_host','172.17.0.16');
      define('db_user','operator');
      define('db_pass','$M15.apps@admin16');
      define('db_name','hris2');
  
      mysql_connect(db_host,db_user,db_pass);
      mysql_select_db(db_name);

  ?>

<script src='../js2/jquery.min.js' type='text/javascript'></script>
<script src="../js2/highcharts.js" type="text/javascript"></script>
<script src="../js2/exporting.js" type="text/javascript"></script>

<script type="text/javascript">

var chart1; // globally available
$(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'container',
            type: 'column'
         },   
         title: {
            text: 'Grafik Jumlah Peserta BPJS Kesehatan - Astel Group'
         },
         xAxis: {
            categories: ['Company']
         },
         yAxis: {
            title: {
               text: 'Jumlah (Orang)'
            }
         },
              series:             
            [
            <?php 
        
          


           $sql   = "SELECT iCompanyId,cCompanyName FROM tbl_company";
            $query = mysql_query( $sql )  or die(mysql_error());
            while( $ret = mysql_fetch_array( $query ) ){
              $merek=$ret['iCompanyId'];
              $jdl=$ret['cCompanyName'];

                 $sql_jumlah   = "SELECT count(bpjs_Id) As jumlah FROM tbl_bpjs WHERE companyID='$merek'";        
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
    


 


