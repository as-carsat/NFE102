<?php
	
session_start();

require_once ('include/functionsPanier.php');
require_once ('include/paypal.php');
include 'include/connection.php';



	$totalTva = montantTotalTVA();
	$paypal = new Paypal();
	
	
	$response = $paypal -> request('GetExpressCheckoutDetails', array(
			'TOKEN'=> $_GET['token']
	));
	
	if($response){
		
		if($response['CHECKOUTSTATUS'] == 'PaymentActionCompleted'){
			
			
			header('Location: error.php');
		}

	// ????????????????????????????????????????
	//????????????????????????????????????????
	$response= $paypal -> request('DoExpressCheckoutPayment', array(
			'TOKEN'=> $_GET['token'],
			'PAYERID' => $_GET['PayerID'],
			'PAYMENTACTION' => 'Sale',
			'PAYMENTREQUEST_0_AMT' => $totalTva,
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR'
	));
	
	if($response){

		$response2 = $paypal -> request('GetTransactionDetails', array(
				'TRANSACTIONID'=> $response['PAYMENTREQUEST_0_TRANSACTIONID']
		));
		
		
		$products = '';
		
		for($i = 0; $i<count($_SESSION['panier']['libelleProduit']); $i++){
			
			$products.=$_SESSION['panier']['libelleProduit'][$i];
			if(count($_SESSION['panier']['libelleProduit'])>1){
				$products.=' , ';
			}
		}
		
		
		$name = $response2['SHIPTONAME'];
		$street = $response2['SHIPTOSTREET'];
		$city = $response2['SHIPTOCITY'];
		$country = $response2['SHIPTOSTATE'];
		$date = $response2['ORDERTIME'];
		$transaction_id = $response2['TRANSACTIONID'];
		$amt = $response2['AMT'];
		$shipping = $response2['FEEAMT'];
		$currency_code = $response2['CURRENCYCODE'];
		$user_id = $_SESSION['user_id'];
		
		
	$db->query("INSERT INTO transactions VALUES('','$name', '$street', '$city', '$country', '$date', '$transaction_id', '$amt', '$shipping', '$products', '$currency_code', '$user_id')");
		
		
		header('Location: success.php');
	
	}else{

		var_dump($paypal->errors);
		die();
	}
	
	}else{
	
		var_dump($paypal->errors);
		die();
	}
	
	?>