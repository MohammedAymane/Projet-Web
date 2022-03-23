<?php
include "navbar.php";
session_start();
if (!$_SESSION["loggedIn"]) {
    header("Location:login.php");
    die();
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <title>ajout de citation</title>
    <meta charset="UTF-8" />
</head>

<body>
    <main>
        <article>
            <header>
                <h1>Formaire de création de citations</h1>
            </header>
            <form method="post" name="FrameCitation" action="<?php basename($_SERVER["PHP_SELF"]); ?>">
                <table border="1" bgcolor="#ccccff" frame="above">
                    <tbody>
                        <tr>
                            <th><label for="login">Login</label></th>
                            <td><input name="login" maxlength="64" size="32" /></td>
                            <input type="hidden" name="token" value="<?php echo $_SESSION["token"]; ?>" />
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
                            <td><input type="date" name="date" maxlength="128" size="64" value="<?php echo date(
                                                                                                    "Y-m-d"
                                                                                                ); ?>" /></td>
                        </tr>


                        <?php if (sizeOf($_POST) > 0) {
                            if ($_POST["auteur"] == "") {
                                echo "<tr> 
                              <th><label for='error'>Message d'érreur</label></th>
                              <td><input type='txt' name='error' maxlength='128' size='64' value='Auteur manquant.' /></td>
                           </tr>";
                            }
                            if ($_POST["citation"] == "") {
                                echo "<tr> 
                              <th><label for='error'>Message d'érreur</label></th>
                              <td><input type='txt' name='error' maxlength='128' size='64' value='Citation manquante.' /></td>
                           </tr>";
                            } else {
                                include "dbFunctions.php";
                                //verify the requst token with session token
                                if (!isset($_POST["token"]) || $_POST["token"] != $_SESSION["token"]) {
                                    echo "<tr> 
                                  <th><label for='error'>Message d'érreur</label></th>
                                  <td><input type='txt' name='error' maxlength='128' size='64' value='Token invalide.' /></td>
                                  
                               </tr>";
                                }
                                $auteur = htmlspecialchars($_POST["auteur"]);
                                $citation = htmlspecialchars($_POST["citation"]);
                                $date = htmlspecialchars($_POST["date"]);
                                $login = htmlspecialchars($_POST["login"]);
                                addCitation($pdo, $auteur, $citation, $date, $login);
                            }
                        } ?>
                        <tr>

                            <td colspan="2" align="center">
                                <input name="Envoyer" value="Enregistrer la citation" type="submit" /><input
                                    name="Effacer" value="Annuler" type="reset" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </article>
    </main>
</body>

</html>