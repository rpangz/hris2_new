<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<table width="100%" class="table table-hover table-striped" style="font-size: 12px;">
	<thead>
	<tr>
	    <th class="text-center" width="5%">No</th>
	    <th class="text-center" width="10%">Start Year</th>
	    <th class="text-center" width="10%">End Year</th>
	    <th class="text-left">Institution</th>
	    <th class="text-left">City</th>
	    <th class="text-center" width="15%">Faculty</th>
	    <th class="text-center" width="10%">GPA</th>
	    <th class="text-center" width="15%">Major</th>
	    <th width="9%" colspan="3" class="text-center">Action</th>
	</tr>
	</thead>

	<tbody>
	<?php
	$no = 1;
	foreach ($result as $key => $data) { ?>
		<tr>			
			<td class="text-center"><?php echo $no;?></td>
			<td class="text-center"><?php echo $data->EduStart;?></td>
			<td class="text-left"><?php echo $data->EduFinish;?></td>
			<td class="text-left"><?php echo $data->EduInstitution;?></td>
			<td class="text-left"><?php echo $data->EduCity;?></td>
			<td class="text-center"><?php echo $data->EduFaculty;?></td>
			<td class="text-center"><?php echo $data->EduGPA;?></td>
			<td class="text-center"><?php echo $data->EduMajor;?></td>		
			<?php
			if (!empty($data->EduFileUrl) && !is_null($data->EduFileUrl)){ ?>
				<td width="3%" class="text-center"><a title="Unduh Lampiran" target="_blank" href="<?php echo $file_path.'/'.$data->EduFileUrl;?>"><i class="fa fa-paperclip big-icon"></i></a></td>
			<?php }
			else{ ?>
				<td class="text-center"></td>
			<?php } ?>
			<td width="3%" class="text-center"><a title="Edit" href="javascript:void(0);" onclick="get_edit('<?php echo $data->EduId;?>')"><i class="fa fa-pencil-square-o big-icon"></i></a></td>
			<td width="3%" class="text-center"><a title="Delete" href="javascript:void(0);" onclick="delete_resume('<?php echo $data->EduId;?>')"><i class="fa fa-trash-o big-icon"></i></a></td>
		</tr>
	<?php $no++; }	?>
	</tbody>
</table>