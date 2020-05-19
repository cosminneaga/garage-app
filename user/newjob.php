<?php
require('../php/user/auth.php');
define('functions',TRUE);
include('../php/user/functions.php');
define('invoice-insert',TRUE);
require('../php/user/invInsert.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create New Invoice</title>
    <link rel="icon" type="image/*" href="../php/user/logoShow.php?user=<?php echo $ownedBy_S ?>" sizes="16x16">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body class="bg-dark">
    <?php 
define('nav',TRUE);
include('nav.php'); ?>
    <div class="container mt-1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="cpanel.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create New Invoice</li>
            </ol>
        </nav>
    </div>


    <div class="container-fluid">
        <!-- form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="bg-light p-3">
            <p>Client Details</p>

            <!-- client details -->
            <div class="form-inline bg-info text-white p-2">
                <label>Select Client from Records</label>
                <select class="form-control form-control-sm mr-sm-2 m-2" name="select-client" id="select-client" onchange="getClient(this.value)">
                    <option value="0" selected>Select Client</option>
                    <?php 
                    $cData = $extract->clients($conn, $ownedBy_S);
                    $c_row = json_decode($cData);
                    $cLength = count($c_row);

                    for($i = 0; $i < $cLength; $i++){ ?>
                        <option value="<?php echo $c_row[$i]->name ?>|<?php echo $c_row[$i]->postcode ?>|<?php echo $c_row[$i]->address ?>"><?php echo $c_row[$i]->name.' '.$c_row[$i]->address.' '.$c_row[$i]->city.' '.$c_row[$i]->postcode ?></option>
                    <?php } ?>
                </select>
                
            </div>

            <div class="form-inline">
                <input type="text" class="form-control form-control-sm mr-sm-2 mt-2" placeholder="Name"
                    name="client-name" id="client-name" required>
                    <!-- added email -->
                <input type="email" class="form-control form-control-sm mr-sm-2 mt-2" placeholder="E-Mail"
                    name="client-email" id="client-email">
                    <!-- added email -->
                <input type="text" class="form-control form-control-sm mr-sm-2 mt-2" placeholder="Address"
                    name="client-address" id="client-address" required>
                <input type="text" class="form-control form-control-sm mr-sm-2 mt-2" placeholder="City Name"
                    name="client-city" id="client-city" required>
                <input type="text" class="form-control form-control-sm mr-sm-2 mt-2" placeholder="Country"
                    name="client-country" id="client-country" required>
                <input type="text" class="form-control form-control-sm mr-sm-2 mt-2" placeholder="Postcode"
                    name="client-postcode" id="client-postcode" required>
                <input type="text" class="form-control form-control-sm mr-sm-2 mt-2" placeholder="Mobile"
                    name="client-mob" id="client-mob" required>
                <input type="text" class="form-control form-control-sm mr-sm-2 mt-2" placeholder="Mobile/Landline"
                    name="client-mob-landline" id="client-mob-landline">
            </div>
            <hr>
            <!-- client details -->

            <!-- vehicle details -->
            <p>Vehicle Details</p>
            <div class="form-inline bg-info text-white p-2">
                <label>Select Vehicle from Records</label>
                <select class="form-control form-control-sm mr-sm-2 m-2" name="select-vehicle" id="select-vehicle" onchange="getVehicle(this.value)">
                    <option value="0" selected>Select Vehicle</option>
                    <?php 
                    $vData = $extract->vehicles($conn, $ownedBy_S);
                    $v_row = json_decode($vData);
                    $vLength = count($v_row);
                    for($i = 0; $i < $vLength; $i++){ ?>
                        <option value="<?php echo $v_row[$i]->reg ?>"><?php echo $v_row[$i]->reg .' | '.$v_row[$i]->make.' '.$v_row[$i]->model ?></option>
                    <?php } ?>
                </select>

                
            </div>
            <div class="form-inline">
                <input type="text" class="form-control form-control-sm mr-sm-2 mt-2" placeholder="Registration Plate" name="reg" id="reg" required>
                <input type="text" class="form-control form-control-sm mr-sm-2 mt-2" placeholder="Make" name="make" id="make" required>
                <input type="text" class="form-control form-control-sm mr-sm-2 mt-2" placeholder="Model" name="model" id="model" required>
                <input type="text" class="form-control form-control-sm mr-sm-2 mt-2" placeholder="VIN" name="vin" id="vin">
                <input type="text" class="form-control form-control-sm mr-sm-2 mt-2" placeholder="Odometer" name="odometer" id="odometer">
                <select class="form-control form-control-sm mr-sm-2 mt-2" name="fuel" id="fuel" required>
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
            </div>
            <hr>
            <!-- vehicle details -->

            <!-- job details -->
            <p>Job Details</p>
    
            <div class="form-group">
                <div class="row">

                    <!-- date time pickers -->
                    <div class="col-sm-3">
                        <label>Start Time</label>
                        <input type="datetime-local" class="form-control form-control-sm mr-sm-2 mt-2" id="start-time"
                            name="start-time">
                    </div>
                    <div class="col-sm-3">
                        <label>End Time</label>
                        <input type="datetime-local" class="form-control form-control-sm mr-sm-2 mt-2" id="end-time"
                            name="end-time">
                    </div>
                    <!-- date time pickers -->

                    <div class="col-sm-2">
                        <label>Charge Method</label>
                        <select id="select" class="form-control form-control-sm mr-sm-2 mt-2" required onchange="enable()">
                            <option value="0">Select charge method</option>
                            <option value="hour">Hour</option>
                            <option value="item">Item</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Hour Charge</label>
                        <input type="number" step="0.01" class="form-control form-control-sm mr-sm-2 mt-2"
                            id="hour-charge" name="hour-charge" value="0" readonly>
                    </div>
                </div>
                <hr>
                <p>Items</p>
                <div class="row">
                    <div class="col-sm-2" id="part-name-column">
                        <label>Part Name</label>
                        <input type="text" class="form-control form-control-sm mr-sm-2 mt-2" name="partname[]"
                            placeholder="Part Name" required>
                    </div>
                    <div class="col-sm-2" id="quantity-column">
                        <label>Quantity</label>
                        <input type="number" id="quantity" name="quantity[]" placeholder="Quantity"
                            class="form-control form-control-sm mr-sm-2 mt-2" required>
                    </div>
                    <div class="col-sm-2" id="item-price-column">
                        <label>Part Price</label>
                        <input type="number" id="item-price" step="0.01"
                            class="form-control form-control-sm mr-sm-2 mt-2" name="itemprice[]"
                            placeholder="Part Price" required>
                    </div>
                    <div class="col-sm-2" id="labour-price-column">
                        <label>Labour</label>
                        <input type="number" id="labour-charge" step="0.01"
                            class="form-control form-control-sm mr-sm-2 mt-2" name="labourcharge[]" value="0" readonly>
                    </div>
                </div>
            </div>
            <!-- job details -->

            <!-- button row -->
            <div class="row">
                <div class="col-sm-12 pt-2">
                    <div class="row d-flex justify-content-between">
                        <button type="button" class="btn btn-success m-2" onclick="enable()();">Add New Field</button>
                        <div class="col-sm-2 text-primary m-2" id="error-column"></div>
                        <input type="submit" name="submit" class="btn btn-primary m-2" value="Create & Save Invoice">
                    </div>
                </div>
            </div>
            <!-- button row ends -->

        </form>
        <!-- form -->
    </div>
    <script src="../app/jquery-3.4.1.min.js"></script>
    <script src="../app/bootstrap.min.js"></script>
    <script src="../app/app.js?2"></script>
</body>

</html>