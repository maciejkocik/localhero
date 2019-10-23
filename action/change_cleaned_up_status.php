<?php

$error = 1;

if($signed_in)
{
    if(isset($_REQUEST['cleaned_up_id']) && is_numeric($_REQUEST['cleaned_up_id']) && isset($_REQUEST['status'])
    && ($_REQUEST['status'] == 'approved' or $_REQUEST['status'] == 'removed' or $_REQUEST['status']== 'waiting'))
    {
        $cleaned_up_id = $_REQUEST['cleaned_up_id'];
        $status = $_REQUEST['status'];

        
        $post = new Post();
        if($post -> resultConnection)
        {
            $post -> getOnlyCleanedUp($cleaned_up_id);
            if($post -> resultOnlyCleanedUp)
            {
                if($post -> onlyCleanedUp['id'] != NULL && ($user_mod or ($status == 'removed' && $user_id == $post -> onlyCleanedUp['id_user'])))
                {
                    $post_id = $post -> onlyCleanedUp['id_post'];



                    if($status == 'removed')
                    {
                        $post -> deleteCleanedUp($cleaned_up_id);
                    }
                    else
                    {
                        $post -> changeCleanedUpStatus($cleaned_up_id,$status);
                    }
                    
                    if($post -> resultChangeCleanedUpStatus or $post -> resultDeleteCleanedUp)
                    {
                        
                        $add_info = '&info=5';
                        if($status == 'removed')
                        {
                            $dir = 'img/photos_cleaned_up/'.$post -> onlyCleanedUp['id'];
                            if(is_dir($dir))
                            {
                                delete_directory($dir);
                            }

                            $add_info = '&info=6';
                        }
                        $error = -1;
                        header('Location:index.php?page=view_post&post_id='.$post_id.$add_info);
                        exit;
                    }
                }
            }
        }
    }
}
header('Location:index.php?error='.$error);
exit;


?>