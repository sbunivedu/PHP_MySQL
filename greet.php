<?php
function greet($name) {
  echo "Hello ".$name."!";
}

function greet1($name) {
?>
  <h1>Hello <?=$name?></h1>
<?php
}

greet("John");
greet("Bob");
greet("Alice");

greet1("John");
greet1("Bob");
greet1("Alice");
?>
