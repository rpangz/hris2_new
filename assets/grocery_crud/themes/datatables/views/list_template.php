<?php

	$this->set_css($this->default_theme_path.'/datatables/css/demo_table_jui.css');
	$this->set_css($this->default_css_path.'/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS);
	$this->set_css($this->default_theme_path.'/datatables/css/datatables.css');
	$this->set_css($this->default_theme_path.'/datatables/css/jquery.dataTables.css');
	$this->set_css($this->default_theme_path.'/datatables/extras/TableTools/media/css/TableTools.css');
	$this->set_js_lib($this->default_javascript_path.'/'.grocery_CRUD::JQUERY);

	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
	$this->set_js_lib($this->default_javascript_path.'/common/lazyload-min.js');

	if (!$this->is_IE7()) {
		$this->set_js_lib($this->default_javascript_path.'/common/list.js');
	}

	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/ui/'.grocery_CRUD::JQUERY_UI_JS);
	$this->set_js_lib($this->default_theme_path.'/datatables/js/jquery.dataTables.min.js');
	$this->set_js($this->default_theme_path.'/datatables/js/datatables-extras.js');
	$this->set_js($this->default_theme_path.'/datatables/js/datatables.js');
	$this->set_js($this->default_theme_path.'/datatables/js/jquery.highlight.js');


	$this->set_js($this->default_theme_path.'/datatables/extras/TableTools/media/js/ZeroClipboard.js');
	$this->set_js($this->default_theme_path.'/datatables/extras/TableTools/media/js/TableTools.min.js');

	/** Fancybox */
	$this->set_css($this->default_css_path.'/jquery_plugins/fancybox/jquery.fancybox.css');
	$this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.fancybox-1.3.4.js');
	$this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.easing-1.3.pack.js');
?>
<script type='text/javascript'>
	var base_url = '<?php echo base_url();?>';
	var subject = '<?php echo $subject?>';

	var unique_hash = '<?php echo $unique_hash; ?>';

	var displaying_paging_string = "<?php echo str_replace( array('{start}','{end}','{results}'),
		array('_START_', '_END_', '_TOTAL_'),
		$this->l('list_displaying')
	   ); ?>";
	var filtered_from_string 	= "<?php echo str_replace('{total_results}','_MAX_',$this->l('list_filtered_from') ); ?>";
	var show_entries_string 	= "<?php echo str_replace('{paging}','_MENU_',$this->l('list_show_entries') ); ?>";
	var search_string 			= "<?php echo $this->l('list_search'); ?>";
	var list_no_items 			= "<?php echo $this->l('list_no_items'); ?>";
	var list_zero_entries 			= "<?php echo $this->l('list_zero_entries'); ?>";

	var list_loading 			= "<?php echo $this->l('list_loading'); ?>";

	var paging_first 	= "<?php echo $this->l('list_paging_first'); ?>";
	var paging_previous = "<?php echo $this->l('list_paging_previous'); ?>";
	var paging_next 	= "<?php echo $this->l('list_paging_next'); ?>";
	var paging_last 	= "<?php echo $this->l('list_paging_last'); ?>";

	var message_alert_delete = "<?php echo $this->l('alert_delete'); ?>";

	var default_per_page = <?php echo $default_per_page;?>;

	var unset_export = <?php echo ($unset_export ? 'true' : 'false'); ?>;
	var unset_print = <?php echo ($unset_print ? 'true' : 'false'); ?>;

	var export_text = '<?php echo $this->l('list_export');?>';
	var print_text = '<?php echo $this->l('list_print');?>';



	<?php
	//A work around for method order_by that doesn't work correctly on datatables theme
	//@todo remove PHP logic from the view to the basic library
	$ordering = 0;
	$sorting = 'asc';
	if(!empty($order_by))
	{
		foreach($columns as $num => $column) {
			if($column->field_name == $order_by[0]) {
				$ordering = $num;
				$sorting = isset($order_by[1]) && $order_by[1] == 'asc' || $order_by[1] == 'desc' ? $order_by[1] : $sorting ;
			}
		}
	}
	?>

	var datatables_aaSorting = [[ <?php echo $ordering; ?>, "<?php echo $sorting;?>" ]];

</script>

<script type="text/javascript">

$(function() {

	var search = $('.groceryCrudTable tfoot input'),
		content = $('.display'),
		matches = $(), index = 0;

	// Listen for the text input event
	search.on('input', function(e) {

		// Only search for strings 2 characters or more
		if (search.val().length >= 2) {
			
            
            
			// Use the highlight plugin
			content.highlight(search.val(), function(found) {                
                found.parent().parent().css('background','yellow');
			});
		}
		else {
			content.highlightRestore();
		}

	});
	
});

(function($) {

	var termPattern;

	$.fn.highlight = function(term, callback) {

		return this.each(function() {

			var elem = $(this);

			if (!elem.data('highlight-original')) {
				
				// Save the original element content
				elem.data('highlight-original', elem.html());
				
			} else {
				
				// restore the original content
				elem.highlightRestore();
				
			}

			termPattern = new RegExp('(' + term + ')', 'ig');

			// Search the element's contents
			walk(elem);

			// Trigger the callback
			callback && callback(elem.find('.match'));

		});
	};

	$.fn.highlightRestore = function() {
		
		return this.each(function() {
			var elem = $(this);
			elem.html(elem.data('highlight-original'));
		});
		
	};

	function walk(elem) {

		elem.contents().each(function() {

			if (this.nodeType == 3) { // text node

				if (termPattern.test(this.nodeValue)) {
					$(this).replaceWith(this.nodeValue.replace(termPattern, '<span class="match">$1</span>'));
				}
			} else {
				walk($(this));
			}
		});
	}

})(jQuery); 
</script>

<style type="text/css">

span.match{
 	background-color:#f8dda9;
 	border:1px solid #edd19b;
 	margin:-1px;
	color:#390705;
}

</style>


<?php
	if(!empty($actions)){
?>
	<style type="text/css">
		<?php foreach($actions as $action_unique_id => $action){?>
			<?php if(!empty($action->image_url)){ ?>
				.<?php echo $action_unique_id; ?>{
					background: url('<?php echo $action->image_url; ?>') !important;
				}
			<?php }?>
		<?php }?>
	</style>
<?php
	}
?>
<?php if($unset_export && $unset_print){?>
<style type="text/css">
	.datatables-add-button
	{
		position: static !important;
	}
</style>
<?php }?>
<div id='list-report-error' class='report-div error report-list'></div>
<div id='list-report-success' class='report-div success report-list' <?php if($success_message !== null){?>style="display:block"<?php }?>><?php
 if($success_message !== null){?>
	<p><?php echo $success_message; ?></p>
<?php }
?></div>
<?php if(!$unset_add){?>
<div class="datatables-add-button">
<a role="button" class="add_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" href="<?php echo $add_url?>">
	<span class="ui-button-icon-primary ui-icon ui-icon-circle-plus"></span>
	<span class="ui-button-text"><?php echo $this->l('list_add'); ?> <?php echo $subject?></span>
</a>
</div>
<?php }?>
<div style='height:10px;'></div>
<div class="dataTablesContainer">
	<?php echo $list_view?>
</div>