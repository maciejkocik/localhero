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
        echo '<div class="container mt-4">';

        if($signed_in && $user_mod && !$user -> getUser['moderator'])
        {
            $change = true;
        }
        else
        {
            $change = false;
        }
        if(isset($_GET['info']))
        {
            error("view_user", "success", $_GET['info']);
        }
        if(isset($_GET['error']))
        {
            error("view_user", "danger", $_GET['error']);
        }
        
        echo '
        <div class="row">
        
        <div '.($change ? 'class="col-lg-8"' :'').' style="width:100%;">
                
                
        <h1 class="mt-4">'.$user -> getUser['login'].($user -> getUser['moderator'] ?' <span class="badge badge-primary">Moderator</span>':'').'</h1>';


        if($user -> getUser['status'] == 0) { echo '<span class="badge badge-danger mb-2">Użytkownik zablokowany</span><br>';}
        echo '<hr>
        <p class="lead">Data dołączenia: <strong>'.$user -> getUser['date'].'</strong></p>
        
        <p class="lead">Punkty: <strong>'.$user -> reactionInfo['points'].'</strong></p>
        <p class="lead">Posty: <strong>'.$user -> reactionInfo['posts'].'</strong></p>
        <p class="lead">Posprzątania: <strong>'.$user -> reactionInfo['cleaned_up'].'</strong></p>
        <p class="lead">Komentarze: <strong>'.$user -> reactionInfo['comments'].'</strong></p>
        
        </div>';

        

        if($change)
        {
            echo '
            <div class="col-md-4">

            <div class="card my-4">
            <h5 class="card-header">Opcje</h5>
            <div class="card-body text-center">';

            
            

            echo'
            <a '.($user -> getUser['status'] == 1 ? 'class="btn btn-danger mb-2"' : 'class="btn btn-success"').' href="action.php?file=change_user_status&user_id='.$user -> getUser['id'].'&status='.($user -> getUser['status'] == 1 ? 0 : 1).'">
            <i class="material-icons">'.($user -> getUser['status'] == 1 ? 'block' : 'restore').'</i> '.($user -> getUser['status'] == 1 ? 'Zablokuj użytkownika' : 'Przywróć użytkownika').'
            </a>

            </div>
            </div>
            
            </div>';
        }
           

            if(isset($activity[0]['id']) && $activity[0]['id'] != NULL)
            {
                echo '

                </div>

                <hr>
                

                <h2 class="text-center display-5" id="gallery-heading">Ostatnia aktywność</h2>
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

                            echo '<a class="btn btn-outline-secondary btn-sm" href="index.php?page=view_post&post_id='.($is_post ? $row['id'] : $row['id_post']).'">Zobacz</a>
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
                echo '
                </div>

                <hr>
                <p>Brak aktywności.</p>';
            }


        break;
    }
}

?>