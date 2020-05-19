<?php
require('../php/user/auth.php');
define('functions',TRUE);
require('../php/user/functions.php');
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create New Booking</title>
        <link rel="icon" type="image/*" href="../php/user/logoShow.php?company-logo=<?php echo $ownedBy_S; ?>" sizes="16x16">
        <link rel="stylesheet" href="../style/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
    </head>

    <body class="bg-dark">
        <?php 
	define('nav',TRUE);
    require('nav.php'); ?>
        <div class="container mt-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="cpanel.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create New Booking</li>
                </ol>
            </nav>
        </div>
        <!-- content -->
        <div class="container">
            <div id="alert"></div>
            <form class="form-group bg-light p-3" onsubmit="return false">
                <div class="row">
                    <div class="col-sm-6">
                        <label class="mt-2">Client Name</label>
                        <input id="name" type="text" class="form-control form-control mt-1" placeholder="Name">
                        <div class="invalid-feedback">Name is required</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="mt-2">Client Mobile</label>
                        <input id="mob" type="text" class="form-control form-control mt-1" placeholder="Mobile">
                        <div class="invalid-feedback">Contact is required</div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <label class="mt-2">Vehicle Registration</label>
                        <input id="reg" type="text" class="form-control form-control mt-1" placeholder="Reg">
                        <div class="invalid-feedback">Vehicle registration is required</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="mt-2">Booking Date</label>
                        <?php 

                    $month = date('m');
                    $day = date('d');
                    $year = date('Y');
                    $hour = date('H');
                    $min = date('m');
                    $today = $year . '-' . $month . '-' . $day .'T'. $hour .':'.$min;
                    ?>
                        <input id="date" type="datetime-local" class="form-control form-control mt-1" placeholder="Date" value="<?php echo $today; ?>">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <h6>Notes</h6>
                        <textarea id="notes" class="form-control" rows="7" placeholder="Notes here..."></textarea>
                    </div>
                </div>
                <hr>
                
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-primary btn-block" name="submit-book" onclick="loadData()">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- content ends -->
        <script src="../app/jquery-3.4.1.min.js"></script>
        <script src="../app/bootstrap.min.js"></script>
        <script src="../app/app.js?4"></script>
        <script>
            
            function loadData() {

                var name = document.getElementById('name');
                var mob = document.getElementById('mob');
                var reg = document.getElementById('reg');
                var date = document.getElementById('date');

                if (name.value === '') {
                    name.classList.add('is-invalid');
                    return;
                } else if (mob.value === '') {
                    mob.classList.add('is-invalid');
                    return;
                } else if (reg.value === '') {
                    reg.classList.add('is-invalid');
                    return;
                } else if (date.value === '') {
                    date.classList.add('is-invalid');
                    return;
                } else {
                    name.classList.remove('is-invalid');
                    mob.classList.remove('is-invalid');
                    reg.classList.remove('is-invalid');
                    date.classList.remove('is-invalid');
                }

                var form_data = {
                    name: name.value,
                    mob: mob.value,
                    reg: reg.value,
                    date: date.value,
                    notes: notes.value
                }

                $.ajax({
                    type: "POST",
                    url: '../php/user/bookInsert.php',
                    data: form_data,
                    beforeSend: function() {
                        spinner(1);
                    },
                    beforeSend: function(){
                        spinner(1);
                    },
                    success: function() {
                        name.value = '';
                        mob.value = '';
                        reg.value = '';
                        notes.value = '';
                        spinner(0);
                    }
                });

            }



            function spinner(status) {
                const parentDiv = document.getElementById('alert');
                if (status === 1) {
                    const div = document.createElement('div');
                    div.id = 'spinner';
                    div.className = 'spinner-border text-success';
                    div.style.position = 'fixed';
                    div.style.top = '50%';
                    div.style.left = '50%';
                    div.style.zIndex = '10000';
                    parentDiv.appendChild(div);
                }
                if (status === 0) {
                    parentDiv.removeChild(parentDiv.childNodes[0]);
                }
            }
        </script>
    </body>

    </html>