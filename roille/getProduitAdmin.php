<?php

session_start();
include("application/database.php");
 // Connection automatique de l'utilisateur dans le cas d'éxistance de cookies
 include('cookieConnection.php');

 if(isset($_SESSION['id_client'])){
  $userInfo=getIdClient($_SESSION['id_client']);
} 

   $produits= listProduits();

  


  // Sélection et affichage du template PHTML.
  $template = 'getProduitAdmin';
  include 'layout.phtml';