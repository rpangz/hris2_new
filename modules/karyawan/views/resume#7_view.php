<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>


<?php

switch ($state) {
    case "list":

?>
<div class="box-tools pull-right">                
    <a href="javascript:void(0);" onclick="add_resume('7')" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus-circle big-icon"></i> Tambah Data</a>
</div>
<table width="100%" class="table table-hover table-striped" style="font-size: 12px;">
	<thead>
	<tr>
	    <th class="text-center" width="5%">No</th>
	    <th class="text-center" width="10%">Date</th>
	    <th class="text-center" width="20%">Project</th>
	    <th class="text-left" width="10%">Institution</th>
	    <th class="text-left" width="5%">Year</th>
	    <th class="text-left" width="5%">Length</th>
	    <th class="text-left">Description</th>
	    <th class="text-left" width="10%">Position in Project</th>
	    <th width="9%" colspan="3" class="text-center">Action</th>
	</tr>
	</thead>

	<tbody>
	<?php
	$no = 1;
	foreach ($result as $key => $data) { ?>
		<tr>			
			<td class="text-center"><?php echo $no;?></td>
			<td class="text-center"><?php echo $data->Tanggal;?></td>
			<td class="text-left"><?php echo $data->ProjectName;?></td>
			<td class="text-left"><?php echo $data->ProjectInstitution;?></td>
			<td class="text-left"><?php echo $data->ProjectYear;?></td>
			<td class="text-left"><?php echo $data->ProjectLength;?></td>
			<td class="text-left"><?php echo $data->ProjectTechnicalSpec;?></td>
			<td class="text-left"><?php echo $data->ProjectPosition;?></td>			
			<?php
			if (!empty($data->ProjectFileUrl) && !is_null($data->ProjectFileUrl)){ ?>
				<td width="3%" class="text-center"><a title="Unduh Lampiran" target="_blank" href="<?php echo $file_path.'/'.$data->ProjectFileUrl;?>"><i class="fa fa-paperclip big-icon"></i></a></td>
			<?php }
			else{ ?>
				<td class="text-center"></td>
			<?php } ?>
			<td width="3%" class="text-center"><a title="Edit" href="javascript:void(0);" onclick="edit_resume('<?php echo $data->ProjectId;?>','7')"><i class="fa fa-pencil-square-o big-icon"></i></a></td>
			<td width="3%" class="text-center"><a title="Delete" href="javascript:void(0);" onclick="delete_resume('<?php echo $data->ProjectId;?>')"><i class="fa fa-trash-o big-icon"></i></a></td>
		</tr>
	<?php $no++; }	?>
	</tbody>
</table>
<?php 
	break;

	case "add": case "edit": ?>


	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Project History</h4>
    </div>

    <form action="#" id="form" method="post" class="form-horizontal">

    <input type="hidden" name="ProjectId" value="<?php echo $result->ProjectId;?>" />
    <div class="modal-body form">

	<div class="form-group">
        <label class="control-label col-md-4">Due Date*</label>
        <div class="col-md-8">
            <input name="ProjectDate" placeholder="dd/mm/yyyy" value="<?php echo $tanggal;?>" class="form-control datepicker-input" type="text">
            <span class="help-block"></span>
        </div>
                           
    </div>
    <div class="form-group">
        <label class="control-label col-md-4">Project*</label>
        <div class="col-md-8">                     
            <input type="text" name="ProjectName" placeholder="Nama Project" value="<?php echo $result->ProjectName;?>" class="form-control">
            <span class="help-block"></span>
        </div>                            
    </div>

    <div class="form-group">
        <label class="control-label col-md-4">Institution*</label>
        <div class="col-md-8">                     
            <input name="ProjectInstitution" placeholder="Penyelenggara" value="<?php echo $result->ProjectInstitution;?>" class="form-control" type="text">
            <span class="help-block"></span>
        </div>                            
    </div>

    <div class="form-group">
        <label class="control-label col-md-4"></label>
        <div class="col-md-4">
            <label class="control-label">Year*</label>
            <input name="ProjectYear" placeholder="Tahun" class="form-control numeric" value="<?php echo $result->ProjectYear;?>" type="text">
            <span class="help-block"></span>
        </div>

        <div class="col-md-4">
           	<label class="control-label">Length*</label>
            <input name="ProjectLength" placeholder="Lama Project" class="form-control" value="<?php echo $result->ProjectLength;?>" type="text">
            <span class="help-block"></span>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-4">Technical Spec*</label>
        <div class="col-md-8">
            <textarea name="ProjectTechnicalSpec" placeholder="Deskripsi" class="form-control"><?php echo $result->ProjectTechnicalSpec;?></textarea>
            <span class="help-block"></span>
        </div>
    </div>

	<div class="form-group">
        <label class="control-label col-md-4">Position in Project*</label>
        <div class="col-md-8">                     
            <input name="ProjectPosition" value="<?php echo $result->ProjectPosition;?>" placeholder="Posisi anda dalam project" class="form-control" type="text">
            <span class="help-block"></span>
        </div>                            
    </div>

    <div class="form-group" id="photo-preview">
        <label class="control-label col-md-4">Evidence</label>
        <div class="col-md-8">
        (No Evidence)
        <span class="help-block"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4" id="label-photo">Upload Evidence (max 1 M)</label>
        <div class="col-md-8">
            <input name="file_evidence" type="file">
            <span class="help-block"></span>
        </div>
    </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-flat pull-left" onclick="save_resume(7)"><i class="fa fa-floppy-o"></i> Simpan</button>
        <button type="button" class="btn btn-default btn-flat pull-right" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
    </div>
    </form>

<?php
	break;

	case "edit":
?>

 <p>Edit</p>

<?php 

	break;

}
?>

