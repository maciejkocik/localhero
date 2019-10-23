
        <?php
        include_once('classes.php');
        include_once('admin/checking_login.php');
        include_once('admin/functions.php');
        include_once('admin/error.php');

        include_once('header.php');
        if($signed_in) include_once('modules/add_post.php');

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

        include('footer.php');
        ?>

