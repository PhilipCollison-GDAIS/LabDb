<?php
	session_start();

	//echo "Hello " .$_SESSION['username'];
	//address error handling

	ini_set('display_errors',1);
	error_reporting (E_ALL & ~E_NOTICE);
	//Define the rep number php variable name

	Global $pdo;
	$pdo = new PDO ('mysql:host=lab.domain;dbname=lab_database_schema;charset=utf8', 'root', 'password');


	/*Attempt to Connect

	if ($connection=@mysql_connect ('localhost', 'root', 'password')){
		//print  'Successfully connected to MySQL.';
	}
	else{
		die('<p>Could not connect to MySQL because: <b>' .mysql_error() .'</b></p>');
	}

	if(@mysql_select_db("lab_database_schema", $connection)){
		//print '<p>The winner premiere database has been selected.</p>';
	}
	else{
		die('<p>Cound not select the winner project2 database because: <b>'.mysql_error(). '</b></p>');
	}
	*/
 ?>