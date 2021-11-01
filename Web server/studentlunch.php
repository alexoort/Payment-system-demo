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
$email = $_SESSION["email"];
$today = date("Y-m-d");
$allActivity = array();
// Check connection


if ($_SESSION['loggedin'] == FALSE){
    header("Location: login.php");
    exit();
}

if ($_SESSION["usertype"] == 'user'){
    $_SESSION["error"] = "You do not have access to this information";
    header("Location: home.php");
    exit();
}

$b=0;
$sql = "SELECT * FROM accounts WHERE memberType='student'";
$result = $mysqli -> query($sql);
$members = $result->num_rows;
while ($row = $result->fetch_array()){
    
    $schoolLunch[$b]["email"] = $row["email"];
    $schoolLunch[$b]["schoolLunch"] = $row["schoolLunch"];
    $b++;
}



// Close connection
$mysqli->close();
?>

<html>
    <head>
        <title>Student lunch</title>
        <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="home.css">
<link rel="stylesheet" href="lunch.css">
<link rel="stylesheet" href="studentlunch.css">
    <script src="jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="countUp.min.js" type="text/javascript"></script>

  </head>
    
    <body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-card" id="myNavbar">
    <a href="/" class="w3-bar-item w3-button w3-wide"><img src="cashfreecanteen.png" id="logo" width="120px"></a>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-small" id="text">
        <a href="analytics.php" class="w3-bar-item w3-button"><i class='fa fa-bar-chart'></i> ANALYTICS</a>
      <a href="lunch.php" class="w3-bar-item w3-button"><i class='fa fa-cutlery'></i> LUNCH</a>
      <a href="profile.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i> PROFILE</a>
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
  <a href="analytics.php" onclick="w3_close()" class="w3-bar-item w3-button">ANALYTICS</a>
  <a href="lunch.php" onclick="w3_close()" class="w3-bar-item w3-button">LUNCH</a>
  <a href="profile.php" onclick="w3_close()" class="w3-bar-item w3-button">PROFILE</a>
  <a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button">LOG OUT</a>
</nav>
<br>
<br>
<br>
<br>
<div class="sidenav">
    
  <a href="lunch.php">Menu</a>
  <a href="studentlunch.php">Students</a>
  <a href="teacherlunch.php">Teachers</a>
 
</div>
<div class='maincontent'>
<h1 class='heading' style="font-size: 50px;"><center>Students</center></h1>
<div class='container'>
    <div class='row'>
        <div class='col'>
            <h3>STUDENT EMAIL</h3>
            <h3 style='float: right;'>SCHOOL LUNCH</h3>
        </div>
    </div>
    
    
    <?php
    for ($c=0;$c<$members; $c++){
        $studentEmail = $schoolLunch[$c]['email'];
       
       echo "<div class='row'><div class='col'>";
       echo "<h3 class='email'>". $schoolLunch[$c]["email"] ."</h3>";
       $functionCall = "change($studentEmail)";
       echo "<form id='$studentEmail' action='/changelunch.php' method='post'>
            <label class='switch'>";
            echo "<input type='hidden' name='studentEmail' value='$studentEmail'>";
            if ($schoolLunch[$c]["schoolLunch"] == "Yes") : ?>
            <html><input onchange="change('<?php echo $studentEmail?>')" type="checkbox" name="schoolLunch" value="true" checked></html>
          
      <?php else : ?>
          <html><input onchange="change('<?php echo $studentEmail?>')" type='checkbox' name='schoolLunch' value='true'></html>
      <?php endif;?>
      <?php
            
            echo "<span class='slider round'></span>
            </label></form>";  
      
       echo "</div></div>";
    }
    ?>
</div>
<script>var modal = document.getElementById("myModal");

// Get the button that opens the modal
function change(email){
   
    document.getElementById(email).submit();
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
function changeToHome() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}</script>