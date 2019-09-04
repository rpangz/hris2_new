<!DOCTYPE html>
<html lang="{{ language:language_alias }}">
    <head>
        <title><?php echo $template['title'];?></title>
        <?php echo $template['metadata'];?>
        <link rel="icon" href="{{ site_favicon }}">

        <link rel="shortcut icon" href="{{ site_favicon }}">        
       

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="{{ site_url }}assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ site_url }}assets_login/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ site_url }}assets_login/css/form-elements.css">
        <link rel="stylesheet" href="{{ site_url }}assets_login/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        
              
        
    </head>
    <body>

        <!-- Top menu -->
        <nav class="navbar navbar-inverse navbar-no-bg" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar-1">
                        <span class="sr-only"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ site_url }}"></a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="top-navbar-1">
                    <ul class="nav navbar-nav navbar-right">
                        
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Top content -->
        <div class="top-content">            
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <!-- element of body -->
                        <?php echo $template['body'];?>

                    </div>
                </div>
            </div>            
        </div>

        <footer style="color:#fff;">{{ widget_name:section_bottom }}</footer>
        
       <!-- Javascript -->
        <script src="{{ site_url }}assets_login/js/jquery-1.11.1.min.js"></script>
        <script src="{{ site_url }}assets_login/bootstrap/js/bootstrap.min.js"></script>
        <script src="{{ site_url }}assets_login/js/jquery.backstretch.min.js"></script>
        <script src="{{ site_url }}assets_login/js/retina-1.1.0.min.js"></script>
        <!--<script src="{{ site_url }}assets_login/js/scripts.js"></script>-->
        
<script type="text/javascript">
    jQuery(document).ready(function() {
    
    /*
        Fullscreen background
    */
    $.backstretch("{{ site_background }}");
    //$.backstretch("../assets_login/img/backgrounds/1.jpg");
    
    $('#top-navbar-1').on('shown.bs.collapse', function(){
        $.backstretch("resize");
    });
    $('#top-navbar-1').on('hidden.bs.collapse', function(){
        $.backstretch("resize");
    });
    
    /*
        Form validation
    */
    $('.registration-form input[type="text"], .registration-form textarea').on('focus', function() {
        $(this).removeClass('input-error');
    });
    
    $('.registration-form').on('submit', function(e) {
        
        $(this).find('input[type="text"], textarea').each(function(){
            if( $(this).val() == "" ) {
                e.preventDefault();
                $(this).addClass('input-error');
            }
            else {
                $(this).removeClass('input-error');
            }
        });
        
    });
    
    
});

</script>
        
        <script type="text/javascript">
            $(document).ready(function(){
                // if section-banner is empty, remove it
                if($.trim($('__section-banner').html()) == ''){
                    $('__section-banner').remove();
                }            
            });
        </script>
    </body>
</html>