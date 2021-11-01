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
$date = date("Y-m-d"); 
$email = $_POST["email"];
$password = $_POST["password"];
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
 
// Attempt select query execution

$stmt = $mysqli->prepare("SELECT * FROM members WHERE email=?");
$stmt -> bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result){
    if($result->num_rows > 0){
        $row = $result -> fetch_array(MYSQLI_ASSOC);
        $emailactivated =$row["emailactivated"];
        $hash= $row["password"];
        if (password_verify($password, $hash)){
            if ($emailactivated == '1'){
            $_SESSION["email"] = $email;
        $_SESSION["id"] = $row["id"];
        $_SESSION['name'] = $row["name"];
        $_SESSION["loggedin"] = TRUE;
        $_SESSION["usertype"] = $row["accounttype"];
        $sql = "UPDATE members SET lastlogin='$date'";
        $result = $mysqli->query($sql);
        if ($_SESSION["usertype"] == 'admin'){
            header("Location: lunch.php");
        } else{
            header("Location: home.php");
        }
        
            }
            else{
                header("Location: login.php");
            }
        }
        else{
        header("Location: login.php");
        }
        // Free result set
        $result->free();
    } else{
        header("Location: login.php");
    }
} else{
    echo "ERROR: Could not execute $sql. " . $mysqli->error;
}
 
// Close connection
$mysqli->close();
?>