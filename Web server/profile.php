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
$usertype = $_SESSION["usertype"]; 
$email = $_SESSION["email"];

// Check connection


if ($_SESSION['loggedin'] == FALSE){
    header("Location: login.php");
    exit();
}
 
// Attempt select query execution

$sql = "SELECT  * FROM members WHERE email='$email'";
if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
        $row = $result -> fetch_array(MYSQLI_ASSOC);
        $accountType= $row["accounttype"];
        $name = $row["name"];
        $gender = $row["gender"];
        $schoolLunch = $row["schoolLunch"];
        // Free result set
        $result->free();
    } else{
        echo "Error";
    }
} else{
    echo "ERROR: Could not execute $sql. " . $mysqli->error;
}
 
// Close connection
$mysqli->close();
?>
?>
<html>
    <head>
        <title>Profile</title>
        <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="fadebackground.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="home.css">
    </head>
    <body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-card" id="myNavbar">
    <a href="/" class="w3-bar-item w3-button w3-wide"><img src="cashfreecanteen.png" id="logo" width="120px"></a>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-small" id="text">
        <?php 
        if ($usertype == 'user'){
            echo "<a href='home.php' class='w3-bar-item w3-button'><i class='fa fa-home'></i> HOME</a><a href='myaccount.php' class='w3-bar-item w3-button'><i class='fa fa-dollar'></i> ACCOUNT</a>";
        } else{
            echo "<a href='analytics.php' class='w3-bar-item w3-button'><i class='fa fa-bar-chart'></i> ANALYTICS</a><a href='lunch.php' class='w3-bar-item w3-button'><i class='fa fa-cutlery'></i> LUNCH</a>";
        }
        ?>
        
      
      <a href="profile.php" class="w3-bar-item w3-button current"><i class="fa fa-user"></i> PROFILE</a>
      <a href="logout.php" class="w3-bar-item w3-button"><i class='fa fa-power-off'></i> LOG OUT</a>
    </div>
    <!-- Hide right-floated links on small screens and replace them with a menu icon -->

    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
</div>

<!-- Sidebar on small screens when clicking the menu icon -->
<nav class="w3-sidebar w3-bar-block w3-black w3-card w3-animate-left w3-hide-medium w3-hide-large" style="display:none" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Close ×</a>
  <a href="myaccount.php" onclick="w3_close()" class="w3-bar-item w3-button">HOME</a>
  <a href="myaccount.php" onclick="w3_close()" class="w3-bar-item w3-button">ACCOUNT</a>
  <a href="#work" onclick="w3_close()" class="w3-bar-item w3-button current">PROFILE</a>
  <a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button">LOG OUT</a>
</nav>
<div class='content'>
<br>
<br>
<br>
<br>
<h1 class='heading' style="font-size: 50px;"><center><?php echo $name?>'s Profile</center></h1>
<div class='container'>
    <center>
    <div class='col' id="profile">
        <br>
        
        <?php 
        if ($gender == "female"){
        echo "<img class='avatar' src='https://www.utsa.edu/financialaffairs/budget/imgs/female_avatar.png'>";}
        else if ($gender == "male"){
            echo "<img class='avatar' src='https://www.w3schools.com/howto/img_avatar.png'>";
        }
        else{
            echo "<img class='avatar' src='https://cdn.onlinewebfonts.com/svg/img_568656.png'>";
        }
        
        ?>
        <br><br>
        <h5>Name: <?php echo $name?></h5>
        <br>
        <h5>Email: <?php echo $email?></h5>
        <br>
        <h5>Account type: <?php echo ucwords($_SESSION["usertype"]);?></h5>
        <br>
        <h5>School lunch: <?php
        echo $schoolLunch
        ?></h5>
        <br>
        <button class='btn btn-info'>
        Change password
    </button>
    </div>
    
    </center>
</div>
<script>
    var mySidebar = document.getElementById("mySidebar");

function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
  } else {
    mySidebar.style.display = 'block';
  }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}
</script>


