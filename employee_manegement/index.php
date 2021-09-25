<?php session_start(); /* Starts the session */
$_SESSION['UserData']['manager'];
	if($_SESSION['UserData']['manager'] == 1){
		header("Location:manager.php");
		exit;
	}elseif($_SESSION['UserData']['manager']!= ''){
		header("Location:employee.php");
		exit;
	}else{
		header("Location:login.php");
		exit;
	}
?>

