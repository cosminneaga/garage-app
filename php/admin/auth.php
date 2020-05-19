<?php
session_start();
    if (!isset($_SESSION['admin'])) 
    {
      header("Location: ../admin/index.php");
      exit();
    }else{
      $username = $_SESSION['admin'];
    }
?>