<?php
$servername = "localhost";
$dbname = "imdb";
$username = "webuser";
$password = "password";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

$sql = "SELECT name, year FROM movies";

//echo $sql;

$result = mysqli_query($conn, $sql);

$rowcount = mysqli_num_rows($result);

if($rowcount == 0){
  print "No result found.";
}else{
  printf("Result set has %d rows.\n",$rowcount);
  while($row = mysqli_fetch_assoc($result)) {
    print_r($row);
  }
}
?>
