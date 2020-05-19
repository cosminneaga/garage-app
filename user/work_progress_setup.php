<?php
if(isset($_GET['email'])){
    $compName = $_GET['compName'];
    $compEmail = $_GET['compEmail'];
    $name = $_GET['name'];
    $email = $_GET['email'];

    $mailContent = '<h1>We have started to work on your car.</h1>
       <p>We will let you know when is ready to collect.</p>
        ';

    if(isset($_POST['submit'])){
        $password = $_POST['password'];

        require_once('../php/phpmailer/PHPMailerAutoload.php');

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = $compEmail;
        $mail->Password = $password;

        $mail->setFrom($compEmail);
        $mail->addAddress($email);

        
        $mail->isHTML(true);
        $mail->Subject = $compName;
        $mail->Body = $mailContent;
        $mail->AltBody = 'We have started to work on your car';

        $mail->send();

        if(!$mail->send()) {
            echo "<script>alert('Message could not be sent.\\nMailer Error: ".$mail->ErrorInfo."')</script>";
        } else {
            echo "<script>alert('Your message has been sent')</script>";
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="../style/bootstrap.min.css">
    </head>

    <body class="bg-dark text-light">

    <div class="container d-flex flex-wrap align-content-center" id="container">
        <div class="container text-center">
            <blockquote class="blockquote">
                <p class="mb-0"><b>From:</b> <i><?php echo $compEmail ?></i></p>
            </blockquote>
            <blockquote class="blockquote">
                <p class="mb-0"> <b>To:</b> <i><?php echo $email ?></i></p>
            </blockquote>
            <blockquote class="blockquote">
                <p class="mb-0"><b>Your password will not be stored in our database system.</b></p>
            </blockquote>
            <blockquote class="blockquote">
                <p class="mb-0"><b>It will be used to access you E-mail account in order to send this message to your customer.</b></p>
            </blockquote>
            <form method="POST">
            <input type="password" name="password" placeholder="Your E-Mail password" class="form-control my-2">
            <blockquote class="blockquote">
                <p class="mb-0">
                    <div class="container border border-light">
                        <p>Subject: <?php echo $compName ?></p>
                        <p><b>E-Mail content:</b> <?php echo $mailContent ?></p>
                    </div>
                </p>
            </blockquote>
            <blockquote class="blockquote">
                
                <p class="mb-0">Send a message to <i><?php echo $name ?></i> to let them know that you have start working.</p>
            </blockquote>
            
            
            <button type="submit" name="submit" class="btn btn-success">Send Progress</button>
            </form>
        </div>
    </div>




<script src="../app/jquery-3.4.1.min.js"></script>
<script src="../app/bootstrap.min.js"></script>
<script src="../app/app.js?2"></script>
<script>
    document.getElementById('container').style.height = window.innerHeight+'px';
</script>
</body>

</html>
<?php
}
?>