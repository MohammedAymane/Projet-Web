<!DOCTYPE html>
<html lang="fr">

<head>
    <title>afficher tous les missions </title>
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
    redirectNoneAdmin();
    $user_id = $_SESSION["id"];
    ?>

    <div class="container-fluid p-4 bg-success text-white text-center bg-opacity-50">
        <h2>Vue Globale</h2>
    </div>

    <form class="container p-3" method="post" action="ListeAllMission.php">
        <div class="row">
            <p class="h5 col-2">Filtres : </p>
            <div class="col-2">
                <input class="form-control" list="firstNameOptions" id="firstName" name="firstName"
                    placeholder="firstName">
                <input class="form-control" list="lastNameOptions" id="lastName" name="lastName" placeholder="lastName">
                <datalist id="firstNameOptions">
                    <?php
                    $result = getUsers();
                    $listeName = $result["result"];
                    foreach ($listeName as $name) {
                    ?>
                    <option value="<?php echo $name['firstName'] ?>" />
                    <?php } ?>
                </datalist>
                <datalist id="lastNameOptions">
                    <?php
                    foreach ($listeName as $name) {
                    ?>
                    <option value="<?php echo $name['lastName'] ?>" />
                    <?php } ?>
                </datalist>

            </div>
            <div class="col-2">
                <input class="form-control" list="etatOptions" id="etat" name="etat" placeholder="État">
                <datalist id="etatOptions">
                    <option value="en Cours">
                    <option value="finis">
                    <option value="annulee">
                    <option value="supprimee">
                </datalist>
            </div>
            <div class="col-2">
                <input class="btn btn-outline-success bg-opacity-50" type="submit" name="afficher" value="afficher" />
            </div>
        </div>
    </form>


    <div class="container p-3">
        <!-- Tableau contenant les citations sauvegardees dans la base de donnees -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Employé</th>
                    <th>Lieu</th>
                    <th>Date</th>
                    <th>État</th>
                    <th>Solde initial</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // $sqlexp = "";
                $firstNameSelect = "";
                $lastNameSelect = "";
                $etatSelect = "";
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $firstNameSelect = $_POST['firstName'];
                    $lastNameSelect = $_POST['lastName'];
                    $etatSelect = $_POST['etat'];
                }

                $result = getMissionsByWhere($firstNameSelect, $lastNameSelect, $etatSelect);
                $listeMissions = $result["result"];

                foreach ($listeMissions as $mission) {
                ?>
                <tr>
                    <td><?php echo $mission["firstName"] . " " . $mission["lastName"] ?></td>
                    <td><?php echo $mission['lieu'] ?></td>
                    <td><?php echo $mission['debut'] . " - " . $mission['fin'] ?></td>
                    <td><?php echo $mission['etat'] ?></td>
                    <td><?php echo $mission['solde_initial'] . " " . $mission['symbole'] ?></td>
                </tr>
                <?php }
                ?>


            </tbody>
        </table>
    </div>
</body>

</html>