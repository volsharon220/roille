<?php
session_start();
require('application/database.php');



//code for Cart
if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
        //code for adding product in cart
        case "add":
            if(!empty($_POST["quantity"])) {
                $pid=$_GET["id_produit"];
                $con= mysqli_connect("127.0.0.1","root","","roille");
                 mysqli_query($con,"SET NAMES 'utf8'");
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
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	// code for if cart is empty
	case "empty":
		unset($_SESSION["cart_item"]);
	break;
    }
}

if(isset($_POST['commande'])){
    for ($i=0; $i<count($_SESSION['cart_item']); $i++) {
        addCommande($_SESSION["cart_item"][$i]["quantity"],
        $_SESSION["cart_item"][$i]["id_produit"],
        $_SESSION["cart_item"][$i]["dateD"],
        $_SESSION["cart_item"][$i]["dateF"]);
        echo 'enregistrer';
    }

}else{echo 'impossible';} 
//print_r($_SESSION);
print_r($_GET);
print_r($_SESSION["cart_item"]);
// Sélection et affichage du template PHTML.
$template = 'panier';
include 'layout.phtml';

?>