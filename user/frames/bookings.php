<?php
require('../../php/user/auth.php');
define('functions',TRUE);
require('../../php/user/functions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link rel="stylesheet" href="../../style/bootstrap.min.css">
</head>

<body class="bg-dark">
    <?php
    
    $extract = new extract();
    $data = $extract->bookingAllEXT($conn, $ownedBy_S);
    $row = json_decode($data);
    $length = count($row);
    
?>

    <div class="container-fluid p-4">
        <div class="row d-flex justify-content-center text-justify">
            <input class="form-control mr-sm-2 w-50" id="search-input" type="text"
                placeholder="Search using any keyword..." value="" onkeyup="search()">
        </div>
        <div class="row d-flex justify-content-center text-justify">

                <?php $count = 1;
         for($i=0; $i<$length; $i++){ 
             $bookedOn = strtotime($row[$i]->booked_on); ?>

                <div class="card m-2 bg-light boredr-primary">
                    <div class="card-body">
                        <div class="card-title text-primary"><strong>Booking No #<?php echo $count ?></strong></div>
                        <div class="card-subtitle">Created By : <i><span
                                    class="text-primary"><?php echo $row[$i]->created_by ?></span></i></div>
                        <hr>
                        <div class="card-text">
                            <p>Client Name: <i><?php echo $row[$i]->client_name ?></i></p>
                            <p>Client Contacts:
                                <i><?php echo $row[$i]->client_mob_one ?></i>
                            </p>
                            <p>Vehicle Registration: <i><?php echo $row[$i]->vehicle_reg ?></i></p>
                            <hr>
                            <p><b>Notes: </b> <i><?php echo $row[$i]->notes ?></i></p>
                        </div>
                    </div>
                    <div class="card-footer bg-dark">
                        <h6 class="text-warning"><?php echo date("l d/m/Y H:i:s", $bookedOn) ?></h6>
                    </div>
                </div>


                <?php $count++; } ?>
        </div>
    </div>
    <script src="../../app/app.js?2"></script>
</body>

</html>