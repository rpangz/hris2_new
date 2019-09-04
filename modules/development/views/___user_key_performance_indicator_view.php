<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$crud = new user_key_performance_indicator();

?>

<style>

table {
	font-size:10px;
	color: #000000;
}

.link
{
   color:#000000 !important;
   text-decoration: none; 
   background-color: none;
}
</style>

<?php echo $crud->period_option(); ?>

<div class="btn-group pull-right">
        
    <a href="{{ MODULE_SITE_URL }}user_key_performance_indicator" class="btn btn-default <?php echo $crud->navigation_name('');?>" title="{{ language:Result }}"><i class="glyphicon glyphicon-list-alt"></i></a>

    <a href="{{ MODULE_SITE_URL }}user_key_performance_indicator/header_form" class="btn btn-default <?php echo $crud->navigation_name('header_form');?>" title="{{ language:Header Form }}"><i class="glyphicon glyphicon-tasks"></i></a>

    <a href="{{ MODULE_SITE_URL }}user_key_performance_indicator/activity_plan" class="btn btn-default <?php echo $crud->navigation_name('activity_plan');?>" title="{{ language:KPI-KEY PERFORMANCE INDICATOR (Berdasarkan KPI evaluation yang mengacu pada Activity Plan) }}"><i class="glyphicon glyphicon-plane"></i></a>

    <a href="{{ MODULE_SITE_URL }}user_key_performance_indicator/routine_activity" class="btn btn-default <?php echo $crud->navigation_name('routine_activity');?>" title="{{ language:PERFORMANCE INDICATOR (ROUTINE ACTIVITY) }}"><i class="glyphicon glyphicon-tag"></i></a>

    <a href="{{ MODULE_SITE_URL }}user_key_performance_indicator/special_assignment" class="btn btn-default <?php echo $crud->navigation_name('special_assignment');?>" title="{{ language:SPECIAL ASSIGNMENT }}"><i class="glyphicon glyphicon-comment"></i></a>

</div>


<br/>
<br/>

<table width="100%" border="1" cellspacing="0" cellpadding="2">
  <tr>
    <th colspan="2" scope="col"><div align="left">NO. DOKUMEN</div></th>
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
  <tr>
    <td colspan="2">NAMA</td>
    <td bgcolor="#CCCCCC"><?php echo $result['EmployeeID'].'/'.$crud->cms_table_data($table_name='tbl_profile', $where_column='NIK', $result_column='Nama', $result['EmployeeID']);?></td>
    <td colspan="14" rowspan="3" bgcolor="#CCCCCC"><div align="center"><strong>PERFORMANCE MANAGEMENT FORM<br />
    Gol. 4A - 4D TANPA BAWAHAN (ANALYST/OFFICER)</strong></div></td>
  </tr>
  <tr>
    <td colspan="2">JABATAN</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">SUB GOLONGAN</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">DIVISI / FUNCTION </td>
    <td bgcolor="#CCCCCC"><?php echo $crud->cms_table_data($table_name='tbl_div', $where_column='iDivId', $result_column='cDivName', $result['DivisionID']);?></td>
    <td colspan="4" rowspan="3" bgcolor="#9999CC"><div align="center"><strong>PERFORMANCE PLAN </strong></div></td>
    <td colspan="5" rowspan="3" bgcolor="#9999CC"><div align="center"><strong>PERFORMANCE MONITORING</strong></div></td>
    <td colspan="5" rowspan="3" bgcolor="#9999CC"><div align="center"><strong>PERFORMANCE APPRAISAL</strong></div></td>
  </tr>
  <tr>
    <td colspan="2">DEPARTMENT </td>
    <td bgcolor="#CCCCCC"><?php echo $crud->cms_table_data($table_name='tbl_dept', $where_column='iDeptID', $result_column='cDeptName', $result['DepartmentID']);?></td>
  </tr>
  <tr>
    <td colspan="2">PERIODE </td>
    <td bgcolor="#CCCCCC"><?php echo $result['PeriodID']?></td>
  </tr>
  <tr>
    <td width="28" rowspan="3"><div align="center"><strong>NO</strong></div></td>
    <td colspan="2" rowspan="3"><div align="center"><strong>ACTIVITY PLAN</strong></div></td>
    <td width="39" rowspan="3"><div align="center"><strong>UoM</strong></div></td>
    <td width="40" rowspan="3"><div align="center"><strong>DD</strong></div></td>
    <td width="35" rowspan="2"><div align="center"><strong>Bobot (%)</strong></div></td>
    <td width="37" rowspan="2"><div align="center"><strong>PLAN</strong></div></td>
    <td colspan="2" rowspan="2"><div align="center"><strong>ACTUAL</strong></div></td>
    <td width="71" rowspan="2"><div align="center"><strong>% Achievement </strong></div></td>
    <td rowspan="3"><div align="center"><strong>Catatan (Semester 1)<br />
    (Berkaitan dg proses yg sudah atau belum dilakukan dalam rangka mencapai target)</strong></div></td>
    <td width="54"><div align="center"><strong>Penilaian Karyawan</strong></div></td>
    <td width="54"><div align="center"><strong>Penilaian Atasan</strong></div></td>
    <td width="37"><div align="center"><strong>NILAI AKHIR</strong></div></td>
    <td width="43" rowspan="2"><strong>SCORE AKHIR<br />
    (Nilai X Bobot)</strong></td>
    <td width="187" rowspan="3"><div align="center"><strong>Catatan (Semester 2)<br />
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
    <td width="52"><div align="center"><strong>Semester 1</strong></div></td>
    <td width="68"><div align="center"><strong>Semester 2 (C)</strong></div></td>
    <td><div align="center"><strong>C / B</strong></div></td>
    <td><div align="center"><strong>D1</strong></div></td>
    <td><div align="center"><strong>D2</strong></div></td>
    <td><div align="center"><strong>D3</strong></div></td>
    <td><strong>D3 x A</strong></td>
  </tr>
  <tr>
    <td colspan="17" bgcolor="#FF9900" style="border-top:3px double #000000"><strong>A. RESULT</strong></td>
  </tr>
  <tr bgcolor="#FFFF00">
    <td><strong>I</strong></td>
    <td colspan="16"><strong>KPI -KEY PERFORMANCE INDICATOR (Berdasarkan KPI evaluation yang mengacu pada Activity Plan)</strong></td>
  </tr>
  

  		<?php
  		$query = $this->db->select('*')
               ->from('tbl_kpi_activity_plan')
               ->join('tbl_kpi_header_form','tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID')
               ->where('tbl_kpi_activity_plan.KPIID', $primary_key)
               ->where('EmployeeID', $session_nik)           
               ->get();
        $no=1;
        $total_bobot_1 = 0;
        foreach($query->result() as $data){ 
        	$total_bobot_1 += $data->Bobot_A;
        ?>
        	<tr>
			    <td class="text-right"><?php echo $no?>.</td>
			    <td colspan="2"><a href="<?php echo site_url('development/user_key_performance_indicator/activity_plan/edit/'.$data->activity_id) ?>" title="Edit" class="link"><?php echo $data->Description?></a></td>
			    <td class="text-center"><?php echo $data->UoM ?></td>
			    <td class="text-center"><?php echo date('d-M-Y', strtotime($data->DD))?></td>
			    <td class="text-center"><?php echo $data->Bobot_A ?></td>
			    <td class="text-center"><?php echo $data->Plan_B ?></td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td width="100">&nbsp;</td>
			    <td width="100">&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
		  	</tr>

        <?php 
        $no++;
        }
        ?>

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
  <tr bgcolor="#FFFF00">
    <td><strong>II</strong></td>
    <td colspan="16"><strong>PERFORMANCE INDICATOR (ROUTINE ACTIVITY) </strong></td>
  </tr>


  		<?php
  		$query = $this->db->select('*')
               ->from('tbl_kpi_routine_activity')
               ->join('tbl_kpi_header_form','tbl_kpi_header_form.KPIID=tbl_kpi_routine_activity.KPIID')
               ->where('tbl_kpi_routine_activity.KPIID', $primary_key)
               ->where('EmployeeID', $session_nik)           
               ->get();
        $no=1;
        $total_bobot_2 = 0;
        foreach($query->result() as $data){
        	$total_bobot_2 += $data->Bobot_A;
        ?>
        	<tr>
			    <td class="text-right"><?php echo $no?>.</td>
			    <td colspan="2"><a href="<?php echo site_url('development/user_key_performance_indicator/routine_activity/edit/'.$data->routine_id) ?>" title="Edit" class="link"><?php echo $data->Description?></a></td>
			    <td class="text-center"><?php echo $data->UoM ?></td>
			    <td class="text-center"><?php echo date('d-M-Y', strtotime($data->DD))?></td>
			    <td class="text-center"><?php echo $data->Bobot_A ?></td>
			    <td class="text-center"><?php echo $data->Plan_B ?></td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td width="100">&nbsp;</td>
			    <td width="100">&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
		  	</tr>

        <?php 
        $no++;
        }
        ?>
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
  <tr bgcolor="#FFFF00">
    <td><strong>III</strong></td>
    <td colspan="16"><strong>SPECIAL ASSIGNMENT </strong></td>
  </tr>
  <?php
  		$query = $this->db->select('*')
               ->from('tbl_kpi_special_assignment')
               ->join('tbl_kpi_header_form','tbl_kpi_header_form.KPIID=tbl_kpi_special_assignment.KPIID')
               ->where('tbl_kpi_special_assignment.KPIID', $primary_key)
               ->where('EmployeeID', $session_nik)           
               ->get();
        $no=1;
        $total_bobot_3 = 0;
        foreach($query->result() as $data){
        	$total_bobot_3 += $data->Bobot_A;

       	?>

         
        	<tr>
			    <td class="text-right"><?php echo $no?>.</td>
			    <td colspan="2"><a href="<?php echo site_url('development/user_key_performance_indicator/special_assignment/edit/'.$data->assignment_id) ?>" title="Edit" class="link"><?php echo $data->Description?></a></td>
			    <td class="text-center"><?php echo $data->UoM ?></td>
			    <td class="text-center"><?php echo date('d-M-Y', strtotime($data->DD))?></td>
			    <td class="text-center"><?php echo $data->Bobot_A ?></td>
			    <td class="text-center"><?php echo $data->Plan_B ?></td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td width="100">&nbsp;</td>
			    <td width="100">&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
		  	</tr>

        <?php 
        $no++;
        }
        ?>
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
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" bgcolor="#33FFFF">TOTAL BOBOT (A)</td>
    <td bgcolor="#33FFFF" class="text-center"><?php echo ($total_bobot_1+$total_bobot_2+$total_bobot_3);?>%</td>
    <td>&nbsp;</td>
    <td colspan="2" bgcolor="#99FF33">Total</td>
    <td bgcolor="#99FF33" class="text-center">00%</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" bgcolor="#99FF33">TOTAL BOBOT (A)</td>
    <td bgcolor="#99FF33" class="text-center">000</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="73">&nbsp;</td>
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
    <td>&nbsp;</td>
  </tr>
</table>