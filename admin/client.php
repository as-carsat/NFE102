<?php
header ('Content-Type: application/json');

try{
	$pdo = new PDO('mysql:host=localhost;dbname=e-commerce; ', 'root','');
	$retour["success"]=true;
	$retour["message"]="Connexion à la base de données réussie";
	
}catch(Exception $e){
	
	$retour["success"]=false;
	$retour["message"]="Connexion à la base de données impossible";
	
}

$requete = $pdo->prepare("SELECT email FROM users");
$requete->execute();

$retour["success"]=true;
$retour["message"]="Voici les adresse emails de vos clients : ";

$resultats = $requete->fetchAll();

$retour["results"]["nb"] = count($resultats);
$retour["results"]["email"] = $resultats;



echo json_encode($retour);
