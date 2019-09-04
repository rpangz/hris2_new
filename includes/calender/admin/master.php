<?php
error_reporting(0);
session_start();
?>
<!DOCTYPE HTML>
<html>

<head>
  <title>Agenda</title>
  <link rel="shortcut icon" href="images/icon.png" />
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/tcal.css" />
	<script type="text/javascript" src="js/tcal.js"></script>
	<script src="js/jquery-latest.js"></script>	
	
	 <link rel="stylesheet" href="css/jquery-ui.css">
  <script src="js/jquery-1.9.1.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script language="javascript" type="text/javascript" src="../tinymcpuk/tiny_mce_src.js"></script>
  <!--include modul for CKEditor-->
	<script src="ckeditor/ckeditor.js"></script>
  
  
</head>

<body>
  <div id="main">
    <header>
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_six", allows you to change the colour of the text -->
          <h1>Agenda<span class="logo_six"></span></h1>
      
        </div>
      </div>     
	  <nav>
        <div id="menu_container">
          <ul class="sf-menu" id="nav">
            <li><a href="?module=home"> Home </a></li>
            <li><a href="#">  Menu  </a>
              <ul>
                <?php				
				
				include "koneksi/koneksi.php";
					$menu=mysql_query("SELECT * FROM tbWebRoleList INNER JOIN 
					tbSubMenu ON tbWebRoleList.SubMenuId = tbSubMenu.SubMenuId 
					WHERE WebRoleId='$_SESSION[WebRoleId]' AND TopMenuId=1");
						while ($data = mysql_fetch_array($menu)){	
							echo "<a href='$data[SubMenuLink]&ui=$data[SubMenuId]'>$data[SubMenuName]</a>";	
							}	
				?>               
              </ul>
            </li>                      
            
			<li><a href="logout.php">Logout</a></li>
          </ul>
        </div>
      </nav>
    </header>
    <div id="site_content">      
        <?php include "konten.php";?>      
    </div>
   
  </div>
  <p>&nbsp;</p>
  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('ul.sf-menu').sooperfish();
    });
  </script>
</body>
</html>
