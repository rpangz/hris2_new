<?php


//Include database connection
if($_POST['rowid']) {
    $id = $_POST['rowid']; //escape string
    

     $this->load->model('detail_form_model');
     $this->detail_form_model->data_form_cuti($form_id = $id,$company_id=NULL,$session_id=NULL,$level_id=NULL);

 }

?>