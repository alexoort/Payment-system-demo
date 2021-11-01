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
$items=array();
$itemsCount = array();
$snacks = array("Coffee", "Croissant", "A. Juice", "Cookie", "Brezel", "Cherry Pastry", "Pingui", "Water", "C. Croissant", "Laugen stange", "Cheese Brezel", "Panini", "Bagel", "C. Biscuit", "Capri Sun", "O. Juice", "Choc. Bar", "A. Pastry", "S. Sandwhich", "C. Sandwhich", "Muffin");
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

if ($_SESSION['loggedin'] == FALSE){
    header("Location: login.php");
    exit();
}
 
// Attempt select query execution

$startOfDay = date('Y-m-d \00:00', strtotime($today));
$endOfDay = date('Y-m-d \23:59', strtotime($today));

$sql = "SELECT * FROM purchases WHERE DATE(`date`)=CURDATE() AND description!='Addition'";
$result = $mysqli->query($sql);
$rows= $result->num_rows;
while ($row = $result->fetch_array()){
        $dailyTotal += number_format(sqrt($row["value"] * $row["value"]), 2);
        
    }
$sql = "SELECT * FROM items WHERE DATE(`date`)=CURDATE() AND product!='Addition'";
$result = $mysqli->query($sql);
$itemsBought= $result->num_rows;

$c=0;    
$mostPopular = 0;
for ($x=0;$x<=count($snacks);$x++){
    $snack = $snacks[$x];
    $sql = "SELECT * FROM items WHERE (product='$snack' AND DATE(`date`)=CURDATE())";
    $result = $mysqli->query($sql);
    $count = $result->num_rows;
    if ($count > 0){
       $items[$c] = $snack;
       $itemsCount[$c] = $count;
       $c++;
       if ($count > $mostPopular){
        $mostPopular = $count;
        $mostPopularSnack = $snack;
    } 
    }
    
}

// Close connection
$mysqli->close();
?>

<html>
    <head>
        <title>Analytics</title>
        <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="analytics.css">
    <script src="jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="countUp.min.js" type="text/javascript"></script>
  </head>
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

    <h1 class='heading' style="font-size: 50px;"><center>Analytics</center></h1>
    <br>
    <br>
    <center>
        <div class='container narrow'>
            <div class='row'>
                <div class='col infocircle' id="revenue">
                   <h5>Today's revenue</h5> 
                   
                      <?php echo number_format($dailyTotal,2);?> € 
                   
                </div>
                <div class='col infocircle' id='items'>
                   <h5>Items sold</h5> 
                  
                      <?php echo $itemsBought?>
                   
                </div>
                <div class='col infocircle' id='popular'>
                   <h5>Most popular item</h5> 
                   
                      <?php echo $mostPopularSnack?> - <?php echo $mostPopular?> sold
                   
                </div>
            </div>
        
    </div>
</center>
<br><br><br>
<h3 style="margin-left: 12%;">Receipt:</h3>
<div class='container'>
    <?php
    $s = 0;
    echo "<div class='row'>";
    for ($c=0;$c<count($items); $c++){
        if ($s == 4){
            echo "</div><div class='row'>";
            $s=0;
        }
        
        echo "<div class='col'><center><h4>" . $items[$c] .": ". $itemsCount[$c] . "</h4></center>
            
        </div>";
    $s++;
    }
    ?>
    
    
</div>


</html>