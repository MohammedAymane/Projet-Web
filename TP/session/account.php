<?php
include 'functions.php';
session_start();
if(isset($_SESSION["login"])){
    $login=$_SESSION["login"];
    $message="Welcome $login";
}
else
    changeLocation("index.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Account Page</title>
</head>
<body>
<?php 
include "header.html";

?>
	You are <?php echo $login." and your last connection is ".$_SESSION["lastConnection"] ?>
</body>
</html>