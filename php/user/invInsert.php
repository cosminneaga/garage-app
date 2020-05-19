<?php
if(defined('invoice-insert')){
    
    if(isset($_POST['submit'])){
        $extract = new extract();

        // client data post
        $clientname = $_POST['client-name'];
        $clientaddress = $_POST['client-address'];
        $clientemail = $_POST['client-email'];
        $clientcity = $_POST['client-city'];
        $clientcountry = $_POST['client-country'];
        $clientpostcode = $_POST['client-postcode'];
        $clientmob = $_POST['client-mob'];
        $clientmoblandline = $_POST['client-mob-landline'];

        // vehicle data post
        $vehicleReg = $_POST['reg'];
        $vehicleMake = $_POST['make'];
        $vehicleModel = $_POST['model'];
        $vehicleVIN = $_POST['vin'];
        $vehicleOdometer = $_POST['odometer'];
        $vehicleFuel = $_POST['fuel'];

        // time post
        $startTime = $_POST['start-time'];
        $endTime = $_POST['end-time'];
        $hourCharge = $_POST['hour-charge'];

        // items post
        $partName = $_POST['partname'];
        $quantity = $_POST['quantity'];
        $itemPrice = $_POST['itemprice'];
        $labourCharge = $_POST['labourcharge'];


        // client data insert
        $insert = new insert();
        $insert->insertClient($conn, $ownedBy_S, $username_S, $clientname, $clientemail, $clientaddress, $clientpostcode, $clientcountry, $clientcity, $clientmob, $clientmoblandline);
        
        // vehicle data insert
        $insert->insertVehicle($conn, $username_S, $ownedBy_S, $vehicleReg, $vehicleMake, $vehicleModel, $vehicleVIN, $vehicleOdometer, $vehicleFuel);



        $cRow = $extract->company($conn, $ownedBy_S);
        $company_name = $cRow['name']; $company_address = $cRow['address']; $company_city = $cRow['city']; $company_country = $cRow['country'];
        $company_postcode = $cRow['postcode']; $company_reg = $cRow['registration_no']; $company_mob_one = $cRow['mob_one'];
        $company_mob_two = $cRow['mob_two']; $company_landline = $cRow['landline']; $company_tax_value = $cRow['tax_value'];



        

        // company data insert into invoice table
        $insert->insertInvoice($conn, $username_S, $ownedBy_S, $company_name, $company_address, $company_city, $company_country, $company_postcode, $company_reg, $company_mob_one, $company_mob_two, $company_landline, $clientname, $clientaddress, $clientpostcode, $clientcountry, $clientcity, $clientmob, $clientmoblandline, $vehicleReg, $vehicleMake, $vehicleModel, $vehicleVIN, $vehicleOdometer, $vehicleFuel, $hourCharge, $company_tax_value);



        
        $extractID = new invoiceID();
        $invoiceID = $extractID->extractID($conn, $ownedBy_S);
        // items array insert
            foreach($partName AS $key => $value){

                $sum[$key] = ($quantity[$key] * $itemPrice[$key]) + $labourCharge[$key];
                $total = array_sum($sum);

                $insert->insertInvoiceItems($conn, $ownedBy_S, $value, $quantity[$key], $itemPrice[$key], $labourCharge[$key], $sum[$key], $invoiceID);
                
                $_POST = array();
            }

        // time difference and hourly price computation
        $time = new time();
        $diff = $time->differenceInHours($startTime, $endTime);
        $hourlyPrice = $time->calculateTimePrice($diff, $hourCharge);

        // items + hours Grand
        $subTotal = $total + $hourlyPrice;

        // Grand Total including tax percentage
        $grand = calculateTax($subTotal, $company_tax_value);
        

        $update = new update();
        $update->updateNewDataInvoice($conn, $ownedBy_S, $invoiceID, $subTotal, $grand, $diff);


        
        
        unset($clientname,$clientaddress,$clientcountry,$clientcity,$clientpostcode,$clientmob,$clientmoblandline,$vehicleReg,$vehicleMake,$vehicleModel,$vehicleVIN,$vehicleOdometer,$vehicleFuel,$startTime,$endTime,$hourCharge,$partName,$quantity,$itemPrice,$labourCharge);
        header('Location: invoice.php?invoice-id='.$invoiceID);
        
        
    }
}else{
    
    header('Location: ../user-portal.php');
}