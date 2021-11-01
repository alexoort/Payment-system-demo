<?php
$host_name = 'xxx';
$database = 'xxx';
$user_name = 'xxx';
$password = 'xxx';
$conn = mysqli_connect($host_name, $user_name, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
echo "Connected successfully";
echo "Results=";

$sql = "SELECT * FROM `accounts`";
$result = mysqli_query($conn, $sql);
if ($result){
    echo "Successful query";
} else{
    echo "Error in query";
}
$rowsInTable = mysqli_num_rows($result);

for ($x=1;$x<=$rowsInTable;$x++){
$sql = "SELECT money FROM accounts WHERE id=$x";
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $money = $row["money"];
        echo ", ";
        echo $money;
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
}

echo "Lunch=";
$sql = "SELECT * FROM `accounts`";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)){
    $schoolLunch = $row["schoolLunch"];
    echo ", ";
    echo $schoolLunch;
}

// Close connection
mysqli_close($conn);
?>