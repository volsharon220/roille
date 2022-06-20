<?php

function createconnection(){
    
    $pdo=new PDO('mysql:host=localhost;dbname=roille;charset=utf8','root','');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
function registerParticulier($nom,$prenom,$mdp,$addresse,$codeP,$ville,$pays,$phone,$mail){
    $pdo=createconnection();
    $req=$pdo->prepare("INSERT INTO particulier (avatar,nom,prenom,mdp,addresse,codeP,ville,
                        pays,phone,mail)
                        values (null,:nom,:prenom,:mdp,:addresse,:codeP,:ville,:pays,:phone,
                        :mail)");
    $req->execute(array(
        ':nom'=>$nom,
        ':prenom'=>$prenom,
        ':mdp'=>$mdp,
        ':addresse'=>$addresse,
        ':codeP'=>$codeP,
        ':ville'=>$ville,
        ':pays'=>$pays,
        ':phone'=>$phone,
        ':mail'=>$mail
    ));                      
}

function registerProfessionnel($nom,$mdp,$addresse,$codeP,$ville,$pays,$phone,$mail,$numSiret,
                                $statut_juridique){
    $pdo=createconnection();
    $req=$pdo->prepare("INSERT INTO professionnel 
                        (avatar,nom,mdp,addresse,codeP,ville,pays,phone,mail,numSiret,
                        statut_juridique)
                        values (null,:nom,:mdp,:addresse,:codeP,:ville,:pays,:phone,:mail,
                        :numSire,:statut_jurid)");
    $req->execute(array(
        ':nom'=>$nom,
        ':mdp'=>$mdp,
        ':addresse'=>$addresse,
        ':codeP'=>$codeP,
        ':ville'=>$ville,
        ':pays'=>$pays,
        ':phone'=>$phone,
        ':mail'=>$mail,
        ':numSire'=>$numSiret,
        ':statut_jurid'=>$statut_juridique
    ));                      
}


function addCtegories($imagec,$nomc,$descc){
    $pdo=createconnection();
    $req=$pdo->prepare("INSERT INTO categories (imagec,nom,descc) values (:imagec,:nomc,:descc)");
    $req->execute(array(
        ':imagec'=>$imagec,
        ':nomc'=>$nomc,
        ':descc'=>$descc
    ));    
}

function listCategories(){
    $pdo=createconnection();
    $req=$pdo->prepare('SELECT * FROM categories');

    $req->execute();
    $details=$req->fetchAll(PDO::FETCH_ASSOC);
    return $details;
}
     

function addProduits($image,$nomp,$descpUn,$descpDeux,$prixUnite,$charge,$hauteurTravail,$largeur,$longueur,
                    $environnementTravail,$energie,$puissance,$poids,$ref,$quantestock,$nomc){
    $pdo=createconnection();
    $req=$pdo->prepare("INSERT INTO produit (imagep,nomp,descpUn,descpDeux,prixUnite,charge,hauteurTravail,
                        largeur,longueur,environnementTravail,energie,puissance,poids,ref,quantestock,nomcat) 
                        values (:imagep,:nomp,:descpUn,:descpDeux,:prixUnite,:charge,:hauteurTravail,:largeur,
                        :longueur,:environnementTravail,:energie,:puissance,:poids,:ref,:quantestock,:nomc)");
    $req->execute(array(
        ':imagep'=>$image,
        ':nomp'=>$nomp,
        ':descpUn'=>$descpUn,
        ':descpDeux'=>$descpDeux,
        ':prixUnite'=>$prixUnite,
        ':charge'=>$charge,
        ':hauteurTravail'=>$hauteurTravail,
        ':largeur'=>$largeur,
        ':longueur'=>$longueur,
        ':environnementTravail'=>$environnementTravail,
        ':energie'=>$energie,
        ':puissance'=>$puissance,
        ':poids'=>$poids,
        ':ref'=>$ref,
        ':quantestock'=>$quantestock,
        ':nomc'=>$nomc
    ));    
}


function infosPayemnt($nom,$code,$date,$cryptogramme,$id){
    $pdo=createconnection();
    $req=$pdo->prepare("INSERT INTO payment (nom,code,dateNaissance,crypto,id_client) 
                                            values (:nom,:code,:dateNaissance,:crypto,:id_client)");
    $req->execute(array(
        ':nom'=>$nom,
        ':code'=>$code,
        ':dateNaissance'=>$date,
        ':crypto'=>$cryptogramme,
        ':id_client'=>$id
    ));    
}


function listProduits(){
    $pdo=createconnection();
    $req=$pdo->prepare('SELECT * FROM produit');

    $req->execute();
    $details=$req->fetchAll(PDO::FETCH_ASSOC);
    return $details;
}

function listParticulier(){
    $pdo=createconnection();
    $req=$pdo->prepare('SELECT * FROM particulier');

    $req->execute();
    $details=$req->fetchAll(PDO::FETCH_ASSOC);
    return $details;
}

function listProfessionnel(){
    $pdo=createconnection();
    $req=$pdo->prepare('SELECT * FROM professionnel');

    $req->execute();
    $details=$req->fetchAll(PDO::FETCH_ASSOC);
    return $details;
}

function getListProduitById($nomc){
    $pdo=createconnection();
    $req=$pdo->prepare('SELECT * FROM produit WHERE nomcat=?');

    $req->execute(array($nomc));
    $details=$req->fetchAll(PDO::FETCH_ASSOC);
    return $details;
}

//requete qui permet de recuperer le detail d'un produit
function getDetailProduitById($id){
    $pdo=createconnection();
    $req=$pdo->prepare('SELECT * FROM produit WHERE id_produit=?');

    $req->execute(array($id));
    $details=$req->fetchAll(PDO::FETCH_ASSOC);
    return $details;
}

//requete qui permet de recuperer un produit par rapport a son id dans le ficchier panier.php
function getDetailProduitsById($id){
    $pdo=createconnection();
    $req=$pdo->prepare('SELECT * FROM produit WHERE id_produit=?');

    $req->execute(array($id));
    $details=$req->fetch(PDO::FETCH_ASSOC);
    return $details;
}



function getDetailCategorieById($id){
    $pdo=createconnection();
    $req=$pdo->prepare('SELECT * FROM categories WHERE id_categorie=?');

    $req->execute(array($id));
    $details=$req->fetchAll(PDO::FETCH_ASSOC);
    return $details;
}


function maxId(){
    $pdo=createconnection();
    $req=$pdo->prepare("select max(id_com) from detail_com");

    $req->execute(array());
    $details=$req->fetch(PDO::FETCH_ASSOC);
    return $details;
}



function addCommande($quantite_com,$idProduit,$dateDebut,$dateFin,$id_client){
    $pdo=createconnection();
    $req=$pdo->prepare("INSERT INTO detail_com (quantite_com,id_produit,dateD,dateF,id_client) 
                        values (:quantite_com,:id_produit,:dateD,:dateF,:id_client)");
    $req->execute(array(
        ':quantite_com'=>$quantite_com,
        ':id_produit'=>$idProduit,
        ':dateD'=>$dateDebut,
        ':dateF'=>$dateFin,
        ':id_client'=>$id_client
    ));    
}


function getCommande($id){
    $pdo=createconnection();
    $req=$pdo->prepare('SELECT * FROM commande c,detail_com d,produit p 
                        WHERE c.id_com=? and d.id_produit=p.id_produit and d.id_com=c.id_com');
    $req->execute(array($id));
    $result=$req->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}


function getIdClient($id){
    $pdo=createconnection();
    $req=$pdo->prepare('SELECT * FROM client WHERE `id_client`=?');
    $req->execute(array($id));
    $idUser=$req->fetch(PDO::FETCH_ASSOC);
    return $idUser;
}
function getIdClientParc($id){
    $pdo=createconnection();
    $req=$pdo->prepare('SELECT * FROM particulier WHERE `id_client`=?');
    $req->execute(array($id));
    $idUser=$req->fetch(PDO::FETCH_ASSOC);
    return $idUser;
}

function getIdClientPro($id){
    $pdo=createconnection();
    $req=$pdo->prepare('SELECT * FROM professionnel WHERE `id_client`=?');
    $req->execute(array($id));
    $idUser=$req->fetch(PDO::FETCH_ASSOC);
    return $idUser;
}


function modifClientParc($avatar,$nom,$prenom,$mdp,$addresse,$codeP,$ville,$pays,$phone,$mail,
                        $id){
    $pdo=createconnection();
        $req=$pdo->prepare('UPDATE particulier SET avatar=?,nom=?,prenom=?,mdp=?,addresse=?,
                            codeP=?,ville=?,pays=?,
                            phone=?,mail=? WHERE id_client=?');
        $req->execute(array($avatar,$nom,$prenom,$mdp,$addresse,$codeP,$ville,$pays,$phone,
                            $mail,$id));
}

function modifClientPro($avatar,$nom,$addresse,$mdp,$codeP,$ville,$pays,$phone,$mail,$statuJ,
                        $numS,$id){
    $pdo=createconnection();
        $req=$pdo->prepare('UPDATE professionnel SET avatar=?,nom=?,mdp=?,addresse=?,codeP=?,
                            ville=?,pays=?,
                            phone=?,mail=?,numSiret=?,statut_juridique=? WHERE id_client=?');
        $req->execute(array($avatar,$nom,$addresse,$mdp,$codeP,$ville,$pays,$phone,$mail,
                            $statuJ,$numS,$id));
}


function deleteProduit($id){
    $pdo=createconnection();
    $req=$pdo->prepare('delete from produit where id_produit=?');
    $req->execute(array($id));
}


function deleteCategories($id){
    $pdo=createconnection();
    $req=$pdo->prepare('delete from categories where id_categorie=?');
    $req->execute(array($id));
}

function deleteClientParticulier($id){
    $pdo=createconnection();
    $req=$pdo->prepare('delete from particulier where id_client=?');
    $req->execute(array($id));
}

function deleteClientPro($id){
    $pdo=createconnection();
    $req=$pdo->prepare('delete from professionnel where id_client=?');
    $req->execute(array($id));
}

function editeProduits($imagep,$nomp,$descpUn,$descpDeux,$prixUnite,$charge,$hauteurTravail,$largeur,
                      $longueur,$environnementTravail,$energie,$puissance,$poids,$ref,$quantestock,$nomcat,$id){
    $pdo=createconnection();
        $req=$pdo->prepare('UPDATE produit SET imagep=?,nomp=?,descpUn=?,descpDeux=?,prixUnite=?,charge=?,
        hauteurTravail=?,largeur=?,longueur=?,environnementTravail=?,energie=?,puissance=?,poids=?,ref=?,
        quantestock=?,nomcat=? WHERE id_produit=?');
        $req->execute(array($imagep,$nomp,$descpUn,$descpDeux,$prixUnite,$charge,$hauteurTravail,$largeur,
        $longueur,$environnementTravail,$energie,$puissance,$poids,$ref,$quantestock,$nomcat,$id));
}

function editeCategories($imagec,$nom,$descc,$id){
    $pdo=createconnection();
        $req=$pdo->prepare('UPDATE categories SET imagec=?,nom=?,descc=? WHERE id_categorie=?');
        $req->execute(array($imagec,$nom,$descc,$id));
}


?>
