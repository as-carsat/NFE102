
<?php 

session_start();

$user='admin';
$pass='1234';
	if(isset($_POST['submit'])){
		$username = $_POST['username'];
		$password =$_POST['password'];
	
	
	if($username&&$password){
		if($username==$user&&$password==$pass){
			$_SESSION['username']=$username;
			header('location: admin.php');
		}else{
				echo 'identifiant incorrecte';
			}
	}else{
		echo 'veuillez remplire tout les champs';
	}
	}
	
?>

<!DOCTYPE html/> 
<html>
<head>
	<meta charset="utf8">
	<link href="css/style.css" type="text/css" rel="stylesheet"/>
	<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
</head>
<body>

<h1>Gestion du site</h1>
<form action="" method="post">
	<h3>Identifiant : <input type="text" name="username"/></h3><br>
	<h3>Mot de passe : <input type="password" name="password"/></h3><br><br>
	<input type="submit" name="submit"/>
</form>
</body>
</html>