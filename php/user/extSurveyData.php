<?php
require('auth.php');
define('functions',TRUE);
require('functions.php');
if(isset($_SERVER['HTTP_REFERER'])){
    if(isset($_POST['client_id'])){
        $id = $_POST['client_id'];
        $extract = new extract();
        $data = $extract->extractSurveyData($conn, $ownedBy_S, $id);
        echo $data;
    }
    if(isset($_POST['owned_by'])){
        $extract = new extract();
        $s_data = $extract->extractOverallSurveyData($conn, $ownedBy_S);
        echo $s_data;
    }
    if(isset($_POST['question_no'])){
        $question_no = $_POST['question_no'];
        $extract = new extract();
        $q_data = $extract->extractOverallSurveyByQuestionNo($conn, $ownedBy_S, $question_no);
        echo $q_data;
    }
}
?>