<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <h1 class="text-center">
                    Register Form
                </h1>
                <form method="post">
                    <input type="text" class="form-control mb-2" placeholder="Enter Your username" name="username">
                    <input type="email" class="form-control mb-2" placeholder="Enter Your Email" name="email">
                    <input type="password" class="form-control mb-2" placeholder="Enter your password" name="pass">
                    <input type="password" class="form-control mb-2" placeholder="Enter your Confirm Password" name="con_pass">
                    <button class="btn btn-warning w-100" name="btn_register">Login</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>


<?php
include('db.php');
require('PHPMailer/src/PHPMailer.php');
require('PHPMailer/src/SMTP.php');
require('PHPMailer/src/Exception.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
function verifyEmail($name , $email , $verify_token){
    $mail = new PHPMailer(true);

      //Server settings
      $mail->SMTPDebug = 0;                      
      $mail->isSMTP();                                            
      $mail->Host       = 'smtp.gmail.com';                    
      $mail->SMTPAuth   = true;                                  
      $mail->Username   = 'noorunnisa560@gmail.com';                    
      $mail->Password   = 'dypv icqa ocnn jfoi';                              
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
      $mail->Port       = 465;  


    $mail->setFrom( 'noorunnisa560@gmail.com' , 'Connect Nisa');
    $mail->addAddress($email, $name);    
    $mail->addReplyTo('noorunnisa560@gmail.com' , 'Connect Nisa');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Verify Your Account';
    $mail->Body    = '<center>Name:'.$name.'<br>Email: '.$email.'<br><a style="background:black;font-size:20px; color:#fff;" href="http://localhost:81/php_code/login_auth/verify_email.php?verify_token='.$verify_token.'">Verify Account</a></center>';

    if($mail->send()){
        echo "<script>alert('User has been registered Now Login Your Account and Verify your email address')</script>";
    }
}

if(isset($_POST['btn_register'])){
    $name = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $confirm_password = $_POST['con_pass'];
    $verify_token =  md5(rand());


    if($pass != $confirm_password){
        echo "Password and confirm password not match";
        exit();
    }

    $query = "SELECT * from users where email = '$email'";
    $queryRun = mysqli_query($con , $query);
    
    if(mysqli_num_rows($queryRun) > 0){
        echo "<script>alert('Email address already registered')</script>";
    }
    else{
        $query = "INSERT into users (name , email , password , verify_token) VALUES ('$name', '$email' , '".md5($pass)."' , '$verify_token')";
        $queryRun = mysqli_query($con , $query); 
        
        verifyEmail($name,$email,$verify_token);
    }
}


// $number = "noor123456";
// echo md5($number);
// echo "<br>";
// echo sha1($number);



?>