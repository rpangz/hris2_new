<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style type="text/css">
#login_message:empty{
        display:none;
    }
p { display: inline }

#span-a {
   float: left;
   background-color: #cfc;
   color: #030;
 }

 .description2 {float:left;
    font-size: 12px }



</style>

    <div class="col-sm-7" style="color:#{{ cms_notice_login_color }}">
            <h1 style="color:#{{ cms_notice_login_color }}"><strong>PERHATIAN</strong></h1>
                <div class="description2" align="left"><p>
                                      
                        <?php
                        $sql = "SELECT * FROM tbl_main_config WHERE config_name='cms_notice_login'";
                        $dw  = mysql_fetch_array(mysql_query($sql));
                        echo $dw['value'];
                        ?>           
              
                
    </p></div>
                            
    </div>
<div class="col-sm-5 form-box">
        <div class="form-top">
            <div class="form-top-left">
            <h3><b>Human Resouce Information System</b></h3>
                 <p>Fill Your username and password</p>
            </div>
                <div class="form-top-right">
                    <i class="fa fa-pencil"></i>
                </div>
        </div>
<div class="form-bottom">
                                
<?php
    echo form_open('main/login');
    echo form_label('{{ language:Username }}');
    echo form_input('identity', $identity, 'placeholder="username" class="form-control"').br();
    echo form_label('{{ language:Password }}');
    echo form_password('password','','placeholder="password" class="form-control"').br();
    echo form_submit('login', $login_caption, 'class="btn btn-primary"');
    if($allow_register){
        echo '&nbsp<br/>';
        echo anchor(site_url('main/register'), "Don't have an account?", array('class'=>''));

        echo '&nbsp &nbsp &nbsp &nbsp';
        
        echo anchor(site_url('main/forgot'), $forgot_caption, array('class'=>''));
        // btn btn-default
       

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

<?php
    include "includes/koneksi/koneksi.php";
    $ip       = $_SERVER['REMOTE_ADDR'];
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

//echo "IP address= $ip";
//echo "IP address= $hostname";

    if($pageWasRefreshed) {
   //do something because page was refreshed;
    } else {
       mysql_query("INSERT INTO tbl_hits (ip_address,computer_name) VALUES ('$ip','$hostname')");
    }

    
//echo base_url().'<br/>';
//echo site_url().'<br/>';


?>