    <section class="text-center">
        <form method="POST" action="action.php" class="form-signin">
          <img class="mb-4" src="img/logo.png" alt="" width="72" height="72">
          <h1 class="h3 mb-3 font-weight-normal">Zarejestruj się</h1>
          <label for="inputLogin" class="sr-only">Login</label>
          <input name="login" type="text" id="inputLogin" class="form-control" placeholder="Login" required autofocus>
          <label for="inputEmail" class="sr-only">Adres email</label>
          <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Adres email" required autofocus>
          <label for="inputPassword" class="sr-only">Hasło</label>
          <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Hasło" required>
          <label for="inputPassword2" class="sr-only">Powtórz hasło</label>
          <input name="password" type="password" id="inputPassword2" class="form-control" placeholder="Powtórz hasło" required>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Zarejestruj się</button>
        </form>
    </section>
      
      

<FORM method="POST" action="action.php">

<h1>Rejestracja</h1>

<div>

<?php
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