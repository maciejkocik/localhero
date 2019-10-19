<html>

    <head>
        <title>LocalHero</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </head>
    
    <body>
        <?php
        include_once('classes.php');
        include_once('admin/checking_login.php');
        include_once('admin/functions.php');

        $path = 'modules';
        if(isset($_REQUEST['page']))
        {
            if(file_exists($path.'/'.$_REQUEST['page'].'.php'))
            { 
                include($path.'/'.$_REQUEST['page'].'.php');
            }
            else
            {
                include_once($path.'/error.php');
            }
        }
        else
        {
            include($path.'/main_page.php');
        }
        ?>
    </body>
    
</html>