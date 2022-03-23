<?php
session_start();
include "dbFunctions.php";
if (!isset($_SESSION["loggedIn"])) {
    $_SESSION["loggedIn"] = false;
}
if ($_SESSION["loggedIn"]) {
    header("Location:index.php");
}
if (sizeOf($_POST) > 0) {
    if ($_POST["user"] == "") {
        echo "<tr> 
                              <th><label for='error'>Message d'érreur</label></th>
                              <td><input type='txt' name='error' maxlength='128' size='64' value='Username manquant.' /></td>
                           </tr>";
    }
    if ($_POST["password"] == "") {
        echo "<tr> 
                              <th><label for='error'>Message d'érreur</label></th>
                              <td><input type='txt' name='error' maxlength='128' size='64' value='Password manquant.' /></td>
                           </tr>";
    } else {
        $user = htmlspecialchars($_POST["user"]);
        $password = htmlspecialchars($_POST["password"]);
        if (checkUser($pdo, $user, $password)) {
            $_SESSION["loggedIn"] = true;
            $_SESSION["id"] = $user;
            $_SESSION["name"] = $user;
            $_SESSION["token"] = md5(time() * rand(1, 574) . $user);
            header("Location:index.php");
        } else {
            echo '
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Error!</strong> A problem has been occurred while submitting your login form.
                    </div>';
            echo $user;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
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
        <form action="login.php" method="post">
            <h2 class="text-center">Log in</h2>
            <div class="form-group">
                <input name="user" type="text" class="form-control" placeholder="Username" required="required" />
            </div>
            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Password"
                    required="required" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Log in</button>
            </div>
        </form>
        <p class="text-center"><a href="inscription.php">Créer un compte</a></p>
        <p class="text-center"><a href="citation.php">Voir les citations</a></p>
    </div>
</body>

</html>