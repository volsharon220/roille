
    <?php

// On se connecte à là base de données
$db=new PDO('mysql:host=localhost;dbname=roille;charset=utf8','root','');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // On détermine sur quelle page on se trouve
    if(isset($_GET['page']) && !empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }else{
        $currentPage = 1;
    }

    // On se connecte à là base de données
    
    $db=createconnection();
    // On détermine le nombre total d'articles
    $sql = 'SELECT COUNT(*) AS nb_articles FROM produit;';
    
    // On prépare la requête
    $query = $db->prepare($sql);
    
    // On exécute
    $query->execute();
    
    // On récupère le nombre d'articles
    $result = $query->fetch();
    
    $nbArticles = (int) $result['nb_articles'];
    
    // On détermine le nombre d'articles par page
    $parPage = 5;
    
    // On calcule le nombre de pages total
    $pages = ceil($nbArticles / $parPage);
    
    // Calcul du 1er article de la page
    $premier = ($currentPage * $parPage) - $parPage;
    
    $sql = 'SELECT * FROM produit LIMIT :premier, :parpage;';
    
    // On prépare la requête
    $query = $db->prepare($sql);
    
    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
    $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    
    // On exécute
    $query->execute();
    
    // On récupère les valeurs dans un tableau associatif
    $articles = $query->fetchAll(PDO::FETCH_ASSOC);
    
    ?>

            <div class="row">
                <section class="col-12">
                    <h1>Liste des articles :</h1><br><br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>image</th>
                                <th>nom</th>
                                <th>description</th>
                                <th>description</th>
                                <th>Description complémentaire</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($articles as $article) :?>
                            
                                <tr>
                                    <td><?= $article['imagep']; ?></td>
                                    <td><?= $article['nomp']; ?></td>
                                    <td><?= $article['descpUn']; ?></td>
                                    <td><?= $article['descpDeux']; ?></td>
                                    <td>
                                        <strong>Charge :</strong><?= $article['hauteurTravail']; ?><br>
                                        <strong>Longueur :</strong><?= $article['longueur']; ?><br>
                                        <strong>Largueur :</strong><?= $article['largeur']; ?><br>
                                        <strong>EnvironnementTravail :</strong><?= $article['environnementTravail']; ?><br>
                                        <strong>Puissance :</strong><?= $article['puissance']; ?><br>
                                        <strong>Poids :</strong><?= $article['poids']; ?><br>
                                        <strong>Ref :</strong><?= $article['ref']; ?>
                                    </td>
                                    
                                    <td>
                                        <a href="modifierProduits.php?id=<?= intval($article['id_produit']) ?>">
                                             <i class="fa-solid fa-pen"></i> 
                                        </a>
                                    </td>
                                    
                                    <td>
                                        <a href="deleteProduits.php?id=<?= intval($article['id_produit']) ?>">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                    
                                 </tr>
                            <?php endforeach;?>


                           
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li>
                                <a href="administration.php?page=<?= $currentPage - 1 ?>"
                                    id="precedent" class="page-link">Précédente</a>
                            </li>
                            <?php for($page = 1; $page <= $pages; $page++): ?>
                                <li>
                                    <a href="administration.php?page=<?= $page ?>"
                                     class="page-link"><?= $page ?></a>
                                </li>
                            <?php endfor ?>
                            <li>
                                <a href="administration.php?page=<?= $currentPage + 1 ?>"
                                 id="suivant" class="page-link">Suivante</a>
                            </li>
                        </ul>
                    </nav>
                </section>
            </div>