<?php
require('../php/user/auth.php');
define('functions',TRUE);
require('../php/user/functions.php');
$extract = new extract();
$update = new update();
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobOne = $_POST['mob-one'];
    $mobTwo = $_POST['mob-two'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $postcode = $_POST['postcode'];
    $update->updUser($conn, $ownedBy_S, $username, $name, $email, $mobOne, $mobTwo, $address, $city, $postcode, $country);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MANAGER | USER EDIT</title>
    <link rel="icon" type="image/*" href="../php/user/logoShow.php?user=<?php echo $ownedBy_S; ?>" sizes="16x16">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
	<link rel="stylesheet" href="../style/style.css">
</head>
<body class="bg-info">
<?php 
	define('nav',TRUE);
    include('nav.php');
if($level == "manager")
{
?>
                <?php
                if(isset($_GET['user']))
                {
                    $user = $_GET['user'];
                }
                if(isset($_GET['user-retour']))
                {
                    $user = $_GET['user-retour'];
                ?>
                    <div class="container">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Holy guacamole!</strong> User edited successfully
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    </div>
                <?php
                }
                $row = $extract->workerEXTSpec($conn, $ownedBy_S, $user);
                $json = json_decode($row);
                ?>
    <div class="container mt-1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="cpanel.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="user-view.php">Garage App Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Garage App User Edit USERNAME: <b><?php echo $user; ?></b></li>
            </ol>
        </nav>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-2 my-lg-5">

            </div>
            <div class="col-sm-12 col-lg-8 my-lg-5">
           
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="username" class="text-light">Username</label>
                            <input class="form-control" type="text" id="username" name="username" value="<?php echo $json->username ?>" readonly>
                        </div>
                    </div>
                    <div class="hr-warning">
                        <hr>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="name" class="text-light">Personal Details</label>
                            <input class="form-control" type="text" id="name" name="name" value="<?php echo $json->name ?>" placeholder="Name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="email" name="email" value="<?php echo $json->email ?>" placeholder="E-mail">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="mob-one" name="mob-one" value="<?php echo $json->mob_one ?>" placeholder="Contact">
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="mob-two" name="mob-two" value="<?php echo $json->mob_two ?>" placeholder="Contact">
                        </div>
                    </div>  
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="address" name="address" value="<?php echo $json->address ?>" placeholder="Address">
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="city" name="city" value="<?php echo $json->city ?>" placeholder="City Name">
                        </div>
                    </div>  
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="country" name="country" value="<?php echo $json->country ?>" placeholder="Country">
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="postcode" name="postcode" value="<?php echo $json->postcode ?>" placeholder="Postcode">
                        </div>
                    </div>
                    <div class="hr-warning">
                        <hr>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="level" class="text-light">Manager/Worker</label>
                            <input class="form-control" type="text" id="level" value="<?php echo $json->auth_level ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <button type="submit" class="btn btn-primary float-right" name="submit">Edit User Details</button>
                        </div>
                    </div>
                </form>   
            </div>
            <div class="col-sm-12 col-lg-2 my-5 py-5">
                
            </div>
        </div>
    </div>

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
 
<script src="../app/jquery-3.4.1.min.js"></script>
<script src="../app/bootstrap.min.js"></script>
<script src="../app/app.js?2"></script>
</body>
</html>