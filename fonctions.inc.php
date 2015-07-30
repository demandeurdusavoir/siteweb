<?php
require('forms.inc.php');
// *** calcul de l'âge à partir de la date de naissance
function calculAge($date){ // argument $date au format "yyyy-mm-dd"
   $timestamp = strtotime($date); // en seconde
   return ceil((time()- $timestamp) / (60 * 60 * 24 * 365)); // calcul de l'âge en arrondit
}

// Nouvelle fonction de listing d'adherents recupere à partir de mysql precisement de la table adherents de la base association  , prend $conn comme paramètre et retourne le listing de tous les adherents
/*** Fonction listing de tous les adherents , param $conn connexion pdo**/
function listingAdherents($conn){
$query = "SELECT * FROM adherents order by date_naissance ASC";
// requete de type select sur la table adhrents

$statement = $conn->query($query);
$output = "";
foreach($statement as $row ){
  $output .= "<tr>";
  // boucle d'affichage des résultats ligne par ligne
  $output .= "<td>".$row['civilite']."</td>";  // utf8_encode fonction native permet l'affichage en
  $output .= "<td>".utf8_encode($row['nom'])."</td>";  // utf8_encode fonction native permet l'affichage en
  $output .= "<td>".utf8_encode($row['prenom'])."</td>";  // utf8_encode fonction native permet l'affichage en
  $output .= "<td>".$row['email']."</td>";
  $output .= "<td>".calculAge($row['date_naissance'])."</td>";
  $output .= "<td>
                <ul>
                <li><a href='adherent.php?action=voir&id=".$row['id_adherent']."'>Voir</a></li>
                <li><a href='adherent.php?action=modifier&id=".$row['id_adherent']."'>Modifier</a></li>
                <li><a href='#' onclick='redirectMe(".$row['id_adherent'].");'>Supprimer</a></li>";
              $output .=    "</ul>
                </td>";
  $output .= "</tr>";
}
return $output;
}
//******************************Fonction d'affichage d'un adherent avec le param id ****/
function showAdherent($id , $conn){
$query = "SELECT * from adherents where id_adherent = $id";
          $statement = $conn->query($query);

          while($obj = $statement->fetch(PDO::FETCH_OBJ)){

        // initialisation en boucle d un objet $obj résultat de la méthode fetch
            echo $obj->civilite."<br/>";
            echo utf8_encode($obj->nom)."<br/>";
            echo utf8_encode($obj->prenom)."<br/>";
            echo utf8_encode($obj->adresse)."<br/>";
            echo $obj->codepostal."<br/>";
            echo $obj->email ."<br/>";
            echo $obj->etat ."<br/>";
   }
}

//******* fonction supprime un adhrent avec son id , $conn est la connexion à la base **///
function deleteAdherent($id, $conn){
$query = "DELETE from adherents where id_adherent = $id";

if($conn->exec($query)){

  // si la requete est executée avec succès je redirige avec header sur le listing
   header('location:adherents.php');
  }
}

//******* fonction mise à jour d' un adhrent avec son id , $conn est la connexion à la base **///
function updateAdherent($id , $conn){
        // Récuperation des anciennes datas de l'adherent avec son $id
        $query = "SELECT * FROM adherents where id_adherent=$id";
        $statement = $conn->query($query);
        while($obj = $statement->fetch(PDO::FETCH_OBJ)){
         // boucle sur le resultat du fetch de l'objet  statement
         $datas["id"] = $obj->id_adherent;
         $datas["nom"] = $obj->nom;
         $datas["prenom"] = $obj->prenom;
         $civilite = $obj->civilite;
         $datas["date_naissance"] = $obj->date_naissance;
         $datas["adresse"] = $obj->adresse;
         $datas["email"] = $obj->email;
         $datas["codepostal"] = $obj->codepostal;
         $datas["etat"] = $obj->etat;
         $datas["civilite"] = ($civilite == "mr")?"1":(($civilite == "mme")?"2":"3");

         }

        $form = formAdherent("", "modifier", $datas );

         // Traitement du submit du formulaire de modification
    if (isset($_POST["submit"])){

      if ($_POST["civilite"] != "0" and !empty($_POST["nom"]) and !empty($_POST["prenom"]) and validMail($_POST["email"])){ // premiere validation
         $date = $_POST["annee"]."-".$_POST["mois"]."-".$_POST["jour"];
         if (checkdate($_POST["mois"], $_POST["jour"],$_POST["annee"])){
         // deuxième validation

         $civilite = ($_POST["civilite"] == "1")?"mr":(($_POST["civilite"] == "2")?"mme":"mlle");
         $nom = utf8_decode($_POST["nom"]); // decode les jeux de cractères utf8 en un code lisible pour mysql
         $prenom = utf8_decode($_POST["prenom"]);
         $email = $_POST["email"];
         $adresse = utf8_decode($_POST["adresse"]);
         $codepostal = $_POST["codepostal"];
         $etat = $_POST["etat"];

        // Création d'une requete update pour mise à jour del'adherent id
         $query = "UPDATE `association`.`adherents` SET `civilite` = '".$civilite."' , `nom` = '".$nom."', `prenom` = '".$prenom."', `date_naissance` = '".$date."', `email` = '".$email."', `adresse` = '".$adresse."', `etat` = '".$etat."', `codepostal` = '".$codepostal."' WHERE `adherents`.`id_adherent` = ".$id.";";

            // requête update sur la table adherents à partir de la connexion $conn
            if($conn->exec($query)){
              header("Location:adherents.php");
            }

        }

    }else { // donnée prenom non valide
        $errors .= "<span class='alert alert-danger'>Vos données ne sont pas renseignées</span>"; // messages d'erreurs
    }
     if (!empty($errors)) echo $errors;  // affichage d'erreurs
 }
   echo $form;
}

// fonction qui valide un email
function validMail($email){
    // ex : mail@domaine.com
 $part1 = strstr($email , "@"); // $part1  @domaine.com
 $part2 = strstr($email, "@" , true); // $part2 mail

   if (!empty($part1) and !empty($part2) and !strpos($part1 , "@") and !strpos($part2 , "@")){
    return true;
   }else {
    return false;
   }
}

function ajouterEnfants($lastID , $datas , $nbr_enfants , $conn){
  $query = "INSERT INTO ENFANTS ( id_enfant ,  id_adherent ,  nom ,  prenom , date_de_naissance , sexe) VALUES";
  for($i = 0 ; $i <  $nbr_enfants ; $i++){
    if ($i < $nbr_enfants-1)
      $query .= "('',$lastID,'".utf8_decode($datas["enfant_nom$i"])."','".utf8_decode($datas["enfant_prenom$i"])."','0000-00-00','".utf8_decode($datas["enfant_sexe$i"])."'),";
    else
      $query .= "('',$lastID,'".utf8_decode($datas["enfant_nom$i"])."','".utf8_decode($datas["enfant_prenom$i"])."','0000-00-00','".utf8_decode($datas["enfant_sexe$i"])."');";
  }
  $count = $conn->exec($query);
  return $count;
}
