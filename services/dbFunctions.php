<?php

use LDAP\Result;

include_once "./classes/user.class.php";
include_once "./classes/mission.class.php";
include_once "./classes/operation.class.php";

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
        foreach ($result as $mission) {
            $missions[] = new Mission($mission["lieu"], $mission["debut"], $mission["fin"], $mission["devise"], $mission["description"], $mission["etat"], $mission["solde_initial"], $mission["user_id"], $mission["id"]);
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
        foreach ($result as $mission) {
            $missions[] = new Mission($mission["lieu"], $mission["debut"], $mission["fin"], $mission["devise"], $mission["description"], $mission["etat"], $mission["solde_initial"], $mission["user_id"], $mission["id"]);
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
function getMissionById($id)
{
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
        $classMission = new Mission($mission["lieu"], $mission["debut"], $mission["fin"], $mission["devise"], $mission["description"], $mission["etat"], $mission["solde_initial"], $mission["user_id"], $mission["id"]);
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

//get Mission by different condition name of employe et status of mission
function getMissionsByWhere($firstName, $lastName, $status)
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT U.firstName, U.lastName, M.lieu, M.debut, M.fin, M.etat, M.solde_initial, M.devise
            FROM missions M LEFT JOIN users U on M.user_id = U.Id WHERE U.firstName LIKE ? AND U.lastName LIKE ? AND M.etat LIKE ?;";
        // print_r($status);
        $req = $pdo->prepare($sql);
        $req->execute(['%'.$firstName.'%', '%'.$lastName.'%', '%'.$status.'%']);
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

// get all names of employes
function getUsers()
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT DISTINCT firstName, lastName FROM `users`";
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

//get all names of service
function getService()
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT DISTINCT service FROM `users`";
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

//get all informations of employes
function getAllUsers($service)
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT DISTINCT * FROM `users` WHERE service LIKE ? ORDER BY firstName asc, lastName asc";
        $req = $pdo->prepare($sql);
        $req->execute(['%'.$service.'%']);
        $result = $req->fetchAll();
        //close connection
        $pdo = null;
        $users = [];
        foreach($result as $user){
            $users[] = new User($user["firstName"],$user["lastName"],$user["email"],$user["password"],$user["role"],$user["service"],$user["phone"]);
        }
        return [
            "status" => "success",
            "result" => $users
        ];
    } catch (PDOException $e) {
        return [
            "status" => "error",
            "message" => "Connection failed: " . $e->getMessage()
        ];
    }
}

// get all nomenclature
function getNomenclature()
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT `text` FROM `nomenclature` WHERE parent != '#'";
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

//get all nomenclature items from database
function getNomenclatureItems()
{
    include "./config/config.php";

    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * from nomenclature";
        $pdoStatement = $pdo->query($sql);
        $result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        $json = json_encode($result);
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

function getMissionById2($id)
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM missions JOIN devise ON missions.devise=devise.nom WHERE missions.id= ?";
        $req = $pdo->prepare($sql);
        $req->execute([$id]);
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


// get all operations from a mission
function getOperationByMissionId($mission_id)
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM operations JOIN nomenclature ON operations.id_nomenclature=nomenclature.id WHERE id_mission= ?";
        $req = $pdo->prepare($sql);
        $req->execute([$mission_id]);
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

//function to add an operation
function addOperation($newOperation)
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `operations` (`date`, `description`, `montant`, `id_nomenclature`, `id_mission`) VALUES (?, ?, ?, ?, ?)";
        $req = $pdo->prepare($sql);
        $req->execute(array($newOperation->getDate(), $newOperation->getDescription(), $newOperation->getMontant(), $newOperation->getID_nomenclature(), $newOperation->getID_mission()));
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

function getNomByText($text)
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM nomenclature WHERE text= ?";
        $req = $pdo->prepare($sql);
        $req->execute([$text]);
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

// delete mission by id
function deleteMissionById($id)
{
    include "./config/config.php";
    // Create connection with mysql database using pdo surrended by try catch
    try {
        $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM `missions` WHERE `id`= ?";
        $req = $pdo->prepare($sql);
        $req->execute([$id]);
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
