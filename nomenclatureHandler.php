<?php

include "./config/config.php";
// update one node in nomenclature
try {
    $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE nomenclature SET text=? WHERE id=?";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$_POST['newName'],$_POST['id']]);
    //close connection
    $pdo = null;
    echo "upadte successfully";
    // return [
    //     "status" => "success",
    //     "result" => true
    // ];
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