<?php

if (!defined('conn')) {
    header('Location: ../../index.php');
} elseif (defined('conn')) {

    date_default_timezone_set('GMT');

    $conn = mysqli_connect(
        getenv('HOST'),
        getenv('USER'),
        getenv('PASSWORD'),
        getenv('DATABASE'),
        getenv('PORT')
    ) or die('Failed to connect to the database, died with error: ' . mysqli_connect_error());
}
?>