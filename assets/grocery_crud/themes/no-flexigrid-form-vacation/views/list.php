<?php

    $column_width = (int)(80/count($columns));

    if(!empty($list)){
?><div class="bDiv" >
        <table cellspacing="0" cellpadding="0" border="0" id="flex1" class="">
        <thead>
            <tr class='hDiv'>
                <?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
                <th align="left" abbr="tools" axis="col1" class="" width='10%'>
                    <div class="text-right">
                        <!--<?php echo $this->l('list_actions'); ?>-->
                        #
                    </div>
                </th>
                <?php }?>
                <?php foreach($columns as $column){?>
                <th width='<?php echo $column_width?>%'>
                    <div class="text-left field-sorting <?php if(isset($order_by[0]) &&  $column->field_name == $order_by[0]){?><?php echo $order_by[1]?><?php }?>"
                        rel='<?php echo $column->field_name?>'>
                        <?php echo $column->display_as?>
                    </div>
                </th>
                <?php }?>
                
            </tr>
        </thead>
        <tbody>
<?php foreach($list as $num_row => $row){ ?>
        <?php
        $temp_string = $row->delete_url;
        $temp_string = explode("/", $temp_string);
        $row_num = sizeof($temp_string)-1;
        $rowId = $temp_string[$row_num];
        ?>
        <tr rowId="<?php echo $rowId; ?>" <?php if($num_row % 2 == 1){?> class="erow"<?php }?>>

            <?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
            <td align="left" width='10%'>
                <div class='tools'>

                    <?php
                    if(!empty($row->action_urls)){
                        foreach($row->action_urls as $action_unique_id => $action_url){
                            $action = $actions[$action_unique_id];
                        ?>
                            
                        <a href="<?php echo $action_url; ?>" class="<?php echo $action->css_class; ?> crud-action" title="<?php echo $action->label?>">
                            <i class="<?php echo $action->image_url; ?>"></i>                                
                        </a>                        

                    <?php }
                    }
                    ?> 

                    <?php if(!$unset_read){?>                                          

                        <a href='javascript:void(0)' title='Detail form cuti' onclick="callback_dialog_detail_cuti(<?php echo $rowId; ?>)" class="btn btn-xs btn-default btn-flat text-success" >
                        <i class="glyphicon glyphicon-search"></i>
                    </a>

                    <?php }?>
                    <?php if(!$unset_edit){?>&nbsp;
                        <a href='<?php echo $row->edit_url?>' title='<?php echo $this->l('list_edit')?>' class="edit_button btn btn-xs btn-success btn-flat">
                              <span class='edit-icon'><i class="glyphicon glyphicon-pencil"></i></span>
                        </a>
                    <?php }?>
                    <?php if(!$unset_delete){?>&nbsp;
                        <a href='<?php echo $row->delete_url?>' title='<?php echo $this->l('list_delete')?>' class="delete-row btn btn-xs btn-danger btn-flat" >
                                <span class='delete-icon'><i class="glyphicon glyphicon-trash"></i></span>
                        </a>
                    <?php }?>
                    <div class='clear'></div>
                </div>
            </td>
            <?php }?>

            <?php foreach($columns as $column){?>
            <td width='<?php echo $column_width?>%' class='<?php if(isset($order_by[0]) &&  $column->field_name == $order_by[0]){?>sorted<?php }?>'>
                <div relied='<?php echo $column->field_name?>' costum-text="<?php echo $column->field_name?>" class=''><?php echo $row->{$column->field_name} != '' ? $row->{$column->field_name} : '&nbsp;' ; ?></div>
            </td>
            <?php }?>
            
        </tr>
<?php } ?>
        </tbody>
        </table>
    </div>
<?php }else{?>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->l('list_no_items'); ?>
    <br/>
    <br/>
<?php }?>

<style type="text/css">    
    #flex1 table, td {
        border-bottom: 1px solid #CCCCCC !important;
        height: 20px !important;
    }
    #flex1 table, th {
        border-bottom: 3px double #999999 !important;
    }
    #flex1 table, tr {
        height: : 50px !important;
    }
    .text-danger{
        color: #f44242;
    }
    .text-danger:hover{
        color: #a80101;
    }

    .text-success{
        color: #0d8734;
    }
    .text-success:hover{
        color: #028c2e;
    }

</style>
