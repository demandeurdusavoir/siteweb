<?php
// fonction d'affichage et de création de formulaire insertion / modification de l'adherent

function formAdherent($action , $type = "inserer" , $datas = array()){

    $selected1 = (!empty($datas) && isset($datas["civilite"]) && $datas["civilite"] == "1")?"selected='selected'":"";
    $selected2 = (!empty($datas) && isset($datas["civilite"]) && $datas["civilite"] == "2")?"selected='selected'":"";
    $selected3 = (!empty($datas) && isset($datas["civilite"]) && $datas["civilite"] == "3")?"selected='selected'":"";
    $date_array =(!empty($datas) && isset($datas["date_naissance"]))?
      explode("-", $datas['date_naissance']):array("0000","00","00");
      // resultat tableau ordonné yyyy-mm-dd apres l explode devien array(0=>"yyyy", 1=>"mm", 2=>"dd")
    $selected_etat1 = (!empty($datas) && isset($datas["etat"]) && $datas["etat"] == "marie")? "checked='checked'":"";
    $selected_etat2 = (!empty($datas) && isset($datas["etat"]) && $datas["etat"] == "divorce")? "checked='checked'":"";
    $selected_etat3 = (!empty($datas) && isset($datas["etat"]) && $datas["etat"] == "celibataire")? "checked='checked'":"";

  // déclaration $form qui est le formulaire adherent
    $form = '<form action="'.$action.'" method="POST">
         <label>Civilité</label>
         <select name="civilite">
            <option value="0">Choissisez</option>
            <option value="1" '.$selected1.' >Mr</option>
            <option value="2" '.$selected2.' >Mme</option>
            <option value="3" '.$selected3.' >Melle</option>
        </select>
        <label>Nom :</label>
        <input type="text" name="nom" value="'.(isset($datas["nom"])?$datas["nom"]:"").'">
        <label>Prénom :</label>
        <input type="text" name="prenom" value="'.(isset($datas["prenom"])?$datas["prenom"]:"").'">
        <label>Adresse :</label >
        <input type="text" name="adresse" value="'.(isset($datas["adresse"])?$datas["adresse"]:"").'">
        <label>Code postal :</label >
        <input type="text" name="codepostal" value="'.(isset($datas["codepostal"])?$datas["codepostal"]:"").'">
        <label>Email :</label>
        <input type="text" name="email" value="'.(isset($datas["email"])?$datas["email"]:"").'">
        <label >Date de naissance :</label>
        <select name="jour">';
        for($i = 1; $i < 32; $i++){
           if ($i < 10) {
            $select_jour = (isset($date_array) && $date_array[2] == "0".$i)?'selected="selected"':'';
            $form .= "<option value='0".$i."'   $select_jour >0$i</option>";
           }else{
            $select_jour = (isset($date_array) && $date_array[2] == $i)?'selected="selected"':'';
            $form .=  "<option value='".$i."'   $select_jour >$i</option>";
           }
        }
        $form .= '</select>
        <select name="mois">';
        for($i = 1; $i < 13; $i++){
           if ($i < 10) {
            $select_mois = (isset($date_array) && $date_array[1] == "0".$i)?'selected="selected"':'';
            $form .= "<option value='0".$i."' $select_mois >0$i</option>";
           }else{
            $select_mois = (isset($date_array) && $date_array[1] == $i)?'selected="selected"':'';
            $form .= "<option value='".$i."' $select_mois >$i</option>";
           }
        }

        $form .= '</select>
       <select name="annee">';
        $anneeActuelle = date("Y");
        for($i = intval($anneeActuelle); $i >= 1920 ; $i--){
            $selected_annee = (isset($date_array) && $date_array[0] == $i)?'selected="selected"':'';
            $form .= "<option value='".$i."' ".$selected_annee.".>$i</option>";
        }

       $form .= '</select>
       <label>Etat civil : </label>
       <input type="radio" name="etat" value="marie" '.$selected_etat1.' >Marié
       <input type="radio" name="etat" value="divorce" '.$selected_etat2.' >Divorcé
       <input type="radio" name="etat" value="celibataire" '.$selected_etat3.' >Célibataire
       <label >Nombre d\'enfants</label >
       <input type="text" name="nbr_enfants" value="">
       <br/><br/>
       <input type="submit" value="'.(($type =="inserer")?"S'inscrire":"Modifier").'" name="submit">
       </form>';
       return $form;

}

// **** fonction creation dynamique du formulaire saisie d'enfant(s)

function formEnfant($action , $nbr){
  // creation de $nbr fois de block fieldset avec le(s) noms , prenoms et sexes des enfants
  $form = '<form action="'.$action.'" method="post">';
  for($i = 0 ; $i < $nbr ; $i++){
    $form .="<fieldset>";
    $form  .="<label >Nom : </label>
              <input type='text' name='enfant_nom".$i."' >
              <label >Prénom : </label>
              <input type='text' name='enfant_prenom".$i."' >
              <label >Sexe : </label>
              <input type='radio' name='enfant_sexe".$i."' value='garçon'> Garçon
              <input type='radio' name='enfant_sexe".$i."' value='fille' > Fille";
    $form .="</fieldset>";
  }
  $form .= '<input type="submit" name="submit_enfant" value="Terminer" >';
  $form .= '</form>';

  return $form;
}
