<?php
require('../php/user/auth.php');
define('functions',TRUE);
require('../php/user/functions.php');
$extract = new extract();
$insert = new insert();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Vehicle</title>
    <link rel="icon" type="image/*" href="../php/user/logoShow.php?user=<?php echo $ownedBy_S; ?>" sizes="16x16">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
	<link rel="stylesheet" href="../style/style.css">
</head>
<body class="bg-dark">
    <?php
        define('nav',TRUE);
        require('nav.php'); 
    ?>
    <div class="container mt-1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="cpanel.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create New Vehicle</li>
            </ol>
        </nav>
    </div>
        <!-- content -->
        <div class="container">
            <div id="alert"></div>
            <form class="form-group bg-light p-3" onsubmit="return false">
                <div class="row">
                    <div class="col-sm-6">

                        <label class="mt-2">Vehicle Details</label>
                        <input id="reg" type="text" class="form-control form-control mt-1" placeholder="Registration">
                        <div class="invalid-feedback">Registration is required</div>

                        <input id="make" type="text" class="form-control form-control mt-4" placeholder="Make">
                        <div class="invalid-feedback">Make is required</div>

                        <input id="model" type="text" class="form-control form-control mt-4" placeholder="Model">
                        <div class="invalid-feedback">Model is required</div>

                    </div>
                    <div class="col-sm-6">

                        <label class="mt-2">Vehicle Technical</label>
                        <input id="odometer" type="text" class="form-control form-control mt-1" placeholder="Odometer">

                        <select class="form-control mt-4" id="fuel" required>
                            <option value="" selected>Select Fuel Type</option>
                            <?php
                            $fData = $extract->fuel($conn);
                            $f_row = json_decode($fData);
                            $fLength = count($f_row);

                            for($i = 0; $i < $fLength; $i++){ ?>

                            <option value="<?php echo strtolower($f_row[$i]->fuel) ?>">
                                <?php echo $f_row[$i]->fuel; ?></option>

                            <?php }  ?>
                        </select>
                        <div class="invalid-feedback">Fuel type is required</div>

                        <input id="vin" type="text" class="form-control form-control mt-4" placeholder="VIN">

                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-primary btn-block" name="submit-book" onclick="sendData();">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- content ends -->
    

    <script src="../app/jquery-3.4.1.min.js"></script>
    <script src="../app/bootstrap.min.js"></script>
    <script src="../app/app.js?4"></script>
    <script>
        function sendData(){
            let reg = document.getElementById('reg');
            let make = document.getElementById('make');
            let model = document.getElementById('model');
            let odometer = document.getElementById('odometer');
            let fuel = document.getElementById('fuel');
            let vin = document.getElementById('vin');

            // conditions
            if(reg.value === ''){
                reg.classList.add('is-invalid');
                return;
            }
            if(make.value === ''){
                make.classList.add('is-invalid');
                return;
            }
            if(model.value === ''){
                model.classList.add('is-invalid');
                return;
            }
            if(fuel.value === ''){
                fuel.classList.add('is-invalid');
                return;
            }
            else{
                reg.classList.remove('is-invalid');
                make.classList.remove('is-invalid');
                model.classList.remove('is-invalid');
                fuel.classList.remove('is-invalid');
            }

            // capture data into json
            var form_data = {
                reg: reg.value,
                make: make.value,
                model: model.value,
                odometer: odometer.value,
                fuel: fuel.value,
                vin: vin.value
            }

            $.ajax({
                type: "POST",
                url: '../php/user/vehicleInsert.php',
                data: form_data,
                beforeSend: function(){
                    spinner(1);
                },
                success: function(){
                    reg.value = '';
                    make.value = '';
                    model.value = '';
                    odometer.value = '';
                    fuel.value = '';
                    vin.value = '';
                    spinner(0);
                    alert('New vehicle created successfully.');
                }
            });
        }
    </script>
</body>
</html>