
<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>ajout de citation</title>
    <meta charset="UTF-8" />
  </head>
  <body>
    <main>
      <article>
        <header><h1>Formaire de création de citations</h1></header>
        <form method="post" name="FrameCitation" action="<?php basename($_SERVER['PHP_SELF']); ?>">
          <table border="1" bgcolor="#ccccff" frame="above">
            <tbody>
              <tr>
                <th><label for="login">Login</label></th>
                <td><input name="login" maxlength="64" size="32" /></td>
              </tr>
              <tr>
                <th><label for="citation">Citation</label></th>
                <td>
                  <textarea cols="128" rows="5" name="citation"></textarea>
                </td>
              </tr>
              <tr>
                <th><label for="auteur">Auteur</label></th>
                <td><input name="auteur" maxlength="128" size="64" /></td>
              </tr>
              <tr>
                <th><label for="date">Date</label></th>
                <td><input type="date" name="date" maxlength="128" size="64" value="<?php echo date('Y-m-d');?>" /></td>
              </tr>


              <?php

                if(sizeOf($_POST)>0) {
                    if ($_POST['auteur']=="" ) {
                      
                      echo "<tr> 
                              <th><label for='error'>Message d'érreur</label></th>
                              <td><input type='txt' name='error' maxlength='128' size='64' value='Auteur manquant.' /></td>
                           </tr>";
                    }
                    if ($_POST['citation']=="" ) {
                      echo "<tr> 
                              <th><label for='error'>Message d'érreur</label></th>
                              <td><input type='txt' name='error' maxlength='128' size='64' value='Citation manquante.' /></td>
                           </tr>";

                    }
                else{
                  $auteur = $_POST["auteur"];
                  $citation = $_POST["citation"];
                  $date = $_POST["date"];
                  $login = $_POST["login"];
                  echo "
                          <h1>Citation ajouté par l'utilisateur $login, le $date</h1>
                                  
                          <div class='card'>
                              
                              <div class='card-body'>
                                  <h5 class='card-title'>Rappel de vos informations</h5>
                                  <p class='card-text'><b>Auteur</b> : $auteur</p>
                                  <p class='card-text'><b>Citation</b> : $citation</p>
                              </div>
                          </div>";                  
                }
                }


                ?>
              <tr>
                
                <td colspan="2" align="center">
                  <input
                    name="Envoyer"
                    value="Enregistrer la citation"
                    type="submit"
                  /><input name="Effacer" value="Anner" type="reset" />
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </article>
    </main>
  </body>
</html>
