<?php
// Vérifier si les cookies existe 
// l'utilisateur se connecte automatiquement

    if(!isset($_SESSION['id_user']) 
        && isset($_COOKIE['email']) && isset($_COOKIE['password'])
        && !empty($_COOKIE['email']) && !empty($_COOKIE['password'])){
        
        $pdo=createconnection();
        $req=$pdo->prepare('SELECT * FROM `users` WHERE `e_mail`=? AND `password`=?');
        $req->execute(array($_COOKIE['email'],$_COOKIE['password']));
        $userExist=$req->rowCount();
    
        if($userExist==1){
    
                $userConnect=$req->fetch();
                $_SESSION['id_user']=$userConnect['id_user'];
                $_SESSION['password']=$userConnect['password'];
                $_SESSION['e_mail']=$userConnect['e_mail'];
    }
        }
    
?>