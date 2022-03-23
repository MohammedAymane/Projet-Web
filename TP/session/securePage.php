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
  <title>Account of user <?php echo $login;?></title>
</head>
<body>
<?php 
include "header.html";
echo $message;
?>

</body>
</html>