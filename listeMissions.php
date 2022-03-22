<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <title>Liste de mes missions</title>
    <!-- Bootsrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Extension DatePicker css -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!-- Bootstrap script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <!-- Extension jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" defer></script>

    <!-- Extension DATEPICKER -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        defer></script>
</head>

<body>

    <?php
    // starting of the session, verification of the user, adding header (navbar) and include data base manipulation fonctions
    include "./services/authentication.php";
    include "navbar.php";
    include "./services/dbFunctions.php";
    redirectOut();
    $user_id = $_SESSION["id"];

    ?>
    <main>
        <!-- Page title banner -->
        <div class="container-fluid p-4 bg-primary text-center text-white opacity-50">
            <h1>Mes Missions</h1>
        </div>

        <?php
        //verification of the datas of the form and addition of a new mission for the current user
        if (sizeOf($_POST) > 0 && isset($_POST["action"]) && $_POST["action"] == "add") {
            if ($_SESSION["token"] == $_POST["token"]) {
                // convert date :
                $debut = DateTime::createFromFormat('m/d/Y', htmlspecialchars($_POST["debut-mission"]));
                $debut = $debut->format('Y-m-d');
                // convert date :
                $fin = DateTime::createFromFormat('m/d/Y', htmlspecialchars($_POST["fin-mission"]));
                $fin = $fin->format('Y-m-d');
                
                //verification of completion of fields
                if (!($_POST["lieu-mission"]) || !($_POST["debut-mission"]) || !($_POST["fin-mission"]) || !($_POST["devise-mission"]) || !($_POST["solde-mission"]) || !($_POST["description-mission"])) {
                    echo '    
                                            <div class="container mt-3 alert alert-warning alert-dismissible fade show">
                                                <strong>Warning!</strong> Veuillez remplir tous les champs.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>';
                } else {
                    // testing coherence of time datas
                    if ($debut > $fin) {
                        echo '    
                                            <div class="container mt-3 alert alert-warning alert-dismissible fade show">
                                                <strong>Warning!</strong> Veuillez choisir des dates cohérentes.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>';
                    } else {

                        // if all tests are passed, creation of a new instance of Mission to inject in the datatbase
                        $newMission = new Mission(htmlspecialchars($_POST["lieu-mission"]), $debut, $fin, htmlspecialchars($_POST["devise-mission"]), htmlspecialchars($_POST["description-mission"]), "en cours", htmlspecialchars($_POST["solde-mission"]), $user_id);

                        $ajout = addMission($newMission);
                        if ($ajout["status"] == "success") {
                            if ($ajout["result"]) { 
                                echo '<div class="mt-3 alert alert-success alert-dismissible fade show">
                                            <strong>Success!</strong> Opération ajoutée.
                                  </div>';
                            }
                        } else { //In case of an issue with the database return an error
                            echo "<div class='mt-3 alert alert-danger alert-dismissible fade show'>
                                            <strong>Erreur!</strong> Erreur lors de l'ajout.
                              </div>";
                        };
                    }
                }
            }
        }
        ?>
        <section class="py-5">
            <div class="container">

                <!-- Adding a mission  -->
                <div class="row">
                    <p class="col-4">Ajouter une mission :</p>
                    <button type="button" class="col-2 btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#missionModal">
                        Nouvelle Mission
                    </button>
                    <!-- Modal containing the form to add a new mission -->
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
                                    <!-- Form to add a new mission -->
                                    <form action="listeMissions.php" method="POST">
                                        <div class="mb-3">
                                            <label for="lieu-mission" class="col-form-label">Lieu:</label>
                                            <input type="text" class="form-control" id="lieu-mission"
                                                name="lieu-mission" required>
                                        </div>
                                        <!-- datePickers for the beginnig and the ending of the new mission -->
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
                                        <!-- spinner to choose a currency -->
                                        <div class="mb-3">
                                            <label for="devise-mission" class="col-form-label">Devise:</label>
                                            <select required name="devise-mission" id="devise-mission"
                                                class="form-control" id="service" required>
                                                <?php
                                                echo "<option value=''>Choisissez la devise</option>";
                                                foreach (["euro", "dollars", "yen", "yuan"] as $menu) {
                                                    echo "<option value='" . $menu . "'>" . $menu . "</option>";
                                                }
                                                ?>
                                            </select>
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
                
                <!-- Table showing all ths mission of the current user -->
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
                            $result = getMissionsByUserId($user_id);
                            if ($result["status"] == "success") {
                                $missions = array_reverse($result["result"]); // reverse the database to show the last mission first
                            }
                            if (!empty($missions)) {
                                $totalMission = count($missions);
                                
                                $indiceMission = $totalMission + 1; // adding numbering the missions of the current user
                                foreach ($missions as $mission) {

                                    $mission_id = $mission->getId();

                                    $indiceMission  -= 1;

                                    // adding a link to the mission page of every mission
                                    echo '<tr id="' . $mission->getId() . '">
                                            <th scope="col"><a href="page_mission.php?mission_id=' . $mission_id . '&number=' . $indiceMission . '" class="link-primary"> Mission ' . $indiceMission . '</a></th> 
                                            <th scope="col">' . $mission->getLieu() . '</th>
                                            <th scope="col">' . $mission->getDebut() . ' - ' . $mission->getFin() . '</th>
                                            <th scope="col">' . $mission->getSolde_initial() . '</th>
                                            <th scope="col">' . $mission->getEtat() . '</th>';
                                    if ($mission->getEtat() == "en cours") { // if the mission is still ongoing, the user can cancel it
                                        echo '<form method="POST" >';
                                        echo '
                                                    <th scope="col">
                                                        <button name ="cancelBtn" type = "submit" class = "button btn-sm btn-warning">ANNULER</button>
                                                        <input type="hidden" name="token" value="' . $_SESSION["token"] . '">
                                                        <input type="hidden" name="action" value="cancel' . $mission->getId() . '">
                                                    </th>';
                                        echo '</form>';
                                    }
                                    if ($mission->getEtat() == "annulee") { // if th mission is canceled, the user can delete it
                                        echo '<form method="POST" >';
                                        echo '
                                                    <th scope="col">
                                                        <button name ="deleteBtn" type = "submit" class = "button btn-sm btn-danger">SUPPRIMER</button>
                                                        <input type="hidden" name="token" value="' . $_SESSION["token"] . '">
                                                        <input type="hidden" name="action" value="delete' . $mission->getId() . '">
                                                   </tr>';
                                        echo '</form>';
                                    }
                                    // canceling a mission
                                    if (sizeOf($_POST) > 0 && isset($_POST["action"]) && $_POST["action"] == "cancel" . $mission->getId()) { 
                                        cancelMission($mission->getId());
                                        echo '
                                            <script>
                                                window.location.href = "listeMissions.php";
                                            </script>';
                                    }
                                    // deleting a mission
                                    if (sizeOf($_POST) > 0 && isset($_POST["action"]) && $_POST["action"] == "delete" . $mission->getId()) {
                                        if ($_SESSION["token"] == $_POST["token"]) {
                                            deleteMissionById($mission->getId());
                                            echo '
                                            <script>
                                                window.location.href = "listeMissions.php";
                                            </script>';
                                        }
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
    <!-- include the footer -->
    <?php
    include "footer.html" ?>
</body>

</html>