<?php
    $record_index = 0;
    $this->load->model('development_model');
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    #md_table_time input[type="text"]{
        max-width:100px;
    }
    #md_table_time .chzn-drop input[type="text"]{
        max-width:240px;
    }
    #md_table_time th:last-child, #md_table_time td:last-child{
        width: 60px;
    }

    .noborder-bottom{
      border-bottom: none !important;
    }
    .noborder-lr{
      border-right: none !important;
      border-left: none !important;
    }
    .noborder-r{
      border-right: none !important;
    }
    .noborder-l{
      border-left: none !important;;
    }


</style>
<?php

$tm = '<div id="md_table_time_container">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>
            <td>
                <table class="table table-striped table-bordered table-hover" style="font-size:12px;" width="100%">
                <thead>

                <tr>            
                <th colspan="6">
                    <h4>D. PENILAIAN KEDISIPLINAN WAKTU - data dari HRD (Bobot : 10  %)</h4>
                </th>
                <th colspan="10">
                    <h4><span class="label label-default" id="total_time">Score : 0.00</span></h4>
                </th>            
            </tr>

                    <tr>
                      <th width="1%" rowspan="3" valign="middle"><div align="center">No</div></th>
                      <th rowspan="3" valign="middle"><div align="center">Faktor</div></th>
                      <th colspan="4" rowspan="3" valign="middle"><div align="center">Keterangan</div></th>
                      <th colspan="10"><div align="center">Kategori Penilaian</div></th>
                    </tr>
                    <tr>
                      <th colspan="3" bgcolor="#00FF00"><div align="center">Baik</div></th>
                      <th colspan="3" bgcolor="#FFFF00"><div align="center">Cukup</div></th>
                      <th colspan="4" bgcolor="#FF9900"><div align="center">Kurang</div></th>
                    </tr>
                    <tr>
                      <th width="6%" bgcolor="#00FF00"><div align="center">10</div></th>
                      <th width="6%" bgcolor="#00FF00"><div align="center">9</div></th>
                      <th width="6%" bgcolor="#00FF00"><div align="center">8</div></th>
                      <th width="6%" bgcolor="#FFFF00"><div align="center">7</div></th>
                      <th width="6%" bgcolor="#FFFF00"><div align="center">6</div></th>
                      <th width="6%" bgcolor="#FFFF00"><div align="center">5</div></th>
                      <th width="6%" bgcolor="#FF9900"><div align="center">4</div></th>
                      <th width="6%" bgcolor="#FF9900"><div align="center">3</div></th>
                      <th width="6%" bgcolor="#FF9900"><div align="center">2</div></th>
                      <th width="6%" bgcolor="#FF9900"><div align="center">1</div></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                      <td rowspan="2"><div align="center">1</div></td>
                      <td rowspan="2">Datang terlambat</td>
                      <td rowspan="2" class="noborder-r">Jumlah dalam 1 tahun</td>
                      <td rowspan="2" class="noborder-lr">:</td>
                      <td rowspan="2" class="noborder-lr"><input type="text" name="datang_terlambat" id="datang_terlambat" value="'.$this->development_model->jumlah_datang_terlambat($session_nik,$periode).'" class="form-control" readonly/><div id="total_datang_terlambat"></div></td>
                      <td rowspan="2" class="noborder-l">menit</td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="10_time_1" value="10" '.$this->development_model->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=10).' onclick="UpdateCostTime()" disabled /><label for="10_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="9_time_1" value="9" '.$this->development_model->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=9).' onclick="UpdateCostTime()" disabled /><label for="9_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="8_time_1" value="8" '.$this->development_model->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=8).' onclick="UpdateCostTime()" disabled /><label for="8_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="7_time_1" value="7" '.$this->development_model->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=7).' onclick="UpdateCostTime()" disabled /><label for="7_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="6_time_1" value="6" '.$this->development_model->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=6).' onclick="UpdateCostTime()" disabled /><label for="6_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="5_time_1" value="5" '.$this->development_model->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=5).' onclick="UpdateCostTime()" disabled /><label for="5_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="4_time_1" value="6" '.$this->development_model->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=4).' onclick="UpdateCostTime()" disabled /><label for="4_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="3_time_1" value="3" '.$this->development_model->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=3).' onclick="UpdateCostTime()" disabled /><label for="3_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="2_time_1" value="2" '.$this->development_model->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=2).' onclick="UpdateCostTime()" disabled /><label for="2_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_1" id="1_time_1" value="1" '.$this->development_model->status_radio_jumlah_datang_terlambat($session_nik, $periode, $value=1).' onclick="UpdateCostTime()" disabled /><label for="1_time_1"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
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
                      <td rowspan="2" class="noborder-lr"><input type="text" name="tanpa_surat_dokter" id="tanpa_surat_dokter" value="'.$this->development_model->jumlah_sakit_tanpa_surat_dokter($session_nik, $periode).'" class="form-control" readonly/><div id="total_sakit_tanpa_surat_dokter"></div></td>
                      <td rowspan="2" class="noborder-l">hari</td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="10_time_2" value="10" '.$this->development_model->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=10).' onclick="UpdateCostTime()" disabled /><label for="10_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="9_time_2" value="9" '.$this->development_model->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=9).' onclick="UpdateCostTime()" disabled /><label for="9_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="8_time_2" value="8" '.$this->development_model->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=8).' onclick="UpdateCostTime()" disabled /><label for="8_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="7_time_2" value="7" '.$this->development_model->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=7).' onclick="UpdateCostTime()" disabled /><label for="7_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="6_time_2" value="6" '.$this->development_model->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=6).' onclick="UpdateCostTime()" disabled /><label for="6_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="5_time_2" value="5" '.$this->development_model->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=5).' onclick="UpdateCostTime()" disabled /><label for="5_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="4_time_2" value="4" '.$this->development_model->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=4).' onclick="UpdateCostTime()" disabled /><label for="4_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="3_time_2" value="3" '.$this->development_model->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=3).' onclick="UpdateCostTime()" disabled /><label for="3_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="2_time_2" value="2" '.$this->development_model->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=2).' onclick="UpdateCostTime()" disabled /><label for="2_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_2" id="1_time_2" value="1" '.$this->development_model->status_radio_sakit_tanpa_surat_dokter($session_nik, $periode, $value=1).' onclick="UpdateCostTime()" disabled /><label for="1_time_2"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
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
                      <td rowspan="2" class="noborder-lr"><input type="text" name="tidak_hadir" id="tidak_hadir" value="'.$this->development_model->jumlah_tidak_hadir_tanpa_alasan($session_nik,$periode).'" class="form-control" readonly/><div id="total_tidak_hadir"></div></td>
                      <td rowspan="2" class="noborder-l">hari</td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="10_time_3" value="10" onclick="UpdateCostTime()" disabled /><label for="10_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="9_time_3" value="9" '.$this->development_model->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=9).' onclick="UpdateCostTime()" disabled /><label for="9_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="8_time_3" value="8" '.$this->development_model->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=8).' onclick="UpdateCostTime()" disabled /><label for="8_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="7_time_3" value="7" '.$this->development_model->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=7).' onclick="UpdateCostTime()" disabled /><label for="7_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="6_time_3" value="6" '.$this->development_model->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=6).' onclick="UpdateCostTime()" disabled /><label for="6_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="5_time_3" value="5" '.$this->development_model->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=5).' onclick="UpdateCostTime()" disabled /><label for="5_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="4_time_3" value="4" '.$this->development_model->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=4).' onclick="UpdateCostTime()" disabled /><label for="4_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="3_time_3" value="3" '.$this->development_model->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=3).' onclick="UpdateCostTime()" disabled /><label for="3_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="2_time_3" value="2" '.$this->development_model->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=2).' onclick="UpdateCostTime()" disabled /><label for="2_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
                      <td class="noborder-bottom"><div align="center"><input type="radio" name="time_3" id="1_time_3" value="1" '.$this->development_model->status_radio_tidak_hadir_tanpa_alasan($session_nik, $periode, $value=1).' onclick="UpdateCostTime()" disabled /><label for="1_time_3"><span class="fa-stack"><i class="fa fa-circle-o fa-stack-1x"></i><i class="fa fa-circle fa-stack-1x"></i></span></label></div></td>
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
                      <td class="noborder-lr"><div align="center" id="total_rata_rata_time">'.$this->development_model->nilai_rata_rata_time($session_nik,$periode).'</div></td>
                      <td colspan="3" class="noborder-lr"><div align="center">% x (nilai rata-rata) =</div></td>
                      <td class="noborder-lr"><div id="total_time_result_temp">'.$this->development_model->calculate_rata_rata_time($session_nik,$periode).'</div></td>
                      <td class="noborder-lr">&nbsp;</td>
                      <td class="noborder-lr">&nbsp;</td>
                      <td class="noborder-lr">&nbsp;</td>
                      <td class="noborder-lr">&nbsp;</td>
                      <td class="noborder-lr">&nbsp;</td>
                    </tr>
                </tbody>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <table class="table table-striped table-bordered table-hover" style="font-size:12px;" width="100%">
                <thead>
                    <tr>
                      <th colspan="14"><strong>HASIL PENILAIAN</strong></th>
                    </tr>
                </thead>
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
                      <td width="6%" class="noborder-l"><div align="center" id="total_time_result" class="total">'.$this->development_model->calculate_rata_rata_time($session_nik,$periode).'</div></td>
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
                <table class="table table-striped table-bordered table-hover" width="100%">
                <thead>    
                    <tr>
                      <th colspan="2"><div align="center"><strong>ASPEK KELEBIHAN-KELEMAHAN KARYAWAN &amp; SARAN</strong></div></th>
                    </tr>
                </thead>
                '.$this->development_model->review_form($primary_key).'
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>  
        </tr>
        <tr>
            <td height="173">
                <table class="table table-striped table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                      <th colspan="2"><div align="center"><strong>KOMENTAR PENILAI</strong></div></th>
                    </tr>
                </thead>
                    <tr>
                      <td colspan="2">
                        <textarea style="width: 100%; height: 100%; border: none; font-style:italic;" placeholder="Silahkan diisi..." class="form-control" name="evaluator_note" readonly>'.$this->development_model->evaluator_result($primary_key).'</textarea>
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
                <table class="table table-striped table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                      <th colspan="2"><div align="center"><strong>KOMENTAR PEMEGANG JABATAN</strong></div></th>
                    </tr>
                </thead>
                    <tr>
                      <td colspan="2">
                        <textarea style="width: 100%; height: 100%; border: none; font-style:italic;" placeholder="Silahkan diisi..." class="form-control" name="incumbent_note" readonly>'.$this->development_model->incumbent_result($primary_key).'</textarea>
                      </td>
                      </tr>
                    <tr>
                      <td width="50%" height="45">Nama &amp; tanda tangan :</td>
                      <td width="50%">Tanggal :</td>
                    </tr>
                </table>
            </td>
        </tr>
        
    </table>';

echo $tm;

?>

    
    <!-- This is the real input. If you want to catch the data, please json_decode this input's value -->
    <!--<input id="md_real_field_time_col" name="md_real_field_time_col" type="hidden" />-->
</div>

<script type="text/javascript">

function UpdateCostTime() {
    var sum10 = 0;
    var sum9 = 0;
    var sum8 = 0;
    var sum7 = 0;
    var sum6 = 0;
    var sum5 = 0;
    var sum4 = 0;
    var sum3 = 0;
    var sum2 = 0;
    var sum1 = 0;

    var bobot = <?php echo $this->development_model->kpi_weight($session_kpi=3);?>;
    var max_data = 3;

    var subtotal;
    var total_time;
    var grand_total;


    var gn, elem;
    for (i=1; i <= max_data; ++i) {
        gn = '10_time_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum10 += Number(elem.value)* bobot/100; }

        gn = '9_time_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum9 += Number(elem.value)* bobot/100; }

        gn = '8_time_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum8 += Number(elem.value)* bobot/100; }

        gn = '7_time_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum7 += Number(elem.value)* bobot/100; }

        gn = '6_time_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum6 += Number(elem.value)* bobot/100; }

        gn = '5_time_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum5 += Number(elem.value)* bobot/100; }

        gn = '4_time_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum4 += Number(elem.value)* bobot/100; }

        gn = '3_time_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum3 += Number(elem.value)* bobot/100; }

        gn = '2_time_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum2 += Number(elem.value)* bobot/100; }

        gn = '1_time_'+(i);
        elem = document.getElementById(gn);  // alert(elem.id);
        if (elem.checked == true) { sum1 += Number(elem.value)* bobot/100; }


    }

    subtotal = (sum10+sum9+sum8+sum7+sum6+sum5+sum4+sum3+sum2+sum1) / max_data;
    total_time = subtotal.toFixed(2);

        if ( total_time >= 0.80 ){
            document.getElementById("total_time").className = "label label-success";
            var status = 'Baik';
        }
        else if (total_time < 0.80 && total_time >= 0.50){
            document.getElementById("total_time").className = "label label-info";
            var status = 'Cukup';
        }
        else {
            document.getElementById("total_time").className = "label label-warning";
            var status = 'Kurang';
        }

        document.getElementById('total_time').value = total_time;
        document.getElementById('total_time').innerHTML = 'Score : '+total_time+' ('+status+')'; //NOW WORKS
        

 
   
    document.getElementById('total_time_result_temp').innerHTML = total_time;

    var pembagi = (total_time * bobot);
    pembagi = pembagi.toFixed(2);



    document.getElementById('total_rata_rata_time').innerHTML = pembagi;

    document.getElementById('total_time_result').value = total_time;
    document.getElementById('total_time_result').innerHTML = total_time;

    var sum_total_attitude = Number(document.getElementById('total_attitude').value);
    var sum_total_performance = Number(document.getElementById('total_performance').value);
    var sum_total_time = Number(document.getElementById('total_time_result').value);

    var grand_total_kpi = (sum_total_attitude+sum_total_performance+sum_total_time);
    var grand_total = grand_total_kpi.toFixed(2);
    var grand_total_bulat = grand_total_kpi.toFixed(0);
    document.getElementById('grand_total_kpi_result').innerHTML = grand_total;

    if (grand_total_bulat >=8.00){
        document.getElementById('pointA').innerHTML = '<span class="glyphicon glyphicon-ok"></span>';
        document.getElementById('pointB').innerHTML = '';
        document.getElementById('pointC').innerHTML = '';
    }
    else if(grand_total_bulat < 8.00 && grand_total_bulat >=5.00){
        document.getElementById('pointA').innerHTML = '';
        document.getElementById('pointB').innerHTML = '<span class="glyphicon glyphicon-ok"></span>';
        document.getElementById('pointC').innerHTML = '';
    }
    else if(grand_total_bulat <=4){
        document.getElementById('pointA').innerHTML = '';
        document.getElementById('pointB').innerHTML = '';
        document.getElementById('pointC').innerHTML = '<span class="glyphicon glyphicon-ok"></span>';
    }

    else{
       
    }



    if ( grand_total >= 8.00 ){
        document.getElementById("head_total_score").className = "label label-success";
        var status_head = 'Baik';
    }
    else if (grand_total < 8.00 && grand_total >=5.00){
        document.getElementById("head_total_score").className = "label label-info";
        var status_head = 'Cukup';
    }
    else {
        document.getElementById("head_total_score").className = "label label-warning";
        var status_head = 'Kurang';
    }    


    document.getElementById('head_total_score').innerHTML = 'TOTAL NILAI : '+grand_total+' ('+status_head+')';

    var grand_total_abs = grand_total_kpi.toFixed(0);

    for (tdi=1; tdi <= 10; ++tdi){

        if (grand_total_abs == tdi){
            document.getElementById('total_color_'+tdi).style.backgroundColor="#FFFF99";
            document.getElementById('total_color_'+tdi).className = "numberCircle";
        }else{
            document.getElementById('total_color_'+tdi).style.backgroundColor="";
            document.getElementById('total_color_'+tdi).className = "";
        }
    }




}

</script>


<script type="text/javascript">

$(document).ready(function(){  

  document.getElementById('total_sakit_tanpa_surat_dokter').value = <?php echo $this->development_model->jumlah_sakit_tanpa_surat_dokter($session_nik, $periode); ?>;
  document.getElementById('total_datang_terlambat').value = <?php echo $this->development_model->jumlah_datang_terlambat($session_nik, $periode); ?>;
  document.getElementById('total_tidak_hadir').value = <?php echo $this->development_model->jumlah_tidak_hadir_tanpa_alasan($session_nik, $periode); ?>; 

  document.getElementById('total_time').value = <?php echo $this->development_model->calculate_rata_rata_time($session_nik,$periode); ?>;

  subtotal = <?php echo $this->development_model->calculate_rata_rata_time($session_nik,$periode); ?>;
  total_time = subtotal.toFixed(2);

        if ( total_time >= 0.80 ){
            document.getElementById("total_time").className = "label label-success";
            var status = 'Baik';
        }
        else if (total_time < 0.80 && total_time >= 0.50){
            document.getElementById("total_time").className = "label label-info";
            var status = 'Cukup';
        }
        else {
            document.getElementById("total_time").className = "label label-warning";
            var status = 'Kurang';
        }

        document.getElementById('total_time').value = total_time;
        document.getElementById('total_time').innerHTML = 'Score : '+total_time+' ('+status+')'; //NOW WORKS


})

</script>