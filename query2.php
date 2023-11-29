<?php
$first_name = "Tom";
$last_name = "Cruise";

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

$sql =
"SELECT name, year FROM actors, movies, roles".
" WHERE actors.id = roles.actor_id".
" AND roles.movie_id = movies.id".
" AND first_name = '".$first_name."'".
" AND last_name = '".$last_name."'";

//echo $sql;

$result = mysqli_query($conn, $sql);

$rowcount = mysqli_num_rows($result);

if($rowcount == 0){
  print "No result found.";
}else{
  while($row = mysqli_fetch_assoc($result)) {
    print_r($row);
  }
}
?>