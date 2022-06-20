
<?php
session_start();
include("application/database.php");
 // Connection automatique de l'utilisateur dans le cas d'éxistance de cookies
 include('cookieConnection.php');

   $categories= listCategories();

   if(isset($_GET['accepte-cookie'])){
      setcookie('accepte-cookie','true',time()+365*24*3600);
      header('location:./');
  }
   
   if(isset($_SESSION['id_client'])){
       $userInfo=getIdClient($_SESSION['id_client']);
   }     


  // Sélection et affichage du template PHTML.
$template = 'index';
include 'layout.phtml';
