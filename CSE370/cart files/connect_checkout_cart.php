<?php
	$bank = $_POST['bank'];
	$location = $_POST['location'];
	$email = $_POST['email'];
	$number = $_POST['number'];

	// Database connection
	$conn = new mysqli('localhost','root','','test');
	if($conn->connect_error){
		echo "Process Failed!";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into checkout_cart_order(bank, location, email, number) values(?, ?, ?, ?)");
		$stmt->bind_param("sssi", $bank, $location, $email, $number);
		$execval = $stmt->execute();
		echo "You have successfully ordered! Redirect to the dashboard page by clicking below!";
		echo "<a href='http://localhost/test/customer_dashboard.html' style='color: red;'> <u>Click Here to redirect to the Dashboard page</u> </a>";
		$stmt->close();
		$conn->close();
	}
?>