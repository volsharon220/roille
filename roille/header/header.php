<nav>
            <div>
                <img src="image/logo_roille.png" alt="">
            </div>
        <ul>
            
            <?php if(isset($userInfo)) : ?>
                <li><a href="index.php">accueil</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="#">Guides</a></li>
                <li><a href="#">Location d'engeins</a></li>
                <li><a href="contact.php">Nous contactez</a></li>
                <li>
                    <a href='profil.php?id=<?= intval($userInfo['id_client']); ?>'><span>Bonjour <?= htmlspecialchars($userInfo['nom']); ?></span>
                        <?php if(!empty($userInfo['avatar'])) :?>
                                <img src="image/utilisateur/<?= $userInfo['avatar'] ;?>" class="pictur">
                                <?php else : ?> 
                                    <img src="image/utilisateur/default.jpg" whidth="100px">   
                        <?php endif; ?>
                    </a>
                    <div class='menu'>
                        <div class='sousMenu'>
                            <ul>
                                <?php if(isset($userInfo['id_client']) && $userInfo['roleClient']==1) : ?>

                                    <li><a href="profil.php?id=<?= intval($userInfo['id_client']); ?>">mon profil</a></li>
                                    <li><a href="administration.php?id=<?= intval($userInfo['id_client']); ?>">admin</a></li>
                                    <li><a href="deConnect.php">se déconnecter</a></li>

                                <?php elseif(isset($userInfo['id_client']) && $userInfo['roleClient']==null) : ?>
                                    <li><a href="profil.php?id=<?= intval($userInfo['id_client']); ?>">mon profil</a></li>
                                    <li><a href="deConnect.php">se déconnecter</a></li>
                                <?php endif; ?>
                                
                            </ul>
                        </div>
                    </div>
                </li>           
                <?php else :?>
                    <li><a href="index.php">accueil</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="#">Guides</a></li>
                    <li><a href="#">Location d'engeins</a></li>
                    <li><a href="contact.php">Nous contactez</a></li>
                    <li><a href='connexion.php'><i class='fa-solid fa-user'></i></a></li>
           
                <?php endif; ?>
            
        </ul>
    </nav>

    