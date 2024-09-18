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
     
        
        <?php if (!empty($results)){ ?>
    <h3>Anime Source</h3>
    <ul>
        <?php foreach ($results as $relatedSource): ?>
            <li>
            <a href="index.php?detail_anime&id=<?php echo $relatedSource['ID']; ?>">
            <img class="ani" src="ressource/img/anime_img/<?php echo $relatedSource['Image']; ?>" alt="<?php echo $relatedSource['Name_Fr']; ?>">
            <strong>Year: </strong><?php echo $relatedSource['Name_Fr']; ?> </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php } else{ ?>
   
<?php }endif; ?>

</body>
</html>

