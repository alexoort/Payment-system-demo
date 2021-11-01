<?php 
session_start();
if ($_SESSION['signedin'] !== TRUE){
    header("Location: signup.html");
    exit();
}
session_destroy();
?>
<html>
    <head>
        <link rel="stylesheet" href="fireworks.css">
    
    </head>
    <body>
        <div class="pyro">
  <div class="before"></div>
  <div class="after"></div>
</div>

<br><br><br><br><br><br><br><br><center>
<h1 class='white'>Woohoo!</h1></center>
<h3 class='white'><center>You successfully created an account</center></h3>
<br>
<h3 class='white'><center><a href='login.php'>Log in</a></center></h3>
</body>  
</html>