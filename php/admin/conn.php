<?php

    if(!defined('conn'))
    {
        header('Location: ../../index.php');
    }
    elseif(defined('conn'))
    {
        date_default_timezone_set('GMT');
        $conn = mysqli_connect("127.0.0.1", "root", "password", "gdb");
        $conn_schema = mysqli_connect("127.0.0.1", "root", "password", "information_schema");
        if(!$conn)
        {
            die("Connection failed: " .mysqli_connect_error());
        }
    }
?>