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
        
        echo '
        
        <style>
        .embed-responsive .card-img-top {
            object-fit: cover;
        }
                </style>
        
        
        
        <h1>Użytkownik: '.$user -> getUser['login'].'</h1>
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
           

            if(isset($activity[0]['id']) && $activity[0]['id'] != NULL)
            {
                echo '
                <h2 class="text-center display-3" id="gallery-heading">Ostatnia Aktywność</h2>
                <div class="container">
                <div class="row">';
                foreach($activity as $row)
                {
                    if($row['status'] == 'approved' or ($signed_in && ($user -> getUser['id'] == $user_id or $user_mod)))
                    {
                        if(isset($row['title']) && $row['title'] != NULL)
                        {
                            $is_post = true;
                        }
                        else
                        {
                            $is_post = false;
                        }
                        echo'
                        <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <div class="embed-responsive embed-responsive-4by3">
                            <a href="index.php?page=view_post&post_id='.($is_post ? $row['id'] : $row['id_post']).'">
                            <img class="card-img-top embed-responsive-item" src="';
                            $directory = 'img/photos_'.($is_post ? 'posts' : 'cleaned_up').'/'.$row['id'];
                            if(is_dir($directory))
                            {
                                $files = scandir ($directory);
                                echo $directory . '/' . $files[2];
                            }
                            else
                            {
                                echo 'img/logo1.png';
                            }
                        
                        
                        
                            
                            
                            echo '" alt="Card image cap"></a>
                            </div>
                          <div class="card-body">
                            <h5 class="card-title">'.($is_post ? 'Wpis: '.$row['title'] : 'Posprzątano').'</h5>
                            <p class="card-text">'.$row['description'].'</p>
                            <div class="d-flex justify-content-between align-items-center">';
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

                            echo '<a href="index.php?page=view_post&post_id='.($is_post ? $row['id'] : $row['id_post']).'<button type="button" class="btn btn-sm btn-outline-secondary">Zobacz</button></a>
                              <small class="text-muted">'.$row['date'].'</small>
                            </div>
                          </div>
                          </div>
                        </div>';
                        

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