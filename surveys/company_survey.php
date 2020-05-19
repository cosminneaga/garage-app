<?php
require '../php/user/auth.php';
if(isset($_GET['username']) && isset($_GET['own'])){
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey</title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <style>
        body {
            background-image: url('../pictures/survBG.jpg');
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
    </style>
</head>

<body>

    <div class="container d-flex flex-wrap align-content-center" id="outer-container">
        <div class="container rounded-lg text-light p-5 shadow-lg border border-light" style="background-color: rgba(15, 104, 194, 0.7);">
            <h1 class="text-center">Survey</h1>
            <div class="container border border-light p-5 mt-5" id="content">
                <div id="content-inner">
                    <div class="blockquote text-center">
                        <h4 id="paragraph">Please take a few moments of your time to answer this survey and help us improve our web application.</h4>
                        <p id="sub-paragraph"></p>
                    </div>
                    <div id="answer" class="my-5"></div>
                    <button id="button" class="btn btn-success" onclick="one()">Click to begin</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../app/jquery-3.4.1.min.js"></script>
    <script>
        var outerContainer = document.getElementById('outer-container');
        outerContainer.style.height = window.innerHeight + 'px';
        var content = document.getElementById('content');
        var content_inner = document.getElementById('content-inner');
        var paragraph = document.getElementById('paragraph');
        var sub_paragraph = document.getElementById('sub-paragraph');
        var answer_rubric = document.getElementById('answer');
        var button = document.getElementById('button');

        window.onload = function() {
            var x = localStorage.getItem("pageNo");
            if (x === '1') {
                one();
            }
            if (x === '2') {
                two();
            }
            if (x === '3') {
                three();
            }
            if (x === '4') {
                four();
            }
            if (x === '5') {
                five();
            }
            if (x === '6') {
                six();
            }
            if (x === '7') {
                seven();
            }
            if (x === '8') {
                eight();
            }
            if (x === '9') {
                nine();
            }
            if (x === '10') {
                ten();
            }
            if (x === '11') {
                eleven();
            }
            if (x === '12') {
                twelve();
            }
            if (x === '13') {
                thirteen();
            }
            if(x === '14') {
                fourteen();
            }
            if (x === 'finish') {
                finish();
            }
            if (x === 'end') {
                
            }
        }



        /*  ###################################################################################################################################
            #########################           SURVEYS CODE JAVASCRIPT         ###############################################################
            ###################################################################################################################################
        */

        // SET DATA TO LOCAL STORAGE
        function setAnswersToLocalStorage(answerQ) {
            var answerQ = answerQ.split(".");
            var questionNo = answerQ[0];
            var answer = answerQ[1];
            localStorage.setItem("q:" + questionNo, answer);
        }

        // CREATE LIST USING BUTTONS
        function createButtonList(buttonExt, questionNo, divToAppend, questions, listType = "1") {
            var ol = document.createElement('ol');
            ol.setAttribute('id', 'answers');
            ol.type = listType;
            for (var i = 0; i < questions.length; i++) {
                var li = document.createElement('li');
                var button = document.createElement('button');
                button.setAttribute('class', 'btn btn-outline-light my-1');
                button.value = questionNo + '.' + questions[i];
                button.onclick = function() {
                    var value = this.value;
                    setAnswersToLocalStorage(value);
                    value = value.split(".");
                    buttonExt.innerHTML = 'Continue with: ' + value[1];
                }
                button.innerHTML = questions[i];
                li.appendChild(button);
                ol.appendChild(li);
            }
            divToAppend.appendChild(ol);
        }

        // CREATE LIST INLINE USING BUTTONS
        function createButtonListInline(buttonExt, questionNo, divToAppend, questions) {
            var answers = document.createElement('div');
            answers.setAttribute('id', 'answers');
            for (var i = 0; i < questions.length; i++) {
                if (typeof(questions[i]) == 'number') {
                    questions[i] = questions[i].toString();
                }
                var button = document.createElement('button');
                button.setAttribute('class', 'btn btn-outline-light mx-1');
                button.value = questionNo + '.' + questions[i];
                button.onclick = function() {
                    var value = this.value;
                    setAnswersToLocalStorage(value);
                    value = value.split(".");
                    buttonExt.innerHTML = 'Continue with: ' + value[1];
                }
                button.innerHTML = questions[i];
                answers.appendChild(button);
            }

            divToAppend.appendChild(answers);
        }



        /* ##############################       COMPANY PAGE FUNCTIONALITY      ######################################*/
        function one() {
            localStorage.setItem("pageNo", "1");
            paragraph.innerHTML = '1. Design of the interface?';
            sub_paragraph.innerHTML = '(0 means worst, 5 means best ever)';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }

            q = [1, 2, 3, 4, 5];
            createButtonListInline(button, 1, answer_rubric, q);
            button.innerHTML = 'Next';
            button.onclick = two;
        }

        function two() {
            localStorage.setItem("pageNo", "2");
            paragraph.innerHTML = '2. The range of functionalities.';
            sub_paragraph.innerHTML = '(0 means not enough functionalities, 5 means it is just perfect)';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }

            q = [1, 2, 3, 4, 5];
            createButtonListInline(button, 2, answer_rubric, q);
            button.innerHTML = 'Next';
            button.onclick = three;
        }

        function three() {
            localStorage.setItem("pageNo", "3");
            paragraph.innerHTML = '3. When you first used the software, what was your overall impression of it?';
            sub_paragraph.innerHTML = '';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            var q = ['Very Positive', 'Positive', 'It was alright', 'Negative', 'Really negative'];
            createButtonList(button, 3, answer_rubric, q, 'a');
            button.innerHTML = 'Next';
            button.onclick = four;
        }

        function four() {
            localStorage.setItem("pageNo", "4");
            paragraph.innerHTML = '4. What do you like most about it?';
            sub_paragraph.innerHTML = '';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            var answer = document.createElement('div');
            answer.setAttribute('id', 'answers');
            var textarea = document.createElement('textarea');
            textarea.setAttribute('class', 'form-control');
            textarea.setAttribute('rows', '6');
            answer.appendChild(textarea);
            answer_rubric.appendChild(answer);
            button.innerHTML = 'Next';
            button.onclick = function() {
                setAnswersToLocalStorage("4." + textarea.value);
                five();
            }
        }

        function five() {
            localStorage.setItem("pageNo", "5");
            paragraph.innerHTML = '5. ...and what do you think could still be improved?';
            sub_paragraph.innerHTML = '';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            var answer = document.createElement('div');
            answer.setAttribute('id', 'answers');
            var textarea = document.createElement('textarea');
            textarea.setAttribute('class', 'form-control');
            textarea.setAttribute('rows', '6');
            answer.appendChild(textarea);
            answer_rubric.appendChild(answer);
            button.innerHTML = 'Next';
            button.onclick = function() {
                setAnswersToLocalStorage("5." + textarea.value);
                six();
            }
        }

        function six() {
            localStorage.setItem("pageNo", "6");
            var bold = 'Overall Quality.';
            bold = bold.bold();
            paragraph.innerHTML = '6. ' + bold + ' How would you rate the service?';
            sub_paragraph.innerHTML = '(0 means worst, 5 means best ever)';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            q = [1, 2, 3, 4, 5];
            createButtonListInline(button, 6, answer_rubric, q);
            button.innerHTML = 'Next';
            button.onclick = seven;
        }

        function seven() {
            localStorage.setItem("pageNo", "7");
            paragraph.innerHTML = '7. How innovative our service you think it is?';
            sub_paragraph.innerHTML = '(0 means not innovative at all, 5 means reached max innovation)';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            q = [1, 2, 3, 4, 5];
            createButtonListInline(button, 7, answer_rubric, q);
            button.innerHTML = 'Next';
            button.onclick = eight;
        }

        function eight() {
            localStorage.setItem("pageNo", "8");
            var bold = 'Total Honesty.';
            bold = bold.bold();
            paragraph.innerHTML = '8. ' + bold + ' How much do you need this service?';
            sub_paragraph.innerHTML = '';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            var q = ['Definitely need it', 'Kind of need it', 'Don\'t really need it', 'Definitely don\'t need it'];
            createButtonList(button, 8, answer_rubric, q, 'a');
            button.innerHTML = 'Next';
            button.onclick = nine;
        }

        function nine() {
            localStorage.setItem("pageNo", "9");
            paragraph.innerHTML = '9. How would you rate its value for money?';
            sub_paragraph.innerHTML = '(0 means down the drain, 5 means totally worth it)';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            q = [1, 2, 3, 4, 5];
            createButtonListInline(button, 9, answer_rubric, q);
            button.innerHTML = 'Next';
            button.onclick = ten;
        }

        function ten() {
            localStorage.setItem("pageNo", "10");
            paragraph.innerHTML = '10. If you could buy the service today, would you buy it?';
            sub_paragraph.innerHTML = '';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            var q = ['Absolutely', 'Let me think about it', 'Don\'t think so', 'Wouldn\'t dream of it'];
            createButtonList(button, 10, answer_rubric, q, 'a');
            button.innerHTML = 'Next';
            button.onclick = eleven;
        }

        function eleven() {
            localStorage.setItem("pageNo", "11");
            paragraph.innerHTML = '11. How likely are you to replace your current solution with this service?';
            sub_paragraph.innerHTML = '';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            q = [1, 2, 3, 4, 5];
            createButtonListInline(button, 11, answer_rubric, q);
            button.innerHTML = 'Next';
            button.onclick = twelve;
        }

        function twelve() {
            localStorage.setItem("pageNo", "12");
            paragraph.innerHTML = '12. How likely would you recommend this service to someone you know?';
            sub_paragraph.innerHTML = '';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            q = [1, 2, 3, 4, 5];
            createButtonListInline(button, 12, answer_rubric, q);
            button.innerHTML = 'Next';
            button.onclick = thirteen;
        }

        function thirteen() {
            localStorage.setItem("pageNo", "13");
            paragraph.innerHTML = '13. How satisfied are you with the overall experience of the software?';
            sub_paragraph.innerHTML = '';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            q = [1, 2, 3, 4, 5];
            createButtonListInline(button, 13, answer_rubric, q);
            button.innerHTML = 'Next';
            button.onclick = fourteen;
        }

        function fourteen(){
            localStorage.setItem("pageNo", "14");
            paragraph.innerHTML = '14. Any final thoughts or problems you have encountered while using the software?';
            sub_paragraph.innerHTML = 'Write down any problem or thoughts you might have.';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            var answer = document.createElement('div');
            answer.setAttribute('id', 'answers');
            var textarea = document.createElement('textarea');
            textarea.setAttribute('class', 'form-control');
            textarea.setAttribute('rows', '6');
            answer.appendChild(textarea);
            answer_rubric.appendChild(answer);
            button.innerHTML = 'Next';
            button.onclick = function() {
                setAnswersToLocalStorage("14." + textarea.value);
                finish();
            }
        }

        function finish() {
            localStorage.setItem("pageNo", "finish");
            paragraph.innerHTML = 'You have completed this survey!';
            sub_paragraph.innerHTML = 'Click the button below to send all your answers to the researcher.';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            button.innerHTML = 'Send the answers to researcher';
            button.onclick = function() {
                var a1 = localStorage.getItem("q:1");
                var a2 = localStorage.getItem("q:2");
                var a3 = localStorage.getItem("q:3");
                var a4 = localStorage.getItem("q:4");
                var a5 = localStorage.getItem("q:5");
                var a6 = localStorage.getItem("q:6");
                var a7 = localStorage.getItem("q:7");
                var a8 = localStorage.getItem("q:8");
                var a9 = localStorage.getItem("q:9");
                var a10 = localStorage.getItem("q:10");
                var a11 = localStorage.getItem("q:11");
                var a12 = localStorage.getItem("q:12");
                var a13 = localStorage.getItem("q:13");
                var a14 = localStorage.getItem("q:14");
                var storedData = {
                    1: a1,
                    2: a2,
                    3: a3,
                    4: a4,
                    5: a5,
                    6: a6,
                    7: a7,
                    8: a8,
                    9: a9,
                    10: a10,
                    11: a11,
                    12: a12,
                    13: a13,
                    14: a14
                }
                localStorage.clear();

                // DATA TO SEND TO DATABASE COMPANY SIDE
                var dataStr = JSON.stringify(storedData);
                $.ajax({
                    url: '../php/user/insertSurveyData.php?company=1&username=<?php echo $username_S; ?>&owned_by=<?php echo $ownedBy_S; ?>',
                    type: 'POST',
                    data: {
                        data: dataStr
                    },
                    success: function(response) {
                    }
                });
                // DATA TO SEND TO DATABASE

                end();
            }
        }

        function end() {
            localStorage.setItem("pageNo", "end");
            paragraph.innerHTML = 'Your answers have been sent successfully!';
            sub_paragraph.innerHTML = 'Thank you for the time to answer this survey.';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            button.innerHTML = 'Go back to main panel.';
            button.onclick = function(){
                window.location.href = '../user/cpanel.php';
            }
        }
        /* ##############################       COMPANY PAGE FUNCTIONALITY      ######################################*/



        /*  ###################################################################################################################################
            #########################           SURVEYS CODE JAVASCRIPT         ###############################################################
            ###################################################################################################################################
        */
    </script>
</body>

</html>
<?php
}else{
?>
<!DOCTYPE html>
    <html>
    <head>
        <title>404 Error</title>
        <style>
            body {
                width: 35em;
                margin: 0 auto;
                font-family: Tahoma, Verdana, Arial, sans-serif;
            }
        </style>
    </head>
    <body>
        <br />
        <br />
        <center>
            <h1>Not Found - 404</h1>
            <p>The requested URL was not found on this server.</p>
        </center>
    </body>
    </html>
<?php
}
?>