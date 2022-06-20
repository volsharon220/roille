<?php
session_start();
require('application/database.php');
if(isset($_SESSION['id_client'])){
    $userInfo=getIdClient($_SESSION['id_client']);
} 

$id=$_GET['id'];
$categories=getDetailCategorieById($id);
$categorie=$categories[0];


if(isset($_POST['envoyer'])){
   

    if(!empty($_POST) && isset($_POST)){

        $nomc=htmlspecialchars($_POST['nomc']);
        $descc=htmlspecialchars($_POST['descc']);
        if(isset($_FILES) && !empty($_FILES['imageCat']['name'])){
            $tmpName=$_FILES['imageCat']['tmp_name'];
            $name=$_FILES['imageCat']['name']; 
            
    
            $tabExtension=explode('.',$name);
            $extension=strtolower(end($tabExtension));
    
            $extensionValide=['jpg','png','jpeg','gif'];
            if(in_array($extension,$extensionValide)){
                $url=uniqid('',true);
                $file=$url.'.'.$extension;
    
                move_uploaded_file($tmpName,'image/'.$file);
                editeCategories($file,$nomc,$descc,$id);
                header('location:administration.php');
            }
        }
    }
}

// Sélection et affichage du template PHTML.
$template = 'modifierCategories';
include 'layout.phtml';