<?php

    if(!defined('conn'))
    {
        header('Location: ../../index.php');
    }
    elseif(defined('conn'))
    {
        date_default_timezone_set('GMT');
        $conn = mysqli_connect("localhost", "root", "", "gdb");
        $conn_schema = mysqli_connect("localhost", "root", "", "information_schema");
        if(!$conn)
        {
            die("Connection failed: " .mysqli_connect_error());
        }
    }
?>