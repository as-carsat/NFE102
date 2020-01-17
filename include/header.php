<?php
include 'connection.php';
?>

			<meta http-equiv="Content-Type" content="text/html; charset="utf8">
			<link href="css/style.css" type="text/css" rel="stylesheet"/>
			<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		</head>
		<header>
			<ul class="menu">
				<li><a href="index.php"><button class="btn btn-custom">Accueil</button></a></li>
				<li><a href="nosProduits.php"><button class="btn btn-custom">Nos Produits</button></a></li>
				<li><a href="panier.php"><button class="btn btn-custom">Panier</button></a></li>
				<?php if(!isset($_SESSION['id_client'])){?>
				<li><a href="connect.php"><button class="btn btn-custom">Accèder à mon compte</button></a></li>
				<li><a href="register.php"><button class="btn btn-custom">Créer un compte</button></a></li>
				<?php }else{?>
				<li><a href="my_account.php"><button class="btn btn-custom">Mon compte</button></a></li>
				<?php }?>

				<li><a href="map.php"><button class="btn btn-custom">Nous Trouver</button></a></li>
			</ul>

		</header>
