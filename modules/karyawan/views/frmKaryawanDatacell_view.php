<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$nikki = $this->input->get('nik');
$this->config->load('cms_config');       
$company_id = $this->config->item('cms_datacell_id');



$asset = new CMS_Asset();
foreach($css_files as $file){
    $asset->add_css($file);
}
echo $asset->compile_css();

foreach($js_files as $file){
    $asset->add_js($file);
}
echo $asset->compile_js();

// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}
if (is_null($nikki) || $nikki =='' || $nikki ==0){
  echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);
          
}else{
  $tampil   = mysql_query("SELECT * FROM tbl_profile LEFT JOIN 
      tbl_company ON tbl_profile.CompanyId=tbl_company.iCompanyId LEFT JOIN 
      tbl_div ON tbl_profile.DivisiID=tbl_div.iDivId LEFT JOIN 
      tbl_dept ON tbl_profile.DeptID=tbl_dept.iDeptID LEFT JOIN 
      tbl_unit ON tbl_profile.UnitID=tbl_unit.UnitID LEFT JOIN 
      tbl_section ON tbl_profile.SeksiID = tbl_section.iSectionID LEFT JOIN 
      tbl_statusdiri ON tbl_profile.StatusDiri=tbl_statusdiri.StatusDiriId LEFT JOIN 
      tbl_sex ON tbl_profile.Sex = tbl_sex.SexCode LEFT JOIN 
      tbl_jabatan ON tbl_profile.JabatanID = tbl_jabatan.JabatanId LEFT JOIN 
      tbl_job_fungsional ON tbl_profile.JobId = tbl_job_fungsional.JobFungsionalId LEFT JOIN 
      tbl_agama ON tbl_profile.Agama=tbl_agama.agama_id WHERE NIK=".$nikki);

    $data = mysql_fetch_array($tampil);

    $NIK    = $data['NIK'];
    $Nama   = $data['Nama'];
    $CompanyId = $data['CompanyId'];

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


?>

<!DOCTYPE html>
<html>
<head>
<title>My CV</title>

<meta name="viewport" content="width=device-width"/>
<meta name="description" content="My CV"/>
<meta charset="UTF-8"> 

<link type="text/css" rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/hris2/css/style.css">
<link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700|Lato:400,300' rel='stylesheet' type='text/css'>

<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

        

<body id="top">

<div id="cv" class="instaFade">
        <div class="social">
            <ul>

        <?php 
        echo'<li><a class="north" href="http://'.$_SERVER['SERVER_NAME'].'/hris2/'.$this->uri->segment('1').'/'.$this->uri->segment('2').'/index/edit/'.$nikki.'" title="Edit"><img src="http://'.$_SERVER['SERVER_NAME'].'/hris2/images/icn-edit.png" alt=" "></a></li>';
        echo'<li><a class="north" href="#" title="Download .xls"><img src="http://'.$_SERVER['SERVER_NAME'].'/hris2/images/icn-save.jpg" alt="Download the pdf version" /></a></li>';
        echo'<li><a class="north" id="contact" href="http://'.$_SERVER['SERVER_NAME'].'/hris2/includes/mailer/frmKaryawanALL/?nik='.$nikki.'" target="_blank" title="Send Email to '.$data['Email'].'"><img src="http://'.$_SERVER['SERVER_NAME'].'/hris2/images/icn-contact.jpg" alt="" /></a></li>';
        ?>
            </ul>
        </div>

        
          
    <div class="mainDetails">
        <div id="headshot" class="quickFade">
            <img src="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/hris2/'.$session_img ?>" alt="<?php echo $data['Nama'] ?>" style="height:80px; width:80px;" />
        </div>
        
        <div id="name">
            <h1 class="quickFade delayTwo"><?php echo $data['Nama'] ?></h1>
            <h2 class="quickFade delayThree"><?php echo $data['NamaJabatan'] ?></h2>
        </div>
        
        <div id="contactDetails" class="quickFade delayFour">
            <ul>
                <li>Email : <a href="mailto:<?php echo $data['Email'] ?>" target="_blank"><?php echo $data['Email'] ?></a></li>
                <li>Mobile: <?php echo $data['Hp'] ?></li>
                
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

                    <table width="100%" height="112" border="0" cellpadding="0" cellspacing="1" style="font-size: 11px;">
                      <tr>
                        <td width="135"><strong>Name</strong></td>
                        <td width="10">:</td>
                        <td width="250"><?php echo $data['Nama'] ?></td>
                        <td width="20">&nbsp;</td>
                        <td width="130"><strong>Age</strong></td>
                        <td width="10">:</td>
                        <td width="250"><?php echo $MyAge ?> Year</td>
                      </tr>
                      <tr>
                        <td><strong>NIP</strong></td>
                        <td>:</td>
                        <td><?php echo $data['NIK'] ?></td>
                        <td>&nbsp;</td>
                        <td><strong>Place of birth</strong></td>
                        <td>:</td>
                        <td><?php echo $data['TptLahir'] ?></td>
                      </tr>
                      <tr>
                        <td><strong>Company</strong></td>
                        <td>:</td>
                        <td><?php echo $data['cCompanyName'] ?></td>
                        <td>&nbsp;</td>
                        <td><strong>Date of birth</strong></td>
                        <td>:</td>
                        <td><?php echo $TglLahir ?></td>
                      </tr>
                      <tr>
                        <td><strong>Division</strong></td>
                        <td>:</td>
                        <td><?php echo $data['cDivName'] ?></td>
                        <td>&nbsp;</td>
                        <td><strong>Domicile Address</strong></td>
                        <td>:</td>
                        <td rowspan="3" valign="top"><?php echo $data['AlamatDomisili'] ?></td>
                      </tr>
                      <tr>
                        <td><strong>Job Title Structural</strong></td>
                        <td>:</td>
                        <td><?php echo $data['NamaJabatan'] ?></td>
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
                        <td><?php echo $data['JobFungsionalName'] ?></td>
                        <td>&nbsp;</td>
                        <td><strong>ZIP</strong></td>
                        <td>:</td>
                        <td><?php echo $data['Kodepos'] ?></td>
                      </tr>
                      <tr>
                        <td><strong>Joint date</strong></td>
                        <td>:</td>
                        <td><?php echo $TglMasuk ?></td>
                        <td>&nbsp;</td>
                        <td><strong>Telephone</strong></td>
                        <td>:</td>
                        <td><?php echo $data['Hp'] ?></td>
                      </tr>
                      <tr>
                        <td><strong>Sex</strong></td>
                        <td>:</td>
                        <td><?php echo $data['SexNameEng'] ?></td>
                        <td>&nbsp;</td>
                        <td><strong>Fax</strong></td>
                        <td>:</td>
                        <td><?php echo $data['Fax'] ?></td>
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
    <tbody>

        <?php 
        $workexp = mysql_query("SELECT * FROM tbl_profile_workexperience WHERE WorkExpNIK=".$nikki." ORDER BY WorkExpId ASC");

        while ($ws1 = mysql_fetch_array($workexp)){
                $WorkExpStart =date('d-M-Y', strtotime($ws1['WorkExpStart']));
                $WorkExpFinish =date('d-M-Y', strtotime($ws1['WorkExpFinish']));
                    ?>
        <tr>
            <td class="organisationnumber" width="90px"><?php echo $WorkExpStart ?></td>
            <td class="organisationname" width="90px"><?php echo $WorkExpFinish ?></td>
            <td class="organisationname"><?php echo $ws1['WorkExpCompany'] ?></td>
            <td class="organisationname"><?php echo $ws1['WorkExpPosition'] ?></td>
        </tr>

            <?php } ?>        

       

       

    </tbody>
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
                <tbody>

                <?php 
                    $education = mysql_query("SELECT * FROM tbl_profile_education WHERE EduNIK=".$nikki." ORDER BY EduId ASC");

                    while ($ws3 = mysql_fetch_array($education)){
                            
                ?>
                    <tr>
                        <td class="organisationnumber" width="90px"><?php echo $ws3['EduStart'] ?></td>
                        <td class="organisationnumber" width="90px"><?php echo $ws3['EduFinish'] ?></td>
                        <td class="organisationname"><?php echo $ws3['EduInstitution'] ?></td>
                        <td class="organisationname"><?php echo $ws3['EduCity'] ?></td>
                        <td class="organisationname"><?php echo $ws3['EduFaculty'] ?></td>
                        <td class="organisationname"><?php echo $ws3['EduGPA'] ?></td>
                        <td class="organisationname"><?php echo $ws3['EduMajor'] ?></td>
                    </tr>

                <?php } ?> 

                    


                </tbody>
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
                <tbody>

                <?php 
                    $training = mysql_query("SELECT * FROM tbl_profile_training WHERE TrainingNIK=".$nikki." ORDER BY TrainingId ASC");

                    while ($ws2 = mysql_fetch_array($training)){
                            //$WorkExpStart =date('d-M-Y', strtotime($ws1['WorkExpStart']));
                            //$WorkExpFinish =date('d-M-Y', strtotime($ws1['WorkExpFinish']));
                ?>
                    <tr>
                        <td class="organisationnumber" width="90px"><?php echo $ws2['TrainingYear'] ?></td>
                        <td class="organisationnumber"><?php echo $ws2['TrainingInstitution'] ?></td>
                        <td class="organisationname"><?php echo $ws2['TrainingCity'] ?></td>
                        <td><?php echo $ws2['TrainingModul'] ?></td>
                        <td><?php echo $ws2['TrainingType'] ?></td>
                    </tr>

                <?php } ?> 

                    


                </tbody>
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
                <tbody>

                <?php 
                    $skill = mysql_query("SELECT * FROM tbl_profile_technicalskill WHERE TechnicalSkillNIK=".$nikki." ORDER BY TechnicalSkillId ASC");
                    while ($ws4 = mysql_fetch_array($skill)){
                            
                ?>
                    <tr>
                        <td class="organisationnumber"><?php echo $ws4['TechnicalSkillName'] ?></td>
                        <td class="organisationnumber"><?php echo $ws4['TechnicalSkillExp'] ?></td>
                        <td class="organisationname"><?php echo $ws4['TechnicalSkillDesc'] ?></td>                       
                    </tr>

                <?php } ?>                  


                </tbody>
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
                <tbody>

                <?php 
                    $Cert = mysql_query("SELECT * FROM tbl_profile_certification WHERE CertNIK=".$nikki." ORDER BY CertId ASC");
                    while ($ws5 = mysql_fetch_array($Cert)){
                        $CertDate =date('d-M-Y', strtotime($ws5['CertDate']));
                        $CertValidStart =date('d M Y', strtotime($ws5['CertValidStart']));
                        $CertValidFinish =date('d M Y', strtotime($ws5['CertValidFinish']));
                            
                ?>
                    <tr>
                        <td class="organisationnumber" width="90px"><?php echo $CertDate ?></td>
                        <td class="organisationnumber"><?php echo $ws5['CertProduct'] ?></td>
                        <td class="organisationname"><?php echo $ws5['CertName'] ?></td>
                        <td class="organisationname"><?php echo $ws5['CertPartnerName'] ?></td>
                        <td class="organisationname"><?php echo $CertValidStart.' s/d '.$CertValidFinish ?></td>                       
                    </tr>

                <?php } ?>                  


                </tbody>
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
                <tbody>

                <?php 
                    $project = mysql_query("SELECT * FROM tbl_profile_projecthistory WHERE ProjectNIK=".$nikki." ORDER BY ProjectId ASC");
                    while ($ws6 = mysql_fetch_array($project)){
                        $ProjectDate =date('d-M-Y', strtotime($ws6['ProjectDate']));
                        
                ?>
                    <tr>
                        <td class="organisationnumber" width="90px"><?php echo $ProjectDate ?></td>
                        <td class="organisationnumber"><?php echo $ws6['ProjectName'] ?></td>
                        <td class="organisationname"><?php echo $ws6['ProjectInstitution'] ?></td>
                        <td class="organisationname"><?php echo $ws6['ProjectYear'] ?></td>
                        <td class="organisationname"><?php echo $ws6['ProjectLength'] ?></td>
                        <td class="organisationname"><?php echo $ws6['ProjectTechnicalSpec'] ?></td>
                        <td class="organisationname"><?php echo $ws6['ProjectPosition'] ?></td>                       
                    </tr>

                <?php } ?>                  


                </tbody>
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
                <tbody>

                <?php 
                    $fileku = mysql_query("SELECT * FROM tbl_profile_files WHERE file_nik=".$nikki." ORDER BY file_id ASC");
                    while ($ws7 = mysql_fetch_array($fileku)){
                        // /$ProjectDate =date('d-M-Y', strtotime($ws6['ProjectDate']));
                        
                ?>
                    <tr>
                        <td class="organisationnumber"><?php echo $ws7['file_code'] ?></td>
                        <td class="organisationnumber"><div align="center"><a href="<?php echo base_url();?>modules/karyawan/assets/uploads/<?php echo $ws7['url'] ?>" target="_blank">Download</a></div></td>                 
                    </tr>

                <?php } ?>                  


                </tbody>
            </table>
            <br/>
            </div>
            <div class="clear"></div>
        </section>

        
    </div>
</div>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-3753241-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>
</body>
</html>


<?php

}


if(isset($dropdown_setup)) {
  $this->load->view('dependent_dropdown', $dropdown_setup);
}
?>

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
    
    
</style>

<script type="text/javascript">
  $(document).ready(function () {
    $('#checkbox1').change(function () {
        if (!this.checked) 
        //  ^
           $('#autoUpdate').fadeIn('slow');
        else 
            $('#autoUpdate').fadeOut('slow');
          
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function()
        {
    var changeYear = $( ".datepicker-input" ).datepicker( "option", "changeYear" );
    $( ".datepicker-input" ).datepicker( "option", "yearRange", "-70:+70" );
        });
</script>

<style type="text/css">

/*
html,body,div,span,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,abbr,address,cite,code,del,dfn,em,img,ins,kbd,q,samp,small,strong,sub,sup,var,b,i,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,figcaption,figure,footer,header,hgroup,menu,nav,section,summary,time,mark,audio,video {
border:0;
font:inherit;
font-size:100%;
margin:0;
padding:0;
vertical-align:baseline;
}
*/
article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section {
display:block;
}

 /*html, body {background: #181818; font-family: 'Lato', helvetica, arial, sans-serif; font-size: 16px; color: #222;}*/

.clear {clear: both;}

p {
    font-size: 1em;
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
    font-family: 'Rokkitt', Helvetica, Arial, sans-serif;
    margin-bottom: -6px;
}

#name h2 {
    font-size: 2em;
    margin-left: 2px;
    font-family: 'Rokkitt', Helvetica, Arial, sans-serif;
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
    font-size: 0.9em;
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
    font-family: 'Rokkitt', Helvetica, Arial, sans-serif;
    font-style: italic;
    font-size: 1.5em;
    color: #cf8a05;
}

.sectionContent h2 {
    font-family: 'Rokkitt', Helvetica, Arial, sans-serif;
    font-size: 1.5em;
    margin-bottom: -2px;
}

.subDetails {
    font-size: 0.8em;
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
  border-collapse: collapse;
}
table.display{
  margin: 1em 0;
}
table.display th,
table.display td{
  border: 1px solid #B3BFAA;
  padding: .5em 1em;
}

table.display th{ background: #D5E0CC; font-size: 12px; text-align: center;  }
table.display td{ background: #fff;font-size: 11px; }

table.responsive-table{
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
    content: 'Number';
    
  }
  table.responsive-table td:nth-child(2):before{
    content: 'Name';
    
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

</style>
<script type="text/javascript">
function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    }

function alphanumeric(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
}

function alphaOnly(e) {
  var code;
  if (!e) var e = window.event;
  if (e.keyCode) code = e.keyCode;
  else if (e.which) code = e.which;
  if ((code >= 48) && (code <= 57)) { return false; }
  return true;
}



function validateEmail(sEmail) {
  var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;

  if(!sEmail.match(reEmail)) {
    alert("Invalid email address");
    return false;
  }

  return true;

}

function handleChange1(input) {
   
    var input=parseInt(input.value);
    if(input < 5 || input >5)
    alert("ZIP (ID Based) value should be 5 Digit");
    //return ;
    // /document.getElementById(input).focus();
    //document.getElementById(KodeposKTP).innerHTML = "<span style='color:red;'>Mandatory!</span>";
      return ;


}

function handleChange2(input) {
   
    var input=parseInt(input.value);
    if(input !=5)
    alert("ZIP (Current) value should be 5 Digit");
    return ;

}