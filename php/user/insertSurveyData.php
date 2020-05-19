<?php
if(isset($_GET['client']) && isset($_GET['session']) && isset($_GET['session_id']) && isset($_GET['ssl'])){
    define('functions',TRUE);
    require('functions.php');
    if(isset($_POST['data'])){
        $data = $_POST['data'];
        $id = $_GET['session'];
        $owned_by = $_GET['session_id'];
        $session = $_GET['ssl'];
        $insert = new insert();
        $insert->insertClientSurveyData($conn, $owned_by, $id, $session, $data);
        }
    else{
        echo 'There is a problem with our servers, your data was not sent.';
        echo 'Please inform administrator.';
    }
}
if(isset($_GET['company']) && isset($_GET['username']) && isset($_GET['owned_by'])){
    if(isset($_POST['data'])){
        define('functions',TRUE);
        require('functions.php');
        $data = $_POST['data'];
        $username = $_GET['username'];
        $owned = $_GET['owned_by'];
        $insert = new insert();
        $response = $insert->insertCompanySurveyData($conn, $username, $owned, $data);
        echo $response;
    }else{
        echo 'There is a problem with our servers, your data was not sent.';
        echo 'Please inform administrator.';
    }
}
?>