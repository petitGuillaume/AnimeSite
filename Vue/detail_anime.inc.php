<!DOCTYPE html>
<html>
<head>




<!DOCTYPE html>
<html>
<head>
    <title>Anime Form</title>
</head>
<body>
    <?php if ($anime): ?>
        <h2><?php echo $anime['Name_Jp']; ?></h2>
        <p><strong>Name (FR): </strong><?php echo $anime['Name_Fr']; ?></p>
        <p><strong>Synopsis: </strong><?php echo $anime['Synopsis']; ?></p>
        <p><strong>Year: </strong><?php echo $anime['Year']; ?></p>
        <!-- Afficher d'autres informations de l'anime ici -->
        
        <?php if ($anime_antéList): ?>
            <h3>Anime antérieur</h3>
            <ul>
                <?php foreach ($anime_antéList as $anime_anté): ?>
                    <li>
                        <img class="ani" src="ressource/img/anime_img/<?php echo $anime_anté['image']; ?>" alt="<?php echo $anime_anté['Name_Fr']; ?>">
                        <?php echo $anime_anté['Name_Fr']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        
        <?php if ($relatedSourceAnimeList): ?>
            <h3>Anime posterieur</h3>
            <ul>
                <?php foreach ($relatedSourceAnimeList as $relatedSourceAnime): ?>
                    <li>
                        <img class="ani" src="ressource/img/anime_img/<?php echo $relatedSourceAnime['image']; ?>" alt="<?php echo $relatedSourceAnime['Name_Fr']; ?>">
                        <?php echo $relatedSourceAnime['Name_Fr']; ?>
                        <?php echo $relatedSourceAnime['Anime_Type']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if ($relatedAnimeList): ?>
            <h3>Related Anime in the Same Universe</h3>
            <ul>
                <?php foreach ($relatedAnimeList as $relatedAnime): ?>
                    <li>
                        <img class="ani" src="ressource/img/anime_img/<?php echo $relatedAnime['image']; ?>" alt="<?php echo $relatedAnime['Name_Jp']; ?>">
                        <?php echo $relatedAnime['Name_Jp']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <?php else: ?>
        <p>L'anime n'existe pas.</p>
    <?php endif; ?>
</body>
</html>

