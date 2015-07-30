<?php
require("includes/config.inc.php");
include("includes/fonctions.inc.php");
include("includes/header.inc.php");
?>
<?php
// Gérer les actions voir , modifier , supprimer
// verifier si l'action existe , $_GET super global pour accéder aux param de l'url

   if(isset($_GET['action'])){
   // Si l'action est égale à voir

       switch($_GET['action']){
      case 'voir':
        if (!empty($_GET["id"]) && is_numeric($_GET["id"])){ // si j'ai un ID valide dans l'url sous forme numérique et non vide
              $id = str_replace(" ", "", $_GET["id"]);
              // id de l'adherent à afficher sur la page adherent.php , formaté avec supression des espace dans la valeur de l'id
              showAdherent($id , $conn);
              }
              break;
       case 'modifier':
        if (!empty($_GET["id"]) && is_numeric($_GET["id"])){ // si j'ai un ID valide dans l'url sous forme numérique et non vide
              $id = str_replace(" ", "", $_GET["id"]);
              // id de l'adherent à afficher sur la page adherent.php , formaté avec supression des espace dans la valeur de l'id
              updateAdherent($id , $conn);
              }
            break;
         case 'supprimer':
        if (!empty($_GET["id"]) && is_numeric($_GET["id"])){ // si j'ai un ID valide dans l'url sous forme numérique et non vide

              $id = str_replace(" ", "", $_GET["id"]);
              // id de l'adherent à afficher sur la page adherent.php , formaté avec supression des espace dans la valeur de l'id
              deleteAdherent($id , $conn);
              }
          break;
        }
}








?>




<?php include("includes/footer.inc.php"); ?>
