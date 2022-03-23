<?php

include_once "./Entity/auteur.class.php"; //import class file
include "./Entity/citation.class.php"; //import class file

$auteurs = [
    new Auteur("Dupont", "Jean"),


    new Auteur("Dupont1", "Alain"),
    new Auteur("Dupont2", "Kevin"),
];
$citations = [
    new Citation($auteurs[0], date("Y-m-d"), "Ceci est la citation 1"),
    new Citation($auteurs[1], date("Y-m-d"), "Ceci est la citation 2"),
    new Citation($auteurs[2], date("Y-m-d"), "Ceci est la citation 3"),
];