<?php


require('database.php');

$categories=listCategories();

if(isset($_POST['envoyer'])){
   

    if(!empty($_POST) && isset($_POST)){

        $nomp=htmlspecialchars($_POST['nomp']);
        $descpUn=htmlspecialchars($_POST['descpUn']);
        $descpDeux=htmlspecialchars($_POST['descpDeux']);
        $prixUnite=htmlspecialchars($_POST['prixUnite']);
        $charge=htmlspecialchars($_POST['charge']);
        $hauteurTravail=htmlspecialchars($_POST['hauteurTravail']);
        $largeur=htmlspecialchars($_POST['largeur']);
        $longueur=htmlspecialchars($_POST['longueur']);
        $environnementTravail=htmlspecialchars($_POST['environnementTravail']);
        $energie=htmlspecialchars($_POST['energie']);
        $puissance=htmlspecialchars($_POST['puissance']);
        $poids=htmlspecialchars($_POST['poids']);
        $ref=htmlspecialchars($_POST['ref']);
        $nomc=htmlspecialchars($_POST['nomc']);

        $errors=array();
        if(isset($_FILES) && !empty($_FILES['imageP']['name'])){

            if(!empty($nomp)){
                if(!empty($prixUnite)){
                    if(!empty($nomc)){
                        if(!empty($descpUn)){

                            $tmpName=$_FILES['imageP']['tmp_name'];
                                $name=$_FILES['imageP']['name']; 
                                
                        
                                $tabExtension=explode('.',$name);
                                $extension=strtolower(end($tabExtension));
                        
                                $extensionValide=['jpg','png','jpeg','gif'];
                        
                        
                                if(in_array($extension,$extensionValide)){
                                    $url=uniqid('',true);
                                    $file=$url.'.'.$extension;
                        
                                    move_uploaded_file($tmpName,'image/'.$file);
                                  
                                    addProduits($file,$nomp,$descpUn,$descpDeux,$prixUnite,$charge,
                                    $hauteurTravail,$largeur,$longueur,$environnementTravail,$energie,$puissance,
                                    $poids,$ref,$nomc);
                                    $succes='La catégorie est bien enregistrée !';
                                    unset($file);
                                    unset($nomp);
                                    unset($descpUn);
                                    unset($descpDeux);
                                    unset($prixUnite);
                                    unset($charge);
                                    unset($hauteurTravail);
                                    unset($largeur);
                                    unset($longueur);
                                    unset($environnementTravail);
                                    unset($energie);
                                    unset($puissance);
                                    unset($poids);
                                    unset($ref);
                                    unset($nomc);
                                }
                        }
                        else{
                            $errors['descpUn']="Entrez une description au produit à ajouter !";
                        }
                    }else{
                        $errors['nomc']="choisir une catégorie !";
                    }
                }else{
                    $errors['prixUnite']="Entrez le prix du produit à ajouter !";
                }

            }else{
                $errors['nomp']="Entrez le nom du produit à ajouter !";
            }
        }
        else{
            $errors['imageP']="Entrez l'image du produit à ajouter !";
        }
    }
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <div>                                      
         <input type="file" name="imageP" placeholder="Entrez une image" value='<?php if(isset($file)) echo $file; ?>'><br>
         <div>
            <?php if(!empty($errors['imageP'])) :?>
                <p class='erreur'><?= $errors['imageP']; ?></p>
            <?php endif; ?>
         </div>
    </div>
    
    <div>
        <input type="text" name="nomp" placeholder="Entrez le nom du produit" value='<?php if(isset($nomp)) echo $nomp; ?>'><br>
        <div>
            <?php if(!empty($errors['nomp'])) :?>
                <p class='erreur'><?= $errors['nomp']; ?></p>
            <?php endif; ?>
        </div>
    </div>                                    
    <div>
        <input type="text" name="prixUnite" placeholder="Entrez le prix " value='<?php if(isset($prixUnite)) echo $prixUnite; ?>'><br>
        <div>
            <?php if(!empty($errors['prixUnite'])) :?>
                <p class='erreur'><?= $errors['prixUnite']; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div>
        <select name="nomc">
            <?php foreach($categories as $categorie) : ?>
                <option value="<?= $categorie['nom'] ?>"><?= $categorie['nom'] ?></option>
            <?php endforeach;?>
        </select>
        <div>
            <?php if(!empty($errors['nomc'])) :?>
                <p class='erreur'><?= $errors['nomc']; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div>
        <textarea name="descpUn" id="" cols="30" rows="10" placeholder='Entrez la description du produit' value='<?php if(isset($descpUn)) echo $descpUn; ?>'></textarea>
        <div>
             <?php if(!empty($errors['descpUn'])) :?>
                <p class='erreur'><?= $errors['descpUn']; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div>
        <textarea name="descpDeux" id="" cols="30" rows="10" placeholder='Entrez la description du produit' value='<?php if(isset($descpDeux)) echo $descpDeux; ?>'></textarea>
        <div>
             <?php if(!empty($errors['descpDeux'])) :?>
                <p class='erreur'><?= $errors['descpDeux']; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div>
        <input type="text" name="charge" placeholder="Entrez la charge du produit" value='<?php if(isset($charge)) echo $charge; ?>'><br>
        <div>
            <?php if(!empty($errors['charge'])) :?>
                <p class='erreur'><?= $errors['charge']; ?></p>
            <?php endif; ?>
        </div>
    </div> 

    <div>
        <input type="text" name="hauteurTravail" placeholder="Entrez la hauteur de travail" value='<?php if(isset($hauteurTravail)) echo $hauteurTravail; ?>'><br>
        <div>
            <?php if(!empty($errors['hauteurTravail'])) :?>
                <p class='erreur'><?= $errors['hauteurTravail']; ?></p>
            <?php endif; ?>
        </div>
    </div> 
    <div>
        <input type="text" name="largeur" placeholder="Entrez la largeur" value='<?php if(isset($largeur)) echo $largeur; ?>'><br>
        <div>
            <?php if(!empty($errors['largeur'])) :?>
                <p class='erreur'><?= $errors['largeur']; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div>
        <input type="text" name="longueur" placeholder="Entrez la longueur" value='<?php if(isset($longueur)) echo $longueur; ?>'><br>
        <div>
            <?php if(!empty($errors['longueur'])) :?>
                <p class='erreur'><?= $errors['longueur']; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div>
        <input type="text" name="environnementTravail" placeholder="Entrez l'environnement du travail'" value='<?php if(isset($environnementTravail)) echo $environnementTravail; ?>'><br>
        <div>
            <?php if(!empty($errors['environnementTravail'])) :?>
                <p class='erreur'><?= $errors['environnementTravail']; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div>
        <input type="text" name="energie" placeholder="Entrez l'energie'" value='<?php if(isset($energie)) echo $energie; ?>'><br>
        <div>
            <?php if(!empty($errors['energie'])) :?>
                <p class='erreur'><?= $errors['energie']; ?></p>
            <?php endif; ?>
        </div>
    </div>
    
    <div>
        <input type="text" name="puissance" placeholder="Entrez la puissance" value='<?php if(isset($puissance)) echo $puissance; ?>'><br>
        <div>
            <?php if(!empty($errors['puissance'])) :?>
                <p class='erreur'><?= $errors['puissance']; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div>
        <input type="text" name="poids" placeholder="Entrez le poids" value='<?php if(isset($poids)) echo $poids; ?>'><br>
        <div>
            <?php if(!empty($errors['poids'])) :?>
                <p class='erreur'><?= $errors['poids']; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div>
        <input type="text" name="ref" placeholder="Entrez la ref" value='<?php if(isset($ref)) echo $ref; ?>'><br>
        <div>
            <?php if(!empty($errors['ref'])) :?>
                <p class='erreur'><?= $errors['ref']; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div>
        <?php if(!empty($succes)) :?>
                <p class='erreur'><?= $succes; ?></p>
            <?php endif; ?>
    </div>
    <input type="submit" value="envoyer" name="envoyer"><br>
    
</form>