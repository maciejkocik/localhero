<?php

if(!$signed_in)
{
    echo '
    <FORM method="POST" action="action.php">

    <h1>Logowanie</h1>

    <div>';


    if(isset($_GET['sign_in_error']))
    {
        if($_GET['sign_in_error'] == 1)
        {
            echo '<p>Wystąpił błąd, spróbuj ponownie.</p>';
        }
        else if($_GET['sign_in_error'] == 2)
        {
            echo '<p>Nieprawidłowy login lub hasło.</p>';
        }
        else if($_GET['sign_in_error'] == 3)
        {
            echo '<p>Podane konto ma zablokowaną możliwość logowania.</p>';
        }
    }

    if($_REQUEST['page'] != 'sign_in')
    {
        echo '<p>Aby kontynuować, musisz się zalogować lub zarejestrować.</p>';
    }


    echo 'Podaj Login: <input type="text" name="login" maxlength=100 minlength=3 required';
    if(isset($_GET['login']))
    {
        echo 'value="'.$_GET['login'].'">';
    }

    echo '>
    
    Podaj hasło: <input type="password" name="password" maxlength=50 minlength=5 required>
    
    <input type="hidden" name="file" value="sign_in">

    </div>
    
    <input type="submit" value"Zarejestruj się">';
    
}
else
{
    echo '<h1>Jesteś już zalogowany</h1>';
}
?>