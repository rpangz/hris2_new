<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<table width="100%" class="table table-hover table-striped" style="font-size: 12px;">
	<thead>
	<tr>
	    <th class="text-center" width="5%">No</th>
	    <th class="text-center" width="10%">Start Year</th>
	    <th class="text-center" width="10%">End Year</th>
	    <th class="text-left">Company</th>
	    <th class="text-left">Position</th>
	    <th width="9%" colspan="3" class="text-center">Action</th>
	</tr>
	</thead>

	<tbody>
	<?php
	$no = 1;
	foreach ($result as $key => $data) { ?>
		<tr>			
			<td class="text-center"><?php echo $no;?></td>
			<td class="text-center"><?php echo $data->Startdate;?></td>
			<td class="text-center"><?php echo $data->Finishdate;?></td>
			<td class="text-left"><?php echo $data->WorkExpCompany;?></td>
			<td class="text-left"><?php echo $data->WorkExpPosition;?></td>		
			<td width="3%" class="text-center"><a title="Edit" href="javascript:void(0);" onclick="get_edit('<?php echo $data->primary_key;?>')"><i class="fa fa-pencil-square-o big-icon"></i></a></td>
			<td width="3%" class="text-center"><a title="Delete" href="javascript:void(0);" onclick="delete_resume('<?php echo $data->primary_key;?>')"><i class="fa fa-trash-o big-icon"></i></a></td>
		</tr>
	<?php $no++; }	?>
	</tbody>
</table>