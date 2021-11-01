<?php
$servername = "xxx";
$username = "xxx";
$password = "xxx";
$dbname = "xxx";

$mysqli = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($mysqli->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id = $_POST["id"];
$sql = "SELECT email FROM accounts WHERE id=$id";
$result = $mysqli->query($sql);
if ($row=$result->fetch_array()){
    $email = $row["email"];
}
echo "Hello";
$date = date("Y-m-d H:i:s");

$sql="INSERT INTO teacherlunch (email, date) VALUES ('$email', '$date')";
$result = $mysqli->query($sql);
if ($result){
    echo "Success";
} else{
    echo $mysqli->error;
}
?>
