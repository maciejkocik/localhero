<?php
$error = 1;

$photos_error = -1;

$description = '';

if($signed_in)
{
    
        if(isset($_POST['description']))
        {
            $description = $_POST['description'];
        }
            
            $post = new Post();
            
            if($post -> resultConnection && isset($_POST['post_id']) && is_numeric($_POST['post_id']))
            {
                
                $post_id = $_POST['post_id'];
                
                $post -> getOnlyPost($post_id);

                if($post -> resultGetOnlyPost && $post -> onlyPost['id'] != NULL)
                {
                    $post -> getOnlyCleanedUpByPost($post_id);

                    if($post -> resultOnlyCleanedUpByPost && $post -> onlyCleanedUpByPost['id'] == NULL)
                    {
                        if($user_mod == 1)
                        {
                            $status = 'approved';
                        }
                        else
                        {
                            $status = 'waiting';
                        }

                        $post -> connection -> beginTransaction();
                        $post -> addCleanedUp($post_id, $user_id, $description, $status);

                        if($post -> resultAddCleanedUp)
                        {
                            

                            $post -> getLastCleanedUp();

                            if($post -> resultGetLastCleanedUp)
                            {
                                

                                if(!$_FILES['imagename']['name'][0] == '')
                                {

                                    $destination = 'img/photos_cleaned_up/'.$post -> lastCleanedUp['id'];

                                    if(mkdir($destination, 0777, true))
                                    {
                                        $file_number = count($_FILES['imagename']['name']);
                                        $counter = 0;
                                    
                                        
                                        for($i = 0;$i<$file_number;$i++)
                                        {	
                                            $ext = pathinfo($_FILES['imagename']['name'][$i])['extension'];
                                            if($ext =="jpg" || $ext =="pjpeg" || $ext =="jpeg" || $ext =="png" &&
                                            ($_FILES['imagename']['type'][$i] == 'image/png' or $_FILES['imagename']['type'][$i]=='image/jpg'
                                            or $_FILES['imagename']['type'][$i] == 'image/jpeg'))
                                            {
                                                if(!move_uploaded_file($_FILES['imagename']['tmp_name'][$i], $destination.'/'.$i.'.'.$ext))
                                                {
                                                    $error = 1;
                                                    
                                                }
                                                else
                                                {
                                                    $counter ++;
                                                }
                                            }
                                        }
                                        
                                        if($counter == $file_number && $counter <= 10)
                                        {
                                            $post -> connection -> commit();
                                            $error = -1;
                                        }
                                        else
                                        {
                                            delete_directory($destination);
                                            $photos_error = 1;
                                        }
                                    }
                                }
                                else
                                {
                                    $post -> connection -> commit();
                                    $error = -1;
                                }
                            }
                        }
                    }
                }
            }
}
else
{
    need_to_sign_in_in_action();
}

if($error == -1)
{
    header('Location:index.php?page=view_post&post_id='.$post -> lastCleanedUp['id'].'&info=1');
    exit;
}
else
{
    $header = 'Location:index.php?page=add_cleaned_up&error='.$error;

    if(isset($_POST['description']))
    {
        $header = $header.'&description='.$_POST['description'];
    }

    if(!$_FILES['imagename']['name'][0] == '')
    {
        if($photos_error == 1)
        {
            $header = $header.'&photos_error='.$photos_error;
        }
        else
        {
            $header = $header.'&imagename='.$_POST['imagename'];
        }
    }

    header($header);
    exit;
}

?>