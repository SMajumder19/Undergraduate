<?php

include('login_connect_customer.php');
$username = $_POST["user"];
$password = $_POST["pass"];

// to prevent from mysqli injection

$username = stripcslashes($username);
$password = stripcslashes($password);
$username = mysqli_real_escape_string($con , $username);
$password = mysqli_real_escape_string($con , $password);


$sql = "select * from sign_up_customer where email = '$username' and password = '$password'" ;
$result = mysqli_query($con , $sql);
$row = mysqli_fetch_array($result , MYSQLI_ASSOC);
$count = mysqli_num_rows($result);


if($count == 1){  
    echo "Congratualtions! Move to the dashboard page by clicking here!";
    echo "<a href='http://localhost/Test/customer_dashboard.html' style='color: red;'> <u>Click Here to go to the Dashboard page</u> </a>";
}
else{
    echo "Failed ! Try again from the login page by redirecting from here!";  
    echo "<a href='http://localhost/Test/customer_login.html' style='color: red;'> <u>Click Here to go to the login page to try again</u> </a>";
}
?>