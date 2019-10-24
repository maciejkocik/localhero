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
            error("view_post", "success", $_GET['info']);
        }
        if(isset($_GET['error']))
        {
            error("view_post", "danger", $_GET['error']);
        }

        if($post -> getPost['p_status'] == 'approved' or ($signed_in && $user_mod == 1 or $this_user_post))
        {
            if($post -> getPost['p_status'] == 'removed')
            {
                echo '<p>Wpis został usunięty lub odrzucony przez moderatora.</p>';
            }
            else if($post -> getPost['p_status'] == 'waiting')
            {
                echo '<p>Wpis czeka na weryfikację przez moderatora.</p>';
            }

            if($signed_in)
            {
                if($this_user_post)
                {
                    echo '<a href="index.php?page=edit_post&post_id='.$post_id.'"><button>Edytuj</button></a>';
                    if($post -> getPost['p_status'] != 'removed')
                    {
                        echo '<a href="action.php?file=change_post_status&post_id='.$post_id.'&status=removed"><button>Usuń</button></a>';
                    }
                }
                if($user_mod)
                {
                    switch($post -> getPost['p_status'])
                    {
                        case 'waiting':
                        {
                            echo '<a href="action.php?file=change_post_status&post_id='.$post_id.'&status=approved"><button>Zaakceptuj</button></a>
                            <a href="action.php?file=change_post_status&post_id='.$post_id.'&status=removed"><button>Odrzuć</button></a>';
                            break;
                        }
                        case 'removed':
                        {
                            echo '<a href="action.php?file=change_post_status&post_id='.$post_id.'&status=approved"><button>Przywróć</button></a>';
                            break;
                        }
                        case 'approved':
                        {
                            if(!$this_user_post)
                            {
                                echo '<a href="action.php?file=change_post_status&post_id='.$post_id.'&status=removed"><button>Zmień status na niepubliczny</button></a>';
                            }
                            break;
                        }
                    }
                }
            }

            echo '<h1>'.$post -> getPost['p_title'].'</h1>';

            //zdjęcia

            echo '<h2>Opis</h2>
            <p>'.$post -> getPost['p_description'].'</p>';

            //mapa

            echo '<p>'.$post -> getPost['p_date'].', <a href="index.php?page=view_user&user_id='.$post -> getPost['p_id_user'].'">'.$post -> getPost['p_login'].'</a></p>';

            if($post -> getPost['cu_id'] != NULL)
            {
                if($post -> getPost['cu_status'] == 'waiting')
                {
                    echo '<p>Posprzątanie czeka na weryfikację przez moderatora</p>';
                }

                if($post -> getPost['cu_status'] == 'approved' or ($signed_in && $user_mod == 1 or $this_user_clean_up))
                {

                    //zdjęcia trzeba dodać!
                    echo '<h1>Posprzątano</h1>
                    
                    <p>'.$post -> getPost['cu_description'].'</p>';

                    echo '<p>'.$post -> getPost['cu_date'].', <a href="index.php?page=view_user&user_id='.$post -> getPost['cu_id_user'].'">'.$post -> getPost['cu_login'].'</a></p>';

                    
                    if($signed_in)
                    {
                        if($this_user_clean_up)
                        {
                            echo '<a href="index.php?page=edit_cleaned_up&cleaned_up_id='.$post -> getPost['cu_id'].'"><button>Edytuj posprzątanie</button></a>
                            <a href="action.php?file=change_cleaned_up_status&cleaned_up_id='.$post -> getPost['cu_id'].'&status=removed"><button>Usuń posprzątanie</button></a>';
                        }

                        if($user_mod)
                        {
                            switch($post -> getPost['cu_status'])
                            {
                                case 'waiting':
                                {
                                    echo '<a href="action.php?file=change_cleaned_up_status&cleaned_up_id='.$post -> getPost['cu_id'].'&status=approved"><button>Zaakceptuj posprzątanie</button></a>
                                    <a href="action.php?file=change_cleaned_up_status&cleaned_up_id='.$post -> getPost['cu_id'].'&status=removed"><button>Odrzuć posprzątanie</button></a>';
                                    break;
                                }
                                case 'approved':
                                {
                                    if(!$this_user_clean_up)
                                    {
                                        echo '<a href="action.php?file=change_cleaned_up_status&cleaned_up_id='.$post -> getPost['cu_id'].'&status=removed"><button>Usuń posprzątanie</button></a>';
                                    }
                                    break;
                                
                                }
                            }
                        }
                    }

                    

                    

                }
            }
            else
            {

                if($signed_in)
                {
                    echo '<a href="index.php?page=add_cleaned_up&post_id='.$post_id.'"><button>Dodaj posprzątanie</button></a>';
                }
            }



            $add_like = '';
            $add_dislike ='';

            if($signed_in)
            {
                if($post -> reactionInfo['reaction'] != NULL)
                {
                    if($post -> reactionInfo['reaction'] == 1)
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
            <a href="action.php?file=add_reaction_post&post_id='.$post_id.'&reaction='.($add_like == '' ? '1':'-1').'" >
            <button '.$add_like.' '.($signed_in ? '':'disabled').'>Likes: '.$post -> postReactions['likes'].'</button></a>
            <a href="action.php?file=add_reaction_post&post_id='.$post_id.'&reaction='.($add_dislike == '' ? '0':'-1').'">
            <button '.$add_dislike.' '.($signed_in ? '':'disabled').'>Dislikes: '.$post -> postReactions['dislikes'].'</button></a>
            </div>
            
            
            <h2>Komentarze</h2>';
            if($signed_in)
            {
                echo '<FORM method="POST" action="action.php">
                <input type="hidden" name="file" value="add_comment">
                <input type="hidden" name="post_id" value="'.$post_id.'">
                <textarea name="text" required></textarea>
                <input type="submit">';        
            }
            else
            {
                echo '<p>Aby dodać komentarz musisz się zalogować.</p>';
            }

            if($post -> comments[0]['id'] != NULL)
            {
                foreach($post -> comments as $row)
                {
                    echo '<div>
                    <h3><a href="index.php?page=view_user&user_id='.$row['id_user'].'">'.$row['login'].'</a>, '.$row['date'].'</h3>
                    <p>'.$row['text'].'</p>';
                    if($signed_in && ($row['id_user'] == $user_id or $user_mod))
                    {
                        echo '<button><a href="action.php?file=delete_comment&comment_id='.$row['id'].'">Usuń</a></button>';
                    }
                    
                    echo '</div>';
                }
            }
            

        }
        else
        {
            if($post -> getPost['p_status'] == 'removed')
            {
                echo '<p>Wpis został usunięty.</p>';
            }
            else
            {
                echo '<p>Nie masz uprawnień, aby wyświetlić wpis.</p>';
            }
        }
        break;
    }
}

?>