<?php

require('application/database.php');

$id=$_GET['id'];
deleteCategories($id);
header('Location:administration.php?id='.$id);


?>