<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style type="text/css">
    #login_message:empty{
        display:none;
    }
</style>
Perhatian :</br>
<i>* Untuk mendaftar menjadi Peserta BPJS Kesehatan, Silahkan Klik tombol </i><b>Registrasi Peserta BPJS Kesehatan</b> (Tidak diperlukan Login)

</br>
<i>* Untuk mendaftarkan Tanggungan karyawan , Silahkan Klik tombol </i><b>Add Member Peserta</b> (Isikan dengan nomor Kartu Keluarga)

</br>
<i>* Untuk cara pengisian formulir, Silahkan Klik tombol </i><b>Panduan</b>
</br>
<i>* Untuk bertanya lebih lanjut silahkan hub HRD ext:2421 dengan Bpk.Yosia / Vinda (Astel)  ; </br>    ext 2422 dengan Ibu Caecilia Carla (Mediatek/ Media Indonusa). </i>
</br>
</br>
</br>
<b>Pendaftaran BPJS via HRD dibuka tanggal mulai tanggal 1 sampai dengan 15 setiap bulannya.</b> 
</br>
</br>
</br>


<?php
    echo form_open('main/login');
    echo form_label('{{ language:Username }}');
    echo form_input('identity', $identity, 'placeholder="username" class="form-control"').br();
    echo form_label('{{ language:Password }}');
    echo form_password('password','','placeholder="password" class="form-control"').br();
    echo form_submit('login', $login_caption, 'class="btn btn-primary"');
    if($allow_register){
        echo '&nbsp';
        echo anchor(site_url('main/register'), $register_caption, array('class'=>'btn btn-default'));

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
</br>
<div id="login_message" class="alert alert-danger"><?php echo isset($message)?$message:''; ?></div>

<?php
    include "includes/koneksi/koneksi.php";
    $ip       = $_SERVER['REMOTE_ADDR'];
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

//echo "IP address= $ip";
//echo "IP address= $hostname";

    mysql_query("INSERT INTO tbl_hits (ip_address,computer_name) VALUES ('$ip','$hostname')");



?>

<!--<marquee behavior="scroll" direction="left">Pendaftaran BPJS via HRD untuk PT.ANEKA SPRING TELEKOMINDO akan ditutup Pada hari Jumat,19 DES 2014 Pkl:12.00 WIB...</marquee>-->

