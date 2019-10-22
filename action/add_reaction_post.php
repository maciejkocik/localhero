<?php
$error = 1;

if($signed_in)
{
    if(isset($_REQUEST['post_id']) && is_numeric($_REQUEST['post_id'])
    && isset($_REQUEST['reaction']) && $_REQUEST['reaction'] == 1 or $_REQUEST['reaction'] == 0 or $_REQUEST['reaction'] == -1)
    {
        $post_id = $_REQUEST['post_id'];
        $reaction = $_REQUEST['reaction'];
        $post = new Post();

        if($post -> resultConnection)
        {
            $post -> getOnlyPost($post_id);

            if($post -> resultGetOnlyPost && $post -> onlyPost['id'] != NULL)
            {
                
                $post -> getReactionInfo($post_id, $user_id);

                if($post -> reactionInfo['id'] != NULL)
                {
                    if($reaction == 1 or $reaction == 0)
                    {
                        $post -> editReaction($post_id,$user_id,$reaction);

                        if($post -> resultEditReaction)
                        {
                            $error =-1;
                        }
                    }

                    if($reaction == -1)
                    {
                        $post -> deleteReaction($post_id,$user_id);

                        if($post -> resultDeleteReaction)
                        {
                            $error =-1;
                        }
                    }
                }
                else
                {
                    if($reaction == 1 or $reaction == 0)
                    {
                        $post -> addReaction($post_id,$user_id,$reaction);

                        if($post -> resultAddReaction)
                        {
                            $error =-1;
                        }
                    }
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
    header('Location:index.php?page=view_post&post_id='.$post_id);
    exit;
}
header('Location:index.php?error='.$error);
exit;
?>