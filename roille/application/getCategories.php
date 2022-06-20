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


// On détermine le nombre total d'articles
$sql = 'SELECT COUNT(*) AS nb_articles FROM categories;';

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

$sql = 'SELECT * FROM categories LIMIT :premier, :parpage;';

// On prépare la requête
$query = $db->prepare($sql);

$query->bindValue(':premier', $premier, PDO::PARAM_INT);
$query->bindValue(':parpage', $parPage, PDO::PARAM_INT);

// On exécute
$query->execute();

// On récupère les valeurs dans un tableau associatif
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

?>


        <div class="row">
            <section class="col-12">
                <h1>Liste des articles</h1>
                <table class="table">
                    <thead>
                    <tr>
                        <th>image</th>
                        <th>nom</th>
                        <th>description</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $categorie) : ?>
                        
                            <tr>
                                <td><?= $categorie['imagec']; ?></td>
                                <td><?= $categorie['nom']; ?></td>
                                <td><?= $categorie['descc']; ?></td>
                                <td>
                                        <a href="modifierCategories.php?id=<?= intval($categorie['id_categorie']) ?>">
                                             <i class="fa-solid fa-pen"></i> 
                                        </a>
                                    </td>
                                    
                                    <td>
                                        <a href="deleteCategories.php?id=<?= intval($categorie['id_categorie']) ?>">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                            </tr>

                        <?php endforeach;?>

                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                            <a href="administration.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                        </li>
                        <?php for($page = 1; $page <= $pages; $page++): ?>
                            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                <a href="administration.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                            </li>
                        <?php endfor ?>
                        <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            <a href="administration.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                        </li>
                    </ul>
                </nav>
            </section>
        </div>
