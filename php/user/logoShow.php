<?php
require('auth.php');
define('conn',TRUE);
require('conn.php');

if(isset($_GET['user']))
{
    $user = $_GET['user'];
    $sql = "SELECT `image_type`, `image_data` FROM `".$user."_company`";
    $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($res);

    header('Content-type:'.$row['image_type']);
    echo $row['image_data'];
}

?>