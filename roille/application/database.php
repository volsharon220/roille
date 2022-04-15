<?php

function createconnection(){
    $pdo=new PDO('mysql:host=localhost;dbname=roille;charset=utf8','root','');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
function registerParticulier($nom,$prenom,$mdp,$addresse,$codeP,$ville,$pays,$phone,$mail){
    $pdo=createconnection();
    $req=$pdo->prepare("INSERT INTO particulier (avatar,nom,prenom,mdp,addresse,codeP,ville,pays,phone,mail)
                        values (null,:nom,:prenom,:mdp,:addresse,:codeP,:ville,:pays,:phone,:mail)");
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

function registerProfessionnel($nom,$mdp,$addresse,$codeP,$ville,$pays,$phone,$mail,$numSiret,$statut_juridique){
    $pdo=createconnection();
    $req=$pdo->prepare("INSERT INTO professionnel 
                        (avatar,nom,mdp,addresse,codeP,ville,pays,phone,mail,numSiret,statut_juridique)
                        values (null,:nom,:mdp,:addresse,:codeP,:ville,:pays,:phone,:mail,:numSire,:statut_jurid)");
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
                    $environnementTravail,$energie,$puissance,$poids,$ref,$nomc){
    $pdo=createconnection();
    $req=$pdo->prepare("INSERT INTO produit (imagep,nomp,descpUn,descpDeux,prixUnite,charge,hauteurTravail,
                        largeur,longueur,environnementTravail,energie,puissance,poids,ref,nomcat) 
                        values (:imagep,:nomp,:descpUn,:descpDeux,:prixUnite,:charge,:hauteurTravail,:largeur,
                        :longueur,:environnementTravail,:energie,:puissance,:poids,:ref,:nomc)");
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
        ':nomc'=>$nomc
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

function getDetailProduitById($id){
    $pdo=createconnection();
    $req=$pdo->prepare('SELECT * FROM produit WHERE id_produit=?');

    $req->execute(array($id));
    $details=$req->fetchAll(PDO::FETCH_ASSOC);
    return $details;
}

function addCommande($quantite_com,$idProduit,$dateDebut,$dateFin){
    $pdo=createconnection();
    $req=$pdo->prepare("INSERT INTO detail_com (quantite_com,id_produit,dateD,dateF) 
                        values (:quantite_com,:id_produit,:dateD,:dateF)");
    $req->execute(array(
        ':quantite_com'=>$quantite_com,
        ':id_produit'=>$idProduit,
        ':dateD'=>$dateDebut,
        ':dateF'=>$dateFin
    ));    
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

function modifClientParc($avatar,$nom,$prenom,$mdp,$addresse,$codeP,$ville,$pays,$phone,$mail,$id){
    $pdo=createconnection();
        $req=$pdo->prepare('UPDATE particulier SET avatar=?,nom=?,prenom=?,mdp=?,addresse=?,codeP=?,ville=?,pays=?,
                            phone=?,mail=? WHERE id_client=?');
        $req->execute(array($avatar,$nom,$prenom,$mdp,$addresse,$codeP,$ville,$pays,$phone,$mail,$id));
}

function modifClientPro($avatar,$nom,$addresse,$mdp,$codeP,$ville,$pays,$phone,$mail,$statuJ,$numS,$id){
    $pdo=createconnection();
        $req=$pdo->prepare('UPDATE professionnel SET avatar=?,nom=?,mdp=?,addresse=?,codeP=?,ville=?,pays=?,
                            phone=?,mail=?,numSiret=?,statut_juridique=? WHERE id_client=?');
        $req->execute(array($avatar,$nom,$addresse,$mdp,$codeP,$ville,$pays,$phone,$mail,$statuJ,$numS,$id));
}
?>