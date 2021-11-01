<?php
session_start();
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$servername = "xxx";
$username = "xxx";
$password = "xxx";
$dbname = "xxx";

$mysqli = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($mysqli->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name = $_POST["name"];
$gender = $_POST["gender"];
$email = $_POST["email"];
$password = $_POST["password"];
$verifypassword = $_POST["secondpassword"];
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

if (strpos($email, "msf.education") === false){
    
    header('Location: /signup.html', true, 301);
    exit();
}

if ($password === $verifypassword){
    $hash= password_hash($password, PASSWORD_DEFAULT);
}
else{
    header("Location: signup.html");
    exit();
}

if ($email == "cade@msf.education" or $email == "foerster@msf.education" or $email=="ennenbach@msf.education"){
    $accounttype = 'admin';
} else{
    if ($email == "alexander.oort-alonso@msf.education"){
        $accounttype = "omniuser";
    } else{
       $accounttype = "user"; 
    }
    
}

// Attempt select query execution
$sql = "INSERT INTO members (`name`, `gender`, `email`, `password`, `accounttype`) VALUES ('$name', '$gender', '$email', '$hash', '$accounttype')";
if($mysqli->query($sql) === TRUE){
    $_SESSION["name"] = $name;
    $_SESSION["email"] = $email;
    header("Location: verifyemail.php");
    
} else{
    echo "ERROR: Could not execute $sql. " . $mysqli->error;
}
 
// Close connection
$mysqli->close();
?>