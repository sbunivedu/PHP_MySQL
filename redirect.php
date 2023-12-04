<?php
function redirect($url) {
  header('Location: '.$url);
  die(); //prevent further code execution
}

redirect("https://www.sbuniv.edu/");
?>