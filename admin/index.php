<?php
define('FunctionS',TRUE);
require('../php/admin/functions.php');

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $extract = new extract();
    $extract->login($conn, $username, $password);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY GARAGE APP | ADMINISTRATOR</title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">

</head>

<body style="background:#F9F8F8">

    <!-- content -->

    <div class="container mt-5">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="p-5">
            <h1 class="text-center">Admin Portal</h1>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Username"
                    onblur="checkUserName(this.value)">
                <div class="invalid-feedback">Wrong Username</div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                    onkeyup="checkPassword(this.value)">
                <div class="invalid-feedback">Wrong Password</div>
            </div>
            <div class="form-group">
                <button id="button" name="submit" class="btn btn-block btn-info" onclick="return checkError()">Log In</button>
            </div>
        </form>
    </div>

    <!-- content ends here -->



    <script src="../app/jquery-3.4.1.min.js"></script>
    <script src="../app/bootstrap.min.js"></script>
    <script src="../app/app.js"></script>
    <script src="../app/md5.js"></script>
</body>

</html>