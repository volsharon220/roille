<?php
session_start();
require('application/database.php');
$nom=$_GET['categorie'];

if(isset($_SESSION['id_client'])){
    $userInfo=getIdClient($_SESSION['id_client']);
} 

//liste des articles
$produits=getListProduitById($nom);
//liste des catégories
$categories=listCategories();

// Sélection et affichage du template PHTML.
$template = 'produits';
include 'layout.phtml';