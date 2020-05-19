<?php
require('../php/user/auth.php');
define('functions',TRUE);
require('../php/user/functions.php');

$id = $_GET['invoice-id'];

    $extract = new extract();
    $compRow = $extract->company($conn, $ownedBy_S);
    $data = $extract->invoiceEXT($conn, $ownedBy_S, $id);
    $dataItems = $extract->invoiceItemsEXT($conn, $ownedBy_S, $id);
    
    $rowIIdD = json_decode($data);
    $invoiceID = $rowIIdD->id;
 
    $rowItem = json_decode($dataItems);
    $itemLength = count($rowItem);

    $name = $compRow['name'];
    $invoiceID = $rowIIdD->id;
        
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $name;?> - <?php echo $username_S; ?> - Invoice No #<?php echo $invoiceID ?></title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body class="bg-dark">
    <!-- print button -->
    <div class="container my-3">
        <div class="row d-flex justify-content-between">
            <button class="btn btn-primary" onclick="printElem()">PRINT INVOICE</button>
            <button class="btn btn-primary" onclick="goBack()">BACK</button>
        </div>
    </div>


    <!-- invoice starts here -->
    <div class="container p-1 bg-white" id="invoice-print-area">
        <div class="container-fluid">

            <div class="row d-flex justify-content-between py-1 px-3">
                <div class="row">
                    <h1><?php echo $rowIIdD->company_name ?></h1>
                </div>
                <div>
                    <h3>Invoice No #<?php echo $invoiceID; ?></h3>
                    <?php $invDate = strtotime($rowIIdD->invoice_date);
                      $formatDate = date('d/m/Y', $invDate); ?>
                    <h6>Invoice Date: <?php echo $formatDate ?></h6>
                </div>
            </div>
            <!-- company and client details -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="float-left">
                        <p><b>Company Details</b></p>
                        <p><?php echo $rowIIdD->company_mob_one.' '.$rowIIdD->company_mob_two.' '.$rowIIdD->company_landline ?>
                        </p>
                        <p><?php echo $rowIIdD->company_vat ?></p>
                        <p><i><?php echo $rowIIdD->company_address.' '.$rowIIdD->company_city.' '.$rowIIdD->company_country.' '.$rowIIdD->company_postcode ?></i>
                        </p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="float-right">
                        <p><b>Client Details</b></p>
                        <p><?php echo $rowIIdD->client_name; ?></p>
                        <p><?php echo $rowIIdD->client_mob_one.' '.$rowIIdD->client_mob_two; ?></p>
                        <p><i><?php echo $rowIIdD->client_address.' '.$rowIIdD->client_city.' '.$rowIIdD->client_country.' '.$rowIIdD->client_postcode; ?></i>
                        </p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <!-- vehicle details -->
                <p><b>Vehicle Details</b></p>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <p>Reg Plate : <b><?php echo $rowIIdD->vehicle_reg ?></b></p>
                    <p>Make : <b><?php echo $rowIIdD->vehicle_make ?></b></p>
                    <p>Model : <b><?php echo $rowIIdD->vehicle_model ?></b></p>
                </div>
                <div class="col-sm-6">
                    <p>Odometer Reading : <b><?php echo $rowIIdD->vehicle_odometer ?></b></p>
                    <p>VIN : <b><?php echo $rowIIdD->vehicle_vin ?></b></p>
                    <p>Fuel Type : <b><?php echo $rowIIdD->vehicle_fuel ?></b></p>
                </div>
            </div>
            <br><br><br><br>
            <!-- items details -->
            <div class="row py-2 px-4 bg-info text-light mb-3">
                <h3>Items Description</h3>
            </div>
            <div class="row">
                <div class="col-4">
                    <b>Item</b>
                </div>
                <div class="col-2">
                    <b>Quantity</b>
                </div>
                <div class="col-2">
                    <b>Item Price</b>
                </div>
                <div class="col-2">
                    <b>Labour</b>
                </div>
                <div class="col-2">
                    <b>Total</b>
                </div>
            </div>

            <?php for($i=0; $i<$itemLength; $i++){ ?>
            <div class="row">
                <div class="col-4">
                    <?php echo $rowItem[$i]->item_name; ?>
                </div>
                <div class="col-2">
                    <em><?php echo $rowItem[$i]->item_quantity ?></em>
                </div>
                <div class="col-2">
                    <em><?php echo $rowItem[$i]->item_price ?></em>
                </div>
                <div class="col-2">
                    <em><?php echo $rowItem[$i]->labour_price ?></em>
                </div>
                <div class="col-2">
                    <em><?php echo $rowItem[$i]->total_price ?></em>
                </div>
            </div>
            <?php } ?>
            <hr><br><br><br><br><br><br>
            <!-- bottom row with hours and totals -->
            <div class="row">
                <div class="col-sm-6">
                    <?php $hourCharge = $rowIIdD->hourly_charge; $diff = $rowIIdD->job_time; $hourlyPrice = $hourCharge * $diff;
                            $timeDiff = timeToString($diff); ?>

                    <p><b> Hour Charge </b> <em><?php echo $hourCharge; ?></em> <b>£/h</b></p>
                    <p><b> Worked Hours : </b> <em><?php echo $timeDiff; ?></em> h</p>
                    <p><b> Total Hourly Charge : </b><em><?php echo $hourlyPrice; ?></em> £</p>
                </div>
                <div class="col-sm-6 py-2">
                    <div class="row">
                        <div class="col-sm-6">
                            <?php if($rowIIdD->tax > 0){ ?>
                            <h4 style="color: #011627">Subtotal:</h4>
                            <h3 style="color: #011627">Tax:</h3>
                            <?php } ?>
                            <h2 style="color: #011627">Grandtotal:</h2>
                        </div>
                        <div class="col-sm-6">
                            <?php if($rowIIdD->tax > 0){ ?>
                            <h4 style="color: #011627"><?php echo $rowIIdD->sub_total?> £</h4>
                            <h3 style="color: #011627"><?php echo round($rowIIdD->tax) ?> %</h3>
                            <?php } ?>
                            <h2 style="color: #011627"><?php echo $rowIIdD->grand_total ?> £</h2>
                        </div>

                    </div>
                </div>
            </div>
            <hr><br><br><br><br>
            <!-- the bottom row containing info -->
            <div class="row d-flex justify-content-center text-center p-2">
                <div class="col-sm-12">
                    <p><em>Thank you for your business!</em></p>
                </div>
            </div>
        </div>

    </div>
    <!-- invoice ends here -->





    <script src="../app/jquery-3.4.1.min.js"></script>
    <script src="../app/bootstrap.min.js"></script>
    <script src="../app/app.js?2"></script>
    <script>
    function printElem() {
        var mywindow = window.open('', 'PRINT', 'height=800,width=800');

        mywindow.document.write(
            '<html><head><title><?php echo $name;?> - <?php echo $username_S; ?> - Invoice No #<?php echo $invoiceID ?></title>'
        );
        mywindow.document.write("<link rel=\"stylesheet\" href=\"../style/bootstrap.min.css\">");
        mywindow.document.write('</head><body>');
        mywindow.document.write(document.getElementById('invoice-print-area').innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        // mywindow.print();
        // setTimeout(function(){
        //     mywindow.close();
        // }, 10000);
        setTimeout(function() {
            mywindow.print();
        }, 500);
        window.onfocus = function() {
            setTimeout(function() {
                mywindow.close();
            }, 500);
        }
    }
    </script>

</body>

</html>