<?php

// name
$name = $_FILES['upload']['name'];
echo "Name $name<br >";

// size
$size = $_FILES['upload']['size'];
echo "Size $size<br />";

// type
$type = $_FILES['upload']['type'];
echo "Type $type<br />";

// get the temp location
$tmp_name = $_FILES['upload']['tmp_name'];
echo "Tmp Name $tmp_name<br />";

// copy file to the uploads folder where it will stay permanently
move_uploaded_file($tmp_name, "uploads/$name");

?>