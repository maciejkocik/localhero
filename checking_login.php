<?php
session_start();

if(isset($_SESSION['signed_up']) && isset($_SESSION['user_id']) && isset($_SESSION['user_login']) && isset($_SESSION['user_mod'])
&& $_SESSION['signed_up'] = true)
{
    $signed_up = true;
    $user_id = $_SESSION['user_id'];
    $user_login = $_SESSION['user_login'];
    $user_mod = $_SESSION['user_mod'];
}
else
{
    $signed_up = false;
}
?>