<table id="example1" cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<?php foreach($columns as $column){?>
				<th class='actions text-center'><?php echo $column->display_as; ?></th>
			<?php }?>
			<?php if(!$unset_delete || !$unset_read || !empty($actions)){?>
			<th class='actions text-right'><?php echo $this->l('list_actions'); ?></th>
			<?php }?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($list as $num_row => $row){ ?>
		<tr id='row-<?php echo $num_row?>'>
			<?php foreach($columns as $column){?>
				<td><?php echo $row->{$column->field_name}?></td>
			<?php }?>
			<?php if(!$unset_delete || !$unset_read || !empty($actions)){?>
			<td class='actions text-right'>
				<?php
				if(!empty($row->action_urls)){
					foreach($row->action_urls as $action_unique_id => $action_url){
						$action = $actions[$action_unique_id];
				?>
						<a href="<?php echo $action_url; ?>" class="edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
							<span class="ui-button-icon-primary ui-icon <?php echo $action->css_class; ?> <?php echo $action_unique_id;?>"></span><span class="ui-button-text">&nbsp;<?php echo $action->label?></span>
						</a>
				<?php }
				}
				?>
				<?php if(!$unset_read){?>
					<a href="<?php echo $row->read_url?>" class="edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
						<span class="ui-button-icon-primary ui-icon ui-icon-document"></span>
						<span class="ui-button-text">&nbsp;<?php echo $this->l('list_view'); ?></span>
					</a>
				<?php }?>

				<?php if(!$unset_edit){?>				

					<a href="<?php echo $row->edit_url?>" class="btn btn-primary btn-flat" title="Perbaharui">
    					<i class="glyphicon glyphicon-pencil"></i>
					</a>

				<?php }?>
				<?php if(!$unset_delete){?>					

					<a onclick = "javascript: return delete_row('<?php echo $row->delete_url?>', '<?php echo $num_row?>')"
						href="javascript:void(0)" class="btn btn-danger btn-flat" title="Hapus">
    					<i class="glyphicon glyphicon-remove"></i>
					</a>					

				<?php }?>
			</td>
			<?php }?>
		</tr>
		<?php }?>
	</tbody>
	
</table>
<style type="text/css">
.table tbody tr:hover td, .table tbody tr:hover th {
    background-color: #eeeeea;
}
</style>