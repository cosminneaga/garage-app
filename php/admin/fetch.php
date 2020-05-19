<?php   

    if(isset($_SERVER['HTTP_REFERER'])){
            define('conn',TRUE);
            require('conn.php');

            // USERNAME FETCH
        if(isset($_GET['username'])){

            $username = $_GET['username'];
        
            $sql = "SELECT `username` FROM `admin` WHERE `username` = '$username'";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
            $data = array();
            while($row = mysqli_fetch_object($result)){
                array_push($data, $row);
            }

            echo json_encode($data);
            mysqli_close($conn);

        }
            // PASSWORD FETCH
        if(isset($_GET['user'])){

            $user = $_GET['user'];
            $sql_pass = "SELECT `password` FROM `admin` WHERE `username` = '$user'";
            $res_pass = mysqli_query($conn, $sql_pass) or die(mysqli_error($conn));

            $pass_data = array();
            while($row_pass = mysqli_fetch_object($res_pass)){
                array_push($pass_data, $row_pass);
            }

            echo json_encode($pass_data);
            mysqli_close($conn);
        }
            // USERNAME FECTH ON USER CREATE
        if(isset($_GET['token'])){
            session_start();
            if($_GET['token'] === $_SESSION['token']){
                
                $user_tk = $_GET['userC'];

                $sql_tk = "SELECT `username` FROM `user` WHERE `username` = '$user_tk'";
                $res_tk = mysqli_query($conn, $sql_tk);

                $data_tk = array();
                while($row_tk = mysqli_fetch_object($res_tk)){
                    array_push($data_tk, $row_tk);
                }
                echo json_encode($data_tk);
                mysqli_close($conn);
            }
        }
    }
?>