<?php
session_start();
require('application/database.php');

if(isset($_SESSION['id_client'])){
    $userInfo=getIdClient($_SESSION['id_client']);
} 

$con= mysqli_connect("127.0.0.1","root","","roille");
mysqli_query($con,"SET NAMES 'utf8'");

//code for Cart
if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
        //code for adding product in cart
        case "add":
            if(!empty($_POST["quantity"])) {

                $pid=$_GET["id_produit"];
                
                $result=mysqli_query($con,"SELECT * FROM produit WHERE id_produit='$pid'");
                while($productByCode=mysqli_fetch_array($result))
                {
                    $itemArray = array(
                        $productByCode["id_produit"]=>array(
                            'id_produit'=>$productByCode["id_produit"],
                             'nomp'=>$productByCode["nomp"],
                             'ref'=>$productByCode["ref"],
                             'quantity'=>$_POST["quantity"],
                             'prixUnite'=>$productByCode["prixUnite"],
                             'dateD'=>$_POST["dateD"], 
                             'dateF'=>$_POST["dateF"],
                             'imagep'=>$productByCode["imagep"]
                        )
                    );
                      
                    
                        if(!empty($_SESSION["cart_item"])) 
                        {
                            if(in_array($productByCode["id_produit"],array_keys($_SESSION["cart_item"]))) 
                            {
                                foreach($_SESSION["cart_item"] as $k => $v) 
                                {
                                        if($productByCode["id_produit"] == $k) 
                                        {
                                            if(empty($_SESSION["cart_item"][$k]["quantity"])) 
                                            {
                                                $_SESSION["cart_item"][$k]["quantity"] = 0;
                                            }
                                            $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                                            
                                        }
                                }
                                
                            } else { $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);}
                            
                        } else { $_SESSION["cart_item"] = $itemArray;}
                }
                 
            }
           
        break;

	// code for removing product from cart
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["id_produit"] == $k)
						unset($_SESSION["cart_item"][$k]);
			}
		}
	break;
	// code for if cart is empty
	case "empty":
		unset($_SESSION["cart_item"]);
	break;
    }
}
$id=$_GET['id_produit'];

$stock=getDetailProduitsById($id);
        print_r($stock);
        $erreur=array();



        // and $stock['quantestock']>$_POST['quantity']
if(!empty($_SESSION["cart_item"]) and isset($_POST['commande'])) 
    { 
            foreach($_SESSION["cart_item"] as $k => $v) 
            { 
                $datD=$_SESSION["cart_item"][$k]["dateD"];
                $datF=$_SESSION["cart_item"][$k]["dateF"];
                 // requete qui vérifie la disponibiilté des dates de réservation d'un matériel
                 $reqD="SELECT * FROM detail_com WHERE id_produit='$id' and '$datD' between dateD and dateF";
                $resultD=mysqli_query($con,$reqD);

                $reqF="SELECT * FROM detail_com WHERE id_produit='$id' and '$datF' between dateD and dateF";
                $resultF=mysqli_query($con,$reqF);

                print_r( $resultD);
                print_r( $resultF);

                if($stock['quantestock'] > $_SESSION["cart_item"][$k]["quantity"])
                {
                    if(mysqli_num_rows($resultD) ==0){
                        if(mysqli_num_rows($resultF)==0){

                            addCommande(
                                $_SESSION["cart_item"][$k]["quantity"],
                                $_SESSION["cart_item"][$k]["id_produit"],
                                $_SESSION["cart_item"][$k]["dateD"],
                                $_SESSION["cart_item"][$k]["dateF"],
                                $userInfo['id_client']
                                );
                                header("refresh:3;url=payement.php");
                            
                            print_r( $_SESSION["cart_item"][$k]["dateD"]);
                        }else{$erreur['dateF']="Ce matériel n'est pas disponible pour cette date";}
                    }else{$erreur['dateD']="Ce matériel n'est pas disponible pour cette date";}
                }
                else{ $erreur['quantestock']=
                    'seulement "'.$stock['quantestock'].'" pièces sont disponibles dans l\'immédiat.';}
        }
        
    } 
    
  


/*if(isset($_POST['louer'])){
    $pdo=createconnection();
        $req=$pdo->prepare('SELECT id_produit,quantestock FROM produit where id_produit=?');
        $req->execute(array($id));
        $idUser=$req->fetch(PDO::FETCH_ASSOC);

        $stock=array();
        $a=$idUser['id_produit'];
        $b=$_POST['dateD'];
        $c=$_POST['dateF'];
        if("call reservation('$a','$b','$c')"){
            $_SESSION['id_client']=$a;
            $_SESSION['dateD']=$a;
            $_SESSION['dateF']=$a;
            header('location:panier.php?action=add&id_produit='.$idUser["id_produit"]);
            echo "est dispo";

/*
            $requete=$pdo->prepare('SELECT erreur FROM Erreur');
            $requete->execute(array());
            $erreur=$requete->fetch(PDO::FETCH_ASSOC);
            if($erreur['erreur']){
               // header('location:panier.php?action=add&id_produit='.$idUser["id_produit"]);
                echo "zst dispo";
            }
            */
      /*  }else{echo $erreur['erreur'];}
        
        if($idUser['quantestock']<$_POST['quantity']){
            $stock['quantestock']= 'seulement "'.$idUser['quantestock'].'" pièces sont disponibles dans l\'immédiat.';
            
        }

    }

    */







//print_r($_SESSION);
// Sélection et affichage du template PHTML.
$template = 'panier';
include 'layout.phtml';

?>