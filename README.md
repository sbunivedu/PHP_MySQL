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

To run this example, clone this repo on `cisone.sbuniv.edu` under your `public_html` directory, change the name of your repository directory to `test`, and point your browser to `http://cisone.sbuniv.edu/~s123456@sbuniv.edu/test/array.php` (replace s123456 with your student ID).

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

Now we can replace hard-coded names with parameters ([query2.php](in query2.php)). Note how in the SQL statement the literal string for names are replaced by two variable names.

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

Point your browser to `cisone.sbuniv.edu/~s123456@sbuniv.edu/test/params.php?firstname=Tom&lastname=Cruise` to see what you get. Note that `$_GET` is an assoicative array with all parameters as key-value pairs sent in the URL.

TODO: Change the URL to send different values for the parameters.

TODO: Create a new script that combines [`params.php`](params.php) and [`query2.php`](query2.php) so that it outputs all movies in which a particular actor was in.

## Send Parameters with HTML Form

Manually sending paramters in URL is tedious. We could use an [`HTML Form`](https://www.w3schools.com/html/html_forms.asp) to capture and send parameters.

```php
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
```
This script (in [`form.php`](form.php)) presents a form and sends the form data to itself for processing. It simply echos all parameters sent via the GET method.
