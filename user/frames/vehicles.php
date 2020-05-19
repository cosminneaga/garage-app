<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vehicles</title>
    <link rel="stylesheet" href="../../style/bootstrap.min.css">
</head>

<body class="bg-dark">
    <?php
require('../../php/user/auth.php');
define('functions',TRUE);
require('../../php/user/functions.php');
    $extract = new extract();
    $data = $extract->vehicles($conn, $ownedBy_S);
    $row = json_decode($data);
    $length = count($row);
?>

    <div class="container-fluid p-4">
        <div class="row d-flex justify-content-center text-justify">
            <input class="form-control mr-sm-2 w-50" id="search-input" type="text" placeholder="Search using any keyword..." value=""
                onkeyup="search()">
        </div>
        <div class="row d-flex justify-content-center text-justify">
            <?php $count = 1;
         for($i = 0; $i < $length; $i++){ ?>

            <div class="card m-2 bg-light border border-primary">
                <div class="card-body">
                    <div class="card-title text-primary"><strong>Vehicle No #<?php echo $count ?></strong></div>
                    <div class="card-subtitle">Created By : <i><span class="text-primary"><?php echo $row[$i]->created_by ?></span></i></div>
                    <hr>
                    <div class="card-text">
                        <p>Registration : <i><b><?php echo $row[$i]->reg ?></b></i></p>
                        <p>Make : <i><b><?php echo $row[$i]->make ?></b></i></p>
                        <p>Model : <i><b><?php echo $row[$i]->model ?></b></i></p>
                        <p>VIN : <i><b><?php echo $row[$i]->vin ?></b></i></p>
                        <p>Odometer: <i><b><?php echo $row[$i]->odometer ?></b></i></p>
                        <p>Fuel : <i><b><?php echo $row[$i]->fuel ?></b></i></p>
                    </div>
                </div>
            </div>
            

            <?php $count++; } ?>

        </div>
    </div>
    <script src="../../app/app.js?2"></script>
</body>

</html>