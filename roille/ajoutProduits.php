<?php


require('application/database.php');

$categories=listCategories();

if(isset($_POST['envoyer'])){
   

    if(!empty($_POST) && isset($_POST)){
 
        $nomp=htmlspecialchars($_POST['nomp']);
        $descpUn=htmlspecialchars($_POST['descpUn']);
        $descpDeux=htmlspecialchars($_POST['descpDeux']);
        $prixUnite=htmlspecialchars($_POST['prixUnite']);
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

        $errors=array();
       if(isset($_FILES) && !empty($_FILES['imageP']['name'])){

           if(!empty($nomp)){
               if(!empty($prixUnite)){
                   if(!empty($nomc)){
                       if(!empty($descpUn)){

                           $tmpName=$_FILES['imageP']['tmp_name'];
                               $name=$_FILES['imageP']['name']; 
                               
                       
                               $tabExtension=explode('.',$name);
                               $extension=strtolower(end($tabExtension));
                       
                               $extensionValide=['jpg','png','jpeg','gif'];
                       
                       
                               if(in_array($extension,$extensionValide)){
                                   $url=uniqid('',true);
                                   $file=$url.'.'.$extension;
                       
                                   move_uploaded_file($tmpName,'image/'.$file);
                                 
                                   addProduits($file,$nomp,$descpUn,$descpDeux,$prixUnite,$charge,
                                   $hauteurTravail,$largeur,$longueur,$environnementTravail,$energie,$puissance,
                                   $poids,$ref,$nomc);
                                   $succes='La catégorie est bien enregistrée !';
                                   unset($file);
                                   unset($nomp);
                                   unset($descpUn);
                                   unset($descpDeux);
                                   unset($prixUnite);
                                   unset($charge);
                                   unset($hauteurTravail);
                                   unset($largeur);
                                   unset($longueur);
                                   unset($environnementTravail);
                                   unset($energie);
                                   unset($puissance);
                                   unset($poids);
                                   unset($ref);
                                   unset($nomc);
                               }
                       }
                       else{
                           $errors['descpUn']="Entrez une description au produit à ajouter !";
                       }
                   }else{
                       $errors['nomc']="choisir une catégorie !";
                   }
               }else{
                   $errors['prixUnite']="Entrez le prix du produit à ajouter !";
               }

           }else{
               $errors['nomp']="Entrez le nom du produit à ajouter !";
           }
       }
       else{
           $errors['imageP']="Entrez l'image du produit à ajouter !";
       }
   }
}


// Sélection et affichage du template PHTML.
$template = 'ajoutProduits';
include 'layout.phtml';