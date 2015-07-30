
<!doctype html>
<html>
<head>
  <title>Création d'un site dynamique en php</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <script type="text/javascript">

  function redirectMe(id)
  {
    if(confirm("Voulez-vous supprimer l'adhérent avec ID" +id))
    {
      window.location = 'adherent.php?action=supprimer&id='+id ;
    }
  }

  </script>
</head>
<header>
    <nav>
      <ul>
        <li> <a href="index.php">Accueil</a></li>
        <li> <a href="inscription.php">Inscription</a></li>
        <li> <a href="contact.php">Contact</a></li>
        <li> <a href="adherents.php">Adhérents</a></li>
      </ul>
    </nav>
  </header>
