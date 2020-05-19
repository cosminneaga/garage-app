<?php
require('auth.php');
define('functions',TRUE);
require('functions.php');
$update = new update();
$delete = new delete();
if(isset($_GET['user-unblock']))
{
    $username = $_GET['user-unblock'];
    $update->userUnBlock($conn, $username);
}
if(isset($_GET['user-block']))
{
    $username = $_GET['user-block'];
    $update->userBlock($conn, $username);
}
if(isset($_GET['user-delete']))
{
    $username = $_GET['user-delete'];
    $delete->dUser($conn, $ownedBy_S, $username);
}
?>