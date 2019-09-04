<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start();
$this->load->model('detail_form_model');

$asset = new CMS_Asset();
foreach($css_files as $file){
    $asset->add_css($file);
}
echo $asset->compile_css();

foreach($js_files as $file){
    $asset->add_js($file);
}
//echo $asset->compile_js();

// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
  return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}

// form cuti
if(isset($_POST['cuti_id'])){    
    echo $this->detail_form_model->data_form_cuti($form_id=$_POST['cuti_id'],$company_id= NULL,$session_id=NULL,$level_id=NULL);
}

// form ijin
elseif(isset($_POST['ijin_id'])){   
    echo $this->detail_form_model->data_form_ijin($form_id=$_POST['ijin_id'],$company_id= NULL,$session_id=NULL,$level_id=NULL);
}

// perpanjangan sisa cuti
elseif(isset($_POST['sisa_id'])){    
    echo $this->detail_form_model->data_form_sisa_cuti($form_id=$_POST['sisa_id'],$company_id= NULL,$session_id=NULL,$level_id=NULL);
}

else{

?>


<form role="form" name="substitusi_modal" id="substitusi_modal" class="form-horizontal" action="{{ base_url }}karyawan/frmTasks/index/?act=save" method="POST" >
               
    <div class='alert alert-info'>
      <strong>Info!</strong> Pilih Task Yang Akan Anda Proses ! 
    </div>
    
    <!--<ul class="nav nav-pills nav-stacked col-md-3">-->                            
    <ul class="nav nav-tabs">
        <?php echo navigations_tab($nik=$session_nik) ?>
    </ul>

    <!--<div class="tab-content col-md-10">-->   
    <div class="tab-content">      
        <?php echo navigations_tab_panel($nik=$session_nik) ?>                    
    </div>  
               
</form>
           
        
    

<?php
}

switch($this->input->get('act')){

case "save":   

    echo "<script language='javascript'>alert('Email Berhasil Dikirim...');</script>";

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


            $pizza      = $data['Nama'];
            $pieces     = explode(" ", $pizza);

            if ($data['CurrentNIK'] != $nik){
              $nick_name  = $pieces[0];
            }else{
              $nick_name  = $pieces[0];
            }
            //$tab .='<li class="'.$status.'"><a data-toggle="tab" href="#'.$data['CurrentNIK'].'">'.$data['CurrentNIK'].'. '.$pieces[0].' <span class="badge">'.all_form_view_total($nik,$current_nik=$data['CurrentNIK']).'</span></a></li>';

            $tab .='<li class="'.$status.'"><a data-toggle="tab" href="#'.$data['CurrentNIK'].'">'.$nick_name.' <span class="badge">'.all_form_view_total($nik,$current_nik=$data['CurrentNIK']).'</span></a></li>';
        
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

            $tab .='<h4>'.$data['Nama'].' ['.$data['NIK'].']</h4>';

            

            $tab .= form_cuti_view($nik=$nik,$current_nik=$data['CurrentNIK']);
            $tab .= form_ijin_view($nik=$nik,$current_nik=$data['CurrentNIK']);
            $tab .= form_sisa_cuti_view($nik=$nik,$current_nik=$data['CurrentNIK']);
            $tab .= form_cv_view($nik=$nik,$current_nik=$data['CurrentNIK']);


            $tab .= '</div>';
        $no++;
        
        }

        return $tab;
    }

}


function multi_dropdown( $name, array $options, array $selected=null, $size=4 ){
        
        $dropdown = '';
        foreach( $options as $key=>$option ){
                $select = in_array( $option, $selected ) ? ' selected' : null;
                $dropdown .= '<option value="'.$option.'"'.$select.' data-subtext="'.$option.'">'.potential_profile($nik=$option).'</option>'."\n";
        }

        $dropdown .= '';
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
                          <th>Jenis Cuti</th>
                          <th>Keperluan</th>
                          <th>Tgl Cuti</th>
                          <th>Jumlah</th>
                          <th>Tgl Masuk</th>
                          <th width="15%"><div align="center">Level</div></th>
                          <th width="8%"><div align="center">Action</div></th>
                        </tr>
                      </thead>
                      <tbody>';
            $no  = 1;
            while($rows = mysql_fetch_assoc($sql)){

                $look_apv = mysql_query('SELECT * FROM tbl_formcuti WHERE CutiId="'.$rows['CutiId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
                $view_row  = mysql_num_rows($look_apv);


                if ($rows['JenisItemCuti'] <= 9 && $rows['JenisCuti'] !=5){
                    $total_cuti = total_cuti($id=$rows['CutiId']);
                    $tgl_cuti   = tanggal_cuti($id=$rows['CutiId']);
                }
                elseif($rows['JenisCuti'] == 5){
                    $total_cuti = count_days_cuti($id=$rows['CutiId']);
                    $tgl_cuti   = active_days_cuti($id=$rows['CutiId']);
                }
                else{
                    $total_cuti = count_days_cuti($id=$rows['CutiId']);
                    $tgl_cuti   = active_days_cuti($id=$rows['CutiId']);
                }


                if ($view_row >0){
                 

                $tab .='<tr>
                          <td>'.$rows['CutiId'].'</td>
                          <td>'.potential_profile($nik=$rows['FormCutiNIK']).'</td>
                          <td>'.jenis_cuti($id=$rows['JenisCuti']).'</td>
                          <td>'.$rows['Keperluan'].'</td>
                          <td>'.$tgl_cuti.'</td>
                          <td>'.$total_cuti.' hari</td>
                          <td>'.tanggal_masuk_cuti($id=$rows['CutiId']).'</td>
                          <td><div align="center">'.level_approval_cuti($id=$rows['CutiId']).'</div></td>
                          <td><div align="center">                          
                          <a title="Read" href="#" class="detail-cuti" data-id="'.$rows['CutiId'].'" data-target="#myModal" data-toggle="modal"><span style="font-size:1.0em;" class="glyphicon glyphicon-search"></span></a>&nbsp;&nbsp;                         
                          <a title="Accept" onclick=open_in_new_tab_and_reload("https://apps.unias.com/publish/hris2/frmCuti/ServicesApproval.php?act=accept&id='.$rows['CutiId'].'&mynik='.$rows['FormCutiNIK'].'&token='.token_cuti($id=$rows['CutiId'],$level=$rows['ApvLevel']).'&proses='.$rows['ApvLevel'].'") href="#"><span style="font-size:1.0em;" class="glyphicon glyphicon-ok"></span></a>&nbsp;&nbsp;
                          <a title="Reject" onclick=open_in_new_tab_and_reload("https://apps.unias.com/publish/hris2/frmCuti/ServicesApproval.php?act=reject&id='.$rows['CutiId'].'&mynik='.$rows['FormCutiNIK'].'&token='.token_cuti($id=$rows['CutiId'],$level=$rows['ApvLevel']).'&proses='.$rows['ApvLevel'].'") href="#"><span style="font-size:1.0em;" class="glyphicon glyphicon-remove"></span></a>
                          </div>
                          </td>
                        </tr>';
                }

                //onclick="newDoc('.$rows['CutiId'].')"


                $no++;

            }                       
                        

    $tab .= '</tbody></table></div></div>';

    if (form_cuti_view_total($nik,$current_nik) > 0){

        return $tab;

    }

}


function form_ijin_view($nik,$current_nik){

    $sql     = mysql_query("SELECT * FROM  (SELECT *,CONCAT('NIK',ApvLevel) as SubstitutionNIK FROM tbl_formijin WHERE StatusForm='P') a");
    $jumlah  = mysql_num_rows($sql);

    $tab = '<div class="panel panel-primary">
                    <div class="panel-heading"><i class="glyphicon glyphicon-pushpin"></i><strong> Form Ijin</strong></div>
                    <div class="table-responsive">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nama</th>
                          <th>Jenis Ijin</th>
                          <th>Keperluan</th>
                          <th>Tgl Ijin</th>
                          <th width="15%"><div align="center">Level</div></th>
                          <th width="8%"><div align="center">Action</div></th>
                        </tr>
                      </thead>
                      <tbody>';
            $no  = 1;
            while($rows = mysql_fetch_assoc($sql)){

                $look_apv = mysql_query('SELECT * FROM tbl_formijin WHERE IjinId="'.$rows['IjinId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
                $view_row  = mysql_num_rows($look_apv);

                if ($view_row >0){

                $tab .='<tr>
                          <td>'.$rows['IjinId'].'</td>
                          <td>'.potential_profile($nik=$rows['NIK']).'</td>
                          <td>'.jenis_ijin($id=$rows['JenisIjin']).'</td>
                          <td>'.$rows['Alasan'].'</td>
                          <td>'.tanggal_ijin($id=$rows['IjinId']).'</td>
                          <td><div align="center">'.level_approval_ijin($id=$rows['IjinId']).'</div></td>
                          <td><div align="center">
                          <a title="Read" href="#" class="detail-ijin" data-id="'.$rows['IjinId'].'" data-target="#myModal" data-toggle="modal"><span style="font-size:1.0em;" class="glyphicon glyphicon-search"></span></a>&nbsp;&nbsp;                         
                          <a title="Accept" onclick=open_in_new_tab_and_reload("https://apps.unias.com/publish/hris2/frmIjin/ServicesApproval.php?act=accept&id='.$rows['IjinId'].'&mynik='.$rows['NIK'].'&token='.token_ijin($id=$rows['IjinId'],$level=$rows['ApvLevel']).'&proses='.$rows['ApvLevel'].'") href="#"><span style="font-size:1.0em;" class="glyphicon glyphicon-ok"></span></a>&nbsp;&nbsp;
                          <a title="Reject" onclick=open_in_new_tab_and_reload("https://apps.unias.com/publish/hris2/frmIjin/ServicesApproval.php?act=reject&id='.$rows['IjinId'].'&mynik='.$rows['NIK'].'&token='.token_ijin($id=$rows['IjinId'],$level=$rows['ApvLevel']).'&proses='.$rows['ApvLevel'].'") href="#"><span style="font-size:1.0em;" class="glyphicon glyphicon-remove"></span></a>
                          </div>
                          </td>
                        </tr>';
                }

                $no++;

            }                       
                        

    $tab .= '</tbody></table></div></div>';

    if (form_ijin_view_total($nik,$current_nik) > 0){

        return $tab;

    }

}

function form_sisa_cuti_view($nik,$current_nik){

    $sql     = mysql_query("select a1.*,CONCAT('NIK',ApvLevel) as SubstitutionNIK from tbl_formperpcuti a1 inner join 
                          (select max(FormPerpCutiId) as max from tbl_formperpcuti group by HakCutiId,NIK) a2 on a1.FormPerpCutiId = a2.max WHERE StatusForm='P'");
    $jumlah  = mysql_num_rows($sql);

    $tab = '<div class="panel panel-primary">
                    <div class="panel-heading"><i class="glyphicon glyphicon-leaf"></i><strong> Form Perpanjangan Sisa Cuti</strong></div>
                    <div class="table-responsive">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nama</th>
                          <th>Jenis Cuti</th>
                          <th>Hak Cuti</th>
                          <th>Diperpanjang Sampai</th>
                          <th width="15%"><div align="center">Level</div></th>
                          <th width="8%"><div align="center">Action</div></th>
                        </tr>
                      </thead>
                      <tbody>';
            $no  = 1;
            while($rows = mysql_fetch_assoc($sql)){

                $look_apv = mysql_query('SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId="'.$rows['FormPerpCutiId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
                $view_row  = mysql_num_rows($look_apv);

                if ($view_row >0){

                $tab .='<tr>
                          <td>'.$rows['FormPerpCutiId'].'</td>
                          <td>'.potential_profile($nik=$rows['NIK']).'</td>
                          <td>'.jenis_hak_cuti($id=$rows['HakCutiId']).'</td>
                          <td>'.tanggal_hak_cuti($id=$rows['HakCutiId']).'</td>
                          <td>'.tanggal_hak_cuti_perpanjang($id=$rows['HakCutiId']).'</td>
                          <td><div align="center">'.level_approval_sisa_cuti($id=$rows['FormPerpCutiId']).'</div></td>
                          <td><div align="center">
                          <a title="Read" href="#" class="detail-sisa" data-id="'.$rows['FormPerpCutiId'].'" data-target="#myModal" data-toggle="modal"><span style="font-size:1.0em;" class="glyphicon glyphicon-search"></span></a>&nbsp;&nbsp;                         
                          <a title="Accept" onclick=open_in_new_tab_and_reload("https://apps.unias.com/publish/hris2/frmPerpCuti/ServicesApproval.php?act=accept&id='.$rows['FormPerpCutiId'].'&mynik='.$rows['NIK'].'&token='.token_sisa_cuti($id=$rows['FormPerpCutiId'],$level=$rows['ApvLevel']).'&proses='.$rows['ApvLevel'].'") href="#"><span style="font-size:1.0em;" class="glyphicon glyphicon-ok"></span></a>&nbsp;&nbsp;
                          <a title="Reject" onclick=open_in_new_tab_and_reload("https://apps.unias.com/publish/hris2/frmPerpCuti/ServicesApproval.php?act=reject&id='.$rows['FormPerpCutiId'].'&mynik='.$rows['NIK'].'&token='.token_sisa_cuti($id=$rows['FormPerpCutiId'],$level=$rows['ApvLevel']).'&proses='.$rows['ApvLevel'].'") href="#"><span style="font-size:1.0em;" class="glyphicon glyphicon-remove"></span></a>
                          </div>
                          </td>
                        </tr>';
                }

                $no++;

            }                       
                        

    $tab .= '</tbody></table></div></div>';

    if (form_sisa_cuti_view_total($nik,$current_nik) > 0){

        return $tab;

    }

}

//https://apps.unias.com/publish/hris2/frmPerpCuti/ServicesApproval.php?act=accept&id=74&mynik=4833&token=4edd6547f84141b85086ed808907454f&proses=1
function form_cv_view($nik,$current_nik){

    $sql     = mysql_query("SELECT * FROM  (SELECT `ProcessId`, `ProcessNIK`, `ProcessLevel`, `ProcessStatusForm`, `ProcessNIK1`, `ProcessNIK2`,
               `ProcessApv1`, `ProcessApv2`, `ProcessPin`, `ProcessPin1`, `ProcessPin2`, `ProcessDate1`, `ProcessDate2`, `ProcessRemark1`,
               `ProcessRemark2`, `PorcessAlasanApv`, `ProcessLastId`, `ProcessRepeated`,tbl_profile_process.`CreatedTime` AS CreatedTime,CONCAT('ProcessNIK',ProcessLevel) as SubstitutionNIK 
               FROM tbl_profile INNER JOIN 
               tbl_profile_process ON tbl_profile_process.ProcessId = tbl_profile.ProcessCVNumber 
               WHERE bStatus=1 AND ProcessStatusForm='P') a");

    $jumlah  = mysql_num_rows($sql);

    $tab = '<div class="panel panel-primary">
                    <div class="panel-heading"><i class="glyphicon glyphicon-file"></i><strong> Form My CV</strong></div>
                    <div class="table-responsive">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nama</th>
                          <th>Tanggal Pengajuan</th>
                          <th width="15%"><div align="center">Level</div></th>
                          <th width="8%"><div align="center">Action</div></th>
                        </tr>
                      </thead>
                      <tbody>';
            $no  = 1;
            while($rows = mysql_fetch_assoc($sql)){

                $look_apv = mysql_query('SELECT * FROM tbl_profile_process WHERE ProcessId="'.$rows['ProcessId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
                $view_row  = mysql_num_rows($look_apv);

                if ($view_row >0){

                $tab .='<tr>
                          <td>'.$rows['ProcessId'].'</td>
                          <td>'.potential_profile($nik=$rows['ProcessNIK']).'</td>
                          <td>'.$rows['CreatedTime'].'</td>
                          <td><div align="center">'.level_approval_my_cv($id=$rows['ProcessId']).'</div></td>
                          <td><div align="center">
                          <a title="Accept" onclick=open_in_new_tab_and_reload("https://apps.unias.com/publish/hris2/frmMyCV/ServicesApproval.php?act=accept&id='.$rows['ProcessId'].'&mynik='.$rows['ProcessNIK'].'&token='.token_mycv($id=$rows['ProcessId'],$level=$rows['ProcessLevel']).'&proses='.$rows['ProcessLevel'].'&last_process='.$rows['ProcessLastId'].'") href="#"><span style="font-size:1.0em;" class="glyphicon glyphicon-ok"></span></a>&nbsp;&nbsp;
                          <a title="Reject" onclick=open_in_new_tab_and_reload("https://apps.unias.com/publish/hris2/frmMyCV/ServicesApproval.php?act=reject&id='.$rows['ProcessId'].'&mynik='.$rows['ProcessNIK'].'&token='.token_mycv($id=$rows['ProcessId'],$level=$rows['ProcessLevel']).'&proses='.$rows['ProcessLevel'].'&last_process='.$rows['ProcessLastId'].'") href="#"><span style="font-size:1.0em;" class="glyphicon glyphicon-remove"></span></a>
                          </div>
                          </td>
                        </tr>';
                }

                $no++;

            }                       
                        

    $tab .= '</tbody></table></div></div>';

    if (form_cv_view_total($nik,$current_nik) > 0){

        return $tab;

    }

}


function total_cuti($id){

    $query  = mysql_query('SELECT * FROM tbl_formcutidetail WHERE CutiId='.$id);
    $total  = mysql_num_rows($query);          

    return $total;
}

function tanggal_cuti($id){

    $query  = mysql_query('SELECT * FROM tbl_formcutidetail WHERE CutiId='.$id);
    $total  = mysql_num_rows($query);

    $no=1;
    $tanggal_cuti = '';
    while ($data = mysql_fetch_array($query)){
        $tanggal_cuti .= date('d-M-Y', strtotime($data['TglCuti']));

        if ($no < $total){
          $tanggal_cuti .= ', ';
        }
    $no++;
    }          

    
    
    return $tanggal_cuti;
}

function tanggal_ijin($id){

    $query  = mysql_query('SELECT * FROM tbl_formijin WHERE IjinId='.$id);
    $total  = mysql_num_rows($query);

    $tanggal = '';
    while ($data = mysql_fetch_array($query)){
        $tanggal .= date('d-M-Y H:i', strtotime($data['TglActive1']));
    }          

    
    
    return $tanggal;
}

function jenis_ijin($id){

    $query  = mysql_query('SELECT * FROM tbl_jenisijin WHERE JenisIjinId='.$id);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);   
    
    return $data['JenisIjinName'];
}

function jenis_cuti($id){

    $query  = mysql_query('SELECT * FROM tbl_jeniscuti WHERE id='.$id);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);   
    
    return $data['JenisCutiName'];
}

function jenis_hak_cuti($id){

    $query  = mysql_query('SELECT * FROM tbl_hakcuti INNER JOIN tbl_jeniscuti ON JenisHakCuti=id WHERE HakId='.$id);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);   
    
    return $data['JenisCutiName'];
}

function level_approval_cuti($id){

    $query  = mysql_query('SELECT * FROM tbl_formcuti INNER JOIN tbl_apv_matrik_approval ON ApvLevel=MatProses WHERE CutiId='.$id.' AND MatCode=1');
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['MatName'];
    }else{
        return '-';
    }  
    
}

function level_approval_ijin($id){

    $query  = mysql_query('SELECT * FROM tbl_formijin INNER JOIN tbl_apv_matrik_approval ON ApvLevel=MatProses WHERE IjinId='.$id.' AND MatCode=4');
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['MatName'];
    }else{
        return '-';
    }  
    
}

function level_approval_sisa_cuti($id){

    $query  = mysql_query('SELECT * FROM tbl_formperpcuti INNER JOIN tbl_apv_matrik_approval ON ApvLevel=MatProses WHERE FormPerpCutiId='.$id.' AND MatCode=2');
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['MatName'];
    }else{
        return '-';
    }  
    
}

function level_approval_my_cv($id){

    $query  = mysql_query('SELECT * FROM tbl_profile_process INNER JOIN tbl_apv_matrik_approval ON ProcessLevel=MatProses WHERE ProcessId='.$id.' AND MatCode=5');
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($total >0){
        return $data['MatName'];
    }else{
        return '-';
    }  
    
}


function tanggal_hak_cuti($id){

    $query  = mysql_query('SELECT * FROM tbl_hakcuti WHERE HakId='.$id);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    $tanggal1 = date('d-M-Y', strtotime($data['Periode1']));
    $tanggal2 = date('d-M-Y', strtotime($data['Periode2']));   
    
    return $tanggal1.' s/d '.$tanggal2;
}

function tanggal_hak_cuti_perpanjang($id){

    $query  = mysql_query('SELECT * FROM tbl_hakcuti WHERE HakId='.$id);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);
    $isa    = strtotime($data['Periode2']);

    $next_date = date('d-M-Y',strtotime('+6 month',$isa));

    return $next_date;
}

function tanggal_masuk_cuti($id){

    $query  = mysql_query('SELECT * FROM tbl_formcuti WHERE CutiId='.$id);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);  
    
    $tanggal_masuk_cuti = date('d-M-Y', strtotime($data['TglMasuk']));

    return $tanggal_masuk_cuti;
}

function token_cuti($id,$level){

    $query  = mysql_query('SELECT * FROM tbl_formcuti WHERE CutiId='.$id);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($level == 1){
        $before     = '';
        $txttoken   = 'Pin'.$before;
        $mytoken    = $data[$txttoken];

    }
    else {
        $before     = $level-1;
        $txttoken   = 'Pin'.$before;
        $mytoken    = $data[$txttoken];
    }

    return $mytoken;
}

function token_ijin($id,$level){

    $query  = mysql_query('SELECT * FROM tbl_formijin WHERE IjinId='.$id);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($level == 1){
        $before     = '';
        $txttoken   = 'Pin'.$before;
        $mytoken    = $data[$txttoken];

    }
    else {
        $before     = $level-1;
        $txttoken   = 'Pin'.$before;
        $mytoken    = $data[$txttoken];
    }

    return $mytoken;
}

function token_sisa_cuti($id,$level){

    $query  = mysql_query('SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId='.$id);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($level == 1){
        $before     = '';
        $txttoken   = 'Pin'.$before;
        $mytoken    = $data[$txttoken];

    }
    else {
        $before     = $level-1;
        $txttoken   = 'Pin'.$before;
        $mytoken    = $data[$txttoken];
    }

    return $mytoken;
}


function token_mycv($id,$level){

    $query  = mysql_query('SELECT * FROM tbl_profile_process WHERE ProcessId='.$id);
    $total  = mysql_num_rows($query);
    $data   = mysql_fetch_array($query);

    if ($level == 1){
        $before     = '';
        $txttoken   = 'ProcessPin'.$before;
        $mytoken    = $data[$txttoken];

    }
    else {
        $before     = $level-1;
        $txttoken   = 'ProcessPin'.$before;
        $mytoken    = $data[$txttoken];
    }

    return $mytoken;
}


function form_cuti_view_total($nik,$current_nik){

    $sql     = mysql_query("SELECT * FROM  (SELECT *,CONCAT('NIK',ApvLevel) as SubstitutionNIK FROM tbl_formcuti WHERE StatusForm='P') a");
    $jumlah  = mysql_num_rows($sql);
    @$grand  = 0;

        while($rows = mysql_fetch_assoc($sql)){

            $look_apv = mysql_query('SELECT * FROM tbl_formcuti WHERE CutiId="'.$rows['CutiId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
            $view_row  = mysql_num_rows($look_apv);

            @$grand += $view_row;                

        }

    return $grand;  


}




function form_ijin_view_total($nik,$current_nik){

    $sql     = mysql_query("SELECT * FROM  (SELECT *,CONCAT('NIK',ApvLevel) as SubstitutionNIK FROM tbl_formijin WHERE StatusForm='P') a");
    $jumlah  = mysql_num_rows($sql);
    @$grand = 0;

        while($rows = mysql_fetch_assoc($sql)){

            $look_apv = mysql_query('SELECT * FROM tbl_formijin WHERE IjinId="'.$rows['IjinId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
            $view_row  = mysql_num_rows($look_apv);

            @$grand += $view_row;                

        }

    return $grand;  


}


function form_sisa_cuti_view_total($nik,$current_nik){

    $sql     = mysql_query("select a1.*,CONCAT('NIK',ApvLevel) as SubstitutionNIK from tbl_formperpcuti a1 inner join 
                          (select max(FormPerpCutiId) as max from tbl_formperpcuti group by HakCutiId,NIK) a2 on a1.FormPerpCutiId = a2.max WHERE StatusForm='P'");
    $jumlah  = mysql_num_rows($sql);
    @$grand = 0;

        while($rows = mysql_fetch_assoc($sql)){

            $look_apv = mysql_query('SELECT * FROM tbl_formperpcuti WHERE FormPerpCutiId="'.$rows['FormPerpCutiId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
            $view_row  = mysql_num_rows($look_apv);

            @$grand += $view_row;                

        }

    return $grand;  


}


function form_cv_view_total($nik,$current_nik){

    $sql     = mysql_query("SELECT * FROM  (SELECT `ProcessId`, `ProcessNIK`, `ProcessLevel`, `ProcessStatusForm`, `ProcessNIK1`, `ProcessNIK2`, `ProcessApv1`, `ProcessApv2`, `ProcessPin`, `ProcessPin1`, `ProcessPin2`, `ProcessDate1`, `ProcessDate2`, `ProcessRemark1`, `ProcessRemark2`, `PorcessAlasanApv`, `ProcessLastId`, `ProcessRepeated`,CONCAT('ProcessNIK',ProcessLevel) as SubstitutionNIK 
               FROM tbl_profile INNER JOIN 
               tbl_profile_process ON tbl_profile_process.ProcessId = tbl_profile.ProcessCVNumber 
               WHERE bStatus=1 AND ProcessStatusForm='P') a");
    $jumlah  = mysql_num_rows($sql);
    @$grand = 0;

        while($rows = mysql_fetch_assoc($sql)){

            $look_apv = mysql_query('SELECT * FROM tbl_profile_process WHERE ProcessId="'.$rows['ProcessId'].'" AND '.$rows['SubstitutionNIK'].'='.$current_nik);
            $view_row  = mysql_num_rows($look_apv);

            @$grand += $view_row;                

        }

    return $grand;  


}


function all_form_view_total($nik,$current_nik){

    $grand_total = form_cuti_view_total($nik,$current_nik);
    $grand_total += form_ijin_view_total($nik,$current_nik);
    $grand_total += form_sisa_cuti_view_total($nik,$current_nik);
    $grand_total += form_cv_view_total($nik,$current_nik);          

    return $grand_total;  


}


function all_potential_user_form($nik){

    $query  = mysql_query('SELECT * FROM `tbl_substitution_potential` INNER JOIN tbl_profile ON NIK=CurrentNIK WHERE PotentialNIK="'.$nik.'" GROUP BY CurrentNIK ORDER BY Nama ASC');
    $total  = mysql_num_rows($query);

    $total = 0;
    while($data = mysql_fetch_assoc($query)){

        $total += all_form_view_total($nik,$current_nik=$data['CurrentNIK']);

    }



    return $total;

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


function count_days_cuti($id){

      $query  = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId='$id'");
      $total  = mysql_num_rows($query);
      $data   = mysql_fetch_array($query);

      $startTimeStamp = strtotime($data['TglActive1']);
      $endTimeStamp   = strtotime($data['TglActive2']);
      $timeDiff     = abs($endTimeStamp - $startTimeStamp);
      $numberDays   = $timeDiff/86400;  // 86400 seconds in one day
      $numberDays   = intval($numberDays+1);

      return $numberDays;

}

function active_days_cuti($id){

      $query  = mysql_query("SELECT * FROM tbl_formcuti WHERE CutiId='$id'");
      $total  = mysql_num_rows($query);
      $data   = mysql_fetch_array($query);

      $TglActive1   = date('d-M-Y', strtotime($data['TglActive1']));
      $TglActive2   = date('d-M-Y', strtotime($data['TglActive2']));

      return $TglActive1.' s/d '.$TglActive2;

}


?>


<div id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="demo" class="label label-success"></span></h4>
      </div>
      <div class="modal-body">
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>


<script>
function open_in_new_tab_and_reload(url){
    window.open(url, '_blank');
    window.focus();
    location.reload();
}
</script>


<script type="text/javascript">
function newDoc(id) {
    window.location.assign("#"+id);
    document.getElementById("demo").innerHTML = "Detail #"+id;
    document.getElementById("myValue").innerHTML = id;

}
</script>

<script type="text/javascript">
var base_url = '<?php echo base_url()?>';
        $(function(){
            $(document).on('click','.detail-cuti',function(e){

                e.preventDefault();
                cache: false;
                document.getElementById("demo").innerHTML = "Detail #"+$(this).attr('data-id');
                
                $("#myModal").modal('show');

                $.post(base_url+'karyawan/frmTasks/',
                    {cuti_id:$(this).attr('data-id')},
                    function(html){                      
                        $(".modal-body").html(html);                        
                    }   
                );
            });

        });
</script>

<script type="text/javascript">
var base_url = '<?php echo base_url()?>';
        $(function(){
            $(document).on('click','.detail-ijin',function(e){
                cache: false,
                e.preventDefault();
                document.getElementById("demo").innerHTML = "Detail #"+$(this).attr('data-id');
                $("#myModal").modal('show');
                $.post(base_url+'karyawan/frmTasks/',
                    {ijin_id:$(this).attr('data-id')},
                    function(html){                      
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>

<script type="text/javascript">
var base_url = '<?php echo base_url()?>';
        $(function(){
            $(document).on('click','.detail-sisa',function(e){
                cache: false,
                e.preventDefault();
                document.getElementById("demo").innerHTML = "Detail #"+$(this).attr('data-id');
                $("#myModal").modal('show');
                $.post(base_url+'karyawan/frmTasks/',
                    {sisa_id:$(this).attr('data-id')},
                    function(html){                      
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
</script>

<script type="text/javascript">
    $('#myModal').on('hidden.bs.modal', function () {
            $('.modal-body').find('lable,input,textarea,table,tr,td').val('');
            
    });
</script>