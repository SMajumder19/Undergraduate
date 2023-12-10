<?php
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$gender = $_POST['gender'];
	$department = $_POST['department'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$number = $_POST['number'];

	// Database connection
	$conn = new mysqli('localhost','root','','test');
	if($conn->connect_error){
		echo "Process Failed!";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into sign_up_employee(firstName, lastName, gender, department, email, password, number) values(?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssssi", $firstName, $lastName, $gender, $department, $email, $password, $number);
		$execval = $stmt->execute();
		echo "You have successfully signed up! Redirect to the login page by clicking below!";
		echo "<a href='http://localhost/Test/employee_login.html' style='color: red;'> <u>Click Here to redirect to the Login page</u> </a>";
		$stmt->close();
		$conn->close();
	}
?>