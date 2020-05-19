<?php
require('auth.php');
define('functions',TRUE);
require('functions.php');
//  $_SERVER['HTTP_REFERER'] === 'http://192.168.0.129/garage/user/new-booking.php'

    if(isset($_SERVER['HTTP_REFERER'])){
        $reg = $_POST['reg'];
        $make = $_POST['make'];
        $model = $_POST['model'];
        $odometer = $_POST['odometer'];
        $fuel = $_POST['fuel'];
        $vin = $_POST['vin'];

        $insert = new insert();
        $insert->insertVehicle($conn, $username_S, $ownedBy_S, $reg, $make, $model, $vin, $odometer, $fuel);
    }

?>