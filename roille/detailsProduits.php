<?php
session_start();
require('application/database.php');

if(isset($_SESSION['id_client'])){
    $userInfo=getIdClient($_SESSION['id_client']);
} 

$id=$_GET['id_produit'];

$produit=getDetailProduitById($id);
$categories=listCategories();

print_r($_POST);
// Sélection et affichage du template PHTML.
$template = 'detailsProduits';
include 'layout.phtml';