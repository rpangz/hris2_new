<style>
.container {
  width: 100%;
}
.action-tools{
  	color:#333333 !important;
   	text-decoration: none; 
   	background-color: none;
}
</style>
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

$tahun_ini = date('Y');
$batas = $tahun_ini-0;

$crud = new summary();

// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}
//echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);
?>

<div id="content">
<H4>SUMMARY SCORE &amp; BOBOT PENCAPAIAN PA-KPI </H4>
<table width="100%" class="table table-bordered table-hover table-striped" border="0" cellspacing="1" cellpadding="0" style="font-size: 12px">
  <tr>
    <th width="3%" rowspan="2" class="text-center">No</th>
    <th width="5%" rowspan="2" class="text-center">NIK</th>
    <th rowspan="2" class="text-center">Nama</th>
    <th width="5%" rowspan="2" class="text-center">Periode</th>
    <th width="20%" rowspan="2" class="text-center">Title</th>
    <th width="15%" rowspan="2" class="text-center">Divisi</th>
    <th width="15%" rowspan="2" class="text-center">Departemen</th>
<?php
    for($i = $batas; $i <= $tahun_ini; ++$i) { ?>
    	<th colspan="2" class="text-center">Pencapaian Kinerja <?php echo $i;?></th>
<?php } ?>
    <th width="10%" rowspan="2" class="text-center">Coaching &amp; Counseling</th>
  </tr>
  <tr>

  <?php
    for($i = $batas; $i <= $tahun_ini; ++$i) { ?>
    	<th width="5%" class="text-center">Score</th>
    	<th width="5%" class="text-center">Bobot (x-bar)</th>

<?php } ?>

    
  </tr>

<?php $no=1; foreach ($result as $key => $data) { ?>

	<tr>
	    <td class="text-center"><?php echo $no;?></td>
	    <td class="text-center"><?php echo $data->EmployeeID;?></td>
	    <td class="text-center"><?php echo $data->Nama;?></td>
	    <td class="text-center"><?php echo $data->PeriodID;?></td>
	    <td class="text-center"><?php echo $data->cTitle;?></td>
	    <td class="text-center"><?php echo $data->cDivName;?></td>
	    <td class="text-center"><?php echo $data->cDeptName;?></td>

	    <?php
for($i = $batas; $i <= $tahun_ini; ++$i) { ?>
    	<td class="text-center"><?php echo $data->total_score;?></td>
	    <td class="text-center"><a href="javascript:void(0);" onclick="detail_summary('<?php echo $data->KPIID;?>')" title="Detail" class="link action-tools"><?php echo $crud->final_bobot_user($data->KPIID);?>%</a></td>
<?php } ?>
		
		<td class="text-center">
		<?php if (($data->x_bar_A < 50 || $data->x_bar_B < 50 || $data->x_bar_B < 50) && $data->iCounseling==0){ ?>
		<!--<i class="glyphicon glyphicon-remove"></i>-->
		<a class="button link" onclick="add_form_counseling('<?php echo $data->KPIID;?>')" href="javascript:void(0);" id="btn_counseling">Butuh counseling anda!</a>
		<?php } elseif($data->iCounseling==1) { ?>
		
		
		<a class="button-read link" onclick="read_form_counseling('<?php echo $data->KPIID;?>')" href="javascript:void(0);" id="btn_counseling">Lihat data counseling?</a>

		<?php } else { ?>
			<i class="glyphicon glyphicon-ok"></i>
		<?php } ?>
		</td>
	    
  	</tr>
<?php $no++; } ?>
  
  
  
</table>

</div>


<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">SCORE PENCAPAIAN PA-KPI</h3>
            </div>
            <div class="modal-body form">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="25%">Nama</td>
					    <td width="2%">:</td>
					    <td id="nama"></td>
					  </tr>
					  <tr>
					    <td>Divisi</td>
					    <td>:</td>
					    <td id="divisi"></td>
					  </tr>
					  <tr>
					    <td>Dept</td>
					    <td>:</td>
					    <td id="dept"></td>
					  </tr>
					  <tr>
					    <td>Jabatan / Grade</td>
					    <td>:</td>
					    <td id="jabatan"></td>
					  </tr>
					  <tr>
					    <td>Periode</td>
					    <td>:</td>
					    <td id="periode"></td>
					  </tr>
					</table>

					<table width="100%" class="table table-bordered" border="0" cellspacing="0" cellpadding="0" align="center">  
  
					  <tr style="background-color: #000000; color: #FFFFFF; font-weight: bold;">
					    <td height="44" colspan="2"><div align="center">KPI</div></td>
					    <td colspan="2"><div align="center">PROCESS / COMPETENCY</div></td>
					    <td colspan="2" class="manage-people"><div align="center">MANAGING<br />
					    PEOPLE</div></td>
					  </tr>
					  <tr>
					    <td height="39" width="16.6%" class="text-center" id="total_score_A"></td>
					    <td width="16.6%" class="text-center" id="x_bar_A"></td>
					    <td width="16.6%" class="text-center" id="total_score_B"></td>
					    <td width="16.6%" class="text-center" id="x_bar_B"></td>
					    <td width="16.6%" class="text-center manage-people" id="total_score_C"></td>
					    <td width="16.6%" class="text-center manage-people" id="x_bar_C"></td>
					  </tr>
					  <tr>
					    <td colspan="6">Total Score :</td>
					  </tr>
					  <tr>
					    <td height="33" colspan="6"><div align="center" id="total_score" style="font-size: 16px !important;font-weight: bold;"></div></td>
					  </tr>
					  <tr>
					    <td height="30" colspan="6"><div align="center" id="nilai_akhir" style="font-size: 16px !important;font-weight: bold;"></div></td>
					  </tr>
					</table>

                
            </div>
            <div class="modal-footer">
                                
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form_counseling" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Coaching &amp; Counseling</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal" style="font-size: 12px">
                <input type="hidden" value="" name="CounselingKPIID"/>
                    <table class="table" width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
					  <tr>
					    <td>
					    <table width="100%" border="0" cellspacing="0" cellpadding="0">
					      <tr>
					        <th rowspan="4" style="font-size: 24px; font-weight: bold" id="company"></th>
					        <th colspan="6" class="text-center">FORM COACHING &amp; COUNSELING</th>
					        </tr>
					      <tr>
					        <td width="10%">Nama Karyawan</td>
					        <td width="2%">:</td>
					        <td width="25%" id="nama">&nbsp;</td>
					        <td width="10%">Jabatan</td>
					        <td width="2%">:</td>
					        <td width="25%" id="jabatan">&nbsp;</td>
					      </tr>
					      <tr>
					        <td>Grade</td>
					        <td>:</td>
					        <td id="grade">&nbsp;</td>
					        <td>Department</td>
					        <td>:</td>
					        <td id="dept">&nbsp;</td>
					      </tr>
					      <tr>
					        <td>Periode</td>
					        <td>:</td>
					        <td id="periode">&nbsp;</td>
					        <td>Divisi</td>
					        <td>:</td>
					        <td id="divisi">&nbsp;</td>
					      </tr>
					    </table>
					    </td>
					  </tr>
					  
					  <tr>
					  	<td>
					    	I. FEEDBACK (Diisi pada awal periode Coaching &amp; Counseling)
					    </td>
					  </tr>
					  
					  <tr>
					    <td>
					      <table width="100%" border="0" cellspacing="2" cellpadding="0" class="table">
					        <tr>
					          <td colspan="10" style="background-color: #CCCCCC; height: 25px; border:1px solid #000000">1.1 Feed back Performance (Mengacu kepada AP/IPP)</td>
					        </tr>
					        <tr style="border:1px solid gray">
					          <td colspan="10">a. Hal-hal positif yang telah dicapai</td>
					        </tr>
					        <tr>
					          <td height="72" colspan="10">
					          <textarea style="width: 100%" class="form-control" name="hal_positif"></textarea>
					          </td>
					        </tr>
					        <tr style="border:1px solid gray">
					          <td colspan="10">b. Hal-hal yang masih perlu ditingkatkan</td>
					        </tr>
					        <tr>
					          <td height="74" colspan="10">
					          	<textarea style="width: 100%" class="form-control" name="hal_perlu_ditingkatkan"></textarea>
					          </td>
					        </tr>
					        <tr>
					          <td colspan="10" style="background-color: #CCCCCC; height: 25px; border:1px solid #000000">1.2 Hambatan/ Challenge dalam Pekerjaan</td>
					        </tr>
					        <tr>
					          <td height="65" colspan="10">
					          	<textarea style="width: 100%" class="form-control" name="tantangan_dalam_pekerjaan"></textarea>
					          </td>
					        </tr>
					        <tr>
					          <td colspan="10" style="background-color: #CCCCCC; height: 25px; border:1px solid #000000">1.3 Aspirasi Karir (Harapan Mentee Terkait Karir, Passion/ MInat, dsb)</td>
					        </tr>
					        <tr>
					          <td height="54" colspan="10">
					          	<textarea style="width: 100%" class="form-control" name="aspirasi_karir"></textarea>
					          </td>
					        </tr>
					        <tr>
					          <td colspan="10" style="background-color: #CCCCCC; height: 25px; border:1px solid #000000">1.4 Feedback Kompetensi yang perlu ditingkatkan (Berikan tabda v pada kompetensi dibawah rata-rata atau 3 terbawah)</td>
					        </tr>
					        <tr style="border:1px solid gray">
					          <td colspan="6"><div align="center">Process &amp; Values</div></td>
					          <td colspan="4"><div align="center">People Management</div></td>
					        </tr>
					        <tr>
					          <td width="3%"><input type="checkbox" name="PV1" value="1"></td>
					          <td width="12%">CORE VALUES (I,R,T,C)</td>
					          <td width="3%"><input type="checkbox" name="PV2" value="1"></td>
					          <td width="18%">Planning, Organizing &amp; Decision Making</td>
					          <td width="3%"><input type="checkbox" name="PV5" value="1"></td>
					          <td width="17%">Learning Ability</td>
					          <td width="3%"><input type="checkbox" name="vehicle" value="1"></td>
					          <td width="17%">Commitment on Performance Plan</td>
					          <td width="3%"><input type="checkbox" name="vehicle" value="1"></td>
					          <td width="21%">Developping Subordinate</td>
					        </tr>
					        <tr>
					          <td><input type="checkbox" name="PV3" value="1"></td>
					          <td>Customer Focus</td>
					          <td><input type="checkbox" name="PV4" value="1"></td>
					          <td>Driver for Result</td>
					          <td><input type="checkbox" name="PV8" value="1"></td>
					          <td>Technical /Functional Skill</td>
					          <td><input type="checkbox" name="vehicle" value="1"></td>
					          <td>Delegating</td>
					          <td><input type="checkbox" name="vehicle" value="1"></td>
					          <td>Coaching &amp; Counseling</td>
					        </tr>
					        <tr>
					          <td><input type="checkbox" name="PV6" value="1"></td>
					          <td>Discipline</td>
					          <td><input type="checkbox" name="PV7" value="1"></td>
					          <td>Concern For Order</td>
					          <td>&nbsp;</td>
					          <td>&nbsp;</td>
					          <td><input type="checkbox" name="vehicle" value="1"></td>
					          <td>PDCA</td>
					          <td><input type="checkbox" name="vehicle" value="1"></td>
					          <td>Appreciation</td>
					        </tr>
					        <tr>
					          <td height="87">Note:</td>
					          <td colspan="9">
					          	<textarea style="width: 100%" class="form-control" name="catatan_kompetensi"></textarea>
					          </td>
					        </tr>
					      </table></td>
					  </tr>
					  
					  <tr>
					  	<td>
					    	II. AREA DEVELOPMENT
					    	<table width="100%" border="0" cellspacing="2" cellpadding="0" class="table">
							  <tr style="background-color: #CCCCCC; height: 25px; border:1px solid #000000 !important">
							    <td bgcolor="#CCCCCC">2.1 Special Assigment (Penugasan Kerja Khusus)</td>
							    <td width="15%" bgcolor="#CCCCCC"><div align="center">Periode Assigment</div></td>
							    <td width="15%" bgcolor="#CCCCCC"><div align="center">Target Kompetensi</div></td>
							    <td width="15%" bgcolor="#CCCCCC"><div align="center">Target Aktifitas</div></td>
							    <td width="15%" bgcolor="#CCCCCC"><div align="center">Actual</div></td>
							  </tr>
							  <tr>
							    <td><textarea style="width: 100%" class="form-control" name="Special_Assigment_Remarks"></textarea></td>
							    <td><input name="Periode_Assigment_1" placeholder="" class="form-control" type="text"></td>
							    <td><input name="Target_Kompetensi_1" placeholder="" class="form-control" type="text"></td>
							    <td><input name="Target_Aktifitas_1" placeholder="" class="form-control" type="text"></td>
							    <td><input name="Actual_1" placeholder="" class="form-control" type="text"></td>
							  </tr>
							  <tr style="background-color: #CCCCCC; height: 25px; border:1px solid #000000">
							    <td bgcolor="#CCCCCC">2.2 Self Development</td>
							    <td width="15%" bgcolor="#CCCCCC"><div align="center">Periode Assigment</div></td>
							    <td width="15%" bgcolor="#CCCCCC"><div align="center">Target Kompetensi</div></td>
							    <td width="15%" bgcolor="#CCCCCC"><div align="center">Target Aktifitas</div></td>
							    <td width="15%" bgcolor="#CCCCCC"><div align="center">Actual</div></td>
							  </tr>
							  <tr>
							    <td><textarea style="width: 100%" class="form-control" name="Self_Development_Remarks"></textarea></td>
							    <td><input name="Periode_Assigment_2" placeholder="" class="form-control" type="text"></td>
							    <td><input name="Target_Kompetensi_2" placeholder="" class="form-control" type="text"></td>
							    <td><input name="Target_Aktifitas_2" placeholder="" class="form-control" type="text"></td>
							    <td><input name="Actual_2" placeholder="" class="form-control" type="text"></td>
							  </tr>
							  <tr style="background-color: #CCCCCC; height: 25px; border:1px solid #000000">
							    <td bgcolor="#CCCCCC">2.3 Pengembangan Lainnya</td>
							    <td width="15%" bgcolor="#CCCCCC"><div align="center">Periode Assigment</div></td>
							    <td width="15%" bgcolor="#CCCCCC"><div align="center">Target Kompetensi</div></td>
							    <td width="15%" bgcolor="#CCCCCC"><div align="center">Target Aktifitas</div></td>
							    <td width="15%" bgcolor="#CCCCCC"><div align="center">Actual</div></td>
							  </tr>
							  <tr>
							    <td><textarea style="width: 100%" class="form-control" name="Pengembangan_Lainnya_Remarks"></textarea></td>
							    <td><input name="Periode_Assigment_3" placeholder="" class="form-control" type="text"></td>
							    <td><input name="Target_Kompetensi_3" placeholder="" class="form-control" type="text"></td>
							    <td><input name="Target_Aktifitas_3" placeholder="" class="form-control" type="text"></td>
							    <td><input name="Actual_3" placeholder="" class="form-control" type="text"></td>
							  </tr>
							</table>
					    </td>  
					  </tr>
					  
					  <tr>
					  	<td>
					    	
					    </td>  
					  </tr>
					  
					</table>

                
            </div>
            <div class="modal-footer">
          		<button type="button" class="btn btn-primary" onclick="save_form_counseling()"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>                                
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">

var save_method;
var table;
var primary_key;
var DATE_FORMAT = '<?php echo $date_format ?>';
var base_url = '<?php echo base_url();?>';

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

function detail_summary(id){

	primary_key = id;
        
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('development/summary/detail/')?>/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

        	$('#nama').text(data.EmployeeID+' / '+data.nama);
        	$('#total_score').text(data.total_score);
        	$('#nilai_akhir').text(data.nilai_akhir);
        	$('#divisi').text(data.divisi);
        	$('#dept').text(data.dept);
        	$('#periode').text(data.PeriodID);
        	$('#jabatan').text(data.jabatan+' / '+data.iGrade);

        	$('#total_score_A').text(data.total_score_A);
        	$('#total_score_B').text(data.total_score_B);
        	$('#total_score_C').text(data.total_score_C);

        	$('#x_bar_A').text(data.x_bar_A+'%');
        	$('#x_bar_B').text(data.x_bar_B+'%');
        	$('#x_bar_C').text(data.x_bar_C+'%');

        	if (data.iTypeForm==1){
        		$('.manage-people').hide();
        	}
        	else{
        		$('.manage-people').show();
        	}

        	if ((data.x_bar_A < 50 || data.x_bar_B < 50 || data.x_bar_B < 50) && data.iCounseling == 0){
        		$('#btn_counseling').show();
        	}
        	else{
        		$('#btn_counseling').hide();
        	}

        	$('#modal_form').modal({backdrop: 'static'});
            $('#modal_form').modal('show');
            $("#modal_form").draggable({handle: ".modal-header"});
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}


function add_form_counseling(id){

	//Ajax Load data from ajax
	save_method = 'add';
	$('#form')[0].reset();
	$('textarea').val('');

	$('[name="CounselingKPIID"]').val(id);	
	
    $.ajax({
        url : "<?php echo site_url('development/summary/add_form_counseling/')?>/"+id,
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {
        	
        	$('#modal_form_counseling #nama').text(data.EmployeeID+' / '+data.nama);
        	$('#modal_form_counseling #company').text(data.company);
        	$('#modal_form_counseling #divisi').text(data.divisi);
        	$('#modal_form_counseling #dept').text(data.dept);
        	$('#modal_form_counseling #periode').text(data.PeriodID);
        	$('#modal_form_counseling #jabatan').text(data.jabatan);
        	$('#modal_form_counseling #grade').text(data.iGrade);

        	$('#modal_form_counseling').modal({backdrop: 'static'});
            $('#modal_form_counseling').modal('show');
            $("#modal_form_counseling").draggable({handle: ".modal-header"});
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    

    	

}


function read_form_counseling(id){

	//Ajax Load data from ajax
	save_method = 'update';
	
    $.ajax({
        url : "<?php echo site_url('development/summary/add_form_counseling/')?>/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

        	$('#modal_form_counseling #nama').text(data.EmployeeID+' / '+data.nama);
        	$('#modal_form_counseling #company').text(data.company);
        	$('#modal_form_counseling #divisi').text(data.divisi);
        	$('#modal_form_counseling #dept').text(data.dept);
        	$('#modal_form_counseling #periode').text(data.PeriodID);
        	$('#modal_form_counseling #jabatan').text(data.jabatan);
        	$('#modal_form_counseling #grade').text(data.iGrade);

        	$('[name="CounselingKPIID"]').val(data.KPIID);
        	$('[name="hal_positif"]').val(data.KPIID);


        	$('#modal_form_counseling').modal({backdrop: 'static'});
            $('#modal_form_counseling').modal('show');
            $("#modal_form_counseling").draggable({handle: ".modal-header"});
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

}

function save_form_counseling(){

    //$('#btnSave').text('saving...'); 
    //$('#btnSave').attr('disabled',true); 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('development/summary/counseling_insert')?>";
    } else {
        url = "<?php echo site_url('development/summary/counseling_update')?>";
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
                $('#modal_form_counseling').modal('hide');
                //reload_table();

                alert('Data berhasil disimpan...');
                //location.reload();

                reload_index_page();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
            

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });
}

function reload_index_page(){
        
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('development/summary/')?>/",
        type: "GET",
        success: function(html)
        {
        	$("#__section-content").html(html);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}



</script>

<style type="text/css">

#modal_form_counseling .modal-dialog  {width:80%;}


.button {
  background-color: #B20000;
  -webkit-border-radius: 10px;
  border-radius: 5px;
  border: none;
  color: #FFFFFF;
  cursor: pointer;
  display: inline-block;
  /*font-family: Arial;*/
  font-size: 12px;
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
  display: inline-block;
  /*font-family: Arial;*/
  font-size: 12px;
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
</style>