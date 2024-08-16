<!DOCTYPE html>
<html>
<head>




<!DOCTYPE html>
<html>
<head>
    <title>Film Form</title>
</head>
<body>
    <?php if ($film): ?>
        <h2><?php echo $film['Name_Jp']; ?></h2>
        <p><strong>Name (FR): </strong><?php echo $film['Name_Fr']; ?></p>
        <p><strong>Synopsis: </strong><?php echo $film['Synopsis']; ?></p>
        <p><strong>Year: </strong><?php echo $film['Year']; ?></p>
        <!-- Afficher d'autres informations de l'anime ici -->
        
        <?php if ($film_antéList): ?>
            <h3>Film antérieur</h3>
            <ul>
                <?php foreach ($film_antéList as $film_anté): ?>
                    <li>
                        <img class="ani" src="ressource/img/film_img/<?php echo $film_anté['image']; ?>" alt="<?php echo $film_anté['Name_Fr']; ?>">
                        <?php echo $film_anté['Name_Fr']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        
        <?php if ($relatedSourcefilmList): ?>
            <h3>film posterieur</h3>
            <ul>
                <?php foreach ($relatedSourcefilmList as $relatedSourcefilm): ?>
                    <li>
                        <img class="ani" src="ressource/img/film_img/<?php echo $relatedSourcefilm['image']; ?>" alt="<?php echo $relatedSourcefilm['Name_Fr']; ?>">
                        <?php echo $relatedSourcefilm['Name_Fr']; ?>
                        <?php echo $relatedSourcefilm['film_Type']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if ($relatedfilmList): ?>
            <h3>Related film in the Same Universe</h3>
            <ul>
                <?php foreach ($relatedfilmList as $relatedfilm): ?>
                    <li>
                        <img class="ani" src="ressource/img/film_img/<?php echo $relatedfilm['image']; ?>" alt="<?php echo $relatedfilm['Name_Jp']; ?>">
                        <?php echo $relatedfilm['Name_Jp']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <?php else: ?>
        <p>L'anime n'existe pas.</p>
    <?php endif; ?>
</body>
</html>

