<?php
session_start();
require('application/database.php');

$id=$_GET['id_produit'];

$produit=getDetailProduitById($id);
$categories=listCategories();
if(isset($_POST['louer'])){
    $pdo=createconnection();
        $req=$pdo->prepare('SELECT id_produit,quantestock FROM produit where id_produit=?');
        $req->execute(array($id));
        $idUser=$req->fetch(PDO::FETCH_ASSOC);

        $stock=array();
        
        
        if($idUser['quantestock']<$_POST['quantity']){
            $stock['quantestock']= 'seulement "'.$idUser['quantestock'].'" pièces sont disponibles dans l\'immédiat.';
            
        }
        else{


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

                        }
?>
                        <!-- Cart ---->
<div id="shopping-cart">

<a id="btnEmpty" href="?action=empty">Vider le panier</a>
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>	
<table class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;">Name</th>
<th style="text-align:left;">Code</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right;" width="10%">date de début</th>
<th style="text-align:right;" width="10%">date de fin</th>
<th style="text-align:right;" width="10%">Price</th>
<th style="text-align:center;" width="5%">Remove</th>
</tr>	
<?php		
    foreach ($_SESSION["cart_item"] as $item){
				$dateD = new DateTime($item["dateD"]);
				$dateF = new DateTime($item["dateF"]);
				$diff = $dateF->diff($dateD)->format("%a");
print_r($diff);
		$item_price =($item["prixUnite"]*($item["quantity"]*$diff));
  
		?>
			<tr>
				<td>
					<img src="<?php echo $item["imagep"]; ?>" class="cart-item-image" /><?php echo $item["nomp"]; ?>
				</td>
				<td>
					<?php echo $item["ref"]; ?>
				</td>
				<td style="text-align:right;">
					<?php echo $item["quantity"]; ?>
				</td>
				<td  style="text-align:right;">
					<?php echo "$ ".$item["prixUnite"]; ?>
				</td>
				<td  style="text-align:right;">
					<?php echo "$ ".$item["dateD"]; ?>
				</td>
				<td  style="text-align:right;">
					<?php echo "$ ".$item["dateF"]; ?>
				</td>
				<td  style="text-align:right;">
					<?php echo "$ ". number_format($item_price,2); ?>
				</td>
				<td style="text-align:center;">
					<a href="?action=remove&id_produit=<?php echo $item["id_produit"]; ?>"
				 	class="btnRemoveAction"><img src="image/icon-delete.png" alt="Remove Item" /></a>
				</td>
			</tr>
				<?php

				
				$total_quantity += $item["quantity"];
				$total_price += ($item["prixUnite"]*($item["quantity"]*$diff));
		}
		?>

<tr>
<td colspan="2" align="right">Total:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>		
  <?php
} else {
?>
<div class="no-records">le panier est vide</div>
<?php 
}
?>
<form action="" method="post">
	<input type="submit" value="commander" name="commande">
</form>

</div>
<?php
        }
print_r($_POST);
// Sélection et affichage du template PHTML.
$template = 'detailsProduits';
include 'layout.phtml';