<script type="text/javascript">
  $(function() {
    status_bobot_note();
  });
</script>


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$performance_management=1;


$asset = new CMS_Asset();
foreach($css_files as $file){
    $asset->add_css($file);
}
echo $asset->compile_css();

foreach($js_files as $file){
    $asset->add_js($file);
}

echo $asset->compile_js();

$crud = new user_key_performance_indicator();

?>



<style>

table tr td{
	font-size:12px;
	color: #000000;
  border:1px solid gray;
}
.action-tools{
  font-size: 10px !important;
}

table td{
  padding: 1px;
}
.container {
  width: 100%;
}

.notes{
  font-size: 11px;
}

.link
{
   color:#000000 !important;
   text-decoration: none; 
   background-color: none;
}
.help-block{
  font-size: 9px;
}

/*
#del_icon {
  display: none;
}

#edit_icon {
  display: none;
}
*/



</style>
<div class="row">
<?php echo $period_option; ?>

<div class="col-sm-8">
<div class="btn-group pull-right">
        
    <a href="{{ MODULE_SITE_URL }}user_key_performance_indicator" class="btn btn-default <?php echo $crud->navigation_name('');?>" title="{{ language:Result }}"><i class="glyphicon glyphicon-list-alt"></i> RESULT</a>

    <a href="{{ MODULE_SITE_URL }}user_key_performance_indicator/header_form" class="btn btn-default <?php echo $crud->navigation_name('header_form');?>" title="{{ language:IPP (Individual Performance Plan) }}"><i class="glyphicon glyphicon-tasks"></i> IPP</a>

    <?php if ($key_agree == 0){ ?>
    <a href="javascript:void(0);" onclick="add_plan('<?php echo $primary_key;?>')" class="btn btn-primary" title="Tambah Activity Plan"><i class="glyphicon glyphicon-plus-sign"></i> Add Plan</a>
    <?php } ?>

    <?php if ($key_nik_atasan != $session_nik && $key_agree == 0){ ?>
    <a href="javascript:void(0);" class="btn btn-danger" title="{{ language:Belum Sepakat }}"><i class="glyphicon glyphicon-ban-circle"></i> UNAPPROVED</a>
    <?php }  ?>

    <?php if ($key_nik_atasan != $session_nik && $key_agree == 1){ ?>
    <a href="javascript:void(0);" class="btn btn-success" title="{{ language:Sudah Sepakat }}"><i class="glyphicon glyphicon-thumbs-up"></i> APPROVED</a>
    <?php }  ?>


    <?php if ($key_nik_atasan == $session_nik && $key_agree == 0){

    if($key_type == 2){

      if ($crud->summing_bobot_user($primary_key, $type=1) < 100){
          $btn_status = 'disabled';
      }
      elseif($crud->summing_bobot_user($primary_key, $type=4) < 100){
          $btn_status = 'disabled';
      }
      elseif($crud->summing_bobot_user($primary_key, $type=5) < 100){
          $btn_status = 'disabled';
      }
      else{
        $btn_status = '';
      }
    }
    else{
      if ($crud->summing_bobot_user($primary_key, $type=1) < 100){
          $btn_status = 'disabled';
      }
      elseif($crud->summing_bobot_user($primary_key, $type=4) < 100){
          $btn_status = 'disabled';
      }
      else{
        $btn_status = '';
      }
    } 


    ?>

    <a href="javascript:void(0);" onclick="deal_plan('<?php echo $primary_key;?>')" class="btn btn-success" title="{{ language:Sepakat }}" <?php echo $btn_status?>><i class="glyphicon glyphicon-thumbs-up"></i> APPROVED</a>
    <a href="javascript:void(0);" onclick="undeal_plan('<?php echo $primary_key;?>')" class="btn btn-warning" title="{{ language:Tidak Sepakat }}"><i class="glyphicon glyphicon-pencil"></i> Review</a>
    <?php }  ?>

    <?php if ($key_nik_atasan == $session_nik && $key_agree == 1){ ?>
    <a href="javascript:void(0);" onclick="deal_plan('<?php echo $primary_key;?>')" class="btn btn-success" title="{{ language:Sepakat }}" <?php echo $btn_status?>><i class="glyphicon glyphicon-thumbs-up"></i> APPROVED</a> 
    <a href="javascript:void(0);" onclick="undeal_plan('<?php echo $primary_key;?>')" class="btn btn-danger" title="{{ language:Tidak Sepakat }}"><i class="glyphicon glyphicon-ban-circle"></i> UNAPPROVED</a>
    <?php } ?>


    

    
<!--
    <a href="{{ MODULE_SITE_URL }}user_key_performance_indicator/activity_plan" class="btn btn-default <?php echo $crud->navigation_name('activity_plan');?>" title="{{ language:KPI-KEY PERFORMANCE INDICATOR (Berdasarkan KPI evaluation yang mengacu pada Activity Plan) }}"><i class="glyphicon glyphicon-plane"></i></a>

    <a href="{{ MODULE_SITE_URL }}user_key_performance_indicator/routine_activity" class="btn btn-default <?php echo $crud->navigation_name('routine_activity');?>" title="{{ language:PERFORMANCE INDICATOR (ROUTINE ACTIVITY) }}"><i class="glyphicon glyphicon-tag"></i></a>

    <a href="{{ MODULE_SITE_URL }}user_key_performance_indicator/special_assignment" class="btn btn-default <?php echo $crud->navigation_name('special_assignment');?>" title="{{ language:SPECIAL ASSIGNMENT }}"><i class="glyphicon glyphicon-comment"></i></a>
-->
</div>


</div>

</div>


<br/>
<br/>

<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size:12px">
  
  <!--
  <tr>
    <th colspan="2" scope="col"><div align="left">NO. DOK</div></th>
    <th width="176" bgcolor="#666666" scope="col">&nbsp;</th>
    <th colspan="13" rowspan="4" scope="col" class="text-right"><?php echo $costum_user_logo ?></th>
  </tr>
  <tr>
    <td colspan="2">NO. REVISI</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">TGL. PEMBUATAN</td>
    <td bgcolor="#CCCCCC"><?php echo date('d-M-Y', strtotime($result['CreatedTime']))?></td>
  </tr>
  <tr>
    <td colspan="2">TGL. BERLAKU</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
  </tr>

-->


  <tr>
    <td colspan="2" width="4%">NAMA</td>
    <td width="20%"><?php echo $result['EmployeeID'].'/'.$crud->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $result['EmployeeID']);?></td>

    <?php if ($key_type == 1){ ?>
    <td colspan="15" rowspan="3" bgcolor="#CCCCCC"><div align="center"><strong>PERFORMANCE APPRAISAL FORM<br /> TANPA BAWAHAN (ANALYST/OFFICER)</strong></div></td>
    <?php } else { ?>
    <td colspan="15" rowspan="3" bgcolor="#CCCCCC"><div align="center"><strong>PERFORMANCE APPRAISAL FORM<br /> ADA BAWAHAN (MANAJERIAL)</strong></div></td>
    <?php } ?>

  </tr>
  <tr>
    <td colspan="2">Company</td>
    <td><?php echo $crud->cms_table_data($table_name='tbl_company', $where_column='iCompanyId', $result_column='cCompanyName', $result['CompanyID']);?></td>
  </tr>
  <tr>
    <td colspan="2">DIVISI</td>
    <td><?php echo $crud->cms_table_data($table_name='tbl_div', $where_column='iDivId', $result_column='cDivName', $result['DivisionID']);?></td>
  </tr>
  <tr>
    <td colspan="2">DEPARTMENT</td>
    <td><?php echo $crud->cms_table_data($table_name='tbl_dept', $where_column='iDeptID', $result_column='cDeptName', $result['DepartmentID']);?></td>
    <td colspan="4" rowspan="4"><div align="center"><strong>PERFORMANCE PLAN </strong></div></td>
    <td colspan="6" rowspan="4"><div align="center"><strong>PERFORMANCE MONITORING</strong></div></td>
    <td colspan="5" rowspan="4"><div align="center"><strong>PERFORMANCE APPRAISAL</strong></div></td>
  </tr>
  <tr>
    <td colspan="2">JABATAN/ GRADE</td>
    <td><?php echo $crud->cms_table_data($table_name='tbl_jabatan', $where_column='JabatanId', $result_column='NamaJabatan', $crud->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='JabatanID', $result['EmployeeID']));?> / <?php echo $result['iGrade'];?></td>
  </tr>
  <tr>
    <td colspan="2">PERIODE </td>
    <td><?php echo $result['PeriodID']?></td>
  </tr>
  <tr>
    <td colspan="2">Atasan Penilai</td>
    <td><?php echo $result['iAtasanNIK'].'/'.$crud->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $result['iAtasanNIK']);?></td>
  </tr>

  <tr>
    <td width="28" rowspan="4" width="5%"><div align="center"><strong>NO</strong></div></td>
    <td colspan="2" rowspan="4"><div align="center"><strong>ACTIVITY PLAN</strong></div></td>
    <td width="3%" rowspan="4"><div align="center"><strong>UoM</strong></div></td>
    <td width="5%" rowspan="4"><div align="center"><strong>DD</strong></div></td>
    <td width="3%" rowspan="4"><div align="center"><strong>Bobot (%)</strong></div></td>
    <td width="8%" rowspan="4"><div align="center"><strong>PLAN</strong></div></td>
    <td colspan="2" rowspan="2"><div align="center"><strong>ACTUAL</strong></div></td>
    <td width="3%" colspan="3" rowspan="2"><div align="center"><strong>% Achieve<br />ment </strong></div></td>
    <td rowspan="4" width="15%"><div align="center"><strong>Catatan Karyawan</strong></div></td>
    <td style="width: 20%;" colspan="4"><div align="center"><strong>Penilaian</strong></div></td>    
    <td rowspan="4" width="15%"><div align="center"><strong>Catatan Atasan</strong></div></td>
  </tr>
  <tr>
    <td style="width: 5%;" rowspan="3"><div align="center"><strong>Atasan <br> Skala (1-5)</strong></div></td>
    <td style="width: 5%;" rowspan="3"><div align="center"><strong>Bawahan <br> Skala (1-5)</strong></div></td>
    <td style="width: 5%;" rowspan="3"><div align="center"><strong>Akhir <br> Skala (1-5)</strong></div></td>
    <td style="width: 5%;" rowspan="3"><div align="center"><strong>Score <br> Akhir</strong></div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"><strong>Semester</strong></div></td>
    <td colspan="2"><div align="center"><strong>Semester</strong></div></td>
    <td rowspan="2"><div align="center"><strong>Nilai</strong></div></td>
  </tr>

  <tr>
    <td><div align="center"><strong>1</strong></div></td>
    <td><div align="center"><strong>2</strong></div></td>
    <td><div align="center"><strong>1</strong></div></td>
    <td><div align="center"><strong>2</strong></div></td>
    
  </tr>



  <tr>
    <td colspan="18" bgcolor="#CCCCCC" style="border-top:3px double #000000"><strong>A. RESULT</strong></td>
  </tr>
  <tr>
    <td bgcolor="#ffffe6"><strong>I</strong></td>
    <td colspan="17" height="20"><strong>KPI -KEY PERFORMANCE INDICATOR (Berdasarkan KPI evaluation yang mengacu pada Activity Plan) (BOBOT = <?php echo $crud->set_bobot_nilai_user($primary_key, $type=1)?>%)</strong> <a href="javascript:void(0)" onclick="callback_monitor_global('<?php echo $primary_key;?>',1)" class="link pull-right action-tools monitor" title="{{ language:Monitor }}"><i class="glyphicon glyphicon-comment"></i> Monitor</a></td>
  </tr>
  

  		<?php

      if($performance_management == 1){
        $SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM2)/Plan_B)*100 AS Achieve, (SM1/(Plan_B))*100 AS AchSM1, (SM2/(Plan_B))*100 AS AchSM2, MonRemarks, MonRemarksAtasan, photo 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=1";
        $query  = $this->db->query($SQL);
      }
      else{
        $SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM2)/Plan_B)*100 AS Achieve, (SM1/(Plan_B))*100 AS AchSM1, (SM2/(Plan_B))*100 AS AchSM2, MonRemarks, MonRemarksAtasan, photo 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=1 AND (EmployeeID='".$session_nik."' OR iAtasanNIK='".$session_nik."' OR iAtasanNIK2='".$session_nik."')";

        $query  = $this->db->query($SQL);
      }
      


      /*
  		$query = $this->db->select('activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM1+SM2)/Plan_B)*100 AS Achieve')
               ->from('tbl_kpi_activity_plan')
               ->join('tbl_kpi_header_form','tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID')
               ->where('tbl_kpi_activity_plan.KPIID', $primary_key)
               ->where('ItemID', 1)
               ->where('EmployeeID', $session_nik)           
               ->get();
      */
        $no=1;
        $total_bobot_1 = 0;
        $total_score_1 = 0;
        $average_A1 = 0;
        $num_row_A1 = $query->num_rows();

        foreach($query->result() as $data){ 
        	$total_bobot_1 += $data->Bobot_A;
          //$nilai_akhir = number_format(($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)/2,1);
          $nilai_akhir = number_format($data->Nilai_Skala_Atasan,1); //perubahan data tanpa akumuliasi
          $score_akhir = ($nilai_akhir * $data->Bobot_A)/100;
          $total_score_1 += $score_akhir;
          $average_A1 += $data->Achieve;



          if($no % 2 == 1){
              $erow = 'erow';
          }
          else{
              $erow = '';
          }
        ?>
        	<tr class="<?php echo $erow?> result" height="18">
			    <td class="text-right"><?php echo $no?>.</td>
			    <td colspan="2"><a href="javascript:void(0);" onclick="edit_plan('<?php echo $data->activity_id;?>')" title="Edit" class="link"><?php echo $data->Description?></a> &nbsp;&nbsp;


            <?php if ($key_agree == 0 && $key_active ==1){ ?>
            <a href="javascript:void(0);" onclick="delete_plan('<?php echo $data->activity_id;?>')" title="Delete" id="del_icon" class="link pull-right action-tools"><i class="glyphicon glyphicon-remove"></i> Delete</a>&nbsp;&nbsp;
            <?php } ?>

            <?php if ($key_agree == 1 && $key_active ==1){ ?>            
            <a href="javascript:void(0);" onclick="monitoring_plan('<?php echo $data->activity_id;?>')" title="Monitor" class="link pull-right action-tools" style="padding-right:5px"><i class="glyphicon glyphicon-comment"></i> Monitor</a>&nbsp;&nbsp;
            <?php } ?>

            <?php 
            if (!is_null($data->photo) && !empty($data->photo) && $data->photo != ''){
                echo '<a href="{{ base_url }}assets/files/upload_pa/'.$data->photo.'" target="_blank" title="Attachment" id="file_icon" class="link action-tools"><i class="glyphicon glyphicon-paperclip"></i></a>&nbsp;&nbsp;';
            }
            ?>

          </td>
			    <td class="text-center" width="4%"><?php echo $data->UoM ?></td>
			    <td class="text-center" width="7%"><?php echo date('d-M-Y', strtotime($data->DD))?></td>
			    <td class="text-center"><?php echo $data->Bobot_A ?></td>
			    <td class="text-center"><?php echo number_format($data->Plan_B , 0, ',', '.') ?></td>
			    <td class="text-center"><?php echo number_format($data->SM1, 0, ',', '.') ?></td>
          <td class="text-center"><?php echo number_format($data->SM2, 0, ',', '.') ?></td>
			    <td class="text-center"><?php echo number_format($data->AchSM1,0) ?></td>
          <td class="text-center"><?php echo number_format($data->AchSM2,0) ?></td>
          <td class="text-center"><?php echo number_format($data->Achieve,0) ?></td>
          <td class="text-left notes"><?php echo $data->MonRemarks ?></td>
          <td class="text-center"><?php echo $crud->set_nilai_skala($data->Achieve) ?></td>			    
			    <td class="text-center <?php if($data->Nilai_Skala_Atasan=='0'){ echo 'bg-danger'; } else { echo $data->Nilai_Skala_Atasan; } ?>" width="5%" ><?php echo $data->Nilai_Skala_Atasan ?></td>			    
			    <td class="text-center" width="5%"><?php echo $nilai_akhir;?></td>
			    <td class="text-center" width="3%"><?php echo number_format($score_akhir,2);?></td>
			    <td class="text-left notes"><?php echo $data->MonRemarksAtasan ?></td>
		  	</tr>

        <?php 
        $no++;
        }
        ?>

  <tr>
    <td colspan="18">&nbsp;</td>    
  </tr>
  <tr>
    <td bgcolor="#e6f2ff"><strong>II</strong></td>
    <td colspan="17" height="20"><strong>PERFORMANCE INDICATOR (ROUTINE ACTIVITY) </strong></td>
  </tr>


  		<?php

      if($performance_management == 1){
        $SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM2)/Plan_B)*100 AS Achieve,(SM1/(Plan_B))*100 AS AchSM1, (SM2/(Plan_B))*100 AS AchSM2, MonRemarks, MonRemarksAtasan, photo 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=2";
        $query  = $this->db->query($SQL);
      }
      else{
        $SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM2)/Plan_B)*100 AS Achieve,(SM1/(Plan_B))*100 AS AchSM1, (SM2/(Plan_B))*100 AS AchSM2, MonRemarks, MonRemarksAtasan, photo 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=2 AND (EmployeeID='".$session_nik."' OR iAtasanNIK='".$session_nik."' OR iAtasanNIK2='".$session_nik."')";
        $query  = $this->db->query($SQL);
      }
  		

        $no=1;
        $total_bobot_2 = 0;
        $total_score_2 = 0;
        $average_A2 = 0;
        $num_row_A2 = $query->num_rows();

        foreach($query->result() as $data){
        	$total_bobot_2 += $data->Bobot_A;
          //$nilai_akhir = number_format(($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)/2,1);
          $nilai_akhir = number_format($data->Nilai_Skala_Atasan,1); //perubahan data tanpa akumulasi          
          $score_akhir = ($nilai_akhir * $data->Bobot_A)/100;
          //$nilai_akhir = ($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan);
          //$score_akhir = ((($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)* $data->Bobot_A)/100);
          $total_score_2 += $score_akhir;
          $average_A2 += $data->Achieve;


          if($no % 2 == 1){
              $erow = 'erow';
          }
          else{
              $erow = '';
          }
        ?>
        	<tr class="<?php echo $erow?> result" height="18">
			    <td class="text-right"><?php echo $no?>.</td>
			    <td colspan="2"><a href="javascript:void(0);" onclick="edit_plan('<?php echo $data->activity_id;?>')" title="Edit" class="link"><?php echo $data->Description?></a> &nbsp;

            <?php if ($key_agree == 0 && $key_active ==1){ ?>
            <a href="javascript:void(0);" onclick="delete_plan('<?php echo $data->activity_id;?>')" title="Delete" class="link pull-right action-tools"><i class="glyphicon glyphicon-remove"></i> Delete</a>&nbsp;&nbsp;
            <?php } ?>

            <?php if ($key_agree == 1 && $key_active ==1){ ?>            
            <a href="javascript:void(0);" onclick="monitoring_plan('<?php echo $data->activity_id;?>')" title="Monitor" class="link pull-right action-tools" style="padding-right:5px"><i class="glyphicon glyphicon-comment"></i> Monitor</a>&nbsp;&nbsp;
            <?php } ?>

            <?php 
            if (!is_null($data->photo) || !empty($data->photo) || $data->photo != ''){
                echo '<a href="{{ base_url }}assets/files/upload_pa/'.$data->photo.'" target="_blank" title="Attachment" id="file_icon" class="link action-tools"><i class="glyphicon glyphicon-paperclip"></i></a>&nbsp;&nbsp;';
            }
            ?>

			    <td class="text-center"><?php echo $data->UoM ?></td>
			    <td class="text-center"><?php echo date('d-M-Y', strtotime($data->DD))?></td>
			    <td class="text-center"><?php echo $data->Bobot_A ?></td>
			    <td class="text-center"><?php echo number_format($data->Plan_B , 0, ',', '.') ?></td>
			    <td class="text-center"><?php echo number_format($data->SM1, 0, ',', '.') ?></td>
          <td class="text-center"><?php echo number_format($data->SM2, 0, ',', '.') ?></td>
			    <td class="text-center"><?php echo number_format($data->AchSM1,0) ?></td>
          <td class="text-center"><?php echo number_format($data->AchSM2,0) ?></td>
          <td class="text-center"><?php echo number_format($data->Achieve,0) ?></td>
			    <td width="100"><?php echo $data->MonRemarks; ?></td>
			    <td class="text-center"><?php echo $crud->set_nilai_skala($data->Achieve) ?></td>  
			    <td class="text-center <?php if($data->Nilai_Skala_Atasan=='0'){ echo 'bg-danger'; } else { echo $data->Nilai_Skala_Atasan; } ?>"><?php echo $data->Nilai_Skala_Atasan ?></td>
			    <td class="text-center"><?php echo $nilai_akhir;?></td>
          <td class="text-center"><?php echo number_format($score_akhir,2);?></td>
			    <td class="text-left notes"><?php echo $data->MonRemarksAtasan ?></td>
		  	</tr>

        <?php 
        $no++;
        }
        ?>
  <tr>
    <td colspan="18">&nbsp;</td>    
  </tr>
  <tr>
    <td bgcolor="#e6ffe6"><strong>III</strong></td>
    <td colspan="17" height="20"><strong>SPECIAL ASSIGNMENT </strong></td>
  </tr>
  <?php

      if($performance_management == 1){
        $SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM2)/Plan_B)*100 AS Achieve, (SM1/(Plan_B))*100 AS AchSM1, (SM2/(Plan_B))*100 AS AchSM2, MonRemarks, MonRemarksAtasan, photo 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=3";
        $query  = $this->db->query($SQL);
      }
      else{
        $SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM2)/Plan_B)*100 AS Achieve, (SM1/(Plan_B))*100 AS AchSM1, (SM2/(Plan_B))*100 AS AchSM2, MonRemarks, MonRemarksAtasan, photo 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=3 AND (EmployeeID='".$session_nik."' OR iAtasanNIK='".$session_nik."' OR iAtasanNIK2='".$session_nik."')";
        $query  = $this->db->query($SQL);
      }
  		

        $no=1;
        $total_bobot_3 = 0;
        $total_score_3 = 0;
        $average_A3 = 0;
        $num_row_A3 = $query->num_rows();
        foreach($query->result() as $data){
        	$total_bobot_3 += $data->Bobot_A;
          //$nilai_akhir = number_format(($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)/2,1);
          $nilai_akhir = number_format($data->Nilai_Skala_Atasan,1); //perubahan tanpa akumulisi
          $score_akhir = ($nilai_akhir * $data->Bobot_A)/100;
          //$nilai_akhir = ($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan);
          //$score_akhir = ((($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)* $data->Bobot_A)/100);
          $total_score_3 += $score_akhir;
          $average_A3 += $data->Achieve;

          if($no % 2 == 1){
              $erow = 'erow';
          }
          else{
              $erow = '';
          }

       	?>         
        	<tr class="<?php echo $erow?> result" height="18">
			    <td class="text-right"></i><?php echo $no?>.</td>
			    <td colspan="2"><a href="javascript:void(0);" onclick="edit_plan('<?php echo $data->activity_id;?>')" title="Edit" class="link"><?php echo $data->Description?></a> &nbsp;

            <?php if ($key_agree == 0 && $key_active ==1){ ?>
            <a href="javascript:void(0);" onclick="delete_plan('<?php echo $data->activity_id;?>')" title="Delete" class="link pull-right action-tools"><i class="glyphicon glyphicon-remove"></i> Delete</a>&nbsp;&nbsp;
            <?php } ?>

            <?php if ($key_agree == 1 && $key_active ==1){ ?>            
            <a href="javascript:void(0);" onclick="monitoring_plan('<?php echo $data->activity_id;?>')" title="Monitor" class="link pull-right action-tools" style="padding-right:5px"><i class="glyphicon glyphicon-comment"></i> Monitor</a>&nbsp;&nbsp;
            <?php } ?>

            <?php 
            if (!is_null($data->photo) || !empty($data->photo) || $data->photo != ''){
                echo '<a href="{{ base_url }}assets/files/upload_pa/'.$data->photo.'" target="_blank" title="Attachment" id="file_icon" class="link action-tools"><i class="glyphicon glyphicon-paperclip"></i></a>&nbsp;&nbsp;';
            }
            ?>

			    <td class="text-center"><?php echo $data->UoM ?></td>
			    <td class="text-center"><?php echo date('d-M-Y', strtotime($data->DD))?></td>
			    <td class="text-center"><?php echo $data->Bobot_A ?></td>
			    <td class="text-center"><?php echo number_format($data->Plan_B , 0, ',', '.') ?></td>
			    <td class="text-center"><?php echo number_format($data->SM1, 0, ',', '.') ?></td>
          <td class="text-center"><?php echo number_format($data->SM2, 0, ',', '.') ?></td>
			    <td class="text-center"><?php echo number_format($data->AchSM1,0) ?></td>
          <td class="text-center"><?php echo number_format($data->AchSM2,0) ?></td>
          <td class="text-center"><?php echo number_format($data->Achieve,0) ?></td>
			    <td width="100"><?php echo $data->MonRemarks; ?></td>
			    <td class="text-center"><?php echo $crud->set_nilai_skala($data->Achieve) ?></td>  
			    <td class="text-center <?php if($data->Nilai_Skala_Atasan=='0'){ echo 'bg-danger'; } else { echo $data->Nilai_Skala_Atasan; } ?>"><?php echo $data->Nilai_Skala_Atasan ?></td>
			    <td class="text-center"><?php echo $nilai_akhir;?></td>
          <td class="text-center"><?php echo number_format($score_akhir,2);?></td>
			    <td class="text-left notes"><?php echo $data->MonRemarksAtasan ?></td>
		  	</tr>

        <?php 
        $no++;
        }
        ?>
  <tr>
    <td colspan="18">&nbsp;</td>    
  </tr>
  <tr style="font-weight: bold">
    <td colspan="3">&nbsp;</td>   
    <td colspan="2" style="color:#000000" class="text-center">TOTAL BOBOT (A)</td>

    <?php 
      $sum_bobot_A = ($total_bobot_1+$total_bobot_2+$total_bobot_3);
      $sum_average_A = ($average_A1+$average_A2+$average_A3);
      $sum_row_A = ($num_row_A1+$num_row_A2+$num_row_A3);

      $crud->update_total_score($primary_key, $column='x_bar_A', number_format(($sum_average_A/$sum_row_A),2));

      if ($sum_bobot_A < 100){
        $sty = '#FF0000';
      }
      else{
        $sty = '';
      }
    ?>
    <td style="color:#000000" bgcolor="<?php echo $sty?>" class="text-center"><?php echo ($total_bobot_1+$total_bobot_2+$total_bobot_3);?>%
    <input type="hidden" id="total_bobot_A" value="<?php echo ($total_bobot_1+$total_bobot_2+$total_bobot_3);?>" />
    </td>
       
    <td colspan="5" class="text-right">x-bar</td>    
    <td class="text-center"><?php echo number_format(($sum_average_A/$sum_row_A),0);?>%</td>
    <td>&nbsp;</td>
    
    <td colspan="3" style="color:#000000" class="text-right">TOTAL SCORE (A)</td>
    <td style="color:#000000" class="text-center"><?php echo number_format(($total_score_1+$total_score_2+$total_score_3),2);?></td>
    <td>&nbsp;</td>
  </tr>

  <tr style="font-weight: bold">  
    
    <td colspan="13"></td>
    
    <td colspan="3" bgcolor="#000000" style="color:#FFFFFF" class="text-right">TOTAL SCORE (A) x Bobot</td>
    <td bgcolor="#000000" style="color:#FFFFFF" class="text-center">
      <?php
      $bobot_nilai = $crud->set_bobot_nilai_user($primary_key, $type=1);
      $bobot_nilai_A = (($total_score_1+$total_score_2+$total_score_3)*$bobot_nilai)/100; 

      $__bobot_nilai_A =  number_format($bobot_nilai_A,2);

      echo number_format($bobot_nilai_A,2);

      $crud->update_total_score($primary_key, $column='total_score_A', number_format($bobot_nilai_A,2));

      ?>
      
    </td>
    <td>&nbsp;</td>
  </tr>


  <tr>
    <td colspan="18">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="18" bgcolor="#CCCCCC"><strong>B. PROCESS / COMPETENCY</strong> <a href="javascript:void(0)" onclick="callback_monitor_global('<?php echo $primary_key;?>',4)" class="link pull-right action-tools monitor" title="{{ language:Monitor }}"><i class="glyphicon glyphicon-comment"></i> Monitor</a></td>
  </tr>

  <tr>
    <td style="border-bottom:3px double #000000;font-weight: bold" bgcolor="#ffe6ff">I</td>
    <td style="border-bottom:3px double #000000;" colspan="17" height="20"><strong>PROCESS & CORE VALUES (BOBOT = <?php echo $crud->set_bobot_nilai_user($primary_key, $type=2)?>%)</strong></td>
    <!--<td style="border-bottom:3px double #000000;" colspan="4" class="text-center">&nbsp;</td>
    <td style="border-bottom:3px double #000000;" colspan="9">&nbsp;</td>-->
  </tr>

      <?php

      if($performance_management == 1){
        $SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM2)/Plan_B)*100 AS Achieve, (SM1/(Plan_B))*100 AS AchSM1, (SM2/(Plan_B))*100 AS AchSM2, MonRemarks, MonRemarksAtasan, photo 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=4";
        $query  = $this->db->query($SQL);
      }
      else{
        $SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM2)/Plan_B)*100 AS Achieve, (SM1/(Plan_B))*100 AS AchSM1, (SM2/(Plan_B))*100 AS AchSM2, MonRemarks, MonRemarksAtasan, photo 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=4 AND (EmployeeID='".$session_nik."' OR iAtasanNIK='".$session_nik."' OR iAtasanNIK2='".$session_nik."')";
        $query  = $this->db->query($SQL);
      }
      

        $no=1;
        $total_bobot_4 = 0;
        $total_score_4 = 0;
        $average_B = 0;
        $num_row_B = $query->num_rows();
        foreach($query->result() as $data){
          $total_bobot_4 += $data->Bobot_A;
          //$nilai_akhir = number_format(($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)/2,1);
          $nilai_akhir = number_format($data->Nilai_Skala_Atasan,1);
          $score_akhir = ($nilai_akhir * $data->Bobot_A)/100;    
          //$nilai_akhir = ($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan);
          //$score_akhir = ((($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)* $data->Bobot_A)/100);
          $total_score_4 += $score_akhir;
          $average_B += $data->Achieve;

          if($no % 2 == 1){
              $erow = 'erow';
          }
          else{
              $erow = '';
          }

        ?>
        <tr class="<?php echo $erow?> result" height="18">
          <td class="text-right"></i><?php echo $no?>.</td>
          <td colspan="2"><a href="javascript:void(0);" onclick="edit_plan('<?php echo $data->activity_id;?>')" title="Edit" class="link"><?php echo $data->Description?></a> &nbsp;&nbsp;

            <?php if ($key_agree == 1 && $key_active ==1){ ?>            
            <a href="javascript:void(0);" onclick="monitoring_plan('<?php echo $data->activity_id;?>')" title="Monitor" class="link pull-right action-tools" style="padding-right:5px"><i class="glyphicon glyphicon-comment"></i> Monitor</a>&nbsp;&nbsp;
            <?php } ?>

            <?php 
            if (!is_null($data->photo) || !empty($data->photo) || $data->photo != ''){
                echo '<a href="{{ base_url }}assets/files/upload_pa/'.$data->photo.'" target="_blank" title="Attachment" id="file_icon" class="link action-tools"><i class="glyphicon glyphicon-paperclip"></i></a>&nbsp;&nbsp;';
            }
            ?>

          </td>
          <td class="text-center"><?php echo $data->UoM ?></td>
          <td class="text-center"><?php echo date('d-M-Y', strtotime($data->DD))?></td>
          <td class="text-center"><?php echo $data->Bobot_A ?></td>
          <td class="text-center"><?php echo $data->Plan_B ?></td>
          <td class="text-center"><?php echo number_format($data->SM1, 0, ',', '.') ?></td>
          <td class="text-center"><?php echo number_format($data->SM2, 0, ',', '.') ?></td>
          <td class="text-center"><?php echo number_format($data->AchSM1,0) ?></td>
          <td class="text-center"><?php echo number_format($data->AchSM2,0) ?></td>
          <td class="text-center"><?php echo number_format($data->Achieve,0) ?></td>
          <td width="100"><?php echo $data->MonRemarks; ?></td>
          <td class="text-center"><?php echo $crud->set_nilai_skala($data->Achieve) ?></td>  
          <td class="text-center <?php if($data->Nilai_Skala_Atasan=='0'){ echo 'bg-danger'; } else { echo $data->Nilai_Skala_Atasan; } ?>"><?php echo $data->Nilai_Skala_Atasan ?></td>
          <td class="text-center"><?php echo $nilai_akhir;?></td>
          <td class="text-center"><?php echo number_format($score_akhir,2);?></td>
          <td class="text-left notes"><?php echo $data->MonRemarksAtasan ?></td>
        </tr>

        <?php 
        $no++;
        }
        ?>


   <tr style="font-weight: bold">
    <td colspan="3">&nbsp;</td>   
    <td colspan="2" style="color:#000000" class="text-center">TOTAL BOBOT (BI)</td>

    <?php 
      $sum_bobot_B = ($total_bobot_4);
      $sum_average_B = ($average_B);
      $sum_row_B = ($num_row_B);

      $crud->update_total_score($primary_key, $column='x_bar_B', number_format(($sum_average_B/$sum_row_B),2));

      if ($sum_bobot_B < 100){
        $sty = '#FF0000';
      }
      else{
        $sty = '';
      }
    ?>

    <td style="color:#000000" bgcolor="<?php echo $sty?>" class="text-center"><?php echo ($total_bobot_4);?>%
    <input type="hidden" id="total_bobot_B" value="<?php echo ($total_bobot_4);?>" />

    </td>
    
    <td colspan="5" class="text-right">x-bar</td>    
    <td class="text-center"><?php echo number_format(($average_B/$sum_row_B),0);?>%</td>
    <td>&nbsp;</td>
    
    <td colspan="3" style="color:#000000" class="text-right">TOTAL SCORE (BI)</td>
    <td style="color:#000000" class="text-center"><?php echo number_format(($total_score_4),2) ?></td>
    <td>&nbsp;</td>
  </tr>

  <tr style="font-weight: bold">   
    <td colspan="13"></td>    
    <td colspan="3" bgcolor="#000000" style="color:#FFFFFF" class="text-right">TOTAL SCORE (BI) x Bobot</td>
    <td bgcolor="#000000" style="color:#FFFFFF" class="text-center">

      <?php
      $bobot_nilai = $crud->set_bobot_nilai_user($primary_key, $type=2);
      $bobot_nilai_B = (($total_score_4)*$bobot_nilai)/100;

      $__bobot_nilai_B = number_format($bobot_nilai_B,2); 

      echo number_format($bobot_nilai_B,2);

      $crud->update_total_score($primary_key, $column='total_score_B', number_format($bobot_nilai_B,2));
      ?>
    </td>
    <td>&nbsp;</td>
  </tr>

<?php if($key_type == 2){ ?>
  <tr >
    <td style="border-bottom:3px double #000000;font-weight: bold" bgcolor="#ccffee">II</td>
    <td style="border-bottom:3px double #000000;" colspan="2" height="20"><strong>MANAGING PEOPLE (BOBOT = <?php echo $crud->set_bobot_nilai_user($primary_key, $type=3)?>%)</strong></td>
    <td style="border-bottom:3px double #000000;" colspan="4" class="text-center">BOBOT %</td>
    <td style="border-bottom:3px double #000000;" colspan="11"><a href="javascript:void(0)" onclick="callback_monitor_global('<?php echo $primary_key;?>',5)" class="link pull-right action-tools monitor" title="{{ language:Monitor }}"><i class="glyphicon glyphicon-comment"></i> Monitor</a></td>
  </tr>


      <?php

      if($performance_management == 1){
        $SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM2)/Plan_B)*100 AS Achieve, (SM1/(Plan_B))*100 AS AchSM1, (SM2/(Plan_B))*100 AS AchSM2, MonRemarks, MonRemarksAtasan, photo 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=5";
        $query  = $this->db->query($SQL);
      }
      else{
        $SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM2)/Plan_B)*100 AS Achieve, (SM1/(Plan_B))*100 AS AchSM1, (SM2/(Plan_B))*100 AS AchSM2, MonRemarks, MonRemarksAtasan, photo 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=5 AND (EmployeeID='".$session_nik."' OR iAtasanNIK='".$session_nik."' OR iAtasanNIK2='".$session_nik."')";
        $query  = $this->db->query($SQL);
      }
      

        $no=1;
        $total_bobot_5 = 0;
        $total_score_5 = 0;
        $average_C = 0;
        $num_row_C = $query->num_rows();
        foreach($query->result() as $data){
          $total_bobot_5 += $data->Bobot_A;
          //$nilai_akhir = number_format(($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)/2,1);
          $nilai_akhir = number_format($data->Nilai_Skala_Atasan,1);
          $score_akhir = ($nilai_akhir * $data->Bobot_A)/100;
          //$nilai_akhir = ($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan);
          //$score_akhir = ((($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)* $data->Bobot_A)/100);
          $total_score_5 += $score_akhir;
          $average_C += $data->Achieve;

          if($no % 2 == 1){
              $erow = 'erow';
          }
          else{
              $erow = '';
          }

        ?>
        <tr class="<?php echo $erow?> result" height="18">
          <td class="text-right"></i><?php echo $no?>.</td>
          <td colspan="2"><a href="javascript:void(0);" onclick="edit_plan('<?php echo $data->activity_id;?>')" title="Edit" class="link"><?php echo $data->Description?></a> &nbsp;&nbsp;

            <?php if ($key_agree == 1 && $key_active ==1){ ?>            
            <a href="javascript:void(0);" onclick="monitoring_plan('<?php echo $data->activity_id;?>')" title="Monitor" class="link pull-right action-tools" style="padding-right:5px"><i class="glyphicon glyphicon-comment"></i> Monitor</a>&nbsp;&nbsp;
            <?php } ?>

            <?php 
            if (!is_null($data->photo) || !empty($data->photo) || $data->photo != ''){
                echo '<a href="{{ base_url }}assets/files/upload_pa/'.$data->photo.'" target="_blank" title="Attachment" id="file_icon" class="link action-tools"><i class="glyphicon glyphicon-paperclip"></i></a>&nbsp;&nbsp;';
            }
            ?>

          </td>
          <td class="text-center"><?php echo $data->UoM ?></td>
          <td class="text-center"><?php echo date('d-M-Y', strtotime($data->DD))?></td>
          <td class="text-center"><?php echo $data->Bobot_A ?></td>
          <td class="text-center"><?php echo $data->Plan_B ?></td>
          <td class="text-center"><?php echo number_format($data->SM1, 0, ',', '.') ?></td>
          <td class="text-center"><?php echo number_format($data->SM2, 0, ',', '.') ?></td>
          <td class="text-center"><?php echo number_format($data->AchSM1,0) ?></td>
          <td class="text-center"><?php echo number_format($data->AchSM2,0) ?></td>
          <td class="text-center"><?php echo number_format($data->Achieve,0) ?></td>
          <td width="100"><?php echo $data->MonRemarks; ?></td>
          <td class="text-center"><?php echo $crud->set_nilai_skala($data->Achieve) ?></td>  
          <td class="text-center <?php if($data->Nilai_Skala_Atasan=='0'){ echo 'bg-danger'; } else { echo $data->Nilai_Skala_Atasan; } ?>"><?php echo $data->Nilai_Skala_Atasan ?></td>
          <td class="text-center"><?php echo $nilai_akhir;?></td>
          <td class="text-center"><?php echo number_format($score_akhir,2);?></td>
          <td class="text-left notes"><?php echo $data->MonRemarksAtasan ?></td>
        </tr>

        <?php 
        $no++;
        }
        ?>

  <tr style="font-weight: bold">
    <td colspan="3">&nbsp;</td>

    <?php      
      $sum_bobot_C = ($total_bobot_5);
      $sum_average_C = ($average_C);
      $sum_row_C = ($num_row_C);

      $crud->update_total_score($primary_key, $column='x_bar_C', number_format(($sum_average_C/$sum_row_C),2));

      if ($sum_bobot_C < 100){
        $sty = '#FF0000';
      }
      else{
        $sty = '';
      }
    ?>

    <td colspan="2" style="color:#000000" class="text-center">TOTAL BOBOT (B II)</td>
    <td style="color:#000000" bgcolor="<?php echo $sty?>" class="text-center"><?php echo ($total_bobot_5);?>%
    <input type="hidden" id="total_bobot_C" value="<?php echo ($total_bobot_5);?>" />
    </td>    
    <td colspan="5" class="text-right">x-bar</td>    
    <td class="text-center"><?php echo number_format(($average_C/$sum_row_C),0);?>%</td>
    <td>&nbsp;</td>    
    <td colspan="3" style="color:#000000" class="text-right">TOTAL SCORE (B)</td>
    <td style="color:#000000" class="text-center"><?php echo number_format(($total_score_5),2);?></td>
    <td>&nbsp;</td>
  </tr>

  <tr style="font-weight: bold; border: 1px white !important">   
    <td colspan="13" style="border-bottom: none !important; border-top: none !important"></td>    
    <td colspan="3" bgcolor="#000000" style="color:#FFFFFF" class="text-right">TOTAL SCORE (B) x Bobot</td>
    <td bgcolor="#000000" style="color:#FFFFFF" class="text-center">

      <?php
      $bobot_nilai = $crud->set_bobot_nilai_user($primary_key, $type=3);
      $bobot_nilai_C = (($total_score_5)*$bobot_nilai)/100; 

      $__bobot_nilai_C = number_format($bobot_nilai_C,2); 

      echo number_format($bobot_nilai_C,2);
      $crud->update_total_score($primary_key, $column='total_score_C', number_format($bobot_nilai_C,2));

      ?>
      
    </td>
    <td>&nbsp;</td>
  </tr>

<?php } ?>

  <tr>   
      <td colspan="18">&nbsp;</td>  
  </tr>



<?php if($key_type == 2){

    //$total_score_all = ($total_score_1+$total_score_2+$total_score_3+$total_score_4+$total_score_5);
    $total_score_all = ($__bobot_nilai_A + $__bobot_nilai_B + $__bobot_nilai_C);
    if(!$crud->cek_nilai_0($primary_key)){
      $total_score_all = 0;
    }

  ?>
  <tr>   
    <td colspan="13"></td>   
    <td colspan="3" bgcolor="#000000" style="color:#FFFFFF; font-size: 14px; font-weight: bold" class="text-right">TOTAL SCORE (A+BI+BII)</td>
    <td bgcolor="#000000" style="color:#FFFFFF;font-size: 16px; font-weight: bold" class="text-center"><?php echo number_format($total_score_all,2);?></td>
    <td>&nbsp;</td>
  </tr>

<?php } else {
    
    //$total_score_all = ($total_score_1+$total_score_2+$total_score_3+$total_score_4); 
    $total_score_all = ($__bobot_nilai_A + $__bobot_nilai_B);
    if(!$crud->cek_nilai_0($primary_key)){
      $total_score_all = 0;
    }
  ?>

  <tr >
    <td colspan="13">&nbsp;</td>   
    <td colspan="3" bgcolor="#000000" style="color:#FFFFFF; font-size: 14px; font-weight: bold" class="text-right">TOTAL SCORE (A+BI)</td>
    <td bgcolor="#000000" style="color:#FFFFFF;font-size: 16px; font-weight: bold" class="text-center"><?php echo number_format($total_score_all,2);?></td>
    <td>&nbsp;</td>
  </tr>

<?php } 
  
  
   if(!$crud->cek_nilai_0($primary_key)){
      $crud->update_status_proses($primary_key, $column='iAgree2', 1);
    } else {
      $crud->update_status_proses($primary_key, $column='iAgree2', 2);
    }

   $crud->update_total_score($primary_key, $column='total_score', number_format($total_score_all,2));  

?>

  <tr>
    <td colspan="13" height="35" class="text-left" style="border-bottom:none !important; font-weight:bold; padding-left: 5px">
      <font size="2"><u>SECOND LAYER APPROVEMENT STATUS : </u></font>
    </td>
    <td colspan="4" class="text-center" bgcolor="#000000" style="color:#FFFFFF"><font size="4"><strong>
      <?php
        if(!$crud->cek_nilai_0($primary_key)){
          echo '- Incomplete -'; 
        } else {
          echo $crud->set_nilai_akhir_pa(number_format($total_score_all,2));          
        }
      ?></strong></font></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="13" style="border-top:none !important; font-size: 13px;">
        <?php echo $crud->cek_status_secondlayer($primary_key); ?>
    </td>
    <td colspan="5">
        <!--
          <table width="100%" border="0" cellspacing="2" cellpadding="3">
          <tr>
            <th width="60%" class="text-center">IST (ISTIMEWA)</th>
            <th width="5%">=</th>
            <th>4.50</th>
            <th width="10%" class="text-center">s/d</th>
            <th>5.00</th>
          </tr>
          <tr>
            <th width="60%" class="text-center">BS (BAIK SEKALI)</th>
            <th width="5%">=</th>
            <th>3.75</th>
            <th width="10%" class="text-center">s/d</th>
            <th>4.49</th>
          </tr>
          <tr>
            <th width="60%" class="text-center">B+ (BAIK PLUS)</th>
            <th width="5%">=</th>
            <th>3.25</th>
            <th width="10%" class="text-center">s/d</th>
            <th>3.74</th>
          </tr>
          <tr>
            <th width="60%" class="text-center">B (BAIK)</th>
            <th width="5%">=</th>
            <th>3.00</th>
            <th width="10%" class="text-center">s/d</th>
            <th>3.24</th>
          </tr>
          <tr>
            <th width="60%" class="text-center">B- (BAIK MINUS)</th>
            <th width="5%">=</th>
            <th>2.75</th>
            <th width="10%" class="text-center">s/d</th>
            <th>2.99</th>
          </tr>
          <tr>
            <th width="60%" class="text-center">C (CUKUP)</th>
            <th width="5%">=</th>
            <th>2.00</th>
            <th width="10%" class="text-center">s/d</th>
            <th>2.74</th>
          </tr>
          <tr>
            <th width="60%" class="text-center">K (KURANG)</th>
            <th width="5%">=</th>
            <th>1.00</th>
            <th width="10%" class="text-center">s/d</th>
            <th>1.99</th>
          </tr>
        </table>
      -->


        <table width="100%" border="0" cellspacing="2" cellpadding="3">
        
          <tr>
            <th width="60%" class="text-center">BS (BAIK SEKALI)</th>
            <th width="5%">=</th>
            <th>4.52</th>
            <th width="10%" class="text-center">s/d</th>
            <th>5.00</th>
          </tr>
          <tr>
            <th width="60%" class="text-center">B+ (BAIK PLUS)</th>
            <th width="5%">=</th>
            <th>4.01</th>
            <th width="10%" class="text-center">s/d</th>
            <th>4.51</th>
          </tr>
          <tr>
            <th width="60%" class="text-center">B (BAIK)</th>
            <th width="5%">=</th>
            <th>3.70</th>
            <th width="10%" class="text-center">s/d</th>
            <th>4.00</th>
          </tr>
          <tr>
            <th width="60%" class="text-center">B- (BAIK MINUS)</th>
            <th width="5%">=</th>
            <th>3.39</th>
            <th width="10%" class="text-center">s/d</th>
            <th>3.69</th>
          </tr>
          <tr>
            <th width="60%" class="text-center">C+ (CUKUP PLUS)</th>
            <th width="5%">=</th>
            <th>3.08</th>
            <th width="10%" class="text-center">s/d</th>
            <th>3.38</th>
          </tr>
          <tr>
            <th width="60%" class="text-center">C (CUKUP)</th>
            <th width="5%">=</th>
            <th>2.77</th>
            <th width="10%" class="text-center">s/d</th>
            <th>3.07</th>
          </tr>
          <tr>
            <th width="60%" class="text-center">C- (CUKUP MINUS)</th>
            <th width="5%">=</th>
            <th>2.26</th>
            <th width="10%" class="text-center">s/d</th>
            <th>2.76</th>
          </tr>
          <tr>
            <th width="60%" class="text-center">K (KURANG)</th>
            <th width="5%">=</th>
            <th>2.25</th>
            <th width="10%" class="text-center">s/d</th>
            <th>kebawah</th>
          </tr>
        </table>


    </td>
   
  </tr>


<!--
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
-->




</table>
<!--
<script type="text/javascript">

  $("#del_icon").css("display","none");

  $('tr').on('mouseover mouseout',function(){
       $(this).find('#del_icon').toggle();
  });

</script>
-->

<script type="text/javascript">

    $(".modal-dialog").draggable({
        handle: ".modal-header"
    });

    $(".modal-dialog").draggable({
        handle: ".modal-header"
    });

    $('#TrainingID').change(function(){
        if($(this).attr('checked')){
            $(this).val(1);
        }else{
            $(this).val(0);
        }
    });

</script>

<script>
$(document).ready(function(){
    $("input").change(function(){
        alert("The text has been changed.");
    });

    
});
</script>

<script type="text/javascript">

var save_method;
var table;
var primary_key;
var DATE_FORMAT = '<?php echo $date_format ?>';
var base_url = '<?php echo base_url();?>';
var session_nik = '<?php echo $session_nik;?>';
var session_nik_atasan = '<?php echo $key_nik_atasan?>';
var primary_key_id = '<?php echo $primary_key;?>';

var key_agree  = '<?php echo $key_agree;?>';
var key_active = '<?php echo $key_active;?>';

$(document).ready(function(){  

    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
	
});

function edit_plan(id){
    save_method = 'update';
    primary_key = id;
    $('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('development/user_key_performance_indicator/plan_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $(".datepicker-input").datepicker({
                showOn: 'focus',
                dateFormat: 'dd/mm/yy',
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-100:c+100",
            }).focus();

            
            $('#modal_form [name="activity_id"]').val(data.activity_id);
            $('#modal_form [name="KPIID"]').val(data.KPIID);
        
            $('#modal_form [name="ItemID"]  option[value="'+data.ItemID+'"').prop("selected", true);
            $('#modal_form [name="ItemID"]').val(data.ItemID).change();

            
            $('#modal_form [name="UoM"]  option[value="'+data.UoM+'"').prop("selected", true);
            $('#modal_form [name="UoM"]').val(data.UoM).change();     
            
            $('#modal_form [name="DD"]').val(php_date_to_js(data.DD));

            var sisa = 100-data.total;

            $('#bobot_ready').text('Sisa bobot tersedia: '+sisa);

            if (data.ItemID > 3){
              $('#item_id').hide();
              $('#form').append('<input type="hidden" name="ItemID" value="'+data.ItemID+'"/>');
            }
            else{
              $('#item_id').show();
            }            
                  
            $('#modal_form [name="Description"]').val(data.Description);
            $('#modal_form [name="Bobot_A"]').val(data.Bobot_A);
            $('#modal_form [name="Plan_B"]').val(data.Plan_B);

            $('.numeric').numeric();
            $('.numeric').keydown(function(e){
                if(e.keyCode == 38)
                {
                    if(IsNumeric($(this).val()))
                    {
                        var new_number = parseInt($(this).val()) + 1;
                        $(this).val(new_number);
                    }else if($(this).val().length == 0)
                    {
                        var new_number = 1;
                        $(this).val(new_number);
                    }
                }
                else if(e.keyCode == 40)
                {
                    if(IsNumeric($(this).val()))
                    {
                        var new_number = parseInt($(this).val()) - 1;
                        $(this).val(new_number);
                    }else if($(this).val().length == 0)
                    {
                        var new_number = -1;
                        $(this).val(new_number);
                    }
                }
                $(this).trigger('change');
            });

            var EveryMonth = data.EveryMonth;

            if (EveryMonth == 1){
                $('#modal_form [name="EveryMonth"]').prop('checked', true);
            }
            else{
                $('#modal_form [name="EveryMonth"]').prop('checked', false);
            }
            
            $('#modal_form').modal({backdrop: 'static'});
            $('#modal_form').modal('show');
            $("#modal_form").draggable({handle: ".modal-header"}); 
            

            $('#modal_form .modal-title').text('{{ language:PLAN }} #'+data.activity_id);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}


function monitoring_plan(id){

    primary_key = id;
    $('#form_monitoring')[0].reset();
    $('.form-group').removeClass('has-error');
    //$('.help-block').empty();

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('development/user_key_performance_indicator/plan_monitoring/')?>/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
        
            $('#modal_form_monitoring [name="MonRemarksAtasan"]').val(data.MonRemarksAtasan);         

            $('#modal_form_monitoring [name="activity_id"]').val(data.activity_id);
            $('#modal_form_monitoring [name="KPIID"]').val(data.KPIID);

            $('#modal_form_monitoring [name="activity_description"]').text(data.Description);
            $('#modal_form_monitoring [name="MonRemarks"]').val(data.MonRemarks);

            $('#modal_form_monitoring [name="SM1"]').val(data.SM1);
            $('#modal_form_monitoring [name="SM2"]').val(data.SM2);

            $('#modal_form_monitoring [name="Nilai_Skala_Atasan"]  option[value="'+data.Nilai_Skala_Atasan+'"').prop("selected", true);
            $('#modal_form_monitoring [name="Nilai_Skala_Atasan"]').val(data.Nilai_Skala_Atasan).change();

           
            $('.numeric').numeric();
            $('.numeric').keydown(function(e){
                if(e.keyCode == 38)
                {
                    if(IsNumeric($(this).val()))
                    {
                        var new_number = parseInt($(this).val()) + 1;
                        $(this).val(new_number);
                    }else if($(this).val().length == 0)
                    {
                        var new_number = 1;
                        $(this).val(new_number);
                    }
                }
                else if(e.keyCode == 40)
                {
                    if(IsNumeric($(this).val()))
                    {
                        var new_number = parseInt($(this).val()) - 1;
                        $(this).val(new_number);
                    }else if($(this).val().length == 0)
                    {
                        var new_number = -1;
                        $(this).val(new_number);
                    }
                }
                $(this).trigger('change');
            });

            if (session_nik != session_nik_atasan){
              $('#catatan-atasan-preview').hide();
              $('#nilai-atasan-preview').hide();
              //$('#modal_form_monitoring .narration-value').hide();
            }

            /*if (session_nik != session_nik_atasan){
              $('#catatan-atasan-preview').hide();
              $('#nilai-atasan-preview').hide();
              $('#modal_form_monitoring .narration-value').hide();
            }*/

            //else{

                $('#modal_form_monitoring .narration-value').hide();

                if(data.ItemID == 1 && data.narration_key_performance_indicator != 0){
                    $('#modal_form_monitoring .narration-value').show();
                    $('#modal_form_monitoring #narration-text').html(data.narration_key_performance_indicator);
                }
                else if(data.ItemID == 2 && data.narration_key_performance_indicator != 0){
                    $('#modal_form_monitoring .narration-value').show();
                    $('#modal_form_monitoring #narration-text').html(data.narration_key_performance_indicator);
                }
                else if(data.ItemID == 3 && data.narration_key_performance_indicator != 0){
                    $('#modal_form_monitoring .narration-value').show();
                    $('#modal_form_monitoring #narration-text').html(data.narration_key_performance_indicator);
                }
                else if(data.ItemID == 4 && data.narration_core_value != 0){
                    $('#modal_form_monitoring .narration-value').show();
                    $('#modal_form_monitoring #narration-text').html(data.narration_core_value);
                }
                else if(data.ItemID == 5 && data.narration_managing_people != 0){
                    $('#modal_form_monitoring .narration-value').show();
                    $('#modal_form_monitoring #narration-text').html(data.narration_managing_people);
                }
                else{
                    $('#modal_form_monitoring .narration-value').hide();
                }

            //}
            


            $('#photo-preview').show();

            if(data.photo)
            {
                $('#label-photo').text('Change Evidence (max 1 M) pdf,jpg,jpeg'); // label photo upload
                //$('#photo-preview div').html('<img src="'+base_url+'assets/files/upload_pa/'+data.photo+'" class="img-responsive">'); // show photo
                $('#photo-preview div').html('<a href="'+base_url+'assets/files/upload_pa/'+data.photo+'" target="_blank" class="img-responsive">'+data.photo+'</a> '); // show photo
                $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="'+data.photo+'"/> Remove evidence when saving'); // remove photo

            }
            else
            {
                $('#label-photo').text('Upload Evidence (max 1 M) pdf,jpg,jpeg'); // label photo upload
                $('#photo-preview div').text('(No Evidence)');
            }           

                        
            $('#modal_form_monitoring').modal({backdrop: 'static'});
            $('#modal_form_monitoring').modal('show');
            $("#modal_form_monitoring").draggable({handle: ".modal-header"});           

            $('#modal_form_monitoring .modal-title').text('{{ language:MONITORING }} #'+data.activity_id);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}


function add_plan(id)
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals

    $('#modal_form [name="KPIID"]').val(id);
    $('#item_id').show();

    $(".datepicker-input").datepicker({
                showOn: 'focus',
                dateFormat: 'dd/mm/yy',
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "c-100:c+100",
            }).focus(); 


    $('.numeric').numeric();
            $('.numeric').keydown(function(e){
                if(e.keyCode == 38)
                {
                    if(IsNumeric($(this).val()))
                    {
                        var new_number = parseInt($(this).val()) + 1;
                        $(this).val(new_number);
                    }else if($(this).val().length == 0)
                    {
                        var new_number = 1;
                        $(this).val(new_number);
                    }
                }
                else if(e.keyCode == 40)
                {
                    if(IsNumeric($(this).val()))
                    {
                        var new_number = parseInt($(this).val()) - 1;
                        $(this).val(new_number);
                    }else if($(this).val().length == 0)
                    {
                        var new_number = -1;
                        $(this).val(new_number);
                    }
                }
                $(this).trigger('change');
            });

    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $('#modal_form').modal({backdrop: 'static'});
    $('#modal_form').modal('show'); // show bootstrap modal
    $("#modal_form").draggable({handle: ".modal-header"});

    $('#modal_form .modal-title').text('Add Plan'); // Set Title to Bootstrap modal title
}


function delete_plan(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('development/user_key_performance_indicator/plan_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');

                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}


function ____deal_plan(id)
{
    if(confirm('Apakah anda sudah sepakat tentang PA ini?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('development/user_key_performance_indicator/plan_deal')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');

                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error updating data');
            }
        });
    }
}

function deal_plan(id){
    save_method = 'update';
    primary_key = id;
    $('#form_deal')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    
    //Ajax Load data from ajax

    $('[name="KPIID"]').val(id);
    $('[name="iAgree"]').val(1);                
            
    //$('#modal_form_deal').modal({backdrop: 'static'});
    //$('#modal_form_deal').modal('show');
    //$("#modal_form_deal").draggable({handle: ".modal-header"});

            
    $.ajax({
        url : "<?php echo site_url('development/user_key_performance_indicator/deal_edit/')?>/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
                        
            
            $('#modal_form_deal [name="KPIID"]').val(id);
            $('#modal_form_deal [name="iAgree"]').val(1);                
            
            $('#modal_form_deal').modal({backdrop: 'static'});
            $('#modal_form_deal').modal('show');
            $("#modal_form_deal").draggable({handle: ".modal-header"});

            if (data.iAgree ==1){
              $('#note_deal').text('PA ini sudah di approve sebelumnya...');
            }
            $('#modal_form_deal [name="PARemarks"]').val(data.PARemarks);             

            //$('.modal-title').text('{{ language:PLAN }} #'+data.activity_id);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    
}


function undeal_plan(id){
    save_method = 'update';
    primary_key = id;
    $('#form_deal')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    
       
    $.ajax({
        url : "<?php echo site_url('development/user_key_performance_indicator/deal_edit/')?>/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {                        
            
            $('#modal_form_deal [name="KPIID"]').val(id);
            $('#modal_form_deal [name="iAgree"]').val(0);
            $('#modal_form_deal [name="PARemarks"]').val(data.PARemarks);                
            
            $('#modal_form_deal').modal({backdrop: 'static'});
            $('#modal_form_deal').modal('show');
            $("#modal_form_deal").draggable({handle: ".modal-header"});             

            $('#modal_form_deal .modal-title').text('Apakah anda belum sepakat tentang PA ini?');

            if (data.iAgree ==1){
              $('#note_deal').text('PA ini sudah di approve sebelumnya...');
            }
            

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    
}



function callback_monitor_global(primary_key, type){

    var component = '';
    var bg_color;
    var title_hdr;
       
    $.ajax({
        url : "<?php echo site_url('development/user_key_performance_indicator/ajax_callback_monitor_global/')?>/"+primary_key+"/"+type,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            
            $('#modal_monitor_global [name="KPIID"]').val(primary_key);
            $('#modal_monitor_global [name="ItemID"]').val(type);


            if( (data.key_agree2 == 3)){                
                show_modal_dialog_warning(title='ERROR...', content='<i class="glyphicon glyphicon-remove"></i> Form sudah di approve oleh Second Layer...','modal modal-success');
            }
            else if(data.session_nik != data.session_nik_atasan && data.performance_management == 0){                
                show_modal_dialog_warning(title='ERROR...', content='<i class="glyphicon glyphicon-remove"></i> Anda bukan atasan karyawan yang bersangkutan...','modal modal-success');
            }
            else if(data.key_agree == 0){                
                show_modal_dialog_warning(title='ERROR...', content='<i class="glyphicon glyphicon-remove"></i> Form ini belum disepakati...','modal modal-success');
            }
            else if(data.key_active == 0){
                show_modal_dialog_warning(title='ERROR...', content='<i class="glyphicon glyphicon-remove"></i> Form ini sudah ditutup...','modal modal-success');
            }
            else{
              $('#modal_monitor_global').modal({backdrop: 'static'});
              $('#modal_monitor_global').modal('show');
              $("#modal_monitor_global").draggable({handle: ".modal-header"});
            }

            if(type ==1){
                title_hdr = '<ul>'+
                    '<li style="background-color: #ffffe6;">KPI-KEY PERFORMANCE INDICATOR</li>'+
                    '<li style="background-color: #e6f2ff;">PERFORMANCE INDICATOR</li>'+
                    '<li style="background-color: #e6ffe6;">SPECIAL ASSIGNMENT</li>'+                    
                  '</ul>';
            }
            else if(type == 4){
                title_hdr = 'PROCESS & CORE VALUES';
            }
            else if(type == 5){
                title_hdr = 'MANAGING PEOPLE';
            }
            else{
                title_hdr = '';
            }
            
            component += '<table class="table table-bordered" style="font-size:11px !important">';
            component += '<p>'+title_hdr+'</p>';
            component += '<thead><tr>'+
                    '<th class="text-center" width="5%">#</th>'+
                    '<th class="text-center" width="35%">Deskripsi</th>'+
                    '<th class="text-center" width="15%">Nilai</th>'+
                    '<th class="text-center">Komentar</th>'+
                '</tr></thead>';

            component += '<tbody>';

            var no=1;

            $.each(data.result, function (key,value){

                if(value.ItemID == 1){
                    bg_color = '#ffffe6';
                }
                else if(value.ItemID == 2){
                    bg_color = '#e6f2ff';
                }
                else if(value.ItemID == 3){
                    bg_color = '#e6ffe6';
                }
                else if(value.ItemID == 4){
                    bg_color = '#ffe6ff';
                }
                else if(value.ItemID == 5){
                    bg_color = '#ccffee';
                }
                else{
                    bg_color = '';
                }

                  component += 
                  '<tr>'+
                  '<td class="text-center" bgcolor="'+bg_color+'">'+no+'</td>'+
                  '<td class="text-left" bgcolor="'+bg_color+'">'+value.Description+'</td>'+
                  '<td class="text-center" bgcolor="'+bg_color+'">';

                  component += '<select name="Nilai_Skala_Atasan_'+value.activity_id+'" class="form-control" style="font-size:11px">';

                  for (var i = 0; i <= 5; i++) {
                      if(value.Nilai_Skala_Atasan == i){
                          component += '<option value="'+i+'" selected="selected">'+i+'</option>';
                      }
                      else{
                          component += '<option value="'+i+'">'+i+'</option>';
                      }                      
                  }

                  component += '</select>';

                  component += '</td>'+
                  '<td class="text-left" bgcolor="'+bg_color+'"><input type="text" style="font-size:11px" class="form-control" name="MonRemarksAtasan_'+value.activity_id+'" placeholder="tulis komentar anda..." value="'+value.MonRemarksAtasan+'"></td>'+
                  '</tr>';
                 no++;     
            });

            component += '</tbody>';
            component += '</table>';

            component += '<input type="checkbox" name="email_notif_global" checked value="1"> Kirim email notifikasi ke karyawan bersangkutan.';
            component += '</br>';
            component += '<input type="checkbox" name="email_notif_global_tome" checked value="1"> Kirim email notifikasi ke saya juga.';

            if( (data.key_agree2 == 4)){                
                component += '</br>';
                component += '<input type="checkbox" name="apvsecondlayer" value="1"> Proses Ke Second Layer.';
            }


            
            $('#modal_monitor_global .form-body').html(component);                       

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    
}


function ___undeal_plan(id)
{
    if(confirm('Apakah anda tidak sepakat tentang PA ini?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('development/user_key_performance_indicator/plan_undeal')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');

                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error updating data');
            }
        });
    }
}


function reload_index_page(){

  $.ajax({
        url : "<?php echo site_url('development/user_key_performance_indicator/')?>/?KPIID="+primary_key_id,
        type: "GET",
        /*dataType: "JSON",*/
        success: function(html)
        {
          
          //$("#result").html(html);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}




function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}


function save(){

    //$('#btnSave').text('saving...'); 
    //$('#btnSave').attr('disabled',true); 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('development/user_key_performance_indicator/plan_insert')?>";
    } else {
        url = "<?php echo site_url('development/user_key_performance_indicator/plan_update')?>";
    }

	//$('#field-iOrgItem').removeAttr('disabled').trigger("liszt:updated");
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status)
            {
                $('#modal_form').modal('hide');
                //reload_table();

                //alert('Data berhasil disimpan...');

                $('#modal_form_send_mail').modal({backdrop: 'static'});
                $('#modal_form_send_mail').modal('show');
                $("#modal_form_send_mail").draggable({handle: ".modal-header"});             
                $('#modal_form_send_mail .modal-title').text('Konfirmasi');

                //location.reload();

                //reload_index_page();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
            //$('#btnSave').text('save');
            //$('#btnSave').attr('disabled',false); 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            //$('#btnSave').text('save'); 
            //$('#btnSave').attr('disabled',false); 

        }
    });
	
}


function save_monitoring(){

    var url;    
    url = "<?php echo site_url('development/user_key_performance_indicator/plan_monitoring_update')?>";

    var formData = new FormData($('#form_monitoring')[0]);

    //alert(JSON.stringify(formData)); 

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status)
            {
                $('#modal_form_monitoring').modal('hide');
                //location.reload();
            }

            $('#modal_form_send_mail_monitor').modal({backdrop: 'static'});
            $('#modal_form_send_mail_monitor').modal('show');
            $("#modal_form_send_mail_monitor").draggable({handle: ".modal-header"});             

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });
}

function save_deal(){

    var url;    
    url = "<?php echo site_url('development/user_key_performance_indicator/kpi_deal')?>";

    var formData = new FormData($('#form_deal')[0]);
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status)
            {
                $('#modal_form_deal').modal('hide');
                location.reload();
            }
             

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });
}




function kirim_email_atasan(){

    var url;    
    url = "<?php echo site_url('development/user_key_performance_indicator/send_email_kpi')?>";

    var formData = new FormData($('#form_send_email')[0]);
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",

        beforeSend: function(){
            $('#modal_form_send_mail').modal('hide');
            show_modal_dialog_warning(title='TUNGGU...', content='<i class="glyphicon glyphicon-send"></i> Email sedang dikirim...','modal modal-warning');             
        },

        success: function(data)
        {

            if(data.status)
            {
                //alert('Email berhasil dikirim ke atasan anda.');
                show_modal_dialog_warning(title='BERHASIL...', content='<i class="glyphicon glyphicon-ok"></i> Email sudah dikirim...','modal modal-success'); 
                location.reload();
            }
             

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error...Ada kesalahan pengiriman email #1.');
        }
    });
}


function kirim_email_atasan_monitor(){

    var url;    
    url = "<?php echo site_url('development/user_key_performance_indicator/send_email_kpi_monitor')?>";

    var formData = new FormData($('#form_send_email_monitor')[0]);
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",

        beforeSend: function(){
            $('#modal_form_send_mail_monitor').modal('hide');
            show_modal_dialog_warning(title='TUNGGU...', content='<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Email sedang dikirim...','modal modal-warning');             
        },

        success: function(data)
        {

            if(data.status)
            {
                //alert('Email berhasil dikirim ke atasan anda.');
                show_modal_dialog_warning(title='BERHASIL...', content='<i class="glyphicon glyphicon-ok"></i> Email sudah dikirim...','modal modal-success'); 
                location.reload();
            }
             

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error...Ada kesalahan pengiriman email #2.');
        }
    });
}



function tidak_kirim_email_atasan(){
    
    location.reload();
          
}



function save_form_monitor_global(){

    var url;    
    url = "<?php echo site_url('development/user_key_performance_indicator/ajax_save_form_monitor_global')?>";

    var formData = new FormData($('#form_monitor_global')[0]);


    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",

        beforeSend: function(){
            $('#modal_monitor_global').modal('hide');
            show_modal_dialog_warning(title='TUNGGU...', content='<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Data sedang diproses...','modal modal-warning');             
        },

        success: function(data)
        {

            if(data.status)
            {                   
                if(data.send_email_status == 1 && data.send_email_tome_status == 1){
                    show_modal_dialog_warning(title='BERHASIL...', content='<i class="glyphicon glyphicon-ok"></i> Data sudah disimpan dan email sudah dikirim ke anda dan karyawan...','modal modal-success'); 
                }
                else if(data.send_email_status == 1 && data.send_email_tome_status == null){
                    show_modal_dialog_warning(title='BERHASIL...', content='<i class="glyphicon glyphicon-ok"></i> Data sudah disimpan dan email sudah dikirim ke karyawan...','modal modal-success'); 
                }
                else if(data.send_email_status == null && data.send_email_tome_status == 1){
                    show_modal_dialog_warning(title='BERHASIL...', content='<i class="glyphicon glyphicon-ok"></i> Data sudah disimpan dan email sudah dikirim ke anda...','modal modal-success'); 
                }
                else{
                    show_modal_dialog_warning(title='BERHASIL...', content='<i class="glyphicon glyphicon-ok"></i> Data sudah disimpan...','modal modal-success'); 
                }

                location.reload();
            }
             

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error...Ada kesalahan pengiriman email.');
        }
    });
}



function status_bobot_note(){

  var bobot_1 = $('#total_bobot_A').val();
  var bobot_2 = $('#total_bobot_B').val();
  var bobot_3 = $('#total_bobot_C').val();

  //alert(bobot_1);

    if(bobot_1 < 100 || bobot_2 < 100 || bobot_3 < 100){
        $('#modal_form_information').modal({backdrop: 'static'});
        $('#modal_form_information').modal('show');
        $('#modal_form_information').draggable({handle: '.modal-header'});

        $('#modal_form_information .modal-title').text('Informasi');
    }                   
   
}


function show_modal_dialog_warning(title, content, gaya){
    
    $('#modal_form_error .form-body').html(content);
    $('#modal_form_error').attr('class', gaya);
    $('#modal_form_error').modal({backdrop: 'static'});
    $('#modal_form_error').modal('show');           

    $('.modal-title').text(title);                

}

function js_date_to_php(js_date){
        if(typeof(js_date)=='undefined' || js_date == ''){
            return '';
        }
        var date = '';
        var month = '';
        var year = '';
        var php_date = '';
        if(DATE_FORMAT == 'uk-date'){
            var date_array = js_date.split('/');
            day = date_array[0];
            month = date_array[1];
            year = date_array[2];
            php_date = year+'-'+month+'-'+day;
        }else if(DATE_FORMAT == 'us-date'){
            var date_array = js_date.split('/');
            day = date_array[1];
            month = date_array[0];
            year = date_array[2];
            php_date = year+'-'+month+'-'+day;
        }else if(DATE_FORMAT == 'sql-date'){
            var date_array = js_date.split('-');
            day = date_array[2];
            month = date_array[1];
            year = date_array[0];
            php_date = year+'-'+month+'-'+day;
        }
        return php_date;
}


function php_datetime_to_js(php_datetime){
        if(typeof(php_datetime)=='undefined' || php_datetime == ''){
            return '';
        }
        var datetime_array = php_datetime.split(' ');
        var php_date = datetime_array[0];
        var time = datetime_array[1];
        var js_date = php_date_to_js(php_date);
        return js_date + ' ' + time;
    }

function php_date_to_js(php_date){
        if(typeof(php_date)=='undefined' || php_date == ''){
            return '';
        }
        var date_array = php_date.split('-');
        var year = date_array[0];
        var month = date_array[1];
        var day = date_array[2];
        if(DATE_FORMAT == 'uk-date'){
            return day+'/'+month+'/'+year;
        }else if(DATE_FORMAT == 'us-date'){
            return month+'/'+date+'/'+year;
        }else if(DATE_FORMAT == 'sql-date'){
            return year+'-'+month+'-'+day;
        }else{
            return '';
        }
}

function IsNumeric(input){
        return (input - 0) == input && input.length > 0;
}



</script>

<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">PLAN</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="activity_id"/>
                    <input type="hidden" value="" name="KPIID"/> 
                    <div class="form-body">

                        <div class="form-group">
                            <label class="text-center col-md-12"><?php echo $key_title?></label>
                        </div>
                        <div class="form-group" id="item_id">
                            <label class="control-label col-md-4">Item*</label>                            
                            <div class="col-md-8">
                                <select name="ItemID" class="selectpicker form-control">          
                                    <option value="1">KPI -KEY PERFORMANCE INDICATOR</option>
                                    <option value="2">PERFORMANCE INDICATOR (ROUTINE ACTIVITY)</option>
                                    <option value="3">SPECIAL ASSIGNMENT</option>
                                    <!--
                                    <option value="4">PROCESS & CORE VALUES</option>
                                    <option value="5">MANAGING PEOPLE</option>
                                    -->
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Activity Plan *</label>
                            <div class="col-md-8">
                                <textarea name="Description" placeholder="Description" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4">Unit of measurement (UoM)*</label>
                            <div class="col-md-8">
                                <select name="UoM" class="selectpicker form-control">          
                                    <option value="%">%</option>
                                    <option value="Qty">Qty</option>
                                    <option value="Time">Time</option>
                                    <option value="Day">Days</option>
                                    <option value="Hour">Hours</option>
                                    <option value="IDR">IDR</option>
                                    <option value="USD">USD</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                        
                        <div class="form-group">
                            <label class="control-label col-md-4">Due Date*</label>
                            <div class="col-md-4">
                                <input name="DD" placeholder="dd/mm/yyyy" class="form-control datepicker-input" type="text">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-4">
                                <input type="checkbox" name="EveryMonth" value="1" >&nbsp; Setiap Bulan ?           
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-4" id="bobot_ready"></label>
                            <div class="col-md-4">
                              <label class="control-label">Bobot (%)*</label>
                              <input name="Bobot_A" placeholder="dalam angka, tidak usah %" class="form-control numeric" type="text">
                              <span class="help-block"></span>
                            </div>

                            <div class="col-md-4">
                              <label class="control-label">TARGET PLAN*</label>
                              <input name="Plan_B" placeholder="dalam angka" class="form-control numeric" type="text">
                              <span class="help-block"></span>
                            </div>
                        </div>

                        <!--
                        <div class="form-group">
                            <label class="control-label col-md-2">Bobot (%)*</label>
                            <div class="col-md-4">
                                <input name="Bobot_A" placeholder="dalam angka" class="form-control numeric" type="text">
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-2">PLAN*</label>
                            <div class="col-md-4">
                                <input name="Plan_B" placeholder="dalam angka" class="form-control numeric" type="text">         
                            </div>
                        </div>
                        -->                        

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <?php 
                if ($key_active == 1 && $key_agree == 0){ ?>
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary pull-left"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
                <?php } ?>
                
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_form_monitoring" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">PLAN</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_monitoring" class="form-horizontal">
                    <input type="hidden" value="" name="activity_id"/>
                    <input type="hidden" value="" name="KPIID"/> 
                    <div class="form-body">

                        <div class="form-group">
                            <label class="text-center col-md-12"><?php echo $key_title?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Activity Plan</label>                            
                            <div class="col-md-9">
                                <label class="text-left col-md-12" name="activity_description"></label>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Catatan</label>
                            <div class="col-md-9">
                                <textarea name="MonRemarks" placeholder="Catatan dari karyawan..." class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">ACTUAL</label>
                            <div class="col-md-4">
                              <label class="control-label">Semester 1</label>
                              <input name="SM1" placeholder="dalam angka" class="form-control numeric" type="text">
                            </div>

                            <div class="col-md-4">
                              <label class="control-label">Semester 2</label>
                              <input name="SM2" placeholder="dalam angka" class="form-control numeric" type="text">
                            </div>
                        </div>

                        <div class="form-group" id="catatan-atasan-preview">
                            <label class="control-label col-md-3">Catatan dari Atasan</label>
                            <div class="col-md-9">
                                <textarea name="MonRemarksAtasan" placeholder="Catatan dari atasan..." class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group" id="nilai-atasan-preview">
                            <label class="control-label col-md-3">Penilaian dari Atasan</label>
                            <div class="col-md-9">
                                <select name="Nilai_Skala_Atasan" class="selectpicker form-control">          
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>       

                        </div>                       

                        <div class="alert alert-block alert-danger fade in narration-value">                        
                            <h4>Kriteria Penilaian</h4>
                            <p id="narration-text"></p>
                        </div>                      


                        <!--
                        <div class="form-group">
                            <label class="control-label col-md-3">Evidence</label>
                            <div class="col-md-9">
                                <input type="file" name="MonEvidence" id="MonEvidence" size="250" />
                                <span class="help-block"></span>
                            </div>
                        </div>
                      -->


                        <div class="form-group" id="photo-preview">
                            <label class="control-label col-md-3">Evidence</label>
                            <div class="col-md-9">
                                (No Evidence)
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" id="label-photo">Upload Evidence (max 1 M)</label>
                            <div class="col-md-9">
                                <input name="photo" type="file">
                                <span class="help-block"></span>
                            </div>
                        </div>


                                                

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <?php 
                if ($key_active == 1 && $key_agree == 1){ ?>
                    <button type="button" id="btnSave" onclick="save_monitoring()" class="btn btn-primary pull-left"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
                <?php } ?>
                
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_form_deal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title button">Apakah anda sudah sepakat tentang PA ini?</h4>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_deal" class="form-horizontal">
                    <input type="hidden" value="" name="KPIID"/>
                    <input type="hidden" value="" name="iAgree"/> 
                    <div class="form-body">                        
                        
                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea name="PARemarks" placeholder="Catatan dari Anda..." class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <p id="note_deal"></p>
                        <p><i class="glyphicon glyphicon-send"></i> Email notifikasi akan dikirim ke karyawan yang bersangkutan.</p>                                               

                    </div>
                </form>
            </div>
            <div class="modal-footer">                
                <button type="button" id="btnSave" onclick="save_deal()" class="btn btn-primary pull-left"><i class="glyphicon glyphicon-floppy-disk"></i> Process</button>                
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_form_information" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Informasi</h4>
            </div>
            <div class="modal-body">             
                <div class="form-body">  
                  <p>PA Tidak bisa di Approve karena masih ada Bobot belum mencapai 100%.</p>
                  <p>Silahkan lihat kolom berwarna merah.</p>                                           
                </div>              
            </div>
            <div class="modal-footer">     
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_form_send_mail" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Konfirmasi</h4>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_send_email" class="form-horizontal">
                    <input type="hidden" value="<?php echo $primary_key;?>" name="KPIID"/>
                    <input type="hidden" value="" name="before_data"/>                    
                    <div class="form-body">
                      <p><strong>Data Berhasil diperbaharui.</strong></p>
                      <p><strong>Apakah anda ingin mengirimkan email notifikasi?</strong></p>               
                    </div>
                </form>
            </div>
            <div class="modal-footer">                
                <button type="button" id="btnSendEmail" onclick="kirim_email_atasan()" class="btn btn-primary pull-left"><i class="glyphicon glyphicon glyphicon-send"></i> KIRIM SEKARANG </button>                
                <button type="button" class="btn btn-danger" onclick="tidak_kirim_email_atasan()" data-dismiss="modal"><i class="glyphicon glyphicon glyphicon-stop"></i> NANTI SAJA</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_form_send_mail_monitor" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Konfirmasi</h4>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_send_email_monitor" class="form-horizontal">
                    <input type="hidden" value="<?php echo $primary_key;?>" name="KPIID"/>
                    <input type="hidden" value="" name="before_data"/>                    
                    <div class="form-body">
                      <p><strong>Data Berhasil diperbaharui.</strong></p>
                      <p><strong>Apakah anda ingin mengirimkan email notifikasi?</strong></p>               
                    </div>
                </form>
            </div>
            <div class="modal-footer">                
                <button type="button" id="btnSendEmail" onclick="kirim_email_atasan_monitor()" class="btn btn-primary pull-left"><i class="glyphicon glyphicon glyphicon-send"></i> KIRIM SEKARANG </button>                
                <button type="button" class="btn btn-danger" onclick="tidak_kirim_email_atasan()" data-dismiss="modal"><i class="glyphicon glyphicon glyphicon-stop"></i> NANTI SAJA</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal dialog untuk penilaian dari atasan (paket) -->
<div class="modal fade" id="modal_monitor_global" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">PERFORMANCE APPRAISAL</h4>
            </div>
            <form action="#" id="form_monitor_global" class="form-horizontal">
            <div class="modal-body form">                
                    <input type="hidden" value="" name="KPIID"/>
                    <input type="hidden" value="" name="ItemID"/>                                      
                    <div class="form-body"></div>                
            </div>
            <div class="modal-footer">                
                <button type="button" id="btnSaveMonitorGlobal" onclick="save_form_monitor_global()" class="btn btn-primary"><i class="glyphicon glyphicon-send"></i> SIMPAN </button>                
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> BATAL</button>
            </div>

            </form>
        </div>
    </div>
</div>


<div class="modal" id="modal_form_error" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" style="font-weight: bold"></h5>
            </div>
            <div class="modal-body form">                                   
                <div class="form-body">                                                 
                        
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>



<style type="text/css">
  ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color:    #909;
    font-size: 11px;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
   color:    #909;
   opacity:  1;
   font-size: 11px;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
   color:    #909;
   opacity:  1;
   font-size: 11px;
}
:-ms-input-placeholder { /* Internet Explorer 10-11 */
   color:    #909;
   font-size: 11px;
}

.erow{
    background-color: #E2E2E2;
}
.result:hover {
    background-color: #ffff99;
}
table td{

}
.control-label{
  font-size: 12px;
}

.glyphicon {
    display: inline-block;
    width: 100%;
}

.button {
  /*background-color: #B20000;*/
  -webkit-border-radius: 10px;
  border-radius: 5px;
  border: none;
  color: #FFFFFF;
  /*cursor: pointer;*/
  /*display: inline-block;*/
  /*font-family: Arial;*/
  /*font-size: 12px;*/
  padding: 5px 10px;
  text-align: center;
  text-decoration: none;
}

.button-read {
  background-color: #00FF00;
  -webkit-border-radius: 10px;
  border-radius: 5px;
  border: none;
  color: #000000;
  cursor: pointer;
  /*display: inline-block;*/
  /*font-family: Arial;*/
  /*font-size: 12px;*/
  padding: 5px 10px;
  text-align: center;
  text-decoration: none;
}

@-webkit-keyframes glowing {
  0% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
  50% { background-color: #FF0000; -webkit-box-shadow: 0 0 40px #FF0000; }
  100% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
}

@-moz-keyframes glowing {
  0% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
  50% { background-color: #FF0000; -moz-box-shadow: 0 0 40px #FF0000; }
  100% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
}

@-o-keyframes glowing {
  0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
  50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
  100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
}

@keyframes glowing {
  0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
  50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
  100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
}

.button {
  -webkit-animation: glowing 1500ms infinite;
  -moz-animation: glowing 1500ms infinite;
  -o-animation: glowing 1500ms infinite;
  animation: glowing 1500ms infinite;
}


/*
    Original version: http://www.bootply.com/128062
    
    This version adds support for IE 10+ and Firefox.
*/

.glyphicon-refresh-animate {
    -animation: spin .7s infinite linear;
    -ms-animation: spin .7s infinite linear;
    -webkit-animation: spinw .7s infinite linear;
    -moz-animation: spinm .7s infinite linear;
}

@keyframes spin {
    from { transform: scale(1) rotate(0deg);}
    to { transform: scale(1) rotate(360deg);}
}
  
@-webkit-keyframes spinw {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
}

@-moz-keyframes spinm {
    from { -moz-transform: rotate(0deg);}
    to { -moz-transform: rotate(360deg);}
}

</style>