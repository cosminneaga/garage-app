<?php
if(isset($_SERVER['HTTP_REFERER'])){
    require 'auth.php';
    if(isset($_GET['update'])){
        define('FunctionS', TRUE);
        require 'functions.php';
        $username = $_POST['username'];
        $update = new update();
        $update->updateSurveyRead($conn, $username);
    }
}
?>