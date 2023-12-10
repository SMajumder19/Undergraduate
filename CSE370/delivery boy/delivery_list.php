<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

echo "You can redirect to the dashboard page by clicking below!";
    echo "<br><a href='http://localhost/Test/delivery_boy_dashboard.html' style='color: red;'> <u>Click Here to redirect to the dashboard page</u> </a> <br> <br> <br>";

$sql = "SELECT * FROM checkout_cart_order";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Location: " . $row["location"]. " - Number: " . $row["number"]. "<br>";
  }
} else {
  echo "No orders yet";
}
$conn->close();
?>