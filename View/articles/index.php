<?php require 'View/includes/header.php'?>

<?php  ?>

<section>
    <!-- <p><a href="index.php?page=articles">To articles page</a></p> -->
    <?php foreach($articles as $article)
        {
            echo '<p>';
            echo $article->title;
            echo '</p>';
        };
    ?>
</section>

<?php require 'View/includes/footer.php'?>