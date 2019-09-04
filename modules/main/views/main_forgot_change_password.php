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
            <h3>Reset Password</h3>
                 <p>Fill new password in the form below</p>
            </div>
                <div class="form-top-right">
                    <i class="fa fa-pencil"></i>
                </div>
        </div>
<div class="form-bottom">
<?php
    echo form_open('main/forgot/'.$activation_code);
    echo form_label('{{ language:New Password }}').br();
    //echo form_password('password').br();
    echo form_password('password','','class="form-control"').br();
    echo form_label('{{ language:New Password (again) }}').br();
    //echo form_password('confirm_password').br();
    echo form_password('confirm_password','','class="form-control"').br();
    echo '</br>';
    echo form_submit('change', $change_caption,'class="btn btn-default"');

    echo '&nbsp<br/><br/>';
    echo anchor(site_url('main/login'), 'Remember Password?', array('class'=>''));

    echo form_close();

    echo '<style>
    		.form-control{
    		width: 350px;
    	}
    		</style>';