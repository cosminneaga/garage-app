<?php

    if(!defined('FunctionS')){
        header('location: ../../admin/index.php');
    }else{
        define('conn',TRUE);
        require('conn.php');

        function clean_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = strip_tags($data);
            $data = htmlspecialchars($data);
            return $data;
        }

    class delete{
        // delete user
        function dUser($conn, $ownedBy, $username){
            $sql = "DELETE FROM `".$ownedBy."_workers` WHERE `username` = '$username'";
            $res = mysqli_query($conn, $sql);
            
            $sql1 = "DELETE FROM `user` WHERE `username` = '$username'";
            $res1 = mysqli_query($conn, $sql1);

            if($res && $res1){
                header('location: ../../user/uView.php');
            }
        }
    }

    class update{
        function updateSurveyStatus($conn, $username, $owned_by){
            $sql = "UPDATE `user` SET `survey_status` = 'not completed' WHERE `username` = '$username' AND `owned_by` = '$owned_by'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }
        function userUnBlock($conn, $username){
            $sql = "UPDATE `user` SET `status` = 'unblocked' WHERE `username` = '$username'";
            $res = mysqli_query($conn, $sql);
            if($res){
                header('location: ../../user/uView.php');
            }
        }
        function userBlock($conn, $username){
            $sql = "UPDATE `user` SET `status` = 'blocked' WHERE `username` = '$username'";
            $res = mysqli_query($conn, $sql);
            if($res){
                header('location: ../../user/uView.php');
            }
        }
        function updateSurveyRead($conn, $username){
            $sql = "UPDATE `admin_survey_data_comments` SET `status` = 'read' WHERE `username` = '$username'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }
    }
    class extract{
        function login($conn, $username, $password){
            
            $sql = "SELECT `username` FROM `admin` WHERE `username` = '$username' AND `password` = '".MD5($password)."'";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $num = mysqli_num_rows($result);
            if($num > 0){
                session_start();
                $_SESSION['admin'] = $username;
                header('Location: dashboard.php');
            }
        }
        
        // extract user details
        function userShow($conn){
            $sql = "SELECT * FROM `user`";
            $res = mysqli_query($conn, $sql);
            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }
        function userNum($conn){
            $sql = "SELECT * FROM `user`";
            $res = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($res);
            return $num;
        }

        // database size
        function getDBSize($conn){
            $sql = "SELECT SUM(((DATA_LENGTH + INDEX_LENGTH)/1024/1024)) AS 'MB' FROM `TABLES` WHERE `TABLE_SCHEMA` = 'gdb' ";
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $row = mysqli_fetch_assoc($res);
            return $row;
        }

        // get all 'not-read' comments
        function getComments($conn){
            $sql= "SELECT DISTINCT `username`, `status` FROM `admin_survey_data_comments` WHERE `status` = 'not read' ORDER BY `created_on` DESC";
            $res = mysqli_query($conn, $sql);
            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }
        function getCommentByQuestionNo($conn, $username, $question_no){
            $sql = "SELECT `comment`, `created_on` FROM `admin_survey_data_comments` WHERE `username` = '$username' AND `question_no` = '$question_no'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_object($res);
            return $row;
        }

        // get survey numbers data
        function getSurveyNumbersPerQuestion($conn, $question){
            $sql = "SELECT * FROM `admin_survey_data` WHERE `question_no` = '$question'";
            $res = mysqli_query($conn, $sql);
            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }
    }
    class insert {
        // NEEDS MODIFYING AND INPUT FORM ACCORDINGLY #################################################################################
        //###############################################################################################################################
        // user insert and create their tables
        function userInsert($conn, $username, $name, $email, $password){
            $sqlUserInsert = "INSERT INTO `user` (`username`, `name`, `email`, `password`, `owned_by`) VALUES ('$username','$name','$email','".MD5($password)."','$username')";
            mysqli_query($conn, $sqlUserInsert) or die(mysqli_error($conn));
            // WORKERS TABLE
            $sql_workers = "CREATE TABLE `".$username."_workers` (
                `username` VARCHAR(50) NOT NULL,
                `name` VARCHAR(100) NOT NULL,
                `email` VARCHAR(100) NOT NULL,
                `mob_one` VARCHAR(50) NOT NULL,
                `mob_two` VARCHAR(50) NOT NULL,
                `address` VARCHAR(200) NOT NULL,
                `city` VARCHAR(150) NOT NULL,
                `postcode` VARCHAR(100) NOT NULL,
                `country` VARCHAR(100) NOT NULL,
                `auth_level` ENUM('manager','user') NOT NULL,
                PRIMARY KEY (`username`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            mysqli_query($conn,$sql_workers) or die(mysqli_error($conn));
            // COMPANY TABLE
            $sql_company = "CREATE TABLE `".$username."_company` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `image_type` VARCHAR(255) NULL,
                `image_data` LONGBLOB NULL,
                `name` VARCHAR(255) NOT NULL,
                `email` VARCHAR(100) NOT NULL,
                `address` VARCHAR(200) NOT NULL,
                `city` VARCHAR(150) NOT NULL,
                `postcode` VARCHAR(100) NOT NULL,
                `country` VARCHAR(100) NOT NULL,
                `registration_no` VARCHAR(100) NOT NULL,
                `mob_one` VARCHAR(50) NOT NULL,
                `mob_two` VARCHAR(50) NOT NULL,
                `landline` VARCHAR(50) NOT NULL,
                `tax_value` INT NOT NULL,
                `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `owned_by` VARCHAR(50) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ";
            mysqli_query($conn,$sql_company) or die(mysqli_error($conn));
            // CLIENTS TABLE
            $sql_clients = "CREATE TABLE `".$username."_clients` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(100) NOT NULL,
                `email` VARCHAR(100) NOT NULL,
                `address` VARCHAR(200) NOT NULL,
                `city` VARCHAR(150) NOT NULL,
                `postcode` VARCHAR(100) NOT NULL,
                `country` VARCHAR(100) NOT NULL,
                `mob_one` VARCHAR(50) NOT NULL,
                `mob_two` VARCHAR(50) NOT NULL,
                `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `created_by` VARCHAR(50) NOT NULL,
                `owned_by` VARCHAR(50) NOT NULL,
                `survey_status` VARCHAR(100) NOT NULL,
                `session_id` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ";
            mysqli_query($conn,$sql_clients) or die(mysqli_error($conn));
            // INVOICE TABLE
            $sql_invoice = "CREATE TABLE `".$username."_invoice` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `invoice_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `company_name` LONGTEXT NOT NULL,
                `company_address` VARCHAR(200) NOT NULL,
                `company_city` VARCHAR(150) NOT NULL,
                `company_postcode` VARCHAR(100) NOT NULL,
                `company_country` VARCHAR(100) NOT NULL,
                `company_vat` VARCHAR(100) NOT NULL,
                `company_mob_one` VARCHAR(50) NOT NULL,
                `company_mob_two` VARCHAR(50) NOT NULL,
                `company_landline` VARCHAR(50) NOT NULL,
                `job_time` DOUBLE(8,2) DEFAULT 0,
                `hourly_charge` DOUBLE(8,2) DEFAULT 0,
                `client_name` VARCHAR(100) NOT NULL,
                `client_address` VARCHAR(200) NOT NULL,
                `client_city` VARCHAR(150) NOT NULL,
                `client_postcode` VARCHAR(100) NOT NULL,
                `client_country` VARCHAR(100) NOT NULL,
                `client_mob_one` VARCHAR(50) NOT NULL,
                `client_mob_two` VARCHAR(50) NOT NULL,
                `vehicle_reg` VARCHAR(50) NOT NULL,
                `vehicle_make` VARCHAR(50) NOT NULL,
                `vehicle_model` VARCHAR(150) NOT NULL,
                `vehicle_vin` VARCHAR(250) NOT NULL,
                `vehicle_odometer` VARCHAR(100) NOT NULL,
                `vehicle_fuel` VARCHAR(100) NOT NULL,
                `sub_total` DOUBLE(10,2) DEFAULT 0,
                `tax` DOUBLE(10,2) DEFAULT 0,
                `discount` DOUBLE(8,2) DEFAULT 0,
                `grand_total` DOUBLE(12,2) DEFAULT 0,
                `status` ENUM('paid','unpaid') NOT NULL,
                `remaining_balance` DOUBLE(10,2) DEFAULT 0,
                `created_by` VARCHAR(50) NOT NULL,
                `owned_by` VARCHAR(50) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ";
            mysqli_query($conn,$sql_invoice) or die(mysqli_error($conn));
            // INVOICE ITEMS TABLE
            $sql_items ="CREATE TABLE `".$username."_invoice_items` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `item_name` VARCHAR(300) NOT NULL,
                `item_quantity` INT DEFAULT 0,
                `item_price` DOUBLE(8,2) DEFAULT 0,
                `labour_price` DOUBLE(8,2) DEFAULT 0,
                `total_price` DOUBLE(8,2) DEFAULT 0,
                `invoice_id` INT UNSIGNED NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ";
            mysqli_query($conn,$sql_items) or die(mysqli_error($conn));
            // VEHICLE TABLE
            $sql_vehicle ="CREATE TABLE `".$username."_vehicle` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `reg` VARCHAR(50) NOT NULL,
                `make` VARCHAR(50) NOT NULL,
                `model` VARCHAR(150) NOT NULL,
                `vin` VARCHAR(250) NOT NULL,
                `odometer` VARCHAR(100) NOT NULL,
                `fuel` VARCHAR(100) NOT NULL,
                `created_by` VARCHAR(50) NOT NULL,
                `owned_by` VARCHAR(50) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ";
            mysqli_query($conn,$sql_vehicle) or die(mysqli_error($conn));
            // BOOKINGS TABLE
            $sql_bookings ="CREATE TABLE `".$username."_bookings` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `client_name` VARCHAR(100) NOT NULL,
                `client_mob_one` VARCHAR(50) NOT NULL,
                `vehicle_reg` VARCHAR(50) NOT NULL,
                `notes` LONGTEXT NOT NULL,
                `booked_on` DATETIME NOT NULL,
                `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `image_data` longblob DEFAULT NULL,
                `created_by` VARCHAR(50) NOT NULL,
                `owned_by` VARCHAR(50) NOT NULL,
                PRIMARY KEY (`id`)
            )ENGINE=InnoDB DEFAULT CHARSET=utf8; ";
            mysqli_query($conn, $sql_bookings) or die(mysqli_error($conn));
            // SURVEY DATA TABLES
            $sql_survey_data_table = "CREATE TABLE `".$username."_survey_data` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `client_id` INT UNSIGNED NOT NULL,
                `question_no` INT(10) NOT NULL,
                `answer` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`id`)
            )ENGINE=InnoDB DEFAULT CHARSET=utf8; ";
            mysqli_query($conn, $sql_survey_data_table) or die(mysqli_error($conn));
            // DATA FOR GRAPHS VIEW
            $sql_graphs_data = "CREATE OR REPLACE VIEW ".$username."_graphs_data AS SELECT
            ".$username."_invoice.id ,".$username."_invoice.invoice_date, ".$username."_invoice.job_time, ".$username."_invoice.hourly_charge, ".$username."_invoice.discount, ".$username."_invoice.status, ".$username."_invoice.remaining_balance, ".$username."_invoice_items.item_price, ".$username."_invoice_items.labour_price, ".$username."_invoice_items.total_price, ".$username."_invoice.sub_total, ".$username."_invoice.grand_total, ".$username."_invoice.created_by FROM ".$username."_invoice INNER JOIN ".$username."_invoice_items WHERE ".$username."_invoice.id = ".$username."_invoice_items.invoice_id";
            mysqli_query($conn, $sql_graphs_data) or die(mysqli_error($conn));
        }
    }
}
?>