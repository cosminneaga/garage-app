<?php
    require('auth.php');
    define('conn', TRUE);
    require('conn.php');

    if(isset($_SERVER['HTTP_REFERER'])){
        
        if(isset($_GET['username-check'])){

            $username = $_GET['username-check'];
            $sql = "SELECT `username` FROM `user` WHERE `username` = '$username'";
            $res = mysqli_query($conn, $sql);
            

            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            echo json_encode($data);
            mysqli_close($conn);
        }
        if(isset($_GET['name'])){
            $var = $_GET['name'];
            $explode = explode("|",$var);
            $name = $explode[0];
            $postcode = $explode[1];
            $address = $explode[2];
        
            $sql = "SELECT * FROM `".$ownedBy_S."_clients` WHERE `name` = '$name' AND `postcode` = '$postcode' AND `address` = '$address'";
            $result = mysqli_query($conn,$sql);
        
            $data = array();
            while($row = mysqli_fetch_object($result)){
                array_push($data, $row);
            }
            echo json_encode($data);
            mysqli_close($conn);
        }
        if(isset($_GET['reg'])){
            $reg = $_GET['reg'];

            $sql = "SELECT * FROM `".$ownedBy_S."_vehicle` WHERE `reg` = '$reg'";
            $result = mysqli_query($conn,$sql);
        
            $data = array();
            while($row = mysqli_fetch_object($result)){
                array_push($data, $row);
            }
            echo json_encode($data);
            mysqli_close($conn);
        }
    }

?>