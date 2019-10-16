<?php
$header = 'index.php?page=registration';

$header_plus = '';

$error = 1;

if(isset($_POST['login']) &&  isset($_POST['password'])
&& strlen($_POST['login']) >= 3 && strlen($_POST['login']) <=100
&& strlen($_POST['password']) >= 5 && strlen($_POST['password']) <= 50)
{
    $login = $_POST['login'];
    $password = $_POST['password'];

    $user = new User();
    if($user -> resultConnection)
    {
        $user -> signIn($login, md5($password));

        if($user -> resultSignIn)
        {
            if(isset($user -> signInList['id']))
            {
                if($user -> signInList['status'] != 0)
                {
                    error = -1;

                    session_start();
                    $_SESSION['signed_in'] = true;
                    $_SESSION['user_id'] = $user -> signInList['id'];
                    $_SESSION['user_login'] = $user -> signInList['login'];
                    $_SESSION['user_mod'] = $user -> signInList['mod'];
                    $header = 'index.php?page=sign_in_succes';
                }
                else
                {
                    error = 3;
                }
            }
            else
            {
                $error = 2;
            }
        }
    }
}

if($error != -1)
{
    $header_plus = '&sign_in_error='.$error;
}

header('Location:'.$header.$header_plus);
?>