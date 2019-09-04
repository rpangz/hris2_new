<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>    

<?php

function basic_date_format($date){

    if (is_null($date) || $date =='0000-00-00' || empty($date)){
        $tanggal = 'N/A';
    }
    else{
        $tanggal = date('d-M-Y', strtotime($date));
    } 

    return $tanggal;
}

?>
    
<link rel="stylesheet" href="{{ base_url }}assets/resume_orbit-v1.0/plugins/font-awesome/css/font-awesome.css">
<link id="theme-style" rel="stylesheet" href="{{ base_url }}assets/resume_orbit-v1.0/css/styles.css">

<style type="text/css">
    @media screen {
        #printSection {
            display: none;
        }
    }
    @media print {
        body * {
            visibility:hidden;
            -webkit-print-color-adjust: exact;
        }
        #printSection, #printSection * {
            visibility:visible;
        }
        #printSection {
            position:absolute;
            left:0;
            top:0;
        }

        #bg-text{
            color:#EFEFEF;
            font-size:40px;
            -ms-transform: rotate(7deg); /* IE 9 */
            -webkit-transform: rotate(-7deg); /* Chrome, Safari, Opera */
            transform: rotate(-20deg);
            position: absolute;
            float: left
            opacity: 0.2;
            -webkit-print-color-adjust: exact; 

        }

    }

</style>

<div class="wrapper">

    <div class="pull-left">
        <div class="btn-group">
            <a href="<?php echo site_url('employee/form_my_resume/index/edit/'.$primary_key)?>" class="btn btn-primary btn-flat" role="button" title="Edit"><i class="fa fa-pencil"></i></a>
            <a href="<?php echo site_url('includes/printer/prt_frmMyCV.php?nik='.$primary_key)?>" class="btn btn-primary btn-flat" role="button" title="Export"><i class="fa fa-file-word-o"></i></a>
            <!--<a href="<?php echo site_url('includes/mailer/frmKaryawanALL/?nik='.$primary_key)?>" target="_blank" class="btn btn-primary btn-flat" role="button"><i class="fa fa-send-o"></i></a>-->           
        </div>
    </div>

    <?php 
        $foto = $profile['Photos'];
        if($foto=="") { $foto = 'nofoto.JPG'; } 
    ?>

    <div class="sidebar-wrapper">
        <div class="profile-container">
            <img class="profile" src="<?php echo site_url('assets/uploads/files/'.$foto);?>" alt="" width="100" height="100"/>
            <h3 class="name" style="color:#fff !important"><?php echo $profile['Nama'];?></h3>
            <h3 class="tagline"><?php echo $profile['NamaJabatan'];?></h3>
        </div>
            
        <div class="contact-container container-block">
            <ul class="list-unstyled contact-list">
                <li class="email"><i class="fa fa-envelope"></i><a href="mailto: <?php echo $profile['Email'];?>"><?php echo $profile['Email'];?></a></li>
                <li class="phone"><i class="fa fa-phone"></i><a href="#"><?php echo $profile['Telp'];?></a></li>
                <li class="nik"><i class="fa fa-user"></i><a href="#"><?php echo $profile['NIK'];?></a></li>
            </ul>
        </div>
        <div class="education-container container-block">
            <h2 class="container-block-title">Education</h2>
                <?php
                foreach ($education as $key => $value){ ?>
                    <div class="item">
                        <h4 class="degree"><?php echo $value->EducationLevelName;?> <?php echo $value->EduFaculty;?></h4>
                        <h5 class="meta"><?php echo $value->EduInstitution;?></h5>
                        <div class="time"><?php echo $value->EduStart;?> - <?php echo $value->EduFinish;?></div>
                    </div>                    
                <?php } ?>               
        </div>                     
    </div>
        
    <div class="main-wrapper">            
        <section class="section experiences-section">
            <h2 class="section-title"><i class="fa fa-briefcase"></i>Working Experiences</h2>
                <?php
                foreach ($working as $key => $value){

                    if($value->WorkExpUntilNow == 1){
                        $WorkExpFinish         = 'Sekarang';
                    }
                    else{
                        $WorkExpFinish         = date('d-M-Y', strtotime($value->WorkExpFinish));
                    }

                    ?>
                    <div class="item">
                        <div class="meta">
                            <div class="upper-row">
                                <h3 class="job-title"><?php echo $value->WorkExpPosition;?></h3>
                                <div class="time"><?php echo date('d-M-Y', strtotime($value->WorkExpStart))?> ~ <?php echo $WorkExpFinish;?></div>
                            </div>
                            <div class="company"><?php echo $value->WorkExpCompany;?></div>
                        </div>
                        <div class="details">
                            <p><?php echo $value->WorkExpDesc;?></p>  
                        </div>
                    </div>
                    
                <?php } ?>                       
        </section>
            
        <section class="section projects-section">
            <h2 class="section-title"><i class="fa fa-cubes"></i>Projects History</h2>
                <?php
                foreach ($project as $key => $value) { ?>
                    <div class="item">
                        <span class="project-title"><a href="javascript:void(0)"><?php echo $value->ProjectName;?></a></span> <span class="project-tagline"><?php echo $value->ProjectTechnicalSpec;?></span>                    
                    </div>
                <?php } ?>
        </section>
            
        <section class="skills-section section">
            <h2 class="section-title"><i class="fa fa-rocket"></i>Technical Skills</h2>
            <div class="skillset">
                <?php
                foreach ($skill as $key => $value) { ?>
                    <div class="item">
                        <h3 class="level-title"><?php echo $value->TechnicalSkillName;?></h3>
                        <div class="level-bar" style="height: 100%;padding: 2px">
                            <?php echo $value->TechnicalSkillDesc;?>                                      
                        </div>                                
                    </div>
                <?php } ?>                    
            </div>  
        </section>


        <section class="section experiences-section">
            <h2 class="section-title"><i class="fa fa-wrench"></i>Training</h2>
                <?php
                foreach ($training as $key => $value) { ?>
                    <div class="item">
                        <div class="meta">
                            <div class="upper-row">
                                <h3 class="job-title"><?php echo $value->TrainingModul;?></h3>
                                <div class="time"><?php echo $value->TrainingYear;?></div>
                            </div>
                            <div class="company"><?php echo $value->TrainingInstitution;?></div>
                        </div>
                        <div class="details">
                            <p><?php echo $value->TrainingType;?></p>  
                        </div>
                    </div>
                    
                <?php } ?>              
        </section>


        <section class="section experiences-section">
            <h2 class="section-title"><i class="fa fa-certificate"></i>Certification</h2>
                <?php
                foreach ($certification as $key => $value) {

                    $CertValidStart  = basic_date_format($value->CertValidStart);
                    $CertValidFinish = basic_date_format($value->CertValidFinish);

                ?>
                    <div class="item">
                        <div class="meta">
                            <div class="upper-row">
                                <h3 class="job-title"><?php echo $value->CertProduct;?></h3>
                                <div class="time"><?php echo $CertValidStart;?> ~ <?php echo $CertValidFinish;?></div>
                            </div>
                            <div class="company"><?php echo $value->CertPartnerName;?></div>
                        </div>
                        <div class="details">
                            <p><?php echo $value->CertItemName;?></p>  
                        </div>
                    </div>
                    
                <?php } ?>                       
        </section>          
    </div>
</div>