

<?php

require('application/database.php');

if(isset($_POST['envoyer'])){
   

    if(!empty($_POST) && isset($_POST)){

        $nomc=htmlspecialchars($_POST['nomc']);
        $descc=htmlspecialchars($_POST['descc']);
        

        $errors=array();

            if(isset($_FILES) && !empty($_FILES['imageCat']['name'])){
                if(!empty($nomc)){
                    if(!empty($descc)){
                        $tmpName=$_FILES['imageCat']['tmp_name'];
                        $name=$_FILES['imageCat']['name']; 
                        
                
                        $tabExtension=explode('.',$name);
                        $extension=strtolower(end($tabExtension));
                
                        $extensionValide=['jpg','png','jpeg','gif'];
                
                
                        if(in_array($extension,$extensionValide)){
                            $url=uniqid('',true);
                            $file=$url.'.'.$extension;
                
                            move_uploaded_file($tmpName,'image/'.$file);
                
                            addCtegories($file,$nomc,$descc);
                            $succes='La catégorie est bien enregistrée !';
                        }
                    }else{
                        $errors['descc']='Entrez le déscription de la catégorie à ajouter !';
                    }
                }else{
                    $errors['nomc']='Entrez le nom de la catégorie à ajouter !';
                }    
            }else{
                $errors['imageCat']='Entrez une image de la catégorie à ajouter !';
            }
        }
    }


    // Sélection et affichage du template PHTML.
$template = 'ajoutCategories';
include 'layout.phtml';
