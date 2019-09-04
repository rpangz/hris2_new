<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>    
    
    <link rel="stylesheet" href="../assets/orbit/plugins/font-awesome/css/font-awesome.css">
    <link id="theme-style" rel="stylesheet" href="../assets/orbit/css/styles.css">

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

            #bg-text
            {
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
        <div class="sidebar-wrapper">
            <div class="profile-container">
                <img class="profile" src="../assets/uploads/files/<?php echo $profile['Photos'];?>" alt="" width="100" height="100"/>
                <h3 class="name" style="color:#fff !important"><?php echo $profile['Nama'];?></h3>
                <h3 class="tagline"><?php echo $profile['NamaJabatan'];?></h3>
            </div><!--//profile-container-->
            
            <div class="contact-container container-block">
                <ul class="list-unstyled contact-list">
                    <li class="email"><i class="fa fa-envelope"></i><a href="mailto: <?php echo $profile['Email'];?>"><?php echo $profile['Email'];?></a></li>
                    <li class="phone"><i class="fa fa-phone"></i><a href="#"><?php echo $profile['Telp'];?></a></li>
                    <li class="nik"><i class="fa fa-user"></i><a href="#"><?php echo $profile['NIK'];?></a></li>
                    
                    <!--
                    <li class="website"><i class="fa fa-globe"></i><a href="http://themes.3rdwavemedia.com/website-templates/free-responsive-website-template-for-developers/" target="_blank">portfoliosite.com</a></li>
                    <li class="linkedin"><i class="fa fa-linkedin"></i><a href="#" target="_blank">linkedin.com/in/alandoe</a></li>
                    <li class="github"><i class="fa fa-github"></i><a href="#" target="_blank">github.com/username</a></li>
                    <li class="twitter"><i class="fa fa-twitter"></i><a href="https://twitter.com/3rdwave_themes" target="_blank">@twittername</a></li>
                    -->
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
            
            <!--
            <div class="languages-container container-block">
                <h2 class="container-block-title">Languages</h2>
                <ul class="list-unstyled interests-list">
                    <li>English <span class="lang-desc">(Native)</span></li>
                    <li>French <span class="lang-desc">(Professional)</span></li>
                    <li>Spanish <span class="lang-desc">(Professional)</span></li>
                </ul>
            </div>
            -->
            
            <!--
            <div class="interests-container container-block">
                <h2 class="container-block-title">Interests</h2>
                <ul class="list-unstyled interests-list">
                    <li>Climbing</li>
                    <li>Snowboarding</li>
                    <li>Cooking</li>
                </ul>
            </div>
            -->
            
        </div><!--//sidebar-wrapper-->
        
        <div class="main-wrapper">
            
            <!--
            <section class="section summary-section">
                <h2 class="section-title"><i class="fa fa-user"></i>Career Profile</h2>
                <div class="summary">
                    <p>Summarise your career here lorem ipsum dolor sit amet, consectetuer adipiscing elit. You can <a href="http://themes.3rdwavemedia.com/website-templates/orbit-free-resume-cv-template-for-developers/" target="_blank">download this free resume/CV template here</a>. Aenean commodo ligula eget dolor aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu.</p>
                </div>
            </section>
        -->
            
            <section class="section experiences-section">
                <h2 class="section-title"><i class="fa fa-briefcase"></i>Working Experiences</h2>
                <?php
                foreach ($working as $key => $value) { ?>
                    <div class="item">
                        <div class="meta">
                            <div class="upper-row">
                                <h3 class="job-title"><?php echo $value->WorkExpPosition;?></h3>
                                <div class="time"><?php echo date('d-M-Y', strtotime($value->WorkExpStart))?> ~ <?php echo date('d-M-Y', strtotime($value->WorkExpFinish))?></div>
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
                foreach ($certification as $key => $value) { ?>
                    <div class="item">
                        <div class="meta">
                            <div class="upper-row">
                                <h3 class="job-title"><?php echo $value->CertProduct;?></h3>
                                <div class="time"><?php echo date('d-M-Y', strtotime($value->CertValidStart))?> ~ <?php echo date('d-M-Y', strtotime($value->CertValidFinish))?></div>
                            </div>
                            <div class="company"><?php echo $value->CertPartnerName;?></div>
                        </div>
                        <div class="details">
                            <p><?php echo $value->CertItemName;?></p>  
                        </div>
                    </div>
                    
                <?php } ?>           
            
            </section>
            
        </div><!--//main-body-->
    </div>  