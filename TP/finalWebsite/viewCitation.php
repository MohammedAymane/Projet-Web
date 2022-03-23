<?php

include "navbar.php";

include "dbFunctions.php";

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = htmlspecialchars($_GET["id"]);
    $citation = getCitationByLogin($pdo, $id);
    if (sizeOf($citation) <= 0) {
        header("Location:404.php");
        die();
    }
    echo <<<EOT
<h1>Citation ajouté le {$citation[0]["Date_enregistrement"]} par {$citation[0]["Login"]}</h1>
        
<div class='card'>
    
    <div class='card-body'>
        <p class='card-text'><b>Auteur</b> : {$citation[0]["Auteur"]}</p>
        <p class='card-text'><b>Citation</b> : {$citation[0]["Content"]}</p>
        <p class='card-text'><b>Date de la citation</b> : {$citation[0]["Date_citation"]}</p>
    </div>
</div>  
EOT;
}