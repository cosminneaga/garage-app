<?php
require('../php/user/auth.php');
define('functions',TRUE);
require('../php/user/functions.php');
$extract = new extract();
$comp = $extract->company($conn, $ownedBy_S);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $comp['name']; ?> | DASHBOARD</title>
    <link rel="icon" type="image/*" href="../php/user/logoShow.php?user=<?php echo $ownedBy_S; ?>" sizes="16x16">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body class="bg-dark text-light">
    <?php 
	define('nav',TRUE);
    require('nav.php');
    $todayDate = date('Y/m/d');   

    $num_today = $extract->todayBookingNumber($conn, $ownedBy_S, $todayDate);
    $num_future = $extract->futureBookingNumber($conn, $ownedBy_S, $todayDate);

    $dataT = $extract->todayBooking($conn, $ownedBy_S, $todayDate);
    $row = json_decode($dataT);
    $dataTlength = count($row); 

    $dataF = $extract->futureBooking($conn, $ownedBy_S, $todayDate);
    $rowFuture = json_decode($dataF);
    $dataFlength = count($rowFuture);

    
    ?>
    <!-- content -->
    <div class="container-fluid my-1">

        <div class="row">

            <div class="col-12">


                <h3><?php echo date("l d/m/Y") ?></h3>

                <?php if($num_today > 0){ ?>

                <div class="card-columns">

                    <?php for($a = 0; $a < $dataTlength; $a++){ 
                    $bookedOn = strtotime($row[$a]->booked_on); ?>

                    <div class="card bg-success text-white mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card-text">
                                        <p>Name: <?php echo $row[$a]->client_name ?></p>
                                        <p>Contacts:
                                            <?php echo $row[$a]->client_mob_one?>
                                        </p>
                                        <p>Vehicle Reg: <?php echo $row[$a]->vehicle_reg ?></p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <?php $dataIMG = $extract->imageData($conn, $ownedBy_S, $row[$a]->id);
                                    
                                    if($dataIMG['image_data'] === ''){
                                    }else{  ?>
                                    <img data-enlargable class="img-thumbnail"
                                        src="<?php echo $dataIMG['image_data'] ?>"
                                        style="width: 200px; height: 150px; cursor:zoom-in;" alt="Book Photo">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-text">
                                        <p>Notes: <?php echo $row[$a]->notes ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-dark text-warning">
                            <?php echo date('l d-m-Y H:i', $bookedOn) ?>
                        </div>
                    </div>

                    <?php  } ?>

                </div>

                <?php } else {?>
                <h4 class="d-flex justify-content-around my-3">No bookings for today</h4>
                <?php } ?>
                <hr>

                <button id="btn-future" class="btn btn-sm btn-block btn-outline-info my-2">Click to show future dates
                    bookings</button>
                <div id="book-future">
                    <h5>Future Bookings</h5>
                    <?php if($num_future > 0){ ?>
                    <div class="card-columns">
                        <?php for($b = 0; $b < $dataFlength; $b++){ 
                    $bookedOnFuture = strtotime($rowFuture[$b]->booked_on); ?>

                        <div class="card bg-info text-white mt-2 shadow">
                            <h4 class="bg-warning text-dark p-2 rounded-lg shadow mt-3">Booked for:
                                <?php echo date('l d/m/Y H:i', $bookedOnFuture) ?></h4>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card-text">
                                            <p>Name: <?php echo $rowFuture[$b]->client_name ?></p>
                                            <p>Contacts:
                                                <?php echo $rowFuture[$b]->client_mob_one?>
                                            </p>
                                            <p>Vehicle Reg: <?php echo $rowFuture[$b]->vehicle_reg ?></p>
                                            <p>Notes: <?php echo $rowFuture[$b]->notes ?></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php $dataIMGF = $extract->imageData($conn, $ownedBy_S, $row[$b]->id);
                                        if($dataIMGF['image_data'] === ''){ ?>
                                        <?php  }else{ ?>
                                        <img data-enlargable class="img-thumbnail"
                                            src="<?php echo $dataIMGF['image_data'] ?>"
                                            style="width: 200px; height: 150px; cursor:zoom-in;" alt="Book Photo">
                                        <?php  } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php  } ?>
                    </div>

                    <?php } else {?>
                    <h4 class="d-flex justify-content-around my-3">No existing bookings</h4>
                    <?php } ?>
                    <hr>
                </div>

            </div><br>


            <!-- <div class="col-12 col-lg-6">
                <h2 class="text-center mb-3">Area in development</h2>
            </div> -->

        </div>

    </div>


    <!-- content ends -->

    <script src="../app/jquery-3.4.1.min.js"></script>
    <script src="../app/bootstrap.min.js"></script>
    <script src="../app/app.js?2"></script>
    <script>
    const divBookFuture = document.getElementById('book-future');
    const btnFutureClick = document.getElementById('btn-future').addEventListener('click', showFutureBookings);
    const btnFuture = document.getElementById('btn-future');

    divBookFuture.style.display = 'none';

    const divBtnCloseFuture = document.createElement('div');
    divBtnCloseFuture.innerHTML =
        `<button class="btn btn-block btn-sm btn-outline-success" onclick="hideFutureBookings()">Close Future Bookings</button>`;

    function showFutureBookings() {
        btnFuture.style.display = 'none';
        divBookFuture.style.display = 'block';
        divBookFuture.appendChild(divBtnCloseFuture);
    }

    function hideFutureBookings() {
        divBtnCloseFuture.remove();
        divBookFuture.style.display = 'none';
        btnFuture.style.display = 'block';
    }

    $('img[data-enlargable]').addClass('img-enlargable').click(function() {
        var src = $(this).attr('src');
        $('<div>').css({
            background: 'RGBA(0,0,0,0.9) url(' + src + ') no-repeat center',
            backgroundSize: 'contain',
            width: '100%',
            height: '100%',
            position: 'fixed',
            zIndex: '10000',
            top: '0',
            left: '0',
            cursor: 'zoom-out'
        }).click(function() {
            $(this).remove();
        }).appendTo('body');
    });
    </script>
</body>

</html>