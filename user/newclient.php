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
    <title>Create New Client</title>
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
                <li class="breadcrumb-item active" aria-current="page">Create New Client</li>
            </ol>
        </nav>
    </div>
        <!-- content -->
        <div class="container">
            <div id="alert"></div>
            <form class="form-group bg-light p-3" onsubmit="return false">
                <div class="row">
                    <div class="col-sm-6">

                        <label class="mt-2">Client Contact Details</label>
                        <input id="name" type="text" class="form-control form-control mt-1" placeholder="Name">
                        <div class="invalid-feedback">Name is required</div>

                        <input id="email" type="email" class="form-control form-control mt-4" placeholder="E-Mail Address">
                        <div class="invalid-feedback">E-Mail is required</div>

                        <input id="mobile" type="text" class="form-control form-control mt-4" placeholder="Mobile">
                        <div class="invalid-feedback">At least one phone no is required</div>

                        <input id="landline" type="text" class="form-control form-control mt-4" placeholder="Mobile/Landline">

                    </div>
                    <div class="col-sm-6">

                        <label class="mt-2">Client Address</label>
                        <input id="address" type="text" class="form-control form-control mt-1" placeholder="Address">
                        <div class="invalid-feedback">Address is required</div>

                        <input id="city" type="text" class="form-control form-control mt-4" placeholder="City">

                        <input id="country" type="text" class="form-control form-control mt-4" placeholder="Country">

                        <input id="postcode" type="text" class="form-control form-control mt-4" placeholder="Postcode">
                        <div class="invalid-feedback">Postcode is required</div>

                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-primary btn-block" name="submit-book" onclick="sendDataToClient();">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- content ends -->
    

    <script src="../app/jquery-3.4.1.min.js"></script>
    <script src="../app/bootstrap.min.js"></script>
    <script src="../app/app.js?4"></script>
    <script>
        function sendDataToClient(){
            let name = document.getElementById('name');
            let email = document.getElementById('email');
            let mobile = document.getElementById('mobile');
            let landline = document.getElementById('landline');
            let address = document.getElementById('address');
            let city = document.getElementById('city');
            let country = document.getElementById('country');
            let postcode = document.getElementById('postcode');

            // conditions
            if(name.value === ''){
                name.classList.add('is-invalid');
                return;
            }
            if(email.value === ''){
                email.classList.add('is-invalid');
                return;
            }
            if(mobile.value === ''){
                mobile.classList.add('is-invalid');
                return;
            }
            if(address.value === ''){
                address.classList.add('is-invalid');
                return;
            }
            if(postcode.value === ''){
                postcode.classList.add('is-invalid');
                return;
            }
            else{
                name.classList.remove('is-invalid');
                email.classList.remove('is-invalid');
                mobile.classList.remove('is-invalid');
                address.classList.remove('is-invalid');
                postcode.classList.remove('is-invalid');
            }

            // capture data into json
            var form_data = {
                name: name.value,
                email: email.value,
                mobile: mobile.value,
                landline: landline.value,
                address: address.value,
                city: city.value,
                country: country.value,
                postcode: postcode.value
            }

            $.ajax({
                type: "POST",
                url: '../php/user/clientInsert.php',
                data: form_data,
                beforeSend: function(){
                    spinner(1);
                },
                success: function(){
                    name.value = '';
                    email.value = '';
                    mobile.value = '';
                    landline.value = '';
                    address.value = '';
                    city.value = '';
                    country.value = '';
                    postcode.value = '';
                    spinner(0);
                    alert('New client created successfully.');
                }
            });
        }
    </script>
</body>
</html>