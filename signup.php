<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-Light">

    <h1 class="mt-4 text-center">Créer votre compte</h1>

    <div class="shadow rounded bg-white w-50 p-3 container border border-1 mt-3">
        <form class="container" action="signup.php" method="POST">
            <div class="row form-row">
                <div class="form-group col-md-6">
                    <label for="lastName">Nom</label>
                    <input name="lastName" type="text" class="mt-1 form-control" id="lastName" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="firstName">Prénom</label>
                    <input type="text" class="mt-1 form-control" id="firstName" name="firstName" required>
                </div>
            </div>

            <div class="form-group">
                <label for="phone">Téléphone</label>
                <input name="phone" type="phone" class="mt-1 form-control" id="phone" required>
            </div>
            <div class="form-group">
                <label for="service">Service de rattachement</label>
                <input name="service" type="text" class="mt-1 form-control" id="service" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="mt-1 form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="mt-1 form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
            </div>
            <button type="submit" class="mt-3 w-100 btn btn-success mx-auto d-block">S'inscrire</button>
            <?php if (sizeOf($_POST) > 0) {
                if ($_POST["email"] == "" || $_POST["password"] == "" || $_POST["lastName"] == "" || $_POST["firstName"] == "" || $_POST["phone"] == "" || $_POST["service"] == "") {
                    echo '    
                    <div class="mt-3 alert alert-warning alert-dismissible fade show">
                        <strong>Warning!</strong> Veuillez remplir tous les champs.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>';
                } else {
                    include "dbFunctions.php";
                    $email = htmlspecialchars($_POST["email"]);
                    if (checkUser($email)) {
                        echo '
                        <div class="mt-3 alert alert-danger alert-dismissible fade show">
                            <strong>Error!</strong> Adresse email déjà utilisée.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>';
                        // show a modal to inform the user that the user already exists

                    } else {
                        //get user informations from form
                        $hashedPassword = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT);
                        $service = htmlspecialchars($_POST["service"]);
                        $firstName = htmlspecialchars($_POST["firstName"]);
                        $lastName = htmlspecialchars($_POST["lastName"]);
                        $phone = htmlspecialchars($_POST["phone"]);
                        //insert user into database
                        addUser($lastName, $firstName, $email, $phone, $hashedPassword, $service);
                        echo '
                            <div class="mt-3 alert alert-success alert-dismissible fade show">
                                <strong>Success!</strong> Vous êtes inscrit maintenant.
                                <a href="login.php">Connectez vous.</a>
                            </div>';
                    }
                }
            }
            ?>
        </form>
    </div>

</body>

</html>