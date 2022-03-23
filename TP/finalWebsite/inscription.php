<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
    .login-form {
        width: 340px;
        margin: 50px auto;
        font-size: 15px;
    }

    .login-form form {
        margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }

    .login-form h2 {
        margin: 0 0 15px;
    }

    .form-control,
    .btn {
        min-height: 38px;
        border-radius: 2px;
    }

    .btn {
        font-size: 15px;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="login-form">
        <form action="inscription.php" method="post">
            <h2 class="text-center">Créer un compte</h2>
            <div class="form-group">
                <input name="mail" type="text" class="form-control" placeholder="email" required="required">
            </div>
            <div class="form-group">
                <input name="user" type="text" class="form-control" placeholder="Username" required="required">
            </div>
            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Password" required="required">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
            </div>
        </form>


        <?php if (sizeOf($_POST) > 0) {
            if ($_POST["user"] == "") {
                echo "<tr> 
                              <th><label for='error'>Message d'érreur</label></th>
                              <td><input type='txt' name='error' maxlength='128' size='64' value='Username manquant.' /></td>
                           </tr>";
            }
            if ($_POST["password"] == "") {
                echo "<tr> 
                              <th><label for='error'>Message d'érreur</label></th>
                              <td><input type='txt' name='error' maxlength='128' size='64' value='Password manquante.' /></td>
                           </tr>";
            }
            if ($_POST["mail"] == "") {
                echo "<tr> 
                              <th><label for='error'>Message d'érreur</label></th>
                              <td><input type='txt' name='error' maxlength='128' size='64' value='Email manquante.' /></td>
                           </tr>";
            } else {
                include "dbFunctions.php";
                $user = htmlspecialchars($_POST["user"]);
                $hashedPassword = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT);
                $email = htmlspecialchars($_POST["mail"]);
                addUser($pdo, $user, $hashedPassword, $email);
                echo '
                  <div class="alert alert-success alert-dismissible fade show">
                     <strong>Success!</strong> Vous êtes inscrit maintenant.
                     <a href="login.php">Connectez vous.</a>
                  </div>';
            }
        } ?>
    </div>
</body>

</html>