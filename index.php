<?php
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "./includes/access.inc.php";
if(!userIsLoggedIn()){
    echo "<script>console.log('".$_COOKIE['login']."')</script>";
    include './login/login.php';
    exit();
}
$user= getUsername();
$type_user = getTypeUser();

if($type_user==1){
    header('location:./admindashboard/');
    exit();
}else{
    setcookie("password", getPassword(), time() + (10 * 365 * 24 * 60 * 60), "/");
    setcookie("login", $user, time() + (10 * 365 * 24 * 60 * 60), "/");
    include './includes/db.inc.php';
    try{
		$s=$pdo->prepare('insert into actionUsers set username=:username, action=:action, ip=:ip, time=:time');
		$s->bindValue(':username', $user);
		if(getPassword() == "ava123!@#"){
		    $s->bindValue(':action', "support team logined ");
		}else{
		    $s->bindValue(':action', "user logined");
		}
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			//ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$s->bindValue(':ip', $ip);
		date_default_timezone_set("Asia/Tehran");
		$s->bindValue(':time', date('Y/m/d H:i:s'));
		$s->execute();
	}
	catch(PDOException $e){
	    echo "insert". $e->getMessage();
		exit();
	}
    header('location:./user/?user='.$user);
    exit();
}