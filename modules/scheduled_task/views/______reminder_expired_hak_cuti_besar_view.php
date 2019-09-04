<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title;?></title>
</head>
<body onload="window.open('', '_self', '');">		

<div class="container">
  <h2>CUTI BESAR</h2>
  <p><?php echo $check_tanggal;?></p>            
  <table class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>NIK</th>
        <th>Periode1</th>
        <th>Periode2</th>
        <th>PeriodeExt</th>
        <th>Qty</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($content as $key => $value) { ?>

      <tr>
        <td><?php echo $value['HakId'];?></td>
        <td><?php echo $value['NIK'];?></td>
        <td><?php echo $value['Periode1'];?></td>
        <td><?php echo $value['Periode2'];?></td>
        <td><?php echo $value['PeriodeExt'];?></td>
        <td><?php echo $value['Qty'];?></td>
      </tr>

    <?php } ?>
     
    </tbody>
  </table>
</div>


</body>
</html>  

<script type="text/javascript">
    function CloseWindow(){
        window.open('','_self','');
        window.close();
    }
</script>

<script type="text/javascript">
    window.open('javascript:window.open("", "_self", "");window.close();', '_self');
</script>