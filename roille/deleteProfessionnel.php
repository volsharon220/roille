<?php

require('application/database.php');

$id=$_GET['id'];
deleteClientPro($id);
header('Location:administration.php?id='.$id);


?>