<?php
session_start();

ini_set('display_errors',1);
error_reporting (E_ALL & ~E_NOTICE);

$pdo = new PDO ('mysql:host=localhost;dbname=lab_database_schema;charset=utf8', 'root', 'password');
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
Global $pdo;