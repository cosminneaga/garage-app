<?php
require('auth.php');
define('functions',TRUE);
require('functions.php');
//  $_SERVER['HTTP_REFERER'] === 'http://192.168.0.129/garage/user/new-booking.php'

    if(isset($_SERVER['HTTP_REFERER'])){
        if(isset($_GET['update'])){
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $postcode = $_POST['postcode'];
            $country = $_POST['country'];
            $city = $_POST['city'];
            $mobile = $_POST['mobile'];
            $landline = $_POST['landline'];

            $update = new update();
            $update->updateClient($conn, $ownedBy_S, $username_S, $id, $name, $email, $address, $postcode, $country, $city, $mobile, $landline);
        }
        if(isset($_GET['update-status'])){
            $str = $_POST['str'];
            $id = $_POST['id'];

            $update = new update();
            $update->updateClientSurveyStatus($conn, $ownedBy_S, $id, $str);
        }
    }

?>