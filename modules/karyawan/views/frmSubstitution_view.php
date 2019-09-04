<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap3/docs/css/highlight.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap3/css/bootstrap-switch.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-select-1.9.4/css/bootstrap-select.min.css'); ?>" />
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap-select-1.9.4/js/bootstrap-select.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap-select-1.9.4/js/i18n/defaults-*.min.js'); ?>"></script>


<script type="text/javascript">
$(document).ready(function(){
    $('.launch-modal').click(function(){
        $('#myModal').modal({
            backdrop: 'static'
        });
    });
});
</script>



<style type="text/css">
    .bs-example{
        margin: 20px;
    }   
    hr {
       border: 0;
    }

    .modal-dialog{
        padding-top: 2%;
    }

    a.my-tool-tip, a.my-tool-tip:hover, a.my-tool-tip:visited {

    color: black;
}

</style>
<script type="text/javascript">

function validateComment(){
  var a=document.forms["substitusi_modal"]["nik"].value;
  if (a==null || a==""){ alert("Error!!! Karyawan Substitusi Tidak Boleh Kosong"); document.substitusi_modal.nik.focus() ; return false; }   
}

</script>

<script type="text/javascript">
 jQuery(document).ready(function () {

    jQuery("select").on("change", function(){
      var msg = $("#msg");
    
      var count = 0;
    
      for (var i = 0; i < this.options.length; i++)
      {
        var option = this.options[i];
        
        option.selected ? count++ : null;
        
        if (count > 2)
        {
            option.selected = false;
            option.disabled = true;

            msg.html("Please select only four options.");
        }else{
            option.disabled = false;
            msg.html("");
        }
      }
    });
});


</script>

<script type="text/javascript">
$(document).ready(function(){
    $(".tip-top").tooltip({
        placement : 'top'
    });
    $(".tip-right").tooltip({
        placement : 'right'
    });
    $(".tip-bottom").tooltip({
        placement : 'bottom'
    });
    $(".tip-left").tooltip({
        placement : 'left'
    });
});
</script>


    <!-- Modal HTML -->
    <div id="myModal" class="modal show">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="location.href='{{ base_url }}'">×</button>
                    <h4 class="modal-title">Substitution Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda Ingin Mengaktifkan Substitusi ? <a href="#" style="text-decoration: none;" class="glyphicon glyphicon-question-sign tip-top" data-toggle="tooltip" title="Hanya Karyawan Yang Memiliki Hak Sebagai Approval"></a></p>

                    <!--<p class="text-warning"><small>If you don't save, your changes will be lost.</small></p>-->
                    
                    <blockquote>
                        <p class="text-info"><small><strong>Active:</strong> Ketika Status Substitusi <strong>ON</strong> Maka Semua Formulir yang terhenti di anda, 
                        akan dikirim ulang <strong>Notifikasi Email Approval</strong> ke karyawan yang anda pilih dibawah.</small></p>
                    </blockquote>

                    <blockquote>
                        <p class="text-info"><small><strong>Potential:</strong> Karyawan Subsitusi Potensial dapat melihat approval dan mengeksekusi form yang sedang proses di level Anda. Maksimal 2 Orang</small></p>
                    </blockquote>
                    
                    <form name="substitusi_modal" id="substitusi_modal" class="form" action="{{ base_url }}karyawan/frmSubstitution/index/?act=save" method="POST" onsubmit='return validateComment()'>

                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#active">Active</a></li>
                        <li><a data-toggle="tab" href="#potential">Potential</a></li>
                    </ul>                    


                  <div class="tab-content">
                    <div id="active" class="tab-pane fade in active">
                      <h4>Active</h4>
                      
                      <div class="form-group">
                        <label for="nik">Karyawan Substitusi:</label>
                        <select data-live-search="true" class="selectpicker form-control" data-container="body" data-header="Pilih Karyawan Substitusi" name="nik" id="nik">
                                             

                        <?php

                        $tampil = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");

                        while ($rows = mysql_fetch_array($tampil)){

                        echo '<optgroup label="'.$rows['cCompanyName'].'">';

                        $sql = mysql_query("SELECT * FROM tbl_profile WHERE CompanyId=".$rows['iCompanyId']." AND NIK !='$session_nik' AND bStatus=1 GROUP BY NIK ORDER BY Nama ASC");           
                        while ($data = mysql_fetch_array($sql)){

                            if(current_substitution($session_nik)== $data['NIK']){  
                                echo '<option value="'.$data['NIK'].'" data-subtext="'.$data['NIK'].' ['.$data['Email'].']" SELECTED>'.$data['Nama'].'</option>';
                            }
                            else {
                                echo '<option value="'.$data['NIK'].'" data-subtext="'.$data['NIK'].' ['.$data['Email'].']">'.$data['Nama'].'</option>';
                            }

                        }
                        echo '</optgroup>';
                        }  
                         
                        ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="status">Status Substitusi:</label><br/>
                        <p>
                          <input id="switch-animate" name="status" type="checkbox" <?php echo current_substitution_status($session_nik) ?> data-handle-width="254" data-on-text="<strong>ON</strong>" data-off-text="<strong>OFF</strong>" />
                        </p>
                      </div> 

                    </div>
                    <div id="potential" class="tab-pane fade">
                      <h4>Potential</h4>
                      
                      <div class="form-group">
                        <label for="nik_potential">Karyawan Substitusi Potensial:</label>
                        <select data-live-search="true" class="selectpicker form-control" multiple="multiple" data-container="body" data-header="Pilih Karyawan Substitusi Potensial (Maksimal 2 Orang)" name="nik_potential[]" id="nik_potential[]">
                        
                        <?php

                        $tampil = mysql_query("SELECT * FROM tbl_company ORDER BY iCompanyId ASC");

                        while ($rows = mysql_fetch_array($tampil)){

                        echo '<optgroup label="'.$rows['cCompanyName'].'">';

                        $name       = 'nik_potential';
                        $options    = potential_all_user($company=$rows['iCompanyId'],$nik=$session_nik);
                        $selected   = current_substitution_potential($nik=$session_nik);

                        echo multi_dropdown($name, $options, $selected );

                        echo '</optgroup>';
                        }  
                         
                        ?>
                        </select>

                      </div>                      
                    </div>
                    
                  </div>


                          
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.href='{{ base_url }}'">Close</button>                    
                    <input type="submit" class="btn btn-primary" name="submit" value="Save changes" onclick="return validateComment" <?php echo substitution_status_nav($session_nik)?>>
                </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php
    

switch($this->input->get('act')){

case "save":

    if (empty($_POST['status']) || is_null($_POST['status'])){
        $status = 'False';

        update_tbl_profile($nik=$session_nik,$substitution_nik=$_POST['nik'],$substitution_status=0);

    }else{
        $status = $_POST['status'];

        update_tbl_profile($nik=$session_nik,$substitution_nik=$_POST['nik'],$substitution_status=1);

    }


    if (!empty($_POST['nik_potential']) || !is_null($_POST['nik_potential'])){

        mysql_query('DELETE FROM tbl_substitution_potential WHERE CurrentNIK='.$session_nik);

        foreach ($_POST['nik_potential'] as $nik_potential){

            mysql_query('INSERT INTO tbl_substitution_potential (CurrentNIK,PotentialNIK) VALUES ("'.$session_nik.'","'.$nik_potential.'")');

            send_email_notifikasi_potential($nik=$nik_potential,$session_nik);

        }

        mysql_query('INSERT INTO tbl_substitution_potential (CurrentNIK,PotentialNIK) VALUES ("'.$session_nik.'","'.$session_nik.'")');

    }
    else{
        mysql_query('DELETE FROM tbl_substitution_potential WHERE CurrentNIK='.$session_nik);

        mysql_query('INSERT INTO tbl_substitution_potential (CurrentNIK,PotentialNIK) VALUES ("'.$session_nik.'","'.$session_nik.'")');
    }

    echo "<script language='javascript'>alert('Data Berhasil Disimpan');window.location ='{{ base_url }}';</script>";




break;



}

function multi_dropdown( $name, array $options, array $selected=null, $size=4 ){
        /*** begin the select ***/
        //$dropdown = '<select data-live-search="true" class="selectpicker form-control" multiple="multiple" data-container="body" data-header="Pilih Karyawan Substitusi Potensial" name="'.$name.'" id="'.$name.'">'."\n";
        $dropdown = '';

        /*** loop over the options ***/
        foreach( $options as $key=>$option )
        {
                /*** assign a selected value ***/
                $select = in_array( $option, $selected ) ? ' selected' : null;


                /*** add each option to the dropdown ***/
                $dropdown .= '<option value="'.$option.'"'.$select.' data-subtext="'.$option.'">'.potential_profile($nik=$option).'</option>'."\n";
        }

        /*** close the select ***/
        $dropdown .= '';
        //$dropdown .= '</select>'."\n";

        /*** and return the completed dropdown ***/
        return $dropdown;
}


function update_tbl_profile($nik,$substitution_nik,$substitution_status){

    mysql_query("UPDATE tbl_profile SET SubstitutionNIK1='$substitution_nik',SubstitutionStatus='$substitution_status' WHERE NIK='$nik'");

}

function current_substitution($nik){

    $query  = mysql_query('SELECT * FROM tbl_profile WHERE NIK='.$nik);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['SubstitutionNIK1'];
    }
    else {
        return '';
    }

}


function current_substitution_potential($nik){

    $query  = mysql_query('SELECT * FROM tbl_substitution_potential WHERE CurrentNIK='.$nik);
    $total  = mysql_num_rows($query);


    $results = array();
    while($data = mysql_fetch_assoc($query))
    {
       $results[] = $data['PotentialNIK'];
    }

    return $results;



}


function total_substitution_potential($nik){

    $query  = mysql_query('SELECT * FROM tbl_substitution_potential WHERE CurrentNIK='.$nik);
    $total  = mysql_num_rows($query);

    return $total;

}



function potential_all_user($company,$nik){

    $query   = mysql_query('SELECT * FROM tbl_profile WHERE CompanyId='.$company.' AND NIK !='.$nik.' AND bStatus=1 ORDER BY Nama ASC');
    $total   = mysql_num_rows($query);
    $results = array();

    while($data = mysql_fetch_assoc($query)){
       $results[] = $data['NIK'];
    }

    return $results;

}

function potential_profile($nik){

    $query  = mysql_query('SELECT * FROM tbl_profile WHERE NIK='.$nik);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);
    if ($total >0){
        return $data['Nama'];
    }else{
        return '';
    }

}

function potential_profile_email($nik){

    $query  = mysql_query('SELECT * FROM tbl_profile WHERE NIK='.$nik);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);
    if ($total >0){
        return $data['Email'];
    }else{
        return '';
    }

}

function current_substitution_status($nik){

    $query  = mysql_query('SELECT * FROM tbl_profile WHERE NIK='.$nik);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        if ($data['SubstitutionStatus']==1){
            return 'checked';
        }else{
            return '';
        }
    }
    else {
        return '';
    }

}

function substitution_status_nav($nik){

    $query  = mysql_query('SELECT * FROM tbl_apv_group_approval WHERE NIK='.$nik);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    $query2  = mysql_query('SELECT * FROM tbl_apv_hrd WHERE hrd_nik='.$nik);
    $total2  = mysql_num_rows($query2);
    $data2   = mysql_fetch_array($query2);

    if ($total >0 || $total2 >0){
        $substitution_nav = '';
    }
    else {
        //$substitution_nav = 'disabled';
        $substitution_nav = '';
    }

    return $substitution_nav;

}  


function send_email_notifikasi_potential($nik,$session_nik){

    $query  = mysql_query("SELECT * FROM tbl_profile WHERE NIK='".$nik."'");
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    require_once 'class.phpmailer.php';
    //require_once base_url('class.phpmailer.php')


    try {

    $mail = new PHPMailer(true);

    $body =
    '<html>
    <head>
    <style type=text/css>
    .style1 {
        font-size: 13px
    }
    .style4 {
        font-size: 13px;
        font-style: normal;
    }

    .bigcell {
        position: relative;
        width: 100px;
        height: 50px;
        border: thin dotted gray;
    }

    .strikeout {
        position: absolute;
        height: 0px;
        width: 179px;
        background-color: black;
        top: 146px;
        visibility: inherit;
    }
    .style7 {
        font-size: 13px; font-weight: bold;
    }
    table {
        border: thin black solid;
    }
    </style>    
    
    <title>Substitution</title>
    </head>
    <body>
    
    <p><strong>Detail Potential Substitution</strong></p>
    
    Dear, '.potential_profile($nik).' <br/>
    Anda ditunjuk oleh <strong>'.potential_profile($session_nik).'</strong> sebagai Subsitusi Potensial (Potential Substitution).<br/>
    Anda bisa melakukan proses accept dan reject form approval dari <strong>'.potential_profile($session_nik).'</strong>.<br/>
    Silahkan lihat modul Tasks yang berada di akun HRIS anda.<br/><br/>

    Trims

    </br>
    <p><font color="#FF0000" size="-1">Perhatian email ini dikirim secara otomatis dari sistem HRIS. Jangan membalas ke alamat ini</font></p>
    </br>
    </body>
    </html>';


   
    
        $mail->IsSMTP();
        $mail->Mailer       = "smtp";
        $mail->Host         = "Exc2013-DAG";
        $mail->Port         = 25;
        $mail->SMTPKeepAlive= true;
        $mail->SMTPAuth     = true;   
        $mail->From         = "system.noreply@unias.com";
        $mail->FromName     = "Human Resource Information System (HRIS)";
        $mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System (HRIS)');  
        $to = $data['Email'];
        //$to = "dompak.sinambela@unias.com";
        $mail->Body = $body;    
        $mail->AddAddress($to);
        $mail->Subject  = "Potential Substitution";
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";     
        $mail->WordWrap   = 80; 
        $mail->IsHTML(true);    
        $mail->Send();  
    
        }
        catch (phpmailerException $e){            
            echo $e->errorMessage();
        }


}


$asset = new CMS_Asset();
foreach($css_files as $file){
    $asset->add_css($file);
}
//echo $asset->compile_css();

foreach($js_files as $file){
    $asset->add_js($file);
}
//echo $asset->compile_js();

// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    //return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}
?>


<!-- Script for Switch button ON-OFF-->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap3/docs/js/highlight.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap3/js/bootstrap-switch.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap3/docs/js/main.js'); ?>"></script>