# Basic PHP and Connect to MySQL

The purpose of this exercise is to get you familiar with using [PHP script](https://www.w3schools.com/php/) to interact with MySQL database. We assume you have your `public_html` directory setup on `cisone.sbuniv.edu` under your account.

## Print Array
PHP variable names start with `$` and PHP code must appear in `<?php ... ?>` blocks, as follows (in [array.php](array.php)):

```php
<?php
$rows = array(
  ["name"=>"Beauty Shop", "year"=>"2005"],
  ["name"=>"Magic 7", "year"=>"2005"]);

print_r($rows);

print("<br>\n");

for($i=0; $i<count($rows); $i++){
  print_r($rows[$i]);
  print("<br>\n");
}
?>
```

To run this example, clone this repo on `cisone.sbuniv.edu` under your `public_html` directory, change the name of your repository directory to `test`, and point your browser to [`http://cisone.sbuniv.edu/~s123456@sbuniv.edu/test/array.php`](http://cisone.sbuniv.edu/~s123456@sbuniv.edu/test/array.php) (replace s123456 with your student ID).

You should see three arrays as the output of the script. You can right-click on the webpage and select "View Page Source" to see the script output AS IS.
The first array is an array of arrays. It is a number-indexed array, whose elements are string-indexed associative arrays. This is the type of array you will get as query results.

```
Array ( [0] => Array ( [name] => Beauty Shop [year] => 2005 ) [1] => Array ( [name] => Magic 7 [year] => 2005 ) )
Array ( [name] => Beauty Shop [year] => 2005 )
Array ( [name] => Magic 7 [year] => 2005 )
```

## Print Array as HTML Table
To output this array in a prettier [HTML table](https://www.w3schools.com/html/html_tables.asp) format you will have to print some HTML tags as follows (in [print_table.php](print_table.php)):
```php
<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
}
</style>
</head>

<body>
<table>
  <caption> Movies </caption>
  <tr>
    <th>#</th> <th>Title</th> <th>Year</th>
  </tr>

<?php
$rows = array(
  ["name"=>"Beauty Shop", "year"=>"2005"],
  ["name"=>"Magic 7", "year"=>"2005"]);
$i = 1;
foreach ($rows as $row){
?>
  <tr>
    <td><?= $i ?></td>
    <td><?= htmlspecialchars($row["name"]) ?></td>
    <td><?= htmlspecialchars($row["year"]) ?></td>
  </tr>
<?php
  $i++;
}
?>
</table>
</body>

</html>
```

## Fetch Data from MySQL
The following script (in [query1.php](query1.php)) connects to MySQL with the [`mysqli_connect`](https://www.w3schools.com/php/func_mysqli_connect.asp) function, runs a query with the [`mysqli_query`](https://www.w3schools.com/php/func_mysqli_query.asp) function, and prints the result by fetching one row at a time from the result set with the [`mysqli_fetch_assoc`](https://www.w3schools.com/php/func_mysqli_fetch_assoc.asp) function. The the [`mysqli_num_rows`](https://www.w3schools.com/php/func_mysqli_num_rows.asp) function counts the number of rows in the result set.

```php
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
```
This script prints 388269 rows, which is too many. Modify the query so that it prints the first 10 movies in the result set.

TODO: Modify this script to print the result in a HTML Table format.

## Query with Parameters

Given the IMDB schema as follows, write a SQL statement that finds the movies "Tom Cruise" acted in.
```
actors(id, first_name, last_name, gender, film_count)
directors(id, first_name, last_name)
movies(id, name, year, rank)
directors_genres(director_id, genre, prob)
movies_directors(director_id, movie_id)
movies_genres(movie_id, genre)
roles(actor_id, movie_id, role)
```

### Answer Key
```SQL
SELECT name, year FROM actors, movies, roles
  WHERE actors.id = roles.actor_id
  AND roles.movie_id = movies.id
  AND first_name = 'Tom'
  AND last_name = 'Cruise';
```

The query can be defined as a concatenated string in PHP. Note that the substrings are stitched together using `.`, which is the cancatenation operator in PHP. We need to insert spaces properly so that the query string look right to the DBMS.
```php
$sql =
  "SELECT name, year FROM actors, movies, roles".
  " WHERE actors.id = roles.actor_id".
  " AND roles.movie_id = movies.id".
  " AND first_name = 'Tom'".
  " AND last_name = 'Cruise'";
```

Now we can replace hard-coded names with parameters (in [query2.php](query2.php)). Note how in the SQL statement the literal strings for names are replaced by two variable names.

```php
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
```

## Get Parameters from Users

One way to send parameters to a PHP script is by appending them to the end of the URL ([GET method](https://www.w3schools.com/tags/ref_httpmethods.asp)). The following script (in [params.php](params.php)) expects two parameters from its caller and echos them back.

```php
$first_name = $_GET["firstname"];
$last_name = $_GET["lastname"];

print("first name: ".$first_name);
print("last name: ".$last_name);

print_r($_GET);
```

Point your browser to [`cisone.sbuniv.edu/~s123456@sbuniv.edu/test/params.php?firstname=Tom&lastname=Cruise`](cisone.sbuniv.edu/~s123456@sbuniv.edu/test/params.php?firstname=Tom&lastname=Cruise) to see what you get. Note that `$_GET` is an assoicative array with all parameters as key-value pairs sent in the URL.

TODO: Change the URL to send different values for the parameters.

TODO: Create a new script that combines [`params.php`](params.php) and [`query2.php`](query2.php) so that it outputs all movies in which a particular actor was in.

## Send Parameters with HTML Form

Manually sending paramters in URL is tedious. We could use an [`HTML Form`](https://www.w3schools.com/html/html_forms.asp) to capture and send parameters.

```php
<form action="form.php">
  <label for="fname">First name:</label><br>
  <input type="text" id="fname" name="firstname"><br>
  <label for="lname">Last name:</label><br>
  <input type="text" id="lname" name="lastname">
  <input type="submit" value="Submit">
</form>

<?php
print_r($_GET);
?>
```
This script (in [`form.php`](form.php)) presents a form and sends the form data to itself for processing. It simply echos all parameters sent via the GET method.

TODO: Fill out the form and click on "Submit" to see what you get and explain why the output is the way it is.

## Send Parameters Privately with POST Method
Parameters sent via the GET method are appended to the URL, which can be seen easily. The [`POST method`](https://www.w3schools.com/php/php_superglobals_post.asp) uses a separate network packet to send the parameters, which will not appear in the URL.
```php
<form action="form1.php" method="POST" >
  <label for="fname">First name:</label><br>
  <input type="text" id="fname" name="firstname"><br>
  <label for="lname">Last name:</label><br>
  <input type="text" id="lname" name="lastname">
  <input type="submit" value="Submit">
</form>

<?php
print_r($_POST);
?>
```
This script (in [`form1.php`](form1.php)) uses the POST method to send form data to the server script indicated by the `action` attribute.

## PHP Functions

You can define [PHP functions](https://www.w3schools.com/php/php_functions.asp) to reuse code and parameterize its "function".

```php
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
```
In the following example (in [`print_table_function.php`](print_table_function.php)), we extact the table printing code into it's own function so that it can be reused.

```php
<?php
$rows = array(
  ["name"=>"Beauty Shop", "year"=>"2005"],
  ["name"=>"Magic 7", "year"=>"2005"]);

function print_table($rows, $caption) {
?>
<table>
  <caption> <?= $caption ?> </caption>
  <tr>
    <th>#</th> <th>Title</th> <th>Year</th>
  </tr>

  <?php $i = 1; foreach ($rows as $row) { ?>
    <tr>
      <td><?= $i ?></td>
      <td><?= htmlspecialchars($row["name"]) ?></td>
      <td><?= htmlspecialchars($row["year"]) ?></td>
    </tr>
  <?php $i++; } ?>
</table>
<?php
}
?>
```
## PHP Include
Another way to reuse PHP code is to use the [include](https://www.w3schools.com/php/php_includes.asp) statement, which copies code from the included file to the including file. PHP will replace the `include` statements will the code in the included files. A common use case is to define common page headers and footers in their respective files and include them in all the PHP generated web pages so that the headers and footers are guaranteed to look the same.

```php
<?php
include(top.html);
?>

<h1>Welcome! Bienvenue! Willkommen! 欢迎! ¡Bienvenido! Добро пожаловать!</h1>

<?php
include(bottom.html);
?>
```

## PHP Redirect

Each PHP scriipt can process form data and generate output. We can separate these two concerns by sending form to one script for processing and redirect the web client to another PHP script for viewing the result. The following script (in [`redirect.php`](redirect.php)) simply redirects your browser to "SBU homepage".

```php
function redirect($url) {
  header('Location: '.$url);
  die(); //prevent further code execution
}

redirect("https://www.sbuniv.edu/");
```

```php
<html>
  <head>
    <title>TODO</title>
  </head>
  <body>

<form action="todo.php" method="GET">
  <input type="text" name="todo"/>
  <button type="submit">Add</button>
</form>

<?php

// create
if(isset($_REQUEST["todo"])){
  file_put_contents("list.txt", $_GET["todo"]."\n", FILE_APPEND);
}

// delete
if($_REQUEST["action"]=="delete"){
  $delete_index = $_REQUEST["index"];
  $old_array = file("list.txt");
  $new_array = [];
  for($i = 0; $i < count($old_array); $i++){
    if($i != $delete_index){
      array_push($new_array, $old_array[$i]);
    }
  }
  file_put_contents("list.txt", $new_array);
}

// edit
$edit_index = -1;
if($_REQUEST["action"]=="edit"){
  $edit_index = $_REQUEST["index"];
}

// update
if($_GET["action"]=="update"){
  $save_index = $_GET["index"];
  //print($save_index);
  $updated_todo = $_GET["todo"];
  //print($updated_todo);
  $old_array = file("list.txt");
  $new_array = [];
  for($i = 0; $i < count($old_array); $i++){
    if($i != $save_index){
      array_push($new_array, $old_array[$i]);
    }else{
      //print("append ".$updated_todo);
      array_push($new_array, $updated_todo."\n");
    }
  }
  file_put_contents("list.txt", $new_array);
}

// read
$array = file("list.txt");

//print_r($array);
?>
<ul>
<?php
for($i = 0; $i < count($array); $i++) {
  if($i==$edit_index){
?>
  <li>
  <form action="todo.php" method="GET">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="index" value=<?=$edit_index?>>
    <input type="text" name="todo" value=<?=$array[$i]?>/>
    <button type="submit">Save</button>
  </form>
  </li>
<?php
  }else{
?>
<li>
  <?=$array[$i]?>
  <a href="index.php?action=delete&index=<?=$i?>">❌</a>
  <a href="index.php?action=edit&index=<?=$i?>">✏️</a>
</li>
<?php
  }
}
?>
</ul>

</body>
</html>
```
