<?php

    $column_width = (int)(80/count($columns));

    if(!empty($list)){
?><div class="bDiv" >
        <table cellspacing="0" cellpadding="0" border="0" id="flex1" class="table table-striped">
        <thead>
            <tr class='hDiv'>
                <?php foreach($columns as $column){?>
                <th width='<?php echo $column_width?>%'>
                    <div class="text-left field-sorting <?php if(isset($order_by[0]) &&  $column->field_name == $order_by[0]){?><?php echo $order_by[1]?><?php }?>"
                        rel='<?php echo $column->field_name?>'>
                        <?php echo $column->display_as?>
                    </div>
                </th>
                <?php }?>
                <?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
                <th align="left" abbr="tools" axis="col1" class="" width='20%'>
                    <div class="text-right">
                        <?php echo $this->l('list_actions'); ?>
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
        <tr rowId="<?php echo $rowId; ?>">
            <?php foreach($columns as $column){?>
            <td width='<?php echo $column_width?>%' class='<?php if(isset($order_by[0]) &&  $column->field_name == $order_by[0]){?>sorted<?php }?>'>
                <div class='text-left'><?php echo $row->{$column->field_name} != '' ? $row->{$column->field_name} : '&nbsp;' ; ?></div>
            </td>
            <?php }?>
            <?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
            <td align="left" width='20%'>
                <div class='tools'>
                    <?php
                    if(!empty($row->action_urls)){
                        foreach($row->action_urls as $action_unique_id => $action_url){
                            $action = $actions[$action_unique_id];
                    ?>
                            <a href="<?php echo $action_url; ?>" class="<?php echo $action->css_class; ?> crud-action" title="<?php echo $action->label?>"><?php
                                if(!empty($action->image_url))
                                {
                                    if(strpos($action->image_url, 'glyphicon glyphicon-') == 0){
                                        ?><i class="<?php echo $action->image_url; ?>"></i>&nbsp;<?php
                                    }else{
                                        ?><img src="<?php echo $action->image_url; ?>" alt="<?php echo $action->label?>" />&nbsp;<?php
                                    }
                                }
                                echo $action->label;
                            ?></a>
                    <?php }
                    }
                    ?>
                    <?php if(!$unset_read){?>
                        &nbsp;
                        <a href='<?php echo $row->read_url?>' title='<?php echo $this->l('list_view')?> <?php echo $subject?>' class="edit_button btn btn-default">
                              <span class='read-icon'><i class="glyphicon glyphicon-list"></i>&nbsp;<?php echo $this->l('list_view')?></span>
                        </a>
                    <?php }?>
                    <?php if(!$unset_edit){?>&nbsp;
                        <a href='<?php echo $row->edit_url?>' title='<?php echo $this->l('list_edit')?> <?php echo $subject?>' class="edit_button btn btn-default">
                              <span class='edit-icon'><i class="glyphicon glyphicon-pencil"></i>&nbsp;<?php echo $this->l('list_edit')?></span>
                        </a>
                    <?php }?>
                    <?php if(!$unset_delete){?>&nbsp;
                        <a href='<?php echo $row->delete_url?>' title='<?php echo $this->l('list_delete')?> <?php echo $subject?>' class="delete-row btn btn-default" >
                                <span class='delete-icon'><i class="glyphicon glyphicon-remove"></i>&nbsp;<?php echo $this->l('list_delete')?></span>
                        </a>
                    <?php }?>
                    <div class='clear'></div>
                </div>
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
