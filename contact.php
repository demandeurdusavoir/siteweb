<?php include("includes/header.inc.php");
      include("includes/fonctions.inc.php");
?>

<div class="container">
    <div class='row'>

        <form action="contact.php" method="post">
            <label>Civilité :</label>
            <select name="civilite">
                <option value="0">Choisissez</option>
                <option value="1">Mr</option>
                <option value="2">Mme</option>
                <option value="3">Mlle</option>
            </select>

            <label>Nom :</label>
            <input type="text" name="nom">
            <label>Prénom :</label>
            <input type="text" name="prenom">
            <label>Sujet :</label>
            <textarea name="sujet"></textarea>
            <br/><br/>
            <input type="submit" name="submit" value="Envoyer">
        </form>
    </div>
</div> <!-- /container -->


<?php include("includes/footer.inc.php");?>

<?php

if(isset($_POST['submit']))
{  // and === AND === &&
   if(($_POST['submit'] !== "0") and !empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['sujet']))
  {
  // mail du webmaster admin@monassoc.fr

    $to = "admin@monassoc.fr";
    $civilite = $_POST['civilite'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $sujet = $_POST['sujet'];

    $message ="Vous avez reçu un message de la part de :"."\n";
     if($_POST['civilite'] == 1)
     {
      $message .= "Mr $nom , $prenom";
     }
     else if ($_POST['civilite'] == 2)
      {

       $message .= "Mme $nom , $prenom";
      }

      else
      {

         $message .= "Mlle $nom , $prenom";
      }

      $message .= " avec le message suivant $sujet";

        echo $message;

      mail($to, 'message de contact', $message);


  }   else
      {
        echo 'Vous devez renseigner les champs';
      }
}
