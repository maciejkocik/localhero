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
        include_once('admin/error.php');

        $path = 'modules';
        if(isset($_REQUEST['page']))
        {
            if(file_exists($path.'/'.$_REQUEST['page'].'.php'))
            { 
                include($path.'/'.$_REQUEST['page'].'.php');
            }
            else
            {
                include_once($path.'/404.php');
            }
        }
        else
        {
            include($path.'/main_page.php');
        }
        ?>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
    
</html>