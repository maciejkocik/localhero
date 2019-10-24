<?php

$error = 1;

if($signed_in)
{
    if(isset($_REQUEST['user_id']) && isset($_REQUEST['status'])
    && ($_REQUEST['status'] == 1 or $_REQUEST['status'] == 0) && $user_mod && $_REQUEST['user_id'] != $user_id)
    {
        $here_user_id = $_REQUEST['user_id'];
        $status = $_REQUEST['status'];
        $user = new User();
        if($user -> resultConnection)
        {
            
            $user -> getUser($here_user_id);
            if($user -> resultGetUser)
            {
                if($user -> getUser['id'] != NULL)
                {
                    $user -> changeUserStatus($here_user_id,$status);

                    if($user -> resultChangeUserStatus)
                    {
                        $error = -1;
                        header('Location:index.php?page=view_user&info=1&user_id='.$here_user_id);
                        exit;
                    }
                }
            }
        }

        if($error != -1)
        {
            header('Location:index.php?page=view_user&error=1&user_id='.$here_user_id);
            exit;
        }

    }
}
header('Location:index.php?error='.$error);
exit;


?>