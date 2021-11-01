<?php
session_start();
$servername = "xxx";
$username = "xxx";
$password = "xxx";
$dbname = "xxx";

$mysqli = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($mysqli->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
$enteredcode= $_POST["verificationcode"];
$code=$_SESSION['code'];
$email = $_SESSION['email'];




if ($code == $enteredcode){
    $sql = "UPDATE members SET emailactivated='1' WHERE email='$email'";
    if ($result = $mysqli->query($sql)){
        $_SESSION['signedin'] = TRUE;
        header("Location: success.php");
        exit();
    }
    else{
        echo "Error updating record: " . $conn->error;
    }
    
    
}
else{
    echo "Error";
}
?>