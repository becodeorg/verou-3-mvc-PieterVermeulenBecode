<?php require 'View/includes/header.php'?>

<?php //workspace ?>

<section>
    <h1><?= $article->title ?></h1>
    <p><?= $article->formatPublishDate() ?></p>
    <p><?= $article->description ?></p>

    <?php // TODO: links to next and previous ?>
    <a href="index.php?page=articles-show&id=<?=$this->getPreviousID($article->id);?>">Previous article</a>
    <a href="index.php?page=articles-show&id=<?=$this->getNextID($article->id);?>">Next article</a>
</section>

<?php require 'View/includes/footer.php'?>