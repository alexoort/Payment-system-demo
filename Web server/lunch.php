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
$enteredMain = 0;
$enteredSide = 0;
$enteredDessert = 0;
$email = $_SESSION["email"];
$today = date("Y-m-d");
$allActivity = array();
$snacks = array("Coffee", "Croissant", "A. Juice", "Cookie", "Brezel", "Cherry Pastry", "Pingui", "Water", "C. Croissant", "Laugen stange", "Cheese Brezel", "Panini", "Bagel", "C. Biscuit", "Capri Sun", "O. Juice", "Choc. Bar", "A. Pastry", "S. Sandwhich", "C. Sandwhich", "Muffin");
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
 
// Attempt select query execution

$startOfDay = date('Y-m-d \00:00', strtotime($today));
$endOfDay = date('Y-m-d \23:59', strtotime($today));
    


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
        $lunch['main'][$b]["allergies"] = $row["allergies"];
        $b++;
    }
}

$b=0;
$sql = "SELECT * FROM lunch WHERE `date`=CURDATE() AND type='dessert'";
$result = $mysqli -> query($sql);
if ($result->num_rows >0){
    $enteredDessert = 1;
    if ($result->num_rows >1){
        $enteredDessert =2;
    }
    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
        $lunch["dessert"][$b]["description"] = $row["description"];
        $lunch['dessert'][$b]["vegetarian"] = $row["vegetarian"];
        $lunch['dessert'][$b]["allergies"] = $row["allergies"];
        $b++;
    }
}

$b=0;
$sql = "SELECT * FROM lunch WHERE `date`=CURDATE() AND type='side'";
$result = $mysqli -> query($sql);
if ($result->num_rows >0){
    $enteredSide = 1;
    if ($result->num_rows >1){
        $enteredSide =2;
    }
    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
        $lunch["side"][$b]["description"] = $row["description"];
        $lunch['side'][$b]["vegetarian"] = $row["vegetarian"];
        $lunch['side'][$b]["allergies"] = $row["allergies"];
        $b++;
    }
}

// Close connection
$mysqli->close();
?>

<html>
    <head>
        <title>Lunch</title>
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
<link rel="icon" href="cashfreecanteen.png">
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
      <a href="lunch.php" class="w3-bar-item w3-button active"><i class='fa fa-cutlery'></i> LUNCH</a>
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
  <a href="lunch.php" class='current'>Menu</a>
  <a href="studentlunch.php">Students</a>
  <a href="teacherlunch.php">Teachers</a>
 
</div>
<div class='maincontent'>
<h1 class='heading' style="font-size: 50px;"><center>Today's lunch</center></h1>

<div class='container'>
    <div class='row'>
        <div class='col-sm'>
            <div id="side">
            <h4 class='centered'>Side dish</h4>
            </div>
            <?php if ($enteredSide < 1):?>
             <br><br><br><br>  
<a href='#mySideModal' data-toggle='modal'><i class='fa fa-plus' style='font-size: 80px; color: lightblue;'></i></a>
<h3>Add a side dish</h3>

<!-- Modal HTML -->
<div id='mySideModal' class='modal fade'>
	<div class='modal-dialog modal-login'>
		<div class='modal-content'>
			<form action='addmeal.php' method='post'>
				<div class='modal-header'>				
					<h4 class='modal-title'>Today's Side dish</h4>
					<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
				</div>
				<input type='hidden' name='type' value='side'>
				<div class='modal-body'>				
					
					    <div class='form-group'>
						<h5>Description</h5>
						<input type='text' class='description' required='required' name='description'>
					</div>
					
					<div class='form-group'>
					<h5>Vegetarian</h5>
					<input type='radio' name='vegetarian' id='yes' value='yes'>
					    <label for='main'>YES</label>
					    <input type='radio' name='vegetarian' id='no' value='no' checked>
					    <label for='no'>NO</label>
					</div>
					<div class='form-group'>
						
							<h5>Allergies</h5>
							<label>Lactose:<input type='checkbox' class='form-control' name='lactose' value='1'></label>
							<label>Eggs:<input type='checkbox' class='form-control' name='eggs' value='1'></label>
							<label>Soy<input type='checkbox' class='form-control' name='soy' value='1'></label>
						
					</div>
				</div>
				<div class='modal-footer'>
					
					<center><input type='submit' class='btn' value='Submit'></center>
				</div>
			</form>
		</div>
	</div>
</div>
            <?php else:?>
            <?php if ($lunch['side'][0]['vegetarian'] == 'yes'):?>
                <div class='side'>
                    <img class='vlabel' src='vegetarian.png' width='25px'>
                    <h4 class='centeredMain'> <?php echo $lunch['side'][0]['description']?></h4>
                </div>
            <?php else:?>
                <div class='side'>
                    <h4 class='centeredMain'><?php echo $lunch['side'][0]['description']?></h4>
                </div>
            <?php endif?>
            <?php if ($enteredSide ==1):?>
                <br>
<a href='#myModal' data-toggle='modal'><i class='fa fa-plus' style='font-size: 60px; color: #d7f7d9;'></i></a>
<h4>Add another main</h4>

<!-- Modal HTML -->
<div id='myModal' class='modal fade'>
	<div class='modal-dialog modal-login'>
		<div class='modal-content'>
			<form action='addmeal.php' method='post'>
				<div class='modal-header'>				
					<h4 class='modal-title'>Today's Main</h4>
					<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
				</div>
				<input type='hidden' name='type' value='main'>
				<div class='modal-body'>				
					
					    <div class='form-group'>
						<h5>Description</h5>
						<input type='text' class='description' required='required' name='description'>
					</div>
					
					<div class='form-group'>
					<h5>Vegetarian</h5>
					<input type='radio' name='vegetarian' id='yes' value='yes'>
					    <label for='main'>YES</label>
					    <input type='radio' name='vegetarian' id='no' value='no' checked>
					    <label for='no'>NO</label>
					</div>
					<div class='form-group'>
						
							<h5>Allergies</h5>
							<label>Lactose:<input type='checkbox' class='form-control' name='lactose' value='1'></label>
							<label>Eggs:<input type='checkbox' class='form-control' name='eggs' value='1'></label>
							<label>Soy<input type='checkbox' class='form-control' name='soy' value='1'></label>
						
					</div>
				</div>
				<div class='modal-footer'>
					
					<center><input type='submit' class='btn' value='Submit'></center>
				                </div>
			                </form>
		                </div>
	                </div>
                </div>
            <?php else:?>
                <?php if ($lunch['side'][1]['vegetarian'] == 'yes'):?>
                <div class='side'>
                    <img class='vlabel' src='vegetarian.png' width='25px'>
                    <h4 class='centeredMain'> <?php echo $lunch['side'][1]['description']?></h4>
                </div>
            <?php else:?>
                <div class='side'>
                    <h4 class='centeredMain'><?php echo $lunch['side'][1]['description']?></h4>
                </div>
            <?php endif?>
        <?php endif?>
        <?php endif?>
        </div>
        
        <div class='col-sm main' >
            <div id="mainCourse">
                <h4 class='centered'>Main course</h4>
            </div>
            <?php 
            if ($enteredMain < 1){
               echo "<br><br><br><br>  
<a href='#myModal' data-toggle='modal'><i class='fa fa-plus' style='font-size: 80px; color: #d7f7d9;'></i></a>
<h3>Add a main</h3>

<!-- Modal HTML -->
<div id='myModal' class='modal fade'>
	<div class='modal-dialog modal-login'>
		<div class='modal-content'>
			<form action='addmeal.php' method='post'>
				<div class='modal-header'>				
					<h4 class='modal-title'>Today's Main</h4>
					<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
				</div>
				<input type='hidden' name='type' value='main'>
				<div class='modal-body'>				
					
					    <div class='form-group'>
						<h5>Description</h5>
						<input type='text' class='description' required='required' name='description'>
					</div>
					
					<div class='form-group'>
					<h5>Vegetarian</h5>
					<input type='radio' name='vegetarian' id='yes' value='yes'>
					    <label for='main'>YES</label>
					    <input type='radio' name='vegetarian' id='no' value='no' checked>
					    <label for='no'>NO</label>
					</div>
					<div class='form-group'>
						
							<h5>Allergies</h5>
							<label>Lactose:<input type='checkbox' class='form-control' name='lactose' value='1'></label>
							<label>Eggs:<input type='checkbox' class='form-control' name='eggs' value='1'></label>
							<label>Soy<input type='checkbox' class='form-control' name='soy' value= '1'></label>
						
					</div>
				</div>
				<div class='modal-footer'>
					
					<center><input type='submit' class='btn' value='Submit'></center>
				</div>
			</form>
		</div>
	</div>
</div>"; 
            } else {
                if ($lunch['main'][0]['vegetarian'] == 'yes'){
                    echo "<div class='meal'>
                    <img class='vlabel' src='vegetarian.png' width='25px'>
    <h4 class='centeredMain'>". $lunch['main'][0]['description'] ."</h4>
</div>";
            } else{
                echo "<div class='meal'>
                    
    <h4 class='centeredMain'>". $lunch['main'][0]['description'] ."</h4>
</div>";
            }
                
        if ($enteredMain == 1){
            
           echo "<br>
<a href='#myModal' data-toggle='modal'><i class='fa fa-plus' style='font-size: 60px; color: #d7f7d9;'></i></a>
<h4>Add another main</h4>

<!-- Modal HTML -->
<div id='myModal' class='modal fade'>
	<div class='modal-dialog modal-login'>
		<div class='modal-content'>
			<form action='addmeal.php' method='post'>
				<div class='modal-header'>				
					<h4 class='modal-title'>Today's Main</h4>
					<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
				</div>
				<input type='hidden' name='type' value='main'>
				<div class='modal-body'>				
					
					    <div class='form-group'>
						<h5>Description</h5>
						<input type='text' class='description' required='required' name='description'>
					</div>
					
					<div class='form-group'>
					<h5>Vegetarian</h5>
					<input type='radio' name='vegetarian' id='yes' value='yes'>
					    <label for='main'>YES</label>
					    <input type='radio' name='vegetarian' id='no' value='no' checked>
					    <label for='no'>NO</label>
					</div>
					<div class='form-group'>
						
							<h5>Allergies</h5>
							<label>Lactose:<input type='checkbox' class='form-control' name='lactose' value='1'></label>
							<label>Eggs:<input type='checkbox' class='form-control' name='eggs' value='1'></label>
							<label>Soy<input type='checkbox' class='form-control' name='soy' value='1'></label>
						
					</div>
				</div>
				<div class='modal-footer'>
					
					<center><input type='submit' class='btn' value='Submit'></center>
				</div>
			</form>
		</div>
	</div>
</div>"; 
        } else{
            if ($lunch['main'][1]['vegetarian'] == 'yes'){
                    echo "<div class='meal'>
                    <img class='vlabel' src='vegetarian.png' width='25px'>
    <h4 class='centeredMain'>". $lunch['main'][1]['description'] ."</h4>
</div>";
            } else{
                echo "<div class='meal'>
                    
    <h4 class='centeredMain'>". $lunch['main'][1]['description'] ."</h4>
</div>";
            }
            }
            }
            ?>
          

      
        </div>
        <div class='col-sm dessert'>
            <div id="dessertCourse">
            <h4 class='centered'>Dessert</h4>
            </div>
            <?php 
            if ($enteredDessert < 1){
                echo "<br><br><br><br>  
<a href='#myDessertModal' data-toggle='modal'><i class='fa fa-plus' style='font-size: 80px; color: salmon;'></i></a>
<h3>Add a dessert</h3>

<!-- Modal HTML -->
<div id='myDessertModal' class='modal fade'>
	<div class='modal-dialog modal-login'>
		<div class='modal-content'>
			<form action='addmeal.php' method='post'>
				<div class='modal-header'>				
					<h4 class='modal-title'>Today's Dessert</h4>
					<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
				</div>
				<input type='hidden' name='type' value='dessert'>
				<div class='modal-body'>				
					
					    <div class='form-group'>
						<h5>Description</h5>
						<input type='text' class='description' required='required' name='description'>
					</div>
					
					<div class='form-group'>
					<h5>Vegetarian</h5>
					<input type='radio' name='vegetarian' id='yes' value='yes' checked>
					    <label for='main'>YES</label>
					    <input type='radio' name='vegetarian' id='no' value='no'>
					    <label for='no'>NO</label>
					</div>
					<div class='form-group'>
						
							<h5>Allergies</h5>
							<label>Lactose:<input type='checkbox' class='form-control' name='lactose' value='1'></label>
							<label>Eggs:<input type='checkbox' class='form-control' name='eggs' value='1'></label>
							<label>Soy<input type='checkbox' class='form-control' name='soy' value='1'></label>
						
					</div>
				</div>
				<div class='modal-footer'>
					
					<center><input type='submit' class='btn' value='Submit'></center>
				</div>
			</form>
		</div>
	</div>
</div>
        </div>
    </div>";
            } else{
                if ($lunch['dessert'][0]['vegetarian'] == 'yes'){
                   echo  "<div class='dessertItem'>
                   <img class='vlabel' src='vegetarian.png' width='25px'>
                <h4 class='centeredMain'>" . $lunch['dessert'][0]['description'] ."</h4>
                </div>"; 
                } else{
                   echo  "<div class='dessertItem'>
                <h4 class='centeredMain'>" . $lunch['dessert'][0]['description'] ."</h4>
                </div>"; 
                }
                
            }
            ?>
             
</div>

<script>
    function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}


// Toggle between showing and hiding the sidebar when clicking the menu icon
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

</body>
</html>