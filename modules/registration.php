<?php

if(!$signed_in)
{
    echo '    
    <link href="assets/css/signin.css" rel="stylesheet" type="text/css">
    
    <div id="signin" class="text-center">';
    
    if(isset($_GET['registration_error']))
    {
        error("registration", "danger", $_GET['registration_error']);
    }
    
    if(isset($_GET['email_error']))
    {
        error("registration", "danger", $_GET['email_error'], "email_error");
    }
    
    if(isset($_GET['login_error']))
    {
        error("registration", "danger", $_GET['login_error'], "login_error");        
    }
    if(isset($_GET['password_error']))
    {
        error("registration", "danger", $_GET["password_error"], "password_error");
    }
    if(isset($_GET['password_error2']))
    {
        error("registration", "danger", $_GET["password_error2"], "password_error2");
    }
    
    
    echo '    
    <form class="form-signin" method="POST" action="action.php">

    <img class="mb-4" src="img/logo1.png">
    
    <h1 class="h3 mb-3 font-weight-normal">Zarejestruj się</h1>';

    echo '<label for="inputLogin" class="sr-only">Login</label>
    <input type="text" id="inputLogin" class="form-control" placeholder="Login" name="login" maxlength=100 minlength=3 required autofocus ';
    if(isset($_GET['login']))
    {
        echo 'value="'.$_GET['login'].'"';
    }

    echo '>';


    echo '<label for="inputEmail" class="sr-only">Adres e-mail</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Adres e-mail" name="email" ';
    if(isset($_GET['email']))
    {
        echo 'value="'.$_GET['email'].'"';
    }

    echo ' maxlength=100 minlength=5 required>
    
    <label for="inputPassword" class="sr-only">Hasło</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Hasło" name="password" maxlength=50 minlength=5 required>

    <label for="inputPassword2" class="sr-only">Powtórz hasło</label>
    <input type="password" id="inputPassword2" class="form-control" placeholder="Powtórz hasło" name="password2" maxlength=50 minlength=5 required>


    <input type="hidden" name="file" value="registration">

    <button class="btn btn-lg btn-primary btn-block mt-4" type="submit">Dalej</button>
    
    </form>
    </div>';
}
else
{
    echo 'Jesteś już zalogowany - nie możesz się zarejestrować.';
}
?>