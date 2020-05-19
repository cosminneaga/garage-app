<?php
if(isset($_SERVER['HTTP_REFERER'])){
    require 'auth.php';
    if(isset($_POST['get_status'])){
        define('functions', TRUE);
        require 'functions.php';
        $extract = new extract();
        $data = $extract->extractSurveyStatus($conn, $username_S, $ownedBy_S);
        echo $data;
    }
}
?>