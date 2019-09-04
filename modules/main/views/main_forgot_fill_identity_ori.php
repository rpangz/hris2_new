<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row">
            <div class="col-md-5">
                <h3>Perhatian</h3>
                <p align="left"><?php 

                $sql = "SELECT * FROM tbl_main_config WHERE config_name='cms_notice_login'";
            	$dw  = mysql_fetch_array(mysql_query($sql));
            	echo $dw['value'];?>
              </p>        
               

                <br>
              </div>


            <div class="col-md-7">
                <h3>Forgot Password</h3>
                <div class="row well well-lg">
<?php
    echo form_open('main/forgot', 'class="form"');
    echo form_label('{{ language:Username }}', 'class="form-label"');
    echo form_input('identity', $identity, 'class="form-control" placeholder="username"').br();
    echo form_submit('send_activation_code', $send_activation_code_caption, 'class="btn btn-primary"');
    
    echo '&nbsp';
    echo anchor(site_url('main/login'), 'Already have an account?', array('class'=>'btn btn-default'));
    echo '&nbsp';
    echo anchor(site_url('main/register'), "Don't have an account?", array('class'=>'btn btn-default'));
    echo form_close();
?>

        </div>
    </div>
</div> 