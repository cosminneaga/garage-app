<?php 
if(isset($_GET['session']) && !empty($_GET['session']) && isset($_GET['session_id']) && !empty($_GET['session_id']) && isset($_GET['ssl']) && !empty($_GET['ssl'])){
    $id = $_GET['session']; //client id
    $owned_by = $_GET['session_id']; //owned by
    $session_id = $_GET['ssl']; //session_id
    define('functions', TRUE);
    require '../php/user/functions.php';
    $key = 'abcdefghijklmnoprstuvx';
    $method = 'idea';
    $iv = 'stringis';
    $own = $owned_by;
    $extract = new extract();
    $data = $extract->company($conn, $own);
    $name = $data['name'];
    
    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey | <?php echo $name ?></title>
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
                        <h4 id="paragraph" class="font-italic">
                            Hello there, in this survey we will analyse your experience with <?php echo $name ?>, the survey consists in 5 questions only, and each question is classified on 0 to 10 scale answers, so it will take only a minute to complete it.
                        </h4>
                        <p id="sub-paragraph"></p>
                    </div>
                    <div id="answer" class="my-5"></div>
                    <button id="button" class="btn btn-success" onclick="clientOne()">Click to begin</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../app/jquery-3.4.1.min.js?1"></script>
    <!-- <script src="../app/survey.js?3"></script> -->
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
            if (x === 'cl1') {
                clientOne();
            }
            if (x === 'cl2') {
                clientTwo();
            }
            if (x === 'cl3') {
                clientThree();
            }
            if (x === 'cl4') {
                clientFour();
            }
            if (x === 'cl5') {
                clientFive();
            }
            if (x === 'clFinish') {
                clientFinish();
            }
            if (x === 'clEnd') {
                clientEnd();
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

        /* ##############################       CLIENT PAGE FUNCTIONALITY      ######################################*/

        function clientOne() {
            localStorage.setItem("pageNo", "cl1");
            paragraph.innerHTML = '1. What is your overall impression about the speed of the repair process the <?php echo $name ?> has done on your vehicle repair?';
            sub_paragraph.innerHTML = '(0 means very slow, 10 means very fast)';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            q = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            createButtonListInline(button, 'cl1', answer_rubric, q);
            button.innerHTML = 'Next';
            button.onclick = clientTwo;
        }

        function clientTwo() {
            localStorage.setItem("pageNo", "cl2");
            paragraph.innerHTML = '2. How welcomed did you feel when you get in contact with <?php echo $name ?> and its members?';
            sub_paragraph.innerHTML = '(0 means very unfriendly, 10 means very friendly)';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            q = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            createButtonListInline(button, 'cl2', answer_rubric, q);
            button.innerHTML = 'Next';
            button.onclick = clientThree;
        }

        function clientThree() {
            localStorage.setItem("pageNo", "cl3");
            paragraph.innerHTML = '3. What is your overall impression of the Quality of Service, <?php echo $name ?> had provide you with?';
            sub_paragraph.innerHTML = '(0 means very bad impression, 10 means very best impression)';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            q = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            createButtonListInline(button, 'cl3', answer_rubric, q);
            button.innerHTML = 'Next';
            button.onclick = clientFour;
        }

        function clientFour() {
            localStorage.setItem("pageNo", "cl4");
            paragraph.innerHTML = '4. How likely are you considering making contact with <?php echo $name ?> in case something similar happens in future?';
            sub_paragraph.innerHTML = '(0 means I will find another workshop next time, 10 means I will definitely go back next time)';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            q = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            createButtonListInline(button, 'cl4', answer_rubric, q);
            button.innerHTML = 'Next';
            button.onclick = clientFive;
        }

        function clientFive() {
            localStorage.setItem("pageNo", "cl5");
            paragraph.innerHTML = '5. How likely would you be to recommend <?php echo $name ?> to your relatives and friends?';
            sub_paragraph.innerHTML = '(0 means I won’t recommend this company to anyone, 10 means I will happily recommend it to my relatives and friends)';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            q = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            createButtonListInline(button, 'cl5', answer_rubric, q);
            button.innerHTML = 'Next';
            button.onclick = clientFinish;
        }

        function clientFinish() {
            localStorage.setItem("pageNo", "clFinish");
            paragraph.innerHTML = 'You have completed this survey!';
            sub_paragraph.innerHTML = 'Click the button below to send all your answers to be evaluated.';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            button.innerHTML = 'Send the answers for evaluation.';
            button.onclick = function() {
                var a1 = localStorage.getItem("q:cl1");
                var a2 = localStorage.getItem("q:cl2");
                var a3 = localStorage.getItem("q:cl3");
                var a4 = localStorage.getItem("q:cl4");
                var a5 = localStorage.getItem("q:cl5");
                var storedData = {
                    1: a1,
                    2: a2,
                    3: a3,
                    4: a4,
                    5: a5
                }
                localStorage.clear();
                // DATA TO SEND TO DATABASE CLIENT SIDE
                var dataStr = JSON.stringify(storedData);
                $.ajax({
                    url: '../php/user/insertSurveyData.php?client=1&session=<?php echo $id?>&session_id=<?php echo $owned_by?>&ssl=<?php echo $session_id?>',
                    type: 'POST',
                    data: {
                        data: dataStr
                    }
                });

                // DATA TO SEND TO DATABASE

                clientEnd();
            }
        }

        function clientEnd() {
            localStorage.setItem("pageNo", "clEnd");
            paragraph.innerHTML = 'Your answers have been sent successfully!';
            sub_paragraph.innerHTML = 'Thank you for the time to answer this survey.';
            // remove method must check
            if (answer_rubric.hasChildNodes()) {
                var answers = document.getElementById('answers');
                answer_rubric.removeChild(answers);
            }
            button.remove();
        }

        /* ##############################       CLIENT PAGE FUNCTIONALITY      ######################################*/

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