<?php
$error = 1;

if((isset($_REQUEST['user_id']) && is_numeric($_REQUEST['user_id']))
or $signed_in)
{
    if(isset($_REQUEST['user_id']))
    {
        $here_user_id = $_REQUEST['user_id'];
    }
    else
    {
        $here_user_id = $user_id;
    }


    $user = new User();

    $post = new Post();


    if($user -> resultConnection && $post -> resultConnection)
    {
        
        $user -> getUser($here_user_id);

        if($user -> resultGetUser && $user -> getUser['id'] != NULL &&(($signed_in && $user_mod) or $user -> getUser['status'] == 1))
        {
            
            $start_id = 0;
            $table = array();

            $post -> getUserPosts($here_user_id, $start_id, $table);
            $post -> getUserCleanedUp($here_user_id, $start_id, $table);

            
                $user -> getReactionInfo($here_user_id);

               
        

            if($post -> resultGetUserCleanedUp && $post -> resultGetUserPost && $user -> resultGetReactionInfo)
            {
                $activity = array_orderby($table, 'date', SORT_DESC);
                $error = -1;
                
            }
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

        
        if(isset($_GET['info']))
        {
            error("view_user", "success", $_GET['info']);
        }
        if(isset($_GET['error']))
        {
            error("view_user", "danger", $_GET['error']);
        }
        
        echo '<h1>Użytkownik: '.$user -> getUser['login'].'</h1>
        <p>data dołączenia: '.$user -> getUser['date'].'</p>
        <p>Punkty: '.$user -> reactionInfo['points'].', Posty: '.$user -> reactionInfo['posts'].', Posprzątania: '.$user -> reactionInfo['cleaned_up'].', Komentarze: '.$user -> reactionInfo['comments'].'</p>';

        if($user -> getUser['status'] == 0)
        {
            echo '<p>Użytkownik zablokowany.</p>';
        }

        if($signed_in && $user_mod && !$user -> getUser['moderator'])
        {
            echo '<a href="action.php?file=change_user_status&user_id='.$user -> getUser['id'].'&status='.($user -> getUser['status'] == 1 ? 0 : 1).'">
            <button>'.($user -> getUser['status'] == 1 ? 'Zablokuj użytkownika' : 'Przywróć użytkownika').'</button>
            </a>';
        }
            echo '
            <h2>Ostatnia Aktywność:</h2>';

            if(isset($activity[0]['id']) && $activity[0]['id'] != NULL)
            {
                foreach($activity as $row)
                {
                    if($row['status'] == 'approved' or ($signed_in && ($user -> getUser['id'] == $user_id or $user_mod)))
                    {
                        echo '<div>
                        
                        <a href="index.php?page=view_post&post_id=';
                        if(isset($row['title']) && $row['title'] != NULL)
                        {
                            echo $row['id'].'">
                            
                            <h3>'.$row['title'].'</h3>';
                        }
                        else
                        {
                            echo $row['id_post'].'">
                            <h3>Posprzątano</h3>';
                        }
                        echo '</a>';

                        echo '<p>'.$row['date'].'</p>
                        
                        <p>'.$row['description'].'</p>';

                        switch($row['status'])
                        {
                            case 'approved':
                            {
                                break;
                            }
                            case 'removed':
                            {
                                echo '<p>Post usunięty</p>';
                                break;
                            }
                            case 'waiting':
                            {
                                echo '<p>Oczekuje na akceptację</p>';
                                break;
                            }
                        }

                        echo '</div>';
                    }
                }
            }
            else
            {
                echo '<p>Brak aktywności.</p>';
            }


        break;
    }
}

?>