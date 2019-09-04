<?php
class development_model extends CI_Model  {


	function __construct(){
        parent::__construct();
        $this->load->model('detail_form_model');
        
  }
    

    public function user_kpi_performance($session_nik, $session_company, $session_dept, $session_kpi=1, $action, $field, $periode, $primary_key){

        //$module_path = $this->cms_module_path();
        

        //$this->set_rules('birthdate','birthdate','required');        

        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from('tbl_kpi_performance')
            ->where('performance_nik', 4833)
            ->where('performance_periode', 2015)
            ->get();
        $result = $query->result_array();
        $num_row = $query->num_rows();


        $val1 = $this->current_value_performace($session_nik, $periode);
        $val2 = $this->kpi_weight($session_kpi=1);

        $current_value = ($val1 * $val2)/100;
        $current_value = ($current_value)/$num_row;
        $current_value = number_format($current_value,2);

       
        $data = array(
            'title' => '<h3>'.$this->kpi_type_title($session_kpi=1).'</h3>',
            'result' => $result,
            'total' => $num_row,
            'current_value_performance' => $current_value,
        );
        return $this->load->view('development/field_detail_performance',$data, TRUE);

    }


    public function user_kpi_attitude($session_nik, $session_company, $session_dept, $session_kpi=1, $action, $field, $periode, $primary_key){

      $date_format = $this->config->item('grocery_crud_date_format');
      $module_path = 'development'; 
     
      $this->config->load('grocery_crud');
      
        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from('tbl_kpi_attitude')
            ->where('attitude_nik', 4833)
            ->where('attitude_periode', 2015)
            ->get();
        $result = $query->result_array();
        $num_row = $query->num_rows();

        $val1 = $this->current_value_attitude($session_nik, $periode);
        $val2 = $this->kpi_weight($session_kpi=2);

        $current_value = ($val1 * $val2)/100;
        $current_value = ($current_value)/$num_row;
        $current_value = number_format($current_value,2);

       
        $data = array(
            'title' => '<h3>'.$this->kpi_type_title($session_kpi=2).'</h3>',
            'result' => $result,
            'periode' => $periode,
            'total' => $num_row,
            'current_value_attitude' => $current_value,
        );

      return $this->load->view('development/field_detail_attitude',$data, TRUE);


    }


    public function user_kpi_time($session_nik, $session_company, $session_dept, $session_kpi=1, $action, $field, $periode, $primary_key){

      $date_format = $this->config->item('grocery_crud_date_format');
      $module_path = 'development'; 
     
      $this->config->load('grocery_crud');
      
        if(!isset($primary_key)) $primary_key = -1;
        $query = $this->db->select('*')
            ->from('tbl_kpi_attitude')
            ->where('attitude_nik', 4833)
            ->where('attitude_periode', 2015)
            ->get();
        $result = $query->result_array();
        $num_row = $query->num_rows();

        $val1 = $this->current_value_attitude($session_nik, $periode);
        $val2 = $this->kpi_weight($session_kpi=2);

        $current_value = ($val1 * $val2)/100;
        $current_value = ($current_value)/$num_row;
        $current_value = number_format($current_value,2);

       
        $data = array(
            'title' => '<h3>'.$this->kpi_type_title($session_kpi=3).'</h3>',
            'result' => $result,
            'periode' => $periode,
            'total' => $num_row,
            'current_value_attitude' => $current_value,
        );

      return $this->load->view('development/field_detail_time',$data, TRUE);


    }


    public function user_kpi_timexxx($session_nik, $session_company, $session_dept, $session_kpi, $action, $periode){

      $data = '<h3>'.$this->kpi_type_title($session_kpi=3).'</h3>                
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td>
            <table class="table table-striped" style="font-size:12px;" width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td width="1%" rowspan="3" valign="middle"><div align="center">No</div></td>
              <td rowspan="3" valign="middle"><div align="center">Faktor</div></td>
              <td colspan="4" rowspan="3" valign="middle"><div align="center">Keterangan</div></td>
              <td colspan="10"><div align="center">Kategori Penilaian</div></td>
            </tr>
            <tr>
              <td colspan="3"><div align="center">Baik</div></td>
              <td colspan="3"><div align="center">Cukup</div></td>
              <td colspan="4"><div align="center">Kurang</div></td>
            </tr>
            <tr>
              <td width="6%"><div align="center">10</div></td>
              <td width="6%"><div align="center">9</div></td>
              <td width="6%"><div align="center">8</div></td>
              <td width="6%"><div align="center">7</div></td>
              <td width="6%"><div align="center">6</div></td>
              <td width="6%"><div align="center">5</div></td>
              <td width="6%"><div align="center">4</div></td>
              <td width="6%"><div align="center">3</div></td>
              <td width="6%"><div align="center">2</div></td>
              <td width="6%"><div align="center">1</div></td>
            </tr>
            <tr>
              <td rowspan="2"><div align="center">1</div></td>
              <td rowspan="2">Datang terlambat</td>
              <td rowspan="2" class="noborder-r">Jumlah dalam 1 tahun</td>
              <td rowspan="2" class="noborder-lr">:</td>
              <td rowspan="2" class="noborder-lr"><input type="text" name="datang_terlambat" id="datang_terlambat" value="'.$this->jumlah_datang_terlambat($session_nik,$periode).'" class="form-control"/></td>
              <td rowspan="2" class="noborder-l">menit</td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="10_time_1" value="10" '.$this->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=10).' onclick="UpdateCostTime()"/><label for="10_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="9_time_1" value="9" '.$this->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=9).' onclick="UpdateCostTime()"/><label for="9_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="8_time_1" value="8" '.$this->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=8).' onclick="UpdateCostTime()"/><label for="8_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="7_time_1" value="7" '.$this->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=7).' onclick="UpdateCostTime()"/><label for="7_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="6_time_1" value="6" '.$this->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=6).' onclick="UpdateCostTime()"/><label for="6_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="5_time_1" value="5" '.$this->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=5).' onclick="UpdateCostTime()"/><label for="5_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="4_time_1" value="6" '.$this->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=4).' onclick="UpdateCostTime()"/><label for="4_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="3_time_1" value="3" '.$this->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=3).' onclick="UpdateCostTime()"/><label for="3_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="2_time_1" value="2" '.$this->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=2).' onclick="UpdateCostTime()"/><label for="2_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="1_time_1" value="1" '.$this->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=1).' onclick="UpdateCostTime()"/><label for="1_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
            </tr>
            <tr>
              <td><div align="center">&lt;260 &quot;</div></td>
              <td><div align="center">261-530 &quot;</div></td>
              <td><div align="center">531-791</div></td>
              <td><div align="center">791-1050</div></td>
              <td><div align="center">1051-1320</div></td>
              <td><div align="center">1321-1580</div></td>
              <td><div align="center">1581-1840</div></td>
              <td><div align="center">1841-2110</div></td>
              <td><div align="center">2111-2370</div></td>
              <td><div align="center">&gt;2371</div></td>
            </tr>
            <tr>
              <td rowspan="2">2</td>
              <td rowspan="2">Sakit tanpa Surat Dokter </td>
              <td rowspan="2" class="noborder-r">Jumlah dalam 1 tahun</td>
              <td rowspan="2" class="noborder-lr">:</td>
              <td rowspan="2" class="noborder-lr"><input type="text" name="tanpa_surat_dokter" id="tanpa_surat_dokter" value="'.$this->jumlah_sakit_tanpa_surat_dokter($session_nik, $periode).'" class="form-control"/><div id="total_sakit_tanpa_surat_dokter"></div></td>
              <td rowspan="2" class="noborder-l">hari</td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="10_time_2" value="10" '.$this->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=10).' onclick="UpdateCostTime()"/><label for="10_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="9_time_2" value="9" '.$this->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=9).' onclick="UpdateCostTime()"/><label for="9_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="8_time_2" value="8" '.$this->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=8).' onclick="UpdateCostTime()"/><label for="8_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="7_time_2" value="7" '.$this->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=7).' onclick="UpdateCostTime()"/><label for="7_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="6_time_2" value="6" '.$this->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=6).' onclick="UpdateCostTime()"/><label for="6_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="5_time_2" value="5" '.$this->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=5).' onclick="UpdateCostTime()"/><label for="5_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="4_time_2" value="4" '.$this->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=4).' onclick="UpdateCostTime()"/><label for="4_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="3_time_2" value="3" '.$this->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=3).' onclick="UpdateCostTime()"/><label for="3_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="2_time_2" value="2" '.$this->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=2).' onclick="UpdateCostTime()"/><label for="2_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="1_time_2" value="1" '.$this->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=1).' onclick="UpdateCostTime()"/><label for="1_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
            </tr>
            <tr>
              <td><div align="center">0 hr</div></td>
              <td><div align="center">1 hr</div></td>
              <td><div align="center">2 hr</div></td>
              <td><div align="center">3 hr</div></td>
              <td><div align="center">4 hr</div></td>
              <td><div align="center">5 hr</div></td>
              <td><div align="center">6 hr</div></td>
              <td><div align="center">7 hr</div></td>
              <td><div align="center">8 hr</div></td>
              <td><div align="center">&gt; 8hr</div></td>
            </tr>
            <tr>
              <td rowspan="2">3</td>
              <td rowspan="2">Alpha/tidak hadir tanpa alasan </td>
              <td rowspan="2" class="noborder-r">Jumlah dalam 1 tahun</td>
              <td rowspan="2" class="noborder-lr">:</td>
              <td rowspan="2" class="noborder-lr"><input type="text" name="tidak_hadir" id="tidak_hadir" value="'.$this->jumlah_tidak_hadir_tanpa_alasan($session_nik,$periode).'" class="form-control"/></td>
              <td rowspan="2" class="noborder-l">hari</td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="10_time_3" value="10" '.$this->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=10).' onclick="UpdateCostTime()"/><label for="10_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="9_time_3" value="9" '.$this->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=9).' onclick="UpdateCostTime()"/><label for="9_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="8_time_3" value="8" '.$this->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=8).' onclick="UpdateCostTime()"/><label for="8_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="7_time_3" value="7" '.$this->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=7).' onclick="UpdateCostTime()"/><label for="7_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="6_time_3" value="6" '.$this->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=6).' onclick="UpdateCostTime()"/><label for="6_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="5_time_3" value="5" '.$this->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=5).' onclick="UpdateCostTime()"/><label for="5_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="4_time_3" value="4" '.$this->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=4).' onclick="UpdateCostTime()"/><label for="4_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="3_time_3" value="3" '.$this->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=3).' onclick="UpdateCostTime()"/><label for="3_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="2_time_3" value="2" '.$this->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=2).' onclick="UpdateCostTime()"/><label for="2_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
              <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="1_time_3" value="1" '.$this->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=1).' onclick="UpdateCostTime()"/><label for="1_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
            </tr>
            <tr>
              <td><div align="center"></div></td>
              <td><div align="center">0 hr</div></td>
              <td><div align="center">1 hr</div></td>
              <td><div align="center">2 hr</div></td>
              <td><div align="center">3 hr</div></td>
              <td><div align="center">4 hr</div></td>
              <td><div align="center">5 hr</div></td>
              <td><div align="center">6 hr</div></td>
              <td><div align="center">7 hr</div></td>
              <td><div align="center">&gt; 8hr</div></td>
            </tr>
            <tr>
              <td colspan="6" class="noborder-r"><div align="right">TOTAL PENILAIAN KEDISIPLINAN WAKTU</div></td>
              <td class="noborder-lr"><div align="center" id="total_rata_rata_time">'.$this->nilai_rata_rata_time($session_nik,$periode).'</div></td>
              <td colspan="3" class="noborder-lr"><div align="center">% x (nilai rata-rata) =</div></td>
              <td class="noborder-lr"><div id="total_time_result_temp">'.$this->calculate_rata_rata_time($session_nik,$periode).'</div></td>
              <td class="noborder-lr">&nbsp;</td>
              <td class="noborder-lr">&nbsp;</td>
              <td class="noborder-lr">&nbsp;</td>
              <td class="noborder-lr">&nbsp;</td>
              <td class="noborder-lr">&nbsp;</td>
            </tr>
          </table>
          </td>
            </tr>


          <tr>
            <td>
            <table class="table table-striped" style="font-size:12px;" width="100%" border="1" cellspacing="0" cellpadding="0">
             <tr>
              <td colspan="14"><strong>HASIL PENILAIAN</strong></td>
            </tr>
            <tr>
              <td class="noborder-r"><div align="center">A.</div></td>
              <td class="noborder-lr">KINERJA OPERASIONAL</td>
              <td class="noborder-lr"><div align="center">=</div></td>
              <td class="noborder-l"><div align="center" id="total_performance_result"></div></td>
              <td colspan="5" class="noborder-r"><strong>Baik Sekali</strong></td>
              <td colspan="5" class="noborder-l"><div align="right"><strong>Kurang Sekali</strong></div></td>
            </tr>
            <tr>
              <td class="noborder-r"><div align="center">B.</div></td>
              <td class="noborder-lr">SIKAP KERJA</td>
              <td class="noborder-lr"><div align="center">=</div></td>
              <td class="noborder-l"><div align="center" id="total_attitude_result" class="total"></div></td>
              <td class="noborder-r"><div align="right" id="pointA"><strong></strong></div></td>
              <td colspan="2" class="noborder-l"><strong>Baik</strong></td>
              <td class="noborder-r"><div align="right" id="pointB"><strong></strong></div></td>
              <td colspan="2" class="noborder-l"><strong>Cukup</strong></td>
              <td class="noborder-r"><div align="right" id="pointC"><strong></strong></div></td>
              <td colspan="3" class="noborder-l"><strong>Kurang</strong></td>
            </tr>
            <tr>
              <td class="noborder-r"><div align="center">C.</div></td>
              <td class="noborder-lr">KEDISIPLINAN WAKTU</td>
              <td class="noborder-lr"><div align="center">=</div></td>
              <td width="6%" class="noborder-l"><div align="center" id="total_time_result" class="total">'.$this->calculate_rata_rata_time($session_nik,$periode).'</div></td>
              <td width="6%" class="noborder-r" align="center"><div align="center" class="" id="total_color_10">10</div></td>
              <td width="6%" class="noborder-lr" align="center"><div align="center" class="" id="total_color_9">9</div></td>
              <td width="6%" class="noborder-l" align="center"><div align="center" class="" id="total_color_8">8</div></td>
              <td width="6%" class="noborder-r" align="center"><div align="center" class="" id="total_color_7">7</div></td>
              <td width="6%" class="noborder-lr" align="center"><div align="center" class="" id="total_color_6">6</div></td>
              <td width="6%" class="noborder-l" align="center"><div align="center" class="" id="total_color_5">5</div></td>
              <td width="6%" class="noborder-r" align="center"><div align="center" class="" id="total_color_4">4</div></td>
              <td width="6%" class="noborder-lr" align="center"><div align="center" class="" id="total_color_3">3</div></td>
              <td width="6%" class="noborder-lr" align="center"><div align="center" class="" id="total_color_2">2</div></td>
              <td width="6%" class="noborder-l" align="center"><div align="center" class="" id="total_color_1">1</div></td>
            </tr>
            <tr>
              <td class="noborder-r">&nbsp;</td>
              <td class="noborder-lr">&nbsp;</td>
              <td class="noborder-lr">&nbsp;</td>
              <td class="noborder-lr">&nbsp;</td>
              <td colspan="10" rowspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" class="noborder-r"><div align="right"><strong>TOTAL NILAI</strong></div></td>
              <td class="noborder-lr"><div align="center">=</div></td>
              <td class="noborder-l"><strong><div align="center" id="grand_total_kpi_result"></div></strong></td>
            </tr>
            <tr>
              <td class="noborder-r">&nbsp;</td>
              <td class="noborder-lr">&nbsp;</td>
              <td class="noborder-lr">&nbsp;</td>
              <td class="noborder-lr">&nbsp;</td>
            </tr>
          </table>
          </td>
          </tr>



            <tr>
              <td>
                <table class="table table-striped" width="100%" border="1" cellspacing="1" cellpadding="0">
                <tr>
                  <td colspan="2"><div align="center"><strong>ASPEK KELEBIHAN-KELEMAHAN KARYAWAN &amp; SARAN</strong></div></td>
                  </tr>
                <tr>
                  <td width="20%">Kelebihan</td>
                  <td width="80%">
                    <textarea style="width: 100%; height: 100%; border: none" placeholder="Silahkan diisi..." class="form-control"></textarea>
                  </td>
                </tr>
                <tr>
                  <td>Saran untuk mengembangkan kelebihan karyawan</td>
                  <td>
                    <textarea style="width: 100%; height: 100%; border: none" placeholder="Silahkan diisi..." class="form-control"></textarea>
                  </td>
                </tr>
                <tr>
                  <td>Kelemahan</td>
                  <td>
                    <textarea style="width: 100%; height: 100%; border: none" placeholder="Silahkan diisi..." class="form-control"></textarea>
                  </td>
                </tr>
                <tr>
                  <td>Saran untuk memperbaiki kelemahan karyawan</td>
                  <td>
                    <textarea style="width: 100%; height: 100%; border: none" placeholder="Silahkan diisi..." class="form-control"></textarea>
                  </td>
                </tr>
              </table>
            </td>
            </tr>
            <tr>
              <td>&nbsp;</td>  
            </tr>
            <tr>
              <td height="173">
                <table class="table table-striped" width="100%" border="1" cellspacing="1" cellpadding="0">
                <tr>
                  <td colspan="2"><div align="center"><strong>KOMENTAR PENILAI</strong></div></td>
                  </tr>
                <tr>
                  <td colspan="2">
                    <textarea style="width: 100%; height: 100%; border: none" placeholder="Silahkan diisi..." class="form-control"></textarea>
                  </td>
                  </tr>
                <tr>
                  <td width="50%" height="34">Nama &amp; tanda tangan penilai :</td>
                  <td width="50%">Nama &amp; tanda tangan atasan penilai :</td>
                </tr>
                <tr>
                  <td height="29">Tanggal :</td>
                  <td>Tanggal :</td>
                </tr>
              </table>
            </td>
            </tr>
            <tr>
              <td>&nbsp;</td>   
            </tr>
            <tr>
              <td>
                <table class="table table-striped" width="100%" border="1" cellspacing="1" cellpadding="0">
                <tr>
                  <td colspan="2"><div align="center"><strong>KOMENTAR PEMEGANG JABATAN</strong></div></td>
                  </tr>
                <tr>
                  <td colspan="2">
                    <textarea style="width: 100%; height: 100%; border: none" placeholder="Silahkan diisi..." class="form-control"></textarea>
                  </td>
                  </tr>
                <tr>
                  <td width="50%" height="45">Nama &amp; tanda tangan :</td>
                  <td width="50%">Tanggal :</td>
                </tr>
              </table>
            </td>
            </tr>
            <tr>
              <td>&nbsp;</td>             
            </tr>
          </table>                            
          ';

    return $data;
    
    }


    public function nav_tabs_kpi(){

      $query = mysql_query("SELECT * FROM tbl_kpi_type WHERE kpi_type_status='1'");
      $total = mysql_num_rows($query);

      $no =1;
      $navi = '';
      while($data = mysql_fetch_array($query)){

        if ($no==1){
          $status= 'active';
        }else{
          $status= '';
        }

        $navi .= '<li class="'.$status.'"><a href="#'.$data['kpi_type_name'].'" data-toggle="tab"><img src="'.$data['kpi_type_icon'].'" class="img-circle" alt="'.$data['kpi_type_name'].'" width="30" height="30"> '.$data['kpi_type_name'].'</a></li>';

        $no++;

      }

      return $navi;


    }


    public function nav_tabs_content_kpi($session_nik, $session_company, $session_dept, $session_kpi=NULL, $action, $field, $periode){

      $query = mysql_query("SELECT * FROM tbl_kpi_type WHERE kpi_type_status='1'");
      $total = mysql_num_rows($query);

      $no =1;
      $navi = '';
      while($data = mysql_fetch_array($query)){

        if ($no==1){
          $status= 'active';
        }else{
          $status= '';
        }

        $code = 'user_kpi_'.$data['kpi_type_code'];

        $navi .= '<div class="tab-pane fade in '.$status.'" id="'.$data['kpi_type_name'].'">';
        $navi .= $this->development_model->$code($session_nik, $session_company, $session_dept, $session_kpi=NULL, $action, $field, $periode);
        $navi .= '</div>';

        $no++;

      }

      return $navi;


    }

    public function user_kpi_attitude_data($session_nik,$periode){

      $tampil = mysql_query("SELECT * FROM tbl_kpi_attitude WHERE attitude_status=1");
      $total  = mysql_num_rows($query);


      $no=1;
      $form ='';
      while($data = mysql_fetch_array($tampil)){

        $radio_name = 'radio_group_'.$no;
        $radio_id   = 'radio_'.$no;

        $form .= '<tr>
          <td><div align="center">'.$no.'</div></td>
          <td><div align="center">'.$data['attitude_factor'].'</div></td>
          <td><div align="center">'.$data['attitude_definition'].'</div></td>
          <td><div align="center"><input type="radio" name="'.$radio_name.'" id="10_'.$radio_id.'" value="10" onclick="UpdateCostAttitude()"/><label for="10_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
          <td><div align="center"><input type="radio" name="'.$radio_name.'" id="9_'.$radio_id.'" value="9" onclick="UpdateCostAttitude()"/><label for="9_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
          <td><div align="center"><input type="radio" name="'.$radio_name.'" id="8_'.$radio_id.'" value="8" onclick="UpdateCostAttitude()"/><label for="8_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
          <td><div align="center"><input type="radio" name="'.$radio_name.'" id="7_'.$radio_id.'" value="7" onclick="UpdateCostAttitude()"/><label for="7_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
          <td><div align="center"><input type="radio" name="'.$radio_name.'" id="6_'.$radio_id.'" value="6" onclick="UpdateCostAttitude()"/><label for="6_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
          <td><div align="center"><input type="radio" name="'.$radio_name.'" id="5_'.$radio_id.'" value="5" onclick="UpdateCostAttitude()"/><label for="5_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
          <td><div align="center"><input type="radio" name="'.$radio_name.'" id="4_'.$radio_id.'" value="4" onclick="UpdateCostAttitude()"/><label for="4_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
          <td><div align="center"><input type="radio" name="'.$radio_name.'" id="3_'.$radio_id.'" value="3" onclick="UpdateCostAttitude()"/><label for="3_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
          <td><div align="center"><input type="radio" name="'.$radio_name.'" id="2_'.$radio_id.'" value="2" onclick="UpdateCostAttitude()"/><label for="2_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
          <td><div align="center"><input type="radio" name="'.$radio_name.'" id="1_'.$radio_id.'" value="1" onclick="UpdateCostAttitude()"/><label for="1_'.$radio_id.'"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
          
        </tr>';

        $no++;


      }

     

      return $form;

    }


    public function current_list_kpi($session_nik, $session_company, $session_dept, $session_kpi, $action, $periode){


       $list = '<div class="table-responsive">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Periode</th>
                          <th>NIK</th>
                          <th>Nama</th>                          
                          <th colspan="2"><div align="center">Score</div></th>
                          <th>Updated Time</th>
                          <th>Revision</th>                         
                          <th width="10%"><div align="center">Action</div></th>
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                          <td>2015</td>
                          <td>'.$session_nik.'</td>                         
                          <td>'.$this->detail_form_model->nama_user($session_nik).'</td>                          
                          <td><div align="right">8.3</div></td>
                          <td>Baik</td>
                          <td><div align="left">10/12/2016 10:00</div></td>
                          <td>10</td>
                          <td>
                          <div align="center">                          
                          <a title="Read" href="{{ base_url }}development/frmKeyPerformanceIndicator/index/?act=read&periode=2016"><span style="font-size:1.0em;" class="glyphicon glyphicon-search"></span></a>&nbsp;&nbsp;                         
                          <a title="Edit" href="{{ base_url }}development/frmKeyPerformanceIndicator/index/?act=edit&periode=2016"><span style="font-size:1.0em;" class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
                          <a title="Add" href="{{ base_url }}development/frmKeyPerformanceIndicator/index/?act=add"><span style="font-size:1.0em;" class="glyphicon glyphicon-plus"></span></a>&nbsp;&nbsp;
                          <a title="Delete" href="{{ base_url }}development/frmKeyPerformanceIndicator/index/?act=delete&period=10"><span style="font-size:1.0em;" class="glyphicon glyphicon-minus-sign"></span></a>
                          </div>
                          </td>
              </tr>                             
                        

          </tbody></table>
          </div>
          ';

          return $list;

    }


    public function kpi_weight($session_kpi){

      $query  = mysql_query('SELECT * FROM tbl_kpi_type WHERE kpi_type_id='.$session_kpi);
      $total  = mysql_num_rows($query);
      $data   = mysql_fetch_array($query);

      return $data['kpi_type_weight'];   

    }

    public function kpi_type_title($session_kpi){

      $query  = mysql_query('SELECT * FROM tbl_kpi_type WHERE kpi_type_id='.$session_kpi);
      $total  = mysql_num_rows($query);
      $data   = mysql_fetch_array($query);

      return $data['kpi_type_title'].' ( Bobot : '.$data['kpi_type_weight'].'% )';   

    }

    public function kpi_total_data($session_kpi){

      $query  = mysql_query('SELECT * FROM tbl_kpi_type WHERE kpi_type_id='.$session_kpi);
      $data   = mysql_fetch_array($query);

      $sql = mysql_query("SELECT * FROM tbl_kpi_".$data['kpi_type_code']);

      $total  = mysql_num_rows($sql);

      return $total; 


    }

    public function jumlah_sakit_tanpa_surat_dokter($session_nik,$periode){

      $token = mysql_escape_string($periode);

      $query  = mysql_query("SELECT count(TglActive1) AS Jumlah FROM `tbl_formijin` WHERE JenisIjin=3 AND StatusForm='A' AND YEAR(TglActive1) ='".$token."' AND NIK='".$session_nik."' GROUP BY YEAR(TglActive1)");
      $data   = mysql_fetch_array($query);
      $total  = mysql_num_rows($query);

      if ($total > 0){
        return $data['Jumlah'];
      }else{
        return 0;
      }

    }

    public function jumlah_tidak_hadir_tanpa_alasan($session_nik,$periode){
      $token = mysql_escape_string($periode);
      $query  = mysql_query("SELECT count(TglActive1) AS Jumlah FROM `tbl_formijin` WHERE JenisIjin=3 AND StatusForm='A' AND YEAR(TglActive1)='".$token."' AND NIK='".$session_nik."' GROUP BY YEAR(TglActive1)");
      $data   = mysql_fetch_array($query);
      $total  = mysql_num_rows($query);

      if ($total > 0){
        return 100;
      }else{
        return 100;
      }

    }

    public function jumlah_datang_terlambat($session_nik, $periode){
      $token = mysql_escape_string($periode);
      $query  = mysql_query("SELECT count(TglActive1) AS Jumlah FROM `tbl_formijin` WHERE JenisIjin='3' AND StatusForm='A' AND YEAR(TglActive1) = '".$token."' AND NIK='".$session_nik."' GROUP BY YEAR(TglActive1)");
      $data   = mysql_fetch_array($query);
      $total  = mysql_num_rows($query);

      if ($total > 0){
        return 100;
      }else{
        return 100;
      }

    }


    public function nilai_datang_terlambat($session_nik,$periode){

      $value = $this->jumlah_datang_terlambat($session_nik,$periode);

      if($value < 260){
          $nilai = 10;
      }
      elseif($value >= 261 && $value <= 530){
          $nilai = 9;
      }
      elseif($value >= 531 && $value <= 791){
          $nilai = 8;
      }
      elseif($value >= 792 && $value <= 1050){
          $nilai = 7;
      }
      elseif($value >= 1051 && $value <= 1320){
          $nilai = 6;
      }
      elseif($value >= 1321 && $value <= 1580){
          $nilai = 5;
      }
      elseif($value >= 1581 && $value <= 1840){
          $nilai = 4;
      }
      elseif($value >= 1841 && $value <= 2110){
          $nilai = 3;
      }
      elseif($value >= 2111 && $value <= 2370){
          $nilai = 2;
      }
      elseif($value >2371){
          $nilai = 1;
      }
      else{
          $nilai = 0;
      }

      return $nilai;


    }


    public function nilai_sakit_tanpa_surat_dokter($session_nik,$periode){
      
      $value = $this->jumlah_sakit_tanpa_surat_dokter($session_nik,$periode);

      if($value ==0){
          $nilai = 10;
      }
      elseif($value == 1){
          $nilai = 9;
      }
      elseif($value == 2){
          $nilai = 8;
      }
      elseif($value == 3){
          $nilai = 7;
      }
      elseif($value == 4){
          $nilai = 6;
      }
      elseif($value == 5){
          $nilai = 5;
      }
      elseif($value == 6){
          $nilai = 4;
      }
      elseif($value == 7){
          $nilai = 3;
      }
      elseif($value == 8){
          $nilai = 2;
      }
      elseif($value > 9){
          $nilai = 1;
      }
      else{
          $nilai = 0;
      }

      return $nilai;


    }

    public function nilai_tidak_hadir_tanpa_alasan($session_nik,$periode){
      
      $value = $this->jumlah_tidak_hadir_tanpa_alasan($session_nik,$periode);

      if($value ==0){
          $nilai = 9;
      }
      elseif($value == 1){
          $nilai = 8;
      }
      elseif($value == 2){
          $nilai = 7;
      }
      elseif($value == 3){
          $nilai = 6;
      }
      elseif($value == 4){
          $nilai = 5;
      }
      elseif($value == 5){
          $nilai = 4;
      }
      elseif($value == 6){
          $nilai = 3;
      }
      elseif($value == 7){
          $nilai = 2;
      }
      elseif($value > 8){
          $nilai = 1;
      }
      else{
          $nilai = 0;
      }

      return $nilai;


    }

    public function nilai_rata_rata_time($session_nik,$periode){

      $val1 = $this->nilai_datang_terlambat($session_nik,$periode);
      $val2 = $this->nilai_sakit_tanpa_surat_dokter($session_nik,$periode);
      $val3 = $this->nilai_tidak_hadir_tanpa_alasan($session_nik,$periode);

      $total = (($val1 + $val2 + $val3) / 3);

      return number_format($total,2);


    }

    public function calculate_rata_rata_time($session_nik,$periode){

      $val1 = $this->nilai_datang_terlambat($session_nik,$periode);
      $val2 = $this->nilai_sakit_tanpa_surat_dokter($session_nik,$periode);
      $val3 = $this->nilai_tidak_hadir_tanpa_alasan($session_nik,$periode);

      $total = (($val1 + $val2 + $val3) * $this->kpi_weight($session_kpi=3)/100);

      return number_format($total,2);


    }

    public function status_radio_jumlah_datang_terlambat($session_nik, $periode, $value){

        $val = $this->nilai_datang_terlambat($session_nik,$periode);

        if ($val==$value){
          $status = 'checked';

        }else{
          $status = '';
        }

        return $status;
    }


    public function status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value){

        $val = $this->nilai_sakit_tanpa_surat_dokter($session_nik,$periode);

        if ($val==$value){
          $status = 'checked';

        }else{
          $status = '';
        }

        return $status;
    }

    public function status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value){

        $val = $this->nilai_tidak_hadir_tanpa_alasan($session_nik,$periode);

        if ($val==$value){
          $status = 'checked';

        }else{
          $status = '';
        }

        return $status;


    }


    public function current_value_performace($session_nik, $periode){
        $token = mysql_escape_string($periode);
        $query  = mysql_query("SELECT sum(performance_value) AS total FROM tbl_kpi_performance WHERE performance_periode='".$token."' AND performance_nik='".$session_nik."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);        

        if (is_null($data['total'])){
            return 0;
        }
        else{
            return $data['total'];
        }


    }

    public function current_value_attitude($session_nik, $periode){
        $token  = mysql_escape_string($periode);
        $query  = mysql_query("SELECT sum(attitude_value) AS total FROM tbl_kpi_attitude WHERE attitude_periode='".$token."' AND attitude_nik='".$session_nik."'");
        $total  = mysql_num_rows($query);
        $data   = mysql_fetch_array($query);        

        if (is_null($data['total'])){
            return 0;
        }
        else{
            return $data['total'];
        }


    }
    

    




}

?>