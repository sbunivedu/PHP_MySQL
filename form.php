<form action="/form.php">
  <label for="fname">First name:</label><br>
  <input type="text" id="fname" name="firstname"><br>
  <label for="lname">Last name:</label><br>
  <input type="text" id="lname" name="lastname">
	<input type="submit" value="Submit">
</form>

<?php
print_r($_GET);
?>