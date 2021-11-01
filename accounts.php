<?php
$servername = "xxx";
$username = "xxx";
$password = "xxx";
$dbname = "xxx";


$timestamp = date('Y-m-d H:i', strtotime('2 hour'));
$money = $_POST["Money"];
$activityValue = $_POST["change"];
$id = $_POST["id"];
$activityDescription = $_POST["purchase"];
$passcode = $_POST["passcode"];

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$items = array();
// Create connection


$sql = "UPDATE accounts SET `money`=$money, `lastPurchaseCost`=$activityValue, `lastPurchaseItem`='$activityDescription', lastPurchaseDate='$timestamp' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully";
 
} else {
  echo "Error updating record: " . $conn->error;
}

$sql = "SELECT email FROM accounts WHERE id=$id";
if ($result = $conn->query($sql)){
    $row= $result->fetch_array();
    $email = $row["email"];
    echo $email;
}
else{
    echo "Error selecting data: " . $conn->error;
}

$sql = "INSERT INTO purchases (email, description, value, date) VALUES ('$email', '$activityDescription', $activityValue, '$timestamp')";

if ($conn->query($sql) === TRUE){
    echo "Record inserted successfully";
}
else{
    echo "Error";
}

$items= explode(", ", $activityDescription);
for ($j=0; $j<count($items);$j++){
    $item = $items[$j];
    $sql = "INSERT INTO items (product, email) VALUES ('$item', '$email')";
    $result = $conn->query($sql);
    if ($result){
        echo "Success";
    } else{
       echo $conn->error;
    }
}




$conn->close();

?>