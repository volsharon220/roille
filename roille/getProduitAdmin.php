<?php

session_start();
include("application/database.php");
 // Connection automatique de l'utilisateur dans le cas d'éxistance de cookies
 include('cookieConnection.php');

   $produits= listProduits();

  
   
   if(isset($_SESSION['id_client'])){
       $userInfo=getIdClient($_SESSION['id_client']);
   }     


  // Sélection et affichage du template PHTML.
  $template = 'getProduitAdmin';
  include 'layout.phtml';