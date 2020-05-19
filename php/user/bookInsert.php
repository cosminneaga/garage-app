<?php
require('auth.php');
define('functions',TRUE);
require('functions.php');
//  $_SERVER['HTTP_REFERER'] === 'http://192.168.0.129/garage/user/new-booking.php'

    if(isset($_SERVER['HTTP_REFERER'])){
        $base64 = $_POST['data'];
        $name = $_POST['name'];
        $mob = $_POST['mob'];
        $reg = $_POST['reg'];
        $date = $_POST['date'];
        $notes = $_POST['notes'];

        $insert = new insert();
        $insert->insertBooking($conn, $username_S, $ownedBy_S, $name, $mob, $reg, $date, $notes, $base64);
    }

?>