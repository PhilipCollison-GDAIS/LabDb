<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";

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

		$string .= 'Not Yet Implemented';

		$string .= '</table>';

		return $string;
	}

	public function getAddButton(){
		return '<a href="/forms/equipment.php">Add Equipment</a>';
	}
}

$report = new EquipmentReport();

include "/inc/reports.php";
?>