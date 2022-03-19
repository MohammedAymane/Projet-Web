<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8"/>
        <title>Ma mission</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link href="/Users/hortense/enregistrements/informatique/Bootstrap/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    </head>

    <body>
        <!-- Extension jquery -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        
        <!-- Extension DATEPICKER -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

        <?php 
        include "./services/authentication.php";
        include "navbar.php";
        include "./services/dbFunctions.php";
        redirectOut();
        $user_id = $_SESSION["id"];
        ?>

        <main>
            <section class="py-5">
            <div class="container bg-primary text-center" >
                <h1>Missions 1</h1>
            </div>
            </section>

            <section class="py-5">
                <div class="container">
                    <div class="row">
                    <p> Nouvelle opération :</p>
                    </div>

                    <div class="row">
                        <div class="col input-group date" data-provide="datepicker">
                            <input type="text" class="form-control" placeholder="Date">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>     

                        <div class="col">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Type de frais</option>
                                <?php                           
                                    $nomenclature=getNomenclature();
                                    $listeNom = $nomenclature["result"];
                                    foreach($listeNom as $nom) { ?>
                                        <option value="1"> <?php echo $nom["nom"] ?> </option>
                                    <?php } ?>
                            </select>                       
                        </div>

                        <div class="col form-outline">
                            <input type="text" class="form-control" placeholder="Description"/>
                        </div>
                        
                        <div class="col form-outline">
                            <input type="number" min="0" class="form-control" placeholder="Montant" />
                        </div>

                        <button type="button" class="col btn-sm btn-success">
                            Ajouter 
                        </button>

                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <p>Feuille de comptabilité</p>
                    </div>

                    <?php
                        $id = 1;
                        $result = getMissionById2($id);
                        $mission = $result["result"][0];
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
                                        <td><?php echo $mission["solde_initial"] ?><td>
                                    </tr>
                                    <tr>
                                        <th>Taux de change</th>
                                        <td>?</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-5">
                <div class="container">
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Description de l'élément</th>
                                    <th class="text-center">Crédit</th>
                                    <th class="text-center">Débit</th>
                                    <th class="text-center">Solde</th>
                                    <th class="text-center">Crédit / Débit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $mission_id = 1;
                                    $depense = 0;
                                    $operation = getOperationByMissionId($mission_id);
                                    $listeOp = $operation["result"];
                                    foreach($listeOp as $op) {
                                ?>
                                <tr>
                                    <td><?php echo $op["date"]?></td>
                                    <td><?php echo $op["nom"]?></td>
                                    <td><?php echo $op["description"]?></td>
                                    <td class="table-danger"><?php if ($op["montant"] > 0) {echo $op["montant"]; $solde += $op["montant"];}?></td>
                                    <td class="table-warning"><?php if ($op["montant"] < 0) {echo $op["montant"]; $solde += $op["montant"]; $depense -= $op["montant"];}?></td>
                                    <td class="table-primary"><?php echo $solde ?></td>
                                    <td class="table-primary"><?php echo $op["montant"] ?></td>
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
                                        <td class="table-primary">$</td>
                                        <td class="table-primary"><?php if ($solde < 0) {echo $solde;} else {echo 0;} ?></td>
                                    </tr>
                                    <tr>
                                        <th>Effets à payer</th>
                                        <td class="table-primary">$</td>
                                        <td class="table-primary"><?php if ($solde > 0) {echo $solde;} else {echo 0;} ?></td>
                                    </tr>
                                    <tr>
                                        <th>Solde actuel</th>
                                        <td class="table-primary">$</td>
                                        <td class="table-primary"><?php echo $solde ?></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="col">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Total</th>
                                        <td class="table-primary"><?php echo $solde?></td>
                                        <td class="table-primary">$</td>
                                    </tr>
                                    <tr>
                                        <th>Total dépense</th>
                                        <td class="table-primary"><?php echo $depense ?></td>
                                        <td class="table-primary">$</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </section>


        </main>

    
        


    </body>
</html>