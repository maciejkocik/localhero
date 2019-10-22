<?php

$error = 1;

if($signed_in)
{
    if(isset($_REQUEST['comment_id']) && is_numeric($_REQUEST['comment_id']))
    {
        $comment_id = $_REQUEST['comment_id'];

        $post = new Post();
        if($post -> resultConnection)
        {
            $post -> getOnlyComment($comment_id);
            if($post -> resultGetOnlyComment && $post -> onlyComment['id_user'] != NULL)
            {
                if($user_mod or $user_id == $post -> onlyComment['id_user'])
                {
                    $post -> changeCommentStatus($comment_id,0);

                    if($post -> resultChangeCommentStatus)
                    {
                        $error = -1;
                        header('Location:index.php?page=view_post&info=4&post_id='.$post -> onlyComment['id_post']);
                        exit;
                    }
                }
                if($error != -1)
                {
                    header('Location:index.php?page=view_post&error=1&post_id='.$post -> onlyComment['id_post']);
                    exit;
                }
            }
        }
    }
}
header('Location:index.php?error='.$error);
exit;


?>