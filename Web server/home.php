<?php
session_start();
$mysqli = new mysqli("xxx", "xxx", "xxx", "xxx");
$lastActivityItems = array(); 
$email = $_SESSION["email"];
$allActivity = array();
$snacks = array("Coffee", "Croissant", "A. Juice", "Cookie", "Brezel", "Cherry Pastry", "Pingui", "Water", "C. Croissant", "Laugen stange", "Cheese Brezel", "Panini", "Bagel", "C. Biscuit", "Capri Sun", "O. Juice", "Choc. Bar", "A. Pastry", "S. Sandwhich", "C. Sandwhich", "Muffin");
// Check connection

$nrOfMains = $_SESSION["mains"];

if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

if ($_SESSION['loggedin'] == FALSE){
    header("Location: login.php");
    exit();
}
 
if ($_SESSION["usertype"] == 'admin'){
    header("Location: analytics.php");
    exit();
}
// Attempt select query execution
$sql = "SELECT  * FROM accounts WHERE email='$email'";
if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
        $row = $result -> fetch_array(MYSQLI_ASSOC);
        $money= $row["money"];
        $lastActivityValue = $row['lastPurchaseCost'];
        $lastActivityValue = number_format(sqrt($lastActivityValue * $lastActivityValue), 2);
        $lastActivityDescription = $row['lastPurchaseItem'];
        
        $lastActivityDate = $row['lastPurchaseDate'];
        $lastActivityDate = date('d/m/Y \a\t H:i', strtotime($lastActivityDate));
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
$i=0;
if ($result){
    $nrOfPurchases = $result->num_rows;
    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
        $allActivity[$i]["description"] = $row["description"];
        $allActivity[$i]["value"] = number_format(sqrt($row["value"] * $row["value"]), 2);
        $allActivity[$i]["date"] = $row["date"];
        $dayOfTheWeek = date("w", strtotime($allActivity[$i]["date"]));
        $dayOfTheWeekCount[$dayOfTheWeek] += 1;
        $i++;
    }
} else {
    echo "Error:" . $mysqli->error;
}

$sql = "SELECT * FROM purchases WHERE email='$email' AND date between (CURDATE() - INTERVAL 1 MONTH ) and CURDATE()";
$result = $mysqli->query($sql);
$purchasesLast30Days = $result->num_rows;

$mostPopular = 0;
for ($x=0;$x<=count($snacks);$x++){
    $snack = $snacks[$x];
    $sql = "SELECT * FROM items WHERE (product='$snack' AND email='$email')";
    $result = $mysqli->query($sql);
    $count = $result->num_rows;
    if ($count > $mostPopular){
        $mostPopular = $count;
        $mostPopularSnack = $snack;
    }
}

$mostPopularDay = "";
$mostPopularDayCount = 0;

for ($w=0;$w<=6;$w++){
  if ($dayOfTheWeekCount[$w] > $mostPopularDayCount){
      $mostPopularDayCount = $dayOfTheWeekCount[$w];
      $mostPopularDayPercent = number_format(($mostPopularDayCount/$nrOfPurchases)*100);
      $mostPopularDay = date('l', strtotime("Sunday +{$w} days"));
  }  
}


$enteredMain = 0;
$b=0;
$sql = "SELECT * FROM lunch WHERE `date`=CURDATE() AND type='main'";
$result = $mysqli -> query($sql);
if ($result->num_rows >0){
    $enteredMain = 1;
    if ($result->num_rows >1){
        $enteredMain =2;
    }
    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
        $lunch["main"][$b]["description"] = $row["description"];
        $lunch['main'][$b]["vegetarian"] = $row["vegetarian"];
        $lunch['main'][$b]["lactose"] = $row["lactose"];
        $lunch['main'][$b]["eggs"] = $row["eggs"];
        $lunch['main'][$b]["soya"] = $row["soy"];
        $b++;
    }
}


// Close connection
$mysqli->close();
?>

<html>
    <head>
        <title>Home</title>
        <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="home.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="countUp.min.js" type="text/javascript"></script>
<link rel="icon" href="cashfreecanteen.png">
  </head>
    
    <body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-card" id="myNavbar">
    <a href="/" class="w3-bar-item w3-button w3-wide"><img src="cashfreecanteen.png" id="logo" width="120px"></a>
    <!-- Right-sided navbar links -->
    
    <div class="w3-right w3-hide-small" id="text">
        
        <a href="home.php" class="w3-bar-item w3-button current"><i class='fa fa-home'></i> HOME</a>
      <a href="myaccount.php" class="w3-bar-item w3-button"><i class='fa fa-dollar'></i> ACCOUNT</a>
      <?php
      if ($_SESSION["usertype"] == 'omniuser'){
          echo "<a href='analytics.php' class='w3-bar-item w3-button'><i class='fa fa-bar-chart'></i> ANALYTICS</a>";
      }
    ?>
    
      
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
  <a href="home.php" onclick="w3_close()" class="w3-bar-item w3-button current">HOME</a>
  <a href="myaccount.php" onclick="w3_close()" class="w3-bar-item w3-button">ACCOUNT</a>
  <a href="profile.php" onclick="w3_close()" class="w3-bar-item w3-button">PROFILE</a>
  <a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button">LOG OUT</a>
</nav>
<br>
<br>
<br>
<br>

<h1 class='heading' style="font-size: 50px;"><center>Welcome, <?php echo $_SESSION['name']?></center></h1>
<br><br>


<div class='container'>
    <div class='row'>
        
        <div class='col-sm' id="activitycolumn">
            <div id="activity">
            <h4 class='centered'>Latest activity</h4>
            </div>
            <center>
                <div class='info'>
            <br><br>
                <?php
                if (isset($lastActivityDescription)){
                if ($lastActivityDescription == "Addition"){
                    echo "<p>Added</p>";
                    echo "<h1>$lastActivityValue €</h1>";
                    echo "<p>on $lastActivityDate</p>";
                }
                else{
                    echo "<p>Bought</p>";
                    echo "<h2>$lastActivityDescription</h2>";
                    
                    echo "<h2>for $lastActivityValue €</h2>";
                    echo "<p>on $lastActivityDate</p>";
                    
                    
                }
                echo "<br><a href='myaccount.php#transaction'>All of your transactions</a>";
                } else{
                    echo "<h5>No activity</h5>";
                }
                ?>
                
            </div>
            </center>
        </div>
        <div class='col-sm'>
            <div id="money">
            <h4 class='centered'>Account balance</h4></div>
            <center>
                <br><br>
                <p>There are currently</p>
                
            <h1 id="counter"> €</h1>
            
            <p>in your account</p>
            <br>
            
            </center>
            
        </div>
        <div class='col-sm'>
            <div id="general">
            <?php 
            if ($enteredMain >= 1){
                echo "<h4 class='centered'>Today's lunch</h4>
            </div>";
            
            if ($lunch['main'][0]['vegetarian'] == 'yes'){
                echo "<div class='firstMeal'><img class='vlabel' src='vegetarian.png'>";
                $descriptionLen = strlen($lunch['main'][0]['description']);
                if ($descriptionLen > 30){
                    echo "<h3 class='centeredMainSmall'>". $lunch['main'][0]['description'] ."</h3><div class='break'></div>";
                } else{
                    echo "<h3 class='centeredMain'>". $lunch['main'][0]['description'] ."</h3><div class='break'></div>";
                }
                if ($lunch['main'][0]['lactose'] == 0 and $lunch['main'][0]['eggs'] == 0 and $lunch['main'][0]['soya'] == 0){
                    
                } else{
                   if ($lunch['main'][0]['lactose'] == 1){
                    echo "<img class='allergen' src='milk allergen.png' height='35px'>";
                }
                if ($lunch['main'][0]['eggs'] == 1){
                    echo "<img class='allergen' src='eggs allergen.png' height='35px'>";
                }
                if ($lunch['main'][0]['soya'] == 1){
                    echo "<img class='allergen' src='soya allergen.png' height='35px'>";
                } 
                }
                 
                
                echo "</div>";
            } else{
                $descriptionLen = strlen($lunch['main'][0]['description']);
               
                if ($descriptionLen > 30){
                    echo "<div class='firstMeal'><h3 class='centeredMainSmall'>". $lunch['main'][0]['description'] ."</h3><div class='break'></div>";
                } else{
                    echo "<div class='meal firstMeal'><h3 class='centeredMain'>". $lunch['main'][0]['description'] ."</h3><div class='break'></div>";
                }
                
                if ($lunch['main'][0]['lactose'] == 0 and $lunch['main'][0]['eggs'] == 0 and $lunch['main'][0]['soya'] == 0){
                    echo "<br>";
                } else{
                   if ($lunch['main'][0]['lactose'] == 1){
                    echo "<img class='allergen' src='milk allergen.png' height='35px'>";
                }
                if ($lunch['main'][0]['eggs'] == 1){
                    echo "<img class='allergen' src='eggs allergen.png' height='35px'>";
                }
                if ($lunch['main'][0]['soya'] == 1){
                    echo "<img class='allergen' src='soya allergen.png' height='35px'>";
                } 
                }
                echo "</div>";
            }
              if ($enteredMain >= 2){
                  
                  if ($lunch['main'][1]['vegetarian'] == 'yes'){
                echo "<div class='meal'><img class='vlabel' src='vegetarian.png'>";
                $descriptionLen = strlen($lunch['main'][1]['description']);
                if ($descriptionLen > 30){
                    echo "<h3 class='centeredMainSmall'>". $lunch['main'][1]['description'] ."</h3><div class='break'></div>";
                } else{
                    echo "<h3 class='centeredMain'>". $lunch['main'][1]['description'] ."</h3><div class='break'></div>";
                }
                if ($lunch['main'][1]['lactose'] == 0 and $lunch['main'][1]['eggs'] == 0 and $lunch['main'][1]['soya'] == 0){
                    echo "<br>";
                } else{
                   if ($lunch['main'][1]['lactose'] == 1){
                    echo "<img class='allergen' src='milk allergen.png' height='35px'>";
                }
                if ($lunch['main'][1]['eggs'] == 1){
                    echo "<img class='allergen' src='eggs allergen.png' height='35px'>";
                }
                if ($lunch['main'][1]['soya'] == 1){
                    echo "<img class='allergen' src='soya allergen.png' height='35px'>";
                } 
                }
                echo "</div>";
            } else{
                $descriptionLen = strlen($lunch['main'][1]['description']);
                if ($descriptionLen > 30){
                    echo "<h3 class='centeredMainSmall'>". $lunch['main'][1]['description'] ."</h3><div class='break'></div>";
                    
                } else{
                    echo "<h3 class='centeredMain'>". $lunch['main'][1]['description'] ."</h3><div class='break'></div>";
                }
            }
              }
              
              echo "<div class='modal fade' id='myModal' role='dialog'>
    <div class='modal-dialog modal-lg'>
      <div class='modal-content'>
        <div class='modal-header'>
          <button type='button' class='close' data-dismiss='modal'>&times;</button>
          <h4 class='modal-title'>Modal Header</h4>
        </div>
        <div class='modal-body'>
          <p>This is a large modal.</p>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
";
            
            } else{
                echo "<h4 class='centered'>General trends</h4>
          
            <br>
            <div class='container'>
            <div class='row'>
            <div class='col box'>
            <p>Total number of purchases: ". $nrOfPurchases ."</p>
            </div>
            <div class='col box'>
            <p>Number of purchases in the last 30 days: ".$purchasesLast30Days ."</p>
            </div>
            </div>
            <div class='row'>
            <div class='col box'>
            <p>Favourite snack: ".$mostPopularSnack." - Bought ".$mostPopular." times </p>
           </div>
           <div class='col box'>
                <p>Most active day: ". $mostPopularDay ." - ". $mostPopularDayPercent ."% of your purchases are on this day.</p></div></div></div>";
                
            }
            ?>
            
            
        
           
           
        </div>
    </div>
</div>


<script type="text/javascript">
  var options = {
useEasing : true, 
useGrouping : true, 
separator : '', 
decimal : '.', 
prefix : '', 
suffix : ' €' 
};
var demo = new CountUp("counter", 0, <?php echo $money?>, 2, 1, options);
demo.start();

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


</html>

