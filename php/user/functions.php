<?php
if(!defined('functions'))
{
    header('Location: ../../user-portal.php');
}
else
{
    define('conn', TRUE);
    require('conn.php');
    
    // FUNCTION CONVERT TIME TO STRING
    function timeToString($decimal){
        $hour = floor($decimal);
        $min = round(60*($decimal - $hour));
        if(strlen($min) === 1){
            $min = '0'.$min;
        }
        if(strlen($hour) === 1){
            $hour = '0'.$hour;
        }
        return $hour.':'.$min;
    }


    // to extract the invoice id from database and calculate next one
    class invoiceID{

        // private $id;
        // extract the id
        function extractID($conn, $user_owned_by){
            $sql = "SELECT `id` FROM `".$user_owned_by."_invoice` ORDER BY `id` DESC";
            $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));
            $row = mysqli_num_rows($res);
            $row_last_id = mysqli_fetch_assoc($res);
            $last_id = implode('/',$row_last_id);
            // $this->id = $last_id;
            return $last_id;
        }

        // // get next id increment by 1
        // function nextId(){
        //     $id = $this->id;
        //     $next_id = $id + 1;
        //     return $next_id;
        // }

    }

    // calculate time difference from input
    class time{
            
        function differenceInHours($startdate,$enddate){
            $starttimestamp = strtotime($startdate);
            $endtimestamp = strtotime($enddate);
            $timeDifference = $endtimestamp - $starttimestamp;
            $minutes = $timeDifference / 60;
            $hours = $minutes / 60;
            $decimal = number_format((float)$hours, 2, '.', '');
            return $decimal;
        }
        
        
        function calculateTimePrice($time, $price){
            $timeSum = $time * $price;
            return $timeSum;
        }
    }

    // sanitize user input
    function clean_input($string){
        $string = stripslashes($string);
        $string = strip_tags($string);
        $string = htmlspecialchars($string);
        return $string;
    }
    
    //function escape string and first character of each string uppercase
    function escape_string_ucword($conn, $string){
        clean_input($string);
        $string = ucwords($string);
        $string = mysqli_real_escape_string($conn, $string);
        return $string;
    } 

    // function escape string and all characters uppercase
    function escape_string_strtoupper($conn, $string){
        clean_input($string);
        $string = strtoupper($string);
        $string = mysqli_real_escape_string($conn, $string);
        return $string;
    }

    // function escape string and all characters lowercase
    function escape_string_strtolower($conn, $string){
        clean_input($string);
        $string = strtolower($string);
        $string = mysqli_real_escape_string($conn, $string);
        return $string;
    }


    // calculate the tax on the invoice
    function calculateTax($price, $taxValue){
        $percentaje = ($price / 100) * $taxValue;
        $grandTotal = $price + $percentaje;
        return $grandTotal;
    }

    // SQL #########################################################################################################################################################region

    // SQL DELETE QUERIES
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

        // delete older booking
        function oldBook($conn, $ownedBy, $today){
            $sql = "DELETE FROM `".$ownedBy."_bookings` WHERE DATE (`booked_on`) < '$today'";
            mysqli_query($conn, $sql);
        }
    }


    // SQL UPDATE QUERIES
    class update{
        // update user created by manager-user
        function updUser($conn, $ownedBy, $username, $name, $email, $mobOne, $mobTwo, $address, $city, $postcode, $country){
            $escName = escape_string_ucword($conn, $name);
            $escEmail = escape_string_strtolower($conn, $email);
            $escMobOne = escape_string_strtoupper($conn, $mobOne);
            $escMobTwo = escape_string_strtoupper($conn, $mobTwo);
            $escAddress = escape_string_ucword($conn, $address);
            $escCity = escape_string_ucword($conn, $city);
            $escPostcode = escape_string_strtoupper($conn, $postcode);
            $escCountry = escape_string_ucword($conn, $country);
            $sql = "UPDATE `".$ownedBy."_workers` SET `name` = '$escName', `email` = '$escEmail', `mob_one` = '$escMobOne', `mob_two` = '$escMobTwo', `address` = '$escAddress', `city` = '$escCity', `postcode` = '$escPostcode', `country` = '$escCountry' WHERE `username` = '$username'";
            $res = mysqli_query($conn, $sql);

            $sql1 = "UPDATE `user` SET `name` = '$escName', `email` = '$escEmail' WHERE `username` = '$username'";
            $res1 = mysqli_query($conn, $sql1);

            if($res && $res1){
                $url = "../user/uEdit.php?user-retour=".$username;
                header('Location:'.$url);
                exit();
            }
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

        // update company details
        function companyUpdate($conn, $ownedBy, $name, $email, $address, $city, $postcode, $country, $reg, $mobOne, $mobTwo, $landline, $tax){
            $escName = escape_string_strtoupper($conn, $name);
            $escEmail = escape_string_strtolower($conn, $email);
            $escAddress = escape_string_ucword($conn, $address);
            $escCity = escape_string_ucword($conn, $city);
            $escPostcode = escape_string_strtoupper($conn, $postcode);
            $escCountry = escape_string_ucword($conn, $country);
            $escReg = escape_string_strtoupper($conn, $reg);
            $escMobOne = escape_string_strtoupper($conn, $mobOne);
            $escMobTwo = escape_string_strtoupper($conn, $mobTwo);
            $escLandline = escape_string_strtoupper($conn, $landline);
            $escTax = escape_string_strtoupper($conn, $tax);
        $sql = "UPDATE `".$ownedBy."_company` SET `name` = '$escName', `email` = '$escEmail', `address` = '$escAddress', `city` = '$escCity', `postcode` = '$escPostcode', `country` = '$escCountry', `registration_no` = '$escReg', `mob_one` = '$escMobOne', `mob_two` = '$escMobTwo', `landline` = '$escLandline', `tax_value` = '$escTax'";
        mysqli_query($conn,$sql) or die(mysqli_error($conn));
        }

        // update company logo traditional way
        function companyLogo($conn, $ownedBy, $logoProperties, $logoData){
            $sql = "UPDATE `".$ownedBy."_company` SET `image_type` = '$logoProperties', `image_data` = '$logoData'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }
        // update client details
        function updateClient($conn, $ownedBy, $username, $id, $name, $email, $address, $postcode, $country, $city, $mob, $landline){
            $escName = escape_string_ucword($conn, $name);
            $escAddress = escape_string_ucword($conn, $address);
            $escEmail = escape_string_strtolower($conn, $email);
            $escPostcode = escape_string_strtoupper($conn, $postcode);
            $escCountry = escape_string_ucword($conn, $country);
            $escCity = escape_string_ucword($conn, $city);
            $escMob = escape_string_strtoupper($conn, $mob);
            $escLandline = escape_string_strtoupper($conn, $landline);

            $sqlU = "UPDATE `".$ownedBy."_clients` SET `name` = '$escName', `email` = '$escEmail', `address` = '$escAddress', `city` = '$escCity', `postcode` = '$escPostcode', `country` = '$escCountry', `mob_one` = '$escMob', `mob_two` = '$escLandline', `created_by` = '$username' WHERE `id` = '$id'";
            mysqli_query($conn, $sqlU) or die (mysqli_error($conn));
        }
        // update client survey status
        function updateClientSurveyStatus($conn, $ownedBy, $id, $str){
            $sql = "UPDATE `".$ownedBy."_clients` SET `survey_status` = 'not completed', `session_id` = '$str' WHERE `id` = '$id'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }
        // update some part of invoice table
        function updateNewDataInvoice($conn, $ownedBy, $invoiceID, $subTotal, $grandTotal, $job_time){
            $sql = "UPDATE `".$ownedBy."_invoice` SET `sub_total` = '$subTotal', `grand_total` = '$grandTotal', `job_time` = '$job_time' WHERE `id` = '$invoiceID'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }
    }



    // SQL EXTRACT QUERIES
    class extract{
        // extract user data for login
        function extractLGNUser($conn, $user){
            $sql = "SELECT `username`, `password`, `status`, `owned_by`, `auth_level` FROM `user` WHERE `username` = '$user'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            return $row;
        }
        // extract company details
        function company($conn, $ownedBy){
            $sql = "SELECT * FROM `".$ownedBy."_company`";
            $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));
            $row = mysqli_fetch_assoc($res);
            return $row;
        }
        // extract company row number
        function companyNum($conn, $ownedBy){
            $sql = "SELECT * FROM `".$ownedBy."_company`";
            $res = mysqli_query($conn,$sql);
            $num = mysqli_num_rows($res);
            return $num;
        }
        // extract user info for viewing and editing user side
        function userEXT($conn, $ownedBy){
            $sql = "SELECT * FROM `user` WHERE `owned_by` = '$ownedBy'";
            $res = mysqli_query($conn, $sql);
            
            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }
        function workerEXT($conn, $ownedBy){
            $sql = "SELECT * FROM `".$ownedBy."_workers`";
            $res = mysqli_query($conn, $sql);

            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }
        function workerEXTSpec($conn, $ownedBy, $username){
            $sql = "SELECT * FROM `".$ownedBy."_workers` WHERE `username` = '$username'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            $json = json_encode($row);
            return $json;
        }
        function extractSurveyStatus($conn, $username, $ownedBy){
            $sql = "SELECT `survey_status` FROM `user` WHERE `username` = '$username' AND `owned_by` = '$ownedBy'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            $json = json_encode($row);
            return $json;
        }

        // extract bookings
        function todayBookingNumber($conn, $ownedBy, $today){
            $sql = "SELECT `id` FROM `".$ownedBy."_bookings` WHERE DATE (`booked_on`) = '$today'";
            $res = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($res);
            return $num;
        }
        function todayBooking($conn, $ownedBy, $today){
            $sql = "SELECT `id`, `client_name`, `client_mob_one`, `vehicle_reg`, `notes`, `booked_on`, `created_by` FROM `".$ownedBy."_bookings` WHERE DATE (`booked_on`) = '$today' ORDER BY `booked_on` ASC";
            $res = mysqli_query($conn, $sql);

            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }
        function futureBookingNumber($conn, $ownedBy, $today){
            $sql = "SELECT `id` FROM `".$ownedBy."_bookings` WHERE DATE (`booked_on`) > '$today'";
            $res = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($res);
            return $num;
        }
        function futureBooking($conn, $ownedBy, $today){
            $sql = "SELECT `id`, `client_name`, `client_mob_one`, `vehicle_reg`, `notes`, `booked_on`, `created_by` FROM `".$ownedBy."_bookings` WHERE DATE (`booked_on`) > '$today' ORDER BY `booked_on` ASC";
            $res = mysqli_query($conn, $sql);

            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }
        // if blob exists in databse row, can't be converted to json - further Experiments
        function bookingAllEXT($conn, $ownedBy){
            $sql = "SELECT `client_name`,`client_mob_one`, `vehicle_reg`, `notes`, `booked_on`, `created_by` FROM `".$ownedBy."_bookings`";
            $res = mysqli_query($conn, $sql);

            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }

        // extract clients
        function clients($conn, $ownedBy){
            $sql = "SELECT * FROM `".$ownedBy."_clients`";
            $res = mysqli_query($conn, $sql);

            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }
        function client($conn, $ownedBy, $clientID){
            $key = 'abcdefghijklmnoprstuvx';
            $method = 'idea';
            $iv = 'stringis';
            $id = openssl_decrypt($clientID, $method, $key, 0, $iv);
            $sql = "SELECT * FROM `".$ownedBy."_clients` WHERE `id` = '$id'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            $json = json_encode($row);
            return $json;
        }
        function getclientID($conn, $ownedBy, $id){
            $sql = "SELECT `id`,`session_id` FROM `".$ownedBy."_clients` WHERE `id` = '$id'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            $eid = $row['id'];
            $esid = $row['session_id'];
            $data = array('session'=>$eid, 'ssl'=>$esid);
            $json = json_encode($data);
            return $json;
        }

        // extract vehicles
        function vehicles($conn, $ownedBy){
            $sql = "SELECT * FROM `".$ownedBy."_vehicle`";
            $res = mysqli_query($conn, $sql);

            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }
        function vehicle($conn, $ownedBy, $id){
            $sql = "SELECT * FROM `".$ownedBy."_vehicle` WHERE `id` = '$id'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($conn, $res);
            $json = json_encode($row);
            return $json;
        }

        // extract fuel type
        function fuel($conn){
            $sql = "SELECT `fuel` FROM `fuel_type`";
            $res = mysqli_query($conn, $sql);

            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }

        // extract all invoices
        function invoiceAllEXT($conn, $ownedBy){
            $sql = "SELECT * FROM `".$ownedBy."_invoice` ORDER BY `invoice_date` DESC";
            $res = mysqli_query($conn, $sql);

            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }

        // extract invoice full specificy id
        function invoiceEXT($conn, $ownedBy, $id){
            $sql = "SELECT * FROM `".$ownedBy."_invoice` WHERE `id` = '$id'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            $json = json_encode($row);
            return $json;
        }

        // extract invoice items full
        function invoiceItemsEXT($conn, $ownedBy, $id){
            $sql = "SELECT * FROM `".$ownedBy."_invoice_items` WHERE `invoice_id` = '$id'";
            $res = mysqli_query($conn, $sql);

            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }

        // extract image data of base64 from bookings
        function imageData($conn, $ownedBy, $id){
            $sql = "SELECT `image_data` FROM `".$ownedBy."_bookings` WHERE `id` = '$id'";
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $row = mysqli_fetch_assoc($res);
            return $row;
        }

        // extract all data for graphs
        function graphs_data_invoices_by_date($conn, $ownedBy, $date){
            $sql = "SELECT * FROM `".$ownedBy."_graphs_data` WHERE DATE (`invoice_date`) LIKE '$date'";
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }

        // extract survey data to visualise
        function extractSurveyData($conn, $ownedBy, $clientId){
            $sql = "SELECT * FROM `".$ownedBy."_survey_data` WHERE `client_id` = '$clientId'";
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }

        function extractOverallSurveyData($conn, $ownedBy){
            $sql = "SELECT * FROM `".$ownedBy."_survey_data`";
            $res = mysqli_query($conn, $sql);
            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }

        function extractOverallSurveyByQuestionNo($conn, $ownedBy, $question_no){
            $sql = "SELECT * FROM `".$ownedBy."_survey_data` WHERE `question_no` = '$question_no'";
            $res = mysqli_query($conn, $sql);
            $data = array();
            while($row = mysqli_fetch_object($res)){
                array_push($data, $row);
            }
            $json = json_encode($data);
            return $json;
        }
    }



    // SQL INSERT QUERIES
    class insert{

        // insert into 'clients' table
        function insertClient($conn, $ownedBy, $username, $name, $email, $address, $postcode, $country, $city, $mob, $landline){
            $escName = escape_string_ucword($conn, $name);
            $escAddress = escape_string_ucword($conn, $address);
            $escEmail = escape_string_strtolower($conn, $email);
            $escPostcode = escape_string_strtoupper($conn, $postcode);
            $escCountry = escape_string_ucword($conn, $country);
            $escCity = escape_string_ucword($conn, $city);
            $escMob = escape_string_strtoupper($conn, $mob);
            $escLandline = escape_string_strtoupper($conn, $landline);

            $sql = "SELECT `name`,`address`,`postcode` FROM `".$ownedBy."_clients` WHERE `name` = '$escName' AND `address` = '$escAddress' AND `postcode` = '$escPostcode'";
            $result = mysqli_query($conn, $sql);
            $row_num = mysqli_num_rows($result);
            if($row_num > 0){
                $sqlU = "UPDATE `".$ownedBy."_clients` SET `name` = '$escName', `email` = '$escEmail', `address` = '$escAddress', `city` = '$escCity', `postcode` = '$escPostcode', `country` = '$escCountry', `mob_one` = '$escMob', `mob_two` = '$escLandline' WHERE `name` = '$escName' AND `address` = '$escAddress'";
                mysqli_query($conn, $sqlU) or die (mysqli_error($conn));
            }elseif($row_num == 0){
                $sqlClient = "INSERT INTO `".$ownedBy."_clients` (`name`, `email`, `address`,`city`,`postcode`, `country`, `mob_one`, `mob_two`, `created_by`, `owned_by`, `survey_status`) VALUES ('$escName','$escEmail','$escAddress','$escCity','$escPostcode','$escCountry','$escMob','$escLandline','$username','$ownedBy', 'send')";
                mysqli_query($conn, $sqlClient) or die(mysqli_error($conn));
            }
        }

        // insert into vehicle table
        function insertVehicle($conn, $createdBy, $ownedBy, $reg, $make, $model, $vin, $odometer, $fuel){
            $escReg = escape_string_strtoupper($conn, $reg);
            $escMake = escape_string_ucword($conn, $make);
            $escModel = escape_string_ucword($conn, $model);
            $escVin = escape_string_strtoupper($conn, $vin);
            $escOdometer = escape_string_strtoupper($conn, $odometer);
            $escFuel = escape_string_strtolower($conn, $fuel);
            $sql = "SELECT `reg` FROM `".$ownedBy."_vehicle` WHERE `reg` = '$escReg'";
            $result = mysqli_query($conn, $sql);
            $row_num = mysqli_num_rows($result);
            if($row_num > 0){
                $sqlU = "UPDATE `".$ownedBy."_vehicle` SET `reg` = '$escReg', `make` = '$escMake', `model` = '$escModel', `vin` = '$escVin', `odometer` = '$escOdometer', `fuel` = '$escFuel' WHERE `reg` = '$escReg'";
                mysqli_query($conn, $sqlU) or die(mysqli_error($conn));
            }else{
                $sqlI = "INSERT INTO `".$ownedBy."_vehicle` (`reg`, `make`, `model`, `vin`, `odometer`, `fuel`, `created_by`, `owned_by`) VALUES ('$escReg', '$escMake', '$escModel', '$escVin', '$escOdometer', '$escFuel', '$createdBy', '$ownedBy')";
                mysqli_query($conn, $sqlI) or die(mysqli_error($conn));
            }
        }

        // insert into 'invoice' table
        function insertInvoice($conn, $createdBy, $ownedBy, $compName, $compAddress, $compCity, $compCountry, $compPostcode, $compVat, $compMob, $compMobTwo, $compLandline ,$clName, $clAddress, $clPostcode, $clCountry, $clCity, $clMob, $clLand, $vReg, $vMake, $vModel, $vVIN, $vOdometer, $vFuel, $hourlyCharge, $taxValue){
            // company 
            $escCoName = escape_string_strtoupper($conn, $compName);
            $escCoAdd = escape_string_ucword($conn, $compAddress);
            $escCoCity = escape_string_ucword($conn, $compCity);
            $escCoCountry = escape_string_ucword($conn, $compCountry);
            $escCoPostcode = escape_string_strtoupper($conn, $compPostcode);
            $escCoVat = escape_string_strtoupper($conn, $compVat);
            $escCoMobOne = escape_string_strtoupper($conn, $compMob);
            $escCoMobTwo = escape_string_strtoupper($conn, $compMobTwo);
            $escCoLandline = escape_string_strtoupper($conn, $compLandline);
            // client
            $escClName = escape_string_ucword($conn, $clName);
            $escClAdd = escape_string_ucword($conn, $clAddress);
            $escClPostcode = escape_string_strtoupper($conn, $clPostcode);
            $escClCountry = escape_string_ucword($conn, $clCountry);
            $escClCity = escape_string_ucword($conn, $clCity);
            $escClMob = escape_string_strtoupper($conn, $clMob);
            $escClLand = escape_string_strtoupper($conn, $clLand);
            // vehicle
            $escVReg = escape_string_strtoupper($conn, $vReg);
            $escVMake = escape_string_ucword($conn, $vMake);
            $escVModel = escape_string_ucword($conn, $vModel);
            $escVVin = escape_string_strtoupper($conn, $vVIN);
            $escVOdometer = escape_string_strtoupper($conn, $vOdometer);
            $escVFuel = escape_string_strtolower($conn, $vFuel);

            $sql = "INSERT INTO `".$ownedBy."_invoice` (`company_name`, `company_address`, `company_city`, `company_postcode`, `company_country`, `company_mob_one`, `company_mob_two`, `company_landline`, `company_vat`, `created_by`, `owned_by`, `client_name`, `client_address`, `client_city`, `client_postcode`, `client_country`, `client_mob_one`, `client_mob_two`, `vehicle_reg`, `vehicle_make`, `vehicle_model`, `vehicle_vin`, `vehicle_odometer`, `vehicle_fuel`, `hourly_charge`, `tax`) VALUES ('$escCoName', '$escCoAdd', '$escCoCity', '$escCoPostcode', '$escCoCountry', '$escCoMobOne', '$escCoMobTwo', '$escCoLandline', '$escCoVat', '$createdBy', '$ownedBy', '$escClName', '$escClAdd', '$escClCity', '$escClPostcode', '$escClCountry', '$escClMob', '$escClLand', '$escVReg', '$escVMake', '$escVModel', '$escVVin', '$escVOdometer', '$escVFuel', '$hourlyCharge', '$taxValue')";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }

        // insert into 'invoice items' table
        function insertInvoiceItems($conn, $ownedBy, $name, $quantity, $price, $labour, $total, $invoiceID){
            $eName = escape_string_ucword($conn, $name); 
            $sql = "INSERT INTO `".$ownedBy."_invoice_items` (`item_name`,`item_quantity`,`item_price`,`labour_price`,`total_price`,`invoice_id`) VALUES ('$eName','$quantity','$price','$labour','$total','$invoiceID')";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }

        // insert into 'bookings' table - NEW WAY OF INSERTING IMAGE USING AJAX - FORMAT OF BASE64 - $dataIMG
        function insertBooking($conn, $createdBy, $ownedBy, $name, $mob, $reg, $date, $notes, $dataIMG){
            $escName = escape_string_ucword($conn, $name);
            $escMob = escape_string_strtoupper($conn, $mob);
            $escReg = escape_string_strtoupper($conn, $reg);
            $escDate = escape_string_strtoupper($conn, $date);
            $escNotes = escape_string_strtoupper($conn, $notes);
            $sql ="INSERT INTO `".$ownedBy."_bookings` (`client_name`,`client_mob_one`,`vehicle_reg`,`notes`,`booked_on`,`created_by`,`owned_by`,`image_data`) VALUES ('$escName','$escMob','$escReg','$escNotes','$escDate','$createdBy','$ownedBy','$dataIMG')";
            mysqli_query($conn,$sql) or die(mysqli_error($conn));
        }

        // insert new user by user-manager
        function userByUser($conn, $ownedBy, $username, $password, $name, $email, $mobOne, $mobTwo, $address, $city, $postcode, $country, $authLevel){
            $alert = null;
            $eUserName = escape_string_strtolower($conn, $username);
            $cPass = clean_input($password);
            $eName = escape_string_ucword($conn, $name);
            $eEmail = escape_string_strtolower($conn, $email);
            $eMO = escape_string_strtoupper($conn, $mobOne);
            $eMT = escape_string_strtoupper($conn, $mobTwo);
            $eAdd = escape_string_ucword($conn, $address);
            $eCity = escape_string_ucword($conn, $city);
            $ePost = escape_string_strtoupper($conn, $postcode);
            $eCountry = escape_string_ucword($conn, $country);
            $sql = "INSERT INTO `".$ownedBy."_workers` (`username`, `name`, `email`, `mob_one`, `mob_two`, `address`, `city`, `postcode`, `country`, `auth_level`) VALUES ('$eUserName', '$eName', '$eEmail', '$eMO', '$eMT', '$eAdd', '$eCity', '$ePost', '$eCountry', '$authLevel')";
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            $sql1 = "INSERT INTO `user` (`username`, `password`, `name`, `email`, `owned_by`, `auth_level`) VALUES ('$eUserName', MD5('".$cPass."'), '$eName', '$eEmail', '$ownedBy', '$authLevel')";
            $res1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));
            if($res && $res1){
                $alert = '<script>alert("User Created Successfully");</script>';
                return $alert;
            }
        }

        // insert company details
        function companyInsert($conn, $ownedBy){
            $sql = "INSERT INTO `".$ownedBy."_company` (`owned_by`) VALUES ('$ownedBy')";
            mysqli_query($conn, $sql);
        }

        // insert client survey data
        function insertClientSurveyData($conn, $ownedBy, $clientID, $sessionID, $data){
            $id = $clientID;
            $own = $ownedBy;
            $sql = "SELECT `id`, `session_id` FROM `".$own."_clients` WHERE `id` = '$id'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);

            if($id == $row['id'] && $sessionID == $row['session_id']){
                $sqlupdate = "UPDATE `".$own."_clients` SET `survey_status` = 'completed' WHERE `id` = '$id'";
                mysqli_query($conn, $sqlupdate) or die(mysqli_error($conn));

                $data = json_decode($data);
                foreach($data as $key => $value){
                    $sqlinsert = "INSERT INTO `".$own."_survey_data` (`client_id`, `question_no`, `answer`) VALUES ('$id', '$key', '$value')";
                    mysqli_query($conn, $sqlinsert) or die(mysqli_error($conn));
                }
            }else{
                echo 'ERROR!';
            }
        }

        // insert company survey data
        function insertCompanySurveyData($conn, $username, $ownedBy, $survey_data){
            $sql_update_user = "UPDATE `user` SET `survey_status` = 'completed' WHERE `username` = '$username' AND `owned_by` = '$ownedBy'";
            mysqli_query($conn, $sql_update_user);


            $data = json_decode($survey_data);
            foreach($data as $key => $value){
                $value = escape_string_strtolower($conn, $value);
                if($key == "3" || $key == "4" || $key == "5" || $key == "8" || $key == "10" || $key == "14"){
                    $insert_comments = "INSERT INTO `admin_survey_data_comments` (`username`, `owned_by`, `question_no`, `comment`) VALUES ('$username','$ownedBy','$key','$value')";
                    mysqli_query($conn, $insert_comments) or die(mysqli_error($conn));
                }else{
                    $insert_data = "INSERT INTO `admin_survey_data` (`username`,`owned_by`,`question_no`,`answer`) VALUES ('$username','$ownedBy','$key','$value')";
                    mysqli_query($conn, $insert_data) or die(mysqli_error($conn));
                }
            }
        }
    }

    // SQL  #####################################################################################################################################################################endregion
}

?>