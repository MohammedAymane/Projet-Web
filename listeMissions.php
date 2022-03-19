<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <title>Liste de mes missions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <!-- Extension jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" defer></script>

    <!-- Extension DATEPICKER -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        defer></script>
</head>

<body>

    <?php
    include "./services/authentication.php";
    include "navbar.php";
    include "./services/dbFunctions.php";
    redirectOut();
    $user_id = $_SESSION["id"];

    ?>
    <main>
        <div class="container-fluid p-4 bg-primary text-center text-white opacity-50">
            <h1>Mes Missions</h1>
        </div>
        <?php

        if (sizeOf($_POST) > 0 && isset($_POST["action"]) && $_POST["action"] == "add") {
            // convert date :
            $debut = DateTime::createFromFormat('m/d/Y', htmlspecialchars($_POST["debut-mission"]));
            $debut = $debut->format('Y-m-d');
            // convert date :
            $fin = DateTime::createFromFormat('m/d/Y', htmlspecialchars($_POST["fin-mission"]));
            $fin = $fin->format('Y-m-d');

            // get id nomenclature
            // $text = htmlspecialchars($_POST["type"]);
            // $result = getNomByText($text);
            // $nom = $result["result"][0];
            // $nom = $nom["id"];

            if (!($_POST["lieu-mission"]) || !($_POST["debut-mission"]) || !($_POST["fin-mission"]) || !($_POST["devise-mission"]) || !($_POST["solde-mission"]) || !($_POST["description-mission"])) {
                echo '    
                                            <div class="container mt-3 alert alert-warning alert-dismissible fade show">
                                                <strong>Warning!</strong> Veuillez remplir tous les champs.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>';
            } else {
                if ($debut > $fin) {
                    echo '    
                                            <div class="container mt-3 alert alert-warning alert-dismissible fade show">
                                                <strong>Warning!</strong> Veuillez choisir des dates cohérentes.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>';
                } else {
                    $newMission = new Mission(htmlspecialchars($_POST["lieu-mission"]), $debut, $fin, htmlspecialchars($_POST["devise-mission"]), htmlspecialchars($_POST["description-mission"]), "enCours", htmlspecialchars($_POST["solde-mission"]), $user_id);

                    $ajout = addMission($newMission);
                    print_r($newMission);
                    echo "*********** <br>";
                    print_r($ajout);
                    if ($ajout["status"] == "success") {
                        if ($ajout["result"]) {
                            echo '<div class="mt-3 alert alert-success alert-dismissible fade show">
                                            <strong>Success!</strong> Opération ajoutée.
                                            <a href="page_mission.php">lien</a>
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
        <section class="py-5">
            <div class="container">
                <div class="row">
                    <p class="col-4">Ajouter une mission :</p>
                    <button type="button" class="col-2 btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#missionModal">
                        Nouvelle Mission
                    </button>
                    <div class="modal fade" id="missionModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Nouvelle Mission</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="listeMissions.php" method="POST">
                                        <div class="mb-3">
                                            <label for="lieu-mission" class="col-form-label">Lieu:</label>
                                            <input type="text" class="form-control" id="lieu-mission"
                                                name="lieu-mission" required>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col">
                                                <label for="debut-mission" class="col-form-label">Début: </label>
                                                <div class="col date" data-provide="datepicker">

                                                    <input type="text" class="form-control md-2"
                                                        placeholder="MM/JJ/YYYY" name="debut-mission" id="debut-mission"
                                                        required>
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calandar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label for="fin-mission" class="col-form-label">Fin: </label>
                                                <div class="col date" data-provide="datepicker">

                                                    <input type="text" class="form-control md-2"
                                                        placeholder="MM/JJ/YYYY" name="fin-mission" id="fin-mission"
                                                        required>
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="devise-mission" class="col-form-label">Devise:</label>
                                            <input type="text" class="form-control" name="devise-mission"
                                                id="devise-mission" required>
                                            <input hidden type="text" name="action" value="add">
                                            <input hidden type="text" name="token"
                                                value="<?php echo $_SESSION["token"] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="solde-mission" class="col-form-label">Solde initial:</label>
                                            <input type="number" class="form-control" name="solde-mission"
                                                id="solde-mission" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description-mission" class="col-form-label">Description:</label>
                                            <textarea class="form-control" name="description-mission"
                                                id="description-mission" required></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Ajouter</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5 overflow-auto">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Mission</th>
                                <th scope="col">Lieu</th>
                                <th scope="col">Date</th>
                                <th scope="col">Solde</th>
                                <th scope="col">Etat</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $missions = [];
                            echo $user_id;

                            $result = getMissionsByUserId($user_id);
                            if ($result["status"] == "success") {
                                $missions = array_reverse($result["result"]);
                            }
                            if (!empty($missions)) {
                                $indiceMission = count($missions);
                                foreach ($missions as $mission) {

                                    $mission_id = $mission->getId();

                                    echo '<tr id="' . $mission->getId() . '">
                                            <th scope="col"><a href="page_mission.php?mission_id=' . $mission_id . '" class="link-primary"> Mission ' . $indiceMission-- . '</a></th>
                                            <th scope="col">' . $mission->getLieu() . '</th>
                                            <th scope="col">' . $mission->getDebut() . ' - ' . $mission->getFin() . '</th>
                                            <th scope="col">' . $mission->getSolde_initial() . '</th>
                                            <th scope="col">' . $mission->getEtat() . '</th>';
                                    if ($mission->getEtat() == "enCours") {
                                        echo '<form method="POST" >';
                                        echo '
                                                    <th scope="col">
                                                        <button name ="editBtn" type = "submit" class = "button btn-sm btn-warning">MODIFIER</button>
                                                        <input type="hidden" name="token" value="' . $_SESSION["token"] . '">
                                                        <input type="hidden" name="action" value="edit' . $mission->getId() . '">
                                                    </th>';
                                        echo '</form>';
                                    }
                                    if ($mission->getEtat() == "annulee") {
                                        echo '<form method="POST" >';
                                        echo '
                                                    <th scope="col">
                                                        <button name ="deleteBtn" type = "submit" class = "button btn-sm btn-danger">SUPPRIMER</button>
                                                        <input type="hidden" name="token" value="' . $_SESSION["token"] . '">
                                                        <input type="hidden" name="action" value="delete' . $mission->getId() . '">
                                                   </tr>';
                                        echo '</form>';
                                    }
                                    if (sizeOf($_POST) > 0 && isset($_POST["action"]) && $_POST["action"] == "edit" . $mission->getId()) {
                                        //TODO : Open modal to edit mission
                                    }
                                    if (sizeOf($_POST) > 0 && isset($_POST["action"]) && $_POST["action"] == "delete" . $mission->getId()) {
                                        deleteMissionById($mission->getId());
                            ?>
                            <script type="text/javascript">
                            window.location.href = 'listeMissions.php';
                            </script>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
</body>

</html>