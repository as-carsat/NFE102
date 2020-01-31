
<?php 
include '../include/connection.php';

if(!isset($_SESSION['username'])){
/*
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
	
*/
	if(isset($_POST['submit'])){

		$username = $_POST['username'];
		$password = $_POST['password'];
	
	
		if($username&&$password){
	
			$select = $db->query("SELECT id_admin FROM administration WHERE username = '$username' && password='$password'");

			if($select->fetchColumn()){
				session_start();
				$select -> 	execute();
				$id = $select->fetch(PDO::FETCH_OBJ);
				

				$select = $db->query("SELECT * FROM administration WHERE id_admin = $id->id_admin");
				$result = $select->fetch(PDO::FETCH_OBJ);
				$_SESSION['id_admin']=$result->id_admin;
				$_SESSION['username']=$result->username;
				$_SESSION['password']=$result->password;
	
				header('Location: admin.php');
	
	
			}else{
	
	
				echo '<p style="color:red;">votre email ou votre de mot de passe est incorrect</p>';
			}
		}else{
	
			echo '<p style="color:red;">Veuillez remplir tout les champs</p>';
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

<?php

}else{
	header('Location: admin.php');
}