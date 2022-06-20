<?php
session_start();
include("application/database.php");

   
   if(isset($_SESSION['id_client'])){
       $userInfo=getIdClient($_SESSION['id_client']);
   }     

$profilUserParc=getIdClientParc($_SESSION['id_client']);
$profilUserPro=getIdClientPro($_SESSION['id_client']);

if(isset($_POST['envoyer'])){
    $num=htmlspecialchars($_POST['numId']);
    $nom=htmlspecialchars($_POST['nom']);
    $addresse=htmlspecialchars($_POST['addresse']);
    $mdp=htmlspecialchars($_POST['mdp']);
    $codeP=htmlspecialchars($_POST['codeP']);
    $ville=htmlspecialchars($_POST['ville']);
    $pays=htmlspecialchars($_POST['pays']);
    $phone=htmlspecialchars($_POST['phone']);
    $mail=htmlspecialchars($_POST['mail']);
   
    
    if(isset($profilUserPro['id_client']) and $num==$profilUserPro['id_client']){
        
        $statuJ=htmlspecialchars($_POST['stautJ']);
        $numS=htmlspecialchars($_POST['siret']);

        $errors=array();
if(isset($_FILES['newPicturs']) && !empty($_FILES['newPicturs']['name'])){
     
        // taille maximal 2 Mo
        $tailleMax= 2097152;

        //Les extensions valide
        $extensionValide=array('jpg');


        if($_FILES['newPicturs']['size'] <=$tailleMax){
            $pictur=$_FILES['newPicturs']['name'];

            // extraire l'extension de l'image telecharger
             $extensionUpload=strtolower(substr(strrchr($pictur,'.'),1));

             //verifier si l'extension est bien valide
            if(in_array($extensionUpload,$extensionValide)){
            
            //chemin de stockage de l'image telecharger
            $chemin='image/utilisateur/'.$_SESSION['id_client'].'.'.$extensionUpload;
            $filName=$_FILES['newPicturs']['tmp_name'];
            //taille de l'image
            $size=getimagesize($filName);

                    //deplacer l'image dans le nouveau dossier
                    $result=move_uploaded_file($filName,$chemin);
                    if($result){
                        //creer une nouvelle image
                        $image=imagecreatefromjpeg($chemin);
                        $width=imagesx($image); //largeur de l'image telecharger
                        $height=imagesy($image); //langueur de l'image telecharger
                        $new_width=150;//largeur de la nouvelle image
                        $new_height=150; //langueur de la nouvelle image

                        //attribuer les nouvelles dimensions a l'image creer
                        $thumb=imagecreatetruecolor($new_width,$new_height);
                        imagecopyresized ($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
                        imagejpeg($thumb,$chemin);
                        //supprimer l'image telecharger
                        imagedestroy($image);
                        
                            modifClientPro($userInfo['id_client'].'.'.$extensionUpload,$nom,$addresse,$mdp,
                                            $codeP,$ville,$pays,$phone,$mail,$statuJ,$numS,$_SESSION['id_client']);
                            header('Location:profil.php?id='.$_SESSION['id_client']);
                        
                    }
                    else{$errors['newPicturs']="Une erreur s'est produite lors de téléchargement de votre photo !!";}
            }
            else{$errors['newPicturs']='Votre photo doit etre au format jpg, jpeg, png ou gif !!';}
        }
        else{$errors['newPicturs']='Votre photo ne doit pas depasser 5 Mo !!';}

    }




        
    }
    elseif(isset($profilUserParc['id_client']) and $num==$profilUserParc['id_client']){

            $prenom=htmlspecialchars($_POST['prenom']);
            $errors=array();
        if(isset($_FILES['newPicturs']) && !empty($_FILES['newPicturs']['name'])){
        
            $tailleMax= 2097152; // taille maximal 2 Mo
            $extensionValide=array('jpg');
            if($_FILES['newPicturs']['size'] <=$tailleMax){
                $pictur=$_FILES['newPicturs']['name'];
                $extensionUpload=strtolower(substr(strrchr($pictur,'.'),1));
                if(in_array($extensionUpload,$extensionValide)){
                    $chemin='image/utilisateur/'.$_SESSION['id_client'].'.'.$extensionUpload;
                    $filName=$_FILES['newPicturs']['tmp_name'];
                    $size=getimagesize($filName);
                        $result=move_uploaded_file($filName,$chemin);
                        if($result){
                            $image=imagecreatefromjpeg($chemin);
                            $width=imagesx($image);
                            $height=imagesy($image);
                            $new_width=150;
                            $new_height=150;
                            $thumb=imagecreatetruecolor($new_width,$new_height);
                            imagecopyresized ($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
                            imagejpeg($thumb,$chemin);
                            imagedestroy($image);
                            
                                modifClientParc($userInfo['id_client'].'.'.$extensionUpload,$nom,$prenom,$mdp,$addresse,
                                $codeP,$ville,$pays,$phone,$mail,$_SESSION['id_client']);
                                header('Location:profil.php?id='.$_SESSION['id_client']);
                        }
                        else{$errors['newPicturs']="Une erreur s'est produite lors de téléchargement de votre photo !!";}
                }
                else{$errors['newPicturs']='Votre photo doit etre au format jpg, jpeg, png ou gif !!';}
            }
            else{$errors['newPicturs']='Votre photo ne doit pas depasser 5 Mo !!';}

    }

    }
    
}
  // Sélection et affichage du template PHTML.
$template = 'modifierProfil';
include 'layout.phtml';