<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>



        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="{{ site_url }}assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ site_url }}assets_login/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ site_url }}assets_login/css/form-elements.css">
        <link rel="stylesheet" href="{{ site_url }}assets_login/css/style.css">

<style>
    
.description2 {float:left;
    font-size: 12px }
</style>

<div class="col-sm-7" style="color:#{{ cms_notice_login_color }}">
            <h1 style="color:#{{ cms_notice_login_color }}"><strong>PERHATIAN</strong></h1>
                <div class="description2" align="left">
                    <p>
                    <?php
                        $sql = "SELECT * FROM tbl_main_config WHERE config_name='cms_notice_login'";
                        $dw  = mysql_fetch_array(mysql_query($sql));
                        echo $dw['value'];
                        ?>  
                  </p>
                </div>
                            
</div>


<div class="col-sm-5 form-box">
        <div class="form-top">
            <div class="form-top-left">
            <h3>Forgot Password</h3>
                 <p>Fill username in the form below</p>
            </div>
                <div class="form-top-right">
                    <i class="fa fa-pencil"></i>
                </div>
        </div>
<div class="form-bottom">
                                
<?php
    echo form_open('main/forgot', 'class="form"');
    echo form_label('{{ language:Username }}', 'class="form-label"');
    echo form_input('identity', $identity, 'class="form-control" placeholder="username"').br();
    echo form_submit('send_activation_code', $send_activation_code_caption, 'class="btn btn-primary"');
    
    echo '&nbsp<br/><br/>';
    echo anchor(site_url('main/login'), 'Already have an account?', array('class'=>''));
    echo '&nbsp<br/>';
    echo anchor(site_url('main/register'), "Don't have an account?", array('class'=>''));
    echo form_close();
?>
<br/>


</div>
</div>