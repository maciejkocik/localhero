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
?>