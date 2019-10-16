<?php

echo '
<FORM method="POST" action="action.php">

<h1>Rejestracja</h1>

<div>';

if(isset($_GET['registration_error']))
{
    {
        echo '<p>Wystąpił błąd, spróbuj ponownie.</p>';
    }
}

echo 'Podaj Login: <input type="text" name="login" maxlength=100 minlength=3 required';
if(isset($_GET['login']))
{
    if(isset($_GET['login_error']))
    {
        echo '>';
        if($_GET['login_error'] == 1)
        {
            echo '<p>Podano błędny login</p>';
        }
        else if($_GET['login_error'] == 2)
        {
            echo '<p>Podany login jest zajęty.</p>';
        }
        
    }
    else
    {
        echo 'value="'.$_GET['login'].'">';
    }
}
else
{
    echo '>';
}


echo 'Podaj e-mail: <input type="email" name="email" maxlength=100 minlength=5 required';
if(isset($_GET['email']))
{
    
    if(isset($_GET['email_error']))
    {
        echo '>';
        if($_GET['email_error'] == 1)
        {
            echo '<p>Podano błędny e-mail.</p>';
        }
        if($_GET['email_error'] == 2)
        {
            echo '<p>Podany e-mail jest zajęty.</p>';
        }
    }
    else
    {
        echo 'value="'.$_GET['email'].'">';
    }
}
else
{
    echo '>';
}


echo 'Podaj hasło (minimum 5 znaków): <input type="password" name="password" maxlength=50 minlength=5 required>';
if(isset($_GET['password']))
{
    if(isset($_GET['password_error']))
    {
        if($_GET['password_error'] == 1)
        {
            echo '<p>Podano błędne hasło.</p>';
        }
    }
}


echo 'Powtórz hasło: <input type="password" name="password2" maxlength=50 minlength=5 required>';
if(isset($_GET['password2']))
{
    if(isset($_GET['password_error2']))
    {
        if($_GET['password_error2'] == 1)
        {
            echo '<p>Powtórzone hasło różni się od pierwotnego.</p>';
        }
    }
}

echo '<input type="hidden" name="file" value="registration">

</div>';
echo '<input type="submit" value"Zarejestruj się">';
?>