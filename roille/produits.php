<?php

require('application/database.php');
$nom=$_GET['categorie'];
print_r($_GET);


$produits=getListProduitById($nom);
$categories=listCategories();

// Sélection et affichage du template PHTML.
$template = 'produits';
include 'layout.phtml';