<?php
$name = $_POST["Name"];
$email = $_POST["Email"];
$subject = $_POST["Subject"];
$message = $_POST["Message"];
$message .= "\nSent by ";
$message .= $email;
mail("alex@cashfreecanteen.com", $subject, $message);
header("Location: /#contact")
?>