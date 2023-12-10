<?php
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'online_book_store';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}


// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, phone, card FROM orders WHERE fullname = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['phone']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo 'Same receiver exists, please choose another!';
	} 

	else {
		// Username doesnt exists, insert new account
		if ($stmt = $con->prepare('INSERT INTO orders (fullname, address, phone, card, price, books, takenby) VALUES (?, ?, ?, ?, ?, ?, ?)')) {
			// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
			$phone = $_POST['phone'];
			$stmt->bind_param('sssssss', $_POST['fullname'], $_POST['address'], $phone, $_POST['card'], $_POST['price'], $_POST['books'], $_POST['takenby']);
			$stmt->execute();
			echo 'You have successfully placed an order!';
		} 

		else {
			// Something is wrong with the sql statement, check to make sure customer_signed table exists with all 3 fields.
			echo 'Could not prepare statement!';
		}
	}
	$stmt->close();
} 
else {
	// Something is wrong with the sql statement, check to make sure customer_signed table exists with all 3 fields.
	echo 'Could not prepare statement!';
}
$con->close();
?>