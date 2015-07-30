
<?php include("includes/header.inc.php");
      include("includes/fonctions.inc.php");
      require("includes/config.inc.php");
?>

<div class="container">
  <div class="row">
<p>Listing des adhérents</p>
<table style="width:100%">
  <thead>
    <tr>
      <th>Civilité</th>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Email</th>
      <th>Age</th>
      <th>Actions</th>
    </tr>

  </thead>

  <tbody styel="text-align:center;">
    <?php

    //TODO
     echo listingAdherents($conn);

    ?>
  </tbody>
  </table>
  </div>

</div> <!-- / container -->

<?php include("includes/footer.inc.php");?>







