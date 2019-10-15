<?php

$header = 'index.php?page=registration';

$header_plus = '';

$error = 1;

$login_error = -1;
$email_error = -1;
$password_error = -1;
$password2_error = -1;

if(isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']))
{
    $user = new User();
    if($user -> resultConnection)
    {
        $login = $_POST['login'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        $user -> registrationCheck($login, $email);
        
        if($user -> resultRegistrationCheck)
        {
            //login
            if(strlen($login) >= 3 && strlen($login) <= 100)
            {
                if(! $user -> loginCheck)
                {
                    $login_error = 2
                }
            }
            else
            {
                $login_error = 1;
            }

            //email
            if(strlen($email) >= 5 && strlen($email) <= 100 && filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                if(! $user -> emailCheck)
                {
                    $email_error = 2
                }
            }
            else
            {
                $email_error = 1;
            }

            //password
            if(strlen($password) >= 5 && strlen($password) <= 50)
            {
            
            }
            else
            {
                $password_error = 1;
            }
            
            //password2
            if($password2 == $password1)
            {
            
            }
            else
            {
                $password_error = 1;
            }

            if($login_error == -1 && $email_error == -1 && $password_error == -1 && $password2_error == -1)
            {
                $user -> registration($login,$email,md5($password));

                if($user -> resultRegistration)
                {

                    $error = -1;
                    $header = 'index.php?page=registration_succes';

                    $user -> getLastId();

                    if($user -> resultGetLastId)
                    {
                        session_start();
                        $_SESSION['signed_up'] = true;
                        $_SESSION['user_id'] = $user -> lastUser['id'];
                        $_SESSION['user_login'] = $user -> lastUser['login'];
                    }
                }
            }
            else
            {
                $header_plus = '';
                $error = 1;

                if($login_error != -1)
                {
                    $header_plus = $header_plus.'&login_error='.$login_error;
                }
                else
                {
                    $header_plus = $header_plus.'&login='.$login;
                }
                if($email_error != -1)
                {
                    $header_plus = $header_plus.'&login_error='.$email_error;
                }
                else
                {
                    $header_plus = $header_plus.'&email='.$email;
                }
                if($password_error != -1)
                {
                    $header_plus = $header_plus.'&login_error='.$password_error;
                }
                if($password2_error != -1)
                {
                    $header_plus = $header_plus.'&login_error='.$password2_error;
                }
            }
        }
    }
}

if($error == 1)
{
    $header_plus = $header_plus.'&login_error='.$error;
}

header('Location:'.$header.$header_plus);

?>