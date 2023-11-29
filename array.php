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