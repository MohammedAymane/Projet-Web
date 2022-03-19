<!DOCTYPE html>
<html lang="fr">

<head>
    <title>afficher tous les employes </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
  include "services/authentication.php";
  include "navbar.php";
  include "services/dbFunctions.php";
  redirectOut();
  $user_id = $_SESSION["id"];
  ?>

    <div class="container-fluid p-4 bg-success text-white text-center bg-opacity-50">
        <h2>Liste tous les employés</h2>
    </div>

    <form class="container p-3" method="post" action="ListeAllEmployes.php">
        <div class="row">
            <p class="h5 col-2">Filtres : </p>
            <div class="col-2">
                <input class="form-control" list="serviceOptions" id="service" name="service" placeholder="Service" >
                <datalist id="serviceOptions">
                    <?php
          $result = getService();
          $listeUsers = $result["result"];
          foreach ($listeUsers as $user) {
          ?>
                    <option value="<?php echo $user['service'] ?>" <?php echo (isset($_POST['service']) && $_POST['service']==$user['service'])?'selected':'';?> />
                    <?php }
          ?>
                </datalist>
            </div>

            <div class="col-2">
                <input class="btn btn-outline-success bg-opacity-50" type="submit" name="afficher" value="afficher" />
            </div>
        </div>
    </form>


    <div class="container p-3">
        <!-- Tableau contenant les citations sauvegardees dans la base de donnees -->
        <table class="table table-striped table-reponsive-sm">
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Service</th>
                    <th>L'addresse mail</th>
                    <th>Numéro de téléphone</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serviceSelect = "";
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                  $serviceSelect = $_POST['service'];
                   }
                   // include_once("classes/user.class.php");

        $result = getAllUsers($serviceSelect);
        $listeUsers = $result["result"];

        foreach ($listeUsers as $user) {
        ?>
                <tr>
                    <td><?php echo $user->getFirstname() ?></td>
                    <td><?php echo $user->getLastname() ?></td>
                    <td><?php echo $user->getService() ?></td>
                    <td><?php echo $user->getEmail() ?></td>
                    <td><?php echo $user->getPhone() ?></td>
                </tr>
                <?php }
        ?>


            </tbody>
        </table>
    </div>
</body>

</html>
