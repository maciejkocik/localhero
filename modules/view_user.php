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

            $reaction = true;
            if($signed_in)
            {
                $user -> getReactionInfo($user_id,$here_user_id);

                if(!$user -> resultGetReactionInfo)
                {
                    $reaction = false;
                }
            }

            if($post -> resultGetUserCleanedUp && $post -> resultGetUserPost && $reaction)
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
        <p>data dołączenia: '.$user -> getUser['date'].'</p>';

        if($user -> getUser['status'] == 0)
        {
            echo '<p>Użytkownik zablokowany.</p>';
        }

        if($signed_in && $user_mod && $user_id != $here_user_id)
        {
            echo '<a href="action.php?file=change_user_status&user_id='.$user -> getUser['id'].'&status='.($user -> getUser['status'] == 1 ? 0 : 1).'">
            <button>'.($user -> getUser['status'] == 1 ? 'Zablokuj użytkownika' : 'Przywróć użytkownika').'</button>
            </a>';
        }
       

            $add_like = '';
            $add_dislike ='';

            if($signed_in)
            {
                if($user -> reactionInfo['reaction'] != NULL)
                {
                    if($user -> reactionInfo['reaction'] == 1)
                    {
                        $add_like = 'style="color:blue;"';
                    }
                    else
                    {
                        $add_dislike = 'style="color:blue;"';
                    }
                }
            }
            
            echo '<div>
            <a href="action.php?file=add_reaction_user&user_id='.$user -> getUser['id'].'&reaction='.($add_like == '' ? '1':'-1').'" >
            <button '.$add_like.' '.($signed_in ? '':'disabled').'>Likes: '.$user -> getUser['likes'].'</button></a>
            <a href="action.php?file=add_reaction_user&user_id='.$user -> getUser['id'].'&reaction='.($add_dislike == '' ? '0':'-1').'">
            <button '.$add_dislike.' '.($signed_in ? '':'disabled').'>Dislikes: '.$user -> getUser['dislikes'].'</button></a>
            </div>
            
            <h2>Ostatnia Aktywność:</h2>';

            if($activity[0]['id']!= NULL)
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