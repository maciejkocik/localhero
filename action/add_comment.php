<?php
$error = 1;

if($signed_in)
{
    if(isset($_POST['post_id']) && is_numeric($_POST['post_id'])
    && isset($_POST['text']))
    {
        $post_id = $_POST['post_id'];
        $text = $_POST['text'];
        $post = new Post();

        if($post -> resultConnection)
        {
            $post -> getOnlyPost($post_id);
            if($post -> resultGetOnlyPost && $post -> onlyPost['id'] != NULL)
            {
                $post -> addComment($post_id, $user_id, $text);

                if($post -> resultAddComment)
                {
                    $error = -1;
                }
            }
        }

        if($error != -1)
        {
            header('Location:index.php?page=view_post&error=1');
            exit;
        }
    }
}

if($error == -1)
{
    header('Location:index.php?page=view_post&post_id='.$post_id.'&info=3');
    exit;
}
header('Location:index.php?error='.$error);
exit;
?>