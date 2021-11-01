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
$description = $_POST["description"];
$vegetarian = $_POST["vegetarian"];
$type = $_POST["type"];
$date = date("Y-m-d");
$lactose = intval($_POST["lactose"]);
$eggs = intval($_POST['eggs']);
$soy = intval($_POST["soy"]);


$sql = "INSERT INTO lunch (description, vegetarian, type, lactose, eggs, soy, date) VALUES ('$description', '$vegetarian', '$type', $lactose, $eggs, $soy, '$date')";
$result = $mysqli->query($sql);
if ($result){
    
    header("Location: lunch.php");

} else{
    echo "Error:";
    echo $mysqli->error;
}


?>