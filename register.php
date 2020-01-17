<?php
require_once ('include/header.php');
require_once ('include/sideBar.php');

if(!isset($_SESSION['id_client'])){
//$datetime = new DateTime();
$dateformat = date("Y-m-d H:i:s");
	if(isset($_POST['submit'])){
		$pays= $_POST['pays'];
		$nom= $_POST['nom'];
		$prenom= $_POST['prenom'];
		$adr1= $_POST['adr1'];
		$adr2= $_POST['adr2'];
		$adr3= $_POST['adr3'];
		$adr4= $_POST['adr4'];
		$cp= $_POST['cp'];
		$ville= $_POST['ville'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repeatpassword = $_POST['repeatpassword'];

		if($nom&&$prenom&&$adr1&&$adr2&&$cp&&$ville&&$email&&$password&&$repeatpassword){
			if($password==$repeatpassword){
				$libelle_p = $db->query("SELECT * FROM PAYS WHERE LIBELLE_PAYS ='$pays'");
				$libelle_p -> execute();
				$libelle_pa = $libelle_p->fetch(PDO::FETCH_OBJ);
				if(null==$libelle_pa){
				$db->query("INSERT INTO PAYS VALUES('','$pays','$dateformat',0)");
				$id_p = $db->query("SELECT * FROM PAYS WHERE LIBELLE_PAYS ='$pays'");
				$id_p -> execute();
				$id_pa = $id_p->fetch(PDO::FETCH_OBJ);
				$id_pays = $id_pa->id_pays;
			}else{
				$id_pays =$libelle_pays;
			}
				$db->query("INSERT INTO clients VALUES('','$id_pays','$nom','$prenom','$adr1','$adr2','$adr3','$adr4','$cp','$ville','$dateformat', '$email', '$password',0)");
				echo '<p style="color:green;">votre compte a bien été crée</p>';

			}else{

				echo '<p style="color:red;">Veuillez saisir des mots de passe identique</p>';
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
								<span class="glyphicon glyphicon-user"></span> Création de compte</div>
									<div class="panel-body">
										<form action="" method="POST" class="form-horizontal" role="form">

										<div class="form-group">
												<label for="nom" class="col-md-3 control-label">
													Nom
												</label>
														<div class="col-md-9">
															<input type="text" name="nom" class="form-control" id="nom" placeholder="Nom" required>
														</div>
											</div>

											<div class="form-group">
													<label for="prenom" class="col-md-3 control-label">
														Prenom
													</label>
															<div class="col-md-9">
																<input type="text" name="prenom" class="form-control" id="prenom" placeholder="Prenom" required>
															</div>
												</div>

												<div class="form-group">
														<label for="adress" class="col-md-3 control-label">
															Adresse
														</label>
																<div class="col-md-9">
																	<input type="text" name="adr1" class="form-control" id="adr1" placeholder="numéro" required>
																	<br/>
																	<input type="text" name="adr2" class="form-control" id="adr2" placeholder="voie" required>
																	<br/>
																	<input type="text" name="adr3" class="form-control" id="adr3" placeholder="complément">
																	<br/>
																	<input type="text" name="adr4" class="form-control" id="adr4" placeholder="lieu-dit">
																	<br/>
																	<input type="number" name="cp" class="form-control" id="cp" placeholder="code postale" required>
																	<br/>
																	<input type="text" name="ville" class="form-control" id="ville" placeholder="ville" required>
																	<br/>
																	<input type="text" name="pays" class="form-control" id="pays" placeholder="pays" required>
																</div>
													</div>


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

												<div class="form-group">
													<label for="inputPassword3" class="col-md-3 control-label">
														vérification du mot de passe
													</label>
														<div class="col-md-9">
															<input type="password" name="repeatpassword" class="form-control" id="Password" placeholder="vérification du mot de passe" required>
														</div>
												</div>

														<div class="form-group last">
															<div class="col-md-offset-3 col-md-9">
																<button type="submit" name="submit" class="btn btn-alert btn-sm">
																	M'enregistrer
																</button>
															</div>
														</div>
											</form>
										</div>
									<div class="panel-footer">
										Déjà en registré? <a href="connect.php">Identifiez-vous</a></div>
									</div>
								</div>
							</div>
						</div>

<?php
}else{

	header('Location:my_account.php');
}


require_once('include/footer.php');?>
