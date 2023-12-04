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
