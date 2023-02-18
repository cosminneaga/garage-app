<?php
session_start();

if (!isset($_SESSION["own"])) {

  header("Location: ../index.php");
  exit();

} else {

  $username_S = $_SESSION['username'];
  $ownedBy_S = $_SESSION['own'];
  $level = $_SESSION['level'];

  function generateRandomString($length = 20)
  {
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
  }

}
?>