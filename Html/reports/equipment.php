<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";
include "/inc/database.php";

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

		$string = '<table class="table">';

		$string .= '<tr>';
		$string .= '<th>Barcode</th>';
		$string .= '<th>Vendor</th>';
		$string .= '<th>Model</th>';
		$string .= '<th>Serial Number</th>';
		$string .= '<th>GFE ID</th>';
		$string .= '<th>Location</th>';
		$string .= '<th>Rack</th>';
		$string .= '<th>Comments</th>';
		$string .= '<th><a href="/forms/equipment.php">Add Equipment</a></th>';
		$string .= '</tr>';

		$query = 'SELECT equipment.id, barcode_number, vendor, model, serial_num, GFE_id, building_name, room_number, racks.name AS rack_name, racks.id AS rack_id, equipment.comment
					FROM equipment, vendors, racks, rooms, affiliations
					WHERE equipment.vendor_id = vendors.id
						AND equipment.id = affiliations.id
						AND affiliations.parent_rack_id = racks.id
						AND racks.room_id = rooms.id
					ORDER BY barcode_number, model';
					// TODO: How is is that the ORDER BY clauses should be ordered?

		$row_resource = $pdo->query($query);

		while ($row = $row_resource->fetchObject()) {
			$string .= '<tr>';
			$string .= '<td><a href="/reports/equipment.php?id=' . $row->id . '">' . $row->barcode_number . '</a></td>';
			$string .= '<td>' . $row->vendor . '</td>';
			$string .= '<td>' . $row->model . '</td>';
			$string .= '<td>' . $row->serial_num . '</td>';
			$string .= '<td>' . $row->GFE_id . '</td>';
			$string .= '<td>' . $row->room_number . " " .  $row->building_name . '</td>';
			$string .= '<td><a href="/reports/racks.php?id=' . $row->rack_id . '">' . $row->rack_name . '</a></td>';
			$string .= '<td>' . $row->comment . '</td>';
			$string .= '<td><a href="/forms/equipment.php?edit_id=' . $row->id . '">Edit</a>&nbsp;&nbsp;&nbsp;<a href="/forms/equipment.php?copy_id=' . $row->id . '">Copy</a></td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		return $string;
	}

	public function getIdString($id){
		if(!isset($id)){
			return '<br>';
		}

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
		$string .= '<tr><td><strong>Barcode Number: </strong></td><td>' . $row->barcode_number . '</td></tr>';
		$string .= '<tr><td><strong>Vendor: </strong></td><td>' . $row->vendor . '</td></tr>';
		$string .= '<tr><td><strong>Model: </strong></td><td>' . $row->model . '</td></tr>';
		$string .= '<tr><td><strong>Serial Number: </strong></td><td>' . $row->serial_num . '</td></tr>';
		$string .= '<tr><td><strong>GFE ID: </strong></td><td>' . $row->GFE_id . '</td></tr>';
		$string .= '<tr><td><strong>Location</strong></td><td>' . $row->room_number . " " .  $row->building_name . '</td></tr>';
		$string .= '<tr><td><strong>Rack</strong></td><td><a href="/reports/racks.php?id=' . $row->rack_id . '">' . $row->rack_name . '</a></td></tr>';
		$string .= '<tr><td><strong>Comment: </strong></td><td>' . $row->comment . '</td></tr>';
		$string .= '</table>';

		$string .= '<br>';

		$string .= '<h2>Ports</h2>';

		$string .= '<table class="table">';
		$string .= '<tr>';
		$string .= '<th>Connector Type</th>';
		$string .= '<th>Name</th>';
		$string .= '<th>Connection</th>';
		$string .= '<th>Gender</th>';
		$string .= '<th>Type</th>';
		$string .= '<th>';
		ob_start();
		include "/inc/modal_buttons/port_button.php";
		$string .= ob_get_clean();
		$string .= '</th>';
		$string .= '</tr>';

		$query = 'SELECT connector_type, ports.name, ports.id, connector_gender, connector_types.affiliated AS type
					FROM ports, connector_types
					WHERE ports.connector_type_id = connector_types.id AND equipment_id = :id
					ORDER BY connector_types.connector_type, ports.name';

		$q = $pdo->prepare($query);
		$q->bindParam(':id', $id, PDO::PARAM_INT);
		$q->execute();

		while ($row = $q->fetchObject()) {
			$string .= '<tr>';
			$string .= '<td>' . $row->connector_type . '</td>';
			$string .= '<td>' . $row->name . '</td>';
			$string .= '<td>' . 'conditional link' . '</td>';
			$string .= '<td>';
			$string .= $row->connector_gender === "F" ? 'Female' : 'Male';
			$string .= '</td>';
			$string .= '<td>';
			$string .= $row->type === "E" ? 'Electrical' : 'Optical';
			$string .= '</td>';
			$string .= '<td><a href="/forms/ports.php?edit_id=' . $row->id . '">Edit</a>&nbsp;&nbsp;&nbsp;<a href="/forms/ports.php?copy_id=' . $row->id . '">Copy</a></td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		return $string;
	}
}

$report = new EquipmentReport();

include "/inc/reports.php";
?>