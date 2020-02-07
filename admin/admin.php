
<?php
include '../include/connection.php';
include '../include/header_admin.php';
if(isset($_SESSION['username'])){
?>

<link href="css/style.css" type="text/css" rel="stylesheet"/>
<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<button type="button" class="btn btn-secondary" style="margin-right:0px;"><a href="disconnect.php">Déconnexion</a></button>

<h1>Bienvenue, <?php echo $_SESSION['username'];?></h1> 
<br/>
<a href="?action=add"><button>Ajouter produit</button></a>
<a href="?action=modifyAndDelete"><button>Modif/Supp produit</button></a>

<a href="?action=add_category"><button>Ajouter catégorie</button></a>
<a href="?action=modifyAndDelete_category"><button>Modif/Supp catégorie</button></a>

<a href="?action=clients"><button>Clients</button></a><br/>

<?php

	if(isset($_GET['action'])){
/* DEBUT CREATION PRODUIT */
	if($_GET['action']=='add'){

		if(isset($_POST['submit'])){

			$stock = $_POST['stock'];
			$libelle_produit = $_POST['libelle_produit'];
			$description = $_POST['description'];
			$description_court =substr($description,0,15).'...';
			$prix = $_POST['prix'];
			$category=$_POST['category'];
			$img=$_FILES['img']['name'];

			$img_tmp=$_FILES['img']['tmp_name'];

			if(!empty($img_tmp)){

				$image = explode('.',$img);

				$image_ext = end($image);

				if(in_array(strtolower($image_ext), array('png', 'jpg', 'jpeg'))===false){
					echo 'Veuillez séléctionner une image ayant pour extension : png, jpg ou jpeg<br/>';
				}else{
					$image_size = getimagesize($img_tmp);

					if($image_size['mime']=='image/jpeg'){

						$image_src= imagecreatefromjpeg($img_tmp);

					}else if($image_size['mime']=='image/png'){

						$image_src= imagecreatefrompng($img_tmp);
					}else{
						$image_src = false;
						echo'Veuillez rentrer une image valide<br/>';
					}

					if($image_src!==false){
						$image_width = 200;
							if($image_size[0]==$image_width){
								$image_finale = $image_src;
							}else{
								$new_width[0]= $image_width;
								$new_height[1] = 200;
								$image_finale= imagecreatetruecolor($new_width[0],$new_height[1]);
								imagecopyresampled($image_finale,$image_src,0,0,0,0,$new_width[0],$new_height[1],$image_size[0],$image_size[1]);
							}

							imagejpeg($image_finale, 'img/'.$libelle_produit.'.jpg');
							$image_chemin = 'admin/img/'.$libelle_produit.'.jpg';
					}
				}
			}else{

				echo 'Veuillez séléctionner une image<br/>';
			}

			if($libelle_produit&&$description&&$prix&&$stock){
				$dateformat = date("Y-m-d H:i:s");
				$dateformat_fin = date("Y-m-d H:i:s", strtotime('+1 year'));

				$category=$_POST['category'];
				$type_produit=$db->query("SELECT id_type_produit FROM type_produit WHERE libelle_type_produit='$category'");
				$id_type_produit=$type_produit->fetch(PDO::FETCH_OBJ);
				$insert_produit = $db -> prepare("INSERT INTO produits VALUES('','$id_type_produit->id_type_produit','$libelle_produit','$dateformat','$category','$description_court','$description',0,'$image_chemin')");
				$insert_produit->execute();
				$id_produit=$db->query("SELECT id_produit FROM produits WHERE libelle_produit='$libelle_produit' and id_type_produit='$id_type_produit->id_type_produit'");
				$id__produit=$id_produit->fetch(PDO::FETCH_OBJ);

				$insert_prix = $db -> prepare("INSERT INTO prix VALUES('','$id__produit->id_produit','$prix','$dateformat','$dateformat_fin','$dateformat',0)");
				$insert_prix->execute();

			}else{
				echo 'veuillez remplir tout les champs!<br/>';
			}
		}

?>


<form action="" method="post" enctype="multipart/form-data">
	<h3>Catégorie de produit :</h3><select name="category">
		<?php $select=$db->query("SELECT * FROM type_produit");
			while($s=$select->fetch(PDO::FETCH_OBJ)){
		?>

		<option><?php echo $s->libelle_type_produit;?>

		<?php
			}
			?>
	</select>
	<h3>Nom du produit : <br/><input type="text" name="libelle_produit"/></h3>
	<h3>Description : <br/><textarea name="description"></textarea></h3>
	<h3>Prix : <br/><input type="text" name="prix"/></h3>
	<h3>Photo du produit :</h3>
	<input type="file" name="img"/>
	<h3>Stock :<input type="text" name="stock"/></h3><br/><br/>
		<input type="submit" name="submit"/>
	</form>
<?php

	}
	/* FIN CREATION PRODUIT */
	/* DEBUT MODIFICATION PRODUIT */
	else if($_GET['action']=='modifyAndDelete'){
		$select = $db -> prepare("SELECT * FROM produits");
		$select -> 	execute();
		?>
		<table class="table">
			<thead>
			<tr>
				<th>Photo</th>
				<th>Libelle</th>
				<th>Modification</th>
				<th>Activation</th>
				<th>Suppression</th>
			</tr>
			</thead>
			<tbody>
		<?php
		while($s=$select->fetch(PDO::FETCH_OBJ)){ 
			$chemin_photo=$s->chemin_photo;
			$chemin_photo_adm=substr($chemin_photo,6);
			?>
			<tr>
				<th><img src="<?php echo $chemin_photo_adm;?>"/></th>
				<th><?php echo $s->libelle_produit;?></th>
				<th><a href="?action=modify&amp;id=<?php echo $s->id_produit; ?>">Modifier</a></th>
			<?php 
			if($s->isdeleted == 0){
			?>
			<th><a href="?action=desactiver&amp;id=<?php echo $s->id_produit; ?>">Désactiver</a></th>
			<?php
			}else{
			?>
			<th><a href="?action=reactiver&amp;id=<?php echo $s->id_produit; ?>">Activer</a></th>
			<?php
			}
			?>
			<th><a href="?action=delete&amp;id=<?php echo $s->id_produit; ?>">X</a><br/><br/></th>
		</tr>
		<?php
		}
		?>
		</tbody>
		</table>
		<?php
	}else if($_GET['action']=='modify'){

		$id = $_GET['id'];

		$select = $db -> prepare("SELECT * FROM produits WHERE id_produit=$id");
		$select -> 	execute();
		$data = $select -> fetch (PDO::FETCH_OBJ);

		$chemin_photo=$data->chemin_photo;
		$chemin_photo_adm=substr($chemin_photo,6);

		$select_prix = $db -> prepare("SELECT * FROM prix WHERE id_produit=$id");
		$select_prix -> 	execute();
		$data_prix = $select_prix -> fetch (PDO::FETCH_OBJ);
		?>

		<form action="" method="post">
			<img src="<?php echo $chemin_photo_adm;?>"/>
			<h3>Nom du produit : <br/><input value="<?php echo $data->libelle_produit; ?>" type="text" name="libelle_produit"/></h3>
			<h3>Description : <br/><textarea name="libelle_long"><?php echo $data->libelle_long; ?></textarea></h3>
			<h3>Description courte: <br/><textarea name="libelle_court"><?php echo $data->libelle_court; ?></textarea></h3>
			<h3>Prix : <br/><input value="<?php echo $data_prix->prix; ?>" type="text" name="prix"/></h3>
			<h3>Stock :<input type="text" name="stock"/></h3><br/><br/>
			<input type="submit" name="submit" value="Modifier"/>
		</form>
		<?php

		if(isset ($_POST['submit'])){

			$stock=$_POST['stock'];
			$libelle_produit = $_POST['libelle_produit'];
			$description = $_POST['libelle_long'];

			$description_courte =  $_POST['libelle_court'];

			$prix = $_POST['prix'];
			$update =$db->prepare("UPDATE produits SET libelle_produit='$libelle_produit', libelle_long='$description', libelle_court='$description_courte' WHERE id_produit=$id");
			$update->execute();

			$update_prix =$db->prepare("UPDATE prix SET prix='$prix' WHERE id_produit=$id");
			$update_prix->execute();

			header('Location: admin.php?action=modifyAndDelete');
		}



	}else if($_GET['action']=='delete'){

		$id=$_GET['id'];

		$delete_prix = $db -> prepare("DELETE  FROM prix WHERE id_produit=$id");
		$delete_prix -> 	execute();
		$delete_produit = $db -> prepare("DELETE  FROM produits WHERE id_produit=$id");
		$delete_produit -> 	execute();
	/*----------------------------------------------*/

	}else if($_GET['action']=='desactiver'){

		$id=$_GET['id'];
		$update = $db -> prepare("UPDATE produits SET ISDELETED =1 WHERE id_produit=$id");
		$update -> 	execute();
	/*----------------------------------------------*/

	}else if($_GET['action']=='reactiver'){

		$id=$_GET['id'];
		$update = $db -> prepare("UPDATE produits SET ISDELETED =0 WHERE id_produit=$id");
		$update -> 	execute();
	/*----------------------------------------------*/

	}else if($_GET['action']=='add_category'){
		$dateformat = date("Y-m-d H:i:s");
		if(isset($_POST['submit'])){

			$name=$_POST['name'];

			if($name){

				$insert = $db -> prepare("INSERT INTO type_produit VALUES('','$name', '$dateformat',0)");
				$insert->execute();
	}else{

		echo"Veuillez donner un nom a votre nouvelle catégorie de produit";
	}
		}

		?>
			<form action="" method="post">
				<h3>Nom de la catégorie :</h3><input type="text" name="name"/><br/><br/>
				<input type="submit" name="submit" value="Ajouter"/>
			</form>
		<?php

	}else if($_GET['action']=='modifyAndDelete_category'){

		$select = $db -> prepare("SELECT * FROM type_produit");
		$select -> 	execute();
		?>
		<table class="table">
		<thead>
		<tr>
			<th>Catégorie</th>
			<th>Modification</th>
			<th>Suppression</th>
		</tr>
		</thead>
		<tbody>
		<?php
		while($s=$select->fetch(PDO::FETCH_OBJ)){
		?>	
		<tr>
			<th><?php echo $s->libelle_type_produit; ?></th>
			<th><a href="?action=modify_category&amp;id=<?php echo $s->id_type_produit; ?>">Modifier</a></th>
			<th><a href="?action=delete_category&amp;id=<?php echo $s->id_type_produit; ?>" onclick="alert('attention!')">X</a></th>
		</tr>
		<?php
				}
		?>
		</tbody>
		</table>
		<?php

				}else if($_GET['action']=='modify_category'){

					$id = $_GET['id'];
					$select = $db -> prepare("SELECT * FROM type_produit WHERE id_type_produit=$id");
					$select -> 	execute();
					$data = $select -> fetch (PDO::FETCH_OBJ);
					?>

						<form action="" method="post">
							<h3>Nom de la catégorie : <br/><input value="<?php echo $data->libelle_type_produit; ?>" type="text" name="libelle_produit"/></h3>
							<input type="submit" name="submit" value="Modifier"/>
						</form>
						<?php

						if(isset ($_POST['submit'])){

							$libelle_produit = $_POST['libelle_produit'];
							$description = $_POST['description'];
							$prix = $_POST['prix'];

							$update =$db->prepare("UPDATE type_produit SET libelle_type_produit='$libelle_produit' WHERE id_type_produit=$id");
							$update->execute();
							header('Location: admin.php?action=modifyAndDelete_category');
						}

				}else if($_GET['action']=='delete_category'){


					$id=$_GET['id'];
					$select= $db->prepare("SELECT * FROM produits WHERE id_type_produit=$id");
					$select->execute();
					while($s=$select->fetch(PDO::FETCH_OBJ)){

					$delete_prix = $db -> prepare("DELETE  FROM prix WHERE id_produit=$s->id_produit");
					$delete_prix -> 	execute();
					$delete_produit = $db -> prepare("DELETE  FROM produits WHERE id_type_produit=$id");
					$delete_produit -> 	execute();
					$delete = $db -> prepare("DELETE  FROM type_produit WHERE id_type_produit=$id");
					$delete -> 	execute();
					}
					header('Location: admin.php?action=modifyAndDelete_category');
	}else if($_GET['action']=='clients'){
		?>

		<h2>Liste des clients :</h2>          
  <table class="table">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Prenom</th>
		<th>Ville</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      
		<?php
	$select = $db->query("SELECT * FROM clients");

	while ($s=$select->fetch(PDO::FETCH_OBJ)){
		?>
	  <tr>
        <td><?php echo $s->nom; ?></td>
        <td><?php echo $s->prenom; ?></td>
        <td><?php echo $s->ville; ?></td>
		<td><?php echo $s->email; ?></td>
      </tr>
      <tr>

		<?php
	}
	?>
	</tbody>
	</table>
	<?php
	}else{
		die('une erreur s\'est produite<br/>');
	}
	}else{

	}

}else{
	header('location:../index.php');
}
?>
