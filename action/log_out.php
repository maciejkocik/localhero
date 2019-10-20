<?php

session_start();

if(isset($_SESSION['signed_in']))
{
    unset($_SESSION['signed_in']);
}

if(isset($_SESSION['user_id']))
{
    unset($_SESSION['user_id']);
}

if(isset($_SESSION['user_login']))
{
    unset($_SESSION['user_login']);
}

if(isset($_SESSION['user_mod']))
{
    unset($_SESSION['user_mod']);
}

header('Location:index.php?page=log_out_succes');
?>