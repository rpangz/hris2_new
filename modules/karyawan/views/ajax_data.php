<?php 

echo $_POST['id'];
$id = $_POST['id'];

include('application/models/detail_form_model');

$this->load->model('detail_form_model');
echo $this->detail_form_model->detail_form_cuti($form_id=$id,$company_id= NULL,$session_id=NULL,$level_id=NULL);

?>