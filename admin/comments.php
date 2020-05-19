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
        <title>MY GARAGE APP | COMMENTS</title>
        <link rel="stylesheet" href="../style/bootstrap.min.css">
    </head>

    <body>
        <?php define('navigation',TRUE); require('nav.php'); ?>
        <?php define('modal', TRUE); require('add_user_modal.php'); ?>

        <div class="container-fluid" id="container">

            <?php foreach($comment as $key => $value){ 
                $question_14 = $extract->getCommentByQuestionNo($conn, $value->username, 14);
                $question_10 = $extract->getCommentByQuestionNo($conn, $value->username, 10);
                $question_8 = $extract->getCommentByQuestionNo($conn, $value->username, 8);
                $question_5 = $extract->getCommentByQuestionNo($conn, $value->username, 5);
                $question_4 = $extract->getCommentByQuestionNo($conn, $value->username, 4);
                $question_3 = $extract->getCommentByQuestionNo($conn, $value->username, 3);
                ?>
                    
                    <div class="jumbotron m-3" id="jumbotron">
                        <div class="container-fluid d-flex justify-content-between mb-2" id="title">
                            <div id="name" class="text-center">
                                <h3><?php echo $value->username; ?></h3>
                            </div>
                            <div id="date" class="text-center">
                                <h3><?php echo date("d/M/Y H:i", strtotime($question_10->created_on)) ?></h3>
                            </div>
                            <div id="status" class="text-center">
                                <h3><button class="btn badge badge-warning" onclick="update_status('<?php echo $value->username ?>')"><?php echo $value->status ?></button></h3>
                            </div>
                        </div>
                        <hr>
                        <div class="container-fluid mb-3" id="content">
                            <div class="row">
                                <div class="col-4">
                                    <h4><b>Comments:</b></h4>
                                    <h5 class="text-justify border border-white p-3 rounded-lg shadow"><?php echo $question_14->comment ?></h5>
                                </div>
                                <div class="col-4">
                                    <h4><b>Like most (comment):</b></h4>
                                    <h5 class="text-justify border border-white p-3 rounded-lg shadow"><?php echo $question_4->comment ?></h5>
                                </div>
                                <div class="col-4">
                                    <h4><b>Needs improvement:</b></h4>
                                    <h5 class="text-justify border border-white p-3 rounded-lg shadow"><?php echo $question_5->comment ?></h5>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="container-fluid d-flex justify-content-between" id="footer">
                    

                            <div id="impression" class="text-center">
                                <h4>First Impression</h4>
                                <h4 id="i-answer"><span class="badge badge-success border border-white shadow-lg p-2"><?php echo $question_3->comment ?></span></h4>
                            </div>
                            <div id="need" class="text-center">
                                <h4>Need of service</h4>
                                <h4 id="n-answer"><span class="badge badge-success border border-white shadow-lg p-2"><?php echo $question_8->comment ?></span></h4>
                            </div>
                            <div id="buy" class="text-center">
                                <h4>Would you buy it?</h4>
                                <h4 id="b-answer"><span class="badge badge-success border border-white shadow-lg p-2"><?php echo $question_10->comment ?></span></h4>
                            </div>

                                
                        </div>
                    </div>

                <?php   }?>

        </div>


    
        <script src="../app/jquery-3.4.1.min.js"></script>
        <script src="../app/bootstrap.min.js"></script>
        <script src="../app/app.js"></script>
        <script>
            function update_status(username){
                $.ajax({
                    type: 'POST',
                    url: '../php/admin/update_survey_status.php?update=1',
                    data: {username: username},
                    beforeSend: function(){
                        if(confirm('Do you want to update the status for this query?')){
                            return true;
                        }
                        return false;
                    },
                    success: function(response){
                        window.location.reload();
                    }
                });
            }
        </script>
</body>
    </html>