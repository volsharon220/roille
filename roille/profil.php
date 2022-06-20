<?php
session_start();
include("application/database.php");

   
   if(isset($_SESSION['id_client'])){
       $userInfo=getIdClient($_SESSION['id_client']);
   }     

$profilUserParc=getIdClientParc($_SESSION['id_client']);
$profilUserPro=getIdClientPro($_SESSION['id_client']);

  // Sélection et affichage du template PHTML.
$template = 'profil';
include 'layout.phtml';