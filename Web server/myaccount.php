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
$allActivity = array();
$trackedMoney = array();
// Check connection


if ($_SESSION['loggedin'] == FALSE){
    header("Location: login.php");
    exit();
}
 
// Attempt select query execution
$sql = "SELECT money FROM accounts WHERE email='$email'";
if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
        $row = $result -> fetch_array(MYSQLI_ASSOC);
        $money= $row["money"];
         
        // Free result set
        $result->free();
    } else{
        
        header("Location: login.php");
    }
} else{
    echo "ERROR: Could not execute $sql. " . $mysqli->error;
}

$sql= "SELECT * FROM purchases WHERE email='$email'";
$result = $mysqli->query($sql);
$nrOfPurchases = $result->num_rows;
$i=0;
if ($result){
    $nrOfPurchases = $result->num_rows;
    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
        $allActivity[$i]["description"] = $row["description"];
        $allActivity[$i]["value"] = $row["value"];
        $allActivity[$i]["date"] = date('d/m/Y', strtotime($row["date"]));
        $net += $allActivity[$i]["value"];
        $i++;
    }
} else {
    echo "Error:" . $mysqli->error;
}

$lowest=$money;
$highest=$money;
$startingMoney = $money - $net;
for ($o=0;$o<$i;$o++){
    $trackedMoney[$o]["date"] = $allActivity[$o]["date"];
    $trackedMoney[$o]["money"] = $startingMoney + $allActivity[$o]["value"];
    if ($trackedMoney[$o]["money"] < $lowest){
        $lowest = $trackedMoney[$o]["money"];
    }
    if ($trackedMoney[$o]["money"] > $highest){
        $highest = $trackedMoney[$o]["money"];
    }
    $startingMoney = $trackedMoney[$o]["money"];
}
 
// Close connection
$mysqli->close();
?>
<html>
    <head>
        <title>My Account</title>
        <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="myaccount.css">
    <script src="jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="countUp.min.js" type="text/javascript"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">

window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer", {
		
		theme: "light2",
		axisY:{
		    minimum: <?php echo ($lowest - 0.05*$lowest) ?>,
		    maximum: <?php echo ($highest + 0.05*$highest) ?>
		},
		data: [              
		{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "line",
			dataPoints: [
			    <?php 
			    for ($x=0;$x<$nrOfPurchases;$x++){
			        $date = $trackedMoney[$x]["date"];
			        $currentMoney = $trackedMoney[$x]['money'];
			        echo "{ label: '$date',  y: $currentMoney},"; 
			    }
			    
			    
				?>
				
			]
		}
		]
	});
	chart.render();
}
</script>
<script>
$(document).ready(function(){
  // Add smooth scrolling to all links
  $("a").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
});
</script>

  </head>
    
    <body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-card" id="myNavbar">
    <a href="/" class="w3-bar-item w3-button w3-wide"><img src="cashfreecanteen.png" id="logo" width="120px"></a>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-small" id="text">
        <a href="home.php" class="w3-bar-item w3-button"><i class='fa fa-home'></i> HOME</a>
      <a href="myaccount.php" class="w3-bar-item w3-button current"><i class='fa fa-dollar'></i> ACCOUNT</a>
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
  <a href="home.php" onclick="w3_close()" class="w3-bar-item w3-button">HOME</a>
  <a href="myaccount.php" onclick="w3_close()" class="w3-bar-item w3-button current">ACCOUNT</a>
  <a href="profile.php" onclick="w3_close()" class="w3-bar-item w3-button">PROFILE</a>
  <a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button">LOG OUT</a>
</nav>
<br>
<br>
<br>
<br>

<h1 class='heading' style="font-size: 50px;"><center><?php echo $_SESSION['name']?>'s Account</center></h1>
<br><br>
<h4><center>Money in account: <span style="font-size: 35px;"><?php echo $money?> €</span></center></h4>
<br>

<center><div id="chartContainer" style="height: 400px; width: 50%;"></div> </center>
<br><br>
<center><a href="#transaction"><i class="fa fa-angle-double-down" style="font-size: 50px;color: #6d77ad;"></i></a></center>
<br>
<div id="transaction">
    <br>
    <br>
    <br>
    <br>

<div class='container'>
    <div class='row'>
        <div class='col noBox'>
            <h2>Your Transactions:</h2>
        </div>
    </div>
    <?php
    for ($j=$i-1; $j>=0;$j--){
        $description = $allActivity[$j]['description'];
        $value = $allActivity[$j]['value'];
        $date = $allActivity[$j]["date"];
        if ($description == "Addition"){
           echo "<div class='row'>
        <div class='col green'>
        <h3 class='centered'>
            ".$description." <span style='font-size: 18px;'> (" . $date . ")</span> <span style='float: right; padding-right: 10px;'>" . $value . " €</span></h3>
            
        </div>
    </div>"; 
        } else{
            echo "<div class='row'>
        <div class='col red'>
        <h3 class='centered'>
            ".$description." <span style='font-size: 18px;'> (" . $date . ")</span> <span style='float: right; padding-right: 10px;'>" . $value . " €</span></h3>
            
        </div>
    </div>"; 
        }
        
    }
    ?>
    
</div>
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