<?php

require('application/database.php');

$id=$_GET['id'];
deleteClientParticulier($id);
header('Location:administration.php?id='.$id);


?>