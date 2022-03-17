<?php

include "./config/config.php";
// update one node in nomenclature
try {
    $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $action = $_POST['action'];
    switch ($action) {
        case 'update':
            $sql = "UPDATE nomenclature SET text=? WHERE id=?";
            $stmt= $pdo->prepare($sql);
            $stmt->execute([$_POST['text'],$_POST['id']]);
            //close connection
            $pdo = null;
            echo "upadte successfully";
            break;
        case 'create':
            $sql = "INSERT INTO `nomenclature` (`id`, `parent`, `text`) VALUES (?, ?, ?)";
            $req = $pdo->prepare($sql);
            $req->execute(array($_POST['id'], $_POST['parent'], $_POST['text']));
            $pdo = null;
            echo "create successfully";
            break;     
    }

} catch (PDOException $e) {
    // return [
    //     "status" => "error",
    //     "message" => "update failed: " . $e->getMessage()
    // ];
    echo $e->getMessage();
}


// if(isset($_POST['oldValue']))
//     echo 'old value'.$_POST['oldValue'];
// else
//     echo 'receive nothing';
?>