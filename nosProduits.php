<?php
require_once ('include/header.php');
require_once ('include/sideBar.php');


	if(isset($_GET['show'])){
		$product = $_GET['show'];
		$select = $db -> prepare("SELECT * FROM produits WHERE libelle_produit='$product' and isdeleted=0");
		$select -> 	execute();
		$s = $select->fetch(PDO::FETCH_OBJ);
		$description=$s->libelle_long;
		$description_finale = wordwrap($description,35,'<br/>',false);


		$prix_produit =$db->query("SELECT * FROM PRIX WHERE ID_PRODUIT = $s->id_produit");
		$prix_produit -> execute();
		$prix = $prix_produit->fetch(PDO::FETCH_OBJ);
		?>
		<div style="text-align:center;">
		<img src="<?php echo $s->chemin_photo;?>"/>
		<h1><?php echo $s->libelle_produit; ?></h1>
		<h5><?php echo $description; ?></h5>
		<h4><?php echo $prix ->prix;?>€</h4>
		<a href="panier.php?action=ajout&amp;l=<?php echo $s->libelle_produit;?>&amp;q=1&amp;p=<?php echo $prix ->prix;?>"><button>Ajouter au panier</button></a>
		
		</div>
		<?php
		
	}else{
		
	if(isset($_GET['category'])){
		$category=$_GET['category'];

		$select = $db -> query("SELECT * FROM produits WHERE id_type_produit='$category' and isdeleted=0");
		$select -> 	execute();

		while($s=$select->fetch(PDO::FETCH_OBJ)){
			$prix_produit =$db->query("SELECT * FROM PRIX WHERE ID_PRODUIT = $s->id_produit");
			$prix_produit -> execute();
			$prix = $prix_produit->fetch(PDO::FETCH_OBJ);

			$description = $s->libelle_court;
			?>
		  		  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
		  		  	<a href="?show=<?php  echo $s-> libelle_produit; ?>"><img src="<?php echo $s->chemin_photo;?>"/></a>
					<a href="?show=<?php  echo $s-> libelle_produit; ?>"><h2><?php echo $s->libelle_produit;?></h2></a>
					<h5><?php echo $description;?></h5>		
					<h4><?php echo $prix->prix;?>€</h4>
					<a href="panier.php?action=ajout&amp;l=<?php echo $s->libelle_produit;?>&amp;q=1&amp;p=<?php echo $prix ->prix;?>"><button>Ajouter au panier</button></a>
				</div>

				<?php 
			}
			
	}else{
	$select=$db->query("SELECT * FROM type_produit");
	
	while($s = $select->fetch(PDO::FETCH_OBJ)){
	
	?>
		<a href="?category=<?php echo $s->id_type_produit;?>"><button class="btn btn-custom" style="position:center; margin-left:30px; margin-bottom:15px;"><h3><?php echo $s->libelle_type_produit ?></h3></button></a>
	<?php 
	}
	}
	}
require_once('include/footer.php');
?>
