<?php

$error = 1;

if(isset($_REQUEST['post_id']) && is_number($_REQUEST['post_id']))
{
    $post_id = $_REQUEST['post_id'];

    $post = new Post();

    if($post -> resultConnection)
    {
        $post -> getPost($post_id);

        if($post -> resultGetPost && $post -> resultGetPost['p_id'] != NULL))
        {
            $error = -1;

            if($user_id == $post -> resultGetPost['p_user_id'])
            {
                $this_user_post = true;
            }
            else
            {
                $this_user_post = false;
            }

            if($post -> resultGetPost['cu_user_id'] != NULL)
            {
                if($user_id == $post -> resultGetPost['cu_user_id'])
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

switch($error)
{
    case 1:
    {
        echo '<p>Wystąpił błąd.</p>';
        break;
    }
    case -1:
    {
        if($post -> resultGetPost['p_status'] == 'approved' or ($signed_in && $user_mod == 1 or $this_user_post))
        {
            if($post -> resultGetPost['p_status'] == 'removed')
            {
                echo '<p>Wpis został ustawiony jako prywatny lub odrzucony.</p>';
            }
            else if($post -> resultGetPost['p_status'] == 'waiting')
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
                switch($post -> resultGetPost['p_status'])
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

            echo '<h1>'.$post -> resultGetPost['p_title'].'</h1>';

            //zdjęcia

            echo '<h2>Opis</h2>
            <p>'.$post -> resultGetPost['p_description'].'</p>';

            //mapa

            echo '<p>'.$post -> resultGetPost['p_data'].', <a href="index.php?page=view_user&user_id='.$post -> resultGetPost['p_id_user'].'">'.$post -> resultGetPost['p_login'].'</a></p>';

            if($post -> resultGetPost['cu_id'] != NULL)
            {
                if($post -> resultGetPost['cu_status'] == 'approved' or ($signed_in && $user_mod == 1 or $this_user_clean_up))
                {
                    if($post -> resultGetPost['cu_status'] == 'waiting')
                    {
                        echo '<p>Posprzątanie czeka na weryfikację przez administratora</p>';
                    }

                    echo '<h1>Posprzątano</h1>';

                    if($this_user_post)
                    {
                        echo '<a href="index.php?page=edit_cleaned_up&post_id='.$post_id.'"><button>Edytuj posprzątanie</button></a>
                        <a href="action.php?page=change_cleaned_up_status?&post_id='.$post_id.'&status=removed"><button>Usuń posprzątanie</button></a>';
                    }
                    

                }
            }
            else
            {
                echo '<a href="index.php?page=add_cleaned_up&post_id='.$post_id.'"><button>Dodaj posprzątanie</button></a>';
            }
        }
        else
        {
            if($post -> resultGetPost['p_status'] == 'removed')
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