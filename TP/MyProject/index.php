<?php

$var = 0;
for ($i=0; $i < 10; $i++) { 
    echo ($var+$i)."<br>";
}

// Souvent on identifie cet objet par la variable $conn ou $db
	$db = new PDO('mysql:host=localhost;dbname=my_recipes;charset=utf8', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  $sqlQuery = 'SELECT * FROM recipes';

$recipesStatement = $db->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();
?>