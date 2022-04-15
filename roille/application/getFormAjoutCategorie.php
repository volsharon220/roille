<?php

require('database.php');

if(isset($_POST['envoyer'])){
   

    if(!empty($_POST) && isset($_POST)){

        $nomc=htmlspecialchars($_POST['nomc']);
        $descc=htmlspecialchars($_POST['descc']);
        

        $errors=array();

            if(isset($_FILES) && !empty($_FILES['imageCat']['name'])){
                if(!empty($nomc)){
                    if(!empty($descc)){
                        $tmpName=$_FILES['imageCat']['tmp_name'];
                        $name=$_FILES['imageCat']['name']; 
                        
                
                        $tabExtension=explode('.',$name);
                        $extension=strtolower(end($tabExtension));
                
                        $extensionValide=['jpg','png','jpeg','gif'];
                
                
                        if(in_array($extension,$extensionValide)){
                            $url=uniqid('',true);
                            $file=$url.'.'.$extension;
                
                            move_uploaded_file($tmpName,'image/'.$file);
                
                            addCtegories($file,$nomc,$descc);
                            $succes='La catégorie est bien enregistrée !';
                        }
                    }else{
                        $errors['descc']='Entrez le déscription de la catégorie à ajouter !';
                    }
                }else{
                    $errors['nomc']='Entrez le nom de la catégorie à ajouter !';
                }    
            }else{
                $errors['imageCat']='Entrez une image de la catégorie à ajouter !';
            }
        }
    }
?>

    <form action="" method="post" enctype="multipart/form-data">

    <div>
         <input type="file" name="imageCat" placeholder="Entrez une image" value='<?php if(isset($name)) echo $name; ?>'><br>
         <div>
            <?php if(!empty($errors['imageCat'])) :?>
                <p class='erreur'><?= $errors['imageCat']; ?></p>
            <?php endif; ?>
         </div>
    </div>
    
    <div>
        <input type="text" name="nomc" placeholder="Entrez le nom de la catégorie" value='<?php if(isset($nomc)) echo $nomc; ?>'><br>
        <div>
            <?php if(!empty($errors['nomc'])) :?>
                <p class='erreur'><?= $errors['nomc']; ?></p>
            <?php endif; ?>
        </div>
    </div>
   
    <div>
        <textarea name="descc" id="" cols="30" rows="10" placeholder='Entrez la description de la catégorie' value='<?php if(isset($descc)) echo $descc; ?>'></textarea>
        <div>
             <?php if(!empty($errors['descc'])) :?>
                <p class='erreur'><?= $errors['descc']; ?></p>
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