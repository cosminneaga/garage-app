<?php
require('auth.php');
define('functions',TRUE);
require('functions.php');
    if(isset($_SERVER['HTTP_REFERER'])){
        if(isset($_GET['clientID'])){
            $id = $_GET['clientID'];
            $extract = new extract();
            $data = $extract->client($conn, $ownedBy_S, $id);
            echo $data;
        }
        if(isset($_GET['client'])){
            $idd = $_GET['client'];
            $extract = new extract();
            $dat = $extract->getclientID($conn, $ownedBy_S, $idd);
            echo $dat;
        }
    }
?>