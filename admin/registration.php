<?php

echo '
<FORM method="POST" action="action.php?page=registration">

<h1>Rejestracja</h1>

<div>';

echo 'Podaj Login: <input type="text" name="login" maxlength=100 minlength=3 required';
if(isset($_POST['login']))
{
    if(isset($_GET['login_error']))
    {
        if($_GET['login_error'] == 0)
        {
            echo '<p>Podano błędny login</p>';
        }
        else if($_GET['login_error'] == 1)
        {
            echo '<p>Podany login jest zajęty.</p>';
        }
        echo '>';
    }
    else
    {
        echo 'value="'.$_POST['login'].'">';
    }
}
else
{
    echo '>';
}


echo 'Podaj e-mail: <input type="email" name="email" maxlength=100 minlength=5';
if(isset($_POST['email']))
{
    
    if(isset($_GET['email_error']))
    {
        if($_GET['email_error'] == 0)
        {
            echo '<p>Podano błędny e-mail.</p>';
        }
        if($_GET['email_error'] == 1)
        {
            echo '<p>Podany e-mail jest zajęty.</p>';
        }
        echo '>';
    }
    else
    {
        echo 'value="'.$_POST['email'].'">';
    }
}
else
{
    echo '>';
}


echo 'Podaj hasło (minimum 5 znaków): <input type="password" name="password" maxlength=50 minlength=5>';
if(isset($_POST['password']))
{
    if(isset($_GET['password_error']))
    {
        if($_GET['password_error'] == 0)
        {
            echo '<p>Podano błędne hasło.</p>';
        }
    }
}


echo 'Powtórz hasło: <input type="password" name="password2" maxlength=50 minlength=5>';
if(isset($_POST['password2']))
{
    if(isset($_GET['password_error2']))
    {
        if($_GET['password_error2'] == 0)
        {
            echo '<p>Powtórzone hasło różni się od pierwotnego.</p>';
        }
    }
}

echo '</div>';
echo '<input type="submit" value"Zarejestruj się">';
?>