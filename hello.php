<?php
session_start();
if(!isset($_SESSION['username'])){
  header("Location: login.php");
}
?>

Hello <?=$_SESSION['username']?>!

<a href="logout.php">logout</a>
