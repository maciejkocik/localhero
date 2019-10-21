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
            
            $reaction_error = false;

            if($signed_in)
            {
                $post -> getReactionInfo($post_id,$user_id);

                if(!$post -> resultGetReactionInfo)
                {
                    $reaction_error = true;
                }
            }

            if(!$reaction_error && $post -> resultGetComments)
            {
                $error = -1;

                if($user_id == $post -> getPost['p_id_user'])
                {
                    $this_user_post = true;
                }
                else
                {
                    $this_user_post = false;
                }

                if($post -> getPost['cu_id_user'] != NULL)
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

switch($error)
{
    case 1:
    {
        echo '<p>Wystąpił błąd.</p>';
        break;
    }
    case -1:
    {
        if($post -> getPost['p_status'] == 'approved' or ($signed_in && $user_mod == 1 or $this_user_post))
        {
            if($post -> getPost['p_status'] == 'removed')
            {
                echo '<p>Wpis został ustawiony jako prywatny lub odrzucony.</p>';
            }
            else if($post -> getPost['p_status'] == 'waiting')
            {
                echo '<p>Wpis czeka na weryfikację przez administratora</p>';
            }

            if($this_user_post)
            {
                echo '<a href="index.php?page=edit_post&post_id='.$post_id.'"><button>Edytuj</button></a>
                <a href="action.php?page=change_post_status?&post_id='.$post_id.'&status=removed"><button>Ustaw jako prywatny</button></a>';
            }
            if(!$this_user_post && $user_mod)
            {
                switch($post -> getPost['p_status'])
                {
                    case 'waiting':
                    {
                        echo '<a href="action.php?page=change_post_status?&post_id='.$post_id.'&status=approved"><button>Zaakceptuj</button></a>
                        <a href="action.php?page=change_post_status?&post_id='.$post_id.'&status=removed"><button>Odrzuć</button></a>';
                        break;
                    }
                    case 'removed':
                    {
                        echo '<a href="action.php?page=change_post_status?&post_id='.$post_id.'&status=approved"><button>Przywróć</button></a>';
                        break;
                    }
                    case 'approved':
                    {
                        echo '<a href="action.php?page=change_post_status?&post_id='.$post_id.'&status=removed"><button>Odrzuć</button></a>';
                        break;
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
                    echo '<p>Posprzątanie czeka na weryfikację przez administratora</p>';
                }

                if($post -> getPost['cu_status'] == 'approved' or ($signed_in && $user_mod == 1 or $this_user_clean_up))
                {
                    echo '<h1>Posprzątano</h1>';

                    if($this_user_clean_up)
                    {
                        echo '<a href="index.php?page=edit_cleaned_up&cleaned_up_id='.$post -> getPost['cu_id'].'"><button>Edytuj posprzątanie</button></a>
                        <a href="action.php?page=change_cleaned_up_status?&cleaned_up_id='.$post -> getPost['cu_id'].'&status=removed"><button>Usuń posprzątanie</button></a>';
                    }

                    if(!$this_user_clean_up && $user_mod)
                    {
                        switch($post -> getPost['cu_status'])
                        {
                            case 'waiting':
                            {
                                echo '<a href="action.php?page=change_cleaned_up_status?&cleaned_up_id='.$post -> getPost['cu_id'].'&status=approved"><button>Zaakceptuj posprzątanie</button></a>
                                <a href="action.php?page=change_cleaned_up_status?&cleaned_up_id='.$post -> getPost['cu_id'].'&status=removed"><button>Odrzuć posprzątanie</button></a>';
                                break;
                            }
                            case 'approved':
                            {
                                echo '<a href="action.php?page=change_cleaned_up_status?&cleaned_up_id='.$post -> getPost['cu_id'].'&status=removed"><button>Usuń posprzątanie</button></a>';
                                break;
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
            if($signed_in)
            {
                echo '';
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