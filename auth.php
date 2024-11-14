<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['login_Admin_Id']) || !isset($_SESSION['login_Faculty_Id']))
    header('location:login.php');
}
?>