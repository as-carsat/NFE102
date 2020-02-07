<?php



require_once ('include/header.php');
require_once ('include/sideBar.php');
require_once ('include/functionsPanier.php');
require_once ('include/paypal.php');

$erreur = false;

$action = (isset($_POST['action'])?$_POST['action']:(isset($_GET['action'])?$_GET['action']:null));

if($action!==null){

	if(!in_array($action,array('ajout','suppression','refresh')))

		$erreur=true;

		$l = (isset($_POST['l'])?$_POST['l']:(isset($_GET['l'])?$_GET['l']:null));
		$q = (isset($_POST['q'])?$_POST['q']:(isset($_GET['q'])?$_GET['q']:null));
		$p = (isset($_POST['p'])?$_POST['p']:(isset($_GET['p'])?$_GET['p']:null));

		$l= preg_replace('#\v#', '', $l);

		$p=floatval($p);

		if(is_array($q)){

			$qteProduit = array();

			$i=0;

			foreach ($q as $contenu){

				$qteProduit[$i++] = intval($contenu);
			}
		}else{
			$q=intval($q);
		}

	}


if(!$erreur){

	switch ($action){
		Case "ajout":

			ajouterArticle($l,$q,$p);
			break;

		Case "suppression":

			supprimerProduit($l);
			break;


		Case "refresh":

			for($i=0; $i<count($qteProduit); $i++){

				modifierQteProduit($_SESSION['panier']['libelleProduit'][$i], round($qteProduit[$i]));
			}
			break;

		Default :
			break;
	}

}
?>

	<form method="post" action="">
		<table class="table-striped" widht="400">

		<thead>
			<tr>
				<td>Produit</td>
				<td>Prix</td>
				<td>Quantitée</td>
				<td>Tva</td>
				<td>Supprimer article</td>
			</tr>
		</thead>
		<tbody>
			<?php

				if(isset($_GET['deletePanier'])&& $_GET['deletePanier']==true){

					supprimerPanier();
				}

				if(creationPanier()){

				$nbProduits = count($_SESSION['panier']['libelleProduit']);

				if($nbProduits <= 0){

					echo '<br/><p style="font-size:25px; color:red;">Oups, votre panier est vide !</p>';

				}else{

					$total = montantTotal();
					$totalHT = montantTotalHT();
					$shipping = CalculFraisPorts();
					$paypal = new Paypal();

					$params = array(
							'RETURNURL' =>'http://127.0.0.1/e-commerce/process.php',
							'CANCELURL' =>'http://127.0.0.1/e-commerce/cancel.php',

							'PAYMENTREQUEST_0_AMT'=>$totalHT + $shipping,
							'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
							'PAYMENTREQUEST_0_SHIPPINGAMT' => $shipping,
							'PAYMENTREQUEST_0_ITEMAMT' => $totalHT
					);

					$response = $paypal->request('SetExpressCheckout', $params);

					if ($response){

						$paypal = 'https://sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token='.$response['TOKEN'].'';

					}else{


						var_dump($paypal->errors);
						die('erreur');
					}

					for($i = 0; $i<$nbProduits; $i++){

						?>

						<tr>
							<td><br/><?php echo $_SESSION['panier']['libelleProduit'][$i];?></td>
							<td><br/><?php echo $_SESSION['panier']['prixProduit'][$i];?>€</td>
							<td><br/><input name="q[]" value="<?php echo $_SESSION['panier']['qteProduit'][$i]?>" size="5"/></td>
							<td><br/><?php echo $_SESSION['panier']['tva']."%";?></td>
							<td><br/><a href="panier.php?action=suppression&amp;l=<?php echo rawurlencode($_SESSION['panier']['libelleProduit'][$i]);?>">X</a></td>

						</tr>
									<?php } ?>
						<tr>
							<td colspan="2"><br/>
								<p>Total HT : <?php echo $totalHT ?>€</p><br/>
								<p>Total TTC: <?php echo $total ?>€</p><br/>
								
								<!--<p>Calcul des frais de port : < ?php echo $shipping ?>€</p>-->

							</td>
						</tr>

						<tr>
							<td colspan="4"><br/>
								<input type="submit" value="recalculer"/>
								<input type="hidden" name="action" value="refresh"/>
								<a href="?deletePanier=true">Supprimer le panier</a><br/>
								<?php if(isset($_SESSION['id_client'])){?><a href="<?php echo $paypal ?>">Payer la commande</a>
								<?php }else{?><h4 style="color:red;">Vous devez vous identifier pour valider votre commande. <a href="connect.php">Se connecter</a></h4><?php }?>
							</td>
						</tr>

						<?php

				}
			}

			?>
			</tbody>
		</table>

	</form>


<?php
require_once ('include/footer.php');

?>
