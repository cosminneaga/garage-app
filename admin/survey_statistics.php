<?php
require('../php/admin/auth.php');
define('FunctionS',TRUE);
require('../php/admin/functions.php');
$extract = new extract();
$data = $extract->getComments($conn);
$comment = json_decode($data);
// echo var_dump($comment)
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MY GARAGE APP | SURVEY STATISTICS</title>
        <link rel="stylesheet" href="../style/bootstrap.min.css">
    </head>

    <body>
        <?php define('navigation',TRUE); require('nav.php'); ?>
        <?php define('modal', TRUE); require('add_user_modal.php'); ?>

        <div class="container p-5">
            <select id="select" class="custom-select" onchange="getData(this.value)">
                <option value="1">1. Design of interface?</option>
                <option value="2">2. Range of functionalities</option>
                <option value="6">6. Overall Quality. How would you rate this service?</option>
                <option value="7">7. How innovative our service you think it is?</option>
                <option value="9">9. How would you rate its value for money?</option>
                <option value="11">11. How likely are you to replace your current solution with this service?</option>
                <option value="12">12. How likely would you recommend this service to someone you know?</option>
                <option value="13">13. How satified are you with the overall experience of the software?</option>
            </select>
        </div>
        <div class="container">
            <canvas id="percent-chart"></canvas>
        </div>


        <script src="../app/chart.min.js"></script>
        <script src="../app/jquery-3.4.1.min.js"></script>
        <script src="../app/bootstrap.min.js"></script>
        <script src="../app/app.js"></script>
        <script>

            function transformObjectIntoArrforPercentChart(data) {
                let answers_no = data.length;
                let answers = [];
                data.forEach(el => {
                    answers.push(el.answer);
                });

                var counts = {};
                answers.forEach(function(x) {
                    counts[x] = (counts[x] || 0) + 1;
                });

                let position = [];
                let values = [];
                for (let key in counts) {
                    position.push(parseInt(key) - 1);
                    values.push((counts[key] / answers_no) * 100);
                }
                chart_data = [0, 0, 0, 0, 0];

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

            // pie chart to analyse percentage
        var ctxPercentChart = document.getElementById('percent-chart').getContext('2d');
        var percentChart = new Chart(ctxPercentChart, {
            type: 'doughnut',
            data: {
                labels: ['A:1', 'A:2', 'A:3', 'A:4', 'A:5'],
                datasets: [{
                    data: [10, 10, 10, 10, 10],
                    backgroundColor: ['#e63b2e', '#f85a3e', '#f7df6a', '#c7ef00', '#5fbc47'],
                    borderColor: 'white',
                }]
            },
            options: {
                title: {
                    display: true,
                    position: 'top',
                    text: 'Design',
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
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label;
                            return label;
                        },
                        title: function(tooltipItem, data) {
                            var que = tooltipItem[0].index + 1;
                            return 'Answer: ' + que;
                        },
                        footer: function(tooltipItem, data) {
                            return data.datasets[0].data[tooltipItem[0].index] + ' % of people answered.';
                        }
                    }
                }
            }
        });

            $.ajax({
                type: 'POST',
                url: '../php/admin/survey-data.php?get_numbers=1',
                data: {
                    question_no: 1
                },
                success: function(response) {
                    let data = JSON.parse(response);
                    let chart_data = transformObjectIntoArrforPercentChart(data);
                    percentChart.data.datasets[0].data = chart_data;
                    percentChart.update();
                }
            });

            function getData(value) {
                let question_select;
                let chart_title;
                if (value === '1') {
                    question_select = 1;
                    chart_title = 'Design';
                }
                if (value === '2') {
                    question_select = 2;
                    chart_title = 'Range of functionalities.';
                }
                if (value === '6') {
                    question_select = 6;
                    chart_title = 'Overall Quality.';
                }
                if (value === '7') {
                    question_select = 7;
                    chart_title = 'Innovative.';
                }
                if (value === '9') {
                    question_select = 9;
                    chart_title = 'Rate value for money.';
                }
                if (value === '11') {
                    question_select = 11;
                    chart_title = 'Replace current solution.';
                }
                if (value === '12') {
                    question_select = 12;
                    chart_title = 'Recommendation.';
                }
                if (value === '13') {
                    question_select = 13;
                    chart_title = 'Satisfaction.';
                }

                $.ajax({
                type: 'POST',
                url: '../php/admin/survey-data.php?get_numbers=1',
                data: {
                    question_no: question_select
                },
                success: function(response) {
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