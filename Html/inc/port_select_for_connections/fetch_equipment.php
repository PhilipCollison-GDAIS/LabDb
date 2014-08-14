<?php
require_once "/inc/connect.php";

if (isset($_POST['rack_id'])) {
	$query = 'SELECT equipment.id AS id, elevation, serial_num
				FROM equipment, affiliations
				WHERE affiliations.id = equipment.id
					AND affiliations.parent_rack_id = :id
				ORDER BY elevation DESC';

	$q = $pdo->prepare($query);
	$q->bindParam(':id', $_POST['rack_id'], PDO::PARAM_INT);
	$q->execute();

	$string = '<option></option>';
	while ($row = $q->fetchObject()) {
		$string .= '<option value="' . htmlspecialchars($row->id) . '">' . htmlspecialchars($row->serial_num) . '</option>';
	}
	echo $string;
}