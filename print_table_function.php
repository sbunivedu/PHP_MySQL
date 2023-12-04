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

print_table($rows, "Movies");
?>