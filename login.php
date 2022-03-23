<?php
// OUGGADI Mohammed Aymane
include "./services/dbFunctions.php";
include "./services/authentication.php";
if (!isset($_SESSION["loggedIn"])) {
    $_SESSION["loggedIn"] = false;
}

redirectIn();

if (sizeOf($_POST) > 0) {
    if ($_POST["email"] == "") {
        echo
        '               <div class="mt-3 alert alert-danger alert-dismissible fade show">
                            <strong>Error!</strong> Veuillez introduire votre email.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>';
    }
    if ($_POST["password"] == "") {
        echo
        '               <div class="mt-3 alert alert-danger alert-dismissible fade show">
                            <strong>Error!</strong> Veuillez introduire votre mot de passe.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>';
    } else {
        $user = loginUser(htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["password"]));
        if ($user["status"] == "success") {
            if (!$user["result"][0]) {
                echo '
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Error!</strong> Email ou mot de passe incorrecte
                    </div>';
            } else {
                $_SESSION["loggedIn"] = true;
                $_SESSION["id"] = $user["result"][1][0];
                $_SESSION["token"] = md5(time() * rand(1, 574) . $_SESSION["id"]);
                $_SESSION["firstName"] = $user["result"][1][2];
                $_SESSION["lastName"] = $user["result"][1][3];
                $_SESSION["role"] = $user["result"][1][1];
                $_SESSION["email"] = $user["result"][1][4];
                $_SESSION["phone"] = $user["result"][1][5];
                $missions = getLastMissionByUserId($_SESSION["id"])["result"];
                if (sizeOf($missions) <= 0) {
                    echo "no missions";
                    header("Location:listeMissions.php");
                } else header("Location:page_mission.php?mission_id=" . $missions[0]["Id"]);
            }
        } else {
            echo '
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error!</strong>Erreur de connexion, veuillez réessayer.
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
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body class="bg-Light">
    <div class="mt-4 text-center">
        <img srcset="./assets/icons8-male-user-100.png" alt="icon">
        <h1 class="">Connectez-vous</h1>
    </div>

    <div class="shadow rounded bg-white w-25 p-3 container border border-1">
        <form method="POST" action="login.php">
            <label for="email">Adresse email</label>
            <input name="email" type="email" name="email" id="email" class="mt-1 form-control rounded" required>
            <label for="password">Mot de passe</label>
            <input name="password" type="password" name="password" id="password" class="mt-1 form-control rounded"
                required>
            <button class="mt-3 btn btn-success mx-auto d-block">Se connecter</button>
        </form>
    </div>

    <div class="shadow bg-white pt-2 text-center w-25 mt-4 container border rounded">
        <p>Vous n'avez pas de compte ? <a href="signup.php">Créer un compte</a></p>
    </div>

</body>

</html>