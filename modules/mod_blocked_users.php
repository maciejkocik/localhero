<?php
$error = 1;

if($signed_in && $user_mod)
{
    $user = new User();

    if($user -> resultConnection)
    {
        $user -> getBlockedUsersMod();

        if($user -> resultGetBlockedUsersMod)
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
        if($user -> blockedUsersMod[0]['id']!= NULL)
        {
            foreach($user -> blockedUsersMod as $row)
            {
                echo '
                <div>
                <p><a href="index.php?page=view_user&user_id='.$user -> blockedUsersMod['id'].'">Użytkownik: '.$user -> blockedUsersMod['login'].'</a></p>
                <p>data dołączenia: '.$user -> blockedUsersMod['date'].'</p>
                </div>';

                            

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