<?php
require('../php/user/auth.php');
define('functions', TRUE);
require('../php/user/functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Activity</title>
    <link rel="icon" type="image/*" href="../php/user/logoShow.php?user=<?php echo $ownedBy_S; ?>" sizes="16x16">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body class="bg-info m-0">
    <?php define('nav', TRUE);
    require('nav.php'); ?>
    <div class="container-fluid text-light m-0">
        <div class="row" id="button-area">
            <div class="col-sm-12 p-2 d-flex justify-content-center">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-secondary" onclick="iframes(this.id)"
                        id="clients">Clients</button>
                    <button type="button" class="btn btn-secondary" onclick="iframes(this.id)"
                        id="bookings">Bookings</button>
                    <button type="button" class="btn btn-secondary" onclick="iframes(this.id)"
                        id="invoices">Invoices</button>
                    <button type="button" class="btn btn-secondary" onclick="iframes(this.id)"
                        id="vehicles">Vehicles</button>
                </div>
            </div>
        </div>
        <div class="row" id="frame-area">
            <iframe src="frames/clients.php" id="my-frame" class="w-100"></iframe>
        </div>
    </div>



    <script src="../app/jquery-3.4.1.min.js"></script>
    <script src="../app/bootstrap.min.js"></script>
    <script src="../app/app.js?2"></script>
    <script>
        // set automatic height of frame according to change of height
        let nav = document.getElementById('nav');
        let button_area = document.getElementById('button-area');
        let frame_area = document.getElementById('frame-area');
        frame_area.style.height = window.innerHeight - nav.clientHeight - button_area.clientHeight - 5 + 'px';

        let myFrame = document.getElementById('my-frame');
        function iframes(click) {

            if (click === 'invoices') {
                myFrame.src = "frames/invoice.php";
            }
            if (click === 'vehicles') {
                let myFrame = document.getElementById('my-frame');
                myFrame.src = "frames/vehicles.php";
            }
            if (click === 'clients') {
                let myFrame = document.getElementById('my-frame');
                myFrame.src = "frames/clients.php";
            }
            if (click === 'bookings') {
                let myFrame = document.getElementById('my-frame');
                myFrame.src = "frames/bookings.php";
            }
        }
    </script>
</body>

</html>