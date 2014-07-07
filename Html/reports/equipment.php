<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";
include "/inc/database.php";

// function queryEquipmentForVendor ($equipment_object) {
// 	global $pdo;

// 	$query_vendors = "SELECT * FROM vendors WHERE id=$equipment_object->vendor_id";

// 	$equipment_object = $pdo->query($query_vendors);
// 	$vendor_row = $equipment_object->fetchObject();

// 	return $vendor_row->vendor;
// }

// TODO: rewrite
// function queryEquipmentForLocation ($equipment_object) {
	// global $pdo;

	// $query_affiliation = "$equipment_object->affiliated";
	// $affiliation = $pdo->query($query_affiliation);

	// if($equipment_object->affiliated == 'E'){
	// 	$query_parent_equipment = "SELECT * FROM equipment WHERE id=$equipment_object->parent_equipment_id";

	// 	$parent_equipment_resource = $pdo->query($query_parent_equipment);
	// 	$parent_equipment_object = $parent_equipment_resource->fetchObject();

	// 	return get_equipment_location($parent_equipment_object);
	// }

	// $query_racks = "SELECT * FROM racks WHERE id=$equipment_object->parent_rack_id";

	// $rack_resource = $pdo->query($query_racks);
	// $rack_row = $rack_resource->fetchObject();

	// $room_query = "SELECT floor_location FROM rooms WHERE id=$rack_row->room_id";

	// $room_resource = $pdo->query($room_query);
	// $room_row = $room_resource->fetchObject();

	// return $room_row->floor_location;

// 	return "";
// }

// function tableStringForEquipments(){
// 	global $pdo;

// 	$string = '<table class="table">';

// 	$string .= '<tr>';
// 	$string .= '<th>Model</th>';
// 	$string .= '<th>Location</th>';
// 	$string .= '<th>Vendor</th>';
// 	$string .= '</tr>';

// 	$query = "SELECT * FROM equipment";

// 	$row_resource = $pdo->query($query);

// 	while ($row = $row_resource->fetchObject()) {
// 		$string .= '<tr>';
// 		$string .= '<td>' . $row->model . '</td>';
// 		$string .= '<td>' . queryEquipmentForLocation($row) . '</td>';
// 		$string .= '<td>' . queryEquipmentForVendor($row) . '</td>';
// 		$string .= '<td><a href="#">Edit</a></td>';
// 		$string .= '</tr>';
// 	}

// 	$string .= '</table>';

// 	return $string;
// }

class EquipmentReport implements reportsInterface{
	public function getTitle(){
		return 'Equipment';
	}

	public function getHeading(){
		return 'Equipment';
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
		$string .= '<th>Comments</th>';
		$string .= '</tr>';

		$query = 'SELECT equipment.id, barcode_number, vendor, model, serial_num, GFE_id, equipment.comment
					FROM equipment, vendors
					WHERE equipment.vendor_id = vendors.id
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
			$string .= '<td>' . $row->comment . '</td>';
			$string .= '<td><a href="/forms/equipment.php?edit_id=' . $row->id . '">Edit</a></td>';
			$string .= '<td><a href="/forms/equipment.php?copy_id=' . $row->id . '">Copy</a></td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		return $string;
	}

	public function getAddButton(){
		return '<a href="/forms/equipment.php">Add Equipment</a>';
	}

	public function getIdString($id){
		if(!isset($id)){
			return '<br>';
		}

		$string = '';

		$string .= '<div id="portModal" class="modalDialog">';
		$string .= '	<div>';
		$string .= '		<a href="#close" title="Close" class="close">X</a>';
		$string .= '		<h2>Add a Port</h2>';
		ob_start();
		include "/inc/forms/ports/port_base.php";
		$string .= ob_get_clean();
		$string .= '	</div>';
		$string .= '</div>';

		global $pdo;

		$query = 'SELECT barcode_number, vendor, model, serial_num, GFE_id, equipment.comment
					FROM equipment, vendors
					WHERE equipment.vendor_id = vendors.id AND equipment.id = :id';

		$q = $pdo->prepare($query);
		$q->bindParam(':id', $id, PDO::PARAM_INT);
		$q->execute();

		$row = $q->fetchObject();

		$string .= '<table class="table" style="width: 450px; font-size: 16px;">';
		$string .= '<tr><td><strong>Barcode Number: </strong></td><td>' . $row->barcode_number . '</td></tr>';
		$string .= '<tr><td><strong>Vendor: </strong></td><td>' . $row->vendor . '</td></tr>';
		$string .= '<tr><td><strong>Model: </strong></td><td>' . $row->model . '</td></tr>';
		$string .= '<tr><td><strong>Serial Number: </strong></td><td>' . $row->serial_num . '</td></tr>';
		$string .= '<tr><td><strong>GFE ID: </strong></td><td>' . $row->GFE_id . '</td></tr>';
		$string .= '<tr><td><strong>Comment: </strong></td><td>' . $row->comment . '</td></tr>';
		$string .= '</table>';

		$string .= '<br>';

		$string .= '<table class="table">';
		$string .= '<tr>';
		$string .= '<th>Connector Type</th>';
		$string .= '<th>Name</th>';
		$string .= '<th>Port Number</th>';
		$string .= '<th>Gender</th>';
		$string .= '<th>Type</th>';
		$string .= '<th><a href="#portModal">Add Port</a></th>';
		$string .= '</tr>';

		$query = 'SELECT ports.name AS connector_type, port_number, type, connector_gender, connector_types.name
					FROM ports, connector_types
					WHERE ports.connector_type_id = connector_types.id AND equipment_id = :id
					ORDER BY connector_types.name, ports.name, port_number';

		$q = $pdo->prepare($query);
		$q->bindParam(':id', $id, PDO::PARAM_INT);
		$q->execute();

		while ($row = $q->fetchObject()) {
			$string .= '<tr>';
			$string .= '<td>' . $row->connector_type . '</td>';
			$string .= '<td>' . $row->name . '</td>';
			$string .= '<td>' . $row->port_number . '</td>';
			$string .= '<td>' . $row->connector_gender . '</td>';
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