<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

.link
{
   color:#000000 !important;
   text-decoration: none; 
   background-color: none;
}
</style>
<div class="row">
<?php echo $period_option; ?>

<div class="col-sm-8">
<div class="btn-group pull-right">
        
    <a href="{{ MODULE_SITE_URL }}user_key_performance_indicator" class="btn btn-default <?php echo $crud->navigation_name('');?>" title="{{ language:Result }}"><i class="glyphicon glyphicon-list-alt"></i> RESULT</a>

    <a href="{{ MODULE_SITE_URL }}user_key_performance_indicator/header_form" class="btn btn-default <?php echo $crud->navigation_name('header_form');?>" title="{{ language:IPP (Individual Performance Plan) }}"><i class="glyphicon glyphicon-tasks"></i> IPP</a>

    <?php if ($key_agree == 0){ ?>
    <a href="javascript:void(0);" onclick="add_plan('<?php echo $primary_key;?>')" class="btn btn-primary" title="{{ language:Add }}"><i class="glyphicon glyphicon-plus-sign"></i> Add Plan</a>
    <?php } ?>

    <?php if ($key_nik_atasan != $session_nik && $key_agree == 0){ ?>
    <a href="javascript:void(0);" class="btn btn-danger" title="{{ language:Belum Sepakat }}"><i class="glyphicon glyphicon-ban-circle"></i> UNAPPROVED</a>
    <?php }  ?>

    <?php if ($key_nik_atasan != $session_nik && $key_agree == 1){ ?>
    <a href="javascript:void(0);" class="btn btn-success" title="{{ language:Sudah Sepakat }}"><i class="glyphicon glyphicon-thumbs-up"></i> APPROVED</a>
    <?php }  ?>


    <?php if ($key_nik_atasan == $session_nik && $key_agree == 0){ ?>
    <a href="javascript:void(0);" onclick="deal_plan('<?php echo $primary_key;?>')" class="btn btn-danger" title="{{ language:Belum Sepakat }}"><i class="glyphicon glyphicon-ban-circle"></i> UNAPPROVED</a>
    <?php }  ?>

    <?php if ($key_nik_atasan == $session_nik && $key_agree == 1){ ?> 
    <a href="javascript:void(0);" onclick="undeal_plan('<?php echo $primary_key;?>')" class="btn btn-success" title="{{ language:Sudah Sepakat }}"><i class="glyphicon glyphicon-thumbs-up"></i> APPROVED</a>
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
    <td colspan="2">NAMA</td>
    <td><?php echo $result['EmployeeID'].'/'.$crud->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $result['EmployeeID']);?></td>

    <?php if ($key_type == 1){ ?>
    <td colspan="13" rowspan="3" bgcolor="#CCCCCC"><div align="center"><strong>PERFORMANCE MANAGEMENT FORM<br /> Gol. 4A - 4D TANPA BAWAHAN (ANALYST/OFFICER)</strong></div></td>
    <?php } else { ?>
    <td colspan="13" rowspan="3" bgcolor="#CCCCCC"><div align="center"><strong>PERFORMANCE MANAGEMENT FORM<br /> Gol. Gol. 1 - 4  ADA BAWAHAN (MANAJERIAL)</strong></div></td>
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
    <td colspan="4" rowspan="3"><div align="center"><strong>PERFORMANCE PLAN </strong></div></td>
    <td colspan="4" rowspan="3"><div align="center"><strong>PERFORMANCE MONITORING</strong></div></td>
    <td colspan="5" rowspan="3"><div align="center"><strong>PERFORMANCE APPRAISAL</strong></div></td>
  </tr>
  <tr>
    <td colspan="2">JABATAN</td>
    <td><?php echo $crud->cms_table_data($table_name='tbl_jabatan', $where_column='JabatanId', $result_column='NamaJabatan', $crud->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='JabatanID', $result['EmployeeID']));?></td>
  </tr>
  <tr>
    <td colspan="2">PERIODE </td>
    <td><?php echo $result['PeriodID']?></td>
  </tr>
  <tr>
    <td width="28" rowspan="3" width="5%"><div align="center"><strong>NO</strong></div></td>
    <td colspan="2" rowspan="3"><div align="center"><strong>ACTIVITY PLAN</strong></div></td>
    <td width="3%" rowspan="3"><div align="center"><strong>UoM</strong></div></td>
    <td width="5%" rowspan="3"><div align="center"><strong>DD</strong></div></td>
    <td width="3%" rowspan="2"><div align="center"><strong>Bobot (%)</strong></div></td>
    <td width="8%" rowspan="2"><div align="center"><strong>PLAN</strong></div></td>
    <td colspan="2" rowspan="2"><div align="center"><strong>ACTUAL</strong></div></td>
    <td width="3%" rowspan="2"><div align="center"><strong>% Achieve<br />ment </strong></div></td>
    <td rowspan="3" width="15%"><div align="center"><strong>Catatan (Semester 1)<br />
    (Berkaitan dg proses yg sudah atau belum dilakukan dalam rangka mencapai target)</strong></div></td>
    <td width="3%"><div align="center"><strong>Penilaian <br />Karyawan</strong></div></td>
    <td width="3%"><div align="center"><strong>Penilaian Atasan</strong></div></td>
    <td width="3%"><div align="center"><strong>NILAI AKHIR</strong></div></td>
    <td width="3%" rowspan="2" class="text-center"><strong>SCORE AKHIR<br />
    (Nilai X Bobot)</strong></td>
    <td rowspan="3" width="15%"><div align="center"><strong>Catatan (Semester 2)<br />
    (Berkaitan dg proses yg sudah atau belum dilakukan dalam rangka mencapai target)</strong></div></td>
  </tr>
  <tr>
    <td><div align="center"><strong>Nilai Skala (1-5)</strong></div></td>
    <td><div align="center"><strong>Nilai Skala (1-5)</strong></div></td>
    <td><div align="center"><strong>Nilai Skala (1-5)</strong></div></td>
  </tr>
  <tr>
    <td><div align="center"><strong>A</strong></div></td>
    <td><div align="center"><strong>B</strong></div></td>
    <td><div align="center"><strong>Semester 1</strong></div></td>
    <td><div align="center"><strong>Semester 2 (C)</strong></div></td>
    <td><div align="center"><strong>C / B</strong></div></td>
    <td><div align="center"><strong>D1</strong></div></td>
    <td><div align="center"><strong>D2</strong></div></td>
    <td><div align="center"><strong>D3</strong></div></td>
    <td class="text-center"><strong>D3 x A</strong></td>
  </tr>
  <tr>
    <td colspan="16" bgcolor="#CCCCCC" style="border-top:3px double #000000"><strong>A. RESULT</strong></td>
  </tr>
  <tr>
    <td><strong>I</strong></td>
    <td colspan="15" height="20"><strong>KPI -KEY PERFORMANCE INDICATOR (Berdasarkan KPI evaluation yang mengacu pada Activity Plan)</strong></td>
  </tr>
  

  		<?php

      $SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM1+SM2)/Plan_B)*100 AS Achieve,MonRemarks 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=1 AND (EmployeeID='".$session_nik."' OR iAtasanNIK='".$session_nik."')";
      $query  = $this->db->query($SQL);

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
        foreach($query->result() as $data){ 
        	$total_bobot_1 += $data->Bobot_A;
          $nilai_akhir = ($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan);
          $score_akhir = ((($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)* $data->Bobot_A)/100);
          $total_score_1 += $score_akhir;
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
            <a href="javascript:void(0);" onclick="delete_plan('<?php echo $data->activity_id;?>')" title="Delete" class="link pull-right action-tools"><i class="glyphicon glyphicon-remove"></i> Delete</a>&nbsp;&nbsp;
            <?php } ?>

            <?php if ($key_agree == 1 && $key_active ==1){ ?>            
            <a href="javascript:void(0);" onclick="monitoring_plan('<?php echo $data->activity_id;?>')" title="Monitor" class="link pull-right action-tools" style="padding-right:5px"><i class="glyphicon glyphicon-comment"></i> Monitor</a>&nbsp;&nbsp;
            <?php } ?>

          </td>
			    <td class="text-center" width="4%"><?php echo $data->UoM ?></td>
			    <td class="text-center" width="7%"><?php echo date('d-M-Y', strtotime($data->DD))?></td>
			    <td class="text-center"><?php echo $data->Bobot_A ?></td>
			    <td class="text-center"><?php echo number_format($data->Plan_B , 0, ',', '.') ?></td>
			    <td class="text-center"><?php echo $data->SM1 ?></td>
          <td class="text-center"><?php echo $data->SM2 ?></td>
			    <td class="text-center"><?php echo number_format($data->Achieve,0) ?></td>
          <td class="text-left"><?php echo $data->MonRemarks ?></td>
          <td class="text-center"><?php echo $crud->set_nilai_skala($data->Achieve) ?></td>			    
			    <td class="text-center" width="5%"><?php echo $data->Nilai_Skala_Atasan ?></td>			    
			    <td class="text-center" width="5%"><?php echo $nilai_akhir;?></td>
			    <td class="text-center" width="3%"><?php echo $score_akhir;?></td>
			    <td>&nbsp;</td>
		  	</tr>

        <?php 
        $no++;
        }
        ?>

  <tr>
    <td colspan="16">&nbsp;</td>    
  </tr>
  <tr>
    <td><strong>II</strong></td>
    <td colspan="15" height="20"><strong>PERFORMANCE INDICATOR (ROUTINE ACTIVITY) </strong></td>
  </tr>


  		<?php
  		$SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM1+SM2)/Plan_B)*100 AS Achieve,MonRemarks 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=2 AND (EmployeeID='".$session_nik."' OR iAtasanNIK='".$session_nik."')";
      $query  = $this->db->query($SQL);

        $no=1;
        $total_bobot_2 = 0;
        $total_score_2 = 0;
        foreach($query->result() as $data){
        	$total_bobot_2 += $data->Bobot_A;
          $nilai_akhir = ($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan);
          $score_akhir = ((($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)* $data->Bobot_A)/100);
          $total_score_2 += $score_akhir;

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

			    <td class="text-center"><?php echo $data->UoM ?></td>
			    <td class="text-center"><?php echo date('d-M-Y', strtotime($data->DD))?></td>
			    <td class="text-center"><?php echo $data->Bobot_A ?></td>
			    <td class="text-center"><?php echo number_format($data->Plan_B , 0, ',', '.') ?></td>
			    <td class="text-center"><?php echo $data->SM1 ?></td>
          <td class="text-center"><?php echo $data->SM2 ?></td>
			    <td class="text-center"><?php echo number_format($data->Achieve,0) ?></td>
			    <td width="100">&nbsp;</td>
			    <td class="text-center"><?php echo $crud->set_nilai_skala($data->Achieve) ?></td>  
			    <td class="text-center"><?php echo $data->Nilai_Skala_Atasan ?></td>
			    <td class="text-center"><?php echo $nilai_akhir;?></td>
          <td class="text-center"><?php echo $score_akhir;?></td>
			    <td>&nbsp;</td>
		  	</tr>

        <?php 
        $no++;
        }
        ?>
  <tr>
    <td colspan="16">&nbsp;</td>    
  </tr>
  <tr>
    <td><strong>III</strong></td>
    <td colspan="15" height="20"><strong>SPECIAL ASSIGNMENT </strong></td>
  </tr>
  <?php
  		$SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM1+SM2)/Plan_B)*100 AS Achieve,MonRemarks 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=3 AND (EmployeeID='".$session_nik."' OR iAtasanNIK='".$session_nik."')";
      $query  = $this->db->query($SQL);

        $no=1;
        $total_bobot_3 = 0;
        $total_score_3 = 0;
        foreach($query->result() as $data){
        	$total_bobot_3 += $data->Bobot_A;
          $nilai_akhir = ($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan);
          $score_akhir = ((($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)* $data->Bobot_A)/100);
          $total_score_3 += $score_akhir;

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

			    <td class="text-center"><?php echo $data->UoM ?></td>
			    <td class="text-center"><?php echo date('d-M-Y', strtotime($data->DD))?></td>
			    <td class="text-center"><?php echo $data->Bobot_A ?></td>
			    <td class="text-center"><?php echo number_format($data->Plan_B , 0, ',', '.') ?></td>
			    <td class="text-center"><?php echo $data->SM1 ?></td>
			    <td class="text-center"><?php echo $data->SM2 ?></td>
			    <td class="text-center"><?php echo number_format($data->Achieve,0) ?></td>
			    <td width="100">&nbsp;</td>
			    <td class="text-center"><?php echo $crud->set_nilai_skala($data->Achieve) ?></td>  
			    <td class="text-center"><?php echo $data->Nilai_Skala_Atasan ?></td>
			    <td class="text-center"><?php echo $nilai_akhir;?></td>
          <td class="text-center"><?php echo $score_akhir;?></td>
			    <td>&nbsp;</td>
		  	</tr>

        <?php 
        $no++;
        }
        ?>
  <tr>

    <td colspan="16">&nbsp;</td>
    
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>   
    <td colspan="2" bgcolor="#000000" style="color:#FFFFFF" class="text-center">TOTAL BOBOT (A)</td>
    <td bgcolor="#000000" style="color:#FFFFFF" class="text-center"><?php echo ($total_bobot_1+$total_bobot_2+$total_bobot_3);?>%</td>
    <td>&nbsp;</td>
    <td colspan="2"></td>
    <td class="text-center"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" bgcolor="#000000" style="color:#FFFFFF" class="text-center">TOTAL SCORE (A)</td>
    <td bgcolor="#000000" style="color:#FFFFFF" class="text-center"><?php echo ($total_score_1+$total_score_2+$total_score_3);?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="16">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="16" bgcolor="#CCCCCC"><strong>B. PROCESS / COMPETENCY</strong></td>
  </tr>

  <tr >
    <td style="border-bottom:3px double #000000;" colspan="3" height="20"><strong>I. PROCESS & CORE VALUES</strong></td>
    <td style="border-bottom:3px double #000000;" colspan="4" class="text-center">BOBOT %</td>
    <td style="border-bottom:3px double #000000;" colspan="9">&nbsp;</td>
  </tr>

      <?php
      $SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM1+SM2)/Plan_B)*100 AS Achieve,MonRemarks 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=4 AND (EmployeeID='".$session_nik."' OR iAtasanNIK='".$session_nik."')";
      $query  = $this->db->query($SQL);

        $no=1;
        $total_bobot_4 = 0;
        $total_score_4 = 0;
        foreach($query->result() as $data){
          $total_bobot_4 += $data->Bobot_A;
          $nilai_akhir = ($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan);
          $score_akhir = ((($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)* $data->Bobot_A)/100);
          $total_score_4 += $score_akhir;

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

          </td>
          <td class="text-center"><?php echo $data->UoM ?></td>
          <td class="text-center"><?php echo date('d-M-Y', strtotime($data->DD))?></td>
          <td class="text-center"><?php echo $data->Bobot_A ?></td>
          <td class="text-center"><?php echo $data->Plan_B ?></td>
          <td class="text-center"><?php echo $data->SM1 ?></td>
          <td class="text-center"><?php echo $data->SM2 ?></td>
          <td class="text-center"><?php echo number_format($data->Achieve,0) ?></td>
          <td width="100">&nbsp;</td>
          <td class="text-center"><?php echo $crud->set_nilai_skala($data->Achieve) ?></td>  
          <td class="text-center"><?php echo $data->Nilai_Skala_Atasan ?></td>
          <td class="text-center"><?php echo $nilai_akhir;?></td>
          <td class="text-center"><?php echo $score_akhir;?></td>
          <td>&nbsp;</td>
        </tr>

        <?php 
        $no++;
        }
        ?>


   <tr>
    <td colspan="3">&nbsp;</td>   
    <td colspan="2" bgcolor="#000000" style="color:#FFFFFF" class="text-center">TOTAL BOBOT (BI)</td>
    <td bgcolor="#000000" style="color:#FFFFFF" class="text-center"><?php echo ($total_bobot_4);?>%</td>
    <td>&nbsp;</td>
    <td colspan="2"></td>
    <td class="text-center"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" bgcolor="#000000" style="color:#FFFFFF" class="text-center">TOTAL SCORE (BI)</td>
    <td bgcolor="#000000" style="color:#FFFFFF" class="text-center"><?php echo ($total_score_4);?></td>
    <td>&nbsp;</td>
  </tr>

<?php if($key_type == 2){ ?>
  <tr >
    <td style="border-bottom:3px double #000000;" colspan="3" height="20"><strong>II. MANAGING PEOPLE</strong></td>
    <td style="border-bottom:3px double #000000;" colspan="4" class="text-center">BOBOT %</td>
    <td style="border-bottom:3px double #000000;" colspan="9">&nbsp;</td>
  </tr>


      <?php
      $SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM1+SM2)/Plan_B)*100 AS Achieve,MonRemarks 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND ItemID=5 AND (EmployeeID='".$session_nik."' OR iAtasanNIK='".$session_nik."')";
      $query  = $this->db->query($SQL);

        $no=1;
        $total_bobot_5 = 0;
        $total_score_5 = 0;
        foreach($query->result() as $data){
          $total_bobot_5 += $data->Bobot_A;
          $nilai_akhir = ($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan);
          $score_akhir = ((($crud->set_nilai_skala($data->Achieve) + $data->Nilai_Skala_Atasan)* $data->Bobot_A)/100);
          $total_score_5 += $score_akhir;

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

          </td>
          <td class="text-center"><?php echo $data->UoM ?></td>
          <td class="text-center"><?php echo date('d-M-Y', strtotime($data->DD))?></td>
          <td class="text-center"><?php echo $data->Bobot_A ?></td>
          <td class="text-center"><?php echo $data->Plan_B ?></td>
          <td class="text-center"><?php echo $data->SM1 ?></td>
          <td class="text-center"><?php echo $data->SM2 ?></td>
          <td class="text-center"><?php echo number_format($data->Achieve,0) ?></td>
          <td width="100">&nbsp;</td>
          <td class="text-center"><?php echo $crud->set_nilai_skala($data->Achieve) ?></td>  
          <td class="text-center"><?php echo $data->Nilai_Skala_Atasan ?></td>
          <td class="text-center"><?php echo $nilai_akhir;?></td>
          <td class="text-center"><?php echo $score_akhir;?></td>
          <td>&nbsp;</td>
        </tr>

        <?php 
        $no++;
        }
        ?>

  <tr>
    <td colspan="3">&nbsp;</td>   
    <td colspan="2" bgcolor="#000000" style="color:#FFFFFF" class="text-center">TOTAL BOBOT (B II)</td>
    <td bgcolor="#000000" style="color:#FFFFFF" class="text-center"><?php echo ($total_bobot_5);?>%</td>
    <td>&nbsp;</td>
    <td colspan="2"></td>
    <td class="text-center"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" bgcolor="#000000" style="color:#FFFFFF" class="text-center">TOTAL SCORE (B)</td>
    <td bgcolor="#000000" style="color:#FFFFFF" class="text-center"><?php echo ($total_score_5);?></td>
    <td>&nbsp;</td>
  </tr>
<?php } ?>


<?php if($key_type == 2){

    $total_score_all = ($total_score_1+$total_score_2+$total_score_3+$total_score_4+$total_score_5);

  ?>
  <tr>
    <td colspan="3">&nbsp;</td>   
    <td colspan="2" bgcolor="#000000" style="color:#FFFFFF" class="text-center">TOTAL BOBOT (A+BI+BII)</td>
    <td bgcolor="#000000" style="color:#FFFFFF" class="text-center"><?php echo ($total_bobot_1+$total_bobot_2+$total_bobot_3+$total_bobot_4+$total_bobot_5);?>%</td>
    <td>&nbsp;</td>
    <td colspan="2"></td>
    <td class="text-center"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" bgcolor="#000000" style="color:#FFFFFF" class="text-center">TOTAL SCORE (A+BI+BII)</td>
    <td bgcolor="#000000" style="color:#FFFFFF" class="text-center"><?php echo ($total_score_1+$total_score_2+$total_score_3+$total_score_4+$total_score_5);?></td>
    <td>&nbsp;</td>
  </tr>

<?php } else {
    
    $total_score_all = ($total_score_1+$total_score_2+$total_score_3+$total_score_4); 

  ?>

  <tr>
    <td colspan="3">&nbsp;</td>   
    <td colspan="2" bgcolor="#000000" style="color:#FFFFFF" class="text-center">TOTAL BOBOT (A+BI)</td>
    <td bgcolor="#000000" style="color:#FFFFFF" class="text-center"><?php echo ($total_bobot_1+$total_bobot_2+$total_bobot_3+$total_bobot_4);?>%</td>
    <td>&nbsp;</td>
    <td colspan="2"></td>
    <td class="text-center"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" bgcolor="#000000" style="color:#FFFFFF" class="text-center">TOTAL SCORE (A+BI)</td>
    <td bgcolor="#000000" style="color:#FFFFFF" class="text-center"><?php echo ($total_score_1+$total_score_2+$total_score_3+$total_score_4);?></td>
    <td>&nbsp;</td>
  </tr>

<?php } ?>

  <tr>
    <td colspan="12" height="35" class="text-right" style="border-bottom:none !important; font-weight:bold; padding-right:5px"><font size="2">NILAI AKHIR</font></td>
    <td colspan="3" class="text-center" bgcolor="#000000" style="color:#FFFFFF"><font size="2"><strong><?php echo $crud->set_nilai_akhir_pa($total_score_all); ?></strong></font></td>
    <td>&nbsp;</td>
  </tr>

  
  <tr>
    <td colspan="12" style="border-top:none !important">&nbsp;</td>
    <td colspan="4">

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

            
            $('[name="activity_id"]').val(data.activity_id);
            $('[name="KPIID"]').val(data.KPIID);
        
            $('[name="ItemID"]  option[value="'+data.ItemID+'"').prop("selected", true);
            $('[name="ItemID"]').val(data.ItemID).change();

            
            $('[name="UoM"]  option[value="'+data.UoM+'"').prop("selected", true);
            $('[name="UoM"]').val(data.UoM).change();     
            
            $('[name="DD"]').val(php_date_to_js(data.DD));

            //$('[name="DD"]').datepicker('update',data.DD);


            $('[name="Description"]').val(data.Description);
            $('[name="Bobot_A"]').val(data.Bobot_A);
            $('[name="Plan_B"]').val(data.Plan_B);

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
                $('[name="EveryMonth"]').prop('checked', true);
            }
            else{
                $('[name="EveryMonth"]').prop('checked', false);
            }
            
            $('#modal_form').modal({backdrop: 'static'});
            $('#modal_form').modal('show');
            

            $('.modal-title').text('{{ language:PLAN }} #'+data.activity_id);

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
        url : "<?php echo site_url('development/user_key_performance_indicator/plan_monitoring/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {            

            $('[name="activity_id"]').val(data.activity_id);
            $('[name="KPIID"]').val(data.KPIID);

            $('[name="activity_description"]').text(data.Description);
            $('[name="MonRemarks"]').val(data.MonRemarks);

            $('[name="SM1"]').val(data.SM1);
            $('[name="SM2"]').val(data.SM2);


            $('[name="Nilai_Skala_Atasan"]  option[value="'+data.Nilai_Skala_Atasan+'"').prop("selected", true);
            $('[name="Nilai_Skala_Atasan"]').val(data.Nilai_Skala_Atasan).change();

           
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
            }


            $('#photo-preview').show();

            if(data.photo)
            {
                $('#label-photo').text('Change Evidence (max 1 M)'); // label photo upload
                //$('#photo-preview div').html('<img src="'+base_url+'assets/files/upload_pa/'+data.photo+'" class="img-responsive">'); // show photo
                $('#photo-preview div').html('<a href="'+base_url+'assets/files/upload_pa/'+data.photo+'" target="_blank" class="img-responsive">'+data.photo+'</a> '); // show photo
                $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="'+data.photo+'"/> Remove evidence when saving'); // remove photo

            }
            else
            {
                $('#label-photo').text('Upload Evidence (max 1 M)'); // label photo upload
                $('#photo-preview div').text('(No Evidence)');
            }           

                        
            $('#modal_form_monitoring').modal({backdrop: 'static'});
            $('#modal_form_monitoring').modal('show');           

            $('.modal-title').text('{{ language:MONITORING }} #'+data.activity_id);

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

    $('[name="KPIID"]').val(id);

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
    $('.modal-title').text('Add Plan'); // Set Title to Bootstrap modal title
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


function deal_plan(id)
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


function undeal_plan(id)
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
                location.reload();
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
                location.reload();
            }
             

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });
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
                        <div class="form-group">
                            <label class="control-label col-md-4">Item*</label>                            
                            <div class="col-md-8">
                                <select name="ItemID" class="selectpicker form-control">          
                                    <option value="1">KPI -KEY PERFORMANCE INDICATOR</option>
                                    <option value="2">PERFORMANCE INDICATOR (ROUTINE ACTIVITY)</option>
                                    <option value="3">SPECIAL ASSIGNMENT</option>
                                    <option value="4">PROCESS & CORE VALUES</option>
                                    <option value="5">MANAGING PEOPLE</option>
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
                                    <option value="Times">Times</option>
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
                            <label class="control-label col-md-4"></label>
                            <div class="col-md-4">
                              <label class="control-label">Bobot (%)*</label>
                              <input name="Bobot_A" placeholder="dalam angka, tidak usah %" class="form-control numeric" type="text">
                              <span class="help-block"></span>
                            </div>

                            <div class="col-md-4">
                              <label class="control-label">TARGET PLAN*</label>
                              <input name="Plan_B" placeholder="dalam angka" class="form-control numeric" type="text">
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
                            <label class="control-label col-md-3">Penilain dari Atasan</label>
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

</style>