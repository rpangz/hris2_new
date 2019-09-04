<?php

	$this->set_css($this->default_theme_path.'/flexigrid/css/flexigrid.css');
	$this->set_js_lib($this->default_theme_path.'/flexigrid/js/jquery.form.js');
	$this->set_js_config($this->default_theme_path.'/flexigrid/js/flexigrid-edit.js');

	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
?>
<div class="flexigrid crud-form" style='width: 100%;' data-unique-hash="<?php echo $unique_hash; ?>">
	<div class="mDiv">
		<div class="ftitle">
			<div class='ftitle-left'>
				<?php echo $this->l('form_edit'); ?> <?php echo $subject?>
			</div>
			<div class='clear'></div>
		</div>
		<div title="<?php echo $this->l('minimize_maximize');?>" class="ptogtitle">
			<span></span>
		</div>
	</div>
<div id='main-table-box'>
	<?php echo form_open( $update_url, 'method="post" id="crudForm" autocomplete="off" enctype="multipart/form-data"'); ?>
	<div class='form-div'>
		<?php
		$counter = 0;
			foreach($fields as $field)
			{
				$even_odd = $counter % 2 == 0 ? 'odd' : 'even';
				$counter++;
		?>
			<div class='form-field-box <?php echo $even_odd?>' id="<?php echo $field->field_name; ?>_field_box">
				<div class='form-display-as-box' id="<?php echo $field->field_name; ?>_display_as_box">
					<?php echo $input_fields[$field->field_name]->display_as?><?php echo ($input_fields[$field->field_name]->required)? "<span class='required'>*</span> " : ""?> :
				</div>
				<div class='form-input-box' id="<?php echo $field->field_name; ?>_input_box">
					<?php echo $input_fields[$field->field_name]->input?>
				</div>
				<div class='clear'></div>
			</div>
		<?php }?>
		<?php if(!empty($hidden_fields)){?>
		<!-- Start of hidden inputs -->
			<?php
				foreach($hidden_fields as $hidden_field){
					echo $hidden_field->input;
				}
			?>
		<!-- End of hidden inputs -->
		<?php }?>
		<?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php }?>
		<div id='report-error' class='report-div error'></div>
		<div id='report-success' class='report-div success'></div>
	</div>
	<div class="pDiv">
		<div class='form-button-box'>
			<input  id="form-button-save" type='submit' value='<?php echo $this->l('form_update_changes'); ?>' class="btn btn-large"/>
		</div>
<?php 	if(!$this->unset_back_to_list) { ?>
		<div class='form-button-box'>
			<input type='button' value='<?php echo $this->l('form_update_and_go_back'); ?>' id="save-and-go-back-button" class="btn btn-large"/>
		</div>
		<div class='form-button-box'>
			<input type='button' value='<?php echo $this->l('form_cancel'); ?>' class="btn btn-large" id="cancel-button" />
		</div>
<?php 	} ?>

<?php 	if(!$this->unset_delete) { 

		//$url = $_SERVER['REQUEST_URI'];

		$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		//echo $url;

		$parsed = parse_url($url);
		$path = $parsed['path'];
		$path_parts = explode('/', $path);
		
		$segment1 = $path_parts[1];
		$segment2 = $path_parts[2];
		$segment3 = $path_parts[3];
		$segment4 = $path_parts[4];
		$segment5 = $path_parts[5];
		$segment6 = $path_parts[6];
		//$segment7 = $path_parts[7]; 


		//$array = array (var_dump(parse_url($url)));

		//echo $array[];

		?>

		<!--	

		<div class='form-button-box2'>


		<form><input id="form-button-save" type='button' value='<?php //echo $this->l('list_delete');?>' onclick="window.location.href='<?php //echo 'http://astapp02/'.$segment1.'/'.$segment2.'/'.$segment3.'/'.$segment4.'/delete/'.$segment6 ?>'" class='btn btn-large'/></form>	

		</div>	
		
			
			<a href="http://www.google.com" ><button id="form-button-save" class='btn btn-large'><?php //echo $this->l('list_delete')?></button></a>
			
			<form><input id="form-button-save" type='button' value='<?php //echo $this->l('list_delete')?>' onclick="window.location.href='"<?php //.site_url($this->cms_module_path().'/assets/index/'.$this->uri->segment('4').'/delete/'.$this->uri->segment('6')); ?>"'" class="btn btn-large"/></form>
			<a href="http://www.google.com" target="_parent"><button>Click me !</button></a>
			<input  id="form-button-save" type='button' value='<?php //echo $this->l('list_delete')?>' class="btn btn-large"/>
		

		-->
		
<?php 	} ?>



		<div class='form-button-box'>
			<div class='small-loading' id='FormLoading'><?php echo $this->l('form_update_loading'); ?></div>
		</div>





		<div class='clear'></div>
	</div>
	<?php echo form_close(); ?>
</div>
</div>
<script>
	var validation_url = '<?php echo $validation_url?>';
	var list_url = '<?php echo $list_url?>';

	var message_alert_edit_form = "<?php echo $this->l('alert_edit_form')?>";
	var message_update_error = "<?php echo $this->l('update_error')?>";
</script>