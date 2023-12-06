<?php
session_start();

if(isset($_SESSION['username'])){
  header("Location: hello.php");
}else if(isset($_POST['username'])){
  session_start();
  $_SESSION['username']=$_POST['username'];
  header("Location: hello.php");
}
?>

<form action="login.php" method="POST" >
  <label for="username">User name:</label><br>
  <input type="text" id="username" name="username"><br>
  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password">
	<input type="submit" value="Submit">
</form>
