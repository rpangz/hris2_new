<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mailer_karyawan_model extends CI_Model {

	public function __construct(){
		parent::__construct();
        $this->load->helper('url');
        $this->load->model('karyawan_model');
	}


	public function kirim_email_update_resume($primary_key, $user_name, $user_email){
       
    	require_once (APPPATH.'libraries/class.phpmailer.php');

      $base_url_img = $this->config->item('base_url_img');

      $profile        = $this->karyawan_model->employee_profile($primary_key);
      $education      = $this->karyawan_model->education_profile($primary_key);
      $project        = $this->karyawan_model->project_profile($primary_key);
      $working        = $this->karyawan_model->working_profile($primary_key);
      $skill          = $this->karyawan_model->skill_profile($primary_key);
      $training       = $this->karyawan_model->training_profile($primary_key);
      $certification  = $this->karyawan_model->certification_profile($primary_key);


      if($profile['Photos'] =='' || is_null($profile['Photos']) || is_null($profile['Photos'])){
        $avatar = $base_url_img.'assets/images/avatar/default.png';
      }
      else{
        $avatar = $base_url_img.'assets/uploads/files/'.$profile['Photos'];
      }

		
		try {

		$mail = new PHPMailer(true);

		  $body =
		  '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Responsive Email Template</title>
                                                                                                                                                                                                                                                                                                                                                                                                        
<style type="text/css">
    .ReadMsgBody {width: 100%; background-color: #ffffff;}
    .ExternalClass {width: 100%; background-color: #ffffff;}
    body     {width: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;font-family: Arial, Helvetica, sans-serif}
    table {border-collapse: collapse;}
    
    @media only screen and (max-width: 640px)  {
                    body[yahoo] .deviceWidth {width:440px!important; padding:0;}    
                    body[yahoo] .center {text-align: center!important;}  
            }
            
    @media only screen and (max-width: 479px) {
                    body[yahoo] .deviceWidth {width:280px!important; padding:0;}    
                    body[yahoo] .center {text-align: center!important;}  
            }
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix" style="font-family: Arial, Helvetica, sans-serif">

<!-- Wrapper -->
<table width="100%"  border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td width="100%" valign="top">
            <!--Start Header-->
            <table width="700" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                <tr>
                    <td style="padding: 6px 0px 0px">
                        <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                            <tr>
                                <td width="100%" >
                                    <!--Start logo-->
                                    <table  border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                                        <tr>
                                            <td class="center" style="padding: 20px 0px 10px 0px">
                                                <a href="#"><img width="230" height="35" src="'.$base_url_img.'assets/nocms/images/custom_logo/astel_group.png'.'" alt="Logo Perusahaan"></a>
                                            </td>
                                        </tr>
                                    </table><!--End logo-->                                    
                                </td>
                            </tr>
                        </table>
                   </td>
                </tr>
            </table>

            <!--Start Top Block-->
            <table width="100%" bgcolor="#3498db" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                <tr>
                    <td>
                        <table width="700" bgcolor="#3498db" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                            <tr>
                                <td width="100%">
                                    <table width="29%"  border="0" cellpadding="0" cellspacing="0" align="right" class="deviceWidth">
                                        <tr>
                                            <td valign="top" style="padding: 50px 20px 0px; " class="center">
                                             <a href="#"><img class="deviceWidth" width="150" height="150" src="'.$avatar.'" alt="User Picture"></a>
                                            </td>
                                        </tr>                                     
                                    </table> <!--End Right box--> 
                                    <!--Left box-->
                                    <table width="69%"  border="0" cellpadding="0" cellspacing="0"  class="deviceWidth">
                                        <tr>
                                            <td valign="middle">
                                                <table  border="0" cellpadding="0" cellspacing="0" > 
                                                    <tr>
                                                        <td colspan="2" class="center" style="font-size: 16px; color: #ffffff; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 50px 2px 0 2px;width:100% ">
                                                            HUMAN RESOURCE INFORMATION SYSTEM ASTEL & GROUP                              
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="center" style="font-size: 12px; color: #ffffff; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px ;width:30% " >
                                                           &nbsp;NIK 
                                                       </td>
                                                       <td class="center" style="font-size: 12px; color: #ffffff; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px ;width:70% " >
                                                           '.$profile['NIK'].' 
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="center" style="font-size: 12px; color: #ffffff; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px ; " >
                                                           &nbsp;Nama 
                                                       </td>
                                                       <td class="center" style="font-size: 12px; color: #ffffff; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px ; " >
                                                           '.$profile['Nama'].' 
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="center" style="font-size: 12px; color: #ffffff; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px ; " >
                                                           &nbsp;Perusahaan 
                                                       </td>
                                                       <td class="center" style="font-size: 12px; color: #ffffff; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px ; " >
                                                           '.$profile['cCompanyName'].' 
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="center" style="font-size: 12px; color: #ffffff; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px ; " >
                                                           &nbsp;Divisi 
                                                       </td>
                                                       <td class="center" style="font-size: 12px; color: #ffffff; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px ; " >
                                                           '.$profile['cDivName'].' 
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="center" style="font-size: 12px; color: #ffffff; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px ; " >
                                                           &nbsp;Departemen 
                                                       </td>
                                                       <td class="center" style="font-size: 12px; color: #ffffff; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px ; " >
                                                           '.$profile['cDeptName'].' 
                                                       </td>
                                                    </tr>
                                                </table>                                                
                                            </td>
                                         </tr>
                                    </table><!--End Left box-->
                                    <!-- Right box  -->
                                </td>
                            </tr>
                        </table>
                        <!--Start Discount -->
                        <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                            <tr>
                                <td width="100%" bgcolor="#3498db">
                                    <!-- Left Box  -->
                                    <table width="100%"  border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                                        <tr>
                                            <td class="center" style="font-size: 16px; color: #ffffff; font-weight: bold; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 20px 20px 20px ;">
                                                RESUME CV                           
                                            </td>                   
                                        </tr>
                                    </table>                                  
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>        


            <!-- Start Middle Block -->
            <table width="700" bgcolor="#f7f7f7" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                <tr>
                    <td width="100%" bgcolor="#f7f7f7" class="center" style="font-size: 16px; color: #687074; font-weight: bold; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 20px; vertical-align: middle; padding: 40px 0px 20px;">
                        EDUCATION              
                    </td>
                </tr>
                <tr>
                    <td>
                        <!--Start Two Pictures-->
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">';

                        foreach ($education as $key => $value) {
                          if(is_null($value->EduFileUrl) || empty($value->EduFileUrl) || $value->EduFileUrl == ''){
                              $lampiran = '';
                          }else{
                              $lampiran = '<a href="'.site_url('modules/karyawan/assets/uploads/'.$value->EduFileUrl).'" target="_blank" title="download file"><img class="deviceWidth" width="12" height="12" src="'.$base_url_img.'assets/images/download-icn.png'.'" alt="Attachment"></a>';
                          }

                          $bgcolor = "";
                          if($value->checking=="TIDAK SAMA"){
                             $bgcolor =  "yellow";
                          } else  {
                             $bgcolor =  "#f7f7f7";
                          }


                          $body .= '<tr>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:15%">&nbsp;'.$value->EduStart.' ~ '.$value->EduFinish.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:15%">'.$value->EducationLevelName.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:45%">'.$value->EduInstitution.' '.$value->EduCity.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:20%">'.$value->EduFaculty.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:5%">'.$lampiran.'</td>
                                    </tr>';                          
                          }

                        $body .= '</table>
                        <!--End Two Pictures-->
                    </td>
                </tr>
                <tr>
                    <td  class="center" style="font-size: 16px; color: #687074; font-weight: bold; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 40px 0px 20px; ">
                        WORKING EXPERIENCE 
                   </td>
                </tr>
                <tr>
                    <td width="100%" bgcolor="#f7f7f7" >
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">';
                        foreach ($working as $key => $value) {
                          if(is_null($value->WorkExpFileUrl) || empty($value->WorkExpFileUrl) || $value->WorkExpFileUrl == ''){
                              $lampiran = '';
                          }else{
                              $lampiran = '<a href="'.site_url('modules/karyawan/assets/uploads/'.$value->WorkExpFileUrl).'" target="_blank" title="download file"><img class="deviceWidth" width="12" height="12" src="'.$base_url_img.'assets/images/download-icn.png'.'" alt="Attachment"></a>';
                          }

                          if($value->WorkExpUntilNow == 1){
                              $WorkExpFinish         = 'Sekarang';
                          }
                          else{
                              $WorkExpFinish         = $this->basic_date_format($value->WorkExpFinish);
                          }

                          $bgcolor = "";
                          if($value->checking=="TIDAK SAMA"){
                             $bgcolor =  "yellow";
                          } else  {
                             $bgcolor =  "#f7f7f7";
                          }


                          $body .= '<tr>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:25%">&nbsp;'.$this->basic_date_format($value->WorkExpStart).' ~ '.$WorkExpFinish.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:35%">'.$value->WorkExpCompany.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:35%">'.$value->WorkExpDesc.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:5%">'.$lampiran.'</td>
                                    </tr>';                          
                          }

                        $body .= '</table>           
                          
                    </td>
                </tr>

                <tr>
                    <td  class="center" style="font-size: 16px; color: #687074; font-weight: bold; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 40px 0px 20px; ">
                        TRAINING 
                   </td>
                </tr>
                <tr>
                    <td width="100%" bgcolor="#f7f7f7" >
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">';
                        foreach ($training as $key => $value){
                          if(is_null($value->TrainingFileUrl) || empty($value->TrainingFileUrl) || $value->TrainingFileUrl == ''){
                              $lampiran = '';
                          }else{
                              $lampiran = '<a href="'.site_url('modules/karyawan/assets/uploads/'.$value->TrainingFileUrl).'" target="_blank" title="download file"><img class="deviceWidth" width="12" height="12" src="'.$base_url_img.'assets/images/download-icn.png'.'" alt="Attachment"></a>';
                          }

                          $bgcolor = "";
                          if($value->checking=="TIDAK SAMA"){
                             $bgcolor =  "yellow";
                          } else  {
                             $bgcolor =  "#f7f7f7";
                          }  

                          $body .= '<tr>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:15%"> '.$value->TrainingYear.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:45%">'.$value->TrainingModul.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:35%">'.$value->TrainingInstitution.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:5%">'.$lampiran.'</td>
                                    </tr>';                          
                          }

                        $body .= '</table>           
                          
                    </td>
                </tr>


                <tr>
                    <td  class="center" style="font-size: 16px; color: #687074; font-weight: bold; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 40px 0px 20px; ">
                        TECHNICAL SKILLS 
                   </td>
                </tr>
                <tr>
                    <td width="100%" bgcolor="#f7f7f7" >
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">';
                        foreach ($skill as $key => $value) {
                          if(is_null($value->TechnicalSkillFileUrl) || empty($value->TechnicalSkillFileUrl) || $value->TechnicalSkillFileUrl == ''){
                              $lampiran = '';
                          }else{
                              $lampiran = '<a href="'.site_url('modules/karyawan/assets/uploads/'.$value->TechnicalSkillFileUrl).'" target="_blank" title="download file"><img class="deviceWidth" width="12" height="12" src="'.$base_url_img.'assets/images/download-icn.png'.'" alt="Attachment"></a>';
                          }

                          $bgcolor = "";
                          if($value->checking=="TIDAK SAMA"){
                             $bgcolor =  "yellow";
                          } else  {
                             $bgcolor =  "#f7f7f7";
                          }  

                          $body .= '<tr>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:35%">'.$value->TechnicalSkillName.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:60%">'.$value->TechnicalSkillDesc.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:5%">'.$lampiran.'</td>
                                    </tr>';                          
                        }

                        $body .= '</table>           
                          
                    </td>
                </tr>


                <tr>
                    <td  class="center" style="font-size: 16px; color: #687074; font-weight: bold; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 40px 0px 20px; ">
                        PROJECT 
                   </td>
                </tr>
                <tr>
                    <td width="100%" bgcolor="#f7f7f7" >
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">';
                        foreach ($project as $key => $value){
                          if(is_null($value->ProjectFileUrl) || empty($value->ProjectFileUrl) || $value->ProjectFileUrl == ''){
                              $lampiran = '';
                          }else{
                              $lampiran = '<a href="'.site_url('modules/karyawan/assets/uploads/'.$value->ProjectFileUrl).'" target="_blank" title="download file"><img class="deviceWidth" width="12" height="12" src="'.$base_url_img.'assets/images/download-icn.png'.'" alt="Attachment"></a>';
                          }

                          $bgcolor = "";
                          if($value->checking=="TIDAK SAMA"){
                             $bgcolor =  "yellow";
                          } else  {
                             $bgcolor =  "#f7f7f7";
                          }

                          $body .= '<tr>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:10%">&nbsp;'.$value->ProjectYear.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:25%">'.$value->ProjectName.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:25%">'.$value->ProjectInstitution.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:35%">'.$value->ProjectTechnicalSpec.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:5%">'.$lampiran.'</td>
                                    </tr>';                          
                          }

                        $body .= '</table>           
                          
                    </td>
                </tr>
                <tr>
                    <td  class="center" style="font-size: 16px; color: #687074; font-weight: bold; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 40px 0px 20px; ">
                        CERTIFICATION 
                   </td>
                </tr>
                <tr>
                    <td width="100%" bgcolor="#f7f7f7" >
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">';

                        foreach ($certification as $key => $value){
                          if(is_null($value->CertFileUrl) || empty($value->CertFileUrl) || $value->CertFileUrl == ''){
                              $lampiran = '';
                          }else{
                              $lampiran = '<a href="'.site_url('modules/karyawan/assets/uploads/'.$value->CertFileUrl).'" target="_blank" title="download file"><img class="deviceWidth" width="12" height="12" src="'.$base_url_img.'assets/images/download-icn.png'.'" alt="Attachment"></a>';
                          }

                          $bgcolor = "";
                          if($value->checking=="TIDAK SAMA"){
                             $bgcolor =  "yellow";
                          } else  {
                             $bgcolor =  "#f7f7f7";
                          }

                          $body .= '<tr>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:25%">&nbsp;'.$this->basic_date_format($value->CertValidStart).' ~ '.$this->basic_date_format($value->CertValidFinish).'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:15%">'.$value->CertProduct.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:30%">'.$value->CertPartnerName.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:15%">'.$value->CertItemName.'</td>
                                      <td bgcolor="'.$bgcolor.'" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:5%">'.$lampiran.'</td>
                                    </tr>';
                          
                        }

                        $body .= '<tr>
                                      <td colspan="4" bgcolor="#f7f7f7" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 100%; vertical-align: middle; padding: 2px; width:100%">&nbsp;</td>
                                    </tr>';

                        $body .= '</table>           
                          
                    </td>
                </tr>

            </table>
            <!-- End Middle Block -->

            <!--Start Bottom Block-->
            <table width="100%" bgcolor="#3498db" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                <tr>
                    <td>
                         <table width="700" bgcolor="#3498db" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                            <tr>
                                <td>
                                    <!-- Left box  -->
                                    <table width="40%"  border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">
                                        <tr>
                                            <td valign="top" style="padding: 20px 20px 0px; " class="center">
                                                <a href="#"><img class="deviceWidth" width="90" height="90" src="'.$base_url_img.'assets/images/Resume-512.png'.'" alt="Resume Campaign"></a>
                                            </td>
                                        </tr>
                                    </table> <!--End left box--> 
                                    <!--Right box-->
                                    <table width="49%"  border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                                        <tr>
                                            <td class="center">
                                                <table  border="0" cellpadding="0" cellspacing="0" align="center"> 
                                                    <tr>
                                                        <td class="center" style="font-size: 16px; color: #ffffff; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 20px; vertical-align: middle; padding: 20px 5px 0; ">
                                                             Stay Yours Resume Updated...                              
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="center" style="font-size: 12px; color: #ffffff; font-weight: bold; text-align: left; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 20px 5px; " >
                                                            Perbaharui Resume anda setiap saat, sehingga dapat digunakan untuk keperluan perusahaan.
                                                       </td>
                                                    </tr>
                                                </table>                                                
                                            </td>
                                        </tr>
                                    </table><!--End right box-->
                                </td>
                            </tr>
                        </table>                        
                    </td>
                </tr>                
            </table>
            <!--End Bottom Block  -->  
            
            <!-- Footer -->
            <table width="700" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                <tr>
                    <td>
                        <table width="700"  border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                            <tr>
                                <td class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 20px; vertical-align: middle; padding: 30px 10px 0px; " >
                                     Perhatian email ini dikirim secara otomatis dari System. Jangan membalas ke alamat ini.                       
                                </td>
                            </tr>                             
                            <tr>
                                <td class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 20px; vertical-align: middle; padding: 10px 50px 30px; " >
                                    Powered By M.I.S, All Rights Reserved                            
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--End Footer-->
            <div style="height:15px">&nbsp;</div><!-- divider -->
          
        </td>
    </tr>
</table> 
<!-- End Wrapper -->
</body>
</html>';
	
	
		$mail->IsSMTP();
		$mail->Mailer     	= "smtp";
		$mail->Port       	=  25;
		$mail->SMTPKeepAlive= true;
		$mail->SMTPAuth     = true;
		$mail->Priority     = 1;
		$mail->From         = "HRIS";
		$mail->FromName     = "HRIS";
		$mail->SetFrom('hris.noreply@unias.com', 'HRIS');
		$to = $user_email;
    $mail->Body         = $body;
		//$to = "dompak.sinambela@unias.com";
		$mail->AddAddress($to);
    //$mail->AddAddress('dompak.sinambela@unias.com');
		$mail->Subject       = "[RESUME CV ".$profile['Nama']."]";
		$mail->AltBody       = "To view the message, please use an HTML compatible email viewer!"; 	
		$mail->WordWrap      = 80;	
		$mail->IsHTML(true);
    //$body = file_get_contents('../../resume_template.php');	
	  //echo $body;
    $mail->Send();	
		
		}
		catch (phpmailerException $e){
			echo $e->errorMessage();
		}   	
		
    }


    public function set_table_data($table_name, $where_column, $result_column, $value){

        $this->db->select($result_column)->from($table_name)->where($where_column, $value);
        $db      = $this->db->get();
        $data    = $db->row(0);
        $num_row = $db->num_rows();

        if ($num_row > 0){
            return $data->$result_column;
        }
        else{
            return '';
        }
    }

    public function basic_date_format($date){

        if (is_null($date) || $date =='0000-00-00' || empty($date)){
            $tanggal = 'N/A';
        }
        else{
            $tanggal = date('d-M-Y', strtotime($date));
        } 

        return $tanggal;
    }

	
	


}