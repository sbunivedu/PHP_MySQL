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
