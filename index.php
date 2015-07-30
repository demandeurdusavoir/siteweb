<!doctype html>
<html>
<div>
    <?php
include("includes/header.inc.php");
include("includes/fonctions.inc.php");
?>


<div class="container">
    <div class="row">

<p>SITE DYNAMIQUE EN PHP</p>

<?php


listingFichier('html');
?>

</div>
<head>
<title>Création d'un site dynamique en php</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>


<?php include("inscription.php");?>



<?php

 $date = date("d-m-Y H:i:s");
 echo "<p>nous sommes le ". $date ."</p>";
 ?>

<?php include("includes/footer.inc.php");?>

</body>
</html>
