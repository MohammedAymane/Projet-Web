<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <title>Liste de mes missions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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
        <section class="py-5">
            <div class="container bg-primary text-center">
                <h1>Mes Missions</h1>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="row">
                    <p class="col-4">Ajouter une mission :</p>
                    <button type="button" class="col-2 btn-sm btn-success">
                        <a href="page_mission.php" class="link-light"> Nouvelle Mission </a>
                    </button>
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

                                    $mission_id = 1;

                                    echo '<tr id="' . $mission->getId() . '">
                                            <th scope="col"><a href="page_mission.php?mission_id=' . $mission_id . '" class="link-primary"> Mission ' . $indiceMission-- . '</a></th>
                                            <th scope="col">' . $mission->getLieu() . '</th>
                                            <th scope="col">' . $mission->getDebut() . ' - ' . $mission->getFin() . '</th>
                                            <th scope="col">' . $mission->getSolde_initial() . '</th>
                                            <th scope="col">' . $mission->getEtat() . '</th>';

                                    echo '<form method="POST" >';
                                    if ($mission->getEtat() == "enCours") {
                                        echo '
                                                    <th scope="col">
                                                        <button name ="editBtn" type = "submit" class = "button btn-sm btn-warning">MODIFIER</button>
                                                        <input type="hidden" name="token" value="' . $_SESSION["token"] . '">
                                                    </th>';
                                    }
                                    if ($mission->getEtat() == "annulee") {
                                        echo '
                                                    <th scope="col">
                                                        <button name ="deleteBtn" type = "submit" class = "button btn-sm btn-danger">SUPPRIMER</button>
                                                        <input type="hidden" name="token" value="' . $_SESSION["token"] . '">
                                                   </tr>';
                                    }
                                    echo '</form>';
                                    if (isset($_POST['editBtn'])) {
                                        //TODO : Open modal to edit mission
                                    }
                                    if (isset($_POST['deleteBtn']) && $_POST['token'] == $_SESSION['token']) {
                                        deleteMissionById($mission->getId());
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