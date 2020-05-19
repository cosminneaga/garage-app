<?php
require('../php/admin/auth.php');
define('FunctionS',TRUE);
require('../php/admin/functions.php');
$extract = new extract();
$num_user = $extract->userNum($conn);
$data = $extract->userShow($conn);
$data = json_decode($data);
// $db = $extract->getDBSize($conn_schema);
// // echo var_dump($db['MB']);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MY GARAGE APP | DASHBOARD</title>
        <link rel="stylesheet" href="../style/bootstrap.min.css">
        <style>
            .gradient-info-right {
                background-image: linear-gradient(to right, #00d4ff, #0e00ff);
                color: white;
            }
            
            .gradient-info-left {
                background-image: linear-gradient(to left, #00d4ff, #0e00ff);
                color: white;
            }
            
            .collapsing {
                -webkit-transition: height .01s ease;
                transition: height .01s ease
            }
        </style>
    </head>

    <body>
        <?php define('navigation',TRUE); require('nav.php'); ?>
        <?php define('modal', TRUE); require('add_user_modal.php'); ?>

        <!-- content -->

        <div class="container-fluid p-4">
            <!-- CARDS WITH DATA -->
            <div class="row">

                <div class="col-md-6">

                    <div class="row p-1">

                        <div class="gradient-info-right p-3 w-100 d-flex justify-content-between">
                            <div>
                                <div class="display-4">
                                    <?php echo $num_user; ?>
                                </div>
                                <p>Users</p>
                            </div>
                            <!-- <div>
                                <p>Database Size</p>
                                <h4><?php echo $db['MB']; ?></h4>
                                <p>Mb Occupied</p>
                            </div> -->
                        </div>

                    </div>

                </div>


                <!-- <div class="col-md-6">

                    <div class="row p-1">

                        <div class="gradient-info-left p-2 w-100">
                            <p>
                                <?php echo 'DB stat: '.$conn->stat.'<br>'; ?></p>
                            <p>
                                <?php echo 'Server info: '.$conn->server_info.'<br>';?></p>
                            <p>
                                <?php echo 'Server version: '.$conn->server_version.'<br>';?></p>
                            <p>
                                <?php echo 'Host info: '.$conn->host_info.'<br>'; ?></p>
                        </div>

                    </div>

                </div> -->



            </div>

            <!-- USERS TABLE -->
            <div class="row">

                <table class="table table-hover bg-white table-responsive-md table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Name</th>
                            <th scope="col">E-Mail</th>
                            <th scope="col">Owned By</th>
                            <th scope="col">First Registered</th>
                            <th scope="col">Authentication</th>
                            <th scope="col">Status</th>
                            <th scope="col">Survey Status</th>
                            <th scope="col">Change State</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">


                        <?php $count = 1;
                        foreach($data as $key=>$value){
                            ?>
                        <tr id="table-row">
                            <th scope="row">
                                <?php echo $count ?>
                            </th>
                            <td>
                                <?php echo $value->username; ?>
                            </td>
                            <td>
                                <?php echo $value->name; ?>
                            </td>
                            <td>
                                <?php echo $value->email; ?>
                            </td>
                            <td>
                                <?php echo $value->owned_by; ?>
                            </td>
                            <td>
                                <?php echo $value->creation_date; ?>
                            </td>
                            <td>
                                <?php echo $value->auth_level; ?>
                            </td>
                            <td>
                                <?php echo $value->status; ?>
                            </td>

                            <!-- three badges 'send/not completed/completed' -->
                            <!-- primary/dark/success -->
                            <td><a href="#" onclick=""><span class="badge badge-primary" id="survey-status" onclick="interact_survey(this.textContent, '<?php echo $value->username; ?>', '<?php echo $value->owned_by; ?>')"><?php echo strtoupper($value->survey_status); ?></span></a></td>
                            <td>
                                <a href="#"><span class="badge badge-danger" onclick="update(this.textContent, '<?php echo $value->username; ?>', '<?php echo $value->owned_by; ?>')">DELETE</span></a>
                                <a href="#"><span class="badge badge-success" onclick="update(this.textContent, '<?php echo $value->username; ?>', '<?php echo $value->owned_by; ?>')">UNBLOCK</span></a>
                                <a href="#"><span class="badge badge-dark" onclick="update(this.textContent, '<?php echo $value->username; ?>', '<?php echo $value->owned_by; ?>')">BLOCK</span></a>
                            </td>

                        </tr>
                        <?php
                        $count++; } ?>


                    </tbody>
                </table>

            </div>



            <div class="row">


                <div class="col-sm-6">

                </div>

                <div class="col-sm-6">

                </div>



            </div>



        </div>


        

        <!-- content ends here -->


        <script src="../app/jquery-3.4.1.min.js"></script>
        <script src="../app/bootstrap.min.js"></script>
        <script src="../app/app.js"></script>
        <script>
            let tbody = document.getElementById('myTable');
            let row = document.getElementById('table-row');
            let collapse_row = document.getElementById('collapse-row');
            let survey_status_el = document.querySelectorAll('#survey-status');

            survey_status_el.forEach(el => {
                if (el.textContent === 'NOT COMPLETED') {
                    el.classList.remove('badge-primary');
                    el.classList.add('badge-dark');
                }
                if (el.textContent === 'COMPLETED') {
                    el.classList.remove('badge-primary');
                    el.classList.add('badge-success')
                }
            });

            function update(value, user, own) {
                if (value === 'UNBLOCK') {
                    $.ajax({
                        type: 'GET',
                        url: '../php/admin/ubd.php?user-unblock=' + user,
                        beforeSend: function() {
                            if (confirm('Do you really want to unblock ' + user + '?')) {
                                return true;
                            }
                            return false;
                        },
                        success: function() {
                            window.location.reload();
                        }
                    })
                }
                if (value === 'BLOCK') {
                    $.ajax({
                        type: 'GET',
                        url: '../php/admin/ubd.php?user-block=' + user,
                        beforeSend: function() {
                            if (confirm('Do you really want to block ' + user + '?')) {
                                return true;
                            }
                            return false;
                        },
                        success: function() {
                            window.location.reload();
                        }
                    })
                }
                if (value === 'DELETE') {
                    console.log(user)
                    console.log(own)
                    $.ajax({
                        type: 'GET',
                        url: '../php/admin/ubd.php?user-delete=' + user +'&owned_by=' +own,
                        beforeSend: function() {
                            if (confirm('Do you really want to delete ' + user + '?')) {
                                return true;
                            }
                            return false;
                        },
                        success: function() {
                            window.location.reload();
                        }
                    })
                }
            }



            function userCheck(str) {
                if (str != '') {
                    <?php $token = md5(rand(1000, 9999)); $_SESSION['token'] = $token; ?>
                    const input = document.getElementById('username');
                    const button = document.getElementById('button');
                    let http = new XMLHttpRequest();
                    http.open("GET", "../php/admin/fetch.php?token=<?php echo $token ?>&userC=" + str, true);
                    http.send();
                    http.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            let data = JSON.parse(this.responseText);
                            if (data.length > 0) {
                                input.classList.add('is-invalid');
                                button.setAttribute('disabled', true);
                            } else {
                                input.classList.remove('is-invalid');
                                input.classList.add('is-valid');
                                button.removeAttribute('disabled');
                            }
                        }
                    }
                }
            }

            function checkUserPassword(passchk) {
                const _pass = document.getElementById('pass');
                const button = document.getElementById('button');
                const _passchk = document.getElementById('passchk');
                if (_pass.value != '') {
                    if (_pass.value !== passchk) {
                        button.setAttribute('disabled', true);
                        _passchk.classList.add('is-invalid');
                    } else {
                        button.removeAttribute('disabled');
                        _passchk.classList.remove('is-invalid');
                        _passchk.classList.add('is-valid');
                    }
                }
            }

            function checkPassword(string) {
                const username = document.getElementById('username').value;
                const input = document.getElementById('password');
                if (string != '') {
                    let http = new XMLHttpRequest();
                    http.open("POST", "../php/admin/fetch.php?user=" + username, true);
                    http.send();

                    http.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            let data = JSON.parse(this.responseText);

                            if (data.length === 0 || calcMD5(input.value) !== data[0].password) {
                                input.classList.add('is-invalid');
                            }
                            if (data.length === 1 && calcMD5(input.value) === data[0].password) {
                                input.classList.remove('is-invalid');
                            }
                        }
                    }
                }
            }



            window.onload = function(event) {
                document.getElementById('button').addEventListener('click', post);

                function post() {
                    <?php $token_ins = md5(rand(1000, 9999)); $_SESSION['token-insert'] = $token_ins; ?>
                    let iusername = document.getElementById('username');
                    let iname = document.getElementById('name');
                    let iemail = document.getElementById('email');
                    let ipassword = document.getElementById('pass');
                    if (iusername.value != '' && iname.value != '' && iemail.value != '' && ipassword.value != '') {
                        const username = iusername.value;
                        const name = iname.value;
                        const email = iemail.value;
                        const password = ipassword.value;
                        let http = new XMLHttpRequest();
                        http.open("POST", "../php/admin/uInsert.php", true);
                        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        http.send(`token=<?php echo $token_ins ?>&username=${username}&name=${name}&email=${email}&password=${password}`);
                        http.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                const form = document.getElementById('form');
                                const success = document.getElementById('success');
                                success.innerHTML = 'User Inserted Successfully';
                                form.classList.replace('border-dark', 'border-success');
                            }
                        }
                    }
                }
            }


            function interact_survey(value, username, owned_by){
                if(value === 'SEND'){
                    $.ajax({
                        type: 'GET',
                        url: '../php/admin/survey-data.php?update_status=1&username='+username+'&own='+owned_by,
                        success: function(response){
                            window.location.reload();
                        }
                    });
                }
            }
        </script>

    </body>

    </html>