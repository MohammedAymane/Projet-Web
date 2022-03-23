<!DOCTYPE html>

<html>
<!-- SOULIÉ Hortense -->
<head>
    <meta charset="utf-8" />
    <title>Ma mission</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>

<body>
    <!-- Extension jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Extension DATEPICKER -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <?php
    include "./services/authentication.php";
    include "./classes/operation.class.php";
    include "navbar.php";
    include "./services/dbFunctions.php";
    if (!isset($_GET['mission_id']) && !isset($_GET['number'])) {
        die();
    } elseif (!isset($_GET['number']) || $_GET['number'] == "") {
        $indiceMission = "en_cours";
        $mission_id = $_GET['mission_id'];
    } else {
        $indiceMission = $_GET['number'];
        $mission_id = $_GET['mission_id'];
    }

    redirectOut();
    $user_id = $_SESSION["id"];
    ?>

    <main>
        <!-- section qui affiche les informations de la mission -->
        <section class="py-5">
            <div class="container bg-primary text-center">
                <h1>Mission <?php echo $indiceMission ?> </h1>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="row">
                    <p>Feuille de comptabilité</p>
                </div>

                <?php
                // get all attributes for the corresponding mission with its corresponding devise
                $result = getMissionDeviseById($mission_id);
                if (sizeof($result["result"]) == 0) {
                    echo '
                        <div class="d-flex justify-content-center align-items-center" id="main">
                            <h1 class="me-3 pe-3 align-top border-end inline-block align-content-center">404</h1>
                            <div class="inline-block align-middle">
                                <h2 class="font-weight-normal lead" id="desc">The page you requested was not found.</h2>
                            </div>
                        </div>';
                    die();
                }
                $mission = $result["result"][0];

                //solde de la mission
                $solde = $mission["solde_initial"];
                ?>

                <div class="row">
                    <div class="col">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2" scope="col" class="text-center align-middle">Mission</th>
                                    <th class="table-active" scope="col">Lieu</th>
                                    <td scope="col"><?php echo $mission["lieu"] ?></td>

                                </tr>
                                <tr>
                                    <th class="table-active">Date de début</th>
                                    <td><?php echo $mission["debut"] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-active">Description</th>
                                    <th class="table-active">Date de fin</th>
                                    <td><?php echo $mission["fin"] ?></td>
                                </tr>
                                <tr>
                                    <td rowspan="3" colspan="3"><?php echo $mission["description"] ?></td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="col">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Solde initial</th>
                                    <td><?php echo $mission["solde_initial"] ?>
                                </tr>
                                <tr>
                                    <th>Monnaie</th>
                                    <td><?php echo $mission["nom"] .  "  " . $mission["symbole"] ?></td>
                                </tr>
                                <tr>
                                    <th>Taux de change</th>
                                    <td><?php echo $mission["taux_change"] ?></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <?php
        //etat de la mission
        if ($mission["etat"] != "en cours") {
            $hide = "py-5 d-none";
        } else {
            $hide = "py-5";
        }
        ?>

        <section class='<?php echo $hide ?>'>
            <?php
                // bouton terminer la mission
                echo '<form class = "container" method="POST" action="listeMissions.php" >';
                echo '
                            <div class = "col1">
                                <button name ="finishBtn" type = "submit" class = "button btn btn-warning">Terminer la mission</button>
                                <input type="hidden" name="token" value="' . $_SESSION["token"] . '">
                                <input type="hidden" name="action" value="finish' . $mission_id . '">
                            </div>';
                echo '</form>';
            ?>

            <!-- formulaire pour ajouter une nouvelle opération -->
            <form class="container py-3"
                action="page_mission.php?mission_id=<?php echo $mission_id ?>&number=<?php echo $indiceMission ?>"
                method="POST">
                <div class="row">
                    <p> Nouvelle opération :</p>
                </div>

                <div class="row">
                    <div class="col input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" placeholder="Date" id="date" name="date" required>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>

                    <div class="col">
                        <select class="form-select" aria-label="Default select example" name="type" id="type" required>
                            <option selected>Type de frais</option>
                            <?php
                            $nomenclature = getNomenclature();
                            $listeNom = $nomenclature["result"];
                            foreach ($listeNom as $nom) {
                                echo "<option value=" . $nom["text"] . " >" . $nom["text"] . "</option>";
                            } ?>
                        </select>
                    </div>

                    <div class="col form-outline">
                        <input type="text" class="form-control" id="description" name="description"
                            placeholder="description" required />
                        <input hidden type="text" id="token" name="token" value="<?php echo $_SESSION["token"] ?>" />
                    </div>

                    <div class="col form-outline">
                        <input type="number" class="form-control" name="montant" placeholder="Montant" />
                    </div>

                    <button type="submit" class="col btn-sm btn-success">
                        Ajouter
                    </button>



                </div>

                <?php

                if (sizeOf($_POST) > 0) {

                    // convert date :
                    $date = DateTime::createFromFormat('m/d/Y', htmlspecialchars($_POST["date"]));
                    $date = $date->format('Y-m-d');

                    // get id nomenclature
                    $text = htmlspecialchars($_POST["type"]);
                    $result = getNomByText($text);
                    $nom = $result["result"][0];
                    $nom = $nom["id"];

                    if ($_POST["description"] == "" || $_POST["date"] == "" || $_POST["montant"] == "" || $_POST["type"] == "") {
                        echo '    
                                <div class="mt-3 alert alert-warning alert-dismissible fade show">
                                <strong>Warning!</strong> Veuillez remplir tous les champs.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>';
                    } else {
                        // check token
                        if ($_POST["token"] == $_SESSION["token"]) {
                            $op = new Operation($date, htmlspecialchars($_POST["description"]), htmlspecialchars($_POST["montant"]), $nom, $mission_id);

                            //insert user into database
                            $ajout = addOperation($op);

                            if ($ajout["status"] == "success") {
                                if ($ajout["result"]) {
                                    echo '<div class="mt-3 alert alert-success alert-dismissible fade show">
                                <strong>Success!</strong> Opération ajoutée.
                                </div>';
                                }
                            } else {
                                echo "<div class='mt-3 alert alert-danger alert-dismissible fade show'>
                                <strong>Erreur!</strong> Erreur lors de l'ajout.
                                </div>";
                            };
                        }
                    }
                }
                ?>

            </form>
        </section>

        <!-- section qui affiche toute les opérations de la mission -->
        <section class="py-5">
            <div class="container">
                <div class="row">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Description de l'élément</th>
                                <th class="text-center">Crédit <?php echo $mission["symbole"] ?> </th>
                                <th class="text-center">Débit <?php echo $mission["symbole"] ?></th>
                                <th class="text-center">Solde <?php echo $mission["symbole"] ?> </th>
                                <th class="text-center">Crédit / Débit €</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $depense = 0;
                            $operation = getOperationByMissionId($mission_id);
                            $listeOp = $operation["result"];
                            foreach ($listeOp as $op) {
                            ?>
                            <tr>
                                <td><?php echo $op["date"] ?></td>
                                <td><?php echo $op["text"] ?></td>
                                <td><?php echo $op["description"] ?></td>
                                <td class="table-danger"><?php if ($op["montant"] > 0) {
                                                                    echo $op["montant"];
                                                                    $solde += $op["montant"];
                                                                } ?></td>
                                <td class="table-warning"><?php if ($op["montant"] < 0) {
                                                                    echo $op["montant"];
                                                                    $solde += $op["montant"];
                                                                    $depense -= $op["montant"];
                                                                } ?></td>
                                <td class="table-primary"><?php echo $solde ?></td>
                                <td class="table-primary"><?php echo $op["montant"] * $mission["taux_change"] ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Effets à recevoir</th>
                                    <td class="table-primary">€</td>
                                    <td class="table-primary"><?php if ($solde < 0) {
                                                                    echo $solde * $mission["taux_change"];
                                                                } else {
                                                                    echo 0;
                                                                } ?></td>
                                </tr>
                                <tr>
                                    <th>Effets à payer</th>
                                    <td class="table-primary">€</td>
                                    <td class="table-primary"><?php if ($solde > 0) {
                                                                    echo $solde * $mission["taux_change"];
                                                                } else {
                                                                    echo 0;
                                                                } ?></td>
                                </tr>
                                <tr>
                                    <th>Solde actuel</th>
                                    <td class="table-primary">€</td>
                                    <td class="table-primary"><?php echo $solde * $mission["taux_change"] ?></td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="col">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Total</th>
                                    <td class="table-primary"><?php echo $solde * $mission["taux_change"] ?></td>
                                    <td class="table-primary">€</td>
                                </tr>
                                <tr>
                                    <th>Total dépense</th>
                                    <td class="table-primary"><?php echo $depense * $mission["taux_change"] ?></td>
                                    <td class="table-primary">€</td>
                                </tr>
                               
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>


    </main>

    <?php
    include "footer.html" ?>
</body>

</html>