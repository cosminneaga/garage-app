<?php
require('../php/user/auth.php');
define('functions',TRUE);
require('../php/user/functions.php');
$extract = new extract();
$comp = $extract->company($conn, $ownedBy_S);
$delete = new delete();
$today = date('Y/m/d');
$delete->oldBook($conn, $ownedBy_S, $today);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $comp['name']; ?></title>
    <link rel="icon" type="image/*" href="../php/user/logoShow.php?user=<?php echo $ownedBy_S; ?>" sizes="16x16">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css?2">
    <style>
        body{
            background-image: url('../pictures/bg.jpg');
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
    </style>
</head>

<body>
    <?php define('nav',TRUE); include('nav.php'); ?>

    <div class="container-fluid m-0 p-0" id="alert-box"></div>
    <!-- page content -->
    <div class="container text-center my-5">
        <div class="row bg-dark rounded-lg d-flex justify-content-around text-wrap p-1">
            <h1 class="text-light text-uppercase"><?php echo $comp['name']; ?></h1>
        </div>
    </div>
    

    <div class="container box-outer my-5 py-5">
        <div class="row">
            <div class="grid-item col">
                <button onclick="window.location.href= 'newjob.php'">
                    <img src="../pictures/job.png">
                    <br>
                    Create Invoice
                </button>
            </div>
            <div class="grid-item col">
                <button onclick="window.location.href = 'new-booking.php'; ">
                    <img src="../pictures/new_record.png">
                    <br>
                    Create Booking
                </button>
            </div>
            <div class="grid-item col">
                <button onclick="window.location.href = 'statistics.php';">
                    <img src="../pictures/statistics.png">
                    <br>
                    Statistics
                </button>
            </div>
            <div class="grid-item col">
                <button onclick="window.location.href = 'dashboard.php';">
                    <img src="../pictures/booking.png">
                    <br>
                    Bookings Dashboard
                </button>
            </div>
        </div>
    </div>

    <br><br>

    <?php 
define('footer',TRUE);
include('footer.php'); ?>


    <script src="../app/jquery-3.4.1.min.js"></script>
    <script src="../app/bootstrap.min.js"></script>
    <script src="../app/app.js?2"></script>

    <script>
        let alert_box = document.getElementById('alert-box');
        function survey(){
            window.location.href = '../surveys/company_survey.php?username=<?php echo $username_S ?>&own=<?php echo $ownedBy_S ?>';
        }
        function getStatus(){
            $.ajax({
                type: 'POST',
                url: '../php/user/getSurveyStatus.php',
                data: {
                    get_status: 'brr'
                },
                success: function(response){
                    let data = JSON.parse(response);
                    if(data.survey_status === 'not completed'){
                        html = '<div class="alert alert-warning text-center" role="alert">' +
                        'Hello there, please take a few moments and tell us what is your opinion about this software. <a type="button" onclick="survey()" class="alert-link">Survey Link</a>.'+
                        '</div>';
                        alert_box.innerHTML = html;
                    }
                }
            });
        }
        window.onload = getStatus();
        
        setInterval(function(){
            getStatus();
        },1000000);
    </script>
</body>

</html>