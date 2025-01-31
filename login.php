<?php
session_start();
?>

<h1><?php echo $_SESSION['status']?></h1>


verify_status == 0

select * from users where email = $email and pass = $pass and verify_status = 1
