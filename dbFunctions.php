<?php
//create function to add user
function addUser($nom, $prenom, $email, $telephone, $password2, $service)
{
    include "config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `users` (`firstName`, `lastName`, `email`, `phone`, `password`, `service`) VALUES (?, ?, ?, ?, ?, ?)";
        $req = $pdo->prepare($sql);
        $req->execute([$prenom, $nom, $email, $telephone, $password2, $service]);
        //close connection
        $pdo = null;
        echo '
                            <div class="mt-3 alert alert-success alert-dismissible fade show">
                                <strong>Success!</strong> Vous êtes inscrit maintenant.
                                <a href="login.php">Connectez vous.</a>
                            </div>';
    } catch (PDOException $e) {
        echo '
                            <div class="mt-3 alert alert-success alert-dismissible fade show">
                                <strong>Error!</strong> Une erreur s\'est produite, réessayez une autre fois.
                                <a href="login.php">Connectez vous.</a>
                            </div>';
        return "Connection failed: " . $e->getMessage();
    }
}

//create function to check if user exists with email
function checkUser($email)
{
    include "config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM `users` WHERE `email` = ?";
        $req = $pdo->prepare($sql);
        $req->execute([$email]);
        $result = $req->fetchAll();
        //close connection
        $pdo = null;
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return "Connection failed: " . $e->getMessage();
    }
}

//create a function to login a user
function loginUser($email, $password2)
{
    include "config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM `users` WHERE `email` = ?";
        $req = $pdo->prepare($sql);
        $req->execute([$email]);
        $result = $req->fetchAll();
        //close connection
        $pdo = null;
        if (count($result) > 0) {
            if (password_verify($password2, $result[0]["password"])) {
                return [true, [$result[0]["Id"], $result[0]["firstName"], $result[0]["lastName"], $result[0]["role"]]];
            } else {
                return
                    [false, "Email mot de passe incorrect"];
            }
        } else {
            return [false, "Email mot de passe incorrect"];
        }
    } catch (PDOException $e) {
        return "Connection failed: " . $e->getMessage();
    }
}