<?php
$error = 1;

if($signed_in && $user_mod)
{
    $post = new Post();

    if($post -> resultConnection)
    {
        $post -> getPostsMod('removed');

        if($post -> resultGetPostsMod)
        {
            $error = -1;
        }
    }
}

switch($error)
{
    case 1:
    {
        echo '<p>Wystąpił błąd.</p>';
        break;
    }
    case -1:
    {
        if($post -> postsMod[0]['id']!= NULL)
        {
            foreach($post -> postsMod as $row)
            {
                            echo '<div>
                            
                            <a href="index.php?page=view_post&post_id='.$row['id'].'">
                                
                                <h3>'.$row['title'].'</h3></a>';

                            echo '<p>'.$row['date'].'</p>
                            
                            <p>'.$row['description'].'</p>';

                            

                            echo '</div>';
            }
        }
        else
        {
            echo '<p>Brak treści do wyświetlenia.</p>';
        }
        break;
    }
}
?>