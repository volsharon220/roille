<?php
session_start();
require('application/database.php');


   
   if(isset($_SESSION['id_client'])){
       $userInfo=getIdClient($_SESSION['id_client']);
   } 

// Sélection et affichage du template PHTML.
$template = 'administration.phtml';
include 'layout.phtml';


