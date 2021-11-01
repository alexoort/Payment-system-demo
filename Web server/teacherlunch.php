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
$clickedEmail = $_POST["email"];
$allActivity = array();
if (isset($_POST["lunchMonth"])){
   $month =  substr($_POST["lunchMonth"], 5);
   $year = substr($_POST["lunchMonth"], 0, 4);
   $date = $_POST["lunchMonth"];

} else{
   $date = date('Y-m');
   $month = date("m");
   $year = date("Y");
}




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
$sql = "SELECT * FROM accounts WHERE memberType='teacher'";
$result = $mysqli -> query($sql);
$nrOfTeachers = $result->num_rows;
while ($row = $result->fetch_array()){
    $teacherEmails[$b] = $row["email"];
    $b++;
}

$sql = "SELECT * FROM teacherlunch WHERE DATE(`date`)=CURDATE()";
$result = $mysqli -> query($sql);
$teacherLunches = $result->num_rows;

?>

<html>
    <head>
        <title>Teacher & staff lunch</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="teacherlunch.css">
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
    <link rel="icon" href="cashfreecanteen.png">
    <script src="jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="countUp.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
    <?php if (!isset($clickedEmail)) : ?>
<h1 class='heading' style="font-size: 50px; text-align: center;">Teachers & Staff</h1>
<br>

<div class="mainStat"><h4 style="text-align: center">Teacher Lunches Today: <h3><?php echo $teacherLunches;?></h3></h4></div>

<br><br><br>
<center>
<input style="text-align: center;" class="form-control" id="myInput" type="text" placeholder="Search for names...">
</center>
<center>

<div id="myDIV">
    <?php 
    for ($i=0; $i<$nrOfTeachers; $i++){ ?>
        <form id='<?php echo $teacherEmails[$i]?>' action='teacherlunch.php' method='POST'><input type='hidden' name='email' value='<?php echo $teacherEmails[$i]?>'><button class='teacherNames' type="submit"><?php echo $teacherEmails[$i]?></button></form>
    
    <?php }?>
    </div>
  <?php else:?>
    <center><h1><?php echo $clickedEmail?></h1></center>
    
    <br>
    <center><p>Showing activity for </p><form id="lunchDate" action='teacherlunch.php' method='post'><input oninput="changeDate()" type='month' value='<?php echo $date?>' min='2020-01' name='lunchMonth'><input type="hidden" name="email" value="<?php echo $clickedEmail?>"></form></center>

    
    
    
    <?php 
      $sql = "SELECT * FROM teacherlunch WHERE `email`='$clickedEmail' AND MONTH(`date`) = $month AND YEAR(`date`) = 2020";
      echo "<div class='container' id='specialContainer'>";
      $result = $mysqli -> query($sql);
      $nrOfLunches = $result->num_rows;
      $bill = number_format($nrOfLunches * 2.9, 2);
      echo "<div class='row'><div class='col specialBox' id='left'>Number of lunches: ". $nrOfLunches."</div><div class='col specialBox' id='right'>Money spent: ". $bill ." €</div></div></div><div class='container'>";
      
     
      while ($row = $result->fetch_array()){
          $date = date("d-m-Y", strtotime($row["date"]));
          echo "<div class='row'><div class='col'><h4>Lunch (2.90€)<span style='float: right;'>". $date ."</span></h4></div></div>";
      }

  ?>
  </div>
  
  <?php endif?>
  
</ul>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myDIV *").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

function submit(email){
    <?php $clickedEmail = email?>
    document.getElementById(email).submit();
}

function changeDate(){
    document.getElementById("lunchDate").submit();
}
</script>