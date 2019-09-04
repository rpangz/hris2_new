<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<table width="100%" class="table table-hover table-striped" style="font-size: 12px;">
	<tr>
	    <th width="5%">No</th>
	    <th width="10%">NIK</th>
	    <th>Description</th>
	    <th>Alamat</th>
	    <th width="9%" colspan="3" class="text-center">Action</th>
	</tr>

	<tbody>
	<?php
	foreach ($result as $key => $data) { ?>
		<tr>
			<td class="text-center"><?php echo $data->NIK;?></td>
			<td class="text-center"><?php echo $data->Nama;?></td>
			<td class="text-center"><?php echo $data->Alamat;?></td>
			<td class="text-center"><?php echo $data->Email;?></td>		
			<td width="3%" class="text-center"><a title="Edit" href="javascript:void(0);" onclick="get_edit('<?php echo $data->NIK;?>')"><i class="fa fa-pencil-square-o big-icon"></i></a></td>
			<td width="3%" class="text-center"><a title="Delete" href="javascript:void(0);" onclick="delete_resume('<?php echo $data->NIK;?>')"><i class="fa fa-trash-o big-icon"></i></a></td>
		</tr>
	<?php }	?>
	</tbody>
</table>