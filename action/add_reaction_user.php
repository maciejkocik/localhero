<?php
$error = 1;

if($signed_in)
{
    if(isset($_REQUEST['user_id']) && is_numeric($_REQUEST['user_id'])
    && isset($_REQUEST['reaction']) && $_REQUEST['reaction'] == 1 or $_REQUEST['reaction'] == 0 or $_REQUEST['reaction'] == -1)
    {
        $here_user_id = $_REQUEST['user_id'];
        $reaction = $_REQUEST['reaction'];
        $user = new User();

        if($user -> resultConnection)
        {
            $user -> getUser($here_user_id);

            if($user -> resultGetUser && $user -> getUser['id'] != NULL)
            {
                
                $user -> getReactionInfo($user_id, $here_user_id,);

                if($user -> reactionInfo['id'] != NULL)
                {
                    if($reaction == 1 or $reaction == 0)
                    {
                        $user -> editReaction($user_id,$here_user_id,$reaction);

                        if($user -> resultEditReaction)
                        {
                            $error =-1;
                        }
                    }

                    if($reaction == -1)
                    {
                        $user -> deleteReaction($user_id, $here_user_id,);

                        if($user -> resultDeleteReaction)
                        {
                            $error =-1;
                        }
                    }
                }
                else
                {
                    if($reaction == 1 or $reaction == 0)
                    {
                        $user -> addReaction($user_id, $here_user_id, $reaction);

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
            header('Location:index.php?page=view_user&error=1');
            exit;
        }
    }
}

if($error == -1)
{
    header('Location:index.php?page=view_user&user_id='.$here_user_id);
    exit;
}
header('Location:index.php?error='.$error);
exit;
?>