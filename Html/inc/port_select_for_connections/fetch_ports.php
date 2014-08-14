<?php
require_once "/inc/connect.php";

if (isset($_POST['equipment_id'])) {
	$string = '';
	$string .= '<thead style="display: block;">';
	$string .= '<tr>';
	$string .= '<th style="width: 25%;">Type</th>';
	$string .= '<th style="width: 25%;">Name</th>';
	$string .= '<th style="width: 25%;">Gender</th>';
	$string .= '<th style="width: 25%;">Type</th>';
	$string .= '</tr>';
	$string .= '</thead>';

	$query = 'SELECT connector_type, ports.name, ports.id AS id, connector_gender, connector_types.affiliated AS type
				FROM ports, connector_types
				WHERE ports.connector_type_id = connector_types.id AND equipment_id = :id
				ORDER BY connector_types.connector_type, ports.name';

	$q = $pdo->prepare($query);
	$q->bindParam(':id', $_POST['equipment_id'], PDO::PARAM_INT);
	$q->execute();

	$string .= '<tbody style="height: 250px; overflow-y: auto; overflow-x: hidden; display: block;">';
	$rowsAdded = 0;
	while ($row = $q->fetchObject()) {
		/* TODO: only send ports not already in connection*/
		if (true) {
			$string .= '<tr value="' . htmlspecialchars($row->id) . '">';
			$string .= '<td style="width: 25%;">' . htmlspecialchars($row->connector_type) . '</td>';
			$string .= '<td style="width: 25%;">' . htmlspecialchars($row->name) . '</td>';
			$string .= '<td style="width: 25%;">';
			$string .= $row->connector_gender === "F" ? 'Female' : 'Male';
			$string .= '</td>';
			$string .= '<td style="width: 25%;">';
			$string .= $row->type === "E" ? 'Electrical' : 'Optical';
			$string .= '</td>';
			$string .= '</tr>';

			$rowsAdded = $rowsAdded + 1;
		}
	}		
	if ($rowsAdded === 0) {
		$string .= '<tr class="no-data"><td>No Data</td><td></td><td></td><td></td></tr>';
	}
	$string .= '</tbody>';

	echo $string;
}