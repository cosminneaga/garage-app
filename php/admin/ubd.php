<?php
require('auth.php');
define('FunctionS',TRUE);
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
if(isset($_GET['user-delete']) && isset($_GET['owned_by']))
{
    $username = $_GET['user-delete'];
    $own = $_GET['owned_by'];
    $delete->dUser($conn, $own, $username);
}
?>