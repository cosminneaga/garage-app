<?php
if(isset($_SERVER['HTTP_REFERER'])){
    define('FunctionS', TRUE);
    require 'functions.php';
    if(isset($_GET['update_status'])){
        $username = $_GET['username'];
        $own = $_GET['own'];
        $update = new update();
        $update->updateSurveyStatus($conn, $username, $own);
    }
    if(isset($_GET['get_numbers'])){
        $question_no = $_POST['question_no'];
        $extract = new extract();
        $data = $extract->getSurveyNumbersPerQuestion($conn, $question_no);
        echo $data;
    }
}
?>