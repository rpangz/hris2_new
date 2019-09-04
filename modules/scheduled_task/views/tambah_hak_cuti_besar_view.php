<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title;?></title>
</head>
<body onload="window.open('', '_self', '');">

	<?php echo $content;?>

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