<?php include("includes/header.inc.php");?>


<div class="container">
    <?php
    if (!empty($_GET['page'])){
        $page=__dir__."/pages/".$_GET['page'].".html";//formate une variable $page avec le paramètre récupéré dans l'url dont la valeur est $_GET["page"]
        if (file_exists($page))//fonction php qui vérifie si un fichier existe physiquement sur le serveur
            echo strip_tags(file_get_contents($page),'<h1><p>');//elle ne permet pas d'enlever tout les tags sauf ceux qui sont spécifiés, j'ai enlevé le lien href
        else
            header("location:introuvable.php");//fonction de redirection en php lorsque commence l'argument qu'elle prend par location: l'URL de la destination ex : fichier introuvable.php
    }else {
        header("location:introuvable.php");
    }
    ?>
</div>

<?php include("includes/footer.inc.php");?>
