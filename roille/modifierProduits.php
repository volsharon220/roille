<?php

session_start();
require('application/database.php');

if(isset($_SESSION['id_client'])){
    $userInfo=getIdClient($_SESSION['id_client']);
} 

$id=$_GET['id'];

$categories=listCategories();
$produits=getDetailProduitById($id);

$produit=$produits[0];

if(isset($_POST['envoyer'])){
   

    if(!empty($_POST) && isset($_POST)){
 
        $nomp=htmlspecialchars($_POST['nomp']);
        $descpUn=htmlspecialchars($_POST['descpUn']);
        $descpDeux=htmlspecialchars($_POST['descpDeux']);
        $prixUnite=htmlspecialchars($_POST['prixUnite']);
        $quantite=htmlspecialchars($_POST['quantite']);
        $charge=htmlspecialchars($_POST['charge']);
        $hauteurTravail=htmlspecialchars($_POST['hauteurTravail']);
        $largeur=htmlspecialchars($_POST['largeur']);
        $longueur=htmlspecialchars($_POST['longueur']);
        $environnementTravail=htmlspecialchars($_POST['environnementTravail']);
        $energie=htmlspecialchars($_POST['energie']);
        $puissance=htmlspecialchars($_POST['puissance']);
        $poids=htmlspecialchars($_POST['poids']);
        $ref=htmlspecialchars($_POST['ref']);
        $nomc=htmlspecialchars($_POST['nomc']);

        if(isset($_FILES) && !empty($_FILES['imageP']['name'])){
            $tmpName=$_FILES['imageP']['tmp_name'];
            $name=$_FILES['imageP']['name']; 
                               
                      
            $tabExtension=explode('.',$name);
            $extension=strtolower(end($tabExtension));
                       
            $extensionValide=['jpg','png','jpeg','gif'];
            if(in_array($extension,$extensionValide)){
                $url=uniqid('',true);
                $file=$url.'.'.$extension;
    
                move_uploaded_file($tmpName,'image/'.$file);
                editeProduits($file,$nomp,$descpUn,$descpDeux,$prixUnite,$charge,$hauteurTravail,$largeur,
                      $longueur,$environnementTravail,$energie,$puissance,$poids,$ref,$quantite,$nomc,$id);

            }
        }
    }
} 

// Sélection et affichage du template PHTML.
$template = 'modifierProduits';
include 'layout.phtml';

?>