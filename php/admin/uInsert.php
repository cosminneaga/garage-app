<?php

    if(isset($_POST['token'])){
        session_start();
        if($_POST['token'] === $_SESSION['token-insert']){
            define('FunctionS',TRUE);
            require('functions.php');
            $username = $_POST['username'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $insert = new insert();
            $insert->userInsert($conn, $username, $name, $email, $password);
        }
    }
?>