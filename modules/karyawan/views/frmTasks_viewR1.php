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
   
</style>


<script>
function goBack() {
    window.history.back();
}
</script>

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
        
        if (count > 4)
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

    <!-- Modal HTML -->
    <div id="myModal" class="modal show">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="location.href='{{ base_url }}'">×</button>
                    <h4 class="modal-title">Tasks</h4>
                </div>
                <div class="modal-body">
                    <p>Pilih Task Yang Akan Anda Proses !</p>                    
                    <form name="substitusi_modal" id="substitusi_modal" class="form" action="{{ base_url }}karyawan/frmTasks/index/?act=save" method="POST" onsubmit='return validateComment()'>
                    <ul class="nav nav-tabs">
                        <?php echo navigations_tab($nik=$session_nik) ?>
                    </ul>

                  <div class="tab-content">
                    <!--
                    <div id="active" class="tab-pane fade in active">
                      <h4>Active</h4>                     
                    </div>
                    <div id="potential" class="tab-pane fade">
                      <h4>Potential</h4>
                    </div>-->

                    <?php echo navigations_tab_panel($nik=$session_nik) ?>
                    
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

        //update_tbl_profile($nik=$session_nik,$substitution_nik=$_POST['nik'],$substitution_status=0);

    }else{
        $status = $_POST['status'];

        //update_tbl_profile($nik=$session_nik,$substitution_nik=$_POST['nik'],$substitution_status=1);

    }


    if (!empty($_POST['nik_potential']) || !is_null($_POST['nik_potential'])){

        mysql_query('DELETE FROM tbl_substitution_potential WHERE CurrentNIK='.$session_nik);

        foreach ($_POST['nik_potential'] as $nik_potential){


            mysql_query('INSERT INTO tbl_substitution_potential (CurrentNIK,PotentialNIK) VALUES ("'.$session_nik.'","'.$nik_potential.'")');

            //echo $nik_potential . ' was selected <br />';

            //echo "<script language='javascript'>alert('Data Berhasil ".$nik_potential." Disimpan');</script>";

        }

    }

    echo "<script language='javascript'>alert('Data Berhasil Disimpan');window.location ='{{ base_url }}';</script>";




break;



}

function navigations_tab($nik){

    $query  = mysql_query('SELECT * FROM `tbl_substitution_potential` INNER JOIN tbl_profile ON NIK=CurrentNIK WHERE PotentialNIK="'.$nik.'" GROUP BY CurrentNIK ORDER BY Nama ASC');
    $total  = mysql_num_rows($query);

    if ($total >0){
        $tab = '';
        $no  = 1;
        while($data = mysql_fetch_assoc($query)){

            if ($no == 1){
                $status = 'active';
            }else{
                $status = '';
            }

            $pizza  = $data['Nama'];
            $pieces = explode(" ", $pizza);
            $tab .='<li class="'.$status.'"><a data-toggle="tab" href="#'.$data['CurrentNIK'].'">'.$pieces[0].' <span class="badge">'.form_cuti_view_total($nik,$current_nik=$data['CurrentNIK']).'</span></a></li>';
        
         $no++;
        }

        return $tab;
    } 

}

function navigations_tab_panel($nik){

    $query  = mysql_query('SELECT * FROM `tbl_substitution_potential` INNER JOIN tbl_profile ON NIK=CurrentNIK WHERE PotentialNIK="'.$nik.'" GROUP BY CurrentNIK ORDER BY Nama ASC');
    $total  = mysql_num_rows($query);

    if ($total >0){
        $tab = '';
        $no  = 1;
        while($data = mysql_fetch_assoc($query)){

            if ($no == 1){
                $status = 'tab-pane fade in active';
            }else{
                $status = 'tab-pane fade';
            }

            $pizza  = $data['Nama'];
            $pieces = explode(" ", $pizza);

            
            $tab .= '<div id="'.$data['CurrentNIK'].'" class="'.$status.'">';

            $tab .='<h4>'.$data['Nama'].'</h4>';

            

            $tab .= form_cuti_view($nik=$nik,$current_nik=$data['CurrentNIK']);


            $tab .= '</div>';
        $no++;
        
        }

        return $tab;
    }

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


function form_cuti_view($nik,$current_nik){

    $sql     = mysql_query("SELECT * FROM  (SELECT *,CONCAT('NIK',ApvLevel) as SubstitutionNIK FROM tbl_formcuti WHERE StatusForm='P') a");
    $jumlah  = mysql_num_rows($sql);

    $tab = '<div class="panel panel-primary">
                    <div class="panel-heading"><i class="glyphicon glyphicon-briefcase"></i><strong> Form Cuti</strong></div>
                    <div class="table-responsive">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nama</th>
                          <th>Keperluan</th>
                          <th>Tanggal</th>
                          <th>Jumlah</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>';
            $no  = 1;
            while($rows = mysql_fetch_assoc($sql)){

                $look_apv = mysql_query('SELECT * FROM tbl_formcuti WHERE CutiId="'.$rows['CutiId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
                $view_row  = mysql_num_rows($look_apv);

                if ($view_row >0){

                $tab .='<tr>
                          <td>'.$rows['CutiId'].'</td>
                          <td>'.potential_profile($nik=$rows['FormCutiNIK']).'</td>
                          <td>'.$rows['Keperluan'].'</td>
                          <td>Table cell</td>
                          <td>'.total_cuti($id=$rows['CutiId']).' hari</td>
                          <td><div align="center"><a href="{{ base_url }}includes/mailer/frmTasks/?form=1&id='.$rows['CutiId'].'" target="_blank"><span style="font-size:1.0em;" class="glyphicon glyphicon-send"></span></a></div></td>
                        </tr>';
                }

                $no++;

            }                       
                        

    $tab .= '</tbody></table></div></div>';

    if (form_cuti_view_total($nik,$current_nik) > 0){

        return $tab;

    }

}


function total_cuti($id){

    $query  = mysql_query('SELECT * FROM tbl_formcutidetail WHERE CutiId='.$id);
    $total  = mysql_num_rows($query);          

    return $total;
}


function form_cuti_view_total($nik,$current_nik){

    $sql     = mysql_query("SELECT * FROM  (SELECT *,CONCAT('NIK',ApvLevel) as SubstitutionNIK FROM tbl_formcuti WHERE StatusForm='P') a");
    $jumlah  = mysql_num_rows($sql);

        while($rows = mysql_fetch_assoc($sql)){

            $look_apv = mysql_query('SELECT * FROM tbl_formcuti WHERE CutiId="'.$rows['CutiId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
            $view_row  = mysql_num_rows($look_apv);

            @$grand += $view_row;                

        }

    return $grand;  


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



function potential_all_user($company){

    $query  = mysql_query('SELECT * FROM tbl_profile WHERE CompanyId='.$company.' AND bStatus=1 ORDER BY Nama ASC');
    $total  = mysql_num_rows($query);


    $results = array();
    while($data = mysql_fetch_assoc($query))
    {
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
        $substitution_nav = 'disabled';
    }

    return $substitution_nav;

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