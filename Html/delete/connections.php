<?php
require_once "/inc/connect.php";

function isValidToDeleteConnection($id) {
	global $pdo;

	return true;
}

function deleteConnection($id) {
	global $pdo;

	$query = 'DELETE FROM connections WHERE id = :id';
	$stmt = $pdo->prepare($query);
	$stmt->bindParam(':id', $id);
	$stmt->execute();
}

if(isset($_POST['main-table-for-connections-delete'])){
	foreach (array_values($_POST)[0] as $id) {
		if(isValidToDeleteConnection($id) === true) {
			deleteConnection($id);
		}
	}
	exit;
}
