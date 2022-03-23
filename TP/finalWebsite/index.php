<?php
include "navbar.php";
include "dbFunctions.php";
session_start();
if (!$_SESSION["loggedIn"]) {
    header("Location:login.php");
    die();
}
$citations = getCitationsByDate($pdo);

foreach ($citations as $citation) {
    echo <<<EOT
<h1>Citation ajouté le {$citation["Date_enregistrement"]} par {$citation["Login"]}</h1>
        
<div class='card'>
    
        <div class='card-body'>
            <p class='card-text'><b>Auteur</b> : {$citation["Auteur"]}</p>
            <p class='card-text'><b>Citation</b> : {$citation["Content"]}</p>
            <p class='card-text'><b>Date de la citation</b> : {$citation["Date_citation"]}</p>
        </div>
</div>  
EOT;
}
?>
