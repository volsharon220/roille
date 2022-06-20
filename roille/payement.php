
<?php
session_start();
require('application/database.php');

if(isset($_SESSION['id_client'])){
    $userInfo=getIdClient($_SESSION['id_client']);
} 



if(isset($_POST['envoyer']))
{
    if(!empty($_POST) && isset($_POST)){

    
        $nom=htmlspecialchars($_POST['name']);
        $code=htmlspecialchars($_POST['code']);
        $date=htmlspecialchars($_POST['date']);
        $cryptogramme=htmlspecialchars($_POST['cryptogramme']);

        
            $errors=array();
            
            if(!empty($nom)){
                if(!empty($code)){
                    if(!empty($date)){
                        if(!empty($cryptogramme)){
                                infosPayemnt($nom,$code,$date,$cryptogramme,$userInfo['id_client']);
                                $succes='Payement réussit ... !!';
                                unset($nom);
                                unset($code);
                                unset($date);
                                unset($cryptogramme);
                        }else{$errors['cryptogramme']="Entrez le cryptogramme ";}
                    }else{$errors['date']='Entrez votre date de naissance !';}
                }else{$errors['code']='Entrez le code de carte bleue !';}
            }else{$errors['name']='Entre votre nom !';}  
                                        
    }
}


// Sélection et affichage du template PHTML.
$template = 'payement';
include 'layout.phtml';
