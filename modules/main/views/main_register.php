<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style type="text/css">
    #message:empty{
        display:none;
    }
    #btn-register, .register_input{
        display:none;
    }

    .description2 {float:left;
    font-size: 12px }





::-webkit-input-placeholder {
 font-size: 12px;
 color: #d0cdfa;
 text-align: left;
 font-weight: normal;
}
:-moz-placeholder { /* older Firefox*/
 font-size:12px;
 color: #d0cdfa;
 /*text-transform: uppercase;*/
 text-align: left;
 font-weight: normal;
}
::-moz-placeholder { /* Firefox 19+ */ 
 font-size: 12px;
 color: #d0cdfa; 
 /*text-transform: uppercase;*/
 text-align: left;
 font-weight: normal;
} 
:-ms-input-placeholder { 
 font-size: 12px; 
 color: #d0cdfa;
 /*text-transform: uppercase;*/
 text-align: left;
 font-weight: normal;
}
 

</style>
<script type="text/javascript">
    var REQUEST_EXISTS = false;
    var REQUEST = "";
    function check_user_exists(){
        var user_id =  $('input[name="<?php echo $secret_code?>user_id"]').val();
        var user_name =  $('input[name="<?php echo $secret_code?>user_name"]').val();
        var email = $('input[name="<?php echo $secret_code?>email"]').val();
        var password = $('input[name="<?php echo $secret_code?>password"]').val();        
        var confirm_password = $('input[name="<?php echo $secret_code?>confirm_password"]').val();
        $("#img_ajax_loader").show();
        if(REQUEST_EXISTS){
            REQUEST.abort();
        }
        REQUEST_EXISTS = true;
        REQUEST = $.ajax({
            "url" : "check_registration",
            "type" : "POST",
            "data" : {
                        "user_id":user_id, 
                        "user_name":user_name, 
                        "email":email
                    },
            "dataType" : "json",
            "success" : function(data){
                if(!data.error && !data.exists && user_id!='' && user_name!='' && password!='' && password==confirm_password){
                    $('input[name="register"]').show();
                    $('input[name="register"]').removeAttr('disabled');
                    console.log($('input[name="register"]'));
                }else{
                    $('input[name="register"]').hide();
                    $('input[name="register"]').attr('disabled', 'disabled');
                }

                // get message from server + local check
                var message = '';
                if(data.message!=''){
                    message += data.message+'<br />';
                }
                if(password == ''){
                    //message += '{{ language:Password is empty }}<br />';
                    message += '{{ language:Password kosong }}<br />';
                }
                if(password != confirm_password){
                    //message += '{{ language:Confirm password doesn\'t match }}';
                    message += '{{ language:Konfirmasi password tidak cocok }}';
                }

                if(message != $('#message').html()){
                    $('#message').html(message);
                }
                REQUEST_EXISTS = false;
                $("#img_ajax_loader").hide();
            },
            error: function(xhr, textStatus, errorThrown){
                if(textStatus != 'abort'){
                    setTimeout(check_user_exists, 10000);    
                }
            }
        });
    }    

    $(document).ready(function(){
        check_user_exists();
        $('input').keyup(function(){
            check_user_exists();
        });    

    })
</script>


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
            <h3>Register An Account</h3>
                 <p>Fill in the form below to get instant access:</p>
            </div>
                <div class="form-top-right">
                    <i class="fa fa-pencil"></i>
                </div>
        </div>
<div class="form-bottom">

<?php
    echo form_open('main/register', 'class="form form-horizontal"');
    //echo form_open_multipart('main/register', 'id="form-register" class="form form-horizontal"');
    echo form_input(array('name'=>'user_id', 'value'=>'', 'class'=>'register_input'));
    echo form_input(array('name'=>'user_name', 'value'=>'', 'class'=>'register_input'));
    echo form_input(array('name'=>'email', 'value'=>'', 'class'=>'register_input'));    
    echo form_input(array('name'=>'password', 'value'=>'', 'class'=>'register_input'));
    echo form_input(array('name'=>'confirm_password', 'value'=>'', 'class'=>'register_input'));
    echo form_input(array('name'=>'real_name', 'value'=>'', 'class'=>'register_input'));

    echo '<div class="form-group">';
    echo form_label('{{ language:NIK }}', ' for="" class="control-label col-sm-4');
    echo '<div class="col-sm-8">';
    echo form_input($secret_code.'user_id', $user_id, 
        'id="'.$secret_code.'user_id" placeholder="NIK" class="form-control"');
    echo '</div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo form_label('{{ language:User Name }}', ' for="" class="control-label col-sm-4');
    echo '<div class="col-sm-8">';
    echo form_input($secret_code.'user_name', $user_name, 
        'id="'.$secret_code.'user_name" placeholder="cth: dompak, dompakpe, dompaksi" class="form-control"');
    echo '</div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo form_label('{{ language:Company Email }}', ' for="" class="control-label col-sm-4');
    echo '<div class="col-sm-8">';
    echo form_input($secret_code.'email', $email, 
        'id="'.$secret_code.'email" placeholder="cth: dompak.sinambela@unias.com" class="form-control"');   
    echo '</div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo form_label('{{ language:Full Name }}', ' for="" class="control-label col-sm-4');
    echo '<div class="col-sm-8">';
    echo form_input($secret_code.'real_name', $real_name, 
        'id="'.$secret_code.'real_name" placeholder="cth: Dompak Petrus Sinambela" class="form-control"');
    echo '</div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo form_label('{{ language:Password }}', ' for="" class="control-label col-sm-4');
    echo '<div class="col-sm-8">';
    echo form_password($secret_code.'password', '', 
        'id="'.$secret_code.'password" placeholder="Password" class="form-control"');
    echo '</div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo form_label('{{ language:Confirm Password }}', ' for="" class="control-label col-sm-4');
    echo '<div class="col-sm-8">';
    echo form_password($secret_code.'confirm_password', '', 
        'id="'.$secret_code.'confirm_password" placeholder="Password (again)" class="form-control"');
    echo '</div>';
    echo '</div>';

    echo '<div class="form-group"><div class="col-sm-offset-4 col-sm-8">';
    echo '<img id="img_ajax_loader" style="display:none;" src="'.base_url('assets/nocms/images/ajax-loader.gif').'" /><br />';
    echo '<div id="message" class="alert alert-danger"></div>';
    echo form_submit('register', $register_caption, 'id="btn-register" class="btn btn-primary" style="display:none;"');
    // /echo '&nbsp';
    //echo '&nbsp';
    //echo '&nbsp';
    echo '<br/><br/>';
    echo anchor(site_url('main/login'), 'Already have an account?', array('class'=>''));
    echo '<br/>';
    echo anchor(site_url('main/forgot'), 'Forgot Password', array('class'=>''));

    echo '</div></div>';
    echo form_close();    
?>


      </div>
</div>