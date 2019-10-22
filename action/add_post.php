<?php
$error = 1;

$photos_error = -1;

$description = '';

if($signed_in)
{
    if(isset($_POST['title']) && isset($_POST['lat']) && isset($_POST['lng']))
    {
        if(isset($_POST['description']))
        {
            $description = $_POST['description'];
        }

        $title = $_POST['title'];
        $lat= $_POST['lat'];
        $lng= $_POST['lng'];


        
        if(strlen($title) >= 3 && strlen($title) <= 400)
        {
            $title_error = 1;
            
            $post = new Post();
            
            if($post -> resultConnection)
            {
                $post -> connection -> beginTransaction();

                if($user_mod == 1)
                {
                    $status = 'approved';
                }
                else
                {
                    $status = 'waiting';
                }

                $post -> addPost($user_id, $title, $description, $lat, $lng, $status);

                if($post -> resultAddPost)
                {
                    

                    $post -> getLastPost();

                    if($post -> resultGetLastPost)
                    {
                        if(!$_FILES['imagename']['name'][0] == '')
                        {

                            $destination = 'img/photos_posts/'.$post -> lastPost['id'];

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
    header('Location:index.php?page=view_post&post_id='.$post -> lastPost['id'].'&info=1');
    exit;
}
else
{
    $header = 'Location:index.php?page=add_post&error='.$error;
    if(isset($_POST['title']))
    {
        $header = $header.'&title='.$_POST['title'];
    }

    if(isset($_POST['description']))
    {
        $header = $header.'&description='.$_POST['description'];
    }

    if(isset($_POST['lat']))
    {
        $header = $header.'&lat='.$_POST['lat'];
    }

    if(isset($_POST['lng']))
    {
        $header = $header.'&lng='.$_POST['lng'];
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