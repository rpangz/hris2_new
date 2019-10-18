<?php //echo "TESTTTTT ".json_encode($detaildata); 

echo "{{ base_url }}"

?>
<span class="label label-info">&nbsp;</span><label style="font-size: 10px;font-weight: bold;">&nbsp; Proses</label>,
<span class="label label-danger">&nbsp;</span><label style="font-size: 10px;font-weight: bold;">&nbsp; Revisi</label>,
<span class="label label-success">&nbsp;</span><label style="font-size: 10px;font-weight: bold;">&nbsp; Approved</label>,
<span class="label label-warning">&nbsp;</span><label style="font-size: 10px;font-weight: bold;">&nbsp; Proses Atasan Langsung</label>
<table id="datatablemaster" class="table table-bordered paleBlueRows" style="width: 100%;">
    <thead>
    <tr>
        <th rowspan="2" style="vertical-align: middle;">NIK</th>
        <th rowspan="2" style="vertical-align: middle;">Nama Karyawan</th>
        <th rowspan="2" style="vertical-align: middle;">Department</th>
        <th rowspan="2" style="vertical-align: middle;">A. Result</th>                                    
        <th colspan="2">B. Process/Competency</th>                    
        <th rowspan="2" style="vertical-align: middle;">Total</th>
        <th rowspan="2" style="vertical-align: middle;">Score</th>
        <th rowspan="2" style="vertical-align: middle;">Usulan Nilai</th>
        <th rowspan="2" style="vertical-align: middle;">Remarks</th>
        <th rowspan="2" style="vertical-align: middle;">Action</th>
    </tr>
    <tr>
        <th style="vertical-align: middle;"> I. Process & Core Values</th>
        <th style="vertical-align: middle;">II. Managing People</th>
    </tr>
    </thead>
    <tbody>
    <?php     

    foreach ($detaildata as $row)
    {
            $crud = new second_layer_approvement();
            
            $score           = "";
            $KPIID           = $row->KPIID;
            $nik             = $row->EmployeeID; 
            $nama            = $row->nama;
            $deptname        = $row->cDeptName;
            $total_score_A   = $row->total_score_A;
            $total_score_B   = $row->total_score_B;
            $total_score_C   = $row->total_score_C;
            $total_score     = $row->total_score;
            $iAgree2         = $row->iAgree2;
            $UsulanAgree2    = $row->UsulanAgree2;
            $RemarkAgree2    = $row->RemarkAgree2;

            if($total_score=='0.00'){
                $score  = '-';
            } else {
                $score  = $crud->_callback_column_Category($total_score);
            }

            $classtr = 'default';    
            if($iAgree2=="1") {
                $classtr = 'warning';
            } elseif ($iAgree2=="2") {
                $classtr = 'info';
            } elseif ($iAgree2=="3") {
                $classtr = 'success';
            } elseif ($iAgree2=="4") {
                $classtr = 'danger';
            } 
    ?>            

    <tr role="row" class="<?php echo $classtr; ?>">       
        <td class="sorting_1"><?php echo $nik; ?></td>
        <td class="text-left col-sm-2"><a href="{{ base_url }}development/user_key_performance_indicator/?KPIID=<?php echo $KPIID; ?>"><?php echo $nama; ?></a></td>
        <td class="text-left col-sm-1"><?php echo $deptname; ?></td>
        <td class="text-center"><?php echo $total_score_A; ?></td>
        <td class="text-center"><?php echo $total_score_B; ?></td>
        <td class="text-center"><?php echo $total_score_C; ?></td>
        <td class="text-center"><?php echo $total_score; ?></td>
        <td class="text-left col-sm-1" style="font-size: 10px;"><?php echo $score; ?></td>
        <td class="text-center col-sm-2">
            <select class="form-control input-sm text-center" id="usulan<?php echo $KPIID; ?>" name="usulan<?php echo $KPIID; ?>" style="font-size: 11px;" data-attr="input_data">
                <?php 
                foreach ($list_score as $row_list_score)
                { 

                    if($UsulanAgree2==$row_list_score->score_value) { $selected = "SELECTED"; } else { $selected = ""; }                    
                    echo '<option value="'.$row_list_score->score_value.'" '.$selected.' >'.$row_list_score->score_desc.'</option>';
                } 
                ?>
            </select> 
        </td>
        <td class="text-center col-sm-2">
            <div class="input-group col-sm-12">
              <input type="text" style="font-size: 11px;" class="form-control" placeholder="Remarks" aria-describedby="basic-addon1" value="<?php echo $RemarkAgree2; ?>" id="remarks<?php echo $KPIID; ?>" name="remarks<?php echo $KPIID; ?>">
            </div>
        </td>
        <?php 


        if($iAgree2=='1' || $iAgree2=='4') { 
            $disableapprove   = 'style="display: none;"';
            $disableunapprove = 'style="display: none;"';
            $disablerevisi = 'style="display: none;"';            
         } else {
            $disableapprove   = '';
            $disableunapprove = '';
            $disablerevisi = '';
         }

         if($iAgree2=='3') {
            $displayapprove = 'style="display: none;"';
            $displayrevisi = 'style="display: none;"';
            $displayunapprove = '';
         } else {
            $displayunapprove = 'style="display: none;"';
            $displayapprove = '';
            $displayrevisi = '';
         }

         ?>
        <td class="text-center col-sm-2">
            <button onclick="unapprove(<?php echo $KPIID; ?>)" type="button" class="btn btn-warning btn-xs" <?php echo $disableapprove.' '.$displayunapprove ;  ?> >- Unapprove -</button>
            <button onclick="approve(<?php echo $KPIID; ?>)" type="button" class="btn btn-success btn-xs" <?php echo $disableapprove.' '.$displayapprove; ?> >- Approve -</button>    
            <button onclick="revisi(<?php echo $KPIID; ?>)" type="button" class="btn btn-danger btn-xs" <?php echo $disablerevisi.' '.$displayrevisi; ?> >- Revisi -</button>
        </td>
        
    </tr>
    <?php } ?>                  
    </tbody>
</table>