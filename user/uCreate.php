<?php
require('../php/user/auth.php');
define('functions',TRUE);
require('../php/user/functions.php');
if(isset($_POST['submit'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobOne = $_POST['mob-one'];
    $mobTwo = $_POST['mob-two'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $postcode = $_POST['postcode'];
    $authLevel = $_POST['auth-level'];

    $insert = new insert();
    $extract = new extract();
    $onSuccess = $insert->userByUser($conn, $ownedBy_S, $username, $password, $name, $email, $mobOne, $mobTwo, $address, $city, $postcode, $country, $authLevel);
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MANAGER | USER CREATE</title>
    <link rel="icon" type="image/*" href="../php/user/logoShow.php?user=<?php echo $ownedBy_S; ?>" sizes="16x16">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
	<link rel="stylesheet" href="../style/style.css">
</head>
<body>
<?php
define('nav',TRUE);
require('nav.php'); 
if($level == "manager")
{
?>
    <div class="container mt-1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="cpanel.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Garage App User</li>
            </ol>
        </nav>
    </div>
    <div class="container-fluid mb-5">
        <div class="row">
            <div class="col-sm-12 col-lg-2 my-sm-2 my-lg-5 py-lg-5 text-wrap">

            </div>
            <div class="col-sm-12 col-lg-8 my-lg-5 py-lg-5 border border-secondary mb-5 shadow-lg bg-light">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php if(isset($onSuccess)) echo $onSuccess ?>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="username">Log In Details</label>
                            <input class="form-control" type="text" id="username" name="username" placeholder="Username" onkeyup="checkUsername()" required>
                            <div class="invalid-feedback">Username exists already</div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="username">Log In Details</label>
                            <input class="form-control" type="text" id="password" name="password" placeholder="Password" onblur="checkPassword()" required>
                            <div class="invalid-feedback">Password too short</div>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="name">Personal Details</label>
                            <input class="form-control" type="text" id="name" name="name" placeholder="Name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="email" name="email" placeholder="E-mail">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="mob-one" name="mob-one" placeholder="Mobile" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="mob-two" name="mob-two" placeholder="Mobile">
                        </div>
                    </div>  
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="address" name="address" placeholder="Address">
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="city" name="city" placeholder="City Name">
                        </div>
                    </div>  
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="country" name="country" placeholder="Country">
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <input class="form-control" type="text" id="postcode" name="postcode" placeholder="Postcode">
                        </div>
                    </div>
                    <hr>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="user-select">Worker/Manager</label>
                            <select name="auth-level" id="user-select" class="custom-select">
                                <option value="user">Worker</option>
                                <option value="manager">Manager</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <button class="btn btn-primary float-right" name="submit" onclick="return checkError()">Create User</button>
                        </div>
                    </div>
                </form>   
            </div>
            <div class="col-sm-12 col-lg-2 my-5 py-5 text-light text-justify">
                
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
<script>
    
    function checkUsername(){
        var usernameField = document.getElementById('username');
        var username = usernameField.value;
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "../php/user/ajaxFetch.php?username-check="+username, true);
        xhr.send();
        xhr.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                let data = JSON.parse(this.responseText);
                if(data.length === 1){
                    usernameField.classList.add('is-invalid');
                }else{
                    usernameField.classList.remove('is-invalid');
                }
            }
        }
    }

</script>
</body>
</html>