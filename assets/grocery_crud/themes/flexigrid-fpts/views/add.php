<?php

    $this->set_css($this->default_theme_path.'/flexigrid-fpts/css/flexigrid.css');
    $this->set_js_lib($this->default_theme_path.'/flexigrid-fpts/js/jquery.form.js');
    $this->set_js_config($this->default_theme_path.'/flexigrid-fpts/js/flexigrid-add.js');
    $this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
    $this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
    
?>
<div class="crud-form" style='width: 100%;' data-unique-hash="<?php echo $unique_hash; ?>">
    <div class="mDiv">
        <div class="ftitle">
            <div class='ftitle-left'>
                <?php echo $this->l('form_add'); ?> <?php echo $subject?>
            </div>
            <div class='clear'></div>
        </div>
        <div title="<?php echo $this->l('minimize_maximize');?>" class="ptogtitle">
            <span></span>
        </div>
    </div>
<div id='main-table-box'>
    <?php echo form_open( $insert_url, 'method="post" id="crudForm" autocomplete="off" enctype="multipart/form-data"'); ?>
        <div class='form-div'>
            <?php
            $counter = 0;
                foreach($fields as $field)
                {
                    $even_odd = $counter % 2 == 0 ? 'odd' : 'even';
                    $counter++;
            ?>
            
            <?php }?>
            <!-- Start of hidden inputs -->
                <?php
                    foreach($hidden_fields as $hidden_field){
                        echo $hidden_field->input;
                    }
                ?>
            <!-- End of hidden inputs -->
            <?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php }?>

            <div id='report-error' class='report-div error'></div>
            <div id='report-success' class='report-div success'></div>
        </div>
        
    

<script>
    var validation_url = '<?php echo $validation_url?>';
    var list_url = '<?php echo $list_url?>';

    var message_alert_add_form = "<?php echo $this->l('alert_add_form')?>";
    var message_insert_error = "<?php echo $this->l('insert_error')?>";
</script>