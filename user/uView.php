<?php
require('../php/user/auth.php');
define('functions',TRUE);
require('../php/user/functions.php');
$extract = new extract();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MANAGER | USER VIEW</title>
    <link rel="icon" type="image/*" href="../php/user/logoShow.php?user=<?php echo $ownedBy_S ?>" sizes="16x16">
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
    <div class="container mt-1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="cpanel.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Garage App Users List</li>
            </ol>
        </nav>
    </div>

    <div class="container-fluid mt-3 mx-0 row col-sm-12 mb-5">
        <div class="col-lg-4 mb-3">
            <div class="row m-2">
                <h2 class="text-white-50 text-center">User Status</h2>
                <div class="table-sm table-responsive">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table table-bordered table-striped table-light mb-0" id="status">

                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Username</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Access Status</th>
                                </tr>
                            </thead>

                            <tbody>
                            <!-- JSON DECODE SHIT -->
                                <?php
                                $data = $extract->userEXT($conn, $ownedBy_S);
                                
                                $dec = json_decode($data);
                                $length = count($dec);
                                for($i = 0; $i < $length; $i++){ ?>
                                <tr>
                                    <td><?php echo $dec[$i]->username; ?></td>
                                    <td><?php echo $dec[$i]->name; ?></td>
                                    <td><?php echo $dec[$i]->status; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 mb-3">
            <div class="row m-2">
                <h2 class="text-white-50 text-center">Garage App Managers and Workers Details</h2>
                <div class="table-sm table-responsive">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table table-bordered table-striped table-light mb-0" id="user-table">

                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Authentication Level</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                            $workerData = $extract->workerEXT($conn, $ownedBy_S);

                            $workerDec = json_decode($workerData);
                            $workerLength = count($workerDec);
                            $count = 1;
                                for($i = 0; $i < $workerLength; $i++){    ?>

                                <tr>
                                    <td class="font-weight-bold"><?php echo $count; ?></td>
                                    <td>
                                        <button type="submit" class="btn btn-success" data-toggle="modal"
                                            data-target="#userviewmodal<?php echo $workerDec[$i]->username; ?>"><?php echo $workerDec[$i]->username; ?></button>
                                    </td>
                                    <td><?php echo $workerDec[$i]->name; ?></td>
                                    <td><?php echo $workerDec[$i]->email; ?></td>
                                    <td><?php echo $workerDec[$i]->auth_level; ?></td>
                                </tr>


                                <!-- Modal -->
                                <div class="modal" id="userviewmodal<?php echo $workerDec[$i]->username?>" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalScrollableLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenteredLabel">
                                                    <?php echo $workerDec[$i]->name; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row my-2">
                                                    <div class="col-sm-4">
                                                        Username:
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <b><?php echo $workerDec[$i]->username ?></b>
                                                    </div>
                                                </div>
                                                <div class="row my-2">
                                                    <div class="col-sm-4">
                                                        Full address:
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <b><?php echo $workerDec[$i]->address; ?><br><?php echo $workerDec[$i]->city; ?><br><?php echo $workerDec[$i]->country; ?><br><?php echo $workerDec[$i]->postcode; ?></b>
                                                    </div>
                                                </div>
                                                <div class="row my-2">
                                                    <div class="col-sm-4">
                                                        Contacts:
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <b><?php echo $workerDec[$i]->email; ?><br><?php echo $workerDec[$i]->mob_one; ?><br><?php echo $workerDec[$i]->mob_two; ?></b>
                                                    </div>
                                                </div>
                                                <div class="row my-2">
                                                    <div class="col-sm-4">
                                                        Authentication level:
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <b><?php echo $workerDec[$i]->auth_level; ?></b>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success"
                                                    onclick="window.location.href = 'uEdit.php?user=<?php echo $workerDec[$i]->username; ?>'">Edit
                                                    Details</button>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="window.location.href = '../php/user/ubd.php?user-block=<?php echo $workerDec[$i]->username; ?>'">Block
                                                    Access</button>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="window.location.href = '../php/user/ubd.php?user-unblock=<?php echo $workerDec[$i]->username; ?>'">Unblock
                                                    Access</button>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="window.location.href = '../php/user/ubd.php?user-delete=<?php echo $workerDec[$i]->username; ?>'">Delete
                                                    User</button>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Ends -->

                                <?php
                            $count++;
                                }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
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