<?php
require('../php/user/auth.php');
define('functions',TRUE);
require('../php/user/functions.php');
$extract = new extract();
$update = new update();
$insert = new insert();
$comp = $extract->company($conn, $ownedBy_S);

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $postcode = $_POST['postcode'];
        $mobOne = $_POST['mob-one'];
        $mobTwo = $_POST['mob-two'];
        $landline = $_POST['landline'];
        $reg = $_POST['reg'];
        $tax = $_POST['tax-value'];
        $compNum = $extract->companyNum($conn, $ownedBy_S);
        if($compNum == 0){
            $insert->companyInsert($conn, $ownedBy_S);
            $update->companyUpdate($conn, $ownedBy_S, $name, $email, $address, $city, $postcode, $country, $reg, $mobOne, $mobTwo, $landline, $tax);
        }
        if($compNum == 1){
            $update->companyUpdate($conn, $ownedBy_S, $name, $email, $address, $city, $postcode, $country, $reg, $mobOne, $mobTwo, $landline, $tax);
        }
        if(is_uploaded_file($_FILES['logo']['tmp_name'])){
            $data = addslashes(file_get_contents($_FILES['logo']['tmp_name']));
            $size = getimagesize($_FILES['logo']['tmp_name']);
            $properties = $size['mime'];
            $update->companyLogo($conn, $ownedBy_S, $properties, $data);
        }
    }
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
	<link rel="stylesheet" href="../style/style.css?1">
<style>
    img{
        width: 80px;
        height: 80px;
    }
</style>
</head>
<body class="bg-dark">
<?php 
define('nav',TRUE);
require('nav.php'); 
if($level == 'manager')
{
?>

    <div class="container mt-1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="cpanel.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Company Profile Edit</li>
            </ol>
        </nav>
    </div>
    <div class="container-fluid text-white mb-5 mb-3">
        <div class="row">
        <div class="p-lg-5 col-sm-12 col-lg-6 p-md-3 text-wrap">
            <h2 class="mb-3">Company Details</h2>
            <div class="form-group row">
                <div class="col-sm-3">
                    Name:
                </div>
                <div class="col-sm-9">
                    <?php echo $comp['name']; ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    E-Mail:
                </div>
                <div class="col-sm-9">
                    <?php echo $comp['email']; ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    Address: 
                </div>
                <div class="col-sm-9">
                    <?php echo $comp['address']; ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    Country: 
                </div>
                <div class="col-sm-9">
                    <?php echo $comp['country']; ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    City: 
                </div>
                <div class="col-sm-9">
                    <?php echo $comp['city']; ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    Postcode: 
                </div>
                <div class="col-sm-9">
                    <?php echo $comp['postcode']; ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    Mobile: 
                </div>
                <div class="col-sm-9">
                    <?php echo $comp['mob_one']; ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    Mobile: 
                </div>
                <div class="col-sm-9">
                    <?php echo $comp['mob_two']; ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    Landline: 
                </div>
                <div class="col-sm-9">
                    <?php echo $comp['landline']; ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    Registration No: 
                </div>
                <div class="col-sm-9">
                    <?php echo $comp['registration_no']; ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    Value Added Tax: 
                </div>
                <div class="col-sm-9">
                    <h2 class="text-warning"><?php echo $comp['tax_value']; ?>&nbsp;%</h2>
                </div>
            </div>
            <div class="form-group row text-dark">
                <div class="col-sm-4">
                <img class="img-thumbnail" src="../php/user/logoShow.php?user=<?php echo $ownedBy_S ?>" alt="Company Logo">
                </div>
                <?php echo $ownedBy_S; ?>
            </div>
        </div>
        <div class="p-lg-5 col-lg-6 col-sm-12 p-md-3 text-wrap">
            <h2 class="mb-3">Edit Company Details</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Company Logo</label>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" id="file" class="custom-file" name="logo" accept="image/*" onchange="return fileValidation()">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Company Name" value="<?php echo $comp['name']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">E-Mail</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="email" name="email" placeholder="Company E-Mail Address" value="<?php echo $comp['email']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="address" name="address" placeholder="House/Unit No ~ Street Name" value="<?php echo $comp['address']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="country" class="col-sm-3 col-form-label">Country</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="country" name="country" placeholder="Country Name" value="<?php echo $comp['country']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="city" class="col-sm-3 col-form-label">City</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="icity" name="city" placeholder="City Name" value="<?php echo $comp['city']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="postcode" class="col-sm-3 col-form-label">Postcode</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode" value="<?php echo $comp['postcode']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mob-one" class="col-sm-3 col-form-label">Mobile</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="mob-one" name="mob-one" placeholder="Mobile 1" value="<?php echo $comp['mob_one']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mob-two" class="col-sm-3 col-form-label">Mobile</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="mob-two" name="mob-two" placeholder="Mobile 2" value="<?php echo $comp['mob_two']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="landline" class="col-sm-3 col-form-label">Landline</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="landline" name="landline" placeholder="Landline" value="<?php echo $comp['landline']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="reg" class="col-sm-3 col-form-label">Registration No.</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="reg" name="reg" placeholder="Tax Registration No" value="<?php echo $comp['registration_no']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="select" class="col-sm-3 col-form-label">Select VAT Value : <span id="value-show"></span>&nbsp;%</label>
                    <div class="col-sm-9">
                        <input type="range" min="0" max="100" value="<?php echo $comp['tax_value']; ?>" class="custom-range w-100" id="myRange" name="tax-value">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary" name="submit">Submit Changes</button>
                    </div>
                </div>
            </form>
            <br>
        </div>
        </div>
    </div>
    <script src="../app/jquery-3.4.1.min.js"></script>
    <script src="../app/bootstrap.min.js"></script>
    <script src="../app/app.js?2"></script>
    <script>
        var slider = document.getElementById("myRange");
        var output = document.getElementById("value-show");
        output.innerHTML = slider.value;

        slider.oninput = function() {
        output.innerHTML = this.value;
        }

        
    </script>
<?php
}
else
{
?>
<div class="container text-center my-5 py-5">
    <p class="text-capitalize text-white-50" style="font-size:4vw">Prohibited access</p>
    <p class="text-capitalize text-white-50" style="font-size:6vw">manager access only</p>
</div>
<?php
}
?>
 
</body>
</html>