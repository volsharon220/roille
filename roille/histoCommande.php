<?php
session_start();
require('application/database.php');

if(isset($_SESSION['id_client'])){
    $userInfo=getIdClient($_SESSION['id_client']);
} 

$commandes=getCommande($userInfo['id_client']);

// Sélection et affichage du template PHTML.
$template = 'histoCommande';
include 'layout.phtml';