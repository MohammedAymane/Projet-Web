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
    redirectOut();

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
                    <button type="button" class="col-2 btn-sm btn-success">Nouvelle Mission</button>
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
                    </table>
                </div>


            </div>



        </section>


    </main>





</body>

</html>