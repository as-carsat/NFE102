
		
<div class="sideBar">
	<h4>Les nouveautées</h4>
	
	<?php
	$select = $db -> prepare("SELECT * FROM produits p inner join prix pr on p.id_produit = pr.id_produit ORDER BY p.id_produit DESC LIMIT 0,3");
	$select -> 	execute();
	
	while($s=$select->fetch(PDO::FETCH_OBJ)){
		$prix = $s->prix;
		$description = $s->libelle_court;
		?>
		
		<div style="text-align:center">
		<a href="?show=<?php  echo $s-> libelle_produit; ?>"><img src="<?php echo $s->chemin_photo;?>"/></a>
		<h2 style="color: white"><?php echo $s->libelle_produit;?></h2>
		<h5 style="color: white"><?php echo $description;?></h5>
		<h4 style="color: white"><?php echo $prix;?>€</h4>
		<br/><br/>
		</div>
		<?php 
	}
	?>
</div>
