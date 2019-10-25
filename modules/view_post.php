<?php

$error = 1;

if(isset($_REQUEST['post_id']) && is_numeric($_REQUEST['post_id']))
{
    $post_id = $_REQUEST['post_id'];

    $post = new Post();

    if($post -> resultConnection)
    {
        $post -> getPost($post_id);


        
        if($post -> resultGetPost && $post -> getPost['p_id'] != NULL)
        {
            $post -> getComments($post_id);
            $post -> getPostReactions($post_id);

            $reaction_error = false;

            if($signed_in)
            {
                $post -> getReactionInfo($post_id,$user_id);

                if(!$post -> resultGetReactionInfo)
                {
                    $reaction_error = true;
                }
            }

            if(!$reaction_error && $post -> resultGetComments && $post -> resultGetPostReactions)
            {
                $error = -1;

                $this_user_post = false;

                if($signed_in)
                {
                    if($user_id == $post -> getPost['p_id_user'])
                    {
                        $this_user_post = true;
                    }
                    else
                    {
                        $this_user_post = false;
                    }
                }

                if($post -> getPost['cu_id_user'] != NULL)
                {
                    $this_user_clean_up = false;
                    if($signed_in)
                    {
                        if($user_id == $post -> getPost['cu_id_user'])
                        {
                            $this_user_clean_up = true;
                        }
                        else
                        {
                            $this_user_clean_up = false;
                        }
                    }
                }
            }
        }
    }
}

if($error == -1):

echo '<div class="container" id="post">';


        if(isset($_GET['info']))
        {
            error("view_post", "success", $_GET['info']);
        }
        if(isset($_GET['error']))
        {
            error("view_post", "danger", $_GET['error']);
        }
    
        if($post -> getPost['p_status'] == 'approved' or ($signed_in && $user_mod == 1 or $this_user_post)){          
            
            echo '
            <div class="row">
            <div class="col-lg-8">
            ';
            
            echo '<h1 class="mt-4">'.$post -> getPost['p_title'].'</h1>';
                
            echo '<p class="lead">
                    od
                    <a href="index.php?page=view_user&user_id='.$post -> getPost['p_id_user'].'">'.$post -> getPost['p_login'].'</a>';
                
            echo '<hr>';
            echo '<p>'.$post -> getPost['p_date'].'</p>';
                
            echo '<hr>
            
            <div id="map3"></div>
            
            <hr>
            ';
            
    
            echo '<p>'.$post -> getPost['p_description'].'</p>';
            
            echo '
            <div class="row my-2">';
                
            $directory = 'img/photos_posts/'.$post -> getPost['p_id'];
                  if(is_dir($directory))
                  {
                    $allFiles = scandir($directory);
                    $files = array_diff($allFiles, array('.', '..'));
                    foreach($files as $file){
                        echo '
                        <div class="col-lg-4 mb-4">
                        <a href="'.$directory . '/' . $file.'" data-fancybox="post">
                        <img src="'.$directory . '/' . $file.'" class="img-thumbnail">
                        </a>
                        </div>';
                    }
                  }

            echo '
            </div>
            <hr>';
            
            $add_like = '';
            $add_dislike ='';

            if($signed_in)
            {
                if($post -> reactionInfo['reaction'] != NULL)
                {
                    if($post -> reactionInfo['reaction'] == 1)
                    {
                        $add_like = 'style="font-weight:700;"';
                    }
                    else
                    {
                        $add_dislike = 'style="font-weight:700;"';
                    }
                }
            }
            
            echo '<div>
            <a href="action.php?file=add_reaction_post&post_id='.$post_id.'&reaction='.($add_like == '' ? '1':'-1').'" >
            <button class="btn btn-primary" '.$add_like.' '.($signed_in ? '':'disabled').'><i class="material-icons">thumb_up</i> Za: '.$post -> postReactions['likes'].'</button></a>
            <a href="action.php?file=add_reaction_post&post_id='.$post_id.'&reaction='.($add_dislike == '' ? '0':'-1').'">
            <button class="btn btn-danger" '.$add_dislike.' '.($signed_in ? '':'disabled').'><i class="material-icons">thumb_down</i> Przeciw: '.$post -> postReactions['dislikes'].'</button></a>
            </div>
            ';
            if($signed_in)
            {
            echo '
            <div class="card my-4">
              <h5 class="card-header">Dodaj komentarz:</h5>
              <div class="card-body">
                <form method="POST" action="action.php">
                  <div class="form-group">
                    <input type="hidden" name="file" value="add_comment">
                    <input type="hidden" name="post_id" value="'.$post_id.'">
                    <textarea class="form-control" name="text" rows="3" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Prześlij</button>
                </form>
              </div>
            </div>
           ';    
            } else echo '<p style="margin-top:20px;">Aby dodać komentarz musisz się zalogować.</p>';

            if($post -> comments[0]['id'] != NULL)
            {
                foreach($post -> comments as $row)
                {
                    echo '
                    <div class="media mb-4">
                        <div class="media-body">
                            <h5 class="mt-0"><a href="index.php?page=view_user&user_id='.$row['id_user'].'">'.$row['login'].'</a>, '.$row['date'].'</h5>
                            <p>'.$row['text'].'</p>';
                    
                    if($signed_in && ($row['id_user'] == $user_id or $user_mod))
                    {
                        echo '<a href="action.php?file=delete_comment&comment_id='.$row['id'].'"><button class="btn btn-danger"><i class="material-icons">delete</i> Usuń</button></a>';
                    }
                    
                    echo '</div>
                    </div>';
                }
            }
            
            echo '</div>
            <div class="col-lg-4">';
            
                if($signed_in)
                {
                    echo'
                    <div class="card my-4">
                      <h5 class="card-header">Opcje</h5>
                      <div class="card-body">';
                    
                    if($this_user_post)
                    {
                        if($post -> getPost['p_status'] != 'removed')
                        {
                            echo '<a class="btn btn-danger mb-2" href="action.php?file=change_post_status&post_id='.$post_id.'&status=removed"><i class="material-icons">delete</i> Usuń</a><br>';
                        }
                    }
                                        
                    if($post -> getPost['p_status'] == 'removed') { echo '<span class="badge badge-danger mb-2">Wpis usunięty</span><br>';}
                    else if($post -> getPost['p_status'] == 'waiting') { echo '<span class="badge badge-warning mb-2">Czeka na weryfikację</span><br>';}
                    
                    if($user_mod)
                    {
                        switch($post -> getPost['p_status'])
                        {
                            case 'waiting':
                            {
                                echo '<a class="btn btn-success" href="action.php?file=change_post_status&post_id='.$post_id.'&status=approved"><i class="material-icons">done</i> Zaakceptuj</a>
                                <a class="btn btn-danger" href="action.php?file=change_post_status&post_id='.$post_id.'&status=removed"><i class="material-icons">delete</i> Odrzuć</a>';
                                break;
                            }
                            case 'removed':
                            {
                                echo '<a class="btn btn-success" href="action.php?file=change_post_status&post_id='.$post_id.'&status=approved"><i class="material-icons">restore_from_trash</i> Przywróć</a>';
                                break;
                            }
                            case 'approved':
                            {
                                if(!$this_user_post)
                                {
                                    echo '<a class="btn btn-danger" href="action.php?file=change_post_status&post_id='.$post_id.'&status=removed"><i class="material-icons">delete</i>Zmień status na niepubliczny</a>';
                                }
                                break;
                            }
                        }
                    }
                    echo '</div>
                    </div>';
                }    
            
            

            
            if($post -> getPost['cu_id'] != NULL)
            {
                echo '
                <div class="card my-4">
                  <h5 class="card-header">Posprzątaj</h5>
                <div class="card-body">
                ';
                
                if($post -> getPost['cu_status'] == 'waiting')
                {
                    echo '<p><span class="badge badge-warning mb-2">Czeka na weryfikację</span></p>';
                }

                if($post -> getPost['cu_status'] == 'approved' or ($signed_in && $user_mod == 1 or $this_user_clean_up))
                {
                    if($signed_in)
                    {
                        if($this_user_clean_up)
                        {
                            echo '
                            <a class="btn btn-danger" href="action.php?file=change_cleaned_up_status&cleaned_up_id='.$post -> getPost['cu_id'].'&status=removed"><i class="material-icons">delete</i> Usuń</a>';
                        }

                        if($user_mod)
                        {
                            switch($post -> getPost['cu_status'])
                            {
                                case 'waiting':
                                {
                                    echo '<a class="btn btn-primary" href="action.php?file=change_cleaned_up_status&cleaned_up_id='.$post -> getPost['cu_id'].'&status=approved"><i class="material-icons">done</i> Zaakceptuj</a>
                                    <a class="btn btn-danger" href="action.php?file=change_cleaned_up_status&cleaned_up_id='.$post -> getPost['cu_id'].'&status=removed"><i class="material-icons">delete</i> Odrzuć</a>';
                                    break;
                                }
                                case 'approved':
                                {
                                    if(!$this_user_clean_up)
                                    {
                                        echo '<a class="btn btn-danger" href="action.php?file=change_cleaned_up_status&cleaned_up_id='.$post -> getPost['cu_id'].'&status=removed"><i class="material-icons">delete</i> Usuń</a>';
                                    }
                                    break;
                                
                                }
                            }
                        }
                    }

                    
                    echo '<h3>Posprzątano</h3>
                    
                    <p>'.$post -> getPost['cu_description'].'</p>';

                    echo '<p>'.$post -> getPost['cu_date'].' przez <a href="index.php?page=view_user&user_id='.$post -> getPost['cu_id_user'].'">'.$post -> getPost['cu_login'].'</a></p>';

                    echo '
                    <div class="row">';

                    $directory = 'img/photos_cleaned_up/'.$post -> getPost['cu_id'];
                          if(is_dir($directory))
                          {
                            $allFiles = scandir($directory);
                            $files = array_diff($allFiles, array('.', '..'));
                            foreach($files as $file){
                                echo '
                                <div class="col-md-12 mt-4">
                                <a href="'.$directory . '/' . $file.'" data-fancybox="cleaned_up">
                                <img src="'.$directory . '/' . $file.'" class="img-thumbnail">
                                </a>
                                </div>';
                            }
                          }

                    echo '</div>';
                    
                }           
            }
            else
            {
                if($signed_in)
                {
                    echo '
                    <div class="card my-4">
                      <h5 class="card-header">Posprzątaj</h5>
                        <div class="card-body">
                        <a class="btn btn-primary" href="index.php?page=add_cleaned_up&post_id='.$post_id.'">
                            <i class="material-icons">add</i> Dodaj
                        </a>';
                }
                else
                {
                    echo '<p>Zaloguj się, aby dodać posprzątanie.</p>';
                }
            }
            
            echo '
                </div>
            </div>
        </div>';
            
            
            


        
            }
endif;
if($error == 1) 

?>