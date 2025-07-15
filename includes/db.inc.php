<?php
try{
$pdo=new PDO('mysql:host=localhost;dbname=avahivai_dashboard','avahivai','9q7K8Wvpp0');
$pdo->setAttribute(PDO::ATTR_ERRMODE, 
PDO::ERRMODE_EXCEPTION);
$pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e){
	exit();
}