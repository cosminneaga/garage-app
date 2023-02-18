<?php
require('../../php/user/auth.php');
define('functions', TRUE);
require('../../php/user/functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Statistics</title>
    <link rel="stylesheet" href="../../style/bootstrap.min.css">
</head>

<body class="bg-dark">
    <div class="container-fluid p-5" id="container">
        <div class="row">

            <div class="col-lg-6">
                <h3 class="text-light text-center">Sales for
                    <?php echo date("Y"); ?>
                </h3>
                <div class="container p-3 bg-light rounded-lg">
                    <canvas id="yearly-sales"></canvas>
                </div>

            </div>

            <div class="col-lg-3">

                <div class="container p-3 rounded-lg my-3 bg-dark text-white">
                    <h3>Sales</h3>
                    <div class="container border border-light p-3">
                        <p><b>Today's total: </b> <i id="today-total">0</i>&nbsp;£</p>
                        <p><b>Yesterday's total: </b><i id="yes-total">0</i>&nbsp;£</p>
                        <p><b>This month: </b><i id="this-month">0</i>&nbsp;£</p>
                        <p><b>Last month: </b><i id="last-month">0</i>&nbsp;£</p>
                    </div>
                </div>

            </div>

            <div class="col-lg-3">
                <div class="container bg-dark text-white p-3 rounded-lg my-3">
                    <h3>Profit vs Expenses</h3>
                    <div class="container border border-light p-3">
                        <p><i>This month</i></p>
                        <p><b>Total Profit: </b><i id="profit-this-month">0</i>&nbsp;£</p>
                        <p><b>Expenses: </b><i id="expenses-this-month">0</i>&nbsp;£</p>
                        <p><b>Profit before VAT: </b><i id="profit-bt">0</i>&nbsp;£</p>
                    </div>
                </div>
                <div class="container p-3 bg-white rounded-lg">
                    <h3>Total this year: <i id="total-year-pie"></i>&nbsp;£</h3>
                    <canvas id="profitChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="../../app/jquery-3.4.1.min.js"></script>
    <script src="../../app/bootstrap.min.js"></script>
    <script src="../../app/app.js?2"></script>
    <script src="../../app/chart.min.js"></script>

    <script>
        window.onload = function () {
            var today_total = document.getElementById('today-total');
            var yes_total = document.getElementById('yes-total');
            var this_month_total = document.getElementById('this-month');
            var last_month_total = document.getElementById('last-month');
            var profit_this_month = document.getElementById('profit-this-month');
            var expenses_this_month = document.getElementById('expenses-this-month');
            var profit_bt = document.getElementById('profit-bt');
            var total_year_pie = document.getElementById('total-year-pie');

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

            // TODAY
            var td = new XMLHttpRequest();
            td.open("GET", "../../php/user/graphData.php?today-inv=<?php echo date('Y-m-d%') ?>");
            td.send();
            td.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let data = JSON.parse(this.responseText);
                    let toSkip = [];
                    const final = data.reduce((total, item) => {
                        if (!toSkip.includes(item.id)) {
                            toSkip.push(item.id);
                            total += parseFloat(item.grand_total);
                        }
                        return total;
                    }, 0);
                    today_total.innerHTML = final;

                }
            };

            // YESTERDAY
            var yes = new XMLHttpRequest();
            yes.open("GET", "../../php/user/graphData.php?yesterday=<?php echo date('Y-m-d%', strtotime(" - 1 Days ")) ?>");
            yes.send();
            yes.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let data = JSON.parse(this.responseText);
                    // console.log(data);
                    let toSkip = [];
                    const final = data.reduce((total, item) => {
                        if (!toSkip.includes(item.id)) {
                            toSkip.push(item.id);
                            total += parseFloat(item.grand_total);
                        }
                        return total;
                    }, 0);
                    yes_total.innerHTML = final;
                }
            };

            // THIS MONTH
            var tmt = new XMLHttpRequest();
            tmt.open("GET", "../../php/user/graphData.php?this-month=<?php echo date('Y-m%') ?>");
            tmt.send();
            tmt.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let data = JSON.parse(this.responseText);

                    // find total from grand_total
                    let toSkip = [];
                    const final = data.reduce((total, item) => {
                        if (!toSkip.includes(item.id)) {
                            toSkip.push(item.id);
                            total += parseFloat(item.grand_total);
                        }
                        return total;
                    }, 0);
                    this_month_total.innerHTML = final.toFixed(2);

                    // find expenses from items item_price
                    var arr = [];
                    data.forEach(el => {
                        arr.push(el.item_price);
                    });
                    expenses_this_month.innerHTML = sum(arr);

                    // find total from sub_total
                    let skip = [];
                    const profit = data.reduce((total, item) => {
                        if (!skip.includes(item.id)) {
                            skip.push(item.id);
                            total += parseFloat(item.sub_total);
                        }
                        return total;
                    }, 0);
                    profit_this_month.innerHTML = (final - sum(arr)).toFixed(2);
                    profit_bt.innerHTML = (profit - sum(arr)).toFixed(2);

                }
            };

            // LAST MONTH
            var lm = new XMLHttpRequest();
            lm.open("GET", "../../php/user/graphData.php?last-month=<?php echo date('Y-m%', strtotime('-1 Month')) ?>");
            lm.send();
            lm.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let data = JSON.parse(this.responseText);
                    let toSkip = [];
                    const final = data.reduce((total, item) => {
                        if (!toSkip.includes(item.id)) {
                            toSkip.push(item.id);
                            total += parseFloat(item.grand_total);
                        }
                        return total;
                    }, 0);
                    last_month_total.innerHTML = final;

                    // data.forEach(el => {
                    //     console.log(el)
                    // })
                }
            };

            // THIS YEAR
            var year = new XMLHttpRequest();
            year.open("GET", "../../php/user/graphData.php?yearly=<?php echo date('Y%') ?>");
            year.send();
            year.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let data = JSON.parse(this.responseText);


                    // find total from item_price - expenses
                    var arr = [];
                    data.forEach(el => {
                        arr.push(el.item_price)
                    });

                    // find total from sub_total
                    let skip = [];
                    const sub = data.reduce((total, item) => {
                        if (!skip.includes(item.id)) {
                            skip.push(item.id);
                            total += parseFloat(item.sub_total);
                        }
                        return total;
                    }, 0);

                    // find total from grand_total
                    let toSkip = [];
                    const final = data.reduce((total, item) => {
                        if (!toSkip.includes(item.id)) {
                            toSkip.push(item.id);
                            total += parseFloat(item.grand_total);
                        }
                        return total;
                    }, 0);
                    total_year_pie.innerHTML = final.toFixed(2);

                    var expenses = sum(arr);
                    var profit = sub - expenses;
                    var taxes = final - sub;
                    var dataYearly = [profit, expenses, taxes];
                    var ctxProfitChart = document.getElementById('profitChart').getContext('2d');
                    var profitChart = new Chart(ctxProfitChart, {
                        type: 'pie',
                        data: {
                            labels: ['Profit', 'Expenses', 'VAT'],
                            datasets: [{
                                data: dataYearly,
                                backgroundColor: ['blue', 'red', 'yellow'],
                                borderColor: 'white',
                            }]
                        },
                        options: {}
                    });

                    // find totals on each month and return array with totals of each one of them, identified by id to remove duplicate
                    function sortData() {
                        var invID = [];
                        var sales = [];
                        var expenses = [];

                        var jan = [];
                        var feb = [];
                        var mar = [];
                        var apr = [];
                        var may = [];
                        var jun = [];
                        var jul = [];
                        var aug = [];
                        var sep = [];
                        var oct = [];
                        var nov = [];
                        var dec = [];

                        var expjan = [];
                        var expfeb = [];
                        var expmar = [];
                        var expapr = [];
                        var expmay = [];
                        var expjun = [];
                        var expjul = [];
                        var expaug = [];
                        var expsep = [];
                        var expoct = [];
                        var expnov = [];
                        var expdec = [];
                        data.forEach(bit => {

                            let month = bit.invoice_date.slice(5, 7);
                            // append totals by month distinct on id to avoid duplicates
                            if (!invID.includes(bit.id)) {

                                invID.push(bit.id);
                                if (month === '01') {
                                    jan.push(parseFloat(bit.grand_total));
                                }
                                if (month === '02') {
                                    feb.push(parseFloat(bit.grand_total));
                                }
                                if (month === '03') {
                                    mar.push(parseFloat(bit.grand_total));
                                }
                                if (month === '04') {
                                    apr.push(parseFloat(bit.grand_total));
                                }
                                if (month === '05') {
                                    may.push(parseFloat(bit.grand_total));
                                }
                                if (month === '06') {
                                    jun.push(parseFloat(bit.grand_total));
                                }
                                if (month === '07') {
                                    jul.push(parseFloat(bit.grand_total));
                                }
                                if (month === '08') {
                                    aug.push(parseFloat(bit.grand_total));
                                }
                                if (month === '09') {
                                    sep.push(parseFloat(bit.grand_total));
                                }
                                if (month === '10') {
                                    oct.push(parseFloat(bit.grand_total));
                                }
                                if (month === '11') {
                                    nov.push(parseFloat(bit.grand_total));
                                }
                                if (month === '12') {
                                    dec.push(parseFloat(bit.grand_total));
                                }
                            }

                            // append expenses by month
                            if (month === '01') {
                                expjan.push(parseFloat(bit.item_price));
                            }
                            if (month === '02') {
                                expfeb.push(parseFloat(bit.item_price));
                            }
                            if (month === '03') {
                                expmar.push(parseFloat(bit.item_price));
                            }
                            if (month === '04') {
                                expapr.push(parseFloat(bit.item_price));
                            }
                            if (month === '05') {
                                expmay.push(parseFloat(bit.item_price));
                            }
                            if (month === '06') {
                                expjun.push(parseFloat(bit.item_price));
                            }
                            if (month === '07') {
                                expjul.push(parseFloat(bit.item_price));
                            }
                            if (month === '08') {
                                expaug.push(parseFloat(bit.item_price));
                            }
                            if (month === '09') {
                                expsep.push(parseFloat(bit.item_price));
                            }
                            if (month === '10') {
                                expoct.push(parseFloat(bit.item_price));
                            }
                            if (month === '11') {
                                expnov.push(parseFloat(bit.item_price));
                            }
                            if (month === '12') {
                                expdec.push(parseFloat(bit.item_price));
                            }

                        });
                        sales.push(sum(jan));
                        sales.push(sum(feb));
                        sales.push(sum(mar));
                        sales.push(sum(apr));
                        sales.push(sum(may));
                        sales.push(sum(jun));
                        sales.push(sum(jul));
                        sales.push(sum(aug));
                        sales.push(sum(sep));
                        sales.push(sum(oct));
                        sales.push(sum(nov));
                        sales.push(sum(dec));

                        expenses.push(sum(expjan));
                        expenses.push(sum(expfeb));
                        expenses.push(sum(expmar));
                        expenses.push(sum(expapr));
                        expenses.push(sum(expmay));
                        expenses.push(sum(expjun));
                        expenses.push(sum(expjul));
                        expenses.push(sum(expaug));
                        expenses.push(sum(expsep));
                        expenses.push(sum(expoct));
                        expenses.push(sum(expnov));
                        expenses.push(sum(expdec));

                        total = [sales, expenses];


                        return total;
                    };

                    var barChartData = sortData();

                    var ctxLineChart = document.getElementById('yearly-sales');
                    var yearLineChart = new Chart(ctxLineChart, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            datasets: [{
                                label: 'Sales',
                                backgroundColor: 'rgba(119, 52, 82, 0.2)',
                                borderColor: '#0C0D5C',
                                lineTension: 0,
                                data: barChartData[0]
                            }, {
                                label: 'Expenses',
                                backgroundColor: 'rgba(108, 8, 14, 0.3)',
                                borderColor: '#6c080e',
                                lineTension: 0,
                                data: barChartData[1]
                            }]
                        },
                        options: {
                            elements: {
                                point: {
                                    radius: 6
                                }
                            }
                        }
                    });
                }
            };

        }
    </script>
</body>

</html>