<?php
require_once "/inc/connect.php";

function isValidToDeletePort($id) {
	global $pdo;

	return true;
}

function deletePort($id) {
	global $pdo;

	$query = 'DELETE FROM ports WHERE id = :id';
	$stmt = $pdo->prepare($query);
	$stmt->bindParam(':id', $id);
	$stmt->execute();
}

if(isset($_POST['ports-table-for-equipment-delete']) ||
		/* TODO: isset($_POST['ports-table-for-optical-cassette-delete']) || */
		isset($_POST['optical_cassette-table-for-racks-delete'])){
	foreach (array_values($_POST)[0] as $id) {
		if(isValidToDeletePort($id) === true) {
			deletePort($id);
		}
	}
	exit;
}
