<?php
include 'functions.php';
$login="";
$authentificate=null;
if(isset($_POST["login"])&& isset($_POST["password"])){
    $login=$_POST["login"];
    $password=$_POST["password"];
    if($login=="user" && $password=="usr"){
        session_start();
        $_SESSION["login"]=$login;
        $_SESSION["lastConnection"]=Date("Y-m-d H:i:s");
        $message="Welcome $login";
        $authentificate=true;
    }
    else{
        $message="Bad login or password. Retry!";
        $authentificate=false;        
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Login page</title>
</head>
<body>
	<?php 
	if($authentificate ==true){
	    changeLocation("securePage.php");
	}
	else if($authentificate===false)
	    echo "<h1> $message </h1>";
	?>
	<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
		<input name="login" type="text" value="<?php echo $login;?>" required="true" placeholder="login"/></br>
		<input name="password" type="password" required="true" placeholder="password"/></br>
		<input name="Login" type="submit"> 
	</form>
</body>
</html>