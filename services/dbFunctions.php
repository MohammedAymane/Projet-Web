<?php

use LDAP\Result;

include_once "./classes/user.class.php";
include_once "./classes/mission.class.php";

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

function addMission($newMission)
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `missions` (`lieu`, `debut`, `fin`, `devise`, `description`, `etat`, `solde_initial`, `user_id`) VALUES (?, ?, ?, ?, ?, ?)";
        $req = $pdo->prepare($sql);
        $req->execute(array($newMission->getLieu(), $newMission->getDebut(), $newMission->getFin(), $newMission->getDevise(), $newMission->getDescription(), $newMission->getEtat(), $newMission->getSolde_initial(), $newMission->getUser_id()));
        //close connection
        $pdo = null;

        return [
            "status" => "success",
            "result" => true
        ];
    } catch (PDOException $e) {
        return [
            "status" => "error",
            "message" => "Connection failed: " . $e->getMessage()
        ];
    }
}
// get all missions
function getMissions()
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM `missions`";
        $req = $pdo->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        //close connection
        $pdo = null;
        $missions = [];
        foreach($result as $mission){
            $missions[] = new Mission($mission["lieu"],$mission["debut"],$mission["fin"],$mission["devise"],$mission["description"],$mission["etat"],$mission["solde_initial"],$mission["user_id"]); 
        }
        return [
            "status" => "success",
            "result" => $missions
        ];
    } catch (PDOException $e) {
        return [
            "status" => "error",
            "message" => "Connection failed: " . $e->getMessage()
        ];
    }
}
// get all missions from a user
function getMissionsByUserId($user_id)
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM `missions` WHERE `user_id`= ? ";
        $req = $pdo->prepare($sql);
        $req->execute([$user_id]);
        $result = $req->fetchAll();
        //close connection
        $pdo = null;
        $missions = [];
        foreach($result as $mission){
            $missions[] = new Mission($mission["lieu"],$mission["debut"],$mission["fin"],$mission["devise"],$mission["description"],$mission["etat"],$mission["solde_initial"],$mission["user_id"]); 
        }
        return [
            "status" => "success",
            "result" => $missions
        ];
    } catch (PDOException $e) {
        return [
            "status" => "error",
            "message" => "Connection failed: " . $e->getMessage()
        ];
    }

}
function getMissionById($id){
        include "./config/config.php";
        // Create connection with mysql database using pdo surrended by try catch
        try {
            $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM `missions` WHERE `id`= ? ";
            $req = $pdo->prepare($sql);
            $req->execute([$id]);
            $result = $req->fetchAll();
            //close connection
            $pdo = null;
            $mission = $result[0];
            $classMission = new Mission($mission["lieu"],$mission["debut"],$mission["fin"],$mission["devise"],$mission["description"],$mission["etat"],$mission["solde_initial"],$mission["user_id"]); 
            return [
                "status" => "success",
                "result" => $classMission
            ];
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "Connection failed: " . $e->getMessage()
            ];
        }
    }

// get all missions
function getUsers()
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT `firstName` FROM `users`";
        $req = $pdo->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        //close connection
        $pdo = null;   
        return [
            "status" => "success",
            "result" => $result
        ];
    } catch (PDOException $e) {
        return [
            "status" => "error",
            "message" => "Connection failed: " . $e->getMessage()
        ];
    }
}


//get all nomenclature itms from database
function getNomenclatureItems() {
    include "./config/config.php";

    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * from nomenclature";
        $pdoStatement=$pdo->query($sql);
        $result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        $json=json_encode($result);
        //close connection
        $pdo = null;
        return [
            "status" => "success",
            "result" => $json
        ];
      } catch (PDOException $e) {
        return [
            "status" => "error",
            "message" => "Connection failed: " . $e->getMessage()
        ];
    }
}



