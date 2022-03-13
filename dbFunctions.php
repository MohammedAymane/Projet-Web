<?php


include_once "./classes/user.class.php";
//create function to add user
function addUser($newUser)
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `users` (`firstName`, `lastName`, `email`, `phone`, `password`, `service`) VALUES (?, ?, ?, ?, ?, ?)";
        $req = $pdo->prepare($sql);
        $req->execute(array($newUser->getFirstname(), $newUser->getLastname(), $newUser->getEmail(), $newUser->getPhone(), $newUser->getPassword(), $newUser->getService()));
        //close connection
        $pdo = null;

        return [
            "status" => "success",
            "result" => true
        ];
        $s = '<div class="mt-3 alert alert-success alert-dismissible fade show">
                                <strong>Success!</strong> Vous êtes inscrit maintenant.
                                <a href="login.php">Connectez vous.</a>
                            </div>';
    } catch (PDOException $e) {
        return [
            "status" => "error",
            "message" => "Connection failed: " . $e->getMessage()
        ];
    }
}

//create function to check if user exists with email
function checkUser($email)
{
    include "./config/config.php";
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
            return [
                "status" => "success",
                "result" => true
            ];
        } else {
            return [
                "status" => "success",
                "result" => false
            ];
        }
    } catch (PDOException $e) {
        return [
            "status" => "error",
            "message" => "Connection failed: " . $e->getMessage()
        ];
    }
}

//create a function to login a user
function loginUser($email, $password2)
{
    include "./config/config.php";
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
        if (count($result) > 0 && password_verify($password2, $result[0]["password"]))
            return ["status" => "success", "result" => [true, $result[0]]];

        return ["status" => "success", "result" => false];
    } catch (PDOException $e) {
        return [
            "status" => "error",
            "message" => "Connection failed: " . $e->getMessage()
        ];
    }
}