<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$action     = $this->input->get('action');
$level      = $this->input->get('level');
$token      = $this->input->get('token');

$asset = new CMS_Asset();
foreach($css_files as $file){
    $asset->add_css($file);
}
echo $asset->compile_css();

foreach($js_files as $file){
    $asset->add_js($file);
}
echo $asset->compile_js();

// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}


if(isset($dropdown_setup5)){
  $this->load->view('dependent_dropdown5', $dropdown_setup5);
}

echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);

?>

<?php if ($state =='edit' OR $state == 'add'){ ?>

<input type="text" name="ParticipantQty" id="ParticipantQty" value="" title="ParticipantQty" class="form-control" />
<input type="text" name="CurrencyText" id="CurrencyText" value="" title="CurrencyText" class="form-control" />

<table class="table table-striped table-borderless" style="font-size:12px;width:98%;table-layout:fixed">           
            <tr>
                <td>
                      <fieldset class="fsStyle">  <legend class="legendStyle">Company Profile</legend>
                        <table class="table table-hover table-borderless" width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <th width="20%" >NO *</th>
                            <td width="2%">:</td>
                            <td>
                              <div class="input-group">
                                 <input type="hidden" name="token" id="token" value="<?php echo $token;?>" title="token"/>
                                 <input type="hidden" name="action" id="action" value="<?php echo $action;?>" title="action"/>
                                 <input type="hidden" name="FPTSNo" id="FPTSNo" value="" title="Nomor Form" class="form-control" />                                 
                                 <input type="text" name="FPTSNo" id="FPTSNo" value="<?php echo $FPTSNo?>" title="Nomor Form" class="form-control" disabled/>
                                 <span class="input-group-addon">
                                  <a href="#" style="text-decoration: none;" class="glyphicon glyphicon-question-sign tip-left" data-toggle="tooltip" title="Nomor digenerate oleh sistem setelah field perusahaan dipilih. Nomor ini merupakan estimasi, nomor valid akan ditampilkan setelah anda melakukan proses."></a>
                                </span>
                              </div>

                              <input type="hidden" name="FPTSNo" id="FPTSNo" value="<?php echo $FPTSNo?>" title="Nomor Form" class="form-control"/>
                              
                            </td>
                            <td>&nbsp;</td>
                            <th>Company *</th>
                            <td width="2%">:</td>
                            <td width=""><?php echo $CompanyID ?></td>
                          </tr>
                          <tr>
                            <th>Tanggal *</th>
                            <td>:</td>
                            <td><input type="text" name="TrDate" id="TrDate" value="" title="Transaction Date" class="datepicker-input form-control" placeholder="Transaction Date"/></td>
                            <td>&nbsp;</td>
                            <th>Division *</th>
                            <td>:</td>
                            <td><?php echo $DivisionID; ?></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <th>Department *</th>
                            <td>:</td>
                            <td><?php echo $DepartmentID; ?></td>
                          </tr>
                        </table>
                      </fieldset>
                        
                </td>
            </tr>

            <tr>
                <td>
                      <fieldset class="fsStyle">  <legend class="legendStyle">Participant</legend>

                        <table class="" width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>                            
                            <td><?php echo $field_detail_fpts; ?></td>
                          </tr>                            
                        </table>                        
                      </fieldset>
                        
                </td>
            </tr>

            
            <tr>
                <td>
                        <fieldset class="fsStyle">  <legend class="legendStyle">Training / Certificate</legend>
                        <table class="table table-hover table-borderless" width="100%" border="0" cellspacing="1" cellpadding="0">
                        	<tr>
                            <th>
                              DATA *
                            </th>
                            <td width="2%">:</td>
                            <td colspan="3">                      

                              <table class="table-borderless" width="100%" border="0" cellspacing="1" cellpadding="0">
                              <tr>                               
                                <td width="20%">
                                  <div class="funkyradio">
                                    <div class="funkyradio-success">
                                      <input type="radio" name="TypeID" id="TypeID1" value="1" checked/><label for="TypeID1">Training</label>
                                    </div>
                                  </div>
                                </td>
                                <td width="20%">
                                  <div class="funkyradio">
                                    <div class="funkyradio-success">
                                      <input type="radio" name="TypeID" id="TypeID2" value="2" /><label for="TypeID2">Ujian Sertifikasi</label>
                                    </div>
                                  </div>
                                </td>
                                <td width="20%" class="text-right"><strong>EXAM PRODUCT * :  &nbsp;</strong></td>
                                <td><?php echo $ProductID ?></td>
                              </tr>
                            </table>
                            </td>
                       
                          </tr>
                          <tr>
                            <th width="20%" >Nama Modul / ID *</th>
                            <td width="2%">:</td>
                            <td width="78%" colspan="3"><input type="text" name="ModulName" id="ModulName" value="" title="Nama Modul atau ID" class="form-control" placeholder="Modul Name / ID"/></td>                           
                          </tr>
                          <tr>
                            <th>Nama Penyelenggara *</th>
                            <td>:</td>
                            <td colspan="3"><input type="text" name="OrganizerID" id="OrganizerID" value="" title="Organizer ID" class="form-control" placeholder="Organizer ID"/></td>                        
                          </tr>

                          <tr>
                            <th>Pelaksanaan di *</th>
                            <td>:</td>
                            <td colspan="3">
                              <table class="table-borderless" width="100%" border="0" cellspacing="1" cellpadding="0">
                                <tr>
                                  <td width="20%">
                                    <div class="funkyradio">
                                      <div class="funkyradio-success"><input type="radio" name="DestRadio" id="DestRadio1" value="1" checked/>
                                        <label for="DestRadio1">Dalam Negeri</label>
                                      </div>
                                    </div>
                                  </td>
                                  <td width="20%">
                                    <div class="funkyradio">
                                      <div class="funkyradio-success">
                                        <input type="radio" name="DestRadio" id="DestRadio2" value="2"/>
                                        <label for="DestRadio2">Luar Negeri</label>
                                      </div>
                                    </div>
                                  </td>
                                  <td><?php echo $DestinationID ?></td>
                                  
                                </tr>
                              </table>                              
                        </td>
          				                              
                          </tr>
                          <tr>
                            <th>Alamat / Tempat *</th>
                            <td>:</td>
                            <td colspan="3"><textarea maxlength="250" style="width: 95%; height: 80%; border: 1px solid #999999; font-style:italic;" placeholder="Maksimal 250 karakter..." class="form-control" name="Address" id="Address"></textarea></td>                        
                          </tr>
                          <tr>
                            <th>Jadwal *</th>
                            <td>:</td>

                            <td colspan="3">
                              <table class="table-borderless" width="100%" border="0" cellspacing="1" cellpadding="0">
                                <tr>
                                  <td><input type="text" name="Date1" id="Date1" value="" title="Jadwal Mulai" class="datepicker-input form-control" placeholder="dd/mm/yyyy"/></td>
                                  <td width="7%" class="text-center">s/d</td>
                                  <td><input type="text" name="Date2" id="Date2" value="" title="Jadwal Selesai" class="datepicker-input form-control" placeholder="dd/mm/yyyy"/></td>
                                 
                                  <td width="50%">&nbsp;</td>
                                </tr>
                              </table>


                            </td>
                          </tr>

                          <tr>
                            <th colspan="5">PERTIMBANGAN ATAS PENGAJUAN TRAINING / UJIAN SERTIFIKASI 2) :</th>                       
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td colspan="3" width="40%">
                              <div class="funkyradio">
                              <table class="table-borderless" width="100%" border="0" cellspacing="1" cellpadding="0">
                                <!--
                                <tr>
                                  <td>
                                    <div class="funkyradio-success">
                                      <input type="checkbox" name="ReasoningID" id="ReasoningID_1" value="1" checked/>
                                      <label for="ReasoningID_1">TNA (Training Need Analysis) Tahunan</label>
                                  </div>
                                  </td>
                                  <td>&nbsp;</td>
                                </tr>

                                <tr>
                                  <td>
                                    <div class="funkyradio-success">
                                      <input type="checkbox" name="ReasoningID" id="ReasoningID_2" value="2"/>
                                      <label for="ReasoningID_2">Peningkatan Kinerja</label>
                                  </div>
                                  </td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>
                                    <div class="funkyradio-success">
                                      <input type="checkbox" name="ReasoningID" id="ReasoningID_3" value="3"/>
                                      <label for="ReasoningID_3">Memenuhi Persyaratan Principal</label>
                                  </div>
                                  </td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>
                                    <div class="funkyradio-success">
                                      <input type="checkbox" name="ReasoningID" id="ReasoningID_4" value="4"/>
                                      <label for="ReasoningID_4">Kebutuhan Proyek / Operasional</label>
                                  </div>
                                  </td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>
                                    <div class="funkyradio-success">
                                      <input type="checkbox" name="ReasoningID" id="ReasoningID_5" value="5"/>
                                      <label for="ReasoningID_5">Lain-lain</label>
                                  </div>
                                  </td>
                                  <td width="60%"><input type="text" name="Other" id="Other" value="" title="Other" class="form-control" placeholder="Other" readonly/></td>
                                </tr>-->

                                <?php echo $ReasoningID; ?>

                              </table>
                            </div>

                            </td>
                          </tr>


                          <tr>
                            <th colspan="5">PERKIRAAN BIAYA</th>                       
                          </tr>
                          <tr>
                            <th>Biaya *</th>
                            <td>:</td>
                            <td colspan="3">
                              <table class="table-borderless" width="100%" border="0" cellspacing="1" cellpadding="0">
                                <tr>
                                  
                                  <td width="20%">
                                    <div class="funkyradio">
                                      <div class="funkyradio-success">
                                        <input type="radio" name="BudgetID" id="BudgetID_1" value="1" checked/><label for="BudgetID_1">Budgetted</label>
                                      </div>
                                    </div>
                                  </td>
                                  <td width="20%">
                                    <div class="funkyradio">
                                      <div class="funkyradio-success">
                                        <input type="radio" name="BudgetID" id="BudgetID_2" value="2"/><label for="BudgetID_2">Unbudgetted</label>
                                      </div>
                                    </div>
                                  </td>                                  
                                  <td width="20%" class="text-right">Kategori ID : &nbsp;</td>
                                  <td><?php echo $KategoriID ?></td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <th>Beban Biaya *</th>
                            <td>:</td>
                            <td colspan="3">
                              <table class="table-borderless" width="100%" border="0" cellspacing="1" cellpadding="0">
                                <tr>
                                  
                                  <td width="20%">
                                    <div class="funkyradio">
                                      <div class="funkyradio-success">
                                        <input type="radio" name="ChargeID" id="ChargeID_1" value="1" checked/><label for="ChargeID_1">Divisi</label>
                                      </div>
                                    </div>
                                  </td>
                                  <td width="20%">
                                    <div class="funkyradio">
                                      <div class="funkyradio-success">
                                        <input type="radio" name="ChargeID" id="ChargeID_2" value="2"/><label for="ChargeID_2">Proyek</label>
                                      </div>
                                    </div>
                                  </td>                                  
                                  <td width="20%" class="text-right">Project ID : &nbsp;</td>
                                  <td><input type="text" name="ProjectID" id="ProjectID" value="" title="ProjectID" class="form-control" /></td>
                                </tr>
                              </table>

                            </td>
                          </tr>
                          <tr>
                            <th>Mata Uang *</th>
                            <td>:</td>
                            <td><?php echo $CurrencyID; ?></td>
                            <td colspan="2"></td>                            
                          </tr>
                          <tr>
                            <th>Biaya / Orang *</th>
                            <td>:</td>
                            <td width="25%"><input type="text" name="Amount" id="Amount" value="" title="Amount" class="form-control" placeholder="Amount" onchange="number_change()"/></td>
                            <td colspan="2"><div align="left" id="amount_kata_kata"></div></td>
                          </tr>
                          <tr>
                            <th>Total Biaya *</th>
                            <td>:</td>
                            <td width="25%"><input type="text" name="TotalAmount" id="TotalAmount" value="" title="Total Amount" class="form-control" placeholder="Total" readonly/></td>
                            <td colspan="2"><div align="left" id="total_kata_kata"></div></td>
                          </tr>
                          <tr>
                            <th>Cara Pembayaran</th>
                            <td>:</td>
                            <td colspan="3">
                              <table class="table-borderless" width="100%" border="0" cellspacing="1" cellpadding="0">
                              <tr>
                                <td width="20%">
                                  <div class="funkyradio">
                                    <div class="funkyradio-success">
                                      <input type="radio" name="PaymentID" id="PaymentID1" value="1" checked/><label for="PaymentID1">Cash</label>
                                    </div>
                                  </div>
                                </td>
                                <td width="20%">
                                  <div class="funkyradio">
                                    <div class="funkyradio-success">
                                      <input type="radio" name="PaymentID" id="PaymentID2" value="2"/><label for="PaymentID2">Transfer Bank</label>
                                    </div>
                                  </div>
                                </td>
                                <td width="18%"><input type="text" name="AccountBankID" id="AccountBankID" value="" title="Bank ID" class="form-control" placeholder="Bank ID" /></td>
                                <td><input type="text" name="AccountID" id="AccountID" value="" title="Account ID" class="form-control" placeholder="Nomor Rekening" /></td>
                                <td><input type="text" name="AccountName" id="AccountName" value="" title="Account Name" class="form-control" placeholder="Atas Nama" /></td>
                              </tr>
                            </table>                              
                        </td>                            
                          </tr>

                        <tr>
                            <th></th>
                            <td></td>
                            <td colspan="3">
                            <table class="table-borderless" width="100%" height="120" border="0" cellpadding="0" cellspacing="1">
                              <tr>
                                <td width="40%">
                                  <div class="funkyradio">
                                  <div class="funkyradio-danger">
                                      <input type="checkbox" name="TermsID" id="TermsID" value="1"/>
                                      <label for="TermsID">I accept the terms and conditions </label>
                                  </div>
                              </div>

                                </td>
                                <td>
                                   <div id="TermsAlert" class="alert alert-info">
                                <strong>Terms & Conditions!</strong> Anda memiliki ikatan dinas, silahkan lihat data 
                                <a href="#Top"><strong>Participant</strong></a> diatas. Dengan mengklik tombol ini, Anda telah menyetujui Ikatan Dinas anda.
                              </div>

                                </td>
                                
                              </tr>
                            </table>
                          </td>

                                        
                        </tr>

                          
                         
                        </table></fieldset>
                        
                </td>
            </tr>




            <tr>
              <td>

                <fieldset class="fsStyle">  <legend class="legendStyle">Workflow</legend>

                  <?php //echo $BankMandiri; ?>
                 <?php //echo json_encode(table_to_query()); ?>
                 <?php //echo json_encode($profile_data); ?>
                  
                </fieldset>



              </td>

            </tr>

            

            </table>

          <div class="pDiv">
            <div class='form-button-box'>
                <input type='button' value='Process' id="save-and-go-back-button"  class="btn btn-primary btn-large"/>
            
                <input type='button' value='Cancel' class="btn btn-default btn-large" id="cancel-button" />
            </div>
          </div>

          <div class="clear"></div>
          <div class="form-button-box" style="width:100%;float: left;">
              <div class="small-loading" id="FormLoading" style="width:100%;float: right;">Loading, updating changes...</div>
          </div>
          <div class="clear"></div>


    
    <?php echo form_close(); ?>
</div>
</div>

<style type="text/css">

input[type="text"] {
     /*width: 90%;*/
     /*margin-bottom: 0px !important;*/
    
}

.table-borderless tbody tr td, .table-borderless tbody tr th, .table-borderless thead tr th {
    border: none;
    vertical-align: middle !important;
    text-align: middle !important;
}
.panel-heading{
    font-weight: bold;
}


legend a {
  color: inherit;
}
legend.legendStyle {
  padding-left: 5px;
  padding-right: 5px;
  padding-top: 0px;
  
}
fieldset.fsStyle {
  
  border: 1px solid #999999;
  padding: 2px;
  margin: 2px;
  padding-bottom: 0px;
}
legend.legendStyle {
  font-size: 90%;
  color: #888888;
  background-color: transparent;
  font-weight: bold;
}

legend {
  width: auto;
  border-bottom: 0px;
}


<style type="text/css">
.label-info {
    background-color: #FFFF00;
    color:#000000;
}
.label-warning {
    background-color: #FF9900;
}
.label-default{
    font-size: 12px;
    width: 100%;
}
.full-width {
    display:block;
    /*width: 90%;*/
}

.selectpicker{
    position: relative !important;
    z-index: 2 !important;
    float: left !important;
    width: 100% !important;
    margin-bottom: 0 !important;
    display: table !important;
    table-layout: fixed !important; 

}

</style>

<style type="text/css">
.table > tbody > tr > td {
    vertical-align: middle !important;
    text-align: middle !important;
}

.th{
	vertical-align: middle !important;
}

.form-group input[type="checkbox"] {
    display: none;
}

.form-group input[type="checkbox"] + .btn-group > label span {
    width: 20px;
}

.form-group input[type="checkbox"] + .btn-group > label span:first-child {
    display: none;
}
.form-group input[type="checkbox"] + .btn-group > label span:last-child {
    display: inline-block;   
}

.form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
    display: inline-block;
}
.form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
    display: none;   
}

@import('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/css/bootstrap.min.css') 

.funkyradio div {
  clear: both;
  overflow: hidden;
}

.funkyradio label {
  width: 100%;
  border-radius: 3px;
  border: 1px solid none;
  font-weight: normal;
}

.funkyradio input[type="radio"]:empty,
.funkyradio input[type="checkbox"]:empty {
  display: none;
  text-align: middle;
}

.funkyradio input[type="radio"]:empty ~ label,
.funkyradio input[type="checkbox"]:empty ~ label {
  position: relative;
  line-height: 2.5em;
  text-indent: 3.25em;
  text-align: middle;
  margin-top: 0em;
  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}

.funkyradio input[type="radio"]:empty ~ label:before,
.funkyradio input[type="checkbox"]:empty ~ label:before {
  position: absolute;
  display: block;
  top: 0;
  bottom: 0;
  left: 0;
  content: '';
  width: 2.5em;
  background: #D1D3D4;
  border-radius: 3px 0 0 3px;
}

.funkyradio input[type="radio"]:hover:not(:checked) ~ label,
.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
  color: #888;
}

.funkyradio input[type="radio"]:hover:not(:checked) ~ label:before,
.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
  content: '\2714';
  text-indent: .9em;
  color: #C2C2C2;
}

.funkyradio input[type="radio"]:checked ~ label,
.funkyradio input[type="checkbox"]:checked ~ label {
  color: #000000;
  font-weight: bold;
}

.funkyradio input[type="radio"]:checked ~ label:before,
.funkyradio input[type="checkbox"]:checked ~ label:before {
  content: '\2714';
  text-indent: .9em;
  color: #333;
  background-color: #ccc;
}

.funkyradio input[type="radio"]:focus ~ label:before,
.funkyradio input[type="checkbox"]:focus ~ label:before {
  box-shadow: 0 0 0 3px #999;
}

.funkyradio-default input[type="radio"]:checked ~ label:before,
.funkyradio-default input[type="checkbox"]:checked ~ label:before {
  color: #333;
  background-color: #ccc;
}

.funkyradio-primary input[type="radio"]:checked ~ label:before,
.funkyradio-primary input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #337ab7;
}

.funkyradio-success input[type="radio"]:checked ~ label:before,
.funkyradio-success input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #5cb85c;
}

.funkyradio-danger input[type="radio"]:checked ~ label:before,
.funkyradio-danger input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #d9534f;
}

.funkyradio-warning input[type="radio"]:checked ~ label:before,
.funkyradio-warning input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #f0ad4e;
}

.funkyradio-info input[type="radio"]:checked ~ label:before,
.funkyradio-info input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #5bc0de;
}

/* SCSS STYLES */
/*
.funkyradio {

    div {
        clear: both;
        overflow: hidden;
    }

    label {
        width: 100%;
        border-radius: 3px;
        border: 1px solid #D1D3D4;
        font-weight: normal;
    }

    input[type="radio"],
    input[type="checkbox"] {

        &:empty {
            display: none;

            ~ label {
                position: relative;
                line-height: 2.5em;
                text-indent: 3.25em;
                margin-top: 2em;
                cursor: pointer;
                user-select: none;

                &:before {
                    position: absolute;
                    display: block;
                    top: 0;
                    bottom: 0;
                    left: 0;
                    content: '';
                    width: 2.5em;
                    background: #D1D3D4;
                    border-radius: 3px 0 0 3px;
                }
            }
        }

        &:hover:not(:checked) ~ label {
            color: #888;

            &:before {
                content: '\2714';
                text-indent: .9em;
                color: #C2C2C2;
            }
        }

        &:checked ~ label {
            color: #777;

            &:before {
                content: '\2714';
                text-indent: .9em;
                color: #333;
                background-color: #ccc;
            }
        }

        &:focus ~ label:before {
            box-shadow: 0 0 0 3px #999;
        }
    }

    &-default {
        input[type="radio"],
        input[type="checkbox"] {
            &:checked ~ label:before {
                color: #333;
                background-color: #ccc;
            }
        }
    }

    &-primary {
        input[type="radio"],
        input[type="checkbox"] {
            &:checked ~ label:before {
                color: #fff;
                background-color: #337ab7;
            }
        }
    }

    &-success {
        input[type="radio"],
        input[type="checkbox"] {
            &:checked ~ label:before {
                color: #fff;
                background-color: #5cb85c;
            }
        }
    }

    &-danger {
        input[type="radio"],
        input[type="checkbox"] {
            &:checked ~ label:before {
                color: #fff;
                background-color: #d9534f;
            }
        }
    }

    &-warning {
        input[type="radio"],
        input[type="checkbox"] {
            &:checked ~ label:before {
                color: #fff;
                background-color: #f0ad4e;
            }
        }
    }

    &-info {
        input[type="radio"],
        input[type="checkbox"] {
            &:checked ~ label:before {
                color: #fff;
                background-color: #5bc0de;
            }
        }
    }
}
*/
</style>

<script type="text/javascript">

$(document).ready(function(){

    $(".datepicker-input").datepicker({
        showOn: "focus",
        dateFormat: "dd/mm/yy",
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true
    });

    $(".selectpicker").selectpicker({
        style: "btn-default",
        size: "auto",
        width: "100%",
    });

});



</script>


<script type="text/javascript">
/* Select Box */
$('.selectpicker').selectpicker({
    style: 'btn-default'
    ,size: "auto"
    ,width: "100%",
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
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

$("#Top").click(function(){
 scroll(0,0);
});

</script>


<script type="text/javascript">
$(document).ready(function(){

    $('#TermsID').change(function(){
        if(this.checked)
          $('#TermsAlert').fadeOut('slow');
        else
          $('#TermsAlert').fadeIn('slow');

    });

    $('#ReasoningID_0').change(function(){
        if(this.checked)
          $('#Other').attr('readonly', false);
        else
          $('#Other').attr('readonly', true);
    });

    $("#TrDate").datepicker({showOn: 'focus', dateFormat: 'dd/mm/yy'}).focus();

    var currency = document.getElementById("CurrencyID").value;
    document.getElementById("CurrencyText").value = currency;

});
</script>


<script type="text/javascript">


  function number_change(){

    var Amount = Number(document.getElementById("Amount").value);
    var ParticipantQty = Number(document.getElementById("ParticipantQty").value);

    document.getElementById("TotalAmount").value = Amount*ParticipantQty;
    
    var words = toWords(Amount*ParticipantQty);
    document.getElementById("total_kata_kata").innerHTML = '<i>'+words+'</i>';

    var words2 = toWords(Amount);
    document.getElementById("amount_kata_kata").innerHTML = '<i>'+words2+'</i>';         
        

  }


  function select_currency(){
    var currency = document.getElementById("CurrencyID").value;
    document.getElementById("CurrencyText").value = currency;
  }


  

</script>

<script type="text/javascript">
    $('#ModalKasbon').on('hidden.bs.modal', function () {
            $('.modal-body').find('lable,input,textarea,table,tr,td').val('');
            
    });

    $('#getConnection').on('hidden.bs.modal', function () {
            $('.modal-body').find('lable,input,textarea,table,tr,td').val('');
            
    });

    $('#myComment').on('hidden.bs.modal', function () {
            $('.modal-body').find('lable,input,textarea,table,tr,td').val('');
            
    });

    $('#myUHPD').on('hidden.bs.modal', function () {
            $('.modal-body').find('lable,input,textarea,table,tr,td').val('');
            
    });

</script>


<!--
<div class="col-md-4">
<div class="col-md-6">
     <h4>Radio Buttons</h4>

    <div class="funkyradio">
        <div class="funkyradio-default">
            <input type="radio" name="radio" id="radio1" />
            <label for="radio1">First Option default</label>
        </div>
        <div class="funkyradio-primary">
            <input type="radio" name="radio" id="radio2" checked/>
            <label for="radio2">Second Option primary</label>
        </div>
        <div class="funkyradio-success">
            <input type="radio" name="radio" id="radio3" />
            <label for="radio3">Third Option success</label>
        </div>
        <div class="funkyradio-danger">
            <input type="radio" name="radio" id="radio4" />
            <label for="radio4">Fourth Option danger</label>
        </div>
        <div class="funkyradio-warning">
            <input type="radio" name="radio" id="radio5" />
            <label for="radio5">Fifth Option warning</label>
        </div>
        <div class="funkyradio-info">
            <input type="radio" name="radio" id="radio6" />
            <label for="radio6">Sixth Option info</label>
        </div>
    </div>
</div>
<div class="col-md-6">
     <h4>Checkbox Buttons</h4>

    <div class="funkyradio">
        <div class="funkyradio-default">
            <input type="checkbox" name="checkbox" id="checkbox1" checked/>
            <label for="checkbox1">First Option default</label>
        </div>
        <div class="funkyradio-primary">
            <input type="checkbox" name="checkbox" id="checkbox2" checked/>
            <label for="checkbox2">Second Option primary</label>
        </div>
        <div class="funkyradio-success">
            <input type="checkbox" name="checkbox" id="checkbox3" checked/>
            <label for="checkbox3">Third Option success</label>
        </div>
        <div class="funkyradio-danger">
            <input type="checkbox" name="checkbox" id="checkbox4" checked/>
            <label for="checkbox4">Fourth Option danger</label>
        </div>
        <div class="funkyradio-warning">
            <input type="checkbox" name="checkbox" id="checkbox5" checked/>
            <label for="checkbox5">Fifth Option warning</label>
        </div>
        <div class="funkyradio-info">
            <input type="checkbox" name="checkbox" id="checkbox6" checked/>
            <label for="checkbox6">Sixth Option info</label>
        </div>
    </div>
</div>
</div>
-->
<?php } ?>