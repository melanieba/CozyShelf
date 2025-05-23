<?php
$servername = "cssql.seattleu.edu";
$username = "sr_group7";
$password = "fYuxf+6dZhaAzLao";
$dbname = "sr_group7";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

echo "Connection successfully";
?>

<?php
$sql = "SELECT * FROM test_table";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo "ID: " . $row["id"] . " - Message: " . $row["message"] . "<br>";
}
?>

<?php
mysqli_close($conn);
?>