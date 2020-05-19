<?php
require('../../php/user/auth.php');
define('functions',TRUE);
require('../../php/user/functions.php');

    $extract = new extract();
    $data = $extract->invoiceAllEXT($conn, $ownedBy_S);
    $row = json_decode($data);
    $length = count($row);
        
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoices</title>
    <link rel="stylesheet" href="../../style/bootstrap.min.css">
</head>

<body class="bg-dark">


    <div class="container-fluid p-4">
        <div class="row d-flex justify-content-center text-justify">
            <input class="form-control mr-sm-2 w-50" id="search-input" type="text" placeholder="Search using any keyword..." value=""
                onkeyup="search()">
        </div>
        <div class="row d-flex justify-content-center text-justify">
            <?php 
            for($i=0; $i < $length; $i++){ ?>

            <div class="card m-2">
                <h5 class="card-header">Invoice No
                    #<?php echo $row[$i]->id.' <b>|</b> <i>'.$row[$i]->invoice_date.'</i> <b>|</b> '?><span
                        class="text-primary"><?php echo $row[$i]->created_by ?></span>
                </h5>
                <div class="card-body">
                    <h5 class="card-title">Client Details</h5>
                    <div class="card-text">
                        <p><?php echo $row[$i]->client_name ?></p>
                        <p><?php echo $row[$i]->client_address.', '.$row[$i]->client_city.', '.$row[$i]->client_country.', '.$row[$i]->client_postcode ?>
                        </p>
                        <p><?php echo $row[$i]->client_mob_one.', '.$row[$i]->client_mob_two ?></p>
                    </div>
                    <hr>
                    <h5 class="card-title">Vehicle Details</h5>
                    <div class="card-text">
                        <p>Registration : <strong><?php echo $row[$i]->vehicle_reg?></strong></p>
                        <p>Fuel Type : <strong><?php echo $row[$i]->vehicle_fuel ?></strong></p>
                        <hr>
                        <strong class="text-success">Total</strong>
                        <p>Grandtotal : <strong class="text-primary"><?php echo $row[$i]->grand_total ?></strong>
                        </p>
                    </div>
                    <a class="card-link" href="../invoice.php?invoice-id=<?php echo $row[$i]->id ?>">Open Invoice</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <script src="../../app/app.js?2"></script>
</body>

</html>