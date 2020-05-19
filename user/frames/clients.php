<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clients</title>
    <link rel="stylesheet" href="../../style/bootstrap.min.css">
</head>

<body class="bg-dark">
    <?php
require('../../php/user/auth.php');
define('functions',TRUE);
require('../../php/user/functions.php');
    $extract = new extract();
    $compData = $extract->company($conn, $ownedBy_S);
    $compEmail = $compData['email'];
    $compName = $compData['name'];
    $data = $extract->clients($conn, $ownedBy_S);
    $row = json_decode($data);
    $length = count($row);

    
?>

        <div class="container-fluid p-4">
            <div class="row d-flex justify-content-center text-justify">
                <div class="container mb-1">
                    <input class="form-control mr-sm-2" id="search-client" type="text" placeholder="Search using any keyword..." value="">
                </div>
            </div>
            <div class="row d-flex justify-content-center text-justify">


                <table class="table table-hover bg-white table-responsive-md">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Contact</th>
                            <th scope="col">E-Mail</th>
                            <th scope="col">Survey Status</th>
                            <th scope="col">Edit Details</th>
                            <th scope="col">Send Progress</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php $count = 1;
         for($i = 0; $i < $length; $i++){ ?>


                        <tr>
                            <th scope="row">
                                <?php echo $count ?>
                            </th>
                            <td>
                                <?php echo $row[$i]->name ?>
                            </td>
                            <td>
                                <?php echo $row[$i]->address.','.$row[$i]->city.','.$row[$i]->country.','.$row[$i]->postcode ?>
                            </td>
                            <td>
                                <a href="tel:<?php echo $row[$i]->mob_one?>"><?php echo $row[$i]->mob_one?></a> |
                                <a href="tel:<?php echo $row[$i]->mob_two?>"><?php echo $row[$i]->mob_two?></a>
                            </td>
                            <td>
                                <a href="mailto:<?php echo $row[$i]->email?>"><?php echo $row[$i]->email?></a>
                            </td>
                            <!-- three badges 'send/not completed/completed' -->
                            <!-- primary/dark/success -->
                            <?php
                                $id = $row[$i]->id;
                                $own = $row[$i]->owned_by;
                            ?>

                                <td><a href="#" onclick="sendSurvey(this.textContent, '<?php echo $id ?>', '<?php echo $own ?>','<?php echo generateRandomString(); ?>')"><span class="badge badge-primary" id="survey-status"><?php echo strtoupper($row[$i]->survey_status) ?></span></a></td>

                                <td><a href="#" class="card-link" data-toggle="modal" data-target="#modal" id="edit" onclick="getClient('<?php echo $id ?>')">Edit</a></td>
                                <td><a href="#" class="card-link" onclick="sendData('<?php echo $compName ?>','<?php echo $compEmail ?>','<?php echo $row[$i]->name ?>','<?php echo $row[$i]->email ?>')">Send Progress</a></td>


                        </tr>



                        <?php $count++; } ?>

                    </tbody>
                </table>

            </div>


            <!-- Modal Edit Client -->
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                        </div>
                        <div class="modal-body">
                            <form class="form-group">
                                <input type="text" id="name" class="form-control mt-1" placeholder="Name">
                                <input type="email" id="email" class="form-control mt-1" placeholder="E-Mail">
                                <input type="text" id="address" class="form-control mt-1" placeholder="Address">
                                <input type="text" id="city" class="form-control mt-1" placeholder="City">
                                <input type="text" id="country" class="form-control mt-1" placeholder="Country">
                                <input type="text" id="postcode" class="form-control mt-1" placeholder="Postcode">
                                <input type="text" id="mobile" class="form-control mt-1" placeholder="Mobile">
                                <input type="text" id="landline" class="form-control mt-1" placeholder="Mobile/Landline">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="save-button" onclick="submitClientData(this.value)">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Modal Update Survey Status -->
            <div class="modal fade" id="modal-survey" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Send the link for survey to you clients</h5>
                        </div>
                        <div class="modal-body text-center">
                            <h4>Click the button to copy the link</h4>
                            <textarea id="modal-survey-content" rows="4" class="form-control" readonly></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="save-button" onclick="captureLink()">Copy</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal Survey Data -->
            <div class="modal fade" id="modal-survey-data" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Survey Data Analytics</h5>
                        </div>
                        <div class="modal-body text-center">

                            <div id="cv"><canvas id="survey-data-graph"></canvas></div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Questions
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item">
                                        <b>1.</b> <i>What is your overall impression about the speed of the repair process the <?php echo $compName ?> has done on your vehicle repair?</i>
                                    </a>
                                    <a class="dropdown-item">
                                        <b>2.</b> <i>How welcomed did you feel when you get in contact with <?php echo $compName ?> and its members?</i>
                                    </a>
                                    <a class="dropdown-item">
                                        <b>3.</b> <i>What is your overall impression of the Quality of Service, <?php echo $compName ?> had provide you with?</i>
                                    </a>
                                    <a class="dropdown-item">
                                        <b>4.</b> <i>How likely are you considering making contact with <?php echo $compName ?> in case something similar happens in future?</i>
                                    </a>
                                    <a class="dropdown-item">
                                        <b>5.</b> <i>How likely would you be to recommend <?php echo $compName ?> to your relatives and friends?</i>
                                    </a>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearCanvas()">Close</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <script src="../../app/jquery-3.4.1.min.js"></script>
        <script src="../../app/bootstrap.bundle.min.js"></script>
        <script src="../../app/bootstrap.min.js"></script>
        <script src="../../app/app.js?2"></script>
        <script src="../../app/md5.js"></script>
        <script src="../../app/chart.min.js"></script>
        <script>
            let title = document.getElementById('exampleModalCenterTitle');
            let name = document.getElementById('name');
            let email = document.getElementById('email');
            let address = document.getElementById('address');
            let city = document.getElementById('city');
            let country = document.getElementById('country');
            let postcode = document.getElementById('postcode');
            let mobile = document.getElementById('mobile');
            let landline = document.getElementById('landline');
            let saveButton = document.getElementById('save-button');
            let modal_survey_link = document.getElementById('modal-survey-content');
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

            function clearCanvas() {
                var cv = document.getElementById('cv');
                var oldcanv = document.getElementById('survey-data-graph');
                cv.removeChild(oldcanv)

                var canv = document.createElement('canvas');
                canv.id = 'survey-data-graph';
                cv.appendChild(canv);
            }

            function sendSurvey(value, id, own, str) {

                if (value === 'SEND') {
                    modal_survey_link.value = location.hostname + '/surveys/client_survey.php?session=' + id + '&session_id=' + own + '&ssl=' + calcMD5(str);
                    $.ajax({
                        type: "POST",
                        url: '../../php/user/clientUpdate.php?update-status=1',
                        data: {
                            id: id,
                            str: calcMD5(str)
                        },
                        success: function() {
                            $('#modal-survey').modal('show');
                        }
                    });
                }
                if (value === 'NOT COMPLETED') {
                    $.ajax({
                        type: "GET",
                        url: "../../php/user/getClient.php",
                        data: {
                            client: id
                        },
                        success: function(srv) {
                            let data = JSON.parse(srv);
                            $('#modal-survey').modal('show');
                            modal_survey_link.value = location.hostname + '/surveys/client_survey.php?session=' + data.session + '&session_id=' + own + '&ssl=' + data.ssl;
                        }
                    });
                }
                if (value === 'COMPLETED') {
                    $.ajax({
                        type: "POST",
                        url: "../../php/user/extSurveyData.php",
                        data: {
                            client_id: id
                        },
                        success: function(srv) {
                            let data = JSON.parse(srv);
                            $('#modal-survey-data').modal('show');
                            let labels = [];
                            let answers = [];
                            data.forEach(el => {
                                labels.push(parseInt(el.question_no));
                                answers.push(parseInt(el.answer));
                            });

                            let chartColors = {
                                red: 'rgba(108, 8, 14, 0.4)',
                                yellow: 'rgba(247, 208, 2, 0.4)',
                                green: 'rgba(14, 127, 27, 0.4)',
                                borderRed: 'rgba(108, 8, 14, 1)',
                                borderYellow: 'rgba(247, 208, 2, 1)',
                                borderGreen: 'rgba(14, 127, 27, 1)'
                            }

                            let questions = [

                            ]
                            questions.forEach(el => {
                                console.log('Question: ' + el)
                            });


                            var survey_data = document.getElementById('survey-data-graph').getContext('2d');
                            var myBarChart = new Chart(survey_data, {
                                type: 'bar',
                                data: {
                                    labels: ['Speed', 'Friendliness', 'Quality of Service', 'Future Business', 'Further Recommendation'],
                                    datasets: [{
                                        label: 'Answer',
                                        data: answers,
                                        borderWidth: 2,
                                        backgroundColor: [],
                                        borderColor: []
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                min: 0,
                                                max: 10,
                                                beginAtZero: true
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: false
                                    }
                                }
                            });

                            let dataset = myBarChart.data.datasets[0];
                            dataset.data.forEach(function(item, index) {
                                if (item <= 5) {
                                    dataset.backgroundColor[index] = chartColors.red;
                                    dataset.borderColor[index] = chartColors.borderRed;
                                }
                                if (item > 5 && item <= 8) {
                                    dataset.backgroundColor[index] = chartColors.yellow;
                                    dataset.borderColor[index] = chartColors.borderYellow;
                                }
                                if (item > 8) {
                                    dataset.backgroundColor[index] = chartColors.green;
                                    dataset.borderColor[index] = chartColors.borderGreen;
                                }
                            });
                            myBarChart.update();
                        }

                    });

                }

            }


            function captureLink() {
                window.location.reload();
                modal_survey_link.select();
                modal_survey_link.setSelectionRange(0, 99999);
                document.execCommand("copy");
            }

            // search input function
            $(document).ready(function() {
                $("#search-client").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });

            function sendData(companyName, companyEmail, name, email) {
                window.location.href = '../work_progress_setup.php?compName=' + companyName + '&compEmail=' + companyEmail + '&name=' + name + '&email=' + email;
            }

            function getClient(id) {
                var text = '';
                data =
                    $.ajax({
                        type: "GET",
                        url: "../../php/user/getClient.php",
                        data: {
                            clientID: id
                        },
                        success: function(srv) {
                            let data = JSON.parse(srv);
                            saveButton.value = data.id;
                            title.innerHTML = data.name;
                            name.value = data.name;
                            email.value = data.email;
                            address.value = data.address;
                            city.value = data.city;
                            country.value = data.country;
                            postcode.value = data.postcode;
                            mobile.value = data.mob_one;
                            landline.value = data.mob_two;
                        }
                    });
            }

            function submitClientData(id) {
                var form_data = {
                    id: id,
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
                    url: '../../php/user/clientUpdate.php?update=1',
                    data: form_data,
                    success: function() {
                        $('#modal').modal('hide');
                        window.location.reload();
                    }
                });
            }
        </script>
</body>

</html>