<?php
    define('user-log-in',TRUE);
    require('php/user/login.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>USER | PORTAL</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">

</head>

<body style="background:#F9F8F8">
    <div class="container">
        <div class="container-fluid mt-5">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6 col-sm-12 p-5 bg-transparent mb-sm-5">

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                        class="p-5 shadow-lg rounded-left bg-primary">
                        <div class="form-group text-center">
                        <h2 class="rounded d-inline-block xbootstrap p-2">User Login Portal</h2>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="name">
                                Username
                                <span class="asteriskField text-dark">
                                    *
                                </span>
                            </label>
                            <input class="form-control" id="name" name="username" type="text"
                                value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" />
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="email">
                                Password
                                <span class="asteriskField text-dark">
                                    *
                                </span>
                            </label>
                            <input class="form-control" id="password" name="password" type="password" />
                        </div>
                        <div class="form-group">
                            <div>
                                <button class="btn btn-block btn-success" name="submit" type="submit">
                                    Login
                                </button>
                            </div>
                        </div>
                        <div class="form-group float-right">
                            <div class="text-warning"><?php if($user_err != "") echo $user_err?></div>
                            <div class="text-warning"><?php if($pass_err != "") echo $pass_err?></div>
                            <div class="text-warning"><?php if($gen_err != "") echo $gen_err ?></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>