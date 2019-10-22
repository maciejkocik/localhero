<?php

$error = 1;

if($signed_in)
{
    if(isset($_REQUEST['post_id']) && isset($_REQUEST['status'])
    && ($_REQUEST['status'] == 'approved' or $_REQUEST['status'] == 'removed' or $_REQUEST['status']== 'waiting'))
    {
        $post_id = $_REQUEST['post_id'];
        $status = $_REQUEST['status'];

        $post = new Post();
        if($post -> resultConnection)
        {
            $post -> getOnlyPost($post_id);
            if($post -> resultGetOnlyPost)
            {
                if($post -> onlyPost['id'] != NULL && ($user_mod or ($status == 'removed' && $user_id == $post -> onlyPost['id_user'])))
                {
                    $post -> changePostStatus($post_id,$status);

                    if($post -> resultChangePostStatus)
                    {
                        $error = -1;
                        header('Location:index.php?page=view_post&info=2&post_id='.$post_id);
                        exit;
                    }
                }
            }
        }

        if($error != -1)
        {
            header('Location:index.php?page=view_post&error=1&post_id='.$post_id);
            exit;
        }

    }
}
header('Location:index.php?error='.$error);
exit;


?>