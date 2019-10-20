<?php
echo '<link href="assets/css/signin.css" rel="stylesheet" type="text/css">
    <div id="signin" class="text-center">';

if(!$signed_in)
{
    if(isset($_GET['sign_in_error']))
    {
        error("sign_in", "danger", $_GET['sign_in_error']);
    }
    
    if($_REQUEST['page'] != 'sign_in' or isset($_GET['write_text']))
    {
        error("sign_in", "warning", 4);
    }

    
    
    echo '
    <form class="form-signin" method="POST" action="action.php">

    <img class="mb-4" src="img/logo1.png">
    
    <h1 class="h3 mb-3 font-weight-normal">Zaloguj się</h1>
    ';





    echo '
    <label for="inputLogin" class="sr-only">Login</label>
    <input type="text" id="inputLogin" class="form-control" placeholder="Login" name="login" maxlength=100 minlength=3 required autofocus ';
    if(isset($_GET['login']))
    {
        echo 'value="'.$_GET['login'].'">';
    }

    echo '>
    <label for="inputPassword" class="sr-only">Hasło</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Hasło" name="password" maxlength=50 minlength=5 required>
    
    <input type="hidden" name="file" value="sign_in">

    
    <button class="btn btn-lg btn-primary btn-block mt-4" type="submit">Dalej</button>
    </form>';
    
}
else
{
    echo '<h1>Jesteś już zalogowany</h1>';
}
?>