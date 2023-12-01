<?php
function greet($name){
  echo "Hello ".$name."!";
}

function greet1($name){
?>
  <h1>Hello <?=$name?>!</h1>
<?php
}

greet("John");
greet("Bob");
greet("Alice");

greet1("John");
greet1("Bob");
greet1("Alice");

function present_form(){
?>
<form action="form1.php" method="POST" >
  <label for="fname">First name:</label><br>
  <input type="text" id="fname" name="firstname"><br>
  <label for="lname">Last name:</label><br>
  <input type="text" id="lname" name="lastname">
	<input type="submit" value="Submit">
</form>
<?php
}
?>

present_form();
present_form();