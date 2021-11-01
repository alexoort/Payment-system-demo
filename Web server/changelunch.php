<?php
session_start();
$email = $_POST["studentEmail"];
$servername = "xxx";
$username = "xxx";
$password = "xxx";
$dbname = "xxxx";

$mysqli = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($mysqli->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

 
if ($_POST["schoolLunch"]){
    $sql = "UPDATE accounts SET `schoolLunch` = 'Yes' WHERE `email`= '$email'";
    $result = $mysqli -> query($sql);
    if ($result){
        header("Location: studentlunch.php");
    } else{
        echo "Error";
    }
} else {
    $sql = "UPDATE accounts SET `schoolLunch` = 'No' WHERE `email`= '$email'";
    $result = $mysqli -> query($sql);
    echo $mysqli->error;
    if ($result){
        header("Location: studentlunch.php");
    } else{
        echo "Error";
    }
}