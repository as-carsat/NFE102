
<?php
include '../include/connection.php';
if(isset($_SESSION['username'])){
?>

<link href="css/style.css" type="text/css" rel="stylesheet"/>
<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet"/>

<h1>Bienvenue, <?php echo $_SESSION['username'];?></h1>
<br/>
<a href="?action=add"><button>Ajouter produit</button></a>
<a href="?action=modifyAndDelete"><button>Modif/Supp produit</button></a>

<a href="?action=add_category"><button>Ajouter catégorie</button></a>
<a href="?action=modifyAndDelete_category"><button>Modif/Supp catégorie</button></a>

<a href="?action=options"><button>Options</button></a><br/>

<?php

/**/

	if(isset($_GET['action'])){

	if($_GET['action']=='add'){

		if(isset($_POST['submit'])){

			$stock = $_POST['stock'];
			$title = $_POST['title'];
			$description = $_POST['description'];
			$description_court =substr($description,20);
			$price = $_POST['price'];
			$category=$_POST['category'];
			$img=$_FILES['img']['name'];

			$img_tmp=$_FILES['img']['tmp_name'];

			if(!empty($img_tmp)){

				$image = explode('.',$img);

				$image_ext = end($image);

				if(in_array(strtolower($image_ext), array('png', 'jpg', 'jpeg'))===false){
					echo 'Veuillez s�l�ctionner une image ayant pour extenson : png, jpg ou jpeg<br/>';
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

							imagejpeg($image_finale, 'img/'.$title.'.jpg');
							$image_chemin = 'admin/img/'.$title.'.jpg';
					}
				}
			}else{

				echo 'Veuillez s�l�ctionner une image<br/>';
			}

			if($title&&$description&&$price&&$stock){
				$dateformat = date("Y-m-d H:i:s");
				$dateformat_fin = date("Y-m-d H:i:s", strtotime('+1 year'));

				$category=$_POST['category'];
				$type_produit=$db->query("SELECT id_type_produit FROM type_produit WHERE libelle_type_produit='$category'");
				$id_type_produit=$type_produit->fetch(PDO::FETCH_OBJ);

/*
				$weight=$_POST['weight'];

				$select=$db->query("SELECT price FROM weights WHERE name='$weight'");

				$s=$select->fetch(PDO::FETCH_OBJ);

				$shipping = $s->price;

				$old_price = $price;

				$final_price = $old_price;

				$select = $db->query("SELECT tva FROM product");

				$s1 = $select->fetch(PDO::FETCH_OBJ);

				$tva = $s1 -> tva ;

				$final_price = $final_price +($final_price * $tva/100) + $shipping;
*/
				//$insert = $db -> prepare("INSERT INTO product VALUES('','$title','$description','$price','$category','$weight', '$shipping','$tva', '$final_price', '$stock')");
				
				$insert_produit = $db -> prepare("INSERT INTO produits VALUES('','$id_type_produit->id_type_produit','$title','$dateformat','$category','$description_court','$description',0,'$image_chemin')");
				$insert_produit->execute();
				$id_produit=$db->query("SELECT id_produit FROM produits WHERE libelle_produit='$title' and id_type_produit='$id_type_produit->id_type_produit'");
				$id__produit=$id_produit->fetch(PDO::FETCH_OBJ);

				$insert_prix = $db -> prepare("INSERT INTO prix VALUES('','$id__produit->id_produit','$price','$dateformat','$dateformat_fin','$dateformat',0)");
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
	<h3>Nom du produit : <br/><input type="text" name="title"/></h3>
	<h3>Description : <br/><textarea name="description"></textarea></h3>

<!--
	<h3>Poids moins de :<select name="weight">
			< ?php $select=$db->query("SELECT * FROM weights");
			while($s=$select->fetch(PDO::FETCH_OBJ)){
		?>

		<option>< ?php echo $s->name;?></option>

		< ?php
			}
			?>

	</select></h3>
	-->
	<h3>Prix : <br/><input type="text" name="price"/></h3>
	<h3>Photo du produit :</h3>
	<input type="file" name="img"/>
	<h3>Stock :<input type="text" name="stock"/></h3><br/><br/>
		<input type="submit" name="submit"/>
	</form>
<?php

	}else if($_GET['action']=='modifyAndDelete'){
		$select = $db -> prepare("SELECT * FROM product");
		$select -> 	execute();

		while($s=$select->fetch(PDO::FETCH_OBJ)){ //while is exist article
			echo $s->title.'<br/>';

		?>
			<a href="?action=modify&amp;id=<?php echo $s->id; ?>">Modifier</a>
			<a href="?action=delete&amp;id=<?php echo $s->id; ?>">X</a><br/><br/>
		<?php

		}

	}else if($_GET['action']=='modify'){

		$id = $_GET['id'];

		$select = $db -> prepare("SELECT * FROM product WHERE id=$id");
		$select -> 	execute();

		$data = $select -> fetch (PDO::FETCH_OBJ);
		?>

		<form action="" method="post">
			<h3>Nom du produit : <br/><input value="<?php echo $data->title; ?>" type="text" name="title"/></h3>
			<h3>Description : <br/><textarea name="description"><?php echo $data->description; ?></textarea></h3>
			<h3>Prix : <br/><input value="<?php echo $data->price; ?>" type="text" name="price"/></h3>
			<h3>Stock :<input type="text" name="stock"/></h3><br/><br/>
			<input type="submit" name="submit" value="Modifier"/>
		</form>
		<?php

		if(isset ($_POST['submit'])){

			$stock=$_POST['stock'];
			$title = $_POST['title'];
			$description = $_POST['description'];
			$price = $_POST['price'];

			$update =$db->prepare("UPDATE product SET title='$title', description='$description', price='$price', stock='$stock' WHERE id=$id");
			$update->execute();

			header('Location: admin.php?action=modifyAndDelete');
		}



	}else if($_GET['action']=='delete'){

		$id=$_GET['id'];
		$delete = $db -> prepare("DELETE  FROM product WHERE id=$id");
		$delete -> 	execute();
	/*----------------------------------------------*/

	}else if($_GET['action']=='add_category'){

		if(isset($_POST['submit'])){

			$name=$_POST['name'];

			if($name){

				$insert = $db -> prepare("INSERT INTO category VALUES('','$name')");
				$insert->execute();
	}else{

		echo"Veuillez donner un nom a votre nouvelle cat�gorie de produit";
	}
		}

		?>
			<form action="" method="post">
				<h3>Nom de la catégorie :</h3><input type="text" name="name"/><br/><br/>
				<input type="submit" name="submit" value="Ajouter"/>
			</form>
		<?php

	}else if($_GET['action']=='modifyAndDelete_category'){

		$select = $db -> prepare("SELECT * FROM category");
		$select -> 	execute();

		while($s=$select->fetch(PDO::FETCH_OBJ)){ //while is exist article
			echo $s->name.'<br/>';

			?>
					<a href="?action=modify_category&amp;id=<?php echo $s->id; ?>">Modifier</a>
					<a href="?action=delete_category&amp;id=<?php echo $s->id; ?>">X</a><br/><br/>
				<?php

				}


				}else if($_GET['action']=='modify_category'){

					$id = $_GET['id'];

					$select = $db -> prepare("SELECT * FROM category WHERE id=$id");
					$select -> 	execute();

					$data = $select -> fetch (PDO::FETCH_OBJ);
					?>

						<form action="" method="post">
							<h3>Nom de la catégorie : <br/><input value="<?php echo $data->name; ?>" type="text" name="title"/></h3>
							<input type="submit" name="submit" value="Modifier"/>
						</form>
						<?php

						if(isset ($_POST['submit'])){

							$title = $_POST['title'];
							$description = $_POST['description'];
							$price = $_POST['price'];

							$update =$db->prepare("UPDATE category SET name='$title' WHERE id=$id");
							$update->execute();

							$id = $_GET['id'];
							$select= $db->query("SELECT name FROM category WHERE id='$id'");

							$result= $select->fetch(PDO::FETCH_OBJ);

							$update =$db->query("UPDATE product SET category='$title' WHERE category='$result->title'");

							header('Location: admin.php?action=modifyAndDelete_category');
						}

				}else if($_GET['action']=='delete_category'){


					$id=$_GET['id'];
					$delete = $db -> prepare("DELETE  FROM category WHERE id=$id");
					$delete -> 	execute();

					header('Location: admin.php?action=modifyAndDelete_category');
	}else if($_GET['action']=='options'){
		?>

		<h2>Frais de ports :</h2>
		<h3>Options de poids (en grammes)</h3>
		<?php
	$select = $db->query("SELECT * FROM weights");

	while ($s=$select->fetch(PDO::FETCH_OBJ)){

		?>
			<form action="" method="post">
			<input type="text" name="weight" value="<?php echo $s->name; ?>"/>
			<a href="?action=modify_weight&amp; name=<?php echo $s->name; ?>">Modifier</a>
		</form>

		<?php
	}

	$select=$db->query("SELECT tva FROM product");

	$s = $select-> fetch(PDO::FETCH_OBJ);

	if(isset($_POST['submit2'])){

		$tva=$_POST['tva'];

		if('$tva'){

			$update = $db->query("UPDATE product SET tva = $tva");
		}
	}
	?>

		<h3>TVA :</h3>
		<form action="" method="post"/>
		<input type="text" name="tva" value="<?php echo $s->tva;?>"/>
		<input type="submit" name="submit2" value="Modifier"/>
		</form>

	<?php
	}else if($_GET['action']=='modify_weight'){

		$old_weight=$_GET['name'];

		$select = $db->query("SELECT * FROM weights WHERE name=$old_weight");
		$s= $select->fetch(PDO::FETCH_OBJ);


		if(isset($_POST['submit'])){

			$weight=$_POST['weight'];
			$price=$_POST['price'];
			if($weight&&$price){

				$update = $db->query("UPDATE weights SET name='$weight', price='$price' WHERE name=$old_weight");

			}
		}
			?>

				<h2>Frais de ports :</h2><br/>
				<h3>Options de poids</h3>


				<form action="" method="post">
				<h3>Poids :<input type="text" name="weight" value="<?php echo $_GET['name'];?>"/>Grammes</h3>
				<h3>Prix :<input type="text" name="price" value="<?php echo $s->price;?>"/> Euros</h3>
				<input type="submit" name="submit" value="Modifier"/>
				</form>
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
