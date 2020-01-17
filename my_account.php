<?php
require_once ('include/header.php');
require_once ('include/sideBar.php');

$user_id = $_SESSION['id_client'];
$select = $db->query("SELECT * FROM clients WHERE id_client = '$user_id'");
?>

<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf8">
			<link href="css/style.css" type="text/css" rel="stylesheet"/>
			<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
		</head>
					<?php
			while($s = $select->fetch(PDO::FETCH_OBJ)){
				?>

		<header>

			<ul class="menu">
				<li><a href="disconnect.php"><button class="btn btn-custom">Déconnexion</button></a><h2 class="bjr">Bonjour, <?php echo $s->prenom; ?></h2></li>

			</ul>

		</header>
			<hr class="separator"><br/><br/><br/>
			<div>
				<h2>Mon compte :</h2>
				<h4>Votre email : <?php echo $s->email; ?></h4>
				<h4>Votre Mot de passe : <?php echo $s->password; ?></h4>
				</div>
				<br/>
			<?php
			}
			?>
			<hr class="separator"/><br/><br/><br/>
				<h2>Mes achats : </h2>
<!--
							< ?php


			$select = $db->query("SELECT * FROM transactions WHERE user_id = '$user_id'");


			$i=0;
			while($s = $select->fetch(PDO::FETCH_OBJ)){

			$i++;
				?>


				<h3>Commande numéro : < ?php echo $i;?></h3>
				<h4>Nom : < ?php echo $s->name; ?></h4>
				<h4>Adresse de livraison : < ?php echo $s->street; ?></h4>
				<h4>Ville: < ?php echo $s->city; ?></h4>
				<h4>Pays : < ?php echo $s->country; ?></h4>
				<h4>Date : < ?php echo $s->date; ?></h4>
				<h4>Numéro de transaction : < ?php echo $s->transaction_id; ?></h4>
				<h4>Montant : < ?php echo $s->amount; ?></h4>
				<h4>Frais de ports : < ?php echo $s->shipping; ?></h4>
				<h4>Article : < ?php echo $s->products; ?></h4>
				<h4>Devise : < ?php echo $s->currency_code; ?></h4>

				<hr class="separator"><br/><br/><br/>
			< ?php

			}

			?>

-->
				</html>



<?php
require_once ('include/footer.php');
?>
