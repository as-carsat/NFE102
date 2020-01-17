
		
<div class="sideBar">
	<h4>Les nouveautées</h4>
	
	<?php
	$select = $db -> prepare("SELECT * FROM produits ORDER BY id_produit DESC LIMIT 0,3");
	$select -> 	execute();
	
	while($s=$select->fetch(PDO::FETCH_OBJ)){
		
		$prix_produit =$db->query("SELECT * FROM PRIX WHERE ID_PRODUIT = $s->id_type_produit");
		$prix_produit -> execute();
		$prix = $prix_produit->fetch(PDO::FETCH_OBJ);

		$lenght=20;
		
		
		$description = $s->libelle_long;
		/*	
		$new_description=substr($s->description,0,$lenght)."...";
		$description_finale = wordwrap($new_description,35,'<br/>',false);
		*/
		?>
		
		<div style="text-align:center">
		<a href="?show=<?php  echo $s-> libelle_produit; ?>"><img src="<?php echo $s->chemin_photo;?>"/></a>
		<h2 style="color: white"><?php echo $s->libelle_produit;?></h2>
		<h5 style="color: white"><?php echo $description;?></h5>
		<h4 style="color: white"><?php echo $prix->prix;?>€</h4>
		<br/><br/>
		</div>
		<?php 
	}
	?>
</div>
