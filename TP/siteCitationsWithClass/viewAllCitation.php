<?php
include "./main.php";

foreach ($citations as $c) {
    echo <<<EOT
<h1>Citation ajouté le {$c->getDate()}</h1>
        
<div class='card'>
    
    <div class='card-body'>
        <h5 class='card-title'>Rappel de vos informations</h5>
        <p class='card-text'><b>Auteur</b> : {$c->getAuteur()->__toString()}</p>
        <p class='card-text'><b>Citation</b> : {$c->getContent()}</p>
    </div>
</div>  
EOT;
}