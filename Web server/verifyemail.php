<?php
session_start();
$_SESSION['code'] = rand(0, 100000);
$code= $_SESSION['code'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$message= "Dear $name,
    
Please verify your email by entering the following code:
- $code
    
Kind regards, \nCashfreecanteen

";
mail($email, "Verify your email", $message);
?>
<html>
    
    <head>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
	    
		<div class="login">
			<h1>Verify your email</h1>
			<form action="authenticateverificationcode.php" method="post">
				<label for="name">
				    <i class='fas fa-lock'></i>
				</label>
				<input type="text" name="verificationcode" placeholder="Code sent to your email" id="name" required>
				<input type="submit" value="Verify">
			</form>
		</div>
	</body>
	</html>