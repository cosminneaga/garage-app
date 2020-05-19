<?php
require('auth.php');
define('functions',TRUE);
require('functions.php');
//  $_SERVER['HTTP_REFERER'] === 'http://192.168.0.129/garage/user/new-booking.php'

    if(isset($_SERVER['HTTP_REFERER'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $postcode = $_POST['postcode'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $mobile = $_POST['mobile'];
        $landline = $_POST['landline'];

        $insert = new insert();
        $insert->insertClient($conn, $ownedBy_S, $username_S, $name, $email, $address, $postcode, $country, $city, $mobile, $landline);
    }

?>