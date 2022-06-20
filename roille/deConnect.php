<?php 	

session_start();
echo "Deconnexion en cours.....";

$id=mysqli_connect("localhost", "root","","roille");
 	mysqli_query($id,"SET NAMES 'utf8'");

$requete ="select max(id_log) max from histoConnexion";
$reponse = mysqli_query($id, $requete);
$ligne = mysqli_fetch_assoc($reponse);
$idlogin = $ligne["max"];

$requete = "UPDATE histoConnexion set `dateF`= now() where id_log = '$idlogin'";
$reponse1 = mysqli_query($id, $requete);


session_destroy();
header("refresh:3;url=index.php"); 

?>