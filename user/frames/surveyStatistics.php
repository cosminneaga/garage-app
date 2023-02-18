<?php
require('../../php/user/auth.php');
define('functions', TRUE);
require('../../php/user/functions.php');
$extract = new extract();
$comp = $extract->company($conn, $ownedBy_S);
$name = $comp['name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Statistics</title>
    <link rel="stylesheet" href="../../style/bootstrap.min.css">
</head>

<body class="bg-dark text-light">

    <div class="container-fluid p-5">

        <div class="row d-flex justify-content-center mb-5">
            <h3>Questions</h3>
            <select id="question" class="custom-select" onchange="select_data(this.value)">
                <option value="1" selected><b>1.</b> <i>What is your overall impression about the speed of the repair
                        process the
                        <?php echo $name ?> has done on your vehicle repair?
                    </i></option>
                <option value="2">2.&nbsp;How welcomed did you feel when you get in contact with
                    <?php echo $name ?> and its members?
                </option>
                <option value="3">3.&nbsp;What is your overall impression of the Quality of Service,
                    <?php echo $name ?> had provide you with?
                </option>
                <option value="4">4.&nbsp;How likely are you considering making contact with
                    <?php echo $name ?> in case something similar happens in future?
                </option>
                <option value="5">5.&nbsp;How likely would you be to recommend
                    <?php echo $name ?> to your relatives and friends?
                </option>
            </select>

        </div>

        <div class="row">

            <div class="col-lg-6 my-1">
                <canvas id="avg-chart" class="border border-dark shadow rounded-lg p-4 bg-white"></canvas>
            </div>

            <div class="col-lg-6 my-1">

                <canvas id="percent-chart" class="border border-dark shadow rounded-lg p-3 bg-white"></canvas>
            </div>

        </div>
    </div>



    <script src="../../app/jquery-3.4.1.min.js"></script>
    <script src="../../app/bootstrap.bundle.min.js"></script>
    <script src="../../app/bootstrap.min.js"></script>
    <script src="../../app/app.js?2"></script>
    <script src="../../app/chart.min.js"></script>
    <script>
        function sum(input) {
            if (toString.call(input) !== "[object Array]")
                return false;
            var total = 0;
            for (var i = 0; i < input.length; i++) {
                if (isNaN(input[i])) {
                    continue;
                }
                total += Number(input[i]);
            }
            return total;
        }

        function transformObjectIntoArrforPercentChart(data) {
            let answers_no = data.length;
            let answers = [];
            data.forEach(el => {
                answers.push(el.answer);
            });

            var counts = {};
            answers.forEach(function (x) {
                counts[x] = (counts[x] || 0) + 1;
            });

            let position = [];
            let values = [];
            for (let key in counts) {
                position.push(parseInt(key) - 1);
                values.push((counts[key] / answers_no) * 100);
            }
            chart_data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            function insertAt(array, index, elements) {
                let pos = 0;
                index.forEach(index => {
                    array.splice(index, 1, parseFloat(elements[pos].toFixed(2)));
                    pos += 1;
                })
            }
            insertAt(chart_data, position, values);
            return chart_data;
        }

        $.ajax({
            type: 'POST',
            url: '../../php/user/extSurveyData.php',
            data: {
                owned_by: 1
            },
            success: function (response) {
                let data = JSON.parse(response);

                let que1 = [];
                let que2 = [];
                let que3 = [];
                let que4 = [];
                let que5 = [];

                let q1_one_three = [];
                let q1_four_six = [];
                let q1_seven_ten = [];

                let q2_one_three = [];
                let q2_four_six = [];
                let q2_seven_ten = [];

                let q3_one_three = [];
                let q3_four_six = [];
                let q3_seven_ten = [];

                let q4_one_three = [];
                let q4_four_six = [];
                let q4_seven_ten = [];

                let q5_one_three = [];
                let q5_four_six = [];
                let q5_seven_ten = [];

                data.forEach(el => {
                    let que = parseInt(el.question_no);
                    if (que === 1) {
                        let ans = parseInt(el.answer);
                        if (ans >= 1 && ans <= 3) {
                            q1_one_three.push(el.client_id);
                        }
                        if (ans >= 4 && ans <= 6) {
                            q1_four_six.push(el.client_id);
                        }
                        if (ans >= 7 && ans <= 10) {
                            q1_seven_ten.push(el.client_id);
                        }
                    }
                    if (que === 2) {
                        let ans = parseInt(el.answer);
                        if (ans >= 1 && ans <= 3) {
                            q2_one_three.push(el.client_id);
                        }
                        if (ans >= 4 && ans <= 6) {
                            q2_four_six.push(el.client_id);
                        }
                        if (ans >= 7 && ans <= 10) {
                            q2_seven_ten.push(el.client_id);
                        }
                    }
                    if (que === 3) {
                        let ans = parseInt(el.answer);
                        if (ans >= 1 && ans <= 3) {
                            q3_one_three.push(el.client_id);
                        }
                        if (ans >= 4 && ans <= 6) {
                            q3_four_six.push(el.client_id);
                        }
                        if (ans >= 7 && ans <= 10) {
                            q3_seven_ten.push(el.client_id);
                        }
                    }
                    if (que === 4) {
                        let ans = parseInt(el.answer);
                        if (ans >= 1 && ans <= 3) {
                            q4_one_three.push(el.client_id);
                        }
                        if (ans >= 4 && ans <= 6) {
                            q4_four_six.push(el.client_id);
                        }
                        if (ans >= 7 && ans <= 10) {
                            q4_seven_ten.push(el.client_id);
                        }
                    }
                    if (que === 5) {
                        let ans = parseInt(el.answer);
                        if (ans >= 1 && ans <= 3) {
                            q5_one_three.push(el.client_id);
                        }
                        if (ans >= 4 && ans <= 6) {
                            q5_four_six.push(el.client_id);
                        }
                        if (ans >= 7 && ans <= 10) {
                            q5_seven_ten.push(el.client_id);
                        }
                    }
                });


                que1.push(q1_one_three.length);
                que1.push(q1_four_six.length);
                que1.push(q1_seven_ten.length);

                que2.push(q2_one_three.length);
                que2.push(q2_four_six.length);
                que2.push(q2_seven_ten.length);

                que3.push(q3_one_three.length);
                que3.push(q3_four_six.length);
                que3.push(q3_seven_ten.length);

                que4.push(q4_one_three.length);
                que4.push(q4_four_six.length);
                que4.push(q4_seven_ten.length);

                que5.push(q5_one_three.length);
                que5.push(q5_four_six.length);
                que5.push(q5_seven_ten.length);


                // var barChartData = sortData();

                var ctxLineChart = document.getElementById('avg-chart');
                var yearLineChart = new Chart(ctxLineChart, {
                    type: 'line',
                    data: {
                        labels: ['1', '2', '3', '4', '5'],
                        datasets: [{
                            label: 'Answers between 1 and 3',
                            fill: false,
                            borderColor: 'red',
                            data: [que1[0], que2[0], que3[0], que4[0], que5[0]]
                        }, {
                            label: 'Answers between 4 and 5',
                            fill: false,
                            borderColor: 'green',
                            data: [que1[1], que2[1], que3[1], que4[1], que5[1]]
                        }, {
                            label: 'Answers between 7 and 10',
                            fill: false,
                            borderColor: 'blue',
                            data: [que1[2], que2[2], que3[2], que4[2], que5[2]]
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                },
                                gridLines: {
                                    display: false
                                }
                            }]
                        },
                        title: {
                            display: true,
                            position: 'top',
                            text: 'No of customers per questions/answer',
                            fontSize: 24,
                            fontColor: 'black'
                        },
                        tooltips: {
                            titleFontSize: 18,
                            footerFontSize: 20,
                            cornerRadius: 0,
                            caretSize: 7,
                            xPadding: 10,
                            yPadding: 10,
                            titleFontStyle: 'normal',
                            titleMarginBottom: 15,
                            position: 'nearest',
                            intersect: false,
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var label = data.datasets[tooltipItem.datasetIndex].label;
                                    return label;
                                },
                                title: function (tooltipItem, data) {
                                    // console.log(tooltipItem)
                                    return 'Question no.: ' + tooltipItem[0].xLabel;
                                },
                                footer: function (tooltipItem, data) {
                                    return tooltipItem[0].value + ' people answered.';
                                }
                            }
                        },
                        elements: {
                            point: {
                                radius: 6
                            }
                        }
                    }
                });
            }
        });



        // pie chart to analyse percentage
        var ctxPercentChart = document.getElementById('percent-chart').getContext('2d');
        var percentChart = new Chart(ctxPercentChart, {
            type: 'doughnut',
            data: {
                labels: ['A:1', 'A:2', 'A:3', 'A:4', 'A:5', 'A:6', 'A:7', 'A:8', 'A:9', 'A:10'],
                datasets: [{
                    data: [10, 10, 10, 10, 10, 10, 10, 10, 10, 10],
                    backgroundColor: ['rgba(153, 20, 12, 1)', 'rgba(238, 46, 28, 1)', 'rgba(255, 106, 76, 1)', 'rgba(235, 166, 169, 1)', 'rgba(201, 221, 167, 1)', 'rgba(116, 142, 84, 1)', 'rgba(58, 77, 42, 1)', 'skyblue', 'rgba(0, 79, 255, 1)', 'rgba(23, 40, 255, 1)'],
                    borderColor: 'white',
                }]
            },
            options: {
                title: {
                    display: true,
                    position: 'top',
                    text: 'Speed',
                    fontSize: 24,
                    fontColor: 'black'
                },
                tooltips: {
                    titleFontSize: 18,
                    footerFontSize: 20,
                    cornerRadius: 0,
                    caretSize: 7,
                    xPadding: 10,
                    yPadding: 10,
                    titleFontStyle: 'normal',
                    titleMarginBottom: 15,
                    position: 'nearest',
                    intersect: false,
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label;
                            return label;
                        },
                        title: function (tooltipItem, data) {
                            var que = tooltipItem[0].index + 1;
                            return 'Answer: ' + que;
                        },
                        footer: function (tooltipItem, data) {
                            return data.datasets[0].data[tooltipItem[0].index] + ' % of people answered.';
                        }
                    }
                }
            }
        });


        $.ajax({
            type: 'POST',
            url: '../../php/user/extSurveyData.php',
            data: {
                question_no: 1
            },
            success: function (response) {
                let data = JSON.parse(response);
                let chart_data = transformObjectIntoArrforPercentChart(data);
                percentChart.data.datasets[0].data = chart_data;
                percentChart.update();
            }
        });


        function select_data(value) {
            let question_select;
            let chart_title;

            if (value === '1') {
                question_select = 1;
                chart_title = 'Speed';
            }
            if (value === '2') {
                question_select = 2;
                chart_title = 'Friendliness';
            }
            if (value === '3') {
                question_select = 3;
                chart_title = 'Quality of Service';
            }
            if (value === '4') {
                question_select = 4;
                chart_title = 'Future Business';
            }
            if (value === '5') {
                question_select = 5;
                chart_title = 'Further Recommendation';
            }

            $.ajax({
                type: 'POST',
                url: '../../php/user/extSurveyData.php',
                data: {
                    question_no: question_select
                },
                success: function (response) {
                    let data = JSON.parse(response);
                    let chart_data = transformObjectIntoArrforPercentChart(data);
                    percentChart.data.datasets[0].data = chart_data;
                    percentChart.options.title.text = chart_title;
                    percentChart.update();
                }
            });
        }
    </script>
</body>

</html>