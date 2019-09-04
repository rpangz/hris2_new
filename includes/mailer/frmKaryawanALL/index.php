<?php
session_start();
error_reporting(0);

include "../../koneksi/koneksi.php";

$nikki = $_GET['nik'];

$tampil   = mysql_query("SELECT * FROM tbl_profile LEFT JOIN 
      tbl_company ON tbl_profile.CompanyId=tbl_company.iCompanyId LEFT JOIN 
      tbl_div ON tbl_profile.DivisiID=tbl_div.iDivId LEFT JOIN 
      tbl_dept ON tbl_profile.DeptID=tbl_dept.iDeptID LEFT JOIN 
      tbl_unit ON tbl_profile.UnitID=tbl_unit.UnitID LEFT JOIN 
      tbl_section ON tbl_profile.SeksiID = tbl_section.iSectionID LEFT JOIN 
      tbl_statusdiri ON tbl_profile.StatusDiri=tbl_statusdiri.StatusDiriId LEFT JOIN 
      tbl_sex ON tbl_profile.Sex = tbl_sex.SexCode LEFT JOIN 
      tbl_jabatan ON tbl_profile.JobCVId = tbl_jabatan.JabatanId LEFT JOIN 
      tbl_job_fungsional ON tbl_profile.JobId = tbl_job_fungsional.JobFungsionalId LEFT JOIN  
      tbl_agama ON tbl_profile.Agama=tbl_agama.agama_id WHERE NIK=".$nikki);

    $data = mysql_fetch_array($tampil);

    $NIK        = $data['NIK'];
    $Nama       = $data['Nama'];
    $CompanyId  = $data['CompanyId'];
    $process_id = $data['ProcessCVNumber'];

    $TglLahir = date('d-M-Y', strtotime($data['TglLahir']));
    $TglMasuk = date('d-M-Y', strtotime($data['TglMasuk']));

            if (!is_null($data['Photos'])){
                $session_img  = 'assets/uploads/files/'.$data['Photos'];
            }
            else {
                $session_img  = 'assets/uploads/files/default.png';
            }


        //+Calculation age------------------------------------------------------------------------------------- 
        $today1 = date ("Y");
        $today2 = date ("m");
        $today3 = date ("d");

        $time = strtotime($data['TglLahir']);
        $d=date('d', $time);
        $y=date('Y', $time);
        $m=date('m', $time);

        $rr = strtotime($m.'/'.$d.'/'.$today1);


        $lahir      = mktime(0,0,0,$m,$d,$y); //jam,menit,detik,bulan,tanggal,tahun
        $t          = time(); $umur = ($lahir < 0) ? ( $t + ($lahir * -1) ) : $t - $lahir; $tahun = 60 * 60 * 24 * 365; 
        $tahunlahir = $umur / $tahun; 
        $MyAge      = floor($tahunlahir);


function format_tanggal_id($date){
    if (!is_null($date) || !empty($date) || $date != ''){
        $tanggal_id = date('d-M-Y', strtotime($date));
    }
    else{
        $tanggal_id = '-';
    }
    return $tanggal_id;
}

require_once 'class.phpmailer.php'; 

try {

    $mail = new PHPMailer(true);


$css ='

<style type="text/css">
    .box{
        padding: 20px;
        display: none;
        margin-top: 20px;
        border: 1px solid #000;
    }
    
    .autoUpdate{ 
      background: #FFFFCC;
      padding: 20px;
      margin-top: 20px;
        border: 1px solid #000;
        color:#FF0000;
        width: 100%;
      
         }

    label {
        display: block;
        padding-left: 15px;
        text-indent: -15px;
    }
    

html,body,div,span,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,abbr,address,cite,code,del,dfn,em,img,ins,kbd,q,samp,small,strong,sub,sup,var,b,i,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,figcaption,figure,footer,header,hgroup,menu,nav,section,summary,time,mark,audio,video {
border:0;
font:inherit;
font-size:12px;
margin:0;
padding:0;
vertical-align:baseline;
}




article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section {
display:block;
}

html, body {font-family: "arial", helvetica, arial, sans-serif; font-size: 12px; color: #222;}

.clear {clear: both;}

p {
    font-size: 12px;
    line-height: 1.4em;
    margin-bottom: 20px;
    color: #444;
}

#cv {
    width: 100%;
    max-width: 100%;
    background: #f3f3f3;
    margin: 10px auto;
}

.mainDetails {
    padding: 25px 35px;
    border-bottom: 2px solid #cf8a05;
    background: #ededed;
}

#name h1 {
    font-size: 2.5em;
    font-weight: 700;
    font-family: "Arial", Helvetica, Arial, sans-serif;
    margin-bottom: -6px;
}

#name h2 {
    font-size: 2em;
    margin-left: 2px;
    font-family: "Arial", Helvetica, Arial, sans-serif;
}

#mainArea {
    padding: 0 40px;
}

#headshot {
    width: 12.5%;
    float: left;
    margin-right: 30px;
}

#headshot img {
    width: 100%;
    height: auto;
    -webkit-border-radius: 50px;
    border-radius: 50px;
}

#name {
    float: left;
}

#contactDetails {
    float: right;
}

#contactDetails ul {
    list-style-type: none;
    font-size: 12px;
    margin-top: 2px;
}

#contactDetails ul li {
    margin-bottom: 3px;
    color: #444;
}

#contactDetails ul li a, a[href^=tel] {
    color: #444; 
    text-decoration: none;
    -webkit-transition: all .3s ease-in;
    -moz-transition: all .3s ease-in;
    -o-transition: all .3s ease-in;
    -ms-transition: all .3s ease-in;
    transition: all .3s ease-in;
}

#contactDetails ul li a:hover { 
    color: #cf8a05;
}


section {
    border-top: 1px solid #dedede;
    padding: 20px 0 0;
}

section:first-child {
    border-top: 0;
}

section:last-child {
    padding: 20px 0 10px;
}

.sectionTitle {
    float: left;
    width: 15%;
}

.sectionContent {
    float: right;
    width: 85%;
}

.sectionTitle h1 {
    font-family: "Arial", Helvetica, Arial, sans-serif;
    font-style: italic;
    font-size: 1.5em;
    color: #cf8a05;
}

.sectionContent h2 {
    font-family: "Arial", Helvetica, Arial, sans-serif;
    font-size: 12px;
    margin-bottom: -2px;
}

.subDetails {
    font-size: 12px;
    font-style: italic;
    margin-bottom: 3px;
}

.keySkills {
    list-style-type: none;
    -moz-column-count:3;
    -webkit-column-count:3;
    column-count:3;
    margin-bottom: 20px;
    font-size: 1em;
    color: #444;
}

.keySkills ul li {
    margin-bottom: 3px;
}

@media all and (min-width: 602px) and (max-width: 800px) {
    #headshot {
        display: none;
    }
    
    .keySkills {
    -moz-column-count:2;
    -webkit-column-count:2;
    column-count:2;
    }
}

@media all and (max-width: 601px) {
    #cv {
        width: 95%;
        margin: 10px auto;
        min-width: 280px;
    }
    
    #headshot {
        display: none;
    }
    
    #name, #contactDetails {
        float: none;
        width: 100%;
        text-align: center;
    }
    
    .sectionTitle, .sectionContent {
        float: none;
        width: 100%;
    }
    
    .sectionTitle {
        margin-left: -2px;
        font-size: 1.25em;
    }
    
    .keySkills {
        -moz-column-count:2;
        -webkit-column-count:2;
        column-count:2;
    }
}

@media all and (max-width: 480px) {
    .mainDetails {
        padding: 15px 15px;
    }
    
    section {
        padding: 15px 0 0;
    }
    
    #mainArea {
        padding: 0 25px;
    }

    
    .keySkills {
    -moz-column-count:1;
    -webkit-column-count:1;
    column-count:1;
    }
    
    #name h1 {
        line-height: .8em;
        margin-bottom: 4px;
    }
}

@media print {
    #cv {
        width: 100%;
    }
}

@-webkit-keyframes reset {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 0;
    }
}

@-webkit-keyframes fade-in {
    0% {
        opacity: 0;
    }
    40% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

@-moz-keyframes reset {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 0;
    }
}

@-moz-keyframes fade-in {
    0% {
        opacity: 0;
    }
    40% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

@keyframes reset {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 0;
    }
}

@keyframes fade-in {
    0% {
        opacity: 0;
    }
    40% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

.instaFade {
    -webkit-animation-name: reset, fade-in;
    -webkit-animation-duration: 1.5s;
    -webkit-animation-timing-function: ease-in;
    
    -moz-animation-name: reset, fade-in;
    -moz-animation-duration: 1.5s;
    -moz-animation-timing-function: ease-in;
    
    animation-name: reset, fade-in;
    animation-duration: 1.5s;
    animation-timing-function: ease-in;
}

.quickFade {
    -webkit-animation-name: reset, fade-in;
    -webkit-animation-duration: 2.5s;
    -webkit-animation-timing-function: ease-in;
    
    -moz-animation-name: reset, fade-in;
    -moz-animation-duration: 2.5s;
    -moz-animation-timing-function: ease-in;
    
    animation-name: reset, fade-in;
    animation-duration: 2.5s;
    animation-timing-function: ease-in;
}
 
.delayOne {
    -webkit-animation-delay: 0, .5s;
    -moz-animation-delay: 0, .5s;
    animation-delay: 0, .5s;
}

.delayTwo {
    -webkit-animation-delay: 0, 1s;
    -moz-animation-delay: 0, 1s;
    animation-delay: 0, 1s;
}

.delayThree {
    -webkit-animation-delay: 0, 1.5s;
    -moz-animation-delay: 0, 1.5s;
    animation-delay: 0, 1.5s;
}

.delayFour {
    -webkit-animation-delay: 0, 2s;
    -moz-animation-delay: 0, 2s;
    animation-delay: 0, 2s;
}

.delayFive {
    -webkit-animation-delay: 0, 2.5s;
    -moz-animation-delay: 0, 2.5s;
    animation-delay: 0, 2.5s;
}

/* SOCIAL ICONS */
/* ----------------------------------------- */

.social {
    width:180px;
    float:right;
    padding-top:10px;
}

.social ul {
    list-style: none;
}

.social ul li {
    float:left;
    width:21px;
    height:24px;
    margin:0;
    padding:0;
    margin-left:6px;
}




.page{
  max-width: 60em;
  margin: 0 auto;
}
table th,
table td{
  text-align: left;
}
table.layout{
  width: 100%;
  border: 1px solid green;
  border-collapse: collapse;
}




table.display{
  margin: 1em 0;
}
table.display th,
table.display td{
  border: 1px solid #B3BFAA;
  border-collapse: collapse;
  padding: .5em 1em;
}

table.display th{ background: #D5E0CC; font-size: 12px; text-align: center;  }
table.display td{ background: #fff;font-size: 12px;border: 1px solid green;border-collapse: collapse; }

table.responsive-table{
    border: 1px solid #B3BFAA;
  box-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
}

@media (max-width: 30em){
    table.responsive-table{
      box-shadow: none;  
    }
    table.responsive-table thead{
      display: none; 
    }
  table.display th,
  table.display td{
    padding: .5em;
  }
    
  table.responsive-table td:nth-child(1):before{
    content: "Number";
    
  }
  table.responsive-table td:nth-child(2):before{
    content: "Name";
    
  }
  table.responsive-table td:nth-child(1),
  table.responsive-table td:nth-child(2){
    padding-left: 25%;
  }
  table.responsive-table td:nth-child(1):before,
  table.responsive-table td:nth-child(2):before{
    position: absolute;
    left: .5em;
    font-weight: bold;
  }
  
    table.responsive-table tr,
    table.responsive-table td{
        display: block;
    }
    table.responsive-table tr{
        position: relative;
        margin-bottom: 1em;
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
    }
    table.responsive-table td{
        border-top: none;
    }
    table.responsive-table td.organisationnumber{
        background: #D5E0CC;
        border-top: 1px solid #B3BFAA;
    }
    table.responsive-table td.actions{
        position: absolute;
        top: 0;
        right: 0;
        border: none;
        background: none;
    }
}

</style>';


$mail->Body     = $css;

$body1='
<html>
<head>
<title>My CV</title>

</head>       

<body id="top">

<div id="cv" class="instaFade">        
          
    <div class="mainDetails">      
        
        <div id="name">
            <h1 class="quickFade delayTwo">'.$data['Nama'].'</h1>
            <h2 class="quickFade delayThree">'.$data['NamaJabatan'].'</h2>
        </div>
        
        <div id="contactDetails" class="quickFade delayFour">
            <ul>
                <li>Email : '.$data['Email'].'</a></li>
                <li>Mobile: '.$data['Hp'].'</li>
                
            </ul>
        </div>
        <div class="clear"></div>
    </div>
    
    <div id="mainArea" class="quickFade delayFive">
        
        <section>
            <article>
                <div class="sectionTitle">
                    <h1>Personal Profile</h1>
                </div>
                
                <div class="sectionContent">
                    <table width="100%" height="112" border="0" cellpadding="0" cellspacing="1" style="border: 0">
                      <tr>
                        <td width="135"><strong>Name</strong></td>
                        <td width="10">:</td>
                        <td width="250">'.$data['Nama'].'</td>
                        <td width="20">&nbsp;</td>
                        <td width="130"><strong>Age</strong></td>
                        <td width="10">:</td>
                        <td width="250">'.$MyAge.' Year</td>
                      </tr>
                      <tr>
                        <td><strong>NIP</strong></td>
                        <td>:</td>
                        <td>'.$data['NIK'].'</td>
                        <td>&nbsp;</td>
                        <td><strong>Place of birth</strong></td>
                        <td>:</td>
                        <td>'.$data['TptLahir'].'</td>
                      </tr>
                      <tr>
                        <td><strong>Company</strong></td>
                        <td>:</td>
                        <td>'.$data['cCompanyName'].'</td>
                        <td>&nbsp;</td>
                        <td><strong>Date of birth</strong></td>
                        <td>:</td>
                        <td>'.$TglLahir.'</td>
                      </tr>
                      <tr>
                        <td><strong>Division</strong></td>
                        <td>:</td>
                        <td>'.$data['cDivName'].'</td>
                        <td>&nbsp;</td>
                        <td><strong>Domicile Address</strong></td>
                        <td>:</td>
                        <td rowspan="3" valign="top">'.$data['AlamatDomisili'].'</td>
                      </tr>
                      <tr>
                        <td><strong>Job Title Structural</strong></td>
                        <td>:</td>
                        <td>'.$data['NamaJabatan'].'</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><strong>City</strong></td>
                        <td>:</td>
                        <td>Jakarta</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><strong>Job Title fungsional</strong></td>
                        <td>:</td>
                        <td>'.$data['JobFungsionalName'].'</td>
                        <td>&nbsp;</td>
                        <td><strong>ZIP</strong></td>
                        <td>:</td>
                        <td>'.$data['Kodepos'].'</td>
                      </tr>
                      <tr>
                        <td><strong>Joint date</strong></td>
                        <td>:</td>
                        <td>'.$TglMasuk.'</td>
                        <td>&nbsp;</td>
                        <td><strong>Telephone</strong></td>
                        <td>:</td>
                        <td>'.$data['Hp'].'</td>
                      </tr>
                      <tr>
                        <td><strong>Sex</strong></td>
                        <td>:</td>
                        <td>'.$data['SexNameEng'].'</td>
                        <td>&nbsp;</td>
                        <td><strong>Fax</strong></td>
                        <td>:</td>
                        <td>'.$data['Fax'].'</td>
                      </tr>
                    </table>

                    <br/>
                </div>
            </article>
            <div class="clear"></div>
        </section>
        
        
        <section>
            <div class="sectionTitle">
                <h1>Work Experience</h1>
            </div>
            
            <div class="sectionContent">
    <article>
               

    <table class="layout display responsive-table">
    <thead>
        <tr>
            <th>Start Year</th>
            <th>End Year</th>
            <th>Company</th>
            <th>Position</th>
        </tr>
    </thead>
    <tbody>';

$mail->Body     .= $body1;

        $workexp = mysql_query("SELECT * FROM tbl_profile_workexperience WHERE WorkExpNIK=".$nikki." ORDER BY WorkExpStart ASC");

        while ($ws1 = mysql_fetch_array($workexp)){
                $WorkExpStart =date('d-M-Y', strtotime($ws1['WorkExpStart']));
                $WorkExpFinish =date('d-M-Y', strtotime($ws1['WorkExpFinish']));
                    
        $wdu1[$ws1['WorkExpId']]='
        <tr>
            <td class="organisationnumber" width="90px">'.format_tanggal_id($date=$ws1['WorkExpStart']).'</td>
            <td class="organisationname" width="90px">'.format_tanggal_id($date=$ws1['WorkExpFinish']).'</td>
            <td class="organisationname">'.$ws1['WorkExpCompany'].'</td>
            <td class="organisationname">'.$ws1['WorkExpPosition'].'</td>
        </tr>';

        $mail->Body .= $wdu1[$ws1['WorkExpId']];

            }        

       

       

    $body2='</tbody>
</table>

                 </article>
                <br/>               
                
                <article>
                </article>
            </div>
            <div class="clear"></div>
        </section>
        

        <section>
        <div class="sectionTitle">
                <h1>Education</h1>
            </div>
            
            <div class="sectionContent">
              
 
            <table class="layout display responsive-table">
                <thead>
                    <tr>
                        <th>Start Year</th>
                        <th>End Year</th>
                        <th>Institution</th>
                        <th>City</th>
                        <th>Faculty</th>
                        <th width="80px">GPA</th>
                        <th>Major</th>
                    </tr>
                </thead>
                <tbody>';

$mail->Body     .= $body2;

              
                    $education = mysql_query("SELECT * FROM tbl_profile_education WHERE EduNIK=".$nikki." ORDER BY EduStart ASC");

                    while ($ws3 = mysql_fetch_array($education)){
                            
                    $wdu3[$ws3['EduId']]='
                    <tr>
                        <td class="organisationnumber" width="90px">'.$ws3['EduStart'].'</td>
                        <td class="organisationnumber" width="90px">'.$ws3['EduFinish'].'</td>
                        <td class="organisationname">'.$ws3['EduInstitution'].'</td>
                        <td class="organisationname">'.$ws3['EduCity'].'</td>
                        <td class="organisationname">'.$ws3['EduFaculty'].'</td>
                        <td class="organisationname">'.$ws3['EduGPA'].'</td>
                        <td class="organisationname">'.$ws3['EduMajor'].'</td>
                    </tr>';

                    $mail->Body .= $wdu3[$ws3['EduId']];

                 }
                 
                 $body3='</tbody>
            </table>
            <br/>
            </div>
            <div class="clear"></div>
        </section>



        <section>
        <div class="sectionTitle">
                <h1>Training</h1>
            </div>
            
            <div class="sectionContent">
              
 
            <table class="layout display responsive-table">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Institution</th>
                        <th>City</th>
                        <th>Modul</th>
                        <th>Training Type</th>
                    </tr>
                </thead>
                <tbody>';

$mail->Body     .= $body3;

                    $training = mysql_query("SELECT * FROM tbl_profile_training WHERE TrainingNIK=".$nikki." ORDER BY TrainingYear ASC");

                    while ($ws2 = mysql_fetch_array($training)){
                            //$WorkExpStart =date('d-M-Y', strtotime($ws1['WorkExpStart']));
                            //$WorkExpFinish =date('d-M-Y', strtotime($ws1['WorkExpFinish']));
                        $wdu2[$ws2['TrainingId']]='
                
                    <tr>
                        <td class="organisationnumber" width="90px">'.$ws2['TrainingYear'].'</td>
                        <td class="organisationnumber">'.$ws2['TrainingInstitution'].'</td>
                        <td class="organisationname">'.$ws2['TrainingCity'].'</td>
                        <td>'.$ws2['TrainingModul'].'</td>
                        <td>'.$ws2['TrainingType'].'</td>
                    </tr>';

                    $mail->Body .= $wdu2[$ws2['TrainingId']];

                } 

                    


                $body4='</tbody>
            </table>
            <br/>
            </div>
            <div class="clear"></div>
        </section>



        <section>
        <div class="sectionTitle">
                <h1>Technical Skill</h1>
            </div>
            
            <div class="sectionContent">
              
 
            <table class="layout display responsive-table">
                <thead>
                    <tr>
                        <th>Technical Skill</th>
                        <th>Experiences</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>';
$mail->Body     .= $body4;

                
                    $skill = mysql_query("SELECT * FROM tbl_profile_technicalskill WHERE TechnicalSkillNIK=".$nikki." ORDER BY TechnicalSkillId ASC");
                    while ($ws4 = mysql_fetch_array($skill)){
                            
                    $wdu4[$ws4['TechnicalSkillId']]='
                    <tr>
                        <td class="organisationnumber">'.$ws4['TechnicalSkillName'].'</td>
                        <td class="organisationnumber">'.$ws4['TechnicalSkillExp'].'</td>
                        <td class="organisationname">'.$ws4['TechnicalSkillDesc'].'</td>                       
                    </tr>';
                    $mail->Body .= $wdu4[$ws4['TechnicalSkillId']];

                 }                 


                $body5='</tbody>
            </table>
            <br/>
            </div>
            <div class="clear"></div>
        </section>
        
        


        <section>
        <div class="sectionTitle">
                <h1>Certification</h1>
            </div>
            
            <div class="sectionContent">
              
 
            <table class="layout display responsive-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Certificate</th>
                        <th>Partner Institution</th>
                        <th>Valid</th>
                    </tr>
                </thead>
                <tbody>';

$mail->Body     .= $body5;

             
                    $Cert = mysql_query("SELECT * FROM tbl_profile_certification WHERE CertNIK=".$nikki." ORDER BY CertDate ASC");
                    while ($ws5 = mysql_fetch_array($Cert)){
                        $CertDate =date('d-M-Y', strtotime($ws5['CertDate']));
                        $CertValidStart =date('d M Y', strtotime($ws5['CertValidStart']));
                        $CertValidFinish =date('d M Y', strtotime($ws5['CertValidFinish']));
                            
                    $wdu5[$ws5['CertId']]='
                    <tr>
                        <td class="organisationnumber" width="90px">'.format_tanggal_id($date=$ws5['CertDate']).'</td>
                        <td class="organisationnumber">'.$ws5['CertProduct'].'</td>
                        <td class="organisationname">'.$ws5['CertName'].'</td>
                        <td class="organisationname">'.$ws5['CertPartnerName'].'</td>
                        <td class="organisationname">'.format_tanggal_id($date=$ws5['CertValidStart']).' s/d '.format_tanggal_id($date=$ws5['CertValidFinish']).'</td>                       
                    </tr>';

                    $mail->Body .= $wdu5[$ws5['CertId']];

             }              


                $body6='</tbody>
            </table>
            <br/>
            </div>
            <div class="clear"></div>
        </section>

        <section>
        <div class="sectionTitle">
                <h1>Project History</h1>
            </div>
            
            <div class="sectionContent">
              
 
            <table class="layout display responsive-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Project</th>
                        <th>Institution</th>
                        <th width="50px">Year</th>
                        <th width="80px">Length</th>
                        <th>Technical Spec</th>
                        <th>Position in Project</th>
                    </tr>
                </thead>
                <tbody>';
$mail->Body     .= $body6;
                
                    $project = mysql_query("SELECT * FROM tbl_profile_projecthistory WHERE ProjectNIK=".$nikki." ORDER BY ProjectDate ASC");
                    while ($ws6 = mysql_fetch_array($project)){
                        $ProjectDate =date('d-M-Y', strtotime($ws6['ProjectDate']));
                        
                    $wdu6[$ws6['ProjectId']]='

                    <tr>
                        <td class="organisationnumber" width="90px">'.format_tanggal_id($date=$ws6['ProjectDate']).'</td>
                        <td class="organisationnumber">'.$ws6['ProjectName'].'</td>
                        <td class="organisationname">'.$ws6['ProjectInstitution'].'</td>
                        <td class="organisationname">'.$ws6['ProjectYear'].'</td>
                        <td class="organisationname">'.$ws6['ProjectLength'].'</td>
                        <td class="organisationname">'.$ws6['ProjectTechnicalSpec'].'</td>
                        <td class="organisationname">'.$ws6['ProjectPosition'].'</td>                       
                    </tr>';

                    $mail->Body .= $wdu6[$ws6['ProjectId']];

                 }           


                $body7='</tbody>
            </table>
            <br/>
            </div>
            <div class="clear"></div>
        </section>



        <section>
        <div class="sectionTitle">
                <h1>Attachment Files</h1>
            </div>
            
            <div class="sectionContent">
              
 
            <table class="layout display responsive-table">
                <thead>
                    <tr>
                        <th>File</th>
                        <th width="150px">Download</th>
                        
                    </tr>
                </thead>
                <tbody>';

$mail->Body     .= $body7;
              
                    $fileku = mysql_query("SELECT * FROM tbl_profile_files WHERE file_nik=".$nikki." ORDER BY file_id ASC");
                    while ($ws7 = mysql_fetch_array($fileku)){
                        // /$ProjectDate =date('d-M-Y', strtotime($ws6['ProjectDate']));
                        
                    $wdu7[$ws7['file_id']]='
                    <tr>
                        <td class="organisationnumber">'.$ws7['file_code'].'</td>
                        <td class="organisationnumber"><div align="center"><a href="'.$_SERVER['SERVER_NAME'].'/hris2/modules/karyawan/assets/uploads/'.$ws7['url'].'" target="_blank">Download</a></div></td>                 
                    </tr>';

                    $mail->Body .= $wdu7[$ws7['file_id']];

                }                 


        $closer='</tbody>
            </table>
            <br/>
            </div>
            <div class="clear"></div>
        </section>

        
    </div>
</div>        


</body></html><br/><br/>';

$mail->Body     .= $closer;


    

    

	$footer ='<p><font color="#FF0000" size="-1">Perhatian email ini dikirim secara otomatis dari HRIS. Jangan membalas ke alamat ini</font></p>';

	$mail->IsSMTP();
    $mail->Mailer       = "smtp";
    $mail->Host         = "Exc2013-DAG";
    $mail->Port         = 25;
    $mail->SMTPKeepAlive= true;
    $mail->SMTPAuth     = true;
    $mail->From         = "system.noreply@unias.com";
    $mail->FromName     = "Human Resource Information System";
    $mail->SetFrom('system.noreply@unias.com', 'Human Resource Information System');    
    //$to = "dompak.sinambela@unias.com";
	$to = "$data[Email]";
	$mail->Body         .= $footer;
    $mail->AddAddress($to);
    $mail->Subject       = "CV $data[Nama]";
    $mail->AltBody       = "To view the message, please use an HTML compatible email viewer!";  
    $mail->WordWrap      = 80;  
    $mail->IsHTML(true);    
    $mail->Send();
    $Statusku = 'Email Berhasil Dikirim';

  }  
        catch (phpmailerException $e){
        echo $e->errorMessage();
        $Statusku = 'Error!!! Email Tidak Berhasil Dikirim';
        }

    echo "<script type='text/javascript'>alert('$Statusku...Click OK to close window');window.open('', '_self', '');window.close();</script>";
    
 

		
?>