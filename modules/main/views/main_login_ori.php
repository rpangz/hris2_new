<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style type="text/css">
    #login_message:empty{
        display:none;
    }
</style>
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
    <h3>Login</h3>
    <div class="row well well-lg">

<?php
    echo form_open('main/login');
    echo form_label('{{ language:Identity }}');
    echo form_input('identity', $identity, 'placeholder="username" class="form-control"').br();
    echo form_label('{{ language:Password }}');
    echo form_password('password','','placeholder="password" class="form-control"').br();
    echo form_submit('login', $login_caption, 'class="btn btn-primary"');
    if($allow_register){
        echo '&nbsp';
        echo anchor(site_url('main/register'), "Don't have an account?", array('class'=>'btn btn-default'));

        echo '&nbsp';
        echo '&nbsp';
        echo '&nbsp';
        echo '&nbsp';
        echo '&nbsp';
        echo '&nbsp';
        echo '&nbsp';
        echo '&nbsp';
        echo anchor(site_url('main/forgot'), $forgot_caption, array('class'=>'btn btn-default'));
            

    }
    echo form_close();
    if(count($providers)>0){
        echo '{{ language:Or Login with }}:'.br();
        foreach($providers as $provider=>$connected){
            echo anchor(site_url('main/hauth/login/'.$provider), '<img src="'.base_url('modules/main/assets/third_party/'.$provider.'.png').'" />');
        }
    }
?>
<br/>
<div id="login_message" class="alert alert-danger"><?php echo isset($message)?$message:''; ?></div>


    </div>
    </div>
</div> 

<?php
    include "includes/koneksi/koneksi.php";
    $ip       = $_SERVER['REMOTE_ADDR'];
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    mysql_query("INSERT INTO tbl_hits (ip_address,computer_name) VALUES ('$ip','$hostname')");



?>

<!--<marquee behavior="scroll" direction="left">Pendaftaran BPJS via HRD untuk PT.ANEKA SPRING TELEKOMINDO akan ditutup Pada hari Jumat,19 DES 2014 Pkl:12.00 WIB...</marquee>-->

