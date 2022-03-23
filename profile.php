<?php

// BLANCHOT Thomas

include "./services/authentication.php";
redirectOut();
include "./services/dbFunctions.php";
include "navbar.php";

if (sizeof($_POST) > 0) {
    if (($_POST["nom"] == "") || ($_POST["prenom"] == "") || ($_POST["tel"] == "") || ($_POST["email"] == "") || ($_POST["password"] == "") || ($_POST["langue"] == "")) {
        echo '
      <div class="mt-3 alert alert-danger alert-dismissible fade show">
        <strong>Error!</strong> Veuillez remplir tous les champs.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    ';
    } else {
        //check token
        if ($_SESSION["token"] == $_POST["token"]) {
            modifyAttributes(htmlspecialchars($_SESSION["id"]), htmlspecialchars($_POST["prenom"]), htmlspecialchars($_POST["nom"]), htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["tel"]), htmlspecialchars($_POST["password"]));
            $_SESSION["firstName"] = $_POST["prenom"];
            $_SESSION["lastName"] = $_POST["nom"];
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["phone"] = $_POST["tel"];
            echo '
      <div class="mt-3 alert alert-success alert-dismissible fade show">
        <strong>Success!</strong> Vos informations ont bien été mises à jour.
      </div>';
        }
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/profile.css">

</head>

<body class="bg-Light">
    <div class="mt-4 text-center">
        <h1 class="">Gestion du compte</h1>
    </div>

    <div class="shadow rounded bg-white w-50 container border border-1" id="cont">
        <form method="POST" action="profile.php">
            <div class="title">
                <img src="./assets/user.png" alt="icon" class="image">
                <h6>Informations Personnelles</h6>
            </div>
            <div class="item">
                <img src="./assets/suit.png" alt="icon" class="image">
                <h6>Nom</h6>
                <input type="text" hidden name="token" value="<?php echo $_SESSION["token"]; ?>">
                <?php
                if (isset($_SESSION["lastName"])) {
                    echo '
                  <input name="nom" type="text" name="nom" id="nom" value="' . $_SESSION["lastName"] . '" class="mt-1 form-control rounded" required>
                  ';
                } else {
                    echo '
                  <input name="nom" type="text" name="nom" id="nom" placeholder="Doe" class="mt-1 form-control rounded" required>
                  ';
                }
                ?>
            </div>
            <div class="item">
                <img src="./assets/suit.png" alt="icon" class="image">
                <h6>Prénom</h6>
                <?php
                if (isset($_SESSION["firstName"])) {
                    echo '
                <input name="prenom" type="text" name="prenom" id="prenom" value="' . $_SESSION["firstName"] . '" class="mt-1 form-control rounded" required>
                ';
                } else {
                    echo '
                <input name="prenom" type="text" name="prenom" id="prenom" placeholder="John" class="mt-1 form-control rounded" required>
                ';
                }
                ?>
            </div>
            <div class="item">
                <img src="./assets/smartphone.png" alt="icon" class="image">
                <h6>Téléphone</h6>
                <?php
                if (isset($_SESSION["phone"])) {
                    echo '
                <input name="tel" type="number" name="tel" id="tel" value="' . $_SESSION["phone"] . '" class="mt-1 form-control rounded" required>
                ';
                } else {
                    echo '
                <input name="tel" type="number" name="tel" id="tel" placeholder=0123456789 class="mt-1 form-control rounded" required>
                ';
                }
                ?>
            </div>
            <div class="title">
                <img src="./assets/lock.png" alt="icon" class="image">
                <h6>Authentification</h6>
            </div>
            <div class="item">
                <img src="./assets/email.png" alt="icon" class="image">
                <h6>Email</h6>
                <?php
                if (isset($_SESSION["email"])) {
                    echo '
                <input name="email" type="email" name="email" id="email" value="' . $_SESSION["email"] . '" class="mt-1 form-control rounded" required>
                ';
                } else {
                    echo '
                <input name="email" type="email" name="email" id="email" placeholder="example@mail.com" class="mt-1 form-control rounded" required>
                ';
                }
                ?>
            </div>
            <div class="item">
                <img src="./assets/key.png" alt="icon" class="image">
                <h6>Mot de Passe</h6>
                <input name="password" type="password" name="password" id="password" placeholder="********"
                    class="mt-1 form-control rounded" required>
            </div>
            <div class="title">
                <img src="./assets/earth.png" alt="icon" class="image">
                <h6>Langues</h6>
            </div>
            <div class="item">
                <img src="./assets/earth.png" alt="icon" class="image">
                <h6>Langue</h6>
                <select required name="langue" class="form-control" id="langue">
                    <?php
                    echo "<option value=''>Choisir une langue</option>";
                    foreach (["Français", "English"] as $menu) {
                        echo "<option value='" . $menu . "'>" . $menu . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button class="mt-5 btn-success mx-auto d-block">Enregistrer</button>
        </form>
    </div>

</body>

</html>