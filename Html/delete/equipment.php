<?php
require_once "/inc/connect.php";

function subEquipmentIds($id) {
	global $pdo;

	$isValid = true;

	$query = 'SELECT id FROM affiliations WHERE affiliations.parent_equipment_id = :id';
	$stmt = $pdo->prepare($query);
	$stmt->bindParam(':id', $id);
	$stmt->execute();

	$data = array();

	while ($row = $stmt->fetchObject()) {
		$data[] = $row->id; // add to array
	}

	return $data; //return array
}

function isValidToDeleteEquipment($id) {
	global $pdo;

	// $isValid = true;

	// $query = 'SELECT COUNT(*) AS count
	// 		  FROM ports, connections
	// 		  WHERE ports.equipment_id = :id
	// 			  AND (ports.id = connections.port_id_1 OR ports.id = connections.port_id_2)';
	// $stmt = $pdo->prepare($query);
	// $stmt->bindParam(':id', $id);
	// $stmt->execute();

	// if ($stmt->fetchObject()->count !== "0") {
	// 	return false;
	// }

	// foreach (subEquipmentIds($id) as $sub_id) {
	// 	if (!isValidToDeleteEquipment($sub_id)) {
	// 		return false;
	// 	}
	// }

	return true;
}

function deleteEquipment($id) {
	global $pdo;

	$query = 'DELETE FROM ports WHERE equipment_id = :id';
	$stmt = $pdo->prepare($query);
	$stmt->bindParam(':id', $id);
	$stmt->execute();

	foreach (subEquipmentIds($id) as $sub_id) {
		deleteEquipment($sub_id);
	}

	$query = 'DELETE FROM equipment WHERE id = :id';
	$stmt = $pdo->prepare($query);
	$stmt->bindParam(':id', $id);
	$stmt->execute();
}

if(isset($_POST['main-table-for-equipment-delete']) || isset($_POST['equipment-table-for-racks-delete'])){
	foreach (array_values($_POST)[0] as $id) {
		if(isValidToDeleteEquipment($id) === true) {
			deleteEquipment($id);
		}
	}
	exit;
}
