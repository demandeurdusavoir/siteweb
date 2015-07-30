<?php
require("includes/config.inc.php");
include("includes/fonctions.inc.php");
include("includes/header.inc.php");
include("includes/forms.inc.php");
?>
<?php
$errors = "";
$succes = "";
 if (isset($_POST["submit"])){
     if($_POST["civilite"] != "0" and !empty($_POST["nom"]) and !empty($_POST["prenom"]) and validMail($_POST["email"])){ // premiere validation
        $date = $_POST["annee"]."-".$_POST["mois"]."-".$_POST["jour"];
        if(checkdate($_POST["mois"], $_POST["jour"],$_POST["annee"])){
         // Validation de la date de naissance

         $civilite = ($_POST["civilite"] == "1")?"mr":(($_POST["civilite"] == "2")?"mme":"mlle");

         // decode les jeux de cractères utf8 en un code lisible pour mysql
         $nom = utf8_decode($_POST["nom"]);
         $prenom = utf8_decode($_POST["prenom"]);
         $email = $_POST["email"];
         $adresse = utf8_decode($_POST["adresse"]);
         $codepostal = $_POST["codepostal"];
         $etat = $_POST["etat"];
         $nbr_enfants = $_POST["nbr_enfants"];
        // nbr d'enfants renseigné par l'utilisateur lors de la première étape d'inscription

        // Inertion d'un nouveau adherent dans la table adherent
          $query = "INSERT INTO `adherents`(`id_adherent`, `civilite`, `nom`, `prenom` , `date_naissance`, `email` , `adresse` , `codepostal` , `etat` )
          VALUES (NULL,'$civilite' , '$nom' ,'$prenom', '$date', '$email' , '$adresse' , '$codepostal' , '$etat');";
            // requête insert sur la table employes à partir de la connexion $conn

          $count = $conn->exec($query); // nombre d'enregistrement ajouté avec l'insert

          if ($count) {
            $last = $conn->lastInsertId();

            if ($_POST["nbr_enfants"] > 1){
              // Vérification de la saisie des nombres d'enfants
              $_SESSION["nbr_enfants"] = $_POST["nbr_enfants"];
              $_SESSION["lastId"] =  $last ;
              // redirection sur l'étape 2
              header("Location:inscription.php?step=2");
            }else{
              // redirection sur l'étape 2
              echo "Inscription réussie";
            }
          }
        }
     }else { // donnée prenom non valide
        $errors .= "<span class='alert alert-danger'>Vos données ne sont pas renseignées</span>"; // messages d'erreurs
     }
     if (!empty($errors)) echo $errors;  // affichage d'erreurs
 }
 ?>
<?php
  if (!isset($_GET["step"])){

    echo "<br/>";
    echo "<h2 >Première étape : </h2>";
    echo formAdherent("http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]);
  }else{

    if (isset($_POST["submit_enfant"])){ // submit du formulaire enfants
       $errors = "";
      // ajouter la validation des données après la soumission du formulaire
      for($i = 0 ; $i < $_SESSION["nbr_enfants"] ; $i++){
        if (empty($_POST["enfant_nom$i"])){
          $errors .= "<li>le ".($i+1)." ".(($i==0)?"er":"éme")." nom n'est pas renseigné.</li>";
        }
        if (empty($_POST["enfant_prenom$i"])){
          $errors .= "<li>le ".($i+1)." ".(($i==0)?"er":"éme")." prénom n'est pas renseigné.</li>";
        }
        if (empty($_POST["enfant_sexe$i"])){
          $errors .= "<li>le sexe du ".($i+1)." ".(($i==0)?"er":"éme")." enfant n'est pas renseigné.</li>";
        }
      }

      if ($errors == ""){

        $lastId = $_SESSION["lastId"];
        $count = ajouterEnfants($lastId , $_POST , $_SESSION["nbr_enfants"] , $conn);
        echo "<span class='alert alert-success'>".$count." Enfants ajoutés</span>";
      }else{

        echo "<ul class='alert alert-danger'>".$errors."</ul></span>";
      }
    }
      echo "<br/>";
      echo "<h2 >Deuxième étape </h2>";
      echo formEnfant("http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]."?step=2", $_SESSION["nbr_enfants"]);
  }

?>
<?php include("includes/footer.inc.php"); ?>
