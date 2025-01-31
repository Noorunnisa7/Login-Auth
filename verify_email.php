<?php
// $token = $_GET['verify_token'];
// echo $token;
include('db.php');
session_start();
if(isset($_GET['verify_token'])){
    $token = $_GET['verify_token'];
    $query = "SELECT * FROM users where verify_token = '$token' limit 1";
    $queryRun = mysqli_query($con , $query);
    // echo mysqli_num_rows($queryRun);
    if(mysqli_num_rows($queryRun)> 0){
        $query = "SELECT verify_status from users where verify_token = '$token' limit 1";
        $queryRun = mysqli_query($con , $query);
        $row = mysqli_fetch_assoc($queryRun);

        if($row['verify_status'] == 0){
            $query = "UPDATE users set verify_status = 1 where verify_token = '$token'";
            $queryRun = mysqli_query($con , $query);

            $_SESSION['status']= "Email id verified Now login your Account";
            header('location:login.php');
        }
        else{
            $_SESSION['status']= "This Email id already verified";
            header('location:login.php');
        }
    }
    else{
        $_SESSION['status']= "Verify token not exists";
        header('location:login.php');
    }
}
else{
    $_SESSION['status']= "Unauthorized";
    header('location:login.php');
}


?>