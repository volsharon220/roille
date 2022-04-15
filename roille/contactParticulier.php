<?php
require('application/database.php');
if(isset($_POST['envoyer']))
{
    if(!empty($_POST) && isset($_POST)){

    
        $nom=htmlspecialchars($_POST['nom']);
        $prenom=htmlspecialchars($_POST['prenom']);
        $mdp=htmlspecialchars($_POST['mdp']);
        $addresse=htmlspecialchars($_POST['addresse']);
        $codeP=htmlspecialchars($_POST['codeP']);
        $ville=htmlspecialchars($_POST['ville']);
        $pays=htmlspecialchars($_POST['pays']);
        $phone=htmlspecialchars($_POST['phone']);
        $mail=htmlspecialchars($_POST['mail']);

        
        $majuscule = preg_match('@[A-Z]@', $mdp);
        $minuscule = preg_match('@[a-z]@', $mdp);
        $chiffre = preg_match('@[0-9]@', $mdp);

        
            $errors=array();
            
            if(!empty($nom)){
                if(!empty($prenom)){
                    if(!empty($mdp)){
                        if(strlen($mdp)>=8){
                            if($majuscule){
                                if($minuscule){
                                    if($chiffre){
                                        if(!empty($addresse)){
                                            if(!empty($codeP)){
                                                if(!empty($ville)){
                                                    if(!empty($pays)){
                                                        if(!empty($phone)){
                                                            if(preg_match("#^\d{6,10}$#",$phone)){
                                                                if(!empty($mail)){
                                                                    if(filter_var($mail,FILTER_VALIDATE_EMAIL) && !preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9].[a-z]{2,4}$#", $mail)){
                                                                        $pdo=createconnection();
                                                                        $req=$pdo->prepare('SELECT mail FROM client WHERE mail=?');
                                                                        $req->execute(array($mail));
                                                                        $emailExite=$req->rowCount();
                                                                        if($emailExite==0){
                                                                            registerParticulier($nom,$prenom,$mdp,$addresse,$codeP,$ville,$pays,$phone,$mail);
                                                                                    $succes='Votre compte à bien été créer !!';
                                                                                    unset($nom);
                                                                                    unset($mdp);
                                                                                    unset($birth_date);
                                                                                    unset($addresse);
                                                                                    unset($codeP);
                                                                                    unset($ville);
                                                                                    unset($pays);
                                                                                    unset($phone);
                                                                                    unset($mail);
                                                                        }else{$errors['mail']="Votre mail existe déjà !!";}
                                                                    }else{$errors['mail']="Votre mail n'est pas valide!!";}
                                                                }else{$errors['mail']="Entrez votre mail !!";}
                                                            }else{$errors['phone']="Votre numéro de téléphone n'ets pas valide !!";}
                                                        }else{$errors['phone']='Entrez votre téléphone mobile !!';}
                                                    }else{$errors['pays']='Entrez votre pays de résidence !!';}
                                                }else{$errors['ville']='Entrez votre ville !!';}
                                            }else{$errors['codeP']='Entrez votre code postale !!';}
                                        }else{$errors['addresse']='Entrez votre adresse !!';}
                                    }else{$error['mdp']="doit contenir des chiffres";}
                                }else{$error['mdp']="doit contenir des minuscules";}
                            }else{$error['mdp']="doit contenir des majuscules";}
                        }else{$error['mdp']="Votre mot de passe doit contenir au moins 8 caractéres";}
                    }else{$errors['mdp']='Entrez votre mot de passe';}
                }else{$errors['prenom']='Entre votre prénom !';}
            }else{$errors['nom']='Entre votre nom !';}  
                                        
    }
}



// Sélection et affichage du template PHTML.
$template = 'contactParticulier';
include 'layout.phtml';
?>


<?php
/*
$id= mysqli_connect("127.0.0.1","root","","roille");
        $connect= mysqli_query($id,"SET NAMES 'utf8'");
        $req="select * from particulier";
        $result=mysqli_query($id,$req);
        $lignes=mysqli_fetch_assoc($result);


$carac= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$combLen=strlen($comb) - 1;
 $mdp = array();  
 for ($i = 0; $i < 10; $i++) {
     $n = rand(0, $combLen);
     $mdp[] = $lignes['nom'].upper(substr($lignes['prenom']).$carac[$n];
 }
 print(implode($mdp)); 



 $date=diff(curdate(),$ligne['date']);
 if($date>=90){

 }

?>
*/