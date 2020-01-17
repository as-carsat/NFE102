<?php
require_once ('include/header.php');
require_once ('include/sideBar.php');


if(!isset($_SESSION['id_client'])){


if(isset($_POST['submit'])){

	$email = $_POST['email'];
	$password = $_POST['password'];


	if($email&&$password){

		$select = $db->query("SELECT id_client FROM clients WHERE email = '$email' && password='$password'");
		if($select->fetchColumn()){

			$select = $db->query("SELECT * FROM clients WHERE email = '$email'");
			$result = $select->fetch(PDO::FETCH_OBJ);
			$_SESSION['id_client']=$result->id_client;
			$_SESSION['nom']=$result->username;
			$_SESSION['email']=$result->email;
			$_SESSION['password']=$result->password;

			header('Location: my_account.php');


		}else{


			echo '<p style="color:red;">votre email ou votre de mot de passe est incorrect</p>';
		}
	}else{

		echo '<p style="color:red;">Veuillez remplir tout les champs</p>';
	}
}

?>
<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf8">
			<link href="css/style.css" type="text/css" rel="stylesheet"/>
			<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
		</head>
			<div class="container">
				<div class="row">
					<div class="col-md-5 col-md-offset-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<span class="glyphicon glyphicon-user"></span> Identification</div>
									<div class="panel-body">
										<form action="" method="POST" class="form-horizontal" role="form">

											<div class="form-group">
												<label for="inputEmail3" class="col-md-3 control-label">
													Email
												</label>
														<div class="col-md-9">
															<input type="email" name="email" class="form-control" id="inputEmail3" placeholder="@Email" required>
														</div>
											</div>
												<div class="form-group">
													<label for="inputPassword3" class="col-md-3 control-label">
														Mot de passe
													</label>
														<div class="col-md-9">
															<input type="password" name="password" class="form-control" id="Password" placeholder="Mot de passe" required>
														</div>
												</div>

														<div class="form-group last">
															<div class="col-md-offset-3 col-md-9">
																<button type="submit" name="submit" class="btn btn-alert btn-sm">
																	M'identifier
																</button>
															</div>
														</div>
											</form>
										</div>
									<div class="panel-footer">
										Vous n'avez pas de compte? <a href="register.php">Créer un compte</a></div>
									</div>
								</div>
							</div>
						</div>

<?php


}else{

	header('Location:my_account.php');
}

require_once('include/footer.php');
?>
