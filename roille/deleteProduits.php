<?php

require('application/database.php');

$id=$_GET['id'];
deleteProduit($id);
header('Location:administration.php?id='.$id);


?>