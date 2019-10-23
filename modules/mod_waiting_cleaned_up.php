<?php
$error = 1;

if($signed_in && $user_mod)
{
    $post = new Post();

    if($post -> resultConnection)
    {
        $post -> getCleanedUpMod('waiting');

        if($post -> resultGetCleanedUpMod)
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
        if($post -> cleanedUpMod[0]['id']!= NULL)
        {
            foreach($post -> postsMod as $row)
            {
                            echo '<div>
                            
                            <a href="index.php?page=view_post&post_id='.$row['id_post'].'">
                                
                                <h3>Posprzątano</h3></a>';

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