<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";
include "/inc/database.php";
require_once "/delete/equipment.php";
require_once "/delete/ports.php";

class EquipmentReport implements reportsInterface{
	public function redirect(){
		global $pdo;

		if(isset($_GET['id'])){
			// If the equipment that is being searched for does not exist, redirect the user
			$query = 'SELECT EXISTS(SELECT 1 FROM equipment WHERE id = :id) AS redirect';

			$q = $pdo->prepare($query);
			$q->bindParam(':id', $_GET['id'] , PDO::PARAM_INT);
			$q->execute();

			if($q->fetchObject()->redirect === "0"){
				header('Location: ' . $_SERVER['PHP_SELF']);
				exit;
			}
		}
	}

	public function getTitle(){
		return 'Equipment';
	}

	public function getHeading(){
		if(empty($_GET)){
			return 'Equipment';
		} else {
			return '<a href="/reports/equipment.php">Equipment</a>';
		}
	}

	public function getTableString(){
		global $pdo;

		$string = '<div class="table-n-buttons" name="main-table-for-equipment">';

		$string .= '<table class="table data-table">';

		$string .= '<thead>';
		$string .= '<tr>';
		$string .= '<th>Serial Number</th>';
		$string .= '<th>Rack</th>';
		$string .= '<th>Location</th>';
		$string .= '<th>Conn : Ports</th>';
		$string .= '<th>Vendor</th>';
		$string .= '<th>Model</th>';
		$string .= '<th>Barcode</th>';
		$string .= '<th>GFE ID</th>';
		$string .= '<th>Comments</th>';
		$string .= '</tr>';
		$string .= '</thead>';

		$query = 'SELECT equipment.id AS unique_equipment_id_name, barcode_number, vendor, model, serial_num, GFE_id, building_name, room_number, racks.name AS rack_name, racks.id AS rack_id, equipment.comment,
						(SELECT COUNT(*) FROM ports WHERE ports.equipment_id = unique_equipment_id_name) AS port_count,
						(SELECT COUNT(*) FROM connections, ports WHERE (connections.port_id_1 = ports.id OR connections.port_id_2 = ports.id) AND ports.equipment_id = unique_equipment_id_name ) AS conn_count
					FROM equipment, vendors, racks, rooms, affiliations
					WHERE equipment.vendor_id = vendors.id
						AND equipment.id = affiliations.id
						AND affiliations.parent_rack_id = racks.id
						AND racks.room_id = rooms.id
					ORDER BY rooms.id, racks.id, serial_num';
					// TODO: How is is that the ORDER BY clauses should be ordered?

		$row_resource = $pdo->query($query);

		while ($row = $row_resource->fetchObject()) {
			$string .= '<tr value="' .  htmlspecialchars($row->unique_equipment_id_name) . '">';
			$string .= '<td><a href="/reports/equipment.php?id=' .  htmlspecialchars($row->unique_equipment_id_name) . '">' . $row->serial_num . '</a></td>';
			$string .= '<td><a href="/reports/racks.php?id=' .  htmlspecialchars($row->rack_id) . '">' .  htmlspecialchars($row->rack_name) . '</a></td>';
			$string .= '<td>' .  htmlspecialchars($row->room_number) . " " .   htmlspecialchars($row->building_name) . '</td>';
			$string .= '<td>' .  htmlspecialchars($row->conn_count) . " : " .  htmlspecialchars($row->port_count) . '</td>';
			$string .= '<td>' .  htmlspecialchars($row->vendor) . '</td>';
			$string .= '<td>' .  htmlspecialchars($row->model) . '</td>';
			$string .= '<td>' .  htmlspecialchars($row->barcode_number) . '</td>';
			$string .= '<td>' .  htmlspecialchars($row->GFE_id) . '</td>';
			$string .= '<td>' .  htmlspecialchars($row->comment) . '</td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		$string .= '<br>';

		$string .= '<a href="/forms/equipment.php"><button type="button" class="btn btn-default btn-lg">Add</button></a>';
		$string .= '<a onclick="addURL(this)" href="/forms/equipment.php?edit_id="><button type="button" class="oneSelected btn btn-default btn-lg" disabled>Edit</button></a>';
		$string .= '<a onclick="addURL(this)" href="/forms/equipment.php?copy_id="><button type="button" class="oneSelected btn btn-default btn-lg" disabled>Copy</button></a>';
		$string .= '<button type="button" class="notNoneSelected btn btn-default btn-lg delete-button" disabled>Delete</button>';

		$string .= '</div>';

		return $string;
	}

	public function getIdString($id){
		global $pdo;

		$query = 'SELECT barcode_number, vendor, model, serial_num, GFE_id, building_name, room_number, racks.name AS rack_name, racks.id AS rack_id, equipment.comment
					FROM equipment, vendors, racks, rooms, affiliations
					WHERE equipment.vendor_id = vendors.id
						AND equipment.id = affiliations.id
						AND affiliations.parent_rack_id = racks.id
						AND racks.room_id = rooms.id
						AND equipment.id = :id';

		$q = $pdo->prepare($query);
		$q->bindParam(':id', $id, PDO::PARAM_INT);
		$q->execute();

		$row = $q->fetchObject();

		$string = '<table class="table" style="width: 400px; font-size: 16px;">';
		$string .= '<tr><td><strong>Barcode Number: </strong></td><td>' .  htmlspecialchars($row->barcode_number) . '</td></tr>';
		$string .= '<tr><td><strong>Vendor: </strong></td><td>' .  htmlspecialchars($row->vendor) . '</td></tr>';
		$string .= '<tr><td><strong>Model: </strong></td><td>' .  htmlspecialchars($row->model) . '</td></tr>';
		$string .= '<tr><td><strong>Serial Number: </strong></td><td>' .  htmlspecialchars($row->serial_num) . '</td></tr>';
		$string .= '<tr><td><strong>GFE ID: </strong></td><td>' .  htmlspecialchars($row->GFE_id) . '</td></tr>';
		$string .= '<tr><td><strong>Location</strong></td><td>' .  htmlspecialchars($row->room_number) . " " .   htmlspecialchars($row->building_name) . '</td></tr>';
		$string .= '<tr><td><strong>Rack</strong></td><td><a href="/reports/racks.php?id=' .  htmlspecialchars($row->rack_id) . '">' .  htmlspecialchars($row->rack_name) . '</a></td></tr>';
		$string .= '<tr><td><strong>Comment: </strong></td><td>' .  htmlspecialchars($row->comment) . '</td></tr>';
		$string .= '</table>';

		$string .= '<br>';

		$string .= '<div class="table-n-buttons" name="ports-table-for-equipment">';

		$string .= '<h2>Ports</h2>';

		$string .= '<table class="table data-table">';
		$string .= '<thead>';
		$string .= '<tr>';
		$string .= '<th>Connector Type</th>';
		$string .= '<th>Name</th>';
		$string .= '<th>Connection</th>';
		$string .= '<th>Gender</th>';
		$string .= '<th>Type</th>';
		$string .= '</tr>';
		$string .= '</thead>';

		$query = 'SELECT connector_type, ports.name, ports.id AS id, connector_gender, connector_types.affiliated AS type
					FROM ports, connector_types
					WHERE ports.connector_type_id = connector_types.id AND equipment_id = :id
					ORDER BY connector_types.connector_type, ports.name';

		$q = $pdo->prepare($query);
		$q->bindParam(':id', $id, PDO::PARAM_INT);
		$q->execute();

		while ($row = $q->fetchObject()) {
			$string .= '<tr value="' .  htmlspecialchars($row->id) . '">';
			$string .= '<td>' .  htmlspecialchars($row->connector_type) . '</td>';
			$string .= '<td>' .  htmlspecialchars($row->name) . '</td>';
			$string .= '<td>' . 'conditional link' . '</td>';
			$string .= '<td>';
			$string .= $row->connector_gender === "F" ? 'Female' : 'Male';
			$string .= '</td>';
			$string .= '<td>';
			$string .= $row->type === "E" ? 'Electrical' : 'Optical';
			$string .= '</td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		$string .= '<br>';

		ob_start();
		include "/inc/modal_buttons/port_button_for_equipment.php";
		$string .= trim(ob_get_clean());
		$string .= '<a onclick="addURL(this)" href="/forms/ports.php?edit_id="><button type="button" class="oneSelected btn btn-default btn-lg" disabled>Edit</button></a>';
		$string .= '<a onclick="addURL(this)" href="/forms/ports.php?copy_id="><button type="button" class="oneSelected btn btn-default btn-lg" disabled>Copy</button></a>';
		$string .= '<button type="button" class="notNoneSelected btn btn-default btn-lg delete-button" disabled>Delete</button>';

		$string .= '</div>';

		return $string;
	}
}

$report = new EquipmentReport();

include "/inc/reports.php";
?>